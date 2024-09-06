<?php
/**
 * Section_With_Cube_360 class.
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
 * Section_With_Cube_360 widget class.
 *
 * @since 11.2.0
 */
class Section_With_Cube_360 extends Widget_Base
{
  /**
   * Section_With_Cube_360 constructor.
   *
   * @param array $data
   * @param null  $args
   *
   * @throws \Exception
   */
  public function __construct($data = [], $args = null)
  {
    parent::__construct($data, $args);
    wp_register_style('testimonials-carousel', plugins_url('/assets/css/testimonials-carousel.min.css', TESTIMONIALS_CAROUSEL_ELEMENTOR), [], TESTIMONIALS_VERSION);
    wp_register_style('section-with-carousel-cube-360', plugins_url('/assets/css/testimonials-section-with-cube-360.min.css', TESTIMONIALS_CAROUSEL_ELEMENTOR), [], TESTIMONIALS_VERSION);

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
    return 'section-with-carousel-cube-360';
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
    return __('Section With Cube 360', 'testimonials-carousel-elementor');
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
    return 'icon-section-with-cube-360';
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
    return ['testimonials_section'];
  }

  /**
   * Enqueue styles.
   */
  public function get_style_depends()
  {
    $styles = ['testimonials-carousel', 'section-with-carousel-cube-360'];

    return $styles;
  }

  public function get_script_depends()
  {
    $scripts = ['testimonials-carousel-widget-handler', 'ai-btn'];

    return $scripts;
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

    $this->add_control(
      'section_content_name',
      [
        'label'              => __('Title', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::WYSIWYG,
        'default'            => __('Discover NYC: <br> Top 10 Iconic Destinations', 'testimonials-carousel-elementor'),
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

    $this->add_control(
      'section_content_text',
      [
        'label'              => __('Content', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::WYSIWYG,
        'default'            => __('<p>Welcome to an exciting journey through the most iconic places of New York City! Discover the unique character of this city, from the observation decks at the Empire State Building and One World Observatory to cultural and historical attractions like the Metropolitan Museum and the Museum of Modern Art. Visit landmark locations such as Central Park and the Brooklyn Bridge, and feel the pulse of the city that never sleeps.</p> <p>Explore cultural neighborhoods like Harlem and Greenwich Village, where you can immerse yourself in the rich culture and atmosphere of this unique city. Get ready for unforgettable experiences in New York, where every corner holds its own unique history and charm!</p>', 'testimonials-carousel-elementor'),
        'frontend_available' => true,
        'dynamic'            => [
          'active' => true,
        ],
        'ai'                 => [
          'active' => false,
        ],
      ]
    );
    $this->end_controls_section();

    // Side Front
    $this->start_controls_section(
      'cube_front',
      [
        'label' => __('Front', 'testimonials-carousel-elementor'),
      ]
    );

    $this->add_control(
      'cube_front_image',
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

    $this->add_control(
      'cube_front_price_enable',
      [
        'label'        => __('Price', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_front_price',
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
          'cube_front_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_front_price_position',
      [
        'label'     => esc_html__('Price Position', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::CHOOSE,
        'options'   => [
          'left'  => [
            'title' => esc_html__('Left', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-text-align-left',
          ],
          'right' => [
            'title' => esc_html__('Right', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-text-align-right',
          ],
        ],
        'default'   => 'right',
        'condition' => [
          'cube_front_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_responsive_control(
      'cube_front_price_top',
      [
        'label'      => esc_html__('Top', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range'      => [
          'px' => [
            'min'  => 8,
            'step' => 1,
            'max'  => 130,
          ],
        ],
        'default'    => [
          'unit' => 'px',
          'size' => 8,
        ],
        'selectors'  => [
          "{{WRAPPER}} .myCube-360 .side-container.front .cube-wrapper-price" => 'top: {{SIZE}}{{UNIT}};',
        ],
        'condition'  => [
          'cube_front_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_responsive_control(
      'cube_front_price_right',
      [
        'label'      => esc_html__('Right', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range'      => [
          'px' => [
            'min'  => 6,
            'step' => 1,
            'max'  => 155,
          ],
        ],
        'default'    => [
          'unit' => 'px',
          'size' => 6,
        ],
        'selectors'  => [
          "{{WRAPPER}} .myCube-360 .side-container.front .cube-wrapper-price" => 'right: {{SIZE}}{{UNIT}}; left: unset;',
        ],
        'condition'  => [
          'cube_front_price_enable'   => 'yes',
          'cube_front_price_position' => 'right',
        ],
      ]
    );

    $this->add_responsive_control(
      'cube_front_price_left',
      [
        'label'      => esc_html__('Left', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range'      => [
          'px' => [
            'min'  => 6,
            'step' => 1,
            'max'  => 155,
          ],
        ],
        'default'    => [
          'unit' => 'px',
          'size' => 6,
        ],
        'selectors'  => [
          "{{WRAPPER}} .myCube-360 .side-container.front .cube-wrapper-price" => 'left: {{SIZE}}{{UNIT}}; right: unset;',
        ],
        'condition'  => [
          'cube_front_price_enable'   => 'yes',
          'cube_front_price_position' => 'left',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'      => 'background_cube_front_price',
        'types'     => ['classic', 'gradient'],
        'selector'  => '{{WRAPPER}} .myCube-360 .side-container.front .cube-wrapper-price',
        'condition' => [
          'cube_front_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_front_price_color',
      [
        'label'     => esc_html__('Price Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.front .cube-wrapper-price p' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_front_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_front_overlay_enable',
      [
        'label'        => __('Overlay', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'separator'    => 'before',
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'      => 'background_cube_front_overlay',
        'types'     => ['classic', 'gradient'],
        'selector'  => '{{WRAPPER}} .myCube-360 .side-container.front .cube-wrapper-content',
        'condition' => [
          'cube_front_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_front_name_enable',
      [
        'label'        => __('Title', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'condition'    => [
          'cube_front_overlay_enable' => 'yes',
        ],
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_front_name',
      [
        'label'              => __('Title', 'testimonials-carousel-elementor'),
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
        'condition'          => [
          'cube_front_name_enable'    => 'yes',
          'cube_front_overlay_enable' => 'yes',
        ]
      ]
    );

    $this->add_control(
      'cube_front_name_color',
      [
        'label'     => esc_html__('Title Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.front .cube-wrapper-content h1' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_front_name_enable'    => 'yes',
          'cube_front_overlay_enable' => 'yes',
        ]
      ]
    );

    $this->add_control(
      'cube_front_rating_enable',
      [
        'label'        => __('Rating', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'condition'    => [
          'cube_front_overlay_enable' => 'yes',
        ],
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_front_rating',
      [
        'label'              => __('Rating', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::NUMBER,
        'min'                => 0,
        'max'                => 5,
        'step'               => 1,
        'default'            => 4,
        'frontend_available' => true,
        'condition'          => [
          'cube_front_rating_enable'  => 'yes',
          'cube_front_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_front_rating_color',
      [
        'label'     => esc_html__('Rating Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.front .slide-icons .icon-star-full' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_front_rating_enable'  => 'yes',
          'cube_front_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_front_rating_unmarked_color',
      [
        'label'     => esc_html__('Rating Unmarked Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.front .slide-icons .icon-star-empty' => 'color: {{VALUE}}',
        ],
        'condition' => [
          'cube_front_rating_enable'  => 'yes',
          'cube_front_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_front_reviews_enable',
      [
        'label'        => __('Reviews', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'condition'    => [
          'cube_front_overlay_enable' => 'yes',
        ],
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_front_reviews',
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
          'cube_front_reviews_enable' => 'yes',
          'cube_front_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_front_reviews_color',
      [
        'label'     => esc_html__('Reviews Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.front .slide-reviews' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_front_reviews_enable' => 'yes',
          'cube_front_overlay_enable' => 'yes',
        ]
      ]
    );

    $this->add_control(
      'cube_front_content_enable',
      [
        'label'        => __('Content', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'condition'    => [
          'cube_front_overlay_enable' => 'yes',
        ],
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_front_content_color',
      [
        'label'     => esc_html__('Content Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.front .cube-content' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_front_overlay_enable' => 'yes',
          'cube_front_content_enable' => 'yes',
        ]
      ]
    );

    $this->add_control(
      'cube_front_content',
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
          'cube_front_overlay_enable' => 'yes',
          'cube_front_content_enable' => 'yes',
        ]
      ]
    );

    $this->end_controls_section();

    // Side Right
    $this->start_controls_section(
      'cube_right',
      [
        'label' => __('Right', 'testimonials-carousel-elementor'),
      ]
    );

    $this->add_control(
      'cube_right_image',
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

    $this->add_control(
      'cube_right_price_enable',
      [
        'label'        => __('Price', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_right_price',
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
          'cube_right_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_right_price_position',
      [
        'label'     => esc_html__('Price Position', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::CHOOSE,
        'options'   => [
          'left'  => [
            'title' => esc_html__('Left', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-text-align-left',
          ],
          'right' => [
            'title' => esc_html__('Right', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-text-align-right',
          ],
        ],
        'default'   => 'right',
        'condition' => [
          'cube_right_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_responsive_control(
      'cube_right_price_top',
      [
        'label'      => esc_html__('Top', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range'      => [
          'px' => [
            'min'  => 8,
            'step' => 1,
            'max'  => 130,
          ],
        ],
        'default'    => [
          'unit' => 'px',
          'size' => 8,
        ],
        'selectors'  => [
          "{{WRAPPER}} .myCube-360 .side-container.right .cube-wrapper-price" => 'top: {{SIZE}}{{UNIT}};',
        ],
        'condition'  => [
          'cube_right_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_responsive_control(
      'cube_right_price_right',
      [
        'label'      => esc_html__('Right', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range'      => [
          'px' => [
            'min'  => 6,
            'step' => 1,
            'max'  => 155,
          ],
        ],
        'default'    => [
          'unit' => 'px',
          'size' => 6,
        ],
        'selectors'  => [
          "{{WRAPPER}} .myCube-360 .side-container.right .cube-wrapper-price" => 'right: {{SIZE}}{{UNIT}}; left: unset;',
        ],
        'condition'  => [
          'cube_right_price_enable'   => 'yes',
          'cube_right_price_position' => 'right',
        ],
      ]
    );

    $this->add_responsive_control(
      'cube_right_price_left',
      [
        'label'      => esc_html__('Left', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range'      => [
          'px' => [
            'min'  => 6,
            'step' => 1,
            'max'  => 155,
          ],
        ],
        'default'    => [
          'unit' => 'px',
          'size' => 6,
        ],
        'selectors'  => [
          "{{WRAPPER}} .myCube-360 .side-container.right .cube-wrapper-price" => 'left: {{SIZE}}{{UNIT}}; right: unset;',
        ],
        'condition'  => [
          'cube_right_price_enable'   => 'yes',
          'cube_right_price_position' => 'left',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'      => 'background_cube_right_price',
        'types'     => ['classic', 'gradient'],
        'selector'  => '{{WRAPPER}} .myCube-360 .side-container.right .cube-wrapper-price',
        'condition' => [
          'cube_right_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_right_price_color',
      [
        'label'     => esc_html__('Price Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.right .cube-wrapper-price p' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_right_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_right_overlay_enable',
      [
        'label'        => __('Overlay', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'separator'    => 'before',
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'      => 'background_cube_right_overlay',
        'types'     => ['classic', 'gradient'],
        'selector'  => '{{WRAPPER}} .myCube-360 .side-container.right .cube-wrapper-content',
        'condition' => [
          'cube_right_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_right_name_enable',
      [
        'label'        => __('Title', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'condition'    => [
          'cube_right_overlay_enable' => 'yes',
        ],
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_right_name',
      [
        'label'              => __('Title', 'testimonials-carousel-elementor'),
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
        'condition'          => [
          'cube_right_name_enable'    => 'yes',
          'cube_right_overlay_enable' => 'yes',
        ]
      ]
    );

    $this->add_control(
      'cube_right_name_color',
      [
        'label'     => esc_html__('Title Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.right .cube-wrapper-content h1' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_right_name_enable'    => 'yes',
          'cube_right_overlay_enable' => 'yes',
        ]
      ]
    );

    $this->add_control(
      'cube_right_rating_enable',
      [
        'label'        => __('Rating', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'condition'    => [
          'cube_right_overlay_enable' => 'yes',
        ],
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_right_rating',
      [
        'label'              => __('Rating', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::NUMBER,
        'min'                => 0,
        'max'                => 5,
        'step'               => 1,
        'default'            => 4,
        'frontend_available' => true,
        'condition'          => [
          'cube_right_rating_enable'  => 'yes',
          'cube_right_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_right_rating_color',
      [
        'label'     => esc_html__('Rating Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.right .slide-icons .icon-star-full' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_right_rating_enable'  => 'yes',
          'cube_right_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_right_rating_unmarked_color',
      [
        'label'     => esc_html__('Rating Unmarked Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.right .slide-icons .icon-star-empty' => 'color: {{VALUE}}',
        ],
        'condition' => [
          'cube_right_rating_enable'  => 'yes',
          'cube_right_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_right_reviews_enable',
      [
        'label'        => __('Reviews', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'condition'    => [
          'cube_right_overlay_enable' => 'yes',
        ],
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_right_reviews',
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
          'cube_right_reviews_enable' => 'yes',
          'cube_right_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_right_reviews_color',
      [
        'label'     => esc_html__('Reviews Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.right .slide-reviews' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_right_reviews_enable' => 'yes',
          'cube_right_overlay_enable' => 'yes',
        ]
      ]
    );

    $this->add_control(
      'cube_right_content_enable',
      [
        'label'        => __('Content', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'condition'    => [
          'cube_right_overlay_enable' => 'yes',
        ],
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_right_content_color',
      [
        'label'     => esc_html__('Content Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.right .cube-content' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_right_overlay_enable' => 'yes',
          'cube_right_content_enable' => 'yes',
        ]
      ]
    );

    $this->add_control(
      'cube_right_content',
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
          'cube_right_overlay_enable' => 'yes',
          'cube_right_content_enable' => 'yes',
        ]
      ]
    );

    $this->end_controls_section();

    // Side Back
    $this->start_controls_section(
      'cube_back',
      [
        'label' => __('Back', 'testimonials-carousel-elementor'),
      ]
    );

    $this->add_control(
      'cube_back_image',
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

    $this->add_control(
      'cube_back_price_enable',
      [
        'label'        => __('Price', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_back_price',
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
          'cube_back_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_back_price_position',
      [
        'label'     => esc_html__('Price Position', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::CHOOSE,
        'options'   => [
          'left'  => [
            'title' => esc_html__('Left', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-text-align-left',
          ],
          'right' => [
            'title' => esc_html__('Right', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-text-align-right',
          ],
        ],
        'default'   => 'right',
        'condition' => [
          'cube_back_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_responsive_control(
      'cube_back_price_top',
      [
        'label'      => esc_html__('Top', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range'      => [
          'px' => [
            'min'  => 8,
            'step' => 1,
            'max'  => 130,
          ],
        ],
        'default'    => [
          'unit' => 'px',
          'size' => 8,
        ],
        'selectors'  => [
          "{{WRAPPER}} .myCube-360 .side-container.back .cube-wrapper-price" => 'top: {{SIZE}}{{UNIT}};',
        ],
        'condition'  => [
          'cube_back_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_responsive_control(
      'cube_back_price_right',
      [
        'label'      => esc_html__('Right', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range'      => [
          'px' => [
            'min'  => 6,
            'step' => 1,
            'max'  => 155,
          ],
        ],
        'default'    => [
          'unit' => 'px',
          'size' => 6,
        ],
        'selectors'  => [
          "{{WRAPPER}} .myCube-360 .side-container.back .cube-wrapper-price" => 'right: {{SIZE}}{{UNIT}}; left: unset;',
        ],
        'condition'  => [
          'cube_back_price_enable'   => 'yes',
          'cube_back_price_position' => 'right',
        ],
      ]
    );

    $this->add_responsive_control(
      'cube_back_price_left',
      [
        'label'      => esc_html__('Left', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range'      => [
          'px' => [
            'min'  => 6,
            'step' => 1,
            'max'  => 155,
          ],
        ],
        'default'    => [
          'unit' => 'px',
          'size' => 6,
        ],
        'selectors'  => [
          "{{WRAPPER}} .myCube-360 .side-container.back .cube-wrapper-price" => 'left: {{SIZE}}{{UNIT}}; right: unset;',
        ],
        'condition'  => [
          'cube_back_price_enable'   => 'yes',
          'cube_back_price_position' => 'left',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'      => 'background_cube_back_price',
        'types'     => ['classic', 'gradient'],
        'selector'  => '{{WRAPPER}} .myCube-360 .side-container.back .cube-wrapper-price',
        'condition' => [
          'cube_back_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_back_price_color',
      [
        'label'     => esc_html__('Price Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.back .cube-wrapper-price p' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_back_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_back_overlay_enable',
      [
        'label'        => __('Overlay', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'separator'    => 'before',
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'      => 'background_cube_back_overlay',
        'types'     => ['classic', 'gradient'],
        'selector'  => '{{WRAPPER}} .myCube-360 .side-container.back .cube-wrapper-content',
        'condition' => [
          'cube_back_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_back_name_enable',
      [
        'label'        => __('Title', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'condition'    => [
          'cube_back_overlay_enable' => 'yes',
        ],
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_back_name',
      [
        'label'              => __('Title', 'testimonials-carousel-elementor'),
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
        'condition'          => [
          'cube_back_name_enable'    => 'yes',
          'cube_back_overlay_enable' => 'yes',
        ]
      ]
    );

    $this->add_control(
      'cube_back_name_color',
      [
        'label'     => esc_html__('Title Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.back .cube-wrapper-content h1' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_back_name_enable'    => 'yes',
          'cube_back_overlay_enable' => 'yes',
        ]
      ]
    );

    $this->add_control(
      'cube_back_rating_enable',
      [
        'label'        => __('Rating', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'condition'    => [
          'cube_back_overlay_enable' => 'yes',
        ],
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_back_rating',
      [
        'label'              => __('Rating', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::NUMBER,
        'min'                => 0,
        'max'                => 5,
        'step'               => 1,
        'default'            => 4,
        'frontend_available' => true,
        'condition'          => [
          'cube_back_rating_enable'  => 'yes',
          'cube_back_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_back_rating_color',
      [
        'label'     => esc_html__('Rating Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.back .slide-icons .icon-star-full' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_back_rating_enable'  => 'yes',
          'cube_back_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_back_rating_unmarked_color',
      [
        'label'     => esc_html__('Rating Unmarked Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.back .slide-icons .icon-star-empty' => 'color: {{VALUE}}',
        ],
        'condition' => [
          'cube_back_rating_enable'  => 'yes',
          'cube_back_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_back_reviews_enable',
      [
        'label'        => __('Reviews', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'condition'    => [
          'cube_back_overlay_enable' => 'yes',
        ],
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_back_reviews',
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
          'cube_back_reviews_enable' => 'yes',
          'cube_back_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_back_reviews_color',
      [
        'label'     => esc_html__('Reviews Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.back .slide-reviews' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_back_reviews_enable' => 'yes',
          'cube_back_overlay_enable' => 'yes',
        ]
      ]
    );

    $this->add_control(
      'cube_back_content_enable',
      [
        'label'        => __('Content', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'condition'    => [
          'cube_back_overlay_enable' => 'yes',
        ],
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_back_content_color',
      [
        'label'     => esc_html__('Content Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.back .cube-content' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_back_overlay_enable' => 'yes',
          'cube_back_content_enable' => 'yes',
        ]
      ]
    );

    $this->add_control(
      'cube_back_content',
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
          'cube_back_overlay_enable' => 'yes',
          'cube_back_content_enable' => 'yes',
        ]
      ]
    );

    $this->end_controls_section();

    // Side Left
    $this->start_controls_section(
      'cube_left',
      [
        'label' => __('Left', 'testimonials-carousel-elementor'),
      ]
    );

    $this->add_control(
      'cube_left_image',
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

    $this->add_control(
      'cube_left_price_enable',
      [
        'label'        => __('Price', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_left_price',
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
          'cube_left_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_left_price_position',
      [
        'label'     => esc_html__('Price Position', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::CHOOSE,
        'options'   => [
          'left'  => [
            'title' => esc_html__('Left', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-text-align-left',
          ],
          'right' => [
            'title' => esc_html__('Right', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-text-align-right',
          ],
        ],
        'default'   => 'right',
        'condition' => [
          'cube_left_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_responsive_control(
      'cube_left_price_top',
      [
        'label'      => esc_html__('Top', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range'      => [
          'px' => [
            'min'  => 8,
            'step' => 1,
            'max'  => 130,
          ],
        ],
        'default'    => [
          'unit' => 'px',
          'size' => 8,
        ],
        'selectors'  => [
          "{{WRAPPER}} .myCube-360 .side-container.left .cube-wrapper-price" => 'top: {{SIZE}}{{UNIT}};',
        ],
        'condition'  => [
          'cube_left_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_responsive_control(
      'cube_left_price_right',
      [
        'label'      => esc_html__('Right', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range'      => [
          'px' => [
            'min'  => 6,
            'step' => 1,
            'max'  => 155,
          ],
        ],
        'default'    => [
          'unit' => 'px',
          'size' => 6,
        ],
        'selectors'  => [
          "{{WRAPPER}} .myCube-360 .side-container.left .cube-wrapper-price" => 'right: {{SIZE}}{{UNIT}}; left: unset;',
        ],
        'condition'  => [
          'cube_left_price_enable'   => 'yes',
          'cube_left_price_position' => 'right',
        ],
      ]
    );

    $this->add_responsive_control(
      'cube_left_price_left',
      [
        'label'      => esc_html__('Left', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range'      => [
          'px' => [
            'min'  => 6,
            'step' => 1,
            'max'  => 155,
          ],
        ],
        'default'    => [
          'unit' => 'px',
          'size' => 6,
        ],
        'selectors'  => [
          "{{WRAPPER}} .myCube-360 .side-container.left .cube-wrapper-price" => 'left: {{SIZE}}{{UNIT}}; right: unset;',
        ],
        'condition'  => [
          'cube_left_price_enable'   => 'yes',
          'cube_left_price_position' => 'left',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'      => 'background_cube_left_price',
        'types'     => ['classic', 'gradient'],
        'selector'  => '{{WRAPPER}} .myCube-360 .side-container.left .cube-wrapper-price',
        'condition' => [
          'cube_left_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_left_price_color',
      [
        'label'     => esc_html__('Price Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.left .cube-wrapper-price p' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_left_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_left_overlay_enable',
      [
        'label'        => __('Overlay', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'separator'    => 'before',
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'      => 'background_cube_left_overlay',
        'types'     => ['classic', 'gradient'],
        'selector'  => '{{WRAPPER}} .myCube-360 .side-container.left .cube-wrapper-content',
        'condition' => [
          'cube_left_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_left_name_enable',
      [
        'label'        => __('Title', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'condition'    => [
          'cube_left_overlay_enable' => 'yes',
        ],
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_left_name',
      [
        'label'              => __('Title', 'testimonials-carousel-elementor'),
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
        'condition'          => [
          'cube_left_name_enable'    => 'yes',
          'cube_left_overlay_enable' => 'yes',
        ]
      ]
    );

    $this->add_control(
      'cube_left_name_color',
      [
        'label'     => esc_html__('Title Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.left .cube-wrapper-content h1' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_left_name_enable'    => 'yes',
          'cube_left_overlay_enable' => 'yes',
        ]
      ]
    );

    $this->add_control(
      'cube_left_rating_enable',
      [
        'label'        => __('Rating', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'condition'    => [
          'cube_left_overlay_enable' => 'yes',
        ],
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_left_rating',
      [
        'label'              => __('Rating', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::NUMBER,
        'min'                => 0,
        'max'                => 5,
        'step'               => 1,
        'default'            => 4,
        'frontend_available' => true,
        'condition'          => [
          'cube_left_rating_enable'  => 'yes',
          'cube_left_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_left_rating_color',
      [
        'label'     => esc_html__('Rating Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.left .slide-icons .icon-star-full' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_left_rating_enable'  => 'yes',
          'cube_left_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_left_rating_unmarked_color',
      [
        'label'     => esc_html__('Rating Unmarked Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.left .slide-icons .icon-star-empty' => 'color: {{VALUE}}',
        ],
        'condition' => [
          'cube_left_rating_enable'  => 'yes',
          'cube_left_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_left_reviews_enable',
      [
        'label'        => __('Reviews', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'condition'    => [
          'cube_left_overlay_enable' => 'yes',
        ],
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_left_reviews',
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
          'cube_left_reviews_enable' => 'yes',
          'cube_left_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_left_reviews_color',
      [
        'label'     => esc_html__('Reviews Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.left .slide-reviews' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_left_reviews_enable' => 'yes',
          'cube_left_overlay_enable' => 'yes',
        ]
      ]
    );

    $this->add_control(
      'cube_left_content_enable',
      [
        'label'        => __('Content', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'condition'    => [
          'cube_left_overlay_enable' => 'yes',
        ],
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_left_content_color',
      [
        'label'     => esc_html__('Content Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.left .cube-content' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_left_overlay_enable' => 'yes',
          'cube_left_content_enable' => 'yes',
        ]
      ]
    );

    $this->add_control(
      'cube_left_content',
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
          'cube_left_overlay_enable' => 'yes',
          'cube_left_content_enable' => 'yes',
        ]
      ]
    );

    $this->end_controls_section();

    // Side Bottom
    $this->start_controls_section(
      'cube_bottom',
      [
        'label' => __('Bottom', 'testimonials-carousel-elementor'),
      ]
    );

    $this->add_control(
      'cube_bottom_image',
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

    $this->add_control(
      'cube_bottom_price_enable',
      [
        'label'        => __('Price', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_bottom_price',
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
          'cube_bottom_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_bottom_price_position',
      [
        'label'     => esc_html__('Price Position', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::CHOOSE,
        'options'   => [
          'left'  => [
            'title' => esc_html__('Left', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-text-align-left',
          ],
          'right' => [
            'title' => esc_html__('Right', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-text-align-right',
          ],
        ],
        'default'   => 'right',
        'condition' => [
          'cube_bottom_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_responsive_control(
      'cube_bottom_price_top',
      [
        'label'      => esc_html__('Top', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range'      => [
          'px' => [
            'min'  => 8,
            'step' => 1,
            'max'  => 130,
          ],
        ],
        'default'    => [
          'unit' => 'px',
          'size' => 8,
        ],
        'selectors'  => [
          "{{WRAPPER}} .myCube-360 .side-container.bottom .cube-wrapper-price" => 'top: {{SIZE}}{{UNIT}};',
        ],
        'condition'  => [
          'cube_bottom_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_responsive_control(
      'cube_bottom_price_right',
      [
        'label'      => esc_html__('Right', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range'      => [
          'px' => [
            'min'  => 6,
            'step' => 1,
            'max'  => 155,
          ],
        ],
        'default'    => [
          'unit' => 'px',
          'size' => 6,
        ],
        'selectors'  => [
          "{{WRAPPER}} .myCube-360 .side-container.bottom .cube-wrapper-price" => 'right: {{SIZE}}{{UNIT}}; left: unset;',
        ],
        'condition'  => [
          'cube_bottom_price_enable'   => 'yes',
          'cube_bottom_price_position' => 'right',
        ],
      ]
    );

    $this->add_responsive_control(
      'cube_bottom_price_left',
      [
        'label'      => esc_html__('Left', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range'      => [
          'px' => [
            'min'  => 6,
            'step' => 1,
            'max'  => 155,
          ],
        ],
        'default'    => [
          'unit' => 'px',
          'size' => 6,
        ],
        'selectors'  => [
          "{{WRAPPER}} .myCube-360 .side-container.bottom .cube-wrapper-price" => 'left: {{SIZE}}{{UNIT}}; right: unset;',
        ],
        'condition'  => [
          'cube_bottom_price_enable'   => 'yes',
          'cube_bottom_price_position' => 'left',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'      => 'background_cube_bottom_price',
        'types'     => ['classic', 'gradient'],
        'selector'  => '{{WRAPPER}} .myCube-360 .side-container.bottom .cube-wrapper-price',
        'condition' => [
          'cube_bottom_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_bottom_price_color',
      [
        'label'     => esc_html__('Price Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.bottom .cube-wrapper-price p' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_bottom_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_bottom_overlay_enable',
      [
        'label'        => __('Overlay', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'separator'    => 'before',
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'      => 'background_cube_bottom_overlay',
        'types'     => ['classic', 'gradient'],
        'selector'  => '{{WRAPPER}} .myCube-360 .side-container.bottom .cube-wrapper-content',
        'condition' => [
          'cube_bottom_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_bottom_name_enable',
      [
        'label'        => __('Title', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'condition'    => [
          'cube_bottom_overlay_enable' => 'yes',
        ],
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_bottom_name',
      [
        'label'              => __('Title', 'testimonials-carousel-elementor'),
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
        'condition'          => [
          'cube_bottom_name_enable'    => 'yes',
          'cube_bottom_overlay_enable' => 'yes',
        ]
      ]
    );

    $this->add_control(
      'cube_bottom_name_color',
      [
        'label'     => esc_html__('Title Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.bottom .cube-wrapper-content h1' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_bottom_name_enable'    => 'yes',
          'cube_bottom_overlay_enable' => 'yes',
        ]
      ]
    );

    $this->add_control(
      'cube_bottom_rating_enable',
      [
        'label'        => __('Rating', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'condition'    => [
          'cube_bottom_overlay_enable' => 'yes',
        ],
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_bottom_rating',
      [
        'label'              => __('Rating', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::NUMBER,
        'min'                => 0,
        'max'                => 5,
        'step'               => 1,
        'default'            => 4,
        'frontend_available' => true,
        'condition'          => [
          'cube_bottom_rating_enable'  => 'yes',
          'cube_bottom_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_bottom_rating_color',
      [
        'label'     => esc_html__('Rating Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.bottom .slide-icons .icon-star-full' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_bottom_rating_enable'  => 'yes',
          'cube_bottom_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_bottom_rating_unmarked_color',
      [
        'label'     => esc_html__('Rating Unmarked Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.bottom .slide-icons .icon-star-empty' => 'color: {{VALUE}}',
        ],
        'condition' => [
          'cube_bottom_rating_enable'  => 'yes',
          'cube_bottom_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_bottom_reviews_enable',
      [
        'label'        => __('Reviews', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'condition'    => [
          'cube_bottom_overlay_enable' => 'yes',
        ],
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_bottom_reviews',
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
          'cube_bottom_reviews_enable' => 'yes',
          'cube_bottom_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_bottom_reviews_color',
      [
        'label'     => esc_html__('Reviews Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.bottom .slide-reviews' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_bottom_reviews_enable' => 'yes',
          'cube_bottom_overlay_enable' => 'yes',
        ]
      ]
    );

    $this->add_control(
      'cube_bottom_content_enable',
      [
        'label'        => __('Content', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'condition'    => [
          'cube_bottom_overlay_enable' => 'yes',
        ],
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_bottom_content_color',
      [
        'label'     => esc_html__('Content Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.bottom .cube-content' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_bottom_overlay_enable' => 'yes',
          'cube_bottom_content_enable' => 'yes',
        ]
      ]
    );

    $this->add_control(
      'cube_bottom_content',
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
          'cube_bottom_overlay_enable' => 'yes',
          'cube_bottom_content_enable' => 'yes',
        ]
      ]
    );

    $this->end_controls_section();

    // Side Top
    $this->start_controls_section(
      'cube_top',
      [
        'label' => __('Top', 'testimonials-carousel-elementor'),
      ]
    );

    $this->add_control(
      'cube_top_image',
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

    $this->add_control(
      'cube_top_price_enable',
      [
        'label'        => __('Price', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_top_price',
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
          'cube_top_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_top_price_position',
      [
        'label'     => esc_html__('Price Position', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::CHOOSE,
        'options'   => [
          'left'  => [
            'title' => esc_html__('Left', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-text-align-left',
          ],
          'right' => [
            'title' => esc_html__('Right', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-text-align-right',
          ],
        ],
        'default'   => 'right',
        'condition' => [
          'cube_top_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_responsive_control(
      'cube_top_price_top',
      [
        'label'      => esc_html__('Top', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range'      => [
          'px' => [
            'min'  => 8,
            'step' => 1,
            'max'  => 130,
          ],
        ],
        'default'    => [
          'unit' => 'px',
          'size' => 8,
        ],
        'selectors'  => [
          "{{WRAPPER}} .myCube-360 .side-container.top .cube-wrapper-price" => 'top: {{SIZE}}{{UNIT}};',
        ],
        'condition'  => [
          'cube_top_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_responsive_control(
      'cube_top_price_right',
      [
        'label'      => esc_html__('Right', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range'      => [
          'px' => [
            'min'  => 6,
            'step' => 1,
            'max'  => 155,
          ],
        ],
        'default'    => [
          'unit' => 'px',
          'size' => 6,
        ],
        'selectors'  => [
          "{{WRAPPER}} .myCube-360 .side-container.top .cube-wrapper-price" => 'right: {{SIZE}}{{UNIT}}; left: unset;',
        ],
        'condition'  => [
          'cube_top_price_enable'   => 'yes',
          'cube_top_price_position' => 'right',
        ],
      ]
    );

    $this->add_responsive_control(
      'cube_top_price_left',
      [
        'label'      => esc_html__('Left', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range'      => [
          'px' => [
            'min'  => 6,
            'step' => 1,
            'max'  => 155,
          ],
        ],
        'default'    => [
          'unit' => 'px',
          'size' => 6,
        ],
        'selectors'  => [
          "{{WRAPPER}} .myCube-360 .side-container.top .cube-wrapper-price" => 'left: {{SIZE}}{{UNIT}}; right: unset;',
        ],
        'condition'  => [
          'cube_top_price_enable'   => 'yes',
          'cube_top_price_position' => 'left',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'      => 'background_cube_top_price',
        'types'     => ['classic', 'gradient'],
        'selector'  => '{{WRAPPER}} .myCube-360 .side-container.top .cube-wrapper-price',
        'condition' => [
          'cube_top_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_top_price_color',
      [
        'label'     => esc_html__('Price Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.top .cube-wrapper-price p' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_top_price_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_top_overlay_enable',
      [
        'label'        => __('Overlay', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'separator'    => 'before',
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'      => 'background_cube_top_overlay',
        'types'     => ['classic', 'gradient'],
        'selector'  => '{{WRAPPER}} .myCube-360 .side-container.top .cube-wrapper-content',
        'condition' => [
          'cube_top_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_top_name_enable',
      [
        'label'        => __('Title', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'condition'    => [
          'cube_top_overlay_enable' => 'yes',
        ],
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_top_name',
      [
        'label'              => __('Title', 'testimonials-carousel-elementor'),
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
        'condition'          => [
          'cube_top_name_enable'    => 'yes',
          'cube_top_overlay_enable' => 'yes',
        ]
      ]
    );

    $this->add_control(
      'cube_top_name_color',
      [
        'label'     => esc_html__('Title Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.top .cube-wrapper-content h1' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_top_name_enable'    => 'yes',
          'cube_top_overlay_enable' => 'yes',
        ]
      ]
    );

    $this->add_control(
      'cube_top_rating_enable',
      [
        'label'        => __('Rating', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'condition'    => [
          'cube_top_overlay_enable' => 'yes',
        ],
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_top_rating',
      [
        'label'              => __('Rating', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::NUMBER,
        'min'                => 0,
        'max'                => 5,
        'step'               => 1,
        'default'            => 4,
        'frontend_available' => true,
        'condition'          => [
          'cube_top_rating_enable'  => 'yes',
          'cube_top_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_top_rating_color',
      [
        'label'     => esc_html__('Rating Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.top .slide-icons .icon-star-full' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_top_rating_enable'  => 'yes',
          'cube_top_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_top_rating_unmarked_color',
      [
        'label'     => esc_html__('Rating Unmarked Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.top .slide-icons .icon-star-empty' => 'color: {{VALUE}}',
        ],
        'condition' => [
          'cube_top_rating_enable'  => 'yes',
          'cube_top_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_top_reviews_enable',
      [
        'label'        => __('Reviews', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'condition'    => [
          'cube_top_overlay_enable' => 'yes',
        ],
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_top_reviews',
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
          'cube_top_reviews_enable' => 'yes',
          'cube_top_overlay_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'cube_top_reviews_color',
      [
        'label'     => esc_html__('Reviews Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.top .slide-reviews' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_top_reviews_enable' => 'yes',
          'cube_top_overlay_enable' => 'yes',
        ]
      ]
    );

    $this->add_control(
      'cube_top_content_enable',
      [
        'label'        => __('Content', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'condition'    => [
          'cube_top_overlay_enable' => 'yes',
        ],
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'cube_top_content_color',
      [
        'label'     => esc_html__('Content Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .side-container.top .cube-content' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_top_overlay_enable' => 'yes',
          'cube_top_content_enable' => 'yes',
        ]
      ]
    );

    $this->add_control(
      'cube_top_content',
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
          'cube_top_overlay_enable' => 'yes',
          'cube_top_content_enable' => 'yes',
        ]
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
      'cube_start_coordinate_x',
      [
        'label'              => esc_html__('Start Cube X', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::NUMBER,
        'default'            => -23,
        'frontend_available' => true,
      ]
    );

    $this->add_control(
      'cube_start_coordinate_y',
      [
        'label'              => esc_html__('Start Cube Y', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::NUMBER,
        'default'            => 33,
        'frontend_available' => true,
      ]
    );

    $this->add_control(
      'interactive_icon_enable',
      [
        'label'        => __('Interactive Icon', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
      ]
    );

    $this->add_control(
      'enable_price',
      [
        'label'        => __('Price', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
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
      'cursor_grab_enable',
      [
        'label'        => __('Cursor Grab', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('On', 'testimonials-carousel-elementor'),
        'label_off'    => __('Off', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
      ]
    );

    $this->add_control(
      'animation_enable',
      [
        'label'        => __('Animation', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('On', 'testimonials-carousel-elementor'),
        'label_off'    => __('Off', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
      ]
    );

    $this->add_control(
      'animation_rotation_x',
      [
        'label'        => __('Rotation X', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('On', 'testimonials-carousel-elementor'),
        'label_off'    => __('Off', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'condition'    => [
          'animation_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'animation_rotation_y',
      [
        'label'        => __('Rotation Y', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('On', 'testimonials-carousel-elementor'),
        'label_off'    => __('Off', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
        'condition'    => [
          'animation_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'animation_speed',
      [
        'label'              => esc_html__('Animation Speed', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::NUMBER,
        'min'                => 0.1,
        'step'               => 0.1,
        'max'                => 1,
        'default'            => 0.5,
        'frontend_available' => true,
        'condition'          => [
          'animation_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'rotation_speed',
      [
        'label'              => esc_html__('Rotation Speed', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::NUMBER,
        'min'                => 0.1,
        'step'               => 0.1,
        'max'                => 1,
        'default'            => 0.5,
        'frontend_available' => true,
      ]
    );

    $this->end_controls_section();

    // General Section styles
    $this->start_controls_section(
      'general_styles_section',
      [
        'label' => esc_html__('General Section Styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_responsive_control(
      'slider_section_margin',
      [
        'label'      => esc_html__('Margin', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .section-with-cube-carousel' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'slider_section_padding',
      [
        'label'      => esc_html__('Padding', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .section-with-cube-carousel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'     => 'background_section',
        'types'    => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .section-with-cube-carousel',
      ]
    );
    $this->add_responsive_control(
      'slider_section_direction',
      [
        'label'     => esc_html__('Direction', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::CHOOSE,
        'options'   => [
          'row'            => [
            'title' => esc_html__('Row', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-h-align-left',
          ],
          'row-reverse'    => [
            'title' => esc_html__('Row-Reverse', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-h-align-right',
          ],
          'column'         => [
            'title' => esc_html__('Column', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-v-align-top',
          ],
          'column-reverse' => [
            'title' => esc_html__('Column-Reverse', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-v-align-bottom',
          ],
        ],
        'default'   => 'row',
        'selectors' => [
          '{{WRAPPER}} .section-with-cube-carousel__wrapper' => 'flex-direction: {{VALUE}}',
        ],
      ]
    );
    $this->add_responsive_control(
      'slider_content_custom_width',
      [
        'label'      => esc_html__('Width', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'default'    => [
          'unit' => '%',
        ],
        'size_units' => ['%', 'px', 'em', 'rem'],
        'range'      => [
          '%' => [
            'min' => 0,
            'max' => 100,
          ],
        ],
        'selectors'  => [
          '{{WRAPPER}} .section-with-cube-carousel__content' => '--container-widget-max-width: {{SIZE}}{{UNIT}}; --container-widget-flex-grow: 0; max-width: var( --container-widget-max-width, {{SIZE}}{{UNIT}} );',
        ],
      ]
    );
    $this->add_responsive_control(
      'slider_section_space',
      [
        'label'     => esc_html__('Spacing', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SLIDER,
        'range'     => [
          'px' => [
            'min' => 0,
            'max' => 120,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .section-with-cube-carousel__wrapper' => 'gap: {{SIZE}}{{UNIT}}',
        ],
      ]
    );
    $this->end_controls_section();

    // General styles Section
    $this->start_controls_section(
      'cube_styles_section',
      [
        'label' => esc_html__('General Cube Styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_responsive_control(
      'cube_wrapper_margin',
      [
        'label'      => esc_html__('Margin', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .myCube-360' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'cube_wrapper_padding',
      [
        'label'      => esc_html__('Padding', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .myCube-360' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'     => 'background_cube_wrapper',
        'types'    => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .myCube-360',
      ]
    );

    $this->add_responsive_control(
      'cube_wrapper_height',
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
          "{{WRAPPER}} .myCube-360" => 'height: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->end_controls_section();

    // Content styles Section
    $this->start_controls_section(
      'slider_content_styles_section',
      [
        'label' => __('Content Styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );
    $this->add_control(
      'slider_content_name_color',
      [
        'label'     => esc_html__('Name color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .section-with-cube-carousel__content h1' => 'color: {{VALUE}};',
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'slider_content_name_typography',
        'label'    => esc_html__('Name typography', 'testimonials-carousel-elementor'),
        'selector' => '{{WRAPPER}} .section-with-cube-carousel__content h1',
      ]
    );
    $this->add_responsive_control(
      'slider_content_name_align',
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
          '{{WRAPPER}} .section-with-cube-carousel__content h1' => 'text-align: {{VALUE}}',
        ],
      ]
    );

    $this->add_control(
      'slider_content_content_color',
      [
        'label'     => esc_html__('Content color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .section-with-cube-carousel__content p' => 'color: {{VALUE}};',
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'slider_content_content_typography',
        'label'    => esc_html__('Content typography', 'testimonials-carousel-elementor'),
        'selector' => '{{WRAPPER}} .section-with-cube-carousel__content p',
      ]
    );
    $this->add_responsive_control(
      'slider_content_content_align',
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
          '{{WRAPPER}} .section-with-cube-carousel__content p' => 'text-align: {{VALUE}}',
        ],
      ]
    );
    $this->end_controls_section();

    // Cube styles Section
    $this->start_controls_section(
      'cube_body_styles_section',
      [
        'label' => esc_html__('Cube Styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_responsive_control(
      'cube_custom_width',
      [
        'label'      => esc_html__('Width', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['em'],
        'default'    => [
          'unit' => 'em',
        ],
        'range'      => [
          'em' => [
            'step' => 1,
          ],
        ],
        'selectors'  => [
          '{{WRAPPER}} .myCube-360 .cube-container' => 'width: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'cube_height',
      [
        'label'      => esc_html__('Height', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['em'],
        'default'    => [
          'unit' => 'em',
        ],
        'range'      => [
          'em' => [
            'step' => 1,
          ],
        ],
        'selectors'  => [
          "{{WRAPPER}} .myCube-360 .cube-container" => 'height: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'cube_translate_z',
      [
        'label'      => esc_html__('TranslateZ', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['em'],
        'default'    => [
          'unit' => 'em',
        ],
        'range'      => [
          'em' => [
            'step' => 0.1,
          ],
        ],
        'selectors'  => [
          "{{WRAPPER}} .myCube-360 .side-container.front"  => 'transform: translateZ({{SIZE}}{{UNIT}});',
          "{{WRAPPER}} .myCube-360 .side-container.right"  => 'transform: rotateY(90deg) translateZ({{SIZE}}{{UNIT}});',
          "{{WRAPPER}} .myCube-360 .side-container.back"   => 'transform: rotateY(180deg) translateZ({{SIZE}}{{UNIT}});',
          "{{WRAPPER}} .myCube-360 .side-container.left"   => 'transform: rotateY(-90deg) translateZ({{SIZE}}{{UNIT}});',
          "{{WRAPPER}} .myCube-360 .side-container.top"    => 'transform: rotateX(90deg) translateZ({{SIZE}}{{UNIT}});',
          "{{WRAPPER}} .myCube-360 .side-container.bottom" => 'transform: rotateX(-90deg) translateZ({{SIZE}}{{UNIT}});',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'      => 'cube_border',
        'selector'  => '{{WRAPPER}} .myCube-360 .cube-side',
        'separator' => 'before',
      ]
    );

    $this->add_responsive_control(
      'icon_size',
      [
        'label'     => esc_html__('Rating Icon Size', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SLIDER,
        'range'     => [
          'px' => [
            'min' => 5,
            'max' => 30,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .slide-icons i' => 'font-size: {{SIZE}}{{UNIT}}',
        ],
        'separator' => 'before',
      ]
    );

    $this->add_responsive_control(
      'icon_space',
      [
        'label'     => esc_html__('Rating Icon Spacing', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SLIDER,
        'range'     => [
          'px' => [
            'min' => 0,
            'max' => 20,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .slide-icons i' => 'margin-right: {{SIZE}}{{UNIT}}',
        ],
      ]
    );

    $this->add_control(
      'cube_rating_global_enable',
      [
        'label'        => __('Rating Style', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('On', 'testimonials-carousel-elementor'),
        'label_off'    => __('Off', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => '',
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'stars_color',
      [
        'label'     => esc_html__('Rating Icon Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .cube-container .side-container .slide-icons .icon-star-full' => 'color: {{VALUE}}',
        ],
        'condition' => [
          'cube_rating_global_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'stars_unmarked_color',
      [
        'label'     => esc_html__('Rating Unmarked Icon Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .cube-container .side-container .slide-icons .icon-star-empty' => 'color: {{VALUE}}',
        ],
        'condition' => [
          'cube_rating_global_enable' => 'yes',
        ],
      ]
    );
    $this->end_controls_section();

    // Content Cube Styles Section
    $this->start_controls_section(
      'content_styles_section',
      [
        'label' => __('Content Cube Styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'cube_content_global_enable',
      [
        'label'        => __('Global Style', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('On', 'testimonials-carousel-elementor'),
        'label_off'    => __('Off', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => '',
      ]
    );

    $this->add_control(
      'cube_content_name_color',
      [
        'label'     => esc_html__('Title Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .cube-container .side-container .cube-wrapper-content h1' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_content_global_enable' => 'yes',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'cube_name_typography',
        'label'    => esc_html__('Title Typography', 'testimonials-carousel-elementor'),
        'selector' => '{{WRAPPER}} .myCube-360 .side-container .cube-wrapper-content h1',
      ]
    );

    $this->add_responsive_control(
      'cube_name_align',
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
          '{{WRAPPER}} .myCube-360 .side-container .cube-wrapper-content h1' => 'text-align: {{VALUE}}',
        ],
      ]
    );

    $this->add_control(
      'content_cube_color',
      [
        'label'     => esc_html__('Content Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .cube-container .side-container .cube-wrapper-content p' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_content_global_enable' => 'yes',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'cube_content_typography',
        'label'    => esc_html__('Content Typography', 'testimonials-carousel-elementor'),
        'selector' => '{{WRAPPER}} .myCube-360 .side-container .cube-wrapper-content p',
      ]
    );

    $this->add_responsive_control(
      'cube_content_align',
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
          '{{WRAPPER}} .myCube-360 .side-container .cube-wrapper-content p' => 'text-align: {{VALUE}}',
        ],
      ]
    );

    $this->add_control(
      'reviews_cube_color',
      [
        'label'     => esc_html__('Review Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .cube-container .side-container .slide-reviews' => 'color: {{VALUE}};',
        ],
        'condition' => [
          'cube_content_global_enable' => 'yes',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'cube_reviews_typography',
        'label'    => esc_html__('Review Typography', 'testimonials-carousel-elementor'),
        'selector' => '{{WRAPPER}} .myCube-360 .side-container .slide-reviews',
      ]
    );

    $this->end_controls_section();

    // Overlay styles Section
    $this->start_controls_section(
      'cube_overlay_section',
      [
        'label' => __('Overlay Styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'cube_overlay_bg_enable',
      [
        'label'        => __('Overlay Background', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('On', 'testimonials-carousel-elementor'),
        'label_off'    => __('Off', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => '',
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'      => 'background_overlay_cube',
        'types'     => ['classic', 'gradient'],
        'selector'  => '{{WRAPPER}} .myCube-360 .cube-container .side-container .cube-wrapper-content',
        'condition' => [
          'cube_overlay_bg_enable' => 'yes',
        ]
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'      => 'cube_overlay_border',
        'selector'  => '{{WRAPPER}} .myCube-360 .side-container .cube-wrapper-content',
        'separator' => 'before',
      ]
    );

    $this->end_controls_section();

    // Price styles Section
    $this->start_controls_section(
      'cube_price_section',
      [
        'label' => __('Price Styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'cube_change_position_enable',
      [
        'label'        => __('Price Position', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('On', 'testimonials-carousel-elementor'),
        'label_off'    => __('Off', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => '',
      ]
    );

    $this->add_control(
      'price_cube_position',
      [
        'label'     => esc_html__('Price Style', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::CHOOSE,
        'options'   => [
          'left'  => [
            'title' => esc_html__('Left', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-text-align-left',
          ],
          'right' => [
            'title' => esc_html__('Right', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-text-align-right',
          ],
        ],
        'default'   => 'right',
        'condition' => [
          'cube_change_position_enable' => 'yes',
        ]
      ]
    );

    $this->add_responsive_control(
      'cube_price_top',
      [
        'label'      => esc_html__('Top', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range'      => [
          'px' => [
            'min'  => 8,
            'step' => 1,
            'max'  => 130,
          ],
        ],
        'default'    => [
          'unit' => 'px',
          'size' => 8,
        ],
        'selectors'  => [
          "{{WRAPPER}} .myCube-360 .cube-container .side-container .cube-wrapper-price" => 'top: {{SIZE}}{{UNIT}};',
        ],
        'condition'  => [
          'cube_change_position_enable' => 'yes',
        ],
      ]
    );

    $this->add_responsive_control(
      'cube_price_right',
      [
        'label'      => esc_html__('Right', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range'      => [
          'px' => [
            'min'  => 6,
            'step' => 1,
            'max'  => 155,
          ],
        ],
        'default'    => [
          'unit' => 'px',
          'size' => 6,
        ],
        'selectors'  => [
          "{{WRAPPER}} .myCube-360 .cube-container .side-container .cube-wrapper-price" => 'right: {{SIZE}}{{UNIT}}; left: unset;',
        ],
        'condition'  => [
          'price_cube_position'         => 'right',
          'cube_change_position_enable' => 'yes',
        ],
      ]
    );

    $this->add_responsive_control(
      'price_cube_left',
      [
        'label'      => esc_html__('Left', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range'      => [
          'px' => [
            'min'  => 6,
            'step' => 1,
            'max'  => 155,
          ],
        ],
        'default'    => [
          'unit' => 'px',
          'size' => 6,
        ],
        'selectors'  => [
          "{{WRAPPER}} .myCube-360 .cube-container .side-container .cube-wrapper-price" => 'left: {{SIZE}}{{UNIT}}; right: unset;',
        ],
        'condition'  => [
          'price_cube_position'         => 'left',
          'cube_change_position_enable' => 'yes',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'      => 'background_price_cube',
        'types'     => ['classic', 'gradient'],
        'selector'  => '{{WRAPPER}} .myCube-360 .cube-container .side-container .cube-wrapper-price',
        'condition' => [
          'cube_change_position_enable' => 'yes',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'      => 'cube_price_border',
        'selector'  => '{{WRAPPER}} .myCube-360 .side-container .cube-wrapper-price',
        'separator' => 'before',
      ]
    );

    $this->add_responsive_control(
      'cube_price_border_radius',
      [
        'label'      => esc_html__('Border Radius', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .myCube-360 .side-container .cube-wrapper-price' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Box_Shadow::get_type(),
      [
        'name'     => 'cube_box_shadow_price',
        'selector' => '{{WRAPPER}} .myCube-360 .side-container .cube-wrapper-price',
      ]
    );

    $this->add_control(
      'price_color_cube',
      [
        'label'     => esc_html__('Price Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myCube-360 .cube-container .side-container .cube-wrapper-price p' => 'color: {{VALUE}};',
        ],
        'separator' => 'before',
        'condition' => [
          'cube_change_position_enable' => 'yes',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'cube_price_typography',
        'label'    => esc_html__('Price Typography', 'testimonials-carousel-elementor'),
        'selector' => '{{WRAPPER}} .myCube-360 .side-container .cube-wrapper-price p',
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
          'class'                            => ['slider-params'],
          'data-startcoordinatex-myswiper'   => esc_attr($settings['cube_start_coordinate_x']),
          'data-startcoordinatey-myswiper'   => esc_attr($settings['cube_start_coordinate_y']),
          'data-animationenable-myswiper'    => esc_attr($settings['animation_enable']),
          'data-animationrotationx-myswiper' => esc_attr($settings['animation_rotation_x']),
          'data-animationrotationy-myswiper' => esc_attr($settings['animation_rotation_y']),
          'data-animationspeed-myswiper'     => esc_attr($settings['animation_speed']),
          'data-rotationspeed-myswiper'      => esc_attr($settings['rotation_speed']),
          'data-cursorgrabenable-myswiper'   => esc_attr($settings['cursor_grab_enable']),
        ]
      );
    }

    if (get_plugin_data(ELEMENTOR__FILE__)['Version'] < "3.5.0") { ?>
      <div <?php echo $this->get_render_attribute_string('my_swiper'); ?>></div>
    <?php } ?>

    <section class="section-with-cube-carousel">
      <div class="section-with-cube-carousel__container">
        <div class="section-with-cube-carousel__wrapper">
          <div class="section-with-cube-carousel__content">
            <h1><?php echo wp_kses_post($settings['section_content_name']); ?></h1>

            <?php echo wp_kses_post($settings['section_content_text']); ?>
          </div>

          <div class="mySwiper myCube-360">
            <div class="cube-container">
              <?php if ($settings['interactive_icon_enable'] === 'yes') { ?>
                <svg class="cube-interactive" width="40" height="40" viewBox="0 0 40 40" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                  <path
                      d="M4.14177 16.9961L3.57089 16.4252C3.25559 16.7405 3.25559 17.2517 3.57089 17.567L4.14177 16.9961ZM9.85064 17.8033C10.0623 17.7996 10.264 17.713 10.4124 17.562C10.5608 17.411 10.644 17.2078 10.644 16.9961C10.644 16.7844 10.5608 16.5812 10.4124 16.4302C10.264 16.2792 10.0623 16.1925 9.85064 16.1889L9.85064 17.8033ZM7.56709 20.4214C7.88238 20.1061 7.88238 19.5949 7.56709 19.2796L5.52002 17.2326C5.00307 16.7156 4.30195 16.4252 3.57089 16.4252L3.57089 17.567L6.42532 20.4214C6.74061 20.7367 7.2518 20.7367 7.56709 20.4214ZM3.57089 16.4252C4.20147 17.0558 5.22385 17.0558 5.85443 16.4252L7.56709 14.7125C7.88238 14.3973 7.88238 13.8861 7.56709 13.5708C7.2518 13.2555 6.74061 13.2555 6.42532 13.5708L3.57089 16.4252ZM4.14177 16.9961C4.14177 17.4419 4.50318 17.8033 4.94901 17.8033H9.85064L9.85064 16.1889L4.94901 16.1889C4.50318 16.1889 4.14177 16.5503 4.14177 16.9961Z"
                      fill="black" fill-opacity="0.6"/>
                  <path
                      d="M29.58 16.4302C29.7284 16.2792 29.9301 16.1925 30.1418 16.1889L33.9016 16.1889L32.4253 14.7125C32.11 14.3973 32.11 13.8861 32.4253 13.5708C32.7406 13.2555 33.2518 13.2555 33.5671 13.5708L36.4215 16.4252C36.7368 16.7405 36.7368 17.2517 36.4215 17.567L33.5671 20.4214C33.2518 20.7367 32.7406 20.7367 32.4253 20.4214C32.11 20.1061 32.11 19.5949 32.4253 19.2796L33.9016 17.8033L30.1418 17.8033C29.9301 17.7996 29.7284 17.713 29.58 17.562C29.4316 17.411 29.3484 17.2078 29.3484 16.9961C29.3484 16.7844 29.4316 16.5812 29.58 16.4302Z"
                      fill="black" fill-opacity="0.6"/>
                  <path class="animated-icons"
                        d="M24.9124 29.4746H24.796V28.7374C24.796 28.4469 24.8497 28.1607 24.9572 27.8918L25.8663 25.6109C25.9738 25.3421 26.0275 25.0559 26.0275 24.7654V22.3327C26.0275 21.7386 25.5304 21.2573 24.9169 21.2573C24.3034 21.2573 23.8063 21.7386 23.8063 22.3327V21.1576C23.8063 20.5635 23.3092 20.0821 22.6957 20.0821C22.0821 20.0821 21.5851 20.5635 21.5851 21.1576V20.0995C21.5851 19.5054 21.088 19.0241 20.4744 19.0241C19.8609 19.0241 19.3638 19.5054 19.3638 20.0995V16.0754C19.3638 15.4813 18.8668 15 18.2532 15C17.6397 15 17.1426 15.4813 17.1426 16.0754V23.2173V23.8157L15.8977 22.6102C15.4633 22.1896 14.7602 22.1896 14.3258 22.6102C13.8914 23.0308 13.8914 23.7116 14.3258 24.1323L17.5233 27.636C17.9129 28.0653 18.1323 28.616 18.1323 29.1884V29.4746H18.0472C17.38 29.4746 16.8336 29.9993 16.8336 30.6497V31.8249C16.8336 32.4753 17.3755 33 18.0472 33H24.9169C25.5886 33 26.1305 32.4753 26.1305 31.8249V30.6497C26.126 29.9993 25.5797 29.4746 24.9124 29.4746Z"
                        fill="black" fill-opacity="0.6"/>
                  <path
                      d="M19.9962 2.14177L20.5671 1.57089C20.2518 1.25559 19.7406 1.25559 19.4253 1.57089L19.9962 2.14177ZM19.189 7.85064C19.1927 8.0623 19.2793 8.26405 19.4303 8.41243C19.5813 8.56082 19.7845 8.64396 19.9962 8.64396C20.2079 8.64396 20.4111 8.56082 20.5621 8.41243C20.7131 8.26405 20.7998 8.0623 20.8034 7.85064L19.189 7.85064ZM16.5709 5.56709C16.8862 5.88238 17.3974 5.88238 17.7127 5.56709L19.7597 3.52002C20.2767 3.00307 20.5671 2.30195 20.5671 1.57089L19.4253 1.57089L16.5709 4.42532C16.2556 4.74061 16.2556 5.2518 16.5709 5.56709ZM20.5671 1.57089C19.9365 2.20147 19.9365 3.22385 20.5671 3.85443L22.2798 5.56709C22.5951 5.88238 23.1062 5.88238 23.4215 5.56709C23.7368 5.2518 23.7368 4.74061 23.4215 4.42532L20.5671 1.57089ZM19.9962 2.14177C19.5504 2.14177 19.189 2.50318 19.189 2.94901V7.85064L20.8034 7.85064L20.8034 2.94901C20.8034 2.50318 20.442 2.14177 19.9962 2.14177Z"
                      fill="black" fill-opacity="0.6"/>
                </svg>
              <?php } ?>

              <div class="cube">
                <div class="side-container front">
                  <div class="cube-side"
                       style="background-image: url('<?php echo esc_url($settings['cube_front_image']['url']); ?>');">
                    <?php if ($settings['cube_front_price_enable'] === 'yes' && $settings['enable_price'] === 'yes') { ?>
                      <div class="cube-wrapper-price">
                        <p><?php echo wp_kses($settings['cube_front_price'], []); ?></p>
                      </div>
                    <?php }

                    if ($settings['cube_front_overlay_enable'] === 'yes' && $settings['overlay_enable'] === 'yes') { ?>
                      <div class="cube-wrapper-content">
                        <?php if ($settings['cube_front_name_enable'] === 'yes') { ?>
                          <h1><?php echo wp_kses($settings['cube_front_name'], []); ?></h1>
                        <?php }

                        if ($settings['cube_front_content_enable'] === 'yes') { ?>
                          <div class="cube-content">
                            <?php echo wp_kses_post($settings['cube_front_content']); ?>
                          </div>
                        <?php } ?>

                        <?php if ($settings['cube_front_rating_enable'] === 'yes') { ?>
                          <div class="slide-icons ratings">
                            <div class="stars">
                              <?php
                              for ($i = 0; $i < $settings['cube_front_rating']; $i++) { ?>
                                <i class="icon-star-full star"></i>
                              <?php }
                              for ($i = 0; $i < (5 - $settings['cube_front_rating']); $i++) { ?>
                                <i class="icon-star-empty"></i>
                              <?php } ?>
                            </div>

                            <?php if ($settings['cube_front_reviews_enable'] === 'yes') { ?>
                              <span
                                  class="slide-reviews"><?php echo wp_kses($settings['cube_front_reviews'], []); ?></span>
                            <?php } ?>
                          </div>
                        <?php } ?>
                      </div>
                    <?php } ?>
                  </div>
                </div>
                <div class="side-container right">
                  <div class="cube-side"
                       style="background-image: url('<?php echo esc_url($settings['cube_right_image']['url']); ?>');">
                    <?php if ($settings['cube_right_price_enable'] === 'yes' && $settings['enable_price'] === 'yes') { ?>
                      <div class="cube-wrapper-price">
                        <p><?php echo wp_kses($settings['cube_right_price'], []); ?></p>
                      </div>
                    <?php }

                    if ($settings['cube_right_overlay_enable'] === 'yes' && $settings['overlay_enable'] === 'yes') { ?>
                      <div class="cube-wrapper-content">
                        <?php if ($settings['cube_right_name_enable'] === 'yes') { ?>
                          <h1><?php echo wp_kses($settings['cube_right_name'], []); ?></h1>
                        <?php }

                        if ($settings['cube_right_content_enable'] === 'yes') { ?>
                          <div class="cube-content">
                            <?php echo wp_kses_post($settings['cube_right_content']); ?>
                          </div>
                        <?php } ?>

                        <?php if ($settings['cube_right_rating_enable'] === 'yes') { ?>
                          <div class="slide-icons ratings">
                            <div class="stars">
                              <?php
                              for ($i = 0; $i < $settings['cube_right_rating']; $i++) { ?>
                                <i class="icon-star-full star"></i>
                              <?php }
                              for ($i = 0; $i < (5 - $settings['cube_right_rating']); $i++) { ?>
                                <i class="icon-star-empty"></i>
                              <?php } ?>
                            </div>

                            <?php if ($settings['cube_right_reviews_enable'] === 'yes') { ?>
                              <span
                                  class="slide-reviews"><?php echo wp_kses($settings['cube_right_reviews'], []); ?></span>
                            <?php } ?>
                          </div>
                        <?php } ?>
                      </div>
                    <?php } ?>
                  </div>
                </div>
                <div class="side-container back">
                  <div class="cube-side"
                       style="background-image: url('<?php echo esc_url($settings['cube_back_image']['url']); ?>');">
                    <?php if ($settings['cube_back_price_enable'] === 'yes' && $settings['enable_price'] === 'yes') { ?>
                      <div class="cube-wrapper-price">
                        <p><?php echo wp_kses($settings['cube_back_price'], []); ?></p>
                      </div>
                    <?php }

                    if ($settings['cube_back_overlay_enable'] === 'yes' && $settings['overlay_enable'] === 'yes') { ?>
                      <div class="cube-wrapper-content">
                        <?php if ($settings['cube_back_name_enable'] === 'yes') { ?>
                          <h1><?php echo wp_kses($settings['cube_back_name'], []); ?></h1>
                        <?php }

                        if ($settings['cube_back_content_enable'] === 'yes') { ?>
                          <div class="cube-content">
                            <?php echo wp_kses_post($settings['cube_back_content']); ?>
                          </div>
                        <?php } ?>

                        <?php if ($settings['cube_back_rating_enable'] === 'yes') { ?>
                          <div class="slide-icons ratings">
                            <div class="stars">
                              <?php
                              for ($i = 0; $i < $settings['cube_back_rating']; $i++) { ?>
                                <i class="icon-star-full star"></i>
                              <?php }
                              for ($i = 0; $i < (5 - $settings['cube_back_rating']); $i++) { ?>
                                <i class="icon-star-empty"></i>
                              <?php } ?>
                            </div>

                            <?php if ($settings['cube_back_reviews_enable'] === 'yes') { ?>
                              <span
                                  class="slide-reviews"><?php echo wp_kses($settings['cube_back_reviews'], []); ?></span>
                            <?php } ?>
                          </div>
                        <?php } ?>
                      </div>
                    <?php } ?>
                  </div>
                </div>
                <div class="side-container left">
                  <div class="cube-side"
                       style="background-image: url('<?php echo esc_url($settings['cube_left_image']['url']); ?>');">
                    <?php if ($settings['cube_left_price_enable'] === 'yes' && $settings['enable_price'] === 'yes') { ?>
                      <div class="cube-wrapper-price">
                        <p><?php echo wp_kses($settings['cube_left_price'], []); ?></p>
                      </div>
                    <?php }

                    if ($settings['cube_left_overlay_enable'] === 'yes' && $settings['overlay_enable'] === 'yes') { ?>
                      <div class="cube-wrapper-content">
                        <?php if ($settings['cube_left_name_enable'] === 'yes') { ?>
                          <h1><?php echo wp_kses($settings['cube_left_name'], []); ?></h1>
                        <?php }

                        if ($settings['cube_left_content_enable'] === 'yes') { ?>
                          <div class="cube-content">
                            <?php echo wp_kses_post($settings['cube_left_content']); ?>
                          </div>
                        <?php } ?>

                        <?php if ($settings['cube_left_rating_enable'] === 'yes') { ?>
                          <div class="slide-icons ratings">
                            <div class="stars">
                              <?php
                              for ($i = 0; $i < $settings['cube_left_rating']; $i++) { ?>
                                <i class="icon-star-full star"></i>
                              <?php }
                              for ($i = 0; $i < (5 - $settings['cube_left_rating']); $i++) { ?>
                                <i class="icon-star-empty"></i>
                              <?php } ?>
                            </div>

                            <?php if ($settings['cube_left_reviews_enable'] === 'yes') { ?>
                              <span
                                  class="slide-reviews"><?php echo wp_kses($settings['cube_left_reviews'], []); ?></span>
                            <?php } ?>
                          </div>
                        <?php } ?>
                      </div>
                    <?php } ?>
                  </div>
                </div>
                <div class="side-container bottom">
                  <div class="cube-side"
                       style="background-image: url('<?php echo esc_url($settings['cube_bottom_image']['url']); ?>');">
                    <?php if ($settings['cube_bottom_price_enable'] === 'yes' && $settings['enable_price'] === 'yes') { ?>
                      <div class="cube-wrapper-price">
                        <p><?php echo wp_kses($settings['cube_bottom_price'], []); ?></p>
                      </div>
                    <?php }

                    if ($settings['cube_bottom_overlay_enable'] === 'yes' && $settings['overlay_enable'] === 'yes') { ?>
                      <div class="cube-wrapper-content">
                        <?php if ($settings['cube_bottom_name_enable'] === 'yes') { ?>
                          <h1><?php echo wp_kses($settings['cube_bottom_name'], []); ?></h1>
                        <?php }

                        if ($settings['cube_bottom_content_enable'] === 'yes') { ?>
                          <div class="cube-content">
                            <?php echo wp_kses_post($settings['cube_bottom_content']); ?>
                          </div>
                        <?php } ?>

                        <?php if ($settings['cube_bottom_rating_enable'] === 'yes') { ?>
                          <div class="slide-icons ratings">
                            <div class="stars">
                              <?php
                              for ($i = 0; $i < $settings['cube_bottom_rating']; $i++) { ?>
                                <i class="icon-star-full star"></i>
                              <?php }
                              for ($i = 0; $i < (5 - $settings['cube_bottom_rating']); $i++) { ?>
                                <i class="icon-star-empty"></i>
                              <?php } ?>
                            </div>

                            <?php if ($settings['cube_bottom_reviews_enable'] === 'yes') { ?>
                              <span
                                  class="slide-reviews"><?php echo wp_kses($settings['cube_bottom_reviews'], []); ?></span>
                            <?php } ?>
                          </div>
                        <?php } ?>
                      </div>
                    <?php } ?>
                  </div>
                </div>
                <div class="side-container top">
                  <div class="cube-side"
                       style="background-image: url('<?php echo esc_url($settings['cube_top_image']['url']); ?>');">
                    <?php if ($settings['cube_top_price_enable'] === 'yes' && $settings['enable_price'] === 'yes') { ?>
                      <div class="cube-wrapper-price">
                        <p><?php echo wp_kses($settings['cube_top_price'], []); ?></p>
                      </div>
                    <?php }

                    if ($settings['cube_top_overlay_enable'] === 'yes' && $settings['overlay_enable'] === 'yes') { ?>
                      <div class="cube-wrapper-content">
                        <?php if ($settings['cube_top_name_enable'] === 'yes') { ?>
                          <h1><?php echo wp_kses($settings['cube_top_name'], []); ?></h1>
                        <?php }

                        if ($settings['cube_top_content_enable'] === 'yes') { ?>
                          <div class="cube-content">
                            <?php echo wp_kses_post($settings['cube_top_content']); ?>
                          </div>
                        <?php } ?>

                        <?php if ($settings['cube_top_rating_enable'] === 'yes') { ?>
                          <div class="slide-icons ratings">
                            <div class="stars">
                              <?php
                              for ($i = 0; $i < $settings['cube_top_rating']; $i++) { ?>
                                <i class="icon-star-full star"></i>
                              <?php }
                              for ($i = 0; $i < (5 - $settings['cube_top_rating']); $i++) { ?>
                                <i class="icon-star-empty"></i>
                              <?php } ?>
                            </div>

                            <?php if ($settings['cube_top_reviews_enable'] === 'yes') { ?>
                              <span
                                  class="slide-reviews"><?php echo wp_kses($settings['cube_top_reviews'], []); ?></span>
                            <?php } ?>
                          </div>
                        <?php } ?>
                      </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  <?php }
}
