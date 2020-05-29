<?php
/** The \NV\Theme\Customize\ThemeCustomizer class */

namespace NV\Theme\Customize;

use NV\Theme\Core;
use NV\Theme\Custom\RadioImageControl;
use NV\Theme\Custom\DropDownSelectControl;

/**
 * Contains methods for customizing the theme customization screen.
 *
 * @link  http://codex.wordpress.org/Theme_Customization_API
 */
class ThemeCustomizer {

	/**
	 * This hooks into 'customize_register' (available as of WP 3.4) and allows you to add new sections and controls to
	 * the Theme Customize screen.
	 *
	 * Note: To enable instant preview, we have to actually write a bit of custom javascript.
	 *
	 * @used-by add_action( 'customize_register', $func )
	 *
	 * @param \WP_Customize_Manager $wp_customize
	 */
	public static function register( $wp_customize ) {

	
		$wp_customize->add_section( 'lu_site_colors_setting',
		  array(
			  'title'         => __( 'Site Colors', 'lumen-ambient' ),
			  'priority'      =>2,
			   'panel' => 'color',
			  'priority' => 160, 
			  'capability'    => 'edit_theme_options',
			  'description'   => __('Allows you to set theme colors.', 'lumen-ambient'),
		  )
		);
	

		
			 
	
		// We can also change built-in settings by modifying properties. For instance, let's make some stuff use live preview JS...
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
		$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';

		/*$wp_customize->add_panel();
		$wp_customize->get_panel();
		$wp_customize->remove_panel();
		
		$wp_customize->add_section();
		$wp_customize->get_section();
		$wp_customize->remove_section();
		
		$wp_customize->add_setting();
		$wp_customize->get_setting();
		$wp_customize->remove_setting();
		
		$wp_customize->add_control();
		$wp_customize->get_control();
		$wp_customize->remove_control();*/
	}


	/**
	 * This will output the custom WordPress settings to the theme's WP head.
	 *
	 * @used-by add_action( 'wp_head', $func )
	 */
	public static function header_output() {
		// If we're not previewing, don't output anything
	
		?>
		<!--Customizer CSS-->
		<style type="text/css" id="lumen-styles-3">
			<?php self::generate_css( '#site-title a', 'color', 'header_textcolor', '#' ); ?>
			<?php self::generate_css( 'body', 'background-color', 'background_color', '#' ); ?>
			<?php self::generate_css( 'a', 'color', 'lu_theme_options[link_textcolor]' ); ?>
			<?php self::generate_css( '.topbar-responsive ', 'background-color', 'lumen_color_back'); ?>
			<?php self::generate_css( '.topbar-responsive ul', 'background-color', 'lumen_color_back'); ?>
			<?php self::generate_css( '.topbar-responsive a', 'color', 'lumen_color_text'); ?>
			<?php self::generate_css( '.menu a:hover, .menu a:focus', 'color', 'lumen_color_menu_hover'); ?>
		</style>
		<!--/Customizer CSS-->
		<?php
	}

	/**
	 * This outputs the javascript needed to automate the live settings preview. Also keep in mind that this function
	 * isn't necessary unless your settings are explicitly using 'transport'=>'postMessage' instead of the default
	 * 'transport' => 'refresh' behavior.
	 *
	 * @used-by add_action( 'customize_preview_init', $func )
	 */
	public static function live_preview() {
		wp_enqueue_script(
			'lu-themecustomizer', //Give the script an ID
			Core::i()->get_js_url( 'theme-customizer.min.js' ), //Define its JS file
			[ 'jquery', 'customize-preview' ], //Define dependencies
			null, //Define a version (optional)
			true //Specify whether to put in footer (leave this true)
		);
	}
	
	

	/**
	 * This will generate a line of CSS for use in header output. If the setting ($mod_name) has no defined value, the
	 * CSS will not be output.
	 *
	 * @uses  get_theme_mod()
	 *
	 * @param string $selector CSS selector
	 * @param string $style    The name of the CSS *property* to modify
	 * @param string $mod_name The name of the 'theme_mod' option to fetch
	 * @param string $prefix   Optional. Anything that needs to be output before the CSS property
	 * @param string $postfix  Optional. Anything that needs to be output after the CSS property
	 * @param bool   $echo     Optional. Whether to print directly to the page (default: true).
	 *
	 * @return string Returns a single line of CSS with selectors and a property.
	 */
	public static function generate_css( $selector, $style, $mod_name, $prefix = '', $postfix = '', $echo = true ) {
		$return = '';

		$mod = get_theme_mod( $mod_name );

		if ( ! empty( $mod ) ) {
			$return = sprintf(
				'%s { %s:%s; }',
				$selector,
				$style,
				$prefix . $mod . $postfix
			);
			if ( $echo ) {
				echo esc_html($return);
			}
		}

		return $return;
	}

	/**
	 * Sanitize Checkbox
	 *
	 * Accepts only "true" or "false" as possible values.
	 *
	 * @param $input
	 *
	 * @access public
	 * @since  1.0
	 * @return bool
	 */
	public static function sanitize_checkbox( $input ) {
		return ( $input === true ) ? true : false;
	}


		/**
	 * Radio Button and Select sanitization
	 *
	 * @param  string		Radio Button value
	 * @return integer	Sanitized value
	 */
	
		public static  function lu_radio_sanitization( $input, $setting ) {
			//get the list of possible radio box or select options
         $choices = $setting->manager->get_control( $setting->id )->choices;
			if ( array_key_exists( $input, $choices ) ) {
				return $input;
			} else {
				return $setting->default;
			}
		}


		/**
	 * Text sanitization
	 *
	 * @param  string	Input to be sanitized (either a string containing a single string or multiple, separated by commas)
	 * @return string	Sanitized input
	 */
	
	public static 	function lu_text_sanitization( $input ) {
			if ( strpos( $input, ',' ) !== false) {
				$input = explode( ',', $input );
			}
			if( is_array( $input ) ) {
				foreach ( $input as $key => $value ) {
					$input[$key] = sanitize_text_field( $value );
				}
				$input = implode( ',', $input );
			}
			else {
				$input = sanitize_text_field( $input );
			}
			return $input;
		}
	

   

}