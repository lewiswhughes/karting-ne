<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
    <a href="javascript:history.back()">&lt;&lt; Back to News</a>
		<h2><?= get_the_title(); ?></h2>
    <p class="date_author"><?= get_the_date().' - '.get_author_name(); ?></p>
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
    <?= the_content(); ?>
	</div><!-- .entry-content -->
</article><!-- #post-${ID} -->
