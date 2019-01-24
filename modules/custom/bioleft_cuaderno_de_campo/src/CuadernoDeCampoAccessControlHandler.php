<?php

namespace Drupal\bioleft_cuaderno_de_campo;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Cuaderno de campo entity.
 *
 * @see \Drupal\bioleft_cuaderno_de_campo\Entity\CuadernoDeCampo.
 */
class CuadernoDeCampoAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\bioleft_cuaderno_de_campo\Entity\CuadernoDeCampoInterface $entity */
    $owner = 'any';
    if ($account->isAuthenticated() && $account->id() == $entity->getOwnerId()) {
      $owner = 'own';
    }
    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, "view {$owner} cuaderno de campo entities");

      case 'update':
        return AccessResult::allowedIfHasPermission($account, "edit {$owner} cuaderno de campo entities");

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, "delete {$owner} cuaderno de campo entities");
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add cuaderno de campo entities');
  }

}
