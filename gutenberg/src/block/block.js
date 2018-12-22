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
const { RichText } = wp.editor;

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
            default: '',
        },
		uid: {
			type: 'string',
			default: '',
		},
    },

    edit: function( props ) {	

	const { attributes, attributes: { time_allowed }, className, setAttributes, isSelected } = props;
	var uid = props.attributes.uid;
	if(!uid)
		{
			var date = new Date();
			uid = 'note' + date.getTime();
			setAttributes({uid});
		}
	
	function setTime( event ) {
		const selected = event.target.querySelector( '#time_allowed option:checked' );
		setAttributes( { time_allowed: selected.value } );
		event.preventDefault();
	}		
	
	return (<div className={ props.className }>
<form onSubmit={ setTime } ><strong>Toastmasters Agenda Note</strong> <select id="time_allowed"  value={ time_allowed } onChange={ setTime }>
<option value="">Minutes Allowed (optional)</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
<option value="30">30</option>
<option value="31">31</option>
<option value="32">32</option>
<option value="33">33</option>
<option value="34">34</option>
<option value="35">35</option>
<option value="36">36</option>
<option value="37">37</option>
<option value="38">38</option>
<option value="39">39</option>
<option value="40">40</option>
<option value="41">41</option>
<option value="42">42</option>
<option value="43">43</option>
<option value="44">44</option>
<option value="45">45</option>
<option value="46">46</option>
<option value="47">47</option>
<option value="48">48</option>
<option value="49">49</option>
<option value="50">50</option>
<option value="51">51</option>
<option value="52">52</option>
<option value="53">53</option>
<option value="54">54</option>
<option value="55">55</option>
<option value="56">56</option>
<option value="57">57</option>
<option value="58">58</option>
<option value="59">59</option>
<option value="60">59</option>
</select></form>
<RichText
	tagName="p"
	value={attributes.content}
	multiline=' '
	onChange={(content) => setAttributes({ content })}
/></div>);
	
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

	return (<div className={ props.className }>
				<strong>Toastmasters Signup Form Note</strong><RichText
                tagName="p"
                className={props.className}
                value={props.attributes.content}
                onChange={(content) => setAttributes({ content })}
            />
			</div>
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
        agenda_note: {
            type: 'string',
            default: '',
        },
        time_allowed: {
            type: 'string',
            default: '',
        },
        padding_time: {
            type: 'string',
            default: '',
        },
    },
	edit: function( props ) {

	const { attributes: { role, custom_role, count, agenda_note, time_allowed, padding_time }, setAttributes, isSelected } = props;

	function showHideOptions () {
		const selected = document.querySelector( '#role option:checked' );
		if(selected.value == 'custom')
			customline.style = 'display: block;';
		else
			{
			document.getElementById('custom_role').value = '';
			customline.style = 'display: none;';
			}
		var paddingline = document.getElementById('paddingline');
		
		if(selected.value == 'Speaker')
			paddingline.style = 'display: block;';
		else
			{
			paddingline.style = 'display: none;';
			}
	}

	function setRole() {
		const selected = event.target.querySelector( '#role option:checked' );
		setAttributes( { role: selected.value } );
		var customline = document.getElementById('customline');
		showHideOptions();
		
		event.preventDefault();
		}
	function setTime( event ) {
		const selected = event.target.querySelector( '#time_allowed option:checked' );
		setAttributes( { time_allowed: selected.value } );
		event.preventDefault();
	}	
	function setCustomRole( event ) {
		var roleinput = document.getElementById('custom_role').value;
		setAttributes( { custom_role: roleinput } );
		event.preventDefault();
	}
	function setCount( event ) {
		const selected = event.target.querySelector( '#count option:checked' );
		setAttributes( { count: selected.value } );
		event.preventDefault();
	}	
	function setAgendaNote( event ) {
		var note = document.getElementById('agenda_note').value;
		setAttributes( { agenda_note: note } );
		event.preventDefault();
	}	
	function setPaddingTime( event ) {
		const selected = event.target.querySelector( '#padding_time option:checked' );
		setAttributes( { padding_time: selected.value } );
		event.preventDefault();
	}
		
	function showPaddingTime () {
		
		return (<div id="paddingline">
			<label>Padding Time:</label> <select id="padding_time"  value={ padding_time } onChange={ setPaddingTime }>
						<option value="">Minutes Allowed (optional)</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
</select>
<br /><em>Typical use: extra time for introductions, beyond the time allowed for speeches</em>
</div>);
	}

		function showForm() {
		if(!isSelected)
			return (<em> Click to show options</em>);
return (<form onSubmit={ setRole, setCustomRole, setCount, setTime, setPaddingTime, setAgendaNote } >
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
<div>			<label>Count:</label> <select id="count"  value={ count } onChange={ setCount }>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
</select>
</div>
			
<div>			<label>Time Allowed:</label> <select id="time_allowed"  value={ time_allowed } onChange={ setTime }>
						<option value="">Minutes Allowed (optional)</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
<option value="30">30</option>
<option value="31">31</option>
<option value="32">32</option>
<option value="33">33</option>
<option value="34">34</option>
<option value="35">35</option>
<option value="36">36</option>
<option value="37">37</option>
<option value="38">38</option>
<option value="39">39</option>
<option value="40">40</option>
<option value="41">41</option>
<option value="42">42</option>
<option value="43">43</option>
<option value="44">44</option>
<option value="45">45</option>
<option value="46">46</option>
<option value="47">47</option>
<option value="48">48</option>
<option value="49">49</option>
<option value="50">50</option>
<option value="51">51</option>
<option value="52">52</option>
<option value="53">53</option>
<option value="54">54</option>
<option value="55">55</option>
<option value="56">56</option>
<option value="57">57</option>
<option value="58">58</option>
<option value="59">59</option>
<option value="60">59</option>
</select>
<br /><em>Total time allowed. If you have three speakers, you might allow 24 minutes or more to allow for two 7-minute speeches, plus a slightly longer one.</em>
</div>
{showPaddingTime()}
<p><label>Agenda Note:</label> <input type="text" id="agenda_note" onChange={setAgendaNote} defaultValue={agenda_note} /></p>

</form>);		
		}
		
		return (
<div className={ props.className }>
<strong>Toastmasters Role {role} {custom_role}</strong>
{ showForm() }
</div>
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
attributes: {
        editable: {
            type: 'string',
            default: '',
        },
		uid: {
			type: 'string',
			default: '',
		},	
    },
	edit: function( props ) {

	const { attributes: { editable }, setAttributes, isSelected } = props;

	var uid = props.attributes.uid;
	if(!uid)
		{
			if(editable)
				uid = editable;
			else
				{
				var date = new Date();
				uid = 'editable' + date.getTime();					
				}
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
<div className={ props.className }>
<p class="dashicons-before dashicons-welcome-write-blog"><strong>Toastmasters Editable Note</strong></p>
{ showForm() }
</div>
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

	return (<div className={ props.className }>
				<strong>Toastmasters Absences</strong> placeholder for widget that tracks planned absences
			{showForm()}
			</div>
);
	
    },
    save: function(props) {
    return null;
    }
} ); 