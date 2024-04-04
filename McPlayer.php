<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://jerl92.tk
 * @since             0.1
 * @package           McPlayer
 *
 * @wordpress-plugin
 * Plugin Name:       McPlayer
 * Plugin URI:        https://mcplayer.jerl92.tk
 * Description:       MCPlayer, A full-width audio player with playlist build with HTML5/JS/AJAX, Plugin for Wordpress.
 * Version:           1.7
 * Author:            Jerl92
 * Author URI:        https://jerl92.tk
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       McPlayer
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-McPlayer-activator.php
 */
function activate_McPlayer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-McPlayer-activator.php';
	Mcplayer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-McPlayer-deactivator.php
 */
function deactivate_McPlayer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-McPlayer-deactivator.php';
	Mcplayer_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_McPlayer' );
register_deactivation_hook( __FILE__, 'deactivate_McPlayer' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-McPlayer.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_McPlayer() {

	$plugin = new Mcplayer();
	$plugin->run();

}
run_McPlayer();
