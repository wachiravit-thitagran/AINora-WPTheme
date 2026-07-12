<?php
/**
 * Theme Customizer settings: brand, hero, contact, social, footer.
 *
 * @package Nora_Learn
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register Customizer panels, sections, settings and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function nora_learn_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	// --- Panel -----------------------------------------------------------
	$wp_customize->add_panel(
		'nora_learn_panel',
		array(
			'title'    => __( 'ตั้งค่า Nora Learn', 'nora-learn' ),
			'priority' => 30,
		)
	);

	/**
	 * Helper to add a text-ish setting + control.
	 */
	$add_text = function ( $id, $label, $section, $type = 'text', $default = '' ) use ( $wp_customize ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $default,
				'sanitize_callback' => 'email' === $type ? 'sanitize_email' : ( 'url' === $type ? 'esc_url_raw' : 'wp_kses_post' ),
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'   => $label,
				'section' => $section,
				'type'    => 'textarea' === $type ? 'textarea' : ( 'url' === $type ? 'url' : ( 'email' === $type ? 'email' : 'text' ) ),
			)
		);
	};

	/**
	 * Helper to add a boolean (checkbox) setting + control.
	 */
	$add_toggle = function ( $id, $label, $section, $default = true ) use ( $wp_customize ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $default,
				'sanitize_callback' => 'wp_validate_boolean',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'   => $label,
				'section' => $section,
				'type'    => 'checkbox',
			)
		);
	};

	// --- Hero ------------------------------------------------------------
	$wp_customize->add_section(
		'nora_hero',
		array(
			'title' => __( 'ส่วนหัวหน้าแรก (Hero)', 'nora-learn' ),
			'panel' => 'nora_learn_panel',
		)
	);
	$add_text( 'nora_hero_eyebrow', __( 'ข้อความนำ', 'nora-learn' ), 'nora_hero', 'text', __( 'มรดกวัฒนธรรมมโนราห์', 'nora-learn' ) );
	$add_text( 'nora_hero_title', __( 'พาดหัว', 'nora-learn' ), 'nora_hero', 'textarea', __( 'เรียนรู้ มรดกมโนราห์<br>ในยุค ดิจิทัล', 'nora-learn' ) );
	$add_text( 'nora_hero_subtitle', __( 'คำอธิบายใต้พาดหัว', 'nora-learn' ), 'nora_hero', 'textarea', __( 'คอร์สเรียนออนไลน์ บทเรียน และคลังความรู้ เพื่อการเรียนรู้ตลอดชีวิตอย่างเป็นอิสระ', 'nora-learn' ) );
	$add_text( 'nora_hero_cta_text', __( 'ปุ่มหลัก — ข้อความ', 'nora-learn' ), 'nora_hero', 'text', __( 'เริ่มเรียนรู้', 'nora-learn' ) );
	$add_text( 'nora_hero_cta_url', __( 'ปุ่มหลัก — ลิงก์', 'nora-learn' ), 'nora_hero', 'url', '' );

	$wp_customize->add_setting( 'nora_hero_image', array( 'sanitize_callback' => 'absint' ) );
	$wp_customize->add_control(
		new WP_Customize_Cropped_Image_Control(
			$wp_customize,
			'nora_hero_image',
			array(
				'label'       => __( 'ภาพประกอบ Hero', 'nora-learn' ),
				'section'     => 'nora_hero',
				'flex_width'  => true,
				'flex_height' => true,
				'width'       => 1200,
				'height'      => 1200,
			)
		)
	);

	// --- Homepage sections (show/hide) -----------------------------------
	$wp_customize->add_section(
		'nora_home_sections',
		array(
			'title'       => __( 'เนื้อหาหน้าแรก', 'nora-learn' ),
			'description' => __( 'เปิด/ปิดแต่ละส่วนของหน้าแรก เพื่อให้หน้ากระชับตามต้องการ (Hero และคอร์สแนะนำแสดงเสมอ)', 'nora-learn' ),
			'panel'       => 'nora_learn_panel',
		)
	);
	$add_toggle( 'nora_show_stats', __( 'แสดงแถบสถิติ', 'nora-learn' ), 'nora_home_sections', true );
	$add_toggle( 'nora_show_how_it_works', __( 'แสดง "เริ่มเรียนใน 3 ขั้นตอน"', 'nora-learn' ), 'nora_home_sections', true );
	$add_toggle( 'nora_show_instructors', __( 'แสดงผู้สอน', 'nora-learn' ), 'nora_home_sections', true );
	$add_toggle( 'nora_show_news', __( 'แสดงข่าวสารล่าสุด', 'nora-learn' ), 'nora_home_sections', true );
	$add_toggle( 'nora_show_partners', __( 'แสดงพันธมิตร/คำคม', 'nora-learn' ), 'nora_home_sections', true );

	// --- Auth page -------------------------------------------------------
	// A plugin-provided login/registration shortcode, stored in the database as
	// a theme mod so it survives theme updates (e.g. from GitHub Releases) and
	// never needs the parent theme's files to be edited. Rendered by the
	// "เข้าสู่ระบบ / สมัครเรียน (Auth)" page template.
	$wp_customize->add_section(
		'nora_auth',
		array(
			'title'       => __( 'หน้าเข้าสู่ระบบ (Auth)', 'nora-learn' ),
			'description' => __( 'ใส่ shortcode จากปลั๊กอินเพื่อใช้เป็นฟอร์มเข้าสู่ระบบ/สมัครเรียน ในหน้าที่เลือกเทมเพลต “เข้าสู่ระบบ / สมัครเรียน (Auth)”. เว้นว่างไว้เพื่อใช้ฟอร์มในตัวของธีม', 'nora-learn' ),
			'panel'       => 'nora_learn_panel',
		)
	);
	$wp_customize->add_setting(
		'nora_learn_auth_shortcode',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'nora_learn_auth_shortcode',
		array(
			'label'       => __( 'Auth shortcode', 'nora-learn' ),
			'description' => __( 'ใส่ shortcode จากปลั๊กอิน เช่น [plugin_login]', 'nora-learn' ),
			'section'     => 'nora_auth',
			'type'        => 'text',
		)
	);

	// --- Contact ---------------------------------------------------------
	$wp_customize->add_section(
		'nora_contact',
		array(
			'title' => __( 'ข้อมูลติดต่อ', 'nora-learn' ),
			'panel' => 'nora_learn_panel',
		)
	);
	$add_text( 'nora_contact_address', __( 'ที่อยู่', 'nora-learn' ), 'nora_contact', 'textarea', __( 'สำนักนวัตกรรมดิจิทัลและระบบอัจฉริยะ มหาวิทยาลัยสงขลานครินทร์ 15 ถ.กาญจนวณิชย์ ต.หาดใหญ่ อ.หาดใหญ่ จ.สงขลา 90110', 'nora-learn' ) );
	$add_text( 'nora_contact_phone', __( 'โทรศัพท์', 'nora-learn' ), 'nora_contact', 'text', '074-28-2105' );
	$add_text( 'nora_contact_email', __( 'อีเมล', 'nora-learn' ), 'nora_contact', 'email', 'patsadu_diis@psu.ac.th' );
	$add_text( 'nora_contact_map', __( 'ลิงก์ Google Maps (embed src)', 'nora-learn' ), 'nora_contact', 'url', '' );

	// --- Social ----------------------------------------------------------
	$wp_customize->add_section(
		'nora_social',
		array(
			'title' => __( 'โซเชียลมีเดีย', 'nora-learn' ),
			'panel' => 'nora_learn_panel',
		)
	);
	$add_text( 'nora_social_facebook', 'Facebook URL', 'nora_social', 'url', '' );
	$add_text( 'nora_social_youtube', 'YouTube URL', 'nora_social', 'url', '' );
	$add_text( 'nora_social_line', 'LINE URL', 'nora_social', 'url', '' );

	// --- Footer ----------------------------------------------------------
	$wp_customize->add_section(
		'nora_footer',
		array(
			'title' => __( 'ส่วนท้าย (Footer)', 'nora-learn' ),
			'panel' => 'nora_learn_panel',
		)
	);
	$add_text( 'nora_footer_about', __( 'ข้อความแนะนำองค์กร', 'nora-learn' ), 'nora_footer', 'textarea', __( 'โครงการอนุรักษ์มรดกทางวัฒนธรรมและภูมิปัญญาไทย ผ่านนวัตกรรมดิจิทัลเพื่อการเรียนรู้ที่ยั่งยืน', 'nora-learn' ) );
	$add_text( 'nora_footer_copyright', __( 'ข้อความลิขสิทธิ์', 'nora-learn' ), 'nora_footer', 'text', '' );
	$add_text( 'nora_cta_title', __( 'แถบ CTA ก่อน footer — หัวข้อ', 'nora-learn' ), 'nora_footer', 'textarea', __( 'พร้อมเริ่มต้นการเรียนรู้แล้วหรือยัง?', 'nora-learn' ) );
	$add_text( 'nora_cta_button', __( 'แถบ CTA — ปุ่ม', 'nora-learn' ), 'nora_footer', 'text', __( 'สมัครเรียนฟรี', 'nora-learn' ) );
	$add_text( 'nora_cta_url', __( 'แถบ CTA — ลิงก์', 'nora-learn' ), 'nora_footer', 'url', '' );
}
add_action( 'customize_register', 'nora_learn_customize_register' );

/**
 * Live-preview JS for blogname / blogdescription.
 */
function nora_learn_customize_preview_js() {
	wp_enqueue_script(
		'nora-learn-customizer',
		NORA_LEARN_URI . '/assets/js/customizer.js',
		array( 'customize-preview' ),
		NORA_LEARN_VERSION,
		true
	);
}
add_action( 'customize_preview_init', 'nora_learn_customize_preview_js' );
