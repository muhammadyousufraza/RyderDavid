<?php

namespace PrimeSliderPro\Modules\Reveal\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Repeater;
use PrimeSliderPro\Utils;

use PrimeSlider\Traits\Global_Widget_Controls;

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

class Reveal extends Widget_Base {

	use Global_Widget_Controls;

	public function get_name() {
		return 'prime-slider-reveal';
	}

	public function get_title() {
		return BDTPS . esc_html__( 'Reveal', 'bdthemes-prime-slider' );
	}

	public function get_icon() {
		return 'bdt-widget-icon ps-wi-reveal';
	}

	public function get_categories() {
		return [ 'prime-slider-pro' ];
	}

	public function get_keywords() {
		return [ 'prime slider', 'slider', 'reveal', 'prime' ];
	}

	public function get_style_depends() {
		return [ 'prime-slider-font', 'ps-reveal' ];
	}

	public function get_script_depends() {
		return [ 'gsap', 'ps-reveal' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/pmBWj3tkuO8';
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content_layout',
			[ 
				'label' => esc_html__( 'Layout', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_responsive_control(
			'slider_height',
			[ 
				'label' => esc_html__( 'Height', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'range' => [ 
					'px' => [ 
						'min' => 50,
						'max' => 1080,
					],
					'%' => [ 
						'min' => 10,
						'max' => 100,
					],
					'vh' => [ 
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-reveal-slider .slideshow' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'show_sub_title',
			[ 
				'label' => esc_html__( 'Show Sub Title', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before'
			]
		);

		/**
		 * Show Title Controls
		 */
		$this->register_show_title_controls();

		/**
		 * Show text Controls
		 */
		$this->register_show_text_controls();

		/**
		 * Text Hide On Controls
		 */
		$this->register_text_hide_on_controls();

		/**
		 * Show readmore Controls
		 */
		$this->register_show_readmore_controls();

		$this->add_control(
			'show_imgae_caption',
			[ 
				'label' => esc_html__( 'Show Image Caption', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_head_static_content',
			[ 
				'label' => esc_html__( 'Show Header Content', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		/**
		 * Thumbnail Size Controls
		 */
		$this->register_thumbnail_size_controls();

		//Global background settings Controls
		$this->register_background_settings( '.bdt-reveal-slider .slide__img' );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_sliders',
			[ 
				'label' => esc_html__( 'Slider Items', 'bdthemes-prime-slider' ),
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'tabs_repeater_content' );

		$repeater->start_controls_tab(
			'tab_main_content',
			[ 
				'label' => esc_html__( 'Content', 'bdthemes-prime-slider' ),
			]
		);

		/**
		 * Repeater Title Controls
		 */
		$this->register_repeater_title_controls( $repeater );

		/**
		 * Repeater Sub Title Controls
		 */
		$this->register_repeater_sub_title_controls( $repeater );

		/**
		 * Repeater Button Text & Link Controls
		 */
		$this->register_repeater_button_text_link_controls( $repeater );

		/**
		 * Repeater Image Controls
		 */
		$this->register_repeater_image_controls( $repeater );

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'tab_optional_content',
			[ 
				'label' => esc_html__( 'Optional', 'bdthemes-prime-slider' ),
			]
		);

		/**
		 * Repeater Title Link Controls
		 */
		$this->register_repeater_title_link_controls( $repeater );

		$repeater->add_control(
			'image_caption',
			[ 
				'label' => esc_html__( 'Image Caption', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
			]
		);

		/**
		 * Repeater Text Controls
		 */
		$this->register_repeater_text_controls( $repeater );

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'slides',
			[ 
				'label' => esc_html__( 'Items', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [ 
					[ 
						'sub_title' => esc_html__( 'by Kary Leo', 'bdthemes-prime-slider' ),
						'title' => esc_html__( 'Pastiche', 'bdthemes-prime-slider' ),
						'image' => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-1.svg' ],
						'image_caption' => esc_html__( 'Caption 1', 'bdthemes-prime-slider' ),
					],
					[ 
						'sub_title' => esc_html__( 'by Marin Qa', 'bdthemes-prime-slider' ),
						'title' => esc_html__( 'Enfilade', 'bdthemes-prime-slider' ),
						'image' => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-4.svg' ],
						'image_caption' => esc_html__( 'Caption 2', 'bdthemes-prime-slider' ),
					],
					[ 
						'sub_title' => esc_html__( 'by John Zoe', 'bdthemes-prime-slider' ),
						'title' => esc_html__( 'Vernacu', 'bdthemes-prime-slider' ),
						'image' => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-5.svg' ],
						'image_caption' => esc_html__( 'Caption 3', 'bdthemes-prime-slider' ),
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_head_static_content',
			[ 
				'label' => esc_html__( 'Header Content', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_head_static_content' => 'yes',
				],
			]
		);

		$this->add_control(
			'head_static_content_title',
			[ 
				'label' => __( 'Title', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [ 
					'active' => true,
				],
				'default' => __( 'Architect', 'bdthemes-prime-slider' ),
				'placeholder' => __( 'Enter your title', 'bdthemes-prime-slider' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'head_static_content_text',
			[ 
				'label' => __( 'Description', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::WYSIWYG,
				'dynamic' => [ 
					'active' => true,
				],
				'default' => __( 'It is not the beauty of a building you should look at, it s the construction of the foundation that will stand the test of time.', 'bdthemes-prime-slider' ),
				'placeholder' => __( 'Enter your description', 'bdthemes-prime-slider' ),
				'rows' => 10,
			]
		);

		$this->end_controls_section();

		//style
		//style
		$this->start_controls_section(
			'section_style_layout',
			[ 
				'label' => __( 'Sliders', 'bdthemes-prime-slider' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'overlay_type',
			[ 
				'label' => esc_html__( 'Overlay', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'background',
				'options' => [ 
					'none' => esc_html__( 'None', 'bdthemes-prime-slider' ),
					'background' => esc_html__( 'Background', 'bdthemes-prime-slider' ),
					'blend' => esc_html__( 'Blend', 'bdthemes-prime-slider' ),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name' => 'overlay_color',
				'label' => esc_html__( 'Background', 'bdthemes-prime-slider' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .bdt-reveal-slider .slide--current .slide__img::after',
				'fields_options' => [ 
					'background' => [ 
						'default' => 'classic',
					],
					'color' => [ 
						'default' => 'rgba(3, 4, 16, 0.3)',
					],
				],
				'condition' => [ 
					'overlay_type' => [ 'background', 'blend' ],
				],
			]
		);

		$this->add_control(
			'blend_type',
			[ 
				'label' => esc_html__( 'Blend Type', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'multiply',
				'options' => prime_slider_blend_options(),
				'condition' => [ 
					'overlay_type' => 'blend',
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-reveal-slider .slide--current .slide__img::after' => 'mix-blend-mode: {{VALUE}};'
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[ 
				'label' => __( 'Padding', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-reveal-slider .slide--current .bdt-slide-content-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'content_margin',
			[ 
				'label' => __( 'Margin', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-reveal-slider .slide--current .bdt-slide-content-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[ 
				'label' => __( 'Title', 'bdthemes-prime-slider' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_color',
			[ 
				'label' => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-reveal-slider .slide--current .slide__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name' => 'title_background',
				'selector' => '{{WRAPPER}} .bdt-reveal-slider .slide--current .slide__title .slide__box',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name' => 'title_border',
				'label' => esc_html__( 'Border', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-reveal-slider .slide--current .slide__title',
			]
		);

		$this->add_responsive_control(
			'title_radius',
			[ 
				'label' => esc_html__( 'Border Radius', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-reveal-slider .slide--current .slide__title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[ 
				'label' => esc_html__( 'Padding', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-reveal-slider .slide--current .slide__title ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[ 
				'label' => esc_html__( 'Margin', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-reveal-slider .slide--current .slide__title ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .bdt-reveal-slider .slide--current .slide__title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[ 
				'name' => 'title_text_stroke',
				'selector' => '{{WRAPPER}} .bdt-reveal-slider .slide--current .slide__title',
			]
		);

		$this->add_responsive_control(
			'title_width',
			[ 
				'label' => esc_html__( 'Width', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range' => [ 
					'px' => [ 
						'min' => 50,
						'max' => 1080,
					],
					'%' => [ 
						'min' => 10,
						'max' => 100,
					],
					'vw' => [ 
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-reveal-slider .slide__title' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_sub_title',
			[ 
				'label' => __( 'Sub Title', 'bdthemes-prime-slider' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_sub_title' => 'yes'
				],
			]
		);

		$this->add_control(
			'sub_title_color',
			[ 
				'label' => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-reveal-slider .slide__subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name' => 'sub_title_background',
				'selector' => '{{WRAPPER}} .bdt-reveal-slider .slide__subtitle .slide__box',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name' => 'sub_title_border',
				'label' => esc_html__( 'Border', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-reveal-slider .slide__subtitle',
			]
		);

		$this->add_responsive_control(
			'sub_title_radius',
			[ 
				'label' => esc_html__( 'Border Radius', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-reveal-slider .slide__subtitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'sub_title_padding',
			[ 
				'label' => esc_html__( 'Padding', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-reveal-slider .slide__subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'sub_title_margin',
			[ 
				'label' => esc_html__( 'Margin', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-reveal-slider .slide__subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name' => 'sub_title_typography',
				'selector' => '{{WRAPPER}} .bdt-reveal-slider .slide__subtitle',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[ 
				'name' => 'sub_title_text_stroke',
				'selector' => '{{WRAPPER}} .bdt-reveal-slider .slide__subtitle',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_text',
			[ 
				'label' => __( 'Text', 'bdthemes-prime-slider' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_text' => 'yes'
				],
			]
		);

		$this->add_control(
			'text_color',
			[ 
				'label' => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-reveal-slider .bdt-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_margin',
			[ 
				'label' => esc_html__( 'Margin', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-reveal-slider .bdt-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name' => 'text_typography',
				'selector' => '{{WRAPPER}} .bdt-reveal-slider .bdt-text',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[ 
				'label' => esc_html__( 'Read More', 'bdthemes-prime-slider' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_read_more_button_style' );

		$this->start_controls_tab(
			'tab_read_more_button_normal',
			[ 
				'label' => esc_html__( 'Normal', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'read_more_button_color',
			[ 
				'label' => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-reveal-slider .slide__explore .slide__explore-inner' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name' => 'read_more_button_background',
				'selector' => '{{WRAPPER}} .bdt-reveal-slider .slide__explore .slide__explore-inner',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name' => 'read_more_button_border',
				'label' => esc_html__( 'Border', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-reveal-slider .slide__explore .slide__explore-inner',
			]
		);

		$this->add_responsive_control(
			'read_more_button_radius',
			[ 
				'label' => esc_html__( 'Border Radius', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-reveal-slider .slide__explore .slide__explore-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'read_more_button_padding',
			[ 
				'label' => esc_html__( 'Padding', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-reveal-slider .slide__explore .slide__explore-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name' => 'slide_read_more_typography',
				'selector' => '{{WRAPPER}} .bdt-reveal-slider .slide__explore .slide__explore-inner',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name' => 'read_more_button_shadow',
				'selector' => '{{WRAPPER}} .bdt-reveal-slider .slide__explore .slide__explore-inner',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_read_more_button_hover',
			[ 
				'label' => esc_html__( 'Hover', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'read_more_button_hover_color',
			[ 
				'label' => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-reveal-slider .slide__explore .slide__explore-inner:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name' => 'read_more_button_hover_background',
				'selector' => '{{WRAPPER}} .bdt-reveal-slider .slide__explore .slide__explore-inner:hover',
			]
		);

		$this->add_control(
			'read_more_button_border_hover_color',
			[ 
				'label' => esc_html__( 'Border Color', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-reveal-slider .slide__explore .slide__explore-inner:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [ 
					'read_more_button_border_border!' => ''
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image_caption',
			[ 
				'label' => __( 'Image Caption', 'bdthemes-prime-slider' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_imgae_caption' => 'yes'
				],
			]
		);

		$this->add_control(
			'image_caption_text_color',
			[ 
				'label' => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-reveal-slider .slide__category' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_caption_margin',
			[ 
				'label' => esc_html__( 'Margin', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-reveal-slider .slide__category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name' => 'image_caption_typography',
				'selector' => '{{WRAPPER}} .bdt-reveal-slider .slide__category',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_head-content',
			[ 
				'label' => __( 'Header Content', 'bdthemes-prime-slider' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_head_static_content' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_header_content_style' );

		$this->start_controls_tab(
			'tab_header_title',
			[ 
				'label' => esc_html__( 'Title', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'head_content_title_color',
			[ 
				'label' => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-reveal-slider .reveal-header__title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'head_content_title_margin',
			[ 
				'label' => esc_html__( 'Margin', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-reveal-slider .reveal-header__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name' => 'head_content_title_typography',
				'selector' => '{{WRAPPER}} .bdt-reveal-slider .reveal-header__title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[ 
				'name' => 'head_content_title_text_shadow',
				'label' => __( 'Text Shadow', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-reveal-slider .reveal-header__title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[ 
				'name' => 'head_content_title_text_stroke',
				'selector' => '{{WRAPPER}} .bdt-reveal-slider .reveal-header__title',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_header_text',
			[ 
				'label' => esc_html__( 'Text', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'head_content_text_color',
			[ 
				'label' => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-reveal-slider .info' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'head_content_text_max_width',
			[ 
				'label' => esc_html__( 'Max Width', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 
					'px' => [ 
						'min' => 100,
						'max' => 1200,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-reveal-slider .info' => 'max-width: {{SIZE}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name' => 'head_content_text_typography',
				'selector' => '{{WRAPPER}} .bdt-reveal-slider .info',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_arrows',
			[ 
				'label' => __( 'Arrows', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'arrows_color',
			[ 
				'label' => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-reveal-slider .slide.slide--left i.ps-wi-arrow-left, {{WRAPPER}} .bdt-reveal-slider .slide.slide--right i.ps-wi-arrow-right' => 'color: {{VALUE}};',
				],
			]
		);
		//hover color	
		$this->add_control(
			'arrows_hover_color',
			[ 
				'label' => esc_html__( 'Hover Color', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-reveal-slider .slide.slide--left:hover i.ps-wi-arrow-left, {{WRAPPER}} .bdt-reveal-slider .slide.slide--right:hover i.ps-wi-arrow-right' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_size',
			[ 
				'label' => esc_html__( 'Size', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw', 'em' ],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-reveal-slider .slide.slide--left i.ps-wi-arrow-left, {{WRAPPER}} .bdt-reveal-slider .slide.slide--right i.ps-wi-arrow-right' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render_header() {
		$settings = $this->get_settings_for_display();
		$id = 'bdt-prime-slider-' . $this->get_id();

		// start target
		$targets = [];
		if ( $settings['show_title'] == 'yes' ) {
			$targets[0] = '.bdt-title';
		}
		if ( $settings['show_sub_title'] == 'yes' ) {
			$targets[1] = '.bdt-sub-title';
		}
		if ( $settings['show_text'] == 'yes' ) {
			$targets[2] = '.bdt-text';
		}
		// if($settings['readmore_type'] == 'static'){
		// 	$targets [3]= '.bdt-link-btn';
		// }
		$targets = implode( ', ', $targets );
		// end target


		$this->add_render_attribute(
			[ 
				'ps-reveal' => [ 
					'id' => $id,
					'class' => [ 'bdt-reveal-slider' ],
					'data-settings' => [ 
						wp_json_encode(
							array_filter( [ 
								"id" => '#' . $id,
								'targets' => $targets

							] )
						),
					],
				],
			]
		);

		$this->add_render_attribute( 'prime-slider', 'class', 'bdt-prime-slider' );

		?>
				<div <?php $this->print_render_attribute_string( 'prime-slider' ); ?>>
					<div <?php $this->print_render_attribute_string( 'ps-reveal' ); ?>>
						<?php if ( $settings['show_head_static_content'] ) : ?>
								<div class="content content--fixed">
									<header class="reveal-header">
										<h1 class="reveal-header__title">
											<?php echo esc_html( $settings['head_static_content_title'] ); ?>
										</h1>
										<span class="info">
											<?php echo wp_kses_post( $settings['head_static_content_text'] ); ?>
										</span>
									</header>
								</div>
						<?php endif; ?>

						<div class="slideshow">
							<?php
	}

	public function render_footer() {
		$settings = $this->get_settings_for_display();

		?>
						</div>
					</div>
				</div>

				<?php
	}

	public function render_title( $slide ) {
		$settings = $this->get_settings_for_display();
		if ( '' == $settings['show_title'] ) {
			return;
		}
		?>
				<div class="slide__box"></div>
				<span class="slide__title-inner">
					<?php if ( '' !== $slide['title_link']['url'] ) : ?>
							<a href="<?php echo esc_url( $slide['title_link']['url'] ); ?>">
						<?php endif; ?>
						<?php echo esc_html( $slide['title'] ); ?>
						<?php if ( '' !== $slide['title_link']['url'] ) : ?>
							</a>
					<?php endif; ?>
				</span>
				<?php

	}

	public function render_sub_title( $slide ) {
		$settings = $this->get_settings_for_display();

		if ( '' == $settings['show_sub_title'] ) {
			return;
		}

		?>
				<div class="slide__box"></div>
				<span class="slide__subtitle-inner">
					<?php echo wp_kses( $slide['sub_title'], prime_slider_allow_tags( 'title' ) ); ?>
				</span>
				<?php
	}


	public function render_readmore( $content ) {
		$settings = $this->get_settings_for_display();

		if ( '' == $settings['show_readmore'] ) {
			return;
		}

		$this->add_render_attribute( 'slider-button', 'class', 'bdt-link-btn', true );

		if ( $content['button_link']['url'] ) {
			$this->add_render_attribute( 'slider-button', 'href', $content['button_link']['url'], true );

			if ( $content['button_link']['is_external'] ) {
				$this->add_render_attribute( 'slider-button', 'target', '_blank', true );
			}

			if ( $content['button_link']['nofollow'] ) {
				$this->add_render_attribute( 'slider-button', 'rel', 'nofollow', true );
			}
		} else {
			$this->add_render_attribute( 'slider-button', 'href', '#', true );
		}

		?>
				<?php if ( $content['slide_button_text'] && ( 'yes' == $settings['show_readmore'] ) ) : ?>
						<a <?php $this->print_render_attribute_string( 'slider-button' ); ?>>
							<span class="slide__explore-inner">
								<?php echo wp_kses( $content['slide_button_text'], prime_slider_allow_tags( 'title' ) ); ?>
							</span>
						</a>
				<?php endif;
	}


	public function rendar_item_image( $item, $alt = '' ) {
		$settings = $this->get_settings_for_display();

		$image_src = Group_Control_Image_Size::get_attachment_image_src( $item['image']['id'], 'thumbnail_size', $settings );

		if ( $image_src ) {
			$image_final_src = $image_src;
		} elseif ( $item['image']['url'] ) {
			$image_final_src = $item['image']['url'];
		} else {
			return;
		}
		?>

				<div class="slide__img-wrap">
					<div class="slide__img" style="background-image: url('<?php echo esc_url( $image_final_src ); ?>')"></div>
					<div class="slide__img-reveal"></div>
					<i class="ps-wi-arrow-left"></i>
					<i class="ps-wi-arrow-right"></i>
				</div>
				<?php
	}

	public function render_text( $slide ) {
		$settings = $this->get_settings_for_display();

		if ( '' == $settings['show_text'] ) {
			return;
		}

		$text_hide_on_setup = '';

		if ( ! empty( $settings['text_hide_on'] ) ) {
			foreach ( $settings['text_hide_on'] as $element ) {

				if ( $element == 'desktop' ) {
					$text_hide_on_setup .= ' bdt-desktop';
				}
				if ( $element == 'tablet' ) {
					$text_hide_on_setup .= ' bdt-tablet';
				}
				if ( $element == 'mobile' ) {
					$text_hide_on_setup .= ' bdt-mobile';
				}
			}
		}

		?>
				<?php if ( $slide['text'] && ( 'yes' == $settings['show_text'] ) ) : ?>
						<div class="bdt-text <?php echo esc_attr( $text_hide_on_setup ); ?>">
							<?php echo wp_kses_post( $slide['text'] ); ?>
						</div>
				<?php endif; ?>
			<?php
	}

	public function render_slides_loop() {
		$settings = $this->get_settings_for_display();

		$i = 0;

		foreach ( $settings['slides'] as $slide ) : ?>

		<div class="slide">

			<?php $this->rendar_item_image( $slide, $slide['title'] ); ?>

			<div class="bdt-slide-content-wrap">
				<<?php echo esc_attr( Utils::get_valid_html_tag( $settings['title_html_tag'] ) ); ?> class="slide__title">
					<?php $this->render_title( $slide ); ?>
				</<?php echo esc_attr( Utils::get_valid_html_tag( $settings['title_html_tag'] ) ); ?>>
				<div class="slide__subtitle">
					<?php $this->render_sub_title( $slide ); ?>
				</div>

				<?php $this->render_text( $slide ); ?>
				<div class="slide__explore">
					<?php $this->render_readmore( $slide ); ?>
				</div>
			</div>
			<?php if ( $settings['show_imgae_caption'] == 'yes' && ! empty( $slide['image_caption'] ) ) : ?>
					<div class="slide__side">
						<h5 class="slide__category">
							<?php echo esc_html( $slide['image_caption'] ); ?>
						</h5>
					</div>
			<?php endif; ?>

		</div>

		<?php

		$i++;

		endforeach;
	}

	public function render() {
		$this->render_header();
		$this->render_slides_loop();
		$this->render_footer();
	}
}
