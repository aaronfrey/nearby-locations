(function($) {

    'use strict';

    var activeMarker = null,
        bounds,
        geocoder,
        infowindow,
        locations,
        map,
        markers = [],
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

    function initialize() {
        // create the geocoder
        geocoder = new google.maps.Geocoder();

        // create the infowindow
        infowindow = new google.maps.InfoWindow({
            content: ''
        });

        // add listener to stop marker animation on infobox close
        google.maps.event.addListener(infowindow, 'closeclick', function() {
            markers[activeMarker].setAnimation(null);
        });

        if ($('body').find('.pl-nearby-locations-container')) {

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

        $('#toggle-all').on('click', function(e) {
            e.preventDefault();
            toggleAll = true;
            $('.ui-accordion-header-active').click();
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
                if (!toggleAll && !ui.newHeader.size()) {
                    return false;
                }

                toggleAll = false;
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