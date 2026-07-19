<?php
/**
 * Template for the Continue Learning dashboard tab.
 *
 * @package Nora_Learn
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$user_id = get_current_user_id();

// Cap the grid — enrolled courses are unbounded and each card costs queries.
$nora_max_cards = 12;

// Get enrolled courses (standard order)
$enrolled_courses = tutor_utils()->get_enrolled_courses_by_user( $user_id );
$sorted_courses   = array();

if ( $enrolled_courses && ! empty( $enrolled_courses->posts ) ) {
	$posts = $enrolled_courses->posts;

	global $wpdb;
	$table_name = $wpdb->prefix . 'tutorlms_analytics_events';

	// Fetch last access time for each course if tracker table exists.
	$has_tracker = $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) ) ) === $table_name;
	// Share the result so get_last_viewed_lesson_url() doesn't re-check per card.
	Nora_Learn_Tutor_UX::$analytics_table_exists = $has_tracker;

	foreach ( $posts as $post ) {
		$course_id   = $post->ID;
		$last_access = 0;
		if ( $has_tracker ) {
			$last_access = $wpdb->get_var( $wpdb->prepare( "
				SELECT MAX(created_at)
				FROM {$table_name}
				WHERE course_id = %d AND user_id = %d
			", $course_id, $user_id ) );
			$last_access = $last_access ? strtotime( $last_access ) : 0;
		}

		// If no access found, fallback to post modification date or 0
		if ( ! $last_access ) {
			$last_access = strtotime( $post->post_modified );
		}

		$post->nora_last_access = $last_access;
		$sorted_courses[]      = $post;
	}

	// Sort by nora_last_access descending
	usort( $sorted_courses, function( $a, $b ) {
		return $b->nora_last_access <=> $a->nora_last_access;
	});
}

$nora_total_courses = count( $sorted_courses );
$sorted_courses    = array_slice( $sorted_courses, 0, $nora_max_cards );

?>
<div class="tutor-dashboard-content-inner">
	<div class="tutor-dashboard-inline-links mb-6">
		<h3 class="font-sans text-xl font-bold text-ink m-0"><?php esc_html_e( 'เรียนต่อจากที่ค้างไว้', 'nora-learn' ); ?></h3>
	</div>

	<?php if ( ! empty( $sorted_courses ) ) : ?>
		<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
			<?php
			// Plain foreach on post objects — the_post()/wp_reset_postdata()
			// on a secondary query corrupts the main query's global $post.
			foreach ( $sorted_courses as $course_post ) {
				$course_id = $course_post->ID;

				// Tracker exact last lesson URL
				$resume_url = Nora_Learn_Tutor_UX::get_last_viewed_lesson_url( $course_id, $user_id );
				if ( ! $resume_url ) {
					$resume_url = tutor_utils()->get_course_first_lesson( $course_id );
					// If the course has no lessons at all, fallback to course page
					if ( ! $resume_url ) {
						$resume_url = get_permalink( $course_id );
					}
				}
				?>
				<div class="card p-5 flex flex-col justify-between h-full bg-white border border-paper-200 hover:border-gold/50 transition shadow-sm rounded-xl">
					<div>
						<h4 class="font-sans text-lg font-bold text-ink m-0 mb-3 line-clamp-2">
							<a href="<?php echo esc_url( get_permalink( $course_id ) ); ?>" class="hover:text-gold no-underline text-inherit">
								<?php echo esc_html( get_the_title( $course_id ) ); ?>
							</a>
						</h4>

						<!-- Segmented Progress Bar -->
						<?php Nora_Learn_Tutor_UX::render_segmented_progress_bar( $course_id, $user_id ); ?>
					</div>

					<div class="mt-auto pt-2">
						<a href="<?php echo esc_url( $resume_url ); ?>" class="nora-tutor-btn w-full justify-center">
							<?php esc_html_e( 'เริ่มเรียนต่อเลย', 'nora-learn' ); ?>
						</a>
					</div>
				</div>
				<?php
			}
			?>
		</div>

		<?php if ( $nora_total_courses > $nora_max_cards ) : ?>
			<p class="mt-6 text-sm text-ink-light">
				<?php printf( esc_html__( 'แสดง %1$d จาก %2$d คอร์สที่เรียนล่าสุด — ดูทั้งหมดได้ที่เมนู "คอร์สที่ลงทะเบียน"', 'nora-learn' ), (int) $nora_max_cards, (int) $nora_total_courses ); ?>
			</p>
		<?php endif; ?>
	<?php else : ?>
		<div class="tutor-dashboard-content-inner text-center py-12 bg-paper-50 rounded-xl border border-dashed border-paper-200">
			<i class="ti ti-book text-4xl text-paper-300 mb-4 block"></i>
			<p class="text-ink-light"><?php esc_html_e( 'คุณยังไม่ได้ลงทะเบียนเรียนคอร์สใดเลย', 'nora-learn' ); ?></p>
			<a href="<?php echo esc_url( home_url( '/courses' ) ); ?>" class="nora-tutor-btn mt-4 inline-flex">
				<?php esc_html_e( 'สำรวจคอร์สเรียน', 'nora-learn' ); ?>
			</a>
		</div>
	<?php endif; ?>
</div>
