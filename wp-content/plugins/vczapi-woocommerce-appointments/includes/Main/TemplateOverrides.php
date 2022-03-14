<?php


namespace Codemanas\ZoomWooCommerceAppointments\Main;


use Codemanas\ZoomWooCommerceAppointments\Helpers\Templates;

class TemplateOverrides {

	public function __construct() {
		add_filter( 'wc_get_template', array( $this, 'templates' ), 10, 5 );
	}

	/**
	 * Give me templates
	 *
	 * @param $located
	 * @param $template_name
	 * @param $args
	 * @param $template_path
	 * @param $default_path
	 *
	 * @return string
	 */
	public function templates( $located, $template_name, $args, $template_path, $default_path ) {
		if ( 'myaccount/appointments.php' == $template_name ) {
			$located = Templates::get_template_path( 'myaccount/appointments.php',$located);
		}

		//for woocommerce appointment reminder e-mail
		if ( 'emails/customer-appointment-reminder.php' == $template_name ) {
			$located = Templates::get_template_path( 'emails/customer-appointment-reminder.php', $located );
		}

		return $located;
	}
}