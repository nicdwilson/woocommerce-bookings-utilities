<?php

namespace WC_Bookings_Utilities;

class Bookings_Status_Manager {


	/**
	 * function set_cod_bookings_confirmed_20170825( $order_id ) {

	// Get the order, then make sure its payment method is COD.
	$order = wc_get_order( $order_id );
	if ( 'cod' !== $order->get_payment_method() ) {
	return;
	}
	// Call the data store class so we can get bookings from the order.
	$booking_data = new WC_Booking_Data_Store();
	$booking_ids  = $booking_data->get_booking_ids_from_order_id( $order_id );
	// If we have bookings go through each and update the status.
	if ( is_array( $booking_ids ) && count( $booking_ids ) > 0 ) {
	foreach ( $booking_ids as $booking_id ) {
	$booking = get_wc_booking( $booking_id );
	$booking->update_status( 'confirmed' );
	}
	}
	}
	add_action( 'woocommerce_order_status_processing', 'set_cod_bookings_confirmed_20170825', 20 );
	 */


}