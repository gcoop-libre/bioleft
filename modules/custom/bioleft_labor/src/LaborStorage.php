<?php

namespace Drupal\bioleft_labor;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\bioleft_labor\Entity\LaborInterface;

/**
 * Defines the storage handler class for Labor entities.
 *
 * This extends the base storage class, adding required special handling for
 * Labor entities.
 *
 * @ingroup bioleft_labor
 */
class LaborStorage extends SqlContentEntityStorage implements LaborStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(LaborInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {labor_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {labor_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(LaborInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {labor_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('labor_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
