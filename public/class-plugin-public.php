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

	/**
	 * So far the plugin is only adding the slider to the home page of the Storefront theme
	 * if the homepage displays the latest posts, but this can be modified to add a slider
	 * at another location or through a shortcode with further changes.
	 */
	public function add_slider_to_home() {
		if ( ! is_front_page() ) {
			return;
		}

		$slider_module = new Slider();
		$slider_module->add_slider();
	}
}
