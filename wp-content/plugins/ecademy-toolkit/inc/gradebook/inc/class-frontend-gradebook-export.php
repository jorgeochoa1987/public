<?php
class LP_Frontend_Gradebook_Export {


	function __construct( $args ) {
		add_action( 'wp_ajax_gradebook_exportfe', array( $this, 'ajax_gradebook_exportfe' ) );
	}


	public function ajax_gradebook_exportfe() {

		global $wpdb;
		$course_id = $_REQUEST['course_id'];
		$limit  = '';
		$args = array(
			'action' => 'gradebook_export',
			'step'	=> 'export',
			'course_id'=> $course_id,
			'date-from' => '',
			'date-to' => '',
			'page' => '',
			'total'=>1,
			'limit'=>'',
			'gradebook-nonce'=>'',
			'type'=>''
		);
		$results = [];
		$students = $this->get_enrolled_students( $course_id, $args );
		foreach ($students as $student){
			$user        = learn_press_get_user( $student->ID);
			$course_data = $user->get_course_data( $course_id );
			$employee_object = new stdClass;
			$employee_object->{'User ID'} = $user->get_id();
			$employee_object->{'User email'} = $user->get_email();
			$employee_object->{'User display name'} = $user->get_display_name();
			$employee_object->{'Average'} = $course_data->get_percent_result();
			$employee_object->{'Enrolled'} = $course_data->get_start_time( get_option( 'date_format' ) );
			$employee_object->{'Status'} = $course_data->get_grade();
			$results[] = $employee_object;
		}
		wp_send_json_success($results);
		wp_die(); // this is required to terminate immediately and return a proper response
	}




	public function step_done( $course_id, $args = array() ) {
		$group      = 'gradebook_export';
		$key_prefix = md5( $group . '-' . $args['course_id'] . '-' . $args['date-from'] . '-' . $args['date-to'] . '-' . $args['gradebook-nonce'] );
		$page_last  = intval( $args['total'] ) / $args['limit'];
		if ( $page_last > intval( $page_last ) ) {
			$page_last = intval( $page_last ) + 1;
		}
		$rows     = array();
		$head_row = $this->build_head_row( $course_id );
		$rows[]   = $head_row;
		for ( $i = 1; $i <= $page_last; $i ++ ) {
			$key = $key_prefix . '_' . $i;
			// $rows_page = get_transient( $key );
			$rows_page = learn_press_gradebook_get_transient( $key );
			if ( $rows_page && is_array( $rows_page ) && ! empty( $rows_page ) ) {
				$rows = array_merge( $rows, $rows_page );
			}
		}
		$result = [];
		foreach ( $rows as $k => $row ) {
			$result[] = join( ',', $row );
		}
		wp_send_json_success($result);
	}


	public function step_export( $course_id, $args = array() ) {
		$page = $args['page'];
		if ( ! $page ) {
			$page = 1;
		}
		$students = $this->get_enrolled_students( $course_id, $args );
		$rows     = array();
		foreach ( $students as $student ) {
			$rows[] = $this->build_row( $course_id, $student->ID );
		}
		// create key
		$group = 'gradebook_export';
		$key   = md5( $group . '-' . $args['course_id'] . '-' . $args['date-from'] . '-' . $args['date-to'] . '-' . $args['gradebook-nonce'] ) . '_' . $page;
// 		$res = set_transient( $key, $rows, 60 * 60 ); // stored row in transient
		$res       = learn_press_gradebook_set_transient( $key, $rows );
		$page_last = round( $args['total'] / $args['limit'], 0, PHP_ROUND_HALF_EVEN );
		if ( $page_last < $args['total'] / $args['limit'] ) {
			$page_last ++;
		}
		if ( $page >= $page_last ) {
			$args['step'] = 'done';
			$args['type'] = 'csv';
		} else {
			$args['page'] = $page + 1;
		}
		return $args;
	}


	/**
	 *
	 */
	public function step_start( $course_id, $args = array() ) {
		# get total enrolled students
		$args['total'] = $this->get_total_enrolled_students( $course_id, $args );
		$args['step']  = 'export';

		return $args;
	}

	/**
	 *
	 */
	public function step_init() {
		# get total enrolled students
		$action = filter_input( INPUT_POST, 'action' );
		$step   = filter_input( INPUT_POST, 'step' );
		$href   = filter_input( INPUT_POST, 'href' );

		$parser_url = parse_url( $href );
		$parse_str  = array();

		parse_str( $parser_url['query'], $parse_str );

		$course_id       = 10;// => 34
		$date_from       = $parse_str['date-from'];// =>
		$date_to         = $parse_str['date-to'];// =>
		$export          = $parse_str['export'];// => csv

		// using gradebook_nonce & course_id & date_from & date_to to create cache_id
		$parse_str['action'] = $action;
		$parse_str['step']   = 'start';
		$args                = array(
			'action'          => $action,
			'step'            => 'start',
			'course_id'       => $course_id,
			'date-from'       => $date_from,
			'date-to'         => $date_to,
		);

		return $args;
	}


	/**
	 *
	 * @param unknown $course_id
	 * @param array $args
	 *
	 * @return array|object|NULL
	 */
	public function get_enrolled_students( $course_id, $args = array() ) {
		global $wpdb;
		$date_from    = isset( $args['date-from'] ) ? $args['date-from'] : '';
		$date_to      = isset( $args['date-to'] ) ? $args['date-to'] : '';
		$prepare_args = array(
			LP_COURSE_CPT,
			$course_id
		);

		$sql_date = "";

		if ( $date_from ) {
			$sql_date       .= " AND lui.start_time > %s ";
			$prepare_args[] = $date_from;
		}

		if ( $date_to ) {
			$sql_date       .= " AND lui.start_time < %s ";
			$prepare_args[] = $date_to;
		}

		$prepare_args[] = LP_COURSE_CPT;
		$prepare_args[] = $course_id;

		$limit = isset( $args['limit'] ) ? $args['limit'] : 0;
		$page  = isset( $args['page'] ) ? intval( $args['page'] ) : 1;
		if ( ! $page ) {
			$page = 1;
		}

		$sql_limit = "";
		if ( $limit ) {
			$limit_start = ( $page - 1 ) * $limit;
			$sql_limit   = " LIMIT {$limit_start}, {$limit}";
		}

		$sql = "
			SELECT
				`u`.`ID`,
				`u`.`user_login`,
				`u`.`display_name`,
				`lui`.*
			FROM
				`{$wpdb->users}` AS `u`
					INNER JOIN
				`{$wpdb->prefix}learnpress_user_items` AS `lui` ON `u`.`ID` = `lui`.`user_id`
			WHERE
				`lui`.`item_type` = %s
					AND `lui`.`item_id` = %d
						" . $sql_date . "
					AND `lui`.`user_item_id` IN (
							SELECT
								MAX(`user_item_id`)
							FROM
								`{$wpdb->prefix}learnpress_user_items`
							WHERE
								`item_type` = %s AND `item_id` = %d
							GROUP BY `user_id`
						)
			ORDER BY `lui`.`user_id` , `lui`.`start_time` " . $sql_limit;

		$query = $wpdb->prepare( $sql, $prepare_args );
		$rows  = $wpdb->get_results( $query );

		return $rows;
	}


	public function get_enrolled_students_id( $course_id, $args = array(), $force = false ) {
		global $wpdb;
		$date_from   = isset( $args['date-from'] ) ? $args['date-from'] : '';
		$date_to     = isset( $args['date-to'] ) ? $args['date-to'] : '';
		$limit       = $args['limit'];
		$page        = $args['page'] ? $args['page'] : 1;
		$limit_start = ( $page - 1 ) . $limit;

		$prepare_args = array(
			LP_COURSE_CPT,
			$course_id
		);

		$sql_date = "";
		if ( $date_from ) {
			$sql_date       .= " AND lui.start_time > %s ";
			$prepare_args[] = $date_from;
		}

		if ( $date_to ) {
			$sql_date       .= " AND lui.start_time < %s ";
			$prepare_args[] = $date_to;
		}

		$prepare_args[] = LP_COURSE_CPT;
		$prepare_args[] = $course_id;

		$sql = "
			SELECT
				`u`.`ID`
			FROM
				`{$wpdb->users}` AS `u`
					INNER JOIN
				`{$wpdb->prefix}learnpress_user_items` AS `lui` ON `u`.`ID` = `lui`.`user_id`
			WHERE
				`lui`.`item_type` = %s
					AND `lui`.`item_id` = %d
					" . $sql_date . "
					AND `lui`.`user_item_id` IN (
							SELECT
								MAX(`user_item_id`)
							FROM
								`{$wpdb->prefix}learnpress_user_items`
							WHERE
								`item_type` = %s AND `item_id` = %d
							GROUP BY `user_id`
						)
			ORDER BY `lui`.`user_id` , `lui`.`start_time`";

		$query = $wpdb->prepare( $sql, $prepare_args );
		$ids   = $wpdb->get_col( $query );

		return $ids;
	}


	public function get_total_enrolled_students( $course_id, $args = array() ) {
		global $wpdb;
		$date_from = isset( $args['date-from'] ) ? $args['date-from'] : '';
		$date_to   = isset( $args['date-to'] ) ? $args['date-to'] : '';

		$prepare_args = array(
			LP_COURSE_CPT,
			$course_id
		);

		$sql_date = "";
		if ( $date_from ) {
			$sql_date       .= " AND lui.start_time > %s ";
			$prepare_args[] = $date_from;
		}

		if ( $date_to ) {
			$sql_date       .= " AND lui.start_time < %s ";
			$prepare_args[] = $date_to;
		}

		$prepare_args[] = LP_COURSE_CPT;
		$prepare_args[] = $course_id;

		$sql = "
			SELECT
				COUNT(*)
			FROM
				`{$wpdb->users}` AS `u`
					INNER JOIN
				`{$wpdb->prefix}learnpress_user_items` AS `lui` ON `u`.`ID` = `lui`.`user_id`
			WHERE
				`lui`.`item_type` = %s
					AND `lui`.`item_id` = %d
					" . $sql_date . "
					AND `lui`.`user_item_id` IN (
						SELECT
							MAX(`user_item_id`)
						FROM
							`{$wpdb->prefix}learnpress_user_items`
						WHERE
							`item_type` = %s AND `item_id` = %d
						GROUP BY `user_id`
					)
			ORDER BY `lui`.`user_id` , `lui`.`start_time`";

		$query = $wpdb->prepare( $sql, $prepare_args );
		$var   = $wpdb->get_var( $query );

		return $var;
	}


	public function build_row( $course_id, $user_id ) {
		$user        = learn_press_get_user( $user_id );
		$course_data = $user->get_course_data( $course_id );
		$row         = array(
			$user->get_id(),
			$this->prepareCellContent( $user->get_data( 'user_login' ) ),
			$this->prepareCellContent( $user->get_email() ),
			$this->prepareCellContent( $user->get_display_name() )
		);
		$row[] = $this->prepareCellContent( $course_data->get_percent_result() );
		$row[] = $this->prepareCellContent( $course_data->get_start_time( get_option( 'date_format' ) ) );
		$row[] = $this->prepareCellContent( $course_data->get_grade() );

		return $row;
	}


	public function build_head_row( $course_id ) {
		$course           = learn_press_get_course( $course_id );
		$curricutum_items = $course->get_curriculum_items();
		$row              = array(
			$this->prepareCellContent( __( 'User ID', 'ecademy-toolkit' ) ),
			$this->prepareCellContent( __( 'User login', 'ecademy-toolkit' ) ),
			$this->prepareCellContent( __( 'User email', 'ecademy-toolkit' ) ),
			$this->prepareCellContent( __( 'User display name', 'ecademy-toolkit' ) )
		);
		$row[] = __( 'Average', 'ecademy-toolkit' );
		$row[] = __( 'Enrolled', 'ecademy-toolkit' );
		$row[] = __( 'Status', 'ecademy-toolkit' );

		return $row;
	}

	public function prepareCellContent( $input = "" ) {
		preg_match( '/,/i', $input, $result );
		$add_quote = false;
		$output    = $input;
		if ( is_array( $result ) && ! empty( $result ) ) {
			$output    = str_replace( '"', "'", $input );
			$add_quote = true;
		}
		if ( ! $add_quote ) {
			preg_match( '/\n/i', $input, $result2 );
			$add_quote = is_array( $result2 ) && ! empty( $result2 );
		}
		if ( $add_quote ) {
			$output = '"' . $output . '"';
		}

		return $output;
	}

}


new LP_Frontend_Gradebook_Export( array() );
