(function($) {

    'use strict';

    var bounds,
        geocoder,
        infowindow,
        locations,
        markers = [],
        map;

    // get locations from the database
    // loop through and populate the map with location markers
    var fetchPlaces = function() {

        jQuery.ajax({
            url: myVars.ajaxUrl,
            dataType: 'json',
            type: 'post',
            data: {
                'action': 'nearby_locations_crud',
                'callback': 'get_locations'
            },
            cache: false,
            success: function(response) {
                bounds = new google.maps.LatLngBounds();
                locations = response;
                // loop through locations and add markers
                for (var l in locations) {
                    // make and place map maker.
                    var marker = new google.maps.Marker({
                        map: map,
                        position: new google.maps.LatLng(locations[l].lat, locations[l].lng),
                        title: locations[l].name + "<br>" + locations[l].geo_name
                    });
                    markers.push(marker);
                    bounds.extend(marker.getPosition());
                    bindInfoWindow(marker, map, infowindow, '<b>' + locations[l].name + "</b><br>" + locations[l].formatted);
                }
                map.fitBounds(bounds);
            }
        })
    };

    // binds a map marker and infoWindow together on click
    var bindInfoWindow = function(marker, map, infowindow, html) {
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.setContent(html);
            infowindow.open(map, marker);
        });
    }

    function initialize() {
        // create the geocoder
        geocoder = new google.maps.Geocoder();

        // create the infowindow
        infowindow = new google.maps.InfoWindow({
            content: ''
        });

        if ($('body').hasClass('plugins-nearby-locations-admin-partials-pepperlillie-nearby-locations-admin-display-php')) {

            // set some default map details, initial center point, zoom and style
            var mapOptions = {
                center: new google.maps.LatLng(39.9523789, -75.1657883),
                zoom: 12,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            // create the map and reference the div#map-canvas container
            map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

            // fetch the existing places (ajax) and put them on the map
            fetchPlaces();
        }
    }

    // when page is ready, initialize the map!
    google.maps.event.addDomListener(window, 'load', initialize);

    $(function() {

        $('.accordion').accordion({
            heightStyle: 'content'
        });

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
                    console.log(response);
                    // reload the page
                    location.reload();
                },
                error: function(response) {
                    console.log(response);
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
                            console.log(response);
                            // reload the page
                            location.reload();
                        },
                        error: function(response) {
                            $('#message').html('Try again. Saving location was not successful.');
                            console.log('error');
                        }
                    });

                } else {
                    $('#message').html('Try again. Geocode was not successful for the following reason: ' + status);
                }
            });
        });

        $('.location-link').on('click', function(e) {
            e.preventDefault();
            var index = $(this).data('location-index');
            google.maps.event.trigger(markers[index], 'click');
        });

    });

})(jQuery);