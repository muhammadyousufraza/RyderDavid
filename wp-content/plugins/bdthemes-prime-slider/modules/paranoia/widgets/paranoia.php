<?php

namespace PrimeSliderPro\Modules\Paranoia\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Repeater;
use PrimeSliderPro\Utils;

use PrimeSlider\Traits\Global_Widget_Controls;

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

class Paranoia extends Widget_Base {

	use Global_Widget_Controls;

	public function get_name() {
		return 'prime-slider-paranoia';
	}

	public function get_title() {
		return BDTPS . esc_html__( 'Paranoia', 'bdthemes-prime-slider' );
	}

	public function get_icon() {
		return 'bdt-widget-icon ps-wi-paranoia';
	}

	public function get_categories() {
		return [ 'prime-slider-pro' ];
	}

	public function get_keywords() {
		return [ 'prime slider', 'slider', 'paranoia', 'prime' ];
	}

	public function get_style_depends() {
		return [ 'prime-slider-font', 'ps-paranoia' ];
	}

	public function get_script_depends() {
		$reveal_effects = prime_slider_option( 'reveal-effects', 'prime_slider_other_settings', 'off' );
		if ( 'on' === $reveal_effects ) {
			if ( true === true ) {
				return [ 'anime', 'revealFx', 'gsap', 'ps-paranoia' ];
			} else {
				return [ 'anime', 'gsap', 'ps-paranoia' ];
			}
		} else {
			return [ 'anime', 'gsap', 'ps-paranoia' ];
		}
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/n_OEl4wkuJE';
	}

	protected function register_controls() {
		$reveal_effects = prime_slider_option( 'reveal-effects', 'prime_slider_other_settings', 'off' );
		$this->start_controls_section(
			'section_content_layout',
			[ 
				'label' => esc_html__( 'Layout', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'slider_item_height',
			[ 
				'label'      => esc_html__( 'Height', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
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
					'{{WRAPPER}} .bdt-paranoia-slider, {{WRAPPER}} .bdt-paranoia-slider .bdt-slideshow' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		/**
		 * Show Sub Title Controls
		 */
		$this->register_show_sub_title_controls();

		/**
		 * Show Title Controls
		 */
		$this->register_show_title_controls();

		/**
		 * Show text Controls
		 */
		$this->register_show_text_controls();

		/**
		 * Show Readmore Controls
		 */
		$this->register_show_readmore_controls();

		/**
		 * Thumbnail Size Controls
		 */
		$this->register_thumbnail_size_controls();

		//Global background settings Controls
		$this->register_background_settings( '.bdt-paranoia-slider .bdt-gallery-img-inner' );

		$this->end_controls_section();

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
		 * Repeater Sub Title Controls
		 */
		$this->register_repeater_sub_title_controls( $repeater );

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
						'sub_title' => esc_html__( 'Explore', 'bdthemes-prime-slider' ),
						'title'     => esc_html__( 'Massive', 'bdthemes-prime-slider' ),
						'text'      => esc_html__( 'Prime Slider Addons for Elementor is a page builder extension that allows you to build sliders with drag and drop. It lets you create an amazing slider without touching no code at all!', 'bdthemes-prime-slider' ),
						'image'     => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-1.svg' ]
					],
					[ 
						'sub_title' => esc_html__( 'Explore', 'bdthemes-prime-slider' ),
						'title'     => esc_html__( 'Vibrant', 'bdthemes-prime-slider' ),
						'image'     => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-4.svg' ]
					],
					[ 
						'sub_title' => esc_html__( 'Explore', 'bdthemes-prime-slider' ),
						'title'     => esc_html__( 'Wallow', 'bdthemes-prime-slider' ),
						'image'     => [ 'url' => BDTPS_CORE_ASSETS_URL . 'images/gallery/item-5.svg' ]
					],
				],
				'title_field' => '{{{ title }}}',
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
				'label' => __( 'Sliders', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'slider_overlay_color',
			[ 
				'label'     => esc_html__( 'Overlay Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-paranoia-slider .bdt-gallery-img.bdt-slides-img:before' => 'background: {{VALUE}};',
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
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-paranoia-slider .bdt-main-title, {{WRAPPER}} .bdt-paranoia-slider .bdt-main-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .bdt-paranoia-slider .bdt-main-title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[ 
				'name'     => 'text_stroke',
				'selector' => '{{WRAPPER}} .bdt-paranoia-slider .bdt-main-title, {{WRAPPER}} .bdt-paranoia-slider .bdt-main-title a',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[ 
				'name'     => 'title_text_shadow',
				'label'    => __( 'Text Shadow', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-paranoia-slider .bdt-main-title',
			]
		);

		$this->add_control(
			'title_offset',
			[ 
				'label'        => __( 'Offset', 'bdthemes-element-pack' ) . BDTPS_PRO_PC,
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'None', 'bdthemes-element-pack' ),
				'label_on'     => __( 'Custom', 'bdthemes-element-pack' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'title_vertical_offset',
			[ 
				'label'       => __( 'Vertical', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [ 
					'px' => [ 
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors'   => [ 
					'{{WRAPPER}} .bdt-paranoia-slider .bdt-main-title' => 'transform: translateY({{SIZE}}px);'
				],
				'condition'   => [ 
					'title_offset' => 'yes'
				],
				'render_type' => 'ui'
			]
		);

		$this->end_popover();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_sub_title',
			[ 
				'label'     => __( 'Sub Title', 'bdthemes-prime-slider' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_sub_title' => 'yes'
				],
			]
		);

		$this->add_control(
			'sub_title_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-paranoia-slider .bdt-sub-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'sub_title_typography',
				'selector' => '{{WRAPPER}} .bdt-paranoia-slider .bdt-sub-title',
			]
		);

		$this->add_control(
			'sub_title_offset',
			[ 
				'label'        => __( 'Offset', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'None', 'bdthemes-element-pack' ),
				'label_on'     => __( 'Custom', 'bdthemes-element-pack' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'sub_title_vertical_offset',
			[ 
				'label'       => __( 'Vertical', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [ 
					'px' => [ 
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors'   => [ 
					'{{WRAPPER}} .bdt-paranoia-slider .bdt-sub-title' => 'transform: translateY({{SIZE}}px);'
				],
				'condition'   => [ 
					'sub_title_offset' => 'yes'
				],
				'render_type' => 'ui'
			]
		);

		$this->end_popover();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_text',
			[ 
				'label'     => __( 'Text', 'bdthemes-prime-slider' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_text' => 'yes'
				],
			]
		);

		$this->add_control(
			'text_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-paranoia-slider .bdt-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[ 
				'label'      => __( 'Padding', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-paranoia-slider .bdt-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
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
					'{{WRAPPER}} .bdt-paranoia-slider .bdt-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			'text_bottom_spacing',
			[ 
				'label'      => esc_html__( 'Bottom Spacing', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'range'      => [ 
					'px' => [ 
						'min' => 0,
						'max' => 1080,
					],
					'%'  => [ 
						'min' => 0,
						'max' => 100,
					],
					'vh' => [ 
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-paranoia-slider .bdt-text' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'text_typography',
				'selector' => '{{WRAPPER}} .bdt-paranoia-slider .bdt-text',
			]
		);

		$this->add_control(
			'text_offset',
			[ 
				'label'        => __( 'Offset', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'None', 'bdthemes-element-pack' ),
				'label_on'     => __( 'Custom', 'bdthemes-element-pack' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'text_vertical_offset',
			[ 
				'label'       => __( 'Vertical', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [ 
					'px' => [ 
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors'   => [ 
					'{{WRAPPER}} .bdt-paranoia-slider .bdt-text' => 'transform: translateY({{SIZE}}px);'
				],
				'condition'   => [ 
					'text_offset' => 'yes'
				],
				'render_type' => 'ui'
			]
		);

		$this->end_popover();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_read_more',
			[ 
				'label'     => esc_html__( 'Read More', 'bdthemes-prime-slider' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_readmore' => 'yes'
				]
			]
		);

		$this->add_control(
			'readmore_offset',
			[ 
				'label'        => __( 'Offset', 'bdthemes-element-pack' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'None', 'bdthemes-element-pack' ),
				'label_on'     => __( 'Custom', 'bdthemes-element-pack' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'readmore_vertical_offset',
			[ 
				'label'       => __( 'Vertical', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [ 
					'px' => [ 
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors'   => [ 
					'{{WRAPPER}} .bdt-paranoia-slider .bdt-link-btn' => 'transform: translateY({{SIZE}}px);'
				],
				'condition'   => [ 
					'readmore_offset' => 'yes'
				],
				'render_type' => 'ui'
			]
		);

		$this->end_popover();

		$this->start_controls_tabs( 'tabs_read_more_style' );

		$this->start_controls_tab(
			'tab_read_more_normal',
			[ 
				'label' => esc_html__( 'Normal', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'read_more_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-paranoia-slider .bdt-link-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'read_more_background',
				'selector' => '{{WRAPPER}} .bdt-paranoia-slider .bdt-link-btn:before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'     => 'read_more_border',
				'selector' => '{{WRAPPER}} .bdt-paranoia-slider .bdt-link-btn:before',
			]
		);

		$this->add_responsive_control(
			'read_more_border_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-paranoia-slider .bdt-link-btn:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'read_more_padding',
			[ 
				'label'      => esc_html__( 'Padding', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-paranoia-slider .bdt-link-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'read_more_height',
			[ 
				'label'      => esc_html__( 'Button Height', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 
					'px' => [ 
						'min' => 10,
						'max' => 200,
					],
				],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-paranoia-slider .bdt-link-btn:before' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'read_more_shadow',
				'selector' => '{{WRAPPER}} .bdt-paranoia-slider .bdt-link-btn:before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'read_more_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-paranoia-slider .bdt-link-btn',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_read_more_hover',
			[ 
				'label' => esc_html__( 'Hover', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'read_more_hover_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-paranoia-slider .bdt-link-btn:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'read_more_hover_background',
				'selector' => '{{WRAPPER}} .bdt-paranoia-slider .bdt-link-btn:hover:before',
			]
		);

		$this->add_control(
			'read_more_hover_border_color',
			[ 
				'label'     => esc_html__( 'Border Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-paranoia-slider .bdt-link-btn:hover:before' => 'border-color: {{VALUE}};',
				],
				'condition' => [ 
					'read_more_border_border!' => ''
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		//Navigation Css
		$this->start_controls_section(
			'section_style_navigation',
			[ 
				'label' => __( 'Navigation', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'navigation_opacity',
			[ 
				'label'     => esc_html__( 'Opacity', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min'  => 0,
						'max'  => 1,
						'step' => 0.1,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-paranoia-slider nav.nav:hover .bdt-nav-imgwrap' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'navigation_text_color',
			[ 
				'label'     => esc_html__( 'Text Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-paranoia-slider .nav:hover .nav__text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'navigation_text_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-paranoia-slider .nav__text',
			]
		);

		$this->end_controls_section();

	}

	protected function render_header() {
		$settings = $this->get_settings_for_display();
		$id       = 'bdt-prime-slider-' . $this->get_id();

		$this->add_render_attribute( 'prime-slider', 'class', 'bdt-prime-slider-paranoia' );

		/**
		 * Reveal Effects
		 */
		$this->reveal_effects_attr( 'ps-paranoia' );

		$this->add_render_attribute(
			[ 
				'ps-paranoia' => [ 
					'id'            => $id,
					'class'         => [ 'bdt-paranoia-slider' ],
					'data-settings' => [ 
						wp_json_encode( array_filter( [ 
							"id" => '#' . $id,
						] )
						),
					],
				],
			]
		);

		$this->add_render_attribute( 'slider', 'class', 'bdt-prime-slider' );

		?>
		<div <?php $this->print_render_attribute_string( 'slider' ); ?>>
			<div <?php $this->print_render_attribute_string( 'prime-slider' ); ?>>
				<div <?php $this->print_render_attribute_string( 'ps-paranoia' ); ?>>
					<div class="bdt-slideshow">

						<?php
	}

	public function render_footer() {
		$settings = $this->get_settings_for_display();

		?>

					</div>
				</div>
			</div>
		</div>

		<?php
	}

	public function render_readmore( $content ) {
		$settings = $this->get_settings_for_display();

		if ( '' == $settings['show_readmore'] ) {
			return;
		}

		$this->add_render_attribute( 'slider-button', 'class', 'bdt-link-btn reveal-muted', true );

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
		<?php if ( $content['slide_button_text'] && ( 'yes' == $settings['show_readmore'] ) ) : ?>
			<a <?php $this->print_render_attribute_string( 'slider-button' ); ?>>
				<span>
					<?php echo wp_kses( $content['slide_button_text'], prime_slider_allow_tags( 'title' ) ); ?>
				</span>
				<i class="ps-wi-arrow-right"></i>
			</a>
		<?php endif;
	}

	public function render_text() {
		$settings = $this->get_settings_for_display();

		$i = 0;
		?>
		<div class="meta">
			<div class="bdt-meta-content-wrap">

				<?php foreach ( $settings['slides'] as $slide ) :
					$i++; ?>

					<div class="bdt-meta-item-content">
						<div class="bdt-inner-top-content">
							<?php $this->render_sub_title( $slide, 'bdt-sub-title bdt-text-animation', 'reveal-active' ); ?>
							<?php $this->render_title( $slide, 'bdt-main-title', 'reveal-active' ); ?>
						</div>
						<div class="bdt-inner-bottom-content">
							<?php if ( $slide['text'] && ( 'yes' == $settings['show_text'] ) ) : ?>
								<div class="bdt-text" data-reveal="reveal-active">
									<?php echo wp_kses_post( $slide['text'] ); ?>
								</div>
							<?php endif; ?>
							<?php $this->render_readmore( $slide ); ?>
						</div>
					</div>

				<?php endforeach; ?>

			</div>
		</div>
		<?php
	}

	public function render_navigation_prev() {
		?>
		<nav class="nav bdt-nav--prev reveal-muted">
			<?php $this->render_gallery_items( 'bdt-nav-imgwrap', 'bdt-nav' ); ?>
			<button class="unbutton nav__text no-select">
				<?php echo esc_html_x( 'Prev', 'Frontend', 'bdthemes-prime-slider' ); ?>
			</button>
		</nav>
		<?php
	}

	public function render_navigation_next() {
		?>
		<nav class="nav bdt-nav--next reveal-muted">
			<?php $this->render_gallery_items( 'bdt-nav-imgwrap', 'bdt-nav' ); ?>
			<button class="unbutton nav__text no-select">
				<?php echo esc_html_x( 'Next', 'Frontend', 'bdthemes-prime-slider' ); ?>
			</button>
		</nav>
		<?php
	}

	public function render_gallery_items( $bdt_class_wrap, $bdt_class ) {
		$settings = $this->get_settings_for_display();

		$i = 0;
		?>
		<div class="<?php echo esc_attr( $bdt_class_wrap ) ?> slides">

			<?php foreach ( $settings['slides'] as $slide ) :
				$i++;

				$image_src = Group_Control_Image_Size::get_attachment_image_src( $slide['image']['id'], 'thumbnail_size', $settings );

				if ( $image_src ) {
					$image_final_src = $image_src;
				} elseif ( $slide['image']['url'] ) {
					$image_final_src = $slide['image']['url'];
				} else {
					return;
				}

				?>

				<div class="<?php echo esc_attr( $bdt_class ) ?>-img bdt-slides-img">
					<div class="<?php echo esc_attr( $bdt_class ) ?>-img-inner bdt-slides-img-inner"
						style="background-image: url('<?php echo esc_url( $image_final_src ); ?>')"></div>
				</div>

			<?php endforeach; ?>

		</div>
		<?php
	}

	public function render() {
		$this->render_header();

		$this->render_text();
		$this->render_navigation_prev();
		$this->render_navigation_next();
		$this->render_gallery_items( 'bdt-gallery-wrap', 'bdt-gallery' );

		$this->render_footer();
	}
}