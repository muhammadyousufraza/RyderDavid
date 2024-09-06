<?php
/**
 * Item Sorting Class.
 *
 * @package RT_TSS
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

if ( ! class_exists( 'TSSItemSorting' ) ) {
	/**
	 * Item Sorting Class.
	 */
	class TSSItemSorting {
		/**
		 * Class constructor
		 */
		public function __construct() {
			add_action( 'admin_init', [ $this, 'refresh' ] );
			add_action( 'admin_init', [ $this, 'load_script' ] );
			add_action( 'pre_get_posts', [ $this, 'tss_pre_get_posts' ] );
			add_action( 'wp_ajax_tss-update-menu-order', [ $this, 'update_menu_order' ] );
			/*old code*/
			//add_action( 'wp_ajax_tss-cat-update-order', [ $this, 'tss_cat_update_order' ] );
		}

		/**
		 * Pre get posts
		 *
		 * @param object $wp_query WP Query.
		 * @return void|bool
		 */
		public function tss_pre_get_posts( $wp_query ) {
			if ( is_admin() ) {
				/*Old Code*/
//				// phpcs:ignore WordPress.Security.NonceVerification.Recommended
//				if ( isset( $wp_query->query['post_type'] ) && ! isset( $_GET['orderby'] ) && TSSPro()->post_type === $wp_query->query['post_type'] ) {
//						$wp_query->set( 'orderby', 'menu_order' );
//						$wp_query->set( 'order', 'ASC' );
//				}
				// phpcs:ignore WordPress.Security.NonceVerification.Recommended
				if ( isset( $wp_query->query['post_type'] ) && ! isset( $_GET['orderby'] ) && $wp_query->query['post_type'] == 'testimonial' && $wp_query->is_main_query() ) {
					$wp_query->set( 'orderby', 'menu_order' );
					$wp_query->set( 'order', 'ASC' );
				}
			}
		}

		/**
		 * Scripts
		 *
		 * @return void|bool
		 */
		public function load_script() {
			$server = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : null;
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended
			if ( isset( $_GET['orderby'] ) || strstr( $server, 'action=edit' ) || strstr( $server, 'wp-admin/post-new.php' ) ) {

				return false;
			}
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended
			if ( ! isset( $_GET['post_type'] ) ) {
				return false;
			}
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended
			if ( isset( $_GET['post_type'] ) && TSSPro()->post_type !== $_GET['post_type'] ) {
				return false;
			}

			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'rt-tss-sortable' );

			add_action( 'admin_footer', [ $this, 'rt_sortable_css' ] );
		}

		/**
		 * CSS
		 *
		 * @return void
		 */
		public function rt_sortable_css() {
			echo '<style>
					.ui-sortable tr:hover {
						cursor: move;
					}
					.ui-sortable tr.alternate {
						background-color: #F9F9F9;
					}
					.ui-sortable tr.ui-sortable-helper {
						background-color: #F9F9F9;
						border-top: 1px solid #DFDFDF;
					}
				</style>';
		}

		/**
		 * Posts update order
		 *
		 * @return void|bool
		 */
		public function update_menu_order() {
			if (wp_verify_nonce(TSSPro()->getNonce(),TSSPro()->nonceText())){
				global $wpdb;
				$data = ( ! empty( $_POST['post'] ) ? array_map( 'absint', $_POST['post'] ) : [] );
				if ( ! is_array( $data ) ) {
					return false;
				}

				$id_arr = [];
				foreach ( $data as $position => $id ) {
					$id_arr[] = $id;
				}

				$menu_order_arr = [];
				foreach ( $id_arr as $key => $id ) {
					$tlp_testimonial_cache_key = 'tlp_testimonial_menu_order_cache_'.$id;
					$results = wp_cache_get($tlp_testimonial_cache_key);
					if (false === $results){
						// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
						$results = $wpdb->get_results(
							$wpdb->prepare("SELECT menu_order FROM $wpdb->posts WHERE ID = " . intval( $id ) )
						);
						wp_cache_set($tlp_testimonial_cache_key,$results);
					}
					foreach ( $results as $result ) {
						$menu_order_arr[] = $result->menu_order;
					}
				}

				sort( $menu_order_arr );

				foreach ( $data as $position => $id ) {
					// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
					$wpdb->update( $wpdb->posts, [ 'menu_order' => $menu_order_arr[ $position ] ], [ 'ID' => intval( $id ) ] );
				}

				wp_send_json_success();
			}

		}

		/**
		 * Category update order
		 *
		 * @return void|bool
		 */
		/*Old Code*/
//		public function tss_cat_update_order() {
//			$id_arr    = [];
//			$order_arr = [];
//			$data = ( ! empty( $_POST['tag'] ) ? array_filter( $_POST['tag'] ) : [] );
//
//			if ( ! is_array( $data ) ) {
//				return false;
//			}
//
//			foreach ( $data as $position => $id ) {
//				$id_arr[] = $id;
//			}
//
//			foreach ( $id_arr as $key => $id ) {
//				$order_arr[] = get_term_meta( intval( $id ), '_order', true );
//			}
//
//			sort( $order_arr );
//
//			foreach ( $data as $position => $id ) {
//				update_term_meta( intval( $id ), '_order', $order_arr[ $position ] );
//			}
//
//			die();
//		}

		/**
		 * Refresh
		 *
		 * @return void
		 */
		public function refresh() {
			global $wpdb;
			/*Old Code*/
//			$results = $wpdb->get_results(
//				$wpdb->prepare(
//					"
//				SELECT ID
//				FROM $wpdb->posts
//				WHERE post_type = '" . TSSPro()->post_type . "' AND post_status IN ('publish', 'pending', 'draft', 'private', 'future')
//				ORDER BY menu_order ASC
//				"
//				)
//			);
			$tlp_refresh_cache_key = 'tlp_testimonial_post_refresh';
			$results = wp_cache_get($tlp_refresh_cache_key);
			if (false === $results){
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
				$results = $wpdb->get_results(
					$wpdb->prepare(
						"
			        SELECT ID
			        FROM $wpdb->posts
			        WHERE post_type = %s AND post_status IN ('publish', 'pending', 'draft', 'private', 'future')
			        ORDER BY menu_order ASC
			        ",
						TSSPro()->post_type
					)
				);
				wp_cache_set($tlp_refresh_cache_key,$results);
			}

			foreach ( $results as $key => $result ) {
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
				$wpdb->update( $wpdb->posts, [ 'menu_order' => $key + 1 ], [ 'ID' => $result->ID ] );
			}
		}
	}

}
