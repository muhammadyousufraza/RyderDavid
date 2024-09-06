<?php

namespace PrimeSliderPro\Modules\Woostand\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Text_Stroke;
use PrimeSliderPro\Utils;

use PrimeSlider\Traits\Global_Widget_Controls;
use PrimeSlider\Traits\QueryControls\GroupQuery\Group_Control_Query;
use WP_Query;

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

class Woostand extends Widget_Base {
	use Group_Control_Query;
	use Global_Widget_Controls;
	public function get_name() {
		return 'prime-slider-woostand';
	}

	public function get_title() {
		return BDTPS . esc_html__( 'WooStand', 'bdthemes-prime-slider' );
	}

	public function get_icon() {
		return 'bdt-widget-icon ps-wi-woostand';
	}

	public function get_categories() {
		return [ 'prime-slider-pro' ];
	}

	public function get_keywords() {
		return [ 'prime slider', 'slider', 'woocommerce', 'prime', 'wc slider', 'woostand' ];
	}

	public function get_style_depends() {
		return [ 'ps-woostand' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/6Wkk2EMN2ps';
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content_layout',
			[ 
				'label' => esc_html__( 'Layout', 'bdthemes-prime-slider' ),
			]
		);

		/**
		 * Slider Height Controls
		 */
		$this->register_slider_height_controls();

		/**
		 * Thumbnail Size Controls
		 */
		$this->register_thumbnail_size_controls();

		//Global background settings Controls
		$this->register_background_settings( '.bdt-prime-slider .bdt-slideshow-item .bdt-ps-slide-img' );

		/**
		 * Show Title Controls
		 */
		$this->register_show_title_controls();

		/**
		 * Show Category Controls
		 */
		$this->register_show_category_controls();

		/**
		 * Show Price Controls
		 */
		$this->register_show_price_controls();

		/**
		 * Show Cart Controls
		 */
		$this->register_show_cart_controls();

		/**
		 * Show Navigation Controls
		 */
		$this->register_show_navigation_controls();

		/**
		 * Show Pagination Controls
		 */
		$this->register_show_pagination_controls();

		$this->add_control(
			'show_navigation_pagination',
			[ 
				'label'   => esc_html__( 'Show Pagination', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
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
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_position',
			[ 
				'label'        => esc_html__( 'Content Position', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [ 
					'left'  => [ 
						'title' => esc_html__( 'Left', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [ 
						'title' => esc_html__( 'Right', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'      => 'right',
				'toggle'       => false,
				'prefix_class' => 'bdt-content-position--',
			]
		);

		$this->end_controls_section();

		//New Query Builder Settings
		$this->start_controls_section(
			'section_post_query_builder',
			[ 
				'label' => esc_html__( 'Query', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->register_query_builder_controls();

		$this->update_control(
			'posts_source',
			[ 
				'type'    => Controls_Manager::SELECT,
				'default' => 'product',
				'options' => [ 
					'product'            => esc_html__( 'Product', 'bdthemes-prime-slider' ),
					'manual_selection'   => esc_html__( 'Manual Selection', 'bdthemes-prime-slider' ),
					'current_query'      => esc_html__( 'Current Query', 'bdthemes-prime-slider' ),
					'_related_post_type' => esc_html__( 'Related', 'bdthemes-prime-slider' ),
				],
			]
		);
		$this->update_control(
			'posts_limit',
			[ 
				'label'   => esc_html__( 'Limit', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_style_animation',
			[ 
				'label' => esc_html__( 'Slider Settings', 'bdthemes-prime-slider' ),
			]
		);

		/**
		 * Slider Settings Controls
		 */
		$this->register_slider_settings_controls();

		/**
		 * Ken Burns Controls
		 */
		$this->register_ken_burns_controls();

		$this->end_controls_section();

		//Style Start

		$this->start_controls_section(
			'section_style_sliders',
			[ 
				'label' => esc_html__( 'Sliders', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'glassmorphism_effect',
			[ 
				'label'       => esc_html__( 'Glassmorphism', 'bdthemes-element-pack' ) . BDTPS_PRO_NC,
				'type'        => Controls_Manager::SWITCHER,
				'description' => sprintf( __( 'This feature will not work in the Firefox browser untill you enable browser compatibility so please %1s look here %2s', 'bdthemes-element-pack' ), '<a href="https://developer.mozilla.org/en-US/docs/Web/CSS/backdrop-filter#Browser_compatibility" target="_blank">', '</a>' ),

			]
		);

		$this->add_control(
			'glassmorphism_blur_level',
			[ 
				'label'     => __( 'Blur Level', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min'  => 0,
						'step' => 1,
						'max'  => 50,
					]
				],
				'default'   => [ 
					'size' => 5
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-skin-woostand .bdt-ps-slideshow-content-wrapper .bdt-ps-slideshow-inner' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);'
				],
				'condition' => [ 
					'glassmorphism_effect' => 'yes',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'inner_background_color',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-skin-woostand .bdt-ps-slideshow-content-wrapper .bdt-ps-slideshow-inner',
			]
		);

		$this->start_controls_tabs( 'slider_item_style' );

		$this->start_controls_tab(
			'slider_title_style',
			[ 
				'label'     => __( 'Title', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_title' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'title_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-title a' => 'color: {{VALUE}};',
				],
				'condition' => [ 
					'show_title' => [ 'yes' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'      => 'title_typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-prime-slider' ),
				'selector'  => '{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-title',
				'condition' => [ 
					'show_title' => [ 'yes' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[ 
				'name'      => 'title_text_stroke',
				'label'     => esc_html__( 'Text Stroke', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'selector'  => '{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-title',
				'condition' => [ 
					'show_title' => [ 'yes' ],
				],
			]
		);

		$this->add_responsive_control(
			'prime_slider_title_spacing',
			[ 
				'label'     => esc_html__( 'Title Spacing', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-title' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'show_title' => [ 'yes' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'slider_category_style',
			[ 
				'label'     => __( 'Category', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_category' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'category_heading_normal',
			[ 
				'label' => __( 'Normal', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'category_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-category a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'category_background_color',
			[ 
				'label'     => esc_html__( 'Background', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-category a' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'     => 'category_border',
				'label'    => __( 'Border', 'bdthemes-element-pack' ),
				'selector' => '{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-category a',
			]
		);

		$this->add_control(
			'category_border_radius',
			[ 
				'label'      => __( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-category a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'category_padding',
			[ 
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-category a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'category_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-category a',
			]
		);

		$this->add_responsive_control(
			'prime_slider_category_spacing',
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
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-category' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'show_category' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'category_heading_hover',
			[ 
				'label'     => __( 'Hover', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'category_hover_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-category a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'category_hover_background_color',
			[ 
				'label'     => esc_html__( 'Background', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-category a:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'category_hover_border_color',
			[ 
				'label'     => __( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-category a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hide_comma',
			[ 
				'label'     => esc_html__( 'Hide Comma', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SWITCHER,
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_style_price',
			[ 
				'label'     => __( 'Price', 'bdthemes-element-pack' ),
				'condition' => [ 
					'show_price' => 'yes',
				],
			]
		);

		$this->add_control(
			'old_price_heading',
			[ 
				'label' => __( 'Old Price', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'old_price_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-price del, {{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-price .price > span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'old_price_margin',
			[ 
				'label'      => __( 'Margin', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-price del, {{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-price .price > span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'old_price_typography',
				'label'    => __( 'Typography', 'bdthemes-element-pack' ),
				'selector' => '{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-price del, {{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-price .price > span',
			]
		);

		$this->add_control(
			'sale_price_heading',
			[ 
				'label'     => __( 'Sale Price', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sale_price_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-price ins' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'sale_price_margin',
			[ 
				'label'      => __( 'Margin', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-price ins' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'sale_price_typography',
				'label'    => __( 'Typography', 'bdthemes-element-pack' ),
				'selector' => '{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-price ins',
			]
		);


		$this->add_responsive_control(
			'sale_price_spacing',
			[ 
				'label'      => __( 'Spacing', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-price' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[ 
				'label'     => __( 'Add to Cart Button', 'bdthemes-element-pack' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_cart' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[ 
				'label' => __( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'button_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-add-to-cart .button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background',
			[ 
				'label'     => __( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-add-to-cart .button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'button_shadow',
				'selector' => '{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-add-to-cart .button',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'        => 'button_border',
				'label'       => __( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-add-to-cart .button',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'button_radius',
			[ 
				'label'      => __( 'Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-add-to-cart .button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_padding',
			[ 
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-add-to-cart .button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'button_typography',
				'label'    => __( 'Typography', 'bdthemes-element-pack' ),
				'selector' => '{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-add-to-cart .button',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[ 
				'label' => __( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'button_hover_background',
			[ 
				'label'     => __( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-add-to-cart .button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-add-to-cart .button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[ 
				'label'     => __( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 
					'button_border_border!' => '',
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-add-to-cart .button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_quantity',
			[ 
				'label' => __( 'Quantity', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'quantity_button_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-add-to-cart .input-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'quantity_button_background',
			[ 
				'label'     => __( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-add-to-cart .input-text' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'quantity_button_shadow',
				'selector' => '{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-add-to-cart .input-text',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'        => 'quantity_button_border',
				'label'       => __( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-add-to-cart .input-text',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'quantity_button_radius',
			[ 
				'label'      => __( 'Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-add-to-cart .input-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'quantity_button_padding',
			[ 
				'label'      => __( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-add-to-cart .input-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'quantity_button_typography',
				'label'    => __( 'Typography', 'bdthemes-element-pack' ),
				'selector' => '{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-add-to-cart .input-text',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[ 
				'label' => __( 'Navigation', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'navi_background_color',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-skin-woostand .ps-navigation-wrapper',
			]
		);

		$this->start_controls_tabs( 'tabs_navigation_style' );

		$this->start_controls_tab(
			'tab_navigation_arrows_style',
			[ 
				'label' => __( 'Arrows', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'arrows_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-previous svg, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-next svg' => 'color: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_color',
			[ 
				'label'     => __( 'Hover Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-previous:hover svg, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-next:hover svg' => 'color: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_navigation_dots_style',
			[ 
				'label' => __( 'Dots', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'dots_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-dotnav-dots li a' => 'background: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'dots_active_color',
			[ 
				'label'     => __( 'Active Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-dotnav-dots li.bdt-active a' => 'background: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_navigation_pagination_style',
			[ 
				'label' => __( 'Pagination', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'pagination_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-dotnav span' => 'color: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_pagination' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'pagination_active_color',
			[ 
				'label'     => __( 'Active Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-dotnav li a' => 'color: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_pagination' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'pagination_separator_color',
			[ 
				'label'     => __( 'Separator Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-dotnav span:before' => 'background: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_pagination' => [ 'yes' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_additional',
			[ 
				'label' => __( 'Additional', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_padding',
			[ 
				'label'      => __( 'Content Inner Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-slideshow-content-wrapper .bdt-ps-slideshow-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'overlay',
			[ 
				'label'     => esc_html__( 'Overlay', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'background',
				'options'   => [ 
					'none'       => esc_html__( 'None', 'bdthemes-prime-slider' ),
					'background' => esc_html__( 'Background', 'bdthemes-prime-slider' ),
					'blend'      => esc_html__( 'Blend', 'bdthemes-prime-slider' ),
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'overlay_color',
			[ 
				'label'     => esc_html__( 'Overlay Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 
					'overlay' => [ 'background', 'blend' ]
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-slideshow .bdt-overlay-default' => 'background-color: {{VALUE}};'
				]
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
					'overlay' => 'blend',
				],
			]
		);

		$this->end_controls_section();
	}

	//WC-Slider
	public function render_query() {
		$default  = $this->getGroupControlQueryArgs();
		$wp_query = new WP_Query( $default );
		return $wp_query;
	}

	public function render_header( $skin_name = 'woostand' ) {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'prime-slider', 'class', 'bdt-prime-slider-skin-' . $skin_name );

		/**
		 * Slideshow Settings
		 */
		$this->render_slideshows_settings( '460' );
	}

	public function render_navigation_arrows() {
		$settings = $this->get_settings_for_display();

		?>

		<?php if ( $settings['show_navigation_arrows'] ) : ?>
			<div class="bdt-navigation-arrows">
				<a class="bdt-prime-slider-previous" href="#" bdt-slidenav-previous bdt-slideshow-item="previous"></a>
				<a class="bdt-prime-slider-next" href="#" bdt-slidenav-next bdt-slideshow-item="next"></a>
			</div>


		<?php endif; ?>

		<?php
	}

	public function render_navigation_dots() {
		$settings = $this->get_active_settings();

		?>

		<?php if ( 'yes' == $settings['show_navigation_pagination'] ) : ?>
			<ul class="bdt-ps-dotnav">
				<?php $slide_index = 1;
				$wp_query    = $this->render_query();
				while ( $wp_query->have_posts() ) :
					$wp_query->the_post();
					?>

					<li bdt-slideshow-item="<?php echo esc_attr( ($slide_index - 1) ); ?>"
						data-label="<?php echo esc_attr(str_pad( $slide_index, 2, '0', STR_PAD_LEFT )); ?>">
						<a href="javascript:void(0);">
							<?php echo esc_html(str_pad( $slide_index, 2, '0', STR_PAD_LEFT )); ?>
						</a>
						<?php $slide_index++; ?>
					</li>

					<?php
				endwhile;
				wp_reset_postdata();
				?>
				<span>
					<?php echo esc_html( str_pad( $slide_index - 1, 2, '0', STR_PAD_LEFT ) ); ?>
				</span>
			</ul>
		<?php endif; ?>

		<?php if ( 'yes' == $settings['show_navigation_dots'] ) : ?>
			<ul class="bdt-slideshow-nav bdt-dotnav-dots bdt-dotnav"></ul>
		<?php endif; ?>

		<?php
	}

	public function render_footer() {
		?>

		</ul>

		<div class="ps-navigation-wrapper">
			<?php $this->render_navigation_dots(); ?>
			<?php $this->render_navigation_arrows(); ?>
		</div>

		</div>

		</div>
		</div>
		<?php
	}

	public function render_item_content() {
		$settings = $this->get_settings_for_display();

		if ( 'yes' == $settings['hide_comma'] ) {
			$this->add_render_attribute( 'comma', 'class', 'bdt-hide-comma', true );
		}

		?>
		<div class="bdt-ps-slideshow-content-wrapper">
			<div class="bdt-ps-slideshow-inner">
				<?php if ( $settings['show_category'] ) : ?>
					<div class="bdt-ps-category">
						<span <?php $this->print_render_attribute_string( 'comma' ); ?>>
							<?php echo wc_get_product_category_list( get_the_ID(), '<span class="hide-comma">,</span> ' ); ?>
						</span>
					</div>
				<?php endif; ?>

				<?php if ( $settings['show_title'] ) : ?>
					<<?php echo esc_attr( Utils::get_valid_html_tag( $settings['title_html_tag'] ) ); ?> class="bdt-ps-title">
						<a href="<?php the_permalink(); ?>">
							<?php the_title(); ?>
						</a>
					</<?php echo esc_attr( Utils::get_valid_html_tag( $settings['title_html_tag'] ) ); ?>>
				<?php endif; ?>

				<?php if ( $settings['show_price'] ) : ?>
					<div class="bdt-ps-price">
						<span class="wae-product-price">
							<?php woocommerce_template_single_price(); ?>
						</span>
					</div>
				<?php endif; ?>

				<?php if ( $settings['show_cart'] ) : ?>
					<div class="bdt-ps-add-to-cart-btn">
						<?php if ( $settings['show_cart'] ) : ?>
							<div class="bdt-ps-add-to-cart">
								<?php woocommerce_template_single_add_to_cart(); ?>
							</div>
						<?php endif; ?>

					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	public function rendar_item_image() {
		$settings = $this->get_settings_for_display();

		$placeholder_image_src = Utils::get_placeholder_image_src();
		$image_src             = Group_Control_Image_Size::get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail_size', $settings );

		if ( $image_src ) {
			$image_final_src = $image_src;
		} elseif ( $placeholder_image_src ) {
			$image_final_src = $placeholder_image_src;
		} else {
			return;
		}

		?>

		<div class="bdt-ps-slide-img" style="background-image: url('<?php echo esc_url( $image_final_src ); ?>')"></div>

		<?php
	}

	public function render_slides_loop() {
		$settings = $this->get_settings_for_display();

		$kenburns_reverse = $settings['kenburns_reverse'] ? ' bdt-animation-reverse' : '';

		$wp_query = $this->render_query();

		while ( $wp_query->have_posts() ) :
			$wp_query->the_post();

			?>

			<li class="bdt-slideshow-item elementor-repeater-item-<?php echo esc_attr( get_the_ID() ); ?>">

				<?php if ( 'yes' == $settings['kenburns_animation'] ) : ?>
					<div
						class="bdt-position-cover bdt-animation-kenburns<?php echo esc_attr( $kenburns_reverse ); ?> bdt-transform-origin-center-left">
					<?php endif; ?>

					<?php $this->rendar_item_image(); ?>

					<?php if ( 'yes' == $settings['kenburns_animation'] ) : ?>
					</div>
				<?php endif; ?>

				<?php if ( 'none' !== $settings['overlay'] ) :
					$blend_type = ( 'blend' == $settings['overlay'] ) ? ' bdt-blend-' . $settings['blend_type'] : ''; ?>
					<div class="bdt-overlay-default bdt-position-cover<?php echo esc_attr( $blend_type ); ?>"></div>
				<?php endif; ?>

				<?php $this->render_item_content(); ?>

			</li>

			<?php

		endwhile;
		wp_reset_postdata();
	}

	public function render() {

		$this->render_header();

		$this->render_slides_loop();

		$this->render_footer();
	}
}
