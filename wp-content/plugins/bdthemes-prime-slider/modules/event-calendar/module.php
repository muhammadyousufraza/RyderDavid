<?php
namespace PrimeSliderPro\Modules\EventCalendar;

use PrimeSliderPro\Base\Prime_Slider_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Prime_Slider_Module_Base {

	public function get_name() {
		return 'event-calendar';
	}

	public function get_widgets() {
		$widgets = [
			'Event_Calendar',
		];

		return $widgets;
	}
}
