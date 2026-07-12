<?php
/**
 * Template Name: เกี่ยวกับเรา (About)
 *
 * @package Nora_Learn
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	nora_learn_page_hero(
		array(
			'eyebrow'  => __( 'รู้จักเรา', 'nora-learn' ),
			'title'    => get_the_title(),
			'subtitle' => has_excerpt() ? get_the_excerpt() : __( 'โครงการอนุรักษ์มรดกทางวัฒนธรรมและภูมิปัญญาไทย ผ่านนวัตกรรมดิจิทัลเพื่อการเรียนรู้ที่ยั่งยืน', 'nora-learn' ),
		)
	);
	?>

	<!-- Intro + page content -->
	<section class="section-tight">
		<div class="container-nora grid items-center gap-12 lg:grid-cols-2">
			<div class="prose-nora">
				<?php
				$nora_content = get_the_content();
				$nora_is_elementor = isset( $_GET['elementor-preview'] ) || ( class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->preview->is_preview_mode() );
				if ( trim( $nora_content ) || $nora_is_elementor ) {
					the_content();
				} else {
					echo '<h2>' . esc_html__( 'ปณิธานของเรา', 'nora-learn' ) . '</h2>';
					echo '<p>' . esc_html__( 'AINORA มุ่งมั่นจัดเก็บ ดูแล และเผยแพร่มรดกทางวัฒนธรรมมโนราห์ งานวิจัย และเอกสารโบราณอันทรงคุณค่า ให้เข้าถึงได้สำหรับทุกคน ผ่านการเรียนรู้ในรูปแบบดิจิทัลที่เปิดกว้างและเป็นอิสระ', 'nora-learn' ) . '</p>';
					echo '<p>' . esc_html__( 'แพลตฟอร์ม Nora Learn รวบรวมคอร์สเรียน บทเรียน และคลังความรู้ เพื่อสนับสนุนการเรียนรู้ตลอดชีวิต ทั้งด้านธรรมะ การภาวนา ศิลปะ และวัฒนธรรม', 'nora-learn' ) . '</p>';
				}
				?>
			</div>
			<div class="relative">
				<?php if ( has_post_thumbnail() ) : ?>
					<figure class="overflow-hidden rounded-3xl shadow-card"><?php the_post_thumbnail( 'nora-hero', array( 'class' => 'w-full object-cover' ) ); ?></figure>
				<?php else : ?>
					<div class="grid aspect-[4/3] place-items-center rounded-3xl bg-gold-wash text-paper-50/40 shadow-card">
						<?php echo nora_learn_icon( 'lotus', 'h-32 w-32' ); // phpcs:ignore ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<!-- Values -->
	<section class="section bg-paper-100/60 bg-grain">
		<div class="container-nora">
			<?php
			nora_learn_section_heading(
				array(
					'eyebrow' => __( 'คุณค่าที่เรายึดถือ', 'nora-learn' ),
					'title'   => __( 'เรียนรู้ด้วยใจที่เป็นอิสระ', 'nora-learn' ),
				)
			);
			$values = array(
				array( 'lotus', __( 'เปิดกว้างและเป็นอิสระ', 'nora-learn' ), __( 'องค์ความรู้พร้อมให้ทุกคนเข้าถึงได้โดยไม่มีกำแพง', 'nora-learn' ) ),
				array( 'book', __( 'เรียนรู้ตลอดชีวิต', 'nora-learn' ), __( 'สนับสนุนการเรียนรู้ในทุกช่วงวัยและทุกจังหวะชีวิต', 'nora-learn' ) ),
				array( 'users', __( 'ชุมชนแห่งปัญญา', 'nora-learn' ), __( 'เติบโตไปด้วยกันกับผู้สอนและผู้เรียนที่ใฝ่รู้', 'nora-learn' ) ),
			);
			?>
			<div class="mt-12 grid gap-8 md:grid-cols-3">
				<?php foreach ( $values as $v ) : ?>
					<div class="card p-8 text-center">
						<span class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-gold-50 text-gold"><?php echo nora_learn_icon( $v[0], 'h-7 w-7' ); // phpcs:ignore ?></span>
						<h3 class="mt-5 font-serif text-xl font-bold text-ink"><?php echo esc_html( $v[1] ); ?></h3>
						<p class="mt-2 text-sm leading-relaxed text-ink-light"><?php echo esc_html( $v[2] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<?php
endwhile;

get_footer();
