<section class="page-title-cont">
	<h1 class="page_header">KNE News</h1>
</section>

<section class="post-container">
	<main>
		<?php
  		/* Start the Loop */
  		while ( have_posts() ) :
  			the_post();
  			get_template_part( 'templates/content/content', 'single' );

  		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</section><!-- #primary -->
