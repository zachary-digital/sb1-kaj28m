<?php
class Settings_Page {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));
    }

    public function add_settings_page() {
        add_options_page(
            'Markdown to ACF Settings',
            'Markdown to ACF',
            'manage_options',
            'markdown-to-acf',
            array($this, 'render_settings_page')
        );
    }

    public function register_settings() {
        register_setting('markdown-to-acf', 'markdown_to_acf_settings');
        
        add_settings_section(
            'markdown_to_acf_main',
            'Main Settings',
            array($this, 'section_callback'),
            'markdown-to-acf'
        );

        add_settings_field(
            'auto_convert',
            'Auto Convert',
            array($this, 'auto_convert_callback'),
            'markdown-to-acf',
            'markdown_to_acf_main'
        );
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1>Markdown to ACF Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('markdown-to-acf');
                do_settings_sections('markdown-to-acf');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function section_callback() {
        echo '<p>Configure how the Markdown converter behaves.</p>';
    }

    public function auto_convert_callback() {
        $options = get_option('markdown_to_acf_settings');
        $auto_convert = isset($options['auto_convert']) ? $options['auto_convert'] : 1;
        ?>
        <input type="checkbox" name="markdown_to_acf_settings[auto_convert]" value="1" <?php checked(1, $auto_convert); ?>>
        <label>Automatically convert Markdown when saving posts</label>
        <?php
    }
}