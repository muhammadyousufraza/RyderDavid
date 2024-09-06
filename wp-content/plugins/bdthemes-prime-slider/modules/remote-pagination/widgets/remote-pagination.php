<?php

namespace PrimeSliderPro\Modules\RemotePagination\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Exit if accessed directly

class Remote_Pagination extends Widget_Base {

	public function get_name() {
		return 'prime-slider-remote-pagination';
	}

	public function get_title() {
		return BDTPS . esc_html__( 'Remote Pagination', 'bdthemes-prime-slider' );
	}

	public function get_icon() {
		return 'bdt-widget-icon  ps-wi-remote-pagination';
	}

	public function get_categories() {
		return [ 'prime-slider-pro' ];
	}

	public function get_keywords() {
		return [ 'remote', 'pagination', 'arrows', 'paginations' ];
	}

	public function get_style_depends() {
		return [ 
			'ps-remote-pagination'
		];
	}

	public function get_script_depends() {
		return [ 'ps-remote-pagination' ];
	}

	public function get_custom_help_url() {
		return 'https://youtu.be/Bp-6mMJIE74';
	}


	protected function register_controls() {
		$this->start_controls_section(
			'section_remote_pagination',
			[ 
				'label' => esc_html__( 'Remote Pagination', 'bdthemes-prime-slider' ),
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
			'loop_status',
			[ 
				'label'       => esc_html__( 'Slider / Carousel Loop Status', 'bdthemes-prime-slider' ),
				'description' => esc_html__( 'If the connected Carousel/Slider Loop feature is off then please deactivate this option.', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_remote_pagination_item',
			[ 
				'label' => esc_html__( 'Items', 'bdthemes-prime-slider' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'pagination_number',
			[ 
				'label'       => __( 'Bullet Number', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 
					'active' => true,
				],
				'default'     => __( 'Adam Smith', 'bdthemes-prime-slider' ),
				'placeholder' => __( 'Enter reviewer name', 'bdthemes-prime-slider' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'pagination_list',
			[ 
				'label'       => '',
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [ 
					[ 
						'pagination_number' => 1,
					],
					[ 
						'pagination_number' => 2,
					],
					[ 
						'pagination_number' => 3,
					],
					[ 
						'pagination_number' => 4,
					],
					[ 
						'pagination_number' => 5,
					],
				],
				'title_field' => '{{{ pagination_number }}}',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[ 
				'name'    => 'thumbnail_size',
				'default' => 'medium',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_pagination',
			[ 
				'label' => esc_html__( 'Remote Pagination', 'bdthemes-prime-slider' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'pagination_align',
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
					'{{WRAPPER}} .bdt-pagination-wrapper' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'pagination_spacing',
			[ 
				'label'      => esc_html__( 'Spacing', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 
					'px' => [ 
						'min' => 0,
						'max' => 100,
					],
					'em' => [ 
						'min'  => 0,
						'max'  => 5,
						'step' => .1,
					],
				],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-pagination-wrapper' => 'grid-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[ 
				'name'     => 'pagination_typography',
				'selector' => '{{WRAPPER}} .bdt-item',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[ 
				'name'     => 'pagination_border',
				'selector' => '{{WRAPPER}} .bdt-item'
			]
		);

		$this->add_responsive_control(
			'pagination_radius',
			[ 
				'label'      => esc_html__( 'Border Radius', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'style_tabs_img'
		);

		$this->start_controls_tab(
			'style_normal_tab',
			[ 
				'label' => esc_html__( 'Normal', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'pagination_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-item' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'pagination_background',
				'selector' => '{{WRAPPER}} .bdt-item',
			]
		);

		$this->add_responsive_control(
			'pagination_height',
			[ 
				'label'      => esc_html__( 'Height', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 
					'px' => [ 
						'min' => 50,
						'max' => 100,
					],
					'em' => [ 
						'min'  => 0,
						'max'  => 5,
						'step' => .1,
					],
				],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-item'               => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .bdt-pagination-wrapper' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'pagination_width',
			[ 
				'label'      => esc_html__( 'Width', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 
					'px' => [ 
						'min' => 50,
						'max' => 100,
					],
					'em' => [ 
						'min'  => 0,
						'max'  => 5,
						'step' => .1,
					],
				],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-item' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'pagination_shadow',
				'selector' => '{{WRAPPER}} .bdt-item'
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'style_active_tab',
			[ 
				'label' => esc_html__( 'Active', 'bdthemes-prime-slider' ),
			]
		);

		$this->add_control(
			'active_pagination_color',
			[ 
				'label'     => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .bdt-item.bdt-active' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'     => 'active_pagination_background',
				'selector' => '{{WRAPPER}} .bdt-item.bdt-active',
			]
		);

		$this->add_responsive_control(
			'active_pagination_height',
			[ 
				'label'      => esc_html__( 'Height', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 
					'px' => [ 
						'min' => 50,
						'max' => 100,
					],
					'em' => [ 
						'min'  => 0,
						'max'  => 5,
						'step' => .1,
					],
				],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-item.bdt-active' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'active_pagination_width',
			[ 
				'label'      => esc_html__( 'Width', 'bdthemes-prime-slider' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range'      => [ 
					'px' => [ 
						'min' => 50,
						'max' => 100,
					],
					'em' => [ 
						'min'  => 0,
						'max'  => 5,
						'step' => .1,
					],
				],
				'selectors'  => [ 
					'{{WRAPPER}} .bdt-item.bdt-active' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'active_pagination_border_color',
			[ 
				'label'     => esc_html__( 'Border Color', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [ 
					'pagination_border_border!' => '',
				],
				'selectors' => [ 
					'{{WRAPPER}} .bdt-item.bdt-active' => 'border-color: {{VALUE}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[ 
				'name'     => 'active_pagination_shadow',
				'selector' => '{{WRAPPER}} .bdt-item.bdt-active'
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$id       = 'bdt-remote-pagination-' . $this->get_id();

		$this->add_render_attribute( 'remote', [ 
			'class'         => 'bdt-remote-pagination',
			'id'            => $id,
			'data-settings' => [ 
				wp_json_encode( array_filter( [ 
					'id'         => '#' . $id,
					'remoteId'   => ! empty( $settings['remote_id'] ) ? '#' . $settings['remote_id'] : false,
					'loopStatus' => 'yes' == $settings['loop_status'] ? true : false,
				] ) )
			]
		] );

		?>
		<div <?php echo $this->get_render_attribute_string( 'remote' ); ?>>
			<div class="bdt-pagination-wrapper">
				<?php
				foreach ( $settings['pagination_list'] as $index => $item ) :
					?>
					<a href="javascript:void(0);" class="bdt-item" data-index="<?php echo esc_attr( $index ); ?>">
						<div class="bdt-pagination">
							<?php echo esc_html( $item['pagination_number'] ); ?>
						</div>
					</a>
					<?php
				endforeach;
				?>
			</div>
		</div>

		<div id="<?php echo esc_attr( $id ) . '-notice' ?>" class="bdt-alert-danger bdt-hidden" bdt-alert>
			<a class="bdt-alert-close" bdt-close></a>
			<p>
				<?php
				echo esc_html__( 'Sorry, your ID is maybe not correct. And please make sure that your selected element is developed with Swiper.', 'bdthemes-prime-slider' );
				?>
			</p>
		</div>

		<?php
	}
}
