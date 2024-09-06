<?php
/**
 * Image Selector Control Class.
 *
 * @package RT_TSS
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Image Selector Control Class.
 */
class TSSImageSelectorControl extends \Elementor\Base_Data_Control {
	/**
	 * Set control name.
	 *
	 * @var string
	 */
	public static $controlName = 'tss-image-selector';

	/**
	 * Set control type.
	 */
	public function get_type() {
		return self::$controlName;
	}

	/**
	 * Enqueue control scripts and styles.
	 */
	public function enqueue() {
		$url = TSSPro()->assetsUrl . 'css';

		wp_enqueue_style( 'tss-image-selector', $url . '/image-selector.css', [], '' );
	}

	/**
	 * Set default settings
	 */
	protected function get_default_settings() {
		return [
			'label_block' => true,
			'toggle'      => true,
			'options'     => [],
		];
	}

	/**
	 * Control field markup
	 */
	public function content_template() {
		$control_uid = $this->get_control_uid( '{{ value }}' );
		?>
		<div class="elementor-control-field">
			<label class="elementor-control-title">{{{ data.label }}}</label>
			<# if ( data.description ) { #>
			<div class="elementor-control-field-description tss-description">{{{ data.description }}}</div>
			<# } #>
			<div class="elementor-control-image-selector-wrapper">
				<# _.each( data.options, function( options, value ) { #>
				<input id="<?php echo esc_attr( $control_uid ); ?>" type="radio" name="elementor-image-selector-{{ data.name }}-{{ data._cid }}" value="{{ value }}" data-setting="{{ data.name }}">
				<label class="elementor-image-selector-label tooltip-target" for="<?php echo esc_attr( $control_uid ); ?>" data-tooltip="{{ options.title }}" title="{{ options.title }}">
					<img src="{{ options.url }}" alt="{{ options.title }}">
					<span class="elementor-screen-only">{{{ options.title }}}</span>
				</label>
				<# } ); #>
			</div>
		</div>
		<?php
	}
}
