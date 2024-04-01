jQuery.event.special.touchstart = {
    setup: function( _, ns, handle ) {
        this.addEventListener("touchstart", handle, { passive: !ns.includes("noPreventDefault") });
    }
};
jQuery.event.special.touchmove = {
    setup: function( _, ns, handle ) {
        this.addEventListener("touchmove", handle, { passive: !ns.includes("noPreventDefault") });
    }
};
jQuery.event.special.wheel = {
    setup: function( _, ns, handle ){
        this.addEventListener("wheel", handle, { passive: true });
    }
};
jQuery.event.special.mousewheel = {
    setup: function( _, ns, handle ){
        this.addEventListener("mousewheel", handle, { passive: true });
    }
};

(function ($) {
    "use strict";


    /*Document is Ready */
    $(document).ready(function () {

        // =============================================
        // HEADER
        // =============================================
        $(window).on("scroll", function () {
            var header = $('header');
            var topmenu = $('.topbar');
            var windowheight = $(this).scrollTop();
            var menuheight = header.outerHeight();
            var firstlogo = $('.first-logo');
            var secondlogo = $('.second-logo');
            var topmenuheight = 0;

            if (topmenu.length) {
                var topmenuheight = topmenu.outerHeight();
            }
            var fixedheight = topmenuheight;
            if (header.length) {
                if ((windowheight > fixedheight) && header.hasClass("sticky-header")) {
                    header.addClass('header-fixed-top').delay(200);
                    if (!header.hasClass("transparent-header")) {
                        header.next("*").css("margin-top", menuheight);
                    }
                    if (header.hasClass("sticky-header")) {
                        header.addClass("scroll-header");
                    }
                    // CHANGE LOGO ON SCROLL
                    firstlogo.css("display", "none");
                    secondlogo.css("display", "block");

                } else {
                    header.removeClass("header-fixed-top");
                    if (!header.hasClass("transparent-header")) {
                        header.next("*").css("margin-top", "0");
                    }
                    if (header.hasClass("sticky-header")) {
                        header.removeClass("scroll-header");
                    }
                    // CHANGE LOGO ON REVERSE SCROLL
                    if (!header.hasClass('mobile-header')) {
                        firstlogo.css("display", "block");
                        secondlogo.css("display", "none");
                    }
                }
            }
        });

        // =============================================
        // MENU
        // =============================================
        function mmenuInit() {
            var screenwidth = $(window).width();
            var header = $('header');
            var main_menu = $('#main-menu');
            var mobile_menu = $('#mobile-menu');
            var menu_toggler = $("#toggle-menu-button");
            var menubreakpoint = $('header').data("menutoggle");
            var dropdown = $('.dropdown');
            var biglogo = $('.big-logo');
            var mobilelogo = $('.mobile-logo');
            var menuside = 'right';

            // MOBILE
            if (screenwidth <= menubreakpoint) {

                // CLONE MAIN MENU
                $("#main-menu ul").clone().addClass("mmenu-init").prependTo(mobile_menu).removeAttr('id').removeClass('navbar-nav mx-auto').find('a').siblings('ul.dropdown-menu').removeAttr('class');

                header.addClass('mobile-header');
                header.removeClass('vertical-header , open-header');
                main_menu.css({
                    "display": "none"
                });
                biglogo.css({
                    "display": "none"
                });
                mobilelogo.css({
                    "display": "block"
                });

                mobile_menu.mmenu({
                    extensions: [
                        'position-' + menuside,
                        "fx-menu-slide",
                    ],
                }, {

                    offCanvas: {
                        pageSelector: ".wrapper"
                    },

                    classNames: {
                        fixedElements: {
                            fixed: [
                                'topbar',
                                'header',
                            ]
                            //elemInsertsMethod: "insertBefore",
                            //elemInsertSelector: ".wrapper"
                        }
                    }

                });

                var menu_API = mobile_menu.data("mmenu");
                menu_toggler.on("click", function () {
                    menu_API.open();
                    menu_API.close();
                });

                header.on("click", function () {
                    menu_API.close();
                });

                menu_API.bind("open:finish", function () {
                    setTimeout(function () {
                        menu_toggler.addClass("open");
                    });
                });

                menu_API.bind("close:finish", function () {
                    setTimeout(function () {
                        menu_toggler.removeClass("open");
                    });
                });

                // DESKTOP
            } else {

                //DESKTOP HORIZONTAL MENU
                header.removeClass('mobile-header');
                main_menu.css({
                    "display": "block"
                });

                biglogo.css({
                    "display": "block"
                });
                mobilelogo.css({
                    "display": "none"
                });

                // DESKTOP VERTICAL MENU
                if (header.hasClass('vertical-header')) {
                    $('header').insertBefore('.wrapper');
                    $('header > div').removeClass('container');
                    if (header.hasClass('open-header')) {
                        $('body').addClass('has-vertical-header-open');
                        menu_toggler.css({
                            "display": "none"
                        });
                    } else {
                        $('body').addClass('has-vertical-header');
                    }
                    menu_toggler.on("click", function () {
                        header.toggleClass('open-header');
                        menu_toggler.toggleClass('open');
                        $('body').toggleClass('has-vertical-header-open');
                    });
                }

                // Open Drop Down Menu on hover for horizontal & vertical header
                dropdown.on({
                    mouseenter: function () {
                        $(this).addClass("open");
                    },
                    mouseleave: function () {
                        $(this).removeClass('open');
                        $('.submenu').removeClass('submenu-left');
                    }
                });

            }
            header.addClass("loaded-header");
        }

        mmenuInit();

        $(window).resize(function () {
            mmenuInit();
        });


        // =============================================
        // BACK TO TOP
        // =============================================
        var amountScrolled = 500;
        var backtotop = $('.back-to-top');

        $(window).on('scroll', function () {
            if ($(window).scrollTop() > amountScrolled) {
                backtotop.addClass('active');
            } else {
                backtotop.removeClass('active');
            }
        });

        backtotop.on('click', function () {
            $(window).scrollTop(0);
        });


    });
})(jQuery);
