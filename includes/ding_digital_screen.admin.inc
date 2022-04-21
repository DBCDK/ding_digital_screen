<?php

/**
 * @file
 * Implements admin page for Ding Digital Screen module.
 */

/**
 * Implements hook_form().
 */
function ding_digital_screen_admin_form($form, &$form_state) {
  $form = [];

  $form['ding_digital_screen_enable_logging'] = [
    '#type' => 'checkbox',
    '#title' => t('Enable logging'),
    '#default_value' => variable_get('ding_digital_screen_enable_logging', FALSE),
  ];

  $form['revert_config'] = array(
    '#type' => 'fieldset',
    '#title' => t('Revert configuration'),
    '#description' => t('Reverts the configuration after a update off DDBCMS has overridden them. Needs to be done every time DDBCMS is updated'),
  );

  $form['revert_config']['submit_button'] = [
    '#value' => t('Revert configuration'),
    '#type' => 'submit',
    '#submit' => ['ding_digital_screen_revert_configuration'],
  ];

  return system_settings_form($form);
}

/**
 * Restore configuration to default.
 */
function ding_digital_screen_revert_configuration($form, &$form_state) {
  try {
    ding_digital_screen_add_site_template_config();
    drupal_set_message(t('Digital Screen configuration restored'));
  } catch (Exception $e) {
    watchdog_exception('ding_digital_screen', $e);
    drupal_set_message(t('Failed to restore Digital Screen configuration'));
  }
}
