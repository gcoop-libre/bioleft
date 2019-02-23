<?php

namespace Drupal\bioleft_cuaderno_de_campo\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Cuaderno de campo entities.
 *
 * @ingroup bioleft_cuaderno_de_campo
 */
interface CuadernoDeCampoInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  /**
   * Gets the Cuaderno de campo name.
   *
   * @return string
   *   Name of the Cuaderno de campo.
   */
  public function getName();

  /**
   * Sets the Cuaderno de campo name.
   *
   * @param string $name
   *   The Cuaderno de campo name.
   *
   * @return \Drupal\bioleft_cuaderno_de_campo\Entity\CuadernoDeCampoInterface
   *   The called Cuaderno de campo entity.
   */
  public function setName($name);

  /**
   * Gets the Cuaderno de campo creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Cuaderno de campo.
   */
  public function getCreatedTime();

  /**
   * Sets the Cuaderno de campo creation timestamp.
   *
   * @param int $timestamp
   *   The Cuaderno de campo creation timestamp.
   *
   * @return \Drupal\bioleft_cuaderno_de_campo\Entity\CuadernoDeCampoInterface
   *   The called Cuaderno de campo entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Cuaderno de campo published status indicator.
   *
   * Unpublished Cuaderno de campo are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Cuaderno de campo is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Cuaderno de campo.
   *
   * @param bool $published
   *   TRUE to set this Cuaderno de campo to published, FALSE
   *   to set it to unpublished.
   *
   * @return \Drupal\bioleft_cuaderno_de_campo\Entity\CuadernoDeCampoInterface
   *   The called Cuaderno de campo entity.
   */
  public function setPublished($published);

}
