(function($) {

    'use strict';

    var activeMarker = null,
        bounds,
        geocoder,
        infowindow,
        locations,
        map,
        markerGroups = {},
        markers = [],
        sectionID,
        toggleAll = true;

    // return an array key based on value
    var arraySearch = function(array, value) {
        for (var i = 0; i < array.length; i++) {
            if (array[i] === value) return i;
        }
        return false;
    }

    // get locations from the database
    // loop through and populate the map with location markers
    var fetchPlaces = function(sectionID) {

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

                locations = response;

                // create a bounds to contain all markers on the map
                bounds = new google.maps.LatLngBounds();

                // loop through locations and add markers to map
                for (var l in locations) {

                    // make and place map maker
                    var marker = new google.maps.Marker({
                        map: map,
                        position: new google.maps.LatLng(locations[l].lat, locations[l].lng),
                        title: locations[l].name + "<br>" + locations[l].geo_name
                    });

                    if (!(locations[l].section_id in markerGroups)) {
                        markerGroups[locations[l].section_id] = [];
                    }

                    markerGroups[locations[l].section_id].push(marker);
                    markers.push(marker);

                    // add marker to the contained bounds
                    bounds.extend(marker.getPosition());

                    // bind click event to show the info box
                    bindInfoWindow(marker, map, infowindow, '<b>' + locations[l].name + "</b><br>" + locations[l].formatted);
                }

                // readjust the map to fit all the markers at once
                map.fitBounds(bounds);
            }
        })
    };

    // binds a map marker and infoWindow together on click
    var bindInfoWindow = function(marker, map, infowindow, html) {
        google.maps.event.addListener(marker, 'click', function() {
            // show the info window
            infowindow.setContent(html);
            infowindow.open(map, marker);
            // animate the selected marker
            //animateMarker(arraySearch(markers, marker));
        });
    }

    var animateMarker = function(index) {
        if (index !== activeMarker) {
            if (activeMarker !== null) {
                markers[activeMarker].setAnimation(null);
            }
            markers[index].setAnimation(google.maps.Animation.BOUNCE);
            activeMarker = index;
        }
    }

    // hides the markers from the map, but keeps them in the array.
    var hideMarkers = function() {
        for (var i = 0; i < markers.length; i++) {
            //console.log('Hide marker: ' + i);
            markers[i].setVisible(false);
        }
    }

    // showd the markers from the map
    var showMarkers = function(sectionID) {
        var newMarkers = sectionID ? markerGroups[sectionID] : markers,
            bounds = new google.maps.LatLngBounds();

        for (var i = 0; i < newMarkers.length; i++) {
            //console.log('Show marker: ' + i);
            // add marker to the contained bounds
            bounds.extend(newMarkers[i].getPosition());
            newMarkers[i].setVisible(true);
        }
        map.fitBounds(bounds);
    }

    function initialize() {
        // create the geocoder
        geocoder = new google.maps.Geocoder();

        // create the infowindow
        infowindow = new google.maps.InfoWindow({
            content: ''
        });

        // add listener to stop marker animation on infobox close
        // google.maps.event.addListener(infowindow, 'closeclick', function() {
        //     markers[activeMarker].setAnimation(null);
        // });

        if ($('.pl-nearby-locations-container').length) {

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

        $('form#settings-form').submit(function(e) {

            e.preventDefault();

            // get the center location
            var centerAddress = $('#center-address').val();

            if (centerAddress) {
                // format the address for saving
                geocoder.geocode({ 'address': centerAddress }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        centerAddress = results[0].formatted_address;
                        submitForm();
                    } else {
                        $('#message').html('Try again. Geocode was not successful for the following reason: ' + status);
                    }
                });
            } else {
                submitForm();
            }

            function submitForm() {
                // preparing data for form posting
                var data = {
                    'action': 'nearby_locations_crud',
                    'callback': 'save_settings',
                    'api-key': $('#api-key').val(),
                    'center-address': centerAddress,
                };

                // save the location type to the database
                $.ajax({
                    url: myVars.ajaxUrl,
                    type: 'post',
                    data: data,
                    cache: false,
                    success: function(response) {
                        $('#message').html('Settings saved.');
                        $('#center-address').val('');
                        $('#formatted-center-address').val(centerAddress);
                    },
                    error: function(response) {
                        $('#message').html('Try again. Settings were not saved.');
                    }
                });
            }
        });

        $('form#location-type-form').submit(function(e) {

            e.preventDefault();

            // preparing data for form posting
            var data = {
                'action': 'nearby_locations_crud',
                'callback': 'add_new_type',
                'id': $('#type-id').val(),
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
                    var queryParameters = {},
                        queryString = location.search.substring(1),
                        re = /([^&=]+)=([^&]*)/g,
                        m;

                    // Creates a map with the query string parameters
                    while (m = re.exec(queryString)) {
                        queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
                    }

                    if (data.id !== '') {
                        // Add new parameters or update existing ones
                        queryParameters['action'] = '';
                        queryParameters['location_type'] = '';
                    }

                    location.search = $.param(queryParameters); // Causes page to reload
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

        $('#toggle-all').on('click', function(e) {
            e.preventDefault();
            toggleAll = true;
            $('.ui-accordion-header-active').click();
            showMarkers();
        });

        // initialize the location types accordion 
        $('.accordion').accordion({
            active: false,
            collapsible: true,
            heightStyle: 'content',
            icons: {
                "header": "ui-icon-triangle-1-s",
                "activeHeader": "ui-icon-triangle-1-n"
            },
            beforeActivate: function(event, ui) {
                // prevent current opened accordion from closing on click unless 'all' is clicked
                if (!toggleAll && !ui.newHeader.size()) {
                    return false;
                }
                toggleAll = false;

                // clear all markers
                hideMarkers();
                infowindow.close();

                // return only the locations for the current section id
                sectionID = ui.newHeader.data('section-id');
                showMarkers(sectionID);
            }
        });

        $('.location-link').on('click', function(e) {
            e.preventDefault();
            var index = $(this).data('location-index');
            google.maps.event.trigger(markers[index], 'click');
            //animateMarker(index);
        });
    });

})(jQuery);