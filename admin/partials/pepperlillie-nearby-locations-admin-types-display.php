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

<h1>Add Location Type</h1>

<form id="location-type-form">

	<div class="form-control">
		<label for="type-name">Location Type Name</label>
		<input class="regular-text" type="text" name="type-name" id="type-name" required>
	</div>

	<div class="form-control">
		<label for="type-order">Location Type Order</label>
		<input class="regular-text" type="text" name="type-order" id="type-order" required>
	</div>

	<button class="button button-primary" type="submit">Add Location Type</button>

</form>

<?php

// Get all of the location types
global $wpdb;
$table_name = $wpdb->prefix . "plnl_sections"; 
$results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY `order` ASC", OBJECT);

if ($results) : ?>
	
	<h2>Locations Types</h2>

	<table>

		<tr>
	    <th>Location Type</th>
	    <th>Order</th> 
	    <th>Actions</th>
	  </tr>

		<?php foreach ($results as $result) : ?>

		<tr>
			<td><?php echo $result->name; ?></td>
			<td><?php echo $result->order; ?></td>
			<td><a href="#">Remove</a></td>
		</tr>

		<?php endforeach; ?>

	</table>

<?php endif; ?>


