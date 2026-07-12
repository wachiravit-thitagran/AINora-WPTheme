<?php
/**
 * Archive template — categories, tags, taxonomies, dates, authors.
 *
 * @package Nora_Learn
 */

defined( 'ABSPATH' ) || exit;

get_header();

nora_learn_page_hero(
	array(
		'eyebrow'  => __( 'คลังเนื้อหา', 'nora-learn' ),
		'title'    => get_the_archive_title(),
		'subtitle' => wp_strip_all_tags( get_the_archive_description() ),
	)
);
?>

<main id="main" class="section">
	<div class="container-nora">
		<?php if ( have_posts() ) : ?>
			<div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/cards/post-card' );
				endwhile;
				?>
			</div>
			<?php nora_learn_pagination(); ?>
		<?php else : ?>
			<?php get_template_part( 'template-parts/content-none' ); ?>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
