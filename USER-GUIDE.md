# wp-ai-kit User Guide

## Overview

**wp-ai-kit** is a production-grade engineering starter kit specifically designed for AI-assisted WordPress development. It provides a comprehensive framework that enables AI agents to work effectively with WordPress projects while maintaining high code quality, security, and performance standards.

### What Makes This Special

Unlike generic AI coding assistants, wp-ai-kit is specifically engineered for WordPress development with:

- **WordPress-specific AI agents** that understand hooks, themes, plugins, and Gutenberg blocks
- **Security-first architecture** with built-in WordPress security patterns
- **Performance optimization** principles tailored for WordPress environments
- **Comprehensive testing frameworks** including WordPress integration tests
- **Production-ready deployment pipelines** for WordPress hosting platforms

## Who This Is For

### Primary Users
- **WordPress Developers** building plugins, themes, or custom functionality
- **AI-assisted Development Teams** using Claude, Cursor, or similar tools
- **WordPress Agencies** needing consistent, high-quality code standards
- **Enterprise WordPress Teams** requiring security and performance compliance

### Secondary Users
- **WordPress Site Builders** creating custom solutions
- **Freelancers** working on WordPress projects
- **DevOps Teams** managing WordPress infrastructure

## Quick Start

### Prerequisites

- **Node.js** 18+ and npm
- **PHP** 8.1+ with Composer
- **Git** for version control
- **WordPress** development environment (local or hosted)

### Installation

```bash
# Clone the repository
git clone https://github.com/your-org/wp-ai-kit.git
cd wp-ai-kit

# Install dependencies
npm install
composer install

# Set up your development environment
npm run setup
```

### First WordPress Project

```bash
# Generate a new WordPress plugin
npx wp-ai-kit generate plugin my-awesome-plugin

# Or create a custom post type
npx wp-ai-kit generate cpt product

# Start development server
npm run dev
```

## Core Concepts

### AI-First Architecture

wp-ai-kit is built around the principle that AI agents should be first-class citizens in your development workflow. Every component is designed to work seamlessly with AI assistants while maintaining human oversight.

#### Key Principles

1. **Explicit Communication** - AI agents must state assumptions clearly
2. **Security by Default** - All code follows WordPress security standards
3. **Performance First** - Built-in optimization patterns
4. **Test-Driven Development** - Comprehensive testing frameworks
5. **Maintainable Code** - Clean, documented, and reviewable

### WordPress-Specific Features

#### Plugin Development
- Object-oriented plugin architecture
- Proper hook registration and cleanup
- Security best practices (nonces, capabilities, sanitization)
- Admin interface patterns
- AJAX endpoint handling

#### Theme Development
- Modern WordPress theme structure
- Gutenberg block integration
- Responsive design patterns
- Performance optimization
- Accessibility compliance

#### Custom Post Types
- Complete CPT registration
- Admin interface customization
- Template integration
- Taxonomy management
- Meta box handling

#### Gutenberg Blocks
- Modern React-based blocks
- Server-side rendering
- Block variations and transforms
- Accessibility support
- Performance optimization

## AI Agents and Commands

### WordPress Agent

The specialized WordPress AI agent understands:

- WordPress core functions and hooks
- Plugin and theme development patterns
- Security best practices
- Performance optimization techniques
- Gutenberg block development

#### Using the WordPress Agent

```bash
# Start a WordPress development session
wp-agent init

# Generate plugin code
wp-agent generate plugin --name=my-plugin --features=admin,ajax,rest-api

# Review code for WordPress standards
wp-agent review --file=my-plugin.php --standards=wordpress-vip

# Optimize performance
wp-agent optimize --file=my-plugin.php --focus=database
```

### Available Commands

#### wp-generate
Generate WordPress components with best practices:

```bash
# Generate a complete plugin
wp-generate plugin my-plugin --admin --ajax --rest-api

# Create a custom post type
wp-generate cpt product --taxonomies=category,tag --templates

# Build a Gutenberg block
wp-generate block hero-banner --attributes=title,subtitle,image

# Start a theme
wp-generate theme my-theme --scss --bootstrap --accessibility
```

#### wp-audit
Security and code quality auditing:

```bash
# Full security audit
wp-audit security --file=my-plugin.php

# WordPress VIP standards check
wp-audit vip --path=./my-plugin/

# Performance analysis
wp-audit performance --file=my-plugin.php

# Accessibility compliance
wp-audit accessibility --theme=my-theme
```

#### wp-deploy
Deployment management for WordPress:

```bash
# Deploy to staging
wp-deploy staging --platform=wp-engine --site=my-site

# Production deployment
wp-deploy production --platform=kinsta --rollback-enabled

# Database migration
wp-deploy migrate --environment=production --backup
```

#### wp-migrate
Database migration helpers:

```bash
# Create new migration
wp-migrate create add_user_profiles_table

# Run pending migrations
wp-migrate up

# Rollback last migration
wp-migrate rollback

# Generate migration from schema changes
wp-migrate generate --from-schema
```

## Development Workflows

### Plugin Development Workflow

1. **Planning**
   ```bash
   wp-agent plan plugin --requirements="User management system"
   ```

2. **Generation**
   ```bash
   wp-generate plugin user-management --admin --database --security
   ```

3. **Development**
   ```bash
   # The AI agent will guide you through implementation
   wp-agent develop --file=user-management.php --feature=user-registration
   ```

4. **Testing**
   ```bash
   wp-audit test --file=user-management.php --coverage
   ```

5. **Security Review**
   ```bash
   wp-audit security --file=user-management.php --wordpress-vip
   ```

6. **Deployment**
   ```bash
   wp-deploy staging --plugin=user-management
   ```

### Theme Development Workflow

1. **Initialize Theme**
   ```bash
   wp-generate theme my-theme --modern --responsive --accessibility
   ```

2. **Add Custom Functionality**
   ```bash
   wp-agent add-feature --theme=my-theme --feature=custom-header
   ```

3. **Gutenberg Integration**
   ```bash
   wp-generate block theme-hero --theme=my-theme --full-width
   ```

4. **Performance Optimization**
   ```bash
   wp-audit performance --theme=my-theme --recommendations
   ```

### Block Development Workflow

1. **Generate Block Structure**
   ```bash
   wp-generate block testimonial-slider --interactive --responsive
   ```

2. **Implement Block Logic**
   ```bash
   wp-agent implement --block=testimonial-slider --feature=autoplay
   ```

3. **Add Block Variations**
   ```bash
   wp-agent add-variation --block=testimonial-slider --name=minimal
   ```

4. **Testing and Validation**
   ```bash
   wp-audit block --file=testimonial-slider --compatibility
   ```

## WordPress-Specific Features

### Security Implementation

wp-ai-kit enforces WordPress security standards:

#### Nonce Verification
```php
// Automatically generated with proper nonce handling
function my_plugin_save_settings() {
    if (!wp_verify_nonce($_POST['my_plugin_nonce'], 'my_plugin_settings')) {
        wp_die('Security check failed');
    }

    if (!current_user_can('manage_options')) {
        wp_die('Insufficient permissions');
    }

    // Safe to process data
    $setting = sanitize_text_field($_POST['my_setting']);
    update_option('my_plugin_setting', $setting);
}
```

#### SQL Injection Prevention
```php
// Prepared statements automatically used
global $wpdb;
$user_id = intval($_GET['user_id']);
$user = $wpdb->get_row(
    $wpdb->prepare("SELECT * FROM {$wpdb->users} WHERE ID = %d", $user_id)
);
```

#### XSS Protection
```php
// Automatic output escaping
echo '<div class="message">' . esc_html($user_message) . '</div>';
echo '<a href="' . esc_url($user_url) . '">' . esc_html($link_text) . '</a>';
```

### Performance Optimization

#### Database Query Optimization
```php
// Efficient queries with proper indexing
$posts = get_posts(array(
    'post_type' => 'product',
    'posts_per_page' => 10,
    'meta_query' => array(
        array(
            'key' => 'price',
            'value' => array(100, 500),
            'type' => 'numeric',
            'compare' => 'BETWEEN'
        )
    ),
    'orderby' => 'meta_value_num',
    'order' => 'ASC'
));
```

#### Caching Strategies
```php
// Transient API usage
function get_expensive_data() {
    $cache_key = 'my_plugin_expensive_data';
    $data = get_transient($cache_key);

    if (false === $data) {
        $data = perform_expensive_operation();
        set_transient($cache_key, $data, HOUR_IN_SECONDS);
    }

    return $data;
}
```

#### Asset Optimization
```php
// Proper asset enqueueing with versioning
wp_enqueue_script(
    'my-plugin-script',
    plugin_dir_url(__FILE__) . 'assets/js/script.js',
    array('jquery'),
    filemtime(plugin_dir_path(__FILE__) . 'assets/js/script.js'),
    true
);
```

### Testing Frameworks

#### Unit Tests
```php
class Test_My_Plugin extends WP_UnitTestCase {
    public function test_plugin_activation() {
        // Test plugin activation
        $this->assertTrue(is_plugin_active('my-plugin/my-plugin.php'));
    }

    public function test_custom_post_type_registered() {
        // Test CPT registration
        $this->assertTrue(post_type_exists('product'));
    }
}
```

#### Integration Tests
```php
class Test_My_Plugin_Integration extends WP_Ajax_UnitTestCase {
    public function test_ajax_endpoint() {
        // Test AJAX functionality
        $_POST['action'] = 'my_plugin_action';
        $_POST['nonce'] = wp_create_nonce('my_plugin_nonce');

        try {
            $this->_handleAjax('my_plugin_action');
        } catch (WPAjaxDieContinueException $e) {
            // Expected
        }

        // Verify response
        $this->assertTrue(isset($e->getMessage()));
    }
}
```

#### E2E Tests
```javascript
// E2E testing with Playwright
test('user can create product', async ({ page }) => {
  await page.goto('/wp-admin/post-new.php?post_type=product');

  await page.fill('#title', 'Test Product');
  await page.fill('#content', 'Product description');

  await page.click('#publish');

  await expect(page.locator('.notice-success')).toBeVisible();
});
```

## Configuration and Customization

### Project Configuration

Create a `.wp-ai-kit.json` file in your project root:

```json
{
  "wordpress": {
    "version": "6.4",
    "php_version": "8.2",
    "hosting": "wp-engine"
  },
  "standards": {
    "phpcs": true,
    "eslint": true,
    "accessibility": true
  },
  "deployment": {
    "staging_url": "https://staging.example.com",
    "production_url": "https://example.com",
    "backup_before_deploy": true
  }
}
```

### AI Agent Configuration

Customize AI agent behavior in `.claude/config.json`:

```json
{
  "agents": {
    "wordpress": {
      "security_level": "strict",
      "performance_focus": true,
      "accessibility_required": true
    }
  },
  "commands": {
    "wp-generate": {
      "default_features": ["admin", "ajax", "security"],
      "code_style": "wordpress-vip"
    }
  }
}
```

## Troubleshooting

### Common Issues

#### AI Agent Not Responding
```bash
# Check agent status
wp-agent status

# Restart agent service
wp-agent restart

# Check logs
wp-agent logs --tail=50
```

#### Plugin Generation Fails
```bash
# Verify WordPress environment
wp core version

# Check PHP extensions
php -m | grep -E "(mysql|zip|gd|curl)"

# Validate composer dependencies
composer validate
```

#### Deployment Issues
```bash
# Check deployment configuration
wp-deploy config --validate

# Test connection to hosting
wp-deploy test-connection --environment=staging

# View deployment logs
wp-deploy logs --environment=staging --tail=100
```

#### Performance Problems
```bash
# Run performance audit
wp-audit performance --comprehensive

# Check database queries
wp-audit database --slow-queries

# Analyze asset loading
wp-audit assets --bundle-analysis
```

### Getting Help

#### Documentation
- [WordPress Core Documentation](https://developer.wordpress.org/)
- [WordPress VIP Documentation](https://docs.wpvip.com/)
- [Gutenberg Handbook](https://developer.wordpress.org/block-editor/)

#### Community Support
- [WordPress Developer Forums](https://wordpress.org/support/forums/)
- [Stack Overflow - WordPress](https://stackoverflow.com/questions/tagged/wordpress)
- [GitHub Issues](https://github.com/your-org/wp-ai-kit/issues)

#### Professional Services
For enterprise support and custom development:
- Contact: support@wp-ai-kit.com
- Enterprise licensing available
- Custom AI agent training
- On-site consulting

## Best Practices

### Code Quality
1. Always run `wp-audit` before committing
2. Use descriptive function and variable names
3. Add PHPDoc comments to all functions
4. Follow WordPress coding standards
5. Write tests for new functionality

### Security
1. Never trust user input - always sanitize and validate
2. Use nonces for all form submissions
3. Check user capabilities before performing actions
4. Use prepared statements for database queries
5. Keep dependencies updated

### Performance
1. Cache expensive operations
2. Optimize database queries
3. Minimize HTTP requests
4. Use lazy loading for images
5. Compress and minify assets

### Accessibility
1. Use semantic HTML
2. Provide alt text for images
3. Ensure keyboard navigation works
4. Test with screen readers
5. Maintain sufficient color contrast

## Contributing

We welcome contributions! See [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines.

### Development Setup
```bash
git clone https://github.com/your-org/wp-ai-kit.git
cd wp-ai-kit
npm install
composer install
npm run setup:dev
```

### Testing
```bash
# Run all tests
npm test

# Run WordPress-specific tests
npm run test:wordpress

# Run E2E tests
npm run test:e2e
```

### Code Standards
```bash
# Check code style
npm run lint

# Fix code style issues
npm run lint:fix

# Run security audit
npm run audit:security
```

## License

This project is licensed under the GPL v2 or later.

## Changelog

### Version 2.0.0 (Current)
- Complete WordPress AI agent integration
- Advanced security auditing
- Performance optimization tools
- Comprehensive testing frameworks
- Multi-platform deployment support

### Version 1.5.0
- Gutenberg block generation
- Theme starter templates
- Custom post type generator
- WordPress VIP compliance

### Version 1.0.0
- Initial release
- Basic plugin generation
- WordPress coding standards
- Core AI agent framework

---

**Happy WordPress Development with AI! 🚀**