# WP-CORE.md

This file documents WordPress core functions, hooks, and development patterns. See the main copy at [../../doc/WP-CORE.md](../../doc/WP-CORE.md).

For quick reference in this context folder, key WordPress core concepts:

## Core Functions

### Plugin Development
```php
// Plugin headers (required in main plugin file)
<?php
/**
 * Plugin Name: My Plugin
 * Plugin URI: https://example.com/my-plugin
 * Description: A brief description
 * Version: 1.0.0
 * Author: Your Name
 * License: GPL v2 or later
 * Text Domain: my-plugin
 */

// Activation hook
register_activation_hook(__FILE__, 'my_plugin_activate');
function my_plugin_activate() {
    // Activation code
}

// Deactivation hook
register_deactivation_hook(__FILE__, 'my_plugin_deactivate');
function my_plugin_deactivate() {
    // Cleanup code
}

// Uninstall hook (in uninstall.php)
register_uninstall_hook(__FILE__, 'my_plugin_uninstall');
function my_plugin_uninstall() {
    // Complete cleanup
}
```

### Theme Development
```php
// functions.php - Theme setup
function my_theme_setup() {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    register_nav_menus(array(
        'primary' => 'Primary Menu'
    ));
}
add_action('after_setup_theme', 'my_theme_setup');

// Enqueue scripts and styles
function my_theme_scripts() {
    wp_enqueue_style('my-theme-style', get_stylesheet_uri());
    wp_enqueue_script('my-theme-script', get_template_directory_uri() . '/js/script.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'my_theme_scripts');
```

## Hooks System

### Action Hooks
```php
// Plugin activation
add_action('plugins_loaded', 'my_plugin_init');
function my_plugin_init() {
    // Initialize plugin
}

// Admin menu
add_action('admin_menu', 'my_plugin_menu');
function my_plugin_menu() {
    add_menu_page('My Plugin', 'My Plugin', 'manage_options', 'my-plugin', 'my_plugin_page');
}

// Save post
add_action('save_post', 'my_save_post', 10, 3);
function my_save_post($post_id, $post, $update) {
    // Handle post save
}
```

### Filter Hooks
```php
// Modify post content
add_filter('the_content', 'my_modify_content');
function my_modify_content($content) {
    return $content . '<p>Added by my plugin</p>';
}

// Modify excerpt length
add_filter('excerpt_length', 'my_excerpt_length');
function my_excerpt_length($length) {
    return 30;
}

// Custom query modification
add_filter('pre_get_posts', 'my_modify_query');
function my_modify_query($query) {
    if ($query->is_main_query() && !is_admin()) {
        $query->set('posts_per_page', 12);
    }
}
```

## Custom Post Types & Taxonomies

### Custom Post Type
```php
function register_book_cpt() {
    $labels = array(
        'name' => 'Books',
        'singular_name' => 'Book',
        'add_new' => 'Add New Book',
        'add_new_item' => 'Add New Book',
        'edit_item' => 'Edit Book',
        'new_item' => 'New Book',
        'view_item' => 'View Book',
        'search_items' => 'Search Books',
        'not_found' => 'No books found',
        'not_found_in_trash' => 'No books found in trash'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'menu_icon' => 'dashicons-book',
        'rewrite' => array('slug' => 'books'),
        'show_in_rest' => true
    );

    register_post_type('book', $args);
}
add_action('init', 'register_book_cpt');
```

### Custom Taxonomy
```php
function register_genre_taxonomy() {
    $labels = array(
        'name' => 'Genres',
        'singular_name' => 'Genre',
        'search_items' => 'Search Genres',
        'all_items' => 'All Genres',
        'edit_item' => 'Edit Genre',
        'update_item' => 'Update Genre',
        'add_new_item' => 'Add New Genre',
        'new_item_name' => 'New Genre Name',
        'menu_name' => 'Genres'
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_admin_column' => true,
        'rewrite' => array('slug' => 'genre'),
        'show_in_rest' => true
    );

    register_taxonomy('genre', array('book'), $args);
}
add_action('init', 'register_genre_taxonomy');
```

## Database Operations

### Using $wpdb
```php
global $wpdb;

// Safe query with prepare
$user = $wpdb->get_row(
    $wpdb->prepare(
        "SELECT * FROM {$wpdb->users} WHERE ID = %d",
        $user_id
    )
);

// Insert data
$wpdb->insert(
    $wpdb->prefix . 'my_table',
    array(
        'name' => 'John Doe',
        'email' => 'john@example.com'
    ),
    array('%s', '%s')
);

// Update data
$wpdb->update(
    $wpdb->prefix . 'my_table',
    array('name' => 'Jane Doe'),
    array('id' => 1),
    array('%s'),
    array('%d')
);

// Delete data
$wpdb->delete(
    $wpdb->prefix . 'my_table',
    array('id' => 1),
    array('%d')
);
```

### Options API
```php
// Save option
update_option('my_plugin_setting', 'value');

// Get option with default
$setting = get_option('my_plugin_setting', 'default_value');

// Delete option
delete_option('my_plugin_setting');

// Autoload control
update_option('my_plugin_setting', 'value', false); // Don't autoload
```

## User Management

### User Functions
```php
// Get current user
$current_user = wp_get_current_user();

// Check user capabilities
if (current_user_can('manage_options')) {
    // Admin only code
}

// Get user meta
$user_phone = get_user_meta($current_user->ID, 'phone', true);

// Update user meta
update_user_meta($current_user->ID, 'phone', '+1234567890');

// Check if user is logged in
if (is_user_logged_in()) {
    // User is logged in
}
```

## Internationalization

### Text Domain Setup
```php
// In main plugin file
function my_plugin_load_textdomain() {
    load_plugin_textdomain(
        'my-plugin',
        false,
        dirname(plugin_basename(__FILE__)) . '/languages/'
    );
}
add_action('plugins_loaded', 'my_plugin_load_textdomain');
```

### Translation Functions
```php
// Simple translation
_e('Hello World', 'my-plugin');

// With context
_x('Post', 'noun', 'my-plugin');

// Plural forms
_n('item', 'items', $count, 'my-plugin');

// With variables
printf(__('Hello %s', 'my-plugin'), $name);

// Escape and translate
esc_html_e('Hello World', 'my-plugin');
```

## REST API

### Register Routes
```php
add_action('rest_api_init', 'my_register_api_routes');

function my_register_api_routes() {
    register_rest_route('my-plugin/v1', '/books', array(
        'methods' => 'GET',
        'callback' => 'get_books',
        'permission_callback' => 'books_permissions_check'
    ));

    register_rest_route('my-plugin/v1', '/books/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_book',
        'permission_callback' => 'books_permissions_check',
        'args' => array(
            'id' => array(
                'validate_callback' => function($param) {
                    return is_numeric($param);
                }
            )
        )
    ));
}

function books_permissions_check($request) {
    return current_user_can('read');
}

function get_books($request) {
    $books = get_posts(array(
        'post_type' => 'book',
        'posts_per_page' => -1
    ));

    return new WP_REST_Response($books, 200);
}

function get_book($request) {
    $book = get_post($request->get_param('id'));

    if (!$book || $book->post_type !== 'book') {
        return new WP_Error('book_not_found', 'Book not found', array('status' => 404));
    }

    return new WP_REST_Response($book, 200);
}
```

## AJAX

### Frontend AJAX
```javascript
jQuery(document).ready(function($) {
    $('#my-button').on('click', function() {
        $.ajax({
            url: my_ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'my_ajax_action',
                nonce: my_ajax_object.nonce,
                data: 'some_data'
            },
            success: function(response) {
                if (response.success) {
                    console.log(response.data);
                }
            }
        });
    });
});
```

### Backend AJAX Handler
```php
// Localize script with AJAX URL and nonce
function my_enqueue_scripts() {
    wp_enqueue_script('my-script', plugin_dir_url(__FILE__) . 'js/script.js', array('jquery'), '1.0.0', true);
    wp_localize_script('my-script', 'my_ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('my_ajax_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');

// Handle AJAX request
add_action('wp_ajax_my_ajax_action', 'my_ajax_handler');
add_action('wp_ajax_nopriv_my_ajax_action', 'my_ajax_handler'); // For non-logged-in users

function my_ajax_handler() {
    // Verify nonce
    if (!wp_verify_nonce($_POST['nonce'], 'my_ajax_nonce')) {
        wp_die('Security check failed');
    }

    // Process request
    $data = sanitize_text_field($_POST['data']);
    $response = array(
        'success' => true,
        'data' => 'Processed: ' . $data
    );

    wp_send_json($response);
}
```

## Shortcodes

### Basic Shortcode
```php
function my_shortcode($atts) {
    $atts = shortcode_atts(array(
        'id' => '',
        'class' => 'my-shortcode'
    ), $atts, 'my_shortcode');

    return '<div class="' . esc_attr($atts['class']) . '">Content for ID: ' . esc_html($atts['id']) . '</div>';
}
add_shortcode('my_shortcode', 'my_shortcode');

// Usage: [my_shortcode id="123" class="custom-class"]
```

### Enclosing Shortcode
```php
function my_enclosing_shortcode($atts, $content = null) {
    return '<div class="my-wrapper">' . do_shortcode($content) . '</div>';
}
add_shortcode('my_wrapper', 'my_enclosing_shortcode');

// Usage: [my_wrapper]Some content[/my_wrapper]
```

## Widgets

### Widget Class
```php
class My_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'my_widget',
            'My Widget',
            array('description' => 'A custom widget')
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        echo '<p>Hello World!</p>';
        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        return $instance;
    }
}

// Register widget
function register_my_widget() {
    register_widget('My_Widget');
}
add_action('widgets_init', 'register_my_widget');
```

## Cron Jobs

### Schedule Cron Event
```php
// Schedule event on activation
register_activation_hook(__FILE__, 'my_plugin_activation');
function my_plugin_activation() {
    if (!wp_next_scheduled('my_hourly_event')) {
        wp_schedule_event(time(), 'hourly', 'my_hourly_event');
    }
}

// Clear scheduled event on deactivation
register_deactivation_hook(__FILE__, 'my_plugin_deactivation');
function my_plugin_deactivation() {
    wp_clear_scheduled_hook('my_hourly_event');
}

// Hook into the event
add_action('my_hourly_event', 'my_hourly_function');
function my_hourly_function() {
    // Do something hourly
}

// Custom cron schedule
add_filter('cron_schedules', 'my_cron_schedules');
function my_cron_schedules($schedules) {
    $schedules['every_five_minutes'] = array(
        'interval' => 300,
        'display' => 'Every 5 Minutes'
    );
    return $schedules;
}
```

## File Operations

### Safe File Upload
```php
function handle_file_upload() {
    if (!function_exists('wp_handle_upload')) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
    }

    $files = $_FILES['my_file'];
    $upload_overrides = array('test_form' => false);

    $movefile = wp_handle_upload($files, $upload_overrides);

    if ($movefile && !isset($movefile['error'])) {
        // File uploaded successfully
        $file_url = $movefile['url'];
        $file_path = $movefile['file'];

        // Process file...
    } else {
        // Error handling
        echo $movefile['error'];
    }
}
```

### File System Operations
```php
// Get WordPress upload directory
$upload_dir = wp_upload_dir();
$upload_path = $upload_dir['path'];
$upload_url = $upload_dir['url'];

// Create directory if it doesn't exist
$subdir = '/my-plugin-files';
wp_mkdir_p($upload_path . $subdir);

// Write file
$file_path = $upload_path . $subdir . '/data.txt';
file_put_contents($file_path, 'Some data');

// Read file
$content = file_get_contents($file_path);
```

## Error Handling

### WordPress Error Handling
```php
// Trigger error
if ($some_condition) {
    trigger_error('Something went wrong', E_USER_WARNING);
}

// Custom error handler
function my_error_handler($errno, $errstr, $errfile, $errline) {
    // Log error
    error_log("Error: $errstr in $errfile on line $errline");

    // Don't execute PHP's internal error handler
    return true;
}
set_error_handler('my_error_handler');

// Restore error handler
restore_error_handler();
```

### WP_Error Class
```php
function my_function_that_can_fail($param) {
    if (empty($param)) {
        return new WP_Error('missing_param', 'Parameter is required', array('status' => 400));
    }

    // Process...
    return $result;
}

// Usage
$result = my_function_that_can_fail($param);
if (is_wp_error($result)) {
    $error_message = $result->get_error_message();
    $error_code = $result->get_error_code();
    // Handle error
} else {
    // Success
}
```

**See [../../doc/WP-CORE.md](../../doc/WP-CORE.md) for complete WordPress core reference.**
