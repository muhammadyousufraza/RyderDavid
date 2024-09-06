<?php
namespace PrimeSliderPro\Modules\Woohotspot;

use PrimeSliderPro\Base\Prime_Slider_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Prime_Slider_Module_Base {

	public function get_name() {
		return 'woohotspot';
	}

	public function get_widgets() {
		$widgets = [
			'Woohotspot',
		];

		return $widgets;
	}
}
