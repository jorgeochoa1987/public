<?php
/*
Plugin Name: Zoom for WooCommerce Appointments
Description: Zoom Add-on for WooCommerce Appointments
Plugin URI: https://codemanas.com/
Author: Codemanas
Author URI: https://codemanas.com/
Version: 1.1.12
WC requires at least: 3.0.0
WC tested up to:   5.2.2
License: http://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
Text Domain: vczapi-woocommerce-appointments
*/

defined( 'ABSPATH' ) or die( 'Script Kiddies Go Away' );

if ( ! defined( 'VCZAPI_ZOOM_WOOCOMMERCE_APPOINTMENTS_PLUGIN_NAME' ) ) {
	define( 'VCZAPI_ZOOM_WOOCOMMERCE_APPOINTMENTS_PLUGIN_NAME', 'Zoom for WooCommerce Appointments' );
}

if ( ! defined( 'VCZAPI_ZOOM_WOOCOMMERCE_APPOINTMENTS_PLUGIN_VERSION' ) ) {
	define( 'VCZAPI_ZOOM_WOOCOMMERCE_APPOINTMENTS_PLUGIN_VERSION', '1.1.12' );
}

//plugin file path
if ( ! defined( 'VCZAPI_WOOCOMMERCE_APPOINTMENTS_FILE_PATH' ) ) {
	define( 'VCZAPI_WOOCOMMERCE_APPOINTMENTS_FILE_PATH', __FILE__ );
}

//plugin dir path
if ( ! defined( 'VCZAPI_WOOCOMMERCE_APPOINTMENTS_DIR' ) ) {
	define( 'VCZAPI_WOOCOMMERCE_APPOINTMENTS_DIR', DIRNAME( __FILE__ ) );
}

//plugin URI
if ( ! defined( 'VCZAPI_WOOCOMMERCE_APPOINTMENTS_URI' ) ) {
	define( 'VCZAPI_WOOCOMMERCE_APPOINTMENTS_URI', plugin_dir_url( __FILE__ ) );
}

require_once VCZAPI_WOOCOMMERCE_APPOINTMENTS_DIR . '/woo-helpers.php';
require_once VCZAPI_WOOCOMMERCE_APPOINTMENTS_DIR . '/includes/Bootstrap.php';