<?php
/**
 * WooCommerce Customizer Options
 *
 * @package LumenWP WordPress theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'lumenWP_WooCommerce_Customizer' ) ) :

	class lumenWP_WooCommerce_Customizer {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {

			add_action( 'customize_register', 	array( $this, 'customizer_options' ) );
			add_filter( 'lumen_head_css', 		array( $this, 'head_css' ) );

		}

		/**Display Featured Image
		 * Customizer options
		 *
		 * @since 1.0.0
		 */
		public function customizer_options( $wp_customize ) {

			/**
			 * Panel
			 */
			$panel = 'lumen_woocommerce_panel';
			$wp_customize->add_panel( $panel , array(
				'title' 			=> esc_html__( 'WooCommerce', 'lumen' ),
				'priority' 			=> 210,
			) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'lumen_woocommerce_general' , array(
				'title' 			=> esc_html__( 'General', 'lumen' ),
				'description' 		=> esc_html__( 'For some options, you must save and refresh your live site to preview changes.', 'lumen' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Remove Custom WooCommerce Features
			 */
			$wp_customize->add_setting( 'lumen_woo_remove_custom_features', array(
				'default'           	=> 'no',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Buttonset_Control( $wp_customize, 'lumen_woo_remove_custom_features', array(
				'label'	   				=> esc_html__( 'Remove Custom WooCommerce Features', 'lumen' ),
				'description'	   		=> esc_html__( 'Remove all the custom WooCommerce features added for lumen, you will have the default plugin features.', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_general',
				'settings' 				=> 'lumen_woo_remove_custom_features',
				'priority' 				=> 10,
				'choices' 				=> array(
					'yes' 	=> esc_html__( 'Yes', 'lumen' ),
					'no' 	=> esc_html__( 'No', 'lumen' ),
				),
			) ) );

			/**
			 * Custom WooCommerce Sidebar
			 */
			$wp_customize->add_setting( 'lumen_woo_custom_sidebar', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'lumenwp_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_custom_sidebar', array(
				'label'	   				=> esc_html__( 'Custom WooCommerce Sidebar', 'lumen' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'lumen_woocommerce_general',
				'settings' 				=> 'lumen_woo_custom_sidebar',
				'priority' 				=> 10,
			) ) );

			/**
			 * Display Cart When Product Added
			 */
			$wp_customize->add_setting( 'lumen_woo_display_cart_product_added', array(
				'default'           	=> 'no',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Buttonset_Control( $wp_customize, 'lumen_woo_display_cart_product_added', array(
				'label'	   				=> esc_html__( 'Display Cart When Product Added', 'lumen' ),
				'description'	   		=> esc_html__( 'Display the cart when a product is added, work in the shop and the single product pages if ajax is enabled.', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_general',
				'settings' 				=> 'lumen_woo_display_cart_product_added',
				'priority' 				=> 10,
				'choices' 				=> array(
					'yes' 	=> esc_html__( 'Yes', 'lumen' ),
					'no' 	=> esc_html__( 'No', 'lumen' ),
				),
			) ) );

			/**
			 * Categories Widget Style
			 */
			$wp_customize->add_setting( 'lumen_woo_cat_widget_style', array(
				'transport'           	=> 'postMessage',
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_cat_widget_style', array(
				'label'	   				=> esc_html__( 'Categories Widget Style', 'lumen' ),
				'description'	   		=> esc_html__( 'Choose the WooCommerce Categories widget style.', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_woocommerce_general',
				'settings' 				=> 'lumen_woo_cat_widget_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'default' 	=> esc_html__( 'Default', 'lumen' ),
					'dropdown' 	=> esc_html__( 'Dropdown', 'lumen' ),
				),
			) ) );

			/**
			 * Heading Wishlist
			 */
			$wp_customize->add_setting( 'lumen_woo_wishlist_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_woo_wishlist_heading', array(
				'label'    	=> esc_html__( 'Wishlist', 'lumen' ),
				'description' => sprintf( esc_html__( 'You need to activate the %1$sTI WooCommerce Wishlist%2$s plugin to add a wishlist button and icon', 'lumen' ), '<a href="https://wordpress.org/plugins/ti-woocommerce-wishlist/" target="_blank">', '</a>' ),
				'section'  	=> 'lumen_woocommerce_general',
				'priority' 	=> 10,
			) ) );

			/**
			 * Add Wishlist Icon In Header
			 */
			$wp_customize->add_setting( 'lumen_woo_wishlist_icon', array(
				'default'           	=> false,
				'sanitize_callback' 	=> 'lumenwp_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_wishlist_icon', array(
				'label'	   				=> esc_html__( 'Add Wishlist Icon In Header', 'lumen' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'lumen_woocommerce_general',
				'settings' 				=> 'lumen_woo_wishlist_icon',
				'priority' 				=> 10,
			) ) );

			/**
			 * Heading On Sale Badge
			 */
			$wp_customize->add_setting( 'lumen_woo_sale_badge_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_woo_sale_badge_heading', array(
				'label'    	=> esc_html__( 'On Sale Badge', 'lumen' ),
				'section'  	=> 'lumen_woocommerce_general',
				'priority' 	=> 10,
			) ) );

			/**
			 * On Sale Badge Style
			 */
			$wp_customize->add_setting( 'lumen_woo_sale_badge_style', array(
				'transport'           	=> 'postMessage',
				'default'           	=> 'square',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_sale_badge_style', array(
				'label'	   				=> esc_html__( 'On Sale Badge Style', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_woocommerce_general',
				'settings' 				=> 'lumen_woo_sale_badge_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'square' 	=> esc_html__( 'Square', 'lumen' ),
					'circle' 	=> esc_html__( 'Circle', 'lumen' ),
				),
			) ) );

			/**
			 * On Sale Badge Content
			 */
			$wp_customize->add_setting( 'lumen_woo_sale_badge_content', array(
				'default'           	=> 'sale',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_sale_badge_content', array(
				'label'	   				=> esc_html__( 'On Sale Badge Content', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_woocommerce_general',
				'settings' 				=> 'lumen_woo_sale_badge_content',
				'priority' 				=> 10,
				'choices' 				=> array(
					'sale' 		=> esc_html__( 'On Sale Text', 'lumen' ),
					'percent' 	=> esc_html__( 'Percentage', 'lumen' ),
				),
			) ) );

			/**
			 * Heading My Account Page
			 */
			$wp_customize->add_setting( 'lumen_woo_account_page_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_woo_account_page_heading', array(
				'label'    	=> esc_html__( 'My Account Page', 'lumen' ),
				'section'  	=> 'lumen_woocommerce_general',
				'priority' 	=> 10,
			) ) );

			/**
			 * My Account Page Style
			 */
			$wp_customize->add_setting( 'lumen_woo_account_page_style', array(
				'transport' 			=> 'postMessage',
				'default'           	=> 'original',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_account_page_style', array(
				'label'	   				=> esc_html__( 'Login/Register Style', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_woocommerce_general',
				'settings' 				=> 'lumen_woo_account_page_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'original' 			=> esc_html__( 'Original', 'lumen' ),
					'side' 				=> esc_html__( 'Side by Side', 'lumen' ),
				),
			) ) );

			/**
			 * Heading Category Page
			 */
			$wp_customize->add_setting( 'lumen_woo_category_page_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_woo_category_page_heading', array(
				'label'    	=> esc_html__( 'Category Page', 'lumen' ),
				'section'  	=> 'lumen_woocommerce_general',
				'priority' 	=> 10,
			) ) );

			/**
			 * Display Featured Image
			 */
			$wp_customize->add_setting( 'lumen_woo_category_image', array(
				'default'           	=> 'no',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Buttonset_Control( $wp_customize, 'lumen_woo_category_image', array(
				'label'	   				=> esc_html__( 'Display Featured Image', 'lumen' ),
				'description'	   		=> esc_html__( 'Display the categories featured images before the product archives.', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_general',
				'settings' 				=> 'lumen_woo_category_image',
				'priority' 				=> 10,
				'choices' 				=> array(
					'yes' 	=> esc_html__( 'Yes', 'lumen' ),
					'no' 	=> esc_html__( 'No', 'lumen' ),
				),
			) ) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'lumen_woocommerce_menu_cart' , array(
				'title' 			=> esc_html__( 'Menu Cart', 'lumen' ),
				'description' 		=> esc_html__( 'For some options, you must save and refresh your live site to preview changes.', 'lumen' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Hide If Empty
			 */
			$wp_customize->add_setting( 'lumen_woo_menu_icon_hide_if_empty', array(
				'default'           	=> false,
				'sanitize_callback' 	=> 'lumenwp_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_menu_icon_hide_if_empty', array(
				'label'	   				=> esc_html__( 'Hide If Empty Cart', 'lumen' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_menu_icon_hide_if_empty',
				'priority' 				=> 10,
			) ) );

			/**
			 * Display Mini Cart On Mobile
			 */
			$wp_customize->add_setting( 'lumen_woo_add_mobile_mini_cart', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'lumenwp_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_add_mobile_mini_cart', array(
				'label'	   				=> esc_html__( 'Display Mini Cart On Mobile', 'lumen' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_add_mobile_mini_cart',
				'priority' 				=> 10,
			) ) );

			/**
			 * Visibility
			 */
			$wp_customize->add_setting( 'lumen_woo_menu_icon_visibility', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_menu_icon_visibility', array(
				'label'	   				=> esc_html__( 'Visibility', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_menu_icon_visibility',
				'priority' 				=> 10,
				'choices' 				=> array(
					'default' 			=> esc_html__( 'Display On All Devices', 'lumen' ),
					'disabled' 			=> esc_html__( 'Disabled On All Devices', 'lumen' ),
					'disabled_desktop' 	=> esc_html__( 'Disabled Only On Desktop', 'lumen' ),
				),
			) ) );

			/**
			 * Bag Style
			 */
			$wp_customize->add_setting( 'lumen_woo_menu_bag_style', array(
				'default'           	=> 'no',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Buttonset_Control( $wp_customize, 'lumen_woo_menu_bag_style', array(
				'label'	   				=> esc_html__( 'Bag Style', 'lumen' ),
				'description'	   		=> esc_html__( 'This setting rep^lace the cart icon by a bag with the items count in it.', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_menu_bag_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'yes' 	=> esc_html__( 'Yes', 'lumen' ),
					'no' 	=> esc_html__( 'No', 'lumen' ),
				),
			) ) );

			/**
			 * Bag Style Total
			 */
			$wp_customize->add_setting( 'lumen_woo_menu_bag_style_total', array(
				'default'           	=> false,
				'sanitize_callback' 	=> 'lumenwp_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_menu_bag_style_total', array(
				'label'	   				=> esc_html__( 'Bag Icon Display Total', 'lumen' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_menu_bag_style_total',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_bag_style',
			) ) );

			/**
			 * Bag Icon Color
			 */
			$wp_customize->add_setting( 'lumen_woo_menu_bag_icon_color', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#333333',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_menu_bag_icon_color', array(
				'label'	   				=> esc_html__( 'Bag Icon Color', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_menu_bag_icon_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_bag_style',
			) ) );

			/**
			 * Bag Icon Hover Color
			 */
			$wp_customize->add_setting( 'lumen_woo_menu_bag_icon_hover_color', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#13aff0',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_menu_bag_icon_hover_color', array(
				'label'	   				=> esc_html__( 'Bag Icon Hover Color', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_menu_bag_icon_hover_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_bag_style',
			) ) );

			/**
			 * Bag Icon Count Color
			 */
			$wp_customize->add_setting( 'lumen_woo_menu_bag_icon_count_color', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#333333',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_menu_bag_icon_count_color', array(
				'label'	   				=> esc_html__( 'Bag Icon Count Color', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_menu_bag_icon_count_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_bag_style',
			) ) );

			/**
			 * Bag Icon Hover Count Color
			 */
			$wp_customize->add_setting( 'lumen_woo_menu_bag_icon_hover_count_color', array(
				'transport' 			=> 'postMessage',
				'default' 				=> '#ffffff',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_menu_bag_icon_hover_count_color', array(
				'label'	   				=> esc_html__( 'Bag Icon Hover Count Color', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_menu_bag_icon_hover_count_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_bag_style',
			) ) );

			/**
			 * Display
			 */
			$wp_customize->add_setting( 'lumen_woo_menu_icon_display', array(
				'default'           	=> 'icon_count',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_menu_icon_display', array(
				'label'	   				=> esc_html__( 'Display', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_menu_icon_display',
				'priority' 				=> 10,
				'choices' 				=> array(
					'icon' 				=> esc_html__( 'Icon', 'lumen' ),
					'icon_total' 		=> esc_html__( 'Icon And Cart Total', 'lumen' ),
					'icon_count' 		=> esc_html__( 'Icon And Cart Count', 'lumen' ),
					'icon_count_total' 	=> esc_html__( 'Icon And Cart Count + Total', 'lumen' ),
				),
				'active_callback' 		=> 'lumenwp_cac_hasnt_woo_bag_style',
			) ) );

			/**
			 * Style
			 */
			$wp_customize->add_setting( 'lumen_woo_menu_icon_style', array(
				'transport'           	=> 'postMessage',
				'default'           	=> 'drop_down',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_menu_icon_style', array(
				'label'	   				=> esc_html__( 'Style', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_menu_icon_style',
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
			$wp_customize->add_setting( 'lumen_woo_menu_icon_custom_link', array(
				'transport'           	=> 'postMessage',
				'sanitize_callback' 	=> 'esc_url_raw',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_menu_icon_custom_link', array(
				'label'	   				=> esc_html__( 'Custom Link', 'lumen' ),
				'description'	   		=> esc_html__( 'The Custom Link style need to be selected', 'lumen' ),
				'type' 					=> 'text',
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_menu_icon_custom_link',
				'priority' 				=> 10,
			) ) );

			/**
			 * Icon
			 */
			$wp_customize->add_setting( 'lumen_woo_menu_icon', array(
				'transport' 			=> 'postMessage',
				'default'           	=> 'icon-handbag',
				'sanitize_callback' 	=> 'wp_filter_nohtml_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Icon_Select_Control( $wp_customize, 'lumen_woo_menu_icon', array(
				'label'	   				=> esc_html__( 'Cart Icon', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_menu_icon',
				'priority' 				=> 10,
			    'choices' 				=> lumenwp_get_cart_icons(),
				'active_callback' 		=> 'lumenwp_cac_hasnt_woo_bag_style',
			) ) );

			/**
			 * Custom Icon
			 */
			$wp_customize->add_setting( 'lumen_woo_menu_custom_icon', array(
				'transport'           	=> 'postMessage',
				'sanitize_callback' 	=> 'wp_filter_nohtml_kses',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_menu_custom_icon', array(
				'label'	   				=> esc_html__( 'Custom Icon', 'lumen' ),
				'description'	   		=> esc_html__( 'Enter your full icon class', 'lumen' ),
				'type' 					=> 'text',
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_menu_custom_icon',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_hasnt_woo_bag_style',
			) ) );

			/**
			 * Icon Size
			 */
			$wp_customize->add_setting( 'lumen_woo_menu_icon_size', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_woo_menu_icon_size_tablet', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_setting( 'lumen_woo_menu_icon_size_mobile', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Slider_Control( $wp_customize, 'lumen_woo_menu_icon_size', array(
				'label'	   				=> esc_html__( 'Icon Size (px)', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' => array(
		            'desktop' 	=> 'lumen_woo_menu_icon_size',
		            'tablet' 	=> 'lumen_woo_menu_icon_size_tablet',
		            'mobile' 	=> 'lumen_woo_menu_icon_size_mobile',
			    ),
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 10,
			        'max'   => 100,
			        'step'  => 1,
			    ),
				'active_callback' 		=> 'lumenwp_cac_hasnt_woo_bag_style',
			) ) );

			/**
			 * Center Vertically
			 */
			$wp_customize->add_setting( 'lumen_woo_menu_icon_center_vertically', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_woo_menu_icon_center_vertically_tablet', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_setting( 'lumen_woo_menu_icon_center_vertically_mobile', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Slider_Control( $wp_customize, 'lumen_woo_menu_icon_center_vertically', array(
				'label'	   				=> esc_html__( 'Center Vertically', 'lumen' ),
				'description'	   		=> esc_html__( 'Use this field to center your icon vertically', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' => array(
		            'desktop' 	=> 'lumen_woo_menu_icon_center_vertically',
		            'tablet' 	=> 'lumen_woo_menu_icon_center_vertically_tablet',
		            'mobile' 	=> 'lumen_woo_menu_icon_center_vertically_mobile',
			    ),
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
				'active_callback' 		=> 'lumenwp_cac_hasnt_woo_bag_style',
			) ) );

			/**
			 * Heading Styling
			 */
			$wp_customize->add_setting( 'lumen_woo_cart_dropdowns_styling_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_woo_cart_dropdowns_styling_heading', array(
				'label'    	=> esc_html__( 'Cart Dropdown Styling', 'lumen' ),
				'section'  	=> 'lumen_woocommerce_menu_cart',
				'priority' 	=> 10,
			) ) );

			/**
			 * Style
			 */
			$wp_customize->add_setting( 'lumen_woo_cart_dropdown_style', array(
				'transport' 			=> 'postMessage',
				'default'           	=> 'compact',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_cart_dropdown_style', array(
				'label'	   				=> esc_html__( 'Style', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_cart_dropdown_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'compact' 		=> esc_html__( 'Compact', 'lumen' ),
					'spacious' 		=> esc_html__( 'Spacious', 'lumen' ),
				),
			) ) );

			/**
			 * Dropdowns Width
			 */
			$wp_customize->add_setting( 'lumen_woo_cart_dropdown_width', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '350',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Range_Control( $wp_customize, 'lumen_woo_cart_dropdown_width', array(
				'label'	   				=> esc_html__( 'Cart Dropdowns Width (px)', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_cart_dropdown_width',
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
			$wp_customize->add_setting( 'lumen_woo_cart_dropdown_bg', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#ffffff',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_cart_dropdown_bg', array(
				'label'	   				=> esc_html__( 'Dropdown Background Color', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_cart_dropdown_bg',
				'priority' 				=> 10,
			) ) );

			/**
			 * Dropdown Borders Color
			 */
			$wp_customize->add_setting( 'lumen_woo_cart_dropdown_borders', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#e6e6e6',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_cart_dropdown_borders', array(
				'label'	   				=> esc_html__( 'Dropdown Borders Color', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_cart_dropdown_borders',
				'priority' 				=> 10,
			) ) );

			/**
			 * Link Color
			 */
			$wp_customize->add_setting( 'lumen_woo_cart_dropdown_link_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#333333',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_cart_dropdown_link_color', array(
				'label'	   				=> esc_html__( 'Link Color', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_cart_dropdown_link_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Link Hover Color
			 */
			$wp_customize->add_setting( 'lumen_woo_cart_dropdown_link_color_hover', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#13aff0',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_cart_dropdown_link_color_hover', array(
				'label'	   				=> esc_html__( 'Link Color: Hover', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_cart_dropdown_link_color_hover',
				'priority' 				=> 10,
			) ) );

			/**
			 * Remove Link Color
			 */
			$wp_customize->add_setting( 'lumen_woo_cart_dropdown_remove_link_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#b3b3b3',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_cart_dropdown_remove_link_color', array(
				'label'	   				=> esc_html__( 'Remove Link Color', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_cart_dropdown_remove_link_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Remove Link Hover Color
			 */
			$wp_customize->add_setting( 'lumen_woo_cart_dropdown_remove_link_color_hover', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#13aff0',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_cart_dropdown_remove_link_color_hover', array(
				'label'	   				=> esc_html__( 'Remove Link Color: Hover', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_cart_dropdown_remove_link_color_hover',
				'priority' 				=> 10,
			) ) );

			/**
			 * Quantity Color
			 */
			$wp_customize->add_setting( 'lumen_woo_cart_dropdown_quantity_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#b2b2b2',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_cart_dropdown_quantity_color', array(
				'label'	   				=> esc_html__( 'Quantity Color', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_cart_dropdown_quantity_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Price Color
			 */
			$wp_customize->add_setting( 'lumen_woo_cart_dropdown_price_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#57bf6d',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_cart_dropdown_price_color', array(
				'label'	   				=> esc_html__( 'Price Color', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_cart_dropdown_price_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Subtotal Color
			 */
			$wp_customize->add_setting( 'lumen_woo_cart_dropdown_subtotal_bg', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#fafafa',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_cart_dropdown_subtotal_bg', array(
				'label'	   				=> esc_html__( 'Subtotal Color', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_cart_dropdown_subtotal_bg',
				'priority' 				=> 10,
			) ) );

			/**
			 * Subtotal Color
			 */
			$wp_customize->add_setting( 'lumen_woo_cart_dropdown_subtotal_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#797979',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_cart_dropdown_subtotal_color', array(
				'label'	   				=> esc_html__( 'Subtotal Color', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_cart_dropdown_subtotal_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Total Price Color
			 */
			$wp_customize->add_setting( 'lumen_woo_cart_dropdown_total_price_color', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#57bf6d',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_cart_dropdown_total_price_color', array(
				'label'	   				=> esc_html__( 'Total Price Color', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_cart_dropdown_total_price_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Cart Button: Background Color
			 */
			$wp_customize->add_setting( 'lumen_woo_cart_dropdown_cart_button_bg', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_cart_dropdown_cart_button_bg', array(
				'label'	   				=> esc_html__( 'Cart Button Background', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_cart_dropdown_cart_button_bg',
				'priority' 				=> 10,
			) ) );

			/**
			 * Cart Button Hover: Background Color
			 */
			$wp_customize->add_setting( 'lumen_woo_cart_dropdown_cart_button_hover_bg', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_cart_dropdown_cart_button_hover_bg', array(
				'label'	   				=> esc_html__( 'Cart Button Background: Hover', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_cart_dropdown_cart_button_hover_bg',
				'priority' 				=> 10,
			) ) );

			/**
			 * Cart Button: Color
			 */
			$wp_customize->add_setting( 'lumen_woo_cart_dropdown_cart_button_color', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_cart_dropdown_cart_button_color', array(
				'label'	   				=> esc_html__( 'Cart Button Color', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_cart_dropdown_cart_button_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Cart Button Hover: Color
			 */
			$wp_customize->add_setting( 'lumen_woo_cart_dropdown_cart_button_hover_color', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_cart_dropdown_cart_button_hover_color', array(
				'label'	   				=> esc_html__( 'Cart Button Color: Hover', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_cart_dropdown_cart_button_hover_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Cart Button: Border Color
			 */
			$wp_customize->add_setting( 'lumen_woo_cart_dropdown_cart_button_border_color', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_cart_dropdown_cart_button_border_color', array(
				'label'	   				=> esc_html__( 'Cart Button Border Color', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_cart_dropdown_cart_button_border_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Cart Button Hover: Border Color
			 */
			$wp_customize->add_setting( 'lumen_woo_cart_dropdown_cart_button_hover_border_color', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_cart_dropdown_cart_button_hover_border_color', array(
				'label'	   				=> esc_html__( 'Cart Button Border Color: Hover', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_cart_dropdown_cart_button_hover_border_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Checkout Button: Background Color
			 */
			$wp_customize->add_setting( 'lumen_woo_cart_dropdown_checkout_button_bg', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_cart_dropdown_checkout_button_bg', array(
				'label'	   				=> esc_html__( 'Checkout Button Background', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_cart_dropdown_checkout_button_bg',
				'priority' 				=> 10,
			) ) );

			/**
			 * Checkout Button Hover: Background Color
			 */
			$wp_customize->add_setting( 'lumen_woo_cart_dropdown_checkout_button_hover_bg', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_cart_dropdown_checkout_button_hover_bg', array(
				'label'	   				=> esc_html__( 'Checkout Button Background: Hover', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_cart_dropdown_checkout_button_hover_bg',
				'priority' 				=> 10,
			) ) );

			/**
			 * Checkout Button: Color
			 */
			$wp_customize->add_setting( 'lumen_woo_cart_dropdown_checkout_button_color', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_cart_dropdown_checkout_button_color', array(
				'label'	   				=> esc_html__( 'Checkout Button Color', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_cart_dropdown_checkout_button_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Checkout Button Hover: Color
			 */
			$wp_customize->add_setting( 'lumen_woo_cart_dropdown_checkout_button_hover_color', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_cart_dropdown_checkout_button_hover_color', array(
				'label'	   				=> esc_html__( 'Checkout Button Color: Hover', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_cart_dropdown_checkout_button_hover_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Heading Styling
			 */
			$wp_customize->add_setting( 'lumen_woo_mobile_cart_styling_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_woo_mobile_cart_styling_heading', array(
				'label'    	=> esc_html__( 'Mobile Cart Sidebar Styling', 'lumen' ),
				'section'  	=> 'lumen_woocommerce_menu_cart',
				'priority' 	=> 10,
			) ) );

			/**
			 * Mobile Cart Sidebar Background Color
			 */
			$wp_customize->add_setting( 'lumen_woo_mobile_cart_sidebar_bg', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '#ffffff',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_mobile_cart_sidebar_bg', array(
				'label'	   				=> esc_html__( 'Background Color', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_menu_cart',
				'settings' 				=> 'lumen_woo_mobile_cart_sidebar_bg',
				'priority' 				=> 10,
			) ) );

			/**
		     * Mobile Cart Sidebar Close Button Color
		     */
	        $wp_customize->add_setting( 'lumen_woo_mobile_cart_sidebar_close_button_color', array(
				'default'				=> '#000000',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_mobile_cart_sidebar_close_button_color', array(
				'label'					=> esc_html__( 'Close Button Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_menu_cart',
				'settings'				=> 'lumen_woo_mobile_cart_sidebar_close_button_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Mobile Cart Sidebar Title Color
		     */
	        $wp_customize->add_setting( 'lumen_woo_mobile_cart_sidebar_title_color', array(
				'default'				=> '#555555',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_mobile_cart_sidebar_title_color', array(
				'label'					=> esc_html__( 'Title Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_menu_cart',
				'settings'				=> 'lumen_woo_mobile_cart_sidebar_title_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Mobile Cart Sidebar Divider Color
		     */
	        $wp_customize->add_setting( 'lumen_woo_mobile_cart_sidebar_divider_color', array(
				'default'				=> 'rgba(0,0,0,0.1)',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_mobile_cart_sidebar_divider_color', array(
				'label'					=> esc_html__( 'Divider Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_menu_cart',
				'settings'				=> 'lumen_woo_mobile_cart_sidebar_divider_color',
				'priority'				=> 10,
			) ) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'lumen_woocommerce_archives' , array(
				'title' 			=> esc_html__( 'Archives', 'lumen' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Layout
			 */
			$wp_customize->add_setting( 'lumen_woo_shop_layout', array(
				'default'           	=> 'left-sidebar',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Radio_Image_Control( $wp_customize, 'lumen_woo_shop_layout', array(
				'label'	   				=> esc_html__( 'Layout', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_archives',
				'settings' 				=> 'lumen_woo_shop_layout',
				'priority' 				=> 10,
				'choices' 				=> lumenwp_customizer_layout(),
			) ) );

			/**
			 * Both Sidebars Style
			 */
			$wp_customize->add_setting( 'lumen_woo_shop_both_sidebars_style', array(
				'default'           	=> 'scs-style',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_shop_both_sidebars_style', array(
				'label'	   				=> esc_html__( 'Both Sidebars: Style', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_woocommerce_archives',
				'settings' 				=> 'lumen_woo_shop_both_sidebars_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'ssc-style' 		=> esc_html__( 'Sidebar / Sidebar / Content', 'lumen' ),
					'scs-style' 		=> esc_html__( 'Sidebar / Content / Sidebar', 'lumen' ),
					'css-style' 		=> esc_html__( 'Content / Sidebar / Sidebar', 'lumen' ),
				),
				'active_callback' 		=> 'lumenwp_cac_has_woo_shop_bs_layout',
			) ) );

			/**
			 * Both Sidebars Content Width
			 */
			$wp_customize->add_setting( 'lumen_woo_shop_both_sidebars_content_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_shop_both_sidebars_content_width', array(
				'label'	   				=> esc_html__( 'Both Sidebars: Content Width (%)', 'lumen' ),
				'type' 					=> 'number',
				'section'  				=> 'lumen_woocommerce_archives',
				'settings' 				=> 'lumen_woo_shop_both_sidebars_content_width',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
				'active_callback' 		=> 'lumenwp_cac_has_woo_shop_bs_layout',
			) ) );

			/**
			 * Both Sidebars Sidebars Width
			 */
			$wp_customize->add_setting( 'lumen_woo_shop_both_sidebars_sidebars_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_shop_both_sidebars_sidebars_width', array(
				'label'	   				=> esc_html__( 'Both Sidebars: Sidebars Width (%)', 'lumen' ),
				'type' 					=> 'number',
				'section'  				=> 'lumen_woocommerce_archives',
				'settings' 				=> 'lumen_woo_shop_both_sidebars_sidebars_width',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
				'active_callback' 		=> 'lumenwp_cac_has_woo_shop_bs_layout',
			) ) );

			/**
			 * Mobile Sidebar Order
			 */
			$wp_customize->add_setting( 'lumen_woo_shop_sidebar_order', array(
				'default'           	=> 'content-sidebar',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_shop_sidebar_order', array(
				'label'	   				=> esc_html__( 'Mobile Sidebar Order', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_woocommerce_archives',
				'settings' 				=> 'lumen_woo_shop_sidebar_order',
				'priority' 				=> 10,
				'choices' 				=> array(
					'content-sidebar' 	=> esc_html__( 'Content / Sidebar', 'lumen' ),
					'sidebar-content' 	=> esc_html__( 'Sidebar / Content', 'lumen' ),
				),
				'active_callback' 		=> 'lumenwp_cac_has_woo_shop_rl_layout',
			) ) );

			/**
			 * Shop Posts Per Page
			 */
			$wp_customize->add_setting( 'lumen_woo_shop_posts_per_page', array(
				'default'           	=> '12',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Range_Control( $wp_customize, 'lumen_woo_shop_posts_per_page', array(
				'label'	   				=> esc_html__( 'Shop Posts Per Page', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_archives',
				'settings' 				=> 'lumen_woo_shop_posts_per_page',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 1,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Shop Columns
			 */
			$wp_customize->add_setting( 'lumen_woocommerce_shop_columns', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '3',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );

			$wp_customize->add_setting( 'lumen_woocommerce_tablet_shop_columns', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_setting( 'lumen_woocommerce_mobile_shop_columns', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Slider_Control( $wp_customize, 'lumen_woocommerce_shop_columns', array(
				'label' 			=> esc_html__( 'Shop Columns', 'lumen' ),
				'section'  			=> 'lumen_woocommerce_archives',
				'settings' => array(
		            'desktop' 	=> 'lumen_woocommerce_shop_columns',
		            'tablet' 	=> 'lumen_woocommerce_tablet_shop_columns',
		            'mobile' 	=> 'lumen_woocommerce_mobile_shop_columns',
			    ),
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 1,
			        'max'   => 7,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Toolbar Heading
			 */
			$wp_customize->add_setting( 'lumen_woocommerce_shop_toolbar_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_woocommerce_shop_toolbar_heading', array(
				'label'    				=> esc_html__( 'Toolbar', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_archives',
				'priority' 				=> 10,
			) ) );

			/**
			 * Grid/List Buttons
			 */
			$wp_customize->add_setting( 'lumen_woo_grid_list', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'lumenwp_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_grid_list', array(
				'label'	   				=> esc_html__( 'Grid/List Buttons', 'lumen' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'lumen_woocommerce_archives',
				'settings' 				=> 'lumen_woo_grid_list',
				'priority' 				=> 10,
			) ) );

			/**
			 * Catalog View
			 */
			$wp_customize->add_setting( 'lumen_woo_catalog_view', array(
				'default'           	=> 'grid',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_catalog_view', array(
				'label'	   				=> esc_html__( 'Default Catalog View', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_woocommerce_archives',
				'settings' 				=> 'lumen_woo_catalog_view',
				'priority' 				=> 10,
				'choices' 				=> array(
					'grid'  	=> esc_html__( 'Grid View', 'lumen' ),
					'list' 		=> esc_html__( 'List View', 'lumen' ),
				),
				'active_callback' 		=> 'lumenwp_cac_has_grid_list_buttons',
			) ) );

			/**
			 * List View Excerpt Length
			 */
			$wp_customize->add_setting( 'lumen_woo_list_excerpt_length', array(
				'default'           	=> '60',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Range_Control( $wp_customize, 'lumen_woo_list_excerpt_length', array(
				'label'	   				=> esc_html__( 'Excerpt Length', 'lumen' ),
				'description'	   		=> esc_html__( 'Length of the short description of the list view.', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_archives',
				'settings' 				=> 'lumen_woo_list_excerpt_length',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 500,
			        'step'  => 1,
			    ),
				'active_callback' 		=> 'lumenwp_cac_has_grid_list_buttons',
			) ) );

			/**
			 * Shop Sort
			 */
			$wp_customize->add_setting( 'lumen_woo_shop_sort', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'lumenwp_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_shop_sort', array(
				'label'	   				=> esc_html__( 'Shop Sort', 'lumen' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'lumen_woocommerce_archives',
				'settings' 				=> 'lumen_woo_shop_sort',
				'priority' 				=> 10,
			) ) );

			/**
			 * Shop Result Count
			 */
			$wp_customize->add_setting( 'lumen_woo_shop_result_count', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'lumenwp_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_shop_result_count', array(
				'label'	   				=> esc_html__( 'Shop Result Count', 'lumen' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'lumen_woocommerce_archives',
				'settings' 				=> 'lumen_woo_shop_result_count',
				'priority' 				=> 10,
			) ) );

			/**
			 * Off Canvas Filtering Heading
			 */
			$wp_customize->add_setting( 'lumen_woocommerce_shop_off_canvas_filter_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_woocommerce_shop_off_canvas_filter_heading', array(
				'label'    				=> esc_html__( 'Off Canvas Filtering', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_archives',
				'priority' 				=> 10,
			) ) );

			/**
			 * Off Canvas Filter Button
			 */
			$wp_customize->add_setting( 'lumen_woo_off_canvas_filter', array(
				'default'           	=> false,
				'sanitize_callback' 	=> 'lumenwp_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_off_canvas_filter', array(
				'label'	   				=> esc_html__( 'Display Filter Button', 'lumen' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'lumen_woocommerce_archives',
				'settings' 				=> 'lumen_woo_off_canvas_filter',
				'priority' 				=> 10,
			) ) );

			/**
			 * Off Canvas Filter Text
			 */
			$wp_customize->add_setting( 'lumen_woo_off_canvas_filter_text', array(
				'default'           	=> esc_html__( 'Filter', 'lumen' ),
				'transport'           	=> 'postMessage',
				'sanitize_callback' 	=> 'wp_kses_post',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_off_canvas_filter_text', array(
				'label'	   				=> esc_html__( 'Filter Button Text', 'lumen' ),
				'type' 					=> 'text',
				'section'  				=> 'lumen_woocommerce_archives',
				'settings' 				=> 'lumen_woo_off_canvas_filter_text',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_filter_button',
			) ) );

			/**
			 * Off Canvas Close Button
			 */
			$wp_customize->add_setting( 'lumen_woo_off_canvas_close_button', array(
				'default'           	=> false,
				'sanitize_callback' 	=> 'lumenwp_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_off_canvas_close_button', array(
				'label'	   				=> esc_html__( 'Add Close Button', 'lumen' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'lumen_woocommerce_archives',
				'settings' 				=> 'lumen_woo_off_canvas_close_button',
				'priority' 				=> 10,
			) ) );

			/**
		     * Off Canvas Close Button Color
		     */
	        $wp_customize->add_setting( 'lumen_woo_off_canvas_close_button_color', array(
				'default'				=> '#333333',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_off_canvas_close_button_color', array(
				'label'					=> esc_html__( 'Close Button Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_archives',
				'settings'				=> 'lumen_woo_off_canvas_close_button_color',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_filter_close_button',
			) ) );

			/**
		     * Off Canvas Close Button Color
		     */
	        $wp_customize->add_setting( 'lumen_woo_off_canvas_close_button_hover_color', array(
				'default'				=> '#777777',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_off_canvas_close_button_hover_color', array(
				'label'					=> esc_html__( 'Close Button Color: Hover', 'lumen' ),
				'section'				=> 'lumen_woocommerce_archives',
				'settings'				=> 'lumen_woo_off_canvas_close_button_hover_color',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_filter_close_button',
			) ) );

			/**
			 * Products Heading
			 */
			$wp_customize->add_setting( 'lumen_woocommerce_shop_products_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_woocommerce_shop_products_heading', array(
				'label'    				=> esc_html__( 'Products', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_archives',
				'priority' 				=> 10,
			) ) );

			/**
			 * Products Style
			 */
			$wp_customize->add_setting( 'lumen_woo_products_style', array(
				'default'           	=> 'default',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_products_style', array(
				'label'	   				=> esc_html__( 'Products Style', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_woocommerce_archives',
				'settings' 				=> 'lumen_woo_products_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'default'  	=> esc_html__( 'Default Style', 'lumen' ),
					'hover' 	=> esc_html__( 'Hover Style', 'lumen' ),
				),
			) ) );

			/**
			 * Product Elements Positioning
			 */
			$wp_customize->add_setting( 'lumenwp_woo_product_elements_positioning', array(
				'default' 				=> array( 'image', 'category', 'title', 'price-rating', 'description' , 'button' ),
				'sanitize_callback' 	=> 'lumenwp_sanitize_multi_choices',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Sortable_Control( $wp_customize, 'lumenwp_woo_product_elements_positioning', array(
				'label'	   				=> esc_html__( 'Elements Positioning', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_archives',
				'settings' 				=> 'lumenwp_woo_product_elements_positioning',
				'priority' 				=> 10,
				'choices' 				=> array(
					'image'    			=> esc_html__( 'Image', 'lumen' ),
					'category'       	=> esc_html__( 'Category', 'lumen' ),
					'title' 			=> esc_html__( 'Title', 'lumen' ),
					'price-rating' 		=> esc_html__( 'Price/Rating', 'lumen' ),
					'description' 		=> esc_html__( 'Description', 'lumen' ),
					'button' 			=> esc_html__( 'Add To Cart Button', 'lumen' ),
				),
				'active_callback' 		=> 'lumenwp_cac_has_woo_default_products_style',
			) ) );

			/**
			 * Product Entry Media
			 */
			$wp_customize->add_setting( 'lumen_woo_product_entry_style', array(
				'default'           	=> 'image-swap',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_product_entry_style', array(
				'label'	   				=> esc_html__( 'Product Entry Media', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_woocommerce_archives',
				'settings' 				=> 'lumen_woo_product_entry_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'featured-image'  	=> esc_html__( 'Featured Image', 'lumen' ),
					'image-swap' 		=> esc_html__( 'Image Swap', 'lumen' ),
					'gallery-slider'  	=> esc_html__( 'Gallery Slider', 'lumen' ),
				),
				'active_callback' 		=> 'lumenwp_cac_has_woo_default_products_style',
			) ) );

			/**
			 * Display Quick View Button
			 */
			$wp_customize->add_setting( 'lumen_woo_quick_view', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'lumenwp_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_quick_view', array(
				'label'	   				=> esc_html__( 'Display Quick View Button', 'lumen' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'lumen_woocommerce_archives',
				'settings' 				=> 'lumen_woo_quick_view',
				'priority' 				=> 10,
			) ) );

			/**
			 * Product Entry Content Alignment
			 */
			$wp_customize->add_setting( 'lumen_woo_product_entry_content_alignment', array(
				'transport' 			=> 'postMessage',
				'default'           	=> 'center',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Buttonset_Control( $wp_customize, 'lumen_woo_product_entry_content_alignment', array(
				'label'	   				=> esc_html__( 'Content Alignment', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_archives',
				'settings' 				=> 'lumen_woo_product_entry_content_alignment',
				'priority' 				=> 10,
				'choices' 				=> array(
					'left' 		=> esc_html__( 'Left', 'lumen' ),
					'center' 	=> esc_html__( 'Center', 'lumen' ),
					'right' 	=> esc_html__( 'Right', 'lumen' ),
				),
			) ) );

			/**
			 * Pagination Heading
			 */
			$wp_customize->add_setting( 'lumen_woocommerce_shop_pagination_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_woocommerce_shop_pagination_heading', array(
				'label'    				=> esc_html__( 'Pagination', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_archives',
				'priority' 				=> 10,
			) ) );

			/**
			 * Shop Pagination Style
			 */
			$wp_customize->add_setting( 'lumen_woo_pagination_style', array(
				'default'           	=> 'standard',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_pagination_style', array(
				'label'	   				=> esc_html__( 'Pagination Style', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_woocommerce_archives',
				'settings' 				=> 'lumen_woo_pagination_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'standard' 			=> esc_html__( 'Standard', 'lumen' ),
					'infinite_scroll' 	=> esc_html__( 'Infinite Scroll', 'lumen' ),
				),
			) ) );

			/**
			 * Infinite Scroll: Spinners Color
			 */
			$wp_customize->add_setting( 'lumen_woo_infinite_scroll_spinners_color', array(
				'default'           	=> '#333333',
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_infinite_scroll_spinners_color', array(
				'label'	   				=> esc_html__( 'Infinite Scroll: Spinners Color', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_archives',
				'settings' 				=> 'lumen_woo_infinite_scroll_spinners_color',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_infinite_scroll',
			) ) );

			/**
			 * Infinite Scroll: Last Text
			 */
			$wp_customize->add_setting( 'lumen_woo_infinite_scroll_last_text', array(
				'default'           	=> esc_html__( 'End of content', 'lumen' ),
				'transport'           	=> 'postMessage',
				'sanitize_callback' 	=> 'wp_kses_post',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_infinite_scroll_last_text', array(
				'label'	   				=> esc_html__( 'Infinite Scroll: Last Text', 'lumen' ),
				'type' 					=> 'text',
				'section'  				=> 'lumen_woocommerce_archives',
				'settings' 				=> 'lumen_woo_infinite_scroll_last_text',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_infinite_scroll',
			) ) );

			/**
			 * Infinite Scroll: Error Text
			 */
			$wp_customize->add_setting( 'lumen_woo_infinite_scroll_error_text', array(
				'default'           	=> esc_html__( 'No more pages to load', 'lumen' ),
				'transport'           	=> 'postMessage',
				'sanitize_callback' 	=> 'wp_kses_post',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_infinite_scroll_error_text', array(
				'label'	   				=> esc_html__( 'Infinite Scroll: Error Text', 'lumen' ),
				'type' 					=> 'text',
				'section'  				=> 'lumen_woocommerce_archives',
				'settings' 				=> 'lumen_woo_infinite_scroll_error_text',
				'priority' 				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_infinite_scroll',
			) ) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'lumen_woocommerce_single' , array(
				'title' 			=> esc_html__( 'Single Product', 'lumen' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Layout
			 */
			$wp_customize->add_setting( 'lumen_woo_product_layout', array(
				'default'           	=> 'left-sidebar',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Radio_Image_Control( $wp_customize, 'lumen_woo_product_layout', array(
				'label'	   				=> esc_html__( 'Layout', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_single',
				'settings' 				=> 'lumen_woo_product_layout',
				'priority' 				=> 10,
				'choices' 				=> lumenwp_customizer_layout(),
			) ) );

			/**
			 * Both Sidebars Style
			 */
			$wp_customize->add_setting( 'lumen_woo_product_both_sidebars_style', array(
				'default'           	=> 'scs-style',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_product_both_sidebars_style', array(
				'label'	   				=> esc_html__( 'Both Sidebars: Style', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_woocommerce_single',
				'settings' 				=> 'lumen_woo_product_both_sidebars_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'ssc-style' 		=> esc_html__( 'Sidebar / Sidebar / Content', 'lumen' ),
					'scs-style' 		=> esc_html__( 'Sidebar / Content / Sidebar', 'lumen' ),
					'css-style' 		=> esc_html__( 'Content / Sidebar / Sidebar', 'lumen' ),
				),
				'active_callback' 		=> 'lumenwp_cac_has_woo_product_bs_layout',
			) ) );

			/**
			 * Both Sidebars Content Width
			 */
			$wp_customize->add_setting( 'lumen_woo_product_both_sidebars_content_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_product_both_sidebars_content_width', array(
				'label'	   				=> esc_html__( 'Both Sidebars: Content Width (%)', 'lumen' ),
				'type' 					=> 'number',
				'section'  				=> 'lumen_woocommerce_single',
				'settings' 				=> 'lumen_woo_product_both_sidebars_content_width',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
				'active_callback' 		=> 'lumenwp_cac_has_woo_product_bs_layout',
			) ) );

			/**
			 * Both Sidebars Sidebars Width
			 */
			$wp_customize->add_setting( 'lumen_woo_product_both_sidebars_sidebars_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_product_both_sidebars_sidebars_width', array(
				'label'	   				=> esc_html__( 'Both Sidebars: Sidebars Width (%)', 'lumen' ),
				'type' 					=> 'number',
				'section'  				=> 'lumen_woocommerce_single',
				'settings' 				=> 'lumen_woo_product_both_sidebars_sidebars_width',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
				'active_callback' 		=> 'lumenwp_cac_has_woo_product_bs_layout',
			) ) );

			/**
			 * Mobile Sidebar Order
			 */
			$wp_customize->add_setting( 'lumen_woo_product_sidebar_order', array(
				'default'           	=> 'content-sidebar',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_product_sidebar_order', array(
				'label'	   				=> esc_html__( 'Mobile Sidebar Order', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_woocommerce_single',
				'settings' 				=> 'lumen_woo_product_sidebar_order',
				'priority' 				=> 10,
				'choices' 				=> array(
					'content-sidebar' 	=> esc_html__( 'Content / Sidebar', 'lumen' ),
					'sidebar-content' 	=> esc_html__( 'Sidebar / Content', 'lumen' ),
				),
				'active_callback' 		=> 'lumenwp_cac_has_woo_product_rl_layout',
			) ) );

			/**
			 * Title HTML Tag
			 */
			$wp_customize->add_setting( 'lumen_woo_product_title_tag', array(
				'default' 				=> 'h2',
				'sanitize_callback' 	=> 'sanitize_key',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_product_title_tag', array(
				'label'	   				=> esc_html__( 'Title HTML Tag', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_woocommerce_single',
				'settings' 				=> 'lumen_woo_product_title_tag',
				'priority' 				=> 10,
				'choices' 				=> array(
					'h1' 		=> esc_html__( 'H1', 'lumen' ),
					'h2' 		=> esc_html__( 'H2', 'lumen' ),
					'h3' 		=> esc_html__( 'H3', 'lumen' ),
					'h4' 		=> esc_html__( 'H4', 'lumen' ),
					'h5' 		=> esc_html__( 'H5', 'lumen' ),
					'h6' 		=> esc_html__( 'H6', 'lumen' ),
					'div' 		=> esc_html__( 'div', 'lumen' ),
					'span' 		=> esc_html__( 'span', 'lumen' ),
					'p' 		=> esc_html__( 'p', 'lumen' ),
				),
			) ) );

			/**
			 * Elements Positioning
			 */
			$wp_customize->add_setting( 'lumenwp_woo_summary_elements_positioning', array(
				'default' 				=> array( 'title', 'rating', 'price', 'excerpt', 'quantity-button', 'meta' ),
				'sanitize_callback' 	=> 'lumenwp_sanitize_multi_choices',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Sortable_Control( $wp_customize, 'lumenwp_woo_summary_elements_positioning', array(
				'label'	   				=> esc_html__( 'Summary Elements Positioning', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_single',
				'settings' 				=> 'lumenwp_woo_summary_elements_positioning',
				'priority' 				=> 10,
				'choices' 				=> array(
					'title'    			=> esc_html__( 'Title', 'lumen' ),
					'rating'       		=> esc_html__( 'Rating', 'lumen' ),
					'price' 			=> esc_html__( 'Price', 'lumen' ),
					'excerpt' 			=> esc_html__( 'Excerpt', 'lumen' ),
					'quantity-button' 	=> esc_html__( 'Quantity & Add To Cart', 'lumen' ),
					'meta' 				=> esc_html__( 'Product Meta', 'lumen' ),
				),
			) ) );

			/**
			 * Display Product Navigation
			 */
			$wp_customize->add_setting( 'lumen_woocommerce_display_navigation', array(
				'default'           	=> true,
				'sanitize_callback' 	=> 'lumenwp_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woocommerce_display_navigation', array(
				'label'	   				=> esc_html__( 'Display Product Navigation', 'lumen' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'lumen_woocommerce_single',
				'settings' 				=> 'lumen_woocommerce_display_navigation',
				'priority' 				=> 10,
			) ) );

			/**
			 * Enable Ajax Add To Cart
			 */
			$wp_customize->add_setting( 'lumen_woo_product_ajax_add_to_cart', array(
				'default'           	=> false,
				'sanitize_callback' 	=> 'lumenwp_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_product_ajax_add_to_cart', array(
				'label'	   				=> esc_html__( 'Enable Ajax Add To Cart', 'lumen' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'lumen_woocommerce_single',
				'settings' 				=> 'lumen_woo_product_ajax_add_to_cart',
				'priority' 				=> 10,
			) ) );

			/**
			 * Image Width
			 */
			$wp_customize->add_setting( 'lumen_woo_product_image_width', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '52',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Range_Control( $wp_customize, 'lumen_woo_product_image_width', array(
				'label'	   				=> esc_html__( 'Image Width (%)', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_single',
				'settings' 				=> 'lumen_woo_product_image_width',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Summary Width
			 */
			$wp_customize->add_setting( 'lumen_woo_product_summary_width', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '44',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Range_Control( $wp_customize, 'lumen_woo_product_summary_width', array(
				'label'	   				=> esc_html__( 'Summary Width (%)', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_single',
				'settings' 				=> 'lumen_woo_product_summary_width',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Thumbnails Layout
			 */
			$wp_customize->add_setting( 'lumen_woo_product_thumbs_layout', array(
				'transport' 			=> 'postMessage',
				'default' 				=> 'horizontal',
				'sanitize_callback' 	=> 'sanitize_text_field',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_product_thumbs_layout', array(
				'label'	   				=> esc_html__( 'Thumbnails Layout', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_woocommerce_single',
				'settings' 				=> 'lumen_woo_product_thumbs_layout',
				'priority' 				=> 10,
				'choices' 				=> array(
					'horizontal' 		=> esc_html__( 'Horizontal', 'lumen' ),
					'vertical' 			=> esc_html__( 'Vertical', 'lumen' ),
				),
			) ) );

			/**
			 * Add To Cart Button Style
			 */
			$wp_customize->add_setting( 'lumen_woo_product_addtocart_style', array(
				'transport' 			=> 'postMessage',
				'default' 				=> 'normal',
				'sanitize_callback' 	=> 'sanitize_text_field',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_product_addtocart_style', array(
				'label'	   				=> esc_html__( 'Add To Cart Button Style', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_woocommerce_single',
				'settings' 				=> 'lumen_woo_product_addtocart_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'normal' 		=> esc_html__( 'Normal', 'lumen' ),
					'big' 			=> esc_html__( 'Big', 'lumen' ),
					'very-big' 		=> esc_html__( 'Very Big', 'lumen' ),
				),
			) ) );

			/**
			 * Heading Woo Tabs
			 */
			$wp_customize->add_setting( 'lumen_woo_product_tabs_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_woo_product_tabs_heading', array(
				'label'    				=> esc_html__( 'Tabs', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_single',
				'priority' 				=> 10,
			) ) );

			/**
			 * Tabs Layout
			 */
			$wp_customize->add_setting( 'lumen_woo_product_tabs_layout', array(
				'transport' 			=> 'postMessage',
				'default' 				=> 'horizontal',
				'sanitize_callback' 	=> 'sanitize_text_field',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_product_tabs_layout', array(
				'label'	   				=> esc_html__( 'Tabs Layout', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_woocommerce_single',
				'settings' 				=> 'lumen_woo_product_tabs_layout',
				'priority' 				=> 10,
				'choices' 				=> array(
					'horizontal' 		=> esc_html__( 'Horizontal', 'lumen' ),
					'vertical' 			=> esc_html__( 'Vertical', 'lumen' ),
					'section' 			=> esc_html__( 'Section', 'lumen' ),
				),
			) ) );

			/**
			 * Tabs Position
			 */
			$wp_customize->add_setting( 'lumen_woo_product_meta_tabs_position', array(
				'transport' 			=> 'postMessage',
				'default'           	=> 'center',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Buttonset_Control( $wp_customize, 'lumen_woo_product_meta_tabs_position', array(
				'label'	   				=> esc_html__( 'Tabs Position', 'lumen' ),
				'description'	   		=> esc_html__( 'Only work for the horizontal tabs layout', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_single',
				'settings' 				=> 'lumen_woo_product_meta_tabs_position',
				'priority' 				=> 10,
				'choices' 				=> array(
					'left' 		=> esc_html__( 'Left', 'lumen' ),
					'center' 	=> esc_html__( 'Center', 'lumen' ),
					'right' 	=> esc_html__( 'Right', 'lumen' ),
				),
			) ) );

			/**
			 * Heading Woo Tabs
			 */
			$wp_customize->add_setting( 'lumen_woo_upsells_related_items_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_woo_upsells_related_items_heading', array(
				'label'    				=> esc_html__( 'Up-Sells & Related Items', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_single',
				'priority' 				=> 10,
			) ) );

			/**
			 * Up-Sells Count
			 */
			$wp_customize->add_setting( 'lumen_woocommerce_upsells_count', array(
				'default'           	=> '3',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Range_Control( $wp_customize, 'lumen_woocommerce_upsells_count', array(
				'label'	   				=> esc_html__( 'Up-Sells Count', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_single',
				'settings' 				=> 'lumen_woocommerce_upsells_count',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 1,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Up-Sells Columns
			 */
			$wp_customize->add_setting( 'lumen_woocommerce_upsells_columns', array(
				'default'           	=> '3',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Range_Control( $wp_customize, 'lumen_woocommerce_upsells_columns', array(
				'label'	   				=> esc_html__( 'Up-Sells Columns', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_single',
				'settings' 				=> 'lumen_woocommerce_upsells_columns',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 1,
			        'max'   => 7,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Display Related Items
			 */
			$wp_customize->add_setting( 'lumen_woocommerce_display_related_items', array(
				'default'           	=> 'on',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Buttonset_Control( $wp_customize, 'lumen_woocommerce_display_related_items', array(
				'label'	   				=> esc_html__( 'Display Related Items', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_single',
				'settings' 				=> 'lumen_woocommerce_display_related_items',
				'priority' 				=> 10,
				'choices' 				=> array(
					'on' 	=> esc_html__( 'Yes', 'lumen' ),
					'off' 	=> esc_html__( 'No', 'lumen' ),
				),
			) ) );

			/**
			 * Related Items Count
			 */
			$wp_customize->add_setting( 'lumen_woocommerce_related_count', array(
				'default'           	=> '3',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Range_Control( $wp_customize, 'lumen_woocommerce_related_count', array(
				'label'	   				=> esc_html__( 'Related Items Count', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_single',
				'settings' 				=> 'lumen_woocommerce_related_count',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 1,
			        'max'   => 100,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Related Products Columns
			 */
			$wp_customize->add_setting( 'lumen_woocommerce_related_columns', array(
				'default'           	=> '3',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Range_Control( $wp_customize, 'lumen_woocommerce_related_columns', array(
				'label'	   				=> esc_html__( 'Related Products Columns', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_single',
				'settings' 				=> 'lumen_woocommerce_related_columns',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 1,
			        'max'   => 7,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Heading Floating Bar
			 */
			$wp_customize->add_setting( 'lumen_woo_floating_bar_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_woo_floating_bar_heading', array(
				'label'    				=> esc_html__( 'Floating Bar', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_single',
				'priority' 				=> 10,
			) ) );

			/**
			 * Display Floating Bar
			 */
			$wp_customize->add_setting( 'lumen_woo_display_floating_bar', array(
				'default'           	=> 'on',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Buttonset_Control( $wp_customize, 'lumen_woo_display_floating_bar', array(
				'label'	   				=> esc_html__( 'Display Floating Bar', 'lumen' ),
				'description' 			=> esc_html__( 'The floating bar is to display the add to cart button when you scroll to increase conversions.', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_single',
				'settings' 				=> 'lumen_woo_display_floating_bar',
				'priority' 				=> 10,
				'choices' 				=> array(
					'on' 	=> esc_html__( 'Yes', 'lumen' ),
					'off' 	=> esc_html__( 'No', 'lumen' ),
				),
			) ) );

			/**
		     * Floating Bar Background
		     */
	        $wp_customize->add_setting( 'lumen_woo_floating_bar_bg', array(
				'default'				=> '#2c2c2c',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_floating_bar_bg', array(
				'label'					=> esc_html__( 'Background Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_single',
				'settings'				=> 'lumen_woo_floating_bar_bg',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_floating_bar',
			) ) );

			/**
		     * Floating Bar Title Color
		     */
	        $wp_customize->add_setting( 'lumen_woo_floating_bar_title_color', array(
				'default'				=> '#ffffff',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_floating_bar_title_color', array(
				'label'					=> esc_html__( 'Title Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_single',
				'settings'				=> 'lumen_woo_floating_bar_title_color',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_floating_bar',
			) ) );

			/**
		     * Floating Bar Price Color
		     */
	        $wp_customize->add_setting( 'lumen_woo_floating_bar_price_color', array(
				'default'				=> '#ffffff',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_floating_bar_price_color', array(
				'label'					=> esc_html__( 'Price Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_single',
				'settings'				=> 'lumen_woo_floating_bar_price_color',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_floating_bar',
			) ) );

			/**
		     * Floating Bar Quantity Buttons Background
		     */
	        $wp_customize->add_setting( 'lumen_woo_floating_bar_quantity_buttons_bg', array(
				'default'				=> 'rgba(255,255,255,0.1)',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_floating_bar_quantity_buttons_bg', array(
				'label'					=> esc_html__( 'Quantity Buttons: Background', 'lumen' ),
				'section'				=> 'lumen_woocommerce_single',
				'settings'				=> 'lumen_woo_floating_bar_quantity_buttons_bg',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_floating_bar',
			) ) );

			/**
		     * Floating Bar Quantity Buttons Hover Background
		     */
	        $wp_customize->add_setting( 'lumen_woo_floating_bar_quantity_buttons_hover_bg', array(
				'default'				=> 'rgba(255,255,255,0.2)',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_floating_bar_quantity_buttons_hover_bg', array(
				'label'					=> esc_html__( 'Quantity Buttons Hover: Background', 'lumen' ),
				'section'				=> 'lumen_woocommerce_single',
				'settings'				=> 'lumen_woo_floating_bar_quantity_buttons_hover_bg',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_floating_bar',
			) ) );

			/**
		     * Floating Bar Quantity Buttons Color
		     */
	        $wp_customize->add_setting( 'lumen_woo_floating_bar_quantity_buttons_color', array(
				'default'				=> '#ffffff',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_floating_bar_quantity_buttons_color', array(
				'label'					=> esc_html__( 'Quantity Buttons: Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_single',
				'settings'				=> 'lumen_woo_floating_bar_quantity_buttons_color',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_floating_bar',
			) ) );

			/**
		     * Floating Bar Quantity Buttons Hover Color
		     */
	        $wp_customize->add_setting( 'lumen_woo_floating_bar_quantity_buttons_hover_color', array(
				'default'				=> '#ffffff',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_floating_bar_quantity_buttons_hover_color', array(
				'label'					=> esc_html__( 'Quantity Buttons Hover: Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_single',
				'settings'				=> 'lumen_woo_floating_bar_quantity_buttons_hover_color',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_floating_bar',
			) ) );

			/**
		     * Floating Bar Quantity Input Color
		     */
	        $wp_customize->add_setting( 'lumen_woo_floating_bar_quantity_input_bg', array(
				'default'				=> 'rgba(255,255,255,0.2)',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_floating_bar_quantity_input_bg', array(
				'label'					=> esc_html__( 'Quantity Input: Background', 'lumen' ),
				'section'				=> 'lumen_woocommerce_single',
				'settings'				=> 'lumen_woo_floating_bar_quantity_input_bg',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_floating_bar',
			) ) );

			/**
		     * Floating Bar Quantity Input Color
		     */
	        $wp_customize->add_setting( 'lumen_woo_floating_bar_quantity_input_color', array(
				'default'				=> '#ffffff',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_floating_bar_quantity_input_color', array(
				'label'					=> esc_html__( 'Quantity Input: Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_single',
				'settings'				=> 'lumen_woo_floating_bar_quantity_input_color',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_floating_bar',
			) ) );

			/**
		     * Floating Bar Add To Cart Background
		     */
	        $wp_customize->add_setting( 'lumen_woo_floating_bar_addtocart_bg', array(
				'default'				=> '#ffffff',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_floating_bar_addtocart_bg', array(
				'label'					=> esc_html__( 'Add To Cart: Background', 'lumen' ),
				'section'				=> 'lumen_woocommerce_single',
				'settings'				=> 'lumen_woo_floating_bar_addtocart_bg',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_floating_bar',
			) ) );

			/**
		     * Floating Bar Add To Cart Hover Background
		     */
	        $wp_customize->add_setting( 'lumen_woo_floating_bar_addtocart_hover_bg', array(
				'default'				=> '#f1f1f1',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_floating_bar_addtocart_hover_bg', array(
				'label'					=> esc_html__( 'Add To Cart Hover: Background', 'lumen' ),
				'section'				=> 'lumen_woocommerce_single',
				'settings'				=> 'lumen_woo_floating_bar_addtocart_hover_bg',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_floating_bar',
			) ) );

			/**
		     * Floating Bar Add To Cart Color
		     */
	        $wp_customize->add_setting( 'lumen_woo_floating_bar_addtocart_color', array(
				'default'				=> '#000000',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_floating_bar_addtocart_color', array(
				'label'					=> esc_html__( 'Add To Cart: Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_single',
				'settings'				=> 'lumen_woo_floating_bar_addtocart_color',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_floating_bar',
			) ) );

			/**
		     * Floating Bar Add To Cart Hover Color
		     */
	        $wp_customize->add_setting( 'lumen_woo_floating_bar_addtocart_hover_color', array(
				'default'				=> '#000000',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_floating_bar_addtocart_hover_color', array(
				'label'					=> esc_html__( 'Add To Cart Hover: Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_single',
				'settings'				=> 'lumen_woo_floating_bar_addtocart_hover_color',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_floating_bar',
			) ) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'lumen_woocommerce_cart' , array(
				'title' 			=> esc_html__( 'Cart', 'lumen' ),
				'description' 		=> esc_html__( 'For some options, you must save and refresh your live site to preview changes.', 'lumen' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Distraction Free Cart
			 */
			$wp_customize->add_setting( 'lumen_woo_distraction_free_cart', array(
				'default'           	=> false,
				'sanitize_callback' 	=> 'lumenwp_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_distraction_free_cart', array(
				'label'	   				=> esc_html__( 'Distraction Free Cart', 'lumen' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'lumen_woocommerce_cart',
				'settings' 				=> 'lumen_woo_distraction_free_cart',
				'priority' 				=> 10,
			) ) );

			/**
			 * Cross-Sells Count
			 */
			$wp_customize->add_setting( 'lumen_woocommerce_cross_sells_count', array(
				'default'           	=> '2',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Range_Control( $wp_customize, 'lumen_woocommerce_cross_sells_count', array(
				'label'	   				=> esc_html__( 'Cart: Cross-Sells Count', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_cart',
				'settings' 				=> 'lumen_woocommerce_cross_sells_count',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 1,
			        'max'   => 10,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Cross-Sells Columns
			 */
			$wp_customize->add_setting( 'lumen_woocommerce_cross_sells_columns', array(
				'default'           	=> '2',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Range_Control( $wp_customize, 'lumen_woocommerce_cross_sells_columns', array(
				'label'	   				=> esc_html__( 'Cart: Cross-Sells Columns', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_cart',
				'settings' 				=> 'lumen_woocommerce_cross_sells_columns',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 1,
			        'max'   => 7,
			        'step'  => 1,
			    ),
			) ) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'lumen_woocommerce_checkout' , array(
				'title' 			=> esc_html__( 'Checkout', 'lumen' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Distraction Free Checkout
			 */
			$wp_customize->add_setting( 'lumen_woo_distraction_free_checkout', array(
				'default'           	=> false,
				'sanitize_callback' 	=> 'lumenwp_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_distraction_free_checkout', array(
				'label'	   				=> esc_html__( 'Distraction Free Checkout', 'lumen' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'lumen_woocommerce_checkout',
				'settings' 				=> 'lumen_woo_distraction_free_checkout',
				'priority' 				=> 10,
			) ) );

			/**
			 * Multi-Step Checkout
			 */
			$wp_customize->add_setting( 'lumen_woo_multi_step_checkout', array(
				'default'           	=> false,
				'sanitize_callback' 	=> 'lumenwp_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_multi_step_checkout', array(
				'label'	   				=> esc_html__( 'Multi-Step Checkout', 'lumen' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'lumen_woocommerce_checkout',
				'settings' 				=> 'lumen_woo_multi_step_checkout',
				'priority' 				=> 10,
			) ) );

			/**
			 * Multi-Step Checkout Timeline Style
			 */
			$wp_customize->add_setting( 'lumen_woo_multi_step_checkout_timeline_style', array(
				'transport'				=> 'postMessage',
				'default'           	=> 'arrow',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_woo_multi_step_checkout_timeline_style', array(
				'label'	   				=> esc_html__( 'Timeline Style', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_woocommerce_checkout',
				'settings' 				=> 'lumen_woo_multi_step_checkout_timeline_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'arrow' 		=> esc_html__( 'Arrow', 'lumen' ),
					'square' 		=> esc_html__( 'Square', 'lumen' ),
				),
				'active_callback' 		=> 'lumenwp_cac_has_woo_multistep_checkout',
			) ) );

			/**
		     * Multi-Step Checkout Timeline Background
		     */
	        $wp_customize->add_setting( 'lumen_woo_checkout_timeline_bg', array(
				'default'				=> '#eeeeee',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_checkout_timeline_bg', array(
				'label'					=> esc_html__( 'Timeline: Background', 'lumen' ),
				'section'				=> 'lumen_woocommerce_checkout',
				'settings'				=> 'lumen_woo_checkout_timeline_bg',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_multistep_checkout',
			) ) );

			/**
		     * Multi-Step Checkout Timeline Color
		     */
	        $wp_customize->add_setting( 'lumen_woo_checkout_timeline_color', array(
				'default'				=> '#333333',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_checkout_timeline_color', array(
				'label'					=> esc_html__( 'Timeline: Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_checkout',
				'settings'				=> 'lumen_woo_checkout_timeline_color',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_multistep_checkout',
			) ) );

			/**
		     * Multi-Step Checkout Timeline Number Background
		     */
	        $wp_customize->add_setting( 'lumen_woo_checkout_timeline_number_bg', array(
				'default'				=> '#ffffff',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_checkout_timeline_number_bg', array(
				'label'					=> esc_html__( 'Timeline Number: Background', 'lumen' ),
				'section'				=> 'lumen_woocommerce_checkout',
				'settings'				=> 'lumen_woo_checkout_timeline_number_bg',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_multistep_checkout',
			) ) );

			/**
		     * Multi-Step Checkout Timeline Number Color
		     */
	        $wp_customize->add_setting( 'lumen_woo_checkout_timeline_number_color', array(
				'default'				=> '#cccccc',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_checkout_timeline_number_color', array(
				'label'					=> esc_html__( 'Timeline Number: Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_checkout',
				'settings'				=> 'lumen_woo_checkout_timeline_number_color',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_multistep_checkout',
			) ) );

			/**
		     * Multi-Step Checkout Timeline Number Color
		     */
	        $wp_customize->add_setting( 'lumen_woo_checkout_timeline_number_border_color', array(
				'default'				=> '#cccccc',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_checkout_timeline_number_border_color', array(
				'label'					=> esc_html__( 'Timeline Number: Border Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_checkout',
				'settings'				=> 'lumen_woo_checkout_timeline_number_border_color',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_multistep_checkout',
			) ) );

			/**
		     * Multi-Step Checkout Timeline Background
		     */
	        $wp_customize->add_setting( 'lumen_woo_checkout_timeline_active_bg', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_checkout_timeline_active_bg', array(
				'label'					=> esc_html__( 'Timeline Active: Background', 'lumen' ),
				'section'				=> 'lumen_woocommerce_checkout',
				'settings'				=> 'lumen_woo_checkout_timeline_active_bg',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_multistep_checkout',
			) ) );

			/**
		     * Multi-Step Checkout Timeline Color
		     */
	        $wp_customize->add_setting( 'lumen_woo_checkout_timeline_active_color', array(
				'default'				=> '#ffffff',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_checkout_timeline_active_color', array(
				'label'					=> esc_html__( 'Timeline Active: Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_checkout',
				'settings'				=> 'lumen_woo_checkout_timeline_active_color',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_multistep_checkout',
			) ) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'lumen_woocommerce_styling' , array(
				'title' 				=> esc_html__( 'Advanced Styling', 'lumen' ),
				'priority' 				=> 10,
				'panel' 				=> $panel,
			) );

			/**
		     * On Sale Background
		     */
	        $wp_customize->add_setting( 'lumen_onsale_bg', array(
				'default'				=> '#3fc387',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_onsale_bg', array(
				'label'					=> esc_html__( 'On Sale Background', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_onsale_bg',
				'priority'				=> 10,
			) ) );

			/**
		     * On Sale Color
		     */
	        $wp_customize->add_setting( 'lumen_onsale_color', array(
				'default'				=> '#ffffff',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_onsale_color', array(
				'label'					=> esc_html__( 'On Sale Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_onsale_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Out of Stock Background
		     */
	        $wp_customize->add_setting( 'lumen_outofstock_bg', array(
				'default'				=> '#000000',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_outofstock_bg', array(
				'label'					=> esc_html__( 'Out of Stock Background', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_outofstock_bg',
				'priority'				=> 10,
			) ) );

			/**
		     * Out of Stock Color
		     */
	        $wp_customize->add_setting( 'lumen_outofstock_color', array(
				'default'				=> '#ffffff',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_outofstock_color', array(
				'label'					=> esc_html__( 'Out of Stock Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_outofstock_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Stars Color Before
		     */
	        $wp_customize->add_setting( 'lumen_stars_color_before', array(
				'default'				=> '#dfdbdf',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_stars_color_before', array(
				'label'					=> esc_html__( 'Stars Color Before', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_stars_color_before',
				'priority'				=> 10,
			) ) );

			/**
		     * Stars Color
		     */
	        $wp_customize->add_setting( 'lumen_stars_color', array(
				'default'				=> '#f9ca63',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_stars_color', array(
				'label'					=> esc_html__( 'Stars Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_stars_color',
				'priority'				=> 10,
			) ) );

			/**
			 * Heading Product Entry Toolbar
			 */
			$wp_customize->add_setting( 'lumen_product_entry_toolbar_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_product_entry_toolbar_heading', array(
				'label'    				=> esc_html__( 'Product Entry: Toolbar', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_styling',
				'priority' 				=> 10,
			) ) );

			/**
		     * Tootlbar Border Color
		     */
	        $wp_customize->add_setting( 'lumen_toolbar_border_color', array(
				'default'				=> '#eaeaea',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_toolbar_border_color', array(
				'label'					=> esc_html__( 'Border Top/Bottom Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_toolbar_border_color',
				'priority'				=> 10
			) ) );

			/**
		     * Off Canvas Filter Color
		     */
	        $wp_customize->add_setting( 'lumen_toolbar_off_canvas_filter_color', array(
				'default'				=> '#999999',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_toolbar_off_canvas_filter_color', array(
				'label'					=> esc_html__( 'Off Canvas Filter Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_toolbar_off_canvas_filter_color',
				'priority'				=> 10
			) ) );

			/**
		     * Off Canvas Filter Border Color
		     */
	        $wp_customize->add_setting( 'lumen_toolbar_off_canvas_filter_border_color', array(
				'default'				=> '#eaeaea',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_toolbar_off_canvas_filter_border_color', array(
				'label'					=> esc_html__( 'Off Canvas Filter Border Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_toolbar_off_canvas_filter_border_color',
				'priority'				=> 10
			) ) );

			/**
		     * Off Canvas Filter Hover Color
		     */
	        $wp_customize->add_setting( 'lumen_toolbar_off_canvas_filter_hover_color', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_toolbar_off_canvas_filter_hover_color', array(
				'label'					=> esc_html__( 'Off Canvas Filter Hover Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_toolbar_off_canvas_filter_hover_color',
				'priority'				=> 10
			) ) );

			/**
		     * Off Canvas Filter Hover Border Color
		     */
	        $wp_customize->add_setting( 'lumen_toolbar_off_canvas_filter_hover_border_color', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_toolbar_off_canvas_filter_hover_border_color', array(
				'label'					=> esc_html__( 'Off Canvas Filter Hover Border Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_toolbar_off_canvas_filter_hover_border_color',
				'priority'				=> 10
			) ) );

			/**
		     * Grid/List Color
		     */
	        $wp_customize->add_setting( 'lumen_toolbar_grid_list_color', array(
				'default'				=> '#999999',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_toolbar_grid_list_color', array(
				'label'					=> esc_html__( 'Grid/List Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_toolbar_grid_list_color',
				'priority'				=> 10
			) ) );

			/**
		     * Grid/List Border Color
		     */
	        $wp_customize->add_setting( 'lumen_toolbar_grid_list_border_color', array(
				'default'				=> '#eaeaea',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_toolbar_grid_list_border_color', array(
				'label'					=> esc_html__( 'Grid/List Border Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_toolbar_grid_list_border_color',
				'priority'				=> 10
			) ) );

			/**
		     * Grid/List Hover Color
		     */
	        $wp_customize->add_setting( 'lumen_toolbar_grid_list_hover_color', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_toolbar_grid_list_hover_color', array(
				'label'					=> esc_html__( 'Grid/List Hover Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_toolbar_grid_list_hover_color',
				'priority'				=> 10
			) ) );

			/**
		     * Grid/List Active Color
		     */
	        $wp_customize->add_setting( 'lumen_toolbar_grid_list_active_color', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_toolbar_grid_list_active_color', array(
				'label'					=> esc_html__( 'Grid/List Active Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_toolbar_grid_list_active_color',
				'priority'				=> 10
			) ) );

			/**
		     * Select Color
		     */
	        $wp_customize->add_setting( 'lumen_toolbar_select_color', array(
				'default'				=> '#999999',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_toolbar_select_color', array(
				'label'					=> esc_html__( 'Select Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_toolbar_select_color',
				'priority'				=> 10
			) ) );

			/**
		     * Select Border Color
		     */
	        $wp_customize->add_setting( 'lumen_toolbar_select_border_color', array(
				'default'				=> '#dddddd',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_toolbar_select_border_color', array(
				'label'					=> esc_html__( 'Select Border Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_toolbar_select_border_color',
				'priority'				=> 10
			) ) );

			/**
		     * Number of Products Color
		     */
	        $wp_customize->add_setting( 'lumen_toolbar_number_of_products_color', array(
				'default'				=> '#555555',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_toolbar_number_of_products_color', array(
				'label'					=> esc_html__( 'Number of Products Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_toolbar_number_of_products_color',
				'priority'				=> 10
			) ) );

			/**
		     * Number of Products Inactive Color
		     */
	        $wp_customize->add_setting( 'lumen_toolbar_number_of_products_inactive_color', array(
				'default'				=> '#999999',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_toolbar_number_of_products_inactive_color', array(
				'label'					=> esc_html__( 'Number of Products Inactive Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_toolbar_number_of_products_inactive_color',
				'priority'				=> 10
			) ) );

			/**
		     * Number of Products Border Color
		     */
	        $wp_customize->add_setting( 'lumen_toolbar_number_of_products_border_color', array(
				'default'				=> '#999999',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_toolbar_number_of_products_border_color', array(
				'label'					=> esc_html__( 'Number of Products Border Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_toolbar_number_of_products_border_color',
				'priority'				=> 10
			) ) );

			/**
			 * Heading Product Entry
			 */
			$wp_customize->add_setting( 'lumen_product_entry_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_product_entry_heading', array(
				'label'    				=> esc_html__( 'Product Entry', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_styling',
				'priority' 				=> 10,
			) ) );

			/**
			 * Product Padding
			 */
			$wp_customize->add_setting( 'lumen_product_top_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_product_right_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_product_bottom_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_product_left_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );

			$wp_customize->add_setting( 'lumen_product_tablet_top_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_product_tablet_right_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_product_tablet_bottom_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_product_tablet_left_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_setting( 'lumen_product_mobile_top_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_product_mobile_right_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_product_mobile_bottom_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_product_mobile_left_padding', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Dimensions_Control( $wp_customize, 'lumen_product_padding', array(
				'label'	   				=> esc_html__( 'Padding (px)', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_styling',				
				'settings'   => array(
		            'desktop_top' 		=> 'lumen_product_top_padding',
		            'desktop_right' 	=> 'lumen_product_right_padding',
		            'desktop_bottom' 	=> 'lumen_product_bottom_padding',
		            'desktop_left' 		=> 'lumen_product_left_padding',
		            'tablet_top' 		=> 'lumen_product_tablet_top_padding',
		            'tablet_right' 		=> 'lumen_product_tablet_right_padding',
		            'tablet_bottom' 	=> 'lumen_product_tablet_bottom_padding',
		            'tablet_left' 		=> 'lumen_product_tablet_left_padding',
		            'mobile_top' 		=> 'lumen_product_mobile_top_padding',
		            'mobile_right' 		=> 'lumen_product_mobile_right_padding',
		            'mobile_bottom' 	=> 'lumen_product_mobile_bottom_padding',
		            'mobile_left' 		=> 'lumen_product_mobile_left_padding',
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
			$wp_customize->add_setting( 'lumen_product_image_top_margin', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_product_image_right_margin', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_product_image_bottom_margin', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_product_image_left_margin', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );

			$wp_customize->add_setting( 'lumen_product_image_tablet_top_margin', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_product_image_tablet_right_margin', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_product_image_tablet_bottom_margin', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_product_image_tablet_left_margin', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_setting( 'lumen_product_image_mobile_top_margin', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_product_image_mobile_right_margin', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_product_image_mobile_bottom_margin', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_product_image_mobile_left_margin', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Dimensions_Control( $wp_customize, 'lumen_product_image_margin', array(
				'label'	   				=> esc_html__( 'Image Margin (px)', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_styling',				
				'settings'   => array(
		            'desktop_top' 		=> 'lumen_product_image_top_margin',
		            'desktop_right' 	=> 'lumen_product_image_right_margin',
		            'desktop_bottom' 	=> 'lumen_product_image_bottom_margin',
		            'desktop_left' 		=> 'lumen_product_image_left_margin',
		            'tablet_top' 		=> 'lumen_product_image_tablet_top_margin',
		            'tablet_right' 		=> 'lumen_product_image_tablet_right_margin',
		            'tablet_bottom' 	=> 'lumen_product_image_tablet_bottom_margin',
		            'tablet_left' 		=> 'lumen_product_image_tablet_left_margin',
		            'mobile_top' 		=> 'lumen_product_image_mobile_top_margin',
		            'mobile_right' 		=> 'lumen_product_image_mobile_right_margin',
		            'mobile_bottom' 	=> 'lumen_product_image_mobile_bottom_margin',
		            'mobile_left' 		=> 'lumen_product_image_mobile_left_margin',
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
			$wp_customize->add_setting( 'lumen_product_top_border_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_product_right_border_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_product_bottom_border_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_product_left_border_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );

			$wp_customize->add_setting( 'lumen_product_tablet_top_border_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_product_tablet_right_border_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_product_tablet_bottom_border_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_product_tablet_left_border_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_setting( 'lumen_product_mobile_top_border_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_product_mobile_right_border_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_product_mobile_bottom_border_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_product_mobile_left_border_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Dimensions_Control( $wp_customize, 'lumen_product_border_width', array(
				'label'	   				=> esc_html__( 'Border Width (px)', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_styling',				
				'settings'   => array(
		            'desktop_top' 		=> 'lumen_product_top_border_width',
		            'desktop_right' 	=> 'lumen_product_right_border_width',
		            'desktop_bottom' 	=> 'lumen_product_bottom_border_width',
		            'desktop_left' 		=> 'lumen_product_left_border_width',
		            'tablet_top' 		=> 'lumen_product_tablet_top_border_width',
		            'tablet_right' 		=> 'lumen_product_tablet_right_border_width',
		            'tablet_bottom' 	=> 'lumen_product_tablet_bottom_border_width',
		            'tablet_left' 		=> 'lumen_product_tablet_left_border_width',
		            'mobile_top' 		=> 'lumen_product_mobile_top_border_width',
		            'mobile_right' 		=> 'lumen_product_mobile_right_border_width',
		            'mobile_bottom' 	=> 'lumen_product_mobile_bottom_border_width',
		            'mobile_left' 		=> 'lumen_product_mobile_left_border_width',
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
			$wp_customize->add_setting( 'lumen_product_top_border_radius', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_product_right_border_radius', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_product_bottom_border_radius', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );
			$wp_customize->add_setting( 'lumen_product_left_border_radius', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );

			$wp_customize->add_setting( 'lumen_product_tablet_top_border_radius', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_product_tablet_right_border_radius', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_product_tablet_bottom_border_radius', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_product_tablet_left_border_radius', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_setting( 'lumen_product_mobile_top_border_radius', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_product_mobile_right_border_radius', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_product_mobile_bottom_border_radius', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );
			$wp_customize->add_setting( 'lumen_product_mobile_left_border_radius', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Dimensions_Control( $wp_customize, 'lumen_product_border_radius', array(
				'label'	   				=> esc_html__( 'Border Radius (px)', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_styling',				
				'settings'   => array(
		            'desktop_top' 		=> 'lumen_product_top_border_radius',
		            'desktop_right' 	=> 'lumen_product_right_border_radius',
		            'desktop_bottom' 	=> 'lumen_product_bottom_border_radius',
		            'desktop_left' 		=> 'lumen_product_left_border_radius',
		            'tablet_top' 		=> 'lumen_product_tablet_top_border_radius',
		            'tablet_right' 		=> 'lumen_product_tablet_right_border_radius',
		            'tablet_bottom' 	=> 'lumen_product_tablet_bottom_border_radius',
		            'tablet_left' 		=> 'lumen_product_tablet_left_border_radius',
		            'mobile_top' 		=> 'lumen_product_mobile_top_border_radius',
		            'mobile_right' 		=> 'lumen_product_mobile_right_border_radius',
		            'mobile_bottom' 	=> 'lumen_product_mobile_bottom_border_radius',
		            'mobile_left' 		=> 'lumen_product_mobile_left_border_radius',
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
	        $wp_customize->add_setting( 'lumen_product_background_color', array(
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_product_background_color', array(
				'label'					=> esc_html__( 'Background Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_product_background_color',
				'priority'				=> 10
			) ) );

			/**
		     * Border Color
		     */
	        $wp_customize->add_setting( 'lumen_product_border_color', array(
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_product_border_color', array(
				'label'					=> esc_html__( 'Border Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_product_border_color',
				'priority'				=> 10
			) ) );

			/**
		     * Category Color
		     */
	        $wp_customize->add_setting( 'lumen_category_color', array(
				'default'				=> '#999999',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_category_color', array(
				'label'					=> esc_html__( 'Category Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_category_color',
				'priority'				=> 10
			) ) );

			/**
		     * Category Color Hover
		     */
	        $wp_customize->add_setting( 'lumen_category_color_hover', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_category_color_hover', array(
				'label'					=> esc_html__( 'Category Color: Hover', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_category_color_hover',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Title Color
		     */
	        $wp_customize->add_setting( 'lumen_product_title_color', array(
				'default'				=> '#333333',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_product_title_color', array(
				'label'					=> esc_html__( 'Title Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_product_title_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Title Color Hover
		     */
	        $wp_customize->add_setting( 'lumen_product_title_color_hover', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_product_title_color_hover', array(
				'label'					=> esc_html__( 'Title Color: Hover', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_product_title_color_hover',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Price Color
		     */
	        $wp_customize->add_setting( 'lumen_product_entry_price_color', array(
				'default'				=> '#57bf6d',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_product_entry_price_color', array(
				'label'					=> esc_html__( 'Price Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_product_entry_price_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Del Price Color
		     */
	        $wp_customize->add_setting( 'lumen_product_entry_del_price_color', array(
				'default'				=> '#666666',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_product_entry_del_price_color', array(
				'label'					=> esc_html__( 'Del Price Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_product_entry_del_price_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Hover Thumbnails Border Color
		     */
	        $wp_customize->add_setting( 'lumen_product_entry_hover_thumbnails_border_color', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_product_entry_hover_thumbnails_border_color', array(
				'label'					=> esc_html__( 'Hover: Thumbnails Border Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_product_entry_hover_thumbnails_border_color',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_hover_products_style',
			) ) );

			/**
		     * Product Entry Hover Quick View Background
		     */
	        $wp_customize->add_setting( 'lumen_product_entry_hover_quickview_background', array(
				'default'				=> '#ffffff',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_product_entry_hover_quickview_background', array(
				'label'					=> esc_html__( 'Hover: Quick View Background', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_product_entry_hover_quickview_background',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_hover_products_style',
			) ) );

			/**
		     * Product Entry Hover Quick View Hover Background
		     */
	        $wp_customize->add_setting( 'lumen_product_entry_hover_quickview_hover_background', array(
				'default'				=> '#ffffff',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_product_entry_hover_quickview_hover_background', array(
				'label'					=> esc_html__( 'Hover: Quick View Hover Background', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_product_entry_hover_quickview_hover_background',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_hover_products_style',
			) ) );

			/**
		     * Product Entry Hover Quick View Color
		     */
	        $wp_customize->add_setting( 'lumen_product_entry_hover_quickview_color', array(
				'default'				=> '#444444',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_product_entry_hover_quickview_color', array(
				'label'					=> esc_html__( 'Hover: Quick View Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_product_entry_hover_quickview_color',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_hover_products_style',
			) ) );

			/**
		     * Product Entry Hover Quick View Hover Color
		     */
	        $wp_customize->add_setting( 'lumen_product_entry_hover_quickview_hover_color', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_product_entry_hover_quickview_hover_color', array(
				'label'					=> esc_html__( 'Hover: Quick View Hover Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_product_entry_hover_quickview_hover_color',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_hover_products_style',
			) ) );

			/**
		     * Product Entry Hover Wishlist Background
		     */
	        $wp_customize->add_setting( 'lumen_product_entry_hover_wishlist_background', array(
				'default'				=> '#ffffff',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_product_entry_hover_wishlist_background', array(
				'label'					=> esc_html__( 'Hover: Wishlist Background', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_product_entry_hover_wishlist_background',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_hover_products_style',
			) ) );

			/**
		     * Product Entry Hover Wishlist Hover Background
		     */
	        $wp_customize->add_setting( 'lumen_product_entry_hover_wishlist_hover_background', array(
				'default'				=> '#ffffff',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_product_entry_hover_wishlist_hover_background', array(
				'label'					=> esc_html__( 'Hover: Wishlist Hover Background', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_product_entry_hover_wishlist_hover_background',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_hover_products_style',
			) ) );

			/**
		     * Product Entry Hover Wishlist Color
		     */
	        $wp_customize->add_setting( 'lumen_product_entry_hover_wishlist_color', array(
				'default'				=> '#444444',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_product_entry_hover_wishlist_color', array(
				'label'					=> esc_html__( 'Hover: Wishlist Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_product_entry_hover_wishlist_color',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_hover_products_style',
			) ) );

			/**
		     * Product Entry Hover Wishlist Hover Color
		     */
	        $wp_customize->add_setting( 'lumen_product_entry_hover_wishlist_hover_color', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_product_entry_hover_wishlist_hover_color', array(
				'label'					=> esc_html__( 'Hover: Wishlist Hover Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_product_entry_hover_wishlist_hover_color',
				'priority'				=> 10,
				'active_callback' 		=> 'lumenwp_cac_has_woo_hover_products_style',
			) ) );

			/**
			 * Heading Product Entry Add To Cart
			 */
			$wp_customize->add_setting( 'lumen_product_entry_addtocart_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_product_entry_addtocart_heading', array(
				'label'    				=> esc_html__( 'Product Entry: Add To Cart', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_styling',
				'priority' 				=> 10,
			) ) );

			/**
		     * Product Entry Add To Cart Background Color
		     */
	        $wp_customize->add_setting( 'lumen_product_entry_addtocart_bg_color', array(
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_product_entry_addtocart_bg_color', array(
				'label'					=> esc_html__( 'Add To Cart Background Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_product_entry_addtocart_bg_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Add To Cart Background Color Hover
		     */
	        $wp_customize->add_setting( 'lumen_product_entry_addtocart_bg_color_hover', array(
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_product_entry_addtocart_bg_color_hover', array(
				'label'					=> esc_html__( 'Add To Cart Background Color: Hover', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_product_entry_addtocart_bg_color_hover',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Add To Cart Color
		     */
	        $wp_customize->add_setting( 'lumen_product_entry_addtocart_color', array(
				'default'				=> '#848494',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_product_entry_addtocart_color', array(
				'label'					=> esc_html__( 'Add To Cart Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_product_entry_addtocart_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Add To Cart Color Hover
		     */
	        $wp_customize->add_setting( 'lumen_product_entry_addtocart_color_hover', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_product_entry_addtocart_color_hover', array(
				'label'					=> esc_html__( 'Add To Cart Color: Hover', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_product_entry_addtocart_color_hover',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Add To Cart Border Color
		     */
	        $wp_customize->add_setting( 'lumen_product_entry_addtocart_border_color', array(
				'default'				=> '#e4e4e4',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_product_entry_addtocart_border_color', array(
				'label'					=> esc_html__( 'Add To Cart Border Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_product_entry_addtocart_border_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Add To Cart Border Color Hover
		     */
	        $wp_customize->add_setting( 'lumen_product_entry_addtocart_border_color_hover', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_product_entry_addtocart_border_color_hover', array(
				'label'					=> esc_html__( 'Add To Cart Border Color: Hover', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_product_entry_addtocart_border_color_hover',
				'priority'				=> 10,
			) ) );

			/**
			 * Product Entry Add To Cart Border Style
			 */
			$wp_customize->add_setting( 'lumen_product_entry_addtocart_border_style', array(
				'default'           	=> 'double',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_product_entry_addtocart_border_style', array(
				'label'	   				=> esc_html__( 'Add To Cart Border: Style', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_woocommerce_styling',
				'settings' 				=> 'lumen_product_entry_addtocart_border_style',
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
			$wp_customize->add_setting( 'lumen_product_entry_addtocart_border_size', array(
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'wp_kses_post',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_product_entry_addtocart_border_size', array(
				'label'	   				=> esc_html__( 'Add To Cart Border: Size', 'lumen' ),
				'description' 			=> esc_html__( 'Add a custom border size. px - em - %.', 'lumen' ),
				'type' 					=> 'text',
				'section'  				=> 'lumen_woocommerce_styling',
				'settings' 				=> 'lumen_product_entry_addtocart_border_size',
				'priority' 				=> 10,
			) ) );

			/**
		     * Product Entry Add To Cart Border Radius
		     */
			$wp_customize->add_setting( 'lumen_product_entry_addtocart_border_radius', array(
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'wp_kses_post',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_product_entry_addtocart_border_radius', array(
				'label'	   				=> esc_html__( 'Add To Cart Border: Radius', 'lumen' ),
				'description' 			=> esc_html__( 'Add a custom border radius. px - em - %.', 'lumen' ),
				'type' 					=> 'text',
				'section'  				=> 'lumen_woocommerce_styling',
				'settings' 				=> 'lumen_product_entry_addtocart_border_radius',
				'priority' 				=> 10,
			) ) );

			/**
			 * Heading Quick View
			 */
			$wp_customize->add_setting( 'lumen_woo_quick_view_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_woo_quick_view_heading', array(
				'label'    				=> esc_html__( 'Quick View', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_styling',
				'priority' 				=> 10,
			) ) );

			/**
		     * Quick View Button Background Color
		     */
	        $wp_customize->add_setting( 'lumen_woo_quick_view_button_bg', array(
				'default'				=> 'rgba(0,0,0,0.6)',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_quick_view_button_bg', array(
				'label'					=> esc_html__( 'Button: Background', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_woo_quick_view_button_bg',
				'priority'				=> 10,
			) ) );

			/**
		     * Quick View Button Hover Background Color
		     */
	        $wp_customize->add_setting( 'lumen_woo_quick_view_button_hover_bg', array(
				'default'				=> 'rgba(0,0,0,0.9)',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_quick_view_button_hover_bg', array(
				'label'					=> esc_html__( 'Button: Hover Background', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_woo_quick_view_button_hover_bg',
				'priority'				=> 10,
			) ) );

			/**
		     * Quick View Button Color
		     */
	        $wp_customize->add_setting( 'lumen_woo_quick_view_button_color', array(
				'default'				=> '#ffffff',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_quick_view_button_color', array(
				'label'					=> esc_html__( 'Button: Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_woo_quick_view_button_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Quick View Button Hover Color
		     */
	        $wp_customize->add_setting( 'lumen_woo_quick_view_button_hover_color', array(
				'default'				=> '#ffffff',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_quick_view_button_hover_color', array(
				'label'					=> esc_html__( 'Button: Hover Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_woo_quick_view_button_hover_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Quick View Overlay Background Color
		     */
	        $wp_customize->add_setting( 'lumen_woo_quick_view_overlay_bg', array(
				'default'				=> 'rgba(0,0,0,0.15)',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_quick_view_overlay_bg', array(
				'label'					=> esc_html__( 'Overlay: Background', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_woo_quick_view_overlay_bg',
				'priority'				=> 10,
			) ) );

			/**
		     * Quick View Overlay Spinner Outside Color
		     */
	        $wp_customize->add_setting( 'lumen_woo_quick_view_overlay_spinner_outside_color', array(
				'default'				=> 'rgba(0,0,0,0.1)',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_quick_view_overlay_spinner_outside_color', array(
				'label'					=> esc_html__( 'Overlay Spinner: Outside Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_woo_quick_view_overlay_spinner_outside_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Quick View Overlay Spinner Inner Color
		     */
	        $wp_customize->add_setting( 'lumen_woo_quick_view_overlay_spinner_inner_color', array(
				'default'				=> '#ffffff',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_quick_view_overlay_spinner_inner_color', array(
				'label'					=> esc_html__( 'Overlay Spinner: Inner Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_woo_quick_view_overlay_spinner_inner_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Quick View Modal Background Color
		     */
	        $wp_customize->add_setting( 'lumen_woo_quick_view_modal_bg', array(
				'default'				=> '#ffffff',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_quick_view_modal_bg', array(
				'label'					=> esc_html__( 'Modal: Background', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_woo_quick_view_modal_bg',
				'priority'				=> 10,
			) ) );

			/**
		     * Quick View Modal Close Button Color
		     */
	        $wp_customize->add_setting( 'lumen_woo_quick_view_modal_close_color', array(
				'default'				=> '#333333',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_quick_view_modal_close_color', array(
				'label'					=> esc_html__( 'Modal Close Button: Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_woo_quick_view_modal_close_color',
				'priority'				=> 10,
			) ) );

			/**
			 * Heading Off Canvas Sidebar
			 */
			$wp_customize->add_setting( 'lumen_woo_off_canvas_sidebar_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_woo_off_canvas_sidebar_heading', array(
				'label'    				=> esc_html__( 'Off Canvas Sidebar', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_styling',
				'priority' 				=> 10,
			) ) );

			/**
		     * Off Canvas Sidebar Background Color
		     */
	        $wp_customize->add_setting( 'lumen_woo_off_canvas_sidebar_bg', array(
				'default'				=> '#ffffff',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_off_canvas_sidebar_bg', array(
				'label'					=> esc_html__( 'Background Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_woo_off_canvas_sidebar_bg',
				'priority'				=> 10,
			) ) );

			/**
		     * Off Canvas Sidebar Widgets Border Color
		     */
	        $wp_customize->add_setting( 'lumen_woo_off_canvas_sidebar_widgets_border', array(
				'default'				=> 'rgba(84,84,84,0.15)',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_woo_off_canvas_sidebar_widgets_border', array(
				'label'					=> esc_html__( 'Widgets Border Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_woo_off_canvas_sidebar_widgets_border',
				'priority'				=> 10,
			) ) );

			/**
			 * Heading Single Product
			 */
			$wp_customize->add_setting( 'lumen_single_product_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_single_product_heading', array(
				'label'    				=> esc_html__( 'Single Product', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_styling',
				'priority' 				=> 10,
			) ) );

			/**
		     * Single Product Title Color
		     */
	        $wp_customize->add_setting( 'lumen_single_product_title_color', array(
				'default'				=> '#333333',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_single_product_title_color', array(
				'label'					=> esc_html__( 'Title Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_single_product_title_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Price Color
		     */
	        $wp_customize->add_setting( 'lumen_single_product_price_color', array(
				'default'				=> '#57bf6d',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_single_product_price_color', array(
				'label'					=> esc_html__( 'Price Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_single_product_price_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Del Price Color
		     */
	        $wp_customize->add_setting( 'lumen_single_product_del_price_color', array(
				'default'				=> '#555555',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_single_product_del_price_color', array(
				'label'					=> esc_html__( 'Del Price Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_single_product_del_price_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Description Color
		     */
	        $wp_customize->add_setting( 'lumen_single_product_description_color', array(
				'default'				=> '#aaaaaa',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_single_product_description_color', array(
				'label'					=> esc_html__( 'Description Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_single_product_description_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Quantity Border Color
		     */
	        $wp_customize->add_setting( 'lumen_quantity_border_color', array(
				'default'				=> '#e4e4e4',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_quantity_border_color', array(
				'label'					=> esc_html__( 'Quantity Border Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_quantity_border_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Quantity Border Color Focus
		     */
	        $wp_customize->add_setting( 'lumen_quantity_border_color_focus', array(
				'default'				=> '#bbbbbb',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_quantity_border_color_focus', array(
				'label'					=> esc_html__( 'Quantity Border Color Focus', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_quantity_border_color_focus',
				'priority'				=> 10,
			) ) );

			/**
		     * Quantity Color
		     */
	        $wp_customize->add_setting( 'lumen_quantity_color', array(
				'default'				=> '#777777',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_quantity_color', array(
				'label'					=> esc_html__( 'Quantity Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_quantity_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Quantity Plus/Minus Color
		     */
	        $wp_customize->add_setting( 'lumen_quantity_plus_minus_color', array(
				'default'				=> '#cccccc',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_quantity_plus_minus_color', array(
				'label'					=> esc_html__( 'Quantity Plus/Minus Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_quantity_plus_minus_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Quantity Plus/Minus Color Hover
		     */
	        $wp_customize->add_setting( 'lumen_quantity_plus_minus_color_hover', array(
				'default'				=> '#cccccc',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_quantity_plus_minus_color_hover', array(
				'label'					=> esc_html__( 'Quantity Plus/Minus Color: Hover', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_quantity_plus_minus_color_hover',
				'priority'				=> 10,
			) ) );

			/**
		     * Quantity Plus/Minus Border Color Hover
		     */
	        $wp_customize->add_setting( 'lumen_quantity_plus_minus_border_color_hover', array(
				'default'				=> '#e0e0e0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_quantity_plus_minus_border_color_hover', array(
				'label'					=> esc_html__( 'Quantity Plus/Minus Border Color: Hover', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_quantity_plus_minus_border_color_hover',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Meta Title Color
		     */
	        $wp_customize->add_setting( 'lumen_single_product_meta_title_color', array(
				'default'				=> '#333333',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_single_product_meta_title_color', array(
				'label'					=> esc_html__( 'Meta Title Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_single_product_meta_title_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Meta Link Color
		     */
	        $wp_customize->add_setting( 'lumen_single_product_meta_link_color', array(
				'default'				=> '#aaaaaa',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_single_product_meta_link_color', array(
				'label'					=> esc_html__( 'Meta Link Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_single_product_meta_link_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Meta Link Color Hover
		     */
	        $wp_customize->add_setting( 'lumen_single_product_meta_link_color_hover', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_single_product_meta_link_color_hover', array(
				'label'					=> esc_html__( 'Meta Link Color: Hover', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_single_product_meta_link_color_hover',
				'priority'				=> 10,
			) ) );

			/**
			 * Heading Single Product Navigation
			 */
			$wp_customize->add_setting( 'lumen_single_product_navigation_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_single_product_navigation_heading', array(
				'label'    				=> esc_html__( 'Single Product: Product Navigation', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_styling',
				'priority' 				=> 10,
			) ) );

			/**
			 * Single Product Navigation Border Radius
			 */
			$wp_customize->add_setting( 'lumen_single_product_navigation_border_radius', array(
				'transport' 			=> 'postMessage',
				'default'           	=> '30',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Range_Control( $wp_customize, 'lumen_single_product_navigation_border_radius', array(
				'label'	   				=> esc_html__( 'Border Radius (px)', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_styling',
				'settings' 				=> 'lumen_single_product_navigation_border_radius',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 30,
			        'step'  => 1,
			    ),
			) ) );

			/**
		     * Single Product Navigation Background Color
		     */
	        $wp_customize->add_setting( 'lumen_single_product_navigation_bg', array(
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_single_product_navigation_bg', array(
				'label'					=> esc_html__( 'Background Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_single_product_navigation_bg',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Navigation Hover Background Color
		     */
	        $wp_customize->add_setting( 'lumen_single_product_navigation_hover_bg', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_single_product_navigation_hover_bg', array(
				'label'					=> esc_html__( 'Background Color: Hover', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_single_product_navigation_hover_bg',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Navigation Color
		     */
	        $wp_customize->add_setting( 'lumen_single_product_navigation_color', array(
				'default'				=> '#333333',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_single_product_navigation_color', array(
				'label'					=> esc_html__( 'Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_single_product_navigation_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Navigation Hover Color
		     */
	        $wp_customize->add_setting( 'lumen_single_product_navigation_hover_color', array(
				'default'				=> '#ffffff',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_single_product_navigation_hover_color', array(
				'label'					=> esc_html__( 'Color: Hover', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_single_product_navigation_hover_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Navigation Border Color
		     */
	        $wp_customize->add_setting( 'lumen_single_product_navigation_border_color', array(
				'default'				=> '#e9e9e9',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_single_product_navigation_border_color', array(
				'label'					=> esc_html__( 'Border Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_single_product_navigation_border_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Navigation Hover Border Color
		     */
	        $wp_customize->add_setting( 'lumen_single_product_navigation_hover_border_color', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_single_product_navigation_hover_border_color', array(
				'label'					=> esc_html__( 'Border Color: Hover', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_single_product_navigation_hover_border_color',
				'priority'				=> 10,
			) ) );

			/**
			 * Heading Product Entry Add To Cart
			 */
			$wp_customize->add_setting( 'lumen_single_product_addtocart_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_single_product_addtocart_heading', array(
				'label'    				=> esc_html__( 'Single Product: Add To Cart', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_styling',
				'priority' 				=> 10,
			) ) );

			/**
		     * Product Entry Add To Cart Background Color
		     */
	        $wp_customize->add_setting( 'lumen_single_product_addtocart_bg_color', array(
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_single_product_addtocart_bg_color', array(
				'label'					=> esc_html__( 'Add To Cart Background Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_single_product_addtocart_bg_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Add To Cart Background Color Hover
		     */
	        $wp_customize->add_setting( 'lumen_single_product_addtocart_bg_color_hover', array(
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_single_product_addtocart_bg_color_hover', array(
				'label'					=> esc_html__( 'Add To Cart Background Color: Hover', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_single_product_addtocart_bg_color_hover',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Add To Cart Color
		     */
	        $wp_customize->add_setting( 'lumen_single_product_addtocart_color', array(
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_single_product_addtocart_color', array(
				'label'					=> esc_html__( 'Add To Cart Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_single_product_addtocart_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Add To Cart Color Hover
		     */
	        $wp_customize->add_setting( 'lumen_single_product_addtocart_color_hover', array(
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_single_product_addtocart_color_hover', array(
				'label'					=> esc_html__( 'Add To Cart Color: Hover', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_single_product_addtocart_color_hover',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Add To Cart Border Color
		     */
	        $wp_customize->add_setting( 'lumen_single_product_addtocart_border_color', array(
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_single_product_addtocart_border_color', array(
				'label'					=> esc_html__( 'Add To Cart Border Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_single_product_addtocart_border_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Product Entry Add To Cart Border Color Hover
		     */
	        $wp_customize->add_setting( 'lumen_single_product_addtocart_border_color_hover', array(
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_single_product_addtocart_border_color_hover', array(
				'label'					=> esc_html__( 'Add To Cart Border Color: Hover', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_single_product_addtocart_border_color_hover',
				'priority'				=> 10,
			) ) );

			/**
			 * Product Entry Add To Cart Border Style
			 */
			$wp_customize->add_setting( 'lumen_single_product_addtocart_border_style', array(
				'default'				=> 'none',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_single_product_addtocart_border_style', array(
				'label'	   				=> esc_html__( 'Add To Cart Border: Style', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_woocommerce_styling',
				'settings' 				=> 'lumen_single_product_addtocart_border_style',
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
			$wp_customize->add_setting( 'lumen_single_product_addtocart_border_size', array(
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'wp_kses_post',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_single_product_addtocart_border_size', array(
				'label'	   				=> esc_html__( 'Add To Cart Border: Size', 'lumen' ),
				'description' 			=> esc_html__( 'Add a custom border size. px - em - %.', 'lumen' ),
				'type' 					=> 'text',
				'section'  				=> 'lumen_woocommerce_styling',
				'settings' 				=> 'lumen_single_product_addtocart_border_size',
				'priority' 				=> 10,
			) ) );

			/**
		     * Product Entry Add To Cart Border Radius
		     */
			$wp_customize->add_setting( 'lumen_single_product_addtocart_border_radius', array(
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'wp_kses_post',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_single_product_addtocart_border_radius', array(
				'label'	   				=> esc_html__( 'Add To Cart Border: Radius', 'lumen' ),
				'description' 			=> esc_html__( 'Add a custom border radius. px - em - %.', 'lumen' ),
				'type' 					=> 'text',
				'section'  				=> 'lumen_woocommerce_styling',
				'settings' 				=> 'lumen_single_product_addtocart_border_radius',
				'priority' 				=> 10,
			) ) );

			/**
			 * Heading Product Tabs
			 */
			$wp_customize->add_setting( 'lumen_single_product_tabs_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_single_product_tabs_heading', array(
				'label'    				=> esc_html__( 'Single Product: Tabs', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_styling',
				'priority' 				=> 10,
			) ) );

			/**
		     * Single Product Tabs Borders Color
		     */
	        $wp_customize->add_setting( 'lumen_single_product_tabs_borders_color', array(
				'default'				=> '#e9e9e9',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_single_product_tabs_borders_color', array(
				'label'					=> esc_html__( 'Borders Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_single_product_tabs_borders_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Tabs Text Color
		     */
	        $wp_customize->add_setting( 'lumen_single_product_tabs_text_color', array(
				'default'				=> '#999999',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_single_product_tabs_text_color', array(
				'label'					=> esc_html__( 'Text Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_single_product_tabs_text_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Tabs Text Color Hover
		     */
	        $wp_customize->add_setting( 'lumen_single_product_tabs_text_color_hover', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_single_product_tabs_text_color_hover', array(
				'label'					=> esc_html__( 'Text Color: Hover', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_single_product_tabs_text_color_hover',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Tabs Active Text Color
		     */
	        $wp_customize->add_setting( 'lumen_single_product_tabs_active_text_color', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_single_product_tabs_active_text_color', array(
				'label'					=> esc_html__( 'Active Text Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_single_product_tabs_active_text_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Tabs Active Text Borders Color
		     */
	        $wp_customize->add_setting( 'lumen_single_product_tabs_active_text_borders_color', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_single_product_tabs_active_text_borders_color', array(
				'label'					=> esc_html__( 'Active Text Borders Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_single_product_tabs_active_text_borders_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Tabs Product Description Color
		     */
	        $wp_customize->add_setting( 'lumen_single_product_tabs_product_description_title_color', array(
				'default'				=> '#333333',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_single_product_tabs_product_description_title_color', array(
				'label'					=> esc_html__( 'Product Description: Title Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_single_product_tabs_product_description_title_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Single Product Tabs Product Description Color
		     */
	        $wp_customize->add_setting( 'lumen_single_product_tabs_product_description_color', array(
				'default'				=> '#929292',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_single_product_tabs_product_description_color', array(
				'label'					=> esc_html__( 'Product Description: Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_single_product_tabs_product_description_color',
				'priority'				=> 10,
			) ) );

			/**
			 * Heading Account
			 */
			$wp_customize->add_setting( 'lumen_account_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_account_heading', array(
				'label'    				=> esc_html__( 'Account', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_styling',
				'priority' 				=> 10,
			) ) );

			/**
		     * Account Login/Register Links Color
		     */
	        $wp_customize->add_setting( 'lumen_account_login_register_color', array(
				'default'				=> '#333333',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_account_login_register_color', array(
				'label'					=> esc_html__( 'Login/Register Links: Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_account_login_register_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Navigation Borders Color
		     */
	        $wp_customize->add_setting( 'lumen_account_navigation_borders_color', array(
				'default'				=> '#e9e9e9',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_account_navigation_borders_color', array(
				'label'					=> esc_html__( 'Navigation: Borders Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_account_navigation_borders_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Navigation Icons Color
		     */
	        $wp_customize->add_setting( 'lumen_account_navigation_icons_color', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_account_navigation_icons_color', array(
				'label'					=> esc_html__( 'Navigation: Icons Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_account_navigation_icons_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Navigation Links Color
		     */
	        $wp_customize->add_setting( 'lumen_account_navigation_links_color', array(
				'default'				=> '#333333',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_account_navigation_links_color', array(
				'label'					=> esc_html__( 'Navigation: Links Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_account_navigation_links_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Navigation Links Color Hover
		     */
	        $wp_customize->add_setting( 'lumen_account_navigation_links_color_hover', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_account_navigation_links_color_hover', array(
				'label'					=> esc_html__( 'Navigation: Links Color: Hover', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_account_navigation_links_color_hover',
				'priority'				=> 10,
			) ) );

			/**
		     * Addresses Box Background
		     */
	        $wp_customize->add_setting( 'lumen_account_addresses_bg', array(
				'default'				=> '#f6f6f6',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_account_addresses_bg', array(
				'label'					=> esc_html__( 'Addresses: Box Background', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_account_addresses_bg',
				'priority'				=> 10,
			) ) );

			/**
		     * Addresses Box Title Color
		     */
	        $wp_customize->add_setting( 'lumen_account_addresses_title_color', array(
				'default'				=> '#333333',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_account_addresses_title_color', array(
				'label'					=> esc_html__( 'Addresses: Box Title Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_account_addresses_title_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Addresses Box Title Border Bottom Color
		     */
	        $wp_customize->add_setting( 'lumen_account_addresses_title_border_color', array(
				'default'				=> '#ffffff',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_account_addresses_title_border_color', array(
				'label'					=> esc_html__( 'Addresses: Box Title Border Bottom Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_account_addresses_title_border_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Addresses Box Content Color
		     */
	        $wp_customize->add_setting( 'lumen_account_addresses_content_color', array(
				'default'				=> '#898989',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_account_addresses_content_color', array(
				'label'					=> esc_html__( 'Addresses: Box Content Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_account_addresses_content_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Addresses Box Button Background Color
		     */
	        $wp_customize->add_setting( 'lumen_account_addresses_button_bg', array(
				'default'				=> '#ffffff',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_account_addresses_button_bg', array(
				'label'					=> esc_html__( 'Addresses: Box Button Background', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_account_addresses_button_bg',
				'priority'				=> 10,
			) ) );

			/**
		     * Addresses Box Button Background Color Hover
		     */
	        $wp_customize->add_setting( 'lumen_account_addresses_button_bg_hover', array(
				'default'				=> '#f8f8f8',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_account_addresses_button_bg_hover', array(
				'label'					=> esc_html__( 'Addresses: Box Button Background: Hover', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_account_addresses_button_bg_hover',
				'priority'				=> 10,
			) ) );

			/**
		     * Addresses Box Button Color
		     */
	        $wp_customize->add_setting( 'lumen_account_addresses_button_color', array(
				'default'				=> '#898989',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_account_addresses_button_color', array(
				'label'					=> esc_html__( 'Addresses: Box Button color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_account_addresses_button_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Addresses Box Button Color Hover
		     */
	        $wp_customize->add_setting( 'lumen_account_addresses_button_color_hover', array(
				'default'				=> '#555555',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_account_addresses_button_color_hover', array(
				'label'					=> esc_html__( 'Addresses: Box Button color: Hover', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_account_addresses_button_color_hover',
				'priority'				=> 10,
			) ) );

			/**
			 * Heading Cart
			 */
			$wp_customize->add_setting( 'lumen_cart_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_cart_heading', array(
				'label'    				=> esc_html__( 'Cart', 'lumen' ),
				'section'  				=> 'lumen_woocommerce_styling',
				'priority' 				=> 10,
			) ) );

			/**
		     * Borders Color
		     */
	        $wp_customize->add_setting( 'lumen_cart_borders_color', array(
				'default'				=> '#e9e9e9',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_cart_borders_color', array(
				'label'					=> esc_html__( 'Borders Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_cart_borders_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Head Background
		     */
	        $wp_customize->add_setting( 'lumen_cart_head_bg', array(
				'default'				=> '#f7f7f7',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_cart_head_bg', array(
				'label'					=> esc_html__( 'Head Background', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_cart_head_bg',
				'priority'				=> 10,
			) ) );

			/**
		     * Head Titles Color
		     */
	        $wp_customize->add_setting( 'lumen_cart_head_titles_color', array(
				'default'				=> '#444444',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_cart_head_titles_color', array(
				'label'					=> esc_html__( 'Head Titles Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_cart_head_titles_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Cart Totals Table Titles Color
		     */
	        $wp_customize->add_setting( 'lumen_cart_totals_table_titles_color', array(
				'default'				=> '#444444',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_cart_totals_table_titles_color', array(
				'label'					=> esc_html__( 'Cart Totals Table: Titles Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_cart_totals_table_titles_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Remove Button Color
		     */
	        $wp_customize->add_setting( 'lumen_cart_remove_button_color', array(
				'default'				=> '#bbbbbb',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );
			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_cart_remove_button_color', array(
				'label'					=> esc_html__( 'Remove Button Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_cart_remove_button_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Remove Button Color Hover
		     */
	        $wp_customize->add_setting( 'lumen_cart_remove_button_color_hover', array(
				'default'				=> '#333333',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_cart_remove_button_color_hover', array(
				'label'					=> esc_html__( 'Remove Button Color: Hover', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_cart_remove_button_color_hover',
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
				'section'  				=> 'lumen_woocommerce_styling',
				'priority' 				=> 10,
			) ) );

			/**
		     * Notices Borders Color
		     */
	        $wp_customize->add_setting( 'lumen_checkout_notices_borders_color', array(
				'default'				=> '#e9e9e9',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_checkout_notices_borders_color', array(
				'label'					=> esc_html__( 'Notices: Borders Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_checkout_notices_borders_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Notices Icon Color
		     */
	        $wp_customize->add_setting( 'lumen_checkout_notices_icon_color', array(
				'default'				=> '#dddddd',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_checkout_notices_icon_color', array(
				'label'					=> esc_html__( 'Notices: Icon Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_checkout_notices_icon_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Notices Color
		     */
	        $wp_customize->add_setting( 'lumen_checkout_notices_color', array(
				'default'				=> '#777777',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_checkout_notices_color', array(
				'label'					=> esc_html__( 'Notices: Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_checkout_notices_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Notices Link Color
		     */
	        $wp_customize->add_setting( 'lumen_checkout_notices_link_color', array(
				'default'				=> '#13aff0',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_checkout_notices_link_color', array(
				'label'					=> esc_html__( 'Notices: Link Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_checkout_notices_link_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Notices Link Color Hover
		     */
	        $wp_customize->add_setting( 'lumen_checkout_notices_link_color_hover', array(
				'default'				=> '#333333',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_checkout_notices_link_color_hover', array(
				'label'					=> esc_html__( 'Notices: Link Color: Hover', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_checkout_notices_link_color_hover',
				'priority'				=> 10,
			) ) );

			/**
		     * Notices Form Border Color
		     */
	        $wp_customize->add_setting( 'lumen_checkout_notices_form_border_color', array(
				'default'				=> '#e9e9e9',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_checkout_notices_form_border_color', array(
				'label'					=> esc_html__( 'Notices Form: Border Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_checkout_notices_form_border_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Titles Color
		     */
	        $wp_customize->add_setting( 'lumen_checkout_titles_color', array(
				'default'				=> '#333333',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_checkout_titles_color', array(
				'label'					=> esc_html__( 'Titles Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_checkout_titles_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Titles Border Bottom Color
		     */
	        $wp_customize->add_setting( 'lumen_checkout_titles_border_bottom_color', array(
				'default'				=> '#e9e9e9',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_checkout_titles_border_bottom_color', array(
				'label'					=> esc_html__( 'Titles Border Bottom Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_checkout_titles_border_bottom_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Table Main Background
		     */
	        $wp_customize->add_setting( 'lumen_checkout_table_main_bg', array(
				'default'				=> '#f7f7f7',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_checkout_table_main_bg', array(
				'label'					=> esc_html__( 'Table Main Background', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_checkout_table_main_bg',
				'priority'				=> 10,
			) ) );

			/**
		     * Table Titles Color
		     */
	        $wp_customize->add_setting( 'lumen_checkout_table_titles_color', array(
				'default'				=> '#444444',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_checkout_table_titles_color', array(
				'label'					=> esc_html__( 'Table Titles Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_checkout_table_titles_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Table Borders Color
		     */
	        $wp_customize->add_setting( 'lumen_checkout_table_borders_color', array(
				'default'				=> '#e9e9e9',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_checkout_table_borders_color', array(
				'label'					=> esc_html__( 'Table Borders Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_checkout_table_borders_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Payment Methods Background
		     */
	        $wp_customize->add_setting( 'lumen_checkout_payment_methods_bg', array(
				'default'				=> '#f8f8f8',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_checkout_payment_methods_bg', array(
				'label'					=> esc_html__( 'Payment Methods Background', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_checkout_payment_methods_bg',
				'priority'				=> 10,
			) ) );

			/**
		     * Payment Methods Borders Color
		     */
	        $wp_customize->add_setting( 'lumen_checkout_payment_methods_borders_color', array(
				'default'				=> '#e9e9e9',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_checkout_payment_methods_borders_color', array(
				'label'					=> esc_html__( 'Payment Methods Borders Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_checkout_payment_methods_borders_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Payment Box Background
		     */
	        $wp_customize->add_setting( 'lumen_checkout_payment_box_bg', array(
				'default'				=> '#ffffff',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_checkout_payment_box_bg', array(
				'label'					=> esc_html__( 'Payment Box Background', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_checkout_payment_box_bg',
				'priority'				=> 10,
			) ) );

			/**
		     * Payment Box Color
		     */
	        $wp_customize->add_setting( 'lumen_checkout_payment_box_color', array(
				'default'				=> '#515151',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_checkout_payment_box_color', array(
				'label'					=> esc_html__( 'Payment Box Color', 'lumen' ),
				'section'				=> 'lumen_woocommerce_styling',
				'settings'				=> 'lumen_checkout_payment_box_color',
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
			$menu_icon_size										= get_theme_mod( 'lumen_woo_menu_icon_size' );
			$menu_icon_size_tablet								= get_theme_mod( 'lumen_woo_menu_icon_size_tablet' );
			$menu_icon_size_mobile								= get_theme_mod( 'lumen_woo_menu_icon_size_mobile' );
			$menu_icon_center_vertically						= get_theme_mod( 'lumen_woo_menu_icon_center_vertically' );
			$menu_icon_center_vertically_tablet					= get_theme_mod( 'lumen_woo_menu_icon_center_vertically_tablet' );
			$menu_icon_center_vertically_mobile					= get_theme_mod( 'lumen_woo_menu_icon_center_vertically_mobile' );
			$cart_dropdown_width 								= get_theme_mod( 'lumen_woo_cart_dropdown_width', '350' );
			$woo_menu_bag_icon_color 							= get_theme_mod( 'lumen_woo_menu_bag_icon_color', '#333333' );
			$woo_menu_bag_icon_hover_color 						= get_theme_mod( 'lumen_woo_menu_bag_icon_hover_color', '#13aff0' );
			$woo_menu_bag_icon_count_color 						= get_theme_mod( 'lumen_woo_menu_bag_icon_count_color', '#333333' );
			$woo_menu_bag_icon_hover_count_color 				= get_theme_mod( 'lumen_woo_menu_bag_icon_hover_count_color', '#ffffff' );
			$cart_dropdown_bg 									= get_theme_mod( 'lumen_woo_cart_dropdown_bg', '#ffffff' );
			$cart_dropdown_borders 								= get_theme_mod( 'lumen_woo_cart_dropdown_borders', '#e6e6e6' );
			$cart_dropdown_link_color 							= get_theme_mod( 'lumen_woo_cart_dropdown_link_color', '#333333' );
			$cart_dropdown_link_color_hover 					= get_theme_mod( 'lumen_woo_cart_dropdown_link_color_hover', '#13aff0' );
			$cart_dropdown_remove_link_color					= get_theme_mod( 'lumen_woo_cart_dropdown_remove_link_color', '#b3b3b3' );
			$cart_dropdown_remove_link_color_hover				= get_theme_mod( 'lumen_woo_cart_dropdown_remove_link_color_hover', '#13aff0' );
			$cart_dropdown_quantity_color						= get_theme_mod( 'lumen_woo_cart_dropdown_quantity_color', '#b2b2b2' );
			$cart_dropdown_price_color							= get_theme_mod( 'lumen_woo_cart_dropdown_price_color', '#57bf6d' );
			$cart_dropdown_subtotal_bg							= get_theme_mod( 'lumen_woo_cart_dropdown_subtotal_bg', '#fafafa' );
			$cart_dropdown_subtotal_color						= get_theme_mod( 'lumen_woo_cart_dropdown_subtotal_color', '#797979' );
			$cart_dropdown_total_price_color					= get_theme_mod( 'lumen_woo_cart_dropdown_total_price_color', '#57bf6d' );
			$cart_dropdown_cart_button_bg						= get_theme_mod( 'lumen_woo_cart_dropdown_cart_button_bg' );
			$cart_dropdown_cart_button_hover_bg					= get_theme_mod( 'lumen_woo_cart_dropdown_cart_button_hover_bg' );
			$cart_dropdown_cart_button_color					= get_theme_mod( 'lumen_woo_cart_dropdown_cart_button_color' );
			$cart_dropdown_cart_button_hover_color				= get_theme_mod( 'lumen_woo_cart_dropdown_cart_button_hover_color' );
			$cart_dropdown_cart_button_border_color				= get_theme_mod( 'lumen_woo_cart_dropdown_cart_button_border_color' );
			$cart_dropdown_cart_button_hover_border_color		= get_theme_mod( 'lumen_woo_cart_dropdown_cart_button_hover_border_color' );
			$cart_dropdown_checkout_button_bg					= get_theme_mod( 'lumen_woo_cart_dropdown_checkout_button_bg' );
			$cart_dropdown_checkout_button_hover_bg				= get_theme_mod( 'lumen_woo_cart_dropdown_checkout_button_hover_bg' );
			$cart_dropdown_checkout_button_color				= get_theme_mod( 'lumen_woo_cart_dropdown_checkout_button_color' );
			$cart_dropdown_checkout_button_hover_color			= get_theme_mod( 'lumen_woo_cart_dropdown_checkout_button_hover_color' );
			$woo_mobile_cart_sidebar_bg							= get_theme_mod( 'lumen_woo_mobile_cart_sidebar_bg', '#ffffff' );
			$woo_mobile_cart_sidebar_close_button_color			= get_theme_mod( 'lumen_woo_mobile_cart_sidebar_close_button_color', '#000000' );
			$woo_mobile_cart_sidebar_title_color				= get_theme_mod( 'lumen_woo_mobile_cart_sidebar_title_color', '#555555' );
			$woo_mobile_cart_sidebar_divider_color				= get_theme_mod( 'lumen_woo_mobile_cart_sidebar_divider_color', 'rgba(0,0,0,0.1)' );
		
			// Styling vars
			$off_canvas_close_button_color 						= get_theme_mod( 'lumen_woo_off_canvas_close_button_color', '#333333' );
			$off_canvas_close_button_hover_color 				= get_theme_mod( 'lumen_woo_off_canvas_close_button_hover_color', '#777777' );
			$infinite_scroll_spinners_color 					= get_theme_mod( 'lumen_woo_infinite_scroll_spinners_color', '#333333' );
			$woo_product_image_width 							= get_theme_mod( 'lumen_woo_product_image_width', '52' );
			$woo_product_summary_width 							= get_theme_mod( 'lumen_woo_product_summary_width', '44' );
			$floating_bar_bg 									= get_theme_mod( 'lumen_woo_floating_bar_bg', '#2c2c2c' );
			$floating_bar_title_color 							= get_theme_mod( 'lumen_woo_floating_bar_title_color', '#ffffff' );
			$floating_bar_price_color 							= get_theme_mod( 'lumen_woo_floating_bar_price_color', '#ffffff' );
			$floating_bar_quantity_buttons_bg 					= get_theme_mod( 'lumen_woo_floating_bar_quantity_buttons_bg', 'rgba(255,255,255,0.1)' );
			$floating_bar_quantity_buttons_hover_bg 			= get_theme_mod( 'lumen_woo_floating_bar_quantity_buttons_hover_bg', 'rgba(255,255,255,0.2)' );
			$floating_bar_quantity_buttons_color 				= get_theme_mod( 'lumen_woo_floating_bar_quantity_buttons_color', '#ffffff' );
			$floating_bar_quantity_buttons_hover_color 			= get_theme_mod( 'lumen_woo_floating_bar_quantity_buttons_hover_color', '#ffffff' );
			$floating_bar_quantity_input_bg 					= get_theme_mod( 'lumen_woo_floating_bar_quantity_input_bg', 'rgba(255,255,255,0.2)' );
			$floating_bar_quantity_input_color 					= get_theme_mod( 'lumen_woo_floating_bar_quantity_input_color', '#ffffff' );
			$floating_bar_addtocart_bg 							= get_theme_mod( 'lumen_woo_floating_bar_addtocart_bg', '#ffffff' );
			$floating_bar_addtocart_hover_bg 					= get_theme_mod( 'lumen_woo_floating_bar_addtocart_hover_bg', '#f1f1f1' );
			$floating_bar_addtocart_color 						= get_theme_mod( 'lumen_woo_floating_bar_addtocart_color', '#000000' );
			$floating_bar_addtocart_hover_color 				= get_theme_mod( 'lumen_woo_floating_bar_addtocart_hover_color', '#000000' );
			$checkout_timeline_bg 								= get_theme_mod( 'lumen_woo_checkout_timeline_bg', '#eeeeee' );
			$checkout_timeline_color 							= get_theme_mod( 'lumen_woo_checkout_timeline_color', '#333333' );
			$checkout_timeline_number_bg 						= get_theme_mod( 'lumen_woo_checkout_timeline_number_bg', '#ffffff' );
			$checkout_timeline_number_color 					= get_theme_mod( 'lumen_woo_checkout_timeline_number_color', '#cccccc' );
			$checkout_timeline_number_border_color 				= get_theme_mod( 'lumen_woo_checkout_timeline_number_border_color', '#cccccc' );
			$checkout_timeline_active_bg 						= get_theme_mod( 'lumen_woo_checkout_timeline_active_bg', '#13aff0' );
			$checkout_timeline_active_color 					= get_theme_mod( 'lumen_woo_checkout_timeline_active_color', '#ffffff' );
			$onsale_bg 											= get_theme_mod( 'lumen_onsale_bg', '#3FC387' );
			$onsale_color 										= get_theme_mod( 'lumen_onsale_color', '#ffffff' );
			$outofstock_bg 										= get_theme_mod( 'lumen_outofstock_bg', '#000000' );
			$outofstock_color 									= get_theme_mod( 'lumen_outofstock_color', '#ffffff' );
			$stars_color_before 								= get_theme_mod( 'lumen_stars_color_before', '#dfdbdf' );
			$stars_color 										= get_theme_mod( 'lumen_stars_color', '#f9ca63' );
			$quantity_border_color 								= get_theme_mod( 'lumen_quantity_border_color', '#e4e4e4' );
			$quantity_border_color_focus 						= get_theme_mod( 'lumen_quantity_border_color_focus', '#bbbbbb' );
			$quantity_color 									= get_theme_mod( 'lumen_quantity_color', '#777777' );
			$quantity_plus_minus_color 							= get_theme_mod( 'lumen_quantity_plus_minus_color', '#cccccc' );
			$quantity_plus_minus_color_hover 					= get_theme_mod( 'lumen_quantity_plus_minus_color_hover', '#cccccc' );
			$quantity_plus_minus_border_color_hover 			= get_theme_mod( 'lumen_quantity_plus_minus_border_color_hover', '#e0e0e0' );
			$toolbar_border_color 								= get_theme_mod( 'lumen_toolbar_border_color', '#eaeaea' );
			$toolbar_off_canvas_filter_color 					= get_theme_mod( 'lumen_toolbar_off_canvas_filter_color', '#999999' );
			$toolbar_off_canvas_filter_border_color 			= get_theme_mod( 'lumen_toolbar_off_canvas_filter_border_color', '#eaeaea' );
			$toolbar_off_canvas_filter_hover_color 				= get_theme_mod( 'lumen_toolbar_off_canvas_filter_hover_color', '#13aff0' );
			$toolbar_off_canvas_filter_hover_border_color 		= get_theme_mod( 'lumen_toolbar_off_canvas_filter_hover_border_color', '#13aff0' );
			$toolbar_grid_list_color 							= get_theme_mod( 'lumen_toolbar_grid_list_color', '#999999' );
			$toolbar_grid_list_border_color 					= get_theme_mod( 'lumen_toolbar_grid_list_border_color', '#eaeaea' );
			$toolbar_grid_list_hover_color 						= get_theme_mod( 'lumen_toolbar_grid_list_hover_color', '#13aff0' );
			$toolbar_grid_list_active_color 					= get_theme_mod( 'lumen_toolbar_grid_list_active_color', '#13aff0' );
			$toolbar_select_color 								= get_theme_mod( 'lumen_toolbar_select_color', '#999999' );
			$toolbar_select_border_color 						= get_theme_mod( 'lumen_toolbar_select_border_color', '#dddddd' );
			$toolbar_number_of_products_color 					= get_theme_mod( 'lumen_toolbar_number_of_products_color', '#555555' );
			$toolbar_number_of_products_inactive_color 			= get_theme_mod( 'lumen_toolbar_number_of_products_inactive_color', '#999999' );
			$toolbar_number_of_products_border_color 			= get_theme_mod( 'lumen_toolbar_number_of_products_border_color', '#999999' );
			$product_top_padding 								= get_theme_mod( 'lumen_product_top_padding' );
			$product_right_padding 								= get_theme_mod( 'lumen_product_right_padding' );
			$product_bottom_padding 							= get_theme_mod( 'lumen_product_bottom_padding' );
			$product_left_padding 								= get_theme_mod( 'lumen_product_left_padding' );
			$tablet_product_top_padding 						= get_theme_mod( 'lumen_product_tablet_top_padding' );
			$tablet_product_right_padding 						= get_theme_mod( 'lumen_product_tablet_right_padding' );
			$tablet_product_bottom_padding 						= get_theme_mod( 'lumen_product_tablet_bottom_padding' );
			$tablet_product_left_padding 						= get_theme_mod( 'lumen_product_tablet_left_padding' );
			$mobile_product_top_padding 						= get_theme_mod( 'lumen_product_mobile_top_padding' );
			$mobile_product_right_padding 						= get_theme_mod( 'lumen_product_mobile_right_padding' );
			$mobile_product_bottom_padding 						= get_theme_mod( 'lumen_product_mobile_bottom_padding' );
			$mobile_product_left_padding 						= get_theme_mod( 'lumen_product_mobile_left_padding' );
			$product_image_top_margin 							= get_theme_mod( 'lumen_product_image_top_margin' );
			$product_image_right_margin 						= get_theme_mod( 'lumen_product_image_right_margin' );
			$product_image_bottom_margin 						= get_theme_mod( 'lumen_product_image_bottom_margin' );
			$product_image_left_margin 							= get_theme_mod( 'lumen_product_image_left_margin' );
			$tablet_product_image_top_margin 					= get_theme_mod( 'lumen_product_image_tablet_top_margin' );
			$tablet_product_image_right_margin 					= get_theme_mod( 'lumen_product_image_tablet_right_margin' );
			$tablet_product_image_bottom_margin 				= get_theme_mod( 'lumen_product_image_tablet_bottom_margin' );
			$tablet_product_image_left_margin 					= get_theme_mod( 'lumen_product_image_tablet_left_margin' );
			$mobile_product_image_top_margin 					= get_theme_mod( 'lumen_product_image_mobile_top_margin' );
			$mobile_product_image_right_margin 					= get_theme_mod( 'lumen_product_image_mobile_right_margin' );
			$mobile_product_image_bottom_margin 				= get_theme_mod( 'lumen_product_image_mobile_bottom_margin' );
			$mobile_product_image_left_margin 					= get_theme_mod( 'lumen_product_image_mobile_left_margin' );
			$product_top_border_width 							= get_theme_mod( 'lumen_product_top_border_width' );
			$product_right_border_width 						= get_theme_mod( 'lumen_product_right_border_width' );
			$product_bottom_border_width 						= get_theme_mod( 'lumen_product_bottom_border_width' );
			$product_left_border_width 							= get_theme_mod( 'lumen_product_left_border_width' );
			$tablet_product_top_border_width 					= get_theme_mod( 'lumen_product_tablet_top_border_width' );
			$tablet_product_right_border_width 					= get_theme_mod( 'lumen_product_tablet_right_border_width' );
			$tablet_product_bottom_border_width 				= get_theme_mod( 'lumen_product_tablet_bottom_border_width' );
			$tablet_product_left_border_width 					= get_theme_mod( 'lumen_product_tablet_left_border_width' );
			$mobile_product_top_border_width 					= get_theme_mod( 'lumen_product_mobile_top_border_width' );
			$mobile_product_right_border_width 					= get_theme_mod( 'lumen_product_mobile_right_border_width' );
			$mobile_product_bottom_border_width 				= get_theme_mod( 'lumen_product_mobile_bottom_border_width' );
			$mobile_product_left_border_width 					= get_theme_mod( 'lumen_product_mobile_left_border_width' );
			$product_top_border_radius 							= get_theme_mod( 'lumen_product_top_border_radius' );
			$product_right_border_radius 						= get_theme_mod( 'lumen_product_right_border_radius' );
			$product_bottom_border_radius 						= get_theme_mod( 'lumen_product_bottom_border_radius' );
			$product_left_border_radius 						= get_theme_mod( 'lumen_product_left_border_radius' );
			$tablet_product_top_border_radius 					= get_theme_mod( 'lumen_product_tablet_top_border_radius' );
			$tablet_product_right_border_radius 				= get_theme_mod( 'lumen_product_tablet_right_border_radius' );
			$tablet_product_bottom_border_radius 				= get_theme_mod( 'lumen_product_tablet_bottom_border_radius' );
			$tablet_product_left_border_radius 					= get_theme_mod( 'lumen_product_tablet_left_border_radius' );
			$mobile_product_top_border_radius 					= get_theme_mod( 'lumen_product_mobile_top_border_radius' );
			$mobile_product_right_border_radius 				= get_theme_mod( 'lumen_product_mobile_right_border_radius' );
			$mobile_product_bottom_border_radius 				= get_theme_mod( 'lumen_product_mobile_bottom_border_radius' );
			$mobile_product_left_border_radius 					= get_theme_mod( 'lumen_product_mobile_left_border_radius' );
			$product_background_color 							= get_theme_mod( 'lumen_product_background_color' );
			$product_border_color 								= get_theme_mod( 'lumen_product_border_color' );
			$category_color 									= get_theme_mod( 'lumen_category_color', '#999999' );
			$category_color_hover 								= get_theme_mod( 'lumen_category_color_hover', '#13aff0' );
			$product_title_color 								= get_theme_mod( 'lumen_product_title_color', '#333333' );
			$product_title_color_hover 							= get_theme_mod( 'lumen_product_title_color_hover', '#13aff0' );
			$product_entry_price_color 							= get_theme_mod( 'lumen_product_entry_price_color', '#57bf6d' );
			$product_entry_del_price_color 						= get_theme_mod( 'lumen_product_entry_del_price_color', '#666666' );
			$product_entry_hover_thumbnails_border_color 		= get_theme_mod( 'lumen_product_entry_hover_thumbnails_border_color', '#13aff0' );
			$product_entry_hover_quickview_background 			= get_theme_mod( 'lumen_product_entry_hover_quickview_background', '#ffffff' );
			$product_entry_hover_quickview_hover_background 	= get_theme_mod( 'lumen_product_entry_hover_quickview_hover_background', '#ffffff' );
			$product_entry_hover_quickview_color 				= get_theme_mod( 'lumen_product_entry_hover_quickview_color', '#444444' );
			$product_entry_hover_quickview_hover_color 			= get_theme_mod( 'lumen_product_entry_hover_quickview_hover_color', '#13aff0' );
			$product_entry_hover_wishlist_background 			= get_theme_mod( 'lumen_product_entry_hover_wishlist_background', '#ffffff' );
			$product_entry_hover_wishlist_hover_background 		= get_theme_mod( 'lumen_product_entry_hover_wishlist_hover_background', '#ffffff' );
			$product_entry_hover_wishlist_color 				= get_theme_mod( 'lumen_product_entry_hover_wishlist_color', '#444444' );
			$product_entry_hover_wishlist_hover_color 			= get_theme_mod( 'lumen_product_entry_hover_wishlist_hover_color', '#13aff0' );
			$product_entry_addtocart_bg_color 					= get_theme_mod( 'lumen_product_entry_addtocart_bg_color' );
			$product_entry_addtocart_bg_color_hover 			= get_theme_mod( 'lumen_product_entry_addtocart_bg_color_hover' );
			$product_entry_addtocart_color 						= get_theme_mod( 'lumen_product_entry_addtocart_color', '#848494' );
			$product_entry_addtocart_color_hover 				= get_theme_mod( 'lumen_product_entry_addtocart_color_hover', '#13aff0' );
			$product_entry_addtocart_border_color 				= get_theme_mod( 'lumen_product_entry_addtocart_border_color', '#e4e4e4' );
			$product_entry_addtocart_border_color_hover 		= get_theme_mod( 'lumen_product_entry_addtocart_border_color_hover', '#13aff0' );
			$product_entry_addtocart_border_style 				= get_theme_mod( 'lumen_product_entry_addtocart_border_style', 'double' );
			$product_entry_addtocart_border_size 				= get_theme_mod( 'lumen_product_entry_addtocart_border_size' );
			$product_entry_addtocart_border_radius 				= get_theme_mod( 'lumen_product_entry_addtocart_border_radius' );
			$quick_view_button_bg 								= get_theme_mod( 'lumen_woo_quick_view_button_bg', 'rgba(0,0,0,0.6)' );
			$quick_view_button_hover_bg 						= get_theme_mod( 'lumen_woo_quick_view_button_hover_bg', 'rgba(0,0,0,0.9)' );
			$quick_view_button_color 							= get_theme_mod( 'lumen_woo_quick_view_button_color', '#ffffff' );
			$quick_view_button_hover_color 						= get_theme_mod( 'lumen_woo_quick_view_button_hover_color', '#ffffff' );
			$quick_view_overlay_bg 								= get_theme_mod( 'lumen_woo_quick_view_overlay_bg', 'rgba(0,0,0,0.15)' );
			$quick_view_overlay_spinner_outside_color 			= get_theme_mod( 'lumen_woo_quick_view_overlay_spinner_outside_color', 'rgba(0,0,0,0.1)' );
			$quick_view_overlay_spinner_inner_color 			= get_theme_mod( 'lumen_woo_quick_view_overlay_spinner_inner_color', '#ffffff' );
			$quick_view_modal_bg 								= get_theme_mod( 'lumen_woo_quick_view_modal_bg', '#ffffff' );
			$quick_view_modal_close_color 						= get_theme_mod( 'lumen_woo_quick_view_modal_close_color', '#333333' );
			$off_canvas_sidebar_bg 								= get_theme_mod( 'lumen_woo_off_canvas_sidebar_bg', '#ffffff' );
			$off_canvas_sidebar_widgets_border 					= get_theme_mod( 'lumen_woo_off_canvas_sidebar_widgets_border', 'rgba(84,84,84,0.15)' );
			$single_product_title_color 						= get_theme_mod( 'lumen_single_product_title_color', '#333333' );
			$single_product_price_color 						= get_theme_mod( 'lumen_single_product_price_color', '#57bf6d' );
			$single_product_del_price_color 					= get_theme_mod( 'lumen_single_product_del_price_color', '#555555' );
			$single_product_description_color 					= get_theme_mod( 'lumen_single_product_description_color', '#aaaaaa' );
			$single_product_meta_title_color 					= get_theme_mod( 'lumen_single_product_meta_title_color', '#333333' );
			$single_product_meta_link_color 					= get_theme_mod( 'lumen_single_product_meta_link_color', '#aaaaaa' );
			$single_product_meta_link_color_hover 				= get_theme_mod( 'lumen_single_product_meta_link_color_hover', '#13aff0' );
			$single_product_navigation_border_radius 			= get_theme_mod( 'lumen_single_product_navigation_border_radius', '30' );
			$single_product_navigation_bg 						= get_theme_mod( 'lumen_single_product_navigation_bg' );
			$single_product_navigation_hover_bg 				= get_theme_mod( 'lumen_single_product_navigation_hover_bg', '#13aff0' );
			$single_product_navigation_color 					= get_theme_mod( 'lumen_single_product_navigation_color', '#333333' );
			$single_product_navigation_hover_color 				= get_theme_mod( 'lumen_single_product_navigation_hover_color', '#ffffff' );
			$single_product_navigation_border_color 			= get_theme_mod( 'lumen_single_product_navigation_border_color', '#e9e9e9' );
			$single_product_navigation_hover_border_color 		= get_theme_mod( 'lumen_single_product_navigation_hover_border_color', '#13aff0' );
			$single_product_addtocart_bg_color 					= get_theme_mod( 'lumen_single_product_addtocart_bg_color' );
			$single_product_addtocart_bg_color_hover 			= get_theme_mod( 'lumen_single_product_addtocart_bg_color_hover' );
			$single_product_addtocart_color 					= get_theme_mod( 'lumen_single_product_addtocart_color' );
			$single_product_addtocart_color_hover 				= get_theme_mod( 'lumen_single_product_addtocart_color_hover' );
			$single_product_addtocart_border_color 				= get_theme_mod( 'lumen_single_product_addtocart_border_color' );
			$single_product_addtocart_border_color_hover 		= get_theme_mod( 'lumen_single_product_addtocart_border_color_hover' );
			$single_product_addtocart_border_style 				= get_theme_mod( 'lumen_single_product_addtocart_border_style' );
			$single_product_addtocart_border_size 				= get_theme_mod( 'lumen_single_product_addtocart_border_size' );
			$single_product_addtocart_border_radius 			= get_theme_mod( 'lumen_single_product_addtocart_border_radius' );
			$single_product_tabs_borders_color 					= get_theme_mod( 'lumen_single_product_tabs_borders_color', '#e9e9e9' );
			$single_product_tabs_text_color 					= get_theme_mod( 'lumen_single_product_tabs_text_color', '#999999' );
			$single_product_tabs_text_color_hover 				= get_theme_mod( 'lumen_single_product_tabs_text_color_hover', '#13aff0' );
			$single_product_tabs_active_text_color 				= get_theme_mod( 'lumen_single_product_tabs_active_text_color', '#13aff0' );
			$single_product_tabs_active_text_borders_color 		= get_theme_mod( 'lumen_single_product_tabs_active_text_borders_color', '#13aff0' );
			$single_product_tabs_product_desc_title_color 		= get_theme_mod( 'lumen_single_product_tabs_product_description_title_color', '#333333' );
			$single_product_tabs_product_desc_color 			= get_theme_mod( 'lumen_single_product_tabs_product_description_color', '#929292' );
			$account_login_register_color 						= get_theme_mod( 'lumen_account_login_register_color', '#333333' );
			$account_nav_borders_color 							= get_theme_mod( 'lumen_account_navigation_borders_color', '#e9e9e9' );
			$account_nav_icons_color 							= get_theme_mod( 'lumen_account_navigation_icons_color', '#13aff0' );
			$account_nav_links_color 							= get_theme_mod( 'lumen_account_navigation_links_color', '#333333' );
			$account_nav_links_color_hover 						= get_theme_mod( 'lumen_account_navigation_links_color_hover', '#13aff0' );
			$account_addresses_bg 								= get_theme_mod( 'lumen_account_addresses_bg', '#f6f6f6' );
			$account_addresses_title_color 						= get_theme_mod( 'lumen_account_addresses_title_color', '#333333' );
			$account_addresses_title_border_color 				= get_theme_mod( 'lumen_account_addresses_title_border_color', '#ffffff' );
			$account_addresses_content_color 					= get_theme_mod( 'lumen_account_addresses_content_color', '#898989' );
			$account_addresses_button_bg 						= get_theme_mod( 'lumen_account_addresses_button_bg', '#ffffff' );
			$account_addresses_button_bg_hover 					= get_theme_mod( 'lumen_account_addresses_button_bg_hover', '#f8f8f8' );
			$account_addresses_button_color 					= get_theme_mod( 'lumen_account_addresses_button_color', '#898989' );
			$account_addresses_button_color_hover 				= get_theme_mod( 'lumen_account_addresses_button_color_hover', '#555555' );
			$cart_borders_color 								= get_theme_mod( 'lumen_cart_borders_color', '#e9e9e9' );
			$cart_head_bg 										= get_theme_mod( 'lumen_cart_head_bg', '#f7f7f7' );
			$cart_head_titles_color 							= get_theme_mod( 'lumen_cart_head_titles_color', '#444444' );
			$cart_totals_table_titles_color 					= get_theme_mod( 'lumen_cart_totals_table_titles_color', '#444444' );
			$cart_remove_button_color 							= get_theme_mod( 'lumen_cart_remove_button_color', '#bbbbbb' );
			$cart_remove_button_color_hover 					= get_theme_mod( 'lumen_cart_remove_button_color_hover', '#333333' );
			$checkout_notices_borders_color 					= get_theme_mod( 'lumen_checkout_notices_borders_color', '#e9e9e9' );
			$checkout_notices_icon_color 						= get_theme_mod( 'lumen_checkout_notices_icon_color', '#dddddd' );
			$checkout_notices_color 							= get_theme_mod( 'lumen_checkout_notices_color', '#777777' );
			$checkout_notices_link_color 						= get_theme_mod( 'lumen_checkout_notices_link_color', '#13aff0' );
			$checkout_notices_link_color_hover 					= get_theme_mod( 'lumen_checkout_notices_link_color_hover', '#333333' );
			$checkout_notices_form_border_color 				= get_theme_mod( 'lumen_checkout_notices_form_border_color', '#e9e9e9' );
			$checkout_titles_color 								= get_theme_mod( 'lumen_checkout_titles_color', '#333333' );
			$checkout_titles_border_bottom_color 				= get_theme_mod( 'lumen_checkout_titles_border_bottom_color', '#e9e9e9' );
			$checkout_table_main_bg 							= get_theme_mod( 'lumen_checkout_table_main_bg', '#f7f7f7' );
			$checkout_table_titles_color 						= get_theme_mod( 'lumen_checkout_table_titles_color', '#444444' );
			$checkout_table_borders_color 						= get_theme_mod( 'lumen_checkout_table_borders_color', '#e9e9e9' );
			$checkout_payment_methods_bg 						= get_theme_mod( 'lumen_checkout_payment_methods_bg', '#f8f8f8' );
			$checkout_payment_methods_borders_color 			= get_theme_mod( 'lumen_checkout_payment_methods_borders_color', '#e9e9e9' );
			$checkout_payment_box_bg 							= get_theme_mod( 'lumen_checkout_payment_box_bg', '#ffffff' );
			$checkout_payment_box_color 						= get_theme_mod( 'lumen_checkout_payment_box_color', '#515151' );

			// Both sidebars shop page layout
			$archives_layout 									= get_theme_mod( 'lumen_woo_shop_layout', 'left-sidebar' );
			$bs_archives_content_width 							= get_theme_mod( 'lumen_woo_shop_both_sidebars_content_width' );
			$bs_archives_sidebars_width 						= get_theme_mod( 'lumen_woo_shop_both_sidebars_sidebars_width' );

			// Both sidebars single product layout
			$single_layout 										= get_theme_mod( 'lumen_woo_product_layout', 'left-sidebar' );
			$bs_single_content_width 							= get_theme_mod( 'lumen_woo_product_both_sidebars_content_width' );
			$bs_single_sidebars_width 							= get_theme_mod( 'lumen_woo_product_both_sidebars_sidebars_width' );

			// Define css var
			$css = '';

			// Menu cart icon size
			if ( ! empty( $menu_icon_size ) ) {
				$css .= '.wcmenucart i{font-size:'. $menu_icon_size .'px;}';
			}

			// Menu cart icon size tablet
			if ( ! empty( $menu_icon_size_tablet ) ) {
				$css .= '@media (max-width: 768px){.lumen-mobile-menu-icon a.wcmenucart{font-size:'. $menu_icon_size_tablet .'px;}}';
			}

			// Menu cart icon size mobile
			if ( ! empty( $menu_icon_size_mobile ) ) {
				$css .= '@media (max-width: 480px){.lumen-mobile-menu-icon a.wcmenucart{font-size:'. $menu_icon_size_mobile .'px;}}';
			}

			// Menu cart icon center vertically
			if ( ! empty( $menu_icon_center_vertically ) ) {
				$css .= '.wcmenucart i{top:'. $menu_icon_center_vertically .'px;}';
			}

			// Menu cart icon center vertically tablet
			if ( ! empty( $menu_icon_center_vertically_tablet ) ) {
				$css .= '@media (max-width: 768px){.lumen-mobile-menu-icon a.wcmenucart{top:'. $menu_icon_center_vertically_tablet .'px;}}';
			}

			// Menu cart icon center vertically mobile
			if ( ! empty( $menu_icon_center_vertically_mobile ) ) {
				$css .= '@media (max-width: 480px){.lumen-mobile-menu-icon a.wcmenucart{top:'. $menu_icon_center_vertically_mobile .'px;}}';
			}

			// Cart dropdown width
			if ( ! empty( $cart_dropdown_width ) && '350' != $cart_dropdown_width ) {
				$css .= '.current-shop-items-dropdown{width:'. $cart_dropdown_width .'px;}';
			}

			// Bag icon style color
			if ( ! empty( $woo_menu_bag_icon_color ) && '#333333' != $woo_menu_bag_icon_color ) {
				$css .= '.wcmenucart-cart-icon .wcmenucart-count{border-color:'. $woo_menu_bag_icon_color .';}';
				$css .= '.wcmenucart-cart-icon .wcmenucart-count:after{border-color:'. $woo_menu_bag_icon_color .';}';
			}

			// Bag icon style hover color
			if ( ! empty( $woo_menu_bag_icon_hover_color ) && '#13aff0' != $woo_menu_bag_icon_hover_color ) {
				$css .= '.bag-style:hover .wcmenucart-cart-icon .wcmenucart-count, .show-cart .wcmenucart-cart-icon .wcmenucart-count{background-color:'. $woo_menu_bag_icon_hover_color .'; border-color:'. $woo_menu_bag_icon_hover_color .';}';
				$css .= '.bag-style:hover .wcmenucart-cart-icon .wcmenucart-count:after, .show-cart .wcmenucart-cart-icon .wcmenucart-count:after{border-color:'. $woo_menu_bag_icon_hover_color .';}';
			}

			// Bag icon style count color
			if ( ! empty( $woo_menu_bag_icon_count_color ) && '#333333' != $woo_menu_bag_icon_count_color ) {
				$css .= '.wcmenucart-cart-icon .wcmenucart-count, .woo-menu-icon .wcmenucart-total span{color:'. $woo_menu_bag_icon_count_color .';}';
			}

			// Bag icon style hover count color
			if ( ! empty( $woo_menu_bag_icon_hover_count_color ) && '#ffffff' != $woo_menu_bag_icon_hover_count_color ) {
				$css .= '.bag-style:hover .wcmenucart-cart-icon .wcmenucart-count, .show-cart .wcmenucart-cart-icon .wcmenucart-count{color:'. $woo_menu_bag_icon_hover_count_color .';}';
			}

			// Cart dropdown background
			if ( ! empty( $cart_dropdown_bg ) && '#ffffff' != $cart_dropdown_bg ) {
				$css .= '.current-shop-items-dropdown{background-color:'. $cart_dropdown_bg .';}';
			}

			// Cart dropdown borders
			if ( ! empty( $cart_dropdown_borders ) && '#e6e6e6' != $cart_dropdown_borders ) {
				$css .= '.widget_shopping_cart ul.cart_list li .owp-grid-wrap .owp-grid.thumbnail, .widget_shopping_cart ul.cart_list li, .woocommerce ul.product_list_widget li:first-child, .widget_shopping_cart .total{border-color:'. $cart_dropdown_borders .';}';
			}

			// Cart dropdown link color
			if ( ! empty( $cart_dropdown_link_color ) && '#333333' != $cart_dropdown_link_color ) {
				$css .= '.widget_shopping_cart ul.cart_list li .owp-grid-wrap .owp-grid a{color:'. $cart_dropdown_link_color .';}';
			}

			// Cart dropdown link hover color
			if ( ! empty( $cart_dropdown_link_color_hover ) && '#13aff0' != $cart_dropdown_link_color_hover ) {
				$css .= '.widget_shopping_cart ul.cart_list li .owp-grid-wrap .owp-grid a:hover{color:'. $cart_dropdown_link_color_hover .';}';
			}

			// Cart dropdown remove link color
			if ( ! empty( $cart_dropdown_remove_link_color ) && '#b3b3b3' != $cart_dropdown_remove_link_color ) {
				$css .= '.widget_shopping_cart ul.cart_list li .owp-grid-wrap .owp-grid a.remove{color:'. $cart_dropdown_remove_link_color .';border-color:'. $cart_dropdown_remove_link_color .';}';
			}

			// Cart dropdown remove link hover color
			if ( ! empty( $cart_dropdown_remove_link_color_hover ) && '#13aff0' != $cart_dropdown_remove_link_color_hover ) {
				$css .= '.widget_shopping_cart ul.cart_list li .owp-grid-wrap .owp-grid a.remove:hover{color:'. $cart_dropdown_remove_link_color_hover .';border-color:'. $cart_dropdown_remove_link_color_hover .';}';
			}

			// Cart dropdown quantity color
			if ( ! empty( $cart_dropdown_quantity_color ) && '#b2b2b2' != $cart_dropdown_quantity_color ) {
				$css .= '.widget_shopping_cart ul.cart_list li .owp-grid-wrap .owp-grid .quantity{color:'. $cart_dropdown_quantity_color .';}';
			}

			// Cart dropdown price color
			if ( ! empty( $cart_dropdown_price_color ) && '#57bf6d' != $cart_dropdown_price_color ) {
				$css .= '.widget_shopping_cart ul.cart_list li .owp-grid-wrap .owp-grid .amount{color:'. $cart_dropdown_price_color .';}';
			}

			// Cart dropdown subtotal background
			if ( ! empty( $cart_dropdown_subtotal_bg ) && '#fafafa' != $cart_dropdown_subtotal_bg ) {
				$css .= '.widget_shopping_cart .total{background-color:'. $cart_dropdown_subtotal_bg .';}';
			}

			// Cart dropdown subtotal color
			if ( ! empty( $cart_dropdown_subtotal_color ) && '#797979' != $cart_dropdown_subtotal_color ) {
				$css .= '.widget_shopping_cart .total strong{color:'. $cart_dropdown_subtotal_color .';}';
			}

			// Cart dropdown total price color
			if ( ! empty( $cart_dropdown_total_price_color ) && '#57bf6d' != $cart_dropdown_total_price_color ) {
				$css .= '.widget_shopping_cart .total .amount{color:'. $cart_dropdown_total_price_color .';}';
			}

			// Cart dropdown cart button background color
			if ( ! empty( $cart_dropdown_cart_button_bg ) ) {
				$css .= '.widget_shopping_cart_content .buttons .button:first-child{background-color:'. $cart_dropdown_cart_button_bg .';}';
			}

			// Cart dropdown cart button hover background color
			if ( ! empty( $cart_dropdown_cart_button_hover_bg ) ) {
				$css .= '.widget_shopping_cart_content .buttons .button:first-child:hover{background-color:'. $cart_dropdown_cart_button_hover_bg .';}';
			}

			// Cart dropdown cart button color
			if ( ! empty( $cart_dropdown_cart_button_color ) ) {
				$css .= '.widget_shopping_cart_content .buttons .button:first-child{color:'. $cart_dropdown_cart_button_color .';}';
			}

			// Cart dropdown cart button hover color
			if ( ! empty( $cart_dropdown_cart_button_hover_color ) ) {
				$css .= '.widget_shopping_cart_content .buttons .button:first-child:hover{color:'. $cart_dropdown_cart_button_hover_color .';}';
			}

			// Cart dropdown cart button border color
			if ( ! empty( $cart_dropdown_cart_button_border_color ) ) {
				$css .= '.widget_shopping_cart_content .buttons .button:first-child{border-color:'. $cart_dropdown_cart_button_border_color .';}';
			}

			// Cart dropdown cart button hover border color
			if ( ! empty( $cart_dropdown_cart_button_hover_border_color ) ) {
				$css .= '.widget_shopping_cart_content .buttons .button:first-child:hover{border-color:'. $cart_dropdown_cart_button_hover_border_color .';}';
			}

			// Cart dropdown checkout button background color
			if ( ! empty( $cart_dropdown_checkout_button_bg ) ) {
				$css .= '.widget_shopping_cart_content .buttons .checkout{background-color:'. $cart_dropdown_checkout_button_bg .';}';
			}

			// Cart dropdown checkout button hover background color
			if ( ! empty( $cart_dropdown_checkout_button_hover_bg ) ) {
				$css .= '.widget_shopping_cart_content .buttons .checkout:hover{background-color:'. $cart_dropdown_checkout_button_hover_bg .';}';
			}

			// Cart dropdown checkout button color
			if ( ! empty( $cart_dropdown_checkout_button_color ) ) {
				$css .= '.widget_shopping_cart_content .buttons .checkout{color:'. $cart_dropdown_checkout_button_color .';}';
			}

			// Cart dropdown checkout button hover color
			if ( ! empty( $cart_dropdown_checkout_button_hover_color ) ) {
				$css .= '.widget_shopping_cart_content .buttons .checkout:hover{color:'. $cart_dropdown_checkout_button_hover_color .';}';
			}

			// Mobile cart sidebar background color
			if ( ! empty( $woo_mobile_cart_sidebar_bg ) && '#ffffff' != $woo_mobile_cart_sidebar_bg ) {
				$css .= '#lumen-cart-sidebar-wrap .lumen-cart-sidebar{background-color:'. $woo_mobile_cart_sidebar_bg .';}';
			}

			// Mobile cart sidebar background color
			if ( ! empty( $woo_mobile_cart_sidebar_close_button_color ) && '#000000' != $woo_mobile_cart_sidebar_close_button_color ) {
				$css .= '#lumen-cart-sidebar-wrap .lumen-cart-close .close-wrap>div, #lumen-cart-sidebar-wrap .lumen-cart-close .close-wrap>div:before{background-color:'. $woo_mobile_cart_sidebar_close_button_color .';}';
			}

			// Mobile cart sidebar background color
			if ( ! empty( $woo_mobile_cart_sidebar_title_color ) && '#555555' != $woo_mobile_cart_sidebar_title_color ) {
				$css .= '#lumen-cart-sidebar-wrap h4{color:'. $woo_mobile_cart_sidebar_title_color .';}';
			}

			// Mobile cart sidebar background color
			if ( ! empty( $woo_mobile_cart_sidebar_divider_color ) && 'rgba(0,0,0,0.1)' != $woo_mobile_cart_sidebar_divider_color ) {
				$css .= '#lumen-cart-sidebar-wrap .divider{background-color:'. $woo_mobile_cart_sidebar_divider_color .';}';
			}

			// Off canvas close button color
			if ( ! empty( $off_canvas_close_button_color ) && '#333333' != $off_canvas_close_button_color ) {
				$css .= '.lumen-off-canvas-close svg{fill:'. $off_canvas_close_button_color .';}';
			}

			// Off canvas close button hover color
			if ( ! empty( $off_canvas_close_button_hover_color ) && '#777777' != $off_canvas_close_button_hover_color ) {
				$css .= '.lumen-off-canvas-close:hover svg{fill:'. $off_canvas_close_button_hover_color .';}';
			}

			// Infinite scroll spinners color
			if ( ! empty( $infinite_scroll_spinners_color ) && '#333333' != $infinite_scroll_spinners_color ) {
				$css .= '.woocommerce .loader-ellips__dot{background-color:'. $infinite_scroll_spinners_color .';}';
			}

			// Product image width
			if ( ! empty( $woo_product_image_width ) && '52' != $woo_product_image_width ) {
				$css .= '.woocommerce div.product div.images, .woocommerce.content-full-width div.product div.images{width:'. $woo_product_image_width .'%;}';
			}

			// Product summary width
			if ( ! empty( $woo_product_summary_width ) && '44' != $woo_product_summary_width ) {
				$css .= '.woocommerce div.product div.summary, .woocommerce.content-full-width div.product div.summary{width:'. $woo_product_summary_width .'%;}';
			}

			// Add floating bar background
			if ( ! empty( $floating_bar_bg ) && '#2c2c2c' != $floating_bar_bg ) {
				$css .= '.owp-floating-bar{background-color:'. $floating_bar_bg .';}';
			}

			// Add floating bar title color
			if ( ! empty( $floating_bar_title_color ) && '#ffffff' != $floating_bar_title_color ) {
				$css .= '.owp-floating-bar p.selected, .owp-floating-bar h2.entry-title{color:'. $floating_bar_title_color .';}';
			}

			// Add floating bar price color
			if ( ! empty( $floating_bar_price_color ) && '#ffffff' != $floating_bar_price_color ) {
				$css .= '.owp-floating-bar .product_price del .amount, .owp-floating-bar .product_price .amount, .owp-floating-bar .out-of-stock{color:'. $floating_bar_price_color .';}';
			}

			// Add floating bar quantity buttons background
			if ( ! empty( $floating_bar_quantity_buttons_bg ) && 'rgba(255,255,255,0.1)' != $floating_bar_quantity_buttons_bg ) {
				$css .= '.owp-floating-bar form.cart .quantity .minus, .owp-floating-bar form.cart .quantity .plus{background-color:'. $floating_bar_quantity_buttons_bg .';}';
			}

			// Add floating bar quantity buttons hover background
			if ( ! empty( $floating_bar_quantity_buttons_hover_bg ) && 'rgba(255,255,255,0.2)' != $floating_bar_quantity_buttons_hover_bg ) {
				$css .= '.owp-floating-bar form.cart .quantity .minus:hover, .owp-floating-bar form.cart .quantity .plus:hover{background-color:'. $floating_bar_quantity_buttons_hover_bg .';}';
			}

			// Add floating bar quantity buttons color
			if ( ! empty( $floating_bar_quantity_buttons_color ) && '#ffffff' != $floating_bar_quantity_buttons_color ) {
				$css .= '.owp-floating-bar form.cart .quantity .minus, .owp-floating-bar form.cart .quantity .plus{color:'. $floating_bar_quantity_buttons_color .';}';
			}

			// Add floating bar quantity buttons hover color
			if ( ! empty( $floating_bar_quantity_buttons_hover_color ) && '#ffffff' != $floating_bar_quantity_buttons_hover_color ) {
				$css .= '.owp-floating-bar form.cart .quantity .minus:hover, .owp-floating-bar form.cart .quantity .plus:hover{color:'. $floating_bar_quantity_buttons_hover_color .';}';
			}

			// Add floating bar quantity input background
			if ( ! empty( $floating_bar_quantity_input_bg ) && 'rgba(255,255,255,0.2)' != $floating_bar_quantity_input_bg ) {
				$css .= '.owp-floating-bar form.cart .quantity .qty{background-color:'. $floating_bar_quantity_input_bg .';}';
			}

			// Add floating bar quantity input color
			if ( ! empty( $floating_bar_quantity_input_color ) && '#ffffff' != $floating_bar_quantity_input_color ) {
				$css .= '.owp-floating-bar form.cart .quantity .qty{color:'. $floating_bar_quantity_input_color .';}';
			}

			// Add add to cart background
			if ( ! empty( $floating_bar_addtocart_bg ) && '#ffffff' != $floating_bar_addtocart_bg ) {
				$css .= '.owp-floating-bar button.button{background-color:'. $floating_bar_addtocart_bg .';}';
			}

			// Add add to cart hover background
			if ( ! empty( $floating_bar_addtocart_hover_bg ) && '#f1f1f1' != $floating_bar_addtocart_hover_bg ) {
				$css .= '.owp-floating-bar button.button:hover, .owp-floating-bar button.button:focus{background-color:'. $floating_bar_addtocart_hover_bg .';}';
			}

			// Add add to cart color
			if ( ! empty( $floating_bar_addtocart_color ) && '#000000' != $floating_bar_addtocart_color ) {
				$css .= '.owp-floating-bar button.button{color:'. $floating_bar_addtocart_color .';}';
			}

			// Add add to cart hover color
			if ( ! empty( $floating_bar_addtocart_hover_color ) && '#000000' != $floating_bar_addtocart_hover_color ) {
				$css .= '.owp-floating-bar button.button:hover, .owp-floating-bar button.button:focus{color:'. $floating_bar_addtocart_hover_color .';}';
			}

			// Add checkout timeline bg
			if ( ! empty( $checkout_timeline_bg ) && '#eeeeee' != $checkout_timeline_bg ) {
				$css .= '#owp-checkout-timeline .timeline-wrapper{background-color:'. $checkout_timeline_bg .';}#owp-checkout-timeline.arrow .timeline-wrapper:before{border-top-color:'. $checkout_timeline_bg .'; border-bottom-color:'. $checkout_timeline_bg .';}#owp-checkout-timeline.arrow .timeline-wrapper:after{border-left-color:'. $checkout_timeline_bg .'; border-right-color:'. $checkout_timeline_bg .';}';
			}

			// Add checkout timeline color
			if ( ! empty( $checkout_timeline_color ) && '#333333' != $checkout_timeline_color ) {
				$css .= '#owp-checkout-timeline .timeline-wrapper{color:'. $checkout_timeline_color .';}';
			}

			// Add checkout timeline number background color
			if ( ! empty( $checkout_timeline_number_bg ) && '#ffffff' != $checkout_timeline_number_bg ) {
				$css .= '#owp-checkout-timeline .timeline-step{background-color:'. $checkout_timeline_number_bg .';}';
			}

			// Add checkout timeline number color
			if ( ! empty( $checkout_timeline_number_color ) && '#ffffff' != $checkout_timeline_number_color ) {
				$css .= '#owp-checkout-timeline .timeline-step{color:'. $checkout_timeline_number_color .';}';
			}

			// Add checkout timeline number border color
			if ( ! empty( $checkout_timeline_number_border_color ) && '#ffffff' != $checkout_timeline_number_border_color ) {
				$css .= '#owp-checkout-timeline .timeline-step{border-color:'. $checkout_timeline_number_border_color .';}';
			}

			// Add checkout timeline active background color
			if ( ! empty( $checkout_timeline_active_bg ) && '#13aff0' != $checkout_timeline_active_bg ) {
				$css .= '#owp-checkout-timeline .active .timeline-wrapper{background-color:'. $checkout_timeline_active_bg .';}#owp-checkout-timeline.arrow .active .timeline-wrapper:before{border-top-color:'. $checkout_timeline_active_bg .'; border-bottom-color:'. $checkout_timeline_active_bg .';}#owp-checkout-timeline.arrow .active .timeline-wrapper:after{border-left-color:'. $checkout_timeline_active_bg .'; border-right-color:'. $checkout_timeline_active_bg .';}';
			}

			// Add checkout timeline active color
			if ( ! empty( $checkout_timeline_active_color ) && '#ffffff' != $checkout_timeline_active_color ) {
				$css .= '#owp-checkout-timeline .active .timeline-wrapper{color:'. $checkout_timeline_active_color .';}';
			}

			// Add onsale bg
			if ( ! empty( $onsale_bg ) && '#3FC387' != $onsale_bg ) {
				$css .= '.woocommerce span.onsale{background-color:'. $onsale_bg .';}';
			}

			// Add onsale color
			if ( ! empty( $onsale_color ) && '#ffffff' != $onsale_color ) {
				$css .= '.woocommerce span.onsale{color:'. $onsale_color .';}';
			}

			// Add out of stock bg
			if ( ! empty( $outofstock_bg ) && '#000000' != $outofstock_bg ) {
				$css .= '.woocommerce ul.products li.product.outofstock .outofstock-badge{background-color:'. $outofstock_bg .';}';
			}

			// Add out of stock color
			if ( ! empty( $outofstock_color ) && '#ffffff' != $outofstock_color ) {
				$css .= '.woocommerce ul.products li.product.outofstock .outofstock-badge{color:'. $outofstock_color .';}';
			}

			// Add stars color before
			if ( ! empty( $stars_color_before ) && '#dfdbdf' != $stars_color_before ) {
				$css .= '.woocommerce .star-rating:before{color:'. $stars_color_before .';}';
			}

			// Add stars color
			if ( ! empty( $stars_color ) && '#f9ca63' != $stars_color ) {
				$css .= '.woocommerce .star-rating span{color:'. $stars_color .';}';
			}

			// Add quantity border color
			if ( ! empty( $quantity_border_color ) && '#e4e4e4' != $quantity_border_color ) {
				$css .= '.quantity .qty,.quantity .qty-changer a{border-color:'. $quantity_border_color .';}';
			}

			// Add quantity border color focus
			if ( ! empty( $quantity_border_color_focus ) && '#bbbbbb' != $quantity_border_color_focus ) {
				$css .= 'body .quantity .qty:focus{border-color:'. $quantity_border_color_focus .';}';
			}

			// Add quantity color
			if ( ! empty( $quantity_color ) && '#777777' != $quantity_color ) {
				$css .= '.quantity .qty{color:'. $quantity_color .';}';
			}

			// Add quantity plus/minus color
			if ( ! empty( $quantity_plus_minus_color ) && '#cccccc' != $quantity_plus_minus_color ) {
				$css .= '.quantity .qty-changer a{color:'. $quantity_plus_minus_color .';}';
			}

			// Add quantity plus/minus color hover
			if ( ! empty( $quantity_plus_minus_color_hover ) && '#cccccc' != $quantity_plus_minus_color_hover ) {
				$css .= '.quantity .qty-changer a:hover{color:'. $quantity_plus_minus_color_hover .';}';
			}

			// Add quantity plus/minus border color hover
			if ( ! empty( $quantity_plus_minus_border_color_hover ) && '#e0e0e0' != $quantity_plus_minus_border_color_hover ) {
				$css .= '.quantity .qty-changer a:hover{border-color:'. $quantity_plus_minus_border_color_hover .';}';
			}

			// Add toolbar border color
			if ( ! empty( $toolbar_border_color ) && '#eaeaea' != $toolbar_border_color ) {
				$css .= '.woocommerce .lumen-toolbar{border-color:'. $toolbar_border_color .';}';
			}

			// Add toolbar off canvas filter color
			if ( ! empty( $toolbar_off_canvas_filter_color ) && '#999999' != $toolbar_off_canvas_filter_color ) {
				$css .= '.woocommerce .lumen-off-canvas-filter{color:'. $toolbar_off_canvas_filter_color .';}';
			}

			// Add toolbar off canvas filter border color
			if ( ! empty( $toolbar_off_canvas_filter_border_color ) && '#eaeaea' != $toolbar_off_canvas_filter_border_color ) {
				$css .= '.woocommerce .lumen-off-canvas-filter{border-color:'. $toolbar_off_canvas_filter_border_color .';}';
			}

			// Add toolbar off canvas filter hover color
			if ( ! empty( $toolbar_off_canvas_filter_hover_color ) && '#13aff0' != $toolbar_off_canvas_filter_hover_color ) {
				$css .= '.woocommerce .lumen-off-canvas-filter:hover{color:'. $toolbar_off_canvas_filter_hover_color .';}';
			}

			// Add toolbar off canvas filter hover border color
			if ( ! empty( $toolbar_off_canvas_filter_hover_border_color ) && '#13aff0' != $toolbar_off_canvas_filter_hover_border_color ) {
				$css .= '.woocommerce .lumen-off-canvas-filter:hover{border-color:'. $toolbar_off_canvas_filter_hover_border_color .';}';
			}

			// Add toolbar grid/list color
			if ( ! empty( $toolbar_grid_list_color ) && '#999999' != $toolbar_grid_list_color ) {
				$css .= '.woocommerce .lumen-grid-list a{color:'. $toolbar_grid_list_color .';}';
			}

			// Add toolbar grid/list border color
			if ( ! empty( $toolbar_grid_list_border_color ) && '#eaeaea' != $toolbar_grid_list_border_color ) {
				$css .= '.woocommerce .lumen-grid-list a{border-color:'. $toolbar_grid_list_border_color .';}';
			}

			// Add toolbar grid/list hover color
			if ( ! empty( $toolbar_grid_list_hover_color ) && '#13aff0' != $toolbar_grid_list_hover_color ) {
				$css .= '.woocommerce .lumen-grid-list a:hover{color:'. $toolbar_grid_list_hover_color .';border-color:'. $toolbar_grid_list_hover_color .';}';
			}

			// Add toolbar grid/list active color
			if ( ! empty( $toolbar_grid_list_active_color ) && '#13aff0' != $toolbar_grid_list_active_color ) {
				$css .= '.woocommerce .lumen-grid-list a.active{color:'. $toolbar_grid_list_active_color .';border-color:'. $toolbar_grid_list_active_color .';}';
			}

			// Add toolbar select color
			if ( ! empty( $toolbar_select_color ) && '#999999' != $toolbar_select_color ) {
				$css .= '.woocommerce .woocommerce-ordering .theme-select,.woocommerce .woocommerce-ordering .theme-select:after{color:'. $toolbar_select_color .';}';
			}

			// Add toolbar select border color
			if ( ! empty( $toolbar_select_border_color ) && '#dddddd' != $toolbar_select_border_color ) {
				$css .= '.woocommerce .woocommerce-ordering .theme-select,.woocommerce .woocommerce-ordering .theme-select:after{border-color:'. $toolbar_select_border_color .';}';
			}

			// Add toolbar number of products color
			if ( ! empty( $toolbar_number_of_products_color ) && '#555555' != $toolbar_number_of_products_color ) {
				$css .= '.woocommerce .result-count li.view-title,.woocommerce .result-count li a.active, .woocommerce .result-count li a:hover{color:'. $toolbar_number_of_products_color .';}';
			}

			// Add toolbar number of products inactive color
			if ( ! empty( $toolbar_number_of_products_inactive_color ) && '#999999' != $toolbar_number_of_products_inactive_color ) {
				$css .= '.woocommerce .result-count li a{color:'. $toolbar_number_of_products_inactive_color .';}';
			}

			// Add toolbar number of products border color
			if ( ! empty( $toolbar_number_of_products_border_color ) && '#999999' != $toolbar_number_of_products_border_color ) {
				$css .= '.woocommerce .result-count li:after{color:'. $toolbar_number_of_products_border_color .';}';
			}

			// Product padding
			if ( isset( $product_top_padding ) && '' != $product_top_padding
				|| isset( $product_right_padding ) && '' != $product_right_padding
				|| isset( $product_bottom_padding ) && '' != $product_bottom_padding
				|| isset( $product_left_padding ) && '' != $product_left_padding ) {
				$css .= '.woocommerce .products .product-inner{padding:'. lumenwp_spacing_css( $product_top_padding, $product_right_padding, $product_bottom_padding, $product_left_padding ) .'}';
			}

			// Tablet product padding
			if ( isset( $tablet_product_top_padding ) && '' != $tablet_product_top_padding
				|| isset( $tablet_product_right_padding ) && '' != $tablet_product_right_padding
				|| isset( $tablet_product_bottom_padding ) && '' != $tablet_product_bottom_padding
				|| isset( $tablet_product_left_padding ) && '' != $tablet_product_left_padding ) {
				$css .= '@media (max-width: 768px){.woocommerce .products .product-inner{padding:'. lumenwp_spacing_css( $tablet_product_top_padding, $tablet_product_right_padding, $tablet_product_bottom_padding, $tablet_product_left_padding ) .'}}';
			}

			// Mobile product padding
			if ( isset( $mobile_product_top_padding ) && '' != $mobile_product_top_padding
				|| isset( $mobile_product_right_padding ) && '' != $mobile_product_right_padding
				|| isset( $mobile_product_bottom_padding ) && '' != $mobile_product_bottom_padding
				|| isset( $mobile_product_left_padding ) && '' != $mobile_product_left_padding ) {
				$css .= '@media (max-width: 480px){.woocommerce .products .product-inner{padding:'. lumenwp_spacing_css( $mobile_product_top_padding, $mobile_product_right_padding, $mobile_product_bottom_padding, $mobile_product_left_padding ) .'}}';
			}

			// Product image margin
			if ( isset( $product_image_top_margin ) && '' != $product_image_top_margin
				|| isset( $product_image_right_margin ) && '' != $product_image_right_margin
				|| isset( $product_image_bottom_margin ) && '' != $product_image_bottom_margin
				|| isset( $product_image_left_margin ) && '' != $product_image_left_margin ) {
				$css .= '.woocommerce ul.products li.product .woo-entry-inner li.image-wrap{margin:'. lumenwp_spacing_css( $product_image_top_margin, $product_image_right_margin, $product_image_bottom_margin, $product_image_left_margin ) .'}';
			}

			// Tablet product image margin
			if ( isset( $tablet_product_image_top_margin ) && '' != $tablet_product_image_top_margin
				|| isset( $tablet_product_image_right_margin ) && '' != $tablet_product_image_right_margin
				|| isset( $tablet_product_image_bottom_margin ) && '' != $tablet_product_image_bottom_margin
				|| isset( $tablet_product_image_left_margin ) && '' != $tablet_product_image_left_margin ) {
				$css .= '@media (max-width: 768px){.woocommerce ul.products li.product .woo-entry-inner li.image-wrap{margin:'. lumenwp_spacing_css( $tablet_product_image_top_margin, $tablet_product_image_right_margin, $tablet_product_image_bottom_margin, $tablet_product_image_left_margin ) .'}}';
			}

			// Mobile product image margin
			if ( isset( $mobile_product_image_top_margin ) && '' != $mobile_product_image_top_margin
				|| isset( $mobile_product_image_right_margin ) && '' != $mobile_product_image_right_margin
				|| isset( $mobile_product_image_bottom_margin ) && '' != $mobile_product_image_bottom_margin
				|| isset( $mobile_product_image_left_margin ) && '' != $mobile_product_image_left_margin ) {
				$css .= '@media (max-width: 480px){.woocommerce ul.products li.product .woo-entry-inner li.image-wrap{margin:'. lumenwp_spacing_css( $mobile_product_image_top_margin, $mobile_product_image_right_margin, $mobile_product_image_bottom_margin, $mobile_product_image_left_margin ) .'}}';
			}

			// Product border style if border width
			if ( isset( $product_top_border_width ) && '' != $product_top_border_width
				|| isset( $product_right_border_width ) && '' != $product_right_border_width
				|| isset( $product_bottom_border_width ) && '' != $product_bottom_border_width
				|| isset( $product_left_border_width ) && '' != $product_left_border_width
				|| isset( $tablet_product_top_border_width ) && '' != $tablet_product_top_border_width
				|| isset( $tablet_product_right_border_width ) && '' != $tablet_product_right_border_width
				|| isset( $tablet_product_bottom_border_width ) && '' != $tablet_product_bottom_border_width
				|| isset( $tablet_product_left_border_width ) && '' != $tablet_product_left_border_width
				|| isset( $mobile_product_top_border_width ) && '' != $mobile_product_top_border_width
				|| isset( $mobile_product_right_border_width ) && '' != $mobile_product_right_border_width
				|| isset( $mobile_product_bottom_border_width ) && '' != $mobile_product_bottom_border_width
				|| isset( $mobile_product_left_border_width ) && '' != $mobile_product_left_border_width ) {
				$css .= '.woocommerce .products .product-inner{border-style: solid}';
			}

			// Product border width
			if ( isset( $product_top_border_width ) && '' != $product_top_border_width
				|| isset( $product_right_border_width ) && '' != $product_right_border_width
				|| isset( $product_bottom_border_width ) && '' != $product_bottom_border_width
				|| isset( $product_left_border_width ) && '' != $product_left_border_width ) {
				$css .= '.woocommerce .products .product-inner{border-width:'. lumenwp_spacing_css( $product_top_border_width, $product_right_border_width, $product_bottom_border_width, $product_left_border_width ) .'}';
			}

			// Tablet product border width
			if ( isset( $tablet_product_top_border_width ) && '' != $tablet_product_top_border_width
				|| isset( $tablet_product_right_border_width ) && '' != $tablet_product_right_border_width
				|| isset( $tablet_product_bottom_border_width ) && '' != $tablet_product_bottom_border_width
				|| isset( $tablet_product_left_border_width ) && '' != $tablet_product_left_border_width ) {
				$css .= '@media (max-width: 768px){.woocommerce .products .product-inner{border-width:'. lumenwp_spacing_css( $tablet_product_top_border_width, $tablet_product_right_border_width, $tablet_product_bottom_border_width, $tablet_product_left_border_width ) .'}}';
			}

			// Mobile product border width
			if ( isset( $mobile_product_top_border_width ) && '' != $mobile_product_top_border_width
				|| isset( $mobile_product_right_border_width ) && '' != $mobile_product_right_border_width
				|| isset( $mobile_product_bottom_border_width ) && '' != $mobile_product_bottom_border_width
				|| isset( $mobile_product_left_border_width ) && '' != $mobile_product_left_border_width ) {
				$css .= '@media (max-width: 480px){.woocommerce .products .product-inner{border-width:'. lumenwp_spacing_css( $mobile_product_top_border_width, $mobile_product_right_border_width, $mobile_product_bottom_border_width, $mobile_product_left_border_width ) .'}}';
			}

			// Product border radius
			if ( isset( $product_top_border_radius ) && '' != $product_top_border_radius
				|| isset( $product_right_border_radius ) && '' != $product_right_border_radius
				|| isset( $product_bottom_border_radius ) && '' != $product_bottom_border_radius
				|| isset( $product_left_border_radius ) && '' != $product_left_border_radius ) {
				$css .= '.woocommerce .products .product-inner{border-radius:'. lumenwp_spacing_css( $product_top_border_radius, $product_right_border_radius, $product_bottom_border_radius, $product_left_border_radius ) .'}';
			}

			// Tablet product border radius
			if ( isset( $tablet_product_top_border_radius ) && '' != $tablet_product_top_border_radius
				|| isset( $tablet_product_right_border_radius ) && '' != $tablet_product_right_border_radius
				|| isset( $tablet_product_bottom_border_radius ) && '' != $tablet_product_bottom_border_radius
				|| isset( $tablet_product_left_border_radius ) && '' != $tablet_product_left_border_radius ) {
				$css .= '@media (max-width: 768px){.woocommerce .products .product-inner{border-radius:'. lumenwp_spacing_css( $tablet_product_top_border_radius, $tablet_product_right_border_radius, $tablet_product_bottom_border_radius, $tablet_product_left_border_radius ) .'}}';
			}

			// Mobile product border radius
			if ( isset( $mobile_product_top_border_radius ) && '' != $mobile_product_top_border_radius
				|| isset( $mobile_product_right_border_radius ) && '' != $mobile_product_right_border_radius
				|| isset( $mobile_product_bottom_border_radius ) && '' != $mobile_product_bottom_border_radius
				|| isset( $mobile_product_left_border_radius ) && '' != $mobile_product_left_border_radius ) {
				$css .= '@media (max-width: 480px){.woocommerce .products .product-inner{border-radius:'. lumenwp_spacing_css( $mobile_product_top_border_radius, $mobile_product_right_border_radius, $mobile_product_bottom_border_radius, $mobile_product_left_border_radius ) .'}}';
			}

			// Add background color
			if ( ! empty( $product_background_color ) ) {
				$css .= '.woocommerce .products .product-inner, .woocommerce ul.products li.product .woo-product-info, .woocommerce ul.products li.product .woo-product-gallery{background-color:'. $product_background_color .';}';
			}

			// Add border color
			if ( ! empty( $product_border_color ) ) {
				$css .= '.woocommerce .products .product-inner{border-color:'. $product_border_color .';}';
			}

			// Add category color
			if ( ! empty( $category_color ) && '#999999' != $category_color ) {
				$css .= '.woocommerce ul.products li.product li.category a{color:'. $category_color .';}';
			}

			// Add category color hover
			if ( ! empty( $category_color_hover ) && '#13aff0' != $category_color_hover ) {
				$css .= '.woocommerce ul.products li.product li.category a:hover{color:'. $category_color_hover .';}';
			}

			// Add product entry title color
			if ( ! empty( $product_title_color ) && '#333333' != $product_title_color ) {
				$css .= '.woocommerce ul.products li.product li.title a{color:'. $product_title_color .';}';
			}

			// Add product entry title color hover
			if ( ! empty( $product_title_color_hover ) && '#13aff0' != $product_title_color_hover ) {
				$css .= '.woocommerce ul.products li.product li.title a:hover{color:'. $product_title_color_hover .';}';
			}

			// Add product entry price color
			if ( ! empty( $product_entry_price_color ) && '#57bf6d' != $product_entry_price_color ) {
				$css .= '.woocommerce ul.products li.product .price, .woocommerce ul.products li.product .price .amount{color:'. $product_entry_price_color .';}';
			}

			// Add product entry del price color
			if ( ! empty( $product_entry_del_price_color ) && '#666666' != $product_entry_del_price_color ) {
				$css .= '.woocommerce ul.products li.product .price del .amount{color:'. $product_entry_del_price_color .';}';
			}

			// Add product hover thumbnails border color
			if ( ! empty( $product_entry_hover_thumbnails_border_color ) && '#13aff0' != $product_entry_hover_thumbnails_border_color ) {
				$css .= '.woocommerce ul.products li.product .woo-product-gallery .active a, .woocommerce ul.products li.product .woo-product-gallery a:hover{border-color:'. $product_entry_hover_thumbnails_border_color .';}';
			}

			// Add product hover quick view background
			if ( ! empty( $product_entry_hover_quickview_background ) && '#ffffff' != $product_entry_hover_quickview_background ) {
				$css .= '.woocommerce ul.products li.product .woo-entry-buttons li a.owp-quick-view{background-color:'. $product_entry_hover_quickview_background .';}';
			}

			// Add product hover quick view hover background
			if ( ! empty( $product_entry_hover_quickview_hover_background ) && '#ffffff' != $product_entry_hover_quickview_hover_background ) {
				$css .= '.woocommerce ul.products li.product .woo-entry-buttons li a.owp-quick-view:hover{background-color:'. $product_entry_hover_quickview_hover_background .';}';
			}

			// Add product hover quick view color
			if ( ! empty( $product_entry_hover_quickview_color ) && '#444444' != $product_entry_hover_quickview_color ) {
				$css .= '.woocommerce ul.products li.product .woo-entry-buttons li a.owp-quick-view{color:'. $product_entry_hover_quickview_color .';}';
			}

			// Add product hover quick view hover color
			if ( ! empty( $product_entry_hover_quickview_hover_color ) && '#13aff0' != $product_entry_hover_quickview_hover_color ) {
				$css .= '.woocommerce ul.products li.product .woo-entry-buttons li a.owp-quick-view:hover{color:'. $product_entry_hover_quickview_hover_color .';}';
			}

			// Add product hover wishlist background
			if ( ! empty( $product_entry_hover_wishlist_background ) && '#ffffff' != $product_entry_hover_wishlist_background ) {
				$css .= '.woocommerce ul.products li.product .woo-entry-buttons li a.tinvwl_add_to_wishlist_button{background-color:'. $product_entry_hover_wishlist_background .';}';
			}

			// Add product hover wishlist hover background
			if ( ! empty( $product_entry_hover_wishlist_hover_background ) && '#ffffff' != $product_entry_hover_wishlist_hover_background ) {
				$css .= '.woocommerce ul.products li.product .woo-entry-buttons li a.tinvwl_add_to_wishlist_button:hover{background-color:'. $product_entry_hover_wishlist_hover_background .';}';
			}

			// Add product hover wishlist color
			if ( ! empty( $product_entry_hover_wishlist_color ) && '#444444' != $product_entry_hover_wishlist_color ) {
				$css .= '.woocommerce ul.products li.product .woo-entry-buttons li a.tinvwl_add_to_wishlist_button{color:'. $product_entry_hover_wishlist_color .';}';
			}

			// Add product hover wishlist hover color
			if ( ! empty( $product_entry_hover_wishlist_hover_color ) && '#13aff0' != $product_entry_hover_wishlist_hover_color ) {
				$css .= '.woocommerce ul.products li.product .woo-entry-buttons li a.tinvwl_add_to_wishlist_button:hover{color:'. $product_entry_hover_wishlist_hover_color .';}';
			}

			// Add product entry add to cart background color
			if ( ! empty( $product_entry_addtocart_bg_color ) ) {
				$css .= '.woocommerce ul.products li.product .button,.woocommerce ul.products li.product .product-inner .added_to_cart{background-color:'. $product_entry_addtocart_bg_color .';}';
			}

			// Add product entry add to cart background color hover
			if ( ! empty( $product_entry_addtocart_bg_color_hover ) ) {
				$css .= '.woocommerce ul.products li.product .button:hover,.woocommerce ul.products li.product .product-inner .added_to_cart:hover{background-color:'. $product_entry_addtocart_bg_color_hover .';}';
			}

			// Add product entry add to cart color
			if ( ! empty( $product_entry_addtocart_color ) && '#848494' != $product_entry_addtocart_color ) {
				$css .= '.woocommerce ul.products li.product .button,.woocommerce ul.products li.product .product-inner .added_to_cart{color:'. $product_entry_addtocart_color .';}';
			}

			// Add product entry add to cart color hover
			if ( ! empty( $product_entry_addtocart_color_hover ) && '#13aff0' != $product_entry_addtocart_color_hover ) {
				$css .= '.woocommerce ul.products li.product .button:hover,.woocommerce ul.products li.product .product-inner .added_to_cart:hover{color:'. $product_entry_addtocart_color_hover .';}';
			}

			// Add product entry add to cart border color
			if ( ! empty( $product_entry_addtocart_border_color ) && '#e4e4e4' != $product_entry_addtocart_border_color ) {
				$css .= '.woocommerce ul.products li.product .button,.woocommerce ul.products li.product .product-inner .added_to_cart{border-color:'. $product_entry_addtocart_border_color .';}';
			}

			// Add product entry add to cart border color hover
			if ( ! empty( $product_entry_addtocart_border_color_hover ) && '#13aff0' != $product_entry_addtocart_border_color_hover ) {
				$css .= '.woocommerce ul.products li.product .button:hover,.woocommerce ul.products li.product .product-inner .added_to_cart:hover{border-color:'. $product_entry_addtocart_border_color_hover .';}';
			}

			// Add product entry add to cart border style
			if ( ! empty( $product_entry_addtocart_border_style ) && 'double' != $product_entry_addtocart_border_style ) {
				$css .= '.woocommerce ul.products li.product .button,.woocommerce ul.products li.product .product-inner .added_to_cart{border-style:'. $product_entry_addtocart_border_style .';}';
			}

			// Add product entry add to cart border size
			if ( ! empty( $product_entry_addtocart_border_size ) && '3' != $product_entry_addtocart_border_size ) {
				$css .= '.woocommerce ul.products li.product .button,.woocommerce ul.products li.product .product-inner .added_to_cart{border-width:'. $product_entry_addtocart_border_size .';}';
			}

			// Add product entry add to cart border radius
			if ( ! empty( $product_entry_addtocart_border_radius ) ) {
				$css .= '.woocommerce ul.products li.product .button,.woocommerce ul.products li.product .product-inner .added_to_cart{border-radius:'. $product_entry_addtocart_border_radius .';}';
			}

			// Add quick view button background
			if ( ! empty( $quick_view_button_bg ) && 'rgba(0,0,0,0.6)' != $quick_view_button_bg ) {
				$css .= '.owp-quick-view{background-color:'. $quick_view_button_bg .';}';
			}

			// Add quick view button hover background
			if ( ! empty( $quick_view_button_hover_bg ) && 'rgba(0,0,0,0.9)' != $quick_view_button_hover_bg ) {
				$css .= '.owp-quick-view:hover{background-color:'. $quick_view_button_hover_bg .';}';
			}

			// Add quick view button color
			if ( ! empty( $quick_view_button_color ) && '#ffffff' != $quick_view_button_color ) {
				$css .= '.owp-quick-view{color:'. $quick_view_button_color .';}';
			}

			// Add quick view button hover color
			if ( ! empty( $quick_view_button_hover_color ) && '#ffffff' != $quick_view_button_hover_color ) {
				$css .= '.owp-quick-view:hover{color:'. $quick_view_button_hover_color .';}';
			}

			// Add quick view overlay background
			if ( ! empty( $quick_view_overlay_bg ) && 'rgba(0,0,0,0.15)' != $quick_view_overlay_bg ) {
				$css .= '.image-wrap.loading:after{background-color:'. $quick_view_overlay_bg .';}';
			}

			// Add quick view overlay spinner outside color
			if ( ! empty( $quick_view_overlay_spinner_outside_color ) && 'rgba(0,0,0,0.1)' != $quick_view_overlay_spinner_outside_color ) {
				$css .= '.image-wrap.loading:before{border-color:'. $quick_view_overlay_spinner_outside_color .';}';
			}

			// Add quick view overlay spinner inner color
			if ( ! empty( $quick_view_overlay_spinner_inner_color ) && '#ffffff' != $quick_view_overlay_spinner_inner_color ) {
				$css .= '.image-wrap.loading:before{border-left-color:'. $quick_view_overlay_spinner_inner_color .';}';
			}

			// Add quick view modal background
			if ( ! empty( $quick_view_modal_bg ) && '#ffffff' != $quick_view_modal_bg ) {
				$css .= '.owp-qv-content-inner{background-color:'. $quick_view_modal_bg .';}';
			}

			// Add quick view modal close button color
			if ( ! empty( $quick_view_modal_close_color ) && '#333333' != $quick_view_modal_close_color ) {
				$css .= '.owp-qv-content-inner .owp-qv-close{color:'. $quick_view_modal_close_color .';}';
			}

			// Add off canvas background
			if ( ! empty( $off_canvas_sidebar_bg ) && '#ffffff' != $off_canvas_sidebar_bg ) {
				$css .= '#lumen-off-canvas-sidebar-wrap .lumen-off-canvas-sidebar{background-color:'. $off_canvas_sidebar_bg .';}';
			}

			// Add off canvas border color
			if ( ! empty( $off_canvas_sidebar_widgets_border ) && 'rgba(84,84,84,0.15)' != $off_canvas_sidebar_widgets_border ) {
				$css .= '#lumen-off-canvas-sidebar-wrap .sidebar-box{border-color:'. $off_canvas_sidebar_widgets_border .';}';
			}

			// Add single product title color
			if ( ! empty( $single_product_title_color ) && '#333333' != $single_product_title_color ) {
				$css .= '.woocommerce div.product .product_title{color:'. $single_product_title_color .';}';
			}

			// Add single product price color
			if ( ! empty( $single_product_price_color ) && '#57bf6d' != $single_product_price_color ) {
				$css .= '.price,.amount{color:'. $single_product_price_color .';}';
			}

			// Add single product del price color
			if ( ! empty( $single_product_del_price_color ) && '#555555' != $single_product_del_price_color ) {
				$css .= '.price del,del .amount{color:'. $single_product_del_price_color .';}';
			}

			// Add single product description color
			if ( ! empty( $single_product_description_color ) && '#aaaaaa' != $single_product_description_color ) {
				$css .= '.woocommerce div.product div[itemprop="description"]{color:'. $single_product_description_color .';}';
			}

			// Add single product meta title color
			if ( ! empty( $single_product_meta_title_color ) && '#333333' != $single_product_meta_title_color ) {
				$css .= '.product_meta .posted_in,.product_meta .tagged_as{color:'. $single_product_meta_title_color .';}';
			}

			// Add single product meta link color
			if ( ! empty( $single_product_meta_link_color ) && '#aaaaaa' != $single_product_meta_link_color ) {
				$css .= '.product_meta .posted_in a,.product_meta .tagged_as a{color:'. $single_product_meta_link_color .';}';
			}

			// Add single product meta link color hover
			if ( ! empty( $single_product_meta_link_color_hover ) && '#13aff0' != $single_product_meta_link_color_hover ) {
				$css .= '.product_meta .posted_in a:hover,.product_meta .tagged_as a:hover{color:'. $single_product_meta_link_color_hover .';}';
			}

			// Add single product navigation border radius
			if ( isset( $single_product_navigation_border_radius ) && '30' != $single_product_navigation_border_radius && '' != $single_product_navigation_border_radius ) {
				$css .= '.owp-product-nav li a.owp-nav-link{-webkit-border-radius: '. $single_product_navigation_border_radius .'px; -moz-border-radius: '. $single_product_navigation_border_radius .'px; -ms-border-radius: '. $single_product_navigation_border_radius .'px; border-radius: '. $single_product_navigation_border_radius .'px;}';
			}

			// Add single product navigation background color
			if ( ! empty( $single_product_navigation_bg ) ) {
				$css .= '.owp-product-nav li a.owp-nav-link{background-color:'. $single_product_navigation_bg .';}';
			}
			
			// Add single product navigation background color
			if ( ! empty( $single_product_navigation_hover_bg ) && '#13aff0' != $single_product_navigation_hover_bg ) {
				$css .= '.owp-product-nav li a.owp-nav-link:hover{background-color:'. $single_product_navigation_hover_bg .';}';
			}
			
			// Add single product navigation color
			if ( ! empty( $single_product_navigation_color ) && '#333333' != $single_product_navigation_color ) {
				$css .= '.owp-product-nav li a.owp-nav-link{color:'. $single_product_navigation_color .';}';
			}
			
			// Add single product navigation color
			if ( ! empty( $single_product_navigation_hover_color ) && '#ffffff' != $single_product_navigation_hover_color ) {
				$css .= '.owp-product-nav li a.owp-nav-link:hover{color:'. $single_product_navigation_hover_color .';}';
			}
			
			// Add single product navigation border color
			if ( ! empty( $single_product_navigation_border_color ) && '#e9e9e9' != $single_product_navigation_border_color ) {
				$css .= '.owp-product-nav li a.owp-nav-link{border-color:'. $single_product_navigation_border_color .';}';
			}
			
			// Add single product navigation border color
			if ( ! empty( $single_product_navigation_hover_border_color ) && '#13aff0' != $single_product_navigation_hover_border_color ) {
				$css .= '.owp-product-nav li a.owp-nav-link:hover{border-color:'. $single_product_navigation_hover_border_color .';}';
			}

			// Add product entry add to cart background color
			if ( ! empty( $single_product_addtocart_bg_color ) ) {
				$css .= '.woocommerce div.product div.summary button.single_add_to_cart_button{background-color:'. $single_product_addtocart_bg_color .';}';
			}

			// Add product entry add to cart background color hover
			if ( ! empty( $single_product_addtocart_bg_color_hover ) ) {
				$css .= '.woocommerce div.product div.summary button.single_add_to_cart_button:hover{background-color:'. $single_product_addtocart_bg_color_hover .';}';
			}

			// Add product entry add to cart color
			if ( ! empty( $single_product_addtocart_color ) ) {
				$css .= '.woocommerce div.product div.summary button.single_add_to_cart_button{color:'. $single_product_addtocart_color .';}';
			}

			// Add product entry add to cart color hover
			if ( ! empty( $single_product_addtocart_color_hover ) ) {
				$css .= '.woocommerce div.product div.summary button.single_add_to_cart_button:hover{color:'. $single_product_addtocart_color_hover .';}';
			}

			// Add product entry add to cart border color
			if ( ! empty( $single_product_addtocart_border_color ) ) {
				$css .= '.woocommerce div.product div.summary button.single_add_to_cart_button{border-color:'. $single_product_addtocart_border_color .';}';
			}

			// Add product entry add to cart border color hover
			if ( ! empty( $single_product_addtocart_border_color_hover ) ) {
				$css .= '.woocommerce div.product div.summary button.single_add_to_cart_button:hover{border-color:'. $single_product_addtocart_border_color_hover .';}';
			}

			// Add product entry add to cart border style
			if ( ! empty( $single_product_addtocart_border_style ) ) {
				$css .= '.woocommerce div.product div.summary button.single_add_to_cart_button{border-style:'. $single_product_addtocart_border_style .';}';
			}

			// Add product entry add to cart border size
			if ( ! empty( $single_product_addtocart_border_size ) ) {
				$css .= '.woocommerce div.product div.summary button.single_add_to_cart_button{border-width:'. $single_product_addtocart_border_size .';}';
			}

			// Add product entry add to cart border radius
			if ( ! empty( $single_product_addtocart_border_radius ) ) {
				$css .= '.woocommerce div.product div.summary button.single_add_to_cart_button{border-radius:'. $single_product_addtocart_border_radius .';}';
			}

			// Add single product tabs borders color
			if ( ! empty( $single_product_tabs_borders_color ) && '#e9e9e9' != $single_product_tabs_borders_color ) {
				$css .= '.woocommerce div.product .woocommerce-tabs ul.tabs{border-color:'. $single_product_tabs_borders_color .';}';
			}

			// Add single product tabs text color
			if ( ! empty( $single_product_tabs_text_color ) && '#999999' != $single_product_tabs_text_color ) {
				$css .= '.woocommerce div.product .woocommerce-tabs ul.tabs li a{color:'. $single_product_tabs_text_color .';}';
			}

			// Add single product tabs text color hover
			if ( ! empty( $single_product_tabs_text_color_hover ) && '#13aff0' != $single_product_tabs_text_color_hover ) {
				$css .= '.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover{color:'. $single_product_tabs_text_color_hover .';}';
			}

			// Add single product tabs active text color
			if ( ! empty( $single_product_tabs_active_text_color ) && '#13aff0' != $single_product_tabs_active_text_color ) {
				$css .= '.woocommerce div.product .woocommerce-tabs ul.tabs li.active a{color:'. $single_product_tabs_active_text_color .';}';
			}

			// Add single product tabs active text borders color
			if ( ! empty( $single_product_tabs_active_text_borders_color ) && '#13aff0' != $single_product_tabs_active_text_borders_color ) {
				$css .= '.woocommerce div.product .woocommerce-tabs ul.tabs li.active a{border-color:'. $single_product_tabs_active_text_borders_color .';}';
			}

			// Add single product tabs product description title color
			if ( ! empty( $single_product_tabs_product_desc_title_color ) && '#333333' != $single_product_tabs_product_desc_title_color ) {
				$css .= '.woocommerce div.product .woocommerce-tabs .panel h2{color:'. $single_product_tabs_product_desc_title_color .';}';
			}

			// Add single product tabs product description color
			if ( ! empty( $single_product_tabs_product_desc_color ) && '#929292' != $single_product_tabs_product_desc_color ) {
				$css .= '.woocommerce div.product .woocommerce-tabs .panel p{color:'. $single_product_tabs_product_desc_color .';}';
			}

			// Add account Login/Register color
			if ( ! empty( $account_login_register_color ) && '#333333' != $account_login_register_color ) {
				$css .= '.woocommerce .owp-account-links li .owp-account-link, .woocommerce .owp-account-links li.orDisplay Related Items{color:'. $account_login_register_color .';}';
			}

			// Add account navigation borders color
			if ( ! empty( $account_nav_borders_color ) && '#e9e9e9' != $account_nav_borders_color ) {
				$css .= '.woocommerce-MyAccount-navigation ul,.woocommerce-MyAccount-navigation ul li{border-color:'. $account_nav_borders_color .';}';
			}

			// Add account navigation icons color
			if ( ! empty( $account_nav_icons_color ) && '#13aff0' != $account_nav_icons_color ) {
				$css .= '.woocommerce-MyAccount-navigation ul li a:before{color:'. $account_nav_icons_color .';}';
			}

			// Add account navigation links color
			if ( ! empty( $account_nav_links_color ) && '#333333' != $account_nav_links_color ) {
				$css .= '.woocommerce-MyAccount-navigation ul li a{color:'. $account_nav_links_color .';}';
			}

			// Add account navigation links color hover
			if ( ! empty( $account_nav_links_color_hover ) && '#13aff0' != $account_nav_links_color_hover ) {
				$css .= '.woocommerce-MyAccount-navigation ul li a:hover{color:'. $account_nav_links_color_hover .';}';
			}

			// Add account addresses background color
			if ( ! empty( $account_addresses_bg ) && '#f6f6f6' != $account_addresses_bg ) {
				$css .= '.woocommerce-MyAccount-content .addresses .woocommerce-Address .title, .woocommerce-MyAccount-content .addresses .woocommerce-Address address{background-color:'. $account_addresses_bg .';}';
			}

			// Add account addresses title color
			if ( ! empty( $account_addresses_title_color ) && '#333333' != $account_addresses_title_color ) {
				$css .= '.woocommerce-MyAccount-content .addresses .woocommerce-Address .title h3{color:'. $account_addresses_title_color .';}';
			}

			// Add account addresses title border color
			if ( ! empty( $account_addresses_title_border_color ) && '#ffffff' != $account_addresses_title_border_color ) {
				$css .= '.woocommerce-MyAccount-content .addresses .woocommerce-Address .title{border-color:'. $account_addresses_title_border_color .';}';
			}

			// Add account addresses content color
			if ( ! empty( $account_addresses_content_color ) && '#898989' != $account_addresses_content_color ) {
				$css .= '.woocommerce-MyAccount-content .addresses .woocommerce-Address address{color:'. $account_addresses_content_color .';}';
			}

			// Add account addresses button background color
			if ( ! empty( $account_addresses_button_bg ) && '#ffffff' != $account_addresses_button_bg ) {
				$css .= '.woocommerce-MyAccount-content .addresses .woocommerce-Address .title a{background-color:'. $account_addresses_button_bg .';}';
			}

			// Add account addresses button background color hover
			if ( ! empty( $account_addresses_button_bg_hover ) && '#f8f8f8' != $account_addresses_button_bg_hover ) {
				$css .= '.woocommerce-MyAccount-content .addresses .woocommerce-Address .title a:hover{background-color:'. $account_addresses_button_bg_hover .';}';
			}

			// Add account addresses button color
			if ( ! empty( $account_addresses_button_color ) && '#898989' != $account_addresses_button_color ) {
				$css .= '.woocommerce-MyAccount-content .addresses .woocommerce-Address .title a{color:'. $account_addresses_button_color .';}';
			}

			// Add account addresses button color hover
			if ( ! empty( $account_addresses_button_color_hover ) && '#555555' != $account_addresses_button_color_hover ) {
				$css .= '.woocommerce-MyAccount-content .addresses .woocommerce-Address .title a:hover{color:'. $account_addresses_button_color_hover .';}';
			}

			// Add cart borders color
			if ( ! empty( $cart_borders_color ) && '#e9e9e9' != $cart_borders_color ) {
				$css .= '.woocommerce-cart table.shop_table,.woocommerce-cart table.shop_table th,.woocommerce-cart table.shop_table td,.woocommerce-cart .cart-collaterals .cross-sells,.woocommerce-page .cart-collaterals .cross-sells,.woocommerce-cart .cart-collaterals h2,.woocommerce-cart .cart-collaterals .cart_totals,.woocommerce-page .cart-collaterals .cart_totals,.woocommerce-cart .cart-collaterals .cart_totals table th,.woocommerce-cart .cart-collaterals .cart_totals .order-total th,.woocommerce-cart table.shop_table td,.woocommerce-cart .cart-collaterals .cart_totals tr td,.woocommerce-cart .cart-collaterals .cart_totals .order-total td{border-color:'. $cart_borders_color .';}';
			}

			// Add cart head background
			if ( ! empty( $cart_head_bg ) && '#f7f7f7' != $cart_head_bg ) {
				$css .= '.woocommerce-cart table.shop_table thead,.woocommerce-cart .cart-collaterals h2{background-color:'. $cart_head_bg .';}';
			}

			// Add cart head titles color
			if ( ! empty( $cart_head_titles_color ) && '#444444' != $cart_head_titles_color ) {
				$css .= '.woocommerce-cart table.shop_table thead th,.woocommerce-cart .cart-collaterals h2{color:'. $cart_head_titles_color .';}';
			}

			// Add cart totals table titles color
			if ( ! empty( $cart_totals_table_titles_color ) && '#444444' != $cart_totals_table_titles_color ) {
				$css .= '.woocommerce-cart .cart-collaterals .cart_totals table th{color:'. $cart_totals_table_titles_color .';}';
			}

			// Add cart remove button color
			if ( ! empty( $cart_remove_button_color ) && '#bbbbbb' != $cart_remove_button_color ) {
				$css .= '.woocommerce table.shop_table a.remove{color:'. $cart_remove_button_color .';}';
			}

			// Add cart remove button color hover
			if ( ! empty( $cart_remove_button_color_hover ) && '#333333' != $cart_remove_button_color_hover ) {
				$css .= '.woocommerce table.shop_table a.remove:hover{color:'. $cart_remove_button_color_hover .';}';
			}

			// Add checkout notices borders color
			if ( ! empty( $checkout_notices_borders_color ) && '#e9e9e9' != $checkout_notices_borders_color ) {
				$css .= '.woocommerce-checkout .woocommerce-info{border-color:'. $checkout_notices_borders_color .';}';
			}

			// Add checkout notices icon color
			if ( ! empty( $checkout_notices_icon_color ) && '#dddddd' != $checkout_notices_icon_color ) {
				$css .= '.woocommerce-checkout .woocommerce-info:before{color:'. $checkout_notices_icon_color .';}';
			}

			// Add checkout notices color
			if ( ! empty( $checkout_notices_color ) && '#777777' != $checkout_notices_color ) {
				$css .= '.woocommerce-checkout .woocommerce-info{color:'. $checkout_notices_color .';}';
			}

			// Add checkout notices link color
			if ( ! empty( $checkout_notices_link_color ) && '#13aff0' != $checkout_notices_link_color ) {
				$css .= '.woocommerce-checkout .woocommerce-info a{color:'. $checkout_notices_link_color .';}';
			}

			// Add checkout notices link color hover
			if ( ! empty( $checkout_notices_link_color_hover ) && '#333333' != $checkout_notices_link_color_hover ) {
				$css .= '.woocommerce-checkout .woocommerce-info a:hover{color:'. $checkout_notices_link_color_hover .';}';
			}

			// Add checkout notices form border color
			if ( ! empty( $checkout_notices_form_border_color ) && '#e9e9e9' != $checkout_notices_form_border_color ) {
				$css .= '.woocommerce-checkout form.login,.woocommerce-checkout form.checkout_coupon{border-color:'. $checkout_notices_form_border_color .';}';
			}

			// Add checkout titles color
			if ( ! empty( $checkout_titles_color ) && '#333333' != $checkout_titles_color ) {
				$css .= '.woocommerce .woocommerce-checkout #customer_details h3,.woocommerce .woocommerce-checkout h3#order_review_heading{color:'. $checkout_titles_color .';}';
			}

			// Add checkout notices titles border bottom color
			if ( ! empty( $checkout_titles_border_bottom_color ) && '#e9e9e9' != $checkout_titles_border_bottom_color ) {
				$css .= '.woocommerce .woocommerce-checkout #customer_details h3,.woocommerce .woocommerce-checkout h3#order_review_heading{border-color:'. $checkout_titles_border_bottom_color .';}';
			}

			// Add checkout table main background
			if ( ! empty( $checkout_table_main_bg ) && '#f7f7f7' != $checkout_table_main_bg ) {
				$css .= '.woocommerce table.shop_table thead,.woocommerce-checkout-review-order-table tfoot th{background-color:'. $checkout_table_main_bg .';}';
			}

			// Add checkout table titles color
			if ( ! empty( $checkout_table_titles_color ) && '#444444' != $checkout_table_titles_color ) {
				$css .= '.woocommerce-checkout table.shop_table thead th,.woocommerce #order_review table.shop_table tfoot th{color:'. $checkout_table_titles_color .';}';
			}

			// Add checkout table borders color
			if ( ! empty( $checkout_table_borders_color ) && '#e9e9e9' != $checkout_table_borders_color ) {
				$css .= '.woocommerce-checkout table.shop_table,.woocommerce-checkout table.shop_table th,.woocommerce-checkout table.shop_table td,.woocommerce-checkout table.shop_table tfoot th,.woocommerce-checkout table.shop_table tfoot td{border-color:'. $checkout_table_borders_color .';}';
			}

			// Add checkout payment methods background
			if ( ! empty( $checkout_payment_methods_bg ) && '#f8f8f8' != $checkout_payment_methods_bg ) {
				$css .= '.woocommerce-checkout #payment{background-color:'. $checkout_payment_methods_bg .';}';
			}

			// Add checkout payment methods borders color
			if ( ! empty( $checkout_payment_methods_borders_color ) && '#e9e9e9' != $checkout_payment_methods_borders_color ) {
				$css .= '.woocommerce-checkout #payment,.woocommerce-checkout #payment ul.payment_methods{border-color:'. $checkout_payment_methods_borders_color .';}';
			}

			// Add checkout payment box background
			if ( ! empty( $checkout_payment_box_bg ) && '#ffffff' != $checkout_payment_box_bg ) {
				$css .= '.woocommerce-checkout #payment div.payment_box{background-color:'. $checkout_payment_box_bg .';}';
			}

			// Add checkout payment box color
			if ( ! empty( $checkout_payment_box_color ) && '#515151' != $checkout_payment_box_color ) {
				$css .= '.woocommerce-checkout #payment div.payment_box{color:'. $checkout_payment_box_color .';}';
			}

			// If shop page Both Sidebars layout
			if ( 'both-sidebars' == $archives_layout ) {

				// Both Sidebars layout shop page content width
				if ( ! empty( $bs_archives_content_width ) ) {
					$css .=
						'@media only screen and (min-width: 960px){
							body.woocommerce.archive.content-both-sidebars .content-area {width: '. $bs_archives_content_width .'%;}
							body.woocommerce.archive.content-both-sidebars.scs-style .widget-area.sidebar-secondary,
							body.woocommerce.archive.content-both-sidebars.ssc-style .widget-area {left: -'. $bs_archives_content_width .'%;}
						}';
				}

				// Both Sidebars layout shop page sidebars width
				if ( ! empty( $bs_archives_sidebars_width ) ) {
					$css .=
						'@media only screen and (min-width: 960px){
							body.woocommerce.archive.content-both-sidebars .widget-area{width:'. $bs_archives_sidebars_width .'%;}
							body.woocommerce.archive.content-both-sidebars.scs-style .content-area{left:'. $bs_archives_sidebars_width .'%;}
							body.woocommerce.archive.content-both-sidebars.ssc-style .content-area{left:'. $bs_archives_sidebars_width * 2 .'%;}
						}';
				}

			}

			// If single product Both Sidebars layout
			if ( 'both-sidebars' == $single_layout ) {

				// Both Sidebars layout single product content width
				if ( ! empty( $bs_single_content_width ) ) {
					$css .=
						'@media only screen and (min-width: 960px){
							body.single-product.content-both-sidebars .content-area {width: '. $bs_single_content_width .'%;}
							body.single-product.content-both-sidebars.scs-style .widget-area.sidebar-secondary,
							body.single-product.content-both-sidebars.ssc-style .widget-area {left: -'. $bs_single_content_width .'%;}
						}';
				}

				// Both Sidebars layout single product sidebars width
				if ( ! empty( $bs_single_sidebars_width ) ) {
					$css .=
						'@media only screen and (min-width: 960px){
							body.single-product.content-both-sidebars .widget-area{width:'. $bs_single_sidebars_width .'%;}
							body.single-product.content-both-sidebars.scs-style .content-area{left:'. $bs_single_sidebars_width .'%;}
							body.single-product.content-both-sidebars.ssc-style .content-area{left:'. $bs_single_sidebars_width * 2 .'%;}
						}';
				}

			}
				
			// Return CSS
			if ( ! empty( $css ) ) {
				$output .= '/* WooCommerce CSS */'. $css;
			}

			// Return output css
			return $output;

		}

	}

endif;

return new lumenWP_WooCommerce_Customizer();