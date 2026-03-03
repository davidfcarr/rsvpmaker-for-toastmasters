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
import { __experimentalNumberControl as NumberControl, TextControl, ToggleControl } from '@wordpress/components';
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

export default function Edit({ attributes, attributes: { show_on_agenda }, setAttributes, isSelected, className, clientId }) {
	return (

<div { ...useBlockProps() }>

<p><strong>Toastmasters Dues Renewal</strong> - displays the payment form</p>
<p>{__('Payment will be calculated according to the dues schedule set in','rsvpmaker-for-toastmasters')}<br />{__('Settings > TM Member Application','rsvpmaker-for-toastmasters')}</p>
</div>
	);
}
