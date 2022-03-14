<?php

namespace Codemanas\ZoomWooCommerceAppointments\Core;

/**
 * Class API
 *
 * @since 1.0.0
 * @author Deepen
 * @copyright 2020. All rights reserved. CodeManas
 */
class API extends \Zoom_Video_Conferencing_Api {

	/**
	 * Hold my instance
	 *
	 * @var
	 */
	protected static $_instance;

	/**
	 * Zoom API KEY
	 *
	 * @var
	 */
	public $zoom_api_key;

	/**
	 * Zoom API Secret
	 *
	 * @var
	 */
	public $zoom_api_secret;

	/**
	 * @return API|\Zoom_Video_Conferencing_Api
	 */
	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function __construct() {
		$this->zoom_api_key    = get_option( 'zoom_api_key' );
		$this->zoom_api_secret = get_option( 'zoom_api_secret' );

		parent::__construct( $this->zoom_api_key, $this->zoom_api_secret );
	}

	/**
	 * Add a meeting registrant
	 *
	 * @param $meetingId
	 * @param bool $postData
	 *
	 * @return array|bool|mixed|string|\WP_Error
	 */
	public function addMeetingRegistrant( $meetingId, $postData = false ) {
		return $this->sendRequest( 'meetings/' . $meetingId . '/registrants', $postData, "POST" );
	}

	/**
	 * Get Meeting Registrants
	 *
	 * @param $meetingId
	 *
	 * @return array|bool|string|\WP_Error
	 */
	public function getMeetingRegistrant( $meetingId ) {
		$postData['page_size'] = 300;

		return $this->sendRequest( 'meetings/' . $meetingId . '/registrants', $postData, "GET" );
	}
}