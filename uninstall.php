<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @link       http://www.aaronjfrey.com/
 * @since      1.0.0
 *
 * @package    Nearby_Locations
 */

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
	exit;
}

global $wpdb;

// Delete the locations table
$table_name = $wpdb->prefix . "plnl_locations";
$wpdb->query("DROP TABLE IF EXISTS $table_name");

// Delete the sections table
$table_name = $wpdb->prefix . "plnl_sections";
$wpdb->query("DROP TABLE IF EXISTS $table_name");

// Delete Options
delete_option("plnl-google-api-key");
delete_option("plnl-center-address");