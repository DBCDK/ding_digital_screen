<?php
/**
 * @file
 * digital_screen_feature.features.inc
 */

/**
 * Implements hook_ctools_plugin_api().
 */
function digital_screen_feature_ctools_plugin_api($module = NULL, $api = NULL) {
  if ($module == "field_group" && $api == "field_group") {
    return array("version" => "1");
  }
  if ($module == "strongarm" && $api == "strongarm") {
    return array("version" => "1");
  }
}

/**
 * Implements hook_eck_bundle_info().
 */
function digital_screen_feature_eck_bundle_info() {
  $items = array(
    'digital_screen_page_digital_screen_page' => array(
      'machine_name' => 'digital_screen_page_digital_screen_page',
      'entity_type' => 'digital_screen_page',
      'name' => 'digital_screen_page',
      'label' => 'Digital screen page',
      'config' => array(),
    ),
  );
  return $items;
}

/**
 * Implements hook_eck_entity_type_info().
 */
function digital_screen_feature_eck_entity_type_info() {
  $items = array(
    'digital_screen_page' => array(
      'name' => 'digital_screen_page',
      'label' => 'Digital screen page',
      'properties' => array(
        'title' => array(
          'label' => 'Title',
          'type' => 'text',
          'behavior' => 'title',
        ),
        'uid' => array(
          'label' => 'Author',
          'type' => 'integer',
          'behavior' => 'author',
        ),
        'created' => array(
          'label' => 'Created',
          'type' => 'integer',
          'behavior' => 'created',
        ),
        'changed' => array(
          'label' => 'Changed',
          'type' => 'integer',
          'behavior' => 'changed',
        ),
        'uuid' => array(
          'label' => 'UUID',
          'type' => 'text',
          'behavior' => 'uuid',
        ),
      ),
    ),
  );
  return $items;
}

/**
 * Implements hook_image_default_styles().
 */
function digital_screen_feature_image_default_styles() {
  $styles = array();

  // Exported image style: ding_digital_screen_large.
  $styles['ding_digital_screen_large'] = array(
    'label' => 'Ding digital screen large',
    'effects' => array(
      2 => array(
        'name' => 'image_scale_and_crop',
        'data' => array(
          'width' => 400,
          'height' => 580,
        ),
        'weight' => 1,
      ),
    ),
  );

  return $styles;
}

/**
 * Implements hook_node_info().
 */
function digital_screen_feature_node_info() {
  $items = array(
    'digital_screen_image' => array(
      'name' => t('Digital Screen Image'),
      'base' => 'node_content',
      'description' => '',
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  drupal_alter('node_info', $items);
  return $items;
}

/**
 * Implements hook_paragraphs_info().
 */
function digital_screen_feature_paragraphs_info() {
  $items = array(
    'ding_digital_screen_carousel' => array(
      'name' => 'Ding Digital Screen Carousel',
      'bundle' => 'ding_digital_screen_carousel',
      'locked' => '1',
    ),
  );
  return $items;
}
