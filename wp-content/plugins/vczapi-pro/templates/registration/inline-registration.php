<?php
/**
 * The Template for displaying all single meetings
 *
 * This template can be overridden by copying it to yourtheme/video-conferencing-zoom-pro/registration/inline-registration.php.
 *
 * @package     Video Conferencing with Zoom API/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $zoom;

if ( empty( $zoom ) && empty( $zoom->registration_url ) ) {
	return;
}

$meeting_id   = $zoom['api']->id;
$webinar_type = ! empty( $zoom['api']->type ) ? \Codemanas\ZoomPro\Helpers::is_webinar( $zoom['api']->type ) : false;

/**
 * vczoom_before_main_content hook.
 *
 * @hooked video_conference_zoom_output_content_wrapper
 */
do_action( 'vczapi_pro_before_registration_inline_form' );
?>
    <div id="vczapi-pro-inline-registration-header" class="vczapi-pro-inline-registration-header">
        <h3><?php _e( 'Registration Details', 'vczapi-pro' ); ?></h3>
    </div>
    <div id="vczapi-pro-inline-registration-container" class="vczapi-pro-inline-registration-container">
		<?php if ( ! empty( $zoom['registration_details'] ) && ! empty( $zoom['registration_details'][ $meeting_id ]->registrant_id ) ) { ?>
            <p><?php _e( 'You are already registered in this meeting. You can join this meeting from', 'vczapi-pro' ) ?>:
            <strong><a rel="noreferrer nofollow" href="<?php echo $zoom['registration_details'][ $meeting_id ]->join_url; ?>"><?php _e( 'Here', 'vczapi-pro' ) ?></a></strong>
		<?php } else { ?>
            <div class="vczapi-pro-registration-container--registration-wrap">
                <div class="vczapi-pro-registration-notice"></div>
                <form action="" method="POST" class="vczapi-pro-registration-form" id="vczapi-pro-registration-form">
					<?php wp_nonce_field( '_registration_zoom_meeting', '_nonce_registration_meeting' ) ?>
                    <input type="hidden" value="<?php echo $meeting_id; ?>" name="meeting_id">
                    <input type="hidden" value="<?php echo ! empty( $zoom['api']->post_id ) ? esc_html( $zoom['api']->post_id ) : ''; ?>" name="post_id">
                    <input type="hidden" value="<?php echo ! empty( $webinar_type ) ? 2 : 1; ?>" name="type">
                    <div class="registration-form__control">
                        <label for="first name">*<?php _e( 'First Name', 'vczapi-pro' ) ?>:</label>
                        <input type="text" name="first_name" id="first_name" autofocus placeholder="John" value="<?php echo ! empty( $zoom['current_user'] ) ? $zoom['current_user']->first_name : ''; ?>">
                    </div>
                    <div class="registration-form__control">
                        <label for="last name">*<?php _e( 'Last name', 'vczapi-pro' ) ?>:</label>
                        <input type="text" name="last_name" id="last_name" placeholder="Doe" value="<?php echo ! empty( $zoom['current_user'] ) ? $zoom['current_user']->last_name : ''; ?>">
                    </div>
                    <div class="registration-form__control">
                        <label for="email">*<?php _e( 'E-mail', 'vczapi-pro' ) ?>:</label>
                        <input type="email" name="email_address" id="email_address" placeholder="john.doe@gmail.com" value="<?php echo ! empty( $zoom['current_user'] ) ? $zoom['current_user']->user_email : ''; ?>">
                    </div>
                    <div class="registration-form__control">
                        <input type="submit" value="<?php _e( 'Register', 'vczapi-pro' ) ?>" name="registration_submit" class="btn btn-vczapi-pro-registration">
                    </div>
                </form>
            </div>
		<?php } ?>
    </div>
<?php
/**
 * vczoom_after_main_content hook.
 *
 * @hooked video_conference_zoom_output_content_end
 */
do_action( 'vczapi_pro_after_registration_inline_form' );

