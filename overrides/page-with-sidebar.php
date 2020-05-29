<?php
/**
 * Template Name:Page With Sidebar
 * 
 * This is an example override template. This can be selected from WordPress's "Edit Page" screens.
 */
use NV\Theme\Utilities\Theme;


Theme::get_header();
Theme::output_file_marker( __FILE__ );
 ?>
	<div id="container" class="row">
		<div id="content" class="small-12 large-8 columns 111"  >
		
			<?php echo lumen_options('code_3');?>
			

			<?php Theme::loop( 'parts/article-page', 'parts/article-empty' ) ?>
			
			<?php wp_link_pages(); ?>
		</div>
        <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>

		<div id="sidebar" class="small-12 large-4 columns" itemscope itemtype="https://schema.org/WPSideBar">
			<?php dynamic_sidebar( 'sidebar-1' ) ?>
		</div>
        <?php endif;?>
	</div>
<?php
Theme::get_footer();