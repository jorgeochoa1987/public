<?php
/**
 * Admin View: Gradebook details page.
 */

/**
 * Prevent loading this file directly
 */
defined( 'ABSPATH' ) || exit();


?>

<?php $items = is_array($datas) && isset($datas[ $this->course->get_id() ]['items'])?$datas[ $this->course->get_id() ]['items']:array(); ?>

<table class="form-table">
	<thead>
	<tr>
		<td><?php _e( 'Title', 'ecademy-toolkit' ); ?></td>
		<td><?php _e( 'Type', 'ecademy-toolkit' ); ?></td>
		<td><?php _e( 'Passing Grade', 'ecademy-toolkit' ); ?></td>
		<td><?php _e( 'Results', 'ecademy-toolkit' ); ?></td>
		<td><?php _e( 'Status', 'ecademy-toolkit' ); ?></td>
	</tr>
	<thead>
	<tbody>
	<?php

	?>
	<?php if ( ! empty( $items ) ) { ?>
		<?php foreach ( $items as $data_item ) { ?>
			<tr>
				<td><?php esc_html_e( $data_item->post_title ); ?></td>
				<td>
					<?php if ( strpos( $data_item->post_type, 'lp_' ) === 0 ) {
						_e( substr( $data_item->post_type, 3 ), 'ecademy-toolkit' );
					} ?>
				</td>
				<td>
					<?php
					if ( $data_item->post_type == 'lp_quiz' ) {
						$quiz = learn_press_get_quiz( $data_item->ID );
						printf( __( "%s%%", 'ecademy-toolkit' ), $quiz->get_data( 'passing_grade' ) );
					} else if ( $data_item->post_type == 'lp_lesson' ) {
						echo '-';
					} else {
						do_action( 'learn-press/gradebook/details-view/passing-grade', $data_item );
					} ?>
				</td>
				<td>
					<?php
					if ( $data_item->post_type == 'lp_quiz' ) {
						if ( $data_item->status == 'completed' ) {
							$user_item = learn_press_get_user( $data_item->user_id );
							$quiz_res  = $user_item->get_quiz_results( $data_item->item_id, $data_item->ref_id, false ); ?>
							<span class="quiz-result"><strong><?php echo __( $quiz_res['grade_text'], 'ecademy-toolkit' ); ?></strong></span>
							<div class="quiz-result-details">
								<?php echo __( 'Mark', 'ecademy-toolkit' ); ?>: <span>
									<?php if($quiz_res['user_mark'] != "") :   ?>

										<?php printf( __( "%s/%s mark (%s%%)", 'ecademy-toolkit' ), $quiz_res['user_mark'], $quiz_res['mark'], round(( $quiz_res['user_mark'] / $quiz_res['mark'] ) * 100, 2) ); ?>
									<?php else:  ?>
										<?php printf( __( "%s", 'ecademy-toolkit' ), $quiz_res['user_mark'] ? $quiz_res['user_mark'] : "0" ); ?>
									<?php endif; ?>
									</span>
								<br/><?php echo __( 'Answered', 'ecademy-toolkit' ); ?>: <span><?php printf( __( "%s/%s questions", 'ecademy-toolkit' ), $quiz_res['question_answered'], $quiz_res['question_count'] ); ?></span>
								<br/><?php echo __( 'Correct', 'ecademy-toolkit' ); ?>: <span><?php printf( __( "%s questions", 'ecademy-toolkit' ), $quiz_res['question_correct'] ); ?></span>
								<br/><?php echo __( 'Wrong', 'ecademy-toolkit' ); ?>: <span><?php printf( __( "%s questions", 'ecademy-toolkit' ), $quiz_res['question_wrong'] ); ?></span>
							</div>
						<?php } else {
							echo '-';
						}
					} else if ( $data_item->post_type == 'lp_lesson' ) {
						if ( $data_item->status == 'completed' ) {
							echo __( 'completed', 'ecademy-toolkit' );
						} else {
							echo '-';
						}
					} else {
						do_action( 'learn-press/gradebook/details-view/result', $data_item );
					} ?>
				</td>
				<td><?php _e( $data_item->status, 'ecademy-toolkit' ); ?></td>
			</tr>
		<?php } ?>
	<?php } ?>
	</tbody>
</table>
