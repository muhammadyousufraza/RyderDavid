<?php

use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;

// Arrows Icons Creative Carousel
function get_arrows_icons_creative_carousel($controls)
{
  $controls->add_control(
    'icon_scroll_right',
    [
      'label'       => __('Choose Right Arrow Icon', 'responsive-tabs-for-elementor'),
      'type'        => Controls_Manager::ICONS,
      'default'     => [
        'value'   => 'fas fa-chevron-right',
        'library' => 'fa-solid',
      ],
      'recommended' => [
        'fa-solid' => [
          'arrow-right',
          'caret-right',
          'angle-right',
        ],
      ],
      'condition'   => [
        'creative_carousel_templates' => '',
      ],
    ]
  );
  $controls->add_control(
    'icon_scroll_left',
    [
      'label'       => __('Choose Left Arrow Icon', 'responsive-tabs-for-elementor'),
      'type'        => Controls_Manager::ICONS,
      'default'     => [
        'value'   => 'fas fa-chevron-left',
        'library' => 'fa-solid',
      ],
      'recommended' => [
        'fa-solid' => [
          'arrow-left',
          'caret-left',
          'angle-left',
        ],
      ],
      'condition'   => [
        'creative_carousel_templates' => '',
      ],
    ]
  );
}

// Repeater Creative Carousel
function get_repeater_creative_carousel($controls, $repeater, $default_item)
{
  $repeater->add_control(
    'slide_image',
    [
      'label'   => __('Choose Image', 'testimonials-carousel-elementor'),
      'type'    => Controls_Manager::MEDIA,
      'default' => [
        'url' => Utils::get_placeholder_image_src(),
      ],
      'ai'      => [
        'active' => false,
      ],
    ]
  );

  $repeater->add_control(
    'slide_title_enable',
    [
      'label'        => __('Title', 'testimonials-carousel-elementor'),
      'type'         => Controls_Manager::SWITCHER,
      'label_on'     => __('Show', 'testimonials-carousel-elementor'),
      'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
      'return_value' => 'yes',
      'default'      => 'yes',
      'separator'    => 'before',
    ]
  );

  $repeater->add_control(
    'slide_title',
    [
      'label'              => __('Title', 'testimonials-carousel-elementor'),
      'type'               => Controls_Manager::WYSIWYG,
      'default'            => __('<h2>Title</h2>', 'testimonials-carousel-elementor'),
      'label_block'        => true,
      'frontend_available' => true,
      'dynamic'            => [
        'active' => true,
      ],
      'ai'                 => [
        'active' => false,
      ],
      'condition'          => [
        'slide_title_enable' => 'yes',
      ],
    ]
  );

  $repeater->add_control(
    'slide_description',
    [
      'label'              => __('Description', 'testimonials-carousel-elementor'),
      'type'               => Controls_Manager::WYSIWYG,
      'default'            => __('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'testimonials-carousel-elementor'),
      'frontend_available' => true,
      'dynamic'            => [
        'active' => true,
      ],
      'ai'                 => [
        'active' => false,
      ],
    ]
  );

  $controls->add_control(
    'slide',
    [
      'label'              => __('Repeater Slide', 'testimonials-carousel-elementor'),
      'type'               => Controls_Manager::REPEATER,
      'fields'             => $repeater->get_controls(),
      'title_field'        => 'Slide',
      'frontend_available' => true,
      'default'            => [$default_item, $default_item, $default_item],
      'condition'          => [
        'creative_carousel_templates' => '',
      ],
    ]
  );
}

// General Styles Creative Carousel
function get_general_style_creative_carousel($controls)
{
  $controls->add_group_control(
    Group_Control_Background::get_type(),
    [
      'name'      => 'background_creative',
      'types'     => ['classic', 'gradient'],
      'selector'  => '{{WRAPPER}} .creative',
      'ai'        => [
        'active' => false,
      ],
      'condition' => [
        'creative_carousel_templates' => '',
      ],
    ]
  );
}

// Images Styles Creative Carousel
function get_images_style_creative_carousel($controls)
{
  $controls->add_group_control(
    Group_Control_Border::get_type(),
    [
      'name'      => 'slider_border_images',
      'selector'  => '{{WRAPPER}} .mySwiperCreative .swiper-slide img',
      'condition' => [
        'creative_carousel_templates' => '',
      ],
    ]
  );

  $controls->add_responsive_control(
    'slider_border_radius_images',
    [
      'label'      => esc_html__('Border Radius Images', 'testimonials-carousel-elementor'),
      'type'       => Controls_Manager::DIMENSIONS,
      'size_units' => ['px', '%', 'em', 'rem', 'custom'],
      'selectors'  => [
        '{{WRAPPER}} .mySwiperCreative .swiper-slide'     => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        '{{WRAPPER}} .mySwiperCreative .swiper-slide img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
      ],
      'condition'  => [
        'creative_carousel_templates' => '',
      ],
    ]
  );
}

// Content Styles Creative Carousel
function get_content_style_creative_carousel($controls)
{
  $controls->add_control(
    'creative_content_enable',
    [
      'label'        => __('Content', 'testimonials-carousel-elementor'),
      'type'         => Controls_Manager::SWITCHER,
      'label_on'     => __('Show', 'testimonials-carousel-elementor'),
      'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
      'return_value' => 'yes',
      'default'      => 'yes',
      'condition'    => [
        'creative_carousel_templates' => '',
      ],
    ]
  );

  $controls->add_responsive_control(
    'content_padding',
    [
      'label'      => esc_html__('Padding', 'testimonials-carousel-elementor'),
      'type'       => Controls_Manager::DIMENSIONS,
      'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
      'selectors'  => [
        '{{WRAPPER}} .creative .creative__wrapper-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
      ],
      'separator'  => 'before',
      'condition'  => [
        'creative_content_enable'     => 'yes',
        'creative_carousel_templates' => '',
      ],
    ]
  );

  $controls->add_group_control(
    Group_Control_Background::get_type(),
    [
      'name'      => 'background_content',
      'types'     => ['classic', 'gradient'],
      'selector'  => '{{WRAPPER}} .creative .creative__wrapper-content',
      'ai'        => [
        'active' => false,
      ],
      'condition' => [
        'creative_content_enable'     => 'yes',
        'creative_carousel_templates' => '',
      ],
    ]
  );

  $controls->add_responsive_control(
    'slider_creative_width',
    [
      'label'      => esc_html__('Width', 'testimonials-carousel-elementor'),
      'type'       => Controls_Manager::SLIDER,
      'default'    => [
        'unit' => '%',
      ],
      'size_units' => ['px', 'em', 'rem', '%'],
      'selectors'  => [
        '{{WRAPPER}} .creative .creative__wrapper-content' => 'width: {{SIZE}}{{UNIT}};',
      ],
      'condition'  => [
        'creative_content_enable'     => 'yes',
        'creative_carousel_templates' => '',
      ],
    ]
  );

  $controls->add_responsive_control(
    'slider_creative_gap',
    [
      'label'      => esc_html__('Gap', 'testimonials-carousel-elementor'),
      'type'       => Controls_Manager::SLIDER,
      'default'    => [
        'unit' => 'px',
      ],
      'size_units' => ['px'],
      'selectors'  => [
        '{{WRAPPER}} .creative' => 'gap: {{SIZE}}{{UNIT}};',
      ],
      'condition'  => [
        'creative_content_enable'     => 'yes',
        'creative_carousel_templates' => '',
      ],
    ]
  );

  $controls->add_control(
    'slider_name_color',
    [
      'label'     => esc_html__('Title Color', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .creative .creative__wrapper-content .creative__slide-title *' => 'color: {{VALUE}};',
      ],
      'separator' => 'before',
      'condition' => [
        'creative_content_enable'     => 'yes',
        'creative_carousel_templates' => '',
      ],
    ]
  );

  $controls->add_group_control(
    Group_Control_Typography::get_type(),
    [
      'name'      => 'slider_name_typography',
      'label'     => esc_html__('Title Typography', 'testimonials-carousel-elementor'),
      'selector'  => '{{WRAPPER}} .creative .creative__wrapper-content .creative__slide-title *',
      'condition' => [
        'creative_content_enable'     => 'yes',
        'creative_carousel_templates' => '',
      ],
    ]
  );

  $controls->add_responsive_control(
    'slider_name_align',
    [
      'label'     => esc_html__('Alignment Title', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::CHOOSE,
      'options'   => [
        'left'   => [
          'title' => esc_html__('Left', 'testimonials-carousel-elementor'),
          'icon'  => 'eicon-text-align-left',
        ],
        'center' => [
          'title' => esc_html__('Center', 'testimonials-carousel-elementor'),
          'icon'  => 'eicon-text-align-center',
        ],
        'right'  => [
          'title' => esc_html__('Right', 'testimonials-carousel-elementor'),
          'icon'  => 'eicon-text-align-right',
        ],
      ],
      'default'   => 'left',
      'selectors' => [
        '{{WRAPPER}} .creative .creative__wrapper-content .creative__slide-title *' => 'text-align: {{VALUE}}',
      ],
      'condition' => [
        'creative_content_enable'     => 'yes',
        'creative_carousel_templates' => '',
      ],
    ]
  );

  $controls->add_control(
    'slider_content_color',
    [
      'label'     => esc_html__('Description Color', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .creative .creative__wrapper-content .creative__slide-text *' => 'color: {{VALUE}};',
      ],
      'separator' => 'before',
      'condition' => [
        'creative_content_enable'     => 'yes',
        'creative_carousel_templates' => '',
      ],
    ]
  );

  $controls->add_group_control(
    Group_Control_Typography::get_type(),
    [
      'name'      => 'slider_content_typography',
      'label'     => esc_html__('Description Typography', 'testimonials-carousel-elementor'),
      'selector'  => '{{WRAPPER}} .creative .creative__wrapper-content .creative__slide-text *',
      'condition' => [
        'creative_content_enable'     => 'yes',
        'creative_carousel_templates' => '',
      ],
    ]
  );

  $controls->add_responsive_control(
    'slider_content_align',
    [
      'label'     => esc_html__('Alignment Description', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::CHOOSE,
      'options'   => [
        'left'    => [
          'title' => esc_html__('Left', 'testimonials-carousel-elementor'),
          'icon'  => 'eicon-text-align-left',
        ],
        'center'  => [
          'title' => esc_html__('Center', 'testimonials-carousel-elementor'),
          'icon'  => 'eicon-text-align-center',
        ],
        'right'   => [
          'title' => esc_html__('Right', 'testimonials-carousel-elementor'),
          'icon'  => 'eicon-text-align-right',
        ],
        'justify' => [
          'title' => esc_html__('Justify', 'testimonials-carousel-elementor'),
          'icon'  => 'eicon-text-align-justify',
        ],
      ],
      'default'   => 'left',
      'selectors' => [
        '{{WRAPPER}} .creative .creative__wrapper-content .creative__slide-text *' => 'text-align: {{VALUE}}',
      ],
      'condition' => [
        'creative_content_enable'     => 'yes',
        'creative_carousel_templates' => '',
      ],
    ]
  );
}

// Arrows Styles Creative Carousel
function get_arrows_style_creative_carousel($controls)
{
  $controls->add_control(
    'arrows_size',
    [
      'label'     => esc_html__('Arrows Size', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::SLIDER,
      'default'   => [
        'unit' => 'px',
      ],
      'selectors' => [
        '{{WRAPPER}} .creative .swiper-button-prev svg, {{WRAPPER}} .creative .swiper-button-next svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
        '{{WRAPPER}} .creative .swiper-button-prev i, {{WRAPPER}} .creative .swiper-button-next i'     => 'font-size: {{SIZE}}{{UNIT}};',
      ],
      'condition' => [
        'creative_carousel_templates' => '',
      ],
    ]
  );

  $controls->add_control(
    'arrows_color',
    [
      'label'     => esc_html__('Arrows Color', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .creative .swiper-button-prev svg path, {{WRAPPER}} .creative .swiper-button-next svg path' => 'fill: {{VALUE}};',
        '{{WRAPPER}} .creative .swiper-button-prev i, {{WRAPPER}} .creative .swiper-button-next i'               => 'color: {{VALUE}};',
      ],
      'condition' => [
        'creative_carousel_templates' => '',
      ],
    ]
  );

  $controls->add_responsive_control(
    'creative_arrows_position',
    [
      'label'     => esc_html__('Arrows Position', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::CHOOSE,
      'options'   => [
        'top'    => [
          'title' => esc_html__('Top', 'testimonials-carousel-elementor'),
          'icon'  => 'eicon-v-align-top',
        ],
        'bottom' => [
          'title' => esc_html__('Bottom', 'testimonials-carousel-elementor'),
          'icon'  => 'eicon-v-align-bottom',
        ],
      ],
      'default'   => 'bottom',
      'condition' => [
        'creative_carousel_templates' => '',
      ],
    ]
  );

  $controls->add_responsive_control(
    'arrows_top_position',
    [
      'label'     => esc_html__('Position Top', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::SLIDER,
      'default'   => [
        'unit' => 'px',
        'size' => 20,
      ],
      'selectors' => [
        '{{WRAPPER}} .creative .swiper-button-prev, {{WRAPPER}} .creative .swiper-button-next' => 'top: {{SIZE}}{{UNIT}}; bottom: unset;',
      ],
      'condition' => [
        'creative_arrows_position'    => 'top',
        'creative_carousel_templates' => '',
      ],
    ]
  );

  $controls->add_responsive_control(
    'arrows_bottom_position',
    [
      'label'     => esc_html__('Position Bottom', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::SLIDER,
      'default'   => [
        'unit' => 'px',
      ],
      'selectors' => [
        '{{WRAPPER}} .creative .swiper-button-prev, {{WRAPPER}} .creative .swiper-button-next' => 'bottom: {{SIZE}}{{UNIT}}; top: unset;',
      ],
      'condition' => [
        'creative_arrows_position'    => 'bottom',
        'creative_carousel_templates' => '',
      ],
    ]
  );

  $controls->add_responsive_control(
    'arrows_prev_position',
    [
      'label'     => esc_html__('Arrow Prev', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::SLIDER,
      'default'   => [
        'unit' => 'px',
      ],
      'selectors' => [
        '{{WRAPPER}} .creative .swiper-button-prev' => 'right: {{SIZE}}{{UNIT}}; left: unset;',
      ],
      'condition' => [
        'creative_carousel_templates' => '',
      ],
    ]
  );

  $controls->add_responsive_control(
    'arrows_next_position',
    [
      'label'     => esc_html__('Arrow Next', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::SLIDER,
      'default'   => [
        'unit' => 'px',
      ],
      'selectors' => [
        '{{WRAPPER}} .creative .swiper-button-next' => 'right: {{SIZE}}{{UNIT}}; left: unset;',
      ],
      'condition' => [
        'creative_carousel_templates' => '',
      ],
    ]
  );
}

// Dots Styles Creative Carousel
function get_dots_style_creative_carousel($controls)
{
  $controls->add_group_control(
    Group_Control_Typography::get_type(),
    [
      'name'      => 'dots_size',
      'label'     => esc_html__('Counter Size', 'testimonials-carousel-elementor'),
      'selector'  => '{{WRAPPER}} .creative .swiper-pagination.swiper-pagination-fraction',
      'condition' => [
        'creative_carousel_templates' => '',
      ],
    ]
  );

  $controls->add_control(
    'dots_color',
    [
      'label'     => esc_html__('Counter Color', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .creative .swiper-pagination.swiper-pagination-fraction' => 'color: {{VALUE}};',
      ],
      'condition' => [
        'creative_carousel_templates' => '',
      ],
    ]
  );

  $controls->add_responsive_control(
    'dots_top_position',
    [
      'label'     => esc_html__('Position Top', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::SLIDER,
      'selectors' => [
        '{{WRAPPER}} .creative .swiper-pagination.swiper-pagination-fraction' => 'top: {{SIZE}}{{UNIT}};',
      ],
      'condition' => [
        'creative_carousel_templates' => '',
      ],
    ]
  );

  $controls->add_responsive_control(
    'dots_bottom_position',
    [
      'label'     => esc_html__('Position Bottom', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::SLIDER,
      'selectors' => [
        '{{WRAPPER}} .creative .swiper-pagination.swiper-pagination-fraction' => 'bottom: {{SIZE}}{{UNIT}};',
      ],
      'condition' => [
        'creative_carousel_templates' => '',
      ],
    ]
  );

  $controls->add_responsive_control(
    'dots_right_position',
    [
      'label'     => esc_html__('Position Right', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::SLIDER,
      'selectors' => [
        '{{WRAPPER}} .creative .swiper-pagination.swiper-pagination-fraction' => 'right: {{SIZE}}{{UNIT}};',
      ],
      'condition' => [
        'creative_carousel_templates' => '',
      ],
    ]
  );

  $controls->add_responsive_control(
    'dots_left_position',
    [
      'label'     => esc_html__('Position Left', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::SLIDER,
      'selectors' => [
        '{{WRAPPER}} .creative .swiper-pagination.swiper-pagination-fraction' => 'left: {{SIZE}}{{UNIT}}; right: unset;',
      ],
      'condition' => [
        'creative_carousel_templates' => '',
      ],
    ]
  );
}
