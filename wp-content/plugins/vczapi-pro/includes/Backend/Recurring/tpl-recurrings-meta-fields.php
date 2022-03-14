<?php if ( empty( $vczapi_field_details ) || ( ! empty( $vczapi_field_details ) && $vczapi_field_details['meeting_type'] != 2 ) ) { ?>
    <tr class="vczapi-admin-hide-on-webinar show-hide-pmi-radio" <?php echo ! empty( $details['enabled_recurring'] ) && ! empty( $details['frequency'] ) && ( $details['frequency'] == "1" || $details['frequency'] == "2" || $details['frequency'] == "3" ) ? 'style=display:none;' : false; ?>>
        <th scope="row"><label for="vczapi-use-pmi"><?php _e( 'Meeting ID', 'vczapi-pro' ); ?></label>
        </th>
        <td>
			<?php
			if ( empty( $details['use_pmi'] ) ) {
				$details['use_pmi'] = '1';
			}
			?>
            <select name="vczapi-use-pmi" id="vczapi-use-pmi">
                <option value="1" <?php ! empty( $details['use_pmi'] ) ? selected( '1', $details['use_pmi'] ) : false; ?>><?php _e( 'Auto Generated', 'vczapi-pro' ); ?></option>
                <option value="2" <?php ! empty( $details['use_pmi'] ) ? selected( '2', $details['use_pmi'] ) : false; ?>><?php _e( 'Use PMI', 'vczapi-pro' ); ?></option>
            </select>
            <p class="description"><?php _e( 'Use Personal Meeting ID instead of an automatically generated meeting ID. It can only be used for scheduled meetings, instant meetings and recurring meetings with no fixed time.', 'vczapi-pro' ); ?></p>
        </td>
    </tr>
<?php } ?>
<tr>
    <th scope="row"><label for="vczapi-enable-recurring-meeting"><?php _e( 'Recurring Meeting?', 'vczapi-pro' ); ?></label>
    </th>
    <td>
        <input name="vczapi-enable-recurring-meeting" type="checkbox" <?php ! empty( $details['enabled_recurring'] ) ? checked( 'on', $details['enabled_recurring'] ) : false; ?> id="vczapi-enable-recurring-meeting" class="regular-text">
        <p class="description"><?php _e( 'Convert this scheduled meeting to recurring meeting ?', 'vczapi-pro' ); ?></p>
    </td>
</tr>
<tr class="vczapi-recurring-show-hide" <?php echo ! empty( $details['enabled_recurring'] ) ? 'style=display:table-row;' : 'style=display:none;'; ?>>
    <th scope="row"><label for="vczapi-recurrence-frequency"><?php _e( 'Recurrence', 'vczapi-pro' ); ?></label></th>
    <td>
        <select name="vczapi-recurrence-frequency" id="vczapi-recurrence-frequency">
            <option value="1" <?php ! empty( $details['frequency'] ) ? selected( '1', $details['frequency'] ) : false; ?>><?php _e( 'Daily', 'vczapi-pro' ); ?></option>
            <option value="2" <?php ! empty( $details['frequency'] ) ? selected( '2', $details['frequency'] ) : false; ?>><?php _e( 'Weekly', 'vczapi-pro' ); ?></option>
            <option value="3" <?php ! empty( $details['frequency'] ) ? selected( '3', $details['frequency'] ) : false; ?>><?php _e( 'Monthly', 'vczapi-pro' ); ?></option>
            <option value="4" <?php ! empty( $details['frequency'] ) ? selected( '4', $details['frequency'] ) : false; ?>><?php _e( 'No Fixed Time', 'vczapi-pro' ); ?></option>
        </select>
    </td>
</tr>
<tr class="vczapi-recurring-show-hide vczapi-recurring-show-hide-no-fixed-time" <?php echo ! empty( $details['enabled_recurring'] ) && ! empty( $details['frequency'] ) && $details['frequency'] != "4" ? 'style=display:table-row;' : 'style=display:none;'; ?>>
    <th scope="row"><label for="vczapi-repeat-interval"><?php _e( 'Repeat Every', 'vczapi-pro' ); ?></label></th>
    <td>
        <select name="vczapi-repeat-interval" id="vczapi-repeat-interval">
			<?php for ( $i = 1; $i <= 3; $i ++ ) { ?>
                <option <?php ! empty( $details['interval'] ) ? selected( $i, $details['interval'] ) : false; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php } ?>
        </select> <span class="vczapi-repeat-type-text">
                        <?php
                        if ( ! empty( $details['frequency'] ) ) {
	                        if ( $details['frequency'] == "1" ) {
		                        echo __( "Day", "vczapi-pro" );
	                        } else if ( $details['frequency'] == "2" ) {
		                        echo __( "Week", "vczapi-pro" );
	                        } else {
		                        echo __( "Month", "vczapi-pro" );
	                        }
                        } else {
	                        echo __( "Day", "vczapi-pro" );
                        }
                        ?>
                    </span>
        <p class="description"><?php _e( 'Define the interval at which the meeting should occur.', 'vczapi-pro' ); ?></p>
    </td>
</tr>
<tr class="vczapi-weekly-occurrence-show-hide" <?php echo ! empty( $details['enabled_recurring'] ) && ! empty( $details['frequency'] ) && $details['frequency'] != "4" && $details['frequency'] == "2" ? 'style=display:table-row;' : 'style=display:none;'; ?>>
    <th scope="row"><label for="vczapi-weekly-occurrence"><?php _e( 'Occurs on', 'vczapi-pro' ); ?></label></th>
    <td>
        <input name="vczapi-weekly-occurrence[]" value="1" type="checkbox" <?php echo ! empty( $details['weekly_occurence'] ) && in_array( '1', $details['weekly_occurence'] ) ? 'checked' : false; ?> id="vczapi-weekly-occurrence-one" class="regular-text"> Sun
        <input name="vczapi-weekly-occurrence[]" value="2" type="checkbox" <?php echo ! empty( $details['weekly_occurence'] ) && in_array( '2', $details['weekly_occurence'] ) ? 'checked' : false; ?> id="vczapi-weekly-occurrence-two" class="regular-text"> Mon
        <input name="vczapi-weekly-occurrence[]" value="3" type="checkbox" <?php echo ! empty( $details['weekly_occurence'] ) && in_array( '3', $details['weekly_occurence'] ) ? 'checked' : false; ?> id="vczapi-weekly-occurrence-three" class="regular-text"> Tues
        <input name="vczapi-weekly-occurrence[]" value="4" type="checkbox" <?php echo ! empty( $details['weekly_occurence'] ) && in_array( '4', $details['weekly_occurence'] ) ? 'checked' : false; ?> id="vczapi-weekly-occurrence-four" class="regular-text"> Wed
        <input name="vczapi-weekly-occurrence[]" value=5 type="checkbox" <?php echo ! empty( $details['weekly_occurence'] ) && in_array( '5', $details['weekly_occurence'] ) ? 'checked' : false; ?> id="vczapi-weekly-occurrence-five" class="regular-text"> Thurs
        <input name="vczapi-weekly-occurrence[]" value="6" type="checkbox" <?php echo ! empty( $details['weekly_occurence'] ) && in_array( '6', $details['weekly_occurence'] ) ? 'checked' : false; ?> id="vczapi-weekly-occurrence-six" class="regular-text"> Fri
        <input name="vczapi-weekly-occurrence[]" value="7" type="checkbox" <?php echo ! empty( $details['weekly_occurence'] ) && in_array( '7', $details['weekly_occurence'] ) ? 'checked' : false; ?> id="vczapi-weekly-occurrence-seven" class="regular-text"> Sat
    </td>
</tr>
<tr class="vczapi-monthly-occurrence-show-hide" <?php echo ! empty( $details['enabled_recurring'] ) && ! empty( $details['frequency'] ) && $details['frequency'] != "4" && $details['frequency'] == "3" ? 'style=display:table-row;' : 'style=display:none;'; ?>>
    <th scope="row"><label for="vczapi-monthly-occurrence"><?php _e( 'Occurs on', 'vczapi-pro' ); ?></label></th>
    <td>
        <div class="vczapi-monthly-occurrence-list">
            <input name="vczapi-monthly-occurrence-type" value="1" <?php ! empty( $details['monthly_occurence_type'] ) ? checked( '1', $details['monthly_occurence_type'] ) : false; ?> type="radio" id="vczapi-monthly-occurrence-type-monthly" class="regular-text">
			<?php _e( 'Day', 'vczapi-pro' ); ?> <select name="vczapi-monthly-occurrence" id="vczapi-monthly-occurrence">
				<?php for ( $i = 1; $i <= 31; $i ++ ) { ?>
                    <option <?php ! empty( $details['monthly_occurence_day'] ) ? selected( $i, $details['monthly_occurence_day'] ) : false; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php } ?>
            </select> <?php _e( 'of the month', 'vczapi-pro' ); ?>
        </div>
        <div class="vczapi-monthly-occurrence-list" style="margin-top:15px;">
            <input name="vczapi-monthly-occurrence-type" value="2" type="radio" <?php ! empty( $details['monthly_occurence_type'] ) ? checked( '2', $details['monthly_occurence_type'] ) : false; ?> id="vczapi-monthly-occurrence-type-weekly" class="regular-text">
			<?php _e( 'By', 'vczapi-pro' ); ?>
            <select name="vczapi-monthly-occurence-week" id="vczapi-monthly-occurence-week">
                <option value="1" <?php ! empty( $details['monthly_occurence_week'] ) ? selected( '1', $details['monthly_occurence_week'] ) : false; ?>>
					<?php _e( 'First', 'vczapi-pro' ); ?>
                </option>
                <option value="2" <?php ! empty( $details['monthly_occurence_week'] ) ? selected( '2', $details['monthly_occurence_week'] ) : false; ?>>
					<?php _e( 'Second', 'vczapi-pro' ); ?>
                </option>
                <option value="3" <?php ! empty( $details['monthly_occurence_week'] ) ? selected( '3', $details['monthly_occurence_week'] ) : false; ?>>
					<?php _e( 'Third', 'vczapi-pro' ); ?>
                </option>
                <option value="4" <?php ! empty( $details['monthly_occurence_week'] ) ? selected( '4', $details['monthly_occurence_week'] ) : false; ?>>
					<?php _e( 'Fourth', 'vczapi-pro' ); ?>
                </option>
                <option value="-1" <?php ! empty( $details['monthly_occurence_week'] ) ? selected( '-1', $details['monthly_occurence_week'] ) : false; ?>>
					<?php _e( 'Last', 'vczapi-pro' ); ?>
                </option>
            </select> <select name="vczapi-monthly-occurrence-day" id="vczapi-monthly-occurrence-day">
                <option value="1" <?php ! empty( $details['monthly_occurence_week_day'] ) ? selected( '1', $details['monthly_occurence_week_day'] ) : false; ?>>
					<?php _e( 'Sunday', 'vczapi-pro' ); ?>
                </option>
                <option value="2" <?php ! empty( $details['monthly_occurence_week_day'] ) ? selected( '2', $details['monthly_occurence_week_day'] ) : false; ?>>
					<?php _e( 'Monday', 'vczapi-pro' ); ?>
                </option>
                <option value="3" <?php ! empty( $details['monthly_occurence_week_day'] ) ? selected( '3', $details['monthly_occurence_week_day'] ) : false; ?>>
					<?php _e( 'Tuesday', 'vczapi-pro' ); ?>
                </option>
                <option value="4" <?php ! empty( $details['monthly_occurence_week_day'] ) ? selected( '4', $details['monthly_occurence_week_day'] ) : false; ?>>
					<?php _e( 'Wednesday', 'vczapi-pro' ); ?>
                </option>
                <option value="5" <?php ! empty( $details['monthly_occurence_week_day'] ) ? selected( '5', $details['monthly_occurence_week_day'] ) : false; ?>>
					<?php _e( 'Thursday', 'vczapi-pro' ); ?>
                </option>
                <option value="6" <?php ! empty( $details['monthly_occurence_week_day'] ) ? selected( '6', $details['monthly_occurence_week_day'] ) : false; ?>>
					<?php _e( 'Friday', 'vczapi-pro' ); ?>
                </option>
                <option value="7" <?php ! empty( $details['monthly_occurence_week_day'] ) ? selected( '7', $details['monthly_occurence_week_day'] ) : false; ?>>
					<?php _e( 'Saturday', 'vczapi-pro' ); ?>
                </option>
            </select> <?php _e( 'of the month', 'vczapi-pro' ); ?>
        </div>
    </td>
</tr>
<tr class="vczapi-recurring-show-hide vczapi-recurring-show-hide-no-fixed-time" <?php echo ! empty( $details['enabled_recurring'] ) && ! empty( $details['frequency'] ) && $details['frequency'] != "4" ? 'style=display:table-row;' : 'style=display:none;'; ?>>
    <th scope="row"><label><?php _e( 'End Date', 'vczapi-pro' ); ?></label></th>
    <td>
        <label>
            <input type="radio"
                   id="vczapi-recurring-end-type-end-date-time"
                   name="vczapi-recurring-end-type"
                   value="by_date"
				<?php ! empty( $details['end_type'] ) ? checked( 'by_date', $details['end_type'] ) : false; ?>
                   class="regular-text"
            >By
            <input
                    type="text"
                    id="vczapi-end-date-time"
                    name="vczapi-end-date-time"
                    value="<?php echo ! empty( $details[ 'end_datetime' ] ) ? $details[ 'end_datetime' ] : date('Y-m-d') ?>"
            >
            
        </label>

        <label>
            <input name="vczapi-recurring-end-type" type="radio" id="vczapi-recurring-end-type-after" value="by_occurrence" <?php ! empty( $details['end_type'] ) ? checked( 'by_occurrence', $details['end_type'] ) : false; ?> class="regular-text">
			<?php _e( 'After', 'vczapi-pro' ); ?>

        </label>


        <select name="vczapi-end-times-occurence" id="vczapi-end-times-occurence">
			<?php for ( $i = 1; $i <= 20; $i ++ ) { ?>
                <option <?php ! empty( $details['end_occurence'] ) ? selected( $i, $details['end_occurence'] ) : false; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php } ?>
        </select> <?php _e( 'Occurrences', 'vczapi-pro' ); ?>
        <p class="description"><?php _e( 'How many times this meeting should occur before it is cancelled !', 'vczapi-pro' ); ?></p>
        <p class="description warning" style="color: red"><?php _e('When selecting end date please keep in mind only 50 occurrences are supported by Zoom, selecting time range that creates more than 50 occurrences will lead to error','vczapi-pro'); ?></p>
    </td>
</tr>
<tr class="vczapi-recurring-show-hide-no-fixed-time vczapi-show-registration-section" <?php echo ! empty( $details['frequency'] ) && $details['frequency'] == "4" ? 'style=display:none;' : 'style=display:table-row;'; ?>>
    <th scope="row"><label for="vczapi-enable-registration"><?php _e( 'Registration', 'vczapi-pro' ); ?></label></th>
    <td>
        <input name="vczapi-enable-registration" type="checkbox" <?php ! empty( $details['registration'] ) ? checked( 'on', $details['registration'] ) : false; ?> id="vczapi-enable-registration" class="regular-text">
        <span class="description" style="color:red;"><?php _e( 'Note: This feature requires the host to be of Zoom Licensed user type. Registration cannot be enabled for a basic user. This will require a user to login before joining the meeting via site. Join via browser will not work when this is enabled.', 'vczapi-pro' ); ?></span>
    </td>
</tr>
<?php
if ( empty( $details['registration_type'] ) ) {
	$details['registration_type'] = '1';
}
?>
<tr class="vczapi-registration-type-on-off vczapi-recurring-show-hide-no-fixed-time" <?php echo ! empty( $details['enabled_recurring'] ) && ! empty( $details['frequency'] ) && $details['frequency'] != "4" && ! empty( $details['registration'] ) ? 'style=display:table-row;' : 'style=display:none;'; ?>>
    <th scope="row"><label for="vczapi-registration-type"><?php _e( 'Registration Type', 'vczapi-pro' ); ?></label>
    </th>
    <td>
        <input name="vczapi-registration-type" type="radio" id="vczapi-registration-type-1" value="1" <?php ! empty( $details['registration_type'] ) ? checked( '1', $details['registration_type'] ) : false; ?> class="regular-text"> <?php _e( 'Attendees register once and can attend any of the occurrences.', 'vczapi-pro' ); ?>
        <p class="description" style="color:red;"><?php _e( 'Registration type. Used for recurring meeting with fixed time only.', 'vczapi-pro' ); ?></p>
    </td>
</tr>
<tr>
    <th scope="row"><label for="vczapi-registration-type"><?php _e( 'Register without Login?', 'vczapi-pro' ); ?></label></th>
    <td>
        <input type="checkbox" name="vcapi-registration-condition" id="vcapi-registration-condition" <?php ! empty( $details['registration_condition'] ) ? checked( 'on', $details['registration_condition'] ) : false; ?>> <?php _e( 'Only valid if registration is enabled', 'vczapi-pro' ); ?>
        <p class="description"><?php _e( 'If this option is checked, User will not be required to be loggedin to this website. Note: User will only receive join link via email and register button will stay regardless after the registration process.', 'vczapi-pro' ); ?></p>
    </td>
</tr>
<tr>
    <th scope="row"><label for="vczapi-registration-email"><?php _e( 'Register Email Notification?', 'vczapi-pro' ); ?></label></th>
    <td>
        <input type="checkbox" name="vczapi-registration-email" id="vczapi-registration-email" <?php ! empty( $details['registration_email'] ) ? checked( 'on', $details['registration_email'] ) : false; ?>> (<?php _e( 'Only valid if registration is enabled', 'vczapi-pro' ); ?>)
        <p class="description"><?php _e( 'Default is TRUE. Send email notifications to registrants about approval, cancellation, confirmation denial of the registration. If checked, users will not receive any registration confirmation email notification from Zoom side.', 'vczapi-pro' ); ?></p>
    </td>
</tr>