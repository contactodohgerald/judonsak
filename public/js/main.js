;(function () {
    'use strict';

    var $body = $('body'),
        $window = $(window),
        windowHeight = $window.height(),
        windowWidth = $window.width();

    /*==============================================
     Retina support added
     ===============================================*/
    if (window.devicePixelRatio > 1) {
        $(".retina, .navbar-brand img, .logo img").imagesLoaded(function () {
            $(".retina, .navbar-brand img, .logo img").each(function () {
                // var src = $(this).attr("src").replace(".", "@2x.");
                var h = $(this).height();
                $(this).attr("src", src).css({height: h, width: "auto"});
            });
        });
    }


    /* ---------------------------------------------
     Sticky header
     --------------------------------------------- */
    var sticky = new Waypoint.Sticky({
        element: $('.Sticky')[0],
        stuckClass: 'Sticky--stuck'
    });

    // grab an element
    var myElement = document.getElementById('header');
    // construct an instance of Headroom, passing the element
    var headroom  = new Headroom(myElement, {
        tolerance: {
            down : 50,
            up : 0
        },
        offset : 50,
        classes : {
            // when element is initialised
            initial : "",
            // when scrolling up
            pinned : "Sticky--pinned",
            // when scrolling down
            unpinned : "Sticky--pinned",
            // when above offset
            top : "Sticky--top",
            // when below offset
            notTop : "Sticky--top",
            // when at bottom of scoll area
            bottom : "headroom--bottom",
            // when not at bottom of scroll area
            notBottom : "headroom--not-bottom"
        }
    });
    // initialise
    headroom.init();



    /*==============================================
     Returns height of browser viewport
     ===============================================*/
    $window.on('resize.windowscreen', function() {
        var height = $(this).height(),
            width = $(this).width(),

            $jsFullHeight = $('.js-FullHeight'),
            $mainNav = $('#mainNav'),

            $mainNavSticky = $mainNav.hasClass('navbar-sticky'),

            isFixedNavbar = $mainNav.hasClass('navbar-fixed'),
            isNoBgNavbar = $mainNav.hasClass('no-background'),
            isTransNavbar = $mainNav.hasClass('navbar-transparent'),

            $mainNav_height = $mainNav.height(),
            $mainNav_nextSection = $mainNav.parent().next();

            windowHeight = $window.height();
            windowWidth = $window.width();

        // bottom nav
        if ($mainNavSticky) {
            var $_bottom_nav = $mainNav.parent('header'),
                $_bottom_navBanner = $_bottom_nav.prev($jsFullHeight),
                $_bottom_bannerHeight = height - $mainNav_height;

                $_bottom_navBanner.height($_bottom_bannerHeight);
        } else {
            if (isFixedNavbar && !isNoBgNavbar || !isTransNavbar) {
                var _height = height - $mainNav_height;

                $jsFullHeight.height(_height);
                $mainNav_nextSection.css('margin-top', $mainNav_height);
            }

            if (isFixedNavbar && isNoBgNavbar || isTransNavbar) {
                if (width < 1024) {
                    var _xs_height = height - $mainNav_height;

                    $mainNav_nextSection.css('margin-top', $mainNav_height);
                    $jsFullHeight.height(_xs_height);
                } else {
                    $jsFullHeight.height(height);

                    $mainNav_nextSection.css('margin-top', '0');
                }
            }
        }

    });

    $window.trigger('resize.windowscreen');


    /*==============================================
     Switch init
     ===============================================*/
    $('.js-Switch').each(function(){
        new Switchery(this, $(this).data());
    })


    /*==============================================
     Parallax
     ===============================================*/

    $.fn.alienParallax = function() {
        var $this = $(this), el_top;
        $this.each(function() { el_top = $this.offset().top; });
        function update() {
            if (windowWidth <= 992) {
                return;
            }
            var pos = $window.scrollTop();
            $this.each(function() {
                var $el = $(this), top = $el.offset().top, height = $el.outerHeight(true);
                if (top + height < pos || top > pos + windowHeight )
                    return;
                $this.css('backgroundPosition', '50% ' + Math.round((el_top - pos) * 0.4) + 'px');
            })
        }
        $window.on('scroll resize', update).trigger('update');
    };

    $('.ImageBackground').each(function(){
        var $this = $(this),
            $imgHolder = $this.children('.ImageBackground__holder'),
            thisIMG = $imgHolder.children().attr('src'),
            thisURL = 'url('+thisIMG+')';
        $imgHolder.css('background-image', thisURL);

        if ($this.hasClass('js-Parallax') && windowWidth > 992) {
            $imgHolder.alienParallax();
        }
    });

    $window.trigger('resize').trigger('scroll');


    // /*==============================================
    //  CountTo init
    //  ===============================================*/
    // $('.js-CountTo').each(function() {
    //     var $this = $(this),
    //     firstLoadCountEvent = true;

    //     $this.waypoint(function() {
    //         if (firstLoadCountEvent) {
    //             $this.countTo({
    //                 speed : 2000,
    //                 refreshInterval : 50,
    //                 formatter : function(value, options) {
    //                     value = value.toFixed(options.decimals);
    //                     value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    //                     return value;
    //                 }
    //             });
    //             firstLoadCountEvent = false;
    //         }
    //     }, {
    //         offset : '90%'
    //     });
    // });


    /*==============================================
     Owl carousel init
     ===============================================*/
    // $('.js-OwlCarousel').owlCarousel({
    //     items: 1,
    //     loop: true,
    //     margin: 0,
    //     nav: true,
    //     navText : ["", ""]
    // });

    // $('.js-OwlCarousel2').owlCarousel({
    //     margin: 40,
    //     nav: true,
    //     navText : ["", ""],
    //     slideBy: 1,
    //     responsive : {
    //         0 : { items: 1 },
    //         480 : { items: 2 }
    //     }
    // });

    // $('.js-OwlCarousel3').owlCarousel({
    //     margin: 40,
    //     nav: true,
    //     navText : ["", ""],
    //     slideBy: 1,
    //     responsive : {
    //         0 : { items: 1 },
    //         480 : { items: 2 },
    //         768 : { items: 3 }
    //     }
    // });

    // $('.js-OwlCarousel4').owlCarousel({
    //     margin: 40,
    //     nav: true,
    //     navText : ["", ""],
    //     slideBy: 1,
    //     responsive : {
    //         0 : { items: 1 },
    //         480 : { items: 2 },
    //         768 : { items: 3 },
    //         992 : { items: 4 }
    //     }
    // });

    // $('.js-OwlCarousel5').owlCarousel({
    //     margin: 40,
    //     nav: true,
    //     navText : ["", ""],
    //     slideBy: 1,
    //     responsive : {
    //         0 : { items: 2 },
    //         480 : { items: 2 },
    //         768 : { items: 3 },
    //         992 : { items: 5 }
    //     }
    // });


    /*==============================================
     Progressbar init
     ===============================================*/
    // $('.progress').each(function() {
    //     var dataParcent = $(this).attr('data-percent'),
    //         progressTitle,
    //         progressTitle__outer = $(this).prev('.progress-title'),
    //         progressTitle__inner = $(this).children('.progress-title');

    //     if (progressTitle__outer.length > 0) {
    //         progressTitle = progressTitle__outer.css('width', dataParcent)
    //     } else if (progressTitle__inner.length > 0) {
    //         progressTitle = progressTitle__inner.css('width', dataParcent)
    //     }

    //     $(this).appear(function() {
    //         $(this).find('.progress-bar').animate({
    //             width : dataParcent
    //         }, 500);
    //     });
    // });


    /*==============================================
     Portfolio grid init
     ===============================================*/
    // var $alienPortfolio = $('.js-Portfolio');

    // $alienPortfolio = $('.js-Portfolio').isotope({
    //     itemSelector: '.portfolio-item',
    //     filter: '*'
    // });

    // if ($.fn.imagesLoaded) {
    //     $alienPortfolio.imagesLoaded().progress(function () {
    //         $alienPortfolio.isotope('layout');
    //     });
    // }

    // $('.js-PortfolioFilter').on('click focus', 'a', function (e) {
    //     var $this = $(this);
    //     e.preventDefault();
    //     $this.parent().addClass('active').siblings().removeClass('active');
    //     $alienPortfolio.isotope({filter: $this.data('filter')});
    // });


    /*==============================================
     Portfolio popup
     ===============================================*/
    $(".portfolio-gallery").each(function () {
        $(this).find(".popup-gallery").magnificPopup({
            type: "image",
            gallery: {
                enabled: true
            }
        });
    });

    $(".popup-youtube, .popup-vimeo, .popup-gmaps").magnificPopup({
        disableOn: 700,
        type: "iframe",
        mainClass: "mfp-fade",
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });

    // Example 1: From an element in DOM
    $('.open-popup-link').magnificPopup({
      type:'inline',
      midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
    });

})(jQuery);
