<?php

namespace Drupal\table_select\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class tableform.
 *
 * @package Drupal\table_select\Form
 */
class tableform extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'tableform';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $query = \Drupal::database()->select('users_field_data', 'u');
    $query->fields('u', ['uid', 'name', 'mail']);
    $results = $query->execute()->fetchAll();
    $header = [
      'userid' => t('User id'),
      'Username' => t('username'),
      'email' => t('Email'),
    ];
// Initialize an empty array
    $output = array();
// Next, loop through the $results array
    foreach ($results as $result) {
      if ($result->uid != 0 && $result->uid != 1) {
        $output[$result->uid] = [
          'userid' => $result->uid, // 'userid' was the key used in the header
          'Username' => $result->name, // 'Username' was the key used in the header
          'email' => $result->mail, // 'email' was the key used in the header
        ];
      }
    }
    $form['table'] = [
      '#type' => 'tableselect',
      '#header' => $header,
      '#options' => $output,
      '#empty' => t('No users found'),
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    foreach ($form_state->getValues() as $key => $value) {
      drupal_set_message($key . ': ' . $value);
    }
  }

}
