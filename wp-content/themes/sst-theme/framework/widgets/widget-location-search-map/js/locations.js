jQuery(".zip-detail-search").on('submit', function () {
    var results = jQuery(this).parent().find('.listing-location-zip');
    jQuery("input,button").attr('disabled', 'disabled');
    jQuery(".zip-form-loader").fadeIn('slow');
    jQuery.ajax({
        type: "post",
        dataType: "json",
        url: myAjax.ajaxurl,
        data: {
            action: "location_search_detail_zip",
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
            var map;
            var bounds = new google.maps.LatLngBounds();
            var mapOptions = {
                mapTypeId: 'roadmap'
            };

            // Display a map on the page
            map = new google.maps.Map(document.getElementById("map"), mapOptions);
            map.setTilt(45);
            var markers = [];
            var infoWindowContent = [];
            jQuery.each(response, function (index) {
                markers[index] = [
                    response[index].address,
                    response[index].lat,
                    response[index].lang
                ];
                var phone = response[index].phone != '' ? '<p>Phone: ' + response[index].phone + '</p>' : '';
                infoWindowContent[index] = [
                    '<p><strong>' + response[index].title + '</strong></p>' + phone + '<p>Address: ' + response[index].address + '</p><p><a href="' + response[index].link + '">More Details</a></p>'
                ];
            });
            console.log(markers);
            console.log(infoWindowContent);

            // Display multiple markers on a map
            var infoWindow = new google.maps.InfoWindow(), marker, i;

            // Loop through our array of markers & place each one on the map
            for (i = 0; i < markers.length; i++) {
                var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
                bounds.extend(position);
                marker = new google.maps.Marker({
                    position: position,
                    map: map,
                    title: markers[i][0]
                });

                // Allow each marker to have an info window
                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        infoWindow.setContent(infoWindowContent[i][0]);
                        infoWindow.open(map, marker);
                    }
                })(marker, i));

                // Automatically center the map fitting all markers on the screen
                map.fitBounds(bounds);
            }

            // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
            var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function (event) {
                var range = jQuery('select[name=search-range]').val();
                if (range == 25) {
                    this.setZoom(10);
                }
                else if (range == 100) {
                    this.setZoom(9);
                }
                else {
                    this.setZoom(8);
                }
                google.maps.event.removeListener(boundsListener);
            });
        }
        jQuery(".zip-form-loader").hide();
    }).fail(function () {
        jQuery("input,button").removeAttr('disabled');
        results.replaceWith('<p>Something when terribly wrong :(</p>');
        jQuery(".zip-form-loader").hide();
    });
    return false;
});

