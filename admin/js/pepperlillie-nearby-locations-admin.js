(function($) {

  'use strict';

  $(function() {

    $('#remove-location').on('click', function(e) {

      e.preventDefault();

      // preparing data for form posting
      var data = {
        'action': 'nearby_locations_crud',
        'callback': 'remove_center_location',
      };

      // save the location type to the database
      $.ajax({
        url: myVars.ajaxUrl,
        type: 'post',
        data: data,
        cache: false,
        success: function(response) {
          $('#message').html('Center Location removed.');
          location.reload();
        },
        error: function(response) {
          $('#message').html('Try again. Center Location was not removed.');
        }
      });

    });
  });
})(jQuery);