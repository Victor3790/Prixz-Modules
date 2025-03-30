<?php
/**
 * This is the slider module class.
 *
 * @package PrixzModules
 */

namespace PrixzModules;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * This class handles the slider functions.
 */
class Slider {
	/**
	 * Add the HTML structure.
	 *
	 * @param array $images The array of images.
	 */
	public function add_slider( $images = array() ) {
		// Check if images are provided.
		if ( empty( $images ) ) {
			return;
		}
		?>
			<!-- Slider main container -->
			<div id="home-page-slider" class="swiper">
				<!-- Additional required wrapper -->
				<div class="swiper-wrapper">
					<!-- Slides -->
					<?php
					foreach ( $images as $image ) {
						?>
						<div class="swiper-slide">
							<img src="<?php echo esc_url( $image ); ?>" />
						</div>
						<?php
					}
					?>
				</div>
				<!-- If we need pagination -->
				<div class="swiper-pagination"></div>

				<!-- If we need navigation buttons -->
				<div class="swiper-button-prev"></div>
				<div class="swiper-button-next"></div>
			</div>
		<?php
	}

	/**
	 * Get the images based on the id.
	 *
	 * @param array  $ids The array of image ids.
	 * @param string $size The size of the image.
	 */
	public function get_media( $ids = array(), $size = 'full' ) {
		$images = array();
		foreach ( $ids as $id ) {
			$image = wp_get_attachment_image_url( $id, $size );

			if ( ! empty( $image ) ) {
				$images[] = $image;
			}
		}
		return $images;
	}
}
