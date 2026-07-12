<?php
/**
 * Latest news / articles row on the homepage.
 *
 * @package Nora_Learn
 */

defined( 'ABSPATH' ) || exit;

$news = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => 3,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);

if ( ! $news->have_posts() ) {
	return;
}

$news_url = nora_learn_news_url();
?>
<section class="section">
	<div class="container-nora">
		<div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
			<?php
			nora_learn_section_heading(
				array(
					'eyebrow' => __( 'ข่าวสาร', 'nora-learn' ),
					'title'   => __( 'ข่าวสารและกิจกรรมล่าสุด', 'nora-learn' ),
					'align'   => 'left',
				)
			);
			?>
			<a href="<?php echo esc_url( $news_url ); ?>" class="btn-outline shrink-0">
				<?php esc_html_e( 'อ่านข่าวทั้งหมด', 'nora-learn' ); ?>
				<?php echo nora_learn_icon( 'arrow', 'h-4 w-4' ); // phpcs:ignore ?>
			</a>
		</div>

		<div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
			<?php
			while ( $news->have_posts() ) :
				$news->the_post();
				get_template_part( 'template-parts/cards/post-card' );
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
