<div class="message">
	<?php
	$message = Codemanas\ZoomPro\Helpers::get_admin_notice();
	if ( ! empty( $message ) ) {
		echo $message;
	}
	?>
</div>
<form method="POST" action="">
    <table class="form-table">
        <tbody>
        <tr valign="top">
            <th scope="row" valign="top">
				<?php _e( 'Registration Email ?', 'vczapi-pro' ); ?>
            </th>
            <td>
                <input id="registration_email" name="registration_email" type="checkbox" class="regular-text" <?php ! empty( $this->settings ) && ! empty( $this->settings['registraion_email'] ) ? checked( $this->settings['registraion_email'], 'on' ) : false; ?> />
                <span class="description" for="registration_email"><?php _e( 'Checking this option will enable email after a user is registered into a meeting.', 'vczapi-pro' ); ?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" valign="top">
				<?php _e( 'Hide Add to Calender links ?', 'vczapi-pro' ); ?>
            </th>
            <td>
                <input id="vczapi-pro-hide-gcal-links" name="hide_ical_links" type="checkbox" class="regular-text" <?php ! empty( $this->settings ) && ! empty( $this->settings['hide_ical_links'] ) ? checked( $this->settings['hide_ical_links'], 'on' ) : false; ?> />
                <span class="description" for="hide_ical_links"><?php _e( 'Checking this option will hide add to calendar and add to Google calendar links from single pages and archive pages.', 'vczapi-pro' ); ?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" valign="top">
				<?php _e( 'Hide add to Calender links for not purchased meetings ?', 'vczapi-pro' ); ?>
            </th>
            <td>
                <input id="vczapi-pro-hide-gcal-links-for-not-purchased" name="hide_ical_links_woocommerce" type="checkbox" class="regular-text" <?php ! empty( $this->settings ) && ! empty( $this->settings['hide_ical_links_woocommerce'] ) ? checked( $this->settings['hide_ical_links_woocommerce'], 'on' ) : false; ?> />
                <span class="description" for="hide_ical_links_woocommerce"><?php _e( 'Checking this option will hide add to calendar and add to Google calendar links for products which are not yet purchased.', 'vczapi-pro' ); ?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" valign="top">
				<?php _e( 'Disable Reminder Emails', 'vczapi-pro' ); ?>
            </th>
            <td>
                <input id="vczapi-pro-reminder-emails" name="reminder_emails[]" type="checkbox" value="24" <?php echo ! empty( $this->settings ) && ! empty( $this->settings['reminder_emails_registrants'] ) && in_array( '24', $this->settings['reminder_emails_registrants'] ) ? 'checked="checked"' : ''; ?> > <?php _e( '24 hours before meeting', 'vczapi-pro' ); ?><br>
                <p class="description"><?php _e( 'Check this option to disable email notification for 24 hours before the meeting.', 'vczapi-pro' ); ?></p>
                <p><a href="<?php echo admin_url( 'edit.php?post_type=zoom-meetings&page=zoom-video-conferencing-settings&tab=pro-licensing&section=email-templates' ); ?>">Goto this page</a> <?php _e( 'and search for Email Reminders section to know more about the variables you can add to your email template.', 'vczapi-pro' ); ?></p>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" valign="top">
				<?php _e( 'Inline Registration Form', 'vczapi-pro' ); ?>
            </th>
            <td>
                <input id="vczapi-pro-inline-registration-form" name="inline_registration_form" type="checkbox" class="regular-text" <?php ! empty( $this->settings ) && ! empty( $this->settings['inline_registration_form'] ) ? checked( $this->settings['inline_registration_form'], 'on' ) : false; ?> />
                <span class="description"><?php _e( 'Checking this option will enable registration form on the meeting page instead of seperate page.', 'vczapi-pro' ); ?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" valign="top">
				<?php _e( 'Create user on Registration ?', 'vczapi-pro' ); ?>
            </th>
            <td>
                <input id="create_user_on_registration" name="create_user_on_registration" type="checkbox" class="regular-text" <?php ! empty( $this->settings ) && ! empty( $this->settings['create_user_on_registration'] ) ? checked( $this->settings['create_user_on_registration'], 'on' ) : false; ?> />
                <span class="description"><?php _e( 'Checking this option will create a new user if not exists when registration form is submitted. Default role for the user will be', 'vczapi-pro' ); ?> <i><strong><?php _e( 'SUBSCRIBER', 'vczapi-pro' ); ?>.</strong></i> <?php printf( __( 'Goto "emails" tab for changing email details and follow this %s to change role of user.', 'vczapi-pro' ), '<a href="https://gist.github.com/techies23/f5e208f9c04dbc7f29ae6571d7642643" target="_blank">Link</a>' ); ?>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row" valign="top">
				<?php _e( 'Meeting/Webinar Registration Fields', 'vczapi-pro' ); ?>
            </th>
            <td>
                <select class="meeting-webinar-registraion-fields-selector" name="meeting_registration_fields[]" multiple="multiple" style="width:75%;">
                    <option value="address" <?php echo ! empty( $this->settings['meeting_registration_fields'] ) && in_array( 'address', $this->settings['meeting_registration_fields'] ) ? 'selected' : false; ?>><?php _e( 'Address', 'vczapi-pro' ); ?></option>
                    <option value="city" <?php echo ! empty( $this->settings['meeting_registration_fields'] ) && in_array( 'city', $this->settings['meeting_registration_fields'] ) ? 'selected' : false; ?>><?php _e( 'City', 'vczapi-pro' ); ?></option>
                    <option value="country" <?php echo ! empty( $this->settings['meeting_registration_fields'] ) && in_array( 'country', $this->settings['meeting_registration_fields'] ) ? 'selected' : false; ?>><?php _e( 'Country', 'vczapi-pro' ); ?></option>
                    <option value="zip" <?php echo ! empty( $this->settings['meeting_registration_fields'] ) && in_array( 'zip', $this->settings['meeting_registration_fields'] ) ? 'selected' : false; ?>><?php _e( 'Zip/Postal Code', 'vczapi-pro' ); ?></option>
                    <option value="state" <?php echo ! empty( $this->settings['meeting_registration_fields'] ) && in_array( 'state', $this->settings['meeting_registration_fields'] ) ? 'selected' : false; ?>><?php _e( 'State', 'vczapi-pro' ); ?></option>
                    <option value="phone" <?php echo ! empty( $this->settings['meeting_registration_fields'] ) && in_array( 'phone', $this->settings['meeting_registration_fields'] ) ? 'selected' : false; ?>><?php _e( 'Phone', 'vczapi-pro' ); ?></option>
                    <option value="industry" <?php echo ! empty( $this->settings['meeting_registration_fields'] ) && in_array( 'industry', $this->settings['meeting_registration_fields'] ) ? 'selected' : false; ?>><?php _e( 'Industry', 'vczapi-pro' ); ?></option>
                    <option value="org" <?php echo ! empty( $this->settings['meeting_registration_fields'] ) && in_array( 'org', $this->settings['meeting_registration_fields'] ) ? 'selected' : false; ?>><?php _e( 'Organization', 'vczapi-pro' ); ?></option>
                    <option value="job" <?php echo ! empty( $this->settings['meeting_registration_fields'] ) && in_array( 'job', $this->settings['meeting_registration_fields'] ) ? 'selected' : false; ?>><?php _e( 'Job Title', 'vczapi-pro' ); ?></option>
                    <option value="purchasing_time" <?php echo ! empty( $this->settings['meeting_registration_fields'] ) && in_array( 'purchasing_time', $this->settings['meeting_registration_fields'] ) ? 'selected' : false; ?>><?php _e( 'Purchasing Time Frame', 'vczapi-pro' ); ?></option>
                    <option value="role_in_purchase" <?php echo ! empty( $this->settings['meeting_registration_fields'] ) && in_array( 'role_in_purchase', $this->settings['meeting_registration_fields'] ) ? 'selected' : false; ?>><?php _e( 'Role in Purchase process', 'vczapi-pro' ); ?></option>
                    <option value="no_of_employees" <?php echo ! empty( $this->settings['meeting_registration_fields'] ) && in_array( 'no_of_employees', $this->settings['meeting_registration_fields'] ) ? 'selected' : false; ?>><?php _e( 'Number of Employees', 'vczapi-pro' ); ?></option>
                    <option value="comments" <?php echo ! empty( $this->settings['meeting_registration_fields'] ) && in_array( 'comments', $this->settings['meeting_registration_fields'] ) ? 'selected' : false; ?>><?php _e( 'Comments', 'vczapi-pro' ); ?></option>
                </select>
            </td>
        </tr>
        </tbody>
    </table>
    <p><input type="submit" class="button button-primary" name="save_registration_details" value="Save"></p>
</form>

