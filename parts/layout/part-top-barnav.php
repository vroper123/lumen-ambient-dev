<?php  use \NV\Theme\Customize\ThemeSetup;
$imageSrc = lumen_options('lumen_logo'); // For the default value
?>
<nav class="top-bar topbar-responsive" itemscope itemtype="http://schema.org/SiteNavigationElement">
  <div class="top-bar-left ">
    <a class="topbar-responsive-logo" href="<?php echo esc_url(home_url()); ?>"><img src='<?php echo esc_url($imageSrc); ?>'/></a>
    <span data-responsive-toggle="topbar-responsive" data-hide-for="large">
       <div class="hamburger hamburger--3dx" data-toggle>
    <div class="hamburger-box">
      <div class="hamburger-inner"></div>
    </div>
  </div>
    </span>
  </div>
  <div id="topbar-responsive" class="topbar-responsive-links">
    <div class="top-bar-right">
    <?php ThemeSetup::lu_top_nav(); ?>
    </div>
  </div>
</nav>