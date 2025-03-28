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
			<p><?php esc_html_e( 'Instructions: Set some slider images, make sure the file names of the images do not have dashes, slashes or any special character.', 'prixz-modules' ); ?></p>
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
	 * Add the settings sections and fields to the admin view.
	 */
	public function init_settings() {
		$settings_sections = array(
			'prixz-modules-slider-settings-section' => array(
				'settings' => array(
					'prixz-modules-slider-image-ids' => array( 'field_type' => 'hidden' ),
				),
			),
		);

		$settings = new Settings( 'prixz-modules-slider', 'prixz-modules-slider-group' );
		$settings->add_settings_sections( $settings_sections );
	}

	/**
	 * Enqueue the admin styles and scripts.
	 */
	public function enqueue_assets() {
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
}
