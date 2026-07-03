/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';
import { useEffect, useRef, useState } from '@wordpress/element';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { RichText } from '@wordpress/block-editor';
import { __experimentalNumberControl as NumberControl, TextControl, ToggleControl } from '@wordpress/components';
import { useEntityProp } from '@wordpress/core-data';
import { useSelect } from '@wordpress/data';
import apiFetch from '@wordpress/api-fetch';
import TimeBlock from '../TimeBlock.js';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

function decodeAgendaHtml(value = '') {
	if (!value || typeof value !== 'string') {
		return '';
	}

	const decoded = value
		.replace(/\\u003c|u003c/gi, '<')
		.replace(/\\u003e|u003e/gi, '>')
		.replace(/\\u0026|u0026/gi, '&')
		.replace(/\\u0022|u0022/gi, '"')
		.replace(/\\u0027|u0027/gi, "'")
		.replace(/\\n/g, "\n")
		.replace(/\\r/g, "\r")
		.replace(/<\/p>\s*n\s*<p/gi, '</p>\n<p');

	return decoded
		.replace(/(<\/p>)(?:\s*<p>(?:\s|&nbsp;|<br\s*\/?\s*>)*<\/p>\s*)+(<p)/gi, '$1$2')
		.replace(/<\/p>\s+<p/gi, '</p><p');
}

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */

export default function Edit({ attributes, attributes: { uid, time_allowed, editable, inline, defaultContent }, setAttributes, isSelected, className, clientId }) {
	const saveTimerRef = useRef();
	const localMetaEditRef = useRef( '' );
	const [ pendingMetaSync, setPendingMetaSync ] = useState( '' );
	const [ fetchedMetaValue, setFetchedMetaValue ] = useState( '' );
	const [ isCheckingMeetingContent, setIsCheckingMeetingContent ] = useState( false );

	const editorContext = useSelect(
		( select ) => ( {
			postType: select( 'core/editor' )?.getCurrentPostType(),
			postId: select( 'core/editor' )?.getCurrentPostId(),
		} ),
		[]
	);

	const [ meta, setMeta ] = useEntityProp(
		'postType',
		editorContext.postType || 'post',
		'meta',
		editorContext.postId || 0
	);

	const isTemplateDoc = editorContext.postType === 'rsvpmaker_template';

	if(!uid)

		{

			var date = new Date();

			uid = 'note' + date.getTime()+Math.random();

			setAttributes({uid});

		}	

	const metaKey = uid ? `agenda_note_${uid}` : '';
	const entityMetaValue = metaKey && meta ? decodeAgendaHtml( meta[ metaKey ] || '' ) : '';
	const apiMetaValue = decodeAgendaHtml( fetchedMetaValue || '' );
	const metaValue = entityMetaValue || apiMetaValue;
	const fallbackValue = decodeAgendaHtml( defaultContent || '' );
	const hasMetaOverride = !isTemplateDoc && metaValue.trim().length > 0 && metaValue.trim() !== fallbackValue.trim();
	const editorValue = hasMetaOverride ? metaValue : fallbackValue;

	const updateContent = ( nextContent ) => {
		setAttributes( { defaultContent: nextContent } );
		localMetaEditRef.current = nextContent;
		setFetchedMetaValue( nextContent );
		setPendingMetaSync( nextContent );

		if ( metaKey && !isTemplateDoc ) {
			setMeta( {
				...( meta || {} ),
				[ metaKey ]: nextContent,
			} );
		}
	};

	useEffect( () => {
		if ( !metaKey || isTemplateDoc || !editorContext.postId ) {
			setIsCheckingMeetingContent( false );
			return;
		}

		setIsCheckingMeetingContent( true );

		apiFetch( {
			path: `/rsvptm/v1/editable_note_json?post_id=${ editorContext.postId }&uid=${ encodeURIComponent( uid ) }`,
			method: 'GET',
		} )
			.then( ( response ) => {
				if ( response && typeof response.note === 'string' && ! localMetaEditRef.current ) {
					setFetchedMetaValue( response.note );
				}
				setIsCheckingMeetingContent( false );
			} )
			.catch( () => {
				setIsCheckingMeetingContent( false );
			} );
	}, [ metaKey, isTemplateDoc, editorContext.postId, uid ] );

	useEffect( () => {
		if ( !pendingMetaSync || !metaKey || isTemplateDoc || !editorContext.postId ) {
			return;
		}

		if ( saveTimerRef.current ) {
			clearTimeout( saveTimerRef.current );
		}

		saveTimerRef.current = setTimeout( () => {
			apiFetch( {
				path: '/rsvptm/v1/editable_note_json',
				method: 'POST',
				data: {
					note: pendingMetaSync,
					uid,
					post_id: editorContext.postId,
					editable,
				},
			} )
				.then( () => {
					localMetaEditRef.current = '';
				} )
				.catch( () => {} );
		}, 700 );

		return () => {
			if ( saveTimerRef.current ) {
				clearTimeout( saveTimerRef.current );
			}
		};
	}, [ pendingMetaSync, metaKey, isTemplateDoc, editorContext.postId, uid, editable ] );

	return (

<div { ...useBlockProps() }>
<TimeBlock clientId={clientId} />
<p class="dashicons-before dashicons-welcome-write-blog"><strong>Toastmasters Agenda Note</strong></p>



<TextControl

        label="HEADING (optional)"

        value={ editable }

        onChange={ ( editable ) => setAttributes( { editable } ) }

    />

<RichText
	tagName="div"
	className="agendaedit-default-content"
	value={ editorValue }
	allowedFormats={ [
		'core/bold',
		'core/italic',
		'core/link',
		'core/strikethrough',
	] }
	onChange={ updateContent }
	placeholder={ __( 'Enter default text (can be overridden with meeting-specific edits on the front end).', 'rsvpmaker-for-toastmasters' ) }
/>

{isCheckingMeetingContent && <p><em>{ __( 'Checking for meeting-specific content ...', 'rsvpmaker-for-toastmasters' ) }</em></p>}

{hasMetaOverride && <p><em>{ __( 'Showing meeting-specific text.', 'rsvpmaker-for-toastmasters' ) }</em></p>}

<InspectorControls>

	<div>
	<NumberControl

			label={ __( 'Time Allowed', 'rsvpmaker-for-toastmasters' ) }

			value={ time_allowed }

			min={0}

			onChange={ ( time_allowed ) => setAttributes({ time_allowed: Math.abs(parseInt(time_allowed)) }) }

		/>
	<ToggleControl

        label="Display inline label, bold, instead of headline"

        help={ inline ? 'Inline Label' : 'Headline' }

        checked={ inline }

        onChange={ (inline) => setAttributes( {inline} ) }

    />

	</div>
	<p><strong>Time Allowed</strong>: Minutes allowed on the agenda.</p>	
</InspectorControls>

</div>
	);
}
