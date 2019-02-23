<?php

namespace Drupal\bioleft_mis_cultivos;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Mis cultivos entity.
 *
 * @see \Drupal\bioleft_mis_cultivos\Entity\MisCultivos.
 */
class MisCultivosAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\bioleft_mis_cultivos\Entity\MisCultivosInterface $entity */
    $owner = 'any';
    if ($account->isAuthenticated() && $account->id() == $entity->getOwnerId()) {
      $owner = 'own';
    }
    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, "view {$owner} mis cultivos entities");

      case 'update':
        return AccessResult::allowedIfHasPermission($account, "edit {$owner} mis cultivos entities");

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, "delete {$owner} mis cultivos entities");
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add mis cultivos entities');
  }

}
