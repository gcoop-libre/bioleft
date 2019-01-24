<?php

namespace Drupal\bioleft_transaccion\Form;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Mail\MailManagerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form controller for Transacción edit forms.
 *
 * @ingroup bioleft_transaccion
 */
class TransaccionForm extends ContentEntityForm {

  /**
   * The current user account.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $account;

  /**
   * Constructs a new TransaccionForm object.
   *
   * @param \Drupal\Core\Entity\EntityManagerInterface $entity_manager
   *   The entity manager.
   * @param \Drupal\Core\Entity\EntityTypeBundleInfoInterface $entity_type_bundle_info
   *   The entity type bundle service.
   * @param \Drupal\Component\Datetime\TimeInterface $time
   *   The time service.
   * @param \Drupal\Core\Session\AccountProxyInterface $account
   *   The current user account.
   * @param Drupal\Core\Mail\MailManagerInterface $mail_manager
   *   The mail manager.
   * @param Drupal\Core\Language\LanguageManagerInterface $language_manager
   *   The lang manager.
   */
  public function __construct(EntityManagerInterface $entity_manager = NULL, EntityTypeBundleInfoInterface $entity_type_bundle_info = NULL, TimeInterface $time = NULL, AccountProxyInterface $account = NULL, MailManagerInterface $mail_manager = NULL, LanguageManagerInterface $language_manager = NULL) {
    parent::__construct($entity_manager, $entity_type_bundle_info, $time);
    $this->languageManager = $language_manager;
    $this->mailManager = $mail_manager;
    $this->account = $account;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.manager'),
      $container->get('entity_type.bundle.info'),
      $container->get('datetime.time'),
      $container->get('current_user'),
      $container->get('plugin.manager.mail'),
      $container->get('language_manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\bioleft_transaccion\Entity\Transaccion */
    $form = parent::buildForm($form, $form_state);

    if (!$this->entity->isNew()) {
      $form['new_revision'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Create new revision'),
        '#default_value' => FALSE,
        '#weight' => 10,
      ];
    }
    return $form;
  }

  /**
   * Function to send Email with URL-to-confirm-transaccion to Semilla's Owner.
   */
  private function sendEmailToConfirmTransaccion($entity) {
    if (isset($entity->get('field_semilla')->entity)) {

      // Definicion de valores del correo.
      $module = 'bioleft_transaccion';
      $key = 'transaction_message';
      $to = $entity->get('field_semilla')->entity->getOwner()->getEmail();
      $params['transaction'] = $entity;
      $language_code = $this->languageManager->getDefaultLanguage()->getId();
      $result = $this->mailManager->mail($module, $key, $to, $language_code, $params, TRUE);
      if ($result['result'] === TRUE) {
        $this->messenger()->addMessage($this->t('Your message has been sent.'));
      }
      else {
        $this->messenger()->addMessage($this->t('There was a problem sending your message and it was not sent.'), 'error');
      }
    }
    else {
      $this->messenger()->addMessage(
        $this->t('Field Semilla does not have a defined value.'),
        'error'
      );
    }
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {

    $entity = $this->entity;
    // Save as a new revision if requested to do so.
    if (!$form_state->isValueEmpty('new_revision') && $form_state->getValue('new_revision') != FALSE) {
      $entity->setNewRevision();

      // If a new revision is created, save the current user as revision author.
      $entity->setRevisionCreationTime($this->time->getRequestTime());
      $entity->setRevisionUserId($this->account->id());
    }
    else {
      $entity->setNewRevision(FALSE);
    }

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Transacción.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Transacción.', [
          '%label' => $entity->label(),
        ]));
    }
    /*
     * After save the Transaccion, a mail is sended to Semilla's
     * Owner to confirm the exchange.
     */
    $this->sendEmailToConfirmTransaccion($entity);
    $form_state->setRedirect('entity.transaccion.canonical', ['transaccion' => $entity->id()]);
  }

}
