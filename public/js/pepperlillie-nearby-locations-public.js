(function($) {

    'use strict';

    $(function() {
        $('.accordion').accordion({
            heightStyle: 'content'
        });
        initMap();
    });

    function initMap() {
        var uluru = { lat: -25.363, lng: 131.044 };
        var map = new google.maps.Map(document.getElementById('map-canvas'), {
            zoom: 4,
            center: uluru
        });
        var marker = new google.maps.Marker({
            position: uluru,
            map: map
        });
    }

})(jQuery);