<?php
/**
 * TestimonialsCarousel_Blog class.
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

use Elementor\Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Flex_Container;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Security Note: Blocks direct access to the plugin PHP files.
defined('ABSPATH') || die();

/**
 * TestimonialsCarousel_Blog widget class.
 *
 * @since 11.2.0
 */
class TestimonialsCarousel_Blog extends Widget_Base
{
  /**
   * TestimonialsCarousel_Blog constructor.
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
    wp_register_style('testimonials-carousel-blog', plugins_url('/assets/css/testimonials-carousel-blog.min.css', TESTIMONIALS_CAROUSEL_ELEMENTOR), [], TESTIMONIALS_VERSION);
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
    return 'testimonials-carousel-blog';
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
    return __('Testimonial Carousel with Blog', 'testimonials-carousel-elementor');
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
    return 'icon-carousel-blog';
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
    $styles = ['swiper', 'elementor-icons-fa-brands', 'testimonials-carousel-blog', 'testimonials-carousel'];

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
      'slide_content'   => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'testimonials-carousel-elementor'),
      'slide_image'     => [
        'url' => Utils::get_placeholder_image_src(),
      ],
      'slide_name'      => __('John Doe', 'testimonials-carousel-elementor'),
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
        'default'   => esc_html__('Read More', 'testimonials-carousel-elementor'),
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
          'label'     => __('Prompt', 'testimonials-carousel-elementor'),
          'type'      => Controls_Manager::TEXTAREA,
          'default'   => __('Write me a [friendly] review of [500] characters [en] language, from a client of the company [IT soft touch] about [importing cars from the USA]', 'testimonials-carousel-elementor'),
          'rows'      => 20,
          'condition' => [
            'slide_ai_enable' => 'yes',
          ],
          'ai'        => [
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
        'default'            => 'dots',
        'options'            => [
          'dots' => esc_html__('Dots', 'testimonials-carousel-elementor'),
          'none' => esc_html__('None', 'testimonials-carousel-elementor'),
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

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'     => 'background_body',
        'types'    => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .myBlog',
        'ai'       => [
          'active' => false,
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'     => 'slider_border',
        'selector' => '{{WRAPPER}} .myBlog',
      ]
    );
    $this->add_responsive_control(
      'card_border_radius',
      [
        'label'      => esc_html__('Border Radius Card', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .myBlog ' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Box_Shadow::get_type(),
      [
        'name'     => 'box_shadow_body',
        'selector' => '{{WRAPPER}} .myBlog',
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
        'selector' => '{{WRAPPER}} .myBlog .blog-slider__img',
        'ai'       => [
          'active' => false,
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
          '{{WRAPPER}} .myBlog .blog-slider__img img' => 'width: {{SIZE}}{{UNIT}}',
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'     => 'slider_border_images',
        'selector' => '{{WRAPPER}} .myBlog .blog-slider__img img',
      ]
    );

    $this->add_responsive_control(
      'slider_border_radius_images',
      [
        'label'      => esc_html__('Border Radius Images', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .myBlog .blog-slider__img'     => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
          '{{WRAPPER}} .myBlog .blog-slider__img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $default_box_shadow = '4px 13px 30px 1px rgba(0, 0, 0, .2)';
    $this->add_control(
      'slider_box_shadow_images',
      [
        'label'              => esc_html__('Enable Box Shadow', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::SELECT,
        'options'            => [
          $default_box_shadow => esc_html__('Enabled', 'testimonials-carousel-elementor'),
          "none"              => esc_html__("Disabled", "testimonials-carousel-elementor")
        ],
        'default'            => $default_box_shadow,
        'selectors'          => ["{{WRAPPER}} .myBlog .blog-slider__img" => "box-shadow:{{VALUE}};"],
        'frontend_available' => true,
      ]);

    $this->add_group_control(
      Group_Control_Box_Shadow::get_type(), [
      'name'      => 'slider_box_shadow_image',
      'selector'  => '{{WRAPPER}} .myBlog .blog-slider__img',
      'condition' => ['slider_box_shadow_images' => $default_box_shadow]
    ]);

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
          '{{WRAPPER}} .blog-slider__title' => 'text-align: {{VALUE}}',
        ],
      ]
    );
    $this->add_control(
      'slider_name_color',
      [
        'label'     => esc_html__('Name color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .blog-slider__title' => 'color: {{VALUE}};',
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'slider_name_typography',
        'label'    => esc_html__('Name typography', 'testimonials-carousel-elementor'),
        'selector' => '{{WRAPPER}} .blog-slider__title',
      ]
    );
    $this->end_controls_section();

    // Content styles Section
    $this->start_controls_section(
      'role_styles_section',
      [
        'label' => __('Content styles', 'testimonials-carousel-elementor'),
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
        'default'   => 'left',
        'selectors' => [
          '{{WRAPPER}} .blog-slider__text' => 'text-align: {{VALUE}}',
        ],
      ]
    );
    $this->add_control(
      'slider_role_color',
      [
        'label'     => esc_html__('Role color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .blog-slider__text' => 'color: {{VALUE}};',
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'slider_role_typography',
        'label'    => esc_html__('Role typography', 'testimonials-carousel-elementor'),
        'selector' => '{{WRAPPER}} .blog-slider__text',
      ]
    );
    $this->add_responsive_control(
      "slide_content_gap",
      [
        'label'     => __('Content Gap', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SLIDER,
        'range'     => [
          'px' => [
            'min' => 14,
            'max' => 65,
          ],
        ],
        'selectors' => ['{{WRAPPER}} .myBlog .blog-slider__content' => 'gap: {{SIZE}}{{UNIT}}'],
      ]
    );
    $this->add_control(
      "slide_content_direction",
      [
        'label'        => __("Reverse Content", 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Yes', 'testimonials-carousel-elementor'),
        'label_off'    => __('No', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'no',
      ]
    );
    $this->add_responsive_control(
      'slide_content_padding',
      [
        'label'      => esc_html__('Padding', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .myBlog .blog-slider__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
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
    $this->start_controls_tabs("button_styles_tabs");

    $this->start_controls_tab("button_styles", [
      'label' => esc_html__('Normal', 'testimonials-carousel-elementor'),
    ]);

    $this->add_responsive_control(
      'button_padding',
      [
        'label'      => esc_html__('Padding', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .myBlog .blog-slider__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'     => 'background_button',
        'types'    => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .myBlog .blog-slider__button',
        'ai'       => [
          'active' => false,
        ],
      ]
    );
    $this->add_control(
      'button_text_color',
      [
        'label'     => esc_html__('Text color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myBlog .blog-slider__button' => 'color: {{VALUE}};',
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'button_text_typography',
        'label'    => esc_html__('Text typography', 'testimonials-carousel-elementor'),
        'selector' => '{{WRAPPER}} .myBlog .blog-slider__button',
      ]
    );
    $this->add_control(
      'button_width',
      [
        'label'     => esc_html__('Width', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SLIDER,
        "range"     => [
          "px" => [
            'min' => 153,
            'max' => 450
          ]
        ],
        'selectors' => [
          '{{WRAPPER}} .myBlog .blog-slider__button' => 'width: {{SIZE}}{{UNIT}};',
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'     => 'button_border',
        'selector' => '{{WRAPPER}} .myBlog .blog-slider__button',
      ]
    );
    $this->add_responsive_control(
      'button_border_radius',
      [
        'label'      => esc_html__('Border Radius Images', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .myBlog .blog-slider__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Box_Shadow::get_type(), [
      'name'     => 'button_box_shadow',
      'selector' => '{{WRAPPER}} .myBlog .blog-slider__button',
    ]);

    $this->end_controls_tab();

    $this->start_controls_tab(
      'slider_tab_button_hover',
      [
        'label' => esc_html__('Hover', 'testimonials-carousel-elementor'),
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
    $this->end_controls_section();

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
    $this->add_responsive_control(
      'pagination_direction',
      [
        'label'   => __('Direction', 'testimonials-carousel-elementor'),
        'type'    => Controls_Manager::SELECT,
        'options' => [
          'vertical'   => esc_html__('Vertical', 'testimonials-carousel-elementor'),
          'horizontal' => esc_html__('Horizontal', 'testimonials-carousel-elementor'),
        ],
        'devices' => ['desktop'],
        'default' => 'vertical'
      ]
    );
    $this->add_responsive_control(
      'pagination_direction_mobile',
      [
        'label'   => __('Direction', 'testimonials-carousel-elementor'),
        'type'    => Controls_Manager::SELECT,
        'options' => [
          'horizontal' => esc_html__('Horizontal', 'testimonials-carousel-elementor'),
        ],
        'devices' => ['mobile'],
        'default' => 'horizontal'
      ]
    );
    $this->add_responsive_control(
      'justify_content_vertical',
      [
        'label'     => __('Justify Content', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SELECT,
        'options'   => [
          'flex-start' => esc_html__('Top', 'testimonials-carousel-elementor'),
          'center'     => esc_html__('Center', 'testimonials-carousel-elementor'),
          'flex-end'   => esc_html__('Bottom', 'testimonials-carousel-elementor'),
        ],
        'devices'   => ['desktop', 'tablet'],
        'default'   => 'flex-end', // Default value
        'selectors' => ['{{WRAPPER}} .myBlog .blog-slider__pagination' => 'justify-content: {{VALUE}}'],
        'condition' => ['pagination_direction' => "vertical"],
      ]
    );
    $this->add_responsive_control(
      'justify_content_horizontal',
      [
        'label'     => __('Justify Content', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SELECT,
        'options'   => [
          'center'   => esc_html__('Center', 'testimonials-carousel-elementor'),
          'flex-end' => esc_html__('End', 'testimonials-carousel-elementor'),
        ],
        'devices'   => ['desktop', 'tablet'],
        'default'   => 'center', // Default value
        'selectors' => ['{{WRAPPER}} .myBlog .blog-slider__pagination' => 'justify-content: {{VALUE}}'],
        'condition' => ['pagination_direction' => 'horizontal', 'slide_content_direction' => 'no'],
      ]
    );
    $this->add_responsive_control(
      'justify_content_horizontal_mobile',
      [
        'label'          => __('Justify Content', 'testimonials-carousel-elementor'),
        'type'           => Controls_Manager::SELECT,
        'options'        => [
          'flex-start' => esc_html__('Start', 'testimonials-carousel-elementor'),
          'center'     => esc_html__('Center', 'testimonials-carousel-elementor'),
          'flex-end'   => esc_html__('End', 'testimonials-carousel-elementor'),
        ],
        'devices'        => ['mobile'],
        'mobile_default' => 'center', // Default value
        'selectors'      => ['{{WRAPPER}} .myBlog .blog-slider__pagination' => 'justify-content: {{VALUE}}'],
      ]
    );
    $this->add_responsive_control(
      'justify_content_horizontal_reverse',
      [
        'label'     => __('Justify Content', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SELECT,
        'options'   => [
          'flex-start' => esc_html__('Start', 'testimonials-carousel-elementor'),
          'center'     => esc_html__('Center', 'testimonials-carousel-elementor'),

        ],
        'devices'   => ["desktop"],
        'default'   => 'center', // Default value
        'selectors' => ['{{WRAPPER}} .myBlog .blog-slider__pagination' => 'justify-content: {{VALUE}}'],
        'condition' => ['pagination_direction' => "horizontal", 'slide_content_direction' => 'yes'],
      ]
    );

    $this->add_responsive_control(
      'dots_size_height',
      [
        'label'     => esc_html__('Dots size height', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SLIDER,
        'range'     => [
          'px' => [
            'min' => 11,
            'max' => 30,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .myBlog .blog-slider__pagination .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};',
        ],
        'default'   => [
          'unit' => 'px',
          'size' => 11,
        ],
        'condition' => ['pagination_direction' => 'vertical', 'pagination_direction_mobile!' => "horizontal"]
      ]
    );
    $this->add_responsive_control(
      'dots_size_width',
      [
        'label'     => esc_html__('Dots size width', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SLIDER,
        'range'     => [
          'px' => [
            'min' => 11,
            'max' => 30,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .myBlog .blog-slider__pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};',
        ],
        'default'   => [
          'unit' => 'px',
          'size' => 11,
        ],
        'condition' => ["pagination_direction" => 'horizontal']
      ]
    );

    $this->add_responsive_control(
      'active_dot_size_width',
      [
        'label'     => esc_html__('Active dot size width', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SLIDER,
        'range'     => [
          'px' => [
            'min' => 11,
            'max' => 30,
          ],
        ],
        'default'   => [
          'unit' => 'px',
          'size' => 30,
        ],
        'selectors' => [
          '{{WRAPPER}} .myBlog .blog-slider__pagination .swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}};',
        ],
        'condition' => ["pagination_direction" => 'horizontal']
      ]
    );
    $this->add_responsive_control(
      'active_dot_size_height',
      [
        'label'     => esc_html__('Active dot size height', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SLIDER,
        'range'     => [
          'px' => [
            'min' => 11,
            'max' => 30,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .myBlog .blog-slider__pagination .swiper-pagination-bullet-active' => 'height: {{SIZE}}{{UNIT}};',
        ],
        'default'   => [
          'unit' => 'px',
          'size' => 30,
        ],
        'condition' => ["pagination_direction" => 'vertical', 'pagination_direction_mobile!' => "horizontal"]
      ]
    );

    $this->add_control(
      'dots_inactive_color',
      [
        'label'     => esc_html__('Dots color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myBlog .blog-slider__pagination .swiper-pagination-bullet' => 'background: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'dots_inactive_hover_color',
      [
        'label'     => esc_html__('Dots hover color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myBlog .blog-slider__pagination .swiper-pagination-bullet:hover' => 'background: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'active_dot_color',
      [
        'label'     => esc_html__('Active dot color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myBlog .blog-slider__pagination .swiper-pagination-bullet-active' => 'background: {{VALUE}};',
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
          'class'                       => ['slider-params'],
          'data-autoplay-myswiper'      => esc_attr($settings['autoplay']),
          'data-autoplayspeed-myswiper' => esc_attr($settings['autoplay_speed']),
          'data-sliderloop-myswiper'    => esc_attr($settings['slider_loop']),
          'data-navigation-myswiper'    => esc_attr($settings['navigation']),
        ]
      );
    }

    if ($settings['slide']) {
      if (get_plugin_data(ELEMENTOR__FILE__)['Version'] < "3.5.0") { ?>
        <div <?php echo $this->get_render_attribute_string('my_swiper'); ?>></div>
      <?php } ?>

      <section class="swiper mySwiper myBlog <?php if (
        esc_attr($settings['navigation']) === "dots"
        || esc_attr($settings['navigation']) === "none"
      ) { ?>slider-arrows-disabled<?php } ?>">
        <div
            class="swiper-wrapper blog-slider <?php if (esc_attr($settings['slide_content_direction']) === 'yes') { ?> blog-slider-reverse<?php } ?>">
          <?php foreach ($settings['slide'] as $item) {
            $this->add_link_attributes('slide_button_link', $item['slide_button_link'] ?? [], true); ?>
            <div class="swiper-slide blog-slider__item">
              <div class="blog-slider__img">
                <img src="<?php echo esc_url($item['slide_image']['url']) ?>" alt="">
              </div>
              <div class="blog-slider__content">
                <div class="blog-slider__title"><?php echo wp_kses($item['slide_name'], []); ?></div>
                <div class="blog-slider__text"><?php echo wp_kses_post($item['slide_content']); ?></div>
                <?php if (wp_kses($item['slide_show_button'], []) === 'yes') { ?>
                  <div class="slide-coverflow-button-wrapper">
                    <a id="<?php echo wp_kses($item['slide_button_css_id'], []); ?>"
                       class="elementor-button blog-slider__button <?php if (!empty($settings['slide_button_hover_animation'])) { ?> elementor-animation-<?php echo esc_attr($settings['slide_button_hover_animation']);
                       } ?>"
                      <?php $this->print_render_attribute_string('slide_button_link'); ?>>
                       <span class="elementor-button-content-wrapper">
                         <?php if (!empty($settings['slide_selected_icon_button']['value'])) { ?>
                           <span
                               class="elementor-button-icon elementor-align-icon-<?php echo esc_attr($settings['slide_icon_align_button']); ?>">
                             <?php Icons_Manager::render_icon(esc_attr($settings['slide_selected_icon_button']), ['aria-hidden' => 'true']); ?>
                           </span>
                         <?php } ?>
                         <span class="elementor-button-text"><?php echo wp_kses($item['slide_button'], []); ?></span>
                       </span>
                    </a>
                  </div>
                <?php } ?>
              </div>
            </div>
          <?php } ?>
        </div>
        <div class="swiper-button-prev swiper-blog-button-prev"></div>
        <div class="swiper-pagination blog-slider__pagination
         <?php if (esc_attr($settings['navigation']) === 'none') { ?> blog-slider__pagination-disabled<?php } ?>
         <?php if (esc_attr($settings['pagination_direction']) === 'horizontal') { ?> blog-slider__pagination-horizontal<?php } ?>"></div>
        <div class="swiper-button-next swiper-blog-button-next"></div>
      </section>
    <?php } ?>
  <?php }
}
