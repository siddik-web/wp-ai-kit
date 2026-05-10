---
name: wp-migrate
description: WordPress database migration helpers and schema management
trigger: "/wp-migrate"
---

# WordPress Migrate Command

Handles WordPress database migrations, schema changes, and data transformations safely.

## What It Does

1. **Database Schema Management**
   - Create custom tables
   - Modify existing tables
   - Safe column additions/removals
   - Index management

2. **Data Migration**
   - Transform existing data
   - Migrate between formats
   - Handle data cleanup
   - Rollback capabilities

3. **Version Management**
   - Track migration versions
   - Plugin update migrations
   - Theme update migrations
   - Safe rollback procedures

4. **Migration Testing**
   - Test migrations in isolation
   - Verify data integrity
   - Performance impact assessment

## Database Schema Operations

### Create Custom Table
```
@Claude /wp-migrate create-table user_profiles
```

Generates:
```php
function create_user_profiles_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_profiles';

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) unsigned NOT NULL,
        profile_data longtext,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY user_id (user_id),
        FOREIGN KEY (user_id) REFERENCES {$wpdb->users}(ID) ON DELETE CASCADE
    ) {$wpdb->get_charset_collate()}";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    add_option('my_plugin_db_version', '1.0');
}
```

### Add Column to Existing Table
```
@Claude /wp-migrate add-column wp_posts featured_image_url VARCHAR(500)
```

Generates safe column addition with existence check.

### Create Index
```
@Claude /wp-migrate add-index user_profiles user_id_idx user_id
```

Generates index creation with performance considerations.

## Data Migration

### Transform Data
```
@Claude /wp-migrate transform user_meta migrate_phone_numbers
```

Generates migration to transform phone number formats.

### Migrate Plugin Settings
```
@Claude /wp-migrate settings old_plugin new_plugin
```

Migrates settings from one plugin to another.

### Clean Up Data
```
@Claude /wp-migrate cleanup orphaned_meta
```

Removes orphaned metadata entries.

## Migration Classes

### Basic Migration
```php
class MyPlugin_Migration_1_0_to_1_1 {
    public function up() {
        global $wpdb;

        // Add new column
        $table_name = $wpdb->prefix . 'my_table';
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN new_field VARCHAR(100) DEFAULT ''");

        // Update version
        update_option('my_plugin_version', '1.1');
    }

    public function down() {
        global $wpdb;

        // Remove column
        $table_name = $wpdb->prefix . 'my_table';
        $wpdb->query("ALTER TABLE $table_name DROP COLUMN new_field");

        // Revert version
        update_option('my_plugin_version', '1.0');
    }
}
```

### Advanced Migration with Data Transform
```php
class MyPlugin_Migration_Transform_Data {
    public function up() {
        global $wpdb;

        // Transform existing data
        $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}my_table WHERE old_format IS NOT NULL");

        foreach ($results as $row) {
            $new_format = $this->transform_data($row->old_format);
            $wpdb->update(
                $wpdb->prefix . 'my_table',
                array('new_format' => $new_format),
                array('id' => $row->id)
            );
        }
    }

    private function transform_data($old_data) {
        // Transform logic here
        return json_encode($old_data);
    }
}
```

## Migration Runner

### Plugin Activation Migration
```php
register_activation_hook(__FILE__, 'my_plugin_activate');

function my_plugin_activate() {
    $current_version = get_option('my_plugin_version', '0.0');

    if (version_compare($current_version, '1.0', '<')) {
        $migration = new MyPlugin_Migration_0_0_to_1_0();
        $migration->up();
    }

    if (version_compare($current_version, '1.1', '<')) {
        $migration = new MyPlugin_Migration_1_0_to_1_1();
        $migration->up();
    }
}
```

### Update Hook Migration
```php
add_action('plugins_loaded', 'my_plugin_check_version');

function my_plugin_check_version() {
    $current_version = get_option('my_plugin_version', '0.0');
    $plugin_version = '1.2'; // Current plugin version

    if (version_compare($current_version, $plugin_version, '<')) {
        // Run migrations
        my_plugin_run_migrations($current_version, $plugin_version);

        // Update version
        update_option('my_plugin_version', $plugin_version);
    }
}
```

## Migration Testing

### Unit Test for Migration
```php
class Test_Migration_1_0_to_1_1 extends WP_UnitTestCase {
    public function test_migration_adds_new_column() {
        global $wpdb;

        // Setup test table
        $table_name = $wpdb->prefix . 'test_table';
        $wpdb->query("CREATE TABLE $table_name (id INT PRIMARY KEY, name VARCHAR(100))");

        // Run migration
        $migration = new MyPlugin_Migration_1_0_to_1_1();
        $migration->up();

        // Verify column exists
        $columns = $wpdb->get_col("DESCRIBE $table_name", 0);
        $this->assertContains('new_field', $columns);
    }
}
```

## Rollback Procedures

### Safe Rollback
```php
function my_plugin_rollback_migration($version) {
    try {
        $migration_class = "MyPlugin_Migration_" . str_replace('.', '_', $version);
        if (class_exists($migration_class)) {
            $migration = new $migration_class();
            $migration->down();
            update_option('my_plugin_version', $version);
            return true;
        }
    } catch (Exception $e) {
        error_log('Migration rollback failed: ' . $e->getMessage());
        return false;
    }
}
```

## Output

- Migration files generated
- SQL statements created
- Test files included
- Rollback procedures documented
- Version tracking setup

## Usage

```
# Create a new table
@Claude /wp-migrate create-table user_settings

# Add column to existing table
@Claude /wp-migrate add-column wp_users profile_complete TINYINT(1) DEFAULT 0

# Generate data migration
@Claude /wp-migrate transform user_meta phone_format

# Create migration class
@Claude /wp-migrate class 1.0_to_1.1 add_user_profiles_table

# Generate rollback
@Claude /wp-migrate rollback 1.1_to_1.0
```

## Safety Features

- **Dry Run Mode**: Test migrations without executing
- **Backup Recommendations**: Suggest database backups
- **Version Tracking**: Prevent duplicate migrations
- **Error Handling**: Graceful failure with rollback
- **Data Validation**: Verify data integrity post-migration

## Integration

Works with:
- [WP-CORE.md](../context/WP-CORE.md) — WordPress database patterns
- [WP-TESTING.md](../context/WP-TESTING.md) — Migration testing
- [RELEASE.md](../context/RELEASE.md) — Version management
