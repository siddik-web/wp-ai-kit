# WP-TESTING.md

This file documents WordPress testing frameworks and practices. See the main copy at [../../doc/WP-TESTING.md](../../doc/WP-TESTING.md).

For quick reference in this context folder, key WordPress testing patterns:

## WordPress Testing Pyramid

### Unit Tests (WP_UnitTestCase)
```php
class MyPlugin_Test extends WP_UnitTestCase {
    public function setUp(): void {
        parent::setUp();

        // Create test user
        $this->user_id = $this->factory->user->create(array(
            'role' => 'administrator'
        ));

        // Create test post
        $this->post_id = $this->factory->post->create(array(
            'post_title' => 'Test Post',
            'post_content' => 'Test content'
        ));
    }

    public function test_my_function() {
        wp_set_current_user($this->user_id);

        $result = my_function('test_input');
        $this->assertEquals('expected_output', $result);
    }

    public function test_post_creation() {
        $post = get_post($this->post_id);
        $this->assertEquals('Test Post', $post->post_title);
        $this->assertEquals('publish', $post->post_status);
    }
}
```

### Integration Tests (WP_UnitTestCase)
```php
class MyPlugin_Integration_Test extends WP_UnitTestCase {
    public function test_plugin_activation() {
        // Test plugin activation
        do_action('activate_my-plugin/my-plugin.php');

        // Verify options created
        $this->assertNotFalse(get_option('my_plugin_version'));

        // Verify database tables created
        global $wpdb;
        $table_name = $wpdb->prefix . 'my_plugin_table';
        $this->assertTrue($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name);
    }

    public function test_custom_post_type_registration() {
        // Force post type registration
        do_action('init');

        // Verify post type exists
        $this->assertTrue(post_type_exists('my_custom_post'));

        // Test post creation
        $post_id = wp_insert_post(array(
            'post_type' => 'my_custom_post',
            'post_title' => 'Test Custom Post'
        ));

        $this->assertIsInt($post_id);
        $this->assertGreaterThan(0, $post_id);
    }
}
```

### Functional Tests (WP_UnitTestCase with HTTP)
```php
class MyPlugin_Functional_Test extends WP_UnitTestCase {
    public function test_rest_api_endpoint() {
        wp_set_current_user($this->factory->user->create(array('role' => 'administrator')));

        $request = new WP_REST_Request('GET', '/my-plugin/v1/data');
        $response = rest_do_request($request);

        $this->assertEquals(200, $response->get_status());
        $this->assertNotEmpty($response->get_data());
    }

    public function test_shortcode_output() {
        $output = do_shortcode('[my_shortcode id="123"]');

        $this->assertStringContains('123', $output);
        $this->assertStringContains('my-shortcode', $output);
    }
}
```

## AJAX Testing

### AJAX Handler Testing
```php
class MyPlugin_Ajax_Test extends WP_UnitTestCase {
    public function setUp(): void {
        parent::setUp();

        // Create admin user
        $this->admin_user = $this->factory->user->create(array(
            'role' => 'administrator'
        ));

        // Set up AJAX
        add_action('wp_ajax_my_action', 'my_ajax_handler');
        add_action('wp_ajax_nopriv_my_action', 'my_ajax_handler');
    }

    public function test_ajax_requires_login() {
        // Test without user
        wp_set_current_user(0);

        try {
            $this->_handleAjax('my_action');
            $this->fail('Expected WPAjaxDieStopException');
        } catch (WPAjaxDieStopException $e) {
            // Expected
        }
    }

    public function test_ajax_success() {
        wp_set_current_user($this->admin_user);

        // Mock POST data
        $_POST['action'] = 'my_action';
        $_POST['data'] = 'test';
        $_POST['_wpnonce'] = wp_create_nonce('my_nonce');

        $this->_handleAjax('my_action');

        // Check response
        $response = json_decode($this->_last_response, true);
        $this->assertTrue($response['success']);
    }
}
```

## Gutenberg Block Testing

### Block Registration Testing
```php
class MyBlock_Test extends WP_UnitTestCase {
    public function test_block_is_registered() {
        // Force block registration
        do_action('init');

        $registered_blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();
        $this->assertArrayHasKey('my-plugin/my-block', $registered_blocks);
    }

    public function test_block_attributes() {
        $block = WP_Block_Type_Registry::get_instance()->get_registered('my-plugin/my-block');

        $this->assertArrayHasKey('content', $block->attributes);
        $this->assertEquals('string', $block->attributes['content']['type']);
        $this->assertEquals('', $block->attributes['content']['default']);
    }
}
```

### Block Rendering Testing
```php
class MyBlock_Render_Test extends WP_UnitTestCase {
    public function test_block_rendering() {
        $attributes = array('content' => 'Test content');
        $content = '<p>Test content</p>';

        $block = new WP_Block(array(
            'blockName' => 'my-plugin/my-block',
            'attrs' => $attributes,
            'innerHTML' => $content
        ));

        // Test render function
        $output = my_block_render_callback($attributes, $content, $block);

        $this->assertStringContains('<div class="my-block">', $output);
        $this->assertStringContains('Test content', $output);
    }
}
```

## Database Testing

### Custom Table Testing
```php
class MyPlugin_Database_Test extends WP_UnitTestCase {
    public function setUp(): void {
        parent::setUp();

        // Create test table
        $this->create_test_table();
    }

    private function create_test_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'test_table';

        $wpdb->query("CREATE TABLE $table_name (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
    }

    public function test_data_insertion() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'test_table';

        $result = $wpdb->insert($table_name, array(
            'name' => 'Test Entry'
        ));

        $this->assertEquals(1, $result);

        // Verify insertion
        $entry = $wpdb->get_row("SELECT * FROM $table_name WHERE id = 1");
        $this->assertEquals('Test Entry', $entry->name);
    }

    public function test_data_retrieval() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'test_table';

        // Insert test data
        $wpdb->insert($table_name, array('name' => 'Test'));

        // Test retrieval
        $results = $wpdb->get_results("SELECT * FROM $table_name");
        $this->assertCount(1, $results);
        $this->assertEquals('Test', $results[0]->name);
    }
}
```

## Migration Testing

### Database Migration Testing
```php
class MyPlugin_Migration_Test extends WP_UnitTestCase {
    public function test_migration_up() {
        global $wpdb;

        // Run migration
        $migration = new MyPlugin_Migration_1_0_to_1_1();
        $migration->up();

        // Verify table structure
        $table_name = $wpdb->prefix . 'my_table';
        $columns = $wpdb->get_col("DESCRIBE $table_name", 0);

        $this->assertContains('new_column', $columns);
    }

    public function test_migration_down() {
        global $wpdb;

        // Run up migration first
        $migration = new MyPlugin_Migration_1_0_to_1_1();
        $migration->up();

        // Then test down migration
        $migration->down();

        // Verify column removed
        $table_name = $wpdb->prefix . 'my_table';
        $columns = $wpdb->get_col("DESCRIBE $table_name", 0);

        $this->assertNotContains('new_column', $columns);
    }
}
```

## Security Testing

### Nonce Testing
```php
class MyPlugin_Security_Test extends WP_UnitTestCase {
    public function test_nonce_verification() {
        $nonce = wp_create_nonce('my_action');

        // Test valid nonce
        $this->assertTrue(wp_verify_nonce($nonce, 'my_action'));

        // Test invalid nonce
        $this->assertFalse(wp_verify_nonce('invalid_nonce', 'my_action'));
    }

    public function test_capability_checks() {
        $user_id = $this->factory->user->create(array('role' => 'subscriber'));
        wp_set_current_user($user_id);

        // Test insufficient permissions
        $this->assertFalse(current_user_can('manage_options'));

        // Switch to admin
        $admin_id = $this->factory->user->create(array('role' => 'administrator'));
        wp_set_current_user($admin_id);

        // Test sufficient permissions
        $this->assertTrue(current_user_can('manage_options'));
    }
}
```

## Performance Testing

### Query Performance Testing
```php
class MyPlugin_Performance_Test extends WP_UnitTestCase {
    public function test_query_performance() {
        // Create test data
        for ($i = 0; $i < 100; $i++) {
            $this->factory->post->create();
        }

        $start_time = microtime(true);

        // Test query performance
        $posts = get_posts(array(
            'posts_per_page' => 50,
            'no_found_rows' => true
        ));

        $end_time = microtime(true);
        $execution_time = $end_time - $start_time;

        // Assert reasonable performance (less than 0.1 seconds)
        $this->assertLessThan(0.1, $execution_time);
        $this->assertCount(50, $posts);
    }
}
```

## Testing Setup

### Bootstrap File (tests/bootstrap.php)
```php
<?php
// Load WordPress test environment
require_once getenv('WP_TESTS_DIR') . '/includes/functions.php';

function _manually_load_plugin() {
    require dirname(dirname(__FILE__)) . '/my-plugin.php';
}
tests_add_filter('muplugins_loaded', '_manually_load_plugin');

// Load the WordPress test suite
require getenv('WP_TESTS_DIR') . '/includes/bootstrap.php';
```

### PHPUnit Configuration (phpunit.xml)
```xml
<phpunit
    bootstrap="tests/bootstrap.php"
    backupGlobals="false"
    colors="true"
    convertErrorsToExceptions="true"
    convertNoticesToExceptions="true"
    convertWarningsToExceptions="true"
>
    <testsuites>
        <testsuite name="My Plugin Tests">
            <directory prefix="test-" suffix=".php">./tests/</directory>
        </testsuite>
    </testsuites>

    <filter>
        <whitelist>
            <directory suffix=".php">../</directory>
            <exclude>
                <directory>../tests</directory>
                <directory>../vendor</directory>
            </exclude>
        </whitelist>
    </filter>
</phpunit>
```

### Test Runner Script
```bash
#!/bin/bash
# Run tests script

# Set WordPress test environment
export WP_TESTS_DIR=/path/to/wordpress-develop/tests/phpunit
export WP_CORE_DIR=/path/to/wordpress

# Run tests
phpunit

# Generate coverage report
phpunit --coverage-html coverage-report
```

## Continuous Integration

### GitHub Actions Testing
```yaml
name: Tests
on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    strategy:
      matrix:
        php: ['7.4', '8.0', '8.1']
        wordpress: ['latest', '5.9']

    steps:
      - uses: actions/checkout@v4

      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: ${{ matrix.php }}

      - name: Setup WordPress
        run: |
          git clone --depth=1 https://github.com/WordPress/wordpress-develop.git
          cd wordpress-develop
          npm install
          npm run build:dev

      - name: Install dependencies
        run: composer install

      - name: Run tests
        run: phpunit
        env:
          WP_TESTS_DIR: wordpress-develop/tests/phpunit
```

## Test Organization

### Test File Structure
```
tests/
├── test-unit.php          # Unit tests
├── test-integration.php   # Integration tests
├── test-ajax.php          # AJAX tests
├── test-security.php      # Security tests
├── test-performance.php   # Performance tests
├── test-database.php      # Database tests
└── bootstrap.php          # Test bootstrap
```

### Test Naming Conventions
```php
class MyPlugin_Feature_Test extends WP_UnitTestCase {
    // Unit tests
    public function test_feature_does_something() {}

    // Integration tests
    public function test_feature_integrates_with_wordpress() {}

    // Security tests
    public function test_feature_validates_input() {}

    // Performance tests
    public function test_feature_performs_well() {}
}
```

## Mocking and Stubs

### Mock WordPress Functions
```php
class MyPlugin_Mock_Test extends WP_UnitTestCase {
    public function test_with_mocked_function() {
        // Mock wp_mail function
        $mock = $this->getMockBuilder('stdClass')
            ->setMethods(['wp_mail'])
            ->getMock();

        $mock->expects($this->once())
            ->method('wp_mail')
            ->willReturn(true);

        // Replace global function (advanced technique)
        global $phpmailer;
        $original_mailer = $phpmailer;
        $phpmailer = $mock;

        // Run test
        $result = my_function_that_sends_email();

        // Restore
        $phpmailer = $original_mailer;

        $this->assertTrue($result);
    }
}
```

## Test Data Factories

### Custom Test Data
```php
class MyPlugin_Test_Factory extends WP_UnitTestCase {
    public function create_test_user_with_meta($meta = array()) {
        $user_id = $this->factory->user->create();

        foreach ($meta as $key => $value) {
            update_user_meta($user_id, $key, $value);
        }

        return $user_id;
    }

    public function create_test_post_with_terms($terms = array()) {
        $post_id = $this->factory->post->create();

        foreach ($terms as $taxonomy => $term_names) {
            wp_set_object_terms($post_id, $term_names, $taxonomy);
        }

        return $post_id;
    }
}
```

## Testing Checklist

- [ ] Unit tests for all functions
- [ ] Integration tests for WordPress integration
- [ ] Security tests for input validation
- [ ] AJAX tests for JavaScript interactions
- [ ] Database tests for data operations
- [ ] Performance tests for critical paths
- [ ] Migration tests for database changes
- [ ] Gutenberg block tests for editor functionality
- [ ] REST API tests for endpoints
- [ ] Accessibility tests for user interfaces

**See [../../doc/WP-TESTING.md](../../doc/WP-TESTING.md) for complete WordPress testing guide.**
