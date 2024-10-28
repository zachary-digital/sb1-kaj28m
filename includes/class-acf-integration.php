<?php
class ACF_Integration {
    private $parser;

    public function __construct($parser) {
        $this->parser = $parser;
        add_action('acf/save_post', array($this, 'process_markdown'), 20);
    }

    public function process_markdown($post_id) {
        if (!function_exists('get_field')) {
            return;
        }

        $markdown_content = get_field('markdown_content', $post_id);
        if (!$markdown_content) {
            return;
        }

        $html_content = $this->parser->parse($markdown_content);
        $metadata = $this->parser->extract_metadata($markdown_content);

        // Update ACF fields with parsed content
        update_field('parsed_content', $html_content, $post_id);
        
        if ($metadata) {
            foreach ($metadata as $key => $value) {
                update_field($key, $value, $post_id);
            }
        }
    }
}