<?php

namespace Drupal\bioleft_transaccion;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\bioleft_transaccion\Entity\TransaccionInterface;

/**
 * Defines the storage handler class for Transacción entities.
 *
 * This extends the base storage class, adding required special handling for
 * Transacción entities.
 *
 * @ingroup bioleft_transaccion
 */
class TransaccionStorage extends SqlContentEntityStorage implements TransaccionStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(TransaccionInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {transaccion_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {transaccion_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(TransaccionInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {transaccion_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('transaccion_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
