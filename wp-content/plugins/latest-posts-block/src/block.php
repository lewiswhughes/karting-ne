<?php
// block.php

function render_latest_posts( $attributes, $content ) {

    $post_content = '';

    $args = array(
      'post_type' => 'post',
      'posts_per_page' => 1
    );
    $posts_query = new WP_Query( $args );
    $posts = $posts_query->posts;

    foreach( $posts as $post ){
      $post_id = $post->ID;
      $post_content.='<h2 class="page_header light">'.$post->post_title.'</h2>';
      $post_content.='<div><p>'.get_the_excerpt( $post ).'</p><a class="tab_link" href="'.get_the_permalink( $post ).'">View Details</a></div>';
    }

    return '<section class="latest-posts">'.$post_content.'</section>';
}

register_block_type( 'surgems/latest-posts', array(
    'render_callback' => 'render_latest_posts',
) );
