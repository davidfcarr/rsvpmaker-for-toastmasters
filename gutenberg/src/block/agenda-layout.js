/**
 * BLOCK: rsvpmaker-for-toastmasters agenda wrapper
 *
 */

//  Import CSS.
import './style.scss';
import './editor.scss';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { InnerBlocks} = wp.editor;
const { FormToggle } = wp.components;

if((typeof toastmasters_special !== 'undefined') && (toastmasters_special == 'Agenda Layout'))
{ // only initialize these blocks for Agenda Layout document
registerBlockType( 'wp4toastmasters/agenda-wrapper', {
	title: ( 'Agenda Layout Wrapper' ), // Block title.
	icon: 'admin-comments', 
	category: 'layout',
	keywords: [
		( 'Toastmasters' ),
		( 'Agenda' ),
		( 'Wrapper' ),
	],
attributes: {
	sidebar: {
		type: 'boolean',
		default: true,
	},
},

    edit: function( props ) {	
	const TEMPLATE = [ ['wp4toastmasters/agendasidebar'] ];
	const { attributes, className, setAttributes, isSelected } = props;

	if(attributes.sidebar)
	return (
		<div className={className}>
		<table id="agenda-main" width="700">
<tbody>
<tr>
<td id="agenda-sidebar" width="175">
<InnerBlocks template={TEMPLATE} />
</td>
<td id="agenda-main" width="*">Placeholder for role info, agenda notes, etc. {rsvpmaker_ajax.special}
<p>Include sidebar: <FormToggle checked={attributes.sidebar} 
		onChange={ function(  ) {
				setAttributes( {sidebar: !attributes.sidebar} );
		} }	
/></p>
</td>
</tr>
</tbody>
</table>
	</div>
		);
	// no sidebar
	return (
			<div className={className}>
Placeholder for role info, agenda notes, etc.
	<p>Include sidebar: <FormToggle checked={attributes.sidebar} 
			onChange={ function(  ) {
					setAttributes( {sidebar: !attributes.sidebar} );
			} }	
	/></p>
		</div>
			);	
    },
    save: function( { attributes, className } ) {
	if(attributes.sidebar)
		return <div className={className}>
		<table id="agenda-main" width="700">
<tbody>
<tr>
<td id="agenda-sidebar" width="175">
<InnerBlocks.Content />
</td>
<td id="agenda-main" width="*">[tmlayout_main]</td>
</tr>
</tbody>
</table>
	</div>;
	//no sidebar
	return <div className={className}>
[tmlayout_main]
</div>;


    }
});

registerBlockType( 'wp4toastmasters/agendasidebar', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'Agenda Sidebar' ), // Block title.
	icon: 'admin-comments', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [
		__( 'Toastmasters' ),
		__( 'Agenda' ),
		__( 'Sidebar' ),
	],
	description: __('Placeholder for sidebar content in the agenda layout. Includes officer listing if specified in Settings -> Toastmasters.'),
    edit: function( props ) {	

	return (
		<div className="agendaplaceholder">Placeholder: sidebar content</div>
);
	
    },
    save: function(props) {
    return null;
    }
} ); 

registerBlockType( 'wp4toastmasters/agendamain', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'Agenda Main Content' ), // Block title.
	icon: 'admin-comments', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [
		__( 'Toastmasters' ),
		__( 'Agenda' ),
		__( 'Main' ),
	],
	description: __('Placeholder for main content (roles and agenda notes) in the agenda layout'),
    edit: function( props ) {	

	return (
		<div className="agendaplaceholder">Placeholder: agenda main content</div>
);
	
    },
    save: function(props) {
    return null;
    }
} ); 

	
} // end of check that this is an Agenda Layout document
