<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 * @author     Your Name <email@example.com>
 */
class AD_Google_Analytics_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $name    The ID of this plugin.
	 */
	private $name;

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
	 * @var      string    $name       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $name, $version ) {

		$this->name = $name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in AD_Google_Analytics_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The AD_Google_Analytics_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->name, plugin_dir_url( __FILE__ ) . 'css/ad-google-analytics-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in AD_Google_Analytics_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The AD_Google_Analytics_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->name, plugin_dir_url( __FILE__ ) . 'js/ad-google-analytics-admin.js', array( 'jquery' ), $this->version, FALSE );

	}

		/**
	 * Callback function for the admin settings page.
	 *
	 * @since    1.0.0
	 */
	public function settings_page() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/ad-google-analytics-admin-display.php';
	}

	/**
	 * CD - Register the Settings page.
	 *
	 * @since    1.0.0
	 */
	public function admin_menu() {
		add_options_page( 'Google Analytics', 'Google Analytics', 'manage_options', $this->name, array( $this, 'settings_page' ) );
	}


	public function ad_ga_settings_init(  ) {

			// Settings - Register
	    register_setting( 'ad_google_analytics_settings', 'ad_ga_settings' );

			// Settings - Section
	    add_settings_section(
	        'ad_google_analytics_settings_section',
	        '',
	        array($this,'ad_ga_settings_section_callback'),
	        'ad_google_analytics_settings'
	    );

			// Settings - Fields
	    add_settings_field(
	        'ad_google_site_kit',
	        'Google Site Kit',
	        array($this,'ad_google_site_kit_render'),
	        'ad_google_analytics_settings',
	        'ad_google_analytics_settings_section'
	    );

			add_settings_field(
	        'ad_google_site_kit_dashboard',
	        'Dashboard',
	        array($this,'ad_google_site_kit_dashboard_render'),
	        'ad_google_analytics_settings',
	        'ad_google_analytics_settings_section'
	    );

	    add_settings_field(
	        'ad_tracking_code',
	        'Tracking Code',
	        array($this,'ad_tracking_code_render'),
	        'ad_google_analytics_settings',
	        'ad_google_analytics_settings_section'
	    );

			add_settings_field(
	        'ad_exclude_users',
	        'Exclude Users',
	        array($this,'ad_exclude_users_render'),
	        'ad_google_analytics_settings',
	        'ad_google_analytics_settings_section'
	    );

			add_settings_field(
	        'ad_enable_tracking',
	        'Tracking',
	        array($this,'ad_enable_tracking_render'),
	        'ad_google_analytics_settings',
	        'ad_google_analytics_settings_section'
	    );

			add_settings_field(
	        'ad_downloads_regex',
	        'Downloads Regex',
	        array($this,'ad_downloads_regex_render'),
	        'ad_google_analytics_settings',
	        'ad_google_analytics_settings_section'
	    );
	}

	function ad_google_site_kit_render(  ) {
	    $options = get_option( 'ad_ga_settings' );
	    ?>
			<label for="ad_ga_settings[ad_google_site_kit]"><input id="ad_ga_settings[ad_google_site_kit]" type="checkbox" name="ad_ga_settings[ad_google_site_kit]" value="1" <?php echo checked( 1, $options['ad_google_site_kit'], false ); ?>>Enable Works With Google Site Kit</label>
			<p class="description">Add Google Analytics code with Site Kit and other enhancements</p>
	    <?php
	}

	function ad_google_site_kit_dashboard_render(  ) {
	    $options = get_option( 'ad_ga_settings' );
	    ?>
			<label for="ad_ga_settings[ad_google_site_kit_dashboard]"><input id="ad_ga_settings[ad_google_site_kit_dashboard]" type="checkbox" name="ad_ga_settings[ad_google_site_kit_dashboard]" value="1" <?php echo checked( 1, $options['ad_google_site_kit_dashboard'], false ); ?>>Enable Google Site Kit Dashboard</label>
			<p class="description">Make Google Site Kit Dashboard default dashboard for WordPress Admin.</p>
	    <?php
	}

	function ad_tracking_code_render(  ) {
	    $options = get_option( 'ad_ga_settings' );
	    ?>
			<textarea name="ad_ga_settings[ad_tracking_code]" type="textarea" rows="12" class="regular-text"><?php if (isset($options['ad_tracking_code'])) : ?><?php echo $options['ad_tracking_code']; ?><?php endif; ?></textarea>
			<?php
	}

	function ad_exclude_users_render(  ) {
	    $options = get_option( 'ad_ga_settings' );
			$roles = wp_roles();
			$role_names = array();

			foreach ($roles->roles as $role => $info) {
				?>
				<label for="ad_ga_settings[ad_exclude_users][<?php echo $role; ?>]"><input id="ad_ga_settings[ad_exclude_users][<?php echo $role; ?>]" type="checkbox" name="ad_ga_settings[ad_exclude_users][]" value="<?php echo $role; ?>" <?php checked( in_array( $role, $options['ad_exclude_users'] ), 1 ); ?>><?php echo $info['name']; ?></label><br />
				<?php
			}
	    ?>
			<p class="description">Exclude users from tracking when logged in.</p>
			<?php
	}

	function ad_enable_tracking_render(  ) {
	    $options = get_option( 'ad_ga_settings' );
	    ?>
			<label for="ad_ga_settings[ad_enable_tracking]"><input id="ad_ga_settings[ad_enable_tracking]" type="checkbox" name="ad_ga_settings[ad_enable_tracking]" value="1" <?php echo checked( 1, $options['ad_enable_tracking'], false ); ?>>Enable Tracking</label>
			<p class="description">Enable Track downloads, mailto, telephone and outbound links</p>
			<?php
	}

	function ad_downloads_regex_render(  ) {
	    $options = get_option( 'ad_ga_settings' );
	    ?>
			<label for="ad_ga_settings[ad_downloads_regex]">
			<input id="ad_ga_settings[ad_downloads_regex]" name="ad_ga_settings[ad_downloads_regex]" type="text" id="ad_ga_settings[ad_downloads_regex]" placeholder="zip|mp3*|mpe*g|pdf|docx*|pptx*|xlsx*|rar*" value="<?php if (!empty($options['ad_downloads_regex'])) : ?><?php echo $options['ad_downloads_regex']; ?><?php else : ?>zip|mp3*|mpe*g|pdf|docx*|pptx*|xlsx*|rar*<?php endif; ?>" class="regular-text">
			</label>
			<?php
	}

	function ad_ga_settings_section_callback() {
		// Nothing right now
	}


		/**
	 * Remove WP Dashboard and redirect to Google Site Kit Dashboard
	 *
	 * @since  1.0.0
	 */
	public function ad_remove_wp_dashboard(){
		$options = get_option( 'ad_ga_settings' );

		if (!is_plugin_active( 'google-site-kit/google-site-kit.php' ) || !isset($options['ad_google_site_kit_dashboard']) || !current_user_can( 'googlesitekit_view_dashboard' ) ) {
			return;
		}
		if ( preg_match( '#wp-admin/?(index.php)?$#', $_SERVER['REQUEST_URI'] ) && ( 'index.php' != $menu[$page][2] ) ) {
			wp_redirect( get_option( 'siteurl' ) . '/wp-admin/admin.php?page=googlesitekit-dashboard');
		}

	}

	/**
	 * On Login Redirect to Google Site Kit Dashboard
	 *
	 * @since  1.0.0
	 */
	public function ad_login_dashboard_redirect($url) {
		$options = get_option( 'ad_ga_settings' );

		if (is_plugin_active( 'google-site-kit/google-site-kit.php' ) && isset($options['ad_google_site_kit_dashboard']) && current_user_can( 'googlesitekit_view_dashboard' )) {
			$url = esc_url( admin_url( 'admin.php?page=googlesitekit-dashboard' ) );
		}
		return $url;
	}



}
