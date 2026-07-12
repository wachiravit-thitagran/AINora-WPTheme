<?php
/**
 * Partners / supporting organisations logo strip.
 *
 * Pulls images from a "partners" gallery if one is set via the
 * `nora_learn_partner_logos` filter; otherwise renders a quiet quote block so
 * the homepage never ends on an empty section.
 *
 * @package Nora_Learn
 */

defined( 'ABSPATH' ) || exit;

/**
 * Filterable list of partner logos. Each item: array( 'name', 'url', 'image' ).
 */
$partners = apply_filters( 'nora_learn_partner_logos', array() );
?>
<section class="section-tight bg-paper-100/60">
	<div class="container-nora">
		<?php if ( ! empty( $partners ) ) : ?>
			<p class="text-center text-xs font-semibold uppercase tracking-[0.2em] text-ink-light"><?php esc_html_e( 'ภายใต้ความร่วมมือกับ', 'nora-learn' ); ?></p>
			<div class="mt-8 flex flex-wrap items-center justify-center gap-x-12 gap-y-8 opacity-70 grayscale">
				<?php foreach ( $partners as $p ) : ?>
					<a href="<?php echo esc_url( $p['url'] ?? '#' ); ?>" class="transition hover:opacity-100 hover:grayscale-0">
						<img src="<?php echo esc_url( $p['image'] ); ?>" alt="<?php echo esc_attr( $p['name'] ?? '' ); ?>" class="h-12 w-auto" loading="lazy">
					</a>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<figure class="mx-auto max-w-3xl text-center">
				<?php echo nora_learn_icon( 'quote', 'mx-auto h-10 w-10 text-gold/60' ); // phpcs:ignore ?>
				<blockquote class="mt-4 font-serif text-2xl font-medium leading-relaxed text-ink sm:text-3xl">
					<?php esc_html_e( '“มโนราห์ คือลมหายใจแห่งแผ่นดินใต้ มรดกที่มีชีวิตจากรุ่นสู่รุ่น”', 'nora-learn' ); ?>
				</blockquote>
				<figcaption class="mt-5 text-sm font-semibold uppercase tracking-wider text-gold">
					<?php esc_html_e( '— มรดกวัฒนธรรมมโนราห์', 'nora-learn' ); ?>
				</figcaption>
			</figure>
		<?php endif; ?>
	</div>
</section>
