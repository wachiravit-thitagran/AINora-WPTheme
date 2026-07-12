<?php
/**
 * The homepage. Composed from self-contained section parts so the order can be
 * rearranged without touching their internals.
 *
 * If the front page is set to a static page that has its own content, we still
 * lead with the designed sections — the page content (if any) renders after.
 *
 * @package Nora_Learn
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<main id="main">
	<?php
	// Lead with the core "find a course" path: hero → browse by category →
	// featured courses. Secondary sections below are toggleable in the
	// Customizer (Nora Learn → เนื้อหาหน้าแรก) so the page can stay lean.
	get_template_part( 'template-parts/home/hero' );
	get_template_part( 'template-parts/home/categories' );
	get_template_part( 'template-parts/home/featured-courses' );

	if ( nora_learn_option( 'nora_show_stats', true ) ) {
		get_template_part( 'template-parts/home/stats' );
	}
	if ( nora_learn_option( 'nora_show_how_it_works', true ) ) {
		get_template_part( 'template-parts/home/how-it-works' );
	}
	if ( nora_learn_option( 'nora_show_instructors', true ) ) {
		get_template_part( 'template-parts/home/instructors' );
	}
	if ( nora_learn_option( 'nora_show_news', true ) ) {
		get_template_part( 'template-parts/home/latest-news' );
	}
	if ( nora_learn_option( 'nora_show_partners', true ) ) {
		get_template_part( 'template-parts/home/partners' );
	}

	// Render static front-page content beneath the designed sections, if present.
	if ( is_page() && have_posts() ) :
		while ( have_posts() ) :
			the_post();
			$nora_content = get_the_content();
			$nora_is_elementor = isset( $_GET['elementor-preview'] ) || ( class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->preview->is_preview_mode() );
			if ( trim( $nora_content ) || $nora_is_elementor ) :
				?>
				<section class="section-tight">
					<div class="container-nora">
						<div class="prose-nora mx-auto"><?php the_content(); ?></div>
					</div>
				</section>
				<?php
			endif;
		endwhile;
	endif;
	?>
</main>

<?php
get_footer();
