<section class="page-title-cont">
	<h1 class="page_header">KNE News</h1>
</section>

<section class="posts-container">
	<h2>What's going on?</h2>

	<!-- main container-->
	<main>
			<div>
			<?php
			if ( have_posts() ) {
				// Load posts loop.
				while ( have_posts() ) {
					the_post();
					get_template_part( 'templates/content/content' );
				}
			} else {
		    echo 'No posts found';
			}
			?>

			<div class="pagination-links">
				<?php previous_posts_link( '&lt;&lt; Newer posts' ); ?>
				<?php next_posts_link( 'Older posts &gt;&gt;' ); ?>
			</div>
		</div>

		<!--sidebar-->
		<div class="sidebar">
			<!--Categories-->
			<div class="category-cont">
				<label>Choose a category</label>
				<ul>
				<?=	wp_list_cats();	?>
				</ul>
			</div>
		</div>
	</main><!-- .site-main -->
</section><!-- .content-area -->
