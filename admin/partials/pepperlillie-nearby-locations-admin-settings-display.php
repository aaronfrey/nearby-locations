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
			value="<?php echo $api_key ? $api_key : ''; ?>">
	</div>

	<?php if (!$center_address) : ?>
	<div class="form-control">
		<label for="center-address">Center Address</label>
		<input
			class="regular-text"
			type="text"
			name="center-address"
			id="center-address"
			<?php echo !$api_key ? 'disabled' : ''; ?>
			>
	</div>
	<?php endif; ?>

	<?php if ($center_address) : ?>
	<div class="form-control">
		<label for="center-address">Center Address</label>
		<textarea
			class="regular-text"
			id="formatted-center-address"
			disabled><?php echo $center_address['address']; ?>
		</textarea>
		<br>
		<button class="button button-primary indented" id="remove-location">Remove</button>
	</div>
	<?php endif; ?>

	<button class="button button-primary indented" type="submit">Save Settings</button>

</form>