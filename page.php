<?php

/**
 * The template for displaying the default page.
 *
 * @package Lumen Ambient
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use \NV\Theme\Utilities\Theme;


get_header();
Theme::output_file_marker( __FILE__ );
 ?>
	<div id="container" class="row">
		<div id="content" class=" large-12 columns "  >
			

			<?php Theme::loop( 'parts/article-page', 'parts/article-empty' ) ?>
			
			<?php wp_link_pages(); ?>
		</div>
        
	</div>
<?php
get_footer();