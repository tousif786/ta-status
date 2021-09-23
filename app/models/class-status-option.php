<?php
/**
 * TA Status options model
 *
 * @since      1.0.0
 * @package    TA_Status
 * @subpackage TA_Status/App/Models
 */

namespace TA_Status\App\Models;

// Prevents direct access to the file for security reasons.
if ( ! defined( 'WPINC' ) ) {
	die();
}

class Status_Option {

	/**
	 * Get status from WordPress options.
	 *
	 * @return string Plugin status text.
	 */
	public static function get_option() {
		return get_option( TA_STATUS_PREFIX . '_option' );
	}

	/**
	 * Set status in WordPress options.
	 *
	 * @return void.
	 */
	public static function set_option( $status, $overwrite ) {
		if ( ! current_user_can( 'administrator' ) ) {
			wp_die( esc_html__( 'Access Denied.' ) );
		}

		if ( is_multisite() && 'overwrite_status' === $overwrite ) {
			$sites = get_sites( array( 'number' => 0 ) );

			if ( ! empty( $sites ) ) {
				// Overwrite status on all sites
				foreach ( $sites as $site ) {
					switch_to_blog( $site->blog_id );

					update_option( TA_STATUS_PREFIX . '_option', sanitize_text_field( $status ) );

					restore_current_blog();
				}
			}
		} else {
			update_option( TA_STATUS_PREFIX . '_option', sanitize_text_field( $status ) );
		}
	}
}
