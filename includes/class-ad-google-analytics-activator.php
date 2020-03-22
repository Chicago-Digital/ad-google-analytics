<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    AD_Google_Analytics
 * @subpackage AD_Google_Analytics/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    AD_Google_Analytics
 * @subpackage AD_Google_Analytics/includes
 * @author     Your Name <email@example.com>
 */
class AD_Google_Analytics_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		if (!get_option('ad_ga_settings')) {
			$options = array(
				"ad_google_site_kit" => "1",
				"ad_google_site_kit_dashboard" => "1",
			);
			add_option( 'ad_ga_settings' , $options);
		}
	}
	
}
