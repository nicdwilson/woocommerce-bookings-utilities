<?php
/**
 * Plugin Name: WooCommerce Bookings Utilities
 * Plugin URL:
 * Description: Utilities for WooCommerce Bookings
 * Version: 2.1.1
 * Author: nicw
 * Author URI:
 * Text Domain: wc-bookings-utilities
 * Requires at least: 5.7
 * Tested up to: 6.0
 * Requires PHP: 7.4
 *
 * WC requires at least: 6.0
 * WC tested up to: 6.8
 * Woo:
 *
 * @package WC_Bookings_Ext
 */

namespace WC_Bookings_Utilities;

defined( 'ABSPATH' ) || exit;

require_once plugin_dir_path( __FILE__ ) . '/includes/class-cart-cleaner.php';

class WooCommerce_Bookings_Utilities {

	public static string $wc_minimum_supported_version = '6.0';
	public static string $wc_bookings_minimum_supported_version = '1.15.50';
	/**
	 * WooCommerce_Bookings_Utilities The instance of Cart_Cleaner.
	 *
	 * @var    object
	 * @access  private
	 * @since    1.0.0
	 */
	private static $instance = null;

	public function __construct() {


		add_action('admin_init', array( $this, 'check_dependencies'));

	}

	/**
	 * Main Cart_Cleaner Instance
	 *
	 * Ensures only one instance of Cart_Cleaner is loaded or can be loaded.
	 *
	 * @return WooCommerce_Bookings_Utilities instance
	 * @since 1.0.0
	 * @static
	 */
	public static function instance(): object {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function check_dependencies(){

		/**
		 * Check if WooCommerce and Subscriptions are active.
		 */
		if ( ! class_exists( 'WooCommerce' ) || version_compare( get_option( 'woocommerce_db_version' ), self::$wc_minimum_supported_version, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'plugin_dependency_notices' ) );
			deactivate_plugins( plugin_basename( __FILE__ ) );
			return;
		}

		if ( ! class_exists( 'WC_Bookings' ) || version_compare( get_option( 'wc_bookings_version' ), self::$wc_bookings_minimum_supported_version, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'plugin_dependency_notices' ) );
			deactivate_plugins( plugin_basename( __FILE__ ) );
			return;
		}
	}

	public function plugin_dependency_notices() {
		$message = '<div id="message" class="error"><p><strong>WooCommerce  Bookings Utilities requires both WooCommerce and WooCommerce  Bookings to be installed and activated.</strong></p></div>';
		echo __( $message, 'woocommerce-bookings-utilities' );
	}
}

add_action( 'plugins_loaded', array( 'WC_Bookings_Utilities\WooCommerce_Bookings_Utilities', 'instance' ) );
