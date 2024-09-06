<?php
namespace PrimeSliderPro\Modules\Flexure\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use PrimeSliderPro\Utils;

use PrimeSlider\Traits\Global_Widget_Controls;

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

/**
 * Class Post Slider
 */
class Flexure extends Widget_Base {

	use Global_Widget_Controls;

	public function get_name() {
		return 'prime-slider-flexure';
	}

	public function get_title() {
		return BDTPS . __( 'Flexure', 'bdthemes-prime-slider' );
	}

	public function get_icon() {
		return 'bdt-widget-icon ps-wi-flexure';
	}

	public function get_categories() {
		return [ 'prime-slider-pro' ];
	}

	public function get_keywords() {
		return [ 'prime slider', 'slider', 'flexure', 'prime' ];
	}

	public function get_style_depends() {
		return [ 'ps-flexure', 'prime-slider-font' ];
	}

	public function get_script_depends() {
		$reveal_effects = prime_slider_option( 'reveal-effects', 'prime_slider_other_settings', 'off' );
		if ( 'on' === $reveal_effects ) {
			return [ 'anime', 'revealFx', 'ps-flexure' ];
		} else {
			return [ 'ps-flexure' ];
		}
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/swPVYPWIZXI';
	}

	protected function register_controls() {
		$reveal_effects = prime_slider_option( 'reveal-effects', 'prime_slider_other_settings', 'off' );
		$this->start_controls_section(
			'section_tabs_item',
			[ 
				'label' => __( 'Sliders', 'bdthemes-prime-slider' ),
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'tabs_slider_items' );

		$repeater->start_controls_tab(
			'tab_slider_content',
			[ 
				'label' => esc_html__( 'Content', 'bdthemes-prime-slider' ),
			]
		);

		$repeater->add_control(
			'ps_flexure_title',
			[ 
				'label'       => __( 'Title', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => __( 'Tab Title', 'bdthemes-prime-slider' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'slide_image',
			[ 
				'label'   => esc_html__( 'Background Image', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [ 
					'url' => BDTPS_CORE_ASSETS_URL . 'images/slide/item-' . rand( 1, 6 ) . '.jpg',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'tab_slider_Optional',
			[ 
				'label' => esc_html__( 'Optional', 'bdthemes-prime-slider' ),
			]
		);

		$repeater->add_control(
			'title_link',
			[ 
				'label'         => esc_html__( 'Title Link', 'bdthemes-prime-slider' ),
				'type'          => Controls_Manager::URL,
				'default'       => [ 'url' => '' ],
				'show_external' => false,
				'dynamic'       => [ 'active' => true ],
				'condition'     => [ 
					'ps_flexure_title!' => ''
				]
			]
		);

		$repeater->add_control(
			'ps_flexure_content',
			[ 

				'type'    => Controls_Manager::WYSIWYG,
				'dynamic' => [ 'active' => true ],
				'default' => __( 'Lorem ipsum dolor sit amet consect voluptate repell endus kilo gram magni illo ea animi.', 'bdthemes-prime-slider' ),
			]
		);

		$repeater->end_controls_tab();
		$repeater->end_controls_tabs();

		$this->add_control(
			'ps_slider',
			[ 
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [ 
					[ 
						'ps_flexure_title' => __( 'Kanzu', 'bdthemes-prime-slider' ),
						'slide_image'      => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/img-1.svg' ]
					],
					[ 
						'ps_flexure_title' => __( 'Colza', 'bdthemes-prime-slider' ),
						'slide_image'      => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/img-2.svg' ]
					],
					[ 
						'ps_flexure_title' => __( 'Voxey', 'bdthemes-prime-slider' ),
						'slide_image'      => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/img-3.svg' ]
					],
					[ 
						'ps_flexure_title' => __( 'Wallow', 'bdthemes-prime-slider' ),
						'slide_image'      => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/img-1.svg' ]
					],
					[ 
						'ps_flexure_title' => __( 'Vibrant', 'bdthemes-prime-slider' ),
						'slide_image'      => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/img-2.svg' ]
					],
					[ 
						'ps_flexure_title' => __( 'Massive', 'bdthemes-prime-slider' ),
						'slide_image'      => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/img-3.svg' ]
					],
				],
				'title_field' => '{{{ ps_flexure_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_layout_ps_slider',
			[ 
				'label' => esc_html__( 'Additional Settings', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'skin_ps_slider_min_height',
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
					'{{WRAPPER}} .bdt-prime-slider-flexure, {{WRAPPER}} .bdt-ps-flexure-item' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'columns',
			[ 
				'label'          => esc_html__( 'Columns', 'bdthemes-element-pack' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '3',
				'tablet_default' => '3',
				'mobile_default' => '2',
				'options'        => [ 
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[ 
				'name'      => 'thumbnail_size',
				'label'     => esc_html__( 'Image Size', 'bdthemes-prime-slider' ),
				'exclude'   => [ 'custom' ],
				'default'   => 'full',
				'separator' => 'before'
			]
		);

		//Global background settings Controls
		$this->register_background_settings( '.bdt-prime-slider .bdt-slideshow-item>.bdt-ps-slide-img' );

		$this->add_control(
			'ps_flexure_event',
			[ 
				'label'     => __( 'Select Event ', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'mouseover',
				'options'   => [ 
					'click'     => __( 'Click', 'bdthemes-prime-slider' ),
					'mouseover' => __( 'Hover', 'bdthemes-prime-slider' ),
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'_active_item',
			[ 
				'label'       => __( 'Active Item', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::NUMBER,
				'default'     => 1,
				'description' => __( 'Type your item number.', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'show_title',
			[ 
				'label'     => esc_html__( 'Show Title', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'title_tags',
			[ 
				'label'     => __( 'Title HTML Tag', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'h2',
				'options'   => prime_slider_title_tags(),
				'condition' => [ 
					'show_title' => 'yes'
				]
			]
		);

		$this->add_control(
			'title_position',
			[ 
				'label'     => __( 'Title Position', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => [ 
					'top'    => __( 'Top', 'bdthemes-prime-slider' ),
					'center' => __( 'Center', 'bdthemes-prime-slider' ),
				],
				'condition' => [ 
					'show_title' => 'yes'
				]
			]
		);

		$this->add_control(
			'show_content',
			[ 
				'label'     => esc_html__( 'Show Text', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'show_social_share',
			[ 
				'label'   => esc_html__( 'Show Social Share', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'title_count_hide',
			[ 
				'label'     => esc_html__( 'Hide Title Count Text', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-flexure .bdt-ps-flexure-item .bdt-ps-flexure-title:before' => 'display: none;',
				],
			]
		);

		$this->add_control(
			'box_image_effect',
			[ 
				'label' => __( 'Image Effect', 'bdthemes-prime-slider' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'box_image_effect_select',
			[ 
				'label'     => __( 'Title HTML Tag', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'effect-1',
				'options'   => [ 
					'effect-1' => 'Effect 01',
					'effect-2' => 'Effect 02',
				],
				'condition' => [ 
					'box_image_effect' => 'yes'
				]
			]
		);

		$this->add_control(
			'show_navigation_arrows',
			[ 
				'label'     => esc_html__( 'Show Arrows', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'show_slider_pagination',
			[ 
				'label'   => esc_html__( 'Show Fraction', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_social_link',
			[ 
				'label'     => __( 'Social Share', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_social_share' => 'yes',
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'social_link_title',
			[ 
				'label' => __( 'Title', 'bdthemes-prime-slider' ),
				'type'  => Controls_Manager::TEXT,
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

		$this->add_control(
			'social_link_list',
			[ 
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [ 
					[ 
						'social_link'       => __( 'http://www.facebook.com/bdthemes/', 'bdthemes-prime-slider' ),
						'social_link_title' => 'Fb',
					],
					[ 
						'social_link'       => __( 'http://www.twitter.com/bdthemes/', 'bdthemes-prime-slider' ),
						'social_link_title' => 'Tw',
					],
					[ 
						'social_link'       => __( 'http://www.instagram.com/bdthemes/', 'bdthemes-prime-slider' ),
						'social_link_title' => 'In',
					],
				],
				'title_field' => '{{{ social_link_title }}}',
			]
		);

		$this->end_controls_section();

		/**
		 * Reveal Effects
		 */
		if ( 'on' === $reveal_effects ) {
			$this->register_reveal_effects();
		}

		//Style
		$this->start_controls_section(
			'section_style_wrapper',
			[ 
				'label' => esc_html__( 'Wrapper', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'overlay_color',
			[ 
				'label'     => esc_html__( 'Overlay Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-flexure .bdt-ps-flexure-content:before' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[ 
				'label'     => esc_html__( 'Title', 'bdthemes-prime-slider' ),
				'tab'       => Controls_Manager::TAB_STYLE,
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
					'{{WRAPPER}} .bdt-prime-slider-flexure .bdt-ps-flexure-item .bdt-ps-flexure-title, {{WRAPPER}} .bdt-prime-slider-flexure .bdt-ps-flexure-item .bdt-ps-flexure-title a' => '-webkit-text-stroke: 1px {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_hover_color',
			[ 
				'label'     => esc_html__( 'Hover Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-flexure .bdt-ps-flexure-item:hover .bdt-ps-flexure-title, {{WRAPPER}} .bdt-prime-slider-flexure .bdt-ps-flexure-item:hover .bdt-ps-flexure-title a' => 'color: {{VALUE}}; -webkit-text-stroke: 1px {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_active_color',
			[ 
				'label'     => esc_html__( 'Active Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-flexure .bdt-ps-flexure-item.active .bdt-ps-flexure-title, {{WRAPPER}} .bdt-prime-slider-flexure .bdt-ps-flexure-item.active .bdt-ps-flexure-title a' => 'color: {{VALUE}}; -webkit-text-stroke: 1px {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-flexure .bdt-ps-flexure-item .bdt-ps-flexure-title, {{WRAPPER}} .bdt-prime-slider-flexure .bdt-ps-flexure-item .bdt-ps-flexure-title a',
			]
		);

		$this->add_responsive_control(
			'title_vertical_offset',
			[ 
				'label'     => esc_html__( 'Vertical Offset(%)', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-flexure .bdt-ps-flexure-item .bdt-ps-flexure-description' => 'top: {{SIZE}}%',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_description',
			[ 
				'label'     => esc_html__( 'Text', 'bdthemes-prime-slider' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_content' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'description_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-flexure .bdt-ps-flexure-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_Width',
			[ 
				'label'     => esc_html__( 'Width', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 100,
						'max' => 1200,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-flexure .bdt-ps-flexure-text-wrapper' => 'width: {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_vertical_offset',
			[ 
				'label'     => esc_html__( 'Vertical Offset', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 100,
						'max' => 500,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-flexure .bdt-ps-flexure-text-wrapper' => 'bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-flexure .bdt-ps-flexure-text',
			]
		);

		$this->add_control(
			'description_divider_heading',
			[ 
				'label'     => esc_html__( 'Divider', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_control(
			'description_line_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-flexure .bdt-ps-flexure-text-wrapper .bdt-custom-divider'        => 'background: linear-gradient(90deg, rgba(255, 255, 255, 0), {{VALUE}}, rgba(255, 255, 255, 0));',
					'{{WRAPPER}} .bdt-prime-slider-flexure .bdt-ps-flexure-text-wrapper .bdt-custom-divider:before' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'description_divider_text_color',
			[ 
				'label'     => esc_html__( 'Text Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-flexure .bdt-ps-flexure-text-wrapper .bdt-custom-divider:before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'description_divider_shadow_color',
			[ 
				'label'     => esc_html__( 'Shadow Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-flexure .bdt-ps-flexure-text-wrapper .bdt-custom-divider:before' => '--box-shadow-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_social_icon',
			[ 
				'label'     => esc_html__( 'Social Share', 'bdthemes-prime-slider' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_social_share' => 'yes',
				],
			]
		);

		$this->add_control(
			'social_icon_text_color',
			[ 
				'label'     => esc_html__( 'Text Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-social-icon h3' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'social_icon_text_typography',
				'selector' => '{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-social-icon h3',
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
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-social-icon a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'social_icon_background',
				'selector' => '{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-social-icon a',
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

		$this->add_responsive_control(
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

		$this->add_responsive_control(
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
			'social_icon_spacing',
			[ 
				'label'     => esc_html__( 'Spacing', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-social-icon a' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'social_icon_size',
				'selector' => '{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-social-icon a',
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
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-social-icon a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'social_icon_hover_background',
				'selector' => '{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-social-icon a:hover',
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
				'label' => __( 'Navigation', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'pagination_heading',
			[ 
				'label'     => __( 'FRACTION', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [ 
					'show_slider_pagination' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'pagination_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-flexure .bdt-ps-dotnav span' => 'color: {{VALUE}}',
				],
				'condition' => [ 
					'show_slider_pagination' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'pagination_active_color',
			[ 
				'label'     => __( 'Active Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-flexure .bdt-ps-dotnav li a' => 'color: {{VALUE}}',
				],
				'condition' => [ 
					'show_slider_pagination' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'pagination_divider_color',
			[ 
				'label'     => __( 'Divider Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-flexure .bdt-ps-dotnav span:before' => 'background: linear-gradient(90deg, rgba(255, 255, 255, 0), {{VALUE}}, rgba(255, 255, 255, 0));',
				],
				'condition' => [ 
					'show_slider_pagination' => [ 'yes' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'      => 'pagination_typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'selector'  => '{{WRAPPER}} .bdt-prime-slider-flexure .bdt-ps-dotnav li a, {{WRAPPER}} .bdt-prime-slider-flexure .bdt-ps-dotnav span',
				'condition' => [ 
					'show_slider_pagination' => [ 'yes' ],
				],
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
				'separator' => 'before'
			]
		);

		$this->add_control(
			'nav_arrows_icon',
			[ 
				'label'     => esc_html__( 'Arrows Icon', 'bdthemes-element-pack' ) . BDTPS_PRO_NC,
				'type'      => Controls_Manager::SELECT,
				'default'   => '0',
				'options'   => [ 
					'0'        => esc_html__( 'Default', 'bdthemes-element-pack' ),
					'1'        => esc_html__( 'Style 1', 'bdthemes-element-pack' ),
					'2'        => esc_html__( 'Style 2', 'bdthemes-element-pack' ),
					'3'        => esc_html__( 'Style 3', 'bdthemes-element-pack' ),
					'4'        => esc_html__( 'Style 4', 'bdthemes-element-pack' ),
					'5'        => esc_html__( 'Style 5', 'bdthemes-element-pack' ),
					'6'        => esc_html__( 'Style 6', 'bdthemes-element-pack' ),
					'7'        => esc_html__( 'Style 7', 'bdthemes-element-pack' ),
					'8'        => esc_html__( 'Style 8', 'bdthemes-element-pack' ),
					'9'        => esc_html__( 'Style 9', 'bdthemes-element-pack' ),
					'10'       => esc_html__( 'Style 10', 'bdthemes-element-pack' ),
					'11'       => esc_html__( 'Style 11', 'bdthemes-element-pack' ),
					'12'       => esc_html__( 'Style 12', 'bdthemes-element-pack' ),
					'13'       => esc_html__( 'Style 13', 'bdthemes-element-pack' ),
					'14'       => esc_html__( 'Style 14', 'bdthemes-element-pack' ),
					'15'       => esc_html__( 'Style 15', 'bdthemes-element-pack' ),
					'16'       => esc_html__( 'Style 16', 'bdthemes-element-pack' ),
					'17'       => esc_html__( 'Style 17', 'bdthemes-element-pack' ),
					'18'       => esc_html__( 'Style 18', 'bdthemes-element-pack' ),
					'circle-1' => esc_html__( 'Style 19', 'bdthemes-element-pack' ),
					'circle-2' => esc_html__( 'Style 20', 'bdthemes-element-pack' ),
					'circle-3' => esc_html__( 'Style 21', 'bdthemes-element-pack' ),
					'circle-4' => esc_html__( 'Style 22', 'bdthemes-element-pack' ),
					'square-1' => esc_html__( 'Style 23', 'bdthemes-element-pack' ),
				],
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->start_controls_tabs( 'tabs_arrows_style' );

		$this->start_controls_tab(
			'tab_arrows_normal',
			[ 
				'label'     => esc_html__( 'Normal', 'bdthemes-prime-slider' ),
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
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-previous svg, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-next svg, {{WRAPPER}} .bdt-navigation-arrows .bdt-slidenav-previous i, {{WRAPPER}} .bdt-navigation-arrows .bdt-slidenav-next i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-next:before, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-previous:before'                                                                                                                 => 'background: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'navigation_arrows_background',
			[ 
				'label'     => __( 'Background', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-navigation-arrows .bdt-slidenav-previous, {{WRAPPER}} .bdt-navigation-arrows .bdt-slidenav-next' => 'background: {{VALUE}};',
				],
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
					'nav_arrows_icon!'       => '0',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'        => 'navigation_arrows_border',
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .bdt-navigation-arrows .bdt-slidenav-previous, {{WRAPPER}} .bdt-navigation-arrows .bdt-slidenav-next',
			]
		);

		$this->add_responsive_control(
			'navigation_arrows_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-navigation-arrows .bdt-slidenav-previous, {{WRAPPER}} .bdt-navigation-arrows .bdt-slidenav-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'navigation_arrows_padding',
			[ 
				'label'      => esc_html__( 'Padding', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-navigation-arrows .bdt-slidenav-previous, {{WRAPPER}} .bdt-navigation-arrows .bdt-slidenav-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'      => 'navigation_arrows_typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'selector'  => '{{WRAPPER}} .bdt-navigation-arrows .bdt-slidenav-previous i, {{WRAPPER}} .bdt-navigation-arrows .bdt-slidenav-next i',
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
					'nav_arrows_icon!'       => '0',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_arrows_hover',
			[ 
				'label'     => esc_html__( 'Hover', 'bdthemes-prime-slider' ),
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
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-previous:hover svg, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-next:hover svg, {{WRAPPER}} .bdt-navigation-arrows .bdt-slidenav-previous:hover i, {{WRAPPER}} .bdt-navigation-arrows .bdt-slidenav-next:hover i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-next:before, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-previous:before'                                                                                                                                         => 'background: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'navigation_arrows_hover_background',
			[ 
				'label'     => __( 'Background', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-navigation-arrows .bdt-slidenav-previous:hover, {{WRAPPER}} .bdt-navigation-arrows .bdt-slidenav-next:hover' => 'background: {{VALUE}};',
				],
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
					'nav_arrows_icon!'       => '0',
				],
			]
		);

		$this->add_control(
			'navigation_arrows_border_hover_color',
			[ 
				'label'     => esc_html__( 'Border Color', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 
					'navigation_arrows_border_border!' => '',
					'show_navigation_arrows'           => [ 'yes' ],
					'nav_arrows_icon!'                 => '0',
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-navigation-arrows .bdt-slidenav-previous:hover, {{WRAPPER}} .bdt-navigation-arrows .bdt-slidenav-next:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	public function activeItem( $active_item, $totalItem ) {
		$active_item = (int) $active_item;
		return $active_item = ( $active_item <= 0 || $active_item > $totalItem ? 1 : $active_item );
	}

	public function render() {
		$settings = $this->get_settings_for_display();

		if ( $settings['ps_flexure_event'] ) {
			$hoverBoxEvent = $settings['ps_flexure_event'];
		} else {
			$hoverBoxEvent = false;
		}

		if ( 'yes' == $settings['box_image_effect'] and 'effect-1' == $settings['box_image_effect_select'] ) {
			$this->add_render_attribute( 'ps-flexure', 'class', 'bdt-ps-flexure-image-effect bdt-image-effect-1' );
		} elseif ( 'yes' == $settings['box_image_effect'] and 'effect-2' == $settings['box_image_effect_select'] ) {
			$this->add_render_attribute( 'ps-flexure', 'class', 'bdt-ps-flexure-image-effect bdt-image-effect-2' );
		}

		$this->add_render_attribute( 'prime-slider', 'class', 'bdt-prime-slider' );

		/**
		 * Reveal Effects
		 */
		$this->reveal_effects_attr( 'ps-flexure' );

		$this->add_render_attribute(
			[ 
				'ps-flexure' => [ 
					'id'            => 'bdt-prime-slider-flexure-' . $this->get_id(),
					'class'         => 'bdt-prime-slider-flexure',
					'data-settings' => [ 
						wp_json_encode( array_filter( [ 
							'box_id'      => 'bdt-prime-slider-flexure-' . $this->get_id(),
							'mouse_event' => $hoverBoxEvent,
						] ) )
					]
				]
			]
		);

		?>
		<div <?php $this->print_render_attribute_string( 'prime-slider' ); ?>>
			<div <?php $this->print_render_attribute_string( 'ps-flexure' ); ?>>

				<?php $this->box_content(); ?>
				<?php $this->box_items(); ?>

				<?php $this->render_social_link(); ?>

			</div>
		</div>

		<?php
	}

	public function render_social_link( $class = [] ) {
		$settings = $this->get_active_settings();

		if ( '' == $settings['show_social_share'] ) {
			return;
		}

		$this->add_render_attribute( 'social-icon', 'class', 'bdt-prime-slider-social-icon reveal-muted' );
		$this->add_render_attribute( 'social-icon', 'class', $class );

		?>

		<div <?php $this->print_render_attribute_string( 'social-icon' ); ?>>

			<h3>
				<?php echo esc_html( 'Follow Us', 'bdthemes-prime-slider' ) ?>
			</h3>

			<?php foreach ( $settings['social_link_list'] as $link ) : ?>

				<a href="<?php echo esc_url( $link['social_link'] ); ?>" target="_blank">
					<span class="bdt-social-share-title">
						<?php echo esc_html( $link['social_link_title'] ); ?>
					</span>
				</a>

			<?php endforeach; ?>

		</div>

		<?php
	}

	public function render_navigation_arrows() {
		$settings = $this->get_settings_for_display();

		?>

		<?php if ( $settings['show_navigation_arrows'] ) : ?>
			<div class="bdt-navigation-arrows reveal-muted">

				<?php if ( $settings['nav_arrows_icon'] == '0' ) : ?>
					<a class="bdt-prime-slider-previous" href="#" bdt-slidenav-previous bdt-slider-item="previous"></a>
					<a class="bdt-prime-slider-next" href="#" bdt-slidenav-next bdt-slider-item="next"></a>
				<?php endif; ?>

				<?php if ( $settings['nav_arrows_icon'] != '0' ) : ?>
					<a href="" class="bdt-navigation-prev bdt-slidenav-previous" bdt-slider-item="previous">
						<i class="ps-wi-arrow-left-<?php echo esc_attr( $settings['nav_arrows_icon'] ); ?>" aria-hidden="true"></i>
					</a>
					<a href="" class="bdt-navigation-next bdt-slidenav-next" bdt-slider-item="next">
						<i class="ps-wi-arrow-right-<?php echo esc_attr( $settings['nav_arrows_icon'] ); ?>" aria-hidden="true"></i>
					</a>
				<?php endif; ?>

			</div>
		<?php endif; ?>

		<?php
	}

	public function render_slider_pagination() {
		$settings = $this->get_settings_for_display();

		?>

		<?php if ( $settings['show_slider_pagination'] ) : ?>

			<ul class="bdt-ps-dotnav bdt-position-bottom-left reveal-muted">
				<?php $slide_index = 1;
				foreach ( $settings['ps_slider'] as $slide ) : ?>
					<li bdt-slider-item="<?php echo esc_attr(( $slide_index - 1 )); ?>"
						data-label="<?php echo esc_html(str_pad( $slide_index, 2, '0', STR_PAD_LEFT )); ?>"><a href="#">
							<?php echo esc_html(str_pad( $slide_index, 2, '0', STR_PAD_LEFT )); ?>
						</a></li>
					<?php $slide_index++; endforeach; ?>

				<span>
					<?php echo esc_html(str_pad( $slide_index - 1, 2, '0', STR_PAD_LEFT )); ?>
				</span>
			</ul>

		<?php endif; ?>

		<?php
	}

	public function box_items() {
		$settings = $this->get_settings_for_display();
		$id       = $this->get_id();

		$this->add_render_attribute( 'box-settings', 'bdt-ps-flexure-items', 'connect: #bdt-ps-content-' . esc_attr( $id ) . ';' );

		$this->add_render_attribute( 'box-settings', 'bdt-grid', '' );
		$this->add_render_attribute( 'box-settings', 'class', [ 'bdt-grid', 'bdt-grid-small', 'bdt-grid-collapse' ] );

		$columns        = isset( $settings["columns"] ) ? (int) $settings["columns"] : 2;
		$columns_tablet = isset( $settings["columns_tablet"] ) ? (int) $settings["columns_tablet"] : 3;
		$columns_mobile = isset( $settings["columns_mobile"] ) ? (int) $settings["columns_mobile"] : 3;

		$this->add_render_attribute( 'box-settings', 'class', 'bdt-slider-items' );
		$this->add_render_attribute( 'box-settings', 'class', 'bdt-child-width-1-' . $columns_mobile );
		$this->add_render_attribute( 'box-settings', 'class', 'bdt-child-width-1-' . $columns_tablet . '@s' );
		$this->add_render_attribute( 'box-settings', 'class', 'bdt-child-width-1-' . $columns . '@m' );

		$this->add_render_attribute(
			[ 
				'slider-settings' => [ 
					'bdt-slider' => [ 
						wp_json_encode( array_filter( [ 
							"autoplay"          => false,
							"autoplay-interval" => 7000,
							"finite"            => false,
							"pause-on-hover"    => true,
						] ) )
					]
				]
			]
		);

		?>
		<div <?php echo ( $this->get_render_attribute_string( 'slider-settings' ) ); ?>>
			<div <?php $this->print_render_attribute_string( 'box-settings' ); ?>>

				<?php $slide_index = 1;
				foreach ( $settings['ps_slider'] as $index => $item ) :

					$tab_count   = $index + 1;
					$tab_id      = 'bdt-ps-' . $tab_count . esc_attr( $id );
					$active_item = $this->activeItem( $settings['_active_item'], count( $settings['ps_slider'] ) );
					if ( $tab_id == 'bdt-ps-' . $active_item . esc_attr( $id ) ) {
						$this->add_render_attribute( 'ps-flexure-item', 'class', 'bdt-ps-flexure-item active', true );
					} else {
						$this->add_render_attribute( 'ps-flexure-item', 'class', 'bdt-ps-flexure-item', true );
					}

					$this->add_render_attribute( 'bdt-ps-flexure-title', 'class', 'bdt-ps-flexure-title', true );
					$this->add_render_attribute(
						[ 
							'title-link' => [ 
								'class'  => [ 
									'bdt-ps-flexure-title-link',
								],
								'href'   => $item['title_link']['url'] ? esc_url( $item['title_link']['url'] ) : 'javascript:void(0);',
								'target' => $item['title_link']['is_external'] ? '_blank' : '_self'
							]
						], '', '', true
					);

					?>
					<div>
						<div <?php echo ( $this->get_render_attribute_string( 'ps-flexure-item' ) ); ?>
							data-id="<?php echo esc_attr( $tab_id ); ?>">

							<div
								class="bdt-ps-flexure-description bdt-position-small bdt-position-<?php echo esc_attr( $settings['title_position'] ) ?>">

								<?php if ( $item['ps_flexure_title'] && ( 'yes' == $settings['show_title'] ) ) : ?>
									<<?php echo esc_attr(Utils::get_valid_html_tag( $settings['title_tags'] )); ?>
										<?php $this->print_render_attribute_string( 'bdt-ps-flexure-title' ); ?>
										data-reveal="reveal-active" data-label="
										<?php echo esc_html(str_pad( $tab_count, 2, '0', STR_PAD_LEFT )); ?>">

										<?php if ( '' !== $item['title_link']['url'] ) : ?>
											<a <?php $this->print_render_attribute_string( 'title-link' ); ?>>
											<?php endif; ?>
											<?php echo wp_kses( $item['ps_flexure_title'], prime_slider_allow_tags( 'title' ) ); ?>
											<?php if ( '' !== $item['title_link']['url'] ) : ?>
											</a>
										<?php endif; ?>

									</<?php echo esc_attr(Utils::get_valid_html_tag( $settings['title_tags'] )); ?>>
								<?php endif; ?>

							</div>

						</div>
					</div>
				<?php endforeach; ?>

			</div>

			<?php $this->render_slider_pagination(); ?>
			<?php $this->render_navigation_arrows(); ?>

		</div>
		<?php
	}

	public function box_content() {
		$settings = $this->get_settings_for_display();
		$id       = $this->get_id();

		?>

		<?php foreach ( $settings['ps_slider'] as $index => $item ) :
			$tab_count = $index + 1;
			$tab_id    = 'bdt-ps-' . $tab_count . esc_attr( $id );

			$slide_image = Group_Control_Image_Size::get_attachment_image_src( $item['slide_image']['id'], 'thumbnail_size', $settings );
			if ( ! $slide_image ) {
				$slide_image = $item['slide_image']['url'];
			}

			$active_item = $this->activeItem( $settings['_active_item'], count( $settings['ps_slider'] ) );

			if ( $tab_id == 'bdt-ps-' . $active_item . esc_attr( $id ) ) {
				$this->add_render_attribute( 'ps-flexure-content', 'class', 'bdt-ps-flexure-content active', true );
			} else {
				$this->add_render_attribute( 'ps-flexure-content', 'class', 'bdt-ps-flexure-content', true );
			}

			?>

			<div id="<?php echo esc_attr( $tab_id ); ?>" <?php echo ( $this->get_render_attribute_string( 'ps-flexure-content' ) ); ?>>

				<?php if ( $item['slide_image'] ) : ?>
					<div class="bdt-ps-flexure-image" style="background-image: url('<?php echo esc_url( $slide_image ); ?>');"></div>
				<?php endif; ?>

				<?php if ( $item['ps_flexure_content'] && ( 'yes' == $settings['show_content'] ) ) : ?>
					<div class="bdt-ps-flexure-text-wrapper">
						<span class="bdt-custom-divider reveal-muted"
							data-label="<?php echo esc_attr(str_pad( $tab_count, 2, '0', STR_PAD_LEFT )); ?>"></span>
						<div class="bdt-ps-flexure-text" data-reveal="reveal-active">
							<?php echo wp_kses_post( $item['ps_flexure_content'] ); ?>
						</div>
					</div>
				<?php endif; ?>

			</div>
		<?php endforeach; ?>

	<?php
	}

}
