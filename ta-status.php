<?php
/**
 * @since               1.0.0
 * @package             TA_Status
 *
 * Plugin Name:         TA Status
 * Plugin URI:          https://bitbucket.org/tousif786/
 * Description:         Allow site admin to add status to the dashboard.
 * Version:             1.0.0
 * Author:              Tousif Ali
 * Text Domain:         ta-status
 * Author URI:          https://indexcodes.com
 * License:             GPL2
 */

use TA_Status\App\Controllers\Dashboard_Controller;
use TA_Status\App\Controllers\Status_Settings_Controller;

// Prevents direct access to the file for security reasons.
if ( ! defined( 'WPINC' ) ) {
	die();
}

require_once 'inc/autoload.php';

if ( ! class_exists( 'TA_Status' ) ) {

	class TA_Status {

		/**
		 * Plugin instance.
		 *
		 * @var null|TA_Status
		 */
		private static $instance = null;

		public function __construct() {
			add_action( 'init', array( $this, 'init' ) );
		}

		/**
		 * Plugins instance
		 *
		 * @return TA_Status
		 */
		public static function get_instance() {
			if ( ! self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Hook calback: Plugin initiate method
		 *
		 * @return void
		 */
		public function init() {
			// Define constants
			$this->set_constants();

			// Add and initialize controllers
			$this->controllers();

			// Load tanslation
			add_action( 'admin_init', array( $this, 'plugin_translation' ) );

			// Add settings action link to plugin page
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'settings_link_in_plugin_page' ) );
		}

		/**
		 * Hook callback: Add settings action link to plugin page
		 *
		 * @return void
		 */
		public function settings_link_in_plugin_page( $actions ) {
			$actions[] = '<a href="' . menu_page_url( 'ta-status', false ) . '">' . __( 'Settings', 'ta-status' ) . '</a>';

			return $actions;
		}

		/**
		 * Set all constant in this method
		 *
		 * @return void
		 */
		private function set_constants() {
			if ( ! defined( 'TA_STATUS_PLUGIN_DIR' ) ) {
				define( 'TA_STATUS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			}

			if ( ! defined( 'TA_STATUS_PLUGIN_URL' ) ) {
				define( 'TA_STATUS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			}

			if ( ! defined( 'TA_STATUS_VERSION' ) ) {
				define( 'TA_STATUS_VERSION', '1.0.0' );
			}

			if ( ! defined( 'TA_STATUS_PREFIX' ) ) {
				define( 'TA_STATUS_PREFIX', 'ta_status' );
			}
		}

		/**
		 * Hook callback: Initialize plugin translation
		 *
		 * @return void
		 */
		public function plugin_translation() {
			load_plugin_textdomain(
				'ta-status',
				false,
				basename( TA_STATUS_PLUGIN_DIR ) . '/languages'
			);
		}

		/**
		 * Add and initialize controllers
		 *
		 * @return void
		 */
		private function controllers() {
			new Dashboard_Controller();
			new Status_Settings_Controller();
		}

		/**
		 * Uninstall plugin
		 *
		 * @return void
		 */
		public function uninstall() {
			// Include all constant
			$this->set_constants();

			if ( is_multisite() ) {
				$sites = get_sites( array( 'number' => 0 ) );

				if ( ! empty( $sites ) ) {
					foreach ( $sites as $site ) {
						switch_to_blog( $site->blog_id );

						delete_option( TA_STATUS_PREFIX . '_option' );

						restore_current_blog();
					}
				}
			} else {
				delete_option( TA_STATUS_PREFIX . '_option' );
			}
		}
	}

	TA_Status::get_instance();
}
