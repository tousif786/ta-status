<?php

// if uninstall.php is not called by WordPress, die
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

// Include main plugin file that has unintall method
require_once 'ta-status.php';

TA_Status::get_instance()->uninstall();
