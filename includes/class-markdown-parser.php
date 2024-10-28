<?php
class Markdown_Parser {
    public function parse($markdown) {
        if (!class_exists('Parsedown')) {
            require_once plugin_dir_path(__DIR__) . 'vendor/parsedown/Parsedown.php';
        }
        
        $parsedown = new Parsedown();
        return $parsedown->text($markdown);
    }

    public function extract_metadata($markdown) {
        $metadata = array();
        $pattern = '/^---\s*\n(.*?)\n---\s*\n/s';
        
        if (preg_match($pattern, $markdown, $matches)) {
            $yaml_content = $matches[1];
            
            if (function_exists('yaml_parse')) {
                // 使用 PHP YAML 扩展
                $metadata = yaml_parse($yaml_content);
            } else {
                // 降级使用简单的键值对解析
                $lines = explode("\n", $yaml_content);
                foreach ($lines as $line) {
                    if (strpos($line, ':') !== false) {
                        list($key, $value) = array_map('trim', explode(':', $line, 2));
                        $metadata[$key] = $value;
                    }
                }
            }
        }
        
        return $metadata;
    }
}