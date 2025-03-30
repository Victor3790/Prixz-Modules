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
	 * The constructor for the class.
	 */
	public function __construct() {
		require_once namespace\PATH . 'includes/class-slider.php';
		require_once namespace\PATH . 'includes/class-product-carousel.php';
	}
	/**
	 * Add styles and scripts
	 */
	public function enqueue_assets() {
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

		// Slider.
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

		// Carousel.
		wp_enqueue_script(
			'carousel',
			namespace\URL . 'public/js/carousel.js',
			array(
				'jquery',
				'swiper',
			),
			namespace\VERSION,
			true
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

		$image_ids = json_decode( get_option( 'prixz-modules-slider-image-ids' ) );
		if ( empty( $image_ids ) ) {
			return;
		}

		$slider_module = new Slider();

		$images = $slider_module->get_media( $image_ids );

		$slider_module->add_slider( $images );
	}

	/**
	 * Add the product carousel to the home page.
	 */
	public function add_product_carousel_to_home() {
		if ( ! is_front_page() ) {
			return;
		}

		$product_data = json_decode( get_option( 'prixz-modules-products-ids' ) );
		if ( empty( $product_data ) ) {
			return;
		}

		$ids        = array_column( $product_data, 'id' );
		$string_ids = implode( ',', $ids );

		$product_carousel_module = new Product_Carousel();
		$product_carousel_module->add_carousel( $string_ids );
	}
}
