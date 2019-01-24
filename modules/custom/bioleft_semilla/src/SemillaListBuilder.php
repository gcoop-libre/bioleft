<?php

namespace Drupal\bioleft_semilla;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Semilla entities.
 *
 * @ingroup bioleft_semilla
 */
class SemillaListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Semilla ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\bioleft_semilla\Entity\Semilla */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.semilla.edit_form',
      ['semilla' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
