<?php

/**
 * Antenna Digital Google Analytics Plugin
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * this starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           AD_Google_Analytics
 *
 * @wordpress-plugin
 * Plugin Name:       Antenna Digital Google Analytics
 * Plugin URI:        https://www.antennagroup.com/
 * Description:       Antenna Digital stand-alone Google Analytics Plugin that works with Google Site Kit
 * Version:           1.0.0
 * Author:            https://www.antennagroup.com/
 * Author URI:        https://www.antennagroup.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ad-google-analytics
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

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
