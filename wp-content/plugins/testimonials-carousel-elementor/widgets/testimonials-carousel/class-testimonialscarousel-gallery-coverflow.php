<?php
/**
 * TestimonialsCarousel_Coverflow class.
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
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Security Note: Blocks direct access to the plugin PHP files.
defined('ABSPATH') || die();

/**
 * TestimonialsCarousel_Coverflow widget class.
 *
 * @since 11.2.0
 */
class TestimonialsCarousel_Gallery_Coverflow extends Widget_Base
{
  /**
   * TestimonialsCarousel_Coverflow constructor.
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
    wp_register_style('testimonials-gallery-carousel', plugins_url('/assets/css/testimonials-gallery-carousel.min.css', TESTIMONIALS_CAROUSEL_ELEMENTOR), [], TESTIMONIALS_VERSION);
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
    return 'testimonials-carousel-gallery-coverflow';
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
    return __('Testimonial Carousel with Gallery Coverflow', 'testimonials-carousel-elementor');
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
    return 'icon-carousel-gallery-coverflow-icon';
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
    $styles = ['swiper', 'testimonials-gallery-carousel', 'testimonials-carousel'];

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
      'slide_content'   => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'testimonials-carousel-elementor'),
      'slide_image'     => [
        'url' => Utils::get_placeholder_image_src(),
      ],
      'slide_name'      => __('John Doe', 'testimonials-carousel-elementor'),
      'slide_subtitle'  => __('Manager', 'testimonials-carousel-elementor'),
      'slide_read_more' => __('Read more', 'testimonials-carousel-elementor'),
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

    $api_key          = get_option('elementor_openai_api_key');
    $api_key_validate = get_option('testimonials_openai_validate');

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
      'slide_icon',
      [
        'label'   => __('Choose Icon', 'testimonials-carousel-elementor'),
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
      'slide_icon_link',
      [
        'label'       => esc_html__('Link', 'testimonials-carousel-elementor'),
        'type'        => Controls_Manager::URL,
        'placeholder' => esc_html__('https://your-link.com', 'testimonials-carousel-elementor'),
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
      'slide_subtitle',
      [
        'label'              => __('Title', 'testimonials-carousel-elementor'),
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
      'slide_content',
      [
        'label'              => __('Content', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::WYSIWYG,
        'default'            => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'testimonials-carousel-elementor'),
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
      'slide_read_more',
      [
        'label'              => __('Read more button', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::TEXT,
        'default'            => __('Read more', 'testimonials-carousel-elementor'),
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

    if (!empty($api_key) && $api_key_validate !== '0') {
      $repeater->add_control(
        'slide_ai_enable',
        [
          'label'        => __('OpenAI', 'testimonials-carousel-elementor'),
          'type'         => Controls_Manager::SWITCHER,
          'label_on'     => __('Show', 'testimonials-carousel-elementor'),
          'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
          'return_value' => 'yes',
          'default'      => 'yes',
        ]
      );

      $repeater->add_control(
        'slide_ai_content',
        [
          'label'              => __('Prompt', 'testimonials-carousel-elementor'),
          'type'               => Controls_Manager::TEXTAREA,
          'default'            => __('Write me a [friendly] review of [500] characters [en] language, from a client of the company [IT soft touch] about [importing cars from the USA]', 'testimonials-carousel-elementor'),
          'frontend_available' => false,
          'rows'               => 20,
          'condition'          => [
            'slide_ai_enable' => 'yes',
          ],
          'ai'                 => [
            'active' => false,
          ],
        ]
      );

      $repeater->add_control(
        'process_ai_button',
        [
          'type'               => Controls_Manager::BUTTON,
          'text'               => __('Process', 'testimonials-carousel-elementor'),
          'frontend_available' => true,
          'dynamic'            => [
            'active' => true,
          ],
          'condition'          => [
            'slide_ai_enable' => 'yes',
          ],
          'event'              => 'send_prompt',
        ]
      );
    }

    $this->add_control(
      'slide',
      [
        'label'              => __('Repeater Slide', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::REPEATER,
        'fields'             => $repeater->get_controls(),
        'title_field'        => 'Slide',
        'frontend_available' => true,
        'default'            => [$this->get_default_slide(), $this->get_default_slide(), $this->get_default_slide()],
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

    $slides_to_show = range(1, 2);
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
      'direction',
      [
        'label'              => esc_html__('Direction', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::SELECT,
        'default'            => 'vertical',
        'options'            => [
          'vertical'   => esc_html__('Vertical', 'testimonials-carousel-elementor'),
          'horizontal' => esc_html__('Horizontal', 'testimonials-carousel-elementor'),
        ],
        'frontend_available' => true,
      ]
    );

    $this->add_control(
      'controller',
      [
        'label'              => esc_html__('Controller', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::SELECT,
        'default'            => 'control',
        'options'            => [
          'control' => esc_html__('Control', 'testimonials-carousel-elementor'),
          'thumbs'  => esc_html__('Thumbs', 'testimonials-carousel-elementor'),
        ],
        'frontend_available' => true,
      ]
    );

    $this->add_control(
      'slide_rotate',
      [
        'label'              => esc_html__('Rotate', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::NUMBER,
        'min'                => 0,
        'max'                => 10,
        'step'               => 1,
        'frontend_available' => true,
      ]
    );

    $this->add_control(
      'slide_stretch',
      [
        'label'              => esc_html__('Stretch', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::NUMBER,
        'min'                => 0,
        'max'                => 80,
        'step'               => 1,
        'frontend_available' => true,
      ]
    );

    $this->add_control(
      'slide_depth',
      [
        'label'              => esc_html__('Depth', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::NUMBER,
        'min'                => 20,
        'max'                => 400,
        'step'               => 10,
        'frontend_available' => true,
      ]
    );

    $this->add_control(
      'slide_modifier',
      [
        'label'              => esc_html__('Modifier', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::NUMBER,
        'min'                => 1,
        'max'                => 4,
        'step'               => 1,
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
      'slider_speed',
      [
        'label'              => esc_html__('Speed', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::NUMBER,
        'default'            => 500,
        'frontend_available' => true,
      ]
    );

    $this->add_control(
      'show_line_text',
      [
        'label'              => esc_html__('Show Lines With Text', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::NUMBER,
        'min'                => 1,
        'max'                => 21,
        'step'               => 1,
        'default'            => 7,
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
        'default'            => 'none',
        'options'            => [
          'dots' => esc_html__('Dots', 'testimonials-carousel-elementor'),
          'none' => esc_html__('None', 'testimonials-carousel-elementor'),
        ],
        'frontend_available' => true,
      ]
    );

    $this->add_control(
      'navigation_position',
      [
        'label'     => esc_html__('Navigation Position', 'testimonials-carousel-elementor'),
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
        'selectors' => [
          '{{WRAPPER}} .swiper-gallery-coverflow-buttons-block .swiper-pagination' => '{{VALUE}}: 10px',
        ],
        'condition' => [
          'direction'  => 'vertical',
          'navigation' => 'dots',
        ],
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
      'slider_tab_gallery',
      [
        'label' => esc_html__('Gallery', 'testimonials-carousel-elementor'),
      ]
    );

    $this->add_responsive_control(
      'slider_gallery_margin',
      [
        'label'      => esc_html__('Margin', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .mySwiperGalleryCoverflow .gallery-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'slider_gallery_padding',
      [
        'label'      => esc_html__('Padding', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .mySwiperGalleryCoverflow .gallery-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'     => 'background_gallery',
        'types'    => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .mySwiperGalleryCoverflow .gallery-wrapper',
      ]
    );
    $this->add_responsive_control(
      'slider_gallery_width',
      [
        'label'                => esc_html__('Width', 'testimonials-carousel-elementor'),
        'type'                 => Controls_Manager::SELECT,
        'default'              => '',
        'options'              => [
          ''        => esc_html__('Default', 'testimonials-carousel-elementor'),
          'inherit' => esc_html__('Full Width', 'testimonials-carousel-elementor') . ' (100%)',
          'initial' => esc_html__('Custom', 'testimonials-carousel-elementor'),
        ],
        'selectors_dictionary' => [
          'inherit' => '100%',
        ],
        'prefix_class'         => 'elementor-widget%s__width-',
        'selectors'            => [
          '{{WRAPPER}} .mySwiperGalleryCoverflow .gallery-wrapper' => 'width: {{VALUE}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'slider_gallery_custom_width',
      [
        'label'      => esc_html__('Width', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'default'    => [
          'unit' => '%',
        ],
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'range'      => [
          '%'  => [
            'min'  => 0,
            'max'  => 100,
            'step' => 1,
          ],
          'px' => [
            'min'  => 0,
            'max'  => 300,
            'step' => 1,
          ],
        ],
        'selectors'  => [
          '{{WRAPPER}} .mySwiperGalleryCoverflow .gallery-wrapper' => '--container-widget-width: {{SIZE}}{{UNIT}}; --container-widget-flex-grow: 0; width: var( --container-widget-width, {{SIZE}}{{UNIT}} );',
        ],
        'condition'  => ['slider_gallery_width' => 'initial'],
      ]
    );
    $this->end_controls_tab();

    $this->start_controls_tab(
      'slider_tab_testimonials',
      [
        'label' => esc_html__('Testimonials', 'testimonials-carousel-elementor'),
      ]
    );

    $this->add_responsive_control(
      'slider_testimonials_margin',
      [
        'label'      => esc_html__('Margin', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .mySwiperGalleryCoverflow .testimonial-wrapper .quote' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'slider_testimonials_padding',
      [
        'label'      => esc_html__('Padding', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .mySwiperGalleryCoverflow .testimonial-wrapper .quote' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'     => 'background_testimonials',
        'types'    => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .mySwiperGalleryCoverflow .testimonial-wrapper',
      ]
    );

    $this->add_responsive_control(
      'slider_testimonials_width',
      [
        'label'                => esc_html__('Width', 'testimonials-carousel-elementor'),
        'type'                 => Controls_Manager::SELECT,
        'default'              => '',
        'options'              => [
          ''        => esc_html__('Default', 'testimonials-carousel-elementor'),
          'inherit' => esc_html__('Full Width', 'testimonials-carousel-elementor') . ' (100%)',
          'initial' => esc_html__('Custom', 'testimonials-carousel-elementor'),
        ],
        'selectors_dictionary' => [
          'inherit' => '100%',
        ],
        'prefix_class'         => 'elementor-widget%s__width-',
        'selectors'            => [
          '{{WRAPPER}} .mySwiperGalleryCoverflow .testimonial-wrapper' => 'width: {{VALUE}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'slider_testimonials_custom_width',
      [
        'label'      => esc_html__('Width', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'default'    => [
          'unit' => '%',
        ],
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'range'      => [
          '%'  => [
            'min'  => 0,
            'max'  => 100,
            'step' => 1,
          ],
          'px' => [
            'min'  => 0,
            'max'  => 300,
            'step' => 1,
          ],
        ],
        'selectors'  => [
          '{{WRAPPER}} .mySwiperGalleryCoverflow .testimonial-wrapper' => '--container-widget-width: {{SIZE}}{{UNIT}}; --container-widget-flex-grow: 0; width: var( --container-widget-width, {{SIZE}}{{UNIT}} );',
        ],
        'condition'  => ['slider_testimonials_width' => 'initial'],
      ]
    );
    $this->add_responsive_control(
      'slide_testimonials_height',
      [
        'label'      => esc_html__('Height Testimonials', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['vh', 'px'],
        'default'    => [
          'unit' => 'vh',
        ],
        'range'      => [
          'px' => [
            'min' => 0,
            'max' => 800,
          ],
          'vh' => [
            'min' => 0,
            'max' => 100,
          ],
        ],
        'selectors'  => [
          "{{WRAPPER}} .mySwiperGalleryCoverflow .swiper-container.testimonial" => 'height: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->end_controls_tab();
    $this->end_controls_tabs();

    $this->add_control(
      'slide_gallery_align',
      [
        'label'   => esc_html__('Gallery Position', 'testimonials-carousel-elementor'),
        'type'    => Controls_Manager::SELECT,
        'default' => 'row',
        'options' => [
          'row'         => esc_html__('Before', 'testimonials-carousel-elementor'),
          'row-reverse' => esc_html__('After', 'testimonials-carousel-elementor'),
        ],
      ]
    );

    $this->add_control(
      'slider_field_heading_height',
      [
        'type'      => Controls_Manager::HEADING,
        'separator' => 'before',
      ]
    );

    $this->add_responsive_control(
      'slide_height',
      [
        'label'      => esc_html__('Height', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['vh', 'px'],
        'default'    => [
          'unit' => 'vh',
        ],
        'range'      => [
          'px' => [
            'min' => 0,
            'max' => 800,
          ],
          'vh' => [
            'min' => 0,
            'max' => 100,
          ],
        ],
        'selectors'  => [
          "{{WRAPPER}} .mySwiperGalleryCoverflow" => 'height: {{SIZE}}{{UNIT}};',
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

    // Slider styles Gallery Images
    $this->start_controls_section(
      'slider_gallery_styles_section',
      [
        'label' => esc_html__('Gallery Images styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'slide_gallery_blur',
      [
        'label'     => esc_html__('Image Blur', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SLIDER,
        'range'     => [
          'px' => [
            'max'  => 5,
            'step' => 0.1,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .mySwiperGalleryCoverflow .gallery-thumbs .swiper-slide img' => 'filter: blur({{SIZE}}px);',
        ],
      ]
    );
    $this->add_control(
      'slide_gallery_blur_active',
      [
        'label'     => esc_html__('Active Image Contrast', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SLIDER,
        'range'     => [
          'px' => [
            'max'  => 5,
            'step' => 0.1,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .mySwiperGalleryCoverflow .gallery-thumbs .swiper-slide-active img' => 'filter: blur({{SIZE}}px);',
        ],
      ]
    );
    $this->add_responsive_control(
      'slider_gallery_element_width',
      [
        'label'                => esc_html__('Width', 'testimonials-carousel-elementor'),
        'type'                 => Controls_Manager::SELECT,
        'default'              => '',
        'options'              => [
          ''        => esc_html__('Default', 'testimonials-carousel-elementor'),
          'inherit' => esc_html__('Full Width', 'testimonials-carousel-elementor') . ' (100%)',
          'initial' => esc_html__('Custom', 'testimonials-carousel-elementor'),
        ],
        'selectors_dictionary' => [
          'inherit' => '100%',
        ],
        'prefix_class'         => 'elementor-widget%s__width-',
        'selectors'            => [
          '{{WRAPPER}} .mySwiperGalleryCoverflow .gallery-thumbs img' => 'width: {{VALUE}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'slider_gallery_element_custom_width',
      [
        'label'      => esc_html__('Width', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'default'    => [
          'unit' => '%',
        ],
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'range'      => [
          '%'  => [
            'min'  => 0,
            'max'  => 100,
            'step' => 1,
          ],
          'px' => [
            'min'  => 0,
            'max'  => 300,
            'step' => 1,
          ],
        ],
        'selectors'  => [
          '{{WRAPPER}} .mySwiperGalleryCoverflow .gallery-thumbs img' => '--container-widget-width: {{SIZE}}{{UNIT}}; --container-widget-flex-grow: 0; width: var( --container-widget-width, {{SIZE}}{{UNIT}} );',
        ],
        'condition'  => ['slider_gallery_element_width' => 'initial'],
      ]
    );
    $this->add_responsive_control(
      'slide_gallery_height',
      [
        'label'      => esc_html__('Height', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'default'    => [
          'unit' => '%',
        ],
        'size_units' => ['px', '%', 'em', 'rem'],
        'range'      => [
          '%'  => [
            'min'  => 0,
            'max'  => 100,
            'step' => 1,
          ],
          'px' => [
            'min'  => 0,
            'max'  => 300,
            'step' => 1,
          ],
        ],
        'selectors'  => [
          "{{WRAPPER}} .mySwiperGalleryCoverflow .swiper-slide" => 'height: {{SIZE}}{{UNIT}};',
        ],
      ]
    );
    $this->end_controls_section();

    // Slider styles Logo
    $this->start_controls_section(
      'slider_logo_styles_section',
      [
        'label' => esc_html__('Logo styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );
    $this->add_responsive_control(
      'slider_logo_margin',
      [
        'label'      => esc_html__('Margin', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .mySwiperGalleryCoverflow .quote-wrapper .quote-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'slider_logo_padding',
      [
        'label'      => esc_html__('Padding', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .mySwiperGalleryCoverflow .quote-wrapper .quote-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );
    $this->add_responsive_control(
      'slider_logo_alignment',
      [
        'label'     => esc_html__('Alignment Logo', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::CHOOSE,
        'options'   => [
          'flex-start' => [
            'title' => esc_html__('Left', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-text-align-left',
          ],
          'center'     => [
            'title' => esc_html__('Center', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-text-align-center',
          ],
          'flex-end'   => [
            'title' => esc_html__('Right', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-text-align-right',
          ],
        ],
        'default'   => 'flex-start',
        'selectors' => [
          '{{WRAPPER}} .mySwiperGalleryCoverflow .quote-wrapper' => 'justify-content: {{VALUE}}',
        ],
      ]
    );
    $this->add_responsive_control(
      'slider_logo_element_width',
      [
        'label'                => esc_html__('Width', 'testimonials-carousel-elementor'),
        'type'                 => Controls_Manager::SELECT,
        'default'              => '',
        'options'              => [
          ''        => esc_html__('Default', 'testimonials-carousel-elementor'),
          'inherit' => esc_html__('Full Width', 'testimonials-carousel-elementor') . ' (100%)',
          'initial' => esc_html__('Custom', 'testimonials-carousel-elementor'),
        ],
        'selectors_dictionary' => [
          'inherit' => '100%',
        ],
        'prefix_class'         => 'elementor-widget%s__width-',
        'selectors'            => [
          '{{WRAPPER}} .mySwiperGalleryCoverflow .quote-wrapper .quote-icon' => 'width: {{VALUE}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'slider_logo_element_custom_width',
      [
        'label'      => esc_html__('Width', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'default'    => [
          'unit' => '%',
        ],
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'range'      => [
          '%'  => [
            'min'  => 0,
            'max'  => 100,
            'step' => 1,
          ],
          'px' => [
            'min'  => 0,
            'max'  => 300,
            'step' => 1,
          ],
        ],
        'selectors'  => [
          '{{WRAPPER}} .mySwiperGalleryCoverflow .quote-wrapper .quote-icon' => '--container-widget-width: {{SIZE}}{{UNIT}}; --container-widget-flex-grow: 0; width: var( --container-widget-width, {{SIZE}}{{UNIT}} );',
        ],
        'condition'  => ['slider_logo_element_width' => 'initial'],
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'     => 'slider_logo_border',
        'selector' => '{{WRAPPER}} .mySwiperGalleryCoverflow .quote-wrapper .quote-icon',
      ]
    );

    $this->add_responsive_control(
      'slider_logo_border_radius',
      [
        'label'      => esc_html__('Border Radius', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .mySwiperGalleryCoverflow .quote-wrapper .quote-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Box_Shadow::get_type(),
      [
        'name'     => 'slider_logo_box_shadow',
        'selector' => '{{WRAPPER}} .mySwiperGalleryCoverflow .quote-wrapper .quote-icon',
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
          '{{WRAPPER}} .swiper-wrapper .slide-title' => 'color: {{VALUE}};',
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'slider_name_typography',
        'label'    => esc_html__('Name typography', 'testimonials-carousel-elementor'),
        'selector' => '{{WRAPPER}} .swiper-wrapper .slide-title',
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
          '{{WRAPPER}} .slide-title' => 'text-align: {{VALUE}}',
        ],
      ]
    );
    $this->add_control(
      'slider_title_color',
      [
        'label'     => esc_html__('Title color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .swiper-wrapper .slide-subtitle' => 'color: {{VALUE}};',
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'slider_title_typography',
        'label'    => esc_html__('Title typography', 'testimonials-carousel-elementor'),
        'selector' => '{{WRAPPER}} .swiper-wrapper .slide-subtitle',
      ]
    );
    $this->add_responsive_control(
      'slider_title_align',
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
          '{{WRAPPER}} .slide-subtitle' => 'text-align: {{VALUE}}',
        ],
      ]
    );
    $this->add_control(
      'slider_content_color',
      [
        'label'     => esc_html__('Content color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .swiper-wrapper .slide-description' => 'color: {{VALUE}};',
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'slider_content_typography',
        'label'    => esc_html__('Content typography', 'testimonials-carousel-elementor'),
        'selector' => '{{WRAPPER}} .swiper-wrapper .slide-description',
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
          '{{WRAPPER}} .slide-content' => 'text-align: {{VALUE}}',
        ],
      ]
    );
    $this->add_control(
      'slider_read_more_color',
      [
        'label'     => esc_html__('Read more button color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .swiper-wrapper .slide-read-more' => 'color: {{VALUE}};',
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'slider_read_more_typography',
        'label'    => esc_html__('Read more button typography', 'testimonials-carousel-elementor'),
        'selector' => '{{WRAPPER}} .swiper-wrapper .slide-read-more',
      ]
    );
    $this->add_responsive_control(
      'slider_rating_align',
      [
        'label'     => esc_html__('Alignment Rating', 'testimonials-carousel-elementor'),
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
          '{{WRAPPER}} .slide-icons' => 'text-align: {{VALUE}}',
        ],
      ]
    );
    $this->end_controls_section();

    // Popup styles Section
    $this->start_controls_section(
      'popup_styles_section',
      [
        'label' => __('Popup styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );
    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'     => 'popup_background',
        'types'    => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .slider-modal .slider-modal-container.slider-container-block-background',
      ]
    );
    $this->add_responsive_control(
      'popup_icon_size',
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
          '{{WRAPPER}} .slider-modal .slide-icons i' => 'font-size: {{SIZE}}{{UNIT}}',
        ],
      ]
    );

    $this->add_responsive_control(
      'popup_icon_space',
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
          '{{WRAPPER}} .slider-modal .slide-icons i' => 'margin-right: {{SIZE}}{{UNIT}}',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'     => 'popup_border',
        'selector' => '{{WRAPPER}} .slider-modal .slider-modal-container.slider-container-block-background',
      ]
    );

    $this->add_responsive_control(
      'popup_border_radius',
      [
        'label'      => esc_html__('Border Radius', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .slider-modal .slider-modal-container.slider-container-block-background' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Box_Shadow::get_type(),
      [
        'name'     => 'popup_box_shadow',
        'selector' => '{{WRAPPER}} .slider-modal .slider-modal-container.slider-container-block-background',
      ]
    );

    $this->add_control(
      'popup_stars_color',
      [
        'label'     => esc_html__('Rating icon color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .slider-modal .slide-icons .icon-star-full' => 'color: {{VALUE}}',
        ],
        'separator' => 'before',
      ]
    );

    $this->add_control(
      'popup_stars_unmarked_color',
      [
        'label'     => esc_html__('Rating unmarked icon color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .slider-modal .slide-icons .icon-star-empty' => 'color: {{VALUE}}',
        ],
      ]
    );
    $this->add_responsive_control(
      'popup_rating_align',
      [
        'label'     => esc_html__('Alignment Rating', 'testimonials-carousel-elementor'),
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
          '{{WRAPPER}} .slider-modal .slide-icons' => 'text-align: {{VALUE}}',
        ],
      ]
    );
    $this->add_control(
      'popup_name_color',
      [
        'label'     => esc_html__('Name color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .slider-modal-container .slide-title' => 'color: {{VALUE}};',
        ],
        'separator' => 'before',
      ]
    );
    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'popup_name_typography',
        'label'    => esc_html__('Name typography', 'testimonials-carousel-elementor'),
        'selector' => '{{WRAPPER}} .slider-modal-container .slide-title',
      ]
    );
    $this->add_responsive_control(
      'popup_name_align',
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
          '{{WRAPPER}} .slider-modal .slide-title' => 'text-align: {{VALUE}}',
        ],
      ]
    );
    $this->add_control(
      'popup_title_color',
      [
        'label'     => esc_html__('Title color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .slider-modal-container .slide-subtitle' => 'color: {{VALUE}};',
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'popup_title_typography',
        'label'    => esc_html__('Title typography', 'testimonials-carousel-elementor'),
        'selector' => '{{WRAPPER}} .slider-modal-container .slide-subtitle',
      ]
    );
    $this->add_responsive_control(
      'popup_title_align',
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
          '{{WRAPPER}} .slider-modal .slide-subtitle' => 'text-align: {{VALUE}}',
        ],
      ]
    );
    $this->add_control(
      'popup_content_color',
      [
        'label'     => esc_html__('Content color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .slider-modal-container .slide-description' => 'color: {{VALUE}};',
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'popup_content_typography',
        'label'    => esc_html__('Content typography', 'testimonials-carousel-elementor'),
        'selector' => '{{WRAPPER}} .slider-modal-container .slide-description',
      ]
    );
    $this->add_responsive_control(
      'popup_content_align',
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
          '{{WRAPPER}} .slider-modal-container .slide-description' => 'text-align: {{VALUE}}',
        ],
      ]
    );
    $this->add_responsive_control(
      'popup_logo_alignment',
      [
        'label'     => esc_html__('Alignment Logo', 'testimonials-carousel-elementor'),
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
          '{{WRAPPER}} .slider-modal .quote-wrapper' => 'text-align: {{VALUE}}',
        ],
        'separator' => 'before',
      ]
    );
    $this->add_responsive_control(
      'popup_logo_element_width',
      [
        'label'                => esc_html__('Width', 'testimonials-carousel-elementor'),
        'type'                 => Controls_Manager::SELECT,
        'default'              => '',
        'options'              => [
          ''        => esc_html__('Default', 'testimonials-carousel-elementor'),
          'inherit' => esc_html__('Full Width', 'testimonials-carousel-elementor') . ' (100%)',
          'initial' => esc_html__('Custom', 'testimonials-carousel-elementor'),
        ],
        'selectors_dictionary' => [
          'inherit' => '100%',
        ],
        'prefix_class'         => 'elementor-widget%s__width-',
        'selectors'            => [
          '{{WRAPPER}} .slider-modal .quote-wrapper .quote-icon' => 'width: {{VALUE}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'popup_logo_element_custom_width',
      [
        'label'      => esc_html__('Width', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'default'    => [
          'unit' => '%',
        ],
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'range'      => [
          '%'  => [
            'min'  => 0,
            'max'  => 100,
            'step' => 1,
          ],
          'px' => [
            'min'  => 0,
            'max'  => 300,
            'step' => 1,
          ],
        ],
        'selectors'  => [
          '{{WRAPPER}} .slider-modal .quote-wrapper .quote-icon' => '--container-widget-width: {{SIZE}}{{UNIT}}; --container-widget-flex-grow: 0; width: var( --container-widget-width, {{SIZE}}{{UNIT}} );',
        ],
        'condition'  => ['popup_logo_element_width' => 'initial'],
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'     => 'popup_logo_border',
        'selector' => '{{WRAPPER}} .slider-modal .quote-wrapper .quote-icon',
      ]
    );

    $this->add_responsive_control(
      'popup_logo_border_radius',
      [
        'label'      => esc_html__('Border Radius', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .slider-modal .quote-wrapper .quote-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Box_Shadow::get_type(),
      [
        'name'     => 'popup_logo_box_shadow',
        'selector' => '{{WRAPPER}} .slider-modal .quote-wrapper .quote-icon',
      ]
    );
    $this->end_controls_section();

    // Navigation styles Section
    $this->start_controls_section(
      'navigation_styles_section',
      [
        'label' => __('Navigation styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'heading_style_dots',
      [
        'label'     => esc_html__('Pagination', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::HEADING,
        'separator' => 'before',
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
            'max' => 12,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .mySwiper .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
            'max' => 12,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .mySwiper .swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
          'class'                             => ['slider-params'],
          'data-slidestoshow-myswiper'        => esc_attr($settings['slides_to_show']),
          'data-slidestoshow-myswiper-tablet' => esc_attr($settings['slides_to_show_tablet']),
          'data-slidestoshow-myswiper-mobile' => esc_attr($settings['slides_to_show_mobile']),
          'data-direction-myswiper'           => esc_attr($settings['direction']),
          'data-direction-myswiper-tablet'    => esc_attr($settings['direction_tablet']),
          'data-direction-myswiper-mobile'    => esc_attr($settings['direction_mobile']),
          'data-navigation-myswiper'          => esc_attr($settings['navigation']),
          'data-autoplay-myswiper'            => esc_attr($settings['autoplay']),
          'data-speed-myswiper'               => esc_attr($settings['slider_speed']),
          'data-autoplayspeed-myswiper'       => esc_attr($settings['autoplay_speed']),
          'data-rotate-myswiper'              => esc_attr($settings['slide_rotate']),
          'data-stretch-myswiper'             => esc_attr($settings['slide_stretch']),
          'data-depth-myswiper'               => esc_attr($settings['slide_depth']),
          'data-modifier-myswiper'            => esc_attr($settings['slide_modifier']),
          'data-slideshadows-myswiper'        => esc_attr($settings['slide_shadows']),
          'data-controller-myswiper'          => esc_attr($settings['controller']),
          'data-showlinetext-myswiper'        => esc_attr($settings['show_line_text']),
        ]
      );
    }

    if ($settings['slide']) {
      if (get_plugin_data(ELEMENTOR__FILE__)['Version'] < "3.5.0") { ?>
        <div <?php echo $this->get_render_attribute_string('my_swiper'); ?>></div>
      <?php } ?>

      <section class="swiper mySwiper myGallery mySwiperGalleryCoverflow <?php if (
        esc_attr($settings['navigation']) === "dots"
        || esc_attr($settings['navigation']) === "none"
      ) { ?>slider-arrows-disabled<?php } ?>">
        <div class="testimonial-section <?php if (esc_attr($this->get_settings('slide_gallery_align')) === 'row') {
          echo 'testimonials-column';
        } else {
          echo 'testimonials-column-reverse';
        } ?>"
             style="flex-direction: <?php echo esc_attr($this->get_settings('slide_gallery_align')); ?>"
        >
          <div class="gallery-wrapper">
            <div class="swiper-container gallery-thumbs">
              <div class="swiper-wrapper">
                <?php foreach ($settings['slide'] as $item) { ?>
                  <div class="swiper-slide">
                    <img src="<?php echo esc_url($item['slide_image']['url']) ?>" alt="Slide Image">
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="testimonial-wrapper">
            <div class="swiper-container testimonial">
              <!-- Additional required wrapper -->
              <div class="swiper-wrapper ">
                <!-- Slides -->
                <?php foreach ($settings['slide'] as $item) {
                  $this->add_link_attributes('slide_icon_link', $item['slide_icon_link'] ?? [], true); ?>
                  <div class="swiper-slide">
                    <div class="quote">
                      <div class="quote-wrapper">
                        <?php if (!empty(wp_kses($item['slide_icon_link']['url'], []))) { ?>
                          <a <?php $this->print_render_attribute_string('slide_icon_link'); ?>>
                            <img class="quote-icon" src="<?php echo esc_url($item['slide_icon']['url']) ?>"
                                 alt="Slide Icon">
                          </a>
                        <?php } else { ?>
                          <img class="quote-icon" src="<?php echo esc_url($item['slide_icon']['url']) ?>"
                               alt="Slide Icon">
                        <?php } ?>
                      </div>
                      <div class="slide-content">
                        <div class="slide-description"
                             style="line-height: 22px;-webkit-line-clamp: <?php echo esc_attr($settings['show_line_text']); ?>">
                          <?php echo wp_kses_post($item['slide_content']); ?>
                        </div>
                        <div class="slide-read-more"><?php echo wp_kses($item['slide_read_more'], []); ?></div>
                      </div>
                      <div class="slide-title"><?php echo wp_kses($item['slide_name'], []); ?></div>
                      <div class="slide-subtitle"><?php echo wp_kses($item['slide_subtitle'], []); ?></div>
                      <?php if ($item['slide_rating_enable'] === 'yes') { ?>
                        <div class="slide-icons">
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
                  </div>
                <?php } ?>
              </div>
              <div class="swiper-gallery-coverflow-buttons-block"></div>
            </div>
          </div>
        </div>
      </section>
      <div class="slider-modal slider-gallery-coverflow-modal mySwiperGalleryCoverflow-modal" id="slider-modal">
        <div class="slider-modal-bg slider-modal-exit"></div>
        <div class="slider-modal-container slider-container-background slider-container-block-background">
          <div class="slider-modal-container-info"></div>
          <button class="slider-modal-close slider-modal-exit icon-close"></button>
        </div>
      </div>
    <?php } ?>
  <?php }
}
