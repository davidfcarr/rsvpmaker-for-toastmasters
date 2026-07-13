/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
import { registerBlockType } from '@wordpress/blocks';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './style.scss';

/**
 * Internal dependencies
 */
import Edit from './edit';
import save from './save';
import metadata from './block.json';

const migrateLegacyMilestone = ( attributes ) => ( {
	label: attributes?.label || metadata.attributes?.label?.default || 'Meeting ends',
} );

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
registerBlockType( metadata.name, {
	/**
	 * @see ./edit.js
	 */
	edit: Edit,

	/**
	 * @see ./save.js
	 */
	save,

	deprecated: [
		{
			attributes: {
				label: {
					type: 'string',
					source: 'html',
					selector: 'p',
				},
				legacyMaxTime: {
					type: 'string',
					source: 'attribute',
					selector: 'p',
					attribute: 'maxtime',
				},
			},
			migrate: migrateLegacyMilestone,
			save( { attributes: { label, legacyMaxTime } } ) {
				return (
					<div className="wp-block-wp4toastmasters-milestone">
						<p maxtime={ legacyMaxTime || 'x' }>{ label }</p>
					</div>
				);
			},
		},
		{
			attributes: {
				label: {
					type: 'string',
					source: 'html',
					selector: 'p',
				},
				legacyMaxTime: {
					type: 'string',
					source: 'attribute',
					selector: 'p',
					attribute: 'maxtime',
				},
			},
			migrate: migrateLegacyMilestone,
			save( { attributes: { label, legacyMaxTime } } ) {
				return <p maxtime={ legacyMaxTime || 'x' }>{ label }</p>;
			},
		},
		{
			migrate: migrateLegacyMilestone,
			save( { attributes: { label } } ) {
				return (
					<div className="wp-block-wp4toastmasters-milestone">
						<p maxtime="x">{ label }</p>
					</div>
				);
			},
		},
	],
} );
