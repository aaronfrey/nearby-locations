<?php

/**
 * @link       http://www.aaronjfrey.com/
 * @since      1.0.0
 *
 * @package    Nearby_Locations
 * @subpackage Nearby_Locations/admin/partials
 */

$api_key = get_option("ajf-nl-google-api-key");
$center_address = get_option("ajf-nl-center-address");

?>

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
			value="<?php echo $api_key ? esc_attr($api_key) : ''; ?>"
			required>
	</div>

	<?php if ($api_key && !$center_address) : ?>
	<div class="form-control">
		<label for="center-address">Featured Address</label>
		<input
			class="regular-text"
			type="text"
			name="center-address"
			id="center-address"
			<?php echo !$api_key ? 'disabled' : ''; ?>>
	</div>
	<div class="indented">Enter an address that will be the focal point of the map.</div>
	<?php endif; ?>

	<?php if ($center_address) : ?>
	<div class="form-control">
		<label for="center-address">Featured Address</label>
		<textarea
			class="regular-text"
			id="formatted-center-address"
			disabled><?php echo esc_textarea($center_address['address']); ?>
		</textarea>
		<br>
		<button class="button button-primary indented" id="remove-location">Remove</button>
	</div>
	<?php endif; ?>

	<button class="button button-primary submit-button indented" type="button">Save Settings</button>

</form>