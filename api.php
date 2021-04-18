<?php

class Toast_Norole_Controller extends WP_REST_Controller {
  public function register_routes() {
    $namespace = 'rsvptm/v1';
    $path = 'norole/(?P<post_id>[0-9]+)';

    register_rest_route( $namespace, '/' . $path, [
      array(
        'methods'             => 'GET',
        'callback'            => array( $this, 'get_items' ),
        'permission_callback' => array( $this, 'get_items_permissions_check' )
            ),
        ]);     
    }

  public function get_items_permissions_check($request) {
    return true;
  }

public function get_items($request) {
    global $wpdb;
    $hasrole = array();
    $norole = array();
    $post_id = $request['post_id'];
    $date = get_rsvp_date($post_id);
    $absences = get_absences_array($post_id);
    $sql = "SELECT * FROM `$wpdb->postmeta` where post_id=".$post_id." AND meta_value REGEXP '^[0-9]+$' AND BINARY meta_key RLIKE '^_[A-Z].+[0-9]$' ";
    $results = $wpdb->get_results($sql);
    foreach ($results as $row)
        $hasrole[] = $row->meta_value;
    $users = get_users('blog_id='.get_current_blog_id());
    foreach($users as $user)
        {
            if(!in_array($user->ID,$hasrole) && !in_array($user->ID,$absences))
                {
                $userdata = get_userdata($user->ID);
                $norole[] = $userdata->first_name .' '. $userdata->last_name;
                }
        }
    sort($norole);
    return new WP_REST_Response($norole, 200);
  }
}

class WPTContest_Order_Controller extends WP_REST_Controller {
	public function register_routes() {
	  $namespace = 'wptcontest/v1';
	  $path = 'order/(?P<post_id>[0-9]+)';///(?P<nonce>.+)
  
	  register_rest_route( $namespace, '/' . $path, [
		array(
		  'methods'             => 'GET',
		  'callback'            => array( $this, 'get_items' ),
		  'permission_callback' => array( $this, 'get_items_permissions_check' )
			  ),
		  ]);     
	  }
  
	public function get_items_permissions_check($request) {
	  return true;
	}
  
  public function get_items($request) {
	  global $wpdb;
	  $order = get_post_meta($request['post_id'],'tm_scoring_order',true);
	  return new WP_REST_Response($order, 200);
	}
}

class WPTContest_Send_Link extends WP_REST_Controller {
	public function register_routes() {
	  $namespace = 'wptcontest/v1';
	  $path = 'send_link';
  
	  register_rest_route( $namespace, '/' . $path, [
		array(
		  'methods'             => 'POST',
		  'callback'            => array( $this, 'get_items' ),
		  'permission_callback' => array( $this, 'get_items_permissions_check' )
			  ),
		  ]);     
	  }
  
	public function get_items_permissions_check($request) {
	  return is_user_logged_in();
	}
  
  public function get_items($request) {
	global $current_user;
	$email = $_POST['email'];
	$note = wpautop(stripslashes($_POST['note']));
	$mail['subject'] = stripslashes($_POST['subject']);
	$code = $_POST['code'];
	$post_id = $_POST['post_id'];
	$mail['to'] = $email;
	$mail['html'] = $note;
	$mail['from'] = $current_user->user_email;
	$mail['fromname'] = $current_user->display_name;
	$error = rsvpmailer($mail);
	if($error)
		return new WP_REST_Response($error, 200);
	return new WP_REST_Response($mail, 200);
	}
}

class WPTContest_VoteCheck extends WP_REST_Controller {
	public function register_routes() {
	  $namespace = 'wptcontest/v1';
	  $path = 'votecheck/(?P<post_id>[0-9]+)';///(?P<nonce>.+)
  
	  register_rest_route( $namespace, '/' . $path, [
		array(
		  'methods'             => 'GET',
		  'callback'            => array( $this, 'get_items' ),
		  'permission_callback' => array( $this, 'get_items_permissions_check' )
			  ),
		  ]);     
	  }
  
	public function get_items_permissions_check($request) {
		global $current_user;
		$post_id = $request['post_id'];
		$dashboard_users = get_post_meta($post_id,'tm_contest_dashboard_users',true);
		return in_array($current_user->ID,$dashboard_users);
	}
  
  public function get_items($request) {
	  global $wpdb, $current_user;
	  $post_id = $request['post_id'];
	  $votes = toast_scoring_update_get($post_id);
	  return new WP_REST_Response($votes, 200);
	}
}


class WPTContest_GotVote extends WP_REST_Controller {
	public function register_routes() {
	  $namespace = 'wptcontest/v1';
	  $path = 'votereceived/(?P<post_id>[0-9]+)/(?P<judge_id>[0-9]+)';///(?P<nonce>.+)
  
	  register_rest_route( $namespace, '/' . $path, [
		array(
		  'methods'             => 'GET',
		  'callback'            => array( $this, 'get_items' ),
		  'permission_callback' => array( $this, 'get_items_permissions_check' )
			  ),
		  ]);     
	  }
  
	public function get_items_permissions_check($request) {
	  return true;
	}
  
  public function get_items($request) {
    global $wpdb;
    $confirmed = (boolean) get_post_meta($request['post_id'],'tm_vote_received'.$request['judge_id'],true);
	  return new WP_REST_Response($confirmed, 200);
	}
}
//check for update_post_meta($post_id,'tm_vote_received'.$index,true);

class WPT_Timer_Control extends WP_REST_Controller {
	public function register_routes() {
	  $namespace = 'toasttimer/v1';
	  $path = 'control/(?P<post_id>[0-9]+)';///(?P<nonce>.+)
  
	  register_rest_route( $namespace, '/' . $path, [
		array(
		  'methods'             => array('GET','POST'),
		  'callback'            => array( $this, 'get_items' ),
		  'permission_callback' => array( $this, 'get_items_permissions_check' )
			  ),
		  ]);     
	  }
  
	public function get_items_permissions_check($request) {
	  return true;
	}
  
  public function get_items($request) {
	if(!empty($_POST))
		{
			$control = $_POST;
			update_post_meta($request['post_id'],'timing_light_control',$control);
		}
	//else
		$control = get_post_meta($request['post_id'],'timing_light_control',true);
	rsvpmaker_debug_log($request,'timing light API request');
	rsvpmaker_debug_log($_REQUEST,'timing light server request');
	rsvpmaker_debug_log($control,'timing light control');
	  return new WP_REST_Response($control, 200);
	}
}

class Toast_Agenda_Timing extends WP_REST_Controller {
	public function register_routes() {
	  $namespace = 'rsvptm/v1';
	  $path = 'agendatime/(?P<post_id>[0-9]+)';
  
	  register_rest_route( $namespace, '/' . $path, [
		array(
		  'methods'             => 'GET',
		  'callback'            => array( $this, 'get_items' ),
		  'permission_callback' => array( $this, 'get_items_permissions_check' )
			  ),
		  ]);     
	  }
  
	public function get_items_permissions_check($request) {
	  return true;
	}
  
  public function get_items($request) {
	$timing = get_agenda_timing($request['post_id']);
	  return new WP_REST_Response($timing, 200);
	}
  }

class Toast_Manual_Lookup extends WP_REST_Controller {
	public function register_routes() {
	  $namespace = 'rsvptm/v1';
	  $path = 'type_to_manual/(?P<type>.+)';
  
	  register_rest_route( $namespace, '/' . $path, [
		array(
		  'methods'             => 'GET',
		  'callback'            => array( $this, 'get_items' ),
		  'permission_callback' => array( $this, 'get_items_permissions_check' )
			  ),
		  ]);     
	  }
  
	public function get_items_permissions_check($request) {
	  return true;
	}
  
  public function get_items($request) {
	$type = urldecode($request['type']);
	$options = get_manuals_by_type_options($type);
	$projects = '';
	$pa = get_projects_array('options');
/*	echo '<br />';
	print_r($type);
	echo '<br />';
	print_r($pa);
	echo '<br />Options<br />';
	print_r($options);
*/
	if($type == 'Other')
		$manual = 'Other Manual or Non Manual Speech';
	elseif($type == 'Manual')
		$manual = "COMPETENT COMMUNICATION";
	elseif($type == 'Pathways 360')
		$manual = "Pathways 360 Level 5 Demonstrating Expertise";
	elseif($type == 'Pathways Mentor Program')
		$manual = "Pathways Mentor Program Level 1 Educational Program";
	else
		$manual = $type .' Level 1 Mastering Fundamentals';
	if(strpos($manual,'ways 360'))
		$projects = '<option value="Pathways 360 Level 5 Demonstrating Expertise 99">Pathways 360° Evaluation</option>';
	else
		$projects = '<option value="">Select Project</option>'.$pa[$manual];
	return new WP_REST_Response(array('list' => $options, 'projects' => $projects), 200);
	}
}

class Editor_Assign extends WP_REST_Controller {
	public function register_routes() {
	  $namespace = 'rsvptm/v1';
	  $path = 'editor_assign';
  
	  register_rest_route( $namespace, '/' . $path, [
		array(
		  'methods'             => 'POST',
		  'callback'            => array( $this, 'handle' ),
		  'permission_callback' => array( $this, 'get_items_permissions_check' )
		),
		  ]);     
	  }
  
	public function get_items_permissions_check($request) {
		$check = $_POST['check'];
		return (wp_verify_nonce($check,'wpt_role_update') && is_user_logged_in() && current_user_can('edit_signups'));
	}
  
  public function handle($request) {
	global $wpdb, $current_user;
	$post_id = (int) $_POST["post_id"];
	$user_id = (int) $_POST["user_id"];
	$role = sanitize_text_field($_POST["role"]);
	$editor_id = (empty($_POST["editor_id"])) ? $current_user->ID : (int) $_POST["editor_id"];
	$timestamp = get_rsvp_date($post_id);
	$was = get_post_meta($post_id,$role,true);
	update_post_meta($post_id,$role,$user_id);
	if(strpos($role,'Speaker'))
		{
		delete_post_meta($post_id,'_manual'.$role);
		delete_post_meta($post_id,'_project'.$role);
		delete_post_meta($post_id,'_title'.$role);
		delete_post_meta($post_id,'_intro'.$role);
		}
	if(time() > strtotime($timestamp))
		{
		$key = make_tm_usermeta_key ($role, $timestamp, $post_id);
		$roledata = make_tm_roledata_array ('wp_ajax_editor_assign');
		if($user_id)
			update_user_meta($user_id,$key,$roledata);
		$sql = $wpdb->prepare("DELETE FROM $wpdb->usermeta WHERE meta_key=%s AND user_id != %d",$key,$user_id);
		$wpdb->query($sql);
		}
	$name = get_member_name($user_id);
	$status = sprintf('%s assigned to %s',preg_replace('/[\_0-9]/',' ',$role),$name);
	$log = get_member_name($editor_id) .' assigned '.clean_role($role).' to '.get_member_name($user_id).' for '.$timestamp;
	if($was)
		$log .= ' (was: '.get_member_name($was).')';
	$log .= ' <small><em>(Posted: '.date('m/d/y H:i').')</em></small>';
	
	add_post_meta($post_id,'_activity_editor', $log );
	$type = '';
	$manual = '';
	$projects = '';
	$options = '';
	if(strpos($role,'peaker')) {
		$track = get_speaking_track($user_id);
		$type = $track["type"];
		$manual = $track["manual"];
		if(!empty($manual) && !strpos($manual,'Manual') )
			update_post_meta($post_id,'_manual'.$role,$manual);
		$options = sprintf('<option value="%s">%s</option>',$track['manual'],$track['manual']);
		$options .= get_manuals_by_type_options($type);
		$projects = '<option value="">Select Project</option>'.$track["projects"];
	}
	  return new WP_REST_Response(array('status' => $status, 'type' => $type, 'list' => $options, 'projects' => $projects), 200);
	}
}

class TM_Role extends WP_REST_Controller {
	public function register_routes() {
	  $namespace = 'rsvptm/v1';
	  $path = 'tm_role';
  
	  register_rest_route( $namespace, '/' . $path, [
		array(
		  'methods'             => 'POST',
		  'callback'            => array( $this, 'handle' ),
		  'permission_callback' => array( $this, 'get_items_permissions_check' )
		),
		  ]);     
	  }
  
	public function get_items_permissions_check($request) {
		return ( is_user_logged_in() );
	}
  
  public function handle($request) {
	$response['content'] = toastmasters_role_signup ();
	  return new WP_REST_Response($response, 200);
	}
}

class WPTM_Reports extends WP_REST_Controller {
	public function register_routes() {
	  $namespace = 'rsvptm/v1';
	  $path = 'reports/(?P<report>.+)/(?P<user_id>[0-9]+)';
  
	  register_rest_route( $namespace, '/' . $path, [
		array(
		  'methods'             => 'GET',
		  'callback'            => array( $this, 'handle' ),
		  'permission_callback' => array( $this, 'get_items_permissions_check' )
		),
		  ]);     
	  }
  
	public function get_items_permissions_check($request) {
	  return (is_user_logged_in() && current_user_can('view_reports'));
	}
  
  public function handle($request) {
	global $wpdb;
	$report = $request["report"];
	$user_id = $request["user_id"];
	$content = '';
	if($report == 'speeches_by_manual')
		$content = speeches_by_manual($user_id);
	elseif($report == 'traditional_program')
		$content = toastmasters_progress_report($user_id);
	elseif($report == 'traditional_advanced') {
		ob_start();
		if($user_id)
			{
			$userdata = get_userdata($user_id);
			toastmasters_advanced_user ($userdata,true);	
			}
		else
			{
			echo 'Select member from the list above';
			echo toastmasters_advanced();
			}		
		$content = ob_get_clean();
	}
	elseif($report == 'pathways') {
		ob_start();
		pathways_report($user_id);
		$content = ob_get_clean();
	}
	  return new WP_REST_Response(array('report' => $report, 'content' => $content), 200);
	}
}

class WPTM_Dues extends WP_REST_Controller {
	public function register_routes() {
	  $namespace = 'rsvptm/v1';
	  $path = 'dues';
  
	  register_rest_route( $namespace, '/' . $path, [
		array(
		  'methods'             => 'POST',
		  'callback'            => array( $this, 'handle' ),
		  'permission_callback' => array( $this, 'get_items_permissions_check' )
		),
		  ]);     
	  }
  
	public function get_items_permissions_check($request) {
	$nonce = $_POST['tmn'];
	  return (wp_verify_nonce($nonce,'wpt_dues_report') && is_user_logged_in() && current_user_can('view_reports'));
	}
  
  public function handle($request) {
	global $wpdb, $current_user;
	$confirmation = array();
	$ti_paid_key = $_POST['ti_paid_key'];
	$paidkey = $_POST['paidkey'];
	$norenew = $_POST['norenew'];
	if(isset($_POST['markpaid'])) {
		foreach($_POST['markpaid'] as $member_id => $value) {
			$until = $_POST['until'][$member_id];
			update_user_meta($member_id,$paidkey,$until);
			delete_user_meta($member_id,$norenew);		
			$confirmation['marked_paid'] = 'Marked paid until '.$until;
		}
	}
	if(isset($_POST[$ti_paid_key])) {
		foreach($_POST[$ti_paid_key] as $member_id => $amount) {
			update_user_meta($member_id,$ti_paid_key, $amount);
			delete_user_meta($member_id,$norenew);		
			$confirmation['paid_ti'] = 'Paid to TI: '.$amount;
		}
	}

	if(isset($_POST['updatevoid']) && is_numeric($_POST['updatevoid'])) {
		$member_id = (int) $_POST['updatevoid'];
		delete_user_meta($member_id,$ti_paid_key);
		delete_user_meta($member_id,$paidkey);
		delete_user_meta($member_id,$norenew);		
		$confirmation['paid_ti'] = 'Voided ';
	}

	if(isset($_POST['no'])) {
		foreach($_POST['no'] as $member_id => $until) {
			update_user_meta($member_id,$norenew,$until);
			$confirmation['no_renewal'] = 'Marked not planning to renew';
		}
	}

	if(!empty($_POST['note'])) {
		$member_id = $_POST['member_id'];
		$note = '<strong>'.stripslashes($_POST['note']).'</strong> ('.$current_user->display_name.') '.rsvpmaker_date('F j, Y');
		$key = $_POST['treasurer_note_key'];
		add_user_meta($member_id,$key,$note);
		$confirmation['note'] = $note;
	}

	$confirmation['member_id'] = $member_id;
	return new WP_REST_Response($confirmation, 200);
	}
}

class WPTM_Money extends WP_REST_Controller {
	public function register_routes() {
	  $namespace = 'rsvptm/v1';
	  $path = 'money';
  
	  register_rest_route( $namespace, '/' . $path, [
		array(
		  'methods'             => 'GET',
		  'callback'            => array( $this, 'handle' ),
		  'permission_callback' => array( $this, 'get_items_permissions_check' )
		),
		  ]);     
	  }
  
	public function get_items_permissions_check($request) {
	  return (is_user_logged_in() && current_user_can('view_reports'));
	}
  
  public function handle($request) {
	$result = wpt_stripe_transactions ();
	return new WP_REST_Response($result, 200);
	}
}

class WPTM_Reminders extends WP_REST_Controller {
	public function register_routes() {
	  $namespace = 'rsvptm/v1';
	  $path = 'duesreminders';
  
	  register_rest_route( $namespace, '/' . $path, [
		array(
		  'methods'             => 'GET',
		  'callback'            => array( $this, 'handle' ),
		  'permission_callback' => array( $this, 'get_items_permissions_check' )
		),
		  ]);     
	  }
  
	public function get_items_permissions_check($request) {
	  return (is_user_logged_in() && current_user_can('view_reports'));
	}
  
  public function handle($request) {
	$result['content'] = wpt_dues_reminders ();
	return new WP_REST_Response($result, 200);
	}
}

class WPTM_Verify extends WP_REST_Controller {
	public function register_routes() {
	  $namespace = 'rsvptm/v1';
	  $path = 'verify/(?P<action>[a-z_]+)';
  
	  register_rest_route( $namespace, '/' . $path, [
		array(
		  'methods'             => 'GET',
		  'callback'            => array( $this, 'handle' ),
		  'permission_callback' => array( $this, 'get_items_permissions_check' )
		),
		  ]);     
	  }
  
	public function get_items_permissions_check($request) {
	  return true;
	}
  
  public function handle($request) {
	$result['action'] = $request['action'];
	$result['result'] = get_transient($request['action']);
	return new WP_REST_Response($result, 200);
	}
}

class WPTM_Tweak_Times extends WP_REST_Controller {
	public function register_routes() {
	  $namespace = 'rsvptm/v1';
	  $path = 'tweak_times';
  
	  register_rest_route( $namespace, '/' . $path, [
		array(
		  'methods'             => 'POST,GET',
		  'callback'            => array( $this, 'handle' ),
		  'permission_callback' => array( $this, 'get_items_permissions_check' )
		),
		  ]);     
	  }
  
	public function get_items_permissions_check($request) {
	  return is_user_logged_in();
	}
  
  public function handle($request) {
	global $wpdb, $current_user;

	if(isset($_GET['post_id'])) {
			global $rsvp_options;
			$post = get_post($_GET['post_id']);	
			$time_format = str_replace('%Z','',$rsvp_options['time_format']);
			if(rsvpmaker_is_template($post->ID)) {
				$sked = get_template_sked($post->ID);
				$date = '2030-01-01 '.$sked['hour'].':'.$sked['minutes'];
			}
			else
				$date = get_rsvp_date($post->ID);

			$ts_start = rsvpmaker_strtotime($date);
			$elapsed = 0;
			$time_array = array();
			$pattern = '|<!-- wp:wp4toastmasters/agendanoterich2[^>]+>(.+)<!-- /wp:wp4toastmasters/agendanoterich2 -->|sU';
			$pattern = '/<p class="wp-block-wp4toastmasters-agendanoterich2">(.+)/';
			preg_match_all($pattern,$post->post_content,$matches);
			$notes = $matches[1];
			$output = '';
			$lines = explode("\n",$post->post_content);
			$block_count = 0;
			$update = false;
			$new = '';
			foreach($lines as $index => $line) {
				$pattern = '/{"role":[^}]+}/';
				preg_match($pattern,$line,$match);
				if(!empty($match[0])) {
					$data[] = (array) json_decode($match[0]);
				}
				elseif(strpos($line,'-- wp:wp4toastmasters/agendanoterich2') || strpos($line,'-- wp:wp4toastmasters/agendaedit')) {
					$pattern = '/{.+}/';
					preg_match($pattern,$line,$match);
					if(!empty($match[0])) {
						$atts = (array) json_decode($match[0]);
						$data[] = $atts;
						//$block_count++;
					}
				}
				$new .= $line."\n";
			}
		
			$block_count = 0;
			$output = array();
			$rawdata = wpt_blocks_to_data($new);
			foreach($data as $d) {
				$t = $ts_start + ($elapsed * 60);
				$waselapsed = $elapsed;
				$start_time_text = rsvpmaker_strftime($time_format,$t);
				if(!$start_time_text)
					$start_time_text = rsvpmaker_date('h:i A',$t);
				$start_time = $elapsed;
		
				$time_allowed = (empty($d['time_allowed'])) ? 0 : (int) $d['time_allowed'];
		
				$padding_time = (!empty($d['role']) && ($d['role'] == 'Speaker') && !empty($d['padding_time'])) ? (int) $d['padding_time'] : 0;
		
				$add = $time_allowed + $padding_time;
		
				$elapsed += $add;
		
				if(!empty($d['role']))
					{
						$start = (empty($d['start'])) ? 1 : $d['start'];
						$index = str_replace(' ','_',$d['role']);
						$label = $d['role'];
					}
		
				elseif(!empty($d['uid']))		
					{
					$start = 1;
					$label = $d['uid'];
					if(strpos($label,'ote'))
					{
						$note = array_shift($notes);
						if($note)
							$label = trim(strip_tags($note));
					}
					if(!empty($d['editable']))
						$label = $d['editable'];
					}
				else
					continue;
				$output[] = array('label' => $label, 'time' => $start_time_text, 'elapsed' => $waselapsed, 'add' => $add);
				$block_count++;
			}
			$t = $ts_start + ($elapsed * 60);
			$start_time_text = rsvpmaker_strftime($time_format,$t);
			$start_time_text = rsvpmaker_strftime($time_format,$t);
			if(!$start_time_text)
				$start_time_text = rsvpmaker_date('h:i A',$t);
			
			$output[] = array('label' => 'End', 'time' => $start_time_text, 'elapsed' => $elapsed, 'add' => 0);
		return new WP_REST_Response($output, 200);	
		}
	//}

	$post_id = (int) $_POST['post_id'];
	$post = get_post($post_id);
	$lines = explode("\n",$post->post_content);
	$block_count = 0;
	$update = '';
	$log = '';
	foreach($lines as $line) {
		$pattern = '/{"role":[^}]+}/';
		preg_match($pattern,$line,$match);
		if(!empty($match[0])) {
			$atts = json_decode($match[0]);
			$index = str_replace(' ','_',$atts->role).'-';
			$index .= (empty($atts->start)) ? '1' : $atts->start;
			$log .= $index."\n";
			if(isset($_POST['remove'][$index])) {
				$update .= "\n";
				//$line = '<!-- wp:wp4toastmasters/role {"role":""} /-->'; // empty role, will not display
				$log .= "remove $index \n";
				continue;
			}
			else {
				$log .= "update $index \n";
				$atts->time_allowed = $_POST['time_allowed'][$index]; //numeric string
				$atts->padding_time = $_POST['padding_time'][$index];
				$atts->count = (int) $_POST['count'][$index];
			}
			$line = preg_replace($pattern,json_encode($atts),$line);
		}
		elseif(strpos($line,'-- wp:wp4toastmasters/agendanoterich2') || strpos($line,'-- wp:wp4toastmasters/agendaedit')) {
			//if(!is_numeric(trim($_POST['time_allowed'][$block_count])))
				//return new WP_REST_Response(array('error' => 'non-numeric data'), 200);
			$pattern = '/{.+}/';
			preg_match($pattern,$line,$match);
			if(!empty($match[0])) {
				$atts = json_decode($match[0]);
				$index = str_replace('.','_',$atts->uid);
				$log .= "$index \n";
				if(isset($_POST['remove'][$index])) {
					$log .= "remove $index \n";
					$update .= "\n";
					if(!strpos($line,'editable')) {
						foreach($lines as $line){
							if(strpos($line,'wp:wp4toastmasters'))
								break;//eat up lines until close
						}
					continue;
					}
				}
				else {
				$log .= "update $index \n";
				if(isset($atts->editable))
					$labels[$atts->uid] = $atts->editable;
				$atts->time_allowed = $_POST['time_allowed'][$index];
				$line = preg_replace($pattern,json_encode($atts),$line);
				}
			}	
		}
		$log .= "line: $line\n";
		$update .= $line . "\n";
	}
	$edits = array();
	if(isset($_POST['edits'])) {
		foreach($_POST['edits'] as $index) {
			$note = stripslashes($_POST[$index]);
			$note = preg_replace('/(style=("|\Z)(.*?)("|\Z))/','',$note);
			$note = wp_filter_post_kses($note);
			$index = str_replace('_','.',$index);
			update_post_meta($post_id,"agenda_note_".$index,$note);
			$edits[] = $labels[$index];
		}
	}
	$up['ID'] = $post->ID;
	$up['post_content'] = $update;
	$response['return'] = wp_update_post($up);
	$response['blocks'] = $block_count;
	$response['next'] = sprintf('<p><a href="%s" target="_blank">View Agenda</a></p>',add_query_arg(array('print_agenda' => 1, 'no_print' => 1),get_permalink($post->ID)));
	$response['next'] .= sprintf('<p><a href="%s">Signup</a></p>',get_permalink($post->ID));
	$response['edits'] = $edits;
	if(current_user_can('edit_post',$post)) {
		$edit = get_edit_post_link($post->ID);
		$response['next'] .= sprintf('<p><a href="%s">Edit Event</a></p>',$edit);
	}
	if(rsvpmaker_is_template($post->ID))
		$response['next'] .= sprintf('<p><a href="%s">Create/Update</a> events from tempate</p>',admin_url('edit.php?post_type=rsvpmaker&page=rsvpmaker_template_list&t='.$post->ID));
	fix_timezone();
	$response['next'] .= sprintf('<p>Updated: %s</p>',date('r'));
	$response['note'] = $note;
	$response['log'] = $log;
	//$response['formpost'] = $_POST;
	return new WP_REST_Response($response, 200);
	}
}

add_action('rest_api_init', function () {
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
	 $rsvpexp = new RSVP_Export();
	 $rsvpexp->register_routes();
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
} );
