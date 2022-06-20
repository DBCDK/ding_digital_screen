<?php

/**
 * @file
 * A loan status item.
 * 
 */
?>

<div class="digital-screen-object-page">
  <div class="digital-screen-object">

    <div class="digital-screen-object-container">
      <div class="digital-screen-object-page-cover">
        <?php print $object->bigCover ?>
      </div>

      <div class="digital-screen-object-content">
        <div class="digital-screen-object-content-top">
          <div class="digital-screen-all-object-type">
            <?php print $object->type ?>
          </div>
          <div class="digital-screen-object-title">
            <h2><?php print $object->title ?></h2>
          </div>
          <div class="digital-screen-object-creator">
            <?php print $object->creators ?>
          </div>
        </div>
        <div class="digital-screen-object-series">
          <?php print $object->series ?>
        </div>
        <div class="digital-screen-object-abstract">
          <?php print $object->abstract ?>
        </div>
        <div class="digital-screen-object-qr">
          <div class="digital-screen-object-qr-image-container">
            <?php print $object->qr ?>
          </div>
          <div class="digital-screen-object-qr-text">
            <h2>
            Scan koden</br>
            med din mobil</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="digital-screen-carousel">
      <hr>
      <?php print drupal_render($object->carousel) ?>
      <ul class="horisontal-dots">
            <li class="horisontal-dot horisontal-dot--1 active"></li>
            <li class="horisontal-dot horisontal-dot--2"></li>
            <li class="horisontal-dot horisontal-dot--3"></li>
            <li class="horisontal-dot horisontal-dot--4"></li>
          </ul>
    </div>

  </div>

  <div class="digital-screen-object-actions">
    <div class="digital-screen-object-return">
      <?php print $object->backArrow ?>
    </div>
    <div class="digital-screen-object-help">
      <?php print $object->info ?>
      <?php print $object->popup ?>
    </div>
  </div>
</div>