<?php
/**
 * Plugin Name: Testimonial Slider and Showcase
 * Plugin URI: https://radiustheme.com
 * Description: Best Testimonial Slider and Showcase plugin for WordPress website. Testimonials Slider plugin is most customizable and developer friendly testimonial plugin to manage your customers testimonial.
 * Author: RadiusTheme
 * Version: 2.3.11
 * Author URI: https://radiustheme.com
 * Tag: testimonials slider, testimonial, testimonials,testimonial slide, testimonial showcase, responsive testimonial, testimonial plugin
 * Text Domain: testimonial-slider-showcase
 * Domain Path: /languages
 *
 * @package RT_TSS
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

define( 'TSS_VERSION', '2.3.11' );
define( 'TSS_AUTHOR', 'RadiusTheme' );
define( 'EDD_TSS_STORE_URL', 'https://www.radiustheme.com' );
define( 'EDD_TSS_ITEM_ID', 11023 );
define( 'TSS_ITEM_NAME', 'Testimonial Slider And Showcase' );
define( 'TSS_PLUGIN_PATH', dirname( __FILE__ ) );
define( 'TSS_PLUGIN_ACTIVE_FILE_NAME', __FILE__ );
define( 'TSS_PLUGIN_URL', plugins_url( '', __FILE__ ) );
define( 'TSS_LANGUAGE_PATH', dirname( plugin_basename( __FILE__ ) ) . '/languages' );

require 'lib/init.php';
