<?php

namespace Drupal\bioleft_licencia\Controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Render\Renderer;
use Drupal\Core\Url;
use Drupal\bioleft_licencia\Entity\LicenciaInterface;

/**
 * Class LicenciaController.
 *
 *  Returns responses for Licencia routes.
 */
class LicenciaController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * The date formatter.
   *
   * @var \Drupal\Core\Datetime\DateFormatter
   */
  protected $dateFormatter;

  /**
   * The renderer.
   *
   * @var \Drupal\Core\Render\Renderer
   */
  protected $renderer;

  /**
   * Constructs a new CompanyController object.
   *
   * @param \Drupal\Core\Datetime\DateFormatter $date_formatter
   *   The date formatter.
   * @param \Drupal\Core\Render\Renderer $renderer
   *   The renderer.
   */
  public function __construct(DateFormatter $date_formatter, Renderer $renderer) {
    $this->dateFormatter = $date_formatter;
    $this->renderer = $renderer;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('date.formatter'),
      $container->get('renderer')
    );
  }

  /**
   * Displays a Licencia  revision.
   *
   * @param int $licencia_revision
   *   The Licencia  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($licencia_revision) {
    $licencia = $this->entityManager()->getStorage('licencia')->loadRevision($licencia_revision);
    $view_builder = $this->entityManager()->getViewBuilder('licencia');

    return $view_builder->view($licencia);
  }

  /**
   * Page title callback for a Licencia  revision.
   *
   * @param int $licencia_revision
   *   The Licencia  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($licencia_revision) {
    $licencia = $this->entityManager()->getStorage('licencia')->loadRevision($licencia_revision);
    return $this->t('Revision of %title from %date', [
      '%title' => $licencia->label(),
      '%date' => $this->dateFormatter->format($licencia->getRevisionCreationTime()),
    ]);
  }

  /**
   * Generates an overview table of older revisions of a Licencia .
   *
   * @param \Drupal\bioleft_licencia\Entity\LicenciaInterface $licencia
   *   A Licencia  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(LicenciaInterface $licencia) {
    $account = $this->currentUser();
    $langcode = $licencia->language()->getId();
    $langname = $licencia->language()->getName();
    $languages = $licencia->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $licencia_storage = $this->entityManager()->getStorage('licencia');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $licencia->label()]) : $this->t('Revisions for %title', ['%title' => $licencia->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all licencia revisions") || $account->hasPermission('administer licencia entities')));
    $delete_permission = (($account->hasPermission("delete all licencia revisions") || $account->hasPermission('administer licencia entities')));

    $rows = [];

    $vids = $licencia_storage->revisionIds($licencia);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\bioleft_licencia\LicenciaInterface $revision */
      $revision = $licencia_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = $this->dateFormatter->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $licencia->getRevisionId()) {
          $link = $this->l($date, new Url('entity.licencia.revision', ['licencia' => $licencia->id(), 'licencia_revision' => $vid]));
        }
        else {
          $link = $licencia->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => $this->renderer->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => Url::fromRoute('entity.licencia.revision_revert', ['licencia' => $licencia->id(), 'licencia_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.licencia.revision_delete', ['licencia' => $licencia->id(), 'licencia_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['licencia_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
