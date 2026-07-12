<?php
/**
 * Template Name: สถิติการเรียนรู้ (Statistics)
 *
 * Public dashboard of platform numbers, in the spirit of the volunteer
 * platform statistics.
 *
 * @package Nora_Learn
 */

defined( 'ABSPATH' ) || exit;

get_header();

$stats        = nora_learn_get_stats();
$page_content = '';

while ( have_posts() ) :
	the_post();
	$page_content = get_the_content();
	nora_learn_page_hero(
		array(
			'eyebrow'  => __( 'ภาพรวม', 'nora-learn' ),
			'title'    => get_the_title(),
			'subtitle' => __( 'ตัวเลขการเรียนรู้บนแพลตฟอร์ม อัปเดตอัตโนมัติจากระบบ', 'nora-learn' ),
		)
	);
endwhile;

$cards = array(
	array( 'book', $stats['courses'], __( 'คอร์สเรียนทั้งหมด', 'nora-learn' ), 'bg-gold-50 text-gold' ),
	array( 'play', $stats['lessons'], __( 'บทเรียน', 'nora-learn' ), 'bg-gold/15 text-gold-dark' ),
	array( 'users', $stats['students'], __( 'ผู้เรียน', 'nora-learn' ), 'bg-night/10 text-night' ),
	array( 'user', $stats['instructors'], __( 'ผู้สอน/วิทยากร', 'nora-learn' ), 'bg-gold-50 text-gold' ),
);
?>

<main id="main" class="section">
	<div class="container-nora">

		<!-- Big stat cards -->
		<div class="grid grid-cols-2 gap-6 lg:grid-cols-4">
			<?php foreach ( $cards as $card ) : ?>
				<div class="card flex flex-col items-center gap-3 p-8 text-center" x-data="countUp(<?php echo (int) $card[1]; ?>)">
					<span class="grid h-16 w-16 place-items-center rounded-2xl <?php echo esc_attr( $card[3] ); ?>"><?php echo nora_learn_icon( $card[0], 'h-8 w-8' ); // phpcs:ignore ?></span>
					<span class="font-serif text-4xl font-black text-ink sm:text-5xl" x-text="display">0</span>
					<span class="text-sm font-medium text-ink-light"><?php echo esc_html( $card[2] ); ?></span>
				</div>
			<?php endforeach; ?>
		</div>

		<!-- Page content (editable notes / charts shortcode) -->
		<?php
		$nora_is_elementor = isset( $_GET['elementor-preview'] ) || ( class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->preview->is_preview_mode() );
		if ( trim( $page_content ) || $nora_is_elementor ) : ?>
			<div class="prose-nora mx-auto mt-16">
				<?php
				rewind_posts();
				while ( have_posts() ) :
					the_post();
					the_content();
				endwhile;
				?>
			</div>
		<?php endif; ?>

		<!-- Top courses by enrolment -->
		<?php
		$tutils = nora_learn_tutor_utils();
		if ( $tutils ) :
			$top = new WP_Query(
				array(
					'post_type'      => 'courses',
					'posts_per_page' => 5,
					'meta_key'       => '_tutor_course_total_enrolled',
					'orderby'        => 'meta_value_num',
					'order'          => 'DESC',
					'no_found_rows'  => true,
				)
			);
			if ( $top->have_posts() ) :
				?>
				<div class="mt-16">
					<h2 class="font-serif text-2xl font-bold text-ink"><?php esc_html_e( 'คอร์สยอดนิยม', 'nora-learn' ); ?></h2>
					<div class="mt-6 overflow-hidden rounded-2xl border border-paper-200 bg-white shadow-card">
						<table class="w-full text-left text-sm">
							<thead class="bg-paper-100 text-xs uppercase tracking-wider text-ink-light">
								<tr>
									<th class="px-6 py-4 font-semibold">#</th>
									<th class="px-6 py-4 font-semibold"><?php esc_html_e( 'คอร์ส', 'nora-learn' ); ?></th>
									<th class="px-6 py-4 text-right font-semibold"><?php esc_html_e( 'ผู้เรียน', 'nora-learn' ); ?></th>
								</tr>
							</thead>
							<tbody class="divide-y divide-paper-100">
								<?php
								$rank = 0;
								while ( $top->have_posts() ) :
									$top->the_post();
									$rank++;
									$enrolled = method_exists( $tutils, 'count_enrolled_users_by_course' ) ? (int) $tutils->count_enrolled_users_by_course( get_the_ID() ) : 0;
									?>
									<tr class="transition hover:bg-paper-50">
										<td class="px-6 py-4 font-serif font-bold text-gold"><?php echo esc_html( $rank ); ?></td>
										<td class="px-6 py-4"><a href="<?php the_permalink(); ?>" class="font-medium text-ink hover:text-gold"><?php the_title(); ?></a></td>
										<td class="px-6 py-4 text-right font-semibold text-ink"><?php echo esc_html( number_format_i18n( $enrolled ) ); ?></td>
									</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
				<?php
				wp_reset_postdata();
			endif;
		endif;
		?>
	</div>
</main>

<?php
get_footer();
