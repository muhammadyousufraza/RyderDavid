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
class TestimonialsCarousel_Coverflow extends Widget_Base
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
    return 'testimonials-carousel-coverflow';
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
    return __('Carousel with Coverflow', 'testimonials-carousel-elementor');
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
    return 'icon-carousel-coverflow-icon';
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
    $styles = ['swiper', 'testimonials-carousel'];

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
      'slide_content' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'testimonials-carousel-elementor'),
      'slide_image'   => [
        'url' => Utils::get_placeholder_image_src(),
      ],
      'slide_name'    => __('Title', 'testimonials-carousel-elementor'),
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
      'slide_show_image',
      [
        'label'        => __('Show Background Image', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
      ]
    );
    $repeater->add_control(
      'type',
      [
        'type'      => Controls_Manager::CHOOSE,
        'label'     => esc_html__('Type', 'testimonials-carousel-elementor'),
        'default'   => 'bg_image',
        'options'   => [
          'bg_image' => [
            'title' => esc_html__('Image', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-image-bold',
          ],
          'bg_color' => [
            'title' => esc_html__('Color', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-paint-brush',
          ],
        ],
        'toggle'    => false,
        'condition' => [
          'slide_show_image' => 'yes',
        ],
      ]
    );

    $repeater->add_control(
      'slide_image',
      [
        'label'       => __('Choose square or round Image', 'testimonials-carousel-elementor'),
        'type'        => Controls_Manager::MEDIA,
        'default'     => [
          'url' => Utils::get_placeholder_image_src(),
        ],
        'ai'          => [
          'active' => false,
        ],
        'has_sizes'   => true,
        'render_type' => 'template',
        'condition'   => [
          'slide_show_image' => 'yes',
          'type'             => 'bg_image',
        ],
      ]
    );

    $repeater->add_control(
      'slide_background_position',
      [
        'label'      => esc_html__('Position', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SELECT,
        'default'    => '',
        'separator'  => 'before',
        'responsive' => true,
        'options'    => [
          ''              => esc_html__('Default', 'testimonials-carousel-elementor'),
          'center center' => esc_html__('Center Center', 'testimonials-carousel-elementor'),
          'center left'   => esc_html__('Center Left', 'testimonials-carousel-elementor'),
          'center right'  => esc_html__('Center Right', 'testimonials-carousel-elementor'),
          'top center'    => esc_html__('Top Center', 'testimonials-carousel-elementor'),
          'top left'      => esc_html__('Top Left', 'testimonials-carousel-elementor'),
          'top right'     => esc_html__('Top Right', 'testimonials-carousel-elementor'),
          'bottom center' => esc_html__('Bottom Center', 'testimonials-carousel-elementor'),
          'bottom left'   => esc_html__('Bottom Left', 'testimonials-carousel-elementor'),
          'bottom right'  => esc_html__('Bottom Right', 'testimonials-carousel-elementor'),
        ],
        'condition'  => [
          'type'              => 'bg_image',
          'slide_show_image'  => 'yes',
          'slide_image[url]!' => '',
        ],
      ]);

    $repeater->add_control(
      'slide_background_attachment',
      [
        'label'     => esc_html_x('Attachment', 'Background Control', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SELECT,
        'default'   => '',
        'options'   => [
          ''       => esc_html__('Default', 'testimonials-carousel-elementor'),
          'scroll' => esc_html_x('Scroll', 'Background Control', 'testimonials-carousel-elementor'),
          'fixed'  => esc_html_x('Fixed', 'Background Control', 'testimonials-carousel-elementor'),
        ],
        'condition' => [
          'type'              => 'bg_image',
          'slide_show_image'  => 'yes',
          'slide_image[url]!' => '',
        ],
      ]);

    $repeater->add_control(
      'slide_background_repeat',
      [
        'label'      => esc_html_x('Repeat', 'Background Control', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SELECT,
        'default'    => '',
        'responsive' => true,
        'options'    => [
          ''          => esc_html__('Default', 'testimonials-carousel-elementor'),
          'no-repeat' => esc_html__('No-repeat', 'testimonials-carousel-elementor'),
          'repeat'    => esc_html__('Repeat', 'testimonials-carousel-elementor'),
          'repeat-x'  => esc_html__('Repeat-x', 'testimonials-carousel-elementor'),
          'repeat-y'  => esc_html__('Repeat-y', 'testimonials-carousel-elementor'),
        ],
        'condition'  => [
          'type'              => 'bg_image',
          'slide_show_image'  => 'yes',
          'slide_image[url]!' => '',
        ],
      ]);

    $repeater->add_control(
      'slide_background_size',
      [
        'label'      => esc_html__('Display Size', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::SELECT,
        'responsive' => true,
        'default'    => '',
        'options'    => [
          ''        => esc_html__('Default', 'testimonials-carousel-elementor'),
          'auto'    => esc_html__('Auto', 'testimonials-carousel-elementor'),
          'cover'   => esc_html__('Cover', 'testimonials-carousel-elementor'),
          'contain' => esc_html__('Contain', 'testimonials-carousel-elementor'),
        ],
        'condition'  => [
          'type'              => 'bg_image',
          'slide_show_image'  => 'yes',
          'slide_image[url]!' => '',
        ],
      ]
    );

    $repeater->add_control(
      'slide_bg_color',
      [
        'label'     => esc_html__('Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'condition' => [
          'slide_show_image' => 'yes',
          'type'             => 'bg_color',
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
        'separator'          => 'before',
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
      'slide_show_button',
      [
        'label'        => __('Show slide button', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
      ]
    );

    $repeater->add_control(
      'slide_button',
      [
        'label'     => esc_html__('Button Text', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::TEXT,
        'dynamic'   => [
          'active' => true,
        ],
        'default'   => esc_html__('Click Here', 'testimonials-carousel-elementor'),
        'separator' => 'before',
        'condition' => [
          'slide_show_button' => 'yes',
        ],
        'ai'        => [
          'active' => false,
        ],
      ]
    );

    $repeater->add_control(
      'slide_button_link',
      [
        'label'       => esc_html__('Link', 'testimonials-carousel-elementor'),
        'type'        => Controls_Manager::URL,
        'placeholder' => esc_html__('https://your-link.com', 'testimonials-carousel-elementor'),
        'condition'   => [
          'slide_show_button' => 'yes',
        ],
      ]
    );

    $repeater->add_control(
      'slide_button_css_id',
      [
        'label'     => esc_html__('Button ID', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::TEXT,
        'dynamic'   => [
          'active' => true,
        ],
        'default'   => '',
        'separator' => 'before',
        'condition' => [
          'slide_show_button' => 'yes',
        ],
        'ai'        => [
          'active' => false,
        ],
      ]
    );

    $this->add_control(
      'slide',
      [
        'label'              => __('Repeater Slide', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::REPEATER,
        'fields'             => $repeater->get_controls(),
        'title_field'        => '{{{ slide_name }}}',
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
        'default'            => 'yes',
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
        'default'            => 'dots',
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

    $this->add_control(
      'show_image',
      [
        'label'        => __('Show Background Images Globally', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'      => 'background',
        'types'     => ['classic', 'gradient'],
        'selector'  => '{{WRAPPER}} .slider-container-block-background',
        'separator' => 'before',
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
        'label'     => esc_html__('Height', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SLIDER,
        'range'     => [
          'px' => [
            'min' => 215,
            'max' => 500,
          ],
        ],
        'selectors' => [
          "{{WRAPPER}} .slider-container-background .block-shadow" => 'height: {{SIZE}}{{UNIT}};',
        ],
      ]
    );
    $this->end_controls_section();

    // Slider styles Button
    $this->start_controls_section(
      'slider_button_styles_section',
      [
        'label' => esc_html__('Button styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );
    $this->add_responsive_control(
      'slider_button_margin',
      [
        'label'      => esc_html__('Margin', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .slide-coverflow-button-wrapper .slide-coverflow-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'slider_button_padding',
      [
        'label'      => esc_html__('Padding', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .slide-coverflow-button-wrapper .slide-coverflow-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );
    $this->add_responsive_control(
      'slider_button_alignment',
      [
        'label'     => esc_html__('Alignment', 'testimonials-carousel-elementor'),
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
          '{{WRAPPER}} .slide-coverflow-button-wrapper' => 'text-align: {{VALUE}}',
        ],
      ]
    );
    $this->add_responsive_control(
      'slider_button_element_width',
      [
        'label'                => esc_html__('Width', 'testimonials-carousel-elementor'),
        'type'                 => Controls_Manager::SELECT,
        'default'              => '',
        'options'              => [
          ''        => esc_html__('Default', 'testimonials-carousel-elementor'),
          'inherit' => esc_html__('Full Width', 'testimonials-carousel-elementor') . ' (100%)',
          'auto'    => esc_html__('Inline', 'testimonials-carousel-elementor') . ' (auto)',
          'initial' => esc_html__('Custom', 'testimonials-carousel-elementor'),
        ],
        'selectors_dictionary' => [
          'inherit' => '100%',
        ],
        'prefix_class'         => 'elementor-widget%s__width-',
        'selectors'            => [
          '{{WRAPPER}} .slide-coverflow-button-wrapper .slide-coverflow-button' => 'width: {{VALUE}}; max-width: {{VALUE}}',
        ],
      ]
    );

    $this->add_responsive_control(
      'slider_button_element_custom_width',
      [
        'label'     => esc_html__('Width', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SLIDER,
        'default'   => [
          'unit' => '%',
        ],
        'range'     => [
          '%' => [
            'max'  => 100,
            'step' => 1,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .slide-coverflow-button-wrapper .slide-coverflow-button' => '--container-widget-width: {{SIZE}}{{UNIT}}; --container-widget-flex-grow: 0; width: var( --container-widget-width, {{SIZE}}{{UNIT}} ); max-width: {{SIZE}}{{UNIT}}',
        ],
        'condition' => ['slider_button_element_width' => 'initial'],
      ]
    );

    $this->add_control(
      'slider_field_heading_typography',
      [
        'type'      => Controls_Manager::HEADING,
        'separator' => 'before',
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'slider_button_typography',
        'selector' => '{{WRAPPER}} .slide-coverflow-button-wrapper .slide-coverflow-button',
      ]
    );

    $this->start_controls_tabs('slider_tabs_button_style');

    $this->start_controls_tab(
      'slider_tab_button_normal',
      [
        'label' => esc_html__('Normal', 'testimonials-carousel-elementor'),
      ]
    );

    $this->add_control(
      'slider_button_text_color',
      [
        'label'     => esc_html__('Text Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'dynamic'   => [],
        'selectors' => [
          '{{WRAPPER}} .slide-coverflow-button-wrapper .slide-coverflow-button' => 'color: {{VALUE}}',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'           => 'slider_button_background',
        'types'          => ['classic', 'gradient'],
        'exclude'        => ['image'],
        'selector'       => '{{WRAPPER}} .slide-coverflow-button-wrapper .slide-coverflow-button',
        'fields_options' => [
          'background' => [
            'default' => 'classic',
          ],
          'color'      => [
            'dynamic' => [],
          ],
          'color_b'    => [
            'dynamic' => [],
          ],
        ],
      ]
    );

    $this->end_controls_tab();

    $this->start_controls_tab(
      'slider_tab_button_hover',
      [
        'label' => esc_html__('Hover', 'testimonials-carousel-elementor'),
      ]
    );

    $this->add_control(
      'slider_button_hover_text_color',
      [
        'label'     => esc_html__('Text Color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'dynamic'   => [],
        'selectors' => [
          '{{WRAPPER}} .slide-coverflow-button-wrapper .slide-coverflow-button:hover' => 'color: {{VALUE}}',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'           => 'slider_button_hover_background',
        'types'          => ['classic', 'gradient'],
        'exclude'        => ['image'],
        'selector'       => '{{WRAPPER}} .slide-coverflow-button-wrapper .slide-coverflow-button:hover',
        'fields_options' => [
          'background' => [
            'default' => 'classic',
          ],
          'color'      => [
            'dynamic' => [],
          ],
          'color_b'    => [
            'dynamic' => [],
          ],
        ],
      ]
    );

    $this->add_control(
      'slide_button_hover_animation',
      [
        'label' => esc_html__('Hover Animation', 'testimonials-carousel-elementor'),
        'type'  => Controls_Manager::HOVER_ANIMATION,
      ]
    );

    $this->end_controls_tab();
    $this->end_controls_tabs();

    $this->add_control(
      'slider_field_heading_icon',
      [
        'type'      => Controls_Manager::HEADING,
        'separator' => 'before',
      ]
    );

    $this->add_control(
      'slide_selected_icon_button',
      [
        'label'            => esc_html__('Icon', 'testimonials-carousel-elementor'),
        'type'             => Controls_Manager::ICONS,
        'fa4compatibility' => 'icon',
        'skin'             => 'inline',
        'label_block'      => false,
      ]
    );

    $this->add_control(
      'slide_icon_align_button',
      [
        'label'   => esc_html__('Icon Position', 'testimonials-carousel-elementor'),
        'type'    => Controls_Manager::SELECT,
        'default' => 'left',
        'options' => [
          'left'  => esc_html__('Before', 'testimonials-carousel-elementor'),
          'right' => esc_html__('After', 'testimonials-carousel-elementor'),
        ],
      ]
    );

    $this->add_control(
      'slide_icon_indent_button',
      [
        'label'     => esc_html__('Icon Spacing', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SLIDER,
        'range'     => [
          'px' => [
            'max' => 50,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .slide-coverflow-button-wrapper .slide-coverflow-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
          '{{WRAPPER}} .slide-coverflow-button-wrapper .slide-coverflow-button .elementor-align-icon-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'slider_field_heading_border',
      [
        'type'      => Controls_Manager::HEADING,
        'separator' => 'before',
      ]
    );

    $this->start_controls_tabs('slider_tabs_border');
    $this->start_controls_tab(
      'slider_tab_border_normal',
      [
        'label' => esc_html__('Normal', 'testimonials-carousel-elementor'),
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'     => 'slider_border',
        'selector' => '{{WRAPPER}} .slide-coverflow-button-wrapper .slide-coverflow-button',
      ]
    );

    $this->add_responsive_control(
      'slider_border_radius',
      [
        'label'      => esc_html__('Border Radius', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .slide-coverflow-button-wrapper .slide-coverflow-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Box_Shadow::get_type(),
      [
        'name'     => 'slider_box_shadow',
        'selector' => '{{WRAPPER}} .slide-coverflow-button-wrapper .slide-coverflow-button',
      ]
    );

    $this->end_controls_tab();

    $this->start_controls_tab(
      'slider_tab_border_hover',
      [
        'label' => esc_html__('Hover', 'testimonials-carousel-elementor'),
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'     => 'slider_border_hover',
        'selector' => '{{WRAPPER}} .slide-coverflow-button-wrapper .slide-coverflow-button:hover',
      ]
    );

    $this->add_responsive_control(
      'slider_border_radius_hover',
      [
        'label'      => esc_html__('Border Radius', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .slide-coverflow-button-wrapper .slide-coverflow-button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Box_Shadow::get_type(),
      [
        'name'     => 'slider_box_shadow_hover',
        'selector' => '{{WRAPPER}} .slide-coverflow-button-wrapper .slide-coverflow-button:hover',
      ]
    );

    $this->add_control(
      'slider_border_hover_transition',
      [
        'label'     => esc_html__('Transition Duration', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SLIDER,
        'separator' => 'before',
        'range'     => [
          'px' => [
            'max'  => 3,
            'step' => 0.1,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .slide-coverflow-button-wrapper .slide-coverflow-button' => 'transition: background {{_background_hover_transition.SIZE}}s, border {{SIZE}}s, border-radius {{SIZE}}s, box-shadow {{SIZE}}s',
        ],
      ]
    );

    $this->end_controls_tab();
    $this->end_controls_tabs();

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
          '{{WRAPPER}} .slide-description' => 'text-align: {{VALUE}}',
        ],
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
      'heading_style_arrows',
      [
        'label'     => esc_html__('Arrows', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::HEADING,
        'separator' => 'before',
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
          '{{WRAPPER}} .mySwiper .swiper-button-prev, {{WRAPPER}} .mySwiper .swiper-button-next'             => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
          '{{WRAPPER}} .mySwiper .swiper-button-prev:after, {{WRAPPER}} .mySwiper .swiper-button-next:after' => 'font-size: calc({{SIZE}}{{UNIT}} / 3);',
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
          '{{WRAPPER}} .mySwiper .swiper-coverflow-buttons-block .swiper-pagination-bullet-active' => 'background: {{VALUE}};',
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
          'data-navigation-myswiper'          => esc_attr($settings['navigation']),
          'data-autoplay-myswiper'            => esc_attr($settings['autoplay']),
          'data-autoplayspeed-myswiper'       => esc_attr($settings['autoplay_speed']),
          'data-rotate-myswiper'              => esc_attr($settings['slide_rotate']),
          'data-stretch-myswiper'             => esc_attr($settings['slide_stretch']),
          'data-depth-myswiper'               => esc_attr($settings['slide_depth']),
          'data-modifier-myswiper'            => esc_attr($settings['slide_modifier']),
          'data-slideshadows-myswiper'        => esc_attr($settings['slide_shadows']),
          'data-sliderloop-myswiper'          => esc_attr($settings['slider_loop']),
        ]
      );
    }

    if ($settings['slide']) {
      if (get_plugin_data(ELEMENTOR__FILE__)['Version'] < "3.5.0") { ?>
        <div <?php echo $this->get_render_attribute_string('my_swiper'); ?>></div>
      <?php } ?>

      <section class="swiper mySwiper mySwiperCoverflow <?php if (
        esc_attr($settings['navigation']) === "dots"
        || esc_attr($settings['navigation']) === "none"
      ) { ?>slider-arrows-disabled<?php } ?>">
        <ul class="swiper-wrapper">
          <?php
          foreach ($settings['slide'] as $item) {
            $this->add_link_attributes('slide_button_link', $item['slide_button_link'] ?? [], true); ?>
            <li class="swiper-slide slider-container-background">
              <div class="block-shadow slider-container-block-background"
                <?php if ($settings['show_image'] === 'yes' && $item['slide_show_image']) {
                  if ($item['type'] === 'bg_image') { ?>
                    style="
                        background-image: url('<?php echo esc_url($item['slide_image']['url']); ?>');
                        background-position: <?php echo esc_attr($item['slide_background_position']); ?>;
                        background-attachment: <?php echo esc_attr($item['slide_background_attachment']); ?>;
                        background-repeat: <?php echo esc_attr($item['slide_background_repeat']); ?>;
                        background-size: <?php echo esc_attr($item['slide_background_size']); ?>;
                        " <?php } elseif ($item['type'] === 'bg_color') { ?>
                    style="background-color: <?php echo esc_attr($item['slide_bg_color']); ?>;background-image: unset;"
                  <?php }
                } ?>>
                <div class=" slider-coverflow-wrapper
              ">
                  <div>
                    <h2 class="slide-title"><?php echo wp_kses($item['slide_name'], []); ?></h2>
                    <div class="slide-description"
                         style="line-height: 22px;"><?php echo wp_kses_post($item['slide_content']); ?></div>
                  </div>
                  <?php if (wp_kses($item['slide_show_button'], []) === 'yes') { ?>
                    <div class="slide-coverflow-button-wrapper">
                      <a id="<?php echo wp_kses($item['slide_button_css_id'], []); ?>"
                         class="elementor-button slide-coverflow-button <?php if (!empty($settings['slide_button_hover_animation'])) { ?> elementor-animation-<?php echo esc_attr($settings['slide_button_hover_animation']);
                         } ?>"
                        <?php $this->print_render_attribute_string('slide_button_link'); ?>>
                       <span class="elementor-button-content-wrapper">
                         <?php if (!empty($this->get_settings('slide_selected_icon_button')['value'])) { ?>
                           <span
                               class="elementor-button-icon elementor-align-icon-<?php echo esc_attr($this->get_settings('slide_icon_align_button')); ?>">
                             <?php Icons_Manager::render_icon($this->get_settings('slide_selected_icon_button'), ['aria-hidden' => 'true']); ?>
                           </span>
                         <?php } ?>
                         <span class="elementor-button-text"><?php echo wp_kses($item['slide_button'], []); ?></span>
                       </span>
                      </a>
                    </div>
                  <?php } ?>
                </div>
              </div>
            </li>
          <?php } ?>
        </ul>
        <div class="swiper-coverflow-buttons-block">
          <div class="swiper-button-prev swiper-coverflow-button-prev"></div>
          <div class="swiper-pagination swiper-coverflow-pagination"></div>
          <div class="swiper-button-next swiper-coverflow-button-next"></div>
        </div>
      </section>
    <?php } ?>
  <?php }
}
