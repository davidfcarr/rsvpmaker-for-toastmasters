<?php
/*
Plugin Name: RSVPMaker for Toastmasters
Plugin URI: http://wp4toastmasters.com
Description: This Toastmasters-specific extension to the RSVPMaker events plugin adds role signups and member performance tracking. Better Toastmasters websites!
Author: David F. Carr
Version: 3.8.2
Tags: Toastmasters, public speaking, community, agenda
Author URI: http://www.carrcommunications.com
Text Domain: rsvpmaker-for-toastmasters
Domain Path: /translations
*/

function rsvptoast_load_plugin_textdomain() {
    load_plugin_textdomain( 'rsvpmaker-for-toastmasters', FALSE, basename( dirname( __FILE__ ) ) . '/translations/' );
}
add_action( 'plugins_loaded', 'rsvptoast_load_plugin_textdomain' );

include "tm-reports.php";
include "contest.php";
include "utility.php";
include 'toastmasters-privacy.php';
include 'tm-online-application.php';
include 'api.php';
include 'mailster.php';
function wpt_gutenberg_check () {
global $carr_gut_test;
if(function_exists('register_block_type') && !isset($carr_gut_test))
require_once plugin_dir_path( __FILE__ ) . 'gutenberg/src/init.php';	
}
add_action('plugins_loaded','wpt_gutenberg_check');

if(is_admin())
{
	global $rsvp_options;
	if(!function_exists('do_blocks'))
		include 'mce_shortcode.php';
}

if(isset($_GET['email_agenda']))
{
	global $email_context;
	$email_context = true;
}

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
add_action('admin_init','wp4t_cron_nudge_setup');

function profile_richtext () {
if(strpos($_SERVER['REQUEST_URI'],'profile.php') || strpos($_SERVER['REQUEST_URI'],'user-edit.php')) 
echo '<script src="//cdn.tinymce.com/4/tinymce.min.js"></script> 
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

$pdir = str_replace('rsvpmaker-for-toastmasters/','',plugin_dir_path( __FILE__ ));
if(!is_plugin_active('rsvpmaker/rsvpmaker.php')){
	if(file_exists($pdir.'rsvpmaker/rsvpmaker.php'  ) )
		echo '<div ><p>'.sprintf(__('The RSVPMaker plugin is required for all Toastmasters functions. RSVPMaker is installed but must be activated. <a href="%s#name">Activate now</a>','rsvpmaker-for-toastmasters'),admin_url('plugins.php?s=rsvpmaker') )."</p></div>\n";
	else
		echo  '<div><p>'.sprintf(__('The RSVPMaker plugin is required for all Toastmasters functions. RSVPMaker must be installed and activated. <a href="%s">Install now</a>','rsvpmaker-for-toastmasters'),admin_url('plugin-install.php?tab=search&s=rsvpmaker#plugin-filter'))."</p></div>\n";
return; // if this is not configured, the rest doesn't matter
}	

global $current_user;
global $wpdb;
$wp4toastmasters_mailman = get_option('wp4toastmasters_mailman');
$wp4toastmasters_member_message = get_option('wp4toastmasters_member_message');
if(!empty($wp4toastmasters_member_message))
	$wp4toastmasters_member_message = wpautop($wp4toastmasters_member_message);

?>
<p><?php echo sprintf(__('You are viewing the private members-only area of the website. For a basic orientation, see the <a href="%s">welcome page</a>.','rsvpmaker-for-toastmasters'),admin_url('index.php?page=toastmasters_welcome') ); ?>
<br /></p>

<?php
$status = wp4t_get_member_status($current_user->ID);
if(!empty($status))
	$status = ' - Current status: '.$status;
printf('<p><a href="%s">%s</a> (%s) %s</p>',admin_url('profile.php?page=wp4t_set_status_form'),__('Set Away Message','rsvpmaker-for-toastmasters'),__('on vacation or unavailable','rsvpmaker-for-toastmasters'),$status);

if(function_exists('bp_core_get_userlink'))
	printf('<p>%s: %s</p>',__('Post a message on your club social profile'),bp_core_get_userlink( $current_user->ID ) );

  $count = 0;
	
$allow_assign = get_option('allow_assign');
$history = new role_history($current_user->ID);

	$results = get_future_events(" ( post_content LIKE '%role=%' OR post_content LIKE '%wp:wp%' ) ",3, OBJECT, 4);
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
					$roles = array();
					$absences = get_absences_array($row->postID);
					if(in_array($current_user->ID,$absences))
						$roles[] = 'planned abscence';
				if($role_results)
					foreach($role_results as $role_row)
						{
						$role = trim(preg_replace('/[^A-Za-z]/',' ',$role_row->meta_key));
						$roles[] = $role;
						$upcoming_roles .= sprintf('<p><a href="%s">%s %s</a></p>',$permalink,$role, $title);
						}
					if(empty($roles))
						$r = 'None';
					else
						$r = implode(", ",$roles);
					$title .= ' (Role: '.$r.')';

					if(strpos($row->post_content,'role'))
					{
						$link = '<p><a href="'.$permalink.'">'.__('Sign Up','rsvpmaker-for-toastmasters').'</a></p>';
;
						$link .= agenda_menu($row->ID, false);
						printf('<div class="dashdate" id="dashdate'.$row->ID.'"><p><strong>%s</strong></p> %s</div>', $title, $link);
		}
		}			  
 }

printf('<p><a href="%s" target="_blank">%s</a>
<br /></p>',site_url('/?signup2=1'),__("Print Signup Sheet",'rsvpmaker-for-toastmasters'));

if(current_user_can('edit_signups'))
	printf('<p><a href="%s">%s</a></p>',site_url('?signup_sheet_editor=1'),__('Edit Signups (multiple weeks)','rsvpmaker-for-toastmasters'));



$link = get_rsvpmaker_archive_link();
printf('<p><a href="%s">%s</a></p>',$link,__('View future events'));
printf('<p><a href="%s">%s</a></p>',admin_url('admin.php?page=toastmasters_planner'),__('Sign up for roles on multiple dates using the Role Planner','rsvpmaker-for-toastmasters'));

if(!empty($upcoming_roles))
{
	printf('<h3>%s</h3>
%s',__('Upcoming Roles','rsvpmaker-for-toastmasters'),$upcoming_roles);					
}

?>
<p><a href="./profile.php#user_login"><?php _e("Edit My Member Profile",'rsvpmaker-for-toastmasters');?></a>
<br /></p>
<!-- p><a href="< ?php echo site_url('/members/'); ?>">Member Directory</a>
<br /></p -->
<p><a href="<?php echo site_url('/?print_contacts=1'); ?>" target="_blank"><?php _e("Print Contacts List",'rsvpmaker-for-toastmasters');?></a>
<br /></p>
<p><a href="<?php echo site_url(); ?>"><?php _e("Home Page",'rsvpmaker-for-toastmasters');?></a>
<br /></p>
<?php
if(current_user_can('email_list') && function_exists('rsvpmaker_relay_active_lists') && $lists = rsvpmaker_relay_active_lists() )
	{
		if(!empty($lists['member']))
		printf('<p>'.__("Email all members",'rsvpmaker-for-toastmasters').': <a href="mailto:%s" target="_blank">%s</a> ('.__('for club business or social invitations, no spam please','rsvpmaker-for-toastmasters').')<br /></p>',$lists['member'],$lists['member']);
		if(!empty($lists['officer']) && is_officer())
		printf('<p>'.__("Officers email list",'rsvpmaker-for-toastmasters').': <a href="mailto:%s" target="_blank">%s</a> ('.__('for club business or social invitations, no spam please','rsvpmaker-for-toastmasters').')<br /></p>',$lists['officer'],$lists['officer']);
	}
elseif(current_user_can('email_list') && function_exists('wpt_mailster_get_email') && $list_email = wpt_mailster_get_email() )
	printf('<p>'.__("Email all members",'rsvpmaker-for-toastmasters').': <a href="mailto:%s" target="_blank">%s</a> ('.__('for club business or social invitations, no spam please','rsvpmaker-for-toastmasters').')<br /></p>',$list_email,$list_email);
elseif(current_user_can('email_list') && isset($wp4toastmasters_mailman["members"]) && !empty($wp4toastmasters_mailman["members"]) )
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
	if( !is_wp4t($template->content) )
		continue;
	$permalink = rsvpmaker_permalink_query($template->ID);
	printf('<p>%s<br /><a href="%s">%s</a><br /><a href="%s">%s</a>', $template->post_title, add_from_template_url($template->ID), __("Add Events (based on template)",'rsvpmaker-for-toastmasters'),agenda_setup_url($template->ID), __("Agenda Setup (drag-and-drop editor)",'rsvpmaker-for-toastmasters'));
	}		
}

if(!empty($wp4toastmasters_mailman["mpass"]))
echo '<p><a href="'.trailingslashit($wp4toastmasters_mailman["mpath"]).'members" target="_blank">'.__("Members Email List",'rsvpmaker-for-toastmasters').'</a> password: '.$wp4toastmasters_mailman["mpass"].' <a href="mailto:'.$wp4toastmasters_mailman["members"].'">'.$wp4toastmasters_mailman["members"].'</a><br /></p>';

if(!empty($wp4toastmasters_mailman["opass"]))
echo'<p><a href="'.trailingslashit($wp4toastmasters_mailman["opath"]).'members" target="_blank">'.__("Officers Email List",'rsvpmaker-for-toastmasters').'</a> password: '.$wp4toastmasters_mailman["opass"].' <a href="mailto:'.$wp4toastmasters_mailman["officers"].'">'.$wp4toastmasters_mailman["officers"].'</a></p>';

if(!empty($wp4toastmasters_mailman["gpass"]))
echo '<p><a href="'.trailingslashit($wp4toastmasters_mailman["gpath"]).'members" target="_blank">'.__("Guests Email List",'rsvpmaker-for-toastmasters').'</a> password: '.$wp4toastmasters_mailman["gpass"].' <a href="mailto:'.$wp4toastmasters_mailman["guest"].'">'.$wp4toastmasters_mailman["guest"].'</a></p>';

if(!empty($wp4toastmasters_mailman["mpass"]) || !empty($wp4toastmasters_mailman["opass"]) || !empty($wp4toastmasters_mailman["gpass"]))
printf('<p>See also <a href="%s">Mailman Mailing Lists</a></p>',admin_url('users.php?page=mailman'));

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
		if(isset($_REQUEST['hide_file']))
			add_post_meta($_REQUEST['hide_file'],'hide',1);
		if(isset($_REQUEST['show_file']))
			delete_post_meta($_REQUEST['show_file'],'hide');
		}
    foreach ($attachments as $post) {
        $hide = get_post_meta($post->ID,'hide',true);
		if($hide && !isset($_REQUEST["show_all_files"]))
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

function toastmasters_admin_widget () {
?>
<p><strong><a class="wp-first-item" href="edit.php">Posts</a></strong> - listing of blog posts</p>
<ul>
 	<li><a href="post-new.php">Add New</a> - new blog post (club news or article)</li>
</ul>
<?php
if(current_user_can('edit_others_pages'))
{
?>
<p><strong><a href="edit.php?post_type=page">Pages</a></strong> - pages of your site</p>
<ul>
 	<li><a href="post-new.php?post_type=page">Add New</a> - new page</li>
</ul>
<?php
}
?>
<p><strong><a href="edit.php?post_type=rsvpmaker">RSVP Events</a></strong> - list of event posts</p>
<ul>
 	<li><a href="post-new.php?post_type=rsvpmaker">Add New</a> - new event (not from template)</li>
 	<li><a href="edit.php?post_type=rsvpmaker&amp;page=rsvpmaker_template_list">Event Templates</a> - list of event templates for meetings</li>
 	<li><a href="edit.php?post_type=rsvpemail&amp;page=rsvpmaker_notification_templates">Email Notification/Reminder Templates</a> - settings for automated role reminders, meeting reminders, RSVP confirmations</li>
</ul>
 
<?php
if(current_user_can('manage_options'))
{
?>
<p><strong>Appearance</strong></p>
<ul>
 	<li id="menu-posts-rsvpmaker"><a class="hide-if-no-customize" href="customize.php">Customize</a> - tweak website design, including menu at top of the page, page header/banner, background color or image</li>
 	<li><a href="widgets.php">Widgets</a> - add/update sidebar widgets</li>
 	<li><a href="nav-menus.php">Menus</a> - update menu of pages, other links</li>
<?php
	$layout_id = get_option('rsvptoast_agenda_layout');
	if($layout_id)
		echo '<li><a href="'.admin_url('post.php?action=edit&post='.$layout_id).'">'.__('Agenda Layout Editor (Advanced)','rsvpmaker-for-toastmasters').'</a> - change the agenda HTML page structure or CSS.</li>';
?>
</ul>
<?php
}
if(current_user_can('edit_users'))
{
?>
<p><strong><a href="users.php?page=add_awesome_member">Users</strong> - list users/members</p>
<ul>
 	<li><a href="users.php?page=add_awesome_member">Add Members</a> - create user/member accounts</li>
</ul>
<?php
}
if(current_user_can('manage_options'))
{
?>
<p><strong>Settings</strong></p>
<ul>
 	<li><a href="options-general.php?page=wp4toastmasters_settings">Toastmasters</a> - set Officers list, agenda options, security for functions such as Edit Signups</li>
 	<li><a href="options-general.php?page=rsvpmaker-admin.php">RSVPMaker</a> - options for the calendar and event registration functions</li>
</ul>
<?php
}
if(function_exists('mailster_install'))
	printf('<p><strong>Mailing List</strong></p>
	<ul>
	<li><a href="%s">Manage Mailster Mailing List</a> - add addresses to whitelist, tweak settings</li>
	<li><a href="%s">Unsubscribe List</a></li>
	</ul>',admin_url('admin.php?page=mailster_toastmasters'),admin_url('edit.php?post_type=rsvpemail&page=unsubscribed_list'));

do_action('toastmasters_admin_widget_end');
}

function awesome_add_dashboard_widgets() {
wp_add_dashboard_widget('awesome_dashboard_widget', 'WordPress for Toastmasters Dashboard', 'awesome_dashboard_widget_function');

// Globalize the metaboxes array, this holds all the widgets for wp-admin

global $wp_meta_boxes;

unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);


// Get the regular dashboard widgets array
// (which has our new widget already but at the end)

$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];

// Backup and delete our new dashbaord widget from the end of the array

$awesome_widget_backup = array('awesome_dashboard_widget' =>
$normal_dashboard['awesome_dashboard_widget']);

unset($normal_dashboard['awesome_dashboard_widget']);

// Merge the two arrays together so our widget is at the beginning

$sorted_dashboard = array_merge($awesome_widget_backup, $normal_dashboard);

// Save the sorted array back into the original metaboxes

$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;

if(current_user_can('edit_others_rsvpmakers') || current_user_can('add_members'))
	{
	wp_add_dashboard_widget('toastmasters_admin_widget', 'Club Website Administration', 'toastmasters_admin_widget');
	$side_dashboard = $wp_meta_boxes['dashboard']['side']['core'];
	$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
	$sidebar_widget_backup = array('toastmasters_admin_widget' =>
$normal_dashboard['toastmasters_admin_widget']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['toastmasters_admin_widget']);
	$wp_meta_boxes['dashboard']['side']['core'] = array_merge($sidebar_widget_backup,$side_dashboard);
	}
}

function wpt_timecheck () {
	global $wpt_start;
	if(empty($wpt_start))
		$wpt_start = time();
	$now = time();
	$difference = $now - $wpt_start;
	//printf('<p>start %s now %s difference %s</p>',$wpt_start,$now,$difference);
	return $difference;
}

function toastmasters_reminder_preview() {
global $email_context;
$email_context = true;
wpt_timecheck ();
$future = get_future_events(" (post_content LIKE '%role=%' OR post_content LIKE '%wp:wp%') ",1);
if(sizeof($future))
{
	$next = $future[0];
	ob_start();
	wp4_speech_prompt($next, strtotime($next->datetime),true); //preview mode set to true	
	$content = ob_get_clean();
}
else
	$content = 'No upcoming meetings found';
wp_die($content,'Preview of Toastmasters reminders');
}
if(isset($_GET['tm_reminders_preview']))
add_action('init','toastmasters_reminder_preview');

function wp4toast_reminders () {
if(!isset($_REQUEST["cron_reminder"]))
	return;
wpt_timecheck ();
global $wpdb;
$wp4toast_reminder = get_option('wp4toast_reminder');
if(!$wp4toast_reminder)
	die("no reminder set");

$future = get_future_events(" (post_content LIKE '%role=%' OR post_content LIKE '%wp:wp%') ",1);
if(sizeof($future))
	$next = $future[0];
else
	$next = false;

if(!$next)
	die('no event scehduled');

echo __("Next meeting",'rsvpmaker-for-toastmasters')." $next->datetime <br />";	

$nexttime = $next->datetime;

$t = strtotime($nexttime.' -'.$wp4toast_reminder);
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

add_action('wp4toast_reminders_cron','wp4toast_reminders_cron',10,1);

function wp4toast_reminders_cron ($interval_hours) {
wpt_timecheck ();
$next = next_toastmaster_meeting();
if(empty($next))//else
	die('no meeting within timeframe');
fix_timezone();
$limit = strtotime($next->datetime . ' -' . $interval_hours . ' hours');
if($limit > time())
	{
		echo 'Next meeting ' . $next->datetime .' not within limit of '.$interval_hours.' hours '.date('r',$limit);
		return;
	}

echo __("Next meeting",'rsvpmaker-for-toastmasters')." $next->datetime <br />";	

wp4_speech_prompt($next, strtotime($next->datetime));
die();
}

function wp4toast_reminders_test () {
wpt_timecheck ();
wp4toast_reminders_cron($_REQUEST["reminders_test"]);
die('running test');
}

if(isset($_REQUEST["reminders_test"]))
	add_action('init','wp4toast_reminders_test');

function wp4_speech_prompt($event_post, $datetime, $preview = false) {
		//rsvpmaker_debug_log($event_post,'speech prompt post');
		//rsvpmaker_debug_log($datetime,'speech prompt datetime');
	
		global $wpdb;
		global $post;
		wpt_timecheck ();
		$post = $event_post;
		$signup = get_post_custom($event_post->ID);
		$emails = wpt_get_member_emails ();
		$admin_email = get_bloginfo('admin_email');
		$blog_name = get_bloginfo('name');
		$data = wpt_blocks_to_data($event_post->post_content);
		$templates = get_rsvpmaker_notification_templates();
		$rsvpdata["[rsvptitle]"] = $event_post->post_title;
		$rsvpdata["[rsvpdate]"] = $event_post->date;
			$toastmaster = (!empty($signup["_Toastmaster_of_the_Day_1"][0])) ? $signup["_Toastmaster_of_the_Day_1"][0] : 0;
			if($toastmaster)
				{
				$toastmaster_email = $emails[$toastmaster];
				}
			else
				$toastmaster_email = $admin_email;
			//rsvpmaker_debug_log($signup,'speech prompt signup');
			foreach($signup as $key => $values)
			{
			$role = trim(preg_replace('/[_[0-9]/',' ',$key));
			$assign = $values[0];
	
			if(!$assign || !is_numeric($assign))
				continue;//role not assigned, or assigned to a guest
			if(!empty($data[$role]))//confirm this meta key is a role from the document
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
				$mail["html"] = wpautop($body);
				$mail["to"] = $emails[$assign];
				if($emails[$assign] == $toastmaster_email)
					$mail["from"] = $admin_email;
				else
					$mail["from"] = $toastmaster_email;
				$mail["fromname"] = $blog_name;
				$mail["subject"] = $subject;
				//rsvpmaker_debug_log($mail,'reminder');
				if($preview)
				{
					printf('<h1>Preview: %s</h1><div>To: %s</div><div>Subject: %s</div>%s',$role,$mail["to"],$mail["subject"],$mail["html"]);
				}
				else
				{
					rsvpmaker_tx_email($event_post, $mail);
					//$mails[] = $mail; //rsvpmaker_tx_email($event_post, $mail);
					//rsvpmaker_debug_log($mail,'role reminder added to array');
				}
	
				}
			//$elapsed = wpt_timecheck ();
			//printf('<p>Elapsed time %s</p>',$elapsed);
			//if($elapsed > 25)
				//rsvpmaker_debug_log($key,'wp4_speech_prompt timeout danger');
			}
		
		/*    if(!empty($mails))
		{
			update_option('wpt_remind_queue',$mails);
			if($elapsed < 20)
				wpt_remind_queue(array('post_id'=> $event_post->ID));
			else
				wp_schedule_single_event(strtotime('+1 minutes'),'wpt_remind_queue',array('post_id'=> $event_post->ID));
		}
		else
		*/
		
		add_post_meta(1,'_rsvpmaker_email_log',array('wp4_speech_prompt' => $mail['to'],'subject' => $mail['subject']));
		
		if(get_option('wpt_remind_all') && !$preview)
		{
			wp_schedule_single_event(strtotime('+5 minutes'),'wpt_remind_unassigned',array('post_id'=> $event_post->ID));
			echo '<p>Setting reminder for unassigned members</p>';
		}
}
	
//add_action('wpt_remind_queue','wpt_remind_queue',10,1);
add_action('wpt_remind_unassigned','wpt_remind_unassigned',10,1);

function cron_email_test ($args = array()) {
	update_option('cron_email_test',date('H:i'));
	$mail['from'] = 'david@wp4toastmasters.com';
	$mail['fromname'] = 'WPT';
	$mail['to'] = 'david@carrcommunications.com';
	$mail['subject'] = 'Cron Email Test';
	$mail['html'] = '<p>Two quick</p><p>Lines of a message</p>';
	rsvpmailer($mail);
}

add_action('cron_email_test','cron_email_test',10,1);

function cron_email_tester () {
if(isset($_POST['add']))
{
	wp_schedule_single_event(strtotime('+1 minutes'),'cron_email_test');
	echo 'adding';
}
if(isset($_GET['now']))
{
	cron_email_test(array());
	echo 'mock send';
}

?>
<form action="<?php echo admin_url('tools.php?page=cron_email_tester'); ?>" method="post">
	<input type="hidden" name="add" value="1">
	<button>Add Test</button>
</form>
<?php
echo get_option('cron_email_test');
fix_timezone();
$cron = get_option('cron');
echo '<pre>';
foreach($cron as $ts => $item)
{
if(isset($item['cron_email_test']))
	echo '<strong>';
echo "\n".date('r',(int) $ts)."\n";
if(isset($item['cron_email_test']))
	echo '</strong>';
print_r($item);	
}
echo '</pre>';
}

function wpt_remind_queue ($args) {
	$mails = get_option('wpt_remind_queue');
	$log['type'] = 'wpt_remind_queue';
	$log['first_recipient'] = (empty($mail[0]['to'])) ? 'empty' : $mail[0]['to'];
	$log['subject'] = (empty($mail[0]['subject'])) ? 'empty' : $mail[0]['subject'];
	echo 'remind queue ';
	print_r($mails);
	echo '<br />';
	$start = time();
	if(is_array($mails))
	while($mail = array_shift($mails))
	{
	$result = rsvpmailer($mail);
	//rsvpmaker_debug_log($mail,'sending role reminder');
	//rsvpmaker_debug_log($result,'rsvpmailer result');
	printf('<pre> sending %s</pre>',var_export($mail,true));
	$elapsed = wpt_timecheck ();
	//printf('<p>Elapsed time %s</p>',$elapsed);
	if($elapsed > 20) {
		//rsvpmaker_debug_log($mail,'wpt_remind_queue timeout danger');
		break;
	}		
	}
	$log['next_recipient'] = (empty($mail[0]['to'])) ? 'empty' : $mail[0]['to'];
	$log['elapsed'] = $elapsed;
	$log['timestamp'] = date('Y-m-d H:i');
	fix_timezone();
	add_post_meta(1, '_rsvpmaker_email_log',$log);
	update_option('wpt_remind_queue',$mails);
	if(!empty($mails))
	{
		wp_schedule_single_event(strtotime('+1 minutes'),'wpt_remind_queue',$args);	
	}
	elseif(get_option('wpt_remind_all'))
	{
		wp_schedule_single_event(strtotime('+1 minutes'),'wpt_remind_unassigned',$args);
		echo '<p>Setting reminder for unassigned members</p>';
	}
}

function wpt_remind_unassigned($args = array())
	{
	global $post;
	$post = $event_post = next_toastmaster_meeting();
	$toastmaster = get_post_meta($post->ID,"_Toastmaster_of_the_Day_1",true);
	if(is_numeric($toastmaster) && ($toastmaster > 1))
	{
		$user = get_userdata($toastmaster);
		$from_email = $user->user_email;
	}
	else
		$from_email = get_bloginfo('admin_email');
	$blog_name = get_bloginfo('name');
	$emails = wp4t_unassigned_emails($event_post->ID);
	if(empty($emails))
		die('nobody unassigned');
	$templates = get_rsvpmaker_notification_templates();
	$rsvpdata["[rsvptitle]"] = $event_post->post_title;
	$rsvpdata["[rsvpdate]"] = $event_post->date;
	$subject = str_replace(array_keys($rsvpdata),$rsvpdata,$templates['norole']['subject']).' '.$blog_name;
	$output = do_shortcode($templates['norole']['body']);
	$mail["html"] = $output;
	echo $mail["html"];
	if(empty($toastmaster_email))
		$mail["from"] = get_bloginfo('admin_email');
	else
		$mail["from"] = $toastmaster_email;
	$mail["fromname"] = get_bloginfo('name');
	$mail["subject"] = $subject;
	if(isset($_GET['preview']))
		{
			printf('<h1>Preview: Reminder for Members with No Assignment</h1><div>To: %s</div><div>Subject: %s</div>%s',var_export($emails,true),$mail["subject"],$mail["html"]);
		}
	else
		{
		foreach($emails as $email)
		{
				$mail["to"] = $email;
				//rsvpmaker_debug_log($mail,'no assignment email');
				rsvpmailer($mail);	
		}

		}
	}


function wpt_open_roles ($atts = array()) {
	global $post;
	$output = '';
	$open = array();
	$signup = get_post_custom($post->ID);
	$data = wpt_blocks_to_data($post->post_content);
	foreach($data as $item)
	{
		if(!empty($item["role"]))
		{
		$role = $item["role"];
		$count = (int) $item['count'];
		for( $i = 1; $i <= $count; $i++) {
			$field = '_'.preg_replace('/[^A-Za-z]/','_',$role).'_'.$i;
			if(!empty($signup[$field][0]) && !is_numeric($signup[$field][0]))
				continue; //might be a guest signup
			if(empty($signup[$field][0]))
			{
			if(isset($open[$role]))
				$open[$role]++;
			else
				$open[$role]=1;
			}
		}
		
		}
	}
	$permalink = get_permalink($post->ID);

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
		}
	$output .= "</p>\n<p>".__("View agenda and sign up at",'rsvpmaker-for-toastmasters')." <a href=\"" . $permalink. "\">" . $permalink. "</a></p>\n<p>".__("Forgot your password?",'rsvpmaker-for-toastmasters')." <a href=\"".site_url('/wp-login.php?action=lostpassword')."\">".__("Reset your password here",'rsvpmaker-for-toastmasters')."</a></p>";
return $output;
}


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

function editable_note ($atts) {
	$atts["agenda_display"] = 'both';
	return agenda_note($atts);
}

function agenda_note($atts, $content = '') {
if(isset($_GET['convert']))
	return agenda_note_convert($atts,$content);
	
if(isset($_REQUEST["reorder"]))
	return; // not needed in this context	
global $post;
global $rsvp_options;
$output = '';
$display = isset($atts["agenda_display"]) ? $atts["agenda_display"] : 'agenda';
	
if(isset($_REQUEST["page"]) && ($_REQUEST["page"] == 'agenda_timing') )
	return timeplanner($atts, $content);
	
if(isset($_REQUEST["word_agenda"]) && $_REQUEST["word_agenda"])
	{
		$atts["style"] = '';
		$atts["sep"] = ' ';
	}

if(!empty($atts["officers"]))
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
		if(isset($atts['uid']))
		{
			$editid = 'agenda_note_'.$atts['uid'];
			$editable = get_post_meta($post->ID,$editid,true);
			if(empty($editable))
			$editable = get_post_meta($post->ID,'agenda_note_'.$atts["editable"],true);
		}
		else
		{
		$editid = 'agenda_note_'.$atts["editable"];
		$editable = get_post_meta($post->ID,'agenda_note_'.$atts["editable"],true);
		}

		$slug = preg_replace('/[^a-zA-Z_]/','',$editid);

		if(rsvpmaker_is_template())
		{
			$editable .= '<p>Editable note block will appear here</p>';
		}
		elseif(is_club_member() && isset($_REQUEST["edit_roles"]))
			{
			$editable = '<div class="agenda_note_editable"><textarea name="agenda_note[]" rows="5" cols="80" class="mce">'.$editable.'</textarea><input type="hidden" name="agenda_note_label[]" value="'.$editid.'" /></div>';
			$display = 'both';
			}
		elseif(empty($editable))
			$editable = '';
		if(is_single() && is_club_member() && !isset($_REQUEST["edit_roles"]) && (current_user_can('edit_signups') || edit_signups_role()) && !isset($_REQUEST["print_agenda"]) && !is_email_context())
			{
			$permalink = get_permalink($post->ID).'#'.$slug;
			$edit_editable = '<div class="agenda_note_editable_editone_wrapper"><a class="agenda_note_editable_editone_on">Edit</a></div><form method="post" action="'.$permalink.'" class="agenda_note_editable_editone"><div class="agenda_note_editable"><textarea name="agenda_note[]" rows="5" cols="80" class="mce">'.$editable.'</textarea><input type="hidden" name="agenda_note_label[]" value="'.$editid.'" /></div><button>Update</button><input type="hidden" name="post_id" value="'.$post->ID.'" /> </form>';
			}
		else
			$edit_editable = '';
		$content .= '<h3 id="'.$slug.'">'.$atts["editable"].'</h3><div class="editable_content">'.wpautop($editable).'</div>'.$edit_editable;
	}

	$maxtime = (!empty($atts["time_allowed"])) ? $atts["time_allowed"] : '';
	$timeblock = '<span class="time_allowed" maxtime="'.$maxtime.'"></span>';

if(isset($_REQUEST["print_agenda"]) || isset($_REQUEST["email_agenda"]))
	{
	if($display != 'web')
		{
		$output = '<p class="agenda_note" '.$style.'>'.$timeblock.trim($content).'</p>';
		}
	}
elseif(($display == 'web') || ($display == 'both') )
	$output = '<p class="agenda_note" '.$style.'>'.trim($content).'</p>';
else
	$output = '';

if(isset($_GET['debug']))
	$output .= var_export($atts,true);
	
return $output;
}

function agenda_timing_footer ($datestring) {
?>
<input type="hidden" id="start_time" value="<?php echo $datestring; ?>" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
jQuery(document).ready(function($) {
var time_tally;

var agenda_add_minutes =  function (dt, minutes) {
    return new Date(dt.getTime() + minutes*60000);
}

var agenda_time_tally = function () {
	time_tally = new Date($('#start_time').val());//start time
    $('.timeblock').each(function(index) {
     var addminutes = $(this).attr('maxtime');
	  	var hour = time_tally.getHours();
		var minute = time_tally.getMinutes();
		hour = (hour >= 12)? hour - 12: hour;
		if(minute < 10)
		minute = '0' + minute;
	var tallyadd = 0;
	var addthis = Number(addminutes);
	if(isNaN(addthis) || isNaN(hour) || isNaN(minute))
		return;
	tallyadd += addthis;
	if(tallyadd) {
    time_tally = agenda_add_minutes(time_tally,tallyadd);
	$(this).html(hour + ":" + minute);		
	}
	});
}

agenda_time_tally();

});

</script>
<?php
}


function get_role_signups ($post_id, $role, $count) {
	$field_base = preg_replace('/[^a-zA-Z0-9]/','_',$role);	
	$volunteers = array();	
		for($i = 1; $i <= $count; $i++)
			{
			$field = '_' . $field_base . '_' . $i;
			$assigned = get_post_meta($post_id, $field, true);
			if($assigned == '-1')
				continue;
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
				$volunteers[] = $assignedto;
				}
			}
return implode(', ',$volunteers);
}

function speaker_details_agenda ($field,$assigned) {
	global $post;
	$output = '';
	$speaker = get_speaker_array_by_field($field,$assigned,$post->ID);
	$manual = '<span class="manual">'.$speaker["manual"].'</span>';
	if(!empty($speaker["project"]))
		{
		$project = get_project_text($speaker["project"]);
		$project .= evaluation_form_link($assigned, $post->ID, $speaker["project"]);
		$dt = get_post_meta($post->ID, '_display_time'.$field, true);
		if(empty($dt))
			{
			$timing = get_projects_array('display_times');
			$dt = (isset($timing[$project_index])) ? $timing[$project_index] : '';
			}
		$dt = apply_filters('agenda_time_display',$dt);
		$manual .= ': <span class="project">'.$project.'</span>';			
		}
	else
		$manual .= evaluation_form_link($assigned, $post->ID, '');
	$output .= '<div class="manual-project">'.$manual.'</div>';
	if(!empty($speaker["title"]))
		$output .= '<div class="title">&quot;'.$speaker["title"].'&quot;</div>';
	if(!empty($dt))
		$output .= '<div class="speechtime">'.$dt.'</div>';
	if(!empty($speaker["intro"]) && (isset($_GET['showintros']) || get_option('wp4toastmasters_intros_on_agenda')) )
		$output .= '<div class="intro">'.wpautop('<strong>'.__('Introduction','rsvpmaker-for-toastmasters').':</strong> '.$speaker["intro"]).'</div>';

	$output = apply_filters('speaker_details_agenda',$output,$field);
	$output = "\n".'<div class="speaker-details">'.$output.'</div>'."\n";
	return $output;
}

function toastmasters_agenda_display($atts) {
	if(function_exists('toastmasters_agenda_display_custom'))
		return  toastmasters_agenda_display_custom($atts);
	global $post, $open, $rolestart;
	$count = (empty($atts["count"])) ? 1 : $atts["count"];;
	$start = (empty($rolestart[$atts['role']])) ? 1 : $rolestart[$atts['role']];

		$field = $output = $startdiv = '';
		$maxtime = (isset($atts["time_allowed"]) ) ? (int) $atts["time_allowed"] : 0;
		$padding_time = (isset($atts["padding_time"])) ? (int) $atts["padding_time"] : 0;
		$speaktime = 0;
		$field_base = preg_replace('/[^a-zA-Z0-9]/','_',$atts["role"]);	
		for($i = $start; $i < ($count + $start); $i++)
			{
			$rolestart[$atts['role']] = $i + 1;
		if(isset($atts["indent"]) && $atts["indent"])
			$output  .= "\n".'<div class="role-agenda-item indent">';
		else
			$output .= "\n".'<div class="role-agenda-item">';
			$field = '_' . $field_base . '_' . $i;
			$assigned = get_post_meta($post->ID, $field, true);
			
			if(isset($_GET['agendadebug']))
			$output .= '<div style="color: red">Assigned: '.$assigned.'</div>';
				
			if(!empty($atts["time_allowed"]) && strpos($field,'Speaker'))
				{
					$speaktime += (int) get_post_meta($post->ID,'_maxtime'.$field,true);
				}
			if($i == 1)
				$output .= 'TIMEBLOCKHERE';
			else
				$output .= '<span class="timeblock"></span>';				
			$output .= '<span class="role">'.$atts["role"];
			if (!empty($atts["count"]) && ($atts["count"] > 1))
			    {
            $output .= ' <span class="role_number">'.$i.'</span>';
			    }
			if (!empty($atts["evaluates"]))
			    {
                if ( ( (strpos($field,'Evaluator')) ) && ($field != '_General_Evaluator_1'))  //add speaker after evaluator
                {
                    $speechfield = '_Speaker_'.$i;
                    $speakerID_to_be_evaluated = get_post_meta($post->ID, $speechfield, true);
                    $user_info = get_userdata($speakerID_to_be_evaluated);
                    $speaker_to_be_evaluated = $user_info -> first_name . ' ' . $user_info -> last_name;
                    $output .= '<span class = "evaluates"> evaluates '. $speaker_to_be_evaluated . '</span>';
                }
                }
            $output .= '</span>';
			$output .= ' <span class="member-role">';
			if(isset($_GET['debug'])) $output .= 'assigned: '.$assigned .' ';
			$output .= get_member_name($assigned);	
			$output .= '</span>';
			if(empty($assigned))
				{
				if(isset($open[$atts["role"]]))
					$open[$atts["role"]]++;
				else
					$open[$atts["role"]] = 1;				
				}
			if($assigned && (strpos($field,'Speaker') == 1) )
				{
				$output .= speaker_details_agenda($field,$assigned);
				}
			if(isset($atts["agenda_note"]) && !empty($atts["agenda_note"]) && strpos($atts["agenda_note"],'Speaker}')){
				$speakerID_to_be_evaluated = get_post_meta($post->ID, '_Speaker_'.$i, true);
				if($speakerID_to_be_evaluated > 0)
					$note = str_replace('{Speaker}',get_member_name($speaker_to_be_evaluated),$atts["agenda_note"]);
				else
					$note = str_replace('{Speaker}','?',$atts["agenda_note"]);
				$output .= '<div class="role_agenda_note">'.$note."</div>";
			}
		$output .= '</div>';
		}//end for loop ?
			if(isset($atts["agenda_note"]) && !empty($atts["agenda_note"]) && !strpos($atts["agenda_note"],'Speaker}'))
				{
				$note = $atts["agenda_note"];
				$output .=  '<div class="role_agenda_note">'.$note."</div>";
				}
		if((strpos($field,'Evaluator') == 1) && get_option('wp4toastmasters_stoplight')) {
			$output .= '<div>Each evaluator '.get_stoplight(2,3).'</div>';
		}
		if((strpos($field,'Topics_Master') == 1) && get_option('wp4toastmasters_stoplight')) {
			$output .= '<div>Each Table Topics Speaker '.get_stoplight(1,2).'</div>';
		}
		$output = apply_filters('agenda_role_bottom',$output,$field);
		if($speaktime > $maxtime)
			$maxtime = $speaktime;
		$start_end = '';
		if($padding_time)
			$maxtime += $padding_time;
		$timeblock = '<span class="time_allowed" maxtime="'.$maxtime.'"></span>';
		$output = str_replace('TIMEBLOCKHERE',$timeblock,$output);
		if(isset($_REQUEST['word_agenda'])) // word doesn't handle the list numbering well
			$output = preg_replace('/(<\/ul>|<\/li>|<ul>|<li>)/','',$output);
		return $output;			
}

$rolestart = array();

function toastmaster_short($atts=array(),$content="") {
	if(isset($_GET['convert']))
		return toastmaster_short_convert($atts);
	global $tmroles, $rolestart;
	$assigned = 0;
	if(isset($_REQUEST["page"]) && ($_REQUEST["page"] == 'agenda_timing') )
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
	if(($atts["role"] == 'custom') )
		{
		if(empty($atts["custom_role"]))
			$atts['role'] = 'Custom role undefined';
		else
			$atts["role"] = $atts["custom_role"];
		}
	
	$field_base = preg_replace('/[^a-zA-Z0-9]/','_',$atts["role"]);	
	$count = (int) (isset($atts["count"])) ? $atts["count"] : 1;
	$start = (empty($rolestart[$atts['role']])) ? 1 : $rolestart[$atts['role']];
	$backup = $output = '';

	if($atts["role"] == 'Speaker')
		pack_speakers($count);
	elseif($count > 1)
		pack_roles($count,$field_base);
	
	if(!empty($atts['backup']))
		$backup = toastmaster_short(array('role'=>'Backup '.$atts['role']));
	//$backup .= var_export($atts,true);
	global $post, $current_user, $open;
	$permalink = rsvpmaker_permalink_query($post->ID);
	
	if(isset($_REQUEST["reorder"]))
		{
		if($count == 1)
			return;
		$output .= '<input type="hidden" id="_'.$field_base.'post_id" value="'.$post->ID.'">';
		$output .= '<h3>'.$atts["role"].'</h3><ul id="'.$field_base.'" class="tmsortable sortable">';
		for($i = $start; $i < ($count + $start); $i++)
			{
			$rolestart[$atts['role']] = $i + 1;
			$field = '_' . $field_base . '_' . $i;
			$assigned = get_post_meta($post->ID, $field, true);
			if($assigned == '-1')
				{
				$assignedto = __('Not Available','rsvpmaker-for-toastmasters');
				}
			elseif($assigned == '-2')
				{
				$assignedto = __('To Be Announced','rsvpmaker-for-toastmasters');
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
			$output .= '<li class="sortableitem sortable_'.$field_base.'" id="'.$field.'" >'.$assignedto.'<input type="hidden" id="'.$field.'_assigned" value="'.$assigned.'"></li>';
			}
		$output .= '<li><div id="'.$field_base.'_sortresult" class="sortresult">'.__('Drag and drop assignments into the desired agenda order','rsvpmaker-for-toastmasters').'</div></li></ul>';
		return $output.$backup;
		}
	// need to know what role to look up for notifications	
	if(isset($atts["leader"]) )
		update_post_meta($post->ID,'meeting_leader','_'.$field_base.'_1' );

	if(isset($_GET["print_agenda"]) && strpos($field_base,'ackup') && ($assigned < 1))
		return; // don't need to output empty backup speaker slot on agenda
	if(isset($_REQUEST["signup2"]))
		{
		for($i = $start; $i < ($count + $start); $i++)
			{
			$rolestart[$atts['role']] = $i + 1;
			$field = '_' . $field_base . '_' . $i;
			$assigned = get_post_meta($post->ID, $field, true);
			if($assigned == '-1')
				{
				$assignedto = __('Not Available','rsvpmaker-for-toastmasters');
				}
			elseif($assigned == '-2')
				{
				$assignedto = __('To Be Announced','rsvpmaker-for-toastmasters');
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
		return $output.$backup;
		}

	if(isset($_REQUEST["print_agenda"]) || is_email_context() || is_agenda_locked())
		return toastmasters_agenda_display($atts);

	global $random_available;
	global $last_attended;
	global $last_filled;
	
	if(isset($_GET['edit_roles']) && (current_user_can('edit_roles') || edit_signups_role()) )
		{
			if(function_exists('do_blocks'))
			{
			$roleindex = preg_replace('/[^a-zA-Z]/','',$atts['role']);
			$time = (empty($atts['time_allowed'])) ? 0 : (int) $atts['time_allowed'];
			$count = (empty($atts['count'])) ? 1 : (int) $atts['count'];
			$timeopt = '';
			$countopt = '';
			for($ii = 0; $ii <= 60; $ii++)
			{
				$s = ($ii == $time) ? ' selected="selected" ' : '';
				$timeopt .= sprintf('<option value="%s" %s>%s</option>',$ii,$s,$ii);
			}
			for($ii = 1; $ii <= 10; $ii++)
			{
				$s = ($ii == $count) ? ' selected="selected" ' : '';
				$countopt .= sprintf('<option value="%s" %s>%s</option>',$ii,$s,$ii);
			}
			if(($atts['role'] == 'Speaker') || !empty($atts["padding_time"]))
			{
				$padding_time = (int) $atts["padding_time"];
				$paddingopt = '';
				for($ii = 0; $ii <= 60; $ii++)
				{
					$s = ($ii == $padding_time) ? ' selected="selected" ' : '';
					$paddingopt .= sprintf('<option value="%s" %s>%s</option>',$ii,$s,$ii);
				}
				$padding = sprintf('Padding <select name="tweakpadding[%s]" id="padding%s" class="tweakpadding">%s</select> ',$roleindex,$roleindex,$paddingopt);
			}
			else
				$padding = '';
		
			$output .= sprintf('<div><span id="time%s" class="toasttime"></span> <input type="checkbox" name="tweaktime[]" value="%s" show="opt%s" class="timecheck" /> Tweak Timing for %s</div><div class="timeopt" id="opt%s">Minutes <select name="tweakminutes[%s]" class="tweakminutes" timetarget="%s">%s</select> %s Count <select name="tweakcount[%s]" class="tweakcount" prompt="prompt%s">%s</select><div id="prompt%s"></div><div><button>Save</button></div></div>',$roleindex,$atts['role'],$roleindex, $atts['role'], $roleindex,$roleindex, $roleindex, $timeopt, $padding, $roleindex, $roleindex, $countopt,$roleindex);		
			}
		}

	for($i = $start; $i < ($count + $start); $i++)
		{
		$rolestart[$atts['role']] = $i + 1;
		$field = '_' . $field_base . '_' . $i;
		$assigned = get_post_meta($post->ID, $field, true);
		if(isset($_GET['debugagenda']))
			$output .= '<div style="color:red;">assigned: '.$assigned.'</div>';
		if(is_numeric($assigned) && ($assigned > 0))
			$tmroles[$field] = $assigned;
		$output .= '<div class="role-block" id="'.$field.'"><div class="role-title" style="font-weight: bold;">';
		$output .= $atts["role"].': </div><div class="role-data"> ';
		$ajaxclass = 'toastrole'; // ($assigned) ? 'toastupdate' : 
		if(is_club_member() && !(isset($_REQUEST["edit_roles"]) || isset($_REQUEST["recommend_roles"]) || (isset($_REQUEST["page"]) && ($_REQUEST["page"] == 'toastmasters_reconcile') ) )  ) 
			$output .= sprintf(' <form id="%s_form" method="post" class="%s" action="%s" style="display: inline;"><input type="hidden" name="user_id" value="%d" /> <input type="hidden" name="role" value="%s"><input type="hidden" name="post_id" value="%d"><input type="hidden" name="check" value="%s">',$field,$ajaxclass,$permalink, $current_user->ID, $field, $post->ID,wp_create_nonce($field));
				
		if($assigned == '-1')
				{
				$output .= __('Not Available','rsvpmaker-for-toastmasters');
				}
		if($assigned == '-2')
				{
				$output .= __('To Be Announced','rsvpmaker-for-toastmasters');
				}
		elseif($assigned  && !(isset($_REQUEST["edit_roles"]) || (isset($_REQUEST["page"]) && ($_REQUEST["page"] == 'toastmasters_reconcile') ) ) )
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
            $random_available = random_available_check();
            if(isset($_GET['debug']))
            {
                echo 'random check</br>';
                print_r($random_available);
            }
			if((isset($_REQUEST["edit_roles"]) &&  (current_user_can('edit_signups') || edit_signups_role()) ) || (isset($_REQUEST["page"]) && ($_REQUEST["page"] == 'toastmasters_reconcile') ) ) // && current_user_can('edit_posts') )
				{
				    $assign_ok = get_user_meta($current_user->ID,'assign_okay',true);
				    if(empty($assign_ok) || ($assign_ok < time()))
                        $output .= '<div>Suggested assignments not enabled</div>';
					elseif(	(empty($assigned) || ($assigned == 0)) && is_array($random_available) && !empty($random_available) )
						{
						$role = preg_replace('/[0-9]/','',$field);// remove number
						$assigned = pick_random_member($role);
						$output .= '<em><span style="color:red;">'.__('Suggested assignment (unconfirmed)','rsvpmaker-for-toastmasters').'</span><br />'.__('Last attended','rsvpmaker-for-toastmasters').': '.$last_attended[$assigned].' '.__('Last filled role','rsvpmaker-for-toastmasters').': '.$last_filled[$role][$assigned].'</em><br />';
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
			elseif(isset($_REQUEST["recommend_roles"]) &&  (current_user_can('edit_roles') || edit_signups_role()) ) // && current_user_can('edit_posts') )
				{
					// editor admin options
					if(!$assigned)
					{
					$random_assigned = NULL;
					if(	is_array($random_available) && !empty($random_available) )
						{
						$role = preg_replace('/[0-9]/','',$field);// remove number
						$assigned = pick_random_member($role);
						$output .= '<em><span style="color:red;">'.__('Suggested assignment (unconfirmed)','rsvpmaker-for-toastmasters').'</span><br />'.__('Last attended','rsvpmaker-for-toastmasters').': '.$last_attended[$assigned].' '.__('Last filled role','rsvpmaker-for-toastmasters').': '.$last_filled[$role][$assigned].'</em><br />';
						}
					$awe_user_dropdown = awe_assign_dropdown($field, $assigned);
					$output .= $awe_user_dropdown;
					$output .= sprintf('<p>%s:<br /><textarea rows="3" cols="40" name="editor_suggest_note[%s]"></textarea></p><input type="hidden" name="editor_suggest_count[%s]" value="%s" />',__('Add a personal note (optional)','rsvpmaker-for-toastmasters'),$field, $field, $count);
					}
				}
			elseif(!$assigned)
				{
				if(rsvpmaker_is_template())
					$output .= '(Take Role button appears here)';
				elseif(strpos($field,'Speaker') )
				{
					$points = get_speech_points ($current_user->ID);
					$rules = get_option('toastmasters_rules');
					if(($points < 0) && !empty($rules['points']))
						{
						global $points_warning;
						//$makeup = abs($points);
						if($rules['points'] == 'prevent')
							{
								if(!$points_warning)
								{
									$output .= '<p><strong>Based on the points system we use, you are at <span style="color: red">'.$points.'</span></strong></p><p>Please sign up for other supporting roles to balance out your participation in the club.</p>';
									$points_warning = true;
								}
							}
						else
							{
								if(!$points_warning)
								{
								$output .= '<p><strong>Based on the points system we use, you are at <span style="color: red">'.$points.'</span></p> Please sign up for other supporting roles (if not for this meeting, then soon) to balance out your participation in the club</p>';
								$points_warning = true;
								}
								$output .= sprintf('<div class="update_form" id="update'.$field.'">%s</div>',$detailsform);	
								$output .= '<button name="take_role" id="take_role'.$field.'" value="1">Take Role</button>';
								
							}
						}
					else
						{
							$output .= sprintf('<div class="update_form" id="update'.$field.'">%s</div>',$detailsform);	
							$output .= '<button name="take_role" id="take_role'.$field.'" value="1">Take Role</button>';
						}
				}
				else
					{
							$output .= '<button name="take_role" id="take_role'.$field.'" value="1">Take Role</button>';
					}
				}

			elseif($assigned == $current_user->ID)
					{
				if(strpos($field,'Speaker') )
					$output .= sprintf('<div class="update_form" id="update'.$field.'">%s
					<button name="update_role" value="1">'.__('Update Role','rsvpmaker-for-toastmasters').'</button>
					<br />
					<em>or</em>
					</div><div></div>',$detailsform);
					}
			elseif(strpos($field,'Speaker') && ($assigned != '-1' ) )
				{
				$output .= '<div class="update_form" id="update'.$field.'">'.speech_public_details($field, $assigned).'</div>';
				}

			if(is_single() && strpos($field,'Speaker') && !strpos($field,'Backup') )
				{
				$output .= '<div class="time_message"></div> ';
				}
			}

		if(isset($atts["agenda_note"]) && !empty($atts["agenda_note"]) )
			{
			$note = $atts["agenda_note"];
			if(strpos($note,'{Speaker}'))
				{
				$speaker_id = get_post_meta($post->ID,'_Speaker_'.$i,true);
				if(empty($speaker_id))
					$speaker_name = '?';
				elseif(is_numeric($speaker_id))
					{
					$member = get_userdata( $speaker_id );
					if(empty($member))
						$speaker_name = 'Name? user: '.$speaker_id;
					else
						$speaker_name = $member->first_name.' '.$member->last_name;
					if(!empty($member->education_awards)) $speaker_name .= ', '.$member->education_awards;
					}
				else
					$speaker_name = $speaker_id.' ('.__('guest','rsvpmaker-for-toastmasters').')';
				$note = str_replace('{Speaker}',$speaker_name,$note);
				}
			$output .=  "<div><em>".$note."</em></div>";
			}

		if(is_club_member() && !(isset($_REQUEST["edit_roles"]) || isset($_REQUEST["recommend_roles"]) || (isset($_REQUEST["page"]) && ($_REQUEST["page"] == 'toastmasters_reconcile') ) )  ) 
		{
			$output .= '</form>';
			if($assigned == $current_user->ID)
			$output .= sprintf('<form id="remove%s_form" method="post" class="remove_me_form" action="%s" style="display: inline;"><input type="hidden" name="user_id" value="%d" /> <input type="hidden" name="remove_role" id="remove_role%s" value="%s"><input type="hidden" name="post_id" class="post_id" value="%d"><input type="hidden" name="check" value="%s">',$field,$permalink, $current_user->ID, $field, $field, $post->ID,wp_create_nonce('remove'.$field)).'<button name="delete_role" id="delete_role'.$field.'" value="1">'.__('Remove Me','rsvpmaker-for-toastmasters').'</button></form>';
			//hidden edit field
			if(is_single() && current_user_can('edit_signups')) { 
				$awe_user_dropdown = awe_user_dropdown($field, $assigned);
				$editone = 'Member: '.$awe_user_dropdown;
				if(strpos($field,'Speaker') )
					$editone .= str_replace('speaker_details maxtime','speaker_details',str_replace('id="','id="editone',$detailsform));
				$output .= sprintf('<div id="editonewrapper%s""><a class="editonelink" editone="%s">Edit</a></div><form id="editone%s" method="post" class="edit_one_form" action="%s" style="display: block;"><input type="hidden" name="post_id" value="%d"><input type="hidden" name="check" value="%s"><input type="hidden" name="role" value="%s"><div>%s</div>',$field,$field,$field,$permalink,$post->ID,wp_create_nonce($field),$field,$editone).'<button name="edit_one" id="edit_one_button'.$field.'" value="1">'.__('Submit','rsvpmaker-for-toastmasters').'</button></form>';	
			}
		}

		$output .= '</div></div><!-- end role block -->';			
			} //end for loop

		if(isset($field) && strpos($field,'Speaker') )
			{
			$time_limit = (isset($atts["time_allowed"])) ? (int) $atts["time_allowed"] : 0;
			$output .= '<input type="hidden" class="time_limit" value="'.$time_limit.'" />';
			}

	return $output.$backup;
}

function tm_calc_time($minutes)
	{
		if(empty($minutes))
			return;
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
				if(empty($datetime))
					{
						$sked = get_post_meta($post->ID,'_sked',true);
						if(isset($sked["hour"]))
							{
								$datetime = '2017-01-01 '.$sked["hour"].':'.$sked["minutes"].':00';
							}
					}
				$time_count = strtotime($datetime);
				//todo also end time
			}
		$start_time = strftime(str_replace('%Z','',$rsvp_options["time_format"]),$time_count);
		
		$time_count = mktime( date("H",$time_count), date("i",$time_count) + $minutes, date("s",$time_count) + $seconds );
		if(isset($_REQUEST["end"]))
			$start_time .= '-'.strftime($rsvp_options["time_format"],$time_count);
		return $start_time;
	}

function decode_timeblock ($matches) {
	return '><span class="timeblock">'.tm_calc_time((int) $matches[1]).'&nbsp;</span>';
}

function agendanoterich2_timeblock($matches) {
	$props = json_decode($matches[1]);
	$time = empty($props->time_allowed) ? 0 : $props->time_allowed;
	$timed = str_replace('<p class="wp-block-wp4toastmasters-agendanoterich2"','<p  class="wp-block-wp4toastmasters-agendanoterich2" maxtime="'.$time.'"',$matches[0]);
	return $timed;
}

function tm_agenda_content () {
	global $post;
	$content = $post->post_content;
	$pattern = '/\<\!-- wp:wp4toastmasters\/agendanoterich2 ({[^}]+})[^!]+/s';
	$content = preg_replace_callback($pattern,'agendanoterich2_timeblock',$content);
	if(function_exists('do_blocks'))
		$content = do_blocks($content);
	$content = wpautop(do_shortcode($content));
	//if(!is_email_context()) //not working well in event reminders
	$content = preg_replace_callback('/maxtime="([0-9]+)[^>]+>/','decode_timeblock',$content);
return $content;
}


function toastmasters_officer_single($atts) {
$title = (isset($atts['title'])) ? $atts['title'] : 'VP of Education';
$wp4toastmasters_officer_ids = get_option('wp4toastmasters_officer_ids');
$wp4toastmasters_officer_titles = get_option('wp4toastmasters_officer_titles');
$index = array_search($title,$wp4toastmasters_officer_titles);
if($index === FALSE)
	return;
$officer_id = $wp4toastmasters_officer_ids[$index];

$contact = '';
	
if($officer_id)
	{
	$userdata = get_userdata($officer_id);
	$contactmethods['home_phone'] = __("Home Phone",'rsvpmaker-for-toastmasters');
	$contactmethods['work_phone'] = __("Work Phone",'rsvpmaker-for-toastmasters');
	$contactmethods['mobile_phone'] = __("Mobile Phone",'rsvpmaker-for-toastmasters');
	$contactmethods['user_email'] = __("Email",'rsvpmaker-for-toastmasters');
	$contact = '<div><strong>'.$title.': '.$userdata->first_name.' '.$userdata->last_name.'</strong></div>';
	foreach($contactmethods as $name => $value)
	{
	if(strpos($name,'phone') && !empty($userdata->$name) )
		{
		$contact .= sprintf("<div>%s: %s</div>\n",$value,$userdata->$name);
		}
	}
$contact .= sprintf('<div>'.__("Email",'rsvpmaker-for-toastmasters').': <a href="mailto:%s">%s</a></div>'."\n",$userdata->user_email,$userdata->user_email);
}	
return $contact;
}

function toastmaster_officers ($atts) {
if(!isset($_REQUEST["print_agenda"]) && !is_email_context())
	return;
$label = isset($atts["label"]) ? $atts["label"] : __('Officers','rsvpmaker-for-toastmasters');
$wp4toastmasters_officer_ids = get_option('wp4toastmasters_officer_ids');
$wp4toastmasters_officer_titles = get_option('wp4toastmasters_officer_titles');
$buffer = "\n<div class=\"officers\"><span class=\"officers_label\">".$label."</span>"; //.$label.": ";

if(is_array($wp4toastmasters_officer_ids))
{
foreach ($wp4toastmasters_officer_ids as $index => $officer_id)
	{
		if(!$officer_id)
			continue;
		$officer = get_member_name($officer_id);
		$title = str_replace(' ','&nbsp;',$wp4toastmasters_officer_titles[$index]);
		$buffer .= sprintf('<div class="officer_entity"><div class="officertitle">%s</div><div class="officer">%s</div></div>',$title,$officer);
	}
}
else
	$buffer .= '<p>'.__('Officers list not yet set','rsvpmaker-for-toastmasters').'</p>';
$buffer .= "</div>\n";
return $buffer;
}

function tm_get_histories () {
	global $post;
	$histories = array();
	$users = get_users();
	foreach($users as $user)
	{
		if(empty($post->ID))
		$histories[$user->ID] = new role_history($user->ID);
		else
		$histories[$user->ID] = new role_history($user->ID,get_rsvp_date($post->ID));		
	}
	return $histories;
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
return get_user_meta($member_id,'status',true).' '.__('expires','rsvpmaker-for-toastmasters').': '.date('r',$exp);
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
printf('<p>%s</p>',__('Set a temporary message for the members page letting people know when you are  to attend.','rsvpmaker-for-toastmasters'));

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

if(isset($_REQUEST["member_id"]))
	$selected = (int) $_REQUEST["member_id"];
else
	{
	global $current_user;
	$selected = $current_user->ID;
	}
echo '<p>My status: '.wp4t_get_member_status($selected).'</p>';

$dropdown = awe_user_dropdown ('member_id',$selected,true);
$t = strtotime('today +2 week');
$month =  (int) date('m',$t);
$year =  (int) date('Y',$t);
$day =  (int) date('d',$t);
$hour =  (int) date('G',$t);
$minutes =  (int) date('i',$t);
$index = 0;
			printf('<p> 
			<form action="'.admin_url('profile.php?page=wp4t_set_status_form').'" method="post">%s<br /><strong>Status</strong><br /><textarea name="status" cols="60" rows="1"></textarea>
',$dropdown);	
?>
<br /><strong><?php echo __('Expires','rsvpmaker');?></strong>
<div class="date_block"><?php echo __('Month:','rsvpmaker');?> 
<select id="month<?php echo $index;?>" name="month[<?php echo $index;?>]"> 
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
<select  id="day<?php echo $index;?>"  name="day[<?php echo $index;?>]"> 
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
<select  id="year<?php echo $index;?>" name="year[<?php echo $index ;?>]"> 
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
<?php echo __('Hour:','rsvpmaker');?> <select name="hour[<?php echo $index;?>]"> 
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

function awesome_wall($comment_content, $post_id, $member_id=0) {

global $current_user;
global $wpdb;
if($member_id)
{
	$userdata = get_userdata($member_id);
	$comment_content = "<strong>".$userdata->display_name.':</strong> '.$comment_content;
}
else
$comment_content = "<strong>".$current_user->display_name.':</strong> '.$comment_content;
$stamp = '<small><em>(Posted: '.date('m/d/y H:i').')</em></small>';
$date = get_rsvp_date($post_id);
$ts = strtotime($date);
$comment_content .= ' for '.date('F jS, Y',$ts). ' '.$stamp;

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
	if(!empty($userdata->user_email))
	{
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
			delete_post_meta($post_id,'_display_time'.$role);
			delete_post_meta($post_id,'_intro'.$role);
			}
	}

if(isset($_POST["agenda_note"]))
	{
	foreach($_POST["agenda_note"] as $index => $note)
		{
			$note = stripslashes($note);
			$note = trim(str_replace('&nbsp;',' ',$note));
			if( empty($_POST["agenda_note_label"][$index]) )
				continue;
			update_post_meta($post_id,$_POST["agenda_note_label"][$index],$note);
		}
	}

if(isset($_POST["editor_assign"]) )
	{
		$edit_log = array();
		foreach($_POST["editor_assign"] as $role => $user_id)
		{
			if(isset($_POST['recommend_instead'.$role]))
			{
				$editor_id = (int) $_POST['editor_id'];
				tm_recommend_send($role,$user_id,get_permalink($post_id),preg_replace('/[^0-9]/','',$role),$post_id,$editor_id);
				update_post_meta($post_id,$role,0);
				continue;
			}
			$timestamp = get_rsvp_date($post_id);
			$was = get_post_meta($post_id,$role,true);
			if($was != $user_id)
				{
				update_post_meta($post_id,$role,$user_id);
				$actiontext = __("signed up for",'rsvpmaker-for-toastmasters').' '.clean_role($role);
				if(is_numeric($user_id))
					{
					if($user_id > 0)
						{
						do_action('toastmasters_agenda_notification',$post_id,$actiontext,$user_id);
						}
					$log = get_member_name($current_user->ID) .' assigned '.$role.' to '.get_member_name($user_id).' for '.date('F jS, Y',strtotime($timestamp));
					if($was)
						$log .= ' (was: '.get_member_name($was).')';
					$edit_log[] = $log;
					}
				if(strpos($role,'peaker') && isset($_POST["_project"]))
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
			delete_post_meta($post_id,'_display_time'.$role);
			delete_post_meta($post_id,'_intro'.$role);
			}
		}

		if(isset($_POST["edit_guest"]))
		foreach($_POST["edit_guest"] as $role => $guest)
		{
			if(!empty($guest))
				{
				update_post_meta($post_id,$role,$guest);			
				$log = get_member_name($current_user->ID) .' assigned '.$role.' to '.$guest.' (guest) for '.date('F jS, Y',strtotime($timestamp));
				if($was)
					$log .= ' (was: '.get_member_name($was).')';
				$edit_log[] = $log;
				}
		}
		
	if(!empty($edit_log)) {
		add_post_meta($post_id,'_activity_editor',implode('<br />',$edit_log));
		update_option( '_tm_updates_logged', strtotime('+ 2 minutes') );
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
			$display_time = (isset($_POST["_display_time"][$basefield])) ? $_POST["_display_time"][$basefield] : '';
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
			update_user_meta($user_id,'current_manual',strip_tags($manual));
			update_post_meta($post_id,'_manual'.$basefield,strip_tags($manual));
			update_post_meta($post_id,'_title'.$basefield,strip_tags($title));
			update_post_meta($post_id,'_project'.$basefield,strip_tags($project));
			if(isset($_POST["_display_time"][$basefield]))
				update_post_meta($post_id,'_display_time'.$basefield,$display_time);
			if(isset($_POST["_maxtime"][$basefield]))
				update_post_meta($post_id,'_maxtime'.$basefield,$time);
			if(isset($_POST["_intro"][$basefield]))
				update_post_meta($post_id,'_intro'.$basefield,strip_tags($intro,'<p><br><a><strong><em>'));
			do_action('save_speaker_extra',$post_id,$basefield);
			}
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

	
if(isset($_POST["remove_role"]))
	{
		$role = $_POST["remove_role"];
		delete_post_meta($post_id,$role);
		if(strpos($role,'peaker') )
			{
			delete_post_meta($post_id,'_manual'.$role);
			delete_post_meta($post_id,'_project'.$role);
			delete_post_meta($post_id,'_title'.$role);
			delete_post_meta($post_id,'_intro'.$role);
			}
		$actiontext = __("withdrawn: ",'rsvpmaker-for-toastmasters').' '.clean_role($role);
		do_action('toastmasters_agenda_notification',$post_id,$actiontext,$current_user->ID);
		awesome_wall("withdrawn: ".clean_role($role),$post_id);
}

if(isset($_POST['tweaktime']))
{
	$post = get_post($post_id);
	$content = $post->post_content;
	foreach($_POST['tweaktime'] as $role)
	{
		if(strpos($role,'ote') == 1)
		{
		//echo '/{"uid":"'.$role.'[^}]+}/';
		preg_match('/{.+"uid":"'.$role.'[^}]+}/',$content, $matches );
		$roleindex = $role;
		//echo ' note match: ';
		//print_r($matches);
		}
		else
		{
		$roleindex = preg_replace('/[^a-zA-Z]/','',$role);
		preg_match('/{"role":"'.$role.'[^}]+}/',$content, $matches );			
		//echo ' role match: ';
		//print_r($matches);
		}
		if(!empty($matches[0]))
		{
		$minutes = $_POST['tweakminutes'][$roleindex];
		$data = json_decode($matches[0]);
		if(isset($_POST['tweakcount'][$roleindex]))
		{
		$count = $_POST['tweakcount'][$roleindex];
		$data->count = $count;			
		}
		if(isset($_POST['tweakpadding'][$roleindex]))
		{
		$padding_time = $_POST['tweakpadding'][$roleindex];
		$data->padding_time = $padding_time;			
		}
		$data->time_allowed = $minutes;
		$new = json_encode($data);
		$content = str_replace($matches[0],$new,$content);
			
		if(($role == 'Speaker') && isset($_POST['tweakevaltoo']) )
			{
			preg_match('/{"role":"Evaluator[^}]+}/',$content, $matches );			
			if(!empty($matches[0]))
			{
			$data = json_decode($matches[0]);
			$data->count = $count;
			$data->time_allowed = round($count * 3.5);
			$new = json_encode($data);
			$content = str_replace($matches[0],$new,$content);
			}
			
			}			
		}
	}
	wp_update_post(array('ID' => $post_id,'post_content' => $content));
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

function wpt_tweak_notes_x ($matches) {
	$data = json_decode($matches[1]);
	$time = (empty($data->time_allowed)) ? '' : $data->time_allowed;
	$timeopt = '';
	for($ii = 0; $ii <= 60; $ii++)
	{
		$s = ($ii == $time) ? ' selected="selected" ' : '';
		$timeopt .= sprintf('<option value="%s" %s>%s</option>',$ii,$s,$ii);
	}
	$form = sprintf('<div><span id="time%s" class="toasttime"></span> <input type="checkbox" name="tweaktime[]" value="%s" show="opt%s" class="timecheck" /> Tweak Timing for note below</div><div class="timeopt" id="opt%s"> Minutes <select name="tweakminutes[%s]" class="tweakminutes" timetarget="%s">%s</select><div><button>Save</button></div></div>',$data->uid,$data->uid,$data->uid,$data->uid,$data->uid,$data->uid,$timeopt);
	return $matches[0].$form;
}

function wpt_tweak_notes ($content)
{
	if(!isset($_GET['edit_roles']))
		return $content;
	if(!current_user_can('edit_signups') && !edit_signups_role() )
		return $content;
	$content = str_replace('class="wp-block-wp4toastmasters-agendanoterich2"','',$content);
	
	$content = preg_replace_callback('/<!-- wp:wp4toastmasters\/agendanoterich2 ({[^}]+}) -->/','wpt_tweak_notes_x',$content);
return $content;
}

if(function_exists('do_blocks'))
	add_filter('the_content','wpt_tweak_notes',1);

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


function speaker_details ($field, $assigned = 0, $atts) {
$demo = (isset($atts['demo']));
global $post;
global $current_user;
$post_id = (isset($post) && isset($post->ID)) ? $post->ID : 0;
$output = $title = "";

		$manual = (isset($post->ID)) ? get_post_meta($post->ID, '_manual'.$field, true) : '';
		if(empty($manual) || strpos($manual,'hoose Manual') || strpos($manual,'elect Manual'))
			{
			if(isset($_REQUEST["edit_roles"]) || isset($_REQUEST["recommend_roles"]) || is_admin() )
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
		<input type="hidden" name="post_id" value="'.$post_id.'" />
		<select class="speaker_details manual" name="_manual['.$field.']" id="_manual_'.$field.'"">'.get_manuals_options($manual).'</select><br /><select class="speaker_details project" name="_project['.$field.']" id="_project_'.$field.'">'.$project_options.'</select>';
		$output .= '<div id="_tmsg_'.$field.'"></div></div>';
		if(!$demo)
		{
			$display_time = get_post_meta($post_id, '_display_time'.$field,true);
			$output .= '<div class="time_required">Timing: <input type="text"class="speaker_details" name="_display_time['.$field.']" id="_display_time_'.$field.'" size="10" value="'.$display_time.'">';
			$output .= ' Maximum Time: <input type="text"class="speaker_details '.$maxclass.'" name="_maxtime['.$field.']" id="_maxtime_'.$field.'" size="4" value="'.$time.'"></div>';
			$title = get_post_meta($post_id, '_title'.$field, true);
			$intro = get_post_meta($post_id, '_intro'.$field, true);	
		}

		$output .= '<div class="speech_title">Title: <input type="text" class="speaker_details title_text" id="title_text'.$field.'" name="_title['.$field.']" value="'.$title.'" /></div>';
		if(!$demo)
			$output .= '<div class="speaker_introduction">Introduction: <br /><textarea class="intro_'.$field.'" name="_intro['.$field.']" id="_intro_'.$field.'" style="width: 100%; height: 4em;">'.$intro.'</textarea></div>';
		$output = apply_filters('speaker_form_extra',$output,$field);	

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

function speech_public_details ($field, $assigned) {
global $post;

		$manual = get_post_meta($post->ID, '_manual'.$field, true);
		$title = get_post_meta($post->ID, '_title'.$field, true);
		$project_key = get_post_meta($post->ID, '_project'.$field, true);
		$project_text = get_project_text($project_key);
		$project_text .= evaluation_form_link($assigned, $post->ID, $project_key);	
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
		return apply_filters('speech_details_public',$output,$field);
}

function evaluation_form_link ($speaker, $meeting_id, $project_key) {
	if(isset($_GET['print_agenda']))
		return '';
	$slug = (empty($project_key)) ? 'unspecified' : urlencode($project_key);
	if(!isset($_GET['print_agenda']))
	return sprintf(' (<a href="%s" target="_blank">%s</a>)',admin_url('admin.php?page=wp4t_evaluations&speaker='.$speaker.'&meeting_id='.$meeting_id.'&project='.$slug),__('evaluation form','rsvpmaker-for-toastmasters'));	
}

function speech_progress () {
global $wpdb;
global $current_user;

if(isset($_REQUEST["select_user"]))
	{
	$user_id = $_REQUEST["select_user"];
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
			if(isset($_REQUEST["select_user"]) && $_REQUEST["select_user"])
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
fix_timezone();
$now = date('Y-m-d H:i:s');
	$sql = "SELECT DISTINCT $wpdb->posts.ID as postID, $wpdb->posts.*, a1.meta_value as datetime, a2.meta_value as template
	 FROM ".$wpdb->posts."
	 JOIN ".$wpdb->postmeta." a1 ON ".$wpdb->posts.".ID =a1.post_id AND a1.meta_key='_rsvp_dates'
	 JOIN ".$wpdb->postmeta." a2 ON ".$wpdb->posts.".ID =a2.post_id AND a2.meta_key LIKE '_Speaker%' AND a2.meta_value=".$user_id."  AND concat('',a2.meta_value * 1) = a2.meta_value
	 WHERE a1.meta_value < '".$now."'
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
if(!is_serialized($raw))
	return;
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
$mm = get_option('wp4toastmasters_mailman');

if(!empty($_POST["guestlist"]))
	{
	foreach($_POST["guestlist"] as $email)
		{
			add_to_mailman($email,'g');
		}
	printf('<p>Attempted to add %s email addresses to guest list. Verify by visiting <a href="%s">%s</a>, password: %s</p>',sizeof($_POST["guestlist"]),$mm["gpath"],$mm["gpath"],$mm["gpass"]);
	}

if(!empty($_REQUEST["reset"]))
	{
	if(!empty($_REQUEST["reset_confirm"]))
		{
			$wpdb->query("TRUNCATE ".$wpdb->prefix."users_archive");
			user_archive();
		}
	else
		{
			echo '<p>'.__('Are you sure you want to delete the user records archive?','rsvpmaker-for-toastmasters').' <a href="'.admin_url('users.php?page=extended_list&reset=1&reset_confirm=1').'">'.__('Yes','rsvpmaker-for-toastmasters').'</a></p>';
		}
	}

if(isset($_GET['make_user_member']))
{
$user_id = (int) $_GET['make_user_member'];
if(is_multisite())
	make_blog_member($user_id);
$userdata = get_userdata($user_id);
$msg = $userdata->first_name.' '.$userdata->last_name.' '.__('added to website','rsvpmaker-for-toastmasters');
echo '<div class="notice notice-success is-dismissible"><p>'.$msg.'</p></div>';
}
	
if(isset($_REQUEST["unsubscribe"]))
{
	$e = strtolower(trim($_REQUEST["unsubscribe"]));
	$unsub = get_option('rsvpmail_unsubscribed');
	if(!is_array($unsub))
		$unsub = array();
	if(!in_array($e,$unsub))
		$unsub[] = $e;
	update_option('rsvpmail_unsubscribed',$unsub);
	do_action('rsvpmail_unsubscribe',$e);
}

if(isset($_REQUEST["resubscribe"]))
{
	$e = strtolower(trim($_REQUEST["resubscribe"]));
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
unset($newuser["ID"]);
$newuser["user_pass"] = wp_generate_password();
$member_factory = new Toastmasters_Member();

//$result = wp_insert_user($newuser);
$result = $member_factory->add($newuser);
$member_factory->show_confirmations();

foreach($newuser as $key => $value)
{
	if(is_serialized($value))
	{
		add_user_meta($result, $key, unserialize($value));
	}
	elseif(strpos($key,'user') === false)
	{
		add_user_meta($result, $key, $value);
	}
}

}

if(isset($_REQUEST["lookup"]))
{
$sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."users_archive WHERE sort=%s",$_REQUEST["lookup"]);
$row = $wpdb->get_row($sql);
$guest = $row->guest;
$userdata = unpack_user_archive_data($row->data);
}
elseif(isset($_REQUEST["activate"]))
{
$sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."users_archive WHERE sort=%s",$_REQUEST["activate"]);
$row = $wpdb->get_row($sql);
if(isset($row->data))
{
$newuser = unpack_user_archive_data($row->data);
?>
<form action="<?php echo admin_url('users.php?page=extended_list'); ?>" method="post">
<h3><?php _e('Activate Member Account','rsvpmaker-for-toastmasters');?></h3>
<p><?php echo $newuser["first_name"] .' '.$newuser["last_name"] .' '.$newuser["user_email"] ?></p>
<p><input type="submit" value="<?php _e("Activate",'rsvpmaker-for-toastmasters');?>"></p>
<input type="hidden" name="activate" value="<?php echo $_REQUEST["activate"]; ?>" />
</form>
<?php
}

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
		if(isset($_REQUEST["debug"]))
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
			$account_exists = get_userdata($userdata["ID"]);
			if($account_exists)
				$status = ' - '.__('Former Member','rsvpmaker-for-toastmasters').' <a href="'.admin_url('users.php?page=extended_list&make_user_member=').$userdata["ID"].'">('.__('Reactivate','rsvpmaker-for-toastmasters').')</a><br />'.__('Updated','rsvpmaker-for-toastmasters').': '.$row->updated;
			else
				$status = ' - '.__('Former Member','rsvpmaker-for-toastmasters').' <a href="'.admin_url('users.php?page=extended_list&lookup=').$row->sort.'">('.__('Edit','rsvpmaker-for-toastmasters').')</a> <a href="'.admin_url('users.php?page=extended_list&activate=').$row->sort.'">('.__('Reactivate','rsvpmaker-for-toastmasters').')</a> <br />'.__('Updated','rsvpmaker-for-toastmasters').': '.$row->updated;
			if(isset($userdata["user_email"]) && !in_array($userdata["user_email"],$unsubscribed))
				{
				$former_list .= $userdata["user_email"].", ";
				$f_email[] = $userdata["user_email"];
				}
			if(isset($_REQUEST['guests_only']))
				continue;
			}
		elseif($row->guest)
			{
			if(isset($userdata["user_email"]) && !in_array($userdata["user_email"],$unsubscribed))
				{
				$guest_list .= $userdata["user_email"].", ";
				$g_email[] = $userdata["user_email"];
				}
			$status = ' - '.__('Guest','rsvpmaker-for-toastmasters').' <a href="'.admin_url('users.php?page=extended_list&lookup=').$row->sort.'">('.__('Edit','rsvpmaker-for-toastmasters').')</a> <a href="'.admin_url('users.php?page=extended_list&activate=').$row->sort.'">('.__('Convert to Member','rsvpmaker-for-toastmasters').')</a><br />'.__('Updated','rsvpmaker-for-toastmasters').': '.$row->updated;
			if(isset($_REQUEST['former_only']))
				continue;
			}
		else
			{
			if(isset($_REQUEST['guests_only']) || isset($_REQUEST['former_only']))
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

if(isset($mm["gpass"]))
{
if(!empty($g_email) || !empty($f_email))
	{
	echo '<h2>Add to Guest Email List</h2>';
	printf('<form action="%s" method="post">',admin_url('users.php?page=extended_list'));
	if(!empty($g_email))	
		{		
		sort($g_email);
		echo '<h3>Guests</h3>';
		foreach($g_email as $email)
			{
				printf('<div><input type="checkbox" name="guestlist[]" value="%s" /> %s</div>',$email,$email);
			}
		}	
	if(!empty($f_email))
		{
		echo '<h3>Former Members</h3>';
		sort($f_email);
		foreach($f_email as $email)
			{
				printf('<div><input type="checkbox" name="guestlist[]" value="%s" /> %s</div>',$email,$email);
			}
		}
	echo '<p><button>Add</button></p></form>';
	}	
printf('<p>See also <a href="%s">Mailman Mailing Lists</a></p>',admin_url('users.php?page=mailman'));

}
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
	
	
if(isset($_REQUEST["user_id"]))
	{
	$user_id = (int) $_REQUEST["user_id"];
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
	//if($userdata->hidden_profile)
	//	continue;
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

if(!function_exists('do_blocks'))
add_submenu_page('edit.php?post_type=rsvpmaker', __("Agenda Timing",'rsvpmaker-for-toastmasters'), __("Agenda Timing",'rsvpmaker-for-toastmasters'), $security['edit_signups'], "agenda_timing", "agenda_timing");

add_submenu_page('profile.php', __("Add Members",'rsvpmaker-for-toastmasters'), __("Add Members",'rsvpmaker-for-toastmasters'), 'edit_others_posts', "add_awesome_member", "add_awesome_member" );

add_submenu_page('profile.php', __("Set Away Status",'rsvpmaker-for-toastmasters'), __("Set Away Status",'rsvpmaker-for-toastmasters'), 'read', "wp4t_set_status_form", "wp4t_set_status_form" );

add_submenu_page('profile.php', __("Edit Members",'rsvpmaker-for-toastmasters'), __("Edit Members",'rsvpmaker-for-toastmasters'), 'edit_members', "edit_members", "edit_members" );
add_submenu_page('profile.php', __("Guests/Former Members",'rsvpmaker-for-toastmasters'), __("Guests/Former Members",'rsvpmaker-for-toastmasters'), 'edit_members', "extended_list", "extended_list" );
$mm = get_option('wp4toastmasters_mailman');
if(!empty($mm["mpass"]) || !empty($mm["opass"]) || !empty($mm["gpass"]))
add_submenu_page('profile.php', __("Mailman Mailing List",'rsvpmaker-for-toastmasters'), __("Mailman Mailing List",'rsvpmaker-for-toastmasters'), 'edit_members', "mailman", "mailman" );

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
      <a class="nav-tab" href="#rules">Rules</a>
      <a class="nav-tab" href="#onlinemeetings">Online Meetings</a>
    </h2>

    <div id="sections" class="rsvpmaker" >
    <section class="rsvpmaker"  id="basic">
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
	<p><input type="radio" name="wp4toastmasters_enable_sync" value="0" <?php if(!$wp4toastmasters_enable_sync) echo ' checked="checked" '; ?> /> <?php _e("No, do not share data outside of this club website",'rsvpmaker-for-toastmasters');?></p>
	<p><a href="<?php echo admin_url('options-general.php?page=wp4toastmasters_settings&reset_sync_count=1'); ?>"><?php _e("Reset sync count",'rsvpmaker-for-toastmasters');?></a></p>
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
		
		//if($member->hidden_profile)
		//	continue;
		
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
$contributor_notification = get_option('wpt_contributor_notification');
if(empty($contributor_notification))
	$contributor_notification = get_option('admin_email');
echo '<h3>Contributor Notifications</h3><p>'.__('Users assigned the Contributor role may submit blog posts for publication, but they must be approved by an author or editor. Who should be notified when contributor posts are submitted for review?','rsvpmaker-for-toastmasters').'<p>';
printf('<p><input type="text" name="wpt_contributor_notification" value="%s" size="150" /><br /><em>%s</em></p>',$contributor_notification, __('One or more email addresses, separated by commas. If you do not want these notifications, enter "none"','rsvpmaker-for-toastmasters'));

echo '<h2>Communications Options</h2>';
do_action('wpt_mailing_list_message');
if(function_exists('rsvpmaker_relay_init'))
{
	$vars = get_option('rsvpmaker_discussion_member');
	$member_list = (!empty($vars['user']) && !empty($vars['password'])) ? $vars['user'] : '(not set)';
	$vars = get_option('rsvpmaker_discussion_officer');	
	$officer_list = (!empty($vars['user']) && !empty($vars['password'])) ? $vars['user'] : '(not set)';
	$active = get_option('rsvpmaker_discussion_active');	
	printf('<h3>Member and Officer Email Lists (RSVPMaker)</h3><p>The Group Email function in RSVPMaker allows you to create email discussion lists. Previously, we recommended integrations with WP Mailster and the Mailman utility.</p><p><a href="%s">View Options</a></p><p>Status: %s</p><p>Member List: %s</p><p>Officer List: %s</p>',admin_url('options-general.php?page=rsvpmaker-admin.php&tab=groupemail'),($active) ? 'On' : 'Off',$member_list,$officer_list);
	echo '<h3>Mailing Lists: Other Options</h3>';
}
do_action('wpt_mailing_list_message');

$wp4toastmasters_mailman = get_option('wp4toastmasters_mailman');

if(function_exists('mailster_install'))
	printf('<h3>Mailster Mailing List</h3><p><a href="%s">Manage Mailster Mailing List</a> - add addresses to whitelist, tweak settings</p>',admin_url('admin.php?page=mailster_toastmasters'));
elseif(current_user_can('update_core'))
{
	if(empty($wp4toastmasters_mailman) && !isset($_GET['show_mailman']))
	{
	printf('<p>Click to see options for integration with <a href="%s">Mailman</a>. Current recommendation: use the RSVPMaker Group Mail feature instead.</p>',admin_url('options-general.php?page=wp4toastmasters_settings&show_mailman=1'));
	}
	else {
	// restrict this to network admin on multisite
echo get_option('wp4toastmasters_mailman_default');

?>
<h3><?php _e("Member Email List (Mailman)",'rsvpmaker-for-toastmasters');?></h3>
<p>(See <a href="http://wp4toastmasters.com/2016/11/28/email-list-integration-for-your-toastmasters-club/" target="_blank"><?php _e("Documentation",'rsvpmaker-for-toastmasters');?></a>)</p>
<?php

?>
<p><?php _e("List email address",'rsvpmaker-for-toastmasters');?>: <input type="text" name="wp4toastmasters_mailman[members]" value="<?php if(isset($wp4toastmasters_mailman["members"])) echo $wp4toastmasters_mailman["members"]; ?>" /></p>
<p><?php _e("Path",'rsvpmaker-for-toastmasters');?>: <input type="text" name="wp4toastmasters_mailman[mpath]" value="<?php if(isset($wp4toastmasters_mailman["mpath"])) echo $wp4toastmasters_mailman["mpath"]; ?>" /> <?php _e("Password",'rsvpmaker-for-toastmasters');?>: <input type="text" name="wp4toastmasters_mailman[mpass]" value="<?php if(isset($wp4toastmasters_mailman["mpass"])) echo $wp4toastmasters_mailman["mpass"]; ?>" /></p>
<?php if(isset($wp4toastmasters_mailman["mpass"])) {
	printf('<p><a href="%s&mailman_add_members=1">'.__('Add current members to mailing list','rsvpmaker-for-toastmasters').'</a></p>',admin_url('options-general.php?page=wp4toastmasters_settings'));
	}

if(isset($_REQUEST["mailman_add_members"]))
{
    $users = get_users();
	foreach ($users as $user) {
		add_to_mailman($user->ID);
	}
}

if(isset($_REQUEST["mailman_add_officers"]))
{
    foreach ($wp4toastmasters_officer_ids as $user_id) {
		add_to_mailman($user_id,'o');
	}
}

?>

<h3><?php _e("Officer Email List (Mailman)",'rsvpmaker-for-toastmasters');?></h3>
<p><?php _e("List email address",'rsvpmaker-for-toastmasters');?>: <input type="text" name="wp4toastmasters_mailman[officers]" value="<?php if(isset($wp4toastmasters_mailman["officers"])) echo $wp4toastmasters_mailman["officers"]; ?>" /></p>
<p><?php _e("Path",'rsvpmaker-for-toastmasters');?>: <input type="text" name="wp4toastmasters_mailman[opath]" value="<?php if(isset($wp4toastmasters_mailman["opath"])) echo $wp4toastmasters_mailman["opath"]; ?>" /> <?php _e("Password",'rsvpmaker-for-toastmasters');?>: <input type="text" name="wp4toastmasters_mailman[opass]" value="<?php if(isset($wp4toastmasters_mailman["opass"])) echo $wp4toastmasters_mailman["opass"]; ?>" />

<?php if(isset($wp4toastmasters_mailman["opass"])) {
	printf('<p><a href="%s&mailman_add_officers=1">'.__("Update officers mailing list",'rsvpmaker-for-toastmasters').'</a></p>',admin_url('options-general.php?page=wp4toastmasters_settings'));
	}
?>

<h3><?php _e("Guest Email List (Mailman)",'rsvpmaker-for-toastmasters');?></h3>
<p><?php _e("List email address",'rsvpmaker-for-toastmasters');?>: <input type="text" name="wp4toastmasters_mailman[guest]" value="<?php if(isset($wp4toastmasters_mailman["guest"])) echo $wp4toastmasters_mailman["guest"]; ?>" /></p>
<p><?php _e("Path",'rsvpmaker-for-toastmasters');?>: <input type="text" name="wp4toastmasters_mailman[gpath]" value="<?php if(isset($wp4toastmasters_mailman["gpath"])) echo $wp4toastmasters_mailman["gpath"]; ?>" /> <?php _e("Password",'rsvpmaker-for-toastmasters');?>: <input type="text" name="wp4toastmasters_mailman[gpass]" value="<?php if(isset($wp4toastmasters_mailman["gpass"])) echo $wp4toastmasters_mailman["gpass"]; ?>" />

<?php
	}//end show mailman options
}
?>
<h3>Messages</h3>
<p><?php _e("Message for Login Page",'rsvpmaker-for-toastmasters');?><br />
<textarea name="wp4toastmasters_login_message" rows="3" cols="80"><?php echo get_option('wp4toastmasters_login_message'); ?></textarea></p>

<p><?php _e("Message To Members on Dashboard",'rsvpmaker-for-toastmasters');?><br />
<textarea name="wp4toastmasters_member_message" rows="3" cols="80"><?php echo $wp4toastmasters_member_message; ?></textarea></p>

<p><?php _e("Message To Officers on Dashboard",'rsvpmaker-for-toastmasters');?><br />
<textarea name="wp4toastmasters_officer_message" rows="3" cols="80"><?php echo $wp4toastmasters_officer_message; ?></textarea></p>

<h3><?php _e("Include Time/Timezone on Agenda Email",'rsvpmaker-for-toastmasters');?></h3>
<p><input type="radio" name="wp4toastmasters_agenda_timezone" value="1" <?php if($wp4toastmasters_agenda_timezone) echo ' checked="checked" '; ?> /> <?php _e("Yes",'rsvpmaker-for-toastmasters');?> <input type="radio" name="wp4toastmasters_agenda_timezone" value="0" <?php if(!$wp4toastmasters_agenda_timezone) echo ' checked="checked" '; ?> /> <?php _e("No",'rsvpmaker-for-toastmasters');?>.</p>

<?php 
//$reminder_options = array('1 hours' => '1 hour before','2 hours' => '2 hours before','3 hours' => '3 hours before','4 hours' => '4 hours before','5 hours' => '5 hours before','6 hours' => '6 hours before','7 hours' => '7 hours before','8 hours' => '8 hours before','9 hours' => '9 hours before','10 hours' => '10 hours before','11 hours' => '11 hours before','12 hours' => '12 hours before','1 days' => '1 day before','2 days' => '2 days before','3 days' => '3 days before','4 days' => '4 days before','5 days' => '5 days before','6 days' => '6 days before');

$end = 6 * 24;
for($i = 1; $i <= $end; $i++) {
	if($i > 6)
		$i += 5;
	if(($i >= 24) && !($i % 24))
	{
		$key = $label = ($i / 24) . ' days';		
	}
	elseif($i >= 24)
	{
		$key = $i.' hours';
		$label = floor($i/24) . ' days '.($i % 24).' hours';
	}
	else
	{
		$key = $i.' hours';
		$label = $i . ' hours';
	}
	$reminder_options[$i .' hours'] = $label.' before';
	//printf('<div>%s %s</div>',$i,$label);
}
	
	
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
<?php
echo wp4toast_reminders_cron_status();
?>
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
<br /><input type="radio" name="wpt_remind_all" value="0" <?php $all = get_option('wpt_remind_all'); if(empty($all)) echo ' checked="checked" '; ?> /> Send automated reminders to members with a role
	<br /><input type="radio" name="wpt_remind_all" value="1" <?php if(!empty($all)) echo ' checked="checked" '; ?> /> Send role reminders and <strong>also send a meeting reminder to everyone else</strong>
</p>

<p>See also <a href="edit.php?post_type=rsvpemail&amp;page=rsvpmaker_notification_templates">Email Notification/Reminder Templates</a></p>

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
wp4toastmasters_agenda_layout_check('custom'); //add layout post if doesn't already exist
$layout_id = get_option('rsvptoast_agenda_layout');
if($layout_id && ($wp4toastmasters_agenda_layout == 'custom'))
	printf('<br />&nbsp;<a href="%s">%s</a>',admin_url('post.php?action=edit&post='.$layout_id),__('Edit Custom Agenda Layout','rsvpmaker-for-toastmasters'));

echo '<pre id="default_css">'.wpt_default_agenda_css().'</pre><br /><a id="default_css_show" href="#default_css">Show default CSS styles</a>';
?>
</p>

<p><?php _e("Agenda CSS Customization",'rsvpmaker-for-toastmasters');?> <br />
<?php agenda_css_customization_form();?>
<h3><?php _e('Show Stoplight (green/yellow/red) times','rsvpmaker-for-toastmasters'); ?></h3>
<?php $stoplight = get_option('wp4toastmasters_stoplight'); ?>
<p><input type="radio" name="wp4toastmasters_stoplight" value="1" <?php if($stoplight == 1) echo ' checked="checked" '; ?> /> <?php _e("Yes",'rsvpmaker-for-toastmasters');?></p>
<p><input type="radio" name="wp4toastmasters_stoplight" value="0" <?php if($stoplight != 1) echo ' checked="checked" '; ?> /> <?php _e("No",'rsvpmaker-for-toastmasters');?>.</p>

<h3><?php _e('Show Speech Introductions on Agenda','rsvpmaker-for-toastmasters'); ?></h3>
<?php $intros = get_option('wp4toastmasters_intros_on_agenda'); ?>
<p><input type="radio" name="wp4toastmasters_intros_on_agenda" value="1" <?php if($intros == 1) echo ' checked="checked" '; ?> /> <?php _e("Yes",'rsvpmaker-for-toastmasters');?></p>
<p><input type="radio" name="wp4toastmasters_intros_on_agenda" value="0" <?php if($intros != 1) echo ' checked="checked" '; ?> /> <?php _e("No",'rsvpmaker-for-toastmasters');?>.</p>


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
$allow_assign = get_option('allow_assign');

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
	<p><?php _e('Enable &quot;Suggest Assignments&quot; mode','rsvpmaker-for-toastmasters'); ?> <select name="allow_assign"><option value="">No</option><option value="yes" <?php if($allow_assign == 'yes') echo 'selected="selcted"'; ?> >Yes</option><option value="editor" <?php if($allow_assign == 'editor') echo 'selected="selcted"'; ?> >Only for Editor, Manager, Administrator roles</option></select>
		<br /><em>In this mode, the software semi-randomly assigns members without a role to open roles on the agenda.</em>
	</p>
<p><?php _e('Avoid selecting members who have','rsvpmaker-for-toastmasters'); ?><ul><li><?php _e('not attended in more than','rsvpmaker-for-toastmasters'); ?> <select name="last_attended_limit"><?php echo $last_attended_option; ?></select> <?php _e('days'); echo '</li><li>'; _e('or who have filled the same role within','rsvpmaker-for-toastmasters'); ?> <select name="last_filled_limit"><?php echo $last_filled_option; ?></select> <?php _e('days');?></li></ul> <p><?php _e('Note: If you use the random assignment of members to roles, you may wish to have the software favor members who have attended the club recently but have not filled the same role within the last few weeks. This works best after your club has built up some history recording meetings in the software. Recommended reasonable settings: members who have attended more recently than 56 days (2 months) but have not filled the same role in the last 14 days.','rsvpmaker-for-toastmasters'); ?></p>

<h3><?php _e("Automatically Lock Agenda",'rsvpmaker-for-toastmasters');?> </h3>
<p><select name="wpt_agenda_lock_policy">
<?php 
$lock = (int) get_option("wpt_agenda_lock_policy");
for($i=0; $i <= 24; $i++)
	{
	$s = ($i == $lock) ? ' selected="selected" ' : '';
	$label = ($i == 0) ? 'No lock' : $i.' hours before meeting';
	printf('<option value="%s" %s>%s</option>',$i,$s,$label);
	}
?>
</select>
<br /><em>You can set the agenda to be locked against changes one or more hours before the meeting start time. An administrator can remove the lock.</em>
</p>

<h3><?php _e("Member Role Planner",'rsvpmaker-for-toastmasters');?> </h3>
<p>The planner allows members to sign up for roles several weeks in advance.</p>
	<p>Promote planner on agenda signup pages? <select name="hide_planner_promo"><option value="">Yes</option><option value="no" <?php if(!empty(get_option('hide_planner_promo'))) echo ' selected="selected" ' ?> >No</option></select>
	</p>

<h3><?php _e("Page Containing Welcome Message",'rsvpmaker-for-toastmasters');?> </h3>
<?php
$args = array('post_type' => 'page','orderby' => 'title','order' => 'ASC','posts_per_page' => 50);
$posts = get_posts($args);
$options = '<option value="">None</option>';
foreach($posts as $p)
	{
	if($p->ID == $wp4toastmasters_welcome_message)
	{
		$s = ' selected="selected" ';
		$welcome_title = $p->post_title;
	}
	else
		$s = '';
	$options .= sprintf('<option value="%s" %s>%s</option>',$p->ID, $s, $p->post_title);
	}
if($wp4toastmasters_welcome_message)
	printf('<p>Edit <a href="%s">%s</a>',admin_url('post.php?action=edit&post'.$wp4toastmasters_welcome_message),$welcome_title);
?>
<p><select name="wp4toastmasters_welcome_message">
<?php echo $options; ?>
</select>
	<br /><em>The content of this page will be appended to the message sent when you add a new member user account.</em></p>

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
<section class="rsvpmaker"  id="security">
<?php tm_security_caps(); ?>
</section>
<section class="rsvpmaker"  id="rules">
<p><em>Optional rules for how your club operates.</em></p>
<?php toastmasters_rule_setting(); ?>
</section>
<section class="rsvpmaker"  id="onlinemeetings">
<?php online_meeting_settings(); ?>
</section>
</div>

</div>
<?php 
}

function online_meeting_settings () {
?>
<p>Jitsi online meeting integration, with a speaker timing lights function, is enabled by default. With a little extra configuration, Zoom integration can also be enabled.</p>
<p><em>Zoom support is a work in progress. So far, users must authenticate at zoom.us first before accessing the page, or the video feed is not displayed.</em></p>
<?php
if(isset($_POST['zoomon']))
{
	activate_plugin('wp-zoom-addon/wp-zoom-addon.php');
	update_option('tm_online_meeting',array('platform' => 'Zoom'));
}
if(isset($_POST['tm_online_meeting']))
	{
		$online = $_POST['tm_online_meeting'];
		update_option('tm_online_meeting',$online);
		echo '<div class="updated"><p>Online meeting settings updated</p></div>';
	}
else
{
	$online = get_option('tm_online_meeting');
}

if(!empty($_POST['zoom_api_key']))
	update_option('zoom_api_key',$_POST['zoom_api_key']);
if(!empty($_POST['zoom_api_secret']))
	update_option('zoom_api_secret',$_POST['zoom_api_secret']);

$platform = (empty($online['platform'])) ? 'Jitsi' : $online['platform'];
$personal_meeting_id = (empty($online['personal_meeting_id'])) ? '' : $online['personal_meeting_id'];
$password = (empty($online['password'])) ? '' : $online['password'];

if ( is_plugin_active( 'wp-zoom-addon/wp-zoom-addon.php' ) ) {
echo '<h3>Zoom add-on enabled</h3>';
$zoom_api_key                   = get_option( 'zoom_api_key' );
$zoom_api_secret                = get_option( 'zoom_api_secret' );
$zoom_url_enable                = get_option( 'zoom_url_enable' );
$zoom_vanity_url                = get_option( 'zoom_vanity_url' );
$zoom_alternative_join          = get_option( 'zoom_alternative_join' );
$zoom_help_text_disable         = get_option( 'zoom_help_text_disable' );
$zoom_compatiblity_text_disable = get_option( 'zoom_compatiblity_text_disable' );
$zoom_subscribe_link            = get_option( 'zoom_subscribe_link' );
$settings_url = admin_url('admin.php?page=zoom-video-conferencing-settings');
if($zoom_api_key)
	echo '<p>API key is set</p>';
else
	printf('<p>API key NOT set. <a href="%s">Settings</a></p>',$settings_url);
if($zoom_api_secret)
	echo '<p>API secret is set</p>';
else
	printf('<p>API secret NOT set. <a href="%s">Settings</a></p>',$settings_url);
	?>
	<form action="<?php echo admin_url('options-general.php?page=wp4toastmasters_settings');?>" method="post">
	<p>Platform
	<br /><select name="tm_online_meeting[platform]">
	<option value="Jitsi" <?php if($platform == 'Jitsi') echo ' selected="selected" '; ?> >Jitsi</option>
	<option value="Zoom" <?php if($platform == 'Zoom') echo ' selected="selected" '; ?>>Zoom</option>
	<option value="Both" <?php if($platform == 'Both') echo ' selected="selected" '; ?> >Both</option>
	</select>
	</p>
	<p>Zoom Personal Meeting ID
	<br /><input name="tm_online_meeting[personal_meeting_id]" value="<?php echo $personal_meeting_id;?>" />
	</p>
	
	<p><button>Submit</button></p>
	</form>
	<?php	
} 
else {
	if(file_exists(WP_PLUGIN_DIR.'/wp-zoom-addon/wp-zoom-addon.php')) {
		echo '<p>The plugin required for Zoom integration is installed but not activated.</p>';
		echo '<p>Before activating the plugin, you will need to optain the required integration credentials, a "key" and a "secret." You do that by visiting the <a href="https://marketplace.zoom.us/develop/create">Create App</a> screen in the Zoom marketplace and choosing JTW (see image below).</p>';
		printf('<form method="post" action="%s"><input type="hidden" name="zoomon" value="1">
		<p>Key<br /><input type="text" name="zoom_api_key"></p>
		<p>Secret<br /><input type="text" name="zoom_api_secret"></p>
		<button>Activate</button></form>',admin_url('options-general.php?page=wp4toastmasters_settings'));
		$imageurl = plugins_url('/rsvpmaker-for-toastmasters/images/zoom-jwt.png');
		echo '<p><img src="'.$imageurl.'" width="600" height="450" /></p>';
		}
	else
		echo '<p>To enable Zoom integration you must download and install <a href="https://elearningevolve.com/products/category/wordpress-plugins/" target="_blank">Zoom integration plugin</a> by eLearning evolve</p>';
}

}

function toastmasters_rule_setting () {
	$security_roles = array('manager','editor','author','contributor','subscriber');

	if(isset($_POST['signup_security']) || isset($_POST['toastmasters_rules']))
		echo '<div class="updated"><p>Updated Custom Rules</p></div>';

	if(isset($_POST['signup_security'])) {
		foreach($security_roles as $role)
			{
				$tm_role = get_role($role);				
				if(isset($_POST['signup_security'][$role]))
					$tm_role->add_cap('edit_signups');
				else
					$tm_role->remove_cap('edit_signups');
			}

		if(isset($_POST['edit_signups_meeting_roles']))
			update_option('edit_signups_meeting_roles',$_POST['edit_signups_meeting_roles']);
		else
			delete_option('edit_signups_meeting_roles');
	}
	if(isset($_POST['toastmasters_rules']))
		update_option('toastmasters_rules',$_POST['toastmasters_rules']);
	
$rules = get_option('toastmasters_rules');
if(empty($rules))
	{
		$rules['cost'] = 2;
		$rules['start'] = 4;
	}
if(empty($rules["start_date"]) ) $rules["start_date"] = date('Y').'-01-01';

printf('<form method="post" action="%s">',admin_url('options-general.php?page=wp4toastmasters_settings'));
?>
<h3>Access to Edit Signups</h3>
<p>Security roles, in addition to administrator who can edit other members' role signups:</p>
<?php 
foreach($security_roles as $role)
{
	$r = get_role($role);
	$cap = $r->has_cap('edit_signups');
	$ck = ($cap) ? '<input type="checkbox" name="signup_security['.$role.']" value="1" checked="checked"/> ' : '<input type="checkbox"  name="signup_security['.$role.']" value="1" />';
	$regular = ($role == 'subscriber') ? ' (Regular member)' : '';
	printf('<p>%s %s %s</p>',$ck,ucfirst($role),$regular);
}
?>
<p>Meeting-specific roles who can edit other members' role signups:</p>
<?php
$meeting_roles = array('Toastmaster of the Day','General Evaluator');
$edit_signups_meeting_roles = get_option('edit_signups_meeting_roles');
foreach($meeting_roles as $role)
{
	{
		$key = '_'.str_replace(' ','_',$role).'_1';
		$cap = (!empty($edit_signups_meeting_roles[$role]));
		$ck = ($cap) ? '<input type="checkbox" name="edit_signups_meeting_roles['.$role.']" value="'.$key.'" checked="checked"/> ' : '<input type="checkbox"  name="edit_signups_meeting_roles['.$role.']" value="'.$key.'"/> ';
		printf('<p>%s %s</p>',$ck,ucfirst($role));
	}	
}
?>
<h3>Points System</h3>
<p>You can measure how well members balance their participation in the club using a system where speakers earn 1 point for each supporting role they fill in your meetings and are charged points for each speech they give. Optionally, members can be encouraged to pick another role or prevented from signing up for a speaker role if their score falls below zero. If neither of those options is selected, the information will simply be available on a <a href="<?php echo admin_url('admin.php?page=toastmasters_reports_dashboard&report=speaker'); ?>">Speaker Points Report</a> club leaders can consult for a snapshot of member participation.</p>
<p><select name="toastmasters_rules[points]" >
<option value="">Use for reporting only</option>
<option value="warn" <?php if($rules['points'] == 'warn') echo ' selected="selected" '; ?> >Warn member if score < 0</option>
<option value="prevent" <?php if($rules['points'] == 'prevent') echo ' selected="selected" '; ?>>Prevent self-service signup for score < 0</option>
<select></p>
<p><strong>Scoring rules</strong></p>
<p>Start count from <input type="text" name="toastmasters_rules[start_date]" value="<?php echo $rules["start_date"]; ?>" > <em>YEAR-MONTH-DAY format</em></p>
<p>Members start with <input type="text" name="toastmasters_rules[start]" value="<?php echo $rules["start"]; ?>" > points</p>
<p>Each speech signup uses <input type="text" name="toastmasters_rules[cost]" value="<?php echo $rules["cost"]; ?>" > points<br />
<em>Example: If you would like members to fill supporting roles about twice as often as they speak, you would make the value above 2. If you give each member 4 points to start with, an eager new member can still give an Ice Breaker and another speech without immediately needing to fill other roles.</em></p>
<?php
if(isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'rules')
{
?>
<input type="hidden" id="activetab" value="rules" />
<?php	
}
?>
<input type="hidden" name="tab" value="rules">
<?php
submit_button();
echo '</form>';
}

function agenda_css_customization_form() {
?>
<textarea rows="3" cols="80" name="wp4toastmasters_agenda_css">
<?php echo get_option('wp4toastmasters_agenda_css'); ?>
</textarea>
<br /><?php _e('Examples','rsvpmaker-for-toastmasters'); ?>:<br /><code>p, div, li {font-size: 14px;}</code> - <?php _e('increase the default font size for all text','rsvpmaker-for-toastmasters'); ?>
<br /><code>#agenda p, #agenda div, #agenda li  {font-size: 14px;}</code> - <?php _e('change the font size of the actual agenda but not the sidebar content','rsvpmaker-for-toastmasters'); ?>
<br /><code>#agenda {border-left: thick dotted #000;}</code> - <?php _e('add a dotted black line to the left of sidebar','rsvpmaker-for-toastmasters'); ?>
</p>
<?php
}

//call register settings function

function wptoast_reminder_clear() {
	$cron = _get_cron_array();
	if(empty($cron))
		return;
	$newcron = array();
	foreach ($cron as $timestamp => $events)
	{
		foreach($events as $slug => $details)
		{
		if($slug == 'wp4toast_reminders_cron')
		{
		$item = array_pop($details);
		if(isset($item['args']))
		{
			$cronargs[] = $item['args'];
		}

		}

		}
	}
	
	if(!empty($cronargs))
		foreach ($cronargs as $args)
			wp_clear_scheduled_hook('wp4toast_reminders_cron',$args);
}

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
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_stoplight' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_intros_on_agenda' );
	register_setting( 'wp4toastmasters-settings-group', 'tm_signup_count' );
	register_setting( 'wp4toastmasters-settings-group', 'last_filled_limit' );
	register_setting( 'wp4toastmasters-settings-group', 'last_attended_limit' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toast_reminder' );
	register_setting( 'wp4toastmasters-settings-group', 'wp4toast_reminder2' );
	register_setting( 'wp4toastmasters-settings-group', 'wpt_remind_all' );	
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_agenda_timezone' );
	register_setting( 'wp4toastmasters-settings-group', 'allow_assign' );
	register_setting( 'wp4toastmasters-settings-group', 'hide_planner_promo' );
	register_setting( 'wp4toastmasters-settings-group', 'wpt_contributor_notification' );
	register_setting( 'wp4toastmasters-settings-group', 'wpt_agenda_lock_policy' );

	if(isset($_POST['wp4toast_reminder']))
		{
				// clear cron
			wptoast_reminder_clear();
			if(!empty($_POST['wp4toast_reminder']))
				{
					$p = explode(' ',$_POST['wp4toast_reminder']);
					if($p[1] == 'hours')
						$hours = $p[0];
					else
						$hours = $p[0] * 24;
					
					$fudge = $hours + 1;
					$future = get_future_events(" (post_content LIKE '%role=%' OR post_content LIKE '%wp:wp%') ",1);
					if(sizeof($future))
						{
						$next = $future[0];
						fix_timezone();
						$timestamp = strtotime($next->datetime .' -'.$hours.' hours');
						wp_schedule_event( $timestamp, 'weekly', 'wp4toast_reminders_cron', array( $hours ) );
						update_option('wp4toast_reminders_cron', 1);
						}
				}
			//adjust for time change, which happens on a sunday
			wp_clear_scheduled_hook('wp4toast_reminders_dst_fix');
			wp_schedule_event( strtotime('next Sunday 05:00:00'), 'weekly', 'wp4toast_reminders_dst_fix');
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
					$future = get_future_events(" (post_content LIKE '%role=%' OR post_content LIKE '%wp:wp%') ",1);
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

function wp4toast_reminders_cron_status() {
global $rsvp_options;
$cron = get_option('cron');
$output = '';
fix_timezone();
$post = next_toastmaster_meeting();
if(empty($post))
	return 'No future meeting events registered';
$output .= sprintf('<p>Next meeting: %s</p>',strftime($rsvp_options['long_date'].' '.$rsvp_options['time_format'],strtotime($post->datetime)));
foreach($cron as $ts => $item)
{
if(isset($item['wp4toast_reminders_cron']))
	$output .= sprintf("<p>Scheduled reminder %s</p>",strftime($rsvp_options['long_date'].' '.$rsvp_options['time_format'],(int) $ts));
}
	return $output;
}



add_action('wp4toast_reminders_dst_fix','wp4toast_reminders_dst_fix',10,1);
function wp4toast_reminders_dst_fix ($args = array()) {
			$previous = get_option('wp4toast_reminder');
			if(!empty($previous))
				{
				$p = explode(' ',$previous);
				if($p[1] == 'hours')
					$hours = $p[0];
				else
					$hours = $p[0] * 24;
				wp_clear_scheduled_hook( 'wp4toast_reminders_cron', array( $hours ) );
					$p = explode(' ',$previous);
					if($p[1] == 'hours')
						$hours = $p[0];
					else
						$hours = $p[0] * 24;
					
					$fudge = $hours + 1;
					$future = get_future_events(" (post_content LIKE '%role=%' OR post_content LIKE '%wp:wp%') ",1);
					if(sizeof($future))
						{
						$next = $future[0];
						fix_timezone();
						wp_schedule_event( strtotime($next->datetime .' -'.$hours.' hours'), 'weekly', 'wp4toast_reminders_cron', array( $hours ) );
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
					$p = explode(' ',$previous);
					if($p[1] == 'hours')
						$hours = $p[0];
					else
						$hours = $p[0] * 24;
					
					$fudge = $hours + 1;
					if(!empty($next))
						{
						fix_timezone();
						wp_schedule_event( strtotime($next->datetime .' -'.$hours.' hours'), 'weekly', 'wp4toast_reminders_cron', array( $hours ) );
						}
				}	
}

function wpt_default_agenda_css($slug = '') {
$segment["stoplight"] = '.stoplight_block {
display: inline-block; margin-bottom: 3px;
}
';

if(!empty($slug))
{
	if(!empty($segment[$slug]))
		return $segment[$slug];
	return;
}

return '
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
body, p, div, td, th, li {
font-size: 12px;
line-height: 1.3;
font-family:"Times New Roman", Times, serif;
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
h3 {font-size: 18px; font-weight: bold; margin-bottom: 5px; font-style: italic;}
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
.role {
font-weight: bold;
}
.role_agenda_note {
font-style: italic;
}
.role-agenda-item ul {
  list-style-type: none;
  padding-left: 0;
  margin-left: 0;
}
.officers_label {font-weight: bold;}
.officer_entity {margin-top: 10px;}
p.agenda_note, div.role-agenda-item, div.role-agenda-note {margin-top: 0; margin-bottom: 0; padding: 3px;}
p.agenda_note {padding-left: 0;}
span.timeblock {display: inline-block; width: 6em; margin: 0px; padding:3px;font-weight: bold;}
#agenda>div.indent {padding-left: 20px;}
p.signup_note, .hideonagenda {display: none;}

/* selected Gutenberg block css */

.wp-block-columns {
	display: flex;
	margin-bottom: 28px;
	flex-wrap: nowrap; }
/*	@media (min-width: 782px) {
	  .wp-block-columns {
		flex-wrap: nowrap; } }

div.wp-block-column:first-of-type {
	flex-basis: 200px;
}
*/
  .wp-block-column {
	flex-grow: 1;
	min-width: 0;
	word-break: break-word;
	overflow-wrap: break-word; }
	@media (max-width: 599px) {
	  .wp-block-column {
		flex-basis: 100% !important; } }
	@media (min-width: 600px) {
	  .wp-block-column {
		flex-basis: calc(50% - 16px);
		flex-grow: 0; }
		.wp-block-column:nth-child(even) {
		  margin-left: 32px; } }
	@media (min-width: 782px) {
	  .wp-block-column:not(:first-child) {
		margin-left: 32px; } }
  
  /**
   * All Columns Alignment
   */
  .wp-block-columns.are-vertically-aligned-top {
	align-items: flex-start; }
  
  .wp-block-columns.are-vertically-aligned-center {
	align-items: center; }
  
  .wp-block-columns.are-vertically-aligned-bottom {
	align-items: flex-end; }
  
  /**
   * Individual Column Alignment
   */
  .wp-block-column.is-vertically-aligned-top {
	align-self: flex-start; }
  
  .wp-block-column.is-vertically-aligned-center {
	-ms-grid-row-align: center;
		align-self: center; }
  
  .wp-block-column.is-vertically-aligned-bottom {
	align-self: flex-end; }
  
  .wp-block-gallery,
  .blocks-gallery-grid {
	display: flex;
	flex-wrap: wrap;
	list-style-type: none;
	padding: 0;
	margin: 0; }
	.wp-block-gallery .blocks-gallery-image,
	.wp-block-gallery .blocks-gallery-item,
	.blocks-gallery-grid .blocks-gallery-image,
	.blocks-gallery-grid .blocks-gallery-item {
	  margin: 0 16px 16px 0;
	  display: flex;
	  flex-grow: 1;
	  flex-direction: column;
	  justify-content: center;
	  position: relative; }
	  .wp-block-gallery .blocks-gallery-image figure,
	  .wp-block-gallery .blocks-gallery-item figure,
	  .blocks-gallery-grid .blocks-gallery-image figure,
	  .blocks-gallery-grid .blocks-gallery-item figure {
		margin: 0;
		height: 100%; }
		@supports ((position: -webkit-sticky) or (position: sticky)) {
		  .wp-block-gallery .blocks-gallery-image figure,
		  .wp-block-gallery .blocks-gallery-item figure,
		  .blocks-gallery-grid .blocks-gallery-image figure,
		  .blocks-gallery-grid .blocks-gallery-item figure {
			display: flex;
			align-items: flex-end;
			justify-content: flex-start; } }
	  .wp-block-gallery .blocks-gallery-image img,
	  .wp-block-gallery .blocks-gallery-item img,
	  .blocks-gallery-grid .blocks-gallery-image img,
	  .blocks-gallery-grid .blocks-gallery-item img {
		display: block;
		max-width: 100%;
		height: auto; }
	  .wp-block-gallery .blocks-gallery-image img,
	  .wp-block-gallery .blocks-gallery-item img,
	  .blocks-gallery-grid .blocks-gallery-image img,
	  .blocks-gallery-grid .blocks-gallery-item img {
		width: 100%; }
		@supports ((position: -webkit-sticky) or (position: sticky)) {
		  .wp-block-gallery .blocks-gallery-image img,
		  .wp-block-gallery .blocks-gallery-item img,
		  .blocks-gallery-grid .blocks-gallery-image img,
		  .blocks-gallery-grid .blocks-gallery-item img {
			width: auto; } }
	  .wp-block-gallery .blocks-gallery-image figcaption,
	  .wp-block-gallery .blocks-gallery-item figcaption,
	  .blocks-gallery-grid .blocks-gallery-image figcaption,
	  .blocks-gallery-grid .blocks-gallery-item figcaption {
		position: absolute;
		bottom: 0;
		width: 100%;
		max-height: 100%;
		overflow: auto;
		padding: 40px 10px 9px;
		color: #fff;
		text-align: center;
		font-size: 13px;
		background: linear-gradient(0deg, rgba(0, 0, 0, 0.7) 0, rgba(0, 0, 0, 0.3) 70%, transparent); }
		.wp-block-gallery .blocks-gallery-image figcaption img,
		.wp-block-gallery .blocks-gallery-item figcaption img,
		.blocks-gallery-grid .blocks-gallery-image figcaption img,
		.blocks-gallery-grid .blocks-gallery-item figcaption img {
		  display: inline; }
	.wp-block-gallery.is-cropped .blocks-gallery-image a,
	.wp-block-gallery.is-cropped .blocks-gallery-image img,
	.wp-block-gallery.is-cropped .blocks-gallery-item a,
	.wp-block-gallery.is-cropped .blocks-gallery-item img,
	.blocks-gallery-grid.is-cropped .blocks-gallery-image a,
	.blocks-gallery-grid.is-cropped .blocks-gallery-image img,
	.blocks-gallery-grid.is-cropped .blocks-gallery-item a,
	.blocks-gallery-grid.is-cropped .blocks-gallery-item img {
	  width: 100%; }
	  @supports ((position: -webkit-sticky) or (position: sticky)) {
		.wp-block-gallery.is-cropped .blocks-gallery-image a,
		.wp-block-gallery.is-cropped .blocks-gallery-image img,
		.wp-block-gallery.is-cropped .blocks-gallery-item a,
		.wp-block-gallery.is-cropped .blocks-gallery-item img,
		.blocks-gallery-grid.is-cropped .blocks-gallery-image a,
		.blocks-gallery-grid.is-cropped .blocks-gallery-image img,
		.blocks-gallery-grid.is-cropped .blocks-gallery-item a,
		.blocks-gallery-grid.is-cropped .blocks-gallery-item img {
		  height: 100%;
		  flex: 1;
		  -o-object-fit: cover;
			 object-fit: cover; } }
	.wp-block-gallery .blocks-gallery-image,
	.wp-block-gallery .blocks-gallery-item,
	.blocks-gallery-grid .blocks-gallery-image,
	.blocks-gallery-grid .blocks-gallery-item {
	  width: calc((100% - 16px) / 2); }
	  .wp-block-gallery .blocks-gallery-image:nth-of-type(even),
	  .wp-block-gallery .blocks-gallery-item:nth-of-type(even),
	  .blocks-gallery-grid .blocks-gallery-image:nth-of-type(even),
	  .blocks-gallery-grid .blocks-gallery-item:nth-of-type(even) {
		margin-right: 0; }
	.wp-block-gallery.columns-1 .blocks-gallery-image,
	.wp-block-gallery.columns-1 .blocks-gallery-item,
	.blocks-gallery-grid.columns-1 .blocks-gallery-image,
	.blocks-gallery-grid.columns-1 .blocks-gallery-item {
	  width: 100%;
	  margin-right: 0; }
	@media (min-width: 600px) {
	  .wp-block-gallery.columns-3 .blocks-gallery-image,
	  .wp-block-gallery.columns-3 .blocks-gallery-item,
	  .blocks-gallery-grid.columns-3 .blocks-gallery-image,
	  .blocks-gallery-grid.columns-3 .blocks-gallery-item {
		width: calc((100% - 16px * 2) / 3);
		margin-right: 16px; }
		@supports (-ms-ime-align: auto) {
		  .wp-block-gallery.columns-3 .blocks-gallery-image,
		  .wp-block-gallery.columns-3 .blocks-gallery-item,
		  .blocks-gallery-grid.columns-3 .blocks-gallery-image,
		  .blocks-gallery-grid.columns-3 .blocks-gallery-item {
			width: calc((100% - 16px * 2) / 3 - 1px); } }
	  .wp-block-gallery.columns-4 .blocks-gallery-image,
	  .wp-block-gallery.columns-4 .blocks-gallery-item,
	  .blocks-gallery-grid.columns-4 .blocks-gallery-image,
	  .blocks-gallery-grid.columns-4 .blocks-gallery-item {
		width: calc((100% - 16px * 3) / 4);
		margin-right: 16px; }
		@supports (-ms-ime-align: auto) {
		  .wp-block-gallery.columns-4 .blocks-gallery-image,
		  .wp-block-gallery.columns-4 .blocks-gallery-item,
		  .blocks-gallery-grid.columns-4 .blocks-gallery-image,
		  .blocks-gallery-grid.columns-4 .blocks-gallery-item {
			width: calc((100% - 16px * 3) / 4 - 1px); } }
	  .wp-block-gallery.columns-5 .blocks-gallery-image,
	  .wp-block-gallery.columns-5 .blocks-gallery-item,
	  .blocks-gallery-grid.columns-5 .blocks-gallery-image,
	  .blocks-gallery-grid.columns-5 .blocks-gallery-item {
		width: calc((100% - 16px * 4) / 5);
		margin-right: 16px; }
		@supports (-ms-ime-align: auto) {
		  .wp-block-gallery.columns-5 .blocks-gallery-image,
		  .wp-block-gallery.columns-5 .blocks-gallery-item,
		  .blocks-gallery-grid.columns-5 .blocks-gallery-image,
		  .blocks-gallery-grid.columns-5 .blocks-gallery-item {
			width: calc((100% - 16px * 4) / 5 - 1px); } }
	  .wp-block-gallery.columns-6 .blocks-gallery-image,
	  .wp-block-gallery.columns-6 .blocks-gallery-item,
	  .blocks-gallery-grid.columns-6 .blocks-gallery-image,
	  .blocks-gallery-grid.columns-6 .blocks-gallery-item {
		width: calc((100% - 16px * 5) / 6);
		margin-right: 16px; }
		@supports (-ms-ime-align: auto) {
		  .wp-block-gallery.columns-6 .blocks-gallery-image,
		  .wp-block-gallery.columns-6 .blocks-gallery-item,
		  .blocks-gallery-grid.columns-6 .blocks-gallery-image,
		  .blocks-gallery-grid.columns-6 .blocks-gallery-item {
			width: calc((100% - 16px * 5) / 6 - 1px); } }
	  .wp-block-gallery.columns-7 .blocks-gallery-image,
	  .wp-block-gallery.columns-7 .blocks-gallery-item,
	  .blocks-gallery-grid.columns-7 .blocks-gallery-image,
	  .blocks-gallery-grid.columns-7 .blocks-gallery-item {
		width: calc((100% - 16px * 6) / 7);
		margin-right: 16px; }
		@supports (-ms-ime-align: auto) {
		  .wp-block-gallery.columns-7 .blocks-gallery-image,
		  .wp-block-gallery.columns-7 .blocks-gallery-item,
		  .blocks-gallery-grid.columns-7 .blocks-gallery-image,
		  .blocks-gallery-grid.columns-7 .blocks-gallery-item {
			width: calc((100% - 16px * 6) / 7 - 1px); } }
	  .wp-block-gallery.columns-8 .blocks-gallery-image,
	  .wp-block-gallery.columns-8 .blocks-gallery-item,
	  .blocks-gallery-grid.columns-8 .blocks-gallery-image,
	  .blocks-gallery-grid.columns-8 .blocks-gallery-item {
		width: calc((100% - 16px * 7) / 8);
		margin-right: 16px; }
		@supports (-ms-ime-align: auto) {
		  .wp-block-gallery.columns-8 .blocks-gallery-image,
		  .wp-block-gallery.columns-8 .blocks-gallery-item,
		  .blocks-gallery-grid.columns-8 .blocks-gallery-image,
		  .blocks-gallery-grid.columns-8 .blocks-gallery-item {
			width: calc((100% - 16px * 7) / 8 - 1px); } }
	  .wp-block-gallery.columns-1 .blocks-gallery-image:nth-of-type(1n),
	  .wp-block-gallery.columns-1 .blocks-gallery-item:nth-of-type(1n),
	  .blocks-gallery-grid.columns-1 .blocks-gallery-image:nth-of-type(1n),
	  .blocks-gallery-grid.columns-1 .blocks-gallery-item:nth-of-type(1n) {
		margin-right: 0; }
	  .wp-block-gallery.columns-2 .blocks-gallery-image:nth-of-type(2n),
	  .wp-block-gallery.columns-2 .blocks-gallery-item:nth-of-type(2n),
	  .blocks-gallery-grid.columns-2 .blocks-gallery-image:nth-of-type(2n),
	  .blocks-gallery-grid.columns-2 .blocks-gallery-item:nth-of-type(2n) {
		margin-right: 0; }
	  .wp-block-gallery.columns-3 .blocks-gallery-image:nth-of-type(3n),
	  .wp-block-gallery.columns-3 .blocks-gallery-item:nth-of-type(3n),
	  .blocks-gallery-grid.columns-3 .blocks-gallery-image:nth-of-type(3n),
	  .blocks-gallery-grid.columns-3 .blocks-gallery-item:nth-of-type(3n) {
		margin-right: 0; }
	  .wp-block-gallery.columns-4 .blocks-gallery-image:nth-of-type(4n),
	  .wp-block-gallery.columns-4 .blocks-gallery-item:nth-of-type(4n),
	  .blocks-gallery-grid.columns-4 .blocks-gallery-image:nth-of-type(4n),
	  .blocks-gallery-grid.columns-4 .blocks-gallery-item:nth-of-type(4n) {
		margin-right: 0; }
	  .wp-block-gallery.columns-5 .blocks-gallery-image:nth-of-type(5n),
	  .wp-block-gallery.columns-5 .blocks-gallery-item:nth-of-type(5n),
	  .blocks-gallery-grid.columns-5 .blocks-gallery-image:nth-of-type(5n),
	  .blocks-gallery-grid.columns-5 .blocks-gallery-item:nth-of-type(5n) {
		margin-right: 0; }
	  .wp-block-gallery.columns-6 .blocks-gallery-image:nth-of-type(6n),
	  .wp-block-gallery.columns-6 .blocks-gallery-item:nth-of-type(6n),
	  .blocks-gallery-grid.columns-6 .blocks-gallery-image:nth-of-type(6n),
	  .blocks-gallery-grid.columns-6 .blocks-gallery-item:nth-of-type(6n) {
		margin-right: 0; }
	  .wp-block-gallery.columns-7 .blocks-gallery-image:nth-of-type(7n),
	  .wp-block-gallery.columns-7 .blocks-gallery-item:nth-of-type(7n),
	  .blocks-gallery-grid.columns-7 .blocks-gallery-image:nth-of-type(7n),
	  .blocks-gallery-grid.columns-7 .blocks-gallery-item:nth-of-type(7n) {
		margin-right: 0; }
	  .wp-block-gallery.columns-8 .blocks-gallery-image:nth-of-type(8n),
	  .wp-block-gallery.columns-8 .blocks-gallery-item:nth-of-type(8n),
	  .blocks-gallery-grid.columns-8 .blocks-gallery-image:nth-of-type(8n),
	  .blocks-gallery-grid.columns-8 .blocks-gallery-item:nth-of-type(8n) {
		margin-right: 0; } }
	.wp-block-gallery .blocks-gallery-image:last-child,
	.wp-block-gallery .blocks-gallery-item:last-child,
	.blocks-gallery-grid .blocks-gallery-image:last-child,
	.blocks-gallery-grid .blocks-gallery-item:last-child {
	  margin-right: 0; }
	.wp-block-gallery.alignleft, .wp-block-gallery.alignright,
	.blocks-gallery-grid.alignleft,
	.blocks-gallery-grid.alignright {
	  max-width: 305px;
	  width: 100%; }
	.wp-block-gallery.aligncenter .blocks-gallery-item figure,
	.blocks-gallery-grid.aligncenter .blocks-gallery-item figure {
	  justify-content: center; }
  
  .wp-block-image {
	max-width: 100%;
	margin-bottom: 1em; }
	.wp-block-image img {
	  max-width: 100%; }
	.wp-block-image.aligncenter {
	  text-align: center; }
	.wp-block-image.alignfull img,
	.wp-block-image.alignwide img {
	  width: 100%; }
	.wp-block-image .alignleft,
	.wp-block-image .alignright,
	.wp-block-image .aligncenter, .wp-block-image.is-resized {
	  display: table;
	  margin-left: 0;
	  margin-right: 0; }
	  .wp-block-image .alignleft > figcaption,
	  .wp-block-image .alignright > figcaption,
	  .wp-block-image .aligncenter > figcaption, .wp-block-image.is-resized > figcaption {
		display: table-caption;
		caption-side: bottom; }
	.wp-block-image .alignleft {
	  /*rtl:ignore*/
	  float: left;
	  /*rtl:ignore*/
	  margin-right: 1em; }
	.wp-block-image .alignright {
	  /*rtl:ignore*/
	  float: right;
	  /*rtl:ignore*/
	  margin-left: 1em; }
	.wp-block-image .aligncenter {
	  margin-left: auto;
	  margin-right: auto; }
	.wp-block-image figcaption {
	  margin-top: 0.5em;
	  margin-bottom: 1em; }
  
  .wp-block-media-text {
	display: -ms-grid;
	display: grid;
	-ms-grid-rows: auto;
	grid-template-rows: auto;
	-ms-grid-columns: 50% 1fr;
	grid-template-columns: 50% 1fr; }
	.wp-block-media-text .has-media-on-the-right {
	  -ms-grid-columns: 1fr 50%;
	  grid-template-columns: 1fr 50%; }
  
  .wp-block-media-text.is-vertically-aligned-top .wp-block-media-text__content,
  .wp-block-media-text.is-vertically-aligned-top .wp-block-media-text__media {
	-ms-grid-row-align: start;
		align-self: start; }
  
  .wp-block-media-text .wp-block-media-text__content,
  .wp-block-media-text .wp-block-media-text__media,
  .wp-block-media-text.is-vertically-aligned-center .wp-block-media-text__content,
  .wp-block-media-text.is-vertically-aligned-center .wp-block-media-text__media {
	-ms-grid-row-align: center;
		align-self: center; }
  
  .wp-block-media-text.is-vertically-aligned-bottom .wp-block-media-text__content,
  .wp-block-media-text.is-vertically-aligned-bottom .wp-block-media-text__media {
	-ms-grid-row-align: end;
		align-self: end; }
  
  .wp-block-media-text .wp-block-media-text__media {
	-ms-grid-column: 1;
	grid-column: 1;
	-ms-grid-row: 1;
	grid-row: 1;
	margin: 0; }
  
  .wp-block-media-text .wp-block-media-text__content {
	-ms-grid-column: 2;
	grid-column: 2;
	-ms-grid-row: 1;
	grid-row: 1;
	word-break: break-word;
	padding: 0 8% 0 8%; }
  
  .wp-block-media-text.has-media-on-the-right .wp-block-media-text__media {
	-ms-grid-column: 2;
	grid-column: 2;
	-ms-grid-row: 1;
	grid-row: 1; }
  
  .wp-block-media-text.has-media-on-the-right .wp-block-media-text__content {
	-ms-grid-column: 1;
	grid-column: 1;
	-ms-grid-row: 1;
	grid-row: 1; }
  
  .wp-block-media-text > figure > img,
  .wp-block-media-text > figure > video {
	max-width: unset;
	width: 100%;
	vertical-align: middle; }
  
  .wp-block-media-text.is-image-fill figure {
	height: 100%;
	min-height: 250px;
	background-size: cover; }
  
  .wp-block-media-text.is-image-fill figure > img {
	position: absolute;
	width: 1px;
	height: 1px;
	padding: 0;
	margin: -1px;
	overflow: hidden;
	clip: rect(0, 0, 0, 0);
	border: 0; }
  
  .is-small-text {
	font-size: 14px; }
  
  .is-regular-text {
	font-size: 16px; }
  
  .is-large-text {
	font-size: 36px; }
  
  .is-larger-text {
	font-size: 48px; }
  
  .has-drop-cap:not(:focus)::first-letter {
	float: left;
	font-size: 8.4em;
	line-height: 0.68;
	font-weight: 100;
	margin: 0.05em 0.1em 0 0;
	text-transform: uppercase;
	font-style: normal; }
  
  .has-drop-cap:not(:focus)::after {
	content: "";
	display: table;
	clear: both;
	padding-top: 14px; }
  
  p.has-background {
	padding: 20px 30px; }
  
  p.has-text-color a {
	color: inherit; }
  
  .wp-block-pullquote {
	padding: 3em 0;
	margin-left: 0;
	margin-right: 0;
	text-align: center; }
	.wp-block-pullquote.alignleft, .wp-block-pullquote.alignright {
	  max-width: 305px; }
	  .wp-block-pullquote.alignleft p, .wp-block-pullquote.alignright p {
		font-size: 20px; }
	.wp-block-pullquote p {
	  font-size: 28px;
	  line-height: 1.6; }
	.wp-block-pullquote cite,
	.wp-block-pullquote footer {
	  position: relative; }
	.wp-block-pullquote .has-text-color a {
	  color: inherit; }
  
  .wp-block-pullquote:not(.is-style-solid-color) {
	background: none; }
  
  .wp-block-pullquote.is-style-solid-color {
	border: none; }
	.wp-block-pullquote.is-style-solid-color blockquote {
	  margin-left: auto;
	  margin-right: auto;
	  text-align: left;
	  max-width: 60%; }
	  .wp-block-pullquote.is-style-solid-color blockquote p {
		margin-top: 0;
		margin-bottom: 0;
		font-size: 32px; }
	  .wp-block-pullquote.is-style-solid-color blockquote cite {
		text-transform: none;
		font-style: normal; }
  
  .wp-block-pullquote cite {
	color: inherit; }
  
  .wp-block-quote.is-style-large, .wp-block-quote.is-large {
	margin: 0 0 16px;
	padding: 0 1em; }
	.wp-block-quote.is-style-large p, .wp-block-quote.is-large p {
	  font-size: 24px;
	  font-style: italic;
	  line-height: 1.6; }
	.wp-block-quote.is-style-large cite,
	.wp-block-quote.is-style-large footer, .wp-block-quote.is-large cite,
	.wp-block-quote.is-large footer {
	  font-size: 18px;
	  text-align: right; }
  
  .wp-block-separator.is-style-wide {
	border-bottom-width: 1px; }
  
  .wp-block-separator.is-style-dots {
	background: none !important;
	border: none;
	text-align: center;
	max-width: none;
	line-height: 1;
	height: auto; }
	.wp-block-separator.is-style-dots::before {
	  content: "\00b7 \00b7 \00b7";
	  color: currentColor;
	  font-size: 20px;
	  letter-spacing: 2em;
	  padding-left: 2em;
	  font-family: serif; }
  
  .wp-block-spacer {
	clear: both; }
  
  p.wp-block-subhead {
	font-size: 1.1em;
	font-style: italic;
	opacity: 0.75; }
  
  .wp-block-table {
	overflow-x: auto; }
	.wp-block-table table {
	  width: 100%; }
	.wp-block-table .has-fixed-layout {
	  table-layout: fixed;
	  width: 100%; }
	  .wp-block-table .has-fixed-layout td,
	  .wp-block-table .has-fixed-layout th {
		word-break: break-word; }
	.wp-block-table.alignleft, .wp-block-table.aligncenter, .wp-block-table.alignright {
	  display: table;
	  width: auto; }
	  .wp-block-table.alignleft td,
	  .wp-block-table.alignleft th, .wp-block-table.aligncenter td,
	  .wp-block-table.aligncenter th, .wp-block-table.alignright td,
	  .wp-block-table.alignright th {
		word-break: break-word; }
	.wp-block-table .has-subtle-light-gray-background-color {
	  background-color: #f3f4f5; }
	.wp-block-table .has-subtle-pale-green-background-color {
	  background-color: #e9fbe5; }
	.wp-block-table .has-subtle-pale-blue-background-color {
	  background-color: #e7f5fe; }
	.wp-block-table .has-subtle-pale-pink-background-color {
	  background-color: #fcf0ef; }
	.wp-block-table.is-style-stripes {
	  border-spacing: 0;
	  border-collapse: inherit;
	  background-color: transparent;
	  border-bottom: 1px solid #f3f4f5; }
	  .wp-block-table.is-style-stripes tbody tr:nth-child(odd) {
		background-color: #f3f4f5; }
	  .wp-block-table.is-style-stripes.has-subtle-light-gray-background-color tbody tr:nth-child(odd) {
		background-color: #f3f4f5; }
	  .wp-block-table.is-style-stripes.has-subtle-pale-green-background-color tbody tr:nth-child(odd) {
		background-color: #e9fbe5; }
	  .wp-block-table.is-style-stripes.has-subtle-pale-blue-background-color tbody tr:nth-child(odd) {
		background-color: #e7f5fe; }
	  .wp-block-table.is-style-stripes.has-subtle-pale-pink-background-color tbody tr:nth-child(odd) {
		background-color: #fcf0ef; }
	  .wp-block-table.is-style-stripes th,
	  .wp-block-table.is-style-stripes td {
		border-color: transparent; }
  
  .wp-block-text-columns {
	display: flex; }
	.wp-block-text-columns.aligncenter {
	  display: flex; }
	.wp-block-text-columns .wp-block-column {
	  margin: 0 16px;
	  padding: 0; }
	  .wp-block-text-columns .wp-block-column:first-child {
		margin-left: 0; }
	  .wp-block-text-columns .wp-block-column:last-child {
		margin-right: 0; }
	.wp-block-text-columns.columns-2 .wp-block-column {
	  width: calc(100% / 2); }
	.wp-block-text-columns.columns-3 .wp-block-column {
	  width: calc(100% / 3); }
	.wp-block-text-columns.columns-4 .wp-block-column {
	  width: calc(100% / 4); }
  
  pre.wp-block-verse {
	white-space: nowrap;
	overflow: auto; }
  
  :root .has-pale-pink-background-color {
	background-color: #f78da7; }
  
  :root .has-vivid-red-background-color {
	background-color: #cf2e2e; }
  
  :root .has-luminous-vivid-orange-background-color {
	background-color: #ff6900; }
  
  :root .has-luminous-vivid-amber-background-color {
	background-color: #fcb900; }
  
  :root .has-light-green-cyan-background-color {
	background-color: #7bdcb5; }
  
  :root .has-vivid-green-cyan-background-color {
	background-color: #00d084; }
  
  :root .has-pale-cyan-blue-background-color {
	background-color: #8ed1fc; }
  
  :root .has-vivid-cyan-blue-background-color {
	background-color: #0693e3; }
  
  :root .has-vivid-purple-background-color {
	background-color: #9b51e0; }
  
  :root .has-very-light-gray-background-color {
	background-color: #eee; }
  
  :root .has-cyan-bluish-gray-background-color {
	background-color: #abb8c3; }
  
  :root .has-very-dark-gray-background-color {
	background-color: #313131; }
  
  :root .has-pale-pink-color {
	color: #f78da7; }
  
  :root .has-vivid-red-color {
	color: #cf2e2e; }
  
  :root .has-luminous-vivid-orange-color {
	color: #ff6900; }
  
  :root .has-luminous-vivid-amber-color {
	color: #fcb900; }
  
  :root .has-light-green-cyan-color {
	color: #7bdcb5; }
  
  :root .has-vivid-green-cyan-color {
	color: #00d084; }
  
  :root .has-pale-cyan-blue-color {
	color: #8ed1fc; }
  
  :root .has-vivid-cyan-blue-color {
	color: #0693e3; }
  
  :root .has-vivid-purple-color {
	color: #9b51e0; }
  
  :root .has-very-light-gray-color {
	color: #eee; }
  
  :root .has-cyan-bluish-gray-color {
	color: #abb8c3; }
  
  :root .has-very-dark-gray-color {
	color: #313131; }
  
  .has-small-font-size {
	font-size: 13px; }
  
  .has-regular-font-size,
  .has-normal-font-size {
	font-size: 16px; }
  
  .has-medium-font-size {
	font-size: 20px; }
  
  .has-large-font-size {
	font-size: 36px; }
  
  .has-larger-font-size,
  .has-huge-font-size {
	font-size: 42px; }
  
  .has-text-align-center {
	text-align: center; }
  
  .has-text-align-left {
	/*rtl:ignore*/
	text-align: left; }
  
  .has-text-align-right {
	/*rtl:ignore*/
	text-align: right; }

'.$segment["stoplight"];
}

function display_time_stoplight ($content) {
preg_match_all('/\d{1,3}/',$content,$matches);
	//return var_export($matches[0],true);
	$output = '';
	if(!empty($matches))
	{
	if(sizeof($matches[0]) == 2)
	{
		//simple case
		$green = array_shift($matches[0]);
		$red = array_shift($matches[0]);
		return get_stoplight($green,$red);
	}
		while(($green = array_shift($matches[0])) && ($red = array_shift($matches[0])))
		{
			$output .= '<br />'.get_stoplight($green,$red);
		}
	}
	return $content . $output;
}

function get_stoplight ($green,$red, $yellow=NULL) {
	if(empty($yellow))
	{
		$diff = $red - $green;
		$plus_minutes = ($diff - $diff % 2) / 2;
		$yellow = $green + $plus_minutes;
		if($diff % 2)
		{
			if(($green > 5) && ($diff > 2)) // go to next minute
				$yellow++;
			else
				$yellow = $yellow .= ':30';
		}
	}
	return sprintf('<span class="stoplight_block"><img src="'.plugins_url('rsvpmaker-for-toastmasters/stoplight-green.png').'" style="padding:0; border: thin solid #000; height: 0.8em; width: 0.8em; " />&nbsp;Green: '.$green.' '.'<img src="'.plugins_url('rsvpmaker-for-toastmasters/stoplight-yellow.png').'" style="padding:0; border: thin solid #000; height: 0.8em; width: 0.8em; " />&nbsp;Yellow: '.$yellow.' '.'<img src="'.plugins_url('rsvpmaker-for-toastmasters/stoplight-red.png').'" style="padding:0; border: thin solid #000;  height: 0.8em; width: 0.8em; " />&nbsp;Red: '.$red.'</span>');
}

function stoplight_shortcode($atts) {
	if(!isset($atts['red']) || !isset($atts["green"]))
		return;
	$red = $atts['red'];
	$green = $atts["green"];
	$yellow = (isset($atts["yellow"])) ? $atts["yellow"] : NULL;
	return get_stoplight($green,$red,$yellow);
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
			if(function_exists('do_blocks'))
			$layout["post_content"] = '<!-- wp:image {"sizeSlug":"large"} -->
			<figure class="wp-block-image size-large"><img src="https://toastmost.org/tmbranding/agenda-rays.png" alt="Toastmasters branded agenda" /></figure>
			<!-- /wp:image -->

			<!-- wp:heading -->
			<h2>'.get_bloginfo('name').' - [tmlayout_meeting_date] </h2>
			<!-- /wp:heading -->
			
			<!-- wp:wp4toastmasters/agenda-wrapper -->
			<div class="wp-block-wp4toastmasters-agenda-wrapper"><table id="agenda-main" width="700"><tbody><tr><td id="agenda-sidebar" width="175"><!-- wp:wp4toastmasters/agendasidebar /--></td><td id="agenda-main" width="*">[tmlayout_main]</td></tr></tbody></table></div>
			<!-- /wp:wp4toastmasters/agenda-wrapper -->';
			else
			$layout["post_content"] = '<img src="https://toastmost.org/tmbranding/agenda-rays.png" alt="Toastmasters branded agenda" /></div>
<h2 id="title">'.get_bloginfo('name').' - [tmlayout_meeting_date]</h2>
<table id="main" width="700"><tr><td id="sidebar" width="175">[tmlayout_sidebar]</td><td id="agenda" width="*">[tmlayout_main]</td></tr></table>';
			$layout["post_author"] = $current_user->ID;
			$layout["post_status"] = 'publish';
			$layout_id = wp_insert_post( $layout );
			add_post_meta($layout_id,'_rsvpmaker_special','Agenda Layout');
			update_option('rsvptoast_agenda_layout',$layout_id);
			}
			elseif(function_exists('do_blocks')	) {
				$layout_id = get_option('rsvptoast_agenda_layout');
				$layout = get_post($layout_id);
				if(isset($_GET['resetlayout']) || (strpos($layout->post_content,'<table') && !strpos($layout->post_content,'wp:wp4toastmasters/agendasidebar')) )
					{
						$postdata['ID'] = $layout->ID;
						$postdata["post_content"] = '<!-- wp:image {"sizeSlug":"large"} -->
						<figure class="wp-block-image size-large"><img src="https://toastmost.org/tmbranding/agenda-rays.png" alt="Toastmasters branded agenda" /></figure>
						<!-- /wp:image -->
			
						<!-- wp:heading -->
						<h2>'.get_bloginfo('name').' - [tmlayout_meeting_date] </h2>
						<!-- /wp:heading -->
						
						<!-- wp:wp4toastmasters/agenda-wrapper -->
						<div class="wp-block-wp4toastmasters-agenda-wrapper"><table id="agenda-main" width="700"><tbody><tr><td id="agenda-sidebar" width="175"><!-- wp:wp4toastmasters/agendasidebar /--></td><td id="agenda-main" width="*">[tmlayout_main]</td></tr></tbody></table></div>
						<!-- /wp:wp4toastmasters/agenda-wrapper -->';
			$result = wp_update_post($postdata);
					}
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

function add_to_mailman($user_id, $list = 'm')
	{
		if(empty($user_id))
			return;
		$wp4toastmasters_mailman = get_option('wp4toastmasters_mailman');
		if(!isset($wp4toastmasters_mailman[$list."path"]) || empty($wp4toastmasters_mailman[$list."path"]) || !isset($wp4toastmasters_mailman[$list."pass"]) || empty($wp4toastmasters_mailman[$list."pass"]) )
			return;
		if(is_numeric($user_id))
		{
		$user = get_userdata($user_id);
		$email = $user->user_email;
		}
		elseif(is_email($user_id))
		{
		$email = $user_id;
		}
		else
			{
			echo 'not numeric or email?'.$user_id;
			return;
			}
		if(empty($email))
			return;
		$url = trailingslashit($wp4toastmasters_mailman[$list."path"])."members?findmember=".$email."&setmemberopts_btn&adminpw=".$wp4toastmasters_mailman[$list."pass"];
		$result = file_get_contents($url);
		if(!strpos($result, 'CHECKBOX') )
			{
			$url = trailingslashit($wp4toastmasters_mailman[$list."path"])."add?subscribe_or_invite=0&send_welcome_msg_to_this_batch=0&notification_to_list_owner=0&subscribees_upload=".$email."&adminpw=".urlencode($wp4toastmasters_mailman[$list."pass"]);
		$result = file_get_contents($url);
		if(!strpos($result, 'Successfully') )
		{
			echo "<div>".__('Error attempting to subscribe','rsvpmaker-for-toastmasters')." $email</div>";
		}
		else
			echo "<div>".__('Added ','rsvpmaker-for-toastmasters')." $email</div>";
			}
}

function list_mailman($list = 'm')
	{
		$lists = array('m' => 'members','o' => 'officers', 'g' => 'guests');
		printf('<h3>Mailing List: %s</h3>',$lists[$list]);
		$wp4toastmasters_mailman = get_option('wp4toastmasters_mailman');
		if(!isset($wp4toastmasters_mailman[$list."path"]) || empty($wp4toastmasters_mailman[$list."path"]) || !isset($wp4toastmasters_mailman[$list."pass"]) || empty($wp4toastmasters_mailman[$list."pass"]) )
			return;
		$url = trailingslashit($wp4toastmasters_mailman[$list."path"])."members?adminpw=".$wp4toastmasters_mailman[$list."pass"];
		$result = file_get_contents($url);
		preg_match_all('/letter=([a-z])/',$result,$matches);
		if(!empty($matches[1][1]))
		{
			//array_shift($matches);
			foreach($matches[1] as $m)
				{
				if($m == 'a')
					continue;
				$url = trailingslashit($wp4toastmasters_mailman[$list."path"])."members?adminpw=".$wp4toastmasters_mailman[$list."pass"].'&letter='.$m;
				$result .= file_get_contents($url);
				}
		}
preg_match_all('/[a-z\d._%+-]+@[a-z\d.-]+\.[a-z]{2,4}\b/i',$result, $matches);
foreach($matches[0] as $email)
	{
	if(strpos($email,'-owner@'))
		continue;
	$status = (get_user_by( 'email', $email )) ? '' : __('Not in user/member list','rsvpmaker-for-toastmasters');
	printf('<div>%s (<a href="%s">%s</a>) %s</div>',$email,admin_url('users.php?page=mailman&unsubscribe=').$email.'&list='.$list,__('Unsubscribe - '.$lists[$list],'rsvpmaker-for-toastmasters'), $status);
	}
}

function list_mailman_pending($list = 'm')
	{
		$lists = array('m' => 'members','o' => 'officers', 'g' => 'guests');
		$wp4toastmasters_mailman = get_option('wp4toastmasters_mailman');
		if(!isset($wp4toastmasters_mailman[$list."path"]) || empty($wp4toastmasters_mailman[$list."path"]) || !isset($wp4toastmasters_mailman[$list."pass"]) || empty($wp4toastmasters_mailman[$list."pass"]) )
			return;
		$path = str_replace('/admin/','/admindb/',$wp4toastmasters_mailman[$list."path"]);
		$url = $path."?adminpw=".$wp4toastmasters_mailman[$list."pass"];
		
		if(isset($_POST["always_approve"]))
			{
			$adminurl = $url;
			foreach($_POST["always_approve"] as $email) {
				$emailcoded = str_replace('@','%40',$email);
				foreach($_POST['msgid'][$email] as $msgid)
					$adminurl .= '&'.$emailcoded.'='.$msgid;
				$adminurl .= '&senderaction-'.$emailcoded.'=1&senderfilter-'.$emailcoded.'=6&senderfilterp-'.$emailcoded.'=1';
				$results = file_get_contents($adminurl);
				echo '<p>Attempting to whitelist email '.$email.'<p>';
				}
			}
		if(isset($_POST["approve"]))
			{
			$adminurl = $url;
			foreach($_POST["approve"] as $email) {
				$emailcoded = str_replace('@','%40',$email);
				foreach($_POST['msgid'][$email] as $msgid)
					$adminurl .= '&'.$emailcoded.'='.$msgid;
				$adminurl .= '&senderaction-'.$emailcoded.'=1';
				$results = file_get_contents($adminurl);
				echo '<p>Attempting to approve current messages for '.$email.'<p>';
				}
			}
		if(isset($_POST["deny"]))
			{
			$adminurl = $url;
			foreach($_POST["deny"] as $email) {
				$emailcoded = str_replace('@','%40',$email);
				foreach($_POST['msgid'][$email] as $msgid)
					$adminurl .= '&'.$emailcoded.'='.$msgid;
				$adminurl .= '&senderaction-'.$emailcoded.'=3&senderfilter-'.$emailcoded.'=3&senderfilterp-'.$emailcoded.'=1';
				$results = file_get_contents($adminurl);
				echo '<p>Attempting to blacklist email '.$email.'<p>';
				}
			}		
		
		$result = file_get_contents($url);

		$parts = explode('From:',$result);
		if(sizeof($parts) > 1)
		{
		echo '<h2>Pending Messages</h2>';
		printf('<form action="%s" method="post">',admin_url('users.php?page=mailman&list='.$list));
		foreach($parts as $text)
		{
		preg_match('/<\/strong>([^<]+)<\/center>/',$text,$email_matches);
		$pattern = '/msgid=([0-9]+)">/';//[([0-9]+)].+<\/strong><\/td>.+<td>(.+)<\/td>/s';
		preg_match_all($pattern,$text,$msg_matches);
		$pattern = '/Subject:<\/strong><\/td>[^<]+<td>([^<]+)<\/td>/s';
		preg_match_all($pattern,$text,$subject_matches);		
		if(!empty($email_matches[1]))
			{
			$email = $email_matches[1];
		printf('<div><input type="checkbox" name="always_approve[]" value="%s" />Always Approve: %s</div>',$email,$email);
		printf('<div><input type="checkbox" name="approve[]" value="%s" />Approve Once: %s</div>',$email,$email);
		printf('<div><input type="checkbox" name="deny[]" value="%s" />Blacklist: %s</div>',$email,$email);
			}
		if(!empty($msg_matches[1]))
		{
		foreach($msg_matches[1] as $index => $msg_id)
			{
				$subject = $subject_matches[1][$index];
				$pending .= sprintf('<div><a target="_blank" href="%s?msgid=%d" />%s</a></div>',$path,$msg_id,$subject);
			printf('<input type="hidden" name="msgid[%s][]" value="%s" />',$email,$msg_id);
			}		
		}

		}
	
		if(!empty($pending))
			echo "<div>Messages from $email</div>".$pending;
		echo '<button>Submit</button></form>';		
		}
}

function mailman () {
$hook = tm_admin_page_top(__('Mailman Mailing Lists','rsvpmaker-for-toastmasters'));
$mm = get_option('wp4toastmasters_mailman');
$list = isset($_REQUEST["list"]) ? $_REQUEST["list"] : '';
$lists = array('m' => 'members','o' => 'officers', 'g' => 'guests');
$options = '';
foreach($lists as $l => $label)
	{
	$s = ($l == $list) ? ' selected="selected" ' : '';
	if(!empty($mm[$l.'pass']))
		{
		$options .= sprintf('<option value="%s" %s>%s</option>',$l,$s,$label);
		if(empty($list))
			$list = $l;
		}
	}

printf('<form action="%s" method="get"><input type="hidden" name="page" value="mailman" />Select List: <select name="list">%s</select><button>Go</button></form>',admin_url('users.php'),$options);		

if(isset($_REQUEST["unsubscribe"]))
	unsubscribe_mailman_by_email($_REQUEST["unsubscribe"],$_REQUEST["list"]);
if(isset($_POST["add_email"]) && isset($_POST["list"]))
{
preg_match_all('/[a-z\d._%+-]+@[a-z\d.-]+\.[a-z]{2,4}\b/i',$_POST["add_email"], $matches);
if(!empty($matches[0]))
foreach($matches[0] as $email)
	{
		add_to_mailman($email,$_POST["list"]);
	}
}

if(!empty($mm[$list."pass"]))
	{
	list_mailman($list);
	
	list_mailman_pending($list);
	
	$suggestions = array();
	if(isset($_REQUEST["rsvp"]))
		{
		global $wpdb;
		$sql = 'SELECT * from '.$wpdb->prefix.'rsvpmaker ORDER BY id DESC';
		$results = $wpdb->get_results($sql);
		foreach($results as $row)
			{
			if(empty($row->email) || get_user_by( 'email', $row->email ) || isset($suggestions[$row->email]))
				continue;
			$suggestions[$row->email] = sprintf("%s (%s %s %s)",$row->email,$row->first,$row->last,$row->timestamp);
			}
		}
	printf('<h3>%s</h3><p>%s</p><form action="%s" method="post"><input type="hidden" name="list" value="%s" /><textarea name="add_email"  rows="5" cols="80">%s</textarea><br /><button>Add</button></form>',__('Add Email','rsvpmaker-for-toastmasters'),__('Add one or more email addresses separated by commas or line breaks','rsvpmaker-for-toastmasters'),admin_url('users.php?page=mailman'),$list,implode("\n",$suggestions));
	if($list == 'g')
		{
		printf('<p>You can pull in guest list suggestions from the <a href="%s">RSVP List</a>',admin_url('users.php?page=mailman&rsvp=1&list=g'));
		printf('<p>Or check off email address to include on the <a href="%s">Guests/Former Members page</a>',admin_url('users.php?page=extended_list'));	
		}
	}

?>
<h1>Direct Login</h1>
<p>For some administrative functions, you will need to log into the Mailman mailing list directly. Mailman is a Linux mailing list utility, which allows limited access from WordPress.</p>
<?php
if(!empty($mm["mpass"]))
echo '<p><a href="'.trailingslashit($mm["mpath"]).'members" target="_blank">'.__("Members Email List",'rsvpmaker-for-toastmasters').'</a> password: '.$mm["mpass"].' <a href="mailto:'.$mm["members"].'">'.$mm["members"].'</a><br /></p>';

if(!empty($mm["opass"]))
echo'<p><a href="'.trailingslashit($mm["opath"]).'members" target="_blank">'.__("Officers Email List",'rsvpmaker-for-toastmasters').'</a> password: '.$mm["opass"].' <a href="mailto:'.$mm["officers"].'">'.$mm["officers"].'</a></p>';

if(!empty($mm["gpass"]))
echo '<p><a href="'.trailingslashit($mm["gpath"]).'members" target="_blank">'.__("Guests Email List",'rsvpmaker-for-toastmasters').'</a> password: '.$mm["gpass"].' <a href="mailto:'.$mm["guest"].'">'.$mm["guest"].'</a></p>';

tm_admin_page_bottom($hook);
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

function unsubscribe_mailman_by_email($email, $list = 'm')
	{
		$wp4toastmasters_mailman = get_option('wp4toastmasters_mailman');
		if(!empty($wp4toastmasters_mailman[$list."path"]) && !empty($wp4toastmasters_mailman[$list."pass"]) )
		{
		$url = trailingslashit($wp4toastmasters_mailman[$list."path"])."members/remove?send_unsub_ack_to_this_batch=0&send_unsub_notifications_to_list_owner=0&unsubscribees_upload=".$email."&adminpw=".$wp4toastmasters_mailman[$list."pass"];;
	$result = file_get_contents($url);
		}
}

add_action('rsvpmail_unsubscribe','unsubscribe_mailman_by_email');

function tm_recommend_send($name,$value,$permalink,$count,$post_id,$editor_id) {
		global $wpdb;
		global $rsvp_options;
		$code = get_post_meta($post_id,'suggest_code', true);
		if(!$code)
			{
				$code = wp_generate_password();
				update_post_meta($post_id,'suggest_code',$code);
			}
			$invite_check = $value.":".$post_id;
			if(isset($_SESSION[$invite_check])) // prevent double notifications
				return;
			$_SESSION[$invite_check] = 1;
			
			$date = get_rsvp_date($post_id);
			$date = strftime($rsvp_options['long_date'],strtotime($date));
			$neatname = trim(preg_replace('/[_\-0-9]/',' ',$name));
			$user = get_userdata($editor_id);
			$msg = sprintf('<p>Toastmaster %s %s %s %s %s %s</p>',$user->first_name,$user->last_name,__('has recomended you for the role of','rsvpmaker-for-toastmasters'),$neatname, __('for','rsvpmaker-for-toastmasters'),$date);
			$member = get_userdata($value);
			$email = $member->user_email;
			$hash = recommend_hash($name, $value,$post_id);
			
			$url = add_query_arg(array('key' => $name,'you' => $value, 'code' => $hash, 'count' => $count), $permalink); 
			$msg .= sprintf("\n\n".__('<p>Click here to <a href="%s">ACCEPT</a> (no password required if you act before someone else takes this role)</p>','rsvpmaker-for-toastmasters'),$url);
			if(!empty($_POST["editor_suggest_note"][$name]))
				$msg .= "\n\n<p><b>".__('Note from','rsvpmaker-for-toastmasters')." ".$user->first_name.' '.$user->last_name.": </b>".stripslashes($_POST["editor_suggest_note"][$name]).'</p>';
			$mail["html"] = $msg;
			$mail["to"] = $email;
			$mail["from"] = $user->user_email;
			$mail["cc"] = $user->user_email;
			$mail["fromname"] = $user->first_name." ".$user->last_name;
			$mail["subject"] = "You have been recommended for the role of ".$neatname.' on '.$date;
			awemailer($mail);
			$msg = '<div style="background-color: #eee; border: thin solid #000; padding: 5px; margin-5px;">'.$msg.'<p><em>'.__('Recommendation sent by email to','rsvpmaker-for-toastmasters').' <b>'.$email."</b></em></p></div>";	
			add_post_meta($post_id,'_activity_editor',$user->first_name.' '.$user->last_name.' recommended '.$member->first_name.' '.$member->last_name.' for '.$neatname.' on '.$date.', email sent to '.$email);
			update_option( '_tm_updates_logged', strtotime('+ 2 minutes') );
}

function rsvpmaker_agenda_notifications ($permalink) {
	global $current_user;
	$output = '';
	$cleared = get_user_meta($current_user->ID,'rsvpmaker_agenda_notifications');
	if(empty($cleared))
		$cleared = array();
	if(isset($_GET['wpt_clear']) && !in_array($_GET['wpt_clear'],$cleared))
	{
		$cleared[] = $_GET['wpt_clear'];
		add_user_meta($current_user->ID,'rsvpmaker_agenda_notifications',$_GET['wpt_clear']);
	}

	if(isset($_GET['wpt_clear_reset']))
	{
		$cleared = array();
		delete_user_meta($current_user->ID,'rsvpmaker_agenda_notifications');
	}
		$edlink = add_query_arg(array('edit_roles' => 1),$permalink);
		$reclink = add_query_arg(array('recommend_roles' => 1,'rm' => 1),$permalink);
		$allow_assign = get_option('allow_assign');
		if(($allow_assign == 'yes') || ( ($allow_assign == 'editor') && current_user_can('edit_others_rsvpmakers') ) )
			$assignlink = '<a href="%s'.add_query_arg(array('edit_roles' => 1,'rm' => 1),$permalink).'">Suggest Assignments</a>';
		else
			$assignlink = 'Suggest Assignments [not enabled]';
		$signup = $permalink;
		$permalink = add_query_arg($_GET,$permalink);
	if(isset($_GET['rm']))
	{
		if(isset($_GET['edit_roles']))
		{
		$notify['rmedit'] = sprintf('<span style="color:red; font-weight: bold">Caution:</span> Open roles are shown below with suggested assignments. These are <strong>NOT yet</strong> saved to the agenda. To make assignments, accept or change each suggestion, then scroll to the bottom and click Save Changes.<br />Switch Mode:<ul><li><a href="%s">Edit Signups</a> (no suggestions)</li><li><a href="%s">Recommend</a> (suggestions, members must confirm)</li><li><a href="%s">Member Signup</a></li></ul>.',$edlink, $reclink,$signup);
		
	$assign_ok = get_user_meta($current_user->ID,'assign_okay',true);
	if(empty($assign_ok) || ($assign_ok < time()))
	{
	$p = get_permalink();
	$notify['rmedit'] .= sprintf('<div><h2 style="color:red;">Are you sure you know what you are doing?</h2>
	<p>In Suggest Assignment mode (as opposed to Edit), open roles are filled with members selected by the software. If you accept the suggestions and click Save Changes at the bottom of the form, they will be saved to the agenda.</p>
	<p>Do you want to turn on Suggest Assignments mode?</p>
	<p><a href="%s">Yes, just for now.</a></p>
	<p><a href="%s">Yes, and do not ask me again.</a></p>
	</div>',add_query_arg(array('edit_roles' => 1, 'rm' =>1, 'sure' => strtotime('+2 hours')),$p),add_query_arg(array('edit_roles' => 1, 'rm' =>1, 'sure' => strtotime('+10 years')),$p));		
	}

		}
		else
		$notify['rmrec'] = sprintf('<strong>Recommend</strong> mode shows suggested assignments for open roles. If you scroll to the bottom and click Save Changes, these members will receive an email saying you have recommended them for the role. The assignment is <strong>NOT</strong> saved to the agenda until the member confirms acceptance.<br />Switch Mode:<ul><li><a href="%s">Edit Signups (no suggestions)</a></li><li>%s</li><li><a href="%s">Member Signup</a></li></ul>',$edlink, $assignlink,$signup);;		
	}
	elseif(isset($_GET['edit_roles']))
	{
		$notify['edit'] = sprintf('Edit Signups mode allows you to assign other members to roles or change assignments. When done, scroll to the bottom and click <strong>Save Changes</strong>. <br />Switch Mode:<ul><li>%s</li><li><a href="%s">Recommend (suggestions, member must confirm)</a></li><li><a href="%s">Member Signup</a></li></ul>',$assignlink, $reclink,$signup);
	}
	
	if(empty(get_option('hide_planner_promo')))
	$notify['planner'] = sprintf('To sign up for multiple upcoming meetings, try the <a href="%s">Multi-Meeting Role Planner</a>',admin_url('admin.php?page=toastmasters_planner'));

	if(!empty($notify))
	foreach($notify as $slug => $value)
	{
		$clearedurl = add_query_arg('wpt_clear',$slug,$permalink);
		if(!in_array($slug,$cleared))
			$output .= sprintf('<div class="wpt_notify %s"><div class="wpt_clear" title="Clear Notice"><a href="%s">&times;</a></div>%s</div>',$slug,$clearedurl,$value);
	}
	
	if(!empty($output)) {
		$output = '<style>
.wpt_notify {
    color:#555;
    border-radius:10px;
    font-family:Tahoma,Geneva,Arial,sans-serif;font-size:11px;
    padding:10px 10px 10px 36px;
    margin:10px;
	background-color: #fff8c4;
    border:1px solid #f2c779;
}
.wpt_clear {
float: right;
}
</style>'.$output;
	}
	
	return $output;
}

function awesome_event_content($content) {

if(!strpos($_SERVER['REQUEST_URI'],'rsvpmaker') ||  is_admin())
	return $content;

global $post, $rsvp_options, $current_user;

$link = $output = '';
	
if(isset($_REQUEST["recommendation"]))
	{
		if($_REQUEST["recommendation"] == 'success')
			$link = '<div style="border: thin solid #00F; padding: 10px; margin: 10px; background-color: #eee;">'.__('You have accepted a role for this meeting. Thanks!','rsvpmaker-for-toastmasters').'</div>';
		elseif($_REQUEST["recommendation"] == 'code_error')
			$link = '<div style="border: thin solid #F00; padding: 10px; margin: 10px; background-color: #eee;">'.__('Oops, something went wrong with the automatic sign up. Please sign in with your password to take a role','rsvpmaker-for-toastmasters').'</div>';		
		else
			$link = '<div style="border: thin solid #F00; padding: 10px; margin: 10px; background-color: #eee;">'.__('Oops, someone else took that role first. Sign in to take any other open role listed below','rsvpmaker-for-toastmasters').'</div>';
	}
if(($post->post_type != 'rsvpmaker') || !is_wp4t() )
	return $content;
$permalink = rsvpmaker_permalink_query($post->ID);

if(isset($_REQUEST["print_agenda"]) || is_email_context() )
	;
elseif( !is_club_member() )
	$link .= sprintf('<div id="agendalogin"><a href="%s">'.__('Login to Sign Up for Roles','rsvpmaker-for-toastmasters').'</a> or <a href="%s">'.__('View Agenda','rsvpmaker-for-toastmasters').'</a></div>',site_url().'/wp-login.php?redirect_to='.urlencode($permalink),$permalink.'print_agenda=1&no_print=1');
else
	{
	$link .= agenda_menu($post->ID);

if(isset($_REQUEST["assigned_open"]) && current_user_can($security['edit_signups']))
	{
	$link .= "\n".sprintf('<div style="margin-top: 10px; margin-bottom: 10px;"><a href="%s">%s</a></div>',$permalink.'assigned_open=1&email_me=1',__('Email to me','rspmaker-for-toastmasters'))."\n";
	
	$link .= wp4t_assigned_open();
	$link .= rsvp_report_this_post();
	return $link;
	}
if(isset($_POST["editor_suggest"]))
	{
		foreach($_POST["editor_suggest"] as $name => $value)
			{
			$count = (int) $_POST["editor_suggest_count"][$name];
			if($value < 1)
				continue;
			tm_recommend_send($name,$value,$permalink,$count,$post->ID,$current_user->ID);
			}
	}
$logged = (int) get_option( '_tm_updates_logged');
if($logged > time())
{
	//displayed up to 2 minutes after updates logged
	$output .= sprintf('<p style="border: thin dotted #000; padding: 5px;"><a href="%s">%s</a></p>',admin_url('admin.php?page=toastmasters_activity_log'),__('View log of assignments and recommendations.','rsvpmaker-for-toastmasters'));
}
/*
if(isset($_POST["editor_assign"]) && current_user_can('edit_posts') )
	{
	global $wpdb;
	$wpdb->show_errors();
	$date = get_rsvp_date($post->ID);
	$results = get_future_events(" (post_content LIKE '%[toastmaster%' OR post_content LIKE '%wp:wp4toastmasters%') AND meta_value > '$date' ",3);
	foreach($results as $row)
		{
		if(isset($row->eventdate))
			$eventdate = $row->eventdate;
		else
			$eventdate = date('F j',strtotime($row->datetime));
		$random_q = (isset($_POST["random"])) ? '&rm=1' : '';
		$link .= sprintf('<div id="agenda_print"><a href="%s">'.__('Edit Agenda Roles for','rsvpmaker-for-toastmasters').' %s</a></div>',rsvpmaker_permalink_query($row->postID).'edit_roles=1'.$random_q,$eventdate);
		}
	
	}
*/
	}

return $output.$link.$content;

}

function agenda_menu($post_id, $frontend = true) {
	global $post, $rsvp_options;
	$post = get_post($post_id);
	$permalink = get_permalink($post_id);
	$permalink .= strpos($permalink,'?') ? '&' : '?';
	$link = '';
	if($frontend)
		$link .= rsvpmaker_agenda_notifications($permalink);
	$agenda_lock = is_agenda_locked();

	$blank = ($frontend) ? '' : ' target="_blank" ';
	// defaults 'edit_signups' => 'read','email_list' => 'read','edit_member_stats' => 'edit_others_posts','view_reports' => 'read','view_attendance' => 'read','agenda_setup' => 'edit_others_posts'
	$security = get_tm_security ();	
	
	$link .= '<div id="cssmenu"><ul>';
	
	if(current_user_can('edit_signups') || edit_signups_role())
		{
		$link .= '<li class="has-sub"><a href="'.$permalink.'edit_roles=1" '.$blank.'>'.__('Edit Signups','rsvpmaker-for-toastmasters').'</a><ul>';
		$allow_assign = get_option('allow_assign');
		if(($allow_assign == 'yes') || ( ($allow_assign == 'editor') && current_user_can('edit_others_rsvpmakers') ) )
		$link .= '<li><a href="'.$permalink.'edit_roles=1&rm=1"'.$blank.'>'.__('Suggest Assignments','rsvpmaker-for-toastmasters').'</a></li>';
		$link .= '<li><a href="'.$permalink.'recommend_roles=1&rm=1"'.$blank.'>'.__('Recommend','rsvpmaker-for-toastmasters').'</a></li>';
		$link .= '<li><a href="'.$permalink.'reorder=1"'.$blank.'>'.__('Reorder','rsvpmaker-for-toastmasters').'</a></li>';
		if($frontend)
		{
		$events = get_future_events("(post_content LIKE '%[toastmaster%' OR post_content LIKE '%wp:wp4toastmasters%') ", 10);
		
		if($events)
		foreach ($events as $event)
		{
			$link .= '<li><a href="'.rsvpmaker_permalink_query($event->ID).'"'.$blank.'>'.strftime($rsvp_options["short_date"],strtotime($event->datetime)).'</a></li>';
			if(current_user_can($security['edit_signups']) || edit_signups_role($event->ID))
				$link .= '<li><a href="'.rsvpmaker_permalink_query($event->ID,'edit_roles=1').'"'.$blank.'>'.__('Edit','rsvpmaker-for-toastmasters').' '.strftime($rsvp_options["short_date"],strtotime($event->datetime)).'</a></li>';
		}
		$link .= '<li class="last"><a href="'.$permalink.'"'.$blank.'>'.__('Stop Editing','rsvpmaker-for-toastmasters').'</a></li></ul></li>';
			
		}
		else
			$link .= '</ul></li>';
}
	$link .= '<li class="has-sub"><a target="_blank" href="'.$permalink.'print_agenda=1">'.__('Agenda','rsvpmaker-for-toastmasters').'</a><ul> ';
	if(current_user_can($security['email_list']))
		$link .= '<li><a  target="_blank" href="'.$permalink.'print_agenda=1">'.__('Print','rsvpmaker-for-toastmasters').'</a></li>';
		$link .= '<li><a  target="_blank" href="'.$permalink.'email_agenda=1">'.__('Email','rsvpmaker-for-toastmasters').'</a></li>';
	$link .= '<li class="last"><a target="_blank" href="'.$permalink.'print_agenda=1&word_agenda=1">'.__('Export to Word','rsvpmaker-for-toastmasters').'</a></li>';
	$link .= '<li class="last"><a target="_blank" href="'.$permalink.'print_agenda=1&no_print=1">'.__('Show','rsvpmaker-for-toastmasters').'</a></li>';
	if(!get_option('wp4toastmasters_intros_on_agenda'))
	$link .= '<li class="last"><a target="_blank" href="'.$permalink.'print_agenda=1&no_print=1&showintros=1">'.__('Show with Introductions','rsvpmaker-for-toastmasters').'</a></li>';
	$link .= '<li class="last"><a href="'.$permalink.'assigned_open=1" '.$blank.'>'.__('Agenda with Contacts','rsvpmaker-for-toastmasters').'</a></li>';
	$link .= '<li class="last"><a target="_blank" href="'.$permalink.'intros=show">'.__('Speech Introductions','rsvpmaker-for-toastmasters').'</a></li>';
	$link .= '<li class="last"><a target="_blank" href="'.$permalink.'scoring=dashboard">'.__('Contest Scoring Dashboard','rsvpmaker-for-toastmasters').'</a></li>';
	$online = get_option('tm_online_meeting');
	$platform = (empty($online['platform'])) ? 'Jitsi' : $online['platform'];
	if($platform != 'Zoom')
	$link .= '<li class="last"><a target="_blank" href="'.$permalink.'timer=1&embed=jitsi">'.__('Online Meeting (Jitsi)','rsvpmaker-for-toastmasters').'</a></li>';
	if(($platform == 'Zoom') || ($platform == 'Both'))
		$link .= '<li class="last"><a target="_blank" href="'.$permalink.'timer=1&embed=zoom">'.__('Online Meeting (Zoom)','rsvpmaker-for-toastmasters').'</a></li>';
	$link .= '<li class="last"><a target="_blank" href="'.$permalink.'timer=1">'.__('Online Timer','rsvpmaker-for-toastmasters').'</a></li></ul></li>';

	$template_id = get_post_meta($post->ID,'_meet_recur',true);
	$layout_id = get_option('rsvptoast_agenda_layout');
	if(current_user_can($security['agenda_setup']))
		{
		$agenda_menu[__('Agenda Setup','rsvpmaker-for-toastmasters')] = admin_url('post.php?action=edit&post='.$post->ID);
		if($template_id)
			$agenda_menu[__('Agenda Setup: Template','rsvpmaker-for-toastmasters')] = admin_url('post.php?action=edit&post='.$template_id);
		}
	if(current_user_can('manage_options'))
	{
		if($agenda_lock) {
			$agenda_menu[__('Unlock Agenda','rsvpmaker-for-toastmasters')] = $permalink.'lock=unlockall';
			$agenda_menu[__('Unlock Agenda (Admin Only)','rsvpmaker-for-toastmasters')] = $permalink.'lock=unlockadmin';
		}
		else {
			$post_lock = get_post_meta($post->ID,'agenda_lock',true);
			if(strpos($post_lock,'admin'))
			$agenda_menu[__('Unlock Agenda for All','rsvpmaker-for-toastmasters')] = $permalink.'lock=unlockall';
			$agenda_menu[__('Lock Agenda','rsvpmaker-for-toastmasters')] = $permalink.'lock=on';
			$agenda_menu[__('Lock Agenda (Except for Admin)','rsvpmaker-for-toastmasters')] = $permalink.'lock=lockexceptadmin';
		}
	}
	if(current_user_can($security['edit_signups']))
		{
		//if(!function_exists('do_blocks'))
		//$agenda_menu[__('Agenda Timing','rsvpmaker-for-toastmasters')] = admin_url('edit.php?post_type=rsvpmaker&page=agenda_timing&post_id='.$post->ID);
		if($template_id && current_user_can($security['agenda_setup']))
		{
			//if(!function_exists('do_blocks'))
			//$agenda_menu[__('Agenda Timing: Template','rsvpmaker-for-toastmasters')] = admin_url('edit.php?post_type=rsvpmaker&page=agenda_timing&post_id='.$template_id);
			$agenda_menu[__('Switch Template','rsvpmaker-for-toastmasters')] = admin_url('edit.php?post_type=rsvpmaker&page=rsvpmaker_template_list&apply_target='.$post->ID.'&apply_current='.$template_id.'#applytemplate');			
		}
		if($layout_id && current_user_can($security['agenda_setup']))
			$agenda_menu[__('Agenda Layout Editor (Advanced)','rsvpmaker-for-toastmasters')] = admin_url('post.php?action=edit&post='.$layout_id);
		if(current_user_can($security['agenda_setup']))
			$agenda_menu[__('Agenda Sidebar','rsvpmaker-for-toastmasters')] = $permalink.'edit_sidebar=1';
		}
if(!empty($agenda_menu)) {
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

	if(current_user_can('edit_signups'))	
	$link .= '<li class="has-sub"><a target="_blank" href="'.site_url('?signup2=1').'">'.__('Signup Sheet','rsvpmaker-for-toastmasters').'</a><ul><li class="last"><a target="_blank" href="'.site_url('?signup_sheet_editor=1').'">'.__('Edit Signups (multiple weeks)','rsvpmaker-for-toastmasters').'</a></li></ul></li>';
	else
	$link .= '<li class="last"><a target="_blank" href="'.site_url('?signup2=1').'">'.__('Signup Sheet','rsvpmaker-for-toastmasters').'</a></li>';
	if($frontend)
	$link .= '<li class="last"><a  target="_blank" href="'.admin_url('admin.php?page=toastmasters_planner').'">'.__('Role Planner','rsvpmaker-for-toastmasters').'</a></li>';
	$link .= '</ul></div>';

	if($agenda_lock)
		$link .= '<p style="margin: 10px; padding: 5px; border: thin dotted red;">Agenda is locked against changes and can only be unlocked by an administrator.</p>';
	elseif(!empty($post_lock) && strpos($post_lock,'admin'))
		$link .= '<p style="margin: 10px; padding: 5px; border: thin dotted red;">Agenda is locked (except for administrator).</p>';
return $link;
}

function random_available_check() {
global $wpdb;
global $post;
global $current_user;
global $random_available;
if(!empty($random_available))
    return $random_available;
else
    $random_available = array();
if(isset($_REQUEST["rm"]))
{

if(isset($_REQUEST["sure"]))
{
	$sure = (int) $_REQUEST["sure"];
	update_user_meta($current_user->ID,'assign_okay',$sure);
}

$sql = "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key RLIKE '^_[A-Z].+[0-9]$' AND post_id=$post->ID";	
$results = $wpdb->get_results($sql);

$preassigned = array();
global $histories;
global $histories;
if(empty($histories))
	$histories = tm_get_histories();

foreach($results as $row)
{
if(is_numeric($row->meta_value))
	$preassigned[] = $row->meta_value;
}

$blogusers = get_users('blog_id='.get_current_blog_id() );
    foreach ($blogusers as $user) {
    if(isset($_GET['debug']))
    {
        echo '<div style="background-color: #fff;">test user '.$user->ID.': <pre>';
        echo "\npreassigned";
        print_r($preassigned);
        echo "\naway";
        print_r($histories[$user->ID]->away_active);
        echo '</pre></div>';
    }
        
	if(in_array($user->ID,$preassigned))
		continue;
	if(!empty($histories[$user->ID]->away_active))
		continue;
	$userdata = get_userdata($user->ID);
	//if($userdata->hidden_profile)
	//	continue;
	if(is_array($random_available))
	    $random_available[] = $user->ID;
	elseif(isset($_GET['debug']))
	    {
	    echo '<div>not an array"';
	    print_r($random_array);
	    echo '"</div>';
	    }
    if(isset($_GET['debug']))
    {
        echo '<div style="background-color: #fff;">add to array '.$user->ID;
        print_r($random_available);
        echo '</div>';
    }

    }
if(!empty($random_available) && is_array($random_available))
shuffle($random_available);
}
return $random_available;
}

function pick_random_member($role) {
global $random_available;
global $histories;
global $last_attended;
global $last_filled;
global $current_user;

$attempts = 0;
$last_filled_limit = get_option('last_filled_limit');
$last_attended_limit = get_option('last_attended_limit');

$assigned = array_shift($random_available);
if(!$histories[$assigned]->get_eligibility($role))
{
	$random_available[] = $assigned; // put on end and try again
	$assigned = array_shift($random_available);
	if(!$histories[$assigned]->get_eligibility($role))
	{
		$random_available[] = $assigned; // put on end and try again
		$assigned = array_shift($random_available); // may not be perfect, but ...
	}
}
	
if(!isset($last_filled[$role][$assigned]))
	{
	$last_filled[$role][$assigned] = $histories[$assigned]->get_last_held($role);
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
			$last_filled[$role][$assigned] = $histories[$assigned]->get_last_held($role);
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
if(isset($_GET['action']))
	return; // don't let gutenberg try to display in editor

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
	//if($userdata->hidden_profile)
	//	continue;
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
	
	if(( isset($_REQUEST["print_contacts"]) || is_admin() ) && is_array($members))
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
	elseif(!empty($title) || ( ($userdata->public_profile == 1) || strtolower(trim($userdata->public_profile)) == 'yes'))
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
$args = array('item_id' => $userdata->ID,'type' => 'full', 'no_grav' => false);
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
		
		if(!$public_context && function_exists('bp_get_user_last_activity') && !isset($_REQUEST["email_prompt"]) )
			{
			printf('<p><strong>%s</strong> %s</p>',__('BuddyPress Profile','rsvpmaker-for-toastmasters'),bp_core_get_userlink( $userdata->ID ));
			}
		if( !$public_context && !isset($_REQUEST["email_prompt"]) )
			{
			//get_user_meta($id,'status',true );
			$status = wp4t_get_member_status($userdata->ID);
			if(!empty($status))
				echo '<p>'.$status.'</p>';
			printf('<p><a href="%s">%s</a></p>',admin_url('profile.php?page=wp4t_set_status_form&member_id=').$userdata->ID,__('Set Away Message','rsvpmaker-for-toastmasters'));
			}

$joinedslug = 'joined'.get_current_blog_id();
if(!empty($userdata->$joinedslug))
	printf('<div class="club_join_date">%s: %s</div>',__('Joined Club','rsvpmaker-for-toastmasters'),$userdata->$joinedslug);
elseif(!empty($userdata->club_member_since))
	printf('<div class="club_join_date">%s: %s</div>',__('Joined Club','rsvpmaker-for-toastmasters'),$userdata->club_member_since);
if(!empty($userdata->original_join_date))
	printf('<div class="original_join_date">%s: %s</div>',__('Joined Toastmasters','rsvpmaker-for-toastmasters'),$userdata->original_join_date);
?>
</div>
<?php

}

function add_awesome_member() {

global $wpdb;
global $current_user;
$blog_id = get_current_blog_id();

if(isset($_POST['addtid']))
{
	foreach($_POST['addtid'] as $user_id => $member_id)
	{
		$member_id = (int) $member_id;
		if($member_id)
		update_user_meta($user_id,'toastmasters_id',$member_id);
	}
}
	
if(isset($_POST["newuser"]))
	{
	$member_factory = new Toastmasters_Member();

		foreach($_POST["newuser"] as $index => $user)
			{
				$type = (!empty($_POST["new_or_existing"][$index])) ? $_POST["new_or_existing"][$index] : 'new';
				if($type == 'new')
					{
					$user["confirmed"] = 1;
					$users[] = $user;
					}
				else
					{
					$p = explode(':',$type);
					$user_id = (int) $p[0];
					make_blog_member($user_id);
					$tid = (int) $p[1];
					if($tid)
						update_user_meta($user_id,'toastmasters_id',$tid);
					$userdata = get_userdata($user_id);
					$msg = $userdata->first_name.' '.$userdata->last_name.' '.__('added to website','rsvpmaker-for-toastmasters');
					echo '<div class="notice notice-success is-dismissible"><p>'.$msg.'</p></div>';
					}
			}
	if(!empty($users))
	{
if(empty($member_factory))
$member_factory = new Toastmasters_Member();
foreach($users as $index => $user)
	{
		$users[$index] = $member_factory->check($user);
	}
foreach($users as $user)
	{
	if(!empty($user))
	$active_ids[] = $member_factory->add($user);
	}
$member_factory->show_prompts();
$member_factory->show_confirmations();
	}

	}
if(isset($_POST["remove_user"])) {
	foreach($_POST["remove_user"] as $user_id)
		{
		if(function_exists('remove_user_from_blog'))
			remove_user_from_blog( $user_id, $blog_id ); // multisite
		else
			wp_delete_user($user_id);
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
	$user["nickname"] = $user["display_name"] = $user["first_name"].' '.$user["last_name"];
	if(isset($label["Paid Until"]))
	{
		if(time() > strtotime($cells[$label["Paid Until"]]))
		{
			//echo '<div>'.$user["nickname"].' membership expired: '.$cells[$label["Paid Until"]].'</div>';
			continue;			
		}
	}

	if(!empty($label["Edu."]) && !empty($cells[$label["Edu."]]))
		$user["education_awards"] = $cells[$label["Edu."]];		
		
	if(isset($label["E-mail"]))
		$user["user_email"] = strtolower(trim($cells[$label["E-mail"]]));
	elseif(isset($label["Email"]))
		$user["user_email"] = strtolower(trim($cells[$label["Email"]]));
	if($user["user_email"] == strtolower(trim($current_user->user_email)))
		continue;
	
	$user["user_login"] = preg_replace('/[^a-z]/','',strtolower($user["first_name"].$user["last_name"]));

	if(isset($label["Home Phone"]) && isset($cells[$label["Home Phone"]]))
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
	elseif(isset($label["CustomerID"]))
		$user["toastmasters_id"] = $cells[$label["CustomerID"]];
	elseif(isset($label["Customer ID"]))
		$user["toastmasters_id"] = $cells[$label["Customer ID"]];
	elseif(isset($label["Customer Id"]))
		$user["toastmasters_id"] = $cells[$label["Customer Id"]];
	if(!empty($user["toastmasters_id"]))
		$user["toastmasters_id"] = (int) $user["toastmasters_id"];//get rid of zero padding
	$blog_id = get_current_blog_id();
	if(isset($label["Member of Club Since"]))
		{
			$user["club_member_since"] = $cells[$label["Member of Club Since"]];
			$user["club_member_since_".$blog_id] = $cells[$label["Member of Club Since"]];
		}
	if(isset($label["Paid Until"]))
		{
			$user["paid_until_".$blog_id] = $cells[$label["Member of Club Since"]];
		}
	if(isset($label["Original Join Date"]))
		$user["original_join_date"] = $cells[$label["Original Join Date"]];
	
	$user["user_pass"] = password_hurdle(wp_generate_password());
	$users[] = $user;
	}
	//break;
	}

if(empty($users))
	return;

$member_factory = new Toastmasters_Member();
foreach($users as $index => $user)
	{
		$users[$index] = $member_factory->check($user);
	}
foreach($users as $user)
	{
	if(!empty($user))
	$active_ids[] = $member_factory->add($user);
	}
$member_factory->show_prompts();
$member_factory->show_confirmations();
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

$member_factory = new Toastmasters_Member();
$user = $member_factory->check($user);
if(!empty($user))
	$member_factory->add($user);
$member_factory->show_prompts();
$member_factory->show_confirmations();
	}

$user_pass_default = password_hurdle(wp_generate_password());

if(isset($_POST["resend"]))
{
	$member_factory = new Toastmasters_Member();
	foreach($_POST["resend"] as $resend)
	{
		$user = get_userdata($resend);
		$member_factory->sendWelcome(array('user_login' => $user->user_login, 'user_email' => $user->user_email));
	}
$member_factory->show_confirmations();
}

if(isset($_POST['existing_email']))
{
	$email_exists = get_user_by('email',$_POST['existing_email'] );
	if($email_exists)
	{
		if(is_multisite())
		add_user_to_blog(get_current_blog_id(),$email_exists->ID,'subscriber');
		echo '<div class="notice notice-success is-dismissible"><p>'.__('Added user','rsvpmaker-for-toastmasters').': '.$email_exists->user_login.'<p></div>';
	}
	else
		echo '<div class="notice notice-error is-dismissible"><p>'.__('No user record found for','rsvpmaker-for-toastmasters').': '.$_POST['existing_email'].'<p></div>';
}

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

<?php
if(is_multisite()) {
	?>
<h3><?php _e("Add member to site by email",'rsvpmaker-for-toastmasters');?></h3>
<p>Users who are members of other clubs whose websites are hosted here can be added by entering the member's email address. This must be the same email address they use on the other club's website.</p>
<form action ="<?php echo admin_url('users.php?page=add_awesome_member'); ?>" method="post">
	<p><strong>Email:</strong> <input type="text" name="existing_email" ></p>
<p class="submit"><input type="submit" name="createuser" id="createusersub" class="button-primary" value="<?php _e("Add By Email",'rsvpmaker-for-toastmasters');?>"  /></p>

</form>

<?php
	}
?>
<div id="import">
<h3><?php _e("Batch Import From Toastmasters.org spreadsheet",'rsvpmaker-for-toastmasters');?></h3>
<p><?php _e("If you download the member spreadsheet from toastmasters.org, you should be able to copy the cells including member data (including the header row of column labels) and paste it here (use Ctrl-V on Windows).",'rsvpmaker-for-toastmasters');?></p>
<form method="post" action="<?php echo admin_url('users.php?page=add_awesome_member'); ?>">
<textarea cols="80" rows="10" name="spreadsheet"></textarea>
	<div><input type="checkbox" name="check_missing" value="1" /> <?php _e("Check for missing members (if you post a complete list of current members, this checkbox triggers a check of which website users are NOT currently on the toastmasters.org list and gives you an option to delete them).",'rsvpmaker-for-toastmasters');?></div>
	<div><input type="checkbox" name="no_email" value="1" /> <?php _e("Do not send email invites (for example, if you are still testing the site).",'rsvpmaker-for-toastmasters');?></div>
	<div>
	<?php
	
	$blogusers = get_users( 'blog_id='.get_current_blog_id() );
	$addids = '';
// Array of WP_User objects.
foreach ( $blogusers as $user ) {
	$tid = get_user_meta($user->ID,'toastmasters_id',true);
	if(empty($tid))
	{
		$addids .= sprintf('<div><input type="text" name="addtid[%d]"> %s %s %s</div>',$user->ID,get_user_meta($user->ID,'first_name',true),get_user_meta($user->ID,'last_name',true),$user->user_email);
	}
}
	if(!empty($addids))
	{
		echo '<p>';
		_e('For better results when synchronizing with your list, add IDs for these members.');
		echo '</p>';
		echo $addids;
	}
	
	?>
	</div>

<p class="submit"><input type="submit" name="createuser" id="createusersub" class="button-primary" value="<?php _e("Import",'rsvpmaker-for-toastmasters');?>"  /></p>

</form>
<p><img src="<?php echo plugins_url( 'spreadsheet.png' , __FILE__ ); ?>" width="500" height="169" /></p>
</div>

<div id="resend">
<h3>Resend Welcome Message</h3>
	<p>If members did not receive the email inviting them to set their password, or if you added them before turning on email notifications, you can resend those notifications by checking off the names below and clicking Send. Note that this will generate a new password reset code (invalidating any that may have been sent previously).</p>
<form method="post" action="<?php echo admin_url('users.php?page=add_awesome_member'); ?>">
	<p><input type="checkbox" id="checkAll"> <strong>Check all</strong></p>
<?php
$blogusers = get_users( 'orderby=nicename&blog_id='.get_current_blog_id() );
// Array of WP_User objects.
foreach ( $blogusers as $user ) {
    printf('<div><input type="checkbox" class="resend" name="resend[]" value="%d">%s %s</div>',$user->ID,$user->user_login,$user->display_name);
}	
?>
<input type="submit" value="<?php _e("Send",'rsvpmaker-for-toastmasters');?>" />
</form>	
</div>

</div>
<script>
(function($) {
$("#checkAll").change(function () {
    $(".resend").prop('checked', $(this).prop("checked"));
});	
})( jQuery );
</script>
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
$edpattern = "/, ([A-Z0-9]{2,6})/";
preg_match_all($edpattern,$name,$matches);
$user["nickname"] = $user["display_name"] = preg_replace($edpattern,'',$name);
$np = explode(" ",$user["display_name"]);
$user["last_name"] = array_pop($np);
$user["first_name"] = implode(" ",$np);
if(!empty($matches[1][0]))
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
if($users)
return $users[0];
}

function make_blog_member($user_id) {
if(!is_multisite())
	return;
$blog_id = get_current_blog_id();
	
if(!is_user_member_of_blog($user_id,$blog_id))
{
	add_user_to_blog($blog_id,$user_id,'subscriber');
	$w = get_option('wp4toastmasters_welcome_message');
	if(!empty($w))
		{
		$p = get_post($w);
		$welcome = '<h1>'.$p->post_title."</h1>\n\n".wpautop($p->post_content);
		}
	else
		$welcome = '';
		
	$userdata = get_userdata($user_id);
	
		$blogs = get_blogs_of_user($user_id);
		$bloglist = '';
		if(!empty($blogs))
		foreach($blogs as $blog)
		{
			$bloglist .= (empty($bloglist)) ? 'You are a member of these sites: ' : ', ';
			$bloglist .= sprintf('<a href="%s">%s</a>',$blog->siteurl,$blog->blogname);
		}
	
		$message = '<p>'.__('You have been registered at').': '.site_url().'</p>';
		$message .= '<p>'.__('Username').': '.$userdata->user_login.'</p>';
		$message .= '<p>'.$bloglist.'</p>';
		$message .= '<p>To reset your password, visit <a href="'.site_url().'/wp-login.php?action=lostpassword">'.site_url().'/wp-login.php?action=lostpassword</a></p>
		
		<p>Your password is the same for all the sites listed above.</p>';	
		$message .= '<p>'.__('For a basic orientation to the website setup we are using, see the <a href="http://wp4toastmasters.com/new-member-guide-to-wordpress-for-toastmasters/">New Member Guide to WordPress for Toastmasters</a>','rsvpmaker-for-toastmasters').'</p>';

			$admin_email = get_bloginfo('admin_email');
			$mail["subject"] = 'Welcome to '.get_bloginfo('name');
			$mail["replyto"] = $admin_email;
			$mail["html"] = "<html>\n<body>\n".$message.$welcome."\n</body></html>";
			$mail["to"] = $userdata->user_email;
			$mail["cc"] = $admin_email;			
			$mail["from"] = $admin_email;
			$mail["fromname"] = get_bloginfo('name');
			echo $return = awemailer($mail);
	if($return)
	printf('<p style="color: red;">Emailing to %s</p>',$userdata->user_email);
	echo $message;
	}	
	
}

class Toastmasters_Member  {

public $prompts;
public $confirmations;
public $active_ids;
public $blog_id;
public $welcome;
public $prompt_count;
public $sync_time;

function __construct() {
$this->prompt_count = 0;
$this->blog_id = get_current_blog_id();
$this->sync_time = time();
	$welcome = '';
	$w = get_option('wp4toastmasters_welcome_message');
	if(!empty($w))
		{
		$p = get_post($w);
		$welcome = '<h1>'.$p->post_title."</h1>\n\n".wpautop($p->post_content);
		}
	}

function add ($user) 
	{
	$member_id = (!empty($user["ID"])) ? $user["ID"] : 0;			
	if($member_id)
		{
		$name = get_member_name($member_id);
		$this->active_ids[] = $member_id;
		if(is_multisite() && !is_user_member_of_blog( $member_id, $this->blog_id ) && !user_can($member_id,'manage_options') )
			{
			add_user_to_blog($this->blog_id, $member_id,'subscriber');
			$this->confirmation[] = $name .' '. __('added to this site','rsvpmaker-for-toastmasters');
			}
		if(!empty($user["toastmasters_id"]) && !get_user_meta($member_id,'toastmasters_id',true) )
			{
			$this->confirmation[] = $name .' '. __('adding Toastmasters ID','rsvpmaker-for-toastmasters');
			update_user_meta($member_id,"toastmasters_id",$user["toastmasters_id"]);
			}
		if(!empty($user["education_awards"]))
			{
			$this->confirmation[] = $name .' '. __('educational awards updated','rsvpmaker-for-toastmasters');
			update_user_meta($member_id,"education_awards",$user["education_awards"]);
			}
		if(!empty($user["club_member_since"]))
			{
			update_user_meta($member_id,"club_member_since",$user["club_member_since"]);
			update_user_meta($member_id,"joined".get_current_blog_id(),$user["club_member_since"]);
			}
		if(!empty($user["original_join_date"]))
			{
			update_user_meta($member_id,"original_join_date",$user["original_join_date"]);
			}
		return $member_id;
		}
	else
		{
		//register user
		if(isset($user["ID"]))
			unset($user["ID"]); // if set but empty, discard
		if($user_id = wp_insert_user($user))
			{
			$this->active_ids[] = $user_id;
    // Generate something random for a password reset key.
			$this->sendWelcome($user);
			if(empty($user["club_member_since"]))
				update_user_meta($user_id,"joined".get_current_blog_id(),date('m/d/Y'));
			else
				update_user_meta($user_id,"joined".get_current_blog_id(),$user["club_member_since"]);
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
	
function sendWelcome($user) {
	    $key = wp_generate_password( 20, false );
 
		do_action( 'retrieve_password_key', $user["user_login"], $key );

		// Now insert the key, hashed, into the DB.
		if ( empty( $wp_hasher ) ) {
			require_once ABSPATH . WPINC . '/class-phpass.php';
			$wp_hasher = new PasswordHash( 8, true );
		}
		$hashed = time() . ':' . $wp_hasher->HashPassword( $key );
		global $wpdb;
		$wpdb->update( $wpdb->users, array( 'user_activation_key' => $hashed ), array( 'user_login' => $user["user_login"] ) );
		$set_password_msg = __('To set your password, visit the following address:');
		$set_password = site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user["user_login"]), 'login');

		$set_password = apply_filters('welcome_message_set_password',$set_password, $key, $user['user_login']);

		$profile_url = admin_url('profile.php#user_login');
		$message = '<p>'.__('You have been registered at').': '.site_url().'</p>';
		$message .= '<p>'.__('Username').': '.$user["user_login"].'</p>';
		$message .= '<p>'. $set_password_msg .'<br /><a href="'.$set_password.'">'.$set_password.'</a></p>';
		$message .= '<p>'.__('For a basic orientation to the website setup we are using, see the <a href="http://wp4toastmasters.com/new-member-guide-to-wordpress-for-toastmasters/">New Member Guide to WordPress for Toastmasters</a>','rsvpmaker-for-toastmasters').'</p>';
		$message .= '<p>'.__('Note that your club website user name and password are <em>not</em> the same as the credentials you will use on toastmasters.org (the website of Toastmasters International) to access Pathways educational materials.','rsvpmaker-for-toastmasters').'</p>';
	
		$welcome_id = get_option('wp4toastmasters_welcome_message');
		if($welcome_id)
		{
			$welcome = get_post($welcome_id);
			if(!empty($welcome->post_content))
			{
				if(strpos($welcome->post_content,'!--'))
					$welcome->post_content = do_blocks($welcome->post_content);
				if(!strpos($welcome->post_content,'</p>'))
					$welcome->post_content = wpautop($welcome->post_content);
				$message .= '<h2>'.$welcome->post_title."</h2>\n".$welcome->post_content;
			}
		}
	
		if(isset($_POST["no_email"]) && $_POST["no_email"])
			{
			echo "<h3>".__('Email notification disabled','rsvpmaker-for-toastmasters')."</h3><pre>".$message."</pre>";
			}
			else
			{
			$admin_email = get_bloginfo('admin_email');
			$mail["subject"] = 'Welcome to '.get_bloginfo('name');
			$mail["replyto"] = $admin_email;
			$mail["html"] = "<html>\n<body>\n".$message.$this->welcome."\n</body></html>";
			$mail["to"] = $user["user_email"];
			$mail["cc"] = $admin_email;			
			$mail["from"] = $admin_email;
			$mail["fromname"] = get_bloginfo('name');
			$return = awemailer($mail);
			if($return === false)
				$this->confirmations[] = "<h3>".__('Emailing notifications disabled','rsvpmaker-for-toastmasters')."</h3><pre>".$message."</pre>";			
			else	
				$this->confirmations[] = "<h3>".__('Emailing to','rsvpmaker-for-toastmasters')." ".$user["user_email"]."</h3>".wpautop($message);
			}	
}

function check ($user) 
	{
	foreach($user as $name => $value)
		$user[$name] = trim($value);	
	if(empty($user["first_name"]) || empty($user["last_name"]))
		return;

	if(empty($user["user_login"]) )
		{
		//assign based on first name or first+last
		$user["user_login"] = preg_replace('/[^a-z]/','',strtolower($user["first_name"]));
		if(get_user_by('login',$user["user_login"] ))
			$user["user_login"] = preg_replace('/[^a-z]/','',strtolower($user["first_name"].$user["last_name"]));
		}
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
		if(!empty($member_exists->ID))
			{
			$this->confirmations[] = $user["first_name"].' '.$user["last_name"].' recognized by user ID'; 
			$this->active_ids[] = $member_exists->ID;
			$user['ID'] = $member_exists->ID;
			return $user;
			}
		}
	else
	{
	if(!empty($user["toastmasters_id"]))
	{
	$user["toastmasters_id"] = (int) $user["toastmasters_id"]; // get rid of any zero padding
	$member_exists = get_user_by_tmid($user["toastmasters_id"]);
	if(!empty($member_exists->ID))
		{
		$this->confirmations[] = $user["first_name"].' '.$user["last_name"].' recognized by Toastmasters ID'; 
		$this->active_ids[] = $member_exists->ID;
		$user['ID'] = $member_exists->ID;
		return tm_sync_fields($user);
	}
	}
	$login_exists = get_user_by('login',$user["user_login"] );
	$email_exists = get_user_by('email',$user["user_email"] );
	if( ($login_exists && $email_exists) && ($login_exists->ID == $email_exists->ID) )
		{
		$user["ID"] = $login_exists->ID;
		$this->confirmations[] = get_member_name($login_exists->ID).' recognized by name and email';
		return tm_sync_fields($user); // add the toastmasters ID
		}
	elseif($email_exists)
		{
			$tmid = get_user_meta($email_exists->ID,'toastmasters_id',true);
			if(empty($tmid) && !empty($user["toastmasters_id"]))
				{
					$user["ID"] = $email_exists->ID;
					return tm_sync_fields($user); // right user, no tmid
				}
			elseif(!empty($tmid) && !empty($user["toastmasters_id"]) && ($tmid != $user["toastmasters_id"]))
				{
					//different person with same email address
					$user["user_email"] = $user["user_login"].'@example.com';
					$this->confirmations[] = '<span style="color: red;">'.$user["first_name"].' '.$user["last_name"].' appears to have the same email address as '.get_member_name($email_exists->ID). ': '.$email_exists->user_email. '(set to '.$user["user_email"].' instead to keep records distinct)</span>';
					return tm_sync_fields($user);
				}
			else
				{
				$this->prompts[] = '<span style="color: red;">'.$user["first_name"].' '.$user["last_name"].' appears to have the same email address as '.get_member_name($email_exists->ID). ': '.$email_exists->user_email.' Each user must have a distinct email address.</span><br />'.$this->prompt_fields($user,$email_exists);
				return;
				}
		}
	if(!is_email($user["user_email"]) && !strpos($user["user_email"],'example.com') )
		 {
		$this->prompts[] = '<span style="color: red;">'.__('Error: invalid email address','rsvpmaker-for-toastmasters').' '.$user["user_email"].'</span><br />'.$this->prompt_fields($user);
		 return;
		 }

	if($login_exists)
		{
		for($i=0; $i < 100; $i++)
		{
			$suffix = ($i) ? $i : '';
			$newlogin = preg_replace('/[^A-Za-z]/','',strtolower($user["first_name"])).$suffix;
			if(!get_user_by('login',$newlogin))
			{
				$user['user_login'] = $newlogin;
				break;
			}
		}
		$this->prompts[] = $this->prompt_fields($user,$login_exists);
		return;		
		}
		
	if(!empty($user["confirmed"]))
		return $user;
	else
		$this->prompts[] = $this->prompt_fields($user);
	}
}

function prompt_fields($user, $other_user = NULL) {
$o = '';
$visible = array('user_login','first_name','last_name','educational_awards','user_email','home_phone','work_phone','mobile_phone','toastmasters_id',"club_member_since","original_join_date");

if(empty($other_user))
	$o = '<h3>New</h3>';
else
{
$member = (is_user_member_of_blog($other_user->ID)) ? '' : '<div>(user account not currently associated with this club website)</div>';
$userdata = get_userdata($other_user->ID);
$tid = empty($user["toastmasters_id"]) ? '' : $user["toastmasters_id"];
$o .= sprintf('<h3><input type="radio" name="new_or_existing[%d]" value="%d:%d" checked="checked" /> Add this existing record?</h3>%s',$this->prompt_count,$other_user->ID, $tid,$member);
foreach($visible as $field)
	{
	$value = (empty($userdata->$field)) ? '' : $userdata->$field;
	$o .= sprintf('<div>%s %s</div>',$field,$value);
	}
$blogs = get_blogs_of_user($other_user->ID);
$bloglist = '';
foreach($blogs as $blog)
{
	$bloglist = (empty($bloglist)) ? 'Member of: ' : ', ';
	$bloglist .= $blog->blogname;	
}
$o .= '<div>'.$bloglist.'</div>';
$o .= sprintf('<h3><input type="radio" name="new_or_existing[%d]" value="new" /> Or record as new member?</h3><div>',$this->prompt_count);
}
$o .= '<table>';
foreach($visible as $field)
{
	$value = (empty($user[$field])) ? '' : $user[$field];
	$o .= sprintf('<tr><td>%s</td><td><input type="text" name="newuser[%d][%s]" value="%s" ></td></tr>',$field,$this->prompt_count,$field,$value);	
}
$o .= '</table>';

$this->prompt_count++;
return $o;

}
	
function show_prompts() 
	{
$o = '';
$missing = '';
if(!empty($this->prompts))
foreach($this->prompts as $p)
	$o .= '<p class="prompt">'.$p.'</p>';
if(!empty($_POST["check_missing"]))
{
global $current_user;
$this->active_ids[] = $current_user->ID;
$blogusers = get_users('blog_id='.get_current_blog_id() );
    foreach ($blogusers as $user) {		
	if(!in_array($user->ID, $this->active_ids) )
		{
		if($user->user_login == '0_NOT_AVAILABLE')
			continue;
		$userdata = get_userdata($user->ID);
		$missing .= sprintf('<p><input type="checkbox" name="remove_user[%d]" value="%d"> Remove: %s (%s) </p>',$user->ID, $user->ID, $userdata->display_name, $userdata->user_login);
		}
	}

if(!empty($missing))
$o .= '<p>'._e("The members below don't show up on the current list. Check those who should be deleted.",'rsvpmaker-for-toastmasters').'</p>'.$missing;
}
if(!empty($o))
	{
?>
<h3>Verify Member Accounts to Be Added or Removed</h3>
<form method="post" action="<?php echo admin_url('users.php?page=add_awesome_member'); ?>">
<?php
echo $o;
?>
<p><input type="checkbox" name="no_email" value="1" <?php if(isset($_POST['no_email'])) echo ' checked="checked" '; ?> /> Do not send email invites (for example, if you are still testing the site).</p> 
<input type="submit"  class="button-primary" value="<?php _e("Submit",'rsvpmaker-for-toastmasters');?>" />
</form>
<?php
	}
}
function show_confirmations()
	{
		if(empty($this->confirmations))
			return;
		else
			{
			foreach($this->confirmations as $conf)
				echo '<div class="confirmation">'.$conf.'</div>';	
			}
	}
}

function add_member_user($user, $override_check = false) {
$member_factory = new Toastmasters_Member();
if(!$override_check)
$user = $member_factory->check($user);
if(!empty($user))
	{
	$member_factory->add($user);
$member_factory->show_prompts();
$member_factory->show_confirmations();	
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
$contactmethods['education_awards'] = "Toastmasters Awards (DTM etc)";
//$contactmethods['club_member_since'] = "Joined Club";
//$contactmethods['original_join_date'] = "Joined Toastmasters";

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
			$activity_sql = "SELECT meta_value, post_id from $wpdb->postmeta JOIN $wpdb->posts ON $wpdb->postmeta.post_id = $wpdb->posts.ID WHERE meta_key='_activity' ORDER BY meta_id DESC LIMIT 0,5";
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
					//if(!isset($signup))
						//$signup = login_redirect($permalink);
					//$ev[ $row->postID ] = sprintf('<a href="%s">%s', login_redirect($permalink), $title);
					if(is_user_logged_in())
					$ev[ $row->postID ] = sprintf('<a class="meeting" href="%s">%s</a>', $permalink, $title);
					else
					{
						$ev[ $row->postID ] = sprintf('<a class="meeting" href="%s">%s</a>', $permalink, $title);
						$ev[ $row->postID ] .= sprintf('<div class="login_signup">&nbsp;&#8594; <a href="%s">%s</a>', login_redirect($permalink), __('Login/Sign Up','rsvpmaker-for-toastmasters'));	
					}
					$ev[ $row->postID ] = '<div class="meetinglinks">'.$ev[ $row->postID ].'</div>';
					}
				}
			  }// end if dates
			//pluggable function widgetlink can be overridden from custom.php
			if(isset($ev) && !empty($ev) )
			{
			
			//echo '<li class="widgetrsvpview"><a href="'.get_post_type_archive_link( 'rsvpmaker' ).'">'.__('View Upcoming Events','rsvpmaker-for-toastmasters').'</a></li>';
			
			echo '<li class="widgetsignup">'.__('Member sign up for roles','rsvpmaker-for-toastmasters').":";			
			$class = '';
			$count = 1;
			  foreach($ev as $id => $e)
			  	{
			  	printf('<div %s>%s</div>',$class, $e);
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
			$most_recent = get_rsvp_date($log[0]->post_id);
			if(strtotime($most_recent) > strtotime('-1 month'))//only show if there is recent activity
			{	
			  echo "<li><strong>".__('Activity','rsvpmaker-for-toastmasters')."</strong><br />";
			  foreach($log as $row)
			  	echo "<div>".$row->meta_value . "</div>";
			  echo "</li>";
			}
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
if(isset($_REQUEST["edit_sidebar"]))
	{
	$sidebar_editor = agenda_sidebar_editor($post->ID);
return sprintf('<form id="edit_roles_form" method="post" action="%s"">
%s<button class="save_changes">'.__("Save Changes",'rsvpmaker-for-toastmasters').'</button><input type="hidden" name="post_id" class="post_id" value="%d"><input type="hidden" id="toastcode" value="%s"></form>%s',rsvpmaker_permalink_query($post->ID),$sidebar_editor,$post->ID,wp_create_nonce( "rsvpmaker-for-toastmasters" ),$content);
	}
if(isset($_REQUEST["reorder"]))
	return '<p><em>'.__('Drag and drop to change the order in which speakers, evaluators and other roles with multiple participants will appear on the agenda').'</em></p>'.$content;
if(!isset($_REQUEST["edit_roles"]) || (!current_user_can('edit_signups') && !edit_signups_role()))
	return $content;
	
$r = 'x'.rand();
$content .= '<p><span id="time'.$r.'" class="toasttime" "></span><select class="tweakminutes" timetarget="'.$r.'" style="display:none;"><option value="0" selected="selected">0</option></select> End of meeting</p>';
	
if(current_user_can('agenda_setup'))
$content .= sprintf('<p><a href="%sedit_sidebar=1">%s</a></p>',rsvpmaker_permalink_query($post->ID),__('Edit Sidebar','rsvpmaker-for-toastmasters'));//agenda_sidebar_editor($post->ID);
	
return sprintf('<form id="edit_roles_form" method="post" action="%s"">
%s
<button class="save_changes">'.__("Save Changes",'rsvpmaker-for-toastmasters').'</button><input type="hidden" name="post_id" class="post_id" value="%d"><input type="hidden" id="editor_id" name="editor_id" value="%d" /><input type="hidden" id="toastcode" value="%s"></form> %s',rsvpmaker_permalink_query($post->ID),$content,$post->ID,$current_user->ID,wp_create_nonce( "rsvpmaker-for-toastmasters" ),time_tally_include($post->ID));
}

function time_tally_include ($post_id) {
?>
<script>
jQuery(document).ready(function($) {

var time_tally;

var agenda_add_minutes =  function (dt, minutes) {
    return new Date(dt.getTime() + minutes*60000);
}

var agenda_time_tally =  function () {
	time_tally = new Date($('#startdate<?php echo $post_id; ?>').attr('datetime'));//start time
    $('.tweakminutes').each(function(index) {
     var target = $(this).attr('timetarget');
	  	var hour = time_tally.getHours();
		var minute = time_tally.getMinutes();
		hour = (hour >= 12)? hour - 12: hour;
		if(minute < 10)
		minute = '0' + minute;
	$('#time' + target).fadeTo( "fast", 0.1 );
	$('#time' + target).html(hour + ":" + minute);
	$('#time' + target).delay(index*50).fadeTo( "fast", 1.0 );
	var tallyadd = 0;
	var addthis = Number($(this).val());
	if(!isNaN(addthis))
		tallyadd += addthis;
	addthis = Number($('#padding' + target).val());
	if(!isNaN(addthis))
		{
		tallyadd += addthis;
		}
	time_tally = agenda_add_minutes(time_tally,tallyadd);
	});
};

agenda_time_tally();
    var sum = 0;
    $('.time_count').each(function() {
        sum += Number($(this).val());
    });
$('.timeopt').hide();

$('.timecheck').on('click', function(){
	var show = $(this).attr('show');
	$('#'+show).show();
});

$('.tweakminutes').on('change', function(){
	agenda_time_tally();
});
$('.tweakpadding').on('change', function(){
	agenda_time_tally();
});
$('.tweakcount').on('change', function(){
	var prompt = $(this).attr('prompt');
	if(prompt == 'promptSpeaker')
		$('#'+prompt).html('<input type="checkbox" name="tweakevaltoo" value="1" checked="checked" /> Change Evaluator count also');
});

});
</script>	
<?php		
}


function recommend_hash($role, $user,$post_id = 0) {
global $post;
if(empty($post_id) && !empty($post->ID))
	$post_id = $post->ID;
return md5($role.$user.$post_id);
}

function accept_recommended_role() {
// key=General_Evaluator-1&you=31&code=eZHuvRnuvb^(
global $post;
if(!isset($post) || ($post->post_type != 'rsvpmaker'))
	return;
$permalink = rsvpmaker_permalink_query($post->ID);
$custom_fields = get_post_custom($post->ID);
if(isset($_REQUEST["key"]) && isset($_REQUEST["you"]) && isset($_REQUEST["code"]))
	{
		$you = (int) $_REQUEST["you"];
		$hash = recommend_hash($_REQUEST["key"], $you);
		$count = (int) $_REQUEST["count"];
		$key = preg_replace('/[0-9]/','',$_REQUEST["key"]);
		if($hash != $_REQUEST["code"])
			{
			header("Location: ".$permalink."recommendation=code_error");
			exit();
			}
		$success = false;
		for($i =1; $i <= $count; $i++)
			{
				$name = $key.$i;
				if(!empty($custom_fields[$name][0]))
					; //echo "<p>Role is taken</p>";
				else
					{
					update_post_meta($post->ID, $name, $you);
					$actiontext = __("accepted the role",'rsvpmaker-for-toastmasters').' '.clean_role($name);
					awesome_wall($comment_content, $post-ID, $you);
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
if(!isset($_REQUEST["recommend_roles"]) || !current_user_can('edit_posts') )
	return $content;
global $post;
global $current_user;
global $wpdb;
global $rsvp_options;
$output = '';

$permalink = rsvpmaker_permalink_query($post->ID);

	$date = get_rsvp_date($post->ID);

$output .= sprintf('<form id="edit_roles_form" method="post" action="%s">
%s<button class="save_changes">'.__("Save Changes",'rsvpmaker-for-toastmasters').'</button><input type="hidden" name="post_id" class="post_id" value="%d"></form>',$permalink,$content,$post->ID);

return $output;

}

function signup_sheet_editor() {
	if(!current_user_can('edit_signups'))
		die('security error');
	global $rsvp_options;
	global $post;
	global $current_user;
	$limit = get_option('tm_signup_count');
	$maxrow = 0;
	if(isset($_GET['limit']))
		{
			$limit = (int) $_GET['limit'];
			if(current_user_can('manage_options'))
				update_option('tm_signup_count',$limit);
		}
	if(empty($limit))
		$limit = 3;
	$dates = future_toastmaster_meetings($limit,0);
	$head = $cells = '';
	$datecount = 0;
	foreach($dates as $index => $date)
		{
		$guestopt = '';
		$t = strtotime($date->datetime);
		$post = get_post($date->ID);
		$head .= "<th>".$post->post_title.'<br />'.date("F j",$t)."</th>";
		$cell[$date->ID] = '';
		$data = wpt_blocks_to_data($date->post_content);
		foreach($data as $row => $item)
		{
		if(empty($item['role']))
			continue;
		$role = $item['role'];
		$count = (int) $item['count'];
		$field_base = '_'.preg_replace('/[^a-zA-Z0-9]/','_',$role);
		for($i = 1; $i <= $count; $i++)
		{
		$field = $field_base . '_' . $i;
		$assigned = get_post_meta($post->ID, $field, true);
		if(empty($assigned))
			$guestopt .= sprintf('<option value="%s">%s</option>',$field,$field);
		if(!empty($assigned) && !is_numeric($assigned))
			$show = $assigned.' (guest)';
		else
			$show = awe_user_dropdown ($field,$assigned);
		$cell[$date->ID] .= '<div><div class="role">'.$role.':</div><div>'.$show.'</div><div id="status'.$field.$post->ID.'" class="status"></div></div>';
		}
		}
		if(!empty($guestopt))
		{
			$addguest = sprintf('<div>Assign role to guest<br /><select id="addguest_role%d">%s</select><br />Name:<br /><input type="text" id="addguest_name%d" /><br /><button class="assign_to_guest" post_id="%d">Assign</button></div><div id="addguest%d"></div>',$post->ID,$guestopt,$post->ID,$post->ID,$post->ID);
			$cell[$date->ID] .= $addguest;
		}
		if(strpos($date->post_content,'wp4toastmasters/absences'))
			$cell[$date->ID] .= tm_absence(array());
		$cell[$date->ID] .= sprintf('<p><a href="%s?edit_roles=1">Edit</a></p>',get_permalink($post->ID));
		$cell[$date->ID] .= sprintf('<div id="norole%d"></div>',$date->ID);
		$norole_call[] = sprintf('norole(%d);',$date->ID);
		$datecount++;
		if($datecount == $limit)
			break;
		}

		$cells = '<tr><td>'.implode('</td><td>',$cell).'</td></tr>';
	
	$colwidth = floor(100 / $limit);
	
	echo "<html><head>
	<title>Signup Sheet Editor</title>
	<style>
	table#signup {
	width: 100%;
	}
	#signup th {
	font-size: 14px;
	font-weight: bold;
	text-align: center;
	}
	#signup td, #signup th {
	padding: 3px;
	margin: 2px;
	width: ".$colwidth."%;
	vertical-align: top;
	}
	#signup .signuprole {
	font-size: 10px;
	border: thin solid #000;
	margin-bottom: 2px;
	font-weight: bold;
	}
	#signup .assignedto {
	font-size: 14px;
	border-bottom: thin solid #000;
	padding-bottom: 10px;
	font-weight: normal;
	}
	select, option {
	max-width: 150px;
	overflow: hidden;
	}
	.role {
	font-size: small;
	}
	.status {
	color: blue;
	}
	</style>
	</head><body><table id=\"signup\"><tr>".$head."</tr>".$cells."</table>
	
	<script type='text/javascript' src='".admin_url('load-scripts.php?c=1&amp;load%5B%5D=jquery-core,jquery-migrate,utils&amp;ver=4.9.8')."'></script>
	
	<script>
jQuery(document).ready(function($) {

$('.editor_assign').on('change', function(){
	var user_id = this.value;
	var id = this.id;
	var role = $('#'+id).attr('role');
	var security = $('#toastcode').val();
	var post_id = $('#'+id).attr('post_id');
	var statusid = 'status'+role.replace(' ','')+post_id;
	$('#'+statusid).html('Saving ...');
	var editor_id = $('#editor_id').val();
	var ajaxurl = '".admin_url( 'admin-ajax.php' )."';
	//alert('user: '+user_id+' role '+role+' post id '+post_id+' status id '+statusid);
	if(security && (post_id > 0))
	{
		var data = {
			'action': 'editor_assign',
			'role': role,
			'user_id': user_id,
			'editor_id': editor_id,
			'security': security,
			'post_id': post_id
		};
		jQuery.post(ajaxurl, data, function(response) {
		$('#'+statusid).html(response);
		$('#'+statusid).fadeIn(200);
		norole(post_id);
		});
	}
});	

$('.absences').on('change', function(){
	var user_id = this.value;
	if(user_id < 1)
		return;
	var id = this.id;
	var security = $('#toastcode').val();
	var post_id = $('#'+id).attr('post_id');
	var statusid = 'status_absences'+post_id;
	$('#'+statusid).html('Saving ...');
	var editor_id = $('#editor_id').val();
	var ajaxurl = '".admin_url( 'admin-ajax.php' )."';
	if(security && (post_id > 0))
	{
		var data = {
			'action': 'editor_absences',
			'user_id': user_id,
			'editor_id': editor_id,
			'security': security,
			'post_id': post_id
		};
		jQuery.post(ajaxurl, data, function(response) {
		console.log(response);
		$('#'+statusid).html(response);
		$('#'+statusid).fadeIn(200);
		norole(post_id);
		});
	}
});	

$('.assign_to_guest').on('click', function(){
	var post_id = $(this).attr('post_id');
	var role = $('#addguest_role'+post_id).val();
	var user_id = $('#addguest_name'+post_id).val();
	var security = $('#toastcode').val();
	var statusid = 'addguest'+post_id;
	$('#'+statusid).html('Saving ...');
	var editor_id = $('#editor_id').val();
	var ajaxurl = '".admin_url( 'admin-ajax.php' )."';
	console.log(' user_id '+user_id+' role '+role+'+ post_id '+post_id);

	//alert('user: '+user_id+' role '+role+' post id '+post_id+' status id '+statusid);
	if(security && (post_id > 0))
	{
		var data = {
			'action': 'editor_assign',
			'role': role,
			'user_id': user_id,
			'editor_id': editor_id,
			'security': security,
			'post_id': post_id
		};
		jQuery.post(ajaxurl, data, function(response) {
		$('#'+statusid).html(response);
		$('#'+statusid).fadeIn(200);
		});
	}
});

$('.absences_remove').on('click', function(){
	var user_id = this.value;
	if(user_id < 1)
		return;
	var id = this.id;
	var security = $('#toastcode').val();
	var post_id = $('#'+id).attr('post_id');
	var statusid = 'current_absences'+post_id+user_id;
	$('#'+statusid).html('Saving ...');
	var editor_id = $('#editor_id').val();
	var ajaxurl = '".admin_url( 'admin-ajax.php' )."';
	if(security && (post_id > 0))
	{
		var data = {
			'action': 'absences_remove',
			'user_id': user_id,
			'editor_id': editor_id,
			'security': security,
			'post_id': post_id
		};
		jQuery.post(ajaxurl, data, function(response) {
		console.log(response);
		$('#'+statusid).html(response);
		$('#'+statusid).fadeIn(200);
		norole(post_id);
		});
	}
});	

function norole(post_id) {
	$('#norole'+post_id).html('updating list of members with no role');
	$.getJSON('/wp-json/rsvptm/v1/norole/'+post_id,function(data) {
		$('#norole'+post_id).html('<strong>Members with No Role</strong><br />'+data.join('<br />'));
    });
}
".implode("\n",$norole_call)."
});
</script>

<input id='toastcode' type='hidden' value='".wp_create_nonce( "rsvpmaker-for-toastmasters" )."' />
<input id='editor_id' type='hidden' value='".$current_user->ID."' />

<form action=\"".site_url()."\" method=\"get\" style=\"margin-top: 20px; margin-left: 10px; padding: 10px; border: thin solid #000; width: 300px;\" >
<input type=\"hidden\" name=\"signup_sheet_editor\"  value=\"1\">
Number of Meetings Shown: 
<select name=\"limit\">
<option value=\"".$limit."\">".$limit."</option>
<option value=\"2\">2</option>
<option value=\"3\">3</option>
<option value=\"4\">4</option>
<option value=\"5\">5</option>
<option value=\"6\">6</option>
</select>
<button>Get</button>
</form>

	</body></html>";
		exit();
}

function signup_sheet($atts = array()) {
	
if(isset($_GET['signup_sheet_editor']))
{
	signup_sheet_editor();
	return;
}

if(isset($_REQUEST["signup"]) || isset($_REQUEST["signup2"]) || isset($atts["limit"]))
	{
	global $wpdb;
	global $rsvp_options;
	global $post;
	if(function_exists('register_block_type'))
		register_block_type('wp4toastmasters/role', ['render_callback' => 'toastmaster_short']);	

	$limit = get_option('tm_signup_count');
	if(empty($limit))
		$limit = 3;
	$sql = "SELECT a1.meta_value as datetime
	 FROM ".$wpdb->posts."
	 JOIN ".$wpdb->postmeta." a1 ON ".$wpdb->posts.".ID =a1.post_id AND a1.meta_key='_rsvp_dates'
	 WHERE a1.meta_value > CURDATE() AND (post_status='publish' OR post_status='draft') AND (post_content LIKE '%[toastmaster%' OR post_content LIKE '%wp:wp4toastmasters%') ORDER BY a1.meta_value";
	$next = "'".$wpdb->get_var($sql)."'";
	if(isset($atts["limit"]))
	{//shortcode version
		$limit = $atts["limit"];
		$_REQUEST["signup"] = $_REQUEST["signup2"] = 1;
		$next = 'CURDATE()';
		ob_start();
	}
	$dates = get_future_events("a1.meta_value > $next AND (post_content LIKE '%[toastmaster%' OR post_content LIKE '%wp:wp4toastmasters%') ",$limit);
	$head = $cells = '';
	$datecount = 0;
	foreach($dates as $date)
		{
		$t = strtotime($date->datetime);
		$post = get_post($date->postID);
		$head .= "<th>".$post->post_title.'<br />'.date("F j",$t)."</th>";
		
		$absent_names = array();
		$absences = get_absences_array($date->postID);
		if(!empty($absences))
		{
		foreach($absences as $a)
		{
			$user = get_userdata($a);
			$absent_names[] = (!empty($user->first_name)) ? $user->first_name.' '.$user->last_name : $user->user_login;
		}
		}

		$ab = (empty($absent_names)) ? '' : '<p><strong>Planned Absences:</strong> '.implode(', ',$absent_names).'</p>';
		
		if(strpos($post->post_content,'{"role":"'))
		{
		preg_match_all('/\<.+wp4toastmasters\/role.+\>/',$post->post_content,$matches);
		$filtered = implode("\n\n",$matches[0]); // filter out all content other than role signups
		$cells .= "<td>".do_blocks($filtered).$ab."</td>";
		}
		else {
		preg_match_all('/\[toastmaster.+\]/',$post->post_content,$matches);
		$filtered = implode("\n",$matches[0]); // filter out all content other than role signups
		$cells .= "<td>".do_shortcode($filtered).$ab."</td>";			
		}
		$datecount++;
		if($datecount == $limit)
			break;
		}
	
	$colwidth = floor(100 / $limit);
	
	echo "<html><head>
	<title>Signup Sheet</title>
	<style>
	table#signup {
	width: 100%;
	}
	#signup th {
	font-size: 14px;
	font-weight: bold;
	text-align: center;
	}
	#signup td, #signup th {
	padding: 3px;
	margin: 2px;
	width: ".$colwidth."%;
	vertical-align: top;
	}
	#signup .signuprole {
	font-size: 10px;
	border: thin solid #000;
	margin-bottom: 2px;
	font-weight: bold;
	}
	#signup .assignedto {
	font-size: 14px;
	border-bottom: thin solid #000;
	padding-bottom: 10px;
	font-weight: normal;
	}
	</style>
	</head><body><table id=\"signup\"><tr>".$head."</tr><tr>".$cells."</tr></table></body></html>";
	if(isset($atts["limit"]))
	{//shortcode version
		unset($_REQUEST["signup"]);
		unset($_REQUEST["signup2"]);
		return ob_get_clean();
	}
	else
		exit();
	}

}

function upcoming_open_roles($limit = 10) {

	global $wpdb;
	global $rsvp_options;
	global $post;
		
	$openings = array();
	$dates = future_toastmaster_meetings($limit);
	$head = $cells = '';
	$datecount = 0;
	foreach($dates as $date)
		{
		$t = strtotime($date->datetime);
		//$datestr = date("F j",$t);
		preg_match_all('/\[.+role="([^"]+).+\]/',$date->post_content,$matches);
		//echo '<h3>'.$datestr.'</h3>';
		foreach($matches[1] as $index => $role)
		{
			$field_base = '_'.preg_replace('/[^a-zA-Z0-9]/','_',$role);
			if(strpos($field_base,'Backup'))
				continue;
			preg_match('/count="([\d]+)/',$matches[0][$index],$counts);
			$count = (empty($counts[1])) ? 1 : $counts[1];
			//echo '<div>Role '.$role.': '.$count.'<div>';
			for($i = 1; $i <= $count; $i++)
			{
				$field = $field_base.'_'.$i;
				$assigned = get_post_meta($date->ID,$field,true);
				if(!$assigned)
				{
					$openings[$t][] = $field;
					break;
				}
			}
		}
		}
return $openings;
}

function openings_for_date($datepost,$user_id) {
			
	$data = wpt_blocks_to_data($datepost->post_content);
	$openings = $bases = array();
	foreach($data as $row)
	{
		if(empty($row['role']))
			continue;
		$role = $row['role'];
		$field_base = '_'.preg_replace('/[^a-zA-Z0-9]/','_',$role);
		if(strpos($field_base,'Backup'))
			continue;
		$count = (int) $row['count'];
		for($i = 1; $i <= $count; $i++)
		{
			$field = $field_base.'_'.$i;
			$assigned = (int) get_post_meta($datepost->ID,$field,true);
			//printf('<p>%d %s %d</p>',$datepost->ID,$field,$assigned);
			if($assigned == $user_id)
				$openings['assigned'] = $field;
			if(!$assigned && !in_array($field_base,$bases))
			{
				$openings[] = $field;
				$bases[] = $field_base;
			}
		}
	}	
return $openings;
}

function wp_ajax_wptoast_role_planner_update () {
    $post_id = $_POST["datepost"];
    $user_id = $_POST["user_id"];
	if(!empty($_POST["takerole"]))
	{
    $role = $_POST["takerole"];
	update_post_meta($post_id,$role,$user_id);
	printf('<p>Added %s</p>',clean_role($role));
	if(strpos($role,'Speaker'))
		printf('<p><a href="%s#%s">* Add speech details</a></p>',get_permalink($post_id),$role);
	$actiontext = __("signed up for",'rsvpmaker-for-toastmasters').' '.clean_role($role);
	do_action('toastmasters_agenda_notification',$post_id,$actiontext,$user_id);
	awesome_wall($actiontext,$post_id, $user_id);		
	}
	if(!empty($_POST["was"]) && ($_POST["was"] != $_POST["takerole"])) {
		$was = $_POST["was"];
		delete_post_meta($post_id,$was);				
		printf('<p>Dropped %s</p>',clean_role($was));
		$actiontext = __("withdrawn:",'rsvpmaker-for-toastmasters').' '.clean_role($was);
		do_action('toastmasters_agenda_notification',$post_id,$actiontext,$user_id);
		awesome_wall($actiontext,$post_id, $user_id);
	}
	die();
}

add_action('wp_ajax_wptoast_role_planner_update','wp_ajax_wptoast_role_planner_update');

function toastmasters_planner () {
$hook = tm_admin_page_top(__('Multi-Meeting Role Planner','rsvpmaker-for-toastmasters'));
?>
<p>This tool allows you to see your currently assigned roles and open roles at upcoming meetings. If you do not have a role, the software will attempt to recommend one you have not filled recently. Open roles are shuffled into a random order.</p>
<p>You can change your role assignments one meeting at a time or scroll to the bottom and click Save All Updates.</p>
<?php
printf('<form method="post" action="%s">',admin_url('admin.php?page=toastmasters_planner'));
	if(isset($_REQUEST['user_id']))
		$user_id = (int) $_REQUEST['user_id'];
	else
	{
	global $current_user;
	$user_id = $current_user->ID;
	}
	if(isset($_POST['takerole']))
	{
		$userdata = get_userdata($user_id);
		foreach($_POST['takerole'] as $post_id => $role)
		{
			$t = strtotime(get_rsvp_date($post_id));
			$d = date("F j",$t);
			if(!empty($_POST['wasrole'][$post_id]))
			{
				 if($_POST['wasrole'][$post_id] == $role)
					 continue; // no change
				delete_post_meta($post_id,$_POST['wasrole'][$post_id]);				
			printf('<p>Dropped %s for %s</p>',clean_role($_POST['wasrole'][$post_id]),$d);
			add_post_meta($post_id,'_activity_editor',$userdata->display_name.' dropped '.clean_role($_POST['wasrole'][$post_id]).' for '.$d);
			$actiontext = __("withdrawn",'rsvpmaker-for-toastmasters').' '.clean_role($_POST['wasrole'][$post_id]);
			do_action('toastmasters_agenda_notification',$post_id,$actiontext,$user_id);
			}
			if(!empty($role))
			{
			update_post_meta($post_id,$role,$user_id);
			printf('<p>Added %s for %s</p>',clean_role($role),$d);
			add_post_meta($post_id,'_activity_editor',$userdata->display_name.' added '.clean_role($_POST['wasrole'][$post_id]).' for '.$d);
			if(strpos($role,'Speaker'))
				printf('<p><a href="%s">* Add speech details</a></p>',get_permalink($post_id));
			$actiontext = __("signed up for",'rsvpmaker-for-toastmasters').' '.clean_role($role);
			do_action('toastmasters_agenda_notification',$post_id,$actiontext,$user_id);
			$mdate[] = $d;
			}
		}
	
	$actiontext = '<strong>'.$userdata->display_name.':</strong> '.__("signed up for roles on",'rsvpmaker-for-toastmasters').' '.implode(', ',$mdate);
	add_post_meta($post_id, '_activity',$actiontext);
	}
	$suggested = array();
	$dates = future_toastmaster_meetings();
	foreach($dates as $date)
		{
		$permalink = get_permalink($date->ID);
		$prompt = '';
		$t = strtotime($date->datetime);
		printf('<h3><a href="%s">Agenda</a> - %s %s</h3>',$permalink,date("F j",$t),$date->post_title);
		$meeting_openings = openings_for_date($date,$user_id);
		$history = new role_history($user_id,$date->datetime);
		$recent_history = $history->recent_history;
		if(!empty($suggested))
			$recent_history = array_merge($recent_history,$suggested);
		$suggest = $olow = '';
		$dontrepeat = array();
		$o = '<option value="">None</option>';
		$picked = false;

		if(!empty($meeting_openings))
		{
		if(!empty($meeting_openings['assigned']))
		{
			$o .= sprintf('<option value="%s" selected="selected">%s (currently assigned)</option>',$meeting_openings['assigned'],$history->clean_role($meeting_openings['assigned']));
			$picked = true;
			printf('<input type="hidden" id="was%d" name="wasrole[%d]" value="%s" />',$date->ID,$date->ID,$meeting_openings['assigned']);
			if(strpos($meeting_openings['assigned'],'Speaker') && !get_post_meta($date->ID,'_project'.$meeting_openings['assigned'],true) )
				$prompt = '<p><a href="'.$permalink.'#'.$meeting_openings['assigned'].'">* Add speech project details</a></p>';
		}
		else {
			$prompt = '<span style="color: red;">Suggested role (not confirmed)</span>';
		}
		shuffle($meeting_openings);
			foreach($meeting_openings as $role)
			{
				//echo '<div>'.$role.'</div>';
				$clean_role = $history->clean_role($role);
				if(!$history->get_eligibility($clean_role))
				{
					if(in_array($clean_role,$dontrepeat))
						continue;
					$olow .= sprintf('<option value="%s">%s</option>',$role,$clean_role);					
				}
				elseif($picked || in_array($clean_role,$recent_history))
				{
					if(in_array($clean_role,$dontrepeat))
						continue;
					$o .= sprintf('<option value="%s">%s</option>',$role,$clean_role);
				}
				elseif(empty($suggest))
				{
					$suggest .= sprintf('<option value="%s" selected="selected">%s (suggested)</option>',$role,$clean_role);
					$suggested[] = $clean_role;
					//printf('<p>Suggested %s</p>',$clean_role);
					$picked = true;
				}
				else
				{
					$o.= sprintf('<option value="%s">%s</option>',$role,$clean_role);
				}
				$dontrepeat[] = $clean_role;
			}
		if(empty($suggest) && !empty($meeting_openings))
		{
			$role = array_shift($meeting_openings);
			$clean_role = $history->clean_role($role);
			$suggest .= sprintf('<option value="%s" selected="selected">%s (suggested)</option>',$role,$clean_role);
			$suggested[] = $clean_role;
			//printf('<p>Suggested %s</p>',$clean_role);
			$picked = true;
		}
		if(!empty($suggest) || !empty($olow) || $picked)
		printf('<p>%s <select id="takerole%d" name="takerole[%d]">%s</select> <button class="roleplanupdate" datepost="%d">%s</button></p>',__('Choices','rsvpmaker-for_toastmasters'),$date->ID,$date->ID,$suggest.$o.$olow,$date->ID,__('Update','rsvpmaker-for_toastmasters'));
		echo '<div id="change'.$date->ID.'">'.$prompt.'</div>';
		}

		}
submit_button('Save All Updates');
printf('<input type="hidden" id="user_id" name="user_id" value="%d" /></form>',$user_id);
tm_admin_page_bottom($hook);
}


function awesome_open_roles($post_id = NULL,$scheduled = false) {

if(!is_club_member())
	return;

if(!isset($_REQUEST["open_roles"]) && !$post_id)
	return;
if(function_exists('email_content_minfilters'))
	email_content_minfilters();
else {
	global $wp_filter;
	$corefilters = array('convert_chars','wpautop','wptexturize');
	foreach($wp_filter["the_content"] as $priority => $filters)
		foreach($filters as $name => $details)
			{
			//keep only core text processing or shortcode
			if(!in_array($name,$corefilters) && !strpos($name,'hortcode'))
				remove_filter( 'the_content', $name, $priority );
			}	
}
global $post;
the_post();
$content = tm_agenda_content();
$content = apply_filters('email_agenda',$content);
	
	global $wpdb;
	global $rsvp_options;
	global $current_user;
	global $open;
	if(!$post_id)
		$post_id = (int) $_REQUEST["open_roles"];
	$permalink = rsvpmaker_permalink_query($post_id);
	$row = get_rsvp_event(" ID = $post_id ");
	//year not necessary in this context
	$dateformat = str_replace(', ','',str_replace('%Y','',$rsvp_options["long_date"]));

	if(get_option('wp4toastmasters_agenda_timezone'))
		$time_format = $dateformat .' at '.$rsvp_options["time_format"];
	else
		$time_format = $dateformat;
	fix_timezone();
	$date = strftime($time_format, strtotime($row->datetime) );
	
	$header = '<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
'.wpt_default_agenda_css()."\n".get_option('wp4toastmasters_agenda_css').'
#message p, #message li {
font-size: 16px;
}
</style>
</head>
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
	if(!empty($_POST["test"]) && !empty($_POST["testto"]))
		$mail["to"] = $_POST["testto"];
	elseif(!empty($wp4toastmasters_mailman["members"]))
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
		$output = '<div id="message">'.stripslashes($_POST["note"])."</div>\n<p>Sent by: ".$current_user->display_name.' <a href="mailto:'.$current_user->user_email.'">'.$current_user->user_email."</a>\n".$output;		
	$mail["html"] = $header. $output . '</body></html>';
	$mail["from"] = $current_user->user_email;
	$mail["fromname"] = get_bloginfo('name') . ' / '.$current_user->display_name;
	$mail["subject"] = stripslashes($_POST["subject"]);
	if(isset($emails) && is_array($emails))
	{
		foreach($emails as $e)
		{
		$mail["to"] = $e;
		echo awemailer($mail);
		}
	}
	else
	{
		echo awemailer($mail);
		
	}
	//output without form
	$output = $header. $output . '</body></html>';
	}
	elseif(!$scheduled)
	{
	$subject = __("Agenda for",'rsvpmaker-for-toastmasters').' '.$date;
	if($openings)
		$subject .= " (".$openings." ".__("open roles",'rsvpmaker-for-toastmasters').")";
	if(empty($wp4toastmasters_mailman["members"]))
		$subject = get_bloginfo('name').' '.$subject;
	$mailform = '<script src="//cdn.tinymce.com/4/tinymce.min.js"></script> 
	<script>
			tinymce.init({selector:"textarea",plugins: "code,link"});		
	</script><h3>'.__("Add a Note",'rsvpmaker-for-toastmasters').'</h3>
	<p>'.__("Your note will be emailed along with the agenda and details about which roles are filled or open. You can change the subject line to emphasize the roles you need filled or special plans for a meeting (such as a contest).",'rsvpmaker-for-toastmasters').'</p>
	<form method="post" action="'.$permalink.'email_agenda=1">
Subject: <input type="text" name="subject" value="'.$subject.'" size="60"><br />
<textarea name="note" rows="5" cols="80"></textarea><br />
<input type="radio" name="test" value="0" checked="checked" > '.__('Send to all members','rsvpmaker-for-toastmasters').' <input type="radio" name="test" value="1" > '.__('Send test to','rsvpmaker-for-toastmasters').': <input type="text" name="testto" /><br />
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
	if(!isset($_REQUEST["print_contacts"]) )
		return;
	if(!is_club_member() || !current_user_can('view_contact_info') )
		die("You must log in first");
	echo '<html><body>';
	}

member_list();

if(isset($_REQUEST["print_contacts"]) )
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
<?php
if(current_user_can('manage_network'))
{
?>
<p><input type="checkbox" name="hidden_profile" id="hidden_profile" value="yes" <?php if( get_the_author_meta( 'hidden_profile', $user->ID ) ) echo ' checked="checked" '; ?> />
<span class="description"><?php _e("Check to HIDE profile from member listings. Use to hide accounts used for administration that do not represent member accounts.",'rsvpmaker-for-toastmasters');?></span></p>
<?php
}
?>
</td>
</tr>
<tr>
<th><label for="public_profile"><?php _e("Email Notifications",'rsvpmaker-for-toastmasters');?></label></th>
<td>
<?php

if(isset($_GET['debug']) && current_user_can('manage_options'))
{
	$data = get_userdata($user->ID);
	echo '<pre>';
	print_r($data);
	echo '</pre>';
}

$e = strtolower($user->user_email);
$unsub = get_option('rsvpmail_unsubscribed');
if(empty($unsub))
	$unsub = array();
if(isset($_GET['resubcribe']))
{
	$key = array_search($e, $unsub);
	if($key !== false)
	{
		echo __('Removing block on','rsvpmaker-for-toastmasters').' '.$e;
		unset($unsub[$key]);
		update_option('rsvpmail_unsubscribed',$unsub);
		$chimp_options = get_option('chimp');
		if(!empty($chimp_options) && !empty($chimp_options["chimp-key"]))
		{
		echo ' - '.__('Does not change unsubscribed status on MailChimp.','rsvpmaker-for-toastmasters');
		}
	}
}
elseif(in_array($e,$unsub))
{
	printf('%s %s (<a href="%s">%s</a>)',__('Notifications are BLOCKED for','rsvpmaker-for-toastmasters'),$e,admin_url('user-edit.php?user_id='.$user->ID.'&resubcribe='.$e),__('remove block'));	
}
else
	printf('%s %s (<a href="%s">%s</a>)',__('Notifications are being sent to','rsvpmaker-for-toastmasters'),$e,site_url('?rsvpmail_unsubscribe='.$e),__('block / unsubscribe'));
?>
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

if(!isset($_REQUEST["intros"]) && !$agenda)
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
	if(isset($_REQUEST["intros"]) && is_numeric($_REQUEST["intros"]))
		$event = (int) $_REQUEST["intros"];
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
global $wpdb;
$sql = "SELECT * FROM `".$wpdb->prefix."postmeta` JOIN ".$wpdb->prefix."rsvp_dates ON ".$wpdb->prefix."rsvp_dates.postID = ".$wpdb->prefix."postmeta.post_id WHERE `meta_key` LIKE '%1' OR  `meta_key` LIKE '%2' OR  `meta_key` LIKE '%3' AND ( (meta_key IS NOT NULL) AND (meta_value IS NOT NULL) AND (datetime > DATE_SUB('".get_sql_now()."', INTERVAL 3 MONTH)) AND (datetime < '".get_sql_now()."') )";
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

add_action('wp_ajax_wpt_reorder','ajax_reorder');

function ajax_reorder() {
	$post_id = $_POST["post_id"];
	if(!$post_id)
		die('Post ID not set');
	$nonce = $_POST["reorder_nonce"];
	//if(!wp_verify_nonce( $nonce, "reorder" ))
		//die('nonce security error');
	$test = '';
	//test nonce
	foreach($_POST as $name => $value)
	{
		if(is_array($value))
		{
			if($name == '_Speaker')
			{
				//print_r($value);
				$neworder = array();
				foreach($value as $assigned)
					{
						$neworder[] = get_speaker_array($assigned, $post_id);
					}
				foreach($neworder as $index => $speaker)
					{
					save_speaker_array($speaker, $index + 1, $post_id);
					$assigned = $speaker["ID"];
					if(empty($assigned))
						$assigned = '?';
					elseif(is_numeric($assigned))
						{
						$assigned_member = get_userdata($assigned);
						$assignee = $assigned_member->first_name.' '.$assigned_member->last_name;
						}
					else
						$assignee = $assigned;
					$test .= ', ' .($index+1).': '.$assignee;
					}
			}
			else
			{
			foreach($value as $index => $assigned)
				{
				if(empty($assigned))
					$assigned = '?';
				elseif(is_numeric($assigned))
					{
					$assigned_member = get_userdata($assigned);
					$assignee = $assigned_member->first_name.' '.$assigned_member->last_name;
					}
				else
					$assignee = $assigned;
				update_post_meta($post_id, $name.'_'.($index+1), $assigned);
				$test .= ', ' .($index+1).': '.$assignee;
				}
			}
		}
	}
	die('Saved. <a href="'.get_permalink($post_id).'">Verify updated order</a>'.$test );
}

function get_speaker_array($assigned, $post_id=0, $backup=false) {
	global $speaker_arrays;
	$key = $assigned.':'.$post_id;
	if(!empty($speaker_arrays[$key]))
		return $speaker_arrays[$key];		
if(empty($assigned))
	return array("ID" => 0, "manual" => '', "project" => '', "maxtime" => '', "display_time"=> '', "title" => '', "intro" => '');
global $wpdb;
if(!$post_id)
	{
	global $post;
	$post_id = $post->ID;
	}
if($backup)
	$field = '_Backup_Speaker_1';
elseif(!is_numeric($assigned)) //guest speaker
	return array('ID' => '','manual' => '','project' => '', 'maxtime' => 0, 'display_time' => '', 'title' => '', 'intro' => '');
else
	$field = $wpdb->get_var("SELECT meta_key from $wpdb->postmeta WHERE post_id=$post_id AND meta_key LIKE '%Speaker%' AND meta_value='".$assigned."' ");
	$speaker_arrays[$key] = get_speaker_array_by_field($field,$assigned,$post_id);
return $speaker_arrays[$key];
}

function get_speaker_array_by_field($field,$assigned,$post_id=0) {
if(!$post_id)
{
	global $post;
	$post_id = $post->ID;
}
$speaker["ID"] = $assigned;
$speaker["manual"] = get_post_meta($post_id, '_manual'.$field, true);
$speaker["project"] = get_post_meta($post_id, '_project'.$field, true);
$speaker["maxtime"] = get_post_meta($post_id, '_maxtime'.$field, true);
$speaker["display_time"] = get_post_meta($post_id, '_display_time'.$field, true);
$speaker["title"] = get_post_meta($post_id, '_title'.$field, true);
$speaker["intro"] = get_post_meta($post_id, '_intro'.$field, true);

if(empty($speaker["manual"]))
	$speaker["manual"] = "COMPETENT COMMUNICATION";
if(empty($speaker["maxtime"]))
	$speaker["maxtime"] = 7;	
return apply_filters('get_speaker_array',$speaker,$field,$post_id);
}

function save_speaker_array($speaker, $count, $post_id=0) {
$field = '_Speaker_' . $count;
if(!$post_id)
	{
	global $post;
	$post_id = $post->ID;
	}
update_post_meta($post_id, $field, $speaker["ID"]);
foreach($speaker as $name => $value)
	{
	if($name =='ID')
		continue;
	update_post_meta($post_id, '_'.$name.$field, strip_tags($value,'<p><br><strong><em><a>'));
	}
}

function pack_speakers($count)
{
global $post;

	for($i = 1; $i <= $count; $i++)
		{
		
		$field = '_Speaker_' . $i;
		$assigned = get_post_meta($post->ID, $field, true);
		if(empty($assigned))
			{
			// fill the first open speaker slot with backup speaker, if any
			$backup = (int) get_post_meta($post->ID, '_Backup_Speaker_1', true);
			if($backup > 0)
				{
				$speaker = get_speaker_array($backup,$post->ID,true);
				save_speaker_array($speaker,$i,$post->ID);
				delete_post_meta($post->ID,'_Backup_Speaker_1');
				delete_post_meta($post->ID,'_manual_Backup_Speaker_1');
				delete_post_meta($post->ID,'_project_Backup_Speaker_1');
				delete_post_meta($post->ID,'_maxtime_Backup_Speaker_1');
				delete_post_meta($post->ID,'_display_time_Backup_Speaker_1');
				delete_post_meta($post->ID,'_title_Backup_Speaker_1');
				delete_post_meta($post->ID,'_intro_Backup_Speaker_1');			
				backup_speaker_notify($backup);
				}
			return;
			}
		}
}//end pack speakers

function pack_roles($count,$fieldbase)
{
global $post;
	for($i = 1; $i <= $count; $i++)
		{
		
		$field = '_'.$fieldbase.'_' . $i;
		$assigned = get_post_meta($post->ID, $field, true);
		if(empty($assigned))
			{
				$backupfield = '_Backup_'.$fieldbase.'_1';
				$backup = (int) get_post_meta($post->ID,$backupfield, true);
				if($backup > 0)
					{
					update_post_meta($post->ID,$field,$backup);
					delete_post_meta($post->ID,$backupfield);
					}
			return;
			}
		}
}//end pack evaluators

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
		$url = rsvpmaker_permalink_query($post->ID);
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
		$result = awemailer($mail); // notify speaker
	
		$footer = "\n\nThis is an automated message. Replies will be sent to ".$speakerdata->user_email;
		$mail["html"] = "<html>\n<body>\n".wpautop($message.$footer)."\n</body></html>";
		$mail["replyto"] = $speakerdata->user_email;
		$mail["to"] = $leader_email;
		$mail["from"] = $speakerdata->user_email;
		$mail["fromname"] = $speakerdata->display_name;
		$result = awemailer($mail); // notify leader
}

function awemailer($mail) {
	
	global $rsvp_options;
	
	if(strpos($mail["to"],'example.com'))
		return;
	
	if(get_option('wp4toastmasters_disable_email'))
		{
			return false;
		}

	$result = rsvpmailer($mail);
	//rsvpmaker_debug_log($mail,'Toastmasters notification');	
	//rsvpmaker_debug_log($result,'Toastmasters notification result');	
	return $result;
}

if(!function_exists('rsvpmaker_print_redirect'))
{
add_action("template_redirect", 'rsvpmaker_print_redirect');

function rsvpmaker_print_redirect()
{
global $post;

		if (isset($_REQUEST["tm_reports"]))
		{
			include(WP_PLUGIN_DIR . '/rsvpmaker-for-toastmasters/reports-fullscreen.php');
			die();
		}
		elseif(isset($_REQUEST["timer"]))
		{
			include(WP_PLUGIN_DIR . '/rsvpmaker-for-toastmasters/timer.php');
			die();
		}
		elseif(isset($_REQUEST["jitsi"]))
		{
			include(WP_PLUGIN_DIR . '/rsvpmaker-for-toastmasters/jitsi.php');
			die();
		}
		elseif(isset($_REQUEST["zoom"]))
		{
			include(WP_PLUGIN_DIR . '/rsvpmaker-for-toastmasters/zoom.php');
			die();
		}
		elseif(isset($_REQUEST["scoring"]))
		{
			include(WP_PLUGIN_DIR . '/rsvpmaker-for-toastmasters/scoring.php');
			die();
		}

if(!(isset($post)) || $post->post_type != 'rsvpmaker')
	return;	
	
		if (isset($_REQUEST["print_agenda"]))
		{
			$format = get_option('wp4toastmasters_agenda_layout');
			if(get_option('wp4toastmasters_stoplight'))
				add_filter('agenda_time_display','display_time_stoplight');
			if($format == 'sidebar')
				include(WP_PLUGIN_DIR . '/rsvpmaker-for-toastmasters/agenda-with-sidebar.php');
			elseif($format == 'custom')
				include(WP_PLUGIN_DIR . '/rsvpmaker-for-toastmasters/agenda-custom.php');
			else
				include(WP_PLUGIN_DIR . '/rsvpmaker-for-toastmasters/agenda.php');
			die();
		}
		elseif (is_email_context())
		{
			if(get_option('wp4toastmasters_stoplight'))
				add_filter('agenda_time_display','display_time_stoplight');
			include(WP_PLUGIN_DIR . '/rsvpmaker-for-toastmasters/email_agenda.php');
			die();
		}
		elseif(isset($_REQUEST["intros"]))
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
update_post_meta($post_id,'_tm_sidebar',$sidebar);
update_post_meta($post_id,'_sidebar_officers',$sidebar_officers);
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

if(is_club_member() && isset($_REQUEST["edit_roles"]))
{
?>
                    <div id="themewords">
                    <h3><?php _e("Theme/Words",'rsvpmaker-for-toastmasters');?></h3>
                    <textarea name="themewords" rows="5" cols="80" class="mce"><?php  
										
					echo wpautop(get_post_meta($post->ID,'_themewords',true)); ?> </textarea>
                    </div>
<?php
}
elseif(isset($_REQUEST["print_agenda"]))
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
if($db_version < 5)
	toast_activate($db_version);

$blogusers = get_users('blog_id='.get_current_blog_id());
    foreach ($blogusers as $user) {
	$meta = get_user_meta( $user->ID );
	// Filter out empty meta data
	$meta = array_filter( array_map( function( $a ) { return $a[0]; }, $meta ) );
	$userdata = array_merge(array('ID' => $user->ID, 'user_login' => $user->user_login, 'user_email' => $user->user_email), $meta);
	$index = (isset($userdata["last_name"])) ? $userdata["last_name"].$userdata["first_name"] : $user->user_login;
	$index = preg_replace('/[^A-Za-z]/','',$index);
	$id = $wpdb->get_var("SELECT id FROM ".$wpdb->prefix."users_archive WHERE user_id=".$user->ID);
	if(!$id)
		$id = $wpdb->get_var("SELECT id FROM ".$wpdb->prefix."users_archive WHERE sort='".$index."' AND email='".$user->user_email."'");
	if(!$id && isset($meta["toastmasters_id"]))
		$id = $wpdb->get_var("SELECT id FROM ".$wpdb->prefix."users_archive WHERE toastmasters_id='".$meta["toastmasters_id"]."'");
	if($id)
		{
		$wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."users_archive SET data=%s, sort=%s, email=%s, user_id=%d WHERE id=%d", serialize($userdata),$index,$user->user_email, $user->ID, $id));
		}
	else
		{
		$id = $wpdb->query($wpdb->prepare("INSERT INTO ".$wpdb->prefix."users_archive SET data=%s, sort=%s, user_id=%d, email=%s", serialize($userdata),$index, $user->ID, $user->user_email));
		}
	if(isset($meta["toastmasters_id"]) && $meta["toastmasters_id"])
		{
		$toastmasters_id = (int) $meta["toastmasters_id"];
		$sql = "UPDATE ".$wpdb->prefix."users_archive SET toastmasters_id=".$toastmasters_id." WHERE id=".$id;
		$wpdb->query($sql);
		}
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

//want this to run ASAP, even before init
add_action('plugins_loaded','add_awesome_roles');

function add_awesome_roles() {
$manager = get_role('manager');
/*
if($manager)
	fix_user_levels_manager ();
else
*/

if(!$manager)
	add_role( 'manager', 'Manager', array( 'delete_others_pages' => true,
'read' => true,
'upload_files' => true,
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
'read_private_pages' => true,
'read_private_posts' => true,
 'delete_others_rsvpmakers' => true,
 'delete_rsvpmakers' => true,
'delete_others_pages' => true,
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
}

function manager_author_editor () {
	$users = get_users([ 'role__in' => [ 'manager' ], 'role__not_in' => [ 'editor' ], 'blog_id' => get_current_blog_id() ]);
	foreach ($users as $user) {
		$user->add_role('editor'); //set_role('manager');
	}
}
add_action('admin_init','manager_author_editor');

add_filter('wp_dropdown_users_args','manager_fix_authors_dropdown');

function awesome_role_activation_wrapper() {

	global $current_user;
	
   register_activation_hook( __FILE__, 'add_awesome_roles' );
   if(isset($_REQUEST["add_awesome_roles"]))
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

function jstest() {
	global $post;
	if( (isset($post->post_content) && is_wp4t() ) || (isset($_REQUEST["page"]) && (($_REQUEST["page"] == 'toastmasters_reconcile') || ($_REQUEST["page"] == 'my_progress_report') || ($_REQUEST["page"] == 'wp4t_evaluations') || ($_REQUEST["page"] == 'toastmasters_reports') )  ) )
		return 'js yes';
	else
		return 'jsno';
}

function toastmasters_css_js() {
	global $post;
	if(isset($_GET['action']) || (is_admin() && !isset($_GET['page'])) )
		return; // don't load all this in editor or post listings
	if( (isset($post->post_content) && is_wp4t() ) || (isset($_REQUEST["page"]) && (($_REQUEST["page"] == 'toastmasters_reconcile') || ($_REQUEST["page"] == 'my_progress_report') || ($_REQUEST["page"] == 'wp4t_evaluations') || ($_REQUEST["page"] == 'toastmasters_reports') )  ) )
	{
	wp_enqueue_style( 'jquery' );
	wp_enqueue_style( 'jquery-ui-core' );
	wp_enqueue_style( 'jquery-ui-sortable' );
	wp_register_script('script-toastmasters', plugins_url('rsvpmaker-for-toastmasters/toastmasters.js'), array('jquery','jquery-ui-core','jquery-ui-sortable'), '2.7.5');
	wp_enqueue_script( 'script-toastmasters');
	$manuals = get_manuals_options();
	wp_localize_script( 'script-toastmasters', 'manuals_list', $manuals );
	$projects = get_projects_array('options');
	wp_localize_script( 'script-toastmasters', 'project_list', $projects );
	$times = get_projects_array('times');
	wp_localize_script( 'script-toastmasters', 'project_times', $times );
	$display_times = get_projects_array('display_times');
	wp_localize_script( 'script-toastmasters', 'display_times', $display_times );
	wp_localize_script( 'script-toastmasters', 'ajaxurl', admin_url('admin-ajax.php') );
	wp_enqueue_style( 'style-toastmasters', plugins_url('rsvpmaker-for-toastmasters/toastmasters.css'), array(), '2.6.3' );
	}
}

function wp4t_assigned_open () {
	global $post;
	$roster = '';
	$signup = get_post_custom($post->ID);

$data = wpt_blocks_to_data($post->post_content);
foreach($data as $d)
{
	if(!empty($d['role']))
	{
		$role = $d['role'];
		$count = (empty($d['count'])) ? 1 : (int) $d['count'];
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
	$absences = get_absences_array($post->ID);
	$has_assignment = array_merge($has_assignment,$absences);
	
if(!empty($absences))
{
	foreach($absences as $a)
	{
		$user = get_userdata($a);
		$absent_names[] = (!empty($user->first_name)) ? $user->first_name.' '.$user->last_name : $user->user_login;
	}
}

if(!empty($absent_names))
	$roster .= '<p><strong>Planned Absences:</strong> '.implode(', ',$absent_names).'</p>';
$roster .= wp4_email_contacts($has_assignment);

$roster = wpautop($roster);
if(isset($_REQUEST["email_me"]))
	{
	global $current_user;
	wp_mail($current_user->user_email,__('Meeting Roster','rsvpmaker-for-toastmasters'),$roster,array('Content-Type: text/html; charset=UTF-8'));
	}
return $roster;
}

function get_absences_array($post_id) {
	global $post;
	$absences = get_post_meta($post_id,'tm_absence');
	if(empty($absences))
		$absences = array();
	
		$time = strtotime(get_rsvp_date($post_id));
		$away = '';
		$blogusers = get_users( 'blog_id='.get_current_blog_id() );
		// Array of WP_User objects.
		foreach ( $blogusers as $user ) {
			$exp = get_user_meta($user->ID,'status_expires',true);
			if(empty($exp))
				continue;
			if($exp > $time)
			{
			$absences[] = $user->ID;
			}
		}
	return array_unique($absences);
}

function wp4_email_contacts( $has_assignment = array() ) {

$output = '';
if(!empty($has_assignment))
	$output .= '<h2>'.__('List of Members Without an Assignment','rsvpmaker-for-toastmasters')."</h2>\n\n";

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
$sql = "SELECT ID FROM `$wpdb->posts` WHERE (post_content LIKE '%[toastmaster%' OR post_content LIKE '%wp:wp4toastmasters%') AND post_status='publish' ORDER BY `ID` DESC ";
if($wpdb->get_var($sql))
	return;

if(function_exists('do_blocks'))
	$default = '<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"2","uid":"note1534624962895"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Sgt. at Arms opens the Meeting</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"3","uid":"note1534625016726"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">President leads the <strong><em>Self Introductions</em></strong>.Then introduces the Toastmaster of the Day.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/role {"role":"Toastmaster of the Day","count":"1","agenda_note":"Introduces supporting roles. Leads the meeting.","time_allowed":"3","padding_time":"0"} /-->

<!-- wp:wp4toastmasters/role {"role":"Ah Counter","count":"1","time_allowed":"0","padding_time":"0"} /-->

<!-- wp:wp4toastmasters/role {"role":"Timer","count":"1","time_allowed":"0","padding_time":"0"} /-->

<!-- wp:wp4toastmasters/role {"role":"Vote Counter","count":"1","time_allowed":"0","padding_time":"0"} /-->

<!-- wp:wp4toastmasters/role {"role":"Grammarian","count":"1","agenda_note":"Leads word of the day contest.","time_allowed":"0","padding_time":"0"} /-->

<!-- wp:wp4toastmasters/role {"role":"Topics Master","count":"1","time_allowed":"10","padding_time":"0"} /-->

<!-- wp:wp4toastmasters/role {"role":"Speaker","count":"3","time_allowed":"24","padding_time":"1","backup":"1"} /-->

<!-- wp:wp4toastmasters/role {"role":"General Evaluator","count":"1","agenda_note":"Explains the importance of evaluations. Introduces Evaluators.","time_allowed":"1","padding_time":"0"} /-->

<!-- wp:wp4toastmasters/role {"role":"Evaluator","count":"3","time_allowed":"9","padding_time":"0"} /-->

<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"5","uid":"note31972"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">General Evaluator asks for reports from the Grammarian, Ah Counter, and Body Language Monitor. General Evaluator gives an overall assessment of the meeting.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"3","uid":"note21837"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Toastmaster of the Day presents the awards.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"2","uid":"note30722"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">President wraps up the meeting.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/agendaedit {"editable":"Theme"} /-->

<!-- wp:wp4toastmasters/absences /-->';

else
	$default = '[agenda_note padding_time="0"  agenda_display="agenda" strong="" italic="" size="" style="" alink="" editable="" time_allowed="1"]Sgt of Arms opens the meeting.[/agenda_note]

[agenda_note padding_time="0"  agenda_display="agenda" strong="" italic="" size="" style="" alink="" editable="" time_allowed="1"]President or Presiding Officer introduces the Toastmaster of the Day[/agenda_note]

[toastmaster role="Toastmaster of the Day" count="1" agenda_note="Introduces supporting roles. Leads the meeting." time="" time_allowed="3" padding_time="0" ]

[toastmaster role="Ah Counter" count="1" indent="1" agenda_note="" time="" time_allowed="0" padding_time="0" ]

[toastmaster role="Timer" count="1" indent="1" agenda_note="" time="" time_allowed="0" padding_time="0" ]

[toastmaster role="Vote Counter" count="1" indent="1" agenda_note="" time="" time_allowed="0" padding_time="0" ]

[toastmaster role="Grammarian" count="1" indent="1" agenda_note="Leads word of the day contest." time="" time_allowed="0" padding_time="0" ]

[toastmaster role="Topics Master" count="1" agenda_note="" time="" time_allowed="10" padding_time="0" ]

[toastmaster role="Speaker" count="3" agenda_note="" time_allowed="24" padding_time="1" indent="0"]

[toastmaster role="Backup Speaker" count="1" agenda_note="" time="" time_allowed="0" padding_time="0" ]

[toastmaster role="General Evaluator" count="1" agenda_note="Explains the importance of evaluations. Introduces Evaluators." indent="0" time_allowed="1" padding_time="0" ]

[toastmaster role="Evaluator" count="3" agenda_note="" time_allowed="9" padding_time="0" indent="0"]

[agenda_note time_allowed="5"  padding_time="0"  agenda_display="agenda" style="" ]General Evaluator asks for reports from the Grammarian, Ah Counter, and Body Language Monitor. General Evaluator gives an overall assessment of the meeting.[/agenda_note]

[agenda_note padding_time="0" agenda_display="agenda" style="" time_allowed="3" ]Toastmaster of the Day presents the awards.[/agenda_note]

[agenda_note padding_time="0" agenda_display="agenda" style="" time_allowed="2" ]President wraps up the meeting.[/agenda_note]

[agenda_note agenda_display="both" strong="" italic="" size="" style="" alink="" editable="Theme" time_allowed="0"][/agenda_note]
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
	if(isset($_POST['sked']))
		{
		$template = $_POST['sked'];
		if(isset($_POST['hour']))
			$template["hour"]= $_POST['hour'];
		if(isset($_POST['minutes']))
			$template["minutes"] = $_POST['minutes'];
		}
	else
	{
	$template["hour"]= 19;
	$template["minutes"] = '00';
	$template["week"] = 0;		
	}

	update_post_meta($templateID, '_sked', $template);
	update_option('default_toastmasters_template',$templateID);
	update_option('toastmasters_meeting_template',$templateID);
	update_option('wp4toastmasters_agenda_layout','custom');
	update_post_meta($templateID,'_tm_sidebar', '<strong>Club Mission:</strong> We provide a supportive and positive learning experience in which members are empowered to develop communication and leadership skills, resulting in greater self-confidence and personal growth.');
	update_post_meta($templateID,'_sidebar_officers', 1);
	update_option('default_toastmasters_template',$templateID);

if(function_exists('do_blocks'))
	$default = '<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"0","uid":"note5474"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Sgt. at Arms calls the meeting to the order.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:image {"id":21,"className":"hideonagenda"} -->
<figure class="wp-block-image hideonagenda"><img src="http://localhost/beta/wp-content/uploads/2018/08/2018_08_08_21_28_11.pdf000.jpg" alt="" class="wp-image-21"/></figure>
<!-- /wp:image -->

<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"0","uid":"note9971"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">President or Presiding Officer introduces the Contest Master.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/role {"role":"Contest Master","count":"1","agenda_note":"Introduces supporting roles. Leads the meeting.","time_allowed":"0","padding_time":"0"} /-->

<!-- wp:wp4toastmasters/role {"role":"Chief Judge","count":"1","time_allowed":"0","padding_time":"0"} /-->

<!-- wp:wp4toastmasters/role {"role":"Timer","count":"1","time_allowed":"0","padding_time":"0"} /-->

<!-- wp:wp4toastmasters/role {"role":"Vote Counter","count":"1","time_allowed":"0","padding_time":"0"} /-->

<!-- wp:wp4toastmasters/role {"role":"Videographer","count":"1","time_allowed":"0","padding_time":"0"} /-->

<!-- wp:wp4toastmasters/role {"role":"International Speech Contestant","count":"6","time_allowed":"0","padding_time":"0"} /-->

<!-- wp:wp4toastmasters/role {"role":"Table Topics Contestant","count":"6","time_allowed":"0","padding_time":"0"} /-->

<!-- wp:wp4toastmasters/role {"role":"Humorous Speech Contestant","count":"6","time_allowed":"0","padding_time":"0"} /-->

<!-- wp:wp4toastmasters/role {"role":"Evaluation Contest Contestant","count":"6","time_allowed":"0","padding_time":"0"} /-->

<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"0","uid":"note20400"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Contest Master opens the awards ceremony.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"0","uid":"note15913"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Chief Judge announces the winners.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->

<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"0","uid":"note9646"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">Announcements and conclusion.</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->';
else
	$default = '[agenda_note agenda_display="agenda" strong="" italic="" size="" style="" alink="" editable="" time_allowed="0"]Sgt. at Arms calls the meeting to the order.[/agenda_note]

[agenda_note agenda_display="agenda" strong="" italic="" size="" style="" alink="" editable="" time_allowed="0"]President or Presiding Officer introduces the Contest Master.[/agenda_note]

[toastmaster role="Contest Master" count="1" agenda_note="Introduces supporting roles. Leads the meeting." time_allowed="0" padding_time="0" indent="0"]

[toastmaster role="Chief Judge" count="1" agenda_note="" time_allowed="0" padding_time="0" indent="0"]

[toastmaster role="Timer" count="1" agenda_note="" time_allowed="0" padding_time="0" indent="0"]

[toastmaster role="Vote Counter" count="1" agenda_note="" time_allowed="0" padding_time="0" indent="0"]

[toastmaster role="Videographer" count="1" agenda_note="" time_allowed="0" padding_time="0" indent="0"]

[toastmaster role="International Speech Contestant" count="6" agenda_note="" time_allowed="0" padding_time="0" indent="0"]

[toastmaster role="Table Topics Contestant" count="6" agenda_note="" time_allowed="0" padding_time="0" indent="0"]

[toastmaster role="Humorous Speech Contestant" count="6" agenda_note="" time_allowed="0" padding_time="0" indent="0"]

[toastmaster role="Evaluation Contest Contestant" count="6" agenda_note="" time_allowed="0" padding_time="0" indent="0"]

[agenda_note agenda_display="agenda" strong="" italic="" size="" style="" alink="" editable="" time_allowed="0"]Contest Master opens the awards ceremony.[/agenda_note]

[agenda_note agenda_display="agenda" strong="" italic="" size="" style="" alink="" editable="" time_allowed="0"]Chief Judge announces the winners.[/agenda_note]

[agenda_note agenda_display="agenda" strong="" italic="" size="" style="" alink="" editable="" time_allowed="0"]Announcements and conclusion.[/agenda_note]
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

function toast_activate($db_version) {

global $wpdb;
$wpdb->show_errors();

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

if($db_version && ($db_version < 4))
	{
		$wpdb->query('ALTER TABLE `'.$wpdb->prefix.'users_archive` DROP PRIMARY KEY');
		$wpdb->query('ALTER TABLE `'.$wpdb->prefix.'users_archive` ADD `id` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`id`)');
	}

$sql = "CREATE TABLE `".$wpdb->prefix."users_archive` (
  	`id` int(11) NOT NULL AUTO_INCREMENT,
	  `sort` varchar(255) NOT NULL,
	  `data` text NOT NULL,
	  `user_id` int(11) NOT NULL DEFAULT '0',
	  `toastmasters_id` int(11) NOT NULL DEFAULT '0',
	  `guest` tinyint(4) NOT NULL,
	  `email` varchar(255) NOT NULL,
	  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
dbDelta($sql);

//establish custom roles
tm_security_setup();
update_option('rsvptoast_db','5');

}

function check_first_login () {
$first = get_option('first_tm_login');
if($first)
	return;
update_option('first_tm_login',current_time('timestamp') );
$db_version = (int) get_option('rsvptoast_db');
toast_activate($db_version); // in case this didn't run on plugin activation (multisite)
}

function archive_users_init () {
// if a logged in user access the users list, back up users
if(!strpos($_SERVER['REQUEST_URI'],'user') )
	return;
	user_archive();
}

register_activation_hook( __FILE__, 'toast_activate' );

function toolbar_link_to_agenda( $wp_admin_bar ) {
global $post;
if(!is_wp4t() )
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

//widget for posts excluding members only
class NewestMembersWidget extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'newest_members', 'description' => __( "Newest Members of Club.",'rsvpmaker-for-toastmasters') );
		parent::__construct('newest_members', __('Newest Members','rsvpmaker-for-toastmasters'), $widget_ops);
		$this->alt_option_name = 'widget_newest_members';
	}

	public function widget($args, $instance) {
		$cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'widget_newest_members', 'widget' );
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

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Newest Members','rsvpmaker-for-toastmasters' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
			$number = 5;

		/**
		 * Filter the arguments for the newest_members widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the club_news posts.
		 */
//fetch user list and sort
$joinedslug = 'joined'.get_current_blog_id();
$q = 'blog_id='.get_current_blog_id();
$blogusers = get_users($q);
foreach($blogusers as $user) {
	$userdata = get_userdata($user->ID);
if(!empty($userdata->$joinedslug))
		$index = date('Y-m-d',strtotime($userdata->$joinedslug));
elseif(!empty($userdata->club_member_since))
	$index = date('Y-m-d',strtotime($userdata->club_member_since));
else
		continue; // don't include if no join date
$month = date('F Y',strtotime($index));
$index .= $userdata->user_registered;
$members[$index] = $userdata->first_name.' '.$userdata->last_name.' ('.$month.')';
}

?>
		<?php echo $args['before_widget']; ?>
		<?php if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		$count = 1;
		if(!empty($members))
			{
				krsort($members);
				echo '<ul>';
				foreach($members as $index => $member)
					{
						printf('<li>%s</li>',$member);
						$count++;
						if($count > $number)
							break;
					}
				echo '</ul>';
			}
		
		}
		//display list
		 ?>
		<?php echo $args['after_widget']; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it

		if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'widget_newest_members', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_newest_members']) )
			delete_option('widget_newest_members');

		return $instance;
	}

	public function flush_widget_cache() {
		wp_cache_delete('widget_newest_members', 'widget');
	}

	public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

<?php
	}
}

function wptoast_widgets () {
	register_widget("AwesomeWidget");
	register_widget( 'WP_Widget_Members_Posts' );
	register_widget( 'WP_Widget_Club_News_Posts' );
	register_widget("NewestMembersWidget");
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
<div style="background-color: #fff; padding: 10px;"><p>Learn more about <a href="https://wp4toastmasters.com" target="_blank">WordPress for Toastmasters</a>. This open source software project was created by <a target="_blank" href="https://davidfcarr.com">David F. Carr, DTM</a>, and receives no financial or logistical support from Toastmasters International. The Toastmasters-branded theme <a href="https://wordpress.org/themes/lectern/" target="_blank">Lectern</a> has been reviewed for conformance to Toastmasters branding requirements.</p>
<p>Thanks to the volunteers, donors, and toastmost.org subscribers who lend their support.</p>
</div>
<?php
}

add_action( 'wp_ajax_wptoast_dismissed_notice_handler', 'wptoast_ajax_notice_handler' );

/**
 * AJAX handler to store the state of dismissible notices.
 */
function wptoast_ajax_notice_handler() {
$cleared = get_option('cleared_rsvptoast_notices');
$cleared = is_array($cleared) ? $cleared : array();
    // Pick up the notice "type" - passed via jQuery (the "data-notice" attribute on the notice)
    $cleared[] = $_REQUEST['type'];
	update_option('cleared_rsvptoast_notices',$cleared);
	print_r($cleared);
}

function rsvptoast_admin_notice() {
if(isset($_GET['action']) && ($_GET['action'] == 'edit'))
	return; //don't clutter edit page with admin notices. Gutenberg hides them anyway.
if(isset($_GET['post_type']) && ($_GET['post_type'] == 'rsvpmaker') && !isset($_GET['page']))
	return; //don't clutter post listing page with admin notices
global $wpdb;
global $current_user;
global $post;
global $rsvp_options;

/* notices NOT just for admin */

$pdir = str_replace('rsvpmaker-for-toastmasters/','',plugin_dir_path( __FILE__ ));

if(!is_plugin_active('rsvpmaker/rsvpmaker.php')){
	if(file_exists($pdir.'rsvpmaker/rsvpmaker.php'  ) )
		echo '<div class="notice notice-error"><p>'.sprintf(__('The RSVPMaker plugin is required for all Toastmasters functions. RSVPMaker is installed but must be activated. <a href="%s#name">Activate now</a>','rsvpmaker-for-toastmasters'),admin_url('plugins.php?s=rsvpmaker') )."</p></div>\n";
	else
		echo  '<div class="notice notice-error"><p>'.sprintf(__('The RSVPMaker plugin is required for all Toastmasters functions. RSVPMaker must be installed and activated. <a href="%s">Install now</a>','rsvpmaker-for-toastmasters'),admin_url('plugin-install.php?tab=search&s=rsvpmaker#plugin-filter'))."</p></div>\n";
return; // if this is not configured, the rest doesn't matter
}	
	
$next_show_promo = (int) get_user_meta($current_user->ID,'next_show_promo',true);

if((time() > $next_show_promo ) || isset($_REQUEST["show_ad"]) )
{
show_wpt_promo();
$next_show_promo = strtotime('+ 1 day');
update_user_meta($current_user->ID,'next_show_promo',$next_show_promo);
}

if(function_exists('do_blocks') && current_user_can('manage_options') && !isset($_GET['convert']))
{
$active = $wpdb->get_row("SELECT ID from $wpdb->posts WHERE post_content LIKE '%wp:wp4toastmasters%' AND post_status='publish' ");
if(!$active)
	echo '<div class="notice notice-info"><p>Your meeting agenda templates need to be converted to work with the new WordPress editor. <a href="'.admin_url('edit.php?post_type=rsvpmaker&page=rsvpmaker_template_list&convert=1').'">Convert Now?</a></p></div>';
}

if(isset($_REQUEST["action"]) && ($_REQUEST["action"] == 'edit') && isset($post->post_content) && is_wp4t())
{
$template_id = get_post_meta($post->ID,'_meet_recur',true);
?>
<div class="notice notice-info"><div style="float: right; width: 225px; padding: 5px; background-color: #fff; margin-left:5px;"><img src="<?php echo plugins_url('rsvpmaker-for-toastmasters/mce/toastmasters_editor_buttons.png')?>" /><br /><em>Toastmasters custom buttons</em></div>

<p><?php _e("You can drag-and-drop to reorder roles or add new roles using the Toastmasters Roles button. Double-click on the placeholder for a role to edit options. Setting the count for a role to more than one opens up multiple signup slots (for example, multiple speakers and multiple evaluators). Your choices determine the roles that will appear on the online signup form, the printable signup form, and the agenda.",'rsvpmaker-for-toastmasters');?></p>
<p><?php _e("Use the Agenda Note button to provide additional 'stage directions' that will appear on thet agenda. Entering a label such as 'Meeting Theme' in the 'Editable field' blank will allow you to add meeting-specific content as part of the same process where you edit signups for roles. You can specify whether agenda notes should appear on the agenda only, on the signup form only, or both.",'rsvpmaker-for-toastmasters');?></p>

<?php
if($template_id)
	{
		printf('<p>%s <a href="%s">%s</a>',__('Changes made below will be applied to a single event. To change the agenda for all future events: '),admin_url('post.php?action=edit&post='.$template_id),__('Edit Template'));
	}

	$timing = '';
	if(!function_exists('do_blocks'))
		$timing = sprintf(' | <a href="%s" target="_blank">%s</a>',admin_url('edit.php?post_type=rsvpmaker&page=agenda_timing&post_id='.$post->ID),__('Agenda Timing','rsvpmaker-for-toastmasters'));
	printf('<div>%s: <a href="%s">%s</a> </div>',__('Related','rsvpmaker-for-toastmasters'),rsvpmaker_permalink_query($post->ID,'print_agenda=1&no_print=1'),__('Show Agenda','rsvpmaker-for-toastmasters'));
?>
</div>
<?php
}

if(isset($_REQUEST["page"]) && ($_REQUEST["page"] == 'agenda_timing') && isset($_REQUEST["post_id"]))
{
echo '<div class="notice notice-info"><p>'.__('Related','rsvpmaker-for-toastmasters').': ';
$template_id = get_post_meta($_REQUEST["post_id"],'_meet_recur',true);	
if($template_id && current_user_can('agenda_setup'))
	printf('<a href="%s">%s</a> | ',admin_url('edit.php?post_type=rsvpmaker&page=agenda_timing&post_id='.$template_id),__('Agenda Timing: Template','rsvpmaker-for-toastmasters'));

if(current_user_can('agenda_setup'))
	printf('<a href="%s">%s</a> | ',admin_url('post.php?action=edit&post='.$_REQUEST["post_id"]),__('Edit/Agenda Setup','rsvpmaker-for-toastmasters'));

printf('<a href="%s" target="_blank">%s</a> | ',rsvpmaker_permalink_query($_REQUEST["post_id"],'print_agenda=1&no_print=1'),__('View Agenda','rsvpmaker-for-toastmasters'));
printf('<a href="%s">%s</a>',get_permalink($_REQUEST["post_id"]),__('View Signup Form','rsvpmaker-for-toastmasters'));
echo '</div>';
}

$sync_ok = get_option('wp4toastmasters_enable_sync');

if($sync_ok)
{
if(isset($_REQUEST["page"]) && (($_REQUEST["page"] == 'my_progress_report') || isset($_REQUEST["toastmaster"]) ) )
	{
		$user_id = (isset($_REQUEST["toastmaster"])) ? $_REQUEST["toastmaster"] : $current_user->ID;
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
	if(isset($_GET['reset_sync_count']))
		update_option('last_wpt_json_batch_upload',0);
	$sync = wpt_json_batch_upload();
	if($sync)
		echo '<div class="notice notice-info"><p>'.$sync."</p></div>\n";
	}
}

/* notices for admin only */

if(!current_user_can('manage_options'))
	return;
if(isset($_GET['reset_notices']))
{
	$cleared = array();
	delete_option('cleared_rsvptoast_notices');
}
else
{
$cleared = get_option('cleared_rsvptoast_notices');
$cleared = is_array($cleared) ? $cleared : array();	
}
if(isset($_REQUEST['cleared_rsvptoast_notices']) && $_REQUEST['cleared_rsvptoast_notices'])
 	{
		$cleared[] = $_REQUEST['cleared_rsvptoast_notices'];
		update_option('cleared_rsvptoast_notices',$cleared);
	}
if(isset($_REQUEST["create_welcome_page"]) && ($_REQUEST["create_welcome_page"] == 0))
	{
		$cleared[] = 'front';
		update_option('cleared_rsvptoast_notices',$cleared);
	}
if(isset($_REQUEST["meetings_nag"]) && ($_REQUEST["meetings_nag"] == 0))
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
			$message = sprintf(__('The Reconcile screen has been renamed Update History and can now be used to record backdated information such as speeches delivered before you started using this software. See <a target="_blank" href="https://wp4toastmasters.com/2017/05/07/updating-member-history/">blog post</a> for explanation of this and related changes.</p><p><a href="%s">Got it: stop showing this notice.</a>','rsvpmaker-for-toastmasters'), admin_url('admin.php?page=toastmasters_reconcile&cleared_rsvptoast_notices=update_history') );
			rsvptoast_admin_notice_format($message, 'update_history', $cleared, 'info');
			}
	}

if(isset($_POST["sked"]))
	delete_option('default_toastmasters_template');

if(!in_array('lectern',$cleared))
{
$my_theme = wp_get_theme();
$theme_name = $my_theme->get( 'Name' );
if($theme_name != 'Lectern')
	{
	if(file_exists( get_theme_root().'/lectern/style.css' ) )
	{
		$message = sprintf(__('The Lectern theme (recommended for Toastmasters branding) is installed but not active. <a href="%s">Activate now</a> or <a href="%s">No thanks,</a> I prefer another theme.','rsvpmaker-for-toastmasters'),admin_url('themes.php?search=Lectern#lectern-action'), admin_url('options-general.php?page=wp4toastmasters_settings&cleared_rsvptoast_notices=lectern') );
		rsvptoast_admin_notice_format($message, 'lectern', $cleared, 'info');
	}
	else
	{
		$message = sprintf(__('The Lectern theme (recommended for Toastmasters branding) is not installed or activated. <a href="%s">Install it now</a> or <a href="%s">No thanks,</a> I prefer another theme.','rsvpmaker-for-toastmasters'),admin_url('theme-install.php?theme=lectern'), admin_url('options-general.php?page=wp4toastmasters_settings&cleared_rsvptoast_notices=lectern'));		
		rsvptoast_admin_notice_format($message, 'lectern', $cleared, 'info');
	}
	return;
	}
}

if(!get_option('page_on_front') && !in_array('front',$cleared))
	{
	
	if(isset($_REQUEST["create_welcome_page"]) && $_REQUEST["create_welcome_page"])
	{
		echo '<div class="updated">';
		global $current_user;
		
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
	echo "</div>";
	}

	if(isset($_REQUEST["create_welcome_page"]))
		{ // even if set to 0, clear the reminder
		$cleared[] = 'front';
		update_option('cleared_rsvptoast_notices',$cleared);
		}
	else {
	ob_start();
	?>
    <p>Do you want to create a welcome page as the front page (rather than having a blog listing as the front page)?</p>
    <form action="<?php echo admin_url('edit.php?post_type=page'); ?>" method="get">
    <p><input type="radio" name="create_welcome_page" value="1" checked="checked">Yes - create welcome page based on default content. Show blog listing on a separate page.</p>
    <p><input type="radio" name="create_welcome_page" value="0">No, I prefer the blog listing as front page.</p>
    <p><input type="checkbox" name="addpages" value="1" checked="checked" /> Add pages for calendar, member directory, Toastmasters International info; set up menu.</p>
    <button><?php _e('Submit','rsvpmaker-for-toastmasters') ?></button>
    </form>
	<?php
	$message = ob_get_clean();
	rsvptoast_admin_notice_format($message, 'front', $cleared, 'info');
	}
	return;
	} // end page on front routine

if(isset($_REQUEST["addpages"]))
	{
		rsvptoast_pages($current_user->ID);
		if(!in_array('front',$cleared)) {
			$cleared[] = 'front';
			update_option('cleared_rsvptoast_notices',$cleared);	
		}		
	}

/*
if(!in_array('front',$cleared)) { // if a static front page is not set, or registered as cleared, check to see if other default pages are installed
$found = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_content LIKE '%srsvpmaker_upcoming%' OR post_content LIKE '%rsvpmaker/upcoming%' ");
if(!$found) {
?>
    <div class="error">
    <p>Do you want to add these default pages?</p>
    <form action="<?php echo admin_url('edit.php?post_type=page'); ?>" method="get">
    <p><input type="checkbox" name="addpages" value="1" checked="checked" /> Add pages for calendar, member directory, Toastmasters Internation info; set up menu.</p>
    <button><?php _e('Submit','rsvpmaker-for-toastmasters') ?></button>
    </form>
    </div>
	<?php
	}
}
*/

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
	$missing .= '<li>'.__('This site is not being indexed by search engines.','rsvpmaker-for-toastmasters').' <a href="'.admin_url('options-general.php?page=wp4toastmasters_settings').'">'.__('Make the site public?','rsvpmaker-for-toastmasters').'</a></li>';

$email = get_option('wp4toastmasters_disable_email');
if($email)
	$missing .= '<li>'.__('Toastmasters-specific functions for sending email (such as sending a welcome message and password to a new member) are currently disabled.','rsvpmaker-for-toastmasters').' <a href="'.admin_url('options-general.php?page=wp4toastmasters_settings').'">'.__('Enable email?','rsvpmaker-for-toastmasters').'</a></li>';
	
$tz = get_option('timezone_string');
if(empty($tz) )
	$missing .= '<li>'.__('Make sure to set the correct timezone for your site so scheduling functions will work properly.','rsvpmaker-for-toastmasters').'</li>';

if(!empty($missing) && !(isset($_GET['page']) && ($_GET['page'] == 'wp4toastmasters_settings')) )
{
	$message = sprintf(__('Visit the <a href="%s">Toastmasters Settings</a> screen','rsvpmaker-for-toastmasters').'<p><ul>'.$missing.'</ul>',admin_url('options-general.php?page=wp4toastmasters_settings'));
	rsvptoast_admin_notice_format($message, 'visit_settings', $cleared, 'info');	
}

}
	
$blogusers = get_users('blog_id='.get_current_blog_id() );
if( sizeof($blogusers) == 1 )
{
	$message = sprintf(__('<a href="%s">Add club members</a> as website users. You can import your whole roster, using the spreadsheet from toastmasters.org\'s Club Central. Or selectively add a few members to help you with testing.','rsvpmaker-for-toastmasters'),admin_url('users.php?page=add_awesome_member'));
	rsvptoast_admin_notice_format($message,'users',$cleared,'info');
}

if(!in_array('wp-user-avatar',$cleared) && !is_plugin_active('wp-user-avatar/wp-user-avatar.php')){
	if(file_exists($pdir.'wp-user-avatar/wp-user-avatar.php'  ) )
	{
		$message = sprintf(__('The WP User Avatar plugin is recommended for allowing members to add a profile picture. WP User Avatar is installed but must be activated. <a href="%s#name">Activate now</a> or <a href="%s">No thanks</a>','rsvpmaker-for-toastmasters'),admin_url('plugins.php?s=wp-user-avatar'), admin_url('options-general.php?page=wp4toastmasters_settings&cleared_rsvptoast_notices=wp-user-avatar') );
		rsvptoast_admin_notice_format($message,'wp-user-avatar',$cleared,'info');
	}
	else {
		$message = sprintf(__('The WP User Avatar plugin is recommended for allowing members to add a profile picture. <a href="%s">Install now</a> or <a href="%s">No thanks</a>','rsvpmaker-for-toastmasters'),admin_url('plugin-install.php?tab=search&s=wp-user-avatar#plugin-filter'), admin_url('options-general.php?page=wp4toastmasters_settings&cleared_rsvptoast_notices=wp-user-avatar') );
		rsvptoast_admin_notice_format($message,'wp-user-avatar',$cleared,'info');
	}
}


if(!in_array('meetings_nag',$cleared) && !strpos($_SERVER['REQUEST_URI'],'rsvpmaker_template_list') && !strpos($_SERVER['REQUEST_URI'],'agenda_setup')) // don't test if already on the projected dates page
{
global $wpdb;
		$future = get_future_events(" (post_content LIKE '%[toastmaster%' OR post_content LIKE '%wp:wp4toastmasters%') ");
		$upcoming = sizeof($future);
if($upcoming == 0)
{
	$message = sprintf(__('No meetings currently published. Add based on template (standard schedule and roles):</p><ul>%s</ul>','rsvpmaker-for-toastmasters'),get_toast_templates () );
	rsvptoast_admin_notice_format($message,'meetings_nag',$cleared,'info');	
}
elseif($upcoming < 5)
{
	$message = sprintf($upcoming.' '.__('meetings currently published. Add more based on template (standard schedule and roles):</p><ul>%s</ul>','rsvpmaker-for-toastmasters').'or <a href="%s">clear reminder</a>',get_toast_templates (), admin_url('options-general.php?page=wp4toastmasters_settings&cleared_rsvptoast_notices=meetings_nag') );
	rsvptoast_admin_notice_format($message,'meetings_nag',$cleared,'info');
}

}

if($sync_ok == '') // if not 1 or 0
	{
	$message = sprintf(__('You can choose to allow the member data on the Progress Reports screen to sync with other websites that use this software. See <a target="_blank" href="https://wp4toastmasters.com/2017/05/13/sync-member-progress-report-data/">blog post</a>.</p><p>Choose whether this should be on our off: <a href="%s">Toastmasters Settings.</a>','rsvpmaker-for-toastmasters'), admin_url('options-general.php?page=wp4toastmasters_settings') );
	rsvptoast_admin_notice_format($message, 'sync_ok', $cleared, 'info');
	}
}

function rsvptoast_admin_notice_format($message, $slug, $cleared, $type='info')
{
if(in_array($slug,$cleared))
	return;
if(empty($message))
	return;
printf('<div class="notice notice-%s wptoast-notice is-dismissible" data-notice="%s">
<p>%s</p>
</div>',$type,$slug,$message);
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
return 'https://toastmost.org/tmbranding/toastmasters3.jpg';
}

function rsvptoast_pages ($user_id) {
	$pages = get_pages();
	foreach($pages as $page)
		$titles[] = $page->page_title;
	$post = array(
	  'post_content'   => '[awesome_members comment="This placeholder code displays the member listing"]',
	  'post_name'      => 'members',
	  'post_title'     => 'Members',
	  'post_status'    => 'publish',
	  'post_type'      => 'page',
	  'post_author'    => $user_id,
	  'ping_status'    => 'closed'
	);
	if(!in_array('Members',$titles))
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
	if(!in_array('Calendar',$titles))
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
	if(!in_array('Toastmasters International',$titles))
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
if(!isset($_REQUEST["placeholder_image"]))
	return;
if(isset($_REQUEST["role"]))
	$impath = dirname( __FILE__ ).DIRECTORY_SEPARATOR.'mce'.DIRECTORY_SEPARATOR.'placeholder.png';
elseif(isset($_REQUEST["agenda_note"]) && strpos($_REQUEST["agenda_note"],'editable'))
	$impath = dirname( __FILE__ ).DIRECTORY_SEPARATOR.'mce'.DIRECTORY_SEPARATOR.'editable_placeholder.png';
else
	$impath = dirname( __FILE__ ).DIRECTORY_SEPARATOR.'mce'.DIRECTORY_SEPARATOR.'note_placeholder.png';
$im = imagecreatefrompng($impath);
if(!$im)
{
$im = imagecreate(800, 50);
imagefilledrectangle($im,5,5,790,45, imagecolorallocate($im, 50, 50, 255));
}

// White text
$border = imagecolorallocate($im, 0, 0, 0);
$textcolor = imagecolorallocate($im, 255, 255, 255);

$tip = $text = '';

if(isset($_REQUEST["role"]))
	{
	$text = sprintf('Role: %s Count: %s',$_REQUEST["role"],$_REQUEST["count"]);
	$tip = '(double-click for popup editor)';
	}
elseif(isset($_REQUEST["agenda_note"]))
	{
	$text = sprintf('Note: %s Display: %s',$_REQUEST["agenda_note"],$_REQUEST["agenda_display"]);
	$tip = '(double-click for popup editor)';
	}
elseif(isset($_REQUEST["themewords"]))
	{
	$text = 'Placeholder for Theme/Words of the Day';
	$tip = '(no popup editor)';
	}
else
	$text = 'error: unrecognized';

// Write the string at the top left
imagestring($im, 5, 40, 10, $text, $textcolor);
imagestring($im, 5, 40, 25, $tip, $textcolor);

// Output the image
header('Content-type: image/png');

imagepng($im);
imagedestroy($im);
exit();
}

function get_manuals_array() {
return array("Select Manual/Path" => __("Select Manual/Path",'rsvpmaker-for-toastmasters'),"COMPETENT COMMUNICATION" => __("COMPETENT COMMUNICATION",'rsvpmaker-for-toastmasters'),"ADVANCED MANUAL TBD" => __("ADVANCED MANUAL TBD",'rsvpmaker-for-toastmasters'),"COMMUNICATING ON VIDEO" => __("COMMUNICATING ON VIDEO",'rsvpmaker-for-toastmasters'),"FACILITATING DISCUSSION" => __("FACILITATING DISCUSSION",'rsvpmaker-for-toastmasters'), "HIGH PERFORMANCE LEADERSHIP" => "HIGH PERFORMANCE LEADERSHIP (ALS)","HUMOROUSLY SPEAKING" => "HUMOROUSLY SPEAKING","INTERPERSONAL COMMUNICATIONS"=>__("INTERPERSONAL COMMUNICATIONS",'rsvpmaker-for-toastmasters'),"INTERPRETIVE READING"=>__("INTERPRETIVE READING",'rsvpmaker-for-toastmasters'),"Other Manual or Non Manual Speech"=>__("Other Manual or Non Manual Speech",'rsvpmaker-for-toastmasters'),"PERSUASIVE SPEAKING"=>__("PERSUASIVE SPEAKING",'rsvpmaker-for-toastmasters'),"PUBLIC RELATIONS"=>__("PUBLIC RELATIONS",'rsvpmaker-for-toastmasters'),"SPEAKING TO INFORM"=>__("SPEAKING TO INFORM",'rsvpmaker-for-toastmasters'),"SPECIAL OCCASION SPEECHES"=>__("SPECIAL OCCASION SPEECHES",'rsvpmaker-for-toastmasters'),"SPECIALTY SPEECHES"=>__("SPECIALTY SPEECHES",'rsvpmaker-for-toastmasters'),"SPEECHES BY MANAGEMENT"=>__("SPEECHES BY MANAGEMENT",'rsvpmaker-for-toastmasters'),"STORYTELLING"=>__("STORYTELLING",'rsvpmaker-for-toastmasters'),"TECHNICAL PRESENTATIONS"=>__("TECHNICAL PRESENTATIONS",'rsvpmaker-for-toastmasters'),"THE DISCUSSION LEADER"=>__("THE DISCUSSION LEADER",'rsvpmaker-for-toastmasters'),"THE ENTERTAINING SPEAKER"=>__("THE ENTERTAINING SPEAKER",'rsvpmaker-for-toastmasters'),"THE PROFESSIONAL SALESPERSON"=>__("THE PROFESSIONAL SALESPERSON",'rsvpmaker-for-toastmasters'),"THE PROFESSIONAL SPEAKER"=>__("THE PROFESSIONAL SPEAKER",'rsvpmaker-for-toastmasters'),'BETTER SPEAKER SERIES' => __('BETTER SPEAKER SERIES','rsvpmaker-for-toastmasters'),'SUCCESSFUL CLUB SERIES'=> __('SUCCESSFUL CLUB SERIES','rsvpmaker-for-toastmasters'),'LEADERSHIP EXCELLENCE SERIES'=> __('LEADERSHIP EXCELLENCE SERIES','rsvpmaker-for-toastmasters')
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

,'Engaging Humor Level 1 Mastering Fundamentals'=> __('Engaging Humor Level 1 Mastering Fundamentals','rsvpmaker-for-toastmasters')
,'Engaging Humor Level 2 Learning Your Style'=> __('Engaging Humor Level 2 Learning Your Style','rsvpmaker-for-toastmasters')
,'Engaging Humor Level 3 Increasing Knowledge'=> __('Engaging Humor Level 3 Increasing Knowledge','rsvpmaker-for-toastmasters')
,'Engaging Humor Level 4 Building Skills'=> __('Engaging Humor Level 4 Building Skills','rsvpmaker-for-toastmasters')
,'Engaging Humor Level 5 Demonstrating Expertise'=> __('Engaging Humor Level 5 Demonstrating Expertise','rsvpmaker-for-toastmasters')
			 
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
include 'projects_array.php';
if(isset($_GET['debug'])) {
	rsvpmaker_debug_log($projects,'projects');
	rsvpmaker_debug_log($project_options,'options');	
}

if($choice == 'projects')
	return $projects;
elseif($choice == 'options')
	return $project_options;
elseif($choice == 'display_times')
	return $display_times;
else
	return $project_times;
}

function timeplanner_option ($count) {
$count = (int) $count;
$options = '';
if($count == 0)
	{
		$options .= '<option value="0">Not Set</option><option value="delete">Delete</option>';	
	}
else
	{
		$options .= sprintf('<option value="%s">%s</option><option value="delete">Delete</option><option value="0">Not Set</option>',$count, $count);
	}

for($i = 1; $i < 61; $i++)
	$options .= sprintf('<option value="%s">%s</option>',$i, $i);
return $options;
}

function timeplanner($atts, $content) {

	global $time_counter;
	global $newoutput;
	global $timeplanner_total;
	global $post;
	if(isset($atts["themewords"]))
		{
		if(!empty($newoutput))
			$newoutput .= '[toastmaster themewords="1" ]'."\n\n";
		return;
		}
	if(empty($atts["time_allowed"]))
		 $atts["time_allowed"] = 0;
	if(empty($atts["padding_time"]))
		 $atts["padding_time"] = 0;

	$txt = $output = '';
	$padding_time_block = sprintf('<input type="hidden" class="time_count" id="padding_time%d" value="0" />',$time_counter); // default except for speaker

	if(isset($atts["role"]))
		{
		$c = '';
		$role = $atts["role"];
		$count = 1;
		if(isset($atts["count"]))
			{
				$count = (int) $atts["count"];
				if($count > 1)
					$c = '('.$count.')';
			}
		$txt = sprintf('Role: %s %s',$atts["role"],$c);
		$signups = get_role_signups ($post->ID, $role, $count);
		if(!empty($signups))
			$txt .= ' '.$signups;
		if(strpos($atts["role"],'peaker') && !strpos($atts["role"],'ackup'))
			{
			global $max_speakers;
			$max_speakers = $count;
			$txt .= sprintf('<p>Time Allowed should be at least %d minutes (%d speeches, 7-minutes each) or more to allow for longer speeches. The signup form will show a warning if members sign up for speeches that exceed the limit. Use <strong>Extra Time</strong> to pad the agenda for introductions and presentation setup.</p>',($count * 7),$count);
			$padding_time_block = sprintf('<br /><strong>Extra Time</strong><br /><select class="time_count" name="padding_time[%d]" id="padding_time%d">%s</select>',$time_counter,$time_counter,timeplanner_option ($atts["padding_time"]));
				$speak_count = 0;
				for($i = 1; $i <= $count; $i++)
					{
						if(get_post_meta($post->ID,'_Speaker_'.$i,true))//if speaker assigned
						$speak_count += (int) get_post_meta($post->ID,'_maxtime_Speaker_'.$i,true);
					}
			if($speak_count)
				{
				$time_allowed = (int) $atts["time_allowed"];
				if($speak_count > $time_allowed)
					{
					$s = ' style="color:red;" ';
					$txt .= sprintf('<input type="hidden" id="speaker_time_count" value="%s" />', $speak_count - $time_allowed);
					}
				else
					$s = '';
				$txt .= sprintf('<p><strong %s>Speakers have reserved: %s minutes</strong></p>',$s, $speak_count);
				}
			}
		}
	if( !empty($content) )
		$txt .= " ".$content;
	if(!empty($atts["editable"]))
		$txt .= ' Editable: '.$atts["editable"];

	$output = sprintf('<tr class="timerow" timecount="%d"><td id="time%s"></td><td class="time_allowed_cell"><select class="time_count" name="time_allowed[%d]" id="time_allowed%d">%s</select>%s</td><td class="text_cell">%s</td></tr>',$time_counter,$time_counter,$time_counter,$time_counter,timeplanner_option ($atts["time_allowed"]),$padding_time_block ,$txt);

return $output;
}

function agenda_timing () {
global $wpdb;
global $time_counter;
global $timeplanner_total;
global $post;
fix_timezone();
if( !isset($_REQUEST["post_id"]))
{
$template_options = '';
		$dayarray = Array(__("Sunday",'rsvpmaker'),__("Monday",'rsvpmaker'),__("Tuesday",'rsvpmaker'),__("Wednesday",'rsvpmaker'),__("Thursday",'rsvpmaker'),__("Friday",'rsvpmaker'),__("Saturday",'rsvpmaker'));
		$weekarray = Array(__("Varies",'rsvpmaker'),__("First",'rsvpmaker'),__("Second",'rsvpmaker'),__("Third",'rsvpmaker'),__("Fourth",'rsvpmaker'),__("Last",'rsvpmaker'),__("Every",'rsvpmaker'));
	
			$sql = "SELECT *, $wpdb->posts.ID as postID
FROM $wpdb->postmeta
JOIN $wpdb->posts ON $wpdb->postmeta.post_id = $wpdb->posts.ID
WHERE meta_key='_sked' AND post_status='publish' AND (post_content LIKE '%[toastmaster%' OR post_content LIKE '%wp:wp4toastmasters%')";
			
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

		$results = get_future_events(" (post_content LIKE '%[toastmaster%' OR post_content LIKE '%wp:wp4toastmasters%') ", 100);
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
return;
}
else
	$post = get_post($_REQUEST["post_id"]);

$output = $newoutput = $template_options = '';
if(isset($_REQUEST["post_id"]) && $_REQUEST["post_id"])
{
$post_id = (int) $_REQUEST["post_id"];
global $post;
$post = get_post($post_id);

// clean up multiline agenda notes
$r = get_shortcode_regex(array('agenda_note'));
$post->post_content = preg_replace_callback(
        "/$r/s",
        function ($matches) {
			$clean_content = preg_replace("/[\r\n]+/"," ",trim($matches[5]));
            return '[agenda_note '.$matches[3].']'.$clean_content.'[/agenda_note]';
			return preg_replace("/[\r\n]+/"," ",$matches[0]);
        },
        $post->post_content
    );

$time_counter = 0;
$lines = explode("\n",$post->post_content);
foreach($lines as $lineindex => $line)
	{
		$time_counter = $lineindex +1;
		if( isset($_POST["time_allowed"]))
			{
			if(!empty($_POST["delete"][$time_counter]))
				{
				$line = "";
				}
			if ((strpos($line,'[toastmaster') === false)  && (strpos($line,'[agenda_note') === false))
				$newoutput .= "\n".$line;
			else
				{
					$time_allowed = (!empty($_POST["time_allowed"][$time_counter])) ? (int) $_POST["time_allowed"][$time_counter] : 0;
					$padding_time = (!empty($_POST["padding_time"][$time_counter])) ? (int) $_POST["padding_time"][$time_counter] : 0;
					if($time_allowed == 'delete')
					{
						$time_allowed = $padding_time = 0;
						$line = '';
					}
				
					if(strpos($line,'padding_time'))
						$line = preg_replace('/padding_time="(\d{0,3})/','padding_time="'.$padding_time,$line);
					else
						{
						if(isset($atts['role']))
							$line = str_replace('[toastmaster','[toastmaster padding_time="'.$padding_time.'" ',$line);
						else
							$line = str_replace('[agenda_note','[agenda_note padding_time="'.$padding_time.'" ',$line);
						}
					if(strpos($line,'time_allowed'))
						$line = preg_replace('/time_allowed="(\d{0,3})/','time_allowed="'.$time_allowed,$line);
					else
						{
						if(isset($atts['role']))
							$line = str_replace('[toastmaster','[toastmaster time_allowed="'.$time_allowed.'" ',$line);
						else
							$line = str_replace('[agenda_note','[agenda_note time_allowed="'.$time_allowed.'" ',$line);
						}
				if(!empty($_POST["change_speaker_count"]) && (strpos($line,'"Speaker"') || strpos($line,'"Evaluator"')))
					{
						$newcount = (int) $_POST["change_speaker_count"];
						$line = preg_replace('/count="(\d{0,3})/','count="'.$newcount,$line);							
					}
					$newoutput .= "\n".$line;
				}
			}

		if ((strpos($line,'[toastmaster') === false)  && (strpos($line,'[agenda_note') === false))
			continue; // ignore non shortcode content on form
		$output .= "\n".do_shortcode($line);
	}

$output .= '<tr class="timerow" timecount="'.$time_counter.'"><td id="time'.$time_counter.'"></td><td><input type="hidden" id="time_allowed'.$time_counter.'" value="0" /><input type="hidden" id="padding_time'.$time_counter.'" value="0"></td><td class="text_cell">'.__('Projected End of Meeting','rsvpmaker-for-toastmasters').'</td></tr>';	

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
foreach($results as $index => $row)
	{
	$t = strtotime($row["datetime"]);
	$dateblock .= '<div class="datetime" itemprop="startDate" datetime="'.date('c',$t).'" utc="'.gmdate('YYYY-mm-dd H:i'). 'UTC">';
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
	if($index == 0)
		{
			$p = explode(' ',$row['datetime']);
			$dateblock .= '<input type="hidden" id="start_time" value="'.$row['datetime'].'" />';
		}
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
echo '<input type="hidden" id="start_time" value="2017-01-01 '.$sked['hour'].':'.$sked['minutes'].'">';
}

if( isset($_POST["time_allowed"]))
	{
	$newoutput = trim(preg_replace("/[\n\r]{3,100}/","\n\n",$newoutput));
	wp_update_post(array('ID' => $post_id,'post_content' => $newoutput));
	//echo nl2br($newoutput);
	printf('<h3>Total Time Allowed: %s</h3>',$timeplanner_total);
	if(!empty($sked["week"]))
		echo rsvp_template_update_checkboxes($post_id);
	}
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
<style>
td {
vertical-align: top;
}
</style>
<table>
<tr><th>Elapsed Time</th><th>Time Allowed</th><th>Role/Note</th></tr>
<input type="hidden" name="post_id" value="<?php echo $post_id; ?>" />
<?php
echo $output;
global $max_speakers;
?>
</table>
<p>Number of Speakers and Evaluators: <select name="change_speaker_count">
<option value=""><?php echo $max_speakers; ?> (no change)</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
<option value="9">9</option>
<option value="10">10</option>
</select></p>
<?php
submit_button();
?>
</form>
<script>
jQuery(document).ready(function($) {

var time_tally;

var agenda_add_minutes =  function (dt, minutes) {
    return new Date(dt.getTime() + minutes*60000);
}

var agenda_time_tally =  function () {
	time_tally = new Date($('#start_time').val());//start time
    $('.timerow').each(function(index) {
     var count = $(this).attr('timecount');
	  	var hour = time_tally.getHours();
		var minute = time_tally.getMinutes();
		hour = (hour >= 12)? hour - 12: hour;
		if(minute < 10)
		minute = '0' + minute;
	$('#time' + count).fadeTo( "fast", 0.1 );
	$('#time' + count).html(hour + ":" + minute);
	$('#time' + count).delay(index*50).fadeTo( "fast", 1.0 );
	var tallyadd = 0;
	var addthis = Number($('#time_allowed' + count).val());
	if(!isNaN(addthis))
		tallyadd += addthis;
	tallyadd += Number($('#padding_time' + count).val());
    time_tally = agenda_add_minutes(time_tally,tallyadd);
	});
}

agenda_time_tally();

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
	agenda_time_tally();
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

function admin_link_menu() {
global $post;
$permalink = get_permalink($post->ID).'?';
$security = get_tm_security ();
$template_id = get_post_meta($post->ID,'_meet_recur',true);

	$link = '<div id="cssmenu"><ul>';
	if(current_user_can($security['agenda_setup']))
		{
		$agenda_menu[__('Agenda Setup','rsvpmaker-for-toastmasters')] = admin_url('post.php?action=edit&post='.$post->ID);
		if($template_id)
			$agenda_menu[__('Agenda Setup: Template','rsvpmaker-for-toastmasters')] = admin_url('post.php?action=edit&post='.$template_id);
		if(!function_exists('do_blocks'))
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

function tm_security_setup ($check = true,$cookie=true) {
if($cookie)
	setcookie('tm_member', $_SERVER['REMOTE_ADDR'], time() + 15552000);//180 days
global $tm_security;
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
	}

add_awesome_roles();

$tm_cap_set = get_option('tm_cap_set');
if(!$tm_cap_set || ($check == 2))
	{
	foreach($security_roles as $role)
		{
			$tm_role = get_role($role);
			if($tm_role)
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

// make sure administrator gets all rights
$tm_role = get_role('administrator');
foreach($tm_security['administrator'] as $cap => $value)
	{
	$tm_role->add_cap($cap);
	}
}
return $tm_security;
}

function tm_security_caps () {
?>
<div class="wrap">
<h2>Toastmasters Security Options</h2>
<?php
if(isset($_REQUEST["reset_security"]))
	$tm_security = tm_security_setup (2,false);
else
	$tm_security = tm_security_setup (false,false);

$action = admin_url('options-general.php?page=tm_security_caps');

$action = admin_url('options-general.php?page=wp4toastmasters_settings');

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
					if($value && ($cap = 'agenda_setup'))
					{
						$tm_role->add_cap('edit_rsvpmakers');
						$tm_role->add_cap('edit_others_rsvpmakers');
					}
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
			if(isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'security')
			{
			?>
			<input type="hidden" id="activetab" value="security" />
			<?php	
			}
			?>
			<input type="hidden" name="tab" value="security">
			<?php
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
				$opt = (!empty($tm_role->capabilities[$cap])) ? '<option value="1" selected="selected">'.__('Yes','rsvpmaker-for-toastmasters').'</option><option value="0">'.__('No','rsvpmaker-for-toastmasters').'</option>' : '<option value="1">'.__('Yes','rsvpmaker-for-toastmasters').'</option><option value="0" selected="selected">'.__('No','rsvpmaker-for-toastmasters').'</option>';
				printf('<p><select name="tm_caps[%s][%s]">%s</select> %s</p>',$role,$cap,$opt,$cap);
			}
		echo '</div>';
	}

echo '<div style="clear: both;">';
if(isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'security')
{
?>
<input type="hidden" id="activetab" value="security" />
<?php	
}
?>
<input type="hidden" name="tab" value="security">
<?php

submit_button();
echo '</div>';
echo '</form>';

printf('<form method="post" action="%s"><h2>Set for User</h2>',$action);
echo awe_user_dropdown ('user_id',0, true);
submit_button();
if(isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'security')
{
?>
<input type="hidden" id="activetab" value="security" />
<?php	
}
?>
<input type="hidden" name="tab" value="security">
<?php
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

function tm_youtube_tool () {

echo '<h1>Toastmasters YouTube Video Tool</h1>';
echo "<p>";
 _e('This tool was designed to capture a listing of videos you have uploaded to YouTube and use them as the basis of a blog post (categorized as members-only by default) and / or an email to distribute to your members.','rsvpmaker-for-toastmasters');
echo "</p>";
 
global $current_user;
global $wpdb;
$wpdb->show_errors();

if(!empty($_POST["speakers"]))
	{
	
$blog = $_POST["blog"];
$email = $_POST["email"];
$policy = stripslashes($_POST["policy"]);
update_option('tm_video_blog',$blog);
update_option('tm_video_email',$email);
update_option('tm_video_policy',$policy);

$members_category = get_category_by_slug('members-only');
$members_cat_id = (empty($members_category->term_id)) ? wp_create_category('Members Only') : $members_category->term_id;
$video_cat = wp_create_category(__('Video','rsvpmaker-for-toastmasters'));

	// Create post object
$my_post = array(
  'post_title'    => __('Videos','rsvpmaker-for-toastmasters'),
  'post_content'  => '',
  'post_status'   => $blog,
  'post_author'   => $current_user->ID,
  'post_category' => array($members_cat_id,$video_cat) //video, members only
);

	$speakers = array();
	foreach($_POST["speakers"] as $index => $speaker)
		if(!empty($speaker))
		{
			if(empty($_POST["link"][$index])){
				printf('<div class="notice notice-error wptoast-notice" >
<p>Error: no link provided for speech by %s</p></div>',$speaker);
				continue;
			}
			$speakers[] = $speaker;
			$link = $_POST["link"][$index];
			if(!empty($_POST["speech"][$index]))
				$speaker .= ": ".stripslashes($_POST["speech"][$index]);
			$my_post['post_content'] .= sprintf("\n\n<p>".'<a href="%s">%s</a>%s',$link,$speaker,"</p>\n\n".$link."\n\n");
		}
	
	if(!empty($speakers))
	{
	$my_post['tags_input'] = $speakers;
	$my_post['post_title'] .= ': '.stripslashes(implode(', ',$speakers));
	}

// Insert the post into the database
if($blog != 'none')
	{
	$my_post['post_content'] .= wpautop($policy);
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
  'post_content'  => $my_post['post_content'],
  'post_status'   => 'publish',
  'post_type' => 'rsvpemail',
  'post_author'   => $current_user->ID);
	$id = wp_insert_post( $my_email );
	printf('<p><a href="%s?post=%d&action=edit">%s</a></p>',admin_url('post.php'),$id,__('Edit email','rsvpmaker-for-toastmasters'));
		printf('<p><a href="%s">%s</a></p>',get_permalink($id),__('Preview/send email','rsvpmaker-for-toastmasters'));
		}

	echo wpautop($my_post['post_content']);
	
	}
$blog = get_option('tm_video_blog');
if(empty($blog))
	$blog = 'draft';
$email = (int) get_option('tm_video_email');
?>
<form method="post" action="<?php echo admin_url('upload.php?page=tm_youtube_tool'); ?>">
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
<?php
$blogusers = get_users('blog_id='.get_current_blog_id() );
$options = '<option value="">Select Member</option>';
    foreach ($blogusers as $user) {
	$userdata = get_userdata($user->ID);
	if($userdata->hidden_profile)
		continue;

	$index = preg_replace('/[^A-Za-z]/','',$userdata->last_name.$userdata->first_name.$userdata->user_login);
	$names[$index] = $userdata->first_name.' '.$userdata->last_name;
	$index = preg_replace('/[^A-Za-z]/','',$userdata->first_name.$userdata->last_name.$userdata->user_login);
	$fnames[$index] = $userdata->first_name.' '.$userdata->last_name;
	}
	
	ksort($names);
	ksort($fnames);
	$options .= '<optgroup label="First Names">';
	foreach ($fnames as $name)
		$options .= sprintf('<option value="%s" /> %s </option>',$name,$name);
	$options .= '</optgroup><optgroup label="Last Names">';
	foreach ($names as $name)
		$options .= sprintf('<option value="%s" /> %s </option>',$name,$name);
	$options .= '</optgroup>';

$ptext = '';
$count = 1;
$past = get_past_events(" (post_content LIKE '%[toastmaster%' OR post_content LIKE '%wp:wp4toastmasters%') ", 5);
if($past)
foreach($past as $pst)
	{
		$ptext .= '<strong>'.$pst->date."</strong>\n";
		$sql = "SELECT *, meta_value as user_id FROM $wpdb->postmeta WHERE post_id=$pst->ID AND meta_key LIKE '_Speaker%' ORDER BY meta_key";
		$speakers = $wpdb->get_results($sql);
		if($speakers)
		foreach ($speakers as $row)
			{
				if(!empty($row->user_id) && is_numeric($row->user_id))
				{
				$user = get_userdata($row->user_id);
				$ptext .= sprintf('<input type="checkbox" name="speakers[%d]" id="speaker%d" value="%s" /> ',$count,$count,$user->first_name.' '.$user->last_name);
				$title = get_post_meta($pst->ID,'_title'.$row->meta_key,true);
				$details = '';
				if(!empty($title))
					$details = trim($title);
				$pkey = get_post_meta($pst->ID,'_project'.$row->meta_key,true);
				if(!empty($pkey)) {
				$project = get_project_text($pkey);
				if(!empty($details))
					$details .= ", ";
				$details .= __('Project:','rsvpmaker-for-toastmasters').' '.$project;
				}
				$ptext .= sprintf('%s: %s<br />Details: <input type="text" name="speech[%d]" value="%s"> YouTube Link: <input type="text" name="link[%d]" class="checkboxlink" i="%d">',$user->first_name.' '.$user->last_name,$details,$count,htmlentities($details.' '.$pst->date),$count,$count);
				$ptext .= "\n\n";
				$count++;
				}
			}
	}

$stop = $count + 3;

while($count < $stop) {
	$ptext .= sprintf('<p><select name="speakers[%d]">%s</select> Details: <input type="text" name="speech[%d]"> YouTube Link: <input type="text" name="link[%d]"></p>',$count,$options,$count,$count);
	$count++;
}

$stop = $count + 2;

while($count < $stop) {
	$ptext .= sprintf('<p>Name: <input type="text" name="speakers[%d]"> Details: <input type="text" name="speech[%d]"> YouTube Link: <input type="text" name="link[%d]"></p>',$count,$count,$count);
	$count++;
}

echo wpautop($ptext);
	$policy = get_option('tm_video_policy');
	if(empty($policy) )
		$policy = "<strong>Video policy</strong>: speech videos are intended as a tool for speakers to see their own performances and think about how they can improve. Even though these are on YouTube, they are published as \"unlisted\" by default, meaning they won't show up in search results. Don't forward these links or post them on Facebook or in any other forum without the speaker's permission. From time to time, we may ask a speaker for permission to use a video as part of our marketing of the club. Volunteers are also welcome - if you're proud of a particular speech, let us know.";
?>
<h3><?php _e('Policy to include in email','rsvpmaker-for-toastmasters'); ?></h3>
<p><textarea name="policy" rows="3" style="width: 100%"><?php echo $policy;?></textarea></p>
<?php submit_button(); ?>
</form>
<script>
jQuery(document).ready(function($) {
$( ".checkboxlink" ).change(function() {
//get value of speakerx
	var count = $(this).attr('i');
	$('#speaker'+count).prop('checked', true);
});
});
</script>
<?php

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
global $post;
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

$css = get_post_meta($post->ID,'_rsvptoast_agenda_css_2018',true);	

if(empty($css) || isset($_REQUEST['reset']))
{
	$css = wpt_default_agenda_css();
	update_post_meta($post->ID,'_rsvptoast_agenda_css_2018',$css);
}
	
echo '<h3>CSS tweaks (same as on Toastmasters settings page)</h3><p>These settings will override anything in the full CSS specified below.</p>';
agenda_css_customization_form();

echo '<h3>Full CSS</h3>';

echo '<pre>'.$css.'</pre>';

$missing = '';
	
if(!strpos($css,'stoplight'))
		$missing .= sprintf('<p><strong>/*%s*/</strong></p><pre>%s</pre>',__('Stoplight display, green-yellow-red times','rsvpmaker-for-toastmasters'),wpt_default_agenda_css('stoplight') );
	if(!strpos($css,'.role'))
		$missing .= sprintf('<p><strong>/*%s*/</strong></p><pre>%s</pre>',__('Bold role label','rsvpmaker-for-toastmasters'),'.role {
font-weight: bold;
}');
if(!strpos($css,'.indent'))
		$missing .= sprintf('<p><strong>/*%s*/</strong></p><pre>%s</pre>',__('Indented items','rsvpmaker-for-toastmasters'),'div.indent {
margin-left: 15px;
}');	
if(!strpos($css,'.role_agenda_note'))
		$missing .= sprintf('<p><strong>/*%s*/</strong></p><pre>%s</pre>',__('Formatting for notes displayed below roles.','rsvpmaker-for-toastmasters'),'.role_agenda_note {
font-style: italic;
}');	
if(!strpos($css,'.role-agenda-item ul '))
		$missing .= sprintf('<p><strong>/*%s*/</strong></p><pre>%s</pre>',__('Agenda role list items (by default, we do not show bullet points)','rsvpmaker-for-toastmasters'),'.role-agenda-item ul {
  list-style-type: none;
  padding-left: 0;
  margin-left: 0;
}');	

if(!empty($missing))
	echo "<h3>Missing CSS Elements</h3><p>Consider adding these to your CSS code</p>\n".$missing;

}

function save_rsvpmaker_special_toastmasters ( $post_id ) {
	if(isset($_POST["_rsvptoast_agenda_css"]))
		update_post_meta($post_id,"_rsvptoast_agenda_css_2018",stripslashes($_POST["_rsvptoast_agenda_css"]));
	if(isset($_POST["wp4toastmasters_agenda_css"]))
		update_option("wp4toastmasters_agenda_css",stripslashes($_POST["wp4toastmasters_agenda_css"]));
}

add_action('save_post','save_rsvpmaker_special_toastmasters');

add_action('rsvpmaker_special_metabox','rsvpmaker_special_toastmasters');

function tmlayout_club_name ($atts) {
if(is_admin() || wp_is_json_request())
	return;
	return get_bloginfo('name');
}

function tmlayout_tag_line ($atts) {
if(is_admin() || wp_is_json_request())
	return;
	return get_bloginfo('description');
}

function tmlayout_meeting_date ($atts) {
	if(is_admin() || wp_is_json_request())
	return;
	global $post;
	global $rsvp_options;
	$datestring = get_rsvp_date($post->ID);
	if(!empty($datestring))
	return strftime($rsvp_options["long_date"], strtotime($datestring) );
}
function tmlayout_sidebar($atts) {
	if(is_admin() || wp_is_json_request())
	return;

global $post;
	$recur = get_post_meta($post->ID, "_meet_recur", true);
	$template_sidebar = ($recur) ? get_post_meta($recur,'_tm_sidebar', true) : '';
	$post_sidebar = get_post_meta($post->ID,'_tm_sidebar', true);
	$option_sidebar = get_option('_tm_sidebar');
	
	if(!empty($post_sidebar)){
		$sidebar = $post_sidebar;
		$officers = get_post_meta($post->ID,"_sidebar_officers", true);
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
		//$officers = $custom["_sidebar_officers"][0];
	}
	
if(!empty($officers))
{
	echo "<p>";
	$sidebar .= toastmaster_officers($atts);
	echo "</p>";
}

return wpautop(trim(str_replace('&nbsp;',' ',$sidebar)));
}

function tmlayout_main($atts) {
	if(is_admin() || wp_is_json_request())
		return;
	global $post;
	$layout = get_option('rsvptoast_agenda_layout');
	if($post->ID == $layout)
		{
		$meetings = future_toastmaster_meetings(1);
		if(empty($meetings[0]->ID))
			return 'View the agenda of a current meeting to test this';
		$permalink = get_permalink($meetings[0]->ID);
		$permalink .= (strpos($permalink,'?')) ? '&' : '?';
		$permalink .= "print_agenda=1";
		return sprintf('View the <a href="%s">agenda of a current meeting</a> to test this',$permalink);
		}
	
	return tm_agenda_content();
}

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
				if($user && !$member && is_multisite())
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
$member_factory = new Toastmasters_Member();
	foreach($_POST["add"] as $index => $check)
	{
		$user["first_name"] = $_POST["first_name"][$index];		
		$user["last_name"] = $_POST["last_name"][$index];		
		$user["user_email"] = $_POST["user_email"][$index];
		if(!empty($_POST["toastmasters_id"][$index]))
			$user["toastmasters_id"] = (int) $_POST["toastmasters_id"][$index];
		$member_factory->check($user);
	}
$member_factory->show_prompts();
$member_factory->show_confirmations();	

}

if(isset($_POST["add_to_site"]) && is_multisite())
{
	foreach($_POST["add_to_site"] as $user_id)
	{
		make_blog_member($user_id);	
	}
}

$table = $wpdb->prefix.'rsvpmaker';
$results = $wpdb->get_results('SELECT * FROM '.$table.' ORDER BY id DESC LIMIT 0, 30');
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
			
			if(empty($out[$row->email]))
			{
				if($user && !$member)
					{
						$out[$row->email] = sprintf('<p><input type="checkbox" name="add_to_site[]" value="%d"> Add To Site %s %s %s</p>',$user->ID,$row->first,$row->last,$row->email);
					}
				else
					{
						$out[$row->email] = sprintf('<p><input type="checkbox" name="add[%d]" value="1"> Add User<br />%s<input type="text" name="first_name[%d]" value="%s" /><br />%s<input type="text" name="last_name[%d]" value="%s" /><br />%s<input type="text" name="user_email[%d]" value="%s" /><br />Toastmasters ID# <input type="text" name="toastmasters_id[%d]" value="" /></p>',$count,__('First Name','rsvpmaker-for-toastmasters'),$count,$row->first,__('Last Name','rsvpmaker-for-toastmasters'),$count,$row->last,__('Email','rsvpmaker-for-toastmasters'),$count,$row->email,$count);
					echo "\n";
					}				
			}
			
					$out[$row->email] .= get_rsvp_date($row->event). "<br />";
					
					$details = unserialize($row->details);
					foreach($details as $name => $value)
					{
						if($value) {
							$out[$row->email] .= $name.': '.esc_attr($value)."<br />";
						}
					}
					if($row->note)
						$out[$row->email] .= "note: " . nl2br(esc_attr($row->note))."<br />";
			$count++;
			}		
	}
if(!empty($out))
{
?>
<form action="<?php echo admin_url('users.php?page=rsvp_to_member'); ?>" method="post" style="max-width: 800px;">
<?php
foreach($out as $o)
{
echo "\n".'<div style="border: thin solid #000;">';
	echo $o;
echo '</div>';
}
echo '<div style="position: fixed; bottom: 30px; right: 30px; width: 100px;">';
submit_button();
echo '</div>';
?>
</form>
<?php	
}
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
$template_forms['Speaker'] = array('subject' => 'You are signed up to speak on [rsvpdate]','body' => "You are scheduled to speak on [rsvpdate].\n\n[wpt_speech_details]\n\nIf for any reason you cannot speak as scheduled, please post an update to the agenda\n\n[wptagendalink]\n\n[wpt_tod]");
$template_forms['Evaluator'] = array('subject' => 'You are signed up as an evaluator for [rsvpdate]','body' => "You are signed up as an evaluator for [rsvpdate].\n\n[speaker_evaluator]\n\n[evaluation_links]\n\n[tmlayout_intros]\n\n\n\n[wpt_speakers]\n\nEvaluation Team:\n\n[wpt_evaluators]\n\n[wpt_general_evaluator]\n\nAgenda:\n[wptagendalink]\n\n[wpt_tod] ");
$template_forms['General Evaluator'] = array('subject' => 'You are signed up as General Evaluator for [rsvpdate]','body' => "You are signed up as General Evaluator for [rsvpdate].\n\n[speaker_evaluator]\n\n[evaluation_links]\n\n[wpt_speakers]\n\nEvaluation Team:\n\n[wpt_evaluators]\n\nAgenda:\n[wptagendalink]\n\n[wpt_tod] ");
$template_forms['norole'] = array('subject' => 'Meeting Reminder for [rsvpdate]','body' => "[wpt_open_roles]\n\n[tmlayout_main]\n\n[wpt_tod]");
return $template_forms;
}

add_filter('rsvpmaker_notification_template_forms','wpt_notification_forms');

function wpt_notifications_doc () {
if(!get_option('wp4toast_reminders_cron'))
	printf('<p>Reminders not active - see <a href="%s">Settings -> Toastmasters</a></p>',admin_url('options-general.php?page=wp4toastmasters_settings'));
else	
	printf('<p>See a <a target="_blank" href="%s">preview</a> of the Toastmasters meeting reminders (based on the next meeting).</p>',site_url('?tm_reminders_preview'));
?>
<h3>Additional Codes for Toastmasters Agenda Notifications</h3>
<p>[wptrole] the member's meeting role</p>
<p>[wptagendalink] link to the meeting agenda</p>
<p>[wpt_tod] name and contact info for Toastmasters of the Day</p>
<p>[wp4t_assigned_open] agenda with contact info for participants, plus a listing of members with no assignment</p>
<p>[wpt_open_roles] open roles listing, with link to sign up</p>
<p>[tmlayout_main] same as info on printable agenda</p>
<p>[tmlayout_intros] speech introductions for speakers</p>
<p>[speaker_evaluator] listing of the speakers and evaluators</p>
<p>[evaluation_links] links to the online forms</p>
<p>[wpt_speakers] listing of speakers</p>
<p>[wpt_evaluators] listing of evaluators</p>
<p>[wpt_general_evaluator] general evaluator</p>
<p>[officer title="VP of Education"] name and contact info for the officer with the specified title (title must exactly match how it's specified on your settings page)</p>

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
		if(empty($userdata))
			$evaluator[$p] = $assigned;
		else	
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
if(empty($userdata))
{
	//might be a guest or member record removed
	$tmagendadata['wpt_evaluators'] .= sprintf('<div><strong>Evaluator: %s</strong></div>',$assigned);	
}
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

function wptagendalink () {
global $tmagendadata;
global $post;
if(isset($tmagendadata['wptagendalink']))
	return $tmagendadata['wptagendalink'];
$permalink = get_permalink($post->ID);
return $tmagendadata['wptagendalink'] = sprintf('%s<br /><a href="%s">%s</a>',__('Agenda','rsvpmaker-for-toastmasters'),$permalink,$permalink);
}

if(!function_exists('pre_print_test')) {
function pre_print_test ($var,$label,$return=false)
{
	$debug = '<pre>'.$label."\n".var_export($var,true).'</pre>';
	if($return)
		return $debug;
	echo $debug;
	
}
}

function no_shortcode_paragraphs($content) {
	return str_replace('<p[','[',str_replace(']</p>',']',$content));
}

function wpautop_for_toastmasters () {
	global $post;
	if(isset($post->post_type) && ($post->post_type == 'rsvpmaker') && is_wp4t())
	{
	remove_filter( 'the_content', 'wpautop' );
	add_filter( 'the_content', 'wpautop' , 1);
	add_filter('the_content','no_shortcode_paragraphs',2);
	}
}
add_action('wp','wpautop_for_toastmasters');

class role_history {

	public $full_history;
	public $recent_history;
	public $last_held_role;
	public $user_id;
	public $away_active;
	
function __construct($user_id,$start_date = '') { 
global $wpdb;
	$this->recent_history = array();
	$this->last_held_role = array();
	$this->user_id = $user_id;
	$start_date = (empty($start_date)) ? ' CURDATE() ' : " '$start_date' ";
	$recent_history_count = get_option('recent_history_count');
	if(empty($recent_history_count)) $recent_history_count = 3;
	$this->away_active = (int) get_user_meta($user_id,'status_expires',true);
	
	global $post;
	if($this->away_active && ($this->away_active < strtotime($start_date)))
		$this->away_active = 0; // only positive if expireation date set and not reached
	if(!empty($post->ID) && ! $this->away_active)
	{
		$absences = get_post_meta($post->ID,'tm_absence');
		if(!empty($absences) && in_array($user_id,$absences))
			$this->away_active = 1;
	}
	
	$sql = "SELECT DISTINCT $wpdb->posts.ID as postID, $wpdb->posts.post_title, a1.meta_value as datetime, date_format(a1.meta_value,'%Y-%m-%d') as ymddate, a2.meta_key as role
	 FROM ".$wpdb->posts."
	 JOIN ".$wpdb->postmeta." a1 ON ".$wpdb->posts.".ID =a1.post_id
	 JOIN ".$wpdb->postmeta." a2 ON ".$wpdb->posts.".ID =a2.post_id 
	 WHERE  a1.meta_key='_rsvp_dates' AND a1.meta_value < ".$start_date." AND post_status='publish' AND BINARY a2.meta_key RLIKE '^_[A-Z].+[0-9]$'  AND a2.meta_value=".$user_id." 
	 ORDER BY a1.meta_value DESC";
	
	$this->full_history = $wpdb->get_results($sql);
	if($this->full_history)
		foreach($this->full_history as $row) {
			$role = $this->clean_role($row->role);
			if(!isset($this->last_held_role[$role]))
				$this->last_held_role[$role] = $row->ymddate;
			if(sizeof($this->recent_history) < $recent_history_count)
				$this->recent_history[] = $role;
		}
	}

	function clean_role($role) {
	$role = preg_replace('/[0-9]/','',$role);
	$role = str_replace('_',' ',$role);
	return trim($role);
	}
	
	function get_eligibility($role) {
		if($this->away_active)
			return false;
		$role = $this->clean_role($role);
		$senior = array('Toastmaster of the Day','Evaluator','General Evaluator');
		if(in_array($role,$senior))
		{
		// check number of speeches
		if($this->get_speech_count() < 3)
			return false;
		}
		return ($this->get_held_recently($role)) ? false : true;
	}

	function get_speech_count () {
			global $wpdb;
			$sql = "SELECT count(*) FROM `$wpdb->usermeta` WHERE `meta_key` LIKE 'tm|Speaker%' AND user_id=".$this->user_id;
			return $wpdb->get_var($sql);
	}
	
	function get_held_recently($role)
	{
		$role = $this->clean_role($role);
		return (in_array($role,$this->recent_history)) ? true : false;
	}
	function get_last_held($role)
	{
		$role = $this->clean_role($role);
		if(isset($this->last_held_role[$role]))
			return date('M j Y',strtotime($this->last_held_role[$role]));
		else
			return '';
	}
}

function role_history_demo () {
	$users = get_users();
	foreach($users as $user) {
		$history = new role_history($user->ID,'2017-10-01');
		echo $user->user_login . '<br />';
		$test_roles = array('Speaker','Evaluator','Nonesuch');
		foreach($test_roles as $role) {
		echo '<h2>'.$role .'</h2><p>';
		if($history->get_eligibility($role))
			echo 'Elibible <br />';
		else
			echo 'Not eligible for role <br />';
		echo 'last held role '. $history->get_last_held($role) . '<br />';
		}
		echo 'speech count '. $history->get_speech_count() . '<br />';
		echo 'recent roles '. var_export($history->recent_history,true) . '</p>';
	}
}

function tm_goal_form () {
global $wpdb, $rsvp_options, $current_user;
$options = get_manuals_options();
?>
<h3>Set Goal (beta)</h3>
<form action="<?php echo admin_url(); ?>" method="post">
	<p><select name="tm_goal_manual"><?php echo $options; ?></select></p>
	<p>Completed After <input type="text" placeholder="Month day, Year" name="tm_goal_date" />
		<button>Submit</button></form>
<p>This is intended for setting a start date for goals such as earning a second Competent Communication award.</p>
<?php
$goals = get_user_meta($current_user->ID,'tm_manual_goal');
if(!empty($goals))
{
	$user_id = $current_user->ID;
	$sql = "SELECT * FROM `$wpdb->usermeta` WHERE user_id = $user_id AND meta_key LIKE 'tm|Speaker%' ORDER BY meta_key";//
	$results = $wpdb->get_results($sql);
	
foreach($goals as $goal)
	{
		$gp = explode(':',$goal);
		$goal_manual = $gp[0];
		$start = (int) $gp[1];
		printf('<p><strong>Goal: %s<br />after: %s</strong></h3>',$goal_manual,strftime($rsvp_options["long_date"],$start));
	if($results)
	foreach($results as $row)
		{
			$key_array = explode('|',$row->meta_key);
			$role = $key_array[1];
			$event_date = $key_array[2];
			$rolecount = $key_array[3];
			$domain = $key_array[4];
			$post_id = $key_array[5];
			$t = strtotime($event_date);
			if($t < $start)
				continue;
			$roledata = unserialize($row->meta_value);
			$manual = (empty($roledata['manual'])) ? 'Other' : $roledata['manual'];
			if($manual != $goal_manual)
				continue;
			
				if(empty($roledata['project']))
					$speech_details = 'Project not specified';
				else
					{
					$project_text = get_project_text($roledata['project']);
					$speech_details = $manual .': '.$project_text;
					if(empty($project_text))
						$speech_details = $roledata['project'];
					}
				if(!empty($roledata['title']))
					$speech_details .= '<br />'.$roledata['title'];
				if($domain != $_SERVER['SERVER_NAME'])
					$speech_details .= '<br /><em>'.$domain.'</em>';

				$speech_details = '<p>'.strftime($rsvp_options["long_date"],strtotime($event_date)).'<br />'.$speech_details.'</p>';
			echo $speech_details;
		}

	}
	
} // goals output
	
}
function tm_goal_save () {
	global $current_user;
	if(empty($_POST['tm_goal_date']) || empty($_POST['tm_goal_manual']))
		return;
	add_user_meta($current_user->ID,'tm_manual_goal',$_POST['tm_goal_manual'].':'.strtotime($_POST['tm_goal_date']));
}

add_action('admin_init','tm_goal_save');

function rsvptoast_showbutton ($showbutton) {
if(isset($_GET['recommend_roles']) || isset($_GET['edit_roles']))
	return true;
else
	return $showbutton;
}

add_filter('rsvpmaker_showbutton','rsvptoast_showbutton');

function tm_absence ($atts) {
	if(is_admin() && isset($_GET['convert']))
	{
		$show = (empty($atts['show_on_agenda'])) ? 0 : 1;
		return '<!-- wp:wp4toastmasters/absences {"show_on_agenda":"'.$show.'"} /-->';		
	}
	if(is_admin())
		return;
	if(empty($atts['show_on_agenda']) && (isset($_GET['print_agenda']) || isset($_GET['email_agenda'])))
		return;
	if(!is_user_member_of_blog())
		return '<div><strong>Planned Absences</strong> - Only displayed for logged in members of this site</div>';
	global $post;
	global $current_user;
	global $wpdb;
	global $rsvp_options;
	$output = '';
	if(isset($_POST['absences']))
		foreach($_POST['absences'] as $a)
			if(!empty($a))
				add_post_meta($post->ID,'tm_absence',$a);
	if(isset($_POST['cancel_absences']))
		foreach($_POST['cancel_absences'] as $a)
			if(!empty($a))
				delete_post_meta($post->ID,'tm_absence',$a);
	if(isset($_POST['add_absence']))
		add_post_meta($post->ID,'tm_absence',$current_user->ID);
	if(isset($_POST['cancel_absence']))
		delete_post_meta($post->ID,'tm_absence',$current_user->ID);
	$absences = get_post_meta($post->ID,'tm_absence');
	if(is_array($absences))
		$absences = array_unique($absences);

	if(isset($_GET['edit_roles']) || isset($_GET['recommend_roles']) || isset($_GET['signup_sheet_editor']) )
	{
	if(!empty($absences) && is_array($absences))
	{
		$output .= '<div><strong>Planned Absences</strong> : ';
		foreach($absences as $absent)
		{
			$userdata = get_userdata($absent);
			$output .= sprintf('<div id="current_absences%s%s">%s %s <input type="checkbox" id="absences_remove%d" class="absences_remove" name="cancel_absences[]" post_id="%s" value="%d" /> Cancel</div>',$post->ID,$absent,$userdata->first_name,$userdata->last_name, $absent, $post->ID, $absent);
		}
		$output .= '</div>';
	}
	$output .= '<div>Add to Planned Absences list</div>';
	for ($i = 0; $i < 4; $i++)
		{
			$select = awe_user_dropdown ('absences[]', 0, true);
			$select = str_replace('<select ','<select id="absences'.$i.$post->ID.'" class="absences" post_id="'.$post->ID.'"',$select);
			$output .= sprintf('<div>%s</div>',$select);
		}
	$output .= '<div id="status_absences'.$post->ID.'"></div>';
	return $output;
	}

	if(!empty($absences) && is_array($absences))
	{
		$output .= '<div><strong>Planned Absences</strong>: ';
		foreach($absences as $absent)
		{
			$userdata = get_userdata($absent);
			if(!empty($userdata->first_name))
			$output .= sprintf('<br />%s %s',$userdata->first_name,$userdata->last_name);
		}
		
		$output .= '</div>'; 
	}
		$time = strtotime(get_rsvp_date($post->ID));
		$away = '';
		$blogusers = get_users( 'blog_id='.get_current_blog_id() );
		// Array of WP_User objects.
		foreach ( $blogusers as $user ) {
			$exp = get_user_meta($user->ID,'status_expires',true);
			if(empty($exp))
				continue;
			if($exp < $time)
			{
			delete_user_meta($user->ID,'status_expires');
			delete_user_meta($user->ID,'status');			
			}
			else
			{
			$status = get_user_meta($user->ID,'status',true);
			if(!empty($status))
				{
				$userdata = get_userdata($user->ID);
				$away .= '<br />'.$userdata->first_name.' '.$userdata->last_name.' '.$status.sprintf(' (Expires: %s)',strftime($rsvp_options['long_date'],$exp));
				}
			}
		}
	
		if(!empty($away))
		$output .= '<div><strong>Away Messages:</strong>'.$away.'</div>';
		
	if(isset($_GET['print_agenda']) || isset($_GET['email_agenda'])   || isset($_GET['signup_sheet_editor']))
		return $output; //don't display button
	   
	if(!empty($absences) && is_array($absences) && in_array($current_user->ID,$absences))
		$output .= sprintf('<form method="post" action="%s"><input type="hidden" name="cancel_absence" value="1"><button>Cancel My Absence </button></form>',get_permalink());
	else
		$output .= sprintf('<form method="post" action="%s"><input type="hidden" name="add_absence" value="1"><button>Planned Absence </button></form>',get_permalink());

	$output .= sprintf('<p>%s <a href="%s">Away Message</a> %s</p>',__('Click here to mark yourself unavailable for this specific meeting. Or, if you will be away for several weeks, you can set an ','rsvpmaker-for-toastmasters'),admin_url('profile.php?page=wp4t_set_status_form'),__('with an expiration date','rsvpmaker-for-toastmasters'));

return $output;
}

function toastmasters_init () {
	global $wpdb;
	if(isset($_REQUEST['tm_ajax']))
	{
	$aj = $_REQUEST['tm_ajax'];
	if($aj == 'role')
		{
		$user_id = $_POST['user_id'];
		$role = $_POST['role'];
		$post_id = $_POST['post_id'];
		$check = $_POST['check'];
		if(!wp_verify_nonce($check,$role))
			die('Security error: '.var_export($_REQUEST, true));
		
		update_post_meta($post_id,$role,$user_id);
		if(strpos($role,'Speaker'))
		{
			update_post_meta($post_id,'_manual'.$role,strip_tags($_POST["_manual"][$role]));
			update_post_meta($post_id,'_project'.$role,strip_tags($_POST["_project"][$role]));
			update_post_meta($post_id,'_title'.$role,strip_tags(stripslashes($_POST["_title"][$role])));
			update_post_meta($post_id,'_intro'.$role,strip_tags(stripslashes($_POST["_intro"][$role]),'<p><br><strong><em><a>'));
		}
		$o = 'Assigned to: '.get_member_name($user_id);
		foreach($_POST as $name => $value)
		{
			if(($name == 'user_id') || ($name == 'post_id') || ($name == 'check')  || ($name == 'editor_assign')  )
				continue;
			if(is_array($value))
			{
				foreach($value as $v)
					$showv = strip_tags(stripslashes($v),'<p><br><strong><em><a>');				
			}
			else
				$showv = $value;
			
		if(!empty($showv))
		{
		if(strpos($name,'project'))
			$showv = get_project_text($showv);
		$o .= '<br />'.clean_role($name).': '.clean_role($showv);
		}
	
		}
		$actiontext = __("signed up for",'rsvpmaker-for-toastmasters').' '.clean_role($role);
		do_action('toastmasters_agenda_notification',$post_id,$actiontext,$user_id);
		awesome_wall($actiontext,$post_id);
		$date = get_rsvp_date($post_id);
		
		$startfrom = " '$date' ";

		$sql = "SELECT DISTINCT $wpdb->posts.ID as postID, $wpdb->posts.*, a1.meta_value as datetime, a1.meta_value as datetime, date_format(a1.meta_value,'%M %e, %Y') as date
		 FROM ".$wpdb->posts."
		 JOIN ".$wpdb->postmeta." a1 ON ".$wpdb->posts.".ID =a1.post_id AND a1.meta_key='_rsvp_dates'
		 WHERE a1.meta_value > ".$startfrom." AND post_status='publish' AND (post_content LIKE '%role=%' OR post_content LIKE '%wp:wp%') ORDER BY a1.meta_value ";
		$next = $wpdb->get_row($sql);
		if($next && !isset($_REQUEST['editor_assign']))
		$o .= sprintf('<p>Would you also like to sign up for <a href="%s">%s</a>?</p>',get_permalink($next->ID),$next->date);

		die($o);
		}
	elseif($aj == 'remove_role')
		{
		$check = $_POST['check'];
		$role = $_POST["remove_role"];
		if(!wp_verify_nonce($check,'remove'.$role))
			die('Security error');
		$user_id = $_POST['user_id'];
		$post_id = $_POST['post_id'];
		delete_post_meta($post_id,$role);
		if(strpos($role,'peaker') )
			{
			delete_post_meta($post_id,'_manual'.$role);
			delete_post_meta($post_id,'_project'.$role);
			delete_post_meta($post_id,'_title'.$role);
			delete_post_meta($post_id,'_intro'.$role);
			}
		$actiontext = __("withdrawn: ",'rsvpmaker-for-toastmasters').' '.clean_role($role);
		do_action('toastmasters_agenda_notification',$post_id,$actiontext,$user_id);
		awesome_wall("withdrawn: ".clean_role($role),$post_id);		
		die($actiontext);
		}	
	die('ajax command not found');
	}	
}

add_action('init','toastmasters_init');

add_action('rsvpmaker_template_list_top','rsvpmaker_template_list_top_wpt');

function rsvpmaker_template_list_top_wpt () {
	global $wpdb;
	global $rsvp_options;
	
	if(!function_exists('do_blocks'))
		return;
		
$sql = "SELECT DISTINCT $wpdb->posts.*, meta_value as sked FROM $wpdb->posts JOIN $wpdb->postmeta ON $wpdb->postmeta.post_id = $wpdb->posts.ID WHERE meta_key='_sked' AND $wpdb->posts.post_content LIKE '%role=%' AND $wpdb->posts.post_status = 'publish' GROUP BY $wpdb->posts.ID ORDER BY post_title";
	
$results = $wpdb->get_results($sql);
if ( $results ) {
if(isset($_GET['convert']))
	{
	foreach($results as $row) {
		if(strpos($row->post_title,'old format'))
			continue;
		$backuptitle = '(backup) '.$row->post_title;
		$newcode = str_replace("</p>\n<p>","\n",do_shortcode($row->post_content));
		$update['ID'] = $row->ID;
		$update["post_type"] = 'rsvpmaker';
		$update["post_title"] = $row->post_title;
		$update["post_content"] = $newcode;
		$update["post_author"] = $row->post_author;
		$update["post_status"] = 'publish';
		wp_insert_post($update);
		
		$back["post_type"] = 'rsvpmaker';
		$back["post_title"] = $backuptitle;
		$back["post_content"] = $row->post_content;
		$back["post_author"] = $row->post_author;
		$back["post_status"] = 'draft';
		$back_id = wp_insert_post( $back );
		$sked = unserialize($row->sked);
		add_post_meta($back_id,'_sked',$sked);
		printf('<p>Updating %s <a href="%s">(Edit)</a>, backup saved as draft</p>',$row->post_title,admin_url('post.php?action=edit&post='.$row->ID));		
	}
	update_option('wpt_template_convert',1);
	}
	elseif(empty($_GET['t'])) {
		echo '<h1>Convert to New Editor Format?</h1><p>Your meeting templates must be converted to display properly in the new WordPress editor. A backup copy will be saved. <a href="'.admin_url('edit.php?post_type=rsvpmaker&page=rsvpmaker_template_list&convert=1').'">Convert Now</a></p>';
		foreach($results as $row) 
			printf('<p><em>Old format:</em> %s</p>',$row->post_title);		
	}
} //end if results
	
}

function agenda_note_convert($atts,$content) {
	if(!empty($atts['editable']))
		return '<!-- wp:wp4toastmasters/agendaedit {"editable":"'.$atts['editable'].'"} /-->';
	if($atts['agenda_display'] == 'web')
		return '<!-- wp:wp4toastmasters/signupnote -->
<p class="wp-block-wp4toastmasters-signupnote">'.trim($content).'</p>
<!-- /wp:wp4toastmasters/signupnote -->';
	elseif($atts['agenda_display'] == 'both')
		return '<!-- wp:paragraph -->
<p>'.trim($content).'</p>
<!-- /wp:paragraph -->';
	else
	{
	if(empty($atts["time_allowed"]))
		$atts["time_allowed"] = '';
	$u = rand();
	return '<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"'.$atts["time_allowed"].'","uid":"note'.$u.'"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">'.trim(strip_tags($content)).'</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->';
	}
}

function toastmaster_short_convert($atts) {
	
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

if(!in_array($atts['role'],$toast_roles))
{
	$atts['custom_role'] = $atts['role']; 
	$atts['role'] = 'custom';
}	
	return '<!-- wp:wp4toastmasters/role '.json_encode($atts).' /-->';
}

function wpt_embed_agenda ($atts) {
	if(isset($atts["id"]))
		$id = $atts["id"];
	else
	{
	$f = future_toastmaster_meetings(1);
	if(empty($f))
		return;
	$id = $f[0];	
	}
	$permalink = get_permalink($id);
	$permalink .= (strpos($permalink,'?')) ? '&' : '?';
	$style = (empty($atts['style'])) ? 'height: 1000px; width: 100%;' : $atts['style'];
	return sprintf('<iframe src="%sprint_agenda=1&no_print=1" style="%s"></iframe>',$permalink,$style);
}


function agenda_note_upgrade_helper($matches) {
	if(empty($matches[1]))
		$props = '{"uid":"note'.rand().'"}';
	else
	{
		$props = $matches[1];
		if(!strpos($props,'"uid"'))
			$props = str_replace('}',',"uid":"note'.rand().'"}',$props);
		$props = str_replace(',"className":"wp-block-wp4toastmasters-agendanoterich"','',$props);
	}	
	
	return sprintf('<!-- wp:wp4toastmasters/agendanoterich2 %s -->
<p class="wp-block-wp4toastmasters-agendanoterich2">%s</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->',$props,trim(strip_tags($matches[0],'<strong><em><a>')));
}	

if(strtotime('2018-12-31') > time())
	add_action('admin_init','agenda_note_upgrade');

function agenda_note_upgrade() {
	if(!empty($_SESSION['did_agenda_note_upgrade']))
		return;
	$_SESSION['did_agenda_note_upgrade'] = 1;
	global $wpdb;
	$f = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE (post_content LIKE '%wp4toastmasters/agendanoterich %' OR post_content LIKE '%wp4toastmasters/agendanote%') AND post_type='rsvpmaker' ");
	//echo '<div>check agendas '.var_export($f,true).'</div>';
	if(empty($f))
		return;
	foreach($f as $r)
	{
	$content = $r->post_content;
	$content = preg_replace_callback('/\<.+wp\:wp4toastmasters\/agendanoterich ({[^}]+})[^<]+<p[^>]+>.+<\/p>[^<]+<!-- \/wp:wp4toastmasters\/agendanoterich -->/','agenda_note_upgrade_helper',$content);

	$pattern = '/<!-- wp:wp4toastmasters\/agendanote ({[^}]+}){0,1}[^!]+!-- \/wp:wp4toastmasters\/agendanote -->/s';
	$content = preg_replace_callback($pattern,'agenda_note_upgrade_helper',$content);
	$sql = $wpdb->prepare("UPDATE $wpdb->posts SET post_content=%s WHERE ID=%d",$content,$r->ID);
	$wpdb->query($sql);
	}
}


register_deactivation_hook( __FILE__, 'wptoast_deactivation' );
  
function wptoast_deactivation() {
    wp_clear_scheduled_hook( 'wp4toast_reminders_cron' );
    wp_clear_scheduled_hook( 'wp4toast_reminders_dst_fix' );
}

function tm_branded_image($att) {
	if(is_array($att))
		$image = $att["image"];
	else
		$image = $att;
	//if($image=='agenda-rays.png')
		return '<img src="https://toastmost.org/tmbranding/agenda-rays.png" />';
		
if(isset($_GET['reset']))
	delete_option($image);
	
if(strpos($_SERVER['SERVER_NAME'],'toastmost.org'))
	$newurl = 'https://toastmost.org/tmbranding/'.$image;
else
	$newurl = get_option($image);
	
if(isset($_GET['retrieve']))
	{
	$wp_upload_dir = wp_upload_dir();
	$url = 'http://toastmost.org/tmbranding/'.$image;
	$file_path = $wp_upload_dir["path"].'/'.$image;
	$newurl = $wp_upload_dir['url'] . '/' .$image;
	$myhttp = new WP_Http();
	$result = $myhttp->get($url, array('filename' => $file_path, 'stream' => true));
	if(is_wp_error($result))
		{
			printf('<div class="error">%s: %s</div>',__('Error retrieving','lectern'),$url);
			return;
		}
	
	// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	
	$parent_post_id = 0;
	
	// Check the type of file. We'll use this as the 'post_mime_type'.
	$filetype = wp_check_filetype( basename( $file_path ), null );
	
	// Prepare an array of post data for the attachment.
	$attachment = array(
		'guid'           => $newurl, 
		'post_mime_type' => $filetype['type'],
		'post_title'     => preg_replace( '/\.[^.]+$/', '', $basename ),
		'post_content'   => '',
		'post_status'    => 'inherit'
	);
	
	// Insert the attachment.
	$attach_id = wp_insert_attachment( $attachment, $file_path, $parent_post_id );
	
	// Generate the metadata for the attachment, and update the database record.
	$attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );
	wp_update_attachment_metadata( $attach_id, $attach_data );
	update_option($image,$newurl);
}
if(empty($newurl))
{
return sprintf('If you are authorized to use the Toastmasters logo, <a href="%s">click to download</a>.',add_query_arg('retrieve','1',site_url($_SERVER['REQUEST_URI'])));	
}
elseif($image == 'agenda-rays.png')
	return '<img src="'.$newurl.'" width="700" height="79">';
elseif($image == 'toastmasters-75.png')
	return '<img src="'.$newurl.'" width="75" height="65">';
}

function edit_signups_role($post_id = 0)
{
	global $post, $current_user;
	if(!$post_id)
		$post_id = $post->ID;
	$signup_roles = get_option('edit_signups_meeting_roles');
	if(empty($signup_roles) || !is_array($signup_roles))
		return false;
	foreach($signup_roles as $role => $key) {
		$hit = (int) get_post_meta($post_id,$key,true);
		if($current_user->ID == $hit)
			{
				return true;
			}
	}
	return false;
}

function wpt_contributor_notification ($new_status, $old_status, $post) {
		if ( ( $new_status != $old_status ) && ($new_status == 'pending') ) {
		global $current_user;
		$result = '';
		$contributor_notification = get_option('wpt_contributor_notification');
			if(empty($contributor_notification))
				$contributor_notification = get_option('admin_email');
				$emails = explode(',',$contributor_notification);
				foreach($emails as $email)
				{
					$email = trim($email);
					if(is_email($email))
						{
							mail($email,'Contributor Post: '.$post->post_title,admin_url('post.php?action=edit&post='.$post->ID),'From: '.$current_user->user_email);
						}
				}
			}
}

add_action(  'transition_post_status',  'wpt_contributor_notification', 10, 3 );

function wp4t_cron_nudge_setup () {
	wp_unschedule_hook('wp4t_reminders_nudge');
	wp_schedule_event( strtotime('tomorrow 1 am'), 'daily', 'wp4t_reminders_nudge' );
}
add_action('wp4t_reminders_nudge','wp4t_reminders_nudge');
function wp4t_reminders_nudge () {
	$temp = get_option('wp4toast_reminder');
	if(!empty($temp))
	$reminders[] = $temp;
	$temp = get_option('wp4toast_reminder2');
	if(!empty($temp))
	$reminders[] = $temp;
	if(empty($reminders))
		return;
	fix_timezone();
	wptoast_reminder_clear();
	$future = future_toastmaster_meetings(5);
	foreach($future as $meeting) {
		//print_r($meeting);
		$time = $meeting->datetime;
		foreach($reminders as $hours)
		{
			$string = $time.' -'.$hours;
			printf('<p>%s</p>',$string);
			$timestamp = strtotime($string);
			printf('<h3>%s %s</h3>',$time,date('r',$timestamp));
			$hours = trim(str_replace('hours','',$hours));
			if($timestamp > time())
			{
				$result = wp_schedule_single_event( $timestamp, 'wp4toast_reminders_cron', array( $hours ) );
				rsvpmaker_debug_log($result,"wp_schedule_single_event( $timestamp, 'wp4toast_reminders_cron', array( $hours ) )");
			}
			
		}
	}
}

if(!wp_is_json_request()) {
	add_shortcode('wpt_open_roles','wpt_open_roles');
	add_shortcode('contest_demo','contest_demo');
	add_shortcode( 'agenda_role', 'toastmaster_short' );
	add_shortcode( 'toastmaster', 'toastmaster_short' );
	add_shortcode( 'agenda_note', 'agenda_note' );
	add_shortcode('officer','toastmasters_officer_single');
	add_shortcode( 'toastmaster_officers', 'toastmaster_officers' );
	add_shortcode('stoplight','stoplight_shortcode');
	add_shortcode('awesome_members','awesome_members');
	add_shortcode('signup_sheet','signup_sheet');
	add_shortcode('themewords','themewords');
	add_shortcode('jstest','jstest');
	add_shortcode('club_news','club_news');
	add_shortcode('members_only','members_only');
	add_shortcode('tmlayout_club_name','tmlayout_club_name');
	add_shortcode('tmlayout_tag_line','tmlayout_tag_line');
	add_shortcode('tmlayout_meeting_date','tmlayout_meeting_date');
	add_shortcode('tmlayout_sidebar','tmlayout_sidebar');
	add_shortcode('tmlayout_main','tmlayout_main');
	add_shortcode('tmlayout_intros','speech_intros_shortcode');
	add_shortcode('wpt_officers','wpt_officers');
	add_shortcode('speaker_evaluator','speaker_evaluator');
	add_shortcode('evaluation_links','evaluation_links');
	add_shortcode('wpt_speakers','wpt_speakers');
	add_shortcode('wpt_evaluators','wpt_evaluators');
	add_shortcode('wpt_general_evaluator','wpt_general_evaluator');
	add_shortcode('wpt_tod','wpt_tod');
	add_shortcode('wptagendalink','wptagendalink');
	add_shortcode('wp4t_assigned_open','wp4t_assigned_open');
	add_shortcode('role_history_demo','role_history_demo');
	add_shortcode('tm_absence','tm_absence');
	add_shortcode('wpt_embed_agenda','wpt_embed_agenda');
	add_shortcode('tm_branded_image','tm_branded_image');
	add_shortcode('tm_member_application','tm_member_application');				
}

add_action('wp_head','wpt_richtext');
function wpt_richtext() {
global $post;
if($post->post_type != 'rsvpmaker')
	return;
if(!strpos($post->post_content,'wp:wp4toastmasters') && !strpos($post->post_content,'agenda_role')  )
	return;

echo '<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
        tinymce.init({selector:"textarea",plugins: "code, link"});	
</script>';	
}

function rsvpmaker4t_deactivate() {
	wp_unschedule_hook('wp4toast_reminders_cron');
	wp_unschedule_hook('wp4toast_reminders_dst_fix');
	wp_unschedule_hook('wp4t_reminders_nudge');
}
register_deactivation_hook( __FILE__, 'rsvpmaker4t_deactivate' );
?>