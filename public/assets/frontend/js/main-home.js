/*=============================================================
Template Name: Hotel Himara - Hotel HTML Template
Author:        Eagle-Themes (Jomin Muskaj)
Author URI:    http://eagle-themes.com
Version:       1.1.0
=============================================================*/

(function ($) {
    "use strict";


    /*Document is Ready */
    $(document).ready(function () {

        $('.image-gallery').each(function () {
            $(this).magnificPopup({
                // delegate: '.owl-item:not(.cloned) a',
                delegate: 'a',
                type: 'image',
                mainClass: 'mfp-with-zoom',
                zoom: {
                    enabled: true,
                    duration: 300,
                    easing: 'ease-in-out',
                    fixedContentPos: true,
                    opener: function (openerElement) {
                        return openerElement.is('img') ? openerElement : openerElement.find('img');
                    }
                },
                fixedContentPos: true,
                gallery: { enabled: true },
                removalDelay: 300,
                retina: {
                    ratio: 1,
                    replaceSrc: function (item, ratio) {
                        return item.src.replace(/\.\w+$/, function (m) {
                            return '@2x' + m;
                        });
                    }
                }

            });
        });


        $('.openVideo').magnificPopup({
            type: 'inline',
            callbacks: {
                open: function () {
                    $('html').css('margin-right', 0);
                    // Play video on open:
                    $(this.content).find('video')[0].play();
                },
                close: function () {
                    // Reset video on close:
                    $(this.content).find('video')[0].load();
                }
            }
        });


        // =============================================
        // TESTIMONIALS - OWL CAROUSEL
        // =============================================
        var owl = $('.testimonials-owl');
        owl.owlCarousel({
            loop: true,
            items: 3,
            margin: 30,
            nav: true,
            navText: [
                "<i class='fa fa-angle-left' aria-hidden='true'></i>",
                "<i class='fa fa-angle-right' aria-hidden='true'></i>"
            ],
            dots: false,
            autoplay: true,
            autoplayTimeout: 4000,
            responsive: {
                0: {
                    items: 1
                },
                480: {
                    items: 1
                },
                768: {
                    items: 2
                },
                992: {
                    items: 3
                }
            }
        });


        // =============================================
        // EVENTS - OWL CAROUSEL
        // =============================================
        var owl = $('.events-owl');
        owl.owlCarousel({
            loop: false,
            margin: 30,
            nav: true,
            dots: false,
            navText: [
                "<i class='fa fa-angle-left' aria-hidden='true'></i>",
                "<i class='fa fa-angle-right' aria-hidden='true'></i>"
            ],
            responsive: {
                0: {
                    items: 1
                },
                480: {
                    items: 2
                },
                768: {
                    items: 3
                },
                992: {
                    items: 4
                }
            }
        });


        // =============================================
        // GALLERY - OWL CAROUSEL
        // =============================================
        var owl = $('.gallery-owl');
        owl.owlCarousel({
            loop: true,
            margin: 30,
            nav: true,
            dots: false,
            navText: [
                "<i class='fa fa-angle-left' aria-hidden='true'></i>",
                "<i class='fa fa-angle-right' aria-hidden='true'></i>"
            ],
            responsive: {
                0: {
                    items: 1
                },
                480: {
                    items: 2
                },
                768: {
                    items: 4
                },
                992: {
                    items: 5
                }
            }
        });

        // =============================================
        // ROOMS - OWL CAROUSEL
        // =============================================
        var owl = $('.news-owl');
        owl.owlCarousel({
            loop: false,
            margin: 30,
            nav: true,
            dots: false,
            navText: [
                "<i class='fa fa-angle-left' aria-hidden='true'></i>",
                "<i class='fa fa-angle-right' aria-hidden='true'></i>"
            ],
            responsive: {
                0: {
                    items: 1
                },
                480: {
                    items: 2
                },
                768: {
                    items: 3
                },
                992: {
                    items: 3
                }
            }
        });

        // =============================================
        // SERVICES - OWL CAROUSEL
        // =============================================
        var owl = $('.services-owl');
        owl.owlCarousel({
            thumbs: true,
            thumbsPrerendered: true,
            items: 1,
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
            loop: true,
            autoplay: true,
            dots: false,
            nav: false,
            mouseDrag: false,
        });


        // =============================================
        // TESTIMONIALS - RANDOM
        // =============================================
        var random = Math.floor(Math.random() * $('.testimonialv2-item').length);
        $('.testimonialv2-item').hide().eq(random).show();


    });
})(jQuery);
