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



}

if( is_admin() ){
	Utility_Settings::instance();
}