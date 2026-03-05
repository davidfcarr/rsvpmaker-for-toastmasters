/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';

const { TextareaControl, SelectControl, ToggleControl, TextControl, ServerSideRender } = wp.components;
import { useSelect } from '@wordpress/data';
import { __experimentalNumberControl as NumberControl } from '@wordpress/components';
import TimeBlock from '../TimeBlock.js';
import { useRsvpmakerRest } from '../useRsvpmakerRest.js';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */

export default function Edit({ attributes, attributes: { role, custom_role, count, start, agenda_note, time_allowed, padding_time, backup }, setAttributes, isSelected, className, clientId }) {
const rsvpmaker_rest = useRsvpmakerRest();
const toast_roles = rsvpmaker_rest.toast_roles;
const toast_role_times = rsvpmaker_rest.toast_role_times;
return (			
<div {...useBlockProps()}>
<TimeBlock clientId={clientId} />
<div className={ className }>
<strong>Toastmasters Role {role} {custom_role} {count > 1 ? `(${count})` : ''}</strong>
</div>

<InspectorControls>
	<SelectControl
	
					label={ __( 'Role', 'rsvpmaker-for-toastmasters' ) }
	
					value={ role }
	
					onChange={ ( role ) => {
						if(toast_role_times && toast_role_times[role]) {
							setAttributes({ time_allowed: count * toast_role_times[role] });
						}
						setAttributes( { role } );
				} }
	
					options={ toast_roles }
	
	/>
	
	
	
	<TextControl
	
			label="Custom Role"
	
			value={ custom_role }
	
			onChange={ ( custom_role ) => setAttributes( { custom_role } ) }
	
	/>
	
	
	
	<div style={ {width: '60%'} }>	<NumberControl
	
			label={ __( 'Count', 'rsvpmaker-for-toastmasters' ) }
	
			value={ count }
	
			onChange={ ( count ) => { setAttributes( { count } ); if(toast_role_times && toast_role_times[role]) { setAttributes({ time_allowed: count * toast_role_times[role] }); } } }
	
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
	
								onChange={ ( time_allowed ) => setAttributes({ time_allowed }) }
	
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
	
</InspectorControls>

</div>
		);
}
