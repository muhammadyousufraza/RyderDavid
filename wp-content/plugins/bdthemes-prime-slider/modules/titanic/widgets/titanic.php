<?php
namespace PrimeSliderPro\Modules\Titanic\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Repeater;
use Elementor\Plugin;
use PrimeSliderPro\Utils;

use PrimeSlider\Traits\Global_Widget_Controls;

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

class Titanic extends Widget_Base {

	use Global_Widget_Controls;

	public function get_name() {
		return 'prime-slider-titanic';
	}

	public function get_title() {
		return BDTPS . esc_html__( 'Titanic', 'bdthemes-prime-slider' );
	}

	public function get_icon() {
		return 'bdt-widget-icon ps-wi-titanic bdt-new';
	}

	public function get_categories() {
		return [ 'prime-slider-pro' ];
	}

	public function get_keywords() {
		return [ 'prime slider', 'slider', 'titanic', 'prime' ];
	}

	public function get_style_depends() {
		return [ 'prime-slider-font', 'ps-titanic' ];
	}
	public function get_script_depends() {
		return [ 'shutters', 'gl', 'slicer', 'tinder', 'ps-titanic' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/EITpA2vI9V4?si=wUIJKjMeB0hzseu8';
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content_sliders',
			[ 
				'label' => esc_html__( 'Slider Items', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		/**
		 * Repeater Sub Title Controls
		 */
		$this->register_repeater_sub_title_controls( $repeater );

		/**
		 * Repeater Title Controls
		 */
		$this->register_repeater_title_controls( $repeater );

		/**
		 * Repeater Title Link Controls
		 */
		$this->register_repeater_title_link_controls( $repeater );

		/**
		 * Repeater Image Controls
		 */
		$this->register_repeater_image_controls( $repeater );

		$this->add_control(
			'slides',
			[ 
				'label'       => esc_html__( 'Items', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [ 
					[ 
						'sub_title' => esc_html__( 'Travel', 'bdthemes-prime-slider' ),
						'title'     => esc_html__( 'Jaflong', 'bdthemes-prime-slider' ),
						'image'     => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-1.svg' ]
					],
					[ 
						'sub_title' => esc_html__( 'Travel', 'bdthemes-prime-slider' ),
						'title'     => esc_html__( 'Cox\'s Bazar', 'bdthemes-prime-slider' ),
						'image'     => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-4.svg' ]
					],
					[ 
						'sub_title' => esc_html__( 'Travel', 'bdthemes-prime-slider' ),
						'title'     => esc_html__( 'Sundarban', 'bdthemes-prime-slider' ),
						'image'     => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-5.svg' ]
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_layout',
			[ 
				'label' => esc_html__( 'Additional Settings', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_responsive_control(
			'slider_height',
			[ 
				'label'      => esc_html__( 'Slider Height', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'vh' ],
				'range'      => [ 
					'px' => [ 
						'min' => 200,
						'max' => 1080,
					],
					'%'  => [ 
						'min' => 10,
						'max' => 100,
					],
					'vh' => [ 
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-titanic-thumbs-slide' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		/**
		 * Show Sub Title Controls
		 */
		$this->register_show_sub_title_controls();

		/**
		 * Show Title Controls
		 */
		$this->register_show_title_controls();

		/**
		 * Show Navigation Controls
		 */
		$this->register_show_navigation_controls();

		$this->add_control(
			'show_navigation_fraction',
			[ 
				'label'   => esc_html__( 'Show Fraction', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		/**
		 * Thumbnail Size Controls
		 */
		$this->register_thumbnail_size_controls();

		$this->end_controls_section();


		$this->start_controls_section(
			'section_slider_settings',
			[ 
				'label' => __( 'Slider Settings', 'bdthemes-prime-slider' ),
			]
		);

		/**
		 * Autoplay Controls
		 */
		$this->register_autoplay_controls();

		/**
		 * Grab Cursor Controls
		 */
		$this->register_grab_cursor_controls();

		/**
		 * Loop, Rewind & mousewheel Controls
		 */
		$this->register_loop_rewind_mousewheel_controls();

		/**
		 * Speed & Observer Controls
		 */
		$this->register_speed_observer_controls();

		$this->add_control(
			'swiper_effect',
			[ 
				'label'   => esc_html__( 'Swiper Effect', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'type'    => Controls_Manager::SELECT,
				'default' => 'cards',
				'options' => [ 
					'cards'     => esc_html__( 'Cards', 'bdthemes-prime-slider' ),
					'slide'     => esc_html__( 'Slide', 'bdthemes-prime-slider' ),
					'fade'      => esc_html__( 'Fade', 'bdthemes-prime-slider' ),
					'cube'      => esc_html__( 'Cube', 'bdthemes-prime-slider' ),
					'coverflow' => esc_html__( 'Coverflow', 'bdthemes-prime-slider' ),
					'flip'      => esc_html__( 'Flip', 'bdthemes-prime-slider' ),
					'shutters'  => esc_html__( 'Shutters', 'bdthemes-prime-slider' ),
					'slicer'    => esc_html__( 'Slicer', 'bdthemes-prime-slider' ),
					'tinder'    => esc_html__( 'Tinder', 'bdthemes-prime-slider' ),
					'gl'        => esc_html__( 'GL', 'bdthemes-prime-slider' ),
					'creative'  => esc_html__( 'Creative', 'bdthemes-prime-slider' ),
				],
			]
		);
		//gl_shader control
		$this->add_control(
			'gl_shader',
			[ 
				'label'     => esc_html__( 'GL Shader', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'random',
				'options'   => [ 
					'random'         => esc_html__( 'random', 'bdthemes-prime-slider' ),
					'dots'           => esc_html__( 'dots', 'bdthemes-prime-slider' ),
					'flyeye'         => esc_html__( 'flyeye', 'bdthemes-prime-slider' ),
					'morph-x'        => esc_html__( 'morph-x', 'bdthemes-prime-slider' ),
					'morph-y'        => esc_html__( 'morph-y', 'bdthemes-prime-slider' ),
					'page-curl'      => esc_html__( 'page-curl', 'bdthemes-prime-slider' ),
					'peel-x'         => esc_html__( 'peel-x', 'bdthemes-prime-slider' ),
					'peel-y'         => esc_html__( 'peel-y', 'bdthemes-prime-slider' ),
					'polygons-fall'  => esc_html__( 'polygons-fall', 'bdthemes-prime-slider' ),
					'polygons-morph' => esc_html__( 'polygons-morph', 'bdthemes-prime-slider' ),
					'polygons-wind'  => esc_html__( 'polygons-wind', 'bdthemes-prime-slider' ),
					'pixelize'       => esc_html__( 'pixelize', 'bdthemes-prime-slider' ),
					'ripple'         => esc_html__( 'ripple', 'bdthemes-prime-slider' ),
					'shutters'       => esc_html__( 'shutters', 'bdthemes-prime-slider' ),
					'slices'         => esc_html__( 'slices', 'bdthemes-prime-slider' ),
					'squares'        => esc_html__( 'squares', 'bdthemes-prime-slider' ),
					'stretch'        => esc_html__( 'stretch', 'bdthemes-prime-slider' ),
					'wave-x'         => esc_html__( 'wave-x', 'bdthemes-prime-slider' ),
					'wind'           => esc_html__( 'wind', 'bdthemes-prime-slider' ),
				],
				'condition' => [ 
					'swiper_effect' => 'gl',
				],
			]
		);

		//creative effect control
		$this->add_control(
			'creative_effect',
			[ 
				'label'     => esc_html__( 'Creative Effect', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'creative-1',
				'options'   => [ 
					'creative-1' => esc_html__( 'Creative 1', 'bdthemes-prime-slider' ),
					'creative-2' => esc_html__( 'Creative 2', 'bdthemes-prime-slider' ),
					'creative-3' => esc_html__( 'Creative 3', 'bdthemes-prime-slider' ),
					'creative-4' => esc_html__( 'Creative 4', 'bdthemes-prime-slider' ),
					'creative-5' => esc_html__( 'Creative 5', 'bdthemes-prime-slider' ),
				],
				'condition' => [ 
					'swiper_effect' => 'creative',
				],
			]
		);

		$this->end_controls_section();

		//Style Start
		$this->start_controls_section(
			'section_style_thumb_title',
			[ 
				'label' => esc_html__( 'Slide Image', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'slider_thumbs_height',
			[ 
				'label'      => esc_html__( 'Height', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'vh' ],
				'range'      => [ 
					'px' => [ 
						'min' => 200,
						'max' => 1080,
					],
					'%'  => [ 
						'min' => 10,
						'max' => 100,
					],
					'vh' => [ 
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-titanic-main-slide' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'slider_thumbs_width',
			[ 
				'label'      => esc_html__( 'Width', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'vh' ],
				'range'      => [ 
					'px' => [ 
						'min' => 200,
						'max' => 1080,
					],
					'%'  => [ 
						'min' => 10,
						'max' => 100,
					],
					'vh' => [ 
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-titanic-main-slide' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'      => 'slider_thumbs_border',
				'selector'  => '{{WRAPPER}} .bdt-titanic-main-slide .bdt-titanic-image-wrap img',
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'slider_thumbs_border_radius',
			[ 
				'label'      => __( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-titanic-main-slide .bdt-titanic-image-wrap img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[ 
				'label' => esc_html__( 'Background Image', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'overlay_type',
			[ 
				'label'   => esc_html__( 'Overlay', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [ 
					'none'       => esc_html__( 'None', 'bdthemes-prime-slider' ),
					'background' => esc_html__( 'Background', 'bdthemes-prime-slider' ),
					'blend'      => esc_html__( 'Blend', 'bdthemes-prime-slider' ),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'           => 'overlay_color',
				'label'          => esc_html__( 'Background', 'bdthemes-prime-slider' ),
				'types'          => [ 'classic', 'gradient' ],
				'exclude'        => [ 'image' ],
				'selector'       => '{{WRAPPER}} .bdt-titanic-thumbs-slide .bdt-titanic-image-wrap:before',
				'fields_options' => [ 
					'background' => [ 
						'default' => 'classic',
					],
				],
				'condition'      => [ 
					'overlay_type' => [ 'background', 'blend' ],
				],
			]
		);

		$this->add_control(
			'blend_type',
			[ 
				'label'     => esc_html__( 'Blend Type', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'multiply',
				'options'   => prime_slider_blend_options(),
				'condition' => [ 
					'overlay_type' => 'blend',
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-titanic-thumbs-slide .bdt-titanic-image-wrap:before' => 'mix-blend-mode: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'glassmorphism_effect',
			[ 
				'label'       => esc_html__( 'Glassmorphism', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => sprintf( esc_html__( 'This feature will not work in the Firefox browser untill you enable browser compatibility so please %1s look here %2s', 'bdthemes-prime-slider' ), '<a href="https://developer.mozilla.org/en-US/docs/Web/CSS/backdrop-filter#Browser_compatibility" target="_blank">', '</a>' ),
				'default'     => 'yes',
			]
		);

		$this->add_control(
			'image_backdrop_filter',
			[ 
				'label'     => esc_html__( 'Blur Level', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min'  => 0,
						'step' => 1,
						'max'  => 50,
					]
				],
				'default'   => [ 
					'size' => 15
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-titanic-thumbs-slide .bdt-titanic-image-wrap::before' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);'
				],
				'condition' => [ 
					'glassmorphism_effect' => 'yes',
				]
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[ 
				'label'     => esc_html__( 'Title', 'bdthemes-prime-slider' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_title' => 'yes'
				],
			]
		);

		$this->start_controls_tabs(
			'style_tabs_title'
		);

		$this->start_controls_tab(
			'style_normal_tab_main_title',
			[ 
				'label' => esc_html__( 'Main Title', 'textdomain' ),
			]
		);

		$this->add_control(
			'title_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-titanic-main-title, {{WRAPPER}} .bdt-titanic-main-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_hover_color',
			[ 
				'label'     => esc_html__( 'Hover Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-titanic-main-title:hover, {{WRAPPER}} .bdt-titanic-main-title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'first_word_title_color',
			[ 
				'label'     => esc_html__( 'First Word Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-titanic-main-title .frist-word' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[ 
				'label'      => __( 'Margin', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-titanic-main-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[ 
				'name'           => 'title_text_stroke',
				'selector'       => '{{WRAPPER}} .bdt-titanic-main-title',
				'fields_options' => [ 
					'text_stroke_type' => [ 
						'label' => esc_html__( 'Text Stroke', 'bdthemes-prime-slider' ),
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[ 
				'name'     => 'title_text_shadow',
				'label'    => __( 'Text Shadow', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-titanic-main-title',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-titanic-main-title',
			]
		);

		$this->end_controls_tab();


		$this->start_controls_tab(
			'style_normal_tab_bg_title',
			[ 
				'label' => esc_html__( 'Background Title', 'textdomain' ),
			]
		);

		$this->add_control(
			'background_title_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-titanic-bg-title .bdt-title, {{WRAPPER}} .bdt-titanic-bg-title .bdt-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[ 
				'name'           => 'background_title_text_stroke',
				'selector'       => '{{WRAPPER}} .bdt-titanic-bg-title .bdt-title',
				'fields_options' => [ 
					'text_stroke_type' => [ 
						'label' => esc_html__( 'Text Stroke', 'bdthemes-prime-slider' ),
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[ 
				'name'     => 'background_title_text_shadow',
				'label'    => __( 'Text Shadow', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-titanic-bg-title .bdt-title',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'background_title_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-titanic-bg-title .bdt-title',
			]
		);


		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_sub_title',
			[ 
				'label'     => esc_html__( 'Sub Title', 'bdthemes-prime-slider' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_sub_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'sub_title_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-titanic-sub-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'sub_title_margin',
			[ 
				'label'      => esc_html__( 'Margin', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-titanic-sub-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[ 
				'name'           => 'sub_title_text_stroke',
				'selector'       => '{{WRAPPER}} .bdt-titanic-sub-title',
				'fields_options' => [ 
					'text_stroke_type' => [ 
						'label' => esc_html__( 'Text Stroke', 'bdthemes-prime-slider' ),
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[ 
				'name'     => 'sub_title_text_shadow',
				'label'    => __( 'Text Shadow', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-titanic-sub-title',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'sub_title_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-titanic-sub-title',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[ 
				'label' => __( 'Navigation', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'arrows_heading',
			[ 
				'label'     => __( 'ARROWS', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'nav_arrows_icon',
			[ 
				'label'     => esc_html__( 'Arrows Icon', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '6',
				'options'   => [ 
					'0'        => esc_html__( 'Default', 'bdthemes-prime-slider' ),
					'1'        => esc_html__( 'Style 1', 'bdthemes-prime-slider' ),
					'2'        => esc_html__( 'Style 2', 'bdthemes-prime-slider' ),
					'3'        => esc_html__( 'Style 3', 'bdthemes-prime-slider' ),
					'4'        => esc_html__( 'Style 4', 'bdthemes-prime-slider' ),
					'5'        => esc_html__( 'Style 5', 'bdthemes-prime-slider' ),
					'6'        => esc_html__( 'Style 6', 'bdthemes-prime-slider' ),
					'7'        => esc_html__( 'Style 7', 'bdthemes-prime-slider' ),
					'8'        => esc_html__( 'Style 8', 'bdthemes-prime-slider' ),
					'9'        => esc_html__( 'Style 9', 'bdthemes-prime-slider' ),
					'10'       => esc_html__( 'Style 10', 'bdthemes-prime-slider' ),
					'11'       => esc_html__( 'Style 11', 'bdthemes-prime-slider' ),
					'12'       => esc_html__( 'Style 12', 'bdthemes-prime-slider' ),
					'13'       => esc_html__( 'Style 13', 'bdthemes-prime-slider' ),
					'14'       => esc_html__( 'Style 14', 'bdthemes-prime-slider' ),
					'15'       => esc_html__( 'Style 15', 'bdthemes-prime-slider' ),
					'16'       => esc_html__( 'Style 16', 'bdthemes-prime-slider' ),
					'17'       => esc_html__( 'Style 17', 'bdthemes-prime-slider' ),
					'18'       => esc_html__( 'Style 18', 'bdthemes-prime-slider' ),
					'circle-1' => esc_html__( 'Style 19', 'bdthemes-prime-slider' ),
					'circle-2' => esc_html__( 'Style 20', 'bdthemes-prime-slider' ),
					'circle-3' => esc_html__( 'Style 21', 'bdthemes-prime-slider' ),
					'circle-4' => esc_html__( 'Style 22', 'bdthemes-prime-slider' ),
					'square-1' => esc_html__( 'Style 23', 'bdthemes-prime-slider' ),
				],
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->start_controls_tabs( 'tabs_navigation_arrows_style' );

		$this->start_controls_tab(
			'tabs_nav_arrows_normal',
			[ 
				'label'     => __( 'Normal', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-titanic-nav-btn i' => 'color: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'      => 'arrows_background',
				'label'     => esc_html__( 'Background', 'bdthemes-prime-slider' ),
				'types'     => [ 'classic', 'gradient' ],
				'exclude'   => [ 'image' ],
				'selector'  => '{{WRAPPER}} .bdt-titanic-nav-btn',
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'      => 'nav_arrows_border',
				'selector'  => '{{WRAPPER}} .bdt-titanic-nav-btn',
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'border_radius',
			[ 
				'label'      => __( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-titanic-nav-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_responsive_control(
			'arrows_padding',
			[ 
				'label'      => esc_html__( 'Padding', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-titanic-nav-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_responsive_control(
			'arrows_margin',
			[ 
				'label'      => esc_html__( 'Margin', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-titanic-navigation-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_responsive_control(
			'arrows_size',
			[ 
				'label'     => __( 'Icon Size', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-titanic-nav-btn i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'      => 'arrows_box_shadow',
				'selector'  => '{{WRAPPER}} .bdt-titanic-nav-btn',
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_nav_arrows_hover',
			[ 
				'label'     => __( 'Hover', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-titanic-nav-btn:hover i' => 'color: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'      => 'arrows_hover_background',
				'label'     => esc_html__( 'Background', 'bdthemes-prime-slider' ),
				'types'     => [ 'classic', 'gradient' ],
				'exclude'   => [ 'image' ],
				'selector'  => '{{WRAPPER}} .bdt-titanic-nav-btn::before',
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'nav_arrows_hover_border_color',
			[ 
				'label'     => __( 'Border Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-titanic-nav-btn:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [ 
					'nav_arrows_border_border!' => '',
					'show_navigation_arrows'    => [ 'yes' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'      => 'arrows_hover_box_shadow',
				'selector'  => '{{WRAPPER}} .bdt-titanic-nav-btn:hover',
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'hr_1',
			[ 
				'type'      => Controls_Manager::DIVIDER,
				'condition' => [ 
					'show_navigation_fraction' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'fraction_heading',
			[ 
				'label'     => __( 'FRACTION', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [ 
					'show_navigation_fraction' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'hr_12',
			[ 
				'type'      => Controls_Manager::DIVIDER,
				'condition' => [ 
					'show_navigation_fraction' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'pagination_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-titanic-pagination' => 'color: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_fraction' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'pagination_current_color',
			[ 
				'label'     => __( 'Current Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-titanic-pagination .swiper-pagination-current' => 'color: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_fraction' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'pagination_total_color',
			[ 
				'label'     => __( 'Total Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-titanic-pagination .swiper-pagination-total' => 'color: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_fraction' => [ 'yes' ],
				],
			]
		);

		$this->add_responsive_control(
			'pagination_margin',
			[ 
				'label'      => esc_html__( 'Margin', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-titanic-pagination' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [ 
					'show_navigation_fraction' => [ 'yes' ],
				],
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'      => 'pagination_typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-prime-slider' ),
				'selector'  => '{{WRAPPER}} .bdt-titanic-pagination',
				'condition' => [ 
					'show_navigation_fraction' => [ 'yes' ],
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render_header() {
		$settings = $this->get_settings_for_display();
		$id       = 'bdt-prime-slider-' . $this->get_id();

		$this->add_render_attribute( 'prime-slider-titanic', 'id', $id );
		$this->add_render_attribute( 'prime-slider-titanic', 'class', [ 'bdt-titanic-slider-wrap', 'elementor-swiper' ] );

		$this->add_render_attribute(
			[ 
				'prime-slider-titanic' => [ 
					'data-settings' => [ 
						wp_json_encode( array_filter( [ 
							"autoplay"            => ( "yes" == $settings["autoplay"] ) ? [ "delay" => $settings["autoplay_speed"] ] : false,
							"loop"                => ( $settings["loop"] == "yes" ) ? true : false,
							"rewind"              => ( isset( $settings["rewind"] ) && $settings["rewind"] == "yes" ) ? true : false,
							"speed"               => $settings["speed"]["size"],
							"effect"              => isset( $settings["swiper_effect"] ) ? $settings["swiper_effect"] : 'cards',
							"gl"                  => [ 
								'shader' => isset( $settings["gl_shader"] ) ? $settings["gl_shader"] : 'random',
							],
							"creativeEffect"      => isset( $settings["creative_effect"] ) ? $settings["creative_effect"] : false,
							"fadeEffect"          => [ 'crossFade' => true ],
							"lazy"                => true,
							"parallax"            => true,
							"watchSlidesProgress" => true,
							"slidesPerGroupAuto"  => false,
							"mousewheel"          => ( $settings["mousewheel"] === "yes" ) ? true : false,
							"cardsEffect"         => [ 'slideShadows' => false ],
							"grabCursor"          => ( $settings["grab_cursor"] === "yes" ) ? true : false,
							"pauseOnHover"        => ( "yes" == $settings["pauseonhover"] ) ? true : false,
							"slidesPerView"       => 1,
							"loopedSlides"        => 4,
							"touchRatio"          => 0.2,
							"observer"            => ( $settings["observer"] ) ? true : false,
							"observeParents"      => ( $settings["observer"] ) ? true : false,
							"scrollbar"           => [ 
								"el" => "#" . $id . " .swiper-scrollbar",
							],
							"lazy"                => [ 
								"loadPrevNext" => "true",
							],

							"pagination"          => [ 
								'el'   => "#" . $id . " .bdt-titanic-pagination",
								'type' => "fraction",
							],

							'navigation'          => [ 
								'nextEl' => "#" . $id . " .bdt-titanic-button-next",
								'prevEl' => "#" . $id . " .bdt-titanic-button-prev",
							]

						] ) )
					]
				]
			]
		);

		$swiper_class = Plugin::$instance->experiments->is_feature_active( 'e_swiper_latest' ) ? 'swiper' : 'swiper-container';
		$this->add_render_attribute( 'swiper', 'class', 'bdt-titanic-main-slide ' . $swiper_class );

		?>
		<div <?php $this->print_render_attribute_string( 'prime-slider-titanic' ); ?>>
			<div <?php $this->print_render_attribute_string( 'swiper' ); ?>>
				<div class="swiper-wrapper">

					<?php
	}

	public function render_footer() {
		$settings = $this->get_settings_for_display();
		?>
				</div>

			</div>

			<?php if ( $settings['show_navigation_arrows'] ) : ?>
				<div class="bdt-titanic-navigation-wrap">
					<div class="bdt-titanic-button-next bdt-titanic-nav-btn">
						<i class="ps-wi-arrow-right-<?php echo esc_attr( $settings['nav_arrows_icon'] ); ?>" aria-hidden="true"></i>
					</div>
					<div class="bdt-titanic-button-prev bdt-titanic-nav-btn">
						<i class="ps-wi-arrow-left-<?php echo esc_attr( $settings['nav_arrows_icon'] ); ?>" aria-hidden="true"></i>
					</div>
				</div>
			<?php endif; ?>


			<?php if ( $settings['show_navigation_fraction'] ) : ?>
				<div class="bdt-titanic-pagination"></div>
			<?php endif; ?>

			<div thumbsSlider="" class="bdt-titanic-thumbs-slide">
				<div class="swiper-wrapper">

					<?php foreach ( $settings['slides'] as $slide ) : ?>
						<div class="swiper-slide bdt-titanic-item">
							<?php $this->rendar_thumbs_image( $slide ); ?>

							<?php if ( $slide['title'] && ( 'yes' == $settings['show_title'] ) ) : ?>
								<div class="bdt-titanic-bg-title">
									<<?php echo esc_attr(Utils::get_valid_html_tag( $settings['title_html_tag'] )); ?> class="bdt-title"
										data-swiper-parallax="-100">
										<?php if ( '' !== $slide['title_link']['url'] ) : ?>
											<a href="<?php echo esc_url( $slide['title_link']['url'] ); ?>">
											<?php endif; ?>
											<?php echo prime_slider_first_word( $slide['title'] ); ?>
											<?php if ( '' !== $slide['title_link']['url'] ) : ?>
											</a>
										<?php endif; ?>
									</<?php echo esc_attr(Utils::get_valid_html_tag( $settings['title_html_tag'] )); ?>>
								</div>
							<?php endif; ?>

							<?php $this->render_sub_title( $slide ); ?>

							<?php if ( $slide['title'] && ( 'yes' == $settings['show_title'] ) ) : ?>
								<<?php echo esc_attr(Utils::get_valid_html_tag( $settings['title_html_tag'] )); ?> class="bdt-titanic-main-title"
									data-swiper-parallax="-150" data-swiper-parallax-duration="900">
									<?php if ( '' !== $slide['title_link']['url'] ) : ?>
										<a href="<?php echo esc_url( $slide['title_link']['url'] ); ?>">
										<?php endif; ?>
										<?php echo prime_slider_first_word( $slide['title'] ); ?>
										<?php if ( '' !== $slide['title_link']['url'] ) : ?>
										</a>
									<?php endif; ?>
								</<?php echo esc_attr(Utils::get_valid_html_tag( $settings['title_html_tag'] )); ?>>

							<?php endif; ?>

						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

		<?php
	}

	public function render_sub_title( $slide ) {
		$settings = $this->get_settings_for_display();

		if ( '' == $settings['show_sub_title'] ) {
			return;
		}

		?>
		<<?php echo esc_attr(Utils::get_valid_html_tag( $settings['sub_title_html_tag'] )); ?> class="bdt-titanic-sub-title"
			data-swiper-parallax="-100" data-swiper-parallax-duration="600">
			<?php echo wp_kses( $slide['sub_title'], prime_slider_allow_tags( 'title' ) ); ?>
		</<?php echo esc_attr(Utils::get_valid_html_tag( $settings['sub_title_html_tag'] )); ?>>
		<?php
	}

	public function rendar_item_image( $item, $alt = '' ) {
		$settings = $this->get_settings_for_display();

		$gl       = $settings['swiper_effect'] == 'gl' ? ' swiper-gl-image' : '';
		$shutters = $settings['swiper_effect'] == 'shutters' ? ' swiper-shutters-image' : '';
		$slicer   = $settings['swiper_effect'] == 'slicer' ? ' swiper-slicer-image' : '';

		$image_src = Group_Control_Image_Size::get_attachment_image_src( $item['image']['id'], 'thumbnail_size', $settings );

		if ( $image_src ) {
			$image_src = $image_src;
		} elseif ( $item['image']['url'] ) {
			$image_src = $item['image']['url'];
		} else {
			return;
		}
		?>

		<div class="bdt-titanic-image-wrap">
			<img class="bdt-titanic-img <?php echo esc_attr( $gl . $shutters . $slicer ); ?>"
				src="<?php echo esc_url( $image_src ); ?>" alt="<?php echo esc_html( $alt ); ?>">
		</div>

		<?php
	}

	public function rendar_thumbs_image( $item, $alt = '' ) {
		$settings = $this->get_settings_for_display();

		$image_src = Group_Control_Image_Size::get_attachment_image_src( $item['image']['id'], 'thumbnail_size', $settings );

		if ( $image_src ) {
			$image_src = $image_src;
		} elseif ( $item['image']['url'] ) {
			$image_src = $item['image']['url'];
		} else {
			return;
		}
		?>

		<div class="bdt-titanic-image-wrap">
			<img class="bdt-titanic-img" src="<?php echo esc_url( $image_src ); ?>" alt="<?php echo esc_html( $alt ); ?>">
		</div>

		<?php
	}

	public function render_slides_loop() {
		$settings = $this->get_settings_for_display();

		foreach ( $settings['slides'] as $slide ) :

			?>
			<div class="bdt-titanic-item swiper-slide">

				<?php $this->rendar_item_image( $slide ); ?>

			</div>

		<?php endforeach;
	}

	public function render() {

		$this->render_header();

		$this->render_slides_loop();

		$this->render_footer();
	}
}