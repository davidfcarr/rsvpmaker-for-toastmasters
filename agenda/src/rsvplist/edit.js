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
import { useBlockProps } from '@wordpress/block-editor';

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

const { PanelBody, SelectControl } = wp.components;
const { InspectorControls } = wp.blockEditor;
const { Component, Fragment } = wp.element;

export default function Edit({ attributes, setAttributes, isSelected, className }) {
	//const props = useBlockProps();
	const { src } = attributes;
	
	return (
		<div {...useBlockProps()}>
		<div className={ className }>
    <h3>Registered Guests</h3>
    <ul class="rsvplist">
        <li>Guest One</li>
        <li>Guest Two</li>
    </ul>
		</div>
		</div>
	);
}
