<?php

namespace NV\Theme\Custom;

use NV\Theme\Core;

class LifterLMS {

/**
 * Define your theme's custom options so users can select them on the Quiz Builder
 * Yes, this is a metabox-like API
 * Yes, we're recreating the wheel a bit here
 * @param  array  $settings  an array of theme setting defaults
 * @return array
 */
public static function lumen_ambient_llms_quiz_settings( $settings ) {

	
	// add layout options
	$settings['layout'] = array(
		
		// id is the wp_postmeta key name where your theme's layout setting value should be stored
		'id' => 'lumen_ambient_layout_post_meta_key',
		
		// Allows meta keys that start with an underscore to be tracked by the Course Builder
		// if your layout meta key is "_my_theme_layout_post_meta_key" you should use this field
		// in combination with the "id" above. In the "id" above remove the "_" and add the "_" to the "id_prefix" below
		// 'id_prefix' => '_',
		
		// Human-readable name for the layout field
		'name' => __( 'Layout', 'lumen_ambient' ),
		
		// array of $key=>$val pairs where 
		//       $key is the meta value for the option
		//       $val is the name (or image src) displayed on screen
		//       if "type" is "select" $val should be text only name of the layout
		//       if "type" is "image_select" $val should be the src for an image of the layout
		'options' => array(
			'full_width' => get_template_directory_uri() . '/images/full_width.png',
			'sidebar_left' => get_template_directory_uri() . '/images/sidebar_left.png',
			'sidebar_right' => get_template_directory_uri() . '/images/sidebar_right.png',
		),
		
		// define the option interface type
		//        "image_select" shows images as radio elements (useful if you have grahpical layout options)
		//        "select" is a text-based select element
		'type' => 'image_select',
		
	);
	
	return $settings;
	
}


public static function lumen_ambient_wrapper_open() {
	echo '<div id="container" class="row">
             <div id="content" class="columns"  >';
}
public static function lumen_ambient_wrapper_close() {
    echo '</div>
        </div>';
}
/**
 * Display LifterLMS Course and Lesson sidebars
 * on courses and lessons in place of the sidebar returned by
 * this function
 * @param    string     $id    default sidebar id (an empty string)
 * @return   string
 */
public static function lumen_ambient_llms_sidebar( $id ) {
	$lumen_ambient_sidebar_id = 'sidebar'; // replace this with your theme's sidebar ID
	return $lumen_ambient_sidebar_id;
}

/**
 * Declare explicit theme support for LifterLMS course and lesson sidebars
 * @return   void
 */
public static function lumen_ambient_llms_theme_support(){
	add_theme_support( 'lifterlms-sidebars' );
}

}