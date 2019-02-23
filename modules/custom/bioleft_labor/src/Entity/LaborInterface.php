<?php

namespace Drupal\bioleft_labor\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Labor entities.
 *
 * @ingroup bioleft_labor
 */
interface LaborInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  /**
   * Gets the Labor name.
   *
   * @return string
   *   Name of the Labor.
   */
  public function getName();

  /**
   * Sets the Labor name.
   *
   * @param string $name
   *   The Labor name.
   *
   * @return \Drupal\bioleft_labor\Entity\LaborInterface
   *   The called Labor entity.
   */
  public function setName($name);

  /**
   * Gets the Labor creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Labor.
   */
  public function getCreatedTime();

  /**
   * Sets the Labor creation timestamp.
   *
   * @param int $timestamp
   *   The Labor creation timestamp.
   *
   * @return \Drupal\bioleft_labor\Entity\LaborInterface
   *   The called Labor entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Labor published status indicator.
   *
   * Unpublished Labor are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Labor is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Labor.
   *
   * @param bool $published
   *   TRUE to set this Labor to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\bioleft_labor\Entity\LaborInterface
   *   The called Labor entity.
   */
  public function setPublished($published);

  /**
   * Gets the Labor revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Labor revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\bioleft_labor\Entity\LaborInterface
   *   The called Labor entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Labor revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Labor revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\bioleft_labor\Entity\LaborInterface
   *   The called Labor entity.
   */
  public function setRevisionUserId($uid);

}
