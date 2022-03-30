<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function latest_posts_block_fe() { // phpcs:ignore
	// Styles.
	wp_enqueue_style(
		'latest-posts-block-style', // Handle.
		plugins_url( '/latest-posts-block/dist/block.style.build.css', dirname( __FILE__ ) ),
		array( 'wp-editor' )
	);
}

// Hook: Frontend assets.
add_action( 'enqueue_block_assets', 'latest_posts_block_fe' );

function latest_posts_block_editor_assets() { // phpcs:ignore
	// Scripts.
	wp_enqueue_script(
		'latest-posts-block-js', // Handle.
		plugins_url( '/latest-posts-block/dist/block.build.js', dirname( __FILE__ ) ), // Block.build.js: We register the block here. Built with Webpack.
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-api' ), // Dependencies, defined above.
		true // Enqueue the script in the footer.
	);

	// Styles.
	wp_enqueue_style(
		'latest-posts-block-editor', // Handle.
		plugins_url( '/latest-posts-block/dist/block.editor.build.css', dirname( __FILE__ ) ), // Block editor CSS.
		array( 'wp-edit-blocks' ) // Dependency to include the CSS after it.
	);
}

// Hook: Editor assets.
add_action( 'enqueue_block_editor_assets', 'latest_posts_block_editor_assets' );

//require php server side rendering for front end
require_once('src/block.php');
