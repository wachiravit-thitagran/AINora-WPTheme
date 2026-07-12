<?php
/**
 * Footer widget columns + brand block.
 *
 * @package Nora_Learn
 */

defined( 'ABSPATH' ) || exit;

$about   = nora_learn_option( 'nora_footer_about' );
$address = nora_learn_option( 'nora_contact_address' );
$phone   = nora_learn_option( 'nora_contact_phone' );
$email   = nora_learn_option( 'nora_contact_email' );

$socials = array_filter(
	array(
		'facebook' => nora_learn_option( 'nora_social_facebook' ),
		'youtube'  => nora_learn_option( 'nora_social_youtube' ),
		'line'     => nora_learn_option( 'nora_social_line' ),
	)
);
?>
<div class="container-nora grid grid-cols-1 gap-10 py-16 sm:grid-cols-2 lg:grid-cols-12 lg:gap-8">

	<!-- Brand + about -->
	<div class="lg:col-span-4">
		<div class="flex items-center gap-3">
			<span class="grid h-12 w-12 place-items-center rounded-xl bg-gold/15">
				<img src="<?php echo esc_url( NORA_LEARN_URI . '/assets/images/brand-mark.png' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" width="512" height="512" class="h-8 w-8 object-contain" loading="lazy" />
			</span>
			<span class="font-serif text-xl font-bold uppercase tracking-[0.14em] text-ink"><?php bloginfo( 'name' ); ?></span>
		</div>
		<?php if ( $about ) : ?>
			<p class="mt-5 max-w-sm text-sm leading-relaxed text-ink-light"><?php echo wp_kses_post( $about ); ?></p>
		<?php endif; ?>

		<?php if ( $socials ) : ?>
			<div class="mt-6 flex items-center gap-3">
				<?php foreach ( $socials as $network => $url ) : ?>
					<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer"
						class="grid h-10 w-10 place-items-center rounded-full bg-paper-100 text-ink-soft transition hover:bg-gold hover:text-white"
						aria-label="<?php echo esc_attr( ucfirst( $network ) ); ?>">
						<?php echo nora_learn_icon( $network, 'h-5 w-5' ); // phpcs:ignore ?>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>

	<!-- Widget columns -->
	<div class="lg:col-span-5 grid grid-cols-1 gap-10 sm:grid-cols-2">
		<?php
		for ( $i = 1; $i <= 2; $i++ ) {
			if ( is_active_sidebar( 'footer-' . $i ) ) {
				echo '<div class="footer-widgets [&_a]:text-ink-light [&_a:hover]:text-gold-dark [&_ul]:space-y-2.5 [&_li]:text-sm">';
				dynamic_sidebar( 'footer-' . $i );
				echo '</div>';
			} elseif ( 1 === $i ) {
				// Sensible default link list when no widgets configured.
				echo '<div class="[&_a]:text-ink-light [&_a:hover]:text-gold-dark">';
				echo '<h3 class="mb-4 font-serif text-base font-bold text-ink">' . esc_html__( 'ลิงก์ด่วน', 'nora-learn' ) . '</h3>';
				echo '<ul class="space-y-2.5 text-sm">';
				printf( '<li><a href="%s">%s</a></li>', esc_url( nora_learn_courses_url() ), esc_html__( 'คอร์สเรียนทั้งหมด', 'nora-learn' ) );
				printf( '<li><a href="%s">%s</a></li>', esc_url( nora_learn_page_url( 'instructors' ) ), esc_html__( 'ผู้สอน', 'nora-learn' ) );
				printf( '<li><a href="%s">%s</a></li>', esc_url( nora_learn_news_url() ), esc_html__( 'ข่าวสาร', 'nora-learn' ) );
				printf( '<li><a href="%s">%s</a></li>', esc_url( nora_learn_page_url( 'faq' ) ), esc_html__( 'คำถามที่พบบ่อย', 'nora-learn' ) );
				printf( '<li><a href="%s">%s</a></li>', esc_url( nora_learn_page_url( 'about' ) ), esc_html__( 'เกี่ยวกับเรา', 'nora-learn' ) );
				printf( '<li><a href="%s">%s</a></li>', esc_url( nora_learn_page_url( 'contact' ) ), esc_html__( 'ติดต่อเรา', 'nora-learn' ) );
				echo '</ul></div>';
			}
		}
		?>
	</div>

	<!-- Contact -->
	<div class="lg:col-span-3">
		<h3 class="mb-4 font-serif text-base font-bold text-ink"><?php esc_html_e( 'ติดต่อเรา', 'nora-learn' ); ?></h3>
		<ul class="space-y-3 text-sm text-ink-light">
			<?php if ( $address ) : ?>
				<li class="flex gap-2.5"><?php echo nora_learn_icon( 'pin', 'mt-0.5 h-4 w-4 shrink-0 text-gold' ); // phpcs:ignore ?><span><?php echo wp_kses_post( $address ); ?></span></li>
			<?php endif; ?>
			<?php if ( $phone ) : ?>
				<li class="flex gap-2.5"><?php echo nora_learn_icon( 'phone', 'mt-0.5 h-4 w-4 shrink-0 text-gold' ); // phpcs:ignore ?><a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></li>
			<?php endif; ?>
			<?php if ( $email ) : ?>
				<li class="flex gap-2.5"><?php echo nora_learn_icon( 'mail', 'mt-0.5 h-4 w-4 shrink-0 text-gold' ); // phpcs:ignore ?><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></li>
			<?php endif; ?>
		</ul>
	</div>
</div>
