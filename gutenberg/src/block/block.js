/**
 * BLOCK: wpt
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

//  Import CSS.
import './style.scss';
import './editor.scss';

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks
const { RichText } = wp.blockEditor;
const { Component, Fragment } = wp.element;
const { InspectorControls, PanelBody } = wp.editor;
const { TextareaControl, SelectControl } = wp.components;
import { __experimentalNumberControl as NumberControl } from '@wordpress/components';
const { subscribe } = wp.data;

var agenda = [];
function agenda_update() {
	let geturl = wpt_rest.url+'rsvptm/v1/tweak_times?post_id='+wpt_rest.post_id;
	fetch(geturl, {
		method: 'GET',
		headers: {
		  'Content-Type': 'application/json',
		  'X-WP-Nonce': wpt_rest.nonce,
		},
	  })
	  .then(response => response.json())
	  .then(data => {
		  agenda = data;
	})
	.catch((error) => {
	  console.error('Error:', error);
	});	
}

agenda_update();

/**
 * Register: aa Gutenberg Block.
 *
 * Registers a new block provided a unique name and an object defining its
 * behavior. Once registered, the block is made editor as an option to any
 * editor interface where blocks are implemented.
 *
 * @link https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */

registerBlockType( 'wp4toastmasters/agendanoterich2', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'Toastmasters Agenda Note' ), // Block title.
	icon: 'admin-comments', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	description: __('Displays "stage directions" for the organization of your meetings.','rsvpmaker'),
	keywords: [
		__( 'Toastmasters' ),
		__( 'Agenda' ),
		__( 'Rich Text' ),
	],
attributes: {
        content: {
            type: 'array',
            source: 'children',
            selector: 'p',
        },
        time_allowed: {
            type: 'string',
            default: '0',
        },
		uid: {
			type: 'string',
			default: '',
		},
		timing_updated: {
			type: 'int',
			default: agenda,
		},
    },

    edit: function( props ) {	

	const { attributes, attributes: { time_allowed }, className, setAttributes, isSelected } = props;
	var uid = props.attributes.uid;
	if(!uid)
		{
			var date = new Date();
			uid = 'note' + date.getTime()+Math.random();
			setAttributes({uid});
		}	
	return (
<Fragment>
<NoteInspector { ...props } />	
<div className={ props.className }>
<p><strong>Toastmasters Agenda Note</strong> <em>Timing: See sidebar</em></p>
<RichText
	tagName="p"
	value={attributes.content}
	multiline=' '
	onChange={(content) => setAttributes({ content })}
/></div>
</Fragment>
);
	
    },
    save: function( { attributes, className } ) {
		//return null;
		return <RichText.Content tagName="p" value={ attributes.content } className={className} />;
    }
});

registerBlockType( 'wp4toastmasters/signupnote', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'Toastmasters Signup Form Note' ), // Block title.
	icon: 'admin-comments', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	description: __('A text block that appears only on the signup form, not on the agenda.'),
	keywords: [
		__( 'Toastmasters' ),
		__( 'Signup' ),
		__( 'Rich Text' ),
	],
attributes: {
        content: {
            type: 'array',
            source: 'children',
            selector: 'p',
        },
    },

    edit: function( props ) {	
	const { attributes, setAttributes } = props;

	return (<Fragment>
		<DocInspector />	
		<div className={ props.className }>
				<strong>Toastmasters Signup Form Note</strong><RichText
                tagName="p"
                className={props.className}
                value={props.attributes.content}
                onChange={(content) => setAttributes({ content })}
            />
			</div>
			</Fragment>
);
	
    },
    save: function(props) {
	
    return <RichText.Content tagName="p" value={ props.attributes.content } className={props.className} />;
    }

} );

registerBlockType( 'wp4toastmasters/role', {
	// Role [toastmaster role="Toastmaster of the Day" count="1" agenda_note="Introduces supporting roles. Leads the meeting." time="" time_allowed="2" padding_time="0" ]

	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'Toastmasters Agenda Role' ), // Block title.
	icon: 'groups', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	description: __('Defines a meeting role that will appear on the signup form and the agenda.'),
	keywords: [
		__( 'Toastmasters' ),
		__( 'Agenda' ),
		__( 'Role' ),
	],
attributes: {
        role: {
            type: 'string',
            default: '',
        },
        custom_role: {
            type: 'string',
            default: '',
        },
        count: {
            type: 'int',
            default: 1,
        },
        start: {
            type: 'int',
            default: 1,
        },
        agenda_note: {
            type: 'string',
            default: '',
        },
        time_allowed: {
            type: 'string',
            default: '0',
        },
		timing_updated: {
			type: 'int',
			default: 0,
		},
        padding_time: {
            type: 'string',
            default: '0',
        },
        backup: {
            type: 'string',
            default: '',
        },
    },
	edit: function( props ) {
	const { attributes: { role, custom_role, count, start, agenda_note, time_allowed, padding_time, backup }, setAttributes, isSelected } = props;

	function showHideOptions () {
		const selected = document.querySelector( '#role option:checked' );
		if(selected.value == 'custom')
			customline.style = 'display: block;';
		else
			{
			document.getElementById('custom_role').value = '';
			customline.style = 'display: none;';
			}
	}

	function setRole() {
		const selected = event.target.querySelector( '#role option:checked' );
		setAttributes( { role: selected.value } );
		var customline = document.getElementById('customline');
		showHideOptions();
		
		event.preventDefault();
		}
	function setCustomRole( event ) {
		var roleinput = document.getElementById('custom_role').value;
		setAttributes( { custom_role: roleinput } );
		event.preventDefault();
	}

		function showForm() {
		if(!isSelected)
			return (<em> Click to show options</em>);
return (<form onSubmit={ setRole, setCustomRole } >
<div><label>Role:</label> 
<select id="role" value={ role } onChange={ setRole }>
<option value=""></option>
<option value="custom">Custom Role</option>
<option value="Ah Counter">Ah Counter</option>
<option value="Body Language Monitor">Body Language Monitor</option>
<option value="Evaluator">Evaluator</option>
<option value="General Evaluator">General Evaluator</option>
<option value="Grammarian">Grammarian</option>
<option value="Humorist">Humorist</option>
<option value="Speaker">Speaker</option>
<option value="Backup Speaker">Backup Speaker</option>
<option value="Topics Master">Topics Master</option>
<option value="Table Topics">Table Topics</option>
<option value="Timer">Timer</option>
<option value="Toastmaster of the Day">Toastmaster of the Day</option>
<option value="Vote Counter">Vote Counter</option>
<option value="Contest Chair">Contest Chair</option>
<option value="Contest Master">Contest Master</option>
<option value="Chief Judge">Chief Judge</option>
<option value="Ballot Counter">Ballot Counter</option>
<option value="Contestant">Contestant</option>
</select>			
</div>
<p id="customline"><label>Custom Role:</label> <input type="text" id="custom_role" onChange={setCustomRole} defaultValue={custom_role} /></p>
<div>
</div>

</form>
);		
		}
		
		return (			
<Fragment>
<RoleInspector { ...props } />
<div className={ props.className }>
<strong>Toastmasters Role {role} {custom_role}</strong>
{isSelected && <em>More options: see sidebar</em>}
{showForm()}
</div>
</Fragment>
		);
	},
    save: function (props) { return null; },

} );

registerBlockType( 'wp4toastmasters/agendaedit', {

	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'Toastmasters Editable Note' ), // Block title.
	icon: 'welcome-write-blog', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [
		__( 'Toastmasters' ),
		__( 'Agenda' ),
		__( 'Editable' ),
	],
	description: __('A note that can be edited by a meeting organizer'),
	attributes: {
        editable: {
            type: 'string',
            default: '',
        },
		uid: {
			type: 'string',
			default: '',
		},
		time_allowed: {
			type: 'string',
			default: '0',
		},
		timing_updated: {
			type: 'int',
			default: 0,
		},
    },
	edit: function( props ) {

	const { attributes: { editable }, setAttributes, isSelected } = props;

	var uid = props.attributes.uid;
	if(!uid)
		{
			var date = new Date();
			uid = 'editable' + date.getTime()+Math.random();					
			setAttributes({uid});
		}		
	function setAgendaEdit( event ) {
		var note = document.getElementById('editable').value;
		setAttributes( { editable: note } );
		event.preventDefault();
	}	
	function showForm() {
	if(!isSelected)
		return (<p><em>Select to set title</em></p>);
return (<form onSubmit={ setAgendaEdit } >
<p><label>Editable Note Title:</label> <input type="text" id="editable" onChange={setAgendaEdit} defaultValue={editable} /></p>
<p>Enter the title for a note that can be changed for each meeting the meeting. <em>Example: Meeting Theme.</em></p></form>);		
		}
		
		return (
			<Fragment>
			<NoteInspector { ...props } />
<div className={ props.className }>
<p class="dashicons-before dashicons-welcome-write-blog"><strong>Toastmasters Editable Note</strong></p>
{ showForm() }
</div>
</Fragment>
		);
	},
    save: function (props) { return null; },

} ); 

registerBlockType( 'wp4toastmasters/absences', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'Toastmasters Absences' ), // Block title.
	icon: 'admin-comments', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [
		__( 'Toastmasters' ),
		__( 'Agenda' ),
		__( 'Absences' ),
	],
	description: __('A button on the signup form where members can record a planned absence.'),
	attributes: {
       show_on_agenda: {
            type: 'int',
            default: 0,
        },
    },
    edit: function( props ) {	
	const { attributes: { show_on_agenda }, setAttributes, isSelected } = props;

	function setShowOnAgenda() {
		const selected = event.target.querySelector( '#show_on_agenda option:checked' );
		setAttributes( { show_on_agenda: selected.value } );
		event.preventDefault();		
	}
	function showForm() {
return (<form onSubmit={ setShowOnAgenda } >
<label>Show on Agenda?</label> <select id="show_on_agenda" value={ show_on_agenda } onChange={ setShowOnAgenda }>
<option value="0">No</option>
<option value="1">Yes</option>
</select></form>);		
		}

	return (
		<Fragment>
		<DocInspector />
		<div className={ props.className }>
				<strong>Toastmasters Absences</strong> placeholder for widget that tracks planned absences
			{showForm()}
			</div>
		</Fragment>
);
	
    },
    save: function(props) {
    return null;
    }
} ); 

class RoleInspector extends Component {

	render() {
		const { attributes, setAttributes, className } = this.props;
		const { count, start, time_allowed, padding_time, agenda_note, backup, role } = attributes;
		//console.log(timing);
		const updateindex = role.replace(/ /g,'_') + start;	

		let wasSavingPost = wp.data.select( 'core/editor' ).isSavingPost();
		let wasAutosavingPost = wp.data.select( 'core/editor' ).isAutosavingPost();
		let wasPreviewingPost = wp.data.select( 'core/editor' ).isPreviewingPost();
		// determine whether to show notice
		subscribe( () => {
			const isSavingPost = wp.data.select( 'core/editor' ).isSavingPost();
			const isAutosavingPost = wp.data.select( 'core/editor' ).isAutosavingPost();
			const isPreviewingPost = wp.data.select( 'core/editor' ).isPreviewingPost();
			const hasActiveMetaBoxes = wp.data.select( 'core/edit-post' ).hasMetaBoxes();
			
			// Save metaboxes on save completion, except for autosaves that are not a post preview.
			const shouldTrigger = (
					( wasSavingPost && ! isSavingPost && ! wasAutosavingPost ) ||
					( wasAutosavingPost && wasPreviewingPost && ! isPreviewingPost )
				);
	
			// Save current state for next inspection.
			wasSavingPost = isSavingPost;
			wasAutosavingPost = isAutosavingPost;
			wasPreviewingPost = isPreviewingPost;
	
			if ( shouldTrigger ) {
				let geturl = wpt_rest.url+'rsvptm/v1/tweak_times?post_id='+wpt_rest.post_id;
				fetch(geturl, {
					method: 'GET',
					headers: {
					  'Content-Type': 'application/json',
					  'X-WP-Nonce': wpt_rest.nonce,
					},
				  })
				  .then(response => response.json())
				  .then(data => {
					  agenda = data;
					  setAttributes({timing_updated: Date.now()});
				})
				.catch((error) => {
				  console.error('Error:', error);
				});			
	}
	} );

return (	
<InspectorControls key="roleinspector">
<p>Role: {role}</p>
<div style={ {width: '60%'} }>	<NumberControl
		label={ __( 'Count', 'rsvpmaker-for-toastmasters' ) }
		value={ count }
		onChange={ ( count ) => setAttributes( { count } ) }
	/>
	</div>
<div>
<p><em><strong>Count</strong> sets multiple instances of a role like Speaker or Evaluator.</em></p>
</div>
{
(role == 'Speaker') && 
<div>
<div style={{width: '45%', float: 'left'}}>
					<NumberControl
							label={ __( 'Time Allowed', 'rsvpmaker-for-toastmasters' ) }
							value={ time_allowed }
							min={0}
							onChange={ ( time_allowed ) => setAttributes({ time_allowed }) }//  setAttributes( { time_allowed } ) }
						/>
</div>
<div style={{width: '45%', float: 'left', marginLeft: '5%' }}>
			<NumberControl
				label={ __( 'Padding Time', 'rsvpmaker-for-toastmasters' ) }
				min={0}
				value={ padding_time }
				onChange={ ( padding_time ) => setAttributes({ padding_time }) }
			/>
</div>
<p><em><strong>Time Allowed</strong>: Total minutes allowed on the agenda. In the case of speeches, limits the time that can be booked for speeches without a warning. Example: 24 minutes for 3 speeches, one of which might be longer than 7 minutes.</em></p>
<p><em><strong>Padding Time</strong>: Typical use is extra time for introductions, beyond the time allowed for speeches.</em></p>
</div>
}
{
(role != 'Speaker') && 
<div>
					<NumberControl
							label={ __( 'Time Allowed', 'rsvpmaker-for-toastmasters' ) }
							min={0}
							value={ time_allowed }
							onChange={ ( time_allowed ) => setAttributes({ time_allowed }) }//  setAttributes( { time_allowed } ) }
						/>
<p><em><strong>Time Allowed</strong>: Total minutes allowed on the agenda. In the case of speeches, limits the time that can be booked for speeches without a warning. Example: 24 minutes for 3 speeches, one of which might be longer than 7 minutes.</em></p>
</div>
}
<div>
<p><strong>Timing Summary</strong> - refreshes on Save Draft/Publish/Update</p>
<p>See also: <a href={wp.data.select('core/editor').getPermalink()+'??tweak_times=1'}>{__('Agenda Time Planner','rsvpmaker')}</a></p>
<p>{agenda.map(function (x) {return <div><strong>{x.time}</strong> {x.label}</div>})}</p>
</div>

<TextareaControl
        label="Agenda Note"
        help="A note that appears immediately below the role on the agenda and signup form"
        value={ agenda_note }
        onChange={ ( agenda_note ) => setAttributes( { agenda_note: fix_quotes_in_note(agenda_note) } ) }
    />
<SelectControl
				label={ __( 'Backup for this Role', 'rsvpmaker-for-toastmasters' ) }
				value={ backup }
				onChange={ ( backup ) => setAttributes( { backup } ) }
				options={ [{value: '0', label: 'No'},{value: '1', label: 'Yes'}] }
			/>
{docContent ()}
</InspectorControls>
		);
	}
}

function fix_quotes_in_note(agenda_note) {
	agenda_note = agenda_note.replace('"','\u0026quot;');
	agenda_note = agenda_note.replace('\u0022','\u0026quot;');
	return agenda_note;
}

function docContent () {
	return (<div><p><a href="https://wp4toastmasters.com/knowledge-base/toastmasters-meeting-templates-and-meeting-events/" target="_blank">{__('Agenda Setup Documentation','rsvpmaker')}</a></p>
	<p>Add additional agenda notes roles and other elements by clicking the + button (top left of the screen or adjacent to other blocks of content). If the appropriate blocks aren't visible, start typing "toastmasters" in the search blank as shown below.</p>
	<p><img src="/wp-content/plugins/rsvpmaker-for-toastmasters/images/gutenberg-blocks.png" /></p>
	<p>Most used agenda content blocks:</p>
	<ul>
	<li><a target="_blank" href="https://wp4toastmasters.com/knowledge-base/add-or-edit-an-agenda-role/">Agenda Role</a></li><li><a target="_blank" href="https://wp4toastmasters.com/knowledge-base/add-an-agenda-note/">Agenda Note</a></li><li><a target="_blank" href="https://wp4toastmasters.com/knowledge-base/editable-agenda-blocks/">Editable Note</a></li><li><a target="_blank" href="https://wp4toastmasters.com/2018/04/11/tracking-planned-absences-agenda/">Toastmasters Absences</a></li>
	</ul></div>);
}

class NoteInspector extends Component {

	render() {

		const { attributes, setAttributes, className } = this.props;
		const { time_allowed, uid } = attributes;

		let wasSavingPost = wp.data.select( 'core/editor' ).isSavingPost();
		let wasAutosavingPost = wp.data.select( 'core/editor' ).isAutosavingPost();
		let wasPreviewingPost = wp.data.select( 'core/editor' ).isPreviewingPost();
		// determine whether to show notice
		subscribe( () => {
			const isSavingPost = wp.data.select( 'core/editor' ).isSavingPost();
			const isAutosavingPost = wp.data.select( 'core/editor' ).isAutosavingPost();
			const isPreviewingPost = wp.data.select( 'core/editor' ).isPreviewingPost();
			const hasActiveMetaBoxes = wp.data.select( 'core/edit-post' ).hasMetaBoxes();
			
			// Save metaboxes on save completion, except for autosaves that are not a post preview.
			const shouldTrigger = (
					( wasSavingPost && ! isSavingPost && ! wasAutosavingPost ) ||
					( wasAutosavingPost && wasPreviewingPost && ! isPreviewingPost )
				);
	
			// Save current state for next inspection.
			wasSavingPost = isSavingPost;
			wasAutosavingPost = isAutosavingPost;
			wasPreviewingPost = isPreviewingPost;
	
			if ( shouldTrigger ) {
				let geturl = wpt_rest.url+'rsvptm/v1/tweak_times?post_id='+wpt_rest.post_id;
				console.log(geturl);
				fetch(geturl, {
					method: 'GET',
					headers: {
					  'Content-Type': 'application/json',
					  'X-WP-Nonce': wpt_rest.nonce,
					},
				  })
				  .then(response => response.json())
				  .then(data => {
					  agenda = data;
					  setAttributes({timing_updated: Date.now()});
				})
				.catch((error) => {
				  console.error('Error:', error);
				});			
	}
	} );

		return (
		<InspectorControls key="noteinspector">
			<NumberControl
					label={ __( 'Time Allowed', 'rsvpmaker-for-toastmasters' ) }
					min={0}
					value={ time_allowed }
					onChange={ ( time_allowed ) => setAttributes({ time_allowed }) }
				/>
<p><strong>Timing Summary</strong> - refreshes on Save Draft/Publish/Update</p>
<p>See also: <a href={wp.data.select('core/editor').getPermalink()+'??tweak_times=1'}>{__('Agenda Time Planner','rsvpmaker')}</a></p>
<p>{agenda.map(function (x) {return <div><strong>{x.time}</strong> {x.label}</div>})}</p>
{docContent ()}
			</InspectorControls>
		);
	}
}

class DocInspector extends Component {

	render() {

		return (
		<InspectorControls key="docinspector">
{docContent ()}
			</InspectorControls>
		);
	}
}
