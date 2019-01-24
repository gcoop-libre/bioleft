<?php

namespace Drupal\bioleft_licencia;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Licencia entity.
 *
 * @see \Drupal\bioleft_licencia\Entity\Licencia.
 */
class LicenciaAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\bioleft_licencia\Entity\LicenciaInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished licencia entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published licencia entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit licencia entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete licencia entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add licencia entities');
  }

}
