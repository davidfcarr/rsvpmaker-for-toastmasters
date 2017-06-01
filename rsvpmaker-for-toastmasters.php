<?php
/*
Plugin Name: RSVPMaker for Toastmasters
Plugin URI: http://wp4toastmasters.com
Description: This Toastmasters-specific extension to the RSVPMaker events plugin adds role signups and member performance tracking. Better Toastmasters websites!
Author: David F. Carr
Version: 2.5.4
Author URI: http://www.carrcommunications.com
Text Domain: rsvpmaker-for-toastmasters
Domain Path: /translations
*/

function rsvptoast_load_plugin_textdomain() {
    load_plugin_textdomain( 'rsvpmaker-for-toastmasters', FALSE, basename( dirname( __FILE__ ) ) . '/translations/' );
}
add_action( 'plugins_loaded', 'rsvptoast_load_plugin_textdomain' );

include "tm-reports.php";
if(is_admin())
	include 'mce_shortcode.php';

/*
awesome_dashboard_widget_function()
awesome_add_dashboard_widgets()
wp4toast_reminders ()
agenda_note($atts, $content)
toastmaster_short($atts=array(),$content="")
tm_calc_time($minutes)
toastmaster_officers ($atts)
awe_user_dropdown ($role, $assigned, $settings = false)
awe_assign_dropdown ($role)
clean_role($role)
awesome_wall($comment_content, $post_id)
role_post()
editor_signup_notification($post_id, $user_id,$role,$manual = '',$project = '',$title = '')
speaker_details_agenda ($field)
speaker_details ($field, $assigned = 0, $atts)
get_toast_speech_options() // obsolete?
speech_public_details ($field)
speech_progress ()
extended_list ()
wp4t_user_row_edit_member( $actions, $user )
edit_members()
awesome_menu()
wp4toastmasters_settings()
register_wp4toastmasters_settings()
wp4toast_login_message( $message )
get_tm_security ()
tm_security_options ($label)
add_to_mailman($user_id, $olduser = NULL)
unsubscribe_mailman($user_id, $olduser = NULL)
awesome_event_content($content)
awesome_members()
display_member($userdata, $title='')
add_awesome_member()
extract_fields_tm($matches)
name2fields($name)
get_user_by_tmid($id)
add_member_user($user)
no_member_match ($active_ids)
awesome_contactmethod( $contactmethods )
login_redirect($link)
class AwesomeWidget extends WP_Widget
awesome_roles()
edit_toast_roles( $content )
recommend_hash($role, $user)
accept_recommended_role()
assign_toast_roles( $content )
signup_sheet()
future_toastmaster_meetings ($limit = 10)
awesome_open_roles($post_id = NULL)
print_contacts( $cron = false )
detect_default_password()
awesome_user_profile_fields( $user )
save_awesome_user_profile_fields( $user_id )
speech_intros() // obsolete?
profile_prompt() // obsolete?
awesome_rating () // obsolete?
pack_speakers($count)
backup_speaker_notify($assigned)
awemailer($mail)
rsvpmaker_print_redirect()
tm_sidebar_post($post_id)
themewords ($atts)
simplify_html($text, $allowable_tags="<p><br><div><b><strong><em><i><h1><h2><h3><h4><h5><h6><ol><ul><li>")
user_archive ()
toast_admin_notice ()
shortcode_eventdates($post_id)
member_not_user()
add_awesome_roles()
awesome_role_activation_wrapper()
toastmasters_css_js()
wp4_speech_prompt($event_post, $datetime)
wp4_email_contacts(  )
toolbar_add_member( $wp_admin_bar )
rsvpmaker_permalink_query ($id, $query = '')
toastmasters_datebox_message ()
wp4toast_template( $user_id = 1 )
new_agenda_template()
toast_activate()
check_first_login ()
archive_users_init ()
toolbar_link_to_agenda( $wp_admin_bar )
edit_template_url($post_id)
add_from_template_url($post_id)
agenda_setup_url($post_id)
member_only_content($content)
class WP_Widget_Members_Posts extends WP_Widget
class WP_Widget_Club_News_Posts extends WP_Widget
wptoast_widgets ()
club_news($args)
toast_modify_query_exclude_category( $query )
members_only($args)
members_only($args)
toast_excerpt_more( $more )
toastmasters_sidebar_mce_css( $mce_css )
agenda_sidebar_editor ($post_id)
password_hurdle ($pass)
rsvptoast_admin_notice()
get_toast_templates ()
wp4t_header($default)
rsvptoast_pages ($user_id)
placeholder_image ()
get_manuals_array()
get_manuals_options( $manual )
get_project_text($slug)
get_project_key($project)
get_projects_array ($choice = 'projects')
timeplanner($atts, $content)
agenda_timing ()
admin_link_menu()
tm_security_setup ($check = true)
tm_security_caps ()
bp_toastmasters($post_id,$actiontext,$user_id)
display_toastmasters_profile()
ajax_toast_assign()
*/

add_filter( 'login_message', 'wp4toast_login_message' );
add_filter('the_content','awesome_event_content');
add_filter('the_content','edit_toast_roles',1);
add_filter('the_content','assign_toast_roles',1);
add_filter('the_content','member_only_content');
add_filter('the_excerpt','member_only_excerpt');
add_filter('get_the_excerpt','member_only_excerpt');
add_filter('jetpack_seo_meta_tags', 'members_only_jetpack');
add_filter( 'excerpt_more', 'toast_excerpt_more' );
add_filter('lectern_default_header','wp4t_header');
add_filter('user_contactmethods','awesome_contactmethod',10,1);
add_filter( 'user_row_actions','wp4t_user_row_edit_member', 9, 2);
if(strpos($_SERVER['REQUEST_URI'],'agenda_sidebar') )
	add_filter( 'mce_css', 'toastmasters_sidebar_mce_css' );
add_action('init','signup_sheet');
add_action('init','print_contacts');
add_action('init','awesome_open_roles');
add_action('init','role_post');
add_action('init','placeholder_image');
add_action( 'widgets_init', 'wptoast_widgets');
add_action( 'wp_enqueue_scripts', 'toastmasters_css_js' );
add_action( 'pre_get_posts', 'toast_modify_query_exclude_category' );
add_action('wp_login','tm_security_setup');
add_action( 'admin_bar_menu', 'toolbar_add_member', 999 );
if(strpos($_SERVER['REQUEST_URI'],'rsvpmaker=') || strpos($_SERVER['REQUEST_URI'],'rsvpmaker/'))
	add_action( 'admin_bar_menu', 'toolbar_link_to_agenda', 999 );
add_action('admin_init','check_first_login');
add_action('admin_init','archive_users_init');
add_action('admin_menu', 'awesome_menu');
add_action('admin_init','awesome_role_activation_wrapper');
add_action( 'admin_init', 'register_wp4toastmasters_settings' );
add_action('admin_init','new_agenda_template');
//add_action('admin_notices', 'toast_admin_notice');
add_action( 'admin_notices', 'rsvptoast_admin_notice' );
add_action('wp_dashboard_setup', 'awesome_add_dashboard_widgets',99 );
add_action('user_register','add_to_mailman');
add_action('profile_update', 'add_to_mailman');
add_action( 'delete_user', 'unsubscribe_mailman' );
add_action( 'remove_user_from_blog', 'unsubscribe_mailman' );
add_action('admin_init','awesome_roles');
add_action('wp','accept_recommended_role');
add_action( 'show_user_profile', 'awesome_user_profile_fields' );
add_action( 'edit_user_profile', 'awesome_user_profile_fields' );
add_action( 'personal_options_update', 'save_awesome_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_awesome_user_profile_fields' );
add_action('user_new_form','member_not_user');
add_action ('rsvpmaker_datebox_message','toastmasters_datebox_message');
add_action('toastmasters_agenda_notification','bp_toastmasters', 10, 3);
add_action('toastmasters_agenda_notification','wp4t_intro_notification', 10, 5);
add_action( 'bp_profile_header_meta', 'display_toastmasters_profile' );
add_action( 'admin_head', 'profile_richtext' );

//add_action( 'wp_ajax_toast_assign', 'ajax_toast_assign' );

function profile_richtext () {
if(strpos($_SERVER['REQUEST_URI'],'profile.php') || strpos($_SERVER['REQUEST_URI'],'user-edit.php')) 
echo '<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script> 
<script>
        tinymce.init({selector:"textarea#description",plugins: "code,link"});		
</script>';
}

function speech_intro_data($user_id,$post_id,$field)
{
global $rsvp_options;
	$speaker = get_userdata($user_id);
	$manual = get_post_meta($post_id, '_manual'.$field, true);
	$project_index = get_post_meta($post_id, '_project'.$field, true);
	if(!empty($project_index))
		{
		$project = get_project_text($project_index);
		$manual .= ': '.$project;
		}
	$title = get_post_meta($post_id, '_title'.$field, true);
	$intro = get_post_meta($post_id, '_intro'.$field, true);
	
	$t = strtotime(get_rsvp_date($post_id));
	$date = strftime($rsvp_options["short_date"],$t);
	$url = get_permalink($post_id);
	
	$message = '<h2>'.$speaker->first_name.' '.$speaker->last_name."</h2>\n\n".$manual;
	if(!empty($title))
		$message .= "\n\n".__('Title','rsvpmaker-for-toastmasters').': '.$title;
	if(!empty($intro))
		$message .= "\n\n".__('Introduction','rsvpmaker-for-toastmasters').': '.$intro;
return $message;
}

function wp4t_intro_notification ($post_id,$actiontext,$user_id, $field='',$actiontype='') {
global $rsvp_options;	

	if($actiontype != 'intro')
		return;
	
$meeting_leader = get_post_meta($post_id, 'meeting_leader', true);
if(empty($meeting_leader))
	$meeting_leader = "_Toastmaster_of_the_Day_1";

	$toastmaster = get_post_meta($post_id,$meeting_leader,true);

if($toastmaster && is_numeric($toastmaster))
	{
	$speaker = get_userdata($user_id);
	$manual = get_post_meta($post_id, '_manual'.$field, true);
	$project_index = get_post_meta($post_id, '_project'.$field, true);
	if(!empty($project_index))
		{
		$project = get_project_text($project_index);
		$manual .= ': '.$project;
		}
	$title = get_post_meta($post_id, '_title'.$field, true);
	
	$t = strtotime(get_rsvp_date($post_id));
	$date = strftime($rsvp_options["short_date"],$t);
	$userdata = get_userdata($toastmaster);
	$url = get_permalink($post_id);
	
	$subject = $speaker->first_name.' '.$speaker->last_name.' '.__('Speech Intro for','rsvpmaker-for-toastmasters').' '.$date;
	
	$message = $speaker->first_name.' '.$speaker->last_name.' '.__('Speech for','rsvpmaker-for-toastmasters').' <a href="'.	$url .'">'.$date."</a>\n\n".$manual."\n\n".$title."\n\n".$actiontext;
	
	$toastmaster_email = $userdata->user_email;
	$message .= "\n\nThis is an automated message. Replies will be sent to ".$speaker->user_email;
	$mail["subject"] = substr(strip_tags($subject),0, 100);
	$mail["replyto"] = $speaker->user_email;
	$mail["html"] = "<html>\n<body>\n".wpautop($message)."\n</body></html>";
	$mail["to"] = $toastmaster_email;
	$mail["from"] = $speaker->user_email;
	$mail["fromname"] = $speaker->display_name;
	awemailer($mail);
	}
}

function awesome_dashboard_widget_function() {

global $current_user;
global $wpdb;

?>
<p><?php echo sprintf(__('You are viewing the private members-only area of the website. For a basic orientation, see the <a href="%s">welcome page</a>.','rsvpmaker-for-toastmasters'),admin_url('index.php?page=toastmasters_welcome') ); ?>
<br /></p>

<table>
<?php

printf('<p><a href="%s">%s</a> (%s)</p>',admin_url('profile.php?page=wp4t_set_status_form'),__('Set Away Message','rsvpmaker-for-toastmasters'),__('on vacation or unavailable','rsvpmaker-for-toastmasters'));

if(function_exists('bp_core_get_userlink'))
	printf('<p>%s: %s</p>',__('Post a message on your club social profile'),bp_core_get_userlink( $current_user->ID ) );

  $count = 0;

	$results = get_future_events(" post_content LIKE '%role=%' ",10, OBJECT, 4);
		if($results)
			  {
			  $upcoming_roles = '';
			  foreach($results as $index => $row)
			  	{
					$t = strtotime($row->datetime);
					$title = $row->post_title . ' '.date('F jS',$t );
					$permalink = rsvpmaker_permalink_query($row->postID);
					$sql = "SELECT * FROM `$wpdb->postmeta` where post_id=".$row->postID."  AND meta_value=".$current_user->ID." AND BINARY meta_key RLIKE '^_[A-Z].+[0-9]$' ";
					$role_results = $wpdb->get_results($sql);
					if($role_results)
					foreach($role_results as $role_row)
						{
						$role = preg_replace('/[^A-Za-z]/',' ',$role_row->meta_key);
						$upcoming_roles .= sprintf('<p><a href="%s">%s %s</a></p>',$permalink,$role, $title);
						}
					if(strpos($row->post_content,'role'))
					{
						if($count == 3)
							continue;
						$count++;
						printf('<tr><td>%s :</td><td> <a href="%s">'.__('Signup','rsvpmaker-for-toastmasters').'</a> | <a href="%sedit_roles=1">'.__('Edit Signups','rsvpmaker-for-toastmasters').'</a> | <a target="_blank" href="%semail_agenda=1">'.__('Email Roster','rsvpmaker-for-toastmasters').'</a></td></tr>', $title, login_redirect($permalink), login_redirect($permalink),$permalink);
						if($index == 0)
						printf('<tr><td>&nbsp;</td><td> <a target="_blank" href="%sprint_agenda=1">'.__('Print Agenda','rsvpmaker-for-toastmasters').'</a> | <a target="_blank" href="%sprint_agenda=1&word_agenda=1">'.__('Download to Word','rsvpmaker-for-toastmasters').'</a></td></tr>', $permalink,$permalink);
					}
				}
			  if(!empty($upcoming_roles))
			  	{
					printf('<h3>%s</h3>
%s',__('Upcoming Roles','rsvpmaker-for-toastmasters'),$upcoming_roles);					
				}
			  
			  }

$wp4toastmasters_mailman = get_option('wp4toastmasters_mailman');
$wp4toastmasters_member_message = get_option('wp4toastmasters_member_message');
if(!empty($wp4toastmasters_member_message))
	$wp4toastmasters_member_message = wpautop($wp4toastmasters_member_message);

?>
</table>
<p><a href="<?php echo site_url('/?signup2=1'); ?>" target="_blank"><?php _e("Print Signup Sheet",'rsvpmaker-for-toastmasters');?></a>
<br /></p>
<p><a href="./profile.php#user_login"><?php _e("Edit My Member Profile",'rsvpmaker-for-toastmasters');?></a>
<br /></p>
<!-- p><a href="< ?php echo site_url('/members/'); ?>">Member Directory</a>
<br /></p -->
<p><a href="<?php echo site_url('/?print_contacts=1'); ?>" target="_blank"><?php _e("Print Contacts List",'rsvpmaker-for-toastmasters');?></a>
<br /></p>
<p><a href="<?php echo site_url(); ?>"><?php _e("Home Page",'rsvpmaker-for-toastmasters');?></a>
<br /></p>
<?php
if(current_user_can('email_list') && isset($wp4toastmasters_mailman["members"]) && !empty($wp4toastmasters_mailman["members"]) )
	printf('<p>'.__("Email all members",'rsvpmaker-for-toastmasters').': <a href="mailto:%s" target="_blank">%s</a> ('.__('for club business or social invitations, no spam please','rsvpmaker-for-toastmasters').')<br /></p>',$wp4toastmasters_mailman["members"],$wp4toastmasters_mailman["members"]);
elseif(current_user_can('email_list'))
	printf('<p>'.__("Email all members",'rsvpmaker-for-toastmasters').': <a href="mailto:%s?subject=%s" target="_blank">%s</a> ('.__('for club business or social invitations, no spam please','rsvpmaker-for-toastmasters').')<br /></p>',wp4t_emails(),get_bloginfo('name'),__('Mailing list','rsvpmaker-for-toastmasters'));

echo $wp4toastmasters_member_message;
?>
<h3>Reports</h3>

<p>This website can be used to track member progress through the Toastmasters program.</p>

<?php 
printf('<p><a href="%s">%s</a>',admin_url('admin.php?page=my_progress_report'), __('My Progress','rsvpmaker-for-toastmasters') );
if(current_user_can('view_reports'))
{
printf('<p><a href="%s">%s</a>',admin_url('admin.php?page=toastmasters_reports'), __('Overview Report','rsvpmaker-for-toastmasters') );
printf('<p><a href="%s">%s</a>',admin_url('admin.php?page=toastmasters_cc'), __('Competent Communicator','rsvpmaker-for-toastmasters') );
printf('<p><a href="%s">%s</a>',admin_url('admin.php?page=cl_report'), __('Competent Leader','rsvpmaker-for-toastmasters') );
printf('<p><a href="%s">%s</a>',admin_url('admin.php?page=toastmasters_advanced'), __('Advanced Awards','rsvpmaker-for-toastmasters') );
printf('<p><a href="%s">%s</a>',admin_url('admin.php?page=toastmasters_attendance_report'), __('Attendance','rsvpmaker-for-toastmasters') );
}

if(current_user_can('edit_others_posts'))
{
$wp4toastmasters_officer_message = get_option('wp4toastmasters_officer_message');
if(!empty($wp4toastmasters_officer_message))
	$wp4toastmasters_officer_message = wpautop($wp4toastmasters_officer_message);
?>
<div style="padding: 5px; border:thin solid red">
<p><em>This information is only shown to site editors, administrators, and managers.</em></p>
<p><strong><?php _e("Administration",'rsvpmaker-for-toastmasters');?>:</strong></p>
<p><a href="./users.php?page=add_awesome_member"><?php _e("Add Members",'rsvpmaker-for-toastmasters');?></a>
<br /></p>
<p><a href="./users.php?page=edit_members"><?php _e("Edit Members",'rsvpmaker-for-toastmasters');?></a>
<br /></p>
<p><a href="./users.php?page=extended_list"><?php _e("Guests/Former Members",'rsvpmaker-for-toastmasters');?></a>
<br /></p>

<?php

$future = get_future_events();
$count = sizeof($future);
$args = array('post_type' => 'rsvpmaker','post_status' => 'publish', 'meta_key' => '_sked');
$templates = get_posts($args);
if($count == 0)
	{

?>
<h3><?php _e("You have no published events based on your club meeting template",'rsvpmaker-for-toastmasters');?>.</h3>
<?php
	}
elseif($count < 10)
	{
		printf('<p><strong>'.__("Future events scheduled",'rsvpmaker-for-toastmasters').': %s</strong></p>',$count);
	}

if($templates)
{
echo "<p><strong>Toastmasters ".__('Event Templates','rsvpmaker-for-toastmasters').'</strong></p>';
foreach($templates as $template) 
	{
	if( strpos($template->post_content,'[toastmaster') === false )
		continue;
	$permalink = rsvpmaker_permalink_query($template->ID);
	printf('<p>%s<br /><a href="%s">%s</a><br /><a href="%s">%s</a>', $template->post_title, add_from_template_url($template->ID), __("Add Events (based on template)",'rsvpmaker-for-toastmasters'),agenda_setup_url($template->ID), __("Agenda Setup (drag-and-drop editor)",'rsvpmaker-for-toastmasters'));
	}		
}

if(!empty($wp4toastmasters_mailman["mpass"]))
echo '<p><a href="'.trailingslashit($wp4toastmasters_mailman["mpath"]).'members" target="_blank">'.__("Members Email List",'rsvpmaker-for-toastmasters').'</a> password: '.$wp4toastmasters_mailman["mpass"].'<br /></p>';

if(!empty($wp4toastmasters_mailman["opass"]))
echo'<p><a href="'.trailingslashit($wp4toastmasters_mailman["opath"]).'members" target="_blank">'.__("Officers Email List",'rsvpmaker-for-toastmasters').'</a> password: '.$wp4toastmasters_mailman["opass"].'</p>';

echo $wp4toastmasters_officer_message;

?>
</div>
<?php
} // end editor functions

$args = array(
    'post_type' => 'attachment',
    'numberposts' => -1,
    'post_status' => null,
    'post_parent' => null, // any parent
    ); 
$attachments = get_posts($args);
if ($attachments) {
	printf('<h3>%s</h3>',__('Member Files','rsvpmaker-for-toastmasters'));
	if(current_user_can('edit_others_posts'))
		{
		printf('<p><em>%s (<a href="%s">%s</a>)</em></p>',__('This listing shows all files uploaded to the website, with the exception of images. As an editor or officer, you can hide any of these that should not be displayed to your members.','rsvpmaker-for-toastmasters'), admin_url('?show_all_files=1'), __('Show all files') );
		if(isset($_GET['hide_file']))
			add_post_meta($_GET['hide_file'],'hide',1);
		if(isset($_GET['show_file']))
			delete_post_meta($_GET['show_file'],'hide');
		}
    foreach ($attachments as $post) {
        $hide = get_post_meta($post->ID,'hide',true);
		if($hide && !isset($_GET["show_all_files"]))
			continue;
		
		setup_postdata($post);
		if(!strpos($post->post_mime_type,'mage'))
		{
		echo '<p>';
		the_attachment_link($post->ID, false);
		if(current_user_can('edit_others_posts'))
			{
			if($hide)
				printf(' | <a href="%s">%s</a>',admin_url('?show_file='.$post->ID),__('Show This','rsvpmaker-for-toastmasters'));
			else
				printf(' | <a href="%s">%s</a>',admin_url('?hide_file='.$post->ID),__('Hide This','rsvpmaker-for-toastmasters'));
			printf(' | <a href="%s">%s</a>',admin_url('post.php?action=edit&post='.$post->ID),__('Edit','rsvpmaker-for-toastmasters'));			
			}
		echo '</p>';
		}

    }
}

}

function awesome_add_dashboard_widgets() {
wp_add_dashboard_widget('awesome_dashboard_widget', 'WordPress for Toastmasters Dashboard', 'awesome_dashboard_widget_function');

// Globalize the metaboxes array, this holds all the widgets for wp-admin

global $wp_meta_boxes;

unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);


// Get the regular dashboard widgets array
// (which has our new widget already but at the end)

$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
$side_dashboard = $wp_meta_boxes['dashboard']['side']['core'];

// Backup and delete our new dashbaord widget from the end of the array

$awesome_widget_backup = array('awesome_dashboard_widget' =>
$normal_dashboard['awesome_dashboard_widget']);

unset($normal_dashboard['awesome_dashboard_widget']);

// Merge the two arrays together so our widget is at the beginning

$sorted_dashboard = array_merge($awesome_widget_backup, $normal_dashboard);

// Save the sorted array back into the original metaboxes

$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
//$wp_meta_boxes['dashboard']['side']['core'] = $awesome_widget_backup;

}

function wp4toast_reminders () {
if(!isset($_GET["cron_reminder"]))
	return;
global $wpdb;
$wp4toast_reminder = get_option('wp4toast_reminder');
if(!$wp4toast_reminder)
	die("no reminder set");

$future = get_future_events(" post_content LIKE '%role=%' ",1);
print_r($future);
if(sizeof($future))
	$next = $future[0];
else
	$next = false;

if(!$next)
	die('no event scehduled');

echo __("Next meeting",'rsvpmaker-for-toastmasters')." $next->datetime <br />";	

$nexttime = $next->datetime;

$t = strtotime($nexttime.' -'.$wp4toast_reminder);
echo date('l jS \of F Y h:i:s A',$t);
$now = current_time('timestamp');
if($now > $t)
	{
	echo "<div>".__('Reminder time is past','rsvpmaker-for-toastmasters')."</div>";
	$reminder_run = (int) get_option('reminder_run');
	if($reminder_run == $t)
		echo "<div>".__('Reminder already ran','rsvpmaker-for-toastmasters')."</div>";
	else
		{
		echo "<div>".__('Run reminder now','rsvpmaker-for-toastmasters')." </div>";
		wp4_speech_prompt($next, strtotime($next->datetime));
		update_option('reminder_run',$t);
		}
	}
else
	echo "<br />".__("Reminder time is NOT past",'rsvpmaker-for-toastmasters');

die();
}

add_action('wp4toast_reminders_cron','wp4toast_reminders_cron');

function wp4toast_reminders_cron ($interval_hours) {

$fudge = $interval_hours + 1;
$where = " post_content LIKE '%role=%' AND meta_value < DATE_ADD(NOW(), INTERVAL $fudge HOUR) ";
$future = get_future_events($where,1);
if(sizeof($future))
	$next = $future[0];
else
	die('no meeting within timeframe');

echo __("Next meeting",'rsvpmaker-for-toastmasters')." $next->datetime <br />";	

$nexttime = $next->datetime;
wp4_speech_prompt($next, strtotime($next->datetime));
die();
}

function wp4toast_reminders_test () {
$future = get_future_events('',1);
if(sizeof($future))
	$next = $future[0];
else
	die('no meeting within timeframe');

echo __("Next meeting",'rsvpmaker-for-toastmasters')." $next->datetime <br />";	

$nexttime = $next->datetime;
wp4_speech_prompt($next, strtotime($next->datetime));
die('running test');
}
if(isset($_GET["reminders_test"]))
	add_action('init','wp4toast_reminders_test');

function wp4toast_setup() {
global $wpdb;
$wpdb->show_errors();
$setup = get_option('wp4toast_setup');
if( empty( $setup ) )
	{
$success = $total = 0;
echo "<ul>";
// AND post_status='publish'
$total++;
		if($wpdb->get_var("SELECT post_title from $wpdb->posts WHERE post_type='page' AND post_content LIKE '%rsvpmaker_upcoming%' AND post_status='publish' ") )
			{
			echo "<li>(&#10004;) ".__("Calendar page created",'rsvpmaker-for-toastmasters')."</li>";
			$success++;
			}
		else
			echo "<li>(<b>X</b>) ".__("To Do: Create a Calendar page including the shortcode/placeholder",'rsvpmaker-for-toastmasters')." [rsvpmaker_upcoming calendar=\"1\"]</li>";

$total++;
		if($wpdb->get_var("SELECT post_title from $wpdb->posts WHERE post_type='page' AND post_status='publish' AND post_content LIKE '%[awesome_members%' ") )
			{
			echo "<li>(&#10004;) ".__("Member page created",'rsvpmaker-for-toastmasters')."</li>";
			$success++;
			}
		else
			echo "<li>(<b>X</b>) ".__("To Do: Create a Calendar page including the shortcode/placeholder",'rsvpmaker-for-toastmasters')." [awesome_members]</li>";
		echo "<li>";

$total++;
		$args = array('post_type' => 'rsvpmaker','post_status' => 'publish', 'meta_key' => '_sked');
		$templates = get_posts($args);
		$tcount = sizeof($templates);
		if($tcount)
			{
			echo "(&#10004;) ".__("Templates created",'rsvpmaker-for-toastmasters')." ($tcount)";
			$success++;
			}
		else
			echo "(<b>X</b>) ".__("To Do",'rsvpmaker-for-toastmasters').": ".'<a href="'.admin_url('edit.php?post_type=rsvpmaker&page=role_setup').'">'.__("Create an event template for your regular meetings",'rsvpmaker-for-toastmasters')."</a>.";

		echo "</li>";

$total++;
		$users = get_users();
		$count = sizeof($users);
		if($count > 5)
			{
			echo "<li>(&#10004;) ".__("Members imported",'rsvpmaker-for-toastmasters').": $count</li>";
			$success++;
			}
		else
			echo '<li>(<b>X</b>) '.__("To Do: Import members. Current members:",'rsvpmaker-for-toastmasters').' $count). <a href="'.admin_url('users.php?page=add_awesome_member').'">'.__("See add members screen",'rsvpmaker-for-toastmasters').'</a></li>';

$total++;
		$officers = get_option('wp4toastmasters_officer_ids');
		if(is_array($officers) )
			{
			echo "<li>(&#10004;) ".__("Officer list recorded",'rsvpmaker-for-toastmasters')."</li>";
			$success++;
			}
		else
			echo '<li>(<b>X</b>) '.__("To Do",'rsvpmaker-for-toastmasters').': <a href="'.admin_url('options-general.php?page=wp4toastmasters_settings').'">'.__("Record list of officers on settings screen",'rsvpmaker-for-toastmasters').'</a>.</li>';

		echo "</ul>";
echo "<p>$success of $total </p>";
	}
}

function agenda_note($atts, $content) {
global $post;
$output = '';
$display = isset($atts["agenda_display"]) ? $atts["agenda_display"] : 'agenda';
	
if(isset($_GET["page"]) && ($_GET["page"] == 'agenda_timing') )
	return timeplanner($atts, $content);
	
if(isset($_GET["word_agenda"]) && $_GET["word_agenda"])
	{
		$atts["style"] = '';
		$atts["sep"] = ' ';
	}

if(isset($atts["officers"]))
	$content .= toastmaster_officers($atts);

$style = (isset($atts["style"])) ? $atts["style"].';' : '';
if(!empty($atts["strong"]))
	$style .= 'font-weight: bold;';
if(!empty($atts["italic"]))
	$style .= 'font-style: italic;';
if(!empty($atts["size"]))
	$style .= 'font-size: '.$atts["size"].';';

if(!empty($style))
	$style = 'style="'.$style.'"';

if(!empty($atts["alink"]) && ($url = esc_url($atts["alink"]) ))
	$content .= ' <a href="'.$url.'">'.$url.'</a>';

if(!empty($atts["editable"]))
	{
		$editable = get_post_meta($post->ID,'agenda_note_'.$atts["editable"],true);
		if(is_club_member() && isset($_GET["edit_roles"]))
			{
			$content .= '<div class="agenda_note_editable"><h3>'.$atts["editable"].'</h3>
<textarea name="agenda_note[]" rows="5" cols="80" class="mce">'.$editable.'</textarea><input type="hidden" name="agenda_note_label[]" value="agenda_note_'.$atts["editable"].'" /></div>';
			$display = 'both';
			}
		elseif(!empty($editable))
			{
			$content .= '<h3>'.$atts["editable"].'</h3>'.wpautop($editable);
			}
	}
	
if(isset($_GET["print_agenda"]) || isset($_GET["email_agenda"]))
	{
	$agenda_time = get_option('agenda_time');
	if($display != 'web')
		{
		$time = '';
			$output = '<p class="agenda_note" '.$style.'>'.trim($content).'</p>';
		}
	}
elseif(($display == 'web') || ($display == 'both') )
	$output = '<p class="agenda_note" '.$style.'>'.trim($content).'</p>';
else
	$output = '';

if(isset($agenda_time) && $agenda_time && !empty($atts["time_allowed"]))
		{
		$maxtime = $atts["time_allowed"];
		$start_end = tm_calc_time($maxtime);
		$output = '<div class="timewrap"><div class="timeblock">'.$start_end.'</div><div class="timed_content">'.$output.'</div></div>';
		}

return $output;
}

function toastmaster_short($atts=array(),$content="") {
	global $tmroles;
	
	if(isset($_GET["page"]) && ($_GET["page"] == 'agenda_timing') )
		return timeplanner($atts, $content);
	elseif(!empty($content))
		return agenda_note($atts, $content);
	elseif(isset($atts["themewords"]))
		return themewords($atts);	
	elseif(isset($atts["officers"]))
		return toastmaster_officers($atts);
	elseif(isset($atts["special"]))
		return '<div class="role-block role-agenda-item"><p><strong>'.$atts["special"].'</strong></p></div>';	
	elseif(empty($atts["role"]) )
		return;
	$count = (int) ($atts["count"]) ? $atts["count"] : 1;
	$output = '';
	global $post, $current_user, $open;
	$permalink = rsvpmaker_permalink_query($post->ID);
	$field_base = preg_replace('/[^a-zA-Z0-9]/','_',$atts["role"]);	
	
	// need to know what role to look up for notifications	
	if(isset($atts["leader"]) )
		update_post_meta($post->ID,'meeting_leader','_'.$field_base.'_1' );

	if($field_base == 'Speaker')
		pack_speakers($count);

	if(isset($_GET["signup2"]))
		{
		for($i = 1; $i <= $count; $i++)
			{
			$field = '_' . $field_base . '_' . $i;
			$assigned = get_post_meta($post->ID, $field, true);
			if($assigned == '-1')
				{
				$assignedto = __('Not Available','rsvpmaker-for-toastmasters');
				}
			elseif($assigned)
				{
					if(is_numeric($assigned))
						{
					$member = get_userdata( $assigned );
					$assignedto = (isset($member->first_name) && isset($member->first_name)) ? $member->first_name." ".$member->last_name : __('member name not found','rsvpmaker-for-toastmasters');
					if(!empty($member->education_awards)) $assignedto .= ', '.$member->education_awards;
						}
					else
						$assignedto = $assigned . ' (guest)';
				}
			else
				$assignedto = "&nbsp;";
			$output .= "\n".'<div class="signuprole">'.$atts["role"].'<div class="assignedto">'.$assignedto.'</div></div>';
			}
		return $output;
		}

	if(isset($_GET["print_agenda"]) || isset($_GET["email_agenda"]) || is_email_context())
		{
		$agenda_time = get_option('agenda_time');
		$output = '';
		$maxtime = (isset($atts["time_allowed"]) ) ? (int) $atts["time_allowed"] : 0;
		$padding_time = (isset($atts["padding_time"])) ? (int) $atts["padding_time"] : 0;
		$speaktime = 0;
		if(isset($atts["time"]))
			$time = explode(',',$atts["time"]);
		for($i = 1; $i <= $count; $i++)
			{
			$field = '_' . $field_base . '_' . $i;
			$assigned = get_post_meta($post->ID, $field, true);
			if(isset($atts["indent"]) && $atts["indent"])
				$output  .= "\n".'<div class="role-agenda-item" style="margin-left: 15px;">';
			else
				$output  .= "\n".'<div class="role-agenda-item">';
			$output .= '<p>';
			// old style of time display
			if(isset($time) && is_array($time) && $time[$i - 1])
				$output .= '<em>'.$time[$i - 1].'</em> ';

			if(!empty($atts["time_allowed"]) && strpos($field,'Speaker'))
				{
					$speaktime += (int) get_post_meta($post->ID,'_maxtime'.$field,true);
				}
			$output .= '<strong>'.$atts["role"].': </strong>';
			if($assigned == '-1')
				{
				$output .= __('Not Available','rsvpmaker-for-toastmasters');
				}
			elseif($assigned)
				{
					$title = get_post_meta($post->ID, '_title'.$field, true);
					if(!empty($title))
						$title = ": ".$title;
					if(is_numeric($assigned))
						{
						$member = get_userdata( $assigned );
						$name = $member->first_name.' '.$member->last_name;
						if(!empty($member->education_awards)) $name .= ', '.$member->education_awards;
						}
					else
						$name = $assigned.' ('.__('guest','rsvpmaker-for-toastmasters').')';
					$output .= sprintf('<span class="member-role">%s%s</span>', $name, $title);
				}
			else
				{
				if(isset($open[$atts["role"]]))
					$open[$atts["role"]]++;
				else
					$open[$atts["role"]] = 1;				
				}
			if(isset($atts["agenda_note"]) && !empty($atts["agenda_note"]) )
				$output .=  "<br /><em>".$atts["agenda_note"]."</em>";
			$output .= '</p>';

			if($assigned && (strpos($field,'Speaker') == 1) )
				{
				$output .= speaker_details_agenda($field);
				}
			$output .= '</div>';
			}
		if($agenda_time)
			{
			if($speaktime > $maxtime)
				$maxtime = $speaktime;
			$start_end = '';
			if($maxtime)
				$start_end = tm_calc_time($maxtime);
			$output = '<div class="timewrap"><div class="timeblock">'.$start_end.'</div><div class="timed_content">'.$output.'</div></div>';
			if($padding_time)
				tm_calc_time($padding_time);
			}
		return $output;
		}

	global $random_available;
	global $last_attended;
	global $last_filled;

	for($i = 1; $i <= $count; $i++)
		{
		
		$field = '_' . $field_base . '_' . $i;
		$assigned = get_post_meta($post->ID, $field, true);
		if(is_numeric($assigned) && ($assigned > 0))
			$tmroles[$field] = $assigned;
		$output .= '<div class="role-block" id="'.$field.'"><div class="role-title" style="font-weight: bold;">';
		$output .= $atts["role"].': </div><div class="role-data"> ';
		if(is_club_member() && !(isset($_GET["edit_roles"]) || isset($_GET["recommend_roles"]) || (isset($_GET["page"]) && ($_GET["page"] == 'toastmasters_reconcile') ) )  ) 
			$output .= sprintf(' <form id="%s_form" method="post" class="toastrole" action="%s" style="display: inline;"><input type="hidden" name="role" id="role" value="%s"><input type="hidden" name="post_id" id="post_id" value="%d">',$field,$permalink, $field, $post->ID);
				
		if($assigned == '-1')
				{
				$output .= __('Not Available','rsvpmaker-for-toastmasters');
				}
		elseif($assigned  && !(isset($_GET["edit_roles"]) || (isset($_GET["page"]) && ($_GET["page"] == 'toastmasters_reconcile') ) ) )
			{
			if(is_numeric($assigned))
				{
				$member = get_userdata( $assigned );
				if(!$member)
					return;
				$name = $member->first_name.' '.$member->last_name;
				if(!empty($member->education_awards)) $name .= ', '.$member->education_awards;
				$output .= sprintf('<div class="member-role">%s</div>',$name);	
				}
			else
				$output .= sprintf('<div class="member-role">%s (%s)</div>',$assigned,__('guest','rsvpmaker-for-toastmasters'));
			}
		
			if(is_club_member() )
			{
			if( strpos($field,'Speaker') && ($assigned != '-1' ) )
				{
				$detailsform = speaker_details($field, $assigned, $atts);
				}
			else
				$detailsform = '';

			if(isset($_GET["edit_roles"]) || (isset($_GET["page"]) && ($_GET["page"] == 'toastmasters_reconcile') ) ) // && current_user_can('edit_posts') )
				{
					if(	(empty($assigned) || ($assigned == 0)) && is_array($random_available) && !empty($random_available) )
						{
						$role = preg_replace('/[0-9]/','',$field);// remove number
						$assigned = pick_random_member($role);
						$output .= '<em><span style="color:red;">'.__('Random assignment (unconfirmed)','rsvpmaker-for-toastmasters').'</span><br />'.__('Last attended','rsvpmaker-for-toastmasters').': '.$last_attended[$assigned].' '.__('Last filled role','rsvpmaker-for-toastmasters').': '.$last_filled[$role][$assigned].'</em><br />';
						}
					// editor admin options
					$awe_user_dropdown = awe_user_dropdown($field, $assigned);
					$output .= 'Member: '.$awe_user_dropdown;
					$guest = (is_numeric($assigned)) ? '' : $assigned;
					$output .= '<br />Or guest: <input type="text" name="edit_guest['.$field.']" value="'.$guest.'" />';
					if(strpos($field,'Speaker') )
						$output .= $detailsform;
				$output .= '<div class="ajax_status" id="status'.$field.'"></div>';
				}
			elseif(isset($_GET["recommend_roles"])) // && current_user_can('edit_posts') )
				{
					// editor admin options
					if(!$assigned)
					{
					$random_assigned = NULL;
					if(	is_array($random_available) && !empty($random_available) )
						{
						$role = preg_replace('/[0-9]/','',$field);// remove number
						$assigned = pick_random_member($role);
						$output .= '<em><span style="color:red;">'.__('Random assignment (unconfirmed)','rsvpmaker-for-toastmasters').'</span><br />'.__('Last attended','rsvpmaker-for-toastmasters').': '.$last_attended[$assigned].' '.__('Last filled role','rsvpmaker-for-toastmasters').': '.$last_filled[$role][$assigned].'</em><br />';
						}
					$awe_user_dropdown = awe_assign_dropdown($field, $assigned);
					$output .= $awe_user_dropdown;
					$output .= sprintf('<p>%s:<br /><textarea rows="3" cols="40" name="editor_suggest_note[%s]"></textarea></p><input type="hidden" name="editor_suggest_count[%s]" value="%s" />',__('Add a personal note (optional)','rsvpmaker-for-toastmasters'),$field, $field, $count);
					}
				}
			elseif(!$assigned)
				{
				if(strpos($field,'Speaker') )
					$output .= sprintf('<div class="update_form" id="update'.$field.'">%s</div>',$detailsform);
				$output .= '<button name="take_role" id="take_role" value="1">Take Role</button>';
				}

			elseif($assigned == $current_user->ID)
					{
				if(strpos($field,'Speaker') )
					$output .= sprintf('<div class="update_form" id="update'.$field.'">%s
					<button name="update_role" value="1">'.__('Update Role','rsvpmaker-for-toastmasters').'</button>
					<br />
					<em>or</em>
					</div><div></div>',$detailsform);
					$output .= '<button name="delete_role" id="delete_role" value="1">'.__('Remove Me','rsvpmaker-for-toastmasters').'</button>';
					}
			elseif(strpos($field,'Speaker') && ($assigned != '-1' ) )
				{
				$output .= '<div class="update_form" id="update'.$field.'">'.speech_public_details($field).'</div>';
				}

			if(is_single() && strpos($field,'Speaker') && !strpos($field,'Backup') )
				{
				$output .= '<div class="time_message"></div> ';
				}
			}
		if(is_club_member() && !(isset($_GET["edit_roles"]) || isset($_GET["recommend_roles"]) || (isset($_GET["page"]) && ($_GET["page"] == 'toastmasters_reconcile') ) )  ) 
				$output .= '</form>';

		if(isset($atts["agenda_note"]) && !empty($atts["agenda_note"]) )
			$output .=  "<br /><em>".$atts["agenda_note"]."</em>";

			$output .= '</div></div><!-- end role block -->';			
			}
		if(strpos($field,'Speaker') )
			{
			$time_limit = (isset($atts["time_allowed"])) ? (int) $atts["time_allowed"] : 0;
			$output .= '<input type="hidden" class="time_limit" value="'.$time_limit.'" />';
			}

	return $output;
}

function tm_calc_time($minutes)
	{
		if(strpos($minutes,':'))
			{
				$parts = explode(':',$minutes);
				$minutes = $parts[0];
				$seconds = $parts[1];
			}
		elseif(strpos($minutes,'.'))
			{
				$parts = explode('.',$minutes);
				$minutes = $parts[0];
				$seconds = round(($parts[1] / 10) * 60);
			}
		else
			{
				$seconds = 0;
			}
		global $rsvp_options;
		global $post;
		global $time_count;
		global $end_time;
		global $wpdb;
		if(empty($time_count))
			{
				$datetime = get_rsvp_date($post->ID);
				$time_count = strtotime($datetime);
				//todo also end time
			}
		$start_time = strftime(str_replace('%Z','',$rsvp_options["time_format"]),$time_count);
		
		$time_count = mktime( date("H",$time_count), date("i",$time_count) + $minutes, date("s",$time_count) + $seconds );
		if(isset($_GET["end"]))
			$start_time .= '-'.strftime($rsvp_options["time_format"],$time_count);
		return $start_time;
	}

add_shortcode( 'toastmaster', 'toastmaster_short' );
add_shortcode( 'agenda_note', 'agenda_note' );

function toastmaster_officers ($atts) {
if(!isset($_GET["print_agenda"]) && !isset($_GET["email_agenda"]))
	return;
$label = isset($atts["label"]) ? $atts["label"] : __('Officers','rsvpmaker-for-toastmasters');
$sep = isset($atts["sep"]) ? html_entity_decode($atts["sep"]) : ' ';
if($sep == 'br')
	$sep = '<br />';

$wp4toastmasters_officer_ids = get_option('wp4toastmasters_officer_ids');
$wp4toastmasters_officer_titles = get_option('wp4toastmasters_officer_titles');

$buffer = "\n<div class=\"officers\"><strong>".$label."</strong>"; //.$label.": ";
if(is_array($wp4toastmasters_officer_ids))
{
foreach ($wp4toastmasters_officer_ids as $index => $officer_id)
	{
		if(!$officer_id)
			continue;
		$officer = get_userdata($officer_id);
		$title = str_replace(' ','&nbsp;',$wp4toastmasters_officer_titles[$index]);
		$buffer .= sprintf('%s<em>%s</em>&nbsp;%s&nbsp;%s',$sep,$title,$officer->first_name,$officer->last_name);
	}
}
else
	$buffer .= '<p>'.__('Officers list not yet set','rsvpmaker-for-toastmasters').'</p>';
$buffer .= "</div>\n";
return $buffer;
}

add_shortcode( 'toastmaster_officers', 'toastmaster_officers' );

function awe_user_dropdown ($role, $assigned, $settings = false, $openlabel = 'Open') {
global $wpdb;
global $sortmember;
global $fnamesort;

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

	foreach($fnamesort as $member)
		{
			if($member->ID == $assigned)
				$s = ' selected="selected" ';
			else
				$s = '';
			$options .= sprintf('<option %s value="%d">%s (%s)</option>',$s, $member->ID,$member->first_name.' '.$member->last_name, $member->user_login);
		}

	$options .= "</optgroup>";

	$options .= '<optgroup label="Last Name Sort">';
	foreach($sortmember as $member)
		{
			if($member->ID == $assigned)
				$s = ' selected="selected" ';
			else
				$s = '';
			$options .= sprintf('<option %s value="%d">%s (%s)</option>',$s, $member->ID,$member->first_name.' '.$member->last_name, $member->user_login);
		}
	$options .= "</optgroup>";

if($settings)
	return '<select name="'.$role.'">'.$options.'</select>';
else
	return '<select name="editor_assign['.$role.']" id="editor_assign'.$role.'" class="editor_assign">'.$options.'</select>';
}

function wp4t_get_member_status($member_id) {
fix_timezone();
$exp = (int) get_user_meta($member_id,'status_expires',true);
if(current_time('timestamp') > $exp)
	{
	delete_user_meta($member_id,'status');
	delete_user_meta($member_id,'status_expires');
	return;
	}
return get_user_meta($member_id,'status',true).' ('.__('expires','rsvpmaker-for-toastmasters').': '.date('r',$exp).')';
}

function wp4t_set_member_status($member_id,$status,$status_expires) {
if(empty($status) || empty($status_expires))
	return;
fix_timezone();
update_user_meta($member_id,'status_expires',strtotime($status_expires));
update_user_meta($member_id,'status',stripslashes($status));
}

function wp4t_set_status_form() {
$hook = tm_admin_page_top('Set Away Status');
printf('<p>%s</p>',__('Set a temporary message for the members page letting people know when you are on vacation or unavailable to attend.','rsvpmaker-for-toastmasters'));

if(isset($_POST["month"][0]) && is_club_member() )
	{
		$exp = $_POST["year"][0].'-'.$_POST["month"][0].'-'.$_POST["day"][0].' '.$_POST["hour"][0].':00:00';
		$member_id = (int) $_POST["member_id"];
		wp4t_set_member_status($member_id,$_POST["status"],$exp);
	}
if(isset($_POST["remove_status"]))
	{
		$id = (int) $_POST["member_id"];
		$result = delete_user_meta($id,'status');
		$result = delete_user_meta($id,'status_expires');
	}

if(isset($_GET["member_id"]))
	$selected = (int) $_GET["member_id"];
else
	{
	global $current_user;
	$selected = $current_user->ID;
	echo '<p>My status: '.wp4t_get_member_status($current_user->ID).'</p>';
	}

$dropdown = awe_user_dropdown ('member_id',$selected,true);
$t = strtotime('today +2 week');
$month =  (int) date('m',$t);
$year =  (int) date('Y',$t);
$day =  (int) date('d',$t);
$hour =  (int) date('G',$t);
$minutes =  (int) date('i',$t);

			printf('<p> 
			<form action="'.admin_url('profile.php?page=wp4t_set_status_form').'" method="post">%s<br /><strong>Status</strong><br /><textarea name="status" cols="60" rows="1"></textarea>
',$dropdown);	
?>
<br /><strong><?php echo __('Expires','rsvpmaker');?></strong>
<div class="date_block"><?php echo __('Month:','rsvpmaker');?> 
<select id="month<?php echo $index;?>" name="<?php echo $prefix; ?>month[<?php echo $index;?>]"> 
<?php
for($i = 1; $i <= 12; $i++)
{
echo "<option ";
	if($i == $month)
		echo ' selected="selected" ';
	echo 'value="'.$i.'">'.$i."</option>\n";
}
?>
</select> 
<?php echo __('Day:','rsvpmaker');?> 
<select  id="day<?php echo $index;?>"  name="<?php echo $prefix; ?>day[<?php echo $index;?>]"> 
<?php
if($day == 0)
	echo '<option value="0">Not Set</option>';
for($i = 1; $i <= 31; $i++)
{
echo "<option ";
	if($i == $day)
		echo ' selected="selected" ';
	echo 'value="'.$i.'">'.$i."</option>\n";
}
?>
</select> 
<?php echo __('Year','rsvpmaker');?>
<select  id="year<?php echo $index;?>" name="<?php echo $prefix; ?>year[<?php echo $index ;?>]"> 
<?php
$y = (int) date('Y');
$limit = $y + 3;
for($i = $y; $i < $limit; $i++)
{
echo "<option ";
	if($i == $year)
		echo ' selected="selected" ';
	echo 'value="'.$i.'">'.$i."</option>\n";
}
?>
</select> 
<input type="hidden" id="datepicker<?php echo $index;?>" value="<?php echo $jquery_date;?>">
<?php echo __('Hour:','rsvpmaker');?> <select name="<?php echo $prefix; ?>hour[<?php echo $index;?>]"> 
<?php
for($i=0; $i < 24; $i++)
	{
	$selected = ($i == $hour) ? ' selected="selected" ' : '';
	$padded = ($i < 10) ? '0'.$i : $i;
	if($i == 0)
		$twelvehour = "12 a.m.";
	elseif($i == 12)
		$twelvehour = "12 p.m.";
	elseif($i > 12)
		$twelvehour = ($i - 12) ." p.m.";
	else		
		$twelvehour = $i." a.m.";

	printf('<option  value="%s" %s>%s / %s:</option>',$padded,$selected,$twelvehour,$padded);
	}
?>
</select> 
</div> 

<input type="submit" name="submit" value="<?php _e('Submit','rsvpmaker-for-toastmasters');?>" /></form></p>
<?php
printf('<form action="'.admin_url('profile.php?page=wp4t_set_status_form').'" method="post">%s<input type="submit" name="remove_status" value="'.__('Clear Status','rsvpmaker-for-toastmasters').'" /></form>',$dropdown);			

tm_admin_page_bottom($hook);
}

function awe_assign_dropdown ($role, $random_assigned) {
global $wpdb;
global $haverole;
global $post;
global $last_filled;
$assigned = 0;

global $haverole;

if(!is_array($haverole) )
	{
	$custom_fields = get_post_custom($post->ID);
	foreach ($custom_fields as $name => $arr)
	{
		if( preg_match('/^_[A-Z].+_[0-9]/',$name) )
		{
			//echo $name.": ".$arr[0]."<br />";
			$haverole[] = $arr[0];
		}
	}
	}

$options = '<option value="0">Open</option>';

$blogusers = get_users('blog_id='.get_current_blog_id() );
    foreach ($blogusers as $user) {		

	if(is_array($haverole) && in_array($user->ID, $haverole) )
		continue;
	
		$member = get_userdata($user->ID);
		if($member->hidden_profile)
			continue;
			
			if($member->first_name && $member->last_name)
				$member->display_name = $member->first_name.' '.$member->last_name;
			$status = wp4t_get_member_status($member->ID);
			if(!empty($status) )
				$member->display_name .= ' ['.$status.']';
			else
				{
				$role = preg_replace('/[0-9]/','',$role);// remove number
				$last_filled_text = $last_filled[$role][$user->ID] = (isset($last_filled[$role][$user->ID])) ? $last_filled[$role][$user->ID] : last_filled_role($member->ID, $role);
				$member->display_name .= ' (Last filled role: '.$last_filled_text.')';
				}
			
		$index = preg_replace('/[^a-zA-Z]/','',$member->last_name.$member->first_name.$member->user_login);
		$findex = preg_replace('/[^a-zA-Z]/','',$member->first_name.$member->last_name.$member->user_login);
		$sortmember[$index] = $member;
		$fnamesort[$findex] = $member;
	}	
	
	$member = new stdClass();
	$member->ID = -1;
	$member->last_name = "Available";
	$member->first_name = "Not";
	$member->display_name = "Not Available";
	
	$fnamesort["AAA"] = $sortmember["AAA"] = $member;
	
	ksort($sortmember);
	ksort($fnamesort);

	$options .= '<optgroup label="'.__('Sort by First Name','rsvpmaker-for-toastmasters').'">';

	foreach($fnamesort as $member)
		{
			if($member->ID == $random_assigned)
				$s = ' selected="selected" ';
			else
				$s = '';
			$options .= sprintf('<option %s value="%d">%s</option>',$s, $member->ID,$member->display_name);
		}

	$options .= "</optgroup>";

	$options .= '<optgroup label="'.__('Sort by Last Name','rsvpmaker-for-toastmasters').'">';
	foreach($sortmember as $member)
		{

			if($member->ID == $assigned)
				$s = ' selected="selected" ';
			else
				$s = '';
			$options .= sprintf('<option %s value="%d">%s</option>',$s, $member->ID,$member->display_name);
		}
	$options .= "</optgroup>";

if(isset($settings))
	return '<select name="'.$role.'">'.$options.'</select>';
else
	return '<select name="editor_suggest['.$role.']">'.$options.'</select>';
}

function clean_role($role) {
$role = str_replace('_1','',$role);
$role = str_replace('_',' ',$role);
return trim($role);
}

function awesome_wall($comment_content, $post_id) {

global $current_user;
global $wpdb;
$comment_content = "<strong>".$current_user->display_name.':</strong> '.$comment_content;
$stamp = '<small><em>(Posted: '.date('m/d/y H:i').')</em></small>';
$date = get_rsvp_date($post_id);
$ts = strtotime($date);
$comment_content .= ' for '.date('F jS',$ts). ' '.$stamp;

add_post_meta($post_id, '_activity', $comment_content, false);

$signup = get_post_custom($post_id);

$meeting_leader = get_post_meta($post_id, 'meeting_leader', true);
if(empty($meeting_leader))
	$meeting_leader = "_Toastmaster_of_the_Day_1";
if(isset($signup[$meeting_leader][0]))
	$toastmaster = $signup[$meeting_leader][0];
else
	$toastmaster = 0; // no meeting leader active

if($toastmaster && is_numeric($toastmaster))
	{
	$userdata = get_userdata($toastmaster);
	$toastmaster_email = $userdata->user_email;
	$subject = $message = $comment_content;
	$url = rsvpmaker_permalink_query($post_id);
	$message .= "\n\nThis is an automated message. Replies will be sent to ".$current_user->user_email;
	$mail["subject"] = substr(strip_tags($subject),0, 100);
	$mail["replyto"] = $current_user->user_email;
	$mail["html"] = "<html>\n<body>\n".wpautop($message)."\n</body></html>";
	$mail["to"] = $toastmaster_email;
	$mail["from"] = $current_user->user_email;
	$mail["fromname"] = $current_user->display_name;
	awemailer($mail);
	}
}

function role_post() {

if(!is_club_member() || empty($_POST["post_id"]))
	return;

global $current_user;
global $wpdb;
$post_id = (int) $_POST["post_id"];
$timestamp = get_rsvp_date($post_id);
$is_past = (time() > strtotime($timestamp));

if(isset($_POST["take_role"]) || isset($_POST["update_speaker_details"]))
	{
		$role = $_POST["role"];
		update_post_meta($post_id,$role,$current_user->ID);
		$actiontext = __("signed up for",'rsvpmaker-for-toastmasters').' '.clean_role($role);
		do_action('toastmasters_agenda_notification',$post_id,$actiontext,$current_user->ID);
		awesome_wall($actiontext,$post_id);
		if(strpos($role,'peaker') )
			{
			// clean any previous speech data
			//echo '_manual'.$role;
			delete_post_meta($post_id,'_manual'.$role);
			delete_post_meta($post_id,'_title'.$role);
			delete_post_meta($post_id,'_project'.$role);
			delete_post_meta($post_id,'_maxtime'.$role);
			delete_post_meta($post_id,'_intro'.$role);
			}
	}

if(isset($_POST["agenda_note"]))
	{
	foreach($_POST["agenda_note"] as $index => $note)
		{
			$note = stripslashes($note);
			if( empty($_POST["agenda_note_label"][$index]) )
				continue;
			update_post_meta($post_id,$_POST["agenda_note_label"][$index],$note);
		}
	}

if(isset($_POST["editor_assign"]) )
	{
		foreach($_POST["editor_assign"] as $role => $user_id)
		{
			$was = get_post_meta($post_id,$role,true);
			if($was != $user_id)
				{
				update_post_meta($post_id,$role,$user_id);

				$actiontext = __("signed up for",'rsvpmaker-for-toastmasters').' '.clean_role($role);
				if($user_id > 0)
				do_action('toastmasters_agenda_notification',$post_id,$actiontext,$user_id);

				if(strpos($role,'peaker') )
					editor_signup_notification($post_id, $user_id,$role,$_POST["_manual"][$role],$_POST["_project"][$role],$_POST["_title"][$role]);
				else
					editor_signup_notification($post_id, $user_id,$role);				
				}
		if(strpos($role,'peaker') && ($user_id == '0') )
			{
			// clean any previous speech data
			delete_post_meta($post_id,'_manual'.$role);
			delete_post_meta($post_id,'_title'.$role);
			delete_post_meta($post_id,'_project'.$role);
			delete_post_meta($post_id,'_maxtime'.$role);
			delete_post_meta($post_id,'_intro'.$role);
			}
		}

		if(isset($_POST["edit_guest"]))
		foreach($_POST["edit_guest"] as $role => $guest)
		{
			if(!empty($guest))
				update_post_meta($post_id,$role,$guest);			
		}
		
	awesome_wall("edited role signups ",$post_id);

	}

if(isset($_POST["_manual"]))
	{		
		foreach($_POST["_manual"] as $basefield => $manual)
			{
			
			if(isset($_POST["editor_assign"]))
				$user_id = $_POST["editor_assign"][$basefield];
			else
				$user_id = $current_user->ID;			
			
			$title = $_POST["_title"][$basefield];
			$project = $_POST["_project"][$basefield];
			$intro = (isset($_POST["_intro"][$basefield])) ? $_POST["_intro"][$basefield] : '';
			$time = (int) (isset($_POST["_maxtime"][$basefield])) ? $_POST["_maxtime"][$basefield] : 0;	
			if($time == 0)
				$time = 7;
			if($user_id < 1) // unassigned or not available
				$time = 0;
			if(!empty($intro))
				{
				$wasintro = get_post_meta($post_id,'_intro'.$basefield,true);
				$intro = stripslashes($intro);
				if($intro != $wasintro)
					do_action('toastmasters_agenda_notification',$post_id,__('Speaker Introduction: ','rsvpmaker-for-toastmasters')."\n\n".$intro,$user_id,$basefield,'intro');
				}
			update_user_meta($user_id,'current_manual',$manual);
			update_post_meta($post_id,'_manual'.$basefield,$manual);
			update_post_meta($post_id,'_title'.$basefield,$title);
			update_post_meta($post_id,'_project'.$basefield,$project);
			if(isset($_POST["_maxtime"][$basefield]))
				update_post_meta($post_id,'_maxtime'.$basefield,$time);
			if(isset($_POST["_intro"][$basefield]))
				update_post_meta($post_id,'_intro'.$basefield,$intro);
			}
	}

if(isset($_POST["delete_role"]))
	{
		$role = $_POST["role"];
		delete_post_meta($post_id,$role);
		if(strpos($role,'peaker') )
			{
			delete_post_meta($post_id,'_manual'.$role);
			delete_post_meta($post_id,'_title'.$role);
			delete_post_meta($post_id,'_intro'.$role);
			}
		$actiontext = __("withdrawn: ",'rsvpmaker-for-toastmasters').' '.clean_role($role);
		do_action('toastmasters_agenda_notification',$post_id,$actiontext,$current_user->ID);
		awesome_wall("withdrawn: ".clean_role($role),$post_id);
	}

if(isset($_POST["delete_speaker"]))
	{
		foreach($_POST["delete_speaker"] as $field)
			{
			delete_post_meta($post_id,$field);
			delete_post_meta($post_id,'_manual'.$field);
			delete_post_meta($post_id,'_title'.$field);
			delete_post_meta($post_id,'_intro'.$field);
			if($is_past)
				{
				$key = make_tm_usermeta_key ($field, $timestamp, $post_id);
				$sql = $wpdb->prepare("DELETE FROM $wpdb->usermeta WHERE meta_key=%s",$key);
				$wpdb->query($sql);
				}
			}
		awesome_wall("Deleted a speaker",$post_id);
	}

//Make sure visitors see current data / Purge a single post / page by passing it's ID:
if (function_exists('w3tc_pgcache_flush_post')) {
w3tc_pgcache_flush_post($post_id);
}

if($is_past)
	{
	update_user_role_archive($post_id,$timestamp);
	}
}

function editor_signup_notification($post_id, $user_id,$role,$manual = '',$project = '',$title = '') {
if(is_admin())
	return; // don't do this on the reconcile screen
	
$role = clean_role($role);
global $current_user;
global $wpdb;
global $rsvp_options;
$datetime = get_rsvp_date($post_id);
$meetingdate = strftime($rsvp_options["short_date"],strtotime($datetime));
	if(!is_numeric($user_id))
		return;
	$speakerdata = get_userdata($user_id);
	if(!isset($speakerdata->user_email))
		return;
	if($project)
		$project = get_project_text($project);
	
	$subject = $message = sprintf(__('Your role: %s for %s %s','rsvpmaker-for-toastmasters'),clean_role($role),$meetingdate, get_bloginfo('name') );

		$message .= "\n\n";
if(strpos($role,'peaker'))
	{
	$message .= sprintf('Manual: %s
Project: %s
Title: %s',$manual,$project,$title);
	if(!$project)
		{
		$message .= "\n\n".__('Please sign into the website to add speech project details, particularly if the speech project will require more than the default 7 minutes on the agenda.','rsvpmaker-for-toastmasters');
		$subject .= ' ('.__('Please add project/timing','rsvpmaker-for-toastmasters').')';		
		}
	}
		$message .= "\n\n".__('If this information is not correct, or if you cannot attend on this date, please let us know as soon as possible.','rsvpmaker-for-toastmasters');

		$meeting_leader = get_post_meta($post_id, 'meeting_leader', true);
		if(empty($meeting_leader))
			$meeting_leader = "_Toastmaster_of_the_Day_1";
		$toastmaster = (int) get_post_meta($post_id, $meeting_leader, true);
	
		if($toastmaster && ($user_id != $toastmaster))
			{
			$tmdata = get_userdata($toastmaster);
			$leader_email = $tmdata->user_email;
			}
		else
			$leader_email = get_option( 'admin_email' );

		$p = get_permalink($post_id);
		$footer = "\n\nTo update this information, visit ".sprintf('<a href="%s">%s</a>',$p,$p);
		
		$mail["subject"] = $subject;
		$mail["html"] = "<html>\n<body>\n".wpautop($message.$footer)."\n</body></html>";
		$mail["replyto"] = $leader_email;
		$mail["to"] = $speakerdata->user_email;
		$mail["from"] = $current_user->user_email;
		$mail["fromname"] = $current_user->display_name;
		awemailer($mail); // notify member
}


function speaker_details_agenda ($field) {
	global $post;
	$manual = get_post_meta($post->ID, '_manual'.$field, true);
	$project_index = get_post_meta($post->ID, '_project'.$field, true);
	if(!empty($project_index))
		{
		$project = get_project_text($project_index);
		$manual .= ': '.$project;
		}
	$output = ($manual && !strpos($manual,'Manual /') ) ? '<div id="manual"><strong>'.$manual."</strong></div>" : "\n";
	$output = "\n".'<div class="speaker-details">'.$output.'</div>'."\n";
	return $output;
}

function speaker_details ($field, $assigned = 0, $atts) {
global $post;
global $current_user;
$output = "";
		$manual = get_post_meta($post->ID, '_manual'.$field, true);
		if(empty($manual) || strpos($manual,'hoose Manual'))
			{
			if(isset($_GET["edit_roles"]) || isset($_GET["recommend_roles"]) || is_admin() )
				$current_manual = '';
			else
				$current_manual = get_user_meta($current_user->ID,'current_manual',true);
			if(empty($current_manual))
			{
				$manual = "Select Manual/Path";
				$time = 0;
				$project_options = '<option value="">'.__('Select Manual/Path to See Options','rsvpmaker-for-toastmasters').'</option>';
			}
			else
			{
			$project_options_array = get_projects_array('options');
			$manual = $current_manual;
			$time = 0;
			if(isset($project_options_array[$manual]))
				$project_options = '<option value="">'.__('Select Project','rsvpmaker-for-toastmasters').'</option>'.$project_options_array[$manual];
			else
				$project_options = '<option value="">'.__('Select Manual/Path to See Options','rsvpmaker-for-toastmasters').'</option>';
			}
			
			//$output .= sprintf('<div>Empty, setting manual to %s</div>',$manual);
			}
		elseif(strpos($manual,':'))
			{
				$parts = explode(':',$manual);
				$manual = trim($parts[0]);
				if(strpos($manual,'(CC) MANUAL'))
					$manual = "COMPETENT COMMUNICATION";
				$project_text = trim($parts[1]);
				$project_key = get_project_key($project_text);
				$time = 7;
			}
		else
			{
			$project_key = get_post_meta($post->ID, '_project'.$field, true);
			$project_text = get_project_text($project_key);
			$time = get_post_meta($post->ID, '_maxtime'.$field, true);
			}
		if( empty($project_key))
			{
				$project_text = 'Choose Project';
				$project_key = '';
			}
		if(empty($project_options))
		{
		$project_options = sprintf('<option value="%s">%s</option>',$project_key,$project_text);		
		$pa = get_projects_array('options');
		$project_options .= isset($pa[$manual]) ? $pa[$manual] : $pa["COMPETENT COMMUNICATION"];
		}
		
		if(strpos($field,'Backup'))
			$maxclass = '';
		else
			$maxclass = 'maxtime';
		
		$output .= '<div>
		<input type="hidden" name="post_id" value="'.$post->ID.'" />
		<select class="speaker_details manual" name="_manual['.$field.']" id="_manual_'.$field.'"">'.get_manuals_options($manual).'</select><br /><select class="speaker_details project" name="_project['.$field.']" id="_project_'.$field.'">'.$project_options.'</select>';
		$output .= '</div>';
		$title = get_post_meta($post->ID, '_title'.$field, true);
		$output .= '<div class="speech_title">Title: <input type="text" class="speaker_details title_text" id="title_text'.$field.'" name="_title['.$field.']" value="'.$title.'" /></div>';
		
		$output .= '<div class="time_required">Time Required: <input type="text"class="speaker_details '.$maxclass.'" name="_maxtime['.$field.']" id="_maxtime_'.$field.'" size="4" value="'.$time.'"></div>';

		$intro = get_post_meta($post->ID, '_intro'.$field, true);

		$output .= '<div class="speaker_introduction">Introduction: <br /><textarea class="intro_'.$field.'" name="_intro['.$field.']" id="_intro_'.$field.'" style="width: 100%; height: 4em;">'.$intro.'</textarea></div>';
		
return $output;
}

function speaker_details_admin ($user_id, $key, $manual, $project_key, $title, $intro) {
global $post;
global $current_user;
$output = "";
		if(empty($manual) || strpos($manual,'hoose Manual'))
			{
				$manual = "Select Manual/Path";
				$project_options = '<option value="">'.__('Select Manual/Path to See Options','rsvpmaker-for-toastmasters').'</option>';
			}
		else
			{
			$project_text = get_project_text($project_key);
			}
		if( empty($project_key))
			{
				$project_text = 'Choose Project';
			}
		if(empty($project_options))
		{
		$project_options = sprintf('<option value="%s">%s</option>',$project_key,$project_text);		
		$pa = get_projects_array('options');
		$project_options .= isset($pa[$manual]) ? $pa[$manual] : $pa["COMPETENT COMMUNICATION"];
		}
		$field = preg_replace('/[^a-zA-Z0-9]/','',$key);
		
		$output .= '<div>
		<select class="speaker_details manual" name="manual" id="_manual_'.$field.'"">'.get_manuals_options($manual).'</select><br /><select class="speaker_details project" name="project" id="_project_'.$field.'">'.$project_options.'</select>';
		$output .= '</div>';
		$output .= '<div class="speech_title">Title: <input type="text" class="speaker_details title_text" id="title_text'.$field.'" name="title" value="'.$title.'" /></div>';
		$output .= '<div class="speaker_introduction">Introduction: <br /><textarea class="intro" name="intro" id="_intro_'.$field.'" style="width: 100%; height: 4em;">'.$intro.'</textarea></div>';
		if(strpos($key,'|0'))
		{
		preg_match('/\d{4}-\d{2}-\d{2}/',$key,$match);
		$output .= '<div><input type="text" id="date'.$field.'" name="date" value="'.$match[0].'" > (added on dashboard)</div>';	
		}
return $output;
}

//obsolete
function get_toast_speech_options() {

return '<option value="Choose Manual / Speech">Choose Manual / Speech</option>
<option value="COMPETENT COMMUNICATION (CC) MANUAL: The Ice Breaker (4 to 6 min)">COMPETENT COMMUNICATION (CC) MANUAL: The Ice Breaker (4 to 6 min)
</option><option value="COMPETENT COMMUNICATION (CC) MANUAL: Organize Your Speech (5 to 7 min)">COMPETENT COMMUNICATION (CC) MANUAL: Organize Your Speech (5 to 7 min)
</option><option value="COMPETENT COMMUNICATION (CC) MANUAL: Get to the Point (5 to 7 min)">COMPETENT COMMUNICATION (CC) MANUAL: Get to the Point (5 to 7 min)
</option><option value="COMPETENT COMMUNICATION (CC) MANUAL: How to Say It (5 to 7 min)">COMPETENT COMMUNICATION (CC) MANUAL: How to Say It (5 to 7 min)
</option><option value="COMPETENT COMMUNICATION (CC) MANUAL: Your Body Speaks (5 to 7 min)">COMPETENT COMMUNICATION (CC) MANUAL: Your Body Speaks (5 to 7 min)
</option><option value="COMPETENT COMMUNICATION (CC) MANUAL: Vocal Variety (5 to 7 min)">COMPETENT COMMUNICATION (CC) MANUAL: Vocal Variety (5 to 7 min)
</option><option value="COMPETENT COMMUNICATION (CC) MANUAL: Research Your Topic (5 to 7 min)">COMPETENT COMMUNICATION (CC) MANUAL: Research Your Topic (5 to 7 min)
</option><option value="COMPETENT COMMUNICATION (CC) MANUAL: Get Comfortable with Visual Aids (5 to 7 min)">COMPETENT COMMUNICATION (CC) MANUAL: Get Comfortable with Visual Aids (5 to 7 min)
</option><option value="COMPETENT COMMUNICATION (CC) MANUAL: Persuade with Power (5 to 7 min)">COMPETENT COMMUNICATION (CC) MANUAL: Persuade with Power (5 to 7 min)
</option><option value="COMPETENT COMMUNICATION (CC) MANUAL: Inspire Your Audience (8 to 10 min)">COMPETENT COMMUNICATION (CC) MANUAL: Inspire Your Audience (8 to 10 min)
</option><option value="COMMUNICATING ON VIDEO: Straight Talk (3 min)">COMMUNICATING ON VIDEO: Straight Talk (3 min)
</option><option value="COMMUNICATING ON VIDEO: The Talk Show (10 min)">COMMUNICATING ON VIDEO: The Talk Show (10 min)
</option><option value="COMMUNICATING ON VIDEO: When You&#39;re the Host (10 min)">COMMUNICATING ON VIDEO: When You Are the Host (10 min)
</option><option value="COMMUNICATING ON VIDEO: The Press Conference (4 to 6 min presentation; 8 to 10 min with Q&amp;A)">COMMUNICATING ON VIDEO: The Press Conference (4 to 6 min presentation; 8 to 10 min with Q&amp;A)
</option><option value="COMMUNICATING ON VIDEO: Training On video (5 to 7 min; 5 to 7 min video tape playback)">COMMUNICATING ON VIDEO: Training On video (5 to 7 min; 5 to 7 min video tape playback)
</option><option value="FACILITATING DISCUSSION: The Panel Moderator (20 to 30 min)">FACILITATING DISCUSSION: The Panel Moderator (20 to 30 min)
</option><option value="FACILITATING DISCUSSION: The Brainstorming Session (20 to 30 min)">FACILITATING DISCUSSION: The Brainstorming Session (20 to 30 min)
</option><option value="FACILITATING DISCUSSION: The Problem-Solving Session (30 to 40 min)">FACILITATING DISCUSSION: The Problem-Solving Session (30 to 40 min)
</option><option value="FACILITATING DISCUSSION: Handling Challenging Situations (Role Playing) (20 to 30 min)">FACILITATING DISCUSSION: Handling Challenging Situations (Role Playing) (20 to 30 min)
</option><option value="FACILITATING DISCUSSION: Reaching A Consensus (30 to 40 min)">FACILITATING DISCUSSION: Reaching A Consensus (30 to 40 min)
</option><option value="HIGH PERFORMANCE LEADERSHIP: Vision (5 to 7 min)">HIGH PERFORMANCE LEADERSHIP: Vision (5 to 7 min)
</option><option value="HIGH PERFORMANCE LEADERSHIP: Learning (5 to 7 min)">HIGH PERFORMANCE LEADERSHIP: Learning (5 to 7 min)
</option><option value="HUMOROUSLY SPEAKING: Warm Up Your Audience (5 to 7 min)">HUMOROUSLY SPEAKING: Warm Up Your Audience (5 to 7 min)
</option><option value="HUMOROUSLY SPEAKING: Leave Them With A Smile (5 to 7 min)">HUMOROUSLY SPEAKING: Leave Them With A Smile (5 to 7 min)
</option><option value="HUMOROUSLY SPEAKING: Make Them Laugh (5 to 7 min)">HUMOROUSLY SPEAKING: Make Them Laugh (5 to 7 min)
</option><option value="HUMOROUSLY SPEAKING: Keep Them Laughing (5 to 7 min)">HUMOROUSLY SPEAKING: Keep Them Laughing (5 to 7 min)
</option><option value="HUMOROUSLY SPEAKING: The Humorous Speech (5 to 7 min)">HUMOROUSLY SPEAKING: The Humorous Speech (5 to 7 min)
</option><option value="INTERPERSONAL COMMUNICATIONS: Conversing with Ease (10 to 14 min)">INTERPERSONAL COMMUNICATIONS: Conversing with Ease (10 to 14 min)
</option><option value="INTERPERSONAL COMMUNICATIONS: The Successful Negotiator (10 to 14 min)">INTERPERSONAL COMMUNICATIONS: The Successful Negotiator (10 to 14 min)
</option><option value="INTERPERSONAL COMMUNICATIONS: Diffusing Verbal Criticism (10 to 14 min)">INTERPERSONAL COMMUNICATIONS: Diffusing Verbal Criticism (10 to 14 min)
</option><option value="INTERPERSONAL COMMUNICATIONS: The Coach (10 to 14 min)">INTERPERSONAL COMMUNICATIONS: The Coach (10 to 14 min)
</option><option value="INTERPERSONAL COMMUNICATIONS: Asserting Yourself Effectively (10 to 14 min)">INTERPERSONAL COMMUNICATIONS: Asserting Yourself Effectively (10 to 14 min)
</option><option value="INTERPRETIVE READING: Read A Story (8 to 10 min)">INTERPRETIVE READING: Read A Story (8 to 10 min)
</option><option value="INTERPRETIVE READING: Interpreting Poetry (6 to 8 min)">INTERPRETIVE READING: Interpreting Poetry (6 to 8 min)
</option><option value="INTERPRETIVE READING: The Monodrama (5 to 7 min)">INTERPRETIVE READING: The Monodrama (5 to 7 min)
</option><option value="INTERPRETIVE READING: The Play (12 to 15 min)">INTERPRETIVE READING: The Play (12 to 15 min)
</option><option value="INTERPRETIVE READING: The Oratorical Speech (10 to 12 min)">INTERPRETIVE READING: The Oratorical Speech (10 to 12 min)
</option><option value="Other Manual or Non Manual Speech: Custom Speech (3 to 5 min)">Other Manual or Non Manual Speech: Custom Speech (3 to 5 min)
</option><option value="Other Manual or Non Manual Speech: Custom Speech (5 to 7 min)">Other Manual or Non Manual Speech: Custom Speech (5 to 7 min)
</option><option value="Other Manual or Non Manual Speech: Custom Speech (8 to 10 min)">Other Manual or Non Manual Speech: Custom Speech (8 to 10 min)
</option><option value="Other Manual or Non Manual Speech: Custom Speech (10 to 12 min)">Other Manual or Non Manual Speech: Custom Speech (10 to 12 min)
</option><option value="Other Manual or Non Manual Speech: Custom Speech (13 to 15 min)">Other Manual or Non Manual Speech: Custom Speech (13 to 15 min)
</option><option value="Other Manual or Non Manual Speech: Custom Speech (18 to 20 min)">Other Manual or Non Manual Speech: Custom Speech (18 to 20 min)
</option><option value="Other Manual or Non Manual Speech: Custom Speech (23 to 25 min)">Other Manual or Non Manual Speech: Custom Speech (23 to 25 min)
</option><option value="Other Manual or Non Manual Speech: Custom Speech (28 to 30 min)">Other Manual or Non Manual Speech: Custom Speech (28 to 30 min)
</option><option value="Other Manual or Non Manual Speech: Custom Speech (35 to 40 min)">Other Manual or Non Manual Speech: Custom Speech (35 to 40 min)
</option><option value="Other Manual or Non Manual Speech: Custom Speech (40 to 45 min)">Other Manual or Non Manual Speech: Custom Speech (40 to 45 min)
</option><option value="Other Manual or Non Manual Speech: Custom Speech (45 to 50 min)">Other Manual or Non Manual Speech: Custom Speech (45 to 50 min)
</option><option value="Other Manual or Non Manual Speech: Custom Speech (55 to 60 min)">Other Manual or Non Manual Speech: Custom Speech (55 to 60 min)
</option><option value="Other Manual or Non Manual Speech: Custom Speech (more than an hour)">Other Manual or Non Manual Speech: Custom Speech (more than an hour)
</option><option value="PERSUASIVE SPEAKING: The Effective Salesperson (3 to 4 min speech; 2 min intro; 3 to 5 min role play)">PERSUASIVE SPEAKING: The Effective Salesperson (3 to 4 min speech; 2 min intro; 3 to 5 min role play)
</option><option value="PERSUASIVE SPEAKING: Conquering the cold call(3 to 4 min speech;2 min intro, 5 to 7 min role play; 2 to 3 min discussion)">PERSUASIVE SPEAKING: Conquering the "Cold Call" (3 to 4 min speech;2 min intro, 5 to 7 min role play; 2 to 3 min discussion)
</option><option value="PERSUASIVE SPEAKING: The Winning Proposal (5 to 7 min)">PERSUASIVE SPEAKING: The Winning Proposal (5 to 7 min)
</option><option value="PERSUASIVE SPEAKING: Addressing the Opposition (7 to 9 min speech; 2 to 3 min Q&amp;A)">PERSUASIVE SPEAKING: Addressing the Opposition (7 to 9 min speech; 2 to 3 min Q&amp;A)
</option><option value="PERSUASIVE SPEAKING: The Persuasive Leader (6 to 8 min)">PERSUASIVE SPEAKING: The Persuasive Leader (6 to 8 min)
</option><option value="PUBLIC RELATIONS: The Persuasive Approach (8 to 10 min)">PUBLIC RELATIONS: The Persuasive Approach (8 to 10 min)
</option><option value="PUBLIC RELATIONS: Speaking Under Fire (6 to 8 min, 8 to 10 min with Q&amp;A)">PUBLIC RELATIONS: Speaking Under Fire (6 to 8 min, 8 to 10 min with Q&amp;A)
</option><option value="PUBLIC RELATIONS: The Goodwill Speech (5 to 7 min)">PUBLIC RELATIONS: The Goodwill Speech (5 to 7 min)
</option><option value="PUBLIC RELATIONS: The Radio Talk Show (8 to 10 min)">PUBLIC RELATIONS: The Radio Talk Show (8 to 10 min)
</option><option value="PUBLIC RELATIONS: The Crisis Management Speech (8 to 10 min, plus 30 seconds wth Q&amp;A)">PUBLIC RELATIONS: The Crisis Management Speech (8 to 10 min, plus 30 seconds wth Q&amp;A)
</option><option value="SPEAKING TO INFORM: The Speech to Inform (5 to 7 min)">SPEAKING TO INFORM: The Speech to Inform (5 to 7 min)
</option><option value="SPEAKING TO INFORM: Resources for Informing (8 to 10 min)">SPEAKING TO INFORM: Resources for Informing (8 to 10 min)
</option><option value="SPEAKING TO INFORM: The Demonstration Talk (10 to 12 min)">SPEAKING TO INFORM: The Demonstration Talk (10 to 12 min)
</option><option value="SPEAKING TO INFORM: A Fact-Finding Report (10 to 12 min)">SPEAKING TO INFORM: A Fact-Finding Report (10 to 12 min)
</option><option value="SPEAKING TO INFORM: The Abstract Concept (10 to 12 min)">SPEAKING TO INFORM: The Abstract Concept (10 to 12 min)
</option><option value="SPECIAL OCCASION SPEECHES: Mastering the Toast (2 to 3 min)">SPECIAL OCCASION SPEECHES: Mastering the Toast (2 to 3 min)
</option><option value="SPECIAL OCCASION SPEECHES: Speaking in Praise (5 to 7 min)">SPECIAL OCCASION SPEECHES: Speaking in Praise (5 to 7 min)
</option><option value="SPECIAL OCCASION SPEECHES: The Roast (3 to 5 min)">SPECIAL OCCASION SPEECHES: The Roast (3 to 5 min)
</option><option value="SPECIAL OCCASION SPEECHES: Presenting an Award (3 to 4 min)">SPECIAL OCCASION SPEECHES: Presenting an Award (3 to 4 min)
</option><option value="SPECIAL OCCASION SPEECHES: Accepting an Award (5 to 7 min)">SPECIAL OCCASION SPEECHES: Accepting an Award (5 to 7 min)
</option><option value="SPECIALTY SPEECHES: Speak Off The Cuff (5 to 7 min)">SPECIALTY SPEECHES: Speak Off The Cuff (5 to 7 min)
</option><option value="SPECIALTY SPEECHES: Uplift the Spirit (8 to 10 min)">SPECIALTY SPEECHES: Uplift the Spirit (8 to 10 min)
</option><option value="SPECIALTY SPEECHES: Sell a Product (10 to 12 min)">SPECIALTY SPEECHES: Sell a Product (10 to 12 min)
</option><option value="SPECIALTY SPEECHES: Read Out Loud (12 to 15 min)">SPECIALTY SPEECHES: Read Out Loud (12 to 15 min)
</option><option value="SPECIALTY SPEECHES: Introduce the Speaker (duration of a club meeting)">SPECIALTY SPEECHES: Introduce the Speaker (duration of a club meeting)
</option><option value="SPEECHES BY MANAGEMENT: The Briefing (8 to 10 min; plus 5 min with Q&amp;A)">SPEECHES BY MANAGEMENT: The Briefing (8 to 10 min; plus 5 min with Q&amp;A)
</option><option value="SPEECHES BY MANAGEMENT: The Technical Speech (8 to 10 min)">SPEECHES BY MANAGEMENT: The Technical Speech (8 to 10 min)
</option><option value="SPEECHES BY MANAGEMENT: Manage And Motivate (10 to 12 min)">SPEECHES BY MANAGEMENT: Manage And Motivate (10 to 12 min)
</option><option value="SPEECHES BY MANAGEMENT: The Status Report (10 to 12 min)">SPEECHES BY MANAGEMENT: The Status Report (10 to 12 min)
</option><option value="SPEECHES BY MANAGEMENT: Confrontation: The Adversary Relationship (5 min speech; plus 10 min with Q&amp;A)">SPEECHES BY MANAGEMENT: Confrontation: The Adversary Relationship (5 min speech; plus 10 min with Q&amp;A)
</option><option value="STORYTELLING: The Folk Tale (7 to 9 min)">STORYTELLING: The Folk Tale (7 to 9 min)
</option><option value="STORYTELLING: Let&#39;s Get Personal (6 to 8 min)">STORYTELLING: Let&rsquo;s Get Personal (6 to 8 min)
</option><option value="STORYTELLING: The Moral of the Story (4 to 6 min)">STORYTELLING: The Moral of the Story (4 to 6 min)
</option><option value="STORYTELLING: The Touching Story (6 to 8 min)">STORYTELLING: The Touching Story (6 to 8 min)
</option><option value="STORYTELLING: Bringing History to Life (7 to 9 min)">STORYTELLING: Bringing History to Life (7 to 9 min)
</option><option value="TECHNICAL PRESENTATIONS: The Technical Briefing (8 to 10 min)">TECHNICAL PRESENTATIONS: The Technical Briefing (8 to 10 min)
</option><option value="TECHNICAL PRESENTATIONS: The Proposal (8 to 10 min; 3 to 5 min with Q&amp;A)">TECHNICAL PRESENTATIONS: The Proposal (8 to 10 min; 3 to 5 min with Q&amp;A)
</option><option value="TECHNICAL PRESENTATIONS: The Nontechnical Audience (10 to 12 min)">TECHNICAL PRESENTATIONS: The Nontechnical Audience (10 to 12 min)
</option><option value="TECHNICAL PRESENTATIONS: Presenting a Technical Paper (10 to 12 min)">TECHNICAL PRESENTATIONS: Presenting a Technical Paper (10 to 12 min)
</option><option value="TECHNICAL PRESENTATIONS: Enhancing A Technical Talk With The Internet (12 to 15 min)">TECHNICAL PRESENTATIONS: Enhancing A Technical Talk With The Internet (12 to 15 min)
</option><option value="THE DISCUSSION LEADER: The Seminar Solution (20 to 30 min)">THE DISCUSSION LEADER: The Seminar Solution (20 to 30 min)
</option><option value="THE DISCUSSION LEADER: The Round Robin (20 to 30 min)">THE DISCUSSION LEADER: The Round Robin (20 to 30 min)
</option><option value="THE DISCUSSION LEADER: Pilot a Panel (30 to 40 min)">THE DISCUSSION LEADER: Pilot a Panel (30 to 40 min)
</option><option value="THE DISCUSSION LEADER: Make Believe (Role Playing) (20 to 30 min)">THE DISCUSSION LEADER: Make Believe (Role Playing) (20 to 30 min)
</option><option value="THE DISCUSSION LEADER: The Workshop Leader (30 to 40 min)">THE DISCUSSION LEADER: The Workshop Leader (30 to 40 min)
</option><option value="THE ENTERTAINING SPEAKER: The Entertaining Speech (5 to 7 min)">THE ENTERTAINING SPEAKER: The Entertaining Speech (5 to 7 min)
</option><option value="THE ENTERTAINING SPEAKER: Resources for Entertainment (5 to 7 min)">THE ENTERTAINING SPEAKER: Resources for Entertainment (5 to 7 min)
</option><option value="THE ENTERTAINING SPEAKER: Make Them Laugh (5 to 7 min)">THE ENTERTAINING SPEAKER: Make Them Laugh (5 to 7 min)
</option><option value="THE ENTERTAINING SPEAKER: A Dramatic Talk (5 to 7 min)">THE ENTERTAINING SPEAKER: A Dramatic Talk (5 to 7 min)
</option><option value="THE ENTERTAINING SPEAKER: Speaking After Dinner (8 to 10 min)">THE ENTERTAINING SPEAKER: Speaking After Dinner (8 to 10 min)
</option><option value="THE PROFESSIONAL SALESPERSON: The Winning Attitude (8 to 10 min)">THE PROFESSIONAL SALESPERSON: The Winning Attitude (8 to 10 min)
</option><option value="THE PROFESSIONAL SALESPERSON: Closing The Sale (10 to 12 min)">THE PROFESSIONAL SALESPERSON: Closing The Sale (10 to 12 min)
</option><option value="THE PROFESSIONAL SALESPERSON: Training The Sales Force (6 to 8 min speech; 8 to 10 min role play; 2 to 5 min discussion)">THE PROFESSIONAL SALESPERSON: Training The Sales Force (6 to 8 min speech; 8 to 10 min role play; 2 to 5 min discussion)
</option><option value="THE PROFESSIONAL SALESPERSON: The Sales Meeting (15 to 20 min)">THE PROFESSIONAL SALESPERSON: The Sales Meeting (15 to 20 min)
</option><option value="THE PROFESSIONAL SALESPERSON: The Team Sales Presentation (15 to 20 min plus 5 to 7 min per person for manual credit)">THE PROFESSIONAL SALESPERSON: The Team Sales Presentation (15 to 20 min plus 5 to 7 min per person for manual credit)
</option><option value="THE PROFESSIONAL SPEAKER: The Keynote Address (15 to 20 min)">THE PROFESSIONAL SPEAKER: The Keynote Address (15 to 20 min)
</option><option value="THE PROFESSIONAL SPEAKER: Speaking to Entertain (15 to 20 min)">THE PROFESSIONAL SPEAKER: Speaking to Entertain (15 to 20 min)
</option><option value="THE PROFESSIONAL SPEAKER: The Sales Training Speech (15 to 20 min)">THE PROFESSIONAL SPEAKER: The Sales Training Speech (15 to 20 min)
</option><option value="THE PROFESSIONAL SPEAKER: The Professional Seminar (20 to 40 min)">THE PROFESSIONAL SPEAKER: The Professional Seminar (20 to 40 min)
</option><option value="THE PROFESSIONAL SPEAKER: The Motivational Speech (15 to 20 min)">THE PROFESSIONAL SPEAKER: The Motivational Speech (15 to 20 min)
</option>';

}

function speech_public_details ($field) {
global $post;

		$manual = get_post_meta($post->ID, '_manual'.$field, true);
		$title = get_post_meta($post->ID, '_title'.$field, true);
		$project_key = get_post_meta($post->ID, '_project'.$field, true);
		$project_text = get_project_text($project_key);
		$time = (int) get_post_meta($post->ID, '_maxtime'.$field, true);
		$output = '';
		if($time == 0)
			$time = 7;
		
		if($manual)
			{
			$output .= '<div class="manual">'.$manual.' '.$project_text.'</div>';
			if(!strpos($field,'Backup'))
				$output .= '<input type="hidden" class="speaker_details maxtime" name="_maxtime['.$field.']" id="_maxtime_'.$field.'" value="'.$time.'">';
			}
		if($title)
			$output .= '<div class="speech_title">'.$title."</div>";
		if($time && !strpos($field,'Backup'))
			$output .= '<div class="speech_time">'.__('Time reserved for this speech','rsvpmaker-for-toastmasters').': '.$time.' '.__('minutes.','rsvpmaker-for-toastmasters')."</div>";
		return $output;
}

function speech_progress () {
global $wpdb;
global $current_user;

if(isset($_GET["select_user"]))
	{
	$user_id = $_GET["select_user"];
	$user = get_userdata($user_id);
	echo "<h2>".__('Progress Report for','rsvpmaker-for-toastmasters'). " ".$user->display_name."</h2>";
	}

else
	{
	$user_id = $current_user->ID;
	echo "<h2>".__('Progress Report for You','rsvpmaker-for-toastmasters'). "</h2>";
	}

echo '<p><form method="get" action="'.admin_url('edit.php').'"><input type="hidden" name="post_type" value="rsvpmaker"><input type="hidden" name="page" value="speech_progress">'.awe_user_dropdown('select_user',0,true).'<input type="submit" value="'.__('Get','rsvpmaker-for-toastmasters').'" /></form></p>'."\n";

echo "<h2>".__('Speeches','rsvpmaker-for-toastmasters')."</h2>";

	$sql = "SELECT DISTINCT $wpdb->posts.ID as postID, $wpdb->posts.*, a1.meta_value as datetime, a2.meta_value as template
	 FROM ".$wpdb->posts."
	 JOIN ".$wpdb->postmeta." a1 ON ".$wpdb->posts.".ID =a1.post_id AND a1.meta_key='_rsvp_dates'
	 JOIN ".$wpdb->postmeta." a2 ON ".$wpdb->posts.".ID =a2.post_id AND a2.meta_key LIKE '_Speaker%' AND a2.meta_value=".$user_id." 
	 WHERE a1.meta_value < CURDATE()
	 ORDER BY a1.meta_value DESC";

$results = $wpdb->get_results($sql);
foreach($results as $row)
	{
		$manual = $wpdb->get_var("SELECT meta_value FROM ".$wpdb->prefix."postmeta WHERE meta_key = '_manual".$row->meta_key."' AND post_id=".$row->post_id);
		$date = date('M jS',strtotime($row->datetime));
		if(!$manual || strpos($manual,'Manual / Speech') )
			{
			$permalink = rsvpmaker_permalink_query($row->post_id);
			if(isset($_GET["select_user"]) && $_GET["select_user"])
				$permalink .= 'edit_roles=1';
			$manual = 'Speech details not recorded (<a href="'.$permalink.'">set now?</a>)';
			}
		echo $manual . " - ".$date .'<br /><br />'; 
	}

echo "<h2>".__("Other Roles",'rsvpmaker-for-toastmasters')."</h2>\n";

	$sql = "SELECT DISTINCT $wpdb->posts.ID as postID, $wpdb->posts.*, a1.meta_value as datetime, a2.meta_value as template
	 FROM ".$wpdb->posts."
	 JOIN ".$wpdb->postmeta." a1 ON ".$wpdb->posts.".ID =a1.post_id AND a1.meta_key='_rsvp_dates'
	 JOIN ".$wpdb->postmeta." a2 ON ".$wpdb->posts.".ID =a2.post_id AND a2.meta_key NOT LIKE '%Speaker%' AND meta_key NOT LIKE '_edit_last' AND a2.meta_value=".$user_id." 
	 WHERE a1.meta_value < CURDATE()
	 ORDER BY a1.meta_value DESC";

$results = $wpdb->get_results($sql);
foreach($results as $row)
	{
		$date = date('M jS',strtotime($row->datetime));
		$role = str_replace('_',' ',$row->meta_key);
		$role = preg_replace('/ [1-9]/','',$role);
		printf('<p>%s - %s</p>',$role,$date);
	}

$wpdb->show_errors();

	$sql = "SELECT DISTINCT $wpdb->posts.ID as postID, $wpdb->posts.*, a1.meta_value as datetime, a2.meta_value as template
	 FROM ".$wpdb->posts."
	 JOIN ".$wpdb->postmeta." a1 ON ".$wpdb->posts.".ID =a1.post_id AND a1.meta_key='_rsvp_dates'
	 JOIN ".$wpdb->postmeta." a2 ON ".$wpdb->posts.".ID =a2.post_id AND a2.meta_key LIKE '_Speaker%' AND a2.meta_value=".$user_id."  AND concat('',a2.meta_value * 1) = a2.meta_value
	 WHERE a1.meta_value < NOW()
	 ORDER BY a1.meta_value DESC";

$results = $wpdb->get_results($sql);
foreach($results as $row)
	{
		$role = str_replace('_',' ',$row->meta_key);
		$role = preg_replace('/ [1-9]/','',$role);
		$done[$row->meta_value][$role]++;
		//printf('<p>%s - %s</p>',$role,$date);
	}

foreach($done as $index => $roles)
	{
		echo "<p>".__("user",'rsvpmaker-for-toastmasters').": ".$index;
		print_r($roles);
		echo "</p>\n";
	}

}

function unpack_user_archive_data($raw) {
$userdata = unserialize($raw);
if(is_object($userdata))
	{
	if(isset($userdata->data))
		$userdata = (array) $userdata->data;
	else
		$userdata = (array) $userdata;
	}
if(empty($userdata['first_name']) && empty($userdata['last_name']))
	{
	if(!empty($userdata["display_name"]))
		{
		$p = explode(' ',$userdata["display_name"]);
		$userdata["first_name"] = array_shift($p);
		$userdata["last_name"] = implode(' ',$p);
		}
	else
		$userdata["first_name"] = $userdata["last_name"] = '';
	}
return $userdata;
}

function extended_list () {
echo '<h2>'.__('Guests/Former Members','rsvpmaker-for-toastmasters').'</h2>';
echo "<p><em>".__('This list includes inactive members and guests','rsvpmaker-for-toastmasters')."</em></p>";
printf('<p>Filters: <a href="%s">%s</a> | <a href="%s">%s</a>  | <a href="%s">%s</a></p>',admin_url('users.php?page=extended_list&guests_only=1'),__('Guests','rsvpmaker-for-toastmasters'),admin_url('users.php?page=extended_list&former_only=1'),__('Former members','rsvpmaker-for-toastmasters'),admin_url('users.php?page=extended_list'),__('All','rsvpmaker-for-toastmasters'));

global $wpdb;
$public_context = false;

if(!empty($_GET["reset"]))
	{
	if(!empty($_GET["reset_confirm"]))
		{
			$wpdb->query("TRUNCATE ".$wpdb->prefix."users_archive");
			user_archive();
		}
	else
		{
			echo '<p>'.__('Are you sure you want to delete the user records archive?','rsvpmaker-for-toastmasters').' <a href="'.admin_url('users.php?page=extended_list&reset=1&reset_confirm=1').'">'.__('Yes','rsvpmaker-for-toastmasters').'</a></p>';
		}
	}

if(isset($_GET["unsubscribe"]))
{
	$e = strtolower(trim($_GET["unsubscribe"]));
	$unsub = get_option('rsvpmail_unsubscribed');
	if(!is_array($unsub))
		$unsub = array();
	if(!in_array($e,$unsub))
		$unsub[] = $e;
	update_option('rsvpmail_unsubscribed',$unsub);
	do_action('rsvpmail_unsubscribe',$e);
}

if(isset($_GET["resubscribe"]))
{
	$e = strtolower(trim($_GET["resubscribe"]));
	$unsub = get_option('rsvpmail_unsubscribed');
	$key = array_search($e,$unsub);
	if($key !== false)
		{
		unset($unsub[$key]);
		update_option('rsvpmail_unsubscribed',$unsub);
		}
}

if(isset($_POST["user"]))
{
	$user = stripslashes_deep($_POST["user"]);
	$user["display_name"] = $user["first_name"].' '.$user["last_name"];
	$index = preg_replace('/[^A-Za-z]/','',$user["last_name"].$user["first_name"].$user["user_email"]);
	$guest = $_POST["guest"];
	if(!empty($_POST["lookup"]))
		{
		$sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."users_archive WHERE sort=%s",$_POST["lookup"]);
		$row = $wpdb->get_row($sql);
		$userdata = unpack_user_archive_data($row->data);
		foreach($user as $name => $value)
			$userdata[$name] = $value; //add changed values to archived data
		$sql = $wpdb->prepare("UPDATE ".$wpdb->prefix."users_archive SET data=%s, sort=%s, guest=%d, email=%s WHERE sort=%s", serialize($userdata),$index, $guest, $user["user_email"], $_POST["lookup"]);
		}
	else
		$sql = $wpdb->prepare("REPLACE INTO ".$wpdb->prefix."users_archive SET data=%s, sort=%s, guest=%d, email=%s", serialize($user),$index, $guest, $user["user_email"]);
	$wpdb->show_errors();
	$wpdb->query($sql);
	$userdata = NULL;
}
elseif(isset($_POST["activate"]))
{
$sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."users_archive WHERE sort=%s",$_POST["activate"]);
$row = $wpdb->get_row($sql);
$newuser = unpack_user_archive_data($row->data);
?>
<form action="<?php echo admin_url('users.php?page=add_awesome_member'); ?>" method="post">
<?php
$result = add_member_user($newuser);
if($result)
	$wpdb->query("DELETE FROM ".$wpdb->prefix."users_archive WHERE sort='".$_POST["activate"]."'");
else
	echo '<button>'.__('Submit','rsvpmaker-for-toastmasters').'<button>';
echo '</form>';
}

if(isset($_GET["lookup"]))
{
$sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."users_archive WHERE sort=%s",$_GET["lookup"]);
$row = $wpdb->get_row($sql);
$guest = $row->guest;
$userdata = unpack_user_archive_data($row->data);
}
elseif(isset($_GET["activate"]))
{
$sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."users_archive WHERE sort=%s",$_GET["activate"]);
$row = $wpdb->get_row($sql);
$newuser = unpack_user_archive_data($row->data);
?>
<form action="<?php echo admin_url('users.php?page=extended_list'); ?>" method="post">
<h3><?php _e('Activate Member Account','rsvpmaker-for-toastmasters');?></h3>
<p><?php echo $newuser["first_name"] .' '.$newuser["last_name"] .' '.$newuser["user_email"] ?></p>
<p><input type="submit" value="<?php _e("Activate",'rsvpmaker-for-toastmasters');?>"></p>
<input type="hidden" name="activate" value="<?php echo $_GET["activate"]; ?>" />
</form>
<?php
}
?>
<form action="<?php echo admin_url('users.php?page=extended_list'); ?>" method="post">
<h3><?php if(isset($userdata)) _e("Edit Entry",'rsvpmaker-for-toastmasters'); else _e("Add Entry",'rsvpmaker-for-toastmasters');?></h3>
<table>
<tr><td><?php _e("First",'rsvpmaker-for-toastmasters');?></td><td><input name="user[first_name]" value="<?php if(isset($userdata["first_name"])) echo $userdata["first_name"]; ?>" ></td></tr>
<tr><td><?php _e("Last",'rsvpmaker-for-toastmasters');?></td><td><input name="user[last_name]"  value="<?php if(isset($userdata["last_name"])) echo $userdata["last_name"]; ?>" ></td></tr
><tr><td><?php _e("Email",'rsvpmaker-for-toastmasters');?></td><td><input name="user[user_email]"  value="<?php if(isset($userdata["user_email"])) echo $userdata["user_email"]; ?>" ></td></tr>
<tr><td><?php _e("Home",'rsvpmaker-for-toastmasters');?></td><td><input name="user[home_phone]"  value="<?php if(isset($userdata["home_phone"])) echo $userdata["home_phone"]; ?>" ></td></tr>
<tr><td><?php _e("Work",'rsvpmaker-for-toastmasters');?></td><td><input name="user[work_phone]"  value="<?php if(isset($userdata["work_phone"])) echo $userdata["work_phone"]; ?>" ></td></tr>
<tr><td><?php _e("Mobile",'rsvpmaker-for-toastmasters');?></td><td><input name="user[mobile_phone]"  value="<?php if(isset($userdata["mobile_phone"])) echo $userdata["mobile_phone"]; ?>" ></td></tr>
<tr><td><?php _e("Note",'rsvpmaker-for-toastmasters');?></td><td><textarea name="user[note]" rows="5" cols="80"><?php if(isset($userdata["note"])) echo $userdata["note"]; ?></textarea></td></tr>
</table>
<br /><input type="radio" name="guest" value="1" <?php if(!isset($userdata["ID"])) echo 'checked="checked"'; ?>> <?php _e('Guest','rsvpmaker-for-toastmasters'); ?>
<br /><input type="radio" name="guest" value="1" <?php if(isset($userdata["ID"])) echo 'checked="checked"'; ?>> <?php _e('Former Member','rsvpmaker-for-toastmasters'); ?>
<input type="hidden" name="lookup" value="<?php if(isset($row->sort)) echo $row->sort; ?>" />
<br /><input type="submit" value="<?php _e("Submit",'rsvpmaker-for-toastmasters');?>">
</form>

<?php

$contactmethods['home_phone'] = __("Home Phone",'rsvpmaker-for-toastmasters');
$contactmethods['work_phone'] = __("Work Phone",'rsvpmaker-for-toastmasters');
$contactmethods['mobile_phone'] = __("Mobile Phone",'rsvpmaker-for-toastmasters');
$contactmethods['facebook_url'] = __("Facebook Profile","rsvpmaker-for-toastmasters");
$contactmethods['twitter_url'] = __("Twitter Profile",'rsvpmaker-for-toastmasters');
$contactmethods['linkedin_url'] = __("LinkedIn Profile",'rsvpmaker-for-toastmasters');
$contactmethods['business_url'] = __("Business Web Address",'rsvpmaker-for-toastmasters');
$contactmethods['user_email'] = __("Email",'rsvpmaker-for-toastmasters');
$contactmethods['Note'] = __("Note",'rsvpmaker-for-toastmasters');
$unsubscribed = get_option('rsvpmail_unsubscribed');
if(empty($unsubscribed))
	$unsubscribed = array();
$guest_list = $former_list = $email_list = '';

$results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."users_archive ORDER BY sort");
foreach($results as $row)
	{
		$userdata = unpack_user_archive_data($row->data);
		if(isset($_GET["debug"]))
		{
		echo '<pre>';
		print_r($userdata);
		echo '</pre>';
		}
		
		if(isset($userdata["ID"]) && $userdata["ID"] && ($row->user_id == 0) )
			$wpdb->query( $wpdb->prepare("UPDATE ".$wpdb->prefix."users_archive SET user_id=%d WHERE sort=%s", $userdata["ID"],$row->sort) );
		if(!empty($userdata["user_email"]) && empty($row->email) )
			$wpdb->query( $wpdb->prepare("UPDATE ".$wpdb->prefix."users_archive SET email=%s WHERE sort=%s", $userdata["user_email"],$row->sort) );
			
		if(isset($userdata["user_email"]) && !in_array($userdata["user_email"],$unsubscribed))
			$email_list .= $userdata["user_email"].", ";
		$status = '';
		if(isset($userdata["ID"]) && !is_user_member_of_blog($userdata["ID"])) //!get_user_by('ID',$userdata["ID"]))
			{
			$status = ' - '.__('Former Member','rsvpmaker-for-toastmasters').' <a href="'.admin_url('users.php?page=extended_list&lookup=').$row->sort.'">('.__('Edit','rsvpmaker-for-toastmasters').')</a> <a href="'.admin_url('users.php?page=extended_list&activate=').$row->sort.'">('.__('Reactivate','rsvpmaker-for-toastmasters').')</a> <br />'.__('Updated','rsvpmaker-for-toastmasters').': '.$row->updated;
			if(isset($userdata["user_email"]) && !in_array($userdata["user_email"],$unsubscribed))
				$former_list .= $userdata["user_email"].", ";
			if(isset($_GET['guests_only']))
				continue;
			}
		elseif($row->guest)
			{
			if(isset($userdata["user_email"]) && !in_array($userdata["user_email"],$unsubscribed))
				$guest_list .= $userdata["user_email"].", ";
			$status = ' - '.__('Guest','rsvpmaker-for-toastmasters').' <a href="'.admin_url('users.php?page=extended_list&lookup=').$row->sort.'">('.__('Edit','rsvpmaker-for-toastmasters').')</a> <a href="'.admin_url('users.php?page=extended_list&activate=').$row->sort.'">('.__('Convert to Member','rsvpmaker-for-toastmasters').')</a><br />'.__('Updated','rsvpmaker-for-toastmasters').': '.$row->updated;
			if(isset($_GET['former_only']))
				continue;
			}
		else
			{
			if(isset($_GET['guests_only']) || isset($_GET['former_only']))
				continue;	
			}
		
?>	
<div class="member-entry" style="margin-bottom: 50px; clear: both;">
<p><strong><?php echo $userdata["first_name"].' '.$userdata["last_name"].$status; ?></strong></p>
<?php
	foreach($contactmethods as $name => $value)
		{
		if(strpos($name,'phone'))
			{
			if( (!$public_context) && isset($userdata[$name]) )
				printf("<div>%s: %s</div>",$value,$userdata[$name]);
			}
		if(strpos($name,'url'))
			{
			if( isset($userdata[$name]) && strpos($userdata[$name],'://') )
				printf('<div><a target="_blank" href="%s">%s</a></div>',$userdata[$name],$value);
			}
		}
		if(isset($userdata["user_email"]))
		{
		printf('<div>'.__('Email','rsvpmaker-for-toastmasters').': <a href="mailto:%s">%s</a> ',$userdata["user_email"],$userdata["user_email"]);
		if(in_array($userdata["user_email"],$unsubscribed))
			printf('(%s <a href="%s">%s</a>)</div>',__('Unsubscribed from email','rsvpmaker-for-toastmasters'),admin_url('users.php?page=extended_list&resubscribe=').$userdata["user_email"],__('Restore','rsvpmaker-for-toastmasters'));			
		else
			printf('(<a href="%s">%s</a>)</div>',admin_url('users.php?page=extended_list&unsubscribe=').$userdata["user_email"],__('Unsubscribe','rsvpmaker-for-toastmasters'));
		}
		if(!empty($userdata["user_description"]))
			echo wpautop('<strong>'.__('About Me','rsvpmaker-for-toastmasters').':</strong> '.$userdata["user_description"]);

		if(isset($userdata["note"]))
			echo wpautop('<strong>'.__('Note','rsvpmaker-for-toastmasters').':</strong> '.$userdata["note"]);

?>
</div>
<?php

	}

printf('<p>%s <a target="_blank" href="mailto:%s">%s</a></p>',__('Combined email','rsvpmaker-for-toastmasters'),$email_list,$email_list);
printf('<p>%s <a target="_blank" href="mailto:%s">%s</a></p>',__('Former member emails','rsvpmaker-for-toastmasters'),$former_list,$former_list);
printf('<p>%s <a target="_blank" href="mailto:%s">%s</a></p>',__('Guest emails','rsvpmaker-for-toastmasters'),$guest_list,$guest_list);
?>
<p><a href="<?php echo admin_url('users.php?page=extended_list&reset=1') ?>"><?php _e('Reset','rsvpmaker-for-toastmasters');?></a></p>
<?php
}


function wp4t_user_row_edit_member( $actions, $user ) {
global $current_user;

	if ( $user->ID == $current_user->ID ) {
		return $actions;
	}
	
	if( current_user_can('edit_members') )

	$actions['edit_member'] = '<a href="' . admin_url('users.php?page=edit_members&user_id=').$user->ID . '">' . esc_html__( 'Edit Member', 'rsvpmaker-for-toastmasters' ) . '</a>';

	return $actions;
}


function edit_members() {

$hook = tm_admin_page_top(__('Edit Member','rsvpmaker-for-toastmasters'));

$security_roles = array('administrator', 'manager','editor','author','contributor','subscriber');

echo '<p>'.__('Authorized users can use this screen to edit member email addresses and other contact information.')."</p>";

if(isset( $_POST['edit_member_nonce'] ) && wp_verify_nonce( $_POST['edit_member_nonce'], 'edit_member' ))
	{
	$user["ID"] = (int) $_POST["user_id"];
	$user["user_email"] = trim($_POST["email"]);
	$user["first_name"] = $_POST["first_name"];
	$user["last_name"] = $_POST["last_name"];
	$user["nickname"] = $user["display_name"] = $_POST["first_name"].' '.$_POST["last_name"];
	$user["home_phone"] = $_POST["home_phone"];
	$user["work_phone"] = $_POST["work_phone"];
	$user["mobile_phone"] = $_POST["mobile_phone"];
	$user["toastmasters_id"] = (int) $_POST["toastmasters_id"];
	$user["education_awards"] = $_POST["education_awards"];
	if(current_user_can('manage_options') && isset($_POST["user_role"]) && in_array($_POST["user_role"],$security_roles) && !user_can($user["ID"],'administrator') )
		$user["role"] = $_POST["user_role"];
	$return = wp_update_user($user);
	if( is_int($return) )
		echo '<div class="updated">Updated member record: '.$user["display_name"].'</div>';
	elseif( is_wp_error( $return ) ) {
    echo '<div class="error">Error: '.$return->get_error_message().'</div>';
}		
// update user
}
	
	
if(isset($_GET["user_id"]))
	{
	$user_id = (int) $_GET["user_id"];
	$userdata = get_userdata($user_id);
	if(!$userdata)
		die('error');
?>
<form action="<?php echo admin_url('users.php?page=edit_members'); ?>" method="post" name="edituser" id="edituser" class="add:users: validate">
<?php wp_nonce_field( 'edit_member', 'edit_member_nonce' );?>
<input type="hidden" name="user_id" value="<?php echo $userdata->ID; ?>" />
<table class="form-table">
	<tr>
		<th scope="row"><label for="email"><?php _e("Email",'rsvpmaker-for-toastmasters');?></label></th>
		<td><input name="email" type="text" id="email" value="<?php echo $userdata->user_email; ?>" /></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="first_name"><?php _e("First Name",'rsvpmaker-for-toastmasters');?> </label></th>
		<td><input name="first_name" type="text" id="first_name" value="<?php echo $userdata->first_name; ?>" /></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="last_name"><?php _e("Last Name",'rsvpmaker-for-toastmasters');?> </label></th>
		<td><input name="last_name" type="text" id="last_name" value="<?php echo $userdata->last_name; ?>" /></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="home_phone"><?php _e("Home Phone",'rsvpmaker-for-toastmasters');?> </label></th>
		<td><input name="home_phone" type="text" id="home_phone" value="<?php echo $userdata->home_phone; ?>" /></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="work_phone"><?php _e("Work Phone",'rsvpmaker-for-toastmasters');?> </label></th>
		<td><input name="work_phone" type="text" id="work_phone" value="<?php echo $userdata->work_phone; ?>" /></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="mobile_phone"><?php _e("Mobile Phone",'rsvpmaker-for-toastmasters');?> </label></th>
		<td><input name="mobile_phone" type="text" id="mobile_phone" value="<?php echo $userdata->mobile_phone; ?>" /></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="toastmasters_id"><?php _e("Toastmasters ID #",'rsvpmaker-for-toastmasters');?> </label></th>
		<td><input name="toastmasters_id" type="text" id="toastmasters_id" value="<?php echo $userdata->toastmasters_id; ?>" /></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="education_awards"><?php _e("Education Awards",'rsvpmaker-for-toastmasters');?> </label></th>
		<td><input name="education_awards" type="text" id="education_awards" value="<?php echo $userdata->education_awards; ?>" />
        <br /><?php _e("Use the abbreviations",'rsvpmaker-for-toastmasters');?> CC, ACB, ACS, ACG, CL, ALB, ALS, DTM</td>
	</tr>
<?php
if(current_user_can('manage_options'))
{
$user = new WP_User( $user_id );
$current_role = $user->roles[0];
$options = '';
foreach($security_roles as $role)
	{
		$s = ($role == $current_role) ? ' selected="selected" ' : '';
		$label = ucfirst($role);
		if($role == 'subscriber')
			{
				$label .= ' ('.__('Member','rsvpmaker-for-toastmasters').')';
			}
	$options .= sprintf('<option value="%s" %s>%s</option>',$role,$s,$label);
	}
?>
	<tr class="form-field">
		<th scope="row"><label for="user_role"><?php _e("User Role",'rsvpmaker-for-toastmasters');?> </label></th>
		<td><select name="user_role" id="user_role"><?php echo $options; ?></select>
        </td>
	</tr>
<?php
}
?>
	</table>
<p class="submit"><input type="submit" name="createuser" id="createusersub" class="button-primary" value="<?php _e("Save",'rsvpmaker-for-toastmasters');?>"  /></p>
</form>
<?php

	}


$blogusers = get_users('orderby=nicename');
    foreach ($blogusers as $user) {		

	$userdata = get_userdata($user->ID);
	if($userdata->hidden_profile)
		continue;
	$index = preg_replace('/[^A-Za-z]/','',$userdata->last_name.$userdata->first_name.$userdata->user_login);
	$members[$index] = $userdata;
	}
	
	ksort($members);
	foreach($members as $userdata) {
	printf('<p><a href="'.admin_url('users.php?page=edit_members&user_id').'=%d">%s %s</a></p></p>',$userdata->ID, $userdata->first_name, $userdata->last_name);
	}
tm_admin_page_bottom($hook);
}

function awesome_menu() {

// defaults 'edit_signups' => 'read','email_list' => 'read','edit_member_stats' => 'edit_others_posts','view_reports' => 'read','view_attendance' => 'read','agenda_setup' => 'edit_others_posts'
$security = get_tm_security ();	

add_submenu_page('edit.php?post_type=rsvpmaker', __("Agenda Setup",'rsvpmaker-for-toastmasters'), __("Agenda Setup",'rsvpmaker-for-toastmasters'), $security['agenda_setup'], "agenda_setup", "agenda_setup");

$agenda_time = get_option('agenda_time');
if($agenda_time)
	add_submenu_page('edit.php?post_type=rsvpmaker', __("Agenda Timing",'rsvpmaker-for-toastmasters'), __("Agenda Timing",'rsvpmaker-for-toastmasters'), $security['agenda_setup'], "agenda_timing", "agenda_timing");

add_submenu_page('profile.php', __("Add Members",'rsvpmaker-for-toastmasters'), __("Add Members",'rsvpmaker-for-toastmasters'), 'edit_others_posts', "add_awesome_member", "add_awesome_member" );

add_submenu_page('profile.php', __("Set Away Status",'rsvpmaker-for-toastmasters'), __("Set Away Status",'rsvpmaker-for-toastmasters'), 'read', "wp4t_set_status_form", "wp4t_set_status_form" );

add_submenu_page('profile.php', __("Edit Members",'rsvpmaker-for-toastmasters'), __("Edit Members",'rsvpmaker-for-toastmasters'), 'edit_members', "edit_members", "edit_members" );
add_submenu_page('profile.php', __("Guests/Former Members",'rsvpmaker-for-toastmasters'), __("Guests/Former Members",'rsvpmaker-for-toastmasters'), 'edit_members', "extended_list", "extended_list" );

add_submenu_page('profile.php', __("RSVP List to Members",'rsvpmaker-for-toastmasters'), __("RSVP List to Members",'rsvpmaker-for-toastmasters'), 'edit_members', "rsvp_to_member", "rsvp_to_member" );

$page_title = "Toastmasters";
$menu_title = $page_title;
$capability = "manage_options";
$menu_slug = "wp4toastmasters_settings";
$function = "wp4toastmasters_settings";
add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function);
add_options_page( 'Toastmasters Security', 'TM Security', 'manage_options', 'tm_security_caps', 'tm_security_caps');

add_submenu_page('upload.php', __("YouTube Toastmasters",'rsvpmaker-for-toastmasters'), __("YouTube Toastmasters",'rsvpmaker-for-toastmasters'), 'edit_others_posts', "tm_youtube_tool", "tm_youtube_tool");

}

function wp4toastmasters_settings() {
global $wpdb;
add_awesome_roles();
?>
<div class="wrap">
<h2>Toastmasters <?php _e("Settings",'rsvpmaker-for-toastmasters');?></h2>
    <h2 class="nav-tab-wrapper">
      <a class="nav-tab nav-tab-active" href="#basic">Basic Settings</a>
      <a class="nav-tab" href="#security">Security</a>
    </h2>

    <div id='sections'>
    <section id="basic">
<form method="post" action="options.php">
<?php settings_fields( 'wp4toastmasters-settings-group' );
$wp4toastmasters_officer_ids = get_option('wp4toastmasters_officer_ids');
$wp4toastmasters_officer_titles = get_option('wp4toastmasters_officer_titles');
if(!is_array($wp4toastmasters_officer_titles) )
	$wp4toastmasters_officer_titles = array(__("President",'rsvpmaker-for-toastmasters'),__("VP of Education",'rsvpmaker-for-toastmasters'),__("VP of Membership",'rsvpmaker-for-toastmasters'),__("VP of Public Relations",'rsvpmaker-for-toastmasters'),__("Secretary",'rsvpmaker-for-toastmasters'),__("Treasurer",'rsvpmaker-for-toastmasters'),__("Sgt. at Arms",'rsvpmaker-for-toastmasters'),__("Immediate Past President",'rsvpmaker-for-toastmasters'));
$wp4toastmasters_member_message = get_option('wp4toastmasters_member_message');
$wp4toastmasters_officer_message = get_option('wp4toastmasters_officer_message');
$wp4toastmasters_disable_email = get_option('wp4toastmasters_disable_email' );
if(empty($wp4toastmasters_disable_email))
	$wp4toastmasters_disable_email = 0;
$wp4toastmasters_enable_sync = get_option('wp4toastmasters_enable_sync' );

$wp4toastmasters_agenda_timezone = get_option('wp4toastmasters_agenda_timezone' );
if(empty($wp4toastmasters_agenda_timezone))
	$wp4toastmasters_agenda_timezone = 0;

$wp4toastmasters_agenda_layout = get_option('wp4toastmasters_agenda_layout');
$wp4toastmasters_welcome_message = get_option('wp4toastmasters_welcome_message');
$tm_signup_count = get_option('tm_signup_count');
	
$public = get_option('blog_public');

?>
<h3><?php _e("Make the Website Public",'rsvpmaker-for-toastmasters');?></h3>
<p><input type="radio" name="blog_public" value="1" <?php if($public) echo ' checked="checked" '; ?> /> <?php _e("Yes, this website is open for business!",'rsvpmaker-for-toastmasters');?></p>
<p><input type="radio" name="blog_public" value="0" <?php if(!$public) echo ' checked="checked" '; ?> /> <?php _e("No, I am still testing, so I don't want this site indexed by Google or other search engines",'rsvpmaker-for-toastmasters');?>.</p>

<h3><?php _e("Enable Email Functions",'rsvpmaker-for-toastmasters');?></h3>
<p><input type="radio" name="wp4toastmasters_disable_email" value="0" <?php if(!$wp4toastmasters_disable_email) echo ' checked="checked" '; ?> /> <?php _e("Yes, the email list is active",'rsvpmaker-for-toastmasters');?></p>
<p><input type="radio" name="wp4toastmasters_disable_email" value="1" <?php if($wp4toastmasters_disable_email) echo ' checked="checked" '; ?> /> <?php _e("No, do not sent automated email from the website",'rsvpmaker-for-toastmasters');?>.</p>

<h3><?php _e("Sync With WP4Toastmasters.com",'rsvpmaker-for-toastmasters');?></h3>
<p><input type="radio" name="wp4toastmasters_enable_sync" value="1" <?php if($wp4toastmasters_enable_sync) echo ' checked="checked" '; ?> /> <?php _e("Yes, sync member speech and role data with other sites",'rsvpmaker-for-toastmasters');?></p>
<p><input type="radio" name="wp4toastmasters_enable_sync" value="0" <?php if(!$wp4toastmasters_enable_sync) echo ' checked="checked" '; ?> /> <?php _e("No, do not share data outside of this club website",'rsvpmaker-for-toastmasters');?>.</p>

<?php
$tzstring = get_option('timezone_string');
if(empty($tzstring) )
	echo "<p>".__('Timezone not set - defaults to UTC 0 (UK time). Scroll to the top of the list for U.S. timezones','rsvpmaker-for-toastmasters')."</p>";

$current_offset = get_option('gmt_offset');

$check_zone_info = true;

// Remove old Etc mappings. Fallback to gmt_offset.
if ( false !== strpos($tzstring,'Etc/GMT') )
	$tzstring = '';

if ( empty($tzstring) ) { // Create a UTC+- zone if no timezone string exists
	$check_zone_info = false;
	if ( 0 == $current_offset )
		$tzstring = 'UTC+0';
	elseif ($current_offset < 0)
		$tzstring = 'UTC' . $current_offset;
	else
		$tzstring = 'UTC+' . $current_offset;
}

?>
<h3><?php _e("Timezone",'rsvpmaker-for-toastmasters');?></h3>
<p><label for="timezone_string"><?php _e('Timezone') ?></label>
<select id="timezone_string" name="timezone_string">
<optgroup label="U.S. Mainland">
<option value="America/New_York">New York</option>
<option value="America/Chicago">Chicago</option>
<option value="America/Denver">Denver</option>
<option value="America/Los_Angeles">Los Angeles</option>
</optgroup>
<?php echo wp_timezone_choice($tzstring); ?>
</select>
<br /><?php _e('Choose a city in the same timezone as you.'); ?>
</p>

<h3><?php _e("Officer List",'rsvpmaker-for-toastmasters');?></h3>
<?php

foreach($wp4toastmasters_officer_titles as $index => $title)
{
	if(empty($title))
		break;
	$dropdown = awe_user_dropdown ('wp4toastmasters_officer_ids['.$index.']', $wp4toastmasters_officer_ids[$index], true);
	printf('<p><input type="text" name="wp4toastmasters_officer_titles[%s]" value="%s" /> %s</p>', $index, $title, $dropdown);
}
$limit = $index + 3;
for($index = $index; $index < $limit; $index++)
	{
	$dropdown = awe_user_dropdown ('wp4toastmasters_officer_ids['.$index.']', 0, true);
	printf('<p><input type="text" name="wp4toastmasters_officer_titles[%s]" value="%s" /> %s</p>', $index, '', $dropdown);
	}
?>
<p><?php _e("Officers will be listed at the top of the members page and can also be displayed on the agenda",'rsvpmaker-for-toastmasters');?>.</p>

<p><?php _e("You may also want to appoint a backup administrator (who will have full rights to administer the site) and one or more site managers (who have editing rights and can also add and edit member records). Be judicious in awarding these additional responsibilities.",'rsvpmaker-for-toastmasters');?>.</p>

<?php

$sortmember = array();
$blogusers = get_users('blog_id='.get_current_blog_id() );
    foreach ($blogusers as $user) {
		$member = get_userdata($user->ID);
		
		if($member->hidden_profile)
			continue;
		
		$index = preg_replace('/[^a-zA-Z]/','',$member->last_name.$member->first_name.$member->user_login);
		if(user_can($user->ID,'manage_options'))
			$administrators[] = $member->first_name.' '.$member->last_name;
		else
			{
			$sortmember[$index] = $member;
			if(user_can($user->ID,'edit_users'))
				$managers[] = $member->first_name.' '.$member->last_name;
			else
				$manager_candidates_array[$index] = $member;
			}
	}	
if(!empty($sortmember))
{
$candidates = '<option value="0">'.__('None','rsvpmaker-for-toastmasters').'</option>';
ksort($sortmember);
foreach($sortmember as $member)
	$candidates .= sprintf('<option value="%d">%s</option>',$member->ID, $member->first_name.' '.$member->last_name);
printf('<h3>%s</h3>
<select name="wp4toastmasters_admin_ids[]">%s</select>',__('Make Administrator','rsvpmaker-for-toastmasters'),$candidates);
}
if(!empty($manager_candidates_array))
{
$candidates = '<option value="0">'.__('None','rsvpmaker-for-toastmasters').'</option>';
ksort($manager_candidates_array);
foreach($manager_candidates_array as $member)
	$candidates .= sprintf('<option value="%d">%s</option>',$member->ID, $member->first_name.' '.$member->last_name);
printf('<h3>%s</h3>
<p><select name="wp4toastmasters_manager_ids[]">%s</select></p>
<p><select name="wp4toastmasters_manager_ids[]">%s</select></p>
<p><select name="wp4toastmasters_manager_ids[]">%s</select></p>',__('Make Manager','rsvpmaker-for-toastmasters'),$candidates,$candidates,$candidates);
}

if(!empty($administrators))
	printf('<p>Administrators: %s</p>',implode(', ',$administrators));
if(!empty($managers))
	printf('<p>Managers: %s</p>',implode(', ',$managers));

if(current_user_can('update_core'))
{
// restrict this to network admin on multisite
$wp4toastmasters_mailman = get_option('wp4toastmasters_mailman');
echo get_option('wp4toastmasters_mailman_default');

?>
<h3><?php _e("Member Email List",'rsvpmaker-for-toastmasters');?></h3>
<p>(See <a href="http://wp4toastmasters.com/2016/11/28/email-list-integration-for-your-toastmasters-club/" target="_blank"><?php _e("Documentation",'rsvpmaker-for-toastmasters');?></a>)</p>
<p><?php _e("List email address",'rsvpmaker-for-toastmasters');?>: <input type="text" name="wp4toastmasters_mailman[members]" value="<?php if(isset($wp4toastmasters_mailman["members"])) echo $wp4toastmasters_mailman["members"]; ?>" /></p>
<p><?php _e("Path",'rsvpmaker-for-toastmasters');?>: <input type="text" name="wp4toastmasters_mailman[mpath]" value="<?php if(isset($wp4toastmasters_mailman["mpath"])) echo $wp4toastmasters_mailman["mpath"]; ?>" /> <?php _e("Password",'rsvpmaker-for-toastmasters');?>: <input type="text" name="wp4toastmasters_mailman[mpass]" value="<?php if(isset($wp4toastmasters_mailman["mpass"])) echo $wp4toastmasters_mailman["mpass"]; ?>" /></p>
<?php if(isset($wp4toastmasters_mailman["mpass"])) {
	printf('<p><a href="%s&mailman_add_members=1">'.__('Add current members to mailing list','rsvpmaker-for-toastmasters').'</a></p>',admin_url('options-general.php?page=wp4toastmasters_settings'));
	}

if(isset($_GET["mailman_add_members"]))
{
    $users = get_users();
	foreach ($users as $user) {
		add_to_mailman($user->ID);
	}
}

if(isset($_GET["mailman_add_officers"]))
{
    foreach ($wp4toastmasters_officer_ids as $user_id) {
		add_to_mailman($user_id);
	}
}

?>

<h3><?php _e("Officer Email List",'rsvpmaker-for-toastmasters');?></h3>
<p><?php _e("List email address",'rsvpmaker-for-toastmasters');?>: <input type="text" name="wp4toastmasters_mailman[officers]" value="<?php if(isset($wp4toastmasters_mailman["officers"])) echo $wp4toastmasters_mailman["officers"]; ?>" /></p>
<p><?php _e("Path",'rsvpmaker-for-toastmasters');?>: <input type="text" name="wp4toastmasters_mailman[opath]" value="<?php if(isset($wp4toastmasters_mailman["opath"])) echo $wp4toastmasters_mailman["opath"]; ?>" /> <?php _e("Password",'rsvpmaker-for-toastmasters');?>: <input type="text" name="wp4toastmasters_mailman[opass]" value="<?php if(isset($wp4toastmasters_mailman["opass"])) echo $wp4toastmasters_mailman["opass"]; ?>" />

<?php if(isset($wp4toastmasters_mailman["opass"])) {
	printf('<p><a href="%s&mailman_add_officers=1">'.__("Update officers mailing list",'rsvpmaker-for-toastmasters').'</a></p>',admin_url('options-general.php?page=wp4toastmasters_settings'));
	}

if(isset($_GET["mailman_add_officers"]))
{
    foreach ($wp4toastmasters_officer_ids as $user_id) {

		$user = get_userdata($user_id);
		$email = $user->user_email;
		$url = trailingslashit($wp4toastmasters_mailman["opath"])."members?findmember=".$email."&setmemberopts_btn&adminpw=".$wp4toastmasters_mailman["opass"];
		$result = file_get_contents($url);
		if(!strpos($result, 'CHECKBOX') )
			{
			$url = trailingslashit($wp4toastmasters_mailman["opath"])."add?subscribe_or_invite=0&send_welcome_msg_to_this_batch=0&notification_to_list_owner=0&subscribees_upload=".$email."&adminpw=".$wp4toastmasters_mailman["opass"];;
		$result = file_get_contents($url);
		if(!strpos($result, 'Successfully') )
			echo "<div>".__('Error attempting to subscribe','rsvpmaker-for-toastmasters')." $email</div>";
			}
	}
}

}

?>

<p><?php _e("Message for Login Page",'rsvpmaker-for-toastmasters');?><br />
<textarea name="wp4toastmasters_login_message" rows="5" cols="80"><?php echo get_option('wp4toastmasters_login_message'); ?></textarea></p>

<p><?php _e("Message To Members on Dashboard",'rsvpmaker-for-toastmasters');?><br />
<textarea name="wp4toastmasters_member_message" rows="5" cols="80"><?php echo $wp4toastmasters_member_message; ?></textarea></p>

<p><?php _e("Message To Officers on Dashboard",'rsvpmaker-for-toastmasters');?><br />
<textarea name="wp4toastmasters_officer_message" rows="5" cols="80"><?php echo $wp4toastmasters_officer_message; ?></textarea></p>

<h3><?php _e("Include Time/Timezone on Agenda Email",'rsvpmaker-for-toastmasters');?></h3>
<p><input type="radio" name="wp4toastmasters_agenda_timezone" value="1" <?php if($wp4toastmasters_agenda_timezone) echo ' checked="checked" '; ?> /> <?php _e("Yes",'rsvpmaker-for-toastmasters');?> <input type="radio" name="wp4toastmasters_agenda_timezone" value="0" <?php if(!$wp4toastmasters_agenda_timezone) echo ' checked="checked" '; ?> /> <?php _e("No",'rsvpmaker-for-toastmasters');?>.</p>

<?php 
$reminder_options = array('4 hours' => '4 hours before','8 hours' => '8 hours before','1 days' => '1 day before','2 days' => '2 days before','3 days' => '3 days');

$wp4toast_reminder = get_option('wp4toast_reminder');
$options = '';
foreach($reminder_options as $index => $value)
	{
	if($index == $wp4toast_reminder)
		$s = ' selected="selected" ';
	else
		$s = '';
	$options .= sprintf('<option value="%s" %s>%s</option>',$index, $s, $value);
	}
$wp4toast_reminder2 = get_option('wp4toast_reminder2');
$options2 = '';
foreach($reminder_options as $index => $value)
	{
	if($index == $wp4toast_reminder2)
		$s = ' selected="selected" ';
	else
		$s = '';
	$options2 .= sprintf('<option value="%s" %s>%s</option>',$index, $s, $value);
	}
?>

<h3><?php _e('Email Reminders','rsvpmaker-for-toastmasters'); ?></h3>

<p><?php _e("Reminder",'rsvpmaker-for-toastmasters');?> 
<select name="wp4toast_reminder">
<option value=""><?php _e("None",'rsvpmaker-for-toastmasters');?></option>
<?php echo $options; ?>
</select>
</p>
<p><?php _e("Reminder #2",'rsvpmaker-for-toastmasters');?> 
<select name="wp4toast_reminder2">
<option value=""><?php _e("None",'rsvpmaker-for-toastmasters');?></option>
<?php echo $options2; ?>
</select>
</p>

<h3><?php _e('Agenda Formatting','rsvpmaker-for-toastmasters'); ?></h3>

<?php
$layout_options = array('plain','sidebar','custom');
$options = '';
foreach($layout_options as $value)
	{
	if($value == $wp4toastmasters_agenda_layout)
		$s = ' selected="selected" ';
	else
		$s = '';
	$options .= sprintf('<option value="%s" %s>%s</option>',$value, $s, $value);
	}
?>
<p><?php _e("Agenda Layout",'rsvpmaker-for-toastmasters');?> 
<select name="wp4toastmasters_agenda_layout">
<?php echo $options; ?>
</select>
<?php
$layout_id = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_rsvpmaker_special' AND meta_value='Agenda Layout' ");
if($layout_id)
	printf('<br />&nbsp;<a href="%s">%s</a>',admin_url('post.php?action=edit&post='.$layout_id),__('Edit Custom Agenda Layout','rsvpmaker-for-toastmasters'));
?>
</p>

<p><?php _e("Agenda CSS Customization",'rsvpmaker-for-toastmasters');?> <br />
<textarea rows="3" cols="80" name="wp4toastmasters_agenda_css">
<?php echo get_option('wp4toastmasters_agenda_css'); ?>
</textarea>
<br /><?php _e('Examples','rsvpmaker-for-toastmasters'); ?>:<br /><code>p {font-size: 14px;}</code> - <?php _e('increase the font size for all paragraphs','rsvpmaker-for-toastmasters'); ?>
<br /><code>#agenda p {font-size: 14px;}</code> - <?php _e('change the font size of the actual agenda but not the sidebar content','rsvpmaker-for-toastmasters'); ?>
<br /><code>#agenda {border-left: thick dotted #000;}</code> - <?php _e('add a dotted black line to the left of sidebar','rsvpmaker-for-toastmasters'); ?>
</p>

<h3><?php _e('Show Times on Agenda','rsvpmaker-for-toastmasters'); ?></h3>
<?php $agenda_time = get_option('agenda_time'); ?>
<p><input type="radio" name="agenda_time" value="1" <?php if($agenda_time) echo ' checked="checked" '; ?> /> <?php _e("Yes, show time",'rsvpmaker-for-toastmasters');?></p>
<p><input type="radio" name="agenda_time" value="0" <?php if(!$agenda_time) echo ' checked="checked" '; ?> /> <?php _e("No",'rsvpmaker-for-toastmasters');?>.</p>


<?php
$args = array('post_type' => 'page','orderby' => 'title','order' => 'ASC','posts_per_page' => 50);
$posts = get_posts($args);
$options = '<option value="">None</option>';
foreach($posts as $p)
	{
	if($p->ID == $wp4toastmasters_welcome_message)
		$s = ' selected="selected" ';
	else
		$s = '';
	$options .= sprintf('<option value="%s" %s>%s</option>',$p->ID, $s, $p->post_title);
	}
?>

<h3><?php _e("Signup Sheet",'rsvpmaker-for-toastmasters');?> </h3>
<p><?php _e("Future Meetings Displayed",'rsvpmaker-for-toastmasters');?> <select name="tm_signup_count">
<?php
if(empty($tm_signup_count))
	$tm_signup_count = 3;
for($i = 1; $i < 11; $i++)
{
$s = ($i == $tm_signup_count) ? ' selected="selected" ' : '';
printf('<option value="%d" %s>%d</option>',$i,$s,$i);
}
?>
</select>
</p>

<h3><?php _e("Random Assignment",'rsvpmaker-for-toastmasters');?> </h3>
<?php
$last_filled_limit = get_option('last_filled_limit');
$last_attended_limit = get_option('last_attended_limit');
$last_filled_option = $last_attended_option = '<option value="">'.__('None','rsvpmaker-for-toastmasters').'</option>';
for($i = 7; $i < 90; $i+=7)
{
$s = ($i == $last_filled_limit) ? ' selected="selected" ' : '';
$last_filled_option .= '<option value="'.$i.'" '.$s.'>'.$i.'</option>';
}
for($i = 28; $i < (7*50); $i+=7)
{
$s = ($i == $last_attended_limit) ? ' selected="selected" ' : '';
$last_attended_option .= '<option value="'.$i.'" '.$s.'>'.$i.'</option>';
}
?>
<p><?php _e('Avoid selecting members who have','rsvpmaker-for-toastmasters'); ?><ul><li><?php _e('not attended in more than','rsvpmaker-for-toastmasters'); ?> <select name="last_attended_limit"><?php echo $last_attended_option; ?></select> <?php _e('days'); echo '</li><li>'; _e('or who have filled the same role within','rsvpmaker-for-toastmasters'); ?> <select name="last_filled_limit"><?php echo $last_filled_option; ?></select> <?php _e('days');?></li></ul> <p><?php _e('Note: If you use the random assignment of members to roles, you may wish to have the software favor members who have attended the club recently but have not filled the same role within the last few weeks. This works best after your club has built up some history recording meetings in the software. Recommended reasonable settings: members who have attended more recently than 56 days (2 months) but have not filled the same role in the last 14 days.','rsvpmaker-for-toastmasters'); ?></p>

<h3><?php _e("Page Containing Welcome Message",'rsvpmaker-for-toastmasters');?> </h3>
<p><select name="wp4toastmasters_welcome_message">
<?php echo $options; ?>
</select>
</p>


<h3><?php _e('Beta Software','rsvpmaker-for-toastmasters'); ?></h3>
<?php $wp4toastmasters_beta = get_option('wp4toastmasters_beta'); ?>
<p><input type="radio" name="wp4toastmasters_beta" value="1" <?php if($wp4toastmasters_beta) echo ' checked="checked" '; ?> /> <?php _e("Yes, enable beta test features",'rsvpmaker-for-toastmasters');?></p>
<p><input type="radio" name="wp4toastmasters_beta" value="0" <?php if(!$wp4toastmasters_beta) echo ' checked="checked" '; ?> /> <?php _e("No, do not turn on beta features",'rsvpmaker-for-toastmasters');?>.</p>
<?php
do_action('toastmasters_settings_extra');
?>

<input type="submit" value="<?php _e("Submit",'rsvpmaker-for-toastmasters');?>" />
</form>

</section>
<section id="security">
<?php tm_security_caps(); ?>
</section>
</div>

</div>
<?php 

}

//call register settings function

function register_wp4toastmasters_settings() {
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_officer_titles' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_officer_ids' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_mailman' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_login_message' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_member_message' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_officer_message' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_disable_email' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_enable_sync' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_agenda_layout', 'wp4toastmasters_agenda_layout_check' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_agenda_css' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_welcome_message' );
	register_setting( 'wp4toastmasters-settings-group', 'timezone_string' );
	register_setting( 'wp4toastmasters-settings-group', 'blog_public' );
	register_setting( 'wp4toastmasters-settings-group', 'tm_security' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_beta' );
	register_setting( 'wp4toastmasters-settings-group', 'agenda_time' );
	register_setting( 'wp4toastmasters-settings-group', 'tm_signup_count' );
	register_setting( 'wp4toastmasters-settings-group', 'last_filled_limit' );
	register_setting( 'wp4toastmasters-settings-group', 'last_attended_limit' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toast_reminder' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toast_reminder2' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_agenda_timezone' );

	if(isset($_POST['wp4toast_reminder']))
		{
				// clear cron
			$previous = get_option('wp4toast_reminder');
			if(!empty($previous))
				{
				$p = explode(' ',$previous);
				if($p[1] == 'hours')
					$hours = $p[0];
				else
					$hours = $p[0] * 24;
				wp_clear_scheduled_hook( 'wp4toast_reminders_cron', array( $hours ) );
				}
			if(!empty($_POST['wp4toast_reminder']))
				{
					$p = explode(' ',$_POST['wp4toast_reminder']);
					if($p[1] == 'hours')
						$hours = $p[0];
					else
						$hours = $p[0] * 24;
					
					$fudge = $hours + 1;
					$future = get_future_events(" post_content LIKE '%role=%' ",1);
					if(sizeof($future))
						{
						$next = $future[0];
						fix_timezone();
						wp_schedule_event( strtotime($next->datetime .' -'.$hours.' hours'), 'weekly', 'wp4toast_reminders_cron', array( $hours ) );
						update_option('wp4toast_reminders_cron', 1);
						}
				}

			$previous = get_option('wp4toast_reminder2');
			if(!empty($previous))
				{
				$p = explode(' ',$previous);
				if($p[1] == 'hours')
					$hours = $p[0];
				else
					$hours = $p[0] * 24;
				wp_clear_scheduled_hook( 'wp4toast_reminders_cron', array( $hours ) );
				}
			if(!empty($_POST['wp4toast_reminder2']))
				{
					$p = explode(' ',$_POST['wp4toast_reminder2']);
					if($p[1] == 'hours')
						$hours = $p[0];
					else
						$hours = $p[0] * 24;
					
					$fudge = $hours + 1;
					$future = get_future_events(" post_content LIKE '%role=%' ",1);
					if(sizeof($future))
						{
						$next = $future[0];
						fix_timezone();
						wp_schedule_event( strtotime($next->datetime .' -'.$hours.' hours'), 'weekly', 'wp4toast_reminders_cron', array( $hours ) );
						update_option('wp4toast_reminders_cron', 1);
						}
				}


		}
}

function wp4toastmasters_agenda_layout_check ($option) {
global $current_user;
if($option == 'custom')
	{
		// create layout post if it does not already exist
		global $wpdb;
		if(! $wpdb->get_var("SELECT meta_key FROM $wpdb->postmeta WHERE meta_key='_rsvpmaker_special' AND meta_value='Agenda Layout' ") )
			{
			$layout["post_type"] = 'rsvpmaker';
			$layout["post_title"] = 'Agenda Layout';
			$layout["post_content"] = '<div id="banner"><img src="' . plugins_url('rsvpmaker-for-toastmasters/agenda-rays.png') . '" width="700" height="79"></div>
<h2 id="title">[tmlayout_club_name] - [tmlayout_meeting_date]</h2>
<table id="main" width="700"><tr><td id="sidebar" width="175">[tmlayout_sidebar]</td><td id="agenda" width="*">[tmlayout_main]</td></tr></table>';
			$layout["post_author"] = $current_user->ID;
			$layout["post_status"] = 'publish';
			$layout_id = wp_insert_post( $layout );
			add_post_meta($layout_id,'_rsvpmaker_special','Agenda Layout');
			update_option('rsvptoast_agenda_layout',$layout_id);
			$css = '
html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, font, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td {
	border: 0;
	font-family: inherit;
	font-size: 100%;
	font-style: inherit;
	font-weight: inherit;
	margin: 0;
	outline: 0;
	padding: 0;
	vertical-align: baseline;
}
body, p, div, td, th {
font-size: 12px;
line-height: 1.3;
font-family:"Times New Roman", Times, serif;
}
div#manual {
font-size: 10px;
}
p, td, th, div {
margin-top: 5px;
margin-bottom: 5px;
}
blockquote {
margin-left: 10px;
}
h1 {font-size: 24px;  font-weight: bold;  margin-bottom: 5px;}
h2 {font-size: 18px; font-weight: bold; margin-bottom: 5px;}
td {vertical-align: top;}
strong { font-weight: bold; }
em {font-style: italic; }

@page Section1
   {size:8.5in 11.0in; 
   margin: 0.5in; 
   mso-header-margin:.5in;
   mso-footer-margin:.5in; mso-paper-source:0;}
 div.Section1
 {
page:Section1;
width: 700px;
 }
div, p, table, blockquote {
max-width: 700px;
}
#banner {
height: 80px;
}
#sidebar {
padding-right: 10px;
width: 25%;
}
#agenda {
padding: 0 10px 0 10px;
border-left: medium solid #DDD;
}
div.timeblock {
margin-top: 0;
width: 75px;
float:left;
}
div.timed_content {
margin-left: 75px;
}
div.timewrap {
clear: both;
}
div.agenda_note p {
margin: 0;
padding: 0;
}
';
			add_post_meta($layout_id,'_rsvptoast_agenda_css',$css);
			}
	}
return $option;
}

function wp4toast_login_message( $message ) {
if(!empty($message))
	$message .= "\n\n";
$message .= get_option('wp4toastmasters_login_message');

if(!empty($message))
	{
	return wpautop($message);
	}
}

function get_tm_security () {
return array('edit_signups' => 'edit_signups','email_list' => 'email_list','edit_member_stats' => 'edit_member_stats','edit_own_stats' => 'edit_own_stats','view_reports' => 'view_reports','view_attendance' => 'view_reports','agenda_setup' => 'agenda_setup');
}

function tm_security_options ($label) {

$current = get_tm_security();
$selected = $current[$label];

$options = array('read' => 'Any Member','edit_others_posts' => 'Officer or Editor','manage_options' => 'Administrator');
$list = '';
foreach($options as $key => $value)
	{
		$s = ($key == $selected) ? ' selected="selected" ' : '';
		$list .= sprintf('<option value="%s" %s>%s</option>',$key,$s,$value);
	}
return sprintf('<label for="%s">Select:</label>
<select name="tm_security[%s]" id="%s">
%s
</select>',$label,$label,$label,$list);
}

function add_to_mailman($user_id, $olduser = NULL)
	{
		$wp4toastmasters_mailman = get_option('wp4toastmasters_mailman');
		if(!isset($wp4toastmasters_mailman["mpath"]) || empty($wp4toastmasters_mailman["mpath"]) || !isset($wp4toastmasters_mailman["mpass"]) || empty($wp4toastmasters_mailman["mpass"]) )
			return;
		$user = get_userdata($user_id);
		$email = $user->user_email;
		$url = trailingslashit($wp4toastmasters_mailman["mpath"])."members?findmember=".$email."&setmemberopts_btn&adminpw=".$wp4toastmasters_mailman["mpass"];
		$result = file_get_contents($url);
		if(!strpos($result, 'CHECKBOX') )
			{
			$url = trailingslashit($wp4toastmasters_mailman["mpath"])."add?subscribe_or_invite=0&send_welcome_msg_to_this_batch=0&notification_to_list_owner=0&subscribees_upload=".$email."&adminpw=".$wp4toastmasters_mailman["mpass"];;
		$result = file_get_contents($url);
		if(!strpos($result, 'Successfully') )
			echo "<div>".__('Error attempting to subscribe','rsvpmaker-for-toastmasters')." $email</div>";
			}
}

function unsubscribe_mailman($user_id, $olduser = NULL)
	{
		$wp4toastmasters_mailman = get_option('wp4toastmasters_mailman');
		if(!isset($wp4toastmasters_mailman["mpath"]) || empty($wp4toastmasters_mailman["mpath"]) || !isset($wp4toastmasters_mailman["mpass"]) || empty($wp4toastmasters_mailman["mpass"]) )
			return;
		$user = get_userdata($user_id);
		$email = $user->user_email;
		$url = trailingslashit($wp4toastmasters_mailman["mpath"])."members/remove?send_unsub_ack_to_this_batch=0&send_unsub_notifications_to_list_owner=0&unsubscribees_upload=".$email."&adminpw=".$wp4toastmasters_mailman["mpass"];;
	$result = file_get_contents($url);
	if(!strpos($result, 'Successfully') )
		echo "<div>".__('Error attempting to unsubscribe','rsvpmaker-for-toastmasters')." $email</div>";
}

function unsubscribe_mailman_by_email($email)
	{
		$wp4toastmasters_mailman = get_option('wp4toastmasters_mailman');
		if(!isset($wp4toastmasters_mailman["mpath"]) || empty($wp4toastmasters_mailman["mpath"]) || !isset($wp4toastmasters_mailman["mpass"]) || empty($wp4toastmasters_mailman["mpass"]) )
			return;
		$url = trailingslashit($wp4toastmasters_mailman["mpath"])."members/remove?send_unsub_ack_to_this_batch=0&send_unsub_notifications_to_list_owner=0&unsubscribees_upload=".$email."&adminpw=".$wp4toastmasters_mailman["mpass"];;
	$result = file_get_contents($url);
}

add_action('rsvpmail_unsubscribe','unsubscribe_mailman_by_email');

function awesome_event_content($content) {

if(!strpos($_SERVER['REQUEST_URI'],'rsvpmaker') ||  is_admin())
	return $content;

global $post, $rsvp_options;

$link = $output = '';

if(isset($_GET["recommendation"]))
	{
		if($_GET["recommendation"] == 'success')
			$link = '<div style="border: thin solid #00F; padding: 10px; margin: 10px; background-color: #eee;">'.__('You have accepted a role for this meeting. Thanks!','rsvpmaker-for-toastmasters').'</div>';
		elseif($_GET["recommendation"] == 'code_error')
			$link = '<div style="border: thin solid #F00; padding: 10px; margin: 10px; background-color: #eee;">'.__('Oops, something went wrong with the automatic sign up. Please sign in with your password to take a role','rsvpmaker-for-toastmasters').'</div>';		
		else
			$link = '<div style="border: thin solid #F00; padding: 10px; margin: 10px; background-color: #eee;">'.__('Oops, someone else took that role first. Sign in to take any other open role listed below','rsvpmaker-for-toastmasters').'</div>';
	}

if(($post->post_type != 'rsvpmaker') || !strpos($post->post_content,'role=') )
	return $content;
$permalink = rsvpmaker_permalink_query($post->ID);

if(isset($_GET["email_agenda"]) || isset($_GET["print_agenda"]) || is_email_context() )
	;
elseif( !is_club_member() )
	$link .= sprintf('<div id="agendalogin"><a href="%s">'.__('Login to Sign Up for Roles','rsvpmaker-for-toastmasters').'</a></div>',site_url().'/wp-login.php?redirect_to='.urlencode($permalink));
else
	{
	// defaults 'edit_signups' => 'read','email_list' => 'read','edit_member_stats' => 'edit_others_posts','view_reports' => 'read','view_attendance' => 'read','agenda_setup' => 'edit_others_posts'
	$security = get_tm_security ();	
	
	$link = '<div id="cssmenu"><ul>';
	
	if(current_user_can($security['edit_signups']))
		{
		$link .= '<li class="has-sub"><a href="'.$permalink.'edit_roles=1">'.__('Edit Signups','rsvpmaker-for-toastmasters').'</a><ul>';
		$link .= '<li"><a href="'.$permalink.'recommend_roles=1">'.__('Recommend','rsvpmaker-for-toastmasters').'</a></li>';
		$events = get_future_events("post_content LIKE '%[toastmaster%' AND ID != ".$post->ID, 10);
		if($events)
		foreach ($events as $event)
			$link .= '<li><a href="'.rsvpmaker_permalink_query($event->ID,'edit_roles=1').'">'.__('Edit','rsvpmaker-for-toastmasters').' '.strftime($rsvp_options["short_date"],strtotime($event->datetime)).'</a></li>';
		$link .= '<li class="last"><a href="'.$permalink.'">'.__('Stop Editing','rsvpmaker-for-toastmasters').'</a></li></ul></li>';
		}
	$link .= '<li class="has-sub"><a target="_blank" href="'.$permalink.'print_agenda=1">'.__('Agenda','rsvpmaker-for-toastmasters').'</a><ul> ';
	if(current_user_can($security['email_list']))
		$link .= '<li><a  target="_blank" href="'.$permalink.'print_agenda=1">'.__('Print','rsvpmaker-for-toastmasters').'</a></li>';
		$link .= '<li><a  target="_blank" href="'.$permalink.'email_agenda=1">'.__('Email','rsvpmaker-for-toastmasters').'</a></li>';
	$link .= '<li class="last"><a target="_blank" href="'.$permalink.'print_agenda=1&word_agenda=1">'.__('Export to Word','rsvpmaker-for-toastmasters').'</a></li>';
	$link .= '<li class="last"><a target="_blank" href="'.$permalink.'print_agenda=1&no_print=1">'.__('Show','rsvpmaker-for-toastmasters').'</a></li>';
	$link .= '<li class="last"><a href="'.$permalink.'assigned_open=1">'.__('Agenda with Contacts','rsvpmaker-for-toastmasters').'</a></li>';
	$link .= '<li class="last"><a target="_blank" href="'.$permalink.'intros=show">'.__('Speech Introductions','rsvpmaker-for-toastmasters').'</a></li></ul></li>';

	if(current_user_can($security['agenda_setup']))
		{
		$template_id = get_post_meta($post->ID,'_meet_recur',true);
		$agenda_time = get_option('agenda_time');
		
		$agenda_menu[__('Agenda Setup','rsvpmaker-for-toastmasters')] = admin_url('post.php?action=edit&post='.$post->ID);
		if($template_id)
			$agenda_menu[__('Agenda Setup: Template','rsvpmaker-for-toastmasters')] = admin_url('post.php?action=edit&post='.$template_id);
		if($agenda_time)
			{
			$agenda_menu[__('Agenda Timing','rsvpmaker-for-toastmasters')] = admin_url('edit.php?post_type=rsvpmaker&page=agenda_timing&post_id='.$post->ID);
			if($template_id)
				$agenda_menu[__('Agenda Timing: Template','rsvpmaker-for-toastmasters')] = admin_url('edit.php?post_type=rsvpmaker&page=agenda_timing&post_id='.$template_id);
			}
		$agenda_menu[__('Agenda Sidebar','rsvpmaker-for-toastmasters')] = $permalink.'edit_sidebar=1';
		$size = sizeof($agenda_menu);
		$linkcounter = 1;
		foreach($agenda_menu as $label => $agenda_link)
			{
				if($linkcounter == 1)
					{
					if($size == 1)
						$link .= sprintf('<li><a href="%s">%s</a></li>',$agenda_link, $label);
					else
						$link .= sprintf('<li class="has-sub"><a href="%s">%s</a><ul>',$agenda_link, $label);
					}
				else
					{
						if($linkcounter == $size)
							$link .= sprintf('<li class="last"><a href="%s">%s</a></li></ul></li>',$agenda_link, $label);
						else
							$link .= sprintf('<li><a href="%s">%s</a></li>',$agenda_link, $label);						
					}
				$linkcounter++;
			}
		}

	$link .= '<li class="last"><a  target="_blank" href="'.site_url('?signup2=1').'">'.__('Signup Sheet','rsvpmaker-for-toastmasters').'</a></li>';
	$link .= '</ul></div>';

if(isset($_GET["assigned_open"]) && current_user_can($security['edit_signups']))
	{
	$link .= "\n".sprintf('<div style="margin-top: 10px; margin-bottom: 10px;"><a href="%s">%s</a></div>',$permalink.'assigned_open=1&email_me=1',__('Email to me','rspmaker-for-toastmasters'))."\n";
	
	$link .= wp4t_assigned_open();
	}
if(isset($_POST["editor_suggest"]))
	{
		global $wpdb;
		global $current_user;
		$code = get_post_meta($post->ID,'suggest_code', true);
		if(!$code)
			{
				$code = wp_generate_password();
				update_post_meta($post->ID,'suggest_code',$code);
			}
		foreach($_POST["editor_suggest"] as $name => $value)
			{
			$count = (int) $_POST["editor_suggest_count"][$name];
			if($value < 1)
				continue;
			$invite_check = $value.":".$post->ID;
			if($_SESSION[$invite_check]) // prevent double notifications
				continue;
			$_SESSION[$invite_check] = 1;
			
			$date = get_rsvp_date($post->ID);
			$neatname = preg_replace('/[_\-0-9]/',' ',$name);
			$user = get_userdata($current_user->ID);
			$msg = sprintf('<p>Toastmaster %s %s %s %s %s %s</p>',$user->first_name,$user->last_name,__('has recomended you for the role of','rsvpmaker-for-toastmasters'),$neatname, __('for','rsvpmaker-for-toastmasters'),$date);
			$member = get_userdata($value);
			$email = $member->user_email;
			$hash = recommend_hash($name, $value);
			$url = $permalink.sprintf('key=%s&you=%s&code=%s&count=%s',$name,$value,$hash,$count);
			$msg .= sprintf("\n\n".__('<p>Click here to <a href="%s">ACCEPT</a> (no password required if you act before someone else takes this role)</p>','rsvpmaker-for-toastmasters'),$url);
			if(isset($_POST["editor_suggest_note"][$name]))
				$msg .= "\n\n<p><b>".__('Note from','rsvpmaker-for-toastmasters')." ".$user->first_name.' '.$user->last_name.": </b>".$_POST["editor_suggest_note"][$name].'</p>';
			$mail["html"] = $msg;
			$mail["to"] = $email;
			$mail["from"] = $user->user_email;
			$mail["cc"] = $user->user_email;
			$mail["fromname"] = $user->first_name." ".$user->last_name;
			$mail["subject"] = "You have been recommended for the role of ".$neatname.' on '.$date;
			awemailer($mail);
			$output = '<div style="background-color: #eee; border: thin solid #000; padding: 5px; margin-5px;">'.$msg.'<p><em>'.__('Sent by email to','rsvpmaker-for-toastmasters').' <b>'.$email."</b></em></p></div>";
			}
	}

if(isset($_POST["editor_assign"]) && current_user_can('edit_posts') )
	{
	global $wpdb;
	$wpdb->show_errors();
	$date = get_rsvp_date($post->ID);
	$results = get_future_events(" post_content LIKE '%[toastmaster%' AND meta_value > '$date' ",3);
	foreach($results as $row)
		{
		if(isset($row->eventdate))
			$eventdate = $row->eventdate;
		else
			$eventdate = date('F j',strtotime($row->datetime));
		$link .= sprintf('<div id="agenda_print"><a href="%s">'.__('Edit Agenda Roles for','rsvpmaker-for-toastmasters').' %s</a></div>',rsvpmaker_permalink_query($row->postID).'edit_roles=1',$eventdate);
		}
	
	}

	}

global $wpdb;
if(isset($_GET["rm"]))
{
$sql = "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key RLIKE '^_[A-Z].+[0-9]$' AND post_id=$post->ID";	
$results = $wpdb->get_results($sql);

$preassigned = array();
global $random_available;
$random_available = array();
foreach($results as $row)
{
if(is_numeric($row->meta_value))
	$preassigned[] = $row->meta_value;
}

$blogusers = get_users('blog_id='.get_current_blog_id() );
    foreach ($blogusers as $user) {		
	if(in_array($user->ID,$preassigned))
			continue;
	$userdata = get_userdata($user->ID);
	if($userdata->hidden_profile)
		continue;
	$random_available[] = $user->ID;
	}
shuffle($random_available);
}

return $output.$link.$content;

}

function pick_random_member($role) {
global $random_available;
global $last_attended;
global $last_filled;
$attempts = 0;
$last_filled_limit = get_option('last_filled_limit');
$last_attended_limit = get_option('last_attended_limit');
//$last_filled_limit = 28;
//$last_attended_limit = 90;
$assigned = array_shift($random_available);
if(!isset($last_filled[$role][$assigned]))
	{
	$last_filled[$role][$assigned] = last_filled_role($assigned, $role);
	$last_attended[$assigned] = get_latest_visit($assigned);
	}

if(!empty($last_attended_limit))
	{
	$last_attended_limit = strtotime($last_attended_limit.' days ago'); // turn into timestamp
	while(($last_attended[$assigned] == 'N/A') || ($last_attended_limit > strtotime($last_attended[$assigned])))
		{
		$assigned = array_shift($random_available);
		if(!isset($last_attended[$assigned]))
			{
			$last_filled[$role][$assigned] = last_filled_role($assigned, $role);
			$last_attended[$assigned] = get_latest_visit($assigned);
			}			
		$attempts++;
		if($attempts > 2)
			continue;
		}
	}
if(!empty($last_filled_limit))
	{
	$last_filled_limit = strtotime($last_filled_limit.' days ago'); // turn into timestamp
	$last_filled_stamp = strtotime($last_filled[$role][$assigned]);
	while(($last_filled[$role][$assigned] != 'N/A') && ($last_filled_stamp > $last_filled_limit))
		{
		array_push($random_available, $assigned); // add to the end, pick a new one from beginning
		$assigned = array_shift($random_available);
		if(!isset($last_filled[$role][$assigned]))
			{
			$last_filled[$role][$assigned] = last_filled_role($assigned, $role);
			$last_attended[$assigned] = get_latest_visit($assigned);
			}			
		$attempts++;
		if($attempts > 2)
			continue;
		}
	}
return $assigned;
}

function awesome_members($atts) {
ob_start();
global $wpdb;

$wp4toastmasters_officer_ids = get_option('wp4toastmasters_officer_ids');
$wp4toastmasters_officer_titles = get_option('wp4toastmasters_officer_titles');

$blogusers = get_users('blog_id='.get_current_blog_id() );
    foreach ($blogusers as $user) {		
	
	if(isset($atts["paid_only"]))
		{
		$paid = (int) get_user_meta($user->ID,'paid_until',true);
		if($paid < time())
			continue;
		}
		
	$userdata = get_userdata($user->ID);
	if($userdata->hidden_profile)
		continue;
	$index = preg_replace('/[^A-Za-z]/','',$userdata->last_name.$userdata->first_name.$userdata->user_login);

	if(is_array($wp4toastmasters_officer_ids) && in_array($user->ID,$wp4toastmasters_officer_ids))
		{
		$officers[array_search($user->ID,$wp4toastmasters_officer_ids) ] = $userdata;
		$officer_emails[] = $userdata->user_email;
		}
	else
		{
		$members[$index] = $userdata;
		$clubemails[] = $userdata->user_email;
		}
	}
	
	if(( isset($_GET["print_contacts"]) || is_admin() ) && is_array($members))
	{
	ksort($members);
	foreach($members as $userdata)
	{	
	if($userdata->user_login != '0_NOT_AVAILABLE' )
		print_display_member($userdata);
	}
	return;
	}

	if(is_club_member() )
		{
		echo '<p><em>'.__('Contact details such as phone numbers and email are only displayed when you are logged into the website (and should only be used for Toastmasters business)','rsvpmaker-for-toastmasters').'.</em></p>';
		if(current_user_can('view_contact_info'))
			echo '<p><em>'.__('Related','rsvpmaker-for-toastmasters').': <a href="'.site_url().'?print_contacts=1">'.__('Print Contact List','rsvpmaker-for-toastmasters').'</a></em></p>';
		}
	else
		printf( '<p><em>%s <a href="%s">%s</a>.</em></p>',__('These members have chosen to create public profiles. For an expanded listing, members may','rsvpmaker-for-toastmasters'),login_redirect($_SERVER['REQUEST_URI']), __('login','rsvpmaker-for-toastmasters'));
		
	if(!empty($officers) && is_array($officers))
	{
		ksort($officers);
		foreach($officers as $officer_index => $officer)
			display_member($officer,$wp4toastmasters_officer_titles[$officer_index]);
	}
	if(is_array($members))
	{
	ksort($members);
	foreach($members as $userdata)
		if($userdata->user_login != '0_NOT_AVAILABLE' )
		display_member($userdata);
	}

if(is_club_member())
		{
			if(!empty($officer_emails) && is_array($officer_emails) ) {
				$o = implode(',',$officer_emails);
			}
			if(!empty($clubemails) && is_array($clubemails) ) {
				$c = implode(',',$clubemails);
				if(isset($o))
					$c .= ','.$o;
				printf('<p><a href="mailto:%s?subject=Toastmasters">'.__('Email All','rsvpmaker-for-toastmasters').'</a></p>',$c );
			}
			if(isset($o))
				printf('<p><a href="mailto:%s?subject=Toastmasters">'.__('Email Officers','rsvpmaker-for-toastmasters').'</a></p>',$o );
		printf('<p><strong><em>%s</em></strong></p>',__('Email addresses and other contact information provided for Toastmasters business only.','rsvpmaker-for-toastmasters'));
		}

return ob_get_clean();
}

function display_member($userdata, $title='')
	 {
	global $post;

$contactmethods['home_phone'] = __("Home Phone",'rsvpmaker-for-toastmasters');
$contactmethods['work_phone'] = __("Work Phone",'rsvpmaker-for-toastmasters');
$contactmethods['mobile_phone'] = __("Mobile Phone",'rsvpmaker-for-toastmasters');
$contactmethods['facebook_url'] = __("Facebook Profile","rsvpmaker-for-toastmasters");
$contactmethods['twitter_url'] = __("Twitter Profile",'rsvpmaker-for-toastmasters');
$contactmethods['linkedin_url'] = __("LinkedIn Profile",'rsvpmaker-for-toastmasters');
$contactmethods['business_url'] = __("Business Web Address",'rsvpmaker-for-toastmasters');
$contactmethods['user_email'] = __("Email",'rsvpmaker-for-toastmasters');

$default_expires = date('Y-m-d',strtotime('+1 Month'));
	if(is_club_member() )
		$public_context = false;
	elseif(!empty($title) || strtolower(trim($userdata->public_profile)) == 'yes')
		$public_context = true;
	else
		return;
?>
<div class="member-entry" style="margin-bottom: 50px; clear: both;">
<?php
if(function_exists('has_wp_user_avatar') && has_wp_user_avatar($userdata->ID))
{
?>	
<div style="float: right; margin-left: 15px; width: 200px;">
<img src="<?php echo get_wp_user_avatar_src($userdata->ID, 96); ?>" alt=""  />
</div>
<?php
}
elseif(function_exists('userphoto_exists') && userphoto_exists($userdata))
{
?>	
<div style="float: right; margin-left: 15px; width: 200px;">
<?php
		userphoto($userdata);
?>
</div>
<?php
}
elseif(function_exists('bp_core_fetch_avatar')) {
{
$args = array('item_id' => $userdata->ID,'type' => 'full', no_grav => false);
$avatar = bp_core_fetch_avatar($args);
if(!strpos($avatar,'mystery') )
{
?>	
<div style="float: right; margin-left: 15px; width: 200px;">
<?php
if($avatar != 404)
	echo $avatar;
?>
</div>
<?php
}
}

}

if(!empty($title))
	printf('<h3 style="clear: none;">%s</h3>',$title);
?>
<p id="member_<?php echo $userdata->ID; ?>"><strong><?php echo $userdata->first_name.' '.$userdata->last_name?></strong> <?php if(!empty($userdata->education_awards)) echo '('.$userdata->education_awards.')'; ?></p>
<?php

	foreach($contactmethods as $name => $value)
		{
		if(strpos($name,'phone'))
			{
			if( (!$public_context) && current_user_can('view_contact_info') && $userdata->$name )
				printf("<div>%s: %s</div>",$value,$userdata->$name);
			}
		if(strpos($name,'url'))
			{
			if( $userdata->$name && strpos($userdata->$name,'://') )
				printf('<div><a target="_blank" href="%s">%s</a></div>',$userdata->$name,$value);
			}
		}
		
		if( ( !$public_context  && current_user_can('view_contact_info') ) || $userdata->public_email)
				{
				$clubemail[] = $userdata->user_email;
				printf('<div>'.__('Email','rsvpmaker-for-toastmasters').': <a href="mailto:%s">%s</a></div>',$userdata->user_email,$userdata->user_email);
				}
		
		if($userdata->user_description)
			echo wpautop('<strong>'.__('About Me','rsvpmaker-for-toastmasters').':</strong> '. add_implicit_links($userdata->user_description));
		
		if(!$public_context && function_exists('bp_get_user_last_activity') && !isset($_GET["email_prompt"]) )
			{
			printf('<p><strong>%s</strong> %s</p>',__('BuddyPress Profile','rsvpmaker-for-toastmasters'),bp_core_get_userlink( $userdata->ID ));
			}
		if( !$public_context && !isset($_GET["email_prompt"]) )
			{
			//get_user_meta($id,'status',true );
			$status = wp4t_get_member_status($userdata->ID);
			if(!empty($status))
				echo '<p>'.$status.'</p>';
			printf('<p><a href="%s">%s</a></p>',admin_url('profile.php?page=wp4t_set_status_form&member_id=').$userdata->ID,__('Set Away Message','rsvpmaker-for-toastmasters'));
			}
?>
</div>
<?php

}

add_shortcode('awesome_members','awesome_members');

function add_awesome_member() {

global $wpdb;
global $current_user;
$blog_id = get_current_blog_id();

if(isset($_POST["remove_user"])) {
	foreach($_POST["remove_user"] as $user_id)
		{
		remove_user_from_blog( $user_id, $blog_id );
		}
}

if(isset($_POST["member_ids"])) {
	foreach($_POST["member_ids"] as $user_login => $member_id)
		{
		$user = $_POST["verify"][$user_login];
		$user["member_id"] = $member_id;
		add_member_user($user);
		}
}

if(isset($_POST["spreadsheet"])) {
?>
<form method="post" action="<?php echo admin_url('users.php?page=add_awesome_member'); ?>">
<?php
$active_ids = array();
$lines = explode("\n", trim($_POST["spreadsheet"]));
$label = array();
foreach($lines as $linenumber => $line)
	{
	$cells = explode("\t",$line);
	if($linenumber == 0)
		{
		foreach($cells as $index => $cell)
			{
				$label[trim($cell)] = $index;
			}
		}
	else
	{
	if(empty($cells[0]))
		break;
	$user = array();
	if(isset($label["First Name"]))
		{
		$user["first_name"] = $cells[$label["First Name"]];
		$user["last_name"] = $cells[$label["Last Name"]];
		}
	elseif(isset($label["First"]))
		{
		$user["first_name"] = $cells[$label["First"]];
		$user["last_name"] = $cells[$label["Last"]];
		}
	elseif(isset($label["Name"]))
		{
			$user = name2fields($cells[$label["Name"]]);
		}

	if($cells[$label["Edu."]])
		$user["education_awards"] = $cells[$label["Edu."]];		
		
	if(isset($label["E-mail"]))
		$user["user_email"] = strtolower(trim($cells[$label["E-mail"]]));
	elseif(isset($label["Email"]))
		$user["user_email"] = strtolower(trim($cells[$label["Email"]]));
	if($user["user_email"] == strtolower(trim($current_user->user_email)))
		continue;
	
	$user["user_login"] = preg_replace('/[^a-z]/','',strtolower($user["first_name"].$user["last_name"]));
	$user["nickname"] = $user["display_name"] = $user["first_name"].' '.$user["last_name"];

	if(isset($label["Home Phone"]))
		$user["home_phone"] = $cells[$label["Home Phone"]];
	elseif(isset($label["Home"]))
		$user["home_phone"] = $cells[$label["Home"]];

	if(isset($label["Work Phone"]))
		$user["work_phone"] = $cells[$label["Work Phone"]];
	elseif(isset($label["Work"]))
		$user["work_phone"] = $cells[$label["Work"]];

	if(isset($label["Cell"]))
		$user["mobile_phone"] = $cells[$label["Cell"]];
	elseif(isset($label["Cell Phone"]))
		$user["mobile_phone"] = $cells[$label["Cell Phone"]];
	elseif(isset($label["Mobile Phone"]))
		$user["mobile_phone"] = $cells[$label["Mobile Phone"]];
	elseif(isset($label["Mobile"]))
		$user["mobile_phone"] = $cells[$label["Mobile"]];

	if(isset($label["Member #"]))
		$user["toastmasters_id"] = $cells[$label["Member #"]];
	elseif(isset($label["Member ID"]))
		$user["toastmasters_id"] = $cells[$label["Member ID"]];
	elseif(isset($label["ID"]))
		$user["toastmasters_id"] = $cells[$label["ID"]];
	elseif(isset($label["CustomerID"]))
		$user["toastmasters_id"] = $cells[$label["CustomerID"]];
	elseif(isset($label["Customer Id"]))
		$user["toastmasters_id"] = $cells[$label["Customer Id"]];
	
	$user["user_pass"] = password_hurdle(wp_generate_password());
	$active_ids[] = add_member_user($user);
	}
	//break;
	}
if(isset($_POST["check_missing"]))
	no_member_match ($active_ids);
?>
<input type="submit"  class="button-primary" value="<?php _e("Submit",'rsvpmaker-for-toastmasters');?>" />
</form>
<?php
}

if(isset($_POST["first_name"]) && $_POST["first_name"] && isset($_POST["last_name"]) && $_POST["last_name"])
	{
	$user["user_login"] = trim($_POST["user_login"]);
	$user["user_email"] = trim($_POST["email"]);
		$user["user_pass"] = $_POST["user_pass"];
		$user["first_name"] = $_POST["first_name"];
		$user["last_name"] = $_POST["last_name"];
		$user["nickname"] = $user["display_name"] = $_POST["first_name"].' '.$_POST["last_name"];
		$user["home_phone"] = $_POST["home_phone"];
		$user["work_phone"] = $_POST["work_phone"];
		$user["mobile_phone"] = $_POST["mobile_phone"];
		$user["toastmasters_id"] = (int) $_POST["toastmasters_id"];
		ob_start();
		add_member_user($user);
		$form = ob_get_clean();
		if( strpos($form,'member_ids') )
			{
?>
<form method="post" action="<?php echo admin_url('users.php?page=add_awesome_member'); ?>">
<?php
				echo $form;
?>
<input type="submit"  class="button-primary" value="<?php _e("Submit",'rsvpmaker-for-toastmasters');?>" />
</form>
<?php
			}
		else
			echo $form;
	}

$user_pass_default = password_hurdle(wp_generate_password());
?>

		<div class="wrap">
<div id="icon-users" class="icon32"><br /></div><h2 id="add-new-user"><?php _e("Add Member",'rsvpmaker-for-toastmasters');?></h2>

<div id="ajax-response"></div>

<p><?php _e("Create a website user account for a new member",'rsvpmaker-for-toastmasters');?>.</p>
<form action="<?php echo admin_url('users.php?page=add_awesome_member'); ?>" method="post" name="createuser" id="createuser" class="add:users: validate">
<input name="action" type="hidden" value="createuser" />
<input type="hidden" id="_wpnonce_create-user" name="_wpnonce_create-user" value="6f56987dd6" /><input type="hidden" name="_wp_http_referer" value="/wp-admin/user-new.php" /><table class="form-table">
	<tr class="form-field form-required">
		<th scope="row"><label for="user_login"><?php _e("Username",'rsvpmaker-for-toastmasters');?> <span class="description"></span></label></th>
		<td><input name="user_login" type="text" id="user_login" value="" aria-required="true" />
        <br /><?php _e("Hint: try the part of the email before the @ sign. If you leave this blank, a username will be assigned based on first and last name.",'rsvpmaker-for-toastmasters');?>
        <br /><?php _e("If a member does not have an email address, or shares an email address with someone else, leave the email field blank. Since WordPress requires an email address, a nonworking address will be assigned in the format firstnamelastname@example.com (example.com is an Internet domain name reserved for examples and tests).",'rsvpmaker-for-toastmasters');?>
        </td>
	</tr>
	<tr>
		<th scope="row"><label for="email"><?php _e("Email",'rsvpmaker-for-toastmasters');?></label></th>
		<td><input name="email" type="text" id="email" value="" /></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="first_name"><?php _e("First Name",'rsvpmaker-for-toastmasters');?> </label></th>
		<td><input name="first_name" type="text" id="first_name" value="" /></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="last_name"><?php _e("Last Name",'rsvpmaker-for-toastmasters');?> </label></th>
		<td><input name="last_name" type="text" id="last_name" value="" /></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="home_phone"><?php _e("Home Phone",'rsvpmaker-for-toastmasters');?> </label></th>
		<td><input name="home_phone" type="text" id="home_phone" value="" /></td>
	</tr>

	<tr class="form-field">
		<th scope="row"><label for="work_phone"><?php _e("Work Phone",'rsvpmaker-for-toastmasters');?> </label></th>
		<td><input name="work_phone" type="text" id="work_phone" value="" /></td>
	</tr>

	<tr class="form-field">
		<th scope="row"><label for="mobile_phone"><?php _e("Mobile Phone",'rsvpmaker-for-toastmasters');?> </label></th>
		<td><input name="mobile_phone" type="text" id="mobile_phone" value="" /></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="first_name"><?php _e("Toastmasters ID #",'rsvpmaker-for-toastmasters');?> </label></th>
		<td><input name="toastmasters_id" type="text" id="toastmasters_id" value="" /></td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="user_pass"><?php _e("Password",'rsvpmaker-for-toastmasters');?> </label></th>
		<td><input name="user_pass" type="text" id="user_pass" value="<?php echo $user_pass_default; ?>" /></td>
	</tr>

	</table>
<p><input type="checkbox" name="no_email" value="1" /> <?php _e("Do not send email invites (for example, if you are still testing the site).",'rsvpmaker-for-toastmasters');?></p> 

<p class="submit"><input type="submit" name="createuser" id="createusersub" class="button-primary" value="<?php _e("Add Member",'rsvpmaker-for-toastmasters');?>"  /></p>
</form>
<div id="import">
<h3><?php _e("Batch Import From Toastmasters.org spreadsheet",'rsvpmaker-for-toastmasters');?></h3>
<p><?php _e("If you download the member spreadsheet from toastmasters.org, you should be able to copy the cells including member data (including the header row of column labels) and paste it here (use Ctrl-V on Windows).",'rsvpmaker-for-toastmasters');?></p>
<form method="post" action="<?php echo admin_url('users.php?page=add_awesome_member'); ?>">
<textarea cols="80" rows="10" name="spreadsheet"></textarea>
<br /><input type="checkbox" name="check_missing" value="1" /> <?php _e("Check for missing members (if you post a complete list of current members, this checkbox triggers a check of which website users are NOT currently on the toastmasters.org list and gives you an option to delete them).",'rsvpmaker-for-toastmasters');?>
<br /><input type="checkbox" name="no_email" value="1" /> <?php _e("Do not send email invites (for example, if you are still testing the site).",'rsvpmaker-for-toastmasters');?>
<br /><input type="submit" value="<?php _e("Post",'rsvpmaker-for-toastmasters');?>" />
</form>
<p><img src="<?php echo plugins_url( 'spreadsheet.png' , __FILE__ ); ?>" width="500" height="169" /></p>
</div>

</div>

<?php
}

function extract_fields_tm($matches) {
// used with paste from HTML display on toastmasters.org
foreach ($matches[1] as $index => $webfield)
	{
		if($webfield == 'Email')
			{
			$contact['user_email'] = trim($matches[2][$index]);
			$ep = explode('@',$contact['user_email']);
			}
		else
			{
			$phone = trim($matches[2][$index]);
			$phone = str_replace(' ','',$phone);
			$phone = str_replace('1(','(',$phone);
			if($webfield == 'Home')
				$contact['home_phone'] = $phone;
			elseif($webfield == 'Work')
				$contact['work_phone'] = $phone;
			elseif($webfield == 'Cell')
				$contact['mobile_phone'] = $phone;
			}
	}
	return $contact;
}

function name2fields($name) {
$edpattern = "/, ([A-Z]{2,4})/";
preg_match_all($edpattern,$name,$matches);
$user["nickname"] = $user["display_name"] = preg_replace($edpattern,'',$name);
$np = explode(" ",$user["display_name"]);
$user["last_name"] = array_pop($np);
$user["first_name"] = implode(" ",$np);
if($matches[1][0])
	$user["education_awards"] = implode(", ",$matches[1]); 
return $user;
}

function get_user_by_tmid($id) {
$args = array( 
  'meta_key' =>  'toastmasters_id',
   'meta_compare' => '=',
   'meta_value' => $id
);
$users = get_users($args);
return $users[0];
}

function add_member_user($user, $override_check = false) {

	global $wpdb;
	$blog_id = get_current_blog_id();
	
	$welcome = '';
	$w = get_option('wp4toastmasters_welcome_message');
	if(!empty($w))
		{
		$p = get_post($w);
		$welcome = '<h1>'.$p->post_title."</h1>\n\n".wpautop($p->post_content);
		}

	foreach($user as $name => $value)
		$user[$name] = trim($value);	
	if(empty($user["first_name"]) || empty($user["last_name"]))
		return;

	if(!isset($user["user_login"]) || empty($user["user_login"]) )
		$user["user_login"] = preg_replace('/[^a-z]/','',strtolower($user["first_name"].$user["last_name"]));
	if(empty($user["user_login"]))
		return;

	if(empty($user["user_email"]))
		$user["user_email"] = $user["user_login"].'@example.com';
	if(empty($user["user_pass"]))
		$user["user_pass"] = wp_generate_password();
	
	if(!empty($user["member_id"]))
		{
		$member_id = (int) $user["member_id"];
		$member_exists = get_user($member_id);
		}
	else
	{
	if(!empty($user["toastmasters_id"]))
	{
	$user["toastmasters_id"] = (int) $user["toastmasters_id"]; // get rid of any zero padding
	$member_exists = get_user_by_tmid($user["toastmasters_id"]);
	printf('<p>Member found by toastmasters ID: %s %s</p>',$user["first_name"],$user["last_name"]);
	}
	
	if(isset($member_exists->ID) && $member_exists->ID)
		{
		$member_id = $member_exists->ID;
		}
	else
		{
		$login_exists = get_user_by('login',$user["user_login"] );
		$email_exists = get_user_by('email',$user["user_email"] );
		if( ($login_exists && $email_exists) && ($login_exists->ID == $email_exists->ID) )
			{
				$member_id = $login_exists->ID; // clearly the same person
			}
		else
			{
				
			if($login_exists)
				{
				$data = get_userdata($login_exists->ID);
				$seek = true;
				$i = 1;
				while($seek)
					{
						$newlogin = $user["user_login"] . $i;
						$i++;
						if(!get_user_by('login',$newlogin))
							{
							$user["user_login"] = $newlogin;
							$seek = false;
							}
					}
				$possible_match[$data->ID] = sprintf('<option value="%d">%s %s %s</option>',$data->ID,$data->display_name,$data->user_login, $data->user_email);
				}
			if($email_exists)
				{
				$user["user_email"] = $user["user_login"].'@example.com';
				$data = get_userdata($email_exists->ID);
				$possible_match[$data->ID] = sprintf('<option value="%d">%s %s %s</option>',$data->ID,$data->display_name,$data->user_login, $data->user_email);
				}
			
			// anyone have the same last name?
			$args = array( 
			  'meta_key' =>  'last_name',
			   'meta_compare' => '=',
			   'meta_value' => $user["last_name"]
			);
			$same_last_name = get_users($args);
			if($same_last_name && !$override_check)
			{
			foreach($same_last_name as $exists)
				{
				$data = get_userdata($exists->ID);
				$possible_match[$data->ID] = sprintf('<option value="%d">%s %s %s</option>',$data->ID,$data->display_name,$data->user_login, $data->user_email);
				}
			}
			
			if(!isset($user["ID"]) && !empty($possible_match))
				{
				echo '<h3>'.__('New or existing member?','rsvpmaker-for-toastmasters').'</h3>';
				echo '<p>'.__('If you match this entry with an existing member, their Toastmasters ID will be added to their record to make this easier to sync next time. If this person is a new member, an account will be created using the information below.','rsvpmaker-for-toastmasters').'</p>';
				printf('<div><select name="member_ids[%s]"><option value="0">New Member</option>%s</select></div>',$user["user_login"],implode('',$possible_match) );
				foreach($user as $field => $value)
					{
					printf('<div>%s: %s<input type="hidden" name="verify[%s][%s]" value="%s"></div>',$field,stripslashes($value),$user["user_login"],$field,stripslashes($value));
					if(strpos($value,'@example.com') )
						echo "<div><em>".__('When no email is supplied, or the same email is in use by another member/user, an example.com fake email address is generated to fill that required field. This is an internet domain reserved for examples and tests.','rsvpmaker-for-toastmasters').'</em></div>';
					}
				return;					
				}
			}
		}
	} // end no member ID submitted
	
	//$incpath = trailingslashit(str_replace('content','includes',WP_CONTENT_DIR));
	//include_once $incpath.'registration.php';	

	if(!is_email($user["user_email"]) && !strpos($user["user_email"],'example.com') )
		 {
		echo '<h3 style="color: red;">'.__('Error: invalid email address','rsvpmaker-for-toastmasters').' '.$user["user_email"].'</h3>';
		 return;
		 }
	elseif(!empty($member_id))
		{
		if(!is_user_member_of_blog( $member_id, $blog_id ) && !user_can($member_id,'manage_options') )
			{
			add_user_to_blog($blog_id, $member_id,'subscriber');
			echo '<p>'.__('Adding user to this site','rsvpmaker-for-toastmasters').'.</p>';
			}
		if(!empty($user["toastmasters_id"]) && !get_user_meta($member_id,'toastmasters_id',true) )
			{
			printf('<p>Adding Toastmasters ID for: %s %s</p>',$user["first_name"],$user["last_name"]);			
			update_user_meta($member_id,"toastmasters_id",$user["toastmasters_id"]);
			}
		if(!empty($user["education_awards"]))
			{
			printf('<p>Updating educational awards for: %s %s</p>',$user["first_name"],$user["last_name"]);			
			update_user_meta($member_id,"educational_awards",$user["educational_awards"]);
			}
		return $member_id;
		}
	else
		{
		//register user
		if(isset($user["ID"]))
			{
				$former_id = $user["ID"];
				unset($user["ID"]);
			}
		if($user_id = wp_insert_user($user))
			{
			if(isset($former_id))
				{
					$wpdb->query('UPDATE '.$wpdb->users.' SET ID='.$former_id.' WHERE ID='.$user_id);
					$wpdb->query('UPDATE '.$wpdb->usermeta.' SET user_id='.$former_id.' WHERE user_id='.$user_id);
					$user_id = $former_id;
				}
    // Generate something random for a password reset key.
    $key = wp_generate_password( 20, false );
 
    /** This action is documented in wp-login.php */
    do_action( 'retrieve_password_key', $user["user_login"], $key );
 
    // Now insert the key, hashed, into the DB.
    if ( empty( $wp_hasher ) ) {
        require_once ABSPATH . WPINC . '/class-phpass.php';
        $wp_hasher = new PasswordHash( 8, true );
    }
    $hashed = time() . ':' . $wp_hasher->HashPassword( $key );
    $wpdb->update( $wpdb->users, array( 'user_activation_key' => $hashed ), array( 'user_login' => $user["user_login"] ) );
    $set_password_msg = __('To set your password, visit the following address:');
    $set_password = site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user["user_login"]), 'login');

				$profile_url = admin_url('profile.php#user_login');
				$message = '<p>'.__('You have been registered at').': '.site_url().'</p>';
				$message .= '<p>'.__('Username').': '.$user["user_login"].'</p>';
				$message .= '<p>'. $set_password_msg .'<br /><a href="'.$set_password.'">'.$set_password.'</a></p>';
				$message .= '<p>'.__('For a basic orientation to the website setup we are using, see the <a href="http://wp4toastmasters.com/new-member-guide-to-wordpress-for-toastmasters/">New Member Guide to WordPress for Toastmasters</a>','rsvpmaker-for-toastmasters').'</p>';
			if(isset($_POST["no_email"]) && $_POST["no_email"])
			{
			echo "<h3>".__('Email notification disabled','rsvpmaker-for-toastmasters')."</h3><pre>".$message."</pre>";
			}
			else
			{
			$admin_email = get_bloginfo('admin_email');
			$mail["subject"] = 'Welcome to '.get_bloginfo('name');
			$mail["replyto"] = $admin_email;
			$mail["html"] = "<html>\n<body>\n".$message.$welcome."\n</body></html>";
			$mail["to"] = $user["user_email"];
			$mail["cc"] = $admin_email;			
			$mail["from"] = $admin_email;
			$mail["fromname"] = get_bloginfo('name');
			$return = awemailer($mail);
			if($return === false)
				echo "<h3>".__('Emailing notifications disabled','rsvpmaker-for-toastmasters')."</h3><pre>".$message."</pre>";			
			else	
				echo "<h3>".__('Emailing to','rsvpmaker-for-toastmasters')." ".$user["user_email"]."</h3><pre>".$message."</pre>";
			}
						
			}
		else
			 {
			echo '<h3 style="color: red;">WordPress '.__('registration error','rsvpmaker-for-toastmasters').'</h3>';
			print_r($user);
			echo "<br />";
			 }
		}

return $user_id;
}

function no_member_match ($active_ids) {
global $current_user;
$active_ids[] = $current_user->ID;
?>
<h3><?php _e("No Match",'rsvpmaker-for-toastmasters');?></h3>
<p><?php _e("The members below don't show up on the current list. Check those who should be deleted.",'rsvpmaker-for-toastmasters');?></p>
<?php

$blogusers = get_users('blog_id='.get_current_blog_id() );
    foreach ($blogusers as $user) {		
	if(!in_array($user->ID, $active_ids) )
		{
		if($user->user_login == '0_NOT_AVAILABLE')
			continue;
		$userdata = get_userdata($user->ID);
		printf('<p><input type="checkbox" name="remove_user[%d]" value="%d"> %s (%s) </p>',$user->ID, $user->ID, $userdata->display_name, $userdata->user_login);
		}
	}
}

function awesome_contactmethod( $contactmethods ) {

$contactmethods['home_phone'] = __("Home Phone",'rsvpmaker-for-toastmasters');
$contactmethods['work_phone'] = __("Work Phone",'rsvpmaker-for-toastmasters');
$contactmethods['mobile_phone'] = __("Mobile Phone",'rsvpmaker-for-toastmasters');
$contactmethods['facebook_url'] = __("Facebook Profile","rsvpmaker-for-toastmasters");
$contactmethods['twitter_url'] = __("Twitter Profile",'rsvpmaker-for-toastmasters');
$contactmethods['linkedin_url'] = __("LinkedIn Profile",'rsvpmaker-for-toastmasters');
$contactmethods['business_url'] = __("Business Web Address",'rsvpmaker-for-toastmasters');
$contactmethods['toastmasters_id'] = "Toastmasters ID";
$contactmethods['education_awards'] = "Educational Awards";
//$contactmethods['user_email'] = __("Email",'rsvpmaker-for-toastmasters');

  // Remove Yahoo IM
  unset($contactmethods['yim']);
  unset($contactmethods['aim']);
  unset($contactmethods['jabber']);
  unset($contactmethods['url']);
  return $contactmethods;
}

function login_redirect($link) {
if( is_club_member() )
	return $link;
else
	return site_url().'/wp-login.php?redirect_to='.urlencode($link);
}


/**
 * CPEventsWidget Class
 */
class AwesomeWidget extends WP_Widget {
    /** constructor */
    function __construct() {
        parent::__construct('rsvptoast_widget', $name = 'Member Access');	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {		
	  global $wpdb;
        extract( $args );
		$instance = apply_filters('tm_widget_settings',$instance);
		$title = (isset($instance["title"])) ? $instance["title"] : 'Member Access';
		$limit = (isset($instance["limit"])) ? $instance["limit"] : 10;
		$showmore = (isset($instance["showmore"])) ? $instance["showmore"] : 4;
		$showlog = (isset($instance["showlog"])) ? $instance["showlog"] : 1;
		$dateformat = (isset($instance["dateformat"]) && strpos($instance["dateformat"],'%s') ) ? $instance["dateformat"] : '%b %e';
		if($showlog)
			{
			$activity_sql = "SELECT meta_value from $wpdb->postmeta JOIN $wpdb->posts ON $wpdb->postmeta.post_id = $wpdb->posts.ID WHERE meta_key='_activity' ORDER BY meta_id DESC LIMIT 0,5";
			$log = $wpdb->get_results($activity_sql);
			}
		else
			$log = false;
		
        global $rsvp_options;
		;?>
              <?php echo $before_widget;?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title;?>
              <?php 
			  $dates = future_toastmaster_meetings($limit);
			  echo "\n<ul>\n";
			  if($dates)
			  {
			  foreach($dates as $row)
			  	{				
				
				if(isset($ev[$row->postID]))
					$ev[$row->postID] .= ", ".strftime($dateformat,strtotime($row->datetime) );
				else
					{
					$t = strtotime($row->datetime);
					$title = $row->post_title .' '. strftime($dateformat,$t );
					$permalink = get_permalink($row->postID);
					if(!isset($signup))
						$signup = login_redirect($permalink);
					$ev[ $row->postID ] = sprintf('<a href="%s">%s', login_redirect($permalink), $title);
					}
				}
			  }// end if dates
			//pluggable function widgetlink can be overridden from custom.php
			if(isset($ev) && !empty($ev) )
			{
			
			echo '<li class="widgetrsvpview"><a href="'.get_post_type_archive_link( 'rsvpmaker' ).'">'.__('View Upcoming Events','rsvpmaker-for-toastmasters').'</a></li>';
			
			echo '<li class="widgetsignup">'.__('Member sign up for roles','rsvpmaker-for-toastmasters').":";			
			$class = '';
			$count = 1;
			  foreach($ev as $id => $e)
			  	{
			  	printf('<div %s>%s</a></div>',$class, $e);
				if($count == $showmore)
					$class = ' class="moremeetings" ';
				$count++;
				}
			if(sizeof($ev) > $showmore)
				echo '<div id="showmorediv"><a href="#" id="showmore">'.__('Show More','rsvpmaker-for-toastmasters').'</a></div>';
			echo "</li>";
			}
			
			echo "<li>".__('Your membership','rsvpmaker-for-toastmasters').":";			
			  if( is_club_member() )
				  {
				  printf('<div><a href="%s">'.__('Edit Member Profile','rsvpmaker-for-toastmasters').'</a></div>',login_redirect(admin_url('profile.php#user_login')));

printf('<div><a href="%s">%s</a></div>',admin_url('profile.php?page=wp4t_set_status_form'),__('Set Away Message','rsvpmaker-for-toastmasters'));

				  printf('<div><a href="%s">'.__('Member Dashboard','rsvpmaker-for-toastmasters').'</a></div>',login_redirect(admin_url('index.php')) );
				if(function_exists('bp_core_get_userlink'))
					{
					global $current_user;
				  	printf('<div><a href="%s#whats-new-form">'.__('Post to Social Profile','rsvpmaker-for-toastmasters').'</a></div>',bp_core_get_userlink($current_user->ID,false,true) );
				  	printf('<div><a href="%sprofile/change-avatar/#avatar-upload-form">'.__('Change Profile Photo','rsvpmaker-for-toastmasters').'</a></div>',bp_core_get_userlink($current_user->ID,false,true) );
					}
				  }
			  else
				printf('<div><a href="%s">'.__('Login','rsvpmaker-for-toastmasters').'</a></div>',login_redirect(site_url()) );							
			echo "</li>";
			  
			 if(isset($log) && !empty($log) )
			 {
			  echo "<li><strong>".__('Activity','rsvpmaker-for-toastmasters')."</strong><br />";
			  foreach($log as $row)
			  	echo "<div>".$row->meta_value . "</div>";
			  echo "</li>";
			  }
			do_action('awesome_widget_bottom');
			  echo "\n</ul>\n";
			
						  
			  echo $after_widget;?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['dateformat'] = strip_tags($new_instance['dateformat']);
	$instance['limit'] = (int) $new_instance['limit'];
	$instance['showmore'] = (int) $new_instance['showmore'];
	$instance['showlog'] = (int) $new_instance['showlog'];
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {				
		$title = (isset($instance["title"])) ? $instance["title"] : 'Member Access';
        $title = apply_filters('tm_widget_title', $title);
        $title = esc_attr($title);
		$limit = (isset($instance["limit"])) ? $instance["limit"] : 10;
		$showmore = (isset($instance["showmore"])) ? $instance["showmore"] : 4;
		$showlog = (isset($instance["showlog"])) ? $instance["showlog"] : 1;
		$dateformat = (isset($instance["dateformat"])) ? $instance["dateformat"] : '%b %e';
        ;?>
            <p><label for="<?php echo $this->get_field_id('title');?>"><?php _e('Title:','rsvpmaker-for-toastmasters');?> <input class="widefat" id="<?php echo $this->get_field_id('title');?>" name="<?php echo $this->get_field_name('title');?>" type="text" value="<?php echo $title;?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('limit');?>"><?php _e('Number to Show:','rsvpmaker-for-toastmasters');?> <input class="widefat" id="<?php echo $this->get_field_id('limit');?>" name="<?php echo $this->get_field_name('limit');?>" type="text" value="<?php echo $limit;?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('showmore');?>"><?php _e('Show More Link After:','rsvpmaker-for-toastmasters');?> <input class="widefat" id="<?php echo $this->get_field_id('showmore');?>" name="<?php echo $this->get_field_name('showmore');?>" type="text" value="<?php echo $showmore;?>" /></label></p>
            <p><label for="<?php echo $this->get_field_id('showmore');?>"><?php _e('Show Member Activity Log:','rsvpmaker-for-toastmasters');?> <input class="widefat" id="<?php echo $this->get_field_id('showlog');?>" name="<?php echo $this->get_field_name('showlog');?>" type="radio" value="1" <?php if($showlog) echo ' checked="checked" ';?> /> <input class="widefat" id="<?php echo $this->get_field_id('showlog');?>" name="<?php echo $this->get_field_name('showlog');?>" type="radio" value="0" <?php if(!$showlog) echo ' checked="checked" ';?> /></label></p>

            <p><label for="<?php echo $this->get_field_id('dateformat');?>"><?php _e('Date Format:','rsvpmaker-for-toastmasters');?> <input class="widefat" id="<?php echo $this->get_field_id('dateformat');?>" name="<?php echo $this->get_field_name('dateformat');?>" type="text" value="<?php echo $dateformat;?>" /></label> (<?php _e('PHP <a target="_blank" href="http://us2.php.net/manual/en/function.date.php">date</a> format string','rsvpmaker-for-toastmasters');?>)</p>

        <?php 
    }

} // class AwesomeWidget

function awesome_roles() {
global $wp_roles;
$wp_roles->add_cap('contributor','upload_files');
}


//translate
function edit_toast_roles( $content ) {
global $post;
global $current_user;
if(isset($_POST["_tm_sidebar"]))
	tm_sidebar_post($post->ID);
if(isset($_GET["edit_sidebar"]))
	{
	$sidebar_editor = agenda_sidebar_editor($post->ID);
return sprintf('<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script> 
<script>
        tinymce.init({selector:"textarea.mce",plugins: "code"});		
</script>
<form id="edit_roles_form" method="post" action="%s"">
%s<button class="save_changes">'.__("Save Changes",'rsvpmaker-for-toastmasters').'</button><input type="hidden" name="post_id" id="post_id" value="%d"><input type="hidden" id="toastcode" value="%s"></form>%s',rsvpmaker_permalink_query($post->ID),$sidebar_editor,$post->ID,wp_create_nonce( "rsvpmaker-for-toastmasters" ),$content);
	}	
if(!isset($_GET["edit_roles"]) || !current_user_can('edit_signups') )
	return $content;
if(current_user_can('agenda_setup'))
$content .= sprintf('<p><a href="%sedit_sidebar=1">%s</a></p>',rsvpmaker_permalink_query($post->ID),__('Edit Sidebar','rsvpmaker-for-toastmasters'));//agenda_sidebar_editor($post->ID);

return sprintf('<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script> 
<script>
        tinymce.init({selector:"textarea.mce",plugins: "code"});		
</script>
<form id="edit_roles_form" method="post" action="%s"">
<p><em>'.__("Edit signups and click <b>Save Changes</b> as the bottom of the form.",'rsvpmaker-for-toastmasters').' <a href="%s?edit_roles=1&rm=1">'.__('Show random assignments','rsvpmaker-for-toastmasters').'</a></em><p>
%s<button class="save_changes">'.__("Save Changes",'rsvpmaker-for-toastmasters').'</button><input type="hidden" name="post_id" id="post_id" value="%d"><input type="hidden" id="toastcode" value="%s"></form>',rsvpmaker_permalink_query($post->ID),rsvpmaker_permalink_query($post->ID),$content,$post->ID,wp_create_nonce( "rsvpmaker-for-toastmasters" ));
}

function recommend_hash($role, $user) {
global $post;
return md5($role.$user.$post->ID);
}

function accept_recommended_role() {
// key=General_Evaluator-1&you=31&code=eZHuvRnuvb^(
global $post;
if(!isset($post) || ($post->post_type != 'rsvpmaker'))
	return;
$permalink = rsvpmaker_permalink_query($post->ID);
$custom_fields = get_post_custom($post->ID);
if(isset($_GET["key"]) && isset($_GET["you"]) && isset($_GET["code"]))
	{
		$you = (int) $_GET["you"];
		$hash = recommend_hash($_GET["key"], $you);
		$count = (int) $_GET["count"];
		$key = preg_replace('/[0-9]/','',$_GET["key"]);
		if($hash != $_GET["code"])
			{
			header("Location: ".$permalink."recommendation=code_error");
			exit();
			}
		$success = false;
		for($i =1; $i <= $count; $i++)
			{
				$name = $key.$i;
				if($custom_fields[$name][0])
					; //echo "<p>Role is taken</p>";
				else
					{
					update_post_meta($post->ID, $name, $you);
					$success = true;
					break;
					}
			}
	if($success)
		header("Location: ".$permalink."recommendation=success");
	else
		header("Location: ".$permalink."recommendation=oops");
	exit();
	}
}

function assign_toast_roles( $content ) {
if(!isset($_GET["recommend_roles"]) || !current_user_can('edit_posts') )
	return $content;
global $post;
global $current_user;
global $wpdb;
global $rsvp_options;
$output = '';

$permalink = rsvpmaker_permalink_query($post->ID);

	$date = get_rsvp_date($post->ID);
$output .= sprintf('<form id="edit_roles_form" method="post" action="%s">
<p><em>'.__("This form lets you recommend that an individual member take a specific speaking slot or other role (the member will get an email with a coded link for one-click role signup. Make your selections and click <b>Save Changes</b> at the bottom of the form.",'rsvpmaker-for-toastmasters').' <a href="%s?recommend_roles=1&rm=1">'.__('Show random assignments','rsvpmaker-for-toastmasters').'</a></em><p>
%s<button class="save_changes">'.__("Save Changes",'rsvpmaker-for-toastmasters').'</button><input type="hidden" name="post_id" id="post_id" value="%d"></form>',$permalink,$permalink,$content,$post->ID);

return $output;

}

function signup_sheet() {

if(isset($_GET["signup"]) || isset($_GET["signup2"]))
	{
	global $wpdb;
	global $rsvp_options;
	global $post;
	$limit = get_option('tm_signup_count');
	if(empty($limit))
		$limit = 3;
	$sql = "SELECT a1.meta_value as datetime
	 FROM ".$wpdb->posts."
	 JOIN ".$wpdb->postmeta." a1 ON ".$wpdb->posts.".ID =a1.post_id AND a1.meta_key='_rsvp_dates'
	 WHERE a1.meta_value > CURDATE() AND (post_status='publish' OR post_status='draft') AND  post_content LIKE '%[toastmaster %' ORDER BY a1.meta_value";
	$next = $wpdb->get_var($sql);
		
	$dates = get_future_events("a1.meta_value > '$next' AND post_content LIKE '%[toastmaster %' ",$limit);
	$head = $cells = '';
	$datecount = 0;
	foreach($dates as $date)
		{
		$t = strtotime($date->datetime);

		$post = get_post($date->postID);
		$head .= "<th>".date("F j",$t)."</th>";
		preg_match_all('/\[toastmaster.+\]/',$post->post_content,$matches);
		$filtered = implode("\n",$matches[0]); // filter out all content other than role signups
		$cells .= "<td>".do_shortcode($filtered)."</td>";
		$datecount++;
		if($datecount == $limit)
			break;
		}
	
	$colwidth = floor(100 / $limit);
	
	echo "<html><head>
	<style>
	table {
	width: 100%;
	}
	th {
	font-size: 14px;
	font-weight: bold;
	text-align: center;
	}
	td, th {
	padding: 3px;
	margin: 2px;
	/* border: thin solid #000; */
	width: ".$colwidth."%;
	vertical-align: top;
	}
	.signuprole {
	font-size: 10px;
	border: thin solid #000;
	margin-bottom: 2px;
	font-weight: bold;
	}
	.assignedto {
	font-size: 14px;
	border-bottom: thin solid #000;
	padding-bottom: 10px;
	font-weight: normal;
	}
	</style>
	</head><body><table><tr>".$head."</tr><tr>".$cells."</tr></table></body></html>";
	exit();
	}

}

function future_toastmaster_meetings ($limit = 10) {

global $wpdb;
$wpdb->show_errors();
	$sql = "SELECT DISTINCT $wpdb->posts.ID as postID, $wpdb->posts.*, a1.meta_value as datetime, a1.meta_value as datetime, date_format(a1.meta_value,'%M %e, %Y') as date
	 FROM ".$wpdb->posts."
	 JOIN ".$wpdb->postmeta." a1 ON ".$wpdb->posts.".ID =a1.post_id AND a1.meta_key='_rsvp_dates'
	 WHERE a1.meta_value > DATE_SUB(NOW(),INTERVAL 4 HOUR) AND post_status='publish' AND post_content LIKE '%[toastmaster %'";
	$sql .= ' ORDER BY a1.meta_value ';
	 if( !empty($limit) )
		$sql .= ' LIMIT 0,'.$limit.' ';
	$r = $wpdb->get_results($sql);
	if(!empty($_GET["debug_sql"]))
		{
		echo $sql;
		print_r($r);
		}
	return $r;
}

function awesome_open_roles($post_id = NULL) {

if(!is_club_member())
	return;

if(!isset($_GET["open_roles"]) && !$post_id)
	return;

global $wp_filter;
$corefilters = array('convert_chars','wpautop','wptexturize');
foreach($wp_filter["the_content"] as $priority => $filters)
	foreach($filters as $name => $details)
		{
		//keep only core text processing or shortcode
		if(!in_array($name,$corefilters) && !strpos($name,'hortcode'))
			{
			$r = remove_filter( 'the_excerpt', $name, $priority );
			$r = remove_filter( 'the_content', $name, $priority );
			}
		}
global $post;
the_post();
$content = wpautop(do_shortcode($post->post_content));
	
	global $wpdb;
	global $rsvp_options;
	global $current_user;
	global $open;
	if(!$post_id)
		$post_id = (int) $_GET["open_roles"];
	$permalink = rsvpmaker_permalink_query($post_id);
	$row = get_rsvp_event(" ID = $post_id ");

	if(get_option('wp4toastmasters_agenda_timezone'))
		$time_format = $rsvp_options["long_date"].' at '.$rsvp_options["time_format"];
	else
		$time_format = $rsvp_options["long_date"];
	fix_timezone();
	$date = strftime($time_format, strtotime($row->datetime) );
	
	$header = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
';
	$output = '';
	$openings = 0;
	if($open)
		{
		$output .= "<h3>".__("Open Roles",'rsvpmaker-for-toastmasters')."</h3>\n<p>";

		foreach($open as $role => $count)
			{
			$output .=  $role;
			if($count > 1)
				$output .=  " (".$count.")";
			$output .=  "<br />\n";
			$openings += $count;
			}
		$output .= "</p>\n<p>".__("Sign up at",'rsvpmaker-for-toastmasters')." <a href=\"" . $permalink. "\">" . $permalink. "</a></p>\n<p>".__("Forgot your password?",'rsvpmaker-for-toastmasters')." <a href=\"".site_url('/wp-login.php?action=lostpassword')."\">".__("Reset your password here",'rsvpmaker-for-toastmasters')."</a></p>\n<h3>".__("Roster",'rsvpmaker-for-toastmasters')."</h3>\n";
		}
//	print_r($open);
	$output .=  $content;

$wp4toastmasters_mailman = get_option("wp4toastmasters_mailman");

	if($_POST)
	{
	
	if(!empty($wp4toastmasters_mailman["members"]))
		$mail["to"] = $wp4toastmasters_mailman["members"];
	else
		{
		$blogusers = get_users('blog_id='.get_current_blog_id() );
			foreach ($blogusers as $user) {
				//print_r($user);
				$emails[] = $user->user_email;
			}
		}
	
	if(isset($_POST["note"]) && $_POST["note"])
		$output = stripslashes($_POST["note"])."\n".$output;		
	$mail["html"] = $header. $output . '</body></html>';
	$mail["from"] = $current_user->user_email;
	$mail["fromname"] = $current_user->display_name;
	$mail["subject"] = stripslashes($_POST["subject"]);
	if(is_array($emails))
	{
		foreach($emails as $e)
		{
		$mail["to"] = $e;
		echo awemailer($mail);
		}
	}
	else
		echo awemailer($mail);
	}
	else
	{
	$subject = __("Agenda for",'rsvpmaker-for-toastmasters').' '.$date;
	if($openings)
		$subject .= " (".$openings." ".__("open roles",'rsvpmaker-for-toastmasters').")";
	if(empty($wp4toastmasters_mailman["members"]))
		$subject = get_bloginfo('name').' '.$subject;

	$mailform = '<h3>'.__("Add a Note",'rsvpmaker-for-toastmasters').'</h3>
	<p>'.__("Your note, along with the roster details, will be sent to all members.",'rsvpmaker-for-toastmasters').'</p>
<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script><br />
<script>
        tinymce.init({selector:"textarea",plugins: "code,link"});	
</script>
	<form method="post" action="'.$permalink.'email_agenda=1">
Subject: <input type="text" name="subject" value="'.$subject.'" size="60"><br />
<textarea name="note" rows="5" cols="80"></textarea><br />
<input type="submit" value="Send" />
</form>';
	
	$output = $header. $mailform . $output . '</body></html>';
	}

	echo $output;

	exit();
}

function print_contacts( $cron = false ) {

if($cron)
	; // not init
else {
	if(!isset($_GET["print_contacts"]) )
		return;
	if(!is_club_member() || !current_user_can('view_contact_info') )
		die("You must log in first");
	echo '<html><body>';
	}

member_list();

if(isset($_GET["print_contacts"]) )
	echo '</body></html>';
exit();
}


function detect_default_password() {

require_once( ABSPATH . WPINC . '/class-phpass.php');
//require_once( ABSPATH . WPINC . '/registration.php');

$blogusers = get_users('blog_id=1&orderby=nicename');
    foreach ($blogusers as $user) {		
		$wp_hasher = new PasswordHash(8, TRUE);
		
	$password_hashed = $user->user_pass;
	$plain_password = 'someawe';
	if($wp_hasher->CheckPassword($plain_password, $password_hashed)) {
		wp_update_user(array('ID' => $user-ID, 'user_pass' => wp_generate_password() ) );
	   	echo $user->user_login." ".__("YES, Matched changing now",'rsvpmaker-for-toastmasters')."<br />";
	}
	else {
	   echo $user->user_login." ".__("Password already reset",'rsvpmaker-for-toastmasters')."<br />";
	}

	}
?>
<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
<input type="submit" name="changepass" value="Change All Passwords" />
</form>
<?php
}

 
function awesome_user_profile_fields( $user ) { ?>
<table class="form-table">
<tr>
<th><label for="public_profile"><?php _e("Public Profile",'rsvpmaker-for-toastmasters');?></label></th>
<td>
<p><input type="checkbox" name="public_profile" id="public_profile" value="yes" <?php if( get_the_author_meta( 'public_profile', $user->ID ) ) echo ' checked="checked" '; ?> />
<span class="description"><?php _e("Check to allow name, social media links, photo, and the description you provided to be displayed publicly.<br /> Otherwise, your contact info will only be shown to other members who have logged in with a password. (Officer profiles are public by default)",'rsvpmaker-for-toastmasters');?></span></p>
<blockquote>
<input type="checkbox" name="public_email" id="public_email" value="yes" <?php if( get_the_author_meta( 'public_email', $user->ID ) ) echo ' checked="checked" '; ?> /> <?php _e("Also show email publicly",'rsvpmaker-for-toastmasters');?>
</blockquote>
<p><input type="checkbox" name="hidden_profile" id="hidden_profile" value="yes" <?php if( get_the_author_meta( 'hidden_profile', $user->ID ) ) echo ' checked="checked" '; ?> />
<span class="description"><?php _e("Check to HIDE profile from member listings. Use to hide accounts used for administration that do not represent member accounts.",'rsvpmaker-for-toastmasters');?></span></p>
</td>
</tr>
</table>
<?php }
 
 
function save_awesome_user_profile_fields( $user_id ) {
 
if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
 
update_user_meta( $user_id, 'public_profile', !empty($_POST['public_profile']) );
update_user_meta( $user_id, 'public_email', !empty($_POST['public_email']) );
update_user_meta( $user_id, 'hidden_profile', !empty($_POST['hidden_profile']) );
}

function speech_intros_shortcode($atts) {
	return '<h1>'.__('Speech Introductions','rsvpmaker-for-toastmasters')."</h1>\n\n".speech_intros(true);
}

function speech_intros($agenda = 0) {

if(!isset($_GET["intros"]) && !$agenda)
	return;
ob_start();
if(!$agenda)
{
?>
<html>
<head>
<style>
h1 {
font-size: 24px;
}
p 
{
	font-size: 18px;
}
</style>
</head>
<body>
<?php
}
	if(isset($_GET["intros"]) && is_numeric($_GET["intros"]))	
		$event = (int) $_GET["intros"];
	else
		{
			global $post;
			$event = $post->ID;
		}
	
	global $wpdb;
	
	$signup = get_post_custom($event);
	//print_r($signup);
	
	for($i = 1; $i < 20; $i++)
		{
			if(isset($signup["_Speaker_".$i][0]) && ($speaker = $signup["_Speaker_".$i][0]))
				{
				echo '<div style="margin-bottom: 20px; padding: 10px; border: thin dotted #000;">'.wpautop(speech_intro_data($speaker,$event,"_Speaker_".$i)).'</div>';
				}
			else
				break;	
		}
if(!$agenda)
{
?>
</body>
</html>
<?php	
ob_get_flush();
exit();
}
return ob_get_clean();
}


function profile_prompt() {

		echo nl2br(__('Can we get a photo of you for the members listing on our Toastmasters website? With our club growing, we would like to have a member roster with photos to help everyone get to know each other.','rsvpmaker-for-toastmasters')."\n".__('You can also log into the website and upload a photo. Take a few minutes to review your profile, making any needed additions or corrections to the contact info we have for you.','rsvpmaker-for-toastmasters'));

$contactmethods['home_phone'] = "Home Phone";
$contactmethods['work_phone'] = "Work Phone";
$contactmethods['mobile_phone'] = "Mobile Phone";

$blogusers = get_users('blog_id=1&orderby=nicename');
    foreach ($blogusers as $user) {		
	$userdata = get_userdata($user->ID);
	if($userdata->hidden_profile)
		continue;	
	echo $userdata->first_name .' '.$userdata->last_name;
	if(isset($userdata->fbuid))
		{
		$fbset = true;
		}
	else
		$fbset = false;
	
	if(userphoto_exists($userdata))
		$photo = true;
	else
		$photo = false;
	$phone = false;
	foreach($contactmethods as $name => $value)
		{
			if(isset($userdata->$name) )
				$phone = true;
		}
	if(!$phone)
		echo " <strong>".__("No Phone Number",'rsvpmaker-for-toastmasters')."</strong>";
	
	if($fbset)
		echo " <strong>".__("Facebook Connection Set",'rsvpmaker-for-toastmasters')."</strong>";
	elseif($photo)
		echo " <strong>".__("Photo Provided",'rsvpmaker-for-toastmasters')."</strong>";
	else
		{
		echo " <strong>".__("Please provide a photo.",'rsvpmaker-for-toastmasters')."</strong>";
		
		printf('<br /><a target="_blank" href="mailto:%s?subject='.__("Please add your photo to your member listiong on the Toastmasters website",'rsvpmaker-for-toastmasters').'">send note</a><br />',$userdata->user_email);
		
		}
	echo "<br />";
	}
}


function awesome_rating () {
global $wpdb;
$sql = "SELECT * FROM `".$wpdb->prefix."postmeta` JOIN ".$wpdb->prefix."rsvp_dates ON ".$wpdb->prefix."rsvp_dates.postID = ".$wpdb->prefix."postmeta.post_id WHERE `meta_key` LIKE '%1' OR  `meta_key` LIKE '%2' OR  `meta_key` LIKE '%3' AND ( (meta_key IS NOT NULL) AND (meta_value IS NOT NULL) AND (datetime > DATE_SUB(NOW(), INTERVAL 3 MONTH)) AND (datetime < NOW()) )";
$r = $wpdb->get_results($sql);
foreach($r as $row)
	{
	//print_r($row);
	$id = (int) $row->meta_value;
	if($id && !empty($row->meta_key) && !strpos($row->meta_key,'Backup') )
		{
		$rate[$id]++;
		$tags[$id] .= $row->meta_key.', ';
		}
	}
arsort($rate);

foreach($rate as $id => $value)
	{
		$userdata = get_userdata($id);
		if(!isset($top))
			$top = $value;
		$score = round(($value / $top) * 5);
		if($score < 1)
			$score = 1;
		printf('<p>%s : %s %s</p>',$score,$userdata->first_name,$userdata->last_name);
		echo $tags[$id]."<br />";
	}
}

function pack_speakers($count)
{
global $post;
$scount = 1;
$fullorder =array();
$currentorder =array();

	for($i = 1; $i <= $count; $i++)
		{
		
		$field = '_Speaker_' . $i;
		$assigned = (int) get_post_meta($post->ID, $field, true);
		if($assigned != 0)
			{
				$currentorder[] = $i;
				$fullorder[] = $scount;
				$speaker[$scount]["assigned"] = $assigned;
				$speaker[$scount]["manual"] = get_post_meta($post->ID, '_manual'.$field, true);
				$speaker[$scount]["project"] = get_post_meta($post->ID, '_project'.$field, true);
				$speaker[$scount]["maxtime"] = get_post_meta($post->ID, '_maxtime'.$field, true);
				$speaker[$scount]["title"] = get_post_meta($post->ID, '_title'.$field, true);
				$speaker[$scount]["intro"] = get_post_meta($post->ID, '_intro'.$field, true);
				$scount++;
			}
		}

		if(sizeof($currentorder) < $count)
			{
				$assigned = (int) get_post_meta($post->ID, '_Backup_Speaker_1', true);
				if($assigned > 0)
					{
					$speaker[$scount]["assigned"] = $assigned;
					$speaker[$scount]["manual"] = get_post_meta($post->ID, '_manual_Backup_Speaker_1', true);
					$speaker[$scount]["project"] = get_post_meta($post->ID, '_project_Backup_Speaker_1', true);
					$speaker[$scount]["maxtime"] = get_post_meta($post->ID, '_maxtime_Backup_Speaker_1', true);
					$speaker[$scount]["title"] = get_post_meta($post->ID, '_title_Backup_Speaker_1', true);
					$speaker[$scount]["intro"] = get_post_meta($post->ID, '_intro_Backup_Speaker_1', true);
					if(empty($speaker[$scount]["manual"]))
						$speaker[$scount]["manual"] = "COMPETENT COMMUNICATION";
					if(empty($speaker[$scount]["maxtime"]))
						$speaker[$scount]["maxtime"] = 7;
					
					$fullorder[] = $scount;
					delete_post_meta($post->ID,'_Backup_Speaker_1');
					delete_post_meta($post->ID,'_manual_Backup_Speaker_1');
					delete_post_meta($post->ID,'_project_Backup_Speaker_1');
					delete_post_meta($post->ID,'_maxtime_Backup_Speaker_1');
					delete_post_meta($post->ID,'_title_Backup_Speaker_1');
					delete_post_meta($post->ID,'_intro_Backup_Speaker_1');
					
					backup_speaker_notify($assigned);

					}
			}
		if( !sizeof($fullorder) )
			return;
		$diff = array_diff($fullorder,$currentorder);
		if(sizeof($diff))
		{
			for($i = 1; $i <= $count; $i++)
				{
				if(isset($speaker[$i]["assigned"]))
					{
					update_post_meta($post->ID,'_Speaker_' . $i,$speaker[$i]["assigned"]);
					update_post_meta($post->ID,'_manual_Speaker_' . $i,$speaker[$i]["manual"]);
					update_post_meta($post->ID,'_project_Speaker_' . $i,$speaker[$i]["project"]);
					update_post_meta($post->ID,'_maxtime_Speaker_' . $i,$speaker[$i]["maxtime"]);
					update_post_meta($post->ID,'_title_Speaker_' . $i,$speaker[$i]["title"]);
					if(isset($speaker[$i]["intro"]))
						update_post_meta($post->ID,'_intro_Speaker_' . $i,$speaker[$i]["intro"]);
					else
						update_post_meta($post->ID,'_intro_Speaker_' . $i,'');				
					}
				else
					{
					delete_post_meta($post->ID,'_Speaker_' . $i);
					delete_post_meta($post->ID,'_manual_Speaker_' . $i);
					delete_post_meta($post->ID,'_project_Speaker_' . $i);
					delete_post_meta($post->ID,'_maxtime_Speaker_' . $i);
					delete_post_meta($post->ID,'_title_Speaker_' . $i);
					delete_post_meta($post->ID,'_intro_Speaker_' . $i);
					}
				}
		}

}//end pack speakers


function backup_speaker_notify($assigned) {
global $post;
global $wpdb;
global $rsvp_options;

if(!is_rsvpmaker_future($post->ID))
	return;

	$datetime = get_rsvp_date($post->ID);
	$meetingdate = strftime($rsvp_options["short_date"],strtotime($datetime));

	$meeting_leader = get_post_meta($post->ID, 'meeting_leader', true);
	if(empty($meeting_leader))
		$meeting_leader = "_Toastmaster_of_the_Day_1";
	$toastmaster = (int) get_post_meta($post->ID, $meeting_leader, true);

	if($toastmaster)
		{
		$tmdata = get_userdata($toastmaster);
		$leader_email = $tmdata->user_email;
		}
	else
		$leader_email = get_option( 'admin_email' );
	
		$speakerdata = get_userdata($assigned);
		$subject = $message = sprintf('%s %s ',$speakerdata->first_name,$speakerdata->last_name).__('now scheduled to speak on','rsvpmaker-for-toastmasters').' '.$meetingdate;
		$url = rsvpmaker_permalink_query($post_id);
		$mail["subject"] = substr(strip_tags($subject),0, 100);
		$message .= "\n\n" . __("Backup speaker promoted to speaker following a cancellation.",'rsvpmaker-for-toastmasters');

		$footer = "\n\n". __("This is an automated message. Replies will be sent to",'rsvpmaker-for-toastmasters')." ".$leader_email;
		if($toastmaster)
			$footer .= " Toastmaster of the Day ".$tmdata->display_name;
		$p = get_permalink($post->ID);
		$footer .= "\n\nTo remove yourself from the agenda, visit ".sprintf('<a href="%s">%s</a>',$p,$p);
		$mail["html"] = "<html>\n<body>\n".wpautop($message.$footer)."\n</body></html>";
		$mail["replyto"] = $leader_email;
		$mail["to"] = $speakerdata->user_email;
		$mail["from"] = $leader_email;
		$mail["fromname"] = get_bloginfo('name');
		awemailer($mail); // notify speaker

		$footer = "\n\nThis is an automated message. Replies will be sent to ".$speakerdata->user_email;
		$mail["html"] = "<html>\n<body>\n".wpautop($message.$footer)."\n</body></html>";
		$mail["replyto"] = $speakerdata->user_email;
		$mail["to"] = $leader_email;
		$mail["from"] = $speakerdata->user_email;
		$mail["fromname"] = $speakerdata->display_name;
		awemailer($mail); // notify leader
		
		
}

function awemailer($mail) {
	
	global $rsvp_options;
	
	if(strpos($mail["to"],'example.com'))
		return;
	
	if(get_option('wp4toastmasters_disable_email'))
		{
			//echo '<p><b><em>'.__('Email sending functions disabled on this site.','rsvpmaker-for-toastmasters')."</em></b></p>";
			return false;
		}
	
	return rsvpmailer($mail);
}

if(!function_exists('rsvpmaker_print_redirect'))
{
add_action("template_redirect", 'rsvpmaker_print_redirect');

function rsvpmaker_print_redirect()
{
global $post;

		if (isset($_GET["tm_reports"]))
		{
			include(WP_PLUGIN_DIR . '/rsvpmaker-for-toastmasters/reports-fullscreen.php');
			die();
		}

if($post->post_type != 'rsvpmaker')
	return;	
	
		if (isset($_GET["print_agenda"]))
		{
			$format = get_option('wp4toastmasters_agenda_layout');
			if($format == 'sidebar')
				include(WP_PLUGIN_DIR . '/rsvpmaker-for-toastmasters/agenda-with-sidebar.php');
			elseif($format == 'custom')
				include(WP_PLUGIN_DIR . '/rsvpmaker-for-toastmasters/agenda-custom.php');
			else
				include(WP_PLUGIN_DIR . '/rsvpmaker-for-toastmasters/agenda.php');
			die();
		}
		elseif (isset($_GET["email_agenda"]))
		{
			include(WP_PLUGIN_DIR . '/rsvpmaker-for-toastmasters/email_agenda.php');
			die();
		}
		elseif(isset($_GET["intros"]))
		{
			speech_intros();
			die();
		}

}
}

function tm_sidebar_post($post_id) {
$sidebar = simplify_html($_POST["_tm_sidebar"]);
$template = (isset($_POST["template"])) ? (int) $_POST["template"] : 0;
$sidebar_officers = (isset($_POST["sidebar_officers"]) && $_POST["sidebar_officers"]) ? 1 : 0;
if($template)
	{
	update_post_meta($template,'_tm_sidebar',$sidebar);
	update_post_meta($template,'_sidebar_officers',$sidebar_officers);
	$future_events = future_rsvpmakers_by_template($template);	
	if(!empty($future_events))
		{
		foreach($future_events as $event)
			{
			update_post_meta($event,'_tm_sidebar',$sidebar);
			update_post_meta($event,'_sidebar_officers',$sidebar_officers);
			}
		}
	}
}

function themewords ($atts) {
global $post;

if(isset($_POST["themewords"]))
	update_post_meta($post->ID,'_themewords',simplify_html($_POST["themewords"]));

ob_start();

if(is_club_member() && isset($_GET["edit_roles"]))
{
?>
                    <div id="themewords">
                    <h3><?php _e("Theme/Words",'rsvpmaker-for-toastmasters');?></h3>
                    <textarea name="themewords" rows="5" cols="80" class="mce"><?php  
										
					echo wpautop(get_post_meta($post->ID,'_themewords',true)); ?> </textarea>
                    </div>
<?php
}
elseif(isset($_GET["print_agenda"]))
	{
	$th = get_post_meta($post->ID,'_themewords',true);
	if(!empty($th))
		{
        return '<div class="agenda_note">'.wpautop($th).'</div>';
     	}
	}
else
{
	$th = get_post_meta($post->ID,'_themewords',true);
	if(!empty($th))
		{
?>
                    <div id="themewords">
                    <h3 style="font-weight: bold; margin-top: 20px;"><?php _e("Theme/Words",'rsvpmaker-for-toastmasters');?></h3>
                    <?php echo wpautop($th); ?>
                    </div>
<?php			
		}
}
return ob_get_clean();
}

add_shortcode('themewords','themewords');

function simplify_html($text, $allowable_tags="<p><br><div><b><strong><em><i><h1><h2><h3><h4><h5><h6><ol><ul><li>") {
	$text = strip_tags($text, $allowable_tags);
	$text = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', $text);
	$text = trim(str_replace("&nbsp;",' ',$text));
	return preg_replace("|</{0,1}p>|i","\n", $text);
}

function user_archive () {
global $wpdb;
$wpdb->show_errors();

$db_version = (int) get_option('rsvptoast_db');
if($db_version < 3)
	toast_activate();

$blogusers = get_users('blog_id='.get_current_blog_id());
    foreach ($blogusers as $user) {
	$meta = get_user_meta( $user->ID );
	// Filter out empty meta data
	$meta = array_filter( array_map( function( $a ) { return $a[0]; }, $meta ) );
	$userdata = array_merge(array('ID' => $user->ID, 'user_login' => $user->user_login, 'user_email' => $user->user_email), $meta);
	$index = (isset($userdata["last_name"])) ? $userdata["last_name"].$userdata["first_name"] : '';
	$index = preg_replace('/[^A-Za-z]/','',$index.$user->user_login);
	$sort = $wpdb->get_var("SELECT sort FROM ".$wpdb->prefix."users_archive WHERE user_id=".$user->ID);
	if($sort)
		{
		$sql = $wpdb->prepare("UPDATE ".$wpdb->prefix."users_archive SET data=%s, sort=%s, email=%s WHERE user_id=%d", serialize($userdata),$index,$user->user_email, $user->ID);
		}
	else
		{
		$sql = $wpdb->prepare("REPLACE INTO ".$wpdb->prefix."users_archive SET data=%s, sort=%s, user_id=%d, email=%s", serialize($userdata),$index, $user->ID, $user->user_email);
		}
	$wpdb->query($sql);
	}
}

if(!function_exists('add_implicit_links') ) { function add_implicit_links($text) {
	$text = preg_replace('! ([A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{3})!i', ' <a href="mailto:$1">$1</a>', $text);
	$text = preg_replace('! (www.[a-z0-9_./?=&-;]+)!i', ' <a href="http://$1">$1</a>', $text);
	$text = preg_replace('! (https{0,1}://[a-z0-9_./?=&-;]+)!i', ' <a href="$1">$1</a>', $text);
	return $text;
} }

// shortcode editor functions 

function shortcode_eventdates($post_id) {

global $wpdb;
global $rsvp_options;
global $custom_fields;
$custom_fields = get_post_custom($post_id);

if(isset($custom_fields["_sked"][0]))
	{
	$template = unserialize($custom_fields["_sked"][0]);
	template_schedule($template);
	return;
	}

if(isset($custom_fields["_meet_recur"][0]))
	{
		$t = (int) $custom_fields["_meet_recur"][0];
	}
	
if(isset($post_id) )
	{
	$results = get_rsvp_dates($post_id);
	}
else
	$results = false;

if($results)
{
$start = 2;
foreach($results as $row)
	{
	echo "\n<div class=\"event_dates\"> \n";
	$t = strtotime($row["datetime"]);
	if($rsvp_options["long_date"]) echo strftime($rsvp_options["long_date"],$t);
	$dur = $row["duration"];
	if($dur != 'allday')
		echo strftime(' '.$rsvp_options["time_format"],$t);
	if(is_numeric($dur) )
		echo " to ". strftime($rsvp_options["time_format"],$dur);
	echo sprintf(' <input type="checkbox" name="delete_date[]" value="%d" /> %s<br />',$row["meta_id"],__('Delete','rsvpmaker'));
	rsvpmaker_date_option($row);
	echo "</div>\n";
	}
}
}

function member_not_user() {
echo '<p style="color: red;"><b>For Toastmasters members, please use the <a href="'.admin_url('users.php?page=add_awesome_member').'">Add Member</a> form instead.</b></p>';
}

function add_awesome_roles() {

$manager = get_role('manager');
if(!$manager)
add_role( 'manager', 'Manager', array( 'delete_others_pages' => true,
'delete_others_posts' => true,
'delete_pages' => true,
'delete_posts' => true,
'delete_private_pages' => true,
'delete_private_posts' => true,
'delete_published_pages' => true,
'delete_published_posts' => true,
'edit_others_pages' => true,
'edit_others_posts' => true,
'edit_pages' => true,
'edit_posts' => true,
'edit_private_pages' => true,
'edit_private_posts' => true,
'edit_published_pages' => true,
'edit_published_posts' => true,
'manage_categories' => true,
'manage_links' => true,
'moderate_comments' => true,
'publish_pages' => true,
'publish_posts' => true,
'read' => true,
'read_private_pages' => true,
'read_private_posts' => true,
'upload_files' => true,
'delete_others_rsvpmakers' => true,
'delete_rsvpmakers' => true,
'delete_private_rsvpmakers' => true,
'delete_published_rsvpmakers' => true,
'edit_others_rsvpmakers' => true,
'edit_rsvpmakers' => true,
'edit_private_rsvpmakers' => true,
'edit_published_rsvpmakers' => true,
'publish_rsvpmakers' => true,
'read_private_rsvpmakers' => true,
'promote_users' => true,
'remove_users' => true,
'delete_users' => true,
'list_users' => true,
'edit_users' => true,
"view_reports" => true,
"view_contact_info" => true,
"edit_signups" => true,
"edit_member_stats" => true,
"edit_own_stats" => true,
"agenda_setup" => true,
"email_list" => true,
"add_member" => true,
"edit_members" => true

 ) );

// fix legacy role
$officer_users = get_users( 'blog_id='.get_current_blog_id().'&role=officer' );
if(!empty($officer_users))
{
// Array of WP_User objects.
foreach ( $officer_users as $officer ) {
	$user = array('ID' => $officer->ID, 'role' => 'manager', 'user_email' => $officer->user_email);
	wp_update_user($user);    
	}
}
remove_role('officer');

   }

function awesome_role_activation_wrapper() {

	global $current_user;
	
   register_activation_hook( __FILE__, 'add_awesome_roles' );
   if(isset($_GET["add_awesome_roles"]))
   	add_awesome_roles();

	if(!current_user_can('manage_options'))
		return;

if(isset($_POST['wp4toastmasters_manager_ids']) )
	{
		foreach($_POST['wp4toastmasters_manager_ids'] as $id)
			{
				$id = (int) $id;
				if(($id == 0) || ($id == $current_user->ID) )
					continue;
				elseif( user_can($id, 'manage_options') || user_can($id, 'administrator') )
					continue; // don't mess with the admin
				else
					{
						$userdata = get_userdata($id);
						$user = array('ID' => $id, 'role' => 'manager', 'user_email' => $userdata->user_email);
						wp_update_user($user);
					}
			}
	}

if(isset($_POST['wp4toastmasters_admin_ids']) )
	{
		foreach($_POST['wp4toastmasters_admin_ids'] as $id)
			{
				$id = (int) $id;
				if(($id == 0) || ($id == $current_user->ID) )
					continue;
				elseif( user_can($id, 'manage_options') || user_can($id, 'administrator') )
					continue; // don't mess with the admin
				else
					{
						$userdata = get_userdata($id);
						$user = array('ID' => $id, 'role' => 'administrator', 'user_email' => $userdata->user_email);
						wp_update_user($user);
					}
			}
	}

}


function toastmasters_css_js() {
	global $post;
	if( (isset($post->post_content) && (strpos($post->post_content,'toastmaster') || strpos($post->post_content,'rsvpmaker') ) ) || (isset($_GET["page"]) && (($_GET["page"] == 'toastmasters_reconcile') || ($_GET["page"] == 'my_progress_report')  || ($_GET["page"] == 'toastmasters_reports') )  ) )
	{
	wp_enqueue_style( 'jquery' );
	wp_enqueue_style( 'style-toastmasters', plugins_url('rsvpmaker-for-toastmasters/toastmasters.css'), array(), '2.4.2' );
	wp_register_script('script-toastmasters', plugins_url('rsvpmaker-for-toastmasters/toastmasters.js'), array('jquery'), '2.4.2');
	wp_enqueue_script( 'script-toastmasters');
	$manuals = get_manuals_options();
	wp_localize_script( 'script-toastmasters', 'manuals_list', $manuals );
	$projects = get_projects_array('options');
	wp_localize_script( 'script-toastmasters', 'project_list', $projects );
	$times = get_projects_array('times');
	wp_localize_script( 'script-toastmasters', 'project_times', $times );
	wp_localize_script( 'script-toastmasters', 'ajaxurl', admin_url('admin-ajax.php') );
	}
}

function wp4t_assigned_open () {
	global $post;
	$roster = '';
	$signup = get_post_custom($post->ID);
			
$lines = explode("\n",$post->post_content);
foreach($lines as $line)
	{
		if(strpos($line,'role') )
		{
		$cells = explode('"',$line);
		if(empty($cells[1]))
			continue;
		$role = $cells[1];
		$count = (isset($cells[3])) ? $cells[3] : 1;
		for($i = 1; $i <= $count; $i++)
			{
				$field = '_'.str_replace(' ','_',$role).'_'.$i;
				$roles[$field] = $role;
			}
		}
	}
	$has_assignment = array();
	 foreach($roles as $field => $role)
		{
			$assigned = (isset($signup[$field][0])) ? $signup[$field][0] : '';
			if(!empty($assigned))
				$has_assignment[] = $assigned;
			if(is_numeric($assigned))
				{
					$userdata = get_userdata($assigned);
					$status = wp4_format_contact ($userdata);
					if($role == 'Speaker')
						{
						if(!empty($signup['_manual'.$field][0]))
							$status .= $signup['_manual'.$field][0]."\n";
						}
				}
			else
				$status = $assigned;			
			$roster .= sprintf("<strong>%s:</strong>\n%s"."\n",str_replace('_',' ',$role), $status);
			
		}
		
$roster .= wp4_email_contacts($has_assignment);

$roster = wpautop($roster);
if(isset($_GET["email_me"]))
	{
	global $current_user;
	wp_mail($current_user->user_email,__('Meeting Roster','rsvpmaker-for-toastmasters'),$roster,array('Content-Type: text/html; charset=UTF-8'));
	}
return $roster;
}

function wp4_speech_prompt($event_post, $datetime) {
	global $wpdb;
	global $post;
	$post = $event_post;
	$signup = get_post_custom($event_post->ID);
	preg_match_all('/\[toastmaster role.{0,2}=.{0,2}"([^"]+)/',$event_post->post_content,$matches);
	$templates = get_rsvpmaker_notification_templates();	
	$rsvpdata["[rsvptitle]"] = $event_post->post_title;
	$rsvpdata["[rsvpdate]"] = $event_post->date;
		$toastmaster = (!empty($signup["_Toastmaster_of_the_Day_1"][0])) ? $signup["_Toastmaster_of_the_Day_1"][0] : 0;
		if($toastmaster)
			{
			$userdata = get_userdata($toastmaster);
			$toastmaster_email = $userdata->user_email;
			}
		else
			$toastmaster_email = get_bloginfo('admin_email');
	
	foreach($signup as $key => $values)
		{
		$role = trim(preg_replace('/[_[0-9]/',' ',$key));
		echo $role.'<br />';
		$assign = $values[0];
		echo $assign.'<br />';

		if(!$assign || !is_numeric($assign))
			continue;//role not assigned, or assigned to a guest
		if(in_array($role,$matches[1]))//confirm this meta key is a role from the document
			{
			$subject = (!empty($templates[$role]['subject'])) ? $templates[$role]['subject'] : $templates['role_reminder']['subject'];
			$body = (!empty($templates[$role]['body'])) ? $templates[$role]['body'] : $templates['role_reminder']['body'];
			if($role == 'Speaker')
				{
				$speech_details = (empty($signup['_manual'.$key][0])) ? 'Manual: ' : 'Manual: '.$signup['_manual'.$key][0];
				$speech_details .= "\n";
				$speech_details .= (empty($signup['_project'.$key][0])) ? 'Project: ' : 'Project: '.get_project_text($signup['_project'.$key][0]);
				$speech_details .= "\n";
				$speech_details .= (empty($signup['_title'.$key][0])) ? 'Title: ' : 'Title: '.$signup['_title'.$key][0];
				$speech_details .= "\n";
				$speech_details .= (empty($signup['_intro'.$key][0])) ? 'Introduction: ' : 'Introduction:<br />'.wpautop($signup['_intro'.$key][0]);
				if(empty($signup['_manual'.$key][0]) || empty($signup['_project'.$key][0]))
					$speech_details .= "\n\n".__("PLEASE ENTER MANUAL / SPEECH TIMING REQUIREMENT ON WEBSITE",'rsvpmaker-for-toastmasters')."\n\n";
				$speech_details .= "\n\n".__("Remember to supply the Toastmaster of the Day with the title of your speech and an introduction.",'rsvpmaker-for-toastmasters');
				$body = str_replace('[wpt_speech_details]',$speech_details,$body);
				}
			$subject = do_shortcode(str_replace('[wptrole]',$role,str_replace(array_keys($rsvpdata),$rsvpdata,$subject)));
			$body = do_shortcode(str_replace('[wptrole]',$role,str_replace(array_keys($rsvpdata),$rsvpdata,$body)));
			$userdata = get_userdata($assign);
			$mail["html"] = wpautop($body);
			$mail["to"] = $userdata->user_email;
			if($userdata->user_email == $toastmaster_email)
				$mail["from"] = get_bloginfo('admin_email');
			else
				$mail["from"] = $toastmaster_email;
			$mail["fromname"] = get_bloginfo('name');
			$mail["subject"] = $subject;
			print_r($mail);
			rsvpmaker_tx_email($event_post, $mail);
			}
		}
}

function wp4_format_contact ($userdata) {
$output = '';
		if($userdata->last_name == "AVAILABLE")
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

function wp4_email_contacts( $has_assignment = array() ) {

$output = '';
if(!empty($has_assignment))
	$output .= __('List of members without an assignment','rsvpmaker-for-toastmasters')."\n\n";

$blogusers = get_users('blog_id='.get_current_blog_id().'&orderby=nicename');
    foreach ($blogusers as $user) {
	if(in_array($user->ID,$has_assignment))
		continue;
	$userdata = get_userdata($user->ID);
	//print_r($userdata);
	//echo " $userdata->first_name test<br />";
	$index = preg_replace('/[^A-Za-z]/','',$userdata->last_name.$userdata->first_name.$userdata->user_login);
	$members[$index] = $userdata;
	}
	
	if(!empty($members))
		{
		ksort($members);
		foreach($members as $userdata) {
			$output .= wp4_format_contact ($userdata);		
		}
	}
return $output;
}

function toolbar_add_member( $wp_admin_bar ) {

if( !current_user_can('list_users') )
	return $wp_admin_bar;
	$args = array(
		'id'    => 'add_member',
		'title' => __('Member','rsvpmaker-for-toastmasters'),
		'href'  => admin_url('users.php?page=add_awesome_member'),
		'parent' => 'new-content',
		'meta'  => array( 'class' => 'add_member' )
	);
	$wp_admin_bar->add_node( $args );
}

if(!function_exists('rsvpmaker_permalink_query') )
{
function rsvpmaker_permalink_query ($id, $query = '') {
if(!$id)
	return;
$p = get_permalink($id);
$p .= strpos($p,'?') ? '&' : '?';
if(is_array($query) )
	{
		foreach($query as $name => $value)
			$qstring .= $name.'='.$value.'&';
	}
else
	{
		$qstring = $query;
	}
	
	return $p.$qstring;
	
}
} // end function exists

function toastmasters_datebox_message () {
echo '<div style="padding: 5px; margin: 5px; backround-color: #eee; border: thin dotted black;">'.__('For a regular Toastmasters meeting, do not worry about the parameters below. You may use this RSVP functionality to schedule other sorts of events (for example, training or open house events.)','rsvpmaker-for-toastmasters').'</div>';
}


function wp4toast_template( $user_id = 1 ) {

global $wpdb;
$sql = "SELECT ID FROM `$wpdb->posts` WHERE `post_content` LIKE '%[toastmasters%' AND post_status='publish' ORDER BY `ID` DESC ";
if($wpdb->get_var($sql))
	return;

$default = '[agenda_note comment="'.__('text between here and /agenda_note will be shown on the agenda only','rsvpmaker-for-toastmasters').'"]

'.__('Sgt. at Arms calls the meeting to the order','rsvpmaker-for-toastmasters').'

[/agenda_note]

[toastmaster role="Invocation" count="1" agenda_note="" ]

[agenda_note comment="'.__('text between here and /agenda_note will be shown on the agenda only','rsvpmaker-for-toastmasters').'"]

'.__('President or Presiding Officer leads the self-introductions','rsvpmaker-for-toastmasters').'

'.__('President introduces the Toastmaster of the Day','rsvpmaker-for-toastmasters').'

[/agenda_note]

[toastmaster role="Toastmaster of the Day" count="1" agenda_note="'.__('Introduces supporting roles. Leads the meeting.','rsvpmaker-for-toastmasters').'" ]

[toastmaster role="Ah Counter" count="1" agenda_note="" indent="1" ]

[toastmaster role="Timer" count="1" agenda_note="" indent="1" ]

[toastmaster role="Vote Counter" count="1" agenda_note="" indent="1" ]

[toastmaster role="Body Language Monitor" count="1" agenda_note="" indent="1" ]

[toastmaster role="Grammarian" count="1" agenda_note="Leads word of the day contest." indent="1" ]

[toastmaster role="Topics Master" count="1" agenda_note="" ]

[toastmaster role="Humorist" count="1" agenda_note="" ]

[toastmaster role="Speaker" count="3" agenda_note="" ]

[toastmaster role="Backup Speaker" count="1" agenda_note="" ]

[toastmaster role="General Evaluator" count="1" agenda_note="'.__('Explains the importance of evaluations. Introduces Evaluators. Asks for Grammarian report. Gives overall evaluation of the meeting.','rsvpmaker-for-toastmasters').'" ]

[toastmaster role="Evaluator" count="3" agenda_note="" ]

[agenda_note editable="Theme" comment="'.__('Rather than wrapping around content, this agenda note is set up as a user-editable field for the meeting theme that can be changed for every meeting','rsvpmaker-for-toastmasters').'"][/agenda_note]
';

	$post = array(
	  'post_content'   => $default,
	  'post_name'      => 'toastmasters-meeting',
	  'post_title'     => 'Toastmasters Meeting',
	  'post_status'    => 'publish',
	  'post_type'      => 'rsvpmaker',
	  'post_author'    => $user_id,
	  'ping_status'    => 'closed'
	);
	$templateID = wp_insert_post($post);

	if($parent_id = wp_is_post_revision($templateID))
		{
		$templateID = $parent_id;
		}
	$template["hour"]= 19;
	$template["minutes"] = '00';
	$template["week"] = 0;

	update_post_meta($templateID, '_sked', $template);
	update_option('default_toastmasters_template',$templateID);
	update_option('toastmasters_meeting_template',$templateID);
	update_option('wp4toastmasters_agenda_layout','sidebar');
	update_post_meta($templateID,'_tm_sidebar', '<strong>Club Mission:</strong> We provide a supportive and positive learning experience in which members are empowered to develop communication and leadership skills, resulting in greater self-confidence and personal growth.');
	update_post_meta($templateID,'_sidebar_officers', 1);
	update_option('default_toastmasters_template',$templateID);

$default = '[agenda_note comment="'.__('text between here and /agenda_note will be shown on the agenda only','rsvpmaker-for-toastmasters').'"]'.__('Sgt. at Arms calls the meeting to the order','rsvpmaker-for-toastmasters').'[/agenda_note]

[agenda_note comment="'.__('text between here and /agenda_note will be shown on the agenda only','rsvpmaker-for-toastmasters').'"]'.__('President or Presiding Officer leads the self-introductions.','rsvpmaker-for-toastmasters').'[/agenda_note]

[agenda_note comment="'.__('text between here and /agenda_note will be shown on the agenda only','rsvpmaker-for-toastmasters').'"]'.__('Introduces the Contest Master.','rsvptost').'[/agenda_note]

[toastmaster role="Contest Master" count="1" agenda_note="'.__('Introduces supporting roles. Leads the meeting.','rsvpmaker-for-toastmasters').'" ]

[toastmaster role="Chief Judge" count="1" agenda_note="" ]

[toastmaster role="Timer" count="1" agenda_note="" ]

[toastmaster role="Vote Counter" count="1" agenda_note="" ]

[toastmaster role="Videographer" count="1" agenda_note="" ]

[toastmaster role="International Speech Contestant" count="6" agenda_note="" ]

[toastmaster role="Table Topics Contestant" count="6" agenda_note="" ]

[toastmaster role="Humorous Speech Contestant" count="6" agenda_note="" ]

[toastmaster role="Evaluation Contest Contestant" count="6" agenda_note="" ]

';

	$post = array(
	  'post_content'   => $default,
	  'post_name'      => 'contest',
	  'post_title'     => 'Contest',
	  'post_status'    => 'publish',
	  'post_type'      => 'rsvpmaker',
	  'post_author'    => $user_id,
	  'ping_status'    => 'closed'
	);
	$templateID = wp_insert_post($post);

	if($parent_id = wp_is_post_revision($templateID))
		{
		$templateID = $parent_id;
		}
	$template["hour"]= 19;
	$template["minutes"] = '00';
	$template["week"] = 0;

	update_post_meta($templateID, '_sked', $template);
	update_post_meta($templateID,'_tm_sidebar', '<strong>Club Mission:</strong> We provide a supportive and positive learning experience in which members are empowered to develop communication and leadership skills, resulting in greater self-confidence and personal growth.');
	update_post_meta($templateID,'_sidebar_officers', 1);
}

register_activation_hook( __FILE__, 'wp4toast_template' );

function new_agenda_template() {
global $current_user;
if(!isset($_REQUEST["submit"]) || ($_REQUEST["submit"] != 'Make New Agenda Template'))
	return;
$default = '[toastmaster role="Speaker" count="1" ]';

	$post = array(
	  'post_content'   => $default,
	  'post_title'     => 'Title Goes Here',
	  'post_status'    => 'publish',
	  'post_type'      => 'rsvpmaker',
	  'post_author'    => $current_user->ID,
	  'ping_status'    => 'closed'
	);
	$templateID = wp_insert_post($post);

	if($parent_id = wp_is_post_revision($templateID))
		{
		$templateID = $parent_id;
		}
	$template["hour"]= 19;
	$template["minutes"] = '00';
	$template["week"] = 6;
	$template["dayofweek"] = 1;

	update_post_meta($templateID, '_sked', $template);
	header('Location: '.admin_url('edit.php?post_type=rsvpmaker&page=agenda_setup&post_id='.$templateID));
	exit();
}


function toast_activate() {

global $wpdb;
$wpdb->show_errors();

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

$sql = "CREATE TABLE `".$wpdb->prefix."toastmasters_history` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `datetime` date NOT NULL,
  `role` varchar(255) CHARACTER SET utf8 NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
dbDelta($sql);

$sql = "CREATE TABLE `".$wpdb->prefix."users_archive` (
	  `sort` varchar(255) NOT NULL,
	  `data` text NOT NULL,
	  `user_id` int(11) NOT NULL DEFAULT '0',
	  `guest` tinyint(4) NOT NULL,
	  `email` varchar(255) NOT NULL,
	  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	  PRIMARY KEY (`sort`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
dbDelta($sql);

//establish custom roles
tm_security_setup();
update_option('rsvptoast_db','3');

}

function check_first_login () {
$first = get_option('first_tm_login');
if($first)
	return;
update_option('first_tm_login',current_time('timestamp') );
toast_activate(); // in case this didn't run on plugin activation (multisite)
}

function archive_users_init () {
// if a logged in user access the users list, back up users
if(!strpos($_SERVER['REQUEST_URI'],'users.php') )
	return;
	user_archive();
}

register_activation_hook( __FILE__, 'toast_activate' );

function toolbar_link_to_agenda( $wp_admin_bar ) {
global $post;
if(!strpos($post->post_content,'[toastmaster') )
	return;

	$security = get_tm_security ();
	if(!current_user_can($security['agenda_setup']) )
		return;
	$link = get_permalink($post->ID);
	$link .= (strpos($link,'?')) ? '&edit_sidebar=1' : '?edit_sidebar=1';
	$args = array(
		'id'    => 'agenda_sidebar',
		'title' => 'Edit Agenda Sidebar',
		'href'  => $link,
		'meta'  => array( 'class' => 'edit-agenda-sidebar')
	);
	$wp_admin_bar->add_node( $args );
}


function edit_template_url($post_id) {
return admin_url('post.php?action=edit&post='.$post_id);
}

function add_from_template_url($post_id) {
return admin_url('edit.php?post_type=rsvpmaker&page=rsvpmaker_template_list&t='.$post_id);
}

function agenda_setup_url($post_id) {
return admin_url('edit.php?post_type=rsvpmaker&page=agenda_setup&post_id='.$post_id);
}

function member_only_content($content) {
if( !in_category('members-only') && !has_term('members-only','rsvpmaker-type') )
	return $content;

if(!is_club_member() )
return '<div style="width: 100%; background-color: #ddd;">'.__('You must be logged in and a member of this blog to view this content','rsvpmaker-for-toastmasters').'</div>'. sprintf('<div id="member_only_login"><a href="%s">'.__('Login to View','rsvpmaker-for-toastmasters').'</a></div>',site_url('/wp-login.php?redirect_to='.urlencode(get_permalink()) ) );
else
return $content.'<div style="width: 100%; background-color: #ddd;">'.__('Note: This is member-only content (login required)','rsvpmaker-for-toastmasters').'</div>';

}


function members_only_jetpack ($tag_array) {
if( !in_category('members-only') && !has_term('members-only','rsvpmaker-type') )
	return $tag_array;
$tag_array['description'] = __('Members only content','rsvpmaker-for-toastmasters');
return $tag_array;
}

function member_only_excerpt($excerpt) {
if( !in_category('members-only') && !has_term('members-only','rsvpmaker-type') )
	return $excerpt;

if(!is_club_member() )
return __('You must be logged in and a member of this blog to view this content','rsvpmaker-for-toastmasters');
else
return $excerpt;
}


// widget for members only posts
class WP_Widget_Members_Posts extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'widget_members_entries', 'description' => __( "Your site&#8217;s most recent members-only posts.",'rsvpmaker-for-toastmasters') );
		parent::__construct('members-posts', __('Members Posts','rsvpmaker-for-toastmasters'), $widget_ops);
		$this->alt_option_name = 'widget_members_entries';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	public function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'widget_members_posts', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Members Only Posts','rsvpmaker-for-toastmasters' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
			$number = 5;
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		/**
		 * Filter the arguments for the members Posts widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the members posts.
		 */
		$r = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => $number,
			'category_name' => 'members-only',
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		) ) );

		if ($r->have_posts()) :
?>
		<?php echo $args['before_widget']; ?>
		<?php if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		} ?>
		<ul>
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
			<li>
				<a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
			<?php if ( $show_date ) : ?>
				<span class="post-date"><?php echo get_the_date(); ?></span>
			<?php endif; ?>
			</li>
		<?php endwhile; ?>
		</ul>
		<?php echo $args['after_widget']; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'widget_members_posts', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_members_entries']) )
			delete_option('widget_members_entries');

		return $instance;
	}

	public function flush_widget_cache() {
		wp_cache_delete('widget_members_posts', 'widget');
	}

	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:','rsvpmaker-for-toastmasters' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:','rsvpmaker-for-toastmasters' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?','rsvpmaker-for-toastmasters' ); ?></label></p>
<?php
	}
}

//widget for posts excluding members only
class WP_Widget_Club_News_Posts extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'widget_club_news_entries', 'description' => __( "Your site&#8217;s most recent public blog posts.",'rsvpmaker-for-toastmasters') );
		parent::__construct('club-news-posts', __('Club News Posts','rsvpmaker-for-toastmasters'), $widget_ops);
		$this->alt_option_name = 'widget_club_news_entries';

		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	public function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'widget_club_news_posts', 'widget' );
		}

		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Club News','rsvpmaker-for-toastmasters' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
			$number = 5;
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

		/**
		 * Filter the arguments for the club_news Posts widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the club_news posts.
		 */
		$category = get_category_by_slug('members-only');
		if($category)
			$qargs =  array(
			'posts_per_page'      => $number,
			'cat' => '-'.$category->term_id,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true);
		else
			$qargs =  array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true);
						
		$r = new WP_Query( apply_filters( 'widget_posts_args', $qargs ) );

		if ($r->have_posts()) :
?>
		<?php echo $args['before_widget']; ?>
		<?php if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		
		 ?>
		<ul>
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
			<li>
				<a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
			<?php if ( $show_date ) : ?>
				<span class="post-date"><?php echo get_the_date(); ?></span>
			<?php endif; ?>
			</li>
		<?php endwhile; ?>
		</ul>
		<?php echo $args['after_widget']; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'widget_club_news_posts', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_club_news_entries']) )
			delete_option('widget_club_news_entries');

		return $instance;
	}

	public function flush_widget_cache() {
		wp_cache_delete('widget_club_news_posts', 'widget');
	}

	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>
<?php
	}
}

function wptoast_widgets () {
	register_widget("AwesomeWidget");
	register_widget( 'WP_Widget_Members_Posts' );
	register_widget( 'WP_Widget_Club_News_Posts' );
}

function club_news($args) {
ob_start();		
		$show_date = (!empty($args["show_date"])) ? 1 : 0;
		$show_excerpt = (!empty($args["show_excerpt"])) ? 1 : 0;
		$show_thumbnail = (!empty($args["show_thumbnail"])) ? 1 : 0;
		$number = (!empty($args["posts_per_page"])) ? $args["posts_per_page"] : 10;
		$title = (isset($args["title"]) ) ? $args["title"] : __('Club News','rsvpmaker-for-toastmasters');
		if(!empty($title))
			echo '<h2 class="club_news">'.$title."</h2>\n";
		$category = get_category_by_slug('members-only');
		if($category)
			$qargs =  array(
			'posts_per_page'      => $number,
			'cat' => '-'.$category->term_id,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true);
		else
			$qargs =  array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true);
						
		$r = new WP_Query( apply_filters( 'widget_posts_args', $qargs ) );

		if ($r->have_posts()) :
		 ?>
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
			<h3>
				<a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
			<?php if ( $show_date ) : ?>
				<span class="post-date"><?php echo get_the_date(); ?></span>
			<?php endif; ?>
			</h3>
			<?php
			
			if ( $show_thumbnail && has_post_thumbnail() ) : ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail('thumbnail'); ?>
				</a>
			<?php endif;			
			
			 if ( $show_excerpt ) : ?>
				<div class="post-excerpt"><?php the_excerpt(); ?></div>
			<?php endif; ?>
		<?php endwhile; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();
		endif;
return ob_get_clean();
}

function toast_modify_query_exclude_category( $query ) {
	if((get_post_type() == 'rsvpmaker') && ! is_club_member() )
		{
			$query->set('tax_query',array(array('taxonomy'  => 'rsvpmaker-type',
            'field'     => 'slug',
            'terms'     => 'members-only', 
            'operator'  => 'NOT IN')));
		}
    elseif ( ! is_admin() && $query->is_main_query() && ! is_club_member() )
		{
		$category = get_category_by_slug('members-only');
		if($category)
			$query->set( 'cat', '-'.$category->term_id );
		}
}

function members_only($args) {
ob_start();		
		$show_date = (!empty($args["show_date"])) ? 1 : 0;
		$show_excerpt = (!empty($args["show_excerpt"])) ? 1 : 0;
		$show_thumbnail = (!empty($args["show_thumbnail"])) ? 1 : 0;
		$number = (!empty($args["posts_per_page"])) ? $args["posts_per_page"] : 10;
		$title = (isset($args["title"]) ) ? $args["title"] : 'Members Only';
		if(!empty($title))
			echo '<h2 class="club_news">'.$title."</h2>\n";
		$qargs =  array(
		'posts_per_page'      => $number,
		'category_name' => 'members-only',
		'no_found_rows'       => true,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true);

		$r = new WP_Query( apply_filters( 'widget_posts_args', $qargs ) );

		if ($r->have_posts()) :
		 ?>
		<?php while ( $r->have_posts() ) : $r->the_post(); ?>
			<h3>
				<a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
			<?php if ( $show_date ) : ?>
				<span class="post-date"><?php echo get_the_date(); ?></span>
			<?php endif; ?>
			</h3>
			<?php
			
			if ( $show_thumbnail && has_post_thumbnail() ) : ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail('thumbnail'); ?>
				</a>
			<?php endif;			
			
			 if ( $show_excerpt ) : ?>
				<div class="post-excerpt"><?php the_excerpt(); ?></div>
			<?php endif; ?>
		<?php endwhile; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();
		endif;
return ob_get_clean();
}

add_shortcode('club_news','club_news');
add_shortcode('members_only','members_only');

function toast_excerpt_more( $more ) {
	return ' <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">[' . __('Read More', 'your-text-domain') . ']</a>';
}
function toastmasters_sidebar_mce_css( $mce_css ) {
	if ( ! empty( $mce_css ) )
		$mce_css .= ',';

	$mce_css .= plugins_url( '/rsvpmaker-for-toastmasters/sidebar.css');

	return $mce_css;
}


function agenda_sidebar_editor ($post_id) {

ob_start();
?>
<h2><?php _e("Sidebar Content",'rsvpmaker-for-toastmasters');?></h2>
<div style="width: 500px;">
<p><?php _e("Use this space for dues reminders, previews of upcoming events and other supporting information.",'rsvpmaker-for-toastmasters');?></p>
<?php

$custom = get_post_meta($post_id,'_tm_sidebar',true);
$template = (int) get_post_meta($post_id,'_meet_recur',true);
$sked = ($template) ? false : get_post_meta($post_id,'_sked',true);

if(empty($custom) && $template)	
	{
	$sidebar = get_post_meta($template,'_tm_sidebar',true);		
	$sidebar_officers = get_post_meta($template,'_sidebar_officers',true);		
	}
else
	{
	$sidebar = $custom;
	$sidebar_officers = get_post_meta($post_id,'_sidebar_officers',true);		
	}

if(empty($custom) && $template)
	{
	$sidebar = get_post_meta($template,'_tm_sidebar',true);		
	$sidebar_officers = get_post_meta($template,'_sidebar_officers',true);		
	printf( '<p>%s <input type="radio" name="template" value="0" /> %s <input type="radio" name="template" value="%d" checked="checked" /> %s</p>',__('Apply edit to','rsvpmaker-for-toastmasters'),__('This event only','rsvpmaker-for-toastmasters'),$template,__('Template (default for future events)','rsvpmaker-for-toastmasters') );
	}
else
	{
	if(is_array($sked) )
		printf( '<p>%s: %s</p><input type="hidden" name="template" value="%d" />',__('Will be applied to','rsvpmaker-for-toastmasters'),__('Template (default for future events)','rsvpmaker-for-toastmasters'), $post_id );
	elseif($template)
		printf( '<p>%s <input type="radio" name="template" value="0" /> %s <input type="radio" name="template" value="%d" checked="checked" /> %s</p>',__('Apply edit to','rsvpmaker-for-toastmasters'),__('This event only','rsvpmaker-for-toastmasters'),$template,__('Template (default for future events)','rsvpmaker-for-toastmasters') );
	else
		printf( '<p>%s: %s</p>',__('Will be applied to','rsvpmaker-for-toastmasters'),__('This event only','rsvpmaker-for-toastmasters') );	
	$sidebar = $custom;
	$sidebar_officers = get_post_meta($post_id,'_sidebar_officers',true);		
	}

if(is_admin())
	{
	$editor_id = "_tm_sidebar";
	
	$settings = array();
	
	wp_editor( $sidebar, $editor_id, $settings );
	}
else
	{ ?>
<textarea name="_tm_sidebar" rows="5" cols="80" class="mce"><?php 
echo wpautop($sidebar); ?> </textarea>
<?php
	}
?>
</div>
<p><input type="checkbox" name="sidebar_officers" value="1" <?php if($sidebar_officers) echo ' checked="checked" ' ?> > <?php _e("Include officer listing",'rsvpmaker-for-toastmasters');?></p>
<?php
return ob_get_clean();
}

//boost random password complexity
function password_hurdle ($pass) {
$upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$lower = 'abcdefghijklmnopqrstuvwxyz';
$symbols = '!@#$%^&*()';
if(!preg_match('/[!@#$%^&*()]/',$pass) )
	$pass .= $symbols[ rand(0,9) ];
if(!preg_match('/[0-9]/',$pass) )
	$pass .= rand(0,9);
if(!preg_match('/[a-z]/',$pass) )
	$pass .= $lower[rand(0,25)];
if(!preg_match('/[A-Z]/',$pass) )
	$pass .= $upper[rand(0,25)];
return $pass;
}

function show_wpt_promo($atts = array()) {
$width = (isset($atts["width"])) ? $atts["width"] : 1030;
$height = (isset($atts["height"])) ? $atts["height"] : 300;
?>

<div style="background-color: #000; padding: 15px; width: <?php echo $width; ?>px;"><h1 style="color: #fff;">Support the WordPress for Toastmasters Project</h1>

<div style="float: left; width: 250px; height: <?php echo $height; ?>px; background-color: #fff; padding: 10px; margin-right: 5px; margin-top: 5px;">
<h3>Web Developer's Tip Jar</h3>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="CF5QHBWBNG7AY">
<table>
<tr><td><input type="hidden" name="on0" value="Happiness Scale">Happiness Scale</td></tr><tr><td><select name="os0">
	<option value="Happy">Happy $50.00 USD</option>
	<option value="Very Happy">Very Happy $100.00 USD</option>
	<option value="Extremely Happy">Extremely Happy $200.00 USD</option>
	<option value="Project Sponsor">Project Sponsor $500.00 USD</option>
</select> </td></tr>
</table>
<input type="hidden" name="currency_code" value="USD">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
<p>Financial contributions offset project expenses such as web hosting and security.</p>
</div>

<div style="float: left; width: 300px; height: <?php echo $height; ?>px; background-color: #fff; padding: 10px; margin-right: 5px; margin-top: 5px;">
<h3>Advertise on Toastmost.org</h3>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="98TYNDX3RZSVU">
<table>
<tr><td><input type="hidden" name="on0" value="Advertisement">Advertisement</td></tr><tr><td><select name="os0">
	<option value="Sidebar Ad: 1 Month">Sidebar Ad: 1 Month $200.00 USD</option>
	<option value="Sidebar Ad: 3 Months">Sidebar Ad: 3 Months $500.00 USD</option>
	<option value="Sidebar Ad: 6 Months">Sidebar Ad: 6 Months $750.00 USD</option>
	<option value="Sidebar Ad: 1 Year">Sidebar Ad: 1 Year $1,000.00 USD</option>
	<option value="Exclusive Sponsor: 1 Year">Exclusive Sponsor: 1 Year $2,000.00 USD</option>
</select> </td></tr>
</table>
<input type="hidden" name="currency_code" value="USD">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
<p>Advertise to Toastmasters leaders in the clubs who take advantage of the free website offer at toastmost.org (example: <a target="_blank" href="https://demo.toastmost.org">demo.toastmost.org</a>). Ads appear in the sidebar of the page.</p>
</div>

<div style="float: left; width: 400px; height: <?php echo $height; ?>px; background-color: #fff; padding: 10px; margin-top: 5px;">
<h3>Contribute Time, Talent, Connections</h3>
<p>This project started as a one-man show, a solution for a single club, but it needs to grow. Can you help spread the word about this project? Contribute documentation or training resources? Do you have web development or design skills to offer?</p>
<p>Contact David F. Carr, founder and chief developer, <a target="_blank" href="https://wp4toastmasters.com">WordPress for Toastmasters</a>, <a target="_blank" href="mailto:david@wp4toastmasters.com">david@wp4toastmasters.com</a>, <a target="_blank" href="https://www.facebook.com/wp4toastmasters">Project Facebook page</a></p>
<ul><li>Business website: <a target="_blank" href="http://www.carrcommunications.com">Carr Communications Inc.</a></li><li>Blog on digital business topics: <a target="_blank" href="http://blogs.forbes.com/davidcarr/">blogs.forbes.com/davidcarr/</a></li><li><a target="_blank" href="https://twitter.com/davidfcarr">Twitter @davidfcarr</a> <a target="_blank" href="http://www.linkedin.com/in/davidfcarr">LinkedIn</a></li></ul>
</div>

<div style="clear: left"></div>

</div>
<div style="text-align: center; margin-top: 5px; width: 1030px;">WordPress for Toastmasters is a project of <a target="_blank" href="https://www.carrcommunications.com">Carr Communications Inc.</a> and receives no financial or logistical support from Toastmasters International.<br />The Toastmasters-branded theme Lectern has been reviewed for conformance to Toastmasters branding requirements.</div>
<?php
}

function rsvptoast_admin_notice() {
global $wpdb;
global $current_user;
global $post;

/* notices NOT just for admin */

$next_show_promo = (int) get_user_meta($current_user->ID,'next_show_promo',true);
if(($next_show_promo == 0) && sizeof(get_past_events()) < 10 )
	{
		//newish site, too soon
		$next_show_promo = strtotime('+ 1 month');
		update_user_meta($current_user->ID,'next_show_promo',$next_show_promo);
	}
if((time() > $next_show_promo ) || isset($_GET["show_ad"]) )
{
show_wpt_promo();
$next_show_promo = strtotime('+ 1 week');
update_user_meta($current_user->ID,'next_show_promo',$next_show_promo);
}

if(isset($_GET["action"]) && ($_GET["action"] == 'edit') && isset($post->post_content) && strpos($post->post_content,'[toastmaster'))
{
$template_id = get_post_meta($post->ID,'_meet_recur',true);
?>
<div class="notice notice-info"><div style="float: right; width: 225px; padding: 5px; background-color: #fff; margin-left:5px;"><img src="<?php echo plugins_url('rsvpmaker-for-toastmasters/mce/toastmasters_editor_buttons.png')?>" /><br /><em>Toastmasters custom buttons</em></div>

<p><?php _e("You can drag-and-drop to reorder roles or add new roles using the Toastmasters Roles button. Double-click on the placeholder for a role to edit options. Setting the count for a role to more than one opens up multiple signup slots (for example, multiple speakers and multiple evaluators). Your choices determine the roles that will appear on the online signup form, the printable signup form, and the agenda.",'rsvpmaker-for-toastmasters');?></p>
<p><?php _e("Use the Agenda Note button to provide additional 'stage directions' that will appear on thet agenda. Entering a label such as 'Meeting Theme' in the 'Editable field' blank will allow you to add meeting-specific content as part of the same process where you edit signups for roles. You can specify whether agenda notes should appear on the agenda only, on the signup form only, or both.",'rsvpmaker-for-toastmasters');?></p>

<?php
if($template_id)
	{
		printf('<p>%s <a href="%s">%s</a></p>',__('Changes made below will be applied to a single event. To change the agenda for all future events: '),admin_url('post.php?action=edit&post='.$template_id),__('Edit Template'));
	}
?>
</div>
<?php
}

$sync_ok = get_option('wp4toastmasters_enable_sync');

if($sync_ok)
{
if(isset($_GET["page"]) && (($_GET["page"] == 'my_progress_report') || isset($_GET["toastmaster"]) ) )
	{
		$user_id = (isset($_GET["toastmaster"])) ? $_GET["toastmaster"] : $current_user->ID;
		$toastmasters_id = get_user_meta($user_id,'toastmasters_id',true);
		if($toastmasters_id)
			{
			$sync_result = wpt_json_user_id ($user_id, $toastmasters_id);
			if(!empty($sync_result))
				echo '<div class="notice notice-info"><p>'.$sync_result.'</p></div>';
			}
	}
else
	{
	$sync = wpt_json_batch_upload();
	if($sync)
		echo '<div class="notice notice-info"><p>'.$sync."</p></div>\n";
	}
}

/* notices for admin only */

if(!current_user_can('manage_options'))
	return;

if($sync_ok == '') // if not 1 or 0
	{
	echo '<div class="notice notice-info"><p>'.sprintf(__('You can choose to allow the member data on the Progress Reports screen to sync with other websites that use this software. See <a target="_blank" href="https://wp4toastmasters.com/2017/05/13/sync-member-progress-report-data/">blog post</a>.</p><p>Choose whether this should be on our off: <a href="%s">Toastmasters Settings.</a>','rsvpmaker-for-toastmasters'), admin_url('options-general.php?page=wp4toastmasters_settings') )."</p></div>\n";
	}


$cleared = get_option('cleared_rsvptoast_notices');
$cleared = is_array($cleared) ? $cleared : array();
if(isset($_GET['cleared_rsvptoast_notices']) && $_GET['cleared_rsvptoast_notices'])
 	{
		$cleared[] = $_GET['cleared_rsvptoast_notices'];
		update_option('cleared_rsvptoast_notices',$cleared);
	}
if(isset($_GET["create_welcome_page"]) && ($_GET["create_welcome_page"] == 0))
	{
		$cleared[] = 'front';
		update_option('cleared_rsvptoast_notices',$cleared);
	}
if(isset($_GET["meetings_nag"]) && ($_GET["meetings_nag"] == 0))
	{
		$cleared[] = 'meetings_nag';
		update_option('cleared_rsvptoast_notices',$cleared);
	}

if(current_user_can('edit_member_stats') && !in_array('update_history',$cleared))
	{
		$count = $wpdb->get_var("SELECT count(*) FROM $wpdb->posts WHERE post_type='rsvpmaker' ");
		if($count < 5)
			{//new site, not a surprise
			$cleared[] = 'update_history';
			update_option('cleared_rsvptoast_notices',$cleared);
			}
		else
			{
			echo '<div class="notice notice-info"><p>'.sprintf(__('The Reconcile screen has been renamed Update History and can now be used to record backdated information such as speeches delivered before you started using this software. See <a target="_blank" href="https://wp4toastmasters.com/2017/05/07/updating-member-history/">blog post</a> for explanation of this and related changes.</p><p><a href="%s">Got it: stop showing this notice.</a>','rsvpmaker-for-toastmasters'), admin_url('admin.php?page=toastmasters_reconcile&cleared_rsvptoast_notices=update_history') )."</p></div>\n";
			}
	}

if(isset($_POST["sked"]))
	delete_option('default_toastmasters_template');

$pdir = str_replace('rsvpmaker-for-toastmasters/','',plugin_dir_path( __FILE__ ));

if(!is_plugin_active('rsvpmaker/rsvpmaker.php')){
	if(file_exists($pdir.'rsvpmaker/rsvpmaker.php'  ) )
		echo '<div class="error"><p>'.sprintf(__('The RSVPMaker plugin is required for all Toastmasters functions. RSVPMaker is installed but must be activated. <a href="%s#name">Activate now</a>','rsvpmaker-for-toastmasters'),admin_url('plugins.php?s=rsvpmaker') )."</p></div>\n";
	else
		echo  '<div class="error"><p>'.sprintf(__('The RSVPMaker plugin is required for all Toastmasters functions. RSVPMaker must be installed and activated. <a href="%s">Install now</a>','rsvpmaker-for-toastmasters'),admin_url('plugin-install.php?tab=search&s=rsvpmaker#plugin-filter'))."</p></div>\n";
return; // if this is not configured, the rest doesn't matter
}

if(!in_array('lectern',$cleared))
{
$my_theme = wp_get_theme();
$theme_name = $my_theme->get( 'Name' );
if($theme_name != 'Lectern')
	{
	if(file_exists( get_theme_root().'/lectern/style.css' ) )
		echo '<div class="error"><p>'.sprintf(__('The Lectern theme (recommended for Toastmasters branding) is installed but not active. <a href="%s">Activate now</a> or <a href="%s">No thanks,</a> I prefer another theme.','rsvpmaker-for-toastmasters'),admin_url('themes.php?search=Lectern#lectern-action'), admin_url('options-general.php?page=wp4toastmasters_settings&cleared_rsvptoast_notices=lectern') )."</p></div>\n";
	else
		echo  '<div class="error">'.sprintf(__('The Lectern theme (recommended for Toastmasters branding) is not installed or activated. <a href="%s">Install it now</a> or <a href="%s">No thanks,</a> I prefer another theme.','rsvpmaker-for-toastmasters'),admin_url('theme-install.php?theme=lectern'), admin_url('options-general.php?page=wp4toastmasters_settings&cleared_rsvptoast_notices=lectern'))."</div>\n";
	return;
	}
}

if(!get_option('page_on_front') && !in_array('front',$cleared))
	{
	if(isset($_GET["create_welcome_page"]) && $_GET["create_welcome_page"])
	{
		echo '<div class="updated">';
		global $current_user;
		
		if(isset($_REQUEST["oldsite"]) && !empty($_REQUEST["oldsite"]))
		{
		$response = wp_remote_get( $_REQUEST["oldsite"] );
			if( is_array($response) ) {
			  $header = $response['headers']; // array of http header lines
			  $html = $response['body']; // use the content
			} 
		$chunks = preg_split('/<div id="[^"]+" class="MainAccordion">/',$html);
		if(sizeof($chunks) > 1)
			$html = $chunks[1];
		else
			{
		    $html = preg_replace(array(// Remove invisible content
            '@<head[^>]*?>.*?</head>@siu',
            '@<style[^>]*?>.*?</style>@siu',
            '@<script[^>]*?.*?</script>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu',
            ),
        "", //replace above with nothing
        $html );
		echo '<p>'.__('Imported content may include extraneous text/links, such as content of menus and sidebars.','rsvpmaker-for-toastmasters').'</p>';
			}
		$welcome = preg_replace('/(<[^>]+) style=".*?"/i', '$1', strip_tags($html,'<p><a><h1><h2><h3><b><strong><i><em><img>'));
		$welcome = str_replace('&nbsp;',' ',$welcome);
		echo '<p>'.__('Be sure to check imported content for formatting errors. Plan to replace photos and other images, which are included as references to your old website.','rsvpmaker-for-toastmasters').'</p>';
		}
		else
			$welcome = '<span style="color: #ff0000;"><strong>Your custom welcome message here:</strong></span> Delete this and replace it with what YOU want to say about your club.

Some boilerplate content from toastmasters.org is concluded below to get you started, but right up at the top of the page here you should say <em>what makes your club special</em>. Don\'t be afraid to <a href="http://wp4toastmasters.com/2014/11/16/your-toastmasters-club-website-show-some-personality/">show some personality</a>!

<a href="http://demo.toastmost.org/wp-content/uploads/sites/22/2014/08/06_Networking_LR.jpg"><img class="aligncenter wp-image-516 size-full" src="http://demo.toastmost.org/wp-content/uploads/sites/22/2014/08/06_Networking_LR.jpg" alt="06_Networking_LR" width="864" height="576" /></a>

A group photo of smiling club members is a very common element to include at the top of the page, but also try to include photos of your members in action -- speaking, laughing, and learning. If you have video of a members giving dynamic speeches, or improvising their way through Table Topics, including one of those on the home page could be a good way of showing what Toastmasters is all about.

Make sure you hit the basics -- where and when does your club meet? If the location is tricky to find, consider including a map or a link to an online mapping service or a photo of the entry to the building.

See the video tutorial on <a href="http://wp4toastmasters.com/2016/02/10/adding-and-editing-club-website-content/">adding and editing content for a WordPress for Toastmasters website</a>.

<h3>The proven way to help you speak and lead.</h3>

<a href="http://demo.toastmost.org/wp-content/uploads/sites/22/2014/08/28_ClubMeetings.jpg"><img class="alignright size-medium wp-image-513" src="http://demo.toastmost.org/wp-content/uploads/sites/22/2014/08/28_ClubMeetings-300x278.jpg" alt="28_ClubMeetings" width="300" height="278" /></a>Congratulations - you\'re on your way to becoming a better communicator and leader! Toastmasters International, founded in 1924, is a proven product, regarded as the leading organization dedicated to communication and leadership skill development. As a member, you will gain all the tools, resources and support you need.

Through its worldwide network of clubs, Toastmasters helps nearly 280,000 people communicate effectively and achieve the confidence to lead others. Why pay thousands of dollars for a seminar or class when you can join a Toastmasters club for a fraction of the cost and have fun in the process?
<h3>What\'s in it for you?</h3>
Toastmasters is a place where you develop and grow - both personally and professionally. You join a community of learners, and in Toastmasters meetings we learn by doing. Whether you\'re an executive or a stay-at-home parent, a college student or a retiree, you will improve yourself; building skills to express yourself in a variety of situations. You\'ll open up a world of new possibilities: giving better work presentations; leading meetings - and participating in them - more confidently; speaking more smoothly off the cuff; even handling one-on-one interactions with family, friends and colleagues more positively.

<h3>How does it work?</h3>
<a href="http://demo.toastmost.org/wp-content/uploads/sites/22/2014/08/02_Evaluations_LR.jpg"><img class="alignright size-medium wp-image-514" src="http://demo.toastmost.org/wp-content/uploads/sites/22/2014/08/02_Evaluations_LR-200x300.jpg" alt="02_Evaluations_LR" width="200" height="300" /></a>The environment in a Toastmasters club is friendly and supportive. Everyone at a Toastmasters meeting feels welcome and valued - from complete beginners to advanced speakers. In a club meeting, you practice giving prepared speeches as well as brief impromptu presentations, known as Table Topics. There is no rush and no pressure: The Toastmasters program allows you to progress at your own pace.

Constructive evaluation is central to the Toastmasters philosophy. Each time you give a prepared speech, an evaluator will point out strengths as well as suggest improvements. Receiving - and giving - such feedback is a great learning experience. In Toastmasters, encouragement and improvement go hand-in-hand.

Toastmasters currently has more than 332,000 members in 135 countries. Our club is just one of the more than 15,400 clubs located around the world.

<h3>Good leaders are good communicators</h3>

Anyone who is a strong leader has to first be an effective communicator. In Toastmasters you will hone your speaking skills, and you will develop leadership abilities - through evaluations, listening, mentoring, serving as club officers and filling roles in club meetings. You will take those leadership skills out into the world, running businesses, mentoring youths, organizing fund-raisers, coaching teams and heading up families.';
		$post = array(
		  'post_content'   => $welcome,
		  'post_name'      => 'welcome',
		  'post_title'     => 'Welcome',
		  'post_status'    => 'publish',
		  'post_type'      => 'page',
		  'post_author'    => $current_user->ID,
		  'ping_status'    => 'closed'
		);
		$home_id = wp_insert_post($post);
		
		$post = array(
		  'post_content'   => '',
		  'post_name'      => 'blog',
		  'post_title'     => __('Blog','rsvpmaker-for-toastmasters'),
		  'post_status'    => 'publish',
		  'post_type'      => 'page',
		  'post_author'    => $current_user->ID,
		  'ping_status'    => 'closed'
		);
		$blog_id = wp_insert_post($post);
	update_option('show_on_front','page');
	update_option('page_on_front',$home_id);
	update_option('page_for_posts',$blog_id);
	printf('<p><a href="%s">'.__('Edit welcome page','rsvpmaker-for-toastmasters').'</a></p>',admin_url('post.php?action=edit&post=').$home_id);
	if(isset($_GET["addpages"]))
		rsvptoast_pages($current_user->ID);
	echo "</div>";
	}
	else {
	?>
    <div class="error">
    <p>Do you want to create a welcome page as the front page (rather than having a blog listing as the front page)? Optionally, you can import content from an existing site on (such as Free Toast Host / toastmastersclubs.org site).</p>
    <form action="<?php echo admin_url('edit.php?post_type=page'); ?>" method="get">
    <p><input type="radio" name="create_welcome_page" value="1" checked="checked">Yes - import from <input type="text" name="oldsite" size="60" placeholder="http://"> </p>
    <p><input type="radio" name="create_welcome_page" value="0">No, I prefer the blog listing as front page.</p>
    <p><input type="checkbox" name="addpages" value="1" checked="checked" /> Add pages for calendar, member directory, Toastmasters Internation info; set up menu.</p>
    <button><?php _e('Submit','rsvpmaker-for-toastmasters') ?></button>
    </form>
    </div>
	<?php
	}
	return;
	} // end page on front routine

	$d = get_option('default_toastmasters_template');
	if($d)
		{
		if(isset($_GET["page"]) && ($_GET["page"] == 'agenda_setup') )
			return; // don't prompt if already doing it

?>
<div class="error">
<p><a href="<?php echo admin_url('edit.php?post_type=rsvpmaker&page=agenda_setup&post_id=').$d; ?>">Set up meeting schedule and roles</a>.</p>
</div>
<?php			
		return;
		}

if(!in_array('users',$cleared))
{
$blogusers = get_users('blog_id='.get_current_blog_id() );
if( sizeof($blogusers) == 1 )
	printf('<div class="error"><p>'.__('<a href="%s">Add club members</a> as website users. You can import your whole roster, using the spreadsheet from toastmasters.org\'s Club Central. Or selectively add a few members to help you with testing.','rsvpmaker-for-toastmasters').'</p></div>',admin_url('users.php?page=add_awesome_member'));
}

if(!in_array('wp-user-avatar',$cleared) && !is_plugin_active('wp-user-avatar/wp-user-avatar.php')){
	if(file_exists($pdir.'wp-user-avatar/wp-user-avatar.php'  ) )
		echo '<div class="error"><p>'.sprintf(__('The WP User Avatar plugin is recommended for allowing members to add a profile picture. WP User Avatar is installed but must be activated. <a href="%s#name">Activate now</a> or <a href="%s">No thanks</a>','rsvpmaker-for-toastmasters'),admin_url('plugins.php?s=wp-user-avatar'), admin_url('options-general.php?page=wp4toastmasters_settings&cleared_rsvptoast_notices=wp-user-avatar') )."</p></div>\n";
	else
		echo  '<div class="error"><p>'.sprintf(__('The WP User Avatar plugin is recommended for allowing members to add a profile picture. <a href="%s">Install now</a> or <a href="%s">No thanks</a>','rsvpmaker-for-toastmasters'),admin_url('plugin-install.php?tab=search&s=wp-user-avatar#plugin-filter'), admin_url('options-general.php?page=wp4toastmasters_settings&cleared_rsvptoast_notices=wp-user-avatar') )."</p></div>\n";
}

if(!in_array('settings',$cleared))
{

if(!isset($missing)) $missing = '';

if(get_option('wp4toast_reminder') && !get_option('wp4toast_reminders_cron'))
{
	$missing .= '<li>'.__('Meeting role reminders need to be reset.','rsvpmaker-for-toastmasters').'</li>';
}

if(! get_option('wp4toastmasters_officer_ids'))
	$missing .= '<li>'.__('You have not yet set the officers list for your club.','rsvpmaker-for-toastmasters').'</li>';

$public = get_option('blog_public');

if(!$public)
	$missing .= '<li>'.__('This site is not being indexed by search engines. Set it to public?','rsvpmaker-for-toastmasters').'</li>';

$tz = get_option('timezone_string');
if(empty($tz) )
	$missing .= '<li>'.__('Make sure to set the correct timezone for your site so scheduling functions will work properly.','rsvpmaker-for-toastmasters').'</li>';

if(!empty($missing) )
	printf('<div class="error"><p>'.__('Visit the <a href="%s">Toastmasters Settings</a> screen','rsvpmaker-for-toastmasters').'<p><ul>'.$missing.'</ul></div>',admin_url('options-general.php?page=wp4toastmasters_settings'));

}

if(!in_array('meetings_nag',$cleared) && !strpos($_SERVER['REQUEST_URI'],'rsvpmaker_template_list') && !strpos($_SERVER['REQUEST_URI'],'agenda_setup')) // don't test if already on the projected dates page
{
global $wpdb;
		$future = get_future_events(" post_content LIKE '%[toastmaster %' ");
		$upcoming = sizeof($future);
if($upcoming == 0)
	printf('<div class="error"><p>'.__('No meetings currently published. Add based on template (standard schedule and roles):</p><ul>%s</ul>','rsvpmaker-for-toastmasters').'</div>',get_toast_templates () );
elseif($upcoming < 5)
	printf('<div class="notice"><p>'.$upcoming.' '.__('meetings currently published. Add more based on template (standard schedule and roles):</p><ul>%s</ul>','rsvpmaker-for-toastmasters').'or <a href="%s">clear reminder</a></div>',get_toast_templates (), admin_url('options-general.php?page=wp4toastmasters_settings&cleared_rsvptoast_notices=meetings_nag') );
}
}



function get_toast_templates () {

global $post;
$post_backup = $post;
global $wp_query;

add_filter('posts_fields', 'rsvpmaker_template_fields' );

add_filter('posts_join', 'rsvpmaker_template_join' );

add_filter('posts_where', 'rsvpmaker_template_where' );

add_filter('posts_orderby', 'rsvpmaker_template_orderby' );

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$querystring = "post_type=rsvpmaker&post_status=publish&paged=$paged&posts_per_page=50";

$backup = $wp_query;

$wp_query = new WP_Query($querystring);
$templates_projected = '';
while ( have_posts() ) { the_post();

		$template_recur_url = admin_url('edit.php?post_type=rsvpmaker&page=rsvpmaker_template_list&t='.$post->ID);

		$templates_projected .= sprintf('<li><a href="%s#template_ck">%s</a></li>',$template_recur_url,$post->post_title);

	}

remove_filter('posts_fields', 'rsvpmaker_template_fields' );

remove_filter('posts_join', 'rsvpmaker_template_join' );

remove_filter('posts_where', 'rsvpmaker_template_where' );

remove_filter('posts_orderby', 'rsvpmaker_template_orderby' );

$wp_query = $backup;
$post = $post_backup;

wp_reset_postdata();

return $templates_projected;

}

// make lectern default to Toastmasters branding
function wp4t_header($default) {
return 'http://wp4toastmasters.com/tmbranding/toastmasters3.jpg';
}

function rsvptoast_pages ($user_id) {
	$post = array(
	  'post_content'   => '[awesome_members comment="This placeholder code displays the member listing"]',
	  'post_name'      => 'members',
	  'post_title'     => 'Members',
	  'post_status'    => 'publish',
	  'post_type'      => 'page',
	  'post_author'    => $user_id,
	  'ping_status'    => 'closed'
	);
	$members = wp_insert_post($post);
	$post = array(
	  'post_content'   => '[rsvpmaker_upcoming calendar="1" comment="This placeholder code displays the calendar of events."]',
	  'post_name'      => 'calendar',
	  'post_title'     => 'Calendar',
	  'post_status'    => 'publish',
	  'post_type'      => 'page',
	  'post_author'    => $user_id,
	  'ping_status'    => 'closed'
	);
	$calendar = wp_insert_post($post);

	$post = array(
	  'post_content'   => 'We are part of <a href="http://www.toastmasters.org">Toastmasters International</a>, a world leader in communication and leadership development. Worldwide membership is 313,000 strong. These members improve their speaking and leadership skills by attending one of the 14,650 clubs in 126 countries that make up our global network of meeting locations.

Membership in Toastmasters is one of the greatest investments you can make in yourself.

<b>How Does It Work?</b>

A Toastmasters meeting is a learn-by-doing workshop in which participants hone their speaking and leadership skills in a no-pressure atmosphere.

There is no instructor in a Toastmasters meeting. Instead, members evaluate one another’s presentations. This feedback process is a key part of the program’s success.

Meeting participants also give impromptu talks on assigned topics, conduct meetings and develop skills related to timekeeping, grammar and parliamentary procedure.

Members learn communication skills by working in the <a href="http://www.toastmasters.org/Members/MemberExperience/EducationalProgram/CommunicationTrack.aspx" target="_blank">Competent Communication manual</a>, a series of 10 self-paced speaking assignments designed to instill a basic foundation in public speaking.

https://www.youtube.com/watch?v=AykYRO5d_lI',
	  'post_name'      => 'toastmasters-international',
	  'post_title'     => 'Toastmasters International',
	  'post_status'    => 'publish',
	  'post_type'      => 'page',
	  'post_author'    => $user_id,
	  'ping_status'    => 'closed'
	);
	$tm = wp_insert_post($post);

$name = 'Primary Menu';
  $menu_id = wp_create_nav_menu($name);
  $menu = get_term_by( 'name', $name, 'nav_menu' );
  $blog_id = get_option('page_for_posts');
  $home_id = get_option('page_on_front');

if($home_id)
	$args = array(
'menu-item-object-id' => $home_id,
'menu-item-title' =>  __('Welcome'),
'menu-item-classes' => 'welcome',
'menu-item-object' => 'page',
'menu-item-type' => 'post_type',	  
'menu-item-status' => 'publish');
else
	$args = array(
'menu-item-title' =>  __('Welcome'),
'menu-item-classes' => 'welcome',
'menu-item-url' => '/',
'menu-item-status' => 'publish');
  wp_update_nav_menu_item($menu->term_id, 0, $args);

if($blog_id)
  wp_update_nav_menu_item($menu->term_id, 0, array(
'menu-item-object-id' => $blog_id,
'menu-item-title' =>  __('Blog'),
'menu-item-classes' => 'blog',
'menu-item-object' => 'page',
'menu-item-type' => 'post_type',	  
'menu-item-status' => 'publish'));
  wp_update_nav_menu_item($menu->term_id, 0, array(
'menu-item-object-id' => $calendar,
'menu-item-title' =>  __('Calendar'),
'menu-item-classes' => 'calendar',
'menu-item-object' => 'page',
'menu-item-type' => 'post_type',	  
'menu-item-status' => 'publish'));
  wp_update_nav_menu_item($menu->term_id, 0, array(
'menu-item-object-id' => $members,
'menu-item-title' =>  __('Members'),
'menu-item-classes' => 'members',
'menu-item-object' => 'page',
'menu-item-type' => 'post_type',	  
'menu-item-status' => 'publish'));
  wp_update_nav_menu_item($menu->term_id, 0, array(
'menu-item-object-id' => $tm,
'menu-item-title' =>  __('Toastmasters International'),
'menu-item-classes' => 'tm',
'menu-item-object' => 'page',
'menu-item-type' => 'post_type',	  
'menu-item-status' => 'publish'));
	  
  // you add as many items as you need with wp_update_nav_menu_item()

  //then you set the wanted theme  location
  $locations = get_theme_mod('nav_menu_locations');
  $locations['primary-menu'] = $menu->term_id;
  $locations['primary'] = $menu->term_id;
  set_theme_mod( 'nav_menu_locations', $locations );

}

function placeholder_image () {
if(!isset($_GET["placeholder_image"]))
	return;
$impath = dirname( __FILE__ ).DIRECTORY_SEPARATOR.'mce'.DIRECTORY_SEPARATOR.'placeholder.png';
$im = imagecreatefrompng($impath);
if(!$im)
{
$im = imagecreate(800, 50);
imagefilledrectangle($im,5,5,790,45, imagecolorallocate($im, 50, 50, 255));
}

// White background and blue text
$bg = imagecolorallocate($im, 200, 200, 255);
$border = imagecolorallocate($im, 0, 0, 0);
$textcolor = imagecolorallocate($im, 255, 255, 255);


$text = '';

if(isset($_GET["role"]))
	{
	$text = sprintf('Role: %s Count: %s',$_GET["role"],$_GET["count"]);
	$tip = '(double-click for popup editor)';
	}
elseif(isset($_GET["agenda_note"]))
	{
	$text = sprintf('Note: %s Display: %s',$_GET["agenda_note"],$_GET["agenda_display"]);
	$tip = '(double-click for popup editor)';
	}
elseif(isset($_GET["themewords"]))
	{
	$text = 'Placeholder for Theme/Words of the Day';
	$tip = '(no popup editor)';
	}
else
	$text = 'error: unrecognized';

// Write the string at the top left
imagestring($im, 5, 10, 10, $text, $textcolor);
imagestring($im, 5, 10, 25, $tip, $textcolor);

// Output the image
header('Content-type: image/png');

imagepng($im);
imagedestroy($im);
exit();
}

function get_manuals_array() {
return array("Select Manual/Path" => __("Select Manual/Path",'rsvpmaker-for-toastmasters'),"COMPETENT COMMUNICATION" => __("COMPETENT COMMUNICATION",'rsvpmaker-for-toastmasters'),"ADVANCED MANUAL TBD" => __("ADVANCED MANUAL TBD",'rsvpmaker-for-toastmasters'),"COMMUNICATING ON VIDEO" => __("COMMUNICATING ON VIDEO",'rsvpmaker-for-toastmasters'),"FACILITATING DISCUSSION" => __("FACILITATING DISCUSSION",'rsvpmaker-for-toastmasters'), "HIGH PERFORMANCE LEADERSHIP" => "HIGH PERFORMANCE LEADERSHIP","HUMOROUSLY SPEAKING" => "HUMOROUSLY SPEAKING","INTERPERSONAL COMMUNICATIONS"=>__("INTERPERSONAL COMMUNICATIONS",'rsvpmaker-for-toastmasters'),"INTERPRETIVE READING"=>__("INTERPRETIVE READING",'rsvpmaker-for-toastmasters'),"Other Manual or Non Manual Speech"=>__("Other Manual or Non Manual Speech",'rsvpmaker-for-toastmasters'),"PERSUASIVE SPEAKING"=>__("PERSUASIVE SPEAKING",'rsvpmaker-for-toastmasters'),"PUBLIC RELATIONS"=>__("PUBLIC RELATIONS",'rsvpmaker-for-toastmasters'),"SPEAKING TO INFORM"=>__("SPEAKING TO INFORM",'rsvpmaker-for-toastmasters'),"SPECIAL OCCASION SPEECHES"=>__("SPECIAL OCCASION SPEECHES",'rsvpmaker-for-toastmasters'),"SPECIALTY SPEECHES"=>__("SPECIALTY SPEECHES",'rsvpmaker-for-toastmasters'),"SPEECHES BY MANAGEMENT"=>__("SPEECHES BY MANAGEMENT",'rsvpmaker-for-toastmasters'),"STORYTELLING"=>__("STORYTELLING",'rsvpmaker-for-toastmasters'),"TECHNICAL PRESENTATIONS"=>__("TECHNICAL PRESENTATIONS",'rsvpmaker-for-toastmasters'),"THE DISCUSSION LEADER"=>__("THE DISCUSSION LEADER",'rsvpmaker-for-toastmasters'),"THE ENTERTAINING SPEAKER"=>__("THE ENTERTAINING SPEAKER",'rsvpmaker-for-toastmasters'),"THE PROFESSIONAL SALESPERSON"=>__("THE PROFESSIONAL SALESPERSON",'rsvpmaker-for-toastmasters'),"THE PROFESSIONAL SPEAKER"=>__("THE PROFESSIONAL SPEAKER",'rsvpmaker-for-toastmasters'),'BETTER SPEAKER SERIES' => __('BETTER SPEAKER SERIES','rsvpmaker-for-toastmasters'),'SUCCESSFUL CLUB SERIES'=> __('SUCCESSFUL CLUB SERIES','rsvpmaker-for-toastmasters'),'LEADERSHIP EXCELLENCE SERIES'=> __('LEADERSHIP EXCELLENCE SERIES','rsvpmaker-for-toastmasters')
,'Dynamic Leadership Level 1 Mastering Fundamentals'=> __('Dynamic Leadership Level 1 Mastering Fundamentals','rsvpmaker-for-toastmasters')
,'Dynamic Leadership Level 2 Learning Your Style'=> __('Dynamic Leadership Level 2 Learning Your Style','rsvpmaker-for-toastmasters')
,'Dynamic Leadership Level 3 Increasing Knowledge'=> __('Dynamic Leadership Level 3 Increasing Knowledge','rsvpmaker-for-toastmasters')
,'Dynamic Leadership Level 4 Building Skills'=> __('Dynamic Leadership Level 4 Building Skills','rsvpmaker-for-toastmasters')
,'Dynamic Leadership Level 5 Demonstrating Expertise'=> __('Dynamic Leadership Level 5 Demonstrating Expertise','rsvpmaker-for-toastmasters')
,'Effective Coaching Level 1 Mastering Fundamentals'=> __('Effective Coaching Level 1 Mastering Fundamentals','rsvpmaker-for-toastmasters')
,'Effective Coaching Level 2 Learning Your Style'=> __('Effective Coaching Level 2 Learning Your Style','rsvpmaker-for-toastmasters')
,'Effective Coaching Level 3 Increasing Knowledge'=> __('Effective Coaching Level 3 Increasing Knowledge','rsvpmaker-for-toastmasters')
,'Effective Coaching Level 4 Building Skills'=> __('Effective Coaching Level 4 Building Skills','rsvpmaker-for-toastmasters')
,'Effective Coaching Level 5 Demonstrating Expertise'=> __('Effective Coaching Level 5 Demonstrating Expertise','rsvpmaker-for-toastmasters')
,'Innovative Planning Level 1 Mastering Fundamentals'=> __('Innovative Planning Level 1 Mastering Fundamentals','rsvpmaker-for-toastmasters')
,'Innovative Planning Level 2 Learning Your Style'=> __('Innovative Planning Level 2 Learning Your Style','rsvpmaker-for-toastmasters')
,'Innovative Planning Level 3 Increasing Knowledge'=> __('Innovative Planning Level 3 Increasing Knowledge','rsvpmaker-for-toastmasters')
,'Innovative Planning Level 4 Building Skills'=> __('Innovative Planning Level 4 Building Skills','rsvpmaker-for-toastmasters')
,'Innovative Planning Level 5 Demonstrating Expertise'=> __('Innovative Planning Level 5 Demonstrating Expertise','rsvpmaker-for-toastmasters')
,'Leadership Development Level 1 Mastering Fundamentals'=> __('Leadership Development Level 1 Mastering Fundamentals','rsvpmaker-for-toastmasters')
,'Leadership Development Level 2 Learning Your Style'=> __('Leadership Development Level 2 Learning Your Style','rsvpmaker-for-toastmasters')
,'Leadership Development Level 3 Increasing Knowledge'=> __('Leadership Development Level 3 Increasing Knowledge','rsvpmaker-for-toastmasters')
,'Leadership Development Level 4 Building Skills'=> __('Leadership Development Level 4 Building Skills','rsvpmaker-for-toastmasters')
,'Leadership Development Level 5 Demonstrating Expertise'=> __('Leadership Development Level 5 Demonstrating Expertise','rsvpmaker-for-toastmasters')
,'Motivational Strategies Level 1 Mastering Fundamentals'=> __('Motivational Strategies Level 1 Mastering Fundamentals','rsvpmaker-for-toastmasters')
,'Motivational Strategies Level 2 Learning Your Style'=> __('Motivational Strategies Level 2 Learning Your Style','rsvpmaker-for-toastmasters')
,'Motivational Strategies Level 3 Increasing Knowledge'=> __('Motivational Strategies Level 3 Increasing Knowledge','rsvpmaker-for-toastmasters')
,'Motivational Strategies Level 4 Building Skills'=> __('Motivational Strategies Level 4 Building Skills','rsvpmaker-for-toastmasters')
,'Motivational Strategies Level 5 Demonstrating Expertise'=> __('Motivational Strategies Level 5 Demonstrating Expertise','rsvpmaker-for-toastmasters')
,'Persuasive Influence Level 1 Mastering Fundamentals'=> __('Persuasive Influence Level 1 Mastering Fundamentals','rsvpmaker-for-toastmasters')
,'Persuasive Influence Level 2 Learning Your Style'=> __('Persuasive Influence Level 2 Learning Your Style','rsvpmaker-for-toastmasters')
,'Persuasive Influence Level 3 Increasing Knowledge'=> __('Persuasive Influence Level 3 Increasing Knowledge','rsvpmaker-for-toastmasters')
,'Persuasive Influence Level 4 Building Skills'=> __('Persuasive Influence Level 4 Building Skills','rsvpmaker-for-toastmasters')
,'Persuasive Influence Level 5 Demonstrating Expertise'=> __('Persuasive Influence Level 5 Demonstrating Expertise','rsvpmaker-for-toastmasters')
,'Presentation Mastery Level 1 Mastering Fundamentals'=> __('Presentation Mastery Level 1 Mastering Fundamentals','rsvpmaker-for-toastmasters')
,'Presentation Mastery Level 2 Learning Your Style'=> __('Presentation Mastery Level 2 Learning Your Style','rsvpmaker-for-toastmasters')
,'Presentation Mastery Level 3 Increasing Knowledge'=> __('Presentation Mastery Level 3 Increasing Knowledge','rsvpmaker-for-toastmasters')
,'Presentation Mastery Level 4 Building Skills'=> __('Presentation Mastery Level 4 Building Skills','rsvpmaker-for-toastmasters')
,'Presentation Mastery Level 5 Demonstrating Expertise'=> __('Presentation Mastery Level 5 Demonstrating Expertise','rsvpmaker-for-toastmasters')
,'Strategic Relationships Level 1 Mastering Fundamentals'=> __('Strategic Relationships Level 1 Mastering Fundamentals','rsvpmaker-for-toastmasters')
,'Strategic Relationships Level 2 Learning Your Style'=> __('Strategic Relationships Level 2 Learning Your Style','rsvpmaker-for-toastmasters')
,'Strategic Relationships Level 3 Increasing Knowledge'=> __('Strategic Relationships Level 3 Increasing Knowledge','rsvpmaker-for-toastmasters')
,'Strategic Relationships Level 4 Building Skills'=> __('Strategic Relationships Level 4 Building Skills','rsvpmaker-for-toastmasters')
,'Strategic Relationships Level 5 Demonstrating Expertise'=> __('Strategic Relationships Level 5 Demonstrating Expertise','rsvpmaker-for-toastmasters')
,'Team Collaboration Level 1 Mastering Fundamentals'=> __('Team Collaboration Level 1 Mastering Fundamentals','rsvpmaker-for-toastmasters')
,'Team Collaboration Level 2 Learning Your Style'=> __('Team Collaboration Level 2 Learning Your Style','rsvpmaker-for-toastmasters')
,'Team Collaboration Level 3 Increasing Knowledge'=> __('Team Collaboration Level 3 Increasing Knowledge','rsvpmaker-for-toastmasters')
,'Team Collaboration Level 4 Building Skills'=> __('Team Collaboration Level 4 Building Skills','rsvpmaker-for-toastmasters')
,'Team Collaboration Level 5 Demonstrating Expertise'=> __('Team Collaboration Level 5 Demonstrating Expertise','rsvpmaker-for-toastmasters')
,'Visionary Communication Level 1 Mastering Fundamentals'=> __('Visionary Communication Level 1 Mastering Fundamentals','rsvpmaker-for-toastmasters')
,'Visionary Communication Level 2 Learning Your Style'=> __('Visionary Communication Level 2 Learning Your Style','rsvpmaker-for-toastmasters')
,'Visionary Communication Level 3 Increasing Knowledge'=> __('Visionary Communication Level 3 Increasing Knowledge','rsvpmaker-for-toastmasters')
,'Visionary Communication Level 4 Building Skills'=> __('Visionary Communication Level 4 Building Skills','rsvpmaker-for-toastmasters')
,'Visionary Communication Level 5 Demonstrating Expertise'=> __('Visionary Communication Level 5 Demonstrating Expertise','rsvpmaker-for-toastmasters')
 );
}

function get_pathways() {
return array('Dynamic Leadership Level 1 Mastering Fundamentals'=> __('Dynamic Leadership Level 1 Mastering Fundamentals','rsvpmaker-for-toastmasters')
,'Dynamic Leadership Level 2 Learning Your Style'=> __('Dynamic Leadership Level 2 Learning Your Style','rsvpmaker-for-toastmasters')
,'Dynamic Leadership Level 3 Increasing Knowledge'=> __('Dynamic Leadership Level 3 Increasing Knowledge','rsvpmaker-for-toastmasters')
,'Dynamic Leadership Level 4 Building Skills'=> __('Dynamic Leadership Level 4 Building Skills','rsvpmaker-for-toastmasters')
,'Dynamic Leadership Level 5 Demonstrating Expertise'=> __('Dynamic Leadership Level 5 Demonstrating Expertise','rsvpmaker-for-toastmasters')
,'Effective Coaching Level 1 Mastering Fundamentals'=> __('Effective Coaching Level 1 Mastering Fundamentals','rsvpmaker-for-toastmasters')
,'Effective Coaching Level 2 Learning Your Style'=> __('Effective Coaching Level 2 Learning Your Style','rsvpmaker-for-toastmasters')
,'Effective Coaching Level 3 Increasing Knowledge'=> __('Effective Coaching Level 3 Increasing Knowledge','rsvpmaker-for-toastmasters')
,'Effective Coaching Level 4 Building Skills'=> __('Effective Coaching Level 4 Building Skills','rsvpmaker-for-toastmasters')
,'Effective Coaching Level 5 Demonstrating Expertise'=> __('Effective Coaching Level 5 Demonstrating Expertise','rsvpmaker-for-toastmasters')
,'Innovative Planning Level 1 Mastering Fundamentals'=> __('Innovative Planning Level 1 Mastering Fundamentals','rsvpmaker-for-toastmasters')
,'Innovative Planning Level 2 Learning Your Style'=> __('Innovative Planning Level 2 Learning Your Style','rsvpmaker-for-toastmasters')
,'Innovative Planning Level 3 Increasing Knowledge'=> __('Innovative Planning Level 3 Increasing Knowledge','rsvpmaker-for-toastmasters')
,'Innovative Planning Level 4 Building Skills'=> __('Innovative Planning Level 4 Building Skills','rsvpmaker-for-toastmasters')
,'Innovative Planning Level 5 Demonstrating Expertise'=> __('Innovative Planning Level 5 Demonstrating Expertise','rsvpmaker-for-toastmasters')
,'Leadership Development Level 1 Mastering Fundamentals'=> __('Leadership Development Level 1 Mastering Fundamentals','rsvpmaker-for-toastmasters')
,'Leadership Development Level 2 Learning Your Style'=> __('Leadership Development Level 2 Learning Your Style','rsvpmaker-for-toastmasters')
,'Leadership Development Level 3 Increasing Knowledge'=> __('Leadership Development Level 3 Increasing Knowledge','rsvpmaker-for-toastmasters')
,'Leadership Development Level 4 Building Skills'=> __('Leadership Development Level 4 Building Skills','rsvpmaker-for-toastmasters')
,'Leadership Development Level 5 Demonstrating Expertise'=> __('Leadership Development Level 5 Demonstrating Expertise','rsvpmaker-for-toastmasters')
,'Motivational Strategies Level 1 Mastering Fundamentals'=> __('Motivational Strategies Level 1 Mastering Fundamentals','rsvpmaker-for-toastmasters')
,'Motivational Strategies Level 2 Learning Your Style'=> __('Motivational Strategies Level 2 Learning Your Style','rsvpmaker-for-toastmasters')
,'Motivational Strategies Level 3 Increasing Knowledge'=> __('Motivational Strategies Level 3 Increasing Knowledge','rsvpmaker-for-toastmasters')
,'Motivational Strategies Level 4 Building Skills'=> __('Motivational Strategies Level 4 Building Skills','rsvpmaker-for-toastmasters')
,'Motivational Strategies Level 5 Demonstrating Expertise'=> __('Motivational Strategies Level 5 Demonstrating Expertise','rsvpmaker-for-toastmasters')
,'Persuasive Influence Level 1 Mastering Fundamentals'=> __('Persuasive Influence Level 1 Mastering Fundamentals','rsvpmaker-for-toastmasters')
,'Persuasive Influence Level 2 Learning Your Style'=> __('Persuasive Influence Level 2 Learning Your Style','rsvpmaker-for-toastmasters')
,'Persuasive Influence Level 3 Increasing Knowledge'=> __('Persuasive Influence Level 3 Increasing Knowledge','rsvpmaker-for-toastmasters')
,'Persuasive Influence Level 4 Building Skills'=> __('Persuasive Influence Level 4 Building Skills','rsvpmaker-for-toastmasters')
,'Persuasive Influence Level 5 Demonstrating Expertise'=> __('Persuasive Influence Level 5 Demonstrating Expertise','rsvpmaker-for-toastmasters')
,'Presentation Mastery Level 1 Mastering Fundamentals'=> __('Presentation Mastery Level 1 Mastering Fundamentals','rsvpmaker-for-toastmasters')
,'Presentation Mastery Level 2 Learning Your Style'=> __('Presentation Mastery Level 2 Learning Your Style','rsvpmaker-for-toastmasters')
,'Presentation Mastery Level 3 Increasing Knowledge'=> __('Presentation Mastery Level 3 Increasing Knowledge','rsvpmaker-for-toastmasters')
,'Presentation Mastery Level 4 Building Skills'=> __('Presentation Mastery Level 4 Building Skills','rsvpmaker-for-toastmasters')
,'Presentation Mastery Level 5 Demonstrating Expertise'=> __('Presentation Mastery Level 5 Demonstrating Expertise','rsvpmaker-for-toastmasters')
,'Strategic Relationships Level 1 Mastering Fundamentals'=> __('Strategic Relationships Level 1 Mastering Fundamentals','rsvpmaker-for-toastmasters')
,'Strategic Relationships Level 2 Learning Your Style'=> __('Strategic Relationships Level 2 Learning Your Style','rsvpmaker-for-toastmasters')
,'Strategic Relationships Level 3 Increasing Knowledge'=> __('Strategic Relationships Level 3 Increasing Knowledge','rsvpmaker-for-toastmasters')
,'Strategic Relationships Level 4 Building Skills'=> __('Strategic Relationships Level 4 Building Skills','rsvpmaker-for-toastmasters')
,'Strategic Relationships Level 5 Demonstrating Expertise'=> __('Strategic Relationships Level 5 Demonstrating Expertise','rsvpmaker-for-toastmasters')
,'Team Collaboration Level 1 Mastering Fundamentals'=> __('Team Collaboration Level 1 Mastering Fundamentals','rsvpmaker-for-toastmasters')
,'Team Collaboration Level 2 Learning Your Style'=> __('Team Collaboration Level 2 Learning Your Style','rsvpmaker-for-toastmasters')
,'Team Collaboration Level 3 Increasing Knowledge'=> __('Team Collaboration Level 3 Increasing Knowledge','rsvpmaker-for-toastmasters')
,'Team Collaboration Level 4 Building Skills'=> __('Team Collaboration Level 4 Building Skills','rsvpmaker-for-toastmasters')
,'Team Collaboration Level 5 Demonstrating Expertise'=> __('Team Collaboration Level 5 Demonstrating Expertise','rsvpmaker-for-toastmasters')
,'Visionary Communication Level 1 Mastering Fundamentals'=> __('Visionary Communication Level 1 Mastering Fundamentals','rsvpmaker-for-toastmasters')
,'Visionary Communication Level 2 Learning Your Style'=> __('Visionary Communication Level 2 Learning Your Style','rsvpmaker-for-toastmasters')
,'Visionary Communication Level 3 Increasing Knowledge'=> __('Visionary Communication Level 3 Increasing Knowledge','rsvpmaker-for-toastmasters')
,'Visionary Communication Level 4 Building Skills'=> __('Visionary Communication Level 4 Building Skills','rsvpmaker-for-toastmasters')
,'Visionary Communication Level 5 Demonstrating Expertise'=> __('Visionary Communication Level 5 Demonstrating Expertise','rsvpmaker-for-toastmasters')
 );
}

function get_manuals_options( $manual = '') {
$manuals = get_manuals_array();
$out = "";
foreach($manuals as $manual_index => $manual_text)
	{
	$s = ($manual == $manual_index) ? ' selected="selected" ' : '';
	$out .= sprintf('<option value="%s" %s>%s</option>',$manual_index,$s,$manual_text);
	}
return $out;
}

function get_project_text($slug) {
$project = get_projects_array();
if(isset($project[$slug]))
	return $project[$slug];
return;
}

function get_project_key($project) {
$projects = get_projects_array();
return array_search($project, $projects);
}

function get_projects_array ($choice = 'projects')
{
$projects["COMPETENT COMMUNICATION 1"] = __("The Ice Breaker (4 to 6 min) (4 - 6 minutes)","rsvpmaker-for-toastmasters");
$project_options["COMPETENT COMMUNICATION"] = '<option value="COMPETENT COMMUNICATION 1">'.__("The Ice Breaker (4 to 6 min) (4 - 6 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["COMPETENT COMMUNICATION 1"] = 6;

$projects["COMPETENT COMMUNICATION 2"] = __("Organize Your Speech (5 to 7 min)","rsvpmaker-for-toastmasters");
$project_options["COMPETENT COMMUNICATION"] .= '<option value="COMPETENT COMMUNICATION 2">'.__("Organize Your Speech (5 to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["COMPETENT COMMUNICATION 2"] = 7;

$projects["COMPETENT COMMUNICATION 3"] = __("Get to the Point (5 to 7 min)","rsvpmaker-for-toastmasters");
$project_options["COMPETENT COMMUNICATION"] .= '<option value="COMPETENT COMMUNICATION 3">'.__("Get to the Point (5 to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["COMPETENT COMMUNICATION 3"] = 7;

$projects["COMPETENT COMMUNICATION 4"] = __("How to Say It (5 to 7 min)","rsvpmaker-for-toastmasters");
$project_options["COMPETENT COMMUNICATION"] .= '<option value="COMPETENT COMMUNICATION 4">'.__("How to Say It (5 to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["COMPETENT COMMUNICATION 4"] = 7;

$projects["COMPETENT COMMUNICATION 5"] = __("Your Body Speaks (5 to 7 min)","rsvpmaker-for-toastmasters");
$project_options["COMPETENT COMMUNICATION"] .= '<option value="COMPETENT COMMUNICATION 5">'.__("Your Body Speaks (5 to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["COMPETENT COMMUNICATION 5"] = 7;

$projects["COMPETENT COMMUNICATION 6"] = __("Vocal Variety (5 to 7 min)","rsvpmaker-for-toastmasters");
$project_options["COMPETENT COMMUNICATION"] .= '<option value="COMPETENT COMMUNICATION 6">'.__("Vocal Variety (5 to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["COMPETENT COMMUNICATION 6"] = 7;

$projects["COMPETENT COMMUNICATION 7"] = __("Research Your Topic (5 to 7 min)","rsvpmaker-for-toastmasters");
$project_options["COMPETENT COMMUNICATION"] .= '<option value="COMPETENT COMMUNICATION 7">'.__("Research Your Topic (5 to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["COMPETENT COMMUNICATION 7"] = 7;

$projects["COMPETENT COMMUNICATION 8"] = __("Get Comfortable with Visual Aids (5 to 7 min)","rsvpmaker-for-toastmasters");
$project_options["COMPETENT COMMUNICATION"] .= '<option value="COMPETENT COMMUNICATION 8">'.__("Get Comfortable with Visual Aids (5 to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["COMPETENT COMMUNICATION 8"] = 7;

$projects["COMPETENT COMMUNICATION 9"] = __("Persuade with Power (5 to 7 min)","rsvpmaker-for-toastmasters");
$project_options["COMPETENT COMMUNICATION"] .= '<option value="COMPETENT COMMUNICATION 9">'.__("Persuade with Power (5 to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["COMPETENT COMMUNICATION 9"] = 7;

$projects["COMPETENT COMMUNICATION 10"] = __("Inspire Your Audience (8 to 10 min)","rsvpmaker-for-toastmasters");
$project_options["COMPETENT COMMUNICATION"] .= '<option value="COMPETENT COMMUNICATION 10">'.__("1Inspire Your Audience (8 to 10 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["COMPETENT COMMUNICATION 10"] = 10;

$projects["ADVANCED MANUAL TBD 1"] = __("Placeholder for manual/project to be specified later","rsvpmaker-for-toastmasters");
$project_options["ADVANCED MANUAL TBD"] = '<option value="ADVANCED MANUAL TBD 1">'.__("Placeholder for manual/project to be specified later","rsvpmaker-for-toastmasters")."</option>";
$project_times["ADVANCED MANUAL TBD 1"] = 7;

$projects["COMMUNICATING ON VIDEO 1"] = __("Straight Talk (3 min) (3 minutes ±30 seconds)","rsvpmaker-for-toastmasters");
$project_options["COMMUNICATING ON VIDEO"] = '<option value="COMMUNICATING ON VIDEO 1">'.__("Straight Talk (3 min) (3 minutes ±30 seconds)","rsvpmaker-for-toastmasters")."</option>";
$project_times["COMMUNICATING ON VIDEO 1"] = 3;

$projects["COMMUNICATING ON VIDEO 2"] = __("The Interview Show (5 to 7 min)","rsvpmaker-for-toastmasters");
$project_options["COMMUNICATING ON VIDEO"] .= '<option value="COMMUNICATING ON VIDEO 2">'.__("The Interview Show (5 to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["COMMUNICATING ON VIDEO 2"] = 7;

$projects["COMMUNICATING ON VIDEO 3"] = __("When You Are the Host (5 to 7 min)","rsvpmaker-for-toastmasters");
$project_options["COMMUNICATING ON VIDEO"] .= '<option value="COMMUNICATING ON VIDEO 3">'.__("When You Are the Host (5 to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["COMMUNICATING ON VIDEO 3"] = 7;

$projects["COMMUNICATING ON VIDEO 4"] = __("The Press Conference (3 to 5 min + 2 to 3 min Q&A) (4-6 minutes, plus 8-10 minutes for Q&A)","rsvpmaker-for-toastmasters");
$project_options["COMMUNICATING ON VIDEO"] .= '<option value="COMMUNICATING ON VIDEO 4">'.__("The Press Conference (3 to 5 min + 2 to 3 min Q&A) (4-6 minutes, plus 8-10 minutes for Q&A)","rsvpmaker-for-toastmasters")."</option>";
$project_times["COMMUNICATING ON VIDEO 4"] = 16;

$projects["COMMUNICATING ON VIDEO 5"] = __("Instructing on the Internet (5 to 7 min + 5 to 7 min video playback)","rsvpmaker-for-toastmasters");
$project_options["COMMUNICATING ON VIDEO"] .= '<option value="COMMUNICATING ON VIDEO 5">'.__("Instructing on the Internet (5 to 7 min + 5 to 7 min video playback)","rsvpmaker-for-toastmasters")."</option>";
$project_times["COMMUNICATING ON VIDEO 5"] = 14;

$projects["FACILITATING DISCUSSION 1"] = __("The Panel Moderator (28 to 30 min)","rsvpmaker-for-toastmasters");
$project_options["FACILITATING DISCUSSION"] = '<option value="FACILITATING DISCUSSION 1">'.__("The Panel Moderator (28 to 30 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["FACILITATING DISCUSSION 1"] = 30;

$projects["FACILITATING DISCUSSION 2"] = __("The Brainstorming Session (31 to 33 min)","rsvpmaker-for-toastmasters");
$project_options["FACILITATING DISCUSSION"] .= '<option value="FACILITATING DISCUSSION 2">'.__("The Brainstorming Session (31 to 33 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["FACILITATING DISCUSSION 2"] = 31;

$projects["FACILITATING DISCUSSION 3"] = __("The Problem-Solving Discussion (19 to 23 min)","rsvpmaker-for-toastmasters");
$project_options["FACILITATING DISCUSSION"] .= '<option value="FACILITATING DISCUSSION 3">'.__("The Problem-Solving Discussion (19 to 23 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["FACILITATING DISCUSSION 3"] = 33;

$projects["FACILITATING DISCUSSION 4"] = __("Handling Challenging Situations (Role Playing) (22 to 32 min)","rsvpmaker-for-toastmasters");
$project_options["FACILITATING DISCUSSION"] .= '<option value="FACILITATING DISCUSSION 4">'.__("Handling Challenging Situations (Role Playing) (22 to 32 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["FACILITATING DISCUSSION 4"] = 32;

$projects["FACILITATING DISCUSSION 5"] = __("Reaching A Consensus (22 to 26 min)","rsvpmaker-for-toastmasters");
$project_options["FACILITATING DISCUSSION"] .= '<option value="FACILITATING DISCUSSION 5">'.__("Reaching A Consensus (22 to 26 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["FACILITATING DISCUSSION 5"] = 26;

$projects["HUMOROUSLY SPEAKING 1"] = __("Warm Up Your Audience (5 to 7 min)","rsvpmaker-for-toastmasters");
$project_options["HUMOROUSLY SPEAKING"] = '<option value="HUMOROUSLY SPEAKING 1">'.__("Warm Up Your Audience (5 to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["HUMOROUSLY SPEAKING 1"] = 7;

$projects["HUMOROUSLY SPEAKING 2"] = __("Leave Them With A Smile (5 to 7 min)","rsvpmaker-for-toastmasters");
$project_options["HUMOROUSLY SPEAKING"] .= '<option value="HUMOROUSLY SPEAKING 2">'.__("Leave Them With A Smile (5 to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["HUMOROUSLY SPEAKING 2"] = 7;

$projects["HUMOROUSLY SPEAKING 3"] = __("Make Them Laugh (5 to 7 min)","rsvpmaker-for-toastmasters");
$project_options["HUMOROUSLY SPEAKING"] .= '<option value="HUMOROUSLY SPEAKING 3">'.__("Make Them Laugh (5 to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["HUMOROUSLY SPEAKING 3"] = 7;

$projects["HUMOROUSLY SPEAKING 4"] = __("Keep Them Laughing (5 to 7 min)","rsvpmaker-for-toastmasters");
$project_options["HUMOROUSLY SPEAKING"] .= '<option value="HUMOROUSLY SPEAKING 4">'.__("Keep Them Laughing (5 to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["HUMOROUSLY SPEAKING 4"] = 7;

$projects["HUMOROUSLY SPEAKING 5"] = __("The Humorous Speech (5 to 7 min)","rsvpmaker-for-toastmasters");
$project_options["HUMOROUSLY SPEAKING"] .= '<option value="HUMOROUSLY SPEAKING 5">'.__("The Humorous Speech (5 to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["HUMOROUSLY SPEAKING 5"] = 7;

$projects["INTERPERSONAL COMMUNICATIONS 1"] = __("Conversing with Ease (10 to 14 min) (10 to 14 minutes)","rsvpmaker-for-toastmasters");
$project_options["INTERPERSONAL COMMUNICATIONS"] = '<option value="INTERPERSONAL COMMUNICATIONS 1">'.__("Conversing with Ease (10 to 14 min) (10 to 14 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["INTERPERSONAL COMMUNICATIONS 1"] = 14;

$projects["INTERPERSONAL COMMUNICATIONS 2"] = __("The Successful Negotiator (10 to 14 min) (10 to 14 minutes)","rsvpmaker-for-toastmasters");
$project_options["INTERPERSONAL COMMUNICATIONS"] .= '<option value="INTERPERSONAL COMMUNICATIONS 2">'.__("The Successful Negotiator (10 to 14 min) (10 to 14 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["INTERPERSONAL COMMUNICATIONS 2"] = 14;

$projects["INTERPERSONAL COMMUNICATIONS 3"] = __("Diffusing Verbal Criticism (10 to 14 min) (10 to 14 minutes)","rsvpmaker-for-toastmasters");
$project_options["INTERPERSONAL COMMUNICATIONS"] .= '<option value="INTERPERSONAL COMMUNICATIONS 3">'.__("Diffusing Verbal Criticism (10 to 14 min) (10 to 14 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["INTERPERSONAL COMMUNICATIONS 3"] = 14;

$projects["INTERPERSONAL COMMUNICATIONS 4"] = __("The Coach (10 to 14 min) (10 to 14 minutes)","rsvpmaker-for-toastmasters");
$project_options["INTERPERSONAL COMMUNICATIONS"] .= '<option value="INTERPERSONAL COMMUNICATIONS 4">'.__("The Coach (10 to 14 min) (10 to 14 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["INTERPERSONAL COMMUNICATIONS 4"] = 14;

$projects["INTERPERSONAL COMMUNICATIONS 5"] = __("Asserting Yourself Effectively (10 to 14 min) (10 to 14 minutes)","rsvpmaker-for-toastmasters");
$project_options["INTERPERSONAL COMMUNICATIONS"] .= '<option value="INTERPERSONAL COMMUNICATIONS 5">'.__("Asserting Yourself Effectively (10 to 14 min) (10 to 14 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["INTERPERSONAL COMMUNICATIONS 5"] = 14;

$projects["INTERPRETIVE READING 1"] = __("Read A Story (8 to 10 min) (8 to 10 minutes)","rsvpmaker-for-toastmasters");
$project_options["INTERPRETIVE READING"] = '<option value="INTERPRETIVE READING 1">'.__("Read A Story (8 to 10 min) (8 to 10 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["INTERPRETIVE READING 1"] = 10;

$projects["INTERPRETIVE READING 2"] = __("Interpreting Poetry (6 to 8 min) (6 to 8 minutes)","rsvpmaker-for-toastmasters");
$project_options["INTERPRETIVE READING"] .= '<option value="INTERPRETIVE READING 2">'.__("Interpreting Poetry (6 to 8 min) (6 to 8 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["INTERPRETIVE READING 2"] = 8;

$projects["INTERPRETIVE READING 3"] = __("The Monodrama (5 to 7 min)","rsvpmaker-for-toastmasters");
$project_options["INTERPRETIVE READING"] .= '<option value="INTERPRETIVE READING 3">'.__("The Monodrama (5 to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["INTERPRETIVE READING 3"] = 7;

$projects["INTERPRETIVE READING 4"] = __("The Play (12 to 15 min) (12 to 15 minutes)","rsvpmaker-for-toastmasters");
$project_options["INTERPRETIVE READING"] .= '<option value="INTERPRETIVE READING 4">'.__("The Play (12 to 15 min) (12 to 15 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["INTERPRETIVE READING 4"] = 15;

$projects["INTERPRETIVE READING 5"] = __("The Oratorical Speech (8 to 10 min) (8 to 10 minutes)","rsvpmaker-for-toastmasters");
$project_options["INTERPRETIVE READING"] .= '<option value="INTERPRETIVE READING 5">'.__("The Oratorical Speech (8 to 10 min) (8 to 10 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["INTERPRETIVE READING 5"] = 10;

$projects["Other Manual or Non Manual Speech 1"] = __("Custom Speech (3 to 5 min)","rsvpmaker-for-toastmasters");
$project_options["Other Manual or Non Manual Speech"] = '<option value="Other Manual or Non Manual Speech 1">'.__("Custom Speech (3 to 5 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Other Manual or Non Manual Speech 1"] = 5;

$projects["Other Manual or Non Manual Speech 2"] = __("Custom Speech (5 to 7 min)","rsvpmaker-for-toastmasters");
$project_options["Other Manual or Non Manual Speech"] .= '<option value="Other Manual or Non Manual Speech 2">'.__("Custom Speech (5 to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Other Manual or Non Manual Speech 2"] = 7;

$projects["Other Manual or Non Manual Speech 3"] = __("Custom Speech (8 to 10 min)","rsvpmaker-for-toastmasters");
$project_options["Other Manual or Non Manual Speech"] .= '<option value="Other Manual or Non Manual Speech 3">'.__("Custom Speech (8 to 10 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Other Manual or Non Manual Speech 3"] = 10;

$projects["Other Manual or Non Manual Speech 4"] = __("Custom Speech (10 to 12 min)","rsvpmaker-for-toastmasters");
$project_options["Other Manual or Non Manual Speech"] .= '<option value="Other Manual or Non Manual Speech 4">'.__("Custom Speech (10 to 12 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Other Manual or Non Manual Speech 4"] = 12;

$projects["Other Manual or Non Manual Speech 5"] = __("Custom Speech (13 to 15 min)","rsvpmaker-for-toastmasters");
$project_options["Other Manual or Non Manual Speech"] .= '<option value="Other Manual or Non Manual Speech 5">'.__("Custom Speech (13 to 15 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Other Manual or Non Manual Speech 5"] = 15;

$projects["Other Manual or Non Manual Speech 6"] = __("Custom Speech (18 to 20 min)","rsvpmaker-for-toastmasters");
$project_options["Other Manual or Non Manual Speech"] .= '<option value="Other Manual or Non Manual Speech 6">'.__("Custom Speech (18 to 20 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Other Manual or Non Manual Speech 6"] = 20;

$projects["Other Manual or Non Manual Speech 7"] = __("Custom Speech (23 to 25 min)","rsvpmaker-for-toastmasters");
$project_options["Other Manual or Non Manual Speech"] .= '<option value="Other Manual or Non Manual Speech 7">'.__("Custom Speech (23 to 25 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Other Manual or Non Manual Speech 7"] = 25;

$projects["Other Manual or Non Manual Speech 8"] = __("Custom Speech (28 to 30 min)","rsvpmaker-for-toastmasters");
$project_options["Other Manual or Non Manual Speech"] .= '<option value="Other Manual or Non Manual Speech 8">'.__("Custom Speech (28 to 30 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Other Manual or Non Manual Speech 8"] = 30;

$projects["Other Manual or Non Manual Speech 9"] = __("Custom Speech (35 to 40 min)","rsvpmaker-for-toastmasters");
$project_options["Other Manual or Non Manual Speech"] .= '<option value="Other Manual or Non Manual Speech 9">'.__("Custom Speech (35 to 40 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Other Manual or Non Manual Speech 9"] = 40;

$projects["Other Manual or Non Manual Speech 10"] = __("Custom Speech (40 to 45 min)","rsvpmaker-for-toastmasters");
$project_options["Other Manual or Non Manual Speech"] .= '<option value="Other Manual or Non Manual Speech 10">'.__("Custom Speech (40 to 45 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Other Manual or Non Manual Speech 10"] = 45;

$projects["Other Manual or Non Manual Speech 11"] = __("Custom Speech (45 to 50 min)","rsvpmaker-for-toastmasters");
$project_options["Other Manual or Non Manual Speech"] .= '<option value="Other Manual or Non Manual Speech 11">'.__("Custom Speech (45 to 50 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Other Manual or Non Manual Speech 11"] = 50;

$projects["Other Manual or Non Manual Speech 12"] = __("Custom Speech (55 to 60 min)","rsvpmaker-for-toastmasters");
$project_options["Other Manual or Non Manual Speech"] .= '<option value="Other Manual or Non Manual Speech 12">'.__("Custom Speech (55 to 60 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Other Manual or Non Manual Speech 12"] = 60;

$projects["Other Manual or Non Manual Speech 13"] = __("Custom Speech (more than an hour)","rsvpmaker-for-toastmasters");
$project_options["Other Manual or Non Manual Speech"] .= '<option value="Other Manual or Non Manual Speech 13">'.__("Custom Speech (more than an hour)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Other Manual or Non Manual Speech 13"] = 0;

$projects["PERSUASIVE SPEAKING 1"] = __("The Effective Salesperson (8 to 12 min (8 to 12 minutes)","rsvpmaker-for-toastmasters");
$project_options["PERSUASIVE SPEAKING"] = '<option value="PERSUASIVE SPEAKING 1">'.__("The Effective Salesperson (8 to 12 min (8 to 12 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["PERSUASIVE SPEAKING 1"] = 12;

$projects["PERSUASIVE SPEAKING 2"] = __("Conquering the &quot;Cold Call&quot; (10 to 14 min)","rsvpmaker-for-toastmasters");
$project_options["PERSUASIVE SPEAKING"] .= '<option value="PERSUASIVE SPEAKING 2">'.__("Conquering the &quot;Cold Call&quot; (10 to 14 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["PERSUASIVE SPEAKING 2"] = 14;

$projects["PERSUASIVE SPEAKING 3"] = __("The Winning Proposal (5 to 7 min)","rsvpmaker-for-toastmasters");
$project_options["PERSUASIVE SPEAKING"] .= '<option value="PERSUASIVE SPEAKING 3">'.__("The Winning Proposal (5 to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["PERSUASIVE SPEAKING 3"] = 7;

$projects["PERSUASIVE SPEAKING 4"] = __("Addressing the Opposition (7 to 9 min) (7 to 9 minutes for the speech, plus 2 to 3 minutes for the question and answer period)","rsvpmaker-for-toastmasters");
$project_options["PERSUASIVE SPEAKING"] .= '<option value="PERSUASIVE SPEAKING 4">'.__("Addressing the Opposition (7 to 9 min) (7 to 9 minutes for the speech, plus 2 to 3 minutes for the question and answer period)","rsvpmaker-for-toastmasters")."</option>";
$project_times["PERSUASIVE SPEAKING 4"] = 12;

$projects["PERSUASIVE SPEAKING 5"] = __("The Persuasive Leader (6 to 8 min) (6 to 8 minutes)","rsvpmaker-for-toastmasters");
$project_options["PERSUASIVE SPEAKING"] .= '<option value="PERSUASIVE SPEAKING 5">'.__("The Persuasive Leader (6 to 8 min) (6 to 8 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["PERSUASIVE SPEAKING 5"] = 8;

$projects["PUBLIC RELATIONS 1"] = __("1.The Goodwill Speech (5  to 7 min)","rsvpmaker-for-toastmasters");
$project_options["PUBLIC RELATIONS"] = '<option value="PUBLIC RELATIONS 1">'.__("1.The Goodwill Speech (5  to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["PUBLIC RELATIONS 1"] = 7;

$projects["PUBLIC RELATIONS 2"] = __("The Radio Talk Show (3 to 5 min + 2 to 3 min Q&A) (3 to 5 minutes for the presentation, plus 2 to 3 minutes for questions and answers)","rsvpmaker-for-toastmasters");
$project_options["PUBLIC RELATIONS"] .= '<option value="PUBLIC RELATIONS 2">'.__("The Radio Talk Show (3 to 5 min + 2 to 3 min Q&A) (3 to 5 minutes for the presentation, plus 2 to 3 minutes for questions and answers)","rsvpmaker-for-toastmasters")."</option>";
$project_times["PUBLIC RELATIONS 2"] = 8;

$projects["PUBLIC RELATIONS 3"] = __("Persuasive Approach (5 to 7 min)","rsvpmaker-for-toastmasters");
$project_options["PUBLIC RELATIONS"] .= '<option value="PUBLIC RELATIONS 3">'.__("Persuasive Approach (5 to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["PUBLIC RELATIONS 3"] = 7;

$projects["PUBLIC RELATIONS 4"] = __("Speaking Under Fire (3 to 5 min + 2 to 3 Q&A) (3 to 5 minutes for the presentation, plus 2 to 3 minutes for questions and answers)","rsvpmaker-for-toastmasters");
$project_options["PUBLIC RELATIONS"] .= '<option value="PUBLIC RELATIONS 4">'.__("Speaking Under Fire (3 to 5 min + 2 to 3 Q&A) (3 to 5 minutes for the presentation, plus 2 to 3 minutes for questions and answers)","rsvpmaker-for-toastmasters")."</option>";
$project_times["PUBLIC RELATIONS 4"] = 8;

$projects["PUBLIC RELATIONS 5"] = __("The Crisis Management Speech (4 to 6 min + 3 to 5 min Q&A) (4 to 6 minutes for the presentation, plus 3 to 5 minutes for questions and answers)","rsvpmaker-for-toastmasters");
$project_options["PUBLIC RELATIONS"] .= '<option value="PUBLIC RELATIONS 5">'.__("The Crisis Management Speech (4 to 6 min + 3 to 5 min Q&A) (4 to 6 minutes for the presentation, plus 3 to 5 minutes for questions and answers)","rsvpmaker-for-toastmasters")."</option>";
$project_times["PUBLIC RELATIONS 5"] = 11;

$projects["SPEAKING TO INFORM 1"] = __("The Speech to Inform (5 to 7 min)","rsvpmaker-for-toastmasters");
$project_options["SPEAKING TO INFORM"] = '<option value="SPEAKING TO INFORM 1">'.__("The Speech to Inform (5 to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["SPEAKING TO INFORM 1"] = 7;

$projects["SPEAKING TO INFORM 2"] = __("Resources for Informing (5 to 7 min)","rsvpmaker-for-toastmasters");
$project_options["SPEAKING TO INFORM"] .= '<option value="SPEAKING TO INFORM 2">'.__("Resources for Informing (5 to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["SPEAKING TO INFORM 2"] = 7;

$projects["SPEAKING TO INFORM 3"] = __("The Demonstration Talk (5 to 7 min)","rsvpmaker-for-toastmasters");
$project_options["SPEAKING TO INFORM"] .= '<option value="SPEAKING TO INFORM 3">'.__("The Demonstration Talk (5 to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["SPEAKING TO INFORM 3"] = 7;

$projects["SPEAKING TO INFORM 4"] = __("A Fact-Finding Report (5 to 7 min + 2 to 3 min for Q&A)","rsvpmaker-for-toastmasters");
$project_options["SPEAKING TO INFORM"] .= '<option value="SPEAKING TO INFORM 4">'.__("A Fact-Finding Report (5 to 7 min + 2 to 3 min for Q&A)","rsvpmaker-for-toastmasters")."</option>";
$project_times["SPEAKING TO INFORM 4"] = 7;

$projects["SPEAKING TO INFORM 5"] = __("The Abstract Concept (6 to 8 min) (6 to 8 minutes)","rsvpmaker-for-toastmasters");
$project_options["SPEAKING TO INFORM"] .= '<option value="SPEAKING TO INFORM 5">'.__("The Abstract Concept (6 to 8 min) (6 to 8 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["SPEAKING TO INFORM 5"] = 8;

$projects["SPECIAL OCCASION SPEECHES 1"] = __("Mastering the Toast (2 to 3 min) (2 to 3 minutes)","rsvpmaker-for-toastmasters");
$project_options["SPECIAL OCCASION SPEECHES"] = '<option value="SPECIAL OCCASION SPEECHES 1">'.__("Mastering the Toast (2 to 3 min) (2 to 3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["SPECIAL OCCASION SPEECHES 1"] = 3;

$projects["SPECIAL OCCASION SPEECHES 2"] = __("Speaking in Praise (5 to 7 min)","rsvpmaker-for-toastmasters");
$project_options["SPECIAL OCCASION SPEECHES"] .= '<option value="SPECIAL OCCASION SPEECHES 2">'.__("Speaking in Praise (5 to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["SPECIAL OCCASION SPEECHES 2"] = 7;

$projects["SPECIAL OCCASION SPEECHES 3"] = __("The Roast (3 to 5 min) (3 to 5 minutes)","rsvpmaker-for-toastmasters");
$project_options["SPECIAL OCCASION SPEECHES"] .= '<option value="SPECIAL OCCASION SPEECHES 3">'.__("The Roast (3 to 5 min) (3 to 5 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["SPECIAL OCCASION SPEECHES 3"] = 5;

$projects["SPECIAL OCCASION SPEECHES 4"] = __("Presenting an Award (3 to 4 min) (3 to 4 minutes)","rsvpmaker-for-toastmasters");
$project_options["SPECIAL OCCASION SPEECHES"] .= '<option value="SPECIAL OCCASION SPEECHES 4">'.__("Presenting an Award (3 to 4 min) (3 to 4 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["SPECIAL OCCASION SPEECHES 4"] = 4;

$projects["SPECIAL OCCASION SPEECHES 5"] = __("Accepting an Award (5 to 7 min)","rsvpmaker-for-toastmasters");
$project_options["SPECIAL OCCASION SPEECHES"] .= '<option value="SPECIAL OCCASION SPEECHES 5">'.__("Accepting an Award (5 to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["SPECIAL OCCASION SPEECHES 5"] = 7;

$projects["SPECIALTY SPEECHES 1"] = __("Speak Off The Cuff (5 to 7 min)","rsvpmaker-for-toastmasters");
$project_options["SPECIALTY SPEECHES"] = '<option value="SPECIALTY SPEECHES 1">'.__("Speak Off The Cuff (5 to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["SPECIALTY SPEECHES 1"] = 7;

$projects["SPECIALTY SPEECHES 2"] = __("Uplift the Spirit (8 to 10 min) (8 to 10 minutes)","rsvpmaker-for-toastmasters");
$project_options["SPECIALTY SPEECHES"] .= '<option value="SPECIALTY SPEECHES 2">'.__("Uplift the Spirit (8 to 10 min) (8 to 10 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["SPECIALTY SPEECHES 2"] = 10;

$projects["SPECIALTY SPEECHES 3"] = __("Sell a Product (10 to 12 min) (10 to 12 minutes)","rsvpmaker-for-toastmasters");
$project_options["SPECIALTY SPEECHES"] .= '<option value="SPECIALTY SPEECHES 3">'.__("Sell a Product (10 to 12 min) (10 to 12 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["SPECIALTY SPEECHES 3"] = 12;

$projects["SPECIALTY SPEECHES 4"] = __("Read Out Loud (12 to 15 min) (12 to 15 minutes)","rsvpmaker-for-toastmasters");
$project_options["SPECIALTY SPEECHES"] .= '<option value="SPECIALTY SPEECHES 4">'.__("Read Out Loud (12 to 15 min) (12 to 15 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["SPECIALTY SPEECHES 4"] = 15;

$projects["SPECIALTY SPEECHES 5"] = __("Introduce the Speaker (duration of a club meeting) (The duration of a club meeting)","rsvpmaker-for-toastmasters");
$project_options["SPECIALTY SPEECHES"] .= '<option value="SPECIALTY SPEECHES 5">'.__("Introduce the Speaker (duration of a club meeting) (The duration of a club meeting)","rsvpmaker-for-toastmasters")."</option>";
$project_times["SPECIALTY SPEECHES 5"] = 120;

$projects["SPEECHES BY MANAGEMENT 1"] = __("The Briefing (8 to 10 min + 5 min Q&A) (3 to 5 minutes for speech, plus 2 to 3 minutes for question period)","rsvpmaker-for-toastmasters");
$project_options["SPEECHES BY MANAGEMENT"] = '<option value="SPEECHES BY MANAGEMENT 1">'.__("The Briefing (8 to 10 min + 5 min Q&A) (3 to 5 minutes for speech, plus 2 to 3 minutes for question period)","rsvpmaker-for-toastmasters")."</option>";
$project_times["SPEECHES BY MANAGEMENT 1"] = 8;

$projects["SPEECHES BY MANAGEMENT 2"] = __("The Technical Speech (8 to 10 min)","rsvpmaker-for-toastmasters");
$project_options["SPEECHES BY MANAGEMENT"] .= '<option value="SPEECHES BY MANAGEMENT 2">'.__("The Technical Speech (8 to 10 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["SPEECHES BY MANAGEMENT 2"] = 10;

$projects["SPEECHES BY MANAGEMENT 3"] = __("Manage And Motivate (10 to 12 min)","rsvpmaker-for-toastmasters");
$project_options["SPEECHES BY MANAGEMENT"] .= '<option value="SPEECHES BY MANAGEMENT 3">'.__("Manage And Motivate (10 to 12 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["SPEECHES BY MANAGEMENT 3"] = 12;

$projects["SPEECHES BY MANAGEMENT 4"] = __("The Status Report (10 to 12 min)","rsvpmaker-for-toastmasters");
$project_options["SPEECHES BY MANAGEMENT"] .= '<option value="SPEECHES BY MANAGEMENT 4">'.__("The Status Report (10 to 12 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["SPEECHES BY MANAGEMENT 4"] = 12;

$projects["SPEECHES BY MANAGEMENT 5"] = __("Confrontation: The Adversary Relationship (5 min + 10 min Q&A)","rsvpmaker-for-toastmasters");
$project_options["SPEECHES BY MANAGEMENT"] .= '<option value="SPEECHES BY MANAGEMENT 5">'.__("Confrontation: The Adversary Relationship (5 min + 10 min Q&A)","rsvpmaker-for-toastmasters")."</option>";
$project_times["SPEECHES BY MANAGEMENT 5"] = 15;

$projects["STORYTELLING 1"] = __("The Folk Tale (7 to 9 min) (7 to 9 minutes)","rsvpmaker-for-toastmasters");
$project_options["STORYTELLING"] = '<option value="STORYTELLING 1">'.__("The Folk Tale (7 to 9 min) (7 to 9 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["STORYTELLING 1"] = 9;

$projects["STORYTELLING 2"] = __("Let’s Get Personal (6 to 8 min) (6 to 8 minutes)","rsvpmaker-for-toastmasters");
$project_options["STORYTELLING"] .= '<option value="STORYTELLING 2">'.__("Let’s Get Personal (6 to 8 min) (6 to 8 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["STORYTELLING 2"] = 8;

$projects["STORYTELLING 3"] = __("The Moral of the Story (5 to 7 min) (4 to 6 minutes)","rsvpmaker-for-toastmasters");
$project_options["STORYTELLING"] .= '<option value="STORYTELLING 3">'.__("The Moral of the Story (5 to 7 min) (4 to 6 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["STORYTELLING 3"] = 6;

$projects["STORYTELLING 4"] = __("The Touching Story (6 to 8 min) (6 to 8 minutes)","rsvpmaker-for-toastmasters");
$project_options["STORYTELLING"] .= '<option value="STORYTELLING 4">'.__("The Touching Story (6 to 8 min) (6 to 8 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["STORYTELLING 4"] = 8;

$projects["STORYTELLING 5"] = __("Bringing History to Life (7 to 9 min) (7 to 9 minutes)","rsvpmaker-for-toastmasters");
$project_options["STORYTELLING"] .= '<option value="STORYTELLING 5">'.__("Bringing History to Life (7 to 9 min) (7 to 9 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["STORYTELLING 5"] = 9;

$projects["TECHNICAL PRESENTATIONS 1"] = __("The Technical Briefing (8 to 10 min) (8 to 10 minutes)","rsvpmaker-for-toastmasters");
$project_options["TECHNICAL PRESENTATIONS"] = '<option value="TECHNICAL PRESENTATIONS 1">'.__("The Technical Briefing (8 to 10 min) (8 to 10 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["TECHNICAL PRESENTATIONS 1"] = 10;

$projects["TECHNICAL PRESENTATIONS 2"] = __("The Proposal (8 to 10 min + 3 to 5 min Q&A) (8 to 10 minutes for speech, plus 3 to 5 minutes for question period)","rsvpmaker-for-toastmasters");
$project_options["TECHNICAL PRESENTATIONS"] .= '<option value="TECHNICAL PRESENTATIONS 2">'.__("The Proposal (8 to 10 min + 3 to 5 min Q&A) (8 to 10 minutes for speech, plus 3 to 5 minutes for question period)","rsvpmaker-for-toastmasters")."</option>";
$project_times["TECHNICAL PRESENTATIONS 2"] = 10;

$projects["TECHNICAL PRESENTATIONS 3"] = __("The Nontechnical Audience (10 to 12 min) (10 to 12 minutes)","rsvpmaker-for-toastmasters");
$project_options["TECHNICAL PRESENTATIONS"] .= '<option value="TECHNICAL PRESENTATIONS 3">'.__("The Nontechnical Audience (10 to 12 min) (10 to 12 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["TECHNICAL PRESENTATIONS 3"] = 12;

$projects["TECHNICAL PRESENTATIONS 4"] = __("Presenting a Technical Paper (10 to 12 min) (10 to 12 minutes)","rsvpmaker-for-toastmasters");
$project_options["TECHNICAL PRESENTATIONS"] .= '<option value="TECHNICAL PRESENTATIONS 4">'.__("Presenting a Technical Paper (10 to 12 min) (10 to 12 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["TECHNICAL PRESENTATIONS 4"] = 12;

$projects["TECHNICAL PRESENTATIONS 5"] = __("The Team Technical Presentation (20 to 30 min)","rsvpmaker-for-toastmasters");
$project_options["TECHNICAL PRESENTATIONS"] .= '<option value="TECHNICAL PRESENTATIONS 5">'.__("The Team Technical Presentation (20 to 30 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["TECHNICAL PRESENTATIONS 5"] = 30;

$projects["THE DISCUSSION LEADER 1"] = __("The Seminar Solution (20 to 30 min)","rsvpmaker-for-toastmasters");
$project_options["THE DISCUSSION LEADER"] = '<option value="THE DISCUSSION LEADER 1">'.__("The Seminar Solution (20 to 30 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["THE DISCUSSION LEADER 1"] = 30;

$projects["THE DISCUSSION LEADER 2"] = __("The Round Robin (20 to 30 min)","rsvpmaker-for-toastmasters");
$project_options["THE DISCUSSION LEADER"] .= '<option value="THE DISCUSSION LEADER 2">'.__("The Round Robin (20 to 30 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["THE DISCUSSION LEADER 2"] = 30;

$projects["THE DISCUSSION LEADER 3"] = __("Pilot a Panel (30 to 40 min)","rsvpmaker-for-toastmasters");
$project_options["THE DISCUSSION LEADER"] .= '<option value="THE DISCUSSION LEADER 3">'.__("Pilot a Panel (30 to 40 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["THE DISCUSSION LEADER 3"] = 40;

$projects["THE DISCUSSION LEADER 4"] = __("Make Believe (Role Playing) (20 to 30 min)","rsvpmaker-for-toastmasters");
$project_options["THE DISCUSSION LEADER"] .= '<option value="THE DISCUSSION LEADER 4">'.__("Make Believe (Role Playing) (20 to 30 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["THE DISCUSSION LEADER 4"] = 30;

$projects["THE DISCUSSION LEADER 5"] = __("The Workshop Leader (30 to 40 min)","rsvpmaker-for-toastmasters");
$project_options["THE DISCUSSION LEADER"] .= '<option value="THE DISCUSSION LEADER 5">'.__("The Workshop Leader (30 to 40 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["THE DISCUSSION LEADER 5"] = 40;

$projects["THE ENTERTAINING SPEAKER 1"] = __("The Entertaining Speech (5 to 7 min)","rsvpmaker-for-toastmasters");
$project_options["THE ENTERTAINING SPEAKER"] = '<option value="THE ENTERTAINING SPEAKER 1">'.__("The Entertaining Speech (5 to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["THE ENTERTAINING SPEAKER 1"] = 7;

$projects["THE ENTERTAINING SPEAKER 2"] = __("Resources for Entertainment (5 to 7 min)","rsvpmaker-for-toastmasters");
$project_options["THE ENTERTAINING SPEAKER"] .= '<option value="THE ENTERTAINING SPEAKER 2">'.__("Resources for Entertainment (5 to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["THE ENTERTAINING SPEAKER 2"] = 7;

$projects["THE ENTERTAINING SPEAKER 3"] = __("Make Them Laugh (5 to 7 min)","rsvpmaker-for-toastmasters");
$project_options["THE ENTERTAINING SPEAKER"] .= '<option value="THE ENTERTAINING SPEAKER 3">'.__("Make Them Laugh (5 to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["THE ENTERTAINING SPEAKER 3"] = 7;

$projects["THE ENTERTAINING SPEAKER 4"] = __("A Dramatic Talk (5 to 7 min)","rsvpmaker-for-toastmasters");
$project_options["THE ENTERTAINING SPEAKER"] .= '<option value="THE ENTERTAINING SPEAKER 4">'.__("A Dramatic Talk (5 to 7 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["THE ENTERTAINING SPEAKER 4"] = 7;

$projects["THE ENTERTAINING SPEAKER 5"] = __("Speaking After Dinner (8 to 10 min) (8 to 10 minutes)","rsvpmaker-for-toastmasters");
$project_options["THE ENTERTAINING SPEAKER"] .= '<option value="THE ENTERTAINING SPEAKER 5">'.__("Speaking After Dinner (8 to 10 min) (8 to 10 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["THE ENTERTAINING SPEAKER 5"] = 10;

$projects["THE PROFESSIONAL SALESPERSON 1"] = __("The Winning Attitude (8 to 10 min)","rsvpmaker-for-toastmasters");
$project_options["THE PROFESSIONAL SALESPERSON"] = '<option value="THE PROFESSIONAL SALESPERSON 1">'.__("The Winning Attitude (8 to 10 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["THE PROFESSIONAL SALESPERSON 1"] = 10;

$projects["THE PROFESSIONAL SALESPERSON 2"] = __("Closing The Sale (10 to 12 min)","rsvpmaker-for-toastmasters");
$project_options["THE PROFESSIONAL SALESPERSON"] .= '<option value="THE PROFESSIONAL SALESPERSON 2">'.__("Closing The Sale (10 to 12 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["THE PROFESSIONAL SALESPERSON 2"] = 12;

$projects["THE PROFESSIONAL SALESPERSON 3"] = __("Training The Sales Force (6 to 8 min speech; 8 to 10 min role play; 2 to 5 min discussion)","rsvpmaker-for-toastmasters");
$project_options["THE PROFESSIONAL SALESPERSON"] .= '<option value="THE PROFESSIONAL SALESPERSON 3">'.__("Training The Sales Force (6 to 8 min speech; 8 to 10 min role play; 2 to 5 min discussion)","rsvpmaker-for-toastmasters")."</option>";
$project_times["THE PROFESSIONAL SALESPERSON 3"] = 23;

$projects["THE PROFESSIONAL SALESPERSON 4"] = __("The Sales Meeting (15 to 20 min)","rsvpmaker-for-toastmasters");
$project_options["THE PROFESSIONAL SALESPERSON"] .= '<option value="THE PROFESSIONAL SALESPERSON 4">'.__("The Sales Meeting (15 to 20 min)","rsvpmaker-for-toastmasters")."</option>";
$project_times["THE PROFESSIONAL SALESPERSON 4"] = 20;

$projects["THE PROFESSIONAL SALESPERSON 5"] = __("The Team Sales Presentation (15 to 20 min plus 5 to 7 min per person for manual credit)","rsvpmaker-for-toastmasters");
$project_options["THE PROFESSIONAL SALESPERSON"] .= '<option value="THE PROFESSIONAL SALESPERSON 5">'.__("The Team Sales Presentation (15 to 20 min plus 5 to 7 min per person for manual credit)","rsvpmaker-for-toastmasters")."</option>";
$project_times["THE PROFESSIONAL SALESPERSON 5"] = 27;

$projects["THE PROFESSIONAL SPEAKER 1"] = __("The Keynote Address (15 to 20 min) (15 to 20 minutes, longer if club program allows)","rsvpmaker-for-toastmasters");
$project_options["THE PROFESSIONAL SPEAKER"] = '<option value="THE PROFESSIONAL SPEAKER 1">'.__("The Keynote Address (15 to 20 min) (15 to 20 minutes, longer if club program allows)","rsvpmaker-for-toastmasters")."</option>";
$project_times["THE PROFESSIONAL SPEAKER 1"] = 20;

$projects["THE PROFESSIONAL SPEAKER 2"] = __("Speaking to Entertain (15 to 20 min) (15 to 20 minutes, longer if club program allows)","rsvpmaker-for-toastmasters");
$project_options["THE PROFESSIONAL SPEAKER"] .= '<option value="THE PROFESSIONAL SPEAKER 2">'.__("Speaking to Entertain (15 to 20 min) (15 to 20 minutes, longer if club program allows)","rsvpmaker-for-toastmasters")."</option>";
$project_times["THE PROFESSIONAL SPEAKER 2"] = 20;

$projects["THE PROFESSIONAL SPEAKER 3"] = __("The Sales Training Speech (15 to 20 min) (15 to 20 minutes, longer if club program allows)","rsvpmaker-for-toastmasters");
$project_options["THE PROFESSIONAL SPEAKER"] .= '<option value="THE PROFESSIONAL SPEAKER 3">'.__("The Sales Training Speech (15 to 20 min) (15 to 20 minutes, longer if club program allows)","rsvpmaker-for-toastmasters")."</option>";
$project_times["THE PROFESSIONAL SPEAKER 3"] = 20;

$projects["THE PROFESSIONAL SPEAKER 4"] = __("The Professional Seminar (20 to 40 min) (20 to 40 minutes)","rsvpmaker-for-toastmasters");
$project_options["THE PROFESSIONAL SPEAKER"] .= '<option value="THE PROFESSIONAL SPEAKER 4">'.__("The Professional Seminar (20 to 40 min) (20 to 40 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["THE PROFESSIONAL SPEAKER 4"] = 40;

$projects["THE PROFESSIONAL SPEAKER 5"] = __("The Motivational Speech (15 to 20 min) (15 to 20 minutes, longer if club program allows)","rsvpmaker-for-toastmasters");
$project_options["THE PROFESSIONAL SPEAKER"] .= '<option value="THE PROFESSIONAL SPEAKER 5">'.__("The Motivational Speech (15 to 20 min) (15 to 20 minutes, longer if club program allows)","rsvpmaker-for-toastmasters")."</option>";
$project_times["THE PROFESSIONAL SPEAKER 5"] = 20;

$projects["BETTER SPEAKER SERIES 0"] = __("Beginning Your Speech","rsvpmaker-for-toastmasters");
$project_options["BETTER SPEAKER SERIES"] = '<option value="BETTER SPEAKER SERIES 0">'.__("Beginning Your Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["BETTER SPEAKER SERIES 0"] = 15;

$projects["BETTER SPEAKER SERIES 1"] = __("Concluding Your Speech","rsvpmaker-for-toastmasters");
$project_options["BETTER SPEAKER SERIES"] .= '<option value="BETTER SPEAKER SERIES 1">'.__("Concluding Your Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["BETTER SPEAKER SERIES 1"] = 15;

$projects["BETTER SPEAKER SERIES 2"] = __("Controlling Your Fear","rsvpmaker-for-toastmasters");
$project_options["BETTER SPEAKER SERIES"] .= '<option value="BETTER SPEAKER SERIES 2">'.__("Controlling Your Fear","rsvpmaker-for-toastmasters")."</option>";
$project_times["BETTER SPEAKER SERIES 2"] = 15;

$projects["BETTER SPEAKER SERIES 3"] = __("Impromptu Speaking","rsvpmaker-for-toastmasters");
$project_options["BETTER SPEAKER SERIES"] .= '<option value="BETTER SPEAKER SERIES 3">'.__("Impromptu Speaking","rsvpmaker-for-toastmasters")."</option>";
$project_times["BETTER SPEAKER SERIES 3"] = 15;

$projects["BETTER SPEAKER SERIES 4"] = __("Selecting Your Topic","rsvpmaker-for-toastmasters");
$project_options["BETTER SPEAKER SERIES"] .= '<option value="BETTER SPEAKER SERIES 4">'.__("Selecting Your Topic","rsvpmaker-for-toastmasters")."</option>";
$project_times["BETTER SPEAKER SERIES 4"] = 15;

$projects["BETTER SPEAKER SERIES 5"] = __("Know Your Audience","rsvpmaker-for-toastmasters");
$project_options["BETTER SPEAKER SERIES"] .= '<option value="BETTER SPEAKER SERIES 5">'.__("Know Your Audience","rsvpmaker-for-toastmasters")."</option>";
$project_times["BETTER SPEAKER SERIES 5"] = 15;

$projects["BETTER SPEAKER SERIES 6"] = __("Organizing Your Speech","rsvpmaker-for-toastmasters");
$project_options["BETTER SPEAKER SERIES"] .= '<option value="BETTER SPEAKER SERIES 6">'.__("Organizing Your Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["BETTER SPEAKER SERIES 6"] = 15;

$projects["BETTER SPEAKER SERIES 7"] = __("Creating An Introduction","rsvpmaker-for-toastmasters");
$project_options["BETTER SPEAKER SERIES"] .= '<option value="BETTER SPEAKER SERIES 7">'.__("Creating An Introduction","rsvpmaker-for-toastmasters")."</option>";
$project_times["BETTER SPEAKER SERIES 7"] = 15;

$projects["BETTER SPEAKER SERIES 8"] = __("Preparation And Practice","rsvpmaker-for-toastmasters");
$project_options["BETTER SPEAKER SERIES"] .= '<option value="BETTER SPEAKER SERIES 8">'.__("Preparation And Practice","rsvpmaker-for-toastmasters")."</option>";
$project_times["BETTER SPEAKER SERIES 8"] = 15;

$projects["BETTER SPEAKER SERIES 9"] = __("Using Body Language","rsvpmaker-for-toastmasters");
$project_options["BETTER SPEAKER SERIES"] .= '<option value="BETTER SPEAKER SERIES 9">'.__("Using Body Language","rsvpmaker-for-toastmasters")."</option>";
$project_times["BETTER SPEAKER SERIES 9"] = 15;

$projects["SUCCESSFUL CLUB SERIES 0"] = __("Moments Of Truth","rsvpmaker-for-toastmasters");
$project_options["SUCCESSFUL CLUB SERIES"] = '<option value="SUCCESSFUL CLUB SERIES 0">'.__("Moments Of Truth","rsvpmaker-for-toastmasters")."</option>";
$project_times["SUCCESSFUL CLUB SERIES 0"] = 15;

$projects["SUCCESSFUL CLUB SERIES 1"] = __("Finding New Members For Your Club","rsvpmaker-for-toastmasters");
$project_options["SUCCESSFUL CLUB SERIES"] .= '<option value="SUCCESSFUL CLUB SERIES 1">'.__("Finding New Members For Your Club","rsvpmaker-for-toastmasters")."</option>";
$project_times["SUCCESSFUL CLUB SERIES 1"] = 15;

$projects["SUCCESSFUL CLUB SERIES 2"] = __("Evaluate To Motivate","rsvpmaker-for-toastmasters");
$project_options["SUCCESSFUL CLUB SERIES"] .= '<option value="SUCCESSFUL CLUB SERIES 2">'.__("Evaluate To Motivate","rsvpmaker-for-toastmasters")."</option>";
$project_times["SUCCESSFUL CLUB SERIES 2"] = 15;

$projects["SUCCESSFUL CLUB SERIES 3"] = __("Closing The Sale","rsvpmaker-for-toastmasters");
$project_options["SUCCESSFUL CLUB SERIES"] .= '<option value="SUCCESSFUL CLUB SERIES 3">'.__("Closing The Sale","rsvpmaker-for-toastmasters")."</option>";
$project_times["SUCCESSFUL CLUB SERIES 3"] = 15;

$projects["SUCCESSFUL CLUB SERIES 4"] = __("Creating The Best Club Climate","rsvpmaker-for-toastmasters");
$project_options["SUCCESSFUL CLUB SERIES"] .= '<option value="SUCCESSFUL CLUB SERIES 4">'.__("Creating The Best Club Climate","rsvpmaker-for-toastmasters")."</option>";
$project_times["SUCCESSFUL CLUB SERIES 4"] = 15;

$projects["SUCCESSFUL CLUB SERIES 5"] = __("Meeting Roles And Responsibilities","rsvpmaker-for-toastmasters");
$project_options["SUCCESSFUL CLUB SERIES"] .= '<option value="SUCCESSFUL CLUB SERIES 5">'.__("Meeting Roles And Responsibilities","rsvpmaker-for-toastmasters")."</option>";
$project_times["SUCCESSFUL CLUB SERIES 5"] = 15;

$projects["SUCCESSFUL CLUB SERIES 6"] = __("Mentoring","rsvpmaker-for-toastmasters");
$project_options["SUCCESSFUL CLUB SERIES"] .= '<option value="SUCCESSFUL CLUB SERIES 6">'.__("Mentoring","rsvpmaker-for-toastmasters")."</option>";
$project_times["SUCCESSFUL CLUB SERIES 6"] = 15;

$projects["SUCCESSFUL CLUB SERIES 7"] = __("Keeping The Commitment","rsvpmaker-for-toastmasters");
$project_options["SUCCESSFUL CLUB SERIES"] .= '<option value="SUCCESSFUL CLUB SERIES 7">'.__("Keeping The Commitment","rsvpmaker-for-toastmasters")."</option>";
$project_times["SUCCESSFUL CLUB SERIES 7"] = 15;

$projects["SUCCESSFUL CLUB SERIES 8"] = __("Going Beyond Our Club","rsvpmaker-for-toastmasters");
$project_options["SUCCESSFUL CLUB SERIES"] .= '<option value="SUCCESSFUL CLUB SERIES 8">'.__("Going Beyond Our Club","rsvpmaker-for-toastmasters")."</option>";
$project_times["SUCCESSFUL CLUB SERIES 8"] = 15;

$projects["SUCCESSFUL CLUB SERIES 9"] = __("How To Be A Distinguished Club","rsvpmaker-for-toastmasters");
$project_options["SUCCESSFUL CLUB SERIES"] .= '<option value="SUCCESSFUL CLUB SERIES 9">'.__("How To Be A Distinguished Club","rsvpmaker-for-toastmasters")."</option>";
$project_times["SUCCESSFUL CLUB SERIES 9"] = 15;

$projects["SUCCESSFUL CLUB SERIES 10"] = __("The Toastmasters Educational Program","rsvpmaker-for-toastmasters");
$project_options["SUCCESSFUL CLUB SERIES"] .= '<option value="SUCCESSFUL CLUB SERIES 10">'.__("The Toastmasters Educational Program","rsvpmaker-for-toastmasters")."</option>";
$project_times["SUCCESSFUL CLUB SERIES 10"] = 15;

$projects["LEADERSHIP EXCELLENCE SERIES 0"] = __("The Visionary Leader","rsvpmaker-for-toastmasters");
$project_options["LEADERSHIP EXCELLENCE SERIES"] = '<option value="LEADERSHIP EXCELLENCE SERIES 0">'.__("The Visionary Leader","rsvpmaker-for-toastmasters")."</option>";
$project_times["LEADERSHIP EXCELLENCE SERIES 0"] = 15;

$projects["LEADERSHIP EXCELLENCE SERIES 1"] = __("Developing A Mission","rsvpmaker-for-toastmasters");
$project_options["LEADERSHIP EXCELLENCE SERIES"] .= '<option value="LEADERSHIP EXCELLENCE SERIES 1">'.__("Developing A Mission","rsvpmaker-for-toastmasters")."</option>";
$project_times["LEADERSHIP EXCELLENCE SERIES 1"] = 15;

$projects["LEADERSHIP EXCELLENCE SERIES 2"] = __("Values and Leadership","rsvpmaker-for-toastmasters");
$project_options["LEADERSHIP EXCELLENCE SERIES"] .= '<option value="LEADERSHIP EXCELLENCE SERIES 2">'.__("Values and Leadership","rsvpmaker-for-toastmasters")."</option>";
$project_times["LEADERSHIP EXCELLENCE SERIES 2"] = 15;

$projects["LEADERSHIP EXCELLENCE SERIES 3"] = __("Goal Setting And Planning","rsvpmaker-for-toastmasters");
$project_options["LEADERSHIP EXCELLENCE SERIES"] .= '<option value="LEADERSHIP EXCELLENCE SERIES 3">'.__("Goal Setting And Planning","rsvpmaker-for-toastmasters")."</option>";
$project_times["LEADERSHIP EXCELLENCE SERIES 3"] = 15;

$projects["LEADERSHIP EXCELLENCE SERIES 4"] = __("Delegate To Empower","rsvpmaker-for-toastmasters");
$project_options["LEADERSHIP EXCELLENCE SERIES"] .= '<option value="LEADERSHIP EXCELLENCE SERIES 4">'.__("Delegate To Empower","rsvpmaker-for-toastmasters")."</option>";
$project_times["LEADERSHIP EXCELLENCE SERIES 4"] = 15;

$projects["LEADERSHIP EXCELLENCE SERIES 5"] = __("Building A Team","rsvpmaker-for-toastmasters");
$project_options["LEADERSHIP EXCELLENCE SERIES"] .= '<option value="LEADERSHIP EXCELLENCE SERIES 5">'.__("Building A Team","rsvpmaker-for-toastmasters")."</option>";
$project_times["LEADERSHIP EXCELLENCE SERIES 5"] = 15;

$projects["LEADERSHIP EXCELLENCE SERIES 6"] = __("Giving Effective Feedback","rsvpmaker-for-toastmasters");
$project_options["LEADERSHIP EXCELLENCE SERIES"] .= '<option value="LEADERSHIP EXCELLENCE SERIES 6">'.__("Giving Effective Feedback","rsvpmaker-for-toastmasters")."</option>";
$project_times["LEADERSHIP EXCELLENCE SERIES 6"] = 15;

$projects["LEADERSHIP EXCELLENCE SERIES 7"] = __("The Leader as a Coach","rsvpmaker-for-toastmasters");
$project_options["LEADERSHIP EXCELLENCE SERIES"] .= '<option value="LEADERSHIP EXCELLENCE SERIES 7">'.__("The Leader as a Coach","rsvpmaker-for-toastmasters")."</option>";
$project_times["LEADERSHIP EXCELLENCE SERIES 7"] = 15;

$projects["LEADERSHIP EXCELLENCE SERIES 8"] = __("Motivating People","rsvpmaker-for-toastmasters");
$project_options["LEADERSHIP EXCELLENCE SERIES"] .= '<option value="LEADERSHIP EXCELLENCE SERIES 8">'.__("Motivating People","rsvpmaker-for-toastmasters")."</option>";
$project_times["LEADERSHIP EXCELLENCE SERIES 8"] = 15;

$projects["LEADERSHIP EXCELLENCE SERIES 9"] = __("Service And Leadership","rsvpmaker-for-toastmasters");
$project_options["LEADERSHIP EXCELLENCE SERIES"] .= '<option value="LEADERSHIP EXCELLENCE SERIES 9">'.__("Service And Leadership","rsvpmaker-for-toastmasters")."</option>";
$project_times["LEADERSHIP EXCELLENCE SERIES 9"] = 15;

$projects["LEADERSHIP EXCELLENCE SERIES 10"] = __("Resolving Conflict","rsvpmaker-for-toastmasters");
$project_options["LEADERSHIP EXCELLENCE SERIES"] .= '<option value="LEADERSHIP EXCELLENCE SERIES 10">'.__("Resolving Conflict","rsvpmaker-for-toastmasters")."</option>";
$project_times["LEADERSHIP EXCELLENCE SERIES 10"] = 15;

$projects["SPEECHES BY MANAGEMENT 8"] = __(" Persuade and Inspire","rsvpmaker-for-toastmasters");
$project_options["SPEECHES BY MANAGEMENT"] .= '<option value="SPEECHES BY MANAGEMENT 8">'.__(" Persuade and Inspire","rsvpmaker-for-toastmasters")."</option>";
$project_times["SPEECHES BY MANAGEMENT 8"] = 7;

$projects["TECHNICAL PRESENTATIONS 11"] = __(" Enhancing a Technical Talk with the Internet (12 to 15 minutes)","rsvpmaker-for-toastmasters");
$project_options["TECHNICAL PRESENTATIONS"] .= '<option value="TECHNICAL PRESENTATIONS 11">'.__(" Enhancing a Technical Talk with the Internet (12 to 15 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["TECHNICAL PRESENTATIONS 11"] = 15;

$projects["COMMUNICATING ON VIDEO 13"] = __("The Talk Show (10 minutes ±30 seconds)","rsvpmaker-for-toastmasters");
$project_options["COMMUNICATING ON VIDEO"] .= '<option value="COMMUNICATING ON VIDEO 13">'.__("The Talk Show (10 minutes ±30 seconds)","rsvpmaker-for-toastmasters")."</option>";
$project_times["COMMUNICATING ON VIDEO 13"] = 10;

$projects["SPEECHES BY MANAGEMENT 10"] = __(" Delivering Bad News","rsvpmaker-for-toastmasters");
$project_options["SPEECHES BY MANAGEMENT"] .= '<option value="SPEECHES BY MANAGEMENT 10">'.__(" Delivering Bad News","rsvpmaker-for-toastmasters")."</option>";
$project_times["SPEECHES BY MANAGEMENT 10"] = 7;

$projects["COMMUNICATING ON VIDEO 14"] = __("When You're the Host (10 minutes ±30 seconds)","rsvpmaker-for-toastmasters");
$project_options["COMMUNICATING ON VIDEO"] .= '<option value="COMMUNICATING ON VIDEO 14">'.__("When You're the Host (10 minutes ±30 seconds)","rsvpmaker-for-toastmasters")."</option>";
$project_times["COMMUNICATING ON VIDEO 14"] = 10;

$projects["PUBLIC RELATIONS 6"] = __(" The Persuasive Approach","rsvpmaker-for-toastmasters");
$project_options["PUBLIC RELATIONS"] .= '<option value="PUBLIC RELATIONS 6">'.__(" The Persuasive Approach","rsvpmaker-for-toastmasters")."</option>";
$project_times["PUBLIC RELATIONS 6"] = 7;

$projects["SPEECHES BY MANAGEMENT 9"] = __(" Communicating Change","rsvpmaker-for-toastmasters");
$project_options["SPEECHES BY MANAGEMENT"] .= '<option value="SPEECHES BY MANAGEMENT 9">'.__(" Communicating Change","rsvpmaker-for-toastmasters")."</option>";
$project_times["SPEECHES BY MANAGEMENT 9"] = 7;

$projects["PERSUASIVE SPEAKING 12"] = __(" Conquering the &quot;Cold Call&quot; (10 to 14 minutes)","rsvpmaker-for-toastmasters");
$project_options["PERSUASIVE SPEAKING"] .= '<option value="PERSUASIVE SPEAKING 12">'.__(" Conquering the &quot;Cold Call&quot; (10 to 14 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["PERSUASIVE SPEAKING 12"] = 14;

$projects["COMMUNICATING ON VIDEO 15"] = __("Training On Video","rsvpmaker-for-toastmasters");
$project_options["COMMUNICATING ON VIDEO"] .= '<option value="COMMUNICATING ON VIDEO 15">'.__("Training On Video","rsvpmaker-for-toastmasters")."</option>";
$project_times["COMMUNICATING ON VIDEO 15"] = 7;

$projects["SPEECHES BY MANAGEMENT 7"] = __(" Appraise with Praise","rsvpmaker-for-toastmasters");
$project_options["SPEECHES BY MANAGEMENT"] .= '<option value="SPEECHES BY MANAGEMENT 7">'.__(" Appraise with Praise","rsvpmaker-for-toastmasters")."</option>";
$project_times["SPEECHES BY MANAGEMENT 7"] = 7;

$projects["HIGH PERFORMANCE LEADERSHIP 1"] = __("First Speech","rsvpmaker-for-toastmasters");
$project_options["HIGH PERFORMANCE LEADERSHIP"] = '<option value="HIGH PERFORMANCE LEADERSHIP 1">'.__("First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["HIGH PERFORMANCE LEADERSHIP 1"] = 7;

$projects["HIGH PERFORMANCE LEADERSHIP 2"] = __("Second Speech","rsvpmaker-for-toastmasters");
$project_options["HIGH PERFORMANCE LEADERSHIP"] .= '<option value="HIGH PERFORMANCE LEADERSHIP 2">'.__("Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["HIGH PERFORMANCE LEADERSHIP 2"] = 7;


//Pathways

$projects["Dynamic Leadership Level 1 Mastering Fundamentals 0"] = __("Ice Breaker (4 - 6 minutes)","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 1 Mastering Fundamentals"] = '<option value="Dynamic Leadership Level 1 Mastering Fundamentals 0">'.__("Ice Breaker (4 - 6 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 1 Mastering Fundamentals 0"] = 6;

$projects["Dynamic Leadership Level 1 Mastering Fundamentals 11"] = __("Researching and Presenting","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 1 Mastering Fundamentals"] .= '<option value="Dynamic Leadership Level 1 Mastering Fundamentals 11">'.__("Researching and Presenting","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 1 Mastering Fundamentals 11"] = 7;

$projects["Dynamic Leadership Level 1 Mastering Fundamentals 5"] = __("Evaluation and Feedback - First Speech","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 1 Mastering Fundamentals"] .= '<option value="Dynamic Leadership Level 1 Mastering Fundamentals 5">'.__("Evaluation and Feedback - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 1 Mastering Fundamentals 5"] = 7;

$projects["Dynamic Leadership Level 1 Mastering Fundamentals 6"] = __("Evaluation and Feedback - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 1 Mastering Fundamentals"] .= '<option value="Dynamic Leadership Level 1 Mastering Fundamentals 6">'.__("Evaluation and Feedback - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 1 Mastering Fundamentals 6"] = 7;

$projects["Dynamic Leadership Level 1 Mastering Fundamentals 7"] = __("Evaluation and Feedback - Evaluator Speech (2-3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 1 Mastering Fundamentals"] .= '<option value="Dynamic Leadership Level 1 Mastering Fundamentals 7">'.__("Evaluation and Feedback - Evaluator Speech (2-3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 1 Mastering Fundamentals 7"] = 3;

$projects["Dynamic Leadership Level 2 Learning Your Style 20"] = __("Understanding Your Leadership Style","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 2 Learning Your Style"] = '<option value="Dynamic Leadership Level 2 Learning Your Style 20">'.__("Understanding Your Leadership Style","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 2 Learning Your Style 20"] = 7;

$projects["Dynamic Leadership Level 2 Learning Your Style 25"] = __("Understanding Your Communication Style","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 2 Learning Your Style"] .= '<option value="Dynamic Leadership Level 2 Learning Your Style 25">'.__("Understanding Your Communication Style","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 2 Learning Your Style 25"] = 7;

$projects["Dynamic Leadership Level 2 Learning Your Style 31"] = __("Mentoring","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 2 Learning Your Style"] .= '<option value="Dynamic Leadership Level 2 Learning Your Style 31">'.__("Mentoring","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 2 Learning Your Style 31"] = 7;

$projects["Dynamic Leadership Level 3 Increasing Knowledge 105"] = __("Using Descriptive Language","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 3 Increasing Knowledge"] = '<option value="Dynamic Leadership Level 3 Increasing Knowledge 105">'.__("Using Descriptive Language","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 3 Increasing Knowledge 105"] = 7;

$projects["Dynamic Leadership Level 3 Increasing Knowledge 111"] = __("Using Presentation Software","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 3 Increasing Knowledge"] .= '<option value="Dynamic Leadership Level 3 Increasing Knowledge 111">'.__("Using Presentation Software","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 3 Increasing Knowledge 111"] = 7;

$projects["Dynamic Leadership Level 3 Increasing Knowledge 117"] = __("Understanding Vocal Variety","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 3 Increasing Knowledge"] .= '<option value="Dynamic Leadership Level 3 Increasing Knowledge 117">'.__("Understanding Vocal Variety","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 3 Increasing Knowledge 117"] = 7;

$projects["Dynamic Leadership Level 3 Increasing Knowledge 40"] = __("Negotiate the Best Outcome","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 3 Increasing Knowledge"] .= '<option value="Dynamic Leadership Level 3 Increasing Knowledge 40">'.__("Negotiate the Best Outcome","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 3 Increasing Knowledge 40"] = 7;

$projects["Dynamic Leadership Level 3 Increasing Knowledge 45"] = __("Active Listening","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 3 Increasing Knowledge"] .= '<option value="Dynamic Leadership Level 3 Increasing Knowledge 45">'.__("Active Listening","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 3 Increasing Knowledge 45"] = 7;

$projects["Dynamic Leadership Level 3 Increasing Knowledge 51"] = __("Connect with Storytelling","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 3 Increasing Knowledge"] .= '<option value="Dynamic Leadership Level 3 Increasing Knowledge 51">'.__("Connect with Storytelling","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 3 Increasing Knowledge 51"] = 7;

$projects["Dynamic Leadership Level 3 Increasing Knowledge 57"] = __("Connect with Your Audience","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 3 Increasing Knowledge"] .= '<option value="Dynamic Leadership Level 3 Increasing Knowledge 57">'.__("Connect with Your Audience","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 3 Increasing Knowledge 57"] = 7;

$projects["Dynamic Leadership Level 3 Increasing Knowledge 63"] = __("Creating Effective Visual Aids","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 3 Increasing Knowledge"] .= '<option value="Dynamic Leadership Level 3 Increasing Knowledge 63">'.__("Creating Effective Visual Aids","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 3 Increasing Knowledge 63"] = 7;

$projects["Dynamic Leadership Level 3 Increasing Knowledge 69"] = __("Deliver Social Speeches - First Speech","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 3 Increasing Knowledge"] .= '<option value="Dynamic Leadership Level 3 Increasing Knowledge 69">'.__("Deliver Social Speeches - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 3 Increasing Knowledge 69"] = 7;

$projects["Dynamic Leadership Level 3 Increasing Knowledge 70"] = __("Deliver Social Speeches -
 Second Speech","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 3 Increasing Knowledge"] .= '<option value="Dynamic Leadership Level 3 Increasing Knowledge 70">'.__("Deliver Social Speeches -
 Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 3 Increasing Knowledge 70"] = 7;

$projects["Dynamic Leadership Level 3 Increasing Knowledge 75"] = __("Effective Body Language","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 3 Increasing Knowledge"] .= '<option value="Dynamic Leadership Level 3 Increasing Knowledge 75">'.__("Effective Body Language","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 3 Increasing Knowledge 75"] = 7;

$projects["Dynamic Leadership Level 3 Increasing Knowledge 81"] = __("Focus on the Positive","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 3 Increasing Knowledge"] .= '<option value="Dynamic Leadership Level 3 Increasing Knowledge 81">'.__("Focus on the Positive","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 3 Increasing Knowledge 81"] = 7;

$projects["Dynamic Leadership Level 3 Increasing Knowledge 87"] = __("Inspire Your Audience","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 3 Increasing Knowledge"] .= '<option value="Dynamic Leadership Level 3 Increasing Knowledge 87">'.__("Inspire Your Audience","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 3 Increasing Knowledge 87"] = 7;

$projects["Dynamic Leadership Level 3 Increasing Knowledge 93"] = __("Make Connections Through Networking","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 3 Increasing Knowledge"] .= '<option value="Dynamic Leadership Level 3 Increasing Knowledge 93">'.__("Make Connections Through Networking","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 3 Increasing Knowledge 93"] = 7;

$projects["Dynamic Leadership Level 3 Increasing Knowledge 99"] = __("Prepare for an Interview","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 3 Increasing Knowledge"] .= '<option value="Dynamic Leadership Level 3 Increasing Knowledge 99">'.__("Prepare for an Interview","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 3 Increasing Knowledge 99"] = 7;

$projects["Dynamic Leadership Level 4 Building Skills 126"] = __("Manage Change","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 4 Building Skills"] = '<option value="Dynamic Leadership Level 4 Building Skills 126">'.__("Manage Change","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 4 Building Skills 126"] = 7;

$projects["Dynamic Leadership Level 4 Building Skills 131"] = __("Building a Social Media Presence","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 4 Building Skills"] .= '<option value="Dynamic Leadership Level 4 Building Skills 131">'.__("Building a Social Media Presence","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 4 Building Skills 131"] = 7;

$projects["Dynamic Leadership Level 4 Building Skills 137"] = __("Create a Podcast (2-3 minute intro; 5-10 minute podcast)","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 4 Building Skills"] .= '<option value="Dynamic Leadership Level 4 Building Skills 137">'.__("Create a Podcast (2-3 minute intro; 5-10 minute podcast)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 4 Building Skills 137"] = 13;

$projects["Dynamic Leadership Level 4 Building Skills 143"] = __("Manage Online Meetings (20 - 25 minutes)","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 4 Building Skills"] .= '<option value="Dynamic Leadership Level 4 Building Skills 143">'.__("Manage Online Meetings (20 - 25 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 4 Building Skills 143"] = 25;

$projects["Dynamic Leadership Level 4 Building Skills 149"] = __("Managing a Difficult Audience (10 - 15 minutes)","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 4 Building Skills"] .= '<option value="Dynamic Leadership Level 4 Building Skills 149">'.__("Managing a Difficult Audience (10 - 15 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 4 Building Skills 149"] = 15;

$projects["Dynamic Leadership Level 4 Building Skills 155"] = __("Manage Projects Successfully - First Speech (2 - 3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 4 Building Skills"] .= '<option value="Dynamic Leadership Level 4 Building Skills 155">'.__("Manage Projects Successfully - First Speech (2 - 3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 4 Building Skills 155"] = 3;

$projects["Dynamic Leadership Level 4 Building Skills 156"] = __("Manage Projects Successfully - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 4 Building Skills"] .= '<option value="Dynamic Leadership Level 4 Building Skills 156">'.__("Manage Projects Successfully - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 4 Building Skills 156"] = 7;

$projects["Dynamic Leadership Level 4 Building Skills 161"] = __("Public Relations Strategies","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 4 Building Skills"] .= '<option value="Dynamic Leadership Level 4 Building Skills 161">'.__("Public Relations Strategies","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 4 Building Skills 161"] = 7;

$projects["Dynamic Leadership Level 4 Building Skills 167"] = __("Question-and-Answer Session (15 - 20 minutes)","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 4 Building Skills"] .= '<option value="Dynamic Leadership Level 4 Building Skills 167">'.__("Question-and-Answer Session (15 - 20 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 4 Building Skills 167"] = 20;

$projects["Dynamic Leadership Level 4 Building Skills 173"] = __("Write a Compelling Blog (2 - 3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 4 Building Skills"] .= '<option value="Dynamic Leadership Level 4 Building Skills 173">'.__("Write a Compelling Blog (2 - 3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 4 Building Skills 173"] = 3;

$projects["Dynamic Leadership Level 5 Demonstrating Expertise 182"] = __("Lead in Any Situation","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 5 Demonstrating Expertise"] = '<option value="Dynamic Leadership Level 5 Demonstrating Expertise 182">'.__("Lead in Any Situation","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 5 Demonstrating Expertise 182"] = 7;

$projects["Dynamic Leadership Level 5 Demonstrating Expertise 187"] = __("Reflect on Your Path","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 5 Demonstrating Expertise"] .= '<option value="Dynamic Leadership Level 5 Demonstrating Expertise 187">'.__("Reflect on Your Path","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 5 Demonstrating Expertise 187"] = 7;

$projects["Dynamic Leadership Level 5 Demonstrating Expertise 193"] = __("Ethical Leadership (20 - 40 minutes)","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 5 Demonstrating Expertise"] .= '<option value="Dynamic Leadership Level 5 Demonstrating Expertise 193">'.__("Ethical Leadership (20 - 40 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 5 Demonstrating Expertise 193"] = 40;

$projects["Dynamic Leadership Level 5 Demonstrating Expertise 199"] = __("High Performance Leadership - First Speech","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 5 Demonstrating Expertise"] .= '<option value="Dynamic Leadership Level 5 Demonstrating Expertise 199">'.__("High Performance Leadership - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 5 Demonstrating Expertise 199"] = 7;

$projects["Dynamic Leadership Level 5 Demonstrating Expertise 200"] = __("High Performance Leadership - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 5 Demonstrating Expertise"] .= '<option value="Dynamic Leadership Level 5 Demonstrating Expertise 200">'.__("High Performance Leadership - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 5 Demonstrating Expertise 200"] = 7;

$projects["Dynamic Leadership Level 5 Demonstrating Expertise 205"] = __("Leading in Your Volunteer Organization","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 5 Demonstrating Expertise"] .= '<option value="Dynamic Leadership Level 5 Demonstrating Expertise 205">'.__("Leading in Your Volunteer Organization","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 5 Demonstrating Expertise 205"] = 7;

$projects["Dynamic Leadership Level 5 Demonstrating Expertise 211"] = __("Lessons Learned","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 5 Demonstrating Expertise"] .= '<option value="Dynamic Leadership Level 5 Demonstrating Expertise 211">'.__("Lessons Learned","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 5 Demonstrating Expertise 211"] = 7;

$projects["Dynamic Leadership Level 5 Demonstrating Expertise 218"] = __("Moderate a Panel Discussion (20 - 40 minutes)","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 5 Demonstrating Expertise"] .= '<option value="Dynamic Leadership Level 5 Demonstrating Expertise 218">'.__("Moderate a Panel Discussion (20 - 40 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 5 Demonstrating Expertise 218"] = 40;

$projects["Dynamic Leadership Level 5 Demonstrating Expertise 224"] = __("Prepare to Speak Professionally (18 - 22 minutes)","rsvpmaker-for-toastmasters");
$project_options["Dynamic Leadership Level 5 Demonstrating Expertise"] .= '<option value="Dynamic Leadership Level 5 Demonstrating Expertise 224">'.__("Prepare to Speak Professionally (18 - 22 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Dynamic Leadership Level 5 Demonstrating Expertise 224"] = 22;

$projects["Effective Coaching Level 1 Mastering Fundamentals 233"] = __("Ice Breaker (4 - 6 minutes)","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 1 Mastering Fundamentals"] = '<option value="Effective Coaching Level 1 Mastering Fundamentals 233">'.__("Ice Breaker (4 - 6 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 1 Mastering Fundamentals 233"] = 6;

$projects["Effective Coaching Level 1 Mastering Fundamentals 240"] = __("Evaluation and Feedback - First Speech","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 1 Mastering Fundamentals"] .= '<option value="Effective Coaching Level 1 Mastering Fundamentals 240">'.__("Evaluation and Feedback - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 1 Mastering Fundamentals 240"] = 7;

$projects["Effective Coaching Level 1 Mastering Fundamentals 241"] = __("Evaluation and Feedback - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 1 Mastering Fundamentals"] .= '<option value="Effective Coaching Level 1 Mastering Fundamentals 241">'.__("Evaluation and Feedback - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 1 Mastering Fundamentals 241"] = 7;

$projects["Effective Coaching Level 1 Mastering Fundamentals 242"] = __("Evaluation and Feedback - Evaluator Speech (2-3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 1 Mastering Fundamentals"] .= '<option value="Effective Coaching Level 1 Mastering Fundamentals 242">'.__("Evaluation and Feedback - Evaluator Speech (2-3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 1 Mastering Fundamentals 242"] = 3;

$projects["Effective Coaching Level 1 Mastering Fundamentals 246"] = __("Researching and Presenting","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 1 Mastering Fundamentals"] .= '<option value="Effective Coaching Level 1 Mastering Fundamentals 246">'.__("Researching and Presenting","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 1 Mastering Fundamentals 246"] = 7;

$projects["Effective Coaching Level 2 Learning Your Style 256"] = __("Understanding Your Leadership Style","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 2 Learning Your Style"] = '<option value="Effective Coaching Level 2 Learning Your Style 256">'.__("Understanding Your Leadership Style","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 2 Learning Your Style 256"] = 7;

$projects["Effective Coaching Level 2 Learning Your Style 263"] = __("Understanding Your Communication Style","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 2 Learning Your Style"] .= '<option value="Effective Coaching Level 2 Learning Your Style 263">'.__("Understanding Your Communication Style","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 2 Learning Your Style 263"] = 7;

$projects["Effective Coaching Level 2 Learning Your Style 269"] = __("Mentoring","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 2 Learning Your Style"] .= '<option value="Effective Coaching Level 2 Learning Your Style 269">'.__("Mentoring","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 2 Learning Your Style 269"] = 7;

$projects["Effective Coaching Level 3 Increasing Knowledge 278"] = __("Reaching Consensus","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 3 Increasing Knowledge"] = '<option value="Effective Coaching Level 3 Increasing Knowledge 278">'.__("Reaching Consensus","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 3 Increasing Knowledge 278"] = 7;

$projects["Effective Coaching Level 3 Increasing Knowledge 285"] = __("Active Listening","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 3 Increasing Knowledge"] .= '<option value="Effective Coaching Level 3 Increasing Knowledge 285">'.__("Active Listening","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 3 Increasing Knowledge 285"] = 7;

$projects["Effective Coaching Level 3 Increasing Knowledge 291"] = __("Connect with Storytelling","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 3 Increasing Knowledge"] .= '<option value="Effective Coaching Level 3 Increasing Knowledge 291">'.__("Connect with Storytelling","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 3 Increasing Knowledge 291"] = 7;

$projects["Effective Coaching Level 3 Increasing Knowledge 297"] = __("Connect with Your Audience","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 3 Increasing Knowledge"] .= '<option value="Effective Coaching Level 3 Increasing Knowledge 297">'.__("Connect with Your Audience","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 3 Increasing Knowledge 297"] = 7;

$projects["Effective Coaching Level 3 Increasing Knowledge 303"] = __("Creating Effective Visual Aids","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 3 Increasing Knowledge"] .= '<option value="Effective Coaching Level 3 Increasing Knowledge 303">'.__("Creating Effective Visual Aids","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 3 Increasing Knowledge 303"] = 7;

$projects["Effective Coaching Level 3 Increasing Knowledge 309"] = __("Deliver Social Speeches - First Speech","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 3 Increasing Knowledge"] .= '<option value="Effective Coaching Level 3 Increasing Knowledge 309">'.__("Deliver Social Speeches - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 3 Increasing Knowledge 309"] = 7;

$projects["Effective Coaching Level 3 Increasing Knowledge 310"] = __("Deliver Social Speeches - Second Speech ()","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 3 Increasing Knowledge"] .= '<option value="Effective Coaching Level 3 Increasing Knowledge 310">'.__("Deliver Social Speeches - Second Speech ()","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 3 Increasing Knowledge 310"] = 0;

$projects["Effective Coaching Level 3 Increasing Knowledge 315"] = __("Effective Body Language","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 3 Increasing Knowledge"] .= '<option value="Effective Coaching Level 3 Increasing Knowledge 315">'.__("Effective Body Language","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 3 Increasing Knowledge 315"] = 7;

$projects["Effective Coaching Level 3 Increasing Knowledge 321"] = __("Focus on the Positive","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 3 Increasing Knowledge"] .= '<option value="Effective Coaching Level 3 Increasing Knowledge 321">'.__("Focus on the Positive","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 3 Increasing Knowledge 321"] = 7;

$projects["Effective Coaching Level 3 Increasing Knowledge 327"] = __("Inspire Your Audience","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 3 Increasing Knowledge"] .= '<option value="Effective Coaching Level 3 Increasing Knowledge 327">'.__("Inspire Your Audience","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 3 Increasing Knowledge 327"] = 7;

$projects["Effective Coaching Level 3 Increasing Knowledge 333"] = __("Make Connections Through Networking","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 3 Increasing Knowledge"] .= '<option value="Effective Coaching Level 3 Increasing Knowledge 333">'.__("Make Connections Through Networking","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 3 Increasing Knowledge 333"] = 7;

$projects["Effective Coaching Level 3 Increasing Knowledge 339"] = __("Prepare for an Interview","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 3 Increasing Knowledge"] .= '<option value="Effective Coaching Level 3 Increasing Knowledge 339">'.__("Prepare for an Interview","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 3 Increasing Knowledge 339"] = 7;

$projects["Effective Coaching Level 3 Increasing Knowledge 345"] = __("Understanding Vocal Variety","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 3 Increasing Knowledge"] .= '<option value="Effective Coaching Level 3 Increasing Knowledge 345">'.__("Understanding Vocal Variety","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 3 Increasing Knowledge 345"] = 7;

$projects["Effective Coaching Level 3 Increasing Knowledge 351"] = __("Using Descriptive Language","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 3 Increasing Knowledge"] .= '<option value="Effective Coaching Level 3 Increasing Knowledge 351">'.__("Using Descriptive Language","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 3 Increasing Knowledge 351"] = 7;

$projects["Effective Coaching Level 3 Increasing Knowledge 357"] = __("Using Presentation Software","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 3 Increasing Knowledge"] .= '<option value="Effective Coaching Level 3 Increasing Knowledge 357">'.__("Using Presentation Software","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 3 Increasing Knowledge 357"] = 7;

$projects["Effective Coaching Level 4 Building Skills 366"] = __("Building a Social Media Presence","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 4 Building Skills"] = '<option value="Effective Coaching Level 4 Building Skills 366">'.__("Building a Social Media Presence","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 4 Building Skills 366"] = 7;

$projects["Effective Coaching Level 4 Building Skills 373"] = __("Create a Podcast (2-3 minute intro; 5-10 minute podcast)","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 4 Building Skills"] .= '<option value="Effective Coaching Level 4 Building Skills 373">'.__("Create a Podcast (2-3 minute intro; 5-10 minute podcast)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 4 Building Skills 373"] = 13;

$projects["Effective Coaching Level 4 Building Skills 385"] = __("Manage Online Meetings (20 - 25 minutes)","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 4 Building Skills"] .= '<option value="Effective Coaching Level 4 Building Skills 385">'.__("Manage Online Meetings (20 - 25 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 4 Building Skills 385"] = 25;

$projects["Effective Coaching Level 4 Building Skills 391"] = __("Manage Projects Successfully - First Speech (2 - 3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 4 Building Skills"] .= '<option value="Effective Coaching Level 4 Building Skills 391">'.__("Manage Projects Successfully - First Speech (2 - 3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 4 Building Skills 391"] = 3;

$projects["Effective Coaching Level 4 Building Skills 392"] = __("Manage Projects Successfully - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 4 Building Skills"] .= '<option value="Effective Coaching Level 4 Building Skills 392">'.__("Manage Projects Successfully - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 4 Building Skills 392"] = 7;

$projects["Effective Coaching Level 4 Building Skills 397"] = __("Managing a Difficult Audience (10 - 15 minutes)","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 4 Building Skills"] .= '<option value="Effective Coaching Level 4 Building Skills 397">'.__("Managing a Difficult Audience (10 - 15 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 4 Building Skills 397"] = 15;

$projects["Effective Coaching Level 4 Building Skills 403"] = __("Public Relations Strategies","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 4 Building Skills"] .= '<option value="Effective Coaching Level 4 Building Skills 403">'.__("Public Relations Strategies","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 4 Building Skills 403"] = 7;

$projects["Effective Coaching Level 4 Building Skills 409"] = __("Question-and-Answer Session (15 - 20 minutes)","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 4 Building Skills"] .= '<option value="Effective Coaching Level 4 Building Skills 409">'.__("Question-and-Answer Session (15 - 20 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 4 Building Skills 409"] = 20;

$projects["Effective Coaching Level 4 Building Skills 415"] = __("Write a Compelling Blog (2 - 3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 4 Building Skills"] .= '<option value="Effective Coaching Level 4 Building Skills 415">'.__("Write a Compelling Blog (2 - 3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 4 Building Skills 415"] = 3;

$projects["Effective Coaching Level 4 Building Skills 422"] = __("Improvement Through Positive Coaching","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 4 Building Skills"] .= '<option value="Effective Coaching Level 4 Building Skills 422">'.__("Improvement Through Positive Coaching","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 4 Building Skills 422"] = 7;

$projects["Effective Coaching Level 5 Demonstrating Expertise 424"] = __("High Performance Leadership - First Speech","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 5 Demonstrating Expertise"] = '<option value="Effective Coaching Level 5 Demonstrating Expertise 424">'.__("High Performance Leadership - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 5 Demonstrating Expertise 424"] = 7;

$projects["Effective Coaching Level 5 Demonstrating Expertise 425"] = __("High Performance Leadership - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 5 Demonstrating Expertise"] .= '<option value="Effective Coaching Level 5 Demonstrating Expertise 425">'.__("High Performance Leadership - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 5 Demonstrating Expertise 425"] = 7;

$projects["Effective Coaching Level 5 Demonstrating Expertise 431"] = __("Reflect on Your Path","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 5 Demonstrating Expertise"] .= '<option value="Effective Coaching Level 5 Demonstrating Expertise 431">'.__("Reflect on Your Path","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 5 Demonstrating Expertise 431"] = 7;

$projects["Effective Coaching Level 5 Demonstrating Expertise 437"] = __("Ethical Leadership (20 - 40 minutes)","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 5 Demonstrating Expertise"] .= '<option value="Effective Coaching Level 5 Demonstrating Expertise 437">'.__("Ethical Leadership (20 - 40 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 5 Demonstrating Expertise 437"] = 40;

$projects["Effective Coaching Level 5 Demonstrating Expertise 443"] = __("Leading in Your Volunteer Organization","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 5 Demonstrating Expertise"] .= '<option value="Effective Coaching Level 5 Demonstrating Expertise 443">'.__("Leading in Your Volunteer Organization","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 5 Demonstrating Expertise 443"] = 7;

$projects["Effective Coaching Level 5 Demonstrating Expertise 449"] = __("Lessons Learned","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 5 Demonstrating Expertise"] .= '<option value="Effective Coaching Level 5 Demonstrating Expertise 449">'.__("Lessons Learned","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 5 Demonstrating Expertise 449"] = 7;

$projects["Effective Coaching Level 5 Demonstrating Expertise 455"] = __("Moderate a Panel Discussion (20 - 40 minutes)","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 5 Demonstrating Expertise"] .= '<option value="Effective Coaching Level 5 Demonstrating Expertise 455">'.__("Moderate a Panel Discussion (20 - 40 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 5 Demonstrating Expertise 455"] = 40;

$projects["Effective Coaching Level 5 Demonstrating Expertise 461"] = __("Prepare to Speak Professionally (18 - 22 minutes)","rsvpmaker-for-toastmasters");
$project_options["Effective Coaching Level 5 Demonstrating Expertise"] .= '<option value="Effective Coaching Level 5 Demonstrating Expertise 461">'.__("Prepare to Speak Professionally (18 - 22 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Effective Coaching Level 5 Demonstrating Expertise 461"] = 22;

$projects["Innovative Planning Level 1 Mastering Fundamentals 470"] = __("Ice Breaker (4 - 6 minutes)","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 1 Mastering Fundamentals"] = '<option value="Innovative Planning Level 1 Mastering Fundamentals 470">'.__("Ice Breaker (4 - 6 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 1 Mastering Fundamentals 470"] = 6;

$projects["Innovative Planning Level 1 Mastering Fundamentals 477"] = __("Evaluation and Feedback - First Speech","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 1 Mastering Fundamentals"] .= '<option value="Innovative Planning Level 1 Mastering Fundamentals 477">'.__("Evaluation and Feedback - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 1 Mastering Fundamentals 477"] = 7;

$projects["Innovative Planning Level 1 Mastering Fundamentals 478"] = __("Evaluation and Feedback - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 1 Mastering Fundamentals"] .= '<option value="Innovative Planning Level 1 Mastering Fundamentals 478">'.__("Evaluation and Feedback - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 1 Mastering Fundamentals 478"] = 7;

$projects["Innovative Planning Level 1 Mastering Fundamentals 479"] = __("Evaluation and Feedback - Evaluator Speech (2-3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 1 Mastering Fundamentals"] .= '<option value="Innovative Planning Level 1 Mastering Fundamentals 479">'.__("Evaluation and Feedback - Evaluator Speech (2-3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 1 Mastering Fundamentals 479"] = 3;

$projects["Innovative Planning Level 1 Mastering Fundamentals 483"] = __("Researching and Presenting","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 1 Mastering Fundamentals"] .= '<option value="Innovative Planning Level 1 Mastering Fundamentals 483">'.__("Researching and Presenting","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 1 Mastering Fundamentals 483"] = 7;

$projects["Innovative Planning Level 2 Learning Your Style 492"] = __("Understanding Your Leadership Style","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 2 Learning Your Style"] = '<option value="Innovative Planning Level 2 Learning Your Style 492">'.__("Understanding Your Leadership Style","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 2 Learning Your Style 492"] = 7;

$projects["Innovative Planning Level 2 Learning Your Style 499"] = __("Connect with Your Audience","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 2 Learning Your Style"] .= '<option value="Innovative Planning Level 2 Learning Your Style 499">'.__("Connect with Your Audience","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 2 Learning Your Style 499"] = 7;

$projects["Innovative Planning Level 2 Learning Your Style 505"] = __("Mentoring","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 2 Learning Your Style"] .= '<option value="Innovative Planning Level 2 Learning Your Style 505">'.__("Mentoring","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 2 Learning Your Style 505"] = 7;

$projects["Innovative Planning Level 3 Increasing Knowledge 514"] = __("Present a Proposal","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 3 Increasing Knowledge"] = '<option value="Innovative Planning Level 3 Increasing Knowledge 514">'.__("Present a Proposal","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 3 Increasing Knowledge 514"] = 7;

$projects["Innovative Planning Level 3 Increasing Knowledge 521"] = __("Active Listening","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 3 Increasing Knowledge"] .= '<option value="Innovative Planning Level 3 Increasing Knowledge 521">'.__("Active Listening","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 3 Increasing Knowledge 521"] = 7;

$projects["Innovative Planning Level 3 Increasing Knowledge 527"] = __("Connect with Storytelling","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 3 Increasing Knowledge"] .= '<option value="Innovative Planning Level 3 Increasing Knowledge 527">'.__("Connect with Storytelling","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 3 Increasing Knowledge 527"] = 7;

$projects["Innovative Planning Level 3 Increasing Knowledge 533"] = __("Creating Effective Visual Aids","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 3 Increasing Knowledge"] .= '<option value="Innovative Planning Level 3 Increasing Knowledge 533">'.__("Creating Effective Visual Aids","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 3 Increasing Knowledge 533"] = 7;

$projects["Innovative Planning Level 3 Increasing Knowledge 539"] = __("Deliver Social Speeches - First Speech","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 3 Increasing Knowledge"] .= '<option value="Innovative Planning Level 3 Increasing Knowledge 539">'.__("Deliver Social Speeches - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 3 Increasing Knowledge 539"] = 7;

$projects["Innovative Planning Level 3 Increasing Knowledge 545"] = __("Effective Body Language","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 3 Increasing Knowledge"] .= '<option value="Innovative Planning Level 3 Increasing Knowledge 545">'.__("Effective Body Language","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 3 Increasing Knowledge 545"] = 7;

$projects["Innovative Planning Level 3 Increasing Knowledge 551"] = __("Focus on the Positive","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 3 Increasing Knowledge"] .= '<option value="Innovative Planning Level 3 Increasing Knowledge 551">'.__("Focus on the Positive","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 3 Increasing Knowledge 551"] = 7;

$projects["Innovative Planning Level 3 Increasing Knowledge 557"] = __("Inspire Your Audience","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 3 Increasing Knowledge"] .= '<option value="Innovative Planning Level 3 Increasing Knowledge 557">'.__("Inspire Your Audience","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 3 Increasing Knowledge 557"] = 7;

$projects["Innovative Planning Level 3 Increasing Knowledge 563"] = __("Make Connections Through Networking","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 3 Increasing Knowledge"] .= '<option value="Innovative Planning Level 3 Increasing Knowledge 563">'.__("Make Connections Through Networking","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 3 Increasing Knowledge 563"] = 7;

$projects["Innovative Planning Level 3 Increasing Knowledge 569"] = __("Prepare for an Interview","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 3 Increasing Knowledge"] .= '<option value="Innovative Planning Level 3 Increasing Knowledge 569">'.__("Prepare for an Interview","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 3 Increasing Knowledge 569"] = 7;

$projects["Innovative Planning Level 3 Increasing Knowledge 575"] = __("Understanding Vocal Variety","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 3 Increasing Knowledge"] .= '<option value="Innovative Planning Level 3 Increasing Knowledge 575">'.__("Understanding Vocal Variety","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 3 Increasing Knowledge 575"] = 7;

$projects["Innovative Planning Level 3 Increasing Knowledge 581"] = __("Using Descriptive Language","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 3 Increasing Knowledge"] .= '<option value="Innovative Planning Level 3 Increasing Knowledge 581">'.__("Using Descriptive Language","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 3 Increasing Knowledge 581"] = 7;

$projects["Innovative Planning Level 3 Increasing Knowledge 587"] = __("Using Presentation Software","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 3 Increasing Knowledge"] .= '<option value="Innovative Planning Level 3 Increasing Knowledge 587">'.__("Using Presentation Software","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 3 Increasing Knowledge 587"] = 7;

$projects["Innovative Planning Level 4 Building Skills 596"] = __("Manage Projects Successfully - First Speech (2 - 3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 4 Building Skills"] = '<option value="Innovative Planning Level 4 Building Skills 596">'.__("Manage Projects Successfully - First Speech (2 - 3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 4 Building Skills 596"] = 3;

$projects["Innovative Planning Level 4 Building Skills 598"] = __("Manage Projects Successfully - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 4 Building Skills"] .= '<option value="Innovative Planning Level 4 Building Skills 598">'.__("Manage Projects Successfully - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 4 Building Skills 598"] = 7;

$projects["Innovative Planning Level 4 Building Skills 603"] = __("Building a Social Media Presence","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 4 Building Skills"] .= '<option value="Innovative Planning Level 4 Building Skills 603">'.__("Building a Social Media Presence","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 4 Building Skills 603"] = 7;

$projects["Innovative Planning Level 4 Building Skills 609"] = __("Create a Podcast (2-3 minute intro; 5-10 minute podcast)","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 4 Building Skills"] .= '<option value="Innovative Planning Level 4 Building Skills 609">'.__("Create a Podcast (2-3 minute intro; 5-10 minute podcast)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 4 Building Skills 609"] = 13;

$projects["Innovative Planning Level 4 Building Skills 615"] = __("Manage Online Meetings (20 - 25 minutes)","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 4 Building Skills"] .= '<option value="Innovative Planning Level 4 Building Skills 615">'.__("Manage Online Meetings (20 - 25 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 4 Building Skills 615"] = 25;

$projects["Innovative Planning Level 4 Building Skills 621"] = __("Managing a Difficult Audience (10 - 15 minutes)","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 4 Building Skills"] .= '<option value="Innovative Planning Level 4 Building Skills 621">'.__("Managing a Difficult Audience (10 - 15 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 4 Building Skills 621"] = 15;

$projects["Innovative Planning Level 4 Building Skills 627"] = __("Public Relations Strategies","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 4 Building Skills"] .= '<option value="Innovative Planning Level 4 Building Skills 627">'.__("Public Relations Strategies","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 4 Building Skills 627"] = 7;

$projects["Innovative Planning Level 4 Building Skills 633"] = __("Question-and-Answer Session (15 - 20 minutes)","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 4 Building Skills"] .= '<option value="Innovative Planning Level 4 Building Skills 633">'.__("Question-and-Answer Session (15 - 20 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 4 Building Skills 633"] = 20;

$projects["Innovative Planning Level 4 Building Skills 639"] = __("Write a Compelling Blog (2 - 3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 4 Building Skills"] .= '<option value="Innovative Planning Level 4 Building Skills 639">'.__("Write a Compelling Blog (2 - 3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 4 Building Skills 639"] = 3;

$projects["Innovative Planning Level 5 Demonstrating Expertise 648"] = __("High Performance Leadership - First Speech","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 5 Demonstrating Expertise"] = '<option value="Innovative Planning Level 5 Demonstrating Expertise 648">'.__("High Performance Leadership - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 5 Demonstrating Expertise 648"] = 7;

$projects["Innovative Planning Level 5 Demonstrating Expertise 649"] = __("High Performance Leadership - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 5 Demonstrating Expertise"] .= '<option value="Innovative Planning Level 5 Demonstrating Expertise 649">'.__("High Performance Leadership - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 5 Demonstrating Expertise 649"] = 7;

$projects["Innovative Planning Level 5 Demonstrating Expertise 655"] = __("Reflect on Your Path","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 5 Demonstrating Expertise"] .= '<option value="Innovative Planning Level 5 Demonstrating Expertise 655">'.__("Reflect on Your Path","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 5 Demonstrating Expertise 655"] = 7;

$projects["Innovative Planning Level 5 Demonstrating Expertise 661"] = __("Ethical Leadership (20 - 40 minutes)","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 5 Demonstrating Expertise"] .= '<option value="Innovative Planning Level 5 Demonstrating Expertise 661">'.__("Ethical Leadership (20 - 40 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 5 Demonstrating Expertise 661"] = 40;

$projects["Innovative Planning Level 5 Demonstrating Expertise 667"] = __("Leading in Your Volunteer Organization","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 5 Demonstrating Expertise"] .= '<option value="Innovative Planning Level 5 Demonstrating Expertise 667">'.__("Leading in Your Volunteer Organization","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 5 Demonstrating Expertise 667"] = 7;

$projects["Innovative Planning Level 5 Demonstrating Expertise 673"] = __("Lessons Learned","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 5 Demonstrating Expertise"] .= '<option value="Innovative Planning Level 5 Demonstrating Expertise 673">'.__("Lessons Learned","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 5 Demonstrating Expertise 673"] = 7;

$projects["Innovative Planning Level 5 Demonstrating Expertise 679"] = __("Moderate a Panel Discussion (20 - 40 minutes)","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 5 Demonstrating Expertise"] .= '<option value="Innovative Planning Level 5 Demonstrating Expertise 679">'.__("Moderate a Panel Discussion (20 - 40 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 5 Demonstrating Expertise 679"] = 40;

$projects["Innovative Planning Level 5 Demonstrating Expertise 685"] = __("Prepare to Speak Professionally (18 - 22 minutes)","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 5 Demonstrating Expertise"] .= '<option value="Innovative Planning Level 5 Demonstrating Expertise 685">'.__("Prepare to Speak Professionally (18 - 22 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 5 Demonstrating Expertise 685"] = 22;

$projects["Innovative Planning Level 6 7"] = __("Lessons Learned","rsvpmaker-for-toastmasters");
$project_options["Innovative Planning Level 6"] = '<option value="Innovative Planning Level 6 7">'.__("Lessons Learned","rsvpmaker-for-toastmasters")."</option>";
$project_times["Innovative Planning Level 6 7"] = 7;

$projects["Leadership Development Level 1 Mastering Fundamentals 694"] = __("Ice Breaker (4 - 6 minutes)","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 1 Mastering Fundamentals"] = '<option value="Leadership Development Level 1 Mastering Fundamentals 694">'.__("Ice Breaker (4 - 6 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 1 Mastering Fundamentals 694"] = 6;

$projects["Leadership Development Level 1 Mastering Fundamentals 701"] = __("Evaluation and Feedback - First Speech","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 1 Mastering Fundamentals"] .= '<option value="Leadership Development Level 1 Mastering Fundamentals 701">'.__("Evaluation and Feedback - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 1 Mastering Fundamentals 701"] = 7;

$projects["Leadership Development Level 1 Mastering Fundamentals 702"] = __("Evaluation and Feedback - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 1 Mastering Fundamentals"] .= '<option value="Leadership Development Level 1 Mastering Fundamentals 702">'.__("Evaluation and Feedback - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 1 Mastering Fundamentals 702"] = 7;

$projects["Leadership Development Level 1 Mastering Fundamentals 703"] = __("Evaluation and Feedback - Evaluator Speech (2-3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 1 Mastering Fundamentals"] .= '<option value="Leadership Development Level 1 Mastering Fundamentals 703">'.__("Evaluation and Feedback - Evaluator Speech (2-3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 1 Mastering Fundamentals 703"] = 3;

$projects["Leadership Development Level 1 Mastering Fundamentals 707"] = __("Researching and Presenting","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 1 Mastering Fundamentals"] .= '<option value="Leadership Development Level 1 Mastering Fundamentals 707">'.__("Researching and Presenting","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 1 Mastering Fundamentals 707"] = 7;

$projects["Leadership Development Level 2 Learning Your Style 716"] = __("Managing Time","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 2 Learning Your Style"] = '<option value="Leadership Development Level 2 Learning Your Style 716">'.__("Managing Time","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 2 Learning Your Style 716"] = 7;

$projects["Leadership Development Level 2 Learning Your Style 723"] = __("Understanding Your Leadership Style","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 2 Learning Your Style"] .= '<option value="Leadership Development Level 2 Learning Your Style 723">'.__("Understanding Your Leadership Style","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 2 Learning Your Style 723"] = 7;

$projects["Leadership Development Level 2 Learning Your Style 729"] = __("Mentoring","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 2 Learning Your Style"] .= '<option value="Leadership Development Level 2 Learning Your Style 729">'.__("Mentoring","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 2 Learning Your Style 729"] = 7;

$projects["Leadership Development Level 3 Increasing Knowledge 738"] = __("Planning and Implementing","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 3 Increasing Knowledge"] = '<option value="Leadership Development Level 3 Increasing Knowledge 738">'.__("Planning and Implementing","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 3 Increasing Knowledge 738"] = 7;

$projects["Leadership Development Level 3 Increasing Knowledge 745"] = __("Active Listening","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 3 Increasing Knowledge"] .= '<option value="Leadership Development Level 3 Increasing Knowledge 745">'.__("Active Listening","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 3 Increasing Knowledge 745"] = 7;

$projects["Leadership Development Level 3 Increasing Knowledge 751"] = __("Connect with Storytelling","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 3 Increasing Knowledge"] .= '<option value="Leadership Development Level 3 Increasing Knowledge 751">'.__("Connect with Storytelling","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 3 Increasing Knowledge 751"] = 7;

$projects["Leadership Development Level 3 Increasing Knowledge 757"] = __("Connect with Your Audience","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 3 Increasing Knowledge"] .= '<option value="Leadership Development Level 3 Increasing Knowledge 757">'.__("Connect with Your Audience","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 3 Increasing Knowledge 757"] = 7;

$projects["Leadership Development Level 3 Increasing Knowledge 763"] = __("Creating Effective Visual Aids","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 3 Increasing Knowledge"] .= '<option value="Leadership Development Level 3 Increasing Knowledge 763">'.__("Creating Effective Visual Aids","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 3 Increasing Knowledge 763"] = 7;

$projects["Leadership Development Level 3 Increasing Knowledge 769"] = __("Deliver Social Speeches - First Speech","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 3 Increasing Knowledge"] .= '<option value="Leadership Development Level 3 Increasing Knowledge 769">'.__("Deliver Social Speeches - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 3 Increasing Knowledge 769"] = 7;

$projects["Leadership Development Level 3 Increasing Knowledge 775"] = __("Effective Body Language","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 3 Increasing Knowledge"] .= '<option value="Leadership Development Level 3 Increasing Knowledge 775">'.__("Effective Body Language","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 3 Increasing Knowledge 775"] = 7;

$projects["Leadership Development Level 3 Increasing Knowledge 781"] = __("Focus on the Positive","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 3 Increasing Knowledge"] .= '<option value="Leadership Development Level 3 Increasing Knowledge 781">'.__("Focus on the Positive","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 3 Increasing Knowledge 781"] = 7;

$projects["Leadership Development Level 3 Increasing Knowledge 787"] = __("Inspire Your Audience","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 3 Increasing Knowledge"] .= '<option value="Leadership Development Level 3 Increasing Knowledge 787">'.__("Inspire Your Audience","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 3 Increasing Knowledge 787"] = 7;

$projects["Leadership Development Level 3 Increasing Knowledge 793"] = __("Make Connections Through Networking","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 3 Increasing Knowledge"] .= '<option value="Leadership Development Level 3 Increasing Knowledge 793">'.__("Make Connections Through Networking","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 3 Increasing Knowledge 793"] = 7;

$projects["Leadership Development Level 3 Increasing Knowledge 799"] = __("Prepare for an Interview","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 3 Increasing Knowledge"] .= '<option value="Leadership Development Level 3 Increasing Knowledge 799">'.__("Prepare for an Interview","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 3 Increasing Knowledge 799"] = 7;

$projects["Leadership Development Level 3 Increasing Knowledge 805"] = __("Understanding Vocal Variety","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 3 Increasing Knowledge"] .= '<option value="Leadership Development Level 3 Increasing Knowledge 805">'.__("Understanding Vocal Variety","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 3 Increasing Knowledge 805"] = 7;

$projects["Leadership Development Level 3 Increasing Knowledge 811"] = __("Using Descriptive Language","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 3 Increasing Knowledge"] .= '<option value="Leadership Development Level 3 Increasing Knowledge 811">'.__("Using Descriptive Language","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 3 Increasing Knowledge 811"] = 7;

$projects["Leadership Development Level 3 Increasing Knowledge 817"] = __("Using Presentation Software","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 3 Increasing Knowledge"] .= '<option value="Leadership Development Level 3 Increasing Knowledge 817">'.__("Using Presentation Software","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 3 Increasing Knowledge 817"] = 7;

$projects["Leadership Development Level 4 Building Skills 826"] = __("Leading Your Team","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 4 Building Skills"] = '<option value="Leadership Development Level 4 Building Skills 826">'.__("Leading Your Team","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 4 Building Skills 826"] = 7;

$projects["Leadership Development Level 4 Building Skills 833"] = __("Building a Social Media Presence","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 4 Building Skills"] .= '<option value="Leadership Development Level 4 Building Skills 833">'.__("Building a Social Media Presence","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 4 Building Skills 833"] = 7;

$projects["Leadership Development Level 4 Building Skills 839"] = __("Create a Podcast (2-3 minute intro; 5-10 minute podcast)","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 4 Building Skills"] .= '<option value="Leadership Development Level 4 Building Skills 839">'.__("Create a Podcast (2-3 minute intro; 5-10 minute podcast)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 4 Building Skills 839"] = 13;

$projects["Leadership Development Level 4 Building Skills 845"] = __("Manage Online Meetings (20 - 25 minutes)","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 4 Building Skills"] .= '<option value="Leadership Development Level 4 Building Skills 845">'.__("Manage Online Meetings (20 - 25 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 4 Building Skills 845"] = 25;

$projects["Leadership Development Level 4 Building Skills 851"] = __("Manage Projects Successfully - First Speech (2 - 3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 4 Building Skills"] .= '<option value="Leadership Development Level 4 Building Skills 851">'.__("Manage Projects Successfully - First Speech (2 - 3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 4 Building Skills 851"] = 3;

$projects["Leadership Development Level 4 Building Skills 852"] = __("Manage Projects Successfully - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 4 Building Skills"] .= '<option value="Leadership Development Level 4 Building Skills 852">'.__("Manage Projects Successfully - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 4 Building Skills 852"] = 7;

$projects["Leadership Development Level 4 Building Skills 857"] = __("Managing a Difficult Audience (10 - 15 minutes)","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 4 Building Skills"] .= '<option value="Leadership Development Level 4 Building Skills 857">'.__("Managing a Difficult Audience (10 - 15 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 4 Building Skills 857"] = 15;

$projects["Leadership Development Level 4 Building Skills 863"] = __("Public Relations Strategies","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 4 Building Skills"] .= '<option value="Leadership Development Level 4 Building Skills 863">'.__("Public Relations Strategies","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 4 Building Skills 863"] = 7;

$projects["Leadership Development Level 4 Building Skills 869"] = __("Question-and-Answer Session (15 - 20 minutes)","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 4 Building Skills"] .= '<option value="Leadership Development Level 4 Building Skills 869">'.__("Question-and-Answer Session (15 - 20 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 4 Building Skills 869"] = 20;

$projects["Leadership Development Level 4 Building Skills 875"] = __("Write a Compelling Blog (2 - 3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 4 Building Skills"] .= '<option value="Leadership Development Level 4 Building Skills 875">'.__("Write a Compelling Blog (2 - 3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 4 Building Skills 875"] = 3;

$projects["Leadership Development Level 5 Demonstrating Expertise 884"] = __("Manage Successful Events","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 5 Demonstrating Expertise"] = '<option value="Leadership Development Level 5 Demonstrating Expertise 884">'.__("Manage Successful Events","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 5 Demonstrating Expertise 884"] = 7;

$projects["Leadership Development Level 5 Demonstrating Expertise 891"] = __("Reflect on Your Path","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 5 Demonstrating Expertise"] .= '<option value="Leadership Development Level 5 Demonstrating Expertise 891">'.__("Reflect on Your Path","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 5 Demonstrating Expertise 891"] = 7;

$projects["Leadership Development Level 5 Demonstrating Expertise 897"] = __("Ethical Leadership (20 - 40 minutes)","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 5 Demonstrating Expertise"] .= '<option value="Leadership Development Level 5 Demonstrating Expertise 897">'.__("Ethical Leadership (20 - 40 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 5 Demonstrating Expertise 897"] = 40;

$projects["Leadership Development Level 5 Demonstrating Expertise 903"] = __("High Performance Leadership - First Speech","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 5 Demonstrating Expertise"] .= '<option value="Leadership Development Level 5 Demonstrating Expertise 903">'.__("High Performance Leadership - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 5 Demonstrating Expertise 903"] = 7;

$projects["Leadership Development Level 5 Demonstrating Expertise 904"] = __("High Performance Leadership - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 5 Demonstrating Expertise"] .= '<option value="Leadership Development Level 5 Demonstrating Expertise 904">'.__("High Performance Leadership - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 5 Demonstrating Expertise 904"] = 7;

$projects["Leadership Development Level 5 Demonstrating Expertise 909"] = __("Leading in Your Volunteer Organization","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 5 Demonstrating Expertise"] .= '<option value="Leadership Development Level 5 Demonstrating Expertise 909">'.__("Leading in Your Volunteer Organization","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 5 Demonstrating Expertise 909"] = 7;

$projects["Leadership Development Level 5 Demonstrating Expertise 915"] = __("Lessons Learned","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 5 Demonstrating Expertise"] .= '<option value="Leadership Development Level 5 Demonstrating Expertise 915">'.__("Lessons Learned","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 5 Demonstrating Expertise 915"] = 7;

$projects["Leadership Development Level 5 Demonstrating Expertise 921"] = __("Moderate a Panel Discussion (20 - 40 minutes)","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 5 Demonstrating Expertise"] .= '<option value="Leadership Development Level 5 Demonstrating Expertise 921">'.__("Moderate a Panel Discussion (20 - 40 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 5 Demonstrating Expertise 921"] = 40;

$projects["Leadership Development Level 5 Demonstrating Expertise 927"] = __("Prepare to Speak Professionally (18 - 22 minutes)","rsvpmaker-for-toastmasters");
$project_options["Leadership Development Level 5 Demonstrating Expertise"] .= '<option value="Leadership Development Level 5 Demonstrating Expertise 927">'.__("Prepare to Speak Professionally (18 - 22 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Leadership Development Level 5 Demonstrating Expertise 927"] = 22;

$projects["Motivational Strategies Level 1 Mastering Fundamentals 937"] = __("Ice Breaker (4 - 6 minutes)","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 1 Mastering Fundamentals"] = '<option value="Motivational Strategies Level 1 Mastering Fundamentals 937">'.__("Ice Breaker (4 - 6 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 1 Mastering Fundamentals 937"] = 6;

$projects["Motivational Strategies Level 1 Mastering Fundamentals 944"] = __("Evaluation and Feedback - First Speech","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 1 Mastering Fundamentals"] .= '<option value="Motivational Strategies Level 1 Mastering Fundamentals 944">'.__("Evaluation and Feedback - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 1 Mastering Fundamentals 944"] = 7;

$projects["Motivational Strategies Level 1 Mastering Fundamentals 945"] = __("Evaluation and Feedback - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 1 Mastering Fundamentals"] .= '<option value="Motivational Strategies Level 1 Mastering Fundamentals 945">'.__("Evaluation and Feedback - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 1 Mastering Fundamentals 945"] = 7;

$projects["Motivational Strategies Level 1 Mastering Fundamentals 946"] = __("Evaluation and Feedback - Evaluator Speech (2-3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 1 Mastering Fundamentals"] .= '<option value="Motivational Strategies Level 1 Mastering Fundamentals 946">'.__("Evaluation and Feedback - Evaluator Speech (2-3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 1 Mastering Fundamentals 946"] = 3;

$projects["Motivational Strategies Level 1 Mastering Fundamentals 950"] = __("Researching and Presenting","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 1 Mastering Fundamentals"] .= '<option value="Motivational Strategies Level 1 Mastering Fundamentals 950">'.__("Researching and Presenting","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 1 Mastering Fundamentals 950"] = 7;

$projects["Motivational Strategies Level 2 Learning Your Style 959"] = __("Understanding Your Communication Style","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 2 Learning Your Style"] = '<option value="Motivational Strategies Level 2 Learning Your Style 959">'.__("Understanding Your Communication Style","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 2 Learning Your Style 959"] = 7;

$projects["Motivational Strategies Level 2 Learning Your Style 966"] = __("Active Listening","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 2 Learning Your Style"] .= '<option value="Motivational Strategies Level 2 Learning Your Style 966">'.__("Active Listening","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 2 Learning Your Style 966"] = 7;

$projects["Motivational Strategies Level 2 Learning Your Style 972"] = __("Mentoring","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 2 Learning Your Style"] .= '<option value="Motivational Strategies Level 2 Learning Your Style 972">'.__("Mentoring","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 2 Learning Your Style 972"] = 7;

$projects["Motivational Strategies Level 3 Increasing Knowledge 1000"] = __("Creating Effective Visual Aids","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 3 Increasing Knowledge"] = '<option value="Motivational Strategies Level 3 Increasing Knowledge 1000">'.__("Creating Effective Visual Aids","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 3 Increasing Knowledge 1000"] = 7;

$projects["Motivational Strategies Level 3 Increasing Knowledge 1006"] = __("Deliver Social Speeches - First Speech","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 3 Increasing Knowledge"] .= '<option value="Motivational Strategies Level 3 Increasing Knowledge 1006">'.__("Deliver Social Speeches - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 3 Increasing Knowledge 1006"] = 7;

$projects["Motivational Strategies Level 3 Increasing Knowledge 1012"] = __("Effective Body Language","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 3 Increasing Knowledge"] .= '<option value="Motivational Strategies Level 3 Increasing Knowledge 1012">'.__("Effective Body Language","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 3 Increasing Knowledge 1012"] = 7;

$projects["Motivational Strategies Level 3 Increasing Knowledge 1018"] = __("Focus on the Positive","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 3 Increasing Knowledge"] .= '<option value="Motivational Strategies Level 3 Increasing Knowledge 1018">'.__("Focus on the Positive","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 3 Increasing Knowledge 1018"] = 7;

$projects["Motivational Strategies Level 3 Increasing Knowledge 1024"] = __("Inspire Your Audience","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 3 Increasing Knowledge"] .= '<option value="Motivational Strategies Level 3 Increasing Knowledge 1024">'.__("Inspire Your Audience","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 3 Increasing Knowledge 1024"] = 7;

$projects["Motivational Strategies Level 3 Increasing Knowledge 1030"] = __("Make Connections Through Networking","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 3 Increasing Knowledge"] .= '<option value="Motivational Strategies Level 3 Increasing Knowledge 1030">'.__("Make Connections Through Networking","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 3 Increasing Knowledge 1030"] = 7;

$projects["Motivational Strategies Level 3 Increasing Knowledge 1036"] = __("Prepare for an Interview","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 3 Increasing Knowledge"] .= '<option value="Motivational Strategies Level 3 Increasing Knowledge 1036">'.__("Prepare for an Interview","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 3 Increasing Knowledge 1036"] = 7;

$projects["Motivational Strategies Level 3 Increasing Knowledge 1042"] = __("Understanding Vocal Variety","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 3 Increasing Knowledge"] .= '<option value="Motivational Strategies Level 3 Increasing Knowledge 1042">'.__("Understanding Vocal Variety","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 3 Increasing Knowledge 1042"] = 7;

$projects["Motivational Strategies Level 3 Increasing Knowledge 1048"] = __("Using Descriptive Language","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 3 Increasing Knowledge"] .= '<option value="Motivational Strategies Level 3 Increasing Knowledge 1048">'.__("Using Descriptive Language","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 3 Increasing Knowledge 1048"] = 7;

$projects["Motivational Strategies Level 3 Increasing Knowledge 1054"] = __("Using Presentation Software","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 3 Increasing Knowledge"] .= '<option value="Motivational Strategies Level 3 Increasing Knowledge 1054">'.__("Using Presentation Software","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 3 Increasing Knowledge 1054"] = 7;

$projects["Motivational Strategies Level 3 Increasing Knowledge 981"] = __("Understanding Emotional Intelligence","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 3 Increasing Knowledge"] .= '<option value="Motivational Strategies Level 3 Increasing Knowledge 981">'.__("Understanding Emotional Intelligence","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 3 Increasing Knowledge 981"] = 7;

$projects["Motivational Strategies Level 3 Increasing Knowledge 988"] = __("Connect with Storytelling","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 3 Increasing Knowledge"] .= '<option value="Motivational Strategies Level 3 Increasing Knowledge 988">'.__("Connect with Storytelling","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 3 Increasing Knowledge 988"] = 7;

$projects["Motivational Strategies Level 3 Increasing Knowledge 994"] = __("Connect with Your Audience","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 3 Increasing Knowledge"] .= '<option value="Motivational Strategies Level 3 Increasing Knowledge 994">'.__("Connect with Your Audience","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 3 Increasing Knowledge 994"] = 7;

$projects["Motivational Strategies Level 4 Building Skills 1063"] = __("Motivate Others","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 4 Building Skills"] = '<option value="Motivational Strategies Level 4 Building Skills 1063">'.__("Motivate Others","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 4 Building Skills 1063"] = 7;

$projects["Motivational Strategies Level 4 Building Skills 1070"] = __("Building a Social Media Presence","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 4 Building Skills"] .= '<option value="Motivational Strategies Level 4 Building Skills 1070">'.__("Building a Social Media Presence","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 4 Building Skills 1070"] = 7;

$projects["Motivational Strategies Level 4 Building Skills 1076"] = __("Create a Podcast (2-3 minute intro; 5-10 minute podcast)","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 4 Building Skills"] .= '<option value="Motivational Strategies Level 4 Building Skills 1076">'.__("Create a Podcast (2-3 minute intro; 5-10 minute podcast)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 4 Building Skills 1076"] = 13;

$projects["Motivational Strategies Level 4 Building Skills 1082"] = __("Manage Online Meetings (20 - 25 minutes)","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 4 Building Skills"] .= '<option value="Motivational Strategies Level 4 Building Skills 1082">'.__("Manage Online Meetings (20 - 25 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 4 Building Skills 1082"] = 25;

$projects["Motivational Strategies Level 4 Building Skills 1088"] = __("Manage Projects Successfully - First Speech (2 - 3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 4 Building Skills"] .= '<option value="Motivational Strategies Level 4 Building Skills 1088">'.__("Manage Projects Successfully - First Speech (2 - 3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 4 Building Skills 1088"] = 3;

$projects["Motivational Strategies Level 4 Building Skills 1089"] = __("Manage Projects Successfully - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 4 Building Skills"] .= '<option value="Motivational Strategies Level 4 Building Skills 1089">'.__("Manage Projects Successfully - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 4 Building Skills 1089"] = 7;

$projects["Motivational Strategies Level 4 Building Skills 1094"] = __("Managing a Difficult Audience (10 - 15 minutes)","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 4 Building Skills"] .= '<option value="Motivational Strategies Level 4 Building Skills 1094">'.__("Managing a Difficult Audience (10 - 15 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 4 Building Skills 1094"] = 15;

$projects["Motivational Strategies Level 4 Building Skills 1100"] = __("Public Relations Strategies","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 4 Building Skills"] .= '<option value="Motivational Strategies Level 4 Building Skills 1100">'.__("Public Relations Strategies","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 4 Building Skills 1100"] = 7;

$projects["Motivational Strategies Level 4 Building Skills 1106"] = __("Question-and-Answer Session (15 - 20 minutes)","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 4 Building Skills"] .= '<option value="Motivational Strategies Level 4 Building Skills 1106">'.__("Question-and-Answer Session (15 - 20 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 4 Building Skills 1106"] = 20;

$projects["Motivational Strategies Level 4 Building Skills 1112"] = __("Write a Compelling Blog (2 - 3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 4 Building Skills"] .= '<option value="Motivational Strategies Level 4 Building Skills 1112">'.__("Write a Compelling Blog (2 - 3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 4 Building Skills 1112"] = 3;

$projects["Motivational Strategies Level 5 Demonstrating Expertise 1121"] = __("Team Building","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 5 Demonstrating Expertise"] = '<option value="Motivational Strategies Level 5 Demonstrating Expertise 1121">'.__("Team Building","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 5 Demonstrating Expertise 1121"] = 7;

$projects["Motivational Strategies Level 5 Demonstrating Expertise 1128"] = __("Reflect on Your Path","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 5 Demonstrating Expertise"] .= '<option value="Motivational Strategies Level 5 Demonstrating Expertise 1128">'.__("Reflect on Your Path","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 5 Demonstrating Expertise 1128"] = 7;

$projects["Motivational Strategies Level 5 Demonstrating Expertise 1134"] = __("Ethical Leadership (20 - 40 minutes)","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 5 Demonstrating Expertise"] .= '<option value="Motivational Strategies Level 5 Demonstrating Expertise 1134">'.__("Ethical Leadership (20 - 40 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 5 Demonstrating Expertise 1134"] = 40;

$projects["Motivational Strategies Level 5 Demonstrating Expertise 1140"] = __("High Performance Leadership - First Speech","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 5 Demonstrating Expertise"] .= '<option value="Motivational Strategies Level 5 Demonstrating Expertise 1140">'.__("High Performance Leadership - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 5 Demonstrating Expertise 1140"] = 7;

$projects["Motivational Strategies Level 5 Demonstrating Expertise 1141"] = __("High Performance Leadership - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 5 Demonstrating Expertise"] .= '<option value="Motivational Strategies Level 5 Demonstrating Expertise 1141">'.__("High Performance Leadership - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 5 Demonstrating Expertise 1141"] = 7;

$projects["Motivational Strategies Level 5 Demonstrating Expertise 1146"] = __("Leading in Your Volunteer Organization","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 5 Demonstrating Expertise"] .= '<option value="Motivational Strategies Level 5 Demonstrating Expertise 1146">'.__("Leading in Your Volunteer Organization","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 5 Demonstrating Expertise 1146"] = 7;

$projects["Motivational Strategies Level 5 Demonstrating Expertise 1152"] = __("Lessons Learned","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 5 Demonstrating Expertise"] .= '<option value="Motivational Strategies Level 5 Demonstrating Expertise 1152">'.__("Lessons Learned","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 5 Demonstrating Expertise 1152"] = 7;

$projects["Motivational Strategies Level 5 Demonstrating Expertise 1158"] = __("Moderate a Panel Discussion (20 - 40 minutes)","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 5 Demonstrating Expertise"] .= '<option value="Motivational Strategies Level 5 Demonstrating Expertise 1158">'.__("Moderate a Panel Discussion (20 - 40 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 5 Demonstrating Expertise 1158"] = 40;

$projects["Motivational Strategies Level 5 Demonstrating Expertise 1164"] = __("Prepare to Speak Professionally (18 - 22 minutes)","rsvpmaker-for-toastmasters");
$project_options["Motivational Strategies Level 5 Demonstrating Expertise"] .= '<option value="Motivational Strategies Level 5 Demonstrating Expertise 1164">'.__("Prepare to Speak Professionally (18 - 22 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Motivational Strategies Level 5 Demonstrating Expertise 1164"] = 22;

$projects["Persuasive Influence Level 1 Mastering Fundamentals 1173"] = __("Ice Breaker (4 - 6 minutes)","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 1 Mastering Fundamentals"] = '<option value="Persuasive Influence Level 1 Mastering Fundamentals 1173">'.__("Ice Breaker (4 - 6 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 1 Mastering Fundamentals 1173"] = 6;

$projects["Persuasive Influence Level 1 Mastering Fundamentals 1180"] = __("Evaluation and Feedback - First Speech","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 1 Mastering Fundamentals"] .= '<option value="Persuasive Influence Level 1 Mastering Fundamentals 1180">'.__("Evaluation and Feedback - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 1 Mastering Fundamentals 1180"] = 7;

$projects["Persuasive Influence Level 1 Mastering Fundamentals 1181"] = __("Evaluation and Feedback - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 1 Mastering Fundamentals"] .= '<option value="Persuasive Influence Level 1 Mastering Fundamentals 1181">'.__("Evaluation and Feedback - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 1 Mastering Fundamentals 1181"] = 7;

$projects["Persuasive Influence Level 1 Mastering Fundamentals 1182"] = __("Evaluation and Feedback - Evaluator Speech (2-3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 1 Mastering Fundamentals"] .= '<option value="Persuasive Influence Level 1 Mastering Fundamentals 1182">'.__("Evaluation and Feedback - Evaluator Speech (2-3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 1 Mastering Fundamentals 1182"] = 3;

$projects["Persuasive Influence Level 1 Mastering Fundamentals 1186"] = __("Researching and Presenting","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 1 Mastering Fundamentals"] .= '<option value="Persuasive Influence Level 1 Mastering Fundamentals 1186">'.__("Researching and Presenting","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 1 Mastering Fundamentals 1186"] = 7;

$projects["Persuasive Influence Level 2 Learning Your Style 1195"] = __("Understanding Your Leadership Style","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 2 Learning Your Style"] = '<option value="Persuasive Influence Level 2 Learning Your Style 1195">'.__("Understanding Your Leadership Style","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 2 Learning Your Style 1195"] = 7;

$projects["Persuasive Influence Level 2 Learning Your Style 1202"] = __("Active Listening","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 2 Learning Your Style"] .= '<option value="Persuasive Influence Level 2 Learning Your Style 1202">'.__("Active Listening","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 2 Learning Your Style 1202"] = 7;

$projects["Persuasive Influence Level 2 Learning Your Style 1208"] = __("Mentoring","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 2 Learning Your Style"] .= '<option value="Persuasive Influence Level 2 Learning Your Style 1208">'.__("Mentoring","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 2 Learning Your Style 1208"] = 7;

$projects["Persuasive Influence Level 3 Increasing Knowledge 1217"] = __("Understanding Conflict Resolution","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 3 Increasing Knowledge"] = '<option value="Persuasive Influence Level 3 Increasing Knowledge 1217">'.__("Understanding Conflict Resolution","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 3 Increasing Knowledge 1217"] = 7;

$projects["Persuasive Influence Level 3 Increasing Knowledge 1224"] = __("Connect with Storytelling","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 3 Increasing Knowledge"] .= '<option value="Persuasive Influence Level 3 Increasing Knowledge 1224">'.__("Connect with Storytelling","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 3 Increasing Knowledge 1224"] = 7;

$projects["Persuasive Influence Level 3 Increasing Knowledge 1230"] = __("Connect with Your Audience","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 3 Increasing Knowledge"] .= '<option value="Persuasive Influence Level 3 Increasing Knowledge 1230">'.__("Connect with Your Audience","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 3 Increasing Knowledge 1230"] = 7;

$projects["Persuasive Influence Level 3 Increasing Knowledge 1236"] = __("Creating Effective Visual Aids","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 3 Increasing Knowledge"] .= '<option value="Persuasive Influence Level 3 Increasing Knowledge 1236">'.__("Creating Effective Visual Aids","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 3 Increasing Knowledge 1236"] = 7;

$projects["Persuasive Influence Level 3 Increasing Knowledge 1242"] = __("Deliver Social Speeches - First Speech","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 3 Increasing Knowledge"] .= '<option value="Persuasive Influence Level 3 Increasing Knowledge 1242">'.__("Deliver Social Speeches - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 3 Increasing Knowledge 1242"] = 7;

$projects["Persuasive Influence Level 3 Increasing Knowledge 1248"] = __("Effective Body Language","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 3 Increasing Knowledge"] .= '<option value="Persuasive Influence Level 3 Increasing Knowledge 1248">'.__("Effective Body Language","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 3 Increasing Knowledge 1248"] = 7;

$projects["Persuasive Influence Level 3 Increasing Knowledge 1254"] = __("Focus on the Positive","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 3 Increasing Knowledge"] .= '<option value="Persuasive Influence Level 3 Increasing Knowledge 1254">'.__("Focus on the Positive","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 3 Increasing Knowledge 1254"] = 7;

$projects["Persuasive Influence Level 3 Increasing Knowledge 1260"] = __("Inspire Your Audience","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 3 Increasing Knowledge"] .= '<option value="Persuasive Influence Level 3 Increasing Knowledge 1260">'.__("Inspire Your Audience","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 3 Increasing Knowledge 1260"] = 7;

$projects["Persuasive Influence Level 3 Increasing Knowledge 1266"] = __("Make Connections Through Networking","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 3 Increasing Knowledge"] .= '<option value="Persuasive Influence Level 3 Increasing Knowledge 1266">'.__("Make Connections Through Networking","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 3 Increasing Knowledge 1266"] = 7;

$projects["Persuasive Influence Level 3 Increasing Knowledge 1272"] = __("Prepare for an Interview","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 3 Increasing Knowledge"] .= '<option value="Persuasive Influence Level 3 Increasing Knowledge 1272">'.__("Prepare for an Interview","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 3 Increasing Knowledge 1272"] = 7;

$projects["Persuasive Influence Level 3 Increasing Knowledge 1278"] = __("Understanding Vocal Variety","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 3 Increasing Knowledge"] .= '<option value="Persuasive Influence Level 3 Increasing Knowledge 1278">'.__("Understanding Vocal Variety","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 3 Increasing Knowledge 1278"] = 7;

$projects["Persuasive Influence Level 3 Increasing Knowledge 1284"] = __("Using Descriptive Language","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 3 Increasing Knowledge"] .= '<option value="Persuasive Influence Level 3 Increasing Knowledge 1284">'.__("Using Descriptive Language","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 3 Increasing Knowledge 1284"] = 7;

$projects["Persuasive Influence Level 3 Increasing Knowledge 1290"] = __("Using Presentation Software","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 3 Increasing Knowledge"] .= '<option value="Persuasive Influence Level 3 Increasing Knowledge 1290">'.__("Using Presentation Software","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 3 Increasing Knowledge 1290"] = 7;

$projects["Persuasive Influence Level 4 Building Skills 1299"] = __("Building a Social Media Presence","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 4 Building Skills"] = '<option value="Persuasive Influence Level 4 Building Skills 1299">'.__("Building a Social Media Presence","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 4 Building Skills 1299"] = 7;

$projects["Persuasive Influence Level 4 Building Skills 1306"] = __("Leading in Difficult Situations (5- to 7-minute prepared speech AND 5 to 10 minutes for impromptu responses)","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 4 Building Skills"] .= '<option value="Persuasive Influence Level 4 Building Skills 1306">'.__("Leading in Difficult Situations (5- to 7-minute prepared speech AND 5 to 10 minutes for impromptu responses)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 4 Building Skills 1306"] = 17;

$projects["Persuasive Influence Level 4 Building Skills 1312"] = __("Create a Podcast (2-3 minute intro; 5-10 minute podcast)","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 4 Building Skills"] .= '<option value="Persuasive Influence Level 4 Building Skills 1312">'.__("Create a Podcast (2-3 minute intro; 5-10 minute podcast)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 4 Building Skills 1312"] = 13;

$projects["Persuasive Influence Level 4 Building Skills 1318"] = __("Manage Online Meetings (20 - 25 minutes)","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 4 Building Skills"] .= '<option value="Persuasive Influence Level 4 Building Skills 1318">'.__("Manage Online Meetings (20 - 25 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 4 Building Skills 1318"] = 25;

$projects["Persuasive Influence Level 4 Building Skills 1324"] = __("Manage Projects Successfully - First Speech (2 - 3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 4 Building Skills"] .= '<option value="Persuasive Influence Level 4 Building Skills 1324">'.__("Manage Projects Successfully - First Speech (2 - 3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 4 Building Skills 1324"] = 3;

$projects["Persuasive Influence Level 4 Building Skills 1325"] = __("Manage Projects Successfully - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 4 Building Skills"] .= '<option value="Persuasive Influence Level 4 Building Skills 1325">'.__("Manage Projects Successfully - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 4 Building Skills 1325"] = 7;

$projects["Persuasive Influence Level 4 Building Skills 1330"] = __("Managing a Difficult Audience (10 - 15 minutes)","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 4 Building Skills"] .= '<option value="Persuasive Influence Level 4 Building Skills 1330">'.__("Managing a Difficult Audience (10 - 15 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 4 Building Skills 1330"] = 15;

$projects["Persuasive Influence Level 4 Building Skills 1336"] = __("Public Relations Strategies","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 4 Building Skills"] .= '<option value="Persuasive Influence Level 4 Building Skills 1336">'.__("Public Relations Strategies","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 4 Building Skills 1336"] = 7;

$projects["Persuasive Influence Level 4 Building Skills 1342"] = __("Question-and-Answer Session (15 - 20 minutes)","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 4 Building Skills"] .= '<option value="Persuasive Influence Level 4 Building Skills 1342">'.__("Question-and-Answer Session (15 - 20 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 4 Building Skills 1342"] = 20;

$projects["Persuasive Influence Level 4 Building Skills 1348"] = __("Write a Compelling Blog (2 - 3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 4 Building Skills"] .= '<option value="Persuasive Influence Level 4 Building Skills 1348">'.__("Write a Compelling Blog (2 - 3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 4 Building Skills 1348"] = 3;

$projects["Persuasive Influence Level 5 Demonstrating Expertise 1357"] = __("High Performance Leadership - First Speech","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 5 Demonstrating Expertise"] = '<option value="Persuasive Influence Level 5 Demonstrating Expertise 1357">'.__("High Performance Leadership - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 5 Demonstrating Expertise 1357"] = 7;

$projects["Persuasive Influence Level 5 Demonstrating Expertise 1358"] = __("High Performance Leadership - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 5 Demonstrating Expertise"] .= '<option value="Persuasive Influence Level 5 Demonstrating Expertise 1358">'.__("High Performance Leadership - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 5 Demonstrating Expertise 1358"] = 7;

$projects["Persuasive Influence Level 5 Demonstrating Expertise 1364"] = __("Reflect on Your Path","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 5 Demonstrating Expertise"] .= '<option value="Persuasive Influence Level 5 Demonstrating Expertise 1364">'.__("Reflect on Your Path","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 5 Demonstrating Expertise 1364"] = 7;

$projects["Persuasive Influence Level 5 Demonstrating Expertise 1370"] = __("Ethical Leadership (20 - 40 minutes)","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 5 Demonstrating Expertise"] .= '<option value="Persuasive Influence Level 5 Demonstrating Expertise 1370">'.__("Ethical Leadership (20 - 40 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 5 Demonstrating Expertise 1370"] = 40;

$projects["Persuasive Influence Level 5 Demonstrating Expertise 1376"] = __("Leading in Your Volunteer Organization","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 5 Demonstrating Expertise"] .= '<option value="Persuasive Influence Level 5 Demonstrating Expertise 1376">'.__("Leading in Your Volunteer Organization","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 5 Demonstrating Expertise 1376"] = 7;

$projects["Persuasive Influence Level 5 Demonstrating Expertise 1382"] = __("Lessons Learned","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 5 Demonstrating Expertise"] .= '<option value="Persuasive Influence Level 5 Demonstrating Expertise 1382">'.__("Lessons Learned","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 5 Demonstrating Expertise 1382"] = 7;

$projects["Persuasive Influence Level 5 Demonstrating Expertise 1388"] = __("Moderate a Panel Discussion (20 - 40 minutes)","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 5 Demonstrating Expertise"] .= '<option value="Persuasive Influence Level 5 Demonstrating Expertise 1388">'.__("Moderate a Panel Discussion (20 - 40 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 5 Demonstrating Expertise 1388"] = 40;

$projects["Persuasive Influence Level 5 Demonstrating Expertise 1394"] = __("Prepare to Speak Professionally (18 - 22 minutes)","rsvpmaker-for-toastmasters");
$project_options["Persuasive Influence Level 5 Demonstrating Expertise"] .= '<option value="Persuasive Influence Level 5 Demonstrating Expertise 1394">'.__("Prepare to Speak Professionally (18 - 22 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Persuasive Influence Level 5 Demonstrating Expertise 1394"] = 22;

$projects["Presentation Mastery Level 1 Mastering Fundamentals 1404"] = __("Ice Breaker (4 - 6 minutes)","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 1 Mastering Fundamentals"] = '<option value="Presentation Mastery Level 1 Mastering Fundamentals 1404">'.__("Ice Breaker (4 - 6 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 1 Mastering Fundamentals 1404"] = 6;

$projects["Presentation Mastery Level 1 Mastering Fundamentals 1411"] = __("Evaluation and Feedback - First Speech","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 1 Mastering Fundamentals"] .= '<option value="Presentation Mastery Level 1 Mastering Fundamentals 1411">'.__("Evaluation and Feedback - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 1 Mastering Fundamentals 1411"] = 7;

$projects["Presentation Mastery Level 1 Mastering Fundamentals 1412"] = __("Evaluation and Feedback - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 1 Mastering Fundamentals"] .= '<option value="Presentation Mastery Level 1 Mastering Fundamentals 1412">'.__("Evaluation and Feedback - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 1 Mastering Fundamentals 1412"] = 7;

$projects["Presentation Mastery Level 1 Mastering Fundamentals 1413"] = __("Evaluation and Feedback - Evaluator Speech (2-3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 1 Mastering Fundamentals"] .= '<option value="Presentation Mastery Level 1 Mastering Fundamentals 1413">'.__("Evaluation and Feedback - Evaluator Speech (2-3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 1 Mastering Fundamentals 1413"] = 3;

$projects["Presentation Mastery Level 1 Mastering Fundamentals 1417"] = __("Researching and Presenting","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 1 Mastering Fundamentals"] .= '<option value="Presentation Mastery Level 1 Mastering Fundamentals 1417">'.__("Researching and Presenting","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 1 Mastering Fundamentals 1417"] = 7;

$projects["Presentation Mastery Level 2 Learning Your Style 1426"] = __("Understanding Your Communication Style","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 2 Learning Your Style"] = '<option value="Presentation Mastery Level 2 Learning Your Style 1426">'.__("Understanding Your Communication Style","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 2 Learning Your Style 1426"] = 7;

$projects["Presentation Mastery Level 2 Learning Your Style 1433"] = __("Effective Body Language","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 2 Learning Your Style"] .= '<option value="Presentation Mastery Level 2 Learning Your Style 1433">'.__("Effective Body Language","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 2 Learning Your Style 1433"] = 7;

$projects["Presentation Mastery Level 2 Learning Your Style 1439"] = __("Mentoring","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 2 Learning Your Style"] .= '<option value="Presentation Mastery Level 2 Learning Your Style 1439">'.__("Mentoring","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 2 Learning Your Style 1439"] = 7;

$projects["Presentation Mastery Level 3 Increasing Knowledge 1448"] = __("Persuasive Speaking","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 3 Increasing Knowledge"] = '<option value="Presentation Mastery Level 3 Increasing Knowledge 1448">'.__("Persuasive Speaking","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 3 Increasing Knowledge 1448"] = 7;

$projects["Presentation Mastery Level 3 Increasing Knowledge 1455"] = __("Active Listening","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 3 Increasing Knowledge"] .= '<option value="Presentation Mastery Level 3 Increasing Knowledge 1455">'.__("Active Listening","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 3 Increasing Knowledge 1455"] = 7;

$projects["Presentation Mastery Level 3 Increasing Knowledge 1461"] = __("Connect with Storytelling","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 3 Increasing Knowledge"] .= '<option value="Presentation Mastery Level 3 Increasing Knowledge 1461">'.__("Connect with Storytelling","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 3 Increasing Knowledge 1461"] = 7;

$projects["Presentation Mastery Level 3 Increasing Knowledge 1467"] = __("Connect with Your Audience","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 3 Increasing Knowledge"] .= '<option value="Presentation Mastery Level 3 Increasing Knowledge 1467">'.__("Connect with Your Audience","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 3 Increasing Knowledge 1467"] = 7;

$projects["Presentation Mastery Level 3 Increasing Knowledge 1473"] = __("Creating Effective Visual Aids","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 3 Increasing Knowledge"] .= '<option value="Presentation Mastery Level 3 Increasing Knowledge 1473">'.__("Creating Effective Visual Aids","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 3 Increasing Knowledge 1473"] = 7;

$projects["Presentation Mastery Level 3 Increasing Knowledge 1479"] = __("Deliver Social Speeches - First Speech","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 3 Increasing Knowledge"] .= '<option value="Presentation Mastery Level 3 Increasing Knowledge 1479">'.__("Deliver Social Speeches - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 3 Increasing Knowledge 1479"] = 7;

$projects["Presentation Mastery Level 3 Increasing Knowledge 1485"] = __("Focus on the Positive","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 3 Increasing Knowledge"] .= '<option value="Presentation Mastery Level 3 Increasing Knowledge 1485">'.__("Focus on the Positive","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 3 Increasing Knowledge 1485"] = 7;

$projects["Presentation Mastery Level 3 Increasing Knowledge 1491"] = __("Inspire Your Audience","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 3 Increasing Knowledge"] .= '<option value="Presentation Mastery Level 3 Increasing Knowledge 1491">'.__("Inspire Your Audience","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 3 Increasing Knowledge 1491"] = 7;

$projects["Presentation Mastery Level 3 Increasing Knowledge 1497"] = __("Make Connections Through Networking","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 3 Increasing Knowledge"] .= '<option value="Presentation Mastery Level 3 Increasing Knowledge 1497">'.__("Make Connections Through Networking","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 3 Increasing Knowledge 1497"] = 7;

$projects["Presentation Mastery Level 3 Increasing Knowledge 1503"] = __("Prepare for an Interview","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 3 Increasing Knowledge"] .= '<option value="Presentation Mastery Level 3 Increasing Knowledge 1503">'.__("Prepare for an Interview","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 3 Increasing Knowledge 1503"] = 7;

$projects["Presentation Mastery Level 3 Increasing Knowledge 1509"] = __("Understanding Vocal Variety","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 3 Increasing Knowledge"] .= '<option value="Presentation Mastery Level 3 Increasing Knowledge 1509">'.__("Understanding Vocal Variety","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 3 Increasing Knowledge 1509"] = 7;

$projects["Presentation Mastery Level 3 Increasing Knowledge 1515"] = __("Using Descriptive Language","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 3 Increasing Knowledge"] .= '<option value="Presentation Mastery Level 3 Increasing Knowledge 1515">'.__("Using Descriptive Language","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 3 Increasing Knowledge 1515"] = 7;

$projects["Presentation Mastery Level 3 Increasing Knowledge 1521"] = __("Using Presentation Software","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 3 Increasing Knowledge"] .= '<option value="Presentation Mastery Level 3 Increasing Knowledge 1521">'.__("Using Presentation Software","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 3 Increasing Knowledge 1521"] = 7;

$projects["Presentation Mastery Level 4 Building Skills 1530"] = __("Managing a Difficult Audience (10 - 15 minutes)","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 4 Building Skills"] = '<option value="Presentation Mastery Level 4 Building Skills 1530">'.__("Managing a Difficult Audience (10 - 15 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 4 Building Skills 1530"] = 15;

$projects["Presentation Mastery Level 4 Building Skills 1537"] = __("Building a Social Media Presence","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 4 Building Skills"] .= '<option value="Presentation Mastery Level 4 Building Skills 1537">'.__("Building a Social Media Presence","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 4 Building Skills 1537"] = 7;

$projects["Presentation Mastery Level 4 Building Skills 1543"] = __("Create a Podcast (2-3 minute intro; 5-10 minute podcast)","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 4 Building Skills"] .= '<option value="Presentation Mastery Level 4 Building Skills 1543">'.__("Create a Podcast (2-3 minute intro; 5-10 minute podcast)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 4 Building Skills 1543"] = 13;

$projects["Presentation Mastery Level 4 Building Skills 1549"] = __("Manage Online Meetings (20 - 25 minutes)","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 4 Building Skills"] .= '<option value="Presentation Mastery Level 4 Building Skills 1549">'.__("Manage Online Meetings (20 - 25 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 4 Building Skills 1549"] = 25;

$projects["Presentation Mastery Level 4 Building Skills 1555"] = __("Manage Projects Successfully - First Speech (2 - 3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 4 Building Skills"] .= '<option value="Presentation Mastery Level 4 Building Skills 1555">'.__("Manage Projects Successfully - First Speech (2 - 3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 4 Building Skills 1555"] = 3;

$projects["Presentation Mastery Level 4 Building Skills 1556"] = __("Manage Projects Successfully - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 4 Building Skills"] .= '<option value="Presentation Mastery Level 4 Building Skills 1556">'.__("Manage Projects Successfully - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 4 Building Skills 1556"] = 7;

$projects["Presentation Mastery Level 4 Building Skills 1561"] = __("Public Relations Strategies","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 4 Building Skills"] .= '<option value="Presentation Mastery Level 4 Building Skills 1561">'.__("Public Relations Strategies","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 4 Building Skills 1561"] = 7;

$projects["Presentation Mastery Level 4 Building Skills 1567"] = __("Question-and-Answer Session (15 - 20 minutes)","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 4 Building Skills"] .= '<option value="Presentation Mastery Level 4 Building Skills 1567">'.__("Question-and-Answer Session (15 - 20 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 4 Building Skills 1567"] = 20;

$projects["Presentation Mastery Level 4 Building Skills 1573"] = __("Write a Compelling Blog (2 - 3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 4 Building Skills"] .= '<option value="Presentation Mastery Level 4 Building Skills 1573">'.__("Write a Compelling Blog (2 - 3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 4 Building Skills 1573"] = 3;

$projects["Presentation Mastery Level 5 Demonstrating Expertise 1582"] = __("Prepare to Speak Professionally (18 - 22 minutes)","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 5 Demonstrating Expertise"] = '<option value="Presentation Mastery Level 5 Demonstrating Expertise 1582">'.__("Prepare to Speak Professionally (18 - 22 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 5 Demonstrating Expertise 1582"] = 22;

$projects["Presentation Mastery Level 5 Demonstrating Expertise 1589"] = __("Reflect on Your Path","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 5 Demonstrating Expertise"] .= '<option value="Presentation Mastery Level 5 Demonstrating Expertise 1589">'.__("Reflect on Your Path","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 5 Demonstrating Expertise 1589"] = 7;

$projects["Presentation Mastery Level 5 Demonstrating Expertise 1595"] = __("Ethical Leadership (20 - 40 minutes)","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 5 Demonstrating Expertise"] .= '<option value="Presentation Mastery Level 5 Demonstrating Expertise 1595">'.__("Ethical Leadership (20 - 40 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 5 Demonstrating Expertise 1595"] = 40;

$projects["Presentation Mastery Level 5 Demonstrating Expertise 1601"] = __("High Performance Leadership - First Speech","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 5 Demonstrating Expertise"] .= '<option value="Presentation Mastery Level 5 Demonstrating Expertise 1601">'.__("High Performance Leadership - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 5 Demonstrating Expertise 1601"] = 7;

$projects["Presentation Mastery Level 5 Demonstrating Expertise 1602"] = __("High Performance Leadership - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 5 Demonstrating Expertise"] .= '<option value="Presentation Mastery Level 5 Demonstrating Expertise 1602">'.__("High Performance Leadership - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 5 Demonstrating Expertise 1602"] = 7;

$projects["Presentation Mastery Level 5 Demonstrating Expertise 1607"] = __("Leading in Your Volunteer Organization","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 5 Demonstrating Expertise"] .= '<option value="Presentation Mastery Level 5 Demonstrating Expertise 1607">'.__("Leading in Your Volunteer Organization","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 5 Demonstrating Expertise 1607"] = 7;

$projects["Presentation Mastery Level 5 Demonstrating Expertise 1613"] = __("Lessons Learned","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 5 Demonstrating Expertise"] .= '<option value="Presentation Mastery Level 5 Demonstrating Expertise 1613">'.__("Lessons Learned","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 5 Demonstrating Expertise 1613"] = 7;

$projects["Presentation Mastery Level 5 Demonstrating Expertise 1619"] = __("Moderate a Panel Discussion (20 - 40 minutes)","rsvpmaker-for-toastmasters");
$project_options["Presentation Mastery Level 5 Demonstrating Expertise"] .= '<option value="Presentation Mastery Level 5 Demonstrating Expertise 1619">'.__("Moderate a Panel Discussion (20 - 40 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Presentation Mastery Level 5 Demonstrating Expertise 1619"] = 40;

$projects["Strategic Relationships Level 1 Mastering Fundamentals 1628"] = __("Ice Breaker (4 - 6 minutes)","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 1 Mastering Fundamentals"] = '<option value="Strategic Relationships Level 1 Mastering Fundamentals 1628">'.__("Ice Breaker (4 - 6 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 1 Mastering Fundamentals 1628"] = 6;

$projects["Strategic Relationships Level 1 Mastering Fundamentals 1635"] = __("Evaluation and Feedback - First Speech","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 1 Mastering Fundamentals"] .= '<option value="Strategic Relationships Level 1 Mastering Fundamentals 1635">'.__("Evaluation and Feedback - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 1 Mastering Fundamentals 1635"] = 7;

$projects["Strategic Relationships Level 1 Mastering Fundamentals 1636"] = __("Evaluation and Feedback - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 1 Mastering Fundamentals"] .= '<option value="Strategic Relationships Level 1 Mastering Fundamentals 1636">'.__("Evaluation and Feedback - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 1 Mastering Fundamentals 1636"] = 7;

$projects["Strategic Relationships Level 1 Mastering Fundamentals 1637"] = __("Evaluation and Feedback - Evaluator Speech (2-3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 1 Mastering Fundamentals"] .= '<option value="Strategic Relationships Level 1 Mastering Fundamentals 1637">'.__("Evaluation and Feedback - Evaluator Speech (2-3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 1 Mastering Fundamentals 1637"] = 3;

$projects["Strategic Relationships Level 1 Mastering Fundamentals 1641"] = __("Researching and Presenting","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 1 Mastering Fundamentals"] .= '<option value="Strategic Relationships Level 1 Mastering Fundamentals 1641">'.__("Researching and Presenting","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 1 Mastering Fundamentals 1641"] = 7;

$projects["Strategic Relationships Level 2 Learning Your Style 1650"] = __("Understanding Your Leadership Style","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 2 Learning Your Style"] = '<option value="Strategic Relationships Level 2 Learning Your Style 1650">'.__("Understanding Your Leadership Style","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 2 Learning Your Style 1650"] = 7;

$projects["Strategic Relationships Level 2 Learning Your Style 1657"] = __("Cross-Cultural Understanding","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 2 Learning Your Style"] .= '<option value="Strategic Relationships Level 2 Learning Your Style 1657">'.__("Cross-Cultural Understanding","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 2 Learning Your Style 1657"] = 7;

$projects["Strategic Relationships Level 2 Learning Your Style 1663"] = __("Mentoring","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 2 Learning Your Style"] .= '<option value="Strategic Relationships Level 2 Learning Your Style 1663">'.__("Mentoring","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 2 Learning Your Style 1663"] = 7;

$projects["Strategic Relationships Level 3 Increasing Knowledge 1672"] = __("Make Connections Through Networking","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 3 Increasing Knowledge"] = '<option value="Strategic Relationships Level 3 Increasing Knowledge 1672">'.__("Make Connections Through Networking","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 3 Increasing Knowledge 1672"] = 7;

$projects["Strategic Relationships Level 3 Increasing Knowledge 1679"] = __("Active Listening","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 3 Increasing Knowledge"] .= '<option value="Strategic Relationships Level 3 Increasing Knowledge 1679">'.__("Active Listening","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 3 Increasing Knowledge 1679"] = 7;

$projects["Strategic Relationships Level 3 Increasing Knowledge 1685"] = __("Connect with Storytelling","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 3 Increasing Knowledge"] .= '<option value="Strategic Relationships Level 3 Increasing Knowledge 1685">'.__("Connect with Storytelling","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 3 Increasing Knowledge 1685"] = 7;

$projects["Strategic Relationships Level 3 Increasing Knowledge 1691"] = __("Connect with Your Audience","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 3 Increasing Knowledge"] .= '<option value="Strategic Relationships Level 3 Increasing Knowledge 1691">'.__("Connect with Your Audience","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 3 Increasing Knowledge 1691"] = 7;

$projects["Strategic Relationships Level 3 Increasing Knowledge 1697"] = __("Creating Effective Visual Aids","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 3 Increasing Knowledge"] .= '<option value="Strategic Relationships Level 3 Increasing Knowledge 1697">'.__("Creating Effective Visual Aids","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 3 Increasing Knowledge 1697"] = 7;

$projects["Strategic Relationships Level 3 Increasing Knowledge 1703"] = __("Deliver Social Speeches - First Speech","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 3 Increasing Knowledge"] .= '<option value="Strategic Relationships Level 3 Increasing Knowledge 1703">'.__("Deliver Social Speeches - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 3 Increasing Knowledge 1703"] = 7;

$projects["Strategic Relationships Level 3 Increasing Knowledge 1709"] = __("Effective Body Language","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 3 Increasing Knowledge"] .= '<option value="Strategic Relationships Level 3 Increasing Knowledge 1709">'.__("Effective Body Language","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 3 Increasing Knowledge 1709"] = 7;

$projects["Strategic Relationships Level 3 Increasing Knowledge 1715"] = __("Focus on the Positive","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 3 Increasing Knowledge"] .= '<option value="Strategic Relationships Level 3 Increasing Knowledge 1715">'.__("Focus on the Positive","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 3 Increasing Knowledge 1715"] = 7;

$projects["Strategic Relationships Level 3 Increasing Knowledge 1721"] = __("Inspire Your Audience","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 3 Increasing Knowledge"] .= '<option value="Strategic Relationships Level 3 Increasing Knowledge 1721">'.__("Inspire Your Audience","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 3 Increasing Knowledge 1721"] = 7;

$projects["Strategic Relationships Level 3 Increasing Knowledge 1727"] = __("Prepare for an Interview","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 3 Increasing Knowledge"] .= '<option value="Strategic Relationships Level 3 Increasing Knowledge 1727">'.__("Prepare for an Interview","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 3 Increasing Knowledge 1727"] = 7;

$projects["Strategic Relationships Level 3 Increasing Knowledge 1733"] = __("Understanding Vocal Variety","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 3 Increasing Knowledge"] .= '<option value="Strategic Relationships Level 3 Increasing Knowledge 1733">'.__("Understanding Vocal Variety","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 3 Increasing Knowledge 1733"] = 7;

$projects["Strategic Relationships Level 3 Increasing Knowledge 1739"] = __("Using Descriptive Language","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 3 Increasing Knowledge"] .= '<option value="Strategic Relationships Level 3 Increasing Knowledge 1739">'.__("Using Descriptive Language","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 3 Increasing Knowledge 1739"] = 7;

$projects["Strategic Relationships Level 3 Increasing Knowledge 1745"] = __("Using Presentation Software","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 3 Increasing Knowledge"] .= '<option value="Strategic Relationships Level 3 Increasing Knowledge 1745">'.__("Using Presentation Software","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 3 Increasing Knowledge 1745"] = 7;

$projects["Strategic Relationships Level 4 Building Skills 1754"] = __("Public Relations Strategies","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 4 Building Skills"] = '<option value="Strategic Relationships Level 4 Building Skills 1754">'.__("Public Relations Strategies","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 4 Building Skills 1754"] = 7;

$projects["Strategic Relationships Level 4 Building Skills 1761"] = __("Building a Social Media Presence","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 4 Building Skills"] .= '<option value="Strategic Relationships Level 4 Building Skills 1761">'.__("Building a Social Media Presence","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 4 Building Skills 1761"] = 7;

$projects["Strategic Relationships Level 4 Building Skills 1767"] = __("Create a Podcast (2-3 minute intro; 5-10 minute podcast)","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 4 Building Skills"] .= '<option value="Strategic Relationships Level 4 Building Skills 1767">'.__("Create a Podcast (2-3 minute intro; 5-10 minute podcast)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 4 Building Skills 1767"] = 13;

$projects["Strategic Relationships Level 4 Building Skills 1773"] = __("Manage Online Meetings (20 - 25 minutes)","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 4 Building Skills"] .= '<option value="Strategic Relationships Level 4 Building Skills 1773">'.__("Manage Online Meetings (20 - 25 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 4 Building Skills 1773"] = 25;

$projects["Strategic Relationships Level 4 Building Skills 1779"] = __("Manage Projects Successfully - First Speech (2 - 3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 4 Building Skills"] .= '<option value="Strategic Relationships Level 4 Building Skills 1779">'.__("Manage Projects Successfully - First Speech (2 - 3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 4 Building Skills 1779"] = 3;

$projects["Strategic Relationships Level 4 Building Skills 1780"] = __("Manage Projects Successfully - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 4 Building Skills"] .= '<option value="Strategic Relationships Level 4 Building Skills 1780">'.__("Manage Projects Successfully - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 4 Building Skills 1780"] = 7;

$projects["Strategic Relationships Level 4 Building Skills 1785"] = __("Managing a Difficult Audience (10 - 15 minutes)","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 4 Building Skills"] .= '<option value="Strategic Relationships Level 4 Building Skills 1785">'.__("Managing a Difficult Audience (10 - 15 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 4 Building Skills 1785"] = 15;

$projects["Strategic Relationships Level 4 Building Skills 1791"] = __("Question-and-Answer Session (15 - 20 minutes)","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 4 Building Skills"] .= '<option value="Strategic Relationships Level 4 Building Skills 1791">'.__("Question-and-Answer Session (15 - 20 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 4 Building Skills 1791"] = 20;

$projects["Strategic Relationships Level 4 Building Skills 1797"] = __("Write a Compelling Blog (2 - 3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 4 Building Skills"] .= '<option value="Strategic Relationships Level 4 Building Skills 1797">'.__("Write a Compelling Blog (2 - 3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 4 Building Skills 1797"] = 3;

$projects["Strategic Relationships Level 5 Demonstrating Expertise 1806"] = __("Leading in Your Volunteer Organization","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 5 Demonstrating Expertise"] = '<option value="Strategic Relationships Level 5 Demonstrating Expertise 1806">'.__("Leading in Your Volunteer Organization","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 5 Demonstrating Expertise 1806"] = 7;

$projects["Strategic Relationships Level 5 Demonstrating Expertise 1813"] = __("Reflect on Your Path","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 5 Demonstrating Expertise"] .= '<option value="Strategic Relationships Level 5 Demonstrating Expertise 1813">'.__("Reflect on Your Path","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 5 Demonstrating Expertise 1813"] = 7;

$projects["Strategic Relationships Level 5 Demonstrating Expertise 1819"] = __("Ethical Leadership (20 - 40 minutes)","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 5 Demonstrating Expertise"] .= '<option value="Strategic Relationships Level 5 Demonstrating Expertise 1819">'.__("Ethical Leadership (20 - 40 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 5 Demonstrating Expertise 1819"] = 40;

$projects["Strategic Relationships Level 5 Demonstrating Expertise 1825"] = __("High Performance Leadership - First Speech","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 5 Demonstrating Expertise"] .= '<option value="Strategic Relationships Level 5 Demonstrating Expertise 1825">'.__("High Performance Leadership - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 5 Demonstrating Expertise 1825"] = 7;

$projects["Strategic Relationships Level 5 Demonstrating Expertise 1826"] = __("High Performance Leadership - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 5 Demonstrating Expertise"] .= '<option value="Strategic Relationships Level 5 Demonstrating Expertise 1826">'.__("High Performance Leadership - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 5 Demonstrating Expertise 1826"] = 7;

$projects["Strategic Relationships Level 5 Demonstrating Expertise 1831"] = __("Lessons Learned","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 5 Demonstrating Expertise"] .= '<option value="Strategic Relationships Level 5 Demonstrating Expertise 1831">'.__("Lessons Learned","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 5 Demonstrating Expertise 1831"] = 7;

$projects["Strategic Relationships Level 5 Demonstrating Expertise 1837"] = __("Moderate a Panel Discussion (20 - 40 minutes)","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 5 Demonstrating Expertise"] .= '<option value="Strategic Relationships Level 5 Demonstrating Expertise 1837">'.__("Moderate a Panel Discussion (20 - 40 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 5 Demonstrating Expertise 1837"] = 40;

$projects["Strategic Relationships Level 5 Demonstrating Expertise 1843"] = __("Prepare to Speak Professionally (18 - 22 minutes)","rsvpmaker-for-toastmasters");
$project_options["Strategic Relationships Level 5 Demonstrating Expertise"] .= '<option value="Strategic Relationships Level 5 Demonstrating Expertise 1843">'.__("Prepare to Speak Professionally (18 - 22 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Strategic Relationships Level 5 Demonstrating Expertise 1843"] = 22;

$projects["Team Collaboration Level 1 Mastering Fundamentals 1852"] = __("Ice Breaker (4 - 6 minutes)","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 1 Mastering Fundamentals"] = '<option value="Team Collaboration Level 1 Mastering Fundamentals 1852">'.__("Ice Breaker (4 - 6 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 1 Mastering Fundamentals 1852"] = 6;

$projects["Team Collaboration Level 1 Mastering Fundamentals 1859"] = __("Evaluation and Feedback - First Speech","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 1 Mastering Fundamentals"] .= '<option value="Team Collaboration Level 1 Mastering Fundamentals 1859">'.__("Evaluation and Feedback - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 1 Mastering Fundamentals 1859"] = 7;

$projects["Team Collaboration Level 1 Mastering Fundamentals 1860"] = __("Evaluation and Feedback - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 1 Mastering Fundamentals"] .= '<option value="Team Collaboration Level 1 Mastering Fundamentals 1860">'.__("Evaluation and Feedback - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 1 Mastering Fundamentals 1860"] = 7;

$projects["Team Collaboration Level 1 Mastering Fundamentals 1861"] = __("Evaluation and Feedback - Evaluator Speech (2-3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 1 Mastering Fundamentals"] .= '<option value="Team Collaboration Level 1 Mastering Fundamentals 1861">'.__("Evaluation and Feedback - Evaluator Speech (2-3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 1 Mastering Fundamentals 1861"] = 3;

$projects["Team Collaboration Level 1 Mastering Fundamentals 1865"] = __("Researching and Presenting","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 1 Mastering Fundamentals"] .= '<option value="Team Collaboration Level 1 Mastering Fundamentals 1865">'.__("Researching and Presenting","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 1 Mastering Fundamentals 1865"] = 7;

$projects["Team Collaboration Level 2 Learning Your Style 1874"] = __("Understanding Your Leadership Style","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 2 Learning Your Style"] = '<option value="Team Collaboration Level 2 Learning Your Style 1874">'.__("Understanding Your Leadership Style","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 2 Learning Your Style 1874"] = 7;

$projects["Team Collaboration Level 2 Learning Your Style 1881"] = __("Active Listening","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 2 Learning Your Style"] .= '<option value="Team Collaboration Level 2 Learning Your Style 1881">'.__("Active Listening","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 2 Learning Your Style 1881"] = 7;

$projects["Team Collaboration Level 2 Learning Your Style 1887"] = __("Mentoring","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 2 Learning Your Style"] .= '<option value="Team Collaboration Level 2 Learning Your Style 1887">'.__("Mentoring","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 2 Learning Your Style 1887"] = 7;

$projects["Team Collaboration Level 3 Increasing Knowledge 1896"] = __("Successful Collaboration","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 3 Increasing Knowledge"] = '<option value="Team Collaboration Level 3 Increasing Knowledge 1896">'.__("Successful Collaboration","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 3 Increasing Knowledge 1896"] = 7;

$projects["Team Collaboration Level 3 Increasing Knowledge 1903"] = __("Connect with Storytelling","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 3 Increasing Knowledge"] .= '<option value="Team Collaboration Level 3 Increasing Knowledge 1903">'.__("Connect with Storytelling","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 3 Increasing Knowledge 1903"] = 7;

$projects["Team Collaboration Level 3 Increasing Knowledge 1909"] = __("Connect with Your Audience","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 3 Increasing Knowledge"] .= '<option value="Team Collaboration Level 3 Increasing Knowledge 1909">'.__("Connect with Your Audience","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 3 Increasing Knowledge 1909"] = 7;

$projects["Team Collaboration Level 3 Increasing Knowledge 1915"] = __("Creating Effective Visual Aids","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 3 Increasing Knowledge"] .= '<option value="Team Collaboration Level 3 Increasing Knowledge 1915">'.__("Creating Effective Visual Aids","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 3 Increasing Knowledge 1915"] = 7;

$projects["Team Collaboration Level 3 Increasing Knowledge 1921"] = __("Deliver Social Speeches - First Speech","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 3 Increasing Knowledge"] .= '<option value="Team Collaboration Level 3 Increasing Knowledge 1921">'.__("Deliver Social Speeches - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 3 Increasing Knowledge 1921"] = 7;

$projects["Team Collaboration Level 3 Increasing Knowledge 1927"] = __("Effective Body Language","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 3 Increasing Knowledge"] .= '<option value="Team Collaboration Level 3 Increasing Knowledge 1927">'.__("Effective Body Language","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 3 Increasing Knowledge 1927"] = 7;

$projects["Team Collaboration Level 3 Increasing Knowledge 1933"] = __("Focus on the Positive","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 3 Increasing Knowledge"] .= '<option value="Team Collaboration Level 3 Increasing Knowledge 1933">'.__("Focus on the Positive","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 3 Increasing Knowledge 1933"] = 7;

$projects["Team Collaboration Level 3 Increasing Knowledge 1939"] = __("Inspire Your Audience","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 3 Increasing Knowledge"] .= '<option value="Team Collaboration Level 3 Increasing Knowledge 1939">'.__("Inspire Your Audience","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 3 Increasing Knowledge 1939"] = 7;

$projects["Team Collaboration Level 3 Increasing Knowledge 1945"] = __("Make Connections Through Networking","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 3 Increasing Knowledge"] .= '<option value="Team Collaboration Level 3 Increasing Knowledge 1945">'.__("Make Connections Through Networking","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 3 Increasing Knowledge 1945"] = 7;

$projects["Team Collaboration Level 3 Increasing Knowledge 1951"] = __("Prepare for an Interview","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 3 Increasing Knowledge"] .= '<option value="Team Collaboration Level 3 Increasing Knowledge 1951">'.__("Prepare for an Interview","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 3 Increasing Knowledge 1951"] = 7;

$projects["Team Collaboration Level 3 Increasing Knowledge 1957"] = __("Understanding Vocal Variety","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 3 Increasing Knowledge"] .= '<option value="Team Collaboration Level 3 Increasing Knowledge 1957">'.__("Understanding Vocal Variety","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 3 Increasing Knowledge 1957"] = 7;

$projects["Team Collaboration Level 3 Increasing Knowledge 1963"] = __("Using Descriptive Language","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 3 Increasing Knowledge"] .= '<option value="Team Collaboration Level 3 Increasing Knowledge 1963">'.__("Using Descriptive Language","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 3 Increasing Knowledge 1963"] = 7;

$projects["Team Collaboration Level 3 Increasing Knowledge 1969"] = __("Using Presentation Software","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 3 Increasing Knowledge"] .= '<option value="Team Collaboration Level 3 Increasing Knowledge 1969">'.__("Using Presentation Software","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 3 Increasing Knowledge 1969"] = 7;

$projects["Team Collaboration Level 4 Building Skills 1978"] = __("Motivate Others","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 4 Building Skills"] = '<option value="Team Collaboration Level 4 Building Skills 1978">'.__("Motivate Others","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 4 Building Skills 1978"] = 7;

$projects["Team Collaboration Level 4 Building Skills 1985"] = __("Building a Social Media Presence","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 4 Building Skills"] .= '<option value="Team Collaboration Level 4 Building Skills 1985">'.__("Building a Social Media Presence","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 4 Building Skills 1985"] = 7;

$projects["Team Collaboration Level 4 Building Skills 1991"] = __("Create a Podcast (2-3 minute intro; 5-10 minute podcast)","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 4 Building Skills"] .= '<option value="Team Collaboration Level 4 Building Skills 1991">'.__("Create a Podcast (2-3 minute intro; 5-10 minute podcast)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 4 Building Skills 1991"] = 13;

$projects["Team Collaboration Level 4 Building Skills 1997"] = __("Manage Online Meetings (20 - 25 minutes)","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 4 Building Skills"] .= '<option value="Team Collaboration Level 4 Building Skills 1997">'.__("Manage Online Meetings (20 - 25 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 4 Building Skills 1997"] = 25;

$projects["Team Collaboration Level 4 Building Skills 2003"] = __("Manage Projects Successfully - First Speech (2 - 3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 4 Building Skills"] .= '<option value="Team Collaboration Level 4 Building Skills 2003">'.__("Manage Projects Successfully - First Speech (2 - 3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 4 Building Skills 2003"] = 3;

$projects["Team Collaboration Level 4 Building Skills 2004"] = __("Manage Projects Successfully - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 4 Building Skills"] .= '<option value="Team Collaboration Level 4 Building Skills 2004">'.__("Manage Projects Successfully - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 4 Building Skills 2004"] = 7;

$projects["Team Collaboration Level 4 Building Skills 2009"] = __("Managing a Difficult Audience (10 - 15 minutes)","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 4 Building Skills"] .= '<option value="Team Collaboration Level 4 Building Skills 2009">'.__("Managing a Difficult Audience (10 - 15 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 4 Building Skills 2009"] = 15;

$projects["Team Collaboration Level 4 Building Skills 2015"] = __("Public Relations Strategies","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 4 Building Skills"] .= '<option value="Team Collaboration Level 4 Building Skills 2015">'.__("Public Relations Strategies","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 4 Building Skills 2015"] = 7;

$projects["Team Collaboration Level 4 Building Skills 2021"] = __("Question-and-Answer Session (15 - 20 minutes)","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 4 Building Skills"] .= '<option value="Team Collaboration Level 4 Building Skills 2021">'.__("Question-and-Answer Session (15 - 20 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 4 Building Skills 2021"] = 20;

$projects["Team Collaboration Level 4 Building Skills 2027"] = __("Write a Compelling Blog (2 - 3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 4 Building Skills"] .= '<option value="Team Collaboration Level 4 Building Skills 2027">'.__("Write a Compelling Blog (2 - 3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 4 Building Skills 2027"] = 3;

$projects["Team Collaboration Level 5 Demonstrating Expertise 2036"] = __("Lead in Any Situation","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 5 Demonstrating Expertise"] = '<option value="Team Collaboration Level 5 Demonstrating Expertise 2036">'.__("Lead in Any Situation","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 5 Demonstrating Expertise 2036"] = 7;

$projects["Team Collaboration Level 5 Demonstrating Expertise 2043"] = __("Reflect on Your Path","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 5 Demonstrating Expertise"] .= '<option value="Team Collaboration Level 5 Demonstrating Expertise 2043">'.__("Reflect on Your Path","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 5 Demonstrating Expertise 2043"] = 7;

$projects["Team Collaboration Level 5 Demonstrating Expertise 2049"] = __("Ethical Leadership (20 - 40 minutes)","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 5 Demonstrating Expertise"] .= '<option value="Team Collaboration Level 5 Demonstrating Expertise 2049">'.__("Ethical Leadership (20 - 40 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 5 Demonstrating Expertise 2049"] = 40;

$projects["Team Collaboration Level 5 Demonstrating Expertise 2055"] = __("High Performance Leadership - First Speech","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 5 Demonstrating Expertise"] .= '<option value="Team Collaboration Level 5 Demonstrating Expertise 2055">'.__("High Performance Leadership - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 5 Demonstrating Expertise 2055"] = 7;

$projects["Team Collaboration Level 5 Demonstrating Expertise 2056"] = __("High Performance Leadership - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 5 Demonstrating Expertise"] .= '<option value="Team Collaboration Level 5 Demonstrating Expertise 2056">'.__("High Performance Leadership - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 5 Demonstrating Expertise 2056"] = 7;

$projects["Team Collaboration Level 5 Demonstrating Expertise 2061"] = __("Leading in Your Volunteer Organization","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 5 Demonstrating Expertise"] .= '<option value="Team Collaboration Level 5 Demonstrating Expertise 2061">'.__("Leading in Your Volunteer Organization","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 5 Demonstrating Expertise 2061"] = 7;

$projects["Team Collaboration Level 5 Demonstrating Expertise 2067"] = __("Lessons Learned","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 5 Demonstrating Expertise"] .= '<option value="Team Collaboration Level 5 Demonstrating Expertise 2067">'.__("Lessons Learned","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 5 Demonstrating Expertise 2067"] = 7;

$projects["Team Collaboration Level 5 Demonstrating Expertise 2073"] = __("Moderate a Panel Discussion (20 - 40 minutes)","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 5 Demonstrating Expertise"] .= '<option value="Team Collaboration Level 5 Demonstrating Expertise 2073">'.__("Moderate a Panel Discussion (20 - 40 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 5 Demonstrating Expertise 2073"] = 40;

$projects["Team Collaboration Level 5 Demonstrating Expertise 2079"] = __("Prepare to Speak Professionally (18 - 22 minutes)","rsvpmaker-for-toastmasters");
$project_options["Team Collaboration Level 5 Demonstrating Expertise"] .= '<option value="Team Collaboration Level 5 Demonstrating Expertise 2079">'.__("Prepare to Speak Professionally (18 - 22 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Team Collaboration Level 5 Demonstrating Expertise 2079"] = 22;

$projects["Visionary Communication Level 1 Mastering Fundamentals 2088"] = __("Ice Breaker (4 - 6 minutes)","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 1 Mastering Fundamentals"] = '<option value="Visionary Communication Level 1 Mastering Fundamentals 2088">'.__("Ice Breaker (4 - 6 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 1 Mastering Fundamentals 2088"] = 6;

$projects["Visionary Communication Level 1 Mastering Fundamentals 2095"] = __("Evaluation and Feedback - First Speech","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 1 Mastering Fundamentals"] .= '<option value="Visionary Communication Level 1 Mastering Fundamentals 2095">'.__("Evaluation and Feedback - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 1 Mastering Fundamentals 2095"] = 7;

$projects["Visionary Communication Level 1 Mastering Fundamentals 2096"] = __("Evaluation and Feedback - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 1 Mastering Fundamentals"] .= '<option value="Visionary Communication Level 1 Mastering Fundamentals 2096">'.__("Evaluation and Feedback - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 1 Mastering Fundamentals 2096"] = 7;

$projects["Visionary Communication Level 1 Mastering Fundamentals 2097"] = __("Evaluation and Feedback - Evaluator Speech (2-3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 1 Mastering Fundamentals"] .= '<option value="Visionary Communication Level 1 Mastering Fundamentals 2097">'.__("Evaluation and Feedback - Evaluator Speech (2-3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 1 Mastering Fundamentals 2097"] = 3;

$projects["Visionary Communication Level 1 Mastering Fundamentals 2101"] = __("Researching and Presenting","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 1 Mastering Fundamentals"] .= '<option value="Visionary Communication Level 1 Mastering Fundamentals 2101">'.__("Researching and Presenting","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 1 Mastering Fundamentals 2101"] = 7;

$projects["Visionary Communication Level 2 Learning Your Style 2110"] = __("Understanding Your Leadership Style","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 2 Learning Your Style"] = '<option value="Visionary Communication Level 2 Learning Your Style 2110">'.__("Understanding Your Leadership Style","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 2 Learning Your Style 2110"] = 7;

$projects["Visionary Communication Level 2 Learning Your Style 2117"] = __("Understanding Your Communication Style","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 2 Learning Your Style"] .= '<option value="Visionary Communication Level 2 Learning Your Style 2117">'.__("Understanding Your Communication Style","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 2 Learning Your Style 2117"] = 7;

$projects["Visionary Communication Level 2 Learning Your Style 2123"] = __("Mentoring","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 2 Learning Your Style"] .= '<option value="Visionary Communication Level 2 Learning Your Style 2123">'.__("Mentoring","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 2 Learning Your Style 2123"] = 7;

$projects["Visionary Communication Level 3 Increasing Knowledge 2132"] = __("Develop a Communication Plan","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 3 Increasing Knowledge"] = '<option value="Visionary Communication Level 3 Increasing Knowledge 2132">'.__("Develop a Communication Plan","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 3 Increasing Knowledge 2132"] = 7;

$projects["Visionary Communication Level 3 Increasing Knowledge 2139"] = __("Active Listening","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 3 Increasing Knowledge"] .= '<option value="Visionary Communication Level 3 Increasing Knowledge 2139">'.__("Active Listening","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 3 Increasing Knowledge 2139"] = 7;

$projects["Visionary Communication Level 3 Increasing Knowledge 2145"] = __("Connect with Storytelling","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 3 Increasing Knowledge"] .= '<option value="Visionary Communication Level 3 Increasing Knowledge 2145">'.__("Connect with Storytelling","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 3 Increasing Knowledge 2145"] = 7;

$projects["Visionary Communication Level 3 Increasing Knowledge 2151"] = __("Connect with Your Audience","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 3 Increasing Knowledge"] .= '<option value="Visionary Communication Level 3 Increasing Knowledge 2151">'.__("Connect with Your Audience","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 3 Increasing Knowledge 2151"] = 7;

$projects["Visionary Communication Level 3 Increasing Knowledge 2157"] = __("Creating Effective Visual Aids","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 3 Increasing Knowledge"] .= '<option value="Visionary Communication Level 3 Increasing Knowledge 2157">'.__("Creating Effective Visual Aids","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 3 Increasing Knowledge 2157"] = 7;

$projects["Visionary Communication Level 3 Increasing Knowledge 2163"] = __("Deliver Social Speeches - First Speech","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 3 Increasing Knowledge"] .= '<option value="Visionary Communication Level 3 Increasing Knowledge 2163">'.__("Deliver Social Speeches - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 3 Increasing Knowledge 2163"] = 7;

$projects["Visionary Communication Level 3 Increasing Knowledge 2169"] = __("Effective Body Language","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 3 Increasing Knowledge"] .= '<option value="Visionary Communication Level 3 Increasing Knowledge 2169">'.__("Effective Body Language","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 3 Increasing Knowledge 2169"] = 7;

$projects["Visionary Communication Level 3 Increasing Knowledge 2175"] = __("Focus on the Positive","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 3 Increasing Knowledge"] .= '<option value="Visionary Communication Level 3 Increasing Knowledge 2175">'.__("Focus on the Positive","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 3 Increasing Knowledge 2175"] = 7;

$projects["Visionary Communication Level 3 Increasing Knowledge 2181"] = __("Inspire Your Audience","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 3 Increasing Knowledge"] .= '<option value="Visionary Communication Level 3 Increasing Knowledge 2181">'.__("Inspire Your Audience","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 3 Increasing Knowledge 2181"] = 7;

$projects["Visionary Communication Level 3 Increasing Knowledge 2187"] = __("Make Connections Through Networking","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 3 Increasing Knowledge"] .= '<option value="Visionary Communication Level 3 Increasing Knowledge 2187">'.__("Make Connections Through Networking","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 3 Increasing Knowledge 2187"] = 7;

$projects["Visionary Communication Level 3 Increasing Knowledge 2193"] = __("Prepare for an Interview","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 3 Increasing Knowledge"] .= '<option value="Visionary Communication Level 3 Increasing Knowledge 2193">'.__("Prepare for an Interview","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 3 Increasing Knowledge 2193"] = 7;

$projects["Visionary Communication Level 3 Increasing Knowledge 2199"] = __("Understanding Vocal Variety","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 3 Increasing Knowledge"] .= '<option value="Visionary Communication Level 3 Increasing Knowledge 2199">'.__("Understanding Vocal Variety","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 3 Increasing Knowledge 2199"] = 7;

$projects["Visionary Communication Level 3 Increasing Knowledge 2205"] = __("Using Descriptive Language","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 3 Increasing Knowledge"] .= '<option value="Visionary Communication Level 3 Increasing Knowledge 2205">'.__("Using Descriptive Language","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 3 Increasing Knowledge 2205"] = 7;

$projects["Visionary Communication Level 3 Increasing Knowledge 2211"] = __("Using Presentation Software","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 3 Increasing Knowledge"] .= '<option value="Visionary Communication Level 3 Increasing Knowledge 2211">'.__("Using Presentation Software","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 3 Increasing Knowledge 2211"] = 7;

$projects["Visionary Communication Level 4 Building Skills 2220"] = __("Communicate Change","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 4 Building Skills"] = '<option value="Visionary Communication Level 4 Building Skills 2220">'.__("Communicate Change","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 4 Building Skills 2220"] = 7;

$projects["Visionary Communication Level 4 Building Skills 2227"] = __("Building a Social Media Presence","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 4 Building Skills"] .= '<option value="Visionary Communication Level 4 Building Skills 2227">'.__("Building a Social Media Presence","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 4 Building Skills 2227"] = 7;

$projects["Visionary Communication Level 4 Building Skills 2233"] = __("Create a Podcast (2-3 minute intro; 5-10 minute podcast)","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 4 Building Skills"] .= '<option value="Visionary Communication Level 4 Building Skills 2233">'.__("Create a Podcast (2-3 minute intro; 5-10 minute podcast)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 4 Building Skills 2233"] = 13;

$projects["Visionary Communication Level 4 Building Skills 2239"] = __("Manage Online Meetings (20 - 25 minutes)","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 4 Building Skills"] .= '<option value="Visionary Communication Level 4 Building Skills 2239">'.__("Manage Online Meetings (20 - 25 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 4 Building Skills 2239"] = 25;

$projects["Visionary Communication Level 4 Building Skills 2245"] = __("Manage Projects Successfully - First Speech (2 - 3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 4 Building Skills"] .= '<option value="Visionary Communication Level 4 Building Skills 2245">'.__("Manage Projects Successfully - First Speech (2 - 3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 4 Building Skills 2245"] = 3;

$projects["Visionary Communication Level 4 Building Skills 2246"] = __("Manage Projects Successfully - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 4 Building Skills"] .= '<option value="Visionary Communication Level 4 Building Skills 2246">'.__("Manage Projects Successfully - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 4 Building Skills 2246"] = 7;

$projects["Visionary Communication Level 4 Building Skills 2251"] = __("Managing a Difficult Audience (10 - 15 minutes)","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 4 Building Skills"] .= '<option value="Visionary Communication Level 4 Building Skills 2251">'.__("Managing a Difficult Audience (10 - 15 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 4 Building Skills 2251"] = 15;

$projects["Visionary Communication Level 4 Building Skills 2257"] = __("Public Relations Strategies","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 4 Building Skills"] .= '<option value="Visionary Communication Level 4 Building Skills 2257">'.__("Public Relations Strategies","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 4 Building Skills 2257"] = 7;

$projects["Visionary Communication Level 4 Building Skills 2263"] = __("Question-and-Answer Session (15 - 20 minutes)","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 4 Building Skills"] .= '<option value="Visionary Communication Level 4 Building Skills 2263">'.__("Question-and-Answer Session (15 - 20 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 4 Building Skills 2263"] = 20;

$projects["Visionary Communication Level 4 Building Skills 2269"] = __("Write a Compelling Blog (2 - 3 minutes)","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 4 Building Skills"] .= '<option value="Visionary Communication Level 4 Building Skills 2269">'.__("Write a Compelling Blog (2 - 3 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 4 Building Skills 2269"] = 3;

$projects["Visionary Communication Level 5 Demonstrating Expertise 2278"] = __("Develop Your Vision","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 5 Demonstrating Expertise"] = '<option value="Visionary Communication Level 5 Demonstrating Expertise 2278">'.__("Develop Your Vision","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 5 Demonstrating Expertise 2278"] = 7;

$projects["Visionary Communication Level 5 Demonstrating Expertise 2285"] = __("Reflect on Your Path","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 5 Demonstrating Expertise"] .= '<option value="Visionary Communication Level 5 Demonstrating Expertise 2285">'.__("Reflect on Your Path","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 5 Demonstrating Expertise 2285"] = 7;

$projects["Visionary Communication Level 5 Demonstrating Expertise 2291"] = __("Ethical Leadership (20 - 40 minutes)","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 5 Demonstrating Expertise"] .= '<option value="Visionary Communication Level 5 Demonstrating Expertise 2291">'.__("Ethical Leadership (20 - 40 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 5 Demonstrating Expertise 2291"] = 40;

$projects["Visionary Communication Level 5 Demonstrating Expertise 2297"] = __("High Performance Leadership - First Speech","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 5 Demonstrating Expertise"] .= '<option value="Visionary Communication Level 5 Demonstrating Expertise 2297">'.__("High Performance Leadership - First Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 5 Demonstrating Expertise 2297"] = 7;

$projects["Visionary Communication Level 5 Demonstrating Expertise 2298"] = __("High Performance Leadership - Second Speech","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 5 Demonstrating Expertise"] .= '<option value="Visionary Communication Level 5 Demonstrating Expertise 2298">'.__("High Performance Leadership - Second Speech","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 5 Demonstrating Expertise 2298"] = 7;

$projects["Visionary Communication Level 5 Demonstrating Expertise 2303"] = __("Leading in Your Volunteer Organization","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 5 Demonstrating Expertise"] .= '<option value="Visionary Communication Level 5 Demonstrating Expertise 2303">'.__("Leading in Your Volunteer Organization","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 5 Demonstrating Expertise 2303"] = 7;

$projects["Visionary Communication Level 5 Demonstrating Expertise 2309"] = __("Lessons Learned","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 5 Demonstrating Expertise"] .= '<option value="Visionary Communication Level 5 Demonstrating Expertise 2309">'.__("Lessons Learned","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 5 Demonstrating Expertise 2309"] = 7;

$projects["Visionary Communication Level 5 Demonstrating Expertise 2315"] = __("Moderate a Panel Discussion (20 - 40 minutes)","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 5 Demonstrating Expertise"] .= '<option value="Visionary Communication Level 5 Demonstrating Expertise 2315">'.__("Moderate a Panel Discussion (20 - 40 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 5 Demonstrating Expertise 2315"] = 40;

$projects["Visionary Communication Level 5 Demonstrating Expertise 2321"] = __("Prepare to Speak Professionally (18 - 22 minutes)","rsvpmaker-for-toastmasters");
$project_options["Visionary Communication Level 5 Demonstrating Expertise"] .= '<option value="Visionary Communication Level 5 Demonstrating Expertise 2321">'.__("Prepare to Speak Professionally (18 - 22 minutes)","rsvpmaker-for-toastmasters")."</option>";
$project_times["Visionary Communication Level 5 Demonstrating Expertise 2321"] = 22;

$project_options["Dynamic Leadership Level 1 Mastering Fundamentals"] .= '<option value="Dynamic Leadership Level 1 Mastering Fundamentals 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Dynamic Leadership Level 2 Learning Your Style"] .= '<option value="Dynamic Leadership Level 2 Learning Your Style 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Dynamic Leadership Level 3 Increasing Knowledge"] .= '<option value="Dynamic Leadership Level 3 Increasing Knowledge 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Dynamic Leadership Level 4 Building Skills"] .= '<option value="Dynamic Leadership Level 4 Building Skills 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Dynamic Leadership Level 5 Demonstrating Expertise"] .= '<option value="Dynamic Leadership Level 5 Demonstrating Expertise 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Effective Coaching Level 1 Mastering Fundamentals"] .= '<option value="Effective Coaching Level 1 Mastering Fundamentals 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Effective Coaching Level 2 Learning Your Style"] .= '<option value="Effective Coaching Level 2 Learning Your Style 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Effective Coaching Level 3 Increasing Knowledge"] .= '<option value="Effective Coaching Level 3 Increasing Knowledge 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Effective Coaching Level 4 Building Skills"] .= '<option value="Effective Coaching Level 4 Building Skills 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Effective Coaching Level 5 Demonstrating Expertise"] .= '<option value="Effective Coaching Level 5 Demonstrating Expertise 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Innovative Planning Level 1 Mastering Fundamentals"] .= '<option value="Innovative Planning Level 1 Mastering Fundamentals 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Innovative Planning Level 2 Learning Your Style"] .= '<option value="Innovative Planning Level 2 Learning Your Style 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Innovative Planning Level 3 Increasing Knowledge"] .= '<option value="Innovative Planning Level 3 Increasing Knowledge 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Innovative Planning Level 4 Building Skills"] .= '<option value="Innovative Planning Level 4 Building Skills 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Innovative Planning Level 5 Demonstrating Expertise"] .= '<option value="Innovative Planning Level 5 Demonstrating Expertise 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Innovative Planning Level 6"] .= '<option value="Innovative Planning Level 6 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Leadership Development Level 1 Mastering Fundamentals"] .= '<option value="Leadership Development Level 1 Mastering Fundamentals 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Leadership Development Level 2 Learning Your Style"] .= '<option value="Leadership Development Level 2 Learning Your Style 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Leadership Development Level 3 Increasing Knowledge"] .= '<option value="Leadership Development Level 3 Increasing Knowledge 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Leadership Development Level 4 Building Skills"] .= '<option value="Leadership Development Level 4 Building Skills 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Leadership Development Level 5 Demonstrating Expertise"] .= '<option value="Leadership Development Level 5 Demonstrating Expertise 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Motivational Strategies Level 1 Mastering Fundamentals"] .= '<option value="Motivational Strategies Level 1 Mastering Fundamentals 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Motivational Strategies Level 2 Learning Your Style"] .= '<option value="Motivational Strategies Level 2 Learning Your Style 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Motivational Strategies Level 3 Increasing Knowledge"] .= '<option value="Motivational Strategies Level 3 Increasing Knowledge 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Motivational Strategies Level 4 Building Skills"] .= '<option value="Motivational Strategies Level 4 Building Skills 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Motivational Strategies Level 5 Demonstrating Expertise"] .= '<option value="Motivational Strategies Level 5 Demonstrating Expertise 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Persuasive Influence Level 1 Mastering Fundamentals"] .= '<option value="Persuasive Influence Level 1 Mastering Fundamentals 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Persuasive Influence Level 2 Learning Your Style"] .= '<option value="Persuasive Influence Level 2 Learning Your Style 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Persuasive Influence Level 3 Increasing Knowledge"] .= '<option value="Persuasive Influence Level 3 Increasing Knowledge 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Persuasive Influence Level 4 Building Skills"] .= '<option value="Persuasive Influence Level 4 Building Skills 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Persuasive Influence Level 5 Demonstrating Expertise"] .= '<option value="Persuasive Influence Level 5 Demonstrating Expertise 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Presentation Mastery Level 1 Mastering Fundamentals"] .= '<option value="Presentation Mastery Level 1 Mastering Fundamentals 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Presentation Mastery Level 2 Learning Your Style"] .= '<option value="Presentation Mastery Level 2 Learning Your Style 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Presentation Mastery Level 3 Increasing Knowledge"] .= '<option value="Presentation Mastery Level 3 Increasing Knowledge 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Presentation Mastery Level 4 Building Skills"] .= '<option value="Presentation Mastery Level 4 Building Skills 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Presentation Mastery Level 5 Demonstrating Expertise"] .= '<option value="Presentation Mastery Level 5 Demonstrating Expertise 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Strategic Relationships Level 1 Mastering Fundamentals"] .= '<option value="Strategic Relationships Level 1 Mastering Fundamentals 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Strategic Relationships Level 2 Learning Your Style"] .= '<option value="Strategic Relationships Level 2 Learning Your Style 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Strategic Relationships Level 3 Increasing Knowledge"] .= '<option value="Strategic Relationships Level 3 Increasing Knowledge 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Strategic Relationships Level 4 Building Skills"] .= '<option value="Strategic Relationships Level 4 Building Skills 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Strategic Relationships Level 5 Demonstrating Expertise"] .= '<option value="Strategic Relationships Level 5 Demonstrating Expertise 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Team Collaboration Level 1 Mastering Fundamentals"] .= '<option value="Team Collaboration Level 1 Mastering Fundamentals 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Team Collaboration Level 2 Learning Your Style"] .= '<option value="Team Collaboration Level 2 Learning Your Style 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Team Collaboration Level 3 Increasing Knowledge"] .= '<option value="Team Collaboration Level 3 Increasing Knowledge 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Team Collaboration Level 4 Building Skills"] .= '<option value="Team Collaboration Level 4 Building Skills 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Team Collaboration Level 5 Demonstrating Expertise"] .= '<option value="Team Collaboration Level 5 Demonstrating Expertise 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Visionary Communication Level 1 Mastering Fundamentals"] .= '<option value="Visionary Communication Level 1 Mastering Fundamentals 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Visionary Communication Level 2 Learning Your Style"] .= '<option value="Visionary Communication Level 2 Learning Your Style 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Visionary Communication Level 3 Increasing Knowledge"] .= '<option value="Visionary Communication Level 3 Increasing Knowledge 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Visionary Communication Level 4 Building Skills"] .= '<option value="Visionary Communication Level 4 Building Skills 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";
$project_options["Visionary Communication Level 5 Demonstrating Expertise"] .= '<option value="Visionary Communication Level 5 Demonstrating Expertise 00">'.__("Other Pathways Speech","rsvpmaker-for-toastmasters")."</option>";

if($choice == 'projects')
	return $projects;
elseif($choice == 'options')
	return $project_options;
else
	return $project_times;
}

function timeplanner_option ($count) {
$count = (int) $count;
$options = '';
if($count == 0)
	{
		$options .= '<option value="0">Not Set</option>';	
	}
else
	{
		$options .= sprintf('<option value="%s">%s</option>',$count, $count);
	}

$options .= '<option value="0">Not Set</option>';	
for($i = 1; $i < 61; $i++)
	$options .= sprintf('<option value="%s">%s</option>',$i, $i);
return $options;
}

function timeplanner($atts, $content) {
	global $time_counter;
	global $newoutput;
	global $timeplanner_total;
	if(!isset($time_counter))
		$time_counter = 0;
	
	if(isset($atts["themewords"]))
		{
		if(!empty($newoutput))
			$newoutput .= '[toastmaster themewords="1" ]'."\n\n";
		return;
		}
	$time_counter++;
	$output = '';

	if(isset($_POST["remove"][$time_counter]))
		return;
	
	if(isset($atts["role"]))
		{
		$c = '';
		if(isset($atts["count"]))
			{
				$count = (int) $atts["count"];
				if($count > 1)
					$c = '('.$count.')';
			}
		$output .= sprintf('<h3>Role: %s %s</h3>',$atts["role"],$c);
		if(!empty($atts["agenda_note"]))
			$output .= '<p>'.$atts["agenda_note"].'</p>';
		if(strpos($atts["role"],'peaker') && !strpos($atts["role"],'ackup'))
			{
				$speak_count = 0;
				global $post;
				for($i = 1; $i <= $count; $i++)
					{
						$speak_count += (int) get_post_meta($post->ID,'_maxtime_Speaker_'.$i,true);
					}
			if($speak_count)
				{
				$time_allowed = (int) $atts["time_allowed"];
				if($speak_count > $time_allowed)
					{
					$s = ' style="color:red;" ';
					$output .= sprintf('<input type="hidden" id="speaker_time_count" value="%s" />', $speak_count - $time_allowed);
					}
				else
					$s = '';
				$output .= sprintf('<p><strong %s>Speakers have reserved: %s minutes</strong></p>',$s, $speak_count);
				}
			}
		}
	elseif( !empty($content) )
		$output .= sprintf('<h3>Note</h3><p>%s</p>',$content);
	$output .= sprintf('<p>Time Allowed: <select class="time_count" name="time_allowed[%d]" id="time_allowed_%s" >%s</select> ',$time_counter,$time_counter,timeplanner_option ($atts["time_allowed"]));
	if(isset($atts["role"]))
		$output .= sprintf(' Extra Time: <select class="time_count" name="padding_time[%d]" id="padding_time_%d" >%s</select>',$time_counter,$time_counter,timeplanner_option ($atts["padding_time"]));
	$output .= sprintf('<br /><input type="checkbox" name="remove[%d]" class="remove_checkbox" value="%s" /> Remove',$time_counter,$time_counter);
	$output .= '</p>';
	$output .= '<div class="time_message"></div>'."\n\n";
	if(isset($_POST["time_allowed"][$time_counter]))
		{				
			$time_allowed = (int) $_POST["time_allowed"][$time_counter];
			$timeplanner_total += $time_allowed;
			$output .= sprintf('<p>Set time_allowed: %s</p>',$_POST["time_allowed"][$time_counter]);
			if(isset($atts["role"]))
				$newoutput .= sprintf('[toastmaster role="%s" ',$atts["role"]);
			else
				$newoutput .= '[agenda_note " ';
			foreach($atts as $index => $value)
				{
					if(($index != 'role') && ($index != 'time_allowed') && ($index != 'padding_time'))
						$newoutput .= $index . '="'.$value.'" ';
				}
			$newoutput .= 'time_allowed="'.$time_allowed.'" ';
		if(isset($_POST["padding_time"][$time_counter]))
			{
			$padding_time = (int) $_POST["padding_time"][$time_counter];
			$timeplanner_total += $padding_time;
			$output .= sprintf('<p>Set padding time: %s</p>',$_POST["padding_time"][$time_counter]);
			$newoutput .= 'padding_time="'.$padding_time.'" ';
			}

		if(!empty($content))
			{
			$newoutput .= sprintf("]%s[/agenda_note]\n\n",$content);
			}
		else
			$newoutput .="]\n\n";
		}

return $output;
}

function agenda_timing () {
global $wpdb;
$template_options = '';
if(isset($_GET["post_id"]) && $_GET["post_id"])
{
$post_id = (int) $_GET["post_id"];
global $post;
$post = get_post($post_id);

$output = do_shortcode($post->post_content);
echo admin_link_menu();
?>
<h1><?php _e("Title",'rsvpmaker-for-toastmasters');?>: <?php echo $post->post_title; ?></h1>
<?php

$sked = get_post_meta($post_id,'_sked',true);
if(empty($sked))
{
global $rsvp_options;
$results = get_rsvp_dates($post_id);
if($results)
{
$dateblock = '';
foreach($results as $row)
	{
	$t = strtotime($row["datetime"]);
	$dateblock .= '<div class="datetime" itemprop="startDate" datetime="'.date('c',$t).'" utc="'.gmtdate('YYYY-mm-dd H:i'). 'UTC">';
	$dateblock .= strftime($rsvp_options["long_date"],$t);
	$dur = $row["duration"];
	if($dur != 'allday')
		$dateblock .= strftime(' '.$rsvp_options["time_format"],$t);
	// dchange
	if(strpos($dur,':'))
		$dur = strtotime($dur);
	if(is_numeric($dur) )
		$dateblock .= " ".__('to','rsvpmaker')." ". strftime($rsvp_options["time_format"],$dur);
	$dateblock .= "</div>\n";
	}
}
echo $dateblock;
}
else
{
if(is_array($sked["week"]))
	{
		$weeks = $sked["week"];
		$dows = $sked["dayofweek"];
	}
else
	{
		$weeks[0] = $sked["week"];
		$dows[0] = $sked["dayofweek"];
	}
$weekarray = Array(__("Varies",'rsvpmaker'),__("First",'rsvpmaker'),__("Second",'rsvpmaker'),__("Third",'rsvpmaker'),__("Fourth",'rsvpmaker'),__("Last",'rsvpmaker'),__("Every",'rsvpmaker'));
$dayarray = Array(__("Sunday",'rsvpmaker'),__("Monday",'rsvpmaker'),__("Tuesday",'rsvpmaker'),__("Wednesday",'rsvpmaker'),__("Thursday",'rsvpmaker'),__("Friday",'rsvpmaker'),__("Saturday",'rsvpmaker'));

if($weeks[0] == 0)
	echo '<h2>Schedule Varies</h2>';
else
	{
	$t = '';
	foreach($weeks as $w)
		{
		$t .= $weekarray[$w].' ';
		//$t .= $w;
		}
	foreach($dows as $d)
		{
		$t .= $dayarray[$d].' ';
		//$t .= $d;
		}
	printf('<h2>%s</h2>',$t);
	}
}

global $newoutput;
global $timeplanner_total;
if(!empty($newoutput))
	{
	wp_update_post(array('ID' => $post_id,'post_content' => $newoutput));
	//echo nl2br($newoutput);
	printf('<h3>Total Time Allowed: %s</h3>',$timeplanner_total);
	echo rsvp_template_update_checkboxes($post_id);
	printf('<p><a href="%s">Revise Timing</a></p>',admin_url('edit.php?post_type=rsvpmaker&page=agenda_timing&post_id=').$post_id);
	printf('<p><a href="%s">Go to Agenda Setup</a></p>',admin_url('edit.php?post_type=rsvpmaker&page=agenda_setup&post_id=').$post_id);
	printf('<p><a href="%s">View on site</a></p>',get_permalink($post_id));
	}
else
{
?>
<div style="position: fixed; left: 550px; bottom: 0; background-color: #fff; width: 100%; padding: 20px;" ><h2 id="time_message"></h2></div>
<?php
}
?>
<div style="background-color: #fff;" id="doc">
<p>You can plan your agenda by assigning minutes of <strong>Time Allowed</strong> to either roles like speaker or evaluator or agenda notes (typically used for stage directions like "Sgt. at Arms leads the Pledge of Allegience").</p>
<p><strong>Extra Time</strong> is used to pad the schedule with additional time, beyond what members sign up for. The primary intended use was to add an allowance for time spent introducing speakers to the agenda.</p>
<p>Example: a club sets 24 minutes as the Time Allowed for speeches, which would be sufficient for two 7-minute speeches, plus a 10 minute speech, or one or two longer speech projects. Setting Extra Time to 1 minute would make the total time reserved on the agenda to 25 minutes.</p>
<p>If speakers have reserved more time on the agenda than is normally allowed, you will see that reflected in the time estimate.</p>
</div>
<p id="doc_button_container" style="width: 200px; float: right;"><button id="doc_button">Show Explanation</button></p>
<form id="agenda_timing" method="post" action = "<?php echo admin_url('edit.php?post_type=rsvpmaker&page=agenda_timing&post_id='.$post_id); ?>">

<input type="hidden" name="post_id" value="<?php echo $post_id; ?>" />

<?php
if(empty($newoutput))
	{
	echo $output;

submit_button();
	}
?>
</form>
<script>
jQuery(document).ready(function($) {

    var sum = 0;
    $('.time_count').each(function() {
        sum += Number($(this).val());
    });
	
	var speaker_time = $('#speaker_time_count').val();
	if(speaker_time)
	    sum += Number(speaker_time);
	
	$('#time_message').html('Total time: '+sum+' minutes.');

	$('#doc').hide();	

$('.time_count').on('change', function(){
    var sum = 0;
    $('.time_count').each(function() {
        sum += Number($(this).val());
    });
	
	$('#time_message').html('Total time: '+sum+' minutes.');
});


$('.remove_checkbox').on('click', function(){
	var counter = $(this).val();
	
	var time_id = '#time_allowed_' + counter;
	var padding_id = '#padding_time_' + counter;
	
	$(time_id).html('<option value="0">Marked for Removal</option>');
	$(padding_id).html('<option value="0">Marked for Removal</option>');
		
    var sum = 0;
    $('.time_count').each(function() {
        sum += Number($(this).val());
    });

	var speaker_time = $('#speaker_time_count').val();
	if(speaker_time)
	    sum += Number(speaker_time);
	
	$('#time_message').html('Total time: '+sum+' minutes.');
});


$('#doc_button').on('click', function(){
	$('#doc').show();
	$('#doc_button_container').hide();
});


});

</script>
<?php
}
else
{
		$dayarray = Array(__("Sunday",'rsvpmaker'),__("Monday",'rsvpmaker'),__("Tuesday",'rsvpmaker'),__("Wednesday",'rsvpmaker'),__("Thursday",'rsvpmaker'),__("Friday",'rsvpmaker'),__("Saturday",'rsvpmaker'));
		$weekarray = Array(__("Varies",'rsvpmaker'),__("First",'rsvpmaker'),__("Second",'rsvpmaker'),__("Third",'rsvpmaker'),__("Fourth",'rsvpmaker'),__("Last",'rsvpmaker'),__("Every",'rsvpmaker'));
	
			$sql = "SELECT *, $wpdb->posts.ID as postID
FROM $wpdb->postmeta
JOIN $wpdb->posts ON $wpdb->postmeta.post_id = $wpdb->posts.ID
WHERE meta_key='_sked' AND post_status='publish' AND post_content LIKE '%[toastmaster%'";
			
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

		$results = get_future_events(" post_content LIKE '%[toastmaster%' ", 100);
		$event_options = '';
		if($results)
		foreach ($results as $r)
			{
			$event_options .= sprintf('<option value="%d">%s %s</option>',$r->postID,$r->post_title,$r->datetime);
			}
			
		$action = admin_url('edit.php');
		
		printf('<form method="get" action="%s"><p>'.__("Get Agenda For",'rsvpmaker-for-toastmasters').' <select name="post_id"><optgroup label="'.__("Templates",'rsvpmaker-for-toastmasters').'">%s</optgroup><optgroup label="'.__("Events",'rsvpmaker-for-toastmasters').'">%s</optgroup></select>
<input type="hidden" name="post_type" value="rsvpmaker" /><input type="hidden" name="page" value="agenda_timing" />		
		</p>',$action, $template_options, $event_options);
		submit_button(__('Get Agenda','rsvpmaker-for-toastmasters'));
		echo '</form>';
}

}

function admin_link_menu() {
global $post;
$permalink = get_permalink($post->ID).'?';
$security = get_tm_security ();
$template_id = get_post_meta($post->ID,'_meet_recur',true);

	$link = '<div id="cssmenu"><ul>';
	if(current_user_can($security['agenda_setup']))
		{
		$agenda_time = get_option('agenda_time');
		
		$agenda_menu[__('Agenda Setup','rsvpmaker-for-toastmasters')] = admin_url('post.php?action=edit&post='.$post->ID);
		if($template_id)
			$agenda_menu[__('Agenda Setup: Template','rsvpmaker-for-toastmasters')] = admin_url('post.php?action=edit&post='.$template_id);
		if($agenda_time)
			{
			$agenda_menu[__('Agenda Timing','rsvpmaker-for-toastmasters')] = admin_url('edit.php?post_type=rsvpmaker&page=agenda_timing&post_id='.$post->ID);
			if($template_id)
				$agenda_menu[__('Agenda Timing: Template','rsvpmaker-for-toastmasters')] = admin_url('edit.php?post_type=rsvpmaker&page=agenda_timing&post_id='.$template_id);
			}
			
		$size = sizeof($agenda_menu);
		$linkcounter = 1;
		foreach($agenda_menu as $label => $agenda_link)
			{
				if($linkcounter == 1)
					{
					if($size == 1)
						$link .= sprintf('<li><a href="%s">%s</a></li>',$agenda_link, $label);
					else
						$link .= sprintf('<li class="has-sub"><a href="%s">%s</a><ul>',$agenda_link, $label);
					}
				else
					{
						if($linkcounter == $size)
							$link .= sprintf('<li class="last"><a href="%s">%s</a></li></ul></li>',$agenda_link, $label);
						else
							$link .= sprintf('<li><a href="%s">%s</a></li>',$agenda_link, $label);						
					}
				$linkcounter++;
			}
		}
	if($template_id) // if it has a template, it's not itself a template
		$link .= '<li><a target="_blank" href="'.$permalink.'">'.__('View Event','rsvpmaker-for-toastmasters').'</a></li>';
	else
		$link .= '<li><a target="_blank" href="'.$permalink.'">'.__('View Template on Site','rsvpmaker-for-toastmasters').'</a></li>';
	$link .= '<li class="last"><a target="_blank" href="'.$permalink.'print_agenda=1&test=1">'.__('View Agenda','rsvpmaker-for-toastmasters').'</a></li>';
	$link .= '</ul></div>';
return $link;

}

function tm_security_setup ($check = true) {

$security_roles = array('administrator','manager','editor','author','contributor','subscriber');

$tm_security["administrator"]["view_reports"] = 1;
$tm_security["administrator"]["view_contact_info"] = 1;
$tm_security["administrator"]["edit_signups"] = 1;
$tm_security["administrator"]["edit_member_stats"] = 1;
$tm_security["administrator"]["edit_own_stats"] = 1;
$tm_security["administrator"]["agenda_setup"] = 1;
$tm_security["administrator"]["edit_members"] = 1;
$tm_security["administrator"]["email_list"] = 1;
$tm_security["administrator"]["add_member"] = 1;

$tm_security["manager"]["view_reports"] = 1;
$tm_security["manager"]["view_contact_info"] = 1;
$tm_security["manager"]["edit_signups"] = 1;
$tm_security["manager"]["edit_member_stats"] = 1;
$tm_security["manager"]["edit_own_stats"] = 1;
$tm_security["manager"]["agenda_setup"] = 1;
$tm_security["manager"]["email_list"] = 1;
$tm_security["manager"]["add_member"] = 1;
$tm_security["manager"]["edit_members"] = 1;
$tm_security["manager"]["edit_users"] = 1;
$tm_security["manager"]['promote_users'] = 1;
$tm_security["manager"]['remove_users'] = 1;
$tm_security["manager"]['delete_users'] = 1;
$tm_security["manager"]['list_users'] = 1;

$tm_security["editor"]["view_reports"] = 1;
$tm_security["editor"]["view_contact_info"] = 1;
$tm_security["editor"]["edit_signups"] = 1;
$tm_security["editor"]["edit_member_stats"] = 1;
$tm_security["editor"]["edit_own_stats"] = 1;
$tm_security["editor"]["agenda_setup"] = 1;
$tm_security["editor"]["email_list"] = 1;
$tm_security["editor"]["add_member"] = 0;
$tm_security["editor"]["edit_users"] = 0;
$tm_security["editor"]["edit_members"] = 0;
$tm_security["editor"]['promote_users'] = 0;
$tm_security["editor"]['remove_users'] = 0;
$tm_security["editor"]['delete_users'] = 0;
$tm_security["editor"]['list_users'] = 0;

$tm_security["author"]["view_reports"] = 1;
$tm_security["author"]["view_contact_info"] = 1;
$tm_security["author"]["edit_signups"] = 1;
$tm_security["author"]["edit_member_stats"] = 0;
$tm_security["author"]["edit_own_stats"] = 0;
$tm_security["author"]["agenda_setup"] = 0;
$tm_security["author"]["email_list"] = 1;
$tm_security["author"]["add_member"] = 0;

$tm_security["contributor"]["view_reports"] = 1;
$tm_security["contributor"]["view_contact_info"] = 1;
$tm_security["contributor"]["edit_signups"] = 1;
$tm_security["contributor"]["edit_member_stats"] = 0;
$tm_security["contributor"]["edit_own_stats"] = 0;
$tm_security["contributor"]["agenda_setup"] = 0;
$tm_security["contributor"]["email_list"] = 1;
$tm_security["contributor"]["add_member"] = 0;

$tm_security["subscriber"]["view_reports"] = 1;
$tm_security["subscriber"]["view_contact_info"] = 1;
$tm_security["subscriber"]["edit_signups"] = 1;
$tm_security["subscriber"]["edit_member_stats"] = 0;
$tm_security["subscriber"]["edit_own_stats"] = 0;
$tm_security["subscriber"]["agenda_setup"] = 0;
$tm_security["subscriber"]["email_list"] = 1;

//fix for changing display label for this role

if(is_multisite())
{
$tm_role = get_role('administrator');
$tm_role->add_cap('edit_members'); // site admins need to be able to edit member records
}

if($check)
{

$security = get_option('tm_security');
if(!empty($security))
	{
		// if this was customized the old way, adjust defaults
		$caparray['read'] = array('administrator','manager','editor','author','contributor','subscriber');
		$caparray['edit_others_posts'] = array('administrator','manager','editor');
		$caparray['manage_options'] = array('administrator');
		foreach($security as $tm_cap => $cap)
			{
				if($tm_cap == 'view_attendance')
					continue;
				foreach($security_roles as $role)
					{
					$tm_security[$role][$tm_cap] = in_array($role,$caparray[$cap]);
					}
			}
	// delete_option('tm_security');
	}

add_awesome_roles();

$tm_cap_set = get_option('tm_cap_set');
if(!$tm_cap_set || ($check == 2))
	{
	foreach($security_roles as $role)
		{
			$tm_role = get_role($role);
			foreach($tm_security[$role] as $cap => $value)
				{
					if($value)
						$tm_role->add_cap($cap);
					else
						$tm_role->remove_cap($cap);
				}
		}
	update_option('tm_cap_set',1);
	}
}
return $tm_security;
}


function tm_security_caps () {
?>
<div class="wrap">
<h2>Toastmasters Security Options</h2>
<?php
$action = admin_url('options-general.php?page=tm_security_caps');
$security_roles = array('manager','editor','author','contributor','subscriber');

if(isset($_POST["tm_caps"]) && $_POST["tm_caps"])
	{
	foreach($security_roles as $role)
		{
			$tm_role = get_role($role);
			foreach($_POST["tm_caps"][$role] as $cap => $value)
				{
					if($value)
						$tm_role->add_cap($cap);
					else
						$tm_role->remove_cap($cap);
				}
		}
	}

if(isset($_POST["user_caps"]) && $_POST["user_caps"])
	{
	$user = get_user_by('ID',$_POST["user_id"]);
	foreach($_POST["user_caps"] as $cap => $value)
		{
			if($value)
				$user->add_cap($cap);
			else
				$user->remove_cap($cap);
		}
	}

if(isset($_GET["reset_security"]))
	$tm_security = tm_security_setup (2);
else
	$tm_security = tm_security_setup (false);

if(isset($_POST["user_id"]) && $_POST["user_id"])
	{
		$user_id = (int) $_POST["user_id"];
		$user = get_user_by('id',$user_id);
printf('<form method="post" action="%s"><h3>%s</h3><input type="hidden" name="user_id" value="%s" />',$action,$user->user_login, $user_id);

		foreach($tm_security['manager'] as $cap => $value)
			{
				if( ($cap == 'delete_users') && is_multisite() )
					continue;
				if( ($cap == 'remove_users') && !is_multisite() )
					continue;					
				$opt = ($user->has_cap($cap)) ? '<option value="1" selected="selected">'.__('Yes','rsvpmaker-for-toastmasters').'</option><option value="0">'.__('No','rsvpmaker-for-toastmasters').'</option>' : '<option value="1">'.__('Yes','rsvpmaker-for-toastmasters').'</option><option value="0" selected="selected">'.__('No','rsvpmaker-for-toastmasters').'</option>';
				printf('<p><select name="user_caps[%s]">%s</select> %s</p>',$cap,$opt,$cap);
			}
submit_button();

echo '</form>';
	}

printf('<form method="post" action="%s">',$action);

foreach($security_roles as $role)
	{
		if($role == 'administrator')
			{
				continue;
			}
		$tm_role = get_role($role);		
		$label = ucfirst($role);
		
		if($role == 'subscriber')
			{
				$label .= ' ('.__('Member','rsvpmaker-for-toastmasters').')';
			}
		printf('<div style="width: 200px; float: left;"><h3>%s</h3>',$label);
		foreach($tm_security[$role] as $cap => $value)
			{
				if( ($cap == 'delete_users') && is_multisite() )
					continue;
				if( ($cap == 'remove_users') && !is_multisite() )
					continue;					
				$opt = ($tm_role->capabilities[$cap]) ? '<option value="1" selected="selected">'.__('Yes','rsvpmaker-for-toastmasters').'</option><option value="0">'.__('No','rsvpmaker-for-toastmasters').'</option>' : '<option value="1">'.__('Yes','rsvpmaker-for-toastmasters').'</option><option value="0" selected="selected">'.__('No','rsvpmaker-for-toastmasters').'</option>';
				printf('<p><select name="tm_caps[%s][%s]">%s</select> %s</p>',$role,$cap,$opt,$cap);
			}
		echo '</div>';
	}

echo '<div style="clear: both;">';
submit_button();
echo '</div>';
echo '</form>';

printf('<form method="post" action="%s"><h2>Set for User</h2>',$action);
echo awe_user_dropdown ('user_id',0, true);
submit_button();
echo '</form>';
?>
</div>
<h3>About these security options</h3>
<p>WordPress security is based on a series of roles, which define categories of users. By default, members are assigned to the standard WordPress security role <strong>Subscriber</strong>, a user with no rights to edit or publish content. At the other extreme, the <strong>Administrator</strong> has all rights on the site. In between are the <a href="https://codex.wordpress.org/Roles_and_Capabilities">standard WordPress roles</a> <strong>Contributor</strong>, <strong>Author</strong>, and <strong>Editor</strong>, each with increasing rights to submit, publish, and edit website content.</p>
<p>We have assigned each of these roles, plus the custom role <strong>Manager</strong> an additional set of privledges related to Toastmasters functionality, and you can change the default choices as necessary. You can also grant or revoke rights for a specific user. Additional customization is possible using a plugin such as <a href="https://wordpress.org/plugins/user-role-editor/">User Role Editor</a> (included with wp4toastmasters.com / toastmost.org accounts).</p>
<p>Visitors to the site who are not logged in cannot perform any of these actions. They also will not be able to view content designated as "members only" such as members only blog posts.</p>
<?php
}

//BuddyPress support


function bp_toastmasters($post_id,$actiontext,$user_id) {

if(!function_exists('bp_activity_add'))
	return;

global $bp;
 // hack for multisite
if(empty($bp->activity->table_name))
	{
		do_action('bp_init');
	}
$profile_link = bp_core_get_userlink($user_id);
$permalink = get_permalink($post_id);
global $wpdb;

$date = get_rsvp_date($post_id);
$ts = strtotime($date);
$actiontext .= ' for <a href="'.$permalink.'">'.date('F jS',$ts).'</a>';
if(is_multisite() )
	{
		$urlparts = explode("//",site_url());
		$actiontext .= ' ('.$urlparts[1].')';
	}
$args = array('action' => $profile_link.' posted an update', 'content' => $actiontext, 'component' => 'activity', 'type' => 'activity_update', 'primary_link' => bp_core_get_userlink($user_id, false, true), 'user_id'=> $user_id );
$row_id = bp_activity_add($args);
//bp_update_user_last_activity( $user_id, time() );
}

function display_toastmasters_profile() {
	global $bp;
	$userdata = get_userdata($bp->displayed_user->id);
	
		if(is_club_member() )
		{
		echo '<p><em>'.__('Contact details such as phone numbers and email are displayed only for logged in members (and should only be used for Toastmasters business)','rsvpmaker-for-toastmasters').'.</em></p>';
		}
		else
			return;
	
$wp4toastmasters_officer_titles = get_option('wp4toastmasters_officer_titles');
$title = $wp4toastmasters_officer_titles[$userdata->ID];
$contactmethods['home_phone'] = __("Home Phone",'rsvpmaker-for-toastmasters');
$contactmethods['work_phone'] = __("Work Phone",'rsvpmaker-for-toastmasters');
$contactmethods['mobile_phone'] = __("Mobile Phone",'rsvpmaker-for-toastmasters');
$contactmethods['facebook_url'] = __("Facebook Profile","rsvpmaker-for-toastmasters");
$contactmethods['twitter_url'] = __("Twitter Profile",'rsvpmaker-for-toastmasters');
$contactmethods['linkedin_url'] = __("LinkedIn Profile",'rsvpmaker-for-toastmasters');
$contactmethods['business_url'] = __("Business Web Address",'rsvpmaker-for-toastmasters');
$contactmethods['user_email'] = __("Email",'rsvpmaker-for-toastmasters');

?>
<p id="member_<?php echo $userdata->ID; ?>"><strong><?php echo $userdata->first_name.' '.$userdata->last_name?></strong> <?php if(!empty($userdata->education_awards)) echo '('.$userdata->education_awards.')'; ?> <?php if(!empty($title)) echo ' '.$title; ?></p>
<?php

	foreach($contactmethods as $name => $value)
		{
		if(empty($userdata->$name))
			continue;
		if(strpos($name,'phone'))
			{
				printf("<div>%s: %s</div>",$value,$userdata->$name);
			}
		if(strpos($name,'url'))
			{
				printf('<div><a target="_blank" href="%s">%s</a></div>',$userdata->$name,$value);
			}
		}
		
		printf('<div>'.__('Email','rsvpmaker-for-toastmasters').': <a href="mailto:%s">%s</a></div>',$userdata->user_email,$userdata->user_email);
		
		if($userdata->user_description)
			echo wpautop('<strong>'.__('About Me','rsvpmaker-for-toastmasters').':</strong> '. add_implicit_links($userdata->user_description));
global $current_user;
if(bp_displayed_user_id() == $current_user->ID)
	printf('<p>&mdash;<a href="%s">%s</a></p>',admin_url('profile.php'),__('Edit my Toastmasters profile','rsvpmaker-for-toastmasters'));
}

/* Ajax */

function ajax_toast_assign() {

	check_ajax_referer( 'rsvpmaker-for-toastmasters', 'security' );
	global $wpdb; // this is how you get access to the database
	
	$role = $_POST["role"];
	$post_id = $_POST["post_id"];	
	$assign = $_POST["assign"];
	$manual = $_POST["manual"];
	$project = $_POST["project"];
	$time = $_POST["time"];
	$title = $_POST["title"];
	if($assign)
	{
		if($assign == 'open')
			$assign = 0;
		update_post_meta($post_id,$role,$assign);
		update_post_meta($post_id,'_maxtime'.$role,$time);		
		_e('Background saved role assignment','rsvpmaker-for-toastmasters');
	}
	elseif($project)
	{
		update_post_meta($post_id,'_project'.$role,$project);
		update_post_meta($post_id,'_manual'.$role,$manual);
		update_post_meta($post_id,'_maxtime'.$role,$time);		
		_e('Background saved role, manual, and time','rsvpmaker-for-toastmasters');
	}
	elseif($manual)
	{
		update_post_meta($post_id,'_manual'.$role,$manual);
		_e('Background saved manual','rsvpmaker-for-toastmasters');
	}
	elseif($title)
	{
		update_post_meta($post_id,'_title'.$role,$title);
		_e('Background saved title','rsvpmaker-for-toastmasters');
	}
	
	wp_die(); // this is required to terminate immediately and return a proper response
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

$model = get_option('stats_data_model');
if(empty($model) || $model < 1)
	update_stats_model();

function update_stats_model()
{
global $wpdb;
$users = get_users();
foreach($users as $user)
{
$sql = "SELECT SUM(quantity) as total,role FROM `".$wpdb->prefix."toastmasters_history` where user_id=".$user->ID." group by role";
$results = $wpdb->get_results($sql);
if($results)
foreach ($results as $row)
	{
		$role = $row->role;
		if($role == 'COMPETENT COMMUNICATION')
			$role = 'COMPETENT COMMUNICATION';
		update_user_meta($user->ID,'tmstat:'.$role,$row->total);
	}
}
update_option('stats_data_model',1);
}

add_filter('bp_get_activity_content_body','members_only_bp');

function members_only_bp($args) {
global $activities_template;

if($activities_template->activity->secondary_item_id)
{
$cat = wp_get_post_categories($activities_template->activity->secondary_item_id);
foreach($cat as $cat_id)
	{
	$category = get_category($cat_id);
	if($category->slug == 'members-only')
		return 'Members-only content (login required)';
	}
}

return $args;
}

function officers_limit_promotion($all_roles) {
if(current_user_can('manage_options'))
	return $all_roles;

	unset($all_roles['administrator']);

    return $all_roles;
}

add_filter('editable_roles', 'officers_limit_promotion',99);

function extract_video($content) {

$pattern = '/<a class="vm-video-title-content.+video_id=([^"]+)[^>]+([^\<]+)/';

	preg_match_all($pattern,$content, $matches);
	foreach($matches[1] as $index => $value)
		{
			$url = 'https://www.youtube.com/watch?v='.$value;
			$title = $matches[2][$index];
			$links[] = sprintf('<a href="%s"%s</a>'."\n%s\n\n",$url,$title,$url);
		}

if(isset($_POST["reverse_order"]) && $_POST["reverse_order"])
	krsort($links);

	return implode("\n",$links);
}

function tm_youtube_tool () {

echo '<h1>Toastmasters YouTube Video Tool</h1>';
echo "<p>";
 _e('This tool was designed to capture a listing of videos you have uploaded to YouTube and use them as the basis of a blog post (categorized as members-only by default) and / or an email to distribute to your members.','rsvpmaker-for-toastmasters');
echo "</p>";
 
global $current_user;
global $wpdb;
$wpdb->show_errors();

if($_POST["video"])
	{
	
	echo "<h1>".stripslashes($_POST["title"])."</h1>";
	
	$vtext = extract_video(stripslashes($_POST["video"]))."<br /><br />";

$blog = $_POST["blog"];
$email = $_POST["email"];
$policy = stripslashes($_POST["policy"]);
$reverse = $_POST["reverse_order"];
update_option('tm_video_blog',$blog);
update_option('tm_video_email',$email);
update_option('tm_video_policy',$policy);
update_option('tm_video_reverse',$reverse);

$members_category = get_category_by_slug('members-only');
$members_cat_id = (empty($members_category->term_id)) ? wp_create_category('Members Only') : $members_category->term_id;
$video_cat = wp_create_category(__('Video','rsvpmaker-for-toastmasters'));

	// Create post object
$my_post = array(
  'post_title'    => __('Videos','rsvpmaker-for-toastmasters'),
  'post_content'  => $vtext,
  'post_status'   => $blog,
  'post_author'   => $current_user->ID,
  'post_category' => array($members_cat_id,$video_cat) //video, members only
);

if(!empty($_POST["speakers"]))
	{
	$my_post['tags_input'] = $_POST["speakers"];
	$my_post['post_title'] .= ': '.stripslashes(implode(', ',$_POST["speakers"]));
	}

// Insert the post into the database
if($blog != 'none')
	{
	$id = wp_insert_post( $my_post );
if($id)
	printf('<p><a href="%s?post=%d&action=edit">%s</a></p>',admin_url('post.php'),$id,__('Edit blog post','rsvpmaker-for-toastmasters'));
	if($blog == 'publish')
		printf('<p><a href="%s">%s</a></p>',get_permalink($id),__('View blog post','rsvpmaker-for-toastmasters'));
	}

	if($email)
		{
		$my_email = array(
  'post_title'    => $my_post["post_title"],
  'post_content'  => $vtext.wpautop($policy),
  'post_status'   => 'publish',
  'post_type' => 'rsvpemail',
  'post_author'   => $current_user->ID);
	$id = wp_insert_post( $my_email );
		printf('<p><a href="%s">%s</a></p>',get_permalink($id),__('Preview/send email','rsvpmaker-for-toastmasters'));
		}

	echo nl2br($vtext);
	}
?>
<form method="post" action="<?php echo admin_url('upload.php?page=tm_youtube_tool'); ?>">
<h3><?php _e('Paste YouTube content here','rsvpmaker-for-toastmasters'); ?></h3>
<?php
	$editor_id = "video";
	
	$settings = array( 'media_buttons' => false );
	
	wp_editor( '', $editor_id, $settings );
?>
<h3><?php _e('Policy to include in email','rsvpmaker-for-toastmasters'); ?></h3>
<?php
	$policy = get_option('tm_video_policy');
	if(empty($policy) )
		$policy = "<strong>Video policy</strong>: speech videos are intended as a tool for speakers to see their own performances and think about how they can improve. Even though these are on YouTube, they are published as \"unlisted\" by default, meaning they won't show up in search results. Don't forward these links or post them on Facebook or in any other forum without the speaker's permission. From time to time, we may ask a speaker for permission to use a video as part of our marketing of the club. Volunteers are also welcome - if you're proud of a particular speech, let us know.";
	$editor_id = "policy";
	
	$settings = array( 'media_buttons' => false, 'textarea_rows' => 5 );
	
	wp_editor( $policy, $editor_id, $settings );
$blog = get_option('tm_video_blog');
if(empty($blog))
	$blog = 'draft';
$email = (int) get_option('tm_video_email');
$reverse_order = (int) get_option('tm_video_reverse');
?>

<div style ="width: 50%; float: right; padding: 10px; background-color: #fff; margin: 15px;">
<h3><?php _e('How to Use This Tool','rsvpmaker-for-toastmasters');?></h3>
<img src="<?php echo plugins_url('rsvpmaker-for-toastmasters/copy_from_youtube.png') ?>" width="600" height="319">
<p><?php _e('You can view all the videos in your account, including the unlisted ones at ','rsvpmaker-for-toastmasters'); ?><a href="https://www.youtube.com/my_videos?o=U">https://www.youtube.com/my_videos?o=U</a>. <?php _e('Copy and paste the contents of the listing from YouTube into the box above labeled "Paste YouTube content here."','rsvpmaker-for-toastmasters')?></p>
<p><?php _e('This will be a messy copy and paste, but the important thing is that you highlight the titles of all the videos when copying from YouTube. The program will extract the titles and associated links to YouTube and output them in a neat format.','rsvpmaker-for-toastmasters'); ?></p>
<p><?php _e('If you check off the names of the speakers featured in the video, the title of the blog post will change from "Videos" to "Videos: Speaker 1, Speaker 2 ..." and this is also used as the subject line for the email. These default posts are meant as a starting point, and you always have the option of editing them further.','rsvpmaker-for-toastmasters'); ?></p>
<p><?php _e('You can also revise the policy message shown above, and the tool will remember your changes next time.','rsvpmaker-for-toastmasters'); ?></p>
</div>
<p>
<input type="radio" name="blog" value="draft" <?php if($blog == 'draft') echo ' checked="checked" '; ?> ><?php _e('Create draft blog post (members only)','rsvpmaker-for-toastmasters');?>
<br />
<input type="radio" name="blog" value="publish" <?php if($blog == 'publish') echo ' checked="checked" '; ?> ><?php _e('Create and publish blog post (members only)','rsvpmaker-for-toastmasters');?>
<br />
<input type="radio" name="blog" value="none" <?php if($blog == 'none') echo ' checked="checked" '; ?> ><?php _e('Do not create blog post','rsvpmaker-for-toastmasters');?>
</p>
<p>
<?php _e('Create email message','rsvpmaker-for-toastmasters');?> <input type="radio" name="email" value="1" <?php if($email) echo ' checked="checked" '; ?> ><?php _e('Yes','rsvpmaker-for-toastmasters');?> <input type="radio" name="email" value="0" <?php if(!$email) echo ' checked="checked" '; ?> ><?php _e('No','rsvpmaker-for-toastmasters');?>
</p>
<p>
<?php _e('Reverse order (oldest videos first)','rsvpmaker-for-toastmasters');?> <input type="radio" name="reverse_order" value="1" <?php if($reverse_order) echo ' checked="checked" '; ?> ><?php _e('Yes','rsvpmaker-for-toastmasters');?> <input type="radio" name="reverse_order" value="0" <?php if(!$reverse_order) echo ' checked="checked" '; ?> ><?php _e('No','rsvpmaker-for-toastmasters');?>
</p>
<?php
$blogusers = get_users('blog_id='.get_current_blog_id() );
    foreach ($blogusers as $user) {
	$userdata = get_userdata($user->ID);
	if($userdata->hidden_profile)
		continue;

	$index = preg_replace('/[^A-Za-z]/','',$userdata->last_name.$userdata->first_name.$userdata->user_login);
	$names[$index] = $userdata->first_name.' '.$userdata->last_name;
	}
	
	ksort($names);
	foreach ($names as $name)
		printf('<input type="checkbox" name="speakers[]" value="%s" /> %s <br />',$name,$name);
?>
<input type="submit" value="Post" />
</form>

<?php
$ptext = '';
$past = get_past_events(" post_content LIKE '%[toastmaster%' ", 10);
if($past)
foreach($past as $pst)
	{
		$ptext .= '<strong>'.$pst->date."</strong>\n";
		$sql = "SELECT *, meta_value as user_id FROM $wpdb->postmeta WHERE post_id=$pst->ID AND meta_key LIKE '_Speaker%'";
		$speakers = $wpdb->get_results($sql);
		if($speakers)
		foreach ($speakers as $row)
			{
				if(!empty($row->user_id) && is_numeric($row->user_id))
				{
				$user = get_userdata($row->user_id);
				$title = get_post_meta($pst->ID,'_title'.$row->meta_key,true);
				$pkey = get_post_meta($pst->ID,'_project'.$row->meta_key,true);
				$project = (!empty($pkey)) ? get_project_text($pkey) : '';
				$ptext .= sprintf("%s: %s\n%s\n%s at %s\n\n",$user->first_name.' '.$user->last_name,$title,$project,$pst->date,site_url());
				}
			}
	}
if(!empty($ptext))
	echo "<h2>Recent Speeches</h2>".wpautop($ptext);
}

function rsvptoast_email ($postdata, $rsvp_html, $rsvp_text) {
if(empty($postdata["guests"]) && empty($postdata["ex"]))
	return;

global $wpdb;
global $unsubscribed;
global $current_user;
$unsub = get_option('rsvpmail_unsubscribed');

if(!empty($postdata["guests"]))
{
//guests
$sql = "SELECT email FROM `".$wpdb->prefix."users_archive` WHERE `".$wpdb->prefix."users_archive`.guest AND user_id=0 ORDER BY updated DESC"; // limit?
$guests = $wpdb->get_results($sql);
if(!empty($guests))
{
printf('<p>Sending to %s guests</p>',sizeof($guests));
foreach($guests as $guest)
	{
	//printf('<div>Guest %s</div>',$guest->email);
	if(is_array($unsub) && in_array(strtolower($guest->email),$unsub))
		{
			$unsubscribed[] = $guest->email;
			continue;
		}
	$mail["to"] = $guest->email;
	$mail["from"] = (isset($_POST["user_email"])) ? $current_user->user_email : $_POST["from_email"];
	$mail["fromname"] =  stripslashes($_POST["from_name"]);
	$mail["subject"] =  stripslashes($_POST["subject"]);
	$mail["html"] = rsvpmaker_personalize_email($rsvp_html,$mail["to"],__('This message was sent to you as a guest of ','rsvpmaker').' '.$_SERVER['SERVER_NAME']);
	$mail["text"] = rsvpmaker_personalize_email($rsvp_text,$mail["to"],__('This message was sent to you as a guest of','rsvpmaker').' '.$_SERVER['SERVER_NAME']);
	$result = rsvpmailer($mail);
	}
} // end db lookup

}

if(!empty($postdata["ex"]))
{
//former members
$sql = "SELECT email FROM `".$wpdb->prefix."users_archive` LEFT JOIN `".$wpdb->prefix."users` ON `".$wpdb->prefix."users_archive`.user_id = ".$wpdb->prefix."users.ID WHERE `".$wpdb->prefix."users`.ID IS NULL AND user_id > 0 ORDER BY updated DESC"; // limit?
$exes = $wpdb->get_results($sql);
if(!empty($exes))
{
printf('<p>Sending to %s former members</p>',sizeof($exes));
foreach($exes as $ex)
	{
	//printf('<div>Ex member %s</div>',$ex->email);
	if(is_array($unsub) && in_array(strtolower($ex->email),$unsub))
		{
			$unsubscribed[] = $ex->email;
			continue;
		}
	$mail["to"] = $ex->email;
	$mail["from"] = (isset($_POST["user_email"])) ? $current_user->user_email : $_POST["from_email"];
	$mail["fromname"] =  stripslashes($_POST["from_name"]);
	$mail["subject"] =  stripslashes($_POST["subject"]);
	$mail["html"] = rsvpmaker_personalize_email($rsvp_html,$mail["to"],__('This message was sent to you as a guest of ','rsvpmaker').' '.$_SERVER['SERVER_NAME']);
	$mail["text"] = rsvpmaker_personalize_email($rsvp_text,$mail["to"],__('This message was sent to you as a guest of','rsvpmaker').' '.$_SERVER['SERVER_NAME']);
	$result = rsvpmailer($mail);
	}
} // end db lookup

}

}
add_action("rsvpmaker_email_send_ui_submit",'rsvptoast_email', 10, 3);

function rsvptoast_email_ui() {
?>
<div><input type="checkbox" name="guests" value="1"> <?php _e('Guests','rsvpmaker');?> </div>
<div><input type="checkbox" name="ex" value="1"> <?php _e('Former Members','rsvpmaker');?> </div>
<?php
}

add_action("rsvpmaker_email_send_ui_options",'rsvptoast_email_ui');

function rsvpmaker_special_toastmasters ($slug) {
if($slug != 'Agenda Layout')
	return;
echo '<p>'.__('This is an agenda layout. CSS coding can be customized below.','rsvpmaker-for-toastmasters').'</p>';
global $post;
$meetings = future_toastmaster_meetings(1);
if(!isset($meetings[0]->ID))
	return 'View the agenda of a current meeting to test this';
$permalink = get_permalink($meetings[0]->ID);
$permalink .= (strpos($permalink,'?')) ? '&' : '?';
$permalink .= "print_agenda=1";
echo '<p>';
printf('View the <a href="%s" target="_blank">agenda of a current meeting</a> to test your changes.',$permalink);
echo '</p>';

$css = get_post_meta($post->ID,'_rsvptoast_agenda_css',true);
echo '<p><textarea name="_rsvptoast_agenda_css" id="_rsvptoast_agenda_css" style="width: 100%" rows="20">'.$css.'</textarea>';
}

function save_rsvpmaker_special_toastmasters ( $post_id ) {
	if(isset($_POST["_rsvptoast_agenda_css"]))
		update_post_meta($post_id,"_rsvptoast_agenda_css",stripslashes($_POST["_rsvptoast_agenda_css"]));
}

add_action('save_post','save_rsvpmaker_special_toastmasters');

add_action('rsvpmaker_special_metabox','rsvpmaker_special_toastmasters');

function tmlayout_club_name ($atts) {
	return get_bloginfo('name');
}
function tmlayout_meeting_date ($atts) {
	global $post;
	global $rsvp_options;
	$datestring = get_rsvp_date($post->ID);
	if(!empty($datestring))
	return strftime($rsvp_options["long_date"], strtotime($datestring) );
}
function tmlayout_sidebar($atts) {
global $post;
	$recur = get_post_meta($post->ID, "_meet_recur", true);
	$template_sidebar = ($recur) ? get_post_meta($recur,'_tm_sidebar', true) : '';
	$post_sidebar = get_post_meta($post->ID,'_tm_sidebar', true);
	$option_sidebar = get_option('_tm_sidebar');
	
	if(!empty($post_sidebar)){
		$sidebar = $post_sidebar;
		$officers = get_post_meta($post->ID,"_sidebar_officers");
	}
	elseif(!empty($template_sidebar))
		{
		$sidebar = $template_sidebar;
		$officers = get_post_meta($recur,'_sidebar_officers', true);
		}
	elseif(!empty($option_sidebar))	
		{
		$sidebar = $option_sidebar;
		$officers = get_option('_sidebar_officers');
		}
	else
		{
		$sidebar = __('<p>Sidebar text not set</p>','rsvpmaker-for-toastmasters');
		}

	if(!empty($custom["_tm_sidebar"][0])){
		$sidebar = $custom["_tm_sidebar"][0];
		$officers = $custom["_sidebar_officers"][0];
	}

$atts["sep"] = 'br';
if(isset($officers))
{
	echo "<p>";
	$sidebar .= toastmaster_officers($atts);
	echo "</p>";
}

return wpautop(trim(str_replace('&nbsp;',' ',$sidebar)));
}
function tmlayout_main($atts) {
	global $post;
	$layout = get_option('rsvptoast_agenda_layout');
	if($post->ID == $layout)
		{
		$meetings = future_toastmaster_meetings(1);
		if(!$meetings[0]->ID)
			return 'View the agenda of a current meeting to test this';
		$permalink = get_permalink($meetings[0]->ID);
		$permalink .= (strpos($permalink,'?')) ? '&' : '?';
		$permalink .= "print_agenda=1";
		return sprintf('View the <a href="%s">agenda of a current meeting</a> to test this',$permalink);
		}
	return do_shortcode($post->post_content);
}

add_shortcode('tmlayout_club_name','tmlayout_club_name');
add_shortcode('tmlayout_meeting_date','tmlayout_meeting_date');
add_shortcode('tmlayout_sidebar','tmlayout_sidebar');
add_shortcode('tmlayout_main','tmlayout_main');
add_shortcode('tmlayout_intros','speech_intros_shortcode');

add_action('rsvp_recorded','rsvp_to_member_auto');

function rsvp_to_member_auto($rsvp) {
	if(isset($_POST['rsvp_to_member_auto']))
	{
		$blog_id = get_current_blog_id();
		$user = get_user_by('email',$rsvp["email"]);
		if($user)
			$member = is_user_member_of_blog($user->ID);
		else
			$member = false;
		if(!$user || !$member)
			{
				if($user && !$member)
					{
					add_user_to_blog($blog_id,$user->ID,'subscriber');
					}
				else
					{
					$userdata["first_name"] = $rsvp["first"];
					$userdata["last_name"] = $rsvp["last"];
					$userdata["user_email"] = $rsvp["email"];
					ob_start();
					add_member_user($userdata, true);
					$log = ob_get_clean();
					}
			}
	}
}

function rsvp_to_member () {
$hook = tm_admin_page_top(__('RSVP List to Member','rsvpmaker-for-toastmasters'));
global $wpdb;
$blog_id = get_current_blog_id();

if(isset($_POST["add"]))
{
	print_r($_POST["add"]);
		
	foreach($_POST["add"] as $index => $check)
	{
		$user["first_name"] = $_POST["first_name"][$index];		
		$user["last_name"] = $_POST["last_name"][$index];		
		$user["user_email"] = $_POST["user_email"][$index];
		add_member_user($user, true);
	}
}

if(isset($_POST["add_to_site"]))
{
	foreach($_POST["add_to_site"] as $user_id)
	{
		add_user_to_blog($blog_id,$user_id,'subscriber');		
	}
}


$table = $wpdb->prefix.'rsvpmaker';
?>
<form action="<?php echo admin_url('users.php?page=rsvp_to_member'); ?>" method="post">
<?php
$results = $wpdb->get_results('SELECT * FROM '.$table.' ORDER BY id');
	$count = 0;

foreach($results as $row)
	{
		$user = get_user_by('email',$row->email);
		if($user)
			$member = is_user_member_of_blog($user->ID);
		else
			$member = false;
		
		//if they're both users and members already, don't list them
		if(!$user || !$member)
			{
				if($user && !$member)
					{
						printf('<p><input type="checkbox" name="add_to_site[]" value="%d"> Add To Site %s %s %s</p>',$user->ID,$row->first,$row->last,$row->email);
					}
				else
					{
					echo "\n";
						printf('<p><input type="checkbox" name="add[%d]" value="1"> Add User<br />%s<input type="text" name="first_name[%d]" value="%s" /><br />%s<input type="text" name="last_name[%d]" value="%s" /><br />%s<input type="text" name="user_email[%d]" value="%s" /></p>',$count,__('First Name','rsvpmaker-for-toastmasters'),$count,$row->first,__('Last Name','rsvpmaker-for-toastmasters'),$count,$row->last,__('Email','rsvpmaker-for-toastmasters'),$count,$row->email);
					echo "\n";
					
					echo get_rsvp_date($row->event). "<br />";
					
					$details = unserialize($row->details);

					foreach($details as $name => $value)
					{
						if($value) {
							echo $name.': '.esc_attr($value)."<br />";
						}
					}
					if($row->note)
						echo "note: " . nl2br(esc_attr($row->note))."<br />";
					}				
			$count++;
			}		
	}
submit_button();
?>
</form>
<?php
tm_admin_page_bottom($hook);
}

add_filter('rsvpmaker_meta_update_from_template','rsvpmaker_meta_update_from_template_tm');

function rsvpmaker_meta_update_from_template_tm($post_meta_infos) {
$toast_roles = array(
'Ah_Counter',
'Body_Language_Monitor',
'Evaluator',
'General_Evaluator',
'Grammarian',
'Humorist',
'Speaker',
'Topics_Master',
'Table_Topics',
'Timer',
'Toastmaster_of_the_Day',
'Vote_Counter');

			foreach ($post_meta_infos as $index => $meta_info) {
				$meta_key = $meta_info->meta_key;
				foreach($toast_roles as $role)
					{
					if(strpos($meta_key,$role))
						{
						unset($post_meta_infos[$index]);
						break;
						}
					}
			}
return $post_meta_infos;
}

function rsvp_yes_emails_filter_users ($emails)
{
$users = get_users();
foreach($users as $user)
	{
	if(in_array($user->user_email,$emails))
		unset($emails[$user->user_email]);
	}
return $emails;
}
add_filter('rsvp_yes_emails','rsvp_yes_emails_filter_users');

function wpt_notification_forms ($template_forms) {
$template_forms['role_reminder'] = array('subject' => 'Your role: [wptrole] for [rsvpdate]','body' => "You are scheduled to serve as [wptrole] for [rsvpdate].\n\nIf for any reason you cannot fulfill this duty, please post an update to the agenda\n\n[wptagendalink]\n\n\n\n[wpt_tod] ");
$template_forms['Toastmaster of the Day'] = array('subject' => 'You are the Toastmaster of the Day for [rsvpdate]','body' => "You are scheduled to serve as [wptrole] for [rsvpdate].\n\nHere is the lineup so far:\n\n[wp4t_assigned_open]");
$template_forms['Speaker'] = array('subject' => 'You are signed up to speak on [rsvpdate]','body' => "You are scheduled to speak on [rsvpdate].\n\n[wpt_speech_details]\n\nIf for any reason you cannot, please post an update to the agenda\n\n[wptagendalink]\n\n[wpt_tod]");
$template_forms['Evaluator'] = array('subject' => 'You are signed up as an evaluator for [rsvpdate]','body' => "You are signed up as an evaluator for [rsvpdate].\n\n[speaker_evaluator]\n\n[evaluation_links]\n\n[tmlayout_intros]\n\n\n\n[wpt_speakers]\n\nEvaluation Team:\n\n[wpt_evaluators]\n\n[wpt_general_evaluator] ");
$template_forms['General Evaluator'] = array('subject' => 'You are signed up as an evaluator for [rsvpdate]','body' => "You are signed up as an evaluator for [rsvpdate].\n\n[speaker_evaluator]\n\n[evaluation_links]\n\n[wpt_speakers]\n\nEvaluation Team:\n\n[wpt_evaluators]\n\n[wpt_general_evaluator] ");
return $template_forms;
}

add_filter('rsvpmaker_notification_template_forms','wpt_notification_forms');

function wpt_sample_data ($sample_data)
{
$sample_data['wptrole'] = 'Ah Counter';
$sample_data['wptagendalink'] = '<a href="https://demo.toastmost.org/rsvpmaker/weekly-meeting-2020-1-1/">https://demo.toastmost.org/rsvpmaker/weekly-meeting-2020-1-1/</a>';
$sample_data['wpt_tod'] = '<h3>Toastmaster of the Day: Abraham Lincoln</h3>
<div>Email: <a href="mailto:abrahamlincoln@example.com">abrahamlincoln@example.com</a></div>';
$sample_data['wpt_speakers'] = '<h3>Speaker: Zoe Heriot</h3>
<div>Home Phone: 954-555-1212</div>
<div>Work Phone: 202-555-1212</div>
<div>Email: <a href="mailto:Zoe@example.com">Zoe@example.com</a></div>
	
<h3>Speaker: Grace Holloway</h3>
<div>Home Phone: 954-555-1212</div>
<div>Work Phone: 202-555-1212</div>
<div>Email: <a href="mailto:Grace@example.com">Grace@example.com</a></div>';

$sample_data['wpt_evaluators'] = '<h3>Evaluator: Thomas Jefferson</h3>
<div>Email: <a href="mailto:thomasjefferson@example.com">thomasjefferson@example.com</a></div>

<h3>Evaluator: Martha Jones</h3>

<div>Home Phone: 954-555-1212</div>
<div>Work Phone: 202-555-1212</div>
<div>Email: <a href="mailto:Martha@example.com">Martha@example.com</a></div>

<h3>Evaluator: Johnny Lately</h3>

<div>Email: <a href="mailto:johnny@example.com">johnny@example.com</a></div>';

$sample_data['wpt_general_evaluator'] = '<h3>General Evaluator: James Madison</h3>

<div>Home Phone: (575)555-0000</div>
<div>Work Phone: (954)555-1212</div>
<div>Mobile Phone: (500)111-2222</div>
<div>Email: <a href="mailto:Madison@example.com">Madison@example.com</a></div>';
$sample_data['wpt_officers'] = '<h3>President: George Washington</h3>

<div>Home Phone: (575)555-0000</div>
<div>Work Phone: (954)555-1212</div>
<div>Mobile Phone: (500)111-2222</div>
<div>Email: <a href="mailto:georgewashington@example.com">georgewashington@example.com</a></div>

<h3>VP Education: Martin Van Buren</h3>

<div>Home Phone: (575)555-0000</div>
<div>Work Phone: (954)555-1212</div>
<div>Mobile Phone: (500)111-2222</div>
<div>Email: <a href="mailto:VanBuren@example.com">VanBuren@example.com</a></div>';
$sample_data['wpt_agenda'] = '<div class="timewrap">
<div class="timeblock"> 7:00 PM</div>
<div class="timed_content">
<div class="role-agenda-item">
<p><strong>Invocation: </strong></p>
</div>
</div>
</div>
<div class="timewrap">
<div class="timeblock"> 7:02 PM</div>
<div class="timed_content">
<p class="agenda_note" style=";">President or Presiding Officer leads the self-introductions Introduces the Toastmaster of the Day</p>
</div>
</div>
<div class="timewrap">
<div class="timeblock"> 7:12 PM</div>
<div class="timed_content">
<div class="role-agenda-item">
<p><strong>Toastmaster of the Day: </strong><span class="member-role">Abraham Lincoln</span><br /><em>Introduces supporting roles. Leads the meeting.</em></p>
</div>
</div>
</div>
<div class="timewrap">
<div class="timeblock"></div>
<div class="timed_content">
<div class="role-agenda-item" style="margin-left: 15px;">
<p><strong>Ah Counter: </strong><span class="member-role">Clara Oswald</span></p>
</div>
</div>
</div>
<div class="timewrap">
<div class="timeblock"></div>
<div class="timed_content">
<div class="role-agenda-item" style="margin-left: 15px;">
<p><strong>Timer: </strong><span class="member-role">Amy Pond, ACS, CL</span></p>
</div>
</div>
</div>
<div class="timewrap">
<div class="timeblock"></div>
<div class="timed_content">
<div class="role-agenda-item" style="margin-left: 15px;">
<p><strong>Vote Counter: </strong><span class="member-role">Franklin Roosevelt</span></p>
</div>
</div>
</div>
<div class="timewrap">
<div class="timeblock"></div>
<div class="timed_content">
<div class="role-agenda-item" style="margin-left: 15px;">
<p><strong>Body Language Monitor: </strong><span class="member-role">Rory Williams</span></p>
</div>
</div>
</div>
<div class="timewrap">
<div class="timeblock"></div>
<div class="timed_content">
<div class="role-agenda-item" style="margin-left: 15px;">
<p><strong>Videographer: </strong></p>
</div>
</div>
</div>
<div class="timewrap">
<div class="timeblock"></div>
<div class="timed_content">
<div class="role-agenda-item" style="margin-left: 15px;">
<p><strong>Grammarian: </strong><br /><em>Leads word of the day contest.</em></p>
</div>
</div>
</div>
<div class="timewrap">
<div class="timeblock"> 7:17 PM</div>
<div class="timed_content">
<div class="role-agenda-item">
<p><strong>Topics Master: </strong><span class="member-role">Thomas Jefferson</span></p>
</div>
</div>
</div>
<p class="agenda_note" style=";">5 minute break</p>
<div class="timewrap">
<div class="timeblock"></div>
<div class="timed_content">
<div class="role-agenda-item">
<p><strong>Listener: </strong></p>
</div>
</div>
</div>
<div class="timewrap">
<div class="timeblock"> 7:32 PM</div>
<div class="timed_content">
<div class="role-agenda-item">
<p><strong>Speaker: </strong><span class="member-role">George Washington: The importance of being honest</span></p>
<div class="speaker-details">
<div id="manual"><strong>SPEECHES BY MANAGEMENT: Manage And Motivate (10 to 12 min)</strong></div>
</div>
</div>
<div class="role-agenda-item">
<p><strong>Speaker: </strong><span class="member-role">Teddy Roosevelt: The speech must go on</span></p>
<div class="speaker-details">
<div id="manual"><strong>COMPETENT COMMUNICATION: Persuade with Power (5 to 7 min)</strong></div>
</div>
</div>
<div class="role-agenda-item">
<p><strong>Speaker: </strong></p>
</div>
</div>
</div>
<div class="timewrap">
<div class="timeblock"></div>
<div class="timed_content">
<div class="role-agenda-item">
<p><strong>Backup Speaker: </strong></p>
</div>
</div>
</div>
<div class="timewrap">
<div class="timeblock"> 8:00 PM</div>
<div class="timed_content">
<div class="role-agenda-item">
<p><strong>General Evaluator: </strong><span class="member-role">Barbara Wright</span><br /><em>Explains the importance of evaluations. Introduces Evaluators.</em></p>
</div>
</div>
</div>
<div class="timewrap">
<div class="timeblock"> 8:01 PM</div>
<div class="timed_content">
<div class="role-agenda-item">
<p><strong>Evaluator: </strong><span class="member-role">James K. Polk</span></p>
</div>
<div class="role-agenda-item">
<p><strong>Evaluator: </strong><span class="member-role">Dodo Chaplet</span></p>
</div>
<div class="role-agenda-item">
<p><strong>Evaluator: </strong><span class="member-role">James A. Garfield</span></p>
</div>
</div>
</div>
<div class="timewrap">
<div class="timeblock"> 8:11 PM</div>
<div class="timed_content">
<p class="agenda_note" style=";">General Evaluator asks for reports from the Grammarian, Ah Counter, and Body Language Monitor. General Evaluator gives an overall assessment of the meeting.</p>
</div>
</div>
<div class="timewrap">
<div class="timeblock"> 8:16 PM</div>
<div class="timed_content">
<p class="agenda_note" style=";">Toastmaster of the Day presents the awards.</p>
</div>
</div>
<div class="timewrap">
<div class="timeblock"> 8:21 PM</div>
<div class="timed_content">
<p class="agenda_note" style=";">President wraps up the meeting.</p>
</div>
</div>';
$sample_data['wpt_unassigned_members'] = '<h2>Members with No Assignment</h2>
<h3>Franklin Pierce</h3>

<div>Home Phone: (575)555-0000</div>
<div>Work Phone: (954)555-1212</div>
<div>Mobile Phone: (500)111-2222</div>
<div>Email: <a href="mailto:Pierce@example.com">Pierce@example.com</a></div>
	
<h3>James K. Polk</h3>

<div>Home Phone: (575)555-0000</div>
<div>Work Phone: (954)555-1212</div>
<div>Mobile Phone: (500)111-2222</div>
<div>Email: <a href="mailto:Polk@example.com">Polk@example.com</a></div>
	
<h3>Liz Shaw</h3>

<div>Home Phone: 954-555-1212</div>
<div>Work Phone: 202-555-1212</div>
<div>Email: <a href="mailto:Liz@example.com">Liz@example.com</a></div>

<h3>Clone Sarah Jane Smith</h3>

<div>Home Phone: 954-555-1212</div>
<div>Work Phone: 202-555-1212</div>
<div>Mobile Phone: 757-555-1212</div>
<div>Email: <a href="mailto:CloneSarah@example.com">CloneSarah@example.com</a></div>

<h3>Mickey Smith</h3>

<div>Home Phone: 954-555-1212</div>
<div>Work Phone: 202-555-1212</div>
<div>Email: <a href="mailto:Mickey@example.com">Mickey@example.com</a></div>';
$sample_data['speaker_evaluator'] = '<table>
<tr><th>Speaker</th><th>Evaluator</th></tr>
<tr><td>George Washington</td><td>James K. Polk</td></tr>
<tr><td>Teddy Roosevelt</td><td>Dodo Chaplet</td></tr>
</table>';
$sample_data['evaluation_links'] = '<p><a href="https://demo.toastmost.org/wp-admin/admin.php?page=wp4t_evaluations&speaker=307&meeting_id=569&project=SPEECHES BY MANAGEMENT 3">George Washington, Manage And Motivate (10 to 12 min), May 5, 2017</a></p><p>Title: The importance of being honest</p>
<p>The stories about me are all true. The stories I told my men at Valley Forge were mostly true. We got through it and that is all that counts. Let me tell you about it.</p>
<p><a href="https://demo.toastmost.org/wp-admin/admin.php?page=wp4t_evaluations&speaker=309&meeting_id=569&project=COMPETENT COMMUNICATION 9">Teddy Roosevelt, Persuade with Power (5 to 7 min), May 5, 2017</a></p><p>Title: The speech must go on</p>
<p>Let me tell you the story about the day I was shot and finished my speech anyway.</p>';
$sample_data['tmlayout_intros'] = '<div style="margin-bottom: 20px; padding: 10px; border: thin dotted #000;"><h2>George Washington</h2>
<p>SPEECHES BY MANAGEMENT: Manage And Motivate (10 to 12 min)</p>
<p>Title: The importance of being honest</p>
<p>Introduction: The stories about me are all true. The stories I told my men at Valley Forge were mostly true. We got through it and that is all that counts. Let me tell you about it.</p>
</div><div style="margin-bottom: 20px; padding: 10px; border: thin dotted #000;"><h2>Teddy Roosevelt</h2>
<p>COMPETENT COMMUNICATION: Persuade with Power (5 to 7 min)</p>
<p>Title: The speech must go on</p>
<p>Introduction: Let me tell you the story about the day I was shot and finished my speech anyway.</p>
</div>';
return $sample_data;
}
add_filter('rsvpmaker_notification_sample_data','wpt_sample_data');

function wpt_notifications_doc () {
?>
<h3>Additional Codes for Toastmasters Agenda Notifications</h3>
<p>[wptrole] the member's meeting role
<p>[wptagendalink] link to the meeting agenda</p>
<p>[wpt_tod] name and contact info for Toastmasters of the Day</p>
<p>[wp4t_assigned_open] agenda with contact info for participants, plus a listing of members with no assignment</p>
<p>[speaker_evaluator] listing of the speakers and evaluators</p>
<p>[evaluation_links] links to the online forms</p>
<p>[tmlayout_intros] speech introductions for speakers</p>
<p>[wpt_speakers] listing of speakers</p>
<p>[wpt_evaluators] listing of evaluators</p>
<p>[wpt_general_evaluator] general evaluator</p>

<p>You can create a custom notification for a specific role, such as Timer or Ah Counter, by creating a custom notification template with the name of that role (as used on the agenda) in the Custom label field.</p>

<?php
}

add_action('rsvpmaker_notification_templates_doc','wpt_notifications_doc');

function wpt_officers () {
global $tmagendadata;
global $post;
if(isset($tmagendadata['wpt_officers']))
	return $tmagendadata['wpt_officers'];
$tmagendadata['wpt_officers'] = "<h3>Officers</h3>\n";

$wp4toastmasters_officer_ids = get_option('wp4toastmasters_officer_ids');
$wp4toastmasters_officer_titles = get_option('wp4toastmasters_officer_titles');

foreach($wp4toastmasters_officer_ids as $index => $id)
	{
	if(!$id)
		continue;
	$title = $wp4toastmasters_officer_titles[$index];
$userdata = get_userdata($id);
$contact = '';
$contactmethods['home_phone'] = __("Home Phone",'rsvpmaker-for-toastmasters');
$contactmethods['work_phone'] = __("Work Phone",'rsvpmaker-for-toastmasters');
$contactmethods['mobile_phone'] = __("Mobile Phone",'rsvpmaker-for-toastmasters');
$contactmethods['user_email'] = __("Email",'rsvpmaker-for-toastmasters');
foreach($contactmethods as $name => $value)
{
if(strpos($name,'phone') && !empty($userdata->$name) )
	{
	$contact .= sprintf("<div>%s: %s</div>\n",$value,$userdata->$name);
	}
}
$contact .= sprintf('<div>'.__("Email",'rsvpmaker-for-toastmasters').': <a href="mailto:%s">%s</a></div>'."\n",$userdata->user_email,$userdata->user_email);
$tmagendadata['wpt_officers'] .= sprintf('<div><strong>%s: %s %s</strong></div>',$title, $userdata->first_name, $userdata->last_name).$contact;
	}
return $tmagendadata['wpt_officers'];
}
add_shortcode('wpt_officers','wpt_officers');

function speaker_evaluator () {
global $tmagendadata;
global $post;
global $wpdb;
if(isset($tmagendadata['speaker_evaluator']))
	return $tmagendadata['speaker_evaluator'];
$tmagendadata['speaker_evaluator'] = '';
$high = 0;
$sql = "SELECT * FROM $wpdb->postmeta WHERE post_id=$post->ID AND (meta_key LIKE '_Speaker%' OR meta_key LIKE '_Evaluator%') ";
$results = $wpdb->get_results($sql);
foreach($results as $row)
	{
	$assigned = $row->meta_value;
	$slug = $row->meta_key;
	$p = (int) preg_replace('/[^0-9]/','',$slug);
	if(strpos($slug,'_Speaker') !== false)
		{
		$userdata = get_userdata($assigned);
		$speaker[$p] = $userdata->first_name.' '.$userdata->last_name;
		$high = ($p > $high) ? $p : $high;
		}
	if(strpos($slug,'_Evaluator') !== false)
		{
		$userdata = get_userdata($assigned);
		$evaluator[$p] = $userdata->first_name.' '.$userdata->last_name;
		$high = ($p > $high) ? $p : $high;
		}
	}
$tmagendadata['speaker_evaluator'] = '<table><tr><th style="width: 200px; text-align: left">Speaker</th><th style="width: 200px; text-align: left">Evaluator</th></tr>';
for($i = 1; $i <= $high; $i++)
	{
	$tmagendadata['speaker_evaluator'] .= '<tr><td>';
	if(empty($speaker[$i]))
		$tmagendadata['speaker_evaluator'] .=  'Open';
	else
		$tmagendadata['speaker_evaluator'] .= $speaker[$i];
	$tmagendadata['speaker_evaluator'] .= '</td><td>';
	if(empty($evaluator[$i]))
		$tmagendadata['speaker_evaluator'] .= 'Open';
	else
		$tmagendadata['speaker_evaluator'] .= $evaluator[$i];
	$tmagendadata['speaker_evaluator'] .= '</td></tr>';
	}
	$tmagendadata['speaker_evaluator'] .= '</table>';
return $tmagendadata['speaker_evaluator'];
}
add_shortcode('speaker_evaluator','speaker_evaluator');

function evaluation_links() {
global $wpdb;
global $post;
global $tmagendadata;
if(isset($tmagendadata['evaluation_links']))
	return $tmagendadata['evaluation_links'];

$is_current = false;
$tmagendadata['evaluation_links'] = '';
$future = get_future_events ("", 1);
if($future)
foreach($future as $meet)
{
	$sql = "SELECT * FROM $wpdb->postmeta WHERE post_id=".$post->ID." AND meta_key LIKE '_Speak%' ORDER BY meta_key";
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
		$speaker_name = get_user_meta($speaker,'first_name',true).' '.get_user_meta($speaker,'last_name',true);
		$tmagendadata['evaluation_links'] .= sprintf('<p><a href="%s&speaker=%d&meeting_id=%d&project=%s">%s, %s, %s</a></p>',admin_url('admin.php?page=wp4t_evaluations'),$speaker,$meet->ID,$project_index,$speaker_name, $project,$meet->date);
		$text = get_post_meta($meet->ID, '_title'.$role, true);
		if(!empty($text))
			$tmagendadata['evaluation_links'] .= '<p>Title: '.$text."</p>\n";
		$text = get_post_meta($meet->ID, '_intro'.$role, true);
		if(!empty($text))
			$tmagendadata['evaluation_links'] .= wpautop($text);
		}
}

return $tmagendadata['evaluation_links'];
}

add_shortcode('evaluation_links','evaluation_links');

function wpt_speakers () {
global $tmagendadata;
global $post;
global $wpdb;
if(isset($tmagendadata['wpt_speakers']))
	return $tmagendadata['wpt_speakers'];
$tmagendadata['wpt_speakers'] = '';
$sql = "SELECT * FROM $wpdb->postmeta WHERE post_id=$post->ID AND meta_key LIKE '_Speaker%' ";
$results = $wpdb->get_results($sql);
foreach($results as $row)
	{
	$assigned = $row->meta_value;
	$slug = $row->meta_key;
$userdata = get_userdata($assigned);
$contact = '';
$contactmethods['home_phone'] = __("Home Phone",'rsvpmaker-for-toastmasters');
$contactmethods['work_phone'] = __("Work Phone",'rsvpmaker-for-toastmasters');
$contactmethods['mobile_phone'] = __("Mobile Phone",'rsvpmaker-for-toastmasters');
$contactmethods['user_email'] = __("Email",'rsvpmaker-for-toastmasters');
foreach($contactmethods as $name => $value)
{
if(strpos($name,'phone') && !empty($userdata->$name) )
	{
	$contact .= sprintf("<div>%s: %s</div>\n",$value,$userdata->$name);
	}
}
$contact .= sprintf('<div>'.__("Email",'rsvpmaker-for-toastmasters').': <a href="mailto:%s">%s</a></div>'."\n",$userdata->user_email,$userdata->user_email);
$tmagendadata['wpt_speakers'] .= sprintf('<div><strong>Speaker: %s %s</strong></div>',$userdata->first_name, $userdata->last_name).$contact;
	}
return $tmagendadata['wpt_speakers'];
}
add_shortcode('wpt_speakers','wpt_speakers');

function wpt_evaluators () {
global $tmagendadata;
global $post;
global $wpdb;
if(isset($tmagendadata['wpt_evaluators']))
	return $tmagendadata['wpt_evaluators'];
$tmagendadata['wpt_evaluators'] = '';
$sql = "SELECT * FROM $wpdb->postmeta WHERE post_id=$post->ID AND meta_key LIKE '_Evaluator%' ";
$results = $wpdb->get_results($sql);
foreach($results as $row)
	{
	$assigned = $row->meta_value;
	$slug = $row->meta_key;
$userdata = get_userdata($assigned);
$contact = '';
$contactmethods['home_phone'] = __("Home Phone",'rsvpmaker-for-toastmasters');
$contactmethods['work_phone'] = __("Work Phone",'rsvpmaker-for-toastmasters');
$contactmethods['mobile_phone'] = __("Mobile Phone",'rsvpmaker-for-toastmasters');
$contactmethods['user_email'] = __("Email",'rsvpmaker-for-toastmasters');
foreach($contactmethods as $name => $value)
{
if(strpos($name,'phone') && !empty($userdata->$name) )
	{
	$contact .= sprintf("<div>%s: %s</div>\n",$value,$userdata->$name);
	}
}
$contact .= sprintf('<div>'.__("Email",'rsvpmaker-for-toastmasters').': <a href="mailto:%s">%s</a></div>'."\n",$userdata->user_email,$userdata->user_email);
$tmagendadata['wpt_evaluators'] .= sprintf('<div><strong>Evaluator: %s %s</strong></div>',$userdata->first_name, $userdata->last_name).$contact;
	}
return $tmagendadata['wpt_evaluators'];
}
add_shortcode('wpt_evaluators','wpt_evaluators');

function wpt_general_evaluator () {
global $tmagendadata;
global $post;
global $tmroles;
if(isset($tmagendadata['wpt_general_evaluator']))
	return $tmagendadata['wpt_general_evaluator'];
$ge_id = get_post_meta($post->ID,'_General_Evaluator_1',true);

if(empty($ge_id))
	return __('General Evaluator not yet assigned','rsvpmaker-for-toastmasters');

$userdata = get_userdata($ge_id);
$contact = '';
$contactmethods['home_phone'] = __("Home Phone",'rsvpmaker-for-toastmasters');
$contactmethods['work_phone'] = __("Work Phone",'rsvpmaker-for-toastmasters');
$contactmethods['mobile_phone'] = __("Mobile Phone",'rsvpmaker-for-toastmasters');
$contactmethods['user_email'] = __("Email",'rsvpmaker-for-toastmasters');
foreach($contactmethods as $name => $value)
{
if(strpos($name,'phone') && !empty($userdata->$name) )
	{
	$contact .= sprintf("<div>%s: %s</div>\n",$value,$userdata->$name);
	}
}
$contact .= sprintf('<div>'.__("Email",'rsvpmaker-for-toastmasters').': <a href="mailto:%s">%s</a></div>'."\n",$userdata->user_email,$userdata->user_email);

return $tmagendadata['wpt_general_evaluator'] = sprintf('<div><strong>General Evaluator %s %s</strong></div>',$userdata->first_name, $userdata->last_name).$contact;
}
add_shortcode('wpt_general_evaluator','wpt_general_evaluator');

function wpt_tod () {
global $tmagendadata;
global $post;
if(!empty($tmagendadata['wpt_tod']))
	return $tmagendadata['wpt_tod'];
$toastmaster = get_post_meta($post->ID,"_Toastmaster_of_the_Day_1",true);
if($toastmaster)
	{
	$userdata = get_userdata($toastmaster);
	$toastmaster_email = $userdata->user_email;
	$contact = '';
	$contactmethods['home_phone'] = __("Home Phone",'rsvpmaker-for-toastmasters');
	$contactmethods['work_phone'] = __("Work Phone",'rsvpmaker-for-toastmasters');
	$contactmethods['mobile_phone'] = __("Mobile Phone",'rsvpmaker-for-toastmasters');
	$contactmethods['user_email'] = __("Email",'rsvpmaker-for-toastmasters');
	foreach($contactmethods as $name => $value)
	{
	if(strpos($name,'phone') && !empty($userdata->$name) )
		{
		$contact .= sprintf("<div>%s: %s</div>\n",$value,$userdata->$name);
		}
}
$contact .= sprintf('<div>'.__("Email",'rsvpmaker-for-toastmasters').': <a href="mailto:%s">%s</a></div>'."\n",$userdata->user_email,$userdata->user_email);

return $tmagendadata['wpt_tod'] = sprintf('<div><strong>Toastmaster of the Day %s %s</strong></div>',$userdata->first_name, $userdata->last_name).$contact;
	}
else
	return __('Toastmasters of the Day not yet assigned','rsvpmaker-for-toastmasters');
}
add_shortcode('wpt_tod','wpt_tod');

function wptagendalink () {
global $tmagendadata;
global $post;
if(isset($tmagendadata['wptagendalink']))
	return $tmagendadata['wptagendalink'];
$permalink = get_permalink($post->ID);
return $tmagendadata['wptagendalink'] = sprintf('%s<br /><a href="%s">%s</a>',__('Agenda','rsvpmaker-for-toastmasters'),$permalink,$permalink);
}
add_shortcode('wptagendalink','wptagendalink');

add_shortcode('wp4t_assigned_open','wp4t_assigned_open');

?>