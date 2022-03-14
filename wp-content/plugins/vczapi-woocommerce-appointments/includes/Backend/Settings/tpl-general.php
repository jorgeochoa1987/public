<?php
$disable_browser_join = \Codemanas\ZoomWooCommerceAppointments\Core\Fields::get_option('disable_browser_join');
?>
<form method="post" action="">
	<?php
	wp_nonce_field( 'save_vczapi_woocommerce_appointments', 'vczapi__woocommerce_appointments_nonce' );
	?>
    <table class="form-table">
        <tr>
            <th>
                <label for="vczapi-disable-browser-join">
					<?php _e( 'Disable Join via Browser', 'vczapi-woocommerce-appointments' ); ?>
                </label>
            </th>
            <td>
                <input type="checkbox" name="vczapi_disable_browser_join" id="vczapi-disable-browser-join" value="yes"
                <?php checked($disable_browser_join,'yes',true); ?>
                >
            </td>
        </tr>
    </table>
    <p>
        <input type="submit" class="button button-primary" name="save" value="Save">
    </p>
</form>