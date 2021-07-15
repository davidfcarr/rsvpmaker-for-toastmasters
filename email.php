<?php
/*
Email routines
*/

add_action( 'wp4toast_reminders_cron', 'wp4toast_reminders_cron', 10, 1 );

function wp4toast_reminders_cron( $meeting_hours ) {
	email_with_without_role( $meeting_hours );
	return;
	// replaces wp4_speech_prompt
}

add_shortcode( 'email_with_without_role', 'email_with_without_role_test' );
function email_with_without_role_test() {
	email_with_without_role( '', true );
}

function email_with_without_role( $meeting_hours, $test = false ) {
	global $wpdb, $email_context, $post, $rsvp_options;
	$waspost       = $post;
	$email_context = true;
	if ( empty( $meeting_hours ) ) {
		$meetings      = future_toastmaster_meetings( 1 );
		$next          = $meetings[0];
		$date          = $next->date;
		$meeting_hours = $next->ID . ':0';
		if ( $test ) {
			$meeting_hours .= time();
		}
	} elseif ( ! strpos( $meeting_hours, ':' ) ) {
		return;
	} else {
		$p    = explode( ':', $meeting_hours );
		$next = get_post( $p[0] );
	}
	if ( empty( $next ) ) {
		return;
	}
	$t      = rsvpmaker_strtotime( get_rsvp_date( $next->ID ) );
	$date   = rsvpmaker_date( $rsvp_options['short_date'], $t );
	$post   = $next;
	$dupkey = 'email_reminder_' . $meeting_hours;
	if ( get_post_meta( $post->ID, $dupkey, true ) ) {
		return; // don't do more than once
	}
	update_post_meta( $post->ID, $dupkey, true );
	$members   = get_club_members();
	$templates = get_rsvpmaker_notification_templates();
	$permalink = get_permalink( $next->ID );
	$content   = do_shortcode( $templates['norole']['body'] );
	$absences  = get_absences_array( $next->ID );
	$reminders = array();
	$absent    = array();
	$norole    = array();
	foreach ( $members as $member ) {
		$sql                             = "SELECT * FROM `$wpdb->postmeta` where post_id=" . $next->ID . '  AND meta_value=' . $member->ID . " AND BINARY meta_key RLIKE '^_[A-Z].+[0-9]$' ";
		$role_results                    = $wpdb->get_results( $sql );
		$roles                           = array();
		$reminder_details[ $member->ID ] = '';
		if ( in_array( $member->ID, $absences ) ) {
			$absent[] = $member->user_email;
		} elseif ( $role_results ) {
			foreach ( $role_results as $role_row ) {
				$role    = trim( preg_replace( '/[^A-Za-z]/', ' ', $role_row->meta_key ) );
				$roles[] = $role;
				if ( $role == 'Speaker' ) {
					$manual                           = get_post_meta( $next->ID, '_manual' . $role_row->meta_key, true );
					$title                            = get_post_meta( $next->ID, '_title' . $role_row->meta_key, true );
					$project_key                      = get_post_meta( $next->ID, '_project' . $role_row->meta_key, true );
					$project                          = ( $project_key ) ? get_project_text( $project_key ) : 'Please specify project';
					$intro                            = get_post_meta( $next->ID, '_intro' . $role_row->meta_key, true );
					$reminder_details[ $member->ID ] .= sprintf( '<p>Manual: %s<br />Project: %s<br />Title: %s<br />Intro: %s</p>', $manual, $project, $title, $intro );
				}
			}
			$reminders[ $member->ID ]      = $member->user_email;
			$reminder_roles[ $member->ID ] = implode( ', ', $roles );
		} else {
			$norole[] = $member->user_email;
		}
	}

	$mail['from']     = get_option( 'admin_email' );
	$mail['fromname'] = get_option( 'name' );
	foreach ( $reminders as $index => $email ) {
		echo esc_html($email);
		$mail['to']      = ( $test ) ? $mail['from'] : $email;
		$testtext        = ( $test ) ? "<p>$email</p>" : '';
		$mail['html']    = wpt_email_agenda_wrapper($testtext . wp_kses_post('<p>Your role(s) :' . $reminder_roles[ $index ] . '<p>' . $reminder_details[ $index ] . $content));
		$mail['subject'] = 'You are signed up for ' . esc_attr($reminder_roles[ $index ] . ' on ' . $date . ' - ' . $next->post_title);
		$result          = rsvpmaker_qemail( $mail, array($mail['to']) );
		update_post_meta( $post->ID, 'reminder', $mail );
	}
	if(!empty($norole)) {
		$mail['html'] = wpt_email_agenda_wrapper("<p>You're not yet signed up for a role.</p>\n" . $content);
		$mail['subject'] = 'Reminder: ' . $date . ' - ' . $next->post_title;	
		rsvpmaker_qemail($mail,$norole);
	}
	update_post_meta( $post->ID, '_role_reminder_email', 'Role reminders ' . implode( ',', $reminders ) . ' prompt: ' . implode( ',', $norole ).rsvpmaker_date('r') );
	$post = $waspost;
}

function awemailer( $mail ) {

	global $rsvp_options;

	if ( strpos( $mail['to'], 'example.com' ) ) {
		return;
	}

	if ( get_option( 'wp4toastmasters_disable_email' ) ) {
			return false;
	}

	$result = rsvpmailer( $mail );
	return $result;
}

function rsvptoast_email( $postdata, $rsvp_html, $rsvp_text ) {
	if ( empty( $postdata['guests'] ) && empty( $postdata['ex'] ) ) {
		return;
	}

	global $wpdb;
	global $unsubscribed;
	global $current_user;
	$unsub = get_option( 'rsvpmail_unsubscribed' );

	if ( ! empty( $postdata['guests'] ) ) {
		// guests
		$sql    = 'SELECT email FROM `' . $wpdb->prefix . 'users_archive` WHERE `' . $wpdb->prefix . 'users_archive`.guest AND user_id=0 ORDER BY updated DESC'; // limit?
		$guests = $wpdb->get_results( $sql );
		if ( ! empty( $guests ) ) {
			printf( '<p>Sending to %s guests</p>', sizeof( $guests ) );
			foreach ( $guests as $guest ) {
				// printf('<div>Guest %s</div>',$guest->email);
				if ( is_array( $unsub ) && in_array( strtolower( $guest->email ), $unsub ) ) {
					$unsubscribed[] = $guest->email;
					continue;
				}
				$mail['to']       = $guest->email;
				$mail['from']     = ( isset( $_POST['user_email'] ) ) ? $current_user->user_email : sanitize_text_field($_POST['from_email']);
				$mail['fromname'] = sanitize_text_field(stripslashes( $_POST['from_name'] ));
				$mail['subject']  = sanitize_text_field(stripslashes( $_POST['subject'] ));
				$mail['html']     = rsvpmaker_personalize_email( $rsvp_html, $mail['to'], __( 'This message was sent to you as a guest of ', 'rsvpmaker' ) . ' ' . sanitize_text_field($_SERVER['SERVER_NAME']) );
				$mail['text']     = rsvpmaker_personalize_email( $rsvp_text, $mail['to'], __( 'This message was sent to you as a guest of', 'rsvpmaker' ) . ' ' . sanitize_text_field($_SERVER['SERVER_NAME']) );
				$result           = rsvpmailer( $mail );
			}
		} // end db lookup
	}

	if ( ! empty( $postdata['ex'] ) ) {
		// former members
		$sql  = 'SELECT email FROM `' . $wpdb->prefix . 'users_archive` LEFT JOIN `' . $wpdb->prefix . 'users` ON `' . $wpdb->prefix . 'users_archive`.user_id = ' . $wpdb->prefix . 'users.ID WHERE `' . $wpdb->prefix . 'users`.ID IS NULL AND user_id > 0 ORDER BY updated DESC'; // limit?
		$exes = $wpdb->get_results( $sql );
		if ( ! empty( $exes ) ) {
			printf( '<p>Sending to %s former members</p>', sizeof( $exes ) );
			foreach ( $exes as $ex ) {
				// printf('<div>Ex member %s</div>',$ex->email);
				if ( is_array( $unsub ) && in_array( strtolower( $ex->email ), $unsub ) ) {
					$unsubscribed[] = $ex->email;
					continue;
				}
				$mail['to']       = $ex->email;
				$mail['from']     = ( isset( $_POST['user_email'] ) ) ? $current_user->user_email : sanitize_text_field($_POST['from_email']);
				$mail['fromname'] = sanitize_text_field(stripslashes( $_POST['from_name'] ));
				$mail['subject']  = sanitize_text_field(stripslashes( $_POST['subject'] ));
				$mail['html']     = rsvpmaker_personalize_email( $rsvp_html, $mail['to'], __( 'This message was sent to you as a guest of ', 'rsvpmaker' ) . ' ' . sanitize_text_field($_SERVER['SERVER_NAME']) );
				$mail['text']     = rsvpmaker_personalize_email( $rsvp_text, $mail['to'], __( 'This message was sent to you as a guest of', 'rsvpmaker' ) . ' ' . sanitize_text_field($_SERVER['SERVER_NAME']) );
				$result           = rsvpmailer( $mail );
			}
		} // end db lookup
	}}

add_action( 'rsvpmaker_email_send_ui_submit', 'rsvptoast_email', 10, 3 );

function rsvptoast_email_ui() {
	?>
<div><input type="checkbox" name="guests" value="1"> <?php _e( 'Guests', 'rsvpmaker' ); ?> </div>
<div><input type="checkbox" name="ex" value="1"> <?php _e( 'Former Members', 'rsvpmaker' ); ?> </div>
	<?php
}

add_action( 'rsvpmaker_email_send_ui_options', 'rsvptoast_email_ui' );

function toastmasters_rsvpmailer_rule( $content, $email, $message_type ) {
	if ( empty( $message_type ) ) {
		return;
	}
	$user = get_user_by( 'email', $email );
	if ( ! $user ) {
		return '';
	}
	return get_user_meta( $user->ID, 'email_rule_' . $message_type, true );
}

add_filter( 'rsvpmailer_rule', 'toastmasters_rsvpmailer_rule', 10, 3 );

function wp4t_intro_notification( $post_id, $actiontext, $user_id, $field = '', $actiontype = '' ) {
	global $rsvp_options;

	if ( $actiontype != 'intro' ) {
		return;
	}

	$meeting_leader = get_post_meta( $post_id, 'meeting_leader', true );
	if ( empty( $meeting_leader ) ) {
		$meeting_leader = '_Toastmaster_of_the_Day_1';
	}

	$toastmaster = get_post_meta( $post_id, $meeting_leader, true );

	if ( $toastmaster && is_numeric( $toastmaster ) ) {
		$speaker       = get_userdata( $user_id );
		$manual        = get_post_meta( $post_id, '_manual' . $field, true );
		$project_index = get_post_meta( $post_id, '_project' . $field, true );
		if ( ! empty( $project_index ) ) {
			$project = get_project_text( $project_index );
			$manual .= ': ' . $project;
		}
		$title = get_post_meta( $post_id, '_title' . $field, true );

		$t        = rsvpmaker_strtotime( get_rsvp_date( $post_id ) );
		$date     = rsvpmaker_date( $rsvp_options['short_date'], $t );
		$userdata = get_userdata( $toastmaster );
		$url      = get_permalink( $post_id );

		$subject = $speaker->first_name . ' ' . $speaker->last_name . ' ' . __( 'Speech Intro for', 'rsvpmaker-for-toastmasters' ) . ' ' . $date;

		$message = $speaker->first_name . ' ' . $speaker->last_name . ' ' . __( 'Speech for', 'rsvpmaker-for-toastmasters' ) . ' <a href="' . $url . '">' . $date . "</a>\n\n" . $manual . "\n\n" . $title . "\n\n" . $actiontext;

		$toastmaster_email = $userdata->user_email;
		$message          .= "\n\nThis is an automated message. Replies will be sent to " . $speaker->user_email;
		$mail['subject']   = substr( strip_tags( $subject ), 0, 100 );
		$mail['replyto']   = $speaker->user_email;
		$mail['html']      = "<html>\n<body>\n" . wpautop( $message ) . "\n</body></html>";
		$mail['to']        = $toastmaster_email;
		$mail['from']      = $speaker->user_email;
		$mail['fromname']  = $speaker->display_name;
		awemailer( $mail );
	}
}

function editor_signup_notification( $post_id, $user_id, $role, $manual = '', $project = '', $title = '' ) {
	if ( is_admin() ) {
		return; // don't do this on the reconcile screen
	}

	$role = clean_role( $role );
	global $current_user;
	global $wpdb;
	global $rsvp_options;
	$datetime    = get_rsvp_date( $post_id );
	$meetingdate = rsvpmaker_date( $rsvp_options['short_date'], rsvpmaker_strtotime( $datetime ) );
	if ( ! is_numeric( $user_id ) ) {
		return;
	}
	$speakerdata = get_userdata( $user_id );
	if ( ! isset( $speakerdata->user_email ) ) {
		return;
	}
	if ( $project ) {
		$project = get_project_text( $project );
	}

	$subject = $message = sprintf( __( 'Your role: %1$s for %2$s %3$s', 'rsvpmaker-for-toastmasters' ), clean_role( $role ), $meetingdate, get_bloginfo( 'name' ) );

		$message .= "\n\n";
	if ( strpos( $role, 'peaker' ) ) {
		$message .= sprintf(
			'Manual: %s
Project: %s
Title: %s',
			$manual,
			$project,
			$title
		);
		if ( ! $project ) {
			$message .= "\n\n" . __( 'Please sign into the website to add speech project details, particularly if the speech project will require more than the default 7 minutes on the agenda.', 'rsvpmaker-for-toastmasters' );
			$subject .= ' (' . __( 'Please add project/timing', 'rsvpmaker-for-toastmasters' ) . ')';
		}
	}
		$message .= "\n\n" . __( 'If this information is not correct, or if you cannot attend on this date, please let us know as soon as possible.', 'rsvpmaker-for-toastmasters' );

		$meeting_leader = get_post_meta( $post_id, 'meeting_leader', true );
	if ( empty( $meeting_leader ) ) {
		$meeting_leader = '_Toastmaster_of_the_Day_1';
	}
		$toastmaster = (int) get_post_meta( $post_id, $meeting_leader, true );

	if ( $toastmaster && ( $user_id != $toastmaster ) ) {
		$tmdata       = get_userdata( $toastmaster );
		$leader_email = $tmdata->user_email;
	} else {
		$leader_email = get_option( 'admin_email' );
	}

		$p      = get_permalink( $post_id );
		$footer = "\n\nTo update this information, visit " . sprintf( '<a href="%s">%s</a>', $p, $p );

		$mail['subject']  = $subject;
		$mail['html']     = "<html>\n<body>\n" . wpautop( $message . $footer ) . "\n</body></html>";
		$mail['replyto']  = $leader_email;
		$mail['to']       = $speakerdata->user_email;
		$mail['from']     = $current_user->user_email;
		$mail['fromname'] = $current_user->display_name;
		awemailer( $mail ); // notify member
}

function tm_recommend_send( $name, $value, $permalink, $count, $post_id, $editor_id ) {
	global $wpdb;
	global $rsvp_options;
	$code = get_post_meta( $post_id, 'suggest_code', true );
	if ( ! $code ) {
			$code = wp_generate_password();
			update_post_meta( $post_id, 'suggest_code', $code );
	}
		$invite_check = $value . ':' . $post_id;
	if ( isset( $_SESSION[ $invite_check ] ) ) { // prevent double notifications
		return;
	}
		$_SESSION[ $invite_check ] = 1;

		$date     = get_rsvp_date( $post_id );
		$date     = rsvpmaker_date( $rsvp_options['long_date'], rsvpmaker_strtotime( $date ) );
		$neatname = trim( preg_replace( '/[_\-0-9]/', ' ', $name ) );
		$user     = get_userdata( $editor_id );
		$msg      = sprintf( '<p>Toastmaster %s %s %s %s %s %s</p>', $user->first_name, $user->last_name, __( 'has recomended you for the role of', 'rsvpmaker-for-toastmasters' ), $neatname, __( 'for', 'rsvpmaker-for-toastmasters' ), $date );
		$member   = get_userdata( $value );
		$email    = $member->user_email;
		$hash     = recommend_hash( $name, $value, $post_id );

		$url  = add_query_arg(
			array(
				'key'   => $name,
				'you'   => $value,
				'code'  => $hash,
				'count' => $count,
			),
			$permalink
		);
		$msg .= sprintf( "\n\n" . __( '<p>Click here to <a href="%s">ACCEPT</a> (no password required if you act before someone else takes this role)</p>', 'rsvpmaker-for-toastmasters' ), $url );
	if ( ! empty( $_POST['editor_suggest_note'][ $name ] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$msg .= "\n\n<p><b>" . __( 'Note from', 'rsvpmaker-for-toastmasters' ) . ' ' . $user->first_name . ' ' . $user->last_name . ': </b>' . wp_kses_post(stripslashes( $_POST['editor_suggest_note'][ $name ]) ) . '</p>';
	}
		$mail['html']     = $msg;
		$mail['to']       = $email;
		$mail['from']     = $user->user_email;
		$mail['cc']       = $user->user_email;
		$mail['fromname'] = $user->first_name . ' ' . $user->last_name;
		$mail['subject']  = 'You have been recommended for the role of ' . $neatname . ' on ' . $date;
		awemailer( $mail );
		$msg = '<div style="background-color: #eee; border: thin solid #000; padding: 5px; margin-5px;">' . $msg . '<p><em>' . __( 'Recommendation sent by email to', 'rsvpmaker-for-toastmasters' ) . ' <b>' . $email . '</b></em></p></div>';
		add_post_meta( $post_id, '_activity_editor', $user->first_name . ' ' . $user->last_name . ' recommended ' . $member->first_name . ' ' . $member->last_name . ' for ' . $neatname . ' on ' . $date . ', email sent to ' . $email );
		update_option( '_tm_updates_logged', strtotime( '+ 2 minutes' ) );
}

function wpt_email_agenda_wrapper($content) {
$header   = '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
' . wpt_default_agenda_css() . "\n" . get_option( 'wp4toastmasters_agenda_css' ) . '
#message p, #message li {
font-size: 16px;
}
</style>
<head>
<body>';
return rsvpmaker_inliner($header.$content.'<body></html>');
}

function awesome_open_roles( $post_id = null, $scheduled = false ) {

	if ( ! is_club_member() ) {
		return;
	}

	if ( ! isset( $_REQUEST['open_roles'] ) && ! $post_id ) {
		return;
	}
	if ( function_exists( 'email_content_minfilters' ) ) {
		email_content_minfilters();
	} else {
		global $wp_filter;
		$corefilters = array( 'convert_chars', 'wpautop', 'wptexturize' );
		foreach ( $wp_filter['the_content'] as $priority => $filters ) {
			foreach ( $filters as $name => $details ) {
				// keep only core text processing or shortcode
				if ( ! in_array( $name, $corefilters ) && ! strpos( $name, 'hortcode' ) ) {
					remove_filter( 'the_content', $name, $priority );
				}
			}
		}
	}
	global $post;
	the_post();
	$content = tm_agenda_content();
	$content = apply_filters( 'email_agenda', $content );

	global $wpdb;
	global $rsvp_options;
	global $current_user;
	global $open;
	if ( ! $post_id ) {
		$post_id = (int) $_REQUEST['open_roles'];
	}
	$permalink = rsvpmaker_permalink_query( $post_id );
	$row       = get_rsvp_event( " ID = $post_id " );
	// year not necessary in this context
	$dateformat = str_replace( ', ', '', str_replace( 'Y', '', $rsvp_options['long_date'] ) );

	if ( get_option( 'wp4toastmasters_agenda_timezone' ) ) {
		$time_format = $dateformat . ' ' . $rsvp_options['time_format'];
	} else {
		$time_format = $dateformat;
	}
	rsvpmaker_fix_timezone();
	$date = rsvpmaker_date( $time_format, rsvpmaker_strtotime( $row->datetime ) );

	$header   = '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
' . wpt_default_agenda_css() . "\n" . get_option( 'wp4toastmasters_agenda_css' ) . '
#message p, #message li {
font-size: 16px;
}
</style>';
//
//'js/tinymce/plugins/compat3x/plugin.min.js?ver='.time()
if(empty($_POST))
$header .= sprintf("<script src='%s' id='wp-tinymce-js'></script>",includes_url('/js/tinymce/tinymce.min.js?ver='.time()));
$header .= '</head>
<body>
';
	$output   = '';
	if(isset($_GET['test'])) {
		$members = get_users('blog_id='.get_current_blog_id());
		foreach($members as $index => $member) 
			$output .= $index.': '.$member->display_name.'<br />';	
	}
	
	$openings = 0;
	if ( $open ) {
		$output .= '<h3>' . __( 'Open Roles', 'rsvpmaker-for-toastmasters' ) . "</h3>\n<p>";

		foreach ( $open as $role => $count ) {
			$output .= $role;
			if ( $count > 1 ) {
				$output .= ' (' . $count . ')';
			}
			$output   .= "<br />\n";
			$openings += $count;
		}
		$output .= "</p>\n<p>" . __( 'Sign up at', 'rsvpmaker-for-toastmasters' ) . ' <a href="' . $permalink . '">' . $permalink . "</a></p>\n<p>" . __( 'Forgot your password?', 'rsvpmaker-for-toastmasters' ) . ' <a href="' . site_url( '/wp-login.php?action=lostpassword' ) . '">' . __( 'Reset your password here', 'rsvpmaker-for-toastmasters' ) . "</a></p>\n<h3>" . __( 'Roster', 'rsvpmaker-for-toastmasters' ) . "</h3>\n";
	}
	// print_r($open);
	$output .= $content;

	if ( isset($_POST) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		if ( ! empty( $_POST['test'] ) && ! empty( $_POST['testto'] ) ) {
			$mail['to'] = sanitize_text_field($_POST['testto']);
		} else {
			$blogusers = get_users( 'blog_id=' . get_current_blog_id() );
			foreach ( $blogusers as $user ) {
				// print_r($user);
				$emails[] = $user->user_email;
			}
		}
		if ( isset( $_POST['note'] ) && $_POST['note'] && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
			$output = '<div id="message">' . wp_kses_post(stripslashes( $_POST['note'] )) . "</div>\n<p>Sent by: " . $current_user->display_name . ' <a href="mailto:' . $current_user->user_email . '">' . $current_user->user_email . "</a>\n" . $output;
		}
		$mail['html']     = $header . $output . '</body></html>';
		$mail['from']     = $current_user->user_email;
		$mail['fromname'] = get_bloginfo( 'name' ) . ' / ' . $current_user->display_name;
		$mail['subject']  = sanitize_text_field( stripslashes( $_POST['subject'] ) );

if ( isset( $emails ) && is_array( $emails ) ) {
			rsvpmaker_qemail ($mail, $emails);			
			echo "<p>Sending to club members</p>";
		} else {
			echo awemailer( $mail );
			echo "<p>Sending to ".$mail['to']."</p>";
		}
		// output without form
		$output = $header . $output . '</body></html>';
	} elseif ( ! $scheduled ) {
		$subject = __( 'Agenda for', 'rsvpmaker-for-toastmasters' ) . ' ' . $date;
		if ( $openings ) {
			$subject .= ' (' . $openings . ' ' . __( 'open roles', 'rsvpmaker-for-toastmasters' ) . ')';
		}
		$subject = get_bloginfo( 'name' ) . ' ' . $subject;
		$mailform = '<script>
	tinymce.init({
		selector:"textarea",plugins: "link",
		block_formats: "Paragraph=p",
		menu: {
		format: { title: "Format", items: "bold italic | removeformat" },
		style_formats: [
		{ title: "Inline", items: [
			{ title: "Bold", format: "bold" },
			{ title: "Italic", format: "italic" },
		]},]},
		toolbar: "bold italic link",
		});	
	</script><h3>' . __( 'Add a Note', 'rsvpmaker-for-toastmasters' ) . '</h3>
	<p>' . __( 'Your note will be emailed along with the agenda and details about which roles are filled or open. You can change the subject line to emphasize the roles you need filled or special plans for a meeting (such as a contest).', 'rsvpmaker-for-toastmasters' ) . '</p>
	<form method="post" action="' . $permalink . 'email_agenda=1">
Subject: <input type="text" name="subject" value="' . $subject . '" size="60"><br />
<textarea name="note" rows="5" cols="80"></textarea><br />
<input type="radio" name="test" value="0" checked="checked" > ' . __( 'Send to all members', 'rsvpmaker-for-toastmasters' ) . ' <input type="radio" name="test" value="1" > ' . __( 'Send test to', 'rsvpmaker-for-toastmasters' ) . ': <input type="text" name="testto" /><br />
<input type="submit" value="Send" />
' . rsvpmaker_nonce('return'). '
</form>';

		$output = $header . $mailform . $output.'</body></html>';
	}

	echo $output;

	exit();
}

function backup_speaker_notify( $assigned ) {
	global $post;
	global $wpdb;
	global $rsvp_options;

	if ( ! is_rsvpmaker_future( $post->ID ) ) {
		return;
	}

		$datetime    = get_rsvp_date( $post->ID );
		$meetingdate = rsvpmaker_date( $rsvp_options['short_date'], rsvpmaker_strtotime( $datetime ) );

		$meeting_leader = get_post_meta( $post->ID, 'meeting_leader', true );
	if ( empty( $meeting_leader ) ) {
		$meeting_leader = '_Toastmaster_of_the_Day_1';
	}
		$toastmaster = (int) get_post_meta( $post->ID, $meeting_leader, true );

	if ( $toastmaster ) {
		$tmdata       = get_userdata( $toastmaster );
		$leader_email = $tmdata->user_email;
	} else {
		$leader_email = get_option( 'admin_email' );
	}

			$speakerdata     = get_userdata( $assigned );
			$subject         = $message = sprintf( '%s %s ', $speakerdata->first_name, $speakerdata->last_name ) . __( 'now scheduled to speak on', 'rsvpmaker-for-toastmasters' ) . ' ' . $meetingdate;
			$url             = rsvpmaker_permalink_query( $post->ID );
			$mail['subject'] = substr( strip_tags( $subject ), 0, 100 );
			$message        .= "\n\n" . __( 'Backup speaker promoted to speaker following a cancellation.', 'rsvpmaker-for-toastmasters' );

			$footer = "\n\n" . __( 'This is an automated message. Replies will be sent to', 'rsvpmaker-for-toastmasters' ) . ' ' . $leader_email;
	if ( $toastmaster ) {
		$footer .= ' Toastmaster of the Day ' . $tmdata->display_name;
	}
			$p                = get_permalink( $post->ID );
			$footer          .= "\n\nTo remove yourself from the agenda, visit " . sprintf( '<a href="%s">%s</a>', $p, $p );
			$mail['html']     = "<html>\n<body>\n" . wpautop( $message . $footer ) . "\n</body></html>";
			$mail['replyto']  = $leader_email;
			$mail['to']       = $speakerdata->user_email;
			$mail['from']     = $leader_email;
			$mail['fromname'] = get_bloginfo( 'name' );
			$result           = awemailer( $mail ); // notify speaker

			$footer           = "\n\nThis is an automated message. Replies will be sent to " . $speakerdata->user_email;
			$mail['html']     = "<html>\n<body>\n" . wpautop( $message . $footer ) . "\n</body></html>";
			$mail['replyto']  = $speakerdata->user_email;
			$mail['to']       = $leader_email;
			$mail['from']     = $speakerdata->user_email;
			$mail['fromname'] = $speakerdata->display_name;
			$result           = awemailer( $mail ); // notify leader
}

