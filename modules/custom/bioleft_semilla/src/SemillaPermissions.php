<?php

namespace Drupal\bioleft_semilla;

use Drupal\Core\Routing\UrlGeneratorTrait;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\bioleft_semilla\Entity\SemillaType;
use Drupal\bioleft_semilla\Entity\SemillaTypeInterface;

/**
 * Provides dynamic permissions for nodes of different types.
 */
class SemillaPermissions {

  use StringTranslationTrait;
  use UrlGeneratorTrait;

  /**
   * Returns an array of node type permissions.
   *
   * @return array
   *   The node type permissions.
   *
   * @see \Drupal\bioleft_semilla\SemillaPermissions::semillaTypePermissions()
   */
  public function semillaTypePermissions() {
    $perms = [];
    // Generate node permissions for all node types.
    foreach (SemillaType::loadMultiple() as $type) {
      $perms += $this->buildPermissions($type);
    }
    return $perms;
  }

  /**
   * Returns a list of node permissions for a given node type.
   *
   * @param \Drupal\bioleft_semilla\Entity\SemillaTypeInterface $type
   *   The node type.
   *
   * @return array
   *   An associative array of permission names and descriptions.
   */
  protected function buildPermissions(SemillaTypeInterface $type) {
    $type_id = $type->id();
    $type_params = [
      '%type_name' => $type->label(),
    ];
    return [
      "create semilla $type_id" => [
        'title' => $this->t('%type_name: Create new semilla', $type_params),
      ],
      "view any semilla $type_id" => [
        'title' => $this->t("%type_name: View any semilla", $type_params),
      ],
      "view own semilla $type_id" => [
        'title' => $this->t("%type_name: View own semilla", $type_params),
      ],
      "edit any semilla $type_id" => [
        'title' => $this->t("%type_name: Edit any semilla", $type_params),
      ],
      "edit own semilla $type_id" => [
        'title' => $this->t("%type_name: Edit own semilla", $type_params),
      ],
      "delete any semilla $type_id" => [
        'title' => $this->t("%type_name: Delete any semilla", $type_params),
      ],
      "delete own semilla $type_id" => [
        'title' => $this->t("%type_name: Delete own semilla", $type_params),
      ],
    ];
  }

}
