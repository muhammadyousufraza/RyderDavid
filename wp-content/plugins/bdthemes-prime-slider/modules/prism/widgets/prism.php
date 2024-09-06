<?php

namespace PrimeSliderPro\Modules\Prism\Widgets;

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

class Prism extends Widget_Base {

	use Global_Widget_Controls;

	public function get_name() {
		return 'prime-slider-prism';
	}

	public function get_title() {
		return BDTPS . esc_html__( 'Prism', 'bdthemes-prime-slider' );
	}

	public function get_icon() {
		return 'bdt-widget-icon ps-wi-prism';
	}

	public function get_categories() {
		return [ 'prime-slider-pro' ];
	}

	public function get_keywords() {
		return [ 'prime slider', 'slider', 'prism', 'prime' ];
	}

	public function get_style_depends() {
		return [ 'prime-slider-font', 'ps-prism' ];
	}

	public function get_script_depends() {
		return [ 'gsap', 'ps-prism' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/kqx65jzUi6s?si=7ss9GTUlKG0J6Nng';
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
				'label'      => esc_html__( 'Height', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'range'      => [ 
					'px' => [ 
						'min' => 50,
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
					'{{WRAPPER}}' => '--bdt-prism-slider-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		/**
		 * Show Title Controls
		 */
		$this->register_show_title_controls();

		$this->add_control(
			'show_count',
			[ 
				'label'     => esc_html__( 'Show Count', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'show_preview_title',
			[ 
				'label'     => esc_html__( 'Show Preview Title', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'preview_title_html_tag',
			[ 
				'label'     => __( 'Title HTML Tag', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'div',
				'options'   => prime_slider_title_tags(),
				'condition' => [ 
					'show_preview_title' => 'yes'
				]
			]
		);


		$this->add_control(
			'show_text',
			[ 
				'label'   => esc_html__( 'Show Preview Text', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_sliders',
			[ 
				'label' => esc_html__( 'Sliders', 'bdthemes-prime-slider' ),
			]
		);

		$repeater = new Repeater();

		/**
		 * Repeater Title Controls
		 */
		$this->register_repeater_title_controls( $repeater );

		/**
		 * Repeater Title Link Controls
		 */
		$this->register_repeater_title_link_controls( $repeater );

		/**
		 * Repeater Text Controls
		 */
		$this->register_repeater_text_controls( $repeater );

		/**
		 * Repeater Image Controls
		 */
		$this->register_repeater_image_controls( $repeater );

		$this->add_control(
			'slides',
			[ 
				'label'       => esc_html__( 'Slider Items', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [ 
					[ 
						'sub_title'     => esc_html__( 'by Paul Clement', 'bdthemes-prime-slider' ),
						'title'         => esc_html__( 'Item One', 'bdthemes-prime-slider' ),
						'text'          => esc_html__( 'Prime Slider Addons for Elementor is a page builder extension that allows you to build sliders with drag and drop. It lets you create an amazing slider without touching no code at all!', 'bdthemes-prime-slider' ),
						'image'         => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-1.svg' ],
						'image_caption' => esc_html__( 'Caption 1', 'bdthemes-prime-slider' ),
					],
					[ 
						'sub_title'     => esc_html__( 'by Martin Quartz', 'bdthemes-prime-slider' ),
						'title'         => esc_html__( 'Item Two', 'bdthemes-prime-slider' ),
						'text'          => esc_html__( 'prism slider is a premium plugin for Elementor that helps you to create awesome sliders for your website. It comes with the perfect design and drag & drop builder tools.', 'bdthemes-prime-slider' ),
						'image'         => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-4.svg' ],
						'image_caption' => esc_html__( 'Caption 2', 'bdthemes-prime-slider' ),
					],
					[ 
						'sub_title'     => esc_html__( 'by John Tatin', 'bdthemes-prime-slider' ),
						'title'         => esc_html__( 'Item Three', 'bdthemes-prime-slider' ),
						'text'          => esc_html__( 'The prism Slider is a creative slider that helps you to design a modern website. With the help of this slider, you can create a unique and memorable experience for your users.', 'bdthemes-prime-slider' ),
						'image'         => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-5.svg' ],
						'image_caption' => esc_html__( 'Caption 3', 'bdthemes-prime-slider' ),
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		/**
		 * Thumbnail Size Controls
		 */
		$this->register_thumbnail_size_controls();

		//Global background settings Controls
		$this->register_background_settings( '.bdt-prism-slider .slide__img' );

		$this->end_controls_section();

		//style

		$this->start_controls_section(
			'section_style_slider',
			[ 
				'label' => __( 'Slider', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'slider_background',
				'selector' => '{{WRAPPER}} .bdt-prism-slider',
			]
		);


		$this->start_controls_tabs(
			'main_slider_tabs'
		);

		$this->start_controls_tab(
			'main_slider_image_tab',
			[ 
				'label' => esc_html__( 'Image', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_responsive_control(
			'slide_image_width',
			[ 
				'label'      => esc_html__( 'Width', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'range'      => [ 
					'px' => [ 
						'min' => 50,
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
					'{{WRAPPER}} .bdt-prism-slider .slide__img-wrap' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'slide_image_overlay_background',
				'selector' => '{{WRAPPER}} .bdt-prism-slider .slide__img-wrap::before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'     => 'slide_image_border',
				'label'    => esc_html__( 'Border', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-prism-slider .slide__img-wrap',
			]
		);

		$this->add_responsive_control(
			'slide_image_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prism-slider .slide__img-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'main_slider_count_tab',
			[ 
				'label'     => esc_html__( 'Count', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_count' => 'yes',
				],
			]
		);

		$this->add_control(
			'slide_count_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prism-slider .slide__number' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'slide_count_typography',
				'selector' => '{{WRAPPER}} .bdt-prism-slider .slide__number',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[ 
				'name'     => 'slide_count_text_shadow',
				'label'    => __( 'Text Shadow', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-prism-slider .slide__number',
			]
		);

		$this->add_responsive_control(
			'slide_count_top_spacing',
			[ 
				'label'     => esc_html__( 'Spacing', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 0,
						'max' => 1200,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prism-slider .slide__number' => 'top: {{SIZE}}px;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'main_slider_title_tab',
			[ 
				'label'     => esc_html__( 'Title', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'slide_title_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prism-slider .slide__title'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-prism-slider .slide__title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'slide_title_typography',
				'selector' => '{{WRAPPER}} .bdt-prism-slider .slide__title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[ 
				'name'     => 'slide_title_text_stroke',
				'label'    => esc_html__( 'Text Stroke', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-prism-slider .slide__title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[ 
				'name'     => 'slide_title_text_shadow',
				'label'    => __( 'Text Shadow', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-prism-slider .slide__title',
			]
		);

		$this->end_controls_tab();


		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_slide_modal',
			[ 
				'label' => __( 'Slide Modal', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,

			]
		);

		$this->start_controls_tabs(
			'slide_modal_tabs'
		);

		$this->start_controls_tab(
			'slide_modal_img_tab',
			[ 
				'label' => esc_html__( 'Img', 'plugin-name' ),
			]
		);

		$this->add_control(
			'overlay_type',
			[ 
				'label'   => esc_html__( 'Overlay', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'background',
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
				'selector'       => '{{WRAPPER}} .bdt-prism-slider .preview__img-wrap::before',
				'fields_options' => [ 
					'background' => [ 
						'default' => 'gradient',
					],
					'color'      => [ 
						'default' => 'rgba(0, 0, 0, 0)',
					],
					'color_b'    => [ 
						'default' => 'rgba(3, 4, 16, 0.3)',
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
					'{{WRAPPER}} .bdt-prism-slider .preview__img-wrap::before' => 'mix-blend-mode: {{VALUE}};'
				],
			]
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'slide_modal_title_tab',
			[ 
				'label'     => esc_html__( 'Title', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_preview_title' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'preview_title_bottom_spacing',
			[ 
				'label'     => esc_html__( 'Bottom Spacing', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 0,
						'max' => 1200,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prism-slider .preview__title' => 'margin-bottom: {{SIZE}}px;',
				],
			]
		);

		$this->add_control(
			'preview_title_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prism-slider .preview__title'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-prism-slider .preview__title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'preview_title_background',
				'selector' => '{{WRAPPER}} .bdt-prism-slider .preview__title',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'     => 'preview_title_border',
				'label'    => esc_html__( 'Border', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-prism-slider .preview__title',
			]
		);

		$this->add_responsive_control(
			'preview_title_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prism-slider .preview__title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'preview_title_padding',
			[ 
				'label'      => esc_html__( 'Padding', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prism-slider .preview__title ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'preview_title_typography',
				'selector' => '{{WRAPPER}} .bdt-prism-slider .preview__title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[ 
				'name'     => 'preview_title_text_stroke',
				'label'    => esc_html__( 'Text Stroke', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-prism-slider .preview__title',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'slide_modal_text_tab',
			[ 
				'label'     => esc_html__( 'Text', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_text' => 'yes'
				],
			]
		);

		$this->add_control(
			'preview_text_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prism-slider .preview__content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'preview_text_max_width',
			[ 
				'label'     => esc_html__( 'Max Width', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 100,
						'max' => 1200,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prism-slider .preview__content' => 'max-width: {{SIZE}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'preview_text_typography',
				'selector' => '{{WRAPPER}} .bdt-prism-slider .preview__content',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'slide_modal_preview_button_tab',
			[ 
				'label' => esc_html__( 'Button', 'plugin-name' ),
			]
		);

		$this->add_control(
			'nav_preview_button_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prism-slider .slidenav__preview' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'nav_preview_button_background',
				'selector' => '{{WRAPPER}} .bdt-prism-slider .slidenav__preview',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'     => 'nav_preview_button_border',
				'label'    => esc_html__( 'Border', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-prism-slider .slidenav__preview',
			]
		);

		$this->add_responsive_control(
			'nav_preview_button_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prism-slider .slidenav__preview' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'nav_preview_button_padding',
			[ 
				'label'      => esc_html__( 'Padding', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prism-slider .slidenav__preview' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'nav_preview_button_font_size',
			[ 
				'label'     => esc_html__( 'Icon Size', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prism-slider .slidenav__preview' => 'font-size: {{SIZE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'nav_preview_button_spacing',
			[ 
				'label'     => esc_html__( 'Spacing', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prism-slider .slidenav__preview' => 'margin-bottom: {{SIZE}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'nav_preview_button_shadow',
				'selector' => '{{WRAPPER}} .bdt-prism-slider .slidenav__preview',
			]
		);

		$this->add_control(
			'slide_modal_preview_button_hover_heading',
			[ 
				'label' => __( 'Hover', 'bdthemes-prime-slider' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'nav_preview_button_hover_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prism-slider .slidenav__preview:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'nav_preview_button_hover_background',
				'selector' => '{{WRAPPER}} .bdt-prism-slider .slidenav__preview:hover',
			]
		);

		$this->add_control(
			'nav_preview_button_border_hover_color',
			[ 
				'label'     => esc_html__( 'Border Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prism-slider .slidenav__preview:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();


		$this->start_controls_section(
			'section_style_slide_navigation',
			[ 
				'label' => __( 'Navigation', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'navigation_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prism-slider .slidenav__item' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'navigation_hover_color',
			[ 
				'label'     => esc_html__( 'Hover Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prism-slider .slidenav__item:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'navigation_margin',
			[ 
				'label'      => esc_html__( 'Margin', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prism-slider .slidenav__item ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'navigation_typography',
				'selector' => '{{WRAPPER}} .bdt-prism-slider .slidenav__item',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[ 
				'name'     => 'navigation_text_shadow',
				'label'    => __( 'Text Shadow', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-prism-slider .slidenav__item',
			]
		);

		$this->end_controls_section();
	}

	protected function render_header() {
		$settings = $this->get_settings_for_display();
		$id       = 'bdt-prism-slider-' . $this->get_id();

		// start target
		$targets = [];
		if ( $settings['show_title'] == 'yes' ) {
			$targets[0] = '.bdt-title';
		}
		if ( $settings['show_text'] == 'yes' ) {
			$targets[2] = '.bdt-text';
		}
		$targets = implode( ', ', $targets );
		// end target

		$this->add_render_attribute(
			[ 
				'ps-prism' => [ 
					'id'            => $id,
					'class'         => [ 'bdt-prism-slider' ],
					'data-settings' => [ 
						wp_json_encode(
							array_filter( [ 
								"id"      => '#' . $id,
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
			<div <?php $this->print_render_attribute_string( 'ps-prism' ); ?>>
				<svg class="hidden">
					<symbol id="icon-caret" viewBox="0 0 24 13">
						<path
							d="M23.646.328a.842.842 0 0 0-1.19 0l-10.459 10.48L1.517.328a.842.842 0 0 0-1.189 1.19L11.382 12.57c.164.164.369.246.595.246.205 0 .43-.082.594-.246L23.625 1.518a.824.824 0 0 0 .02-1.19z" />
					</symbol>
				</svg>
				<main>
					<div class="slideshow">
						<?php
	}

	public function render_footer() {
		$settings = $this->get_settings_for_display();

		?>


						<nav class="slidenav">
							<button class="slidenav__item slidenav__item--prev">
								<?php echo esc_html_x( 'Previous', 'Frontend', 'bdthemes-prime-slider' ) ?>
							</button>
							<button class="slidenav__item slidenav__item--next">
								<?php echo esc_html_x( 'Next', 'Frontend', 'bdthemes-prime-slider' ) ?>
							</button>
							<button class="slidenav__preview">
								<svg class="icon icon--caret">
									<use xlink:href="#icon-caret"></use>
								</svg>
							</button>
						</nav>
					</div>
				</main>
			</div>
		</div>

		<?php
	}

	public function render_preview_title( $slide ) {
		$settings = $this->get_settings_for_display();
		if ( '' == $settings['show_preview_title'] ) {
			return;
		}
		?>
		<?php if ( '' !== $slide['title_link']['url'] ) : ?>
			<a href="<?php echo esc_url( $slide['title_link']['url'] ); ?>">
			<?php endif; ?>
			<?php echo esc_html( $slide['title'] ); ?>
			<?php if ( '' !== $slide['title_link']['url'] ) : ?>
			</a>
		<?php endif; ?>
	<?php

	}

	public function rendar_preview_item_image( $item, $alt = '' ) {
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

		<div class="preview__img-wrap">

			<div class="preview__img" style="background-image: url('<?php echo esc_url( $image_final_src ); ?>')"></div>

			<div class="preview__img-reveal"></div>
		</div>

		<?php
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
		</div>

		<?php
	}

	public function render_slides_loop() {
		$settings = $this->get_settings_for_display();

		$i = 0;

		foreach ( $settings['slides'] as $index => $slide ) :
			$count = $index + 1; ?>

			<div class="slide">

				<div class="preview">
					<?php $this->rendar_preview_item_image( $slide, $slide['title'] ); ?>

					<<?php echo esc_attr(Utils::get_valid_html_tag( $settings['preview_title_html_tag'] )); ?> class="preview__title">
						<?php $this->render_preview_title( $slide ); ?>
					</<?php echo esc_attr(Utils::get_valid_html_tag( $settings['preview_title_html_tag'] )); ?>>

					<?php if ( $slide['text'] && ( 'yes' == $settings['show_text'] ) ) : ?>
						<div class="preview__content">
							<?php echo wp_kses_post( $slide['text'] ); ?>
						</div>
					<?php endif; ?>
				</div>

				<?php $this->rendar_item_image( $slide, $slide['title'] ); ?>

				<?php if ( 'yes' == $settings['show_count'] ) : ?>
					<span class="slide__number">
						<?php echo esc_html(str_pad( $count, 2, '0', STR_PAD_LEFT )); ?>
					</span>
				<?php endif; ?>

				<?php $this->render_title( $slide, 'slide__title', '' ); ?>

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
