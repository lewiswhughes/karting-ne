<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function svg_block_fe() { // phpcs:ignore
	// Styles.
	wp_enqueue_style(
		'svg-block-style', // Handle.
		plugins_url( '/svg-block/dist/block.style.build.css', dirname( __FILE__ ) ),
		array( 'wp-editor' )
	);
}

// Hook: Frontend assets.
add_action( 'enqueue_block_assets', 'svg_block_fe' );

function svg_block_editor_assets() { // phpcs:ignore
	// Scripts.
	wp_enqueue_script(
		'svg-block-js', // Handle.
		plugins_url( '/svg-block/dist/block.build.js', dirname( __FILE__ ) ), // Block.build.js: We register the block here. Built with Webpack.
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-api' ), // Dependencies, defined above.
		// filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: File modification time.
		true // Enqueue the script in the footer.
	);

	// Styles.
	wp_enqueue_style(
		'svg-block-editor', // Handle.
		plugins_url( '/svg-block/dist/block.editor.build.css', dirname( __FILE__ ) ), // Block editor CSS.
		array( 'wp-edit-blocks' ) // Dependency to include the CSS after it.
		// filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: File modification time.
	);
}

// Hook: Editor assets.
add_action( 'enqueue_block_editor_assets', 'svg_block_editor_assets' );
