jQuery(document).ready(function () {
    jQuery('#fluidHeightSections').fullpage({
        navigation: true,
        navigationPosition: 'right',
        navigationTooltips: ['Welcome'],
        responsiveWidth: 900,
        scrollingSpeed: 1000,
        afterResponsive: function (isResponsive) {
        }
    });

    jQuery('.tab-container').easyResponsiveTabs({
        width: 'auto',
        fit: true
    });

    jQuery('.results-section .tab-container').find('.thumbs-group.female').addClass('active').css({display: 'flex'});
    jQuery('.toggle-male').on('click', function (e) {
        jQuery(this).addClass('active').siblings('.toggle-female').removeClass('active');
        jQuery(this).closest('.tab-container').find('.thumbs-group.female').removeClass('active').css({display: 'none'});
        jQuery('.results-section .tab-container').find('.thumbs-group.male').addClass('active').css({display: 'flex'});
        e.preventDefault();
    });

    jQuery('.toggle-female').on('click', function (e) {
        jQuery(this).addClass('active').siblings('.toggle-male').removeClass('active');
        jQuery(this).closest('.tab-container').find('.thumbs-group.male').removeClass('active').css({display: 'none'});
        jQuery('.results-section .tab-container').find('.thumbs-group.female').addClass('active').css({display: 'flex'});
        e.preventDefault();
    });

    //carousel
    var fancyCarousel = jQuery('.fancy-carousel');
    fancyCarousel.slick({
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: true,
        centerMode: true,
        arrows: true
    });

    var video = jQuery('.video'),
        iFrame = jQuery("iframe");
    jQuery(".toggle-video").on("click", function (e) {
        e.preventDefault();
        jQuery(this).addClass("active").find("iframe")[0].src += "&autoplay=1";
    });

    fancyCarousel.on('beforeChange swipe', function (e) {
        e.preventDefault();
        iFrame.attr('src', iFrame.attr('src'));
        fancyCarousel.find(".toggle-video").removeClass("active");
    });

    fancyCarousel.find(".slick-dots button").on("click", function (e) {
        e.preventDefault();
        iFrame.attr('src', iFrame.attr('src'));
        fancyCarousel.find(".toggle-video").removeClass("active");
    });
});