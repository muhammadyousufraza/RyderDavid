<?php
/**
 * TestimonialsCarousel_Thumbnails class.
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

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;

// Security Note: Blocks direct access to the plugin PHP files.
defined('ABSPATH') || die();

/**
 * TestimonialsCarousel_Creative widget class.
 *
 * @since 11.2.0
 */
class TestimonialsCarousel_Thumbnails extends Widget_Base
{
  /**
   * TestimonialsCarousel_Thumbnails constructor.
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
    wp_register_style('testimonials-carousel', plugins_url('/assets/css/testimonials-carousel.min.css', TESTIMONIALS_CAROUSEL_ELEMENTOR), [], TESTIMONIALS_VERSION);
    wp_register_style('testimonials-carousel-thumbnails', plugins_url('/assets/css/testimonials-carousel-thumbnails.min.css', TESTIMONIALS_CAROUSEL_ELEMENTOR), [], TESTIMONIALS_VERSION);
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
    return 'testimonials-carousel-thumbnails';
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
    return __('Testimonials Carousel with Thumbnails', 'testimonials-carousel-elementor');
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
    return 'icon-testimonials-thumbnails';
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
    $styles = ['swiper', 'elementor-icons-fa-brands', 'testimonials-carousel-thumbnails', 'testimonials-carousel'];

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
      'slide_title'       => __('John Doe', 'testimonials-carousel-elementor'),
      'slide_description' => __('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'testimonials-carousel-elementor'),
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
        'label'   => __('Choose avatar', 'testimonials-carousel-elementor'),
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
      'slide_title',
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
        'title_field'        => '{{{ slide_title }}}',
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
        'default'            => 'both',
        'options'            => [
          'both'          => esc_html__('Arrows, Thumbs and Dots', 'testimonials-carousel-elementor'),
          'arrows_thumbs' => esc_html__('Arrows and Thumbs', 'testimonials-carousel-elementor'),
          'arrows_dots'   => esc_html__('Arrows and Dots', 'testimonials-carousel-elementor'),
          'thumbs_dots'   => esc_html__('Thumbs and Dots', 'testimonials-carousel-elementor'),
          'arrows'        => esc_html__('Arrows', 'testimonials-carousel-elementor'),
          'dots'          => esc_html__('Dots', 'testimonials-carousel-elementor'),
          'thumbs'        => esc_html__('Thumbs', 'testimonials-carousel-elementor'),
          'none'          => esc_html__('None', 'testimonials-carousel-elementor'),
        ],
        'frontend_available' => true,
      ]
    );
    $this->end_controls_section();

    // General Styles Section
    $this->start_controls_section(
      'general_styles_section',
      [
        'label' => esc_html__('General Styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );
    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'     => 'background',
        'types'    => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .testimonials-thumbnails.myTestimonialsThumbnail',
      ]
    );

    $this->add_responsive_control(
      'thumbs_wrapper_gap',
      [
        'label'     => esc_html__('Gap', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::SLIDER,
        'range'     => [
          'px' => [
            'min' => 0,
            'max' => 100,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .testimonials-thumbnails__wrapper' => 'gap: {{SIZE}}{{UNIT}};',
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
          '{{WRAPPER}} .thumbnail__slider_1 .thumbnail__content .thumbnail__content-hero .slide-icons i' => 'font-size: {{SIZE}}{{UNIT}}',
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
          '{{WRAPPER}} .thumbnail__slider_1 .thumbnail__content .thumbnail__content-hero .slide-icons i' => 'color: {{VALUE}}',
        ],
        'separator' => 'before',
      ]
    );

    $this->end_controls_section();

    // Images Style Section
    $this->start_controls_section(
      'images_styles_section',
      [
        'label' => esc_html__('Images Styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_responsive_control(
      'image_position',
      [
        'label'              => esc_html__('Position', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::CHOOSE,
        'options'            => [
          'row'            => [
            'title' => esc_html__('Row', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-order-start',
          ],
          'row-reverse'    => [
            'title' => esc_html__('Row-Reverse', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-order-end',
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
        'frontend_available' => true,
        'default'            => 'row',
        'selectors'          => [
          '{{WRAPPER}} .thumbnail__wrapper.thumbnails-content' => 'flex-direction: {{VALUE}}',
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
          '{{WRAPPER}} .testimonials-thumbnails .thumbnail__wrapper .thumbnail__image' => 'max-width: {{SIZE}}{{UNIT}}',
        ],
      ]
    );

    $this->add_responsive_control(
      'slider_height_images',
      [
        'label'      => esc_html__('Height Images', 'testimonials-carousel-elementor'),
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
          '{{WRAPPER}} .testimonials-thumbnails .thumbnail__wrapper .thumbnail__image' => 'height: {{SIZE}}{{UNIT}}',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Box_Shadow::get_type(),
      [
        'name'     => 'slider_image_box_shadow',
        'selector' => '{{WRAPPER}} .testimonials-thumbnails .thumbnail__wrapper .thumbnail__image',
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'     => 'slider_image_border',
        'selector' => '{{WRAPPER}} .testimonials-thumbnails .thumbnail__wrapper .thumbnail__image',
      ]
    );

    $this->add_responsive_control(
      'slider_image_border_radius',
      [
        'label'      => esc_html__('Border Radius', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .testimonials-thumbnails .thumbnail__wrapper .thumbnail__image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );
    $this->end_controls_section();

    // Slider Styles Section
    $this->start_controls_section(
      'slider_styles_section',
      [
        'label' => __('Slider Styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );
    $this->add_responsive_control(
      'name_position',
      [
        'label'              => esc_html__('Name Position', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::CHOOSE,
        'options'            => [
          'row'            => [
            'title' => esc_html__('Row', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-order-start',
          ],
          'row-reverse'    => [
            'title' => esc_html__('Row-Reverse', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-order-end',
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
        'frontend_available' => true,
        'default'            => 'column',
        'selectors'          => [
          '{{WRAPPER}} .thumbnail__content-hero' => 'flex-direction: {{VALUE}}',
        ],
      ]
    );

    $this->add_control(
      'slider_name_color',
      [
        'label'     => esc_html__('Name color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .testimonials-thumbnails .thumbnail__slider_1 .thumbnail__content .thumbnail__title' => 'color: {{VALUE}};',
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'slider_name_typography',
        'label'    => esc_html__('Name typography', 'testimonials-carousel-elementor'),
        'selector' => '{{WRAPPER}} .testimonials-thumbnails .thumbnail__slider_1 .thumbnail__content .thumbnail__title',
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
          '{{WRAPPER}} .testimonials-thumbnails .thumbnail__slider_1 .thumbnail__content .thumbnail__title' => 'text-align: {{VALUE}}',
        ],
      ]
    );

    $this->add_responsive_control(
      'content_position',
      [
        'label'              => esc_html__('Content Position', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::CHOOSE,
        'options'            => [
          'column'         => [
            'title' => esc_html__('Column', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-v-align-bottom',
          ],
          'column-reverse' => [
            'title' => esc_html__('Column-Reverse', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-v-align-top',
          ],
        ],
        'frontend_available' => true,
        'default'            => 'column',
        'selectors'          => [
          '{{WRAPPER}} .thumbnail__wrapper__content.slide-content' => 'flex-direction: {{VALUE}}',
        ],
        'separator'          => 'before',
      ]
    );

    $this->add_control(
      'slider_content_color',
      [
        'label'     => esc_html__('Content color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .testimonials-thumbnails .thumbnail__slider_1 .thumbnail__wrapper__content .thumbnail__description *' => 'color: {{VALUE}};',
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'slider_content_typography',
        'label'    => esc_html__('Content typography', 'testimonials-carousel-elementor'),
        'selector' => '{{WRAPPER}} .testimonials-thumbnails .thumbnail__slider_1 .thumbnail__wrapper__content .thumbnail__description *',
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
          '{{WRAPPER}} .testimonials-thumbnails .thumbnail__slider_1 .thumbnail__wrapper__content .thumbnail__description *' => 'text-align: {{VALUE}}',
        ],
      ]
    );

    $this->end_controls_section();

    // Button Read More Styles Section
    $this->start_controls_section(
      'read_more_styles_section',
      [
        'label' => __('Button Styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'read_more_icon',
      [
        'label'       => __('Choose Icon', 'testimonials-carousel-elementor'),
        'type'        => Controls_Manager::ICONS,
        'default'     => [
          'value'   => 'fas fa-arrow-right',
          'library' => 'fa-solid',
        ],
        'recommended' => [
          'fa-solid' => [
            'arrow-right',
            'caret-right',
            'angle-right',
          ],
        ],
      ]
    );

    $this->add_responsive_control(
      'read_more_section_margin',
      [
        'label'      => esc_html__('Margin', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .thumbnail__button.slide-read-more' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'read_more_section_padding',
      [
        'label'      => esc_html__('Padding', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .thumbnail__button.slide-read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'read_more_icon_position',
      [
        'label'              => esc_html__('Icon Position', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::CHOOSE,
        'options'            => [
          'row'            => [
            'title' => esc_html__('Row', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-order-end',
          ],
          'row-reverse'    => [
            'title' => esc_html__('Row-Reverse', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-order-start',
          ],
          'column'         => [
            'title' => esc_html__('Column', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-v-align-bottom',
          ],
          'column-reverse' => [
            'title' => esc_html__('Column-Reverse', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-v-align-top',
          ],
        ],
        'frontend_available' => true,
        'default'            => 'row',
        'selectors'          => [
          '{{WRAPPER}} .thumbnail__button.slide-read-more' => 'flex-direction: {{VALUE}}',
        ],
      ]
    );

    $this->add_control(
      'slider_read_more_color',
      [
        'label'     => esc_html__('Read more button color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .testimonials-thumbnails .thumbnail__slider_1 .thumbnail__content .thumbnail__button'          => 'color: {{VALUE}}; border-color: {{VALUE}};',
          '{{WRAPPER}} .testimonials-thumbnails .thumbnail__slider_1 .thumbnail__content .thumbnail__button svg path' => 'fill: {{VALUE}}',
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'slider_read_more_typography',
        'label'    => esc_html__('Read more button typography', 'testimonials-carousel-elementor'),
        'selector' => '{{WRAPPER}} .testimonials-thumbnails .thumbnail__slider_1 .thumbnail__content .thumbnail__button',
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'     => 'slider_read_more_border',
        'selector' => '{{WRAPPER}} .testimonials-thumbnails .thumbnail__slider_1 .thumbnail__content .thumbnail__button',
      ]
    );

    $this->add_responsive_control(
      'slider_read_more_border_radius',
      [
        'label'      => esc_html__('Border Radius', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .testimonials-thumbnails .thumbnail__slider_1 .thumbnail__content .thumbnail__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->end_controls_section();

    // Popup Styles Section
    $this->start_controls_section(
      'popup_styles_section',
      [
        'label' => __('Popup Styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );
    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'     => 'popup_background',
        'types'    => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .testimonials-thumbnails#slider-modal .slider-modal-container',
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'     => 'popup_border',
        'selector' => '{{WRAPPER}} .testimonials-thumbnails#slider-modal .slider-modal-container',
      ]
    );

    $this->add_responsive_control(
      'popup_border_radius',
      [
        'label'      => esc_html__('Border Radius', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .testimonials-thumbnails#slider-modal .slider-modal-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Box_Shadow::get_type(),
      [
        'name'     => 'popup_box_shadow',
        'selector' => '{{WRAPPER}} .testimonials-thumbnails#slider-modal .slider-modal-container',
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
          '{{WRAPPER}} .testimonials-thumbnails#slider-modal .thumbnail__slider_1 .thumbnail__content .thumbnail__content-hero .slide-icons i' => 'font-size: {{SIZE}}{{UNIT}}',
        ],
        'separator' => 'before',
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
          '{{WRAPPER}} .testimonials-thumbnails#slider-modal .thumbnail__slider_1 .thumbnail__content .thumbnail__content-hero .slide-icons i' => 'margin-right: {{SIZE}}{{UNIT}}',
        ],
      ]
    );

    $this->add_control(
      'popup_stars_color',
      [
        'label'     => esc_html__('Rating icon color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .testimonials-thumbnails#slider-modal .thumbnail__slider_1 .thumbnail__content .thumbnail__content-hero .slide-icons i' => 'color: {{VALUE}}',
        ],
      ]
    );

    $this->add_responsive_control(
      'popup_name_position',
      [
        'label'              => esc_html__('Name Position', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::CHOOSE,
        'options'            => [
          'row'            => [
            'title' => esc_html__('Row', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-order-start',
          ],
          'row-reverse'    => [
            'title' => esc_html__('Row-Reverse', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-order-end',
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
        'frontend_available' => true,
        'default'            => 'column',
        'selectors'          => [
          '{{WRAPPER}} .testimonials-thumbnails#slider-modal .thumbnail__slider_1 .thumbnail__content-hero' => 'flex-direction: {{VALUE}}',
        ],
        'separator'          => 'before',
      ]
    );

    $this->add_control(
      'popup_name_color',
      [
        'label'     => esc_html__('Name color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .testimonials-thumbnails#slider-modal .thumbnail__slider_1 .thumbnail__content .thumbnail__title' => 'color: {{VALUE}};',
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'popup_name_typography',
        'label'    => esc_html__('Name typography', 'testimonials-carousel-elementor'),
        'selector' => '{{WRAPPER}} .testimonials-thumbnails#slider-modal .thumbnail__slider_1 .thumbnail__content .thumbnail__title',
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
          '{{WRAPPER}} .testimonials-thumbnails#slider-modal .thumbnail__slider_1 .thumbnail__content .thumbnail__title' => 'text-align: {{VALUE}}',
        ],
      ]
    );

    $this->add_responsive_control(
      'popup_content_position',
      [
        'label'              => esc_html__('Content Position', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::CHOOSE,
        'options'            => [
          'column'         => [
            'title' => esc_html__('Column', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-v-align-bottom',
          ],
          'column-reverse' => [
            'title' => esc_html__('Column-Reverse', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-v-align-top',
          ],
        ],
        'frontend_available' => true,
        'default'            => 'column',
        'selectors'          => [
          '{{WRAPPER}} .testimonials-thumbnails#slider-modal .thumbnail__slider_1 .thumbnail__wrapper__content.slide-content' => 'flex-direction: {{VALUE}}',
        ],
        'separator'          => 'before',
      ]
    );
    $this->add_control(
      'popup_content_color',
      [
        'label'     => esc_html__('Content color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .testimonials-thumbnails#slider-modal .thumbnail__slider_1 .thumbnail__wrapper__content .thumbnail__description *' => 'color: {{VALUE}};',
        ],
      ]
    );
    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'popup_content_typography',
        'label'    => esc_html__('Content typography', 'testimonials-carousel-elementor'),
        'selector' => '{{WRAPPER}} .testimonials-thumbnails#slider-modal .thumbnail__slider_1 .thumbnail__wrapper__content .thumbnail__description *',
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
          '{{WRAPPER}} .testimonials-thumbnails#slider-modal .thumbnail__slider_1 .thumbnail__wrapper__content .thumbnail__description *' => 'text-align: {{VALUE}}',
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
        'default'   => 'center',
        'selectors' => [
          '{{WRAPPER}} .testimonials-thumbnails#slider-modal .thumbnail__slider_1 .thumbnail__content .thumbnail__content-hero .slide-icons' => 'text-align: {{VALUE}}',
        ],
      ]
    );
    $this->end_controls_section();

    // Navigation Styles Section
    $this->start_controls_section(
      'navigation_styles_section',
      [
        'label' => __('Navigation Styles', 'testimonials-carousel-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'icon_scroll_left',
      [
        'label'       => __('Choose Left Scroll Icon', 'testimonials-carousel-elementor'),
        'type'        => Controls_Manager::ICONS,
        'default'     => [
          'value'   => 'fas fa-arrow-left',
          'library' => 'fa-solid',
        ],
        'recommended' => [
          'fa-solid' => [
            'arrow-left',
            'caret-left',
            'angle-left',
          ],
        ],
      ]
    );
    $this->add_control(
      'icon_scroll_right',
      [
        'label'       => __('Choose Right Scroll Icon', 'testimonials-carousel-elementor'),
        'type'        => Controls_Manager::ICONS,
        'default'     => [
          'value'   => 'fas fa-arrow-right',
          'library' => 'fa-solid',
        ],
        'recommended' => [
          'fa-solid' => [
            'arrow-right',
            'caret-right',
            'angle-right',
          ],
        ],
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
          '{{WRAPPER}} .myTestimonialsThumbnail .swiper-button-prev, {{WRAPPER}} .myTestimonialsThumbnail .swiper-button-next'             => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
          '{{WRAPPER}} .myTestimonialsThumbnail .swiper-button-prev:after, {{WRAPPER}} .myTestimonialsThumbnail .swiper-button-next:after' => 'font-size: calc({{SIZE}}{{UNIT}} / 3);',
        ],
      ]
    );

    $this->add_control(
      'arrows_color',
      [
        'label'     => esc_html__('Arrows color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myTestimonialsThumbnail .swiper-button-prev:after, {{WRAPPER}} .myTestimonialsThumbnail .swiper-button-next:after'       => 'color: {{VALUE}};',
          '{{WRAPPER}} .myTestimonialsThumbnail .swiper-button-prev, {{WRAPPER}} .myTestimonialsThumbnail .swiper-button-next'                   => 'border-color: {{VALUE}}; color: {{VALUE}}',
          '{{WRAPPER}} .myTestimonialsThumbnail .swiper-button-prev svg path, {{WRAPPER}} .myTestimonialsThumbnail .swiper-button-next svg path' => 'fill: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'arrows_hover_color',
      [
        'label'     => esc_html__('Arrows hover color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myTestimonialsThumbnail .swiper-button-prev:hover::after, {{WRAPPER}} .myTestimonialsThumbnail .swiper-button-next:hover::after' => 'color: {{VALUE}};',
          '{{WRAPPER}} .myTestimonialsThumbnail .swiper-button-prev:hover, {{WRAPPER}} .myTestimonialsThumbnail .swiper-button-next:hover'               => 'background: {{VALUE}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'     => 'arrows_border',
        'selector' => '{{WRAPPER}} .myTestimonialsThumbnail .swiper-button-prev, {{WRAPPER}} .myTestimonialsThumbnail .swiper-button-next',
      ]
    );

    $this->add_responsive_control(
      'arrows_border_radius',
      [
        'label'      => esc_html__('Border Radius', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .myTestimonialsThumbnail .swiper-button-prev, {{WRAPPER}} .myTestimonialsThumbnail .swiper-button-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
          '{{WRAPPER}} .myTestimonialsThumbnail .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
          '{{WRAPPER}} .myTestimonialsThumbnail .swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'dots_inactive_color',
      [
        'label'     => esc_html__('Dots color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myTestimonialsThumbnail .swiper-pagination-bullet' => 'background: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'dots_inactive_hover_color',
      [
        'label'     => esc_html__('Dots hover color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myTestimonialsThumbnail .swiper-pagination-bullet:hover' => 'background: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'active_dot_color',
      [
        'label'     => esc_html__('Active dot color', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .myTestimonialsThumbnail .swiper-pagination-bullet-active' => 'background: {{VALUE}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'     => 'dots_border',
        'selector' => '{{WRAPPER}} .myTestimonialsThumbnail .swiper-pagination-bullet',
      ]
    );

    $this->add_responsive_control(
      'dots_border_radius',
      [
        'label'      => esc_html__('Border Radius', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .myTestimonialsThumbnail .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'heading_style_thumbs',
      [
        'label'     => esc_html__('Thumbs', 'testimonials-carousel-elementor'),
        'type'      => Controls_Manager::HEADING,
        'separator' => 'before',
      ]
    );

    $this->add_responsive_control(
      'slider_thumbs_position',
      [
        'label'              => esc_html__('Position', 'testimonials-carousel-elementor'),
        'type'               => Controls_Manager::CHOOSE,
        'options'            => [
          'column'         => [
            'title' => esc_html__('Column', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-v-align-bottom',
          ],
          'column-reverse' => [
            'title' => esc_html__('Column-Reverse', 'testimonials-carousel-elementor'),
            'icon'  => 'eicon-v-align-top',
          ],
        ],
        'frontend_available' => true,
        'default'            => 'column',
        'selectors'          => [
          '{{WRAPPER}} .testimonials-thumbnails__wrapper' => 'flex-direction: {{VALUE}}',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Box_Shadow::get_type(),
      [
        'name'     => 'slider_thumbs_box_shadow',
        'selector' => '{{WRAPPER}} .testimonials-thumbnails .thumbnail__slider_2 .swiper-slide .thumbnail__image',
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'     => 'slider_thumbs_border',
        'selector' => '{{WRAPPER}} .testimonials-thumbnails .thumbnail__slider_2 .swiper-slide .thumbnail__image',
      ]
    );

    $this->add_responsive_control(
      'slider_thumbs_border_radius',
      [
        'label'      => esc_html__('Border Radius', 'testimonials-carousel-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .testimonials-thumbnails .thumbnail__slider_2 .swiper-slide .thumbnail__image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
          'data-navigation-myswiper'    => esc_attr($settings['navigation']),
          'data-speed-myswiper'         => esc_attr($settings['slider_speed']),
          'data-autoplay-myswiper'      => esc_attr($settings['autoplay']),
          'data-autoplayspeed-myswiper' => esc_attr($settings['autoplay_speed']),
          'data-sliderloop-myswiper'    => esc_attr($settings['slider_loop']),
          'data-showlinetext-myswiper'  => esc_attr($settings['show_line_text']),
        ]
      );
    }

    if ($settings['slide']) {
      if (get_plugin_data(ELEMENTOR__FILE__)['Version'] < "3.5.0") { ?>
        <div <?php echo $this->get_render_attribute_string('my_swiper'); ?>></div>
      <?php } ?>

      <section id="thumbnails" class="testimonials-thumbnails myTestimonialsThumbnail mySwiper <?php if (
        esc_attr($settings['navigation']) === "dots"
        || esc_attr($settings['navigation']) === "thumbs_dots"
        || esc_attr($settings['navigation']) === "thumbs"
        || esc_attr($settings['navigation']) === "none"
      ) { ?>slider-arrows-disabled<?php } ?>">
        <div class="testimonials-thumbnails__wrapper">
          <div class="swiper thumbnail__slider_1 <?php if (esc_attr($settings['navigation']) === "arrows_dots"
            || esc_attr($settings['navigation']) === "arrows") { ?>thumbnail__slider_1-width<?php } ?>">
            <div class="swiper-wrapper">
              <?php foreach ($settings['slide'] as $item) { ?>
                <div class="swiper-slide">
                  <div class="thumbnail__wrapper thumbnails-content">
                    <img class="thumbnail__image" src="<?php echo esc_url($item['slide_image']['url']) ?>"
                         alt="<?php echo esc_url($item['slide_image']['alt']) ?>"/>

                    <div class="thumbnail__wrapper__content slide-content">
                      <div class="thumbnail__content">
                        <div class="thumbnail__content-hero">
                          <h1 class="thumbnail__title"><?php echo wp_kses($item['slide_title'], []); ?></h1>

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

                        <div class="thumbnail__button slide-read-more">
                          <?php echo wp_kses($item['slide_read_more'], []); ?>

                          <?php Icons_Manager::render_icon($settings['read_more_icon'], ['aria-hidden' => 'true']); ?>
                        </div>
                      </div>

                      <div class="thumbnail__description slide-description"
                           style="line-height: 22px;-webkit-line-clamp: <?php echo esc_attr($settings['show_line_text']); ?>">
                        <?php echo wp_kses_post($item['slide_content']); ?>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>

          <div
              class="<?php if (esc_attr($settings['navigation']) === "arrows_dots"
                || esc_attr($settings['navigation']) === "arrows") { ?>arrows__settings<?php } else { ?>p-relative<?php }
              if (esc_attr($settings['navigation']) === "none") { ?> d-none<?php } ?>">
            <div class="swiper thumbnail__slider_2 <?php if (
              esc_attr($settings['navigation']) === "dots"
              || esc_attr($settings['navigation']) === "none"
              || esc_attr($settings['navigation']) === "arrows_dots"
              || esc_attr($settings['navigation']) === "arrows"
            ) { ?>d-none<?php } ?>">
              <div class="swiper-wrapper">
                <?php foreach ($settings['slide'] as $item) { ?>
                  <div class="swiper-slide">
                    <img class="thumbnail__image" src="<?php echo esc_url($item['slide_image']['url']) ?>"
                         alt="<?php echo esc_url($item['slide_image']['alt']) ?>"/>
                  </div>
                <?php } ?>
              </div>
            </div>

            <div class="swiper-button-prev">
              <?php Icons_Manager::render_icon($settings['icon_scroll_left'], ['aria-hidden' => 'true']); ?>
            </div>
            <div class="swiper-pagination <?php if (
              esc_attr($settings['navigation']) === "arrows_thumbs"
              || esc_attr($settings['navigation']) === "arrows"
              || esc_attr($settings['navigation']) === "thumbs"
              || esc_attr($settings['navigation']) === "none"
            ) { ?>d-none<?php } ?>"></div>
            <div class="swiper-button-next">
              <?php Icons_Manager::render_icon($settings['icon_scroll_right'], ['aria-hidden' => 'true']); ?>
            </div>
          </div>
        </div>
      </section>

      <div class="slider-modal slider-testimonials-thumbnails-modal testimonials-thumbnails" id="slider-modal">
        <div class="slider-modal-bg slider-modal-exit"></div>
        <div class="slider-modal-container slider-container-background slider-container-block-background">
          <div class="slider-modal-container-info swiper thumbnail__slider_1"></div>
          <button class="slider-modal-close slider-modal-exit icon-close"></button>
        </div>
      </div>
    <?php } ?>
  <?php }
}
