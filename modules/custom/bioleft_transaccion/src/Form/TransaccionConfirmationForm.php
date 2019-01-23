<?php

namespace Drupal\bioleft_transaccion\Form;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Entity\ContentEntityConfirmFormBase;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Form\ConfirmFormHelper;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Mail\MailManagerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a form for approving a transaccion.
 *
 * @ingroup bioleft_transaccion
 */
class TransaccionConfirmationForm extends ContentEntityConfirmFormBase {

  /**
   * The current user account.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $account;

  /**
   * Constructs a new TransaccionConfirmationForm object.
   *
   * @param \Drupal\Core\Entity\EntityManagerInterface $entity_manager
   *   The entity manager.
   * @param \Drupal\Core\Entity\EntityTypeBundleInfoInterface $entity_type_bundle_info
   *   The entity type bundle service.
   * @param \Drupal\Component\Datetime\TimeInterface $time
   *   The time service.
   * @param \Drupal\Core\Session\AccountProxyInterface $account
   *   The current user account.
   * @param Drupal\Core\Language\LanguageManagerInterface $language_manager
   *   The lang manager.
   * @param Drupal\Core\Mail\MailManagerInterface $mail_manager
   *   The mail manager.
   */
  public function __construct(EntityManagerInterface $entity_manager, EntityTypeBundleInfoInterface $entity_type_bundle_info = NULL, TimeInterface $time = NULL, AccountProxyInterface $account = NULL, LanguageManagerInterface $language_manager = NULL, MailManagerInterface $mail_manager = NULL) {
    parent::__construct($entity_manager, $entity_type_bundle_info, $time);
    $this->account = $account;
    $this->languageManager = $language_manager;
    $this->mailManager = $mail_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    // Instantiates this form class.
    return new static(
      $container->get('entity.manager'),
      $container->get('entity_type.bundle.info'),
      $container->get('datetime.time'),
      $container->get('current_user'),
      $container->get('language_manager'),
      $container->get('plugin.manager.mail')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    /** @var \Drupal\bioleft_transaccion\Entity\TransaccionInterface $transaccion */
    $transaccion = $this->entity;

    return $this->t('Are you sure you want to approve the transaccion @transaccion?', [
      '@transaccion' => $transaccion->label(),
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return $this->getEntity()->urlInfo('canonical');
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return $this->t('Aceptar');
  }

  /**
   * Label to Reject Button.
   */
  public function getRejectText() {
    return $this->t('Rechazar');
  }

  /**
   * {@inheritdoc}
   */
  protected function actions(array $form, FormStateInterface $form_state) {
    return [
      'accept' => [
        '#type' => 'submit',
        '#value' => $this->getConfirmText(),
        '#submit' => [
          [$this, 'submitForm'],
        ],
      ],
      'reject' => [
        '#type' => 'submit',
        '#value' => $this->getRejectText(),
        '#submit' => [
          [$this, 'rejectForm'],
        ],
      ],
      'cancel' => ConfirmFormHelper::buildCancelLink($this, $this->getRequest()),
    ];
  }

  /**
   * Notify via mail when submitForm and rejectForm.
   */
  private function sendNotificationMail() {
    // Definicion de valores del correo.
    $module = 'bioleft_transaccion';
    $key = 'transaction_confirmation_message';
    $to = implode(",", [
      $this->entity->getOwner()->getEmail(),
      $this->account->getEmail(),
    ]);
    $params['transaction'] = $this->entity;
    $result = $this->mailManager->mail($module, $key, $to, NULL, $params, TRUE);
    if ($result['result'] === TRUE) {
      $this->messenger()->addMessage($this->t('Your message has been sent.'));
    }
    else {
      $this->messenger()->addMessage($this->t('There was a problem sending your message and it was not sent.'), 'error');
    }
  }

  /**
   * Core functionality for submitForm and rejectForm.
   */
  private function saveAndApplyTransition(array $actionSubmitted) {
    $state = $this->entity->get('field_transaccion_state')->first();
    $transitions = $state->getTransitions();

    if ($state->value === 'pending') {
      $state->applyTransition($transitions[$actionSubmitted['transition']]);
      $this->entity->save();
      $this->messenger()->addMessage(
        $this->t('@type %title has been %action.', [
          '@type' => $this->entity->getEntityType()->getLabel(),
          '%title' => $this->entity->label(),
          '%action' => $actionSubmitted['message'],
        ])
      );
    }
    else {
      $this->messenger()->addMessage(
        $this->t('The transaccion can not be %action from its current state.', [
          '%action' => $actionSubmitted['message'],
        ]),
        'error'
      );
    };
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    /** @var \Drupal\bioleft_transaccion\src\Entity\TransaccionInterface $transaccion */
    $this->saveAndApplyTransition([
      'transition' => 'approve',
      'message' => 'accepted',
    ]);
    $this->sendNotificationMail();
    $form_state->setRedirectUrl($this->getCancelUrl());
  }

  /**
   * Funtion to handle the functionality extension of the Form.
   */
  public function rejectForm(array &$form, FormStateInterface $form_state) {
    /** @var \Drupal\bioleft_transaccion\src\Entity\TransaccionInterface $transaccion */
    $this->saveAndApplyTransition([
      'transition' => 'reject',
      'message' => 'rejected',
    ]);
    $this->sendNotificationMail();
    $form_state->setRedirectUrl($this->getCancelUrl());
  }

}
