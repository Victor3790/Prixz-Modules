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
	 * The slider module.
	 *
	 * @var Slider
	 */
	private $slider_module;

	/**
	 * The constructor for the class.
	 */
	private function __construct() {
		$this->define_constants();
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
		add_action( 'admin_menu', array( $this, 'add_admin_pages' ) );
		/**
		 * These are the slider module hooks.
		 */
		$this->slider_module = new Slider();
		/**
		 * So far the plugin is only adding the slider to the home page of the Storefront theme
		 * if the homepage displays the latest posts, but this can be modified to add a slider
		 * at another location or through a shortcode with further changes.
		 */
		add_action( 'storefront_loop_before', array( $this, 'add_slider_to_home' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
	}

	/**
	 * Add the admin pages.
	 */
	public function add_admin_pages() {
		add_menu_page(
			'Prixz Modules',
			'Prixz Modules',
			'manage_options',
			'prixz-modules',
			array( $this, 'admin_page' ),
			'dashicons-admin-generic',
			100
		);

		add_submenu_page(
			'prixz-modules',
			'Prixz Modules Slider',
			'Slider',
			'manage_options',
			'prixz-modules-slider',
			array( $this, 'admin_page' )
		);
	}

	/**
	 * The admin page.
	 */
	public function admin_page() {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Prixz Modules', 'prixz-modules' ); ?></h1>
			<p><?php esc_html_e( 'This is the admin page for the Prixz Modules plugin.', 'prixz-modules' ); ?></p>
		</div>
		<?php
	}

	/**
	 * Add the slider to the home page.
	 */
	public function add_slider_to_home() {
		if ( ! is_front_page() ) {
			return;
		}
		$this->slider_module->add_slider();
	}

	/**
	 * Add styles and scripts
	 */
	public function enqueue_assets() {
		// Slider.
		wp_enqueue_style(
			'swiper',
			namespace\URL . 'assets/swiper/swiper-bundle.min.css',
			array(),
			'11.2.6'
		);

		wp_enqueue_script(
			'swiper',
			namespace\URL . 'assets/swiper/swiper-bundle.min.js',
			array(),
			'11.2.6',
			true
		);

		wp_enqueue_script(
			'slider',
			namespace\URL . 'assets/slider.js',
			array(
				'jquery',
				'swiper',
			),
			namespace\VERSION,
			true
		);

		wp_enqueue_style(
			'slider',
			namespace\URL . 'assets/slider.css',
			array(),
			namespace\VERSION
		);
	}
}
