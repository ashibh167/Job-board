<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://ashibh.com
 * @since             1.0.0
 * @package           Job_Board
 *
 * @wordpress-plugin
 * Plugin Name:       Job Board
 * Plugin URI:        https://ashi.com
 * Description:       This plugin makes it easier to find jobs
 * Version:           1.0.0
 * Author:            Ashi
 * Author URI:        https://ashibh.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       job-board
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
if(! defined("plugin_code_plugin_dir"))
    define("plugin_code_plugin_dir" , plugin_dir_path(__FILE__ ));
    if(! defined('plugin_code_plugin_url'))
   define ('plugin_code_plugin_url', plugins_url( ) .'/plugin-code');
     

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'JOB_BOARD_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-job-board-activator.php
 */
function activate_job_board() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-job-board-activator.php';
	Job_Board_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-job-board-deactivator.php
 */
function deactivate_job_board() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-job-board-deactivator.php';
	Job_Board_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_job_board' );
register_deactivation_hook( __FILE__, 'deactivate_job_board' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-job-board.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_job_board() {

	$plugin = new Job_Board();
	$plugin->run();

}
run_job_board();

