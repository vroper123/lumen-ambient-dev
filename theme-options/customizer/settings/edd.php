<?php
/**
 * EDD Customizer Options
 *
 * @package LumenWP WordPress theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'lumenWP_EDD_Customizer' ) ) :

	class lumenWP_EDD_Customizer {

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
			 * Panel
			 */
			$panel = 'lumen_edd_panel';
			$wp_customize->add_panel( $panel , array(
				'title' 			=> esc_html__( 'Easy Digital Downloads', 'lumen' ),
				'priority' 			=> 210,
			) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'lumen_edd_general' , array(
				'title' 			=> esc_html__( 'General', 'lumen' ),
				'description' 		=> esc_html__( 'For some options, you must save and refresh your live site to preview changes.', 'lumen' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Custom EDD Sidebar
			 */
			$wp_customize->add_setting( 'lumen_edd_custom_sidebar', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'lumenwp_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_edd_custom_sidebar', array(
				'label'	   				=> esc_html__( 'Custom EDD Sidebar', 'lumen' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'lumen_edd_general',
				'settings' 				=> 'lumen_edd_custom_sidebar',
				'priority' 				=> 10,
			) ) );

			/**
			 * Display Cart When Product Added
			 */
			$wp_customize->add_setting( 'lumen_edd_display_cart_edd_added', array(
				'default'           	=> 'no',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Buttonset_Control( $wp_customize, 'lumen_edd_display_cart_edd_added', array(
				'label'	   				=> esc_html__( 'Display Cart When Product Added', 'lumen' ),
				'description'	   		=> esc_html__( 'Display the cart when a edd is added, work in the shop and the single edd pages if ajax is enabled.', 'lumen' ),
				'section'  				=> 'lumen_edd_general',
				'settings' 				=> 'lumen_edd_display_cart_edd_added',
				'priority' 				=> 10,
				'choices' 				=> array(
					'yes' 	=> esc_html__( 'Yes', 'lumen' ),
					'no' 	=> esc_html__( 'No', 'lumen' ),
				),
			) ) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'lumen_edd_menu_cart' , array(
				'title' 			=> esc_html__( 'Menu Cart', 'lumen' ),
				'description' 		=> esc_html__( 'For some options, you must save and refresh your live site to preview changes.', 'lumen' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Hide If Empty
			 */
			$wp_customize->add_setting( 'lumen_edd_menu_icon_hide_if_empty', array(
				'default'           	=> false,
				'sanitize_callback' 	=> 'lumenwp_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_edd_menu_icon_hide_if_empty', array(
				'label'	   				=> esc_html__( 'Hide If Empty Cart', 'lumen' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' 				=> 'lumen_edd_menu_icon_hide_if_empty',
				'priority' 				=> 10,
			) ) );

			/**
			 * Visibility
			 */
			$wp_customize->add_setting( 'lumen_edd_menu_icon_visibility', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_edd_menu_icon_visibility', array(
				'label'	   				=> esc_html__( 'Visibility', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' 				=> 'lumen_edd_menu_icon_visibility',
				'priority' 				=> 10,
				'choices' 				=> array(
					'default' 			=> esc_html__( 'Display On All Devices', 'lumen' ),
					'disabled' 			=> esc_html__( 'Disabled On All Devices', 'lumen' ),
				),
			) ) );

			/**
			 * Bag Style
			 */
			$wp_customize->add_setting( 'lumen_edd_menu_bag_style', array(
				'default'           	=> 'no',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Buttonset_Control( $wp_customize, 'lumen_edd_menu_bag_style', array(
				'label'	   				=> esc_html__( 'Bag Style', 'lumen' ),
				'description'	   		=> esc_html__( 'This setting rep^lace the cart icon by a bag with the items count in it.', 'lumen' ),
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' 				=> 'lumen_edd_menu_bag_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'yes' 	=> esc_html__( 'Yes', 'lumen' ),
					'no' 	=> esc_html__( 'No', 'lumen' ),
				),
			) ) );

			/**
			 * Bag Style Total
			 */
			$wp_customize->add_setting( 'lumen_edd_menu_bag_style_total', array(
				'default'           	=> false,
				'sanitize_callback' 	=> 'lumenwp_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_edd_menu_bag_style_total', array(
				'label'	   				=> esc_html__( 'Bag Icon Display Total', 'lumen' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' 				=> 'lumen_edd_menu_bag_style_total',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_edd_bag_style',
			) ) );

			/**
			 * Bag Icon Color
			 */
			$wp_customize->add_setting( 'lumen_edd_menu_bag_icon_color', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#333333',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_menu_bag_icon_color', array(
				'label'	   				=> esc_html__( 'Bag Icon Color', 'lumen' ),
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' 				=> 'lumen_edd_menu_bag_icon_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_edd_bag_style',
			) ) );

			/**
			 * Bag Icon Hover Color
			 */
			$wp_customize->add_setting( 'lumen_edd_menu_bag_icon_hover_color', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#13aff0',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_menu_bag_icon_hover_color', array(
				'label'	   				=> esc_html__( 'Bag Icon Hover Color', 'lumen' ),
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' 				=> 'lumen_edd_menu_bag_icon_hover_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_edd_bag_style',
			) ) );

			/**
			 * Bag Icon Count Color
			 */
			$wp_customize->add_setting( 'lumen_edd_menu_bag_icon_count_color', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#333333',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_menu_bag_icon_count_color', array(
				'label'	   				=> esc_html__( 'Bag Icon Count Color', 'lumen' ),
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' 				=> 'lumen_edd_menu_bag_icon_count_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_edd_bag_style',
			) ) );

			/**
			 * Bag Icon Hover Count Color
			 */
			$wp_customize->add_setting( 'lumen_edd_menu_bag_icon_hover_count_color', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#ffffff',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_menu_bag_icon_hover_count_color', array(
				'label'	   				=> esc_html__( 'Bag Icon Hover Count Color', 'lumen' ),
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' 				=> 'lumen_edd_menu_bag_icon_hover_count_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_edd_bag_style',
			) ) );

			/**
			 * Display
			 */
			$wp_customize->add_setting( 'lumen_edd_menu_icon_display', array(
				'default'           	=> 'icon_count',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_edd_menu_icon_display', array(
				'label'	   				=> esc_html__( 'Display', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' 				=> 'lumen_edd_menu_icon_display',
				'priority' 				=> 10,
				'choices' 				=> array(
					'icon' 				=> esc_html__( 'Icon', 'lumen' ),
					'icon_total' 		=> esc_html__( 'Icon And Cart Total', 'lumen' ),
					'icon_count' 		=> esc_html__( 'Icon And Cart Count', 'lumen' ),
					'icon_count_total' 	=> esc_html__( 'Icon And Cart Count + Total', 'lumen' ),
				),
				'active_callback' 		=> 'lumenwp_cac_hasnt_edd_bag_style',
			) ) );

			/**
			 * Style
			 */
			$wp_customize->add_setting( 'lumen_edd_menu_icon_style', array(
				'transport'           	=> 'postMessage',
				'default'           	=> 'drop_down',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_edd_menu_icon_style', array(
				'label'	   				=> esc_html__( 'Style', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' 				=> 'lumen_edd_menu_icon_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'drop_down' 		=> esc_html__( 'Drop-Down', 'lumen' ),
					'cart' 				=> esc_html__( 'Go To Cart', 'lumen' ),
					'custom_link' 		=> esc_html__( 'Custom Link', 'lumen' ),
				),
			) ) );

			/**
			 * Custom Link
			 */
			$wp_customize->add_setting( 'lumen_edd_menu_icon_custom_link', array(
				'transport'           	=> 'postMessage',
				'sanitize_callback' 	=> 'esc_url_raw',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_edd_menu_icon_custom_link', array(
				'label'	   				=> esc_html__( 'Custom Link', 'lumen' ),
				'description'	   		=> esc_html__( 'The Custom Link style need to be selected', 'lumen' ),
				'type' 					=> 'text',
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' 				=> 'lumen_edd_menu_icon_custom_link',
				'priority' 				=> 10,
			) ) );

			/**
			 * Icon
			 */
			$wp_customize->add_setting( 'lumen_edd_menu_icon', array(
				'transport' 			=> 'postMessage',
				'default'           	=> 'icon-handbag',
				'sanitize_callback' 	=> 'wp_filter_nohtml_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Icon_Select_Control( $wp_customize, 'lumen_edd_menu_icon', array(
				'label'	   				=> esc_html__( 'Cart Icon', 'lumen' ),
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' 				=> 'lumen_edd_menu_icon',
				'priority' 				=> 10,
			    'choices' 				=> lumenwp_get_cart_icons(),
				'active_callback' 		=> 'lumenwp_cac_hasnt_edd_bag_style',
			) ) );

			/**
			 * Custom Icon
			 */
			$wp_customize->add_setting( 'lumen_edd_menu_custom_icon', array(
				'transport'           	=> 'postMessage',
				'sanitize_callback' 	=> 'wp_filter_nohtml_kses',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_edd_menu_custom_icon', array(
				'label'	   				=> esc_html__( 'Custom Icon', 'lumen' ),
				'description'	   		=> esc_html__( 'Enter your full icon class', 'lumen' ),
				'type' 					=> 'text',
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' 				=> 'lumen_edd_menu_custom_icon',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_hasnt_edd_bag_style',
			) ) );

			/**
			 * Icon Size
			 */
			$wp_customize->add_setting( 'lumen_edd_menu_icon_size', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_edd_menu_icon_size_tablet', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_setting( 'lumen_edd_menu_icon_size_mobile', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Slider_Control( $wp_customize, 'lumen_edd_menu_icon_size', array(
				'label'	   				=> esc_html__( 'Icon Size (px)', 'lumen' ),
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' => array(
		            'desktop' 	=> 'lumen_edd_menu_icon_size',
		            'tablet' 	=> 'lumen_edd_menu_icon_size_tablet',
		            'mobile' 	=> 'lumen_edd_menu_icon_size_mobile',
			    ),
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 10,
			        'max'   => 100,
			        'step'  => 1,
			    ),
				'active_callback' 		=> 'lumenwp_cac_hasnt_edd_bag_style',
			) ) );

			/**
			 * Center Vertically
			 */
			$wp_customize->add_setting( 'lumen_edd_menu_icon_center_vertically', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_edd_menu_icon_center_vertically_tablet', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_setting( 'lumen_edd_menu_icon_center_vertically_mobile', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Slider_Control( $wp_customize, 'lumen_edd_menu_icon_center_vertically', array(
				'label'	   				=> esc_html__( 'Center Vertically', 'lumen' ),
				'description'	   		=> esc_html__( 'Use this field to center your icon vertically', 'lumen' ),
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' => array(
		            'desktop' 	=> 'lumen_edd_menu_icon_center_vertically',
		            'tablet' 	=> 'lumen_edd_menu_icon_center_vertically_tablet',
		            'mobile' 	=> 'lumen_edd_menu_icon_center_vertically_mobile',
			    ),
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
				'active_callback' 		=> 'lumenwp_cac_hasnt_edd_bag_style',
			) ) );

			/**
			 * Heading Styling
			 */
			$wp_customize->add_setting( 'lumen_edd_cart_dropdowns_styling_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_edd_cart_dropdowns_styling_heading', array(
				'label'    	=> esc_html__( 'Cart Dropdown Styling', 'lumen' ),
				'section'  	=> 'lumen_edd_menu_cart',
				'priority' 	=> 10,
			) ) );

			/**
			 * Style
			 */
			$wp_customize->add_setting( 'lumen_edd_cart_dropdown_style', array(
				'transport' 			=> 'postMessage',
				'default'           	=> 'compact',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_edd_cart_dropdown_style', array(
				'label'	   				=> esc_html__( 'Style', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' 				=> 'lumen_edd_cart_dropdown_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'compact' 		=> esc_html__( 'Compact', 'lumen' ),
					'spacious' 		=> esc_html__( 'Spacious', 'lumen' ),
				),
			) ) );

			/**
			 * Dropdowns Width
			 */
			$wp_customize->add_setting( 'lumen_edd_cart_dropdown_width', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '350',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Range_Control( $wp_customize, 'lumen_edd_cart_dropdown_width', array(
				'label'	   				=> esc_html__( 'Cart Dropdowns Width (px)', 'lumen' ),
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' 				=> 'lumen_edd_cart_dropdown_width',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 30,
			        'max'   => 600,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Dropdown Background Color
			 */
			$wp_customize->add_setting( 'lumen_edd_cart_dropdown_bg', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#ffffff',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_cart_dropdown_bg', array(
				'label'	   				=> esc_html__( 'Dropdown Background Color', 'lumen' ),
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' 				=> 'lumen_edd_cart_dropdown_bg',
				'priority' 				=> 10,
			) ) );

			/**
			 * Dropdown Borders Color
			 */
			$wp_customize->add_setting( 'lumen_edd_cart_dropdown_borders', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#e6e6e6',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_cart_dropdown_borders', array(
				'label'	   				=> esc_html__( 'Dropdown Borders Color', 'lumen' ),
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' 				=> 'lumen_edd_cart_dropdown_borders',
				'priority' 				=> 10,
			) ) );

			/**
			 * Product Title Color
			 */
			$wp_customize->add_setting( 'lumen_edd_cart_dropdown_title_color', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_cart_dropdown_title_color', array(
				'label'	   				=> esc_html__( 'Product Title Color', 'lumen' ),
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' 				=> 'lumen_edd_cart_dropdown_title_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Price Color
			 */
			$wp_customize->add_setting( 'lumen_edd_cart_dropdown_price_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#57bf6d',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_cart_dropdown_price_color', array(
				'label'	   				=> esc_html__( 'Price Color', 'lumen' ),
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' 				=> 'lumen_edd_cart_dropdown_price_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Remove Link Color
			 */
			$wp_customize->add_setting( 'lumen_edd_cart_dropdown_remove_link_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#b3b3b3',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_cart_dropdown_remove_link_color', array(
				'label'	   				=> esc_html__( 'Remove Link Color', 'lumen' ),
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' 				=> 'lumen_edd_cart_dropdown_remove_link_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Remove Link Hover Color
			 */
			$wp_customize->add_setting( 'lumen_edd_cart_dropdown_remove_link_color_hover', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#13aff0',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_cart_dropdown_remove_link_color_hover', array(
				'label'	   				=> esc_html__( 'Remove Link Color: Hover', 'lumen' ),
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' 				=> 'lumen_edd_cart_dropdown_remove_link_color_hover',
				'priority' 				=> 10,
			) ) );

			/**
			 * Subtotal Background Color
			 */
			$wp_customize->add_setting( 'lumen_edd_cart_dropdown_subtotal_bg', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#fafafa',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_cart_dropdown_subtotal_bg', array(
				'label'	   				=> esc_html__( 'Subtotal Background Color', 'lumen' ),
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' 				=> 'lumen_edd_cart_dropdown_subtotal_bg',
				'priority' 				=> 10,
			) ) );

			/**
			 * Subtotal Border Color
			 */
			$wp_customize->add_setting( 'lumen_edd_cart_dropdown_subtotal_border_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#e6e6e6',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_cart_dropdown_subtotal_border_color', array(
				'label'	   				=> esc_html__( 'Subtotal Border Color', 'lumen' ),
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' 				=> 'lumen_edd_cart_dropdown_subtotal_border_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Subtotal Color
			 */
			$wp_customize->add_setting( 'lumen_edd_cart_dropdown_subtotal_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#797979',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_cart_dropdown_subtotal_color', array(
				'label'	   				=> esc_html__( 'Subtotal Color', 'lumen' ),
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' 				=> 'lumen_edd_cart_dropdown_subtotal_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Total Price Color
			 */
			$wp_customize->add_setting( 'lumen_edd_cart_dropdown_total_price_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#57bf6d',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_cart_dropdown_total_price_color', array(
				'label'	   				=> esc_html__( 'Total Price Color', 'lumen' ),
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' 				=> 'lumen_edd_cart_dropdown_total_price_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Checkout Button: Background Color
			 */
			$wp_customize->add_setting( 'lumen_edd_cart_dropdown_checkout_button_bg', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_cart_dropdown_checkout_button_bg', array(
				'label'	   				=> esc_html__( 'Checkout Button Background', 'lumen' ),
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' 				=> 'lumen_edd_cart_dropdown_checkout_button_bg',
				'priority' 				=> 10,
			) ) );

			/**
			 * Checkout Button Hover: Background Color
			 */
			$wp_customize->add_setting( 'lumen_edd_cart_dropdown_checkout_button_bg_hover', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_cart_dropdown_checkout_button_bg_hover', array(
				'label'	   				=> esc_html__( 'Checkout Button Background: Hover', 'lumen' ),
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' 				=> 'lumen_edd_cart_dropdown_checkout_button_bg_hover',
				'priority' 				=> 10,
			) ) );

			/**
			 * Checkout Button: Color
			 */
			$wp_customize->add_setting( 'lumen_edd_cart_dropdown_checkout_button_color', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_cart_dropdown_checkout_button_color', array(
				'label'	   				=> esc_html__( 'Checkout Button Color', 'lumen' ),
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' 				=> 'lumen_edd_cart_dropdown_checkout_button_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Checkout Button Hover: Color
			 */
			$wp_customize->add_setting( 'lumen_edd_cart_dropdown_checkout_button_hover_color', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_cart_dropdown_checkout_button_hover_color', array(
				'label'	   				=> esc_html__( 'Checkout Button Color: Hover', 'lumen' ),
				'section'  				=> 'lumen_edd_menu_cart',
				'settings' 				=> 'lumen_edd_cart_dropdown_checkout_button_hover_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'lumen_edd_archives' , array(
				'title' 			=> esc_html__( 'Archives', 'lumen' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Layout
			 */
			$wp_customize->add_setting( 'lumen_edd_archive_layout', array(
				'default'           	=> 'left-sidebar',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Radio_Image_Control( $wp_customize, 'lumen_edd_archive_layout', array(
				'label'	   				=> esc_html__( 'Layout', 'lumen' ),
				'section'  				=> 'lumen_edd_archives',
				'settings' 				=> 'lumen_edd_archive_layout',
				'priority' 				=> 10,
				'choices' 				=> lumenwp_customizer_layout(),
			) ) );

			/**
			 * Both Sidebars Style
			 */
			$wp_customize->add_setting( 'lumen_edd_archive_both_sidebars_style', array(
				'default'           	=> 'scs-style',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_edd_archive_both_sidebars_style', array(
				'label'	   				=> esc_html__( 'Both Sidebars: Style', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_edd_archives',
				'settings' 				=> 'lumen_edd_archive_both_sidebars_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'ssc-style' 		=> esc_html__( 'Sidebar / Sidebar / Content', 'lumen' ),
					'scs-style' 		=> esc_html__( 'Sidebar / Content / Sidebar', 'lumen' ),
					'css-style' 		=> esc_html__( 'Content / Sidebar / Sidebar', 'lumen' ),
				),
				'active_callback' 		=> 'lumenwp_cac_has_edd_archive_bs_layout',
			) ) );

			/**
			 * Both Sidebars Content Width
			 */
			$wp_customize->add_setting( 'lumen_edd_archive_both_sidebars_content_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_edd_archive_both_sidebars_content_width', array(
				'label'	   				=> esc_html__( 'Both Sidebars: Content Width (%)', 'lumen' ),
				'type' 					=> 'number',
				'section'  				=> 'lumen_edd_archives',
				'settings' 				=> 'lumen_edd_archive_both_sidebars_content_width',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
				'active_callback' 		=> 'lumenwp_cac_has_edd_archive_bs_layout',
			) ) );

			/**
			 * Both Sidebars Sidebars Width
			 */
			$wp_customize->add_setting( 'lumen_edd_archive_both_sidebars_sidebars_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_edd_archive_both_sidebars_sidebars_width', array(
				'label'	   				=> esc_html__( 'Both Sidebars: Sidebars Width (%)', 'lumen' ),
				'type' 					=> 'number',
				'section'  				=> 'lumen_edd_archives',
				'settings' 				=> 'lumen_edd_archive_both_sidebars_sidebars_width',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
				'active_callback' 		=> 'lumenwp_cac_has_edd_archive_bs_layout',
			) ) );

			/**
			 * Mobile Sidebar Order
			 */
			$wp_customize->add_setting( 'lumen_edd_archive_sidebar_order', array(
				'default'           	=> 'content-sidebar',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_edd_archive_sidebar_order', array(
				'label'	   				=> esc_html__( 'Mobile Sidebar Order', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_edd_archives',
				'settings' 				=> 'lumen_edd_archive_sidebar_order',
				'priority' 				=> 10,
				'choices' 				=> array(
					'content-sidebar' 	=> esc_html__( 'Content / Sidebar', 'lumen' ),
					'sidebar-content' 	=> esc_html__( 'Sidebar / Content', 'lumen' ),
				),
				'active_callback' 		=> 'lumenwp_cac_has_edd_archive_rl_layout',
			) ) );

			/**
			 * Shop Columns
			 */
			$wp_customize->add_setting( 'lumen_edd_archive_columns', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '3',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );

			$wp_customize->add_setting( 'lumen_edd_tablet_archive_columns', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_setting( 'lumen_edd_mobile_archive_columns', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Slider_Control( $wp_customize, 'lumen_edd_archive_columns', array(
				'label' 			=> esc_html__( 'Shop Columns', 'lumen' ),
				'section'  			=> 'lumen_edd_archives',
				'settings' => array(
		            'desktop' 	=> 'lumen_edd_archive_columns',
		            'tablet' 	=> 'lumen_edd_tablet_archive_columns',
		            'mobile' 	=> 'lumen_edd_mobile_archive_columns',
			    ),
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 1,
			        'max'   => 4,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Products Heading
			 */
			$wp_customize->add_setting( 'lumen_edd_archive_edds_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_edd_archive_edds_heading', array(
				'label'    				=> esc_html__( 'Products', 'lumen' ),
				'section'  				=> 'lumen_edd_archives',
				'priority' 				=> 10,
			) ) );

			/**
			 * Product Elements Positioning
			 */
			$wp_customize->add_setting( 'lumenwp_edd_archive_elements_positioning', array(
				'default' 				=> array( 'image', 'category', 'title', 'price', 'description' , 'button' ),
				'sanitize_callback' 	=> 'lumenwp_sanitize_multi_choices',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Sortable_Control( $wp_customize, 'lumenwp_edd_archive_elements_positioning', array(
				'label'	   				=> esc_html__( 'Elements Positioning', 'lumen' ),
				'section'  				=> 'lumen_edd_archives',
				'settings' 				=> 'lumenwp_edd_archive_elements_positioning',
				'priority' 				=> 10,
				'choices' 				=> array(
					'image'    			=> esc_html__( 'Image', 'lumen' ),
					'category'       	=> esc_html__( 'Category', 'lumen' ),
					'title' 			=> esc_html__( 'Title', 'lumen' ),
					'price' 		    => esc_html__( 'Price', 'lumen' ),
					'description' 		=> esc_html__( 'Description', 'lumen' ),
					'button' 			=> esc_html__( 'Add To Cart Button', 'lumen' ),
				),
			) ) );

			/**
			 * Product Entry Content Alignment
			 */
			$wp_customize->add_setting( 'lumen_edd_entry_content_alignment', array(
				'transport' 			=> 'postMessage',
				'default'           	=> 'center',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Buttonset_Control( $wp_customize, 'lumen_edd_entry_content_alignment', array(
				'label'	   				=> esc_html__( 'Content Alignment', 'lumen' ),
				'section'  				=> 'lumen_edd_archives',
				'settings' 				=> 'lumen_edd_entry_content_alignment',
				'priority' 				=> 10,
				'choices' 				=> array(
					'left' 		=> esc_html__( 'Left', 'lumen' ),
					'center' 	=> esc_html__( 'Center', 'lumen' ),
					'right' 	=> esc_html__( 'Right', 'lumen' ),
				),
			) ) );

			/**
			 * Variable Product Button
			 */
			$wp_customize->add_setting( 'lumen_edd_archive_variable_button', array(
				'transport' 			=> 'refresh',
				'default'           	=> 'button',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Buttonset_Control( $wp_customize, 'lumen_edd_archive_variable_button', array(
				'label'	   				=> esc_html__( 'Variable Product Button', 'lumen' ),
				'section'  				=> 'lumen_edd_archives',
				'settings' 				=> 'lumen_edd_archive_variable_button',
				'priority' 				=> 10,
				'choices' 				=> array(
					'button' 		=> esc_html__( 'Button', 'lumen' ),
					'options'		=> esc_html__( 'Options', 'lumen' ),
				),
			) ) );

			/**
			 * Image Width
			 */
			$wp_customize->add_setting( 'lumen_edd_archive_image_width', array(
				'default'               => 450,
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_edd_archive_image_width', array(
				'label'	   				=> esc_html__( 'Custom Image Width (px)', 'lumen' ),
				'type' 					=> 'number',
				'section'  				=> 'lumen_edd_archives',
				'settings' 				=> 'lumen_edd_archive_image_width',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min' => 0,
			    ),
			) ) );
			/**
			 * Image Height
			 */
			$wp_customize->add_setting( 'lumen_edd_archive_image_height', array(
				'default'               => 450,
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_edd_archive_image_height', array(
				'label'	   				=> esc_html__( 'Custom Image Height (px)', 'lumen' ),
				'type' 					=> 'number',
				'section'  				=> 'lumen_edd_archives',
				'settings' 				=> 'lumen_edd_archive_image_height',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min' => 0,
			    ),
			) ) );
			/**
			 * Download Excerpt Length
			 */
			$wp_customize->add_setting( 'lumen_edd_archive_excerpt_length', array(
				'default'           	=> 5,
				'sanitize_callback' 	=> false,
			) );
			$wp_customize->add_control( new lumenWP_Customizer_Range_Control( $wp_customize, 'lumen_edd_archive_excerpt_length', array(
				'label'	   				=> esc_html__( 'Excerpt Length', 'lumen' ),
				'section'  				=> 'lumen_edd_archives',
				'settings' 				=> 'lumen_edd_archive_excerpt_length',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 500,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'lumen_edd_single' , array(
				'title' 			=> esc_html__( 'Single Product', 'lumen' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Layout
			 */
			$wp_customize->add_setting( 'lumen_edd_download_layout', array(
				'default'           	=> 'left-sidebar',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Radio_Image_Control( $wp_customize, 'lumen_edd_download_layout', array(
				'label'	   				=> esc_html__( 'Layout', 'lumen' ),
				'section'  				=> 'lumen_edd_single',
				'settings' 				=> 'lumen_edd_download_layout',
				'priority' 				=> 10,
				'choices' 				=> lumenwp_customizer_layout(),
			) ) );

			/**
			 * Both Sidebars Style
			 */
			$wp_customize->add_setting( 'lumen_edd_download_both_sidebars_style', array(
				'default'           	=> 'scs-style',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_edd_download_both_sidebars_style', array(
				'label'	   				=> esc_html__( 'Both Sidebars: Style', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_edd_single',
				'settings' 				=> 'lumen_edd_download_both_sidebars_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'ssc-style' 		=> esc_html__( 'Sidebar / Sidebar / Content', 'lumen' ),
					'scs-style' 		=> esc_html__( 'Sidebar / Content / Sidebar', 'lumen' ),
					'css-style' 		=> esc_html__( 'Content / Sidebar / Sidebar', 'lumen' ),
				),
				'active_callback' 		=> 'lumenwp_cac_has_edd_download_bs_layout',
			) ) );

			/**
			 * Both Sidebars Content Width
			 */
			$wp_customize->add_setting( 'lumen_edd_download_both_sidebars_content_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_edd_download_both_sidebars_content_width', array(
				'label'	   				=> esc_html__( 'Both Sidebars: Content Width (%)', 'lumen' ),
				'type' 					=> 'number',
				'section'  				=> 'lumen_edd_single',
				'settings' 				=> 'lumen_edd_download_both_sidebars_content_width',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
				'active_callback' 		=> 'lumenwp_cac_has_edd_download_bs_layout',
			) ) );

			/**
			 * Both Sidebars Sidebars Width
			 */
			$wp_customize->add_setting( 'lumen_edd_download_both_sidebars_sidebars_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_edd_download_both_sidebars_sidebars_width', array(
				'label'	   				=> esc_html__( 'Both Sidebars: Sidebars Width (%)', 'lumen' ),
				'type' 					=> 'number',
				'section'  				=> 'lumen_edd_single',
				'settings' 				=> 'lumen_edd_download_both_sidebars_sidebars_width',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
				'active_callback' 		=> 'lumenwp_cac_has_edd_download_bs_layout',
			) ) );

			/**
			 * Mobile Sidebar Order
			 */
			$wp_customize->add_setting( 'lumen_edd_download_sidebar_order', array(
				'default'           	=> 'content-sidebar',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_edd_download_sidebar_order', array(
				'label'	   				=> esc_html__( 'Mobile Sidebar Order', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_edd_single',
				'settings' 				=> 'lumen_edd_download_sidebar_order',
				'priority' 				=> 10,
				'choices' 				=> array(
					'content-sidebar' 	=> esc_html__( 'Content / Sidebar', 'lumen' ),
					'sidebar-content' 	=> esc_html__( 'Sidebar / Content', 'lumen' ),
				),
				'active_callback' 		=> 'lumenwp_cac_has_edd_download_rl_layout',
			) ) );

			/**
			 * Display Product Navigation
			 */
			$wp_customize->add_setting( 'lumen_edd_display_navigation', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'lumenwp_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_edd_display_navigation', array(
				'label'	   				=> esc_html__( 'Display Product Navigation', 'lumen' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'lumen_edd_single',
				'settings' 				=> 'lumen_edd_display_navigation',
				'priority' 				=> 10,
			) ) );

			/**
			 * Display Purchase Button
			 */
			$wp_customize->add_setting( 'lumen_edd_display_add_to_cart', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'lumenwp_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_edd_display_add_to_cart', array(
				'label'	   				=> esc_html__( 'Display Add to Cart Button', 'lumen' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'lumen_edd_single',
				'settings' 				=> 'lumen_edd_display_add_to_cart',
				'priority' 				=> 10,
			) ) );

			/**
			 * Next/Prev Taxonomy
			 */
			$wp_customize->add_setting( 'lumen_edd_next_prev_taxonomy', array(
				'default' 				=> 'download_tag',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Buttonset_Control( $wp_customize, 'lumen_edd_next_prev_taxonomy', array(
				'label'	   				=> esc_html__( 'Next/Prev Taxonomy', 'lumen' ),
				'section'  				=> 'lumen_edd_single',
				'settings' 				=> 'lumen_edd_next_prev_taxonomy',
				'priority' 				=> 10,
				'choices' 				=> array(
					'download_category' => esc_html__( 'Category', 'lumen' ),
					'download_tag'      => esc_html__( 'Tag', 'lumen' ),
				),
			) ) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'lumen_edd_cart_checkout' , array(
				'title' 			=> esc_html__( 'Checkout Page', 'lumen' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Heading Checkout Page
			 */
			$wp_customize->add_setting( 'lumen_edd_checkout_page_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );
			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_edd_checkout_page_heading', array(
				'label'    				=> esc_html__( 'Checkout Page', 'lumen' ),
				'section'  				=> 'lumen_edd_cart_checkout',
				'priority' 				=> 10,
			) ) );

			/**
			 * Distraction Free Checkout
			 */
			$wp_customize->add_setting( 'lumen_edd_distraction_free_checkout', array(
				'default'           	=> false,
				'sanitize_callback' 	=> 'lumenwp_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_edd_distraction_free_checkout', array(
				'label'	   				=> esc_html__( 'Distraction Free Checkout', 'lumen' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'lumen_edd_cart_checkout',
				'settings' 				=> 'lumen_edd_distraction_free_checkout',
				'priority' 				=> 10,
			) ) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'lumen_edd_styling' , array(
				'title' 				=> esc_html__( 'Advanced Styling', 'lumen' ),
				'priority' 				=> 10,
				'panel' 				=> $panel,
			) );

			/**
			 * Heading Product Entry
			 */
			$wp_customize->add_setting( 'lumen_edd_entry_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_edd_entry_heading', array(
				'label'    				=> esc_html__( 'Product Entry', 'lumen' ),
				'section'  				=> 'lumen_edd_styling',
				'priority' 				=> 10,
			) ) );

			/**
			 * Product Padding
			 */
			$wp_customize->add_setting( 'lumen_edd_top_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_edd_right_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_edd_bottom_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_edd_left_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );

			$wp_customize->add_setting( 'lumen_edd_tablet_top_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_edd_tablet_right_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_edd_tablet_bottom_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_edd_tablet_left_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_setting( 'lumen_edd_mobile_top_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_edd_mobile_right_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_edd_mobile_bottom_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_edd_mobile_left_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Dimensions_Control( $wp_customize, 'lumen_edd_padding', array(
				'label'	   				=> esc_html__( 'Padding (px)', 'lumen' ),
				'section'  				=> 'lumen_edd_styling',				
				'settings'   => array(
		            'desktop_top' 		=> 'lumen_edd_top_padding',
		            'desktop_right' 	=> 'lumen_edd_right_padding',
		            'desktop_bottom' 	=> 'lumen_edd_bottom_padding',
		            'desktop_left' 		=> 'lumen_edd_left_padding',
		            'tablet_top' 		=> 'lumen_edd_tablet_top_padding',
		            'tablet_right' 		=> 'lumen_edd_tablet_right_padding',
		            'tablet_bottom' 	=> 'lumen_edd_tablet_bottom_padding',
		            'tablet_left' 		=> 'lumen_edd_tablet_left_padding',
		            'mobile_top' 		=> 'lumen_edd_mobile_top_padding',
		            'mobile_right' 		=> 'lumen_edd_mobile_right_padding',
		            'mobile_bottom' 	=> 'lumen_edd_mobile_bottom_padding',
		            'mobile_left' 		=> 'lumen_edd_mobile_left_padding',
				),
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Product Image Margin
			 */
			$wp_customize->add_setting( 'lumen_edd_image_top_margin', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_edd_image_right_margin', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_edd_image_bottom_margin', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_edd_image_left_margin', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );

			$wp_customize->add_setting( 'lumen_edd_image_tablet_top_margin', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_edd_image_tablet_right_margin', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_edd_image_tablet_bottom_margin', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_edd_image_tablet_left_margin', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_setting( 'lumen_edd_image_mobile_top_margin', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_edd_image_mobile_right_margin', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_edd_image_mobile_bottom_margin', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_edd_image_mobile_left_margin', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Dimensions_Control( $wp_customize, 'lumen_edd_image_margin', array(
				'label'	   				=> esc_html__( 'Image Margin (px)', 'lumen' ),
				'section'  				=> 'lumen_edd_styling',				
				'settings'   => array(
		            'desktop_top' 		=> 'lumen_edd_image_top_margin',
		            'desktop_right' 	=> 'lumen_edd_image_right_margin',
		            'desktop_bottom' 	=> 'lumen_edd_image_bottom_margin',
		            'desktop_left' 		=> 'lumen_edd_image_left_margin',
		            'tablet_top' 		=> 'lumen_edd_image_tablet_top_margin',
		            'tablet_right' 		=> 'lumen_edd_image_tablet_right_margin',
		            'tablet_bottom' 	=> 'lumen_edd_image_tablet_bottom_margin',
		            'tablet_left' 		=> 'lumen_edd_image_tablet_left_margin',
		            'mobile_top' 		=> 'lumen_edd_image_mobile_top_margin',
		            'mobile_right' 		=> 'lumen_edd_image_mobile_right_margin',
		            'mobile_bottom' 	=> 'lumen_edd_image_mobile_bottom_margin',
		            'mobile_left' 		=> 'lumen_edd_image_mobile_left_margin',
				),
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Product Border Width
			 */
			$wp_customize->add_setting( 'lumen_edd_top_border_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_edd_right_border_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_edd_bottom_border_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_edd_left_border_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );

			$wp_customize->add_setting( 'lumen_edd_tablet_top_border_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_edd_tablet_right_border_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_edd_tablet_bottom_border_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_edd_tablet_left_border_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_setting( 'lumen_edd_mobile_top_border_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_edd_mobile_right_border_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_edd_mobile_bottom_border_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_edd_mobile_left_border_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Dimensions_Control( $wp_customize, 'lumen_edd_border_width', array(
				'label'	   				=> esc_html__( 'Border Width (px)', 'lumen' ),
				'section'  				=> 'lumen_edd_styling',				
				'settings'   => array(
		            'desktop_top' 		=> 'lumen_edd_top_border_width',
		            'desktop_right' 	=> 'lumen_edd_right_border_width',
		            'desktop_bottom' 	=> 'lumen_edd_bottom_border_width',
		            'desktop_left' 		=> 'lumen_edd_left_border_width',
		            'tablet_top' 		=> 'lumen_edd_tablet_top_border_width',
		            'tablet_right' 		=> 'lumen_edd_tablet_right_border_width',
		            'tablet_bottom' 	=> 'lumen_edd_tablet_bottom_border_width',
		            'tablet_left' 		=> 'lumen_edd_tablet_left_border_width',
		            'mobile_top' 		=> 'lumen_edd_mobile_top_border_width',
		            'mobile_right' 		=> 'lumen_edd_mobile_right_border_width',
		            'mobile_bottom' 	=> 'lumen_edd_mobile_bottom_border_width',
		            'mobile_left' 		=> 'lumen_edd_mobile_left_border_width',
				),
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Product Border Radius
			 */
			$wp_customize->add_setting( 'lumen_edd_top_border_radius', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_edd_right_border_radius', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_edd_bottom_border_radius', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_edd_left_border_radius', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );

			$wp_customize->add_setting( 'lumen_edd_tablet_top_border_radius', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_edd_tablet_right_border_radius', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_edd_tablet_bottom_border_radius', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_edd_tablet_left_border_radius', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_setting( 'lumen_edd_mobile_top_border_radius', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_edd_mobile_right_border_radius', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_edd_mobile_bottom_border_radius', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_edd_mobile_left_border_radius', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Dimensions_Control( $wp_customize, 'lumen_edd_border_radius', array(
				'label'	   				=> esc_html__( 'Border Radius (px)', 'lumen' ),
				'section'  				=> 'lumen_edd_styling',				
				'settings'   => array(
		            'desktop_top' 		=> 'lumen_edd_top_border_radius',
		            'desktop_right' 	=> 'lumen_edd_right_border_radius',
		            'desktop_bottom' 	=> 'lumen_edd_bottom_border_radius',
		            'desktop_left' 		=> 'lumen_edd_left_border_radius',
		            'tablet_top' 		=> 'lumen_edd_tablet_top_border_radius',
		            'tablet_right' 		=> 'lumen_edd_tablet_right_border_radius',
		            'tablet_bottom' 	=> 'lumen_edd_tablet_bottom_border_radius',
		            'tablet_left' 		=> 'lumen_edd_tablet_left_border_radius',
		            'mobile_top' 		=> 'lumen_edd_mobile_top_border_radius',
		            'mobile_right' 		=> 'lumen_edd_mobile_right_border_radius',
		            'mobile_bottom' 	=> 'lumen_edd_mobile_bottom_border_radius',
		            'mobile_left' 		=> 'lumen_edd_mobile_left_border_radius',
				),
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 200,
			        'step'  => 1,
			    ),
			) ) );

			/**
		     * Background Color
		     */
	        $wp_customize->add_setting( 'lumen_edd_background_color', array(
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_background_color', array(
				'label'					=> esc_html__( 'Background Color', 'lumen' ),
				'section'				=> 'lumen_edd_styling',
				'settings'				=> 'lumen_edd_background_color',
				'priority'				=> 10
			) ) );

			/**
		     * Border Color
		     */
	        $wp_customize->add_setting( 'lumen_edd_border_color', array(
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_border_color', array(
				'label'					=> esc_html__( 'Border Color', 'lumen' ),
				'section'				=> 'lumen_edd_styling',
				'settings'				=> 'lumen_edd_border_color',
				'priority'				=> 10
			) ) );

			/**
		     * Category Color
		     */
	        $wp_customize->add_setting( 'lumen_edd_category_color', array(
				'default'				=> '#999999',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_category_color', array(
				'label'					=> esc_html__( 'Category Color', 'lumen' ),
				'section'				=> 'lumen_edd_styling',
				'settings'				=> 'lumen_edd_category_color',
				'priority'				=> 10
			) ) );

			/**
		     * Category Color Hover
		     */
	        $wp_customize->add_setting( 'lumen_edd_category_color_hover', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_category_color_hover', array(
				'label'					=> esc_html__( 'Category Color: Hover', 'lumen' ),
				'section'				=> 'lumen_edd_styling',
				'settings'				=> 'lumen_edd_category_color_hover',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Title Color
		     */
	        $wp_customize->add_setting( 'lumen_edd_title_color', array(
				'default'				=> '#333333',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_title_color', array(
				'label'					=> esc_html__( 'Title Color', 'lumen' ),
				'section'				=> 'lumen_edd_styling',
				'settings'				=> 'lumen_edd_title_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Title Color Hover
		     */
	        $wp_customize->add_setting( 'lumen_edd_title_color_hover', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_title_color_hover', array(
				'label'					=> esc_html__( 'Title Color: Hover', 'lumen' ),
				'section'				=> 'lumen_edd_styling',
				'settings'				=> 'lumen_edd_title_color_hover',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Price Color
		     */
	        $wp_customize->add_setting( 'lumen_edd_entry_price_color', array(
				'default'				=> '#57bf6d',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_entry_price_color', array(
				'label'					=> esc_html__( 'Price Color', 'lumen' ),
				'section'				=> 'lumen_edd_styling',
				'settings'				=> 'lumen_edd_entry_price_color',
				'priority'				=> 10,
			) ) );

			/**
			 * Heading Product Entry Add To Cart
			 */
			$wp_customize->add_setting( 'lumen_edd_entry_addtocart_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_edd_entry_addtocart_heading', array(
				'label'    				=> esc_html__( 'Product Entry: Add To Cart', 'lumen' ),
				'section'  				=> 'lumen_edd_styling',
				'priority' 				=> 10,
			) ) );

			/**
		     * Product Entry Add To Cart Background Color
		     */
	        $wp_customize->add_setting( 'lumen_edd_entry_addtocart_bg_color', array(
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_entry_addtocart_bg_color', array(
				'label'					=> esc_html__( 'Add To Cart Background Color', 'lumen' ),
				'section'				=> 'lumen_edd_styling',
				'settings'				=> 'lumen_edd_entry_addtocart_bg_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Add To Cart Background Color Hover
		     */
	        $wp_customize->add_setting( 'lumen_edd_entry_addtocart_bg_color_hover', array(
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_entry_addtocart_bg_color_hover', array(
				'label'					=> esc_html__( 'Add To Cart Background Color: Hover', 'lumen' ),
				'section'				=> 'lumen_edd_styling',
				'settings'				=> 'lumen_edd_entry_addtocart_bg_color_hover',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Add To Cart Color
		     */
	        $wp_customize->add_setting( 'lumen_edd_entry_addtocart_color', array(
				'default'				=> '#848494',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_entry_addtocart_color', array(
				'label'					=> esc_html__( 'Add To Cart Color', 'lumen' ),
				'section'				=> 'lumen_edd_styling',
				'settings'				=> 'lumen_edd_entry_addtocart_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Add To Cart Color Hover
		     */
	        $wp_customize->add_setting( 'lumen_edd_entry_addtocart_color_hover', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_entry_addtocart_color_hover', array(
				'label'					=> esc_html__( 'Add To Cart Color: Hover', 'lumen' ),
				'section'				=> 'lumen_edd_styling',
				'settings'				=> 'lumen_edd_entry_addtocart_color_hover',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Add To Cart Border Color
		     */
	        $wp_customize->add_setting( 'lumen_edd_entry_addtocart_border_color', array(
				'default'				=> '#e4e4e4',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_entry_addtocart_border_color', array(
				'label'					=> esc_html__( 'Add To Cart Border Color', 'lumen' ),
				'section'				=> 'lumen_edd_styling',
				'settings'				=> 'lumen_edd_entry_addtocart_border_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Add To Cart Border Color Hover
		     */
	        $wp_customize->add_setting( 'lumen_edd_entry_addtocart_border_color_hover', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_entry_addtocart_border_color_hover', array(
				'label'					=> esc_html__( 'Add To Cart Border Color: Hover', 'lumen' ),
				'section'				=> 'lumen_edd_styling',
				'settings'				=> 'lumen_edd_entry_addtocart_border_color_hover',
				'priority'				=> 10,
			) ) );

			/**
			 * Product Entry Add To Cart Border Style
			 */
			$wp_customize->add_setting( 'lumen_edd_entry_addtocart_border_style', array(
				'default'           	=> 'double',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_edd_entry_addtocart_border_style', array(
				'label'	   				=> esc_html__( 'Add To Cart Border: Style', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_edd_styling',
				'settings' 				=> 'lumen_edd_entry_addtocart_border_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'none' 			=> esc_html__( 'None', 'lumen' ),
					'solid' 		=> esc_html__( 'Solid', 'lumen' ),
					'double' 		=> esc_html__( 'Double', 'lumen' ),
					'dashed' 		=> esc_html__( 'Dashed', 'lumen' ),
					'dotted' 		=> esc_html__( 'Dotted', 'lumen' ),
				),
			) ) );

			/**
		     * Product Entry Add To Cart Border Size
		     */
			$wp_customize->add_setting( 'lumen_edd_entry_addtocart_border_size', array(
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'wp_kses_post',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_edd_entry_addtocart_border_size', array(
				'label'	   				=> esc_html__( 'Add To Cart Border: Size', 'lumen' ),
				'description' 			=> esc_html__( 'Add a custom border size. px - em - %.', 'lumen' ),
				'type' 					=> 'text',
				'section'  				=> 'lumen_edd_styling',
				'settings' 				=> 'lumen_edd_entry_addtocart_border_size',
				'priority' 				=> 10,
			) ) );

			/**
		     * Product Entry Add To Cart Border Radius
		     */
			$wp_customize->add_setting( 'lumen_edd_entry_addtocart_border_radius', array(
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'wp_kses_post',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_edd_entry_addtocart_border_radius', array(
				'label'	   				=> esc_html__( 'Add To Cart Border: Radius', 'lumen' ),
				'description' 			=> esc_html__( 'Add a custom border radius. px - em - %.', 'lumen' ),
				'type' 					=> 'text',
				'section'  				=> 'lumen_edd_styling',
				'settings' 				=> 'lumen_edd_entry_addtocart_border_radius',
				'priority' 				=> 10,
			) ) );

			/**
			 * Heading Single Product
			 */
			$wp_customize->add_setting( 'lumen_single_edd_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_single_edd_heading', array(
				'label'    				=> esc_html__( 'Single Product', 'lumen' ),
				'section'  				=> 'lumen_edd_styling',
				'priority' 				=> 10,
			) ) );

			/**
		     * Single Product Title Color
		     */
	        $wp_customize->add_setting( 'lumen_single_edd_title_color', array(
				'default'				=> '#333333',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_single_edd_title_color', array(
				'label'					=> esc_html__( 'Title Color', 'lumen' ),
				'section'				=> 'lumen_edd_styling',
				'settings'				=> 'lumen_single_edd_title_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Description Color
		     */
	        $wp_customize->add_setting( 'lumen_single_edd_description_color', array(
				'default'				=> '#aaaaaa',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_single_edd_description_color', array(
				'label'					=> esc_html__( 'Description Color', 'lumen' ),
				'section'				=> 'lumen_edd_styling',
				'settings'				=> 'lumen_single_edd_description_color',
				'priority'				=> 10,
			) ) );

			/**
			 * Heading Checkout
			 */
			$wp_customize->add_setting( 'lumen_checkout_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_checkout_heading', array(
				'label'    				=> esc_html__( 'Checkout', 'lumen' ),
				'section'  				=> 'lumen_edd_styling',
				'priority' 				=> 10,
			) ) );

			/**
		     * Titles Color
		     */
	        $wp_customize->add_setting( 'lumen_edd_checkout_titles_color', array(
				'default'				=> '#222',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_checkout_titles_color', array(
				'label'					=> esc_html__( 'Titles Color', 'lumen' ),
				'section'				=> 'lumen_edd_styling',
				'settings'				=> 'lumen_edd_checkout_titles_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Titles Border Bottom Color
		     */
	        $wp_customize->add_setting( 'lumen_edd_checkout_titles_border_bottom_color', array(
				'default'				=> '#e5e5e5',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_checkout_titles_border_bottom_color', array(
				'label'					=> esc_html__( 'Titles Border Bottom Color', 'lumen' ),
				'section'				=> 'lumen_edd_styling',
				'settings'				=> 'lumen_edd_checkout_titles_border_bottom_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Borders Color
		     */
	        $wp_customize->add_setting( 'lumen_edd_checkout_borders_color', array(
				'default'				=> '#eee',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_checkout_borders_color', array(
				'label'					=> esc_html__( 'Borders Color', 'lumen' ),
				'section'				=> 'lumen_edd_styling',
				'settings'				=> 'lumen_edd_checkout_borders_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Label Color
		     */
	        $wp_customize->add_setting( 'lumen_edd_checkout_label_color', array(
				'default'				=> '#929292',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_checkout_label_color', array(
				'label'					=> esc_html__( 'Label Color', 'lumen' ),
				'section'				=> 'lumen_edd_styling',
				'settings'				=> 'lumen_edd_checkout_label_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Description Color
		     */
	        $wp_customize->add_setting( 'lumen_edd_checkout_description_color', array(
				'default'				=> '#666',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_checkout_description_color', array(
				'label'					=> esc_html__( 'Description Color', 'lumen' ),
				'section'				=> 'lumen_edd_styling',
				'settings'				=> 'lumen_edd_checkout_description_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Head Background
		     */
	        $wp_customize->add_setting( 'lumen_edd_checkout_head_bg', array(
				'default'				=> '#fafafa',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_checkout_head_bg', array(
				'label'					=> esc_html__( 'Head Background', 'lumen' ),
				'section'				=> 'lumen_edd_styling',
				'settings'				=> 'lumen_edd_checkout_head_bg',
				'priority'				=> 10,
			) ) );

			/**
		     * Head Titles Color
		     */
	        $wp_customize->add_setting( 'lumen_edd_checkout_head_titles_color', array(
				'default'				=> '#666',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_checkout_head_titles_color', array(
				'label'					=> esc_html__( 'Head Titles Color', 'lumen' ),
				'section'				=> 'lumen_edd_styling',
				'settings'				=> 'lumen_edd_checkout_head_titles_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Cart Totals Table Titles Color
		     */
	        $wp_customize->add_setting( 'lumen_edd_checkout_totals_table_titles_color', array(
				'default'				=> '#666',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_checkout_totals_table_titles_color', array(
				'label'					=> esc_html__( 'Cart Totals Table: Titles Color', 'lumen' ),
				'section'				=> 'lumen_edd_styling',
				'settings'				=> 'lumen_edd_checkout_totals_table_titles_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Remove Button Color
		     */
	        $wp_customize->add_setting( 'lumen_edd_checkout_remove_button_color', array(
				'default'				=> '#333',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );
			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_checkout_remove_button_color', array(
				'label'					=> esc_html__( 'Remove Button Color', 'lumen' ),
				'section'				=> 'lumen_edd_styling',
				'settings'				=> 'lumen_edd_checkout_remove_button_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Remove Button Color Hover
		     */
	        $wp_customize->add_setting( 'lumen_edd_checkout_remove_button_color_hover', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_edd_checkout_remove_button_color_hover', array(
				'label'					=> esc_html__( 'Remove Button Color: Hover', 'lumen' ),
				'section'				=> 'lumen_edd_styling',
				'settings'				=> 'lumen_edd_checkout_remove_button_color_hover',
				'priority'				=> 10,
			) ) );

		}

		/**
		 * Get CSS
		 *
		 * @since 1.0.0
		 */
		public static function head_css( $output ) {
		
			// Global vars
			$menu_icon_size										= get_theme_mod( 'lumen_edd_menu_icon_size' );
			$menu_icon_size_tablet								= get_theme_mod( 'lumen_edd_menu_icon_size_tablet' );
			$menu_icon_size_mobile								= get_theme_mod( 'lumen_edd_menu_icon_size_mobile' );
			$menu_icon_center_vertically						= get_theme_mod( 'lumen_edd_menu_icon_center_vertically' );
			$menu_icon_center_vertically_tablet					= get_theme_mod( 'lumen_edd_menu_icon_center_vertically_tablet' );
			$menu_icon_center_vertically_mobile					= get_theme_mod( 'lumen_edd_menu_icon_center_vertically_mobile' );
			$cart_dropdown_width 								= get_theme_mod( 'lumen_edd_cart_dropdown_width', '350' );
			$edd_menu_bag_icon_color 							= get_theme_mod( 'lumen_edd_menu_bag_icon_color', '#333333' );
			$edd_menu_bag_icon_hover_color 						= get_theme_mod( 'lumen_edd_menu_bag_icon_hover_color', '#13aff0' );
			$edd_menu_bag_icon_count_color 						= get_theme_mod( 'lumen_edd_menu_bag_icon_count_color', '#333333' );
			$edd_menu_bag_icon_hover_count_color 				= get_theme_mod( 'lumen_edd_menu_bag_icon_hover_count_color', '#ffffff' );
			$cart_dropdown_bg 									= get_theme_mod( 'lumen_edd_cart_dropdown_bg', '#ffffff' );
			$cart_dropdown_borders 								= get_theme_mod( 'lumen_edd_cart_dropdown_borders', '#e6e6e6' );
			$cart_dropdown_title_color 							= get_theme_mod( 'lumen_edd_cart_dropdown_title_color' );
			$cart_dropdown_price_color							= get_theme_mod( 'lumen_edd_cart_dropdown_price_color', '#57bf6d' );
			$cart_dropdown_remove_link_color					= get_theme_mod( 'lumen_edd_cart_dropdown_remove_link_color', '#b3b3b3' );
			$cart_dropdown_remove_link_color_hover				= get_theme_mod( 'lumen_edd_cart_dropdown_remove_link_color_hover', '#13aff0' );
			$cart_dropdown_subtotal_bg							= get_theme_mod( 'lumen_edd_cart_dropdown_subtotal_bg', '#fafafa' );
			$cart_dropdown_subtotal_border_color				= get_theme_mod( 'lumen_edd_cart_dropdown_subtotal_border_color', '#e6e6e6' );
			$cart_dropdown_subtotal_color						= get_theme_mod( 'lumen_edd_cart_dropdown_subtotal_color', '#797979' );
			$cart_dropdown_total_price_color					= get_theme_mod( 'lumen_edd_cart_dropdown_total_price_color', '#57bf6d' );
			$cart_dropdown_checkout_button_bg					= get_theme_mod( 'lumen_edd_cart_dropdown_checkout_button_bg' );
			$cart_dropdown_checkout_button_hover_bg				= get_theme_mod( 'lumen_edd_cart_dropdown_checkout_button_bg_hover' );
			$cart_dropdown_checkout_button_color				= get_theme_mod( 'lumen_edd_cart_dropdown_checkout_button_color' );
			$cart_dropdown_checkout_button_hover_color			= get_theme_mod( 'lumen_edd_cart_dropdown_checkout_button_hover_color' );
		
			// Styling vars
			$edd_top_padding 								= get_theme_mod( 'lumen_edd_top_padding' );
			$edd_right_padding 								= get_theme_mod( 'lumen_edd_right_padding' );
			$edd_bottom_padding 							= get_theme_mod( 'lumen_edd_bottom_padding' );
			$edd_left_padding 								= get_theme_mod( 'lumen_edd_left_padding' );
			$tablet_edd_top_padding 						= get_theme_mod( 'lumen_edd_tablet_top_padding' );
			$tablet_edd_right_padding 						= get_theme_mod( 'lumen_edd_tablet_right_padding' );
			$tablet_edd_bottom_padding 						= get_theme_mod( 'lumen_edd_tablet_bottom_padding' );
			$tablet_edd_left_padding 						= get_theme_mod( 'lumen_edd_tablet_left_padding' );
			$mobile_edd_top_padding 						= get_theme_mod( 'lumen_edd_mobile_top_padding' );
			$mobile_edd_right_padding 						= get_theme_mod( 'lumen_edd_mobile_right_padding' );
			$mobile_edd_bottom_padding 						= get_theme_mod( 'lumen_edd_mobile_bottom_padding' );
			$mobile_edd_left_padding 						= get_theme_mod( 'lumen_edd_mobile_left_padding' );
			$edd_image_top_margin 							= get_theme_mod( 'lumen_edd_image_top_margin' );
			$edd_image_right_margin 						= get_theme_mod( 'lumen_edd_image_right_margin' );
			$edd_image_bottom_margin 						= get_theme_mod( 'lumen_edd_image_bottom_margin' );
			$edd_image_left_margin 							= get_theme_mod( 'lumen_edd_image_left_margin' );
			$tablet_edd_image_top_margin 					= get_theme_mod( 'lumen_edd_image_tablet_top_margin' );
			$tablet_edd_image_right_margin 					= get_theme_mod( 'lumen_edd_image_tablet_right_margin' );
			$tablet_edd_image_bottom_margin 				= get_theme_mod( 'lumen_edd_image_tablet_bottom_margin' );
			$tablet_edd_image_left_margin 					= get_theme_mod( 'lumen_edd_image_tablet_left_margin' );
			$mobile_edd_image_top_margin 					= get_theme_mod( 'lumen_edd_image_mobile_top_margin' );
			$mobile_edd_image_right_margin 					= get_theme_mod( 'lumen_edd_image_mobile_right_margin' );
			$mobile_edd_image_bottom_margin 				= get_theme_mod( 'lumen_edd_image_mobile_bottom_margin' );
			$mobile_edd_image_left_margin 					= get_theme_mod( 'lumen_edd_image_mobile_left_margin' );
			$edd_top_border_width 							= get_theme_mod( 'lumen_edd_top_border_width' );
			$edd_right_border_width 						= get_theme_mod( 'lumen_edd_right_border_width' );
			$edd_bottom_border_width 						= get_theme_mod( 'lumen_edd_bottom_border_width' );
			$edd_left_border_width 							= get_theme_mod( 'lumen_edd_left_border_width' );
			$tablet_edd_top_border_width 					= get_theme_mod( 'lumen_edd_tablet_top_border_width' );
			$tablet_edd_right_border_width 					= get_theme_mod( 'lumen_edd_tablet_right_border_width' );
			$tablet_edd_bottom_border_width 				= get_theme_mod( 'lumen_edd_tablet_bottom_border_width' );
			$tablet_edd_left_border_width 					= get_theme_mod( 'lumen_edd_tablet_left_border_width' );
			$mobile_edd_top_border_width 					= get_theme_mod( 'lumen_edd_mobile_top_border_width' );
			$mobile_edd_right_border_width 					= get_theme_mod( 'lumen_edd_mobile_right_border_width' );
			$mobile_edd_bottom_border_width 				= get_theme_mod( 'lumen_edd_mobile_bottom_border_width' );
			$mobile_edd_left_border_width 					= get_theme_mod( 'lumen_edd_mobile_left_border_width' );
			$edd_top_border_radius 							= get_theme_mod( 'lumen_edd_top_border_radius' );
			$edd_right_border_radius 						= get_theme_mod( 'lumen_edd_right_border_radius' );
			$edd_bottom_border_radius 						= get_theme_mod( 'lumen_edd_bottom_border_radius' );
			$edd_left_border_radius 						= get_theme_mod( 'lumen_edd_left_border_radius' );
			$tablet_edd_top_border_radius 					= get_theme_mod( 'lumen_edd_tablet_top_border_radius' );
			$tablet_edd_right_border_radius 				= get_theme_mod( 'lumen_edd_tablet_right_border_radius' );
			$tablet_edd_bottom_border_radius 				= get_theme_mod( 'lumen_edd_tablet_bottom_border_radius' );
			$tablet_edd_left_border_radius 					= get_theme_mod( 'lumen_edd_tablet_left_border_radius' );
			$mobile_edd_top_border_radius 					= get_theme_mod( 'lumen_edd_mobile_top_border_radius' );
			$mobile_edd_right_border_radius 				= get_theme_mod( 'lumen_edd_mobile_right_border_radius' );
			$mobile_edd_bottom_border_radius 				= get_theme_mod( 'lumen_edd_mobile_bottom_border_radius' );
			$mobile_edd_left_border_radius 					= get_theme_mod( 'lumen_edd_mobile_left_border_radius' );
			$edd_background_color 							= get_theme_mod( 'lumen_edd_background_color' );
			$edd_border_color 								= get_theme_mod( 'lumen_edd_border_color' );
			$category_color 								= get_theme_mod( 'lumen_edd_category_color', '#999999' );
			$category_color_hover 							= get_theme_mod( 'lumen_edd_category_color_hover', '#13aff0' );
			$edd_title_color 								= get_theme_mod( 'lumen_edd_title_color', '#333333' );
			$edd_title_color_hover 							= get_theme_mod( 'lumen_edd_title_color_hover', '#13aff0' );
			$edd_entry_price_color 							= get_theme_mod( 'lumen_edd_entry_price_color', '#57bf6d' );
			$edd_entry_addtocart_bg_color 					= get_theme_mod( 'lumen_edd_entry_addtocart_bg_color' );
			$edd_entry_addtocart_bg_color_hover 			= get_theme_mod( 'lumen_edd_entry_addtocart_bg_color_hover' );
			$edd_entry_addtocart_color 						= get_theme_mod( 'lumen_edd_entry_addtocart_color', '#848494' );
			$edd_entry_addtocart_color_hover 				= get_theme_mod( 'lumen_edd_entry_addtocart_color_hover', '#13aff0' );
			$edd_entry_addtocart_border_color 				= get_theme_mod( 'lumen_edd_entry_addtocart_border_color', '#e4e4e4' );
			$edd_entry_addtocart_border_color_hover 		= get_theme_mod( 'lumen_edd_entry_addtocart_border_color_hover', '#13aff0' );
			$edd_entry_addtocart_border_style 				= get_theme_mod( 'lumen_edd_entry_addtocart_border_style', 'double' );
			$edd_entry_addtocart_border_size 				= get_theme_mod( 'lumen_edd_entry_addtocart_border_size' );
			$edd_entry_addtocart_border_radius 				= get_theme_mod( 'lumen_edd_entry_addtocart_border_radius' );
			$single_edd_title_color 						= get_theme_mod( 'lumen_single_edd_title_color', '#333333' );
			$single_edd_description_color 					= get_theme_mod( 'lumen_single_edd_description_color', '#aaaaaa' );

			// Checkout
			$checkout_titles_color 								= get_theme_mod( 'lumen_edd_checkout_titles_color', '#222' );
			$checkout_titles_border_bottom_color 				= get_theme_mod( 'lumen_edd_checkout_titles_border_bottom_color', '#e5e5e5' );
			$checkout_borders_color                             = get_theme_mod( 'lumen_edd_checkout_borders_color' , '#eee' );
			$checkout_label_color                               = get_theme_mod( 'lumen_edd_checkout_label_color', '#929292' );
			$checkout_description_color                         = get_theme_mod( 'lumen_edd_checkout_description_color', '#666' );
			$checkout_head_bg                                   = get_theme_mod( 'lumen_edd_checkout_head_bg', '#fafafa' );
			$checkout_head_titles_color                         = get_theme_mod( 'lumen_edd_checkout_head_titles_color', '#666' );
			$checkout_totals_table_titles_color                 = get_theme_mod( 'lumen_edd_checkout_totals_table_titles_color' , '#666' );
			$checkout_remove_button_color                       = get_theme_mod( 'lumen_edd_checkout_remove_button_color', '#333' );
			$checkout_remove_button_color_hover                 = get_theme_mod( 'lumen_edd_checkout_remove_button_color_hover', '#13aff0' ); 

			// Both sidebars shop page layout
			$archives_layout 									= get_theme_mod( 'lumen_edd_archive_layout', 'left-sidebar' );
			$bs_archives_content_width 							= get_theme_mod( 'lumen_edd_archive_both_sidebars_content_width' );
			$bs_archives_sidebars_width 						= get_theme_mod( 'lumen_edd_archive_both_sidebars_sidebars_width' );

			// Both sidebars single edd layout
			$single_layout 										= get_theme_mod( 'lumen_edd_download_layout', 'left-sidebar' );
			$bs_single_content_width 							= get_theme_mod( 'lumen_edd_download_both_sidebars_content_width' );
			$bs_single_sidebars_width 							= get_theme_mod( 'lumen_edd_download_both_sidebars_sidebars_width' );

			// Define css var
			$css = '';

			// Menu cart icon size
			if ( ! empty( $menu_icon_size ) ) {
				$css .= '.eddmenucart i{font-size:'. $menu_icon_size .'px;}';
			}

			// Menu cart icon size tablet
			if ( ! empty( $menu_icon_size_tablet ) ) {
				$css .= '@media (max-width: 768px){.lumen-mobile-menu-icon a.eddmenucart{font-size:'. $menu_icon_size_tablet .'px;}}';
			}

			// Menu cart icon size mobile
			if ( ! empty( $menu_icon_size_mobile ) ) {
				$css .= '@media (max-width: 480px){.lumen-mobile-menu-icon a.eddmenucart{font-size:'. $menu_icon_size_mobile .'px;}}';
			}

			// Menu cart icon center vertically
			if ( ! empty( $menu_icon_center_vertically ) ) {
				$css .= '.eddmenucart i{top:'. $menu_icon_center_vertically .'px;}';
			}

			// Menu cart icon center vertically tablet
			if ( ! empty( $menu_icon_center_vertically_tablet ) ) {
				$css .= '@media (max-width: 768px){.lumen-mobile-menu-icon a.eddmenucart{top:'. $menu_icon_center_vertically_tablet .'px;}}';
			}

			// Menu cart icon center vertically mobile
			if ( ! empty( $menu_icon_center_vertically_mobile ) ) {
				$css .= '@media (max-width: 480px){.lumen-mobile-menu-icon a.eddmenucart{top:'. $menu_icon_center_vertically_mobile .'px;}}';
			}

			// Cart dropdown width
			if ( ! empty( $cart_dropdown_width ) && '350' != $cart_dropdown_width ) {
				$css .= '.current-shop-items-dropdown{width:'. $cart_dropdown_width .'px;}';
			}

			// Bag icon style color
			if ( ! empty( $edd_menu_bag_icon_color ) && '#333333' != $edd_menu_bag_icon_color ) {
				$css .= '.eddmenucart-cart-icon .eddmenucart-count{border-color:'. $edd_menu_bag_icon_color .';}';
				$css .= '.eddmenucart-cart-icon .eddmenucart-count:after{border-color:'. $edd_menu_bag_icon_color .';}';
			}

			// Bag icon style hover color
			if ( ! empty( $edd_menu_bag_icon_hover_color ) && '#13aff0' != $edd_menu_bag_icon_hover_color ) {
				$css .= '.bag-style:hover .eddmenucart-cart-icon .eddmenucart-count, .show-cart .eddmenucart-cart-icon .eddmenucart-count{background-color:'. $edd_menu_bag_icon_hover_color .'; border-color:'. $edd_menu_bag_icon_hover_color .';}';
				$css .= '.bag-style:hover .eddmenucart-cart-icon .eddmenucart-count:after, .show-cart .eddmenucart-cart-icon .eddmenucart-count:after{border-color:'. $edd_menu_bag_icon_hover_color .';}';
			}

			// Bag icon style count color
			if ( ! empty( $edd_menu_bag_icon_count_color ) && '#333333' != $edd_menu_bag_icon_count_color ) {
				$css .= '.eddmenucart-cart-icon .eddmenucart-count, .edd-menu-icon .eddmenucart-total span{color:'. $edd_menu_bag_icon_count_color .';}';
			}

			// Bag icon style hover count color
			if ( ! empty( $edd_menu_bag_icon_hover_count_color ) && '#ffffff' != $edd_menu_bag_icon_hover_count_color ) {
				$css .= '.bag-style:hover .eddmenucart-cart-icon .eddmenucart-count, .show-cart .eddmenucart-cart-icon .eddmenucart-count{color:'. $edd_menu_bag_icon_hover_count_color .';}';
			}

			// Cart dropdown background
			if ( ! empty( $cart_dropdown_bg ) && '#ffffff' != $cart_dropdown_bg ) {
				$css .= '.current-shop-items-dropdown{background-color:'. $cart_dropdown_bg .';}';
			}

			// Cart dropdown borders
			if ( ! empty( $cart_dropdown_borders ) && '#e6e6e6' != $cart_dropdown_borders ) {
				$css .= '.current-shop-items-dropdown .widget_edd_cart_widget li{border-color:'. $cart_dropdown_borders .';}';
			}

			// Cart dropdown product title color
			if ( ! empty( $cart_dropdown_title_color ) ) {
				$css .= '.current-shop-items-dropdown .widget_edd_cart_widget li .edd-cart-item-title{color:'. $cart_dropdown_title_color .';}';
			}

			// Cart dropdown price color
			if ( ! empty( $cart_dropdown_price_color ) && '#57bf6d' != $cart_dropdown_price_color ) {
				$css .= '.current-shop-items-dropdown .widget_edd_cart_widget li .edd-cart-item-price{color:'. $cart_dropdown_price_color .';}';
			}

			// Cart dropdown remove link color
			if ( ! empty( $cart_dropdown_remove_link_color ) && '#b3b3b3' != $cart_dropdown_remove_link_color ) {
				$css .= '.current-shop-items-dropdown .widget_edd_cart_widget ul.edd-cart li a.edd-remove-from-cart{color:'. $cart_dropdown_remove_link_color .';}';
			}

			// Cart dropdown remove link hover color
			if ( ! empty( $cart_dropdown_remove_link_color_hover ) && '#13aff0' != $cart_dropdown_remove_link_color_hover ) {
				$css .= '.current-shop-items-dropdown .widget_edd_cart_widget ul.edd-cart li a.edd-remove-from-cart:hover{color:'. $cart_dropdown_remove_link_color_hover .';}';
			}

			// Cart dropdown subtotal background color
			if ( ! empty( $cart_dropdown_subtotal_bg ) && '#fafafa' != $cart_dropdown_subtotal_bg ) {
				$css .= '.current-shop-items-dropdown .widget_edd_cart_widget li.edd_total{background-color:'. $cart_dropdown_subtotal_bg .';}';
			}

			// Cart dropdown subtotal borde color
			if ( ! empty( $cart_dropdown_subtotal_border_color ) && '#e6e6e6' != $cart_dropdown_subtotal_border_color ) {
				$css .= '.current-shop-items-dropdown .widget_edd_cart_widget li.edd_total{border-color:'. $cart_dropdown_subtotal_border_color .';}';
			}

			// Cart dropdown subtotal color
			if ( ! empty( $cart_dropdown_subtotal_color ) && '#797979' != $cart_dropdown_subtotal_color ) {
				$css .= '.current-shop-items-dropdown .widget_edd_cart_widget li.edd_total{color:'. $cart_dropdown_subtotal_color .';}';
			}

			// Cart dropdown total price color
			if ( ! empty( $cart_dropdown_total_price_color ) && '#57bf6d' != $cart_dropdown_total_price_color ) {
				$css .= '.current-shop-items-dropdown .widget_edd_cart_widget li.edd_total .cart-total{color:'. $cart_dropdown_total_price_color .';}';
			}

			// Cart dropdown checkout button background color
			if ( ! empty( $cart_dropdown_checkout_button_bg ) ) {
				$css .= '.current-shop-items-dropdown .widget_edd_cart_widget .edd_checkout a{background-color:'. $cart_dropdown_checkout_button_bg .';}';
			}

			// Cart dropdown checkout button hover background color
			if ( ! empty( $cart_dropdown_checkout_button_hover_bg ) ) {
				$css .= '.current-shop-items-dropdown .widget_edd_cart_widget .edd_checkout a:hover{background-color:'. $cart_dropdown_checkout_button_hover_bg .';}';
			}

			// Cart dropdown checkout button color
			if ( ! empty( $cart_dropdown_checkout_button_color ) ) {
				$css .= '.current-shop-items-dropdown .widget_edd_cart_widget .edd_checkout a{color:'. $cart_dropdown_checkout_button_color .';}';
			}

			// Cart dropdown checkout button hover color
			if ( ! empty( $cart_dropdown_checkout_button_hover_color ) ) {
				$css .= '.current-shop-items-dropdown .widget_edd_cart_widget .edd_checkout a:hover{color:'. $cart_dropdown_checkout_button_hover_color .';}';
			}

			// Product padding
			if ( isset( $edd_top_padding ) && '' != $edd_top_padding
				|| isset( $edd_right_padding ) && '' != $edd_right_padding
				|| isset( $edd_bottom_padding ) && '' != $edd_bottom_padding
				|| isset( $edd_left_padding ) && '' != $edd_left_padding ) {
				$css .= '.edd_downloads_list .edd_download_inner{padding:'. lumenwp_spacing_css( $edd_top_padding, $edd_right_padding, $edd_bottom_padding, $edd_left_padding ) .'}';
			}

			// Tablet edd padding
			if ( isset( $tablet_edd_top_padding ) && '' != $tablet_edd_top_padding
				|| isset( $tablet_edd_right_padding ) && '' != $tablet_edd_right_padding
				|| isset( $tablet_edd_bottom_padding ) && '' != $tablet_edd_bottom_padding
				|| isset( $tablet_edd_left_padding ) && '' != $tablet_edd_left_padding ) {
				$css .= '@media (max-width: 768px){.edd_downloads_list .edd_download_inner{padding:'. lumenwp_spacing_css( $tablet_edd_top_padding, $tablet_edd_right_padding, $tablet_edd_bottom_padding, $tablet_edd_left_padding ) .'}}';
			}

			// Mobile edd padding
			if ( isset( $mobile_edd_top_padding ) && '' != $mobile_edd_top_padding
				|| isset( $mobile_edd_right_padding ) && '' != $mobile_edd_right_padding
				|| isset( $mobile_edd_bottom_padding ) && '' != $mobile_edd_bottom_padding
				|| isset( $mobile_edd_left_padding ) && '' != $mobile_edd_left_padding ) {
				$css .= '@media (max-width: 480px){.edd_downloads_list .edd_download_inner{padding:'. lumenwp_spacing_css( $mobile_edd_top_padding, $mobile_edd_right_padding, $mobile_edd_bottom_padding, $mobile_edd_left_padding ) .'}}';
			}

			// Product image margin
			if ( isset( $edd_image_top_margin ) && '' != $edd_image_top_margin
				|| isset( $edd_image_right_margin ) && '' != $edd_image_right_margin
				|| isset( $edd_image_bottom_margin ) && '' != $edd_image_bottom_margin
				|| isset( $edd_image_left_margin ) && '' != $edd_image_left_margin ) {
				$css .= '.edd_downloads_list .edd_download_inner .edd_download_image{margin:'. lumenwp_spacing_css( $edd_image_top_margin, $edd_image_right_margin, $edd_image_bottom_margin, $edd_image_left_margin ) .'}';
			}

			// Tablet edd image margin
			if ( isset( $tablet_edd_image_top_margin ) && '' != $tablet_edd_image_top_margin
				|| isset( $tablet_edd_image_right_margin ) && '' != $tablet_edd_image_right_margin
				|| isset( $tablet_edd_image_bottom_margin ) && '' != $tablet_edd_image_bottom_margin
				|| isset( $tablet_edd_image_left_margin ) && '' != $tablet_edd_image_left_margin ) {
				$css .= '@media (max-width: 768px){.edd_downloads_list .edd_download_inner .edd_download_image{margin:'. lumenwp_spacing_css( $tablet_edd_image_top_margin, $tablet_edd_image_right_margin, $tablet_edd_image_bottom_margin, $tablet_edd_image_left_margin ) .'}}';
			}

			// Mobile edd image margin
			if ( isset( $mobile_edd_image_top_margin ) && '' != $mobile_edd_image_top_margin
				|| isset( $mobile_edd_image_right_margin ) && '' != $mobile_edd_image_right_margin
				|| isset( $mobile_edd_image_bottom_margin ) && '' != $mobile_edd_image_bottom_margin
				|| isset( $mobile_edd_image_left_margin ) && '' != $mobile_edd_image_left_margin ) {
				$css .= '@media (max-width: 480px){.edd_downloads_list .edd_download_inner .edd_download_image{margin:'. lumenwp_spacing_css( $mobile_edd_image_top_margin, $mobile_edd_image_right_margin, $mobile_edd_image_bottom_margin, $mobile_edd_image_left_margin ) .'}}';
			}

			// Product border style if border width
			if ( isset( $edd_top_border_width ) && '' != $edd_top_border_width
				|| isset( $edd_right_border_width ) && '' != $edd_right_border_width
				|| isset( $edd_bottom_border_width ) && '' != $edd_bottom_border_width
				|| isset( $edd_left_border_width ) && '' != $edd_left_border_width
				|| isset( $tablet_edd_top_border_width ) && '' != $tablet_edd_top_border_width
				|| isset( $tablet_edd_right_border_width ) && '' != $tablet_edd_right_border_width
				|| isset( $tablet_edd_bottom_border_width ) && '' != $tablet_edd_bottom_border_width
				|| isset( $tablet_edd_left_border_width ) && '' != $tablet_edd_left_border_width
				|| isset( $mobile_edd_top_border_width ) && '' != $mobile_edd_top_border_width
				|| isset( $mobile_edd_right_border_width ) && '' != $mobile_edd_right_border_width
				|| isset( $mobile_edd_bottom_border_width ) && '' != $mobile_edd_bottom_border_width
				|| isset( $mobile_edd_left_border_width ) && '' != $mobile_edd_left_border_width ) {
				$css .= '.edd_downloads_list .edd_download_inner{border-style: solid}';
			}

			// Product border width
			if ( isset( $edd_top_border_width ) && '' != $edd_top_border_width
				|| isset( $edd_right_border_width ) && '' != $edd_right_border_width
				|| isset( $edd_bottom_border_width ) && '' != $edd_bottom_border_width
				|| isset( $edd_left_border_width ) && '' != $edd_left_border_width ) {
				$css .= '.edd_downloads_list .edd_download_inner{border-width:'. lumenwp_spacing_css( $edd_top_border_width, $edd_right_border_width, $edd_bottom_border_width, $edd_left_border_width ) .'}';
			}

			// Tablet edd border width
			if ( isset( $tablet_edd_top_border_width ) && '' != $tablet_edd_top_border_width
				|| isset( $tablet_edd_right_border_width ) && '' != $tablet_edd_right_border_width
				|| isset( $tablet_edd_bottom_border_width ) && '' != $tablet_edd_bottom_border_width
				|| isset( $tablet_edd_left_border_width ) && '' != $tablet_edd_left_border_width ) {
				$css .= '@media (max-width: 768px){.edd_downloads_list .edd_download_inner{border-width:'. lumenwp_spacing_css( $tablet_edd_top_border_width, $tablet_edd_right_border_width, $tablet_edd_bottom_border_width, $tablet_edd_left_border_width ) .'}}';
			}

			// Mobile edd border width
			if ( isset( $mobile_edd_top_border_width ) && '' != $mobile_edd_top_border_width
				|| isset( $mobile_edd_right_border_width ) && '' != $mobile_edd_right_border_width
				|| isset( $mobile_edd_bottom_border_width ) && '' != $mobile_edd_bottom_border_width
				|| isset( $mobile_edd_left_border_width ) && '' != $mobile_edd_left_border_width ) {
				$css .= '@media (max-width: 480px){.edd_downloads_list .edd_download_inner{border-width:'. lumenwp_spacing_css( $mobile_edd_top_border_width, $mobile_edd_right_border_width, $mobile_edd_bottom_border_width, $mobile_edd_left_border_width ) .'}}';
			}

			// Product border radius
			if ( isset( $edd_top_border_radius ) && '' != $edd_top_border_radius
				|| isset( $edd_right_border_radius ) && '' != $edd_right_border_radius
				|| isset( $edd_bottom_border_radius ) && '' != $edd_bottom_border_radius
				|| isset( $edd_left_border_radius ) && '' != $edd_left_border_radius ) {
				$css .= '.edd_downloads_list .edd_download_inner{border-radius:'. lumenwp_spacing_css( $edd_top_border_radius, $edd_right_border_radius, $edd_bottom_border_radius, $edd_left_border_radius ) .'}';
			}

			// Tablet edd border radius
			if ( isset( $tablet_edd_top_border_radius ) && '' != $tablet_edd_top_border_radius
				|| isset( $tablet_edd_right_border_radius ) && '' != $tablet_edd_right_border_radius
				|| isset( $tablet_edd_bottom_border_radius ) && '' != $tablet_edd_bottom_border_radius
				|| isset( $tablet_edd_left_border_radius ) && '' != $tablet_edd_left_border_radius ) {
				$css .= '@media (max-width: 768px){.edd_downloads_list .edd_download_inner{border-radius:'. lumenwp_spacing_css( $tablet_edd_top_border_radius, $tablet_edd_right_border_radius, $tablet_edd_bottom_border_radius, $tablet_edd_left_border_radius ) .'}}';
			}

			// Mobile edd border radius
			if ( isset( $mobile_edd_top_border_radius ) && '' != $mobile_edd_top_border_radius
				|| isset( $mobile_edd_right_border_radius ) && '' != $mobile_edd_right_border_radius
				|| isset( $mobile_edd_bottom_border_radius ) && '' != $mobile_edd_bottom_border_radius
				|| isset( $mobile_edd_left_border_radius ) && '' != $mobile_edd_left_border_radius ) {
				$css .= '@media (max-width: 480px){.edd_downloads_list .edd_download_inner{border-radius:'. lumenwp_spacing_css( $mobile_edd_top_border_radius, $mobile_edd_right_border_radius, $mobile_edd_bottom_border_radius, $mobile_edd_left_border_radius ) .'}}';
			}

			// Add background color
			if ( ! empty( $edd_background_color ) ) {
				$css .= '.edd_downloads_list .edd_download_inner{background-color:'. $edd_background_color .';}';
			}

			// Add border color
			if ( ! empty( $edd_border_color ) ) {
				$css .= '.edd_downloads_list .edd_download_inner{border-color:'. $edd_border_color .';}';
			}

			// Add category color
			if ( ! empty( $category_color ) && '#999999' != $category_color ) {
				$css .= '.edd_downloads_list .edd_download_inner .edd_download_categories a{color:'. $category_color .';}';
			}

			// Add category color hover
			if ( ! empty( $category_color_hover ) && '#13aff0' != $category_color_hover ) {
				$css .= '.edd_downloads_list .edd_download_inner .edd_download_categories a:hover{color:'. $category_color_hover .';}';
			}

			// Add edd entry title color
			if ( ! empty( $edd_title_color ) && '#333333' != $edd_title_color ) {
				$css .= '.edd_downloads_list .edd_download_inner .edd_download_title a{color:'. $edd_title_color .';}';
			}

			// Add edd entry title color hover
			if ( ! empty( $edd_title_color_hover ) && '#13aff0' != $edd_title_color_hover ) {
				$css .= '.edd_downloads_list .edd_download_inner .edd_download_title a:hover{color:'. $edd_title_color_hover .';}';
			}

			// Add edd entry price color
			if ( ! empty( $edd_entry_price_color ) && '#57bf6d' != $edd_entry_price_color ) {
				$css .= '.edd_downloads_list .edd_download_inner span.edd_price, .edd_price_range_sep{color:'. $edd_entry_price_color .';}';
			}

			// Add edd entry add to cart background color
			if ( ! empty( $edd_entry_addtocart_bg_color ) ) {
				$css .= '.edd_downloads_list .edd_download_inner .button{background-color:'. $edd_entry_addtocart_bg_color .';}';
			}

			// Add edd entry add to cart background color hover
			if ( ! empty( $edd_entry_addtocart_bg_color_hover ) ) {
				$css .= '.edd_downloads_list .edd_download_inner .button:hover{background-color:'. $edd_entry_addtocart_bg_color_hover .';}';
			}

			// Add edd entry add to cart color
			if ( ! empty( $edd_entry_addtocart_color ) && '#848494' != $edd_entry_addtocart_color ) {
				$css .= '.edd_downloads_list .edd_download_inner .button{color:'. $edd_entry_addtocart_color .';}';
			}

			// Add edd entry add to cart color hover
			if ( ! empty( $edd_entry_addtocart_color_hover ) && '#13aff0' != $edd_entry_addtocart_color_hover ) {
				$css .= '.edd_downloads_list .edd_download_inner .button:hover{color:'. $edd_entry_addtocart_color_hover .';}';
			}

			// Add edd entry add to cart border color
			if ( ! empty( $edd_entry_addtocart_border_color ) && '#e4e4e4' != $edd_entry_addtocart_border_color ) {
				$css .= '.edd_downloads_list .edd_download_inner .button{border-color:'. $edd_entry_addtocart_border_color .';}';
			}

			// Add edd entry add to cart border color hover
			if ( ! empty( $edd_entry_addtocart_border_color_hover ) && '#13aff0' != $edd_entry_addtocart_border_color_hover ) {
				$css .= '.edd_downloads_list .edd_download_inner .button:hover{border-color:'. $edd_entry_addtocart_border_color_hover .';}';
			}

			// Add edd entry add to cart border style
			if ( ! empty( $edd_entry_addtocart_border_style ) && 'double' != $edd_entry_addtocart_border_style ) {
				$css .= '.edd_downloads_list .edd_download_inner .button{border-style:'. $edd_entry_addtocart_border_style .';}';
			}

			// Add edd entry add to cart border size
			if ( ! empty( $edd_entry_addtocart_border_size ) && '3' != $edd_entry_addtocart_border_size ) {
				$css .= '.edd_downloads_list .edd_download_inner .button{border-width:'. $edd_entry_addtocart_border_size .';}';
			}

			// Add edd entry add to cart border radius
			if ( ! empty( $edd_entry_addtocart_border_radius ) ) {
				$css .= '.edd_downloads_list .edd_download_inner .button{border-radius:'. $edd_entry_addtocart_border_radius .';}';
			}

			// Add single edd title color
			if ( ! empty( $single_edd_title_color ) && '#333333' != $single_edd_title_color ) {
				$css .= '.single-download .edd-download .edd_download_title{color:'. $single_edd_title_color .';}';
			}

			// Add single edd description color
			if ( ! empty( $single_edd_description_color ) && '#aaaaaa' != $single_edd_description_color ) {
				$css .= '.single-download .edd-download .edd_download_content{color:'. $single_edd_description_color .';}';
			}

			// Add checkout titles color
			if ( ! empty( $checkout_titles_color ) && '#222' != $checkout_titles_color ) {
				$css .= '#edd_checkout_form_wrap legend{color:'. $checkout_titles_color .';}';
			}

			// Add checkout notices titles border bottom color
			if ( ! empty( $checkout_titles_border_bottom_color ) && '#e5e5e5' != $checkout_titles_border_bottom_color ) {
				$css .= '#edd_checkout_form_wrap legend{border-color:'. $checkout_titles_border_bottom_color .';}';
			}

			// Add checkout borders color
			if ( ! empty( $checkout_borders_color ) && '#eee' != $checkout_borders_color ) {
				$css .= '#edd_checkout_cart th, #edd_checkout_cart td, #edd_checkout_form_wrap #edd-discount-code-wrap, #edd_checkout_form_wrap #edd_final_total_wrap, #edd_checkout_form_wrap #edd_show_discount, #edd_checkout_form_wrap fieldset{border-color:'. $checkout_borders_color .';}';
			}

			// Add checkout label color
			if ( ! empty( $checkout_label_color ) && '#929292' != $checkout_label_color ) {
				$css .= '#edd_checkout_form_wrap .edd-label{color:'. $checkout_label_color .';}';
			}

			// Add checkout description color
			if ( ! empty( $checkout_description_color ) && '#666' != $checkout_description_color ) {
				$css .= '#edd_checkout_form_wrap .edd-description{color:'. $checkout_description_color .';}';
			}

			// Add checkout head background
			if ( ! empty( $checkout_head_bg ) && '#fafafa' != $checkout_head_bg ) {
				$css .= '#edd_checkout_cart .edd_cart_header_row th, .edd-table tr th{background-color:'. $checkout_head_bg .';}';
			}

			// Add checkout head titles color
			if ( ! empty( $checkout_head_titles_color ) && '#666' != $checkout_head_titles_color ) {
				$css .= '#edd_checkout_cart .edd_cart_header_row th, .edd-table tr th{color:'. $checkout_head_titles_color .';}';
			}

			// Add checkout totals table titles color
			if ( ! empty( $checkout_totals_table_titles_color ) && '#666' != $checkout_totals_table_titles_color ) {
				$css .= '#edd_checkout_cart th.edd_cart_total{color:'. $checkout_totals_table_titles_color .';}';
			}

			// Add checkout remove button color
			if ( ! empty( $checkout_remove_button_color ) && '#333' != $checkout_remove_button_color ) {
				$css .= '#edd_checkout_cart a.edd_cart_remove_item_btn{color:'. $checkout_remove_button_color .';}';
			}

			// Add checkout remove button color hover
			if ( ! empty( $checkout_remove_button_color_hover ) && '#13aff0' != $checkout_remove_button_color_hover ) {
				$css .= '#edd_checkout_cart a.edd_cart_remove_item_btn:hover{color:'. $checkout_remove_button_color_hover .';}';
			}

			// If shop page Both Sidebars layout
			if ( 'both-sidebars' == $archives_layout ) {

				// Both Sidebars layout shop page content width
				if ( ! empty( $bs_archives_content_width ) ) {
					$css .=
						'@media only screen and (min-width: 960px){
							body.edd.archive.content-both-sidebars .content-area {width: '. $bs_archives_content_width .'%;}
							body.edd.archive.content-both-sidebars.scs-style .widget-area.sidebar-secondary,
							body.edd.archive.content-both-sidebars.ssc-style .widget-area {left: -'. $bs_archives_content_width .'%;}
						}';
				}

				// Both Sidebars layout shop page sidebars width
				if ( ! empty( $bs_archives_sidebars_width ) ) {
					$css .=
						'@media only screen and (min-width: 960px){
							body.edd.archive.content-both-sidebars .widget-area{width:'. $bs_archives_sidebars_width .'%;}
							body.edd.archive.content-both-sidebars.scs-style .content-area{left:'. $bs_archives_sidebars_width .'%;}
							body.edd.archive.content-both-sidebars.ssc-style .content-area{left:'. $bs_archives_sidebars_width * 2 .'%;}
						}';
				}

			}

			// If single edd Both Sidebars layout
			if ( 'both-sidebars' == $single_layout ) {

				// Both Sidebars layout single edd content width
				if ( ! empty( $bs_single_content_width ) ) {
					$css .=
						'@media only screen and (min-width: 960px){
							body.single-edd.content-both-sidebars .content-area {width: '. $bs_single_content_width .'%;}
							body.single-edd.content-both-sidebars.scs-style .widget-area.sidebar-secondary,
							body.single-edd.content-both-sidebars.ssc-style .widget-area {left: -'. $bs_single_content_width .'%;}
						}';
				}

				// Both Sidebars layout single edd sidebars width
				if ( ! empty( $bs_single_sidebars_width ) ) {
					$css .=
						'@media only screen and (min-width: 960px){
							body.single-edd.content-both-sidebars .widget-area{width:'. $bs_single_sidebars_width .'%;}
							body.single-edd.content-both-sidebars.scs-style .content-area{left:'. $bs_single_sidebars_width .'%;}
							body.single-edd.content-both-sidebars.ssc-style .content-area{left:'. $bs_single_sidebars_width * 2 .'%;}
						}';
				}

			}
				
			// Return CSS
			if ( ! empty( $css ) ) {
				$output .= '/* EDD CSS */'. $css;
			}

			// Return output css
			return $output;

		}

	}

endif;

return new lumenWP_EDD_Customizer();