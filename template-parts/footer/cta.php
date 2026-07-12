<?php
/**
 * Pre-footer call-to-action strip.
 *
 * @package Nora_Learn
 */

defined( 'ABSPATH' ) || exit;

$title  = nora_learn_option( 'nora_cta_title', __( 'พร้อมเริ่มต้นการเรียนรู้แล้วหรือยัง?', 'nora-learn' ) );
$button = nora_learn_option( 'nora_cta_button', __( 'สมัครเรียนฟรี', 'nora-learn' ) );
$url    = nora_learn_option( 'nora_cta_url' ) ?: nora_learn_courses_url();
?>
<section class="relative overflow-hidden bg-gold-wash">
	<div class="absolute inset-0 bg-grain opacity-[0.08]" aria-hidden="true"></div>
	<div class="container-nora relative flex flex-col items-center gap-6 py-14 text-center sm:py-16">
		<?php echo nora_learn_icon( 'lotus', 'h-10 w-10 text-gold-light' ); // phpcs:ignore ?>
		<h2 class="max-w-2xl font-serif text-3xl font-bold text-white sm:text-4xl"><?php echo wp_kses_post( $title ); ?></h2>
		<a href="<?php echo esc_url( $url ); ?>" class="btn-gold btn-lg">
			<?php echo esc_html( $button ); ?>
			<?php echo nora_learn_icon( 'arrow', 'h-5 w-5' ); // phpcs:ignore ?>
		</a>
	</div>
</section>
