<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.pepperlillie.com/
 * @since      1.0.0
 *
 * @package    Pepperlillie_Nearby_Locations
 * @subpackage Pepperlillie_Nearby_Locations/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Pepperlillie_Nearby_Locations
 * @subpackage Pepperlillie_Nearby_Locations/public
 * @author     Aaron Frey <aaron.frey@gmail.com>
 */
class Pepperlillie_Nearby_Locations_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( 'jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css', array(), $this->version, 'all' );

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pepperlillie-nearby-locations-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyDMkqWm3kT5wOXT-400rN7sURd-sFIR2hI', array(), $this->version, false);

		wp_enqueue_script('jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', array('jquery'), $this->version, false);

		wp_enqueue_script($this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pepperlillie-nearby-locations-public.js', array('jquery'), $this->version, false);

	}

	public function pepperlillie_nearby_locations_shortcodes_init() {
    function pepperlillie_nearby_locations_shortcode($atts = [], $content = null) {
	    ob_start();
	    include('partials/pepperlillie-nearby-locations-public-display.php');
	    return ob_get_clean();
    }
    add_shortcode('pepperlillie_nearby_locations', 'pepperlillie_nearby_locations_shortcode');
	}

}