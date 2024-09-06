<?php

namespace PrimeSliderPro\Modules\Fluent\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Icons_Manager;
use Elementor\Repeater;

use PrimeSlider\Traits\Global_Widget_Controls;
use PrimeSlider\Traits\QueryControls\GroupQuery\Group_Control_Query;
use PrimeSliderPro\Utils;
use WP_Query;

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

class Fluent extends Widget_Base {
	use Group_Control_Query;
	use Global_Widget_Controls;

	public function get_name() {
		return 'prime-slider-fluent';
	}

	public function get_title() {
		return BDTPS . esc_html__( 'Fluent', 'bdthemes-prime-slider' );
	}

	public function get_icon() {
		return 'bdt-widget-icon ps-wi-fluent';
	}

	public function get_categories() {
		return [ 'prime-slider-pro' ];
	}

	public function get_keywords() {
		return [ 'prime slider', 'slider', 'blog', 'prime', 'fluent' ];
	}

	public function get_style_depends() {
		return [ 'ps-fluent', 'prime-slider-font' ];
	}

	public function get_script_depends() {
		$reveal_effects = prime_slider_option( 'reveal-effects', 'prime_slider_other_settings', 'off' );
		if ( 'on' === $reveal_effects ) {
			return [ 'gsap', 'split-text', 'mThumbnailScroller', 'anime', 'revealFx', 'ps-fluent' ];
		} else {
			return [ 'gsap', 'split-text', 'mThumbnailScroller', 'ps-fluent' ];
		}
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/HxwdDoOsdMA';
	}

	protected function register_controls() {
		$reveal_effects = prime_slider_option( 'reveal-effects', 'prime_slider_other_settings', 'off' );
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
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-content' => 'text-align: {{VALUE}};',
				],
			]
		);

		/**
		 * Thumbnail Size Controls
		 */
		$this->register_thumbnail_size_controls();

		//Global background settings Controls
		$this->register_background_settings( '.bdt-prime-slider .bdt-slideshow-item>.bdt-ps-slide-img' );

		/**
		 * Show Title Controls
		 */
		$this->register_show_title_controls();

		/**
		 * Show Post Excerpt Controls
		 */
		$this->register_show_post_excerpt_controls();

		$this->add_control(
			'show_admin_info',
			[ 
				'label'     => esc_html__( 'Show Admin Meta', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'show_avatar',
			[ 
				'label'     => esc_html__( 'Show Avatar', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [ 
					'show_admin_info' => 'yes'
				]
			]
		);

		/**
		 * Show Category Controls
		 */
		$this->register_show_category_controls();

		/**
		 * Show date & human diff time Controls
		 */
		$this->register_show_date_and_human_diff_time_controls();

		/**
		 * Show social links Controls
		 */
		$this->register_show_social_link_controls();

		$this->add_control(
			'show_thumb_scroller',
			[ 
				'label'   => esc_html__( 'Show Thumbs', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		/**
		 * Show Navigation Controls
		 */
		$this->register_show_navigation_controls();

		$this->add_control(
			'show_scroll_button',
			[ 
				'label'   => esc_html__( 'Show Scroll Button', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		/**
		 * Scroll Down Controls
		 */
		$this->register_scroll_down_controls();

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
				'label' => __( 'Title', 'bdthemes-prime-slider' ),
				'type'  => Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'social_link',
			[ 
				'label' => __( 'Link', 'bdthemes-prime-slider' ),
				'type'  => Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'social_icon',
			[ 
				'label' => __( 'Choose Icon', 'bdthemes-prime-slider' ),
				'type'  => Controls_Manager::ICONS,
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
						'social_icon'       => [ 'value' => 'fab fa-facebook-f', 'library' => 'fa-brands' ],
						'social_link_title' => 'Facebook',
					],
					[ 
						'social_link'       => __( 'http://www.twitter.com/bdthemes/', 'bdthemes-prime-slider' ),
						'social_icon'       => [ 'value' => 'fab fa-twitter', 'library' => 'fa-brands' ],
						'social_link_title' => 'Twitter',
					],
					[ 
						'social_link'       => __( 'http://www.vimeo.com//bdthemes/', 'bdthemes-prime-slider' ),
						'social_icon'       => [ 'value' => 'fab fa-vimeo-v', 'library' => 'fa-brands' ],
						'social_link_title' => 'Vimeo',
					],
					[ 
						'social_link'       => __( 'http://www.instagram.com/bdthemes/', 'bdthemes-prime-slider' ),
						'social_icon'       => [ 'value' => 'fab fa-instagram', 'library' => 'fa-brands' ],
						'social_link_title' => 'Instagram',
					],
				],
				'title_field' => '{{{ social_link_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_post_query_builder',
			[ 
				'label' => __( 'Query', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->register_query_builder_controls();

		$this->update_control(
			'posts_limit',
			[ 
				'type'    => Controls_Manager::NUMBER,
				'default' => 9,
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

		/**
		 * Advanced Animation
		 */
		$this->start_controls_section(
			'section_advanced_animation',
			[ 
				'label' => esc_html__( 'Advanced Animation', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'animation_status',
			[ 
				'label'   => esc_html__( 'Advanced Animation', 'bdthemes-element-pack' ),
				'type'    => Controls_Manager::SWITCHER,
				'classes' => BDTPS_PRO_IS_PC,
			]
		);

		if ( true === true ) {

			$this->add_control(
				'animation_of',
				[ 
					'label'     => __( 'Animation Of', 'bdthemes-element-pack' ),
					'type'      => Controls_Manager::SELECT2,
					'multiple'  => true,
					'options'   => [ 
						'.bdt-title-tag' => __( 'Title', 'bdthemes-element-pack' ),
						'.bdt-blog-text' => __( 'Excerpt', 'bdthemes-element-pack' ),
					],
					'default'   => [ '.bdt-title-tag' ],
					'condition' => [ 
						'animation_status' => 'yes'
					]
				]
			);

			/**
			 * Advanced Animation
			 */
			$this->register_advanced_animation_controls();

		}

		$this->end_controls_section();

		/**
		 * Reveal Effects
		 */
		if ( 'on' === $reveal_effects ) {
			$this->register_reveal_effects();
		}

		//Style Start
		$this->start_controls_section(
			'section_style_sliders',
			[ 
				'label' => esc_html__( 'Sliders', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
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

		$this->add_control(
			'ps_content_innner_padding',
			[ 
				'label'      => esc_html__( 'Content Inner Padding', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_left_spacing',
			[ 
				'label'      => esc_html__( 'Left Spacing', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 
					'px' => [ 
						'min' => 0,
						'max' => 600,
					],
				],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider-fluent .bdt-prime-slider-content' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-prime-slider-fluent .bdt-scroll-down-wrapper'  => 'left: calc({{SIZE}}{{UNIT}} + 15px);',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_slider_style' );

		$this->start_controls_tab(
			'tab_slider_title',
			[ 
				'label' => __( 'Title', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'title_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-title-tag a' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .bdt-prime-slider .bdt-title-tag a:hover, {{WRAPPER}} .bdt-prime-slider .bdt-title-tag a:hover .frist-word' => 'color: {{VALUE}};',
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
				'selector'  => '{{WRAPPER}} .bdt-prime-slider .bdt-title-tag',
				'condition' => [ 
					'show_title' => [ 'yes' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[ 
				'name'      => 'title_shadow',
				'label'     => esc_html__( 'Text Shadow', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'selector'  => '{{WRAPPER}} .bdt-prime-slider .bdt-title-tag',
				'condition' => [ 
					'show_title' => [ 'yes' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[ 
				'name'      => 'title_stroke',
				'label'     => esc_html__( 'Text Stroke', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'selector'  => '{{WRAPPER}} .bdt-prime-slider .bdt-title-tag',
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
					'{{WRAPPER}} .bdt-prime-slider .bdt-title-tag' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'show_title' => [ 'yes' ],
				],
			]
		);

		$this->add_responsive_control(
			'title_width',
			[ 
				'label'     => esc_html__( 'Title Width', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 220,
						'max' => 1200,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'show_title' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'first_word_style',
			[ 
				'label'     => esc_html__( 'First Word Style', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'first_word_title_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-title-tag .frist-word' => 'color: {{VALUE}};',
				],
				'condition' => [ 
					'show_title'       => [ 'yes' ],
					'first_word_style' => [ 'yes' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'      => 'first_word_typography',
				'selector'  => '{{WRAPPER}} .bdt-prime-slider .frist-word',
				'condition' => [ 
					'show_title'       => [ 'yes' ],
					'first_word_style' => [ 'yes' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_slider_text',
			[ 
				'label'     => __( 'Text', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_excerpt' => 'yes'
				],
			]
		);

		$this->add_control(
			'excerpt_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-content .bdt-blog-text' => 'color: {{VALUE}};',
				],
				'condition' => [ 
					'show_excerpt' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'excerpt_spacing',
			[ 
				'label'     => __( 'Spacing', 'bdthemes-element-pack' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-content .bdt-blog-text' => 'padding-top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'show_excerpt' => 'yes'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'      => 'excerpt_typography',
				'selector'  => '{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-content .bdt-blog-text',
				'condition' => [ 
					'show_excerpt' => 'yes'
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_slider_category',
			[ 
				'label'     => __( 'Category', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_category' => 'yes',
				],
			]
		);

		$this->add_control(
			'category_icon_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-content .bdt-ps-category a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'category_icon_background_color',
			[ 
				'label'     => __( 'Background', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-content .bdt-ps-category a' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'     => 'category_border',
				'label'    => esc_html__( 'Border', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-content .bdt-ps-category a',
			]
		);

		$this->add_responsive_control(
			'category_border_radius',
			[ 
				'label'      => esc_html__( 'Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-content .bdt-ps-category a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'category_padding',
			[ 
				'label'      => esc_html__( 'Padding', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-content .bdt-ps-category a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'category_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-content .bdt-ps-category a',
			]
		);

		$this->add_responsive_control(
			'ps_category_spacing',
			[ 
				'label'     => esc_html__( 'Space Between', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-content .bdt-ps-category a + a' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_slider_meta',
			[ 
				'label'     => __( 'Meta', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_admin_info' => 'yes',
				],
			]
		);

		$this->add_control(
			'meta_text_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-meta .bdt-author, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-meta .bdt-author a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'meta_text_hover_color',
			[ 
				'label'     => __( 'Hover Color', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-meta .bdt-author a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'meta_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-meta .bdt-author',
			]
		);

		$this->add_control(
			'avatar_heading',
			[ 
				'label'     => __( 'AVATAR', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [ 
					'show_avatar' => 'yes',
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'avatar_size',
			[ 
				'label'     => _x( 'Size', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'type'      => Controls_Manager::SELECT,
				'default'   => '42',
				'options'   => [ 
					'24' => '24 X 24',
					'36' => '36 X 36',
					'42' => '42 X 42',
					'48' => '48 X 48',
					'60' => '60 X 60',
					'70' => '70 X 70',
					'90' => '90 X 90',
				],
				'condition' => [ 
					'show_avatar' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'avatar_spacing',
			[ 
				'label'     => esc_html__( 'Spacing', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-post-slider-author' => 'margin-right: {{SIZE}}{{UNIT}} !important;',
				],
				'condition' => [ 
					'show_avatar' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'avatar_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-post-slider-author, {{WRAPPER}} .bdt-prime-slider .bdt-post-slider-author img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [ 
					'show_avatar' => 'yes',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_slider_date',
			[ 
				'label'     => __( 'Date', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_date' => 'yes',
				],
			]
		);

		$this->add_control(
			'date_text_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-fluent .bdt-prime-slider-date' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'date_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-prime-slider-fluent .bdt-prime-slider-date',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();


		$this->start_controls_section(
			'section_style_thumb_scroller',
			[ 
				'label'     => esc_html__( 'Thumbs', 'bdthemes-prime-slider' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_thumb_scroller' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'thumb_width',
			[ 
				'label'      => esc_html__( 'Column Width', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 
					'px' => [ 
						'min' => 100,
						'max' => 500,
					],
				],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider-fluent .bdt-thumbnav-wrap' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_thumbs_style' );

		$this->start_controls_tab(
			'tab_thumbs_normal',
			[ 
				'label' => esc_html__( 'Normal', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'thumb_scroller_title_color',
			[ 
				'label'     => esc_html__( 'Text Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-fluent .bdt-ps-thumbnav .bdt-thumb-content h3' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'thumbs_background_color',
			[ 
				'label'     => esc_html__( 'Background Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-fluent .bdt-thumbnav-wrap' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'thumbs_border_color',
			[ 
				'label'     => esc_html__( 'Border Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-fluent .bdt-ps-thumbnav' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'thumbs_item_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider-fluent .bdt-ps-thumbnav .bdt-thumb-content:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'thumbs_item_padding',
			[ 
				'label'      => esc_html__( 'Padding', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider-fluent .bdt-ps-thumbnav .bdt-thumb-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'thumbs_item_margin',
			[ 
				'label'      => esc_html__( 'Margin', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider-fluent .bdt-ps-thumbnav .bdt-thumb-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'thumb_scroller_title_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-prime-slider-fluent .bdt-ps-thumbnav .bdt-thumb-content h3',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_thumbs_hover',
			[ 
				'label' => esc_html__( 'Hover', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'thumbs_title_hover_color',
			[ 
				'label'     => esc_html__( 'Text Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-fluent .bdt-ps-thumbnav:hover .bdt-thumb-content h3' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'thumbs_background_hover_color',
			[ 
				'label'     => esc_html__( 'Background Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-fluent .bdt-ps-thumbnav:hover .bdt-thumb-content:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_thumbs_active',
			[ 
				'label' => esc_html__( 'Active', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'thumbs_title_active_color',
			[ 
				'label'     => esc_html__( 'Text Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-fluent .bdt-ps-thumbnav.bdt-active .bdt-thumb-content h3' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'thumb_scroller_item_background',
			[ 
				'label'     => __( 'Background Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-fluent .bdt-ps-thumbnav.bdt-active .bdt-thumb-content:before' => 'background: {{VALUE}}',
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

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'social_line_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .bdt-prime-slider-fluent.bdt-ps-icon .bdt-prime-slider-content:before',
			]
		);

		$this->add_responsive_control(
			'social_line_width',
			[ 
				'label'      => esc_html__( 'Column Width', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 
					'px' => [ 
						'min' => 10,
						'max' => 200,
					],
				],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prime-slider-fluent.bdt-ps-icon .bdt-prime-slider-content:before' => 'width: {{SIZE}}{{UNIT}};',
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

		$this->add_responsive_control(
			'social_icon_spacing',
			[ 
				'label'     => esc_html__( 'Icon Spacing', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-social-icon a' => 'margin-bottom: {{SIZE}}{{UNIT}}; margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'social_icon_position',
			[ 
				'label'     => esc_html__( 'Icon Position', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-fluent .bdt-prime-slider-social-icon' => 'right: {{SIZE}}{{UNIT}};',
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
			'section_style_scroll_down',
			[ 
				'label'     => __( 'Scroll Down', 'bdthemes-prime-slider' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_scroll_button' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'scroll_down_primary_color',
			[ 
				'label'     => __( 'Primary Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-fluent .bdt-scroll-down-wrapper .bdt-scroll-down-content-wrapper span' => '--primary-border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'scroll_down_secondary_color',
			[ 
				'label'     => __( 'Secondary Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-fluent .bdt-scroll-down-wrapper .bdt-scroll-down-content-wrapper span' => '--secondary-border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[ 
				'label'     => __( 'Navigation', 'bdthemes-prime-slider' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->start_controls_tabs( 'tabs_navigation_style' );

		$this->start_controls_tab(
			'tab_nav_arrows_dots_style',
			[ 
				'label' => __( 'Normal', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'arrows_color',
			[ 
				'label'     => __( 'Arrows Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-previous svg, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-next svg' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_size',
			[ 
				'label'     => esc_html__( 'Arrows Size', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-fluent .bdt-prime-slider-next svg, {{WRAPPER}} .bdt-prime-slider-fluent .bdt-prime-slider-previous svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_spacing',
			[ 
				'label'     => esc_html__( 'Arrows Spacing', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-fluent .bdt-navigation-arrows' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_nav_arrows_dots_hover_style',
			[ 
				'label' => __( 'Hover', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'arrows_hover_color',
			[ 
				'label'     => __( 'Arrows Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-previous:hover svg, {{WRAPPER}} .bdt-prime-slider .bdt-prime-slider-next:hover svg' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	public function query_posts() {
		$settings = $this->get_settings();
		$args     = [];
		if ( $settings['posts_limit'] ) {
			$args['posts_per_page'] = $settings['posts_limit'];
			$args['paged']          = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
		}

		$default = $this->getGroupControlQueryArgs();
		$args    = array_merge( $default, $args );

		$query = new WP_Query( $args );

		return $query;
	}

	public function render_header( $skin_name = 'fluent' ) {
		$settings = $this->get_settings_for_display();

		/**
		 * Advanced Animation
		 */
		$this->adv_anim( 'slideshow' );
		$this->add_render_attribute( 'slideshow', 'id', 'bdt-' . $this->get_id() );

		/**
		 * Reveal Effects
		 */
		$this->reveal_effects_attr( 'slideshow' );

		$this->add_render_attribute( 'prime-slider', 'class', 'bdt-prime-slider-' . $skin_name );


		if ( 'yes' == $settings['show_social_icon'] ) {
			$this->add_render_attribute( 'prime-slider', 'class', 'bdt-ps-icon' );
		}

		/**
		 * Slideshow Settings
		 */
		$this->render_slideshows_settings( '460' );

	}

	public function render_category() {
		?>
		<div class="bdt-ps-category reveal-muted">
			<?php echo get_the_category_list( ' ' ); ?>
		</div>
		<?php
	}

	public function render_scroll_button() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'bdt-scroll-down', 'class', [ 'bdt-scroll-down reveal-muted' ] );


		if ( '' == $settings['show_scroll_button'] ) {
			return;
		}

		$this->add_render_attribute(
			[ 
				'bdt-scroll-down' => [ 
					'data-settings' => [ 
						wp_json_encode( array_filter( [ 
							'duration' => ( '' != $settings['duration']['size'] ) ? $settings['duration']['size'] : '',
							'offset'   => ( '' != $settings['offset']['size'] ) ? $settings['offset']['size'] : '',
						] ) )
					]
				]
			]
		);

		$this->add_render_attribute( 'bdt-scroll-down', 'data-selector', '#' . esc_attr( $settings['section_id'] ) );
		$this->add_render_attribute( 'bdt-scroll-wrapper', 'class', 'bdt-scroll-down-wrapper' );

		?>
		<div <?php $this->print_render_attribute_string( 'bdt-scroll-wrapper' ); ?>>
			<div <?php $this->print_render_attribute_string( 'bdt-scroll-down' ); ?>>
				<div bdt-scrollspy="cls: bdt-animation-slide-bottom; repeat: true">
					<div class="bdt-scroll-down-content-wrapper">
						<span></span>
						<span></span>
						<span></span>
					</div>
				</div>
			</div>
		</div>

		<?php
	}

	public function render_social_link( $position = 'left' ) {
		$settings = $this->get_settings_for_display();

		if ( '' == $settings['show_social_icon'] ) {
			return;
		}

		$this->add_render_attribute( 'social-icon', 'class', 'bdt-prime-slider-social-icon bdt-position-center-right reveal-muted' );

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

	public function render_date() {
		$settings = $this->get_settings_for_display();


		if ( ! $this->get_settings( 'show_date' ) ) {
			return;
		}

		?>
		<div class="bdt-prime-slider-date bdt-position-top-right bdt-flex bdt-flex-middle" data-reveal="reveal-active">
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

	public function render_navigation_arrows() {
		$settings = $this->get_settings_for_display();

		?>

		<?php if ( $settings['show_navigation_arrows'] ) : ?>
			<div class="bdt-navigation-arrows bdt-position-bottom-right bdt-position-z-index reveal-muted">
				<a class="bdt-prime-slider-previous" href="#" bdt-slidenav-previous bdt-slideshow-item="previous"></a>
				<a class="bdt-prime-slider-next" href="#" bdt-slidenav-next bdt-slideshow-item="next"></a>
			</div>
		<?php endif; ?>

		<?php

	}

	public function render_thumbnav() {
		$settings = $this->get_settings_for_display();
		?>

		<?php if ( 'yes' == $settings['show_thumb_scroller'] ) : ?>
			<div class="bdt-thumbnav-wrap bdt-position-center-left reveal-muted">
				<div class="bdt-thumbnav-scroller">
					<ul>
						<?php
						$slide_index = 1;

						global $post;

						$wp_query = $this->query_posts();

						if ( ! $wp_query->found_posts ) {
							return;
						}

						while ( $wp_query->have_posts() ) {
							$wp_query->the_post();

							?>

							<li class="bdt-ps-thumbnav" bdt-slideshow-item="<?php echo esc_attr(( $slide_index - 1 )); ?>">
								<a href="javascript:void(0);">
									<div class="bdt-thumb-content">
										<?php //if ('yes' == $settings['show_category']) : ?>
										<?php //$this->render_category(); ?>
										<?php //endif; ?>
										<?php if ( 'yes' == $settings['show_title'] ) : ?>
											<h3>
												<?php echo get_the_title(); ?>
											</h3>
										<?php endif; ?>
									</div>
								</a>
								<?php $slide_index++; ?>
							</li>

							<?php
						}

						wp_reset_postdata(); ?>

					</ul>
				</div>
			</div>
		<?php endif; ?>

		<?php
	}

	public function render_footer() {
		?>

		</ul>

		<?php $this->render_navigation_arrows(); ?>

		<?php $this->render_thumbnav(); ?>

		</div>

		<?php $this->render_social_link(); ?>
		<?php $this->render_scroll_button(); ?>
		</div>
		</div>
		<?php
	}

	public function render_excerpt() {
		$settings = $this->get_settings_for_display();

		if ( ! $this->get_settings( 'show_excerpt' ) ) {
			return;
		}

		$strip_shortcode = $this->get_settings_for_display( 'strip_shortcode' );

		$parallax_text = 'y: 100,0,-100; opacity: 1,1,0';

		if ( $settings['animation_status'] == 'yes' && ! empty( $settings['animation_of'] ) ) {

			if ( in_array( ".bdt-blog-text", $settings['animation_of'] ) ) {
				$parallax_text = '';
			}
		}

		?>
		<div class="bdt-blog-text" data-reveal="reveal-active" data-bdt-slideshow-parallax="<?php echo esc_attr( $parallax_text ); ?>">
			<?php
			if ( has_excerpt() ) {
				the_excerpt();
			} else {
				echo prime_slider_custom_excerpt( $this->get_settings_for_display( 'excerpt_length' ), $strip_shortcode );
			}
			?>
		</div>
		<?php
	}

	public function render_author_info() {
		$settings = $this->get_settings_for_display();

		if ( ! $this->get_settings( 'show_admin_info' ) ) {
			return;
		}

		$avatar_size = $settings['avatar_size'];

		?>
		<div class="bdt-prime-slider-meta bdt-flex-inline bdt-flex-middile" data-reveal="reveal-active"
			data-bdt-slideshow-parallax="y: 70,-30">
			<?php if ( $settings['show_avatar'] ) : ?>
				<div class="bdt-post-slider-author bdt-margin-small-right bdt-border-circle bdt-overflow-hidden bdt-flex-inline">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), $avatar_size ); ?>
				</div>
			<?php endif; ?>
			<div class="bdt-meta-author bdt-flex bdt-flex-middle">
				<span class="bdt-author bdt-text-capitalize">
					<?php echo esc_html_x( 'Published by ', 'Frontend', 'bdthemes-prime-slider' ); ?>
					<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
						<?php echo esc_attr( get_the_author() ); ?>
					</a>
				</span>
			</div>
		</div>
		<?php
	}

	public function render_title( $post ) {
		$settings = $this->get_settings_for_display();

		if ( ! $this->get_settings( 'show_title' ) ) {
			return;
		}

		$parallax_title = 'data-bdt-slideshow-parallax="y: 80,0,-80; opacity: 1,1,0"';

		if ( $settings['animation_status'] == 'yes' && ! empty( $settings['animation_of'] ) ) {

			if ( in_array( ".bdt-title-tag", $settings['animation_of'] ) ) {
				$parallax_title = '';
			}
		}

		?>
		<div class="bdt-main-title">
			<<?php echo esc_attr(Utils::get_valid_html_tag( $settings['title_html_tag'] )); ?> class="bdt-title-tag"
				data-reveal="reveal-active"
				<?php echo wp_kses_post($parallax_title); ?>>
				<a href="<?php echo esc_url( get_permalink( $post->ID ) ); ?>">
					<?php echo prime_slider_first_word( get_the_title() ); ?>
				</a>
			</<?php echo esc_attr(Utils::get_valid_html_tag( $settings['title_html_tag'] )); ?>>
		</div>
		<?php
	}

	public function render_item_content( $post ) {
		$settings = $this->get_settings_for_display();

		?>

		<div class="bdt-prime-slider-content">

			<?php $this->render_date(); ?>

			<?php if ( 'yes' == $settings['show_category'] ) : ?>
				<div class="bdt-ps-category-wrapper">
					<?php $this->render_category(); ?>
				</div>
			<?php endif; ?>

			<?php $this->render_author_info(); ?>
			<?php $this->render_title( $post ); ?>
			<?php $this->render_excerpt(); ?>

		</div>

		<?php
	}

	public function render_slides_loop() {
		$settings = $this->get_settings_for_display();

		$kenburns_reverse = $settings['kenburns_reverse'] ? ' bdt-animation-reverse' : '';

		$slide_index = 1;

		global $post;

		$wp_query = $this->query_posts();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		while ( $wp_query->have_posts() ) {
			$wp_query->the_post();

			?>

			<li class="bdt-slideshow-item bdt-flex bdt-flex-middle elementor-repeater-item-<?php echo esc_attr(get_the_ID()); ?>">

				<?php if ( 'yes' == $settings['kenburns_animation'] ) : ?>
					<div
						class="bdt-position-cover bdt-animation-kenburns<?php echo esc_attr( $kenburns_reverse ); ?> bdt-transform-origin-center-left">
					<?php endif; ?>

					<?php $this->rendar_post_image( "bdt-ps-slide-img" ); ?>

					<?php if ( 'yes' == $settings['kenburns_animation'] ) : ?>
					</div>
				<?php endif; ?>

				<?php if ( 'none' !== $settings['overlay'] ) :
					$blend_type = ( 'blend' == $settings['overlay'] ) ? ' bdt-blend-' . $settings['blend_type'] : ''; ?>
					<div class="bdt-overlay-default bdt-position-cover<?php echo esc_attr( $blend_type ); ?>"></div>
				<?php endif; ?>

				<?php $this->render_item_content( $post ); ?>

				<?php $slide_index++; ?>

			</li>


			<?php
		}

		wp_reset_postdata();
	}

	public function render() {

		$this->render_header();

		$this->render_slides_loop();

		$this->render_footer();
	}
}
