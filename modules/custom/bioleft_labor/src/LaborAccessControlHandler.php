<?php

namespace Drupal\bioleft_labor;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Labor entity.
 *
 * @see \Drupal\bioleft_labor\Entity\Labor.
 */
class LaborAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\bioleft_labor\Entity\LaborInterface $entity */
    $owner = 'any';
    if ($account->isAuthenticated() && $account->id() == $entity->getOwnerId()) {
      $owner = 'own';
    }
    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, "view {$owner} labor entities");

      case 'update':
        return AccessResult::allowedIfHasPermission($account, "edit {$owner} labor entities");

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, "delete {$owner} labor entities");
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add labor entities');
  }

}
