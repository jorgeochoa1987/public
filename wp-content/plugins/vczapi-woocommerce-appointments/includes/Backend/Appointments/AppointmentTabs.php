<?php

namespace Codemanas\ZoomWooCommerceAppointments\Backend\Appointments;

use Codemanas\ZoomWooCommerceAppointments\Core\Fields;

/**
 * Class ProductTabs
 *
 * Display and render new tabs in single product page on wp-admin
 *
 * @author  Deepen Bajracharya, CodeManas, 2020. All Rights reserved.
 * @package Codemanas\ZoomWooCommerceAppointments\Admin
 * @since   1.0.0
 */
class AppointmentTabs {

	public function __construct() {
		add_filter( 'woocommerce_product_data_tabs', array( $this, 'register_tabs' ) );
		add_action( 'woocommerce_product_data_panels', array( $this, 'render_panels' ) );
		add_action( 'woocommerce_process_product_meta_appointment', array( $this, 'save' ) );
	}

	/**
	 * Register New tab event
	 *
	 * @param $tabs
	 *
	 * @return mixed
	 */
	public function register_tabs( $tabs ) {
		$tabs['vczapi-woocommerce-appointments'] = array(
			'label'  => __( 'Zoom', 'vczapi-woocommerce-appointments' ),
			'target' => 'vczapi_woocommerce_appointments_product_data',
			'class'  => array(
				'show_if_appointment vczapi-zoom-booking-icon',
			)
		);

		return $tabs;
	}

	/**
	 * Render tab panel HTML
	 */
	public function render_panels() {
		global $post;
		?>
        <div id='vczapi_woocommerce_appointments_product_data' class='panel woocommerce_options_panel'>
	        <?php
	        $users        = video_conferencing_zoom_api_get_user_transients();
	        $user_options = array();
	        if ( ! empty( $users ) ) {
		        foreach ( $users as $user ) {
			        $user_options[ $user->id ] = ! empty( $user->first_name ) ? $user->first_name . ' ' . $user->last_name : $user->email;
		        }
	        }
	        $user_options = apply_filters( 'vczapi_bookings_hosts', $user_options );
	        $saved_host   = get_post_meta( $post->ID, '_vczapi_woocommerce_appointments_product_host', true );
	        $host_exists  = false;
	        if ( ! empty( $saved_host ) ) {
		        foreach ( $user_options as $host_id => $host_name ) {
			        if ( $host_id == $saved_host ) {
				        $host_exists = true;
				        break;
			        }
		        }
	        }

	        if ( $host_exists == false ) {
		        ?>
                <p class="warning" style="color:red; padding-left:10px;">
			        <?php
			        _e( 'WARNING: It seems like Zoom Host previously saved no longer exists, this will cause issues when booking is made,
				    Please select a host and save the product again.' );
			        ?>
                </p>
		        <?php
	        }
	        ?>
            <div class='options_group'>
				<?php

				woocommerce_wp_checkbox( array(
					'id'          => '_vczapi_woocommerce_appointments_enable_zoom',
					'label'       => __( 'Enable Zoom Meeting', 'vczapi-woocommerce-appointments' ),
					'description' => __( 'Checking this option will create a meeting when this product is booked.', 'vczapi-woocommerce-appointments' ),
					'default'     => '0',
					'desc_tip'    => false,
				) );

				woocommerce_wp_select(
					array(
						'id'          => '_vczapi_woocommerce_appointments_product_host',
						'label'       => __( 'Default Host', 'woocommerce' ),
						'options'     => $user_options,
						'description' => __( 'Select which host would be responsible for hosting this booking product. Add more users to your zoom account to show them here.', 'vczapi-woocommerce-appointments' ),
						'desc_tip'    => true,
					)
				);

				woocommerce_wp_checkbox( array(
					'id'          => '_vczapi_woocommerce_appointments_jbh',
					'label'       => __( 'Allow Join Before Host ?', 'vczapi-woocommerce-appointments' ),
					'description' => __( 'Allow participants to join the meeting before the host starts the meeting. Only used for scheduled or recurring meetings.', 'vczapi-woocommerce-appointments' ),
					'default'     => '0',
					'desc_tip'    => false,
				) );
				?>
            </div>
            <p class="description" style="color:red;">NOTE: If you enable Zoom Meetings, <strong>General > Appointment Duration</strong> should be defined
                in hours or minutes.</p>
        </div>
		<?php
	}

	/**
	 * Save Tab Data on post
	 *
	 * @param $post_id
	 */
	function save( $post_id ) {
		$enable        = sanitize_text_field( filter_input( INPUT_POST, '_vczapi_woocommerce_appointments_enable_zoom' ) );
		$host          = sanitize_text_field( filter_input( INPUT_POST, '_vczapi_woocommerce_appointments_product_host' ) );
		$jbh           = sanitize_text_field( filter_input( INPUT_POST, '_vczapi_woocommerce_appointments_jbh' ) );

		Fields::set_meta($post_id,'enable_zoom',$enable);
		Fields::set_meta($post_id,'product_host',$host);
		Fields::set_meta($post_id,'jbh',$jbh);
	}
}