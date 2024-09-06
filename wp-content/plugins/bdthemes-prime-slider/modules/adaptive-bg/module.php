<?php

namespace PrimeSliderPro\Modules\AdaptiveBg;

use Elementor\Controls_Manager;
use PrimeSliderPro\Base\Prime_Slider_Module_Base;

if (!defined('ABSPATH')) {
	exit;
}

class Module extends Prime_Slider_Module_Base {

	public function __construct() {
		parent::__construct();
		$this->add_actions();
	}

	public function get_name() {
		return 'prime-slider-adaptive-bg';
	}

	public function register_section($element) {
		$element->start_controls_section(
			'section_ps_adaptive_bg_controls',
			[
				'tab'   => Controls_Manager::TAB_ADVANCED,
				'label' => BDTPS_PRO_CP . esc_html__('Adaptive Background', 'bdthemes-prime-slider'),
			]
		);
		$element->end_controls_section();
	}

	public function register_controls($widget, $args) {

		$widget->add_control(
			'ps_widget_abg',
			[
				'label'              => esc_html__('Use Adaptive Background?', 'bdthemes-prime-slider'),
				'description' 		 => esc_html__('This feature is only supported for sliders developed using the Swiper technology. And also make sure images are PNG | JPG', 'bdthemes-prime-slider'),
				'type'               => Controls_Manager::SWITCHER,
				'render_type'        => 'template',
				'return_value'       => 'yes',
				'frontend_available' => true,
			]
		);

		$widget->add_control(
			'ps_widget_abg_parent',
			[
				'label'              => esc_html__('Parent Selector', 'bdthemes-prime-slider'),
				'type'               => Controls_Manager::TEXT,
				'description'        => esc_html__('Use a parent selector to limit the scope of the adaptive background. Example (.select, #select)', 'bdthemes-prime-slider'),
				'frontend_available' => true,
				'condition'          => [
					'ps_widget_abg' => 'yes',
				],
			]
		);
	}

	public function should_script_enqueue($widget) {
		if ('yes' === $widget->get_settings_for_display('ps_widget_abg')) {
			wp_enqueue_script('ps-adaptive-bg', BDTPS_PRO_ASSETS_URL . 'js/adaptive-bg.js', ['jquery', 'swiper'], BDTPS_PRO_VER, true);
		}
	}

	public function enqueue_scripts() {
		wp_enqueue_script('ps-adaptive-bg', BDTPS_PRO_ASSETS_URL . 'js/adaptive-bg.js', ['jquery', 'swiper'], BDTPS_PRO_VER, true);
	}

	protected function add_actions() {

		$widgets = array(
			array(
				'name' 		=> 'prime-slider-pacific',
				'section'	=> 'section_style_modal',
			),
			array(
				'name' 		=> 'prime-slider-mercury',
				'section'	=> 'section_style_navigation',
			),
			array(
				'name' 		=> 'prime-slider-escape',
				'section'	=> 'section_style_navigation',
			),
			array(
				'name' 		=> 'prime-slider-marble',
				'section'	=> 'section_style_navigation',
			),
			array(
				'name' 		=> 'prime-slider-material',
				'section'	=> 'section_style_navigation',
			),
			array(
				'name' 		=> 'prime-slider-monster',
				'section'	=> 'section_style_navigation',
			),
			array(
				'name' 		=> 'prime-slider-mercury',
				'section'	=> 'section_style_navigation',
			),
			array(
				'name' 		=> 'prime-slider-tango',
				'section'	=> 'section_style_navigation',
			),
			array(
				'name' 		=> 'prime-slider-vertex',
				'section'	=> 'section_style_navigation',
			),
		);

		foreach ($widgets as $widget) {
			add_action('elementor/element/' . $widget['name'] . '/' . $widget['section'] . '/after_section_end', [$this, 'register_section']);
			add_action('elementor/element/' . $widget['name'] . '/section_ps_adaptive_bg_controls/before_section_end', [$this, 'register_controls'], 10, 2);
		}

		add_action('elementor/frontend/widget/before_render', [$this, 'should_script_enqueue'], 10, 1);
		add_action('elementor/preview/enqueue_scripts', [$this, 'enqueue_scripts']);
	}
}
