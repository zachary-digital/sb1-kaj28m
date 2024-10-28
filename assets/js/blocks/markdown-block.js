const { registerBlockType } = wp.blocks;
const { RichText } = wp.editor;

registerBlockType('markdown-to-acf/markdown-block', {
    title: 'Markdown Block',
    icon: 'editor-code',
    category: 'common',
    attributes: {
        markdown: {
            type: 'string',
            source: 'text',
        },
    },

    edit: function(props) {
        const { attributes: { markdown }, setAttributes, className } = props;

        return (
            <div className={className}>
                <RichText
                    tagName="pre"
                    value={markdown}
                    onChange={(content) => setAttributes({ markdown: content })}
                    placeholder="Enter markdown content..."
                />
            </div>
        );
    },

    save: function(props) {
        return null; // Dynamic block, render handled by PHP
    },
});