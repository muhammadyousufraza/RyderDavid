<?php

namespace PrimeSliderPro\Modules\RemoteArrows\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Exit if accessed directly

class Remote_Arrows extends Widget_Base {

	public function get_name() {
		return 'prime-slider-remote-arrows';
	}

	public function get_title() {
		return BDTPS . esc_html__( 'Remote Arrows', 'bdthemes-prime-slider' );
	}

	public function get_icon() {
		return 'bdt-widget-icon  ps-wi-remote-arrows';
	}

	public function get_categories() {
		return [ 'prime-slider-pro' ];
	}

	public function get_keywords() {
		return [ 'remote', 'arrows', 'navigation' ];
	}

	public function get_style_depends() {
		return [ 
			'elementor-icons-fa-solid',
			'elementor-icons-fa-brands',
			'prime-slider-font',
			'ps-remote-arrows'
		];
	}

	public function get_script_depends() {
		return [ 'ps-remote-arrows' ];
	}



	public function get_custom_help_url() {
		return 'https://youtu.be/Lm_B9VaWDXA';
	}


	protected function register_controls() {
		$this->start_controls_section(
			'section_remote_arrow',
			[ 
				'label' => esc_html__( 'Remote Arrows', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'remote_id',
			[ 
				'label'       => esc_html__( 'Remote Carousel ID', 'bdthemes-prime-slider' ),
				'description' => esc_html__( 'Unique ID of Carousel / Slider. The Elements must be developed with Swiper. No need to add a hash(#) before ID. Note: If you will insert both Elements in the same section, then at first system will try to detect the Element Automatically.', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$this->add_control(
			'nav_arrows_icon',
			[ 
				'label'   => esc_html__( 'Arrows Icon', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '0',
				'options' => [ 
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
					'custom'   => esc_html__( 'Custom', 'bdthemes-prime-slider' ),
				],
			]
		);

		$this->start_controls_tabs(
			'content_tabs'
		);

		$this->start_controls_tab(
			'content_next_tab',
			[ 
				'label' => esc_html__( 'Next', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'next_text',
			[ 
				'label'   => esc_html__( 'Text', 'bdthemes-prime-slider' ),
				'default' => 'Next',
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'next_icon',
			[ 
				'label'     => esc_html__( 'Icon', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [ 
					'value'   => 'fas fa-angle-right',
					'library' => 'fa-solid',
				],
				'condition' => [ 
					'nav_arrows_icon' => [ 'custom' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'content_previous_tab',
			[ 
				'label' => esc_html__( 'Previous', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'prev_text',
			[ 
				'label'   => esc_html__( 'Text', 'bdthemes-prime-slider' ),
				'default' => 'Prev',
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'prev_icon',
			[ 
				'label'     => esc_html__( 'Icon', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::ICONS,
				'default'   => [ 
					'value'   => 'fas fa-angle-left',
					'library' => 'fa-solid',
				],
				'condition' => [ 
					'nav_arrows_icon' => [ 'custom' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_arrows',
			[ 
				'label' => esc_html__( 'Remote Arrows', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'arrows_align',
			[ 
				'label'     => esc_html__( 'Alignment', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [ 
					'flex-start' => [ 
						'title' => esc_html__( 'Left', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'     => [ 
						'title' => esc_html__( 'Center', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-text-align-center',
					],
					'flex-end'   => [ 
						'title' => esc_html__( 'Right', 'bdthemes-prime-slider' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-remote-arrows' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'arrows_typography',
				'selector' => '{{WRAPPER}} .bdt-prev, {{WRAPPER}} .bdt-next',
			]
		);

		$this->add_responsive_control(
			'arrows_space',
			[ 
				'label'     => esc_html__( 'Arrows Space Between', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [ 
					'size' => 10,
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-remote-arrows' => 'grid-gap: {{SIZE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'icon_text_space',
			[ 
				'label'     => esc_html__( 'Icon/Text Space Between', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [ 
					'size' => 10,
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-remote-arrows .bdt-button' => 'grid-gap: {{SIZE}}px;',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_arrows_arrows_style' );

		$this->start_controls_tab(
			'tabs_nav_arrows_normal',
			[ 
				'label' => esc_html__( 'Normal', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'arrows_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prev, {{WRAPPER}} .bdt-next'         => 'color: {{VALUE}}',
					'{{WRAPPER}} .bdt-prev svg, {{WRAPPER}} .bdt-next svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'arrows_background',
				'selector' => '{{WRAPPER}} .bdt-prev, {{WRAPPER}} .bdt-next',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'     => 'nav_arrows_border',
				'selector' => '{{WRAPPER}} .bdt-prev, {{WRAPPER}} .bdt-next',
			]
		);

		$this->add_responsive_control(
			'border_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-prev, {{WRAPPER}} .bdt-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .bdt-prev, {{WRAPPER}} .bdt-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'arrows_box_shadow',
				'selector' => '{{WRAPPER}} .bdt-prev, {{WRAPPER}} .bdt-next',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tabs_nav_arrows_hover',
			[ 
				'label' => esc_html__( 'Hover', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'arrows_hover_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prev:hover, {{WRAPPER}} .bdt-next:hover'         => 'color: {{VALUE}}',
					'{{WRAPPER}} .bdt-prev:hover svg, {{WRAPPER}} .bdt-next:hover svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'arrows_hover_background',
				'selector' => '{{WRAPPER}} .bdt-prev:hover, {{WRAPPER}} .bdt-next:hover',
			]
		);

		$this->add_control(
			'nav_arrows_hover_border_color',
			[ 
				'label'     => esc_html__( 'Border Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-prev:hover, {{WRAPPER}} .bdt-next:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [ 
					'nav_arrows_border_border!' => ''
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'arrows_hover_box_shadow',
				'selector' => '{{WRAPPER}} .bdt-prev:hover, {{WRAPPER}} .bdt-next:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$id       = 'bdt-remote-arrows-' . $this->get_id();

		$this->add_render_attribute( 'remote', [ 
			'class'         => 'bdt-remote-arrows',
			'id'            => $id,
			'data-settings' => [ 
				wp_json_encode( array_filter( [ 
					'id'       => '#' . $id,
					'remoteId' => ! empty( $settings['remote_id'] ) ? '#' . $settings['remote_id'] : false,
				] ) )
			]
		] );


		?>
		<div <?php echo $this->get_render_attribute_string( 'remote' ); ?>>
			<a class="bdt-prev bdt-button bdt-button-link" href="javascript:void(0);">
				<?php
				if ( $settings['nav_arrows_icon'] == 'custom' && ! empty( $settings['prev_icon']['value'] ) ) :
					Icons_Manager::render_icon( $settings['prev_icon'], [ 'aria-hidden' => 'true' ] );
				endif;

				if ( $settings['nav_arrows_icon'] != 'custom' ) {
					printf( '<i class="ps-wi-arrow-left-%s" aria-hidden="true"></i>', esc_html( $settings['nav_arrows_icon']) );
				}

				if ( ! empty( $settings['prev_text'] ) ) {
					printf( '<span class="bdt-arrows-text">%s</span>', esc_html( $settings['prev_text'] ) );
				}

				?>

			</a>
			<a class="bdt-next bdt-button bdt-button-link" href="javascript:void(0);">
				<?php
				if ( ! empty( $settings['next_text'] ) ) {
					printf( '<span class="bdt-arrows-text">%s</span>', esc_html( $settings['next_text'] ) );
				}

				if ( $settings['nav_arrows_icon'] == 'custom' && ! empty( $settings['next_icon']['value'] ) ) :
					Icons_Manager::render_icon( $settings['next_icon'], [ 'aria-hidden' => 'true' ] );
				endif;

				if ( $settings['nav_arrows_icon'] != 'custom' ) {
					printf( '<i class="ps-wi-arrow-right-%s" aria-hidden="true"></i>', esc_html( $settings['nav_arrows_icon'] ) );
				}

				?>
			</a>
		</div>

		<div id="<?php echo esc_attr( $id ) . '-notice' ?>" class="bdt-alert-danger bdt-hidden" bdt-alert>
			<a class="bdt-alert-close" bdt-close></a>
			<p>
				<?php
				echo esc_html__( 'Sorry, your ID is maybe not correct (If you did not place any ID that means auto-detect does not work.). And please make sure that your selected element is developed with Swiper.', 'bdthemes-prime-slider' );
				?>
			</p>
		</div>

		<?php
	}
}
