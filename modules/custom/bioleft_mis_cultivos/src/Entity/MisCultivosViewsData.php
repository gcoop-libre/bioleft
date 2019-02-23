<?php

namespace Drupal\bioleft_mis_cultivos\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Mis cultivos entities.
 */
class MisCultivosViewsData extends EntityViewsData {

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
