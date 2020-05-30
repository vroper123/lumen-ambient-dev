<?php
/**
 * Footer Widgets Customizer Options
 *
 * @package LumenWP WordPress theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'lumenWP_Footer_Widgets_Customizer' ) ) :

	class lumenWP_Footer_Widgets_Customizer {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {

			add_action( 'customize_register', 	array( $this, 'customizer_options' ) );
			add_filter( 'lumen_head_css', 		array( $this, 'head_css' ) );

		}

		/**
		 * Customizer options
		 *
		 * @since 1.0.0
		 */
		public function customizer_options( $wp_customize ) {

			/**
			 * Section
			 */
			$section = 'lumen_footer_widgets_section';
			$wp_customize->add_section( $section , array(
				'title' 			=> esc_html__( 'Footer Widgets', 'lumen' ),
				'priority' 			=> 210,
			) );

			/**
			 * Enable Footer Widgets
			 */
			$wp_customize->add_setting( 'lumen_footer_widgets', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'lumenwp_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_footer_widgets', array(
				'label'	   				=> esc_html__( 'Enable Footer Widgets', 'lumen' ),
				'type' 					=> 'checkbox',
				'section'  				=> $section,
				'settings' 				=> 'lumen_footer_widgets',
				'priority' 				=> 10,
			) ) );

			/**
			 * Footer Widgets Visibility
			 */
			$wp_customize->add_setting( 'lumen_footer_widgets_visibility', array(
				'transport' 			=> 'postMessage',
				'default'           	=> 'all-devices',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_footer_widgets_visibility', array(
				'label'	   				=> esc_html__( 'Visibility', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> $section,
				'settings' 				=> 'lumen_footer_widgets_visibility',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_footer_widgets',
				'choices' 				=> array(
					'all-devices' 			=> esc_html__( 'Show On All Devices', 'lumen' ),
					'hide-tablet' 			=> esc_html__( 'Hide On Tablet', 'lumen' ),
					'hide-mobile' 			=> esc_html__( 'Hide On Mobile', 'lumen' ),
					'hide-tablet-mobile' 	=> esc_html__( 'Hide On Tablet & Mobile', 'lumen' ),
				),
			) ) );

			/**
			 * Fixed Footer
			 */
			$wp_customize->add_setting( 'lumen_fixed_footer', array(
				'default'           	=> 'off',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Buttonset_Control( $wp_customize, 'lumen_fixed_footer', array(
				'label'	   				=> esc_html__( 'Fixed Footer', 'lumen' ),
				'description'	   		=> esc_html__( 'This option add a height to your content to keep your footer at the bottom of your page.', 'lumen' ),
				'section'  				=> $section,
				'settings' 				=> 'lumen_fixed_footer',
				'priority' 				=> 10,
				'choices' 				=> array(
					'on' 	=> esc_html__( 'On', 'lumen' ),
					'off' 	=> esc_html__( 'Off', 'lumen' ),
				),
				'active_callback' 		=> 'lumenwp_cac_has_footer_widgets',
			) ) );

			/**
			 * Parallax Footer Effect
			 */
			$wp_customize->add_setting( 'lumen_parallax_footer', array(
				'default'           	=> 'off',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Buttonset_Control( $wp_customize, 'lumen_parallax_footer', array(
				'label'	   				=> esc_html__( 'Parallax Footer Effect', 'lumen' ),
				'description'	   		=> esc_html__( 'Add a parallax effect to your footer.', 'lumen' ),
				'section'  				=> $section,
				'settings' 				=> 'lumen_parallax_footer',
				'priority' 				=> 10,
				'choices' 				=> array(
					'on' 	=> esc_html__( 'On', 'lumen' ),
					'off' 	=> esc_html__( 'Off', 'lumen' ),
				),
				'active_callback' 		=> 'lumenwp_cac_has_footer_widgets',
			) ) );

			/**
			 * Footer Widgets Template
			 */
			$wp_customize->add_setting( 'lumen_footer_widgets_template', array(
				'default'           	=> '0',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_footer_widgets_template', array(
				'label'	   				=> esc_html__( 'Select Template', 'lumen' ),
				'description'	   		=> esc_html__( 'Choose a template created in Theme Panel > My Library.', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> $section,
				'settings' 				=> 'lumen_footer_widgets_template',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_footer_widgets',
				'choices' 				=> lumenwp_customizer_helpers( 'library' ),
			) ) );

			/**
			 * Footer Widgets Columns
			 */
			$wp_customize->add_setting( 'lumen_footer_widgets_columns', array(
				'default'           	=> '4',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );

			$wp_customize->add_setting( 'lumen_footer_widgets_tablet_columns', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_setting( 'lumen_footer_widgets_mobile_columns', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Slider_Control( $wp_customize, 'lumen_footer_widgets_columns', array(
				'label' 			=> esc_html__( 'Columns', 'lumen' ),
				'section'  			=> $section,
				'settings' => array(
		            'desktop' 	=> 'lumen_footer_widgets_columns',
		            'tablet' 	=> 'lumen_footer_widgets_tablet_columns',
		            'mobile' 	=> 'lumen_footer_widgets_mobile_columns',
			    ),
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_footer_widgets_and_no_page_id',
			    'input_attrs' 			=> array(
			        'min'   => 1,
			        'max'   => 4,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Footer Widgets Add Container
			 */
			$wp_customize->add_setting( 'lumen_add_footer_container', array(
				'transport' 			=> 'postMessage',
				'default'           	=> true,
				'sanitize_callback' 	=> 'lumenwp_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_add_footer_container', array(
				'label'	   				=> esc_html__( 'Add Container', 'lumen' ),
				'type' 					=> 'checkbox',
				'section'  				=> $section,
				'settings' 				=> 'lumen_add_footer_container',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_footer_widgets',
			) ) );

			/**
			 * Footer Widgets Padding
			 */
			$wp_customize->add_setting( 'lumen_footer_top_padding', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '30',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_footer_right_padding', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '0',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_footer_bottom_padding', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '30',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_footer_left_padding', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '0',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );

			$wp_customize->add_setting( 'lumen_footer_tablet_top_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_footer_tablet_right_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_footer_tablet_bottom_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_footer_tablet_left_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_setting( 'lumen_footer_mobile_top_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_footer_mobile_right_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_footer_mobile_bottom_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_footer_mobile_left_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Dimensions_Control( $wp_customize, 'lumen_footer_padding_dimensions', array(
				'label'	   				=> esc_html__( 'Padding (px)', 'lumen' ),
				'section'  				=> $section,				
				'settings'   => array(
		            'desktop_top' 		=> 'lumen_footer_top_padding',
		            'desktop_right' 	=> 'lumen_footer_right_padding',
		            'desktop_bottom' 	=> 'lumen_footer_bottom_padding',
		            'desktop_left' 		=> 'lumen_footer_left_padding',
		            'tablet_top' 		=> 'lumen_footer_tablet_top_padding',
		            'tablet_right' 		=> 'lumen_footer_tablet_right_padding',
		            'tablet_bottom' 	=> 'lumen_footer_tablet_bottom_padding',
		            'tablet_left' 		=> 'lumen_footer_tablet_left_padding',
		            'mobile_top' 		=> 'lumen_footer_mobile_top_padding',
		            'mobile_right' 		=> 'lumen_footer_mobile_right_padding',
		            'mobile_bottom' 	=> 'lumen_footer_mobile_bottom_padding',
		            'mobile_left' 		=> 'lumen_footer_mobile_left_padding',
				),
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_footer_widgets',
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 500,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Footer Widgets Background
			 */
			$wp_customize->add_setting( 'lumen_footer_background', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#222222',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_footer_background', array(
				'label'	   				=> esc_html__( 'Background Color', 'lumen' ),
				'section'  				=> $section,
				'settings' 				=> 'lumen_footer_background',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_footer_widgets',
			) ) );

			/**
			 * Footer Widgets Color
			 */
			$wp_customize->add_setting( 'lumen_footer_color', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#929292',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_footer_color', array(
				'label'	   				=> esc_html__( 'Text Color', 'lumen' ),
				'section'  				=> $section,
				'settings' 				=> 'lumen_footer_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_footer_widgets',
			) ) );

			/**
			 * Footer Widgets Borders Color
			 */
			$wp_customize->add_setting( 'lumen_footer_borders', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#555555',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_footer_borders', array(
				'label'	   				=> esc_html__( 'Borders Color', 'lumen' ),
				'section'  				=> $section,
				'settings' 				=> 'lumen_footer_borders',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_footer_widgets',
			) ) );

			/**
			 * Footer Widgets Links Color
			 */
			$wp_customize->add_setting( 'lumen_footer_link_color', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#ffffff',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_footer_link_color', array(
				'label'	   				=> esc_html__( 'Links Color', 'lumen' ),
				'section'  				=> $section,
				'settings' 				=> 'lumen_footer_link_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_footer_widgets',
			) ) );

			/**
			 * Footer Widgets Links Hover Color
			 */
			$wp_customize->add_setting( 'lumen_footer_link_color_hover', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#13aff0',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_footer_link_color_hover', array(
				'label'	   				=> esc_html__( 'Links Color: Hover', 'lumen' ),
				'section'  				=> $section,
				'settings' 				=> 'lumen_footer_link_color_hover',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_footer_widgets',
			) ) );

		}

		/**
		 * Get CSS
		 *
		 * @since 1.0.0
		 */
		public static function head_css( $output ) {
		
			// Global vars
			$footer_top_padding 				= get_theme_mod( 'lumen_footer_top_padding', '30' );
			$footer_right_padding 				= get_theme_mod( 'lumen_footer_right_padding', '0' );
			$footer_bottom_padding 				= get_theme_mod( 'lumen_footer_bottom_padding', '30' );
			$footer_left_padding 				= get_theme_mod( 'lumen_footer_left_padding', '0' );
			$tablet_footer_top_padding 			= get_theme_mod( 'lumen_footer_tablet_top_padding' );
			$tablet_footer_right_padding 		= get_theme_mod( 'lumen_footer_tablet_right_padding' );
			$tablet_footer_bottom_padding 		= get_theme_mod( 'lumen_footer_tablet_bottom_padding' );
			$tablet_footer_left_padding 		= get_theme_mod( 'lumen_footer_tablet_left_padding' );
			$mobile_footer_top_padding 			= get_theme_mod( 'lumen_footer_mobile_top_padding' );
			$mobile_footer_right_padding 		= get_theme_mod( 'lumen_footer_mobile_right_padding' );
			$mobile_footer_bottom_padding 		= get_theme_mod( 'lumen_footer_mobile_bottom_padding' );
			$mobile_footer_left_padding 		= get_theme_mod( 'lumen_footer_mobile_left_padding' );
			$footer_background 					= get_theme_mod( 'lumen_footer_background', '#222222' );
			$footer_color 						= get_theme_mod( 'lumen_footer_color', '#929292' );
			$footer_borders 					= get_theme_mod( 'lumen_footer_borders', '#555555' );
			$footer_link_color 					= get_theme_mod( 'lumen_footer_link_color', '#ffffff' );
			$footer_link_color_hover 			= get_theme_mod( 'lumen_footer_link_color_hover', '#13aff0' );

			// Define css var
			$css = '';
			
			// Footer padding
			if ( isset( $footer_top_padding ) && '30' != $footer_top_padding && '' != $footer_top_padding
				|| isset( $footer_right_padding ) && '0' != $footer_right_padding && '' != $footer_right_padding
				|| isset( $footer_bottom_padding ) && '30' != $footer_bottom_padding && '' != $footer_bottom_padding
				|| isset( $footer_left_padding ) && '0' != $footer_left_padding && '' != $footer_left_padding ) {
				$css .= '#footer-widgets{padding:'. lumenwp_spacing_css( $footer_top_padding, $footer_right_padding, $footer_bottom_padding, $footer_left_padding ) .'}';
			}

			// Tablet footer padding
			if ( isset( $tablet_footer_top_padding ) && '' != $tablet_footer_top_padding
				|| isset( $tablet_footer_right_padding ) && '' != $tablet_footer_right_padding
				|| isset( $tablet_footer_bottom_padding ) && '' != $tablet_footer_bottom_padding
				|| isset( $tablet_footer_left_padding ) && '' != $tablet_footer_left_padding ) {
				$css .= '@media (max-width: 768px){#footer-widgets{padding:'. lumenwp_spacing_css( $tablet_footer_top_padding, $tablet_footer_right_padding, $tablet_footer_bottom_padding, $tablet_footer_left_padding ) .'}}';
			}

			// Mobile footer padding
			if ( isset( $mobile_footer_top_padding ) && '' != $mobile_footer_top_padding
				|| isset( $mobile_footer_right_padding ) && '' != $mobile_footer_right_padding
				|| isset( $mobile_footer_bottom_padding ) && '' != $mobile_footer_bottom_padding
				|| isset( $mobile_footer_left_padding ) && '' != $mobile_footer_left_padding ) {
				$css .= '@media (max-width: 480px){#footer-widgets{padding:'. lumenwp_spacing_css( $mobile_footer_top_padding, $mobile_footer_right_padding, $mobile_footer_bottom_padding, $mobile_footer_left_padding ) .'}}';
			}

			// Footer background
			if ( ! empty( $footer_background ) && '#222222' != $footer_background ) {
				$css .= '#footer-widgets{background-color:'. $footer_background .';}';
			}

			// Footer color
			if ( ! empty( $footer_color ) && '#929292' != $footer_color ) {
				$css .= '#footer-widgets,#footer-widgets p,#footer-widgets li a:before,#footer-widgets .contact-info-widget span.lumen-contact-title,#footer-widgets .recent-posts-date,#footer-widgets .recent-posts-comments,#footer-widgets .widget-recent-posts-icons li .fa{color:'. $footer_color .';}';
			}

			// Footer borders color
			if ( ! empty( $footer_borders ) && '#555555' != $footer_borders ) {
				$css .= '#footer-widgets li,#footer-widgets #wp-calendar caption,#footer-widgets #wp-calendar th,#footer-widgets #wp-calendar tbody,#footer-widgets .contact-info-widget i,#footer-widgets .lumen-newsletter-form-wrap input[type="email"],#footer-widgets .posts-thumbnails-widget li,#footer-widgets .social-widget li a{border-color:'. $footer_borders .';}';
			}

			// Footer link color
			if ( ! empty( $footer_link_color ) && '#ffffff' != $footer_link_color ) {
				$css .= '#footer-widgets .footer-box a,#footer-widgets a{color:'. $footer_link_color .';}';
			}

			// Footer link hover color
			if ( ! empty( $footer_link_color_hover ) && '#13aff0' != $footer_link_color_hover ) {
				$css .= '#footer-widgets .footer-box a:hover,#footer-widgets a:hover{color:'. $footer_link_color_hover .';}';
			}
				
			// Return CSS
			if ( ! empty( $css ) ) {
				$output .= '/* Footer Widgets CSS */'. $css;
			}

			// Return output css
			return $output;

		}

	}

endif;

return new lumenWP_Footer_Widgets_Customizer();