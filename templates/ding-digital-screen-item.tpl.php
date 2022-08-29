
<?php
/**
 * @file
 * Template for a carousel item.
 * 
 *
 */
?>
<?php if ($item) : ?>
    <div class="digital-screen-object-cover">
      <?php print $item->cover ?>
      <?php print $item->qr ?>
    </div>
<?php endif; ?>
