<?php

namespace Drupal\bioleft_cuaderno_de_campo\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Cuaderno de campo edit forms.
 *
 * @ingroup bioleft_cuaderno_de_campo
 */
class CuadernoDeCampoForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\bioleft_cuaderno_de_campo\Entity\CuadernoDeCampo */
    $form = parent::buildForm($form, $form_state);
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Cuaderno de campo.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Cuaderno de campo.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.cuaderno_de_campo.canonical', ['cuaderno_de_campo' => $entity->id()]);
  }

}
