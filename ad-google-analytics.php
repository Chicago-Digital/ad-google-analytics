<?php

/*
Plugin Name: Antenna Digital Google Analytics Plugin
Plugin URI: https://www.antennagroup.com
Version: 1.0.1
Author: Antenna | Digital
Author URI: https://wwww.antennagroup.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Private Plugin Update From GitHub
 */
include_once( plugin_dir_path( __FILE__ ) . 'updater.php' );
$updater = new AD_Google_Analytics_Updater( __FILE__ ); // Update to prefixed class name of plugin. Can't be the same as other plugin updaters
$updater->set_username('Chicago-Digital');
$updater->set_repository('ad-google-analytics'); // Repository should be same name as plugin
$updater->initialize();

/**
 * The code that runs during plugin activation.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-ad-google-analytics-activator.php';

/**
 * The code that runs during plugin deactivation.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-ad-google-analytics-deactivator.php';

/** This action is documented in includes/class-ad-google-analytics-activator.php */
register_activation_hook( __FILE__, array( 'AD_Google_Analytics_Activator', 'activate' ) );

/** This action is documented in includes/class-ad-google-analytics-deactivator.php */
register_activation_hook( __FILE__, array( 'AD_Google_Analytics_Deactivator', 'deactivate' ) );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-ad-google-analytics.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin_name() {

	$plugin = new AD_Google_Analytics();
	$plugin->run();

}
run_plugin_name();
