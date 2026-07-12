/**
 * Customizer live-preview: blog name + description.
 */
( function ( $ ) {
	wp.customize( 'blogname', function ( value ) {
		value.bind( function ( to ) {
			$( '.nora-site-title' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function ( value ) {
		value.bind( function ( to ) {
			$( '.nora-site-description' ).text( to );
		} );
	} );
} )( jQuery );
