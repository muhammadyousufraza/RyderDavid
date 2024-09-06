<?php
/**
 * Widgets class.
 *
 * @category   Class
 * @package    TestimonialsCarouselElementor
 * @subpackage WordPress
 * @author
 * @copyright
 * @license    https://opensource.org/licenses/GPL-3.0 GPL-3.0-only
 * @link
 * @since      11.2.0
 * php version 7.4.1
 */

namespace TestimonialsCarouselElementor;

// Security Note: Blocks direct access to the plugin PHP files.
use Elementor\Plugin;

defined('ABSPATH') || die();

/**
 * Class Plugin
 *
 * Main Plugin class
 *
 * @since 11.2.0
 */
class Widgets
{

  /**
   * Instance
   *
   * @since  11.2.0
   * @access private
   * @static
   *
   * @var Plugin The single instance of the class.
   */
  private static $instance = null;

  /**
   * Instance
   *
   * Ensures only one instance of the class is loaded or can be loaded.
   *
   * @return Plugin An instance of the class.
   * @since  11.2.0
   * @access public
   *
   */
  public static function instance()
  {
    if (is_null(self::$instance)) {
      self::$instance = new self();
    }

    return self::$instance;
  }

  /**
   * Include Widgets files
   *
   * Load widgets files
   *
   * @since  11.2.0
   * @access private
   */
  private function include_widgets_files()
  {
    // Testimonials Carousel
    require_once 'widgets/testimonials-carousel/class-testimonialscarousel.php';
    require_once 'widgets/testimonials-carousel/class-testimonialscarousel-logo.php';
    require_once 'widgets/testimonials-carousel/class-testimonialscarousel-centered.php';
    require_once 'widgets/testimonials-carousel/class-testimonialscarousel-bottom.php';
    require_once 'widgets/testimonials-carousel/class-testimonialscarousel-gallery-coverflow.php';
    require_once 'widgets/testimonials-carousel/class-testimonialscarousel-employees.php';
    require_once 'widgets/testimonials-carousel/class-testimonialscarousel-blog.php';
    require_once 'widgets/testimonials-carousel/class-testimonialscarousel-creative.php';
    require_once 'widgets/testimonials-carousel/class-testimonialscarousel-thumbnails.php';

    // 3D Animated Carousel
    require_once 'widgets/animated-carousel/class-testimonialscarousel-coverflow.php';
    require_once 'widgets/animated-carousel/class-testimonialscarousel-cube.php';
    require_once 'widgets/animated-carousel/class-testimonialscarousel-cube-360.php';

    // Sections With Carousels
    require_once 'widgets/section-with-carousel/class-section-with-cube.php';
    require_once 'widgets/section-with-carousel/class-section-with-cube-360.php';
  }

  /**
   * Include Widgets Templates files
   *
   * Load widgets templates files
   *
   * @since  11.2.0
   * @access private
   */
  private function include_widgets_templates_files()
  {
    require_once('widgets-templates/creative-slider/default.php');
    require_once('widgets-templates/creative-slider/creative-with-background.php');
  }

  /**
   * Include Widgets Templates controls
   *
   * Load widgets templates controls
   *
   * @since  11.2.0
   * @access private
   */
  private function include_widgets_templates_controls()
  {
    require_once('widgets-templates/creative-slider/control-elements/controls-creative-carousel.php');
    require_once('widgets-templates/creative-slider/control-elements/controls-creative-with-background.php');
  }

  /**
   * Register Widgets
   *
   * Register new Elementor widgets.
   *
   * @since  11.2.0
   * @access public
   */
  public function register_widgets()
  {
    // It's now safe to include Widgets files.
    $this->include_widgets_files();

    // It's now safe to include Widgets Templates.
    $this->include_widgets_templates_files();

    // It's now safe to include Widgets Controls.
    $this->include_widgets_templates_controls();

    // Register the plugin widget Testimonials Carousel.
    Plugin::instance()->widgets_manager->register_widget_type(new Widgets\TestimonialsCarousel());
    Plugin::instance()->widgets_manager->register_widget_type(new Widgets\TestimonialsCarousel_Logo());
    Plugin::instance()->widgets_manager->register_widget_type(new Widgets\TestimonialsCarousel_Centered());
    Plugin::instance()->widgets_manager->register_widget_type(new Widgets\TestimonialsCarousel_Bottom());
    Plugin::instance()->widgets_manager->register_widget_type(new Widgets\TestimonialsCarousel_Gallery_Coverflow());
    Plugin::instance()->widgets_manager->register_widget_type(new Widgets\TestimonialsCarousel_Employees());
    Plugin::instance()->widgets_manager->register_widget_type(new Widgets\TestimonialsCarousel_Blog());
    Plugin::instance()->widgets_manager->register_widget_type(new Widgets\TestimonialsCarousel_Creative());
    Plugin::instance()->widgets_manager->register_widget_type(new Widgets\TestimonialsCarousel_Thumbnails());

    // Register the plugin widget 3d Animated Carousel.
    Plugin::instance()->widgets_manager->register_widget_type(new Widgets\TestimonialsCarousel_Coverflow());
    Plugin::instance()->widgets_manager->register_widget_type(new Widgets\TestimonialsCarousel_Cube());
    Plugin::instance()->widgets_manager->register_widget_type(new Widgets\TestimonialsCarousel_Cube_360());

    // Register the plugin widget Section With Carousel.
    Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Section_With_Cube());
    Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Section_With_Cube_360());
  }

  /**
   *  Plugin class constructor
   *
   * Register plugin action hooks and filters
   *
   * @since  11.2.0
   * @access public
   */
  public function __construct()
  {
    // Register the widgets.
    add_action('elementor/widgets/widgets_registered', array($this, 'register_widgets'));
  }
}

// Instantiate the Widgets class.
Widgets::instance();
