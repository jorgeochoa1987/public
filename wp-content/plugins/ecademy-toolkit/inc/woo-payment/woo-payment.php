<?php
/**
 * LearnPress - WooCommerce Payment Methods Integration
 *
 * @package learnpress-woo-payment
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
define( 'LP_ADDON_WOO_PAYMENT_FILE', __FILE__ );
define( 'LP_ADDON_WOO_PAYMENT_PATH', dirname( __FILE__ ) );
define( 'LP_WOO_TEMPLATE_DEFAULT', LP_ADDON_WOO_PAYMENT_PATH . '/templates/' );

class LP_Addon_Woo_Payment_Preload {
	/**
	 * @var array
	 */
	public static $addon_info;

	/**
	 * LP_Addon_Wishlist_Preload constructor.
	 */
	public function __construct() {
		$can_load = true;
		// Set Base name plugin.
		define( 'LP_ADDON_WOO_PAYMENT_BASENAME', plugin_basename( LP_ADDON_WOO_PAYMENT_FILE ) );

		// Set version addon for LP check .
		include_once ABSPATH . 'wp-admin/includes/plugin.php';
		self::$addon_info = get_file_data(
			LP_ADDON_WOO_PAYMENT_FILE,
			array(
				'Name'               => 'Plugin Name',
				'Require_LP_Version' => 'Require_LP_Version',
				'Version'            => 'Version',
			)
		);

		define( 'LP_ADDON_WOO_PAYMENT_VER', self::$addon_info['Version'] );
		define( 'LP_ADDON_WOO_PAYMENT_REQUIRE_VER', self::$addon_info['Require_LP_Version'] );

		// Check LP activated .
		if ( ! is_plugin_active( 'learnpress/learnpress.php' ) ) {
			$can_load = false;
		} elseif ( version_compare( LP_ADDON_WOO_PAYMENT_REQUIRE_VER, get_option( 'learnpress_version', '3.0.0' ), '>' ) ) {
			$can_load = false;
		}

		if ( ! $can_load ) {
			deactivate_plugins( LP_ADDON_WOO_PAYMENT_BASENAME );

			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}

			return;
		}

		// Check Woo activated .
		$this->check_woo_activated();

		// Sure LP loaded.
		add_action( 'learn-press/ready', array( $this, 'load' ) );
	}

	/**
	 * Check plugin Woo activated.
	 */
	public function check_woo_activated() {
		if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {

			deactivate_plugins( LP_ADDON_WOO_PAYMENT_BASENAME );

			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}

			return;
		}
	}

	/**
	 * Load addon
	 */
	public function load() {
		LP_Addon::load( 'LP_Addon_Woo_Payment', 'incs/load.php', __FILE__ );
	}
}

new LP_Addon_Woo_Payment_Preload();

