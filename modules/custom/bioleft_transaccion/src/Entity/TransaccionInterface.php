<?php

namespace Drupal\bioleft_transaccion\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Transacción entities.
 *
 * @ingroup bioleft_transaccion
 */
interface TransaccionInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  /**
   * Gets the Transacción name.
   *
   * @return string
   *   Name of the Transacción.
   */
  public function getName();

  /**
   * Sets the Transacción name.
   *
   * @param string $name
   *   The Transacción name.
   *
   * @return \Drupal\bioleft_transaccion\Entity\TransaccionInterface
   *   The called Transacción entity.
   */
  public function setName($name);

  /**
   * Gets the Transacción creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Transacción.
   */
  public function getCreatedTime();

  /**
   * Sets the Transacción creation timestamp.
   *
   * @param int $timestamp
   *   The Transacción creation timestamp.
   *
   * @return \Drupal\bioleft_transaccion\Entity\TransaccionInterface
   *   The called Transacción entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Transacción published status indicator.
   *
   * Unpublished Transacción are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Transacción is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Transacción.
   *
   * @param bool $published
   *   TRUE to set the Transacción to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\bioleft_transaccion\Entity\TransaccionInterface
   *   The called Transacción entity.
   */
  public function setPublished($published);

  /**
   * Gets the Transacción revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Transacción revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\bioleft_transaccion\Entity\TransaccionInterface
   *   The called Transacción entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Transacción revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Transacción revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\bioleft_transaccion\Entity\TransaccionInterface
   *   The called Transacción entity.
   */
  public function setRevisionUserId($uid);

}
