jQuery(".zip-search").on('submit', function () {
    var results = jQuery(this).parent().find('.listing-location-zip');
    jQuery("input,button").attr('disabled', 'disabled');
    jQuery(".zip-form-loader").fadeIn('slow');
    jQuery.ajax({
        type: "post",
        dataType: "json",
        url: myAjax.ajaxurl,
        data: {
            action: "location_search_zip",
            zip: jQuery('input[name=search-zip-code]').val(),
            range: jQuery('select[name=search-range]').val(),
            secret: myAjax.secret_zip
        }
    }).done(function (response) {
        jQuery("input,button").removeAttr('disabled');
        if (response.message == "error") {
            results.html("<p>Couldn't find anything for entered zip code.</p>");
        }
        else {
            results.replaceWith(response);
        }
        jQuery(".zip-form-loader").hide();
    }).fail(function () {
        jQuery("input,button").removeAttr('disabled');
        results.replaceWith('<p>Something when terribly wrong :(</p>');
        jQuery(".zip-form-loader").hide();
    });
    return false;
});
