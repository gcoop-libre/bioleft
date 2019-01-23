<?php

namespace Drupal\bioleft_transaccion\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class TransaccionTypeForm.
 */
class TransaccionTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $transaccion_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $transaccion_type->label(),
      '#description' => $this->t("Label for the Transacción type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $transaccion_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\bioleft_transaccion\Entity\TransaccionType::load',
      ],
      '#disabled' => !$transaccion_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $transaccion_type = $this->entity;
    $status = $transaccion_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Transacción type.', [
          '%label' => $transaccion_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Transacción type.', [
          '%label' => $transaccion_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($transaccion_type->toUrl('collection'));
  }

}
