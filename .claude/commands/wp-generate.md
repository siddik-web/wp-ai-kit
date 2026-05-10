---
name: wp-generate
description: Generate WordPress components (plugins, themes, blocks, post types)
trigger: "/wp-generate"
---

# WordPress Generate Command

Generates WordPress components following best practices and project conventions.

## What It Does

1. **Plugin Generation**
   - Complete plugin boilerplate
   - Proper file structure
   - Security best practices
   - Internationalization setup

2. **Theme Generation**
   - Theme starter files
   - Template hierarchy
   - Asset organization
   - Child theme support

3. **Gutenberg Block Generation**
   - Block registration
   - Editor interface
   - Frontend rendering
   - Build configuration

4. **Custom Post Type Generation**
   - CPT registration
   - Admin interface
   - Frontend templates
   - Archive pages

5. **Taxonomy Generation**
   - Custom taxonomy registration
   - Term management
   - Template integration

6. **Widget Generation**
   - Widget class structure
   - Admin form
   - Frontend display

## Plugin Generation

### Basic Plugin
```
@Claude /wp-generate plugin my-plugin "My Awesome Plugin"
```

Generates:
```
my-plugin/
├── my-plugin.php          # Main plugin file with headers
├── includes/
│   └── class-my-plugin.php # Main plugin class
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
├── templates/
├── languages/
├── README.txt
└── composer.json
```

### Plugin with Features
```
@Claude /wp-generate plugin my-plugin --features=cpt,settings,ajax
```

Includes:
- Custom post type registration
- Settings page
- AJAX handlers
- Admin notices

## Theme Generation

### Basic Theme
```
@Claude /wp-generate theme my-theme "My Awesome Theme"
```

Generates:
```
my-theme/
├── style.css             # Theme headers
├── functions.php         # Theme functions
├── index.php            # Main template
├── header.php           # Header template
├── footer.php           # Footer template
├── sidebar.php          # Sidebar template
├── page.php             # Page template
├── single.php           # Single post template
├── archive.php          # Archive template
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
├── inc/
└── README.md
```

### Advanced Theme
```
@Claude /wp-generate theme my-theme --framework=underscores --features=customizer,woocommerce
```

Includes:
- Customizer integration
- WooCommerce support
- Advanced customization options

## Gutenberg Block Generation

### Basic Block
```
@Claude /wp-generate block hero-block "Hero Block"
```

Generates:
```
blocks/hero-block/
├── block.json           # Block registration
├── index.js            # Block JavaScript
├── edit.js             # Editor component
├── save.js             # Frontend rendering
├── editor.scss         # Editor styles
├── style.scss          # Frontend styles
└── block.php           # Server-side rendering (optional)
```

### Advanced Block
```
@Claude /wp-generate block testimonial --attributes=name:text,photo:image,rating:number --supports=align,anchor
```

Includes:
- Multiple attributes
- Block supports
- Rich editing interface

## Custom Post Type Generation

### Basic CPT
```
@Claude /wp-generate cpt book "Book" "books"
```

Generates:
```php
// In functions.php or plugin
function register_book_post_type() {
    register_post_type('book', array(
        'labels' => array(
            'name' => 'Books',
            'singular_name' => 'Book'
        ),
        'public' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-book'
    ));
}
add_action('init', 'register_book_post_type');
```

### Advanced CPT
```
@Claude /wp-generate cpt book --supports=title,editor,thumbnail,custom-fields --taxonomies=genre,author --archive=true
```

Includes:
- Custom taxonomies
- Archive page
- Custom fields support

## Taxonomy Generation

```
@Claude /wp-generate taxonomy genre "Genre" "genres" --post-types=book,movie
```

Generates taxonomy registration code with proper labels and associations.

## Widget Generation

```
@Claude /wp-generate widget recent-posts "Recent Posts Widget"
```

Generates a complete widget class with admin form and frontend display.

## Output

- Generated file structure
- Key files created
- Installation instructions
- Next steps for customization

## Usage Examples

```
# Generate a basic plugin
@Claude /wp-generate plugin contact-form

# Generate a theme with specific features
@Claude /wp-generate theme business-theme --features=customizer,woocommerce

# Generate a Gutenberg block with attributes
@Claude /wp-generate block call-to-action --attributes=title:text,button-text:text,button-url:url

# Generate a custom post type with taxonomies
@Claude /wp-generate cpt portfolio --taxonomies=category,tag --supports=title,editor,thumbnail
```

## Integration

Generated components follow:
- [CONVENTIONS.md](../context/CONVENTIONS.md) — Project naming and structure
- [WP-CORE.md](../context/WP-CORE.md) — WordPress best practices
- [WP-SECURITY.md](../context/WP-SECURITY.md) — Security patterns
- [WP-TESTING.md](../context/WP-TESTING.md) — Testing structure
