# Theme Starter Template

This template generates a complete WordPress theme with modern development practices.

## Generated Structure

```
my-theme/
├── style.css              # Theme header and main styles
├── functions.php          # Theme functions and setup
├── index.php             # Main template
├── header.php            # Header template
├── footer.php            # Footer template
├── sidebar.php           # Sidebar template
├── page.php              # Page template
├── single.php            # Single post template
├── archive.php           # Archive template
├── search.php            # Search results template
├── 404.php               # 404 error template
├── assets/
│   ├── css/
│   │   ├── style.css     # Compiled styles
│   │   ├── editor.css    # Gutenberg editor styles
│   │   └── style.scss    # SCSS source
│   ├── js/
│   │   ├── script.js     # Main JavaScript
│   │   └── navigation.js # Navigation script
│   └── images/
├── inc/
│   ├── custom-header.php
│   ├── customizer.php
│   ├── jetpack.php
│   └── template-tags.php
├── template-parts/
│   ├── content-none.php
│   ├── content-page.php
│   ├── content-search.php
│   └── content.php
├── languages/
│   └── my-theme.pot
├── tests/
│   ├── bootstrap.php
│   └── test-theme.php
├── README.md
├── composer.json
├── package.json
├── phpcs.xml
└── phpunit.xml
```

## Theme Header (style.css)

```css
/*
Theme Name: My Theme
Description: A modern WordPress theme with best practices.
Author: Your Name
Version: 1.0.0
Text Domain: my-theme
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Tags: blog, custom-menu, featured-images, threaded-comments, translation-ready
Requires at least: 5.0
Tested up to: 6.4
Requires PHP: 7.4
*/

/* CSS Variables for theming */
:root {
    --primary-color: #007cba;
    --secondary-color: #005a87;
    --text-color: #333;
    --background-color: #fff;
    --border-color: #ddd;
    --font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
}

/* Reset and base styles */
*,
*::before,
*::after {
    box-sizing: border-box;
}

body {
    margin: 0;
    font-family: var(--font-family);
    line-height: 1.6;
    color: var(--text-color);
    background-color: var(--background-color);
}

/* Typography */
h1, h2, h3, h4, h5, h6 {
    margin-top: 0;
    line-height: 1.2;
}

h1 { font-size: 2.5rem; }
h2 { font-size: 2rem; }
h3 { font-size: 1.75rem; }
h4 { font-size: 1.5rem; }
h5 { font-size: 1.25rem; }
h6 { font-size: 1rem; }

/* Layout */
.site {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.site-content {
    flex: 1;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Header */
.site-header {
    background-color: var(--primary-color);
    color: white;
    padding: 1rem 0;
}

.site-branding {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/* Navigation */
.main-navigation {
    background-color: var(--secondary-color);
}

.nav-menu {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
}

.nav-menu li {
    position: relative;
}

.nav-menu a {
    display: block;
    padding: 1rem;
    color: white;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.nav-menu a:hover,
.nav-menu .current-menu-item > a {
    background-color: rgba(255, 255, 255, 0.1);
}

/* Content */
.site-main {
    padding: 2rem 0;
}

.entry-header {
    margin-bottom: 2rem;
}

.entry-title {
    margin-bottom: 1rem;
}

.entry-content {
    margin-bottom: 2rem;
}

/* Footer */
.site-footer {
    background-color: #f8f9fa;
    padding: 2rem 0;
    margin-top: auto;
}

/* Responsive */
@media (max-width: 768px) {
    .nav-menu {
        flex-direction: column;
    }

    .site-branding {
        flex-direction: column;
        text-align: center;
    }
}
```

## Functions File (functions.php)

```php
<?php

if (!defined('ABSPATH')) {
    exit;
}

// Theme constants
define('MY_THEME_VERSION', '1.0.0');
define('MY_THEME_DIR', get_template_directory());
define('MY_THEME_URL', get_template_directory_uri());

// Theme setup
function my_theme_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');

    // Set post thumbnail size
    set_post_thumbnail_size(1200, 9999);

    // Add custom image sizes
    add_image_size('my-theme-featured-image', 1200, 9999);
    add_image_size('my-theme-thumbnail-avatar', 100, 100, true);

    // This theme uses wp_nav_menu() in two locations
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'my-theme'),
        'social'  => __('Social Links Menu', 'my-theme'),
    ));

    // Switch default core markup for search form, comment form, and comments to output valid HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'width'       => 300,
        'height'      => 100,
        'flex-width'  => true,
        'flex-height' => true,
    ));

    // Add support for custom background
    add_theme_support('custom-background', array(
        'default-color' => 'ffffff',
    ));

    // Add support for editor styles
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor.css');

    // Gutenberg support
    add_theme_support('wp-block-styles');
    add_theme_support('responsive-embeds');
    add_theme_support('align-wide');

    // Load theme textdomain
    load_theme_textdomain('my-theme', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'my_theme_setup');

// Set the content width in pixels, based on the theme's design and stylesheet
function my_theme_content_width() {
    $GLOBALS['content_width'] = apply_filters('my_theme_content_width', 1200);
}
add_action('after_setup_theme', 'my_theme_content_width', 0);

// Register widget areas
function my_theme_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar', 'my-theme'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here to appear in your sidebar.', 'my-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => __('Footer 1', 'my-theme'),
        'id'            => 'footer-1',
        'description'   => __('Add widgets here to appear in your footer.', 'my-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => __('Footer 2', 'my-theme'),
        'id'            => 'footer-2',
        'description'   => __('Add widgets here to appear in your footer.', 'my-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'my_theme_widgets_init');

// Enqueue scripts and styles
function my_theme_scripts() {
    // Theme stylesheet
    wp_enqueue_style('my-theme-style', get_stylesheet_uri(), array(), MY_THEME_VERSION);

    // Google Fonts
    wp_enqueue_style('my-theme-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap', array(), null);

    // Theme script
    wp_enqueue_script('my-theme-script', MY_THEME_URL . '/assets/js/script.js', array('jquery'), MY_THEME_VERSION, true);

    // Navigation script
    wp_enqueue_script('my-theme-navigation', MY_THEME_URL . '/assets/js/navigation.js', array('jquery'), MY_THEME_VERSION, true);

    // Localize script
    wp_localize_script('my-theme-script', 'my_theme', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('my_theme_nonce'),
    ));

    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'my_theme_scripts');

// Enqueue block editor styles
function my_theme_block_editor_styles() {
    wp_enqueue_style('my-theme-block-editor-styles', MY_THEME_URL . '/assets/css/editor.css', array(), MY_THEME_VERSION);
}
add_action('enqueue_block_editor_assets', 'my_theme_block_editor_styles');

// Customizer additions
require MY_THEME_DIR . '/inc/customizer.php';

// Custom header
require MY_THEME_DIR . '/inc/custom-header.php';

// Jetpack compatibility
require MY_THEME_DIR . '/inc/jetpack.php';

// Custom template tags
require MY_THEME_DIR . '/inc/template-tags.php';

// Include additional functionality
foreach (glob(MY_THEME_DIR . '/inc/*.php') as $file) {
    if (!in_array(basename($file), array('customizer.php', 'custom-header.php', 'jetpack.php', 'template-tags.php'))) {
        require $file;
    }
}
```

## Main Template (index.php)

```php
<?php get_header(); ?>

<div class="site-content container">
    <div class="site-main">

        <?php if (have_posts()) : ?>

            <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('template-parts/content', get_post_type()); ?>
            <?php endwhile; ?>

            <?php the_posts_navigation(); ?>

        <?php else : ?>

            <?php get_template_part('template-parts/content', 'none'); ?>

        <?php endif; ?>

    </div><!-- .site-main -->

    <?php get_sidebar(); ?>
</div><!-- .site-content -->

<?php get_footer(); ?>
```

## Header Template (header.php)

```php
<?php
/**
 * The header for our theme
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <header id="masthead" class="site-header">
        <div class="container">
            <div class="site-branding">
                <?php
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    ?>
                    <div class="site-title">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                            <?php bloginfo('name'); ?>
                        </a>
                    </div>
                    <?php
                    $description = get_bloginfo('description', 'display');
                    if ($description || is_customize_preview()) {
                        ?>
                        <p class="site-description"><?php echo $description; ?></p>
                        <?php
                    }
                }
                ?>
            </div><!-- .site-branding -->

            <nav id="site-navigation" class="main-navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'nav-menu',
                ));
                ?>
            </nav><!-- #site-navigation -->
        </div><!-- .container -->
    </header><!-- #masthead -->

    <div class="site-content container">
```

## Footer Template (footer.php)

```php
    </div><!-- .site-content -->

    <footer id="colophon" class="site-footer">
        <div class="container">
            <div class="site-info">
                <?php
                if (function_exists('the_privacy_policy_link')) {
                    the_privacy_policy_link('', '<span role="separator" aria-hidden="true"></span>');
                }
                ?>
                <a href="<?php echo esc_url(__('https://wordpress.org/', 'my-theme')); ?>">
                    <?php
                    /* translators: %s: CMS name, i.e. WordPress. */
                    printf(__('Proudly powered by %s', 'my-theme'), 'WordPress');
                    ?>
                </a>
            </div><!-- .site-info -->

            <?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2')) : ?>
                <div class="footer-widgets">
                    <div class="footer-widget-1">
                        <?php dynamic_sidebar('footer-1'); ?>
                    </div>
                    <div class="footer-widget-2">
                        <?php dynamic_sidebar('footer-2'); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div><!-- .container -->
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
```

## Content Template (template-parts/content.php)

```php
<?php
/**
 * Template part for displaying posts
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php
        if (is_singular()) :
            the_title('<h1 class="entry-title">', '</h1>');
        else :
            the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
        endif;

        if ('post' === get_post_type()) :
            ?>
            <div class="entry-meta">
                <?php
                my_theme_posted_on();
                my_theme_posted_by();
                ?>
            </div><!-- .entry-meta -->
        <?php endif; ?>
    </header><!-- .entry-header -->

    <?php my_theme_post_thumbnail(); ?>

    <div class="entry-content">
        <?php
        if (is_singular()) {
            the_content(sprintf(
                wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                    __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'my-theme'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            ));

            wp_link_pages(array(
                'before' => '<div class="page-links">' . esc_html__('Pages:', 'my-theme'),
                'after'  => '</div>',
            ));
        } else {
            the_excerpt();

            echo '<a href="' . esc_url(get_permalink()) . '" class="read-more">' . __('Read More', 'my-theme') . '</a>';
        }
        ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php my_theme_entry_footer(); ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
```

## Customizer (inc/customizer.php)

```php
<?php

function my_theme_customize_register($wp_customize) {
    // Theme Options Panel
    $wp_customize->add_panel('my_theme_options', array(
        'title'    => __('Theme Options', 'my-theme'),
        'priority' => 30,
    ));

    // Colors Section
    $wp_customize->add_section('my_theme_colors', array(
        'title' => __('Colors', 'my-theme'),
        'panel' => 'my_theme_options',
    ));

    // Primary Color
    $wp_customize->add_setting('primary_color', array(
        'default'           => '#007cba',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label'   => __('Primary Color', 'my-theme'),
        'section' => 'my_theme_colors',
    )));

    // Layout Section
    $wp_customize->add_section('my_theme_layout', array(
        'title' => __('Layout', 'my-theme'),
        'panel' => 'my_theme_options',
    ));

    // Sidebar Position
    $wp_customize->add_setting('sidebar_position', array(
        'default'           => 'right',
        'sanitize_callback' => 'my_theme_sanitize_sidebar_position',
    ));

    $wp_customize->add_control('sidebar_position', array(
        'type'    => 'radio',
        'section' => 'my_theme_layout',
        'label'   => __('Sidebar Position', 'my-theme'),
        'choices' => array(
            'left'  => __('Left', 'my-theme'),
            'right' => __('Right', 'my-theme'),
            'none'  => __('No Sidebar', 'my-theme'),
        ),
    ));
}
add_action('customize_register', 'my_theme_customize_register');

function my_theme_sanitize_sidebar_position($input) {
    $valid = array('left', 'right', 'none');
    return in_array($input, $valid, true) ? $input : 'right';
}

// Customizer preview
function my_theme_customize_preview_js() {
    wp_enqueue_script('my-theme-customize-preview', MY_THEME_URL . '/assets/js/customize-preview.js', array('customize-preview'), MY_THEME_VERSION, true);
}
add_action('customize_preview_init', 'my_theme_customize_preview_js');

// Generate CSS from customizer
function my_theme_customizer_css() {
    $primary_color = get_theme_mod('primary_color', '#007cba');

    ?>
    <style type="text/css">
        :root {
            --primary-color: <?php echo esc_attr($primary_color); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'my_theme_customizer_css');
```

## Template Tags (inc/template-tags.php)

```php
<?php

if (!function_exists('my_theme_posted_on')) :
    function my_theme_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr(get_the_date(DATE_W3C)),
            esc_html(get_the_date()),
            esc_attr(get_the_modified_date(DATE_W3C)),
            esc_html(get_the_modified_date())
        );

        $posted_on = sprintf(
            /* translators: %s: post date. */
            esc_html_x('Posted on %s', 'post date', 'my-theme'),
            '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
        );

        echo '<span class="posted-on">' . $posted_on . '</span>';
    }
endif;

if (!function_exists('my_theme_posted_by')) :
    function my_theme_posted_by() {
        $byline = sprintf(
            /* translators: %s: post author. */
            esc_html_x('by %s', 'post author', 'my-theme'),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
        );

        echo '<span class="byline"> ' . $byline . '</span>';
    }
endif;

if (!function_exists('my_theme_entry_footer')) :
    function my_theme_entry_footer() {
        // Hide category and tag text for pages
        if ('post' === get_post_type()) {
            $categories_list = get_the_category_list(esc_html__(', ', 'my-theme'));
            if ($categories_list) {
                /* translators: 1: list of categories. */
                printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'my-theme') . '</span>', $categories_list);
            }

            $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'my-theme'));
            if ($tags_list) {
                /* translators: 1: list of tags. */
                printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'my-theme') . '</span>', $tags_list);
            }
        }

        if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
            echo '<span class="comments-link">';
            comments_popup_link(
                sprintf(
                    wp_kses(
                        /* translators: %s: post title */
                        __('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'my-theme'),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    get_the_title()
                )
            );
            echo '</span>';
        }

        edit_post_link(
            sprintf(
                wp_kses(
                    /* translators: %s: post title */
                    __('Edit <span class="screen-reader-text">%s</span>', 'my-theme'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            ),
            '<span class="edit-link">',
            '</span>'
        );
    }
endif;

if (!function_exists('my_theme_post_thumbnail')) :
    function my_theme_post_thumbnail() {
        if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
            return;
        }

        if (is_singular()) :
            ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail('my-theme-featured-image', array('class' => 'featured-image')); ?>
            </div><!-- .post-thumbnail -->
        <?php else : ?>
            <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <?php
                the_post_thumbnail('my-theme-featured-image', array(
                    'alt' => the_title_attribute(array(
                        'echo' => false,
                    )),
                ));
                ?>
            </a>
        <?php endif;
    }
endif;
```

## Package Configuration (package.json)

```json
{
  "name": "my-theme",
  "version": "1.0.0",
  "description": "A modern WordPress theme",
  "main": "assets/js/script.js",
  "scripts": {
    "build": "wp-scripts build",
    "start": "wp-scripts start",
    "lint:js": "wp-scripts lint-js",
    "lint:css": "wp-scripts lint-style",
    "bundle": "dir-archiver --src . --dest ../my-theme.zip --exclude .git .github node_modules .DS_Store *.log",
    "test": "jest"
  },
  "devDependencies": {
    "@wordpress/scripts": "^24.0.0",
    "dir-archiver": "^2.1.0",
    "jest": "^27.0.0"
  },
  "dependencies": {}
}
```

## SCSS Structure (assets/css/style.scss)

```scss
// Variables
$primary-color: #007cba;
$secondary-color: #005a87;
$text-color: #333;
$background-color: #fff;
$border-color: #ddd;
$font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;

// Mixins
@mixin responsive($breakpoint) {
    @if $breakpoint == tablet {
        @media (max-width: 768px) { @content; }
    } @else if $breakpoint == mobile {
        @media (max-width: 480px) { @content; }
    }
}

// Base styles
*,
*::before,
*::after {
    box-sizing: border-box;
}

body {
    margin: 0;
    font-family: $font-family;
    line-height: 1.6;
    color: $text-color;
    background-color: $background-color;
}

// Typography
h1, h2, h3, h4, h5, h6 {
    margin-top: 0;
    line-height: 1.2;
}

h1 { font-size: 2.5rem; }
h2 { font-size: 2rem; }
h3 { font-size: 1.75rem; }
h4 { font-size: 1.5rem; }
h5 { font-size: 1.25rem; }
h6 { font-size: 1rem; }

// Layout
.site {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.site-content {
    flex: 1;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

// Header
.site-header {
    background-color: $primary-color;
    color: white;
    padding: 1rem 0;
}

.site-branding {
    display: flex;
    align-items: center;
    justify-content: space-between;

    @include responsive(tablet) {
        flex-direction: column;
        text-align: center;
    }
}

// Navigation
.main-navigation {
    background-color: $secondary-color;
}

.nav-menu {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;

    @include responsive(tablet) {
        flex-direction: column;
    }

    a {
        display: block;
        padding: 1rem;
        color: white;
        text-decoration: none;
        transition: background-color 0.3s ease;

        &:hover,
        .current-menu-item & {
            background-color: rgba(255, 255, 255, 0.1);
        }
    }
}

// Content
.site-main {
    padding: 2rem 0;
}

.entry-header {
    margin-bottom: 2rem;
}

.entry-title {
    margin-bottom: 1rem;
}

.entry-content {
    margin-bottom: 2rem;
}

// Footer
.site-footer {
    background-color: #f8f9fa;
    padding: 2rem 0;
    margin-top: auto;
}

// Components
@import "components/buttons";
@import "components/forms";
@import "components/cards";

// Utilities
@import "utilities/utilities";
```

## Usage

This theme template provides:

- Modern CSS with CSS variables
- Responsive design
- Accessibility features
- Gutenberg support
- Customizer integration
- SCSS compilation
- JavaScript build process
- Testing setup
- Internationalization
- Performance optimizations

Customize the generated files according to your design requirements and add your specific styling and functionality.
