<?php
/**
 * Plugin Name: Prixz Modules
 * Description: This plugin adds custom modules to Woocommerce.
 * Author: Victor Crespo
 * Version: 1.0.0
 * License: GPL2
 *
 * @package PrixzModules
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

// Define the plugin path.
if ( ! defined( 'PRIXZ_MODULES_PATH' ) ) {
	define( 'PRIXZ_MODULES_PATH', plugin_dir_path( __FILE__ ) );
}

// Define the plugin URL.
if ( ! defined( 'PRIXZ_MODULES_URL' ) ) {
	define( 'PRIXZ_MODULES_URL', plugin_dir_url( __FILE__ ) );
}

// Define the plugin version.
if ( ! defined( 'PRIXZ_MODULES_VERSION' ) ) {
	define( 'PRIXZ_MODULES_VERSION', '1.0.0' );
}

require_once PRIXZ_MODULES_PATH . 'includes/class-main.php';

$prixz_modules = PrixzModules\Main::get_instance();
