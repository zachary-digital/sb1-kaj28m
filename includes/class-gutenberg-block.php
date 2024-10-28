<?php
class Gutenberg_Block {
    private $parser;

    public function __construct($parser) {
        $this->parser = $parser;
        add_action('init', array($this, 'register_block'));
    }

    public function register_block() {
        if (!function_exists('register_block_type')) {
            return;
        }

        wp_register_script(
            'markdown-block',
            plugin_dir_url(__DIR__) . 'assets/js/blocks/markdown-block.js',
            array('wp-blocks', 'wp-element', 'wp-editor')
        );

        register_block_type('markdown-to-acf/markdown-block', array(
            'editor_script' => 'markdown-block',
            'render_callback' => array($this, 'render_block')
        ));
    }

    public function render_block($attributes) {
        if (empty($attributes['markdown'])) {
            return '';
        }

        return sprintf(
            '<div class="markdown-content">%s</div>',
            $this->parser->parse($attributes['markdown'])
        );
    }
}