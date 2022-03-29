<?php
/*
Contact Us Page Template
*/

?>

<?php
$show_60_days_text = false;
if (isset($_GET['booking_over_60_days_in_future'])) {
  if ($_GET['booking_over_60_days_in_future']) {
    $show_60_days_text = true;
  }
}
?>

<section class="page-title-cont">
	<h1 class="page_header"><?= get_the_title(); ?></h1>
</section>

<?php if ($show_60_days_text) { ?>
<section class="booking_advice">
  <div>
    <div class="message_inner">
      <?= get_field('sixty_days_booking_advice'); ?>
    </div>
  </div>
</section>
<?php } ?>

<?php
  /* Start the Loop */
  while ( have_posts() ) :
  	the_post();
  	get_template_part( 'templates/content/content', 'page' );
  endwhile; // End of the loop.
?>
