<?php

namespace Codemanas\ZoomWooCommerceAppointments\Core;

/**
 * Interface for fields
 *
 * @author Deepen Bajracharya, CodeManas, 2020. All Rights reserved.
 * @since 1.0.0
 * @package Codemanas\ZoomWooCommerceAppointments
 */
interface FieldsInterface {

	public static function set_option( $key, $value );

	public static function get_option( $key );

	public static function set_meta( $post_id, $key, $value );

	public static function get_meta( $post_id, $key );

	public static function delete_option( $key );

}