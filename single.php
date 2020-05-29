<?php
/**
 * SINGLE BLOG POSTS
 *
 * This is the template for single, full-page blog posts.
* @package Lumen Ambient
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use \NV\Theme\Utilities\Theme;

get_header();
Theme::output_file_marker( __FILE__ );
the_post();
?>
	<div id="container" class="row">
		<div id="content" class="small-12 large-8 columns ">
			<?php get_template_part( 'parts/article-with-comments' ) ?>
		</div>
		

		 <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>

		<div id="sidebar" class="small-12 large-4 columns" itemscope itemtype="https://schema.org/WPSideBar">
			<?php dynamic_sidebar( 'sidebar-1' ) ?>
		</div>
        <?php endif;?>
	</div>
<?php
get_footer();