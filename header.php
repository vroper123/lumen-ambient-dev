<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="<?php echo bloginfo('description');?>" />
  <meta name=”keywords” content="<?php echo bloginfo( 'name' )?>" />
	<!--wp_head-->
  <?php wp_head(); //Enqueue your own stuff in functions.php or \NV\Hooks\Config::enqueue_assets()
  use \NV\Theme\Utilities\Theme;
  echo lumen_options('lumen_code');
 ?>
	<!--/wp_head-->
</head>
<body <?php body_class() ?> itemscope itemtype="http://schema.org/WebPage">
<?php  lumen_options('lumen_code2'); ?>
<div id="frame">
<?php //Theme::get_part('topnotices');?>
<header  itemscope itemtype="http://schema.org/WPHeader">
 <?php if ( get_theme_mod( 'lumen_headers', 'top-barnav' ) ):
    Theme::get_part(get_theme_mod( 'lumen_headers', 'top-barnav' )); 
 else:
     Theme::get_part(lumen_options('lumen_headers'));
 endif; 
    ?>
</header>
