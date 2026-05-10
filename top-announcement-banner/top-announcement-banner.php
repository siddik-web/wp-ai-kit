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

/** @psalm-suppress UndefinedConstant */
define('TAB_VERSION', '1.0.0');
/** @psalm-suppress UndefinedConstant */
define('TAB_PLUGIN_FILE', __FILE__);
/** @psalm-suppress UndefinedConstant */
define('TAB_PLUGIN_DIR', plugin_dir_path(__FILE__));
/** @psalm-suppress UndefinedConstant */
define('TAB_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once TAB_PLUGIN_DIR . 'includes/class-top-announcement-banner.php';

register_activation_hook(__FILE__, 'tab_activate');
register_deactivation_hook(__FILE__, 'tab_deactivate');

function tab_activate(): void {
    $defaults = array(
        'enabled' => 0,
        'message' => __('Limited time offer: save 25% on your next purchase!', 'top-announcement-banner'),
        'button_text' => __('Shop Now', 'top-announcement-banner'),
        'button_url' => '',
        'background_color' => '#d95459',
        'text_color' => '#ffffff',
        'dismissible' => 1,
    );
    add_option('top_announcement_banner', $defaults);
}

function tab_deactivate(): void {
    // Cleanup if needed.
}

function tab_initialize_plugin(): void {
    Top_Announcement_Banner::get_instance();
}

add_action('plugins_loaded', 'tab_initialize_plugin', 10, 0);
