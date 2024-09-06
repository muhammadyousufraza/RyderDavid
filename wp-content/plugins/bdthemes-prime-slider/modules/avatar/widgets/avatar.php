<?php

namespace PrimeSliderPro\Modules\Avatar\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Plugin;
use PrimeSlider\Traits\Global_Widget_Controls;
use PrimeSliderPro\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Exit if accessed directly

class Avatar extends Widget_Base {

	use Global_Widget_Controls;

	public function get_name() {
		return 'prime-slider-avatar';
	}

	public function get_title() {
		return BDTPS . esc_html__( 'Avatar', 'bdthemes-prime-slider' );
	}

	public function get_icon() {
		return 'bdt-widget-icon ps-wi-avatar';
	}

	public function get_categories() {
		return [ 'prime-slider-pro' ];
	}

	public function get_keywords() {
		return [ 'prime slider', 'slider', 'avatar', 'prime' ];
	}

	public function get_style_depends() {
		return [ 'prime-slider-font', 'ps-avatar' ];
	}

	public function get_script_depends() {
		$reveal_effects = prime_slider_option( 'reveal-effects', 'prime_slider_other_settings', 'off' );
		if ( 'on' === $reveal_effects ) {
			return [ 'splitting', 'anime', 'revealFx', 'ps-avatar' ];
		} else {
			return [ 'splitting', 'ps-avatar' ];
		}
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/qmNOWgzTt_Q';
	}

	protected function register_controls() {
		$reveal_effects = prime_slider_option( 'reveal-effects', 'prime_slider_other_settings', 'off' );
		$this->start_controls_section(
			'section_content_layout',
			[ 
				'label' => esc_html__( 'Layout', 'bdthemes-prime-slider' ),
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
					'{{WRAPPER}} .bdt-prime-slider-avatar' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_max_width',
			[ 
				'label'      => esc_html__( 'Content Max Width', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range'      => [ 
					'px' => [ 
						'min' => 220,
						'max' => 1400,
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
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider-avatar .bdt-content-wrap' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		/**
		 * Show Title Controls
		 */
		$this->register_show_title_controls();

		/**
		 * Show Excerpt Controls
		 */
		$this->register_show_excerpt_controls();

		/**
		 * Show Button Text Controls
		 */
		$this->register_show_button_text_controls();

		/**
		 * Show Navigation Controls
		 */
		$this->register_show_navigation_controls();

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
					'{{WRAPPER}} .bdt-prime-slider-avatar .bdt-content-wrap' => 'text-align: {{VALUE}};',
				],
			]
		);

		/**
		 * Thumbnail Size Controls
		 */
		$this->register_thumbnail_size_controls();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_sliders',
			[ 
				'label' => esc_html__( 'Sliders', 'bdthemes-prime-slider' ),
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'tabs_slider_item_content' );
		$repeater->start_controls_tab(
			'tab_slider_content',
			[ 
				'label' => __( 'Content', 'bdthemes-prime-slider' ),
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
			'tab_slider_optional',
			[ 
				'label' => __( 'Optional', 'bdthemes-prime-slider' ),
			]
		);

		/**
		 * Repeater Title Link Controls
		 */
		$this->register_repeater_title_link_controls( $repeater );

		/**
		 * Repeater Excerpt Controls
		 */
		$this->register_repeater_excerpt_controls( $repeater );

		$repeater->end_controls_tab();
		$repeater->end_controls_tabs();

		$this->add_control(
			'slides',
			[ 
				'label'       => esc_html__( 'Slider Items', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [ 
					[ 
						'title' => esc_html__( 'Avatar Slide One', 'bdthemes-prime-slider' ),
						'image' => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-1.svg' ],
					],
					[ 
						'title' => esc_html__( 'Avatar Slide Two', 'bdthemes-prime-slider' ),
						'image' => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-4.svg' ],
					],
					[ 
						'title' => esc_html__( 'Avatar Slide Three', 'bdthemes-prime-slider' ),
						'image' => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-5.svg' ],
					],
					[ 
						'title' => esc_html__( 'Avatar Slide Four', 'bdthemes-prime-slider' ),
						'image' => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-6.svg' ],
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_carousel_settings',
			[ 
				'label' => __( 'Slider Settings', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'autoplay',
			[ 
				'label'   => __( 'Autoplay', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',

			]
		);

		$this->add_control(
			'autoplay_speed',
			[ 
				'label'     => esc_html__( 'Autoplay Speed', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 4000,
				'condition' => [ 
					'autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'pauseonhover',
			[ 
				'label' => esc_html__( 'Pause on Hover', 'bdthemes-prime-slider' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'grab_cursor',
			[ 
				'label' => __( 'Grab Cursor', 'bdthemes-prime-slider' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'loop',
			[ 
				'label'   => __( 'Loop', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',

			]
		);

		$this->add_control(
			'speed',
			[ 
				'label'   => __( 'Animation Speed (ms)', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [ 
					'size' => 500,
				],
				'range'   => [ 
					'min'  => 100,
					'max'  => 5000,
					'step' => 50,
				],
			]
		);

		$this->add_control(
			'observer',
			[ 
				'label'       => __( 'Observer', 'bdthemes-prime-slider' ),
				'description' => __( 'When you use carousel in any hidden place (in tabs, accordion etc) keep it yes.', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

		/**
		 * Reveal Effects
		 */
		if ( 'on' === $reveal_effects ) {
			$this->register_reveal_effects();
		}

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
				'name'     => 'image_overlay',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-avatar .content--hero::before',
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[ 
				'label'      => __( 'Content Padding', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider-avatar .bdt-content-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[ 
				'label' => __( 'Thumbs Image', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'thumbs_image_height',
			[ 
				'label'     => esc_html__( 'Height', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 50,
						'max' => 1024,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-avatar .bdt-hero-swiper' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'thumbs_image_width',
			[ 
				'label'     => esc_html__( 'Width', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 50,
						'max' => 1024,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-avatar .bdt-hero-swiper' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'      => 'thumb_image_border',
				'selector'  => '{{WRAPPER}} .bdt-prime-slider-avatar .bdt-item-box',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'thumb_image_border_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider-avatar .bdt-item-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[ 
				'label'     => __( 'Title', 'bdthemes-prime-slider' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-avatar .bdt-title, {{WRAPPER}} .bdt-prime-slider-avatar .bdt-title>a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_hover_color',
			[ 
				'label'     => __( 'Hover Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-avatar .bdt-title:hover, {{WRAPPER}} .bdt-prime-slider-avatar .bdt-title>a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[ 
				'label'     => __( 'Spacing', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-avatar .bdt-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-avatar .bdt-title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[ 
				'name'     => 'title_text_shadow',
				'label'    => __( 'Text Shadow', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-prime-slider-avatar .bdt-title, {{WRAPPER}} .bdt-prime-slider-avatar .bdt-title>a',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_desc',
			[ 
				'label' => __( 'Text', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'desc_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-avatar .bdt-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'desc_shadow',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-avatar .bdt-desc',
			]
		);

		$this->add_responsive_control(
			'desc_spacing',
			[ 
				'label'     => esc_html__( 'Spacing', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-avatar .bdt-desc' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'desc_typography',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-avatar .bdt-desc',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_link_btn',
			[ 
				'label' => __( 'Link Button', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_link_btn_style' );

		$this->start_controls_tab(
			'tabs_nav_link_btn_normal',
			[ 
				'label' => __( 'Normal', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'link_btn_color',
			[ 
				'label'     => __( 'Text Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-avatar .bdt-link-btn a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'link_btn_background',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-avatar .bdt-link-btn a',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'     => 'link_btn_border',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-avatar .bdt-link-btn a',
			]
		);

		$this->add_responsive_control(
			'link_btn_border_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider-avatar .bdt-link-btn a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'link_btn_padding',
			[ 
				'label'      => __( 'Padding', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider-avatar .bdt-link-btn a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'link_btn_margin',
			[ 
				'label'      => __( 'Margin', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-rubix-slider .bdt-main-slider .bdt-read-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'link_btn_shadow',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-avatar .bdt-link-btn a',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'link_btn_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-prime-slider-avatar .bdt-link-btn a',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_link_btn_hover',
			[ 
				'label' => __( 'Hover', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'link_btn_hover_color',
			[ 
				'label'     => __( 'Text Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-avatar .bdt-link-btn a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'link_btn_hover_background',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-avatar .bdt-link-btn a:hover',
			]
		);

		$this->add_control(
			'link_btn_hover_border_color',
			[ 
				'label'     => esc_html__( 'Border Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 
					'arrows_border_border!' => '',
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-avatar .bdt-link-btn a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'link-btn_hover_shadow',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-avatar .bdt-link-btn a:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation_btn',
			[ 
				'label' => __( 'Navigation', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_navigation_btn_style' );

		$this->start_controls_tab(
			'tabs_nav_navigation_btn_normal',
			[ 
				'label' => __( 'Normal', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'navigation_btn_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-avatar .bdt-button-next' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'navigation_btn_background',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-avatar .bdt-button-next',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'     => 'navigation_btn_border',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-avatar .bdt-button-next',
			]
		);

		$this->add_responsive_control(
			'navigation_btn_border_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider-avatar .bdt-button-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// $this->add_responsive_control(
		//     'navigation_btn_size',
		//     [
		//         'label' => esc_html__('Button Size', 'bdthemes-prime-slider'),
		//         'type'  => Controls_Manager::SLIDER,
		//         'range' => [
		//             'px' => [
		//                 'min' => 50,
		//                 'max' => 1024,
		//             ],
		//         ],
		//         'selectors' => [
		//             '{{WRAPPER}}  .bdt-prime-slider-avatar .bdt-button-next' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
		//         ],
		//     ]
		// );

		$this->add_responsive_control(
			'navigation_padding',
			[ 
				'label'      => __( 'Padding', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider-avatar .bdt-button-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'navigation_btn_icon_size',
			[ 
				'label'     => esc_html__( 'Icon Size', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 30,
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}}  .bdt-prime-slider-avatar .bdt-button-next svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'navigation_btn_shadow',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-avatar .bdt-button-next',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'navigation_btn_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-prime-slider-avatar .bdt-button-next',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_navigation_btn_hover',
			[ 
				'label' => __( 'Hover', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'navigation_btn_hover_color',
			[ 
				'label'     => __( 'Text Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-avatar .bdt-button-next:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'navigation_btn_hover_background',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-avatar .bdt-button-next:hover',
			]
		);

		$this->add_control(
			'navigation_btn_hover_border_color',
			[ 
				'label'     => esc_html__( 'Border Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 
					'arrows_border_border!' => '',
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-avatar .bdt-button-next:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'navigation_btn_hover_shadow',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-avatar .bdt-button-next:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render_header() {
		$settings = $this->get_settings_for_display();
		$id       = 'bdt-prime-slider-' . $this->get_id();

		$this->add_render_attribute( 'prime-slider-avatar', 'id', $id );
		$this->add_render_attribute( 'prime-slider-avatar', 'class', [ 'bdt-prime-slider-avatar', 'elementor-swiper' ] );

		/**
		 * Reveal Effects
		 */
		$this->reveal_effects_attr( 'prime-slider-avatar' );

		$this->add_render_attribute(
			[ 
				'prime-slider-avatar' => [ 
					'data-settings' => [ 
						wp_json_encode( array_filter( [ 
							"autoplay"       => ( "yes" == $settings["autoplay"] ) ? [ "delay" => $settings["autoplay_speed"] ] : false,
							"loop"           => ( $settings["loop"] == "yes" ) ? true : false,
							"speed"          => $settings["speed"]["size"],
							"pauseOnHover"   => ( "yes" == $settings["pauseonhover"] ) ? true : false,
							"simulateTouch"  => false,
							"grabCursor"     => ( $settings["grab_cursor"] === "yes" ) ? true : false,
							"effect"         => 'fade',
							"observer"       => ( $settings["observer"] ) ? true : false,
							"observeParents" => ( $settings["observer"] ) ? true : false,
						] ) ),
					],
				],
			]
		);

		$this->add_render_attribute( 'prime-slider', 'class', 'bdt-prime-slider' );

		$swiper_class = Plugin::$instance->experiments->is_feature_active( 'e_swiper_latest' ) ? 'swiper' : 'swiper-container';
		$this->add_render_attribute( 'swiper', 'class', 'bdt-hero-swiper ' . $swiper_class );

		?>
		<div <?php $this->print_render_attribute_string( 'prime-slider' ); ?>>
			<div <?php $this->print_render_attribute_string( 'prime-slider-avatar' ); ?>>
				<div class="bdt-fullsize"></div>
				<div <?php $this->print_render_attribute_string( 'swiper' ); ?>>
					<div class="swiper-wrapper">
						<?php
	}

	public function render_navigation_arrows() {
		$settings = $this->get_settings_for_display();

		?>

						<?php if ( $settings['show_navigation_arrows'] ) : ?>
							<div class="bdt-button-next reveal-muted">
								<svg width="30" height="30" viewBox="0 0 20 20" fill="currentColor"
									xmlns="http://www.w3.org/2000/svg">
									<path fill-rule="evenodd"
										d="M12.146 6.646a.5.5 0 01.708 0l3 3a.5.5 0 010 .708l-3 3a.5.5 0 01-.708-.708L14.793 10l-2.647-2.646a.5.5 0 010-.708z"
										clip-rule="evenodd" />
									<path fill-rule="evenodd" d="M4 10a.5.5 0 01.5-.5H15a.5.5 0 010 1H4.5A.5.5 0 014 10z"
										clip-rule="evenodd" />
								</svg>
							</div>
						<?php endif;
	}

	public function render_button( $content ) {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'slider-button', '', true );
		$this->add_render_attribute( 'slider-button', 'data-reveal', 'reveal-active', true );

		if ( isset( $content['button_link']['url'] ) ) {
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
							<a <?php $this->print_render_attribute_string( 'slider-button' ); ?>>
								<?php echo wp_kses( $content['slide_button_text'], prime_slider_allow_tags( 'title' ) ); ?>
							</a>
						<?php endif;
	}

	public function render_footer() {
		$settings = $this->get_settings_for_display();

		?>
					</div>
					<?php $this->render_navigation_arrows(); ?>
				</div>

			</div>
		</div>

		<?php
	}

	public function rendar_item_image( $slide ) {
		$settings = $this->get_settings_for_display();

		$thumb_url = Group_Control_Image_Size::get_attachment_image_src( $slide['image']['id'], 'thumbnail_size', $settings );
		if ( ! $thumb_url ) {
			printf( '<img src="%1$s" alt="%2$s" class="bdt-image-wrap reveal-muted">', esc_url($slide['image']['url']), esc_html( $slide['title'] ) );
		} else {
			print( wp_get_attachment_image(
				$slide['image']['id'],
				$settings['thumbnail_size_size'],
				false,
				[ 
					'class' => 'bdt-image-wrap reveal-muted',
					'alt'   => esc_html( $slide['title'] )
				]
			) );
		}
	}

	public function render_slides_loop() {
		$settings = $this->get_settings_for_display();

		foreach ( $settings['slides'] as $slide ) : ?>

			<div class="swiper-slide bdt-item">
				<div class="content bdt-item-box">
					<?php $this->rendar_item_image( $slide ); ?>
					<div class="bdt-content-wrap">

						<?php if ( $slide['title'] && ( 'yes' == $settings['show_title'] ) ) : ?>
							<<?php echo esc_attr(Utils::get_valid_html_tag( $settings['title_html_tag'] )); ?> class="bdt-title"
								data-reveal="reveal-active">
								<?php if ( '' !== $slide['title_link']['url'] ) : ?>
									<a href="<?php echo esc_url( $slide['title_link']['url'] ); ?>">
									<?php endif; ?>
									<?php echo prime_slider_first_word( $slide['title'] ); ?>
									<?php if ( '' !== $slide['title_link']['url'] ) : ?>
									</a>
								<?php endif; ?>
							</<?php echo esc_attr(Utils::get_valid_html_tag( $settings['title_html_tag'] )); ?>>
						<?php endif; ?>

						<?php if ( $slide['excerpt'] && ( 'yes' == $settings['show_excerpt'] ) ) : ?>
							<div class="bdt-desc" data-reveal="reveal-active">
								<?php echo wp_kses_post( $slide['excerpt'] ); ?>
							</div>
						<?php endif; ?>

						<div class="bdt-link-btn">
							<?php $this->render_button( $slide ); ?>
						</div>

					</div>
				</div>
			</div>


		<?php endforeach;
	}

	public function render() {
		$this->render_header();
		$this->render_slides_loop();
		$this->render_footer();
	}
}