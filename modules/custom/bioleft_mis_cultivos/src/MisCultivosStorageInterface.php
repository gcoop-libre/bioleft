<?php

namespace Drupal\bioleft_mis_cultivos;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface MisCultivosStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Mis cultivos revision IDs for a specific Mis cultivos.
   *
   * @param \Drupal\bioleft_mis_cultivos\Entity\MisCultivosInterface $entity
   *   The Mis cultivos entity.
   *
   * @return int[]
   *   Mis cultivos revision IDs (in ascending order).
   */
  public function revisionIds(MisCultivosInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Mis cultivos author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Mis cultivos revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\bioleft_mis_cultivos\Entity\MisCultivosInterface $entity
   *   The Mis cultivos entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(MisCultivosInterface $entity);

  /**
   * Unsets the language for all Mis cultivos with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
