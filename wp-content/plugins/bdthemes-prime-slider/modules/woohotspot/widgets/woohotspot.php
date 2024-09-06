<?php

namespace PrimeSliderPro\Modules\Woohotspot\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Plugin;
use PrimeSliderPro\Utils;

use PrimeSlider\Traits\Global_Widget_Controls;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Exit if accessed directly

class Woohotspot extends Widget_Base {

	use Global_Widget_Controls;

	public function get_name() {
		return 'prime-slider-woohotspot';
	}

	public function get_title() {
		return BDTPS . esc_html__( 'Woo HotSpot', 'bdthemes-prime-slider' );
	}

	public function get_icon() {
		return 'bdt-widget-icon ps-wi-woohotspot bdt-new';
	}

	public function get_categories() {
		return [ 'prime-slider-pro' ];
	}

	public function get_keywords() {
		return [ 'prime slider', 'slider', 'marker', 'prime', 'woocommerce', 'woohotspot', 'wc' ];
	}

	public function get_style_depends() {
		return [ 'prime-slider-font', 'ps-woohotspot', 'tippy' ];
	}

	public function get_script_depends() {
		return [ 'shutters', 'gl', 'slicer', 'tinder', 'popper', 'tippyjs', 'ps-woohotspot' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/vuYYnjSogqU';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_marker_image',
			[ 
				'label' => __( 'Slide Item One', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'image',
			[ 
				'label'   => __( 'Choose Products Image', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [ 
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'tabs_markers' );

		$repeater->start_controls_tab(
			'tab_marker',
			[ 
				'label' => __( 'Hotspot', 'bdthemes-prime-slider' ),
			]
		);

		$repeater->add_control(
			'select_type',
			[ 
				'label'   => __( 'Select Type', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [ 
					'none'  => [ 
						'title' => __( 'None', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-editor-close',
					],
					'text'  => [ 
						'title' => __( 'Text', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-text-area',
					],
					'icon'  => [ 
						'title' => __( 'Icon', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-star',
					],
					'image' => [ 
						'title' => __( 'Image', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-image',
					],
				],
				'default' => 'icon',
				'toggle'  => false,
			]
		);

		$repeater->add_control(
			'text',
			[ 
				'type'      => Controls_Manager::TEXT,
				'label'     => __( 'Text', 'bdthemes-prime-slider' ),
				'default'   => 'Marker',
				'dynamic'   => [ 
					'active' => true,
				],
				'condition' => [ 
					'select_type' => 'text',
				],
			]
		);

		$repeater->add_control(
			'marker_select_icon',
			[ 
				'label'     => esc_html__( 'Icon', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::ICONS,
				'condition' => [ 
					'select_type' => 'icon',
				],
			]
		);

		$repeater->add_control(
			'image',
			[ 
				'type'       => Controls_Manager::MEDIA,
				'show_label' => false,
				'dynamic'    => [ 
					'active' => true,
				],
				'default'    => [ 
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition'  => [ 
					'select_type' => 'image',
				],
			]
		);

		$repeater->add_responsive_control(
			'marker_invisible_height',
			[ 
				'label'          => __( 'Height', 'bdthemes-prime-slider' ),
				'type'           => Controls_Manager::SLIDER,
				'default'        => [ 
					'size' => 20,
				],
				'tablet_default' => [ 
					'size' => 20,
				],
				'mobile_default' => [ 
					'size' => 20,
				],
				'size_units'     => [ 'px', '%' ],
				'range'          => [ 
					'px' => [ 
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'      => [ 
					'{{WRAPPER}} .bdt-woohotspot-wrap {{CURRENT_ITEM}}.bdt-woohotspot-item' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition'      => [ 
					'select_type' => 'none',
				],
			]
		);

		$repeater->add_responsive_control(
			'marker_invisible_width',
			[ 
				'label'          => __( 'Width', 'bdthemes-prime-slider' ),
				'type'           => Controls_Manager::SLIDER,
				'default'        => [ 
					'size' => 20,
				],
				'tablet_default' => [ 
					'size' => 20,
				],
				'mobile_default' => [ 
					'size' => 20,
				],
				'size_units'     => [ 'px', '%' ],
				'range'          => [ 
					'px' => [ 
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'      => [ 
					'{{WRAPPER}} .bdt-woohotspot-wrap {{CURRENT_ITEM}}.bdt-woohotspot-item' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'      => [ 
					'select_type' => 'none',
				],
			]
		);

		$repeater->add_responsive_control(
			'marker_x_position',
			[ 
				'label'     => esc_html__( 'X Postion', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'%' => [ 
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-woohotspot-wrap {{CURRENT_ITEM}}.bdt-woohotspot-item' => 'left: {{SIZE}}%;',
				],
			]
		);

		$repeater->add_responsive_control(
			'marker_y_position',
			[ 
				'label'     => esc_html__( 'Y Postion', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'%' => [ 
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-woohotspot-wrap {{CURRENT_ITEM}}.bdt-woohotspot-item' => 'top: {{SIZE}}%;',
				],
			]
		);

		$repeater->add_control(
			'marker_tooltip_placement',
			[ 
				'label'       => esc_html__( 'Placement', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'top',
				'options'     => [ 
					'top-start'    => esc_html__( 'Top Left', 'bdthemes-prime-slider' ),
					'top'          => esc_html__( 'Top', 'bdthemes-prime-slider' ),
					'top-end'      => esc_html__( 'Top Right', 'bdthemes-prime-slider' ),
					'bottom-start' => esc_html__( 'Bottom Left', 'bdthemes-prime-slider' ),
					'bottom'       => esc_html__( 'Bottom', 'bdthemes-prime-slider' ),
					'bottom-end'   => esc_html__( 'Bottom Right', 'bdthemes-prime-slider' ),
					'left'         => esc_html__( 'Left', 'bdthemes-prime-slider' ),
					'right'        => esc_html__( 'Right', 'bdthemes-prime-slider' ),
				],
				'render_type' => 'template',
			]
		);

		$repeater->add_control(
			'advanced_option_toggle',
			[ 
				'label'        => __( 'Hotspot Style', 'bdthemes-prime-slider' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'None', 'bdthemes-prime-slider' ),
				'label_on'     => __( 'Custom', 'bdthemes-prime-slider' ),
				'return_value' => 'yes',
			]
		);



		$repeater->start_popover();

		$repeater->add_control(
			'repeater_marker_color',
			[ 
				'label'       => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ 
					'{{WRAPPER}} .bdt-woohotspot-wrap {{CURRENT_ITEM}}.bdt-woohotspot' => 'color: {{VALUE}};',
				],
				'render_type' => 'ui',
				'condition'   => [ 
					'advanced_option_toggle' => 'yes',
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'        => 'repeater_marker_background',
				'selector'    => '{{WRAPPER}} .bdt-woohotspot-wrap {{CURRENT_ITEM}}.bdt-woohotspot',
				'render_type' => 'ui',
				'condition'   => [ 
					'advanced_option_toggle' => 'yes',
				],
			]
		);

		$repeater->end_popover();

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'tab_tooltip',
			[ 
				'label' => __( 'Product', 'bdthemes-prime-slider' ),
			]
		);

		$repeater->add_control(
			'product_title',
			[ 
				'label'       => esc_html__( 'Title', 'bdthemes-prime-slider' ),
				'default'     => esc_html__( 'Title Here', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'product_text',
			[ 
				'label'       => esc_html__( 'Text', 'bdthemes-prime-slider' ),
				'default'     => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::WYSIWYG,
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'product_price',
			[ 
				'label'       => esc_html__( 'Price', 'bdthemes-prime-slider' ),
				'default'     => esc_html__( '$124.00', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'product_link_text',
			[ 
				'label'       => esc_html__( 'Button', 'bdthemes-prime-slider' ),
				'default'     => esc_html__( 'Buy Now', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'product_link',
			[ 
				'label'       => esc_html__( 'Link', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'http://your-link.com',
				'default'     => [ 
					'url' => '#',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'markers',
			[ 
				'label'       => esc_html__( 'Hotspot Items', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ product_title }}}',
				'default'     => [ 
					[ 
						'product_title'     => esc_html__( 'Product 01', 'bdthemes-prime-slider' ),
						'marker_x_position' => [ 
							'size' => 50,
							'unit' => '%',
						],
						'marker_y_position' => [ 
							'size' => 75,
							'unit' => '%',
						],
					],
					[ 
						'product_title'     => esc_html__( 'Product 02', 'bdthemes-prime-slider' ),
						'marker_x_position' => [ 
							'size' => 20,
							'unit' => '%',
						],
						'marker_y_position' => [ 
							'size' => 30,
							'unit' => '%',
						],
					],
					[ 
						'product_title'     => esc_html__( 'Product 03', 'bdthemes-prime-slider' ),
						'marker_x_position' => [ 
							'size' => 65,
							'unit' => '%',
						],
						'marker_y_position' => [ 
							'size' => 20,
							'unit' => '%',
						],
					],
				],
			]
		);

		$this->end_controls_section();

		//item2 two
		$this->start_controls_section(
			'two_section_marker_image',
			[ 
				'label' => __( 'Slide Item Two', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'two_image',
			[ 
				'label'   => __( 'Choose Products Image', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [ 
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'two_tabs_markers' );

		$repeater->start_controls_tab(
			'two_tab_marker',
			[ 
				'label' => __( 'Hotspot', 'bdthemes-prime-slider' ),
			]
		);

		$repeater->add_control(
			'two_select_type',
			[ 
				'label'   => __( 'Select Type', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [ 
					'none'  => [ 
						'title' => __( 'None', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-editor-close',
					],
					'text'  => [ 
						'title' => __( 'Text', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-text-area',
					],
					'icon'  => [ 
						'title' => __( 'Icon', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-star',
					],
					'image' => [ 
						'title' => __( 'Image', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-image',
					],
				],
				'default' => 'icon',
				'toggle'  => false,
			]
		);

		$repeater->add_control(
			'two_text',
			[ 
				'type'      => Controls_Manager::TEXT,
				'label'     => __( 'Text', 'bdthemes-prime-slider' ),
				'default'   => 'Marker',
				'dynamic'   => [ 
					'active' => true,
				],
				'condition' => [ 
					'two_select_type' => 'text',
				],
			]
		);

		$repeater->add_control(
			'two_marker_select_icon',
			[ 
				'label'     => esc_html__( 'Icon', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::ICONS,
				'condition' => [ 
					'two_select_type' => 'icon',
				],
			]
		);

		$repeater->add_control(
			'two_image',
			[ 
				'type'       => Controls_Manager::MEDIA,
				'show_label' => false,
				'dynamic'    => [ 
					'active' => true,
				],
				'default'    => [ 
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition'  => [ 
					'two_select_type' => 'image',
				],
			]
		);

		$repeater->add_responsive_control(
			'two_marker_invisible_height',
			[ 
				'label'          => __( 'Height', 'bdthemes-prime-slider' ),
				'type'           => Controls_Manager::SLIDER,
				'default'        => [ 
					'size' => 20,
				],
				'tablet_default' => [ 
					'size' => 20,
				],
				'mobile_default' => [ 
					'size' => 20,
				],
				'size_units'     => [ 'px', '%' ],
				'range'          => [ 
					'px' => [ 
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'      => [ 
					'{{WRAPPER}} .bdt-woohotspot-wrap {{CURRENT_ITEM}}.bdt-woohotspot-item' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition'      => [ 
					'two_select_type' => 'none',
				],
			]
		);

		$repeater->add_responsive_control(
			'two_marker_invisible_width',
			[ 
				'label'          => __( 'Width', 'bdthemes-prime-slider' ),
				'type'           => Controls_Manager::SLIDER,
				'default'        => [ 
					'size' => 20,
				],
				'tablet_default' => [ 
					'size' => 20,
				],
				'mobile_default' => [ 
					'size' => 20,
				],
				'size_units'     => [ 'px', '%' ],
				'range'          => [ 
					'px' => [ 
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'      => [ 
					'{{WRAPPER}} .bdt-woohotspot-wrap {{CURRENT_ITEM}}.bdt-woohotspot-item' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'      => [ 
					'two_select_type' => 'none',
				],
			]
		);

		$repeater->add_responsive_control(
			'two_marker_x_position',
			[ 
				'label'     => esc_html__( 'X Postion', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'%' => [ 
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-woohotspot-wrap {{CURRENT_ITEM}}.bdt-woohotspot-item' => 'left: {{SIZE}}%;',
				],
			]
		);

		$repeater->add_responsive_control(
			'two_marker_y_position',
			[ 
				'label'     => esc_html__( 'Y Postion', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'%' => [ 
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-woohotspot-wrap {{CURRENT_ITEM}}.bdt-woohotspot-item' => 'top: {{SIZE}}%;',
				],
			]
		);

		$repeater->add_control(
			'two_marker_tooltip_placement',
			[ 
				'label'       => esc_html__( 'Placement', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'top',
				'options'     => [ 
					'top-start'    => esc_html__( 'Top Left', 'bdthemes-prime-slider' ),
					'top'          => esc_html__( 'Top', 'bdthemes-prime-slider' ),
					'top-end'      => esc_html__( 'Top Right', 'bdthemes-prime-slider' ),
					'bottom-start' => esc_html__( 'Bottom Left', 'bdthemes-prime-slider' ),
					'bottom'       => esc_html__( 'Bottom', 'bdthemes-prime-slider' ),
					'bottom-end'   => esc_html__( 'Bottom Right', 'bdthemes-prime-slider' ),
					'left'         => esc_html__( 'Left', 'bdthemes-prime-slider' ),
					'right'        => esc_html__( 'Right', 'bdthemes-prime-slider' ),
				],
				'render_type' => 'template',
			]
		);


		$repeater->add_control(
			'two_advanced_option_toggle',
			[ 
				'label'        => __( 'Hotspot Style', 'bdthemes-prime-slider' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'None', 'bdthemes-prime-slider' ),
				'label_on'     => __( 'Custom', 'bdthemes-prime-slider' ),
				'return_value' => 'yes',
			]
		);



		$repeater->start_popover();

		$repeater->add_control(
			'two_repeater_marker_color',
			[ 
				'label'       => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ 
					'{{WRAPPER}} .bdt-woohotspot-wrap {{CURRENT_ITEM}}.bdt-woohotspot' => 'color: {{VALUE}};',
				],
				'render_type' => 'ui',
				'condition'   => [ 
					'two_advanced_option_toggle' => 'yes',
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'        => 'two_repeater_marker_background',
				'selector'    => '{{WRAPPER}} .bdt-woohotspot-wrap {{CURRENT_ITEM}}.bdt-woohotspot',
				'render_type' => 'ui',
				'condition'   => [ 
					'two_advanced_option_toggle' => 'yes',
				],
			]
		);

		$repeater->end_popover();

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'two_tab_tooltip',
			[ 
				'label' => __( 'Product', 'bdthemes-prime-slider' ),
			]
		);

		$repeater->add_control(
			'two_product_title',
			[ 
				'label'       => esc_html__( 'Title', 'bdthemes-prime-slider' ),
				'default'     => esc_html__( 'Title Here', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'two_product_text',
			[ 
				'label'       => esc_html__( 'Text', 'bdthemes-prime-slider' ),
				'default'     => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::WYSIWYG,
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'two_product_price',
			[ 
				'label'       => esc_html__( 'Price', 'bdthemes-prime-slider' ),
				'default'     => esc_html__( '$124.00', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'two_product_link_text',
			[ 
				'label'       => esc_html__( 'Button', 'bdthemes-prime-slider' ),
				'default'     => esc_html__( 'Buy Now', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'two_product_link',
			[ 
				'label'       => esc_html__( 'Link', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'http://your-link.com',
				'default'     => [ 
					'url' => '#',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'two_markers',
			[ 
				'label'       => esc_html__( 'Hotspot Items', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ two_product_title }}}',
				'default'     => [ 
					[ 
						'two_product_title'     => esc_html__( 'Product 01', 'bdthemes-prime-slider' ),
						'two_marker_x_position' => [ 
							'size' => 20,
							'unit' => '%',
						],
						'two_marker_y_position' => [ 
							'size' => 20,
							'unit' => '%',
						],
					],
					[ 
						'two_product_title'     => esc_html__( 'Product 02', 'bdthemes-prime-slider' ),
						'two_marker_x_position' => [ 
							'size' => 65,
							'unit' => '%',
						],
						'two_marker_y_position' => [ 
							'size' => 29,
							'unit' => '%',
						],
					],
					[ 
						'two_product_title'     => esc_html__( 'Product 03', 'bdthemes-prime-slider' ),
						'two_marker_x_position' => [ 
							'size' => 40,
							'unit' => '%',
						],
						'two_marker_y_position' => [ 
							'size' => 80,
							'unit' => '%',
						],
					],
				],
			]
		);

		$this->end_controls_section();

		//item2 three
		$this->start_controls_section(
			'three_section_marker_image',
			[ 
				'label' => __( 'Slide Item Three', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'three_image',
			[ 
				'label'   => __( 'Choose Products Image', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [ 
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs( 'three_tabs_markers' );

		$repeater->start_controls_tab(
			'three_tab_marker',
			[ 
				'label' => __( 'Hotspot', 'bdthemes-prime-slider' ),
			]
		);

		$repeater->add_control(
			'three_select_type',
			[ 
				'label'   => __( 'Select Type', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [ 
					'none'  => [ 
						'title' => __( 'None', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-editor-close',
					],
					'text'  => [ 
						'title' => __( 'Text', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-text-area',
					],
					'icon'  => [ 
						'title' => __( 'Icon', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-star',
					],
					'image' => [ 
						'title' => __( 'Image', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-image',
					],
				],
				'default' => 'icon',
				'toggle'  => false,
			]
		);

		$repeater->add_control(
			'three_text',
			[ 
				'type'      => Controls_Manager::TEXT,
				'label'     => __( 'Text', 'bdthemes-prime-slider' ),
				'default'   => 'Marker',
				'dynamic'   => [ 
					'active' => true,
				],
				'condition' => [ 
					'three_select_type' => 'text',
				],
			]
		);

		$repeater->add_control(
			'three_marker_select_icon',
			[ 
				'label'     => esc_html__( 'Icon', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::ICONS,
				'condition' => [ 
					'three_select_type' => 'icon',
				],
			]
		);

		$repeater->add_control(
			'three_image',
			[ 
				'type'       => Controls_Manager::MEDIA,
				'show_label' => false,
				'dynamic'    => [ 
					'active' => true,
				],
				'default'    => [ 
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition'  => [ 
					'three_select_type' => 'image',
				],
			]
		);

		$repeater->add_responsive_control(
			'three_marker_invisible_height',
			[ 
				'label'          => __( 'Height', 'bdthemes-prime-slider' ),
				'type'           => Controls_Manager::SLIDER,
				'default'        => [ 
					'size' => 20,
				],
				'tablet_default' => [ 
					'size' => 20,
				],
				'mobile_default' => [ 
					'size' => 20,
				],
				'size_units'     => [ 'px', '%' ],
				'range'          => [ 
					'px' => [ 
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'      => [ 
					'{{WRAPPER}} .bdt-woohotspot-wrap {{CURRENT_ITEM}}.bdt-woohotspot-item' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition'      => [ 
					'three_select_type' => 'none',
				],
			]
		);

		$repeater->add_responsive_control(
			'three_marker_invisible_width',
			[ 
				'label'          => __( 'Width', 'bdthemes-prime-slider' ),
				'type'           => Controls_Manager::SLIDER,
				'default'        => [ 
					'size' => 20,
				],
				'tablet_default' => [ 
					'size' => 20,
				],
				'mobile_default' => [ 
					'size' => 20,
				],
				'size_units'     => [ 'px', '%' ],
				'range'          => [ 
					'px' => [ 
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'      => [ 
					'{{WRAPPER}} .bdt-woohotspot-wrap {{CURRENT_ITEM}}.bdt-woohotspot-item' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'      => [ 
					'three_select_type' => 'none',
				],
			]
		);

		$repeater->add_responsive_control(
			'three_marker_x_position',
			[ 
				'label'     => esc_html__( 'X Postion', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'%' => [ 
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-woohotspot-wrap {{CURRENT_ITEM}}.bdt-woohotspot-item' => 'left: {{SIZE}}%;',
				],
			]
		);

		$repeater->add_responsive_control(
			'three_marker_y_position',
			[ 
				'label'     => esc_html__( 'Y Postion', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'%' => [ 
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-woohotspot-wrap {{CURRENT_ITEM}}.bdt-woohotspot-item' => 'top: {{SIZE}}%;',
				],
			]
		);

		$repeater->add_control(
			'three_marker_tooltip_placement',
			[ 
				'label'       => esc_html__( 'Placement', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'top',
				'options'     => [ 
					'top-start'    => esc_html__( 'Top Left', 'bdthemes-prime-slider' ),
					'top'          => esc_html__( 'Top', 'bdthemes-prime-slider' ),
					'top-end'      => esc_html__( 'Top Right', 'bdthemes-prime-slider' ),
					'bottom-start' => esc_html__( 'Bottom Left', 'bdthemes-prime-slider' ),
					'bottom'       => esc_html__( 'Bottom', 'bdthemes-prime-slider' ),
					'bottom-end'   => esc_html__( 'Bottom Right', 'bdthemes-prime-slider' ),
					'left'         => esc_html__( 'Left', 'bdthemes-prime-slider' ),
					'right'        => esc_html__( 'Right', 'bdthemes-prime-slider' ),
				],
				'render_type' => 'template',
			]
		);

		$repeater->add_control(
			'three_advanced_option_toggle',
			[ 
				'label'        => __( 'Hotspot Style', 'bdthemes-prime-slider' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'None', 'bdthemes-prime-slider' ),
				'label_on'     => __( 'Custom', 'bdthemes-prime-slider' ),
				'return_value' => 'yes',
			]
		);



		$repeater->start_popover();

		$repeater->add_control(
			'three_repeater_marker_color',
			[ 
				'label'       => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ 
					'{{WRAPPER}} .bdt-woohotspot-wrap {{CURRENT_ITEM}}.bdt-woohotspot' => 'color: {{VALUE}};',
				],
				'render_type' => 'ui',
				'condition'   => [ 
					'three_advanced_option_toggle' => 'yes',
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'        => 'three_repeater_marker_background',
				'selector'    => '{{WRAPPER}} .bdt-woohotspot-wrap {{CURRENT_ITEM}}.bdt-woohotspot',
				'render_type' => 'ui',
				'condition'   => [ 
					'three_advanced_option_toggle' => 'yes',
				],
			]
		);

		$repeater->end_popover();

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'three_tab_tooltip',
			[ 
				'label' => __( 'Product', 'bdthemes-prime-slider' ),
			]
		);

		$repeater->add_control(
			'three_product_title',
			[ 
				'label'       => esc_html__( 'Title', 'bdthemes-prime-slider' ),
				'default'     => esc_html__( 'Title Here', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'three_product_text',
			[ 
				'label'       => esc_html__( 'Text', 'bdthemes-prime-slider' ),
				'default'     => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipisicing elit.', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::WYSIWYG,
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'three_product_price',
			[ 
				'label'       => esc_html__( 'Price', 'bdthemes-prime-slider' ),
				'default'     => esc_html__( '$124.00', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'three_product_link_text',
			[ 
				'label'       => esc_html__( 'Button', 'bdthemes-prime-slider' ),
				'default'     => esc_html__( 'Buy Now', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'three_product_link',
			[ 
				'label'       => esc_html__( 'Link', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [ 'active' => true ],
				'placeholder' => 'http://your-link.com',
				'default'     => [ 
					'url' => '#',
				],
			]
		);

		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'three_markers',
			[ 
				'label'       => esc_html__( 'Hotspot Items', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ three_product_title }}}',
				'default'     => [ 
					[ 
						'three_product_title'     => esc_html__( 'Product 01', 'bdthemes-prime-slider' ),
						'three_marker_x_position' => [ 
							'size' => 50,
							'unit' => '%',
						],
						'three_marker_y_position' => [ 
							'size' => 50,
							'unit' => '%',
						],
					],
					[ 
						'three_product_title'     => esc_html__( 'Product 02', 'bdthemes-prime-slider' ),
						'three_marker_x_position' => [ 
							'size' => 30,
							'unit' => '%',
						],
						'three_marker_y_position' => [ 
							'size' => 30,
							'unit' => '%',
						],
					],
					[ 
						'three_product_title'     => esc_html__( 'Product 03', 'bdthemes-prime-slider' ),
						'three_marker_x_position' => [ 
							'size' => 80,
							'unit' => '%',
						],
						'three_marker_y_position' => [ 
							'size' => 20,
							'unit' => '%',
						],
					],
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_tooltip_settings',
			[ 
				'label' => __( 'Tooltip Settings', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'marker_tooltip_animation',
			[ 
				'label'       => esc_html__( 'Animation', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'shift-toward',
				'options'     => [ 
					'shift-away'   => esc_html__( 'Shift-Away', 'bdthemes-prime-slider' ),
					'shift-toward' => esc_html__( 'Shift-Toward', 'bdthemes-prime-slider' ),
					'fade'         => esc_html__( 'Fade', 'bdthemes-prime-slider' ),
					'scale'        => esc_html__( 'Scale', 'bdthemes-prime-slider' ),
					'perspective'  => esc_html__( 'Perspective', 'bdthemes-prime-slider' ),
				],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'marker_tooltip_x_offset',
			[ 
				'label'   => esc_html__( 'Offset', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [ 
					'size' => 0,
				],
			]
		);

		$this->add_control(
			'marker_tooltip_y_offset',
			[ 
				'label'   => esc_html__( 'Distance', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [ 
					'size' => 0,
				],
			]
		);

		$this->add_control(
			'marker_tooltip_arrow',
			[ 
				'label' => esc_html__( 'Arrow', 'bdthemes-prime-slider' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'marker_tooltip_trigger',
			[ 
				'label'       => __( 'Trigger on Click', 'bdthemes-prime-slider' ),
				'description' => __( 'Don\'t set yes when you set lightbox image with marker.', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_additional_settings',
			[ 
				'label' => esc_html__( 'Additional Settings', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[ 
				'name'    => 'thumbnail',
				'label'   => __( 'Image Size', 'bdthemes-prime-slider' ),
				'default' => 'full',
			]
		);

		$this->add_control(
			'show_title',
			[ 
				'label'     => __( 'Show Product Title', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_tag',
			[ 
				'label'     => __( 'Title HTML Tag', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'h3',
				'options'   => prime_slider_title_tags(),
				'condition' => [ 
					'show_title' => 'yes',
				]
			]
		);

		$this->add_control(
			'show_price',
			[ 
				'label'     => __( 'Show Product Price', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_text',
			[ 
				'label'   => __( 'Show Product Text', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_button',
			[ 
				'label'   => esc_html__( 'Show Product Button', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		/**
		 * Show Navigation Controls
		 */
		$this->register_show_navigation_controls();

		/**
		 * Show Pagination Controls
		 */
		$this->register_show_pagination_controls();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_carousel_settings',
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

		$this->add_control(
			'rewind',
			[ 
				'label' => __( 'Rewind (Loop Alternative)', 'bdthemes-prime-slider' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'mousewheel',
			[ 
				'label'   => __( 'Mousewheel', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		/**
		 * Speed & Observer Controls
		 */
		$this->register_speed_observer_controls();

		$this->add_control(
			'transition',
			[ 
				'label'   => esc_html__( 'Swiper Effect', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'type'    => Controls_Manager::SELECT,
				'default' => 'slide',
				'options' => [ 
					'slide'     => esc_html__( 'Slide', 'bdthemes-prime-slider' ),
					'fade'      => esc_html__( 'Fade', 'bdthemes-prime-slider' ),
					'cube'      => esc_html__( 'Cube', 'bdthemes-prime-slider' ),
					'coverflow' => esc_html__( 'Coverflow', 'bdthemes-prime-slider' ),
					'flip'      => esc_html__( 'Flip', 'bdthemes-prime-slider' ),
					'tinder'    => esc_html__( 'Tinder', 'bdthemes-prime-slider' ),
					'creative'  => esc_html__( 'Creative', 'bdthemes-prime-slider' ),
				],
			]
		);

		//creative effect control
		$this->add_control(
			'creative_effect',
			[ 
				'label'     => esc_html__( 'Creative Effect', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'creative-1',
				'options'   => [ 
					'creative-1' => esc_html__( 'Creative 1', 'bdthemes-prime-slider' ),
					'creative-2' => esc_html__( 'Creative 2', 'bdthemes-prime-slider' ),
					'creative-3' => esc_html__( 'Creative 3', 'bdthemes-prime-slider' ),
					'creative-4' => esc_html__( 'Creative 4', 'bdthemes-prime-slider' ),
					'creative-5' => esc_html__( 'Creative 5', 'bdthemes-prime-slider' ),
				],
				'condition' => [ 
					'transition' => 'creative',
				],
			]
		);

		$this->end_controls_section();

		//style
		$this->start_controls_section(
			'section_style_image',
			[ 
				'label' => __( 'Image', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'space',
			[ 
				'label'          => __( 'Size (%)', 'bdthemes-prime-slider' ),
				'type'           => Controls_Manager::SLIDER,
				'default'        => [ 
					'size' => 100,
					'unit' => '%',
				],
				'tablet_default' => [ 
					'unit' => '%',
				],
				'mobile_default' => [ 
					'unit' => '%',
				],
				'size_units'     => [ '%' ],
				'range'          => [ 
					'%' => [ 
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors'      => [ 
					'{{WRAPPER}} .bdt-woohotspot-wrap' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'opacity',
			[ 
				'label'     => __( 'Opacity', 'bdthemes-prime-slider' ),
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
					'{{WRAPPER}} .bdt-woohotspot-wrap > img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'      => 'image_border',
				'label'     => __( 'Image Border', 'bdthemes-prime-slider' ),
				'selector'  => '{{WRAPPER}} .bdt-woohotspot-wrap > img',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'image_radius',
			[ 
				'label'      => __( 'Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-woohotspot-wrap > img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'image_shadow',
				'exclude'  => [ 
					'shadow_position',
				],
				'selector' => '{{WRAPPER}} .bdt-woohotspot-wrap > img',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_marker',
			[ 
				'label' => __( 'Hotspots', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_marker_style' );

		$this->start_controls_tab(
			'tab_marker_normal',
			[ 
				'label' => __( 'Normal', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'marker_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-woohotspot-wrap .bdt-woohotspot'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-woohotspot-wrap .bdt-woohotspot svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'marker_background_color',
				'selector' => '{{WRAPPER}} .bdt-woohotspot-wrap .bdt-woohotspot',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'      => 'marker_border',
				'label'     => __( 'Image Border', 'bdthemes-prime-slider' ),
				'selector'  => '{{WRAPPER}} .bdt-woohotspot-wrap .bdt-woohotspot',
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'marker_radius',
			[ 
				'label'      => __( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-woohotspot-wrap .bdt-woohotspot'                                                                        => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .bdt-woohotspot-animated .bdt-woohotspot:before, {{WRAPPER}} .bdt-woohotspot-animated .bdt-woohotspot:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'marker_padding',
			[ 
				'label'      => __( 'Padding', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-woohotspot-wrap .bdt-woohotspot' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'marker_size',
			[ 
				'label'     => __( 'Size', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-woohotspot-wrap .bdt-woohotspot > img' => 'width: calc({{SIZE}}{{UNIT}} - 12px); height: auto;',
					'{{WRAPPER}} .bdt-woohotspot-wrap .bdt-woohotspot > i'   => 'font-size: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-woohotspot-wrap .bdt-woohotspot'       => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'marker_opacity',
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
					'{{WRAPPER}} .bdt-woohotspot-wrap .bdt-woohotspot' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'marker_shadow',
				'exclude'  => [ 
					'shadow_position',
				],
				'selector' => '{{WRAPPER}} .bdt-woohotspot-wrap .bdt-woohotspot',
			]
		);

		$this->add_control(
			'marker_pulse_color',
			[ 
				'label'     => esc_html__( 'Pulse Animated Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-woohotspot-animated .bdt-woohotspot:before, {{WRAPPER}} .bdt-woohotspot-animated .bdt-woohotspot:after' => 'border-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_marker_hover',
			[ 
				'label' => __( 'Hover', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'marker_hover_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-woohotspot-wrap .bdt-woohotspot:hover'     => 'color: {{VALUE}};',
					'{{WRAPPER}} .bdt-woohotspot-wrap .bdt-woohotspot:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'marker_hover_background_color',
				'selector' => '{{WRAPPER}} .bdt-woohotspot-wrap .bdt-woohotspot:hover',
			]
		);

		$this->add_control(
			'marker_hover_border_color',
			[ 
				'label'     => esc_html__( 'Border Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-woohotspot-wrap .bdt-woohotspot:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [ 
					'marker_border_border!' => '',
				],
			]
		);

		$this->end_controls_tab();


		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_content',
			[ 
				'label' => esc_html__( 'Product Item', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'content_background',
				'selector' => '.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .bdt-woohotspot-content',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'        => 'content_border',
				'label'       => esc_html__( 'Border', 'bdthemes-prime-slider' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .bdt-woohotspot-content',
				'separator'   => 'before',
			]
		);

		$this->add_responsive_control(
			'content_border_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .bdt-woohotspot-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[ 
				'label'      => esc_html__( 'Padding', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .bdt-woohotspot-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'content_box_shadow',
				'selector' => '.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .bdt-woohotspot-content',
			]
		);

		$this->add_responsive_control(
			'content_alignment',
			[ 
				'label'     => __( 'Alignment', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'left',
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
						'title' => __( 'Justify', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'selectors' => [ 
					'.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .bdt-woohotspot-content' => 'text-align: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'marker_tooltip_arrow_color',
			[ 
				'label'     => esc_html__( 'Arrow Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .tippy-popper[x-placement^=left] .tippy-arrow'         => 'border-left-color: {{VALUE}}',
					'{{WRAPPER}} .tippy-popper[x-placement^=right] .tippy-arrow'        => 'border-right-color: {{VALUE}}',
					'{{WRAPPER}} .tippy-popper[x-placement^=top] .tippy-arrow'          => 'border-top-color: {{VALUE}}',
					'{{WRAPPER}} .tippy-popper[x-placement^=bottom] .tippy-arrow'       => 'border-bottom-color: {{VALUE}}',

					'.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .tippy-arrow' => 'color: {{VALUE}}',
				],
				'condition' => [ 
					'marker_tooltip_arrow' => 'yes',
				]
			]
		);

		$this->add_responsive_control(
			'marker_tooltip_width',
			[ 
				'label'       => esc_html__( 'Width', 'bdthemes-element-pack' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 
					'px', 'em',
				],
				'range'       => [ 
					'px' => [ 
						'min' => 50,
						'max' => 500,
					],
				],
				'selectors'   => [ 
					'.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"]' => 'width: {{SIZE}}{{UNIT}} !important; max-width: {{SIZE}}{{UNIT}} !important;',
				],
				'render_type' => 'template',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[ 
				'label'     => __( 'Product Title', 'bdthemes-prime-slider' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_title' => 'yes',
				]
			]
		);

		$this->add_control(
			'title_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .bdt-woohotspot-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[ 
				'label'      => esc_html__( 'Margin', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .bdt-woohotspot-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'title_typography',
				'selector' => '.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .bdt-woohotspot-title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[ 
				'name'     => 'title_shadow',
				'label'    => __( 'Text Shadow', 'bdthemes-prime-slider' ),
				'selector' => '.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .bdt-woohotspot-title',
			]
		);

		$this->end_controls_section();



		$this->start_controls_section(
			'section_style_text',
			[ 
				'label'     => __( 'Product Text', 'bdthemes-prime-slider' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_text' => 'yes',
				]
			]
		);

		$this->add_control(
			'text_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .bdt-woohotspot-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'text_margin',
			[ 
				'label'      => esc_html__( 'Margin', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .bdt-woohotspot-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'text_typography',
				'selector' => '.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .bdt-woohotspot-text',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_price',
			[ 
				'label'     => __( 'Product Price', 'bdthemes-prime-slider' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_price' => 'yes',
				]
			]
		);

		$this->add_control(
			'price_color',
			[ 
				'label'     => __( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .bdt-woohotspot-price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'price_margin',
			[ 
				'label'      => esc_html__( 'Margin', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .bdt-woohotspot-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'price_typography',
				'selector' => '.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .bdt-woohotspot-price',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_readmore',
			[ 
				'label'     => esc_html__( 'Product Button', 'bdthemes-prime-slider' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_button' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_readmore_style' );

		$this->start_controls_tab(
			'tab_readmore_normal',
			[ 
				'label' => esc_html__( 'Normal', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'readmore_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .bdt-woohotspot-link'     => 'color: {{VALUE}};',
					'.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .bdt-woohotspot-link svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'readmore_background',
				'selector' => '.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .bdt-woohotspot-link',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'        => 'readmore_border',
				'label'       => esc_html__( 'Border', 'bdthemes-prime-slider' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .bdt-woohotspot-link',
				'separator'   => 'before',
			]
		);

		$this->add_responsive_control(
			'readmore_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .bdt-woohotspot-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'readmore_padding',
			[ 
				'label'      => esc_html__( 'Padding', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .bdt-woohotspot-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'readmore_margin',
			[ 
				'label'      => esc_html__( 'Margin', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .bdt-woohotspot-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'readmore_typography',
				'selector' => '.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .bdt-woohotspot-link',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'readmore_box_shadow',
				'selector' => '.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .bdt-woohotspot-link',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_readmore_hover',
			[ 
				'label' => esc_html__( 'Hover', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'readmore_hover_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .bdt-woohotspot-link:hover'     => 'color: {{VALUE}};',
					'.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .bdt-woohotspot-link:hover svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'readmore_hover_background',
				'selector' => '.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .bdt-woohotspot-link:hover',
			]
		);

		$this->add_control(
			'readmore_hover_border_color',
			[ 
				'label'     => esc_html__( 'Border Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 
					'readmore_border_border!' => '',
				],
				'selectors' => [ 
					'.tippy-box[data-theme="bdt-tippy-woohotspot-{{ID}}"] .bdt-woohotspot-link:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'readmore_hover_animation',
			[ 
				'label' => esc_html__( 'Animation', 'bdthemes-prime-slider' ),
				'type'  => Controls_Manager::HOVER_ANIMATION,
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

		$this->start_controls_tabs( 'tabs_nav_pag_style' );

		$this->start_controls_tab(
			'tab_arrows_normal',
			[ 
				'label'     => __( 'Arrows', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_responsive_control(
			'arrow_direction',
			[ 
				'label'                => esc_html__( 'Alignment', 'bdthemes-prime-slider' ),
				'type'                 => Controls_Manager::CHOOSE,
				'default'              => 'right',
				'options'              => [ 
					'left'  => [ 
						'title' => esc_html__( 'Left', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [ 
						'title' => esc_html__( 'Right', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors_dictionary' => [ 
					'left'  => 'left: 0;',
					'right' => 'right: 0;',
				],
				'selectors'            => [ 
					'{{WRAPPER}} .bdt-navigation-arrows' => '{{VALUE}};',
				],
				'toggle'               => false,
				'condition'            => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'nav_arrows_icon',
			[ 
				'label'     => esc_html__( 'Arrows Icon', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '8',
				'options'   => [ 
					'0'        => esc_html__( 'Default', 'bdthemes-prime-slider' ),
					'1'        => esc_html__( 'Style 1', 'bdthemes-prime-slider' ),
					'2'        => esc_html__( 'Style 2', 'bdthemes-prime-slider' ),
					'3'        => esc_html__( 'Style 3', 'bdthemes-prime-slider' ),
					'4'        => esc_html__( 'Style 4', 'bdthemes-prime-slider' ),
					'5'        => esc_html__( 'Style 5', 'bdthemes-prime-slider' ),
					'6'        => esc_html__( 'Style 6', 'bdthemes-prime-slider' ),
					'7'        => esc_html__( 'Style 7', 'bdthemes-prime-slider' ),
					'8'        => esc_html__( 'Style 8', 'bdthemes-prime-slider' ),
					'9'        => esc_html__( 'Style 9', 'bdthemes-prime-slider' ),
					'10'       => esc_html__( 'Style 10', 'bdthemes-prime-slider' ),
					'11'       => esc_html__( 'Style 11', 'bdthemes-prime-slider' ),
					'12'       => esc_html__( 'Style 12', 'bdthemes-prime-slider' ),
					'13'       => esc_html__( 'Style 13', 'bdthemes-prime-slider' ),
					'14'       => esc_html__( 'Style 14', 'bdthemes-prime-slider' ),
					'15'       => esc_html__( 'Style 15', 'bdthemes-prime-slider' ),
					'16'       => esc_html__( 'Style 16', 'bdthemes-prime-slider' ),
					'17'       => esc_html__( 'Style 17', 'bdthemes-prime-slider' ),
					'18'       => esc_html__( 'Style 18', 'bdthemes-prime-slider' ),
					'circle-1' => esc_html__( 'Style 19', 'bdthemes-prime-slider' ),
					'circle-2' => esc_html__( 'Style 20', 'bdthemes-prime-slider' ),
					'circle-3' => esc_html__( 'Style 21', 'bdthemes-prime-slider' ),
					'circle-4' => esc_html__( 'Style 22', 'bdthemes-prime-slider' ),
					'square-1' => esc_html__( 'Style 23', 'bdthemes-prime-slider' ),
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
					'{{WRAPPER}} .bdt-navigation-arrows .bdt-woohotspot-slidenav' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_responsive_control(
			'arrows_spacing',
			[ 
				'label'     => __( 'Space Between', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-woohotspot .bdt-navigation-arrows' => 'gap: {{SIZE}}{{UNIT}};',
				],
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
					'{{WRAPPER}} .bdt-navigation-arrows .bdt-woohotspot-slidenav' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'      => 'arrows_background',
				'selector'  => '{{WRAPPER}} .bdt-navigation-arrows .bdt-woohotspot-slidenav',
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'      => 'arrows_border',
				'selector'  => '{{WRAPPER}} .bdt-navigation-arrows .bdt-woohotspot-slidenav',
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
					'{{WRAPPER}} .bdt-navigation-arrows .bdt-woohotspot-slidenav' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .bdt-navigation-arrows .bdt-woohotspot-slidenav' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .bdt-navigation-arrows' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector'  => '{{WRAPPER}} .bdt-navigation-arrows .bdt-woohotspot-slidenav',
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_heading',
			[ 
				'label'     => esc_html__( 'HOVER', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
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
					'{{WRAPPER}} .bdt-navigation-arrows .bdt-woohotspot-slidenav:hover' => 'color: {{VALUE}};',
				],
				'condition' => [ 
					'show_navigation_arrows' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_background',
			[ 
				'label'     => esc_html__( 'Background', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-woohotspot-slidenav::before'                      => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .bdt-navigation-arrows .bdt-woohotspot-slidenav:hover' => 'background-color: {{VALUE}};',
				],
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
				'condition' => [ 
					'arrows_border_border!'  => '',
					'show_navigation_arrows' => [ 'yes' ],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-navigation-arrows .bdt-woohotspot-slidenav:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dots_normal',
			[ 
				'label'     => __( 'Pagination', 'bdthemes-prime-slider' ),
				'condition' => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
			]
		);


		$this->add_responsive_control(
			'pagination_direction',
			[ 
				'label'                => esc_html__( 'Alignment', 'bdthemes-prime-slider' ),
				'type'                 => Controls_Manager::CHOOSE,
				'default'              => 'left',
				'options'              => [ 
					'left'  => [ 
						'title' => esc_html__( 'Left', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [ 
						'title' => esc_html__( 'Right', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors_dictionary' => [ 
					'left'  => 'left: 0; right: auto;',
					'right' => 'right: 0; left: auto;',
				],
				'selectors'            => [ 
					'{{WRAPPER}} .bdt-prime-slider-woohotspot .bdt-navigation-dots .swiper-pagination' => '{{VALUE}};',
				],
				'toggle'               => false,
				'condition'            => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
			]
		);


		$this->add_control(
			'pagination_background',
			[ 
				'label'     => __( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-navigation-dots .swiper-pagination .swiper-pagination-bullet' => 'background-color: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'pagination_hover_background',
			[ 
				'label'     => __( 'Hover Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-navigation-dots .swiper-pagination .swiper-pagination-bullet:hover' => 'background-color: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'pagination_active_background',
			[ 
				'label'     => __( 'Active Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .swiper-pagination-bullet::before' => 'background-color: {{VALUE}}',
				],
				'condition' => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
			]
		);

		$this->add_responsive_control(
			'pagination_width',
			[ 
				'label'     => __( 'Width', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 0,
						'max' => 300,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-navigation-dots .swiper-pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
			]
		);

		$this->add_responsive_control(
			'pagination_height',
			[ 
				'label'     => __( 'Height', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 0,
						'max' => 300,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-navigation-dots .swiper-pagination .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
			]
		);


		$this->add_responsive_control(
			'pagination_border_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-navigation-dots .swiper-pagination .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
			]
		);

		$this->add_responsive_control(
			'pagination_space_between',
			[ 
				'label'     => __( 'Space Between', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-navigation-dots .swiper-pagination' => 'gap: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
			]
		);

		$this->add_responsive_control(
			'pagination_horizontal_spacing',
			[ 
				'label'     => __( 'Horizontal Spacing', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 0,
						'max' => 300,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prime-slider-woohotspot .bdt-navigation-dots .swiper-pagination' => 'margin: 0 {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'show_navigation_dots' => [ 'yes' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	public function render_title( $marker ) {
		$settings = $this->get_settings_for_display();

		if ( ! $settings['show_title'] ) {
			return;
		}

		$this->add_render_attribute( 'title-wrap', 'class', 'bdt-woohotspot-title', true );

		?>
		<?php if ( $marker['product_title'] ) : ?>
			<<?php echo esc_attr( Utils::get_valid_html_tag( $settings['title_tag'] ) ); ?>
				<?php echo $this->get_render_attribute_string( 'title-wrap' ); ?>>
				<?php echo wp_kses( $marker['product_title'], prime_slider_allow_tags( 'product_title' ) ); ?>
			</<?php echo esc_attr( Utils::get_valid_html_tag( $settings['title_tag'] ) ); ?>>
		<?php endif;

	?>
	<?php
	}

	public function render_two_title( $marker ) {
		$settings = $this->get_settings_for_display();

		if ( ! $settings['show_title'] ) {
			return;
		}

		$this->add_render_attribute( 'title-wrap', 'class', 'bdt-woohotspot-title', true );

		?>
		<?php if ( $marker['two_product_title'] ) : ?>
			<<?php echo esc_attr( Utils::get_valid_html_tag( $settings['title_tag'] ) ); ?>
				<?php echo $this->get_render_attribute_string( 'title-wrap' ); ?>>
				<?php echo wp_kses( $marker['two_product_title'], prime_slider_allow_tags( 'two_product_title' ) ); ?>
			</<?php echo esc_attr( Utils::get_valid_html_tag( $settings['title_tag'] ) ); ?>>
		<?php endif; ?>
	<?php
	}

	public function render_three_title( $marker ) {
		$settings = $this->get_settings_for_display();

		if ( ! $settings['show_title'] ) {
			return;
		}

		$this->add_render_attribute( 'title-wrap', 'class', 'bdt-woohotspot-title', true );

		?>
		<?php if ( $marker['three_product_title'] ) : ?>
			<<?php echo esc_attr( Utils::get_valid_html_tag( $settings['title_tag'] ) ); ?>
				<?php echo $this->get_render_attribute_string( 'title-wrap' ); ?>>
				<?php echo wp_kses( $marker['three_product_title'], prime_slider_allow_tags( 'three_product_title' ) ); ?>
			</<?php echo esc_attr( Utils::get_valid_html_tag( $settings['title_tag'] ) ); ?>>
		<?php endif; ?>
	<?php
	}

	public function render_price( $marker ) {
		$settings = $this->get_settings_for_display();

		if ( ! $settings['show_price'] ) {
			return;
		}

		?>
		<?php if ( $marker['product_price'] ) : ?>
			<div class="bdt-woohotspot-price">
				<?php echo esc_html( $marker['product_price'] ); ?>
			</div>
		<?php endif; ?>
	<?php
	}

	public function render_two_price( $marker ) {
		$settings = $this->get_settings_for_display();

		if ( ! $settings['show_price'] ) {
			return;
		}

		?>
		<?php if ( $marker['two_product_price'] ) : ?>
			<div class="bdt-woohotspot-price">
				<?php echo esc_html( $marker['two_product_price'] ); ?>
			</div>
		<?php endif; ?>
	<?php
	}

	public function render_three_price( $marker ) {
		$settings = $this->get_settings_for_display();

		if ( ! $settings['show_price'] ) {
			return;
		}

		?>
		<?php if ( $marker['three_product_price'] ) : ?>
			<div class="bdt-woohotspot-price">
				<?php echo esc_html( $marker['three_product_price'] ); ?>
			</div>
		<?php endif; ?>
	<?php
	}

	public function render_text( $marker ) {
		$settings = $this->get_settings_for_display();

		if ( ! $settings['show_text'] ) {
			return;
		}

		?>
		<?php if ( $marker['product_text'] ) : ?>
			<div class="bdt-woohotspot-text">
				<?php echo wp_kses_post( $marker['product_text'] ); ?>
			</div>
		<?php endif; ?>
	<?php
	}

	public function render_two_text( $marker ) {
		$settings = $this->get_settings_for_display();

		if ( ! $settings['show_text'] ) {
			return;
		}

		?>
		<?php if ( $marker['two_product_text'] ) : ?>
			<div class="bdt-woohotspot-text">
				<?php echo wp_kses_post( $marker['two_product_text'] ); ?>
			</div>
		<?php endif; ?>
	<?php
	}

	public function render_three_text( $marker ) {
		$settings = $this->get_settings_for_display();

		if ( ! $settings['show_text'] ) {
			return;
		}

		?>
		<?php if ( $marker['three_product_text'] ) : ?>
			<div class="bdt-woohotspot-text">
				<?php echo wp_kses_post( $marker['three_product_text'] ); ?>
			</div>
		<?php endif; ?>
	<?php
	}

	public function render_readmore( $marker ) {
		$settings = $this->get_settings_for_display();

		if ( ! $settings['show_button'] ) {
			return;
		}

		$this->add_render_attribute(
			[ 
				'product-link' => [ 
					'class'  => [ 
						'bdt-woohotspot-link elementor-button elementor-size-xs',
						$settings['readmore_hover_animation'] ? 'elementor-animation-' . $settings['readmore_hover_animation'] : '',
					],
					'href'   => isset( $marker['product_link']['url'] ) ? esc_url( $marker['product_link']['url'] ) : '#',
					'target' => $marker['product_link']['is_external'] ? '_blank' : '_self'
				]
			],
			'',
			'',
			true
		);

		?>
		<?php if ( ( ! empty( $marker['product_link']['url'] ) ) && ( $marker['product_link_text'] ) && ( $settings['show_button'] ) ) : ?>
			<div class="bdt-woohotspot-link-wrap">
				<a <?php echo $this->get_render_attribute_string( 'product-link' ); ?>>
					<?php echo esc_html( $marker['product_link_text'] ); ?>
				</a>
			</div>
		<?php endif; ?>
	<?php
	}

	public function render_two_readmore( $marker ) {
		$settings = $this->get_settings_for_display();

		if ( ! $settings['show_button'] ) {
			return;
		}

		$this->add_render_attribute(
			[ 
				'product-link' => [ 
					'class'  => [ 
						'bdt-woohotspot-link elementor-button elementor-size-xs',
						$settings['readmore_hover_animation'] ? 'elementor-animation-' . $settings['readmore_hover_animation'] : '',
					],
					'href'   => isset( $marker['two_product_link']['url'] ) ? esc_url( $marker['two_product_link']['url'] ) : '#',
					'target' => $marker['two_product_link']['is_external'] ? '_blank' : '_self'
				]
			],
			'',
			'',
			true
		);

		?>
		<?php if ( ( ! empty( $marker['two_product_link']['url'] ) ) && ( $marker['two_product_link_text'] ) && ( $settings['show_button'] ) ) : ?>
			<div class="bdt-woohotspot-link-wrap">
				<a <?php echo $this->get_render_attribute_string( 'product-link' ); ?>>
					<?php echo esc_html( $marker['two_product_link_text'] ); ?>
				</a>
			</div>
		<?php endif; ?>
	<?php
	}

	public function render_three_readmore( $marker ) {
		$settings = $this->get_settings_for_display();

		if ( ! $settings['show_button'] ) {
			return;
		}

		$this->add_render_attribute(
			[ 
				'product-link' => [ 
					'class'  => [ 
						'bdt-woohotspot-link elementor-button elementor-size-xs',
						$settings['readmore_hover_animation'] ? 'elementor-animation-' . $settings['readmore_hover_animation'] : '',
					],
					'href'   => isset( $marker['three_product_link']['url'] ) ? esc_url( $marker['three_product_link']['url'] ) : '#',
					'target' => $marker['three_product_link']['is_external'] ? '_blank' : '_self'
				]
			],
			'',
			'',
			true
		);

		?>
		<?php if ( ( ! empty( $marker['three_product_link']['url'] ) ) && ( $marker['three_product_link_text'] ) && ( $settings['show_button'] ) ) : ?>
			<div class="bdt-woohotspot-link-wrap">
				<a <?php echo $this->get_render_attribute_string( 'product-link' ); ?>>
					<?php echo esc_html( $marker['three_product_link_text'] ); ?>
				</a>
			</div>
		<?php endif; ?>
	<?php
	}

	public function render_product_content( $marker ) {
		$settings = $this->get_settings_for_display();

		ob_start();
		$html = '';
		?>
		<div class="bdt-card bdt-card-body bdt-card-default bdt-woohotspot-content">
			<?php $this->render_title( $marker ); ?>
			<?php $this->render_text( $marker ); ?>
			<?php if ( $marker['product_price'] && $marker['product_link_text'] ) : ?>
				<div class="bdt-woohotspot-price-btn-wrap bdt-flex bdt-flex-middle bdt-flex-between">
					<?php $this->render_price( $marker ); ?>
					<?php $this->render_readmore( $marker ); ?>
				</div>
			<?php endif; ?>
		</div>

		<?php
		$html .= ob_get_clean();
		return $html;
	}

	public function render_two_product_content( $marker ) {
		$settings = $this->get_settings_for_display();

		ob_start();
		$html = '';
		?>
		<div class="bdt-card bdt-card-body bdt-card-default bdt-woohotspot-content">
			<?php $this->render_two_title( $marker ); ?>
			<?php $this->render_two_text( $marker ); ?>
			<?php if ( $marker['two_product_price'] && $marker['two_product_link_text'] ) : ?>
				<div class="bdt-woohotspot-price-btn-wrap bdt-flex bdt-flex-middle bdt-flex-between">
					<?php $this->render_two_price( $marker ); ?>
					<?php $this->render_two_readmore( $marker ); ?>
				</div>
			<?php endif; ?>
		</div>

		<?php
		$html .= ob_get_clean();
		return $html;
	}

	public function render_three_product_content( $marker ) {
		$settings = $this->get_settings_for_display();

		ob_start();
		$html = '';
		?>
		<div class="bdt-card bdt-card-body bdt-card-default bdt-woohotspot-content">
			<?php $this->render_three_title( $marker ); ?>
			<?php $this->render_three_text( $marker ); ?>
			<?php if ( $marker['three_product_price'] && $marker['three_product_link_text'] ) : ?>
				<div class="bdt-woohotspot-price-btn-wrap bdt-flex bdt-flex-middle bdt-flex-between">
					<?php $this->render_three_price( $marker ); ?>
					<?php $this->render_three_readmore( $marker ); ?>
				</div>
			<?php endif; ?>
		</div>

		<?php
		$html .= ob_get_clean();
		return $html;
	}

	public function marker_render_attributes( $marker, $marker_title ) {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'marker', 'class', 'bdt-woohotspot-item bdt-position-absolute bdt-woohotspot bdt-icon elementor-repeater-item-' . esc_attr( $marker['_id'] ), true );

		$this->add_render_attribute( 'marker', 'target', [ '_self' ], true );
		$this->add_render_attribute( 'marker', 'href', 'javascript:void(0);', true );

		$this->add_render_attribute( 'marker', 'data-tippy-content', $marker_title, true );

		$this->add_render_attribute( 'marker', 'class', 'bdt-tippy-tooltip' );
		$this->add_render_attribute( 'marker', 'data-tippy', '', true );

		if ( $settings['marker_tooltip_animation'] ) {
			$this->add_render_attribute( 'marker', 'data-tippy-animation', $settings['marker_tooltip_animation'], true );
		}

		if ( $settings['marker_tooltip_x_offset']['size'] or $settings['marker_tooltip_y_offset']['size'] ) {
			$this->add_render_attribute( 'marker', 'data-tippy-offset', '[' . $settings['marker_tooltip_x_offset']['size'] . ',' . $settings['marker_tooltip_y_offset']['size'] . ']', true );
		}

		if ( 'yes' == $settings['marker_tooltip_arrow'] ) {
			$this->add_render_attribute( 'marker', 'data-tippy-arrow', 'true', true );
		} else {
			$this->add_render_attribute( 'marker', 'data-tippy-arrow', 'false', true );
		}

		if ( 'yes' == $settings['marker_tooltip_trigger'] ) {
			$this->add_render_attribute( 'marker', 'data-tippy-trigger', 'click', true );
		}
	}

	protected function render_item_content() {
		$settings = $this->get_settings_for_display();
		$id       = 'bdt-drop-' . $this->get_id();

		if ( empty( $settings['image']['url'] ) ) {
			return;
		}

		$this->add_render_attribute( 'wrapper', 'class', 'bdt-woohotspot-wrap bdt-flex bdt-woohotspot-animated bdt-dark' );
		$this->add_render_attribute( 'wrapper', 'id', esc_attr( $id ) );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php

			// $gl = $settings['transition'] == 'gl' ? ' swiper-gl-image' : '';
			// $shutters = $settings['transition'] == 'shutters' ? ' swiper-shutters-image' : '';
			// $slicer = $settings['transition'] == 'slicer' ? ' swiper-slicer-image' : '';
	
			$placeholder_image_src = Utils::get_placeholder_image_src();
			$image_src             = wp_get_attachment_image_src( $settings['image']['id'], 'full' );
			if ( ! $image_src ) {
				printf( '<img src="%1$s" alt="%2$s">', esc_url( $placeholder_image_src ), esc_html( get_the_title() ) );
			} else {
				print( wp_get_attachment_image(
					$settings['image']['id'],
					$settings['thumbnail_size'],
					false,
					[ 

						'alt' => esc_html( get_the_title() )
					]
				) );
			}

			foreach ( $settings['markers'] as $marker ) {

				$marker_title = $this->render_product_content( $marker );
				$this->marker_render_attributes( $marker, $marker_title );
				if ( 'none' == $marker['select_type'] ) {
					$this->add_render_attribute( 'marker', 'class', 'bdt-woohotspot-invisible' );
				}
				if ( $marker['marker_tooltip_placement'] ) {
					$this->add_render_attribute( 'marker', 'data-tippy-placement', $marker['marker_tooltip_placement'], true );
				}


				?>
				<a <?php echo $this->get_render_attribute_string( 'marker' ); ?>>

					<?php if ( $marker['select_type'] === 'icon' ) { ?>
						<?php if ( $marker['marker_select_icon']['value'] ) :
							Icons_Manager::render_icon( $marker['marker_select_icon'], [ 'aria-hidden' => 'true' ] );
						else : ?>
							<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="marker">
								<rect x="9" y="4" width="1" height="11"></rect>
								<rect x="4" y="9" width="11" height="1"></rect>
							</svg>
						<?php endif;
					} elseif ( $marker['select_type'] === 'image' ) {
						echo wp_get_attachment_image( $marker['image']['id'] );
					} elseif ( $marker['select_type'] === 'none' ) {
						// echo '';
					} else {
						echo esc_html( $marker['text'] );
					}
					?>

				</a>


				<?php
			} ?>
		</div>
		<?php
	}

	protected function render_item_two_content() {
		$settings = $this->get_settings_for_display();
		$id       = 'bdt-drop-two-' . $this->get_id();

		if ( empty( $settings['two_image']['url'] ) ) {
			return;
		}

		$this->add_render_attribute( 'wrapper', 'class', 'bdt-woohotspot-wrap bdt-flex bdt-woohotspot-animated bdt-dark' );
		$this->add_render_attribute( 'wrapper', 'id', esc_attr( $id ) );

		?>

		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php

			$placeholder_image_src = Utils::get_placeholder_image_src();
			$image_src             = wp_get_attachment_image_src( $settings['two_image']['id'], 'full' );
			if ( ! $image_src ) {
				printf( '<img src="%1$s" alt="%2$s">', esc_url( $placeholder_image_src ), esc_html( get_the_title() ) );
			} else {
				print( wp_get_attachment_image(
					$settings['two_image']['id'],
					$settings['thumbnail_size'],
					false,
					[ 

						'alt' => esc_html( get_the_title() )
					]
				) );
			}

			foreach ( $settings['two_markers'] as $marker ) {

				$marker_title = $this->render_two_product_content( $marker );
				$this->marker_render_attributes( $marker, $marker_title );

				if ( 'none' == $marker['two_select_type'] ) {
					$this->add_render_attribute( 'marker', 'class', 'bdt-woohotspot-invisible' );
				}
				if ( $marker['two_marker_tooltip_placement'] ) {
					$this->add_render_attribute( 'marker', 'data-tippy-placement', $marker['two_marker_tooltip_placement'], true );
				}

				?>
				<a <?php echo $this->get_render_attribute_string( 'marker' ); ?>>

					<?php if ( $marker['two_select_type'] === 'icon' ) { ?>
						<?php if ( $marker['two_marker_select_icon']['value'] ) :
							Icons_Manager::render_icon( $marker['two_marker_select_icon'], [ 'aria-hidden' => 'true' ] );
						else : ?>
							<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="marker">
								<rect x="9" y="4" width="1" height="11"></rect>
								<rect x="4" y="9" width="11" height="1"></rect>
							</svg>
						<?php endif;
					} elseif ( $marker['two_select_type'] === 'image' ) {
						echo wp_get_attachment_image( $marker['two_image']['id'] );
					} elseif ( $marker['two_select_type'] === 'none' ) {
						// echo '';
					} else {
						echo esc_html( $marker['two_text'] );
					}
					?>

				</a>
				<?php
			} ?>
		</div>
		<?php
	}

	protected function render_item_three_content() {
		$settings = $this->get_settings_for_display();
		$id       = 'bdt-drop-three-' . $this->get_id();

		if ( empty( $settings['three_image']['url'] ) ) {
			return;
		}

		$this->add_render_attribute( 'wrapper', 'class', 'bdt-woohotspot-wrap bdt-flex bdt-woohotspot-animated bdt-dark' );
		$this->add_render_attribute( 'wrapper', 'id', esc_attr( $id ) );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php

			$placeholder_image_src = Utils::get_placeholder_image_src();
			$image_src             = wp_get_attachment_image_src( $settings['three_image']['id'], 'full' );
			if ( ! $image_src ) {
				printf( '<img src="%1$s" alt="%2$s">', esc_url( $placeholder_image_src ), esc_html( get_the_title() ) );
			} else {
				print( wp_get_attachment_image(
					$settings['three_image']['id'],
					$settings['thumbnail_size'],
					false,
					[ 

						'alt' => esc_html( get_the_title() )
					]
				) );
			}

			foreach ( $settings['three_markers'] as $marker ) {

				$marker_title = $this->render_three_product_content( $marker );
				$this->marker_render_attributes( $marker, $marker_title );

				if ( 'none' == $marker['three_select_type'] ) {
					$this->add_render_attribute( 'marker', 'class', 'bdt-woohotspot-invisible' );
				}
				if ( $marker['three_marker_tooltip_placement'] ) {
					$this->add_render_attribute( 'marker', 'data-tippy-placement', $marker['three_marker_tooltip_placement'], true );
				}

				?>
				<a <?php echo $this->get_render_attribute_string( 'marker' ); ?>>

					<?php if ( $marker['three_select_type'] === 'icon' ) { ?>
						<?php if ( $marker['three_marker_select_icon']['value'] ) :
							Icons_Manager::render_icon( $marker['three_marker_select_icon'], [ 'aria-hidden' => 'true' ] );
						else : ?>
							<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="marker">
								<rect x="9" y="4" width="1" height="11"></rect>
								<rect x="4" y="9" width="11" height="1"></rect>
							</svg>
						<?php endif;
					} elseif ( $marker['three_select_type'] === 'image' ) {
						echo wp_get_attachment_image( $marker['three_image']['id'] );
					} elseif ( $marker['three_select_type'] === 'none' ) {
						// echo '';
					} else {
						echo esc_html( $marker['three_text'] );
					}
					?>

				</a>

				<?php
			} ?>
		</div>
		<?php
	}

	public function render_slides_loop() {
		$settings = $this->get_settings_for_display();
		?>

		<?php if ( ! empty( $settings['image']['url'] ) ) : ?>
			<div class="swiper-slide bdt-item">
				<div class="bdt-flex">
					<?php $this->render_item_content(); ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $settings['two_image']['url'] ) ) : ?>
			<div class="swiper-slide bdt-item">
				<div class="bdt-flex">
					<?php $this->render_item_two_content(); ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $settings['three_image']['url'] ) ) : ?>
			<div class="swiper-slide bdt-item">
				<div class="bdt-flex">
					<?php $this->render_item_three_content(); ?>
				</div>
			</div>
		<?php endif; ?>
	<?php
	}

	protected function render_header() {
		$settings = $this->get_settings_for_display();
		$id       = 'woohotspot-' . $this->get_id();

		$this->add_render_attribute( 'prime-slider-woohotspot', 'id', $id );
		$this->add_render_attribute( 'prime-slider-woohotspot', 'class', [ 'bdt-prime-slider-woohotspot', 'elementor-swiper' ] );

		$this->add_render_attribute(
			[ 
				'prime-slider-woohotspot' => [ 
					'data-settings' => [ 
						wp_json_encode( array_filter( [ 
							'id'                  => $id,
							"autoplay"            => ( "yes" == $settings["autoplay"] ) ? [ "delay" => $settings["autoplay_speed"] ] : false,
							"rewind"              => ( $settings["rewind"] == "yes" ) ? true : false,
							"loop"                => false,
							"autoHeight"          => true,
							"speed"               => $settings["speed"]["size"],
							"pauseOnHover"        => ( "yes" == $settings["pauseonhover"] ) ? true : false,
							"simulateTouch"       => false,
							"grabCursor"          => ( $settings["grab_cursor"] === "yes" ) ? true : false,
							"effect"              => isset( $settings["transition"] ) ? $settings["transition"] : 'slide',
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
							"observer"            => ( $settings["observer"] ) ? true : false,
							"observeParents"      => ( $settings["observer"] ) ? true : false,
							"navigation"          => [ 
								"nextEl" => "#" . $id . " .bdt-navigation-next",
								"prevEl" => "#" . $id . " .bdt-navigation-prev",
							],
							"pagination"          => [ 
								"el"        => "#" . $id . " .swiper-pagination",
								"clickable" => true,
							],
						] ) )
					]
				]
			]
		);

		$this->add_render_attribute( 'prime-slider', 'class', 'bdt-prime-slider' );

		$swiper_class = Plugin::$instance->experiments->is_feature_active( 'e_swiper_latest' ) ? 'swiper' : 'swiper-container';
		$this->add_render_attribute( 'swiper', 'class', 'swiper-woohotspot ' . $swiper_class );

		?>
		<div <?php $this->print_render_attribute_string( 'prime-slider' ); ?>>
			<div <?php $this->print_render_attribute_string( 'prime-slider-woohotspot' ); ?>>
				<div <?php $this->print_render_attribute_string( 'swiper' ); ?>>
					<div class="swiper-wrapper">
						<?php
	}

	public function render_footer() {
		$settings = $this->get_settings_for_display();

		?>
					</div>
				</div>

				<?php $this->render_navigation_dots(); ?>
				<?php $this->render_navigation_arrows(); ?>
			</div>
		</div>

		<?php
	}

	public function render_navigation_arrows() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'prime-slider-arrows', 'class', 'bdt-navigation-arrows bdt-position-z-index' );


		?>

		<?php if ( $settings['show_navigation_arrows'] ) : ?>
			<div <?php $this->print_render_attribute_string( 'prime-slider-arrows' ); ?>>
				<div class="bdt-navigation-prev bdt-woohotspot-slidenav">
					<i class="ps-wi-arrow-left-<?php echo esc_html( $settings['nav_arrows_icon'] ); ?>" aria-hidden="true"></i>
				</div>
				<div class="bdt-navigation-next bdt-woohotspot-slidenav">
					<i class="ps-wi-arrow-right-<?php echo esc_html( $settings['nav_arrows_icon'] ); ?>" aria-hidden="true"></i>
				</div>
			</div>
		<?php endif; ?>

		<?php
	}

	public function render_navigation_dots() {
		$settings = $this->get_settings_for_display();

		?>
		<?php if ( $settings['show_navigation_dots'] ) : ?>
			<div class="bdt-navigation-dots">
				<div class="swiper-pagination"></div>
			</div>
		<?php endif; ?>
	<?php
	}

	public function render() {
		$this->render_header();
		$this->render_slides_loop();
		$this->render_footer();
	}
}
