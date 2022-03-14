<?php


namespace Codemanas\ZoomWooCommerceAppointments\Helpers;

class Templates {
	public static $theme_folder = 'vczapi-woocommerce-appointments';
	public static $template_dir = VCZAPI_WOOCOMMERCE_APPOINTMENTS_DIR . '/templates/';

	public static function get_template_path( $template_name, $located ) {
		$located_in_theme         = locate_template( self::$theme_folder . '/' . $template_name );
		$plugin_template_location = self::get_template_dir() . $template_name;


		if ( $located_in_theme ) {
			$located = $located_in_theme;
		} else if ( file_exists( $plugin_template_location ) ) {
			$located = $plugin_template_location;
		}

		return $located;
	}

	public static function get_template_dir( $template_dir = '' ) {
		$template_dir = empty( $template_dir ) ? self::$template_dir : $template_dir;

		return $template_dir;
	}

	public static function include_file( $file = '', $args = array() ) {
		if ( locate_template( self::$theme_folder . '/' . $file ) ) {
			locate_template( self::$theme_folder . '/' . $file, true );
		} else {
			$file_path = self::get_template_dir() . $file;
			if ( file_exists( $file_path ) ) {
				include $file_path;
			}
		}
	}
}

