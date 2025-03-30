<?php
/**
 * This class will handle admin functionality for the plugin.
 *
 * @package PrixzModules
 */

namespace PrixzModules;

use Vk_custom_libs\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * The admin class for the plugin.
 */
class Plugin_Admin {

	/**
	 * The constructor for the class.
	 */
	public function __construct() {
		require_once namespace\PATH . 'includes/class-settings.php';
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
			array( $this, 'slider_page' )
		);

		add_submenu_page(
			'prixz-modules',
			'Prixz Modules Products',
			'Products',
			'manage_options',
			'prixz-modules-products',
			array( $this, 'products_page' )
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
	 * The Slider submenu page.
	 */
	public function slider_page() {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Prixz Modules Slider', 'prixz-modules' ); ?></h1>
			<p><?php esc_html_e( 'Instructions: Set some slider images.', 'prixz-modules' ); ?></p>
			<p>
				<button class="set_custom_images button">Set Slider Images</button>
			</p>
			<div id="slider_images_preview"></div>
			<form action="options.php" method="post">
				<?php
					settings_fields( 'prixz-modules-slider-group' );
					do_settings_sections( 'prixz-modules-slider' );
					submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * The Products submenu page.
	 */
	public function products_page() {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Prixz Modules Products', 'prixz-modules' ); ?></h1>
			<p><?php esc_html_e( 'Instructions: Select at least four products for the carousel.', 'prixz-modules' ); ?></p>
			<div id="slider_images_preview"></div>
			<select id="prixz-product-search-bar"></select>
			<form action="options.php" method="post">
				<?php
					settings_fields( 'prixz-modules-products-group' );
					do_settings_sections( 'prixz-modules-products' );
					submit_button();
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Add the settings sections and fields to the admin view.
	 */
	public function init_settings() {
		$slider_settings_sections = array(
			'prixz-modules-slider-settings-section' => array(
				'settings' => array(
					'prixz-modules-slider-image-ids' => array( 'field_type' => 'hidden' ),
				),
			),
		);

		$slider_settings = new Settings( 'prixz-modules-slider', 'prixz-modules-slider-group' );
		$slider_settings->add_settings_sections( $slider_settings_sections );

		$products_settings_sections = array(
			'prixz-modules-products-settings-section' => array(
				'settings' => array(
					'prixz-modules-products-ids' => array(
						'field_type' => 'hidden',
					),
				),
			),
		);

		$products_settings = new Settings( 'prixz-modules-products', 'prixz-modules-products-group' );
		$products_settings->add_settings_sections( $products_settings_sections );
	}

	/**
	 * Enqueue the admin styles and scripts.
	 *
	 * @param string $page The admin page slug.
	 */
	public function enqueue_assets( $page ) {
		// Media assets.
		if ( 'prixz-modules_page_prixz-modules-slider' === $page ) {
			wp_enqueue_media();

			wp_enqueue_script(
				'admin-media',
				namespace\URL . 'admin/js/media.js',
				array( 'jquery' ),
				namespace\VERSION,
				true
			);

			wp_enqueue_style(
				'admin-media',
				namespace\URL . 'admin/css/media.css',
				array(),
				namespace\VERSION
			);
		}

		// Products assets.
		if ( 'prixz-modules_page_prixz-modules-products' === $page ) {
			wp_enqueue_script(
				'select2',
				namespace\URL . 'admin/js/select2.min.js',
				array(),
				'4.0.13',
				true
			);

			wp_enqueue_style(
				'select2',
				namespace\URL . 'admin/css/select2.min.css',
				array(),
				'4.0.13'
			);

			wp_enqueue_script(
				'admin-products',
				namespace\URL . 'admin/js/products.js',
				array( 'jquery', 'select2' ),
				namespace\VERSION,
				true
			);

			wp_add_inline_script(
				'admin-products',
				'const PRIXZ_MODULES_PRODUCTS_DATA = ' .
					wp_json_encode(
						array(
							'ajax_url' => admin_url( 'admin-ajax.php' ),
							'nonce'    => wp_create_nonce( 'search-products' ),
						)
					),
				'before'
			);
		}
	}
}
