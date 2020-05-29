<?php
/**
 * Template Name:Fullwidth Page
 * 
 * This is an example override template. This can be selected from WordPress's "Edit Page" screens.
 */
use NV\Theme\Utilities\Theme;


get_header();
Theme::output_file_marker( __FILE__ );
 ?>
	<div id="container" class="row expanded">
		<div id="content" class="lu-full"  >
		
			<?php echo lumen_options('code_3');?>
			

			<?php Theme::loop( 'parts/article-page', 'parts/article-empty' ) ?>
			
			<?php wp_link_pages(); ?>
		</div>
	</div>
<?php
get_footer();