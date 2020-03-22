<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    AD_Google_Analytics
 * @subpackage AD_Google_Analytics/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    AD_Google_Analytics
 * @subpackage AD_Google_Analytics/public
 * @author     Your Name <email@example.com>
 */
class AD_Google_Analytics_Public {

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

	public $settings;

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
		$this->settings = get_option('ad_ga_settings');
		$this->settings = array(
			"event_tracking_enabled" => (isset($this->settings['ad_enable_tracking'])) ? boolval($this->settings['ad_enable_tracking']) : false,
			"google_site_kit_enabled" => (isset($this->settings['ad_google_site_kit'])) ? boolval($this->settings['ad_google_site_kit']) : false,
			"tracking_code" => (isset($this->settings['ad_tracking_code'])) ? $this->settings['ad_tracking_code'] : '',
			"downloads_regex" => (isset($this->settings['ad_downloads_regex'])) ? esc_js($this->settings['ad_downloads_regex']) : 'zip|mp3*|mpe*g|pdf|docx*|pptx*|xlsx*|rar*',
			"exclude_users" => (isset($this->settings['ad_exclude_users'])) ? $this->settings['ad_exclude_users'] : array()
		);

	}

	/**
	 * Get Root Domain Helper Function
	 *
	 * @since    1.0.0
	 */
	public function get_root_domain() {
		$url = site_url();
		$root = explode( '/', $url );
		preg_match( '/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', str_ireplace( 'www', '', isset( $root[2] ) ? $root[2] : $url ), $root );
		if ( isset( $root['domain'] ) ) {
			return $root['domain'];
		} else {
			return '';
		}
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in AD_Google_Analytics_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The AD_Google_Analytics_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if ($this->settings['event_tracking_enabled'] && ($this->settings['google_site_kit_enabled'] || $this->settings['tracking_code'])) {
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ad-google-analytics-public.js', array( 'jquery' ), $this->version, false );
			wp_script_add_data( $this->plugin_name, 'script_execution', 'async' );
			wp_localize_script( $this->plugin_name, 'aga_event_data', array(
					'options' => array(
						'event_downloads' => $this->settings['downloads_regex'],
						'root_domain' => $this->get_root_domain(),
					),
				)
			);
		}
	}

	/**
	 * Show Custom Tracking Code
	 *
	 * @since    1.0.0
	 */
	public function custom_ga_script() {
		// If google site kit is not enabled
		if (!$this->settings['google_site_kit_enabled']) {

			// Exclude Users Detect
			$show_custom_tracking = true;

			if (is_user_logged_in()) {
				$user = wp_get_current_user();
				$roles_to_hide = $this->settings["exclude_users"];
				foreach ($roles_to_hide as $role) {
					if (in_array($role, $user->roles)) {
						$show_custom_tracking = false;
						break;
					}
				}
			}

			// If not excluded logged in user show custom tracking code
			if ($show_custom_tracking) {
				echo "\n" . $this->settings['tracking_code'] . "\n";
			}

		}

	}

	/**
	 * If Google Site Kit Disabled or Excluded User Hide Google Site Kit gtag Script
	 *
	 * @since    1.0.0
	 */
	public function dequeue_google_gtag_script() {

		if (!$this->settings['google_site_kit_enabled']) {
			wp_dequeue_script( 'google_gtagjs' );
		}
		else if (is_user_logged_in()) {
			$user = wp_get_current_user();
			$roles_to_hide = $this->settings["exclude_users"];
			foreach ($roles_to_hide as $role) {
				if (in_array($role, $user->roles)) {
					wp_dequeue_script( 'google_gtagjs' );
					break;
				}
			}
		}

	}




}
