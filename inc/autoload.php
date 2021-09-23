<?php

spl_autoload_register( 'autoload' );

function autoload( $class ) {
	$prefix  = 'TA_Status\\';
	$str_len = strlen( $prefix );

	if ( 0 !== strncmp( $prefix, $class, $str_len ) ) {
		return;
	}

	$class_name = substr( $class, $str_len );
	$path       = explode( '\\', strtolower( str_replace( '_', '-', $class_name ) ) );
	$file_name  = 'class-' . array_pop( $path ) . '.php';
	$file_path  = __DIR__ . '/../' . implode( DIRECTORY_SEPARATOR, $path ) . DIRECTORY_SEPARATOR . $file_name;

	// Require file if it exists.
	if ( file_exists( $file_path ) ) {
		require_once $file_path;
	}
}