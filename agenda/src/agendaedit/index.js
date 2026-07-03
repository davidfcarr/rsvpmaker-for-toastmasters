/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
import { registerBlockType } from '@wordpress/blocks';
import { createBlock } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';

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

function excerptFirstThreeWords(text, stripHtml = false) {
	if (!text) {
		return '';
	}

	const source = stripHtml ? text.replace(/<[^>]*>/g, ' ') : text;
	const normalized = source.replace(/\s+/g, ' ').trim();
	if (!normalized) {
		return '';
	}

	const words = normalized.split(' ');
	const excerpt = words.slice(0, 3).join(' ');
	return words.length > 3 ? `${excerpt}...` : excerpt;
}

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
registerBlockType( metadata.name, {
	__experimentalLabel: ( attributes ) => {
		const excerpt = excerptFirstThreeWords(attributes?.editable || '');
		if (!excerpt) {
			return __('TM Editable Agenda Note', 'rsvpmaker-for-toastmasters');
		}
		return `${__('TM Editable Agenda Note', 'rsvpmaker-for-toastmasters')}: ${excerpt}`;
	},

	/**
	 * @see ./edit.js
	 */
	edit: Edit,

	/**
	 * @see ./save.js
	 */
	save,

	transforms: {
		from: [
			{
				type: 'block',
				blocks: [ 'wp4toastmasters/agendanoterich2' ],
				transform: ( attributes ) => {
					return createBlock(metadata.name, {
						uid: attributes?.uid || '',
						time_allowed: attributes?.time_allowed || 0,
						editable: '',
						inline: 0,
						defaultContent: attributes?.content || '',
					});
				},
			},
		],
	},
} );
