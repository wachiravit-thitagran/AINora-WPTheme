<?php
/**
 * Enqueue compiled styles, scripts and webfonts.
 *
 * @package Nora_Learn
 */

defined( 'ABSPATH' ) || exit;

/**
 * Cache-busting version: file mtime in dev, theme version in production.
 *
 * @param string $relative Path relative to the theme root.
 * @return string
 */
function nora_learn_asset_version( $relative ) {
	$path = NORA_LEARN_DIR . '/' . ltrim( $relative, '/' );
	return file_exists( $path ) ? (string) filemtime( $path ) : NORA_LEARN_VERSION;
}

/**
 * Front-end assets.
 */
function nora_learn_enqueue_assets() {
	// Compiled Tailwind stylesheet. Self-hosted webfonts (Noto Sans Thai — the
	// ainora.psu.ac.th display/UI face — plus Sarabun fallback) are declared with
	// @font-face inside this file; see src/css/main.css. No external font CDN
	// is used, keeping first paint fast and avoiding cross-origin requests
	// (PDPA-friendly for a .ac.th site).
	wp_enqueue_style(
		'nora-learn-style',
		NORA_LEARN_URI . '/assets/css/main.css',
		array(),
		nora_learn_asset_version( 'assets/css/main.css' )
	);

	// Bundled Alpine.js + interactions.
	wp_enqueue_script(
		'nora-learn-main',
		NORA_LEARN_URI . '/assets/js/main.js',
		array(),
		nora_learn_asset_version( 'assets/js/main.js' ),
		true
	);

	// Tutor LMS UX Enhancements (Phase 3: Celebration)
	if ( function_exists( 'tutor_utils' ) && is_singular( 'tutor_quiz' ) || is_singular( 'tutor_enrolled' ) || is_singular( 'courses' ) || is_singular( 'lesson' ) ) {
		wp_enqueue_script( 'canvas-confetti', 'https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js', array(), '1.9.2', true );
		wp_enqueue_script( 'nora-learn-celebration', NORA_LEARN_URI . '/assets/js/tutor-celebration.js', array( 'canvas-confetti' ), nora_learn_asset_version( 'assets/js/tutor-celebration.js' ), true );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'nora_learn_enqueue_assets' );

/**
 * Preload the primary Thai webfonts (body + display) to reduce layout shift /
 * flash of unstyled text. Other weights/subsets load on demand via @font-face.
 *
 * @param array $preload_resources Existing preload entries.
 * @return array
 */
function nora_learn_preload_fonts( $preload_resources ) {
	// Primary display/body face (Noto Sans Thai) + body fallback (Sarabun), Thai subset.
	foreach ( array( 'notosansthai-400-thai', 'notosansthai-700-thai', 'sarabun-400-thai' ) as $slug ) {
		$preload_resources[] = array(
			'href'        => NORA_LEARN_URI . '/assets/fonts/' . $slug . '.woff2',
			'as'          => 'font',
			'type'        => 'font/woff2',
			'crossorigin' => 'anonymous',
		);
	}
	return $preload_resources;
}
add_filter( 'wp_preload_resources', 'nora_learn_preload_fonts' );

/**
 * Mark the bundled script as a module (Alpine ships as ESM via esbuild IIFE).
 * We keep it classic by default; filter retained for future use.
 */

/**
 * Default favicon / touch icon (brand mark on a gold tile).
 *
 * Only emitted when the site owner has NOT set a Site Icon in the Customizer,
 * so an explicit Site Icon always wins.
 */
function nora_learn_default_site_icon() {
	if ( function_exists( 'has_site_icon' ) && has_site_icon() ) {
		return;
	}
	$base = NORA_LEARN_URI . '/assets/images/';
	printf( '<link rel="icon" type="image/png" sizes="32x32" href="%s">' . "\n", esc_url( $base . 'favicon-32.png' ) );
	printf( '<link rel="icon" type="image/png" sizes="192x192" href="%s">' . "\n", esc_url( $base . 'favicon-192.png' ) );
	printf( '<link rel="apple-touch-icon" sizes="180x180" href="%s">' . "\n", esc_url( $base . 'favicon-180.png' ) );
}
add_action( 'wp_head', 'nora_learn_default_site_icon' );

/**
 * Editor styles so the block editor roughly matches the front end.
 */
function nora_learn_editor_assets() {
	add_editor_style( 'assets/css/main.css' );
}
add_action( 'after_setup_theme', 'nora_learn_editor_assets' );
