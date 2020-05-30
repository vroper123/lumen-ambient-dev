<?php
/**
 * Customizer Control: lumen-radio-image.
 *
 * @package     lumen WordPress theme
 * @subpackage  Controls
 * @see   		https://github.com/aristath/kirki
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Radio image control
 */
class LumenWP_Customizer_Radio_Image_Control extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'lumen-radio-image';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		wp_enqueue_script( 'lumen-radio-image',  LumenWP_INC_DIR_URI . 'customizer/assets/min/js/radio-image.min.js', array( 'jquery', 'customize-base' ), false, true );
		wp_localize_script( 'lumen-radio-image', 'oceanwpL10n', $this->l10n() );
		wp_enqueue_style( 'lumen-radio-image',  LumenWP_INC_DIR_URI . 'customizer/assets/min/css/radio-image.min.css', null );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();

		if ( isset( $this->default ) ) {
			$this->json['default'] 	= $this->default;
		} else {
			$this->json['default'] 	= $this->setting->default;
		}
		$this->json['value']       	= $this->value();
		$this->json['choices']     	= $this->choices;
		$this->json['link']        	= $this->get_link();
		$this->json['id']          	= $this->id;
		$this->json['l10n']    		= $this->l10n();

		$this->json['inputAttrs'] = '';
		foreach ( $this->input_attrs as $attr => $value ) {
			$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
		}

	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 */
	protected function content_template() {
		?>
		<# if ( data.label ) { #>
			<span class="customize-control-title">{{{ data.label }}}</span>
		<# } #>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		<div id="input_{{ data.id }}" class="image">
			<# for ( key in data.choices ) { #>
				<input {{{ data.inputAttrs }}} class="image-select" type="radio" value="{{ key }}" name="_customize-radio-{{ data.id }}" id="{{ data.id }}{{ key }}" {{{ data.link }}}<# if ( data.value === key ) { #> checked="checked"<# } #>>
					<label for="{{ data.id }}{{ key }}" title="{{ data.l10n[ key ] }}">
						<img src="{{ data.choices[ key ] }}">
						<span class="image-clickable"></span>
						<span class="radio-label">{{ data.l10n[ key ] }}</span>
					</label>
				</input>
			<# } #>
		</div>
		<?php
	}

	/**
	 * Returns an array of translation strings.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @param string|false $id The string-ID.
	 * @return string
	 */
	protected function l10n( $id = false ) {
		$translation_strings = array(
			'right-sidebar' 	=> esc_attr__( 'Right Sidebar', 'lumen' ),
			'left-sidebar' 		=> esc_attr__( 'Left Sidebar', 'lumen' ),
			'full-width' 		=> esc_attr__( 'Full Width', 'lumen' ),
			'full-screen' 		=> esc_attr__( '100% Full Width', 'lumen' ),
			'both-sidebars' 	=> esc_attr__( 'Both Sidebars', 'lumen' ),
		);
		if ( false === $id ) {
			return $translation_strings;
		}
		return $translation_strings[ $id ];
	}
}
