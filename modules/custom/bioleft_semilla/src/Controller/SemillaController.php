<?php

namespace Drupal\bioleft_semilla\Controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Render\Renderer;
use Drupal\Core\Url;
use Drupal\bioleft_semilla\Entity\SemillaInterface;

/**
 * Class SemillaController.
 *
 *  Returns responses for Semilla routes.
 */
class SemillaController extends ControllerBase implements ContainerInjectionInterface {

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
   * Displays a Semilla  revision.
   *
   * @param int $semilla_revision
   *   The Semilla  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($semilla_revision) {
    $semilla = $this->entityManager()->getStorage('semilla')->loadRevision($semilla_revision);
    $view_builder = $this->entityManager()->getViewBuilder('semilla');

    return $view_builder->view($semilla);
  }

  /**
   * Page title callback for a Semilla  revision.
   *
   * @param int $semilla_revision
   *   The Semilla  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($semilla_revision) {
    $semilla = $this->entityManager()->getStorage('semilla')->loadRevision($semilla_revision);
    return $this->t('Revision of %title from %date', [
      '%title' => $semilla->label(),
      '%date' => $this->dateFormatter->format($semilla->getRevisionCreationTime()),
    ]);
  }

  /**
   * Generates an overview table of older revisions of a Semilla .
   *
   * @param \Drupal\bioleft_semilla\Entity\SemillaInterface $semilla
   *   A Semilla  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(SemillaInterface $semilla) {
    $account = $this->currentUser();
    $langcode = $semilla->language()->getId();
    $langname = $semilla->language()->getName();
    $languages = $semilla->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $semilla_storage = $this->entityManager()->getStorage('semilla');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $semilla->label()]) : $this->t('Revisions for %title', ['%title' => $semilla->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all semilla revisions") || $account->hasPermission('administer semilla entities')));
    $delete_permission = (($account->hasPermission("delete all semilla revisions") || $account->hasPermission('administer semilla entities')));

    $rows = [];

    $vids = $semilla_storage->revisionIds($semilla);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\bioleft_semilla\SemillaInterface $revision */
      $revision = $semilla_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = $this->dateFormatter->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $semilla->getRevisionId()) {
          $link = $this->l($date, new Url('entity.semilla.revision', ['semilla' => $semilla->id(), 'semilla_revision' => $vid]));
        }
        else {
          $link = $semilla->link($date);
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
              'url' => Url::fromRoute('entity.semilla.revision_revert', ['semilla' => $semilla->id(), 'semilla_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.semilla.revision_delete', ['semilla' => $semilla->id(), 'semilla_revision' => $vid]),
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

    $build['semilla_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
