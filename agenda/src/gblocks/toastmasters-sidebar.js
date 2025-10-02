var el = wp.element.createElement;
const { __ } = wp.i18n; // Import __() from wp.i18n

import { registerPlugin } from '@wordpress/plugins';
import { __experimentalMainDashboardButton as MainDashboardButton } from '@wordpress/edit-post';
import { Dashicon, Button, Modal } from '@wordpress/components';
import { useState } from '@wordpress/element';
const { subscribe } = wp.data;

	let wasSavingPost = wp.data.select( 'core/editor' ).isSavingPost();
	let wasAutosavingPost = wp.data.select( 'core/editor' ).isAutosavingPost();
	let wasPreviewingPost = wp.data.select( 'core/editor' ).isPreviewingPost();
	// determine whether to show notice
	subscribe( () => {
		const isSavingPost = wp.data.select( 'core/editor' ).isSavingPost();
		const isAutosavingPost = wp.data.select( 'core/editor' ).isAutosavingPost();
		const isPreviewingPost = wp.data.select( 'core/editor' ).isPreviewingPost();
		const type = wp.data.select( 'core/editor' ).getCurrentPostType();
		const shouldTriggerTimeNotice = (
				( (type == 'rsvpmaker' || type == 'rsvpmaker_template') && wasSavingPost && ! isSavingPost && ! wasAutosavingPost ) ||
				( wasAutosavingPost && wasPreviewingPost && ! isPreviewingPost )
		);

		// Save current state for next inspection.
		wasSavingPost = isSavingPost;
		wasAutosavingPost = isAutosavingPost;
		wasPreviewingPost = isPreviewingPost;

		if ( shouldTriggerTimeNotice ) {
			const content = wp.data.select( 'core/editor' ).getEditedPostContent();
			const time_required = ( content.match( /"(time_allowed|padding_time)":"(\d+)"/g ) || [] ).reduce( ( total, item ) => {
				const match = item.match( /"(time_allowed|padding_time)":"(\d+)"/ );
				return total + ( match ? parseInt( match[2], 10 ) : 0 );
			}, 0 );
            console.log('time required', time_required);
            const message = time_required ? ( time_required + ' minutes required according to agenda' ) : 'No time required';
            console.log('message', message);
if(time_required > 0)
wp.data.dispatch('core/notices').createNotice(
	'success', // Can be one of: success, info, warning, error.
	__('Agenda Time','rsvpmaker-for-toastmasters'), // Text string to display.
	{
		id: 'toasttimesnack', //assigning an ID prevents the notice from being added repeatedly
		isDismissible: true, // Whether the user can dismiss the notice.
		// Any actions the user can perform.
		type: 'snackbar',
		actions: [
			{
				url: wp.data.select("core/editor").getPermalink(),
				label: message,
			}
		]
	}
);

		}
} );
