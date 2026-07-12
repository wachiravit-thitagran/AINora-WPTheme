<?php
/**
 * The footer: CTA strip, widget columns, bottom bar, closing markup.
 *
 * @package Nora_Learn
 */

defined( 'ABSPATH' ) || exit;
?>
	</div><!-- #content -->

	<footer id="colophon" class="site-footer relative mt-16 overflow-hidden border-t border-paper-200 bg-paper-50 text-ink-light sm:mt-20">
		<div class="absolute inset-0 bg-grain opacity-[0.35]" aria-hidden="true"></div>
		<div class="relative">
			<?php get_template_part( 'template-parts/footer/columns' ); ?>
			<?php get_template_part( 'template-parts/footer/bottom' ); ?>
		</div>
	</footer>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
