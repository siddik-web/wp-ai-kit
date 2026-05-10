---
name: wp-audit
description: WordPress-specific security and best practices audit
trigger: "/wp-audit"
---

# WordPress Audit Command

Performs WordPress-specific security checks, best practices validation, and code quality assessment.

## What It Does

1. **WordPress Security Audit**
   - Nonce verification checks
   - Capability checks validation
   - SQL injection prevention
   - XSS vulnerability scanning
   - CSRF protection verification

2. **WordPress Best Practices**
   - Hook usage validation
   - Internationalization checks
   - Plugin/theme structure compliance
   - WordPress coding standards
   - Deprecated function usage

3. **Performance Audit**
   - N+1 query detection
   - Proper caching implementation
   - Asset optimization
   - Database query efficiency

4. **Compatibility Audit**
   - WordPress version compatibility
   - PHP version requirements
   - Plugin conflicts detection
   - Theme compatibility checks

## Security Checks

### Nonce Verification
```php
// ✅ Good
if (!wp_verify_nonce($_POST['nonce'], 'my_action')) {
    wp_die('Security check failed');
}

// ❌ Bad - Missing nonce check
$name = sanitize_text_field($_POST['name']);
```

### Capability Checks
```php
// ✅ Good
if (!current_user_can('manage_options')) {
    wp_die('Insufficient permissions');
}

// ❌ Bad - No capability check
update_option('my_setting', $_POST['value']);
```

### SQL Injection Prevention
```php
// ✅ Good
global $wpdb;
$user = $wpdb->get_row(
    $wpdb->prepare("SELECT * FROM {$wpdb->users} WHERE ID = %d", $user_id)
);

// ❌ Bad - Direct interpolation
$user = $wpdb->get_row("SELECT * FROM {$wpdb->users} WHERE ID = $user_id");
```

## Best Practices Checks

### Hook Usage
- Proper action/filter hook registration
- Correct hook priorities
- Appropriate hook timing
- Hook cleanup on deactivation

### Internationalization
- All user-facing strings wrapped in `__()`, `_e()`, `_x()`
- Text domain consistency
- Proper translation loading

### Plugin Structure
- Proper plugin headers
- Activation/deactivation hooks
- Uninstall cleanup
- Proper file organization

## Output

- Security vulnerabilities found (severity: critical/high/medium/low)
- Best practices violations
- Performance issues
- Compatibility warnings
- Remediation recommendations

## Usage

```
@Claude /wp-audit
@Claude /wp-audit plugin
@Claude /wp-audit theme
@Claude /wp-audit security
@Claude /wp-audit performance
```

## Integration

Works with existing `/audit` command but focuses specifically on WordPress patterns and security practices.

## Related Documentation

- [WP-SECURITY.md](../context/WP-SECURITY.md) — WordPress security patterns
- [WP-CORE.md](../context/WP-CORE.md) — WordPress core functions
- [SECURITY.md](../context/SECURITY.md) — General security principles
