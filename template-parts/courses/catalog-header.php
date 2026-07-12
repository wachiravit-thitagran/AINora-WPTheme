<?php
/**
 * Course catalog header: title, count, course search and browse-by-category
 * chips. Sits above the Tutor LMS archive grid (see tutor/archive-course.php)
 * and also adapts to course-category / course-tag term archives.
 *
 * @package Nora_Learn
 */

defined( 'ABSPATH' ) || exit;

$nora_total = 0;
$nora_counts = wp_count_posts( 'courses' );
if ( $nora_counts && isset( $nora_counts->publish ) ) {
	$nora_total = (int) $nora_counts->publish;
}

$nora_is_term = is_tax( 'course-category' ) || is_tax( 'course-tag' );
$nora_term    = $nora_is_term ? get_queried_object() : null;
$nora_active  = ( $nora_term && isset( $nora_term->term_id ) ) ? (int) $nora_term->term_id : 0;

$nora_title = $nora_term ? $nora_term->name : __( 'คอร์สเรียนทั้งหมด', 'nora-learn' );
$nora_desc  = ( $nora_term && ! empty( $nora_term->description ) )
	? $nora_term->description
	: ( $nora_total ? sprintf( __( 'เลือกเรียนได้จาก %s คอร์ส ตามจังหวะของคุณ', 'nora-learn' ), number_format_i18n( $nora_total ) ) : '' );

$nora_courses_url = function_exists( 'nora_learn_courses_url' ) ? nora_learn_courses_url() : home_url( '/courses/' );

$nora_cats = get_terms(
	array(
		'taxonomy'   => 'course-category',
		'hide_empty' => true,
		'number'     => 12,
		'orderby'    => 'count',
		'order'      => 'DESC',
	)
);
?>
<section class="bg-paper-50 pt-10 sm:pt-14">
	<div class="container-nora">
		<p class="eyebrow"><?php esc_html_e( 'คลังคอร์ส', 'nora-learn' ); ?></p>

		<div class="mt-3 flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
			<div class="max-w-2xl">
				<h1 class="section-title"><?php echo esc_html( $nora_title ); ?></h1>
				<?php if ( $nora_desc ) : ?>
					<p class="lead mt-2"><?php echo esc_html( wp_strip_all_tags( $nora_desc ) ); ?></p>
				<?php endif; ?>
			</div>

			<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>"
				class="flex w-full max-w-sm items-center gap-2 rounded-full border border-paper-200 bg-white p-1.5 shadow-soft focus-within:ring-2 focus-within:ring-gold/30">
				<input type="hidden" name="post_type" value="courses" />
				<span class="grid h-9 w-9 shrink-0 place-items-center text-ink-light"><?php echo nora_learn_icon( 'search', 'h-5 w-5' ); // phpcs:ignore ?></span>
				<label for="nora-catalog-search" class="sr-only"><?php esc_html_e( 'ค้นหาคอร์ส', 'nora-learn' ); ?></label>
				<input id="nora-catalog-search" type="search" name="s"
					placeholder="<?php esc_attr_e( 'ค้นหาคอร์ส…', 'nora-learn' ); ?>"
					class="min-w-0 flex-1 border-0 bg-transparent text-ink placeholder:text-ink-light focus:ring-0" />
				<button type="submit" class="btn-primary shrink-0 rounded-full"><?php esc_html_e( 'ค้นหา', 'nora-learn' ); ?></button>
			</form>
		</div>

		<?php if ( ! is_wp_error( $nora_cats ) && ! empty( $nora_cats ) ) : ?>
			<nav class="mt-6 flex flex-wrap gap-2" aria-label="<?php esc_attr_e( 'หมวดหมู่คอร์ส', 'nora-learn' ); ?>">
				<a href="<?php echo esc_url( $nora_courses_url ); ?>"
					class="pill <?php echo $nora_active ? 'bg-paper-100 text-ink-light hover:bg-gold-50 hover:text-gold' : 'pill-gold'; ?>">
					<?php esc_html_e( 'ทั้งหมด', 'nora-learn' ); ?>
				</a>
				<?php foreach ( $nora_cats as $nora_cat ) : ?>
					<a href="<?php echo esc_url( get_term_link( $nora_cat ) ); ?>"
						class="pill <?php echo ( $nora_active === (int) $nora_cat->term_id ) ? 'pill-gold' : 'bg-paper-100 text-ink-light hover:bg-gold-50 hover:text-gold'; ?>">
						<?php echo esc_html( $nora_cat->name ); ?>
					</a>
				<?php endforeach; ?>
			</nav>
		<?php endif; ?>
	</div>
</section>
