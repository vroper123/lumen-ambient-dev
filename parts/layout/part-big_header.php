<?php  use \NV\Theme\Customize\ThemeSetup;
$imageSrc = lumen_options('lumen_logo'); // For the default value
?>
<div class="top-header">
  <div class="lu-site-title">
  <a class="topbar-responsive-logo" href="<?php echo esc_url(home_url()); ?>"><img src='<?php echo esc_url($imageSrc); ?>'/></a>

</div>
 <div class="lu-widget-area">
 <?php if (    is_active_sidebar( 'header-widget-1' ) ):?>	
				<div class=" widget-area">
					<?php dynamic_sidebar( 'header-widget-1' ); ?>
				</div><!-- .fourth .widget-area -->
			<?php endif; ?>
</div>
</div>

<nav class="top-bar " itemscope itemtype="http://schema.org/SiteNavigationElement">
  
    <span data-responsive-toggle="topbar-responsive" data-hide-for="medium">
       <div class="hamburger hamburger--3dx" data-toggle>
    <div class="hamburger-box">
      <div class="hamburger-inner"></div>
    </div>
  </div>
    </span>
    
 
    
  <div id="topbar-responsive" class="topbar-responsive-links">
   
    <?php ThemeSetup::lu_top_center(); ?>
    
  </div>
</nav>

