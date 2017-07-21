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
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<h1>Add locations to display on the map.</h1>

<div id="message"></div>

<form id="location-form">

	<label>
		Location Name
		<input class="regular-text" type="text" name="name" id="name" required>
	</label>

	<label>
		Location Address
		<input class="regular-text" type="text" name="address" id="address" required>
	</label>

	<button class="button button-primary" type="submit">Add Location</button>

</form>

<br>

<div class="pl-nearby-locations-container">

  <div class="accordion-container">
    <a href="#" class="toggle-all">ALL</a>
    <div class="accordion">
      <h3>Section 1</h3>
      <div>
        <ul>
          <li><a href="#">Location 1</a></li>
          <li><a href="#">Location 2</a></li>
          <li><a href="#">Location 3</a></li>
        </ul>
      </div>
      <h3>Section 2</h3>
      <div>
        <ul>
          <li><a href="#">Location 1</a></li>
          <li><a href="#">Location 2</a></li>
          <li><a href="#">Location 3</a></li>
          <li><a href="#">Location 4</a></li>
          <li><a href="#">Location 5</a></li>
          <li><a href="#">Location 6</a></li>
        </ul>
      </div>
      <h3>Section 3</h3>
      <div>
        <ul>
          <li><a href="#">Location 1</a></li>
          <li><a href="#">Location 2</a></li>
          <li><a href="#">Location 3</a></li>
        </ul>
      </div>
      <h3>Section 4</h3>
      <div>
        <ul>
          <li><a href="#">Location 1</a></li>
          <li><a href="#">Location 2</a></li>
          <li><a href="#">Location 3</a></li>
        </ul>
      </div>
    </div>
  </div>

  <div id="map-canvas" class="map"></div>

</div>