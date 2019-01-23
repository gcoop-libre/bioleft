<?php

namespace Drupal\bioleft_transaccion\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\bioleft_semilla\Entity\SemillaInterface;

/**
 * Form controller for Transacción edit forms.
 *
 * @ingroup bioleft_transaccion
 */
class TransaccionCatalogoForm extends TransaccionForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, SemillaInterface $semilla = NULL) {

    /* @var \Drupal\bioleft_transaccion\Entity\Transaccion $entity */
    $this->entity->set('field_semilla', $semilla->id());
    $semilla_ref = $semilla->field_form_semilla->target_id;
    $form = parent::buildForm($form, $form_state);

    if (!$this->entity->isNew()) {
      $form['new_revision'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Create new revision'),
        '#default_value' => FALSE,
        '#weight' => 10,
      ];
    }
    $node = \Drupal::entityTypeManager()
      ->getStorage('semilla')
      ->loadByProperties([
        'type' => [
          'semilla_registrada',
          'semilla_mejorada',
          'semilla_sin_registrar',
        ],
        'id' => $semilla_ref,
      ]);

    $term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($node[$semilla_ref]->field_especie->target_id);
    $especie = $term->getName();

    switch ($node[$semilla_ref]->type->target_id) {
      case 'semilla_registrada':
        $cultivo = $node[$semilla_ref]->field_cultivar->value;
        $registro = $node[$semilla_ref]->field_nro_registro->value;
        $etiqueta_semilla = $especie . " " . $cultivo . " " . $registro;
        break;

      case 'semilla_mejorada':
        $cultivo = $node[$semilla_ref]->field_cultivar->value;
        $etiqueta_semilla = $especie . " " . $cultivo;
        break;

      case 'semilla_sin_registrar':
        $cultivo = $node[$semilla_ref]->field_cultivar->value;
        $etiqueta_semilla = $especie . " " . $cultivo;
        break;
    }

    $form['#title'] = "Semilla solicitada: " . $etiqueta_semilla;
    $form['status']['#access'] = FALSE;
    $form['name']['#access'] = FALSE;
    $form['name']['widget'][0]['value']['#default_value'] = substr($etiqueta_semilla, 0, 40);
    $form['field_semilla']['#access'] = FALSE;
    $form['field_fecha']['#access'] = FALSE;
    return $form;
  }

}
