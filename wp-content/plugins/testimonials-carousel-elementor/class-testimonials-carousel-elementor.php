<?php
/**
 * Testimonials_Carousel_Elementor class.
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
if (!defined('ABSPATH')) {
  // Exit if accessed directly.
  exit;
}

/**
 * Main Testimonials Carousel Elementor Class
 *
 * The init class that runs the Testimonials Carousel for Elementor plugin.
 * Intended To make sure that the plugin's minimum requirements are met.
 */
final class Testimonials_Carousel_Elementor
{
  /**
   * Minimum Elementor Version
   *
   * @since 11.2.0
   * @var string Minimum Elementor version required to run the plugin.
   */
  const MINIMUM_ELEMENTOR_VERSION = '3.10.0';
  /**
   * Minimum PHP Version
   *
   * @since 11.2.0
   * @var string Minimum PHP version required to run the plugin.
   */
  const MINIMUM_PHP_VERSION = '7.4.1';

  /**
   * Constructor
   *
   * @since  11.2.0
   * @access public
   */
  public function __construct()
  {
    add_action('elementor/admin/after_create_settings/elementor', [$this, 'register_new_admin_fields'], 15);
    add_action('elementor/elements/categories_registered', [$this, 'register_category']);
    // Load the translation.
    add_action('init', [$this, 'i18n']);
    // Initialize the plugin.
    add_action('plugins_loaded', [$this, 'init']);

    add_action('wp_ajax_save_testimonials_option', [$this, 'save_testimonials_option_callback']);
  }

  /**
   *
   * Register Testimonials Carousel Elementor category
   *
   */
  public function register_category($elements_manager)
  {

    $elements_manager->add_category(
      'testimonials_carousel',
      [
        'title' => __('Testimonials Carousel', 'testimonials-carousel-elementor'),
        'icon'  => 'fa fa-plug',
      ]
    );

    $elements_manager->add_category(
      '3d_animated_carousel',
      [
        'title' => __('3D Animated Carousel', 'testimonials-carousel-elementor'),
        'icon'  => 'fa fa-plug',
      ]
    );

    $elements_manager->add_category(
      'testimonials_section',
      [
        'title' => __('Section With Carousel', 'testimonials-carousel-elementor'),
        'icon'  => 'fa fa-plug',
      ]
    );
  }

  /**
   *
   * Register Testimonials Carousel Elementor new field to the Elementor settings
   *
   */

  public function register_new_admin_fields($settings)
  {
    $settings->add_section('general', 'openai', [
      'callback' => function () {
        echo '<hr><h2>' . esc_html__('Testimonials API Key', 'testimonials-carousel-elementor') . '</h2>';
      },
      'fields'   => [
        'openai_api_key'              => [
          'label'      => esc_html__('API Key', 'testimonials-carousel-elementor'),
          'field_args' => [
            'type' => 'text',
          ],
        ],
        'openai_api_key_verification' => [
          'field_args' => [
            'type' => 'raw_html',
            'html' => '<button type="button" class="button elementor-button-spinner" onclick="verifyOpenAIKey();" id="elementor_openai_api_key_verification_button">Validate API Key</button>',
          ],
        ],
      ],
    ]);
    require_once 'class-testimonials-openai-verification-handler.php';
    wp_enqueue_style('testimonials-carousel-menu', plugins_url('/assets/css/testimonials-carousel-menu.min.css', TESTIMONIALS_CAROUSEL_ELEMENTOR));
  }

  function save_testimonials_option_callback()
  {
    if (!is_user_logged_in()) {
      wp_send_json_error('User not logged in.');
      die();
    }

    if (!current_user_can('manage_options')) {
      wp_send_json_error('User does not have permission.');
      die();
    }

    if (isset($_POST['value'])) {
      $value = sanitize_text_field($_POST['value']);
      update_option('testimonials_openai_validate', $value);
      wp_send_json_success();
    } else {
      wp_send_json_error('Value is missing.');
    }

    die();
  }


  /**
   * Load Textdomain
   *
   * Load plugin localization files.
   * Fired by `init` action hook.
   *
   * @since  11.2.0
   * @access public
   */
  public function i18n()
  {
    load_plugin_textdomain('testimonials-carousel-elementor');
  }

  /**
   * Initialize the plugin
   *
   * Validates that Elementor is already loaded.
   * Checks for basic plugin requirements, if one check fail don't continue,
   * if all check have passed include the plugin class.
   *
   * Fired by `plugins_loaded` action hook.
   *
   * @since  11.2.0
   * @access public
   */
  public function init()
  {
    // Check if Elementor installed and activated.
    if (!did_action('elementor/loaded')) {
      add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
      return;
    }

    // Check for required Elementor version.
    if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
      add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
      return;
    }

    // Check for required PHP version.
    if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
      add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
      return;
    }

    if (get_option('elementor_experiment-e_swiper_latest') === 'inactive') {
      update_option('elementor_experiment-e_swiper_latest', 'active');
    }

    // Once we get here, We have passed all validation checks so we can safely include our widgets.
    require_once 'class-widgets.php';

    // Elementor Editor Styles
    add_action('elementor/editor/after_enqueue_scripts', [__CLASS__, 'editor_scripts']);

    // Handler for OpenAI
    add_action('elementor/editor/after_enqueue_scripts', [$this, 'openai_event_controller_script']);
  }

  /**
   *
   * Enqueue Elementor Editor Styles
   *
   */
  public static function editor_scripts()
  {
    wp_enqueue_style('testimonials-carousel-editor', plugins_url('/assets/css/testimonials-carousel-editor.min.css', TESTIMONIALS_CAROUSEL_ELEMENTOR));
  }

  /**
   * Admin notice
   *
   * Warning when the site doesn't have Elementor installed or activated.
   *
   * @since  11.2.0
   * @access public
   */
  public function admin_notice_missing_main_plugin()
  {
    deactivate_plugins(plugin_basename(TESTIMONIALS_CAROUSEL_ELEMENTOR));

    printf(
      sprintf(
        '<div class="notice notice-warning is-dismissible"><p><strong>"%1$s"</strong> requires <strong>"%2$s"</strong> to be installed and activated.</p></div>',
        'Testimonials Carousel Elementor',
        'Elementor'
      )
    );

    echo '<style>#message { display: none; }</style>';
  }

  /**
   * Admin notice
   *
   * Warning when the site doesn't have a minimum required Elementor version.
   *
   * @since  11.2.0
   * @access public
   */
  public function admin_notice_minimum_elementor_version()
  {
    deactivate_plugins(plugin_basename(TESTIMONIALS_CAROUSEL_ELEMENTOR));

    printf(
      sprintf(
        '<div class="notice notice-warning is-dismissible"><p><strong>"%1$s"</strong> requires <strong>"%2$s"</strong> version %3$s or greater.</p></div>',
        'Testimonials Carousel Elementor',
        'Elementor',
        self::MINIMUM_ELEMENTOR_VERSION
      )
    );

    echo '<style>#message { display: none; }</style>';
  }

  /**
   * Admin notice
   *
   * Warning when the site doesn't have a minimum required PHP version.
   *
   * @since  11.2.0
   * @access public
   */
  public function admin_notice_minimum_php_version()
  {
    deactivate_plugins(plugin_basename(TESTIMONIALS_CAROUSEL_ELEMENTOR));

    printf(
      sprintf(
        '<div class="notice notice-warning is-dismissible"><p><strong>"%1$s"</strong> requires PHP version %3$s or greater.</p></div>',
        'Testimonials Carousel Elementor',
        'Elementor',
        self::MINIMUM_PHP_VERSION
      )
    );

    echo '<style>#message { display: none; }</style>';
  }

  /**
   *
   * @since  11.2.0
   * @access public
   */
  public function openai_event_controller_script()
  {
    require_once 'class-testimonials-openai-handler.php';
  }
}

// Instantiate Testimonials_Carousel_Elementor.
new Testimonials_Carousel_Elementor();
