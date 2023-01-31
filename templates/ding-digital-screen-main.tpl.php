<?php

/**
 * @file
 * Template for the main digital screen page.
 * 
 *
 */
?>

<div class="digital-screen-main">
<div class="digital-screen-object-help">
      <?php print $info ?>
      <?php print $popup ?>
    </div>
  <div class="digital-screen-content">
    <?php foreach ($carousels as $title => $carousel) : ?>
      <div class="digital-screen-carousel">
        <h2><?php print $title ?></h2>
        <?php print $carousel ?>
          <hr>
      </div>
    <?php endforeach; ?>
  </div>
</div>