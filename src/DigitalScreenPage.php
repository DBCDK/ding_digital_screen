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
  public function renderPage(bool $useCache = true) {
    $output = [];
    $cache = cache_get($this->id, 'cache_digital_screen_pages');
    file_put_contents("/var/www/drupalvm/drupal/web/debug/object4.txt", print_r($cache->data, TRUE), FILE_APPEND);
    if (!$cache || !$useCache) {
      $carousels = $this->handleCarousels();
      cache_set($this->id, $carousels, 'cache_digital_screen_pages');
      file_put_contents("/var/www/drupalvm/drupal/web/debug/object3.txt", print_r($carousels, TRUE), FILE_APPEND);
    } else {
      $carousels = $cache->data;
    }
    foreach ($carousels as $title => $carousel) {
      $output[$title] = drupal_render($carousel);
    }
    file_put_contents("/var/www/drupalvm/drupal/web/debug/object5.txt", print_r($output, TRUE), FILE_APPEND);
    return theme('ding_digital_screen_main', ['carousels' => $output ]);
  }

  /**
   * Renders the object.
   * 
   * @return string $html
   *   The html for the page.
   */
  public function renderObject($objectId) {
    $cacheId = $this->createObjectCacheId($objectId);
    $object =  cache_get($cacheId, 'cache_digital_screen_objects');
    if (!$object) {
      $this->handleCarousels();
      $object =  cache_get($cacheId, 'cache_digital_screen_objects');
      //file_put_contents("/var/www/drupalvm/drupal/web/debug/object3.txt", print_r($object, TRUE), FILE_APPEND);
    }
    //file_put_contents("/var/www/drupalvm/drupal/web/debug/object2.txt", print_r($object, TRUE), FILE_APPEND);
    $page = theme('ding_digital_screen_object', ['object' => $object->data]);
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
      $result = $this->handleCarousel($carousel);
      $results[$result['title']] = $result['carousel'];
    }
    //file_put_contents("/var/www/drupalvm/drupal/web/debug/screen9.txt", print_r($carousels, TRUE), FILE_APPEND);
    return $results;
  }

  /**
   *Handles Carousels.
   * 
   */
  private function handleCarousel($carousel) {
    $items  = [];
    $carousel_entity = entity_metadata_wrapper('paragraphs_item', $carousel);
    //file_put_contents("/var/www/drupalvm/drupal/web/debug/car1.txt", print_r($carousel_entity, TRUE), FILE_APPEND);
    $title = $carousel_entity->field_ds_title->value();
    $query = $carousel_entity->field_search->value();
    $rotate = $carousel_entity->field_rotate->value();
    $number_of_objects = $carousel_entity->field_number_of_posts->value();
    if (!$rotate) {
      $items = $this->getObjects($query);
    } else {
      $items  = $this->getObjectsWithRotation($query, $number_of_objects);
    }
    $carousel = $this->createCarousel($items, $title);

    foreach ($items as $item) {
      $item->carousel = $carousel;
      //file_put_contents("/var/www/drupalvm/drupal/web/debug/object1.txt", print_r($item, TRUE), FILE_APPEND);
      $cacheId = $this->createObjectCacheId($item->objectid);
      cache_set($cacheId, $item, 'cache_digital_screen_objects');
    }

    return ['carousel' => $carousel, 'title' => $title]; 
  }

    /**
   *Handles Caraousels.
   * 
   */
  private function getObjects($query) { 
    $objects = $this->search($query, 1, 50);
    $covers = $this->get_covers($objects);
    file_put_contents("/var/www/drupalvm/drupal/web/debug/items1.txt", print_r($objects, TRUE), FILE_APPEND);
    return $this->handleCovers($covers, $objects);
  }

  /**
   *Handles Caraousels.
   * 
   */
  private function getObjectsWithRotation($query, $number_of_objects) {
    $objects = [];
    $objects_retrieved = 0;
    $page = 1;
    while ($objects_retrieved < $number_of_objects) {
      $results = $this->search($query, $page, 50);
      //file_put_contents("/var/www/drupalvm/drupal/web/debug/rot3.txt", print_r($results , TRUE), FILE_APPEND);
      foreach ($results as $key => $object) {
        $objects[$key] =  $object;
      }
      $objects_retrieved += 50;
      $page++;
    }
    
    //file_put_contents("/var/www/drupalvm/drupal/web/debug/rot1.txt", print_r($objects , TRUE), FILE_APPEND);
    $covers = $this->get_covers($objects);
    $covers = $this->shuffle_assoc($covers);
    return $this->handleCovers($covers, $objects);
  }

  /**
   *Handles Caraousels.
   * 
   */
  private function shuffle_assoc($list) { 
    if (!is_array($list)) return $list; 
  
    $keys = array_keys($list); 
    shuffle($keys); 
    $random = array(); 
    foreach ($keys as $key) { 
      $random[$key] = $list[$key]; 
    }
    return $random; 
  } 

     /**
   *Handles Caraousels.
   * 
   */
  private function handleCovers($covers, $objects) {
    $items = [];
    $objects_per_carousel = variable_get('$objects_per_carousel', 16);
    $found_covers = array_slice($covers, 0, $objects_per_carousel);
    //file_put_contents("/var/www/drupalvm/drupal/web/debug/car4.txt", print_r($objects, TRUE), FILE_APPEND);
    //file_put_contents("/var/www/drupalvm/drupal/web/debug/car6.txt", print_r($covers, TRUE), FILE_APPEND);

    foreach ($found_covers as $objectId => $cover) {
      $path = $this->object_path($objectId);
      file_unmanaged_copy($cover, $path, FILE_EXISTS_REPLACE);
      $this->create_cr($objectId);
      $items[] = $this->createItem($objectId, $objects[$objectId]);
    }
    return $items;
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
    $render_items = [];
    foreach ($items as $item) {
      $render_items[] = theme('ding_digital_screen_item', ['item' => $item]);
    }
    $carousel = [
      '#type' => 'ding_carousel',
      '#title' => $title,
      '#items' => $render_items,
      '#offset' => 1,
      // Add a single placeholder to fetch more content later if there is more
      // content.
      '#placeholders' => -1,
    ];

    return $carousel;
  }


  function createItem($objectId, $object) {
    //file_put_contents("/var/www/drupalvm/drupal/web/debug/items2.txt", print_r($object, TRUE), FILE_APPEND);
    $item = new DigitalScreenObject();
    $item->objectid = $objectId;
    $item->cover = $this->getCoverImage($objectId, 'ting_search_carousel');
    $item->bigCover = $this->getCoverImage($objectId, 'ding_digital_screen_large'); 
    $item->qr = $this->getQrImage($objectId);
    $item->title = $this->getTitle($object);
    $item->creators = $this->get_creators($object);
    $item->abstract = $object->getAbstract();
    $item->series = $this->getSeries($object);
    $item->type =$object->getType();
    //file_put_contents("/var/www/drupalvm/drupal/web/debug/items3.txt", print_r($item , TRUE), FILE_APPEND);
    return $item; 
  }

  function getTitle($object) {
    $title = $object->getTitle();
    $languge = $object->getLanguage();
    return $title . '(' . $languge . ')';
  }

  function getSeries($object) {
    if (!empty($object->getSeriesTitles())) {
      //file_put_contents("/var/www/drupalvm/drupal/web/debug/items4.txt", print_r($object->getSeriesTitles(), TRUE), FILE_APPEND);
      $series = $object->getSeriesTitles()[0];
      $series_title = $series[0];
      if (isset($series[1])) {
        $series_title .= '; ' . $series[1];
      }
      return $series_title;
    } else if ($object->getSerieDescription()) {
      return $object->getSerieDescription();
    }
    return null;
  }

  function createObject($objectId, $object, $item) {

    return theme('ding_digital_screen_item', ['item' => $item]);
  }

  function getQrImage($objectId) {
    $path = $this->qr_path($objectId);
    $var = [
      'path' => $path,
      'attributes' => ['class' => 'digital-screen-qr-image'],
    ];
    return theme('image', $var);
  }
  
  function getCoverImage($objectId, $style) {
    $url = 'digital/screen/' . $this->id . '/object/' . $objectId;
    $path = $this->object_path($objectId);

    $params = ['style_name' => $style, 'path' => $path];
    $image = theme('image_style', $params);

    $options = array(
      'html' => TRUE,
    );
    return l($image, $url, $options);
  }

  function get_creators($object) {
    if (count($object->getCreators())) {
      if ($object->getDate()!= '') {
        $markup_string = t('By !author_link (@year)', array(
            '!author_link' => implode(', ', $object->getCreators()),
            // So wrong, but appears to be the way the data is.
            '@year' => $object->getDate(),
        ));
      } else {
        $markup_string = t('By !author_link', array(
            '!author_link' => implode(', ', $object->getCreators()),
        ));
      }
    } elseif ($object->getDate() != '') {
      $markup_string = t('(@year)', array('@year' => $object->getDate()));
    }
    return $markup_string;
  }
  
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
      $local_cover = $this->check_uploadet_cover($object->getLocalId());
      if (!(empty($local_cover))) {
        $covers[$id] = $local_cover[0];
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

  function check_uploadet_cover($id) {
    $path = file_default_scheme() . '://digital_screen_images/' . $id . '.*';
    return glob (drupal_realpath($path));
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

  /**
   *Handles Caraousels.
   * 
   */
  private function createObjectCacheId($object_id) {
    return 'object-' . $this->id . '-' . $object_id;
  }
  
}
