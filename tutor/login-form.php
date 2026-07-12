<?php
/**
 * Override Tutor LMS Login Form to force SSO
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="tutor-login-form-wrap text-center py-8">
	<div class="nora-auth-social">
		<?php
		$nora_current_url = function_exists( 'tutor_utils' ) ? tutor_utils()->get_current_url() : '';
		$nora_providers   = array( 'google', 'facebook', 'line', 'oidc', 'oauth2' );
		foreach ( $nora_providers as $nora_provider ) {
			echo do_shortcode( sprintf( '[authorizenter_button context="default" provider="%s" return_to="%s"]', esc_attr( $nora_provider ), esc_url( $nora_current_url ) ) );
		}
		?>
	</div>
</div>
