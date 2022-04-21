<?php

/**
 * @file
 * Digital service page.
 */

use OpenSearch\OpenSearchTingObjectCollection;

/**
 * Class DigitalScreenPage.
 */
class DigitalScreenPage {
  public $id;

  /**
   * DigitalScreenPage constructor.
   *
   * @param string $id
   *   Id off the Digital Service Page.
   */
  public function __construct(string $id) {
    $this->id = $id;
  }

  /**
   * Renders the page.
   * 
   * @return string $html
   *   The html for the page.
   */
  public function renderPage() {
    // Handle cached page
    $page = '';
    $carousels = $this->handleCarousels();
    foreach ($carousels as $carousel) {
      $page .= $carousel;
    }
    return $page;
  }

  /**
   *Handles Caraousels.
   * 
   */
  private function handleCarousels() {
    $results = [];
    $this->prepare_directories();
    $page = ding_digital_screen_get_page($this->id);
    $carousels = $page->field_dds_carousels->value();
    // Get to each fieldcollection.
    foreach ($carousels as $carousel) {
      $results[] = $this->handleCarousel($carousel);
    }
    file_put_contents("/var/www/drupalvm/drupal/web/debug/screen9.txt", print_r($carousels, TRUE), FILE_APPEND);
    return $results;
  }

  /**
   *Handles Carousels.
   * 
   */
  private function handleCarousel($carousel) {
    $items  = [];
    $carousel_entity = entity_metadata_wrapper('paragraphs_item', $carousel);
    file_put_contents("/var/www/drupalvm/drupal/web/debug/car1.txt", print_r($carousel_entity, TRUE), FILE_APPEND);
    $title = $carousel_entity->field_ds_title->value();
    $query = $carousel_entity->field_search->value();
    $rotate = $carousel_entity->field_rotate->value();
    $number_of_objects = $carousel_entity->field_number_of_posts->value();
    if (!$rotate) {
      $items = $this->getObjects($query);
    } else {
      $items  = $this->getObjectsWithRotation($query, $number_of_objects);
    }
    file_put_contents("/var/www/drupalvm/drupal/web/debug/car2.txt", print_r($title, TRUE), FILE_APPEND);
    $carousel = $this->createCarousel($items, $title);
    file_put_contents("/var/www/drupalvm/drupal/web/debug/items3.txt", print_r($carousel, TRUE), FILE_APPEND);
    return $carousel; 
  }

    /**
   *Handles Caraousels.
   * 
   */
  private function getObjects($query) {
    $items = [];
    $objects = $this->search($query, 1, 50);
    $covers = $this->get_covers($objects);
    $objects_per_carousel = variable_get('$objects_per_carousel', 16);
    $found_covers = array_slice($covers, 0, $objects_per_carousel);
    file_put_contents("/var/www/drupalvm/drupal/web/debug/car4.txt", print_r($objects, TRUE), FILE_APPEND);
    file_put_contents("/var/www/drupalvm/drupal/web/debug/car6.txt", print_r($covers, TRUE), FILE_APPEND);

    foreach ($found_covers as $objectId => $cover) {
      $path = $this->object_path($objectId);
      file_unmanaged_copy($cover, $path, FILE_EXISTS_REPLACE); 
      $this->create_cr($objectId);
      $items[] = $this->createItem($objectId);
      // TODO cache objectdata
    }
    file_put_contents("/var/www/drupalvm/drupal/web/debug/items1.txt", print_r($items, TRUE), FILE_APPEND);
    return $items;
  }

  /**
   *Handles Caraousels.
   * 
   */
  private function getObjectsWithRotation($query, $number_of_objects) {
    $results = [];
    return $results;
  }

  /**
   * Find ting entities from a query.
   *
   * @param string $query
   *   Query to use.
   * @param int $start
   *   Offset to start from.
   * @param int $size
   *   Search chunk size to use.
   *
   * @return array
   *   Array of found ting entities (an array).
   */
  function search($query, $start, $size) {
    $finished = FALSE;
    $entities = [];

    $cqlDoctor = new TingSearchCqlDoctor($query);

    $sal_query = ting_start_query()
      ->withRawQuery($cqlDoctor->string_to_cql())
      ->withPage($start)
      ->withCount($size)
      ->withPopulateCollections(FALSE);

    $sal_query->reply_only = true;
    $results = $sal_query->execute();

    if (!$results->hasMoreResults()) {
      $finished = TRUE;
    }

    foreach ($results->openSearchResult->collections as $collection) {
      $object = $collection->getPrimary_object();
      $entities[$object->getId()] = $object;
    }
    return $entities;
  }

  function createCarousel($items, $title) {
    $carousel = [
      '#type' => 'ding_carousel',
      '#title' => $title,
      //'#path' => 'ting_smart_carousel/results/ajax/' . urlencode($query),
      '#items' => $items,
      '#offset' => -1,
      // Add a single placeholder to fetch more content later if there is more
      // content.
      '#placeholders' => 1,
    ];

    return drupal_render($carousel );
  }





  function createItem($objectId) {
    $item = new DigitalScreenObject();
    $item->cover = $this->getCoverImage($objectId); 
    $item->qr = $this->getQrImage($objectId);

    return theme('ding_digital_screen_item', ['item' => $item]);
  }

  function getQrImage($objectId) {
    $path = $this->qr_path($objectId);
    return theme('image', ['path' => $path]);
  }
  
  function getCoverImage($objectId) {
    $url = 'digital/screen/' . $this->id . '/object/' . $objectId;
    $path = $this->object_path($objectId);

    $params = ['style_name' => 'ting_search_carousel', 'path' => $path];
    $image = theme('image_style', $params);

    $options = array(
      'html' => TRUE,
    );
    return l($image, $url, $options);
  }

  // function ting_smart_carousel_get_creators($object) {
  //   if (count($object->getCreators())) {
  //     if ($object->getDate()!= '') {
  //       $markup_string = t('By !author_link (@year)', array(
  //           '!author_link' => implode(', ', $object->getCreators()),
  //           // So wrong, but appears to be the way the data is.
  //           '@year' => $object->getDate(),
  //       ));
  //     } else {
  //       $markup_string = t('By !author_link', array(
  //           '!author_link' => implode(', ', $object->getCreators()),
  //       ));
  //     }
  //   } elseif ($object->getDate() != '') {
  //     $markup_string = t('(@year)', array('@year' => $object->getDate()));
  //   }
  //   return $markup_string;
  // }
  
  // function ting_smart_carousel_uri($object) {
  //   return 'ting/collection/' . $object->id;
  // }
  
  
  /**
   * Get covers for an array of ids.
   *
   * @param array $requested_covers
   *   Ids of entities to return covers for.
   *
   * @return array
   *   Array of id => file path for found covers.
   */
  function get_covers(array $requested_covers) {
    $entities = array();
    $covers = array();
  
    // Create array of loaded entities for passing to hooks.
    foreach ($requested_covers as $id => $object) {
      // Ensure that the id at least seems valid.
      if (!mb_check_encoding($id, "UTF-8")) {
        continue;
      }
  
      // If we we already have a valid cover image, use it.
      $path = ting_covers_object_path($id);
      if (file_exists($path)) {
        $covers[$id] = $path;
        continue;
      }
  
      // Queue for fetching by hook.
      $entities[$id] = ''; 
    }

    // Fetch covers by calling hook.
    foreach (module_implements('ting_covers') as $module) {
      //file_put_contents("/var/www/drupalvm/drupal/web/debug/car8.txt", print_r($module, TRUE), FILE_APPEND);
      foreach (module_invoke($module, 'ting_covers', $entities) as $id => $uri) {
        if ($uri && $path = _ting_covers_get_file($id, $uri)) {
          $covers[$id] = $path;
        }
        // Remove elements where a cover has been found, or suppressed.
        unset($entities[$id]);
      }
    }
    return $covers;
  }

  function create_cr($object_id) {
    $path = $this->qr_path($object_id);
    $url = url('ting/object/' . $object_id, ['absolute' => TRUE]);
    QRcode::png($url, $path); 
  }

  function object_path($object_id) {
    return file_default_scheme() . '://digital_screen_images' . DIRECTORY_SEPARATOR . 'covers' . DIRECTORY_SEPARATOR . $this->id . DIRECTORY_SEPARATOR . base64_encode($object_id) . '.jpg';
  }

  function qr_path($object_id) {
    return file_default_scheme() . '://digital_screen_images' . DIRECTORY_SEPARATOR . 'covers' . DIRECTORY_SEPARATOR . $this->id . DIRECTORY_SEPARATOR . 'qr' . base64_encode($object_id) . '.jpg';
  }

  function prepare_directories() {
    $path = file_default_scheme() . '://digital_screen_images';
    file_prepare_directory($path, FILE_CREATE_DIRECTORY | FILE_MODIFY_PERMISSIONS);
    $path .= DIRECTORY_SEPARATOR . 'covers';
    file_prepare_directory($path, FILE_CREATE_DIRECTORY | FILE_MODIFY_PERMISSIONS);
    $path .= DIRECTORY_SEPARATOR . $this->id;
    file_unmanaged_delete_recursive($path);
    file_prepare_directory($path, FILE_CREATE_DIRECTORY | FILE_MODIFY_PERMISSIONS);
  }
  
}
