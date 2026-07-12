<?php
/**
 * Footer bottom bar: copyright + legal menu.
 *
 * @package Nora_Learn
 */

defined( 'ABSPATH' ) || exit;

$copyright = nora_learn_option( 'nora_footer_copyright' );
if ( ! $copyright ) {
	/* translators: 1: year, 2: site name */
	$copyright = sprintf( __( '© %1$s %2$s สงวนลิขสิทธิ์', 'nora-learn' ), gmdate( 'Y' ), get_bloginfo( 'name' ) );
}
?>
<div class="border-t border-paper-200">
	<div class="container-nora py-6 text-xs text-paper-500">

		<!-- Institutional credit -->
		<div class="space-y-1 text-center leading-relaxed [&_a]:text-ink-light [&_a:hover]:text-gold-dark">
			<p>
				<?php esc_html_e( 'แพลตฟอร์มการเรียนรู้มรดกวัฒนธรรมมโนราห์', 'nora-learn' ); ?>
				<a href="https://www.psu.ac.th/" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'มหาวิทยาลัยสงขลานครินทร์', 'nora-learn' ); ?></a>
				<?php esc_html_e( 'ร่วมกับ', 'nora-learn' ); ?>
				<a href="https://diis.psu.ac.th/" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'สำนักนวัตกรรมดิจิทัลและระบบอัจฉริยะ', 'nora-learn' ); ?></a>
			</p>
			<p>
				<?php esc_html_e( 'อีเมล:', 'nora-learn' ); ?>
				<a href="mailto:patsadu_diis@psu.ac.th">patsadu_diis@psu.ac.th</a>
				<span class="px-1 text-paper-500">&middot;</span>
				<?php esc_html_e( 'โทร:', 'nora-learn' ); ?>
				<a href="tel:074282105">074-28-2105</a>
			</p>
		</div>

		<!-- Copyright + legal -->
		<div class="mt-5 flex flex-col items-center justify-between gap-3 border-t border-paper-200 pt-5 md:flex-row">
			<p><?php echo wp_kses_post( $copyright ); ?></p>

			<?php
			if ( has_nav_menu( 'footer_legal' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'footer_legal',
						'container'      => false,
						'menu_class'     => 'flex flex-wrap items-center gap-x-5 gap-y-1 [&_a]:text-ink-light [&_a:hover]:text-gold-dark',
						'depth'          => 1,
						'fallback_cb'    => false,
					)
				);
			} else {
				echo '<p class="text-paper-500">' . esc_html__( 'พัฒนาเพื่อการเรียนรู้และอนุรักษ์มรดกวัฒนธรรม', 'nora-learn' ) . '</p>';
			}
			?>
		</div>
	</div>
</div>
