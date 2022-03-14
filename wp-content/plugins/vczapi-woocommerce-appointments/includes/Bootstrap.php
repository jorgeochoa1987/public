<?php

namespace Codemanas\ZoomWooCommerceAppointments;


use Codemanas\ZoomWooCommerceAppointments\Backend\Appointments\AppointmentMetaBox;
use Codemanas\ZoomWooCommerceAppointments\Backend\Appointments\AppointmentsWPML;
use Codemanas\ZoomWooCommerceAppointments\Backend\Appointments\AppointmentTable;
use Codemanas\ZoomWooCommerceAppointments\Backend\Appointments\AppointmentTabs;
use Codemanas\ZoomWooCommerceAppointments\Core\Container;
use Codemanas\ZoomWooCommerceAppointments\Core\Fields;
use Codemanas\ZoomWooCommerceAppointments\Backend\Settings\Settings;
use Codemanas\ZoomWooCommerceAppointments\Core\Updater;
use Codemanas\ZoomWooCommerceAppointments\Main\AppointmentsStaff;
use Codemanas\ZoomWooCommerceAppointments\Main\CronHandlers;
use Codemanas\ZoomWooCommerceAppointments\Main\TemplateOverrides;
use Codemanas\ZoomWooCommerceAppointments\Main\WooCommerceAppointments;

final class Bootstrap {
	const PLUGIN_NAME = 'Zoom for WooCommerce Appointments';
	const VERSION = '1.0.0';
	const MINIMUM_PHP_VERSION = '7.0';
	const WOO_MIN_VERSION = '4.2.2';
	const WOO_APPOINTMENTS_MIN_VERSION = '4.9.7';
	public static $_instance = null;
	private $admin_area = null;
	private $prerequisites_fulfilled = false;
	private $container = false;
	private $key_validate = false;

	/**
	 * @return Bootstrap
	 */
	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self:: $_instance;
	}

	/**
	 * pluginName constructor.
	 */
	public function __construct() {
		$prerequisites_fulfilled = $this->check_prerequisites();
		if ( ! $prerequisites_fulfilled ) {
			return;
		}
//		register_activation_hook( VCZAPI_WOOCOMMERCE_APPOINTMENTS_FILE_PATH, 'Codemanas\ZoomWooCommerceAppointments\Bootstrap::plugin_activate' );
		$this->autoload();
		$this->container    = new Container();
		$this->key_validate = Fields::get_option( 'license_key' );

		add_action( 'plugins_loaded', array( $this, 'load_plugin' ) );
	}

	public function check_prerequisites() {
		//check PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );

			return false;
		} //Check if Zoom Core Plugin Exists
		else if ( ! in_array( 'video-conferencing-with-zoom-api/video-conferencing-with-zoom-api.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			add_action( 'admin_notices', [ $this, 'zoom_core_not_installed' ] );

			return false;
		} //Check if WooCommerce Exists
		else if ( ! is_woocommerce_active() ) {
			add_action( 'admin_notices', [ $this, 'woocommerce_not_installed' ] );

			return false;
		} //check Woo Appointments Activated
		else if ( ! in_array( 'woocommerce-appointments/woocommerce-appointments.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			add_action( 'admin_notices', [ $this, 'woocommerce_appointments_not_installed' ] );

			return false;
		}

		return true;
	}

	//admin notice for PHP version
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		$message = sprintf(
		/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'vczapi-woocommerce-appointments' ),
			'<strong>' . self::PLUGIN_NAME . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'vczapi-woocommerce-appointments' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-error is-dismissible"><p>%1$s</p></div>', $message );

	}

	//core zoom not installed
	public function zoom_core_not_installed() {

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
		/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" please install and activate "%3$s" first.', 'vczapi-woocommerce-appointments' ),
			'<strong>' . self::PLUGIN_NAME . '</strong>',
			'<a href="https://wordpress.org/plugins/video-conferencing-with-zoom-api/" target="_blank" rel="nofollow noopener">Video Conferencing with Zoom</a>',
			'<strong>' . __( 'Video Conferencing with Zoom', 'vczapi-woocommerce-appointments' ) . '</strong>'
		);

		printf( '<div class="notice notice-error is-dismissible"><p>%1$s</p></div>', $message );

	}

	//woocommerce not installed
	public function woocommerce_not_installed() {

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		$message = sprintf(
		/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires %2$s please install and activate "%3$s" first.', 'vczapi-woocommerce-appointments' ),
			'<strong>' . self::PLUGIN_NAME . '</strong>',
			'<a href="https://wordpress.org/plugins/woocommerce/" target="_blank" rel="nofollow noopener">WooCommerce</a>',
			'<strong>' . __( 'WooCommerce', 'vczapi-woocommerce-appointments' ) . '</strong>'
		);

		printf( '<div class="notice notice-error is-dismissible"><p>%1$s</p></div>', $message );

	}

	//woocommerce not installed
	public function woocommerce_appointments_not_installed() {

		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		$message = sprintf(
		/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires %2$s please install and activate "%3$s first."', 'vczapi-woocommerce-appointments' ),
			'<strong>' . self::PLUGIN_NAME . '</strong>',
			'<a href="https://bookingwp.com/plugins/woocommerce-appointments/" target="_blank" rel="nofollow noopener">' . __( 'WooCommerce Appointments', 'vczapi-woocommerce-appointments' ) . '</a>',
			'<strong>' . __( 'WooCommerce Appointments', 'vczapi-woocommerce-appointments' ) . '</strong>'
		);

		printf( '<div class="notice notice-error is-dismissible"><p>%1$s</p></div>', $message );

	}


	/**
	 * Autoload - PSR 4 Compliance
	 */
	public function autoload() {
		require_once VCZAPI_WOOCOMMERCE_APPOINTMENTS_DIR . '/vendor/autoload.php';
	}

	public function load_plugin() {
		load_plugin_textdomain( 'vczapi-woocommerce-appointments', false, 'vczapi-woocommerce-appointments/languages/' );
		if ( $this->key_validate ) {
			WooCommerceAppointments::getInstance();
			$this->container->get( CronHandlers::class );
			$this->container->get( TemplateOverrides::class );

			if ( class_exists( 'SitePress' ) ) {
				$this->container->get( AppointmentsWPML::class );
			}
			AppointmentMetaBox::get_instance();
		}
		if ( current_user_can( 'manage_options' ) ) {
			$this->container->get( Settings::class );
			//Run Updater
			$this->updater( $this->container->get( Fields::class ) );
			AppointmentsStaff::get_instance();
		}
		add_action( 'admin_init', [ $this, 'admin_init' ] );

	}

	public function admin_init() {
		if ( $this->key_validate ) {
			$this->container->get( AppointmentTabs::class );
			$this->container->get( AppointmentTable::class );
		}
	}

	/**
	 * Run the updater in admin
	 *
	 * @param Fields $fields
	 */
	private function updater( Fields $fields ) {
		$updater = new Updater( $fields->store_url(), VCZAPI_WOOCOMMERCE_APPOINTMENTS_DIR . '/vczapi-woocommerce-appointments.php', array(
			'version' => VCZAPI_ZOOM_WOOCOMMERCE_APPOINTMENTS_PLUGIN_VERSION,
			'license' => Fields::get_option( 'license_key' ),
			'author'  => 'CodeManas',
			'item_id' => $fields->item_id(),
			'beta'    => false,
		) );

		$updater->check();
	}

}

function ZoomWCAppointments() {
	return Bootstrap::get_instance();
}

ZoomWCAppointments();
