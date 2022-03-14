<?php
namespace SG_Security\Rest;

/**
 * Main Rest class.
 */
class Rest {

	const REST_NAMESPACE = 'sg-security/v1';

	/**
	 * The constructor.
	 */
	public function __construct() {
		$this->options_helper       = new Rest_Helper_Options();
		$this->post_hack_helper     = new Rest_Helper_Post_Hack_Actions();
		$this->site_security_helper = new Rest_Helper_Site_Security();
		$this->login_helper         = new Rest_Helper_Login();
		$this->dashboard_helper     = new Rest_Helper_Dashboard();
		$this->activity_helper      = new Rest_Helper_Activity();
	}

	/**
	 * Check if a given request has admin access
	 *
	 * @since  1.0.0
	 *
	 * @param  WP_REST_Request $request Full data about the request.
	 */
	public function check_permissions( $request ) {
		return current_user_can( 'activate_plugins' );
	}

	/**
	 * Register rest routes.
	 *
	 * @since  1.0.0
	 */
	public function register_rest_routes() {
		$this->register_options_routes();
		$this->register_post_hack_action_routes();
		$this->register_site_security_routes();
		$this->register_login_routes();
		$this->register_dashboard_routes();
		$this->register_activity_log_routes();
	}

	/**
	 * Register options rest routes.
	 *
	 * @since  1.0.0
	 */
	public function register_options_routes() {
		register_rest_route(
			self::REST_NAMESPACE, '/fetch-options/', array(
				'methods'             => 'POST',
				'callback'            => array( $this->options_helper, 'fetch_options' ),
				'permission_callback' => array( $this, 'check_permissions' ),
			)
		);
	}

	/**
	 * Register post hack rest routes.
	 *
	 * @since  1.0.0
	 */
	public function register_post_hack_action_routes() {
		register_rest_route(
			self::REST_NAMESPACE, '/reinstall-plugins/', array(
				'methods'             => 'POST',
				'callback'            => array( $this->post_hack_helper, 'resinstall_plugins' ),
				'permission_callback' => array( $this, 'check_permissions' ),
			)
		);

		register_rest_route(
			self::REST_NAMESPACE, '/force-password-reset/', array(
				'methods'             => 'POST',
				'callback'            => array( $this->post_hack_helper, 'force_password_reset' ),
				'permission_callback' => array( $this, 'check_permissions' ),
			)
		);

		register_rest_route(
			self::REST_NAMESPACE, '/logout-users/', array(
				'methods'             => 'POST',
				'callback'            => array( $this->post_hack_helper, 'logout_users' ),
				'permission_callback' => array( $this, 'check_permissions' ),
			)
		);
	}

	/**
	 * Register site security rest routes.
	 *
	 * @since  1.0.0
	 */
	public function register_site_security_routes() {
		register_rest_route(
			self::REST_NAMESPACE, '/lock-system-folders/', array(
				'methods'             => 'POST',
				'callback'            => array( $this->site_security_helper, 'lock_system_folders' ),
				'permission_callback' => array( $this, 'check_permissions' ),
			)
		);

		register_rest_route(
			self::REST_NAMESPACE, '/disable-editors/', array(
				'methods'             => 'POST',
				'callback'            => array( $this->site_security_helper, 'disable_editors' ),
				'permission_callback' => array( $this, 'check_permissions' ),
			)
		);

		register_rest_route(
			self::REST_NAMESPACE, '/hide-wp-version/', array(
				'methods'             => 'POST',
				'callback'            => array( $this->site_security_helper, 'hide_wp_version' ),
				'permission_callback' => array( $this, 'check_permissions' ),
			)
		);

		register_rest_route(
			self::REST_NAMESPACE, '/disable-xml-rpc/', array(
				'methods'             => 'POST',
				'callback'            => array( $this->site_security_helper, 'disable_xml_rpc' ),
				'permission_callback' => array( $this, 'check_permissions' ),
			)
		);

		register_rest_route(
			self::REST_NAMESPACE, '/disable-feeds/', array(
				'methods'             => 'POST',
				'callback'            => array( $this->site_security_helper, 'disable_feeds' ),
				'permission_callback' => array( $this, 'check_permissions' ),
			)
		);

		register_rest_route(
			self::REST_NAMESPACE, '/delete-readme/', array(
				'methods'             => 'POST',
				'callback'            => array( $this->site_security_helper, 'delete_readme' ),
				'permission_callback' => array( $this, 'check_permissions' ),
			)
		);

		register_rest_route(
			self::REST_NAMESPACE, '/xss-protection/', array(
				'methods'             => 'POST',
				'callback'            => array( $this->site_security_helper, 'xss_protection' ),
				'permission_callback' => array( $this, 'check_permissions' ),
			)
		);
	}

	/**
	 * Register login rest routes.
	 *
	 * @since  1.0.0
	 */
	public function register_login_routes() {
		register_rest_route(
			self::REST_NAMESPACE, '/2fa/', array(
				'methods'             => 'POST',
				'callback'            => array( $this->login_helper, 'sg2fa' ),
				'permission_callback' => array( $this, 'check_permissions' ),
			)
		);

		register_rest_route(
			self::REST_NAMESPACE, '/disable-admin-username/', array(
				'methods'             => 'POST',
				'callback'            => array( $this->login_helper, 'disable_admin_username' ),
				'permission_callback' => array( $this, 'check_permissions' ),
			)
		);

		register_rest_route(
			self::REST_NAMESPACE, '/login-access/', array(
				'methods'             => 'POST',
				'callback'            => array( $this->login_helper, 'login_access' ),
				'permission_callback' => array( $this, 'check_permissions' ),
			)
		);

		register_rest_route(
			self::REST_NAMESPACE, '/limit-login-attempts/', array(
				'methods'             => 'POST',
				'callback'            => array( $this->login_helper, 'limit_login_attempts' ),
				'permission_callback' => array( $this, 'check_permissions' ),
			)
		);
	}

	/**
	 * Register dashboard rest routes.
	 *
	 * @since  1.0.0
	 */
	public function register_dashboard_routes() {
		register_rest_route(
			self::REST_NAMESPACE, '/notifications/', array(
				'methods'             => 'POST',
				'callback'            => array( $this->dashboard_helper, 'notifications' ),
				'permission_callback' => array( $this, 'check_permissions' ),
			)
		);

		register_rest_route(
			self::REST_NAMESPACE, '/hardening/', array(
				'methods'             => 'POST',
				'callback'            => array( $this->dashboard_helper, 'hardening' ),
				'permission_callback' => array( $this, 'check_permissions' ),
			)
		);

		register_rest_route(
			self::REST_NAMESPACE, '/e-book/', array(
				'methods'             => 'POST',
				'callback'            => array( $this->dashboard_helper, 'ebook' ),
				'permission_callback' => array( $this, 'check_permissions' ),
			)
		);
	}

	/**
	 * Register activity log rest routes.
	 *
	 * @since  1.0.0
	 */
	public function register_activity_log_routes() {
		register_rest_route(
			self::REST_NAMESPACE, '/activity-unknown/', array(
				'methods'             => 'POST',
				'callback'            => array( $this->activity_helper, 'unknown_activity' ),
				'permission_callback' => array( $this, 'check_permissions' ),
			)
		);

		register_rest_route(
			self::REST_NAMESPACE, '/activity-registered/', array(
				'methods'             => 'POST',
				'callback'            => array( $this->activity_helper, 'registered_activity' ),
				'permission_callback' => array( $this, 'check_permissions' ),
			)
		);

		register_rest_route(
			self::REST_NAMESPACE, '/blocked-users/', array(
				'methods'             => 'POST',
				'callback'            => array( $this->activity_helper, 'get_blocked_user' ),
				'permission_callback' => array( $this, 'check_permissions' ),
			)
		);

		register_rest_route(
			self::REST_NAMESPACE, '/block-ip/(?P<id>\d+)', array(
				'methods'             => 'POST',
				'callback'            => array( $this->activity_helper, 'block_ip' ),
				'permission_callback' => array( $this, 'check_permissions' ),
				'args'                => array(
					'ip' => array(
						'validate_callback' => function( $param, $request, $key ) {
							return filter_var( $param, FILTER_VALIDATE_IP );
						},
					),
				),
			)
		);

		register_rest_route(
			self::REST_NAMESPACE, '/block-user/(?P<id>\d+)', array(
				'methods'             => 'POST',
				'callback'            => array( $this->activity_helper, 'block_user' ),
				'permission_callback' => array( $this, 'check_permissions' ),
				'args'                => array(
					'id' => array(
						'validate_callback' => function( $param, $request, $key ) {
							return is_numeric( $param );
						},
					),
				),
			)
		);

		register_rest_route(
			self::REST_NAMESPACE, '/unblock/(?P<id>\d+)', array(
				'methods'             => 'POST',
				'callback'            => array( $this->activity_helper, 'unblock' ),
				'permission_callback' => array( $this, 'check_permissions' ),
				'args'                => array(
					'id' => array(
						'validate_callback' => function( $param, $request, $key ) {
							return is_numeric( $param );
						},
					),
				),
			)
		);

		register_rest_route(
			self::REST_NAMESPACE, '/get-visitor-status/(?P<id>\d+)', array(
				'methods'             => 'POST',
				'callback'            => array( $this->activity_helper, 'get_visitor_status' ),
				'permission_callback' => array( $this, 'check_permissions' ),
				'args'                => array(
					'ip' => array(
						'validate_callback' => function( $param, $request, $key ) {
							return is_numeric( $param );
						},
					),
				),
			)
		);
	}
}
