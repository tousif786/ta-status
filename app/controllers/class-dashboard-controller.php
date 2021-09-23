<?php
/**
 * TA Status dashboard widget
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

class Dashboard_Controller {

	public function __construct() {
		add_action( 'wp_dashboard_setup', array( $this, 'init_widget' ) );
	}

	/**
	 * Hook callback: Initiate widget to dashboard.
	 *
	 * @return void
	 */
	public function init_widget() {
		wp_add_dashboard_widget(
			'ta_status_widget',
			__( 'TA Status', 'ta-status' ),
			array( $this, 'show_widget' )
		);
	}

	/**
	 * wp_add_dashboard_widget callback: Show widget to dashboard
	 *
	 * @return void
	 */
	public function show_widget() {
		// Get status
		$status = Status_Option::get_option();

		require_once TA_STATUS_PLUGIN_DIR . 'app/views/dashboard-widget.php';
	}
}
