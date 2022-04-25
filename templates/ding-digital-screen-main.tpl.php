
<?php
/**
 * @file
 * The initial react code
 * 
 *
 */
?>

<div class="digital-sceen-main">
  <div class="digital-sceen-content">
  <?php foreach($carousels as $title => $carousel): ?>
    <div class="digital-sceen-carousel">
      <h2><?php print $title ?></h2>
      <?php print $carousel?>
    </div>
    <?php endforeach; ?>
  </div>
  <div class="digital-sceen-sidebar">
  </div>
</div>

