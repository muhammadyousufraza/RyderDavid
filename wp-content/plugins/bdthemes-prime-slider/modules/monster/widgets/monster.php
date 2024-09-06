<?php

namespace PrimeSliderPro\Modules\Monster\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Repeater;
use Elementor\Plugin;
use PrimeSliderPro\Utils;

use PrimeSlider\Traits\Global_Widget_Controls;

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

class Monster extends Widget_Base {

	use Global_Widget_Controls;

	public function get_name() {
		return 'prime-slider-monster';
	}

	public function get_title() {
		return BDTPS . esc_html__( 'Monster', 'bdthemes-prime-slider' );
	}

	public function get_icon() {
		return 'bdt-widget-icon ps-wi-monster';
	}

	public function get_categories() {
		return [ 'prime-slider-pro' ];
	}

	public function get_keywords() {
		return [ 'prime slider', 'slider', 'monster', 'prime' ];
	}

	public function get_style_depends() {
		return [ 'prime-slider-font', 'ps-monster' ];
	}

	public function get_script_depends() {
		$reveal_effects = prime_slider_option( 'reveal-effects', 'prime_slider_other_settings', 'off' );
		if ( 'on' === $reveal_effects ) {
			return [ 'anime', 'revealFx', 'ps-monster' ];
		} else {
			return [ 'ps-monster' ];
		}
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/BH-0sfptHeQ';
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
			'columns',
			[ 
				'label'          => __( 'Columns', 'bdthemes-prime-slider' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 3,
				'tablet_default' => 3,
				'mobile_default' => 1,
				'options'        => [ 
					1 => '1',
					2 => '2',
					3 => '3',
					4 => '4',
					5 => '5',
					6 => '6',
				],
			]
		);

		$this->add_responsive_control(
			'item_gap',
			[ 
				'label'          => __( 'Item Gap', 'ultimate-post-kit' ),
				'type'           => Controls_Manager::SLIDER,
				'default'        => [ 
					'size' => 0,
				],
				'tablet_default' => [ 
					'size' => 0,
				],
				'mobile_default' => [ 
					'size' => 0,
				],
				'range'          => [ 
					'px' => [ 
						'min' => 0,
						'max' => 100,
					],
				],
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
					'{{WRAPPER}} .bdt-prime-slider-monster' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		/**
		 * Show Title Controls
		 */
		$this->register_show_title_controls();

		$this->add_control(
			'show_sub_title',
			[ 
				'label'     => esc_html__( 'Show Label', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before',
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

		/**
		 * Show Navigation Controls
		 */
		$this->register_show_navigation_controls();

		$this->add_control(
			'navigation_center_arrows',
			[ 
				'label'     => esc_html__( 'Center Arrows', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [ 
					'show_navigation_arrows' => 'yes'
				]
			]
		);

		/**
		 * Show Pagination Controls
		 */
		$this->register_show_pagination_controls();

		$this->add_control(
			'hide_on_mobile',
			[ 
				'label'        => esc_html__( 'Pagination Hide on Mobile', 'bdthemes-prime-slider' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'condition'    => [ 
					'show_navigation_dots' => 'yes'
				],
				'prefix_class' => 'bdt-pagination-hide-',
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
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-prime-slider-content' => 'text-align: {{VALUE}};',
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

		$repeater->add_control(
			'sub_title',
			[ 
				'label'       => esc_html__( 'Label', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
			]
		);

		/**
		 * Repeater Title Controls
		 */
		$this->register_repeater_title_controls( $repeater );

		/**
		 * Repeater Title Link Controls
		 */
		$this->register_repeater_title_link_controls( $repeater );

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
						'sub_title' => esc_html__( 'This is a Label', 'bdthemes-prime-slider' ),
						'title'     => esc_html__( 'Monster Slider Item One', 'bdthemes-prime-slider' ),
						'image'     => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-1.svg' ]
					],
					[ 
						'sub_title' => esc_html__( 'This is a Label', 'bdthemes-prime-slider' ),
						'title'     => esc_html__( 'Monster Slider Item Two', 'bdthemes-prime-slider' ),
						'image'     => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-4.svg' ]
					],
					[ 
						'sub_title' => esc_html__( 'This is a Label', 'bdthemes-prime-slider' ),
						'title'     => esc_html__( 'Monster Slider Item Three', 'bdthemes-prime-slider' ),
						'image'     => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-5.svg' ]
					],
					[ 
						'sub_title' => esc_html__( 'This is a Label', 'bdthemes-prime-slider' ),
						'title'     => esc_html__( 'Monster Slider Item Four', 'bdthemes-prime-slider' ),
						'image'     => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-6.svg' ]
					],
				],
				'title_field' => '{{{ title }}}',
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

		$this->start_controls_section(
			'section_carousel_settings',
			[ 
				'label' => __( 'Slider Settings', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'skin',
			[ 
				'label'        => esc_html__( 'Layout', 'bdthemes-prime-slider' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'coverflow',
				'options'      => [ 
					'carousel'  => esc_html__( 'Carousel', 'bdthemes-prime-slider' ),
					'coverflow' => esc_html__( 'Coverflow', 'bdthemes-prime-slider' ),
				],
				'prefix_class' => 'bdt-carousel-style-',
				'render_type'  => 'template',
			]
		);

		$this->add_control(
			'coverflow_toggle',
			[ 
				'label'        => __( 'Coverflow Effect', 'bdthemes-prime-slider' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'return_value' => 'yes',
				'condition'    => [ 
					'skin' => 'coverflow'
				]
			]
		);

		$this->start_popover();

		$this->add_control(
			'coverflow_rotate',
			[ 
				'label'       => esc_html__( 'Rotate', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => [ 
					'size' => 0,
				],
				'range'       => [ 
					'px' => [ 
						'min'  => -360,
						'max'  => 360,
						'step' => 5,
					],
				],
				'condition'   => [ 
					'coverflow_toggle' => 'yes'
				],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'coverflow_stretch',
			[ 
				'label'       => __( 'Stretch', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => [ 
					'size' => 180,
				],
				'range'       => [ 
					'px' => [ 
						'min'  => 0,
						'step' => 10,
						'max'  => 200,
					],
				],
				'condition'   => [ 
					'coverflow_toggle' => 'yes'
				],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'coverflow_modifier',
			[ 
				'label'       => __( 'Modifier', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => [ 
					'size' => 1,
				],
				'range'       => [ 
					'px' => [ 
						'min'  => 1,
						'step' => 1,
						'max'  => 10,
					],
				],
				'condition'   => [ 
					'coverflow_toggle' => 'yes'
				],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'coverflow_depth',
			[ 
				'label'       => __( 'Depth', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => [ 
					'size' => 100,
				],
				'range'       => [ 
					'px' => [ 
						'min'  => 0,
						'step' => 10,
						'max'  => 1000,
					],
				],
				'condition'   => [ 
					'coverflow_toggle' => 'yes'
				],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'slide_shadows',
			[ 
				'label'       => __( 'Slide Shadows', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'yes',
				'render_type' => 'template',
			]
		);

		$this->end_popover();

		$this->add_control(
			'hr_005',
			[ 
				'type'      => Controls_Manager::DIVIDER,
				'condition' => [ 
					'skin' => 'coverflow'
				]
			]
		);

		$this->add_control(
			'show_lightbox',
			[ 
				'label'   => __( 'Show Lightbox', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'lightbox_animation',
			[ 
				'label'     => esc_html__( 'Lightbox Animation', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'slide',
				'options'   => [ 
					'slide' => esc_html__( 'Slide', 'bdthemes-prime-slider' ),
					'fade'  => esc_html__( 'Fade', 'bdthemes-prime-slider' ),
					'scale' => esc_html__( 'Scale', 'bdthemes-prime-slider' ),
				],
				'condition' => [ 
					'show_lightbox' => 'yes'
				]
			]
		);

		$this->add_control(
			'match_height',
			[ 
				'label' => __( 'Item Match Height', 'bdthemes-prime-slider' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		/**
		 * Autoplay Controls
		 */
		$this->register_autoplay_controls();

		$this->add_responsive_control(
			'slides_to_scroll',
			[ 
				'type'           => Controls_Manager::SELECT,
				'label'          => esc_html__( 'Slides to Scroll', 'bdthemes-prime-slider' ),
				'default'        => 1,
				'tablet_default' => 1,
				'mobile_default' => 1,
				'options'        => [ 
					1 => '1',
					2 => '2',
					3 => '3',
					4 => '4',
					5 => '5',
					6 => '6',
				],
			]
		);

		/**
		 * Centered Slides Controls
		 */
		$this->register_centered_slides_controls();

		/**
		 * Grab Cursor Controls
		 */
		$this->register_grab_cursor_controls();

		/**
		 * Loop Controls
		 */
		$this->register_loop_controls();

		/**
		 * Speed & Observer Controls
		 */
		$this->register_speed_observer_controls();

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
				'label' => __( 'Sliders', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_item_style' );

		$this->start_controls_tab(
			'tab_item_normal',
			[ 
				'label' => __( 'Normal', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'item_background',
			[ 
				'label'     => __( 'Background', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-slider-item' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'item_shadow',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-monster .bdt-slider-item',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'     => 'item_border',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-monster .bdt-slider-item',
			]
		);

		$this->add_responsive_control(
			'item_border_radius',
			[ 
				'label'      => __( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-slider-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[ 
				'label'      => __( 'Content Padding', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-prime-slider-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_item_hover',
			[ 
				'label' => __( 'Hover', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'item_hover_background',
			[ 
				'label'     => __( 'Background', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-slider-item:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_hover_border_color',
			[ 
				'label'     => __( 'Border Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 
					'item_border_border!' => '',
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-slider-item:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'item_hover_shadow',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-monster .bdt-slider-item:hover',
			]
		);

		$this->add_responsive_control(
			'item_shadow_padding',
			[ 
				'label'       => __( 'Match Padding', 'bdthemes-prime-slider' ),
				'description' => __( 'You have to add padding for matching overlaping normal/hover box shadow when you used Box Shadow option.', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [ 
					'px' => [ 
						'min'  => 0,
						'step' => 1,
						'max'  => 50,
					]
				],
				'default'     => [ 
					'size' => 10
				],
				'selectors'   => [ 
					'{{WRAPPER}} .swiper-monster' => 'padding: {{SIZE}}{{UNIT}}; margin: 0 -{{SIZE}}{{UNIT}};'
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_image',
			[ 
				'label' => __( 'Image', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_background',
			[ 
				'label'     => __( 'Background', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-slide-image' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_padding',
			[ 
				'label'      => __( 'Padding', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-slide-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'image_margin',
			[ 
				'label'      => __( 'Margin', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-slide-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[ 
				'label'      => __( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-slide-image'     => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-slide-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_opacity',
			[ 
				'label'     => __( 'Opacity (%)', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [ 
					'size' => 1,
				],
				'range'     => [ 
					'px' => [ 
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-slide-image img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'image_hover_opacity',
			[ 
				'label'     => __( 'Hover Opacity (%)', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [ 
					'size' => 1,
				],
				'range'     => [ 
					'px' => [ 
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-slide-image:hover img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_spacing',
			[ 
				'label'     => __( 'Spacing', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-slide-image' => 'margin-bottom: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-prime-slider-content .bdt-title-tag, {{WRAPPER}} .bdt-prime-slider-monster .bdt-prime-slider-content .bdt-title-tag>a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_hover_color',
			[ 
				'label'     => __( 'Hover Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-prime-slider-content .bdt-title-tag:hover, {{WRAPPER}} .bdt-prime-slider-monster .bdt-prime-slider-content .bdt-title-tag>a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[ 
				'label'     => __( 'Spacing', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-prime-slider-content .bdt-main-title' => 'padding-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-monster .bdt-prime-slider-content .bdt-title-tag, {{WRAPPER}} .bdt-prime-slider-monster .bdt-prime-slider-content .bdt-title-tag>a',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[ 
				'name'     => 'title_text_shadow',
				'label'    => __( 'Text Shadow', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-prime-slider-monster .bdt-prime-slider-content .bdt-title-tag, {{WRAPPER}} .bdt-prime-slider-monster .bdt-prime-slider-content .bdt-title-tag>a',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_sub_title',
			[ 
				'label'     => __( 'Label', 'bdthemes-prime-slider' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_sub_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'sub_title_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-slider-item .bdt-slide-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'sub_title_background',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-monster .bdt-slider-item .bdt-slide-label',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'     => 'sub_title_border',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-monster .bdt-slider-item .bdt-slide-label',
			]
		);

		$this->add_responsive_control(
			'sub_title_padding',
			[ 
				'label'      => esc_html__( 'Padding', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-slider-item .bdt-slide-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'sub_title_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-slider-item .bdt-slide-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'sub_title_shadow',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-monster .bdt-slider-item .bdt-slide-label',
			]
		);

		$this->add_responsive_control(
			'sub_title_spacing',
			[ 
				'label'     => esc_html__( 'Spacing', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-slider-item .bdt-slide-label' => 'left: {{SIZE}}{{UNIT}}; top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'sub_title_typography',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-monster .bdt-slider-item .bdt-slide-label',
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
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-prime-slider-social-icon h3' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'social_icon_text_typography',
				'selector' => '{{WRAPPER}} .bdt-prime-slider-monster .bdt-prime-slider-social-icon h3',
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
			'arrows_heading',
			[ 
				'label'     => __( 'Arrows', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_responsive_control(
			'arrows_size',
			[ 
				'label'     => esc_html__( 'Size', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 10,
						'max' => 50,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-navigation-arrows .bdt-navigation-next, {{WRAPPER}} .bdt-prime-slider-monster .bdt-navigation-arrows .bdt-navigation-prev' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_responsive_control(
			'arrows_spacing',
			[ 
				'label'     => esc_html__( 'Spacing', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 10,
						'max' => 500,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-navigation-arrows .bdt-navigation-prev' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'show_navigation_arrows'   => [ 'yes' ],
					'navigation_center_arrows' => ''
				],
			]
		);

		$this->add_responsive_control(
			'arrows_acx_position',
			[ 
				'label'     => __( 'Spacing', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-navigation-arrows .bdt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-navigation-arrows .bdt-navigation-next' => 'right: {{SIZE}}px;',
				],
				'condition' => [ 
					'show_navigation_arrows'   => 'yes',
					'navigation_center_arrows' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'arrows_padding',
			[ 
				'label'      => __( 'Padding', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-navigation-arrows .bdt-navigation-next, {{WRAPPER}} .bdt-prime-slider-monster .bdt-navigation-arrows .bdt-navigation-prev' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'      => 'arrows_border',
				'selector'  => '{{WRAPPER}} .bdt-prime-slider-monster .bdt-navigation-arrows .bdt-navigation-next, {{WRAPPER}} .bdt-prime-slider-monster .bdt-navigation-arrows .bdt-navigation-prev',
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_responsive_control(
			'arrows_border_radius',
			[ 
				'label'      => __( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-navigation-arrows .bdt-navigation-next, {{WRAPPER}} .bdt-prime-slider-monster .bdt-navigation-arrows .bdt-navigation-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->start_controls_tabs( 'tabs_arrows_style' );

		$this->start_controls_tab(
			'tab_arrows_normal',
			[ 
				'label' => __( 'Normal', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'arrows_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-navigation-arrows .bdt-navigation-next, {{WRAPPER}} .bdt-prime-slider-monster .bdt-navigation-arrows .bdt-navigation-prev' => 'color: {{VALUE}}',
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
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .bdt-prime-slider-monster .bdt-navigation-arrows .bdt-navigation-next, {{WRAPPER}} .bdt-prime-slider-monster .bdt-navigation-arrows .bdt-navigation-prev',
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_arrows_hover',
			[ 
				'label' => __( 'Hover', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'arrows_hover_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-navigation-arrows .bdt-navigation-next:hover, {{WRAPPER}} .bdt-prime-slider-monster .bdt-navigation-arrows .bdt-navigation-prev:hover' => 'color: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'      => 'arrows_background_hover',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .bdt-prime-slider-monster .bdt-navigation-arrows .bdt-navigation-next:hover, {{WRAPPER}} .bdt-prime-slider-monster .bdt-navigation-arrows .bdt-navigation-prev:hover',
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_border_color',
			[ 
				'label'     => __( 'Border Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 
					'arrows_border_border!' => '',
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-monster .bdt-navigation-arrows .bdt-navigation-next:hover, {{WRAPPER}} .bdt-prime-slider-monster .bdt-navigation-arrows .bdt-navigation-prev:hover' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();


		$this->add_control(
			'pagination_heading',
			[ 
				'label'     => __( 'Pagination', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'pagination_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-monster .swiper-pagination .swiper-pagination-bullet' => 'background: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'pagination_active_color',
			[ 
				'label'     => __( 'Active Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-monster .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
			]
		);

		$this->add_responsive_control(
			'pagination_size',
			[ 
				'label'     => esc_html__( 'Size', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-monster .swiper-pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render_header() {
		$settings = $this->get_settings_for_display();
		$id       = 'bdt-prime-slider-' . $this->get_id();

		$this->add_render_attribute( 'prime-slider-monster', 'id', $id );
		$this->add_render_attribute( 'prime-slider-monster', 'class', [ 'bdt-prime-slider-monster', 'elementor-swiper' ] );

		$elementor_vp_lg = get_option( 'elementor_viewport_lg' );
		$elementor_vp_md = get_option( 'elementor_viewport_md' );
		$viewport_lg     = ! empty( $elementor_vp_lg ) ? $elementor_vp_lg - 1 : 1023;
		$viewport_md     = ! empty( $elementor_vp_md ) ? $elementor_vp_md - 1 : 767;

		if ( 'yes' == $settings['match_height'] ) {
			$this->add_render_attribute( 'prime-slider-monster', 'bdt-height-match', 'target: > div > div > div > .bdt-slider-item' );
		}

		/**
		 * Reveal Effects
		 */
		$this->reveal_effects_attr( 'prime-slider-monster' );

		$this->add_render_attribute(
			[ 
				'prime-slider-monster' => [ 
					'data-settings' => [ 
						wp_json_encode( array_filter( [ 
							"autoplay"        => ( "yes" == $settings["autoplay"] ) ? [ "delay" => $settings["autoplay_speed"] ] : false,
							"loop"            => ( $settings["loop"] == "yes" ) ? true : false,
							"speed"           => $settings["speed"]["size"],
							"pauseOnHover"    => ( "yes" == $settings["pauseonhover"] ) ? true : false,
							"slidesPerView"   => isset( $settings["columns_mobile"] ) ? (int) $settings["columns_mobile"] : 1,
							"slidesPerGroup"  => isset( $settings["slides_to_scroll_mobile"] ) ? (int) $settings["slides_to_scroll_mobile"] : 1,
							"spaceBetween"    => ! empty( $settings["item_gap_mobile"]["size"] ) ? (int) $settings["item_gap_mobile"]["size"] : 0,
							"centeredSlides"  => ( $settings["centered_slides"] === "yes" ) ? true : false,
							"grabCursor"      => ( $settings["grab_cursor"] === "yes" ) ? true : false,
							"effect"          => $settings["skin"],
							"observer"        => ( $settings["observer"] ) ? true : false,
							"observeParents"  => ( $settings["observer"] ) ? true : false,
							"breakpoints"     => [ 
								(int) $viewport_md => [ 
									"slidesPerView"  => isset( $settings["columns_tablet"] ) ? (int) $settings["columns_tablet"] : 3,
									"spaceBetween"   => ! empty( $settings["item_gap_tablet"]["size"] ) ? (int) $settings["item_gap_tablet"]["size"] : 0,
									"slidesPerGroup" => isset( $settings["slides_to_scroll_tablet"] ) ? (int) $settings["slides_to_scroll_tablet"] : 1,
								],
								(int) $viewport_lg => [ 
									"slidesPerView"  => isset( $settings["columns"] ) ? (int) $settings["columns"] : 3,
									"spaceBetween"   => ! empty( $settings["item_gap"]["size"] ) ? (int) $settings["item_gap"]["size"] : 0,
									"slidesPerGroup" => isset( $settings["slides_to_scroll"] ) ? (int) $settings["slides_to_scroll"] : 1,
								]
							],
							"navigation"      => [ 
								"nextEl" => "#" . $id . " .bdt-navigation-next",
								"prevEl" => "#" . $id . " .bdt-navigation-prev",
							],
							"pagination"      => [ 
								"el"        => "#" . $id . " .swiper-pagination",
								// "type"           => 'fraction',
								"clickable" => "true",
							],
							'coverflowEffect' => [ 
								'rotate'       => ( "yes" == $settings["coverflow_toggle"] ) ? $settings["coverflow_rotate"]["size"] : 0,
								'stretch'      => ( "yes" == $settings["coverflow_toggle"] ) ? $settings["coverflow_stretch"]["size"] : 180,
								'depth'        => ( "yes" == $settings["coverflow_toggle"] ) ? $settings["coverflow_depth"]["size"] : 100,
								'modifier'     => ( "yes" == $settings["coverflow_toggle"] ) ? $settings["coverflow_modifier"]["size"] : 1,
								'slideShadows' => ( $settings["slide_shadows"] === "yes" ) ? true : false,
							],

						] ) )
					]
				]
			]
		);

		$this->add_render_attribute( 'prime-slider', 'class', 'bdt-prime-slider' );


		if ( $settings['show_lightbox'] == 'yes' ) {
			$this->add_render_attribute( 'prime-slider', 'bdt-lightbox', '' );
			$this->add_render_attribute( 'prime-slider', 'bdt-lightbox', 'toggle: .bdt-lightbox-img; animation:' . $settings['lightbox_animation'] . ';' );
		}

		$swiper_class = Plugin::$instance->experiments->is_feature_active( 'e_swiper_latest' ) ? 'swiper' : 'swiper-container';
		$this->add_render_attribute( 'swiper', 'class', 'swiper-monster ' . $swiper_class );

		?>
		<div <?php $this->print_render_attribute_string( 'prime-slider' ); ?>>
			<div <?php $this->print_render_attribute_string( 'prime-slider-monster' ); ?>>
				<div <?php $this->print_render_attribute_string( 'swiper' ); ?>>
					<div class="swiper-wrapper">
						<?php
	}

	public function render_navigation_arrows() {
		$settings = $this->get_settings_for_display();

		if ( 'yes' == $settings['navigation_center_arrows'] ) {
			$this->add_render_attribute( 'prime-slider-arrows', 'class', 'bdt-arrows-center' );
		} else {
			$this->add_render_attribute( 'prime-slider-arrows', 'class', 'bdt-arrows-bottom' );
		}
		$this->add_render_attribute( 'prime-slider-arrows', 'class', 'bdt-navigation-arrows bdt-position-z-index reveal-muted' );


		?>

						<?php if ( $settings['show_navigation_arrows'] ) : ?>
							<div <?php $this->print_render_attribute_string( 'prime-slider-arrows' ); ?>>
								<div class="bdt-navigation-prev bdt-slidenav"><i class="ps-wi-arrow-left-5"></i></div>
								<div class="bdt-navigation-next bdt-slidenav"><i class="ps-wi-arrow-right-5"></i></div>
							</div>
						<?php endif; ?>

						<?php
	}

	public function render_navigation_dots() {
		$settings = $this->get_settings_for_display();

		?>
						<?php if ( $settings['show_navigation_dots'] ) : ?>

							<div class="swiper-pagination reveal-muted"></div>

						<?php endif; ?>
						<?php
	}

	public function render_footer() {
		$settings = $this->get_settings_for_display();

		?>
					</div>
				</div>

				<?php $this->render_navigation_dots(); ?>
				<?php $this->render_navigation_arrows(); ?>
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

	public function rendar_item_image( $slide, $alt = '' ) {
		$settings = $this->get_settings_for_display();

		$image_src = Group_Control_Image_Size::get_attachment_image_src( $slide['image']['id'], 'thumbnail_size', $settings );

		if ( $image_src ) {
			$image_final_src = $image_src;
		} elseif ( $slide['image']['url'] ) {
			$image_final_src = $slide['image']['url'];
		} else {
			return;
		}
		if ( $settings['show_lightbox'] == 'yes' ) {
			$this->add_render_attribute(
				[ 
					'lightbox-settings' => [ 
						'class'                        => [ 'bdt-lightbox-img' ],
						'data-elementor-open-lightbox' => 'no',
						'data-caption'                 => $slide['title'],
						'href'                         => esc_url( $image_final_src )
					]
				],
				'',
				'',
				true
			);
		} else {
			$this->add_render_attribute(
				[ 
					'lightbox-settings' => [ 
						'class'                        => [ 'bdt-lightbox-img' ],
						'data-elementor-open-lightbox' => 'no',
						'data-caption'                 => $slide['title'],
						'href'                         => esc_url( $slide['title_link']['url'] ),
						'target'                       => esc_attr( $slide['title_link']['is_external'] ? '_blank' : '_self' ),
					]
				],
				'',
				'',
				true
			);
		}


		?>
		<a <?php $this->print_render_attribute_string( 'lightbox-settings' ); ?>>
			<?php
			$thumb_url = Group_Control_Image_Size::get_attachment_image_src( $slide['image']['id'], 'thumbnail_size', $settings );
			if ( ! $thumb_url ) {
				printf( '<img src="%1$s" alt="%2$s">', esc_url($slide['image']['url']), esc_html( $slide['title'] ) );
			} else {
				print( wp_get_attachment_image(
					$slide['image']['id'],
					$settings['thumbnail_size_size'],
					false,
					[ 
						'alt' => esc_html( $slide['title'] )
					]
				) );
			}
			?>
		</a>
		<?php
	}

	public function render_slides_loop() {
		$settings = $this->get_settings_for_display();

		foreach ( $settings['slides'] as $slide ) : ?>

			<div class="swiper-slide">
				<div class="bdt-slider-item">
					<div class="bdt-slide-image">
						<?php $this->rendar_item_image( $slide, $slide['title'] ); ?>
						<?php if ( $slide['sub_title'] && ( 'yes' == $settings['show_sub_title'] ) ) : ?>
							<div class="bdt-slide-label" data-reveal="reveal-active">
								<?php echo wp_kses_post( $slide['sub_title'] ); ?>
							</div>
						<?php endif; ?>
					</div>
					<div class="bdt-prime-slider-content">

						<?php if ( $slide['title'] && ( 'yes' == $settings['show_title'] ) ) : ?>
							<div class="bdt-main-title">
								<<?php echo esc_attr(Utils::get_valid_html_tag( $settings['title_html_tag'] )); ?> class="bdt-title-tag"
									data-reveal="reveal-active">
									<?php if ( '' !== $slide['title_link']['url'] ) : ?>
										<a href="<?php echo esc_url( $slide['title_link']['url'] ); ?>">
										<?php endif; ?>
										<?php echo prime_slider_first_word( $slide['title'] ); ?>
										<?php if ( '' !== $slide['title_link']['url'] ) : ?>
										</a>
									<?php endif; ?>
								</<?php echo esc_attr(Utils::get_valid_html_tag( $settings['title_html_tag'] )); ?>>
							</div>
						<?php endif; ?>

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