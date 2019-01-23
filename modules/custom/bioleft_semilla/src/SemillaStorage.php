<?php

namespace Drupal\bioleft_semilla;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\bioleft_semilla\Entity\SemillaInterface;

/**
 * Defines the storage handler class for Semilla entities.
 *
 * This extends the base storage class, adding required special handling for
 * Semilla entities.
 *
 * @ingroup bioleft_semilla
 */
class SemillaStorage extends SqlContentEntityStorage implements SemillaStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(SemillaInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {semilla_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {semilla_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(SemillaInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {semilla_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('semilla_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
