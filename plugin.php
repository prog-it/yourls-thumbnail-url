<?php
/*
Plugin Name: Thumbnail URL image
Plugin URI: https://github.com/prog-it/yourls-thumbnail-url
Description: Add .i to shorturls to display Thumbnail URL image
Version: 1.1
Author: progit
Author URI: https://github.com/prog-it
*/

// EDIT THIS

// Thumbnail Image service URL with params
// Choose one. Uncomment if need

define( 'PROGIT_THUMB_URL', 'https://api.site-shot.com/?width=1024&height=768&scaled_width=800&format=jpeg&url=' );
//define( 'PROGIT_THUMB_URL', 'https://api.webthumbnail.org/?width=800&height=600&screen=1024&url=' );

// Kick in if the loader does not recognize a valid pattern
yourls_add_action( 'loader_failed', 'progit_yourls_thumbnail' );

function progit_yourls_thumbnail( $request ) {
	// Get authorized charset in keywords and make a regexp pattern
	$pattern = yourls_make_regexp_pattern( yourls_get_shorturl_charset() );
	
	// Shorturl is like bleh.i ?
	if( preg_match( "@^([$pattern]+)\.i?/?$@", $request[0], $matches ) ) {
		// this shorturl exists ?
		$keyword = yourls_sanitize_keyword( $matches[1] );
		if( yourls_is_shorturl( $keyword ) ) {
			$url = yourls_get_keyword_longurl( $keyword );					
			// Show the Thubmnail long URL then!
			header('Location: '.PROGIT_THUMB_URL . $url);
			exit;
		}
	}
}