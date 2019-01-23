<?php

namespace Drupal\bioleft_labor\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\bioleft_labor\Entity\LaborInterface;

/**
 * Class LaborController.
 *
 *  Returns responses for Labor routes.
 */
class LaborController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Labor  revision.
   *
   * @param int $labor_revision
   *   The Labor  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($labor_revision) {
    $labor = $this->entityManager()->getStorage('labor')->loadRevision($labor_revision);
    $view_builder = $this->entityManager()->getViewBuilder('labor');

    return $view_builder->view($labor);
  }

  /**
   * Page title callback for a Labor revision.
   *
   * @param int $labor_revision
   *   The Labor  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($labor_revision) {
    $labor = $this->entityManager()->getStorage('labor')->loadRevision($labor_revision);
    return $this->t('Revision of %title from %date', [
      '%title' => $labor_revision->label(),
      '%date' => $this->dateFormatter->format($labor->getRevisionCreationTime()),
    ]);
  }

  /**
   * Generates an overview table of older revisions of a Labor .
   *
   * @param \Drupal\bioleft_labor\Entity\LaborInterface $labor
   *   A Labor  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(LaborInterface $labor) {
    $account = $this->currentUser();
    $langcode = $labor->language()->getId();
    $langname = $labor->language()->getName();
    $languages = $labor->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $labor_storage = $this->entityManager()->getStorage('labor');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $labor->label()]) : $this->t('Revisions for %title', ['%title' => $labor->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all labor revisions") || $account->hasPermission('administer labor entities')));
    $delete_permission = (($account->hasPermission("delete all labor revisions") || $account->hasPermission('administer labor entities')));

    $rows = [];

    $vids = $labor_storage->revisionIds($labor);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\bioleft_labor\LaborInterface $revision */
      $revision = $labor_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = $this->dateFormatter->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $labor->getRevisionId()) {
          $link = $this->l($date, new Url('entity.labor.revision', ['labor' => $labor->id(), 'labor_revision' => $vid]));
        }
        else {
          $link = $labor->link($date);
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
              'url' => Url::fromRoute('entity.labor.revision_revert', ['labor' => $labor->id(), 'labor_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.labor.revision_delete', ['labor' => $labor->id(), 'labor_revision' => $vid]),
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

    $build['labor_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
