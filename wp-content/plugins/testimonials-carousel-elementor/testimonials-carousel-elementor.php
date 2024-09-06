<?php
/**
 * Testimonial Carousel For Elementor WordPress Plugin
 *
 * @package TestimonialsCarouselElementor
 *
 * Plugin Name: Testimonial Carousel For Elementor
 * Description: The compact Testimonial Carousel for Elementor lets you show long text reviews in Pop-Up of Carousel Slider.
 * Plugin URI:
 * Version:     11.2.0
 * Author:      UAPP GROUP
 * Author URI:  https://uapp.group/
 * Requires PHP: 7.4.1
 * Requires at least: 5.9
 * Text Domain: testimonials-carousel-elementor
 */
define('TESTIMONIALS_CAROUSEL_ELEMENTOR', __FILE__);

/**
 * Plugin Version
 *
 * @since 11.2.0
 * @var string The plugin version.
 */
define('TESTIMONIALS_VERSION', '11.2.0');

/**
 * Include the Testimonials_Carousel_Elementor class.
 */
require plugin_dir_path(TESTIMONIALS_CAROUSEL_ELEMENTOR) . 'class-testimonials-carousel-elementor.php';
