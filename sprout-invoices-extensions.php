<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://profiles.wordpress.org/mbezuidenhout/
 * @since             1.0.0
 * @package           Sprout_Invoices_Extensions
 *
 * @wordpress-plugin
 * Plugin Name:       Extensions for Sprout Invoices
 * Plugin URI:        https://github.com/mbezuidenhout/
 * Description:       Extra functionality to the sprout invoicing system.
 * Version:           1.0.0
 * Author:            Marius Bezuidenhout
 * Author URI:        https://profiles.wordpress.org/mbezuidenhout/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sprout-invoices-extensions
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SPROUT_INVOICES_EXTENSIONS_VERSION', '1.0.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sprout-invoices-extensions-activator.php
 */
function activate_sprout_invoices_extensions() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sprout-invoices-extensions-activator.php';
	Sprout_Invoices_Extensions_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sprout-invoices-extensions-deactivator.php
 */
function deactivate_sprout_invoices_extensions() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sprout-invoices-extensions-deactivator.php';
	Sprout_Invoices_Extensions_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_sprout_invoices_extensions' );
register_deactivation_hook( __FILE__, 'deactivate_sprout_invoices_extensions' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sprout-invoices-extensions.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sprout_invoices_extensions() {

	$plugin = new Sprout_Invoices_Extensions();
	$plugin->run();

}
run_sprout_invoices_extensions();
