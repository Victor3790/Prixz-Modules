<?php
/**
 * This is the product carousel module class.
 *
 * @package PrixzModules
 */

namespace PrixzModules;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * This class handles the product carousel functions.
 */
class Product_Carousel {
	/**
	 * Add the HTML structure.
	 *
	 * @param array $product_ids The comma separated product ids.
	 */
	public function add_carousel( $product_ids = '' ) {
		// Check if product data is provided.
		if ( empty( $product_ids ) ) {
			return;
		}
		?>
			<!-- Slider main container -->
			<div id="home-page-product-carousel">
				
				<?php
					echo do_shortcode( '[products ids="' . $product_ids . '" columns="4"]' );
				?>

			</div>
		<?php
	}
}
