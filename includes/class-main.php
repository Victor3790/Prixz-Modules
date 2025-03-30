<?php
/**
 * This is the main class for the plugin.
 *
 * @package PrixzModules
 */

namespace PrixzModules;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * The main class for the plugin.
 */
class Main {
	/**
	 * The instance of the class.
	 *
	 * @var Main
	 */
	private static $instance = null;

	/**
	 * The plugin public object.
	 *
	 * @var Plugin_Public
	 */
	private $public;

	/**
	 * The plugin admin object.
	 *
	 * @var Plugin_Admin
	 */
	private $admin;

	/**
	 * The constructor for the class.
	 */
	private function __construct() {
		$this->define_constants();

		$this->public = new Plugin_Public();
		$this->admin  = new Plugin_Admin();

		$this->define_hooks();
	}

	/**
	 * Get the instance of the class.
	 *
	 * @return Main
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Define the constants for the plugin.
	 */
	private function define_constants() {
		if ( ! defined( __NAMESPACE__ . '\VERSION' ) ) {
			define( __NAMESPACE__ . '\VERSION', '1.0.0' );
		}

		if ( ! defined( __NAMESPACE__ . '\URL' ) ) {
			define( __NAMESPACE__ . '\URL', plugin_dir_url( PRIXZ_MODULES_PLUGIN_FILE ) );
		}

		if ( ! defined( __NAMESPACE__ . '\PATH' ) ) {
			define( __NAMESPACE__ . '\PATH', plugin_dir_path( PRIXZ_MODULES_PLUGIN_FILE ) );
		}
	}

	/**
	 * Add hooks here.
	 */
	private function define_hooks() {
		add_action( 'admin_menu', array( $this->admin, 'add_admin_pages' ) );
		/**
		 * These are the slider module hooks.
		 */
		add_action( 'storefront_loop_before', array( $this->public, 'add_slider_to_home' ) );
		add_action( 'storefront_loop_before', array( $this->public, 'add_product_carousel_to_home' ), 20 );
		add_action( 'wp_enqueue_scripts', array( $this->public, 'enqueue_assets' ) );
		add_action( 'admin_enqueue_scripts', array( $this->admin, 'enqueue_assets' ) );
		add_action( 'admin_init', array( $this->admin, 'init_settings' ) );
	}
}
