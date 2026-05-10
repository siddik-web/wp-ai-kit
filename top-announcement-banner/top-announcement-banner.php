<?php
/**
 * Plugin Name: Top Announcement Banner
 * Plugin URI: https://github.com/siddik-web/top-announcement-banner.php
 * Description: Show a campaign or offer announcement banner at the top of your WordPress site.
 * Version: 1.0.0
 * Requires at least: 6.0
 * Tested up to: 6.7
 * Requires PHP: 7.4
 * Author: Md Siddiqur Rahman
 * Author URI: https://siddiqur.com
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: top-announcement-banner
 * Domain Path: /languages
 */

if (! defined('ABSPATH')) {
    exit;
}

define('TAB_VERSION', '1.0.0');
define('TAB_PLUGIN_FILE', __FILE__);
define('TAB_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('TAB_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once TAB_PLUGIN_DIR . 'includes/class-top-announcement-banner.php';

register_activation_hook(__FILE__, 'tab_activate');
register_deactivation_hook(__FILE__, 'tab_deactivate');

function tab_activate() {
    // Seed the option so it exists immediately after activation.
    if (false === get_option('top_announcement_banner')) {
        add_option('top_announcement_banner', array());
    }
}

function tab_deactivate() {
    // Nothing to clean up on deactivation. Data is preserved so re-activation
    // restores previous settings. Permanent cleanup happens in uninstall.php.
}

function tab_initialize_plugin() {
    Top_Announcement_Banner::get_instance();
}
add_action('plugins_loaded', 'tab_initialize_plugin');
