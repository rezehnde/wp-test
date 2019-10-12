/* This section of the code registers a new block, sets an icon and a category, and indicates what type of fields it'll include. */
wp.blocks.registerBlockType("wp-test/aboutus-box", {
    title: "About Us Box",
    icon: "universal-access-alt",
    category: "common",
    attributes: {
        title: { type: "string" },
        content: {
            type: 'array',
            source: 'children',
            selector: 'p',
        },
        image: {
            type: "string",
            source: "attribute",
            selector: "img",
            attribute: "src"
        }
    },

    /* This configures how the content and color fields will work, and sets up the necessary elements */
    edit: function(props) {
        function updateTitle(event) {
            props.setAttributes({ title: event.target.value });
        }
        function updateContent(event) {
            props.setAttributes({ content: event.target.value });
        }
        function updateImage(value) {
            props.setAttributes({ image: event.target.value });
        }
        return React.createElement(
            "div",
            null,
            React.createElement("h3", null, "About Us Box"),
            React.createElement("input", {
                type: "text",
                value: props.attributes.title,
                onChange: updateTitle
            }),
            React.createElement("input", {
                type: "text",
                value: props.attributes.content,
                onChange: updateContent
            })
        );
    },
    save: function(props) {
        return wp.element.createElement(
            "h3",
            { style: { border: "3px solid " + props.attributes.color } },
            props.attributes.content
        );
    }
});
