# Custom Post Type Generator Template

This template generates WordPress custom post types with full functionality.

## Generated Files

```
custom-post-type-{name}/
├── {name}.php                    # Main CPT registration file
├── includes/
│   ├── class-cpt-{name}.php      # CPT class
│   ├── class-cpt-{name}-admin.php # Admin functionality
│   └── class-cpt-{name}-public.php # Public functionality
├── templates/
│   ├── archive-{name}.php        # Archive template
│   ├── single-{name}.php         # Single template
│   └── content-{name}.php        # Content template
├── assets/
│   ├── css/
│   │   ├── admin.css
│   │   └── public.css
│   └── js/
│       ├── admin.js
│       └── public.js
├── languages/
│   └── {name}.pot
└── README.md
```

## Main CPT File ({name}.php)

```php
<?php

/**
 * Plugin Name: {Name} Custom Post Type
 * Description: Custom post type for {name}
 * Version: 1.0.0
 * Author: Your Name
 * Text Domain: {name}
 * License: GPL v2 or later
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define constants
define('{NAME}_VERSION', '1.0.0');
define('{NAME}_FILE', __FILE__);
define('{NAME}_DIR', plugin_dir_path(__FILE__));
define('{NAME}_URL', plugin_dir_url(__FILE__));

// Autoloader
spl_autoload_register(function ($class) {
    $prefix = '{Name}_';
    $base_dir = {NAME}_DIR . 'includes/';

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
function {name}_init() {
    {Name}::get_instance();
}
add_action('plugins_loaded', '{name}_init');

// Activation hook
register_activation_hook(__FILE__, array('{Name}', 'activate'));

// Deactivation hook
register_deactivation_hook(__FILE__, array('{Name}', 'deactivate'));
```

## Main CPT Class (includes/class-cpt-{name}.php)

```php
<?php

if (!defined('ABSPATH')) {
    exit;
}

class {Name} {

    private static $instance = null;
    private $post_type = '{name}';

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
        add_action('init', array($this, 'register_post_type'));
        add_action('init', array($this, 'register_taxonomies'));
        add_action('init', array($this, 'load_textdomain'));
    }

    private function includes() {
        if (is_admin()) {
            new {Name}_Admin();
        } else {
            new {Name}_Public();
        }
    }

    public function register_post_type() {
        $labels = array(
            'name'                  => _x('{Name}', 'Post type general name', '{name}'),
            'singular_name'         => _x('{Name}', 'Post type singular name', '{name}'),
            'menu_name'             => _x('{Name}', 'Admin Menu text', '{name}'),
            'name_admin_bar'        => _x('{Name}', 'Add New on Toolbar', '{name}'),
            'add_new'               => __('Add New', '{name}'),
            'add_new_item'          => __('Add New {Name}', '{name}'),
            'new_item'              => __('New {Name}', '{name}'),
            'edit_item'             => __('Edit {Name}', '{name}'),
            'view_item'             => __('View {Name}', '{name}'),
            'all_items'             => __('All {Name}', '{name}'),
            'search_items'          => __('Search {Name}', '{name}'),
            'parent_item_colon'     => __('Parent {Name}:', '{name}'),
            'not_found'             => __('No {name} found.', '{name}'),
            'not_found_in_trash'    => __('No {name} found in Trash.', '{name}'),
            'featured_image'        => _x('{Name} Cover Image', 'Overrides the "Featured Image" phrase', '{name}'),
            'set_featured_image'    => _x('Set cover image', 'Overrides the "Set featured image" phrase', '{name}'),
            'remove_featured_image' => _x('Remove cover image', 'Overrides the "Remove featured image" phrase', '{name}'),
            'use_featured_image'    => _x('Use as cover image', 'Overrides the "Use as featured image" phrase', '{name}'),
            'archives'              => _x('{Name} archives', 'The post type archive label used in nav menus', '{name}'),
            'insert_into_item'      => _x('Insert into {name}', 'Overrides the "Insert into post" phrase', '{name}'),
            'uploaded_to_this_item' => _x('Uploaded to this {name}', 'Overrides the "Uploaded to this post" phrase', '{name}'),
            'filter_items_list'     => _x('Filter {name} list', 'Screen reader text for the filter links', '{name}'),
            'items_list_navigation' => _x('{Name} list navigation', 'Screen reader text for the pagination', '{name}'),
            'items_list'            => _x('{Name} list', 'Screen reader text for the items list', '{name}'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => '{name}'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'menu_icon'          => 'dashicons-{icon}',
            'supports'           => array(
                'title',
                'editor',
                'author',
                'thumbnail',
                'excerpt',
                'comments',
                'custom-fields',
                'page-attributes'
            ),
            'show_in_rest'       => true,
            'rest_base'          => '{name}',
        );

        register_post_type($this->post_type, $args);
    }

    public function register_taxonomies() {
        // Register taxonomies here
        // Example: Category taxonomy
        $category_labels = array(
            'name'              => _x('{Name} Categories', 'taxonomy general name', '{name}'),
            'singular_name'     => _x('{Name} Category', 'taxonomy singular name', '{name}'),
            'search_items'      => __('Search {Name} Categories', '{name}'),
            'all_items'         => __('All {Name} Categories', '{name}'),
            'parent_item'       => __('Parent {Name} Category', '{name}'),
            'parent_item_colon' => __('Parent {Name} Category:', '{name}'),
            'edit_item'         => __('Edit {Name} Category', '{name}'),
            'update_item'       => __('Update {Name} Category', '{name}'),
            'add_new_item'      => __('Add New {Name} Category', '{name}'),
            'new_item_name'     => __('New {Name} Category Name', '{name}'),
            'menu_name'         => __('Categories', '{name}'),
        );

        $category_args = array(
            'hierarchical'      => true,
            'labels'            => $category_labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => '{name}-category'),
            'show_in_rest'      => true,
        );

        register_taxonomy('{name}_category', array($this->post_type), $category_args);

        // Example: Tag taxonomy
        $tag_labels = array(
            'name'                       => _x('{Name} Tags', 'taxonomy general name', '{name}'),
            'singular_name'              => _x('{Name} Tag', 'taxonomy singular name', '{name}'),
            'search_items'               => __('Search {Name} Tags', '{name}'),
            'popular_items'              => __('Popular {Name} Tags', '{name}'),
            'all_items'                  => __('All {Name} Tags', '{name}'),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __('Edit {Name} Tag', '{name}'),
            'update_item'                => __('Update {Name} Tag', '{name}'),
            'add_new_item'               => __('Add New {Name} Tag', '{name}'),
            'new_item_name'              => __('New {Name} Tag Name', '{name}'),
            'separate_items_with_commas' => __('Separate {name} tags with commas', '{name}'),
            'add_or_remove_items'        => __('Add or remove {name} tags', '{name}'),
            'choose_from_most_used'      => __('Choose from the most used {name} tags', '{name}'),
            'not_found'                  => __('No {name} tags found.', '{name}'),
            'menu_name'                  => __('Tags', '{name}'),
        );

        $tag_args = array(
            'hierarchical'          => false,
            'labels'                => $tag_labels,
            'show_ui'               => true,
            'show_admin_column'     => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var'             => true,
            'rewrite'               => array('slug' => '{name}-tag'),
            'show_in_rest'          => true,
        );

        register_taxonomy('{name}_tag', array($this->post_type), $tag_args);
    }

    public function load_textdomain() {
        load_plugin_textdomain(
            '{name}',
            false,
            dirname(plugin_basename({NAME}_FILE)) . '/languages/'
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

    public function get_post_type() {
        return $this->post_type;
    }
}
```

## Admin Class (includes/class-cpt-{name}-admin.php)

```php
<?php

if (!defined('ABSPATH')) {
    exit;
}

class {Name}_Admin {

    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_meta_boxes'), 10, 2);
        add_filter('manage_{name}_posts_columns', array($this, 'add_admin_columns'));
        add_action('manage_{name}_posts_custom_column', array($this, 'populate_admin_columns'), 10, 2);
        add_filter('manage_edit-{name}_sortable_columns', array($this, 'sortable_columns'));
    }

    public function add_admin_menu() {
        add_submenu_page(
            'edit.php?post_type={name}',
            __('{Name} Settings', '{name}'),
            __('Settings', '{name}'),
            'manage_options',
            '{name}-settings',
            array($this, 'settings_page')
        );
    }

    public function settings_page() {
        ?>
        <div class="wrap">
            <h1><?php _e('{Name} Settings', '{name}'); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('{name}_settings');
                do_settings_sections('{name}-settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function enqueue_scripts($hook) {
        global $post_type;

        if (($hook == 'post-new.php' || $hook == 'post.php') && $post_type == '{name}') {
            wp_enqueue_script(
                '{name}-admin',
                {NAME}_URL . 'assets/js/admin.js',
                array('jquery'),
                {NAME}_VERSION,
                true
            );

            wp_enqueue_style(
                '{name}-admin',
                {NAME}_URL . 'assets/css/admin.css',
                array(),
                {NAME}_VERSION
            );
        }
    }

    public function add_meta_boxes() {
        add_meta_box(
            '{name}_details',
            __('{Name} Details', '{name}'),
            array($this, 'meta_box_callback'),
            '{name}',
            'normal',
            'high'
        );
    }

    public function meta_box_callback($post) {
        wp_nonce_field('{name}_meta_box', '{name}_meta_box_nonce');

        $value = get_post_meta($post->ID, '_{name}_field', true);
        ?>
        <table class="form-table">
            <tr>
                <th><label for="{name}_field"><?php _e('Custom Field', '{name}'); ?></label></th>
                <td>
                    <input type="text" id="{name}_field" name="{name}_field" value="<?php echo esc_attr($value); ?>" class="regular-text">
                    <p class="description"><?php _e('Enter a custom value for this {name}.', '{name}'); ?></p>
                </td>
            </tr>
        </table>
        <?php
    }

    public function save_meta_boxes($post_id, $post) {
        if (!isset($_POST['{name}_meta_box_nonce']) ||
            !wp_verify_nonce($_POST['{name}_meta_box_nonce'], '{name}_meta_box')) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if ($post->post_type != '{name}') {
            return;
        }

        // Save custom field
        if (isset($_POST['{name}_field'])) {
            update_post_meta($post_id, '_{name}_field', sanitize_text_field($_POST['{name}_field']));
        }
    }

    public function add_admin_columns($columns) {
        $new_columns = array();

        foreach ($columns as $key => $value) {
            if ($key == 'title') {
                $new_columns[$key] = $value;
                $new_columns['{name}_field'] = __('Custom Field', '{name}');
            } else {
                $new_columns[$key] = $value;
            }
        }

        return $new_columns;
    }

    public function populate_admin_columns($column, $post_id) {
        if ($column == '{name}_field') {
            $value = get_post_meta($post_id, '_{name}_field', true);
            echo esc_html($value);
        }
    }

    public function sortable_columns($columns) {
        $columns['{name}_field'] = '{name}_field';
        return $columns;
    }
}
```

## Archive Template (templates/archive-{name}.php)

```php
<?php get_header(); ?>

<div class="archive-{name} container">
    <header class="page-header">
        <h1 class="page-title">
            <?php post_type_archive_title(); ?>
        </h1>
        <?php
        $description = get_the_archive_description();
        if ($description) {
            echo '<div class="archive-description">' . $description . '</div>';
        }
        ?>
    </header><!-- .page-header -->

    <div class="archive-content">
        <?php if (have_posts()) : ?>
            <div class="posts-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('template-parts/content', '{name}'); ?>
                <?php endwhile; ?>
            </div>

            <?php the_posts_navigation(); ?>

        <?php else : ?>
            <p><?php _e('No {name} found.', '{name}'); ?></p>
        <?php endif; ?>
    </div><!-- .archive-content -->

    <?php get_sidebar(); ?>
</div><!-- .archive-{name} -->

<?php get_footer(); ?>
```

## Single Template (templates/single-{name}.php)

```php
<?php get_header(); ?>

<div class="single-{name} container">
    <div class="content-area">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title('<h1 class="entry-title">', '</h1>'); ?>

                    <div class="entry-meta">
                        <?php
                        // Display taxonomies
                        $categories = get_the_terms(get_the_ID(), '{name}_category');
                        if ($categories) {
                            echo '<span class="categories">' . __('Categories: ', '{name}');
                            foreach ($categories as $category) {
                                echo '<a href="' . get_term_link($category) . '">' . $category->name . '</a> ';
                            }
                            echo '</span>';
                        }

                        $tags = get_the_terms(get_the_ID(), '{name}_tag');
                        if ($tags) {
                            echo '<span class="tags">' . __('Tags: ', '{name}');
                            foreach ($tags as $tag) {
                                echo '<a href="' . get_term_link($tag) . '">' . $tag->name . '</a> ';
                            }
                            echo '</span>';
                        }
                        ?>
                    </div><!-- .entry-meta -->
                </header><!-- .entry-header -->

                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-thumbnail">
                        <?php the_post_thumbnail('large'); ?>
                    </div><!-- .post-thumbnail -->
                <?php endif; ?>

                <div class="entry-content">
                    <?php the_content(); ?>

                    <?php
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . __('Pages:', '{name}'),
                        'after'  => '</div>',
                    ));
                    ?>
                </div><!-- .entry-content -->

                <footer class="entry-footer">
                    <?php
                    // Display custom fields
                    $custom_field = get_post_meta(get_the_ID(), '_{name}_field', true);
                    if ($custom_field) {
                        echo '<div class="custom-field">';
                        echo '<strong>' . __('Custom Field:', '{name}') . '</strong> ';
                        echo esc_html($custom_field);
                        echo '</div>';
                    }
                    ?>
                </footer><!-- .entry-footer -->
            </article><!-- #post-<?php the_ID(); ?> -->

            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>

        <?php endwhile; ?>
    </div><!-- .content-area -->

    <?php get_sidebar(); ?>
</div><!-- .single-{name} -->

<?php get_footer(); ?>
```

## Content Template (templates/content-{name}.php)

```php
<?php
/**
 * Template part for displaying {name} posts
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('medium'); ?>
            </a>
        </div><!-- .post-thumbnail -->
    <?php endif; ?>

    <div class="post-content">
        <header class="entry-header">
            <?php
            if (is_singular()) :
                the_title('<h1 class="entry-title">', '</h1>');
            else :
                the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
            endif;
            ?>

            <div class="entry-meta">
                <?php
                // Display taxonomies
                $categories = get_the_terms(get_the_ID(), '{name}_category');
                if ($categories && !is_wp_error($categories)) {
                    echo '<span class="categories">';
                    foreach ($categories as $category) {
                        echo '<a href="' . get_term_link($category) . '">' . $category->name . '</a> ';
                    }
                    echo '</span>';
                }
                ?>
            </div><!-- .entry-meta -->
        </header><!-- .entry-header -->

        <div class="entry-summary">
            <?php
            if (is_singular()) {
                the_content();
            } else {
                the_excerpt();
                echo '<a href="' . esc_url(get_permalink()) . '" class="read-more">' . __('Read More', '{name}') . '</a>';
            }
            ?>
        </div><!-- .entry-summary -->
    </div><!-- .post-content -->
</article><!-- #post-<?php the_ID(); ?> -->
```

## Usage

This custom post type template provides:

- Complete CPT registration with taxonomies
- Admin interface with custom columns and meta boxes
- Public templates for archive and single views
- Internationalization support
- Custom fields integration
- Security best practices
- Responsive design ready

To use this template:

1. Replace `{name}`, `{Name}`, and `{NAME}` with your actual post type name
2. Customize the labels and arguments as needed
3. Add additional taxonomies or meta fields
4. Style the templates according to your theme
5. Test thoroughly before deploying

The generated code follows WordPress coding standards and includes proper security measures, accessibility features, and performance optimizations.
