<?php


namespace Codemanas\ZoomWooCommerceAppointments\Main;


use Codemanas\ZoomWooCommerceAppointments\Core\Fields;

class AppointmentsStaff {
	public static $_instance = null;

	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	public function __construct() {
		add_action( 'edit_user_profile', [ $this, 'generate_staff_selection_option' ], 100 );
		add_action( 'user_new_form', [ $this, 'generate_staff_selection_option' ], 100 );
		add_action( 'edit_user_profile_update', [ $this, 'update_staff_selection' ] );
		add_action( 'user_register', [ $this, 'update_staff_selection' ] );
	}



	//generate form fields for host id selections

	/**
	 * @param \WP_User $user
	 */
	public function generate_staff_selection_option( $user = false ) {
		?>
        <script>
            jQuery(function ($) {
                var zoomRoleOptions = {
                    init: function () {
                        this.$role = $('#role');
                        this.$zoomHostAssignWrapper = $('#zoom-assign-host__wrapper');
                        this.toggleZoomHostAssingForm();
                        this.$role.on('change', this.toggleZoomHostAssingForm.bind(this));
                    },
                    toggleZoomHostAssingForm() {
                        if (this.$role.val() === 'shop_staff') {
                            this.$zoomHostAssignWrapper.show();
                        } else {
                            this.$zoomHostAssignWrapper.hide();
                        }
                    }
                }
                zoomRoleOptions.init();
            });
        </script>
        <div id="zoom-assign-host__wrapper" style="display: none">
            <h3 id="zoom-assign-host__header"><?php _e( 'Assign Staff Host', 'vczapi-woocommerce-appointments' ); ?></h3>
            <table class="form-table">
                <tr>
                    <th>
                        <label for="zoom-staff-host"><?php _e( 'Zoom Host for Staff', 'vczapi-woocommerce-appointments' ); ?></label>
                    </th>
                    <td>
						<?php
						$users           = video_conferencing_zoom_api_get_user_transients();
						$zoom_staff_host = false;
						if ( $user ) {
							$zoom_staff_host = Fields::get_user_meta( $user->ID, 'zoom_staff_host' );
						}
						if ( ! empty( $users ) ) {
						?>
                        <select id="zoom-staff-host" name="zoom-staff-host">
                            <option value="">Select Zoom Host</option>
							<?php
							foreach ( $users as $user ) {
								$user_nice_name = ! empty( $user->first_name ) ? $user->first_name . ' ' . $user->last_name : $user->email;
								echo '<option value="' . $user->id . '" ' . selected( $user->id, $zoom_staff_host ) . '>' . $user_nice_name . '</option>';
							}
							?>
							<?php
							}
							?>
                        </select>
                        <p class="description"><?php _e( 'If left empty, first selected host in product will be used as host', 'vczapi-woocommerce-appointments' ); ?></p>
                    </td>
                </tr>
            </table>
        </div>

		<?php
	}

	/*
	 * @param int $user_id
	 */
	public function update_staff_selection( $user_id ) {
		$user = get_user_by( 'id', $user_id );
		if ( is_object( $user ) && in_array( 'shop_staff', $user->roles ) ) {
			$zoom_staff_host = filter_input( INPUT_POST, 'zoom-staff-host' );
			if ( ! empty( $zoom_staff_host ) ) {
				Fields::set_user_meta( $user_id, 'zoom_staff_host', $zoom_staff_host );
			} else {
				delete_user_meta( $user_id, Fields::getFieldsSlug() . 'zoom_staff_host' );
			}
		}
	}

}