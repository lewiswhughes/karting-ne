<?php

function custom_post_type_track() {

// Set UI labels for Custom Post Type
	$labels = array(
		'name'                => _x( 'Tracks', 'Post Type General Name', 'Surge Zero'),
		'singular_name'       => _x( 'Track', 'Post Type Singular Name', 'Surge Zero'),
		'menu_name'           => __( 'Tracks', 'Surge Zero'),
		'parent_item_colon'   => __( 'Tracks', 'Surge Zero'),
		'all_items'           => __( 'All Tracks', 'Surge Zero'),
		'view_item'           => __( 'View Track', 'Surge Zero'),
		'add_new_item'        => __( 'Add New Track', 'Surge Zero'),
		'add_new'             => __( 'Add New', 'Surge Zero'),
		'edit_item'           => __( 'Edit Track', 'Surge Zero'),
		'update_item'         => __( 'Update Track', 'Surge Zero'),
		'search_items'        => __( 'Search Tracks', 'Surge Zero'),
		'not_found'           => __( 'Not Found', 'Surge Zero'),
		'not_found_in_trash'  => __( 'Not found in Bin', 'Surge Zero'),
	);

// Set other options for Custom Post Type
	$args = array(
		'label'               => __( 'Your Tracks', 'Surge Zero'),
		'description'         => __( 'Your Tracks', 'Surge Zero'),
		'labels'              => $labels,
		'show_in_rest'				=> true,
		// You can associate this CPT with a taxonomy or custom taxonomy.
		//'taxonomies'          => array( 'genres' ),
		/* A hierarchical CPT is like Pages and can have
		* Parent and child items. A non-hierarchical CPT
		* is like Posts.
		*/
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'query_var' 		      => false,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_icon'           => 'dashicons-editor-unlink',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);

	// Registering your Custom Post Type
	register_post_type( 'track', $args );
}
/* Hook into the 'init' action so that the function
* Containing our post type registration is not
* unnecessarily executed.
*/
add_action( 'init', 'custom_post_type_track', 0 );


function custom_post_type_offers() {

// Set UI labels for Custom Post Type
	$labels = array(
		'name'                => _x( 'Offers', 'Post Type General Name', 'Surge Zero'),
		'singular_name'       => _x( 'Offer', 'Post Type Singular Name', 'Surge Zero'),
		'menu_name'           => __( 'Offers', 'Surge Zero'),
		'parent_item_colon'   => __( 'Offers', 'Surge Zero'),
		'all_items'           => __( 'All Offers', 'Surge Zero'),
		'view_item'           => __( 'View Offer', 'Surge Zero'),
		'add_new_item'        => __( 'Add New Offer', 'Surge Zero'),
		'add_new'             => __( 'Add New', 'Surge Zero'),
		'edit_item'           => __( 'Edit Offer', 'Surge Zero'),
		'update_item'         => __( 'Update Offer', 'Surge Zero'),
		'search_items'        => __( 'Search Offers', 'Surge Zero'),
		'not_found'           => __( 'Not Found', 'Surge Zero'),
		'not_found_in_trash'  => __( 'Not found in Bin', 'Surge Zero'),
	);

// Set other options for Custom Post Type
	$args = array(
		'label'               => __( 'Your Offers', 'Surge Zero'),
		'description'         => __( 'Your Offers', 'Surge Zero'),
		'labels'              => $labels,
		'show_in_rest'				=> true,
		// You can associate this CPT with a taxonomy or custom taxonomy.
		//'taxonomies'          => array( 'genres' ),
		/* A hierarchical CPT is like Pages and can have
		* Parent and child items. A non-hierarchical CPT
		* is like Posts.
		*/
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'query_var' 		      => false,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_icon'           => 'dashicons-carrot',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);

	// Registering your Custom Post Type
	register_post_type( 'offer', $args );
}
/* Hook into the 'init' action so that the function
* Containing our post type registration is not
* unnecessarily executed.
*/
add_action( 'init', 'custom_post_type_offers', 0 );


function custom_post_type_basket_logs() {

// Set UI labels for Custom Post Type
	$labels = array(
		'name'                => _x( 'Basket Logs', 'Post Type General Name', 'Surge Zero'),
		'singular_name'       => _x( 'Basket Log', 'Post Type Singular Name', 'Surge Zero'),
		'menu_name'           => __( 'Basket Logs', 'Surge Zero'),
		'parent_item_colon'   => __( 'Basket Logs', 'Surge Zero'),
		'all_items'           => __( 'All Basket Logs', 'Surge Zero'),
		'view_item'           => __( 'View Basket Log', 'Surge Zero'),
		'add_new_item'        => __( 'Add New Basket Log', 'Surge Zero'),
		'add_new'             => __( 'Add New', 'Surge Zero'),
		'edit_item'           => __( 'Edit Basket Log', 'Surge Zero'),
		'update_item'         => __( 'Update Basket Log', 'Surge Zero'),
		'search_items'        => __( 'Search Basket Logs', 'Surge Zero'),
		'not_found'           => __( 'Not Found', 'Surge Zero'),
		'not_found_in_trash'  => __( 'Not found in Bin', 'Surge Zero'),
	);

// Set other options for Custom Post Type
	$args = array(
		'label'               => __( 'Basket Logs', 'Surge Zero'),
		'description'         => __( 'Basket Logs', 'Surge Zero'),
		'labels'              => $labels,
		'show_in_rest'				=> true,
		// You can associate this CPT with a taxonomy or custom taxonomy.
		//'taxonomies'          => array( 'genres' ),
		/* A hierarchical CPT is like Pages and can have
		* Parent and child items. A non-hierarchical CPT
		* is like Posts.
		*/
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'query_var' 		      => false,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_icon'           => 'dashicons-cart',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);

	// Registering your Custom Post Type
	register_post_type( 'basket_logs', $args );
}
/* Hook into the 'init' action so that the function
* Containing our post type registration is not
* unnecessarily executed.
*/
add_action( 'init', 'custom_post_type_basket_logs', 0 );

?>
