<?php
namespace PrimeSliderPro\Modules\RemotePagination;

use PrimeSliderPro\Base\Prime_Slider_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Prime_Slider_Module_Base {

	public function get_name() {
		return 'remote-pagination';
	}

	public function get_widgets() {
		$widgets = [
			'Remote_Pagination',
		];

		return $widgets;
	}
}
