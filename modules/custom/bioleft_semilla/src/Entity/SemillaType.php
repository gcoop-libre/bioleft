<?php

namespace Drupal\bioleft_semilla\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Semilla type entity.
 *
 * @ConfigEntityType(
 *   id = "semilla_type",
 *   label = @Translation("Semilla type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\bioleft_semilla\SemillaTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\bioleft_semilla\Form\SemillaTypeForm",
 *       "edit" = "Drupal\bioleft_semilla\Form\SemillaTypeForm",
 *       "delete" = "Drupal\bioleft_semilla\Form\SemillaTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\bioleft_semilla\SemillaTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "semilla_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "semilla",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/semilla_type/{semilla_type}",
 *     "add-form" = "/admin/structure/semilla_type/add",
 *     "edit-form" = "/admin/structure/semilla_type/{semilla_type}/edit",
 *     "delete-form" = "/admin/structure/semilla_type/{semilla_type}/delete",
 *     "collection" = "/admin/structure/semilla_type"
 *   }
 * )
 */
class SemillaType extends ConfigEntityBundleBase implements SemillaTypeInterface {

  /**
   * The Semilla type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Semilla type label.
   *
   * @var string
   */
  protected $label;

}
