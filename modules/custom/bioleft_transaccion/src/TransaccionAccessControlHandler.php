<?php

namespace Drupal\bioleft_transaccion;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Transacción entity.
 *
 * @see \Drupal\bioleft_transaccion\Entity\Transaccion.
 */
class TransaccionAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\bioleft_transaccion\Entity\TransaccionInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished transaccion entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published transaccion entities');

      case 'update':
        if ($entity->get('field_transaccion_state')->first()->value === 'pending') {
          return AccessResult::allowedIfHasPermission($account, 'edit transaccion entities');
        }
        return AccessResult::forbidden('This entity has a final state')
          ->addcacheabledependency($entity);

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete transaccion entities');

      case 'confirm':
        $semilla_owner = $entity->get('field_semilla')->entity->getOwner();
        if ($semilla_owner->id() === $account->id()) {
          $transitions = $entity->get('field_transaccion_state')->first()->getTransitions();
          if ($transitions) {
            foreach ($transitions as $transition) {
              if (in_array($transition->getId(), ['approve', 'reject'])) {
                return AccessResult::allowedifhaspermission($account, "confirm transaccion entities")
                  ->addcacheabledependency($entity);
              }
            }
          }
        }
        return AccessResult::forbidden('there are no allowed transitions')
          ->addcacheabledependency($entity);
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add transacción entities');
  }

}
