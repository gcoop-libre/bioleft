<?php

namespace Drupal\bioleft_semilla\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Semilla entities.
 *
 * @ingroup bioleft_semilla
 */
interface SemillaInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  /**
   * Gets the Semilla name.
   *
   * @return string
   *   Name of the Semilla.
   */
  public function getName();

  /**
   * Sets the Semilla name.
   *
   * @param string $name
   *   The Semilla name.
   *
   * @return \Drupal\bioleft_semilla\Entity\SemillaInterface
   *   The called Semilla entity.
   */
  public function setName($name);

  /**
   * Gets the Semilla creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Semilla.
   */
  public function getCreatedTime();

  /**
   * Sets the Semilla creation timestamp.
   *
   * @param int $timestamp
   *   The Semilla creation timestamp.
   *
   * @return \Drupal\bioleft_semilla\Entity\SemillaInterface
   *   The called Semilla entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Semilla published status indicator.
   *
   * Unpublished Semilla are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Semilla is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Semilla.
   *
   * @param bool $published
   *   TRUE to set this Semilla to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\bioleft_semilla\Entity\SemillaInterface
   *   The called Semilla entity.
   */
  public function setPublished($published);

  /**
   * Gets the Semilla revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Semilla revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\bioleft_semilla\Entity\SemillaInterface
   *   The called Semilla entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Semilla revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Semilla revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\bioleft_semilla\Entity\SemillaInterface
   *   The called Semilla entity.
   */
  public function setRevisionUserId($uid);

}
