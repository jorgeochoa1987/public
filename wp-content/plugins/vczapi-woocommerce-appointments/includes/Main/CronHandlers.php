<?php


namespace Codemanas\ZoomWooCommerceAppointments\Main;


use Codemanas\ZoomWooCommerceAppointments\Core\Fields;
use DateTime;
use DateTimeZone;
use Exception;

class CronHandlers {

	public function __construct() {
		add_action( 'wc-appointment-complete', [ $this, 'cleanup_on_appointment_complete' ] );
		add_action( 'vczapi_woocommerce_appointments_before_delete_meeting', [ $this, 'cleanup_on_appointment_complete' ], 10, 2 );
	}

	/**
	 * Helper function to set correct time zone
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
	 * @param      $appointment_id
	 * @param bool $force_remove
	 */
	public function cleanup_on_appointment_complete( $appointment_id, $force_remove = false ) {
		$appointment = get_wc_appointment( $appointment_id );
		if ( ! is_object( $appointment ) ) {
			return;
		}
		/** @var  $meeting_details_raw */
		$meeting_details_raw = Fields::get_meta( $appointment_id, 'meeting_details' );
		$meeting_details     = json_decode( $meeting_details_raw );
		if ( ! empty( $meeting_details ) ) {
			try {
				$dateTime = new DateTime( $meeting_details->start_time );
				$dateTime->setTimezone( new DateTimeZone ( $meeting_details->timezone ) );
				$currentTime = new DateTime( 'now' );
				$currentTime->setTimezone( new DateTimeZone ( $meeting_details->timezone ) );
				//the second parameter is set for force remove be careful with use with woocommerce_appointment_complete as second parameter is priority and args are passed will be appointment check class-wc-appointments.php line 258
				if ( ( $currentTime < $dateTime ) && $force_remove == false ) {
					return;
				}
			} catch ( Exception $e ) {
				//echo $e->getMessage();
				return;
			}

			$start_time           = $dateTime->format( 'Y-m-dH:i:s' );
			$product_id           = $appointment->get_product_id();
			$booked_zoom_meetings = Fields::get_meta( $product_id, 'zoom_meetings' );
			$index_timezone = $this->get_system_timezone();
//			$details =
//				[
//					'meeting_details' => $booked_zoom_meetings,
//					'index' => $booked_zoom_meetings[ $meeting_details->host_id ][ $start_time . '-' . $index_timezone ]
//			];
//			file_put_contents(VZAPI_WOO_ADDON_DIR_PATH.'logs/cleanup.txt',var_export($details,true));
			if ( isset( $booked_zoom_meetings[ $meeting_details->host_id ][ $start_time . '-' . $index_timezone ] )
			     && ! empty( $booked_zoom_meetings[ $meeting_details->host_id ][ $start_time . '-' . $index_timezone ] )
			) {
				unset( $booked_zoom_meetings[ $meeting_details->host_id ][ $start_time . '-' . $index_timezone ] );
				Fields::set_meta($product_id,'zoom_meetings',$booked_zoom_meetings);
			}
		}

	}
}