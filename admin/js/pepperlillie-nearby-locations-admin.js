(function($) {

    'use strict';

    var address,
        geocoder,
        infowindow,
        map,
        places;

    // fetch Places JSON from /data/places
    // loop through and populate the map with markers
    var fetchPlaces = function() {
        jQuery.ajax({
            url: '/data/places',
            dataType: 'json',
            success: function(response) {

                if (response.status == 'OK') {
                    places = response.places;
                    // loop through places and add markers
                    for (p in places) {
                        //create gmap latlng obj
                        tmpLatLng = new google.maps.LatLng(places[p].geo[0], places[p].geo[1]);
                        // make and place map maker.
                        var marker = new google.maps.Marker({
                            map: map,
                            position: tmpLatLng,
                            title: places[p].name + "<br>" + places[p].geo_name
                        });
                        bindInfoWindow(marker, map, infowindow, '<b>' + places[p].name + "</b><br>" + places[p].geo_name);
                        // not currently used but good to keep track of markers
                        markers.push(marker);
                    }
                }
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

        // set some default map details, initial center point, zoom and style
        var mapOptions = {
            center: new google.maps.LatLng(39.9523789, -75.1657883),
            zoom: 12,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        // create the map and reference the div#map-canvas container
        map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

        // fetch the existing places (ajax) and put them on the map
        //fetchPlaces();
    }

    // when page is ready, initialize the map!
    google.maps.event.addDomListener(window, 'load', initialize);

    $(function() {

        $('#addressSubmit').on('click', function(e) {

            e.preventDefault();

            address = $('#address').val();

            geocoder.geocode({ 'address': address }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    // reposition map to the first returned location
                    map.setCenter(results[0].geometry.location);

                    // put marker on map
                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location
                    });

                    //console.log(results[0]);

                    bindInfoWindow(marker, map, infowindow, results[0].formatted_address);
                }
            });
        });

    });

})(jQuery);