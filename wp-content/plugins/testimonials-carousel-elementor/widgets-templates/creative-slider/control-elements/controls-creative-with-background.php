<?php

use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;

// Arrows Icons Creative With Background
function get_arrows_icons_creative_with_background($controls)
{
  $controls->add_control(
    'icon_arrow_right',
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
        'creative_carousel_templates' => '1',
      ],
    ]
  );
  $controls->add_control(
    'icon_arrow_left',
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
        'creative_carousel_templates' => '1',
      ],
    ]
  );
}

// Repeater Creative With Background
function get_repeater_creative_with_background($controls, $repeater, $default_item)
{
  $repeater->add_control(
    'creative_with_background_image',
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
    'creative_with_background_title_enable',
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
    'creative_with_background_title',
    [
      'label'              => __('Title', 'testimonials-carousel-elementor'),
      'type'               => Controls_Manager::WYSIWYG,
      'default'            => __('<h2>SPECIAL OFFER</h2>', 'testimonials-carousel-elementor'),
      'label_block'        => true,
      'frontend_available' => true,
      'dynamic'            => [
        'active' => true,
      ],
      'ai'                 => [
        'active' => false,
      ],
      'condition'          => [
        'creative_with_background_title_enable' => 'yes',
      ],
    ]
  );

  $repeater->add_control(
    'creative_with_background_subtitle_enable',
    [
      'label'        => __('Subtitle', 'testimonials-carousel-elementor'),
      'type'         => Controls_Manager::SWITCHER,
      'label_on'     => __('Show', 'testimonials-carousel-elementor'),
      'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
      'return_value' => 'yes',
      'default'      => 'yes',
      'separator'    => 'before',
    ]
  );

  $repeater->add_control(
    'creative_with_background_subtitle',
    [
      'label'              => __('Subtitle', 'testimonials-carousel-elementor'),
      'type'               => Controls_Manager::WYSIWYG,
      'default'            => __('<h3>on mobile phones</h3>', 'testimonials-carousel-elementor'),
      'label_block'        => true,
      'frontend_available' => true,
      'dynamic'            => [
        'active' => true,
      ],
      'ai'                 => [
        'active' => false,
      ],
      'condition'          => [
        'creative_with_background_subtitle_enable' => 'yes',
      ],
    ]
  );

  $repeater->add_control(
    'creative_with_background_description',
    [
      'label'              => __('Description', 'testimonials-carousel-elementor'),
      'type'               => Controls_Manager::WYSIWYG,
      'default'            => __('<p>Upgrade your world for less! Enjoy blazing-fast processors, stunning cameras, and sleek designs with our <strong>20% discount</strong> on all mobile phones. Don`t miss out on this limited offer - <strong>ends this weekend!</strong></p>', 'testimonials-carousel-elementor'),
      'frontend_available' => true,
      'dynamic'            => [
        'active' => true,
      ],
      'ai'                 => [
        'active' => false,
      ],
      'separator'          => 'before',
    ]
  );

  $controls->add_control(
    'creative_with_background',
    [
      'label'              => __('Repeater Slide', 'testimonials-carousel-elementor'),
      'type'               => Controls_Manager::REPEATER,
      'fields'             => $repeater->get_controls(),
      'title_field'        => 'Slide',
      'frontend_available' => true,
      'default'            => [$default_item, $default_item, $default_item],
      'condition'          => [
        'creative_carousel_templates' => '1',
      ],
    ]
  );
}

// General Styles Creative With Background
function get_general_style_creative_with_background($controls)
{
  $controls->add_responsive_control(
    'creative_with_background_padding',
    [
      'label'      => esc_html__('Padding', 'testimonials-carousel-elementor'),
      'type'       => Controls_Manager::DIMENSIONS,
      'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
      'selectors'  => [
        '{{WRAPPER}} .creative-with-background.creative' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
      ],
      'condition'  => [
        'creative_with_background_content_enable' => 'yes',
        'creative_carousel_templates'             => '1',
      ],
    ]
  );

  $controls->add_control(
    'creative_with_background_image_enable',
    [
      'label'        => __('Background Image', 'testimonials-carousel-elementor'),
      'type'         => Controls_Manager::SWITCHER,
      'label_on'     => __('Show', 'testimonials-carousel-elementor'),
      'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
      'return_value' => 'yes',
      'default'      => 'yes',
      'separator'    => 'before',
      'condition'    => [
        'creative_carousel_templates' => '1',
      ],
    ]
  );

  $controls->add_control(
    'creative_with_background_image_background',
    [
      'label'     => __('Choose Image', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::MEDIA,
      'default'   => [
        'url' => plugins_url('/assets/images/creative-with-background.jpg', TESTIMONIALS_CAROUSEL_ELEMENTOR),
      ],
      'ai'        => [
        'active' => false,
      ],
      'condition' => [
        'creative_with_background_image_enable' => 'yes',
        'creative_carousel_templates'           => '1',
      ],
      'separator' => 'before',
    ]
  );

  $controls->add_group_control(
    Group_Control_Background::get_type(),
    [
      'name'      => 'background_creative_with_background',
      'types'     => ['classic', 'gradient', 'video'],
      'selector'  => '{{WRAPPER}} .creative-with-background.creative',
      'ai'        => [
        'active' => false,
      ],
      'condition' => [
        'creative_carousel_templates'           => '1',
        'creative_with_background_image_enable' => '',
      ],
      'separator' => 'before',
    ]
  );

  $controls->add_responsive_control(
    'creative_with_background_gap_content',
    [
      'label'      => esc_html__('Gap', 'testimonials-carousel-elementor'),
      'type'       => Controls_Manager::SLIDER,
      'default'    => [
        'unit' => 'px',
      ],
      'size_units' => ['px'],
      'selectors'  => [
        '{{WRAPPER}} .creative-with-background.creative .creative-with-background__wrapper' => 'gap: {{SIZE}}{{UNIT}};',
      ],
      'condition'  => [
        'creative_carousel_templates' => '1',
      ],
      'separator'  => 'before',
    ]
  );
}

// Images Styles Creative With Background
function get_images_style_creative_with_background($controls)
{
  $controls->add_responsive_control(
    'creative_with_background_width_image',
    [
      'label'      => esc_html__('Width', 'testimonials-carousel-elementor'),
      'type'       => Controls_Manager::SLIDER,
      'default'    => [
        'unit' => '%',
      ],
      'size_units' => ['px', 'em', 'rem', '%'],
      'selectors'  => [
        '{{WRAPPER}} .creative-with-background.creative .mySwiperCreative .swiper-slide img' => 'max-width: {{SIZE}}{{UNIT}};',
      ],
      'condition'  => [
        'creative_carousel_templates' => '1',
      ],
    ]
  );

  $controls->add_control(
    'creative_with_background_object_fit',
    [
      'label'              => esc_html__('Object Fit', 'testimonials-carousel-elementor'),
      'type'               => Controls_Manager::SELECT,
      'default'            => 'contain',
      'options'            => [
        ''             => esc_html__('Default', 'testimonials-carousel-elementor'),
        'none'         => esc_html__('None', 'testimonials-carousel-elementor'),
        'contain'      => esc_html__('Contain', 'testimonials-carousel-elementor'),
        'cover'        => esc_html__('Cover', 'testimonials-carousel-elementor'),
        'fill'         => esc_html__('Fill', 'testimonials-carousel-elementor'),
        'scale-down'   => esc_html__('Scale Down', 'testimonials-carousel-elementor'),
        'inherit'      => esc_html__('Inherit', 'testimonials-carousel-elementor'),
        'initial'      => esc_html__('Initial', 'testimonials-carousel-elementor'),
        'revert'       => esc_html__('Revert', 'testimonials-carousel-elementor'),
        'revert-layer' => esc_html__('Revert Layer', 'testimonials-carousel-elementor'),
        'unset'        => esc_html__('Unset', 'testimonials-carousel-elementor'),
      ],
      'frontend_available' => true,
      'selectors'          => [
        '{{WRAPPER}} .creative-with-background.creative .mySwiperCreative .swiper-slide img' => 'object-fit: {{VALUE}};',
      ],
      'condition'          => [
        'creative_carousel_templates' => '1',
      ],
    ]
  );

  $controls->add_group_control(
    Group_Control_Border::get_type(),
    [
      'name'      => 'creative_with_background_border_images',
      'selector'  => '{{WRAPPER}} .creative-with-background .mySwiperCreative .swiper-slide img',
      'condition' => [
        'creative_carousel_templates' => '1',
      ],
      'separator' => 'before',
    ]
  );

  $controls->add_responsive_control(
    'creative_with_background_border_radius_images',
    [
      'label'      => esc_html__('Border Radius Images', 'testimonials-carousel-elementor'),
      'type'       => Controls_Manager::DIMENSIONS,
      'size_units' => ['px', '%', 'em', 'rem', 'custom'],
      'selectors'  => [
        '{{WRAPPER}} .creative-with-background .mySwiperCreative .swiper-slide'     => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        '{{WRAPPER}} .creative-with-background .mySwiperCreative .swiper-slide img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
      ],
      'condition'  => [
        'creative_carousel_templates' => '1',
      ],
    ]
  );
}

// Content Styles Creative With Background
function get_content_style_creative_with_background($controls)
{
  $controls->add_control(
    'creative_with_background_content_enable',
    [
      'label'        => __('Content', 'testimonials-carousel-elementor'),
      'type'         => Controls_Manager::SWITCHER,
      'label_on'     => __('Show', 'testimonials-carousel-elementor'),
      'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
      'return_value' => 'yes',
      'default'      => 'yes',
      'condition'    => [
        'creative_carousel_templates' => '1',
      ],
    ]
  );

  $controls->add_responsive_control(
    'creative_with_background_content_padding',
    [
      'label'      => esc_html__('Padding', 'testimonials-carousel-elementor'),
      'type'       => Controls_Manager::DIMENSIONS,
      'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
      'selectors'  => [
        '{{WRAPPER}} .creative-with-background.creative .creative__wrapper-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
      ],
      'separator'  => 'before',
      'condition'  => [
        'creative_with_background_content_enable' => 'yes',
        'creative_carousel_templates'             => '1',
      ],
    ]
  );

  $controls->add_responsive_control(
    'creative_with_background_width',
    [
      'label'      => esc_html__('Width', 'testimonials-carousel-elementor'),
      'type'       => Controls_Manager::SLIDER,
      'default'    => [
        'unit' => '%',
      ],
      'size_units' => ['px', 'em', 'rem', '%'],
      'selectors'  => [
        '{{WRAPPER}} .creative-with-background.creative .creative__wrapper-content' => 'width: {{SIZE}}{{UNIT}};',
      ],
      'condition'  => [
        'creative_with_background_content_enable' => 'yes',
        'creative_carousel_templates'             => '1',
      ],
    ]
  );

  $controls->add_responsive_control(
    'creative_with_background_gap',
    [
      'label'      => esc_html__('Gap', 'testimonials-carousel-elementor'),
      'type'       => Controls_Manager::SLIDER,
      'default'    => [
        'unit' => 'px',
      ],
      'size_units' => ['px'],
      'selectors'  => [
        '{{WRAPPER}} .creative-with-background.creative .creative__slide-content' => 'gap: {{SIZE}}{{UNIT}};',
      ],
      'condition'  => [
        'creative_with_background_content_enable' => 'yes',
        'creative_carousel_templates'             => '1',
      ],
    ]
  );

  $controls->add_control(
    'creative_with_background_name_color',
    [
      'label'     => esc_html__('Title Color', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .creative-with-background.creative .creative__wrapper-content .creative__slide-title *' => 'color: {{VALUE}};',
      ],
      'separator' => 'before',
      'condition' => [
        'creative_with_background_content_enable' => 'yes',
        'creative_carousel_templates'             => '1',
      ],
    ]
  );

  $controls->add_group_control(
    Group_Control_Typography::get_type(),
    [
      'name'      => 'creative_with_background_name_typography',
      'label'     => esc_html__('Title Typography', 'testimonials-carousel-elementor'),
      'selector'  => '{{WRAPPER}} .creative-with-background.creative .creative__wrapper-content .creative__slide-title *',
      'condition' => [
        'creative_with_background_content_enable' => 'yes',
        'creative_carousel_templates'             => '1',
      ],
    ]
  );

  $controls->add_responsive_control(
    'creative_with_background_name_align',
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
      'default'   => 'right',
      'selectors' => [
        '{{WRAPPER}} .creative-with-background.creative .creative__wrapper-content .creative__slide-title *' => 'text-align: {{VALUE}}',
      ],
      'condition' => [
        'creative_with_background_content_enable' => 'yes',
        'creative_carousel_templates'             => '1',
      ],
    ]
  );

  $controls->add_control(
    'creative_with_background_subtitle_color',
    [
      'label'     => esc_html__('Subtitle Color', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .creative-with-background.creative .creative__wrapper-content .creative__slide-subtitle *' => 'color: {{VALUE}};',
      ],
      'separator' => 'before',
      'condition' => [
        'creative_with_background_content_enable' => 'yes',
        'creative_carousel_templates'             => '1',
      ],
    ]
  );

  $controls->add_group_control(
    Group_Control_Typography::get_type(),
    [
      'name'      => 'creative_with_background_subtitle_typography',
      'label'     => esc_html__('Subtitle Typography', 'testimonials-carousel-elementor'),
      'selector'  => '{{WRAPPER}} .creative-with-background.creative .creative__wrapper-content .creative__slide-subtitle *',
      'condition' => [
        'creative_with_background_content_enable' => 'yes',
        'creative_carousel_templates'             => '1',
      ],
    ]
  );

  $controls->add_responsive_control(
    'creative_with_background_subtitle_align',
    [
      'label'     => esc_html__('Alignment Subtitle', 'testimonials-carousel-elementor'),
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
      'default'   => 'right',
      'selectors' => [
        '{{WRAPPER}} .creative-with-background.creative .creative__wrapper-content .creative__slide-subtitle *' => 'text-align: {{VALUE}}',
      ],
      'condition' => [
        'creative_with_background_content_enable' => 'yes',
        'creative_carousel_templates'             => '1',
      ],
    ]
  );

  $controls->add_control(
    'creative_with_background_content_color',
    [
      'label'     => esc_html__('Description Color', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .creative-with-background.creative .creative__wrapper-content .creative__slide-text *' => 'color: {{VALUE}};',
      ],
      'separator' => 'before',
      'condition' => [
        'creative_with_background_content_enable' => 'yes',
        'creative_carousel_templates'             => '1',
      ],
    ]
  );

  $controls->add_group_control(
    Group_Control_Typography::get_type(),
    [
      'name'      => 'creative_with_background_content_typography',
      'label'     => esc_html__('Description Typography', 'testimonials-carousel-elementor'),
      'selector'  => '{{WRAPPER}} .creative-with-background.creative .creative__wrapper-content .creative__slide-text *',
      'condition' => [
        'creative_with_background_content_enable' => 'yes',
        'creative_carousel_templates'             => '1',
      ],
    ]
  );

  $controls->add_responsive_control(
    'creative_with_background_content_align',
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
      'default'   => 'right',
      'selectors' => [
        '{{WRAPPER}} .creative-with-background.creative .creative__wrapper-content .creative__slide-text *' => 'text-align: {{VALUE}}',
      ],
      'condition' => [
        'creative_with_background_content_enable' => 'yes',
        'creative_carousel_templates'             => '1',
      ],
    ]
  );

  $controls->add_responsive_control(
    'creative_with_background_content_width',
    [
      'label'      => esc_html__('Description Width', 'testimonials-carousel-elementor'),
      'type'       => Controls_Manager::SLIDER,
      'default'    => [
        'unit' => '%',
      ],
      'size_units' => ['px', 'em', 'rem', '%'],
      'selectors'  => [
        '{{WRAPPER}} .creative-with-background.creative .creative__wrapper-content .creative__slide-text *' => 'max-width: {{SIZE}}{{UNIT}};',
      ],
      'condition'  => [
        'creative_with_background_content_enable' => 'yes',
        'creative_carousel_templates'             => '1',
      ],
    ]
  );
}

// Arrows Styles Creative With Background
function get_arrows_style_creative_with_background($controls)
{
  $controls->add_control(
    'creative_with_background_arrows_size',
    [
      'label'     => esc_html__('Arrows Size', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::SLIDER,
      'default'   => [
        'unit' => 'px',
        'size' => 20,
      ],
      'selectors' => [
        '{{WRAPPER}} .creative-with-background.creative .swiper-button-prev svg, {{WRAPPER}} .creative .swiper-button-next svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
        '{{WRAPPER}} .creative-with-background.creative .swiper-button-prev i, {{WRAPPER}} .creative .swiper-button-next i'     => 'font-size: {{SIZE}}{{UNIT}};',
      ],
      'condition' => [
        'creative_carousel_templates' => '1',
      ],
    ]
  );

  $controls->add_control(
    'creative_with_background_arrows_color',
    [
      'label'     => esc_html__('Arrows Color', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .creative-with-background.creative .swiper-button-prev svg path, {{WRAPPER}} .creative .swiper-button-next svg path' => 'fill: {{VALUE}};',
        '{{WRAPPER}} .creative-with-background.creative .swiper-button-prev i, {{WRAPPER}} .creative .swiper-button-next i'               => 'color: {{VALUE}};',
      ],
      'condition' => [
        'creative_carousel_templates' => '1',
      ],
    ]
  );

  $controls->add_responsive_control(
    'creative_with_background_arrows_top_position',
    [
      'label'     => esc_html__('Position Top', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::SLIDER,
      'default'   => [
        'unit' => 'px',
      ],
      'selectors' => [
        '{{WRAPPER}} .creative-with-background.creative .swiper-button-prev, {{WRAPPER}} .creative .swiper-button-next' => 'top: {{SIZE}}{{UNIT}}; bottom: unset;',
      ],
      'condition' => [
        'creative_carousel_templates' => '1',
      ],
    ]
  );

  $controls->add_responsive_control(
    'creative_with_background_arrows_bottom_position',
    [
      'label'     => esc_html__('Position Bottom', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::SLIDER,
      'default'   => [
        'unit' => 'px',
      ],
      'selectors' => [
        '{{WRAPPER}} .creative-with-background.creative .swiper-button-prev, {{WRAPPER}} .creative .swiper-button-next' => 'bottom: {{SIZE}}{{UNIT}}; top: unset;',
      ],
      'condition' => [
        'creative_carousel_templates' => '1',
      ],
    ]
  );

  $controls->add_responsive_control(
    'creative_with_background_arrows_prev_position',
    [
      'label'     => esc_html__('Arrow Prev', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::SLIDER,
      'default'   => [
        'unit' => 'px',
      ],
      'selectors' => [
        '{{WRAPPER}} .creative-with-background.creative .swiper-button-prev' => 'right: {{SIZE}}{{UNIT}}; left: unset;',
      ],
      'condition' => [
        'creative_carousel_templates' => '1',
      ],
    ]
  );

  $controls->add_responsive_control(
    'creative_with_background_arrows_next_position',
    [
      'label'     => esc_html__('Arrow Next', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::SLIDER,
      'default'   => [
        'unit' => 'px',
      ],
      'selectors' => [
        '{{WRAPPER}} .creative-with-background.creative .swiper-button-next' => 'left: {{SIZE}}{{UNIT}}; right: unset;',
      ],
      'condition' => [
        'creative_carousel_templates' => '1',
      ],
    ]
  );
}

// Dots Styles Creative With Background
function get_dots_style_creative_with_background($controls)
{
  $controls->add_group_control(
    Group_Control_Typography::get_type(),
    [
      'name'      => 'creative_with_background_dots_size',
      'label'     => esc_html__('Counter Size', 'testimonials-carousel-elementor'),
      'selector'  => '{{WRAPPER}} .creative-with-background.creative .swiper-pagination.swiper-pagination-fraction',
      'condition' => [
        'creative_carousel_templates' => '1',
      ],
    ]
  );

  $controls->add_control(
    'creative_with_background_dots_color',
    [
      'label'     => esc_html__('Counter Color', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .creative-with-background.creative .swiper-pagination.swiper-pagination-fraction' => 'color: {{VALUE}};',
      ],
      'condition' => [
        'creative_carousel_templates' => '1',
      ],
    ]
  );

  $controls->add_responsive_control(
    'creative_with_background_dots_top_position',
    [
      'label'     => esc_html__('Position Top', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::SLIDER,
      'selectors' => [
        '{{WRAPPER}} .creative-with-background.creative .swiper-pagination.swiper-pagination-fraction' => 'top: {{SIZE}}{{UNIT}};',
      ],
      'condition' => [
        'creative_carousel_templates' => '1',
      ],
    ]
  );

  $controls->add_responsive_control(
    'creative_with_background_dots_bottom_position',
    [
      'label'     => esc_html__('Position Bottom', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::SLIDER,
      'selectors' => [
        '{{WRAPPER}} .creative-with-background.creative .swiper-pagination.swiper-pagination-fraction' => 'bottom: {{SIZE}}{{UNIT}};',
      ],
      'condition' => [
        'creative_carousel_templates' => '1',
      ],
    ]
  );

  $controls->add_responsive_control(
    'creative_with_background_dots_right_position',
    [
      'label'     => esc_html__('Position Right', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::SLIDER,
      'selectors' => [
        '{{WRAPPER}} .creative-with-background.creative .swiper-pagination.swiper-pagination-fraction' => 'right: {{SIZE}}{{UNIT}}; left: unset;',
      ],
      'condition' => [
        'creative_carousel_templates' => '1',
      ],
    ]
  );

  $controls->add_responsive_control(
    'creative_with_background_dots_left_position',
    [
      'label'     => esc_html__('Position Left', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::SLIDER,
      'selectors' => [
        '{{WRAPPER}} .creative-with-background.creative .swiper-pagination.swiper-pagination-fraction' => 'left: {{SIZE}}{{UNIT}}; right: unset;',
      ],
      'condition' => [
        'creative_carousel_templates' => '1',
      ],
    ]
  );
}

// Section Pagination Styles Creative With Background
function get_section_pagination_creative_with_background($controls)
{
  $controls->start_controls_section(
    'creative_with_background_pagination_styles_section',
    [
      'label'     => __('Pagination Styles', 'testimonials-carousel-elementor'),
      'tab'       => Controls_Manager::TAB_STYLE,
      'condition' => [
        'creative_carousel_templates' => '1',
      ],
    ]
  );

  $controls->add_responsive_control(
    'creative_with_background_pagination_width',
    [
      'label'      => esc_html__('Pagination Width', 'testimonials-carousel-elementor'),
      'type'       => Controls_Manager::SLIDER,
      'default'    => [
        'unit' => '%',
      ],
      'size_units' => ['px', 'em', 'rem', '%'],
      'selectors'  => [
        '{{WRAPPER}} .creative-with-background.creative .creative-with-background__pagination' => 'max-width: {{SIZE}}{{UNIT}};',
      ],
      'condition'  => [
        'creative_carousel_templates' => '1',
      ],
    ]
  );

  $controls->add_responsive_control(
    'creative_with_background_pagination_height',
    [
      'label'      => esc_html__('Pagination Height', 'testimonials-carousel-elementor'),
      'type'       => Controls_Manager::SLIDER,
      'default'    => [
        'unit' => '%',
      ],
      'size_units' => ['px', 'em', 'rem', '%'],
      'selectors'  => [
        '{{WRAPPER}} .creative-with-background.creative .creative-with-background__pagination' => 'min-height: {{SIZE}}{{UNIT}};',
      ],
      'condition'  => [
        'creative_carousel_templates' => '1',
      ],
    ]
  );

  $controls->add_group_control(
    Group_Control_Border::get_type(),
    [
      'name'      => 'creative_with_background_border_pagination',
      'selector'  => '{{WRAPPER}} .creative-with-background.creative .creative-with-background__pagination',
      'condition' => [
        'creative_carousel_templates' => '1',
      ],
      'separator' => 'before',
    ]
  );

  $controls->add_responsive_control(
    'creative_with_background_border_radius_pagination',
    [
      'label'      => esc_html__('Pagination Border Radius', 'testimonials-carousel-elementor'),
      'type'       => Controls_Manager::DIMENSIONS,
      'size_units' => ['px', '%', 'em', 'rem', 'custom'],
      'selectors'  => [
        '{{WRAPPER}} .creative-with-background.creative .creative-with-background__pagination' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
      ],
      'condition'  => [
        'creative_carousel_templates' => '1',
      ],
    ]
  );

  $controls->add_responsive_control(
    'creative_with_background_pagination_position',
    [
      'label'     => esc_html__('Pagination Position', 'testimonials-carousel-elementor'),
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
        'creative_carousel_templates' => '1',
      ],
      'separator' => 'before',
    ]
  );

  $controls->add_responsive_control(
    'creative_with_background_pagination_top_position',
    [
      'label'     => esc_html__('Position Top', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::SLIDER,
      'default'   => [
        'unit' => 'px',
        'size' => 0,
      ],
      'selectors' => [
        '{{WRAPPER}} .creative-with-background.creative .creative-with-background__pagination' => 'top: {{SIZE}}{{UNIT}}; bottom: unset;',
      ],
      'condition' => [
        'creative_with_background_pagination_position' => 'top',
        'creative_carousel_templates'                  => '1',
      ],
    ]
  );

  $controls->add_responsive_control(
    'creative_with_background_pagination_bottom_position',
    [
      'label'     => esc_html__('Position Bottom', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::SLIDER,
      'default'   => [
        'unit' => 'px',
      ],
      'selectors' => [
        '{{WRAPPER}} .creative-with-background.creative .creative-with-background__pagination' => 'bottom: {{SIZE}}{{UNIT}}; top: unset;',
      ],
      'condition' => [
        'creative_with_background_pagination_position' => 'bottom',
        'creative_carousel_templates'                  => '1',
      ],
    ]
  );

  $controls->add_responsive_control(
    'creative_with_background_pagination_right_position',
    [
      'label'     => esc_html__('Pagination Rigth', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::SLIDER,
      'default'   => [
        'unit' => 'px',
      ],
      'selectors' => [
        '{{WRAPPER}} .creative-with-background.creative .creative-with-background__pagination' => 'right: {{SIZE}}{{UNIT}}; left: unset;',
      ],
      'condition' => [
        'creative_carousel_templates' => '1',
      ],
    ]
  );

  $controls->add_responsive_control(
    'creative_with_background_pagination_left_position',
    [
      'label'     => esc_html__('Pagination Left', 'testimonials-carousel-elementor'),
      'type'      => Controls_Manager::SLIDER,
      'default'   => [
        'unit' => 'px',
      ],
      'selectors' => [
        '{{WRAPPER}} .creative-with-background.creative .creative-with-background__pagination' => 'left: {{SIZE}}{{UNIT}}; right: unset;',
      ],
      'condition' => [
        'creative_carousel_templates' => '1',
      ],
    ]
  );

  $controls->end_controls_section();
}
