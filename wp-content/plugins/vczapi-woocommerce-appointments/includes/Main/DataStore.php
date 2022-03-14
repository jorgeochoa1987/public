<?php

namespace Codemanas\ZoomWooCommerceAppointments\Main;

use Codemanas\ZoomWooCommerceAppointments\Core\Fields;

/**
 * Class DataStore
 *
 * Handle the getters and setters - More needs to be done. Simple execution right now.
 *
 * @author  Deepen Bajracharya, CodeManas, 2020. All Rights reserved.
 * @since   1.0.0
 * @package Codemanas\ZoomWooCommerceAppointments
 */
class DataStore {
	/**
	 * Helper function to set correct time zone
	 *
	 * @return false|mixed|string|void
	 */
	private function get_system_timezone() {
		$timezone = get_option( 'timezone_string' );
		if ( empty( $timezone ) ) {
			$timezone = zvc_get_timezone_offset_wp();
		}

		if ( $timezone == false ) {
			$timezone = 'UTC';
		}

		return $timezone;
	}

	/**
	 * Get join via browser Link
	 *
	 * @param $password
	 * @param $meeting_id
	 *
	 * @return string
	 */
	public static function get_browser_join_link( $meeting_id, $password = false ) {
		$link               = get_post_type_archive_link( 'zoom-meetings' );
		$encrypt_meeting_id = vczapi_encrypt_decrypt( 'encrypt', $meeting_id );
		if ( ! empty( $password ) ) {
			$encrypt_pwd = vczapi_encrypt_decrypt( 'encrypt', $password );

			$query = add_query_arg( array( 'pak' => $encrypt_pwd, 'join' => $encrypt_meeting_id, 'type' => 'meeting' ), $link );

			return '<a target="_blank" rel="nofollow" href="' . esc_url( $query ) . '" class="btn btn-join-link btn-join-via-browser">' . apply_filters( 'vczoom_join_meeting_via_app_text', __( 'Join via Web Browser', 'vczapi-woocommerce-appointments' ) ) . '</a>';
		} else {
			$query = add_query_arg( array( 'join' => $encrypt_meeting_id, 'type' => 'meeting' ), $link );

			return '<a target="_blank" rel="nofollow" href="' . esc_url( $query ) . '" class="btn btn-join-link btn-join-via-browser">' . apply_filters( 'vczoom_join_meeting_via_app_text', __( 'Join via Web Browser', 'vczapi-woocommerce-appointments' ) ) . '</a>';
		}
	}

	/**
	 * Get Join link to show in frontend.
	 *
	 * @param \WC_Appointment $appointment
	 *
	 * @return mixed|void
	 */
	public static function get_join_link( $appointment ) {
		$html    = '';
		$meeting = json_decode( Fields::get_meta( $appointment->get_id(), 'meeting_details' ) );
		if ( ! empty( $meeting ) ) {
			if ( 'paid' === $appointment->get_status() || 'confirmed' === $appointment->get_status() || 'paid' === $appointment->get_status() || 'complete' === $appointment->get_status() ) {
				$disabled = Fields::get_option( 'disable_browser_join' );
				$html     = '<a href="' . esc_url( $meeting->join_url ) . '" title="' . esc_attr( $meeting->topic ) . '">' . esc_html__( 'via App', 'vczapi-woocommerce-appointments' ) . '</a>';
				if ( empty( $disabled ) ) {
					$pwd  = ! empty( $meeting->password ) ? $meeting->password : false;
					$html .= ' / ' . DataStore::get_browser_join_link( $meeting->id, $pwd );
				}
			} else {
				$html = apply_filters( 'vczapi_woo_addon_join_fail_html', __( 'You have not completed your order yet.', 'vczapi-woocommerce-appointments' ) );
			}
		}

		return $html;
	}

	/**
	 * Get start link from appointment
	 *
	 * @param \WC_Appointment $appointment
	 *
	 * @return mixed|void
	 */
	public static function get_start_link( $appointment ) {
		$meeting = json_decode( Fields::get_meta( $appointment->get_id(), 'meeting_details' ) );
		if ( ! empty( $meeting ) ) {
			$html = '<a href="' . esc_url( $meeting->start_url ) . '" title="' . esc_attr( $meeting->topic ) . '">' . esc_html__( 'Start', 'vczapi-woocommerce-appointments' ) . '</a>';
		} else {
			$html = apply_filters( 'vczapi_woo_addon_start_fail_html', 'N/A', 'no-meeting' );
		}

		return $html;
	}

	/**
	 * Create Meeting Finally !
	 *
	 * @param \WC_Appointment $wc_appointment
	 * @param                 $appointment_id
	 * @param                 $order_id
	 * @param                 $host
	 */
	protected function create_meeting( $wc_appointment, $appointment_id, $order_id ) {
		$product_id   = $wc_appointment->get_product_id();
		$enabled_zoom = Fields::get_meta( $product_id, 'enable_zoom' );
		if ( empty( $enabled_zoom ) ) {
			return;
		}

		//Only process if appointment is not all day appointments
		if ( ! $wc_appointment->get_all_day() ) {
			$start_date = $wc_appointment->get_start_date( 'Y-m-d', 'H:i:s' );
			$end_date   = $wc_appointment->get_end_date( 'Y-m-d', 'H:i:s' );
			$duration   = ! empty( $end_date ) ? ( strtotime( $end_date ) - strtotime( $start_date ) ) / 60 : 60;

			$timezone = $this->get_system_timezone();

			$product_host = Fields::get_meta( $product_id, 'product_host' );
			$jbh          = Fields::get_meta( $product_id, 'jbh' );

			$selected_staff_id = get_post_meta( $appointment_id, '_appointment_staff_id', true );
			$host              = Fields::get_user_meta( $selected_staff_id, 'zoom_staff_host' );

			if ( ! empty( $product_host ) ) {
				$host_id = ! empty( $host ) ? $host : $product_host;

				$start_date    = $wc_appointment->get_start_date( 'Y-m-d', 'H:i:s' );
				$meeting_topic = apply_filters( 'vczapi-woocommerce-appointments-meeting-topic', get_bloginfo( 'name' ) . " Appointment for " . get_the_title( $product_id ) . '-' . $appointment_id, $product_id, $appointment_id );
				//meeting topic has max character length of 200
				if ( strlen( $meeting_topic ) > 200 ) {
					$meeting_topic = apply_filters( 'vczapi-woocommerce-appointments-meeting-topic-retracted', 'Appointment for ' . $appointment_id, $product_id, $appointment_id );
				}

				$create_meeting_arr = apply_filters( 'vczapi_woocommerce_appointments_create_meeting_params', array(
					'userId'           => $host_id,
					'meetingTopic'     => $meeting_topic,
					'start_date'       => $start_date,
					'password'         => $appointment_id,
					'timezone'         => $timezone,
					'duration'         => $duration,
					'join_before_host' => ! empty( $jbh ) ? true : false,
				), $wc_appointment, $product_id, $order_id );

				$booked_zoom_meetings = Fields::get_meta( $product_id, 'zoom_meetings' );

				$timezone_for_index = $this->get_system_timezone();
				//isset and !empty
				if ( isset( $booked_zoom_meetings[ $host_id ][ $start_date . '-' . $timezone_for_index ] ) && ! empty( $booked_zoom_meetings[ $host_id ][ $start_date . '-' . $timezone_for_index ] ) ) {
					$meeting_created_id   = $booked_zoom_meetings[ $host_id ][ $start_date . '-' . $timezone_for_index ];
					$meeting_created      = zoom_conference()->getMeetingInfo( $meeting_created_id );
					$prev_meeting_details = json_decode( $meeting_created );

					//if meeting is deleted from Zoom by user for some reason we need to recreate it.
					if ( is_object( $prev_meeting_details ) ) {
						if ( isset( $prev_meeting_details->code ) && $prev_meeting_details->code != 200 ) {
							$meeting_created     = zoom_conference()->createAMeeting( $create_meeting_arr );
							$new_meeting_details = json_decode( $meeting_created );
							//updates the index with new meeting id
							$booked_zoom_meetings[ $host_id ][ $start_date . '-' . $timezone_for_index ] = $new_meeting_details->id;
							Fields::set_meta( $product_id, 'zoom_meetings', $booked_zoom_meetings );
						}
					}
					//lets keep it simple for now
					Fields::set_meta( $order_id, 'meeting_exists', true );
					Fields::set_meta( $appointment_id, 'meeting_exists', true );
					Fields::set_meta( $appointment_id, 'meeting_details', $meeting_created );
					Fields::set_meta( $appointment_id, 'meeting_error', null );
				} else {
					//this code creates new meeting
					$meeting_created = zoom_conference()->createAMeeting( $create_meeting_arr );
					$meeting_details = json_decode( $meeting_created );
					if ( is_object( $meeting_details ) && empty( $meeting_details->code ) ) {
						//If Success
						$booked_zoom_meetings                                                        = empty( $booked_zoom_meetings ) ? [] : $booked_zoom_meetings;
						$booked_zoom_meetings[ $host_id ][ $start_date . '-' . $timezone_for_index ] = $meeting_details->id;
						Fields::set_meta( $product_id, 'zoom_meetings', $booked_zoom_meetings );
						Fields::set_meta( $order_id, 'meeting_exists', true );
						Fields::set_meta( $appointment_id, 'meeting_exists', true );
						Fields::set_meta( $appointment_id, 'meeting_details', $meeting_created );
						Fields::set_meta( $appointment_id, 'meeting_error', null );
					} else {
						//If Fails
						Fields::set_meta( $appointment_id, 'meeting_error', $meeting_created );

						$site_email  = apply_filters( 'vczapi_woocommerce_appointments_notify_email_on_error', get_option( 'admin_email' ) );
						$product_obj = wc_get_product( $product_id );
						$headers[]   = 'Content-Type: text/html; charset=UTF-8';
						/*******
						 * **********
						 * ********** Send Email Template
						 * **********
						 */
						$body          = apply_filters( 'vczapi_woocommerce_appointments_meeting_create_error_message', '<p>There was an error when creating a Zoom Meeting for booking ' . $appointment_id . '<br /><br/> 
 Error message from Zoom API call: ' . $meeting_details->message . '<br /><br />
 Seems Host is not defined for the product: <strong>' . $product_obj->get_name() . '</strong> Please see the details under Zoom Details of booking here <a href="' . get_edit_post_link( $appointment_id ) . '">' . get_edit_post_link( $appointment_id ) . '</a>', $meeting_details, $product_id, $appointment_id );
						$email_subject = 'Error when creating Zoom Meeting for Appointment' . $appointment_id;
						wp_mail( $site_email, $email_subject, $body, $headers );

					}
				}
				//Trigger After meeting is created
				do_action( 'vczapi_woo_addon_meeting_created', $meeting_created );
			}
		}
	}

	/**
	 * Delete Zoom Meeting Finally !
	 *
	 * @param $appointment_id
	 * @param $order_id
	 * @param $product_id
	 */
	protected function delete_meeting( $appointment_id, $order_id, $product_id, $action = 'deleted' ) {
		$meeting_start_time     = get_post_meta( $appointment_id, '_appointment_start', true );
		$meeting_end_time       = get_post_meta( $appointment_id, '_appointment_end', true );
		$appointment_statuses   = (array) get_wc_appointment_statuses();
		$appointment_statuses[] = 'trash';
		$args                   = [
			'object_id'    => $product_id,
			'object_type'  => 'product',
			'status'       => $appointment_statuses,
			'limit'        => - 1,
			'date_between' => [
				'start' => strtotime( $meeting_start_time ),
				'end'   => strtotime( $meeting_end_time ),
			],
		];
		$appointments_on_date   = \WC_Appointment_Data_Store::get_appointment_ids_by( $args );
		//if count is greater than 1 it indicates that there are still other appointments on this same time for this same product so bail early
		if ( $action == 'deleted' && count( $appointments_on_date ) > 1 ) {
			return;
		} else if ( $action == 'cancelled' && count( $appointments_on_date ) >= 1 ) {
			return;
		}
		$meeting      = json_decode( Fields::get_meta( $appointment_id, 'meeting_details' ) );
		$product_host = Fields::get_meta( $product_id, 'product_host' );
		if ( ! empty( $meeting ) && ! empty( $product_host ) ) {
			do_action( 'vczapi_woocommerce_appointments_before_delete_meeting', $appointment_id, true );
			zoom_conference()->deleteAMeeting( $meeting->id, $product_host );
			delete_post_meta( $appointment_id, '_vczapi_woocommerce_appointments_meeting_details' );
			delete_post_meta( $appointment_id, '_vczapi_woocommerce_appointments_meeting_error' );
			delete_post_meta( $appointment_id, '_vczapi_woocommerce_appointments_meeting_exists' );
			delete_post_meta( $order_id, '_vczapi_woocommerce_appointments_meeting_exists' );

			//Trigger After meeting is deleted
			do_action( 'vczapi_woocommerce_appointments_meeting_deleted', $product_host );
		}
	}

	/**
	 * Get Zoom Product type by Product ID
	 *
	 * @param $product_id
	 *
	 * @return bool
	 */
	public static function get_zoom_product_type( $product_id ) {
		$product = ! empty( $product_id ) ? wc_get_product( $product_id ) : false;
		if ( ! empty( $product ) && $product->get_type() === 'zoom_meeting' ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Get All meetings or with meta query filter
	 *
	 * @param array $meta_query
	 *
	 * @return \WP_Post[]
	 */
	public static function get_all_meetings( $meta_query = array() ) {
		$args = array(
			'post_type'      => 'zoom-meetings',
			'posts_per_page' => - 1
		);

		if ( ! empty( $meta_query ) ) {
			$args['meta_query'] = $meta_query;
		}

		$meetings = get_posts( $args );

		return $meetings;
	}

	/**
	 * Get All orders IDs for a given product ID.
	 *
	 * @param integer $product_id   (required)
	 * @param array   $order_status (optional) Default is 'wc-completed'
	 *
	 * @return array
	 */
	public static function get_orders_ids_by_product_id( $product_id, $order_status = array( 'wc-completed', 'wc-processing' ) ) {
		global $wpdb;

		$results = $wpdb->get_col( "
	        SELECT order_items.order_id
	        FROM {$wpdb->prefix}woocommerce_order_items as order_items
	        LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id
	        LEFT JOIN {$wpdb->posts} AS 		posts ON order_items.order_id = posts.ID
	        WHERE posts.post_type = 'shop_order'
	        AND posts.post_status IN ( '" . implode( "','", $order_status ) . "' )
	        AND order_items.order_item_type = 'line_item'
	        AND order_item_meta.meta_key = '_product_id'
	        AND order_item_meta.meta_value = '$product_id'
	    " );

		return $results;
	}

	/**
	 * Get Email Reminder data
	 *
	 * @return array|mixed|void
	 */
	public static function get_email_reminder() {
		$email_settings = get_option( '_vczapi_email_settings' );
		$email_settings = ! empty( $email_settings )
			? $email_settings
			: [
				'disable_reminder' => false,
				'email_schedule'   => [ '24_hours_before' ],
				'enable_log'       => null
			];

		return $email_settings;
	}

	/**
	 * Get orders IDS from a product ID
	 *
	 * @param $product_id
	 *
	 * @return array
	 * @since 2.1.4
	 *
	 */
	static function orders_ids_from_a_product_id( $product_id ) {
		global $wpdb;

		$orders_statuses = "'wc-completed', 'wc-processing'";

		# Get All defined statuses Orders IDs for a defined product ID (or variation ID)
		return $wpdb->get_col( "
        SELECT DISTINCT woi.order_id
        FROM {$wpdb->prefix}woocommerce_order_itemmeta as woim,
             {$wpdb->prefix}woocommerce_order_items as woi,
             {$wpdb->prefix}posts as p
        WHERE  woi.order_item_id = woim.order_item_id
        AND woi.order_id = p.ID
        AND p.post_status IN ( $orders_statuses )
        AND woim.meta_key IN ( '_product_id', '_variation_id' )
        AND woim.meta_value LIKE '$product_id'
        ORDER BY woi.order_item_id DESC"
		);
	}
}
