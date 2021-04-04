<?php
function refresh_tm_history () {
	$histories = tm_get_histories();
	update_option('tm_histories',$histories);
}
add_action('refresh_tm_history','refresh_tm_history');

function awe_user_dropdown ($role, $assigned = 0, $settings = false, $openlabel = 'Open') {

if(rsvpmaker_is_template())

	return 'Member dropdown will appear here';

global $wpdb;

global $sortmember;

global $fnamesort;

global $histories;

global $post;

if (! wp_next_scheduled ( 'refresh_tm_history' )) {
	wp_schedule_event( rsvpmaker_strtotime('tomorrow 02:00'), 'daily', 'refresh_tm_history' );
}

if(empty($histories))
	$histories = get_option('tm_histories');
if(empty($histories)) {
	$histories = tm_get_histories();
	update_option('tm_histories',$histories);
}

$options = '<option value="0">'.$openlabel.'</option>';

if(!empty($assigned) && !is_numeric($assigned) )

	{
	$options .= sprintf('<option value="" selected="selected">%s</option>', __('Guest','rsvpmaker-for-toastmasters'));
	}

$blogusers = get_users('blog_id='.get_current_blog_id() );

    foreach ($blogusers as $user) {

		$member = get_userdata($user->ID);

		$findex = preg_replace('/[^a-zA-Z]/','',$member->first_name.$member->last_name.$member->user_login);

		$fnamesort[$findex] = $member;

	}	

	

	$member = new stdClass();

	$member->ID = -1;

	$member->last_name = __("Available",'rsvpmaker-for-toastmasters');

	$member->first_name = __("Not",'rsvpmaker-for-toastmasters');

	$member->display_name = __("Not Available",'rsvpmaker-for-toastmasters');

	$member->user_login = 'not_available';

	

	$fnamesort["AAA"] = $sortmember["AAA"] = $member;



	$member = new stdClass();

	$member->ID = -2;

	$member->last_name = __("Announced",'rsvpmaker-for-toastmasters');

	$member->first_name = __("To Be",'rsvpmaker-for-toastmasters');

	$member->display_name = __("To Be Announced",'rsvpmaker-for-toastmasters');

	$member->user_login = 'tobe';

	

	$fnamesort["AAB"] = $sortmember["AAB"] = $member;



	$member = new stdClass();

	$reserved_role_label = get_option('wpt_reserved_role_label');

	if(empty($reserved_role_label))

		$reserved_role_label = 'Ask VPE';

	$member->ID = -3;

	$member->last_name = __($reserved_role_label,'rsvpmaker-for-toastmasters');

	$member->first_name = __("Reserved",'rsvpmaker-for-toastmasters');

	$member->display_name = __("Reserved",'rsvpmaker-for-toastmasters').' '.$reserved_role_label;

	$member->user_login = 'tobe';

	

	$fnamesort["AAC"] = $sortmember["AAC"] = $member;



	ksort($fnamesort);



	foreach($fnamesort as $fnindex => $member)

		{

			if($member->ID == $assigned)

				$s = ' selected="selected" ';

			else

				$s = '';

			$status = __('Last did: ?','rsvpmaker-for_toastmasters');

			if(($member->ID > 0) && (!empty($histories[$member->ID])))

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

				$status = __('Last did','rsvpmaker-for_toastmasters').": " .$held;				

			}

			if(!empty($status)) $status = '('.$status.')';

			if(empty($member->first_name))

				$member->first_name = $member->display_name;

			$options .= sprintf('<option %s value="%d">%s</option>',$s, $member->ID,$member->first_name.' '.$member->last_name );

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

	

	$options = apply_filters('awe_dropdown_options',$options);



if($settings)

	return '<select name="'.$role.'" id="'.$role.'_select">'.$options.'</select>';

elseif(isset($_GET['recommend_roles']))

	return '<select name="editor_suggest['.$role.']" id="editor_suggest'.$role.'" class="editor_suggest" >'.$options.'</select>';

elseif(is_edit_roles())

	return "\n\n".'<input type="checkbox" class="recommend_instead" name="recommend_instead'.$role.'" id="recommend_instead'.$role.'" class="editor_assign" post_id="'.$post->ID.'" value="_rm'.$role.'" /> '.__('Recommend instead of assign','rsvpmaker-for-toastmasters').'<br /><select name="editor_assign['.$role.']" id="editor_assign'.$role.'" class="editor_assign"  post_id="'.$post->ID.'">'.$options.'</select><span id="_rm'.$role.'"></span>';

else

	return "\n\n".'<select name="editor_assign['.$role.']" id="'.$post->ID.'_editor_assign'.$role.'" class="editor_assign" post_id="'.$post->ID.'" role="'.$role.'">'.$options.'</select>';

}



function awe_assign_dropdown ($role, $random_assigned) {

return awe_user_dropdown ($role, $random_assigned,false,'Open');

}

function clean_role($role) {
	$role = preg_replace('/[0-9]/','',$role);
	$role = str_replace('_',' ',$role);
	return trim($role);
}

function future_toastmaster_meetings ($limit = 10, $buffer=4) {

	return get_future_events ($where = "(post_content LIKE '%[toastmaster%' OR post_content LIKE '%wp:wp4toastmasters%')", $limit, OBJECT, $buffer);

}



function past_toastmaster_meetings ($limit = 10000, $buffer=0) {

	return get_past_events ($where = "(post_content LIKE '%[toastmaster%' OR post_content LIKE '%wp:wp4toastmasters%')", $limit, OBJECT, $buffer);

}



function next_toastmaster_meeting () {

return get_next_rsvpmaker(" (post_content LIKE '%[toastmaster%' OR post_content LIKE '%wp:wp4toastmasters%') ");

}



function get_club_members ($blog_id = 0) {

	if(empty($blog_id))

		$blog_id = get_current_blog_id();

	return get_users(array('blog_id' => $blog_id,'orderby' => 'display_name') );

}



function get_club_member_emails ($blog_id = 0) {

	if(empty($blog_id))

		$blog_id = get_current_blog_id();

	$members = get_users(array('blog_id' => $blog_id,'orderby' => 'display_name') );

	$emails = array();

	foreach($members as $member) {

		$emails[] = strtolower($member->user_email);

	}

	return $emails;

}



function is_officer() {

	global $current_user;

	$officer_ids = get_option('wp4toastmasters_officer_ids');

	return (is_array($officer_ids) && in_array($current_user->ID,$officer_ids));

}

function wpt_multiple_blocks_same( $post_id, $post_after, $post_before ) {
	static $newcontent;
	if(!empty($newcontent)) // prevent running more than once
		return;
	$content = $post_after->post_content;
	$newcontent = '';
	$do_update = false;

	$newcontent = '';
	if(strpos($content,'wp:wp4toastmasters/role')) {
		$lines = explode("\n",$content);
		foreach ($lines as $line) {
			preg_match('/{"role":[^}]+}/',$line,$match);
			if(!empty($match[0])) {
				$atts = json_decode($match[0]);
				if(empty($atts->count))
					$atts->count = 1;
				$atts->start = (empty($next_start[$atts->role])) ? 1 : $next_start[$atts->role];
				$next_start[$atts->role] = $atts->start + $atts->count;
				$line = preg_replace('/{"role":[^}]+}/',json_encode($atts),$line);
			}
			elseif(strpos($line,'"uid":"')) {
				$pattern = '/{.+}/';
				preg_match($pattern,$line,$match);
				if(!empty($match[0])) {
					$atts = (array) json_decode($match[0]);
					if(in_array($atts['uid'],$uids))
						{
							$atts['uid'] = 'note'.rand();
							$line = preg_replace('/{.+}/',json_encode($atts),$line);
						}
					$uids[] = $atts['uid'];
				}
			}
			$newcontent .= $line . "\n";
		}
		$post_array = array("ID" => $post_id, "post_content" => $newcontent);
		wp_update_post($post_array);	
	}
}

add_action( 'post_updated', 'wpt_multiple_blocks_same', 10, 3 );



function get_role_assignments($post_id, $atts) {

	$role = $atts["role"];

	$start = (empty($atts["start"])) ? 1 : $atts["start"];



	$field_base = preg_replace('/[^a-zA-Z0-9]/','_',$atts["role"]);	

	$count = (int) (isset($atts["count"])) ? $atts["count"] : 1;

	if($atts["role"] == 'Speaker')

		pack_speakers($count);

	elseif($count > 1)

		pack_roles($count,$field_base);

	for($i = $start; $i < ($count + $start); $i++)

		{

		$field = '_' . $field_base . '_' . $i;

		$assigned = get_post_meta($post_id, $field, true);

		$name = get_member_name($assigned);

		$assignments[$field] = array('role' => $atts['role'],'assigned' => $assigned, 'name' => $name, 'iteration' => $i);

		}

	if(!empty($atts['backup']))

		{

			$field = '_'.preg_replace('/[^a-zA-Z0-9]/','_','Backup '.$atts["role"]).'_1';	

			$assigned = get_post_meta($post_id, $field, true);

			$name = get_member_name($assigned);

			$assignments[$field] = array('role' => __('Backup','rsvpmaker-for-toastmasters').' '.$atts['role'],'assigned' => $assigned, 'name' => $name, 'iteration' => 1);

		}



	return $assignments;

}



function get_member_name($user_id, $credentials = true) {

	if(!empty($user_id) && !is_numeric($user_id))

		return $user_id.' ('.__('guest','rsvpmaker-for-toastmasters').')'; // guest ?

	elseif(empty($user_id))

		return 'Open';

	elseif($user_id == -1)

		return 'Not Available';

	elseif($user_id == -2)

		return 'To Be Announced';

	elseif($user_id == -3) {

		$reserved_role_label = get_option('wpt_reserved_role_label');

		if(empty($reserved_role_label))

			$reserved_role_label = 'Ask VPE';

		return 'Reserved ' . $reserved_role_label;	

	}

	if(is_numeric($user_id)) {

		$member = get_userdata($user_id);

		if(empty($member))

			return __('Member not found','rsvpmaker-for-toastmasters');

		if(empty($member->first_name) && empty($member->last_name))
			{
				if(empty($member->display_name))
					$name = $member->user_login;
				else
					$name = $member->display_name;
			}
		else

			$name = $member->first_name.' '.$member->last_name;

		if($credentials && !empty($member->education_awards))

			$name .= ', '.$member->education_awards;	

	}

	else

		$name = $user_id.' ('.__('guest','rsvpmaker-for-toastmasters').')';

	$name = strip_tags($name);

	return $name;

}



function is_wp4t($content = '') {

	global $post;

	if(!empty($post) && empty($content))

	{

		$content = $post->post_content;

	}

	if(strpos($content,'wp4t_evaluations_demo2020'))

		return true;

	

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

		$count = (empty($item['count'])) ? 1 : (int) $item['count'];

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



function wpt_blocks_to_data($content, $include_backup = true, $aggregate = false) {

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

				if(!$aggregate)

				$key .= (empty($thisdata['start'])) ? 1 : $thisdata['start'];

			}

			elseif(!empty($thisdata['uid']))

				$key = $thisdata['uid'];

			else

				$key = 'other'.$index;

			$data[$key] = $thisdata;

			}



			if(!empty($thisdata['backup']) && $include_backup)

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



function wpt_blocks_to_data2($content, $include_backup = true, $aggregate = false) {

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

			$data[] = $thisdata;				

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

				if(!$aggregate)

				$key .= (empty($thisdata['start'])) ? 1 : $thisdata['start'];

			}

			elseif(!empty($thisdata['uid']))

				$key = $thisdata['uid'];

			else

				$key = 'other'.$index;

			$data[] = $thisdata;

			}



			if(!empty($thisdata['backup']) && $include_backup)

			{

				$key = $backup['role'] = 'Backup '.$thisdata['role'];

				$backup['count'] = 1;

				$data[] = $backup;

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

$role = str_replace('Contest_Speaker','Speaker',$role);

// Contest Speaker = Speaker

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



//do_action( 'add_user_to_blog', $user_id, $role, $blog_id );

add_action('add_user_to_blog','add_joined_club_date');



function add_joined_club_date($user_id) {

	update_user_meta($user_id,'joined'.get_current_blog_id(),date('n/j/Y'));

}



function is_agenda_locked () {

	global $post;

	if(is_admin()) // do not apply to the history screen

		return false;

	$locked = false;

	$date = get_rsvp_date($post->ID);

	$policy_lock = get_option('wpt_agenda_lock_policy');

	if($policy_lock)

	{

	$now = time();

	$string = $date.' -'.$policy_lock.' hours';

	$deadline = rsvpmaker_strtotime($string);

	if($now > $deadline)

		$locked = true;

	}

	if(isset($_GET['lock']))

		{

		$post_lock = $_GET['lock'];

		update_post_meta($post->ID,'agenda_lock',$post_lock);

		}

	else

		$post_lock = get_post_meta($post->ID,'agenda_lock',true);

	if($post_lock == 'unlockall')

		$locked = false;

	elseif(($post_lock == 'unlockadmin') && current_user_can('manage_options') )

		$locked = false;

	elseif($post_lock == 'lockexceptadmin') {

		if(current_user_can('manage_options') )

			$locked = false;

		else

			$locked = true;

	} 

	elseif($post_lock == 'on')

		$locked = true;

	return $locked;

}

function get_agenda_timing($post_id) {

	global $rsvp_options;

	$time_format = str_replace('%Z','',$rsvp_options['time_format']);

	$post = get_post($post_id);

	$date = get_rsvp_date($post_id);

	$data = wpt_blocks_to_data($post->post_content, false);

	$elapsed = 0;

	$time_array = array();

	foreach($data as $d) {

		$t = strtotime($date.' +'.$elapsed.' minutes');

		$start_time_text = strftime($time_format,$t);

		$start_time = $elapsed;

		$time_allowed = (empty($d['time_allowed'])) ? 0 : (int) $d['time_allowed'];

		$padding_time = (empty($d['padding_time'])) ? 0 : (int) $d['padding_time'];

		$add = $time_allowed + $padding_time;

		$elapsed += $add;

		if(!empty($d['role']))

			{

				$start = (empty($d['start'])) ? 1 : $d['start'];

				$index = str_replace(' ','_',$d['role']).$start;

				$label = $d['role'];

			}

		elseif(!empty($d['uid']))

			{

			$index = $d['uid'];

			$label = (empty($d['content'])) ? $index : 'Note: '.substr(trim(strip_tags($d['content'])),0,15).'...';

			}

		else

			continue;

		$time_array[$index] = array('label' => $label, 'start_time' => $start_time, 'elapsed' => $elapsed, 'time_allowed' => $time_allowed, 'padding_time' => $padding_time);

	}

	return $time_array;

}



function is_edit_roles() {

	if(isset($_GET['edit_roles']))

		return true;

	if(isset($_GET['page']) && ($_GET['page'] == 'toastmasters_reconcile'))

		return true;

	return false;

}



add_filter('wp_nav_menu', 'wp_nav_menu_wpt', 10, 2);



function wp_nav_menu_wpt($menu_html,$menu_args) {

    if(strpos($menu_html,'#rolesignup') || strpos($menu_html,'#tmlogin'))

    {

        $evlist = '';

        $future = future_toastmaster_meetings(5);

        if($future) {

            $event = $future[0];

            $evlist = sprintf('<li class="menu-item menu-item-type-post_type menu-item-object-rsvpmaker menu-item-%d menu-item-has-children" ><a href="%s">%s</a><ul class="sub-menu">',$event->ID,wpt_login_permalink($event->ID),__('Role Signup','rsvpmaker-for-toastmasters'));

            if(!empty($future))

            foreach($future as $event) {

                $evlist .= sprintf('<li class="menu-item menu-item-type-post_type menu-item-object-rsvpmaker menu-item-%d"><a href="%s">%s</a></li>',$event->ID,wpt_login_permalink($event->ID),$event->date);

			}

			$evlist .= sprintf('<li class="menu-item menu-item-type-post_type menu-item-object-rsvpmaker"><a href="%s">%s</a></li>',site_url('rsvpmaker/'),__('Future Dates','rsvpmaker-for-toastmasters'));

            $evlist .= '</ul></li>';   

        }

	}

    if(strpos($menu_html,'#rolesignup'))

	{

		$menu_html = preg_replace('/<li [^>]+><a[^"]+"#rolesignup[^<]+<\/a><\/li>/',$evlist,$menu_html);

    }

	if(strpos($menu_html,'#tmlogin'))

	{

		add_option('wpt_login_menu_item',true);

		$label = (is_user_logged_in()) ? __('Dashboard','rsvpmaker-for-toastmasters') : __('Login','rsvpmaker-for-toastmasters');

		$toplink = (is_user_logged_in()) ? admin_url('/') : wpt_login_permalink();

		$menu = '<li id="menu-item-wpt-login" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-wpt-login"><a href="'.$toplink.'">'.$label.'</a><ul class="sub-menu">

		'.$evlist.'<li id="menu-item-profile" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2862"><a href="'.admin_url('profile.php').'">Profile</a></li>

			<li id="menu-item-profilephoto" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2865"><a href="'.admin_url('profile.php#profilephoto').'">Profile Photo</a></li>

			<li id="menu-item-password" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2863"><a href="'.admin_url('profile.php#password').'">Password</a></li>

		</ul>

		</li>';

		$menu_html = preg_replace('/<li [^>]+><a[^"]+"#tmlogin[^<]+<\/a><\/li>/',$menu,$menu_html);

    }

    return $menu_html;

}



function wpt_login_permalink ($id = 0, $permalink = '') {

	global $post;

	if(empty($id))

		$id = $post->ID;

	if(empty($permalink))

    	$permalink = get_permalink($id);

    if(!is_user_logged_in())

        $permalink = wp_login_url($permalink);

    return $permalink;

}



function wpt_get_last_login($user_id) {

	global $rsvp_options;

	$slug = (is_plugin_active( 'wordfence/wordfence.php' )) ? 'wfls-last-login' : 'wpt-last-login';

	$last = get_user_meta($user_id,$slug,true);

	return rsvpmaker_strftime($rsvp_options['long_date'].' '.rsvp_options['time_format'],$last);

}



function wpt_set_last_login($user_id) {

	if(is_plugin_active( 'wordfence/wordfence.php' ))

		return; // don't duplicate function

	update_post_meta($user_id,'wpt-last-login',time());

}



function is_tm_officer($user_id = 0) {

	global $current_user;

	if(!$user_id)

		$user_id = $current_user->ID;

	$officers = get_option('wp4toastmasters_officer_ids');

	if(empty($officers))

		return false;

	return !empty($officers[$user_id]);

}



add_shortcode('time_planner_2020','time_planner_2020');



function time_planner_minutes_select($index,$minutes) {

	$output = sprintf('<select class="timeadjust" id="timeadjust%d" counter="%d">',$index,$index);

	for($i = 0; $i < 61; $i++) {

		$s = ($i == $minutes) ? ' selected="selected" ' : '';

		$output .= sprintf('<option %s value="%s">%s</option>',$s,$i,$i);

	}

}

function time_planner_2020 ($atts) {

	global $post, $rsvp_options;

	$t = strtotime(get_rsvp_date($post->ID));

	$output = sprintf('<h3>Start at %s</h3>',date('H:i',$t));

	$addminutes = 0;

	$data = wpt_blocks_to_data2($post->post_content);

	foreach($data as $index => $row) {

		if(!empty($row['role'])){

			$output .= sprintf('<h3>%s %s</h3>',date('H:i',$t),$row['role']);

			$padding = (empty($row['padding_time'])) ? '' : " (including ".$row['padding_time']." minutes padding time)";

			$roleminutes = (int) $row['padding_time'] + (int) $row['time_allowed'];

			$output .= sprintf('<p>%s minutes %s</p>',$roleminutes,$padding);

			$t += ($roleminutes * 60);

		}

		elseif(!empty($row['time_allowed'])) {

			$output .= sprintf('<h3>%s %s</h3>',date('H:i',$t),$row['content']);

			$noteminutes = (int) $row['time_allowed'];

			$t += $noteminutes;

			$t += ($noteminutes * 60);

			$output .= sprintf('<p>%s minutes</p>',$noteminutes);

		}

	}

	$output .= sprintf('<h3>%s Done</h3>',date('H:i',$t));

	$output .=  '<pre>'.var_export($data,true).'</pre>';

	return $output;

}

function get_update_role_nonce() {

	global $tm_update_role_nonce;

	if($tm_update_role_nonce)

		return $tm_update_role_nonce;

	$tm_update_role_nonce = wp_create_nonce('tm_update_role');

	return $tm_update_role_nonce;

}