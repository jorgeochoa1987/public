<?php

namespace Codemanas\ZoomWooCommerceAppointments\Main;

use Codemanas\ZoomWooCommerceAppointments\Core\Fields;
use WC_Appointment_Data_Store;

/**
 * Class WooCommerceAppointments
 *
 * @package Codemanas\ZoomWooCommerceAppointments\Main
 */
class WooCommerceAppointments extends DataStore {
	public static $_instance = null;

	public static function getInstance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function __construct() {
		//WooCommerce
		add_action( 'woocommerce_order_status_completed', array( $this, 'wc_appointment_completed' ) );
		add_action( 'woocommerce_order_status_processing', array( $this, 'wc_appointment_completed' ) );
		//add_action( 'woocommerce_order_status_cancelled', array( $this, 'wc_delete_appointment' ) );

		add_action( 'woocommerce_appointment_paid', array( $this, 'appointment_paid' ) );
		add_action( 'woocommerce_appointment_confirmed', array( $this, 'appointment_paid' ) );
		add_action( 'woocommerce_appointment_cancelled', array( $this, 'appointment_cancelled' ) );

		//add_action( 'woocommerce_delete_order_items', array( $this, 'wc_delete_appointment' ) );

		//WooCommerce Email Template
		add_action( 'woocommerce_order_item_meta_end', array( $this, 'meeting_details' ), 10, 3 );

		add_action( 'before_delete_post', [ $this, 'before_delete_appointment' ] );

		//Google Calendar Add
		add_filter( 'woocommerce_appointments_gcal_sync', [ $this, 'add_zoom_links_to_calendar' ], 10, 2 );
	}

	/**
	 * @param                 $data
	 * @param \WC_Appointment $appointment
	 *
	 * @return mixed
	 */
	function add_zoom_links_to_calendar( $data, $appointment ) {
		remove_filter( 'woocommerce_appointments_gcal_sync', [ 'WooCommerceAppointments', 'cm_add_zoom_links' ] );
		$appointment_id  = $appointment->get_id();
		$meeting_details = get_post_meta( $appointment_id, '_vczapi_woocommerce_appointments_meeting_details', true );
		if ( ! empty( $meeting_details ) ) {
			$meeting_details = json_decode( $meeting_details );
			if ( is_object( $meeting_details ) ) {
				if ( isset( $meeting_details->join_url ) ) {
					$data['description'] .= __( 'Join Zoom Meeting ', 'vczapi-woocommerce-appointments' ) . html_entity_decode( \Codemanas\ZoomWooCommerceAppointments\Main\DataStore::get_join_link( $appointment ) ) . PHP_EOL;
				}
			}
		}

		return $data;
	}

	/**
	 * Create appointment meeting based on order ID
	 *
	 * @param $order_id
	 */
	public function wc_appointment_completed( $order_id ) {
		$appointment_ids = WC_Appointment_Data_Store::get_appointment_ids_from_order_id( $order_id );
		if ( ! empty( $appointment_ids ) ) {
			foreach ( $appointment_ids as $appointment_id ) {
				$exists = Fields::get_meta( $appointment_id, 'meeting_exists' );
				$error  = Fields::get_meta( $appointment_id, 'meeting_error' );
				if ( empty( $exists ) && empty( $error ) ) {
					$wc_appointment = get_wc_appointment( $appointment_id );
					//Create Meeting
					$this->create_meeting( $wc_appointment, $appointment_id, $order_id );
				}
			}
		}
	}

	/**
	 * Create Meeting if appointment status is changed to Paid in wc-appointment order page.
	 *
	 * @param $appointment_id
	 */
	public function appointment_paid( $appointment_id ) {
		$wc_appointment = get_wc_appointment( $appointment_id );
		$order_id       = $wc_appointment->get_order_id();
		$exists         = Fields::get_meta( $appointment_id, 'meeting_exists' );
		$error          = Fields::get_meta( $appointment_id, 'meeting_error' );
		if ( empty( $exists ) && empty( $error ) ) {
			//Create Meeting
			$this->create_meeting( $wc_appointment, $appointment_id, $order_id );
		}
	}

	/**
	 * Delete meeting When appointment order is Cancelled from wc-appointment page.
	 *
	 * @param $appointment_id
	 */
	public function appointment_cancelled( $appointment_id ) {
		$appointment = get_wc_appointment( $appointment_id );
		$order_id    = $appointment->get_order_id();
		$this->delete_meeting( $appointment_id, $order_id, $appointment->get_product_id(), 'cancelled' );
	}

	/**
	 * Delete Meeting when order is cancelled from WooCommerce orders page.
	 *
	 * @param $order_id
	 */
	public function wc_delete_appointment( $order_id ) {
		$appointment_ids = WC_Appointment_Data_Store::get_appointment_ids_from_order_id( $order_id );
		if ( ! empty( $appointment_ids ) ) {
			foreach ( $appointment_ids as $appointment_id ) {
				$appointment = get_wc_appointment( $appointment_id );
				$exists      = Fields::get_meta( $appointment_id, 'meeting_exists' );
				if ( ! empty( $exists ) ) {
					$this->delete_meeting( $appointment_id, $order_id, $appointment->get_product_id() );
				}
			}
		}
	}

	/**
	 * Delete Meeting when appointment is deleted
	 *
	 * @param $appointment_id
	 */
	public function before_delete_appointment( $appointment_id ) {
		if ( 'wc_appointment' != get_post_type( $appointment_id ) ) {
			return;
		}
		$appointment = get_wc_appointment( $appointment_id );
		if ( is_object( $appointment ) ) {
			$exists = Fields::get_meta( $appointment_id, 'meeting_exists' );
			if ( ! empty( $exists ) ) {
				$this->delete_meeting( $appointment_id, $appointment->get_order_id(), $appointment->get_product_id() );
			}
		}
	}

	/**
	 * Show in order emails
	 *
	 * @param $item_id
	 * @param $item
	 * @param $order
	 */
	public function meeting_details( $item_id, $item, $order ) {
		$appointment_ids = WC_Appointment_Data_Store::get_appointment_ids_from_order_item_id( $item_id );
		if ( ! empty( $appointment_ids ) ) {
			foreach ( $appointment_ids as $appointment_id ) {
				$appointment = get_wc_appointment( $appointment_id );
				$meeting     = Fields::get_meta( $appointment_id, 'meeting_details' );
				$meeting     = ! empty( $meeting ) ? json_decode( $meeting ) : false;
				$disabled    = Fields::get_option( 'disable_browser_join' );
				if ( ! empty( $meeting ) && ($appointment->get_status() === 'paid' || $appointment->get_status() == 'confirmed' ) ) {
					do_action( 'vczapi_appointments_before_meeting_details', $meeting );
					echo '<p style="margin: 20px 0;"><a target="_blank" rel="nofollow" href="' . esc_url( $meeting->join_url ) . '">' . __( 'Join via App.', 'vczapi-woocommerce-appointments' ) . '</a>';
					if ( empty( $disabled ) ) {
						$password = ! empty( $meeting->password ) ? $meeting->password : false;
						echo '/' . DataStore::get_browser_join_link( $meeting->id, $password );
					}
					echo "</p>";

					do_action( 'vczapi_appointments_after_meeting_details', $meeting );
				}
			}
		}
	}
}