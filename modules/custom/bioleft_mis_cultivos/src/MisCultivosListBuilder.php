<?php

namespace Drupal\bioleft_mis_cultivos;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Mis cultivos entities.
 *
 * @ingroup bioleft_mis_cultivos
 */
class MisCultivosListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Mis cultivos ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\bioleft_mis_cultivos\Entity\MisCultivos */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.mis_cultivos.edit_form',
      ['mis_cultivos' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
