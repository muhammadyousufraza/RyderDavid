<?php

namespace PrimeSliderPro;

use PrimeSliderPro\Base\Prime_Slider_Base;

use PrimeSlider\Notices;


/**
 * License Settings Class
 */
class License_Settings {

	const PAGE_ID = 'prime_slider_options';

	public $responseObj;
	public $licenseMessage;
	public $showMessage = false;
	private $is_activated = false;


	function __construct() {
		if (!defined('BDTPS_HIDE')) {
			add_action('admin_menu', [$this, 'admin_menu'], 201);
			add_action('ps_license_page', [$this, 'license_page'], 99);
		}

		$license_key   = self::get_license_key();
		$license_email = self::get_license_email();


		Prime_Slider_Base::add_on_delete(
			function () {
				update_option('prime_slider_license_email', '');
				update_option('prime_slider_license_key', '');
				update_option(Prime_Slider_Base::get_lic_key_param('prime_slider_license_key'), '');
			}
		);

		if (Prime_Slider_Base::check_wp_plugin($license_key, $license_email, $error, $responseObj, BDTPS_PRO__FILE__)) {

			if (!defined('BDTPS_LO')) {
				add_action('admin_post_prime_slider_deactivate_license', [$this, 'action_deactivate_license']);

				$this->is_activated = true;
			}
		} else {

			if (!defined('BDTPS_LO')) {
				if (!empty($licenseKey) && !empty($this->licenseMessage)) {
					$this->showMessage = true;
				}

				if ($error) {
					$this->licenseMessage = $error;
					$this->license_activate_error_notice();
					// add_action( 'admin_notices', [ $this, 'license_activate_error_notice' ], 10, 3 );
				}

				$this->license_activate_notice();

				// add_action( 'admin_notices', [ $this, 'license_activate_notice' ] );

				update_option(Prime_Slider_Base::get_lic_key_param('prime_slider_license_key'), "");
				add_action('admin_post_prime_slider_activate_license', [$this, 'action_activate_license']);
			}
		}
	}

	public static function get_url() {
		return admin_url('admin.php?page=' . self::PAGE_ID);
	}

	function admin_menu() {

		add_submenu_page(
			'prime_slider_options',
			BDTPS_PRO_TITLE,
			esc_html__('License', 'prime-slider-pro'),
			'manage_options',
			'prime_slider_options' . '#prime_slider_license_settings',
			[$this, 'display_page']
		);
	}

	/**
	 * Get all the pages
	 *
	 * @return array page names with key value pairs
	 */
	function get_pages() {
		$pages         = get_pages();
		$pages_options = [];
		if ($pages) {
			foreach ($pages as $page) {
				$pages_options[$page->ID] = $page->post_title;
			}
		}

		return $pages_options;
	}

	/**
	 * Get License Key
	 *
	 * @access public
	 * @return string
	 */

	public static function get_license_key() {
		$license_key = get_option(Prime_Slider_Base::get_lic_key_param('prime_slider_license_key'));
		if (empty($license_key)) {
			$license_key = get_option('prime_slider_license_key');
			if (!empty($license_key)) {
				self::set_license_key($license_key);
				update_option('prime_slider_license_key', '');
			}
		}
		return trim($license_key);
	}

	/**
	 * Get License Email
	 *
	 * @access public
	 * @return string
	 */

	public static function get_license_email() {
		return trim(get_option('prime_slider_license_email', get_bloginfo('admin_email')));
	}

	/**
	 * Set License Key
	 *
	 * @access public
	 * @return string
	 */

	public static function set_license_key($license_key) {
		return update_option('prime_slider_license_key', $license_key);
	}

	/**
	 * Set License Email
	 *
	 * @access public
	 * @return string
	 */

	public static function set_license_email($license_email) {
		return update_option('prime_slider_license_email', $license_email);
	}


	/**
	 * Display License Page
	 *
	 * @access public
	 */

	public function license_page() {

		if ($this->is_activated) {

			$this->license_activated();
		} else {
			if (!empty($licenseKey) && !empty($this->licenseMessage)) {
				$this->showMessage = true;
			}

			$this->license_form();
		}
	}

	/**
	 * License Deactivate Action
	 * @access public
	 */

	function action_deactivate_license() {


		check_admin_referer('ps-license');
		if (Prime_Slider_Base::remove_license_key(BDTPS_PRO__FILE__, $message)) {
			update_option("prime_slider_license_key", "") || add_option("prime_slider_license_key");
		}
		wp_safe_redirect(admin_url('admin.php?page=' . 'prime_slider_options#prime_slider_license_settings'));
	}

	/**
	 * License Active Error
	 *
	 * @access public
	 */

	public function license_activate_error_notice() {
		Notices::add_notice(
			[
				'id'               => 'license-error',
				'type'             => 'error',
				'dismissible'      => true,
				'dismissible-time' => 43200,
				'message'          => $this->licenseMessage,
			]
		);
	}

	/**
	 * License Active Notice
	 *
	 * @access public
	 */

	public function license_activate_notice() {
		Notices::add_notice(
			[
				'id'               => 'license-issue',
				'type'             => 'error',
				'dismissible'      => true,
				'dismissible-time' => HOUR_IN_SECONDS * 72,
				// 'message'          => '<img height="40" src="' . BDTPS_CORE_ASSETS_URL . 'images/logo.png" class="bdt-display-block bdt-margin-small-bottom">' . __('Thank you for purchase Prime Slider. Please <a href="' . self::get_url() . '#prime_slider_license_settings">activate your license</a> to get feature updates, premium support. Don\'t have Prime Slider license? Purchase and download your license copy <a href="https://primeslider.pro/" target="_blank">from here</a>.', 'prime-slider-pro'),
				'html_message'          => $this->license_active_notice_message(),
			]
		);
	}

	public function license_active_notice_message(){
		
		$plugin_icon = BDTPS_CORE_ASSETS_URL . 'images/logo.png';
		$plugin_title = __('Prime Slider Pro', 'prime-slider-pro');
		$plugin_msg = __('Thank you for purchase Prime Slider. Please activate your license to get feature updates, premium support. Don\'t have Prime Slider license? Purchase and download your license copy from here.', 'prime-slider-pro');
		// $admin_url = self::get_url() . '#prime_slider_license_settings';
		ob_start();
		?>
		<div class="bdt-license-notice-global prime_slider">
			<?php if (!empty($plugin_icon)) : ?>
				<div class="bdt-license-notice-logo">
					<img src="<?php echo esc_url($plugin_icon); ?>" alt="icon">
				</div>
			<?php endif; ?>
			<div class="bdt-license-notice-content">
				<h3>
					<?php printf(wp_kses_post($plugin_title)); ?>
				</h3>
				<p>
					<?php printf(wp_kses_post($plugin_msg)); ?>
				</p>
				<div class="bdt-license-notice-button-wrap">
					<a href="<?php echo esc_url(self::get_url()); ?>#prime_slider_license_settings" class="bdt-button bdt-button-allow">
					Activate License
					</a>
					<a href="https://primeslider.pro/" target="_blank" class="bdt-button bdt-button-skip">
						Get License
					</a>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Display License Activated
	 *
	 * @access public
	 * @return void
	 */

	function license_activated() {
?>
		<form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
			<input type="hidden" name="action" value="prime_slider_deactivate_license" />
			<div class="ps-license-container bdt-card bdt-card-body">


				<h3 class="ps-license-title"><span class="dashicons dashicons-admin-network"></span>
					<?php esc_html_e("Prime Slider License Information", 'prime-slider-pro'); ?>
				</h3>

				<ul class="prime-slider-license-info bdt-list bdt-list-divider">
					<li>
						<div>
							<span class="license-info-title">
								<?php esc_html_e('Status', 'prime-slider-pro'); ?>
							</span>

							<?php if (Prime_Slider_Base::get_register_info()->is_valid) : ?>
								<span class="license-valid">Valid License</span>
							<?php else : ?>
								<span class="license-valid">Invalid License</span>
							<?php endif; ?>
						</div>
					</li>

					<li>
						<div>
							<span class="license-info-title">
								<?php esc_html_e('License Type', 'prime-slider-pro'); ?>
							</span>
							<?php echo esc_html(Prime_Slider_Base::get_register_info()->license_title); ?>
						</div>
					</li>

					<li>
						<div>
							<span class="license-info-title">
								<?php esc_html_e('License Expired on', 'prime-slider-pro'); ?>
							</span>
							<?php echo esc_html(Prime_Slider_Base::get_register_info()->expire_date); ?>
						</div>
					</li>

					<li>
						<div>
							<span class="license-info-title">
								<?php esc_html_e('Support Expired on', 'prime-slider-pro'); ?>
							</span>
							<?php echo esc_html(Prime_Slider_Base::get_register_info()->support_end); ?>
						</div>
					</li>

					<li>
						<div>
							<span class="license-info-title">
								<?php esc_html_e('License Email', 'prime-slider-pro'); ?>
							</span>
							<?php echo esc_html(self::get_license_email()); ?>
						</div>
					</li>

					<li>
						<div>
							<span class="license-info-title">
								<?php esc_html_e('Your License Key', 'prime-slider-pro'); ?>
							</span>
							<span class="license-key">
								<?php echo esc_attr(substr(Prime_Slider_Base::get_register_info()->license_key, 0, 9) . "XXXXXXXX-XXXXXXXX" . substr(Prime_Slider_Base::get_register_info()->license_key, -9)); ?>
							</span>
						</div>
					</li>
				</ul>

				<div class="ps-license-active-btn">
					<?php wp_nonce_field('ps-license'); ?>
					<?php submit_button('Deactivate License'); ?>
				</div>
			</div>
		</form>
	<?php
	}



	/**
	 * Display License Form
	 *
	 * @access public
	 * @return void
	 */

	function license_form() {
	?>
		<form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
			<input type="hidden" name="action" value="prime_slider_activate_license" />
			<div class="ps-license-container bdt-card bdt-card-body">

				<?php
				if (!empty($this->showMessage) && !empty($this->licenseMessage)) {
				?>
					<div class="notice notice-error is-dismissible">
						<p>
							<?php echo esc_html($this->licenseMessage); ?>
						</p>
					</div>
				<?php
				}
				?>

				<h3 class="bdt-text-large">
					<strong>
						<?php esc_html_e('Enter your license key here, to activate Prime Slider Pro, and get full feature updates and premium support.', 'prime-slider-pro'); ?>
					</strong>
				</h3>

				<ol class="bdt-text-default">
					<li>
						<?php printf(sprintf('Log in to your <a href="%1s" target="_blank">bdthemes fastspring</a> account to get your license key.', 'https://bdthemes.onfastspring.com/account')); ?>
					</li>
					<li>
						<?php printf(sprintf('If you don\'t yet have a license key, <a href="%s" target="_blank">get Prime Slider Pro now</a>.', 'https://primeslider.pro/')); ?>
					</li>
					<li>
						<?php esc_html_e('Copy the license key from your account and paste it below for work Prime Slider properly.', 'prime-slider-pro'); ?>
					</li>
				</ol>

				<div class="bdt-ps-license-field bdt-margin-top">
					<label for="prime_slider_license_email">License Email
						<input type="text" class="regular-text code" name="prime_slider_license_email" size="50" placeholder="example@email.com" required="required">
					</label>
				</div>

				<div class="bdt-ps-license-field bdt-margin-top">
					<label for="prime_slider_license_key">License Code
						<input type="text" class="regular-text code" name="prime_slider_license_key" size="50" placeholder="xxxxxxxx-xxxxxxxx-xxxxxxxx-xxxxxxxx" required="required">
					</label>
				</div>


				<div class="ps-license-active-btn">
					<?php wp_nonce_field('ps-license'); ?>
					<?php submit_button('Activate License'); ?>
				</div>
			</div>
		</form>
<?php
	}

	/**
	 * License Activate Action
	 * @access public
	 */

	function action_activate_license() {
		check_admin_referer('ps-license');

		$licenseKey   = !empty($_POST['prime_slider_license_key']) ? sanitize_text_field($_POST['prime_slider_license_key']) : "";
		$licenseEmail = !empty($_POST['prime_slider_license_email']) ? wp_unslash($_POST['prime_slider_license_email']) : "";

		update_option(Prime_Slider_Base::get_lic_key_param('prime_slider_license_key'), $licenseKey);
		update_option("prime_slider_license_email", $licenseEmail);

		wp_safe_redirect(admin_url('admin.php?page=' . 'prime_slider_options#prime_slider_license_settings'));
	}
}


new License_Settings();
