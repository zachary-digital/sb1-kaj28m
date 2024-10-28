<?php
/**
 * Plugin Name: Markdown to ACF Fields Converter
 * Description: Convert Markdown content to ACF fields and integrate with Gutenberg editor.
 * Version: 1.0.0
 * Author: Your Name
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if (!defined('ABSPATH')) {
    exit;
}

// Load required files
require_once plugin_dir_path(__FILE__) . 'includes/class-markdown-parser.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-acf-integration.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-gutenberg-block.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-settings-page.php';

class Markdown_To_ACF_Converter {
    private static $instance = null;
    private $parser;
    private $acf_integration;
    private $gutenberg_block;
    private $settings;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('init', array($this, 'init'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
    }

    public function init() {
        $this->parser = new Markdown_Parser();
        $this->acf_integration = new ACF_Integration($this->parser);
        $this->gutenberg_block = new Gutenberg_Block($this->parser);
        $this->settings = new Settings_Page();
    }

    public function enqueue_admin_assets() {
        wp_enqueue_style(
            'markdown-to-acf-admin',
            plugin_dir_url(__FILE__) . 'assets/css/admin.css',
            array(),
            '1.0.0'
        );

        wp_enqueue_script(
            'markdown-to-acf-admin',
            plugin_dir_url(__FILE__) . 'assets/js/admin.js',
            array('jquery'),
            '1.0.0',
            true
        );
    }
}

// Initialize the plugin
function markdown_to_acf_converter_init() {
    return Markdown_To_ACF_Converter::get_instance();
}

markdown_to_acf_converter_init();