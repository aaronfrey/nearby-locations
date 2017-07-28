<?php

/**
 * @link       http://www.pepperlillie.com/
 * @since      1.0.0
 *
 * @package    Pepperlillie_Nearby_Locations
 * @subpackage Pepperlillie_Nearby_Locations/admin/partials
 */

$api_key = get_option("plnl-google-api-key");
$center_address = get_option("plnl-center-address");

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<h1>Settings</h1>

<div id="message"></div>

<br>

<form id="settings-form">

	<div class="form-control">
		<label for="api-key">Google Maps API Key</label>
		<input
			class="regular-text"
			type="text"
			name="api-key"
			id="api-key"
			value="<?php echo $api_key ? $api_key : ''; ?>"
			required>
	</div>

	<div class="form-control">
		<label for="center-address">Center Address</label>
		<input
			class="regular-text"
			type="text"
			name="center-address"
			id="center-address">
	</div>

	<div class="form-control">
		<label for="center-address">Formatted Address</label>
		<textarea class="regular-text" id="formatted-center-address" disabled><?php echo $center_address ? $center_address : ''; ?></textarea>
	</div>

	<button class="button button-primary" type="submit">Save Settings</button>

</form>