<?php

namespace PrimeSliderPro\Modules\Custom\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;
use Elementor\Repeater;

use PrimeSliderPro\Prime_Slider_Loader;

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

class Custom extends Widget_Base {

	public function get_name() {
		return 'prime-slider-custom';
	}

	public function get_title() {
		return BDTPS . esc_html__( 'Custom', 'bdthemes-prime-slider' );
	}

	public function get_icon() {
		return 'bdt-widget-icon ps-wi-custom';
	}

	public function get_categories() {
		return [ 'prime-slider-pro' ];
	}

	public function get_keywords() {
		return [ 'prime slider', 'slider', 'custom', 'prime' ];
	}

	public function get_style_depends() {
		return [ 'ps-custom' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/Ayo1oEALF_8';
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content_layout',
			[ 
				'label' => esc_html__( 'Layout', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'slider_size_ratio',
			[ 
				'label'       => esc_html__( 'Size Ratio', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::IMAGE_DIMENSIONS,
				'description' => 'Slider ratio to width and height, such as 16:9',
				'separator'   => 'before',
			]
		);

		$this->add_responsive_control(
			'slider_min_height',
			[ 
				'label'     => esc_html__( 'Minimum Height', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 50,
						'max' => 1024,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-custom .bdt-slideshow-items' => 'min-height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_control(
			'show_navigation_arrows',
			[ 
				'label'   => esc_html__( 'Show Arrows', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_navigation_dots',
			[ 
				'label'   => esc_html__( 'Show Dots', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_social_icon',
			[ 
				'label' => esc_html__( 'Show Social Icon', 'bdthemes-prime-slider' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'scroll_to_section',
			[ 
				'label' => esc_html__( 'Scroll to Section', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'section_id',
			[ 
				'label'       => esc_html__( 'Section ID', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => 'Section ID Here',
				'description' => 'Enter section ID of this page, ex: #my-section',
				'label_block' => true,
				'condition'   => [ 
					'scroll_to_section' => 'yes',
				],
			]
		);

		$this->add_control(
			'slider_scroll_to_section_icon',
			[ 
				'label'            => esc_html__( 'Scroll to Section Icon', 'bdthemes-element-pack' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'scroll_to_section_icon',
				'default'          => [ 
					'value'   => 'fas fa-angle-double-down',
					'library' => 'fa-solid',
				],
				'condition'        => [ 
					'scroll_to_section' => 'yes',
				],
				'skin'             => 'inline',
				'label_block'      => false
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_sliders',
			[ 
				'label' => esc_html__( 'Sliders', 'bdthemes-element-pack' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'tab_title',
			[ 
				'label'       => esc_html__( 'Title ( Optional )', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'template_id',
			[ 
				'label'       => __( 'Select Template', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => prime_slider_et_options(),
				'label_block' => 'true',
			]
		);

		$this->add_control(
			'sliders',
			[ 
				'label'       => esc_html__( 'Slider Items', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [ 
					[ 
						'tab_title' => esc_html__( 'Slide #1', 'bdthemes-element-pack' ),
					],
					[ 
						'tab_title' => esc_html__( 'Slide #2', 'bdthemes-element-pack' ),
					],
					[ 
						'tab_title' => esc_html__( 'Slide #3', 'bdthemes-element-pack' ),
					],
				],
				'title_field' => '{{{ tab_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_social_link',
			[ 
				'label'     => __( 'Social Icon', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_social_icon' => 'yes',
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'social_link_title',
			[ 
				'label'   => __( 'Title', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'Facebook',
			]
		);

		$repeater->add_control(
			'social_link',
			[ 
				'label'   => __( 'Link', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'http://www.facebook.com/bdthemes/', 'bdthemes-prime-slider' ),
			]
		);

		$repeater->add_control(
			'social_icon',
			[ 
				'label'       => __( 'Choose Icon', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false
			]
		);

		$this->add_control(
			'social_link_list',
			[ 
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [ 
					[ 
						'social_link'       => __( 'http://www.facebook.com/bdthemes/', 'bdthemes-prime-slider' ),
						'social_icon'       => [ 
							'value'   => 'fab fa-facebook-f',
							'library' => 'fa-brands',
						],
						'social_link_title' => 'Facebook',
					],
					[ 
						'social_link'       => __( 'http://www.twitter.com/bdthemes/', 'bdthemes-prime-slider' ),
						'social_icon'       => [ 
							'value'   => 'fab fa-twitter',
							'library' => 'fa-brands',
						],
						'social_link_title' => 'Twitter',
					],
					[ 
						'social_link'       => __( 'http://www.instagram.com/bdthemes/', 'bdthemes-prime-slider' ),
						'social_icon'       => [ 
							'value'   => 'fab fa-instagram',
							'library' => 'fa-brands',
						],
						'social_link_title' => 'Instagram',
					],
				],
				'title_field' => '{{{ social_link_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_layout_navigation',
			[ 
				'label'      => __( 'Navigation', 'bdthemes-element-pack' ),
				'conditions' => [ 
					'relation' => 'or',
					'terms'    => [ 
						[ 
							'name'  => 'show_navigation_arrows',
							'value' => 'yes'
						],
						[ 
							'name'  => 'show_navigation_dots',
							'value' => 'yes'
						],
					]
				]
			]
		);

		$this->add_control(
			'heading_arrows',
			[ 
				'label'     => __( 'Arrows', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->start_controls_tabs( 'tabs_ps_nav_arrows_layout' );

		$this->start_controls_tab(
			'tab_ps_arrows_next',
			[ 
				'label' => __( 'Next', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'nav_arrows_next_icon',
			[ 
				'label'       => esc_html__( 'Arrows Icon', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [ 
					'value'   => 'fas fa-chevron-right',
					'library' => 'fa-solid',
				],
				'skin'        => 'inline',
				'label_block' => false
			]
		);

		$this->add_control(
			'nav_next_custom_text',
			[ 
				'label'       => esc_html__( 'Custom Text', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Next', 'bdthemes-prime-slider' ),
				'condition'   => [ 
					'navigation_style_type' => [ 'style1', 'style2', 'style4' ],
				],
			]
		);

		$this->add_control(
			'arrows_next_position',
			[ 
				'label'   => esc_html__( 'Position', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'center-right',
				'options' => [ 
					'top-left'     => esc_html__( 'Top Left', 'bdthemes-prime-slider' ),
					'top-right'    => esc_html__( 'Top Right', 'bdthemes-prime-slider' ),
					'center-left'  => esc_html__( 'Center Left', 'bdthemes-prime-slider' ),
					'center-right' => esc_html__( 'Center Right', 'bdthemes-prime-slider' ),
					'bottom-left'  => esc_html__( 'Bottom Left', 'bdthemes-prime-slider' ),
					'bottom-right' => esc_html__( 'Bottom Right', 'bdthemes-prime-slider' ),
				],
			]
		);

		$this->add_responsive_control(
			'arrows_next_horizontal_position',
			[ 
				'label'     => __( 'Horizontal Spacing', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-next' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'show_navigation_arrows' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_next_vertical_spacing',
			[ 
				'label'     => __( 'Next Vertical Spacing', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-next' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'show_navigation_arrows' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_ps_arrows_previous',
			[ 
				'label' => __( 'Previous', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'nav_arrows_prev_icon',
			[ 
				'label'       => esc_html__( 'Arrows Icon', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [ 
					'value'   => 'fas fa-chevron-left',
					'library' => 'fa-solid',
				],
				'skin'        => 'inline',
				'label_block' => false
			]
		);

		$this->add_control(
			'nav_prev_custom_text',
			[ 
				'label'       => esc_html__( 'Custom Text', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Prev', 'bdthemes-prime-slider' ),
				'condition'   => [ 
					'navigation_style_type' => [ 'style1', 'style2', 'style4' ],
				],
			]
		);

		$this->add_control(
			'arrows_prev_position',
			[ 
				'label'   => esc_html__( 'Position', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'center-left',
				'options' => [ 
					'top-left'     => esc_html__( 'Top Left', 'bdthemes-prime-slider' ),
					'top-right'    => esc_html__( 'Top Right', 'bdthemes-prime-slider' ),
					'center-left'  => esc_html__( 'Center Left', 'bdthemes-prime-slider' ),
					'center-right' => esc_html__( 'Center Right', 'bdthemes-prime-slider' ),
					'bottom-left'  => esc_html__( 'Bottom Left', 'bdthemes-prime-slider' ),
					'bottom-right' => esc_html__( 'Bottom Right', 'bdthemes-prime-slider' ),
				],
			]
		);

		$this->add_responsive_control(
			'arrows_prev_horizontal_position',
			[ 
				'label'     => __( 'Horizontal Spacing', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-previous' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'show_navigation_arrows' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_prev_vertical_spacing',
			[ 
				'label'     => __( 'Prev Vertical Spacing', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-previous' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'show_navigation_arrows' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_ps_dots',
			[ 
				'label'     => __( 'Dots', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'dots_hv_position',
			[ 
				'label'   => esc_html__( 'Position', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'bottom-center',
				'options' => [ 
					'top-left'      => esc_html__( 'Top Left', 'bdthemes-prime-slider' ),
					'top-right'     => esc_html__( 'Top Right', 'bdthemes-prime-slider' ),
					'center-left'   => esc_html__( 'Center Left', 'bdthemes-prime-slider' ),
					'center-right'  => esc_html__( 'Center Right', 'bdthemes-prime-slider' ),
					'bottom-left'   => esc_html__( 'Bottom Left', 'bdthemes-prime-slider' ),
					'bottom-right'  => esc_html__( 'Bottom Right', 'bdthemes-prime-slider' ),
					'bottom-center' => esc_html__( 'Bottom Center', 'bdthemes-prime-slider' ),
				],
			]
		);

		$this->add_responsive_control(
			'dots_vertical_spacing',
			[ 
				'label'     => __( 'Vertical Spacing', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-dotnav' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
			]
		);

		$this->add_responsive_control(
			'dots_horizontal_spacing',
			[ 
				'label'     => __( 'Horizontal Spacing', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-dotnav' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
			]
		);

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_slider_settings',
			[ 
				'label' => esc_html__( 'Slider Settings', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'finite',
			[ 
				'label'   => esc_html__( 'Loop', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'autoplay',
			[ 
				'label'   => esc_html__( 'Autoplay', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'autoplay_interval',
			[ 
				'label'     => esc_html__( 'Autoplay Interval', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 7000,
				'condition' => [ 
					'autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'pause_on_hover',
			[ 
				'label' => esc_html__( 'Pause on Hover', 'bdthemes-prime-slider' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'velocity',
			[ 
				'label' => __( 'Animation Speed', 'bdthemes-element-pack' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [ 
					'px' => [ 
						'min'  => 0.1,
						'max'  => 1,
						'step' => 0.1,
					],
				],
			]
		);

		$this->add_control(
			'slider_animations',
			[ 
				'label'     => esc_html__( 'Slider Animations', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SELECT,
				'separator' => 'before',
				'default'   => 'slide',
				'options'   => [ 
					'slide' => esc_html__( 'Slide', 'bdthemes-prime-slider' ),
					'fade'  => esc_html__( 'Fade', 'bdthemes-prime-slider' ),
					'scale' => esc_html__( 'Scale', 'bdthemes-prime-slider' ),
					'push'  => esc_html__( 'Push', 'bdthemes-prime-slider' ),
					'pull'  => esc_html__( 'Pull', 'bdthemes-prime-slider' ),
				],
			]
		);

		$this->end_controls_section();


		//Style
		$this->start_controls_section(
			'section_style_slider',
			[ 
				'label' => esc_html__( 'Slider', 'bdthemes-element-pack' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'slider_background_color',
				'label'    => __( 'Background', 'bdthemes-prime-slider' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .bdt-prime-slider .bdt-slideshow-item',
			]
		);

		$this->add_responsive_control(
			'slider_item_padding',
			[ 
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-slideshow-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_scroll_to_top',
			[ 
				'label'      => esc_html__( 'Scroll to Top', 'bdthemes-element-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [ 
					'terms' => [ 
						[ 
							'name'  => 'scroll_to_section',
							'value' => 'yes',
						],
						[ 
							'name'     => 'section_id',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->start_controls_tabs( 'tabs_scroll_to_top_style' );

		$this->start_controls_tab(
			'scroll_to_top_normal',
			[ 
				'label' => esc_html__( 'Normal', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'scroll_to_top_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ep-scroll-to-section a'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-prime-slider .bdt-ep-scroll-to-section a svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'scroll_to_top_background',
			[ 
				'label'     => esc_html__( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ep-scroll-to-section a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'scroll_to_top_shadow',
				'selector' => '{{WRAPPER}} .bdt-prime-slider .bdt-ep-scroll-to-section a',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'        => 'scroll_to_top_border',
				'label'       => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-prime-slider .bdt-ep-scroll-to-section a',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'scroll_to_top_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ep-scroll-to-section a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'scroll_to_top_padding',
			[ 
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ep-scroll-to-section a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'scroll_to_top_icon_size',
			[ 
				'label'     => esc_html__( 'Icon Size', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ep-scroll-to-section a' => 'font-size: {{SIZE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'scroll_to_top_bottom_space',
			[ 
				'label'     => esc_html__( 'Bottom Space', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min'  => 0,
						'max'  => 300,
						'step' => 5,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ep-scroll-to-section' => 'margin-bottom: {{SIZE}}px;',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'scroll_to_top_hover',
			[ 
				'label' => esc_html__( 'Hover', 'bdthemes-element-pack' ),
			]
		);

		$this->add_control(
			'scroll_to_top_hover_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ep-scroll-to-section a:hover'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-prime-slider .bdt-ep-scroll-to-section a:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'scroll_to_top_hover_background',
			[ 
				'label'     => esc_html__( 'Background', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ep-scroll-to-section a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'scroll_to_top_hover_border_color',
			[ 
				'label'     => esc_html__( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 
					'scroll_to_top_border_border!' => '',
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ep-scroll-to-section a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_social_icon',
			[ 
				'label'     => esc_html__( 'Social Icon', 'bdthemes-prime-slider' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_social_icon' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_social_icon_style' );

		$this->start_controls_tab(
			'tab_social_icon_normal',
			[ 
				'label' => esc_html__( 'Normal', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'social_icon_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-social-icon i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-social-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'      => 'social_icon_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-social-icon a',
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'        => 'social_icon_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-social-icon a',
			]
		);

		$this->add_control(
			'social_icon_padding',
			[ 
				'label'      => esc_html__( 'Padding', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-social-icon a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'social_icon_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-social-icon a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'social_icon_shadow',
				'selector' => '{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-social-icon a',
			]
		);

		$this->add_responsive_control(
			'social_icon_size',
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
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-social-icon a' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'social_icons_position',
			[ 
				'label'   => esc_html__( 'Position', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'bottom-center',
				'options' => prime_slider_position(),
			]
		);

		$this->add_responsive_control(
			'social_icons_horizontal_position',
			[ 
				'label'     => __( 'Horizontal Spacing', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-social-icon' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'social_icons_vertical_spacing',
			[ 
				'label'     => __( 'Vertical Spacing', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => -100,
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-social-icon' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'social_icons_spacing',
			[ 
				'label'     => __( 'Icon Spacing', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-social-icon a' => 'margin: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'social_icon_tooltip',
			[ 
				'label'   => esc_html__( 'Show Tooltip', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'tooltip_position',
			[ 
				'label'     => esc_html__( 'Tooltip Position', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'top',
				'options'   => [ 
					'left'   => esc_html__( 'Left', 'bdthemes-prime-slider' ),
					'right'  => esc_html__( 'Right', 'bdthemes-prime-slider' ),
					'top'    => esc_html__( 'Top', 'bdthemes-prime-slider' ),
					'bottom' => esc_html__( 'Bottom', 'bdthemes-prime-slider' ),
				],
				'condition' => [ 
					'social_icon_tooltip' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_social_icon_hover',
			[ 
				'label' => esc_html__( 'Hover', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'social_icon_hover_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-social-icon a:hover i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-social-icon a:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'      => 'social_icon_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-social-icon a:hover',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'icon_hover_border_color',
			[ 
				'label'     => esc_html__( 'Border Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 
					'social_icon_border_border!' => '',
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-social-icon a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[ 
				'label'      => __( 'Navigation', 'bdthemes-element-pack' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [ 
					'relation' => 'or',
					'terms'    => [ 
						[ 
							'name'  => 'show_navigation_arrows',
							'value' => 'yes'
						],
						[ 
							'name'  => 'show_navigation_dots',
							'value' => 'yes'
						],
					]
				]
			]
		);

		$this->add_control(
			'navigation_style_type',
			[ 
				'label'   => esc_html__( 'Select Navigation Style', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [ 
					'default' => esc_html__( 'Default', 'bdthemes-prime-slider' ),
					'style1'  => esc_html__( 'Style 1', 'bdthemes-prime-slider' ),
					'style2'  => esc_html__( 'Style 2', 'bdthemes-prime-slider' ),
					'style3'  => esc_html__( 'Style 3', 'bdthemes-prime-slider' ),
					'style4'  => esc_html__( 'Style 4', 'bdthemes-prime-slider' ),
				],
			]
		);

		$this->add_control(
			'heading_style_arrows',
			[ 
				'label'     => __( 'Arrows', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->start_controls_tabs( 'tabs_ps_nav_arrows_style' );

		$this->start_controls_tab(
			'ps_arrows_normal',
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
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-previous i, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-next i, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-previous .bdt-slider-nav-text, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-next .bdt-slider-nav-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-previous svg, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-next svg'                                                                                                                                                       => 'fill: {{VALUE}};',
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-previous:before, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-next:before'                                                                                                                                                 => 'background: {{VALUE}};',
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
				'label'     => __( 'Background', 'bdthemes-prime-slider' ),
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-next, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-previous',
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'      => 'arrows_border',
				'selector'  => '{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-next, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-previous',
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'arrows_border_radius',
			[ 
				'label'      => __( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-next, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-previous' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [ 
					'show_navigation_arrows'       => [ 'yes' ],
					'border_radius_advanced_show!' => 'yes',
				],
			]
		);

		$this->add_control(
			'border_radius_advanced_show',
			[ 
				'label'     => __( 'Advanced Radius', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'border_radius_advanced',
			[ 
				'label'       => esc_html__( 'Radius', 'bdthemes-element-pack' ),
				'description' => sprintf( __( 'For example: <b>%1s</b> or Go <a href="%2s" target="_blank">this link</a> and copy and paste the radius value.', 'bdthemes-element-pack' ), '30% 70% 70% 30% / 30% 30% 70% 70%', 'https://9elements.github.io/fancy-border-radius/' ),
				'type'        => Controls_Manager::TEXT,
				'size_units'  => [ 'px', '%' ],
				'separator'   => 'after',
				'default'     => '30% 70% 70% 30% / 30% 30% 70% 70%',
				'selectors'   => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-next, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-previous' => 'border-radius: {{VALUE}};',
				],
				'condition'   => [ 
					'border_radius_advanced_show' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_padding',
			[ 
				'label'      => esc_html__( 'Padding', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-next, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-previous' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [ 
					'show_navigation_arrows' => [ 'yes' ],
					'navigation_style_type!' => 'style3',
				],
			]
		);

		$this->add_control(
			'arrows_size',
			[ 
				'label'     => __( 'Arrows Size', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 5,
						'max' => 50,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-previous svg, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-next svg'                                                                                                                                                       => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-previous i, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-next i, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-previous .bdt-slider-nav-text, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-next .bdt-slider-nav-text' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
					'navigation_style_type!' => 'style3',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'ps_arrows_hover',
			[ 
				'label'     => __( 'Hover', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'arrows_color_hover',
			[ 
				'label'     => __( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-previous:hover i, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-next:hover i, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-previous .bdt-slider-nav-text, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-next .bdt-slider-nav-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-previous:hover svg, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-next:hover svg'                                                                                                                                                       => 'fill: {{VALUE}};',
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-previous:hover:before, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-next:hover:before'                                                                                                                                                 => 'background: {{VALUE}};',
				],
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
					'navigation_style_type!' => 'style4',
				],
			]
		);

		$this->add_control(
			'arrows_style4_color_hover',
			[ 
				'label'     => __( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-previous:hover .bdt-slider-nav-text, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-next:hover .bdt-slider-nav-text' => 'color: {{VALUE}};',
				],
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
					'navigation_style_type'  => 'style4',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'      => 'arrows_background_hover',
				'label'     => __( 'Background', 'bdthemes-prime-slider' ),
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-next:hover, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-previous:hover',
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'arrows_border_color_hover',
			[ 
				'label'     => __( 'Border Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-previous:hover, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-next:hover' => 'border-color: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'heading_style_dots',
			[ 
				'label'     => __( 'Dots', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
			]
		);

		$this->start_controls_tabs( 'tabs_dots_style' );

		$this->start_controls_tab(
			'dots_normal_tab',
			[ 
				'label'     => esc_html__( 'Normal', 'bdthemes-element-pack' ),
				'condition' => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'dots_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-ps-dotnav li a, {{WRAPPER}} .bdt-prime-slider .bdt-ps-dotnav li a:before' => 'background-color: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'dots_size_height',
			[ 
				'label'     => __( 'Dots Height', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 5,
						'max' => 50,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-custom .bdt-ps-dotnav li a' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'dots_size_width',
			[ 
				'label'     => __( 'Dots Width', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 5,
						'max' => 50,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-custom .bdt-ps-dotnav li a' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'     => 'dots_border',
				'label'    => esc_html__( 'Border', 'bdthemes-element-pack' ),
				'selector' => '{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-custom .bdt-ps-dotnav li a',
			]
		);

		$this->add_control(
			'dots_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'bdthemes-element-pack' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-custom .bdt-ps-dotnav li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'dots_hover_tab',
			[ 
				'label'     => esc_html__( 'Hover', 'bdthemes-element-pack' ),
				'condition' => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'dots_hover_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-custom .bdt-ps-dotnav li a:hover, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-custom .bdt-ps-dotnav li a:hover:before' => 'background-color: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'dots_border_hover_color',
			[ 
				'label'     => __( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-custom .bdt-ps-dotnav li a:hover' => 'border-color: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'dots_active_tab',
			[ 
				'label'     => esc_html__( 'Active', 'bdthemes-element-pack' ),
				'condition' => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'active_dot_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-custom .bdt-ps-dotnav li.bdt-active a, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-custom .bdt-ps-dotnav li.bdt-active a:before' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-custom .bdt-ps-dotnav li.bdt-active a:after'                                                                                         => 'border-color: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'dots_border_active_color',
			[ 
				'label'     => __( 'Border Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-custom .bdt-ps-dotnav li.bdt-active a' => 'border-color: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'dots_active_size_height',
			[ 
				'label'     => __( 'Dots Height', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 5,
						'max' => 50,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-custom .bdt-ps-dotnav li.bdt-active a' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'show_navigation_dots'  => [ 'yes' ],
					'navigation_style_type' => 'style3',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	public function render_header() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'slider', 'class', 'bdt-prime-slider-custom' );

		$ratio = ( $settings['slider_size_ratio']['width'] && $settings['slider_size_ratio']['height'] ) ? $settings['slider_size_ratio']['width'] . ":" . $settings['slider_size_ratio']['height'] : '16:9';

		$this->add_render_attribute(
			[ 
				'slideshow' => [ 
					'bdt-slideshow' => [ 
						wp_json_encode( [ 
							"animation"         => $settings["slider_animations"],
							"ratio"             => $ratio,
							"min-height"        => ( $settings["slider_min_height"]["size"] ) ? $settings["slider_min_height"]["size"] : 480,
							"autoplay"          => ( $settings["autoplay"] ) ? true : false,
							"autoplay-interval" => $settings["autoplay_interval"],
							"pause-on-hover"    => ( "yes" === $settings["pause_on_hover"] ) ? true : false,
							"velocity"          => ( $settings["velocity"]["size"] ) ? $settings["velocity"]["size"] : 1,
							"finite"            => ( $settings["finite"] ) ? false : true,
						] )
					]
				]
			]
		);

		?>
		<div class="bdt-prime-slider">
			<div <?php $this->print_render_attribute_string( 'slider' ); ?>>
				<?php if ( $settings['scroll_to_section'] && $settings['section_id'] ) : ?>
					<div class="bdt-ep-scroll-to-section bdt-position-bottom-center">
						<a href="<?php echo esc_url( $settings['section_id'] ); ?>" bdt-scroll>
							<span class="bdt-ep-scroll-to-section-icon">

								<?php Icons_Manager::render_icon( $settings['slider_scroll_to_section_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] ); ?>

							</span>
						</a>
					</div>
				<?php endif; ?>
				<div class="bdt-position-relative bdt-visible-toggle" <?php $this->print_render_attribute_string( 'slideshow' ); ?>>

					<ul class="bdt-slideshow-items">

						<?php
	}

	public function render_navigation_arrows() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'prev_position', 'class', 'bdt-prime-slider-previous bdt-position-' . $settings['arrows_prev_position'] );

		$this->add_render_attribute( 'next_position', 'class', 'bdt-prime-slider-next bdt-position-' . $settings['arrows_next_position'] );

		?>

						<?php if ( $settings['show_navigation_arrows'] ) : ?>


							<a <?php $this->print_render_attribute_string( 'prev_position' ); ?> href="#"
								bdt-slideshow-item="previous">
								<?php Icons_Manager::render_icon( $settings['nav_arrows_prev_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] ); ?>
								<span class="bdt-slider-nav-text">
									<?php if ( ! empty( $settings['nav_prev_custom_text'] ) ) : ?>
										<?php echo esc_html( $settings['nav_prev_custom_text'] ); ?>
									<?php else : ?>
										<?php esc_html_e( 'Prev', 'bdthemes-prime-slider' ) ?>
									<?php endif; ?>
								</span>
							</a>

							<a <?php $this->print_render_attribute_string( 'next_position' ); ?> href="#" bdt-slideshow-item="next">
								<span class="bdt-slider-nav-text">
									<?php if ( ! empty( $settings['nav_next_custom_text'] ) ) : ?>
										<?php echo esc_html( $settings['nav_next_custom_text'] ); ?>
									<?php else : ?>
										<?php esc_html_e( 'Next', 'bdthemes-prime-slider' ) ?>
									<?php endif; ?>
								</span>
								<?php Icons_Manager::render_icon( $settings['nav_arrows_next_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] ); ?>
							</a>


						<?php endif; ?>

						<?php
	}

	public function render_navigation_dots() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'dots-position', 'class', 'bdt-slideshow-nav bdt-dotnav bdt-ps-dotnav bdt-position-' . $settings['dots_hv_position'] );

		if ( 'center-left' == $settings['dots_hv_position'] or 'center-right' == $settings['dots_hv_position'] ) {
			$this->add_render_attribute( 'dots-position', 'class', 'bdt-dotnav-vertical' );
		}

		?>

						<?php if ( $settings['show_navigation_dots'] ) : ?>
							<ul <?php $this->print_render_attribute_string( 'dots-position' ); ?>></ul>
						<?php endif; ?>

						<?php
	}

	public function render_social_link( $class = [] ) {
		$settings = $this->get_active_settings();

		if ( '' == $settings['show_social_icon'] ) {
			return;
		}

		$position = $settings['tooltip_position'];

		$this->add_render_attribute( 'social-icon', 'class', 'bdt-prime-slider-social-icon' );
		$this->add_render_attribute( 'social-icon', 'class', $class );

		$this->add_render_attribute( 'social-icon', 'class', 'bdt-position-' . $settings['social_icons_position'] );

		?>

						<div <?php $this->print_render_attribute_string( 'social-icon' ); ?>>

							<?php
							foreach ( $settings['social_link_list'] as $link ) :
								$tooltip = ( 'yes' == $settings['social_icon_tooltip'] ) ? ' title="' . esc_attr( $link['social_link_title'] ) . '" bdt-tooltip="pos: ' . $position . '"' : ''; ?>

								<a href="<?php echo esc_url( $link['social_link'] ); ?>" target="_blank" <?php echo wp_kses_post( $tooltip ); ?>>
									<?php Icons_Manager::render_icon( $link['social_icon'], [ 'aria-hidden' => 'true', 'class' => 'fa-fw' ] ); ?>
								</a>
							<?php endforeach; ?>
						</div>

						<?php
	}

	public function render_footer() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'navigation', 'class', 'bdt-custom-navigation bdt-ps-navigation-style-' . $settings['navigation_style_type'] );


		?>

					</ul>
					<div <?php $this->print_render_attribute_string( 'navigation' ); ?>>
						<?php $this->render_navigation_arrows(); ?>
						<?php $this->render_navigation_dots(); ?>
					</div>
				</div>
				<?php $this->render_social_link(); ?>

			</div>
		</div>
		<?php
	}

	public function render_item_content( $slide_content ) {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'slide_content_animate', 'class', 'bdt-prime-slider-content' );

		?>

		<?php if ( ! empty( $slide_content['template_id'] ) ) : ?>

			<?php echo Prime_Slider_Loader::elementor()->frontend->get_builder_content_for_display( $slide_content['template_id'] ); ?>

		<?php else : ?>
			<div class="bdt-alert-warning" bdt-alert>
				<a class="bdt-alert-close" bdt-close></a>
				<p>
					<?php esc_html_e( 'Please Select Template From Sliders Section. ', 'bdthemes-prime-slider' ); ?>
				</p>
			</div>
		<?php endif; ?>

		<?php echo prime_slider_template_edit_link( $slide_content['template_id'] ); ?>

		<?php
	}

	public function render_slides_loop() {
		$settings = $this->get_settings_for_display();

		foreach ( $settings['sliders'] as $slide ) : ?>

			<li class="bdt-slideshow-item">

				<?php

				$this->render_item_content( $slide );

				?>
			</li>

		<?php endforeach;
	}

	public function render() {
		$this->render_header();
		$this->render_slides_loop();
		$this->render_footer();
	}
}
