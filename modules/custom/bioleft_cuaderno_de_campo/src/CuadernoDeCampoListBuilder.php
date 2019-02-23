<?php

namespace Drupal\bioleft_cuaderno_de_campo;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Cuaderno de campo entities.
 *
 * @ingroup bioleft_cuaderno_de_campo
 */
class CuadernoDeCampoListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Cuaderno de campo ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\bioleft_cuaderno_de_campo\Entity\CuadernoDeCampo */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.cuaderno_de_campo.edit_form',
      ['cuaderno_de_campo' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
