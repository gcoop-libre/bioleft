<?php

/**
 * @file
 * Contains transaction.mail.inc.
 *
 * Render callback for emails.
 */

use Drupal\Core\Url;

/**
 * Prepares variables for transaction request template.
 *
 * Default template: transaction-request-notification.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - receiver: The semilla owner.
 *   - sender: The Transaccion requester/owner.
 *   - url: URL to transaction confirm form.
 */
function template_preprocess_transaction_request_notification(array &$variables) {
  $transaction = $variables['transaction'];
  if ($transaction->hasField('field_semilla')) {
    $variables['receiver'] = $transaction->get('field_semilla')->entity->getOwner()->getDisplayName();
    $variables['sender'] = $transaction->getOwner()->getDisplayName();
  }
  $variables['url'] = (new Url('entity.transaccion.confirm_form',
    ['transaccion' => $transaction->id()],
    ['absolute' => TRUE, 'https' => TRUE]))->toString();
};

/**
 * Prepares variables for confirmation message template.
 *
 * Default template: transaction-confirmation-message.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - receiver: The Transaccion owner.
 *   - sender: The Semilla owner.
 *   - result: The Transaccion's final state.
 */
function template_preprocess_transaction_confirmation_message(array &$variables) {
  $transaction = $variables['transaction'];
  if ($transaction->hasField('field_semilla')) {
    $variables['sender'] = $transaction->get('field_semilla')->entity->getOwner()->getDisplayName();
    $variables['receiver'] = $transaction->getOwner()->getDisplayName();
  }
  $variables['result'] = $transaction->get('field_transaccion_state')->first()->getLabel();
};
