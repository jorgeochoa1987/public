<?php


namespace Codemanas\ZoomWooCommerceAppointments\Backend\Appointments;


use Codemanas\ZoomWooCommerceAppointments\Core\Fields;
use Codemanas\ZoomWooCommerceAppointments\Main\DataStore;

class AppointmentMetaBox extends DataStore {
	public static $instance = null;

	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		if ( is_admin() ) {
			add_action( 'load-post.php', array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
		}

	}

	/**
	 * Meta box initialization.
	 */
	public function init_metabox() {
		add_action( 'add_meta_boxes', array( $this, 'add_metabox' ) );
		add_action( 'save_post', array( $this, 'save_metabox' ), 100, 2 );
	}

	/**
	 * Adds the meta box.
	 */
	public function add_metabox() {
		add_meta_box(
			'vczapi-appointment-zoom-meta-box',
			__( 'Zoom Details', 'vczapi-woocommerce-appointments' ),
			array( $this, 'render_metabox' ),
			'wc_appointment',
			'advanced',
			'default'
		);

	}

	public function is_json( $str ) {
		return json_decode( $str ) != null;
	}

	/**
	 * Renders the meta box.
	 */
	public function render_metabox( $post ) {
		// Add nonce for security and authentication.
		wp_nonce_field( 'vczapi_zoom_appointment_meta_nonce_verify', 'vczapi_zoom_appointment_meta_nonce' );
		$appointment = get_wc_appointment( $post->ID );
		if ( ! is_object( $appointment ) ) {
			return;
		}
		$product_id        = $appointment->get_product_id();
		$product_edit_link = get_edit_post_link( $product_id );
		$meeting_exists    = get_post_meta( $post->ID, '_vczapi_woocommerce_appointments_meeting_exists', true );
		$meeting_error     = Fields::get_meta( $post->ID, 'meeting_error' );

		$meeting_details = Fields::get_meta( $post->ID, 'meeting_details' );
		$meeting_details = ! empty( $meeting_details ) ? json_decode( $meeting_details ) : '';

		$additional_fields_html = '';
		if ( ! empty( $meeting_error ) ) {
			if ( $this->is_json( $meeting_error ) ) {
				$errors = json_decode( $meeting_error );
			} else if ( strpos( $meeting_error, 'xml' ) ) {

				$meeting_error = simplexml_load_string( $meeting_error );
				foreach($meeting_error->errors->children() as $key => $value){
				   $additional_fields_html .='<tr><td>'.$key.'</td><td>'.$value.'</td><tr>';
                }
			}
			?>
            <h2 style="color:red">
				<?php
				_e( "There was an error when creating the meeting - see details bellow:", 'vczapi-woocommerce-appointments' );
				?>
            </h2>
            <table class="form-table">
                <tr>
                    <td>Code</td>
                    <td><?php echo $meeting_error->code; ?></td>
                </tr>
                <tr>
                    <td>Message</td>
                    <td><?php echo $meeting_error->message; ?></td>
                </tr>
                <?php
                echo $additional_fields_html;
                ?>
                <tr>
                    <td><label for="vczapi_create_meeting">Create Meeting:</label></td>
                    <td><input type="checkbox" id="vczapi_create_meeting" name="vczapi_create_meeting" value="yes">
                        <span class="description">
                            <?php printf( __( 'Check this box after you have assigned host to <a href="%s" target="_blank" rel="nofollow noopener">product</a>, and then save the booking, this will create the meeting in Zoom', 'vczapi-woocommerce-appointments' ), $product_edit_link ); ?>
                        </span>
                    </td>
                </tr>

            </table>
			<?php
		} else if ( ! empty( $meeting_details ) ) {
			?>
            <table class="form-table vczapi-woocommerce-email-mtg-details">
                <tr class="vczapi-woocommerce-email-mtg-details--list1">
                    <td><?php _e( 'Meeting Details', 'vczapi-woocommerce-appointments' ); ?>:</td>
                </tr>
                <tr class="vczapi-woocommerce-email-mtg-details--list2">
                    <td><?php _e( 'Topic', 'vczapi-woocommerce-appointments' ); ?>
                        :
                    </td>
                    <td><?php echo $meeting_details->topic; ?></td>
                </tr>
                <tr class="vczapi-woocommerce-email-mtg-details--list3">
                    <td><?php _e( 'Start Time', 'vczapi-woocommerce-appointments' ); ?>:</td>
                    <td><?php echo vczapi_dateConverter( $meeting_details->start_time, $meeting_details->timezone, 'F j, Y @ g:i a' );
						?></td>
                </tr>
                <tr class="vczapi-woocommerce-email-mtg-details--list3">
                    <td><?php _e( 'Timezone', 'vczapi-woocommerce-appointments' ); ?>:</td>
                    <td><?php echo $meeting_details->timezone; ?></td>
                </tr>
                <tr class="vczapi-woocommerce-email-mtg-details--list4">
                    <td><a target="_blank" rel="nofollow" href="<?php echo esc_url( $meeting_details->join_url ); ?>"><?php _e( 'Join via App', 'vczapi-woocommerce-appointments' ); ?></a></td>

                </tr>
                <tr>
					<?php if ( empty( $disabled ) ) { ?>
                        <td class="vczapi-woocommerce-email-mtg-details--list5">
							<?php
							$pwd = ! empty( $meeting_details->password ) ? $meeting_details->password : false;
							echo DataStore::get_browser_join_link( $meeting_details->id, $pwd );
							?>
                        </td>
					<?php } ?>
                </tr>
                <tr>
                    <td>
                        <a href="<?php echo $meeting_details->start_url; ?>" class="button button-primary button-large"><?php _e( 'Start Meeting', 'vczapi-woocommerce-appointments' ); ?></a>
                    </td>
                </tr>
            </table>
			<?php
		}
	}

	/**
	 * Handles saving the meta box.
	 *
	 * @param int      $post_id Post ID.
	 * @param \WP_Post $post    Post object.
	 *
	 * @return null
	 */
	public function save_metabox( $post_id, $post ) {
		// Add nonce for security and authentication.
		$nonce_name     = isset( $_POST['vczapi_zoom_appointment_meta_nonce'] ) ? $_POST['vczapi_zoom_appointment_meta_nonce'] : '';
		$nonce_action   = 'vczapi_zoom_appointment_meta_nonce_verify';
		$create_meeting = filter_input( INPUT_POST, 'vczapi_create_meeting' );


		// Check if nonce is valid.
		if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
			return;
		}

		if ( $create_meeting != 'yes' ) {
			return;
		}

		// Check if user has permissions to save data.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Check if not an autosave.
		if ( wp_is_post_autosave( $post_id ) ) {
			return;
		}

		// Check if not a revision.
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

		$appointment = get_wc_appointment( $post_id );
		if ( ! is_object( $appointment ) ) {
			return;
		}
		$order_id = $appointment->get_order_id();
		$this->create_meeting( $appointment, $post_id, $order_id );
	}

}