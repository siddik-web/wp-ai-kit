# Gutenberg Block Template

This template generates complete Gutenberg blocks with modern JavaScript and React.

## Generated Structure

```
blocks/{block-name}/
├── block.json                    # Block registration
├── index.js                      # Block JavaScript
├── edit.js                       # Editor component
├── save.js                       # Frontend rendering
├── editor.scss                   # Editor styles
├── style.scss                    # Frontend styles
├── block.php                     # Server-side rendering (optional)
├── transforms.js                 # Block transforms
├── variations.js                 # Block variations
└── deprecated.js                 # Deprecated versions
```

## Block Registration (block.json)

```json
{
  "$schema": "https://schemas.wp.org/trunk/block.json",
  "apiVersion": 2,
  "name": "my-plugin/{block-name}",
  "title": "{Block Title}",
  "category": "common",
  "description": "A custom Gutenberg block for {description}",
  "keywords": ["{keyword1}", "{keyword2}"],
  "version": "1.0.0",
  "textdomain": "my-plugin",
  "attributes": {
    "content": {
      "type": "string",
      "source": "html",
      "selector": "p"
    },
    "alignment": {
      "type": "string",
      "default": "left"
    },
    "backgroundColor": {
      "type": "string",
      "default": "#ffffff"
    },
    "textColor": {
      "type": "string",
      "default": "#000000"
    }
  },
  "supports": {
    "align": ["left", "center", "right", "wide", "full"],
    "anchor": true,
    "color": {
      "background": true,
      "text": true,
      "gradients": true
    },
    "spacing": {
      "margin": true,
      "padding": true
    },
    "typography": {
      "fontSize": true,
      "lineHeight": true
    },
    "__experimentalBorder": {
      "color": true,
      "radius": true,
      "style": true,
      "width": true
    }
  },
  "styles": [
    {
      "name": "default",
      "label": "Default",
      "isDefault": true
    },
    {
      "name": "bordered",
      "label": "Bordered"
    }
  ],
  "variations": [
    {
      "name": "primary",
      "title": "Primary {Block Title}",
      "description": "Primary variation",
      "attributes": {
        "backgroundColor": "#007cba",
        "textColor": "#ffffff"
      }
    }
  ],
  "editorScript": "file:./index.js",
  "editorStyle": "file:./editor.scss",
  "style": "file:./style.scss",
  "render": "file:./block.php"
}
```

## Main Block JavaScript (index.js)

```javascript
import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import edit from './edit';
import save from './save';
import metadata from './block.json';

registerBlockType(metadata.name, {
    ...metadata,
    title: __('{Block Title}', 'my-plugin'),
    description: __('{Block description}', 'my-plugin'),
    icon: 'star-filled',
    category: 'common',
    keywords: [
        __('{keyword1}', 'my-plugin'),
        __('{keyword2}', 'my-plugin'),
    ],
    edit,
    save,
    // Add any additional configuration here
    example: {
        attributes: {
            content: __('This is an example of the {block-name} block.', 'my-plugin'),
        },
    },
});
```

## Editor Component (edit.js)

```javascript
import { __ } from '@wordpress/i18n';
import {
    useBlockProps,
    RichText,
    InspectorControls,
    PanelColorSettings,
    BlockControls,
    AlignmentToolbar,
} from '@wordpress/block-editor';
import {
    PanelBody,
    TextControl,
    RangeControl,
} from '@wordpress/components';
import { useState } from '@wordpress/element';

export default function Edit({ attributes, setAttributes }) {
    const {
        content,
        alignment,
        backgroundColor,
        textColor,
        fontSize,
        padding,
    } = attributes;

    const blockProps = useBlockProps({
        className: `wp-block-my-plugin-${block-name}`,
        style: {
            backgroundColor,
            color: textColor,
            textAlign: alignment,
            fontSize: fontSize ? `${fontSize}px` : undefined,
            padding: padding ? `${padding}px` : undefined,
        },
    });

    return (
        <>
            <BlockControls>
                <AlignmentToolbar
                    value={alignment}
                    onChange={(newAlignment) =>
                        setAttributes({ alignment: newAlignment })
                    }
                />
            </BlockControls>

            <InspectorControls>
                <PanelBody title={__('Settings', 'my-plugin')}>
                    <TextControl
                        label={__('Content', 'my-plugin')}
                        value={content}
                        onChange={(value) => setAttributes({ content: value })}
                        help={__('Enter the block content', 'my-plugin')}
                    />

                    <RangeControl
                        label={__('Font Size', 'my-plugin')}
                        value={fontSize}
                        onChange={(value) => setAttributes({ fontSize: value })}
                        min={12}
                        max={72}
                        step={1}
                    />

                    <RangeControl
                        label={__('Padding', 'my-plugin')}
                        value={padding}
                        onChange={(value) => setAttributes({ padding: value })}
                        min={0}
                        max={100}
                        step={5}
                    />
                </PanelBody>

                <PanelColorSettings
                    title={__('Color Settings', 'my-plugin')}
                    colorSettings={[
                        {
                            value: backgroundColor,
                            onChange: (colorValue) =>
                                setAttributes({ backgroundColor: colorValue }),
                            label: __('Background Color', 'my-plugin'),
                        },
                        {
                            value: textColor,
                            onChange: (colorValue) =>
                                setAttributes({ textColor: colorValue }),
                            label: __('Text Color', 'my-plugin'),
                        },
                    ]}
                />
            </InspectorControls>

            <div {...blockProps}>
                <RichText
                    tagName="p"
                    value={content}
                    onChange={(value) => setAttributes({ content: value })}
                    placeholder={__('Enter content...', 'my-plugin')}
                    style={{
                        textAlign: alignment,
                        color: textColor,
                    }}
                />
            </div>
        </>
    );
}
```

## Save Component (save.js)

```javascript
import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText } from '@wordpress/block-editor';

export default function Save({ attributes }) {
    const {
        content,
        alignment,
        backgroundColor,
        textColor,
        fontSize,
        padding,
    } = attributes;

    const blockProps = useBlockProps.save({
        className: `wp-block-my-plugin-${block-name}`,
        style: {
            backgroundColor,
            color: textColor,
            textAlign: alignment,
            fontSize: fontSize ? `${fontSize}px` : undefined,
            padding: padding ? `${padding}px` : undefined,
        },
    });

    return (
        <div {...blockProps}>
            <RichText.Content
                tagName="p"
                value={content}
                style={{
                    textAlign: alignment,
                    color: textColor,
                }}
            />
        </div>
    );
}
```

## Server-Side Rendering (block.php)

```php
<?php

/**
 * Server-side rendering for the {block-name} block
 */

function render_my_plugin_{block_name}_block($attributes, $content) {
    // Sanitize attributes
    $content = isset($attributes['content']) ? wp_kses_post($attributes['content']) : '';
    $alignment = isset($attributes['alignment']) ? esc_attr($attributes['alignment']) : 'left';
    $background_color = isset($attributes['backgroundColor']) ? esc_attr($attributes['backgroundColor']) : '#ffffff';
    $text_color = isset($attributes['textColor']) ? esc_attr($attributes['textColor']) : '#000000';
    $font_size = isset($attributes['fontSize']) ? intval($attributes['fontSize']) : null;
    $padding = isset($attributes['padding']) ? intval($attributes['padding']) : null;

    // Build inline styles
    $styles = array();
    $styles[] = "background-color: {$background_color}";
    $styles[] = "color: {$text_color}";
    $styles[] = "text-align: {$alignment}";

    if ($font_size) {
        $styles[] = "font-size: {$font_size}px";
    }

    if ($padding) {
        $styles[] = "padding: {$padding}px";
    }

    $style_attr = 'style="' . esc_attr(implode('; ', $styles)) . '"';

    // Generate unique ID for potential JavaScript targeting
    $block_id = 'wp-block-my-plugin-' . esc_attr($block_name) . '-' . uniqid();

    // Build the output
    $output = '<div class="wp-block-my-plugin-' . esc_attr($block_name) . '" id="' . $block_id . '" ' . $style_attr . '>';
    $output .= '<p>' . $content . '</p>';
    $output .= '</div>';

    return $output;
}

// Register the render callback if using server-side rendering
// register_block_type('my-plugin/{block-name}', array(
//     'render_callback' => 'render_my_plugin_{block_name}_block',
// ));
```

## Editor Styles (editor.scss)

```scss
// Editor-specific styles for the {block-name} block

.wp-block-my-plugin-{block-name} {
    // Editor-specific styling
    border: 2px dashed #ccc;
    padding: 20px;
    margin: 10px 0;
    background: #f9f9f9;
    min-height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;

    &:hover {
        border-color: #007cba;
        background: #f0f8ff;
    }

    // Placeholder styling
    .rich-text {
        width: 100%;

        &:empty::before {
            content: attr(data-placeholder);
            color: #999;
            font-style: italic;
        }
    }

    // Block controls
    .block-editor-block-list__block-edit {
        width: 100%;
    }

    // Responsive preview
    @media (max-width: 768px) {
        padding: 15px;
        min-height: 80px;
    }
}

// Block toolbar
.block-editor-block-toolbar {
    .wp-block-my-plugin-{block-name} & {
        background: white;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
}

// Inspector controls
.block-editor-block-inspector {
    .wp-block-my-plugin-{block_name} & {
        // Custom inspector styling if needed
    }
}
```

## Frontend Styles (style.scss)

```scss
// Frontend styles for the {block-name} block

.wp-block-my-plugin-{block-name} {
    // Base styles
    margin: 20px 0;
    padding: 20px;
    border-radius: 4px;
    transition: all 0.3s ease;

    // Content styling
    p {
        margin: 0;
        line-height: 1.6;
    }

    // Responsive design
    @media (max-width: 768px) {
        padding: 15px;
        margin: 15px 0;

        p {
            font-size: 16px;
        }
    }

    // Block variations
    &.is-style-bordered {
        border: 2px solid #ddd;
        background: #f9f9f9;
    }

    // Alignment classes
    &.has-text-align-left {
        text-align: left;
    }

    &.has-text-align-center {
        text-align: center;
    }

    &.has-text-align-right {
        text-align: right;
    }

    // Color utilities (WordPress generates these)
    &.has-background {
        // Background color styles
    }

    &.has-text-color {
        // Text color styles
    }

    // Typography utilities
    &.has-font-size {
        // Font size styles
    }

    // Spacing utilities
    &.has-padding {
        // Padding styles
    }

    &.has-margin {
        // Margin styles
    }

    // Border utilities
    &.has-border-color {
        // Border color styles
    }

    &.has-border-radius {
        // Border radius styles
    }
}

// Animations (optional)
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.wp-block-my-plugin-{block-name} {
    animation: fadeIn 0.5s ease-out;
}
```

## Block Transforms (transforms.js)

```javascript
import { createBlock } from '@wordpress/blocks';

const transforms = {
    from: [
        {
            type: 'block',
            blocks: ['core/paragraph'],
            transform: (attributes) => {
                return createBlock('my-plugin/{block-name}', {
                    content: attributes.content,
                });
            },
        },
        {
            type: 'block',
            blocks: ['core/heading'],
            transform: (attributes) => {
                return createBlock('my-plugin/{block-name}', {
                    content: attributes.content,
                });
            },
        },
    ],
    to: [
        {
            type: 'block',
            blocks: ['core/paragraph'],
            transform: (attributes) => {
                return createBlock('core/paragraph', {
                    content: attributes.content,
                });
            },
        },
    ],
};

export default transforms;
```

## Block Variations (variations.js)

```javascript
import { __ } from '@wordpress/i18n';

const variations = [
    {
        name: 'default',
        title: __('Default', 'my-plugin'),
        description: __('Standard {block-name} block', 'my-plugin'),
        isDefault: true,
        attributes: {
            backgroundColor: '#ffffff',
            textColor: '#000000',
        },
    },
    {
        name: 'primary',
        title: __('Primary', 'my-plugin'),
        description: __('Primary colored {block-name} block', 'my-plugin'),
        attributes: {
            backgroundColor: '#007cba',
            textColor: '#ffffff',
        },
    },
    {
        name: 'secondary',
        title: __('Secondary', 'my-plugin'),
        description: __('Secondary colored {block-name} block', 'my-plugin'),
        attributes: {
            backgroundColor: '#6c757d',
            textColor: '#ffffff',
        },
    },
    {
        name: 'success',
        title: __('Success', 'my-plugin'),
        description: __('Success colored {block-name} block', 'my-plugin'),
        attributes: {
            backgroundColor: '#28a745',
            textColor: '#ffffff',
        },
    },
];

export default variations;
```

## Deprecated Versions (deprecated.js)

```javascript
import { __ } from '@wordpress/i18n';
import { RichText } from '@wordpress/block-editor';

const deprecated = [
    {
        attributes: {
            content: {
                type: 'string',
                source: 'html',
                selector: 'p',
            },
            alignment: {
                type: 'string',
                default: 'left',
            },
        },
        save: function (props) {
            const { content, alignment } = props.attributes;

            return (
                <div
                    className={`wp-block-my-plugin-${block-name}`}
                    style={{ textAlign: alignment }}
                >
                    <p>{content}</p>
                </div>
            );
        },
    },
];

export default deprecated;
```

## Usage

This Gutenberg block template provides:

- Complete block registration with block.json
- Modern React-based edit and save components
- Server-side rendering fallback
- Comprehensive styling for editor and frontend
- Block transforms and variations
- Deprecated version handling
- Accessibility and internationalization support

To use this template:

1. Replace `{block-name}`, `{Block Title}`, and other placeholders
2. Customize attributes and supports in block.json
3. Modify the edit and save components as needed
4. Add custom styling in SCSS files
5. Test in both editor and frontend
6. Add any additional functionality (transforms, variations, etc.)

The generated block follows WordPress coding standards, includes proper security measures, and is optimized for performance.
