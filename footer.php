	<footer id="footer"  itemscope itemtype="http://schema.org/WPFooter">
	<div class="lu-footer row">	
	<?php if (    is_active_sidebar( 'first-footer-widget-area' ) ):?>
				<div class="columns  widget-area">
					<?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
				</div><!-- .first .widget-area -->
			<?php endif; ?>

			<?php if (    is_active_sidebar( 'second-footer-widget-area' ) ):?>	
				<div class="columns widget-area">
					<?php dynamic_sidebar( 'second-footer-widget-area' ); ?>
				</div><!-- .second .widget-area -->
			<?php endif; ?>

			<?php if (    is_active_sidebar( 'third-footer-widget-area')  ):?>	
				<div class="columns widget-area">
					<?php dynamic_sidebar( 'third-footer-widget-area' ); ?>
				</div><!-- .third .widget-area -->
			<?php endif; ?>
		   
			<?php if (    is_active_sidebar( 'fourth-footer-widget-area' ) ):?>	
				<div class="columns widget-area">
					<?php dynamic_sidebar( 'fourth-footer-widget-area' ); ?>
				</div><!-- .fourth .widget-area -->
			<?php endif; ?>
</div>		
		<div class="lu-copyright row">
			<?php
			echo lumen_options('lumen_copyright');
			?>
		</div>
	
	</footer>


</div>
<!-- /#frame -->
<?php echo lumen_options('lumen_code3'); ?>

	<!-- start wp_footer() hooks -->
	<?php wp_footer(); ?>
	<!-- end wp_footer() hooks -->
</body>
</html>