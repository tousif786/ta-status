<?php
/**
 * TA Status admin settings
 *
 * @since      1.0.0
 * @package    TA_Status
 * @subpackage TA_Status/App/Controllers
 */

namespace TA_Status\App\Controllers;

use TA_Status\App\Models\Status_Option;

// Prevents direct access to the file for security reasons.
if ( ! defined( 'WPINC' ) ) {
	die();
}

class Status_Settings_Controller {

	public function __construct() {
		// Only network admin and subsite admin are allowed to view TA Status page
		if ( current_user_can( 'administrator' ) ) {
			add_action( 'admin_menu', array( $this, 'ta_status_settings_menu' ) );
		}
	}

	/**
	 * Hook callback: TA Status settings menu.
	 *
	 * @return void
	 */
	public function ta_status_settings_menu() {
		// Submit settings form handler
		$this->submit_handler();

		add_submenu_page(
			'tools.php',
			__( 'TA Status', 'ta-status' ),
			__( 'TA Status', 'ta-status' ),
			'manage_options',
			'ta-status',
			array( $this, 'show' )
		);
	}

	/**
	 * add_submenu_page callback: TA Status page settings form under tool.
	 *
	 * @return void
	 */
	public function show() {
		// Get status
		$status = Status_Option::get_option();

		require_once TA_STATUS_PLUGIN_DIR . 'app/views/admin-settings-page.php';
	}

	/**
	 * Setting form submit handler
	 *
	 * @return void
	 */
	private function submit_handler() {
		if ( ! empty( $_POST['_wpnonce_ta_status_admin_settings'] ) ) {
			// Verify nonce with admin referer
			check_admin_referer( 'ta_status_admin_settings', '_wpnonce_ta_status_admin_settings' );

			if ( $this->validate( $_POST ) ) {
				// Process the request
				if ( is_multisite() && ! empty( $_POST['overwrite_status'] ) ) {
					$overwrite_status = 'overwrite_status';
				} else {
					$overwrite_status = '';
				}

				// Set option
				Status_Option::set_option( $_POST['status'], $overwrite_status );

				add_action( 'admin_notices', array( $this, 'status_notice' ) );
			}
		}
	}

	/**
	 * Form Validation
	 *
	 * @return bool
	 */
	private function validate( $post_data ) {
		$is_valid = true;

		if ( empty( $post_data['status'] ) ) {
			add_action( 'admin_notices', array( $this, 'status_validation_error_notice' ) );

			$is_valid = false;
		}

		return $is_valid;
	}

	/**
	 * Hook callback: Show status validation error notice
	 *
	 * @return void
	 */
	public function status_validation_error_notice() {
		?>
			<div class="notice notice-error is-dismissible">
				<p><?php esc_html_e( 'Status message field is required.', 'ta-status' ); ?></p>
			</div>
		<?php
	}

	/**
	 * Hook callback: Show status updated notice
	 *
	 * @return void
	 */
	public function status_notice() {
		?>
			<div class="notice notice-success is-dismissible">
				<p><?php esc_html_e( 'Status updated successfully.', 'ta-status' ); ?></p>
			</div>
		<?php
	}
}
