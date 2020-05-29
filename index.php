<?php

/**
* DEFAULT TEMPLATE
 *
 * This is the global default template. If WordPress can't find a more appropriate, specific template file,
 * it will use this one.
 * @package Lumen-Ambient
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use \NV\Theme\Utilities\Theme;

get_header();
Theme::output_file_marker( __FILE__ );
 ?>
	<div id="container" class="row">
		<div id="content" class="small-12 large-8 columns 111"  >
			<?php //Theme::archive_nav( array( 'id' => 'nav-top' ) ) " ?>
			
			<?php wp_link_pages(); ?>

			<?php Theme::loop( 'parts/article', 'parts/article-empty' ) ?>
			
			<?php paginate_links(); ?>

			<?php get_template_part( 'parts/archive-nav' ) ?>
		</div>

		<div id="sidebar" class="small-12 large-4 columns" itemscope itemtype="https://schema.org/WPSideBar">
			<?php dynamic_sidebar( 'sidebar-1' ) ?>
		</div>

	</div>
<?php
get_footer();