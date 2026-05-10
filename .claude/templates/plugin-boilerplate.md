# Plugin Boilerplate Template

This template generates a complete WordPress plugin with best practices.

## Generated Structure

```
my-plugin/
├── my-plugin.php          # Main plugin file
├── includes/
│   ├── class-my-plugin.php # Main plugin class
│   ├── class-admin.php     # Admin functionality
│   └── class-public.php    # Public functionality
├── assets/
│   ├── css/
│   │   ├── admin.css
│   │   └── public.css
│   ├── js/
│   │   ├── admin.js
│   │   └── public.js
│   └── images/
├── templates/
├── languages/
│   └── my-plugin.pot
├── tests/
│   ├── bootstrap.php
│   ├── test-unit.php
│   └── test-integration.php
├── README.md
├── composer.json
├── package.json
├── phpcs.xml
└── phpunit.xml
```

## Main Plugin File (my-plugin.php)

```php
<?php

/**
 * Plugin Name: My Plugin
 * Plugin URI: https://example.com/my-plugin
 * Description: A comprehensive WordPress plugin with best practices.
 * Version: 1.0.0
 * Author: Md Siddiqur Rahman
 * License: GPL v2 or later
 * Text Domain: my-plugin
 * Requires at least: 5.0
 * Tested up to: 6.4
 * Requires PHP: 7.4
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define constants
define('MY_PLUGIN_VERSION', '1.0.0');
define('MY_PLUGIN_FILE', __FILE__);
define('MY_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('MY_PLUGIN_URL', plugin_dir_url(__FILE__));

// Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'My_Plugin_';
    $base_dir = MY_PLUGIN_DIR . 'includes/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . 'class-' . strtolower(str_replace('_', '-', $relative_class)) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Initialize the plugin
function my_plugin_init() {
    My_Plugin::get_instance();
}
add_action('plugins_loaded', 'my_plugin_init');

// Activation hook
register_activation_hook(__FILE__, array('My_Plugin', 'activate'));

// Deactivation hook
register_deactivation_hook(__FILE__, array('My_Plugin', 'deactivate'));

// Uninstall hook
register_uninstall_hook(__FILE__, array('My_Plugin', 'uninstall'));
```

## Main Plugin Class (includes/class-my-plugin.php)

```php
<?php

if (!defined('ABSPATH')) {
    exit;
}

class My_Plugin {

    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->init_hooks();
        $this->includes();
    }

    private function init_hooks() {
        add_action('init', array($this, 'load_textdomain'));
    }

    private function includes() {
        if (is_admin()) {
            new My_Plugin_Admin();
        } else {
            new My_Plugin_Public();
        }
    }

    public function load_textdomain() {
        load_plugin_textdomain(
            'my-plugin',
            false,
            dirname(plugin_basename(MY_PLUGIN_FILE)) . '/languages/'
        );
    }

    public static function activate() {
        // Activation logic
        flush_rewrite_rules();
    }

    public static function deactivate() {
        // Deactivation logic
        flush_rewrite_rules();
    }

    public static function uninstall() {
        // Uninstall logic - clean up options, tables, etc.
        delete_option('my_plugin_settings');
    }
}
```

## Admin Class (includes/class-admin.php)

```php
<?php

if (!defined('ABSPATH')) {
    exit;
}

class My_Plugin_Admin {

    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    public function add_admin_menu() {
        add_menu_page(
            __('My Plugin', 'my-plugin'),
            __('My Plugin', 'my-plugin'),
            'manage_options',
            'my-plugin',
            array($this, 'admin_page'),
            'dashicons-admin-generic'
        );
    }

    public function admin_page() {
        ?>
        <div class="wrap">
            <h1><?php _e('My Plugin Settings', 'my-plugin'); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('my_plugin_settings');
                do_settings_sections('my-plugin');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function register_settings() {
        register_setting('my_plugin_settings', 'my_plugin_settings');

        add_settings_section(
            'my_plugin_main',
            __('Main Settings', 'my-plugin'),
            array($this, 'settings_section_callback'),
            'my-plugin'
        );

        add_settings_field(
            'my_plugin_field',
            __('My Field', 'my-plugin'),
            array($this, 'settings_field_callback'),
            'my-plugin',
            'my_plugin_main'
        );
    }

    public function settings_section_callback() {
        echo __('Configure your plugin settings below.', 'my-plugin');
    }

    public function settings_field_callback() {
        $options = get_option('my_plugin_settings');
        $value = isset($options['my_field']) ? $options['my_field'] : '';
        echo '<input type="text" name="my_plugin_settings[my_field]" value="' . esc_attr($value) . '" />';
    }

    public function enqueue_scripts($hook) {
        if ('toplevel_page_my-plugin' !== $hook) {
            return;
        }

        wp_enqueue_script(
            'my-plugin-admin',
            MY_PLUGIN_URL . 'assets/js/admin.js',
            array('jquery'),
            MY_PLUGIN_VERSION,
            true
        );

        wp_enqueue_style(
            'my-plugin-admin',
            MY_PLUGIN_URL . 'assets/css/admin.css',
            array(),
            MY_PLUGIN_VERSION
        );
    }
}
```

## Public Class (includes/class-public.php)

```php
<?php

if (!defined('ABSPATH')) {
    exit;
}

class My_Plugin_Public {

    public function __construct() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_shortcode('my_shortcode', array($this, 'shortcode_callback'));
    }

    public function enqueue_scripts() {
        wp_enqueue_script(
            'my-plugin-public',
            MY_PLUGIN_URL . 'assets/js/public.js',
            array('jquery'),
            MY_PLUGIN_VERSION,
            true
        );

        wp_enqueue_style(
            'my-plugin-public',
            MY_PLUGIN_URL . 'assets/css/public.css',
            array(),
            MY_PLUGIN_VERSION
        );

        wp_localize_script('my-plugin-public', 'my_plugin_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('my_plugin_nonce')
        ));
    }

    public function shortcode_callback($atts) {
        $atts = shortcode_atts(array(
            'id' => '',
            'class' => 'my-plugin-shortcode'
        ), $atts, 'my_shortcode');

        ob_start();
        ?>
        <div class="<?php echo esc_attr($atts['class']); ?>">
            <p><?php _e('Hello from My Plugin!', 'my-plugin'); ?></p>
            <?php if ($atts['id']) : ?>
                <p><?php printf(__('ID: %s', 'my-plugin'), esc_html($atts['id'])); ?></p>
            <?php endif; ?>
        </div>
        <?php
        return ob_get_clean();
    }
}
```

## AJAX Handler

Add to includes/class-public.php or create separate file:

```php
// AJAX handlers
add_action('wp_ajax_my_plugin_action', array($this, 'ajax_handler'));
add_action('wp_ajax_nopriv_my_plugin_action', array($this, 'ajax_handler'));

public function ajax_handler() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'my_plugin_nonce')) {
        wp_send_json_error(__('Security check failed', 'my-plugin'));
    }

    // Process request
    $data = sanitize_text_field($_POST['data']);

    // Return response
    wp_send_json_success(array(
        'message' => __('Success!', 'my-plugin'),
        'data' => $data
    ));
}
```

## Composer Configuration (composer.json)

```json
{
    "name": "yourname/my-plugin",
    "description": "A comprehensive WordPress plugin",
    "type": "wordpress-plugin",
    "license": "GPL-2.0-or-later",
    "authors": [
        {
            "name": "Your Name",
            "email": "your@email.com"
        }
    ],
    "require": {
        "php": ">=7.4"
    },
    "require-dev": {
        "phpunit/phpunit": "^9.0",
        "wp-coding-standards/wpcs": "^2.3",
        "dealerdirect/phpcodesniffer-composer-installer": "^0.7.0"
    },
    "scripts": {
        "test": "phpunit",
        "lint": "phpcs",
        "lint-fix": "phpcbf"
    },
    "autoload": {
        "psr-4": {
            "My_Plugin\\": "includes/"
        }
    }
}
```

## Package Configuration (package.json)

```json
{
  "name": "my-plugin",
  "version": "1.0.0",
  "description": "A comprehensive WordPress plugin",
  "main": "assets/js/admin.js",
  "scripts": {
    "build": "wp-scripts build",
    "start": "wp-scripts start",
    "lint:js": "wp-scripts lint-js",
    "lint:css": "wp-scripts lint-style",
    "test": "jest"
  },
  "devDependencies": {
    "@wordpress/scripts": "^24.0.0",
    "jest": "^27.0.0"
  },
  "dependencies": {}
}
```

## Testing Setup (tests/bootstrap.php)

```php
<?php

require_once getenv('WP_TESTS_DIR') . '/includes/functions.php';

function _manually_load_plugin() {
    require dirname(dirname(__FILE__)) . '/my-plugin.php';
}
tests_add_filter('muplugins_loaded', '_manually_load_plugin');

require getenv('WP_TESTS_DIR') . '/includes/bootstrap.php';
```

## Basic Test (tests/test-unit.php)

```php
<?php

class My_Plugin_Test extends WP_UnitTestCase {

    public function setUp(): void {
        parent::setUp();
    }

    public function test_plugin_loaded() {
        $this->assertTrue(class_exists('My_Plugin'));
    }

    public function test_shortcode_registered() {
        global $shortcode_tags;
        $this->assertArrayHasKey('my_shortcode', $shortcode_tags);
    }

    public function test_shortcode_output() {
        $output = do_shortcode('[my_shortcode]');
        $this->assertStringContains('<div class="my-plugin-shortcode">', $output);
    }
}
```

## Usage

This template provides a solid foundation for WordPress plugin development with:

- Proper file structure
- Object-oriented architecture
- Internationalization support
- Admin and public separation
- AJAX handling
- Testing setup
- Build tools configuration
- Security best practices

Customize the generated files according to your specific plugin requirements.
