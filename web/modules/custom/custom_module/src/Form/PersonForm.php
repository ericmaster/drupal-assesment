<?php

declare(strict_types=1);

namespace Drupal\custom_module\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\custom_module\Entity\Person;

/**
 * Person form.
 */
final class PersonForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state): array {

    $form = parent::form($form, $form_state);

    /** @var \Drupal\custom_module\Entity\Person $person */
    $person = $this->entity;

    $form['first_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First Name'),
      '#maxlength' => 255,
      '#default_value' => $person->getFirstName(),
      '#description' => $this->t('Enter the first name.'),
      '#required' => TRUE,
    ];

    $form['last_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Last Name'),
      '#maxlength' => 255,
      '#default_value' => $person->getLastName(),
      '#description' => $this->t('Enter the last name.'),
      '#required' => TRUE,
    ];

    $form['label'] = [
      '#type' => 'textfield',
      // '#title' => '',
      '#default_value' => $person->label(),
      '#attributes' => [
        'style' => 'display: none;',
        'data-person-label' => 'true',
      ],
      '#required' => FALSE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $person->id(),
      '#machine_name' => [
        'exists' => [Person::class, 'load'],
        'source' => ['label'],
      ],
      '#disabled' => !$person->isNew(),
      '#attached' => [
        'library' => ['custom_module/person_form'],
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state): int {
    /** @var \Drupal\custom_module\Entity\Person $person */
    $person = $this->entity;

    // Set the first and last name from form values.
    $person->setFirstName($form_state->getValue('first_name'));
    $person->setLastName($form_state->getValue('last_name'));
    
    // Auto-populate the label with the full name.
    $full_name = trim($form_state->getValue('first_name') . ' ' . $form_state->getValue('last_name'));
    $person->set('label', $full_name);

    $result = parent::save($form, $form_state);
    $message_args = ['%label' => $person->label()];
    $this->messenger()->addStatus(
      match($result) {
        \SAVED_NEW => $this->t('Created new person %label.', $message_args),
        \SAVED_UPDATED => $this->t('Updated person %label.', $message_args),
      }
    );
    $form_state->setRedirectUrl($person->toUrl('collection'));
    return $result;
  }

}
