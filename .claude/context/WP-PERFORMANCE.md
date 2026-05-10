# WP-PERFORMANCE.md

This file documents WordPress performance optimization techniques. See the main copy at [../../doc/WP-PERFORMANCE.md](../../doc/WP-PERFORMANCE.md).

For quick reference in this context folder, key WordPress performance patterns:

## Database Optimization

### Query Optimization
```php
// ✅ Efficient queries
$query = new WP_Query(array(
    'post_type' => 'post',
    'posts_per_page' => 10,
    'no_found_rows' => true, // Skip pagination count
    'update_post_meta_cache' => false, // Skip meta cache
    'update_post_term_cache' => false, // Skip term cache
));

// ❌ Avoid N+1 queries
$posts = get_posts();
foreach ($posts as $post) {
    $meta = get_post_meta($post->ID, 'my_meta'); // N+1 problem!
}

// ✅ Use single query with post__in
$posts = get_posts(array('include' => $post_ids));
$meta = get_post_meta($post->ID); // Single query
```

### Database Indexes
```php
// Add indexes for frequently queried columns
function add_performance_indexes() {
    global $wpdb;

    // Add index on custom meta key
    $wpdb->query("ALTER TABLE {$wpdb->postmeta} ADD INDEX meta_key_value (meta_key, meta_value(50))");

    // Add index on custom table
    $wpdb->query("ALTER TABLE {$wpdb->prefix}my_table ADD INDEX user_date (user_id, created_at)");
}
register_activation_hook(__FILE__, 'add_performance_indexes');
```

## Caching Strategies

### Transient API
```php
function get_expensive_data($key) {
    $cache_key = 'my_data_' . md5($key);
    $data = get_transient($cache_key);

    if (false === $data) {
        $data = expensive_operation($key);
        set_transient($cache_key, $data, HOUR_IN_SECONDS);
    }

    return $data;
}

// Clear cache when data changes
function clear_my_cache($post_id) {
    delete_transient('my_data_' . md5($post_id));
}
add_action('save_post', 'clear_my_cache');
```

### Object Caching
```php
// Cache complex objects
function get_cached_user_data($user_id) {
    $cache_key = 'user_data_' . $user_id;
    $data = wp_cache_get($cache_key, 'my_plugin');

    if (false === $data) {
        $data = build_user_data($user_id);
        wp_cache_set($cache_key, $data, 'my_plugin', HOUR_IN_SECONDS);
    }

    return $data;
}
```

## Asset Optimization

### Script/Style Optimization
```php
function optimize_assets() {
    // Enqueue with dependencies
    wp_enqueue_script(
        'my-script',
        plugin_dir_url(__FILE__) . 'js/script.js',
        array('jquery'), // Dependencies
        '1.0.0',
        true // Load in footer
    );

    // Conditional loading
    if (is_page('contact')) {
        wp_enqueue_script('contact-form-js');
    }

    // Inline critical CSS
    wp_add_inline_style('my-style', '.critical { display: block; }');
}
add_action('wp_enqueue_scripts', 'optimize_assets');
```

### Asset Versioning
```php
function version_assets($src) {
    // Add version parameter to break cache
    if (strpos($src, 'my-plugin') !== false) {
        $src = add_query_arg('ver', wp_get_theme()->get('Version'), $src);
    }
    return $src;
}
add_filter('script_loader_src', 'version_assets');
add_filter('style_loader_src', 'version_assets');
```

## Image Optimization

### Responsive Images
```php
// Add image sizes
function add_image_sizes() {
    add_image_size('hero-large', 1200, 600, true);
    add_image_size('hero-medium', 800, 400, true);
    add_image_size('hero-small', 400, 200, true);
}
add_action('after_setup_theme', 'add_image_sizes');

// Use responsive images
the_post_thumbnail('hero-large', array(
    'sizes' => '(max-width: 768px) 400px, (max-width: 1200px) 800px, 1200px'
));
```

### Lazy Loading
```php
function add_lazy_loading($content) {
    if (is_feed() || is_preview()) {
        return $content;
    }

    // Add loading="lazy" to images
    $content = preg_replace(
        '/<img([^>]+)>/',
        '<img$1 loading="lazy">',
        $content
    );

    return $content;
}
add_filter('the_content', 'add_lazy_loading');
```

## WordPress Core Optimization

### Disable Unnecessary Features
```php
function optimize_wordpress() {
    // Remove emoji scripts
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');

    // Remove unnecessary scripts
    remove_action('wp_head', 'wp_generator'); // Remove WordPress version
    remove_action('wp_head', 'wlwmanifest_link'); // Remove Windows Live Writer
    remove_action('wp_head', 'rsd_link'); // Remove Really Simple Discovery

    // Disable heartbeat API on frontend
    if (!is_admin()) {
        wp_deregister_script('heartbeat');
    }
}
add_action('init', 'optimize_wordpress');
```

### Optimize Admin
```php
function optimize_admin() {
    // Remove dashboard widgets
    function remove_dashboard_widgets() {
        remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
        remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
        remove_meta_box('dashboard_primary', 'dashboard', 'side');
        remove_meta_box('dashboard_secondary', 'dashboard', 'side');
    }
    add_action('wp_dashboard_setup', 'remove_dashboard_widgets');

    // Limit post revisions
    define('WP_POST_REVISIONS', 3);

    // Optimize autosave
    define('AUTOSAVE_INTERVAL', 300); // 5 minutes instead of 60 seconds
}
add_action('admin_init', 'optimize_admin');
```

## Plugin Performance

### Efficient Plugin Loading
```php
// Load only when needed
function conditionally_load_plugin() {
    if (is_page('special-page') || isset($_GET['my_param'])) {
        require_once plugin_dir_path(__FILE__) . 'includes/heavy-code.php';
    }
}
add_action('wp', 'conditionally_load_plugin');

// Use autoloader for classes
spl_autoload_register(function($class) {
    $file = plugin_dir_path(__FILE__) . 'includes/class-' . strtolower(str_replace('_', '-', $class)) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});
```

### Database Cleanup
```php
function cleanup_plugin_data() {
    global $wpdb;

    // Remove orphaned meta
    $wpdb->query("
        DELETE pm FROM {$wpdb->postmeta} pm
        LEFT JOIN {$wpdb->posts} p ON pm.post_id = p.ID
        WHERE p.ID IS NULL
    ");

    // Optimize tables
    $wpdb->query("OPTIMIZE TABLE {$wpdb->postmeta}");
}
register_deactivation_hook(__FILE__, 'cleanup_plugin_data');
```

## Frontend Performance

### Critical CSS
```php
function add_critical_css() {
    if (!is_admin()) {
        echo '<style>.critical-styles { /* Critical CSS here */ }</style>';
    }
}
add_action('wp_head', 'add_critical_css', 1);
```

### DNS Prefetch
```php
function add_dns_prefetch() {
    echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">';
    echo '<link rel="dns-prefetch" href="//www.google-analytics.com">';
}
add_action('wp_head', 'add_dns_prefetch');
```

### Resource Hints
```php
function add_resource_hints() {
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
    echo '<link rel="preload" href="' . get_theme_file_uri('css/critical.css') . '" as="style">';
}
add_action('wp_head', 'add_resource_hints');
```

## Caching Plugins Integration

### WP Rocket
```php
// Exclude pages from cache
function exclude_from_cache() {
    if (is_page('contact')) {
        define('DONOTCACHEPAGE', true);
    }
}
add_action('wp', 'exclude_from_cache');

// Clear cache on content update
function clear_cache_on_update($post_id) {
    if (function_exists('rocket_clean_post')) {
        rocket_clean_post($post_id);
    }
}
add_action('save_post', 'clear_cache_on_update');
```

### W3 Total Cache
```php
// Programmatic cache clearing
function clear_w3_cache() {
    if (function_exists('w3tc_flush_all')) {
        w3tc_flush_all();
    }
}
add_action('my_custom_action', 'clear_w3_cache');
```

## Performance Monitoring

### Query Monitoring
```php
function log_slow_queries() {
    global $wpdb;

    if (defined('SAVEQUERIES') && SAVEQUERIES) {
        add_action('shutdown', function() {
            global $wpdb;

            $slow_queries = array_filter($wpdb->queries, function($query) {
                return $query[1] > 0.5; // Queries slower than 0.5 seconds
            });

            if (!empty($slow_queries)) {
                error_log('Slow queries detected: ' . count($slow_queries));
                foreach ($slow_queries as $query) {
                    error_log('Slow query: ' . $query[0] . ' (' . $query[1] . 's)');
                }
            }
        });
    }
}
add_action('wp_loaded', 'log_slow_queries');
```

### Memory Usage Monitoring
```php
function log_memory_usage() {
    $memory_used = memory_get_peak_usage(true) / 1024 / 1024; // MB

    if ($memory_used > 128) { // Log if over 128MB
        error_log('High memory usage: ' . round($memory_used, 2) . 'MB');
    }
}
add_action('shutdown', 'log_memory_usage');
```

## CDN Integration

### Asset CDN
```php
function cdn_asset_url($src) {
    $cdn_url = 'https://cdn.example.com';

    // Only CDN certain assets
    if (strpos($src, content_url()) === 0) {
        $src = str_replace(content_url(), $cdn_url, $src);
    }

    return $src;
}
add_filter('wp_get_attachment_url', 'cdn_asset_url');
add_filter('script_loader_src', 'cdn_asset_url');
add_filter('style_loader_src', 'cdn_asset_url');
```

## Database Performance

### Connection Optimization
```php
// Use persistent connections if supported
if (defined('MYSQL_CLIENT_FLAGS') && defined('MYSQLI_CLIENT_PERSISTENT')) {
    // Persistent connection setup
}

// Connection pooling for multiple databases
class Database_Pool {
    private $connections = array();

    public function get_connection($key) {
        if (!isset($this->connections[$key])) {
            $this->connections[$key] = new wpdb(DB_USER, DB_PASSWORD, $key, DB_HOST);
        }
        return $this->connections[$key];
    }
}
```

### Query Result Caching
```php
function get_cached_query_results($query, $cache_key, $ttl = HOUR_IN_SECONDS) {
    $results = get_transient($cache_key);

    if (false === $results) {
        global $wpdb;
        $results = $wpdb->get_results($query);
        set_transient($cache_key, $results, $ttl);
    }

    return $results;
}

// Usage
$popular_posts = get_cached_query_results(
    "SELECT * FROM {$wpdb->posts} WHERE post_status = 'publish' ORDER BY comment_count DESC LIMIT 10",
    'popular_posts_cache'
);
```

## Performance Testing

### Load Testing Setup
```php
// Basic load testing with WP-CLI
// wp plugin install wp-load-test
// wp load-test --url=https://example.com --requests=100 --concurrency=10

function performance_test_endpoint() {
    register_rest_route('performance/v1', '/test', array(
        'methods' => 'GET',
        'callback' => 'run_performance_test',
        'permission_callback' => '__return_true'
    ));
}

function run_performance_test() {
    $start = microtime(true);

    // Simulate work
    for ($i = 0; $i < 1000; $i++) {
        $result = md5(uniqid());
    }

    $end = microtime(true);
    $duration = $end - $start;

    return array(
        'duration' => round($duration, 4) . ' seconds',
        'memory' => round(memory_get_peak_usage(true) / 1024 / 1024, 2) . ' MB'
    );
}
add_action('rest_api_init', 'performance_test_endpoint');
```

## Performance Checklist

- [ ] Database queries optimized (no N+1)
- [ ] Proper caching implemented
- [ ] Assets optimized and minified
- [ ] Images responsive and lazy-loaded
- [ ] Unnecessary scripts removed
- [ ] CDN configured for assets
- [ ] Gzip compression enabled
- [ ] Browser caching configured
- [ ] Critical CSS inlined
- [ ] DNS prefetch implemented
- [ ] Database indexes added
- [ ] Query monitoring active
- [ ] Memory usage monitored

**See [../../doc/WP-PERFORMANCE.md](../../doc/WP-PERFORMANCE.md) for complete WordPress performance guide.**
