<?php

/**
 * The plugin bootstrap file
 *
 * @link              https://github.com/DevNiko/aps-content-moderator-plugin
 * @since             1.0.0
 * @package        APS_Content_Moderator
 *
 * @wordpress-plugin
 * Plugin Name:           APS Content Moderator Plugin for Wordpress
 * Plugin URI:              https://github.com/DevNiko/aps-content-moderator-plugin
 * Description:             APS Content Moderator API Plugin for Wordpress.
 * Version:                   1.0.0
 * Author:                    DevNiko
 * Author URI:              https://github.com/DevNiko/aps-content-moderator-plugin
 * License:                   GPL-2.0+
 * License URI:             http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:            aps-content-moderator
 * Domain Path:           /languages/
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 */
define('APS_CONTENT_MODERATOR_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-aps-content-moderator-activator.php
 */
function activate_aps_content_moderator()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-aps-content-moderator-activator.php';
    APS_Content_Moderator_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-aps-content-moderator-deactivator.php
 */
function deactivate_aps_content_moderator()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-aps-content-moderator-deactivator.php';
    APS_Content_Moderator_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_aps_content_moderator');
register_deactivation_hook(__FILE__, 'deactivate_aps_content_moderator');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-aps-content-moderator.php';

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
function run_aps_content_moderator()
{

    $plugin = new APS_Content_Moderator();
    $plugin->run();

}

run_aps_content_moderator();
