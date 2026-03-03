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

import { RichText } from '@wordpress/block-editor';
import { __experimentalNumberControl as NumberControl } from '@wordpress/components';
import TimeBlock from '../TimeBlock.js';

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

export default function Edit({ attributes, attributes: { uid, time_allowed }, setAttributes, isSelected, className, clientId }) {

	if(!uid)

		{

			var date = new Date();

			uid = 'note' + date.getTime()+Math.random();

			setAttributes({uid});

		}	

	return (

<div { ...useBlockProps() }>
<TimeBlock clientId={clientId} />

<p><strong>Toastmasters Agenda Note</strong></p>

<RichText

	tagName="p"

	value={attributes.content}

	onChange={(content) => setAttributes({ content })}

/>

{isSelected && <div>

	<p><em>Options: see sidebar to set timing</em></p>

</div>}

<InspectorControls>

	<div>
	<NumberControl

			label={ __( 'Time Allowed', 'rsvpmaker-for-toastmasters' ) }

			value={ time_allowed }

			min={0}

			onChange={ ( time_allowed ) => setAttributes({ time_allowed }) }

		/>

	</div>
	<p><strong>Time Allowed</strong>: Minutes allowed on the agenda.</p>	
</InspectorControls>

</div>
	);
}
