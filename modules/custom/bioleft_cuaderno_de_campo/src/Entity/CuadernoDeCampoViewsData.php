<?php

namespace Drupal\bioleft_cuaderno_de_campo\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Cuaderno de campo entities.
 */
class CuadernoDeCampoViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.
    return $data;
  }

}
