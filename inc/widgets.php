<?php
/**
 * Widget areas: blog sidebar + four footer columns.
 *
 * @package Nora_Learn
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register sidebars.
 */
function nora_learn_widgets_init() {
	$widget_wrap = array(
		'before_widget' => '<section id="%1$s" class="widget %2$s mb-8 last:mb-0">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="mb-4 font-serif text-lg font-bold text-ink after:mt-2 after:block after:h-0.5 after:w-10 after:bg-gold">',
		'after_title'   => '</h3>',
	);

	register_sidebar(
		array_merge(
			array(
				'name'        => __( 'แถบข้าง (Blog Sidebar)', 'nora-learn' ),
				'id'          => 'sidebar-1',
				'description' => __( 'แสดงในหน้าบทความ/ข่าว', 'nora-learn' ),
			),
			$widget_wrap
		)
	);

	$footer_wrap = array(
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="mb-4 font-serif text-base font-bold text-white/90">',
		'after_title'   => '</h3>',
	);

	for ( $i = 1; $i <= 3; $i++ ) {
		register_sidebar(
			array_merge(
				array(
					/* translators: %d: footer column number */
					'name'        => sprintf( __( 'ส่วนท้าย คอลัมน์ %d', 'nora-learn' ), $i ),
					'id'          => 'footer-' . $i,
					'description' => __( 'วิดเจ็ตในส่วนท้ายเว็บไซต์', 'nora-learn' ),
				),
				$footer_wrap
			)
		);
	}
}
add_action( 'widgets_init', 'nora_learn_widgets_init' );
