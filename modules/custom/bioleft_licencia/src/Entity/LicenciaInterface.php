<?php

namespace Drupal\bioleft_licencia\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Licencia entities.
 *
 * @ingroup bioleft_licencia
 */
interface LicenciaInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  /**
   * Gets the Licencia name.
   *
   * @return string
   *   Name of the Licencia.
   */
  public function getName();

  /**
   * Sets the Licencia name.
   *
   * @param string $name
   *   The Licencia name.
   *
   * @return \Drupal\bioleft_licencia\Entity\LicenciaInterface
   *   The called Licencia entity.
   */
  public function setName($name);

  /**
   * Gets the Licencia creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Licencia.
   */
  public function getCreatedTime();

  /**
   * Sets the Licencia creation timestamp.
   *
   * @param int $timestamp
   *   The Licencia creation timestamp.
   *
   * @return \Drupal\bioleft_licencia\Entity\LicenciaInterface
   *   The called Licencia entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Licencia published status indicator.
   *
   * Unpublished Licencia are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Licencia is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Licencia.
   *
   * @param bool $published
   *   TRUE to set this Licencia to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\bioleft_licencia\Entity\LicenciaInterface
   *   The called Licencia entity.
   */
  public function setPublished($published);

  /**
   * Gets the Licencia revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Licencia revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\bioleft_licencia\Entity\LicenciaInterface
   *   The called Licencia entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Licencia revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Licencia revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\bioleft_licencia\Entity\LicenciaInterface
   *   The called Licencia entity.
   */
  public function setRevisionUserId($uid);

}
