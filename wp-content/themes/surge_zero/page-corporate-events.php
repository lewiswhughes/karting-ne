<?php
/*
Corporate Events Page Template
*/

?>

<section class="page-title-cont">
	<h1 class="page_header"><?= get_the_title(); ?></h1>
</section>

<?php
  /* Start the Loop */
  while ( have_posts() ) :
  	the_post();
  	get_template_part( 'templates/content/content', 'page' );
  endwhile; // End of the loop.

  //contact form template
  get_template_part('/templates/forms/event-enquiry-form');
?>
