<?php

/**
 * @file
 * Implements admin page for Ding Digital Screen module.
 */

/**
 * Implements hook_form().
 */
function ding_digital_screen_pages_form($form, &$form_state) {
  $form = [];

  $form['submit_button'] = [
    '#value' => t('Add digital screen'),
    '#type' => 'submit',
    '#submit' => ['ding_digital_screen_add_screen'],
  ];
  
  $pages = ding_digital_screen_get_pages();
  $header = [t('Pages'), t('Edit page'), t('Delete page')];
  $pages_table = theme('table', ['header' => $header, 'rows' => $pages]);

  $form['pages'] = array(
    '#type' => 'fieldset',
    '#title' => t('Digital screen pages'),
  );

  $form['pages']['table'] = [
    '#markup' =>  $pages_table,
  ];



  return system_settings_form($form);
}

/**
 * Add digital screen page submit function.
 */
function ding_digital_screen_add_screen($form, &$form_state) {
  drupal_goto('admin/structure/digital/screen/add');
}

/**
 * Get all digital screen pages.
 */
function ding_digital_screen_get_pages() {
  $pages = [];
  $result = ding_digital_screen_get_entities();
  if (isset($result['digital_screen_page'])) {
    foreach ($result['digital_screen_page'] as $id => $item) {
      $pages[] = ding_digital_screen_process_page($id);
    }
  }
  return $pages;
}

/**
 * Process a digital screen page.
 */
function ding_digital_screen_process_page($id) {
  $page_entity = entity_metadata_wrapper('digital_screen_page', $id);
  $title = $page_entity->title->value();
  $page_link = l($title, 'digital/screen/' . $id);
  $edit_link = l(t('Edit Digital Screen'), 'admin/structure/digital/screen/' . $id . '/edit' );
  $delete_link = l(t('Delete Digital Screen'), 'admin/structure/digital/screen/' . $id . '/delete' );
  return [$page_link, $edit_link, $delete_link];
}

