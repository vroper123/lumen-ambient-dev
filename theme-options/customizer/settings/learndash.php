<?php
/**
 * LearnDash Customizer Options
 *
 * @package LumenWP WordPress theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'lumenWP_LearnDash_Customizer' ) ) :

	class lumenWP_LearnDash_Customizer {

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
			$panel = 'lumen_ld_panel';
			$wp_customize->add_panel( $panel , array(
				'title' 			=> esc_html__( 'LearnDash', 'lumen' ),
				'priority' 			=> 210,
			) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'lumen_ld_general' , array(
				'title' 			=> esc_html__( 'General', 'lumen' ),
				'description' 		=> esc_html__( 'For some options, you must save and refresh your live site to preview changes.', 'lumen' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * General Header
			 */
			$wp_customize->add_setting( 'lumen_ld_general_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_ld_general_heading', array(
				'label'    	=> esc_html__( 'General', 'lumen' ),
				'section'  	=> 'lumen_ld_general',
				'priority' 	=> 10,
			) ) );

			/**
			 * Distraction Free Learning
			 */
			$wp_customize->add_setting( 'lumen_ld_distraction_free_learning', array(
				'default'           	=> false,
				'sanitize_callback' 	=> 'lumenwp_sanitize_checkbox',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_ld_distraction_free_learning', array(
				'label'	   				=> esc_html__( 'Distraction Free Learning', 'lumen' ),
				'type' 					=> 'checkbox',
				'section'  				=> 'lumen_ld_general',
				'settings' 				=> 'lumen_ld_distraction_free_learning',
				'priority' 				=> 10,
			) ) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'lumen_ld_layout' , array(
				'title' 			=> esc_html__( 'Layout', 'lumen' ),
				'description' 		=> esc_html__( 'For some options, you must save and refresh your live site to preview changes.', 'lumen' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Global Layout Header
			 */
			$wp_customize->add_setting( 'lumen_ld_global_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_ld_global_heading', array(
				'label'    	=> esc_html__( 'Global', 'lumen' ),
				'section'  	=> 'lumen_ld_layout',
				'priority' 	=> 10,
			) ) );

			/**
			 * Layout
			 */
			$wp_customize->add_setting( 'lumen_ld_global_layout', array(
				'default'           	=> 'full-width',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Radio_Image_Control( $wp_customize, 'lumen_ld_global_layout', array(
				'label'	   				=> esc_html__( 'Layout', 'lumen' ),
				'section'  				=> 'lumen_ld_layout',
				'settings' 				=> 'lumen_ld_global_layout',
				'priority' 				=> 10,
				'choices' 				=> lumenwp_customizer_layout(),
			) ) );

			/**
			 * Both Sidebars Style
			 */
			$wp_customize->add_setting( 'lumen_ld_global_both_sidebars_style', array(
				'default'           	=> 'scs-style',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_ld_global_both_sidebars_style', array(
				'label'	   				=> esc_html__( 'Both Sidebars: Style', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_ld_layout',
				'settings' 				=> 'lumen_ld_global_both_sidebars_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'ssc-style' 		=> esc_html__( 'Sidebar / Sidebar / Content', 'lumen' ),
					'scs-style' 		=> esc_html__( 'Sidebar / Content / Sidebar', 'lumen' ),
					'css-style' 		=> esc_html__( 'Content / Sidebar / Sidebar', 'lumen' ),
				),
				'active_callback' 		=> 'lumenwp_cac_has_ld_global_bs_layout',
			) ) );

			/**
			 * Both Sidebars Content Width
			 */
			$wp_customize->add_setting( 'lumen_ld_global_both_sidebars_content_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_ld_global_both_sidebars_content_width', array(
				'label'	   				=> esc_html__( 'Both Sidebars: Content Width (%)', 'lumen' ),
				'type' 					=> 'number',
				'section'  				=> 'lumen_ld_layout',
				'settings' 				=> 'lumen_ld_global_both_sidebars_content_width',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
				'active_callback' 		=> 'lumenwp_cac_has_ld_global_bs_layout',
			) ) );

			/**
			 * Both Sidebars Sidebars Width
			 */
			$wp_customize->add_setting( 'lumen_ld_global_both_sidebars_sidebars_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_ld_global_both_sidebars_sidebars_width', array(
				'label'	   				=> esc_html__( 'Both Sidebars: Sidebars Width (%)', 'lumen' ),
				'type' 					=> 'number',
				'section'  				=> 'lumen_ld_layout',
				'settings' 				=> 'lumen_ld_global_both_sidebars_sidebars_width',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
				'active_callback' 		=> 'lumenwp_cac_has_ld_global_bs_layout',
			) ) );

			/**
			 * Mobile Sidebar Order
			 */
			$wp_customize->add_setting( 'lumen_ld_global_sidebar_order', array(
				'default'           	=> 'content-sidebar',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_ld_global_sidebar_order', array(
				'label'	   				=> esc_html__( 'Mobile Sidebar Order', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_ld_layout',
				'settings' 				=> 'lumen_ld_global_sidebar_order',
				'priority' 				=> 10,
				'choices' 				=> array(
					'content-sidebar' 	=> esc_html__( 'Content / Sidebar', 'lumen' ),
					'sidebar-content' 	=> esc_html__( 'Sidebar / Content', 'lumen' ),
				),
				'active_callback' 		=> 'lumenwp_cac_has_ld_global_rl_layout',
			) ) );

			/**
			 * Course Page Header
			 */
			$wp_customize->add_setting( 'lumen_ld_course_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_ld_course_heading', array(
				'label'    	=> esc_html__( 'Course', 'lumen' ),
				'section'  	=> 'lumen_ld_layout',
				'priority' 	=> 10,
			) ) );

			/**
			 * Layout
			 */
			$wp_customize->add_setting( 'lumen_ld_course_layout', array(
				'default'           	=> 'left-sidebar',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Radio_Image_Control( $wp_customize, 'lumen_ld_course_layout', array(
				'label'	   				=> esc_html__( 'Layout', 'lumen' ),
				'section'  				=> 'lumen_ld_layout',
				'settings' 				=> 'lumen_ld_course_layout',
				'priority' 				=> 10,
				'choices' 				=> lumenwp_customizer_layout(),
			) ) );

			/**
			 * Both Sidebars Style
			 */
			$wp_customize->add_setting( 'lumen_ld_course_both_sidebars_style', array(
				'default'           	=> 'scs-style',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_ld_course_both_sidebars_style', array(
				'label'	   				=> esc_html__( 'Both Sidebars: Style', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_ld_layout',
				'settings' 				=> 'lumen_ld_course_both_sidebars_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'ssc-style' 		=> esc_html__( 'Sidebar / Sidebar / Content', 'lumen' ),
					'scs-style' 		=> esc_html__( 'Sidebar / Content / Sidebar', 'lumen' ),
					'css-style' 		=> esc_html__( 'Content / Sidebar / Sidebar', 'lumen' ),
				),
				'active_callback' 		=> 'lumenwp_cac_has_ld_course_bs_layout',
			) ) );

			/**
			 * Both Sidebars Content Width
			 */
			$wp_customize->add_setting( 'lumen_ld_course_both_sidebars_content_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_ld_course_both_sidebars_content_width', array(
				'label'	   				=> esc_html__( 'Both Sidebars: Content Width (%)', 'lumen' ),
				'type' 					=> 'number',
				'section'  				=> 'lumen_ld_layout',
				'settings' 				=> 'lumen_ld_course_both_sidebars_content_width',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
				'active_callback' 		=> 'lumenwp_cac_has_ld_course_bs_layout',
			) ) );

			/**
			 * Both Sidebars Sidebars Width
			 */
			$wp_customize->add_setting( 'lumen_ld_course_both_sidebars_sidebars_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_ld_course_both_sidebars_sidebars_width', array(
				'label'	   				=> esc_html__( 'Both Sidebars: Sidebars Width (%)', 'lumen' ),
				'type' 					=> 'number',
				'section'  				=> 'lumen_ld_layout',
				'settings' 				=> 'lumen_ld_course_both_sidebars_sidebars_width',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
				'active_callback' 		=> 'lumenwp_cac_has_ld_course_bs_layout',
			) ) );

			/**
			 * Mobile Sidebar Order
			 */
			$wp_customize->add_setting( 'lumen_ld_course_sidebar_order', array(
				'default'           	=> 'content-sidebar',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_ld_course_sidebar_order', array(
				'label'	   				=> esc_html__( 'Mobile Sidebar Order', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_ld_layout',
				'settings' 				=> 'lumen_ld_course_sidebar_order',
				'priority' 				=> 10,
				'choices' 				=> array(
					'content-sidebar' 	=> esc_html__( 'Content / Sidebar', 'lumen' ),
					'sidebar-content' 	=> esc_html__( 'Sidebar / Content', 'lumen' ),
				),
				'active_callback' 		=> 'lumenwp_cac_has_ld_course_rl_layout',
			) ) );

			/**
			 * Lesson Page Header
			 */
			$wp_customize->add_setting( 'lumen_ld_lesson_heading', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_ld_lesson_heading', array(
				'label'    	=> esc_html__( 'Lesson/Topic', 'lumen' ),
				'section'  	=> 'lumen_ld_layout',
				'priority' 	=> 10,
			) ) );

			/**
			 * Layout
			 */
			$wp_customize->add_setting( 'lumen_ld_lesson_layout', array(
				'default'           	=> 'left-sidebar',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Radio_Image_Control( $wp_customize, 'lumen_ld_lesson_layout', array(
				'label'	   				=> esc_html__( 'Layout', 'lumen' ),
				'section'  				=> 'lumen_ld_layout',
				'settings' 				=> 'lumen_ld_lesson_layout',
				'priority' 				=> 10,
				'choices' 				=> lumenwp_customizer_layout(),
			) ) );

			/**
			 * Both Sidebars Style
			 */
			$wp_customize->add_setting( 'lumen_ld_lesson_both_sidebars_style', array(
				'default'           	=> 'scs-style',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_ld_lesson_both_sidebars_style', array(
				'label'	   				=> esc_html__( 'Both Sidebars: Style', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_ld_layout',
				'settings' 				=> 'lumen_ld_lesson_both_sidebars_style',
				'priority' 				=> 10,
				'choices' 				=> array(
					'ssc-style' 		=> esc_html__( 'Sidebar / Sidebar / Content', 'lumen' ),
					'scs-style' 		=> esc_html__( 'Sidebar / Content / Sidebar', 'lumen' ),
					'css-style' 		=> esc_html__( 'Content / Sidebar / Sidebar', 'lumen' ),
				),
				'active_callback' 		=> 'lumenwp_cac_has_ld_lesson_bs_layout',
			) ) );

			/**
			 * Both Sidebars Content Width
			 */
			$wp_customize->add_setting( 'lumen_ld_lesson_both_sidebars_content_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_ld_lesson_both_sidebars_content_width', array(
				'label'	   				=> esc_html__( 'Both Sidebars: Content Width (%)', 'lumen' ),
				'type' 					=> 'number',
				'section'  				=> 'lumen_ld_layout',
				'settings' 				=> 'lumen_ld_lesson_both_sidebars_content_width',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
				'active_callback' 		=> 'lumenwp_cac_has_ld_lesson_bs_layout',
			) ) );

			/**
			 * Both Sidebars Sidebars Width
			 */
			$wp_customize->add_setting( 'lumen_ld_lesson_both_sidebars_sidebars_width', array(
				'transport' 			=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_number_blank',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_ld_lesson_both_sidebars_sidebars_width', array(
				'label'	   				=> esc_html__( 'Both Sidebars: Sidebars Width (%)', 'lumen' ),
				'type' 					=> 'number',
				'section'  				=> 'lumen_ld_layout',
				'settings' 				=> 'lumen_ld_lesson_both_sidebars_sidebars_width',
				'priority' 				=> 10,
			    'input_attrs' 			=> array(
			        'min'   => 0,
			        'max'   => 100,
			        'step'  => 1,
			    ),
				'active_callback' 		=> 'lumenwp_cac_has_ld_lesson_bs_layout',
			) ) );

			/**
			 * Mobile Sidebar Order
			 */
			$wp_customize->add_setting( 'lumen_ld_lesson_sidebar_order', array(
				'default'           	=> 'content-sidebar',
				'sanitize_callback' 	=> 'lumenwp_sanitize_select',
			) );

			$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'lumen_ld_lesson_sidebar_order', array(
				'label'	   				=> esc_html__( 'Mobile Sidebar Order', 'lumen' ),
				'type' 					=> 'select',
				'section'  				=> 'lumen_ld_layout',
				'settings' 				=> 'lumen_ld_lesson_sidebar_order',
				'priority' 				=> 10,
				'choices' 				=> array(
					'content-sidebar' 	=> esc_html__( 'Content / Sidebar', 'lumen' ),
					'sidebar-content' 	=> esc_html__( 'Sidebar / Content', 'lumen' ),
				),
				'active_callback' 		=> 'lumenwp_cac_has_ld_lesson_rl_layout',
			) ) );

			/**
			 * Section
			 */
			$wp_customize->add_section( 'lumen_ld_styling' , array(
				'title' 			=> esc_html__( 'Advanced Styling', 'lumen' ),
				'description' 		=> esc_html__( 'For some options, you must save and refresh your live site to preview changes.', 'lumen' ),
				'priority' 			=> 10,
				'panel' 			=> $panel,
			) );

			/**
			 * Course
			 */
			$wp_customize->add_setting( 'lumen_lld_styling_course', array(
				'sanitize_callback' 	=> 'wp_kses',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Heading_Control( $wp_customize, 'lumen_lld_styling_course', array(
				'label'    				=> esc_html__( 'Table', 'lumen' ),
				'section'  				=> 'lumen_ld_styling',
				'priority' 				=> 10,
			) ) );

			/**
		     * Table Heading Color
		     */
	        $wp_customize->add_setting( 'lumen_ld_heading_color', array(
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_ld_heading_color', array(
				'label'					=> esc_html__( 'Heading Color', 'lumen' ),
				'section'				=> 'lumen_ld_styling',
				'settings'				=> 'lumen_ld_heading_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Table Heading Background Color
		     */
	        $wp_customize->add_setting( 'lumen_ld_heading_bg_color', array(
				'default'				=> '',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_ld_heading_bg_color', array(
				'label'					=> esc_html__( 'Heading Background Color', 'lumen' ),
				'section'				=> 'lumen_ld_styling',
				'settings'				=> 'lumen_ld_heading_bg_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Item Color
		     */
	        $wp_customize->add_setting( 'lumen_ld_item_color', array(
				'default'				=> '#333',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_ld_item_color', array(
				'label'					=> esc_html__( 'Item Color', 'lumen' ),
				'section'				=> 'lumen_ld_styling',
				'settings'				=> 'lumen_ld_item_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Item Hover Color
		     */
	        $wp_customize->add_setting( 'lumen_ld_item_hover_color', array(
				'default'				=> '#333',
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_ld_item_hover_color', array(
				'label'					=> esc_html__( 'Item Hover Color', 'lumen' ),
				'section'				=> 'lumen_ld_styling',
				'settings'				=> 'lumen_ld_item_hover_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Complete Color
		     */
	        $wp_customize->add_setting( 'lumen_ld_complete_color', array(
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_ld_complete_color', array(
				'label'					=> esc_html__( 'Complete Color', 'lumen' ),
				'section'				=> 'lumen_ld_styling',
				'settings'				=> 'lumen_ld_complete_color',
				'priority'				=> 10
			) ) );

			/**
		     * Incomplete Color
		     */
	        $wp_customize->add_setting( 'lumen_ld_incomplete_color', array(
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_ld_incomplete_color', array(
				'label'					=> esc_html__( 'Incomplete Color', 'lumen' ),
				'section'				=> 'lumen_ld_styling',
				'settings'				=> 'lumen_ld_incomplete_color',
				'priority'				=> 10,
			) ) );

			/**
		     * Progress Bar Color
		     */
	        $wp_customize->add_setting( 'lumen_ld_progressbar_color', array(
				'transport'				=> 'postMessage',
				'sanitize_callback' 	=> 'lumenwp_sanitize_color',
			) );

			$wp_customize->add_control( new lumenWP_Customizer_Color_Control( $wp_customize, 'lumen_ld_progressbar_color', array(
				'label'					=> esc_html__( 'Progress Bar Color', 'lumen' ),
				'section'				=> 'lumen_ld_styling',
				'settings'				=> 'lumen_ld_progressbar_color',
				'priority'				=> 10,
			) ) );
		}

		/**
		 * Get CSS
		 *
		 * @since 1.0.0
		 */
		public static function head_css( $output ) {
		
			// Course Table
			$heading_color 									= get_theme_mod( 'lumen_ld_heading_color' );
			$heading_bg_color 								= get_theme_mod( 'lumen_ld_heading_bg_color' );
			$item_color 									= get_theme_mod( 'lumen_ld_item_color' );
			$item_hover_color 								= get_theme_mod( 'lumen_ld_item_hover_color' );
			$complete_color 								= get_theme_mod( 'lumen_ld_complete_color' );
			$incomplete_color								= get_theme_mod( 'lumen_ld_incomplete_color' );
			$progressbar_color								= get_theme_mod( 'lumen_ld_progressbar_color' );

			// Both Sidebars - Global
			$ld_global_layout 								= get_theme_mod( 'lumen_ld_global_layout', 'full-width' );
			$bs_global_content_width 						= get_theme_mod( 'lumen_ld_global_both_sidebars_content_width' );
			$bs_global_sidebars_width 						= get_theme_mod( 'lumen_ld_global_both_sidebars_sidebars_width' );

			// Both Sidebars - Course
			$ld_course_layout 								= get_theme_mod( 'lumen_ld_course_layout', 'left-sidebar' );
			$bs_course_content_width 						= get_theme_mod( 'lumen_ld_course_both_sidebars_content_width' );
			$bs_course_sidebars_width 						= get_theme_mod( 'lumen_ld_course_both_sidebars_sidebars_width' );

			// Both Sidebars - Lesson
			$ld_lesson_layout 								= get_theme_mod( 'lumen_ld_lesson_layout', 'left-sidebar' );
			$bs_lesson_content_width 						= get_theme_mod( 'lumen_ld_lesson_both_sidebars_content_width' );
			$bs_lesson_sidebars_width 						= get_theme_mod( 'lumen_ld_lesson_both_sidebars_sidebars_width' );

			// Define css var
			$css = '';

			// Add Heading color
			if ( ! empty( $heading_color ) ) {
				$css .= '#learndash_lessons #lesson_heading, #learndash_profile .learndash_profile_heading, #learndash_quizzes #quiz_heading, #learndash_lesson_topics_list div > strong{color:'. $heading_color .';}';
			}

			// Add Heading Background color
			if ( ! empty( $heading_bg_color ) ) {
				$css .= '#learndash_lessons #lesson_heading, #learndash_profile .learndash_profile_heading, #learndash_quizzes #quiz_heading, #learndash_lesson_topics_list div > strong{background-color:'. $heading_bg_color .';}';
			}

			// Add Item color
			if ( ! empty( $item_color ) ) {
				$css .= '#lessons_list > div h4 a, #course_list > div h4 a, #quiz_list > div h4 a, .learndash_topic_dots a, .learndash_topic_dots a > span, #learndash_lesson_topics_list span a{color:'. $item_color .';}';
			}

			// Add Item Hover color
			if ( ! empty( $item_hover_color ) ) {
				$css .= '#lessons_list > div h4 a:hover, #lessons_list > div h4 a:hover > span, #course_list > div h4 a:hover, #course_list > div h4 a:hover > span, #quiz_list > div h4 a:hover, #quiz_list > div h4 a:hover > span, .learndash_topic_dots a:hover, .learndash_topic_dots a:hover span, #learndash_lesson_topics_list span a:hover{color:'. $item_hover_color .';}';
			}

			// Add Complete Icon color
			if ( ! empty( $complete_color ) ) {
				$css .= '.learndash_navigation_lesson_topics_list .topic-completed span:before, .learndash_navigation_lesson_topics_list ul .topic-completed span:before, .learndash_topic_dots .topic-completed span:before, .learndash_topic_dots ul .topic-completed span:before, .learndash .completed:before, #learndash_profile .completed:before{color:'. $complete_color .';}';
			}

			// Add Incomplete Icon color
			if ( ! empty( $incomplete_color ) ) {
				$css .= '.learndash_navigation_lesson_topics_list .topic-notcompleted span:before, .learndash_navigation_lesson_topics_list ul .topic-notcompleted span:before, .learndash_topic_dots .topic-notcompleted span:before, .learndash_topic_dots ul .topic-notcompleted span:before, .learndash .notcompleted:before, #learndash_profile .notcompleted:before{color:'. $incomplete_color .';}';
			}

			// Add Progress Bar color
			if ( ! empty( $progressbar_color ) ) {
				$css .= 'dd.course_progress div.course_progress_blue{background-color:'. $progressbar_color .';}';
			}

			// LearnDash Both Sidebars - Global
			if ( 'both-sidebars' == $ld_global_layout ) {

				// Both Sidebars layout ld Global page content width
				if ( ! empty( $bs_global_content_width ) ) {
					$css .=
						'@media only screen and (min-width: 960px){
							body.ld-global-layout.content-both-sidebars .content-area {width: '. $bs_global_content_width .'%;}
							body.ld-global-layout.content-both-sidebars.scs-style .widget-area.sidebar-secondary,
							body.ld-global-layout.content-both-sidebars.ssc-style .widget-area {left: -'. $bs_global_content_width .'%;}
						}';
				}

				// Both Sidebars layout ld Global sidebars width
				if ( ! empty( $bs_global_sidebars_width ) ) {
					$css .=
						'@media only screen and (min-width: 960px){
							body.ld-global-layout.content-both-sidebars .widget-area{width:'. $bs_global_sidebars_width .'%;}
							body.ld-global-layout.content-both-sidebars.scs-style .content-area{left:'. $bs_global_sidebars_width .'%;}
							body.ld-global-layout.content-both-sidebars.ssc-style .content-area{left:'. $bs_global_sidebars_width * 2 .'%;}
						}';
				}

			}

			// LearnDash Both Sidebars - Course
			if ( 'both-sidebars' == $ld_course_layout ) {

				// Both Sidebars layout ld Course page content width
				if ( ! empty( $bs_course_content_width ) ) {
					$css .=
						'@media only screen and (min-width: 960px){
							body.single-sfwd-courses.content-both-sidebars .content-area {width: '. $bs_course_content_width .'%;}
							body.single-sfwd-courses.content-both-sidebars.scs-style .widget-area.sidebar-secondary,
							body.single-sfwd-courses.content-both-sidebars.ssc-style .widget-area {left: -'. $bs_course_content_width .'%;}
						}';
				}

				// Both Sidebars layout ld Course sidebars width
				if ( ! empty( $bs_course_sidebars_width ) ) {
					$css .=
						'@media only screen and (min-width: 960px){
							body.single-sfwd-courses.content-both-sidebars .widget-area{width:'. $bs_course_sidebars_width .'%;}
							body.single-sfwd-courses.content-both-sidebars.scs-style .content-area{left:'. $bs_course_sidebars_width .'%;}
							body.single-sfwd-courses.content-both-sidebars.ssc-style .content-area{left:'. $bs_course_sidebars_width * 2 .'%;}
						}';
				}

			}

			// LearnDash Both Sidebars  - Lesson
			if ( 'both-sidebars' == $ld_lesson_layout ) {

				// Both Sidebars layout ld Lesson page content width
				if ( ! empty( $bs_lesson_content_width ) ) {
					$css .=
						'@media only screen and (min-width: 960px){
							body.single-sfwd-lessons.content-both-sidebars .content-area, body.single-sfwd-topic.content-both-sidebars .content-area {width: '. $bs_lesson_content_width .'%;}
							body.single-sfwd-lessons.content-both-sidebars.scs-style .widget-area.sidebar-secondary,
							body.single-sfwd-lessons.content-both-sidebars.ssc-style .widget-area, body.single-sfwd-topic.content-both-sidebars.scs-style .widget-area.sidebar-secondary,
							body.single-sfwd-topic.content-both-sidebars.ssc-style .widget-area {left: -'. $bs_lesson_content_width .'%;}
						}';
				}

				// Both Sidebars layout ld Lesson sidebars width
				if ( ! empty( $bs_lesson_sidebars_width ) ) {
					$css .=
						'@media only screen and (min-width: 960px){
							body.single-sfwd-lessons.content-both-sidebars .widget-area, body.single-sfwd-topic.content-both-sidebars .widget-area{width:'. $bs_lesson_sidebars_width .'%;}
							body.single-sfwd-lessons.content-both-sidebars.scs-style .content-area,
							body.single-sfwd-topic.content-both-sidebars.scs-style .content-area{left:'. $bs_lesson_sidebars_width .'%;}
							body.single-sfwd-lessons.content-both-sidebars.ssc-style .content-area,
							body.single-sfwd-topic.content-both-sidebars.ssc-style .content-area{left:'. $bs_lesson_sidebars_width * 2 .'%;}
						}';
				}

			}

			// Return CSS
			if ( ! empty( $css ) ) {
				$output .= '/* LearnDash CSS */'. $css;
			}

			// Return output css
			return $output;
		}
	}

endif;

return new lumenWP_LearnDash_Customizer();