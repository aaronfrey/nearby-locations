<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.pepperlillie.com/
 * @since      1.0.0
 *
 * @package    Pepperlillie_Nearby_Locations
 * @subpackage Pepperlillie_Nearby_Locations/admin/partials
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

<h1>Add Location</h1>

<div id="message"></div>

<form id="location-form">

	<div class="form-control">
		<label for="name">Location Name</label>
		<input class="regular-text" type="text" name="name" id="name" required>
	</div>

	<div class="form-control">
		<label for="address">Location Address</label>
		<input class="regular-text" type="text" name="address" id="address" required>
	</div>

  <?php if ($location_types) : ?>
	<div class="form-control">
		<label for="type">Location Type</label>
		<select name="type" id="type" required>
      <?php foreach ($location_types as $type) : ?>
			<option value="<?php echo $type->id; ?>"><?php echo $type->name; ?></option>
      <?php endforeach; ?>
		</select>
	</div>
  <?php endif; ?>

	<button class="button button-primary" type="submit">Add Location</button>

</form>

<br>

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