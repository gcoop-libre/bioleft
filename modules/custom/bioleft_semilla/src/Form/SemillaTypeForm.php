<?php

namespace Drupal\bioleft_semilla\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SemillaTypeForm.
 */
class SemillaTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $semilla_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $semilla_type->label(),
      '#description' => $this->t("Label for the Semilla type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $semilla_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\bioleft_semilla\Entity\SemillaType::load',
      ],
      '#disabled' => !$semilla_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $semilla_type = $this->entity;
    $status = $semilla_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Semilla type.', [
          '%label' => $semilla_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Semilla type.', [
          '%label' => $semilla_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($semilla_type->toUrl('collection'));
  }

}
