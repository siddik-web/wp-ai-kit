<?php

if (! defined('ABSPATH')) {
    define('ABSPATH', sys_get_temp_dir() . '/wordpress/');
}

if (! defined('TAB_PLUGIN_DIR')) {
    define('TAB_PLUGIN_DIR', dirname(__DIR__, 2) . '/top-announcement-banner/');
}

if (! defined('TAB_PLUGIN_URL')) {
    define('TAB_PLUGIN_URL', 'https://example.test/wp-content/plugins/top-announcement-banner/');
}

if (! defined('TAB_VERSION')) {
    define('TAB_VERSION', '1.0.0');
}

if (! function_exists('__')) {
    function __($text, $domain = 'default')
    {
        return $text;
    }
}

if (! function_exists('sanitize_textarea_field')) {
    function sanitize_textarea_field($value)
    {
        $sanitized = preg_replace('@<(script|style)\b[^>]*>.*?</\1>@is', '', (string) $value);
        $sanitized = preg_replace('/<[^>]+>/', '', (string) $sanitized);

        return trim((string) $sanitized);
    }
}

if (! function_exists('sanitize_text_field')) {
    function sanitize_text_field($value)
    {
        $sanitized = preg_replace('@<(script|style)\b[^>]*>.*?</\1>@is', '', (string) $value);
        $sanitized = preg_replace('/<[^>]+>/', '', (string) $sanitized);

        return trim((string) $sanitized);
    }
}

if (! function_exists('esc_url_raw')) {
    function esc_url_raw($url)
    {
        $url = trim((string) $url);

        if ('' === $url) {
            return '';
        }

        return filter_var($url, FILTER_VALIDATE_URL) ? $url : '';
    }
}

require_once TAB_PLUGIN_DIR . 'includes/class-top-announcement-banner.php';
