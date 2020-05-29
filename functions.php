<?php
/**
 * Required: include OptionTree.
 */

require( trailingslashit( get_template_directory() ) . 'theme-options/options.php' );


/*-----------------------------------------------------------------------------------*/
/*	Excerpt
/*-----------------------------------------------------------------------------------*/
// Increase max length
function lumen_excerpt() {
	if( is_page('join') && is_user_logged_in() == true){
		echo "I AM IN THE IF";
	}
}
add_filter( 'wp_footer', 'lumen_excerpt');


// Increase max length
function lumen_excerpt_length( $length ) {
	return 100;
}
add_filter( 'excerpt_length', 'lumen_excerpt_length', 20 );

// Remove [...] and shortcodes
function lumen_custom_excerpt( $output ) {
  return preg_replace( '/\[[^\]]*]/', '', $output );
}
add_filter( 'get_the_excerpt', 'lumen_custom_excerpt' );


// Load and initialize NV library... that's it!
require 'NV/Core.php';

