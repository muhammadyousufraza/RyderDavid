<?php

namespace PrimeSliderPro\Modules\Material\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Widget_Base;
use Elementor\Plugin;

use PrimeSlider\Traits\Global_Widget_Controls;
use PrimeSlider\Traits\QueryControls\GroupQuery\Group_Control_Query;
use PrimeSliderPro\Utils;
use WP_Query;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Exit if accessed directly

class Material extends Widget_Base {
	use Group_Control_Query;
	use Global_Widget_Controls;

	public function get_name() {
		return 'prime-slider-material';
	}

	public function get_title() {
		return BDTPS . esc_html__( 'Material', 'bdthemes-prime-slider' );
	}

	public function get_icon() {
		return 'bdt-widget-icon ps-wi-material bdt-new';
	}

	public function get_categories() {
		return [ 'prime-slider-pro' ];
	}

	public function get_keywords() {
		return [ 'prime slider', 'slider', 'material', 'prime', 'blog', 'post', 'news' ];
	}

	public function get_style_depends() {
		return [ 'ps-material', 'prime-slider-font' ];
	}

	public function get_script_depends() {
		return [ 'material', 'ps-material' ];
	}

	// public function get_custom_help_url() {
	// 	return 'https://youtu.be/gdBqzj1jUzs';
	// }

	protected function register_controls() {

		$this->start_controls_section(
			'section_content_layout',
			[ 
				'label' => esc_html__( 'Layout', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_responsive_control(
			'item_gap',
			[ 
				'label' => __( 'Item Gap', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [ 
					'size' => 20,
				],
				'tablet_default' => [ 
					'size' => 20,
				],
				'mobile_default' => [ 
					'size' => 0,
				],
				'range' => [ 
					'px' => [ 
						'min' => 0,
						'max' => 100,
					],
				],
			]
		);

		$this->add_responsive_control(
			'slider_height',
			[ 
				'label' => esc_html__( 'Height', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 
					'px' => [ 
						'min' => 200,
						'max' => 1200,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-material-slider-wrap .bdt-item' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_alignment',
			[ 
				'label' => esc_html__( 'Alignment', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [ 
					'left' => [ 
						'title' => esc_html__( 'Left', 'bdthemes-prime-slider' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [ 
						'title' => esc_html__( 'Center', 'bdthemes-prime-slider' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [ 
						'title' => esc_html__( 'Right', 'bdthemes-prime-slider' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors_dictionary' => [ 
					'left' => 'align-items: flex-start; text-align: left;',
					'center' => 'align-items: center; text-align: center;',
					'right' => 'align-items: flex-end; text-align: right;',
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-material-content' => '{{VALUE}};',
				],
			]
		);

		/**
		 * Primary Thumbnail Controls
		 */
		$this->register_primary_thumbnail_controls();

		/**
		 * Show title & title tags controls
		 */
		$this->register_show_title_and_title_tags_controls();

		/**
		 * Show Category Controls
		 */
		$this->register_show_category_controls();

		/**
		 * Show date & human diff time Controls
		 */
		$this->register_show_date_and_human_diff_time_controls();

		/**
		 * Show author Controls
		 */
		$this->register_show_author_controls();

		$this->add_control(
			'meta_separator',
			[ 
				'label' => __( 'Separator', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::TEXT,
				'default' => '.',
				'label_block' => false,
			]
		);

		//show navigation
		$this->add_control(
			'show_navigation',
			[ 
				'label' => esc_html__( 'Show Navigation', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		//New Query Builder Settings
		$this->start_controls_section(
			'section_post_query_builder',
			[ 
				'label' => __( 'Query', 'bdthemes-prime-slider' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->register_query_builder_controls();
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

		$this->add_responsive_control(
			'slides_to_scroll',
			[ 
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__( 'Slides to Scroll', 'bdthemes-prime-slider' ),
				'default' => 1,
				'tablet_default' => 1,
				'mobile_default' => 1,
				'options' => [ 
					1 => '1',
					2 => '2',
					3 => '3',
					4 => '4',
					5 => '5',
					6 => '6',
				],
			]
		);

		$this->add_control(
			'centered_slides',
			[ 
				'label' => __( 'Center Slide', 'bdthemes-prime-slider' ),
				'description' => __( 'Use even items from Layout > Columns settings for better preview.', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::SWITCHER,
				'prefix_class' => 'bdt-material-center-slides--',
				'render_type' => 'template',
			]
		);

		/**
		 * Free Mode Controls
		 */
		$this->register_free_mode_controls();

		/**
		 * Loop Controls
		 */
		// $this->register_loop_controls();
		$this->add_control(
			'rewind',
			[ 
				'label' => __( 'Rewind', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		/**
		 * Speed & Observer Controls
		 */
		$this->add_control(
			'speed',
			[ 
				'label' => __( 'Animation Speed (ms)', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [ 
					'size' => 300,
				],
				'range' => [ 
					'px' => [ 
						'min' => 100,
						'max' => 5000,
						'step' => 50,
					],
				],
			]
		);

		$this->add_control(
			'observer',
			[ 
				'label' => __( 'Observer', 'bdthemes-prime-slider' ),
				'description' => __( 'When you use carousel in any hidden place (in tabs, accordion etc) keep it yes.', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

		//style
		$this->start_controls_section(
			'section_style_layout',
			[ 
				'label' => __( 'Items', 'bdthemes-prime-slider' ),
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
				'selector' => '{{WRAPPER}} .swiper-material-content:before',
				'fields_options' => [ 
					'background' => [ 
						'default' => 'gradient',
					],
					'color' => [ 
						'default' => 'rgba(0,0,0,0.845)',
					],
					'color_b' => [ 
						'default' => 'rgba(0,0,0,0)',
					],
					'gradient_angle' => [ 
						'default' => [ 
							'unit' => 'deg',
							'size' => 45,
						],
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
					'{{WRAPPER}} .swiper-material-content:before' => 'mix-blend-mode: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'overlay_blur_effect',
			[ 
				'label' => esc_html__( 'Glassmorphism', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::SWITCHER,
				'description' => sprintf( __( 'This feature will not work in the Firefox browser untill you enable browser compatibility so please %1s look here %2s', 'bdthemes-prime-slider' ), '<a href="https://developer.mozilla.org/en-US/docs/Web/CSS/backdrop-filter#Browser_compatibility" target="_blank">', '</a>' ),
				'separator' => 'before'
			]
		);

		$this->add_control(
			'overlay_blur_level',
			[ 
				'label' => __( 'Blur Level', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 
					'px' => [ 
						'min' => 0,
						'step' => 1,
						'max' => 50,
					]
				],
				'default' => [ 
					'size' => 10
				],
				'selectors' => [ 
					'{{WRAPPER}} .swiper-material-content:before' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);'
				],
				'condition' => [ 
					'overlay_blur_effect' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[ 
				'label' => __( 'Padding', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-material-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'item_border_radius',
			[ 
				'label' => esc_html__( 'Border Radius', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-material-slider-wrap .bdt-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; --swiper-material-slide-border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[ 
				'label' => esc_html__( 'Title', 'bdthemes-prime-slider' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_style',
			[ 
				'label' => esc_html__( 'Style', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'underline',
				'options' => [ 
					'underline' => esc_html__( 'Style 1', 'bdthemes-prime-slider' ),
					'middle-underline' => esc_html__( 'Style 2', 'bdthemes-prime-slider' ),
					'overline' => esc_html__( 'Style 3', 'bdthemes-prime-slider' ),
					'middle-overline' => esc_html__( 'Style 4', 'bdthemes-prime-slider' ),
					'style-5' => esc_html__( 'Style 5', 'bdthemes-prime-slider' ),
					'style-6' => esc_html__( 'Style 6', 'bdthemes-prime-slider' ),
				],
			]
		);

		$this->add_control(
			'title_color',
			[ 
				'label' => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-material-slider-wrap .bdt-title a' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_hover_color',
			[ 
				'label' => esc_html__( 'Hover Color', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-material-slider-wrap .bdt-title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[ 
				'label' => esc_html__( 'Margin', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-material-slider-wrap .bdt-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name' => 'title_typography',
				'label' => esc_html__( 'Typography', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-material-slider-wrap .bdt-title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[ 
				'name' => 'title_text_shadow',
				'selector' => '{{WRAPPER}} .bdt-material-slider-wrap .bdt-title a',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[ 
				'name' => 'title_text_stroke',
				'selector' => '{{WRAPPER}} .bdt-material-slider-wrap .bdt-title a',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_category',
			[ 
				'label' => esc_html__( 'Category', 'bdthemes-prime-slider' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_category' => 'yes'
				],
			]
		);

		$this->add_control(
			'overlay_blur_effect_category',
			[ 
				'label' => esc_html__( 'Glassmorphism', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::SWITCHER,
				'description' => sprintf( __( 'This feature will not work in the Firefox browser untill you enable browser compatibility so please %1s look here %2s', 'bdthemes-prime-slider' ), '<a href="https://developer.mozilla.org/en-US/docs/Web/CSS/backdrop-filter#Browser_compatibility" target="_blank">', '</a>' ),
				'default' => 'yes',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'overlay_blur_level_category',
			[ 
				'label' => __( 'Blur Level', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 
					'px' => [ 
						'min' => 0,
						'step' => 1,
						'max' => 50,
					]
				],
				'default' => [ 
					'size' => 10
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-material-slider-wrap .bdt-category a' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);'
				],
				'condition' => [ 
					'overlay_blur_effect_category' => 'yes'
				]
			]
		);

		$this->start_controls_tabs( 'tabs_category_style' );

		$this->start_controls_tab(
			'tab_category_normal',
			[ 
				'label' => esc_html__( 'Normal', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'category_color',
			[ 
				'label' => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-material-slider-wrap .bdt-category a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name' => 'category_background',
				'selector' => '{{WRAPPER}} .bdt-material-slider-wrap .bdt-category a',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name' => 'category_border',
				'selector' => '{{WRAPPER}} .bdt-material-slider-wrap .bdt-category a',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'category_border_radius',
			[ 
				'label' => esc_html__( 'Border Radius', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-material-slider-wrap .bdt-category a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'category_padding',
			[ 
				'label' => esc_html__( 'Padding', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-material-slider-wrap .bdt-category a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'category_margin',
			[ 
				'label' => esc_html__( 'Margin', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-material-slider-wrap .bdt-category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'category_space_between',
			[ 
				'label' => esc_html__( 'Space Between', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 
					'px' => [ 
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-material-slider-wrap .bdt-category a+a' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name' => 'category_shadow',
				'selector' => '{{WRAPPER}} .bdt-material-slider-wrap .bdt-category a',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name' => 'category_typography',
				'label' => esc_html__( 'Typography', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-material-slider-wrap .bdt-category a',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_category_hover',
			[ 
				'label' => esc_html__( 'Hover', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'category_hover_color',
			[ 
				'label' => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-material-slider-wrap .bdt-category a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name' => 'category_hover_background',
				'selector' => '{{WRAPPER}} .bdt-material-slider-wrap .bdt-category a:hover',
			]
		);

		$this->add_control(
			'category_hover_border_color',
			[ 
				'label' => esc_html__( 'Border Color', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [ 
					'category_border_border!' => '',
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-material-slider-wrap .bdt-category a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name' => 'category_hover_shadow',
				'selector' => '{{WRAPPER}} .bdt-material-slider-wrap .bdt-category a:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		//meta style
		$this->start_controls_section(
			'section_style_meta',
			[ 
				'label' => esc_html__( 'Meta', 'bdthemes-prime-slider' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'conditions' => [ 
					'relation' => 'or',
					'terms' => [ 
						[ 
							'name' => 'show_date',
							'operator' => '==',
							'value' => 'yes',
						],
						[ 
							'name' => 'show_author',
							'operator' => '==',
							'value' => 'yes',
						],
					],
				],
			]
		);

		$this->add_control(
			'meta_color',
			[ 
				'label' => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-material-slider-wrap .bdt-meta' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'meta_author_hover_color',
			[ 
				'label' => esc_html__( 'Author Hover Color', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-material-slider-wrap .bdt-meta a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'meta_margin',
			[ 
				'label' => esc_html__( 'Margin', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-material-slider-wrap .bdt-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name' => 'meta_typography',
				'label' => esc_html__( 'Typography', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-material-slider-wrap .bdt-meta',
			]
		);

		$this->end_controls_section();


		//Navigation Css
		$this->start_controls_section(
			'section_style_navigation',
			[ 
				'label' => __( 'Navigation', 'bdthemes-prime-slider' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_navigation' => 'yes'
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[ 
				'label' => __( 'Color', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-material-nav-button .bdt-material-nav-svg-circle-wrap, {{WRAPPER}} .bdt-material-nav-button .bdt-material-nav-svg-line' => 'stroke: {{VALUE}}',
					'{{WRAPPER}} .bdt-material-nav-button .bdt-material-nav-svg-arrow' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'arrows_color_hover',
			[ 
				'label' => __( 'Hover Color', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-material-nav-button:hover .bdt-material-nav-svg-circle-wrap, {{WRAPPER}} .bdt-material-nav-button:hover .bdt-material-nav-svg-line' => 'stroke: {{VALUE}}',
					'{{WRAPPER}} .bdt-material-nav-button:hover .bdt-material-nav-svg-arrow' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_size',
			[ 
				'label' => esc_html__( 'Size', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range' => [ 
					'px' => [ 
						'min' => 10,
						'max' => 100,
						'step' => 1,
					],
					'rem' => [ 
						'min' => 0.1,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-material-slider .bdt-material-nav-button' => 'width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'navigation_offset_toggle',
			[ 
				'label' => __( 'Offset', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __( 'None', 'bdthemes-prime-slider' ),
				'label_on' => __( 'Custom', 'bdthemes-prime-slider' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'navigation_horizontal_offset',
			[ 
				'label' => __( 'Horizontal Offset', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range' => [ 
					'px' => [ 
						'min' => 10,
						'max' => 100,
						'step' => 1,
					],
					'rem' => [ 
						'min' => 0.1,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'condition' => [ 
					'navigation_offset_toggle' => 'yes'
				],
				'render_type' => 'ui',
				'selectors' => [ 
					'{{WRAPPER}} .bdt-material-slider .bdt-material-nav-button-next' => 'right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-material-slider .bdt-material-nav-button-prev' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'navigation_vertical_offset',
			[ 
				'label' => __( 'Vertical Offset', 'bdthemes-prime-slider' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'rem' ],
				'range' => [ 
					'px' => [ 
						'min' => -300,
						'step' => 1,
						'max' => 300,
					],
					'rem' => [ 
						'min' => -10,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'condition' => [ 
					'navigation_offset_toggle' => 'yes'
				],
				'render_type' => 'ui',
				'selectors' => [ 
					'{{WRAPPER}}' => '--ep-material-nav-v-offset: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->end_popover();

		$this->end_controls_section();
	}

	public function query_posts() {
		$settings = $this->get_settings();

		$args = [];

		if ( $settings['posts_limit'] ) {
			$args['posts_per_page'] = $settings['posts_limit'] + 1;
			$args['paged'] = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
		}

		$default = $this->getGroupControlQueryArgs();
		$args = array_merge( $default, $args );

		$query = new WP_Query( $args );

		return $query;
	}

	public function render_image( $post_id, $size ) {
		$placeholder_image_src = Utils::get_placeholder_image_src();
		$image_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size );

		if ( ! $image_src ) {
			printf( '<img src="%1$s" alt="%2$s" class="swiper-slide-bg-image bdt-img swiper-lazy" data-swiper-material-scale="1.25">', esc_url( $placeholder_image_src ), esc_html( get_the_title() ) );
		} else {
			print( wp_get_attachment_image(
				get_post_thumbnail_id(),
				$size,
				false,
				[ 
					'class' => 'swiper-slide-bg-image bdt-img swiper-lazy',
					'alt' => esc_html( get_the_title() ),
					'data-swiper-material-scale' => "1.25"
				]
			) );
		}
	}

	/**
	 * Post Title Here
	 */
	public function render_post_title() {
		$settings = $this->get_settings_for_display();

		if ( ! $this->get_settings( 'show_title' ) ) {
			return;
		}

		printf(
			'<%1$s class="bdt-title">
				<a href="%2$s" title="%3$s" class="title-animation-%4$s">%5$s</a>
			</%1$s>',
			esc_attr( $settings['title_tags'] ),
			esc_url( get_permalink() ),
			esc_attr( get_the_title() ),
			esc_html( $settings['title_style'] ),
			esc_html( get_the_title() )
		);

	}

	public function render_category() {
		if ( ! $this->get_settings( 'show_category' ) ) {
			return;
		}

		?>
				<div class="bdt-category">
					<?php echo get_the_category_list( ' ' ); ?>
				</div>
				<?php
	}

	public function render_author() {
		if ( ! $this->get_settings( 'show_author' ) ) {
			return;
		}

		?>
		<div class="bdt-meta-author bdt-flex bdt-flex-middle">
				<?php echo esc_html_x( 'by ', 'Frontend', 'bdthemes-prime-slider' ); ?>
				<a class="bdt-author" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
					<?php echo esc_attr( get_the_author() ); ?>
				</a>
			</div>
		<?php
	}

	public function render_date() {
		$settings = $this->get_settings_for_display();


		if ( ! $this->get_settings( 'show_date' ) ) {
			return;
		}

		?>
		<div class="bdt-flex bdt-flex-middle">
			<div class="bdt-date">
				<?php if ( $settings['human_diff_time'] == 'yes' ) {
					echo prime_slider_post_time_diff( ( $settings['human_diff_time_short'] == 'yes' ) ? 'short' : '' );
				} else {
					echo get_the_date();
				} ?>
			</div>
			<?php if ( $settings['show_time'] ) : ?>
				<div class="bdt-post-time">
					<i class="ps-wi-clock-o" aria-hidden="true"></i>
					<?php echo get_the_time(); ?>
				</div>
			<?php endif; ?>
		</div>

		<?php
	}

	public function render_meta() {
		$settings = $this->get_settings_for_display();

		if ( ! $this->get_settings( 'show_author' ) && ! $this->get_settings( 'show_date' ) ) {
			return;
		}

		?>
		<div class="bdt-meta bdt-flex bdt-flex-middle">
			<?php $this->render_author(); ?>
			<?php if ( $settings['meta_separator'] ) : ?>
				<div class="bdt-ps-separator"> <?php echo esc_html($settings['meta_separator']); ?> </div>
			<?php endif; ?>
			<?php $this->render_date(); ?>
		</div>
		<?php
	}

	protected function render_header() {
		$settings = $this->get_settings_for_display();
		$id = 'bdt-prime-slider-' . $this->get_id();

		$this->add_render_attribute( 'prime-slider-material', 'id', $id );
		$this->add_render_attribute( 'prime-slider-material', 'class', [ 'bdt-material-slider', 'elementor-swiper' ] );

		$elementor_vp_lg = get_option( 'elementor_viewport_lg' );
		$elementor_vp_md = get_option( 'elementor_viewport_md' );
		$viewport_lg = ! empty( $elementor_vp_lg ) ? $elementor_vp_lg - 1 : 1023;
		$viewport_md = ! empty( $elementor_vp_md ) ? $elementor_vp_md - 1 : 767;

		$this->add_render_attribute(
			[ 
				'prime-slider-material' => [ 
					'data-settings' => [ 
						wp_json_encode( array_filter( [ 
							"autoplay" => ( "yes" == $settings["autoplay"] ) ? [ "delay" => $settings["autoplay_speed"] ] : false,
							"speed" => $settings["speed"]["size"],
							"rewind" => ( isset( $settings["rewind"] ) && $settings["rewind"] == "yes" ) ? true : false,
							"pauseOnHover" => ( "yes" == $settings["pauseonhover"] ) ? true : false,
							"slidesPerView" => 1,
							"slidesPerGroup" => isset( $settings["slides_to_scroll_mobile"] ) ? (int) $settings["slides_to_scroll_mobile"] : 1,
							"spaceBetween" => ! empty( $settings["item_gap_mobile"]["size"] ) ? (int) $settings["item_gap_mobile"]["size"] : 0,
							"centeredSlides" => ( $settings["centered_slides"] === "yes" ) ? true : false,
							"grabCursor" => ( $settings["grab_cursor"] === "yes" ) ? true : false,
							"freeMode" => ( $settings["free_mode"] === "yes" ) ? true : false,
							"effect" => 'material',
							"observer" => ( $settings["observer"] ) ? true : false,
							"observeParents" => ( $settings["observer"] ) ? true : false,
							"breakpoints" => [ 
								(int) $viewport_md => [ 
									"slidesPerView" => 2,
									"slidesPerGroup" => isset( $settings["slides_to_scroll_tablet"] ) ? (int) $settings["slides_to_scroll_tablet"] : 1,
									"spaceBetween" => ! empty( $settings["item_gap_tablet"]["size"] ) ? (int) $settings["item_gap_tablet"]["size"] : 0,
								],
								(int) $viewport_lg => [ 
									"slidesPerView" => 2,
									"slidesPerGroup" => isset( $settings["slides_to_scroll"] ) ? (int) $settings["slides_to_scroll"] : 1,
									"spaceBetween" => ! empty( $settings["item_gap"]["size"] ) ? (int) $settings["item_gap"]["size"] : 0,
								]
							],
							"navigation" => [ 
								"nextEl" => "#" . $id . " .swiper-button-next",
								"prevEl" => "#" . $id . " .swiper-button-prev",
							],
							"lazy" => [ 
								"loadPrevNext" => "true",
							],
						] ) )
					]
				]
			]
		);

		$swiper_class = Plugin::$instance->experiments->is_feature_active( 'e_swiper_latest' ) ? 'swiper' : 'swiper-container';
		$this->add_render_attribute( 'swiper', 'class', 'bdt-material-slider-wrap ' . $swiper_class );

		?>
				<div <?php $this->print_render_attribute_string( 'prime-slider-material' ); ?>>
					<div <?php $this->print_render_attribute_string( 'swiper' ); ?>>
						<div class="swiper-wrapper">
						<?php
	}

	public function render_footer() {
		$settings = $this->get_settings_for_display();
		?>
						</div>
						<?php $this->render_navigation(); ?>
					</div>
				</div>
				<?php
	}

	public function render_navigation() {
		$settings = $this->get_settings_for_display();

		if ( ! $settings['show_navigation'] ) {
			return;
		}

		?>
				<div class="bdt-material-navigation-wrap">
					<div class="bdt-material-nav-button-next bdt-material-nav-button bdt-navigation-next swiper-button-next">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 350 160 90">
						<g class="bdt-material-nav-svg-wrap">
						<g class="bdt-material-nav-svg-circle-wrap">
							<circle cx="42" cy="42" r="40"></circle>
						</g>
						<path class="bdt-material-nav-svg-arrow" d="M.983,6.929,4.447,3.464.983,0,0,.983,2.482,3.464,0,5.946Z">
						</path>
						<path class="bdt-material-nav-svg-line" d="M80,0H0"></path>
						</g>
					</svg>
					</div>
	
					<div class="bdt-material-nav-button-prev bdt-material-nav-button bdt-navigation-prev swiper-button-prev">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 350 160 90">
						<g class="bdt-material-nav-svg-wrap">
						<g class="bdt-material-nav-svg-circle-wrap">
							<circle cx="42" cy="42" r="40"></circle>
						</g>
						<path class="bdt-material-nav-svg-arrow" d="M.983,6.929,4.447,3.464.983,0,0,.983,2.482,3.464,0,5.946Z">
						</path>
						<path class="bdt-material-nav-svg-line" d="M80,0H0"></path>
						</g>
					</svg>
					</div>
				</div>
				<?php
	}

	public function render_slider_item( $post_id, $image_size ) {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'slider-item', 'class', 'bdt-item swiper-slide', true );

		?>
				<div <?php echo $this->get_render_attribute_string( 'slider-item' ); ?>>
					<div class="swiper-material-wrapper">
						<div class="swiper-material-content">
							<?php $this->render_image( $post_id, $image_size ); ?>
							<div class="bdt-material-content swiper-material-animate-opacity">
								<?php $this->render_category(); ?>
								<?php $this->render_post_title(); ?>
								<?php $this->render_meta(); ?>
							</div>
						</div>
					</div>
				</div>
				<?php
	}

	public function render() {
		$settings = $this->get_settings_for_display();

		$wp_query = $this->query_posts();
		if ( ! $wp_query->found_posts ) {
			return;
		}

		?>
				<div class="bdt-prime-slider">
					<?php

					$slide_index = 1;
					$this->render_header();

					while ( $wp_query->have_posts() ) {
						$wp_query->the_post();
						$thumbnail_size = $settings['primary_thumbnail_size'];

						$this->render_slider_item( get_the_ID(), $thumbnail_size );
						$slide_index++;
					}

					$this->render_footer();

					?>

				</div>
				<?php
				wp_reset_postdata();
	}
}
