(function($) {

    'use strict';

    $(function() {

        $('form#location-type-form').submit(function(e) {

            e.preventDefault();

            // preparing data for form posting
            var data = {
                'action': 'nearby_locations_crud',
                'callback': 'add_new_type',
                'name': $('#type-name').val(),
                'order': $('#type-order').val(),
            };

            // save the location type to the database
            $.ajax({
                url: myVars.ajaxUrl,
                type: 'post',
                data: data,
                cache: false,
                success: function(response) {
                    // reload the page - TEMPORARY
                    location.reload();
                },
                error: function(response) {
                    $('#message').html('Try again. Saving location was not successful.');
                }
            });

        });

        $('form#location-form').submit(function(e) {

            e.preventDefault();

            geocoder.geocode({ 'address': $('#address').val() }, function(results, status) {

                if (status == google.maps.GeocoderStatus.OK) {
                    // reposition map to the first returned location
                    map.setCenter(results[0].geometry.location);

                    // put marker on map
                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location
                    });

                    bindInfoWindow(marker, map, infowindow, results[0].formatted_address);

                    // preparing data for form posting
                    var data = {
                        'action': 'nearby_locations_crud',
                        'callback': 'add_new_location',
                        'section_id': $('#type option:selected').val(),
                        'lat': results[0].geometry.location.lat(),
                        'lng': results[0].geometry.location.lng(),
                        'location_name': $('#name').val(),
                        'formatted_name': results[0].formatted_address
                    };

                    // save the location to the database
                    $.ajax({
                        url: myVars.ajaxUrl,
                        type: 'post',
                        data: data,
                        cache: false,
                        success: function(response) {
                            // reload the page
                            location.reload();
                        },
                        error: function(response) {
                            $('#message').html('Try again. Saving location was not successful.');
                        }
                    });

                } else {
                    $('#message').html('Try again. Geocode was not successful for the following reason: ' + status);
                }
            });
        });
    });

})(jQuery);