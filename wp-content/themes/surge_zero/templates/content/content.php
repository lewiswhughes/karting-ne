<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php	the_title( '<h2 class="entry-title">', '</h2>' );	?>

	<div class="post-image">
		<?php
			if( has_post_thumbnail() ){
	      $url = get_the_post_thumbnail_url();
	      $post_thumbnail_id = get_post_thumbnail_id();
	      $srcset = wp_get_attachment_image_srcset( $post_thumbnail_id );
			} else {
				$url = get_template_directory_uri().'/assets/images/karts.jpg';
				$srcset = '';
			}
	    echo '<img src="'.$url.'" srcset="'.$srcset.'" class="featured-image" />';
    ?>
	</div>

  <div class="content">
		<?= limit_text( get_the_excerpt(), 50 ); ?>
		<a class="read-more" href="<?= get_the_permalink(); ?>">Read more</a>
		<hr />
	</div>


</article>
