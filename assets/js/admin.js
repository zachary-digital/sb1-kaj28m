jQuery(document).ready(function($) {
    // Real-time preview functionality
    const markdownEditor = $('.markdown-editor');
    const previewArea = $('.markdown-preview');

    markdownEditor.on('input', function() {
        const markdown = $(this).val();
        
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'preview_markdown',
                markdown: markdown,
                nonce: markdownToAcf.nonce
            },
            success: function(response) {
                previewArea.html(response.data);
            }
        });
    });

    // Settings page interactions
    $('.markdown-to-acf-settings').on('change', 'input[type="checkbox"]', function() {
        $(this).closest('form').submit();
    });
});