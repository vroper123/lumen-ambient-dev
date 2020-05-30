<?php
/**
 * Footer Bottom Customizer Options
 *
 * @package LumenWP WordPress theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'lumenWP_Footer_Bottom_Customizer' ) ) :

	class lumenWP_Footer_Bottom_Customizer {

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
			$section = 'lumen_footer_bottom_section';
			$wp_customize->add_section( $section , array(
				'title' 			=> esc_html__( 'Footer Bottom', 'lumen' ),
				'priority' 			=> 210,
			) );

			/**
			 * Enable Footer Bottom
			 */
			$wp_customize->add_setting( 'lumen_footer_bottom', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'lumenwp_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_footer_bottom', array(
				'label'	   				=> esc_html__( 'Enable Footer Bottom', 'lumen' ),
				'type' 					=> 'checkbox',
				'section'  				=> $section,
				'settings' 				=> 'lumen_footer_bottom',
				'priority' 				=> 10,
			) ) );

			/**
			 * Footer Bottom Visibility
			 */
			$wp_customize->add_setting( 'lumen_bottom_footer_visibility', array(
				'transport' 			=> 'postMessage',
				'default'           	=> 'all-devices',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_bottom_footer_visibility', array(
				'label'	   				=> esc_html__( 'Visibility', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> $section,
				'settings' 				=> 'lumen_bottom_footer_visibility',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_footer_bottom',
				'choices' 				=> array(
					'all-devices' 			=> esc_html__( 'Show On All Devices', 'lumen' ),
					'hide-tablet' 			=> esc_html__( 'Hide On Tablet', 'lumen' ),
					'hide-mobile' 			=> esc_html__( 'Hide On Mobile', 'lumen' ),
					'hide-tablet-mobile' 	=> esc_html__( 'Hide On Tablet & Mobile', 'lumen' ),
				),
			) ) );

			/**
			 * Footer Bottom Copyright
			 */
			$wp_customize->add_setting( 'lumen_footer_copyright_text', array(
				'transport'           	=> 'postMessage',
				'default'           	=> 'Copyright [lumenwp_date] - lumen Theme by Nick',
				'sanitize_callback' 	=> 'wp_kses_post',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Textarea_Control( $wp_customize, 'lumen_footer_copyright_text', array(
				'label'	   				=> esc_html__( 'Copyright', 'lumen' ),
				'description'	   		=> sprintf( esc_html__( 'Shortcodes allowed, %1$ssee the list%2$s.', 'lumen' ), '<a href="http://docs.lumen.org/category/369-shortcodes" target="_blank">', '</a>' ),
				'section'  				=> $section,
				'settings' 				=> 'lumen_footer_copyright_text',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_footer_bottom',
			) ) );

			/**
			 * Footer Bottom Padding
			 */
			$wp_customize->add_setting( 'lumen_bottom_footer_top_padding', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '15',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_bottom_footer_right_padding', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '0',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_bottom_footer_bottom_padding', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '15',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_bottom_footer_left_padding', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '0',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );

			$wp_customize->add_setting( 'lumen_bottom_footer_tablet_top_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_bottom_footer_tablet_right_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_bottom_footer_tablet_bottom_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_bottom_footer_tablet_left_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_setting( 'lumen_bottom_footer_mobile_top_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_bottom_footer_mobile_right_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_bottom_footer_mobile_bottom_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_bottom_footer_mobile_left_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Dimensions_Control( $wp_customize, 'lumen_bottom_footer_padding_dimensions', array(
				'label'	   				=> esc_html__( 'Padding (px)', 'lumen' ),
				'section'  				=> $section,				
				'settings'   => array(
		            'desktop_top' 		=> 'lumen_bottom_footer_top_padding',
		            'desktop_right' 	=> 'lumen_bottom_footer_right_padding',
		            'desktop_bottom' 	=> 'lumen_bottom_footer_bottom_padding',
		            'desktop_left' 		=> 'lumen_bottom_footer_left_padding',
		            'tablet_top' 		=> 'lumen_bottom_footer_tablet_top_padding',
		            'tablet_right' 		=> 'lumen_bottom_footer_tablet_right_padding',
		            'tablet_bottom' 	=> 'lumen_bottom_footer_tablet_bottom_padding',
		            'tablet_left' 		=> 'lumen_bottom_footer_tablet_left_padding',
		            'mobile_top' 		=> 'lumen_bottom_footer_mobile_top_padding',
		            'mobile_right' 		=> 'lumen_bottom_footer_mobile_right_padding',
		            'mobile_bottom' 	=> 'lumen_bottom_footer_mobile_bottom_padding',
		            'mobile_left' 		=> 'lumen_bottom_footer_mobile_left_padding',
				),
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_footer_bottom',
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 500,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Footer Bottom Background Color
			 */
			$wp_customize->add_setting( 'lumen_bottom_footer_background', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#1b1b1b',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_bottom_footer_background', array(
				'label'	   				=> esc_html__( 'Background Color', 'lumen' ),
				'section'  				=> $section,
				'settings' 				=> 'lumen_bottom_footer_background',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_footer_bottom',
			) ) );

			/**
			 * Footer Bottom Color
			 */
			$wp_customize->add_setting( 'lumen_bottom_footer_color', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#929292',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_bottom_footer_color', array(
				'label'	   				=> esc_html__( 'Text Color', 'lumen' ),
				'section'  				=> $section,
				'settings' 				=> 'lumen_bottom_footer_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_footer_bottom',
			) ) );

			/**
			 * Footer Bottom Links Color
			 */
			$wp_customize->add_setting( 'lumen_bottom_footer_link_color', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#ffffff',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_bottom_footer_link_color', array(
				'label'	   				=> esc_html__( 'Links Color', 'lumen' ),
				'section'  				=> $section,
				'settings' 				=> 'lumen_bottom_footer_link_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_footer_bottom',
			) ) );

			/**
			 * Footer Bottom Links Hover Color
			 */
			$wp_customize->add_setting( 'lumen_bottom_footer_link_color_hover', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#13aff0',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_bottom_footer_link_color_hover', array(
				'label'	   				=> esc_html__( 'Links Color: Hover', 'lumen' ),
				'section'  				=> $section,
				'settings' 				=> 'lumen_bottom_footer_link_color_hover',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_footer_bottom',
			) ) );

		}

		/**
		 * Get CSS
		 *
		 * @since 1.0.0
		 */
		public static function head_css( $output ) {
		
			// Global vars
			$bottom_top_padding 		= get_theme_mod( 'lumen_bottom_footer_top_padding', '15' );
			$bottom_right_padding 		= get_theme_mod( 'lumen_bottom_footer_right_padding', '0' );
			$bottom_bottom_padding 		= get_theme_mod( 'lumen_bottom_footer_bottom_padding', '15' );
			$bottom_left_padding 		= get_theme_mod( 'lumen_bottom_footer_left_padding', '0' );
			$tablet_top_padding 		= get_theme_mod( 'lumen_bottom_footer_tablet_top_padding' );
			$tablet_right_padding 		= get_theme_mod( 'lumen_bottom_footer_tablet_right_padding' );
			$tablet_bottom_padding 		= get_theme_mod( 'lumen_bottom_footer_tablet_bottom_padding' );
			$tablet_left_padding 		= get_theme_mod( 'lumen_bottom_footer_tablet_left_padding' );
			$mobile_top_padding 		= get_theme_mod( 'lumen_bottom_footer_mobile_top_padding' );
			$mobile_right_padding 		= get_theme_mod( 'lumen_bottom_footer_mobile_right_padding' );
			$mobile_bottom_padding 		= get_theme_mod( 'lumen_bottom_footer_mobile_bottom_padding' );
			$mobile_left_padding 		= get_theme_mod( 'lumen_bottom_footer_mobile_left_padding' );
			$bottom_background 			= get_theme_mod( 'lumen_bottom_footer_background', '#1b1b1b' );
			$bottom_color 				= get_theme_mod( 'lumen_bottom_footer_color', '#929292' );
			$bottom_link_color 			= get_theme_mod( 'lumen_bottom_footer_link_color', '#ffffff' );
			$bottom_link_color_hover 	= get_theme_mod( 'lumen_bottom_footer_link_color_hover', '#13aff0' );

			// Define css var
			$css = '';

			// Footer bottom padding
			if ( isset( $bottom_top_padding ) && '15' != $bottom_top_padding && '' != $bottom_top_padding
				|| isset( $bottom_right_padding ) && '0' != $bottom_right_padding && '' != $bottom_right_padding
				|| isset( $bottom_bottom_padding ) && '15' != $bottom_bottom_padding && '' != $bottom_bottom_padding
				|| isset( $bottom_left_padding ) && '0' != $bottom_left_padding && '' != $bottom_left_padding ) {
				$css .= '#footer-bottom{padding:'. lumenwp_spacing_css( $bottom_top_padding, $bottom_right_padding, $bottom_bottom_padding, $bottom_left_padding ) .'}';
			}

			// Tablet footer bottom padding
			if ( isset( $tablet_top_padding ) && '' != $tablet_top_padding
				|| isset( $tablet_right_padding ) && '' != $tablet_right_padding
				|| isset( $tablet_bottom_padding ) && '' != $tablet_bottom_padding
				|| isset( $tablet_left_padding ) && '' != $tablet_left_padding ) {
				$css .= '@media (max-width: 768px){#footer-bottom{padding:'. lumenwp_spacing_css( $tablet_top_padding, $tablet_right_padding, $tablet_bottom_padding, $tablet_left_padding ) .'}}';
			}

			// Mobile footer bottom padding
			if ( isset( $mobile_top_padding ) && '' != $mobile_top_padding
				|| isset( $mobile_right_padding ) && '' != $mobile_right_padding
				|| isset( $mobile_bottom_padding ) && '' != $mobile_bottom_padding
				|| isset( $mobile_left_padding ) && '' != $mobile_left_padding ) {
				$css .= '@media (max-width: 480px){#footer-bottom{padding:'. lumenwp_spacing_css( $mobile_top_padding, $mobile_right_padding, $mobile_bottom_padding, $mobile_left_padding ) .'}}';
			}

			// Footer bottom background
			if ( ! empty( $bottom_background ) && '#1b1b1b' != $bottom_background ) {
				$css .= '#footer-bottom{background-color:'. $bottom_background .';}';
			}

			// Footer bottom color
			if ( ! empty( $bottom_color ) && '#929292' != $bottom_color ) {
				$css .= '#footer-bottom,#footer-bottom p{color:'. $bottom_color .';}';
			}

			// Footer bottom links color
			if ( ! empty( $bottom_link_color ) && '#ffffff' != $bottom_link_color ) {
				$css .= '#footer-bottom a,#footer-bottom #footer-bottom-menu a{color:'. $bottom_link_color .';}';
			}

			// Footer bottom links hover color
			if ( ! empty( $bottom_link_color_hover ) && '#13aff0' != $bottom_link_color_hover ) {
				$css .= '#footer-bottom a:hover,#footer-bottom #footer-bottom-menu a:hover{color:'. $bottom_link_color_hover .';}';
			}
				
			// Return CSS
			if ( ! empty( $css ) ) {
				$output .= '/* Footer Bottom CSS */'. $css;
			}

			// Return output css
			return $output;

		}

	}

endif;

return new lumenWP_Footer_Bottom_Customizer();