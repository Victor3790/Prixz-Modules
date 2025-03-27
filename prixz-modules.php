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

// Define the plugin file path.
if ( ! defined( 'PRIXZ_MODULES_PLUGIN_FILE' ) ) {
	define( 'PRIXZ_MODULES_PLUGIN_FILE', __FILE__ );
}

require_once 'includes/class-main.php';
require_once 'public/class-plugin-public.php';
require_once 'includes/class-slider.php';

$prixz_modules = PrixzModules\Main::get_instance();
