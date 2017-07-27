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
		wp_enqueue_style('jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css', array(), $this->version, 'all');

		wp_enqueue_style('shared', plugin_dir_url(dirname(__FILE__)) . 'shared/css/pepperlillie-nearby-locations-shared.css', array(), $this->version, 'all');

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/pepperlillie-nearby-locations-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDMkqWm3kT5wOXT-400rN7sURd-sFIR2hI', array(), $this->version, false);
		wp_enqueue_script('jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', array('jquery'), $this->version, false);

		wp_enqueue_script('shared', plugin_dir_url(dirname(__FILE__)) . 'shared/js/pepperlillie-nearby-locations-shared.js', array('jquery'), $this->version, false);
		wp_localize_script('shared', 'myVars', array('ajaxUrl' => admin_url('admin-ajax.php')));

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/pepperlillie-nearby-locations-admin.js', array('jquery'), $this->version, false);
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

		add_submenu_page(
			plugin_dir_path(__FILE__) . 'partials/pepperlillie-nearby-locations-admin-display.php',
			'Location Types',
			'Location Types',
			'manage_options',
			plugin_dir_path(__FILE__) . 'partials/pepperlillie-nearby-locations-admin-types-display.php'
		);

		add_submenu_page(
			plugin_dir_path(__FILE__) . 'partials/pepperlillie-nearby-locations-admin-display.php',
			'Settings',
			'Settings',
			'manage_options',
			plugin_dir_path(__FILE__) . 'partials/pepperlillie-nearby-locations-admin-settings-display.php'
		);

	}	

	public function pepperlillie_nearby_locations_process_ajax() {

		if (isset($_POST['callback'])) {
			if($_POST['callback'] === 'add_new_location') {
				$this->add_new_location();
			} elseif($_POST['callback'] === 'get_locations') {
				$this->get_locations();
			} elseif($_POST['callback'] === 'add_new_type') {
				$this->add_new_type();
			}
		}

		die();
	}

	private function add_new_type() {
    global $wpdb;
		$table_name = $wpdb->prefix . "plnl_sections"; 
    $wpdb->insert($table_name, array(
      'name' => $_POST['name'],
      'order' => $_POST['order'],
    ));
	}

  private function add_new_location() {
    global $wpdb;
		$table_name = $wpdb->prefix . "plnl_locations"; 
    $wpdb->insert($table_name, array(
    	'section_id' => $_POST['section_id'],
      'name' => $_POST['location_name'],
      'formatted' => $_POST['formatted_name'],
      'lat' => $_POST['lat'],
      'lng' => $_POST['lng'],
      'post_date' => date('Y-m-d H:i:s'),
    ));
  }

  private function get_locations() {
		global $wpdb;
		$table_name = $wpdb->prefix . "plnl_sections"; 
		$location_types = $wpdb->get_results("SELECT * FROM $table_name ORDER BY `order` ASC", OBJECT);

		$join_table_name = $wpdb->prefix . "plnl_locations"; 
		$locations = $wpdb->get_results("
		  SELECT `locations`.*, `sections`.name `section_name`
		  FROM $table_name `sections`, $join_table_name `locations`
		  WHERE `locations`.`section_id` = `sections`.`id`
		  ORDER BY `sections`.`order` ASC, `locations`.name
		", OBJECT);

		echo json_encode($locations);
  }

}