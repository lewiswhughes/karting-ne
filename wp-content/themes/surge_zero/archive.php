<section class="page-title-cont">
	<h1 class="page_header">KNE News</h1>
</section>

<section class="posts-container">
	<h2><?= get_queried_object()->name; ?> </h2>

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
