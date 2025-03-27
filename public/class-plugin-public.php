<?php
/**
 * This class will handle public functionality for the plugin.
 *
 * @package PrixzModules
 */

namespace PrixzModules;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * The public class for the plugin.
 */
class Plugin_Public {
	/**
	 * Add styles and scripts
	 */
	public function enqueue_assets() {
		// Slider.
		wp_enqueue_style(
			'swiper',
			namespace\URL . 'public/css/swiper-bundle.min.css',
			array(),
			'11.2.6'
		);

		wp_enqueue_script(
			'swiper',
			namespace\URL . 'public/js/swiper-bundle.min.js',
			array(),
			'11.2.6',
			true
		);

		wp_enqueue_script(
			'slider',
			namespace\URL . 'public/js/slider.js',
			array(
				'jquery',
				'swiper',
			),
			namespace\VERSION,
			true
		);

		wp_enqueue_style(
			'slider',
			namespace\URL . 'public/css/slider.css',
			array(),
			namespace\VERSION
		);
	}
}
