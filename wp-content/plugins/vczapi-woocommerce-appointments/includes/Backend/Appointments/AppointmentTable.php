<?php

namespace Codemanas\ZoomWooCommerceAppointments\Backend\Appointments;

use Codemanas\ZoomWooCommerceAppointments\Main\DataStore as DataStore;

/**
 * Class AppointmentTable
 *
 * Manage all appointment admin settings from here
 *
 * @author Deepen Bajracharya, CodeManas, 2020. All Rights reserved.
 * @package Codemanas\ZoomWooCommerceAppointments\Admin
 * @since 1.0.0
 */
class AppointmentTable {

	private $type = 'wc_appointment';

	public function __construct() {
		add_filter( 'manage_' . $this->type . '_posts_columns', array( $this, 'add_columns' ), 20 );
		add_action( 'manage_' . $this->type . '_posts_custom_column', array( $this, 'render_data' ), 20, 2 );
	}

	/**
	 * Add New Start Link column
	 *
	 * @param $columns
	 *
	 * @return mixed
	 */
	public function add_columns( $columns ) {
		$columns['zoom_start_link'] = __( 'Start Link', 'vczapi-woocommerce-appointments' );

		return $columns;
	}

	/**
	 * Render HTML
	 *
	 * @param $column
	 * @param $post_id
	 */
	public function render_data( $column, $post_id ) {
		switch ( $column ) {

			case 'zoom_start_link' :
				echo DataStore::get_start_link( get_wc_appointment( $post_id ) );
				break;
		}
	}
}
