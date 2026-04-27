if (jQuery.extend({
        hook: function(e) {
            var t;
            return t = e && "*" !== e ? '[data-hook~="' + e + '"]' : "[data-hook]", jQuery(t)
        }
    }), jQuery(document).ready(function() {
        if (jQuery(".product-accordion dt").on("click", function() {
                jQuery(this).hasClass("active") ? jQuery(this).removeClass("active").next("dd").slideUp("fast") : (jQuery(".product-accordion dt.active").removeClass("active").next("dd").slideUp("fast"), jQuery(this).addClass("active").next("dd").slideDown("slow"))
            }).filter(function(e) {
                0 !== e && jQuery(this).next("dd").hide()
            }), jQuery(".product-cart").on("click", ".cart-contents", function() {
                return jQuery(this).next(".widget_shopping_cart").toggleClass("cart-visible"), !1
            }), jQuery(".section-toggle .toggle-title").on("click", function(e) {
                e.preventDefault(), jQuery(this).parents(".section-toggle").find(".toggle-list").toggleClass("active").slideToggle("fast")
            }), jQuery(".section-toggle .group1").on("click", function(e) {
                e.preventDefault(), jQuery(this).parents(".group-holder").find("#group1").addClass("active"), jQuery(".group-holder").find("#group2").removeClass("active")
            }), jQuery(".section-toggle .group2").on("click", function(e) {
                e.preventDefault(), jQuery(this).parents(".group-holder").find("#group2").addClass("active"), jQuery(".group-holder").find("#group1").removeClass("active")
            }), jQuery("#verticalTab").easyResponsiveTabs({
                type: "vertical",
                width: "auto",
                fit: !0
            }), jQuery("#verticalTab1").easyResponsiveTabs({
                type: "vertical",
                width: "auto",
                fit: !0
            }), jQuery(".landing-page-wrapper .resp-tabs-container").find(".thumbs-group.female").addClass("active").css({
                display: "flex"
            }), jQuery(".toggle-male").on("click", function(e) {
                jQuery(this).addClass("active").siblings(".toggle-female").removeClass("active"), jQuery(this).closest(".resp-tabs-container").find(".thumbs-group.female").removeClass("active").css({
                    display: "none"
                }), jQuery(".landing-page-wrapper .resp-tabs-container").find(".thumbs-group.male").addClass("active").css({
                    display: "flex"
                }), e.preventDefault()
            }), jQuery(".toggle-female, .section-toggle .group1, .section-toggle .group2").on("click", function(e) {
                jQuery(".toggle-female").addClass("active").siblings(".toggle-male").removeClass("active"), jQuery(".toggle-female").closest(".resp-tabs-container").find(".thumbs-group.male").removeClass("active").css({
                    display: "none"
                }), jQuery(".landing-page-wrapper .resp-tabs-container").find(".thumbs-group.female").addClass("active").css({
                    display: "flex"
                }), e.preventDefault()
            }), jQuery(".fancy-button").prepend("<i></i>"), jQuery(".toggle-event-date").on("click", function(e) {
                jQuery(".event-container").toggleClass("active"), e.preventDefault()
            }), jQuery(".event-search-icon").on("click", function(e) {
                jQuery(this).parents(".event-search-holder").toggleClass("active"), e.preventDefault()
            }), jQuery(".event-items, .main-content").on("click", function() {
                jQuery(".event-container").removeClass("active")
            }), jQuery(".single-team .editor-content p").length > 1 && jQuery(".single-team .editor-content").addClass("multi-column"), jQuery(".woo-products li").matchHeight({
                byRow: !0,
                property: "height",
                target: null,
                remove: !1
            }), jQuery("ul#main-nav").slimmenu({
                resizeWidth: "900",
                collapserTitle: "Main Menu",
                animSpeed: "fast",
                easingEffect: null,
                indentChildren: !1,
                childrenIndenter: "&nbsp;"
            }), jQuery(".popup").fancybox({
                maxWidth: "800",
                maxHeight: "90%",
                beforeShow: function() {
                    jQuery(window).resize()
                }
            }), jQuery(".gallery .gallery-icon a").attr("rel", "gallery-fancybox"), jQuery(".gallery .gallery-icon a").fancybox({
                beforeShow: function() {
                    jQuery(window).resize()
                }
            }), jQuery(".site-search").on("click", ".icon-search", function() {
                jQuery(this).parent().toggleClass("active"), jQuery(".page-navigation").toggleClass("search-active"), jQuery("#s").attr("autofocus", "autofocus")
            }), jQuery(".menu-overflow-collapser").on("click", function() {
                jQuery(".overflow-menu").slideToggle()
            }), jQuery(".toggle_trigger").click(function() {
                jQuery(this).next(".toggle_hidden").hasClass("showMe") ? jQuery(".toggle_hidden").removeClass("showMe").hide() : (jQuery(".toggle_hidden").removeClass("showMe").hide(), jQuery(this).next(".toggle_hidden").addClass("showMe").show())
            }), jQuery(".toggle_hidden").hide(), jQuery("blockquote p span:empty").closest("p").remove(), jQuery(".carousel-holder ul").slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                dots: !1,
                responsive: [{
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3
                    }
                }, {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 3
                    }
                }, {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2
                    }
                }]
            }), jQuery(".nav-carousel .carousel-content").slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                dots: !1,
                responsive: [{
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3
                    }
                }, {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 3
                    }
                }, {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2
                    }
                }]
            }), jQuery(".inner-container .item .image-container").slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: !1,
                fade: !0,
                asNavFor: ".inner-container .item .thumbnail"
            }), jQuery(".inner-container .item .thumbnail").slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                asNavFor: ".inner-container .item .image-container",
                dots: !1,
                arrows: !1,
                centerMode: !0,
                focusOnSelect: !0
            }), jQuery(".property-slider").slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: !0,
                fade: !0,
                asNavFor: ".property-slider-nav"
            }), jQuery(".property-slider-nav").slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                asNavFor: ".property-slider",
                dots: !1,
                arrows: !1,
                centerMode: !0,
                focusOnSelect: !0
            }), jQuery(".ytb-iframe").click(function() {
                var e = '<iframe width="560" height="315" src="' + jQuery(this).find("img").attr("data-video") + '?rel=0&amp;controls=0&amp;showinfo=0&amp;autoplay=1" frameborder="0" allowfullscreen></iframe>';
                jQuery(this).find("img").replaceWith(e), jQuery(this).addClass("active")
            }), jQuery(".iframe-play .image-holder").click(function(e) {
                jQuery(this).parents(".iframe-play").toggleClass("open").find("iframe")[0].src += "&autoplay=1", e.preventDefault()
            }), jQuery(".listing-location").length > 0) {
            /* var e = jQuery(".listing-location"),
                t = jQuery(".listing-location li");
            t.length > 3 && (e.parent().append('<a href="#" class="view-all button primary alignright">View All</a>'), t.slice(3).css({
                display: "none"
            }), e.parent().on("click", ".view-all", function() {
                return jQuery(this).text("View All" == jQuery(this).text().trim() ? "View Less" : "View All"), t.slice(3).slideToggle("slow"), !1
            })) */
        }
        if (jQuery(".listing-location-sidebar").length > 0) {
            var r = jQuery(".listing-location-sidebar"),
                i = jQuery(".listing-location-sidebar li");
            i.length > 5 && (r.parent().append('<a href="#" class="view-all button primary alignright">View All</a>'), i.slice(5).css({
                display: "none"
            }), r.parent().on("click", ".view-all", function() {
                return jQuery(this).text("View All" == jQuery(this).text().trim() ? "View Less" : "View All"), i.slice(5).slideToggle("slow"), !1
            }))
        }
    }), jQuery(window).width() >= 500 && jQuery(window).width() <= 991 && jQuery(window).load(function() {
        jQuery(".hero").each(function() {
            jQuery(this).children(".hero .hero-item").matchHeight({
                byRow: !0
            })
        })
    }), jQuery(window).load(function() {
        jQuery(".blog-list").each(function() {
            jQuery(this).children(".blog-list .post,.blog-list .news").matchHeight({
                byRow: !0
            })
        }), jQuery(".blog-col2").each(function() {
            jQuery(this).children(".blog-col2 .post,.blog-col2 .news").matchHeight({
                byRow: !0
            })
        }), jQuery(window).width() >= 481 && jQuery(".equal-height").each(function() {
            jQuery(this).children(".post").matchHeight({
                byRow: !0
            }), jQuery(this).children(".item").matchHeight({
                byRow: !0
            })
        }), jQuery(".slick-slider > div").length > 1 && jQuery(".slick-slider").slick({
            infinite: !0,
            dots: !0,
            autoplay: !0,
            autoplaySpeed: 4e3,
            adaptiveHeight: !0,
            speed: 700,
            arrows: !1,
            draggable: !1
        }), jQuery(".slider-with-arrow > div").length > 1 && jQuery(".slider-with-arrow").slick({
            infinite: !0,
            dots: !0,
            autoplay: !0,
            autoplaySpeed: 4e3,
            adaptiveHeight: !1,
            speed: 700,
            arrows: !0,
            draggable: !1
        }), jQuery(".banner-slides > div").length > 1 && jQuery(".banner-slides").slick({
            fade: !0,
            dots: !1,
            speed: 1e3,
            prevArrow: '<button type="button" data-role="none" class="slick-prev slick-arrow" aria-label="Next" role="button" style="display: block;">&nbsp;</button>',
            nextArrow: '<button type="button" data-role="none" class="slick-next slick-arrow" aria-label="Next" role="button" style="display: block;">&nbsp;</button>'
        }), jQuery(window).width() > 992 && jQuery(window).width() < 1100 && jQuery(".services-list .column").matchHeight({
            byRow: !0
        })
    }), jQuery.urlParam = function(e) {
        var t = new RegExp("[?&]" + e + "=([^&#]*)").exec(window.location.href);
        return null != t ? t[1] : 0
    }, jQuery("#gform_wrapper_11").length > 0) {
    var step = jQuery.urlParam("step") ? jQuery.urlParam("step") : "";
    "" != step && jQuery("#gform_11").trigger("submit")
}
jQuery(".page-template-template-sst-dropoff").length > 0 && jQuery(".dropoff-zip-search").on("submit", function() {
    var e = jQuery(".dropoff-search-results");
    return jQuery("input,button").attr("disabled", "disabled"), jQuery.ajax({
        type: "post",
        dataType: "json",
        url: sstAjax.ajaxurl,
        data: {
            action: "mok_dropoff_loc_by_zip",
            zip: jQuery("input[name=dropoff-search-zip-code]").val(),
            range: jQuery("select[name=dropoff-search-range]").val(),
            secret: sstAjax.secret_sst
        }
    }).done(function(t) {
        jQuery("input,button").removeAttr("disabled"), "error" == t.message ? e.html("<p>Couldn't find anything for entered zip code.</p>") : e.html(t)
    }).fail(function() {
        jQuery("input,button").removeAttr("disabled"), e.html("<p>Something when terribly wrong :(</p>")
    }), !1
}), jQuery(".woocommerce-page").on("click", ".quantity span", function() {
    var e = jQuery(this),
        t = e.parent().find(".input-text.qty").val(),
        r = t;
    r = e.hasClass("increase") ? parseFloat(t) + 1 : t > 0 ? parseFloat(t) - 1 : 0, e.parent().find(".input-text.qty").val(r), jQuery("input.qty").trigger("change")
}), jQuery(".woocommerce-cart").on("click", ".quantity span", function() {
    jQuery(".woocommerce-cart").find("input[name=update_cart]").trigger("click")
});