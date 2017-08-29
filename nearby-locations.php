<?php

/**
 * @link              http://www.aaronjfrey.com/
 * @since             1.0.0
 * @package           Nearby_Locations
 *
 * @wordpress-plugin
 * Plugin Name:       Nearby Locations
 * Description:       Add locations, grouped by categories, to a Google map.
 * Version:           1.0.0
 * Author:            Aaron Frey
 * Author URI:        http://www.aaronjfrey.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nearby-locations
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-nearby-locations-activator.php
 */
function activate_pepperlillie_nearby_locations() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nearby-locations-activator.php';
	Pepperlillie_Nearby_Locations_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-nearby-locations-deactivator.php
 */
function deactivate_pepperlillie_nearby_locations() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nearby-locations-deactivator.php';
	Pepperlillie_Nearby_Locations_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_pepperlillie_nearby_locations' );
register_deactivation_hook( __FILE__, 'deactivate_pepperlillie_nearby_locations' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-nearby-locations.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_pepperlillie_nearby_locations() {

	$plugin = new Pepperlillie_Nearby_Locations();
	$plugin->run();

}
run_pepperlillie_nearby_locations();
