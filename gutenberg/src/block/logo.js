/**
 * BLOCK: block2022
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks
const { PanelBody, SelectControl } = wp.components;
const { InspectorControls } = wp.blockEditor;
const { Component, Fragment } = wp.element;

/**
 * Register: aa Gutenberg Block.
 *
 * Registers a new block provided a unique name and an object defining its
 * behavior. Once registered, the block is made editor as an option to any
 * editor interface where blocks are implemented.
 *
 * @link https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType( 'wp4toastmasters/logo', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'Toastmasters Logo' ), // Block title.
	icon: 'shield', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [
		__( 'toastmasters' ),
		__( 'logo' ),
		__( 'header' ),
	],
	attributes: {
		 src: {
		 type: 'string',
		 default: 'https://toastmost.org/tmbranding/toastmasters-75.png',
		 },
	 },

	/**
	 * The edit function describes the structure of your block in the context of the editor.
	 * This represents what the editor will render when the block is used.
	 *
	 * The "edit" property must be a valid function.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
	 *
	 * @param {Object} props Props.
	 * @returns {Mixed} JSX Component.
	 */
	edit: ( props ) => {
		// Creates a <p class='wp-block-cgb-block-block2022'></p>.
		const { attributes: { src } } = props;
		return (
			<Fragment>
			<div className={ props.className }>
			<TmLogoInspector {...props}/>
			<img src={src} />
			</div>
			</Fragment>
		);
	},

	/**
	 * The save function defines the way in which the different attributes should be combined
	 * into the final markup, which is then serialized by Gutenberg into post_content.
	 *
	 * The "save" property must be specified and must be a valid function.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
	 *
	 * @param {Object} props Props.
	 * @returns {Mixed} JSX Frontend HTML.
	 */
	save: ( props ) => {
		const { attributes: { src } } = props;
		return (
			<div className={ props.className }>
			<a href="/"><img src={src} /></a>
			</div>
		);
	},
} );

/* tm_theme.images+ */
class TmLogoInspector extends Component {
	render() {
		const { attributes: { src }, setAttributes, isSelected } = this.props;
		return (
			<InspectorControls key="upcominginspector">
			<PanelBody title={ __( 'Logo Version', 'rsvpmaker' ) } >
					<SelectControl
        label={__("Choice",'rsvpmaker')}
        value={ src }
        options={ [
		{value: 'https://toastmost.org/tmbranding/toastmasters-75.png', label: __('Default 75px')},
		{value: 'https://toastmost.org/tmbranding/Toastmasters150-125.png', label: __('150px')},
		{value: 'https://toastmost.org/tmbranding/Toastmasters180-150.png', label: __('180px')},
		{value: 'https://toastmost.org/tmbranding/Toastmasters200-167.png', label: __('200px')},
		{value: 'https://toastmost.org/tmbranding/Toastmasters240-200.png', label: __('240px')},
		{value: 'https://toastmost.org/tmbranding/Toastmasters300-250.png', label: __('300px')},
	] }
        onChange={ ( src ) => { setAttributes( { src: src } ) } }
    />				</PanelBody>
				</InspectorControls>
);	} }
