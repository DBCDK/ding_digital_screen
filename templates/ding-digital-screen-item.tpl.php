
<?php
/**
 * @file
 * The initial react code
 * 
 *
 */
?>

<?php if ($item) : ?>
  <li class="digital-screen-item">
    <div class="digital-screen-object-cover">
      <?php print $item->cover ?>
    </div>
    <div class="digital-screen-qr">
      <?php print $item->qr ?>
    </div>
  </li>
<?php endif; ?>
