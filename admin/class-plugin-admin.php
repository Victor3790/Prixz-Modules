<?php
/**
 * This class will handle admin functionality for the plugin.
 *
 * @package PrixzModules
 */

namespace PrixzModules;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * The admin class for the plugin.
 */
class Plugin_Admin {
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
}
