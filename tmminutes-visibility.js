( function ( wp ) {
	const { __ } = wp.i18n;
	const { RadioControl } = wp.components;
	const { createElement: el } = wp.element;
	const { PluginDocumentSettingPanel } = wp.editPost;
	const { registerPlugin } = wp.plugins;
	const { withDispatch, withSelect } = wp.data;

	const VisibilityPanel = withSelect( ( select ) => {
		const editor = select( 'core/editor' );
		const meta = editor.getEditedPostAttribute( 'meta' ) || {};

		return {
			postType: editor.getCurrentPostType(),
			value: meta.tm_visibility || 'default',
		};
	} )(
		withDispatch( ( dispatch ) => {
			return {
				setValue( value ) {
					const meta = wp.data.select( 'core/editor' ).getEditedPostAttribute( 'meta' ) || {};
					dispatch( 'core/editor' ).editPost( {
						meta: {
							...meta,
							tm_visibility: value,
						},
					} );
				},
			};
		} )( ( props ) => {
			if ( 'tmminutes' !== props.postType ) {
				return null;
			}

			return el(
				PluginDocumentSettingPanel,
				{
					name: 'wp4t-tmminutes-visibility',
					title: __( 'Visibility', 'rsvpmaker-for-toastmasters' ),
				},
				el( RadioControl, {
					label: __( 'Who can view this document on the front end?', 'rsvpmaker-for-toastmasters' ),
					selected: props.value,
					options: [
						{
							label: __( 'Default member access', 'rsvpmaker-for-toastmasters' ),
							value: 'default',
						},
						{
							label: __( 'Public', 'rsvpmaker-for-toastmasters' ),
							value: 'public',
						},
						{
							label: __( 'Editors only', 'rsvpmaker-for-toastmasters' ),
							value: 'editors',
						},
					],
					onChange: props.setValue,
				} )
			);
		} )
	);

	registerPlugin( 'wp4t-tmminutes-visibility', {
		render: VisibilityPanel,
	} );
} )( window.wp );