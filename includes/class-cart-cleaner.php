<?php

namespace WC_Bookings_Utilities;

defined( 'ABSPATH' ) || exit;

class Cart_Cleaner {

	/**
	 * Cart_Cleaner The instance of Cart_Cleaner.
	 *
	 * @var    object
	 * @access  private
	 * @since    1.0.0
	 */
	private static $instance = null;


	/**
	 * Constructor function.
	 *
	 * @access  public
	 * @return  void
	 * @since   1.0.0
	 */
	public function __construct() {

		/**
		 * Set up the clean cart action using cron.
		 */
		add_action( 'bookings_utility_cart_cleaner', array( $this, 'cleanup_the_cart' ) );

		if ( ! wp_next_scheduled( 'bookings_utility_cart_cleaner' ) ) {
			wp_schedule_event( time(), 'hourly', 'bookings_utility_cart_cleaner' );
		}
	}

	/**
	 * Main Cart_Cleaner Instance
	 *
	 * Ensures only one instance of Cart_Cleaner is loaded or can be loaded.
	 *
	 * @return Main Cart_Cleaner instance
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
	 * Cleanup the cart. Do the real work here.
	 *
	 * @return void
	 */
	public function cleanup_the_cart() {

		$remove = 'expired';

		//clears expired bookings
		$tool = new \WC_Bookings_Tools();

		$log      = new \WC_Logger();
		$log_file = [ 'source' => 'wc_booking_cart_manager' ];

		$result = $tool::remove_in_cart_bookings( $remove );

		if ( is_string( $result ) ) {
			$log->debug( 'Cart cleanup utility plugin ran: ' . $result, $log_file );
		} else {
			$log->debug( 'Cart cleanup ran and output was unexpected', $log_file );
			$log->debug( print_r( $result, true ), $log_file );
		}
	}


}

Cart_Cleaner::instance();