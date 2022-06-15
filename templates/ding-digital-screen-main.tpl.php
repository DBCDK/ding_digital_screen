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
    <?php foreach ($carousels as $title => $carousel) : ?>
      <div class="digital-sceen-carousel">
        <h2><?php print $title ?></h2>
        <?php print $carousel ?>
          <ul class="horisontal-dots">
            <li class="horisontal-dot horisontal-dot--1 active"></li>
            <li class="horisontal-dot horisontal-dot--2"></li>
            <li class="horisontal-dot horisontal-dot--3"></li>
            <li class="horisontal-dot horisontal-dot--4"></li>
          </ul>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="digital-sceen-sidebar">
    <nav>
      <ul>
        <li class="dot dot--1"></li>
        <li class="dot dot--2"></li>
        <li class="dot dot--3"></li>
        <li class="dot dot--4"></li>
      </ul>
    </nav>
    <div class="digital-screen-object-help">
      <?php print $info ?>
    </div>
  </div>
</div>