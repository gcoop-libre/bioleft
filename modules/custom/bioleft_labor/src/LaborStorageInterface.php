<?php

namespace Drupal\bioleft_labor;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface LaborStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Labor revision IDs for a specific Labor.
   *
   * @param \Drupal\bioleft_labor\Entity\LaborInterface $entity
   *   The Labor entity.
   *
   * @return int[]
   *   Labor revision IDs (in ascending order).
   */
  public function revisionIds(LaborInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Labor author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Labor revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\bioleft_labor\Entity\LaborInterface $entity
   *   The Labor entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(LaborInterface $entity);

  /**
   * Unsets the language for all Labor with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
