<?php

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */

function create_block_toastmasters_dynamic_agenda_block_init() {
	register_block_type( __DIR__ . '/build' );
	$blocks = get_wpt_blocks();		
	foreach ( $blocks as $dir => $args ) {
		register_block_type( __DIR__ . '/build/'.$dir, $args );
	}
}
function get_wpt_blocks() {
	return array(
		'logo' => array(),
		'help'  => array(),
		'rsvplist'  => array(),
		'role'  => array(),
		'agendanoterich2'  => array(),
		'signupnote'  => array(),
		'agendaedit'  => array(),
		'milestone'  => array(),
		'absences'  => array(),
		'hybrid'  => array(),
		'duesrenewal'  => array(),
		'context'  => array(),
		'blog'  => array(),
		'newestmembers'  => array(),
		'memberaccess'  => array(),
		'agendamain'  => array(),
		'meetingdate'  => array(),
		'officers'  => array(),
		'memberoptions'  => array(),
		'speaker-evaluator'  => array(),
		'agendaprivacy'  => array(),		
		'memberprofile'  => array());
}

add_filter('block_type_metadata_settings','wp4t_agenda_block_type_metadata',10,2);

add_filter('allowed_block_types_all','wp4t_restrict_layout_blocks_for_agenda_content',20,2);

function wp4t_block_declares_post_types( $block_json_path ) {
	if ( ! file_exists( $block_json_path ) ) {
		return false;
	}

	$metadata = array();
	if ( function_exists( 'wp_json_file_decode' ) ) {
		$metadata = wp_json_file_decode( $block_json_path, array( 'associative' => true ) );
	} else {
		$raw = @file_get_contents( $block_json_path );
		if ( false !== $raw ) {
			$metadata = json_decode( $raw, true );
		}
	}

	return ( is_array( $metadata ) && ! empty( $metadata['postTypes'] ) && is_array( $metadata['postTypes'] ) );
}

function wp4t_get_event_only_blocks() {
	$event_only = array();
	if ( wp4t_block_declares_post_types( __DIR__ . '/build/block.json' ) ) {
		$event_only[] = 'wp4toastmasters/toastmasters-dynamic-agenda';
	}

	foreach ( array_keys( get_wpt_blocks() ) as $slug ) {
		if ( wp4t_block_declares_post_types( __DIR__ . '/build/' . $slug . '/block.json' ) ) {
			$event_only[] = 'wp4toastmasters/' . $slug;
		}
	}

	return array_values( array_unique( $event_only ) );
}

function wp4t_is_agenda_editor_post( $post ) {
	if ( ! $post || empty( $post->post_type ) ) {
		return false;
	}

	return in_array( $post->post_type, array( 'rsvpmaker', 'rsvpmaker_template' ), true );
}

function wp4t_restrict_layout_blocks_for_agenda_content($allowed_block_types, $editor_context) {
	$post = !empty($editor_context->post) ? $editor_context->post : null;

	if(true === $allowed_block_types) {
		$all = WP_Block_Type_Registry::get_instance()->get_all_registered();
		$allowed_block_types = array_keys($all);
	}

	if(!is_array($allowed_block_types)) {
		return $allowed_block_types;
	}

	if(!wp4t_is_agenda_editor_post($post)) {
		$event_only = wp4t_get_event_only_blocks();
		if ( empty( $event_only ) ) {
			return $allowed_block_types;
		}

		return array_values(array_diff($allowed_block_types, $event_only));
	}

	if(!$post || empty($post->post_content)) {
		return $allowed_block_types;
	}

	if(false === strpos($post->post_content, 'wp:wp4toastmasters/')) {
		return $allowed_block_types;
	}

	$restricted = array('core/group','core/columns');

	return array_values(array_diff($allowed_block_types, $restricted));
}

function wp4t_agenda_block_type_metadata($metadata) {
	global $post, $current_user;
	if(!empty($metadata['view_script_handles']) && in_array('wp4toastmasters-toastmasters-dynamic-agenda-view-script',$metadata['view_script_handles'])) {
		wp_localize_script( 'wp4toastmasters-toastmasters-dynamic-agenda-view-script', 'wpt_rest',wpt_rest_array());
	}
	return $metadata;
}

function wp4t_get_dynamic_agenda_script_handle ($type) {
return generate_block_asset_handle( 'wp4toastmasters/toastmasters-dynamic-agenda', $type);
}
add_action('wp_enqueue_scripts', 'wp4t_dynamic_agenda_script');
add_action('admin_enqueue_scripts', 'wp4t_dynamic_agenda_script');

function wp4t_dynamic_agenda_script() {
	global $post, $wp_scripts;
	if(
	($post && $post->post_type && (('rsvpmaker' == $post->post_type) || ('rsvpmaker_template' == $post->post_type) || ('tmminutes' == $post->post_type) || strpos($post->post_content,'wp-block-wp4toastmasters-toastmasters-dynamic-agenda')))
	|| (isset($_GET['page']) && ('wp4t_evaluations' == $_GET['page'] || 'wp4t_agenda_template_editor' == $_GET['page']))
	) {
		$script_handle = wp4t_get_dynamic_agenda_script_handle('viewScript');
		$frontend = get_block_asset_url((dirname(__FILE__)) . 'agenda/build/frontend.js');		
		wp_enqueue_script($script_handle
		, $frontend, 
		['wp-i18n'], // Add wp-i18n as a dependency
		null,
		true // Load in footer
		);
		
		$plugin_dir = plugin_dir_path(dirname(__FILE__)); // Get the parent directory of the current file
		wp_set_script_translations($script_handle, 'rsvpmaker-for-toastmasters', $plugin_dir . 'translations');
		wp_set_script_translations($script_handle.'-2', 'rsvpmaker-for-toastmasters', $plugin_dir . 'translations');
		wp_localize_script( $script_handle, 'wpt_rest',wpt_rest_array());
		wp_enqueue_style(wp4t_get_dynamic_agenda_script_handle('style'),'',['forms','common']);
		rsvpmaker_enqueue_block_store();
	}
	if(isset($_GET['transdebug']))
	die('<pre>'.htmlentities(var_export($wp_scripts->registered,true)).'</pre>');
}
