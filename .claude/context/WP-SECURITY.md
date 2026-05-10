# WP-SECURITY.md

This file documents WordPress-specific security practices. See the main copy at [../../doc/WP-SECURITY.md](../../doc/WP-SECURITY.md).

For quick reference in this context folder, key WordPress security patterns:

## Input Validation & Sanitization

### Form Data Validation
```php
// Always validate and sanitize
function process_contact_form() {
    // Check nonce first
    if (!wp_verify_nonce($_POST['contact_nonce'], 'submit_contact')) {
        wp_die('Security check failed');
    }

    // Validate required fields
    if (empty($_POST['name']) || empty($_POST['email'])) {
        wp_die('Required fields are missing');
    }

    // Sanitize inputs
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $message = sanitize_textarea_field($_POST['message']);

    // Validate email format
    if (!is_email($email)) {
        wp_die('Invalid email address');
    }

    // Process form...
}
```

### URL and Query Parameter Validation
```php
// Validate and sanitize URL parameters
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$category = isset($_GET['category']) ? sanitize_key($_GET['category']) : '';

// Validate ranges
if ($page < 1) $page = 1;
if ($page > 100) $page = 100;

// Use esc_url for output
echo '<a href="' . esc_url(add_query_arg('page', $page)) . '">Next</a>';
```

## Nonce Verification

### Form Nonces
```php
// In form
wp_nonce_field('my_action', 'my_nonce');

// In processing
if (!wp_verify_nonce($_POST['my_nonce'], 'my_action')) {
    wp_die('Security check failed');
}
```

### AJAX Nonces
```php
// Localize nonce for JavaScript
wp_localize_script('my-script', 'my_ajax', array(
    'nonce' => wp_create_nonce('my_ajax_nonce')
));

// Verify in AJAX handler
if (!wp_verify_nonce($_POST['nonce'], 'my_ajax_nonce')) {
    wp_send_json_error('Security check failed');
}
```

### URL Nonces
```php
// Create nonce URL
$url = wp_nonce_url(admin_url('admin.php?page=my-plugin'), 'bulk-action');

// Verify nonce URL
if (!wp_verify_nonce($_GET['_wpnonce'], 'bulk-action')) {
    wp_die('Security check failed');
}
```

## Capability & Permission Checks

### User Capability Checks
```php
// Check before performing actions
if (!current_user_can('manage_options')) {
    wp_die('Insufficient permissions');
}

// Check for specific post
if (!current_user_can('edit_post', $post_id)) {
    wp_die('You cannot edit this post');
}

// Check for custom capabilities
if (!current_user_can('my_custom_capability')) {
    wp_die('Access denied');
}
```

### Meta Capability Checks
```php
// Check if user can edit specific post
if (!current_user_can('edit_post', $post_id)) {
    return;
}

// Check if user can delete specific user
if (!current_user_can('delete_user', $user_id)) {
    return;
}
```

## Database Security

### Safe SQL Queries
```php
global $wpdb;

// ✅ Always use prepare()
$user = $wpdb->get_row(
    $wpdb->prepare("SELECT * FROM {$wpdb->users} WHERE ID = %d", $user_id)
);

// ✅ Multiple placeholders
$results = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT * FROM {$wpdb->posts} WHERE post_type = %s AND post_status = %s",
        'page', 'publish'
    )
);

// ❌ Never do this
$user = $wpdb->get_row("SELECT * FROM {$wpdb->users} WHERE ID = $user_id");
```

### Custom Table Creation
```php
function create_secure_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'my_secure_table';

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) unsigned NOT NULL,
        data text NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        FOREIGN KEY (user_id) REFERENCES {$wpdb->users}(ID) ON DELETE CASCADE
    ) {$wpdb->get_charset_collate()}";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
```

## Output Escaping

### HTML Output
```php
// Escape HTML attributes
echo '<input type="text" name="field" value="' . esc_attr($value) . '" />';

// Escape HTML content
echo '<div>' . esc_html($content) . '</div>';

// Escape URLs
echo '<a href="' . esc_url($url) . '">Link</a>';
```

### JavaScript Output
```php
// Escape for JavaScript
echo '<script>var data = ' . wp_json_encode($data) . ';</script>';

// Or use wp_localize_script
wp_localize_script('my-script', 'myData', $data);
```

## File Upload Security

### Secure File Upload
```php
function secure_file_upload() {
    // Check nonce
    if (!wp_verify_nonce($_POST['upload_nonce'], 'file_upload')) {
        wp_die('Security check failed');
    }

    // Check user permissions
    if (!current_user_can('upload_files')) {
        wp_die('Insufficient permissions');
    }

    // Validate file
    $file = $_FILES['my_file'];

    // Check file type
    $allowed_types = array('image/jpeg', 'image/png', 'image/gif');
    if (!in_array($file['type'], $allowed_types)) {
        wp_die('Invalid file type');
    }

    // Check file size (max 2MB)
    if ($file['size'] > 2 * 1024 * 1024) {
        wp_die('File too large');
    }

    // Use WordPress upload handler
    if (!function_exists('wp_handle_upload')) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
    }

    $upload_overrides = array('test_form' => false);
    $movefile = wp_handle_upload($file, $upload_overrides);

    if ($movefile && !isset($movefile['error'])) {
        // Success - sanitize filename
        $filename = sanitize_file_name(basename($movefile['file']));
        return $movefile;
    } else {
        wp_die($movefile['error']);
    }
}
```

## Cross-Site Scripting (XSS) Prevention

### Content Filtering
```php
// Filter content before saving
$content = wp_kses_post($_POST['content']); // Allows basic HTML
// or
$content = sanitize_text_field($_POST['content']); // Plain text only

// Save filtered content
update_post_meta($post_id, 'my_content', $content);
```

### Custom KSES Rules
```php
function my_kses_rules($allowedtags) {
    // Allow additional tags
    $allowedtags['iframe'] = array(
        'src' => array(),
        'width' => array(),
        'height' => array(),
        'frameborder' => array(),
        'allowfullscreen' => array()
    );

    return $allowedtags;
}
add_filter('wp_kses_allowed_html', 'my_kses_rules');
```

## Cross-Site Request Forgery (CSRF) Protection

### Action Nonces
```php
// Add to forms
wp_nonce_field('my_action');

// Verify in processing
if (!wp_verify_nonce($_POST['_wpnonce'], 'my_action')) {
    wp_die('CSRF check failed');
}
```

### Referer Check (Additional Layer)
```php
// Check referer as additional security
if (!wp_verify_nonce($_POST['_wpnonce'], 'my_action') ||
    !check_admin_referer('my_action')) {
    wp_die('Security check failed');
}
```

## Secure Cookies

### Setting Secure Cookies
```php
// Set secure cookie
setcookie(
    'my_secure_cookie',
    $value,
    time() + 3600, // 1 hour
    COOKIEPATH,
    COOKIE_DOMAIN,
    true, // secure (HTTPS only)
    true  // httponly
);
```

### WordPress Session Management
```php
// Force logout
wp_logout();

// Destroy session
wp_destroy_current_session();

// Clear auth cookies
wp_clear_auth_cookie();
```

## Plugin Security Headers

### Content Security Policy
```php
function add_csp_header() {
    if (!is_admin()) {
        header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'");
    }
}
add_action('send_headers', 'add_csp_header');
```

### Security Headers
```php
function add_security_headers() {
    // Prevent clickjacking
    header('X-Frame-Options: SAMEORIGIN');

    // Prevent MIME type sniffing
    header('X-Content-Type-Options: nosniff');

    // Enable XSS protection
    header('X-XSS-Protection: 1; mode=block');

    // Referrer policy
    header('Referrer-Policy: strict-origin-when-cross-origin');
}
add_action('send_headers', 'add_security_headers');
```

## User Data Protection

### Data Sanitization
```php
// Personal data handling
$user_data = array(
    'name' => sanitize_text_field($_POST['name']),
    'email' => sanitize_email($_POST['email']),
    'phone' => preg_replace('/[^\d\-\+\(\)\s]/', '', $_POST['phone']), // Numbers, dashes, spaces only
);

// Store securely
update_user_meta($user_id, 'personal_data', $user_data);
```

### Data Retention
```php
// Implement data retention policies
function cleanup_old_data() {
    global $wpdb;

    // Delete data older than 2 years
    $wpdb->query($wpdb->prepare(
        "DELETE FROM {$wpdb->prefix}user_activity
         WHERE created_at < DATE_SUB(NOW(), INTERVAL 2 YEAR)"
    ));
}
```

## Secure API Endpoints

### REST API Security
```php
add_action('rest_api_init', 'register_secure_endpoint');

function register_secure_endpoint() {
    register_rest_route('my-plugin/v1', '/secure-data', array(
        'methods' => 'GET',
        'callback' => 'get_secure_data',
        'permission_callback' => function() {
            return current_user_can('read');
        },
        'args' => array(
            'id' => array(
                'required' => true,
                'validate_callback' => function($param) {
                    return is_numeric($param) && $param > 0;
                },
                'sanitize_callback' => 'intval'
            )
        )
    ));
}

function get_secure_data($request) {
    $id = $request->get_param('id');

    // Additional permission check
    if (!current_user_can('read_private_data') &&
        get_current_user_id() !== get_post_field('post_author', $id)) {
        return new WP_Error('forbidden', 'Access denied', array('status' => 403));
    }

    // Return data
    return get_post($id);
}
```

## Security Monitoring

### Log Security Events
```php
function log_security_event($event, $details = array()) {
    $log_entry = array(
        'timestamp' => current_time('mysql'),
        'event' => $event,
        'user_id' => get_current_user_id(),
        'ip' => $_SERVER['REMOTE_ADDR'],
        'user_agent' => $_SERVER['HTTP_USER_AGENT'],
        'details' => wp_json_encode($details)
    );

    // Log to custom table or use error_log
    global $wpdb;
    $wpdb->insert($wpdb->prefix . 'security_log', $log_entry);
}

// Usage
if ($suspicious_activity) {
    log_security_event('suspicious_login_attempt', array(
        'username' => $username,
        'ip' => $_SERVER['REMOTE_ADDR']
    ));
}
```

### Failed Login Monitoring
```php
function track_failed_logins($username) {
    $key = 'failed_login_' . sanitize_key($username);
    $attempts = get_transient($key);

    if ($attempts === false) {
        $attempts = 0;
    }

    $attempts++;
    set_transient($key, $attempts, 15 * MINUTE_IN_SECONDS); // 15 minutes

    // Lock account after 5 failed attempts
    if ($attempts >= 5) {
        // Implement account lockout
        update_user_meta(get_user_by('login', $username)->ID, 'account_locked', true);
    }
}
add_action('wp_login_failed', 'track_failed_logins');
```

## WordPress Core Security

### Disable File Editing
```php
// In wp-config.php
define('DISALLOW_FILE_EDIT', true);
```

### Automatic Updates
```php
// Enable automatic updates
define('WP_AUTO_UPDATE_CORE', true);
define('AUTOMATIC_UPDATER_DISABLED', false);
```

### Secure wp-config.php
```php
// Move wp-config.php outside web root
// Or add protection
if (!defined('ABSPATH')) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}
```

## Security Checklist

- [ ] All inputs validated and sanitized
- [ ] Nonces used for all forms and AJAX
- [ ] Capability checks before actions
- [ ] SQL queries use $wpdb->prepare()
- [ ] Output properly escaped
- [ ] File uploads validated
- [ ] HTTPS enforced for sensitive operations
- [ ] Security headers implemented
- [ ] Failed login attempts monitored
- [ ] Sensitive data encrypted
- [ ] Regular security audits performed

**See [../../doc/WP-SECURITY.md](../../doc/WP-SECURITY.md) for complete WordPress security guide.**
