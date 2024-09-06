<?php
/**
 * Prime Slider Pro Helper Functions
 *
 * @package Prime Slider Pro
 */

use Elementor\Plugin;

/**
 * You can easily add white label branding for for extended license or multi site license.
 * Don't try for regular license otherwise your license will be invalid.
 * return white label
 */
define( 'BDTPS_PRO_PNAME', basename( dirname( BDTPS_PRO__FILE__ ) ) );
define( 'BDTPS_PRO_PBNAME', plugin_basename( BDTPS_PRO__FILE__ ) );
define( 'BDTPS_PRO_PATH', plugin_dir_path( BDTPS_PRO__FILE__ ) );
define( 'BDTPS_PRO_URL', plugins_url( '/', BDTPS_PRO__FILE__ ) );
define( 'BDTPS_PRO_ADMIN_PATH', BDTPS_PRO_PATH . 'admin/' );
define( 'BDTPS_PRO_ADMIN_URL', BDTPS_PRO_URL . 'admin/' );
define( 'BDTPS_PRO_MODULES_PATH', BDTPS_PRO_PATH . 'modules/' );
define( 'BDTPS_PRO_INC_PATH', BDTPS_PRO_PATH . 'includes/' );
define( 'BDTPS_PRO_ASSETS_URL', BDTPS_PRO_URL . 'assets/' );
define( 'BDTPS_PRO_ASSETS_PATH', BDTPS_PRO_PATH . 'assets/' );
define( 'BDTPS_PRO_MODULES_URL', BDTPS_PRO_URL . 'modules/' );

if ( ! defined( 'BDTPS' ) ) {
	define( 'BDTPS', '' );
} //Add prefix for all widgets <span class="bdt-widget-badge"></span>
if ( ! defined( 'BDTPS_PRO_CP' ) ) {
	define( 'BDTPS_PRO_CP', '<span class="bdt-ps-widget-badge"></span>' );
} //Add prefix for all widgets <span class="bdt-widget-badge"></span>
if ( ! defined( 'BDTPS_PRO_NC' ) ) {
	define( 'BDTPS_PRO_NC', '<span class="bdt-ps-new-control"></span>' );
} // if you have any custom style
if ( ! defined( 'BDTPS_PRO_SLUG' ) ) {
	define( 'BDTPS_PRO_SLUG', 'prime-slider' );
} // set your own alias
if ( ! defined( 'BDTPS_PRO_TITLE' ) ) {
	define( 'BDTPS_PRO_TITLE', 'Prime Slider' );
} // set your own alias
// if (true === true) {
if ( true === true ) {
	if ( ! defined( 'BDTPS_PRO_PC' ) ) {
		define( 'BDTPS_PRO_PC', '' );
	}
	define( 'BDTPS_PRO_IS_PC', '' );
} else {
	if ( ! defined( 'BDTPS_PRO_PC' ) ) {
		define( 'BDTPS_PRO_PC', '<span class="bdt-ps-pro-control"></span>' );
	}
	define( 'BDTPS_PRO_IS_PC', 'bdt-ps-disabled-control' );
}


function prime_slider_pro_is_edit() {
	return Plugin::$instance->editor->is_edit_mode();
}

function prime_slider_pro_is_preview() {
	return Plugin::$instance->preview->is_preview_mode();
}


/**
 * Show any alert by this function
 */
function prime_slider_pro_alert( $message, $type = 'warning', $close = true ) {
	?>
	<div class="bdt-alert-<?php echo esc_attr( $type ); ?>" bdt-alert>
		<?php if ( $close ) : ?>
			<a class="bdt-alert-close" bdt-close></a>
		<?php endif; ?>
		<?php echo wp_kses_post( $message ); ?>
	</div>
	<?php
}
