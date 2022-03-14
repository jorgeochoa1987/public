<?php
/*
 * Plugin Name: eCademy Toolkit
 * Author: EnvyTheme
 * Author URI: envytheme.com
 * Description: A Light weight and easy toolkit for eCademy Theme.
 * Version: 4.9.1
 * Domain Path: /languages
 * Text Domain: ecademy-toolkit
 *
 */

if (!defined('ABSPATH')) {
    exit; //Exit if accessed directly
}

define('ECADEMY_ACC_PATH', plugin_dir_path(__FILE__));
if( !defined('ECADEMY_FRAMEWORK_VAR') ) define('ECADEMY_FRAMEWORK_VAR', 'ecademy_opt');

// Disable Elementor's Default Colors and Default Fonts
update_option( 'elementor_disable_color_schemes', 'yes' );
update_option( 'elementor_disable_typography_schemes', 'yes' );
update_option( 'elementor_global_image_lightbox', '' );

function ecademy_init() {
    load_plugin_textdomain( 'ecademy-toolkit', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'ecademy_init' );

/**
 * Custom post taxonomy
 */
function ecademy_custom_post_taxonomy(){
	register_taxonomy(
		'instructor_cat',
		'instructor',
		  array(
			'hierarchical'      => true,
			'label'             => esc_html__('Instructor Category', 'ecademy-toolkit' ),
			'query_var'         => true,
			'show_admin_column' => true,
				'rewrite'         => array(
				'slug'          => 'instructor-category',
				'with_front'    => true
				)
		  )
	);
  }
add_action('init', 'ecademy_custom_post_taxonomy');

/**
 * Main Elementor ecademy Extension Class
 */
final class Elementor_eCademy_Extension {

	const VERSION = '1.0.0';
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
	const MINIMUM_PHP_VERSION = '7.0';

	// Instance
    private static $_instance = null;

	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	// Constructor
	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'init' ] );

	}

	// init
	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		// Add Plugin actions
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );

        add_action('elementor/elements/categories_registered',[ $this, 'register_new_category'] );

    }

    public function register_new_category($manager){
        $manager->add_category('ecademy-elements',[
            'title'=>esc_html__('eCademy','ecademy-toolkit'),
            'icon'=> 'fa fa-image'
        ]);
    }

	//Admin notice
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'ecademy-toolkit' ),
			'<strong>' . esc_html__( 'eCademy Toolkit', 'ecademy-toolkit' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'ecademy-toolkit' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'ecademy-toolkit' ),
			'<strong>' . esc_html__( 'eCademy Toolkit', 'ecademy-toolkit' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'ecademy-toolkit' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'ecademy-toolkit' ),
			'<strong>' . esc_html__( 'eCademy Toolkit', 'ecademy-toolkit' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'ecademy-toolkit' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	// Toolkit Widgets
	public function init_widgets() {

		// Include Widget files
		$pcs = trim( get_option( 'ecademy_purchase_code_status' ) );
		if ( $pcs == 'valid' ) {
			require_once( __DIR__ . '/widgets/section.php' );
			require_once( __DIR__ . '/widgets/banner-one.php' );
			require_once( __DIR__ . '/widgets/banner-two.php' );
			require_once( __DIR__ . '/widgets/banner-three.php' );
			require_once( __DIR__ . '/widgets/banner-four.php' );
			require_once( __DIR__ . '/widgets/banner-five.php' );
			require_once( __DIR__ . '/widgets/banner-slider.php' );
			require_once( __DIR__ . '/widgets/main-banner-area.php' );
			require_once( __DIR__ . '/widgets/modern-schooling-hero.php' );
			require_once( __DIR__ . '/widgets/yoga-hero.php' );
			require_once( __DIR__ . '/widgets/health-coaching-hero.php' );
			require_once( __DIR__ . '/widgets/kindergarten-hero.php' );
			require_once( __DIR__ . '/widgets/partner.php' );
			require_once( __DIR__ . '/widgets/features-boxes.php' );
			require_once( __DIR__ . '/widgets/features-boxes.php' );
			require_once( __DIR__ . '/widgets/language-courses.php' );
			require_once( __DIR__ . '/widgets/distance-learning.php' );
			require_once( __DIR__ . '/widgets/courses.php' );
			require_once( __DIR__ . '/widgets/courses-filter.php' );
			require_once( __DIR__ . '/widgets/feedback.php' );
			require_once( __DIR__ . '/widgets/feedback-two.php' );
			require_once( __DIR__ . '/widgets/feedback-three.php' );
			require_once( __DIR__ . '/widgets/feedback-slider.php' );
			require_once( __DIR__ . '/widgets/funfacts.php' );
			require_once( __DIR__ . '/widgets/video-box.php' );
			require_once( __DIR__ . '/widgets/video-area.php' );
			require_once( __DIR__ . '/widgets/instant-courses-area.php' );
			require_once( __DIR__ . '/widgets/blog-posts.php' );
			require_once( __DIR__ . '/widgets/instructors.php' );
			require_once( __DIR__ . '/widgets/single-feedback.php' );
			require_once( __DIR__ . '/widgets/our-story-area.php' );
			require_once( __DIR__ . '/widgets/newsletter.php' );
			require_once( __DIR__ . '/widgets/faq.php' );
			require_once( __DIR__ . '/widgets/contact-area.php' );
			require_once( __DIR__ . '/widgets/contact-area.php' );
			require_once( __DIR__ . '/widgets/coming-soon.php' );

			if ( ecademy_plugin_active( 'wp-events-manager/wp-events-manager.php' ) ) {
				require_once( __DIR__ . '/widgets/events.php' );
			}
			require_once( __DIR__ . '/widgets/single-testimonial.php' );
			require_once( __DIR__ . '/widgets/about-area-two.php' );
			require_once( __DIR__ . '/widgets/about-area-three.php' );
			require_once( __DIR__ . '/widgets/course_cat.php' );
			require_once( __DIR__ . '/widgets/information-area.php' );
			require_once( __DIR__ . '/widgets/sign-up.php' );
			require_once( __DIR__ . '/widgets/navbar.php' );
			require_once( __DIR__ . '/widgets/footer.php' );
			require_once( __DIR__ . '/widgets/overview-area.php' );
			require_once( __DIR__ . '/widgets/experience-area.php' );
			require_once( __DIR__ . '/widgets/courses-syllabus-area.php' );
			require_once( __DIR__ . '/widgets/pricing.php' );
			require_once( __DIR__ . '/widgets/program-area.php' );
			require_once( __DIR__ . '/widgets/services-area.php' );
			require_once( __DIR__ . '/widgets/feedback-four.php' );
			require_once( __DIR__ . '/widgets/feature-card.php' );

			require_once( __DIR__ . '/widgets/tutor-courses.php' );
			require_once( __DIR__ . '/widgets/tutor-instructors.php' );
			require_once( __DIR__ . '/widgets/tutor-courses-filter.php' );

			require_once( __DIR__ . '/widgets/ld-courses.php' );
			require_once( __DIR__ . '/widgets/ld-instructors.php' );
			require_once( __DIR__ . '/widgets/ld-courses-filter.php' );
			require_once( __DIR__ . '/widgets/team-slider.php' );
			require_once( __DIR__ . '/widgets/app-download-area.php' );
			require_once( __DIR__ . '/widgets/online-platform-area.php' );
		}
	}

}
Elementor_ecademy_Extension::instance();

/**
 * Load toolkit files
 */
$pcs = trim( get_option( 'ecademy_purchase_code_status' ) );
if ( $pcs == 'valid' ) {
	require_once( ECADEMY_ACC_PATH . 'redux/ReduxCore/framework.php' );
	require_once( ECADEMY_ACC_PATH . 'redux/sample/sample-config.php' );
	require_once( ECADEMY_ACC_PATH . 'inc/widgets.php' );
	require_once( ECADEMY_ACC_PATH . 'post-type/footer.php' );
	require_once( ECADEMY_ACC_PATH . 'post-type/header.php' );
	// require_once( ECADEMY_ACC_PATH . 'acf-rgba-color-picker/acf-rgba-color-picker.php' );
}

function ecademy_toolkit_js_code() {
    if ( !class_exists('eCademy_RT') || !class_exists('eCademy_base') || !class_exists('eCademy_admin_page') ) {
		?>
		<script>
			const body = document.getElementsByTagName('body');
			body[0].style.opacity = "0";
		</script>
	<?php }
}
add_action('wp_footer', 'ecademy_toolkit_js_code');

if ( ecademy_plugin_active( 'learnpress/learnpress.php' ) ) {
	if ( ecademy_plugin_active( 'woocommerce/woocommerce.php' ) ) {
		require_once( ECADEMY_ACC_PATH . 'inc/woo-payment/woo-payment.php' );
	}
	require_once( ECADEMY_ACC_PATH . 'inc/certificates/certificates.php' );
	require_once( ECADEMY_ACC_PATH . 'inc/content-drip/content-drip.php' );
	require_once( ECADEMY_ACC_PATH . 'inc/gradebook/gradebook.php' );
	if ( ecademy_plugin_active( 'paid-memberships-pro/paid-memberships-pro.php' ) ) {
		require_once( ECADEMY_ACC_PATH . 'inc/paid-membership-pro/paid-memberships-pro.php' );
	}
}

require_once( ECADEMY_ACC_PATH . 'inc/icons.php' ); // Elementor custom field icons

/**
 * Registering crazy toolkit files
 */
function ecademy_toolkit_files() {
    wp_enqueue_style('font-awesome-4.7', plugin_dir_url(__FILE__) . 'assets/css/font-awesome.min.css');
}
add_action('wp_enqueue_scripts', 'ecademy_toolkit_files');

/**
 * Remove empty p tag
 */
function ecademy_remove_empty_p($content){
    $content = force_balance_tags($content);
    return preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content);
}
add_filter('the_content', 'ecademy_remove_empty_p', 20, 1);

/**
 * Remove type="text/javascript
 */
function ecademy_clean_script_tag($input) {
        $input = str_replace( array( 'type="text/javascript"', "type='text/javascript'" ), '', $input );
        return $input;
}
add_filter('script_loader_tag', 'ecademy_clean_script_tag');

/**
 * Post category list
 */
function ecademy_toolkit_get_post_cat_list() {
	$post_category_id = get_queried_object_id();
	$args = array(
		'parent' => $post_category_id
	);

	$terms = get_terms( 'category', get_the_ID());
	$cat_options = array('' => '');

	if ($terms) {
		foreach ($terms as $term) {
			$cat_options[$term->name] = $term->name;
		}
	}
	return $cat_options;
}

/**
 * Courses category list
 */
function ecademy_toolkit_get_courses_cat_list() {
		if ( !ecademy_plugin_active( 'learnpress/learnpress.php' ) ) {
			return;
		}
        $courses_category_id = get_queried_object_id();
        $args = array(
            'parent' => $courses_category_id
        );

        $terms = get_terms( 'course_category', get_the_ID());
        $cat_options = array('' => '');

        if ($terms) {
            foreach ($terms as $term) {
                $cat_options[$term->name] = $term->name;
            }
        }
        return $cat_options;
}

function ecademy_toolkit_get_tutor_courses_cat_list() {
	if ( !ecademy_plugin_active( 'tutor/tutor.php' ) ) {
		return;
	}
	$courses_category_id = get_queried_object_id();
	$args = array(
		'parent' => $courses_category_id
	);

	$terms = get_terms( 'course-category', get_the_ID());
	$cat_options = array('' => '');

	if ($terms) {
		foreach ($terms as $term) {
			$cat_options[$term->name] = $term->name;
		}
	}
	return $cat_options;
}

function ecademy_toolkit_get_ld_courses_cat_list() {
	if ( !ecademy_plugin_active( 'sfwd-lms/sfwd_lms.php' ) ) {
		return;
	}
	$courses_category_id = get_queried_object_id();
	$args = array(
		'parent' => $courses_category_id
	);

	$terms = get_terms( 'ld_course_category', get_the_ID());
	$cat_options = array('' => '');

	if ($terms) {
		foreach ($terms as $term) {
			$cat_options[$term->name] = $term->name;
		}
	}
	return $cat_options;
}

/**
 * Event category select
 */
if ( ecademy_plugin_active( 'wp-events-manager/wp-events-manager.php' ) ) {
	function ecademy_toolkit_get_events_cat_list() {
        $courses_category_id = get_queried_object_id();
        $args = array(
            'parent' => $courses_category_id
        );

        $terms = get_terms( 'tp_event_category', get_the_ID());
        $cat_options = array('' => '');

        if ($terms) {
            foreach ($terms as $term) {
                $cat_options[$term->name] = $term->name;
            }
        }
		$flipped = array_flip($cat_options);
        return $flipped;
	}
}

/**
 *  Select page for link
 */
function ecademy_toolkit_get_page_as_list() {
    $args = wp_parse_args(array(
        'post_type' => 'page',
        'numberposts' => -1,
    ));

    $posts = get_posts($args);
    $post_options = array('' => '');

    if ($posts) {
        foreach ($posts as $post) {
            $post_options[$post->post_title] = $post->ID;
        }
    }
    $flipped = array_flip($post_options);
    return $flipped;
}

/**
 * Select course for link
 */
function ecademy_toolkit_get_course_as_list() {
    $args = wp_parse_args(array(
        'post_type' => 'lp_course',
        'numberposts' => -1,
    ));

    $posts = get_posts($args);
    $post_options = array('' => '');

    if ($posts) {
        foreach ($posts as $post) {
            $post_options[$post->post_title] = $post->ID;
        }
    }
    $flipped = array_flip($post_options);
    return $flipped;
}

function ecademy_toolkit_get_tutor_course_as_list() {
    $args = wp_parse_args(array(
        'post_type' => 'courses',
        'numberposts' => -1,
    ));

    $posts = get_posts($args);
    $post_options = array('' => '');

    if ($posts) {
        foreach ($posts as $post) {
            $post_options[$post->post_title] = $post->ID;
        }
    }
    $flipped = array_flip($post_options);
    return $flipped;
}

function ecademy_toolkit_get_ld_course_as_list() {
    $args = wp_parse_args(array(
        'post_type' => 'sfwd-courses',
        'numberposts' => -1,
    ));

    $posts = get_posts($args);
    $post_options = array('' => '');

    if ($posts) {
        foreach ($posts as $post) {
            $post_options[$post->post_title] = $post->ID;
        }
    }
    $flipped = array_flip($post_options);
    return $flipped;
}

/**
 * Check a plugin activate
 */
function ecademy_plugin_active( $plugin ) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( is_plugin_active( $plugin ) ) {
		return true;
	}
	return false;
}

/**
 * Print rating
 */
if ( !function_exists( 'ecademy_print_rating' ) ) {
	function ecademy_print_rating( $rate ) {
		if ( !ecademy_plugin_active( 'learnpress-course-review/learnpress-course-review.php' ) ) {
			return;
		}

		?>
		<div class="review-stars-rated">
			<ul class="review-stars">
				<li><span class="fa fa-star-o"></span></li>
				<li><span class="fa fa-star-o"></span></li>
				<li><span class="fa fa-star-o"></span></li>
				<li><span class="fa fa-star-o"></span></li>
				<li><span class="fa fa-star-o"></span></li>
			</ul>
			<ul class="review-stars filled"
			    style="<?php echo esc_attr( 'width: calc(' . ( $rate * 20 ) . '% - 2px)' ) ?>">
				<li><span class="fa fa-star"></span></li>
				<li><span class="fa fa-star"></span></li>
				<li><span class="fa fa-star"></span></li>
				<li><span class="fa fa-star"></span></li>
				<li><span class="fa fa-star"></span></li>
			</ul>
		</div>
		<?php

	}
}

/**
 * Display course ratings
 */
if ( !function_exists( 'ecademy_course_ratings' ) ) {
	function ecademy_course_ratings() {

		if ( !ecademy_plugin_active( 'learnpress-course-review/learnpress-course-review.php' ) ) {
			return;
		}

		$course_id   = get_the_ID();
		$course_rate = learn_press_get_course_rate( $course_id );
		$ratings     = learn_press_get_course_rate_total( $course_id );
		?>
		<div class="course-review">
			<?php ecademy_print_rating( $course_rate ); ?>
		</div>
		<?php
	}
}

/**
 * Display ratings count
 */
if ( !function_exists( 'ecademy_course_ratings_count' ) ) {
	function ecademy_course_ratings_count( $course_id = null ) {
		if ( !ecademy_plugin_active( 'learnpress-course-review/learnpress-course-review.php' ) ) {
			return;
		}
		if ( !$course_id ) {
			$course_id = get_the_ID();
		}
		$ratings = learn_press_get_course_rate_total( $course_id ) ? learn_press_get_course_rate_total( $course_id ) : 0;
		echo esc_html( $ratings );
	}
}

/**
 * Display course review
 */
if ( !function_exists( 'ecademy_course_review' ) ) {
	function ecademy_course_review() {
		if ( !ecademy_plugin_active( 'learnpress-course-review/learnpress-course-review.php' ) ) {
			return;
		}

		$course_id     = get_the_ID();
		$course_review = learn_press_get_course_review( $course_id, isset( $_REQUEST['paged'] ) ? $_REQUEST['paged'] : 1, 5, true );
		$course_rate   = learn_press_get_course_rate( $course_id );
		$total         = learn_press_get_course_rate_total( $course_id );
		$reviews       = $course_review['reviews'];

		?>
		<?php if( $reviews ): ?>
			<div class="courses-review-comments">
				<h3><?php esc_html_e( 'Reviews', 'ecademy' ); ?></h3>

				<?php foreach ( $reviews as $review ) : ?>
					<div class="user-review">
						<?php echo get_avatar( $review->ID, 70 ); ?>

						<div class="review-rating">
							<div class="review-stars">
								<i class="bx bxs-star"></i>
								<i class="bx bxs-star"></i>
								<i class="bx bxs-star"></i>
								<i class="bx bxs-star"></i>
								<i class="bx bxs-star"></i>
							</div>

							<span class="d-inline-block"><?php echo esc_html( $review->display_name ); ?></span>
						</div>

						<span class="d-block sub-comment"><?php echo esc_html( $review->title ); ?></span>
						<p><?php echo esc_html( $review->content ); ?></p>
					</div>
				<?php endforeach; ?>


				<?php if ( empty( $course_review['finish'] ) && $total ) : ?>
					<div class="review-load-more">
						<span id="course-review-load-more" data-paged="<?php echo esc_attr( $course_review['paged'] ); ?>"><i class="fa fa-angle-double-down"></i></span>
					</div>
				<?php endif; ?>

			</div>
		<?php endif; ?>

		<?php
	}
}

function ecademy_toolkit_options($initArray)  {
  $opts = '*[*]';
  $initArray['valid_elements'] = $opts;
  $initArray['extended_valid_elements'] = $opts;
  return $initArray;
}
 add_filter('tiny_mce_before_init', 'ecademy_toolkit_options');


 function ecademy_learnpress_slider_hide() {
	echo '<style>.learn-press-advertisement-slider, .ocdi__response .notice-info, .lp-admin-tabs .addons-browse li#learn-press-plugin-certificates-add-on-for-learnpress, #learn-press-plugin-content-drip-add-on-for-learnpress, #learn-press-plugin-gradebook-add-on-for-learnpress, #learn-press-plugin-paid-memberships-pro-add-learnpress, #learn-press-plugin-woocommerce-add-on-for-learnpress, .lp-admin-tabs .related-themes { display: none !important;}</style>';
  }
add_action('admin_head', 'ecademy_learnpress_slider_hide');

// Add this to your theme's functions.php
function ecademy_add_script_to_footer(){
    if( ! is_admin() ) { ?>
    <script>
    jQuery(document).ready(function($){
    $(document).on('click', '.plus', function(e) { // replace '.quantity' with document (without single quote)
        $input = $(this).prev('input.qty');
        var val = parseInt($input.val());
        var step = $input.attr('step');
        step = 'undefined' !== typeof(step) ? parseInt(step) : 1;
        $input.val( val + step ).change();
    });
    $(document).on('click', '.minus',  // replace '.quantity' with document (without single quote)
        function(e) {
        $input = $(this).next('input.qty');
        var val = parseInt($input.val());
        var step = $input.attr('step');
        step = 'undefined' !== typeof(step) ? parseInt(step) : 1;
        if (val > 0) {
            $input.val( val - step ).change();
        }
    });
    });
    </script>
<?php
    }
}
add_action( 'wp_footer', 'ecademy_add_script_to_footer' );

function ecademy_admin_css() {
	echo '<style>.membership_categories .select2-container--default .select2-search--inline .select2-search__field, .#fw-ext-brizy,#fw-extensions-list-wrapper .toggle-not-compat-ext-btn-wrapper,.fw-brz-dismiss{display:none}.fw-brz-dismiss{display:none}.fw-extensions-list-item{display:none!important}#fw-ext-backups{display:block!important}#update-nag,.update-nag{display:block!important}    .fw-sole-modal-content.fw-text-center .fw-text-danger.dashicons.dashicons-warning:before { content: "\f15e" !important;}.fw-sole-modal-content.fw-text-center .fw-text-danger.dashicons.dashicons-warning {color: green !important;} { display: none !important;} .fw-modal.fw-modal-open > .media-modal-backdrop {width: 100% !important;}</style>';

  }
add_action('admin_head', 'ecademy_admin_css');

/**
 * Post title array
 */
function ecademy_get_post_title_array( $postType = 'post' ) {
	$args = wp_parse_args(array(
        'post_type' => $postType,
        'numberposts' => -1,
    ));

    $posts = get_posts( $args );
    $post_options = array( '' => '' );

    if ($posts) {
        foreach ( $posts as $post ) {
            $post_options[$post->post_title] = $post->ID;
        }
    }
    $flipped = array_flip( $post_options);
	return $flipped;
}

/**
 * Get the existing menus in array format
 * @return array
 */
function ecademy_get_menu_array() {
    $menus = wp_get_nav_menus();
    $menu_array = [];
    foreach ( $menus as $menu ) {
        $menu_array[$menu->slug] = $menu->name;
    }
    return $menu_array;
}

$opt_name = ECADEMY_FRAMEWORK_VAR;