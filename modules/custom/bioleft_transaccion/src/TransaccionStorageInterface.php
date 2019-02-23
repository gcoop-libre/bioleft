<?php

namespace Drupal\bioleft_transaccion;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface TransaccionStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Transacción revision IDs for a specific Transacción.
   *
   * @param \Drupal\bioleft_transaccion\Entity\TransaccionInterface $entity
   *   The Transacción entity.
   *
   * @return int[]
   *   Transacción revision IDs (in ascending order).
   */
  public function revisionIds(TransaccionInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Transacción author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Transacción revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\bioleft_transaccion\Entity\TransaccionInterface $entity
   *   The Transacción entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(TransaccionInterface $entity);

  /**
   * Unsets the language for all Transacción with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
