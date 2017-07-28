<?php

/**
 * @link       http://www.pepperlillie.com/
 * @since      1.0.0
 *
 * @package    Pepperlillie_Nearby_Locations
 * @subpackage Pepperlillie_Nearby_Locations/admin/partials
 */

$api_key = get_option("plnl-google-api-key");

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<h1>Settings</h1>

<div id="message"></div>

<form id="settings-form">

	<div class="form-control">
		<label for="name">Google Maps API Key</label>
		<input
			class="regular-text"
			type="text"
			name="api-key"
			id="api-key"
			value="<?php echo $api_key ? $api_key : ''; ?>"
			required>
	</div>

	<button class="button button-primary" type="submit">Save Settings</button>

</form>