<?php
namespace PrimeSliderPro\Modules\Astoria;

use PrimeSliderPro\Base\Prime_Slider_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Prime_Slider_Module_Base {

	public function get_name() {
		return 'astoria';
	}

	public function get_widgets() {
		$widgets = [
			'Astoria',
		];

		return $widgets;
	}
}
