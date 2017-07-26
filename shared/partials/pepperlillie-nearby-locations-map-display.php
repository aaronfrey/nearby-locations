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
$location_types = $wpdb->get_results("SELECT * FROM $table_name ORDER BY `order` ASC", OBJECT);

$join_table_name = $wpdb->prefix . "plnl_locations"; 
$locations = $wpdb->get_results("
  SELECT `locations`.*, `sections`.name `section_name`
  FROM $table_name `sections`, $join_table_name `locations`
  WHERE `locations`.`section_id` = `sections`.`id`
  ORDER BY `sections`.`order` ASC, `locations`.name
", OBJECT);

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="pl-nearby-locations-container">

  <div class="accordion-container">

    <?php if ($locations) : ?>

      <a href="#" id="toggle-all" class="toggle-all">ALL</a>

      <div class="accordion">

        <?php

        $current_location_type = '';

        foreach ($locations as $idx => $location) :

          if ($location->section_id !== $current_location_type) : $current_location_type = $location->section_id; ?>

            <?php if ($idx !== 0) : ?>
              </ul></div>
            <?php endif; ?>

            <h3><?php echo $location->section_name; ?></h3>
            <div>
              <ul>
                <li>
                  <a href="#" class="location-link" data-location-index="<?php echo $idx; ?>">
                    <?php echo $location->name; ?>
                  </a>
                </li>

              <?php else : ?>
                <li>
                  <a href="#" class="location-link" data-location-index="<?php echo $idx; ?>">
                    <?php echo $location->name; ?>
                  </a>
                </li>
              <?php endif; ?>

        <?php endforeach; ?>

        </ul></div>

      </div><!-- .accordion -->

    <?php endif; ?>

  </div>

  <div id="map-canvas" class="map"></div>

</div>