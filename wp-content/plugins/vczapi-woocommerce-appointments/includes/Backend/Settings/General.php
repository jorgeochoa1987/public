<?php


namespace Codemanas\ZoomWooCommerceAppointments\Backend\Settings;

use Codemanas\ZoomWooCommerceAppointments\Core\Fields;

class General {
	public static $_instance = null;

	public static function get_instance() {
		if ( self::$_instance == null ) {
			self::$_instance = new self();
		}
	}

	public function __construct() {
		add_action( 'init', [ $this, 'save_form' ] );
	}

	public function save_form() {
		$_nonce = filter_input( INPUT_POST, 'vczapi__woocommerce_appointments_nonce' );
		if ( ! wp_verify_nonce( $_nonce, 'save_vczapi_woocommerce_appointments' ) ) {
			return;
		}
		$disable_browser_join = filter_input( INPUT_POST, 'vczapi_disable_browser_join' );
		Fields::set_option( 'disable_browser_join', $disable_browser_join );
	}
}