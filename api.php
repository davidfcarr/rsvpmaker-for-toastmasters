<?php

class Toast_Norole_Controller extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'norole/(?P<post_id>[0-9]+)';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'get_items' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;
	}

	public function get_items( $request ) {
		$post_id  = intval($request['post_id']);
		$norole = wpt_norole($post_id);
		return new WP_REST_Response( $norole, 200 );
	}
}

class WPTContest_Order_Controller extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'wptcontest/v1';
		$path      = 'order/(?P<post_id>[0-9]+)';// (?P<nonce>.+)

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'get_items' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;
	}

	public function get_items( $request ) {
		global $wpdb;
		$order = get_post_meta( $request['post_id'], 'tm_scoring_order', true );
		return new WP_REST_Response( $order, 200 );
	}
}

class WPTContest_Send_Link extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'wptcontest/v1';
		$path      = 'send_link';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'POST',
					'callback'            => array( $this, 'get_items' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return is_user_logged_in();
	}

	public function get_items( $request ) {
		global $current_user;
		$email            = sanitize_text_field($_POST['email']);
		$note             = wpautop( wp_kses_post(stripslashes( $_POST['note'] ) ) );
		$mail['subject']  = sanitize_text_field(stripslashes( $_POST['subject'] ));
		$code             = sanitize_text_field($_POST['code']);
		$post_id          = (int) $_POST['post_id'];
		$mail['to']       = $email;
		$mail['html']     = $note;
		$mail['from']     = $current_user->user_email;
		$mail['fromname'] = $current_user->display_name;
		$error            = rsvpmailer( $mail );
		if ( $error ) {
			return new WP_REST_Response( $error, 200 );
		}
		return new WP_REST_Response( $mail, 200 );
	}
}

class WPTContest_VoteCheck extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'wptcontest/v1';
		$path      = 'votecheck/(?P<post_id>[0-9]+)';// (?P<nonce>.+)

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'get_items' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		global $current_user;
		if ( current_user_can( 'manage_options' ) ) {
			return true;
		}
		$post_id         = $request['post_id'];
		$dashboard_users = get_post_meta( $post_id, 'tm_contest_dashboard_users', true );
		return in_array( $current_user->ID, $dashboard_users );
	}

	public function get_items( $request ) {
		global $wpdb, $current_user;
		$post_id = $request['post_id'];
		$votes   = toast_scoring_update_get( $post_id );
		return new WP_REST_Response( $votes, 200 );
	}
}


class WPTContest_GotVote extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'wptcontest/v1';
		$path      = 'votereceived/(?P<post_id>[0-9]+)/(?P<judge_id>[0-9]+)';// (?P<nonce>.+)

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'get_items' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;
	}

	public function get_items( $request ) {
		global $wpdb;
		$confirmed = (bool) get_post_meta( $request['post_id'], 'tm_vote_received' . $request['judge_id'], true );
		return new WP_REST_Response( $confirmed, 200 );
	}
}
// check for update_post_meta($post_id,'tm_vote_received'.$index,true);

class WPT_Timer_Control extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'toasttimer/v1';
		$path      = 'control/(?P<post_id>[0-9]+)';// (?P<nonce>.+)

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => array( 'GET', 'POST' ),
					'callback'            => array( $this, 'get_items' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;
	}

	public function get_items( $request ) {
		if ( ! empty( $_POST ) ) {
			$control = array_map('sanitize_text_field',$_POST);
			update_post_meta( $request['post_id'], 'timing_light_control', $control );
		}
		// else
		$control = get_post_meta( $request['post_id'], 'timing_light_control', true );
		return new WP_REST_Response( $control, 200 );
	}
}

class Toast_Agenda_Timing extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'agendatime/(?P<post_id>[0-9]+)';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'get_items' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;
	}

	public function get_items( $request ) {
		$timing = get_agenda_timing( $request['post_id'] );
		return new WP_REST_Response( $timing, 200 );
	}
}

class Toast_Manual_Lookup extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'type_to_manual/(?P<type>.+)';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'get_items' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;
	}

	public function get_items( $request ) {
		$type     = urldecode( $request['type'] );
		$options  = get_manuals_by_type_options( $type );
		$projects = '';
		$pa       = get_projects_array( 'options' );
		/*
		  echo '<br />';
		print_r($type);
		echo '<br />';
		print_r($pa);
		echo '<br />Options<br />';
		print_r($options);
		*/
		if ( $type == 'Other' ) {
			$manual = 'Other Manual or Non Manual Speech';
		} elseif ( $type == 'Manual' ) {
			$manual = 'COMPETENT COMMUNICATION';
		} elseif ( $type == 'Pathways 360' ) {
			$manual = 'Pathways 360 Level 5 Demonstrating Expertise';
		} elseif ( $type == 'Pathways Mentor Program' ) {
			$manual = 'Pathways Mentor Program Level 1 Educational Program';
		} else {
			$manual = $type . ' Level 1 Mastering Fundamentals';
		}
		if ( strpos( $manual, 'ways 360' ) ) {
			$projects = '<option value="Pathways 360 Level 5 Demonstrating Expertise 99">Pathways 360° Evaluation</option>';
		} else {
			$projects = '<option value="">Select Project</option>' . $pa[ $manual ];
		}
		return new WP_REST_Response(
			array(
				'list'     => $options,
				'projects' => $projects,
			),
			200
		);
	}
}

class Editor_Assign extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'editor_assign';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return ( wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) && is_user_logged_in() && current_user_can( 'edit_signups' ) );
	}

	public function handle( $request ) {
		global $wpdb, $current_user;
		$post_id   = (int) $_POST['post_id'];
		$user_id   = (int) $_POST['user_id'];
		$role      = sanitize_text_field( $_POST['role'] );
		$editor_id = ( empty( $_POST['editor_id'] ) ) ? $current_user->ID : (int) $_POST['editor_id'];
		$timestamp = get_rsvp_date( $post_id );
		$was       = (int) get_post_meta( $post_id, $role, true );
		do_action('toastmasters_agenda_change',$post_id,$role,$user_id,$was,$editor_id);
		update_post_meta( $post_id, $role, $user_id );
		if ( strpos( $role, 'Speaker' ) ) {
			delete_post_meta( $post_id, '_manual' . $role );
			delete_post_meta( $post_id, '_project' . $role );
			delete_post_meta( $post_id, '_title' . $role );
			delete_post_meta( $post_id, '_intro' . $role );
		}
		$name   = get_member_name( $user_id );
		$status = sprintf( '%s assigned to %s', preg_replace( '/[\_0-9]/', ' ', $role ), $name );
		$log    = get_member_name( $editor_id ) . ' assigned ' . clean_role( $role ) . ' to ' . get_member_name( $user_id ) . ' for ' . $timestamp;
		if ( $was ) {
			$log .= ' (was: ' . get_member_name( $was ) . ')';
		}
		$log .= ' <small><em>(Posted: ' . rsvpmaker_date( 'm/d/y H:i' ) . ')</em></small>';

		add_post_meta( $post_id, '_activity_editor', $log );
		$type     = '';
		$manual   = '';
		$projects = '';
		$options  = '';
		if ( strpos( $role, 'peaker' ) ) {
			$track  = get_speaking_track( $user_id );
			$type   = $track['type'];
			$manual = $track['manual'];
			if ( ! empty( $manual ) && ! strpos( $manual, 'Manual' ) ) {
				update_post_meta( $post_id, '_manual' . $role, $manual );
			}
			$options  = sprintf( '<option value="%s">%s</option>', $track['manual'], $track['manual'] );
			$options .= get_manuals_by_type_options( $type );
			$projects = '<option value="">Select Project</option>' . $track['projects'];
		}
		return new WP_REST_Response(
			array(
				'status'   => $status,
				'type'     => $type,
				'list'     => $options,
				'projects' => $projects,
			),
			200
		);
	}
}

class TM_Role extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'tm_role';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return ( is_user_logged_in() );
	}

	public function handle( $request ) {

		if(isset($_POST['suggest_note']))
			$response['content'] = wpt_suggest_role();
		elseif(isset($_POST['away_user_id']))
			$response['content'] = wpt_api_add_absence();
		else
			$response['content'] = toastmasters_role_signup();
		return new WP_REST_Response( $response, 200 );
	}
}

function wpt_api_add_absence() {
	$away_user_id = intval($_POST['away_user_id']);
	$post_id = intval($_POST['post_id']);
	add_post_meta( $post_id, 'tm_absence', $away_user_id );
	return get_member_name($away_user_id)." added to absences.";
}

function wpt_suggest_role() {
	global $current_user, $rsvp_options;
	$post_id = intval($_POST['post_id']);
	$roletag = sanitize_text_field($_POST['role']);
	$role = clean_role($roletag);
	$member_id = intval($_POST['user_id']);
	$member = get_userdata($member_id);
	$post_id = intval($_POST['post_id']);
	$t = get_rsvpmaker_timestamp( $post_id );
	$date = rsvpmaker_date($rsvp_options['short_date'],$t);
	$cleanrole = clean_role($_POST['role']);
	$nonce = get_post_meta($post_id,'oneclicknonce',true);
	if(empty($nonce)) {
		$nonce = wp_create_nonce('oneclick');
		update_post_meta($post_id,'oneclicknonce',$nonce);
	}
	$url = add_query_arg(array('oneclick' => $nonce,'role' => rawurlencode($role),'member' => $member_id),get_permalink($post_id)).'#oneclick';
	$link = sprintf('<a href="%s" style="display:block; width: 150px; text-align: center; text-decoration: none; background-color: black; color: white; border: thin solid gray; font-weight:bold; font-size:large; padding: 5px;">%s</a> <br>%s <a href="%s">%s</a>', $url, __('Take Role','rsvpmaker-for-toastmasters'), __('or click','rsvpmaker-for-toastmasters'), $url, $url );
	$templates = get_rsvpmaker_notification_templates();
	$template = $templates['suggest'];
	$note = '';
	if(!empty($_POST['suggest_note'])){
		$note = wpautop(stripslashes($_POST['suggest_note']));
		$note = wp_kses_post($note);	
	}
	$mail['subject'] = str_replace('[rsvpdate]',$date,str_replace('[wptrole]',$cleanrole,$template['subject']));//$cleanrole,$date);
	$mail['html'] = wpautop(str_replace('[custom_message]',$note,$template['body']));//$cleanrole,$date);
	$mail['html'] = str_replace('[oneclicklink]',$link,$mail['html']);
	$mail['fromname'] = $current_user->display_name;
	$mail['from'] = $current_user->user_email;
	$mail['to'] = $member->user_email;
	$mail['override'] = 1;//works with rsvpmailer override on toastmost
	if(2 != (int) $_POST['ccme'])
		rsvpmailer($mail);
	$msg = $mail['html'];
	if(!empty($_POST['ccme']))
	{
		$mail['to'] = $current_user->user_email;
		$mail['subject'] = '(For '.$member->user_email.') '.$mail['subject'];
		if(!empty($member->mobile_phone)) {
			$mail['html'] .= "\n" . sprintf('<p><br><br>Mobile: <a href="tel:%s">%s</p>',$member->mobile_phone,$member->mobile_phone);
			$mail['html'] .= sprintf("<p>Text message version<br><br></p><p>Nominating you for %s on %s<br>To accept %s<br>(no password required)<br><br></p>",$cleanrole, $date, $url);
		}
		if(!empty($member->home_phone)) {
			$mail['html'] .= "\n" . sprintf('<p>Home: <a href="tel:%s">%s</p>',$member->home_phone,$member->home_phone);
		}
		if(!empty($member->work_phone)) {
			$mail['html'] .= "\n" . sprintf('<p>Work: <a href="tel:%s">%s</p>',$member->work_phone,$member->work_phone);
		}
		$mail['html'] .= (1 == (int) $_POST['ccme']) ? '<p>'.__('Sent to member','rsvpmaker-for_toastmasters').'</p>' : '<p>'.__('Sent ONLY to you','rsvpmaker-for_toastmasters').'</p>';
		rsvpmailer($mail);
	}
	add_post_meta($post_id,'_suggest'.$roletag,$member_id);
	return '<p>Message sent:'.$msg.'</p>';
}

class WPTM_Reports extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'reports/(?P<report>.+)/(?P<user_id>[0-9]+)';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return ( is_user_logged_in() && current_user_can( 'view_reports' ) );
	}

	public function handle( $request ) {
		global $wpdb;
		$report  = $request['report'];
		$user_id = $request['user_id'];
		$content = '';
		if ( $report == 'speeches_by_manual' ) {
			$content = speeches_by_manual( $user_id );
		} elseif ( $report == 'traditional_program' ) {
			$content = toastmasters_progress_report( $user_id );
		} elseif ( $report == 'traditional_advanced' ) {
			ob_start();
			if ( $user_id ) {
				$userdata = get_userdata( $user_id );
				toastmasters_advanced_user( $userdata, true );
			} else {
				echo 'Select member from the list above';
				echo toastmasters_advanced();
			}
			$content = ob_get_clean();
		} elseif ( $report == 'pathways' ) {
			ob_start();
			pathways_report( $user_id );
			$content = ob_get_clean();
		}
		return new WP_REST_Response(
			array(
				'report'  => $report,
				'content' => $content,
			),
			200
		);
	}
}

class WPTM_Dues extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'dues';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		$nonce = sanitize_text_field($_POST['tmn']);
		return ( wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) && is_user_logged_in() && current_user_can( 'view_reports' ) );
	}

	public function handle( $request ) {
		global $wpdb, $current_user;
		$confirmation = array();
		$paidkey      = sanitize_text_field($_POST['paidkey']);
		$norenew      = sanitize_text_field($_POST['norenew']);
		$member_id = intval($_POST['member_id']);
		$blog_id = intval($_POST['blog_id']);
		$paidkey = "TIpayment_".get_current_blog_id()."_".$_POST['until'];
		$until_key = "paid_until_".get_current_blog_id();
		$paid_to_ti = (empty($_POST['paid_to_ti'])) ? 0 : sanitize_text_field($_POST['paid_to_ti']);
		if ( isset( $_POST['markpaid'] ) && ('1' == $_POST['markpaid']) ) {
			$until = sanitize_text_field($_POST['until']);
			update_user_meta( $member_id, $until_key, $until );
			delete_user_meta( $member_id, $norenew );
			$confirmation['marked_paid'] = 'Marked paid until ' . $until;
		}
		if($paid_to_ti) {
			update_user_meta($member_id,$paidkey,$paid_to_ti);
			$confirmation['paid_to_ti'] = "$member_id $paidkey $paid_to_ti";
		}

		if ( isset( $_POST['updatevoid'] ) && is_numeric( $_POST['updatevoid'] ) ) {
			$member_id = (int) $_POST['updatevoid'];
			delete_user_meta( $member_id, $ti_paid_key );
			delete_user_meta( $member_id, $paidkey );
			delete_user_meta( $member_id, $norenew );
			$confirmation['paid_ti'] = 'Voided ';
		}

		if ( isset( $_POST['no'] ) ) {
			foreach ( $_POST['no'] as $member_id => $until ) {
				$member_id = (int) $member_id;
				$until = sanitize_text_field($until);
				update_user_meta( $member_id, $norenew, $until );
				$confirmation['no_renewal'] = 'Marked not planning to renew';
			}
		}

		if ( ! empty( $_POST['note'] ) ) {
			$member_id = sanitize_text_field($_POST['member_id']);
			$note      = '<strong>' . sanitize_textarea_field(stripslashes( $_POST['note'] )) . '</strong> (' . $current_user->display_name . ') ' . rsvpmaker_date( 'F j, Y' );
			$key       = sanitize_text_field($_POST['treasurer_note_key']);
			add_user_meta( $member_id, $key, $note );
			$confirmation['note'] = $note;
		}

		$confirmation['member_id'] = $member_id;
		return new WP_REST_Response( $confirmation, 200 );
	}
}

class WPTM_Money extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'money';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return ( is_user_logged_in() && current_user_can( 'view_reports' ) );
	}

	public function handle( $request ) {
		$result = wpt_stripe_transactions();
		return new WP_REST_Response( $result, 200 );
	}
}

class WPTM_Reminders extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'duesreminders';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return ( is_user_logged_in() && current_user_can( 'view_reports' ) );
	}

	public function handle( $request ) {
		$result['content'] = wpt_dues_reminders();
		return new WP_REST_Response( $result, 200 );
	}
}

class WPTM_Verify extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'verify/(?P<action>[a-z_]+)';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;
	}

	public function handle( $request ) {
		$result['action'] = $request['action'];
		$result['result'] = get_transient( $request['action'] );
		return new WP_REST_Response( $result, 200 );
	}
}

class WPTM_Tweak_Times extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'tweak_times';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'POST,GET',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return is_user_logged_in();
	}

	public function handle( $request ) {
		global $wpdb, $current_user;

		if ( isset( $_GET['post_id'] ) ) {
			global $rsvp_options;
			$post  = get_post( (int) $_GET['post_id'] );
			if(!$post)
				return new WP_REST_Response( array('error' => 'no post found'), 200 );
			$time_format = str_replace( 'T', '', $rsvp_options['time_format'] );
			if ( rsvpmaker_is_template( $post->ID ) ) {
				$sked = get_template_sked( $post->ID );
				$date = '2030-01-01 ' . $sked['hour'] . ':' . $sked['minutes'];
			} else {
				$date = get_rsvp_date( $post->ID );
			}

			$ts_start   = rsvpmaker_strtotime( $date );
			$elapsed    = 0;
			$time_array = array();
			$pattern    = '|<!-- wp:wp4toastmasters/agendanoterich2[^>]+>(.+)<!-- /wp:wp4toastmasters/agendanoterich2 -->|sU';
			$pattern    = '/<p class="wp-block-wp4toastmasters-agendanoterich2">(.+)/';
			preg_match_all( $pattern, $post->post_content, $matches );
			$notes       = $matches[1];
			$output      = '';
			$lines       = explode( "\n", $post->post_content );
			$block_count = 0;
			$update      = false;
			$new         = '';
			foreach ( $lines as $index => $line ) {
				$pattern = '/{"role":[^}]+}/';
				preg_match( $pattern, $line, $match );
				if ( ! empty( $match[0] ) ) {
					$data[] = (array) json_decode( $match[0] );
				} elseif ( strpos( $line, '-- wp:wp4toastmasters/agendanoterich2' ) || strpos( $line, '-- wp:wp4toastmasters/agendaedit' ) ) {
					$pattern = '/{.+}/';
					preg_match( $pattern, $line, $match );
					if ( ! empty( $match[0] ) ) {
						$atts   = (array) json_decode( $match[0] );
						$data[] = $atts;
						// $block_count++;
					}
				}
				$new .= $line . "\n";
			}

			$block_count = 0;
			$output      = array();
			$rawdata     = wpt_blocks_to_data( $new );
			foreach ( $data as $d ) {
				$t               = $ts_start + ( $elapsed * 60 );
				$waselapsed      = $elapsed;
				$start_time_text = rsvpmaker_date( $time_format, $t );
				if ( ! $start_time_text ) {
					$start_time_text = rsvpmaker_date( 'h:i A', $t );
				}
				$start_time = $elapsed;

				$time_allowed = ( empty( $d['time_allowed'] ) ) ? 0 : (int) $d['time_allowed'];

				$padding_time = ( ! empty( $d['role'] ) && ( $d['role'] == 'Speaker' ) && ! empty( $d['padding_time'] ) ) ? (int) $d['padding_time'] : 0;

				$add = $time_allowed + $padding_time;

				$elapsed += $add;

				if ( ! empty( $d['role'] ) ) {
					  $start = ( empty( $d['start'] ) ) ? 1 : $d['start'];
					  $index = str_replace( ' ', '_', $d['role'] );
					  $label = $d['role'];
				} elseif ( ! empty( $d['uid'] ) ) {
					$start = 1;
					$label = $d['uid'];
					if ( strpos( $label, 'ote' ) ) {
						$note = array_shift( $notes );
						if ( $note ) {
							$label = trim( strip_tags( $note ) );
						}
					}
					if ( ! empty( $d['editable'] ) ) {
						$label = $d['editable'];
					}
				} else {
					continue;
				}
				$output[] = array(
					'label'   => $label,
					'time'    => $start_time_text,
					'elapsed' => $waselapsed,
					'add'     => $add,
				);
				$block_count++;
			}
			$t               = $ts_start + ( $elapsed * 60 );
			$start_time_text = rsvpmaker_date( $time_format, $t );
			$start_time_text = rsvpmaker_date( $time_format, $t );
			if ( ! $start_time_text ) {
				$start_time_text = rsvpmaker_date( 'h:i A', $t );
			}

			$output[] = array(
				'label'   => 'End',
				'time'    => $start_time_text,
				'elapsed' => $elapsed,
				'add'     => 0,
			);
			return new WP_REST_Response( $output, 200 );
		}
		// }

		$post_id     = (int) $_POST['post_id'];
		$post        = get_post( $post_id );
		$lines       = explode( "\n", $post->post_content );
		$block_count = 0;
		$update      = '';
		$log         = '';
		foreach ( $lines as $line ) {
			$pattern = '/{"role":[^}]+}/';
			preg_match( $pattern, $line, $match );
			if ( ! empty( $match[0] ) ) {
				$atts   = json_decode( $match[0] );
				$index  = str_replace( ' ', '_', $atts->role ) . '-';
				$index .= ( empty( $atts->start ) ) ? '1' : $atts->start;
				$log   .= $index . "\n";
				if ( isset( $_POST['remove'][ $index ] ) ) {
					$update .= "\n";
					$log .= "remove $index \n";
					continue;
				} else {
					$log               .= "update $index \n";
					$atts->time_allowed = sanitize_text_field($_POST['time_allowed'][ $index ]); // numeric string
					$atts->padding_time = sanitize_text_field($_POST['padding_time'][ $index ]);
					$atts->count        = (int) $_POST['count'][ $index ];
				}
				$line = preg_replace( $pattern, json_encode( $atts ), $line );
			} elseif ( strpos( $line, '-- wp:wp4toastmasters/agendanoterich2' ) || strpos( $line, '-- wp:wp4toastmasters/agendaedit' ) ) {
				// if(!is_numeric(trim($_POST['time_allowed'][$block_count])))
				// return new WP_REST_Response(array('error' => 'non-numeric data'), 200);
				$pattern = '/{.+}/';
				preg_match( $pattern, $line, $match );
				if ( ! empty( $match[0] ) ) {
					$atts  = json_decode( $match[0] );
					$index = str_replace( '.', '_', $atts->uid );
					$log  .= "$index \n";
					if ( isset( $_POST['remove'][ $index ] ) ) {
						$log    .= "remove $index \n";
						$update .= "\n";
						if ( ! strpos( $line, 'editable' ) ) {
							foreach ( $lines as $line ) {
								if ( strpos( $line, 'wp:wp4toastmasters' ) ) {
									break;// eat up lines until close
								}
							}
							continue;
						}
					} else {
						$log .= "update $index \n";
						if ( isset( $atts->editable ) ) {
							  $labels[ $atts->uid ] = $atts->editable;
						}
						$atts->time_allowed = sanitize_text_field($_POST['time_allowed'][ $index ]);
						$line               = preg_replace( $pattern, json_encode( $atts ), $line );
					}
				}
			}
			$log    .= "line: $line\n";
			$update .= $line . "\n";
		}
		$edits = array();
		if ( isset( $_POST['edits'] ) ) {
			foreach ( $_POST['edits'] as $index ) {
				$index = sanitize_text_field($index);
				$note  = stripslashes( $_POST[ $index ] );
				$note  = preg_replace( '/(style=("|\Z)(.*?)("|\Z))/', '', $note );
				$note  = wp_filter_post_kses( $note );
				$index = str_replace( '_', '.', $index );
				update_post_meta( $post_id, 'agenda_note_' . $index, $note );
				$edits[] = $labels[ $index ];
			}
		}
		$up['ID']           = $post->ID;
		$up['post_content'] = $update;
		$response['return'] = wp_update_post( $up );
		$response['blocks'] = $block_count;
		$response['next']   = sprintf(
			'<p><a href="%s" target="_blank">View Agenda</a></p>',
			add_query_arg(
				array(
					'print_agenda' => 1,
					'no_print'     => 1,
				),
				get_permalink( $post->ID )
			)
		);
		$response['next']  .= sprintf( '<p><a href="%s">Signup</a></p>', get_permalink( $post->ID ) );
		$response['edits']  = $edits;
		if ( current_user_can( 'edit_post', $post ) ) {
			$edit              = get_edit_post_link( $post->ID );
			$response['next'] .= sprintf( '<p><a href="%s">Edit Event</a></p>', $edit );
		}
		if ( rsvpmaker_is_template( $post->ID ) ) {
			$response['next'] .= sprintf( '<p><a href="%s">Create/Update</a> events from tempate</p>', admin_url( 'edit.php?post_type=rsvpmaker&page=rsvpmaker_template_list&t=' . $post->ID ) );
		}
		rsvpmaker_fix_timezone();
		$response['next'] .= sprintf( '<p>Updated: %s</p>', rsvpmaker_date( 'r' ) );
		$response['note']  = $note;
		$response['log']   = $log;
		return new WP_REST_Response( $response, 200 );
	}
}

class WPTM_Regular_Voting extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'regularvoting/(?P<post_id>[0-9]+)';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;
	}

	public function handle( $request ) {
		$output = wptm_count_votes($request['post_id']);
		return new WP_REST_Response( $output, 200 );
	}
}

class WPTM_Reorder extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'reorder';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return true;
	}

	public function handle( $request ) {
		$post_id = (int) $_POST['post_id'];
		if ( ! $post_id ) {
			die( 'Post ID not set' );
		}
		$test = '';
		foreach ( $_POST as $name => $value ) {
			if ( is_array( $value ) ) {
				if ( $name == '_Speaker' ) {
					// print_r($value);
					$neworder = array();
					foreach ( $value as $assigned ) {
							$neworder[] = get_speaker_array( sanitize_text_field($assigned), $post_id );
					}
					foreach ( $neworder as $index => $speaker ) {
						save_speaker_array( $speaker, $index + 1, $post_id );
						$assigned = $speaker['ID'];
						if ( empty( $assigned ) ) {
							$assigned = '?';
						} elseif ( is_numeric( $assigned ) ) {
							$assigned_member = get_userdata( $assigned );
							$assignee        = $assigned_member->first_name . ' ' . $assigned_member->last_name;
						} else {
							$assignee = $assigned;
						}
						$test .= ', ' . ( $index + 1 ) . ': ' . $assignee;
					}
				} else {
					foreach ( $value as $index => $assigned ) {
						if ( empty( $assigned ) ) {
							$assigned = '?';
						} elseif ( is_numeric( $assigned ) ) {
							$assigned_member = get_userdata( $assigned );
							$assignee        = $assigned_member->first_name . ' ' . $assigned_member->last_name;
						} else {
							$assignee = $assigned;
						}
						update_post_meta( $post_id, $name . '_' . ( $index + 1 ), $assigned );
						$test .= ', ' . ( $index + 1 ) . ': ' . $assignee;
					}
				}
			}
		}
		$output = 'Saved. <a href="' . get_permalink( $post_id ) . '">Verify updated order</a>';
		return new WP_REST_Response( $output, 200 );
	}
}

class Editable_Note extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'editable_note_update';

		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}

	public function get_items_permissions_check( $request ) {
		return ( wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) && is_user_logged_in() && current_user_can( 'edit_signups' ) );
	}

	public function handle( $request ) {
		global $wpdb, $current_user;
		$post_id   = (int) $_POST['post_id'];
		$note      = wp_kses_post( stripslashes($_POST['agenda_note'][0]) );
		$note = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/si",'<$1$2>', $note); //strip style and other attributes
		$label = sanitize_text_field( $_POST['agenda_note_label'][0] );
		$result = update_post_meta($post_id,$label,$note);
		$message = '<p style="border: medium solid green; padding: 5px;">Updated. <a href="'.get_permalink($post_id).'">Reload the page</a> if you need to make further revisions.</p>';
		return new WP_REST_Response($message,200);
	}
}

add_action(
	'rest_api_init',
	function () {
		$toastnorole = new Toast_Norole_Controller();
		$toastnorole->register_routes();
		$order_controller = new WPTContest_Order_Controller();
		$order_controller->register_routes();
		$contest_sendlink = new WPTContest_Send_Link();
		$contest_sendlink->register_routes();
		$votecheck_controller = new WPTContest_VoteCheck();
		$votecheck_controller->register_routes();
		$gotvote_controller = new WPTContest_GotVote();
		$gotvote_controller->register_routes();
		$timer_controller = new WPT_Timer_Control();
		$timer_controller->register_routes();
		$manual = new Toast_Manual_Lookup();
		$manual->register_routes();
		$assign = new Editor_Assign();
		$assign->register_routes();
		$repo = new WPTM_Reports();
		$repo->register_routes();
		$dues = new WPTM_Dues();
		$dues->register_routes();
		$money = new WPTM_Money();
		$money->register_routes();
		$reminders = new WPTM_Reminders();
		$reminders->register_routes();
		$verify = new WPTM_Verify();
		$verify->register_routes();
		$role = new TM_Role();
		$role->register_routes();
		$tweak = new WPTM_Tweak_Times();
		$tweak->register_routes();
		$reg = new WPTM_Regular_Voting();
		$reg->register_routes();
		$reorder = new WPTM_Reorder();
		$reorder->register_routes();
		$editable = new Editable_Note();
		$editable->register_routes();
	}
);
