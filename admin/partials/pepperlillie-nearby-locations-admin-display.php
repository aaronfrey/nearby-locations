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

<div id="realAddress"></div>

<div id="map-canvas" class="map"></div>