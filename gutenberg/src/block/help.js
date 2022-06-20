const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks

registerBlockType( 'wp4toastmasters/help', {
	title: __( 'Toastmasters Agenda Help' ), // Block title.
	icon: 'editor-help', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	description: __('Provides links to help resources within the agenda document'),
	keywords: [
		__( 'Toastmasters' ),
		__( 'Agenda' ),
		__( 'Help' ),
	],
attributes: {
    },
	edit: function( props ) {
	const { isSelected } = props;

		return (			
<div className={ props.className }>
<h2>How to Edit The Agenda - Click for Help</h2>
{isSelected && <div>
    <p>The WordPress for Toastmasters system represents meeting agendas as a series of content blocks that you work with within the same editor used for blog posts and web pages. Although it can include standard content blocks (paragraphs, headings, images), you primarily work with <strong>Role</strong> blocks and a <strong>Note</strong> blocks (the "stage directions" of your meetings). <strong>Event Templates</strong> define an abstract model of a "typical" meeting, contest, or other event, but you can use the same techniques to modify a specific event (for example, to change the number and order of roles for a given meeting).</p>
    <p>For details, see the <a target="_blank" href="https://www.wp4toastmasters.com/knowledge-base/toastmasters-meeting-templates-and-meeting-events/">Knowledge Base articles</a> on the WordPress for Toastmasters website.</p>
    <p>This special help tips block will not appear on the website or your agenda. You can delete it or leave it here to refer back to later. <em>Click anywhere outside of this box to close it.</em></p>
</div>
}
</div>
		);
	},
    save: function (props) { return null; },

} );