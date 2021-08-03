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
	global $post, $toast_roles;
	if(!isset($_GET['action']) || !isset($post->post_type) || ($post->post_type != 'rsvpmaker'))
		return;
	// Scripts.
	wp_enqueue_script(
		'wpt-cgb-block-js', // Handle.
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ), // Block.build.js: We register the block here. Built with Webpack.
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-block-editor' ), // Dependencies, defined above.
		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: filemtime — Gets file modification time.
		true // Enqueue the script in the footer.
	);

	$wpt_rest = array('nonce' => wp_create_nonce( 'wp_rest' ), 'url' => get_rest_url(), 'post_id' => $post->ID );
	$rsvpmaker_special = get_post_meta($post->ID,'_rsvpmaker_special',true);
	if(!empty($rsvpmaker_special))
		$wpt_rest['special'] = $rsvpmaker_special;
	wp_localize_script('wpt-cgb-block-js', 'wpt_rest', $wpt_rest );
	$toast[] = array('value' =>'custom', 'label' => 'Custom Role');
	foreach($toast_roles as $key => $value)
		$toast[] = array('value' => $key, 'label' => $value);
	wp_localize_script('wpt-cgb-block-js', 'toast_roles', $toast );
/*	[
		{value: '', label: ''},
		{value: 'custom', label: __('Custom Role','rsvpmaker-for-toastmasters')},
		{value: 'Ah Counter', label: __('Ah Counter','rsvpmaker-for-toastmasters')},
		{value: 'Body Language Monitor', label: __('Body Language Monitor','rsvpmaker-for-toastmasters')},
		{value: 'Evaluator', label: __('Evaluator','rsvpmaker-for-toastmasters')},
		{value: 'General Evaluator', label: __('General Evaluator','rsvpmaker-for-toastmasters')},
		{value: 'Grammarian', label: __('Grammarian','rsvpmaker-for-toastmasters')},
		{value: 'Humorist', label: __('Humorist','rsvpmaker-for-toastmasters')},
		{value: 'Speaker', label: __('Speaker','rsvpmaker-for-toastmasters')},
		{value: 'Backup Speaker', label: __('Backup Speaker','rsvpmaker-for-toastmasters')},
		{value: 'Topics Master', label: __('Topics Master','rsvpmaker-for-toastmasters')},
		{value: 'Table Topics', label: __('Table Topics','rsvpmaker-for-toastmasters')},
		{value: 'Toastmaster of the Day', label: __('Toastmaster of the Day','rsvpmaker-for-toastmasters')},
		{value: 'Timer', label: __('Timer','rsvpmaker-for-toastmasters')},
		{value: 'Vote Counter', label: __('Vote Counter','rsvpmaker-for-toastmasters')},
		{value: 'Contest Chair', label: __('Contest Chair','rsvpmaker-for-toastmasters')},
		{value: 'Contest Master', label: __('Contest Master','rsvpmaker-for-toastmasters')},
		{value: 'Chief Judge', label: __('Chief Judge','rsvpmaker-for-toastmasters')},
		{value: 'Ballot Counter', label: __('Ballot Counter','rsvpmaker-for-toastmasters')},
		{value: 'Contestant', label: __('Contestant','rsvpmaker-for-toastmasters')},
		]
*/
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
	$roleatts = array('role' => array('type' => 'string', 'default' => ''),'custom_role' => array('type' => 'string', 'default' => ''),'count' => array('type' => 'int', 'default' => 1),'start' => array('type' => 'int', 'default' => 1),'agenda_note' => array('type' => 'string', 'default' => ''),'time_allowed' => array('type' => 'string', 'default' => '0'),'padding_time' => array('type' => 'string', 'default' => '0'),'timing_updated' => array('type' => 'int', 'default' => 0),'backup' => array('type' => 'string', 'default' => ''));
	$noteatts = array('time_allowed' => array('type' => 'string', 'default' => '0'),'timing_updated' => array('type' => 'int', 'default' => 0),'uid' => array('type' => 'string', 'default' => ''),'content' => array('type' => 'array', 'default' => array() ) );
	register_block_type('wp4toastmasters/agendanoterich2', ['render_callback' => 'agendanoterich2', 'attributes' => $noteatts]);
	$noteatts = array('editable' => array('type' => 'string', 'default' => ''),'time_allowed' => array('type' => 'string', 'default' => '0'),'timing_updated' => array('type' => 'int', 'default' => 0),'uid' => array('type' => 'string', 'default' => ''),'inline' => array('type' => 'int', 'default' => 0 ) );
	register_block_type('wp4toastmasters/agendaedit', ['render_callback' => 'editable_note', 'attributes' => $noteatts]);
	register_block_type('wp4toastmasters/role', ['render_callback' => 'toastmaster_short', 'attributes' => $roleatts ]);
	register_block_type('wp4toastmasters/agendamain', ['render_callback' => 'tmlayout_main_block']);
	register_block_type('wp4toastmasters/officers', ['render_callback' => 'toastmaster_officers']);	
	register_block_type('wp4toastmasters/absences', ['render_callback' => 'tm_absence']);	
}

function agendanoterich2($atts, $content) {
if(wp_is_json_request())
	return summarize_agenda_times($atts);

$output = false;
global $emailcontext;
if($emailcontext)
	$output = true;
if(isset($_GET['print_agenda']) || isset($_GET['email_agenda']))
	$output = true;
if($output)
	return $content;
return;
}

add_action('init','wpt_server_block_render');