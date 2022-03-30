<?php
if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

/**
 * Moove_GDPR_Options File Doc Comment
 *
 * @category Moove_GDPR_Options
 * @package   gdpr-cookie-compliance
 * @author    Gaspar Nemes
 */

/**
 * Moove_GDPR_Options Class Doc Comment
 *
 * @category Class
 * @package  Moove_GDPR_Options
 * @author   Gaspar Nemes
 */
class Moove_GDPR_Options {
	/**
	 * Global options
	 *
	 * @var array
	 */
	private $options;
	/**
	 * Construct
	 */
	function __construct() {
		add_action( 'admin_menu', array( &$this, 'moove_gdpr_admin_menu' ) );
	}

	/**
	 * Moove feed importer page added to settings
	 *
	 * @return  void
	 */
	public function moove_gdpr_admin_menu() {
		$gdpr_settings_page = add_menu_page(
			'GDPR Cookie', // Page_title.
			'GDPR Cookie Compliance', // Menu_title.
			'manage_options', // Capability.
			'moove-gdpr', // Menu_slug.
			array( &$this, 'moove_gdpr_settings_page' ), // Function.
			'dashicons-shield',
			90 // Position.
		);
		add_action( 'load-' . $gdpr_settings_page, array( 'Moove_GDPR_Actions', 'moove_gdpr_admin_scripts' ) );
	}
	/**
	 * Settings page registration
	 *
	 * @return void
	 */
	public function moove_gdpr_settings_page() {
		$data = array();
		$view_cnt = new GDPR_View();
		echo $view_cnt->load( 'moove.admin.settings.settings_page', $data );
	}

}
$moove_gdpr_options = new Moove_GDPR_Options();
