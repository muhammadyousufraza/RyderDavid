<?php

namespace PrimeSliderPro\Modules\Wooexpand\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use PrimeSliderPro\Utils;

use PrimeSlider\Traits\Global_Widget_Controls;
use PrimeSlider\Traits\QueryControls\GroupQuery\Group_Control_Query;
use WP_Query;

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

class Wooexpand extends Widget_Base {
	use Group_Control_Query;
	use Global_Widget_Controls;
	public function get_name() {
		return 'prime-slider-wooexpand';
	}

	public function get_title() {
		return BDTPS . esc_html__( 'WooExpand', 'bdthemes-prime-slider' );
	}

	public function get_icon() {
		return 'bdt-widget-icon ps-wi-wooexpand';
	}

	public function get_categories() {
		return [ 'prime-slider-pro' ];
	}

	public function get_keywords() {
		return [ 'prime slider', 'slider', 'wooexpand', 'prime', 'wc slider', 'woocommerce' ];
	}

	public function get_style_depends() {
		return [ 'ps-wooexpand', 'prime-slider-font' ];
	}

	public function get_script_depends() {
		return [ 'ps-wooexpand' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/t5_ogz1XhJo';
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_wooexpand_layout',
			[ 
				'label' => __( 'Layout', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_responsive_control(
			'image_expand_min_height',
			[ 
				'label'     => esc_html__( 'Height', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 100,
						'max' => 1200,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-wooexpand' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_expand_width',
			[ 
				'label'     => esc_html__( 'Content Width', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content' => 'width: {{SIZE}}%;',
				],
			]
		);

		$this->add_responsive_control(
			'items_content_align',
			[ 
				'label'     => __( 'Alignment', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [ 
					'left'    => [ 
						'title' => __( 'Left', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'  => [ 
						'title' => __( 'Center', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'   => [ 
						'title' => __( 'Right', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify' => [ 
						'title' => __( 'Justified', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content' => 'text-align: {{VALUE}};',
				],
			]
		);

		/**
		 * Thumbnail Size Controls
		 */
		$this->register_thumbnail_size_controls();

		//Global background settings Controls
		$this->register_background_settings( '.bdt-wooexpand .bdt-wooexpand-item' );

		/**
		 * Show Title Controls
		 */
		$this->register_show_title_controls();

		$this->add_control(
			'show_rating',
			[ 
				'label'   => esc_html__( 'Show Rating', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		/**
		 * Show Excerpt Controls
		 */
		$this->register_show_excerpt_controls();

		/**
		 * Show Price Controls
		 */
		$this->register_show_price_controls();

		/**
		 * Show Cart Controls
		 */
		$this->register_show_cart_controls();

		$this->add_control(
			'show_meta',
			[ 
				'label'   => __( 'Add Meta', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_badge',
			[ 
				'label'   => esc_html__( 'Show Badge', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'image_expand_event',
			[ 
				'label'     => __( 'Select Event', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'click',
				'options'   => [ 
					'click'     => __( 'Click', 'bdthemes-prime-slider' ),
					'mouseover' => __( 'Hover', 'bdthemes-prime-slider' ),
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'active_item',
			[ 
				'label' => esc_html__( 'Active Item', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'active_item_number',
			[ 
				'label'       => __( 'Item Number', 'bdthemes-prime-slider' ),
				'description' => __( 'Type your item number', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 1,
				'condition'   => [ 
					'active_item' => 'yes'
				]
			]
		);

		$this->add_control(
			'show_scrollspy',
			[ 
				'label'     => esc_html__( 'Show Scrollspy', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'scrollspy_delay',
			[ 
				'label'     => _x( 'Delay(ms)', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'type'      => Controls_Manager::NUMBER,
				'default'   => 500,
				'condition' => [ 
					'show_scrollspy' => 'yes'
				]
			]
		);

		$this->add_control(
			'scrollspy_animation',
			[ 
				'label'     => _x( 'Animation', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'fade',
				'options'   => [ 
					'fade'         => _x( 'Fade', 'bdthemes-prime-slider' ),
					'slide-top'    => _x( 'Slide Top', 'bdthemes-prime-slider' ),
					'slide-bottom' => _x( 'Slide Bottom', 'bdthemes-prime-slider' ),
				],
				'condition' => [ 
					'show_scrollspy' => 'yes'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_post_query_builder',
			[ 
				'label' => esc_html__( 'Query', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->register_query_builder_controls();
		$this->update_control(
			'posts_limit',
			[ 
				'label'   => esc_html__( 'Limit', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 4,
			]
		);

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
				]
			]
		);
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
			'image_overlay_color',
			[ 
				'label'     => esc_html__( 'Overlay Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item:before' => 'background: {{VALUE}};',
				]
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[ 
				'label'      => esc_html__( 'Content Padding', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
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
			'show_text_stroke',
			[ 
				'label'        => esc_html__( 'Text Stroke', 'bdthemes-prime-slider' ),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'bdt-text-stroke--',
				'condition'    => [ 
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
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content .bdt-ps-title a' => 'color: {{VALUE}}; -webkit-text-stroke-color: {{VALUE}};',
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
				'selector'  => '{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content .bdt-ps-title',
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
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content .bdt-ps-title' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'show_title' => [ 'yes' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'slider_meta_style',
			[ 
				'label'     => __( 'Meta', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_meta' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'meta_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content .bdt-single-meta span *' => 'color: {{VALUE}};',
				],
				'condition' => [ 
					'show_meta' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'meta_hover_color',
			[ 
				'label'     => esc_html__( 'Hover Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content .bdt-single-meta span a:hover' => 'color: {{VALUE}};',
				],
				'condition' => [ 
					'show_meta' => [ 'yes' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'      => 'meta_typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-prime-slider' ),
				'selector'  => '{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content .bdt-single-meta span',
				'condition' => [ 
					'show_meta' => [ 'yes' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'      => 'meta_left_typography',
				'label'     => esc_html__( 'Left Typography', 'bdthemes-prime-slider' ),
				'selector'  => '{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content .bdt-single-meta .bdt-meta-name',
				'condition' => [ 
					'show_meta' => [ 'yes' ],
				],
			]
		);

		$this->add_responsive_control(
			'meta_spacing',
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
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content .bdt-single-meta > span' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'show_meta' => [ 'yes' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'slider_style_excerpt',
			[ 
				'label'     => esc_html__( 'Text', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_excerpt' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'excerpt_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content .bdt-ps-text' => 'color: {{VALUE}};',
				],
				'condition' => [ 
					'show_excerpt' => [ 'yes' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'      => 'excerpt_typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-prime-slider' ),
				'selector'  => '{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content .bdt-ps-text',
				'condition' => [ 
					'show_excerpt' => [ 'yes' ],
				],
			]
		);

		$this->add_responsive_control(
			'prime_slider_excerpt_spacing',
			[ 
				'label'     => esc_html__( 'Excerpt Spacing', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content .bdt-ps-text' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'show_excerpt' => [ 'yes' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_style_price',
			[ 
				'label'     => __( 'Price', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_price' => 'yes',
				],
			]
		);

		$this->add_control(
			'old_price_heading',
			[ 
				'label' => __( 'Old Price', 'bdthemes-prime-slider' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'old_price_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content .bdt-ps-price .price del span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'old_price_margin',
			[ 
				'label'      => __( 'Margin', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content .bdt-ps-price .price del > span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'old_price_typography',
				'label'    => __( 'Typography', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content .bdt-ps-price .price del span',
			]
		);

		$this->add_control(
			'sale_price_heading',
			[ 
				'label'     => __( 'Sale Price', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sale_price_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content .bdt-ps-price .price ins, {{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content .bdt-ps-price .price > span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'sale_price_margin',
			[ 
				'label'      => __( 'Margin', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content .bdt-ps-price .price ins, {{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content .bdt-ps-price .price > span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'sale_price_typography',
				'label'    => __( 'Typography', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content .bdt-ps-price .price ins, {{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content .bdt-ps-price .price > span',
			]
		);


		$this->add_responsive_control(
			'sale_price_spacing',
			[ 
				'label'      => __( 'Spacing', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content .bdt-ps-price' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'slider_style_badge',
			[ 
				'label'     => esc_html__( 'Badge', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_badge' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'badge_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content .bdt-badge-wrapper' => 'color: {{VALUE}};',
				],
				'condition' => [ 
					'show_badge' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'badge_line_color',
			[ 
				'label'     => esc_html__( 'Line Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content .bdt-meta-text-wrapper' => 'border-top-color: {{VALUE}};',
				],
				'condition' => [ 
					'show_badge' => [ 'yes' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'      => 'badge_typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-prime-slider' ),
				'selector'  => '{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content .bdt-badge-wrapper',
				'condition' => [ 
					'show_badge' => [ 'yes' ],
				],
			]
		);

		$this->add_responsive_control(
			'prime_slider_badge_spacing',
			[ 
				'label'     => esc_html__( 'Spacing', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content .bdt-meta-text-wrapper' => 'padding-top: {{SIZE}}{{UNIT}}; margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'show_badge' => [ 'yes' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'slider_style_rating',
			[ 
				'label'     => esc_html__( 'rating', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_rating' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'rating_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content .bdt-ps-rating .star-rating span' => 'color: {{VALUE}};',
				],
				'condition' => [ 
					'show_rating' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'rating_text_color',
			[ 
				'label'     => esc_html__( 'Text Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content .bdt-ps-rating .woocommerce-review-link' => 'color: {{VALUE}};',
				],
				'condition' => [ 
					'show_rating' => [ 'yes' ],
				],
			]
		);

		$this->add_responsive_control(
			'prime_slider_rating_spacing',
			[ 
				'label'     => esc_html__( 'Spacing', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-content .bdt-ps-rating .woocommerce-product-rating' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'show_rating' => [ 'yes' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[ 
				'label'     => __( 'Add to Cart', 'bdthemes-prime-slider' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_cart' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_color',
			[ 
				'label'     => __( 'Icon Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-ps-add-to-cart-btn .bdt-ps-add-to-cart i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-ps-add-to-cart-btn .bdt-ps-add-to-cart svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_color',
			[ 
				'label'     => __( 'Hover Icon Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-ps-add-to-cart-btn .bdt-ps-add-to-cart:hover i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-ps-add-to-cart-btn .bdt-ps-add-to-cart:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_border_color',
			[ 
				'label'     => __( 'Border Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-ps-add-to-cart-btn .bdt-ps-add-to-cart' => 'border-color: {{VALUE}};',
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[ 
				'label'     => __( 'Hover Border Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-ps-add-to-cart-btn .bdt-ps-add-to-cart:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_line_color',
			[ 
				'label'     => __( 'Line Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-ps-add-to-cart-btn .bdt-ps-add-to-cart:after, {{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-ps-add-to-cart-btn .bdt-ps-add-to-cart:before' => 'background: {{VALUE}};',
				],
				'separator' => 'before'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_counter',
			[ 
				'label' => __( 'Counter/Plus Title', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'counter_number_heading',
			[ 
				'label' => __( 'Counter Number', 'bdthemes-prime-slider' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'counter_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-counter' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'counter_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-wooexpand-counter',
			]
		);

		$this->add_control(
			'plus_title_heading',
			[ 
				'label'     => __( 'Plus Title', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'plus_icon_color',
			[ 
				'label'     => __( 'Icon Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-plus-title-wrap span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'plus_title_color',
			[ 
				'label'     => __( 'Title Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-plus-title-wrap a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'plus_title_line_color',
			[ 
				'label'     => __( 'Line Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-plus-title-wrap .bdt-ps-title-inner:before' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'plus_title_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-plus-title-wrap span, {{WRAPPER}} .bdt-wooexpand .bdt-wooexpand-item .bdt-plus-title-wrap .bdt-ps-title-inner',
			]
		);

		$this->end_controls_section();
	}

	public function render_query() {
		$default  = $this->getGroupControlQueryArgs();
		$wp_query = new WP_Query( $default );
		return $wp_query;
	}

	public function render() {
		$settings = $this->get_settings_for_display();

		if ( $settings['image_expand_event'] ) {
			$imageExpandEvent = $settings['image_expand_event'];
		} else {
			$imageExpandEvent = false;
		}

		$this->add_render_attribute(
			[ 
				'wooexpand' => [ 
					'id'            => 'bdt-wooexpand-' . $this->get_id(),
					'class'         => 'bdt-wooexpand',
					'data-settings' => [ 
						wp_json_encode( array_filter( [ 
							'tabs_id'          => 'bdt-wooexpand-' . $this->get_id(),
							'mouse_event'      => $imageExpandEvent,
							'activeItem'       => $settings['active_item'] == 'yes' ? true : false,
							'activeItemNumber' => $settings['active_item_number']
						] ) )
					]
				]
			]
		);

		if ( $settings['show_scrollspy'] == 'yes' ) {
			$this->add_render_attribute( 'wooexpand', 'bdt-scrollspy', 'cls: bdt-animation-' . $settings['scrollspy_animation'] . '; target: .bdt-wooexpand-item; delay: ' . $settings['scrollspy_delay'] . '; repeat: true;' );
		}

		?>

		<div <?php $this->print_render_attribute_string( 'wooexpand' ); ?>>
			<?php
			$wp_query = $this->render_query();

			while ( $wp_query->have_posts() ) :
				$wp_query->the_post();
				global $product;

				$placeholder_image_src = Utils::get_placeholder_image_src();
				$image_src             = Group_Control_Image_Size::get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail_size', $settings );

				if ( $image_src ) {
					$image_final_src = $image_src;
				} elseif ( $placeholder_image_src ) {
					$image_final_src = $placeholder_image_src;
				} else {
					return;
				}

				$this->add_render_attribute( 'wooexpand-item', 'class', 'bdt-wooexpand-item', true );

				?>

				<div <?php $this->print_render_attribute_string( 'wooexpand-item' ); ?>
					style="background-image: url('<?php echo esc_url( $image_final_src ); ?>');">

					<div class="bdt-wooexpand-content">

						<?php if ( $settings['show_title'] ) : ?>
							<<?php echo esc_attr( Utils::get_valid_html_tag( $settings['title_html_tag'] ) ); ?> class="bdt-ps-title"
								data-bdt-slideshow-parallax="y: 70,0,-100; opacity: 1,1,0">
								<a href="<?php the_permalink(); ?>">
									<?php the_title(); ?>
								</a>
							</<?php echo esc_attr( Utils::get_valid_html_tag( $settings['title_html_tag'] ) ); ?>>
						<?php endif; ?>

						<?php if ( 'yes' == $settings['show_rating'] ) : ?>
							<div class="bdt-ps-rating">
								<?php woocommerce_template_single_rating(); ?>
							</div>
						<?php endif; ?>

						<?php if ( $settings['show_price'] ) : ?>
							<div class="bdt-ps-price" data-bdt-slideshow-parallax="y: 100,0,-70; opacity: 1,1,0">
								<span class="wae-product-price">
									<?php woocommerce_template_single_price(); ?>
								</span>
							</div>
						<?php endif; ?>

						<?php if ( $settings['show_excerpt'] ) : ?>
							<div class="bdt-ps-text" data-bdt-slideshow-parallax="y: 90,0,-90; opacity: 1,1,0">
								<?php the_excerpt(); ?>
							</div>
						<?php endif; ?>

						<?php if ( $settings['show_meta'] ) : ?>
							<div class="bdt-single-meta product_meta">
								<?php do_action( 'woocommerce_product_meta_start' ); ?>
								<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
									<span class="sku_wrapper">
										<span class="bdt-meta-name">
											<?php esc_html_e( 'SKU:', 'woocommerce' ); ?>
										</span>
										<span class="sku">
											<?php 
											$sku =  $product->get_sku() ? $product->get_sku() : esc_html__('N/A', 'woocommerce');
											echo wp_kses_post( $sku );
											?>
										</span>
									</span>
								<?php endif; ?>
								<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( '<span class="bdt-meta-name">Category:</span>', '<span class="bdt-meta-name">Categories:</span>', count( $product->get_category_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>
								<?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( '<span class="bdt-meta-name">Tag:</span>', '<span class="bdt-meta-name">Tags:</span>', count( $product->get_tag_ids() ), 'woocommerce' ) . ' ', '</span>' ); ?>
								<?php do_action( 'woocommerce_product_meta_end' ); ?>
							</div>
						<?php endif; ?>

						<?php if ( $settings['show_badge'] and ! $product->is_in_stock() or $product->is_on_sale() ) : ?>
							<div class="bdt-meta-text-wrapper">
								<?php if ( $settings['show_badge'] and ! $product->is_in_stock() ) : ?>
									<div class="bdt-badge-wrapper">
										<?php //woocommerce_show_product_loop_sale_flash();
															?>
										<?php echo apply_filters( 'woocommerce_product_is_in_stock', '<span class="bdt-onsale">' . esc_html__( 'Out of Stock!', 'woocommerce' ) . '</span>', $product ); ?>
									</div>
								<?php elseif ( $settings['show_badge'] and $product->is_on_sale() ) : ?>
									<div class="bdt-badge-wrapper">
										<?php //woocommerce_show_product_loop_sale_flash();
															?>
										<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="bdt-onsale">' . esc_html__( 'In Stock!', 'woocommerce' ) . '</span>', $product ); ?>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>

					</div>

					<div class="bdt-wooexpand-counter bdt-visible@s">0</div>

					<div class="bdt-plus-title-wrap">
						<div class="bdt-plus-title-inner">
							<span class="bdt-ps-plus-icon">
								<i class="ps-wi-plus"></i>
							</span>
							<?php if ( $settings['show_title'] ) : ?>
								<<?php echo esc_attr( Utils::get_valid_html_tag( $settings['title_html_tag'] ) ); ?> class="bdt-ps-title-inner">
									<a href="javascript:void(0);">
										<?php the_title(); ?>
									</a>
								</<?php echo esc_attr( Utils::get_valid_html_tag( $settings['title_html_tag'] ) ); ?>>
							<?php endif; ?>
						</div>
					</div>

					<?php if ( $settings['show_cart'] ) : ?>
						<div class="bdt-ps-add-to-cart-btn" data-bdt-slideshow-parallax="y: 110,0,-50; opacity: 1,1,0">
							<?php if ( $settings['show_cart'] ) : ?>
								<div class="bdt-ps-add-to-cart">
									<?php woocommerce_template_single_add_to_cart(); ?>

									<?php if ( $product->is_in_stock() ) { ?>
										<i class="ps-wi-cart-solid"></i>
									<?php } else { ?>
										<svg id="Layer_1" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512"
											xmlns="http://www.w3.org/2000/svg">
											<g>
												<path d="m241 432.465v-59.649l-25.829 44.737z" />
												<path
													d="m358.3 246.464c-.738 19.879-29.268 19.868-30 0v-14.048l-9.359 5.404-47.941 83.034v111.61l137.1-79.152c4.641-2.679 7.5-7.631 7.5-12.99v-158.313l-57.3 33.085z" />
												<path d="m111.4 156.029 113.128 65.318 28.65-49.623-84.481-48.774z" />
												<path
													d="m263.5 76.876c-4.641-2.679-10.359-2.679-15 0l-49.803 28.753 69.481 40.114 28.651-49.625z" />
												<path d="m374.771 141.117-25.828 44.737 51.656-29.826z" />
												<path
													d="m96.4 340.322c0 5.359 2.859 10.311 7.5 12.99l33.328 19.241 72.299-125.226-113.127-65.318z" />
												<path
													d="m256 .836c-141.159 0-256 114.841-256 256 12.87 339.152 499.182 339.06 512-.003 0-141.156-114.841-255.997-256-255.997zm-226 256c-2.18-165.031 179.49-277.498 325.743-202.76l-225.446 390.484c-60.442-40.605-100.297-109.596-100.297-187.724zm226 226c-35.783 0-69.642-8.373-99.743-23.241l225.446-390.484c183.21 122.508 97.632 412.814-125.703 413.725z" />
											</g>
										</svg>
									<?php } ?>

								</div>
							<?php endif; ?>

						</div>
					<?php endif; ?>

				</div>

				<?php

			endwhile;
			wp_reset_postdata(); ?>

		</div>

		<?php
	}
}
