<?php
/**
 * @file
 * digital_screen_feature.field_group.inc
 */

/**
 * Implements hook_field_group_info().
 */
function digital_screen_feature_field_group_info() {
  $field_groups = array();

  $field_group = new stdClass();
  $field_group->disabled = FALSE; /* Edit this to true to make a default field_group disabled initially */
  $field_group->api_version = 1;
  $field_group->identifier = 'group_rotate_settings|paragraphs_item|ding_digital_screen_carousel|form';
  $field_group->group_name = 'group_rotate_settings';
  $field_group->entity_type = 'paragraphs_item';
  $field_group->bundle = 'ding_digital_screen_carousel';
  $field_group->mode = 'form';
  $field_group->parent_name = '';
  $field_group->data = array(
    'label' => 'Rotate Settings',
    'weight' => '2',
    'children' => array(
      0 => 'field_rotate',
      1 => 'field_number_of_posts',
    ),
    'format_type' => 'fieldset',
    'format_settings' => array(
      'formatter' => 'collapsible',
      'instance_settings' => array(
        'description' => '',
        'classes' => 'group-rotate-settings field-group-fieldset',
        'required_fields' => 1,
        'id' => '',
      ),
    ),
  );
  $field_groups['group_rotate_settings|paragraphs_item|ding_digital_screen_carousel|form'] = $field_group;

  // Translatables
  // Included for use with string extractors like potx.
  t('Rotate Settings');

  return $field_groups;
}
