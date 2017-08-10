<?php

/**
 * @link       http://www.pepperlillie.com/
 * @since      1.0.0
 *
 * @package    Pepperlillie_Nearby_Locations
 * @subpackage Pepperlillie_Nearby_Locations/shared/partials
 */

// Get all of the location types
global $wpdb;
$table_name = $wpdb->prefix . "plnl_sections"; 
$join_table_name = $wpdb->prefix . "plnl_locations"; 
$locations = $wpdb->get_results("
  SELECT `locations`.*, `sections`.name `section_name`
  FROM $join_table_name `locations`
  LEFT JOIN $table_name `sections` ON `sections`.id = `locations`.section_id
  ORDER BY `sections`.`order` ASC, `locations`.name
", OBJECT);

echo '<pre>';
//var_dump($locations);
echo '</pre>';

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="pl-nearby-locations-container">

  <div class="accordion-container">

    <?php if ($locations) : ?>

      <a href="#" id="toggle-all" class="toggle-all">ALL</a>

      <div class="accordion">

        <?php

        $current_location_type = null;

        foreach ($locations as $idx => $location) :

          if ($location->section_id !== "-99") :

            if ($location->section_id !== $current_location_type) :

              if ($current_location_type) : ?>
                </ul></div>
              <?php endif;

              $current_location_type = $location->section_id; ?>

              <h3 data-section-id="<?php echo esc_attr($location->section_id); ?>">
                <?php echo esc_html($location->section_name); ?>
              </h3>
              <div>
                <ul>

            <?php endif; ?>

            <li>
              <a href="#" class="location-link" data-location-index="<?php echo esc_attr($idx); ?>">
                <?php echo esc_html($location->name); ?>
              </a>
            </li>

          <?php endif ;?>

        <?php endforeach; ?>

        <?php if ($current_location_type) : ?>
        </ul></div>
        <?php endif; ?>

      </div><!-- .accordion -->

    <?php endif; ?>

  </div><!-- .accordion-container -->

  <div id="map-canvas" class="map"></div>

</div><!-- .pl-nearby-locations-container -->