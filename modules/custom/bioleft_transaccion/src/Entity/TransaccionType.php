<?php

namespace Drupal\bioleft_transaccion\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Transacción type entity.
 *
 * @ConfigEntityType(
 *   id = "transaccion_type",
 *   label = @Translation("Transacción type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\bioleft_transaccion\TransaccionTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\bioleft_transaccion\Form\TransaccionTypeForm",
 *       "edit" = "Drupal\bioleft_transaccion\Form\TransaccionTypeForm",
 *       "delete" = "Drupal\bioleft_transaccion\Form\TransaccionTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\bioleft_transaccion\TransaccionTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "transaccion_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "transaccion",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/transaccion_type/{transaccion_type}",
 *     "add-form" = "/admin/structure/transaccion_type/add",
 *     "edit-form" = "/admin/structure/transaccion_type/{transaccion_type}/edit",
 *     "delete-form" = "/admin/structure/transaccion_type/{transaccion_type}/delete",
 *     "collection" = "/admin/structure/transaccion_type"
 *   }
 * )
 */
class TransaccionType extends ConfigEntityBundleBase implements TransaccionTypeInterface {

  /**
   * The Transacción type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Transacción type label.
   *
   * @var string
   */
  protected $label;

}
