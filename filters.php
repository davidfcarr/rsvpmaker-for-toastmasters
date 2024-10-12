<?php

//wp4toastmasters_event_content
add_filter( 'the_content', function ( $content ) {
	global $post;
	if('rsvpmaker_template' == $post->post_type)
		return '<div  id="react-agenda" '.get_get_to_attributes().' >Loading ...</div>';

	if ( ! strpos( $_SERVER['REQUEST_URI'], 'rsvpmaker' ) || is_admin() ) {
		return $content;
	}
	//don't want to clog memory with speech lookups
	wp_suspend_cache_addition(true);
	if(isset($_REQUEST['oneclick']))
		return wpt_oneclick_signup();

	if(isset($_POST['oneclickrole'])) {
		return wpt_oneclick_signup_post();
	}
	if ( isset( $_GET['clipboard'] ) ) {
		return wpt_clipboard();
	}
	
	global $post, $rsvp_options, $current_user;

	$link = $output = '';

	if ( isset( $_REQUEST['recommendation'] ) ) {
		if ( $_REQUEST['recommendation'] == 'success' ) {
			$link = '<div style="border: thin solid #00F; padding: 10px; margin: 10px; background-color: #eee;">' . __( 'You have accepted a role for this meeting. Thanks!', 'rsvpmaker-for-toastmasters' ) . '</div>';
		} elseif ( $_REQUEST['recommendation'] == 'code_error' ) {
			$link = '<div style="border: thin solid #F00; padding: 10px; margin: 10px; background-color: #eee;">' . __( 'Oops, something went wrong with the automatic sign up. Please sign in with your password to take a role', 'rsvpmaker-for-toastmasters' ) . '</div>';
		} else {
			$link = '<div style="border: thin solid #F00; padding: 10px; margin: 10px; background-color: #eee;">' . __( 'Oops, someone else took that role first. Sign in to take any other open role listed below', 'rsvpmaker-for-toastmasters' ) . '</div>';
		}
	}
	if ( ( $post->post_type != 'rsvpmaker' ) || ! is_wp4t() ) {
		return $content;
	}
	$permalink = rsvpmaker_permalink_query( $post->ID );

	if ( isset( $_REQUEST['print_agenda'] ) || is_email_context() ) {
	} 
	elseif(isset($_GET['evalme']) && (!is_user_logged_in() || !is_club_member())) {
		if(!is_user_logged_in()) {
			$link = sprintf('<p>If you have a password, please <a href="%s">log in</a></p>',wp_login_url(get_permalink().'?evalme='.$_GET['evalme']));
		}
		$link .= '<div  id="react-agenda" '.get_get_to_attributes('evaluation_guest').' >Loading ...</div>';
		return $link;
	}
	elseif ( ! is_club_member() && ! current_user_can('manage_network') ) {
		$link .= sprintf( '<div id="agendalogin"><a href="%s">' . __( 'Login to Sign Up for Roles', 'rsvpmaker-for-toastmasters' ) . '</a> or <a href="%s">' . __( 'View Agenda', 'rsvpmaker-for-toastmasters' ) . '</a></div>', site_url() . '/wp-login.php?redirect_to=' . urlencode( $permalink ), $permalink . 'print_agenda=1&no_print=1' );
	} else {
		$link .= agenda_menu( $post->ID );
		if(function_exists('create_block_toastmasters_dynamic_agenda_block_init')) {
			if(isset($_GET['revert_by_default']) && current_user_can('manage_options')) {
				$revert_default = ('on' == $_GET['revert_by_default']);
				update_option('toast_revert_default',$revert_default);
			}
			else
				$revert_default = get_option('toast_revert_default');
			if((current_user_can('manage_network') || is_club_member()) && !isset($_GET['revert']) && !$revert_default) {
				$link .= '<div id="react-agenda" '.get_get_to_attributes().' >Loading ...</div>';
				$parts = explode('<div id="rsvpsection">',$content);
				if(!empty($parts[1]))
					$content = '<div style="margin-top: 500px;" id="rsvpsection">'.$parts[1];
				else
					$content = '';
			}
			elseif(current_user_can('manage_options')) {
				if($revert_default)
					$link .= '<div style="width: 200px;float:right;"><a style="color:#5A808D; background-color:#fff;" href="?revert_by_default=off">Switch to new form</a></div>';
				else
					$link .= '<div style="width: 200px;float:right;"><a style="color:#5A808D; background-color:#fff;" href="?revert=1&revert_by_default=on">Default to old form</a></div>';
			}
		}	
		$link .= sprintf( '<input type="hidden" id="editor_id" value="%s" />', $current_user->ID );

		if ( isset( $_REQUEST['assigned_open'] ) && current_user_can( 'edit_signups' ) ) {
			$link .= "\n" . sprintf( '<div style="margin-top: 10px; margin-bottom: 10px;"><a href="%s">%s</a></div>', $permalink . 'assigned_open=1&email_me=1', __( 'Email to me', 'rspmaker-for-toastmasters' ) ) . "\n";

			$link .= wp4t_assigned_open();
			$link .= rsvp_report_this_post();
			return $link;
		}
		if ( isset( $_POST['editor_suggest'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
			foreach ( $_POST['editor_suggest'] as $name => $value ) {
				$name = sanitize_text_field($name);
				$value = sanitize_text_field($value);
				$count = (int) $_POST['editor_suggest_count'][ $name ];
				if ( $value < 1 ) {
					continue;
				}
				tm_recommend_send( $name, $value, $permalink, $count, $post->ID, $current_user->ID );
			}
		}
		$logged = (int) get_option( '_tm_updates_logged' );
		if ( $logged > time() ) {
			// displayed up to 2 minutes after updates logged
			$output .= sprintf( '<p style="border: thin dotted #000; padding: 5px;"><a href="%s">%s</a></p>', admin_url( 'admin.php?page=toastmasters_activity_log' ), __( 'View log of assignments and recommendations.', 'rsvpmaker-for-toastmasters' ) );
		}
	}

	if(isset($_GET['edit_roles_new'])) 
		$link .= '<input type="hidden" id="edit_roles_new" value="1" >';
	if(wp4t_hour_past($post->ID) && current_user_can( 'edit_member_stats' )) 
		$link .= sprintf('<h3>%s - <a href="%s">%s</a></h3>',__('Role data archived','rsvpmaker-for-toastmasters'),admin_url('admin.php?page=toastmasters_reconcile&post_id='.$post->ID),__('Edit','rsvpmaker-for-toastmasters'));
	return $output . $link . $content.'<div><a style="color:#5A808D; background-color:#fff;" href="?revert=1">Old signup form</a><p style="font-size: 10px; font-style: italic; line-height: 10.3px;color:#5A808D; background-color:#fff;">Click here if the form fails to load or something goes wrong.</p></div>';

}
, 2 );

//edit_toast_roles
add_filter( 'the_content', function ( $content ) {
	global $post;
	global $current_user;
	if ( isset( $_POST['_tm_sidebar'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		tm_sidebar_post( $post->ID );
	}
	if ( isset( $_REQUEST['edit_sidebar'] ) ) {
		$sidebar_editor = agenda_sidebar_editor( $post->ID );
		return sprintf(
			'<form id="edit_roles_form" method="post" action="%s"">
%s<button class="save_changes">' . __( 'Save Changes', 'rsvpmaker-for-toastmasters' ) . '</button><input type="hidden" name="post_id" class="post_id" value="%d">'.rsvpmaker_nonce('return').'</form>%s',
			rsvpmaker_permalink_query( $post->ID ),
			$sidebar_editor,
			$post->ID,
			$content
		);
	}
	if ( isset( $_REQUEST['reorder'] ) ) {
		return '<p><em>' . __( 'Drag and drop to change the order in which speakers, evaluators and other roles with multiple participants will appear on the agenda' ) . '</em></p>' . $content;
	} elseif ( isset( $_GET['tweak_times'] ) ) {
		return tweak_agenda_times( $post );
	} elseif ( ! is_edit_roles() || ( ! current_user_can( 'edit_signups' ) && ! edit_signups_role() ) ) {
		return $content;
	}

	$r        = 'x' . rand();
	$content .= '<p><span id="time' . $r . '" class="toasttime" "></span><select class="tweakminutes" timetarget="' . $r . '" style="display:none;"><option value="0" selected="selected">0</option></select> End of meeting</p>';

	if ( current_user_can( 'agenda_setup' ) ) {
		$content .= sprintf( '<p><a href="%sedit_sidebar=1">%s</a></p>', rsvpmaker_permalink_query( $post->ID ), __( 'Edit Sidebar', 'rsvpmaker-for-toastmasters' ) );// agenda_sidebar_editor($post->ID);
	}

	return sprintf(
		'<form id="edit_roles_form" method="post" action="%s"">
%s
<button class="save_changes">' . __( 'Save Changes', 'rsvpmaker-for-toastmasters' ) . '</button><input type="hidden" name="post_id" class="post_id" value="%d">%s</form>',
		rsvpmaker_permalink_query( $post->ID ),
		$content,
		$post->ID,
		rsvpmaker_nonce('return')
	);
}
, 1 );

//assign_toast_roles
add_filter( 'the_content', function ( $content ) {
	if ( ! isset( $_REQUEST['recommend_roles'] ) || ! current_user_can( 'edit_posts' ) ) {
		return $content;
	}
	global $post;
	global $current_user;
	global $wpdb;
	global $rsvp_options;
	$output = '';

	$permalink = rsvpmaker_permalink_query( $post->ID );

	$date = get_rsvp_date( $post->ID );

	$output .= sprintf(
		'<form id="edit_roles_form" method="post" action="%s">
%s<button class="save_changes">' . __( 'Save Changes', 'rsvpmaker-for-toastmasters' ) . '</button><input type="hidden" name="post_id" class="post_id" value="%d">%s</form>',
		$permalink,
		$content,
		$post->ID,
		rsvpmaker_nonce('return')
	);

	return $output;

}
, 1 );

//member_only_content
add_filter( 'the_content', function ( $content ) {
	global $post;
	if ( ! in_category( 'members-only' ) && ! has_term( 'members-only', 'rsvpmaker-type' ) && (empty($post->post_type) || $post->post_type != 'tmminutes') ) {
		return $content;
	}
	if('tmminutes' == $post->post_type) {
		//termids
		$terms = wp_get_post_terms( $post->ID, array( 'minutes-type' ) );
		if($terms) {
			$content .= '<p>Minutes type: ';
			foreach ( $terms as $term ) :
				$term_links[] = sprintf('<a href="%s">%s</a>',get_term_link($term->term_id),$term->name);
			endforeach;
			$content .= implode(', ',$term_links).'</p>';
		}
	}
	if ( ! is_club_member() ) {
		return '<div style="width: 100%; background-color: #ddd;">' . __( 'To view this content, you must be logged with a member account.', 'rsvpmaker-for-toastmasters' ) . '</div>' . sprintf( '<div id="member_only_login"><a href="%s">' . __( 'Login to View', 'rsvpmaker-for-toastmasters' ) . '</a></div>', site_url( '/wp-login.php?redirect_to=' . urlencode( get_permalink() ) ) );		
	}  
	elseif(isset($_GET['print']))
		return $content;
	else {
		return $content . '<div style="width: 100%; background-color: #ddd;">' . __( 'Note: This is member-only content (login required)', 'rsvpmaker-for-toastmasters' ) . '</div>';
	}
}
);

add_filter( 'login_message', function ( $message ) {
	if ( ! empty( $message ) ) {
		$message .= "\n\n";
	}
	$message .= get_option( 'wp4toastmasters_login_message' );

	if ( ! empty( $message ) ) {
		return wpautop( $message );
	}
}
);

add_filter( 'the_excerpt', 'member_only_excerpt' );
add_filter( 'get_the_excerpt', 'member_only_excerpt' );
function member_only_excerpt( $excerpt ) {
	if ( ! in_category( 'members-only' ) && ! has_term( 'members-only', 'rsvpmaker-type' ) ) {
		return $excerpt;
	}

	if ( ! is_club_member() ) {
		return __( 'To view this content, you must be logged in with a member account.', 'rsvpmaker-for-toastmasters' );
	} else {
		return $excerpt;
	}
}