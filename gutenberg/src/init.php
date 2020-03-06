<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Gutenberg block assets for both frontend + backend.
 *
 * `wp-blocks`: includes block type registration and related functions.
 *
 * @since 1.0.0
 */
function wpt_cgb_block_assets() {
	// Styles.
	wp_enqueue_style(
		'wpt-cgb-style-css', // Handle.
		plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ), // Block style CSS.
		array( 'wp-editor' ), // Dependency to include the CSS after it.
		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' ) // Version: filemtime — Gets file modification time.
	);
} // End function wpt_cgb_block_assets().

// Hook: Frontend assets.

add_action( 'enqueue_block_assets', 'wpt_cgb_block_assets' );

/**
 * Enqueue Gutenberg block assets for backend editor.
 *
 * `wp-blocks`: includes block type registration and related functions.
 * `wp-element`: includes the WordPress Element abstraction for describing the structure of your blocks.
 * `wp-i18n`: To internationalize the block's text.
 *
 * @since 1.0.0
 */
function wpt_cgb_editor_assets() {
	global $post;
	if(!isset($_GET['action']) || !isset($post->post_type) || ($post->post_type != 'rsvpmaker'))
		return;
	// Scripts.
	wp_enqueue_script(
		'wpt-cgb-block-js', // Handle.
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ), // Block.build.js: We register the block here. Built with Webpack.
		array( 'wp-blocks', 'wp-i18n', 'wp-element' ), // Dependencies, defined above.
		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: filemtime — Gets file modification time.
		true // Enqueue the script in the footer.
	);

	$rsvpmaker_special = get_post_meta($post->ID,'_rsvpmaker_special',true);
	wp_localize_script( 'wpt-cgb-block-js', 'toastmasters_special', $rsvpmaker_special);
	
	// Styles.
	wp_enqueue_style(
		'wpt-cgb-block-editor-css', // Handle.
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ), // Block editor CSS.
		array( 'wp-edit-blocks' ), 
		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' )
	);
} // End function wpt_cgb_editor_assets().

// Hook: Editor assets.
add_action( 'enqueue_block_editor_assets', 'wpt_cgb_editor_assets' );

function wpt_server_block_render(){
	if(wp_is_json_request())
		return;
	register_block_type('wp4toastmasters/role', ['render_callback' => 'toastmaster_short']);
	register_block_type('wp4toastmasters/agendaedit', ['render_callback' => 'editable_note']);	
	register_block_type('wp4toastmasters/absences', ['render_callback' => 'tm_absence']);	
	register_block_type('wp4toastmasters/agendasidebar', ['render_callback' => 'tmlayout_sidebar']);	
	register_block_type('wp4toastmasters/agendamain', ['render_callback' => 'tmlayout_main']);
}

add_action('init','wpt_server_block_render');