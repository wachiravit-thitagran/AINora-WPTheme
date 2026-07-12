<?php
/**
 * Empty-state shown when a loop finds no posts.
 *
 * @package Nora_Learn
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="mx-auto max-w-md py-16 text-center">
	<span class="mx-auto grid h-16 w-16 place-items-center rounded-full bg-paper-100 text-gold">
		<?php echo nora_learn_icon( 'search', 'h-8 w-8' ); // phpcs:ignore ?>
	</span>
	<h2 class="mt-6 font-serif text-2xl font-bold text-ink"><?php esc_html_e( 'ไม่พบเนื้อหา', 'nora-learn' ); ?></h2>

	<?php if ( is_search() ) : ?>
		<p class="mt-3 text-ink-light"><?php esc_html_e( 'ไม่พบผลลัพธ์ที่ตรงกับคำค้นหา ลองใช้คำอื่นดูอีกครั้ง', 'nora-learn' ); ?></p>
		<div class="mt-6"><?php get_search_form(); ?></div>
	<?php else : ?>
		<p class="mt-3 text-ink-light"><?php esc_html_e( 'ยังไม่มีเนื้อหาในส่วนนี้ โปรดกลับมาใหม่อีกครั้ง', 'nora-learn' ); ?></p>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-primary mt-6"><?php esc_html_e( 'กลับหน้าแรก', 'nora-learn' ); ?></a>
	<?php endif; ?>
</div>
