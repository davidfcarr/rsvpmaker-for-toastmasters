<?php
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
				$absences = get_post_meta( $post_id, 'wp4t_tm_absence' );
				if ( is_array( $absences ) ) {
					$absences = array_unique( $absences );
				}
				else 
					$absences = [];
				$haverole = wp4t_haverole($post_id);
				$members = wp4t_get_club_members();
				$memberstatus = [];
				foreach($members as $member) {
					$status = '';
					if(isset($haverole[$member->ID]))			
						$status = __( 'Signed up for', 'rsvpmaker-for_toastmasters' ) . ': ' . $haverole[$member->ID];
					elseif(in_array($member->ID,$absences))
						$status = __('Planned Absence','rsvpmaker-for-toastmasters');
					elseif ( $member->ID > 0 ) {
						$held = wp4t_last_held_role($member->ID, wp4t_clean_role($role));
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
				$members = wp4t_get_club_members();
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
					$result = add_post_meta($post_id,'wp4t_tm_absence',$id);
				else {
					$result = delete_post_meta($post_id,'wp4t_tm_absence',$current_user->ID);
				}
			}
			elseif($wasopen) {
				$was = get_post_meta($post_id,$key,true);
				if(!empty($was)) {
					$agendadata['taken'] = wp4t_get_member_name($was);
					$agendadata['update'][] ='already assigned: '.wp4t_get_member_name($was);
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
					if(strpos($field,'intro') !== false) {
						$v = wp_kses_post(wpautop($data->$field));
						$v = preg_replace('/style=".+"/','', $v); //strip inline style
					}
					else {
					$v = sanitize_text_field($data->$field);
					}
				}
				$agendadata['update'][] = "$k = $v";
				update_post_meta($post_id,$k,$v);
			}
		}
		if(isset($data) && isset($data->absence))
		{
			$absence = intval($data->absence);
			if($absence) {
				$result = add_post_meta($post_id,'wp4t_tm_absence',$current_user->ID);
				$agendadata['absence_update'] = 'added '.$current_user->ID.' '.$current_user->display_name;
			}
			else {
				$result = delete_post_meta($post_id,'wp4t_tm_absence',$current_user->ID);
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
				$content .= wp4t_tm_agenda_content($post_id);
			} catch (Exception $e) {
				$content .= 'Caught exception: '.  $e->getMessage(). "\n";
			}
			try {
				$content = apply_filters( 'email_agenda', $content );
			} catch (Exception $e) {
				$content .= 'Caught exception: '.  $e->getMessage(). "\n";
			}
			//ob_start();
			//wp4t_awesome_open_roles($post_id, false,$request_array);
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
			$report = wp4t_get_speech_progress_report();
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
		$memberlist = get_transient('wp4t_memberlist');
		if(false === $memberlist || !is_array($memberlist)) {
		$memberlist = [];
		$members = wp4t_get_club_members();
		foreach($members as $member) {
			$name = (!empty($member->first_name)) ? $member->first_name.' '.$member->last_name : $member->display_name;
			$memberlist[] = array('name'=>$name,'ID'=>$member->ID);
		}
		$memberlist[] = array('name' => 'Open', 'ID' => 0);
		$memberlist[] = array('name' =>  wp4t_get_member_name(-1), 'ID' => -1);
		$memberlist[] = array('name' =>  wp4t_get_member_name(-2), 'ID' => -2);
		$memberlist[] = array('name' => wp4t_get_member_name(-3), 'ID' => -3);
		$memberlist[] = array('name' => wp4t_get_member_name(-4), 'ID' => -4);
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
		set_transient('wp4t_memberlist',$memberlist,DAY_IN_SECONDS);
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

function wpt_get_mobile_agendadata($user_id = 0) {
	global $current_user,$post,$email_context;
	$email_context = true;
	$agendas = [];
	$post = false;
	$meetings = future_toastmaster_meetings( 4 );
	foreach($meetings as $meeting) {
		$post_id = $meeting->ID;
		$agenda['post_id'] = $post_id;
		$title = strlen($meeting->post_title) > 30 ? substr($meeting->post_title,0,27).'...' : $meeting->post_title;
		$agenda['title'] = rsvpmaker_date('M j',$meeting->ts_start) .' '.$title;
		$agenda['intros'] = wp4t_speech_intros($post_id);
		$agenda['html'] = wp4t_tm_agenda_content($post_id);
		$agenda['roles'] = [];
		$lastcount = [];
		$blocksdata = get_post_meta($post_id,'_blocksdata', true);
		if(empty($blocksdata)) {
			$blocksdata = parse_blocks($meeting->post_content);
			update_post_meta($post_id,'_blocksdata',$blocksdata);
		}
		foreach($blocksdata as $block) {
			if(isset($block['attrs']) && isset($block['attrs']['role']))
				{
					$role = (!empty($block['attrs']['custom_role'])) ? $block['attrs']['custom_role'] : $block['attrs']['role'];
					$role_display = __($role,'rsvpmaker-for-toastmasters');
					$count = isset($block['attrs']['count']) ? $block['attrs']['count'] : 1;
					$start = (isset($lastcount[$role])) ? $lastcount[$role] + 1 : 1;
					$lastcount[$role] = $start + $count - 1;
					$backup = !empty($block['attrs']['backup']) ? 1 : 0;
					for($i=$start; $i < ($count + $start); $i++)
					{
						$key = wp4t_fieldbase($role,$i);
						$assignment = array('post_id'=>$post_id,'assignment_key'=>$key,'role'=>$role,'role_display'=>$role_display);
						$assignment['ID'] = get_post_meta($post_id,$key, true);
						$assignment['suggestion'] = '';
						if(empty($assignment['ID'])) {
							$assignment['name'] = '';
							$assignment['suggestion'] = get_post_meta($post_id,'_suggest'.$key, true);
						}
						elseif(is_numeric($assignment['ID'])) {
							$assignment['name'] = wp4t_get_member_name($assignment['ID']);
						}
						else
							$assignment['name'] = $assignment['ID'].' (guest)';
						if($assignment['ID'] && ('Speaker' == $role)) {
							$speakerdata = wp4t_get_speaker_array_by_field($key,$assignment['ID'],$post_id);
							$project_key = ($speakerdata['project']) ? $speakerdata['project'] : '';
							$speakerdata['evaluation_link'] = wp4t_evaluation_form_url( $assignment['ID'], $post_id );//add_query_arg('evalme',$current_user->ID,get_permalink())
							$assignment = array_merge($assignment,$speakerdata);
						}
						$agenda['roles'][] = $assignment;
					}
			
					if($backup) {
						$key = wp4t_fieldbase('Backup '.$role,$start);
						$assignment = array('post_id'=>$post_id,'assignment_key'=>$key,'role'=>'Backup '.$role);
						$assignment['ID'] = intval( get_post_meta($post_id,$key, true) );
						$assignment['name'] = ($assignment['ID']) ? wp4t_get_member_name($assignment['ID']) : '';
						if($assignment['ID'] && ('Speaker' == $role)) {
							$speakerdata = wp4t_get_speaker_array_by_field($key,$assignment['ID'],$post_id);
							$assignment = array_merge($assignment,$speakerdata);
						}
					$agenda['roles'][] = $assignment;
					}
				}
				elseif('wp4toastmasters/agendaedit' == $block['blockName']) {
					$editable['headline'] = $block['attrs']['editable'];
					$text = get_post_meta($post_id,'agenda_note_'.$block['attrs']['uid'],true);
					if ( empty( $text ) && ! empty( $block['attrs']['defaultContent'] ) ) {
						$text = $block['attrs']['defaultContent'];
						if ( function_exists( 'wp4t_decode_editable_note_content' ) ) {
							$text = wp4t_decode_editable_note_content( $text );
						}
					}
					$editable['content'] = ($text) ? wpt_sanitize_user_html($text) : '';
					$editable['key'] = 'agenda_note_'.$block['attrs']['uid'];
					$agenda['editable'][] = $editable;
				}
		}
		//end tour through blocks
		if(strpos($meeting->post_content,'wp:wp4toastmasters/absences')) {
			$assignment = array('post_id'=>$post_id,'assignment_key'=>'_planned_absence_1','role'=>'Planned Absence');
			$absences = get_post_meta( $meeting->ID, 'wp4t_tm_absence' );
			if(is_array($absences))
				$absences = array_unique($absences);
			else
				$absences = [];
			$agenda['absences'] = [];
			foreach($absences as $ab) {
				$abs_list[] = wp4t_get_member_name($ab);
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

function wp4t_program() {
	$manuals_by_type = wp4t_get_manuals_by_type();
	$projects = wp4t_get_projects_array();
	$program['maxtime'] = wp4t_get_projects_array('times');
	$program['display_time'] = wp4t_get_projects_array('display_times');
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

function wpt_mobile_translations() {



	$locale = get_locale();



	if($locale == 'en_EN')



		return;



	global $toast_roles;



	$translations = $toast_roles;



	$localkey = 'wp4t_translations_'.$locale;



	$localtranslations = get_option($localkey,[]);



	$terms = array(



		'Take Role' => __('Take Role','rsvpmaker-for-toastmasters'),



		'Cancel' => __('Cancel','rsvpmaker-for-toastmasters'),



		'Edit' => __('Edit','rsvpmaker-for-toastmasters'),



		'Suggest' => __('Suggest','rsvpmaker-for-toastmasters'),



		'Delete' => __('Delete','rsvpmaker-for-toastmasters'),



		'Select' => __('Select','rsvpmaker-for-toastmasters'),



		'Send Email' => __('Send Email','rsvpmaker-for-toastmasters'),



		'Request by Email' => __('Request by Email','rsvpmaker-for-toastmasters'),



		'Suggest' => __('Suggest','rsvpmaker-for-toastmasters'),



		'Vote' => __('Vote','rsvpmaker-for-toastmasters'),



		'Voting' => __('Voting','rsvpmaker-for-toastmasters'),



		'Home' => __('Home','rsvpmaker-for-toastmasters'),



		'Agenda' => __('Agenda','rsvpmaker-for-toastmasters'),



		'Timer' => __('Timer','rsvpmaker-for-toastmasters'),



		'Start' => __('Start','rsvpmaker-for-toastmasters'),



		'Stop' => __('Stop','rsvpmaker-for-toastmasters'),



		'Pause' => __('Pause','rsvpmaker-for-toastmasters'),



		'Settings' => __('Settings','rsvpmaker-for-toastmasters'),



		"Vote Counter's Tool" => __("Vote Counter's Tool",'rsvpmaker-for-toastmasters'),



		"Publish" => __("Publish",'rsvpmaker-for-toastmasters'),



		"Unpublish" => __("Unpublish",'rsvpmaker-for-toastmasters'),



		"New Ballot" => __("New Ballot",'rsvpmaker-for-toastmasters'),



		"Include for every meeting" => __("Include for every meeting",'rsvpmaker-for-toastmasters'),



		"Signature Required" => __("Signature Required",'rsvpmaker-for-toastmasters'),



		"Send web voting link" => __("Send web voting link",'rsvpmaker-for-toastmasters'),



		"Email the link to me" => __("Email the link to me",'rsvpmaker-for-toastmasters'),



		"Email the link to members" => __("Email the link to members",'rsvpmaker-for-toastmasters'),



		"Reset Ballot" => __("Reset Ballot",'rsvpmaker-for-toastmasters'),



		"Domain or domain|code" => __("Domain or domain|code",'rsvpmaker-for-toastmasters'),



		"Code or email" => __("Code or email",'rsvpmaker-for-toastmasters'),



		"Add" => __("Add",'rsvpmaker-for-toastmasters'),



		"Reset Clubs List" => __("Reset Clubs List",'rsvpmaker-for-toastmasters'),



		"Assign" => __("Assign","rsvpmaker-for-toastmasters"),



		"Back to Vote Counter Controls?" => __("Back to Vote Counter Controls?","rsvpmaker-for-toastmasters"),



		"Backup Speaker" => __("Backup Speaker","rsvpmaker-for-toastmasters"),



		"Checking for ballots ..." => __("Checking for ballots ...","rsvpmaker-for-toastmasters"),



		"Done" => __("Done","rsvpmaker-for-toastmasters"),



		"Go Back" => __("Go Back","rsvpmaker-for-toastmasters"),



		"Language Preference" => __("Language Preference","rsvpmaker-for-toastmasters"),



		"Log missed translations" => __("Log missed translations","rsvpmaker-for-toastmasters"),



		"Members can vote using the app or a web link." => __("Members can vote using the app or a web link.","rsvpmaker-for-toastmasters"),



		"Note" => __("Note","rsvpmaker-for-toastmasters"),



		"Or Type Choice" => __("Or Type Choice","rsvpmaker-for-toastmasters"),



		"Planned Absence" => __("Planned Absence","rsvpmaker-for-toastmasters"),



		"Progress Report" => __("Progress Report","rsvpmaker-for-toastmasters"),



		"Send Web Voting Link" => __("Send Web Voting Link","rsvpmaker-for-toastmasters"),



		"Status: French translation started." => __("Status: French translation started.","rsvpmaker-for-toastmasters"),



		"Status: Spanish planned." => __("Status: Spanish planned.","rsvpmaker-for-toastmasters"),



		"Suggest Role" => __("Suggest Role","rsvpmaker-for-toastmasters"),



		"Translation" => __("Translation","rsvpmaker-for-toastmasters"),



		"Use this function to recommend that another member take the selected role" => __("Use this function to recommend that another member take the selected role","rsvpmaker-for-toastmasters"),



		"Voted" => __("Voted","rsvpmaker-for-toastmasters"),



		"beta" => __("beta","rsvpmaker-for-toastmasters"),



	"Path Not Set" => __("Path Not Set",'rsvpmaker-for-toastmasters'),



	"Dynamic Leadership" => __("Dynamic Leadership",'rsvpmaker-for-toastmasters'),



	"Effective Coaching" => __("Effective Coaching",'rsvpmaker-for-toastmasters'),



	"Engaging Humor" => __("Engaging Humor",'rsvpmaker-for-toastmasters'),



	"Innovative Planning" => __("Innovative Planning",'rsvpmaker-for-toastmasters'),



	"Leadership Development" => __("Leadership Development",'rsvpmaker-for-toastmasters'),



	"Motivational Strategies" => __("Motivational Strategies",'rsvpmaker-for-toastmasters'),



	"Persuasive Influence" => __("Persuasive Influence",'rsvpmaker-for-toastmasters'),



	"Presentation Mastery" => __("Presentation Mastery",'rsvpmaker-for-toastmasters'),



	"Strategic Relationships" => __("Strategic Relationships",'rsvpmaker-for-toastmasters'),



	"Team Collaboration" => __("Team Collaboration",'rsvpmaker-for-toastmasters'),



	"Visionary Communication" => __("Visionary Communication",'rsvpmaker-for-toastmasters'),



	"Pathways 360" => __("Pathways 360",'rsvpmaker-for-toastmasters'),



	"Pathways Mentor Program" => __("Pathways Mentor Program",'rsvpmaker-for-toastmasters'),



	"Other" => __("Other",'rsvpmaker-for-toastmasters'),



	"Level" => __("Level",'rsvpmaker-for-toastmasters'),



	"Pathways 360° Evaluation" => __("Pathways 360° Evaluation",'rsvpmaker-for-toastmasters'),



	"Mentor Program: Mentoring" => __("Mentor Program: Mentoring",'rsvpmaker-for-toastmasters'),



	"Mentor Program: Advanced Mentoring" => __("Mentor Program: Advanced Mentoring",'rsvpmaker-for-toastmasters'),



	"Ice Breaker" => __("Ice Breaker",'rsvpmaker-for-toastmasters'),



	"Evaluation and Feedback - First Speech" => __("Evaluation and Feedback - First Speech",'rsvpmaker-for-toastmasters'),



	"Evaluation and Feedback - Second Speech" => __("Evaluation and Feedback - Second Speech",'rsvpmaker-for-toastmasters'),



	"Evaluation and Feedback - Evaluator Speech" => __("Evaluation and Feedback - Evaluator Speech",'rsvpmaker-for-toastmasters'),



	"Writing a Speech with Purpose" => __("Writing a Speech with Purpose",'rsvpmaker-for-toastmasters'),



	"Introduction to Vocal Variety and Body Language" => __("Introduction to Vocal Variety and Body Language",'rsvpmaker-for-toastmasters'),



	"Introduction to Vocal Variety and Body Language - Emphasis on Vocal Variety" => __("Introduction to Vocal Variety and Body Language - Emphasis on Vocal Variety",'rsvpmaker-for-toastmasters'),



	"Researching and Presenting" => __("Researching and Presenting",'rsvpmaker-for-toastmasters'),



	"Understanding Your Leadership Style" => __("Understanding Your Leadership Style",'rsvpmaker-for-toastmasters'),



	"Understanding Your Communication Style" => __("Understanding Your Communication Style",'rsvpmaker-for-toastmasters'),



	"Introduction to Toastmasters Mentoring" => __("Introduction to Toastmasters Mentoring",'rsvpmaker-for-toastmasters'),



	"Negotiate the Best Outcome" => __("Negotiate the Best Outcome",'rsvpmaker-for-toastmasters'),



	"Active Listening" => __("Active Listening",'rsvpmaker-for-toastmasters'),



	"Connect with Storytelling" => __("Connect with Storytelling",'rsvpmaker-for-toastmasters'),



	"Connect with Your Audience" => __("Connect with Your Audience",'rsvpmaker-for-toastmasters'),



	"Creating Effective Visual Aids" => __("Creating Effective Visual Aids",'rsvpmaker-for-toastmasters'),



	"Deliver Social Speeches - First Speech" => __("Deliver Social Speeches - First Speech",'rsvpmaker-for-toastmasters'),



	"Deliver Social Speeches - Second Speech" => __("Deliver Social Speeches - Second Speech",'rsvpmaker-for-toastmasters'),



	"Effective Body Language" => __("Effective Body Language",'rsvpmaker-for-toastmasters'),



	"Focus on the Positive" => __("Focus on the Positive",'rsvpmaker-for-toastmasters'),



	"Inspire Your Audience" => __("Inspire Your Audience",'rsvpmaker-for-toastmasters'),



	"Know Your Sense of Humor" => __("Know Your Sense of Humor",'rsvpmaker-for-toastmasters'),



	"Make Connections Through Networking" => __("Make Connections Through Networking",'rsvpmaker-for-toastmasters'),



	"Prepare for an Interview" => __("Prepare for an Interview",'rsvpmaker-for-toastmasters'),



	"Using Descriptive Language" => __("Using Descriptive Language",'rsvpmaker-for-toastmasters'),



	"Using Presentation Software" => __("Using Presentation Software",'rsvpmaker-for-toastmasters'),



	"Understanding Vocal Variety" => __("Understanding Vocal Variety",'rsvpmaker-for-toastmasters'),



	"Manage Change" => __("Manage Change",'rsvpmaker-for-toastmasters'),



	"Building a Social Media Presence" => __("Building a Social Media Presence",'rsvpmaker-for-toastmasters'),



	"Create a Podcast" => __("Create a Podcast",'rsvpmaker-for-toastmasters'),



	"Manage Online Meetings" => __("Manage Online Meetings",'rsvpmaker-for-toastmasters'),



	"Managing a Difficult Audience" => __("Managing a Difficult Audience",'rsvpmaker-for-toastmasters'),



	"Manage Projects Successfully - First Speech" => __("Manage Projects Successfully - First Speech",'rsvpmaker-for-toastmasters'),



	"Manage Projects Successfully - Second Speech" => __("Manage Projects Successfully - Second Speech",'rsvpmaker-for-toastmasters'),



	"Public Relations Strategies" => __("Public Relations Strategies",'rsvpmaker-for-toastmasters'),



	"Question-and-Answer Session" => __("Question-and-Answer Session",'rsvpmaker-for-toastmasters'),



	"Write a Compelling Blog" => __("Write a Compelling Blog",'rsvpmaker-for-toastmasters'),



	"Lead in Any Situation" => __("Lead in Any Situation",'rsvpmaker-for-toastmasters'),



	"Reflect on Your Path" => __("Reflect on Your Path",'rsvpmaker-for-toastmasters'),



	"Ethical Leadership" => __("Ethical Leadership",'rsvpmaker-for-toastmasters'),



	"High Performance Leadership - First Speech" => __("High Performance Leadership - First Speech",'rsvpmaker-for-toastmasters'),



	"High Performance Leadership - Second Speech" => __("High Performance Leadership - Second Speech",'rsvpmaker-for-toastmasters'),



	"Leading in Your Volunteer Organization" => __("Leading in Your Volunteer Organization",'rsvpmaker-for-toastmasters'),



	"Lessons Learned" => __("Lessons Learned",'rsvpmaker-for-toastmasters'),



	"Moderate a Panel Discussion" => __("Moderate a Panel Discussion",'rsvpmaker-for-toastmasters'),



	"Prepare to Speak Professionally" => __("Prepare to Speak Professionally",'rsvpmaker-for-toastmasters'),



	"DTM Project Speech 1" => __("DTM Project Speech 1",'rsvpmaker-for-toastmasters'),



	"DTM Project Speech 2" => __("DTM Project Speech 2",'rsvpmaker-for-toastmasters'),



	"Pathways 360 Evaluation" => __("Pathways 360 Evaluation",'rsvpmaker-for-toastmasters'),



	"Reaching Consensus - Assignment Option 1" => __("Reaching Consensus - Assignment Option 1",'rsvpmaker-for-toastmasters'),



	"Reaching Consensus - Assignment Option 2" => __("Reaching Consensus - Assignment Option 2",'rsvpmaker-for-toastmasters'),



	"Improvement Through Positive Coaching" => __("Improvement Through Positive Coaching",'rsvpmaker-for-toastmasters'),



	"Engage Your Audience with Humor" => __("Engage Your Audience with Humor",'rsvpmaker-for-toastmasters'),



	"The Power of Humor in an Impromptu Speech" => __("The Power of Humor in an Impromptu Speech",'rsvpmaker-for-toastmasters'),



	"Deliver Your Message With Humor" => __("Deliver Your Message With Humor",'rsvpmaker-for-toastmasters'),



	"Present a Proposal" => __("Present a Proposal",'rsvpmaker-for-toastmasters'),



	"Managing Time" => __("Managing Time",'rsvpmaker-for-toastmasters'),



	"Planning and Implementing" => __("Planning and Implementing",'rsvpmaker-for-toastmasters'),



	"Leading Your Team" => __("Leading Your Team",'rsvpmaker-for-toastmasters'),



	"Manage Successful Events" => __("Manage Successful Events",'rsvpmaker-for-toastmasters'),



	"Understanding Emotional Intelligence" => __("Understanding Emotional Intelligence",'rsvpmaker-for-toastmasters'),



	"Motivate Others" => __("Motivate Others",'rsvpmaker-for-toastmasters'),



	"Team Building" => __("Team Building",'rsvpmaker-for-toastmasters'),



	"Understanding Conflict Resolution" => __("Understanding Conflict Resolution",'rsvpmaker-for-toastmasters'),



	"Leading in Difficult Situations" => __("Leading in Difficult Situations",'rsvpmaker-for-toastmasters'),



	"Persuasive Speaking" => __("Persuasive Speaking",'rsvpmaker-for-toastmasters'),



	"Cross-Cultural Understanding" => __("Cross-Cultural Understanding",'rsvpmaker-for-toastmasters'),



	"Successful Collaboration" => __("Successful Collaboration",'rsvpmaker-for-toastmasters'),



	"Develop a Communication Plan" => __("Develop a Communication Plan",'rsvpmaker-for-toastmasters'),



	"Communicate Change" => __("Communicate Change",'rsvpmaker-for-toastmasters'),



	"Develop Your Vision - First Speech" => __("Develop Your Vision - First Speech",'rsvpmaker-for-toastmasters'),



	"Develop Your Vision - Second Speech" => __("Develop Your Vision - Second Speech",'rsvpmaker-for-toastmasters'),



	);



	$combined = array_merge($translations,$terms);



	$missed = [];



	$translated = [];



	$localsize = sizeof($localtranslations);



	if($localsize) {



		foreach($localtranslations as $key => $value) {



			if((empty($combined[$key]) || $combined[$key] == $key)) {



				$combined[$key] = $localtranslations[$key];



			}



		}



	}



	foreach($combined as $key => $value) {



		if($value == $key) {



			$missed[] = $key;



		}



		else



			$translated[$key] = $value;



	}



	$t = array('translations'=>$translated,'missed'=>$missed);



	if(isset($_GET['wp'])) {



		$wptrans = [];



		foreach($missed as $miss) {



			$try = __($miss,'wordpress');



			if($try != $miss) {



				$wptrans[$miss] = $try;



			}



		}



		$t['wp'] = $wptrans;



	}

	return $t;
}



		$agendadata['agendas'] = wpt_get_mobile_agendadata($current_user->ID);
		$agendadata['projects'] = wp4t_program();
		$trans = wpt_mobile_translations();
		$agendadata['translations'] = ($trans && !empty($trans['translations'])) ? $trans['translations'] : array();
		$agendadata['missedTranslation'] = ($trans && !empty($trans['missed'])) ? $trans['missed'] : array();
		$agendadata['userblogs'] = wpt_domains_of_mobile_user($current_user->ID);
