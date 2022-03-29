<?php
//WRAPPER
//include page template wrapper class
require_once ('classes/wrapper.php');

//CUSTOM POST TYPES
require_once( 'includes/custom_post_types.php' );

//ACF SETUP
require_once( 'includes/acf_global_setup.php' );

//WOOCOMMERCE
//theme support
add_theme_support( 'woocommerce' );
//dequeue styles becoz they is minging
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
//remove cross-sells default display
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
//includes for woocommerce
require_once('includes/woocommerce/custom-cart-attributes.php');
require_once('includes/woocommerce/multi-add-to-cart-url.php');
require_once('includes/woocommerce/add-order-meta.php');
require_once('includes/woocommerce/order-status-changes.php');
require_once('includes/woocommerce/custom-discounts.php');
require_once('includes/woocommerce/custom-register-fields.php');
require_once('includes/woocommerce/modify-breadcrumb.php');
require_once('includes/woocommerce/basket-reminders.php');
//Checkout
// removes Order Notes Title - Additional Information
add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );
//Modify checkout fields
add_filter( 'woocommerce_checkout_fields' , 'remove_order_notes' );
function remove_order_notes( $fields ) {
  unset($fields['order']['order_comments']);
  return $fields;
}
//wc allowed password strength
add_filter( 'woocommerce_min_password_strength', 'reduce_min_strength_password_requirement' );
function reduce_min_strength_password_requirement( $strength ) {
    // 3 => Strong (default) | 2 => Medium | 1 => Weak | 0 => Very Weak (anything).
    return 1;
}
//my account nav items
add_filter ( 'woocommerce_account_menu_items', 'remove_my_account_links' );
function remove_my_account_links( $menu_links ){
	// unset( $menu_links['edit-address'] );
	unset( $menu_links['payment-methods'] );
	unset( $menu_links['downloads'] );
	return $menu_links;
}
//product hide unwanted info
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );


//ENQUEUE SCRIPTS AND STYLES
//enqueue main script
function kne_scripts() {
  $version_no = '1.1.01'; //version for cache busting
  //scripts
  wp_enqueue_script( 'index', get_template_directory_uri() . '/dist/index.js', null, $version_no, true);
  wp_enqueue_script( 'booking-index', get_template_directory_uri() . '/dist/booking~index.js', null, $version_no, true);
  wp_enqueue_script( 'vendors-booking-index', get_template_directory_uri() . '/dist/vendors~booking~index.js', null, $version_no, true);
  //booking pages
  if( is_page(array('booking','booking-start')) ){
    wp_enqueue_script( 'booking', get_template_directory_uri() . '/dist/booking.js', null, $version_no, true);
  }
  //styles
  if(! is_admin()){
    wp_enqueue_style( 'main', get_template_directory_uri() . '/dist/styles.css', null, $version_no, null);
  } else {
    wp_enqueue_style( 'editor', get_template_directory_uri() . '/dist/editor.css', false, null);
  }
}
add_action( 'wp_enqueue_scripts', 'kne_scripts' );

//init actions
add_action( 'init', 'woocommerce_clear_cart_url' );
function woocommerce_clear_cart_url() {
	if ( isset( $_GET['clear-cart'] ) ) {
		global $woocommerce;
		$woocommerce->cart->empty_cart();
	}
}


//CUSTOM COLOR PALETTE FOR EDITOR
function kne_gutenberg_color_palette() {
	add_theme_support(
		'editor-color-palette', array(
			array(
				'name'  => esc_html__( 'White', '@@textdomain' ),
				'slug' => 'white',
				'color' => '#fff',
			),
			array(
				'name'  => esc_html__( 'Yellow', '@@textdomain' ),
				'slug' => 'yellow',
				'color' => '#fc0',
			),
			array(
				'name'  => esc_html__( 'Red', '@@textdomain' ),
				'slug' => 'red',
				'color' => '#c01349',
			),
			array(
				'name'  => esc_html__( 'Off Black', '@@textdomain' ),
				'slug' => 'off-black',
				'color' => '#1d1d1b',
			),
			array(
				'name'  => esc_html__( 'Yellow Two', '@@textdomain' ),
				'slug' => 'yellow-two',
				'color' => '#f7a600',
			),
			array(
				'name'  => esc_html__( 'Grey One', '@@textdomain' ),
				'slug' => 'grey-one',
				'color' => '#575756',
			),
			array(
				'name'  => esc_html__( 'Grey Dark', '@@textdomain' ),
				'slug' => 'grey-dark',
				'color' => '#404038',
			),
			array(
				'name'  => esc_html__( 'Grey Mid', '@@textdomain' ),
				'slug' => 'grey-mid',
				'color' => '#acacab',
			),
			array(
				'name'  => esc_html__( 'Grey Light', '@@textdomain' ),
				'slug' => 'grey-light',
				'color' => '#efefed',
			)
		)
	);
}
add_action( 'after_setup_theme', 'kne_gutenberg_color_palette' );

//OTHER FUNCTIONS
include_once( 'includes/limit_text.php' );

//CUSTOM TABLE
global $wpdb;
$charset_collate = $wpdb->get_charset_collate();

$sql = "CREATE TABLE `{$wpdb->base_prefix}reservations` (
  check_id int NOT NULL,
  reservation_id int NOT NULL,
  status varchar(16) NOT NULL,
  created_at datetime NOT NULL,
  PRIMARY KEY  (check_id)
) $charset_collate;";

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);

/**
 * Disable the emoji's
 */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );	
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	
	// Remove from TinyMCE
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );

/**
 * Filter out the tinymce emoji plugin.
 */
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

?>
