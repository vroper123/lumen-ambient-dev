<?php
/** The \NV\Theme\Customize\ThemeSetup class */

namespace NV\Theme\Customize;

use NV\Theme\Core;

use \NV\Theme\Custom\TopbarMenuWalker;
use \NV\Theme\Custom\CurtainMenuWalker;
/**
 * Contains functions for reconfiguring the admin back-end. Generally, method names should match the hook name for
 * easy identification. In cases where a generic hook is utilized, a more logical method name should be used.
 */
class ThemeSetup {

	/**
	 * Sets up basic theme features.
	 *
	 * Used by action hook: 'after_setup_theme'
	 * 
	 * @see https://developer.wordpress.org/reference/hooks/after_setup_theme/
	 *
	 * @uses self::languages();
	 */
	public static function after_setup_theme() {
		
		// Load available language pack
		load_theme_textdomain( 'lumen-ambient', Core::i()->paths->langs );

		// Let WordPress generate the <title> tag for you
		add_theme_support( 'title-tag' );

		// Let WordPress automatically generate RSS feed urls
		add_theme_support( 'automatic-feed-links' );

		// Enable HTML5 support
		add_theme_support( 'html5', 
			[ 
				'comment-list', 
				'comment-form', 
				'search-form', 
				'gallery', 
				'caption',
			] 
		);

		// Add custom header support
		add_theme_support(
			'custom-header', 
			[
				'width'         		 => 1200,
				'height'                 => 250,
				'flex-height'            => true,
				'flex-width'             => true,
				'default-image'          => Core::i()->urls->img . 'header.gif',
				'random-default'         => false,
				'header-text'            => true,
				'default-text-color'     => '',
				'uploads'                => true,
				'wp-head-callback'       => null,
				'admin-head-callback'    => null,
				'admin-preview-callback' => null,
			]
		);

		// Customize your background
		add_theme_support(
			'custom-background', 
			[
				'default-image'          => '',
				'default-repeat'         => 'repeat',
				'default-position-x'     => 'left',
				'default-attachment'     => 'scroll',
				'default-color'          => '',
				//'wp-head-callback'       => '_custom_background_cb',
				'admin-head-callback'    => '',
				'admin-preview-callback' => '',
			]
		);

		// Enable support for blog post thumbnails
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1568, 9999 );

		// Enable support for post formats
		add_theme_support(
			'post-formats', 
			[
				'aside',
				'audio',
				'chat',
				'gallery',
				'image',
				'link',
				'quote',
				'status',
				'video',
			]
		);

		// Enable support for WooCommerce
		add_theme_support( 'woocommerce' );

		// declare that your theme supports LifterLMS Quizzes
        add_theme_support( 'lifterlms-quizzes' );

		// Register your default navigation
		register_nav_menu( 'primary', __( 'Primary Menu', 'lumen-ambient' ) );
		register_nav_menu( 'footer', __( 'Footer Menu', 'lumen-ambient' ) );
		
		/*
		 * Set up any default values needed for theme options. If a default value is needed, it can be provided as a 
		 * second parameter. This will NOT overwrite any existing options with these names.
		 */
//		add_option( 'nouveau_example_checkbox' );
//		add_option( 'nouveau_example_radio' );
//		add_option( 'nouveau_example_text', 'This is example default text.' );
//		add_option( 'nouveau_example_select' );


	}

	

	/**
	 * Enqueues styles and scripts.
	 *
	 * This is current set up for the majority of use-cases, and you can uncomment additional lines if you want to
	 *
	 * Used by action hook: 'wp_enqueue_scripts'
	 * 
	 * @see https://developer.wordpress.org/reference/hooks/wp_enqueue_scripts/
	 */
	public static function enqueue_assets() {

		/******************
		 * STYLES / CSS
		 ******************/

		// Base stylesheet (compiled Foundation SASS)
		wp_enqueue_style( 'app', Core::i()->urls->css . 'app.css' );

		// WordPress's required styles.css
		wp_enqueue_style( 'styles', get_bloginfo( 'stylesheet_url' ), [ 'app' ] );

		/******************
		 * SCRIPTS / JS
		 ******************/

	
		// Foundation what-input dependency
		wp_enqueue_script( 'what-input', Core::i()->get_js_url( 'what-input/dist/what-input.min.js', 'bower' ), [], false, true );

		// Load the complete version of Foundation
		wp_enqueue_script( 'foundation', Core::i()->get_js_url( 'foundation-sites/dist/js/foundation.min.js', 'bower' ), [ 'jquery', 'what-input' ], false, true );

		// Load any custom javascript (remember to update dependencies if you changed the above)...
		wp_enqueue_script( 'lumen-theme', Core::i()->get_js_url( 'app.min.js' ), [ 'foundation' ], false, true );

		//Add lazy load library 
		wp_enqueue_script( 'intersection-observer-polyfill', 'https://raw.githubusercontent.com/w3c/IntersectionObserver/master/polyfill/intersection-observer.js',  [], null, true );
		wp_enqueue_script( 'lozad', 'https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js', ['intersection-observer-polyfill'], null, true );
		wp_add_inline_script( 'lozad', '
			lozad(".lazyload", { 
				rootMargin: "300px 0px", 
				loaded: function (el) {
					el.classList.add("is-loaded");
				}
			}).observe();
		');
	}
	


	/**
	 * adds lazyload attribute to all image loaded inside the_content()
	 *
	 * @param [type] $content
	 * @return void
	 */

	public static function lazyload_content_images($content)
	{
		//-- Change src/srcset to data attributes.
        
		//$content = preg_replace("/<img(.*?)(src=|srcset=)(.*?)>/i", '<img$1data-$2$3>', $content);
		//-- Add .lazyload class to each image that already has a class.
		$content = preg_replace('/<img(.*?)class=\"(.*?)\"(.*?)>/i', '<img$1class="$2  lazyload"$3>', $content);
		//-- Add .lazyload class to each image that doesn't have a class.
		$content = preg_replace('/<img(.*?)(?!\bclass\b)(.*?)/i', '<img$1 class=" lazyload"$2', $content);
		return $content;
	}


	/**
	 * Enqueues styles and scripts for the admin section
	 *
	 * Used by action hook: 'admin_enqueue_scripts'
	 * 
	 * @see https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/
	 */
	public static function enqueue_admin_assets() {

		// Base admin styles
		wp_enqueue_style( 'nv-admin', Core::i()->urls->css . 'admin.css' );

		// Base admin scripts
		wp_enqueue_script( 'nv-admin', Core::i()->get_js_url( 'admin.min.js' ), [ 'jquery' ], false, false );
	}


	/**
	 * Allows customization of classes output to the <body> element via WordPress' body_class() function.
	 * 
	 * Used by filter hook: 'body_class'
	 * 
	 * @see https://codex.wordpress.org/Plugin_API/Filter_Reference/body_class
	 *
	 * @param array $classes
	 * @return array The proccesses classes array
	 */
	public static function body_class( $classes ) {
		//Do stuff!
		return $classes;
	}


	/**
	 * Registers any sidebars that need to be used with the theme.
	 *
	 * Used by action hook: 'widgets_init'
	 * 
	 * @see https://developer.wordpress.org/reference/hooks/widgets_init/
	 */
	public static function sidebars() {

		register_sidebar(
			[
				'name'          => __( 'Luminous Blog Sidebar', 'lumen-ambient' ),
				'id'            => 'sidebar-1',
				'description'   => __( 'Drag widgets for Blog sidebar here. These widgets will only appear on the blog portion of your site.', 'lumen-ambient' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => "</aside>",
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			]
		);
		register_sidebar(
			[
				'name'          => __( 'lumenous Site Sidebar', 'lumen-ambient' ),
				'id'            => 'sidebar-2',
				'description'   => __( 'Drag widgets for the Site sidebar here. These widgets will only appear on non-blog pages.', 'lumen-ambient' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => "</aside>",
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			]
		);
		register_sidebar(
			[
				'name'          => __( 'Luminous Footer', 'lumen-ambient' ),
				'id'            => 'sidebar-3',
				'description'   => __( 'Drag footer widgets here.', 'lumen-ambient' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => "</aside>",
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			]
		);

		register_sidebar(
			[
				'name'          => __( 'Header Widget', 'lumen-ambient' ),
				'id'            => 'header-widget-1',
				'description'   => __( 'Drag widgets for Blog sidebar here. These widgets will only appear on the blog portion of your site.', 'lumen-ambient' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => "</aside>",
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			]
		);
	
		 // First footer widget area, located in the footer. Empty by default.
		 register_sidebar( array(
			'name' => __( 'Luminous First Footer Widget Area', 'lumen-ambient' ),
			'id' => 'first-footer-widget-area',
			'description' => __( 'The first footer widget area', 'lumen-ambient' ),
			'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	 
		// Second Footer Widget Area, located in the footer. Empty by default.
		register_sidebar( array(
			'name' => __( 'Luminous Second Footer Widget Area', 'lumen-ambient' ),
			'id' => 'second-footer-widget-area',
			'description' => __( 'The second footer widget area', 'lumen-ambient' ),
			'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	 
		// Third Footer Widget Area, located in the footer. Empty by default.
		register_sidebar( array(
			'name' => __( 'Luminous Third Footer Widget Area', 'lumen-ambient' ),
			'id' => 'third-footer-widget-area',
			'description' => __( 'The third footer widget area', 'lumen-ambient' ),
			'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	 
		// Fourth Footer Widget Area, located in the footer. Empty by default.
		register_sidebar( array(
			'name' => __( 'Luminous Fourth Footer Widget Area', 'lumen-ambient' ),
			'id' => 'fourth-footer-widget-area',
			'description' => __( 'The fourth footer widget area', 'lumen-ambient' ),
			'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	}


	/**
	 * 
	 *Renames WordPress' default .sticky class to .status-sticky to prevent conflicts with css
	 * 
	 * 
	 * Used by action hook: post_class
	 * 
	 * @see https://developer.wordpress.org/reference/hooks/post_class/
	 * 
	 * @param array $classes An array of classes for each post
	 *
	 * @return array
	 */
	public static function sticky_post_class( $classes ) {
		if( in_array( 'sticky', $classes ) ) {
			$classes = array_diff( $classes, [ 'sticky' ] );
			$classes[] = 'status-sticky';
		}
		return $classes;
	}
	 
	
	 // The Top Menu
	public static function lu_top_nav() {
		/*wp_nav_menu(array(
			'container'			=> false,						// Remove nav container
			'menu_id'			=> 'main-nav',					// Adding custom nav id
			'menu_class'		=> 'medium-horizontal menu',	// Adding custom nav class
			'items_wrap'		=> '<ul id="%1$s" class="%2$s" data-responsive-menu="accordion medium-dropdown">%3$s</ul>',
			'theme_location'	=> 'primary',					// Where it's located in the theme
			'depth'				=> 5,							// Limit the depth of the nav
			'fallback_cb'		=> false,						// Fallback function (see below)
			'walker'			=> new TopbarMenuWalker
		));*/

		wp_nav_menu( array(
			'theme_location'  => 'primary',
			'container'       => false,
			'menu_class'      => 'menu vertical large-horizontal',
			'items_wrap'      => '<ul class="%2$s" data-responsive-menu="accordion large-dropdown">%3$s</ul>',
			'depth'           => 0,
			'fallback_cb'		=> false,	
			'walker' =>  new TopbarMenuWalker
			)
		);
}

 // The Top Menu
 public static function lu_top_center() {
	wp_nav_menu(array(
		'container'			=> false,						// Remove nav container
		'menu_id'			=> 'main-nav',					// Adding custom nav id
		'menu_class'		=> 'medium-horizontal menu align-center',	// Adding custom nav class
		'items_wrap'		=> '<ul id="%1$s" class="%2$s" data-responsive-menu="accordion medium-dropdown">%3$s</ul>',
		'theme_location'	=> 'primary',					// Where it's located in the theme
		'depth'				=> 5,							// Limit the depth of the nav
		'fallback_cb'		=> false,						// Fallback function (see below)
		'walker'			=> new TopbarMenuWalker
	));
 }

//Curtain Nav
public static function lu_curtian_nav(){
	wp_nav_menu( array(
		'theme_location'  => 'primary',
		'container'       => false,
		'menu_class'      => 'curtain-menu-wrapper',
		'depth'           => 0,
		'items_wrap'      => '<ul class="curtain-menu-list menu vertical" data-responsive-menu="accordion large-dropdown">%3$s</ul>',
		'fallback_cb'		=> false,	
		'walker' =>  new CurtainMenuWalker
		)
	);
}

//overlay Nav
public static function lu_overlay_nav(){
	wp_nav_menu( array(
		'theme_location'  => 'primary',
		'container'       => false,
		'menu_class'      => 'overlay-menu-wrapper',
		'depth'           => 0,
		)
	);
}

}