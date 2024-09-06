<?php

namespace PrimeSliderPro;

use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

/**
 * Main class for element pack
 */
class Prime_Slider_Loader {

	/**
	 * @var Prime_Slider_Loader
	 */
	private static $_instance;

	/**
	 * @var Manager
	 */
	private $_modules_manager;

	private $classes_aliases = [ 
		'PrimeSliderPro\Modules\PanelPostsControl\Module'                       => 'PrimeSliderPro\Modules\QueryControl\Module',
		'PrimeSliderPro\Modules\PanelPostsControl\Controls\Group_Control_Posts' => 'PrimeSliderPro\Modules\QueryControl\Controls\Group_Control_Posts',
		'PrimeSliderPro\Modules\PanelPostsControl\Controls\Query'               => 'PrimeSliderPro\Modules\QueryControl\Controls\Query',
	];

	public $elements_data = [ 
		'sections' => [],
		'columns'  => [],
		'widgets'  => [],
	];

	/**
	 * @deprecated
	 *
	 * @return string
	 */
	public function get_version() {
		return BDTPS_PRO_VER;
	}

	/**
	 * Throw error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'bdthemes-prime-slider' ), '1.6.0' );
	}

	/**
	 * Disable unserializing of the class
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'bdthemes-prime-slider' ), '1.6.0' );
	}

	/**
	 * @return Plugin
	 */

	public static function elementor() {
		return Plugin::$instance;
	}

	/**
	 * @return Prime_Slider_Loader
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}



	/**
	 * we loaded module manager + admin php from here
	 * @return [type] [description]
	 */
	private function _includes() {

		require BDTPS_PRO_PATH . 'includes/modules-manager.php';

		require_once BDTPS_PRO_PATH . 'base/prime-slider-base.php';

		if ( ps_is_dashboard_enabled() ) {
			if ( is_admin() ) {
				require_once BDTPS_PRO_ADMIN_PATH . 'admin.php';
			}
		}
	}

	public function autoload( $class ) {
		if ( 0 !== strpos( $class, __NAMESPACE__ ) ) {
			return;
		}

		$class_to_load = $class;

		if ( ! class_exists( $class_to_load ) ) {
			$filename = strtolower(
				preg_replace(
					[ '/^' . __NAMESPACE__ . '\\\/', '/([a-z])([A-Z0-9])/', '/_/', '/\\\/' ],
					[ '', '$1-$2', '-', DIRECTORY_SEPARATOR ],
					$class_to_load
				)
			);

			$filename = BDTPS_PRO_PATH . $filename . '.php';

			if ( is_readable( $filename ) ) {
				include( $filename );
			}
		}
	}

	/**
	 * Register all script that need for any specific widget on call basis.
	 * @return [type] [description]
	 */
	public function register_site_scripts() {
		$reveal_effects = prime_slider_option( 'reveal-effects', 'prime_slider_other_settings', 'off' );

		/**
		 * Please use only the min file of anime js.
		 * Suffix will give error
		 * BDTU-011
		 */
		if ( prime_slider_is_widget_enabled( 'astoria' ) or prime_slider_is_widget_enabled( 'paranoia' ) or prime_slider_is_widget_enabled( 'pieces' ) ) {
			wp_register_script( 'anime', BDTPS_PRO_ASSETS_URL . 'vendor/js/anime.min.js', [ 'jquery', 'elementor-frontend' ], BDTPS_PRO_VER, true );
		}
		if ( prime_slider_is_widget_enabled( 'astoria' ) or prime_slider_is_widget_enabled( 'blog' ) or prime_slider_is_widget_enabled( 'crossroad' ) or prime_slider_is_widget_enabled( 'general' ) or prime_slider_is_widget_enabled( 'isolate' ) or prime_slider_is_widget_enabled( 'paranoia' ) or prime_slider_is_widget_enabled( 'prism' ) or prime_slider_is_widget_enabled( 'reveal' ) or prime_slider_is_widget_enabled( 'fluent' ) or prime_slider_is_widget_enabled( 'dragon' ) or prime_slider_is_widget_enabled( 'flogia' ) or prime_slider_is_widget_enabled( 'mount' ) or prime_slider_is_widget_enabled( 'sequester' ) or prime_slider_is_widget_enabled( 'woocommerce' ) or prime_slider_is_widget_enabled( 'woolamp' ) ) {
			wp_register_script( 'gsap', BDTPS_PRO_ASSETS_URL . 'vendor/js/gsap.min.js', [], '3.3.0', true );
		}
		if ( prime_slider_is_widget_enabled( 'blog' ) or prime_slider_is_widget_enabled( 'general' ) or prime_slider_is_widget_enabled( 'isolate' ) or prime_slider_is_widget_enabled( 'fluent' ) or prime_slider_is_widget_enabled( 'dragon' ) or prime_slider_is_widget_enabled( 'flogia' ) or prime_slider_is_widget_enabled( 'mount' ) or prime_slider_is_widget_enabled( 'sequester' ) or prime_slider_is_widget_enabled( 'woocommerce' ) or prime_slider_is_widget_enabled( 'woolamp' ) ) {
			wp_register_script( 'split-text', BDTPS_PRO_ASSETS_URL . 'vendor/js/SplitText.min.js', [ 'gsap' ], '3.3.0', true );
		}
		if ( prime_slider_is_widget_enabled( 'crossroad' ) ) {
			wp_register_script( 'charming', BDTPS_PRO_ASSETS_URL . 'vendor/js/charming.min.js', [ 'jquery', 'elementor-frontend' ], BDTPS_PRO_VER, true );
		}
		if ( prime_slider_is_widget_enabled( 'avatar' ) ) {
			wp_register_script( 'splitting', BDTPS_PRO_ASSETS_URL . 'vendor/js/splitting.min.js', [ 'jquery', 'elementor-frontend' ], BDTPS_PRO_VER, true );
		}
		if ( prime_slider_is_widget_enabled( 'fluent' ) ) {
			wp_register_script( 'mThumbnailScroller', BDTPS_PRO_ASSETS_URL . 'vendor/js/jquery.mThumbnailScroller.min.js', [ 'jquery', 'elementor-frontend' ], BDTPS_PRO_VER, true );
		}
		if ( prime_slider_is_widget_enabled( 'woohotspot' ) ) {
			wp_register_script( 'popper', BDTPS_PRO_ASSETS_URL . 'vendor/js/popper.min.js', [ 'jquery' ], null, true );
			wp_register_script( 'tippyjs', BDTPS_PRO_ASSETS_URL . 'vendor/js/tippy.all.min.js', [ 'jquery' ], null, true );
		}
		if ( prime_slider_is_widget_enabled( 'material' ) ) {
			wp_register_script( 'material', BDTPS_PRO_ASSETS_URL . 'vendor/js/effect-material.min.js', [ 'jquery', 'elementor-frontend' ], BDTPS_PRO_VER, true );
		}

		if ( 'on' === $reveal_effects ) {
			wp_register_script( 'anime', BDTPS_PRO_ASSETS_URL . 'vendor/js/anime.min.js', [ 'jquery', 'elementor-frontend' ], BDTPS_PRO_VER, true );
			wp_register_script( 'revealFx', BDTPS_PRO_ASSETS_URL . 'vendor/js/RevealFx.min.js', [ 'jquery', 'elementor-frontend' ], BDTPS_PRO_VER, true );
		}
	}

	public function register_site_styles() {
		$direction_suffix = is_rtl() ? '.rtl' : '';

		if ( prime_slider_is_widget_enabled( 'woohotspot' ) ) {
			wp_register_style( 'tippy', BDTPS_PRO_ASSETS_URL . 'css/tippy' . $direction_suffix . '.css', [], BDTPS_PRO_VER );
		}
	}

	/**
	 * initialize the category
	 * @return [type] [description]
	 */
	public function prime_slider_init() {
		$this->_modules_manager = new Manager();

		$elementor = Plugin::$instance;

		// Add element category in panel
		$elementor->elements_manager->add_category(
			'prime-slider-pro',
			[ 
				'title' => 'Prime Slider Pro',
				'icon'  => 'font'
			]
		);

		do_action( 'bdthemes_prime_slider_pro/init' );
	}

	/**
	 * initialize the category
	 * @return [type] [description]
	 */
	public function prime_slider_pro_category_register() {

		$elementor = Plugin::$instance;
		$elementor->elements_manager->add_category(
			'prime-slider-pro',
			[ 
				'title' => esc_html__( 'Prime Slider Pro', 'prime-slider-pro' ),
				'icon'  => 'font'
			]
		);
	}

	private function setup_hooks() {
		// add_action( 'elementor/elements/categories_registered', [ $this, 'prime_slider_pro_category_register' ] );
		add_action( 'elementor/init', [ $this, 'prime_slider_init' ] );

		add_action( 'elementor/frontend/before_register_styles', [ $this, 'register_site_styles' ] );
		add_action( 'elementor/frontend/before_register_scripts', [ $this, 'register_site_scripts' ] );

	}

	/**
	 * Prime_Slider_Loader constructor.
	 * @throws \Exception
	 */
	private function __construct() {
		// Register class automatically
		spl_autoload_register( [ $this, 'autoload' ] );
		// Include some backend files
		$this->_includes();
		// Finally hooked up all things here
		$this->setup_hooks();
	}
}

if ( ! defined( 'BDTPS_PRO_TESTS' ) ) {
	// In tests we run the instance manually.
	Prime_Slider_Loader::instance();
}

// handy function for push data
function prime_slider_config() {
	return Prime_Slider_Loader::instance();
}
