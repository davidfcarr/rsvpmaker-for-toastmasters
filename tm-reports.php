<?php

/*
toastmasters_reports_menu()
tm_member_edit()
toastmasters_screen ()
toastmasters_reports ()
awesome_get_stats ($userdata)
get_latest_speeches ($user_id, $myroles = array())
toastmasters_reconcile ()
toastmasters_attendance ()
toastmasters_attendance_report()
awesome_get_attendance($user_id)
get_speech_role_count ($user_id, $check_history = true)
toastmasters_cc()
tm_barhtml($count,$target)
toastmasters_advanced ()
get_advanced_projects ()
is_requirement_met($user_id, $choices, $goal, $echo = true)
cl_report ()
cl_progress ($userdata)
cl_project_gaps ($userdata)
get_latest_visit ($user_id)
last_filled_role ($user_id, $role)
toastmasters_mentors()
toastmasters_edit_stats()
import_fth ()
toastmasters_activity_log()
toastmasters_progress_report($user_id)
my_progress_report ()
member_list ()
tm_welcome_screen_assets( $hook )
tm_member_welcome_redirect()
tm_welcome_screen_pages()
toastmasters_welcome()
tm_welcome_screen_remove_menus()
toastmasters_support()
tm_reports_disclaimer ($extra = '')
tm_admin_page_top($headline)
tm_admin_page_bottom($hook = '')
*/

add_action( 'admin_menu', 'toastmasters_reports_menu' );
add_action('admin_menu','tm_welcome_screen_pages');
add_action( 'admin_enqueue_scripts', 'tm_welcome_screen_assets' );
add_action('admin_init', 'tm_member_welcome_redirect');
add_action( 'admin_head', 'tm_welcome_screen_remove_menus' );

function toastmasters_reports_menu() {
global $current_user;	
$security = get_tm_security ();	
$beta = get_option('wp4toastmasters_beta');

add_menu_page(__('Toastmasters','rsvpmaker-for-toastmasters'), __('Toastmasters','rsvpmaker-for-toastmasters'), 'read', 'toastmasters_screen', 'toastmasters_screen',plugins_url('rsvpmaker-for-toastmasters/toastmasters-20.png'),'2.01');
add_submenu_page( 'toastmasters_screen', __('Update History','rsvpmaker-for-toastmasters'), __('Update History','rsvpmaker-for-toastmasters'), $security['edit_member_stats'], 'toastmasters_reconcile', 'toastmasters_reconcile');

add_submenu_page( 'toastmasters_screen', __('My Progress','rsvpmaker-for-toastmasters'), __('My Progress','rsvpmaker-for-toastmasters'), 'read', 'my_progress_report', 'my_progress_report');
add_submenu_page('toastmasters_screen',__('Progress Reports','rsvpmaker-for-toastmasters'), __('Progress Reports','rsvpmaker-for-toastmasters'), $security['view_reports'], 'toastmasters_reports', 'toastmasters_reports',plugins_url('rsvpmaker-for-toastmasters/toastmasters-20.png'),'2.01');
add_submenu_page( 'toastmasters_screen', __('Competent Communicator Progress Report','rsvpmaker-for-toastmasters'), __('CC Progress','rsvpmaker-for-toastmasters'), $security['view_reports'], 'toastmasters_cc', 'toastmasters_cc');
add_submenu_page( 'toastmasters_screen', __('Competent Leader Progress Report','rsvpmaker-for-toastmasters'), __('CL Progress','rsvpmaker-for-toastmasters'), $security['view_reports'], 'cl_report', 'cl_report');
add_submenu_page( 'toastmasters_screen', __('Advanced Awards Progress Report','rsvpmaker-for-toastmasters'), __('Advanced Awards','rsvpmaker-for-toastmasters'), $security['view_reports'], 'toastmasters_advanced', 'toastmasters_advanced');

add_submenu_page( 'toastmasters_screen', __('Evaluations','rsvpmaker-for-toastmasters'), __('Evaluations','rsvpmaker-for-toastmasters'), 'read', 'wp4t_evaluations', 'wp4t_evaluations');
add_submenu_page( 'toastmasters_screen', __('Edit Evaluation Forms','rsvpmaker-for-toastmasters'), __('Edit Evaluation Forms','rsvpmaker-for-toastmasters'), 'edit_others_rsvpmakers', 'wp4t_evaluations_edit', 'wp4t_evaluations_edit');

add_submenu_page( 'toastmasters_screen', __('Member List','rsvpmaker-for-toastmasters'), __('Member List','rsvpmaker-for-toastmasters'), 'view_contact_info', 'contacts_list', 'member_list');

add_submenu_page( 'toastmasters_screen', __('Attendance Report','rsvpmaker-for-toastmasters'), __('Attendance Report','rsvpmaker-for-toastmasters'), $security['view_attendance'], 'toastmasters_attendance_report', 'toastmasters_attendance_report');

add_submenu_page( 'toastmasters_screen', __('Edit Stats','rsvpmaker-for-toastmasters'), __('Edit Member Stats','rsvpmaker-for-toastmasters'), $security['edit_member_stats'], 'tm_member_edit', 'tm_member_edit');
add_submenu_page( 'toastmasters_screen', __('Add Speech','rsvpmaker-for-toastmasters'), __('Add Speech','rsvpmaker-for-toastmasters'), $security['edit_member_stats'], 'add_member_speech', 'add_member_speech');

add_submenu_page( 'toastmasters_screen', __('Record Attendance','rsvpmaker-for-toastmasters'), __('Record Attendance','rsvpmaker-for-toastmasters'), $security['edit_member_stats'], 'toastmasters_attendance', 'toastmasters_attendance');
add_submenu_page( 'toastmasters_screen', __('Mentors','rsvpmaker-for-toastmasters'), __('Mentors','rsvpmaker-for-toastmasters'), $security['edit_member_stats'], 'toastmasters_mentors', 'toastmasters_mentors');
add_submenu_page( 'toastmasters_screen', __('Track Dues','rsvpmaker-for-toastmasters'), __('Track Dues','rsvpmaker-for-toastmasters'), $security['edit_member_stats'], 'toastmasters_dues', 'toastmasters_dues');
add_submenu_page( 'toastmasters_screen', __('Activity Log','rsvpmaker-for-toastmasters'), __('Activity Log','rsvpmaker-for-toastmasters'), $security['edit_member_stats'], 'toastmasters_activity_log', 'toastmasters_activity_log');
add_submenu_page( 'toastmasters_screen', __('Import Free Toast Host Data','rsvpmaker-for-toastmasters'), __('Import Free Toast Host Data','rsvpmaker-for-toastmasters'), 'manage_options', 'import_fth', 'import_fth');
add_submenu_page( 'toastmasters_screen', __('Import/Export','rsvpmaker-for-toastmasters'), __('Import/Export','rsvpmaker-for-toastmasters'), 'manage_options', 'import_export', 'toastmasters_import_export');
//add_submenu_page( 'toastmasters_screen', __('Sync','rsvpmaker-for-toastmasters'), __('Sync','rsvpmaker-for-toastmasters'), 'manage_options', 'wpt_json', 'wpt_json');

add_submenu_page( 'toastmasters_screen', __('Support This Project','rsvpmaker-for-toastmasters'), __('Support This Project','rsvpmaker-for-toastmasters'), 'read', 'toastmasters_support', 'toastmasters_support');

add_action( 'admin_enqueue_scripts', 'toastmasters_css_js' );

}

function agenda_setup () {
global $wpdb;
$event_options = $template_options = '';
if($_POST)
{
		
	$post_id = (int) $_POST["post_id"];
	$permalink = get_permalink($post_id);
	$agenda_link = rsvpmaker_permalink_query($post_id, 'print_agenda=1');

printf('<div id="message" class="updated">
		<p><strong>'.__("Meeting Agenda updated",'rsvpmaker-for-toastmasters').'.</strong> <a href="%s">'.__("View Form",'rsvpmaker-for-toastmasters').'</a> | <a href="%s">'.__("View Agenda",'rsvpmaker-for-toastmasters').'</a></p>
	</div>',$permalink, $agenda_link);
	
	$my_post = array(
      'ID'           => $post_id,
      'post_title' => $_POST["post_title"],
      'post_content' => $_POST["post_content"]
  );
   wp_update_post( $my_post );
if(isset($_POST["_tm_sidebar"]))
	tm_sidebar_post($post_id);
if(isset($_POST["enable_sidebar_layout"]) && $_POST["enable_sidebar_layout"])
	update_option("wp4toastmasters_agenda_layout",'sidebar');
}

	if(isset($_POST["sked"]))
		{
				echo rsvp_template_update_checkboxes($post_id);
		}

if(isset($_GET["post_id"]))
{
$post_id = (int) $_GET["post_id"];
global $post;
$post = get_post($post_id);
global $agenda_setup_item;
echo admin_link_menu();
?>
<form id="agenda_form" method="post" action = "<?php echo admin_url('edit.php?post_type=rsvpmaker&page=agenda_setup&post_id='.$post_id); ?>">
<input type="hidden" name="post_id" value="<?php echo $post_id; ?>" />

<h1><?php _e("Title",'rsvpmaker-for-toastmasters');?>: <input type="text" name="post_title" value="<?php echo $post->post_title; ?>" size="30" /></h1>
<?php shortcode_eventdates($post->ID); ?>

<div style="float: right; width: 225px; padding: 5px; background-color: #fff; margin-left:5px;"><img src="<?php echo plugins_url('rsvpmaker-for-toastmasters/mce/toastmasters_editor_buttons.png')?>" /><br /><em>Toastmasters custom buttons</em></div>

<p><em><?php _e("You can drag-and-drop to reorder roles or add new roles using the Toastmasters Roles button. Double-click on the placeholder for a role to edit options. Setting the count for a role to more than one opens up multiple signup slots (for example, multiple speakers and multiple evaluators). Your choices determine the roles that will appear on the online signup form, the printable signup form, and the agenda.",'rsvpmaker-for-toastmasters');?></em></p>
<p><em><?php _e("Use the Agenda Note button to provide additional 'stage directions' that will appear on thet agenda. You can specify whether this text should appear on the agenda only, on the signup form only, or both.",'rsvpmaker-for-toastmasters');?></em></p>
<div style="clear:both;"></div>
<?php
// include wp_editor with shortcode representation

	$editor_id = "post_content";
	$settings = array();
	wp_editor( $post->post_content, $editor_id, $settings );

$layout = get_option("wp4toastmasters_agenda_layout");
if($layout == 'sidebar')
{
echo agenda_sidebar_editor ($post->ID);
	if(isset($template_id))
		printf('<input type="hidden" name="template_sidebar" value="%d" /> ',$template_id);
	echo '<input type="hidden" name="option_sidebar" value="1" /> ';
}
else
	echo '<p><input type="checkbox" name="enable_sidebar_layout" value="1" /> '.__('Enable agenda layout with sidebar','rsvpmaker-for-toastmasters').'</p>';

?>
<input type="hidden" id="order" name="order" value="<?php for($i = 0; $i <= $agenda_setup_item; $i++) { if($i > 0) echo ","; echo "item_".$i; } ?>">
<?php submit_button(); ?>
</form>
<?php
}
else
{
		$dayarray = Array(__("Sunday",'rsvpmaker'),__("Monday",'rsvpmaker'),__("Tuesday",'rsvpmaker'),__("Wednesday",'rsvpmaker'),__("Thursday",'rsvpmaker'),__("Friday",'rsvpmaker'),__("Saturday",'rsvpmaker'));
		$weekarray = Array(__("Varies",'rsvpmaker'),__("First",'rsvpmaker'),__("Second",'rsvpmaker'),__("Third",'rsvpmaker'),__("Fourth",'rsvpmaker'),__("Last",'rsvpmaker'),__("Every",'rsvpmaker'));
	
			$sql = "SELECT *, $wpdb->posts.ID as postID
FROM $wpdb->postmeta
JOIN $wpdb->posts ON $wpdb->postmeta.post_id = $wpdb->posts.ID
WHERE meta_key='_sked' AND post_content LIKE '%[toastmaster%' AND post_status='publish'";
			
		$results = $wpdb->get_results($sql);
		if($results)
		foreach ($results as $r)
			{
			$sked = unserialize($r->meta_value);

		//backward compatability
		if(is_array($sked["week"]))
			{
				$weeks = $sked["week"];
				$dows = $sked["dayofweek"];
			}
		else
			{
				$weeks = array();
				$dows = array();
				$weeks[0] = (isset($sked["week"])) ? $sked["week"] : 0;
				$dows[0] = (isset($sked["dayofweek"])) ? $sked["dayofweek"] : 0;
			}

		$dayarray = Array(__("Sunday",'rsvpmaker'),__("Monday",'rsvpmaker'),__("Tuesday",'rsvpmaker'),__("Wednesday",'rsvpmaker'),__("Thursday",'rsvpmaker'),__("Friday",'rsvpmaker'),__("Saturday",'rsvpmaker'));
		$weekarray = Array(__("Varies",'rsvpmaker'),__("First",'rsvpmaker'),__("Second",'rsvpmaker'),__("Third",'rsvpmaker'),__("Fourth",'rsvpmaker'),__("Last",'rsvpmaker'),__("Every",'rsvpmaker'));
		$s = '';
		if((int)$weeks[0] == 0)
			$s = __('Schedule Varies','rsvpmaker');
		else
			{
			foreach($weeks as $week)
				{
				if(!empty($s))
					$s .= '/ ';
				$s .= $weekarray[(int) $week].' ';
				}
			foreach($dows as $dow)
				$s .= $dayarray[(int) $dow] . ' ';	
			}

			$template_options .= sprintf('<option value="%d">%s (%s)</option>',$r->postID,$r->post_title,$s);
			}

		$sql = "SELECT DISTINCT $wpdb->posts.ID as postID, $wpdb->posts.*, a1.meta_value as datetime
	 FROM ".$wpdb->posts."
	 JOIN ".$wpdb->postmeta." a1 ON ".$wpdb->posts.".ID =a1.post_id AND a1.meta_key='_rsvp_dates'
	 WHERE a1.meta_value >= '".date('Y-m')."-1' AND $wpdb->posts.post_content LIKE '%[toastmaster%' AND $wpdb->posts.post_status = 'publish' ORDER BY a1.meta_value LIMIT 0,100";
		$results = $wpdb->get_results($sql);
		if($results)
		foreach ($results as $r)
			{
			$event_options .= sprintf('<option value="%d">%s %s</option>',$r->postID,$r->post_title,$r->datetime);
			}
			
		$action = admin_url('edit.php');
		
		printf('<form method="get" action="%s"><p>'.__("Get Agenda For",'rsvpmaker-for-toastmasters').' <select name="post_id"><optgroup label="'.__("Templates",'rsvpmaker-for-toastmasters').'">%s</optgroup><optgroup label="'.__("Events",'rsvpmaker-for-toastmasters').'">%s</optgroup></select>
<input type="hidden" name="post_type" value="rsvpmaker" /><input type="hidden" name="page" value="agenda_setup" />		
		</p>',$action, $template_options, $event_options);
		submit_button(__('Get Agenda','rsvpmaker-for-toastmasters'));
		echo '</form>';

		printf('<form method="put" action="%s">',$action);
		submit_button(__('Make New Agenda Template','rsvpmaker-for-toastmasters'));
		echo '</form>';

}

}

function wp_ajax_add_speech () {
	$user_id = $_REQUEST['user_id'];
	add_member_speech($user_id);
	die();
}
add_action('wp_ajax_add_speech','wp_ajax_add_speech');

function wp_ajax_remove_meta_speech () {
global $wpdb;
	$user_id = $_REQUEST['user_id'];
	$project = $_REQUEST['project'];
	$sql = "DELETE FROM $wpdb->usermeta WHERE user_id=$user_id AND meta_key='Speaker' AND meta_value LIKE '%".$project."%' ";
	$wpdb->query($sql);
	die($sql);
}
add_action('wp_ajax_remove_meta_speech','wp_ajax_remove_meta_speech');


function tm_select_member ($page,$field) {
	$user_id = (isset($_REQUEST[$field])) ? $_REQUEST[$field] :  0;
	printf('<form method="get" action="%s" id="tm_select_member"><input type="hidden" id="tm_page" name="page" value="%s" />',admin_url('admin.php'),$page);
	echo awe_user_dropdown($field,$user_id, true,__('Select Member','rsvpmaker-for-toastmasters'));
	echo '<button>'.__('Get','rsvpmaker-for-toastmasters').'</button>';
	echo '</form>';
	return $user_id;
}

function add_member_speech ($user_id = 0) {
if(!$user_id)
	{
		echo 'Select member from the list above';
		return;
	}
global $rsvp_options;
if(isset($_POST["_manual_meta"]))
{
$manual = $_POST["_manual_meta"];
$p = $_POST['_project_meta'];
$speech_title = $_POST['_title_meta'];
$intro = $_POST['_intro_meta'];
$projectslug = preg_replace('/[ _]/','',$manual)."_project";
$year = $_POST['project_year'];
$month = $_POST['project_month'];
$day = $_POST['project_day'];
if($year && $month && $day)
	$date = strtotime($year.'-'.$month.'-'.$day);
else
	$date = time();
$project_text = (empty($p)) ? '' : get_project_text($p);

//new data model
$key = make_tm_usermeta_key ('Speaker_'.time(), date('Y-m-d G:i:s',$date), 0);
$roledata = make_tm_speechdata_array (make_tm_roledata_array('add_member_speech'), $manual, $p, $speech_title, $intro);
update_user_meta($user_id,$key,$roledata);

$speech_url = admin_url('admin.php?page=toastmasters_reports&tab=speeches&toastmaster='.$user_id);

echo '<em>'.__('Saved:','rsvpmaker-for-toastmasters').' '.$manual.' '.$project_text.' '.$speech_title.' for '.date('F j, Y',$date).'</em> ';
printf('<a href="%s">%s</a>',$speech_url,__('Refresh speech list','rsvpmaker-for-toastmasters'));
}
elseif(isset($_POST["_role_meta"]))
{
$role = $_POST["_role_meta"];
$year = $_POST['year'];
$month = $_POST['month'];
$day = $_POST['day'];
if($year && $month && $day)
	$date = strtotime($year.'-'.$month.'-'.$day);
else
	$date = time();

$key = make_tm_usermeta_key ($role.'_'.time(), date('Y-m-d G:i:s',$date), 0);
update_user_meta($user_id,$key,$roledata);

$speech_url = admin_url('admin.php?page=toastmasters_reports&toastmaster='.$user_id);

echo '<em>'.__('Saved:','rsvpmaker-for-toastmasters').' '.$role.' for '.date('F j, Y',$date).'</em> ';
printf('<a href="%s">%s</a>',$speech_url,__('Refresh to see changes','rsvpmaker-for-toastmasters'));
}
elseif($user_id)
{
global $post;
$post = (object) array('ID' => 0); // fake post object, expected by speaker_details function
printf('<div id="add_speech_div"><h2>%s</h2><form id="add_speech_form" method="post" action="%s"><input type="hidden" name="member" id="member" value="%d" /><input type="hidden" name="add_speech" value="1" />',__('Add Speech'),admin_url('admin.php?page=add_member_speech'),$user_id);
echo str_replace('[]','_meta',speaker_details('',0,array() ));
printf('<div>%s: <input name="project_month" id="project_month_add" size="4" value="%s" /> %s: <input name="project_day" id="project_day_add" size="4" value="%s" /> %s: <input name="project_year" id="project_year_add" size="8" value="%s" /></div>',__('Month','rsvpmaker-for-toastmasters'), date('m'), __('Day','rsvpmaker-for-toastmasters'), date('d'), __('Year','rsvpmaker-for-toastmasters'), date('Y'));
submit_button(__('Save','rsvpmaker-for-toastmasters'));
echo '</form></div><div id="add_speech_status"></div>';

global $toast_roles;
global $competent_leader;
$projects = get_advanced_projects ();
$role_list = '';
foreach($toast_roles as $role)
	$role_list .= '<option value="'.$role.'">'.$role.'</option>';
foreach($competent_leader as $role)
	$role_list .= '<option value="'.$role.'">'.$role.'</option>';
foreach($projects as $code => $role)
	$role_list .= '<option value="'.$code.'">'.$role.'</option>';

printf('<div id="add_role_div"><h2>%s</h2><form id="add_role_form" method="post" action="%s"><input type="hidden" name="member" id="member" value="%d" /><input type="hidden" name="add_speech" value="1" />',__('Add Role'),admin_url('admin.php?page=add_member_speech'),$user_id);
printf('<p><select name="_role_meta" id="_role_meta">%s</select></p>',$role_list);
printf('<div>%s: <input name="project_month" id="project_month_add" size="4" value="%s" /> %s: <input name="project_day" id="project_day_add" size="4" value="%s" /> %s: <input name="project_year" id="project_year_add" size="8" value="%s" /></div>',__('Month','rsvpmaker-for-toastmasters'), date('m'), __('Day','rsvpmaker-for-toastmasters'), date('d'), __('Year','rsvpmaker-for-toastmasters'), date('Y'));
submit_button(__('Save','rsvpmaker-for-toastmasters'));
echo '</form></div><div id="add_role_status"></div>';

}

}

function tm_member_edit($id = 0) {
if(!$id)
{
?>
Select member from the list above
</section>
<section id="edit_stats_count">
Select member from the list above
<?php
return;
}
global $wpdb;
$wpdb->show_errors();
$manuals = get_manuals_array();
global $toast_roles;
global $competent_leader;
$projects = get_advanced_projects ();

$project_options_array = get_projects_array('options');
if(isset($_REQUEST['toastmaster']) && $_REQUEST['toastmaster'])
	$id = (int) $_GET['toastmaster'];
if($id)
{
	$userdata = get_userdata($id);
	$tmstats = get_tm_stats($userdata->ID);
	$stats = $tmstats["count"];

	if(isset($_GET["debug"]))
	{
	echo "<p>";
	print_r($stats);
	echo "<br />Pure:";
	print_r($tmstats["pure_count"]);
	echo "</p>";
	}
	echo '<h2>'.__('Edit Details','rsvpmaker-for-toastmasters').': '.$userdata->first_name.' '.$userdata->last_name.'</h2>';
	echo $tmstats['editdetail'];
?>
</section>
<section id="edit_stats_count">
<?php
	if($_GET["page"] == 'tm_member_edit')
	tm_select_member('tm_member_edit','toastmaster');
	$hook = tm_admin_page_top(__('Edit Overview Stats','rsvpmaker-for-toastmasters').': '.$userdata->first_name.' '.$userdata->last_name);

	if(isset($_POST["stat"]))
		{
			$stats = $tmstats["pure_count"];
			if(!empty($_POST['education_awards']))
				update_user_meta($id,'education_awards',$_POST['education_awards']);
			foreach($_POST["stat"] as $field => $value)
				{
				if(($value == '') || ($value == 0))
					{
					delete_user_meta($id,'tmstat:'.$field);
					continue;
					}
				if(empty($stats[$field])) $stats[$field] = 0;
				$adj = $value - $stats[$field];
				if($adj == 0)
					delete_user_meta($id,'tmstat:'.$field);
				else
					update_user_meta($id,'tmstat:'.$field,$adj);
				}
			foreach($_POST["add_project"] as $manual => $p)
				{
				if(!empty($p))
					{
						$projectslug = preg_replace('/[ _]/','',$manual)."_project";
						$year = $_POST['project_year'][$manual];
						$month = $_POST['project_month'][$manual];
						$day = $_POST['project_day'][$manual];
						if($year && $month && $day)
							$date = strtotime($year.'-'.$month.'-'.$day);
						else
							$date = time();
					$text = get_project_text($p);
					$pa = array('title' => $text, 'date' => $date, 'source' => 'meta');
					add_user_meta($id,$projectslug,$pa);
					}					
				}
		if(isset($_POST["delete_meta"]))
			{
				foreach($_POST["delete_meta"] as $deletethis)
				{
					$deletethis = str_replace(' ','_',$deletethis);
					delete_user_meta($id,$deletethis);

					echo "delete $deletethis <br />";
				}
			}

		echo '<div class="updated"><p>'.__('Updated','rsvpmaker-for-toastmasters').'</p></div>';
		}
	
	// refresh the list now that changes have been posted
	$stats = awesome_get_stats($userdata->ID);

	printf('<form method="post" id="edit_member_stats" action="%s"><input type="hidden" name="action" value="edit_member_stats" /><input type="hidden" name="toastmaster" value="%s" />',admin_url('admin.php?page='.$_GET["page"].'&toastmaster=').$id,$id);
	
	echo '<table>';
	printf('<tr><td>Educational Awards</td><td><input type="text" size="10" name="education_awards" value="%s"><br />Use the abbreviations CC,  ACB, ACS, ACG, CL, ALB, ALS, DTM</td><td></td></tr>',$userdata->education_awards);
	foreach($manuals as $role => $display)
		{
			$stat = (isset($stats[$role])) ? $stats[$role] : 0;
			$pure = (isset($tmstats["pure_count"][$role])) ? $tmstats["pure_count"][$role] : 0;
			$difftext = ($stat != $pure) ? sprintf('detailed records: %s, adjustment: %s',$pure, ($stat - $pure)) : '';
			printf('<tr><td>%s</td><td><input type="text" size="4" name="stat[%s]" value="%s"></td><td>%s</td></tr>',$display,$role,$stat,$difftext);
		}
	foreach($toast_roles as $role)
		{
			$stat = (isset($stats[$role])) ? $stats[$role] : 0;
			$pure = (isset($tmstats["pure_count"][$role])) ? $tmstats["pure_count"][$role] : 0;
			$difftext = ($stat != $pure) ? sprintf('detailed records: %s, adjustment: %s',$pure, ($stat - $pure)) : '';
			printf('<tr><td>%s</td><td><input type="text" size="4" name="stat[%s]" value="%s"></td><td>%s</td></tr>',$role,$role,$stat,$difftext);
		}
	foreach($competent_leader as $role)
		{
			$stat = (isset($stats[$role])) ? $stats[$role] : 0;
			$pure = (isset($tmstats["pure_count"][$role])) ? $tmstats["pure_count"][$role] : 0;
			$difftext = ($stat != $pure) ? sprintf('detailed records: %s, adjustment: %s',$pure, ($stat - $pure)) : '';
			printf('<tr><td>%s</td><td><input type="text" size="4" name="stat[%s]" value="%s"></td><td>%s</td></tr>',$role,$role,$stat,$difftext);
		}
	echo '</table>';
	foreach($projects as $key => $project)
		{
			$s = (empty($stats[$key])) ? '' : ' checked="checked" ';
			printf('<p><input type="checkbox" name="stat[%s]" value="1" %s> %s</p>',$key,$s,$project);
		}

submit_button('Save Changes','primary','edit_stats');
printf('<input type="hidden" name="edit" id="edit" value="%d"></form>',$id);

}// edit member
elseif(isset($_GET["edit_all"]))
{
$users = get_users();
foreach($users as $user) {
$ud = get_userdata($user->ID);
$tmstats = get_tm_stats($user->ID);
$listing[$ud->last_name.$ud->first_name] = '<h2>'.$ud->first_name.' '.$ud->last_name."</h2>\n".$tmstats['editdetail'];
}
ksort($listing);
echo implode("\n",$listing);
}
else
	printf('<p><a href="%s">%s</a></p>',admin_url('admin.php?page=toastmasters_reports&edit_all#edit'),__('Show editable data for all members','rsvpmaker-for-toastmasters'));
//tm_admin_page_bottom($hook);
}

function toastmasters_screen () {
$hook = tm_admin_page_top(__('Toastmasters','rsvpmaker-for-toastmasters'));

awesome_dashboard_widget_function();
tm_admin_page_bottom($hook);
} // end toastmasters_screen

$toast_roles = array(
'Ah Counter',
'Body Language Monitor',
'Evaluator',
'General Evaluator',
'Grammarian',
'Humorist',
'Speaker',
'Topics Master',
'Table Topics',
'Timer',
'Toastmaster of the Day',
'Vote Counter');

$competent_leader = array(
"Help Organize a Club Speech Contest",
"Help Organize a Club Special Event",
"Help Organize a Club Membership Campaign or Contest",
"Help Organize a Club PR Campaign",
"Help Produce a Club Newsletter",
"Assist the Club’s Webmaster",
"Befriend a Guest",
"PR Campaign Chair",
"Mentor for a New Member",
"Mentor for an Existing Member",
"HPL Guidance Committee Member",
"Membership Campaign Chair",
"Club PR Campaign Chair",
"Club Speech Contest Chair",
"Club Special Event Chair",
"Club Newsletter Editor",
"Club Webmaster");

function toastmasters_reports () {
if($_GET["page"] == 'my_progress_report')
	{
	$hook = tm_admin_page_top(__('Progress Reports','rsvpmaker-for-toastmasters'));
	global $current_user;
	$user_id = $current_user->ID;
	}
else
	{
	$hook = tm_admin_page_top(__('Progress Reports','rsvpmaker-for-toastmasters'));
	$user_id = tm_select_member('toastmasters_reports','toastmaster');
	}
tm_reports_disclaimer();
global $wpdb;
global $toast_all_roles;
$toast_all_roles = array();
global $toast_roles;

// display routines

//if changes are submitted, process them first
ob_start();
tm_member_edit($user_id);
$edit_form = ob_get_clean();

//if(isset($_GET["toastmaster"]))
//	{
?>
    <h2 class="nav-tab-wrapper">
      <a class="nav-tab nav-tab-active" href="#profile_main">Basic Program</a>
      <a class="nav-tab " href="#speeches">Speeches</a>
      <a class="nav-tab " href="#advanced">Advanced Awards</a>
      <a class="nav-tab " href="#pathways">Pathways</a>
<?php
if( (($_GET["page"] == 'my_progress_report') && current_user_can('edit_own_stats')) || current_user_can('edit_member_stats'))
{
?>
     <a class="nav-tab <?php if(isset($_GET["active"]) && ($_GET["active"] =='edit' ) ) echo 'nav-tab-active'; ?>" href="#edit" id="edit_tab">Edit</a>
     <a class="nav-tab <?php if(isset($_GET["active"]) && ($_GET["active"] =='edit_stats' ) ) echo 'nav-tab-active'; ?>" href="#edit_stats" id="edit_stats_tab">Edit Stats</a>
     <a class="nav-tab <?php if(isset($_GET["active"]) && ($_GET["active"] =='add_member_speech' ) ) echo 'nav-tab-active'; ?>" href="#add_member_speech" id="speech_tab">Add Speech/Role</a>
<?php
}
if(current_user_can('manage_options'))
{
?>
<a class="nav-tab <?php if(isset($_GET["active"]) && ($_GET["active"] =='deleterecords' ) ) echo 'nav-tab-active'; ?>" href="#deleterecords" id="deleterecords_tab">Delete</a>
<?php
}
?>
    </h2>

    <div id='sections'>
    <section id="profile_main">
<?php
echo toastmasters_progress_report($user_id);
?>
</section>
<section id="advanced">
<?php
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
?>
</section>
<section id="pathways">
<?php pathways_report(); ?>
</section>
<?php
if( (($_GET["page"] == 'my_progress_report') && current_user_can('edit_own_stats')) || current_user_can('edit_member_stats'))
{
?>
<section id="edit">
<?php
echo $edit_form;
?>
</section>
<section id="add_member_speech">
<?php
add_member_speech($user_id);
?>
</section>
<?php
}
?>
<?php
if(current_user_can('manage_options'))
{
?>
<section id="deleterecords">
<?php
wpt_delete_records($user_id);
?>
</section>
<?php
}
?>
</div>
<?php
if(isset($_GET["tab"]))
	{
?>
<script>
(function($) {
		$('section').hide();
		$('section#<?php echo $_GET["tab"]; ?>').show();
		return false;
})( jQuery );
</script>
<?php
	}

tm_admin_page_bottom($hook);
}

function wpt_delete_records ($user_id = 0) {
global $wpdb;
$wpdb->show_errors();
$output = '';
$sql = "select * from $wpdb->usermeta WHERE meta_key LIKE 'tm|%".$_SERVER['SERVER_NAME']."%' ";
if($user_id)
	$sql .= " AND user_id=".$user_id;
$sql .= ' ORDER BY user_id, meta_key';
$results = $wpdb->get_results($sql);
if($results)
foreach($results as $row)
	{
	if($user_id != $row->user_id)
		{
			$userdata = get_userdata($row->user_id);
			if(isset($userdata->first_name))
			$output .= '<h3>'.$userdata->first_name.' '.$userdata->last_name.'</h3>';
			else
			$output .= '<h3>User record missing</h3>';

		}
	$parts = explode('|',$row->meta_key);
	$output .= sprintf('<p><input type="checkbox" name="deleterecords[]" value="%d" /> %s %s</p>',$row->umeta_id,$parts[1],$parts[2]);
	$user_id = $row->user_id;
	}
if(!empty($output))
{
?>
<p>This screen, visible only to a site administrator, is meant to allow you to delete bad data such as records created while you were testing the website and the agenda system.
<form method="post" action="<?php echo admin_url('admin.php?page=toastmasters_reports');?>">
<p><input id="checkAllDelete" type="checkbox"> Check All</p>
<?php echo $output; ?>
<button>Delete</button>
</form>
<?php
}
else
	echo 'No detailed records found.';

}

function wpt_deleterecords_post () {
if(!isset($_POST["deleterecords"]))
	return;
if(!current_user_can('manage_options'))
	return;
global $wpdb;
foreach($_POST["deleterecords"] as $d)
	$wpdb->query("DELETE FROM $wpdb->usermeta where umeta_id=$d");
}

add_action('admin_init','wpt_deleterecords_post');

function awesome_get_stats ($user_id) {
$tmstats = get_tm_stats($user_id);
return $tmstats["count"];
}

function get_latest_speeches ($user_id, $myroles = array()) {
global $wpdb;
global $current_user;

$wpdb->show_errors();
	$sql = "SELECT DISTINCT $wpdb->posts.ID as post_id, $wpdb->posts.*, a1.meta_value as datetime, a2.meta_key as speech
	 FROM ".$wpdb->posts."
	 JOIN ".$wpdb->postmeta." a1 ON ".$wpdb->posts.".ID =a1.post_id AND a1.meta_key='_rsvp_dates'
	 JOIN ".$wpdb->postmeta." a2 ON ".$wpdb->posts.".ID =a2.post_id AND a2.meta_key LIKE '\_Speaker\_%' AND a2.meta_value=".$user_id." 
	 WHERE a1.meta_value < CURDATE() AND post_status='publish'
	 ORDER BY a1.meta_value DESC";

$speeches = $wpdb->get_results($sql);

$speech_array = array();
$output = '';
if(sizeof($speeches))
foreach($speeches as $s)
	{
		$manual = get_post_meta($s->post_id,'_manual'.$s->speech,true);
		$project_key = get_post_meta($s->post_id,'_project'.$s->speech,true);
		$project_text = get_project_text($project_key);
		if( $manual )
			{
			$parts = explode(':',$manual);
			if(!empty($parts[1]))
				{
					$project_key = $project_text = $parts[1];
					if(strpos($parts[0],'PETENT COMMUNICATION'))
						$manual = 'COMPETENT COMMUNICATION';
					else
						$manual = $parts[0];
				}
			}
		$title = get_post_meta($s->post_id,'_title'.$s->speech,true);
		$action = admin_url('admin.php?page='.$_GET['page']);
		if(isset($_GET["toastmaster"]))
			$action .= '&toastmaster='. (int) $_GET["toastmaster"];
		$field = $s->speech;
		$slug = preg_replace('/[^A-Za-z]/','',$project_key).$s->post_id;
		if(empty($project) || strpos($project,'hoose Manual') )
			$project = "Project not recorded";
		if((current_user_can('edit_member_stats')) || (($user_id == $current_user->ID) && current_user_can('edit_own_stats')) )
			{
			if( empty($project_key))
				{
					$project_text = 'Choose Project';
					$project_key = '';
				}
			$project_options = sprintf('<option value="%s">%s</option>',$project_key,$project_text);		
			$pa = get_projects_array('options');
			$project_options .= $pa[$manual];
			$output .= '<form method="post" action="'.$action.'" class="speech_update" id="'.$slug.'">
			<input type="hidden" name="post_id" value="'.$s->post_id.'" />
			<select class="speaker_details manual" name="_manual['.$field.']" id="_manual_'.$field.$s->post_id.'"">'.get_manuals_options($manual).'</select><br /><select class="speaker_details project" name="_project['.$field.']" id="_project_'.$field.$s->post_id.'">'.$project_options.'</select>';
			$output .= '<div class="speech_title">Title: <input type="text" class="speaker_details title_text" id="title_text'.$field.$s->post_id.'" name="_title['.$field.']" value="'.$title.'" /></div>';
			$output .= '<button>Update</button></form>';
			$button = sprintf('<button class="edit_speech" slug="%s">Edit</button>',$slug).$output;
			}
		else
			$button = '';
		if($project_text == 'Choose Project')
			$buff = sprintf('<p>%s %s %s</p>',$manual, $title, $button);
		else
			$buff = sprintf('<p>%s %s %s %s</p>',$manual, $project_text, $title, $button);
		
		$ts = strtotime($s->datetime);
		$speech_array[$ts] = (empty($speech_array[$ts])) ? $buff : $speech_array[$ts] . $buff;
	}

	$meta_speeches = get_user_meta($user_id,'Speaker');
	if(is_array($meta_speeches) )
	foreach($meta_speeches as $speech)
		{
			$manual = (isset($speech["manual"])) ? $speech["manual"] : '';
			$ts = (isset($speech["date"])) ? (int) $speech["date"] : 0;
			$project = (isset($speech["project"])) ? $speech["project"] : '';
			$title = (isset($speech["speech_title"])) ? $speech["speech_title"] : '';
		if((current_user_can('edit_member_stats')) || (($user_id == $current_user->ID) && current_user_can('edit_own_stats')) )
				$button = sprintf('<button class="remove_meta_speech" user_id="%d" project="%s">%s</button>',$user_id, $project ,__('Remove','rsvpmaker-for-toastmasters'));
			else
				$button = '';
			$buff = sprintf('<p>%s %s %s (%s) %s</p>',$manual, $project, $title, __('added','rsvpmaker-for-toastmasters'), $button);		
			$speech_array[$ts] = (empty($speech_array[$ts])) ? $buff : $speech_array[$ts] . $buff;
		}

if(empty($speech_array))
	return;

global $rsvp_options;
$buff = "<h2>Speech List</h2>";
krsort($speech_array);
foreach($speech_array as $ts => $details)
	$buff .= '<h3>'.strftime($rsvp_options["long_date"],$ts).'</h3>'.$details;
return $buff;
}

function get_speeches_by_manual ($user_id) {
global $wpdb;

$wpdb->show_errors();
	$sql = "SELECT DISTINCT $wpdb->posts.ID as post_id, $wpdb->posts.*, a1.meta_value as datetime, a2.meta_key as speech
	 FROM ".$wpdb->posts."
	 JOIN ".$wpdb->postmeta." a1 ON ".$wpdb->posts.".ID =a1.post_id AND a1.meta_key='_rsvp_dates'
	 JOIN ".$wpdb->postmeta." a2 ON ".$wpdb->posts.".ID =a2.post_id AND a2.meta_key LIKE '\_Speaker\_%' AND a2.meta_value=".$user_id." 
	 WHERE a1.meta_value < CURDATE() AND post_status='publish'
	 ORDER BY a1.meta_value";

$speeches = $wpdb->get_results($sql);

$speech_array = array();
$counter = 1;
if(sizeof($speeches))
foreach($speeches as $s)
	{
		$manual = get_post_meta($s->post_id,'_manual'.$s->speech,true);
		$project_key = get_post_meta($s->post_id,'_project'.$s->speech,true);
		$project_text = get_project_text($project_key);
		if( $manual )
			{
			$parts = explode(':',$manual);
			if(!empty($parts[1]))
				{
					$project_key = $project_text = $parts[1];
					if(strpos($parts[0],'PETENT COMMUNICATION'))
						$manual = 'COMPETENT COMMUNICATION';
					else
						$manual = $parts[0];
				}
			}
		$title = get_post_meta($s->post_id,'_title'.$s->speech,true);
		$action = admin_url('admin.php?page='.$_GET['page']);
		if(isset($_GET["toastmaster"]))
			$action .= '&toastmaster='. (int) $_GET["toastmaster"];
		$field = $s->speech;
		$slug = preg_replace('/[^A-Za-z]/','',$project_key).$s->post_id;
		$ts = strtotime($s->datetime);
		if(($project_text == 'Choose Project') || empty($project_text))
			{
			$project_text = "Project not recorded ".$counter++;
			$buff = sprintf('<p>Project? %s %s</p>', $title,date('F j, Y',$ts));
			}
		else
			$buff = sprintf('<p>%s: %s (%s)</p>', $project_text, $title,date('F j, Y',$ts));
		$speech_array[$manual][$project_text] = $buff;
	}

	$meta_speeches = get_user_meta($user_id,'Speaker');
	if(is_array($meta_speeches) )
	foreach($meta_speeches as $speech)
		{
			$manual = (isset($speech["manual"])) ? $speech["manual"] : '';
			$ts = (isset($speech["date"])) ? (int) $speech["date"] : 0;
			$project = (isset($speech["project"])) ? $speech["project"] : "Project not recorded ".$counter++;
			$title = (!empty($speech["speech_title"])) ? $speech["speech_title"] : '[title left blank]';
			$buff = sprintf('<p>%s: %s (%s)</p>', $project, $title, date('F j, Y',$ts));		
			$speech_array[$manual][$project] = $buff;
		}

if(empty($speech_array))
	return;

global $rsvp_options;
$buff = "<h2>Speeches by Manual</h2>";

$manuals = get_manuals_array();

$buff .= var_export($manuals,true);

foreach($manuals as $mkey => $mtext)
	{
	if(empty($speech_array[$mkey]))
		continue;
	$buff .= '<h3>'.$mtext.'</h3>';
	foreach($speech_array[$mkey] as $project => $show)
		$buff .= $show;
	}

$sql = "SELECT * FROM $wpdb->usermeta WHERE user_id=".$user_id." AND meta_key LIKE 'evaluation|%' ORDER BY meta_key DESC";
$results = $wpdb->get_results($sql);
if($results)
{
$buff .= '<h3>Evaluations</h3>';
	foreach($results as $row)
	{
		$key = $row->meta_key;
		$parts = explode('|',$key);
		$timestamp = $parts[1];
		$project = $parts[2];
		$project_text = get_project_text($project);
		$buff .= sprintf('<p><a target="_blank" href="%s">%s %s</a></p>', site_url('?show_evaluation='.$key.'&member_id='.$user_id), $project_text, strftime($rsvp_options["long_date"], strtotime($timestamp)) )."\n";
	}
}

return $buff;
}

function toastmasters_reconcile () {
$hook = tm_admin_page_top(__('Reconcile Meeting Activity / Add History','rsvpmaker-for-toastmasters'));

echo '<p><em>'.__('Use this form to reconcile and add to your record of roles filled at past meetings (members who signed up and did not attend and others who took roles at the last minute)','rsvpmaker-for-toastmasters').'</em></p>';

global $wpdb;
global $post;
global $rsvp_options;

if(!empty($_POST["post_id"]))
	{
	$post_id = (int) $_POST["post_id"];
	update_post_meta($post_id,'_reconciled',date('F j, Y') );
printf('<div id="message" class="updated">
		<p><strong>%s.</strong></p>',__('Reconciliation report updated','rsvpmaker-for-toastmasters'));
	echo '</div>';
	
	if(isset($_POST["attended"]))
		{
			foreach($_POST["attended"] as $user_id)
				{
					update_post_meta($post_id,'_Attended_'.$user_id,$user_id);
				}
		}
	}
	
if(!empty($_POST["year"]))
	{
	$t = strtotime($_POST["year"].'-'.$_POST["month"].'-'.$_POST["day"].' 12:00:00');
	$timestamp = date("Y-m-d H:i:s",$t);
	$nextdate = post_user_role_archive ($timestamp);
	$sql = "SELECT * FROM $wpdb->usermeta WHERE meta_key LIKE '%".$timestamp."%' order BY meta_key";
	$results = $wpdb->get_results($sql);
	if($results)
		{
		printf('<h3>%s %s</h3>',__('Updates posted for','rsvpmaker-for-toastmasters'),date('F j, Y',$t));
		foreach($results as $row)
			{
				$parts = explode('|',$row->meta_key);
				$role = $parts[1];
				$userdata = get_userdata($row->user_id);
				printf('<p><strong>%s</strong>: %s %s</p>',$role,$userdata->first_name,$userdata->last_name);
			}
		}
	echo '<p>'.__('Advancing date +1 week','rsvpmaker-for-toastmasters').'</p>';
	}
if(!empty($_GET["history"]))
	{
	$r_post = get_post($_GET["history"]);
	printf('<form action="%s" method="post">',admin_url('admin.php?page=toastmasters_reconcile&history='.$_GET["history"]) );
	if(!isset($nextdate))
		$nextdate = strtotime('-1 year');
	$year = date('Y',$nextdate);
	$month = date('n',$nextdate);
	$day = date('j',$nextdate);
	echo '<p>Year <select name="year">';
	$yearback = (int) date('Y',strtotime('-10 year'));
	$yearnow = (int) date('Y');
	for($i = $yearback; $i <= $yearnow; $i++)
		{
			$s = ($i == $year) ? ' selected="selected" ' : '';
			printf('<option value="%d" %s>%d</option>',$i,$s,$i);
		}
	echo '<select> ';
	echo 'Month <select name="month">';
	for($i = 1; $i < 13; $i++)
		{
			$s = ($i == $month) ? ' selected="selected" ' : '';
			printf('<option value="%d" %s>%d</option>',$i,$s,$i);
		}
	echo '<select> ';
	echo 'Day <select name="day">';
	for($i = 1; $i < 32; $i++)
		{
			$s = ($i == $day) ? ' selected="selected" ' : '';
			printf('<option value="%d" %s>%d</option>',$i,$s,$i);
		}
	echo '<select></p>';

	}
else
	{
$sql = "SELECT DISTINCT $wpdb->posts.ID as post_id, $wpdb->posts.*, date_format(a1.meta_value,'%M %e, %Y') as date
	 FROM ".$wpdb->posts."
	 JOIN ".$wpdb->postmeta." a1 ON ".$wpdb->posts.".ID =a1.post_id AND a1.meta_key='_rsvp_dates'
	 WHERE a1.meta_value < DATE_ADD(NOW(),INTERVAL 5 HOUR) AND (post_status='publish' OR post_status='draft')  AND post_content LIKE '%[toast%'  ORDER BY a1.meta_value DESC";

$results = $wpdb->get_results($sql);
if(empty($results))
	return 'No data';
$options = '';
foreach($results as $row)
	{
		$rdate = get_post_meta($row->ID,'_reconciled', true);
		$s = '';
		if(isset($_REQUEST["post_id"]) && ($row->ID == $_REQUEST["post_id"]))
			$s = ' selected="selected" ';
		if($rdate)
			$r = " (reconciled $rdate)";
		else
			$r = "";
		$options .= sprintf('<option value="%d" %s>%s %s</option>',$row->ID,$s,$row->date, $r);
	}

$sql = "SELECT DISTINCT $wpdb->posts.ID as post_id, $wpdb->posts.*, date_format(a1.meta_value,'%M %e, %Y') as date
	 FROM ".$wpdb->posts."
	 JOIN ".$wpdb->postmeta." a1 ON ".$wpdb->posts.".ID =a1.post_id AND a1.meta_key='_sked'
	 ORDER BY $wpdb->posts.ID";

$ot = '<option value="">'.__('Choose Template','rsvpmaker-for-toastmasters').'</option>';
$results = $wpdb->get_results($sql);
foreach($results as $row)
	{
		$s = '';
		if(isset($_REQUEST["history"]) && ($row->ID == $_REQUEST["history"]))
			$s = ' selected="selected" ';
		$ot .= sprintf('<option value="%d" %s>%s</option>',$row->ID,$s,$row->post_title);
	}
?>
<table>
<tr>
<th style="text-align: left;">Update Meeting Records</th>
<th style="width: 250px; text-align: left;">Add History for Other Dates</th>
<th></th>
</tr>
<tr><td valign="top">
<form method="get" action="<?php echo admin_url('admin.php'); ?>">
<input type="hidden" name="page" value="toastmasters_reconcile" />
<select id="pick_event" name="post_id">
<?php echo $options; ?>
</select>
<br /><button><?php _e('Get','rsvpmaker-for-toastmasters'); ?></button>
</form>
</td>
<td valign="top">
<form method="get" action="<?php echo admin_url('admin.php'); ?>">
<input type="hidden" name="page" value="toastmasters_reconcile" />
<select id="history" name="history">
<?php echo $ot; ?>
</select>
<br /><button><?php _e('Get','rsvpmaker-for-toastmasters'); ?></button>
</form>
</td>
<td>
<em><?php
printf(__('Use the "Add History" option if you want to add detailed records of meetings from before you began using this software. (To add summary data such as number of speeches per manual, use Edit tab under <a href="%s">Progress Reports</a>)','rsvpmaker-for-toastmasters'),admin_url('admin.php?page=toastmasters_reports'));?></em>
</td>
</tr>
</table>

<?php
if(isset($_REQUEST["post_id"]))
	{
	$id = (int) $_REQUEST["post_id"];
	$r_post = get_post( $id );
	$r_post->postID = $r_post->ID;
	$time = get_rsvp_date( $id );
	$r_post->date = strftime($rsvp_options["long_date"],strtotime($time));
	}
else
	{
	$past = get_past_events(" post_content LIKE '%[toast%' ",1);
	$r_post = $past[0];
	}
	printf("<h2>%s</h2>",$r_post->date);
	printf('<form action="%s" method="post">',admin_url('admin.php?page=toastmasters_reconcile') );
	} // not history

$post = get_post($r_post->ID);

$content = $r_post->post_content;

$content .= '

[toastmaster role="Table Topics" count="10"]

[toastmaster role="Best Table Topics" count="1"]

[toastmaster role="Best Speech" count="1"]

[toastmaster role="Best Evaluation" count="1"]

';

echo do_shortcode($content);


if($r_post->postID)
{
$sql = "SELECT meta_key, meta_value FROM `$wpdb->postmeta` where post_id=".$r_post->postID." AND BINARY meta_key RLIKE '^_[A-Z].+[0-9]$' GROUP BY meta_key";
$results = $wpdb->get_results($sql);
foreach ($results as $row) 
	{
		$present[] = $row->meta_value; // all the people who filled any role
		$meeting_roles[] = $row->meta_key;
	}
}
$members = array();
$blogusers = get_users('blog_id='.get_current_blog_id() );
    foreach ($blogusers as $user) {		
	$userdata = get_userdata($user->ID);
	if(!empty($present) && in_array($user->ID, $present ) )
		{
		$email[] = $userdata->user_email;
		continue;
		}
	$index = preg_replace('/[^A-Za-z]/','',$userdata->last_name.$userdata->first_name.$userdata->user_login);
	$members[$index] = $userdata;
	}
ksort($members);

echo '<h2>'.__('Others attending','rsvpmaker-for-toastmasters').'</h2>';

$count = 0;
foreach ($members as $index => $userdata)
	{
		$att = sprintf(' <input type="checkbox" name="attended[]" value="%d" />',$userdata->ID);
		if(($count % 5) == 0)
			echo '<br />';
		$count++;
		printf('%s %s %s',$att,$userdata->first_name, $userdata->last_name);
	}

submit_button('Save Changes','primary','edit_roles');
if(isset($_GET["history"]))
	$post->ID = 0;
printf('<input type="hidden" name="post_id" id="post_id" value="%d"><input type="hidden" id="toastcode" value="%s"></form>',$post->ID,wp_create_nonce( "rsvpmaker-for-toastmasters" ));

if(!empty($email))
	{
	$email_list = implode(', ',$email);
	printf('<p>Email attendees: <a href="mailto:%s">%s</a></p>',$email_list, $email_list);
	}
	
tm_admin_page_bottom($hook);
}


function toastmasters_attendance () {
$hook = tm_admin_page_top(__('Record Attendance','rsvpmaker-for-toastmasters'));

global $wpdb;

if(isset($_POST["attended"]) && $_POST["attended"])
	{
		foreach($_POST["attended"] as $meta_key)
			{
				$parts = explode("_",$meta_key);
				$meta_value = array_pop($parts);
				$event = (int) $_POST["post_id"];
				update_post_meta($event, $meta_key, $meta_value);
			}
printf('<div id="message" class="updated">
		<p><strong>%s.</strong></p>
	</div>',__('Attendance updated','rsvpmaker-for-toastmasters'));

	}

	$results = get_past_events("post_content LIKE '%[toast%'");
if(empty($results))
	{
	echo 'No meeting data';
	return;
	}
$options = '';
foreach($results as $row)
	{
		$s = '';
		if(isset($_REQUEST["post_id"]) && ($row->ID == $_REQUEST["post_id"]))
			$s = ' selected="selected" ';
		$options .= sprintf('<option value="%d" %s>%s</option>',$row->ID,$s,$row->date);
	}
?>
<div class="wrap"><h2><?php _e('Record Attendance','rsvpmaker-for-toastmasters'); ?></h2>
<form method="get" action="<?php echo admin_url('admin.php'); ?>">
<input type="hidden" name="page" value="toastmasters_attendance" />
<select id="pick_event" name="post_id">
<?php echo $options; ?>
</select>
<button>Get Event</button>
</form>

<?php
	if(isset($_REQUEST["post_id"]) && $_REQUEST["post_id"])
		$results = get_past_events("ID =". (int) $_REQUEST["post_id"]);
	$r_post = $results[0]; 

$present = array();
$meeting_roles = array();

if($r_post->postID)
{
$sql = "SELECT meta_key, meta_value FROM `$wpdb->postmeta` where post_id=".$r_post->postID." AND BINARY meta_key RLIKE '^_[A-Z].+[0-9]$' GROUP BY meta_key";
$results = $wpdb->get_results($sql);
foreach ($results as $row) 
	{
		$present[] = $row->meta_value; // all the people who filled any role
		$meeting_roles[] = $row->meta_key;
	}
}
else
	_e('Error: no event selected','rsvpmaker-for-toastmasters');

$blogusers = get_users('blog_id='.get_current_blog_id() );
    foreach ($blogusers as $user) {		
	$userdata = get_userdata($user->ID);
	if($userdata->hidden_profile)
		continue;	
	$index = preg_replace('/[^A-Za-z]/','',$userdata->last_name.$userdata->first_name.$userdata->user_login);
	$members[$index] = $userdata;
	}

// TO DO add routine to edit list of roles for table

printf("<h2>%s</h2>",$r_post->date);
printf('<form action="%s" method="post"><input type="hidden" name="post_id" value="%d"><input type="hidden" name="toastcode" id="toastcode" value="%s">',admin_url('admin.php?page=toastmasters_attendance'), $r_post->postID, wp_create_nonce( "rsvpmaker-for-toastmasters" ));

echo '<table   class="wp-list-table" >'; //  widefat fixed posts
$l = '<tr><th>Name</th><th>Attended</th></tr>';
echo $l;
$count =0;

ksort($members);
foreach ($members as $index => $userdata)
	{
		$count++;
		if(($count % 10) == 0)
			echo $l;
		if(in_array($userdata->ID,$present)) // || in_array('_Attended_'.$userdata->ID,$meeting_roles))
			$att = ' <strong>'.__('YES','rsvpmaker-for-toastmasters').'</strong> ';
		else
			$att = sprintf('<input type="checkbox" name="attended[]" value="_Attended_%d" />',$userdata->ID);
/*
		if(in_array('_Table_Topics_'.$userdata->ID,$meeting_roles))
			$tt = ' <strong>YES</strong> ';
		else
			$tt =  sprintf('<input type="checkbox" name="table_topics[]" value="_Table_Topics_%d" />',$userdata->ID);
*/
		//printf('<tr><td>%s %s</td><td>%s</td><td>%s</td></tr>',$userdata->first_name, $userdata->last_name,$att,$tt);
		printf('<tr><td>%s %s</td><td>%s</td></tr>',$userdata->first_name, $userdata->last_name,$att);
	}
echo "</table>";

submit_button();
?>
</form>
<?php
tm_admin_page_bottom($hook);
} // end attendance


function toastmasters_attendance_report() {

$hook = tm_admin_page_top(__('Attendance Report','rsvpmaker-for-toastmasters'));
tm_reports_disclaimer();

if(is_admin())
{

if(isset($_GET["start_month"]) && $_GET["start_month"])
	{
		$year = (int) $_GET["start_year"];
		$month = (int) $_GET["start_month"];
		$start = sprintf('&amp;start_year=%d&amp;start_month=%d',$year,$month);
		$startmsg = '';
	}
else
	{
		$month = 7;
		$year = (date('n') > 6) ? date('Y') : date('Y') - 1;
		$start = '';
		$startmsg = ' <b>(not set)</b>';
	}
?>
<form action="admin.php" method="get">
<input type="hidden" name="page" value="toastmasters_attendance_report" />
<?php _e('Start Month','rsvpmaker-for-toastmasters'); ?>: <input name="start_month" size="6" value="<?php echo $month; ?>">
<?php _e('Start Year','rsvpmaker-for-toastmasters'); ?>: <input name="start_year"  size="6" value="<?php echo $year; ?>">
<button><?php _e('Set','rsvpmaker-for-toastmasters'); ?></button> <?php echo $startmsg; ?>
</form>
<?php
}

$blogusers = get_users('blog_id='.get_current_blog_id() );
    foreach ($blogusers as $user) {			
	$userdata = get_userdata($user->ID);
	if($userdata->hidden_profile)
		continue;
	$attendance[$user->ID] = awesome_get_attendance($user->ID);
	}

arsort($attendance);

echo "<table>";

foreach($attendance as $user_id => $count)
	{
		if(empty ($user_id) || ($user_id == 0))
			continue;
		if(!isset($d))
			$d = $count;
		if($count > 0)
			{
			$bar = 500 * ($count / $d);
			$bar = round($bar);
			}
		else
			$bar = 0;
		if($bar > 20)	
			$barhtml = '<div style="background-color: #772432; padding-top: 5px; padding-bottom: 5px; font-size: large; width: '.$bar.'px"><span style="font-weight: bold; margin: 5px; text-shadow: 2px 3px 4px #000000; font-size: 35px; color: white;">'.$count.'</span></div>';
		else
			$barhtml = '<div>'.$count.'</div>';
		
		$userdata = get_userdata($user_id);

		echo '<tr><td>';
		echo $userdata->first_name;
		echo ' ';
		echo $userdata->last_name;
		echo '</td><td>';
		echo $barhtml;
		echo '</td></tr>';
	}
echo "</table>";
tm_admin_page_bottom($hook);
} // attendance report

function awesome_get_attendance($user_id) {
global $wpdb;

if(isset($_GET["start_year"]) && $_GET["start_year"])
	{
		$year = (int) $_GET["start_year"];
		$month = (int) $_GET["start_month"];
		if($month < 10)
			$month = '0'.$month;
		$start_date = " AND a1.meta_value > '".$year.'-'.$month."-01' ";
	}
else
	$start_date = '';

	$sql = "SELECT DISTINCT $wpdb->posts.ID as postID, $wpdb->posts.*, a1.meta_value as datetime, a2.meta_value as role
	 FROM ".$wpdb->posts."
	 JOIN ".$wpdb->postmeta." a1 ON ".$wpdb->posts.".ID =a1.post_id AND a1.meta_key='_rsvp_dates'
	 JOIN ".$wpdb->postmeta." a2 ON ".$wpdb->posts.".ID =a2.post_id AND BINARY a2.meta_key RLIKE '^_[A-Z].+[0-9]$' 
	 WHERE a1.meta_value < NOW() $start_date AND a2.meta_value = $user_id";	
$results = $wpdb->get_results($sql);
return sizeof($results);
}

function get_speech_role_count ($user_id, $check_history = true) {
global $wpdb;
$wpdb->show_errors();
$counts = array();

$count = 0;
$role_count_projects = array();

	$sql = "SELECT DISTINCT $wpdb->posts.ID as post_id, $wpdb->posts.*, a1.meta_value as datetime, a2.meta_key as manual
	 FROM ".$wpdb->posts."
	 JOIN ".$wpdb->postmeta." a1 ON ".$wpdb->posts.".ID =a1.post_id AND a1.meta_key='_rsvp_dates'
	 JOIN ".$wpdb->postmeta." a2 ON ".$wpdb->posts.".ID =a2.post_id AND a2.meta_key LIKE '\_Speaker\_%' AND a2.meta_value=".$user_id." 
	 WHERE a1.meta_value < NOW() AND post_status='publish'
	 ORDER BY a1.meta_value DESC ";

if(isset($_GET["debug"]))
	echo $sql;

$results = $wpdb->get_results($sql);
if(!empty($results))
foreach ($results as $row) 
	{
	$key = '_manual'.$row->manual;
	$projectkey = '_project'.$row->manual;
	$sql = "SELECT meta_value FROM `$wpdb->postmeta` WHERE post_id=".$row->post_id." AND meta_key = '$key' ";
	$speech_role = $wpdb->get_var($sql);
	if( $speech_role )
		{
		$parts = explode(':',$speech_role);
		if(strpos($parts[0],'PETENT COMMUNICATION'))
			$role = $manual = 'COMPETENT COMMUNICATION';
		else
			$role = $manual = $parts[0];
		}
	if(isset($_GET["debug"]))
	{
	echo $manual;
	printf('<p>Speech record: %s</p>',$role);	
	}
	$counts[$role] = isset($counts[$role]) ? $counts[$role] + 1 : 1;
	$project = get_post_meta($row->post_id,$projectkey, true);
	if(!empty($project))
	{
	$projectslug = preg_replace('/[ _]/','',$role)."_project";
	$counts[$projectslug][] = array('title' => get_project_text($project),'date' => strtotime($row->datetime), 'source' => $row->post_id);
	}

	}//end foreach

if(isset($_GET["debug"]))
print_r($counts);

	$manuals = get_manuals_array();

	// history - projects in user meta
	foreach($manuals as $role => $text)
		{
			$projectslug = preg_replace('/[ _]/','',$role)."_project";
			$parray = get_user_meta($user_id,$projectslug);
			if(!empty($parray))
				{
				if(empty($counts[$projectslug]))
					$counts[$projectslug] = $parray;
				else
					$counts[$projectslug] = array_merge($counts[$projectslug],$parray);
				$counts[$role] = sizeof($counts[$projectslug]);
				}
		}

	$meta_speeches = get_user_meta($user_id,'Speaker');
	if(is_array($meta_speeches) )
	foreach($meta_speeches as $speech)
		{
			$manual = (isset($speech["manual"])) ? $speech["manual"] : 'COMPETENT COMMUNICATION';
			$project = (isset($speech["project"])) ? $speech["project"] : '';
			$date = (isset($speech["date"])) ? $speech["date"] : '';
			$projectslug = preg_replace('/[ _]/','',$manual)."_project";
			$counts[$projectslug][] = array('title' => $project,'date' => $date, 'source' => 'meta');
			$counts[$manual] = (isset($counts[$manual])) ? $counts[$manual] +1 : 1;
		}
	
return $counts;
}

function toastmasters_cc() {

if($_GET["page"] == 'toastmasters_cc')
$hook = tm_admin_page_top(__('Competent Communicator Progress Report','rsvpmaker-for-toastmasters'));
tm_reports_disclaimer();

$ccs = array();
global $wpdb;

$blogusers = get_users('blog_id='.get_current_blog_id());
    foreach ($blogusers as $user) {
		$userdata = get_userdata($user->ID);
		if($userdata->hidden_profile)
			continue;
		$stats = get_tm_stats($user->ID);
		$counts = $stats["count"];
		$pure_counts = $stats["pure_count"];
		$ccs[$user->ID] = (isset($counts["COMPETENT COMMUNICATION"]) ) ? $counts["COMPETENT COMMUNICATION"] : 0;
		$pure[$user->ID] = (isset($pure_counts["COMPETENT COMMUNICATION"]) ) ? $pure_counts["COMPETENT COMMUNICATION"] : 0;
	}

if(isset($_GET["debug"]))
{
echo '<br />CC array: ';
print_r($ccs);
}
	arsort($ccs);

if(!isset($_GET["all"]))
{
$datefilter = strtotime('3 months ago');
printf('<p><em>'.__('Filtered by default to show members active within the last 3 months (since %s) <a href="%s">(show all)','rsvpmaker-for-toastmasters').'</a></em></p>',date('m/d/Y',$datefilter),admin_url('admin.php?page=toastmasters_cc&all=1'));
}

echo "<table>";

	foreach($ccs as $member => $count)
	{	
	$userdata = get_userdata($member);
	if(!$userdata)
		continue;

	$ts = strtotime(get_latest_visit ($userdata->ID));
	if($ts)
		$d = sprintf('<br />'.__('Last attended','rsvpmaker-for-toastmasters').': %s',date("m/d/Y",$ts));
	else
		$d = '';

	if(!isset($_GET["all"]))
		{
			if( $ts && ($datefilter > $ts) )
				continue;
		}

		$barhtml = tm_barhtml($count,10);
		echo '<tr><td><strong>';
		echo $userdata->first_name;
		echo ' ';
		echo $userdata->last_name;
		echo '</strong>'.$d.'</td><td>';
		echo $barhtml;
		if(isset($_GET["debug"]) && ($count != $pure[$member]))
			printf('<br />Detailed speech records: %d, adjusted total %d', $pure[$member], $count);
		echo '<br />&nbsp;</td></tr>';
	}
echo "</table>";

if($_GET["page"] == 'toastmasters_cc')
tm_admin_page_bottom($hook);

}

function tm_barhtml($count,$target) {
$barhtml = '';
while ($count > $target)
	{
	$barhtml .= '<div style="width: 500px; border: thin solid #000;"><div style="background-color: #772432; padding-top: 5px; padding-bottom: 5px; font-size: large; width: 100%;"><span style="font-weight: bold; margin: 5px; text-shadow: 2px 3px 4px #000000; font-size: 35px; color: white;">'.$target.'</span></div></div>';
	$count = $count - $target;
	}

$increment = 100 / $target;
$bar = $count * $increment;
$barhtml .= '<div style="width: 500px; border: thin solid #000;"><div style="background-color: #772432; padding-top: 5px; padding-bottom: 5px; font-size: large; width: '.$bar.'%;"><span style="font-weight: bold; margin: 5px; text-shadow: 2px 3px 4px #000000; font-size: 35px; color: white;">'.$count.'</span></div></div>';
return $barhtml;
}

function toastmasters_advanced_user ($userdata, $showempty = false)
{		
$manuals = get_manuals_array();
$advanced_projects = get_advanced_projects();
		$counts = awesome_get_stats($userdata->ID);
		$advanced_completed = 0;
		$user_id = $userdata->ID;
		$progress = '';
		$projects = '';
		if($counts)
		foreach($counts as $manual => $count)
			{
				if(!$count)
					continue;
				if(empty($manual))
					continue;
				if((strpos($manual,'OMPETENT')) || (strpos($manual,'C Speeches')))
					continue;
				if(strpos($manual,'ETTER SPEAKER') || strpos($manual,'UCCESSFUL CLUB') || strpos($manual,'EADERSHIP EXCELLENCE'))
					continue;
				elseif(in_array($manual,$manuals))
					{
					$next = '<div>'.$manuals[$manual].tm_barhtml($count,5).'</div>';
					$progress .= $next;
					if($count >= 5)
						$advanced_completed++;
					}
			}

if(empty($next) && !$showempty)
	return;

	echo '<h3>'.$userdata->first_name.' '.$userdata->last_name.'</h3>';
	echo $progress;

echo '<h4>'.__('Advanced Communicator Bronze','rsvpmaker-for-toastmasters').'</h4>';
$done = ($advanced_completed >= 2) ? '<span style="color: green; font-weight: bold;">&#10004; DONE</span>' : (int) $advanced_completed;
echo '<p>'.__('Complete 2 advanced manuals','rsvpmaker-for-toastmasters').': '.$done.'</p>';

echo '<h4>'.__('Advanced Communicator Silver','rsvpmaker-for-toastmasters').'</h4>';
$done = ($advanced_completed >= 4) ? '<span style="color: green; font-weight: bold;">&#10004; DONE</span>' : (int) $advanced_completed;
echo '<p>'.__('Complete 2 more advanced manuals (total 4)','rsvpmaker-for-toastmasters').': '.$done.'</p>';
echo '<p>'.__('Deliver 2 educational presentations','rsvpmaker-for-toastmasters').'</p>';
echo '<blockquote>';
$ms = array('BETTER SPEAKER SERIES' => __('BETTER SPEAKER SERIES','rsvpmaker-for-toastmasters'),'SUCCESSFUL CLUB SERIES'=> __('SUCCESSFUL CLUB SERIES','rsvpmaker-for-toastmasters'));

foreach($ms as $manual => $display)
	{
	if(empty($counts[$manual])) $counts[$manual] = 0;
	printf('<p>%s: %s</p>',$display,$counts[$manual]);
	$project = preg_replace('/[ _]/','',$manual)."_project";
	if(isset($counts[$project]))
		{
		echo '<ul>';
		$project_array = $counts[$project];
		foreach($project_array as $project_row)
			{
			$t = (int) $project_row["date"];
			printf('<li>%s - %s</li>',$project_row["title"],date('F jS, Y', $t) );
			}
		echo '</ul>';
		}
	}
echo '<p>'.__('Note: Successful Club series projects can also be applied to Advanced Leader Bronze (but same the project cannot be counted twice)','rsvpmaker-for-toastmasters').'</p>';
echo '</blockquote>';


foreach($advanced_projects as $key => $project)
	{
		if(strpos($key,'CS'))
			{
			$plus = (current_user_can('edit_member_stats')) ? increment_stat_button($user_id,$key) : '';

			$done = (!empty($counts[$key])) ? '<span style="color: green; font-weight: bold;">&#10004; DONE</span>' : '<em>TO DO</em> '.$plus;
			printf('<p>%s: %s</p>',$project, $done);
			}
	}

echo '<h4>'.__('Advanced Communicator Gold','rsvpmaker-for-toastmasters').'</h4>';
$done = ($advanced_completed >= 6) ? '<span style="color: green; font-weight: bold;">&#10004; DONE</span>' : (int) $advanced_completed;
echo '<p>'.__('Complete 2 more advanced manuals (6 total)','rsvpmaker-for-toastmasters').': '.$done.'</p>';
foreach($advanced_projects as $key => $project)
	{
		if(strpos($key,'CG'))
			{
			$plus = (current_user_can('edit_member_stats')) ? increment_stat_button($user_id,$key) : '';

			$done = (!empty($counts[$key])) ? '<span style="color: green; font-weight: bold;">&#10004; DONE</span>' : '<em>TO DO</em> '.$plus;
			printf('<p>%s: %s</p>',$project, $done);
			}
	}

echo '<h4>'.__('Advanced Leader Bronze','rsvpmaker-for-toastmasters').'</h4>';
echo '<p>'.__('Deliver 2 educational presentations','rsvpmaker-for-toastmasters').'</p>';
echo '<blockquote>';
$ms = array('SUCCESSFUL CLUB SERIES'=> __('SUCCESSFUL CLUB SERIES','rsvpmaker-for-toastmasters'),'LEADERSHIP EXCELLENCE SERIES'=> __('LEADERSHIP EXCELLENCE SERIES','rsvpmaker-for-toastmasters') );

foreach($ms as $manual => $display)
	{
	if(empty($counts[$manual])) $counts[$manual] = 0;
	printf('<p>%s: %s</p>',$display,$counts[$manual]);

	$project = preg_replace('/[ _]/','',$manual)."_project";
	if(isset($counts[$project]))
		{
		echo '<ul>';
		$project_array = $counts[$project];
		foreach($project_array as $project_row)
			{
			$t = (int) $project_row["date"];
			printf('<li>%s - %s</li>',$project_row["title"],date('F jS, Y', $t) );
			}
		echo '</ul>';
		}

	}
echo '<p>'.__('Note: Successful Club series projects can also be applied to Advanced Communicator Silver (but the same project cannot be counted twice)','rsvpmaker-for-toastmasters').'</p>';
echo '</blockquote>';

foreach($advanced_projects as $key => $project)
	{
		if(strpos($key,'LB'))
			{
			$plus = (current_user_can('edit_member_stats')) ? increment_stat_button($user_id,$key) : '';
			$done = (!empty($counts[$key])) ? '<span style="color: green; font-weight: bold;">&#10004; DONE</span>' : '<em>TO DO</em> '.$plus;
			printf('<p>%s: %s</p>',$project, $done);
			}
	}

echo '<h4>'.__('Advanced Leader Silver','rsvpmaker-for-toastmasters').'</h4>';
foreach($advanced_projects as $key => $project)
	{
		if(strpos($key,'LS'))
			{
			$plus = (current_user_can('edit_member_stats')) ? increment_stat_button($user_id,$key) : '';
			$done = (!empty($counts[$key])) ? '<span style="color: green; font-weight: bold;">&#10004; DONE</span>' : '<em>TO DO</em> '.$plus;
			printf('<p>%s: %s</p>',$project, $done);
			}
	}
}

function toastmasters_advanced () {
if($_GET["page"] == 'toastmasters_advanced')
$hook = tm_admin_page_top(__('Advanced Award Progress','rsvpmaker-for-toastmasters'));
tm_reports_disclaimer('<em>This report is still under development.</em>');

$blogusers = get_users('blog_id='.get_current_blog_id());
    foreach ($blogusers as $user) {
	$userdata = get_userdata($user->ID);
	if($userdata->hidden_profile)
		continue;

	$index = preg_replace('/[^A-Za-z]/','',$userdata->last_name.$userdata->first_name.$userdata->user_login);
	$members[$index] = $userdata;
	}
	
	ksort($members);
	foreach($members as $userdata) {
toastmasters_advanced_user ($userdata);	
} // end for each member

/*
II. Advanced Communicator Silver (ACS)
4 Received Advanced Communicator Bronze
(Or received Able Toastmaster award or __________________________________________________________
Advanced Toastmaster Bronze award)
4 Completed two Advanced Communication manuals.
(Attach Project Completion Record from each manual.)
4 Conducted two presentations from The Better Speaker Series and/or The Successful Club Series. (Success/Communication,
Success/Leadership, Youth Leadership workshops and The Leadership Excellence Series do not qualify.) Presentation date may
not be one used previously.
Presentation Name Date Presented
1. _________________________________________________________________________________________________
2. _________________________________________________________________________________________________
III. Advanced Communicator Gold (ACG)
4 Received Advanced Communicator Silver
(Or received Able Toastmaster Bronze or __________________________________________________________
Advanced Toastmaster Silver)
4 Completed two Advanced Communication manuals.
(Attach Project Completion Record from each manual.)
4 Coordinated and conducted one Success/Communication, Success/Leadership or Youth Leadership workshop. (The Better
Speaker Series, The Successful Club Series, and The Leadership Excellence Series do not qualify.) Presentation date may not be
one used previously.
Workshop Name Date Presented
______________________________________________________________________________________________________________
4 Coached a new member with his or her first three speeches.
Name of New Member New Member Number (if known) Year Coached
_____________________________________________

I. Advanced Leader Bronze (ALB)
4 Achieved Competent Leader (CL) award
for completing Competent Leadership manual Date ______________ Club/District No. ___________________
4 Achieved Competent Communicator (CC) award
(or achieved Competent Toastmaster award) Date ______________ Club/District No. ___________________
4 Served at least six months* as a club officer (president, vice president education, vice president membership,
vice president public relations, secretary, treasurer, or sergeant at arms) and participated in the preparation of a
Club Success Plan while serving in this office.
(*You must have served as an officer from July 1 through December 31 or January 1 through June 30 to fulfill this requirement. Other six-month
periods do not qualify. The six months must be completed at the time you submit this application.)
Office held ______________________________________________________________ in Club No. _______________
Served six months as follows (check one and fill in year)
______ July 1 – December 31, ______ ______ January 1 – June 30, ______
Date you helped prepare a Club Success Plan for your club ________________________ ____________
(must coincide with above officer term)
4 While serving in above officer term, participated in a district-sponsored club-officer training program.
(Applicants in undistricted clubs need not complete this requirement.)
Date attended training _________________________________________________________________________________
DTM APPLICANTS MUST PROVIDE A STREET ADDRESS, NOT A P. O. BOX
MONTH YEAR
REQUIRED FOR DTM APPLICATIONS
TO APPLY:
You must be a current member of the club listed below at the time your application is received at World
Headquarters to be eligible for the award.
4 Complete both sides of this application.
4 A current club officer must sign and date the application.
4 Ask a current club officer to submit your application online at www.toastmasters.org/members.
If no current officer has online access, mail OR fax (one method only please) the completed form to:
Member Services - Education Awards Fax: 949.858.1207
Toastmasters International
P.O. Box 9052, Mission Viejo, CA 92690 USA
PLEASE PRINT OR TYPE (AS YOU WOULD LIKE IT TO APPEAR ON CERTIFICATE)
LLLLLLLL
4 Conducted two presentations from The Successful Club Series and/or The Leadership Excellence Series. (Success/Communication, Success/
Leadership, Youth Leadership and The Better Speaker Series do not qualify.) Presentation date may not be one used previously.
Presentation Name Date Presented
1. _________________________________________________________________________________________________
2. _________________________________________________________________________________________________
II. Advanced Leader Silver (ALS)
4 Received Advanced Leader Bronze award
(or “old” Competent Leader award)
4 Served a complete term* (July 1 – June 30) as a district officer (district governor, lieutenant governor, public relations officer,
secretary, treasurer, division governor, area governor). (Applicants in undistricted clubs need not complete this requirement.)
(*Term must be completed at the time you submit this application.)
Office held ______________________________________________________________ District No. _______________
Date served (fill in years) July 1, ____________ through June 30, ____________
4 Completed the High Performance Leadership program.
Club No. __________________ Certificate No. ____________________________ Date Received_____________________
4 Served successfully as sponsor* (up to two allowed) or mentor** (up to two allowed, appointed by the district governor) of a
new club. Name must appear on Application to Organize (Form 1).
(*Members are successful sponsors when the new club charters and sends World Headquarters a letter from the charter president verifying that the
sponsor performed his/her duties. World Headquarters must receive this letter no later than 90 days after the club charter date.)
(**Members are successful mentors after they have worked with the new club for at least six months following its charter and the new club charter
president sends World Headquarters a letter verifying that the mentor performed his/her duties for those six months.)
*/

if($_GET["page"] == 'toastmasters_advanced')
tm_admin_page_bottom($hook);
}

function get_advanced_projects () {
$projects = array('ACG1' => 'ACG: Coordinated and conducted one Success/Communication, Success/Leadership or Youth Leadership workshop','ACG2' => 'ACG: Coached a new member with his or her first three speeches','ALB1' => 'ALB: Served at least six months as a club officer','ALB2' => 'ALB: Participated in a district-sponsored club-officer training program','ALS1' => 'ALS: Served a complete term as a district officer','ALS2' => 'ALS: Completed High Performance Leadership Program','ALS3' => 'ALS: Served successfully as sponsor or mentor of a new club');
return $projects;
}

add_action('wp_ajax_increment_stat','wp_ajax_increment_stat');

function wp_ajax_increment_stat() {
$role = 'tmstat:'.$_POST['role'];
$user_id = (int) $_POST['user_id'];
$stat = (int) get_user_meta($user_id,$role,true);
$stat++;
update_user_meta($user_id,$role,$stat);
die('+1 ' . $_POST["role"]);
}

function is_requirement_met($user_id, $choices, $goal, $echo = true) {
global $myroles;
$score = 0;

foreach($choices as $choice)
	{
		if(($score < $goal) && isset($myroles[$choice]) && ($myroles[$choice] > 0) )
			{
			$myroles[$choice]--;
			$score++;
			if($echo)
			echo '<div><span style="color: green; font-weight: bold">(x)</span> '.$choice."</div>\n";
			}
		elseif($echo)
			{
			echo '<div>'.$choice;
			if(current_user_can('edit_member_stats'))
				echo increment_stat_button($user_id, $choice );
			echo "</div>\n";
			}
	}
	if($score >= $goal)
		{
		if($echo)
			echo '<div><span style="color: green; font-weight: bold">'.__('Goal Met!','rsvpmaker-for-toastmasters').'</span>'."</div>\n";
		return true;
		}
	else
		{		
		return false;
		}
}

function cl_report () {

$hook = tm_admin_page_top(__('Competent Leader Progress Report','rsvpmaker-for-toastmasters'));
tm_reports_disclaimer('<em>Member strategy for matching activities with projects may differ from the automated method used for this report.</em>');

global $project_gaps;

$cl_leaders = array();
$nocl = array();
$text2 = array();

echo '
<style>
td {vertical-align: text-top;}
td.project, th.project, td.name, th.name {
width: 150px;
}
</style>
';

if(!isset($_GET["all"]))
{
$datefilter = strtotime('3 months ago');
printf(__('<p><em>Filtered by default to show members active within the last 3 months (since %s) <a href="%s">(show all)</a></em></p>','rsvpmaker-for-toastmasters'),date('m/d/Y',$datefilter),admin_url('admin.php?page=cl_report&all=1'));
}

$text = '';

$blogusers = get_users('blog_id='.get_current_blog_id() );
    foreach ($blogusers as $user) {		
	$userdata = get_userdata($user->ID);
	if($userdata->hidden_profile)
		continue;
	if(preg_match('/[LD]/',$userdata->education_awards))
		continue;
	$ts = strtotime(get_latest_visit ($userdata->ID));
	if($ts)
		$d = sprintf('<br />'.__('Last attended','rsvpmaker-for-toastmasters').': %s',date("m/d/Y",$ts));
	else
		$d = '';

	if(!isset($_GET["all"]))
		{
			if( $ts && ($datefilter > $ts) )
				continue;
		}

	ob_start();
	$completed = cl_progress($userdata);
	if($completed)
		{
		$text[$user->ID] = ob_get_clean();	
		$cl_leaders[$completed][] = $userdata;
		}
	else
		{
		$text2[$userdata->last_name.$userdata->first_name] = ob_get_clean();
		$nocl[$userdata->last_name.$userdata->first_name] = '<a href="#'.$userdata->ID.'">'.$userdata->first_name. " ". $userdata->last_name."</a>";
		}
	}

krsort($cl_leaders);
ksort($nocl);
ksort($text2);

$output = $table2 = '';
foreach($cl_leaders as $count => $users)
	{

	foreach($users as $user)
		{
		$output .= $text[$user->ID];

		$table2 .= '<tr><td>'.$count.'</td>'.$project_gaps[$user->ID].'</tr>';
		}
	}

echo "<table><tr><th>#</th><th class=\"name\">Name</th><th class=\"project\">".__('Project','rsvpmaker-for-toastmasters')." 1</th>
<th class=\"project\">".__('Project','rsvpmaker-for-toastmasters')." 2</th>
<th class=\"project\">".__('Project','rsvpmaker-for-toastmasters')." 3</th>
<th class=\"project\">".__('Project','rsvpmaker-for-toastmasters')." 4</th>
<th class=\"project\">".__('Project','rsvpmaker-for-toastmasters')." 5</th>
<th class=\"project\">".__('Project','rsvpmaker-for-toastmasters')." 6</th>
<th class=\"project\">".__('Project','rsvpmaker-for-toastmasters')." 7</th>
<th class=\"project\">".__('Project','rsvpmaker-for-toastmasters')." 8</th>
<th class=\"project\">".__('Project','rsvpmaker-for-toastmasters')." 9</th>
<th class=\"project\">".__('Project','rsvpmaker-for-toastmasters')." 10</th>
</tr>
$table2
</table>";

echo "<h3>None</h3>";
echo "<div>".implode("<br />",$nocl)."</div>";

echo $output . implode($text2);


tm_admin_page_bottom($hook);
}

function cl_progress ($userdata) {

global $myroles;
global $project_gaps;
if(empty($project_gaps[$userdata->ID])) $project_gaps[$userdata->ID] = '';
printf('<h2 id="%d">%s %s</h2>',$userdata->ID, $userdata->first_name,$userdata->last_name);
$project_gaps[$userdata->ID] .= sprintf('<td class="name"><a href="#%s">%s %s</a></td>',$userdata->ID, $userdata->first_name,$userdata->last_name);

$myroles = awesome_get_stats($userdata->ID);

$completed = 0;

echo '<h3>'.__('PROJECT 1: Listening','rsvpmaker-for-toastmasters').'<br />
'.__('COMPLETE 3 OF 4','rsvpmaker-for-toastmasters').'</h3>';

$choices = array(
'Ah Counter',
'Grammarian',
'Table Topics',
'Evaluator');
$goal = 3;
$met = is_requirement_met($userdata->ID, $choices, $goal);

if($met)
	{
	$completed++;
	echo '<h4 style="color: green;">'.__('Project Complete','rsvpmaker-for-toastmasters').'</h4>';
	$project_gaps[$userdata->ID] .= '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">'.__('Done!','rsvpmaker-for-toastmasters').'</div>'.__('Listening: 3 OF 4','rsvpmaker-for-toastmasters').'</td>';
	}
else
	$project_gaps[$userdata->ID] .= '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">'.__('TO DO','rsvpmaker-for-toastmasters').sprintf('</div><a href="#%s">%s</a></td>',$userdata->ID,__('Listening: 3 OF 4','rsvpmaker-for-toastmasters'));

echo "<h3>".__('PROJECT 2: Critical Thinking','rsvpmaker-for-toastmasters')."<br />
 ".__("COMPLETE 2 OF 3",'rsvpmaker-for-toastmasters')."</h3>";

$choices = array(
'Grammarian',
'General Evaluator',
'Evaluator');

$goal = 2;
$met = is_requirement_met($userdata->ID, $choices, $goal);

if($met)
	{
	$completed++;
	echo '<h4 style="color: green;">'.__('Project Complete','rsvpmaker-for-toastmasters').'</h4>';
	$project_gaps[$userdata->ID] .= '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">Done!</div>'.sprintf('%s</td>', __('Critical Thinking: 2 OF 3','rsvpmaker-for-toastmasters') );
	}
else
	$project_gaps[$userdata->ID] .= '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">'.__('TO DO','rsvpmaker-for-toastmasters').'</div>'.sprintf('<a href="#%s">%s</a></td>',$userdata->ID,__('Critical Thinking: 2 OF 3','rsvpmaker-for-toastmasters'));

echo "<h3>".__("PROJECT 3: Giving Feedback",'rsvpmaker-for-toastmasters')."<br />
".__("COMPLETE 3 OF 3",'rsvpmaker-for-toastmasters')."</h3>";

$choices = array(
'Grammarian',
'General Evaluator',
'Evaluator');

$goal = 3;
$met = is_requirement_met($userdata->ID, $choices, $goal);

if($met)
	{
	$completed++;
	echo '<h4 style="color: green;">'.__('Project Complete','rsvpmaker-for-toastmasters').'</h4>';
	$project_gaps[$userdata->ID] .= '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">'.__('Done!','rsvpmaker-for-toastmasters').'</div>'.sprintf('%s</td>',__('Feedback: 3 OF 3','rsvpmaker-for-toastmasters') );
	}
else
	$project_gaps[$userdata->ID] .= '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">'.__('TO DO','rsvpmaker-for-toastmasters').'</div>'.sprintf('<a href="#%s">%s</a></td>',$userdata->ID,__('Feedback: 3 OF 3','rsvpmaker-for-toastmasters'));

echo "<h3>".__("PROJECT 4: Time Management",'rsvpmaker-for-toastmasters')."<br />
  ".__("COMPLETE TIMER",'rsvpmaker-for-toastmasters')."</h3>";
$choices = array(
'Timer');

$goal = 1;
$met = is_requirement_met($userdata->ID, $choices, $goal);

echo "<h3>+1 ".__("Other",'rsvpmaker-for-toastmasters')."</h3>\n";

$choices = array(
'Grammarian',
'Speaker',
'Topics Master',
'Toastmaster of the Day');

$goal = 1;
$met2 = is_requirement_met($userdata->ID, $choices, $goal);

if($met && $met2)
	{
	$completed++;
	echo '<h4 style="color: green;">Project Complete</h4>';
	$project_gaps[$userdata->ID] .= '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">Done!</div>'.sprintf('%s</td>',__('Timer + One Other','rsvpmaker-for-toastmasters'));
	}
elseif($met)
	$project_gaps[$userdata->ID] .= '<td class="project"><div width="width: 100%; border: thin solid red; font-weight: bold;"><div style="width: 50%; background-color: red; color: #fff;">'.__('Goal 1','rsvpmaker-for-toastmasters').'</div></div>'.sprintf('<a href="#%s">%s</a></td>',$userdata->ID,__('DONE Timer TO DO + One Other','rsvpmaker-for-toastmasters'));
elseif($met2)
	$project_gaps[$userdata->ID] .= '<td class="project"><div width="width: 100%; border: thin solid red; font-weight: bold;"><div style="width: 50%; background-color: red; color: #fff;">'.__('Goal 2','rsvpmaker-for-toastmasters').'</div></div>'.sprintf('<a href="#%s">%s</a></td>',$userdata->ID,__('TO DO Timer DONE + One Other','rsvpmaker-for-toastmasters') );
else
	$project_gaps[$userdata->ID] .= '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">'.__('TO DO','rsvpmaker-for-toastmasters').'</div>'.sprintf('<a href="#%s">%s</a></td>',$userdata->ID,__('Timer + One Other','rsvpmaker-for-toastmasters'));

echo "<h3>".__('PROJECT 5: Planning and Implementation','rsvpmaker-for-toastmasters').'<br />
  '.__('COMPLETE 3 OF 4','rsvpmaker-for-toastmasters')."</h3>\n";

$choices = array(
'Speaker',
'Topics Master',
'General Evaluator',
'Toastmaster of the Day');

$goal = 3;
$met = is_requirement_met($userdata->ID, $choices, $goal);

if($met)
	{
	$completed++;
	echo '<h4 style="color: green;">'.__('Project Complete','rsvpmaker-for-toastmasters').'</h4>';
	$project_gaps[$userdata->ID] .= '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">Done!</div>'.sprintf('%s</td>',__('Planning & Implementation: 3 OF 4','rsvpmaker-for-toastmasters'));
	}
else
	$project_gaps[$userdata->ID] .= '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">'.__('TO DO','rsvpmaker-for-toastmasters').'</div>'.sprintf('<a href="#%s">%s</a></td>',$userdata->ID,__('Planning & Implementation: 3 OF 4','rsvpmaker-for-toastmasters'));

echo "<h3>".__("PROJECT 6: Organization and Delegation",'rsvpmaker-for-toastmasters')."<br />
  ".__("COMPLETE 1 OF 6",'rsvpmaker-for-toastmasters')."</h3>\n";

$choices = array(
"Help Organize a Club Speech Contest",
"Help Organize a Club Special Event",
"Help Organize a Club Membership Campaign or Contest",
"Help Organize a Club PR Campaign",
"Help Produce a Club Newsletter",
"Assist the Club’s Webmaster"
);

$goal = 1;
$met = is_requirement_met($userdata->ID, $choices, $goal);

if($met)
	{
	$completed++;
	echo '<h4 style="color: green;">'.__("Project Complete",'rsvpmaker-for-toastmasters').'</h4>';
	$project_gaps[$userdata->ID] .= '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">'.__('Done!','rsvpmaker-for-toastmasters').'</div>'.sprintf('%s</td>',__('Organization & Delegation: 1 of 6','rsvpmaker-for-toastmasters') );
	}
else
	$project_gaps[$userdata->ID] .= '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">TO DO</div>'.sprintf('<a href="#%s">%s</a></td>',$userdata->ID, __('Organization & Delegation: 1 of 6','rsvpmaker-for-toastmasters') );

echo "<h3>".__("PROJECT 7: Facilitation",'rsvpmaker-for-toastmasters')."<br />
  ".__("COMPLETE 2 OF 4",'rsvpmaker-for-toastmasters')."</h3>\n";

$choices = array(
"Befriend a Guest",
'General Evaluator',
"Topics Master",
'Toastmaster of the Day');

$goal = 2;
$met = is_requirement_met($userdata->ID, $choices, $goal);

if($met)
	{
	$completed++;
	echo '<h4 style="color: green;">'.__('Project Complete','rsvpmaker-for-toastmasters').'</h4>';
	$project_gaps[$userdata->ID] .= '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">'.__('Done!','rsvpmaker-for-toastmasters').'</div>'.sprintf('%s</td>',__('Facilitation: 2 OF 4','rsvpmaker-for-toastmasters') );
	}
else
	$project_gaps[$userdata->ID] .= '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">TO DO</div>'.sprintf('<a href="#%s">%s</a></td>',$userdata->ID,__('Facilitation: 2 of 4','rsvpmaker-for-toastmasters') );

echo "<h3>".__("PROJECT 8: Motivation",'rsvpmaker-for-toastmasters')."<br />
  ".__("COMPLETE 1 CHAIR","rsvpmaker-for-toastmasters")."</h3>\n";

$choices = array("Membership Campaign Chair",
"Club Speech Contest Chair"
);

$goal = 1;
$met = is_requirement_met($userdata->ID, $choices, $goal);

echo "<h3> +2 ".__("OTHERS","rsvpmaker-for-toastmasters")."</h3>\n";

$choices = array(
'Evaluator',
'General Evaluator',
'Toastmaster of the Day',
"PR Campaign Chair");

$goal = 2;
$met2 = is_requirement_met($userdata->ID, $choices, $goal);

if($met && $met2)
	{
	$completed++;
	echo '<h4 style="color: green;">'.__('Project Complete','rsvpmaker-for-toastmasters').'</h4>';
	$project_gaps[$userdata->ID] .= '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">'.__('Done!','rsvpmaker-for-toastmasters').'</div>'.sprintf('%s</td>',__('Motivation: Chair + 1 Other','rsvpmaker-for-toastmasters') );
	}
elseif($met)
	$project_gaps[$userdata->ID] .= '<td class="project"><div width="width: 100%; border: thin solid red; font-weight: bold;"><div style="width: 50%; background-color: red; color: #fff;">'.__('Goal 1','rsvpmaker-for-toastmasters').'</div></div>'.sprintf('<a href="#%s">%s</a></td>',$userdata->ID,__('DONE Chair TO DO + One Other','rsvpmaker-for-toastmasters') );
elseif($met2)
	$project_gaps[$userdata->ID] .= '<td class="project"><div width="width: 100%; border: thin solid red; font-weight: bold;"><div style="width: 50%; background-color: red; color: #fff;">Goal 2</div></div>'.sprintf('<a href="#%s">%s</a></td>',$userdata->ID,__('TO DO Chair DONE + One Other','rsvpmaker-for-toastmasters') );
else
	$project_gaps[$userdata->ID] .= '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">'.__('TO DO','rsvpmaker-for-toastmasters').'</div>'.sprintf('<a href="#%s">%s</a></td>',$userdata->ID,__('Motivation: Chair + 1 Other','rsvpmaker-for-toastmasters') );

echo "<h3>".__("PROJECT 9: Mentoring",'rsvpmaker-for-toastmasters')."<br />
  ".__("COMPLETE 1 OF 3",'rsvpmaker-for-toastmasters')."</h3>\n";

$choices = array(
"Mentor for a New Member",
"Mentor for an Existing Member",
"HPL Guidance Committee Member"
);

$goal = 1;
$met = is_requirement_met($userdata->ID, $choices, $goal);

if($met)
	{
	$completed++;
	echo '<h4 style="color: green;">'.__('Project Complete','rsvpmaker-for-toastmasters').'</h4>';
	$project_gaps[$userdata->ID] .= '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">Done!</div>'.sprintf('%s</td>',__('Mentoring: 1 of 3','rsvpmaker-for-toastmasters') );
	}
else
	$project_gaps[$userdata->ID] .= '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">'.__('TO DO','rsvpmaker-for-toastmasters').'</div>'.sprintf('<a href="#%s">%s</a></td>',$userdata->ID,__('Mentoring: 1 of 3','rsvpmaker-for-toastmasters') );

echo "<h3>".__("PROJECT 10: Team Building",'rsvpmaker-for-toastmasters')."<br />
  ".__("COMPLETE TOASTMASTER + GENERAL EVALUATOR","rsvpmaker-for-toastmasters")."</h3>";
  
$choices = array(
'Toastmaster of the Day',
'General Evaluator'
);

$goal = 2;
$met = is_requirement_met($userdata->ID, $choices, $goal);

echo "<h3>".__("OR 1 OF THE FOLLOWING",'rsvpmaker-for-toastmasters')."</h3>";

$choices = array(
"Membership Campaign Chair",
"Club PR Campaign Chair",
"Club Speech Contest Chair",
"Club Special Event Chair",
"Club Newsletter Editor",
"Club Webmaster");

$goal = 1;
$met2 = is_requirement_met($userdata->ID, $choices, $goal);

if($met || $met2)
	{
	$completed++;
	echo '<h4 style="color: green;">'.__('Project Complete','rsvpmaker-for-toastmasters').'</h4>';
	$project_gaps[$userdata->ID] .= '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">Done!</div>'.sprintf('%s</td>',__('Team Building','rsvpmaker-for-toastmasters'));
	}
else
	$project_gaps[$userdata->ID] .= '<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">'.__('TO DO','rsvpmaker-for-toastmasters').'</div>'.sprintf('<a href="#%s">%s</a></td>',$userdata->ID,__('Team Building','rsvpmaker-for-toastmasters') );

return $completed;
}

function cl_project_gaps ($userdata) {

printf('<tr><td class="name">%s %s</td>',$userdata->first_name,$userdata->last_name);

$myroles = awesome_get_stats($userdata->ID);

$completed = 0;

$choices = array(
'Ah Counter',
'Evaluator',
'Grammarian',
'Table Topics');
$goal = 3;
$met = is_requirement_met($userdata->ID, $choices, $goal, false);

if($met)
	{
	$completed++;
	echo '<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">'.__('Done!','rsvpmaker-for-toastmasters').'</div>'.__('Listening: 3 OF 4','rsvpmaker-for-toastmasters').'</td>';
	}
else
	printf('<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">'.__('TO DO','rsvpmaker-for-toastmasters').'</div><a href="#%s">%s</a></td>',$userdata->ID,__('Listening: 3 OF 4','rsvpmaker-for-toastmasters') );

$choices = array(
'Grammarian',
'Evaluator',
'General Evaluator');

$goal = 2;
$met = is_requirement_met($userdata->ID, $choices, $goal, false);

if($met)
	{
	$completed++;
	printf('<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">Done!</div>%s</td>',__('Critical Thinking: 2 OF 3','rsvpmaker-for-toastmasters') );
	}
else
	printf('<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">TO DO</div><a href="#%s">%s</a></td>',$userdata->ID,__('Critical Thinking: 2 OF 3','rsvpmaker-for-toastmasters') );

$choices = array(
'Grammarian',
'Evaluator',
'General Evaluator');

$goal = 3;
$met = is_requirement_met($userdata->ID, $choices, $goal, false);

if($met)
	{
	$completed++;
	printf('<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">'.__('Done!','rsvpmaker-for-toastmasters').'</div>%s</td>',__('Feedback: 3 OF 3','rsvpmaker-for-toastmasters') );
	}
else
	printf('<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">'.__('TO DO','rsvpmaker-for-toastmasters').'</div><a href="#%s">%s</a></td>',$userdata->ID,__('Feedback: 3 OF 3','rsvpmaker-for-toastmasters') );

$choices = array(
'Timer');

$goal = 1;
$met = is_requirement_met($userdata->ID, $choices, $goal, false);

$choices = array(
'Grammarian',
'Speaker',
'Topics Master',
'Toastmaster of the Day');

$goal = 1;
$met2 = is_requirement_met($userdata->ID, $choices, $goal, false);

if($met && $met2)
	{
	$completed++;
	printf('<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">Done!</div>%s</td>',__('Timer + One Other','rsvpmaker-for-toastmasters') );
	}
elseif($met)
	printf('<td class="project"><div width="width: 100%; border: thin solid red; font-weight: bold;"><div style="width: 50%; background-color: red;  color: #fff;">%s</div></div><a href="#%s">%s</a></td>', __('Goal 1','rsvpmaker-for-toastmasters'), $userdata->ID,'DONE Timer TO DO + One Other');
elseif($met2)
	printf('<td class="project"><div width="width: 100%; border: thin solid red; font-weight: bold;"><div style="width: 50%; background-color: red; color: #fff;">%s</div></div><a href="#%s">%s</a></td>',__('Goal 2','rsvpmaker-for-toastmasters'),$userdata->ID,'TO DO Timer DONE + One Other');
else
	printf('<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">'.__('TO DO','rsvpmaker-for-toastmasters').'</div><a href="#%s">%s</a></td>',$userdata->ID,__('Timer + One Other','rsvpmaker-for-toastmasters') );

$choices = array(
'Speaker',
'Topics Master',
'General Evaluator',
'Toastmaster of the Day');

$goal = 3;
$met = is_requirement_met($userdata->ID, $choices, $goal, false);

if($met)
	{
	$completed++;
	printf('<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">'.__('Done!','rsvpmaker-for-toastmasters').'</div>%s</td>',__('Planning & Implementation: 3 OF 4','rsvpmaker-for-toastmasters') );
	}
else
	printf('<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">'.__('TO DO','rsvpmaker-for-toastmasters').'</div><a href="#%s">%s</a></td>',$userdata->ID, __('Planning & Implementation: 3 OF 4','rsvpmaker-for-toastmasters') );

$choices = array(
"Help Organize a Club Speech Contest",
"Help Organize a Club Special Event",
"Help Organize a Club Membership Campaign or Contest",
"Help Organize a Club PR Campaign",
"Help Produce a Club Newsletter",
"Assist the Club’s Webmaster"
);

$goal = 1;
$met = is_requirement_met($userdata->ID, $choices, $goal, false);

if($met)
	{
	$completed++;
	printf('<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">'.__('Done!','rsvpmaker-for-toastmasters').'</div>%s</td>',__('Organization & Delegation: 1 of 6','rsvpmaker-for-toastmasters') );
	}
else
	printf('<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">'. __('TO DO','rsvpmaker-for-toastmasters') .'</div><a href="#%s">%s</a></td>',$userdata->ID,__('Organization & Delegation: 1 of 6','rsvpmaker-for-toastmasters') );

$choices = array(
'General Evaluator',
"Topics Master",
'Toastmaster of the Day',
"Befriend a Guest"
);

$goal = 2;
$met = is_requirement_met($userdata->ID, $choices, $goal, false);

if($met)
	{
	$completed++;
	printf('<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">'. __('Done!','rsvpmaker-for-toastmasters') .'</div>%s</td>',__('Facilitation: 2 OF 4','rsvpmaker-for-toastmasters') );
	}
else
	printf('<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">' . __('TO DO','rsvpmaker-for-toastmasters') . '</div><a href="#%s">%s</a></td>',$userdata->ID, __('Facilitation: 2 of 4','rsvpmaker-for-toastmasters') );

$choices = array("Membership Campaign Chair",
"Club Speech Contest Chair"
);

$goal = 1;
$met = is_requirement_met($userdata->ID, $choices, $goal, false);

$choices = array(
"PR Campaign Chair",
'Evaluator',
'General Evaluator',
'Toastmaster of the Day');

$goal = 2;
$met2 = is_requirement_met($userdata->ID, $choices, $goal, false);

if($met && $met2)
	{
	$completed++;
	printf('<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">' .__('Done!','rsvpmaker-for-toastmasters'). '</div>%s</td>', __('Motivation: Chair + 1 Other','rsvpmaker-for-toastmasters') );
	}
elseif($met)
	printf('<td class="project"><div width="width: 100%; border: thin solid red; font-weight: bold;"><div style="width: 50%; background-color: red;  color: #fff;">' . __('Goal 1','rsvpmaker-for-toastmasters'). '</div></div><a href="#%s">%s</a></td>',$userdata->ID, __('DONE Chair TO DO + One Other','rsvpmaker-for-toastmasters') );
elseif($met2)
	printf('<td class="project"><div width="width: 100%; border: thin solid red; font-weight: bold;"><div style="width: 50%; background-color: red;  color: #fff;">'.__('Goal 2','rsvpmaker-for-toastmasters').'</div></div><a href="#%s">%s</a></td>',$userdata->ID, __('TO DO Chair DONE + One Other','rsvpmaker-for-toastmasters') );
else
	printf('<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">'.__('TO DO','rsvpmaker-for-toastmasters').'</div><a href="#%s">%s</a></td>',$userdata->ID, __('Motivation: Chair + 1 Other','rsvpmaker-for-toastmasters') );

$choices = array(
"Mentor for a New Member",
"Mentor for an Existing Member",
"HPL Guidance Committee Member"
);

$goal = 1;
$met = is_requirement_met($userdata->ID, $choices, $goal, false);

if($met)
	{
	$completed++;
	printf('<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">'.__('Done!','rsvpmaker-for-toastmasters').'</div>%s</td>',__('Mentoring: 1 of 3','rsvpmaker-for-toastmasters') );
	}
else
	printf('<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">'.__('TO DO','rsvpmaker-for-toastmasters').'</div><a href="#%s">%s</a></td>',$userdata->ID,__('Mentoring: 1 of 3','rsvpmaker-for-toastmasters') );

$choices = array(
'Toastmaster of the Day',
'General Evaluator'
);

$goal = 2;
$met = is_requirement_met($userdata->ID, $choices, $goal, false);

$choices = array(
"Membership Campaign Chair",
"Club PR Campaign Chair",
"Club Speech Contest Chair",
"Club Special Event Chair",
"Club Newsletter Editor",
"Club Webmaster");

$goal = 1;
$met2 = is_requirement_met($userdata->ID, $choices, $goal, false);

if($met || $met2)
	{
	$completed++;
	printf('<td class="project"><div style="width: 100%; background-color: red; color: #fff; font-weight: bold;">'.__('Done!','rsvpmaker-for-toastmasters').'</div>%s</td>',__('Team Building','rsvpmaker-for-toastmasters'));
	}
else
	printf('<td class="project"><div style="width: 100%; border: thin solid red; font-weight: bold;">'.__('TO DO','rsvpmaker-for-toastmasters').'</div><a href="#%s">%s</a></td>',$userdata->ID,__('Team Building','rsvpmaker-for-toastmasters') );

return $completed;
}




function get_latest_visit ($user_id) {
global $wpdb;
$wpdb->show_errors();

	$sql = "SELECT DISTINCT a1.meta_value as datetime
	 FROM ".$wpdb->posts."
	 JOIN ".$wpdb->postmeta." a1 ON ".$wpdb->posts.".ID =a1.post_id AND a1.meta_key='_rsvp_dates'
	 JOIN ".$wpdb->postmeta." a2 ON ".$wpdb->posts.".ID =a2.post_id AND a2.meta_value=".$user_id." AND BINARY a2.meta_key RLIKE '^_[A-Z].+[0-9]$'  
	 WHERE a1.meta_value < NOW() 
	 ORDER BY a1.meta_value DESC";
$date = $wpdb->get_var($sql);
if($date)
	return date('Y-m-d',strtotime($date));
else
	return 'N/A';
}

function last_filled_role ($user_id, $role) {
global $wpdb, $rsvp_options;
$wpdb->show_errors();

$role = preg_replace('/[0-9]/','',$role);

	$sql = "SELECT DISTINCT a1.meta_value as datetime
	 FROM ".$wpdb->posts."
	 JOIN ".$wpdb->postmeta." a1 ON ".$wpdb->posts.".ID =a1.post_id AND a1.meta_key='_rsvp_dates'
	 JOIN ".$wpdb->postmeta." a2 ON ".$wpdb->posts.".ID =a2.post_id AND a2.meta_value=".$user_id." AND a2.meta_key LIKE '".$role."%'   
	 WHERE a1.meta_value < NOW() 
	 ORDER BY a1.meta_value DESC";
$date = $wpdb->get_var($sql);
if($date)
	return date('Y-m-d',strtotime($date));
else
	return 'N/A';
}

function toastmasters_mentors() {

$hook = tm_admin_page_top(__('Mentors','rsvpmaker-for-toastmasters'));

if(isset($_POST["mentor"]))
	{
		foreach($_POST["mentor"] as $user_id => $mentor)
			{
				if(!empty($mentor) )
					{
						update_user_meta($user_id, 'mentor', $mentor);
					}
			}

echo '<div id="message" class="updated">
		<p><strong>'.__('Mentor list updated','rsvpmaker-for-toastmasters').'</strong></p>
	</div>';

	}

if(isset($_GET["edit"]))
	printf('<h2><a class="add-new-h2" href="%s">%s</a></h2>',admin_url('admin.php?page=toastmasters_mentors'),__('Return to Report','rsvpmaker-for-toastmasters') );
else
	printf('<h2><a class="add-new-h2" href="%s">%s</a></h2>',admin_url('admin.php?page=toastmasters_mentors&edit=1'), __('Edit','rsvpmaker-for-toastmasters') );

if(!isset($_GET["all"]))
{
$datefilter = strtotime('3 months ago');
printf('<p><em>'.__('Filtered by default to show members active within the last 3 months','rsvpmaker-for-toastmasters').' ('.__('since','rsvpmaker-for-toastmasters').' %s) <strong>'.__('AND','rsvpmaker-for-toastmasters').'</strong> '.__('who have not yet attained an educational award such as CC or CL','rsvpmaker-for-toastmasters').' <a href="%s">('.__('show all','rsvpmaker-for-toastmasters').')</a></em></p>',date('m/d/Y',$datefilter),admin_url('admin.php?page=toastmasters_mentors&all=1'));
}

$blogusers = get_users('blog_id='.get_current_blog_id() );
    foreach ($blogusers as $user) {	
	$userdata = get_userdata($user->ID);
	if($userdata->hidden_profile)
		continue;
	$ts = strtotime(get_latest_visit ($user->ID));
	if(!isset($_GET["all"]))
		{
			if( $ts && ($datefilter > $ts) )
				continue;
		}

	$index = preg_replace('/[^A-Za-z]/','',$userdata->last_name.$userdata->first_name.$userdata->user_login);
	$members[$index] = $userdata;
	}

if(empty($members))
	return;
ksort($members);

if(isset($_GET["edit"]) && current_user_can('edit_others_rsvpmakers') )
	printf('<form action="%s" method="post">',admin_url('admin.php?page=toastmasters_mentors&edit=1') );

foreach($members as $userdata)
	{
	if(isset($_GET["edit"]) && current_user_can('edit_others_rsvpmakers') )
		printf('<p>%s %s: <input type="text" name="mentor[%d]" value="%s" /></p>',$userdata->first_name,$userdata->last_name, $userdata->ID, $userdata->mentor);
	else
		printf('<p>%s %s: %s</p>',$userdata->first_name,$userdata->last_name, $userdata->mentor);
	}

if(isset($_GET["edit"]) && current_user_can('edit_others_rsvpmakers') )
	echo '<button>'.__('Save','rsvpmaker-for-toastmasters').'</button></form>';

tm_admin_page_bottom($hook);
}

function toastmasters_edit_stats() {

$hook = tm_admin_page_top(__('Edit Member Stats','rsvpmaker-for-toastmasters'));

global $wpdb;
global $toast_roles;
global $competent_leader;

$tasks = '<option value="">'.__('Choose a Project','rsvpmaker-for-toastmasters').'</option>';
foreach($competent_leader as $task)
	{
		$tasks .= sprintf('<option value="%s">%s</option>',$task,$task);
	}
?>
<style>
td,th {
border: thin solid #000;
text-align:center;	
	}
th.role {
	min-width: 90px;
    max-width: 100px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;

}
</style>
<?php
echo '<div class="wrap"><h2>'.__('Edit Member Stats','rsvpmaker-for-toastmasters').'</h2>';
if(isset($_POST["newstat"]) && $_POST["newstat"])
	{
		$wpdb->show_errors();
		foreach($_POST["newstat"] as $user_id => $newroles)
			{
					foreach($newroles as $role => $count)
					{
						$oldcount = (int) $_POST["oldstat"][$user_id][$role];
						if(!is_numeric($count))
						{
						update_user_meta($user_id, $role, $count);
						}
						elseif($count != $oldcount)
						{
							$adjustment = $count - $oldcount;
							$sql = sprintf( "INSERT into %s SET user_id=%d, role='%s', quantity=%d, datetime=CURDATE() ",$wpdb->prefix.'toastmasters_history',$user_id, $role, $adjustment );
					$wpdb->show_errors();
							$wpdb->query($sql);
						}
					}

					
			}

if(isset($_POST["editcl"]))
foreach($_POST["editcl"] as $user_id => $cl_updates)
	{
		foreach($cl_updates as $role)
			{
				if(!empty($role) )
					{
					$sql = sprintf( "INSERT into %s SET user_id=%d, role='%s', quantity=1, datetime=CURDATE() ",$wpdb->prefix.'toastmasters_history',$user_id, $role);
					$wpdb->show_errors();
					$wpdb->query($sql);
					}
			}
	}

printf('<div id="message" class="updated">
		<p><strong>%s.</strong></p>
	</div>',__('Member stats updated','rsvpmaker-for-toastmasters') );

	}

printf('<form action="%s" method="post">',admin_url('admin.php?page=toastmasters_edit_stats') );

$blogusers = get_users('blog_id='.get_current_blog_id() );
    foreach ($blogusers as $user) {	
	$userdata = get_userdata($user->ID);
	if($userdata->hidden_profile)
		continue;
	$index = preg_replace('/[^A-Za-z]/','',$userdata->last_name.$userdata->first_name.$userdata->user_login);
	$members[$index] = $userdata;
	$achievements[$index] = awesome_get_stats($userdata->ID);
	}

$l = '<table class="wp-list-table widefat fixed posts" ><tr><th  class="role">'.__('COMPETENT COMMUNICATION','rsvpmaker-for-toastmasters').'</th>';
foreach ($toast_roles as $role)
	{
	if($role == 'Topics Master')
		$role = 'TT Master';
	$l .= '<th class="role">'.$role."</th>";
	}
$l .= "</tr>";

ksort($members);

$ed = '';
foreach ($members as $index => $userdata)
	{
		$myroles = $achievements[$index];
		printf('<h3 id="%d">%s %s - <a href="%s">'.__('View','rsvpmaker-for-toastmasters').'</a></h3>',$userdata->ID, $userdata->first_name, $userdata->last_name,admin_url('admin.php?page=toastmasters_reports&toastmaster=').$userdata->ID);
		echo $l;
		echo "<tr><td>";
			printf('<input type="text" name="newstat[%d][%s]" value="%d" size="2" />',$userdata->ID,"COMPETENT COMMUNICATION",$myroles["COMPETENT COMMUNICATION"]);
		if($myroles["COMPETENT COMMUNICATION"])
			printf('<input type="hidden" name="oldstat[%d][%s]" value="%d" size="2" />',$userdata->ID,"COMPETENT COMMUNICATION",$myroles["COMPETENT COMMUNICATION"]);
		echo "</td>";
		foreach($toast_roles as $role)
			{
				echo "<td>";
				printf('<input type="text" name="newstat[%d][%s]" value="%d" size="2" />',$userdata->ID,$role,$myroles[$role]);
			if($myroles[$role])
				printf('<input type="hidden" name="oldstat[%d][%s]" value="%d" size="2" />',$userdata->ID,$role,$myroles[$role]);
				echo "</td>";
			}
		echo "</tr>";
		echo "</table>";
		$cl = array();
		foreach($competent_leader as $role)
			{
				if(isset($myroles[$role]) )
				{
					$cl[] = $role;
				}
			}
		if(sizeof($cl) )
			{
		echo "<p>CL Projects: ";
			echo implode(', ',$cl);
		echo "</p>";
			}

				printf('<p><b>'.__('Additonal Competent Leader Credits for','rsvpmaker-for-toastmasters').' %s %s</b></p>
				<p><select name="editcl[%d][]">%s</select><select name="editcl[%d][]">%s</select></p>
				<p><select name="editcl[%d][]">%s</select><select name="editcl[%d][]">%s</select></p>
				',$userdata->first_name, $userdata->last_name,$userdata->ID,$tasks,$userdata->ID,$tasks,$userdata->ID,$tasks,$userdata->ID,$tasks);

	}

submit_button();
tm_admin_page_bottom($hook);
}

function import_fth () {

$hook = tm_admin_page_top(__('Import Free Toast Host Data','rsvpmaker-for-toastmasters'));

?>
<?php
global $wpdb;
global $toast_roles;

$action = admin_url('admin.php?page=import_fth');

if(isset($_POST["speeches"]))
{
$fth_roles = array();
?>
<form action="<?php echo $action; ?>" method="post">
<?php

	echo "<h3>".__('Match Users','rsvpmaker-for-toastmasters')."</h3><p>".__("Either match with a WordPress user or leave blank (Match?) if there is no match, as with a former member.",'rsvpmaker-for-toastmasters')."</p>";

$blogusers = get_users('blog_id='.get_current_blog_id() );
    foreach ($blogusers as $user) {	
	$userdata = get_userdata($user->ID);
	if($userdata->hidden_profile)
		continue;	
	$index = preg_replace('/[^A-Za-z]/','',$userdata->last_name.$userdata->first_name.$userdata->user_login);
	$members[$index] = $userdata;
	$users_id[$userdata->ID] = sprintf('<option value="%s">%s %s</option>',$userdata->ID,$userdata->first_name,$userdata->last_name);
	}
ksort($members);

$userlist = '<option value="">Match?</option>';
foreach($members as $userdata)
	{
		$userlist .= sprintf('<option value="%s">%s %s</option>',$userdata->ID,$userdata->first_name,$userdata->last_name);
	}

if(isset($_POST["speeches"]))
	{

		$lines = explode("\n",$_POST["speeches"]);
		foreach($lines as $index => $line)
			{
				$cells = explode("\t",$line);
				//echo "<h2>Line: $index </h2>";
				if(sizeof($cells) == 6)
					{
					$name = array_shift($cells);
					//echo "<h1>$name</h1>";
					$name = trim($name);
					$nameindex = preg_replace('/[^A-Za-z]/','',$name);
					$names[$nameindex] = $name;
					}
				//print_r($cells);
				$speech["name"][$nameindex][] = $name;
				$name = preg_replace('/, [A-Z]{2,4}/','',$name);
				$speech["date"][$nameindex][] = trim($cells[0]);
				$speech["project"][$nameindex][] = trim($cells[3]);
				$speech["title"][$nameindex][] = trim($cells[2] . ' '. $cells[4]);
			}
	}
if(isset($_POST["stats"]))
	{
		$lines = explode("\n",$_POST["stats"]);
		foreach($lines as $index => $line)
			{
				$cells = explode("\t",$line);
				//echo "<h2>Line: $index </h2>";
				//print_r($cells);
				if(sizeof($cells) == 3)
					{
					$name = array_shift($cells);
					$name = trim($name);
					$nameindex = preg_replace('/[^A-Za-z]/','',$name);
					$names[$nameindex] = $name;
					}
				$stats["date"][$nameindex][] = $cells[0];
				$stats["role"][$nameindex][] = $cells[1];
			}
	ksort($names);
	foreach($names as $nameindex => $name)
		{	
		$p = explode(' ',trim($name));
		$sql = "SELECT user_id from $wpdb->usermeta WHERE meta_key='first_name' AND meta_value LIKE '".$p[0]."%'";
		$results = $wpdb->get_results($sql);
		$matching = '';
		foreach($results as $r)
			$matching .= $users_id[$r->user_id];
		printf('<p><select name="user[%s]">%s</select> = %s</p>',$nameindex,$matching.$userlist,$name);
		}
		
	foreach($stats["date"] as $nameindex => $daterow)
		{
			//print_r($namerow);
			foreach($daterow as $i => $date)
			{
			$t = strtotime($date);
			$dates[$t] = $t;
			$name = $names[$nameindex];
			$role = $stats["role"][$nameindex][$i];
			$role = trim(preg_replace('/ #[0-9]/','',$role));
			if($role == 'Speaker')
				continue; // track speakers through project list instead
			if(!in_array($role,$fth_roles) )
				$fth_roles[] = $role;
			printf('<input type="hidden" name="role[%s][%s]" value="%s" />',$t, $nameindex, $role);
			}
		}
	
	}
	
	echo "<h3>Match Roles</h3>";
	sort($fth_roles);
	foreach($fth_roles as $role)
	{
			$options = '<option value="">Match?</option>';
			
			foreach($toast_roles as $tracked)
				{
					$s = ($role == $tracked) ? ' selected="selected" ' : '';
					if(($role == 'Toastmaster') && ($tracked == 'Toastmaster of the Day'))
						$s = ' selected="selected" ';
					if(($role == 'Topic Master') && ($tracked == 'Topics Master'))
						$s = ' selected="selected" ';
					if(($role == 'Table Topics Contestant') && ($tracked == 'Table Topics'))
						$s = ' selected="selected" ';
					
					$options .= sprintf('<option value="%s" %s> %s</option>',$tracked, $s, $tracked);
				}
	printf('<p><select name="rolelist[%s]">%s</select> = %s</p>',$role, $options, $role);
	}

	echo "<h3>Speech Projects</h3>";
	$project_options = get_toast_speech_options();
	foreach($speech["name"] as $nameindex => $namerow)
		{
			//print_r($namerow);
			foreach($namerow as $i => $name)
			{
			$date = $speech["date"][$nameindex][$i];
			$t = strtotime($date);
			$dates[$t] = $t;
			$project = $speech["project"][$nameindex][$i];
			$title = $speech["title"][$nameindex][$i];
			printf('<p>'.__('Member','rsvpmaker-for-toastmasters').': %s '.__('Date','rsvpmaker-for-toastmasters').': <input type="text" name="speechdate[%s][]" value="%s"> <br />'.__('Project','rsvpmaker-for-toastmasters').': <select name="project[%s][%s]"><option value="%s">%s</option>%s</select>
			<br />Title: <input type="text" name="title[%s][%s]" value="%s"></p>',$name, $nameindex, $date, $t, $nameindex, $project, $project, $project_options, $t, $nameindex, $title);
			}
		}

	printf('<input type="hidden" name="dates" value="%s" />',implode(",",$dates));

submit_button(__('Import Records (step 2)','rsvpmaker-for-toastmasters'),'primary'); ?>
</form>
<?php
}
elseif(isset($_POST["dates"]))
{
	
	printf('<h3>'.__('Recording data. Verify by checking','rsvpmaker-for-toastmasters').' <a href="%s">'.__('Toastmaster Reports','rsvpmaker-for-toastmasters').'</a>.</h3>',admin_url('admin.php?page=toastmasters_reports'));
	foreach($_POST["user"] as $nameindex => $id)
		{
			if($id)
				$users[$nameindex] = (int) $id;
		}

	$dates = explode(",",$_POST["dates"]);
	sort($dates);
	foreach($dates as $date)
		{
			$t = (int) $date;
			if($t == 0)
				continue;
			$sqldate = date('Y-m-d H:i:s',$t);
			
			$p = array('post_title' => __('Historical Data','rsvpmaker-for-toastmasters'),'post_type' => 'historical-toastmsters-data','post_content' => __('used to track events imported from Free Toast Host. Do not delete.','rsvpmaker-for-toastmasters'),'post_status' => 'publish');
			$post_id = wp_insert_post($p);
			
			add_rsvpmaker_date($post_id,$sqldate);
			
			if(is_array($_POST["project"][$date]) )
				{
					$count = 1;
					foreach($_POST["project"][$date] as $nameindex => $project)
						{
						if(isset($users[$nameindex]))
							{
							$user_id = $users[$nameindex];
							$meta_key = '_Speaker_'.$count;
							update_post_meta($post_id, $meta_key, $user_id);
							$count++;
							if(empty($project))
								continue;
							update_post_meta($post_id, '_manual'.$meta_key, $project);
							$title = $_POST["title"][$date][$nameindex];
							if(!empty($title))
								{
								//echo "title: $title <br />";
								update_post_meta($post_id, '_title'.$meta_key, $project);
								}
							}
						}
				}
			if(is_array($_POST["role"][$date]) )
				{
					foreach($_POST["role"][$date] as $nameindex => $role)
						{
						if($_POST["rolelist"][$role])
							$role = $_POST["rolelist"][$role];
						else
							continue;
						if(isset($users[$nameindex]))
							{
							$user = $users[$nameindex];
							update_post_meta($post_id, '_'.$role.'_1', $user_id);
							}
						}
				}
		}
}
else
{ // step 1 form
?>
<form action="<?php echo $action; ?>" method="post">
<h3><?php _e('Paste in the contents of','rsvpmaker-for-toastmasters'); ?> ...</h3>
<?php _e('Member Speech Historical Report','rsvpmaker-for-toastmasters'); ?>:<br />
<textarea name="speeches" cols="100" rows="10"></textarea>
<br />
<?php _e('Member Role Historical Report','rsvpmaker-for-toastmasters'); ?>:<br />
<textarea name="stats" cols="100" rows="10"></textarea>
<?php submit_button(__('Import Records (step 1)','rsvpmaker-for-toastmasters'),'primary'); ?>
</form>
<div style="max-width: 605px;">
<h1>Directions</h1>
<p>This tool allows you to import some of the data collected through your use of Free Toast Host so that it will be reflected in the member performance reports for progress toward CC, CL, etc.</p>
<p>When you are viewing an agenda on Free Toast Host, the reports button is displayed at the top of the screen. Click it.</p>
<p><img src="<?php echo plugins_url('/rsvpmaker-for-toastmasters/fth_agenda_role_rpt.png'); ?>" width="600" height="80" alt="FTH agenda button" /></p>
<p>Free Toast Host displays a dialog box prompting you to choose the report you want to access. We are going to use the Member Speech Report and the Member Role Report (the html version, not the xls download). Under Select Start Date, make sure you select &quot;All.&quot; </p>
<p><img src="<?php echo plugins_url('/rsvpmaker-for-toastmasters/fth-dialog.png'); ?>" width="600" height="392" alt="FTH Dialog box" /></p>
<p>First, select &quot;Member Speech Report (html)&quot; and click <strong>Run/Download</strong>.</p>
<p>If you are prompted to print the document, click <strong>Cancel</strong>. Copy and Paste the all the data (not including the headers at the top) and paste it into the appropriate dialog on this form.</p>
<p><img src="<?php echo plugins_url('/rsvpmaker-for-toastmasters/fth-speech-report.png'); ?>" width="600" height="455" alt="Speech Report" /></p>
<p>Repeat the process for &quot;Member Role Report (html)&quot;.</p>
<p><img src="<?php echo plugins_url('/rsvpmaker-for-toastmasters/fth_member_role_report.png'); ?>" width="600" height="463" alt="Role Report" /></p>
<p>Click <strong>Import Records (step 1)</strong>.</p>
<p>On the next screen, you will be given the opportunity to make some corrections, matching up the names of members with the correct records recorded in WordPress for Toastmasters and matching the names of roles with the standard role names WordPress for Toastmasters uses for reporting.</p>
<p>Some data may not match up perfectly. You may have former members on the historical report for whom there is no matching record in WordPress. You may have roles that don't match up with the standard roles. If you leave those items with no selection, they simply will not be recorded.</p>
<p>If members speech projects were not recorded in Free Toast Host, you can add that information if you have it. Otherwise, leave it blank. The member will still be recorded as having given a speech, even though you haven't specified which one.</p>
<p>Click <strong>Import Records (step 2)</strong> and the data will be recorded.</p>

<?php
tm_admin_page_bottom($hook);

}

}


function toastmasters_activity_log() {

$hook = tm_admin_page_top(__('Activity Log','rsvpmaker-for-toastmasters'));

	global $wpdb;
	$log = "";
	
	if(isset($_GET["filter"]))
		{
		$filter = preg_replace('[^a-zA-Z0-9 ]','',$_GET["filter"]);
		$filterSQL =  " AND meta_value LIKE '%".$filter."%'";
		}
	else
		$filterSQL =  "";
	
	$activity_sql = "SELECT meta_value from $wpdb->postmeta WHERE meta_key='_activity' $filterSQL ORDER BY meta_id DESC LIMIT 0,1000";
	$log = $wpdb->get_results($activity_sql);
	$output = '';
	foreach($log as $row)
		{
	  	$output .= "<p>".$row->meta_value . "</p>";
		}
?>
<p><em><?php _e('Optionally, you can filter by the name of a member or by a keyword such as "edited" or "withdrawn."','rsvpmaker-for-toastmasters'); ?></em></p>
<form method="get" action="<?php echo admin_url('admin.php'); ?>">
<input type="hidden" name="page" value="toastmasters_activity_log" />
<input type="text" name="filter" value="<?php if(isset($_GET["filter"])) echo $_GET["filter"]; ?>" />
<button>Filter</button>
</form>
<?php
if(!empty($output))
echo $output;
tm_admin_page_bottom($hook);
}

function toastmasters_progress_report($user_id) {

if(!$user_id)
{
?>
<p>Select member from the list above</p>
<h2>Competent Communicator Progress Report</h2>
<?php toastmasters_cc(); ?>
</section>
<section id="speeches">
Select member from the list above
<?php
return;
}

echo '<style>
td,th {
border: thin solid #000;
text-align:center;	
	}
th.role {
	min-width: 80px;
    max-width: 100px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
</style>';

	global $competent_leader;
	global $toast_roles;	
	$id = (int) $user_id;
	$userdata = get_userdata($id);
	$stats = get_tm_stats($userdata->ID);
	$myroles = $stats["count"];//awesome_get_stats($userdata->ID);
	$pure_count = $stats["pure_count"];
if(isset($_GET["debug"]))
{
	echo "<pre>Adjusted count:\n";
	print_r($myroles);
	echo "\nDetailed Records:\n";
	print_r($pure_count);
	echo "</pre>";


}
	
	printf('<h2>%s %s</h2>',$userdata->first_name, $userdata->last_name);

echo '<h3>Competent Communication</h3>';	
	$count = isset($myroles["COMPETENT COMMUNICATION"]) ? $myroles["COMPETENT COMMUNICATION"] : 0;
	while($count > 10)
		{
			echo '<div style="width: 100%; border: thin solid #000;"><div style="background-color: #772432; padding-top: 5px; padding-bottom: 5px; font-size: large; width: 100%"><span style="font-weight: bold; margin: 5px; text-shadow: 2px 3px 4px #000000; font-size: 35px; color: white;">10</span></div></div><p>additional CC?</p>';
			$count -= 10;
		}
	$bar = $count * 10;
	echo '<div style="width: 100%; border: thin solid #000;"><div style="background-color: #772432; padding-top: 5px; padding-bottom: 5px; font-size: large; width: '.$bar.'%"><span style="font-weight: bold; margin: 5px; text-shadow: 2px 3px 4px #000000; font-size: 35px; color: white;">'.$count.'</span></div></div>';
$table2 = '';
echo '<h3>Competent Leader</h3>';	
	ob_start();
	$count = cl_progress($userdata);
	global $project_gaps;
	$cl_detail = ob_get_clean();
	$table2 .= '<tr><td>'.$count.'</td>'.$project_gaps[$userdata->ID].'</tr>';

echo '<style>
td {vertical-align: text-top;}
td.project, th.project, td.name, th.name {
width: 150px;
}
table {
margin-top: 15px;
width: 95%;
}
</style>
<table><tr><th>#</th><th class="name">Name</th><th class="project">'.__('Project','rsvpmaker-for-toastmasters')." 1</th>
<th class=\"project\">".__('Project','rsvpmaker-for-toastmasters')." 2</th>
<th class=\"project\">".__('Project','rsvpmaker-for-toastmasters')." 3</th>
<th class=\"project\">".__('Project','rsvpmaker-for-toastmasters')." 4</th>
<th class=\"project\">".__('Project','rsvpmaker-for-toastmasters')." 5</th>
<th class=\"project\">".__('Project','rsvpmaker-for-toastmasters')." 6</th>
<th class=\"project\">".__('Project','rsvpmaker-for-toastmasters')." 7</th>
<th class=\"project\">".__('Project','rsvpmaker-for-toastmasters')." 8</th>
<th class=\"project\">".__('Project','rsvpmaker-for-toastmasters')." 9</th>
<th class=\"project\">".__('Project','rsvpmaker-for-toastmasters')." 10</th>
</tr>
$table2
</table>";

$l = '<h3>Role Statistics</h3><table><tr><th  class="role">'.__('COMPETENT COMMUNICATION','rsvpmaker-for-toastmasters').'</th>';
foreach ($toast_roles as $role)
	{
	if($role == 'Topics Master')
		$role = 'TT Master';
	$l .= '<th class="role">'.$role."</th>";
	}
$l .= "</tr>";
echo $l;

$security = get_tm_security ();
		
if(isset($_GET["edit"]) && current_user_can($security['edit_member_stats']))
{
		echo "<tr><td>";
			printf('<input type="text" name="newstat[%d][%s]" value="%d" size="2" />',$userdata->ID,"COMPETENT COMMUNICATION",$myroles["COMPETENT COMMUNICATION"]);
		if($myroles["COMPETENT COMMUNICATION"])
			printf('<input type="hidden" name="oldstat[%d][%s]" value="%d" size="2" />',$userdata->ID,"COMPETENT COMMUNICATION",$myroles["COMPETENT COMMUNICATION"]);
		echo "</td>";
		foreach($toast_roles as $role)
			{
				echo "<td>";
				printf('<input type="text" name="newstat[%d][%s]" value="%d" size="2" />',$userdata->ID,$role,$myroles[$role]);
			if($myroles[$role])
				printf('<input type="hidden" name="oldstat[%d][%s]" value="%d" size="2" />',$userdata->ID,$role,$myroles[$role]);
				echo "</td>";
			}
		echo "</tr>";
		echo "</table>";
		$cl = array();

		$tasks = '<option value="">Choose a Project</option>';

		foreach($competent_leader as $role)
			{
				$tasks .= sprintf('<option value="%s">%s</option>',$role,$role);
				if(isset($myroles[$role]) )
				{
					$cl[] = $role;
				}
			}
		if(sizeof($cl) )
			{
		echo "<p>CL Projects: ";
			echo implode(', ',$cl);
		echo "</p>";
			}



				printf('<p><b>'.__('Additonal Competent Leader Credits for','rsvpmaker-for-toastmasters').' %s %s</b></p>
				<p><select name="editcl[%d][]">%s</select><select name="editcl[%d][]">%s</select></p>
				<p><select name="editcl[%d][]">%s</select><select name="editcl[%d][]">%s</select></p>
				',$userdata->first_name, $userdata->last_name,$userdata->ID,$tasks,$userdata->ID,$tasks,$userdata->ID,$tasks,$userdata->ID,$tasks);
		
		echo "<p><b>".__('Advanced Manuals','rsvpmaker-for-toastmasters').'</b></p>';
		$manuals = get_manuals_array();
		foreach($manuals as $role => $manual_text)
			{
				if( ($role == "COMPETENT COMMUNICATION") || strpos($role,'Non Manual Speech')  )
					continue;
				echo "<p>";
				printf('<input type="text" name="newstat[%d][%s]" value="%d" size="2" /> %s',$userdata->ID,$role,$myroles[$role],$role);
			if($myroles[$role])
				printf('<input type="hidden" name="oldstat[%d][%s]" value="%d" size="2" />',$userdata->ID,$role,$myroles[$role]);
				echo "</p>";
			}

$manuals_options = get_manuals_options();
$manuals = sprintf('<select class="manual" name="add_speeches_manual[%d][]">
%s</select>',$userdata->ID,$manuals_options);

submit_button();
}
else
{
		if(empty($myroles["COMPETENT COMMUNICATION"])) $myroles["COMPETENT COMMUNICATION"] = 0;
		echo "<tr><td>".$myroles["COMPETENT COMMUNICATION"]."</td>";
		foreach($toast_roles as $role)
			{
				echo (isset($myroles[$role])) ? "<td>".$myroles[$role]."</td>" : '<td>&nbsp;</td>';
			}
		echo "</tr>";
		echo "</table>";

		$manuals = get_manuals_array();
		$adv = "";
		foreach($manuals as $role => $manual_text)
			{
				if(($role == "COMPETENT COMMUNICATION") || empty($myroles[$role]) )
					continue;
				$adv .= sprintf('<p>%s %s</p>',$role,$myroles[$role]);
			}
		if(!empty($adv))
				echo "<h3>".__('Advanced Manuals','rsvpmaker-for-toastmasters').'</h3>'.$adv;

}

$security = get_tm_security ();
		
//echo get_latest_speeches($id, $myroles);

echo '<h3>Competent Leader Detail</h3>';

echo $cl_detail;

//echo get_speeches_by_manual($id);
?>
</section>
<section id="speeches">
<?php
echo $stats["speech_list"];

echo '<h2>Speeches by Manual</h2>';

/*
	$myroles = $stats["count"];//awesome_get_stats($userdata->ID);
	$pure_count = $stats["pure_count"];
*/
$manuals = get_manuals_array();
$speech_array = $stats["speeches"];
foreach($manuals as $mkey => $mtext)
	{
	if(strpos($mkey,'Manual'))
		continue;
	if(empty($myroles[$mkey]))
		continue;
	echo '<h3>'.$mtext.'</h3>';
	if(isset($speech_array[$mkey]))
		echo $speech_array[$mkey];
	$pure = isset($pure_count[$mkey]) ? $pure_count[$mkey] : 0;
	if($myroles[$mkey] != $pure)
		printf('<div>Detailed speech records %d, adjusted count %d for %s</div>',$pure, $myroles[$mkey],$mtext);
	}
}

function my_progress_report () {
toastmasters_reports();
return;
}

function member_list () {
$hook = tm_admin_page_top(__('Member List','rsvpmaker-for-toastmasters'));

$blogusers = get_users('blog_id='.get_current_blog_id());
    foreach ($blogusers as $user) {
	$userdata = get_userdata($user->ID);
	if($userdata->hidden_profile)
		continue;
	$index = preg_replace('/[^A-Za-z]/','',$userdata->last_name.$userdata->first_name.$userdata->user_login);
	$members[$index] = $userdata;
	}
	
	ksort($members);
	foreach($members as $userdata) {
?>	


<h3><?php echo $userdata->first_name.' '.$userdata->last_name?></h3>

<?php
$contactmethods['home_phone'] = __("Home Phone",'rsvpmaker-for-toastmasters');
$contactmethods['work_phone'] = __("Work Phone",'rsvpmaker-for-toastmasters');
$contactmethods['mobile_phone'] = __("Mobile Phone",'rsvpmaker-for-toastmasters');
$contactmethods['user_email'] = __("Email",'rsvpmaker-for-toastmasters');

	foreach($contactmethods as $name => $value)
		{
		if(strpos($name,'phone') && !empty($userdata->$name) )
			{
			printf("<div>%s: %s</div>\n",$value,$userdata->$name);
			}
		}
		printf('<div>'.__("Email",'rsvpmaker-for-toastmasters').': <a href="mailto:%s">%s</a></div>'."\n",$userdata->user_email,$userdata->user_email);
		$status = wp4t_get_member_status($userdata->ID);
		if( !empty($status) )
			printf('<div>'.__("Status",'rsvpmaker-for-toastmasters').': %s</div>'."\n",$status);
	}
tm_admin_page_bottom($hook);
}

function tm_welcome_screen_assets( $hook ) {

  if( strpos($hook,'toastmasters') !== false ) {
    wp_enqueue_style( 'tm_welcome_screen_css', plugin_dir_url( __FILE__ ) . '/admin-style.css' );
    wp_enqueue_script( 'tm_welcome_screen_js', plugin_dir_url( __FILE__ ) . '/admin-script.js', array( 'jquery' ), '1.0.4', true );
  }
}

function tm_member_welcome_redirect() {
	global $current_user;
	if(isset($_GET["forget_welcome"]))
		{
		delete_user_meta($current_user->ID,'tm_member_welcome');
		wp_logout();
		wp_safe_redirect( site_url('wp-login.php') );
		return;
		}
    if(get_user_meta($current_user->ID,'tm_member_welcome',true))
		return;
	add_user_meta($current_user->ID,'tm_member_welcome',time());
	wp_safe_redirect( add_query_arg( array( 'page' => 'toastmasters_welcome' ), admin_url( 'index.php' ) ) );
}

function tm_welcome_screen_pages() {
  add_dashboard_page(
    'Welcome To WordPress for Toastmasters',
    'Welcome To WordPress for Toastmasters',
    'read',
    'toastmasters_welcome',
    'toastmasters_welcome'
  );
}


function toastmasters_welcome() {
$hook = tm_admin_page_top(__('Welcome to WordPress for Toastmasters','rsvpmaker-for-toastmasters'));
global $wpdb;
  ?>

    <h2 class="nav-tab-wrapper">
      <a class="nav-tab nav-tab-active" href="#main">Quick Guide</a>
      <a class="nav-tab" href="#TODO">To Do First</a>
      <a class="nav-tab" href="#credits">Credits</a>
    </h2>

    <div id='sections'>
    <section id="main">
    <p>This website takes advantage of software from the <a href="http://wp4toastmasters.com">WordPress for Toastmasters</a> project, which adds Toastmasters-specific features such as meeting and membership management to WordPress, a popular web publishing and online marketing platform. Here is a quick orientation.</p>
    <p>You are viewing the website's administrative back end, or "Dashboard." This is where you come to <a href="<?php echo admin_url('profile.php'); ?>">update your member profile</a> (please verify your contact information!) and <a href="<?php echo admin_url('profile.php#password'); ?>">change your password</a>. Site administrators can also edit the content of the website and tweak settings from here. To sign up for meeting roles, you will want to return to the public website, as shown below.</p>
    <p>The basic dashboard menu for a member looks something like this:</p>
    <p><img src="<?php echo plugins_url('/rsvpmaker-for-toastmasters/'); ?>nav-toastmasters-menu.png" width="242" height="217" alt=""/></p>
    <p>Officers and administrators will see a more complicated menu, with options for adding members and editing site content.</p>
    <p>Do not let yourself get lost in the menus! WordPress has many capabilities, which is the rationale for using it for Toastmasters websites. As a regular member, most of the time you only need to do a few simple things. Click on the To Do First tab above for pointers on basic tasks like changing your password and signing up for a role at an upcoming meeting.</p>
    <p>Here is how you return to viewing the public website:</p>
    <p>
<img src="<?php echo plugins_url('/rsvpmaker-for-toastmasters/'); ?>nav-to-site.png" width="458" height="297" alt=""/>
<br /><em>At the top of every back end administrative screen, the Visit Site option is displayed under the name of the website, in the menu at the top of the screen.</em></p>
<p>When you are logged in with your user name and password, you should see a black bar across the top of the screen that contains a similar menu:</p>
<p>
<img src="<?php echo plugins_url('/rsvpmaker-for-toastmasters/'); ?>nav-to-dashboard.png" width="458" height="297" alt=""/>
<br /><em>When you are logged in and viewing the public website, the Dashboard option is displayed under the name of the website. Clicking there returns you to the administrative back end, or dashboard.</em></p>
    <?php
	if(current_user_can('edit_others_posts'))
	{
	?>
<!-- admins see -->
<h3>For Administrators and Editors</h3>
    <p>Everyone sees the message above the first time they visit the administrator's dashboard. What follows are some specific tips for anyone starting one of these websites or taking responsibility for maintaining it.</p>
    <ul>
    <li>If you are setting up this software on a club website for the first time, a series of prompts at the top of the screen will guide you through basic steps like establishing a meeting template.</li>
    <li>You will edit the content of your website using the WordPress editor, which is essentially a web-based word processor that you use to format text, with a built-in file uploader for adding images and other media. If you want to add a link, highlight a word or phrase and click the "chain link" icon.</li>
    <li>The main content of a WordPress website is divided into Posts and Pages, which you create or edit using the <a href="<?php echo admin_url('edit.php'); ?>">Posts</a> and <a href="<?php echo admin_url('edit.php?post_type=page'); ?>">Pages</a> menus.
    <ul><li>Posts appear on the blog in reverse chronological order, meaning the most recent items appear first. Typically, they consist of news content like announcing one of your members won an area contest (maybe including photos or video) that is most relevant when it is first published.</li>
    <li>Pages are the more timeless content, like your home page or the page giving directions to your meeting location. Typically, you feature them on your site's navigation menu and update them periodically.</li>
    <li>See this <a  target="_blank" href="http://wp4toastmasters.com/2016/02/10/adding-and-editing-club-website-content/">video tutorial</a> on creating and editing basic website content.</li>
    </ul>
    </li>
    <li>In addition to Posts and Pages, this supports Events as a separate content time through the RSVPMaker plugin, which is why that menu item is labeled <a href="<?php echo admin_url('edit.php?post_type=rsvpmaker'); ?>">RSVP Events</a>.
    <ul>
    <li>Events appear on the site in calendar order, rather than blog order or menu order, with the emphasis on upcoming events people can participate in.</li>
    <li>Toastmasters meeting events appear in the WordPress editor as a series of placeholders for the different roles that will be displayed on the signup form and on the printable agenda.</li>
    <li>Typically, Toastmasters meetings follow an event template that lays out the organization of a "typical" meeting and defines a standard meeting schedule. You then generate individual events based on that template. For example, if your template says your club meets every Monday at 7 pm and typically schedules 3 speakers and 3 evaluators per meeting, the software will help you create events for the next several months that follow that pattern. <em>You always have the option of customizing the agenda for an individual meeting that does not follow the template.</em></li>
    <li>See this <a  target="_blank"  href="http://wp4toastmasters.com/2016/02/09/video-setting-up-and-editing-your-standard-meeting-agenda/">video tutorial</a> on setting up and managing meeting agendas.</li>
    <li>For any other sort of event, such as an open house, you would edit text and add media exactly as you would for Pages and Posts, except that you must also specify the date in the Event Options box. If you are advertising an event for which you are requesting online RSVPs, you would also specify that in this section. See this <a target="_blank" href="http://wp4toastmasters.com/2016/02/23/rsvpmaker-event-management-for-toastmasters/">blog post</a>.</li>
    </ul>
    </li>
    <li>Some website pages also include placeholder codes. For example, the calendar page includes a placeholder for the calendar display and events listing.</li>
    <li>To add pages to the menu, or change the order in which they appear, use the <a href="<?php echo admin_url('nav-menus.php'); ?>">Menu editor</a>. 
    </li>
    </ul>
    
    <?php
	}


?>
<p><a href="<?php echo admin_url('?forget_welcome=1'); ?>">Reset welcome screen</a></p>
    </section><!-- end #main -->
    <section id="TODO">
    <p>New members should start by:</p>
    <ul>
    <li><a href="<?php echo admin_url('profile.php#user_login'); ?>"><?php _e("Editing your member profile",'rsvpmaker-for-toastmasters');?></a> (you can also change your password on this screen)</li>
    <li>Signing up for roles at an upcoming meeting.
    <ul>
<?php

$count = 0;
// lookup next meeting
	$results = get_future_events(" post_content LIKE '%[toastmaster%' ",10,ARRAY_A);
			  if($results)
			  {
			  foreach($results as $index => $row)
			  	{
					$t = strtotime($row->datetime);
					$title = $row->post_title . ' '.date('F jS',$t );
					$permalink = rsvpmaker_permalink_query($row->postID);					
					printf('<li><a href="%s">%s</a></li>',$permalink, $title);
				}
			  }
			  else
			  	echo '<li>No upcoming meetings posted</li>';
?>  
    </ul>
    </li>
    </ul>

    </section><!-- end #TO DO -->
    <section id="credits">
    <p>WordPress for Toastmasters is a volunteer project derived from customizations originally created by David F. Carr for <a href="http://www.clubawesome.org">Club Awesome Toastmasters</a> in Coral Springs, Florida and supported by <a href="http://www.carrcommunications.com">Carr Communications Inc</a>.</p>
    <p>Many improvements have been (and continue to be) suggested by the members of Club Awesome and by Toastmasters around the world who see the potential of this project.</p>
    <p>Some particularly important supporters include:
    <br />Lois Margolin
    <br />Marilyn Brown
    <br />Sue Ness
    <br />Lois Margolin
<br />Scott Friedman
<br />Blake Evans
<br />Juan Artigas
<br />Daniel Greenberg
    </p>
<p>All Toastmasters logos and other references to the brand are owned by <a href="http://www.toastmasters.org">Toastmasters International</a>, which provided guidance on conformity to the Toastmasters brand guidelines.</p>
    
    </section><!-- end #credits -->
    </div>

  <?php
tm_admin_page_bottom($hook);
}


function tm_welcome_screen_remove_menus() {
	//these menus will be active but not displayed
    remove_submenu_page( 'index.php', 'toastmasters_welcome' );
    remove_submenu_page( 'options-general.php', 'tm_security_caps' );
    remove_submenu_page( 'toastmasters_screen', 'tm_member_edit' );
    remove_submenu_page( 'toastmasters_screen', 'import_fth' );
    remove_submenu_page( 'toastmasters_screen', 'add_member_speech' );
}


function toastmasters_support() {

	show_wpt_promo();

$hook = tm_admin_page_top(__('Other Resources','rsvpmaker-for-toastmasters'));
?>
<p>Ideas for improvements are always welcome. The underlying software is available as open source code, meaning web developers and designers can contribute their own improvements. See the <a href="https://wordpress.org/plugins/rsvpmaker/">RSVPMaker</a> and <a href="https://wordpress.org/plugins/rsvpmaker-for-toastmasters/">RSVPMaker for Toastmasters</a> plugins and the <a href="https://wordpress.org/themes/lectern/">Lectern</a> theme in the WordPress.org repository.</p>
<p>&quot;Like&quot; the <a href="https://www.facebook.com/wp4toastmasters">WordPress for Toastmasters Facebook page</a>.</p>
<!-- Begin MailChimp Signup Form -->
<link href="//cdn-images.mailchimp.com/embedcode/horizontal-slim-10_7.css" rel="stylesheet" type="text/css">
<style type="text/css">
	#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; width:100%;}
	/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
	   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
</style>
<div id="mc_embed_signup">
<form action="//carrcommunications.us1.list-manage.com/subscribe/post?u=98249af77569f1d331f14fb25&amp;id=5d7256b1ba" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
    <div id="mc_embed_signup_scroll">
	<label for="mce-EMAIL">Subscribe to the WordPress for Toastmasters mailing list</label>
	<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" required value="<?php echo $current_user->user_email; ?>">
    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_98249af77569f1d331f14fb25_5d7256b1ba" tabindex="-1" value="<?php echo $email; ?>"></div>
    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
    </div>
</form>
</div>
<?php
tm_admin_page_bottom($hook);
}

add_action('admin_init','tm_export');
function tm_export() {
if(!isset($_GET["tm_export"]))
	return;
$nonce = $_REQUEST['tm_export'];
if ( ! wp_verify_nonce( $nonce, 'tm_export' ) ) {
    // This nonce is not valid.
    die( 'Failed security check' ); 
} else {
$users = get_users();
$contact = array();
$urls = array('facebook_url','twitter_url','linkedin_url','business_url');

$header = array("user_id","user_login","first_name","last_name","user_email","toastmasters_id",'home_phone','work_phone','mobile_phone');

$manuals = get_manuals_array();
global $toast_roles;
global $competent_leader;
foreach($manuals as $manual => $manual_text)
	$statfields[] = $manual;
foreach($toast_roles as $column)
	$statfields[] = $column;
foreach($competent_leader as $column)
	$statfields[] = $column;

$header = array_merge($header, $statfields, $urls);

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="'. $_SERVER['SERVER_NAME'] . '-members-'.date('Y-m-d').'.csv"');
header('Cache-Control: max-age=0');
$out = fopen('php://output', 'w');
fputcsv($out, $header);

foreach($users as $user)
	{
		$nextuser = array();
		$userdata = get_userdata($user->ID);
		$stats = awesome_get_stats($userdata->ID);
		foreach($header as $field)
			{
				if($field == 'user_id')
					$field = "ID"; // workaround for issue with excel
				if(in_array($field,$statfields) && isset($stats[$field]) )
					$nextuser[$field] = $stats[$field];
				elseif( isset($userdata->$field) )
					$nextuser[$field] = $userdata->$field;
				else
					$nextuser[$field] = '';		
			}
		fputcsv($out, $nextuser);
	}
fclose($out);
exit();
}

}

function toastmasters_dues () {
$hook = tm_admin_page_top('Track Dues');
$standard_dues = get_option('toastmasters_dues');
$newmember_fee = get_option('toastmasters_newmember_fee');
if(empty($newmember_fee))
	$newmember_fee = 20;
$blogusers = get_users(  );
$paid = '';
if(isset($_POST["paid"]))
	{
		$t = strtotime($_POST["yearend"].'-'.$_POST["monthend"].'-1');
		$dues = $_POST["dues"];
		if($dues != $standard_dues)
			{
			update_option('toastmasters_dues',$dues);
			$standard_dues = $dues;
			}
		$newfee = $_POST["newfee"];
		if($newfee != $newmember_fee)
			{
			update_option('toastmasters_newmember_fee',$newfee);
			$newmember_fee = $newfee;
			}
		foreach($_POST["paid"] as $paiduser)
			{
				update_user_meta($paiduser,'paid_until',$t);
				if(!empty($_POST["isnew"][$paiduser]))
					{
					$payment = array('timestamp' => time(), 'new' => 1, 'USD' => ($dues + $newfee));
					update_user_meta($paiduser,'dues_paid',$payment);
					}
				else
					{
					$payment = array('timestamp' => time(), 'new' => 0, 'USD' => $dues);
					update_user_meta($paiduser,'dues_paid',$payment);
					}
				add_user_meta($paiduser,'paid_until',$t);
			}
	}

// Array of WP_User objects.
printf('<form action="%s" method="post">',admin_url('admin.php?page=toastmasters_dues'));

$y = date('Y');
$m = date('m');
if($m > 10)
	{
		$y++;
		printf('<p>Until Month: <select name="monthend"><option value="4">4</option><option value="10">10</option></select> Year:<select name="yearend"><option value="%s">%s</option><option value="%s">%s</option></select></p>',$y,$y,($y+1),($y+1));
	}
elseif($m <4)
	{
		printf('<p>Until Month: <select name="monthend"><option value="4">4</option><option value="10">10</option></select> Year:<select name="yearend"><option value="%s">%s</option><option value="%s">%s</option></select></p>',$y,$y,($y+1),($y+1));
	}
else
	{
		printf('<p>Until Month: <select name="monthend"><option value="10">10</option><option value="4">4</option></select> Year:<select name="yearend"><option value="%s">%s</option><option value="%s">%s</option></select></p>',$y,$y,($y+1),($y+1));
	}

printf('<p>Dues: $ <input name="dues" value="%s"> USD New Member fee: $ <input type="text" name="newfee" value="%s"> USD</p>',$standard_dues, $newmember_fee);

$paidcount = 0;
foreach ( $blogusers as $user ) {
    $userdata = get_userdata($user->ID);
	if($userdata->hidden_profile)
		continue;

	$payments = get_user_meta($user->ID,'dues_paid');
	$pay = '';
	$order_payments = array();
	if(!empty($payments))
	{
	foreach($payments as $payment)
		{
		if(!empty($payment["timestamp"]))
			$order_payments[$payment["timestamp"]] = $payment["USD"];
		}
	if(!empty($order_payments))
		{
		krsort($order_payments);
		foreach($order_payments as $timestamp => $usd)
			$pay .= '$'.$usd.' paid '.date('F Y',(int) $timestamp).'<br />';
		}
	}
	if(empty($userdata->paid_until) || ( time() > $userdata->paid_until ))
		{
		printf('<p><input type="checkbox" name="paid[]" value="%s" /> %s <input type="checkbox" name="isnew[%d]" value="1"> %s<br />%s %s (%s) <a href="mailto:%s">%s</a></p>',$user->ID, __('Dues','rsvpmaker-for-toastmasters'), $user->ID, __('New Member Fee','rsvpmaker-for-toastmasters'), $userdata->first_name,$userdata->last_name, $user->user_login, $user->user_email, $user->user_email);	
		if(!empty($pay))
			printf('<p>Payment history: %s</p>',$pay);
		$unpaid_email[] = $user->user_email;
		}
	else
		{
		$paidcount++;
		$d = date('F Y', (int) $userdata->paid_until );
		$paid .= sprintf('<p>%s: %s %s (%s) %s</p>',$paidcount, $userdata->first_name,$userdata->last_name, $user->user_login, $d);	
		if(!empty($pay))
			$paid .= sprintf('<p>Payment history: %s</p>',$pay);
		$paid_email[]  = $user->user_email;
		}
}
submit_button();
echo '</form>';

if(!empty($unpaid_email))
	printf('<p><a href="mailto:%s">%s</a></p>',implode(",",$unpaid_email),__('Email all unpaid members','rsvpmaker-for-toastmasters'));

if(!empty($paid_email))
{
printf('<h3>%s</h3>',__('Paid Members','rsvpmaker-for-toastmasters'));
echo $paid;
printf('<p><a href="mailto:%s">%s</a></p>',implode(",",$paid_email),__('Email all PAID members','rsvpmaker-for-toastmasters'));
}

tm_admin_page_bottom($hook);
}

function toastmasters_import_export() {
$hook = tm_admin_page_top('Import/Export');

?>
    <h2 class="nav-tab-wrapper">
      <a class="nav-tab nav-tab-active" href="#main">WP4Toastmasters Data</a>
      <a class="nav-tab" href="#fth">Import from Free Toast Host</a>
    </h2>
    <div id='sections'>
    <section id="main">
<?php

$export_link = sprintf('<a href="%s?page=%s&tm_export=%s">Export</a>', admin_url('admin.php') ,'import_export',wp_create_nonce('tm_export') );

printf('<p>Click to %s a listing of member contact info and achievements. Use this for your own reference or make corrections to the spreadsheet and import your data into the website.</p>',$export_link);

printf('<p>%s <a href="%s">%s</a></p>',__('If you want to import or sync a member spreadsheet from toastmasters.org, see the','rsvpmaker-for-toastmasters'),admin_url('users.php?page=add_awesome_member#import'),__('Add Members page','rsvpmaker-for-toastmasters'));

if(isset($_POST["import_ss"])) {
$manuals = get_manuals_array();
global $toast_roles;
global $competent_leader;
foreach($manuals as $manual => $manual_text)
	$statfields[] = $manual;
foreach($toast_roles as $column)
	$statfields[] = $column;
foreach($competent_leader as $column)
	$statfields[] = $column;
$lines = explode("\n", stripslashes($_POST["import_ss"]));
printf('<p>%s %s %s</p>',__('Starting import on','rsvpmaker-for-toastmasters').' ',sizeof($lines),' '.__('lines of data','rsvpmaker-for-toastmasters'));
$label = array();
$checkform = '';
$row = 0;

foreach($lines as $linenumber => $line)
	{
	$line = trim($line);
	$cells = explode("\t",$line);
	if($linenumber == 0)
		{
		foreach($cells as $index => $cell)
			{
				$label[] = trim($cell);
			}
		}
	else
	{
	$cells[0] = preg_replace('/[^0-9]/','', $cells[0]);
	if(!empty($cells[0]) && !is_numeric($cells[0]))
		continue; // want either an ID # or a blank field for new member
	if(empty($cells[2]) || empty($cells[3]) || empty($cells[4]))
		break;
	$user = array();
	$id = $cells[0];
	$userdata = get_userdata($id);
	if(empty($userdata) || ($userdata->user_login != $cells[1]))
		{
		printf('<p>id: %s login: %s does not match an existing user</p>',$cells[0],$cells[1]);
		if(!isset($_POST["add_members"]))
			continue;		
		$user_fields = array("user_login","first_name","last_name","user_email",'home_phone','work_phone','mobile_phone','facebook_url','twitter_url','linkedin_url','business_url');
			$newuser = array();
			foreach($user_fields as $field)
				{
				$newuser['user_login'] = $cells[1];
				$newuser['first_name'] = $cells[2];
				$newuser['last_name'] = $cells[3];
				$newuser['user_email'] = $cells[4];
				}
			$id = add_member_user($newuser);
			//printf('<p>new: %s id: %d</p>',$newuser["user_login"],$id);
		}
	//if we've passed that test begin to update
	if(!$id)
		continue;
	$stats = awesome_get_stats($id);

	//printf('<p>start: %s %s %s</p>',$cell[0],$cell[1],$cell[2]);
	
	foreach($cells as $index => $cell)
		{
			$cell = trim(str_replace('"','',$cell));
			$field = $label[$index];
			//printf('<br />%s = %s',$field,$cell);
			if($index < 3)
				continue;
			elseif(in_array($field,$statfields) )
				{
				if(!isset($stats[$field]) || ($cell == $stats[$field]))
					{
					continue; // if it didn't change, we don't need to update it
					}
				$current_meta = (int) get_user_meta($id,'tmstat:'.$field,true);
				$new_meta = $cell - ($stats[$field] - $current_meta);
				update_user_meta($id,'tmstat:'.$field,$new_meta);
				printf('<br />%s %s = %s',$cells[1],$field,$new_meta);
				}
			else
				{
				if($cell == $userdata->$field)
					{
					//printf('<p>%s %s unchanged %s</p>',$field,$cell,$userdata->$field);
					continue; // if it didn't change, we don't need to update it
					}
				printf('<br />%s %s = %s',$cells[1],$field,$cell);
				update_user_meta($id,$field,$cell);
				}			
	}
	}
	}
}

?>
<h2>Import or Update Member Records from Spreadsheet</h2>
<p>This allows you to make corrections to a spreadsheet of member facts and statistics, then import those updates. If you are just getting started with WordPress for Toastmasters, you can first import your members into the site, download the spreadsheet, fill in a starter set of statistics such as manual speeches completed for each member, and then use this tool to import that data.</p>
<p>Copy the spreadsheet to your computer clipboard, including the column headers, and paste it into the space below. This utility will update existing member records. If you also want to add new member records, check the "add members" box.</p>
<form method="post" action="<?php echo admin_url('admin.php?page=import_export'); ?>">
<textarea rows="10" cols="80" name="import_ss"></textarea>
<br /><input type="checkbox" name="add_members" value="1"> Add members (if not already in user database)
<br /><button>Import</button>
</form>
</section>
<section id="fth">
<?php import_fth(); ?>
</section>
</div>
<?php

tm_admin_page_bottom($hook);
}

function tm_reports_disclaimer ($extra = '') {
echo '<p>These reports provide guidance on member activity but are not guaranteed to be complete. Site owners can make them more accurate by reconciling meeting signup data with who actually showed up and performed roles, by adding historical data, and by recording activities that happen outside of meetings. '.$extra.'</p>';
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

$print = (isset($_GET["page"]) && !isset($_GET["rsvp_print"])) ? '<div style="width: 200px; text-align: right; float: right;"><a target="_blank" href="'.admin_url(str_replace('/wp-admin/','',$_SERVER['REQUEST_URI'])).'&rsvp_print=1">Print</a></div>' : '';
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

function increment_stat_button($user_id, $key ) {
global $increment_stat_count;
$increment_stat_count++;
return sprintf(' <button class="increment_stat" counter="%d" user_id="%s" role="%s">+1</button></span> <span id="increment_stat_result%d"></span>', $increment_stat_count, $user_id,$key, $increment_stat_count);
}

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
//for statistics, we don't distinguish between speaker #1, speaker #2
//timestamp format date('Y-m-d G:i:s')
return 'tm|'.trim(preg_replace('/[^\sa-zA-Z]/',' ',$role)).'|'.$event_timestamp.'|'.preg_replace('/[^0-9]/','',$role).'|'.$_SERVER['SERVER_NAME'].'|'.$post_id;
}

function archive_site_user_roles () {
$last = get_option('archive_site_user_roles');
$users = get_users();
foreach($users as $user)
	archive_legacy_roles_usermeta($user->ID,$last);
fix_timezone();
update_option('archive_site_user_roles',date('Y-m-d G:i:s'));
}

add_action('wp_login','archive_site_user_roles');
if(isset($_GET["archive"]))
	add_action('admin_init','archive_site_user_roles');

function post_user_role_archive ($timestamp) {

if(isset($_POST["editor_assign"]) )
	{
		foreach($_POST["editor_assign"] as $role => $user_id)
		{
		if(($user_id == '0') || !is_numeric($user_id) )
			continue;
		$key = make_tm_usermeta_key ($role, $timestamp, 0);
		$roledata = make_tm_roledata_array ('post_user_role_archive');
		if(strpos($role,'peaker'))
			{
			$manual = $_POST["_manual"][$role];
			$project_index = $_POST["_project"][$role];
			$title = $_POST["_title"][$role];
			$intro = (isset($_POST["_intro"][$role])) ? $_POST["_intro"][$role] : '';
			$roledata = make_tm_speechdata_array ($roledata, $manual, $project_index, $title, $intro);
			}
		update_user_meta($user_id,$key,$roledata);
		}
	}
return strtotime($timestamp . ' +1 week');
}


function update_user_role_archive($post_id,$timestamp) {

global $wpdb;
global $current_user;
$wpdb->show_errors();

	$sql = "SELECT *, meta_key as role FROM `$wpdb->postmeta` where post_id=".$post_id." AND BINARY meta_key RLIKE '^_[A-Z].+[0-9]$' ";//

$results = $wpdb->get_results($sql);
if($results)
foreach($results as $row)
	{
		$user_id = (int) $row->meta_value;
		$key = make_tm_usermeta_key ($row->role, $timestamp, $post_id);
		$roledata = make_tm_roledata_array ('update_user_role_archive');
		if(strpos($row->role,'Speaker'))
		{
		$manual = get_post_meta($post_id, '_manual'.$row->role, true);
		$project_index = get_post_meta($post_id, '_project'.$row->role, true);
		$title = get_post_meta($post_id, '_title'.$row->role, true);
		$intro = get_post_meta($post_id, '_intro'.$row->role, true);
		$roledata = make_tm_speechdata_array ($roledata, $manual, $project_index, $title, $intro);
		}
		if($user_id) // not for id 0
			update_user_meta($user_id,$key,$roledata);
		//don't give 2 people credit for same role;
		$sql = $wpdb->prepare("DELETE FROM $wpdb->usermeta WHERE meta_key=%s AND user_id != %d",$key,$user_id);
		$wpdb->query($sql);
	}
}

function archive_legacy_roles_usermeta ($user_id, $start = '') {
global $wpdb;
global $current_user;
$wpdb->show_errors();
if(!empty($start))
	$start = " AND a2.meta_value > '$start' ";

	$sql = "SELECT a1.meta_key as role, a2.meta_value as event_timestamp, a1.post_id as postID FROM `$wpdb->postmeta` a1 JOIN  `$wpdb->postmeta` a2 ON a1.post_id = a2.post_id AND a2.meta_key='_rsvp_dates' where a1.meta_value=".$user_id." AND BINARY a1.meta_key RLIKE '^_[A-Z].+[0-9]$' $start AND a2.meta_value < NOW() ORDER BY a1.meta_key DESC";//

$results = $wpdb->get_results($sql);
if($results)
foreach($results as $row)
	{
		$key = make_tm_usermeta_key ($row->role, $row->event_timestamp, $row->postID);
		$roledata = make_tm_roledata_array ('archive_legacy_roles_usermeta');
		if(strpos($row->role,'Speaker'))
		{
		$manual = get_post_meta($row->postID, '_manual'.$row->role, true);
		$project_index = get_post_meta($row->postID, '_project'.$row->role, true);
		$title = get_post_meta($row->postID, '_title'.$row->role, true);
		$intro = get_post_meta($row->postID, '_intro'.$row->role, true);
		$roledata = make_tm_speechdata_array ($roledata, $manual, $project_index, $title, $intro);
		}
		update_user_meta($user_id,$key,$roledata);
	}

//old method of logging speeches from dashboard
$meta_speeches = get_user_meta($user_id, 'Speaker');
if(!empty($meta_speeches))
{
foreach($meta_speeches as $speech)
	{
		$manual = $speech["manual"];
		$project = $speech["project"];
		$title = $speech["speech_title"];
		$date = (int) $speech["date"];
		$check = 'tm|Speaker|'.date('Y-m-d',$date);
		$sql = "SELECT * FROM $wpdb->usermeta WHERE user_id=$user_id AND meta_key LIKE '".$check."%' ";
		$row = $wpdb->get_row($sql);
		if($row)
			continue;
		$key = make_tm_usermeta_key ('_Speaker_0', date('Y-m-d G:i:s',$date), 0);
		$roledata = make_tm_speechdata_array (make_tm_roledata_array('archive_legacy_roles_usermeta/meta'), $manual, $project, $title,'');
		update_user_meta($user_id,$key,$roledata);
	}
delete_user_meta($user_id, 'Speaker');
}
}

function wp_ajax_tm_edit_detail () {
global $rsvp_options;
global $wpdb;
$roledata = make_tm_speechdata_array (make_tm_roledata_array('wp_ajax_tm_edit_detail'), $_POST["manual"], $_POST["project"], stripslashes($_POST["title"]),stripslashes($_POST["intro"]));
$user_id = (int) $_POST["user_id"];
update_user_meta($user_id,$_POST["tm_details_update_key"],$roledata);
$key_array = explode('|',$_POST["tm_details_update_key"]);
$role = $key_array[1];
$event_date = $key_array[2];
$rolecount = $key_array[3];
$domain = $key_array[4];
$post_id = $key_array[5];
if($_POST["date"])
{
	if(!strpos($_POST["tm_details_update_key"],$_POST["date"])) // new date not present in old key
		{
			$new_key = str_replace($event_date,$_POST["date"]. ' 00:00:00',$_POST["tm_details_update_key"]);
			$sql = "UPDATE $wpdb->usermeta set meta_key='$new_key' WHERE user_id=$user_id AND meta_key='".$_POST["tm_details_update_key"]."'";
			$wpdb->query($sql);
			fix_timezone();
			$date = strftime($rsvp_options["long_date"],strtotime($_POST["date"])) . ' (changed date)';
			add_user_meta($user_id,'wp4t_stats_delete',$_POST["tm_details_update_key"]);
		}
}
if($post_id && ($domain = $_SERVER['SERVER_NAME']))
	{
	$p = get_post($post_id); // make sure it exists
	if($p)
		{
			update_post_meta($post_id,'_manual_Speaker_'.$rolecount,$_POST["manual"]);
			update_post_meta($post_id,'_project_Speaker_'.$rolecount,$_POST["project"]);
			update_post_meta($post_id,'_title_Speaker_'.$rolecount,stripslashes($_POST["title"]));
			update_post_meta($post_id,'_intro_Speaker_'.$rolecount,stripslashes($_POST["intro"]));
		}
	}
if(empty($date))
	$date = strftime($rsvp_options["long_date"],strtotime($event_date));
echo "<strong>Updating ".$role." for ".$date.'</strong>';
printf('<br />%s<br />%s<br />%s<br />%s',$_POST["manual"], get_project_text($_POST["project"]), stripslashes($_POST["title"]),stripslashes($_POST["intro"]));
echo ' <a href="'.admin_url("admin.php?page=toastmasters_reports&toastmaster=".$user_id).'">refresh</a> to see changes.';
wp_die();
}

add_action( 'wp_ajax_tm_edit_detail', 'wp_ajax_tm_edit_detail' );

function wp_ajax_delete_tm_detail () {
global $rsvp_options;
//print_r($_POST);
$key = $_POST["key"];
$user_id = $_POST["user_id"];
delete_user_meta($user_id,$key);
add_user_meta($user_id,'wp4t_stats_delete',$key);
$key_array = explode('|',$key);
//print_r($key_array);
$role = $key_array[1];
$event_date = $key_array[2];
$rolecount = $key_array[3];
$domain = $key_array[4];
$post_id = $key_array[5];
if($post_id && ($domain = $_SERVER['SERVER_NAME']))
	{
	$p = get_post($post_id); // make sure it exists
	if($p)
		{
			delete_post_meta($post_id,'_'.$role.'_'.$rolecount);
			if($role == 'Speaker')
			{
			delete_post_meta($post_id,'_manual_Speaker_'.$rolecount);
			delete_post_meta($post_id,'_project_Speaker_'.$rolecount);
			delete_post_meta($post_id,'_title_Speaker_'.$rolecount);
			delete_post_meta($post_id,'_intro_Speaker_'.$rolecount);
			}
		}
	}
echo "<strong>Deleting ".$role." for ".strftime($rsvp_options["long_date"],strtotime($event_date)).'</strong> <a href="'.admin_url("admin.php?page=toastmasters_reports&toastmaster=".$user_id).'">refresh</a> to see changes.';
wp_die();
}

add_action( 'wp_ajax_delete_tm_detail', 'wp_ajax_delete_tm_detail' );

function wp_ajax_editor_assign () {
global $wpdb;
$post_id = (int) $_POST["post_id"];
$user_id = (int) $_POST["user_id"];
$role = $_POST["role"];
$timestamp = get_rsvp_date($post_id);
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
if($user_id == -1)
	$name = 'Not Available';
elseif($user_id)
{
$userdata = get_userdata($user_id);
$name = $userdata->first_name.' '.$userdata->last_name;
}
else
	$name = 'Open';
printf('%s assigned to %s',preg_replace('/[\_0-9]/',' ',$role),$name);
wp_die();
}

add_action( 'wp_ajax_editor_assign', 'wp_ajax_editor_assign' );

function get_tm_stats($user_id = 0) {
global $current_user;
global $stats_array;
if(!$user_id)
	$user_id = $current_user->ID;

if(!empty($stats_array[$user_id]))
	return $stats_array[$user_id];
global $wpdb;
global $rsvp_options;
// if individual record, sync
$wpdb->show_errors();
$count = array();
$speech_count = array();
$speeches = array();
$speech_list = '';
$editdetail = array();
$lastdate = '';
	$sql = "SELECT * FROM `$wpdb->usermeta` WHERE user_id = $user_id AND meta_key LIKE 'tm|%' ORDER BY meta_key";//
	$results = $wpdb->get_results($sql);
	//print_r($results);
	if($results)
	foreach($results as $row)
		{
			//echo $row->meta_key;
			$key_array = explode('|',$row->meta_key);
			if(!isset($key_array[5]))
				{
				//clean up malformed entries
				delete_user_meta($user_id,$row->meta_key);
				add_user_meta($user_id,'wp4t_stats_delete',$row->meta_key);
				}
			$role = $key_array[1];
			$event_date = $key_array[2];
			$rolecount = $key_array[3];
			$domain = $key_array[4];
			$post_id = $key_array[5];
			$roledata = unserialize($row->meta_value);
			if(isset($_GET["details"]))
				{
				echo $role.' ';
				echo $event_date.' ';
				echo $domain.' ';
				echo $post_id.'<br />';
				}
			if($role == 'Speaker')
				{
				$manual = (empty($roledata['manual'])) ? 'Other' : $roledata['manual'];
				if(empty($speech_count[$manual]))
					$count[$manual] = $speech_count[$manual] = 1;
				else
					$count[$manual] = $speech_count[$manual] = $speech_count[$manual] + 1;
				if(empty($roledata['project']))
					$speech_details = 'Project not specified';
				else
					{
					$project_text = get_project_text($roledata['project']);
					$speech_details = $manual .': '.$project_text;
					if(empty($project_text))
						$speech_details = $roledata['project'];
					}
				//$speech_details .= '<br />'.var_export($roledata,true);
				if(!empty($roledata['title']))
					$speech_details .= '<br />'.$roledata['title'];
				if(isset($_GET["intro"]) && !empty($roledata['intro']))
					$speech_details .= '<br />'.nl2br($roledata['intro']);
				if($domain != $_SERVER['SERVER_NAME'])
					$speech_details .= '<br /><em>'.$domain.'</em>';

				if(isset($_GET["debug"]))
				$speech_details .= '<br />'.$row->meta_key;

				$speech_details = '<p>'.strftime($rsvp_options["long_date"],strtotime($event_date)).'<br />'.$speech_details.'</p>';
				if(empty($speeches[$manual]))
					$speeches[$manual] = $speech_details;
				else
					$speeches[$manual] .= $speech_details;
				$speech_list .= $speech_details;

				if(isset($_GET["debug"]))
				$speech_list .= '<pre>'.var_export($row,true).'</pre>';

				}
			else
				{
				if(empty($count[$role]))
					$count[$role] = 1;
				else
					$count[$role]++;
				}

		if((current_user_can('edit_member_stats')) || (($user_id == $current_user->ID) && current_user_can('edit_own_stats')) )
		{
			$form = '';
			if($lastdate == $event_date.$role)
				$form .= '<div style="color:red; border: thin solid red;">'.__('Possible duplicate','rsvpmaker-for-toastmasters').'</div>';
			$lastdate = $event_date.$role;
			$field = preg_replace('/[^a-zA-Z0-9]/','',$row->meta_key);
			$form .= '<p id="delete'.$field.'"><strong>'.$role .' '.strftime($rsvp_options["long_date"],strtotime($event_date)).' </strong><button class="delete_tm_detail" key="'.$row->meta_key.'" status="'.$field.'">Delete</button></p>';
			$form .= sprintf('<form class="tm_edit_detail" status="%s" method="post" action="%s" id="form'.$field.'"><input type="hidden" name="action" value="tm_edit_detail"><input type="hidden" name="tm_details_update_key" class="tm_details_update_key" id="key_%s" value="%s" /><input type="hidden" name="user_id" id="user_id_%s" value="%d">',$field,admin_url('admin.php?page=toastmasters_reports&toastmaster=').$user_id,$row->meta_key,$row->meta_key,$field,$user_id);
			if(($role == 'Speaker') && !empty($roledata['manual']))
				{
					$form .= speaker_details_admin ($user_id, $row->meta_key, $roledata['manual'],$roledata['project'],$roledata['title'],$roledata['intro']).'<p><button>Update</button></p>';
					//sprintf('<p>Manual %s Project %s Title <input type="text" name="title" id="_title_%s" value="%s" /> Intro %s</p><p><button>Update</button></p>',$roledata['manual'],$roledata['project'],$roledata['title'],$roledata['intro']);
				}
			$form .= '</form>';
			if(isset($_GET["debug"]))
				$form .= '<div>'.$field.'</div>';
			$editdetail[$event_date] = (isset($editdetail[$event_date])) ? $editdetail[$event_date] . $form : $form;
		}

		}// end for loop

$pure_count = $count;

$manuals = get_manuals_array();
$sql = "SELECT * FROM $wpdb->usermeta where user_id = $user_id AND meta_key LIKE 'tmstat:%'";
$results = $wpdb->get_results($sql);
if($results)
foreach ($results as $row)
	{
		$role = str_replace('tmstat:','',$row->meta_key);
		$count[$role] = isset($count[$role]) ? $count[$role] + $row->meta_value : $row->meta_value;
		if(in_array($role,$manuals))
			{
			//printf('<p>%s adjustment: %s</p>'."\n",$role,$row->meta_value);
			$speech_count[$role] = isset($speech_count[$role]) ? $speech_count[$role] + $row->meta_value : $row->meta_value;
			}
		if(isset($_GET["debug"]))
			printf('<p>%s adjustment: %s</p>',$role,$row->meta_value);
	}

ksort($editdetail);

$stats_array[$user_id] = array('count' => $count, 'pure_count' => $pure_count, 'speech_count' => $speech_count, 'speeches' => $speeches, 'speech_list' => $speech_list, 'editdetail' => implode("\n",$editdetail));

return $stats_array[$user_id];
}

function show_evaluation_form($project, $speaker_id, $meeting_id){
global $wpdb;
global $current_user;
global $rsvp_options;
$project_text = get_project_text($project);
$speaker_user = get_userdata($speaker_id);
$evaluator = get_userdata($current_user->ID);
$timestamp = get_rsvp_date($meeting_id);
$date = strftime($rsvp_options["long_date"],strtotime($timestamp));

$response = wp_remote_get( 'http://wp4toastmasters.com/?wpt_forms&form='.$project );
if( is_array($response) ) {
  $header = $response['headers']; // array of http header lines
  $body = $response['body']; // use the content
}

$slug = $project;
$name = $project_text;
$intro = $prompts = '';
if(!empty($body) && strpos($body,'++++'))
	{
	$parts = explode("++++",$body);
	$id = trim($parts[0]);
	$slug = trim($parts[1]);
	$name = trim($parts[2]);
	$intro = trim($parts[3]);
	$prompts = trim($parts[4]);
	}
	if(empty($prompts))
		{
		$intro = '<h4>We do not yet have a form with specific prompts for this project, but you can record your notes below.</h4>
<p><strong>You excelled at</strong></p>
<p><textarea name="comment[0]" style="width: 100%; height: 3em;"></textarea></p>
<p><strong>You may want to work on</strong></p>
<p><textarea name="comment[1]" style="width: 100%; height: 3em;"></textarea></p>
<p><strong>To challenge yourself</strong></p>
<p><textarea name="comment[2]" style="width: 100%; height: 3em;"></textarea></p>
<p><strong>Other Comments</strong></p>
<p><textarea name="comment[3]" style="width: 100%; height: 6em;"></textarea></p>
';
		}
		
		//lookup role field, title
		$sql = "SELECT meta_key from $wpdb->postmeta WHERE post_id=".$meeting_id. " AND meta_key LIKE '_Speaker%' AND meta_value=".$speaker_id;
		$field = $wpdb->get_var($sql);
		$title = get_post_meta($meeting_id, '_title'.$field, true);
?>
<form action="<?php echo admin_url('admin.php?page=wp4t_evaluations');?>" method="post">

<h3>Record Evaluation</h3>
<p>Speaker: <?php echo $speaker_user->first_name.' '.$speaker_user->last_name;  ?><input type="hidden" name="speaker_id" value="<?php echo $speaker_id; ?>" /></p>
<p>Manual/Path: <?php $manual = preg_replace('/\d*$/','',$project); echo $manual ?><input type="hidden" name="manual" value="<?php echo $manual; ?>" /></p>
<p>Project: <?php echo $project_text; ?><input type="hidden" name="project" value="<?php echo $project; ?>" /></p>
<p>Speech Title: <input type="text" name="speech_title" value="<?php echo $title; ?>" /></p>
<p>Evaluator: <input type="text" name="evaluator" value="<?php echo $evaluator->first_name.' '.$evaluator->last_name; ?>" /></p>
<p>Date: <?php echo $date; ?><input type="hidden" name="timestamp" value="<?php echo $timestamp; ?>" /></p>

<?php	
		echo wpautop($intro);
		if(!empty($prompts))
		{
		$lines = explode("\n",$prompts);
		foreach($lines as $index => $line)
			{
			$line = trim($line);
			if(empty($line))
				continue;
			$options = explode("|",$line);
			$prompt = array_shift($options);
			echo wpautop('<strong>'.$prompt.'</strong>');
				if(!empty($options))
				{
					echo '<p>';
					foreach($options as $option)
					{
					trim($option);
					printf('<input type="radio" name="check[%d]" value="%s" /> %s ',$index, $option, $option);
					}
					echo '</p>';
				}
			echo '<p><textarea name="comment['.$index.']" style="width: 100%; height: 3em;"></textarea></p>';
			}
		}
echo submit_button();
?>
</form>
<?php
}

function wp4t_evaluations () {
$hook = tm_admin_page_top(__('Evaluations','rsvpmaker-for-toastmasters'));
printf('<p><em>%s</em></p>',__('These online evaluation forms can be used by any club but were particularly intended for online Toastmasters clubs, where they can be used to eliminate the need to email, print, and scan evaluation forms. Most of the pre-Pathways manual projects are covered with specific prompts for those speeches.','rsvpmaker-for-toastmasters'));

global $current_user;
global $rsvp_options;
global $wpdb;
$project_options = get_projects_array('options');

$sql = "SELECT * FROM $wpdb->usermeta WHERE user_id=".$current_user->ID." AND meta_key LIKE 'evaluation|%' ORDER BY meta_key DESC";
$results = $wpdb->get_results($sql);
if($results)
{
echo '<h3>Evaluations of My Speeches</h3>';
	foreach($results as $row)
	{
		$key = $row->meta_key;
		$parts = explode('|',$key);
		//print_r($parts);
		$timestamp = $parts[1];
		$project = $parts[2];
		$project_text = get_project_text($project);
		printf('<p><a target="_blank" href="%s">%s %s</a></p>', site_url('?show_evaluation='.$key), $project_text, strftime($rsvp_options["long_date"], strtotime($timestamp)) )."\n";
	}
}

if(!empty($_POST["speaker_id"]) && !empty($_POST["project"]))
	{
		$speaker_id = (int) $_POST["speaker_id"];
		$speaker_user = get_userdata($speaker_id);
		$timestamp = $_POST["timestamp"];
		$key = 'evaluation|'.$timestamp.'|'.$_POST["project"].'|'.$_SERVER['SERVER_NAME'];
		$project = $_POST["project"];
		$project_text = get_project_text($project);
		$evaluator = get_userdata($current_user->ID);
		$evaluation = sprintf('<h1>Speaker: %s %s</h1>',$speaker_user->first_name,$speaker_user->last_name)."\n";
		$evaluation .= sprintf('<h2>Manual/Path: %s</h2>',$_POST["manual"])."\n";
		$evaluation .= sprintf('<h2>Project: %s</h2>',$project_text)."\n";
		$evaluation .= sprintf('<p><strong>Title</strong> %s</p>',stripslashes($_POST["speech_title"]))."\n";
		$evaluation .= sprintf('<p><strong>Evaluator</strong> %s</p>',$evaluator->first_name. ' '.$evaluator->last_name)."\n";
		$evaluation .= sprintf('<p><strong>Date</strong> %s</p>', strftime($rsvp_options["long_date"], strtotime($timestamp)) )."\n";

$url = 'http://wp4toastmasters.com/?wpt_forms&form='.$project;
$response = wp_remote_get( $url );
if( is_array($response) ) {
  $header = $response['headers']; // array of http header lines
  $body = $response['body']; // use the content
}
else
	die('Error retrieving form template');

$slug = $project;
$name = $project_text;
$intro = $prompts = '';
if(!empty($body) && strpos($body,'++++'))
	{
	$parts = explode('++++',$body);
	$prompts = trim($parts[4]);
	}
if(empty($prompts))
		{
		$prompts = 'You excelled at
You may want to work on</strong></p>
To challenge yourself
Other Comments';
		}
		$lines = explode("\n",$prompts);
		foreach($lines as $index => $line)
			{
			$parts = explode("|",$line);
			$prompt = array_shift($parts);
			$evaluation .= wpautop('<strong>'.$prompt.'</strong>');
			if(!empty($_POST["check"][$index]))
				$evaluation .= wpautop($_POST["check"][$index]);
			$evaluation .= wpautop(stripslashes($_POST["comment"][$index]));
			}

		update_user_meta($speaker_id,$key, $evaluation);
		echo '<p>Recording to Member Progress Report</p>';
		echo $evaluation;
	
	printf('<p>%s %s</p>',__('Emailing to'), $speaker_user->user_email );
	$mail["subject"] = "Speech Evaluation";
	$mail["replyto"] = $evaluator->user_email;
	$mail["html"] = "<html>\n<body>\n".$evaluation."\n</body></html>";
	$mail["to"] = $speaker_user->user_email;
	$mail["from"] = $evaluator->user_email;
	$mail["fromname"] = $evaluator->first_name. ' '.$evaluator->last_name;
	awemailer($mail);

	}

if(!empty($_GET["project"]) && !empty($_GET["speaker"]) && !empty($_GET["meeting_id"]))
	{
		$project = $_GET["project"];
		$speaker_id = (int) $_GET["speaker"];
		$meeting_id = (int) $_GET["meeting_id"];
		show_evaluation_form($project, $speaker_id, $meeting_id);
	}

$is_current = false;
$next_evaluations = '';
$my_next_evaluations = '';
$future = get_future_events (" post_content LIKE '%[toastmaster%' ", 1);
if($future)
foreach($future as $meet)
{
	$sql = "SELECT * FROM $wpdb->postmeta WHERE post_id=".$meet->ID." AND meta_key LIKE '_Evaluat%' ";
	$wpdb->show_errors();
	$eval_results = $wpdb->get_results($sql);
	foreach($eval_results as $row)
		{
			if(empty($row->meta_value))
				continue;
			$row->meta_value = (int) $row->meta_value;
			$eval_user = get_userdata($row->meta_value);
			$evaluators[] = sprintf('Evaluator: %s %s <a href="%s">%s</a> ',$eval_user->first_name,$eval_user->last_name,$eval_user->user_email,$eval_user->user_email);
			$eval_emails[] = $eval_user->user_email;
		}
	$ge = get_post_meta($meet->ID,'_General_Evaluator_1',true);
	if($ge)
		{
			$eval_user = get_userdata($ge);
			$eval_emails[] = $eval_user->user_email;
			$evaluators[] = sprintf('General Evaluator: %s %s <a href="%s">%s</a> ',$eval_user->first_name,$eval_user->last_name,$eval_user->user_email,$eval_user->user_email);
		}
	$sql = "SELECT * FROM $wpdb->postmeta WHERE post_id=".$meet->ID." AND meta_key LIKE '_Speak%' ORDER BY meta_key";
	$results = $wpdb->get_results($sql);
	if($results)
	foreach($results as $row)
		{
		$speaker = (int) $row->meta_value;
		if(!$speaker)
			continue;
		$role = $row->meta_key;
		$project_index = get_post_meta($meet->ID, '_project'.$role, true);
		$project = (!empty($project_index)) ? get_project_text($project_index) : ' (project ?) ';
		if(empty($project_index)) $project_index = 'unspecified';
		$speaker_name = get_user_meta($speaker,'first_name',true).' '.get_user_meta($speaker,'last_name',true);
		$title = get_post_meta($meet->ID, '_title'.$role, true);
		$next_evaluations .= sprintf('<p><a href="%s&speaker=%d&meeting_id=%d&project=%s">%s, %s, %s</a> %s</p>',admin_url('admin.php?page=wp4t_evaluations'),$speaker,$meet->ID,$project_index,$speaker_name, $project,$meet->date, $title);
		}
}

if(isset($eval_emails) && in_array($current_user->user_email, $eval_emails))
	{
		printf('<h3>%s</h3>',__('Speakers at Next Meeting','rsvpmaker-for-toastmasters'));
		echo $next_evaluations;
	}
$past_evaluations = array();
$past = get_past_events ("", 20);
if($past)
{
foreach($past as $past_meet)
{
	$sql = "SELECT meta_key FROM $wpdb->postmeta WHERE post_id=".$past_meet->ID." AND meta_key LIKE '_Evaluat%' AND meta_value=".$current_user->ID;
	$wpdb->show_errors();
	$key = $wpdb->get_var($sql);
	if(empty($key))
		continue;
	$sql = "SELECT * FROM $wpdb->postmeta WHERE post_id=".$past_meet->ID." AND meta_key LIKE '_Speak%' ";
	$results = $wpdb->get_results($sql);
	if($results)
	foreach($results as $row)
		{
		$speaker = $row->meta_value;
		if(! $speaker > 0)
			continue;
		$role = $row->meta_key;
		$project_index = get_post_meta($past_meet->ID, '_project'.$role, true);
		$project = (!empty($project_index)) ? get_project_text($project_index) : ' (project ?) ';
		if(empty($project_index)) $project_index = 'unspecified';
		$speaker_name = get_user_meta($speaker,'first_name',true).' '.get_user_meta($speaker,'last_name',true);
		$title = get_post_meta($speaker, '_title'.$role, true);
		$past_evaluations[$past_meet->ID.'-'.$speaker] = sprintf('<p><a href="%s&speaker=%d&meeting_id=%d&project=%s">%s, %s, %s</a> %s</p>',admin_url('admin.php?page=wp4t_evaluations'),$speaker,$past_meet->ID,$project_index,$speaker_name, $project,$past_meet->date, $title);
		}
}
if(!empty($past_evaluations))
	{
	printf('<h3>%s</h3><p>%s</p>',__('Show Form','rsvpmaker-for-toastmasters'),__('Showing links for speakers at recent meetings where you were an evaluator.','rsvpmaker-for-toastmasters'));
	echo implode("\n",$past_evaluations);
	}
}

if(!empty($next_evaluations))
echo '<h3>Next Meeting</h3>'.$next_evaluations;

if(!empty($eval_emails))
	{
	$em = implode(",",$eval_emails);
	echo wpautop(implode("\n",$evaluators));
	printf('<p>Evaluation Team: <a href="mailto:%s">%s</a>',$em,$em);
	}
$eval_emails = array();
$allpast = get_past_events (" post_content LIKE '%[toastmaster%' ", 5);
if($allpast)
foreach($allpast as $meet)
{
	$evaluators = $eval_emails = array();
	echo '<h3>'.$meet->date.'</h3>';
	$sql = "SELECT * FROM $wpdb->postmeta WHERE post_id=".$meet->ID." AND meta_key LIKE '_Evaluat%' ";
	$wpdb->show_errors();
	$eval_results = $wpdb->get_results($sql);
	foreach($eval_results as $row)
		{
			if(empty($row->meta_value))
				continue;
			$row->meta_value = (int) $row->meta_value;
			$eval_user = get_userdata($row->meta_value);
			$evaluators[] = sprintf('Evaluator: %s %s <a href="%s">%s</a> ',$eval_user->first_name,$eval_user->last_name,$eval_user->user_email,$eval_user->user_email);
			$eval_emails[] = $eval_user->user_email;
		}
	$ge = get_post_meta($meet->ID,'_General_Evaluator_1',true);
	if($ge)
		{
			$eval_user = get_userdata($ge);
			$eval_emails[] = $eval_user->user_email;
			$evaluators[] = sprintf('General Evaluator: %s %s <a href="%s">%s</a> ',$eval_user->first_name,$eval_user->last_name,$eval_user->user_email,$eval_user->user_email);
		}
	$sql = "SELECT * FROM $wpdb->postmeta WHERE post_id=".$meet->ID." AND meta_key LIKE '_Speak%' ORDER BY meta_key";
	$results = $wpdb->get_results($sql);
	if($results)
	foreach($results as $row)
		{
		$speaker = (int) $row->meta_value;
		if(!$speaker)
			continue;
		$role = $row->meta_key;
		$project_index = get_post_meta($meet->ID, '_project'.$role, true);
		$project = (!empty($project_index)) ? get_project_text($project_index) : ' (project ?) ';
		if(empty($project_index)) $project_index = 'unspecified';
		$speaker_name = get_user_meta($speaker,'first_name',true).' '.get_user_meta($speaker,'last_name',true);
		$title = get_post_meta($meet->ID, '_title'.$role, true);
		printf('<p><a href="%s&speaker=%d&meeting_id=%d&project=%s">%s, %s, %s</a> %s</p>',admin_url('admin.php?page=wp4t_evaluations'),$speaker,$meet->ID,$project_index,$speaker_name, $project,$meet->date, $title);
		}
if(!empty($eval_emails))
	{
	$em = implode(",",$eval_emails);
	echo wpautop(implode("\n",$evaluators));
	printf('<p>Evaluation Team: <a href="mailto:%s">%s</a>',$em,$em);
	}

}

tm_admin_page_bottom($hook);
}


function wp4t_evaluations_edit () {
$hook = tm_admin_page_top(__('Edit Evaluation Forms','rsvpmaker-for-toastmasters'));

if(isset($_GET["form"]))
{
$response = wp_remote_get( 'http://wp4toastmasters.com/?wpt_forms&form='.$_GET["form"] );
if( is_array($response) ) {
  $header = $response['headers']; // array of http header lines
  $body = $response['body']; // use the content
}

if(!empty($body))
	{
		$forms = explode("====",$body);
echo '<form method="post" target="_blank" action="http://wp4toastmasters.com/?wpt_forms"><input type="hidden" name="edit" value="1"> ';
		foreach($forms as $form)
		{
			$parts = explode("++++",$form);
			$id = trim($parts[0]);
			$slug = trim($parts[1]);
			$name = trim($parts[2]);
			$intro = trim($parts[3]);
			$prompts = trim($parts[4]);
			printf('<input type="hidden" name="slug[%d]" value="%s" >',$id, $slug);
			printf('<input type="hidden" name="name[%d]" value="%s" ><h3>%s</h3>',$id, $name, $name);
			printf('<p><strong>Instructions for Evaluator</strong>
<br /><textarea style="width:800px; height: 15em;" name="intro[%d]">%s</textarea></p>',$id, $intro);
			printf('<p><strong>Speech Prompts</strong></p>
<p><em>Each prompt appears on a single line. Multiple choice prompts, if any, are separated from the prompt and from each other by the | symbol.<br />Examples:</em>
<br />What did you like about the speech?
<br />Vocal Variety|5 (Exemplary)|4 (Excels)|3 (Accomplished)|2 (Emerging)|1 (Developing)
<br /><textarea style="width:800px; height: 15em;" name="prompts[%d]">%s</textarea></p>',$id, $prompts);
		}

	submit_button('Update');
	echo '</form>';
	}
}
//$o = '<option value="all">All</option>';
$o = '';
$project_options_array = get_projects_array('options');
foreach($project_options_array as $manual => $options)
	$o .= sprintf('<option value="manual:%s" style="font-weight: bold;">%s</option>%s',$manual,$manual,$options);

printf('<h3>Choose Forms to Display</h3><p>Select a whole manual/path or a specific project</p>
<form method="get" action="%s"><select name="form">%s</select>',admin_url('admin.php'),$o);
submit_button('Submit');
echo '<input type="hidden" name="page" value="wp4t_evaluations_edit" /></form>';	

tm_admin_page_bottom($hook);
}


function clean_bullets($text, $replace = '')
{
$newtext = '';
$lines = explode("\n",$text);
foreach($lines as $line)
	{
	$line = trim($line);
	if(empty($line))
		{
		$newtext .= "\n";
		continue;
		}
	$newtext .= preg_replace( "/^[^A-Za-z\\&;]+/", $replace, $line )."\n";
	}
return $newtext;
}

function show_evaluation () {
if(isset($_GET["show_evaluation"]) && is_user_logged_in())
	{
		global $current_user;
		$user_id = (isset($_GET["member_id"])) ? $_GET["member_id"] : $current_user->ID;
		$eval = get_user_meta($user_id,$_GET["show_evaluation"],true);
		printf('<html><title>Evaluation</title><body>%s</body></html>',$eval);
		exit();
	}

}

add_action('init','show_evaluation');

function pathways_report($toastmaster = 0) {
global $current_user;
global $rsvp_options;

if(isset($_GET["toastmaster"]))
	{
		$toastmaster = (int) $_GET["toastmaster"];
	}
if(empty($toastmaster))
	{
	$users = get_users();
	foreach($users as $user)
		{
		$stats = get_tm_stats($user->ID);
		$p = '';
		foreach($stats["count"] as $mkey => $count)
			{
				if(strpos($mkey,'Level'))
					$p .= sprintf('<p><strong>%s</strong> %s</p>',$count,$mkey);
			}
		if(!empty($p))
			{
				$userdata = get_userdata($user->ID);
				$key = preg_replace('/[^A-Za-z]/','',$userdata->last_name.$userdata->first_name);
				$path[$key] = sprintf('<h3>%s %s (<a href="%s">details</a>)</h3>%s',$userdata->first_name,$userdata->last_name,admin_url('admin.php?page=toastmasters_reports&toastmaster=').$user->ID,$p);
			}
		}
	if(!empty($path))
	{
		ksort($path);
		echo implode("\n",$path);
	}
	else
	_e('No Pathways projects yet','rsvpmaker-for-toastmasters');
	return;
	}

if(isset($_POST["pathwaysnote"]))
	{
		$note = stripslashes($_POST["pathwaysnote"]);
		$key = stripslashes($_POST["tmnote"]);
		$author = get_userdata($current_user->ID);
		$note .= "\n\n<em>".__('Added by','rspvpmaker-for-toastmasters').": ".$author->first_name.' '.$author->last_name.", ".strftime($rsvp_options["long_date"]).'</em>';
		add_user_meta($toastmaster,$key,$note);
	}

$stats = get_tm_stats($toastmaster);
$manuals = get_manuals_array();
foreach($manuals as $manual => $label)
	{
	if(!strpos($manual,'Level'))
		continue; // no level, not pathways
	$notes = get_user_meta($toastmaster,'tmnote_'.$manual);
	if(!empty($stats["speeches"][$manual]) || !empty($notes))
		{
		printf('<h2>%s</h2>',$label);
		if(!empty($stats["speeches"][$manual]))
			echo $stats["speeches"][$manual];
		if(!empty($notes))
			{
			echo '<p><strong>Notes</strong></p>';
				foreach($notes as $note)
					echo wpautop($note);
			}
$mslug = str_replace(' ','_',$manual);
?>
<form action="<?php echo site_url($_SERVER['REQUEST_URI']); ?>" method="post" id="<?php echo $mslug; ?>">
<div class="pathwaysnote_entry"><textarea name="pathwaysnote" rows="2" style="width: 100%"></textarea></div>
<input type="hidden" name="tmnote" value="tmnote_<?php echo $manual; ?>">
<button target="<?php echo $mslug; ?>">Add Note</button>
</form>
<?php
		}
	}
?>
<p><strong>About this screen:</strong> The preliminary support for Pathways in WordPress for Toastmasters includes tracking of speeches, along with a space to add notes about aspects of the program other than speeches.</p>
<?php
}

add_action('wp_ajax_edit_member_stats','wp_ajax_edit_member_stats');

function wp_ajax_edit_member_stats () {

			$id = $_REQUEST["toastmaster"];
			$userdata = get_userdata($id);
			$tmstats = get_tm_stats($userdata->ID);
			$stats = $tmstats["pure_count"];
			if(!empty($_POST['education_awards']))
				update_user_meta($id,'education_awards',$_POST['education_awards']);
			foreach($_POST["stat"] as $field => $value)
				{
				if(($value == '') || ($value == 0))
					{
					delete_user_meta($id,'tmstat:'.$field);
					continue;
					}
				if(empty($stats[$field])) $stats[$field] = 0;
				$adj = $value - $stats[$field];
				if($adj != 0)
				update_user_meta($id,'tmstat:'.$field,$adj);
				}
			foreach($_POST["add_project"] as $manual => $p)
				{
				if(!empty($p))
					{
						$projectslug = preg_replace('/[ _]/','',$manual)."_project";
						$year = $_POST['project_year'][$manual];
						$month = $_POST['project_month'][$manual];
						$day = $_POST['project_day'][$manual];
						if($year && $month && $day)
							$date = strtotime($year.'-'.$month.'-'.$day);
						else
							$date = time();
					$text = get_project_text($p);
					$pa = array('title' => $text, 'date' => $date, 'source' => 'meta');
					add_user_meta($id,$projectslug,$pa);
					}
				}
		if(isset($_POST["delete_meta"]))
			{
				foreach($_POST["delete_meta"] as $deletethis)
				{
					$deletethis = str_replace(' ','_',$deletethis);
					delete_user_meta($id,$deletethis);
					add_user_meta($id,'wp4t_stats_delete',$deletethis);
					echo "delete $deletethis <br />";
				}
			}

		echo '<div class="updated"><p>'.__('Updated','rsvpmaker-for-toastmasters').'</p></div>';
wp_die();
}

function wpt_json () {
global $wpdb;
global $current_user;
if(isset($_GET["all"]))
{
$users = get_users();
foreach($users as $user)
	{
	$toastmasters_id = get_user_meta($user->ID,'toastmasters_id',true);
	if(!$toastmasters_id)
		continue;
	$sql = "SELECT meta_key, meta_value FROM $wpdb->usermeta WHERE user_id=".$user->ID." AND meta_key LIKE 'tm|Sp%".$_SERVER['SERVER_NAME']."%' ORDER BY umeta_id";
	$results = $wpdb->get_results($sql);
	foreach ($results as $row)
		{
			$json_data[$toastmasters_id][] = $row;
		}
	}
}
else
{
	$toastmasters_id = get_user_meta($current_user->ID,'toastmasters_id',true);
	$sql = "SELECT meta_key, meta_value FROM $wpdb->usermeta WHERE user_id=".$current_user->ID." AND meta_key LIKE 'tm|%".$_SERVER['SERVER_NAME']."%' ";
	$results = $wpdb->get_results($sql);
	foreach ($results as $row)
		{
			$json_data[$toastmasters_id][] = $row;
		}
}

$json = json_encode($json_data);

//echo $json;
$url = 'http://wp4toastmasters.com/?wpt_stats_warehouse='.$_SERVER['SERVER_NAME'];
$ch = curl_init();
curl_setopt($ch,  CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: ' . strlen($json)));
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$response  = curl_exec($ch);
echo '<p>curl error: '.curl_error($ch).'</p>';
curl_close($ch);
$parts = explode('+++++',$response);
echo $parts[0];
$json = trim($parts[1]);
$download = json_decode($json,true);
echo '<pre>';
print_r($download);
echo '</pre>';
foreach($download as $toastmasters_id => $keys) {
	   if(!$toastmasters_id)
	   		continue;
		$user_id = $wpdb->get_var("SELECT user_id FROM $wpdb->usermeta WHERE meta_key='toastmasters_id' AND meta_value=".$toastmasters_id);
		if(!$user_id)
			continue;
	   foreach($keys as $kv)
	   {
		$umeta_id = $wpdb->get_var("SELECT umeta_id FROM $wpdb->usermeta WHERE meta_key='".$kv["meta_key"]."' AND user_id=".$user_id);
		if($umeta_id)
			$sql = $wpdb->prepare("UPDATE $wpdb->usermeta SET meta_value=%s WHERE umeta_id=%d",$kv["meta_value"],$umeta_id);
		else
			$sql = $wpdb->prepare("INSERT INTO $wpdb->usermeta SET meta_key=%s, meta_value=%s, user_id=%d",$kv["meta_key"],$kv["meta_value"],$user_id);
   		echo $sql.'<br />';
		$wpdb->query($sql);
	   }
   }


}

function wpt_json_user_id ($user_id, $toastmasters_id) {
global $wpdb;
global $rsvp_options;
$up = 0;
$down = 0;
if(!get_option('wp4toastmasters_enable_sync'))
	return 'Data sync between WordPress for Toastmasters websites disabled';
if(!$toastmasters_id)
	return 'To sync data, first add Toastmasters ID to member profile';
$last_sync = (int) get_user_meta($user_id,'tm_last_stats_sync',true);
if($last_sync && ($last_sync > strtotime('-1 day')) && !isset($_GET["debug"]) && !isset($_GET["syncnow"]) )
	return 'Last data sync within 24 hours (<a href="'.$_SERVER['REQUEST_URI'].'&syncnow=1">sync now</a>)';
update_user_meta($user_id,'tm_last_stats_sync',time());
$sql = "SELECT meta_key, meta_value FROM $wpdb->usermeta WHERE user_id=".$user_id." AND meta_key LIKE 'tm|%".$_SERVER['SERVER_NAME']."%' ";
$results = $wpdb->get_results($sql);
foreach ($results as $row)
	{
		$json_data[$toastmasters_id][] = $row;
	}
//check for deleted records
$deleted = get_user_meta($user_id,'wp4t_stats_delete');
if(is_array($deleted))
foreach ($deleted as $key)
	$json_data[$toastmasters_id][] = array('meta_key' => 'delete', 'meta_value' => $key);
return wpt_json_send($json_data).' user id: '.$user_id.' toastmasters id: '.$toastmasters_id;
}

function get_toastmasters_ids () {
$users = get_users();
$tmids = array();
foreach($users as $user) {
	$t = get_user_meta($user->ID,'toastmasters_id',true);
	if($t)
		$tmids[$user->ID] = $t;
	}
return $tmids;
}

function wpt_json_batch_upload () {
global $wpdb;
$wpdb->show_errors();
$last_wpt_json_batch_upload = (int) get_option('last_wpt_json_batch_upload');
$sql = "SELECT * from $wpdb->usermeta WHERE umeta_id > $last_wpt_json_batch_upload AND meta_key LIKE 'tm|%".$_SERVER['SERVER_NAME']."%' ORDER BY umeta_id LIMIT 0, 200";
$results = $wpdb->get_results($sql);
if($results)
	{
		$tmids = get_toastmasters_ids();
		foreach($results as $row)
			{
			$last = $row->umeta_id;
			if(isset($tmids[$row->user_id]))
				$json_data[$tmids[$row->user_id]][] = $row;
			}
	update_option('last_wpt_json_batch_upload',$last);
	}
if(isset($json_data))
	return wpt_json_send($json_data, true);
}

function wpt_json_send($json_data, $upload_only = false) {
global $wpdb;
$json = json_encode($json_data);
$p = get_option('wpt_stats_warehouse_password');
if(empty($p))
	{
		$p = wp_generate_password();
		update_option('wpt_stats_warehouse_password',$p);
	}
$url = 'http://wp4toastmasters.com/?wpt_stats_warehouse='.$_SERVER['SERVER_NAME']."&p=".$p;
if($upload_only)
	$url .= '&upload_only=1';
$ch = curl_init();
curl_setopt($ch,  CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: ' . strlen($json)));
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
if(isset($_GET["debug"]))
echo $url . "<br />" .$json ."<br />";
$response  = curl_exec($ch);
curl_close($ch);
$json_response = json_decode($response,true);
if(!isset($json_response["log"]))
	{
	update_option('sync_error_json_log',$response);
	return 'Sync error, logged to sync_error_json_log';
	}
$log = $json_response["log"];
if(!isset($json_response["uploaded"]))
	{
	update_option('sync_error_json_log',$json_response["log"]);
	return 'Sync error, logged to sync_error_json_log';
	}
update_option('last_sync_result',var_export($json_response,true));
$download = $json_response["download"];
$uploaded = $json_response["uploaded"];
$deleted = $json_response["deleted"];
$members = $json_response["members"];
if(isset($_GET["debug"]))
{
echo $parts[0];
echo '<pre>';
echo "JSON UP\n";
print_r($json_data);
echo "\ndownload:";
print_r($download);
echo '</pre>';
}
$down = 0;
if(isset($download) && is_array($download))
foreach($download as $toastmasters_id => $keys) {
	   if(!$toastmasters_id)
	   		continue;
		$user_id = $wpdb->get_var("SELECT user_id FROM $wpdb->usermeta WHERE meta_key='toastmasters_id' AND meta_value=".$toastmasters_id);
		if(!$user_id)
			continue;
	   foreach($keys as $kv)
	   {
		if($kv["meta_key"] == 'delete')
			{
				delete_user_meta($user_id,$kv["meta_value"]);
				continue;
			}
		$umeta_id = $wpdb->get_var("SELECT umeta_id FROM $wpdb->usermeta WHERE meta_key='".$kv["meta_key"]."' AND user_id=".$user_id);
		if($umeta_id)
			$sql = $wpdb->prepare("UPDATE $wpdb->usermeta SET meta_value=%s WHERE umeta_id=%d",$kv["meta_value"],$umeta_id);
		else
			$sql = $wpdb->prepare("INSERT INTO $wpdb->usermeta SET meta_key=%s, meta_value=%s, user_id=%d",$kv["meta_key"],$kv["meta_value"],$user_id);
		$wpdb->query($sql);
		$down++;
	   }
   }
return "Data sync result uploaded $uploaded records, deleted $deleted, downloaded $down for $members members";
}

?>