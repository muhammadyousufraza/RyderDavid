<?php
namespace PrimeSliderPro\Modules\EventCalendar\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Plugin;
use PrimeSliderPro\Utils;

use PrimeSlider\Traits\Global_Widget_Controls;

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

/**
 * Class Post Slider
 */
class Event_Calendar extends Widget_Base {

	use Global_Widget_Controls;

	public $_query = null;

	public function get_name() {
		return 'prime-slider-event-calendar';
	}

	public function get_title() {
		return BDTPS . __( 'Event Calendar', 'bdthemes-prime-slider' );
	}

	public function get_icon() {
		return 'bdt-widget-icon ps-wi-event-calendar';
	}

	public function get_categories() {
		return [ 'prime-slider-pro' ];
	}

	public function get_keywords() {
		return [ 'events', 'slider', 'calendar', 'countdown', 'event slider' ];
	}

	public function get_style_depends() {
		return [ 'prime-slider-font', 'ps-event-calendar' ];
	}

	public function get_script_depends() {
		return [ 'ps-event-calendar' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/M5GpxSdlt_8';
	}

	public function get_query() {
		return $this->_query;
	}

	public function register_controls() {

		$this->start_controls_section(
			'section_content_layout',
			[ 
				'label' => __( 'Layout', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_responsive_control(
			'slider_item_height',
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
					'{{WRAPPER}} .bdt-event-calendar .bdt-event-item' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_align',
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
					'{{WRAPPER}} .bdt-event-calendar .bdt-event-content' => 'text-align: {{VALUE}};',
				],
			]
		);

		/**
		 * Show Title Controls
		 */
		$this->register_show_title_controls();

		$this->add_control(
			'show_date',
			[ 
				'label'   => __( 'Show Date', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		/**
		 * Show Post Excerpt Controls
		 */
		$this->register_show_post_excerpt_controls();

		$this->add_control(
			'show_buy_button',
			[ 
				'label'   => __( 'Show Buy Button', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'button_link',
			[ 
				'label'         => esc_html__( 'Custom Link', 'bdthemes-prime-slider' ),
				'description'   => __( 'When you use Buy Button, Please type your custom link.', 'bdthemes-prime-slider' ),
				'type'          => Controls_Manager::URL,
				'default'       => [ 'url' => '#' ],
				'show_external' => false,
				'dynamic'       => [ 'active' => true ],
				'condition'     => [ 
					'show_buy_button' => 'yes'
				]
			]
		);

		$this->add_control(
			'show_meta_location',
			[ 
				'label'   => __( 'Show Location', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[ 
				'name'    => 'image',
				'label'   => esc_html__( 'Image Size', 'bdthemes-element-pack' ),
				'exclude' => [ 'custom' ],
				'default' => 'full',
			]
		);

		//Global background settings Controls
		$this->register_background_settings( '.bdt-event-calendar .bdt-event-item .bdt-ps-slide-img' );

		$this->add_control(
			'event_countdown_heading',
			[ 
				'label'     => __( 'Event Countdown', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_days',
			[ 
				'label'   => esc_html__( 'Days', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_hours',
			[ 
				'label'   => esc_html__( 'Hours', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_minutes',
			[ 
				'label'   => esc_html__( 'Minutes', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_seconds',
			[ 
				'label'   => esc_html__( 'Seconds', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_labels',
			[ 
				'label'   => esc_html__( 'Show Label', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'custom_labels',
			[ 
				'label'        => esc_html__( 'Custom Label', 'bdthemes-prime-slider' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'condition'    => [ 
					'show_labels!' => '',
				],
			]
		);

		$this->add_control(
			'label_days',
			[ 
				'label'       => esc_html__( 'Days', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Days', 'bdthemes-prime-slider' ),
				'placeholder' => esc_html__( 'Days', 'bdthemes-prime-slider' ),
				'condition'   => [ 
					'show_labels!'   => '',
					'custom_labels!' => '',
					'show_days'      => 'yes',
				],
			]
		);

		$this->add_control(
			'label_hours',
			[ 
				'label'       => esc_html__( 'Hours', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Hours', 'bdthemes-prime-slider' ),
				'placeholder' => esc_html__( 'Hours', 'bdthemes-prime-slider' ),
				'condition'   => [ 
					'show_labels!'   => '',
					'custom_labels!' => '',
					'show_hours'     => 'yes',
				],
			]
		);

		$this->add_control(
			'label_minutes',
			[ 
				'label'       => esc_html__( 'Minutes', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Minutes', 'bdthemes-prime-slider' ),
				'placeholder' => esc_html__( 'Minutes', 'bdthemes-prime-slider' ),
				'condition'   => [ 
					'show_labels!'   => '',
					'custom_labels!' => '',
					'show_minutes'   => 'yes',
				],
			]
		);

		$this->add_control(
			'label_seconds',
			[ 
				'label'       => esc_html__( 'Seconds', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Seconds', 'bdthemes-prime-slider' ),
				'placeholder' => esc_html__( 'Seconds', 'bdthemes-prime-slider' ),
				'condition'   => [ 
					'show_labels!'   => '',
					'custom_labels!' => '',
					'show_seconds'   => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_query',
			[ 
				'label' => __( 'Query', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'source',
			[ 
				'label'       => _x( 'Source', 'Posts Query Control', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [ 
					''        => esc_html__( 'Show All', 'bdthemes-prime-slider' ),
					'by_name' => esc_html__( 'Manual Selection', 'bdthemes-prime-slider' ),
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'event_categories',
			[ 
				'label'       => esc_html__( 'Categories', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => prime_slider_get_category( 'tribe_events_cat' ),
				'default'     => [],
				'label_block' => true,
				'multiple'    => true,
				'condition'   => [ 
					'source' => 'by_name',
				],
			]
		);


		$this->add_control(
			'start_date',
			[ 
				'label'       => esc_html__( 'Start Date', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [ 
					''           => esc_html__( 'Any Time', 'bdthemes-prime-slider' ),
					'now'        => esc_html__( 'Now', 'bdthemes-prime-slider' ),
					'today'      => esc_html__( 'Today', 'bdthemes-prime-slider' ),
					'last month' => esc_html__( 'Last Month', 'bdthemes-prime-slider' ),
					'custom'     => esc_html__( 'Custom', 'bdthemes-prime-slider' ),
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'custom_start_date',
			[ 
				'label'     => esc_html__( 'Custom Start Date', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::DATE_TIME,
				'condition' => [ 
					'start_date' => 'custom'
				]
			]
		);

		$this->add_control(
			'end_date',
			[ 
				'label'       => esc_html__( 'End Date', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [ 
					''           => esc_html__( 'Any Time', 'bdthemes-prime-slider' ),
					'now'        => esc_html__( 'Now', 'bdthemes-prime-slider' ),
					'today'      => esc_html__( 'Today', 'bdthemes-prime-slider' ),
					'next month' => esc_html__( 'Last Month', 'bdthemes-prime-slider' ),
					'custom'     => esc_html__( 'Custom', 'bdthemes-prime-slider' ),
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'custom_end_date',
			[ 
				'label'     => esc_html__( 'Custom End Date', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::DATE_TIME,
				'condition' => [ 
					'end_date' => 'custom'
				]
			]
		);

		$this->add_control(
			'limit',
			[ 
				'label'   => esc_html__( 'Limit', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
			]
		);

		$this->add_control(
			'orderby',
			[ 
				'label'   => esc_html__( 'Order by', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'event_date',
				'options' => [ 
					'event_date' => esc_html__( 'Event Date', 'bdthemes-prime-slider' ),
					'title'      => esc_html__( 'Title', 'bdthemes-prime-slider' ),
					'category'   => esc_html__( 'Category', 'bdthemes-prime-slider' ),
					'rand'       => esc_html__( 'Random', 'bdthemes-prime-slider' ),
				],
			]
		);

		$this->add_control(
			'order',
			[ 
				'label'   => esc_html__( 'Order', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [ 
					'DESC' => esc_html__( 'Descending', 'bdthemes-prime-slider' ),
					'ASC'  => esc_html__( 'Ascending', 'bdthemes-prime-slider' ),
				],
			]
		);



		$this->end_controls_section();


		$this->start_controls_section(
			'section_content_navigation',
			[ 
				'label' => __( 'Navigation', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'navigation',
			[ 
				'label'        => __( 'Navigation', 'bdthemes-prime-slider' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'arrows',
				'options'      => [ 
					'both'   => __( 'Arrows and Dots', 'bdthemes-prime-slider' ),
					'arrows' => __( 'Arrows', 'bdthemes-prime-slider' ),
					'dots'   => __( 'Dots', 'bdthemes-prime-slider' ),
					'none'   => __( 'None', 'bdthemes-prime-slider' ),
				],
				'prefix_class' => 'bdt-navigation-type-',
				'render_type'  => 'template',
			]
		);

		$this->add_control(
			'both_position',
			[ 
				'label'     => __( 'Arrows and Dots Position', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => prime_slider_navigation_position(),
				'condition' => [ 
					'navigation' => 'both',
				],
			]
		);

		$this->add_control(
			'arrows_position',
			[ 
				'label'     => __( 'Arrows Position', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center',
				'options'   => prime_slider_navigation_position(),
				'condition' => [ 
					'navigation' => 'arrows',
				],
			]
		);

		$this->add_control(
			'hide_arrows',
			[ 
				'label'     => __( 'Hide Arrows on Moblile ?', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [ 
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_position',
			[ 
				'label'     => __( 'Dots Position', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'bottom-center',
				'options'   => prime_slider_pagination_position(),
				'condition' => [ 
					'navigation' => 'dots',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_slider_settings',
			[ 
				'label' => __( 'Slider Settings', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'autoplay',
			[ 
				'label'   => __( 'Autoplay', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',

			]
		);

		$this->add_control(
			'autoplay_speed',
			[ 
				'label'     => esc_html__( 'Autoplay Speed (ms)', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
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
			'slides_to_scroll',
			[ 
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__( 'Slides to Scroll', 'bdthemes-prime-slider' ),
				'options' => [ 
					1 => '1',
					2 => '2',
					3 => '3',
					4 => '4',
					5 => '5',
					6 => '6',
				],
				'default' => '1',
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

		// Style Section
		$this->start_controls_section(
			'section_style_item',
			[ 
				'label' => __( 'Items', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'item_background',
			[ 
				'label'     => __( 'Overlay Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-event-image:before' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'slider_item_width',
			[ 
				'label'     => esc_html__( 'Max Width', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 100,
						'max' => 1200,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-event-content' => 'max-width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .bdt-event-calendar .bdt-event-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_hover_color',
			[ 
				'label'     => esc_html__( 'Hover Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-event-title:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-event-calendar .bdt-event-title-wrap',
			]
		);
		$this->add_group_control(
			Group_Control_Text_Stroke::get_type(),
			[ 
				'name'     => 'title_text_stroke',
				'label'    => esc_html__( 'Text Stroke', 'bdthemes-prime-slider' ) . BDTPS_PRO_NC,
				'selector' => '{{WRAPPER}} .bdt-event-calendar .bdt-event-title-wrap',
			]
		);
		$this->add_responsive_control(
			'title_spacing',
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
					'{{WRAPPER}} .bdt-event-calendar .bdt-event-content .bdt-event-title-wrap' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_date',
			[ 
				'label'     => esc_html__( 'Date', 'bdthemes-prime-slider' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_date' => [ 'yes' ],
				],
			]
		);

		$this->add_control(
			'date_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-event-content .bdt-event-date a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'day_bg_color',
			[ 
				'label'     => esc_html__( 'background Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-event-content .bdt-event-date a .bdt-event-day' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'date_typography',
				'selector' => '{{WRAPPER}} .bdt-event-calendar .bdt-event-content .bdt-event-date a',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_excerpt',
			[ 
				'label'     => esc_html__( 'Excerpt', 'bdthemes-prime-slider' ),
				'tab'       => Controls_Manager::TAB_STYLE,
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
					'{{WRAPPER}} .bdt-event-calendar .bdt-event-excerpt' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'excerpt_typography',
				'label'    => esc_html__( 'Typography', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-event-calendar .bdt-event-excerpt',
			]
		);

		$this->add_responsive_control(
			'excerpt_spacing',
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
					'{{WRAPPER}} .bdt-event-calendar .bdt-event-excerpt' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_button',
			[ 
				'label'     => esc_html__( 'Button', 'bdthemes-prime-slider' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_buy_button' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[ 
				'label' => esc_html__( 'Normal', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-event-content .bdt-event-meta .bdt-event-price a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'button_background',
				'selector' => '{{WRAPPER}} .bdt-event-calendar .bdt-event-content .bdt-event-meta .bdt-event-price a',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .bdt-event-calendar .bdt-event-content .bdt-event-meta .bdt-event-price a',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'      => 'button_border',
				'label'     => esc_html__( 'Border', 'bdthemes-prime-slider' ),
				'selector'  => '{{WRAPPER}} .bdt-event-calendar .bdt-event-content .bdt-event-meta .bdt-event-price a',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_border_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-event-content .bdt-event-meta .bdt-event-price a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [ 
					'border_radius_advanced_show!' => 'yes',
				],
			]
		);

		$this->add_control(
			'border_radius_advanced_show',
			[ 
				'label' => __( 'Advanced Radius', 'bdthemes-prime-slider' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'border_radius_advanced',
			[ 
				'label'       => esc_html__( 'Radius', 'bdthemes-prime-slider' ),
				'description' => sprintf( __( 'For example: %1s or Go %2s this link %3s and copy and paste the radius value.', 'bdthemes-prime-slider' ), '<b>30% 70% 82% 18% / 46% 62% 38% 54%</b>', '<a href="https://9elements.github.io/fancy-border-radius/" target="_blank">', '</a>' ),
				'type'        => Controls_Manager::TEXT,
				'size_units'  => [ 'px', '%' ],
				'separator'   => 'after',
				'default'     => '30% 70% 82% 18% / 46% 62% 38% 54%',
				'selectors'   => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-event-content .bdt-event-meta .bdt-event-price a' => 'border-radius: {{VALUE}}; overflow: hidden;',
				],
				'condition'   => [ 
					'border_radius_advanced_show' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[ 
				'label'      => esc_html__( 'Padding', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-event-content .bdt-event-meta .bdt-event-price a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .bdt-event-calendar .bdt-event-content .bdt-event-meta .bdt-event-price a',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[ 
				'label' => esc_html__( 'Hover', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'button_hover_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-event-content .bdt-event-meta .bdt-event-price a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_line_color',
			[ 
				'label'     => esc_html__( 'Line Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-event-content .bdt-event-meta .bdt-event-price a:before' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'button_hover_background',
				'selector' => '{{WRAPPER}} .bdt-event-calendar .bdt-event-content .bdt-event-meta .bdt-event-price a:hover',
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[ 
				'label'     => esc_html__( 'Border Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 
					'button_border_border!' => '',
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-event-content .bdt-event-meta .bdt-event-price a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_location',
			[ 
				'label'     => esc_html__( 'Location', 'bdthemes-prime-slider' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'show_meta_location' => 'yes',
				],
			]
		);

		$this->add_control(
			'location_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-event-content .bdt-event-meta .bdt-address-website-icon a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'location_hover_color',
			[ 
				'label'     => esc_html__( 'Hover Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-event-content .bdt-event-meta .bdt-address-website-icon a:hover' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'location_typography',
				'selector' => '{{WRAPPER}} .bdt-event-calendar .bdt-event-content .bdt-event-meta .bdt-address-website-icon a',
			]
		);

		$this->add_responsive_control(
			'location_spacing',
			[ 
				'label'     => esc_html__( 'Spacing', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-event-content .bdt-event-meta .bdt-address-website-icon a' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_countdown',
			[ 
				'label' => __( 'Countdown', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_countdown_style' );

		$this->start_controls_tab(
			'tab_countdown_normal',
			[ 
				'label' => esc_html__( 'Normal', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'countdown_text_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-countdown-item' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'countdown_background',
				'selector' => '{{WRAPPER}} .bdt-event-calendar .bdt-countdown-item',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'     => 'countdown_border',
				'label'    => esc_html__( 'Border', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-event-calendar .bdt-countdown-item',
			]
		);

		$this->add_control(
			'countdown_border_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-countdown-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'countdown_padding',
			[ 
				'label'      => esc_html__( 'Padding', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-countdown-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'countdown_number_typography',
				'label'    => esc_html__( 'Number Typography', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-event-calendar .bdt-countdown-item .bdt-countdown-number',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'countdown_text_typography',
				'label'    => esc_html__( 'Text Typography', 'bdthemes-prime-slider' ),
				'selector' => '{{WRAPPER}} .bdt-event-calendar .bdt-countdown-item .bdt-countdown-label',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'countdown_box_shadow',
				'selector' => '{{WRAPPER}} .bdt-event-calendar .bdt-countdown-item',
			]
		);

		$this->add_responsive_control(
			'countdown_spacing',
			[ 
				'label'     => esc_html__( 'Spacing', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 0,
						'max' => 150,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-countdown-wrapper' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_countdown_hover',
			[ 
				'label' => esc_html__( 'Hover', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'countdown_hover_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-countdown-item:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'countdown_hover_background',
				'selector' => '{{WRAPPER}} .bdt-event-calendar .bdt-countdown-item:hover',
			]
		);

		$this->add_control(
			'countdown_hover_border_color',
			[ 
				'label'     => esc_html__( 'Border Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-countdown-item:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[ 
				'label'     => __( 'Navigation', 'bdthemes-prime-slider' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 
					'navigation' => [ 'arrows', 'dots', 'both' ],
				],
			]
		);

		$this->add_responsive_control(
			'arrows_size',
			[ 
				'label'     => __( 'Arrows Size', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 20,
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-navigation-prev i, {{WRAPPER}} .bdt-event-calendar .bdt-navigation-next i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_background',
			[ 
				'label'     => __( 'Background Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-navigation-prev, {{WRAPPER}} .bdt-event-calendar .bdt-navigation-next' => 'background-color: {{VALUE}}',
				],
				'condition' => [ 
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_background',
			[ 
				'label'     => __( 'Hover Background Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-navigation-prev:hover, {{WRAPPER}} .bdt-event-calendar .bdt-navigation-next:hover' => 'background-color: {{VALUE}}',
				],
				'condition' => [ 
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_color',
			[ 
				'label'     => __( 'Arrows Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-navigation-prev svg, {{WRAPPER}} .bdt-event-calendar .bdt-navigation-next svg' => 'color: {{VALUE}}',
				],
				'condition' => [ 
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_hover_color',
			[ 
				'label'     => __( 'Arrows Hover Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-navigation-prev:hover svg, {{WRAPPER}} .bdt-event-calendar .bdt-navigation-next:hover svg' => 'color: {{VALUE}}',
				],
				'condition' => [ 
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_space',
			[ 
				'label'      => __( 'Space', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 
					'px' => [ 
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-navigation-prev' => 'margin-right: {{SIZE}}px;',
					'{{WRAPPER}} .bdt-event-calendar .bdt-navigation-next' => 'margin-left: {{SIZE}}px;',
				],
				'conditions' => [ 
					'terms' => [ 
						[ 
							'name'  => 'navigation',
							'value' => 'both',
						],
						[ 
							'name'     => 'both_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
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
					'{{WRAPPER}} .bdt-event-calendar .bdt-navigation-prev, {{WRAPPER}} .bdt-event-calendar .bdt-navigation-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[ 
				'label'      => __( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'separator'  => 'after',
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-navigation-prev, {{WRAPPER}} .bdt-event-calendar .bdt-navigation-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [ 
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_size',
			[ 
				'label'     => __( 'Dots Size', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 5,
						'max' => 20,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-event-calendar .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_width',
			[ 
				'label'     => __( 'Active Size', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'px' => [ 
						'min' => 5,
						'max' => 50,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-event-calendar .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_color',
			[ 
				'label'     => __( 'Dots Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-event-calendar .swiper-pagination-bullet' => 'background-color: {{VALUE}}',
				],
				'condition' => [ 
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'active_dot_color',
			[ 
				'label'     => __( 'Active Dots Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-event-calendar .swiper-pagination-bullet-active' => 'background-color: {{VALUE}}',
				],
				'condition' => [ 
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_border_radius',
			[ 
				'label'      => __( 'Dots Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-event-calendar .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [ 
					'navigation' => [ 'dots', 'both' ],
				],
				'separator'  => 'after',
			]
		);

		$this->add_control(
			'arrows_ncx_position',
			[ 
				'label'      => __( 'Horizontal Offset', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [ 
					'size' => 0,
				],
				'range'      => [ 
					'px' => [ 
						'min' => -200,
						'max' => 200,
					],
				],
				'conditions' => [ 
					'terms' => [ 
						[ 
							'name'  => 'navigation',
							'value' => 'arrows',
						],
						[ 
							'name'     => 'arrows_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'arrows_ncy_position',
			[ 
				'label'      => __( 'Vertical Offset', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [ 
					'size' => 0,
				],
				'range'      => [ 
					'px' => [ 
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-arrows-container' => 'transform: translate({{arrows_ncx_position.size}}px, {{SIZE}}px);',
				],
				'conditions' => [ 
					'terms' => [ 
						[ 
							'name'  => 'navigation',
							'value' => 'arrows',
						],
						[ 
							'name'     => 'arrows_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'arrows_acx_position',
			[ 
				'label'      => __( 'Horizontal Offset', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [ 
					'size' => 20,
				],
				'range'      => [ 
					'px' => [ 
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .bdt-event-calendar .bdt-navigation-next' => 'right: {{SIZE}}px;',
				],
				'conditions' => [ 
					'terms' => [ 
						[ 
							'name'  => 'navigation',
							'value' => 'arrows',
						],
						[ 
							'name'  => 'arrows_position',
							'value' => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'dots_nnx_position',
			[ 
				'label'      => __( 'Horizontal Offset', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [ 
					'size' => 0,
				],
				'range'      => [ 
					'px' => [ 
						'min' => -200,
						'max' => 200,
					],
				],
				'conditions' => [ 
					'terms' => [ 
						[ 
							'name'  => 'navigation',
							'value' => 'dots',
						],
						[ 
							'name'     => 'dots_position',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'dots_nny_position',
			[ 
				'label'      => __( 'Vertical Offset', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [ 
					'size' => 0,
				],
				'range'      => [ 
					'px' => [ 
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-dots-container' => 'transform: translate({{dots_nnx_position.size}}px, {{SIZE}}px);',
				],
				'conditions' => [ 
					'terms' => [ 
						[ 
							'name'  => 'navigation',
							'value' => 'dots',
						],
						[ 
							'name'     => 'dots_position',
							'operator' => '!=',
							'value'    => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'both_ncx_position',
			[ 
				'label'      => __( 'Horizontal Offset', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [ 
					'size' => 0,
				],
				'range'      => [ 
					'px' => [ 
						'min' => -200,
						'max' => 200,
					],
				],
				'conditions' => [ 
					'terms' => [ 
						[ 
							'name'  => 'navigation',
							'value' => 'both',
						],
						[ 
							'name'     => 'both_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'both_ncy_position',
			[ 
				'label'      => __( 'Vertical Offset', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [ 
					'size' => 0,
				],
				'range'      => [ 
					'px' => [ 
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-arrows-dots-container' => 'transform: translate({{both_ncx_position.size}}px, {{SIZE}}px);',
				],
				'conditions' => [ 
					'terms' => [ 
						[ 
							'name'  => 'navigation',
							'value' => 'both',
						],
						[ 
							'name'     => 'both_position',
							'operator' => '!=',
							'value'    => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'both_cx_position',
			[ 
				'label'      => __( 'Arrows Offset', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [ 
					'size' => 20,
				],
				'range'      => [ 
					'px' => [ 
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-navigation-prev' => 'left: {{SIZE}}px;',
					'{{WRAPPER}} .bdt-event-calendar .bdt-navigation-next' => 'right: {{SIZE}}px;',
				],
				'conditions' => [ 
					'terms' => [ 
						[ 
							'name'  => 'navigation',
							'value' => 'both',
						],
						[ 
							'name'  => 'both_position',
							'value' => 'center',
						],
					],
				],
			]
		);

		$this->add_control(
			'both_cy_position',
			[ 
				'label'      => __( 'Dots Offset', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [ 
					'size' => -40,
				],
				'range'      => [ 
					'px' => [ 
						'min' => -200,
						'max' => 200,
					],
				],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-event-calendar .bdt-dots-container' => 'transform: translateY({{SIZE}}px);',
				],
				'conditions' => [ 
					'terms' => [ 
						[ 
							'name'  => 'navigation',
							'value' => 'both',
						],
						[ 
							'name'  => 'both_position',
							'value' => 'center',
						],
					],
				],
			]
		);

		$this->end_controls_section();

	}

	public function render() {

		$settings = $this->get_settings_for_display();

		global $post;

		$start_date = ( 'custom' == $settings['start_date'] ) ? $settings['custom_start_date'] : $settings['start_date'];
		$end_date   = ( 'custom' == $settings['end_date'] ) ? $settings['custom_end_date'] : $settings['end_date'];

		$query_args = array_filter( [ 
			'start_date'     => $start_date,
			'end_date'       => $end_date,
			'orderby'        => $settings['orderby'],
			'order'          => $settings['order'],
			'eventDisplay'   => ( 'custom' == $settings['start_date'] or 'custom' == $settings['end_date'] ) ? 'custom' : 'all',
			'posts_per_page' => $settings['limit'],
			//'tag'          => 'donor-program', // or whatever the tag name is
		] );


		if ( 'by_name' === $settings['source'] and ! empty( $settings['event_categories'] ) ) {
			$query_args['tax_query'][] = [ 
				'taxonomy' => 'tribe_events_cat',
				'field'    => 'slug',
				'terms'    => $settings['event_categories'],
			];
		}

		$query_args = tribe_get_events( $query_args );

		$this->render_header();

		foreach ( $query_args as $post ) {


			$this->render_loop_item( $post );
		}

		$this->render_footer();

		wp_reset_postdata();
	}

	public function render_image() {
		$settings = $this->get_settings_for_display();

		$settings['image'] = [ 
			'id' => get_post_thumbnail_id(),
		];

		$url = wp_get_attachment_image_url( get_post_thumbnail_id(), $settings['image_size'] );
		?>

		<div class="bdt-event-image">
			<div class="bdt-ps-slide-img"
				style="background-image: url('<?php echo esc_url( $url ); ?>')">
			</div>
		</div>

		<?php
	}

	public function render_title() {
		$settings = $this->get_settings_for_display();

		if ( ! $this->get_settings( 'show_title' ) ) {
			return;
		}

		?>

		<<?php echo esc_attr( Utils::get_valid_html_tag( $settings['sub_title_html_tag'] ) ); ?> class="bdt-event-title-wrap">
			<a href="<?php echo esc_url( get_permalink() ); ?>" class="bdt-event-title">
				<?php the_title() ?>
			</a>
		</<?php echo esc_attr( Utils::get_valid_html_tag( $settings['sub_title_html_tag'] ) ); ?>>
		<?php
	}

	public function render_date() {
		if ( ! $this->get_settings( 'show_date' ) ) {
			return;
		}

		$start_datetime = tribe_get_start_date();
		$end_datetime   = tribe_get_end_date();

		$event_day   = tribe_get_start_date( null, false, 'j' );
		$event_month = tribe_get_start_date( null, false, 'F' );
		$event_year  = tribe_get_start_date( null, false, 'Y' );

		?>
		<span class="bdt-event-date">
			<a href="#"
				title="<?php esc_html_e( 'Start Date:', 'bdthemes-prime-slider' );
				echo esc_html( $start_datetime ); ?>  - <?php esc_html_e( 'End Date:', 'bdthemes-prime-slider' );
					echo esc_html( $end_datetime ); ?>">
				<span class="bdt-event-day">
					<?php echo esc_html( str_pad( $event_day, 2, '0', STR_PAD_LEFT ) ); ?>
				</span>
				<span>
					<?php echo esc_html( $event_month ); ?>
				</span>
				<span>
					<?php echo esc_html( $event_year ); ?>
				</span>
			</a>
		</span>
		<?php
	}

	public function render_excerpt( $post ) {
		if ( ! $this->get_settings( 'show_excerpt' ) ) {
			return;
		}

		?>
		<div class="bdt-event-excerpt">
			<?php

			if ( ! $post->post_excerpt ) {
				echo strip_shortcodes( wp_trim_words( $post->post_content, $this->get_settings( 'excerpt_length' ) ) );

			} else {
				echo strip_shortcodes( wp_trim_words( $post->post_excerpt, $this->get_settings( 'excerpt_length' ) ) );

			}

			?>
		</div>
		<?php

	}

	public function render_meta() {
		$settings = $this->get_settings_for_display();

		$address = ( $settings['show_meta_location'] ) ? tribe_address_exists() : '';

		?>

		<div class="bdt-event-meta">

			<?php if ( 'yes' == $settings['show_buy_button'] ) : ?>
				<div class="bdt-event-price">
					<?php if ( '' !== $settings['button_link']['url'] ) : ?>
						<a href="<?php echo esc_url( $settings['button_link']['url'] ); ?>">
						<?php endif; ?>
						<span>
							<?php esc_html_e( 'Buy Ticket Online', 'bdthemes-prime-slider' ); ?>
						</span>
						<?php if ( '' !== $settings['button_link']['url'] ) : ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( $address ) : ?>
				<div class="bdt-address-website-icon">
					<a href="javacript:void(0);" bdt-tooltip="<?php echo esc_html( tribe_get_full_address() ); ?>">
						<span class="ps-wi-map-pin"></span>
						<span>
							<?php esc_html_e( ' View Location', 'bdthemes-prime-slider' ); ?>
						</span>
					</a>
				</div>
			<?php endif; ?>

		</div>

		<?php
	}

	public function render_header() {
		$settings = $this->get_settings_for_display();
		$id       = 'bdt-event-' . $this->get_id();

		$this->add_render_attribute( 'slider', 'id', $id );
		$this->add_render_attribute( 'slider', 'class', [ 'bdt-event-calendar' ] );

		if ( 'arrows' == $settings['navigation'] ) {
			$this->add_render_attribute( 'slider', 'class', 'bdt-arrows-align-' . $settings['arrows_position'] );

		}
		if ( 'dots' == $settings['navigation'] ) {
			$this->add_render_attribute( 'slider', 'class', 'bdt-dots-align-' . $settings['dots_position'] );
		}
		if ( 'both' == $settings['navigation'] ) {
			$this->add_render_attribute( 'slider', 'class', 'bdt-arrows-dots-align-' . $settings['both_position'] );
		}

		$this->add_render_attribute(
			[ 
				'slider' => [ 
					'data-settings' => [ 
						wp_json_encode( array_filter( [ 
							"autoplay"       => ( "yes" == $settings["autoplay"] ) ? [ "delay" => $settings["autoplay_speed"] ] : false,
							"loop"           => ( $settings["loop"] == "yes" ) ? true : false,
							"speed"          => $settings["speed"]["size"],
							"effect"         => 'fade',
							"lazy"           => true,
							"pauseOnHover"   => ( "yes" == $settings["pauseonhover"] ) ? true : false,
							"slidesPerView"  => 1,
							"slidesPerGroup" => ( $settings["slides_to_scroll"] > 1 ) ? $settings["slides_to_scroll"] : false,
							"observer"       => ( $settings["observer"] ) ? true : false,
							"observeParents" => ( $settings["observer"] ) ? true : false,
							"navigation"     => [ 
								"nextEl" => "#" . $id . " .bdt-navigation-next",
								"prevEl" => "#" . $id . " .bdt-navigation-prev",
							],
							"pagination"     => [ 
								"el"        => "#" . $id . " .swiper-pagination",
								"type"      => "bullets",
								"clickable" => true,
							],
						] ) )
					]
				]
			]
		);

		$swiper_class = Plugin::$instance->experiments->is_feature_active( 'e_swiper_latest' ) ? 'swiper' : 'swiper-container';
		$this->add_render_attribute( 'swiper', 'class', 'swiper-event-calendar ' . $swiper_class );

		$this->add_render_attribute( 'event-slider-wrapper', 'class', 'swiper-wrapper' );

		?>
		<div <?php $this->print_render_attribute_string( 'slider' ); ?>>
			<div <?php $this->print_render_attribute_string( 'swiper' ); ?>>
				<div <?php $this->print_render_attribute_string( 'event-slider-wrapper' ); ?>>
					<?php
	}

	public function render_both_navigation() {
		$settings    = $this->get_settings_for_display();
		$hide_arrows = $settings['hide_arrows'] ? 'bdt-visible@m' : '';
		?>

					<div class="bdt-position-z-index bdt-position-<?php echo esc_attr( $settings['both_position'] ); ?>">
						<div class="bdt-arrows-dots-container bdt-slidenav-container ">

							<div class="bdt-flex bdt-flex-middle">
								<div class="<?php echo esc_attr( $hide_arrows ); ?>">
									<a href="" class="bdt-navigation-prev bdt-slidenav-previous bdt-icon bdt-slidenav"><i
											class="ps-wi-arrow-left-5"></i></a>
								</div>

								<?php if ( 'center' !== $settings['both_position'] ) : ?>
									<div class="swiper-pagination"></div>
								<?php endif; ?>

								<div class="<?php echo esc_attr( $hide_arrows ); ?>">
									<a href="" class="bdt-navigation-next bdt-slidenav-next bdt-icon bdt-slidenav"><i
											class="ps-wi-arrow-right-5"></i></a>
								</div>

							</div>
						</div>
					</div>
					<?php
	}

	public function render_navigation() {
		$settings    = $this->get_settings_for_display();
		$hide_arrows = $settings['hide_arrows'] ? ' bdt-visible@m' : '';

		if ( 'arrows' == $settings['navigation'] ) : ?>
						<div
							class="bdt-position-z-index bdt-position-<?php echo esc_attr( $settings['arrows_position'] . $hide_arrows ); ?>">
							<div class="bdt-arrows-container bdt-slidenav-container">
								<a href="" class="bdt-navigation-prev bdt-slidenav-previous bdt-icon bdt-slidenav"><i
										class="ps-wi-arrow-left-5"></i></a>
								<a href="" class="bdt-navigation-next bdt-slidenav-next bdt-icon bdt-slidenav"><i
										class="ps-wi-arrow-right-5"></i></a>
							</div>
						</div>
					<?php endif;
	}

	public function render_pagination() {
		$settings = $this->get_settings_for_display();

		if ( 'dots' == $settings['navigation'] ) : ?>
						<?php if ( 'arrows' !== $settings['navigation'] ) : ?>
							<div class="bdt-position-z-index bdt-position-<?php echo esc_attr( $settings['dots_position'] ); ?>">
								<div class="bdt-dots-container">
									<div class="swiper-pagination"></div>
								</div>
							</div>
						<?php endif;
		endif;
	}

	public function render_footer() {
		$settings = $this->get_settings_for_display();

		?>
				</div>
			</div>
			<?php if ( 'both' == $settings['navigation'] ) : ?>
				<?php $this->render_both_navigation(); ?>
				<?php if ( 'center' === $settings['both_position'] ) : ?>
					<div class="bdt-dots-container">
						<div class="swiper-pagination"></div>
					</div>
				<?php endif; ?>
			<?php else : ?>
				<?php $this->render_pagination(); ?>
				<?php $this->render_navigation(); ?>
			<?php endif; ?>
		</div>
		<?php
	}

	public function render_loop_item( $post ) {
		?>
		<div class="bdt-event-item swiper-slide">

			<?php $this->render_image(); ?>

			<div class="bdt-position-center bdt-position-z-index">
				<div class="bdt-container">
					<div class="bdt-event-content">
						<?php $this->render_date(); ?>
						<?php $this->render_title(); ?>
						<?php $this->render_excerpt( $post ); ?>
						<?php $this->render_meta(); ?>
						<div class="bdt-event-countdown">
							<?php $this->render_event_countdown(); ?>
						</div>
					</div>
				</div>
			</div>

			<div class="bdt-default-shape">
				<div class="bdt-shape-1">
					<img src="<?php echo esc_url( BDTPS_PRO_ASSETS_URL ); ?>images/shape/shape-1.svg" alt="Shape Image">
				</div>

				<div class="bdt-shape-2 rotateme">
					<img src="<?php echo esc_url( BDTPS_PRO_ASSETS_URL ); ?>images/shape/shape-2.svg" alt="Shape Image">
				</div>

				<div class="bdt-shape-3">
					<img src="<?php echo esc_url( BDTPS_PRO_ASSETS_URL ); ?>images/shape/shape-3.svg" alt="Shape Image">
				</div>

				<div class="bdt-shape-4">
					<img src="<?php echo esc_url( BDTPS_PRO_ASSETS_URL ); ?>images/shape/shape-4.svg" alt="Shape Image">
				</div>

				<div class="bdt-shape-5">
					<img src="<?php echo esc_url( BDTPS_PRO_ASSETS_URL ); ?>images/shape/shape-5.svg" alt="Shape Image">
				</div>

				<div class="bdt-shape-6">
					<img src="<?php echo esc_url( BDTPS_PRO_ASSETS_URL ); ?>images/shape/shape-5.svg" alt="Shape Image">
				</div>
			</div>


		</div>
		<?php
	}

	private $_default_countdown_labels;

	private function _init_default_countdown_labels() {
		$this->_default_countdown_labels = [ 
			'label_months'  => esc_html__( 'Months', 'bdthemes-prime-slider' ),
			'label_weeks'   => esc_html__( 'Weeks', 'bdthemes-prime-slider' ),
			'label_days'    => esc_html__( 'Days', 'bdthemes-prime-slider' ),
			'label_hours'   => esc_html__( 'Hours', 'bdthemes-prime-slider' ),
			'label_minutes' => esc_html__( 'Minutes', 'bdthemes-prime-slider' ),
			'label_seconds' => esc_html__( 'Seconds', 'bdthemes-prime-slider' ),
		];
	}

	public function get_default_countdown_labels() {
		if ( ! $this->_default_countdown_labels ) {
			$this->_init_default_countdown_labels();
		}

		return $this->_default_countdown_labels;
	}

	private function render_countdown_item( $settings, $label, $part_class ) {
		$string = '<div class="bdt-countdown-item-wrapper">';
		$string .= '<div class="bdt-countdown-item">';
		$string .= '<span class="bdt-countdown-number ' . $part_class . ' bdt-text-' . esc_attr( $this->get_settings( 'alignment' ) ) . '"></span>';

		if ( $settings['show_labels'] ) {
			$default_labels = $this->get_default_countdown_labels();
			$label          = ( $settings['custom_labels'] ) ? $settings[ $label ] : $default_labels[ $label ];
			$string .= ' <span class="bdt-countdown-label bdt-text-' . esc_attr( $this->get_settings( 'alignment' ) ) . '">' . $label . '</span>';
		}
		$string .= '</div>';
		$string .= '</div>';

		return $string;
	}

	public function get_strftime( $settings ) {
		$string = '';
		if ( $settings['show_days'] ) {
			$string .= $this->render_countdown_item( $settings, 'label_days', 'bdt-countdown-days' );
		}
		if ( $settings['show_hours'] ) {
			$string .= $this->render_countdown_item( $settings, 'label_hours', 'bdt-countdown-hours' );
		}
		if ( $settings['show_minutes'] ) {
			$string .= $this->render_countdown_item( $settings, 'label_minutes', 'bdt-countdown-minutes' );
		}
		if ( $settings['show_seconds'] ) {
			$string .= $this->render_countdown_item( $settings, 'label_seconds', 'bdt-countdown-seconds' );
		}

		return $string;
	}

	public function render_event_countdown() {
		$settings = $this->get_settings_for_display();

		$event_date = tribe_get_start_date( $event = null, false, 'Y-m-d H:i' );

		$due_date = $event_date;
		$string   = $this->get_strftime( $settings );

		$with_gmt_time = date( 'Y-m-d H:i', strtotime( $due_date ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) );

		try {
			$datetime = new \DateTime( $with_gmt_time );
		} catch (\Exception $e) {

		}
		$final_time = $datetime->format( 'c' );

		$this->add_render_attribute( 'countdown', 'class', 'bdt-grid', true );
		$this->add_render_attribute( 'countdown', 'bdt-countdown', 'date: ' . $final_time, true );

		?>
		<div class="bdt-countdown-wrapper">

			<div <?php $this->print_render_attribute_string( 'countdown' ); ?>>

				<?php echo wp_kses_post( $string ); ?>

			</div>
		</div>
		<?php
	}
}
