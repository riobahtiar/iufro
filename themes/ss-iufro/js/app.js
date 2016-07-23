var reinitTimer;

var app = {
    homeURL: app_vars.homeURL,
    themeURL: app_vars.themeURL,
    siteName: app_vars.siteName,
    greedyMenu: false,
    offCanvas: true,
    offCanvasMenu: '#navbar .menu',
    offCanvasDirectionFrom: 'right',
    isPhone: false,
    greedyCheck: function() {},
    init: function($) {
        app.wrapHome();
        app.wrapPage();
        app.pageHero();
        app.detectBrowser();
        app.changeImgPageHero();
        app.stellarParallax();
        app.moveHeroDetailPage();
        app.wrapFieldTrip();
        app.detectUserProfile();
        app.removeClassToggle();
        app.detectToggleOff();
        app.toggleOff();
        app.matchHeight();

        // Size things
        app.mobileNavbarOpenOnClick();
        app.greedySubmenuReveal();
        app.phoneDetect();
        //app.removeEmptyParagraph();
        app.onTopDetect();
        app.backToTopAnimation();
        app.offCanvasInit();
        app.greedyNavInit($);
        app.greedyNavButtonInit();
        app.offCanvasTrigger();
        app.offCanvasMenuControl();
        app.scrollToContent();
        app.slideshowInit();
        app.wrapImageBlock();
        app.addAttributeToButton();
        app.handleMobileNav();
        app.floatHeader();
    },
    toggleOff: function() {
        jQuery('.container> .field-trip:nth-of-type(1) .col-md-4> div[data-toggle="toggle"]').click(function() {
            a = jQuery(this);
            if (a.hasClass('off')) {
                a.parent().parent().parent().parent().removeClass('disable');
            } else {
                a.parent().parent().parent().parent().addClass('disable');
            }
        });

        jQuery("#radio-custom-toggle").click(function() {
            jQuery('#custom-toggle').slideToggle();
        });
    },
    detectUserProfile: function() {
        var a = jQuery('#main-profile');
        if (a.length > 0) {
            jQuery('body').addClass('profileuser');
        }
    },
    detectToggleOff: function() {
        var b = jQuery('.field-trip .col-md-4> .off');
        jQuery('.field-trip-wrap').ready(function() {
            if (b.length > 0) {
                jQuery(this).addClass('off-toggle');
            }
        });
    },
    wrapFieldTrip: function() {
        jQuery(".field-trip:nth-of-type(1) .col-md-6").wrapInner("<div class='field-trip-wrap'></div>");
        jQuery(".field-trip.col-md-4").wrapAll("<div class='field-trip-upload'></div>");
        jQuery(".field-trip.col-md-4").wrapInner("<div class='field-trip-upload-item'></div>");
        jQuery(".field-trip:nth-of-type(1)> .col-md-6> .field-trip-wrap>.row:nth-of-type(1)").wrapInner("<div class='field-trip-type'></div>");
    },
    removeClassToggle: function() {
        // jQuery('.post-139 .field-trip-wrap > .col-md-4 .toggle').ready(function() {
        // jQuery('.post-139 .field-trip-wrap > .col-md-4 .toggle').find().removeClass('.btn');
        //
        jQuery('.post-139 .field-trip .col-md-4').find('*').each(function() {
            jQuery(this).removeClass('btn btn-default btn-primary');
            jQuery(this).removeClass('toggle');
        });
        // });
    },
    moveHeroDetailPage: function() {
        jQuery('.single .post-thumbnail').parent().parent().parent().prepend(jQuery('.single .post-thumbnail'));
    },
    stellarParallax: function() {
        jQuery(".bg-page-hero,.ss-slideshow .ss-slide").attr("data-stellar-background-ratio", "0.5");
        jQuery.stellar({
            horizontalScrolling: false,
            responsive: true,
            verticalOffset: 150
        });
    },
    changeImgPageHero: function() {
        // jQuery(".post-thumbnail img").each(function(i, elem) {
        //     var img = jQuery(elem);
        //     var div = jQuery("<div />").css({
        //         'background-image': "url(" + img.attr("src") + ")",
        //     });
        //
        //     div.html(img.attr("alt"));
        //     div.addClass("bg-page-hero");
        //
        //     img.replaceWith(div);
        // });
        var src = jQuery(".post-thumbnail img").attr("src");
        jQuery("<div class='bg-page-hero' style='background-image:url(" + src + " )'></div>").insertAfter(".post-thumbnail img");
    },
    detectBrowser: function() {
        jQuery(document).ready(function() {
            /* Get browser */
            jQuery.browser.chrome = /chrome/.test(navigator.userAgent.toLowerCase());
            /* Detect Chrome */
            if (jQuery.browser.chrome) {
                /* Do something for Chrome at this point */
                jQuery('body').addClass('chrome');
                /* Finally, if it is Chrome then jQuery thinks it's*/
            } else if (jQuery.browser.mozilla) {
                jQuery('body').addClass('firefox');
            } else if (jQuery.browser.msie) {
                jQuery('body').addClass('ie');
            }
        });
    },
    matchHeight: function() {
        jQuery('.pre-event-item .content-wrap> *,.rundown-item .content-wrap> *,.field-trip:nth-of-type(1)> .col-md-6> .field-trip-wrap>.row:last-child .col-md-6>*').matchHeight({
            byRow: true,
            property: 'height',
            target: null,
            remove: false
        });
    },
    wrapHome: function() {
        jQuery("#ss_part_widget-2,#ss_part_widget-10,.ss-slideshow .ss-slide-caption").wrapInner("<div class='container-custom'></div>");
        jQuery("#ss_part_widget-8,#ss_part_widget-9").wrapAll("<div class='container-custom venue-wrap'><div class='venue-item'></div></div>");
        jQuery(".venue-wrap").wrap("<div class='venue-holder'></div>");

    },
    pageHero: function() {
        jQuery("#page-content .entry-title,#page-content .post-thumbnail").wrapAll("<div class='page-hero'></div>");
        jQuery(".page-hero").prependTo("#content");
        jQuery(".page-hero .entry-title").wrap("<div class='container-custom'></div>");
    },
    wrapPage: function() {
        jQuery(".keynote_speaker").wrapInner("<div class='keyspeaker-wrap'></div>");
        jQuery(".popular-entry").wrapInner("<div class='popular-entry-wrap'></div>");
    },

    mobileNavbarOpenOnClick: function() {
        if (jQuery('body').hasClass('is-mobile')) {
            app.navbarOpenOnClick = true;
        }
    },
    handleMobileNav: function() {
        if (app.isPhone === true) {
            // jQuery('.sub-menu').hide();
        }

        jQuery(document).on('click', '#offcanvas .menu-item-has-children > a', function() {
            if (!jQuery(this).parent().hasClass('opened')) {
                jQuery(this).parent().addClass('opened');
                return false;
            } else {
                jQuery(this).parent().removeClass('opened');
            }
        });
    },
    floatHeader: function() {
        /*
         * Desc: trigger floating header when page scrolled down
         */

        jQuery(window).scroll(function() {
            var top = jQuery(document).scrollTop();
            if (top > 0) {
                jQuery('body').addClass('sticky-header-on').removeClass('sticky-header-off');
            } else {
                jQuery('body').addClass('sticky-header-off').removeClass('sticky-header-on');
            }
        });
    },
    addAttributeToButton: function() {
        jQuery('.btn').each(function() {
            var text = jQuery(this).text();
            jQuery(this).attr('data-text', text);
        });

        // Add attr to H2
        jQuery('.ss-text-block .ss-parts-single-part > a > h2').each(function() {
            var text = jQuery(this).text();
            jQuery(this).attr('data-hover', text);
            jQuery(this).parent().attr('data-hover', text);
        });
    },
    wrapImageBlock: function() {
        jQuery('.ss-image-block .ss-parts-single-part').each(function() {
            jQuery(this).find('> h2, > p').wrapAll('<div class="ss-caption-wrapper" />');
            jQuery(this).find('.ss-parts-image, .ss-caption-wrapper, > a').wrapAll('<div class="ss-parts-single-wrapper" />');
        });
    },
    slideshowInit: function() {
        if (!jQuery('.ss-slideshow').length) {
            return false;
        }

        var $slideshow = jQuery('.ss-slideshow');
        var $slideNext = $slideshow.find('.ss-right');
        var $slidePrev = $slideshow.find('.ss-left');

        //destroy all
        $slideshow.cycle('destroy');

        //restore background image
        jQuery('.ss-slide').each(function() {
            var backgroundImage = jQuery(this).data("backgroundImage");
            jQuery(this).css('background-image', 'url(' + backgroundImage + ')');
        });

        //set visible items based on window width
        var width = jQuery(window).width();
        $slideshow.each(function() {
            var visibleItems;
            if (width >= 992) { //desktop
                visibleItems = jQuery(this).data("cycleCarouselVisibleDesktop");
            } else if (width >= 768) { //tablet
                visibleItems = jQuery(this).data("cycleCarouselVisibleTablet");
            } else { //mobile
                visibleItems = jQuery(this).data("cycleCarouselVisibleMobile");
            }
            jQuery(this).data("cycleCarouselVisible", visibleItems);
        });

        function getCycleData(id) {
            var slideClass = '.ss-slideshow .ss-slide';
            var result = false;

            jQuery(slideClass).not('.cycle-sentinel').each(function(i) {
                if (i == id) {
                    var image = jQuery(this).data('background-image');
                    var title = jQuery(this).find('.ss-slide-caption h3').text();
                    var caption = jQuery(this).find('.ss-slide-caption .ss-slide-content').text();

                    result = {
                        image: image,
                        title: title,
                        caption: caption
                    };
                }
            });
            return result;
        }

        function getPrevID(currentID, totalID) {
            var prevID;
            if (currentID <= 0) {
                prevID = (totalID - 1);
            } else {
                prevID = (currentID - 1);
            }
            return prevID;
        }

        function renderHTML(image, title, caption, elm) {
            var HTML = "<div class='nav-text'><h3>" + title + " <span>" + caption + "</span></h3><div class='nav-bg-image' style='background-image: url(" + image + ")'></div></div>";
            elm.html(HTML);
        }

        // On analized
        $slideshow.on('cycle-update-view', function(event, optionHash) {

            var prevSlide = getCycleData(getPrevID(optionHash.currSlide, optionHash.slideCount));
            var nextSlide = getCycleData(optionHash.nextSlide);

            if (jQuery('.ss-slideshow').hasClass('ss-parts-carousel')) {
                nextSlide = getCycleData(optionHash.nextSlide + 1);
            }

            renderHTML(prevSlide.image, prevSlide.title, prevSlide.caption, $slidePrev);
            renderHTML(nextSlide.image, nextSlide.title, nextSlide.caption, $slideNext);
        });

        // init default setting for slider
        $slideshow.cycle({
            manualSpeed: 500,
            slides: '.ss-slide',
            pagerTemplate: '<span></span>'
        });
    },
    removeEmptyParagraph: function() {
        jQuery('p').each(function() {
            var $this = jQuery(this);
            if ($this.html().replace(/\s|&nbsp;/g, '').length === 0)
                $this.remove();
        });
    },
    offCanvasInit: function() {
        if (!app.offCanvas || !jQuery(app.offCanvasMenu).length) {
            return false;
        }

        var offCanvasButtonHTML = "<span class='offcanvas-hamburger'></span>";
        jQuery(offCanvasButtonHTML).insertAfter(app.offCanvasMenu);

        var $offCanvasHTML = jQuery(app.offCanvasMenu)[0].outerHTML;
        $offCanvasHTML = '<div id="offcanvas" class="' + app.offCanvasDirectionFrom + '"><span class="close-btn"></span>' + $offCanvasHTML + '</div><div class="overlay"></div>';
        jQuery($offCanvasHTML).insertBefore('#footer');

        // Add class
        jQuery(app.offCanvasMenu).parent().addClass('offcanvas-menu');
        jQuery('body').addClass('offcanvas-active');
    },
    offCanvasTrigger: function() {
        jQuery('.offcanvas-hamburger').on('click', function() {
            if (!jQuery('body').hasClass('offcanvas-opened')) {
                jQuery('body').addClass('offcanvas-opened');
            }
        });

        jQuery('#offcanvas .close-btn, .offcanvas-opened .overlay').on('click', function() {
            if (jQuery('body').hasClass('offcanvas-opened')) {
                jQuery('body').removeClass('offcanvas-opened');
            }
        });
    },
    offCanvasMenuControl: function() {
        if (!app.isPhone) {
            jQuery('body').removeClass('offcanvas-opened');
        }
    },
    phoneDetect: function() {
        if (jQuery('#phone-detection').css('display') == 'none') {
            app.isPhone = true;
        } else {
            app.isPhone = false;
        }
    },
    onTopDetect: function() {
        jQuery(window).scroll(function() {
            var top = jQuery(document).scrollTop();
            if (top > 0) {
                jQuery('body').addClass('not-on-top');
            } else {
                jQuery('body').removeClass('not-on-top');
            }
        });
    },
    backToTopAnimation: function() {
        var button = "#back-to-top";
        jQuery(button).click(function(event) {
            event.preventDefault();
            jQuery('html,body').animate({
                scrollTop: 0
            }, 500);
        });
    },
    scrollToContent: function() {
        var button = ".top-hero .ss-part-button";
        var offset = 90;
        var speed = 1000;

        jQuery(button).click(function(event) {
            event.preventDefault();

            var height = jQuery(window).height();
            jQuery('html,body').animate({
                scrollTop: height - offset
            }, speed);
        });
    },
    greedyNavButtonInit: function() {
        if (!app.greedyMenu) {
            return false;
        }

        jQuery("<span class='greedy-trigger'>More<ul class='hidden-links hidden'></ul></span>").insertAfter('#navbar .menu');
        jQuery('#navbar .menu').parent().addClass('greedy');
        jQuery(document).trigger('greedyNavReady');
    },
    greedyNavInit: function($) {
        if (!app.greedyMenu) {
            return false;
        }

        jQuery(document).on('greedyNavReady', function() {

            var $nav = $('.greedy');
            var $btn = $('.greedy .greedy-trigger');
            var $vlinks = $('.greedy .menu');
            var $hlinks = $('.greedy .hidden-links');

            var numOfItems = 0;
            var totalSpace = 0;
            var breakWidths = [];

            // Get initial state
            $vlinks.children().outerWidth(function(i, w) {
                totalSpace += w;
                numOfItems += 1;
                breakWidths.push(totalSpace);
            });

            var availableSpace, numOfVisibleItems, requiredSpace;

            app.greedyCheck = function() {

                // Get instant state
                availableSpace = $vlinks.width() - 10;
                numOfVisibleItems = $vlinks.children().length;
                requiredSpace = breakWidths[numOfVisibleItems - 1];

                // There is not enought space
                if (requiredSpace > availableSpace) {
                    $vlinks.children().last().prependTo($hlinks);
                    numOfVisibleItems -= 1;
                    app.greedyCheck();

                    // There is more than enough space
                } else if (availableSpace > breakWidths[numOfVisibleItems]) {
                    $hlinks.children().first().appendTo($vlinks);
                    numOfVisibleItems += 1;
                }
                // Update the button accordingly
                $btn.attr("count", numOfItems - numOfVisibleItems);
                if (numOfVisibleItems === numOfItems) {
                    $btn.addClass('hidden');
                    jQuery('body').removeClass('greedy-menu-active');
                } else {
                    $btn.removeClass('hidden');
                    jQuery('body').addClass('greedy-menu-active');
                }
            };

            if (app.navbarSubMenuTrigger == "click") {
                $btn.on('click', function() {
                    jQuery('.menu-item').removeClass('opened');
                    $hlinks.toggleClass('hidden');
                });
            } else {
                $btn.hover(function() {
                    jQuery('.menu-item').removeClass('opened');
                    $hlinks.removeClass('hidden');
                }, function() {
                    $hlinks.addClass('hidden');
                });
            }

            app.greedyCheck();
        });
    },
    greedySubmenuReveal: function() {
        jQuery(document).on('click', '.hidden-links .menu-item-has-children', function() {
            if (!jQuery(this).hasClass('children-opened')) {
                jQuery(this).addClass('children-opened');
            } else {
                jQuery(this).removeClass('children-opened');
            }
        });
    },
    onResize: function() {
        app.phoneDetect();
        app.offCanvasMenuControl();
        app.greedyCheck();

        //TODO: trigger only refresh
        clearTimeout(reinitTimer);
        reinitTimer = setTimeout(app.slideshowInit, 500);
    }
};

jQuery(document).ready(function($) {
    app.init($);
    jQuery(window).resize(function() {
        app.onResize();
    });
});
