<?php

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Main plugin class for Top Announcement Banner.
 *
 * @psalm-type TabOptions = array{
 *     enabled: 0|1,
 *     message: string,
 *     button_text: string,
 *     button_url: string,
 *     background_color: string,
 *     text_color: string,
 *     dismissible: 0|1
 * }
 */
final class Top_Announcement_Banner {
    /** @var self|null */
    private static $instance = null;

    /** @var TabOptions|array<empty, empty> */
    private $options = array();

    /** @var bool */
    private $banner_displayed = false;

    /**
     * Get the singleton instance of the class.
     *
     * @return self
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Constructor.
     */
    private function __construct() {
        $this->load_textdomain();
        $this->register_hooks();
    }

    /**
     * Register WordPress hooks.
     *
     * @return void
     */
    private function register_hooks() {
        add_action('init', array($this, 'register_blocks'), 10, 0);
        add_action('admin_menu', array($this, 'register_settings_page'), 10, 0);
        add_action('admin_init', array($this, 'register_settings'), 10, 0);
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'), 10, 1);
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'), 10, 0);
        // wp_body_open fires immediately after <body> in themes that support it.
        // wp_footer is a fallback for themes that do not call wp_body_open.
        // The $banner_displayed flag prevents double output if both hooks fire.
        add_action('wp_body_open', array($this, 'display_banner'), 10, 0);
        add_action('wp_footer', array($this, 'display_banner'), 10, 0);
    }

    /**
     * Load the plugin textdomain.
     *
     * @return void
     */
    private function load_textdomain() {
        load_plugin_textdomain('top-announcement-banner');
    }

    /**
     * Register Gutenberg blocks.
     *
     * @return void
     */
    public function register_blocks() {
        /** @psalm-suppress UndefinedConstant */
        $build_dir = TAB_PLUGIN_DIR . 'build/blocks/call-to-action';
        if (is_dir($build_dir)) {
            register_block_type($build_dir);
        }
    }

    /**
     * Register settings.
     *
     * @return void
     */
    public function register_settings() {
        /** @psalm-suppress InvalidArgument */
        register_setting(
            'top_announcement_banner_options',
            'top_announcement_banner',
            array($this, 'sanitize_options')
        );

        add_settings_section(
            'top_announcement_banner_main',
            __('Announcement Banner Settings', 'top-announcement-banner'),
            array($this, 'settings_section_text'),
            'top_announcement_banner_options'
        );
    }

    /**
     * Render settings section text.
     *
     * @return void
     */
    public function settings_section_text() {
        echo '<p>' . esc_html__('Configure the top announcement banner that appears on the front end of your site.', 'top-announcement-banner') . '</p>';
    }

    /**
     * Register the settings page.
     *
     * @return void
     */
    public function register_settings_page() {
        add_options_page(
            __('Top Announcement Banner', 'top-announcement-banner'),
            __('Announcement Banner', 'top-announcement-banner'),
            'manage_options',
            'top-announcement-banner',
            array($this, 'render_settings_page')
        );
    }

    /**
     * Enqueue admin assets.
     *
     * @param string $hook The current admin page hook.
     * @return void
     */
    public function enqueue_admin_assets($hook) {
        if ($hook !== 'settings_page_top-announcement-banner') {
            return;
        }

        /** @psalm-suppress UndefinedConstant */
        wp_enqueue_style(
            'top-announcement-banner-admin',
            TAB_PLUGIN_URL . 'assets/css/admin.css',
            array(),
            TAB_VERSION
        );

        /** @psalm-suppress UndefinedConstant */
        wp_enqueue_script(
            'top-announcement-banner-admin',
            TAB_PLUGIN_URL . 'assets/js/admin.js',
            array('jquery'),
            TAB_VERSION,
            true
        );
    }

    /**
     * Enqueue frontend assets.
     *
     * @return void
     */
    public function enqueue_frontend_assets() {
        $options = $this->get_options();

        if (empty($options['enabled'])) {
            return;
        }

        /** @psalm-suppress UndefinedConstant */
        wp_enqueue_style(
            'top-announcement-banner-style',
            TAB_PLUGIN_URL . 'assets/css/banner.css',
            array(),
            TAB_VERSION
        );

        /** @psalm-suppress UndefinedConstant */
        wp_enqueue_script(
            'top-announcement-banner-script',
            TAB_PLUGIN_URL . 'assets/js/banner.js',
            array(),
            TAB_VERSION,
            true
        );

        wp_localize_script('top-announcement-banner-script', 'TAB_Settings', array(
            'dismissible' => ! empty($options['dismissible']),
            'dismissKey'  => 'top-announcement-banner-hidden',
        ));
    }

    /**
     * Render the settings page.
     *
     * @return void
     */
    public function render_settings_page() {
        $options = $this->get_options();
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Top Announcement Banner', 'top-announcement-banner'); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('top_announcement_banner_options');
                do_settings_sections('top_announcement_banner_options');
                ?>
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="tab_enabled"><?php esc_html_e('Enable Banner', 'top-announcement-banner'); ?></label>
                        </th>
                        <td>
                            <input type="checkbox" id="tab_enabled" name="top_announcement_banner[enabled]" value="1" <?php checked(1, $options['enabled']); ?> />
                            <p class="description"><?php esc_html_e('Show the banner on the frontend.', 'top-announcement-banner'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="tab_message"><?php esc_html_e('Announcement Text', 'top-announcement-banner'); ?></label>
                        </th>
                        <td>
                            <textarea id="tab_message" name="top_announcement_banner[message]" rows="4" class="large-text"><?php echo esc_textarea($options['message']); ?></textarea>
                            <p class="description"><?php esc_html_e('Enter the campaign or offer message to show in the banner.', 'top-announcement-banner'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="tab_button_text"><?php esc_html_e('Button Text', 'top-announcement-banner'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="tab_button_text" name="top_announcement_banner[button_text]" class="regular-text" value="<?php echo esc_attr($options['button_text']); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="tab_button_url"><?php esc_html_e('Button URL', 'top-announcement-banner'); ?></label>
                        </th>
                        <td>
                            <input type="url" id="tab_button_url" name="top_announcement_banner[button_url]" class="regular-text" value="<?php echo esc_url($options['button_url']); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="tab_background_color"><?php esc_html_e('Background Color', 'top-announcement-banner'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="tab_background_color" name="top_announcement_banner[background_color]" class="regular-text" value="<?php echo esc_attr($options['background_color']); ?>" placeholder="#ff4f4f" />
                            <p class="description"><?php esc_html_e('Use a hex color for the banner background.', 'top-announcement-banner'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="tab_text_color"><?php esc_html_e('Text Color', 'top-announcement-banner'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="tab_text_color" name="top_announcement_banner[text_color]" class="regular-text" value="<?php echo esc_attr($options['text_color']); ?>" placeholder="#ffffff" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="tab_dismissible"><?php esc_html_e('Dismissible Banner', 'top-announcement-banner'); ?></label>
                        </th>
                        <td>
                            <input type="checkbox" id="tab_dismissible" name="top_announcement_banner[dismissible]" value="1" <?php checked(1, $options['dismissible']); ?> />
                            <p class="description"><?php esc_html_e('Allow visitors to close the banner.', 'top-announcement-banner'); ?></p>
                        </td>
                    </tr>
                </table>

                <h2><?php esc_html_e('Preview', 'top-announcement-banner'); ?></h2>
                <div class="tab-admin-preview">
                    <div class="tab-banner-preview">
                        <span class="tab-banner-preview-message"><?php echo esc_html($options['message']); ?></span>
                        <?php if (! empty($options['button_text']) && ! empty($options['button_url'])) : ?>
                            <a href="<?php echo esc_url($options['button_url']); ?>" class="tab-banner-preview-button"><?php echo esc_html($options['button_text']); ?></a>
                        <?php endif; ?>
                    </div>
                </div>

                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    /**
     * Display the banner on the frontend.
     *
     * @return void
     */
    public function display_banner() {
        if ($this->banner_displayed) {
            return;
        }

        $options = $this->get_options();

        if (empty($options['enabled'])) {
            return;
        }

        $this->banner_displayed = true;

        $style = sprintf(
            'background-color: %s; color: %s;',
            $this->sanitize_hex_color($options['background_color'], '#d95459'),
            $this->sanitize_hex_color($options['text_color'], '#ffffff')
        );

        echo '<div id="tab-banner" class="tab-banner" style="' . esc_attr($style) . '">';
        echo '<div class="tab-banner-message">' . esc_html($options['message']) . '</div>';

        $button_url = ('' !== $options['button_url']) ? $options['button_url'] : home_url('/');
        if ('' !== $options['button_text']) {
            echo '<a class="tab-banner-button" href="' . esc_url($button_url) . '">' . esc_html($options['button_text']) . '</a>';
        }

        if (! empty($options['dismissible'])) {
            echo '<button type="button" class="tab-banner-close" aria-label="' . esc_attr__('Close announcement', 'top-announcement-banner') . '">&times;</button>';
        }

        echo '</div>';
    }

    /**
     * Sanitize settings.
     *
     * @param mixed $input Raw input.
     * @return TabOptions
     */
    public function sanitize_options($input) {
        $defaults = $this->get_default_options();

        /** @var TabOptions $output */
        $output = array();
        /** @psalm-suppress MixedArrayAccess */
        $output['enabled'] = (isset($input) && is_array($input) && isset($input['enabled'])) ? 1 : 0;
        /** @psalm-suppress MixedArgument */
        $output['message'] = (isset($input) && is_array($input) && isset($input['message'])) ? sanitize_textarea_field((string) $input['message']) : $defaults['message'];
        /** @psalm-suppress MixedArgument */
        $output['button_text'] = (isset($input) && is_array($input) && isset($input['button_text'])) ? sanitize_text_field((string) $input['button_text']) : $defaults['button_text'];
        /** @psalm-suppress MixedArgument */
        $output['button_url'] = (isset($input) && is_array($input) && isset($input['button_url'])) ? esc_url_raw((string) $input['button_url']) : $defaults['button_url'];
        
        $bg_color = (isset($input) && is_array($input) && isset($input['background_color'])) ? (string) $input['background_color'] : '';
        $output['background_color'] = $this->sanitize_hex_color($bg_color, $defaults['background_color']);

        $txt_color = (isset($input) && is_array($input) && isset($input['text_color'])) ? (string) $input['text_color'] : '';
        $output['text_color'] = $this->sanitize_hex_color($txt_color, $defaults['text_color']);
        
        /** @psalm-suppress MixedArrayAccess */
        $output['dismissible'] = (isset($input) && is_array($input) && isset($input['dismissible'])) ? 1 : 0;

        return $output;
    }

    /**
     * Sanitize hex color.
     *
     * @param string $color   Hex color.
     * @param string $default Default hex color.
     * @return string
     */
    private function sanitize_hex_color($color, $default) {
        if (empty($color)) {
            return $default;
        }

        if (preg_match('/^#([A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$/', $color)) {
            return $color;
        }

        return $default;
    }

    /**
     * Get default options.
     *
     * @return TabOptions
     */
    private function get_default_options() {
        return array(
            'enabled' => 0,
            'message' => __('Limited time offer: save 25% on your next purchase!', 'top-announcement-banner'),
            'button_text' => __('Shop Now', 'top-announcement-banner'),
            'button_url' => '',
            'background_color' => '#d95459',
            'text_color' => '#ffffff',
            'dismissible' => 1,
        );
    }

    /** @return TabOptions */
    private function get_options() {
        if (empty($this->options)) {
            /** @psalm-suppress MixedAssignment */
            $saved = get_option('top_announcement_banner', array());
            /** @psalm-suppress MixedArgument */
            $parsed = wp_parse_args(
                is_array($saved) ? $saved : array(),
                $this->get_default_options()
            );
            /** @psalm-suppress UnnecessaryVarAnnotation */
            /** @var TabOptions $parsed */
            $this->options = $parsed;
        }
        /** @var TabOptions */
        return $this->options;
    }
}
