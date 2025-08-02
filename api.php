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
		if(wpt_exclude_agenda_functions())
			return false;
		return true;
	}
	public function get_items( $request ) {
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
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
		if(wpt_exclude_agenda_functions())
			return false;

		return true;
	}
	public function get_items( $request ) {
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
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
		if(wpt_exclude_agenda_functions())
			return false;

		return is_user_logged_in();
	}
	public function get_items( $request ) {
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
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
		if(wpt_exclude_agenda_functions())
			return false;

		global $current_user;
		if ( current_user_can( 'manage_options' ) ) {
			return true;
		}
		$post_id         = $request['post_id'];
		$dashboard_users = get_post_meta( $post_id, 'tm_contest_dashboard_users', true );
		return in_array( $current_user->ID, $dashboard_users );
	}
	public function get_items( $request ) {
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
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
		if(wpt_exclude_agenda_functions())
			return false;

		return true;
	}
	public function get_items( $request ) {
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
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
		if(wpt_exclude_agenda_functions())
			return false;

		return true;
	}
	public function get_items( $request ) {
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
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
		if(wpt_exclude_agenda_functions())
			return false;

		return true;
	}
	public function get_items( $request ) {
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
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
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
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
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
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
				'name'   => $name,
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
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
		if(isset($_POST['suggest_note']))
			$response['content'] = wpt_suggest_role($_POST);
		elseif(isset($_POST['away_user_id']))
			$response['content'] = wpt_api_add_absence();
		else
			$response['content'] = toastmasters_role_signup();
		do_action('rsvpmaker_log_array',
		array('meta_key' => 'agenda_activity',
		'meta_value' => $response['content'],
		));		
		return new WP_REST_Response( $response, 200 );
	}
}
function wpt_api_add_absence() {
	$away_user_id = intval($_POST['away_user_id']);
	$post_id = intval($_POST['post_id']);
	add_post_meta( $post_id, 'tm_absence', $away_user_id );
	return get_member_name($away_user_id)." added to absences.";
}
function wpt_suggest_role($postdata) {
	global $current_user, $rsvp_options;
	$post_id = intval($postdata['post_id']);
	$roletag = sanitize_text_field($postdata['role']);
	$role = clean_role($roletag);
	$member_id = intval($postdata['user_id']);
	$member = get_userdata($member_id);
	$t = get_rsvpmaker_timestamp( $post_id );
	$date = rsvpmaker_date($rsvp_options['short_date'],$t);
	$cleanrole = clean_role($postdata['role']);
	$nonce = get_post_meta($post_id,'oneclicknonce',true);
	if(empty($nonce)) {
		$nonce = wp_create_nonce('oneclick');
		update_post_meta($post_id,'oneclicknonce',$nonce);
	}
	$url = add_query_arg(array('oneclick' => $nonce,'role' => rawurlencode($role),'member' => $member_id,'by'=>$current_user->ID),get_permalink($post_id)).'#oneclick';
	$link = sprintf('<a href="%s" style="display:block; width: 150px; text-align: center; text-decoration: none; background-color: black; color: white; border: thin solid gray; font-weight:bold; font-size:large; padding: 5px; margin: 15px;">%s</a>', $url, __('Take Role','rsvpmaker-for-toastmasters') );
	$absence = add_query_arg(array('oneclick' => $nonce,'role' => 'absent','e' => '*|EMAIL|*','mode' => 'suggestall','by'=>$current_user->ID),get_permalink($post_id));
	$link .= '<p>Or let us know if you will not be able to attend.</p>'.sprintf('<a style="width: 150px; text-align: center; text-decoration: none; font-weight: bold; display: block; background-color: red; color: #FFFFFF; padding: 10px; margin: 15px;" href="%s#oneclick">Will Not Attend</a>',$absence);
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
	return '<p>From: '.$current_user->display_name.'<br>To: '.$member->display_name.'</p>'.$msg;
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
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
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
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
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
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
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
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
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
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
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
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
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
function wpt_mobile_auth($user_code = '') {
	global $current_user;
	if(is_user_logged_in() && is_user_member_of_blog($current_user->ID, get_current_blog_id()))
		return $current_user->ID;
	if(empty($user_code) && isset($_GET['mobile']) && !empty($_GET['mobile'])) {
		$user_code = sanitize_text_field($_GET['mobile']);
	}
	if(empty($user_code))
		return 0;

	if(strpos($user_code,'-')) {
		$parts = explode('-',$user_code);
		$user_id = intval($parts[0]);
		$saved_code = get_user_meta($user_id,'wpt_mobile_code',true);
		if($user_code == $saved_code) {
			$current_user = get_userdata($user_id);
			return $user_id;
		}
	}
	return 0;
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
					'methods'             => 'GET,POST',
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
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
		global $wpdb, $current_user;
		$post_id = intval($request['post_id']);
		if(0 == $post_id) {
			$meetings = future_toastmaster_meetings();
			if(sizeof($meetings))
				$post_id = $meetings[0]->ID;
		}
	if(!empty($_GET['mobile'])) {
		$identifier = sanitize_text_field($_GET['mobile']);
		$json = file_get_contents('php://input');
		if($json) {
			$data = json_decode($json);
		}
		$authorized = $current_user->ID ? $current_user->ID : wpt_mobile_auth();
		$votingdata['current_user'] = $current_user->ID;
		$votingdata['current_user_name'] = $current_user->display_name;
		$votingdata['post_id'] = $post_id;
		$votingdata['url'] = add_query_arg('meetingvote',1,get_permalink($post_id));
		$votingdata['login_url'] = wp_login_url(add_query_arg('meetingvote',1,get_permalink($post_id)));
		$votingdata['authorized_user'] = $authorized;
		$votingdata['identifier'] = $identifier;
		$votingdata['vote_counter'] = get_post_meta($post_id,'_role_Vote_Counter_1',true);
		$votecounter = ($votingdata['vote_counter']) ? get_userdata($votingdata['vote_counter']) : null;
		$votingdata['vote_counter_name'] = ($votecounter) ? $votecounter->display_name : '';
		$votingdata['is_vote_counter'] = $votingdata['vote_counter'] == $authorized;
		$votingdata['loginurl'] = wp_login_url(add_query_arg('meetingvote',1,get_permalink($post_id)));	
		$trans = wpt_mobile_translations();
		$votingdata['translations'] = ($trans && !empty($trans['translations'])) ? $trans['translations'] : array();
		$open = get_post_meta($post_id,'openvotes');
		$custom_club_contests = get_option('custom_club_contests');
		if(!is_array($custom_club_contests))
			$custom_club_contests = [];
		if(isset($data->deleteRecurring)) {
			$custom_club_contests = [];
			$shortened = array_diff($custom_club_contests,[$data->deleteRecurring]);
			foreach($shortened as $s) 
				$custom_club_contests[] = $s;
			update_option('custom_club_contests',$custom_club_contests,false);
			$votingdata['deleteRecurring'] = $data->deleteRecurring;
		}
		$votingdata['everyWeek'] = $custom_club_contests;
		if(isset($data) && isset($data->vote)) {
			$votingdata['data'] = $data;
			$vote = sanitize_text_field($data->vote);
			$key = sanitize_text_field($data->key);
			$metakey = 'myvote_'.$key.'_'.$identifier;
			if(!empty($data->signature))
				update_post_meta($post_id,'_signedvote_'.$key.$vote,sanitize_text_field($data->signature));
			add_post_meta($post_id,'audit_'.$metakey,$vote.' '.$_SERVER['REMOTE_ADDR'].' api '.date('r'));
			$votingdata['voterecorded'] = $metakey;
			update_post_meta($post_id,$metakey,$vote);
		}
		if(isset($data) && isset($data->email_link)) {
			$auth_user = get_userdata($authorized);
			$mail['from'] = $auth_user->user_email;
			$mail['fromname'] = $auth_user->display_name;
			$mail['subject'] = 'Voting link for '.get_bloginfo('name');
			$mobile_link = site_url('?toastmost_app_redirect=Voting&domain='.$_SERVER['SERVER_NAME']);
			$web_link = add_query_arg('meetingvote',1,get_permalink($post_id));
			$mail['html'] = sprintf('<p>To cast votes on the website, visit <a href="%s">%s</a></p>',$web_link,$web_link);
			$mail['html'] .= sprintf('<p>If you have the Toastmost mobile app on your phone, this link should open the <a href="%s">Voting screen</a> of the app.</p>',$mobile_link);
			if('all' == $data->email_link)
			{
				$blogusers = get_users( 'blog_id=' . get_current_blog_id() );
				foreach ( $blogusers as $user ) {
					$emails[] = $user->user_email;
				}
				rsvpmaker_qemail ($mail, $emails);	
			}
			else
			{
				$mail['to'] = $auth_user->user_email;
				rsvpmailer($mail);
			}
		}
		if(isset($data) && isset($data->take_vote_counter) && $authorized) {
			update_post_meta($post_id,'_role_Vote_Counter_1',$authorized);
			$votingdata['vote_counter'] = $authorized;
			$votingdata['is_vote_counter'] = true;
		}
		if(isset($data) && isset($data->ballot) && $authorized) {
			$ballot_array = (array) $data->ballot;
			foreach($ballot_array as $b => $params) {
				if(!empty($params->everyMeeting) && !in_array($b,$custom_club_contests))
				{
					$custom_club_contests[] = $b;
					update_option('custom_club_contests',$custom_club_contests,false);
					$votingdata['custom_club_contests'] = $b;
					unset($ballot_array[$b]->everyMeeting);//don't store this property
				}
			}
			update_post_meta($post_id,'tm_ballot',$ballot_array);
			$votingdata['ballot'] = $ballot_array;
		}
		if(isset($data) && isset($data->added) && $authorized) {
			update_post_meta($post_id,'added_votes',$data->added);
		}
		if(isset($data->reset)) {
			if($authorized) {
				delete_post_meta($post_id,'tm_ballot');
				$sql = "DELETE FROM $wpdb->postmeta WHERE post_id=$post_id AND (meta_key LIKE 'myvote%' or meta_key = 'added_votes' or meta_key LIKE '%ballot%' ) ";
				$wpdb->query($sql);	
				$votingdata['reset'] = $sql;
			}
			else {
				$votingdata['reset_error'] = 'not authorized';
			}
		}
		else
			$votingdata['ballot'] = get_post_meta($post_id,'tm_ballot',true);
		if( empty($votingdata['ballot']) ) {
				foreach(['Speaker','Evaluator'] as $role) {
					$sql = "select * from $wpdb->postmeta WHERE post_id=$post_id and meta_key LIKE '_role_$role%'";
					$results = $wpdb->get_results($sql);
					$votingdata[$role] = [];
					$ids = [];
					foreach($results as $row) {
						
						if(!empty($row->meta_value)) {
							if(is_numeric($row->meta_value)) {
								if($row->meta_value > 0) {
									if(!in_array($row->meta_key,$ids)) {
										$user = get_userdata($row->meta_value);
										$ids[] = $row->meta_key;
										$speaker_name = ($user->display_name) ? $user->display_name : $user->login_name;
									}
								}
							}
							else
								$speaker_name = $row->meta_value;
							$votingdata[$role][] = $speaker_name;
				}
				
				}
			}
			$emptyballot = array('status'=>'draft','contestants'=>[],'new'=>[],'deleted'=>[],'signature_required'=>false);
			$votingdata['ballot'] = array('Speaker'=> array('status'=>'draft','contestants'=>$votingdata['Speaker'],'new'=>[],'deleted'=>[],'signature_required'=>false),'Evaluator'=> array('status'=>'draft','contestants'=>$votingdata['Evaluator'],'new'=>[],'deleted'=>[],'signature_required'=>false),'Table Topics'=> $emptyballot,'Template'=> $emptyballot);
			
			if($custom_club_contests && is_array($custom_club_contests)) {
				foreach($custom_club_contests as $contest)
					$votingdata['ballot'][$contest] = $emptyballot;
			}
			
		}
		$votingdata['added_votes'] = get_post_meta($post_id,'added_votes',true);
		if(empty($votingdata['added_votes']))
			$votingdata['added_votes'] = array();
		$openvotes = [];
		if(sizeof($open))
		{
			foreach($open as $key => $value)
			{
				$vote_options = get_post_meta($post_id,'voting_'.$value,true);
				if(!is_array($vote_options))
					$vote_options = [];
				$open_label = get_post_meta($post_id,'votelabel_'.$value,true);
				$signature_required = boolval(get_post_meta($post_id,'signature_'.$value,true));
				$openvotes[] = array('key' => $value, 'label' => $open_label, 'options' => $vote_options,'signature' => $signature_required);
				$sql = "select count(*) from $wpdb->postmeta WHERE post_id=$post_id AND meta_key LIKE 'myvote_$value%' ";
				$metakey = 'myvote_'.$value.'_'.$identifier;
				$votingdata['myvotekey'][] = $metakey;
				$votingdata['myvote'][$value] = boolval(get_post_meta($post_id,$metakey, true));
				$votingdata['votesfor'][$value] = $wpdb->get_var($sql);
			}
		}
		$memberlist = [];
		$members = get_club_members();
		foreach($members as $member) {
			$memberlist[] = array('label'=>$member->display_name,'value'=>$member->display_name);
		}
		if(!empty($post_id)) {
			$names = [];
			$sql = "SELECT first, last from ".$wpdb->prefix."rsvpmaker WHERE event=$post_id";
			$rsvps = $wpdb->get_results($sql);
			if($rsvps) {
				foreach($rsvps as $rsvp) {
					$display_name = $rsvp->first.' '.$rsvp->last;
					if(!in_array($display_name,$memberlist))
						$memberlist[] = array('label'=>$display_name,'value'=>$display_name);
				}
			}
			$sql = "SELECT meta_value as display_name from $wpdb->postmeta WHERE post_id=$post_id and meta_key LIKE '_role_%'";
			$guestroles = $wpdb->get_results( $sql );
			if($guestroles) {
				foreach($guestroles as $row) {
					if(!is_numeric($row->display_name))
					{
						if(!in_array($row->display_name,$memberlist) || !in_array($row->display_name,$memberlist))
							$memberlist[] = array('label'=>$row->display_name,'value'=>$row->display_name);
					}
				}
			}
		}
		$votingdata['votecount'] = wptm_count_votes($post_id, $votingdata['added_votes']);
		$votingdata['memberlist'] = $memberlist;
		$votingdata['myvotes'] = [];
		$sql = "SELECT * FROM $wpdb->postmeta where post_id=".$post_id." AND meta_key LIKE 'myvote%_$identifier' ORDER BY meta_key, meta_value";
		error_log($sql);
		$results = $wpdb->get_results($sql);
		foreach($results as $row) {
			$parts = explode('_',$row->meta_key);
			$votingdata['myvotes'][] = $parts[1];
		}
		$votingdata['myvotesresults'] = $results;
	return new WP_REST_Response( $votingdata, 200 );
	}
		$output = wptm_count_votes($post_id);
		do_action('rsvpmaker_log_array',
	array('meta_key' => 'voting',
	'meta_value' => $output,
    ));
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
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
		$post_id = (int) $_POST['post_id'];
		if ( ! $post_id ) {
			die( 'Post ID not set' );
		}
		$test = '';
		foreach ( $_POST as $name => $value ) {
			if ( is_array( $value ) ) {
				if ( $name == '_role_Speaker' ) {
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
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
		global $wpdb, $current_user;
		$post_id   = (int) $_POST['post_id'];
		$note      = wp_kses_post( stripslashes($_POST['agenda_note'][0]) );
		$note = preg_replace('/style=[\'"][^"]+[\'"]/','', $note); //strip inline style
		$note = preg_replace('/h[0-9][^>]*>/','p>', $note); //no headings
		$label = sanitize_text_field( $_POST['agenda_note_label'][0] );
		$result = update_post_meta($post_id,$label,$note);
		$message = '<p style="border: medium solid green; padding: 5px;">Updated. <a href="'.get_permalink($post_id).'">Reload the page</a> if you need to make further revisions.</p>';
		return new WP_REST_Response($message,200);
	}
}
class Editable_Note_Json extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'editable_note_json';
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
		return true;// (!empty($_POST)) ? is_club_member() : true;
	}
	public function handle( $request ) {
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
		global $wpdb, $current_user;
		if(isset($_GET['post_id']) && isset($_GET['uid'])) {
			$post_id = intval($_GET['post_id']);
			$uid = sanitize_text_field($_GET['uid']);
			$note = get_post_meta($post_id,'agenda_note_'.$uid,true);
			return new WP_REST_Response(['post_id'=>$post_id,'uid'=>$uid,'note'=>$note],200);
		}
		else {
			$json = file_get_contents('php://input');
			$data = json_decode($json);
			$post_id = $data->post_id;
			$editable = $data->editable;
			if(current_user_can('edit_signups')) {
				$uid = $data->uid;
				$note = wp_kses_post($data->note);
				$note = preg_replace('/style=[\'"][^"]+[\'"]/','', $note); //strip inline style
				$note = preg_replace('/h[0-9][^>]*>/','p>', $note); //no headings
				update_post_meta($post_id,'agenda_note_'.$uid,$note);
				return new WP_REST_Response(['post_id'=>$post_id,'uid'=>$uid,'note'=>$note],200);
			}
			else 
				return new WP_REST_Response('failed permissions check user:'.$current_user->ID.' post '.$post->ID,200);
		}
	}
}
class WP4TBlocksData extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'blocks_data/(?P<post_id>[0-9]+)';
		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}
	public function get_items_permissions_check( $request ) {
		if(wpt_exclude_agenda_functions())
			return false;
		return true;
	}
	public function handle( $request ) {
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
		$agendadata = wpt_get_agendadata($request["post_id"]);
		return new WP_REST_Response($agendadata,
			200
		);
	}
}
function wpt_get_agendadata($post_id = 0, $render = true) {
	if(!$post_id)
		return [];
	global $current_user,$post;
	wpt_mobile_user_check();
	$all_assignments = wpt_all_assignments($post_id);
	$agendadata = [];
	$post = false;
	$meetings = future_toastmaster_meetings( 10 );
	$templates = rsvpmaker_get_templates();
	if($meetings)
		$meetings = [];
	$agendadata['current_user_id'] = ($current_user->ID && (is_club_member($current_user->ID)) || current_user_can('manage_network')) ? $current_user->ID : false;
	$agendadata['is_user_logged_in'] = is_user_logged_in(); // true for logged in users who are not members
	$agendadata['current_user_name'] = ($current_user->ID) ? get_member_name($current_user->ID) : '';
	$agendadata['newSignupDefault'] = (bool) get_option('wp4t_newSignupDefault');
	$agendadata['admin_url'] = admin_url();
	$agendadata['second_language_feedback'] = boolval(get_user_meta($current_user->ID,'second_language_feedback',true));
	$agendadata['upcoming'] = [];
	if($post_id) {
		$post = get_post($post_id);
	}
	elseif(sizeof($meetings)) {
			$post = $meetings[0];
			$post_id = $post->ID;
		}
	else {
		$post = array_shift($templates);
		$post_id = $post->ID;
	}
	$agendadata['postdata'] = var_export($post,true);
	$absences = get_post_meta( $post_id, 'tm_absence' );
	if ( is_array( $absences ) ) {
		$absences = array_unique( $absences );
	}
	else 
		$absences = [];
	$agendadata['absences'] = [];
	foreach($absences as $ab) {
		$agendadata['absences'][] = array('ID' => $ab, 'name' => get_member_name($ab));
	}
		$r       = get_role( 'subscriber' );
		$agendadata['subscribers_can_edit_signups'] = $r->has_cap( 'edit_signups' );
		$agendadata['subscribers_can_organize_agenda'] = $r->has_cap( 'organize_agenda' );
		$agendadata['permissionsurl'] = admin_url('options-general.php?page=wp4toastmasters_settings&rules=1#rules');
		$agendadata['wpt_rest'] = wpt_rest_array();
		$agendadata['post_id'] = $post_id;
		$agendadata['editor'] = admin_url('post.php?action=edit&post='.$post_id);
		$agendadata['request_evaluation'] = ($current_user->ID && wpt_user_is_speaker($current_user->ID,$post_id) ) ? add_query_arg('evalme',$current_user->ID,get_permalink()) : admin_url('admin.php?page=wp4t_evaluations&speaker='.$current_user->ID);
		if($meetings) {
			foreach($meetings as $meeting)
			$agendadata['upcoming'][]= array('value' => $meeting->ID, 'permalink' => get_permalink($meeting->ID),'edit_link' => admin_url('wp-admin/post.php?post='.$meeting->ID.'&action=edit'),'label' => preg_replace('/ [0-9]{2}:[0-9]{2}:[0-9]{2}/','',$meeting->datetime) .' '.$meeting->post_title);
		}
		if(current_user_can('edit_rsvpmakers'))
		{
			foreach($templates as $template) {
				$agendadata['upcoming'][]= array('value' => $template->ID, 'permalink' => get_permalink($template->ID),'edit_link' => admin_url('wp-admin/post.php?post='.$template->ID.'&action=edit'),'label' => 'Template: '.$template->post_title);
				$tids[] = $template->ID;
			}
		}
		if(isset($_GET['mode']) && ('evaluation_demo' == $_GET['mode'] ))
			{
				$agendadata['post_id'] = 0;
				$blocksdata = parse_blocks('<!-- wp:wp4toastmasters/role {"role":"Speaker"} /-->');
			}
		elseif(isset($_GET['admin']) && ('true' == $_GET['admin'] ))
			{
				$default_template_id = get_option( 'default_toastmasters_template' );
				$index = array_search($default_template_id,$tids);
				if($index !== false)
					$template = $templates[$index];
				else {
					$template = $templates[0];
				}
				$agendadata['post_id'] = $post_id = $template->ID;
				$blocksdata = parse_blocks($template->post_content);
			}
		else
			$blocksdata = parse_blocks($post->post_content);
	
		$agendadata['has_template'] = rsvpmaker_has_template($post_id);
		$agendadata['is_template'] = rsvpmaker_is_template($post_id);
			
		if($agendadata['is_template'])
		{
			$agendadata['datetime'] = '1924-10-22 '.$agendadata['is_template']['hour'].':'.$agendadata['is_template']['minutes'].':00';
			$agendadata['agenda_preview'] = get_permalink($post_id).'?print_agenda=1&no_print=1&mode=reorg_admin';
		}
		else {
			$agendadata['datetime'] = get_rsvp_date($post_id);
		}
		$agendadata['permissions'] = array('member' => is_club_member(), 'edit_post' => current_user_can('edit_post',$post_id),'edit_signups' => current_user_can('edit_signups'),'organize_agenda'=>current_user_can('organize_agenda'),'manage_options' => current_user_can('manage_options'));
		$agendadata['allmembers'] = awe_rest_user_options('',$post_id);
	
		//filter empty blocks. also remove promo content above the start of the agenda
		$agendastart = false;
		foreach($blocksdata as $block)
		{
			if(!empty($block["blockName"])) {
				if(strpos($block["blockName"],'wp4toastmasters') !== false) {
					$agendastart = true;
				}
				if($agendastart)
					$agendadata['blocksdata'][] = $block;
			}
		}
		if(!empty($agendadata['blocksdata']))
		foreach($agendadata['blocksdata'] as $index => $block) {
			if(!empty($block['attrs']['custom_role']))
				$agendadata['blocksdata'][$index]['attrs']['role'] = $block['attrs']['custom_role'];
			$agendadata['blocksdata'][$index]['DnDid'] = 'dnd'.$index;
			if('wp4toastmasters/agendaedit' == $block['blockName'] && !empty($block['attrs']['uid']))
				$agendadata['blocksdata'][$index]['edithtml'] = empty($all_assignments['agenda_note_'.$block['attrs']['uid']]) ? '' : $all_assignments['agenda_note_'.$block['attrs']['uid']];// get_post_meta($post_id,'agenda_note_'.$block['attrs']['uid'],true);
			elseif(isset($block['attrs']) && isset($block['attrs']['role']))
				{
					$agendadata['blocksdata'][$index]['memberoptions'] = awe_rest_user_options($block['attrs']['role'],$post_id);
					$agendadata['blocksdata'][$index]['assignments'] = [];
					$role = (!empty($block['attrs']['custom_role'])) ? $block['attrs']['custom_role'] : $block['attrs']['role'];
					$trans  = translate($role,'rsvpmaker-for-toastmasters');
					$agendadata['blocksdata'][$index]['attrs']['translated_role'] = ($trans != $role) ? $trans : '';
					$count = isset($block['attrs']['count']) ? $block['attrs']['count'] : 1;
					if('Speaker' == $role)
						pack_speakers($count,$agendadata['post_id']);
					$start = (isset($lastcount[$role])) ? $lastcount[$role] + 1 : 1;
					$agendadata['blocksdata'][$index]['attrs']['start'] = $start;
					$lastcount[$role] = (empty($lastcount[$role])) ? $count : + $count + $lastcount[$role];
					$backup = !empty($block['attrs']['backup']) ? 1 : 0;
					$blanks = array();
					for($i=$start; $i < ($count + $start); $i++)
					{
						$key = wp4t_fieldbase($role,$i);
						$assignment = array('post_id'=>$post_id);
						//$assignment['ID'] = get_post_meta($post_id,$key, true);
						$assignment['ID'] = empty($all_assignments[$key]) ? '' : $all_assignments[$key];
						if(empty($assignment['ID'])) {
							$assignment['name'] = '';
						}
						elseif(is_numeric($assignment['ID']))
							$assignment['name'] = get_member_name($assignment['ID']);
						else
							$assignment['name'] = $assignment['ID'].' (guest)';
						if($assignment['ID'] && ('Speaker' == $role)) {
							$speakerdata = extract_speaker_array($post_id, $key,$assignment['ID'],$all_assignments);
							$project_key = ($speakerdata['project']) ? $speakerdata['project'] : '';
							$speakerdata['evaluation_link'] = evaluation_form_url( $assignment['ID'], $post_id );//add_query_arg('evalme',$current_user->ID,get_permalink())
							$assignment = array_merge($assignment,$speakerdata);
						}
						if(isset($_GET['mode']) && 'reorg_admin' == $_GET['mode']) {
							if(!isset($democharacters)) {
								$democharacters = array('George Washington','John Adams','Thomas Jefferson','James Madison','James Monroe','John Quincy Adams','Andrew Jackson','Martin Van Buren','William Henry Harrison','John Tyler','James K. Polk','Zachary Taylor','Millard Fillmore','Franklin Pierce','James Buchanan','Abraham Lincoln');
								$demotitles = array('Immigration history in America','Society and life in the Dark Ages','The mystery of Leonardo DaVinci\'s Mona Lisa painting','Burial practices in ancient cultures and societies','Sculpture in the Renaissance','Fashion in Victorian Britain','The assassination of John FKennedy','Colonization and its impact on the European powers in the Age of Exploration and beyond','The Olympics in Ancient Greece','Explore the history of tattoos and body art','The  Spanish Flu','Innovations that came out of the great wars','Japanese Kamikaze fighters during World War II','Rum running during Prohibition','Mahatma Gandhi and Indian apartheid');
							}
							$assignment['ID'] = 999999999999 + sizeof($democharacters);
							$assignment['name'] = array_pop($democharacters);
							if('Speaker' == $role) {
								$assignment['manual'] = 'Dynamic Demos';
								$assignment['project'] = 'Dynamic Demos 123';
								$assignment['project_text'] = 'Dynamic Demos to Fill the Agenda';
								$assignment['title'] = array_pop($demotitles);
								$assignment['maxtime'] = 7;
							}
						}
						if(empty($assignment['ID']))
							$blanks[] = $i - 1;
						$agendadata['blocksdata'][$index]['assignments'][] = $assignment;
					}
					if($backup) {
						$key = wp4t_fieldbase('Backup '.$role,$start);
						$assignment = array();
						$assignment['ID'] = intval( get_post_meta($agendadata['post_id'],$key, true) );
						$assignment['name'] = ($assignment['ID']) ? get_member_name($assignment['ID']) : '';
						if($assignment['ID'] && ('Speaker' == $role)) {
							$speakerdata = get_speaker_array_by_field($key,$assignment['ID'],$agendadata['post_id']);
							$assignment = array_merge($assignment,$speakerdata);
						}
					$agendadata['blocksdata'][$index]['assignments'][] = $assignment;
					}
				}//end if role
				elseif($render) {
					$agendadata['blocksdata'][$index]['rendered'] = render_block($block);
				}
		}
		$trans = wpt_mobile_translations();
		$agendadata['translations'] = ($trans && !empty($trans['translations'])) ? $trans['translations'] : array();
		$agendadata['missedTranslation'] = ($trans && !empty($trans['missed'])) ? $trans['missed'] : array();
	
	return $agendadata;
}
class WP4T_Mobile_Code extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'mobilecode/';
		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
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
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
		if(isset($_GET['email'])) {
			$email = sanitize_text_field($_GET['email']);
			$user = get_user_by('email', $email);
			$message = '';
			if(!$user && $_SERVER['SERVER_NAME'] == 'demo.toastmost.org') {
				$parts = explode('@',$email);
				$newuser['user_login'] = $email;
				$newuser['first_name'] =  ucfirst($parts[0]);
				$newuser['last_name']  = 'Test Account';
				$newuser['user_email'] = $email;
				$newuser['user_pass'] = wp_generate_password(12, true, false);
				
			if ( $user_id = wp_insert_user( $newuser )){
				add_user_to_blog(22, $user_id, 'subscriber');
				$user = get_userdata($user_id);
				$code = $user->ID.'-'.wp_generate_password(8,false);
				update_user_meta($user->ID,'wpt_mobile_code',$code);
				$message .= '<p>The account you created to test the mobile app can also be used to set up a club or district website at Toastmost.org.</p>
<p>To set your website password, visit <a href="' . site_url() . '/wp-login.php?action=lostpassword">' . site_url() . '/wp-login.php?action=lostpassword</a></p>
<p>Once you have set your password, you can also change the name associated with your account at <a href="' . site_url() . '/wp-admin/profile.php">' . site_url() . '/wp-admin/profile.php</a></p>
<p>Setting a website password is not required to test the mobile app but will allow you to test the website agenda management tools using the demo.toastmost.org website.</p>
';
				$message .= '<p>' . __( 'For a basic orientation to the website setup, see the <a href="http://wp4toastmasters.com/new-member-guide-to-wordpress-for-toastmasters/">New Member Guide to WordPress for Toastmasters</a>', 'rsvpmaker-for-toastmasters' ) . '</p>';
			}
			}
			if($user) {
				$ok = false;
				if(is_multisite()) {
					$blog_id = get_current_blog_id();
					if(is_user_member_of_blog($user->ID, $blog_id)) {$ok = true;}
					elseif('demo.toastmost.org' == $_SERVER['SERVER_NAME']) {
						add_user_to_blog($blog_id, $user->ID, 'subscriber');
						$ok = true;
					}
					else {
						$response['status'] = 'User account found but not associated with '.$_SERVER['SERVER_NAME']." user $user->ID blog $blog_id";
					}						
				}
				else
					$ok = true;
				if($ok) {
					$code = get_user_meta($user->ID,'wpt_mobile_code',true);
					if(!$code)
					{
						$code = $user->ID.'-'.wp_generate_password(24,false);
						update_user_meta($user->ID,'wpt_mobile_code',$code);
					}					
					$code_url = 'https://toastmost.org/app-setup/?domain='.$_SERVER['SERVER_NAME'].'&code='.$code;
					$app_redirect_url = site_url('?toastmost_app_redirect=Settings&domain='.$_SERVER['SERVER_NAME'].'&code='.$code);
					$mail['html'] = '<p>Open this email on your phone to simplify connecting the app setup.</p>
					
					<p><a href="'.$app_redirect_url.'" style="display: inline-block; padding: 10px 20px; background-color: #004165; color: #ffffff; text-decoration: none; border-radius: 5px; font-size: 16px; font-weight: bold; text-align: center;">Connect Now!</a></p>
					<p>Clicking the button above should open the app and connect the app to your club website account.</p>
					<p>If that does not work for some reason, visit the <a href="'.$code_url.'">app setup page</a>, which will help you connect the app to your account on a club website (or on demo.toastmost.org if you do not currently have a Toastmost or WordPress for Toastmasters website).</p>
					'.$message;
					$mail['to'] = $email;
					$mail['cc'] = 'david@toastmost.org';
					$mail['from'] = 'david@toastmost.org';
					$mail['fromname'] = 'Toastmost';
					$mail['subject'] = 'Toastmost app setup for '.$user->display_name.' on '.$_SERVER['SERVER_NAME'];
					rsvpmailer($mail);
					$response['status'] = 'Sending email to '.$email;
					$response['success'] = true;
					$response['timestamp'] = date('r');
					//$response['message'] = $mail['html'];
				}
			}
			else {
				$response['status'] = 'No user account found for that email address';
			}
		}
		else {
			$response['status'] = 'No email submitted';
		}
		return new WP_REST_Response($response,
			200
		);
	}
}
if(!empty($_GET['language']))
	add_filter( 'locale', 'wpt_mobile_language_preference', 1, 1 );
function wpt_mobile_language_preference($language) {
	global $current_user;
	$user_preference = sanitize_text_field($_GET['language']);
	if ( ! empty( $user_preference ) ) {
		// Update user meta to store the language preference
		if ( isset($current_user->ID) ) {
			update_user_meta( $current_user->ID, 'locale', $user_preference );
		}
		// Return the user preference for localization
		return $user_preference;
	}
	return $language;
}
class WP4T_Mobile_Agenda extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'mobile/(?P<user_code>.+)';
		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}
	public function get_items_permissions_check( $request ) {
		global $current_user;
		$user_code = $request['user_code'];
		$user_id = wpt_mobile_auth($user_code);
		if(empty($user_id))
			return false;
		$stamp = date('r');
		if(isset($_GET['mobileos'])) {
			$mobileos = sanitize_text_field($_GET['mobileos']);
			update_user_meta($user_id,'wpt_mobile_os_'.$mobileos,$stamp);
		}
		update_user_meta($user_id,'wpt_mobile_last_access',$stamp);
		return true;
	}
	public function handle( $request ) {
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
		global $current_user, $wpdb;
		error_log($current_user->display_name.' mobile request '.$request['user_code']);
		$json = file_get_contents('php://input');
		if($json) {
			$data = json_decode($json);
			$post_id = intval($data->post_id);
		}
		if(!isset($post_id)) {
			$future = future_toastmaster_meetings();
			if($future)
			$post_id = $future[0]->ID;
		}
		if(isset($_GET['ask'])) {
			$ask = sanitize_text_field($_GET['ask']);
			if('role_status' == $ask) {
				$role = sanitize_text_field($_GET['role']);
				$absences = get_post_meta( $post_id, 'tm_absence' );
				if ( is_array( $absences ) ) {
					$absences = array_unique( $absences );
				}
				else 
					$absences = [];
				$haverole = wp4t_haverole($post_id);
				$members = get_club_members();
				$memberstatus = [];
				foreach($members as $member) {
					$status = '';
					if(isset($haverole[$member->ID]))			
						$status = __( 'Signed up for', 'rsvpmaker-for_toastmasters' ) . ': ' . $haverole[$member->ID];
					elseif(in_array($member->ID,$absences))
						$status = __('Planned Absence','rsvpmaker-for-toastmasters');
					elseif ( $member->ID > 0 ) {
						$held = wp4t_last_held_role($member->ID, clean_role($role));
						if ( ! empty( $held ) ) {
							$status = __( 'Last did', 'rsvpmaker-for_toastmasters' ) . ': ' . $held;
						}	
				}
				$memberstatus[$member->ID] = $status;
				}
				$answer['memberstatus']	= $memberstatus;
				return new WP_REST_Response($answer,
				200
			);
	
			}
		}
		$agendapost = get_post($post_id);
		$speechfields = ['title','manual','project','maxtime','display_time','intro'];
		if(isset($data) && isset($data->suggest))
		{
			$response['content'] = wpt_suggest_role(array('suggest_note'=>$data->note,'post_id'=>$post_id,'user_id'=>$data->suggest,'role'=>$data->role));
			return new WP_REST_Response($response,
			200);
		}
		if(isset($data) && isset($data->sendBallot))
		{
			$votelink = add_query_arg('meetingvote','1',get_permalink($post_id));
			$mail['from'] = $current_user->user_email;
			$mail['fromname'] = $current_user->display_name;
			$mail['subject'] = 'Toastmasters voting link';
			$mail['html'] = sprintf('<p>The voting link is <a href="%s">%s</a></p>',$votelink,$votelink);
			if('members' == $data->sendBallot) {
				$members = get_club_members();
				foreach($members as $member) {
					$recipients[] = $member->user_email;
				}
			}
			else {
				$recipients[] = $current_user->user_email;
			}
			foreach($recipients as $to) {
				$mail['to'] = $to;
				rsvpmailer($mail);
			}
			$response['recipients_count'] = sizeof($recipients);
			$response['recipients'] = $recipients;
			return new WP_REST_Response($response,
			200);
		}
		if(isset($data) && isset($data->ID))
		{
			$id = sanitize_text_field($data->ID);
			$key = sanitize_text_field($data->assignment_key);
			$wasopen = !empty($data->wasopen);
			if(strpos($key,'planned_absence')) {
				if($id)
					$result = add_post_meta($post_id,'tm_absence',$id);
				else {
					$result = delete_post_meta($post_id,'tm_absence',$current_user->ID);
				}
			}
			elseif($wasopen) {
				$was = get_post_meta($post_id,$key,true);
				if(!empty($was)) {
					$agendadata['taken'] = get_member_name($was);
					$agendadata['update'][] ='already assigned: '.get_member_name($was);
				}
				else {
					$result = update_post_meta($post_id,$key,$id);
					$agendadata['wasopen_check'] = 'still open';
				}
			}
			else {
				$result = update_post_meta($post_id,$key,$id);
			}
			$agendadata['update'][] = $key . ' = ' . $id .' post id = '.$post_id.' result '.var_export($result,true);
			if(strpos($key,'Vote_Counter')) {
				if(!strpos($agendapost->post_content,':"Vote Counter"')) {
					$update['ID'] = $post_id;
					$update['post_content'] = $agendapost->post_content."\n\n".'<!-- wp:wp4toastmasters/role {"role":"Vote Counter","count":1,"start":1} /-->';
					wp_update_post($update);
				}
			}
		}
		if(isset($data) && 'Speaker' == $data->role)
		{
			$key = sanitize_text_field($data->assignment_key);
			foreach($speechfields as $field) {
				$k = '_'.$field.$key;
				if($data->ID == 0)
				{
					$v = '';
				}
				else {
					if(!isset($data->$field)) {
						$agendadata['update'][] = "missing $field";
						continue;
					}
					$v = sanitize_text_field($data->$field);
				}
				$agendadata['update'][] = "$k = $v";
				update_post_meta($post_id,$k,$v);
			}
		}
		if(isset($data) && isset($data->absence))
		{
			$absence = intval($data->absence);
			if($absence) {
				$result = add_post_meta($post_id,'tm_absence',$current_user->ID);
				$agendadata['absence_update'] = 'added '.$current_user->ID.' '.$current_user->display_name;
			}
			else {
				$result = delete_post_meta($post_id,'tm_absence',$current_user->ID);
				$agendadata['absence_update'] = 'removed '.$current_user->ID.' '.$current_user->display_name;
			}
		}
		if(isset($data) && isset($data->note_update))
		{
			$note = wpautop(strip_tags(sanitize_textarea_field($data->note_update)));
			$r = update_post_meta($data->post_id,$data->note_update_key,$note);
			$agendadata['note_update'] = $data->post_id.':'.$data->note_update_key.':'.$note.':'.var_export($r,true);	
		}
		if(isset($data) && isset($data->emailagenda))
		{
			global $email_context;
			$email_context = true;	
			$request_array['send'] = sanitize_text_field($data->emailagenda);
			$request_array['subject'] = sanitize_text_field($data->subject);
			$request_array['note'] = sanitize_text_field($data->note);
			if($request_array['send'] == 'test') {
				$request_array['testto'] = $current_user->user_email;
			}
			$content = '';
			if(!empty($request_array['note']))
				$content .= '<p><em>'.esc_html($request_array['note']).' &mdash; '.$current_user->display_name.'</em></p>';
			try {
				$content .= tm_agenda_content($post_id);
			} catch (Exception $e) {
				$content .= 'Caught exception: '.  $e->getMessage(). "\n";
			}
			try {
				$content = apply_filters( 'email_agenda', $content );
			} catch (Exception $e) {
				$content .= 'Caught exception: '.  $e->getMessage(). "\n";
			}
			//ob_start();
			//awesome_open_roles($post_id, false,$request_array);
			$mail['html'] = $content;
			$mail['from'] = $current_user->user_email;
			$mail['fromname'] = $current_user->display_name;
			$mail['subject'] = $request_array['subject'];
			$emails = [];
			if($request_array['send'] == 'members') {
				$blogusers = get_users( 'blog_id=' . get_current_blog_id() );
				foreach ( $blogusers as $user ) {
					$emails[] = $user->user_email;
				}
			}
			else {
				$emails[] = $current_user->user_email;
			}
			foreach($emails as $email) {
				$mail['to'] = $email;
				rsvpmailer($mail);
			}
			$agendadata['emailagenda_content'] = $content;
			$agendadata['emailagenda_to'] = sizeof($emails).' emails: '.implode(', ',$emails);
		}
		if(isset($data) && isset($data->firstName) && isset($data->lastName))
		{
			$current_user->display_name = $data->firstName.' '.$data->lastName;
			wp_update_user(array('ID'=>$current_user->ID,'display_name'=>$current_user->display_name,'first_name'=>$data->firstName,'last_name'=>$data->lastName));
		}
		if(isset($data) && isset($data->suggestTranslations))
		{
			$language = sanitize_text_field($_GET['language']);
			$new_translations = (array) $data->suggestTranslations;
			$current_trans = get_option('wp4t_translations_'.$language);
			if(empty($current_trans) || !is_array($current_trans)) {
				$translations = [];
			}
			foreach($new_translations as $key => $translation) {
				if(!empty($translation)) {
					$translations[$key] = sanitize_text_field($translation);
				}
			}
			update_option('wp4t_translations_'.$language,$translations);
			if(is_toastmost_site()) {
				$current_trans = get_blog_option(1,'wp4t_translations_'.$language);
				if(empty($current_trans) || !is_array($current_trans)) {
	
					$translations = [];
	
				}
	
				foreach($new_translations as $key => $translation) {
	
					if(!empty($translation)) {
	
						$translations[$key] = sanitize_text_field($translation);
	
					}
	
				}
	
				update_blog_option(1,'wp4t_translations_'.$language,$translations);	
			}
			foreach($translations as $key => $translation) {
					$content .= $key.' = '.$translation."\n";
				}
			$agendadata['translation_submitted'] = $content;
			$mail['html'] = $content;
			$mail['from'] = $current_user->user_email;
			$mail['fromname'] = $current_user->display_name;
			$mail['subject'] = 'Toastmasters app translation suggestions for '.$language.' on '.$_SERVER['SERVER_NAME'];
			$mail['to'] = 'translation@toastmost.org';
			rsvpmailer($mail);
		}
		if(isset($_GET['getprogress'])) {
			$progress = '<p>'.__('Check this report against your Pathways Base Camp records.','rsvpmaker-for-toastmasters').'</p>';
			$report = get_speech_progress_report();
			if(empty($report))
				$progress .= '<p>'.__('No speech records found.','rsvpmaker-for-toastmasters').'</p>';
			else {
				$progress .= $report;
			}
			$agendadata['progress'] = $progress;
		}
		$agendadata['domain'] = $_SERVER['SERVER_NAME'];
		$agendadata['sitename'] = get_option('blogname');
		$agendadata['user_id'] = $current_user->ID;
		$agendadata['name'] = $current_user->display_name;
		$agendadata['agendas'] = wpt_get_mobile_agendadata($current_user->ID);
		$agendadata['projects'] = wp4t_program();
		$trans = wpt_mobile_translations();
		$agendadata['translations'] = ($trans && !empty($trans['translations'])) ? $trans['translations'] : array();
		$agendadata['missedTranslation'] = ($trans && !empty($trans['missed'])) ? $trans['missed'] : array();
		$agendadata['userblogs'] = wpt_domains_of_mobile_user($current_user->ID);
		$agendadata['is_officer'] = wpt_is_officer($current_user->ID);
		$agendadata['is_editor'] = current_user_can('edit_others_posts');
		$memberlist = [];
		$members = get_club_members();
		foreach($members as $member) {
			$name = (!empty($member->first_name)) ? $member->first_name.' '.$member->last_name : $member->display_name;
			$memberlist[] = array('name'=>$name,'ID'=>$member->ID);
		}
		$memberlist[] = array('name' => 'Open', 'ID' => 0);
		$memberlist[] = array('name' => 'Not Available', 'ID' => -1);
		$memberlist[] = array('name' => 'To Be Announced', 'ID' => -2);
		if(!empty($post_id)) {
			$names = [];
			$sql = "SELECT first, last from ".$wpdb->prefix."rsvpmaker WHERE event=$post_id";
			$rsvps = $wpdb->get_results($sql);
			if($rsvps) {
				foreach($rsvps as $rsvp) {
					$display_name = $rsvp->first.' '.$rsvp->last.' (guest)';
					$names[] = $display_name;
					$memberlist[] = array('name'=>$display_name,'ID'=>$display_name);
				}
			}
			$sql = "SELECT meta_value as display_name from $wpdb->postmeta WHERE post_id=$post_id and meta_key LIKE '_role_%'";
			$guestroles = $wpdb->get_results( $sql );
			if($guestroles) {
				foreach($guestroles as $row) {
					if(!is_numeric($row->display_name))
					{
						$row->display_name .= ' (guest)';
						if(!in_array($row->display_name,$names))
							$memberlist[] = array('name'=>$row->display_name,'ID'=>$row->display_name);
					}
				}
			}	
		}
		$agendadata['post_id'] = $post_id;
		$agendadata['members'] = $memberlist;
		$agendadata['code'] = $request['user_code'];
		$agendadata['payload'] = $data;
		return new WP_REST_Response($agendadata,
			200
		);
	}
}
class WP4T_Translations extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'translations';
		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}
	public function get_items_permissions_check( $request ) {
		if(wpt_exclude_agenda_functions())
			return false;

		return true;
	}
	public function handle( $request ) {
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
		return new WP_REST_Response(wpt_mobile_translations(),
			200
		);
	}
}
function wpt_get_mobile_agendadata($user_id = 0) {
	global $current_user,$post,$email_context;
	$email_context = true;
	$agendas = [];
	$post = false;
	$meetings = future_toastmaster_meetings( 16 );
	foreach($meetings as $meeting) {
		$post_id = $meeting->ID;
		$agenda['post_id'] = $post_id;
		$agenda['title'] = rsvpmaker_date('M j',$meeting->ts_start) .' '.$meeting->post_title;
		$agenda['intros'] = speech_intros($post_id);
		$agenda['html'] = tm_agenda_content($post_id);
		$agenda['roles'] = [];
		$blocksdata = parse_blocks($meeting->post_content);
		foreach($blocksdata as $block) {
			if(isset($block['attrs']) && isset($block['attrs']['role']))
				{
					$role = (!empty($block['attrs']['custom_role'])) ? $block['attrs']['custom_role'] : $block['attrs']['role'];
					$role_display = __($role,'rsvpmaker-for-toastmasters');
					$count = isset($block['attrs']['count']) ? $block['attrs']['count'] : 1;
					$start = (isset($lastcount[$role])) ? $lastcount[$role] + 1 : 1;
					$backup = !empty($block['attrs']['backup']) ? 1 : 0;
					for($i=$start; $i < ($count + $start); $i++)
					{
						$key = wp4t_fieldbase($role,$i);
						$assignment = array('post_id'=>$post_id,'assignment_key'=>$key,'role'=>$role,'role_display'=>$role_display);
						$assignment['ID'] = get_post_meta($post_id,$key, true);
						if(empty($assignment['ID'])) {
							$assignment['name'] = '';
						}
						elseif(is_numeric($assignment['ID'])) {
							$assignment['name'] = get_member_name($assignment['ID']);
						}
						else
							$assignment['name'] = $assignment['ID'].' (guest)';
						if($assignment['ID'] && ('Speaker' == $role)) {
							$speakerdata = get_speaker_array_by_field($key,$assignment['ID'],$post_id);
							$project_key = ($speakerdata['project']) ? $speakerdata['project'] : '';
							$speakerdata['evaluation_link'] = evaluation_form_url( $assignment['ID'], $post_id );//add_query_arg('evalme',$current_user->ID,get_permalink())
							$assignment = array_merge($assignment,$speakerdata);
						}
						$agenda['roles'][] = $assignment;
					}
			
					if($backup) {
						$key = wp4t_fieldbase('Backup '.$role,$start);
						$assignment = array('post_id'=>$post_id,'assignment_key'=>$key,'role'=>'Backup '.$role);
						$assignment['ID'] = intval( get_post_meta($post_id,$key, true) );
						$assignment['name'] = ($assignment['ID']) ? get_member_name($assignment['ID']) : '';
						if($assignment['ID'] && ('Speaker' == $role)) {
							$speakerdata = get_speaker_array_by_field($key,$assignment['ID'],$post_id);
							$assignment = array_merge($assignment,$speakerdata);
						}
					$agenda['roles'][] = $assignment;
					}
				}
				elseif('wp4toastmasters/agendaedit' == $block['blockName']) {
					$editable['headline'] = $block['attrs']['editable'];
					$text = get_post_meta($post_id,'agenda_note_'.$block['attrs']['uid'],true);
					$editable['content'] = ($text) ? trim(html_entity_decode(strip_tags($text))) : '';
					$editable['key'] = 'agenda_note_'.$block['attrs']['uid'];
					$agenda['editable'][] = $editable;
				}
		}
		//end tour through blocks
		if(strpos($meeting->post_content,'wp:wp4toastmasters/absences')) {
			$assignment = array('post_id'=>$post_id,'assignment_key'=>'_planned_absence_1','role'=>'Planned Absence');
			$absences = get_post_meta( $meeting->ID, 'tm_absence' );
			if(is_array($absences))
				$absences = array_unique($absences);
			else
				$absences = [];
			$agenda['absences'] = [];
			foreach($absences as $ab) {
				$abs_list[] = get_member_name($ab);
			}
			if(!empty($abs_list)) {
				$assignment['name'] = implode(', ',$abs_list);
			}
			if(in_array($user_id,$absences)) {
				$assignment['ID'] = $user_id;
			}
			else
				$assignment['ID'] = 0;
			$agenda['roles'][] = $assignment;
		}
		$agendas[] = $agenda;
	}//end meetings loop
	
return $agendas;
}
class WP4TRolesList extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'roles_list';
		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}
	public function get_items_permissions_check( $request ) {
		if(wpt_exclude_agenda_functions())
			return false;

		return true;
	}
	public function handle( $request ) {
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
		global $toast_roles;
		$toast[] = array('value' =>'', 'label' => __('Select Role','rsvpmaker-for-toastmasters'));
		$toast[] = array('value' =>'custom', 'label' => __('Custom Role','rsvpmaker-for-toastmasters'));
		foreach($toast_roles as $key => $value)
			$toast[] = array('value' => $key, 'label' => $value);		
		return new WP_REST_Response($toast,
			200
		);
	}
}
//get_manuals_by_type()
class WP4TUpdateRole extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'update_role';
		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
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
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
		$json = file_get_contents('php://input');
		$data = json_decode($json);
		$post_id = $data->post_id;
		$role = $data->role;
		$keybase = wp4t_fieldbase($role).'_';
		$updated['status'] = 'updated';
		foreach($data->assignments as $index => $item) {
			//foreach($assignment as $item) {
				$item = (array) $item;
				foreach($item as $type => $value) {
					if(empty($type) || ('name' == $type))
						continue;
					elseif('ID' == $type)
						$key = $keybase.($index+1);
					else
						$key = '_role_'.$type.$keybase.($index+1);
					update_post_meta($post_id,$key,$value);
					$updated['status'] .= ' '.$key.' = '.$value;	
			}
			do_action('rsvpmaker_log_array',
			array('meta_key' => 'update_role',
			'meta_value' => $updated,
			));					//}
		}
		return new WP_REST_Response($updated,
			200
		);
	}
}
class WP4TUpdateAgenda extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'update_agenda';
		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}
	public function get_items_permissions_check( $request ) {
		return (current_user_can('edit_rsvpmakers') || current_user_can('organize_agenda')); //or allowed to reorganize
	}
	public function handle( $request ) {
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
		$json = file_get_contents('php://input');
		$data = json_decode($json);
		$output = '';
		$post_id = $data->post_id;
		$post_type = get_post_type($post_id);
		if(('rsvpmaker' != $post_type) && ('rsvpmaker_template' != $post_type))
			return new WP_REST_Response(['status'=>'This function only works with event content'],401);
		if('rsvpmaker_template' != $post_type) {
			if(!current_user_can('edit_post',$post_id) && !current_user_can('organize_agenda'))
				return new WP_REST_Response(['status'=>'user is not allowed to update this document'],401);
		}
		foreach($data->blocksdata as $index => $block) {
			if($block->blockName)
				$output .= jsonBlockDataOutput($block, $post_id);
		}
		$updated['ID'] = $post_id;
		$updated['post_content'] = $output;
		$upid = wp_update_post($updated);
		$agendadata = wpt_get_agendadata($post_id);
		$agendadata['status'] = "update agenda ".$upid;
		if(!empty($data->copyToTemplate)) {
			$updated['ID'] = $data->has_template;
			$updated['post_content'] = $output;
			wp_update_post($updated);
			$related = get_events_by_template($data->has_template);
			$agendadata['status'] .= " + template update";
			$related = get_events_by_template($data->has_template);
			foreach($related as $post_to_update) {
				if($post_id == $post_to_update->ID)
					continue;
				$updated['ID'] = $post_to_update->ID;
				$updated['post_content'] = $output;
				wp_update_post($updated);	
				$agendadata['status'] .= " + ".$post_to_update->ID;
			}
		}
	do_action('rsvpmaker_log_array',
	array('meta_key' => 'update_agenda',
	'meta_value' => $agendadata,
    ));
		return new WP_REST_Response($agendadata,
			200
		);
	}
}
class WP4T_Paths_and_Projects extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'paths_and_projects';
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
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
		return new WP_REST_Response(wp4t_program(),200);
	}
}
function wp4t_program() {
	$manuals_by_type = get_manuals_by_type();
	$projects = get_projects_array();
	$program['maxtime'] = get_projects_array('times');
	$program['display_time'] = get_projects_array('display_times');
	foreach($manuals_by_type as $pathkey => $marray) {
		$program['paths'][] = array('label' => $pathkey,'value' => $pathkey);
		$program['manuals'][$pathkey][] = array('label' => 'Choose a Level', 'value' => '');
		foreach($marray as $mkey => $manual) {
			$program['manuals'][$pathkey][] = array('label' => $mkey, 'value' => $manual);
			$program['projects'][$manual][] = array('label' => 'Choose a Project', 'value' => '');
			$manuals[] = $manual;
		}
	}
	$program['manuals']['Other'][] = array('label' => 'Other','value' => 'Other');
	foreach($projects as $key => $project) {
		$manual = preg_replace('/([\s0-9]+)$/','',$key);
		if(in_array($manual,$manuals))
			$program['projects'][$manual][] = array('label' => $project, 'value' => $key);
		else
			$program['projects']['Other'][] = array('label' => $project, 'value' => $key);
	}
	return $program;
}
class WP4T_Members_for_Role extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'members_for_role/(?P<role>[a-zA-Z_]+)/(?P<post_id>[0-9]+)';
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
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
		$options = awe_rest_user_options( clean_role($request['role']), $request['post_id'] );
		return new WP_REST_Response($options,200);
	}
}
class WptJsonAssignmentPost extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'json_assignment_post';
		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}
	public function get_items_permissions_check( $request ) {
		return (is_user_logged_in() || wpt_mobile_user_check());
	}
	public function handle( $request ) {
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
		global $current_user;
		$json = file_get_contents('php://input');
		$data = json_decode($json);
		$post_id = $data->post_id;
		$blockindex = $data->blockindex;
		$roleindex = $data->roleindex;
		$user_id = $data->ID;
		$role = $data->role;
		$start = $data->start;
		$count = $data->count;
		$wasopen = !empty($data->wasopen);
		if($count == $roleindex) {
			$role = 'Backup '.$role;
			$roleindex = 0;
		}
		$name = get_member_name($user_id);
		$keybase = wp4t_fieldbase($role).'_';
		$updated = $item = (array) $data;
		$status = 'updated post id '.$post_id.' count: '.$count;
		$updated['name'] = $name;
		$control = ['role','blockindex','roleindex','name','post_id','start','count'];
		foreach($item as $type => $value) {
			if($type == "ID")
			$status .= ' item '.var_export($item,true).' '; 
			if(empty($type) || in_array($type,$control))
				continue;
			elseif('ID' == $type)
				$key = $keybase.($roleindex+$start);
			else
				$key = '_'.$type.$keybase.($roleindex+$start);
			//$updated[$type] = $value;
			if(($type == "ID") && $wasopen && !empty($value)) {
				$was = get_post_meta($post_id,$key,true);
				if(!empty($was)) {
					$agendadata = wpt_get_agendadata($post_id);
					$agendadata['taken'] = get_member_name($was);
					$agendadata['status'] = 'already assigned: '.get_member_name($was);
					return new WP_REST_Response($agendadata,200);						
				}
				else
					$status .= ' Confirmed not assigned ';
			}
			update_post_meta($post_id,$key,$value);
			$status .= ' '.$key.' = '.$value;
			$updated['status'] .= ' '.$key.' = '.$value;
	}
	$key = (isset($item["ID"]) && ($item["ID"] == $current_user->ID)) ? 'role sign up' : 'role assignment';
	do_action('rsvpmaker_log_array',
	array('meta_key' => $key,
	'meta_value' => $updated['status'],
	'user_id' => $current_user->ID,
    ));
		$agendadata = wpt_get_agendadata($post_id);
		$agendadata['status'] = $status;
		$agendadata['prompt'] = ($user_id == $current_user->ID);
		$agendadata['role'] = $role;
		return new WP_REST_Response($agendadata,
			200
		);
	}
}
class WptJsonMultiAssignmentPost extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'json_multi_assignment_post';
		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
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
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
		$json = file_get_contents('php://input');
		$data = json_decode($json);
		$blockindex = $data->blockindex;
		$assignments = $data->assignments;
		$start = $data->start;
		$updated['status'] = 'updated ';
		$updated['assignments'] = [];
		foreach($assignments as $roleindex => $assignment) {
			$post_id = $assignment->post_id;
			$user_id = $assignment->ID;
			$role = $assignment->role;
			$count = $assignment->count;
			if($roleindex == $count) {
				$role = "Backup ".$role;
				$roleindex = 0;
			}
			$name = get_member_name($user_id);
			$keybase = wp4t_fieldbase($role).'_';
			$item = (array) $data;
			$item['name'] = $name;
			array_push($updated['assignments'],$item);
			$control = ['role','blockindex','roleindex','name','post_id','count'];
			$item = (array) $assignment;
			foreach($item as $type => $value) {
				if(empty($type) || in_array($type,$control))
					continue;
				elseif('ID' == $type)
					$key = $keybase.($roleindex+$start);
				else
					$key = '_'.$type.$keybase.($roleindex+$start);
				$updated[$roleindex][$type] = $value;
				update_post_meta($post_id,$key,$value);
				$updated['status'] .= ' ' .$post_id.' '.$key.' = '.$value;	
				$status .=  ' ' .$post_id.' '.$key.' = '.$value;	
		}
	
		}
		$agendadata = wpt_get_agendadata($post_id);
		$agendadata['status'] = $status;
		return new WP_REST_Response($agendadata,
			200
		);
	}
}
class WP4T_Copy_Post extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'json_copy_post';
		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}
	public function get_items_permissions_check( $request ) {
		return current_user_can('edit_posts');
	}
	public function handle( $request ) {
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
		$json = file_get_contents('php://input');
		$data = json_decode($json);
		$post_id = json_decode($post_id);
		if(!current_user_can('edit_post',$data->copyfrom) || !current_user_can('edit_post',$data->copyto))
		return new WP_REST_Response('User lacks sufficient editing rights.',
			200
		);
		$copyfrom = get_post($data->copyfrom);
		$update = array('ID' => $data->copyto,'post_content'=>$copyfrom->post_content);
		wp_update_post($update);
		$agendadata = wpt_get_agendadata($post_id);
		$agendadata['status'] = var_export($data,true);
		return new WP_REST_Response($agendadata,
			200
		);
	}
}
class WP4T_Permissions extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'json_agenda_permissions';
		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}
	public function get_items_permissions_check( $request ) {
		return current_user_can('manage_options');
	}
	public function handle( $request ) {
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
		$json = file_get_contents('php://input');
		$data = json_decode($json);
		if('newSignupDefault' == $data->key) {
		update_option('wp4t_newSignupDefault',$data->value,false);
		$response['status'] = "$data->key ".(($data->value) ? 'true' : 'false');
		return new WP_REST_Response($response,
			200
		);
		}
		$change = ['subscriber','contributor','author'];
		foreach($change as $label) {
			$r = get_role( $label );
			if($data->value)
				$r->add_cap($data->key);
			else
				$r->remove_cap($data->key);
		}
		$security = get_option( 'tm_caps' );
		if(empty($security))
			$security = [];
		$security[$data->key] = $data->value;
		update_option('tm_caps',$security);
		//update_option($data->key,$data->value);
		$response['status'] = "$data->key ".(($data->value) ? 'true' : 'false')." for ".implode(', ',$change);
		return new WP_REST_Response($response,
			200
		);
	}
}
class WP4T_Absences extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'absences';
		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
					'callback'            => array( $this, 'handle' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
				),
			)
		);
	}
	public function get_items_permissions_check( $request ) {
		return true;//return is_club_member();
	}
	public function handle( $request ) {
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
		global $rsvp_options;
		$response['absences'] = tm_absences_json();
		$future = future_toastmaster_meetings();
		$response['upcoming'][] = array('value'=>'','label'=>'Just this meeting');
		foreach($future as $f)
			$response['upcoming'][] = array('value'=>$f->datetime,'label'=>'until '.rsvpmaker_date($rsvp_options['long_date'],rsvpmaker_strtotime($f->datetime)));
		$response['memberlist'][] = array('value'=>'0','label'=>'Choose Member');
		$members = get_club_members();
		foreach($members as $m) {
			$response['memberlist'][] = array('value'=>$m->ID,'label'=>$m->display_name);
		}
		return new WP_REST_Response($response,
			200
		);
	}
}
class WP4T_Hybrid extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'hybrid';
		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
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
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
		$json = file_get_contents('php://input');
		$data = ($json) ? json_decode($json) : array();
		$response = tm_attend_in_person_json($data);
		return new WP_REST_Response($response,
			200
		);
	}
}
class WP4T_Evaluation extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'evaluation';
		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
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
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
		global $wpdb, $rsvp_options;
		$json = file_get_contents('php://input');
		if(!empty($json))
		$data = json_decode($json);	
		$response['authorized'] = wpt_mobile_auth(); //set current user if mobile code included
		$speaker_id = (isset($_GET['speaker'])) ? intval($_GET['speaker']) : 0;
		if(!empty($data)) {
			global $current_user, $rsvp_options;
			$output = '';
			$speaker_id = $data->evaluate->ID;
			if(is_numeric($speaker_id))
				$speaker = get_userdata($speaker_id);
			if($speaker) {
				$mail['to'] = $speaker->user_email;
			}
			error_log('data '.var_export($data,true));
			$name = sanitize_text_field($data->evaluate->name);
			$manual = sanitize_text_field($data->evaluate->manual);
			$project_text = ($data->evaluate->project) ? get_project_text($data->evaluate->project) : '';
			$title = sanitize_text_field($data->evaluate->title);
			$evaluator_name = (isset($current_user->display_name)) ? $current_user->display_name : sanitize_text_field($data->evaluator_name);
			$mail['subject'] = "Evaluation for ".$name.' '.$title;
			$output = sprintf("<h1>Evaluation for %s %s</h1>\n",$name,($title) ? "<em>$title</em>" : '');
			$output .= sprintf("<h2>Evaluator: %s</h2>\n",$evaluator_name);
			$output .= sprintf("<h2>Path: %s</h2>\n",$manual);
			$output .= sprintf("<h2>Project: %s</h2>\n",$project_text);
			$output .= sprintf("<p>Evaluator: %s</p>\n",$current_user->display_name);
			$output .= sprintf("<p>Date: %s</p>\n",rsvpmaker_date($rsvp_options['long_date'],time()));
			$sizeofprompts = sizeof($data->form->prompts);
			$sizeofresponses = sizeof($data->responses);
			$sizeofnotes = sizeof($data->notes);
			$prompts = ($sizeofprompts < $sizeofresponses || $sizeofprompts < $sizeofnotes) ? array_merge($data->form->prompts,$data->form->second_language) : $data->form->prompts;
			foreach($prompts as $index => $p) {
				$choice = empty($data->responses[$index]) ? '' : sanitize_text_field($data->responses[$index]);
				$output .= '<p><strong>'.sanitize_text_field($p->prompt).(($choice) ? ': <em>'.$choice.'</em>' : '')."</strong></p>\n";
				if($p->choices) {
					$output .= "<div style=\"display:flex;font-family: Arial, Helvetica, sans-serif;flex-direction:row;\">";
					foreach($p->choices as $option) {
						$output .= format_eval_opt($option->value,($choice == $option->value));
					}
					$output .= "</div>\n";
				}
				$note = empty($data->notes[$index]) ? '' : wpautop(sanitize_textarea_field($data->notes[$index]));
				$output .= '<div style="padding-left: 20px;">'.$note."</div>\n";
			}
			$response['message'] = $output;
			if(empty($current_user->user_email))
				$mail['from'] = (empty($data->evaluator_email) || !is_email($data->evaluator_email)) ? get_option('admin_email') : $data->evaluator_email;	
			else
				$mail['from'] = $current_user->user_email;
			$mail['html'] = $output;
			$mail['fromname'] = $current_user->display_name;
			if(!empty($mail['to'])) {
				rsvpmailer($mail);
				$project = (!empty($data->project)) ? $data->project : '';
				$eval_identify = empty($current_user->user_login) ? 'guest' : $current_user->user_login;
				$key = 'evaluation|' . date( 'Y-m-d' ) . ' 00:00:00|' . $project . '|' . sanitize_text_field($_SERVER['SERVER_NAME']) . '|' . $eval_identify;
				update_user_meta( $speaker_id, $key, $output );
				update_post_meta($data->post_id,'evaluation_given',$current_user->ID);
				update_post_meta($data->post_id,'evaluation_received',$speaker_id);
				$response['status'] = 'Sent by email. Copy saved to dashboard.';
			}
			else
				$response['status'] = 'Copy and paste to print or email';
			
			$response['message'] = '<div>'.$response['status']."</div>\n".$response['message'];
			do_action('rsvpmaker_log_array',
	array('meta_key' => 'evaluation',
	'meta_value' => $response,
    ));
			//process evaluation
			return new WP_REST_Response($response,
			200
		);
		}
		//get form
		$updated = (int) get_option( 'evaluation_forms_updated' );
		if ( empty( $updated ) || ( $updated < strtotime( 'February 25, 2023' ) ) ) {
			$json = file_get_contents( plugin_dir_path( __FILE__ ) . 'evaluation_forms.json' );
			if ( $json ) {
				$eval_data = json_decode( $json );
				foreach ( $eval_data as $eval_row ) {
					if ( isset( $eval_row->timestamp ) ) {
						update_option( 'evaluation_forms_updated', $eval_row->timestamp, false );
						$updated = $eval_row->timestamp;
					} elseif ( $eval_row->option_value ) {
						update_option( $eval_row->option_name, $eval_row->option_value, false );
					}
				}
			}
		}
	
		$project = 'Visionary Communication Level 5 Demonstrating Expertise 2278';
		$project = sanitize_text_field($_GET['project']);
		$form = null;
		if(!empty(trim($project)))
			$form    = fetch_evaluation_form( $project );
		if(empty($form) || empty($form->intro) ) {
			$response['project'] = 'Dynamic Leadership Level 1 Mastering Fundamentals 5';
			$form = fetch_evaluation_form( 'Dynamic Leadership Level 1 Mastering Fundamentals 5' );
			$response['intro'] = '<p>Showing a generic form because project not specified or not recognized.</p>';
		}
		else {
			$response['intro'] = (!empty($form->intro)) ? wpautop($form->intro) : '<p>Intro variables missing';
			$response['project'] = $project;
		}
		$response['timestamp'] = time();
		$prompts = explode("\n",$form->prompts);
		foreach($prompts as $index => $prompt) {
			$prompt = trim($prompt);
			$cells = explode('|',$prompt);
			$response['form'][$index]['prompt'] = array_shift($cells);
			// = $cells;
			$response['form'][$index]['choice'] = '';
			$response['form'][$index]['note'] = '';
			foreach($cells as $cell)
				$response['form'][$index]['choices'][] = array('label'=>$cell,'value'=>$cell);
		}
		$response['second_language_requested'] = ($speaker_id) ? get_user_meta($speaker_id,'second_language_feedback',true) : false;
		$response['second_language'][0]['prompt'] = 'Pace: not too fast or too slow';
		$response['second_language'][0]['choices'] = array(array('label' => '5 (Exemplary)','value' => '5 (Exemplary)'),array('label'=>'4 (Excels)','value'=>'4 (Excels)'),array('label'=>'3 (Accomplished)','value'=>'3 (Accomplished)'),array('label'=>'4 (Emerging)','value'=>'4 (Emerging)'),array('label'=>'5 (Developing)','value'=>'5 (Developing)')); 
		$response['second_language'][0]['note'] = ''; 
		$response['second_language'][0]['choice'] = ''; 
		$response['second_language'][1]['prompt'] = 'Grammar and word usage';
		$response['second_language'][1]['choices'] = array(array('label' => '5 (Exemplary)','value' => '5 (Exemplary)'),array('label'=>'4 (Excels)','value'=>'4 (Excels)'),array('label'=>'3 (Accomplished)','value'=>'3 (Accomplished)'),array('label'=>'4 (Emerging)','value'=>'4 (Emerging)'),array('label'=>'5 (Developing)','value'=>'5 (Developing)')); 
		$response['second_language'][1]['note'] = ''; 
		$response['second_language'][1]['choice'] = ''; 
		$response['second_language'][2]['prompt'] = 'Word tense, gender, and pronouns';
		$response['second_language'][2]['choices'] = array(array('label' => '5 (Exemplary)','value' => '5 (Exemplary)'),array('label'=>'4 (Excels)','value'=>'4 (Excels)'),array('label'=>'3 (Accomplished)','value'=>'3 (Accomplished)'),array('label'=>'4 (Emerging)','value'=>'4 (Emerging)'),array('label'=>'5 (Developing)','value'=>'5 (Developing)')); 
		$response['second_language'][2]['note'] = ''; 
		$response['second_language'][2]['choice'] = '';
		$response['second_language'][3]['prompt'] = 'Clear pronunciation';
		$response['second_language'][3]['choices'] = array(array('label' => '5 (Exemplary)','value' => '5 (Exemplary)'),array('label'=>'4 (Excels)','value'=>'4 (Excels)'),array('label'=>'3 (Accomplished)','value'=>'3 (Accomplished)'),array('label'=>'4 (Emerging)','value'=>'4 (Emerging)'),array('label'=>'5 (Developing)','value'=>'5 (Developing)')); 
		$response['second_language'][3]['note'] = ''; 
		$response['second_language'][3]['choice'] = ''; 
		$response['previous_speeches'] = [];
		$history_table = $wpdb->base_prefix.'tm_history';
		$speech_history_table = $wpdb->base_prefix.'tm_speech_history';	
		$userwhere = (isset($_GET['speaker'])) ? 'AND user_id='.intval($_GET['speaker']) : '';
		$sql = "SELECT user_id as ID, datetime, project_key as project, project as project_text, title, post_id FROM `$history_table` join $speech_history_table ON id=history_id WHERE `role` LIKE 'Speaker' AND `datetime` < NOW() AND `domain` LIKE '".sanitize_text_field($_SERVER['SERVER_NAME'])."' $userwhere order by datetime DESC LIMIT 0,15";
		$p = $wpdb->get_results($sql);
		foreach($p as $speech) {
			$speech->name = $label = get_member_name($speech->ID);
			if($speech->project_text)
				$label .= ' '.$speech->project_text;
			if($speech->title)
				$label .= ' '.$speech->title;
			$label .= ' '.rsvpmaker_date($rsvp_options['short_date'],rsvpmaker_strtotime($speech->datetime));
			$response['previous_speeches'][] = array('label' => $label,'value' => $speech);
		}
		return new WP_REST_Response($response,
			200
		);
		
	}
}
function format_eval_opt($opt,$is_true) {
	$parts = preg_split('/[\(\)]/',$opt);
	$outer_style = 'margin-right: 10px; border: thick solid #000; padding: 5px; font-size: 25px;height: 40px; width: 40px; text-align: center; display: flex; justify-content: center; align-items: center;';
	$outer_style .= ($is_true) ? 'font-weight: bold; color: #fff; background-color: #000' : 'opacity: 0.5';
	return sprintf('<div class="%s" style="%s">%s</div>',($is_true) ? 'evalchoice' : '', $outer_style,$parts[0]);
}

class WP4T_User_Meta extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'user_meta';
		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
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
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
		global $current_user;
		$json = file_get_contents('php://input');
		$data = json_decode($json);
		$response['status'] = '';
		if(isset($data->key) && isset($data->value) && isset($current_user->ID))
			{
				update_user_meta($current_user->ID,sanitize_text_field($data->key),sanitize_text_field($data->value));
				$response['status'] = $data->key.' updated';
			}
		return new WP_REST_Response($response,
			200
		);
	}
}
class WP4T_Timer_Image extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'timerimage';
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
		return current_user_can('edit_posts') && ($_POST['timer_upload'] == get_post_meta(intval($_POST['post_id']),'timer_nonce',true));
	}
	public function handle( $request ) {
	rsvpmaker_debug_log($_SERVER['SERVER_NAME'].' '.$_SERVER['REQUEST_URI'],'rsvpmaker_api');
		$upload_dir = wp_upload_dir();
		//checks suggested by https://www.wordfence.com/learn/how-to-prevent-file-upload-vulnerabilities/
			$allowedMimes = array(
				'jpg|jpeg|jpe' => 'image/jpeg',
				'gif'          => 'image/gif',
				'png'          => 'image/png',
			);
			$fileInfo = wp_check_filetype($_FILES["colorimage"]["name"],$allowedMimes);
			if (empty($fileInfo['ext']) || !$fileInfo['type']) {
				error_log('timer file upload error '.var_export($_FILES,true));
				wp_die('invalid file type');
			}
			$check = getimagesize($_FILES["colorimage"]["tmp_name"]);
			if($check !== false) {
			$color = sanitize_text_field($_POST['color']);
			//$response['nonce_result'] = wp_verify_nonce($_POST['_wpnonce'],'timer_upload');
			//$response['nonce'] = $_POST['_wpnonce'];
			$response['color'] = $color;
			$ext = pathinfo($_FILES["colorimage"]["name"],PATHINFO_EXTENSION);
			$filename = preg_replace('/[^A-Za-z0-9\.]+/','_',$_POST['slug']).'_'.$color.'_'.time().'.'.$ext;
			$response['file'] = $filename;
			$target_file = trailingslashit($upload_dir['path']) . $filename;
			$target_url = trailingslashit($upload_dir['url']) . $filename;
			$response['url'] = $target_url;
			move_uploaded_file($_FILES["colorimage"]["tmp_name"], $target_file);
			require_once ABSPATH . 'wp-admin/includes/image.php';
			$filetype = wp_check_filetype( basename( $target_file ), null );
			$attachment = array(
				'guid'           => $target_url,
				'post_mime_type' => $filetype['type'],
				'post_title'     => preg_replace( '/\.[^.]+$/', '', $filename ),
				'post_content'   => '',
				'post_status'    => 'inherit',
			);
			$attach_id = wp_insert_attachment( $attachment, $target_file, 0 );
			// Generate the metadata for the attachment, and update the database record.
			$attach_data = wp_generate_attachment_metadata( $attach_id, $target_file );
			wp_update_attachment_metadata( $attach_id, $attach_data );
		
			} else {
			  $response['error'] = "File is not an image.";
			}
		return new WP_REST_Response($response,
			200
		);
	}
}
/*
skeleton
class WP4T_XX extends WP_REST_Controller {
	public function register_routes() {
		$namespace = 'rsvptm/v1';
		$path      = 'xx';
		register_rest_route(
			$namespace,
			'/' . $path,
			array(
				array(
					'methods'             => 'GET,POST',
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
		$json = file_get_contents('php://input');
		$data = json_decode($json);
		return new WP_REST_Response($response,
			200
		);
	}
}
{'prompt':'You excelled at','choices':[],'choice':'','note':''},{'prompt':'You may want to work on','choices':[],'choice':'','note':''},{'prompt':'To challenge yourself','choices':[],'choice':'','note':''},{'prompt':'Clarity: Spoken language is clear and is easily understood','choices':[{'label':'5 (Exemplary)','value':'5 (Exemplary)'},{'label':'4 (Excels)','value':'4 (Excels)'},{'label':'3 (Accomplished)','value':'3 (Accomplished)'},{'label':'2 (Emerging)','value':'2 (Emerging)'},{'label':'1 (Developing)','value':'1 (Developing)'}],'choice':'','note':''}
*/
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
		$wptb = new WP4TBlocksData();
		$wptb->register_routes();
		$wpup = new WP4TUpdateRole();
		$wpup->register_routes();
		$tpp = new WP4T_Paths_and_Projects();
		$tpp->register_routes();
		$m4r = new WP4T_Members_for_Role();
		$m4r->register_routes();
		$upagenda = new WP4TUpdateAgenda();
		$upagenda->register_routes();
		$jsonass = new WptJsonAssignmentPost();
		$jsonass->register_routes();
		$multiass = new WptJsonMultiAssignmentPost();
		$multiass->register_routes();
		$enj = new Editable_Note_Json();
		$enj->register_routes();
		$rl = new WP4TRolesList();
		$rl->register_routes();
		$wptcopy = new WP4T_Copy_Post();
		$wptcopy->register_routes();
		$wptpermissions = new WP4T_Permissions();
		$wptpermissions->register_routes();
		$abs = new WP4T_Absences();
		$abs->register_routes();
		$hybrid = new WP4T_Hybrid();
		$hybrid->register_routes();
		$eval = new WP4T_Evaluation();
		$eval->register_routes();
		$umeta = new WP4T_User_Meta();
		$umeta->register_routes();
		$timerimage = new WP4T_Timer_Image();
		$timerimage->register_routes();
		$wp4tmobile = new WP4T_Mobile_Agenda();
		$wp4tmobile->register_routes();
		$wp4tmc = new WP4T_Mobile_Code();
		$wp4tmc->register_routes();
		$wptr = new WP4T_Translations();
		$wptr->register_routes();
	}
);
