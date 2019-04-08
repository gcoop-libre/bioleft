<?php

namespace Drupal\bioleft_licencia;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface LicenciaStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Licencia revision IDs for a specific Licencia.
   *
   * @param \Drupal\bioleft_licencia\Entity\LicenciaInterface $entity
   *   The Licencia entity.
   *
   * @return int[]
   *   Licencia revision IDs (in ascending order).
   */
  public function revisionIds(LicenciaInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Licencia author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Licencia revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\bioleft_licencia\Entity\LicenciaInterface $entity
   *   The Licencia entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(LicenciaInterface $entity);

  /**
   * Unsets the language for all Licencia with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
