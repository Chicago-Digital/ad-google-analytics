<?php

/**
 * Antenna Digital Google Analytics Dashboard Settings
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin/partials
 */
?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
  <h1 class="wp-heading-inline">Google Analytics Settings</h1>
  <hr class="wp-header-end">
  <form action='options.php' method='post'>
      <?php
      settings_fields( 'ad_google_analytics_settings' );
      do_settings_sections( 'ad_google_analytics_settings' );
      submit_button();
      ?>
  </form>
</div>
