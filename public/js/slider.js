jQuery(function ($) {
    $( document ).ready(function() {
        const slider = new Swiper('#home-page-slider', {
            // Optional parameters
            direction: 'horizontal',
            loop: true,
            autoplay: true,
          
            // If we need pagination
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