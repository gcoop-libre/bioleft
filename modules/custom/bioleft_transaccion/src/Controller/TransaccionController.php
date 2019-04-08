<?php

namespace Drupal\bioleft_transaccion\Controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Render\Renderer;
use Drupal\Core\Url;
use Drupal\bioleft_transaccion\Entity\TransaccionInterface;

/**
 * Class TransaccionController.
 *
 *  Returns responses for Transacción routes.
 */
class TransaccionController extends ControllerBase implements ContainerInjectionInterface {

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
   * Displays a Transacción  revision.
   *
   * @param int $transaccion_revision
   *   The Transacción  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($transaccion_revision) {
    $transaccion = $this->entityManager()->getStorage('transaccion')->loadRevision($transaccion_revision);
    $view_builder = $this->entityManager()->getViewBuilder('transaccion');

    return $view_builder->view($transaccion);
  }

  /**
   * Page title callback for a Transacción  revision.
   *
   * @param int $transaccion_revision
   *   The Transacción  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($transaccion_revision) {
    $transaccion = $this->entityManager()->getStorage('transaccion')->loadRevision($transaccion_revision);
    return $this->t('Revision of %title from %date', [
      '%title' => $transaccion->label(),
      '%date' => $this->dateFormatter->format($transaccion->getRevisionCreationTime()),
    ]);
  }

  /**
   * Generates an overview table of older revisions of a Transacción .
   *
   * @param \Drupal\bioleft_transaccion\Entity\TransaccionInterface $transaccion
   *   A Transacción  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(TransaccionInterface $transaccion) {
    $account = $this->currentUser();
    $langcode = $transaccion->language()->getId();
    $langname = $transaccion->language()->getName();
    $languages = $transaccion->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $transaccion_storage = $this->entityManager()->getStorage('transaccion');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $transaccion->label()]) : $this->t('Revisions for %title', ['%title' => $transaccion->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all transacción revisions") || $account->hasPermission('administer transacción entities')));
    $delete_permission = (($account->hasPermission("delete all transacción revisions") || $account->hasPermission('administer transacción entities')));

    $rows = [];

    $vids = $transaccion_storage->revisionIds($transaccion);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\bioleft_transaccion\TransaccionInterface $revision */
      $revision = $transaccion_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = $this->dateFormatter->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $transaccion->getRevisionId()) {
          $link = $this->l($date, new Url('entity.transaccion.revision', ['transaccion' => $transaccion->id(), 'transaccion_revision' => $vid]));
        }
        else {
          $link = $transaccion->link($date);
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
              'url' => Url::fromRoute('entity.transaccion.revision_revert', ['transaccion' => $transaccion->id(), 'transaccion_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.transaccion.revision_delete', ['transaccion' => $transaccion->id(), 'transaccion_revision' => $vid]),
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

    $build['transaccion_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
