<?php
/**
 * Lumen Customizer Class
 *
 * @package LumenWP WordPress theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'lumenWP_Customizer' ) ) :

	/**
	 * The lumen Customizer class
	 */
	class lumenWP_Customizer {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {

			add_action( 'customize_register',					array( $this, 'custom_controls' ) );
			add_action( 'customize_register',					array( $this, 'controls_helpers' ) );
			add_action( 'customize_register',					array( $this, 'customize_register' ), 11 );
			add_action( 'after_setup_theme',					array( $this, 'register_options' ) );
			add_action( 'customize_preview_init', 				array( $this, 'customize_preview_init' ) );
			add_action( 'customize_controls_enqueue_scripts', 	array( $this, 'custom_customize_enqueue' ), 7 );

		}

		/**
		 * Adds custom controls
		 *
		 * @since 1.0.0
		 */
		public function custom_controls( $wp_customize ) {

			// Path
			$dir =  LumenWP_INC_DIR . 'customizer/controls/';

			// Load customize control classes
			require_once( $dir . 'buttonset/class-control-buttonset.php' 					);
			require_once( $dir . 'color/class-control-color.php' 							);		
			require_once( $dir . 'dimensions/class-control-dimensions.php' 					);
			require_once( $dir . 'dropdown-pages/class-control-dropdown-pages.php' 			);
			require_once( $dir . 'heading/class-control-heading.php' 						);
			require_once( $dir . 'icon-select/class-control-icon-select.php' 				);
			require_once( $dir . 'multicheck/class-control-multicheck.php' 					);
			require_once( $dir . 'multiple-select/class-control-multiple-select.php' 		);
			require_once( $dir . 'radio-image/class-control-radio-image.php' 				);
			require_once( $dir . 'range/class-control-range.php' 							);
			require_once( $dir . 'slider/class-control-slider.php' 							);
			require_once( $dir . 'sortable/class-control-sortable.php' 						);
			require_once( $dir . 'text/class-control-text.php' 								);
			require_once( $dir . 'textarea/class-control-textarea.php' 						);
			require_once( $dir . 'typo/class-control-typo.php' 								);
			require_once( $dir . 'typography/class-control-typography.php' 					);

			// Register JS control types
			$wp_customize->register_control_type( 'LumenWP_Customizer_Color_Control' 			);
			$wp_customize->register_control_type( 'LumenWP_Customizer_Dimensions_Control' 		);
			$wp_customize->register_control_type( 'LumenWP_Customizer_Dropdown_Pages' 			);
			$wp_customize->register_control_type( 'LumenWP_Customizer_Heading_Control' 			);
			$wp_customize->register_control_type( 'LumenWP_Customizer_Icon_Select_Control' 		);
			$wp_customize->register_control_type( 'LumenWP_Customize_Multicheck_Control' 		);
			$wp_customize->register_control_type( 'LumenWP_Customize_Multiple_Select_Control' 	);
			$wp_customize->register_control_type( 'LumenWP_Customizer_Range_Control' 			);
			$wp_customize->register_control_type( 'LumenWP_Customizer_Slider_Control' 			);
			$wp_customize->register_control_type( 'LumenWP_Customizer_Radio_Image_Control' 		);
			$wp_customize->register_control_type( 'LumenWP_Customizer_Sortable_Control' 		);
			$wp_customize->register_control_type( 'LumenWP_Customizer_Text_Control' 			);
			$wp_customize->register_control_type( 'LumenWP_Customizer_Textarea_Control' 		);
			$wp_customize->register_control_type( 'LumenWP_Customizer_Typo_Control' 			);
			$wp_customize->register_control_type( 'LumenWP_Customizer_Typography_Control' 		);

			if ( true != apply_filters( 'lumenwp_licence_tab_enable', false ) ) {
				require_once( $dir . 'upsell/class-control-upsell.php' 								);
				$wp_customize->register_section_type( 'lumenWP_Customizer_Upsell_Section_Control' 	);
			}

		}

		/**
		 * Adds customizer helpers
		 *
		 * @since 1.0.0
		 */
		public function controls_helpers() {
			require_once(  LumenWP_INC_DIR .'customizer/customizer-helpers.php' );
			require_once(  LumenWP_INC_DIR .'customizer/sanitization-callbacks.php' );
		}

		/**
		 * Core modules
		 *
		 * @since 1.0.0
		 */
		public static function customize_register( $wp_customize ) {

			// Tweak default controls
			$wp_customize->get_setting( 'blogname' )->transport 		= 'postMessage';
			$wp_customize->get_setting( 'blogdescription' )->transport 	= 'postMessage';

			// Move custom logo setting
			$wp_customize->get_control( 'custom_logo' )->section 		= 'lumen_header_logo';

            if ( ! function_exists( 'owp_fs' ) ) {
                // Add our upsell section
                if ( true != apply_filters( 'lumenwp_licence_tab_enable', false ) ) {

                    // Get link
                    $url = 'https://lumen.org/core-extensions-bundle/';

                    // If affiliate ref
                    $ref_url = '';
                    $aff_ref = apply_filters( 'lumen_affiliate_ref', $ref_url );

                    // Add & is has referal link
                    if ( $aff_ref ) {
                        $if_ref = '&';
                    } else {
                        $if_ref = '?';
                    }

                    // Add source
                    $utm = $if_ref . 'utm_source=customizer&utm_campaign=bundle&utm_medium=wp-dash';

                    $wp_customize->add_section( new lumenWP_Customizer_Upsell_Section_Control( $wp_customize, 'lumenwp_upsell_section', array(
                        'title'    => esc_html__( 'Premium Addons Available', 'lumen' ),
                        'url'      => $url . $aff_ref . $utm,
                        'priority' => 0,
                    ) ) );

                }
            }

		}

		/**
		 * Adds customizer options
		 *
		 * @since 1.0.0
		 */
		public function register_options() {
			
			// Var
			$dir =  LumenWP_INC_DIR .'customizer/settings/';

			// Customizer files array
			$files = array(
				'general',
				'typography',
				'topbar',
				'header',
				'blog',
				'sidebar',
				'footer-widgets',
				'footer-bottom',
			);

			foreach ( $files as $key ) {

				$setting = str_replace( '-', '_', $key );

				// If lumen Extra is activated
				if ( lumen_EXTRA_ACTIVE
					&& class_exists( 'lumen_Extra_Theme_Panel' ) ) {

					if ( lumen_Extra_Theme_Panel::get_setting( 'oe_'. $setting .'_panel' ) ) {
						require_once( $dir . $key .'.php' );
					}

				} else {

					require_once( $dir . $key .'.php' );

				}

			}

			// If WooCommerce is activated
			if ( lumenWP_WOOCOMMERCE_ACTIVE ) {
				require_once( $dir .'woocommerce.php' );
			}

			// Easy Digital Downloads Settings
			if ( lumenWP_EDD_ACTIVE ) {
				require_once( $dir .'edd.php' );
			}

			// If LifterLMS is activated
			if ( lumenWP_LIFTERLMS_ACTIVE ) {
				require_once( $dir .'lifterlms.php' );
			}

			// If LearnDash is activated
			if ( lumenWP_LEARNDASH_ACTIVE ) {
				require_once( $dir .'learndash.php' );
			}

		}

		/**
		 * Loads js file for customizer preview
		 *
		 * @since 1.0.0
		 */
		public function customize_preview_init() {
			wp_enqueue_script( 'lumen-customize-preview',  LumenWP_INC_DIR_URI . 'customizer/assets/js/customize-preview.min.js', array( 'customize-preview' ), lumenWP_THEME_VERSION, true );
		}

		/**
		 * Load scripts for customizer
		 *
		 * @since 1.0.0
		 */
		public function custom_customize_enqueue() {
			wp_enqueue_style( 'font-awesome', LumenWP_THEME_URI .'/assets/fonts/fontawesome/css/all.min.css', false, '5.11.2'  );
			wp_enqueue_style( 'simple-line-icons',  LumenWP_INC_DIR_URI .'customizer/assets/css/customizer-simple-line-icons.min.css', false, '2.4.0' );
			wp_enqueue_style( 'lumen-general',  LumenWP_INC_DIR_URI . 'customizer/assets/min/css/general.min.css' );
			wp_enqueue_script( 'lumen-general',  LumenWP_INC_DIR_URI . 'customizer/assets/min/js/general.min.js', array( 'jquery', 'customize-base' ), false, true );

			if ( is_rtl() ) {
				wp_enqueue_style( 'lumen-controls-rtl',  LumenWP_INC_DIR_URI . 'customizer/assets/min/css/rtl.min.css' );
			}
		}

	}

endif;

return new lumenWP_Customizer();
