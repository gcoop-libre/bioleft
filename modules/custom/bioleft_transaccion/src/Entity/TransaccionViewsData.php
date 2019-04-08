<?php

namespace Drupal\bioleft_transaccion\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Transacción entities.
 */
class TransaccionViewsData extends EntityViewsData {

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
