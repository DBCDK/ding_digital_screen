<?php
/**
 * @file
 * digital_screen_feature.features.field_instance.inc
 */

/**
 * Implements hook_field_default_field_instances().
 */
function digital_screen_feature_field_default_field_instances() {
  $field_instances = array();

  // Exported field_instance:
  // 'digital_screen_page-digital_screen_page-field_dds_carousels'.
  $field_instances['digital_screen_page-digital_screen_page-field_dds_carousels'] = array(
    'bundle' => 'digital_screen_page',
    'default_value' => NULL,
    'deleted' => 0,
    'description' => '',
    'display' => array(
      'default' => array(
        'label' => 'above',
        'module' => 'paragraphs',
        'settings' => array(
          'view_mode' => 'full',
        ),
        'type' => 'paragraphs_view',
        'weight' => 1,
      ),
      'teaser' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => 0,
      ),
    ),
    'entity_type' => 'digital_screen_page',
    'field_name' => 'field_dds_carousels',
    'label' => 'Karruseller',
    'required' => 0,
    'settings' => array(
      'add_mode' => 'button',
      'allowed_bundles' => array(
        'custom_boost_values' => -1,
        'ding_digital_screen_carousel' => 'ding_digital_screen_carousel',
        'ding_paragraphs_carousel' => -1,
        'ding_paragraphs_image' => -1,
        'ding_paragraphs_image_and_text' => -1,
        'ding_paragraphs_material_list' => -1,
        'ding_paragraphs_single_material' => -1,
        'ding_paragraphs_text' => -1,
        'ding_paragraphs_text_box' => -1,
      ),
      'bundle_weights' => array(
        'custom_boost_values' => 2,
        'ding_digital_screen_carousel' => 3,
        'ding_paragraphs_carousel' => 4,
        'ding_paragraphs_image' => 5,
        'ding_paragraphs_image_and_text' => 6,
        'ding_paragraphs_material_list' => 7,
        'ding_paragraphs_single_material' => 8,
        'ding_paragraphs_text' => 9,
        'ding_paragraphs_text_box' => 10,
      ),
      'default_edit_mode' => 'open',
      'title' => 'Karrusel',
      'title_multiple' => 'karruseller',
      'user_register_form' => FALSE,
    ),
    'widget' => array(
      'active' => 0,
      'module' => 'paragraphs',
      'settings' => array(),
      'type' => 'paragraphs_embed',
      'weight' => 32,
    ),
  );

  // Exported field_instance: 'node-digital_screen_image-field_ds_image'.
  $field_instances['node-digital_screen_image-field_ds_image'] = array(
    'bundle' => 'digital_screen_image',
    'deleted' => 0,
    'description' => 'Tilføj billede. Navngiv billedet med faustnr. Og det skal enten være af typen png eller jpeg.',
    'display' => array(
      'alternative_layout_full' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => 0,
      ),
      'default' => array(
        'label' => 'above',
        'module' => 'image',
        'settings' => array(
          'image_link' => '',
          'image_style' => '',
        ),
        'type' => 'image',
        'weight' => 0,
      ),
      'teaser' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => 0,
      ),
      'teaser_highlight' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => 0,
      ),
      'teaser_no_overlay' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => 0,
      ),
    ),
    'entity_type' => 'node',
    'field_name' => 'field_ds_image',
    'label' => 'Image',
    'required' => 0,
    'settings' => array(
      'alt_field' => 0,
      'default_image' => 0,
      'file_directory' => 'digital_screen_images',
      'file_extensions' => 'png gif jpg jpeg',
      'max_filesize' => '',
      'max_resolution' => '',
      'min_resolution' => '',
      'title_field' => 0,
      'user_register_form' => FALSE,
    ),
    'widget' => array(
      'active' => 1,
      'module' => 'media',
      'settings' => array(
        'allowed_schemes' => array(
          'oembed' => 0,
          'public' => 'public',
          'vimeo' => 0,
          'youtube' => 0,
        ),
        'allowed_types' => array(
          'audio' => 0,
          'document' => 0,
          'image' => 'image',
          'video' => 0,
        ),
        'browser_plugins' => array(
          'ding_content' => 0,
          'media_default--media_browser_1' => 0,
          'media_default--media_browser_my_files' => 0,
          'media_internet' => 0,
          'upload' => 0,
        ),
        'manualcrop_crop_info' => 1,
        'manualcrop_default_crop_area' => 1,
        'manualcrop_enable' => 0,
        'manualcrop_inline_crop' => 0,
        'manualcrop_instant_crop' => FALSE,
        'manualcrop_instant_preview' => 1,
        'manualcrop_keyboard' => 1,
        'manualcrop_maximize_default_crop_area' => 0,
        'manualcrop_require_cropping' => array(),
        'manualcrop_styles_list' => array(),
        'manualcrop_styles_mode' => 'include',
        'manualcrop_thumblist' => 0,
      ),
      'type' => 'media_generic',
      'weight' => 41,
    ),
  );

  // Exported field_instance:
  // 'paragraphs_item-ding_digital_screen_carousel-field_ds_title'.
  $field_instances['paragraphs_item-ding_digital_screen_carousel-field_ds_title'] = array(
    'bundle' => 'ding_digital_screen_carousel',
    'default_value' => NULL,
    'deleted' => 0,
    'description' => '',
    'display' => array(
      'default' => array(
        'label' => 'above',
        'module' => 'text',
        'settings' => array(),
        'type' => 'text_default',
        'weight' => 3,
      ),
      'paragraphs_editor_preview' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => 0,
      ),
    ),
    'entity_type' => 'paragraphs_item',
    'field_name' => 'field_ds_title',
    'label' => 'Title',
    'required' => 1,
    'settings' => array(
      'text_processing' => 0,
      'user_register_form' => FALSE,
    ),
    'widget' => array(
      'active' => 1,
      'module' => 'text',
      'settings' => array(
        'size' => 60,
      ),
      'type' => 'text_textfield',
      'weight' => 0,
    ),
  );

  // Exported field_instance:
  // 'paragraphs_item-ding_digital_screen_carousel-field_number_of_posts'.
  $field_instances['paragraphs_item-ding_digital_screen_carousel-field_number_of_posts'] = array(
    'bundle' => 'ding_digital_screen_carousel',
    'default_value' => array(
      0 => array(
        'value' => 100,
      ),
    ),
    'deleted' => 0,
    'description' => 'Antal poster som skal søges frem for at rotere i mellem.',
    'display' => array(
      'default' => array(
        'label' => 'above',
        'module' => 'number',
        'settings' => array(
          'decimal_separator' => '.',
          'prefix_suffix' => TRUE,
          'scale' => 0,
          'thousand_separator' => '',
        ),
        'type' => 'number_integer',
        'weight' => 2,
      ),
      'paragraphs_editor_preview' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => 0,
      ),
    ),
    'entity_type' => 'paragraphs_item',
    'field_name' => 'field_number_of_posts',
    'label' => 'Number of posts',
    'required' => 0,
    'settings' => array(
      'max' => '',
      'min' => '',
      'prefix' => '',
      'suffix' => '',
      'user_register_form' => FALSE,
    ),
    'widget' => array(
      'active' => 0,
      'module' => 'number',
      'settings' => array(),
      'type' => 'number',
      'weight' => 3,
    ),
  );

  // Exported field_instance:
  // 'paragraphs_item-ding_digital_screen_carousel-field_rotate'.
  $field_instances['paragraphs_item-ding_digital_screen_carousel-field_rotate'] = array(
    'bundle' => 'ding_digital_screen_carousel',
    'default_value' => array(
      0 => array(
        'value' => 0,
      ),
    ),
    'deleted' => 0,
    'description' => 'Aktiver rotation af poster',
    'display' => array(
      'default' => array(
        'label' => 'above',
        'module' => 'list',
        'settings' => array(),
        'type' => 'list_default',
        'weight' => 1,
      ),
      'paragraphs_editor_preview' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => 0,
      ),
    ),
    'entity_type' => 'paragraphs_item',
    'field_name' => 'field_rotate',
    'label' => 'Rotate',
    'required' => 0,
    'settings' => array(
      'user_register_form' => FALSE,
    ),
    'widget' => array(
      'active' => 1,
      'module' => 'options',
      'settings' => array(
        'display_label' => 0,
      ),
      'type' => 'options_onoff',
      'weight' => 2,
    ),
  );

  // Exported field_instance:
  // 'paragraphs_item-ding_digital_screen_carousel-field_search'.
  $field_instances['paragraphs_item-ding_digital_screen_carousel-field_search'] = array(
    'bundle' => 'ding_digital_screen_carousel',
    'default_value' => NULL,
    'deleted' => 0,
    'description' => 'Den søgestreng som der søges efter.',
    'display' => array(
      'default' => array(
        'label' => 'above',
        'module' => 'text',
        'settings' => array(),
        'type' => 'text_default',
        'weight' => 0,
      ),
      'paragraphs_editor_preview' => array(
        'label' => 'above',
        'settings' => array(),
        'type' => 'hidden',
        'weight' => 0,
      ),
    ),
    'entity_type' => 'paragraphs_item',
    'field_name' => 'field_search',
    'label' => 'Search',
    'required' => 1,
    'settings' => array(
      'text_processing' => 0,
      'user_register_form' => FALSE,
    ),
    'widget' => array(
      'active' => 1,
      'module' => 'text',
      'settings' => array(
        'size' => 60,
      ),
      'type' => 'text_textfield',
      'weight' => 1,
    ),
  );

  // Translatables
  // Included for use with string extractors like potx.
  t('Aktiver rotation af poster');
  t('Antal poster som skal søges frem for at rotere i mellem.');
  t('Den søgestreng som der søges efter. Kan også være en liste af faustnurmre med mellemrum i mellem. F,eks. 61644113 62220449 osv.');
  t('Image');
  t('Karruseller');
  t('Number of posts');
  t('Rotate');
  t('Search');
  t('Tilføj billede. Navngiv billedet med faustnr. Og det skal enten være af typen png eller jpeg.');
  t('Title');

  return $field_instances;
}
