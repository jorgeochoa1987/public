<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class LP_PMS_Setting
 */
class LP_PMS_Setting extends LP_Abstract_Settings_Page {

	public function __construct() {
		$this->id   = 'membership';
		$this->text = esc_html__( 'Memberships', 'ecademy-toolkit' );

		parent::__construct();
	}

	public function output_section_general() {
		include LP_ADDON_PMPRO_PATH . '/inc/views/membership.php';
	}

	/**
	 * Get setting lp pms
	 *
	 * @param string $section
	 * @param string $tab
	 *
	 * @return array|array[]|bool|mixed
	 */
	public function get_settings( $section = '', $tab = '' ) {
		$crojob_disabled = '';

		if ( ! LP_Addon_Paid_Memberships_Pro_Preload::$_WP_CRON_STATUS ) {
			$crojob_disabled = '<strong style="color: red">' . __( 'Cron job is disabled, please enable that', 'ecademy-toolkit' ) . '</strong>';
		}

		$desc_mode_run  = __( '1. <strong>Auto</strong>: system will auto detected number courses of level and process', 'ecademy-toolkit' );
		$desc_mode_run .= '<br>' . __( '2. <strong>Normal</strong>: best for site small data', 'ecademy-toolkit' );
		$desc_mode_run .= '<br>' . __( '3. <strong>Background</strong>: run cron-job (best for site big data). After 10 second user subscription level, system LP wil update courses to LP order', 'ecademy-toolkit' );
		$desc_mode_run .= '<br>' . $crojob_disabled;

		$link_levels_pms = '<a href="' . home_url( 'wp-admin/admin.php?page=pmpro-membershiplevels' ) . '">level</a>';

		$desc_auto_update_list_courses_on_level  = sprintf( '%s %s', __( 'LP Orders\'s users bought level PMS will update list courses when save', 'ecademy-toolkit' ), $link_levels_pms );
		$desc_auto_update_list_courses_on_level .= '<br><span style="color: red">' . __( 'Note: when remove courses on list, all progress of those courses of users will lose', 'ecademy-toolkit' ) . '</span>';

		return apply_filters(
			'lp-pms-fields-setting',
			array(
				array(
					'title' => __( 'Paid Memberships Pro add-on for LearnPress', 'ecademy-toolkit' ),
					'type'  => 'title',
				),
				array(
					'title'   => __( 'Always buy the course through membership', 'ecademy-toolkit' ),
					'id'      => 'buy_through_membership',
					'default' => 'no',
					'type'    => 'yes-no',
				),
				array(
					'title'      => __( 'Button Buy Course', 'ecademy-toolkit' ),
					'id'         => 'button_buy_course',
					'default'    => 'Buy Now',
					'type'       => 'text',
					'visibility' => array(
						'state'       => 'show',
						'conditional' => array(
							array(
								'field'   => 'buy_through_membership',
								'compare' => '!=',
								'value'   => 'yes',
							),
						),
					),
				),
				array(
					'title'   => __( 'Button Buy Membership', 'ecademy-toolkit' ),
					'id'      => 'button_buy_membership',
					'default' => 'Buy Membership',
					'type'    => 'text',
				),
				array(
					'type' => 'sectionend',
				),
				// array(
				// 	'title' => __( 'When membership access expires', 'ecademy-toolkit' ),
				// 	'type'  => 'title',
				// ),
				// array(
				// 'title'   => __( 'Preven access course', 'ecademy-toolkit' ),
				// 'id'      => 'pmpro_prevent_access_course',# mean cancel user order
				// 'default' => 'yes',
				// 'type'    => 'yes-no',
				// ),
				array(
					'title' => __( 'When membership level change', 'ecademy-toolkit' ),
					'type'  => 'title',
				),
				array(
					'title'   => __( 'Update access courses when level change list courses', 'ecademy-toolkit' ),
					'id'      => 'pmpro_update_access_course',
					'desc'    => $desc_auto_update_list_courses_on_level,
					'default' => 'no',
					'type'    => 'yes-no',
				),
				array(
					'title'   => __( 'Run mode', 'ecademy-toolkit' ),
					'id'      => 'pmpro_run_mode',
					'desc'    => $desc_mode_run,
					'default' => 'yes',
					'type'    => 'select',
					'options' => lp_pmpro_run_mode(),
				),
				array(
					'type' => 'sectionend',
				),
			)
		);
	}
}

return new LP_PMS_Setting();
