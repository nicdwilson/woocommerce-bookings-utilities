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

		$this->settings = get_option( 'wc_bookings_utilities_settings' );
		$this->do_settings_menu();
	}

	/**
	 * Set up the utlity sub menu
	 *
	 * @return void
	 */
	public function do_settings_menu() {

		/**
		 * Only plugin managers. Booking managers are not allowed access, as some of these settings
		 * could be destructive.
		 */
		if ( ! user_can( get_current_user_id(), 'manage_options' ) ) {
			return;
		}

		$settings_page = add_submenu_page(
			'edit.php?post_type=wc_booking',
			__( 'Utilities', 'wc-bookings-utilities' ),
			__( 'Utilities', 'wc-bookings-utilities' ),
			'manage_options',
			'wc-bookings-utilities-settings',
			array( $this, 'render_submenu_page' ),
		);


		add_settings_section( 'wc_bookings_utilities_settings_cart', 'Setup cart cleaner', null, 'wc-bookings-utilities-settings' );
		register_setting( 'wc_bookings_utilities_settings_cart', 'wc_bookings_utilities_settings', );

		$this->register_settings_fields();

	}

	private function register_settings_fields() {

		$fields = array(
			array(
				'id'           => 'wc_bookings_utilities_settings[cart_expiry_minutes]',
				'name'         => __( 'Cart expiry', 'wc-bookings-utilities' ),
				'callback'     => array( $this, 'render_fields' ),
				'page'         => 'wc-bookings-utilities-settings',
				'option_group' => 'wc_bookings_utilities_settings_cart',
				'args'         => array(
					'type'         => 'text',
					'option_group' => 'wc_bookings_utilities_settings_cart',
					'name'         => 'wc_bookings_utilities_settings[cart_expiry_minutes]',
					'label_for'    => 'wc_bookings_utilities_settings[cart_expiry_minutes]',
					'value'        => $this->settings['cart_expiry_minutes'],
					'description'  => __( 'Time in minutes before bookings are removed from the cart.', 'wc-bookings-utilities' ),
					'helper'       => ''
				)
			),
			array(
				'id'           => 'wc_bookings_utilities_settings[use_cart_cleaner]',
				'name'         => __( 'Use additional cart cleaner', 'wc-bookings-utilities' ),
				'callback'     => array( $this, 'render_fields' ),
				'page'         => 'wc-bookings-utilities-settings',
				'option_group' => 'wc_bookings_utilities_settings_cart',
				'args'         => array(
					'type'         => 'checkbox',
					'option_group' => 'wc_bookings_utilities_settings_cart',
					'name'         => 'wc_bookings_utilities_settings[use_cart_cleaner]',
					'label_for'    => 'wc_bookings_utilities_settings[use_cart_cleaner]',
					'value'        => $this->settings['use_cart_cleaner'],
					'description'  => __( 'If you have bookings getting stuck in the cart, set the additional cart cleaner to run every five minutes. This only removes expired bookings.', 'wc-bookings-utilities' ),
					'helper'       => ''
				),
			)
		);

		foreach ( $fields as $field ) {
			add_settings_field(
				$field['id'],
				$field['name'],
				$field['callback'],
				$field['page'],
				$field['option_group'],
				$field['args']
			);
		}

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

	public function render_fields( $field ) {

		ob_start();
		include( 'views/html-admin-settings-fields.php' );
		$html = ob_get_clean();
		echo $html;

	}

	/**
	 * Render the submenu page
	 *
	 * @return void
	 */
	public function render_submenu_page() {

		ob_start();

		include( 'views/html-utilities-menu.php' );

		$html = ob_get_clean();

		echo $html;

	}

}

add_action( 'admin_menu', array( 'WC_Bookings_Utilities\Utility_Menu', 'instance' ), 99 );