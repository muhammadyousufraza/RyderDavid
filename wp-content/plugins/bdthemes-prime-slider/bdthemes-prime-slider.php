<?php

/**
 * Plugin Name: Prime Slider Pro
 * Plugin URI: https://primeslider.pro/
 * Description: Prime Slider is a packed of elementor widget that gives you some awesome header and slider combination for your website.
 * Version: 3.13.3
 * Update URI: https://primeslider.pro
 * Author: BdThemes
 * Author URI: https://bdthemes.com/
 * Text Domain: bdthemes-prime-slider
 * Domain Path: /languages
 * License: GPL3
 * Elementor requires at least: 3.0.0
 * Elementor tested up to: 3.20.2
 */

// Some pre define value for easy use

if ( ! defined( 'BDTPS_PRO_VER' ) ) {
	define( 'BDTPS_PRO_VER', '3.13.3' );
}
/**
 * Required version is very important
 * Required on Core/Base file changes
 * If Base function changes then must release a Pro
 * That means Must have free sufficient version to works
 */
define( 'BDTPS_CORE_REQUIRED_VERSION', '3.11.14' );

if ( ! defined( 'BDTPS_PRO__FILE__' ) ) {
	define( 'BDTPS_PRO__FILE__', __FILE__ );
}

// Helper function here
include dirname( __FILE__ ) . '/includes/helper.php';
include dirname( __FILE__ ) . '/includes/utils.php';


/**
 * Plugin load here correctly
 * Also loaded the language file from here
 */
if ( ! function_exists( 'prime_slider_pro_load_plugin' ) ) {
	function prime_slider_pro_load_plugin() {
		load_plugin_textdomain( 'bdthemes-prime-slider', false, basename( dirname( __FILE__ ) ) . '/languages' );

		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', 'prime_slider_pro_fail_load' );
			return;
		}

		if ( ! did_action( 'bdthemes_prime_slider_lite/init' ) ) {
			add_action( 'admin_notices', 'ps_core_load_failed' );
			return;
		}

		if ( ! _is_prime_slider_core_version_sufficient() ) {
			add_action( 'admin_notices', 'not_ps_core_version_sufficient' );
			return;
		}

		/**
		 * Finally, Load the Pro plugin
		 */

		// Filters for developer
		require BDTPS_PRO_PATH . 'includes/prime-slider-filters.php';
		// Prime Slider widget and assets loader
		require BDTPS_PRO_PATH . 'loader.php';
	}
}

add_action( 'plugins_loaded', 'prime_slider_pro_load_plugin' );

/**
 * Check Elementor installed and activated correctly
 */
function ps_core_load_failed() {
	$screen = get_current_screen();
	if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
		return;
	}

	$plugin = 'bdthemes-prime-slider-lite/bdthemes-prime-slider.php';

	if ( _is_prime_slider_core_installed() ) {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		$activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
		$admin_message  = '<p>' . esc_html__( 'Ops! Prime Slider Pro not working because you need to activate the Prime Slider (Core) plugin first.', 'bdthemes-prime-slider' ) . '</p>';
		$admin_message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, esc_html__( 'Activate Prime Slider (Core) Now', 'bdthemes-prime-slider' ) ) . '</p>';
	} else {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		$install_url = wp_nonce_url( self_admin_url( 'plugin-install.php?s=Prime+Slider+Lite+Addons+For+Elementor+BdThemes&tab=search&type=term' ), 'install-plugin_elementor' );

		$admin_message = '<p>' . esc_html__( 'Ops! Prime Slider Pro not working because you need to install the Prime Slider (Core) plugin', 'bdthemes-prime-slider' ) . '</p>';
		$admin_message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, esc_html__( 'Install Prime Slider (Core) Now', 'bdthemes-prime-slider' ) ) . '</p>';
	}

	echo '<div class="error">' . wp_kses_post( $admin_message ) . '</div>';
}

/**
 * Check Elementor installed and activated correctly
 */
if ( ! function_exists( 'prime_slider_pro_fail_load' ) ) {
	function prime_slider_pro_fail_load() {
		$screen = get_current_screen();
		if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
			return;
		}
		$plugin = 'elementor/elementor.php';

		if ( _is_elementor_installed() ) {
			if ( ! current_user_can( 'activate_plugins' ) ) {
				return;
			}
			$activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
			$admin_message  = '<p>' . esc_html__( 'Ops! Prime Slider not working because you need to activate the Elementor plugin first.', 'bdthemes-prime-slider' ) . '</p>';
			$admin_message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, esc_html__( 'Activate Elementor Now', 'bdthemes-prime-slider' ) ) . '</p>';
		} else {
			if ( ! current_user_can( 'install_plugins' ) ) {
				return;
			}
			$install_url   = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
			$admin_message = '<p>' . esc_html__( 'Ops! Prime Slider not working because you need to install the Elementor plugin', 'bdthemes-prime-slider' ) . '</p>';
			$admin_message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, esc_html__( 'Install Elementor Now', 'bdthemes-prime-slider' ) ) . '</p>';
		}

		echo '<div class="error">' . wp_kses_post( $admin_message ) . '</div>';
	}
}

function not_ps_core_version_sufficient() {
	$admin_message = '<p>' . esc_html__( 'Ops! Prime Slider Pro not working because your Free/Core version is not sufficient/updated. You must install at least ' . BDTPS_CORE_REQUIRED_VERSION . ' version of the Free/Core version.', 'bdthemes-prime-slider' ) . '</p>';
	echo '<div class="error">' . wp_kses_post( $admin_message ) . '</div>';
}

/**
 * Check the elementor installed or not
 */
if ( ! function_exists( '_is_elementor_installed' ) ) {
	function _is_elementor_installed() {
		$file_path         = 'elementor/elementor.php';
		$installed_plugins = get_plugins();
		return isset( $installed_plugins[ $file_path ] );
	}
}

if ( ! function_exists( '_is_prime_slider_core_installed' ) ) {

	function _is_prime_slider_core_installed() {
		$file_path         = 'bdthemes-prime-slider-lite/bdthemes-prime-slider.php';
		$installed_plugins = get_plugins();

		return isset( $installed_plugins[ $file_path ] );
	}
}

if ( ! function_exists( '_is_prime_slider_core_version_sufficient' ) ) {
	function _is_prime_slider_core_version_sufficient() {
		if ( ! defined( 'BDTPS_CORE_VER' ) ) {
			return false;
		}
		if ( version_compare( BDTPS_CORE_VER, BDTPS_CORE_REQUIRED_VERSION, '>=' ) ) {
			return true;
		}
		return false;
	}
}