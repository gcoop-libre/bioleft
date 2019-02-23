<?php

namespace Drupal\bioleft_semilla;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Semilla entity.
 *
 * @see \Drupal\bioleft_semilla\Entity\SemillaInterface.
 */
class SemillaAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\bioleft_semilla\Entity\SemillaInterface $entity */
    $bundle = $entity->bundle();
    $owner = 'any';
    if ($account->isAuthenticated() && $account->id() == $entity->getOwnerId()) {
      $owner = 'own';
    }
    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, "view {$owner} semilla {$bundle}");

      case 'update':
        return AccessResult::allowedIfHasPermission($account, "edit {$owner} semilla {$bundle}");

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, "delete {$owner} semilla {$bundle}");

    }
    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, "create semilla $entity_bundle");
  }

}
