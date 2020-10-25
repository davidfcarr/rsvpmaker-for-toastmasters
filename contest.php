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

function set_contest_parameters($post_id,$contest) {
	global $current_user;
	$contest_selection['International Speech Contest'] = array('Speech Development' => 20,'Effectiveness' => 15,'Speech Value' => 15,'Physical' => 10,'Voice' => 10,'Manner' => 10,'Appropriateness' => 10,'Correctness' => 10);
	$contest_selection['Video Speech Contest'] = array('Speech Development' => 20,'Effectiveness' => 15,'Speech Value' => 15,'Physical' => 10,'Voice' => 10,'Manner' => 10,'Appropriateness' => 10,'Correctness' => 10);
	$contest_selection['Humorous Speech Contest'] = array('Speech Development' => 15,'Effectiveness' => 10,'Speech Value' => 15,'Audience Response' => 15,'Physical' => 10,'Voice' => 10,'Manner' => 10,'Appropriateness' => 10,'Correctness' => 5);
	$contest_selection['Table Topics Contest'] = array('Speech Development' => 30,'Effectiveness' => 25,'Physical' => 15,'Voice' => 15,'Appropriateness' => 10,'Correctness' => 5);
	$contest_selection['Evaluation Contest'] = array('Analytical Quality' => 40,'Recommendations' => 30,'Technique' => 15,'Summation' => 15);
	$contest_selection['Mini-Webinar Contest'] = array('Speech Development' => 15,'Audience Engagement' => 15,'Speech Value' => 15,'Call to Action' => 15,'Visual' => 15,'Voice' => 10,'Manner' => 5,'Appropriateness/Correctness' => 10);
	
	$contest_timing['International Speech Contest'] = '5 to 7';
	$contest_timing['Video Speech Contest'] = '5 to 7';
	$contest_timing['Humorous Speech Contest'] = '5 to 7';
	$contest_timing['Table Topics Contest'] = '1 to 2';
	$contest_timing['Evaluation Contest'] = '2 to 3';
	$contest_timing['Mini-Webinar Contest'] = '6 to 8';
	update_post_meta($post_id,'toast_contest_name',$contest);
	update_post_meta($post_id,'toast_contest_scoring',$contest_selection[$contest]);
	update_post_meta($post_id,'toast_timing',$contest_timing[$contest]);
	update_post_meta($post_id,'tm_contest_dashboard_users',array($current_user->ID));
}

function toast_contest ($mode) {
	global $post, $rsvp_options;
	$date = get_rsvp_date($post->ID);
	$contest_name = get_post_meta($post->ID,'toast_contest_name',true);
	$date = strftime($rsvp_options['long_date'],strtotime($date));
	$mycontests = get_permalink().'?scoring=mycontests';
	if(!is_user_logged_in())
		$mycontests = wp_login_url($mycontests);
	$output = '<div id="scoring">';		
	if($mode == 'dashboard')
	{
		$output .= '<div style="width: 150px;text-align: center; float: right; background-color: #FFFF99; padding: 5px;"><a href="'.$mycontests.'">My Contests</a></div>';
		$output .= '<h1>Scoring Dashboard - '.$date.' '.$post->post_title.'</h1>';
		$output .= toast_scoring_dashboard();
	}
	elseif($mode == 'voting')
	{
		$output .= '<div style="width: 150px;text-align: center; float: right; background-color: #FFFF99; padding: 5px;"><a href="'.$mycontests.'">My Contests</a></div>';
		$output .= '<h1>Voting - '.$date.' '.$post->post_title.'</h1>';
		$output .= toast_scoring_sheet();	
	}
	elseif($mode == 'mycontests')
		{
		$output .= '<h1>My Contests</h1>';
		$output .= wpt_mycontests();
		}
	else
		return "<div>Error: scoring mode not recognized</div>";
	$output .= '</div>';// close wrapper		
return $output;
}

//todo remove this after current crisis
function contest_user_fix() {
$future = get_future_events();
foreach($future as $event) {
	printf('<h1>%s %s</h1><div>%s</div>',$event->post_title,$event->date,var_export($event, true));

	$permalink = get_permalink($event->ID);
	$users = get_post_meta($event->ID,'tm_contest_dashboard_users',true);
	echo '<br />dashboard users';
	print_r($users);
	$users[] = $event->post_author;
	foreach($users as $user_id) {
		$userdata = get_userdata($user_id);
		$link = $permalink.'?scoring=dashboard';
		add_contest_userlink($user_id,$link,$event->ID);
		printf('<p>%s %s</p>',$userdata->display_name,$link);
		//update_post_meta($event->ID,'contest_link_'.$user_id,$permalink.'?scoring=dashboard');
	}
	$judges = get_post_meta($event->ID,'tm_scoring_judges',true);
	foreach($judges as $key => $user_id) {
		if(is_numeric($user_id))
			{
				$userdata = get_userdata($user_id);
				$link = $permalink.'?scoring=voting&judge='.$key;
				printf('<p>%s %s</p>',$userdata->display_name,$link);
				add_contest_userlink($user_id,$link,$event->ID);
				$users[] = $user_id;
			}
	}

	$timer = get_post_meta($event->ID,'contest_timer',true);
	if($timer) {
		$code = get_post_meta($event->ID,'tm_timer_code',true);
		$link = $permalink.'?timer=1&contest='.$code;
		add_contest_userlink($timer,$link,$event->ID);
		$userdata = get_userdata($timer);
		printf('<p>%s %s</p>',$userdata->display_name,$link);
		$users[] = $timer;
	}
	print_r($users);
}//end future
}

add_shortcode('wpt_contests_prompt','wpt_contests_prompt');
function wpt_contests_prompt ($atts) {
	if(is_user_logged_in())
		return sprintf('<p>Judges/Organizers: see <a href="%s">contest links</a></p>',get_permalink().'?scoring=mycontests');
	else
		return sprintf('<p>Judges/Organizers: <a href="%s">login</a> to see assignments</p>',wp_login_url(get_permalink().'?scoring=mycontests'));	
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
			if($_GET['debug'])
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

function toast_scoring_dashboard () {
ob_start();
global $post, $wpdb;
global $current_user;

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

$contest_selection['International Speech Contest'] = array('Speech Development' => 20,'Effectiveness' => 15,'Speech Value' => 15,'Physical' => 10,'Voice' => 10,'Manner' => 10,'Appropriateness' => 10,'Correctness' => 10);
$contest_selection['Video Speech Contest'] = array('Speech Development' => 20,'Effectiveness' => 15,'Speech Value' => 15,'Physical' => 10,'Voice' => 10,'Manner' => 10,'Appropriateness' => 10,'Correctness' => 10);
$contest_selection['Humorous Speech Contest'] = array('Speech Development' => 15,'Effectiveness' => 10,'Speech Value' => 15,'Audience Response' => 15,'Physical' => 10,'Voice' => 10,'Manner' => 10,'Appropriateness' => 10,'Correctness' => 5);
$contest_selection['Table Topics Contest'] = array('Speech Development' => 30,'Effectiveness' => 25,'Physical' => 15,'Voice' => 15,'Appropriateness' => 10,'Correctness' => 5);
$contest_selection['Evaluation Contest'] = array('Analytical Quality' => 40,'Recommendations' => 30,'Technique' => 15,'Summation' => 15);
$contest_selection['Mini-Webinar Contest'] = array('Speech Development' => 15,'Audience Engagement' => 15,'Speech Value' => 15,'Call to Action' => 15,'Visual' => 15,'Voice' => 10,'Manner' => 5,'Appropriateness/Correctness' => 10);

$contest_timing['International Speech Contest'] = '5 to 7';
$contest_timing['Video Speech Contest'] = '5 to 7';
$contest_timing['Humorous Speech Contest'] = '5 to 7';
$contest_timing['Table Topics Contest'] = '1 to 2';
$contest_timing['Evaluation Contest'] = '2 to 3';
$contest_timing['Mini-Webinar Contest'] = '6 to 8';
	
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
	if(!current_user_can('edit_others_posts'))
	{
	if(!is_array($dashboard_users))
		return '<p>Logged in user not recognized as a site administrator, chief judge, or ballot counter.</p>'.wpt_mycontests();
	if(!in_array($current_user->ID,$dashboard_users))
		return '<p>Logged in user not recognized as a site administrator, chief judge, or ballot counter.</p>'.wpt_mycontests();
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
$output .= '<p>Use this dashboard to pick a contest, add your list of contestants and judges, and generate personalized links to a page where each judge can score contestants and enter their votes.</p><p>As the judges vote, you will see their votes appear on the dashboard within seconds. If you have the Timer and Tiebreaking Judge record their work online, their input can also be factored in to show if any contestants were disqualified or how any ties were broken.</p>';
$output .= '<h1>Choose Contest</h1>'.sprintf('<form method="post" action="%s">
	<div>Contest:<br /><select name="contest_scoring">%s</select>
	%s
		<button>Set</button></div>
</form>
',$actionlink,$options,$syncrole);
	
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
<script>
jQuery(document).ready(function($) {
	
$('form#custom_contest').submit(function(){
	var score = 0;
	$('.setscore').each(function() {
		score += Number($(this).val());
	});
	if(score != 100)
		{
       $('#readyprompt').html('<span style="color: red;">Scores total '+score + ' (must total 100)</span>');
		return false;			
		}
	else
		$('#readyprompt').html('Saving ...');
}); 

});
</script>
<?php
$output .= ob_get_clean();

return $output;
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
	
if(isset($_POST['tm_scoring_dashboard_users']))
{
	$dashboard = add_query_arg('scoring','dashboard',get_permalink());
	if(empty($dashboard_users))
	$dashboard_users = array(); //reset
	foreach($_POST['tm_scoring_dashboard_users'] as $user_id)
		if($user_id && !in_array($user_id,$dashboard_users))
			{
			add_contest_userlink($user_id,$dashboard);
			//add_post_meta($post->ID,'contest_user',$user_id);
			//add_post_meta($post->ID,'contest_link_'.$user_id,$dashboard);
			$dashboard_users[] = $user_id;
			}
	update_post_meta($post->ID,'tm_contest_dashboard_users',$dashboard_users);
}

if(!empty($track_role))
{
	$miss = 0;
	$field_base = '_'.preg_replace('/[^a-zA-Z0-9]/','_',$track_role);
	for($i = 1; $i <20; $i++)
	{
		$lookup = $field_base.'_'.$i;
		$contestant = get_post_meta($post->ID,$lookup,true);
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
elseif(isset($_POST['contestant']))
	foreach($_POST['contestant'] as $contestant)
		if(!empty($contestant))
			$contestants[] = $contestant;
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
	foreach($_POST['judge'] as $index => $judge_id)
	{
		$judge_name = $_POST['judge_name'][$index];
		if(!empty($judge_name))
		{
			$judge[$index] = $judge_name;
		}
		elseif(!empty($judge_id)){
			$link = add_query_arg(array('scoring'=>'voting','judge'=>$index),get_permalink());
			add_contest_userlink($judge_id,$link);
			$judge[$index] = $judge_id;
		}
	}
if(!empty($judge))
{
	//print_r($judge);
	update_post_meta($post->ID,'tm_scoring_judges',$judge);	
}
}

if(empty($contestants))
	$contestants = get_post_meta($post->ID,'tm_scoring_contestants',true);
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
	//print_r($_POST['resetit']);
	rsvpmaker_debug_log($_POST['resetit'],'contest reset');
	rsvpmaker_debug_log(wp_get_current_user(),'contest reset by');

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
		echo '<p>Scores reset</p>';			
		}
		
		if($reset == 'judges')
			delete_post_meta($post->ID,'tm_scoring_judges');
		if($reset == 'order')
		{
		$order = $contestants;
		shuffle($order);
		update_post_meta($post->ID,'tm_scoring_order',$order);
		echo '<p>Speaking order reset</p>';			
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
}
elseif(!empty($order))
{
	echo '<h3>Speaking Order</h3>';
	foreach($order as $index => $next)
	{
		printf("<div>#%d %s</div>",$index + 1, $next);
	}

}

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
$checked = ($nolinks) ? '' : ' checked="checked" ';
echo '<h2>Voting Links</h2><p><input type="checkbox" id="showlinks" value="1" '. $checked .' /> Show Links</p><p class="votinglink">Share these personalized voting links with the judges.</p>';
foreach($judges as $key => $value)
{
	$v = $votinglink . '&judge='.$key;
		
	if(is_numeric($value))
	{
		$userdata = get_userdata($value);
		$name = $userdata->first_name.' '.$userdata->last_name;
		$username = $userdata->user_login;
	}
	else
	{
		$name = $value;
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
	echo '<h4>Voting Link for '.$name.'</h4>';
	if(!empty($username))
		printf('<p>This link is password protected, user name: <strong>%s</strong> | <a href="%s">Login</a> | <a href="%s">Set/Reset password</a></p>',$username,wp_login_url($v),wp_login_url().'?action=lostpassword');
	printf('<p><a target="_blank" href="%s">%s</a></p>',$v,$v);
	echo '</div>';
$dashboard_forms .= dashboard_vote($contestants, $key, $name, $actionlink, $is_tiebreaker);
}

echo '<div class="votinglink"><h3>Timer</h3>';
$timer_code = get_post_meta($post->ID,'tm_timer_code',true);
if(empty($timer_code))
{
	$timer_code = time()+rand(1,99);
	add_post_meta($post->ID,'tm_timer_code',$timer_code);
}
$timer_link = add_query_arg( array(
    'timer' => 1,
    'contest' => $timer_code,
), get_permalink($post->ID) );

$timer_user = (int) get_post_meta($post->ID,'contest_timer',true);
if($timer_user)
	{
		$user = get_userdata($timer_user);
		$username = $user->user_login;
		$name = $userdata->first_name.' '.$userdata->last_name;
		printf('<p>This link is password protected, user name: <strong>%s</strong> | <a href="%s">Login</a> | <a href="%s">Set/Reset password</a></p>',$username,wp_login_url($timer_link),wp_login_url().'?action=lostpassword');
	}
printf("<p>Use this link for the Timer's Report".'<br /><a target="_blank" href="%s">%s</a></p></div>',$timer_link,$timer_link);

echo "<h3>Backup Voting Forms</h3><p>If judges have problems with the online voting, you can record votes on their behalf.</p>";
echo '<p><input type="checkbox" id="showvotingforms" value="1" /> Show Forms</p><div class="votingforms">';
echo $dashboard_forms.'</div>';
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
?>
	<h2>Setup</h2>

    <h2 class="nav-tab-wrapper">
	<a class="nav-tab nav-tab-active" href="#contestants">Contestants</a>
	<a class="nav-tab" href="#judges">Judges and Timer</a>
      <a class="nav-tab" href="#security">Security</a>
      <!--a class="nav-tab" href="#judging-links">Judging Links</a-->
      <a class="nav-tab" href="#lock-reset">Lock/Unlock/Reset</a>
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
else {
?>	
	<form method="post" action="<?php echo $actionlink ?>" >
<?php
	if(is_array($judges))
	foreach($judges as $index => $value)
	{
		if(isset($_GET['debug']))
			printf('<div>%s %s</div>',$index,$value);
		if(is_numeric($value)) {
			$user = $value;
			$name = '';
			$open = 'Open';
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
		$drop = awe_user_dropdown ('judge['.$index.']', $user, true, $open);
		printf('<p>%s <input type="text" name="judge_name[%d]" value="%s"><br /><input type="radio" name="tm_tiebreaker" value="%s" %s />Tiebreaker</p>',$drop,$index,$name,$index,$s);
	}
	$t = time();	
	for($i= 0; $i < 10; $i++)
		{
		$index = $t+($i*100)+rand(1,99);
		$drop = awe_user_dropdown ('judge['.$index.']', 0, true);
		printf('<p>%s or guest: <input type="text" name="judge_name[%d]" value=""><br /><input type="radio" name="tm_tiebreaker" value="%s" />Tiebreaker</p>',$drop, $index,$index);
		}
	?>
	<p><em>You can assign up to 10 judges at a time. If you have more than 10 judges to assign, first submit the form with the first 10 assignments. When the page reloads, additional blanks will be displayed.</em></p>
	
	<h3>Timer</h3>
	<?php 
	$timer_user = (int) get_post_meta($post->ID,'contest_timer',true);
	echo '<p>'.awe_user_dropdown('contest_timer_user',$timer_user, true).'</p>';
	?>
	<h3>Judging Links</h3>
<p><input type="radio" name="hide_ballot_links" value="0" <?php if(empty($nolinks)) echo ' checked="checked" '; ?> /> Show judge ballot links</p>
<p><input type="radio" name="hide_ballot_links" value="1" <?php if(!empty($nolinks)) echo ' checked="checked" '; ?> /> Hide judge ballot links (if they're not being used)</p>
<?php
if(isset($_POST['ballot_no_password']))
{
	$ballot_no_password = (int) $_POST['ballot_no_password'];
	update_post_meta($post->ID,'ballot_no_password',$ballot_no_password);
}
else
	$ballot_no_password = get_post_meta($post->ID,'ballot_no_password',true);
?>
	<p><button>Submit</button></p>
</form>
	</section>
    <section class="rsvpmaker"  id="security">
	<form method="post" action="<?php echo $actionlink ?>" >
	<h3>Security Options</h3>
<p><input type="radio" name="ballot_no_password" value="0" <?php if(empty($ballot_no_password)) echo ' checked="checked" '; ?> /> User password required for access to ballot, timer's report form</p>
<p><input type="radio" name="ballot_no_password" value="1" <?php if(!empty($ballot_no_password)) echo ' checked="checked" '; ?> /> No password. Ballots protected by coded links</p>
<p><em>By default, a password is required for all voting forms associated with a user account. You may turn off password protection to make it easier for judges to access thier ballots, which will still be private as long as the link is only shared with the individual judges. This setting also applies to the timer's report. Guest judge links, created by entering a name rather than choosing a user account, are not password protected. The contest dashboard is always password protected.</em></p>
<h3>Dashboard Users</h3>
	<p>Add chief judge, ballot counters</p>
<?php
for($i= 0; $i < 5; $i++)
{
	$user = empty($dashboard_users[$i]) ? 0 : $dashboard_users[$i];
	$drop = awe_user_dropdown ('tm_scoring_dashboard_users[]', $user, true);//, $open);
	echo '<div>'.$drop.'</div>';
}
?>
	<p><button>Submit</button></p>
</form>
<?php } ?>
	</section>

    <!--section class="rsvpmaker" id="judging-links"-->
<?php
?>
	<!--/section -->
	<section id="lock-reset">
<form method="post" action="<?php echo $actionlink; ?>">
	<h2>Lock Settings</h2>
	<p>You can do this once the contest begins to disable the reset function or any other changing of settings while the contest is in progress.</p>
	<input type="hidden" name="contest_locked" value="1">
	<button>Lock</button>
</form>

<form method="post" action="<?php echo $actionlink; ?>">
	<h2>Reset</h2>
	<div><input type="checkbox" name="resetit[]" value="scores"> Scores</div>
	<div><input type="checkbox" name="resetit[]" value="order"> Speaking Order</div>
	<div><input type="checkbox" name="resetit[]" value="judges"> Judges List</div>
	<button>Reset</button>
</form>
	</section>
	</div><!--end of sections--->
</div>
<?php
judge_import_form($actionlink);
} //end test $is_locked
do_action('wpt_scoring_dashboard_bottom'); ?>
<p style="margin-top: 200px;"><a href="<?php echo $actionlink. '&reset_scoring=1'; ?>">Change Contest Type</a></p>

<script>
jQuery(document).ready(function($) {

$.ajaxSetup({
	headers: {
		'X-WP-Nonce': '<?php echo wp_create_nonce( 'wp_rest' );?>',
	}
});

function votingLinkToggle () {
	if($( "input#showlinks:checked" ).val()) {
	  $('.votinglink').show();
  }
  else {
	$('.votinglink').hide();
  }
}

function votingFormsToggle () {
	if($( "input#showvotingforms:checked" ).val()) {
	  $('.votingforms').show();
  }
  else {
	$('.votingforms').hide();
  }
}

var activetab = $('a.nav-tab-active').attr('href');
	if(activetab)
	{
		$('section').hide();
		$('section' + activetab).show();
	}
		
$(document).on( 'click', '.nav-tab-wrapper a', function() {
	$('section').hide();
	$('a').removeClass('nav-tab-active');
	$('section').eq($(this).index()).show();
	$(this).addClass('nav-tab-active');
	return false;
});

//check initial state of voting links
votingLinkToggle();
$( "input#showlinks" ).on( "click", votingLinkToggle);

votingFormsToggle();
$( "input#showvotingforms" ).on( "click", votingFormsToggle);

function refreshScores() {
$('#score_status').html('Checking for new scores ...');
$.get( "<?php echo site_url('?toast_scoring_update='.$post->ID); ?>", function( data ) {
  $( "#scores" ).html( data );
  $('#score_status').html('Updated');
});

$.get( "<?php echo site_url('/wp-json/wptcontest/v1/votecheck/'.$post->ID); ?>", function( data ) {
  //console.log( data );
  var hasvoted = '';
  var status = '';
  for (const property in data) {
	hasvoted = '#votestatus'+`${property}`;
if(data[property])
status = ' Has voted';
else
status = ' Has <span style="color:red;">NOT</span> voted';
$(hasvoted).html(status);
}
  //data.forEach(function(value, index) { console.log(index+': ');console.log(element+': '); });
});	

}
$('#scoreupdate').click(function() {
  refreshScores();
});

setInterval(function(){
  refreshScores();	
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

<?php
$output .= ob_get_clean();
return $output;
}

function toast_scoring_update_get($post_id) {
$judges = get_post_meta($post_id,'tm_scoring_judges',true);
if(empty($judges))
	return 'Judges not set';
$contestants = get_post_meta($post_id,'tm_scoring_contestants',true);
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
			foreach($votes as $i => $vote)
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
	$inc = 0.4;
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
			$top .= '<p>Tiebreaker vote applied</p>';
			foreach($tiebreaker_vote as $index => $contestant)
			{
				if(!empty($ranking[$contestant]))
					$ranking[$contestant] += $inc;
				$inc -= 0.01;
			}
			arsort($ranking);
		}		
	}

	foreach($ranking as $contestant => $points)
	{
		if(($topcount < 3) && ($points > 0))
			$top .= sprintf('<div>#%d %s</div>',$topcount+1,$contestant);
		if($points >= 0)
			$topscores .= sprintf('<div>%s (%d points)</div>',$contestant,$points);
		else
			$topscores .= sprintf('<div>%s (disqualified)</div>',$contestant,$points);			
		$topcount++;
	}
	$top .= $tiebreaker_status . $timer_report.'</div>';
	$output = $top . $topscores . $output;
}
return $output;
}

function toast_scores_check($post_id) {
	$judges = get_post_meta($post_id,'tm_scoring_judges',true);
	if(empty($judges))
		return array();
	$contestants = get_post_meta($post_id,'tm_scoring_contestants',true);
	if(empty($contestants))
		return array();
	
		foreach($judges as $index => $judge) {
			$votes = get_post_meta($post_id,'tm_scoring_vote'.$index,true);
			$vote_array[$index] = !empty($votes);
		}
	return $vote_array;
}//end toast_scores_check
	
function toast_scoring_update () {
	if(!isset($_GET['toast_scoring_update']))
		return;
	$update = toast_scoring_update_get($_GET['toast_scoring_update']);
	die($update);
}

add_action('init','toast_scoring_update');
  
function toast_scoring_sheet() {
ob_start();
//$contestants = array('Adrienne Williams','John M. Quick','Carol Prahinski','Louis Brown','Norman Dowe','G. Murali');
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

$contestants = get_post_meta($post->ID,'tm_scoring_contestants',true);
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
	//empty($ballot_no_password) && 
	if(empty($ballot_no_password) && ($current_user->ID != $judge_name) && !in_array($current_user->ID,$dashboard_users))
	{
	echo wpt_mycontests();
	printf('<p>You must <a href="%s">login</a> to access this judge\'s voting form.</p>',wp_login_url($_SERVER['REQUEST_URI']));
	return;
	}
	$userdata = get_userdata($judge_name);
	$judge_name = $userdata->first_name.' '.$userdata->last_name;	
	}
}
elseif( is_user_logged_in() )
{
	$id = $judge_id = array_search($current_user->ID,$judges);
	$name = $current_user->display_name;
	if( !$id)
		echo '<div style="color: red;">Logged in user is not on the list of judges</div>';
}

$votinglink .= '&judge='.$id;

$link = sprintf('<div id="agendalogin"><a href="%s">'.__('Login','rsvpmaker-for-toastmasters').'</a></div>',site_url().'/wp-login.php?redirect_to='.urlencode($votinglink));

if(! $id )
	return sprintf('<p>Before voting, you must either log in as a user authorized as a judge or access this page with a code provided for guest judges. %s</p>',$link).wpt_mycontests();
do_action('wpt_voting_form_top');
printf('<p><em>Voting Form for %s</em></p>',$judge_name);

if(isset($_POST['vote']))
	{
		update_post_meta($post->ID,'tm_scoring_vote'.$id,$_POST['vote']);
		rsvpmaker_debug_log($_POST,'contest_vote_submitted');
		//print_r($_POST);
	}
if(isset($_POST['scores']))
	update_post_meta($post->ID,'tm_subscore'.$id,$_POST['scores']);

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
	echo '<p>Keep this page open until you confirm your votes have been received properly.</p>';
	echo '<p><button>Resubmit</button></p>';
?>
<script>
jQuery(document).ready(function($) {

var dotdot = '...';

function refreshReceived() {
$.get( "<?php echo site_url('/wp-json/wptcontest/v1/votereceived/'.$post->ID.'/'.$id); ?>", function( data ) {
console.log(data);
if(data) {
	$('#gotvote_result').html('Votes received on ballot counting dashboard');
	stopRefreshReceived();
}
else
  $('#gotvote_result').html('Checking whether vote has been received'+dotdot);
  dotdot = dotdot.concat('.');
});	
}

var checkinterval = 1500 + Math.floor(Math.random()*1000);

//execute once
refreshReceived();

//then set timer
var gotvotetimer = setInterval(function(){
  refreshReceived();	
}, checkinterval);

function stopRefreshReceived() {
  clearInterval(gotvotetimer);
}

});
</script>
<?php
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
		echo '<p>Refresh this page once the contestant order has been set. To practice, you can use <a href="https://contest.toastmost.org/rsvpmaker/international-speech-contest-division-demo/?scoring=voting&judge=1584220677">this demo</a>.</p>';
?>
<div id="order_status"></div>
<script>
jQuery(document).ready(function($) {

function refreshOrder() {
$('#score_status').html('Checking for contestant order ...');
$.get( "<?php echo site_url('/wp-json/wptcontest/v1/order/'.$post->ID); ?>", function( data ) {
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
echo '<style>th {font-size: 10px;} .criteria {width: 50px;} .max {width: 25px} .score {width: 25px;} select {min-width: 50px;} table {max-width: 400px;}</style>';

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
	$o = '';
	for($i =0; $i <= $maxscore; $i++)
	{
		$s = (isset($tm_subscores[$category_count][$index]) && ($tm_subscores[$category_count][$index] == $i)) ? 'selected="selected" ' : '';
		if($i == $preselected)
			$s = 'selected="selected" ';
		$o .= sprintf('<option value="%d" %s>%d </option>',$i,$s,$i);
	}
	printf('<td class="score"><select name="scores[%s][%s]" contestant="%d" class="score score%d">%s</select> </td></tr>',$category_count,$index,$index,$index,$o);
	echo "\n";
	}//end foreach scoring
	echo '</table>';
	printf('<p><strong>Total <span id="sum%d">%s</span></strong></p>',$index,$score_me[$index]);
}//end foreach order

/*
echo '<table><tr><th>Criteria</th><th>Max&nbsp;&nbsp;</th>';
foreach($order as $index => $value)
	printf('<th><input type="hidden" id="contestant%d" value="%s">%s</th>',$index,$value,$value);
echo '</tr>';
$category_count = 0;
foreach($scoring as $category => $maxscore)
	{
	echo '<tr>';
	printf('<td>%s</td><td>%s</td>',$category,$maxscore);
	foreach($order as $index => $value)
		{
		$o = '';
		if(!isset($score_me[$index]))
			$score_me[$index] = 0;
		if(isset($tm_subscores[$category_count][$index]))
			$score_me[$index] += $tm_subscores[$category_count][$index];		   
		if(isset($_GET['demo'])) 
			$preselected = rand(2,$maxscore);
		else
			$preselected = 0;
		for($i =0; $i <= $maxscore; $i++)
		{
			$s = (isset($tm_subscores[$category_count][$index]) && ($tm_subscores[$category_count][$index] == $i)) ? 'selected="selected" ' : '';
			if($i == $preselected)
				$s = 'selected="selected" ';
			$o .= sprintf('<option value="%d" %s>%d </option>',$i,$s,$i);
		}
		printf('<td><select name="scores[%s][%s]" contestant="%d" class="score score%d">%s</select> </td>',$category_count,$index,$index,$index,$o);
		}
	echo '</tr>';
	$category_count++;
	}
echo '<tr><td></td><td><strong>Total<strong></td>';

foreach($order as $index => $value)
	printf('<td><strong><span id="sum%d">%s</span></strong></td>',$index,$score_me[$index]);

echo '</tr></table>';
*/
?>

<div id="autorank"><button id="autorank_now">Show Ranking</button></div>

<p>Use the scoresheet above to guide your vote. If two contestants have the same score, use your judgement to break the tie -- you must choose first, second, and third.</p>

<h2>Vote</h2>
<?php 
echo '<form id="voting" method="post" action="'.$votinglink.'">';	
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
?>
<input type="checkbox" id="readytovote" value="1" /> Record these choices as the vote of <?php echo $judge_name; ?>
<div id="readyprompt"></div>
<input type="hidden" name="judge_id" value="<?php echo $id; ?>" />
<button>Vote</button>
</form>

<script>
jQuery(document).ready(function($) {

var scoreArr = [];

<?php
foreach($order as $index => $value)
	printf("
scoreArr[%d] = {
	'index' : %d,
	'score' : 0
}	
",$index,$index);
?>

$('#autorank_now').click(function() {
var autorank = '';
scoreArr.sort(function (a, b) {return b.score - a.score});

var arrayLength = scoreArr.length;
for (var i = 0; i < arrayLength; i++) {
	var name = $('#contestant' + scoreArr[i].index).val();
	autorank = autorank + '<br />'+name + ' '+scoreArr[i].score;
}
$('#autorank').html('<div style="width: 300px; margin-bottom: 10px; padding: 5px; border: thin solid #555;"><h3>Best Scores</h3>'+autorank+'</div>');

});
	
$('.score').on('change', function(){

var contestant = $(this).attr('contestant');
var score = 0;
$('.score' + contestant).each(function() {
	score += Number($(this).val());
});
$('#sum' + contestant).html(score);

scoreArr[contestant] = {
	'index' : contestant,
	'score' : score
}

scoreArr[contestant].score = score;
});

let findDuplicates = arr => arr.filter((item, index) => arr.indexOf(item) != index);

/*
$('.voteselect').change(function(){
	var votes = $('.voteselect');
	console.log(votes);
	let findDuplicates = arr => arr.filter((item, index) => arr.indexOf(item) != index);
	//let dups = findDuplicates(votes);
	//if(dups) {
		$("#readyprompt").html('<span style="color: red;">You cannot vote for the same contestant twice.</span>');
		console.log('duplicates:');
		//console.log(dups);
		//return false;
	//}
}); 
*/

$('form#voting').submit(function(){
	var empty = false;
	var votes = $('.voteselect');
	var checkvotes = [];
	votes.each(function() {
		checkvotes.push($(this).val());
		if($(this).val() == '')
		{
			empty = true;
		}

	});
	if(empty)
		{
       $("#readyprompt").html('<span style="color: red;">One or more votes left blank</span>');
		return false;			
		}

    if (! $('#readytovote').is(':checked')){
       $("#readyprompt").html('<span style="color: red;">You must check the checkbox first</span>');
       return false;
	}
	
	let findDuplicates = arr => arr.filter((item, index) => arr.indexOf(item) != index);
	let dups = findDuplicates(checkvotes);
	if(dups.length) {
		$("#readyprompt").html('<span style="color: red;">You cannot vote for the same contestant twice.</span>');
		console.log('duplicates:');
		console.log(dups);
		return false;
	}
});

});
</script>
<?php
return ob_get_clean();
}

function dashboard_vote($contestants, $id, $judge_name, $votinglink, $tiebreaker=false) {
	ob_start();
	if($tiebreaker)
		$judge_name = 'Tie Breaker';
	echo '<h3>'.$judge_name.'</h3><div id="votestatus'.$id.'"></div>';
	echo '<form class="dashboard_votes" id="voting" method="post" action="'.$votinglink.'">';	
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
			if(!in_array($current_user->ID,$contest_users))
				continue;
			$date = get_rsvp_date($event->ID);
			$opt .= sprintf('<option value="%d">%s %s</option>',$event->ID,$event->post_title,rsvpmaker_strftime('',$date));
		}
		if(!empty($opt))
			printf('<form action="%s" method="post"><h3>Import judges/settings (optional)</h3><p><select name="importfrom">%s</select></p>
			<p>If the list of judges will be the same (or mostly the same) as for another contest, you can import those settings rather than setting them individually.</p>
			<button>Import</button></form>',$action,$opt);
	}	
}

function track_roles_ui($track_role = '') {
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

return sprintf('<p>Sync With Agenda Role for Contestants <br /><select id="track_role" name="track_role" >%s<option value="cancel">Cancel Selection</option></select></p>',$track_top.$track);

}

}

?>