<?php
/**
 * Nora Learn theme bootstrap.
 *
 * Loads the modular includes that configure the theme. Each concern lives in
 * its own file under /inc to keep things small and focused.
 *
 * @package Nora_Learn
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'NORA_LEARN_VERSION' ) ) {
	define( 'NORA_LEARN_VERSION', '1.0.0' );
}
define( 'NORA_LEARN_DIR', get_template_directory() );
define( 'NORA_LEARN_URI', get_template_directory_uri() );

/**
 * Whether Tutor LMS is available.
 *
 * @return bool
 */
function nora_learn_has_tutor_lms() {
	return function_exists( 'tutor_utils' ) || function_exists( 'tutor' ) || class_exists( 'TUTOR\\Tutor' );
}

/**
 * Return Tutor's utility object when available.
 *
 * @return object|null
 */
function nora_learn_tutor_utils() {
	return function_exists( 'tutor_utils' ) ? tutor_utils() : null;
}

/**
 * Check whether the Tutor utility object supports a method.
 *
 * @param string $method Method name.
 * @return bool
 */
function nora_learn_tutor_utils_supports( $method ) {
	$utils = nora_learn_tutor_utils();

	return $utils && is_string( $method ) && method_exists( $utils, $method );
}

/**
 * Resolve the Tutor dashboard URL with a safe fallback.
 *
 * @param string $fallback Fallback URL.
 * @return string
 */
function nora_learn_tutor_dashboard_url( $fallback = '' ) {
	if ( nora_learn_tutor_utils_supports( 'tutor_dashboard_url' ) ) {
		$url = (string) nora_learn_tutor_utils()->tutor_dashboard_url();
		if ( ! empty( $url ) ) {
			return $url;
		}
	}

	return $fallback ? $fallback : home_url( '/' );
}

/**
 * Require an include file from the /inc directory.
 *
 * @param string $relative Path relative to /inc, without extension.
 */
function nora_learn_require( $relative ) {
	require_once NORA_LEARN_DIR . '/inc/' . $relative . '.php';
}

nora_learn_require( 'setup' );          // Theme supports, menus, image sizes.
nora_learn_require( 'enqueue' );        // Styles, scripts, fonts.
nora_learn_require( 'template-tags' );  // Reusable presentation helpers.
nora_learn_require( 'widgets' );        // Sidebar + footer widget areas.
nora_learn_require( 'customizer' );     // Brand / contact / social settings.
nora_learn_require( 'structured-data' ); // JSON-LD (Organization, breadcrumb, article).
nora_learn_require( 'updater' );        // Self-update from GitHub Releases.

// Tutor LMS glue only loads when the plugin is active.
if ( nora_learn_has_tutor_lms() ) {
	nora_learn_require( 'tutor' );
	nora_learn_require( 'tutor-ux' );
	nora_learn_require( 'tutor-gamification' );
	nora_learn_require( 'tutor-social' );
}
