jQuery(function ($) {
    $( document ).ready(function() {
        // Activate the carousel only if there are more than 4 products
        if ($('#home-page-product-carousel .woocommerce .products .product').length <= 4) {
          return;
        }

        // Add the proper swiper classes to the product cards before initializing the carousel.
        $('#home-page-product-carousel .woocommerce').addClass('swiper');
        $('#home-page-product-carousel .woocommerce .products').addClass('swiper-wrapper');
        $('#home-page-product-carousel .woocommerce .products .product').addClass('swiper-slide');

        $('#home-page-product-carousel .woocommerce').append('<div class="swiper-button-prev"></div>');
        $('#home-page-product-carousel .woocommerce').append('<div class="swiper-button-next"></div>');
        $('#home-page-product-carousel .woocommerce').append('<div class="swiper-pagination"></div>');

        // Initialize the Swiper carousel
        const carousel = new Swiper('#home-page-product-carousel .woocommerce', {
            // Optional parameters
            direction: 'horizontal',
            loop: true,
            autoplay: true,
            slidesPerView: 4,

            pagination: {
              el: '.swiper-pagination',
            },

            // Navigation arrows
            navigation: {
              nextEl: '.swiper-button-next',
              prevEl: '.swiper-button-prev',
            },
          });
    });
});
