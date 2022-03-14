<?php

namespace Codemanas\ZoomWooCommerceAppointments\Backend\Appointments;

use Codemanas\ZoomWooCommerceAppointments\Core\Fields;

/**
 * Class AppointmentsWPML
 *
 * Save WPML products
 *
 * @author  Deepen Bajracharya, CodeManas, 2020. All Rights reserved.
 * @package Codemanas\ZoomWooCommerceAppointments\Admin
 * @since   1.0.0
 */
class AppointmentsWPML {

	public $appointments_statuses
		= array(
			'unpaid',
			'pending-confirmation',
			'confirmed',
			'paid',
			'cancelled',
			'complete',
			'in-cart',
			'was-in-cart',
		);

	public function __construct() {
		add_action( 'wcml_before_sync_product_data', [ $this, 'sync_appointments' ], 10, 3 );
		add_action( 'wcml_before_sync_product', [ $this, 'sync_appointment_data' ], 10, 2 );

		foreach ( $this->appointments_statuses as $status ) {
			add_action( 'woocommerce_appointment_' . $status, [ $this, 'update_status_for_translations' ], 20 );
		}
	}

	/**
	 * Sync zoom details when a translation is edited from translation screen.
	 *
	 * @param $original_product_id
	 * @param $product_id
	 * @param $language
	 */
	public function sync_appointments( $original_product_id, $product_id, $language ) {
		if ( has_term( 'appointment', 'product_type', $original_product_id ) && has_term( 'appointment', 'product_type', $product_id ) ) {
			// Sync Zoom Fields
			$this->sync_zoom_fields( $original_product_id, $product_id, $language );
		}
	}

	/**
	 * Sync zoom details when an original product is edited.
	 *
	 * @param $original_product_id
	 * @param $current_product_id
	 */
	public function sync_appointment_data( $original_product_id, $current_product_id ) {
		if ( has_term( 'appointment', 'product_type', $original_product_id ) ) {
			global $wpml_post_translations;
			$translations = $wpml_post_translations->get_element_translations( $original_product_id, false, true );
			foreach ( $translations as $translation ) {
				$language = $wpml_post_translations->get_element_lang_code( $translation );

				// Sync Zoom Fields
				$this->sync_zoom_fields( $original_product_id, $translation, $language );
			}
		}
	}

	/**
	 * Sync fields to new product created
	 *
	 * @param      $original_product_id
	 * @param      $translated_product_id
	 * @param      $lang_code
	 * @param bool $duplicate
	 */
	public function sync_zoom_fields( $original_product_id, $translated_product_id, $lang_code, $duplicate = true ) {
		$old_values = array(
			'_vczapi_woocommerce_appointments_enable_zoom'  => Fields::get_meta( $original_product_id, 'enable_zoom' ),
			'_vczapi_woocommerce_appointments_product_host' => Fields::get_meta( $original_product_id, 'product_host' ),
			'_vczapi_woocommerce_appointments_jbh'          => Fields::get_meta( $original_product_id, 'jbh' ),
		);

		foreach ( $old_values as $k => $new_value ) {
			update_post_meta( $translated_product_id, $k, $new_value );
		}
	}

	/**
	 * Update same details for the translated order as well.
	 *
	 * @param $appointment_id
	 */
	public function update_status_for_translations( $appointment_id ) {
		global $sitepress;
		$original_appointment_id = $sitepress->get_original_element_id( $appointment_id, 'post_product' );
		//Get Original appointment ID and fetch its data
		if ( ! empty( $original_appointment_id ) ) {
			$appointment_fields = array(
				'_vczapi_woocommerce_appointments_meeting_details' => Fields::get_meta( $original_appointment_id, 'meeting_details' ),
				'_vczapi_woocommerce_appointments_meeting_exists'  => Fields::get_meta( $original_appointment_id, 'meeting_exists' ),
				'_vczapi_woocommerce_appointments_meeting_error'   => Fields::get_meta( $original_appointment_id, 'meeting_error' )
			);
		} else {
			$details = Fields::get_meta( $appointment_id, 'meeting_details' );
			$exists  = Fields::get_meta( $appointment_id, 'meeting_exists' );
			$error   = Fields::get_meta( $appointment_id, 'meeting_error' );
			if ( ! empty( $details ) ) {
				$appointment_fields['_vczapi_woocommerce_appointments_meeting_details'] = $details;
			}

			if ( ! empty( $exists ) ) {
				$appointment_fields['_vczapi_woocommerce_appointments_meeting_exists'] = $exists;
			}

			if ( ! empty( $error ) ) {
				$appointment_fields['_vczapi_woocommerce_appointments_meeting_error'] = $error;
			}
		}

		//Save Fields with the acquired data
		global $wpml_post_translations;
		if ( ! empty( $appointment_fields ) ) {
			$get_translated_appointments = $wpml_post_translations->get_element_translations( $appointment_id, false, false );
			foreach ( $get_translated_appointments as $lang => $translated_appointment_id ) {
				if ( ! empty( $appointment_fields['_vczapi_woocommerce_appointments_meeting_details'] ) ) {
					Fields::set_meta( $translated_appointment_id, 'meeting_details', $appointment_fields['_vczapi_woocommerce_appointments_meeting_details'] );
				}

				if ( ! empty( $appointment_fields['_vczapi_woocommerce_appointments_meeting_exists'] ) ) {
					Fields::set_meta( $translated_appointment_id, 'meeting_exists', $appointment_fields['_vczapi_woocommerce_appointments_meeting_exists'] );
				}

				if ( ! empty( $appointment_fields['_vczapi_woocommerce_appointments_meeting_error'] ) ) {
					Fields::set_meta( $translated_appointment_id, 'meeting_error', $appointment_fields['_vczapi_woocommerce_appointments_meeting_error'] );
				}
			}
		}

		//only field to be updated it product when appointment is made
		$wc_appointment = get_wc_appointment( $appointment_id );
		$product_id     = $wc_appointment->get_product_id();
		$zoom_meeting   = Fields::get_meta( $product_id, 'zoom_meetings' );
		if ( ! empty( $zoom_meeting ) ) {
			$all_products = $wpml_post_translations->get_element_translations( $product_id );
			foreach ( $all_products as $translation_product_id ) {
				if ( $product_id == $translation_product_id ) {
					continue;
				}
				Fields::set_meta( $translation_product_id,'zoom_meetings',$zoom_meeting );
			}
		}


	}
}