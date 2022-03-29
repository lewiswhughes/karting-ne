<?php

$activities_array = array(
  array(
    'label' => 'Race',
    'url' => '/karting/#race-events',
    'icon' => 'race'
  ),
  array(
    'label' => 'Timed',
    'url' => '/karting/#timed-sessions',
    'icon' => 'timed'
  ),
  array(
    'label' => 'Family',
    'url' => '/karting/#family-events',
    'icon' => 'family'
  ),
  array(
    'label' => 'Other Events',
    'url' => '/other-events/',
    'icon' => 'other-events'
  )
)
?>

<div class="activity_icons">

  <?php
  foreach( $activities_array as $activity ){
  ?>

    <a href="<?= $activity['url']; ?>" class="activity_button">
      <?= ($activity['flag']) ? '<div class="flag">'.$activity['flag'].'</div>' : '' ; ?>
      <div class="icon"><?php get_template_part('/templates/icons/'.$activity['icon']); ?></div>
    </a>

  <?php
  }
  ?>

  <a href="/booking-start" class="book-now">
    <div class="icon">
      <span>Book Now</span>
    </div>
  </a>

</div>