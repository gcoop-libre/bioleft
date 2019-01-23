<?php

namespace Drupal\bioleft_mis_cultivos;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\bioleft_mis_cultivos\Entity\MisCultivosInterface;

/**
 * Defines the storage handler class for Mis cultivos entities.
 *
 * This extends the base storage class, adding required special handling for
 * Mis cultivos entities.
 *
 * @ingroup bioleft_mis_cultivos
 */
class MisCultivosStorage extends SqlContentEntityStorage implements MisCultivosStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(MisCultivosInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {mis_cultivos_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {mis_cultivos_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(MisCultivosInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {mis_cultivos_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('mis_cultivos_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
