<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              jerl92.tk
 * @since             1.0.0
 * @package           Mcplayer
 *
 * @wordpress-plugin
 * Plugin Name:       mcplayer
 * Plugin URI:        mcplayer
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            jerl92
 * Author URI:        jerl92.tk
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mcplayer
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mcplayer-activator.php
 */
function activate_mcplayer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mcplayer-activator.php';
	Mcplayer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mcplayer-deactivator.php
 */
function deactivate_mcplayer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mcplayer-deactivator.php';
	Mcplayer_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mcplayer' );
register_deactivation_hook( __FILE__, 'deactivate_mcplayer' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mcplayer.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mcplayer() {

	$plugin = new Mcplayer();
	$plugin->run();

}
run_mcplayer();
