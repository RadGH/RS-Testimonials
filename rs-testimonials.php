<?php
/*
 * Plugin Name: RS Testimonials
 * Plugin URI: http://radleysustaire.com/
 * Description: Display testimonials on your site and optionally allow visitors to write testimonials.
 * Version: 1.0.0
 * Author: Radley Sustaire
 * Author URI: http://radleysustaire.com/
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * Domain Path: /languages
 * Text Domain: rs-ssi
 *
 * Requires at least: 3.8
 * Tested up to: 4.8
 */

if ( !defined( 'ABSPATH' ) ) exit; // Do not allow direct access

/**
 * Main plugin class for the Expert City Memberships plugin.
 * @class EC_Memberships
 */
if ( !class_exists( 'EC_Memberships' ) ) {
	class EC_Memberships
	{
		// Plugin settings
		public $version = '1.0.0';
		public $plugin_dir = null;
		public $plugin_url = null;
		public $plugin_basename = null;
		
		/**
		 * EC_Memberships constructor
		 */
		public function __construct() {
			$this->plugin_dir = untrailingslashit( plugin_dir_path( __FILE__ ) );
			$this->plugin_url = plugins_url( '', __FILE__ );
			$this->plugin_basename = plugin_basename( __FILE__ );
			
			// Finish setting up the plugin once other plugins have loaded, for compatibility.
			add_action( 'plugins_loaded', array( &$this, 'setup_plugin' ), 20 );
		}
		
		/**
		 * Initializes the rest of our plugin
		 */
		public function setup_plugin() {
			include( $this->plugin_dir . '/includes/expert-category.php' );
			include( $this->plugin_dir . '/includes/prelaunch.php' );
			include( $this->plugin_dir . '/includes/thankyou.php' );
			include( $this->plugin_dir . '/includes/membership-introduction.php' );
			include( $this->plugin_dir . '/includes/general.php' );
		}
	}
}

// Create our plugin object, accessible via the global variable $rs_ssi.
global $ec_memberships;
$ec_memberships = new EC_Memberships();