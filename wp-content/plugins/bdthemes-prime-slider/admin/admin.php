<?php

namespace PrimeSliderPro;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin class
 */

class Admin {

	public function __construct() {
		require_once( BDTPS_PRO_ADMIN_PATH . 'license-settings.php' );
	}
}

// Load admin class for admin related content process
if ( is_admin() ) {
	if ( ! defined( 'BDTPS_PRO_CH' ) ) {
		new Admin();
	}
}
