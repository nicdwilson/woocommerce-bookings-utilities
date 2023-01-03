<?php

namespace WC_Bookings_Utilities;

class Utility_Menu {

	/**
	 * Utility_Menu The instance of Utility_Settings
	 *
	 * @var    object
	 * @access  private
	 * @since    1.0.0
	 */
	private static $instance = null;

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->do_settings_menu();
	}

	/**
	 * Main Utility_Menu Instance
	 *
	 * Ensures only one instance of Utility_Menu is loaded or can be loaded.
	 *
	 * @return Main Utility_Menu instance
	 * @since 1.0.0
	 * @static
	 */
	public static function instance(): object {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Set up the utlity sub menu
	 *
	 * @return void
	 */
	public function do_settings_menu() {

		$settings_page = add_submenu_page(
			'edit.php?post_type=wc_booking',
			__( 'Utilities', 'wc-bookings-utilities' ),
			__( 'Utilities', 'wc-bookings-utilities' ),
			'manage_options',
			'wc_bookings_utilities_settings',
			array( $this, 'render_submenu_page' ),
		);
		add_settings_section( 'wc_bookings_utilities_settings', 'Setup cart cleaner', null, 'wc-bookings-utility-cart-cleaner' );
		register_setting( 'bookings_utilities', 'wc_bookings_utilities_settings' );

	}


	/**
	 * Render the submenu page
	 *
	 * @return void
	 */
	public function render_submenu_page() {

		echo '';
		do_settings_sections('wc-bookings-utility-cart-cleaner' );
	}

}

add_action( 'admin_menu', array( 'WC_Bookings_Utilities\Utility_Menu', 'instance' ), 99 );