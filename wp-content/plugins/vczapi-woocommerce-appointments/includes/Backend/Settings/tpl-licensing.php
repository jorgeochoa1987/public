<p>Enter your addon keys below to activate the product.</p><p><i>Enter your license keys here to receive updates and support for purchased addon.</i>
</p>
<form method="POST" action="">
	<?php wp_nonce_field( 'vczapi_verify_woocommerce_appointments_nonce', '_vczapi_woocommerce_appointments_licensing_nonce' ); ?>
    <table class="form-table">
        <tbody>
        <tr valign="top">
            <th scope="row" valign="top">
				<?php _e( 'License Key', 'vczapi-woocommerce-appointments' ); ?>
            </th>
            <td>
                <div class="vczapi-addon-activator-inputs" style="display: inline-block;vertical-align: top;">
					<?php if ( $this->status !== 'valid' ) { ?>
                        <input id="vczapi_woocommerce_appointments_license_key" name="vczapi_woocommerce_appointments_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $this->license ); ?>" placeholder="<?php _e( 'Your license key here', 'vczapi-woocommerce-appointments' ); ?>"/>
					<?php } ?>
                </div>
                <div class="vczapi-addon-activator-buttons" style="display: inline-block;vertical-align: top;">
					<?php if ( ! empty( $this->status ) && $this->status === 'valid' ) { ?>
                        <input type="submit" class="button button-primary" name="vczapi_woocommerce_appointments_deactivate" value="Deactivate License"/>
					<?php } else { ?>
                        <input type="submit" class="button button-primary" name="vczapi_woocommerce_appointments_activate" value="Activate License"/>
					<?php } ?>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</form>
