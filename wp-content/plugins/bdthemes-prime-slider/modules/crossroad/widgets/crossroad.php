<?php

namespace PrimeSliderPro\Modules\Crossroad\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;
use PrimeSliderPro\Utils;

use PrimeSlider\Traits\Global_Widget_Controls;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Exit if accessed directly

class Crossroad extends Widget_Base {

	use Global_Widget_Controls;

	public function get_name() {
		return 'prime-slider-crossroad';
	}

	public function get_title() {
		return BDTPS . esc_html__( 'Crossroad', 'bdthemes-prime-slider' );
	}

	public function get_icon() {
		return 'bdt-widget-icon ps-wi-crossroad';
	}

	public function get_categories() {
		return [ 'prime-slider-pro' ];
	}

	public function get_keywords() {
		return [ 'prime slider', 'slider', 'crossroad', 'prime' ];
	}

	public function get_style_depends() {
		return [ 'prime-slider-font', 'ps-crossroad' ];
	}

	public function get_script_depends() {
		return [ 'charming', 'gsap', 'ps-crossroad' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/zXYPK3yER1I';
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content_sliders',
			[ 
				'label' => esc_html__( 'Slider Items', 'bdthemes-prime-slider' ),
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'tabs_slider_content' );

		$repeater->start_controls_tab(
			'tab_slider_items',
			[ 
				'label' => esc_html__( 'Items', 'bdthemes-prime-slider' ),
			]
		);

		/**
		 * Repeater Title Controls
		 */
		$this->register_repeater_title_controls( $repeater );

		$repeater->add_control(
			'meta_text',
			[ 
				'label'       => esc_html__( 'Meta Text', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
			]
		);

		/**
		 * Repeater Image Controls
		 */
		$this->register_repeater_image_controls( $repeater );

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'tab_slider_modal',
			[ 
				'label' => esc_html__( 'Modal', 'bdthemes-prime-slider' ),
			]
		);

		$repeater->add_control(
			'modal_title',
			[ 
				'label'       => esc_html__( 'Title (Optional)', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'modal_meta_text',
			[ 
				'label'       => esc_html__( 'Meta Text (Optional)', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
			]
		);

		/**
		 * Repeater Button Text & Link Controls
		 */
		$this->register_repeater_button_text_link_controls( $repeater );

		/**
		 * Repeater Excerpt Controls
		 */
		$this->register_repeater_excerpt_controls( $repeater );

		$repeater->add_control(
			'modal_image',
			[ 
				'label'   => esc_html__( 'Image (Optional)', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'slides',
			[ 
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [ 
					[ 
						'title'     => esc_html__( 'Kanzu', 'bdthemes-prime-slider' ),
						'meta_text' => esc_html__( 'This is meta text here', 'bdthemes-prime-slider' ),
						'excerpt'   => esc_html__( 'Prime Slider Addons for Elementor is a page builder extension that allows you to build sliders with drag and drop. It lets you create an amazing slider without touching no code at all!', 'bdthemes-prime-slider' ),
						'image'     => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-1.svg' ],
					],
					[ 
						'title'     => esc_html__( 'Juked', 'bdthemes-prime-slider' ),
						'meta_text' => esc_html__( 'This is meta text here', 'bdthemes-prime-slider' ),
						'excerpt'   => esc_html__( 'Crossroad Slider is a modern and creative slider that helps you to design a unique website. Upload your own images, choose from more than 50 animations and create a stunning slider with Elementor.', 'bdthemes-prime-slider' ),
						'image'     => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-4.svg' ],
					],
					[ 
						'title'     => esc_html__( 'Colza', 'bdthemes-prime-slider' ),
						'meta_text' => esc_html__( 'This is meta text here', 'bdthemes-prime-slider' ),
						'excerpt'   => esc_html__( 'Moneky slider is a creative slider that helps you to design a modern website. It has advanced features and many customization options, also it\'s packed with beautiful content blocks.', 'bdthemes-prime-slider' ),
						'image'     => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-5.svg' ],
					],
					[ 
						'title'     => esc_html__( 'Voxey', 'bdthemes-prime-slider' ),
						'meta_text' => esc_html__( 'This is meta text here', 'bdthemes-prime-slider' ),
						'excerpt'   => esc_html__( 'Prime Slider Addons for Elementor - crossroad slider is a creative slider that helps you to design a modern website without any coding knowledge. It\'s unique, responsive and highly customizable.', 'bdthemes-prime-slider' ),
						'image'     => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-6.svg' ],
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_layout',
			[ 
				'label' => esc_html__( 'Slider Settings', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_responsive_control(
			'slider_height',
			[ 
				'label'      => esc_html__( 'Height', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'vh' ],
				'default'    => [ 
					'size' => 80,
					'unit' => 'vh',
				],
				'range'      => [ 
					'vh' => [ 
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors'  => [ 
					'{{WRAPPER}}' => '--ps-crossroad-slider-height: {{SIZE}}vh',
				],
			]
		);

		$this->add_responsive_control(
			'slider_item_gap',
			[ 
				'label'       => esc_html__( 'Item Gap', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'vw' ],
				'default'     => [ 
					'size' => 5,
					'unit' => 'vw',
				],
				'range'       => [ 
					'vw' => [ 
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'   => [ 
					'{{WRAPPER}}' => '--ps-crossroad-column-gap: {{SIZE}}vw;',
				],
				'render_type' => 'template',
			]
		);

		$this->add_responsive_control(
			'content_alignment',
			[ 
				'label'     => esc_html__( 'Alignment', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [ 
					'left'   => [ 
						'title' => esc_html__( 'Left', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [ 
						'title' => esc_html__( 'Center', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [ 
						'title' => esc_html__( 'Right', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-crossroad-slider .grid--slideshow, {{WRAPPER}} .bdt-crossroad-slider .content, {{WRAPPER}} .bdt-crossroad-slider .content__item-copy' => 'text-align: {{VALUE}};',
				],
			]
		);

		/**
		 * Show Title Controls
		 */
		$this->register_show_title_controls();

		$this->add_control(
			'show_meta_text',
			[ 
				'label'     => esc_html__( 'Show Meta Text', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before',
			]
		);

		/**
		 * Show Excerpt Controls
		 */
		$this->register_show_excerpt_controls();

		$this->add_control(
			'show_button',
			[ 
				'label'   => esc_html__( 'Show Button', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_counter',
			[ 
				'label'   => esc_html__( 'Show Number', 'ultimate-post-kit' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		//style
		$this->start_controls_section(
			'section_style_layout',
			[ 
				'label' => __( 'Items', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'slider_background',
				'exclude'  => [ 'image' ],
				'selector' => '{{WRAPPER}} .bdt-crossroad-slider .revealer__inner',
			]
		);

		$this->add_responsive_control(
			'image_rotate',
			[ 
				'label'      => esc_html__( 'Rotate', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'deg' ],
				'default'    => [ 
					'size' => -8,
					'unit' => 'deg',
				],
				'range'      => [ 
					'deg' => [ 
						'min' => -90,
						'max' => 90,
					],
				],
				'selectors'  => [ 
					'{{WRAPPER}}' => '--ps-crossroad-image-rotate: {{SIZE}}deg',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_items_style' );

		$this->start_controls_tab(
			'tab_items_title',
			[ 
				'label'     => esc_html__( 'Title', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-crossroad-slider .grid__item--title' => 'color: {{VALUE}};',
				],
				'condition' => [ 
					'show_title' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'      => 'title_typography',
				'selector'  => '{{WRAPPER}} .bdt-crossroad-slider .grid__item--title',
				'condition' => [ 
					'show_title' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[ 
				'name'      => 'title_text_shadow',
				'label'     => __( 'Text Shadow', 'bdthemes-prime-slider' ),
				'selector'  => '{{WRAPPER}} .bdt-crossroad-slider .grid__item--title',
				'condition' => [ 
					'show_title' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[ 
				'name'      => 'title_text_stroke',
				'selector'  => '{{WRAPPER}} .bdt-crossroad-slider .grid__item--title',
				'condition' => [ 
					'show_title' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'title_rotate',
			[ 
				'label'      => esc_html__( 'Title Rotate', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'deg' ],
				'default'    => [ 
					'size' => 16,
					'unit' => 'deg',
				],
				'range'      => [ 
					'deg' => [ 
						'min' => -90,
						'max' => 90,
					],
				],
				'selectors'  => [ 
					'{{WRAPPER}}' => '--ps-crossroad-title-rotate: {{SIZE}}deg',
				],
				'separator'  => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_items_meta_text',
			[ 
				'label'     => esc_html__( 'Meta', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_meta_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'meta_text_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-crossroad-slider .caption' => 'color: {{VALUE}};',
				],
				'condition' => [ 
					'show_meta_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'meta_text_line_color',
			[ 
				'label'     => esc_html__( 'Line Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-crossroad-slider .caption::before' => 'color: {{VALUE}};',
				],
				'condition' => [ 
					'show_meta_text' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'meta_text_margin',
			[ 
				'label'      => __( 'Margin', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-crossroad-slider .caption' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'      => 'meta_text_typography',
				'selector'  => '{{WRAPPER}} .bdt-crossroad-slider .caption',
				'condition' => [ 
					'show_meta_text' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_items_counter',
			[ 
				'label'     => esc_html__( 'Number', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_counter' => 'yes',
				],
			]
		);

		$this->add_control(
			'number_stroke_color',
			[ 
				'label'     => esc_html__( 'Stroke Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-crossroad-slider .number' => '-webkit-text-stroke-color: {{VALUE}}; text-stroke-color: {{VALUE}};',
				],
				'condition' => [ 
					'show_counter' => 'yes',
				],
			]
		);

		$this->add_control(
			'number_fill_color',
			[ 
				'label'     => esc_html__( 'Fill Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-crossroad-slider .number' => '-webkit-text-fill-color: {{VALUE}}; text-fill-color: {{VALUE}};',
				],
				'condition' => [ 
					'show_counter' => 'yes',
				],
			]
		);

		$this->add_control(
			'number_stroke_width',
			[ 
				'label'     => esc_html__( 'Stroke Width', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-crossroad-slider .number' => '-webkit-text-stroke-width: {{SIZE}}px; text-stroke-width: {{SIZE}}px;',
				],
				'condition' => [ 
					'show_counter' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'number_margin',
			[ 
				'label'      => __( 'Margin', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-crossroad-slider .number' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'condition'  => [ 
					'show_counter' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'      => 'number_typography',
				'selector'  => '{{WRAPPER}} .bdt-crossroad-slider .number',
				'condition' => [ 
					'show_counter' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_items_image',
			[ 
				'label' => esc_html__( 'Image', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [ 
				'name'     => 'image_border',
				'selector' => '{{WRAPPER}} .bdt-crossroad-slider .grid__item .img-wrap',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-crossroad-slider .grid__item .img-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[ 
				'name'     => 'css_filters',
				'selector' => '{{WRAPPER}} .bdt-crossroad-slider .grid__item .img-wrap .img',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[ 
				'name'    => 'thumbnail_size',
				'label'   => esc_html__( 'Item Image Size', 'bdthemes-prime-slider' ),
				'exclude' => [ 'custom' ],
				'default' => 'medium_large',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		//Modal
		$this->start_controls_section(
			'section_style_modal',
			[ 
				'label' => __( 'Modal', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'modal_background',
				'exclude'  => [ 'image' ],
				'selector' => '{{WRAPPER}} .bdt-crossroad-slider .content__item',
			]
		);

		$this->add_responsive_control(
			'header_padding',
			[ 
				'label'      => esc_html__( 'Header Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-crossroad-slider .content__item-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[ 
				'label'      => esc_html__( 'Content Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-crossroad-slider .content__item-copy' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_modal_style' );

		$this->start_controls_tab(
			'tab_modal_title',
			[ 
				'label'     => esc_html__( 'Title', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'modal_title_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-crossroad-slider .content__item-header-title' => 'color: {{VALUE}};',
				],
				'condition' => [ 
					'show_title' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'      => 'modal_title_typography',
				'selector'  => '{{WRAPPER}} .bdt-crossroad-slider .content__item-header-title',
				'condition' => [ 
					'show_title' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[ 
				'name'      => 'modal_title_text_shadow',
				'label'     => __( 'Text Shadow', 'bdthemes-prime-slider' ),
				'selector'  => '{{WRAPPER}} .bdt-crossroad-slider .content__item-header-title',
				'condition' => [ 
					'show_title' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[ 
				'name'      => 'modal_title_text_stroke',
				'selector'  => '{{WRAPPER}} .bdt-crossroad-slider .content__item-header-title',
				'condition' => [ 
					'show_title' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_modal_meta_text',
			[ 
				'label'     => esc_html__( 'Meta', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_meta_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'modal_meta_text_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-crossroad-slider .content__item-header-meta' => 'color: {{VALUE}};',
				],
				'condition' => [ 
					'show_meta_text' => 'yes',
				],
			]
		);

		$this->add_control(
			'modal_meta_text_line_color',
			[ 
				'label'     => esc_html__( 'Line Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-crossroad-slider .content__item-header-meta::before' => 'color: {{VALUE}};',
				],
				'condition' => [ 
					'show_meta_text' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'modal_meta_text_margin',
			[ 
				'label'      => __( 'Margin', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-crossroad-slider .content__item-header-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'      => 'modal_meta_text_typography',
				'selector'  => '{{WRAPPER}} .bdt-crossroad-slider .content__item-header-meta',
				'condition' => [ 
					'show_meta_text' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_modal_text',
			[ 
				'label'     => esc_html__( 'Text', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'text_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-crossroad-slider .content__item-copy-text' => 'color: {{VALUE}};',
				],
				'condition' => [ 
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'text_margin',
			[ 
				'label'      => __( 'Margin', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-crossroad-slider .content__item-copy-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'condition'  => [ 
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'text_max_width',
			[ 
				'label'      => esc_html__( 'Max Width', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [ 
					'px' => [ 
						'min' => 50,
						'max' => 1080,
					],
					'vh' => [ 
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-crossroad-slider .content__item-copy' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'      => 'text_typography',
				'selector'  => '{{WRAPPER}} .bdt-crossroad-slider .content__item-copy-text',
				'condition' => [ 
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_modal_button',
			[ 
				'label'     => esc_html__( 'Button', 'bdthemes-element-pack' ),
				'condition' => [ 
					'show_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_nornal_heading',
			[ 
				'label'     => esc_html__( 'NORMAL', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [ 
					'show_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_text_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-crossroad-slider .content__item-copy-more' => 'color: {{VALUE}};',
				],
				'condition' => [ 
					'show_button' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'      => 'button_background',
				'selector'  => '{{WRAPPER}} .bdt-crossroad-slider .content__item-copy-more',
				'condition' => [ 
					'show_button' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [ 
				'name'        => 'button_border',
				'label'       => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-crossroad-slider .content__item-copy-more',
				'condition'   => [ 
					'show_button' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'button_border_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-crossroad-slider .content__item-copy-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [ 
					'show_button' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'button_text_padding',
			[ 
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-crossroad-slider .content__item-copy-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [ 
					'show_button' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'button_text_margin',
			[ 
				'label'      => esc_html__( 'Margin', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-crossroad-slider .content__item-copy-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [ 
					'show_button' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'      => 'button_box_shadow',
				'selector'  => '{{WRAPPER}} .bdt-crossroad-slider .content__item-copy-more',
				'condition' => [ 
					'show_button' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'      => 'button_typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-element-pack' ),
				'selector'  => '{{WRAPPER}} .bdt-crossroad-slider .content__item-copy-more',
				'condition' => [ 
					'show_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_hover_heading',
			[ 
				'label'     => esc_html__( 'HOVER', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [ 
					'show_button' => 'yes',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_hover_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-crossroad-slider .content__item-copy-more:hover' => 'color: {{VALUE}};',
				],
				'condition' => [ 
					'show_button' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'      => 'button_hover_background',
				'selector'  => '{{WRAPPER}} .bdt-crossroad-slider .content__item-copy-more:hover',
				'condition' => [ 
					'show_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[ 
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 
					'button_border_border!' => '',
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-crossroad-slider .content__item-copy-more:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [ 
					'show_button' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'      => 'button_hover_box_shadow',
				'selector'  => '{{WRAPPER}} .bdt-crossroad-slider .content__item-copy-more:hover',
				'condition' => [ 
					'show_button' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_hover_animation',
			[ 
				'label'     => esc_html__( 'Animation', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HOVER_ANIMATION,
				'condition' => [ 
					'show_button' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_modal_image',
			[ 
				'label' => esc_html__( 'Image', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_responsive_control(
			'slider_image_height',
			[ 
				'label'      => esc_html__( 'Height', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'default'    => [ 
					'unit' => 'px',
				],
				'range'      => [ 
					'px' => [ 
						'min' => 100,
						'max' => 600,
					],
				],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-crossroad-slider .img-wrap--content' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[ 
				'name'     => 'modal_css_filters',
				'selector' => '{{WRAPPER}} .bdt-crossroad-slider .img--content',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[ 
				'name'    => 'modal_thumbnail_size',
				'label'   => esc_html__( 'Modal Image Size', 'bdthemes-prime-slider' ),
				'exclude' => [ 'custom' ],
				'default' => 'full',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		//cursor
		$this->start_controls_section(
			'section_style_cursor',
			[ 
				'label' => __( 'Cursor', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'cursor_color',
			[ 
				'label'        => esc_html__( 'Type', 'bdthemes-prime-slider' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'dark',
				'options'      => [ 
					'dark'  => esc_html__( 'Dark', 'bdthemes-prime-slider' ),
					'white' => esc_html__( 'White', 'bdthemes-prime-slider' ),
				],
				'prefix_class' => 'ps-crossroad-cursor-type--',
				'render_type'  => 'template',
			]
		);

		$this->end_controls_section();

	}

	public function render_title( $slide ) {
		$settings = $this->get_settings_for_display();

		if ( '' == $settings['show_title'] ) {
			return;
		}

		?>
		<<?php echo esc_attr(Utils::get_valid_html_tag( $settings['title_html_tag'] )); ?> class="content__item-header-title">

			<?php if ( ! empty( $slide['modal_title'] ) ) : ?>
				<?php echo esc_html( $slide['modal_title'] ); ?>
			<?php else : ?>
				<?php echo esc_html( $slide['title'] ); ?>
			<?php endif; ?>

		</<?php echo esc_attr(Utils::get_valid_html_tag( $settings['title_html_tag'] )); ?>>

		<?php

	}

	public function render_button( $content ) {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'slider-button', 'class', 'content__item-copy-more elementor-animation-' . $settings['button_hover_animation'], true );

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
		<?php if ( $content['slide_button_text'] && ( 'yes' == $settings['show_button'] ) ) : ?>
			<div class="bdt-btn-wrap">
				<a <?php $this->print_render_attribute_string( 'slider-button' ); ?>>
					<?php echo wp_kses( $content['slide_button_text'], prime_slider_allow_tags( 'title' ) ); ?>
				</a>
			</div>
		<?php endif;
	}

	public function rendar_modal_image( $item, $alt = '' ) {
		$settings = $this->get_settings_for_display();

		$image_src       = Group_Control_Image_Size::get_attachment_image_src( $item['image']['id'], 'modal_thumbnail_size', $settings );
		$modal_image_src = Group_Control_Image_Size::get_attachment_image_src( $item['modal_image']['id'], 'modal_thumbnail_size', $settings );

		if ( $image_src ) {
			$image_final_src = $image_src;
		} elseif ( $item['image']['url'] ) {
			$image_final_src = $item['image']['url'];
		}

		if ( $modal_image_src ) {
			$image_final_src = $modal_image_src;
		}

		?>

		<div class="img img--content" style="background-image: url('<?php echo esc_url( $image_final_src ); ?>')"></div>

		<?php
	}

	public function render_modal_loop() {
		$settings = $this->get_settings_for_display();

		foreach ( $settings['slides'] as $slide ) : ?>

			<article class="content__item">
				<div class="img-wrap img-wrap--content">
					<?php $this->rendar_modal_image( $slide, $slide['title'] ); ?>
				</div>
				<header class="content__item-header">
					<?php if ( $slide['meta_text'] && ( 'yes' == $settings['show_meta_text'] ) ) : ?>
						<span class="content__item-header-meta">
							<?php if ( ! empty( $slide['modal_meta_text'] ) ) : ?>
								<?php echo esc_html( $slide['modal_meta_text'] ); ?>
							<?php else : ?>
								<?php echo wp_kses_post( $slide['meta_text'] ) ?>
							<?php endif; ?>
						</span>
					<?php endif; ?>

					<?php $this->render_title( $slide ); ?>
				</header>
				<div class="content__item-copy">
					<?php if ( $slide['excerpt'] && ( 'yes' == $settings['show_excerpt'] ) ) : ?>
						<div class="content__item-copy-text">
							<?php echo wp_kses_post( $slide['excerpt'] ); ?>
						</div>
					<?php endif; ?>
					<?php $this->render_button( $slide ); ?>
				</div>
			</article>

			<?php
		endforeach;
	}

	public function render_slides_loop() {
		$settings = $this->get_settings_for_display();

		$slide_index = 1;
		foreach ( $settings['slides'] as $slide ) : ?>

			<figure class="grid__item grid__item--slide">
				<?php if ( $settings['show_counter'] == 'yes' ) : ?>
					<span class="number">
						<?php printf( "%02d", esc_html($slide_index) ); ?>
					</span>
				<?php endif; ?>

				<div class="img-wrap">
					<?php $this->rendar_item_image( $slide, 'img' ); ?>
				</div>
				<?php if ( $slide['meta_text'] && ( 'yes' == $settings['show_meta_text'] ) ) : ?>
					<figcaption class="caption">
						<?php echo wp_kses_post( $slide['meta_text'] ) ?>
					</figcaption>
				<?php endif; ?>
			</figure>
			<?php
			$slide_index++;
		endforeach;
	}

	public function render_title_loop() {
		$settings = $this->get_settings_for_display();

		foreach ( $settings['slides'] as $slide ) : ?>

			<<?php echo esc_attr(Utils::get_valid_html_tag( $settings['title_html_tag'] )); ?> class="grid__item grid__item--title">
				<?php if ( $settings['show_title'] ) : ?>
					<?php echo esc_html( $slide['title'] ); ?>
				<?php endif; ?>
			</<?php echo esc_attr(Utils::get_valid_html_tag( $settings['title_html_tag'] )); ?>>

		<?php endforeach;
	}

	public function render() {
		$settings = $this->get_settings_for_display();
		$id       = 'bdt-prime-slider-' . $this->get_id();

		$this->add_render_attribute( 'prime-slider', 'class', 'bdt-prime-slider' );

		$this->add_render_attribute(
			[ 
				'ps-crossroad' => [ 
					'id'            => $id,
					'class'         => [ 'bdt-crossroad-slider' ],
					'data-settings' => [ 
						wp_json_encode( array_filter( [ 
							"id" => '#' . $id,
						] )
						),
					],
				],
			]
		);

		?>
		<div <?php $this->print_render_attribute_string( 'prime-slider' ); ?>>
			<div <?php $this->print_render_attribute_string( 'ps-crossroad' ); ?>>

				<div class="content">
					<?php $this->render_modal_loop(); ?>
				</div>

				<div class="revealer">
					<div class="revealer__inner"></div>
				</div>

				<div class="grid grid--slideshow">
					<?php $this->render_slides_loop(); ?>
					<div class="titles-wrap">
						<div class="grid grid--titles">
							<?php $this->render_title_loop(); ?>
						</div>
					</div>
					<div class="grid grid--interaction">
						<div class="grid__item grid__item--cursor grid__item--left"></div>
						<div class="grid__item grid__item--cursor grid__item--center"></div>
						<div class="grid__item grid__item--cursor grid__item--right"></div>
					</div>
				</div>

			</div>
		</div>
		<?php
	}
}