<?php

namespace Codemanas\ZoomWooCommerceAppointments\Backend\Settings;

/**
 * Class Settings
 *
 * Add setting options to settings page
 *
 * @author  Deepen Bajracharya, CodeManas, 2020. All Rights reserved.
 * @since   1.0.0
 * @package Codemanas\ZoomWooCommerceAppointments\Backend
 */
class Settings {

	private $licensing;

	/**
	 * Settings constructor.
	 *
	 * @param \Codemanas\ZoomWooCommerceAppointments\Backend\Settings\Licensing $licensing
	 */
	public function __construct( Licensing $licensing ) {
		$this->licensing = $licensing;
		$this->call_hooks();
		General::get_instance();
	}

	/**
	 * Calling wordpress hooks
	 */
	public function call_hooks() {
		add_action( 'vczapi_admin_tabs_heading', array( $this, 'settings_tab' ) );
		add_action( 'vczapi_admin_tabs_content', array( $this, 'settings_body' ) );
	}

	/**
	 * Add licensing tab to admin area
	 *
	 * @param $active_tab
	 */
	public function settings_tab( $active_tab ) {
		?>
        <a href="<?php echo add_query_arg( array( 'tab' => 'woocommerce-appointments-licensing' ) ); ?>" class="nav-tab <?php echo ( 'woocommerce-appointments-licensing' === $active_tab ) ? esc_attr( 'nav-tab-active' ) : ''; ?>">
			<?php esc_html_e( 'WooCommerce Appointments', 'vczapi-woocommerce-appointments' ); ?>
        </a>
		<?php
	}

	/**
	 * Show Licensing tab body section
	 *
	 * @param $active_tab
	 *
	 * @throws \Exception
	 */
	public function settings_body( $active_tab ) {
		$section = isset( $_GET['section'] ) ? $_GET['section'] : false;
		?>
        <div class="vczapi-settings-admin-wrap vczapi-settings-admin-support">
			<?php
			if ( 'woocommerce-appointments-licensing' === $active_tab ) {
				$this->sub_menu_section_head( $active_tab, $section );
				echo '<div class="vczapi-settings-admin-support-bg">';
				$this->sub_menu_section_body( $active_tab, $section );
				echo '</div>';
			}
			?>
        </div>
		<?php
	}

	/**
	 * Show Sub menu sections
	 *
	 * @param $active_tab
	 * @param $section
	 */
	public function sub_menu_section_head( $active_tab, $section ) {
		?>
        <style>
            .vczapi-settings-admin-wrap .subsubsub {
                float: unset;
            }

            .vczapi-settings-admin-wrap .subsubsub li:after {
                content: '|';
                padding-left: 3px;
            }
        </style>
        <ul class="subsubsub sub-vczapi-woocommerce-appointments-menu-admin" style="">
            <li>
                <a href="<?php echo add_query_arg( array( 'section' => 'general' ) ); ?>"
                   class="<?php echo ( empty( $section ) || $section == 'general' ) ? 'current' : ''; ?>"
                >General</a>
            </li>
            <li>
                <a href="<?php echo add_query_arg( array( 'section' => 'licensing' ) ); ?>" class="<?php echo ! empty( $section ) && $active_tab == "woocommerce-appointments-licensing" && $section == "licensing" ? 'current' : false; ?>">Licensing</a>
            </li>
        </ul>
		<?php
	}

	/**
	 * Show sub menu body HTML
	 *
	 * @param $active_tab
	 * @param $section
	 */
	public function sub_menu_section_body( $active_tab, $section ) {
		if ( $active_tab != 'woocommerce-appointments-licensing' ) {
			return;
		}

		if ( $section == '' || $section == 'general' ) {
			include_once VCZAPI_WOOCOMMERCE_APPOINTMENTS_DIR . '/includes/Backend/Settings/tpl-general.php';
		} else if ( $section === "licensing" ) {
			$license = $this->licensing;
			$license = $license::get_instance();
			$license->show_license_form();
		}
	}
}