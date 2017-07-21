<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.pepperlillie.com/
 * @since      1.0.0
 *
 * @package    Pepperlillie_Nearby_Locations
 * @subpackage Pepperlillie_Nearby_Locations/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Pepperlillie_Nearby_Locations
 * @subpackage Pepperlillie_Nearby_Locations/admin
 * @author     Aaron Frey <aaron.frey@gmail.com>
 */
class Pepperlillie_Nearby_Locations_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pepperlillie-nearby-locations-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		
		wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDMkqWm3kT5wOXT-400rN7sURd-sFIR2hI', array(), $this->version, false);

		wp_enqueue_script($this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pepperlillie-nearby-locations-admin.js', array( 'jquery' ), $this->version, false );

		wp_localize_script($this->plugin_name, 'myVars', array('ajaxUrl' => admin_url('admin-ajax.php')));
		
	}

	public function pepperlillie_nearby_locations_page() {
    add_menu_page(
      'Nearby Locations',
      'Locations',
      'manage_options',
      plugin_dir_path(__FILE__) . 'partials/pepperlillie-nearby-locations-admin-display.php',
      null,
      'dashicons-location'
    );
	}	

	public function pepperlillie_nearby_locations_process_ajax() {

	}
}