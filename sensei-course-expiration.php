<?php
/**
 * Plugin Name: Sensei Course Exipration
 * Description: Removes students from courses and lessons after a year so that course must be repurchased.
 * Version: 1.0
 * Author: Bob, O'Brien, Digital Eel Inc.
 * Author URI:http://digitaleel.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option('active_plugins') ) ) ){

  require_once plugin_dir_path(__FILE__) . 'includes/class-sensei-course-expiration.php';

  add_action( 'plugins_loaded', 'sce_plugin_startup_settings' );
  /**
   * Starts the plugin.
   *
   * @since 1.0.0
   */
  function sce_plugin_startup_settings() {

      $sensei_course_expiration = new Sensei_Course_Expiration();

  }

}



