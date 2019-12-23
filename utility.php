<?php

function awe_user_dropdown ($role, $assigned = 0, $settings = false, $openlabel = 'Open') {

if(rsvpmaker_is_template())
	return 'Member dropdown will appear here';
	
global $wpdb;
global $sortmember;
global $fnamesort;
global $histories;
global $post;
if(empty($histories))
	$histories = tm_get_histories();

$options = '<option value="0">'.$openlabel.'</option>';

if(!empty($assigned) && !is_numeric($assigned) )
	{
	$options .= sprintf('<option value="" selected="selected">%s</option>', __('Guest','rsvpmaker-for-toastmasters'));
	}

$blogusers = get_users('blog_id='.get_current_blog_id() );
    foreach ($blogusers as $user) {		

		$member = get_userdata($user->ID);
		if($member->hidden_profile)
			continue;
		$index = preg_replace('/[^a-zA-Z]/','',$member->last_name.$member->first_name.$member->user_login);
		$findex = preg_replace('/[^a-zA-Z]/','',$member->first_name.$member->last_name.$member->user_login);
		$sortmember[$index] = $member;
		$fnamesort[$findex] = $member;
	}	
	
	$member = new stdClass();
	$member->ID = -1;
	$member->last_name = __("Available",'rsvpmaker-for-toastmasters');
	$member->first_name = __("Not",'rsvpmaker-for-toastmasters');
	$member->display_name = __("Not Available",'rsvpmaker-for-toastmasters');
	$member->user_login = 'not_available';
	
	$fnamesort["AAA"] = $sortmember["AAA"] = $member;

	ksort($sortmember);
	ksort($fnamesort);

	$options .= '<optgroup label="First Name Sort">';

	foreach($fnamesort as $fnindex => $member)
		{
			if($member->ID == $assigned)
				$s = ' selected="selected" ';
			else
				$s = '';
			$status = '';
			if($member->ID > 0)
			{
			$held = $histories[$member->ID]->get_last_held($role);
			if(!empty($histories[$member->ID]->away_active))
			{
				$status_msg = wp4t_get_member_status($member->ID);
				if(empty($status_msg))
					$status_msg = 'Planned Absence';
				$status = 'Away  '.$status_msg;
			}
			elseif(!empty($held))	
				$status = __('Last did role','rsvpmaker-for_toastmasters').": " .$held;				
			}
			if(!empty($status)) $status = '('.$status.')';
			if(empty($member->first_name))
				$member->first_name = $member->display_name;
			$options .= sprintf('<option %s value="%d">%s %s</option>',$s, $member->ID,$member->first_name.' '.$member->last_name, $status );
		
		if(!empty($role))
		{
		if(empty($held))
			$fnindex = '0000-00-00'.$fnindex;
		else
			$fnindex = date('Y-m-d',strtotime($held)).$fnindex;
		if($member->ID > 0)//filter out Not Available
		$heldsort[$fnindex] = sprintf('<option value="%d">%s %s</option>', $member->ID,$member->first_name.' '.$member->last_name, $status );			
		}
		
		}

	$options .= "</optgroup>";
	$options .='<option value="0">'.$openlabel.'</option>';

	$options .= '<optgroup label="Last Name Sort">';
	foreach($sortmember as $member)
		{
			$status = '';
			if($member->ID > 0)
			{
			$held = $histories[$member->ID]->get_last_held($role);
			if(!empty($histories[$member->ID]->away_active))
				$status = 'Away  '.wp4t_get_member_status($member->ID);
			elseif(!empty($held))	
				$status = __('Last did role','rsvpmaker-for_toastmasters').": " .$held;				
			}
			if(!empty($status)) $status = '('.$status.')';
			$options .= sprintf('<option value="%d">%s %s</option>', $member->ID,$member->first_name.' '.$member->last_name, $status );
		}
	$options .= "</optgroup>";
	if(!empty($role))
	{
	ksort($heldsort);
	$options .='<option value="0">'.$openlabel.'</option>';
	$options .= '<optgroup label="Last Did Role">';
	foreach($heldsort as $option)
	{
		$options .= $option;
	}
	$options .= '</optgroup>';		
	}
	
if($settings)
	return '<select name="'.$role.'" >'.$options.'</select>';
elseif(isset($_GET['recommend_roles']))
	return '<select name="editor_suggest['.$role.']" id="editor_suggest'.$role.'" class="editor_suggest" >'.$options.'</select>';
elseif(isset($_GET['edit_roles']))
	return "\n\n".'<input type="checkbox" class="recommend_instead" name="recommend_instead'.$role.'" id="recommend_instead'.$role.'" class="editor_assign" post_id="'.$post->ID.'" value="_rm'.$role.'" /> '.__('Recommend instead of assign','rsvpmaker-for-toastmasters').'<br /><select name="editor_assign['.$role.']" id="editor_assign'.$role.'" class="editor_assign"  post_id="'.$post->ID.'">'.$options.'</select><span id="_rm'.$role.'"></span>';
else
	return "\n\n".'<select name="editor_assign['.$role.']" id="editor_assign'.$role.$post->ID.'" class="editor_assign" post_id="'.$post->ID.'" role="'.$role.'">'.$options.'</select>';
}

function awe_assign_dropdown ($role, $random_assigned) {
return awe_user_dropdown ($role, $random_assigned,false,'Open');
}

function clean_role($role) {
$role = str_replace('_1','',$role);
$role = str_replace('_',' ',$role);
return trim($role);
}

function future_toastmaster_meetings ($limit = 10, $buffer=4) {
	$datewhere = ($buffer) ? sprintf('DATE_SUB(NOW(),INTERVAL %d HOUR)',$buffer) : 'NOW()';
global $wpdb;
$wpdb->show_errors();
	$sql = "SELECT DISTINCT $wpdb->posts.ID as postID, $wpdb->posts.*, a1.meta_value as datetime, a1.meta_value as datetime, date_format(a1.meta_value,'%M %e, %Y') as date
	 FROM ".$wpdb->posts."
	 JOIN ".$wpdb->postmeta." a1 ON ".$wpdb->posts.".ID =a1.post_id AND a1.meta_key='_rsvp_dates'
	 WHERE a1.meta_value > ".$datewhere." AND post_status='publish' AND (post_content LIKE '%[toastmaster%' OR post_content LIKE '%wp:wp4toastmasters%') ";
	$sql .= ' ORDER BY a1.meta_value ';
	 if( !empty($limit) )
		$sql .= ' LIMIT 0,'.$limit.' ';
	$r = $wpdb->get_results($sql);
	if(!empty($_REQUEST["debug_sql"]))
		{
		echo $sql;
		print_r($r);
		}
	return $r;
}

function next_toastmaster_meeting () {
global $wpdb;
$wpdb->show_errors();
	$sql = "SELECT DISTINCT $wpdb->posts.ID as postID, $wpdb->posts.*, a1.meta_value as datetime, a1.meta_value as datetime, date_format(a1.meta_value,'%M %e, %Y') as date
	 FROM ".$wpdb->posts."
	 JOIN ".$wpdb->postmeta." a1 ON ".$wpdb->posts.".ID =a1.post_id AND a1.meta_key='_rsvp_dates'
	 WHERE a1.meta_value > NOW() AND post_status='publish' AND (post_content LIKE '%[toastmaster%' OR post_content LIKE '%wp:wp4toastmasters%') ORDER BY a1.meta_value ";
	return $wpdb->get_row($sql);
}

function get_club_members () {
	return get_users('blog_id='.get_current_blog_id() );
}

function get_member_name($user_id, $credentials = true) {
	if(!empty($user_id) && !is_numeric($user_id))
		return $user_id.' ('.__('guest','rsvpmaker-for-toastmasters').')'; // guest ?
	elseif($user_id == 0)
		return 'Open';
	elseif($user_id == -1)
		return 'Not Available';
	$member = get_userdata($user_id);
	if(empty($member->first_name) && empty($member->last_name))
		$name = $member->display_name;
	else
		$name = $member->first_name.' '.$member->last_name;
	if($credentials && !empty($member->education_awards))
		$name .= ', <span class="education_awards">'.$member->education_awards.'</span>';
	return $name;
}

function is_wp4t($content = '') {
	global $post;
	if(!empty($post) && empty($content))
	{
		$content = $post->post_content;
	}
	
	if((strpos($content,'[toastmaster') === false) && (strpos($content,'wp:wp4toastmasters/') === false))
		return false;
	else
		return true;
}

function tm_admin_page_top($headline) {

/*
$hook = tm_admin_page_top(__('Headline','rsvpmaker-for-toastmasters'));
tm_admin_page_bottom($hook);
*/
$hook = '';
if(is_admin()) { // if not full screen view
	$screen = get_current_screen();
	$hook = $screen->id;
}

$print = (isset($_REQUEST["page"]) && !isset($_REQUEST["rsvp_print"])) ? '<div style="width: 200px; text-align: right; float: right;"><a target="_blank" href="'.admin_url(str_replace('/wp-admin/','',$_SERVER['REQUEST_URI'])).'&rsvp_print=1">Print</a></div>' : '';
printf('<div id="wrap" class="%s toastmasters">%s<h1>%s</h1>',$hook,$print,$headline);
return $hook;
}

function tm_admin_page_bottom($hook = '') {
if(is_admin() && empty($hook))
	{
	$screen = get_current_screen();
	$hook = $screen->id;
	}
printf("\n".'<hr /><p><small>%s</small></p></div>',$hook);
}

function wpt_get_member_emails () {
$blogusers = get_users('blog_id='.get_current_blog_id() );
foreach($blogusers as $user)
	$emails[$user->ID] = $user->user_email;
return $emails;
}

function wp4t_unassigned_emails ($post_id = 0) {
	global $post;
	if(!$post_id)
		$post_id = $post->ID;
	if(empty($post->ID))
		$post = get_post($post_id);
	$roster = '';
	$signup = get_post_custom($post_id);
	//rsvpmaker_debug_log($signup,'unassigned emails roles assigned '.$post_id);
	$data = wpt_blocks_to_data($post->post_content);
foreach($data as $item)
	{
		if(!empty($item['role']))
		{
		$role = $item['role'];
		$count = (int) $item['count'];
		for($i = 1; $i <= $count; $i++)
			{
				$field = '_'.str_replace(' ','_',$role).'_'.$i;
				$roles[$field] = $role;
			}
		}
	}
	$has_assignment = $emails = array();
	 foreach($roles as $field => $role)
		{
			$assigned = (isset($signup[$field][0])) ? $signup[$field][0] : '';
			if(!empty($assigned))
				$has_assignment[] = (int) $assigned;
		}

$absences = get_absences_array($post_id);
$has_assignment = array_merge($has_assignment,$absences);

$users = get_users('blog_id='.get_current_blog_id());	
foreach ($users as $user)
{
	if(!in_array($user->ID,$has_assignment))
		$emails[] = $user->user_email;
}
return $emails;
}

function wp4t_unassigned_ids ($post_id = 0) {
	global $post;
	if(!$post_id)
		$post_id = $post->ID;
	if(empty($post->ID))
		$post = get_post($post_id);
	$roster = '';
	$signup = get_post_custom($post_id);
	//rsvpmaker_debug_log($signup,'unassigned emails roles assigned '.$post_id);
	$data = wpt_blocks_to_data($post->post_content);
foreach($data as $item)
	{
		if(!empty($item['role']))
		{
		$role = $item['role'];
		$count = (int) $item['count'];
		for($i = 1; $i <= $count; $i++)
			{
				$field = '_'.str_replace(' ','_',$role).'_'.$i;
				$roles[$field] = $role;
			}
		}
	}
	$has_assignment = $emails = array();
	 foreach($roles as $field => $role)
		{
			$assigned = (isset($signup[$field][0])) ? $signup[$field][0] : '';
			if(!empty($assigned))
				$has_assignment[] = (int) $assigned;
		}

$absences = get_absences_array($post_id);
$has_assignment = array_merge($has_assignment,$absences);

$users = get_users('blog_id='.get_current_blog_id());	
foreach ($users as $user)
{
	if(!in_array($user->ID,$has_assignment))
		$ids[] = $user->ID;
}
return $ids;
}

function wp4_format_contact ($userdata) {
$output = '';
		if(empty($userdata->last_name) || ($userdata->last_name == "AVAILABLE"))
			return '';
		
		$output .= "\n\n".$userdata->first_name.' '.$userdata->last_name."\n";
		$status = wp4t_get_member_status($userdata->ID);
		if(!empty($status))
			$output .= $status."\n";

$contactmethods['home_phone'] = __("Home Phone",'rsvpmaker-for-toastmasters');
$contactmethods['work_phone'] = __("Work Phone",'rsvpmaker-for-toastmasters');
$contactmethods['mobile_phone'] = __("Mobile Phone",'rsvpmaker-for-toastmasters');
$contactmethods['user_email'] = __("Email",'rsvpmaker-for-toastmasters');

	foreach($contactmethods as $name => $value)
		{
		$trimmed = trim($userdata->$name);
		if(empty($trimmed))
			continue;
		if($name == 'user_email')
			$output .= sprintf('%s: <a href="mailto:%s">%s</a>'."\n",$value,$trimmed,$trimmed);
		elseif($name == 'status')
			$output .= sprintf("%s: %s\n",$value,$trimmed);
		else
			{
			$phone = preg_replace('/[^0-9\+]/','',$trimmed);
			if(strpos($phone,'+') === false)
				{
				$first_digit = substr($phone,0,1);
				if($first_digit != '1')
					$phone = '1'.$phone;
				$phone = '+'.$phone;
				}
			$output .= sprintf('%s: <a href="tel:%s">%s</a>'."\n",$value,$phone,$trimmed);
			}
		}
return $output;
}

function wp4t_emails () {
$list = '';
$blogusers = get_users('blog_id='.get_current_blog_id() );
    foreach ($blogusers as $user) {	
		$email = $user->user_email;
		if(strpos($email,'example.com') )
			continue;
		if(!empty($list))
			$list .= ',';
		$list .= $email;
	}
return $list;
}

function is_club_member() {
return apply_filters('is_club_member',is_user_member_of_blog());	
}

function wpt_blocks_to_data($content) {
	$data = array();
	if(strpos($content,'wp:wp4toast'))
	{
	$blocks = preg_split("/<!/",$content);
	foreach($blocks as $index => $block)
	{
		if(strpos($block,'agendanoterich2'))
		{
			preg_match('/{[^}]+}/',$block,$matches);
			if(!empty($matches))
			{
			$thisdata = (array) json_decode($matches[0]);
			$thisdata['content'] = trim(strip_tags('<'.$block.'>'));
			$thisdata['json'] = $matches[0];
			$key = $thisdata['uid'];
			$data[$key] = $thisdata;				
			}
		}
		else
		{
			preg_match('/{[^}]+}/',$block,$matches);
			if(!empty($matches))
			{
			$thisdata =	(array) json_decode($matches[0]);
			$thisdata['json'] = $matches[0];
			if(!empty($thisdata['role']))
			{
				$key = $thisdata['role'];
				if($key == 'custom')
					$key = $thisdata['role'] = $thisdata['custom_role'];
			}
			elseif(!empty($thisdata['uid']))
				$key = $thisdata['uid'];
			else
				$key = 'other'.$index;
			$data[$key] = $thisdata;
			}

			if(!empty($thisdata['backup']))
			{
				$key = $backup['role'] = 'Backup '.$thisdata['role'];
				$backup['count'] = 1;
				$data[$key] = $backup;
			}
		}
	}
	//printf('<pre>%s</pre>',var_export($data,true));
	return $data;
	}
	
	preg_match_all('/\[.+role="([^"]+).+\]/',$content,$matches);
	foreach($matches[1] as $index => $role)
	{
		if(strpos($role,'ackup'))
			continue;
		preg_match('/count="([\d]+)/',$matches[0][$index],$counts);
		$count = (empty($counts[1])) ? 1 : $counts[1];
		$data[$role] = array('role' => $role, 'count' => $count);
	}
return $data;
}

//project data encoding
function make_tm_speechdata_array ($roledata, $manual, $project, $title, $intro) {
	$roledata['manual'] = $manual;
	$roledata['project'] = $project;
	$roledata['title'] = $title;
	$roledata['intro'] = $intro;
	return $roledata;
}

function make_tm_roledata_array ($function = '') {
global $current_user;
	return array('time_recorded' => time(), 'recorded_by' => $current_user->user_login, 'function' => $function);
}
function make_tm_usermeta_key ($role, $event_timestamp, $post_id) {
$slug = preg_replace('/[^0-9]/','',$role);
if(isset($_GET['project_year']))
	$slug = $_GET['project_year'].$_GET['project_month'].$_GET['project_day'];
return 'tm|'.trim(preg_replace('/[^\sa-zA-Z]/',' ',$role)).'|'.$event_timestamp.'|'.$slug.'|'.$_SERVER['SERVER_NAME'].'|'.$post_id;
}

function extract_usermeta_key_data($key) {
	$parts = explode('|',$key);
	$data['role'] = $parts[1];
	$data['timestamp'] = $parts[2];
	$data['order'] = $parts[3];
	$data['domain'] = $parts[4];
	$data['post_id'] = $parts[5];
	return $data;
}

function cache_assignments ($post_id,$refresh=false) {
global $assign_cache;
if($refresh)
	$assign_cache = array();
else
	$assign_cache = get_transient('assign_cache');
if(empty($assign_cache[$post_id]))
	{
		$sql = "SELECT * FROM $wpdb->postmeta WHERE post_id=$post_id AND meta_value REGEXP '^[0-9]+$'";
		$results = $wpdb->get_results($sql);
		foreach($results as $row) {
			$assign_cache[$post_id][$row->meta_key] = $row->meta_value;
		}
	set_transient('assign_cache',$assign_cache, DAY_IN_SECONDS);
	}
}

function get_wpt_assignment($post_id,$key) {
global $assign_cache;
if(isset($assign_cache[$post_id][$key]))
	return $assign_cache[$post_id][$key];
return get_post_meta($post_id,$key,true);
}

function set_wpt_assignment($post_id,$key,$value,$update_cache = true) {
global $assign_cache;
$assign_cache[$post_id][$key] = $value;
update_post_meta($post_id,$key,$value);
if($update_cache) // unless we're told not to, update the cache transient
	set_transient('assign_cache',$assign_cache, DAY_IN_SECONDS);
}
?>