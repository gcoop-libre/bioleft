<?php

namespace Drupal\bioleft_licencia;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\bioleft_licencia\Entity\LicenciaInterface;

/**
 * Defines the storage handler class for Licencia entities.
 *
 * This extends the base storage class, adding required special handling for
 * Licencia entities.
 *
 * @ingroup bioleft_licencia
 */
class LicenciaStorage extends SqlContentEntityStorage implements LicenciaStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(LicenciaInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {licencia_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {licencia_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(LicenciaInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {licencia_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('licencia_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
