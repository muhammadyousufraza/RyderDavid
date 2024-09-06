<?php
/**
 * TestimonialsCarousel_Employees class.
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
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Security Note: Blocks direct access to the plugin PHP files.
defined('ABSPATH') || die();

/**
 * TestimonialsCarousel_Employees widget class.
 *
 * @since 11.2.0
 */
class TestimonialsCarousel_Employees extends Widget_Base
{
  /**
   * TestimonialsCarousel_Employees constructor.
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
    wp_register_style('testimonials-carousel-employees', plugins_url('/assets/css/testimonials-carousel-employees.min.css', TESTIMONIALS_CAROUSEL_ELEMENTOR), [], TESTIMONIALS_VERSION);
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
    return 'testimonials-carousel-employees';
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
    return __('Testimonial Carousel with Employees', 'testimonials-carousel-elementor');
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
    return 'icon-carousel-employees';
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
    return ['testimonials_carousel'];
  }

  /**
   * Enqueue styles.
   */
  public function get_style_depends()
  {
    $styles = ['swiper', 'elementor-icons-fa-brands', 'testimonials-carousel-employees', 'testimonials-carousel'];

    return $styles;
  }

  public function get_script_depends()
  {
    $scripts = ['swiper', 'testimonials-carousel-widget-handler'];

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
      'slide_image'   => [
        'url' => plugins_url('/assets/images/employees-placeholder-icon.png', TESTIMONIALS_CAROUSEL_ELEMENTOR),
      ],
      'slide_name'    => __('John Doe', 'testimonials-carousel-elementor'),
      'slide_role'    => __('Manager', 'testimonials-carousel-elementor'),
      'social_icon_1' => [
        'value'   => 'fab fa-facebook',
        'library' => 'fa-solid',
      ],
      'social_icon_2' => [
        'value'   => 'fab fa-twitter',
        'library' => 'fa-solid',
      ],
      'social_icon_3' => [
        'value'   => 'fab fa-linkedin-in',
        'library' => 'fa-solid',
      ],
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
        'label'   => __('Choose Image', 'testimonials-carousel-elementor'),
        'type'    => Controls_Manager::MEDIA,
        'default' => [
          'url' => plugins_url('/assets/images/employees-placeholder-icon.png', TESTIMONIALS_CAROUSEL_ELEMENTOR),
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
        'default'            => __('John Doe', 'testimonials-carousel-elementor'),
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
      'slide_role',
      [
        'label'              => __('Role', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::TEXT,
        'default'            => __('Manager', 'testimonials-carousel-elementor'),
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
      'slide_rating_enable',
      [
        'label'        => __('Rating', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
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
          'slide_rating_enable' => 'yes',
        ],
      ]
    );
    $repeater->add_control(
      'slide_social_enable',
      [
        'label'        => __('Social', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
      ]
    );

    $social_number = range(1, 5);
    $social_number = array_combine($social_number, $social_number);

    $repeater->add_responsive_control(
      'social_to_show',
      [
        'label'     => esc_html__('Social Link To Show', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SELECT,
        'default'   => '3',
        'options'   => $social_number,
        'condition' => [
          'slide_social_enable' => 'yes',
        ],
      ]
    );
    $repeater->add_control(
      'social_icon_1',
      [
        'label'     => __('<span>First Social</span><br><br>Icon', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::ICONS,
        'default'   => [
          'value'   => 'fab fa-facebook',
          'library' => 'fa-solid',
        ],
        'condition' => [
          'social_to_show'      => ['1', '2', '3', '4', '5'],
          'slide_social_enable' => 'yes',
        ],
      ]
    );
    $repeater->add_control(
      'social_link_1',
      [
        'label'       => esc_html__('Social Link', 'testimonials-carousel-elementor'),
        'type'        => Controls_Manager::URL,
        'placeholder' => esc_html__('https://your-link.com', 'testimonials-carousel-elementor'),
        'condition'   => [
          'social_to_show'      => ['1', '2', '3', '4', '5'],
          'slide_social_enable' => 'yes',
        ],
      ]
    );
    $repeater->add_control(
      'social_icon_2',
      [
        'label'     => __('<span>Second Social</span><br><br>Icon', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::ICONS,
        'default'   => [
          'value'   => 'fab fa-twitter',
          'library' => 'fa-solid',
        ],
        'condition' => [
          'social_to_show'      => ['2', '3', '4', '5'],
          'slide_social_enable' => 'yes',
        ],
      ]
    );
    $repeater->add_control(
      'social_link_2',
      [
        'label'       => esc_html__('Social Link', 'testimonials-carousel-elementor'),
        'type'        => Controls_Manager::URL,
        'placeholder' => esc_html__('https://your-link.com', 'testimonials-carousel-elementor'),
        'condition'   => [
          'social_to_show'      => ['2', '3', '4', '5'],
          'slide_social_enable' => 'yes',
        ],
      ]
    );
    $repeater->add_control(
      'social_icon_3',
      [
        'label'     => __('<span>Third Social</span><br><br>Icon', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::ICONS,
        'default'   => [
          'value'   => 'fab fa-linkedin-in',
          'library' => 'fa-solid',
        ],
        'condition' => [
          'social_to_show'      => ['3', '4', '5'],
          'slide_social_enable' => 'yes',
        ],
      ]
    );
    $repeater->add_control(
      'social_link_3',
      [
        'label'       => esc_html__('Social Link', 'testimonials-carousel-elementor'),
        'type'        => Controls_Manager::URL,
        'placeholder' => esc_html__('https://your-link.com', 'testimonials-carousel-elementor'),
        'condition'   => [
          'social_to_show'      => ['3', '4', '5'],
          'slide_social_enable' => 'yes',
        ],
      ]
    );
    $repeater->add_control(
      'social_icon_4',
      [
        'label'     => __('<span>Fourth Social</span><br><br>Icon', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::ICONS,
        'default'   => [
          'value'   => 'fab fa-instagram',
          'library' => 'fa-solid',
        ],
        'condition' => [
          'social_to_show'      => ['4', '5'],
          'slide_social_enable' => 'yes',
        ],
      ]
    );
    $repeater->add_control(
      'social_link_4',
      [
        'label'       => esc_html__('Social Link', 'testimonials-carousel-elementor'),
        'type'        => Controls_Manager::URL,
        'placeholder' => esc_html__('https://your-link.com', 'testimonials-carousel-elementor'),
        'condition'   => [
          'social_to_show'      => ['4', '5'],
          'slide_social_enable' => 'yes',
        ],
      ]
    );
    $repeater->add_control(
      'social_icon_5',
      [
        'label'     => __('<span>Fifth Social</span><br><br>Icon', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::ICONS,
        'default'   => [
          'value'   => 'fab fa-github',
          'library' => 'fa-solid',
        ],
        'condition' => [
          'social_to_show'      => '5',
          'slide_social_enable' => 'yes',
        ],
      ]
    );
    $repeater->add_control(
      'social_link_5',
      [
        'label'       => esc_html__('Social Link', 'testimonials-carousel-elementor'),
        'type'        => Controls_Manager::URL,
        'placeholder' => esc_html__('https://your-link.com', 'testimonials-carousel-elementor'),
        'condition'   => [
          'social_to_show'      => '5',
          'slide_social_enable' => 'yes',
        ],
      ]
    );
    $repeater->add_control(
      'slide_button_enable',
      [
        'label'        => __('Button', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
      ]
    );

    $social_number = range(1, 2);
    $social_number = array_combine($social_number, $social_number);

    $repeater->add_responsive_control(
      'slide_button_to_show',
      [
        'label'     => esc_html__('Button To Show', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SELECT,
        'default'   => '2',
        'options'   => $social_number,
        'condition' => [
          'slide_button_enable' => 'yes',
        ],
      ]
    );
    $repeater->add_control(
      'slide_button_1',
      [
        'label'     => __('<span>First Button</span>', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::TEXT,
        'dynamic'   => [
          'active' => true,
        ],
        'default'   => esc_html__('About Me', 'testimonials-carousel-elementor'),
        'separator' => 'before',
        'ai'        => [
          'active' => false,
        ],
        'condition' => [
          'slide_button_to_show' => ['1', '2'],
          'slide_button_enable'  => 'yes',
        ],
      ]
    );
    $repeater->add_control(
      'slide_button_link_1',
      [
        'label'       => esc_html__('Link', 'testimonials-carousel-elementor'),
        'type'        => Controls_Manager::URL,
        'placeholder' => esc_html__('https://your-link.com', 'testimonials-carousel-elementor'),
        'condition'   => [
          'slide_button_to_show' => ['1', '2'],
          'slide_button_enable'  => 'yes',
        ],
      ]
    );
    $repeater->add_control(
      'slide_button_2',
      [
        'label'     => __('<span>Second Button</span>', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::TEXT,
        'dynamic'   => [
          'active' => true,
        ],
        'default'   => esc_html__('Hire Me', 'testimonials-carousel-elementor'),
        'separator' => 'before',
        'ai'        => [
          'active' => false,
        ],
        'condition' => [
          'slide_button_to_show' => '2',
          'slide_button_enable'  => 'yes',
        ],
      ]
    );
    $repeater->add_control(
      'slide_button_link_2',
      [
        'label'       => esc_html__('Link', 'testimonials-carousel-elementor'),
        'type'        => Controls_Manager::URL,
        'placeholder' => esc_html__('https://your-link.com', 'testimonials-carousel-elementor'),
        'condition'   => [
          'slide_button_to_show' => '2',
          'slide_button_enable'  => 'yes',
        ],
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

    $slides_to_show = range(1, 4);
    $slides_to_show = array_combine($slides_to_show, $slides_to_show);

    $this->add_responsive_control(
      'slides_to_show',
      [
        'label'              => esc_html__('Slides to show', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::SELECT,
        'options'            => [
            '' => esc_html__('Default', 'testimonials-carousel-elementor'),
          ] + $slides_to_show,
        'frontend_available' => true,
      ]
    );

    $this->add_responsive_control(
      'slides_to_scroll',
      [
        'label'              => esc_html__('Slides to scroll', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::SELECT,
        'description'        => esc_html__('Set how many slides are scrolled per swipe.', 'testimonials-carousel-elementor'),
        'options'            => [
          ''  => esc_html__('Default', 'testimonials-carousel-elementor'),
          '1' => esc_html__(1, 'testimonials-carousel-elementor'),
        ],
        'frontend_available' => true,
      ]
    );

    $this->add_control(
      'slider_loop',
      [
        'label'              => esc_html__('Loop', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::SWITCHER,
        'label_on'           => __('Yes', 'testimonials-carousel-elementor'),
        'label_off'          => __('No', 'testimonials-carousel-elementor'),
        'return_value'       => 'yes',
        'default'            => 'yes',
        'frontend_available' => true,
      ]
    );

    $this->add_control(
      'autoplay',
      [
        'label'              => esc_html__('Autoplay', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::SELECT,
        'default'            => 'no',
        'options'            => [
          'yes' => esc_html__('Yes', 'testimonials-carousel-elementor'),
          'no'  => esc_html__('No', 'testimonials-carousel-elementor'),
        ],
        'frontend_available' => true,
      ]
    );

    $this->add_control(
      'autoplay_speed',
      [
        'label'              => esc_html__('Autoplay speed', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::NUMBER,
        'default'            => 5000,
        'frontend_available' => true,
      ]
    );

    $this->add_control(
      'navigation',
      [
        'label'              => esc_html__('Navigation', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::SELECT,
        'default'            => 'both',
        'options'            => [
          'both'   => esc_html__('Arrows and Dots', 'testimonials-carousel-elementor'),
          'arrows' => esc_html__('Arrows', 'testimonials-carousel-elementor'),
          'dots'   => esc_html__('Dots', 'testimonials-carousel-elementor'),
          'none'   => esc_html__('None', 'testimonials-carousel-elementor'),
        ],
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

    $this->start_controls_tabs('slider_tabs_style');

    $this->start_controls_tab(
      'slider_tab_header',
      [
        'label' => esc_html__('Header', 'testimonials-carousel-elementor'),
      ]
    );
    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'     => 'background_header',
        'types'    => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .myEmployees .card::before',
        'ai'       => [
          'active' => false,
        ],
      ]
    );
    $this->end_controls_tab();

    $this->start_controls_tab(
      'slider_tab_body',
      [
        'label' => esc_html__('Body', 'testimonials-carousel-elementor'),
      ]
    );
    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'     => 'background_body',
        'types'    => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .myEmployees .card',
        'ai'       => [
          'active' => false,
        ],
      ]
    );
    $this->end_controls_tab();
    $this->end_controls_tabs();
    $this->end_controls_section();

    $this->start_controls_section(
      'rating_styles_section',
      [
        'label' => esc_html__('Rating styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );
    $this->add_responsive_control(
      'slider_rating_align',
      [
        'label'     => esc_html__('Alignment Rating', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::CHOOSE,
        'options'   => [
          'flex-start'    => [
            'title' => esc_html__('Flex-Left', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-justify-start-h',
          ],
          'center'        => [
            'title' => esc_html__('Center', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-justify-center-h',
          ],
          'flex-end'      => [
            'title' => esc_html__('Flex-End', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-justify-end-h',
          ],
          'space-between' => [
            'title' => esc_html__('Space-Between', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-justify-space-between-h',
          ],
          'space-around'  => [
            'title' => esc_html__('Space-Around', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-justify-space-around-h',
          ],
          'space-evenly'  => [
            'title' => esc_html__('Space-Evenly', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-justify-space-evenly-h',
          ],
        ],
        'default'   => 'center',
        'selectors' => [
          '{{WRAPPER}} .rating' => 'justify-content: {{VALUE}}',
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
            'max' => 20,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .rating i' => 'font-size: {{SIZE}}{{UNIT}}',
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
            'max' => 6,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .rating i' => 'margin-right: {{SIZE}}{{UNIT}}',
        ],
      ]
    );

    $this->add_control(
      'stars_color',
      [
        'label'     => esc_html__('Rating icon color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .rating .icon-star-full' => 'color: {{VALUE}}',
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
          '{{WRAPPER}} .rating .icon-star-empty' => 'color: {{VALUE}}',
        ],
      ]
    );
    $this->end_controls_section();

    // Social Icons styles Section
    $this->start_controls_section(
      'social_icons_styles_section',
      [
        'label' => __('Social Icons styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );
    $this->add_responsive_control(
      'social_icons_align',
      [
        'label'     => esc_html__('Alignment Icons', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::CHOOSE,
        'options'   => [
          'left: 20px; right: auto;' => [
            'title' => esc_html__('Left', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-text-align-left',
          ],
          'right: 20px; left: auto;' => [
            'title' => esc_html__('Right', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-text-align-right',
          ],
        ],
        'default'   => 'right: 20px; left: auto;',
        'selectors' => [
          '{{WRAPPER}} .card-content .media-icons' => '{{VALUE}}',
        ],
      ]
    );
    $this->add_control(
      'social_icons_color',
      [
        'label'     => esc_html__('Icons color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .card-content .media-icons a' => 'color: {{VALUE}};',
        ],
      ]
    );
    $this->add_control(
      'social_icons_hover_color',
      [
        'label'     => esc_html__('Icons hover color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .card-content .media-icons a:hover' => 'color: {{VALUE}};',
        ],
      ]
    );
    $this->add_responsive_control(
      'social_icons_size',
      [
        'label'     => esc_html__('Icons size', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SLIDER,
        'range'     => [
          'px' => [
            'min' => 5,
            'max' => 20,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .card-content .media-icons i' => 'font-size: {{SIZE}}{{UNIT}}',
        ],
        'separator' => 'before',
      ]
    );

    $this->add_responsive_control(
      'social_icons_space',
      [
        'label'     => esc_html__('Icons spacing', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SLIDER,
        'range'     => [
          'px' => [
            'min' => 0,
            'max' => 6,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .card-content .media-icons' => 'gap: {{SIZE}}{{UNIT}}',
        ],
      ]
    );

    $this->end_controls_section();

    // Images style Section
    $this->start_controls_section(
      'images_styles_section',
      [
        'label' => esc_html__('Images styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );
    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'     => 'background_images',
        'types'    => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .myEmployees .image',
        'ai'       => [
          'active' => false,
        ],
      ]
    );
    $this->add_responsive_control(
      'slider_image_alignment',
      [
        'label'     => esc_html__('Alignment Images', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::CHOOSE,
        'options'   => [
          '0 auto 0 0' => [
            'title' => esc_html__('Left', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-text-align-left',
          ],
          'auto'       => [
            'title' => esc_html__('Center', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-text-align-center',
          ],
          '0 0 0 auto' => [
            'title' => esc_html__('Right', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-text-align-right',
          ],
        ],
        'default'   => 'auto',
        'selectors' => [
          '{{WRAPPER}} .myEmployees .image' => 'margin: {{VALUE}}',
        ],
      ]
    );
    $this->add_responsive_control(
      'slider_width_images',
      [
        'label'      => esc_html__('Width Images', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px', '%', 'custom'],
        'default'    => [
          'unit' => '%',
        ],
        'range'      => [
          '%' => [
            'min' => 0,
            'max' => 100,
          ],
        ],
        'selectors'  => [
          '{{WRAPPER}} .myEmployees .image' => 'width: {{SIZE}}{{UNIT}}',
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'     => 'slider_border_images',
        'selector' => '{{WRAPPER}} .myEmployees .image img',
      ]
    );

    $this->add_responsive_control(
      'slider_border_radius_images',
      [
        'label'      => esc_html__('Border Radius Images', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .myEmployees .image'     => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
          '{{WRAPPER}} .myEmployees .image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );
    $this->end_controls_section();

    // Name style Section
    $this->start_controls_section(
      'name_styles_section',
      [
        'label' => esc_html__('Name styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
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
        'default'   => 'center',
        'selectors' => [
          '{{WRAPPER}} .name-profession .name' => 'text-align: {{VALUE}}',
        ],
      ]
    );
    $this->add_control(
      'slider_name_color',
      [
        'label'     => esc_html__('Name color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .name-profession .name' => 'color: {{VALUE}};',
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'slider_name_typography',
        'label'    => esc_html__('Name typography', 'testimonials-carousel-elementor'),
        'selector' => '{{WRAPPER}} .name-profession .name',
      ]
    );
    $this->end_controls_section();

    // Role styles Section
    $this->start_controls_section(
      'role_styles_section',
      [
        'label' => __('Role styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );
    $this->add_responsive_control(
      'slider_role_align',
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
        'default'   => 'center',
        'selectors' => [
          '{{WRAPPER}} .name-profession .profession' => 'text-align: {{VALUE}}',
        ],
      ]
    );
    $this->add_control(
      'slider_role_color',
      [
        'label'     => esc_html__('Role color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .name-profession .profession' => 'color: {{VALUE}};',
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'slider_role_typography',
        'label'    => esc_html__('Role typography', 'testimonials-carousel-elementor'),
        'selector' => '{{WRAPPER}} .name-profession .profession',
      ]
    );

    $this->end_controls_section();

    // Button styles Section
    $this->start_controls_section(
      'button_styles_section',
      [
        'label' => __('Button styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );
    $this->add_responsive_control(
      'button_padding',
      [
        'label'      => esc_html__('Padding', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .myEmployees .button a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'     => 'background_button',
        'types'    => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .myEmployees .button a',
        'ai'       => [
          'active' => false,
        ],
      ]
    );
    $this->add_control(
      'button_alignment',
      [
        'label'     => esc_html__('Alignment Button', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::CHOOSE,
        'options'   => [
          'flex-start'    => [
            'title' => esc_html__('Flex-Left', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-justify-start-h',
          ],
          'center'        => [
            'title' => esc_html__('Center', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-justify-center-h',
          ],
          'flex-end'      => [
            'title' => esc_html__('Flex-End', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-justify-end-h',
          ],
          'space-between' => [
            'title' => esc_html__('Space-Between', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-justify-space-between-h',
          ],
          'space-around'  => [
            'title' => esc_html__('Space-Around', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-justify-space-around-h',
          ],
          'space-evenly'  => [
            'title' => esc_html__('Space-Evenly', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-justify-space-evenly-h',
          ],
        ],
        'default'   => 'space-around',
        'selectors' => [
          '{{WRAPPER}} .myEmployees .button' => 'justify-content: {{VALUE}}',
        ],
      ]
    );
    $this->add_responsive_control(
      'button_space',
      [
        'label'     => esc_html__('Button spacing', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SLIDER,
        'range'     => [
          'px' => [
            'min' => 0,
            'max' => 50,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .myEmployees .button' => 'gap: {{SIZE}}{{UNIT}}',
        ],
      ]
    );

    $this->add_control(
      'button_text_color',
      [
        'label'     => esc_html__('Text color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myEmployees .button a' => 'color: {{VALUE}};',
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'button_text_typography',
        'label'    => esc_html__('Text typography', 'testimonials-carousel-elementor'),
        'selector' => '{{WRAPPER}} .myEmployees .button a',
      ]
    );
    $this->add_responsive_control(
      'button_text_align',
      [
        'label'     => esc_html__('Alignment Text', 'testimonials-carousel-elementor'),
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
        'default'   => 'center',
        'selectors' => [
          '{{WRAPPER}} .myEmployees .button a' => 'text-align: {{VALUE}}',
        ],
      ]
    );
    $this->end_controls_section();

    // Arrows styles Section
    $this->start_controls_section(
      'arrows_styles_section',
      [
        'label' => __('Arrows styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'arrows_size',
      [
        'label'     => esc_html__('Arrows size', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SLIDER,
        'range'     => [
          'px' => [
            'min' => 30,
            'max' => 60,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .mySwiper .swiper-button-prev:after, {{WRAPPER}} .mySwiper .swiper-button-next:after' => 'font-size: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'arrows_color',
      [
        'label'     => esc_html__('Arrows color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .mySwiper .swiper-button-prev:after, {{WRAPPER}} .mySwiper .swiper-button-next:after' => 'color: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'arrows_hover_color',
      [
        'label'     => esc_html__('Arrows hover color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .mySwiper .swiper-button-prev:hover::after, {{WRAPPER}} .mySwiper .swiper-button-next:hover::after' => 'color: {{VALUE}};',
        ],
      ]
    );
    $this->end_controls_section();

    // Dots styles Section
    $this->start_controls_section(
      'dots_styles_section',
      [
        'label' => __('Dots styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );
    $this->add_control(
      'dots_size',
      [
        'label'     => esc_html__('Dots size', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SLIDER,
        'range'     => [
          'px' => [
            'min' => 5,
            'max' => 30,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .mySwiper .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'active_dot_size',
      [
        'label'     => esc_html__('Active dot size', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SLIDER,
        'range'     => [
          'px' => [
            'min' => 5,
            'max' => 30,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .mySwiper .swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'dots_inactive_color',
      [
        'label'     => esc_html__('Dots color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .mySwiper .swiper-pagination-bullet' => 'background: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'dots_inactive_hover_color',
      [
        'label'     => esc_html__('Dots hover color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .mySwiper .swiper-pagination-bullet:hover' => 'background: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'active_dot_color',
      [
        'label'     => esc_html__('Active dot color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .mySwiper .swiper-pagination-bullet-active' => 'background: {{VALUE}};',
        ],
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
          'class'                               => ['slider-params'],
          'data-slidestoshow-myswiper'          => esc_attr($settings['slides_to_show']),
          'data-slidestoshow-myswiper-tablet'   => esc_attr($settings['slides_to_show_tablet']),
          'data-slidestoshow-myswiper-mobile'   => esc_attr($settings['slides_to_show_mobile']),
          'data-slidestoscroll-myswiper'        => esc_attr($settings['slides_to_scroll']),
          'data-slidestoscroll-myswiper-tablet' => esc_attr($settings['slides_to_scroll_tablet']),
          'data-slidestoscroll-myswiper-mobile' => esc_attr($settings['slides_to_scroll_mobile']),
          'data-navigation-myswiper'            => esc_attr($settings['navigation']),
          'data-autoplay-myswiper'              => esc_attr($settings['autoplay']),
          'data-autoplayspeed-myswiper'         => esc_attr($settings['autoplay_speed']),
          'data-sliderloop-myswiper'            => esc_attr($settings['slider_loop']),
        ]
      );
    }

    if ($settings['slide']) {
      if (get_plugin_data(ELEMENTOR__FILE__)['Version'] < "3.5.0") { ?>
        <div <?php echo $this->get_render_attribute_string('my_swiper'); ?>></div>
      <?php } ?>

      <section class="swiper mySwiper myEmployees <?php if (
        esc_attr($settings['navigation']) === "dots"
        || esc_attr($settings['navigation']) === "none"
      ) { ?>slider-arrows-disabled<?php } ?>">
        <div class="swiper-wrapper content">
          <?php foreach ($settings['slide'] as $item) { ?>
            <div class="swiper-slide card">
              <div class="card-content">
                <div>
                  <div class="image">
                    <img
                        src="<?php echo esc_url($item['slide_image']['url']) ?>"
                        alt="Slide Image" class="card-img">
                  </div>

                  <?php if ($item['slide_social_enable'] === 'yes') { ?>
                    <div class="media-icons">
                      <?php
                      if ($item['social_to_show'] > '0') {
                        for ($i = 1; $i <= (int)$item['social_to_show']; $i++) {
                          $this->add_link_attributes('social_link_' . $i, $item['social_link_' . $i] ?? [], true);
                          ?>
                          <a <?php $this->print_render_attribute_string('social_link_' . $i); ?>>
                           <span>
                             <i class="<?php echo esc_attr($item['social_icon_' . $i]['value']); ?>"></i>
                           </span>
                          </a>
                          <?php
                        }
                      } ?>
                    </div>
                  <?php } ?>

                  <div class="name-profession">
                    <span class="name"><?php echo wp_kses($item['slide_name'], []); ?></span>
                    <span class="profession"><?php echo wp_kses($item['slide_role'], []); ?></span>
                  </div>

                  <?php if ($item['slide_rating_enable'] === 'yes') { ?>
                    <div class="rating">
                      <?php
                      for ($i = 0; $i < $item['slide_rating']; $i++) { ?>
                        <i class="icon-star-full"></i>
                      <?php }
                      for ($i = 0; $i < (5 - $item['slide_rating']); $i++) { ?>
                        <i class="icon-star-empty"></i>
                      <?php } ?>
                    </div>
                  <?php } ?>
                </div>

                <?php if ($item['slide_button_enable'] === 'yes') { ?>
                  <div class="button">
                    <?php
                    if ($item['slide_button_to_show'] > '0') {
                      for ($i = 1; $i <= (int)$item['slide_button_to_show']; $i++) {
                        $this->add_link_attributes('slide_button_link_' . $i, $item['slide_button_link_' . $i] ?? [], true);
                        ?>
                        <a <?php $this->print_render_attribute_string('slide_button_link_' . $i); ?>>
                          <?php echo wp_kses($item['slide_button_' . $i], []); ?>
                        </a>
                      <?php }
                    } ?>
                  </div>
                <?php } ?>
              </div>
            </div>
          <?php } ?>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
      </section>
    <?php } ?>
  <?php }
}
