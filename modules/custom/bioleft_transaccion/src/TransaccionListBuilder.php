<?php

namespace Drupal\bioleft_transaccion;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Transacción entities.
 *
 * @ingroup bioleft_transaccion
 */
class TransaccionListBuilder extends EntityListBuilder {

  /**
   * Gets this list's default operations.
   *
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   The entity the operations are for.
   *
   * @return array
   *   The array structure is identical to the return value of
   *   self::getOperations().
   */
  protected function getDefaultOperations(EntityInterface $entity) {
    $operations = parent::getDefaultOperations($entity);
    if ($entity->access('confirm')) {
      $operations['confirm'] = [
        'title' => $this->t('Confirm'),
        'weight' => 10,
        'url' => $this->ensureDestination($entity->toUrl('confirm-form')),
      ];
    }
    return $operations;
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Transacción ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\bioleft_transaccion\Entity\Transaccion */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.transaccion.edit_form',
      ['transaccion' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
