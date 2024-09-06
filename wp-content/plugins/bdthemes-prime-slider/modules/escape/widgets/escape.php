<?php
namespace PrimeSliderPro\Modules\Escape\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Plugin;
use Elementor\Repeater;
use PrimeSliderPro\Utils;

use PrimeSlider\Traits\Global_Widget_Controls;

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

class Escape extends Widget_Base {

	use Global_Widget_Controls;

	public function get_name() {
		return 'prime-slider-escape';
	}

	public function get_title() {
		return BDTPS . esc_html__( 'Escape', 'bdthemes-prime-slider' );
	}

	public function get_icon() {
		return 'bdt-widget-icon ps-wi-escape bdt-new';
	}

	public function get_categories() {
		return [ 'prime-slider-pro' ];
	}

	public function get_keywords() {
		return [ 'prime slider', 'slider', 'escape', 'prime' ];
	}

	public function get_style_depends() {
		return [ 'ps-escape', 'prime-slider-font' ];
	}
	public function get_script_depends() {
		return [ 'shutters', 'gl', 'slicer', 'tinder', 'ps-escape' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/WTqtALRdhDc';
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_content_sliders',
			[ 
				'label' => esc_html__( 'Sliders', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'tabs_items_style' );

		$repeater->start_controls_tab(
			'tab_item_content',
			[ 
				'label' => esc_html__( 'Content', 'bdthemes-prime-slider' ),
			]
		);

		/**
		 * Repeater Title Controls
		 */
		$this->register_repeater_title_controls( $repeater );

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
			'tab_item_content_optional',
			[ 
				'label' => esc_html__( 'Optional', 'bdthemes-prime-slider' ),
			]
		);

		/**
		 * Repeater Title Link Controls
		 */
		$this->register_repeater_title_link_controls( $repeater );

		/**
		 * Repeater Text Controls
		 */
		$this->register_repeater_text_controls( $repeater );

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'slides',
			[ 
				'label'       => esc_html__( 'Items', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [ 
					[ 
						'title' => esc_html__( 'Massive', 'bdthemes-prime-slider' ),
						'text'  => esc_html__( 'Prime Slider Addons for Elementor is a page builder extension that allows you to build sliders with drag and drop. It lets you create an amazing slider without touching no code at all!', 'bdthemes-prime-slider' ),
						'image' => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-1.svg' ]
					],
					[ 
						'title' => esc_html__( 'Vibrant', 'bdthemes-prime-slider' ),
						'text'  => esc_html__( 'Prime Slider Addons for Elementor is a page builder extension that allows you to build sliders with drag and drop. It lets you create an amazing slider without touching no code at all!', 'bdthemes-prime-slider' ),
						'image' => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-4.svg' ]
					],
					[ 
						'title' => esc_html__( 'Wallow', 'bdthemes-prime-slider' ),
						'text'  => esc_html__( 'Prime Slider Addons for Elementor is a page builder extension that allows you to build sliders with drag and drop. It lets you create an amazing slider without touching no code at all!', 'bdthemes-prime-slider' ),
						'image' => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-5.svg' ]
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
			'item_height',
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
					'{{WRAPPER}}' => '--ps-slider-height: {{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->add_responsive_control(
			'content_width',
			[ 
				'label'       => esc_html__( 'Content Width', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ '%', 'px', 'vw' ],
				'range'       => [ 
					'px' => [ 
						'min' => 200,
						'max' => 1080,
					],
					'%'  => [ 
						'min' => 10,
						'max' => 100,
					],
					'vw' => [ 
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors'   => [ 
					'{{WRAPPER}} .bdt-escape-slider .bdt-content' => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'render_type' => 'template'
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
		 * Show Button Text Controls
		 */
		$this->register_show_button_text_controls();

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

		$this->add_responsive_control(
			'content_alignment',
			[ 
				'label'     => esc_html__( 'Alignment', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [ 
					'left'    => [ 
						'title' => esc_html__( 'Left', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'  => [ 
						'title' => esc_html__( 'Center', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'   => [ 
						'title' => esc_html__( 'Right', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify' => [ 
						'title' => esc_html__( 'Justify', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-escape-slider .bdt-content' => 'text-align: {{VALUE}};',
				],
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
		 * Free Mode Controls
		 */
		$this->register_free_mode_controls();

		/**
		 * Loop, Rewind & mousewheel Controls
		 */
		$this->register_loop_rewind_mousewheel_controls();

		/**
		 * Speed & Observer Controls
		 */
		$this->register_speed_observer_controls();

		/**
		 * Swiper Effects global controls
		 */
		$this->register_swiper_effects_controls();

		$this->end_controls_section();

		//Style Start
		$this->start_controls_section(
			'section_style_sliders',
			[ 
				'label' => esc_html__( 'Sliders', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'slider_wrap_margin',
			[ 
				'label'      => __( 'Margin', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-escape-slider' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'slider_wrap_padding',
			[ 
				'label'      => __( 'Content Padding', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-escape-slider .bdt-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[ 
				'label'      => esc_html__( 'Image Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-escape-slider .bdt-image-wrap .bdt-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			'title_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-escape-slider .bdt-title, {{WRAPPER}} .bdt-escape-slider .bdt-title a' => 'color: {{VALUE}};',
				],
				'condition' => [ 
					'show_title' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'title_hover_color',
			[ 
				'label'     => esc_html__( 'Hover Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-escape-slider .bdt-title:hover, {{WRAPPER}} .bdt-escape-slider .bdt-title a:hover' => 'color: {{VALUE}};',
				],
				'condition' => [ 
					'show_title' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'first_word_title_color',
			[ 
				'label'     => esc_html__( 'First Word Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-escape-slider .bdt-title .frist-word' => 'color: {{VALUE}};',
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
				'selector'  => '{{WRAPPER}} .bdt-escape-slider .bdt-title',
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
				'selector'  => '{{WRAPPER}} .bdt-escape-slider .bdt-title',
				'condition' => [ 
					'show_title' => [ 'yes' ],
				],
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[ 
				'label'      => __( 'Margin', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-escape-slider .bdt-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'slider_text_style',
			[ 
				'label'     => __( 'Text', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_text' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'text_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-escape-slider .bdt-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'text_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-escape-slider .bdt-text',
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[ 
				'label'      => __( 'Margin', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-escape-slider .bdt-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'slider_link_btn_style',
			[ 
				'label' => __( 'Button', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'link_btn_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-escape-slider .bdt-link-btn a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'link_btn_background',
				'selector' => '{{WRAPPER}} .bdt-escape-slider .bdt-link-btn a',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'     => 'link_btn_border',
				'selector' => '{{WRAPPER}} .bdt-escape-slider .bdt-link-btn a',
			]
		);

		$this->add_responsive_control(
			'link_btn_border_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-escape-slider .bdt-link-btn a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'link_btn_padding',
			[ 
				'label'      => esc_html__( 'Padding', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-escape-slider .bdt-link-btn a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'link_btn_margin',
			[ 
				'label'      => esc_html__( 'Margin', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-escape-slider .bdt-link-btn a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'link_btn_shadow',
				'selector' => '{{WRAPPER}} .bdt-escape-slider .bdt-link-btn a',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'link_btn_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-escape-slider .bdt-link-btn a',
			]
		);

		$this->add_control(
			'link_button_hover_heading',
			[ 
				'label'     => esc_html__( 'HOVER', 'bdthemes-prime-slider' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'link_btn_hover_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-escape-slider .bdt-link-btn a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'link_btn_hover_background',
				'selector' => '{{WRAPPER}} .bdt-escape-slider .bdt-link-btn a:hover',
			]
		);

		$this->add_control(
			'link_btn_hover_border_color',
			[ 
				'label'     => esc_html__( 'Border Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 
					'link_btn_border_border!' => '',
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-escape-slider .bdt-link-btn a:hover' => 'border-color: {{VALUE}};',
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
			'nav_arrows_icon',
			[ 
				'label'     => esc_html__( 'Arrows Icon', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '3',
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

		$this->start_controls_tabs( 'slider_nav_arrows_style' );

		$this->start_controls_tab(
			'slider_arrows_style',
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
				'label'     => __( 'Arrows Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-escape-slider .bdt-navigation-wrap .bdt-nav-btn' => 'color: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_responsive_control(
			'arrows_font_size',
			[ 
				'label'      => __( 'Arrows Size', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'vh' ],
				'range'      => [ 
					'px' => [ 
						'min' => 0,
						'max' => 200,
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
					'{{WRAPPER}} .bdt-escape-slider .bdt-navigation-wrap .bdt-nav-btn' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'      => 'arrows_background',
				'selector'  => '{{WRAPPER}} .bdt-escape-slider .bdt-navigation-wrap .bdt-nav-btn',
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'      => 'arrows_border',
				'selector'  => '{{WRAPPER}} .bdt-escape-slider .bdt-navigation-wrap .bdt-nav-btn',
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_responsive_control(
			'arrows_border_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-escape-slider .bdt-navigation-wrap .bdt-nav-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .bdt-escape-slider .bdt-navigation-wrap .bdt-nav-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .bdt-escape-slider .bdt-navigation-wrap .bdt-nav-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);


		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'      => 'arrows_shadow',
				'selector'  => '{{WRAPPER}} .bdt-escape-slider .bdt-navigation-wrap .bdt-nav-btn',
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->end_controls_tab();
		$this->start_controls_tab(
			'slider_arrows_hover_style',
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
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-escape-slider .bdt-navigation-wrap .bdt-nav-btn:hover' => 'color: {{VALUE}};',
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
				'selector'  => '{{WRAPPER}} .bdt-escape-slider .bdt-navigation-wrap .bdt-nav-btn:hover',
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_border_color',
			[ 
				'label'     => esc_html__( 'Border Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-escape-slider .bdt-navigation-wrap .bdt-nav-btn:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'Fraction_pag_heading',
			[ 
				'label'     => esc_html__( 'Fraction Pagination', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 
					'show_navigation_fraction' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'pagination_color',
			[ 
				'label'     => __( 'Pagination Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-escape-slider .bdt-pagination .swiper-pagination-bullet' => 'color: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_fraction' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'pagination_hover_color',
			[ 
				'label'     => __( 'Pagination Hover Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-escape-slider .bdt-pagination .swiper-pagination-bullet:hover' => 'color: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_fraction' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'pagination_active_color',
			[ 
				'label'     => __( 'Pagination Active Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-escape-slider .bdt-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'color: {{VALUE}}',
					'{{WRAPPER}} .bdt-escape-slider .bdt-pagination .swiper-pagination-bullet::after'                          => 'background-color: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_fraction' => [ 'yes' ],
				],
			]
		);

		$this->add_responsive_control(
			'fraction_line_width',
			[ 
				'label'     => __( 'Line Width', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 0,
						'max' => 300,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-escape-slider .bdt-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active::after' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'      => 'pagination_typography',
				'label'     => esc_html__( 'Typography', 'bdthemes-prime-slider' ),
				'selector'  => '{{WRAPPER}} .bdt-escape-slider .bdt-pagination .swiper-pagination-bullet',
				'condition' => [ 
					'show_title' => [ 'yes' ],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render_header() {
		$settings = $this->get_settings_for_display();
		$id       = 'bdt-prime-slider-' . $this->get_id();

		$this->add_render_attribute( 'prime-slider-escape', 'id', $id );
		$this->add_render_attribute( 'prime-slider-escape', 'class', [ 'bdt-escape-slider', 'elementor-swiper' ] );

		$this->add_render_attribute(
			[ 
				'prime-slider-escape' => [ 
					'data-settings' => [ 
						wp_json_encode( array_filter( [ 
							"autoplay"            => ( "yes" == $settings["autoplay"] ) ? [ "delay" => $settings["autoplay_speed"] ] : false,
							"loop"                => ( $settings["loop"] == "yes" ) ? true : false,
							"rewind"              => ( isset( $settings["rewind"] ) && $settings["rewind"] == "yes" ) ? true : false,
							"speed"               => $settings["speed"]["size"],
							"effect"              => isset( $settings["swiper_effect"] ) ? $settings["swiper_effect"] : 'slide',
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
							"grabCursor"          => ( $settings["grab_cursor"] === "yes" ) ? true : false,
							"pauseOnHover"        => ( "yes" == $settings["pauseonhover"] ) ? true : false,
							// "slidesPerView"  => 1.25,
							"slidesPerView"       => ( $settings["swiper_effect"] == "slide" or $settings["swiper_effect"] == "coverflow" ) ? 1.25 : 1,
							"loopedSlides"        => 4,
							"spaceBetween"        => 20,
							"observer"            => ( $settings["observer"] ) ? true : false,
							"observeParents"      => ( $settings["observer"] ) ? true : false,
							"pagination"          => [ 
								"el"        => "#" . $id . " .bdt-pagination",
								"clickable" => "true",
							],
							"scrollbar"           => [ 
								"el" => "#" . $id . " .swiper-scrollbar",
							],
							"lazy"                => [ 
								"loadPrevNext" => "true",
							],
							"navigation"          => [ 
								"nextEl" => "#" . $id . " .bdt-button-next",
								"prevEl" => "#" . $id . " .bdt-button-prev",
							],
						] ) )
					]
				]
			]
		);

		$swiper_class = Plugin::$instance->experiments->is_feature_active( 'e_swiper_latest' ) ? 'swiper' : 'swiper-container';
		$this->add_render_attribute( 'swiper', 'class', 'bdt-main-slider ' . $swiper_class );

		?>
		<div <?php $this->print_render_attribute_string( 'prime-slider-escape' ); ?>>
			<div <?php $this->print_render_attribute_string( 'swiper' ); ?>>
				<div class="swiper-wrapper">
					<?php
	}

	public function render_navigations() {
		$settings = $this->get_settings_for_display();
		?>

					<div class="bdt-nav-pag-wrap">
						<?php if ( $settings['show_navigation_fraction'] ) : ?>
							<div class="bdt-pagination"></div>
						<?php endif; ?>
						<?php if ( $settings['show_navigation_arrows'] ) : ?>
							<div class="bdt-navigation-wrap">
								<div class="bdt-button-next bdt-nav-btn">
									<i class="ps-wi-arrow-right-<?php echo esc_attr( $settings['nav_arrows_icon'] ); ?>"
										aria-hidden="true"></i>
								</div>
								<div class="bdt-button-prev bdt-nav-btn">
									<i class="ps-wi-arrow-left-<?php echo esc_attr( $settings['nav_arrows_icon'] ); ?>"
										aria-hidden="true"></i>
								</div>
							</div>
						<?php endif; ?>
					</div>

					<?php
	}

	public function render_footer() {
		$settings = $this->get_settings_for_display();
		?>
				</div>
				<?php $this->render_navigations(); ?>

			</div>
			<div thumbsSlider="" class="bdt-thumbs-slider">
				<div class="swiper-wrapper">

					<?php foreach ( $settings['slides'] as $slide ) : ?>
						<div class="swiper-slide bdt-item">

							<div class="bdt-content">

								<?php if ( $slide['title'] && ( 'yes' == $settings['show_title'] ) ) : ?>
									<<?php echo esc_attr( Utils::get_valid_html_tag( $settings['title_html_tag'] ) ); ?> class="bdt-title"
										data-swiper-parallax-y="-250">
										<?php if ( '' !== $slide['title_link']['url'] ) : ?>
											<a href="<?php echo esc_url( $slide['title_link']['url'] ); ?>">
											<?php endif; ?>
											<?php echo wp_kses_post( prime_slider_first_word( $slide['title'] ) ); ?>
											<?php if ( '' !== $slide['title_link']['url'] ) : ?>
											</a>
										<?php endif; ?>
									</<?php echo esc_attr( Utils::get_valid_html_tag( $settings['title_html_tag'] ) ); ?>>
								<?php endif; ?>

								<?php $this->render_text( $slide ); ?>

								<?php $this->render_button( $slide ); ?>

							</div>
						</div>
					<?php endforeach; ?>

				</div>
			</div>
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
			<div class="bdt-text <?php echo esc_attr( $text_hide_on_setup ); ?>" data-swiper-parallax-y="-200">
				<?php echo wp_kses_post( $slide['text'] ); ?>
			</div>
		<?php endif; ?>
	<?php
	}

	public function render_button( $content ) {
		$settings = $this->get_settings_for_display();

		// $this->add_render_attribute('slider-button', '', true);

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

		<?php if ( $content['slide_button_text'] && ( 'yes' == $settings['show_button_text'] ) ) : ?>

			<div class="bdt-link-btn" data-swiper-parallax-y="-150">
				<a <?php $this->print_render_attribute_string( 'slider-button' ); ?>>
					<?php echo wp_kses( $content['slide_button_text'], prime_slider_allow_tags( 'title' ) ); ?>
				</a>
			</div>

		<?php endif;
	}

	public function render_slides_loop() {
		$settings = $this->get_settings_for_display();

		foreach ( $settings['slides'] as $slide ) :

			?>
			<div class="bdt-item swiper-slide">
				<?php $this->rendar_image( $slide, '' ); ?>
			</div>

		<?php endforeach;
	}

	public function render() {

		$this->render_header();

		$this->render_slides_loop();

		$this->render_footer();
	}
}