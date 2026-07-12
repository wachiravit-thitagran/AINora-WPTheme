<?php
/**
 * Learning categories grid (Tutor "course-category" taxonomy when present).
 *
 * @package Nora_Learn
 */

defined( 'ABSPATH' ) || exit;

$taxonomy = taxonomy_exists( 'course-category' ) ? 'course-category' : 'category';

$terms = get_terms(
	array(
		'taxonomy'   => $taxonomy,
		'hide_empty' => true,
		'number'     => 8,
		'orderby'    => 'count',
		'order'      => 'DESC',
	)
);

if ( is_wp_error( $terms ) || empty( $terms ) ) {
	return;
}

// Rotating icon + tint set so each tile feels distinct.
$palette = array(
	array( 'lotus', 'bg-gold-50 text-gold' ),
	array( 'book', 'bg-gold/15 text-gold-dark' ),
	array( 'play', 'bg-night/10 text-night' ),
	array( 'users', 'bg-gold-50 text-gold' ),
	array( 'cert', 'bg-gold/15 text-gold-dark' ),
	array( 'chart', 'bg-night/10 text-night' ),
);
?>
<section class="section bg-paper-100/60 bg-grain">
	<div class="container-nora">
		<?php
		nora_learn_section_heading(
			array(
				'eyebrow' => __( 'หมวดหมู่', 'nora-learn' ),
				'title'   => __( 'เรียนรู้ตามหัวข้อที่สนใจ', 'nora-learn' ),
				'lead'    => __( 'สำรวจหมวดหมู่การเรียนรู้ที่หลากหลาย ตั้งแต่ธรรมะ การภาวนา ไปจนถึงศิลปะและวัฒนธรรม', 'nora-learn' ),
			)
		);
		?>

		<div class="mt-12 grid grid-cols-2 gap-4 sm:gap-6 md:grid-cols-3 lg:grid-cols-4">
			<?php foreach ( $terms as $i => $term ) : ?>
				<?php list( $icon, $tint ) = $palette[ $i % count( $palette ) ]; ?>
				<a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="card card-hover group flex flex-col gap-4 p-6">
					<span class="grid h-14 w-14 place-items-center rounded-2xl <?php echo esc_attr( $tint ); ?> transition group-hover:scale-110">
						<?php echo nora_learn_icon( $icon, 'h-7 w-7' ); // phpcs:ignore ?>
					</span>
					<div>
						<h3 class="font-serif text-lg font-bold text-ink transition group-hover:text-gold"><?php echo esc_html( $term->name ); ?></h3>
						<p class="mt-1 text-sm text-ink-light"><?php printf( esc_html( _n( '%d คอร์ส', '%d คอร์ส', $term->count, 'nora-learn' ) ), (int) $term->count ); ?></p>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
