<?php

namespace Drupal\bioleft_licencia;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Licencia entities.
 *
 * @ingroup bioleft_licencia
 */
class LicenciaListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Licencia ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\bioleft_licencia\Entity\Licencia */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.licencia.edit_form',
      ['licencia' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
