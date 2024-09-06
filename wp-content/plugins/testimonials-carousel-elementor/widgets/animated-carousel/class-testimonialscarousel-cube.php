<?php
/**
 * TestimonialsCarousel_Cube class.
 *
 * @category   Class
 * @package    TestimonialsCarouselElementor
 * @subpackage WordPress
 * @author     UAPP GROUP
 * @copyright  2024 UAPP GROUP
 * @license    https://opensource.org/licenses/GPL-3.0 GPL-3.0-only
 * @link
 * @since      11.2.0
 * php version 7.4.1
 */

namespace TestimonialsCarouselElementor\Widgets;

use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Security Note: Blocks direct access to the plugin PHP files.
defined('ABSPATH') || die();

/**
 * TestimonialsCarousel_Cube widget class.
 *
 * @since 11.2.0
 */
class TestimonialsCarousel_Cube extends Widget_Base
{
  /**
   * TestimonialsCarousel_Cube constructor.
   *
   * @param array $data
   * @param null  $args
   *
   * @throws \Exception
   */
  public function __construct($data = [], $args = null)
  {
    parent::__construct($data, $args);
    wp_register_style('swiper', plugins_url('/assets/css/swiper-bundle.min.css', TESTIMONIALS_CAROUSEL_ELEMENTOR), [], TESTIMONIALS_VERSION);
    wp_register_style('testimonials-carousel', plugins_url('/assets/css/testimonials-carousel.min.css', TESTIMONIALS_CAROUSEL_ELEMENTOR), [], TESTIMONIALS_VERSION);
    wp_register_style('testimonials-carousel-cube', plugins_url('/assets/css/testimonials-carousel-cube.min.css', TESTIMONIALS_CAROUSEL_ELEMENTOR), [], TESTIMONIALS_VERSION);
    wp_register_script('swiper', plugins_url('/assets/js/swiper-bundle.min.js', TESTIMONIALS_CAROUSEL_ELEMENTOR), [], TESTIMONIALS_VERSION, true);


    if (!function_exists('get_plugin_data')) {
      require_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }

    if (get_plugin_data(ELEMENTOR__FILE__)['Version'] >= "3.5.0") {
      wp_register_script('testimonials-carousel-widget-handler', plugins_url('/assets/js/testimonials-carousel-widget-handler.min.js', TESTIMONIALS_CAROUSEL_ELEMENTOR), ['elementor-frontend'], TESTIMONIALS_VERSION, true);
    } else {
      wp_register_script('testimonials-carousel-widget-handler', plugins_url('/assets/js/testimonials-carousel-widget-old-elementor-handler.min.js', TESTIMONIALS_CAROUSEL_ELEMENTOR), ['elementor-frontend'], TESTIMONIALS_VERSION, true);
    }
  }

  /**
   * Retrieve the widget name.
   *
   * @return string Widget name.
   * @since  11.2.0
   *
   * @access public
   *
   */
  public function get_name()
  {
    return 'testimonials-carousel-cube';
  }

  /**
   * Retrieve the widget title.
   *
   * @return string Widget title.
   * @since  11.2.0
   *
   * @access public
   *
   */
  public function get_title()
  {
    return __('Cube Carousel', 'testimonials-carousel-elementor');
  }

  /**
   * Retrieve the widget icon.
   *
   * @return string Widget icon.
   * @since  11.2.0
   *
   * @access public
   *
   */
  public function get_icon()
  {
    return 'icon-cube-carousel';
  }

  /**
   * Retrieve the list of categories the widget belongs to.
   *
   * Used to determine where to display the widget in the editor.
   *
   * Note that currently Elementor supports only one category.
   * When multiple categories passed, Elementor uses the first one.
   *
   * @return array Widget categories.
   * @since  11.2.0
   *
   * @access public
   *
   */
  public function get_categories()
  {
    return ['3d_animated_carousel'];
  }

  /**
   * Enqueue styles.
   */
  public function get_style_depends()
  {
    $styles = ['swiper', 'testimonials-carousel', 'testimonials-carousel-cube'];

    return $styles;
  }

  public function get_script_depends()
  {
    $scripts = ['swiper', 'testimonials-carousel-widget-handler', 'ai-btn'];

    return $scripts;
  }

  /**
   * Get default slide.
   *
   * @return array Default slide.
   */
  protected function get_default_slide()
  {
    return [
      'slide_content' => __('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'testimonials-carousel-elementor'),
      'slide_image'   => [
        'url' => Utils::get_placeholder_image_src(),
      ],
      'slide_name'    => __('Title', 'testimonials-carousel-elementor'),
      'slide_reviews' => __('138 reviews', 'testimonials-carousel-elementor'),
      'slide_price'   => __('from $230 per group', 'testimonials-carousel-elementor'),
    ];
  }

  /**
   * Register the widget controls.
   *
   * Adds different input fields to allow the user to change and customize the widget settings.
   *
   * @since  11.2.0
   *
   * @access protected
   */
  protected function _register_controls()
  {
    // Content Section
    $this->start_controls_section(
      'section_content',
      [
        'label' => __('Content', 'testimonials-carousel-elementor'),
      ]
    );

    $repeater = new Repeater();
    $repeater->add_control(
      'slide_image',
      [
        'label'   => __('Choose square or round Image', 'testimonials-carousel-elementor'),
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
      'slide_name',
      [
        'label'              => __('Name', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::TEXT,
        'default'            => __('Title', 'testimonials-carousel-elementor'),
        'label_block'        => true,
        'frontend_available' => true,
        'dynamic'            => [
          'active' => true,
        ],
        'ai'                 => [
          'active' => false,
        ],
      ]
    );

    $repeater->add_control(
      'slide_price_enable',
      [
        'label'        => __('Price', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
      ]
    );

    $repeater->add_control(
      'slide_price',
      [
        'label'              => __('Price', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::TEXT,
        'default'            => __('from $230 per group', 'testimonials-carousel-elementor'),
        'label_block'        => true,
        'frontend_available' => true,
        'dynamic'            => [
          'active' => true,
        ],
        'ai'                 => [
          'active' => false,
        ],
        'condition'          => [
          'slide_price_enable' => 'yes',
        ],
      ]
    );

    $repeater->add_control(
      'slide_overlay_enable',
      [
        'label'        => __('Overlay', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
      ]
    );

    $repeater->add_control(
      'slide_rating_enable',
      [
        'label'        => __('Rating', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'condition'    => [
          'slide_overlay_enable' => 'yes',
        ]
      ]
    );
    $repeater->add_control(
      'slide_rating',
      [
        'label'              => __('Rating', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::NUMBER,
        'min'                => 0,
        'max'                => 5,
        'step'               => 1,
        'default'            => 4,
        'frontend_available' => true,
        'condition'          => [
          'slide_rating_enable'  => 'yes',
          'slide_overlay_enable' => 'yes',
        ],
      ]
    );

    $repeater->add_control(
      'slide_reviews_enable',
      [
        'label'        => __('Reviews', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'condition'    => [
          'slide_overlay_enable' => 'yes',
        ],
      ]
    );

    $repeater->add_control(
      'slide_reviews',
      [
        'label'              => __('Reviews', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::TEXT,
        'default'            => __('138 reviews', 'testimonials-carousel-elementor'),
        'label_block'        => true,
        'frontend_available' => true,
        'dynamic'            => [
          'active' => true,
        ],
        'ai'                 => [
          'active' => false,
        ],
        'condition'          => [
          'slide_reviews_enable' => 'yes',
          'slide_overlay_enable' => 'yes',
        ],
      ]
    );

    $repeater->add_control(
      'slide_content',
      [
        'label'              => __('Content', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::WYSIWYG,
        'default'            => __('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'testimonials-carousel-elementor'),
        'frontend_available' => true,
        'dynamic'            => [
          'active' => true,
        ],
        'ai'                 => [
          'active' => false,
        ],
        'condition'          => [
          'slide_overlay_enable' => 'yes',
        ]
      ]
    );

    $this->add_control(
      'slide',
      [
        'label'              => __('Repeater Slide', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::REPEATER,
        'fields'             => $repeater->get_controls(),
        'title_field'        => 'Slide',
        'frontend_available' => true,
        'default'            => [$this->get_default_slide()],
      ]
    );
    $this->end_controls_section();


    // Additional Options Section
    $this->start_controls_section(
      'section_additional_options',
      [
        'label' => esc_html__('Additional Options', 'testimonials-carousel-elementor'),
      ]
    );

    $this->add_control(
      'slider_rotate',
      [
        'label'              => esc_html__('Rotate', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::SWITCHER,
        'label_on'           => __('Yes', 'testimonials-carousel-elementor'),
        'label_off'          => __('No', 'testimonials-carousel-elementor'),
        'return_value'       => 'yes',
        'default'            => 'yes',
        'frontend_available' => true,
      ]
    );

    $this->add_control(
      'slide_shadows',
      [
        'label'              => esc_html__('Slide Shadows', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::SWITCHER,
        'label_on'           => __('Show', 'testimonials-carousel-elementor'),
        'label_off'          => __('Hide', 'testimonials-carousel-elementor'),
        'return_value'       => 'yes',
        'default'            => 'yes',
        'frontend_available' => true,
      ]
    );

    $this->add_control(
      'slider_shadow_offset',
      [
        'label'              => esc_html__('Shadow Offset', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::NUMBER,
        'min'                => 10,
        'step'               => 1,
        'max'                => 200,
        'default'            => 10,
        'frontend_available' => true,
        'condition'          => [
          'slide_shadows' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'slider_shadow_scale',
      [
        'label'              => esc_html__('Shadow Scale', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::NUMBER,
        'min'                => 0,
        'step'               => 0.01,
        'max'                => 1.3,
        'default'            => 0.94,
        'frontend_available' => true,
        'condition'          => [
          'slide_shadows' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'slider_pause_mouse_enter',
      [
        'label'              => esc_html__('Pause On Mouse Enter', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::SWITCHER,
        'label_on'           => __('Yes', 'testimonials-carousel-elementor'),
        'label_off'          => __('No', 'testimonials-carousel-elementor'),
        'return_value'       => 'yes',
        'default'            => 'yes',
        'frontend_available' => true,
      ]
    );

    $this->add_control(
      'slider_reverse_direction',
      [
        'label'              => esc_html__('Reverse Direction', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::SWITCHER,
        'label_on'           => __('Yes', 'testimonials-carousel-elementor'),
        'label_off'          => __('No', 'testimonials-carousel-elementor'),
        'return_value'       => 'yes',
        'default'            => 'no',
        'frontend_available' => true,
      ]
    );

    $this->add_control(
      'overlay_enable',
      [
        'label'        => __('Overlay', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
      ]
    );

    $this->add_control(
      'autoplay_speed',
      [
        'label'              => esc_html__('Autoplay speed', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::NUMBER,
        'min'                => 1,
        'default'            => 1,
        'frontend_available' => true,
      ]
    );

    $this->add_control(
      'slider_speed',
      [
        'label'              => esc_html__('Speed', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::NUMBER,
        'default'            => 3000,
        'frontend_available' => true,
      ]
    );

    $this->end_controls_section();

    // General styles Section
    $this->start_controls_section(
      'general_styles_section',
      [
        'label' => esc_html__('General styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_responsive_control(
      'slider_testimonials_custom_width',
      [
        'label'      => esc_html__('Width', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'default'    => [
          'unit' => 'px',
        ],
        'size_units' => ['px', 'em', 'rem'],
        'range'      => [
          'px' => [
            'min'  => 400,
            'max'  => 600,
            'step' => 1,
          ],
        ],
        'selectors'  => [
          '{{WRAPPER}} .mySwiperCube' => '--container-widget-max-width: {{SIZE}}{{UNIT}}; --container-widget-flex-grow: 0; max-width: var( --container-widget-max-width, {{SIZE}}{{UNIT}} );',
        ],
      ]
    );
    $this->add_responsive_control(
      'slide_testimonials_height',
      [
        'label'      => esc_html__('Height', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range'      => [
          'px' => [
            'min'  => 400,
            'step' => 1,
            'max'  => 690,
          ],
        ],
        'selectors'  => [
          "{{WRAPPER}} .mySwiperCube" => 'height: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'      => 'slider_border',
        'selector'  => '{{WRAPPER}} .swiper-slide.slider-container-background',
        'separator' => 'before',
      ]
    );

    $this->add_responsive_control(
      'slider_border_radius',
      [
        'label'      => esc_html__('Border Radius', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .swiper-slide.slider-container-background' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
          '{{WRAPPER}} .swiper-slide img'                         => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
          '{{WRAPPER}} .swiper-slide-shadow-left '                => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
          '{{WRAPPER}} .swiper-slide-shadow-right'                => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'icon_size',
      [
        'label'     => esc_html__('Rating icon size', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SLIDER,
        'range'     => [
          'px' => [
            'min' => 5,
            'max' => 30,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .slide-icons i' => 'font-size: {{SIZE}}{{UNIT}}',
        ],
        'separator' => 'before',
      ]
    );

    $this->add_responsive_control(
      'icon_space',
      [
        'label'     => esc_html__('Rating icon spacing', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SLIDER,
        'range'     => [
          'px' => [
            'min' => 0,
            'max' => 20,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .slide-icons i' => 'margin-right: {{SIZE}}{{UNIT}}',
        ],
      ]
    );

    $this->add_control(
      'stars_color',
      [
        'label'     => esc_html__('Rating icon color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .slide-icons .icon-star-full' => 'color: {{VALUE}}',
        ],
        'separator' => 'before',
      ]
    );

    $this->add_control(
      'stars_unmarked_color',
      [
        'label'     => esc_html__('Rating unmarked icon color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .slide-icons .icon-star-empty' => 'color: {{VALUE}}',
        ],
      ]
    );
    $this->end_controls_section();

    // Slider styles Section
    $this->start_controls_section(
      'slider_styles_section',
      [
        'label' => __('Slider styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );
    $this->add_control(
      'slider_name_color',
      [
        'label'     => esc_html__('Name color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .swiper-wrapper .overlay h1' => 'color: {{VALUE}};',
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'slider_name_typography',
        'label'    => esc_html__('Name typography', 'testimonials-carousel-elementor'),
        'selector' => '{{WRAPPER}} .swiper-wrapper .overlay h1',
      ]
    );
    $this->add_responsive_control(
      'slider_name_align',
      [
        'label'     => esc_html__('Alignment Name', 'testimonials-carousel-elementor'),
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
          '{{WRAPPER}} .overlay h1' => 'text-align: {{VALUE}}',
        ],
      ]
    );

    $this->add_control(
      'slider_content_color',
      [
        'label'     => esc_html__('Content color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .swiper-wrapper .overlay p' => 'color: {{VALUE}};',
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'slider_content_typography',
        'label'    => esc_html__('Content typography', 'testimonials-carousel-elementor'),
        'selector' => '{{WRAPPER}} .swiper-wrapper .overlay p',
      ]
    );
    $this->add_responsive_control(
      'slider_content_align',
      [
        'label'     => esc_html__('Alignment Content', 'testimonials-carousel-elementor'),
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
          '{{WRAPPER}} .overlay p' => 'text-align: {{VALUE}}',
        ],
      ]
    );

    $this->add_control(
      'slider_reviews_color',
      [
        'label'     => esc_html__('Review color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .swiper-wrapper .overlay .slide-reviews' => 'color: {{VALUE}};',
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'slider_reviews_typography',
        'label'    => esc_html__('Review typography', 'testimonials-carousel-elementor'),
        'selector' => '{{WRAPPER}} .swiper-wrapper .overlay .slide-reviews',
      ]
    );
    $this->end_controls_section();

    // Overlay styles Section
    $this->start_controls_section(
      'slider_overlay_section',
      [
        'label' => __('Overlay styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );
    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'     => 'background_overlay',
        'types'    => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .overlay',
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'      => 'slider_overlay_border',
        'selector'  => '{{WRAPPER}} .overlay',
        'separator' => 'before',
      ]
    );

    $this->add_responsive_control(
      'slider_overlay_border_radius',
      [
        'label'      => esc_html__('Border Radius', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .overlay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->end_controls_section();

    // Price styles Section
    $this->start_controls_section(
      'slider_price_section',
      [
        'label' => __('Price styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );
    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'     => 'background_price',
        'types'    => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .cost',
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'      => 'slider_price_border',
        'selector'  => '{{WRAPPER}} .cost',
        'separator' => 'before',
      ]
    );

    $this->add_responsive_control(
      'slider_price_border_radius',
      [
        'label'      => esc_html__('Border Radius', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .cost' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Box_Shadow::get_type(),
      [
        'name'     => 'slider_box_shadow',
        'selector' => '{{WRAPPER}} .cost',
      ]
    );

    $this->add_control(
      'slider_price_color',
      [
        'label'     => esc_html__('Price color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .cost' => 'color: {{VALUE}};',
        ],
        'separator' => 'before',
      ]
    );
    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'slider_price_typography',
        'label'    => esc_html__('Price typography', 'testimonials-carousel-elementor'),
        'selector' => '{{WRAPPER}} .cost',
      ]
    );

    $this->end_controls_section();
  }

  /**
   * Render the widget output on the frontend.
   *
   * Written in PHP and used to generate the final HTML.
   *
   * @since  11.2.0
   *
   * @access protected
   */
  protected function render()
  {
    $settings = $this->get_settings_for_display();
    if (get_plugin_data(ELEMENTOR__FILE__)['Version'] < "3.5.0") {
      $this->add_render_attribute(
        'my_swiper',
        [
          'class'                                => ['slider-params'],
          'data-speed-myswiper'                  => esc_attr($settings['slider_speed']),
          'data-autoplayspeed-myswiper'          => esc_attr($settings['autoplay_speed']),
          'data-sliderrotate-myswiper'           => esc_attr($settings['slider_rotate']),
          'data-slidershadowoffset-myswiper'     => esc_attr($settings['slider_shadow_offset']),
          'data-slidershadowscale-myswiper'      => esc_attr($settings['slider_shadow_scale']),
          'data-sliderpausemouse-myswiper'       => esc_attr($settings['slider_pause_mouse_enter']),
          'data-sliderrevercedirection-myswiper' => esc_attr($settings['slider_reverse_direction']),
          'data-slideshadows-myswiper'           => esc_attr($settings['slide_shadows']),
        ]
      );
    }

    if ($settings['slide']) {
      if (get_plugin_data(ELEMENTOR__FILE__)['Version'] < "3.5.0") { ?>
        <div <?php echo $this->get_render_attribute_string('my_swiper'); ?>></div>
      <?php } ?>

      <section class="swiper mySwiper mySwiperCube">
        <ul class="swiper-wrapper <?php if (esc_attr($settings['slider_rotate'])) { ?>slide-rotate<?php } ?>">
          <?php $counter = 1;
          foreach ($settings['slide'] as $item) { ?>
            <li class="swiper-slide slider-container-background">
              <img
                  src="<?php echo esc_url($item['slide_image']['url']) ?>"
                  alt="<?php echo wp_kses($item['slide_name'], []); ?>">

              <?php if ($item['slide_price_enable'] === 'yes') { ?>
                <div class="cost"><?php echo wp_kses($item['slide_price'], []); ?></div>
              <?php }

              if ($item['slide_overlay_enable'] === 'yes' && $settings['overlay_enable'] === 'yes') { ?>
                <div class="overlay overlay-<?php echo esc_attr($counter); ?>">
                  <h1><?php echo wp_kses($item['slide_name'], []); ?></h1>

                  <div class="crop-cube-content">
                    <?php echo wp_kses_post($item['slide_content']); ?>
                  </div>

                  <?php if ($item['slide_rating_enable'] === 'yes') { ?>
                    <div class="slide-icons ratings">
                      <div class="stars">
                        <?php
                        for ($i = 0; $i < $item['slide_rating']; $i++) { ?>
                          <i class="icon-star-full star"></i>
                        <?php }
                        for ($i = 0; $i < (5 - $item['slide_rating']); $i++) { ?>
                          <i class="icon-star-empty"></i>
                        <?php } ?>
                      </div>

                      <?php if ($item['slide_reviews_enable'] === 'yes') { ?>
                        <span class="slide-reviews"><?php echo wp_kses($item['slide_reviews'], []); ?></span>
                      <?php } ?>
                    </div>
                  <?php } ?>
                </div>
              <?php } ?>
            </li>
            <?php $counter++;
          } ?>
        </ul>
      </section>
    <?php } ?>
  <?php }
}
