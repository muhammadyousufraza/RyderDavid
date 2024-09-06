<?php
/**
 * Notice Class.
 *
 * @package RT_TSS
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

if ( ! class_exists( 'TSSNotice' ) ):
	/**
	 * Notice Class.
	 */
	class TSSNotice {
		/**
		 * Class constructor
		 */
		public function __construct() {
			$current      = time();
			$black_friday = mktime( 0, 0, 0, 11, 20, 2023 ) <= $current && $current <= mktime( 0, 0, 0, 1, 5, 2024 );

			if (  $black_friday ) {
				add_action( 'admin_init', [ $this, 'black_friday_notice' ] );
			} else {
				register_activation_hook( TSS_PLUGIN_ACTIVE_FILE_NAME, [ $this, 'rttss_activation_time' ] );
				add_action( 'admin_init', [ $this, 'rttss_check_installation_time' ] );
				add_action( 'admin_init', [ __CLASS__, 'rttss_spare_me' ], 5 );
			}
		}

		/**
		 * Black Friday notice
		 *
		 * @return void
		 */
		public static function black_friday_notice() {

			if ( '1' !== get_option( 'rttss_bf_2021' ) && ! function_exists('rttsp')) {
				if ( ! isset( $GLOBALS['rt_tss_2021_notice'] ) ) {
					$GLOBALS['rt_tss_2021_notice'] = 'rttss_bf_2021';
					self::notice();
				}
			}
		}

		/**
		 * Notice
		 *
		 * @return void
		 */
		public static function notice() {
			add_action(
				'admin_enqueue_scripts',
				function () {
					wp_enqueue_script( 'jquery' );
				}
			);

			add_action(
				'admin_notices',
				function () {
					$plugin_name   = 'Testimonial Slider and Showcase';
					$download_link = 'https://www.radiustheme.com/downloads/wp-testimonial-slider-showcase-pro-wordpress/';
					?>

					<div class="notice notice-info is-dismissible" data-rttss-dismissable="rttss_bf_2021"
						style="display:grid;grid-template-columns: 100px auto;padding-top: 25px; padding-bottom: 22px;">
						<img alt="<?php echo esc_attr( $plugin_name ); ?>"
							src="<?php echo esc_url( TSSPro()->assetsUrl ) . 'images/icon-128x128.gif'; ?>" width="74px"
							height="74px" style="grid-row: 1 / 4; align-self: center;justify-self: center"/>
						<h3 style="margin:0;"><?php echo sprintf( '%s Black Friday Sale 2023!!', esc_html( $plugin_name ) ); ?></h3>
						<p style="margin:0 0 2px;"><?php
							printf(
							    /* translators: %s is the plugin name */
								esc_html__(
									'🚀 Exciting News: %1$s Black Friday sale is now live!',
									'testimonial-slider-showcase'
								),
								esc_html( $plugin_name )
							);


                        ?>
                            Get the plugin today and enjoy discounts up to <b> 50%.</b>
						</p>
						<p style="margin:0;">
							<a class="button button-primary" href="<?php echo esc_url( $download_link ); ?>" target="_blank">Buy Now</a>
							<a class="button button-dismiss" href="#">Dismiss</a>
						</p>
					</div>

					<?php
				}
			);

			add_action(
				'admin_footer',
				function () {
					?>
					<script type="text/javascript">
						(function ($) {
							$(function () {
								setTimeout(function () {
									$('div[data-rttss-dismissable] .notice-dismiss, div[data-rttss-dismissable] .button-dismiss')
										.on('click', function (e) {
											e.preventDefault();
											$.post(ajaxurl, {
												'action': 'rttss_dismiss_admin_notice',
												'nonce': <?php echo wp_json_encode( wp_create_nonce( 'rttss-dismissible-notice' ) ); ?>
											});
											$(e.target).closest('.is-dismissible').remove();
										});
								}, 1000);
							});
						})(jQuery);
					</script>
					<?php
				}
			);

			add_action(
				'wp_ajax_rttss_dismiss_admin_notice',
				function () {
					check_ajax_referer( 'rttss-dismissible-notice', 'nonce' );

					update_option( 'rttss_bf_2021', '1' );
					wp_die();
				}
			);
		}

		/**
		 * Plugin activation time
		 *
		 * @return void
		 */
		public static function rttss_activation_time() {
			$get_activation_time = strtotime( "now" );
			add_option( 'rttss_plugin_activation_time', $get_activation_time );
		}

		/**
		 * Plugin installation time
		 *
		 * @return void
		 */
		public static function rttss_check_installation_time() {
			$nobug = get_option( 'rttss_spare_me', "0");

			if ($nobug == "1" || $nobug == "3") {
				return;
			}

			$install_date = get_option( 'rttss_plugin_activation_time' );
			$past_date    = strtotime( '-10 days' );

			$remind_time = get_option( 'rttss_remind_me' );
			$remind_due  = strtotime( '+15 days', $remind_time );
			$now         = strtotime( "now" );

			if ( $now >= $remind_due ) {
				add_action( 'admin_notices', [ __CLASS__, 'rttss_display_admin_notice' ] );
			} else if ( ( $past_date >= $install_date ) &&  $nobug !== "2" ) {
				add_action( 'admin_notices', [ __CLASS__, 'rttss_display_admin_notice' ] );
			}
		}

		/**
		 * Display Admin Notice
		 *
		 * @return void
		 */
		public static function rttss_display_admin_notice() {
			global $pagenow;

			$exclude = [ 'themes.php', 'users.php', 'tools.php', 'options-general.php', 'options-writing.php', 'options-reading.php', 'options-discussion.php', 'options-media.php', 'options-permalink.php', 'options-privacy.php', 'edit-comments.php', 'upload.php', 'media-new.php', 'admin.php', 'import.php', 'export.php', 'site-health.php', 'export-personal-data.php', 'erase-personal-data.php' ];

			if ( ! in_array( $pagenow, $exclude ) ) {
				$args         = [ '_wpnonce' => wp_create_nonce( 'rttss_notice_nonce' ) ];
				$dont_disturb = add_query_arg( $args + [ 'rttss_spare_me' => '1' ], self::rttss_current_admin_url() );
				$remind_me    = add_query_arg( $args + [ 'rttss_remind_me' => '1' ], self::rttss_current_admin_url() );
				$rated        = add_query_arg( $args + [ 'rttss_rated' => '1' ], self::rttss_current_admin_url() );
				$reviewurl    = 'https://wordpress.org/support/plugin/testimonial-slider-and-showcase/reviews/?filter=5#new-post';
                ?>
				<div class="notice rttss-review-notice rttss-review-notice--extended">
                    <div class="rttss-review-notice_content">
                        <h3><?php esc_html_e('Enjoying Testimonial Slider and Showcase?','testimonial-slider-showcase'); ?></h3>
                        <p><?php esc_html_e('Thank you for choosing Testimonial Slider and Showcase. If you have found our plugin useful and makes you smile, please consider giving us a 5-star rating on WordPress.org. It will help us to grow.','testimonial-slider-showcase'); ?></p>
                        <div class="rttss-review-notice_actions">
                            <a href="<?php echo esc_url( $reviewurl );?>" class="rttss-review-button rttss-review-button--cta" target="_blank"><span>⭐ <?php esc_html_e('Yes, You Deserve It!','testimonial-slider-showcase'); ?></span></a>
                            <a href="<?php echo esc_url( $rated ); ?>" class="rttss-review-button rttss-review-button--cta rttss-review-button--outline"><span>😀 Already Rated!</span></a>
                            <a href="<?php echo esc_url( $remind_me ); ?>" class="rttss-review-button rttss-review-button--cta rttss-review-button--outline"><span>🔔 Remind Me Later</span></a>
                            <a href="<?php echo esc_url( $dont_disturb ); ?>" class="rttss-review-button rttss-review-button--cta rttss-review-button--error rttss-review-button--outline"><span>😐 No Thanks</span></a>
                        </div>
                    </div>
                </div>
                <?php
				echo '<style>
					.rttss-review-button--cta {
						--e-button-context-color: #4C6FFF;
						--e-button-context-color-dark: #4C6FFF;
						--e-button-context-tint: rgb(75 47 157/4%);
						--e-focus-color: rgb(75 47 157/40%);
					}
					.rttss-review-notice {
						position: relative;
						margin: 5px 20px 5px 2px;
						border: 1px solid #ccd0d4;
						background: #fff;
						box-shadow: 0 1px 4px rgba(0,0,0,0.15);
						font-family: Roboto, Arial, Helvetica, Verdana, sans-serif;
						border-inline-start-width: 4px;
					}
					.rttss-review-notice.notice {
						padding: 0;
					}
					.rttss-review-notice:before {
						position: absolute;
						top: -1px;
						bottom: -1px;
						left: -4px;
						display: block;
						width: 4px;
						background: -webkit-linear-gradient(bottom, #4C6FFF 0%, #6939c6 100%);
						background: linear-gradient(0deg, #4C6FFF 0%, #6939c6 100%);
						content: "";
					}
					.rttss-review-notice_content {
						padding: 20px;
					}
					.rttss-review-notice_actions > * + * {
						margin-inline-start: 8px;
						-webkit-margin-start: 8px;
						-moz-margin-start: 8px;
					}
					.rttss-review-notice p {
						margin: 0;
						padding: 0;
						line-height: 1.5;
					}
					p + .rttss-review-notice_actions {
						margin-top: 1rem;
					}
					.rttss-review-notice h3 {
						margin: 0;
						font-size: 1.0625rem;
						line-height: 1.2;
					}
					.rttss-review-notice h3 + p {
						margin-top: 8px;
					}
					.rttss-review-button {
						display: inline-block;
						padding: 0.4375rem 0.75rem;
						border: 0;
						border-radius: 3px;;
						background: var(--e-button-context-color);
						color: #fff;
						vertical-align: middle;
						text-align: center;
						text-decoration: none;
						white-space: nowrap;
					}
					.rttss-review-button:active {
						background: var(--e-button-context-color-dark);
						color: #fff;
						text-decoration: none;
					}
					.rttss-review-button:focus {
						outline: 0;
						background: var(--e-button-context-color-dark);
						box-shadow: 0 0 0 2px var(--e-focus-color);
						color: #fff;
						text-decoration: none;
					}
					.rttss-review-button:hover {
						background: var(--e-button-context-color-dark);
						color: #fff;
						text-decoration: none;
					}
					.rttss-review-button.focus {
						outline: 0;
						box-shadow: 0 0 0 2px var(--e-focus-color);
					}
					.rttss-review-button--error {
						--e-button-context-color: #d72b3f;
						--e-button-context-color-dark: #ae2131;
						--e-button-context-tint: rgba(215,43,63,0.04);
						--e-focus-color: rgba(215,43,63,0.4);
					}
					.rttss-review-button.rttss-review-button--outline {
						border: 1px solid;
						background: 0 0;
						color: var(--e-button-context-color);
					}
					.rttss-review-button.rttss-review-button--outline:focus {
						background: var(--e-button-context-tint);
						color: var(--e-button-context-color-dark);
					}
					.rttss-review-button.rttss-review-button--outline:hover {
						background: var(--e-button-context-tint);
						color: var(--e-button-context-color-dark);
					}
				</style>';
			}
		}

		/**
		 * Current admin URL
		 *
		 * @return void
		 */
		protected static function rttss_current_admin_url() {
			$uri = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
			$uri = preg_replace( '|^.*/wp-admin/|i', '', $uri );

			if ( ! $uri ) {
				return '';
			}

			return remove_query_arg( [ '_wpnonce', '_wc_notice_nonce', 'wc_db_update', 'wc_db_update_nonce', 'wc-hide-notice' ], admin_url( $uri ) );
		}

		/**
		 * Review already done
		 *
		 * @return void
		 */
		public static function rttss_spare_me() {
			if ( ! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'rttss_notice_nonce' ) ) {
				return;
			}

			if ( isset( $_GET['rttss_spare_me'] ) && ! empty( $_GET['rttss_spare_me'] ) ) {
				$spare_me = sanitize_text_field( wp_unslash( $_GET['rttss_spare_me'] ) );

				if ( 1 == $spare_me ) {
					update_option( 'rttss_spare_me', "1" );
				}
			}

			if ( isset( $_GET['rttss_remind_me'] ) && ! empty( $_GET['rttss_remind_me'] ) ) {
				$remind_me = sanitize_text_field( wp_unslash( $_GET['rttss_remind_me'] ) );

				if ( 1 == $remind_me ) {
					$get_activation_time = strtotime( "now" );
					update_option( 'rttss_remind_me', $get_activation_time );
					update_option( 'rttss_spare_me', "2" );
				}
			}

			if ( isset( $_GET['rttss_rated'] ) && ! empty( $_GET['rttss_rated'] ) ) {
				$rttss_rated = sanitize_text_field( wp_unslash( $_GET['rttss_rated'] ) );

				if ( 1 == $rttss_rated ) {
					update_option( 'rttss_rated', 'yes' );
					update_option( 'rttss_spare_me', "3" );
				}
			}
		}
	}

endif;
