<?php

namespace Drupal\bioleft_mis_cultivos\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Mis cultivos entities.
 *
 * @ingroup bioleft_mis_cultivos
 */
interface MisCultivosInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  /**
   * Gets the Mis cultivos name.
   *
   * @return string
   *   Name of the Mis cultivos.
   */
  public function getName();

  /**
   * Sets the Mis cultivos name.
   *
   * @param string $name
   *   The Mis cultivos name.
   *
   * @return \Drupal\bioleft_mis_cultivos\Entity\MisCultivosInterface
   *   The called Mis cultivos entity.
   */
  public function setName($name);

  /**
   * Gets the Mis cultivos creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Mis cultivos.
   */
  public function getCreatedTime();

  /**
   * Sets the Mis cultivos creation timestamp.
   *
   * @param int $timestamp
   *   The Mis cultivos creation timestamp.
   *
   * @return \Drupal\bioleft_mis_cultivos\Entity\MisCultivosInterface
   *   The called Mis cultivos entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Mis cultivos published status indicator.
   *
   * Unpublished Mis cultivos are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Mis cultivos is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Mis cultivos.
   *
   * @param bool $published
   *   TRUE to set this Mis cultivos to published, FALSE to set it to
   *   unpublished.
   *
   * @return \Drupal\bioleft_mis_cultivos\Entity\MisCultivosInterface
   *   The called Mis cultivos entity.
   */
  public function setPublished($published);

  /**
   * Gets the Mis cultivos revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Mis cultivos revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\bioleft_mis_cultivos\Entity\MisCultivosInterface
   *   The called Mis cultivos entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Mis cultivos revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Mis cultivos revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\bioleft_mis_cultivos\Entity\MisCultivosInterface
   *   The called Mis cultivos entity.
   */
  public function setRevisionUserId($uid);

}
