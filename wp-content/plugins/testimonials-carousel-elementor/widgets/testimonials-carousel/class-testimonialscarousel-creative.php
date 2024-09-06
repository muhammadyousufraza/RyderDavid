<?php
/**
 * TestimonialsCarousel_Creative class.
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
use Elementor\Icons_Manager;

// Security Note: Blocks direct access to the plugin PHP files.
defined('ABSPATH') || die();

/**
 * TestimonialsCarousel_Creative widget class.
 *
 * @since 11.2.0
 */
class TestimonialsCarousel_Creative extends Widget_Base
{
  /**
   * TestimonialsCarousel_Creative constructor.
   *
   * @param array $data
   * @param null  $args
   *
   * @throws \Exception
   */
  public function __construct($data = [], $args = null)
  {
    parent::__construct($data, $args);
    wp_register_style('swiper', plugins_url('/assets/css/swiper-bundle-v11.min.css', TESTIMONIALS_CAROUSEL_ELEMENTOR), [], TESTIMONIALS_VERSION);
    wp_register_style('testimonials-carousel-creative', plugins_url('/assets/css/testimonials-carousel-creative.min.css', TESTIMONIALS_CAROUSEL_ELEMENTOR), [], TESTIMONIALS_VERSION);
    wp_register_script('swiper', plugins_url('/assets/js/swiper-bundle-v11.min.js', TESTIMONIALS_CAROUSEL_ELEMENTOR), [], TESTIMONIALS_VERSION, true);


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
    return 'testimonials-carousel-creative';
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
    return __('Creative Carousel', 'testimonials-carousel-elementor');
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
    return 'icon-carousel-creative';
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
    $styles = ['swiper', 'elementor-icons-fa-brands', 'testimonials-carousel-creative'];

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
      'slide_image'       => [
        'url' => Utils::get_placeholder_image_src(),
      ],
      'slide_title'       => __('<h2>Title</h2>', 'testimonials-carousel-elementor'),
      'slide_description' => __('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'testimonials-carousel-elementor'),
    ];
  }

  protected function get_default_items_creative_with_background()
  {
    return [
      'creative_with_background_image'       => [
        'url' => plugins_url('/assets/images/creative-with-background-placeholder.png', TESTIMONIALS_CAROUSEL_ELEMENTOR),
      ],
      'creative_with_background_title'       => __('<h2>SPECIAL OFFER</h2>', 'testimonials-carousel-elementor'),
      'creative_with_background_subtitle'    => __('<h3>on mobile phones</h3>', 'testimonials-carousel-elementor'),
      'creative_with_background_description' => __('<p>Upgrade your world for less! Enjoy blazing-fast processors, stunning cameras, and sleek designs with our <strong>20% discount</strong> on all mobile phones. Don`t miss out on this limited offer - <strong>ends this weekend!</strong></p>', 'testimonials-carousel-elementor'),
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

    // Get Arrows Icons Creative Carousel
    get_arrows_icons_creative_carousel($this);

    // Get Arrows Icons Creative With Background
    get_arrows_icons_creative_with_background($this);


    // Get Repeater Creative Carousel
    $repeater      = new Repeater();
    $default_items = $this->get_default_slide();

    get_repeater_creative_carousel($this, $repeater, $default_items);

    // Get Repeater Creative With Background
    $repeater_creative_with_background      = new Repeater();
    $default_items_creative_with_background = $this->get_default_items_creative_with_background();

    get_repeater_creative_with_background($this, $repeater_creative_with_background, $default_items_creative_with_background);

    $this->end_controls_section();

    // Accordion Templates Section
    $this->start_controls_section(
      'section_creative_carousel_templates',
      [
        'label' => esc_html__('Creative Carousel Templates', 'testimonials-carousel-elementor'),
      ]
    );

    $this->add_control(
      'creative_carousel_templates',
      [
        'label'              => esc_html__('Creative Carousel Templates', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::SELECT,
        'default'            => '',
        'options'            => [
          ''  => esc_html__('Default', 'testimonials-carousel-elementor'),
          '1' => esc_html__('Creative With Background', 'testimonials-carousel-elementor'),
        ],
        'frontend_available' => true,
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
      'slider_speed',
      [
        'label'              => esc_html__('Speed', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::NUMBER,
        'default'            => 500,
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
        'condition'          => [
          'autoplay' => 'yes',
        ]
      ]
    );

    $this->add_control(
      'navigation',
      [
        'label'              => esc_html__('Navigation', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::SELECT,
        'default'            => 'both',
        'options'            => [
          'both'   => esc_html__('Arrows and Counter', 'testimonials-carousel-elementor'),
          'arrows' => esc_html__('Arrows', 'testimonials-carousel-elementor'),
          'dots'   => esc_html__('Counter', 'testimonials-carousel-elementor'),
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
        'label' => esc_html__('General Sstyles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    // Get General Styles Creative Carousel
    get_general_style_creative_carousel($this);

    // Get General Styles Creative With Background
    get_general_style_creative_with_background($this);

    $this->end_controls_section();

    // Images style Section
    $this->start_controls_section(
      'images_styles_section',
      [
        'label' => esc_html__('Images Styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    // Get Images Styles Creative Carousel
    get_images_style_creative_carousel($this);

    // Get Images Styles Creative With Background
    get_images_style_creative_with_background($this);

    $this->end_controls_section();

    // Content styles Section
    $this->start_controls_section(
      'slider_styles_section',
      [
        'label' => __('Content Styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    // Get Content Styles Creative Carousel
    get_content_style_creative_carousel($this);

    // Get Content Styles Creative With Background
    get_content_style_creative_with_background($this);

    $this->end_controls_section();

    // Arrows styles Section
    $this->start_controls_section(
      'arrows_styles_section',
      [
        'label' => __('Arrows Styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    // Get Arrows Styles Creative Carousel
    get_arrows_style_creative_carousel($this);

    // Get Arrows Styles Creative With Background
    get_arrows_style_creative_with_background($this);

    $this->end_controls_section();

    // Dots styles Section
    $this->start_controls_section(
      'dots_styles_section',
      [
        'label' => __('Counter Styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    // Get Dots Styles Creative Carousel
    get_dots_style_creative_carousel($this);

    // Get Dots Styles Creative With Background
    get_dots_style_creative_with_background($this);

    $this->end_controls_section();

    // Get Pagination Styles Section Creative With Background
    get_section_pagination_creative_with_background($this);
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
          'class'                       => ['slider-params'],
          'data-navigation-myswiper'    => esc_attr($settings['navigation']),
          'data-speed-myswiper'         => esc_attr($settings['slider_speed']),
          'data-sliderloop-myswiper'    => esc_attr($settings['slider_loop']),
          'data-autoplay-myswiper'      => esc_attr($settings['autoplay']),
          'data-autoplayspeed-myswiper' => esc_attr($settings['autoplay_speed']),
        ]
      );

      $attributes = $this->get_render_attribute_string('my_swiper');
    }

    if ($settings['slide']) {
      get_default_creative_template($settings, $attributes);
    } elseif ($settings['creative_with_background']) {
      get_creative_with_background_template($settings, $attributes);
    }
  }
}
