<?php

namespace Drupal\bioleft_semilla;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface SemillaStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Semilla revision IDs for a specific Semilla.
   *
   * @param \Drupal\bioleft_semilla\Entity\SemillaInterface $entity
   *   The Semilla entity.
   *
   * @return int[]
   *   Semilla revision IDs (in ascending order).
   */
  public function revisionIds(SemillaInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Semilla author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Semilla revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\bioleft_semilla\Entity\SemillaInterface $entity
   *   The Semilla entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(SemillaInterface $entity);

  /**
   * Unsets the language for all Semilla with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
