<?php
namespace SG_Security\Helper;

use SG_Security;

/**
 * Helper functions and main initialization class.
 */
class Helper {

	/**
	 * Load the global wp_filesystem.
	 *
	 * @since  1.0.0
	 *
	 * @return object The instance.
	 */
	public static function setup_wp_filesystem() {
		global $wp_filesystem;

		// Initialize the WP filesystem, no more using 'file-put-contents' function.
		if ( empty( $wp_filesystem ) ) {
			require_once( ABSPATH . '/wp-admin/includes/file.php' );
			WP_Filesystem();
		}

		return $wp_filesystem;
	}

	/**
	 * Check if wp cron is disabled and send error message.
	 *
	 * @since  1.0.0
	 */
	public static function is_cron_disabled() {
		if ( defined( 'DISABLE_WP_CRON' ) && true == DISABLE_WP_CRON ) {
			return 1;
		}

		return 0;
	}

	/**
	 * Hide warnings in rest api.
	 *
	 * @since  1.0.0
	 */
	public function hide_warnings_in_rest_api() {
		if ( self::is_rest() ) {
			error_reporting( E_ERROR | E_PARSE );
		}
	}

	/**
	 * Checks if the current request is a WP REST API request.
	 *
	 * Case #1: After WP_REST_Request initialisation
	 * Case #2: Support "plain" permalink settings
	 * Case #3: URL Path begins with wp-json/ (your REST prefix)
	 *          Also supports WP installations in subfolders
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if it's rest request, false otherwise.
	 */
	public static function is_rest() {
		$prefix = rest_get_url_prefix();

		if (
			defined( 'REST_REQUEST' ) && REST_REQUEST ||
			(
				isset( $_GET['rest_route'] ) &&
				0 === @strpos( trim( $_GET['rest_route'], '\\/' ), $prefix, 0 )
			)
		) {
			return true;
		}

		$rest_url    = wp_parse_url( site_url( $prefix ) );
		$current_url = wp_parse_url( add_query_arg( array() ) );

		return 0 === @strpos( $current_url['path'], $rest_url['path'], 0 );
	}

	/**
	 * Our custom error handler
	 *
	 * @since 1.0.0
	 *
	 * @param int    $errno        The first parameter, errno, contains the level of the error raised.
	 * @param string $errstr    The second parameter, errstr, contains the error message.
	 * @param string $errfile   The third parameter is optional, errfile, which contains the
	 *                          filename that the error was raised in.
	 * @param int    $errline      The fourth parameter is optional, errline, which contains the line
	 *                             number the error was raised at.
	 * @param array  $errcontext The fifth parameter is optional, errcontext that contains an array
	 *                           of every variable that existed in the scope the error was triggered
	 *                           in. User error handler must not modify error context.
	 * @return bool             True if error is within /plugins, false otherwise.
	 */
	public function error_handler( $errno, $errstr, $errfile, $errline, $errcontext = array() ) {
		// Path to error file.
		$error_file = str_replace( '\\', '/', $errfile );

		// Path to plugins.
		$vendor = str_replace( '\\', '/', SG_Security\DIR . '/vendor' );

		// Do nothing for errors inside of the plugins directory.
		if ( @strpos( $error_file, $vendor ) !== false ) {
			return true;
		}

		// Default error handler otherwise.
		return false;
	}

	/**
	 * Some plugins like WPML for example are overwriting the home url.
	 *
	 * @since  1.0.0
	 *
	 * @return string The real home url.
	 */
	public static function get_home_url() {
		$url = get_option( 'home' );

		$scheme = is_ssl() ? 'https' : parse_url( $url, PHP_URL_SCHEME );

		$url = set_url_scheme( $url, $scheme );

		return trailingslashit( $url );
	}

	/**
	 * Some plugins like WPML for example are overwriting the site url.
	 *
	 * @since  1.0.0
	 *
	 * @return string The real site url.
	 */
	public static function get_site_url() {
		$url = get_option( 'siteurl' );

		$scheme = is_ssl() ? 'https' : parse_url( $url, PHP_URL_SCHEME );

		$url = set_url_scheme( $url, $scheme );

		return trailingslashit( $url );
	}

	/**
	 * Get WordPress uploads dir
	 *
	 * @since  1.0.0
	 *
	 * @return string Path to the uploads dir.
	 */
	public static function get_uploads_dir() {
		// Get the uploads dir.
		$upload_dir = wp_upload_dir();

		$base_dir = $upload_dir['basedir'];

		if ( defined( 'UPLOADS' ) ) {
			$base_dir = ABSPATH . UPLOADS;
		}

		return $base_dir;
	}

	/**
	 * Get the current user's ip address.
	 *
	 * @since  1.0.0
	 *
	 * @return string The users's ip.
	 */
	public static function get_current_user_ip() {

		$keys = array(
			'HTTP_CLIENT_IP',
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_FORWARDED',
			'HTTP_X_CLUSTER_CLIENT_IP',
			'HTTP_FORWARDED_FOR',
			'HTTP_FORWARDED',
			'REMOTE_ADDR',
		);

		foreach ( $keys as $key ) {
			// Bail if the key doesn't exists.
			if ( ! isset( $_SERVER[ $key ] ) ) {
				continue;
			}

			// Bail if the IP is not valid.
			if ( ! filter_var( $_SERVER[ $key ], FILTER_VALIDATE_IP ) ) { //phpcs:ignore
				continue;
			}

			return str_replace( '::1', '127.0.0.1', $_SERVER[ $key ] ); //phpcs:ignore
		}

		// Return the local IP by default.
		return '127.0.0.1';
	}

	/**
	 * Check for any updates available.
	 *
	 * @since  1.0.0
	 *
	 * @return boolean True if we have, false otherwise.
	 */
	public static function has_updates() {
		// Get dependencies.
		require_once( ABSPATH . 'wp-admin/includes/update.php' );

		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		// Check for theme updates.
		if ( ! empty( get_theme_updates() ) ) {
			return true;
		}

		// Check for plugin updates.
		if ( ! empty( get_plugin_updates() ) ) {
			return true;
		}

		$core = get_core_updates();

		// Check for core.
		if ( 'latest' !== $core[0]->response ) {
			return true;
		}

		// Check for translation updates.
		if ( ! empty( wp_get_translation_updates() ) ) {
			return true;
		}

		// Bail if we do not have any updates available.
		return false;
	}
}
