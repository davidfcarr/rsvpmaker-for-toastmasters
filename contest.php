<?php

function add_contest_userlink($user_id, $link, $post_id = 0) {
	global $post;
	if(!$post_id && isset($post->ID))
		$post_id = $post->ID;
	$contest_users = get_post_meta($post_id,'contest_user');
	if(!in_array($user_id,$contest_users))
		add_post_meta($post_id,'contest_user',$user_id);
	update_post_meta($post_id,'contest_link_'.$user_id,$link);
}

function wpt_get_contest_array ($type = 'selection') {
	$contest_selection['International Speech Contest'] = array('Speech Development' => 20,'Effectiveness' => 15,'Speech Value' => 15,'Physical' => 10,'Voice' => 10,'Manner' => 10,'Appropriateness' => 10,'Correctness' => 10);
	$contest_selection['Video Speech Contest'] = array('Speech Development' => 20,'Effectiveness' => 15,'Speech Value' => 15,'Physical' => 10,'Voice' => 10,'Manner' => 10,'Appropriateness' => 10,'Correctness' => 10);
	$contest_selection['Humorous Speech Contest'] = array('Speech Development' => 15,'Effectiveness' => 10,'Speech Value' => 15,'Audience Response' => 15,'Physical' => 10,'Voice' => 10,'Manner' => 10,'Appropriateness' => 10,'Correctness' => 5);
	$contest_selection['Table Topics Contest'] = array('Speech Development' => 30,'Effectiveness' => 25,'Physical' => 15,'Voice' => 15,'Appropriateness' => 10,'Correctness' => 5);
	$contest_selection['Evaluation Contest'] = array('Analytical Quality' => 40,'Recommendations' => 30,'Technique' => 15,'Summation' => 15);
	$contest_selection['VTM 3-5 Min Webinar Contest'] = array('Speech Development' => 15,'Audience Engagement' => 15,'Speech Value' => 15,'Call to Action' => 15,'Visual' => 15,'Voice' => 10,'Manner' => 5,'Appropriateness/Correctness' => 10);
	$contest_selection['Mini-Webinar Contest'] = array('Speech Development' => 15,'Audience Engagement' => 15,'Speech Value' => 15,'Call to Action' => 15,'Visual' => 15,'Voice' => 10,'Manner' => 5,'Appropriateness/Correctness' => 10);
	
	$contest_timing['International Speech Contest'] = '5 to 7';
	$contest_timing['Video Speech Contest'] = '5 to 7';
	$contest_timing['Humorous Speech Contest'] = '5 to 7';
	$contest_timing['Table Topics Contest'] = '1 to 2';
	$contest_timing['Evaluation Contest'] = '2 to 3';
	$contest_timing['VTM 3-5 Min Webinar Contest'] = '3 to 5';
	$contest_timing['Mini-Webinar Contest'] = '6 to 8';
	if($type == 'timing')
		return $contest_timing;
	else
		return $contest_selection;	
}

function set_contest_parameters($post_id,$contest) {
	global $current_user;
	$contest_selection = wpt_get_contest_array();
	$contest_timing = wpt_get_contest_array('timing');
	update_post_meta($post_id,'toast_contest_name',$contest);
	update_post_meta($post_id,'toast_contest_scoring',$contest_selection[$contest]);
	update_post_meta($post_id,'toast_timing',$contest_timing[$contest]);
	update_post_meta($post_id,'tm_contest_dashboard_users',array($current_user->ID));
}

function toast_contest ($mode) {
	global $post, $rsvp_options;
	$date = get_rsvp_date($post->ID);
	$contest_name = get_post_meta($post->ID,'toast_contest_name',true);
	$dashboard_name = (empty($contest_name)) ? $post->post_title : $contest_name;
	$date = strftime($rsvp_options['long_date'],strtotime($date));
	$output = '<div id="scoring">';
	$practice = get_practice_contest_links();
	$output .= wpt_mycontests_links($practice);
	if($mode == 'dashboard')
	{
		$output .= '<h1>Scoring Dashboard - '.$date.' '.$dashboard_name.'</h1>';
		$related = get_post_meta($post->ID,'_contest_related',true);
		if($related) {
			$other_contest_name = get_post_meta($related,'toast_contest_name',true);
			$otherprompt = (isset($_POST['judge']) && !empty(get_post_meta($post->ID,'tm_contest_sync',true))) ? ' - Reload '.$other_contest_name.' dashboard to see synchronized list of judges': '';
			printf('<p>Related: <a target="_blank" href="%s?scoring=dashboard">%s</a> %s</p>',get_permalink($related),$other_contest_name, $otherprompt);
		}
		$output .= toast_scoring_dashboard($related, $practice);
	}
	elseif($mode == 'voting')
	{
		$output .= '<h1>Voting - '.$date.' '.$dashboard_name.'</h1>';
		$output .= toast_scoring_sheet();	
	}
	elseif($mode == 'mycontests')
		{
		$output .= '<h1>My Contests</h1>';
		$output .= wpt_mycontests();
		}
	elseif($mode == 'shuffle')
		{
			$output .= wpt_shuffle_contestants();
		}
	else
		return "<div>Error: scoring mode not recognized</div>";
	$output .= '</div>';// close wrapper		
return $output;
}

add_shortcode('wpt_contests_prompt','wpt_contests_prompt');
function wpt_contests_prompt ($atts) {
	if(is_user_logged_in())
		return sprintf('<p>Judges/Organizers: see <a href="%s">contest links</a></p>',get_permalink().'?scoring=mycontests');
	else
		return sprintf('<p>Judges/Organizers: <a href="%s">login</a> to see assignments</p>',wp_login_url(get_permalink().'?scoring=mycontests'));	
}

function wpt_shuffle_contestants() {
	global $post;
	$contestants = get_post_meta($post->ID,'tm_scoring_contestants',true);
	$order = get_post_meta($post->ID,'tm_scoring_order',true);
	$contest_name = get_post_meta($post->ID,'toast_contest_name',true);
	if(isset($_POST['shuffle']))
	{
		$order = $contestants;
		shuffle($order);
		update_post_meta($post->ID,'tm_scoring_order',$order);
		echo '<p>Speaking order set</p>';
	}
	if(empty($order)) {
		echo '<h1>Order Not Set - '.$contest_name.'</h1>';
		sort($contestants);
		foreach($contestants as $contestant)
		{
			printf('<p>%s</p>',$contestant);
		}
		printf('<form method="post" action="%s"><button>Set Speaking Order</button><input type="hidden" name="shuffle" value="1"></form>',get_permalink($post->ID).'?scoring=shuffle');
	}
	else {
		echo '<h1>Speaker Order  - '.$contest_name.'</h1>';
		foreach($order as $index => $contestant)
		{
			printf('<p id="text%d">%s</p>',$index,$contestant);
		}
	}
}

function wpt_mycontests() {
if(!is_user_logged_in()) {
	printf('<p>You must <a href="%s">login</a> to see assignments</p>',wp_login_url(get_permalink().'?scoring=mycontests'));
	return;
}

	//if(current_user_can('manage_network')) contest_user_fix();
	global $wpdb, $current_user;
	$output = $past = '';
	$displayed = array();
	$now = time();
	$results = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key='contest_user' AND meta_value='".$current_user->ID."' ORDER BY meta_id");
	foreach($results as $row) {
			if(in_array($row->post_id,$displayed))
				continue;
			$displayed[] = $row->post_id;
			$post = get_post($row->post_id);
			if(empty($post) || ($post->post_status != 'publish'))
				continue;
			$datetime = get_rsvp_date($row->post_id);
			$t = strtotime($datetime);
		//if($_GET['debug'])
			//print_r($row);
			if(isset($_GET['debug']))
				print_r($row);
			$date = date('F j, Y',$t);
			$link = get_post_meta($row->post_id,'contest_link_'.$current_user->ID,true);
			$permalink = get_permalink($row->post_id);
			if(strpos($link,$permalink) === false)
			{
				$p = explode('?',$link);
				$link = $permalink.'?'.$p[1];
				update_post_meta($row->post_id,$row->meta_key,$link);
			}
			$label = '';
			if(strpos($link,'dashboard'))
				$label = '(dashboard)';
			if(strpos($link,'judge'))
				$label = '(judge)';
			if(strpos($link,'timer'))
				$label = '(timer)';
			$item = sprintf('<p><a href="%s">%s - %s %s</a></p>',$link,$post->post_title,$date,$label);//.$datetime;
			
			if($t < $now)
				$past .= $item;
			else
				$output .= $item;
		}
if(empty($output))
	$output = '<p>None</p>';
if(!empty($past)) 
	$output .= '<h3>Past Events</h3>'.$past;
$output = '<p>Contest links you have access to:</p>'.$output;
return $output;
}

function toast_scoring_dashboard ($related = 0, $practice = array()) {
ob_start();
global $post, $wpdb;
global $current_user;
$contest_name = get_post_meta($post->ID,'toast_contest_name',true);

if(isset($_POST['sync'])) {
	$related = (int) $_POST['related'];
	$synctype = $_POST['sync'];
	if($synctype == 'master') {
		$sync = array('copy_from' => $post->ID, 'copy_to' => $related);
	}
	elseif($synctype == 'slave') {
		$sync = array('copy_from' => $related, 'copy_to' => $post->ID);
	}
	if(empty($sync)) {
		delete_post_meta($post->ID,'tm_contest_sync');
		delete_post_meta($related,'tm_contest_sync');
	}
	else {
		update_post_meta($post->ID,'tm_contest_sync',$sync);
		update_post_meta($related,'tm_contest_sync',$sync);
	}
}
else {
	$sync = get_post_meta($post->ID,'tm_contest_sync',true);
}

if(!empty($sync)) {
	tm_contest_sync($sync);
}

if(isset($_POST['dashboardvote']))
{
	$id = $_POST['judge_id'];
	update_post_meta($post->ID,'tm_scoring_vote'.$id,$_POST['vote']);
	add_post_meta($post->ID,'dashboard_vote',$id);
	//print_r($_POST);
}
$output = '';
$votinglink = $actionlink = get_permalink($post->ID);
if(strpos($actionlink,'?'))
{
$actionlink .= '&scoring=dashboard';
$votinglink .= '&scoring=voting';	
}
else {
$actionlink .= '?scoring=dashboard';
$votinglink .= '?scoring=voting';	
}

do_action('wpt_scoring_dashboard_top');
$link = sprintf('<div id="agendalogin"><a href="%s">'.__('Login','rsvpmaker-for-toastmasters').'</a></div>',site_url().'/wp-login.php?redirect_to='.urlencode($actionlink));

$contest_selection = wpt_get_contest_array();
$contest_timing = wpt_get_contest_array('timing');

$demo = get_post_meta($post->ID,'_contest_demo',true);
if($demo)
	$output .= '<p>This page is configured as a demo, no password required.</p>';
elseif( !is_user_logged_in() )
{
	return '<p>You must be logged in as the site administrator, chief judge, or ballot counter.</p>'.$link;
}
else
{
	$dashboard_users = get_post_meta($post->ID,'tm_contest_dashboard_users',true);
	if(empty($dashboard_users))
		$dashboard_users = array();
	if(!in_array($post->post_author,$dashboard_users))
	{
		$dashboard_users[] = $post->post_author;
		update_post_meta($post->ID,'tm_contest_dashboard_users',$dashboard_users);
	}
	if(!current_user_can('edit_others_posts'))
	{
	if(!is_array($dashboard_users))
		return '<p>Logged in user not recognized as a site administrator, chief judge, or ballot counter.</p>'.wpt_mycontests();
	if(!in_array($current_user->ID,$dashboard_users))
		return '<p>Logged in user not recognized as a site administrator, chief judge, or ballot counter.</p>'.wpt_mycontests();
	}
}

$default_dashboard_users = array($current_user->ID);

if(!empty($_POST['contest_scoring2']))
{
	$scoring_index = $_POST['contest_scoring2'];
	$contest_scoring = $contest_selection[$scoring_index];
	$timing = $contest_timing[$scoring_index];
	$data['post_title'] = $scoring_index;
	$data['post_content'] = '[wpt_contests_prompt]';
	$data['post_author'] = $current_user->ID;
	$data['post_type'] = 'rsvpmaker';
	$data['post_status'] = 'publish';
	$id = wp_insert_post($data);
	if(!empty($contest_scoring))
	{
		update_post_meta($id,'toast_contest_name',$scoring_index);
		update_post_meta($id,'toast_contest_scoring',$contest_scoring);
		update_post_meta($id,'toast_timing',$timing);
		update_post_meta($id,'_rsvpmaker_special','Contest document');
		update_post_meta($id,'_contest_tracking_post',$post->ID);
		update_post_meta($id,'_contest_related',$post->ID);
		update_post_meta($id,'_rsvp_dates',get_rsvp_date($post->ID));
		update_post_meta($post->ID,'_contest_related',$id);
		update_post_meta($id,'tm_contest_dashboard_users',$default_dashboard_users);
		$track_role = $_POST['track_role2'];
		if(!empty($track_role))
			update_post_meta($id,'tm_track_role',$track_role);
		if($id) {
			$rp = get_post($id);
			printf('<p>Created related contest: <a target="_blank" href="%s?scoring=dashboard">%s</a></p>',get_permalink($id),$rp->post_title);
		}
	if(!empty($_POST['syncwith1'])) {
		$sync = array('copy_from' => $post->ID,'copy_to' => $id);
		update_post_meta($post->ID,'tm_contest_sync',$sync);
		update_post_meta($id,'tm_contest_sync',$sync);
	}

	}
}

if(!empty($_POST['contest_scoring']))
{
	$scoring_index = $_POST['contest_scoring'];
	$contest_scoring = $contest_selection[$scoring_index];
	$timing = $contest_timing[$scoring_index];
	if(!empty($contest_scoring))
	{
		update_post_meta($post->ID,'toast_contest_name',$scoring_index);
		update_post_meta($post->ID,'toast_contest_scoring',$contest_scoring);
		update_post_meta($post->ID,'toast_timing',$timing);		
		update_post_meta($post->ID,'tm_contest_dashboard_users',$default_dashboard_users);
	}
}
elseif(!empty($_POST['scoring_label'])) {
	foreach($_POST['scoring_label'] as $index => $label)
	{
	$label = stripslashes($label);
	$score = (int) $_POST['scoring_score'][$index];
	if(!empty($label) && !empty($score))
	{
		$contest_scoring[$label] = $score;
		$foropt[] = $label.':'.$score;
	}
	}
	if(!empty($contest_scoring))
	{
		$custom = get_option('toast_custom_contest');
		$newcustom = sprintf('<option value="%s">%s</option>',implode(',',$foropt),stripslashes($_POST['contest_name']));
		update_option('toast_custom_contest',$custom . $newcustom);
		update_post_meta($post->ID,'toast_contest_scoring',$contest_scoring);
		update_post_meta($post->ID,'toast_timing',$_POST['toast_timing']);
	}
}
else
$contest_scoring = get_post_meta($post->ID,'toast_contest_scoring',true);
if(empty($contest_scoring) || isset($_GET['reset_scoring']))
{
$options = '<option value="">Select Contest</option>';

foreach($contest_selection as $contest => $score_array)
{
$options .= sprintf('<option value="%s">%s</option>',$contest,$contest);
}

if(isset($_GET['clear_custom_scoring']))
	delete_option('toast_custom_contest');
else
	$options .= get_option('toast_custom_contest');
$syncrole =	track_roles_ui();
$output .= '<p>Use this dashboard to pick a contest, add your list of contestants and judges, and generate personalized links to a page where each judge can score contestants and enter their votes.</p><p>As the judges vote, you will see their votes appear on the dashboard within seconds. If you have the Timer and Tiebreaking Judge record their work online, their input can also be factored in to show if any contestants were disqualified or how any ties were broken.</p><p><a href="https://www.wp4toastmasters.com/knowledge-base/contest-setup/" target="_blank">Step-By-Step Directions</a></p>';
$output .= '<h1>Choose Contest</h1>'.sprintf('<form method="post" action="%s">
	<div>Contest:<br /><select name="contest_scoring">%s</select>
	%s
	<div>Contest #2 (optional):<br /><select name="contest_scoring2">%s</select>
	%s
	<p><input type="checkbox" name="syncwith1" value="checked" checked="checked" /> Use same list of judges and functionaries for second contest</p>
	<p><input type="radio" name="ballot_no_password" value="0"  checked="checked" /> User password required for access to ballot, timer\'s report form</p>
	<p><input type="radio" name="ballot_no_password" value="1"  /> No password. Ballots protected by coded links</p>
	<p><em>By default, a password is required for all voting forms associated with a user account. You may turn off password protection to make it easier for judges to access thier ballots, which will still be private as long as the link is only shared with the individual judges. This setting also applies to the timer\'s report. Guest judge links, created by entering a name rather than choosing a user account, are not password protected. The contest dashboard is always password protected.</em></p>
		<button>Set</button></div>
</form>
',$actionlink,$options,track_roles_ui(),$options,track_roles_ui('',2));
	
$output .= '<h1>Custom Contest</h1>'.sprintf('<form method="post" action="%s" id="custom_contest"><p>Contest Name: <input type="input" name="contest_name" value="My Custom Contest" /></p>
',$actionlink);

for($i = 1; $i < 15; $i++)
	$output .= sprintf('<div>Label: <input type="text" name="scoring_label[%d]" /> Score: <input class="setscore" type="text" name="scoring_score[%d]" /></div>',$i,$i);
$output .= '<div>Timing <input type="text" name="toast_timing" value="5 to 7" size="10"> minutes</div>';
$output .= '<div id="readyprompt"></div><button>Set</button></div>
</form>';
ob_start();
?>
<p><a href="<?php echo $actionlink; ?>&reset_scoring=1&clear_custom_scoring">Clear Custom Scoring</a></p>
<?php
$output .= ob_get_clean();
return $output;
}

if(true) { //kludge

if(!empty($_POST['copy_judges'])) {
	$copyfrom = (int) $_POST['copy_judges'];
	$judges = get_post_meta($copyfrom,'tm_scoring_judges',true);
	update_post_meta($post->ID,'tm_scoring_judges', $judges );
	update_post_meta($post->ID,'tm_scoring_tiebreaker', get_post_meta($copyfrom,'tm_scoring_tiebreaker',true) );
	update_post_meta($post->ID,'contest_timer', get_post_meta($copyfrom,'contest_timer',true) );
	foreach($judges as $index => $judge_id) {
		if(is_numeric($judge_id))
		{
			$arg = array('scoring' => 'voting','judge' => $index);
			$link = add_query_arg($arg,get_permalink());
			add_contest_userlink($judge_id,$link,$post->ID);
		}
	}
}

if(isset($_POST['track_role']))
{
	$track_role = $_POST['track_role'];
	if($track_role == 'cancel')
	{
		$track_role = '';
		delete_post_meta($post->ID,'tm_track_role');
	}
	else
		update_post_meta($post->ID,'tm_track_role',$track_role);
}
else
	$track_role = get_post_meta($post->ID,'tm_track_role',true);
	
if(isset($_POST['remove']))
{
	update_post_meta($post->ID,'tm_judges_removed',$_POST['remove']);
}
	
if(isset($_POST['tm_tiebreaker']))
{
	$tiebreaker = (int) $_POST['tm_tiebreaker'];
	update_post_meta($post->ID,'tm_scoring_tiebreaker',$tiebreaker);
}
else
	$tiebreaker = get_post_meta($post->ID,'tm_scoring_tiebreaker',true);

if(isset($_POST['contest_timer_user']))
	update_post_meta($post->ID,'contest_timer',$_POST['contest_timer_user']);

if(isset($_POST['timer_named']))
	update_post_meta($post->ID,'contest_timer_named',$_POST['timer_named']);
	
if(isset($_POST['tm_scoring_dashboard_users']))
{
	$dashboard = add_query_arg('scoring','dashboard',get_permalink());
	if(empty($dashboard_users))
	$dashboard_users = array(); //reset
	foreach($_POST['tm_scoring_dashboard_users'] as $user_id)
		if($user_id && !in_array($user_id,$dashboard_users))
			{
			add_contest_userlink($user_id,$dashboard);
			$dashboard_users[] = $user_id;
			}
	update_post_meta($post->ID,'tm_contest_dashboard_users',$dashboard_users);
}

if(!empty($track_role))
{
	$signup = get_post_meta($post->ID,'_contest_tracking_post',true);
	$track_from = ($signup) ? $signup : $post->ID;
	$miss = 0;
	$field_base = '_'.preg_replace('/[^a-zA-Z0-9]/','_',$track_role);
	for($i = 1; $i <20; $i++)
	{
		$lookup = $field_base.'_'.$i;
		$contestant = get_post_meta($track_from,$lookup,true);
		if(empty($contestant))
		{
			$miss++;
			if($miss > 5)
				break;
			else
				continue;
		}
		elseif(is_numeric($contestant))
		{
		$userdata = get_userdata($contestant);
		$contestant = $userdata->first_name.' '.$userdata->last_name;
		}
		elseif($contestant == '?')
			continue;
		$contestants[] = $contestant;
	}
}
elseif(isset($_POST['contestant'])) {
	foreach($_POST['contestant'] as $contestant) {
		if(!empty($contestant))
			$contestants[] = $contestant;
	}
	//allow user to clear the list of contestants by submitting an empty list
	if(empty($contestants))
		delete_post_meta($post->ID,'tm_scoring_contestants');
}
if(!empty($contestants))
{
	update_post_meta($post->ID,'tm_scoring_contestants',$contestants);
	if(isset($_POST['make_order']) && !empty($_POST['contestant']))
	{
	foreach($_POST['contestant'] as $contestant)
		if(!empty($contestant))
			$order[] = $contestant;
		update_post_meta($post->ID,'tm_scoring_order',$order);
		delete_post_meta($post->ID,'tm_track_role');			
	}
}

if(isset($_POST['judge']))
{	
	//print_r($_POST['judge_email']);
	foreach($_POST['judge'] as $index => $judge_id)
	{
		if(!empty($judge_id)){
			$link = add_query_arg(array('scoring'=>'voting','judge'=>$index),get_permalink());
			add_contest_userlink($judge_id,$link);
			$judge[$index] = $judge_id;
		}
	}
	foreach($_POST['judge_name'] as $index => $judge_name)
	{
		if(!empty($judge_name))
		{
			$judge[$index] = $judge_name;
			$email = (empty($_POST['judge_email'][$index])) ? '' : $_POST['judge_email'][$index];
			if(!empty($email) && is_email($email))
			{
				echo "judge email $email";
				update_post_meta($post->ID,'judge_email'.$index,$email);
			}			
		}
	}
}
if(isset($_POST['remove_judge']))
{
	foreach($_POST['remove_judge'] as $judge_index) {
		$judge_id = $judge[$judge_index];
		unset($judge[$judge_index]);
		if(is_numeric($judge_id)) {
			delete_post_meta($post->ID,'contest_user',$judge_id);
			delete_post_meta($post->ID,'contest_link_'.$judge_id);
			echo 'delete contest_link_'.$judge_id.' post '.$post->ID;	
		}
	}
}

if(isset($judge))
{
	update_post_meta($post->ID,'tm_scoring_judges',$judge);	
}

if(!empty($sync))
	tm_contest_sync($sync);
}

if(empty($contestants))
	$contestants = toast_get_contestants($post->ID);
$judges = get_post_meta($post->ID,'tm_scoring_judges',true);

$is_locked = get_post_meta($post->ID,'contest_locked', true);

if(isset($_POST['contest_locked']))
	{
		$is_locked = true;
		update_post_meta($post->ID,'contest_locked',$current_user->ID);
	}
elseif(isset($_POST['contest_unlock']) && (($is_locked == $current_user->ID) || current_user_can('manage_options')) )
	{
		$is_locked = false;
		update_post_meta($post->ID,'contest_locked',false);
	}


if(isset($_POST['resetit']))
{

	foreach($_POST['resetit'] as $reset)
	{
		if($reset == 'scores')
		{
			foreach($judges as $i => $value)
			{
				delete_post_meta($post->ID,'tm_scoring_vote'.$i);
				delete_post_meta($post->ID,'tm_vote_received'.$i);
				delete_post_meta($post->ID,'tm_subscore'.$i);
			}
		delete_post_meta($post->ID,'_time_report');
		delete_post_meta($post->ID,'_time_disqualified');
		echo '<p>Scores reset</p>';			
		}
		
		if($reset == 'judges')
			delete_post_meta($post->ID,'tm_scoring_judges');
		if($reset == 'deleteorder')
		{
		delete_post_meta($post->ID,'tm_scoring_order');
		echo '<p>Speaking order deleted</p>';
		unset($order);		
		}
		elseif($reset == 'order')
		{
		$order = $contestants;
		shuffle($order);
		update_post_meta($post->ID,'tm_scoring_order',$order);
		echo '<p>Speaking order reset (reshuffled)</p>';			
		}
	}
}

if(empty($order))
	$order = get_post_meta($post->ID,'tm_scoring_order',true);	

if(!empty($judges))
	echo '<div id="score_status"></div><div id="scores">'.toast_scoring_update_get($post->ID).'</div>';
	//<button id="scoreupdate">Update</button>
if(isset($_POST['hide_ballot_links']))
{
	$nolinks = (int) $_POST['hide_ballot_links'];
	update_post_meta($post->ID,'hide_ballot_links',$nolinks);
}
else
	$nolinks = (int) get_post_meta($post->ID,'hide_ballot_links',true);

if(!empty($contestants) && empty($order))
{
?>
<form method="post" action="<?php echo $actionlink; ?>">
	<h2>Set Speaking Order</h2>
	<p><em>Randomized speaking order has not been set.</em></p>
	<div><input type="hidden" name="resetit[]" value="order">
		<button>Set</button></div>
</form>
<?php
	$shuffle_link = add_query_arg( array(
		'scoring' => 'shuffle',
	), get_permalink($post->ID) );
printf('<p>Set order for %s <a target="_blank" href="%s">open in new tab</a></p>',$contest_name,$shuffle_link);
if($related) {
	$other_shuffle_link = add_query_arg( array(
		'scoring' => 'shuffle',
	), get_permalink($related) );
	$other_contest_name = get_post_meta($related,'toast_contest_name',true);
	printf('<p class="other">Set order for %s <a target="_blank" href="%s">open in new tab</a></p>',$other_contest_name,$other_shuffle_link);
}

}
elseif(!empty($order))
{
	echo '<h3>Speaking Order</h3>';
	if(sizeof($order) != sizeof($contestants))
		echo '<div style="color: red; font-weight: bold;">Order appears to be out of sync with contestant list.</div>';
	foreach($contestants as $contestant) {
		if(!in_array($contestant,$order))
			printf('<div style="color: red; font-weight: bold;">Missing: %s</div>',$contestant);
	}
	foreach($order as $index => $next)
	{
		printf("<div>#%d %s</div>",$index + 1, $next);
	}

}

if(isset($_POST['ballot_no_password']))
{
	$ballot_no_password = (int) $_POST['ballot_no_password'];
	update_post_meta($post->ID,'ballot_no_password',$ballot_no_password);
}
else
	$ballot_no_password = get_post_meta($post->ID,'ballot_no_password',true);

if(!$is_locked)
{
if(isset($_POST['importfrom']))
{
	echo 'Copying setup from event post #'.$import = (int) $_POST['importfrom'];
	$users = get_post_meta($import,'contest_user');
	if($users)
	foreach($users as $user)
		add_post_meta($post->ID,'contest_user',$user);
	$judges = get_post_meta($import,'tm_scoring_judges',true);
	if($judges)
		update_post_meta($post->ID,'tm_scoring_judges',$judges);
	$dashboard_users = get_post_meta($import,'tm_contest_dashboard_users',true);
	if($dashboard_users)
		update_post_meta($post->ID,'tm_contest_dashboard_users',$dashboard_users);
	$timer_user = (int) get_post_meta($post->ID,'contest_timer',true);
	if($timer_user)
		update_post_meta($post_id,'contest_timer',$timer_user);
	$tie_breaker = get_post_meta($post->ID,'tm_scoring_tiebreaker',true);
	if($tie_breaker)
		update_post_meta($post_id,'tm_scoring_tiebreaker',$tie_breaker);

	$sql = "SELECT * FROM $wpdb->postmeta WHERE post_id=$import AND meta_key LIKE 'contest_link%' ";
	$results = $wpdb->get_results($sql);
	if($results)
	foreach($results as $row)
		{
		$p = explode('?',$row->meta_value);
		$url = get_permalink().'?'.$p[1];
		update_post_meta($post->ID,$row->meta_key,$url);
		//printf('<p>Setting %s %s %s</p>',$post->ID,$row->meta_key,$row->meta_value);
		}
}

}// end locked test

if(!empty($judges))
{
$dashboard_forms = '';
$related = get_post_meta($post->ID,'_contest_related',true);
if($related) {
	$other_contest_name = get_post_meta($related,'toast_contest_name',true);
	$other_judges = get_post_meta($related,'tm_scoring_judges',true);
}	

$checked = ($nolinks) ? '' : ' checked="checked" ';
$othercontest = ($related) ? '<input type="checkbox" id="showboth" /> Show links for both contests. ' : ''; 
$samedifferent = ($related) ? sprintf('Judge lists %s between contests',($judges == $other_judges) ? 'the same' : '<span style="color: red;">different</span>') : '';
$practice_contest = get_option('tm_practice_contest');
$practice_judges = get_post_meta($practice_contest,'tm_scoring_judges',true);

$update_practice = false;

echo '<h2>Voting Links</h2><p><input type="checkbox" id="showlinks" value="1" '. $checked .' /> Show Links '.$othercontest.' '.$samedifferent.'</p><p class="votinglink">Share these personalized voting links with the judges. </p> ';
wpt_contest_emaillinks_post ();
if(empty($_POST['email_link']))
	echo '<p>To send these links by email, see the Email Links tab, below.</p>';
?>	
<p class="votinglink">

<?php
$email_links = '';

foreach($judges as $key => $value)
{
	$v = $votinglink . '&judge='.$key;
	
	$name = get_member_name($value);
	if(is_numeric($value))
	{
		$userdata = get_userdata($value);
		$username = $userdata->user_login;
	}
	else
	{
		$username = '';
	}
	$is_tiebreaker = ($key == $tiebreaker);
	if($is_tiebreaker)
		{
			$name = 'Tie Breaker';
			if(!empty($username))
				$username = "(tiebreaker's username)";
		}
	echo '<div class="votinglink">';
	$links = '';
	$links .= '<h4>Voting for '.$name.'</h4>'."\n";
	$links .= sprintf('<p>%s <a target="_blank" href="%s">%s</a></p>',$contest_name,$v,$v);
	if(!empty($other_judges[$key])) {
		$v = get_permalink($related).'?scoring=voting&judge='.$key;
		$links .= sprintf('<p class="other">%s <a target="_blank" href="%s">%s</a></p>',$other_contest_name,$v,$v);
		unset($other_judges[$key]);
	}
	if(!empty($username) && !$ballot_no_password)
		$links .= sprintf('<p>This link is password protected, user name: <strong>%s</strong> | <a href="%s">Login</a> | <a href="%s">Set/Reset password</a></p>',$username,wp_login_url($v),wp_login_url().'?action=lostpassword');
	echo $links;
	if(empty($practice_judges[$key]))
	{
		$practice_judges[$key] = $value;
		$update_practice = true;
	}
	$v = add_query_arg(array('scoring' => 'voting','judge' => $key,'reset' => 1),get_permalink($practice_contest));
	$links .= sprintf('<p>%s <a target="_blank" href="%s">%s</a></p>','Practice Contest Ballot for '.$name,$v,$v);
	//$email_links .= $links;
	$email_links .= wpt_contest_emaillinks($links,$key,'judge',$value); // value is user id or name
	echo '</div>';
$dashboard_forms .= dashboard_vote($contestants, $key, $name, $actionlink, $is_tiebreaker);
}

if($update_practice) {
	update_post_meta($practice_contest,'tm_scoring_judges',$practice_judges);
}

if(!empty($other_judges)) {
	printf('<p>%s judges only registered for other contest</p>',sizeof($other_judges));
}

echo '<div class="votinglink">';
$timer_code = get_post_meta($post->ID,'tm_timer_code',true);
if(empty($timer_code))
{
	$timer_code = time()+rand(1,99);
	update_post_meta($post->ID,'tm_timer_code',$timer_code);
}
$timer_link = add_query_arg( array(
    'timer' => 1,
    'claim_timer' => 1,
    'contest' => $timer_code,
), get_permalink($post->ID) );

$links = '<h4>Timer</h4>'."\n";
$timer_user = (int) get_post_meta($post->ID,'contest_timer',true);
if($timer_user && !$ballot_no_password)
	{
		$userdata = get_userdata($timer_user);
		$username = $userdata->user_login;
		$name = $userdata->first_name.' '.$userdata->last_name;
		$links .= sprintf('<p>This link is password protected, user name: <strong>%s</strong> | <a href="%s">Login</a> | <a href="%s">Set/Reset password</a></p>',$username,wp_login_url($timer_link),wp_login_url().'?action=lostpassword');
	}
$links .= sprintf("<p>%s Timer's Report".'<br /><a target="_blank" href="%s">%s</a></p>',$contest_name,$timer_link,$timer_link);

if($related) {
	$other_timer_link = add_query_arg( array(
		'timer' => 1,
		'claim_timer' => 1,
		'contest' => $timer_code,
	), get_permalink($related) );	
	$links.= sprintf("<p class=\"other\">%s Timer's Report".'<br /><a target="_blank" href="%s">%s</a></p>',$other_contest_name,$other_timer_link,$other_timer_link);
}

$timer_code = get_post_meta($practice_contest,'tm_timer_code',true);
$practice_timer_link = add_query_arg( array(
	'timer' => 1,
	'claim_timer' => 1,
	'contest' => $timer_code,
	'reset' => 1,
), get_permalink($practice_contest) );
$links .= sprintf("<p>%s Timer's Report".'<br /><a target="_blank" href="%s">%s</a></p>','Practice Contest',$practice_timer_link,$practice_timer_link);
echo $links;
//$email_links .= $links;
$email_links .= wpt_contest_emaillinks($links,$timer_code,'timer',$timer_user);
echo $links;
echo '</div>';

}

?>
<div>
<?php
	
	if($is_locked)
	{
	echo '<h3>Settings Locked</h3><p>Contest settings are locked. Only a website administrator, or the user who locked the form, can remove the lock.</p>';
	if(($is_locked == $current_user->ID) || current_user_can('manage_options') )
		{
			?>
			<form method="post" action="<?php echo $actionlink; ?>">
				<h2>Unlock</h2>
				<input type="hidden" name="contest_unlock" value="1">
				<button>Unlock</button>
			</form>
<?php		
		}
	}
else {
	$sync = get_post_meta($post->ID,'tm_contest_sync',true);
	$slave = ($sync && ($sync['copy_from'] != $post->ID));
	$addtodrop = contest_user_list_top($judges, $timer_user, $dashboard_users);
	$genericdrop = wp_dropdown_users(array('echo' => false));
	$genericdrop = preg_replace('/<select[^>]+>/','$0'.$addtodrop.'<optgroup label="All Users">',$genericdrop);
	$genericdrop = str_replace('</select>','</optgroup></select>',$genericdrop);
?>
	<h2>Setup</h2>
    <h3 class="nav-tab-wrapper">
	<a class="nav-tab nav-tab-active" href="#contestants">Contestants</a>
	<a class="nav-tab" href="#judges">Judges and Timer</a>
	<a class="nav-tab" href="#email_links">Email Links</a>
	<a class="nav-tab" href="#backup_ballots">Backup Ballots</a>
      <a class="nav-tab" href="#security">Security</a>
      <a class="nav-tab" href="#lock-reset">Lock/Reset</a>
	  <?php
	  if($related) 
	  	echo '<a class="nav-tab" href="#sync">Sync with Related Contest</a>'; 
	  ?>
    </h2>

    <div id="sections" class="rsvpmaker" >
    <section class="rsvpmaker"  id="contestants">
	<?php
if($is_locked) {
	echo '<p>Settings are locked</p>';
}
else {
?>
	<form method="post" action="<?php echo $actionlink ?>" >
<?php
echo track_roles_ui($track_role);

?>
<div id="role_track_status"><?php if(!empty($track_role)) printf('<p>Names pulled from %s role signups on the agenda.</p>',$track_role); ?></div>
<div id="manual_contestants">
<?php
if(empty($track_role) && !empty($track))
	echo '<p>or enter names</p>';

if(is_array($contestants))
foreach($contestants as $value)
{
	//print_r($value);
	printf('<div><input type="text" name="contestant[]" value="%s"></div>',$value);	
}
$stop = 10;
if(is_array($contestants))
	$stop = $stop - sizeof($contestants);
if($stop <2)
	$stop = 2;
for($i= 0; $i < $stop; $i++)
	echo '<div><input type="text" name="contestant[]" value=""></div>';	
?>
<p><input type="checkbox" name="make_order" value="1"> Record this as the official speaking order</p>
</div>
<p><button>Submit</button></p>
</form>
<?php
}
?>
	</section>
	<section class="rsvpmaker"  id="judges">
<?php
if($is_locked) {
	echo 'Settings are locked';
}
elseif($slave) {
	echo 'Judges list controlled from related contest';
}
else {
	$related = get_post_meta($post->ID,'_contest_related',true);
?>	
	<form method="post" action="<?php echo $actionlink ?>" >
	<p>You can select judges from the drop-down list of users or enter the name and email address of guest judges who do not have a user account. Ballot links for guest judges will not be password protected, even if that feature is turned on (see the Security tab).</p>
<?php
do_action('wpt_contest_judges_form');
	if(is_array($judges))
	foreach($judges as $index => $value)
	{
		$selected_option = '';
		if(isset($_GET['debug']))
			printf('<div>%s %s</div>',$index,$value);
		if(is_numeric($value)) {
			$user = $value;
			$name = get_member_name($value);
			$open = 'Open';
			$selected_option = sprintf('<option value="%s">%s</option>',$user,$name);
		}
		else {
			$user = 0;
			$name = $value;
			$open = 'Guest';
		}
		if(isset($_GET['debug']))
			printf('<div>%s %s - user %s open %s</div>',$index,$value,$user,$open);
		if(!empty($tiebreaker) && ($tiebreaker == $index))
			$s = ' checked="checked" ';
		else
			$s = '';
		$drop = str_replace('user','judge['.$index.']',$genericdrop);//awe_user_dropdown ('judge['.$index.']', $user, true, $open);
		if(!empty($selected_option))
			$drop = preg_replace('/<select[^>]+>/','$0'.$selected_option,$drop);
		printf('<p><input type="hidden" name="judge[%s]" value="%s" /><input type="hidden" name="judge_name[%s]" value="%s" /> %s<br /><input type="radio" name="tm_tiebreaker" value="%s" %s />Tiebreaker <input type="checkbox" name="remove_judge[]" value="%s" > Remove as judge</p>',$index,$user,$index,$name,$name,$index,$s,$index);
	}
	$t = time();
	for($i= 0; $i < 15; $i++)
		{
		$index = $t+($i*100)+rand(1,99);	
		$drop = str_replace('user','judge['.$index.']',$genericdrop);
		$class = ($i > 5) ? ' class="morejudges" ' : '';
		printf('<p %s>%s <input type="radio" name="tm_tiebreaker" value="%s" />Tiebreaker</p>',$class, $drop, $index);
		}
	for($i= 0; $i < 15; $i++)
		{
		$index = $t+($i*100)+rand(1,99);	
		$class = ($i > 5) ? ' class="morejudges" ' : '';
		printf('<p %s>Name <input type="text" name="judge_name[%d]" value=""> Email <input type="text" name="judge_email[%d]" value=""><br /><input type="radio" name="tm_tiebreaker" value="%s" />Tiebreaker</p>',$class,$index, $index,$index);
		}
	?>
	<p><input type="checkbox" id="showmorejudges"> Show more judge assignment entries</p>
	
	<h3>Timer</h3>
	<?php 
	$timer_user = (int) get_post_meta($post->ID,'contest_timer',true);
	$timer_named = get_post_meta($post->ID,'contest_timer_named',true);
	if(empty($timer_named))
		$timer_named = array('name' => "",'email' => "");

	$selected_option = (empty($timer_user)) ? '' : sprintf('<option value="%s">%s</option>',$timer_user,get_member_name($timer_user));
	$drop = str_replace('user','contest_timer_user',$genericdrop);//awe_user_dropdown ('judge['.$index.']', $user, true, $open);
	if(!empty($selected_option))
		$drop = preg_replace('/<select[^>]+>/','$0'.$selected_option,$drop);
	echo '<div><em>With</em> a user account '.$drop.'</div>';
	printf('<p><em>Without</em> without a user account: Name <input name="timer_named[name]" value="%s"> Email <input name="timer_named[email]" value="%s"> </p>',$timer_named['name'],$timer_named['email']);
	?>
	<h3>Judging Links</h3>
<p><input type="radio" name="hide_ballot_links" value="0" <?php if(empty($nolinks)) echo ' checked="checked" '; ?> /> Show judge ballot links</p>
<p><input type="radio" name="hide_ballot_links" value="1" <?php if(!empty($nolinks)) echo ' checked="checked" '; ?> /> Hide judge ballot links (if they're not being used)</p>
	<p><button>Submit</button></p>
</form>
<?php
}
?>
	</section>
<section class="rsvpmaker"  id="email_links">
<p>Use this form to email links to the judges and timer. You can send them one at a time or use the Send All Links button at the bottom.</p>
<form method="post" action="<?php echo $actionlink ?>" >
<p>You can customize this introduction to the list of links:</p>
<textarea name="intro_note" id="intro_note" style="width: 90%" rows="3">Please confirm you received this email. We're planning to use a web-based voting / vote counting system for our upcoming contest, and these are the links we would like you to use for your role. You may want to try the practice link ahead of time.</textarea>
<?php 
echo $email_links;
?>
<p><br /><button>Send All Links</button></p>
</form>
	</section>
	<section class="rsvpmaker"  id="backup_ballots">
<?php
	echo "<h3>Backup Voting Forms</h3><p>If judges have problems with the online voting, you can record votes on their behalf.</p>";
echo '<div class="votingforms_tab">';
echo $dashboard_forms.'</div>';
?>
	</section>
    <section class="rsvpmaker"  id="security">
<?php
if($slave || isset($_GET['test'])) {
	echo 'Settings controlled from related contest';
}
else {
?>
	<form method="post" action="<?php echo $actionlink ?>" >
	<h3>Security Options</h3>
<p><input type="radio" name="ballot_no_password" value="0" <?php if(empty($ballot_no_password)) echo ' checked="checked" '; ?> /> User password required for access to ballot, timer's report form</p>
<p><input type="radio" name="ballot_no_password" value="1" <?php if(!empty($ballot_no_password)) echo ' checked="checked" '; ?> /> No password. Ballots protected by coded links</p>
<p><em>By default, a password is required for all voting forms associated with a user account. You may turn off password protection to make it easier for judges to access thier ballots, which will still be private as long as the link is only shared with the individual judges. This setting also applies to the timer's report. Guest judge links, created by entering a name rather than choosing a user account, are not password protected. The contest dashboard is always password protected.</em></p>
<h3>Dashboard Users</h3>
	<p>Add chief judge, ballot counters</p>
<?php
$dashlimit = sizeof($dashboard_users)+5;
for($i= 0; $i < $dashlimit; $i++)
{
	$user = empty($dashboard_users[$i]) ? 0 : $dashboard_users[$i];
	$selected_option = (!$user) ? '' : sprintf('<option value="%s">%s</option>',$user,get_member_name($user));
	$drop = str_replace('user','tm_scoring_dashboard_users[]',str_replace("id='user'",'',$genericdrop));//awe_user_dropdown ('judge['.$index.']', $user, true, $open);
	if(!empty($selected_option))
		$drop = preg_replace('/<select[^>]+>/','$0'.$selected_option,$drop);
	echo '<div>'.$drop.'</div>';
}
?>
	<p><button>Submit</button></p>
</form>
<?php 
}//end slaved
?>
	</section>

	<section id="lock-reset">
<form method="post" action="<?php echo $actionlink; ?>">
	<h2>Lock Settings</h2>
	<p>You can do this once the contest begins to disable the reset function or any other changing of settings while the contest is in progress.</p>
	<input type="hidden" name="contest_locked" value="1">
	<button>Lock</button>
</form>

<form method="post" action="<?php echo $actionlink; ?>">
	<h2>Reset</h2>
	<div><input type="checkbox" name="resetit[]" value="scores"> Scores and Timer's Report</div>
	<div><input type="checkbox" name="resetit[]" value="judges"> Judges List</div>
	<div><input type="checkbox" name="resetit[]" value="order"> Re-Shuffle Speaking Order</div>
	<div><input type="checkbox" name="resetit[]" value="deleteorder"> Delete Speaking Order</div>
	<button>Reset</button>
</form>
	</section>
	<?php if($related) {
	$other_contest_name = get_post_meta($related,'toast_contest_name',true); 
	?>
	<section id="sync">
	<form method="post" action="<?php echo $actionlink; ?>">
	<h2>Sync Settings</h2>
	<div><input type="radio" name="sync" value="" <?php if(empty($sync)) echo ' checked="checked" ' ?> > Off</div>
	<div><input type="radio" name="sync" value="slave" <?php if($slave) echo ' checked="checked" ' ?> > Sync based on <?php echo $other_contest_name; ?></div>
	<div><input type="radio" name="sync" value="master" <?php if(!empty($sync) && !$slave) echo ' checked="checked" ' ?> > Sync based on this contest</div>
	<input type="hidden" name="related" value="<?php echo $related; ?>" />
	<button>Save</button>
</form>
	</section>
	<?php } //end if related show sync ?>
	</div><!--end of sections--->
</div>
<?php
judge_import_form($actionlink);
} //end test $is_locked
do_action('wpt_scoring_dashboard_bottom'); ?>
<p style="margin-top: 200px;"><a href="<?php echo $actionlink. '&reset_scoring=1'; ?>">Change Contest Type</a></p>
<?php
$output .= ob_get_clean();
return $output;
}

function toast_get_contestants($post_id) {
return get_post_meta($post_id,'tm_scoring_contestants',true);
}

function toast_scoring_update_get($post_id) {
$judges = get_post_meta($post_id,'tm_scoring_judges',true);
if(empty($judges))
	return 'Judges not set';
$contestants = toast_get_contestants($post_id);
if(empty($contestants))
	return 'Contestants not set';

$tiebreaker = get_post_meta($post_id,'tm_scoring_tiebreaker',true);
$tiebreaker_vote = array();

$timer_report = get_post_meta($post_id,'_time_report',true);
$timer_report = (empty($timer_report)) ? "<p>Timer's report not submitted" : "<h3>Timer's Report</h3>".$timer_report;
$disqualified = get_post_meta($post_id,'_time_disqualified',true);
if(empty($disqualified)) $disqualified = array();

$output = '';
$novote = 0;
$missing_votes = '';
	$tiebreaker_status = '<h3>Tiebreaker Ranking</h3>';
	foreach($judges as $index => $judge) {
		$votes = get_post_meta($post_id,'tm_scoring_vote'.$index,true);
		if(!empty($votes))
			update_post_meta($post_id,'tm_vote_received'.$index,true);
		if(is_numeric($judge))
		{
			$userdata = get_userdata($judge);
			$judge = $userdata->first_name.' '.$userdata->last_name;
		}
		if($index == $tiebreaker)
		{
			if(empty($votes))
				$tiebreaker_status = '<div style="color: red;">Tiebreaking judge has not yet voted</div>';
			else
			{
			$tiebreaker_vote = $votes;
			unset($votes);
			foreach($tiebreaker_vote as $i => $vote)
			{
				$tiebreaker_status .= sprintf('<div>%s</div>',$vote);
			}
			
			}				
		}
		elseif(empty($votes))
		{
			$output .= '<h3>'.$judge.'</h3><p>no votes recorded</p>';
			$novote++;
			$missing_votes .= $judge.' ';
		}
		else
		{
			$output .= '<h3>'.$judge.'</h3>';
			$signature = get_post_meta($post_id,'tm_scoring_signature'.$index,true);
			$output .= sprintf('<div>Signed: %s</div>',$signature);
			$votes_recorded = true;
			foreach($votes as $i => $vote)
			{
				$points = 3 - $i;
				$output .= sprintf('<div>%s %d points</div>',$vote,$points);
				if(empty($ranking[$vote]))
					$ranking[$vote] = $points;
				else
					$ranking[$vote] += $points;
			}
		}
	}
if(!isset($votes_recorded))
	$output = 'No votes recorded';
else
{
	$top =  '<div style="margin: 10px; padding: 10px; "><h2>Top Scores</h3>';
	$topscores = '<h3>Full Ranking with Scores</h3>'; 
	$topcount = 0;
	foreach($contestants as $c)
		if(empty($ranking[$c]))
			$ranking[$c] = 0;
	if(!empty($disqualified))
		{
		$order = get_post_meta($post_id,'tm_scoring_order',true);
		if(!empty($order))
			{
			foreach($disqualified as $id)
				{
				$c = $order[$id];
				$ranking[$c] -= 100;
				}
			}
		}
	arsort($ranking);
	$last_contestant = '';
	$last_points = 0;
	$inc = 0.1;
	$tie = false;
	foreach($ranking as $contestant => $points)
	{
		if(!empty($last_contestant) && ($points == $last_points))
			$tie = true;
	$last_contestant = $contestant;
	$last_points = $points;
	}
	if($novote)
		$top .= sprintf('<div style="color: red;">%s judges have not yet voted: %s</div>',$novote,$missing_votes);
	else
	{
		$top .= '<div style="background-color: red; color: white; font-weight: bold; padding: 5px;">All judges have now voted</div>';
		if($tie && !empty($tiebreaker_vote))
		{
			$top .= '<p>Tiebreaking judge vote applied</p>';
			foreach($tiebreaker_vote as $index => $contestant)
			{
				if(!empty($ranking[$contestant])) {
					$ranking[$contestant] += $inc;
				}
				$inc -= 0.01;
			}
			arsort($ranking);
		}
		$alljudgesvoted = true;		
	}

	$lastpoint = 0;
	$lastpointsint = 0;
	$topnopoints = '<h3>Without Scores</h3>';

	foreach($ranking as $contestant => $points)
	{
		if(($topcount < 3) && ($points > 0)) {
			$is_tie = ($points == $lastpoint) ? ' (tied with #'.$topcount.')' : '';
			$top .= sprintf('<div>#%d %s</div>',$topcount+1,$contestant.$is_tie);
			$lastpoint = $points;
		}
		if($points >= 0) {
			$pointsint = (int) $points;
			$tiemessage = ($pointsint == $lastpointsint) ? ' (Tiebreaking Judge\'s vote applied)' : '';
			$lastpointsint = $pointsint;
			$topscores .= sprintf('<div>%s <span class="contestant_points">%s points %s</span></div>',$contestant,$pointsint,$tiemessage);
			$topnopoints .= sprintf('<div>%s</div>',$contestant);
		}
		else
			$topscores .= sprintf('<div>%s (disqualified)</div>',$contestant,$points);			
		$topcount++;
	}
	$top .= $tiebreaker_status . $timer_report.'</div>';
	if(!empty($alljudgesvoted) && !empty($tiebreaker_status) )
		$top = apply_filters('wpt_contest_alljudgesvoted',$top);
	$output = $top . $topscores . $topnopoints . $output;
}
return $output;
}

function toast_scoring_update () {
	if(!isset($_GET['toast_scoring_update']))
		return;
	$update = toast_scoring_update_get($_GET['toast_scoring_update']);
	die($update);
}

add_action('init','toast_scoring_update');
  
function toast_scoring_sheet() {
ob_start();
global $post;
global $current_user;
$votinglink = $actionlink = get_permalink($post->ID);
if(strpos($actionlink,'?'))
{
$actionlink .= '&scoring=dashboard';
$votinglink .= '&scoring=voting';	
}
else {
$actionlink .= '?scoring=dashboard';
$votinglink .= '?scoring=voting';	
}

$contestants = toast_get_contestants($post->ID);
$judges = get_post_meta($post->ID,'tm_scoring_judges',true);
$tiebreaker = get_post_meta($post->ID,'tm_scoring_tiebreaker',true);
$ballot_no_password = get_post_meta($post->ID,'ballot_no_password',true);

if(isset($_REQUEST['judge']))
{
	$id = (int) $_REQUEST['judge'];
	if(!isset($judges[$id]))
		return 'Invalid judge code'.wpt_mycontests();
	$judge_name = $judges[$id];
	if(is_numeric($judge_name))
	{
	$dashboard_users = get_post_meta($post->ID,'tm_contest_dashboard_users',true);
	if(empty($dashbord_users)) $dashboard_users = array(); 
	if(empty($ballot_no_password) && ($current_user->ID != $judge_name) && !in_array($current_user->ID,$dashboard_users))
	{
	echo wpt_mycontests();
	printf('<p>You must <a href="%s">login</a> to access this judge\'s voting form.</p>',wp_login_url($_SERVER['REQUEST_URI']));
	return;
	}
	$judge_name = get_member_name($judge_name);
	}
}
elseif( is_user_logged_in() )
{
	$id = $judge_id = array_search($current_user->ID,$judges);
	$name = get_member_name($judge_id);
	if( !$id)
		echo '<div style="color: red;">Logged in user is not on the list of judges</div>';
}

$votinglink .= '&judge='.$id;

$link = sprintf('<div id="agendalogin"><a href="%s">'.__('Login','rsvpmaker-for-toastmasters').'</a></div>',site_url().'/wp-login.php?redirect_to='.urlencode($votinglink));

if(! $id )
	return sprintf('<p>Before voting, you must either log in as a user authorized as a judge or access this page with a code provided for guest judges. %s</p>',$link).wpt_mycontests();
do_action('wpt_voting_form_top');
printf('<p><em>Voting Form for %s</em></p>',$judge_name);

if( isset($_POST['signature']) && empty($_POST['signature']) )
	echo '<div style="color: red; padding: 20px;">Error: Signature left blank</div>';
elseif(isset($_POST['vote']))
	{
		update_post_meta($post->ID,'tm_scoring_vote'.$id,$_POST['vote']);
		update_post_meta($post->ID,'tm_scoring_signature'.$id,$_POST['signature'].' - '.$_POST['signature_date']);
		rsvpmaker_debug_log($_POST,'contest_vote_submitted');
	}

if(isset($_GET['reset']))
	$votes = false;
else
	$votes = get_post_meta($post->ID,'tm_scoring_vote'.$id,true);
if(is_array($votes) && !isset($_GET['judge_id']))
{
	printf('<form action="%s" method="post">',site_url($_SERVER['REQUEST_URI']));
	echo '<h2>Recorded</h2>';
	echo '<div id="gotvote_result" style="font-style: italic; font-weight: bold; padding: 20px;"></div>';
	foreach($votes as $index => $vote)
	{
		printf('<p>#%d %s</p>',$index + 1, $vote);
		printf('<input type="hidden" name="vote[]" value="%s">',$vote);
		if(empty($vote)) {
			$blanks = true;
			echo '<div style="color: red;">Vote left blank</div>';
		}
	}
if(empty($blanks))
{
	echo '<p>Keep this page open until you confirm your votes have been received properly. Some contest organizers may require an analog signature on a printout or a paper ballot as a formality.</p>';
	echo '<p><button>Resubmit</button></p><p><em>Resubmit resubmits your previous vote (does not allow you to change your vote). Only use if there is a problem with votes showing up on the voting dashboard monitored by conference officials.</em></p>';
do_action('wpt_contest_ballot_submitted');
	//check for update_post_meta($post_id,'tm_vote_received'.$index,true);
	return ob_get_clean();	
}
else
	{
		delete_post_meta($post->ID,'tm_scoring_vote'.$id);
		echo '<p>Please correct errors and re-submit.</p>';
	}
echo '</form>';
}

$order = get_post_meta($post->ID,'tm_scoring_order',true);
if(empty($order))
	{
		echo '<p>Refresh this page once the contestant order has been set.</p>';
?>
<div id="order_status"></div>
<script>
jQuery(document).ready(function($) {

function refreshOrder() {
$('#score_status').html('Checking for contestant order ...');
$.get( "<?php echo get_rest_url('/wptcontest/v1/order/'.$post->ID); ?>", function( data ) {
console.log(data);
if(Array.isArray(data)) {
	$('#order_status').html('Order set, reload the page now if it does not do so automatically');
	location.reload();	
}
else
  $('#order_status').html('Order still not set');
});	
}

setInterval(function(){
  refreshOrder();	
}, 10000);
	
$('#track_role').on('change', function(){
var role = $(this).val();
if(role == '')
	{
$('#role_track_status').html('');
$('#manual_contestants').show();		
	}
else {
$('#role_track_status').html('<p>Contestant names will be pulled from the '+role+' role on the agenda</p>');
$('#manual_contestants').hide();	
}
});

});
</script>
<?php		return ob_get_clean();
	}

$scoring = get_post_meta($post->ID,'toast_contest_scoring',true);

if(isset($_GET["clear_scores"]))
	$tm_subscores = array();
else
	$tm_subscores = get_post_meta($post->ID,'tm_subscore'.$id,true);
echo '<style>th {font-size: 10px;} .criteria {width: 50px;} .max {width: 25px} .score {width: 25px;} select {min-width: 100px;} table {max-width: 400px;}</style>';

foreach($order as $index => $name)
{
	if(empty($name))
		continue;
	printf('<h3>Contestant #%d %s</h3><input type="hidden" id="contestant%d" value="%s">',$index+1,$name,$index,$name);	
	echo "\n";
	echo '<table><tr><th class="criteria">Criteria</th><th class="max">Max</th><th class="score">Score</th></tr>';
	echo "\n";
	$category_count = 0;
	foreach($scoring as $category => $maxscore)
	{
	echo '<tr>';
	printf('<th  class="criteria">%s</th><td  class="max">%s</td>',$category,$maxscore);
	if(!isset($score_me[$index]))
		$score_me[$index] = 0;
	if(isset($tm_subscores[$category_count][$index]))
		$score_me[$index] += $tm_subscores[$category_count][$index];		   
	if(isset($_GET['demo'])) 
		$preselected = rand(2,$maxscore);
	else
		$preselected = 0;
	$category_count++;
	printf('<td class="score"><input type="number" min="0" max="%d" name="scores[%s][%s]" contestant="%d" class="score score%d" value="%d" /> </td></tr>',$maxscore,$category_count,$index,$index,$index,$preselected);
	echo "\n";
	}//end foreach scoring
	echo '</table>';
	printf('<p><strong>Total <span id="sum%d">%s</span></strong></p>',$index,$score_me[$index]);
}//end foreach order

?>

<div id="autorank"><button id="autorank_now">Show Ranking</button></div>

<p>Use the scoresheet above to guide your vote. If two contestants have the same score, use your judgement to break the tie -- you must choose first, second, and third.</p>

<h2>Vote</h2>
<?php 
echo '<form id="voting" method="post" action="'.$votinglink.'"><div id="nowvote"></div>';
$vote_opt = '';
if(!empty($contestants))
{
	sort($contestants);
	foreach ($contestants as $contestant)
		$vote_opt .= sprintf('<option value="%s">%s</option>',$contestant,$contestant);	
}
	
$contestant_count = sizeof($contestants);
if($tiebreaker == $id)
	echo '<h3>As the tiebreaking judge, you should rank order ALL contestants.</h3>';
$max = (($tiebreaker == $id) || ($contestant_count < 3)) ? $contestant_count : 3;

for($i= 1; $i <= $max; $i++)
	printf('<div><select class="voteselect" name="vote[]"><option value="">Vote #%d</option>%s</select></div>',$i,$vote_opt);
global $rsvp_options;
?>
<div><label>Signature:</label> <input type="text" name="signature" id="signature"> <br /><label>Date:</label> <input type="text" name="signature_date" value="<?php echo rsvpmaker_strftime($rsvp_options['long_date'],time()); ?>" />
<br /><em>By typing your name and verifying the date, you are signing this ballot as your official vote</em></div>

<div id="readyprompt"></div>
<input type="hidden" name="judge_id" value="<?php echo $id; ?>" />
<button>Vote</button>
</form>
<?php
return ob_get_clean();
}

function dashboard_vote($contestants, $id, $judge_name, $votinglink, $tiebreaker=false) {
	ob_start();
	if($tiebreaker)
		$judge_name = 'Tie Breaker';
	echo '<h3>'.$judge_name.'</h3><div id="votestatus'.$id.'"></div>';
	echo '<form class="dashboard_votes" class="dashboard_votes" method="post" action="'.$votinglink.'">';	
	$vote_opt = '';
	if(!empty($contestants))
	{
		sort($contestants);
		foreach ($contestants as $contestant)
			$vote_opt .= sprintf('<option value="%s">%s</option>',$contestant,$contestant);	
	}
		
	$contestant_count = (empty($contestants)) ? 0 : sizeof($contestants);
	if($tiebreaker == $id)
		echo '<h3>As the tiebreaking judge, you should rank order ALL contestants.</h3>';
	$max = (($tiebreaker) || ($contestant_count < 3)) ? $contestant_count : 3;
	
	for($i= 1; $i <= $max; $i++)
		printf('<div><select class="voteselect" name="vote[]"><option value="">Vote #%d</option>%s</select></div>',$i,$vote_opt);
	?>
	<p><input type="checkbox" name="dashboardvote" value="1" /> Record these choices on behalf of <?php echo $judge_name; ?></p>
	<input type="hidden" name="judge_id" value="<?php echo $id; ?>" />
	<button>Vote</button>
	</form>
<?php
return ob_get_clean();
}

function contest_demo ($atts) {
global $post;
$output = '';
if(isset($atts['result']))
{
if(isset($_POST['demo_title']))
{
	$demo["post_type"] = 'rsvpmaker';
	$demo["post_title"] = stripslashes($_POST['demo_title']);
	$demo["post_content"] = 'This is a contest demo post.
	
<a href="?scoring=dashboard">Scoring Dashboard</a>';
	$demo["post_author"] = 1;
	$demo["post_status"] = 'publish';
	$demo_id = wp_insert_post( $demo );
	add_post_meta($demo_id,'_contest_demo',$_SERVER['REMOTE_ADDR']);
	$link = get_permalink($demo_id).'?scoring=dashboard';
	$output .= sprintf('<h3>Contest Demo Created!</h3><p>Scoring Dashboard: <a href="%s">%s</a></p>',$link,$link);
}	
}

if(isset($atts['form']))
{
$output .= sprintf('<form action="%s" method="post"><h3>Create Contest Page</h3><p><input type="text" name="demo_title" value="My Demo"><br /><em>Give your page a name, such as Area Contest or Video Speech Contest</em></p><button>Create</button></form>',get_permalink($post->ID));
}
return $output;
}

$myusers_indexed = array();

function check_contest_collaborators () {
	global $wpdb, $current_user, $myusers_indexed;
	$myusers = array();
	$results = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key='contest_user' AND meta_value='".$current_user->ID."' ORDER BY meta_id");
	foreach($results as $row) {
		$sql = "SELECT * FROM $wpdb->postmeta WHERE meta_key='contest_user' AND post_id=".$row->post_id;
		$myresults = $wpdb->get_results($sql);
		
		foreach($myresults as $urow) {
			if(is_numeric($urow->meta_value) && !in_array($urow->meta_value,$myusers))
				$myusers[] = $urow->meta_value;
		}
	
		}
	if(isset($options) && (empty($myusers) || (sizeof($myusers) == 1)))
		return $options;
	foreach($myusers as $user_id) {
		$user = get_userdata($user_id);
		if(empty($user) || empty($user->user_email))
			continue;
		//$output .= sprintf('<div>%s %s %s</div>',$user->first_name,$user->last_name,$user->user_email);
		$index = preg_replace('/[^a-zA-Z]/','',$user->first_name.$user->last_name.$user->user_email).':'.$user->ID;
		$myusers_indexed[$index] = sprintf('%s %s (%s)',$user->first_name,$user->last_name,$user->user_login);
		}
	ksort($myusers_indexed);
	return $myusers_indexed;
}

function judge_import_form($action) {
	global $post, $wpdb, $current_user;
	$judges = get_post_meta($post->ID,'tm_scoring_judges',true);
	if(empty($judges) && check_contest_collaborators ()) {
		$opt = '<option value="">Choose Previous Contest</option>';
		$results = $wpdb->get_results("SELECT * FROM $wpdb->posts JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id WHERE meta_key='tm_scoring_judges' AND post_status='publish' ORDER BY ID DESC");
		if($results)
		foreach($results as $event) {
			$contest_users = get_post_meta($event->ID,'contest_user');
			if($contest_users && !in_array($current_user->ID,$contest_users))
				continue;
			$date = get_rsvp_date($event->ID);
			$opt .= sprintf('<option value="%d">%s %s</option>',$event->ID,$event->post_title,rsvpmaker_strftime('',$date));
		}
		if(!empty($opt) && empty(get_post_meta($post->ID,'tm_contest_sync',true)))
			printf('<form action="%s" method="post"><h3>Import judges/settings (optional)</h3><p><select name="importfrom">%s</select></p>
			<p>If the list of judges will be the same (or mostly the same) as for another contest, you can import those settings rather than setting them individually.</p>
			<button>Import</button></form>',$action,$opt);
	}	
}

function track_roles_ui($track_role = '', $slug = '') {
	global $post;
	if(strpos($post->post_content,'wp:wp4toastmasters'))
{
$data = wpt_blocks_to_data($post->post_content);
foreach($data as $item)
	if(!empty($item['role']))
		$roles[] = $item['role'];
}
else {
preg_match_all('/role="([^"]+)/',$post->post_content,$matches);
	$roles = (empty($matches[1])) ? array() : $matches[1];	
}
	
if(!empty($roles))
{
$track = '';
$track_top = '<option value="">Select Role</option>';

foreach($roles as $role)
{
$s = ($role == $track_role) ? ' selected="selected" ' : '';
if(strpos($role,'peaker') || strpos($role,'peech') || strpos($role,'ontest'))
	$track_top  .= sprintf('<option value="%s" %s>%s</option>',$role,$s,$role);
else
	$track .= sprintf('<option value="%s" %s>%s</option>',$role,$s,$role);
}

return sprintf('<p>Sync With Agenda Role for Contestants <br /><select id="track_role%s" name="track_role%s" >%s<option value="cancel">Cancel Selection</option></select></p>',$slug,$slug,$track_top.$track);

}

}

function tm_contest_sync($sync = null) {
	global $post;
	if(empty($sync))
		$sync = get_post_meta($post->ID,'tm_contest_sync',true);
	if(empty($sync))
		return;
	$copyfrom = $sync['copy_from'];
	$copyto = $sync['copy_to'];
	$judges = get_post_meta($copyfrom,'tm_scoring_judges',true);
	update_post_meta($copyto,'tm_scoring_judges', $judges );
	update_post_meta($copyto,'tm_scoring_tiebreaker', get_post_meta($copyfrom,'tm_scoring_tiebreaker',true) );
	update_post_meta($copyto,'contest_timer', get_post_meta($copyfrom,'contest_timer',true) );
	if($judges)
	foreach($judges as $index => $judge_id) {
		if(is_numeric($judge_id))
		{
			$arg = array('scoring' => 'voting','judge' => $index);
			$link = add_query_arg($arg,get_permalink($copyto));
			add_contest_userlink($judge_id,$link,$copyto);
		}
	}
	update_post_meta($copyto,'tm_contest_dashboard_users',get_post_meta($copyfrom,'tm_contest_dashboard_users',true));
	update_post_meta($copyto,'ballot_no_password',get_post_meta($copyfrom,'ballot_no_password',true));
}

function get_practice_contest_links() {
	global $current_user;
	$practice_contest = get_option('tm_practice_contest');
	$timing = '5 to 7';	
	$scoring_index = 'International Speech Contest';
	$contest_scoring = array('Speech Development' => 20,'Effectiveness' => 15,'Speech Value' => 15,'Physical' => 10,'Voice' => 10,'Manner' => 10,'Appropriateness' => 10,'Correctness' => 10);

	if(empty($practice_contest) || empty(get_post($practice_contest))) {
		$data['post_title'] = 'Demo: '.$scoring_index;
		$data['post_content'] = '[wpt_contests_prompt]';
		$data['post_author'] = $current_user->ID;
		$data['post_type'] = 'rsvpmaker';
		$data['post_status'] = 'publish';
		$practice_contest = wp_insert_post($data);
	}
	if(empty($data))//if new, this won't be set
		$judges = get_post_meta($practice_contest,'tm_scoring_judges',true);
	if(empty($judges))
		$judges = array();
	else {
		$size = sizeof($judges);
		//shorten the list
		if($size > 15)
		{
			$i = 1;
			$stop = $size - 10;
			foreach($judges as $index => $value) {
				if($i < $stop)
					unset($judges[$index]);
				$i++;
			}
		$judges['100000'] = 'Demo Judge';
		update_post_meta($practice_contest,'tm_scoring_judges',$judges);
		}
	}
	if(!empty($data) || isset($_GET['reset']))
	{
		update_post_meta($practice_contest,'toast_contest_name','Demo: '.$scoring_index);
		update_post_meta($practice_contest,'toast_contest_scoring',$contest_scoring);
		update_post_meta($practice_contest,'toast_timing',$timing);
		update_post_meta($practice_contest,'_rsvpmaker_special','Contest document');
		update_post_meta($practice_contest,'_rsvp_dates','2000-01-01 07:00:00');
		$contestants = array('Aaron Beverly','Mike Carr','Ramona J. Smith','Darren LaCroix','Mark Brown');
		update_post_meta($practice_contest,'tm_scoring_contestants',$contestants);
		update_post_meta($practice_contest,'tm_scoring_order',$contestants);
		update_post_meta($practice_contest,'ballot_no_password',1);
		if(!empty($data) || ( isset($_GET['reset']) && isset($_GET['scoring']) && ($_GET['scoring'] == 'dashboard') ) )
			if(is_user_logged_in())
				update_post_meta($practice_contest,'tm_contest_dashboard_users',array($current_user->ID));
		$judges['100000'] = 'Demo Judge';
		update_post_meta($practice_contest,'tm_scoring_judges',$judges);
		update_post_meta($practice_contest,'tm_timer_code','200000');
		update_option('tm_practice_contest',$practice_contest);
	}
	if(isset($_GET['reset'])) {
		delete_post_meta($practice_contest,'_time_report');
	if(isset($_GET['judge'])) {
		$index = $_GET['judge'];
		delete_post_meta($practice_contest,'tm_scoring_vote'.$index);
	}
	elseif($_GET['scoring'] == 'dashboard') {
		foreach($judges as $index => $judge)
			delete_post_meta($practice_contest,'tm_scoring_vote'.$index);
	}
	}

	$practicelinks['judge'] = add_query_arg(array('scoring' => 'voting','judge' => '100000','reset' => 1),get_permalink($practice_contest));
	if(is_user_logged_in())
		$practicelinks['dashboard']  = add_query_arg(array('scoring' => 'dashboard','reset' => 1),get_permalink($practice_contest));
	return $practicelinks;
}

function wpt_mycontests_links($practice) {
$mycontests = get_permalink().'?scoring=mycontests';
$output = '<div style="width: 300px;text-align: center; float: right; background-color: #FFFF99; padding: 5px;"><a href="'.$mycontests.'">My Contests</a>';
if(isset($practice['dashboard']))
	$output .= sprintf('<div><a href="%s" target="_blank">Practice Contest Dashboard</a></div>',$practice['dashboard']);
$output .= sprintf('<div><a href="%s" target="_blank">Practice Contest Ballot</a></div>',$practice['judge']);
$output .= apply_filters('my_contests_help','');
$output .= '<div><a  target="_blank" href="https://www.wp4toastmasters.com/knowledge-base/category/contests/">Help</a></div>';
$output .= '</div>';
return $output;
}

function wpt_contest_emaillinks_post () {
	global $current_user, $post;
	if(isset($_POST['email_link']))
		{
			foreach($_POST['email_link'] as $code => $email) {
				if(!empty($email))
				{
					$mail['to'] = $email;
					$mail['subject'] = stripslashes($_POST['email_subject'][$code]);
					$mail['html'] = '<p>'.nl2br(stripslashes($_POST['intro_note']) ."\n\n". stripslashes($_POST['email_link_note'][$code]))."</p>\n";
					$mail['from'] = $current_user->user_email;
					$mail['fromname'] = $current_user->display_name;
					rsvpmailer($mail);
					echo '<div>Emailing links to '.$_POST['email_link'][$code].'</div>';	
				}
			}
		}	
}

function wpt_contest_emaillinks($links,$code,$role, $user_id) {
global $post;
ob_start();
	if(is_numeric($user_id) && $user_id)
	{
	$userdata = get_userdata($user_id);
	$email = $userdata->user_email;
	$name = $userdata->display_name;
	}
	elseif($role == 'timer')
	{
	$timer_named = get_post_meta($post->ID,'contest_timer_named',true);
	$email = (empty($timer_named['email'])) ? '' : $timer_named['email'];
	$name = (empty($timer_named['name'])) ? '' : $timer_named['name'];
	}
	else
	{
	$email = get_post_meta($post->ID,'judge_email'.$code,true);
	$name = $user_id;
	}
	$tiebreaker = get_post_meta($post->ID,'tm_scoring_tiebreaker',true);
	if($code == $tiebreaker)
		$role = 'Tie Breaker';
	$subject = 'IMPORTANT for your role in our contest: '.$role;
	printf('<p class="email_links_new"><strong>Email links for %s to</strong> <input type="text" name="email_link[%s]" id="email_link%s" value="%s" /><br /><input type="text" name="email_subject[%s]" id="email_subject%s" value="%s" size="80" /><br />Note: <textarea name="email_link_note[%s]" id="email_link_note%s" rows="4">%s</textarea><br /><button class="send_contest_link" id="%s" action="%s">Send to %s</button><div id="send_link_status%s"></div></p>'
	,$name,$code,$code,$email,$code,$code,$subject,$code,$code,"Your role: $role\n\n".trim(strip_tags(str_replace("</p>","\n\n",$links),'<a><strong><h3>')),$code,get_rest_url(NULL,'wptcontest/v1/send_link'),$name,$code);
return ob_get_clean();
}

function contest_user_list_top($judges, $timer_user, $dashboard_users) {
	global $current_user, $wpdb, $post;
	$team = get_user_meta($current_user->ID,'my_contest_team',true);
	if(empty($team))
		$team = array();
	$initial = $team;
	if(empty($team))
	{
		$sql = "SELECT * FROM $wpdb->postmeta WHERE meta_key='tm_contest_dashboard_users' AND meta_value LIKE '%\"$current_user->ID\"%' AND post_id != $post->ID";
		$results = $wpdb->get_results($sql);
		if($results) {
			foreach($results as $row) {
				$otherpost = $row->post_id;
				$otherjudges = get_post_meta($otherpost,'tm_scoring_judges',true);
				$otherdash = get_post_meta($otherpost,'tm_contest_dashboard_users',true);
				$othertimer = get_post_meta($otherpost,'contest_timer',true);
				if(!empty($other_judges) && is_array($other_judges))
				foreach($other_judges as $id) {
					if($id && is_numeric($id) && !in_array($id,$team))
						$team[] = $id;
				}
				if(!empty($otherdash) && is_array($otherdash))
				foreach($otherdash as $id) {
					if($id && !in_array($id,$team))
						$team[] = $id;
				}
				if($othertimer && is_numeric($othertimer) && !in_array($othertimer,$team) )
					$team[] = $othertimer;	
			}
		}
	}
	if(is_array($judges))
	foreach($judges as $id) {
		if($id && is_numeric($id) && !in_array($id,$team))
			$team[] = $id;
	}
	if(is_array($dashboard_users))
	foreach($dashboard_users as $id) {
		if($id && !in_array($id,$team))
			$team[] = $id;
	}
	if($timer_user && is_numeric($timer_user) && !in_array($timer_user,$team) )
		$team[] = $timer_user;
		
	$top = '<option value="">Open</open><optgroup label="My Contest Team">';
	foreach($team as $id) {
		$name = get_member_name($id);
		$opt[$name] = sprintf('<option value="%s">%s</option>',$id,$name);
	}
	ksort($opt);
	$top .= implode('',$opt);
	$top .= '</optgroup>';
	if($initial != $team)
		update_user_meta($current_user->ID,'my_contest_team',$team);

	return apply_filters('wpt_contest_user_dropdown',$top);
}
