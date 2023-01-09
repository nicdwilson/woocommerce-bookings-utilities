<?php

namespace WC_Bookings_Utilities;

defined( 'ABSPATH' ) || exit;

class Utility_Settings {

	/**
	 * Utility_Settings The instance of Utility_Settings
	 *
	 * @var    object
	 * @access  private
	 * @since    1.0.0
	 */
	private static $instance = null;

	/**
	 * Settings array
	 */
	private $settings = array();

	/**
	 * Default settings for the plugin
	 */
	private $default_settings = array(
		'cart_expiry_minutes' => 60,
	);


	/**
	 * Main Utility_Settings Instance
	 *
	 * Ensures only one instance of Utility_Settings is loaded or can be loaded.
	 *
	 * @return Main Utility_Settings instance
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
	 * Constructor
	 */
	public function __construct() {

		$this->do_settings();
		$this->add_filters_and_actions();
	}

	/**
	 * Sets up settings and default settings
	 *
	 * @return void
	 */
	public function do_settings(){

		$this->settings = get_option( 'wc_bookings_utilities_settings', false );

		if( ! $this->settings ){
			update_option( 'wc_bookings_utilities_settings', $this->default_settings );
			$this->settings = $this->default_settings;
		}
	}

	/**
	 * Setup filters
	 *
	 * @return void
	 */
	public function add_filters_and_actions() {

		// Change the expiry time of in-cart bookings. Default is 60 minutes
		add_filter( 'woocommerce_bookings_remove_inactive_cart_time', array( $this, 'get_cart_expiry_minutes' ) );
	}

	/**
	 * Returns the cart_expiry_minutes from settings array
	 *
	 * @return void
	 */
	public function get_cart_expiry_minutes(){
		return $this->settings['cart_expiry_minutes'];
	}

}


Utility_Settings::instance();
