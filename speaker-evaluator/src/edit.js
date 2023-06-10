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
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { RadioControl } from '@wordpress/components';
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
export default function Edit({ attributes, setAttributes }) {
	return (
		<p { ...useBlockProps() }>
			<InspectorControls key="speaker-evaluator-settings">
				<RadioControl label="Columns" selected={attributes.columns} options={[{'label': '2 columns','value': '2'},{'label': 'Separate columns for Speaker, Path, Project, Title','value': '5'}]} onChange={(value) => setAttributes({columns: value})} />
			</InspectorControls>
			{ __(
				'Speaker-Evaluator table for the agenda',
				'speaker-evaluator'
			) }
		</p>
	);
}
