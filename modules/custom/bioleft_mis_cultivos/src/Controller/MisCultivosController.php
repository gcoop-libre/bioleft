<?php

namespace Drupal\bioleft_mis_cultivos\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\bioleft_mis_cultivos\Entity\MisCultivosInterface;

/**
 * Class MisCultivosController.
 *
 *  Returns responses for Mis cultivos routes.
 */
class MisCultivosController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Mis cultivos  revision.
   *
   * @param int $mis_cultivos_revision
   *   The Mis cultivos revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($mis_cultivos_revision) {
    $mis_cultivos = $this->entityManager()->getStorage('mis_cultivos')->loadRevision($mis_cultivos_revision);
    $view_builder = $this->entityManager()->getViewBuilder('mis_cultivos');

    return $view_builder->view($mis_cultivos);
  }

  /**
   * Page title callback for a Mis cultivos  revision.
   *
   * @param int $mis_cultivos_revision
   *   The Mis cultivos  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($mis_cultivos_revision) {
    $mis_cultivos = $this->entityManager()->getStorage('mis_cultivos')->loadRevision($mis_cultivos_revision);
    return $this->t('Revision of %title from %date', [
      '%title' => $mis_cultivos_revision->label(),
      '%date' => $this->dateFormatter->format($mis_cultivos->getRevisionCreationTime()),
    ]);
  }

  /**
   * Generates an overview table of older revisions of a Mis cultivos .
   *
   * @param \Drupal\bioleft_mis_cultivos\Entity\MisCultivosInterface $mis_cultivos
   *   A Mis cultivos  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(MisCultivosInterface $mis_cultivos) {
    $account = $this->currentUser();
    $langcode = $mis_cultivos->language()->getId();
    $langname = $mis_cultivos->language()->getName();
    $languages = $mis_cultivos->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $mis_cultivos_storage = $this->entityManager()->getStorage('mis_cultivos');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $mis_cultivos->label()]) : $this->t('Revisions for %title', ['%title' => $mis_cultivos->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];
    $revert_permission = (($account->hasPermission("revert all mis cultivos revisions") || $account->hasPermission('administer mis cultivos entities')));
    $delete_permission = (($account->hasPermission("delete all mis cultivos revisions") || $account->hasPermission('administer mis cultivos entities')));
    $rows = [];
    $vids = $mis_cultivos_storage->revisionIds($mis_cultivos);
    $latest_revision = TRUE;
    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\bioleft_mis_cultivos\MisCultivosInterface $revision */
      $revision = $mis_cultivos_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = $this->dateFormatter->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $mis_cultivos->getRevisionId()) {
          $link = $this->l($date, new Url('entity.mis_cultivos.revision', ['mis_cultivos' => $mis_cultivos->id(), 'mis_cultivos_revision' => $vid]));
        }
        else {
          $link = $mis_cultivos->link($date);
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
              'url' => Url::fromRoute('entity.mis_cultivos.revision_revert', ['mis_cultivos' => $mis_cultivos->id(), 'mis_cultivos_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.mis_cultivos.revision_delete', ['mis_cultivos' => $mis_cultivos->id(), 'mis_cultivos_revision' => $vid]),
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

    $build['mis_cultivos_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
