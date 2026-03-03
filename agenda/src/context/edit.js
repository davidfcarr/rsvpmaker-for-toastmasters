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
import { InnerBlocks } from '@wordpress/block-editor';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
const { PanelBody, ToggleControl } = wp.components;

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

export default function Edit({ attributes, attributes: { webContext, emailContext, agendaContext, printContext, anonContext }, setAttributes, isSelected, className, clientId }) {
	return (

<div { ...useBlockProps() }>
	<InspectorControls key="contextcontrols">
		<PanelBody title={ __( 'Display', 'rsvpmaker-for-toastmasters' ) } >
			<ToggleControl
            label="Web / Signup Page"
            help={
                webContext
                    ? 'Show on website / agenda signup view.'
                    : 'Do not show on website / agenda signup view.'
            }
            checked={ webContext }
			onChange={ (webContext) => setAttributes( {webContext} ) }
		/>
			<ToggleControl
            label="Agenda"
            help={
                agendaContext
                    ? 'Show on agenda (email or print).'
                    : 'Do not show on agenda (email or print).'
            }
            checked={ agendaContext }
			onChange={ (agendaContext) => setAttributes( {agendaContext} ) }
		/>
		
		<ToggleControl
            label="Email"
            help={
                emailContext
                    ? 'Show on email agenda.'
                    : 'Do not show on email agenda.'
            }
            checked={ emailContext }
			onChange={ (emailContext) => setAttributes( {emailContext} ) }
		/>

			<ToggleControl
            label="Print"
            help={
                printContext
                    ? 'Show on print agenda.'
                    : 'Do not show on print agenda.'
            }
            checked={ printContext }
			onChange={ (printContext) => setAttributes( {printContext} ) }
		/>
			<ToggleControl
            label="Anonymous Users"
            help={
                anonContext
                    ? 'No login required.'
                    : 'Limit to logged in users and club email notifications.'
            }
            checked={ anonContext }
			onChange={ (anonContext) => setAttributes( {anonContext} ) }
		/>
</PanelBody>
	</InspectorControls>
<div class="context-block-label">CLICK TO SET DISPLAY CONTEXT</div>
	<InnerBlocks />
</div>
	);
}
