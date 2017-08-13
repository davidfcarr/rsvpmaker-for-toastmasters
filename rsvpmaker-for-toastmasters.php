<?php
/*
Plugin Name: RSVPMaker for Toastmasters
Plugin URI: http://wp4toastmasters.com
Description: This Toastmasters-specific extension to the RSVPMaker events plugin adds role signups and member performance tracking. Better Toastmasters websites!
Author: David F. Carr
Version: 2.6.4
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

function get_member_name($user_id, $credentials = true) {
	if(!is_numeric($user_id))
		return $user_id; // guest ?
	if($user_id == 0)
		return 'Open';
	elseif($user_id == -1)
		return 'Not Available';
	$member = get_userdata($user_id);
	$name = $member->first_name.' '.$member->last_name;
	if($credentials && !empty($member->education_awards))
		$name .= ', '.$member->education_awards;
	return $name;
}

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
$wp4toastmasters_mailman = get_option('wp4toastmasters_mailman');
$wp4toastmasters_member_message = get_option('wp4toastmasters_member_message');
if(!empty($wp4toastmasters_member_message))
	$wp4toastmasters_member_message = wpautop($wp4toastmasters_member_message);

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
			  }

?>
</table>
<?php

$link = get_rsvpmaker_archive_link();
printf('<p><a href="%s">%s</a></p>',$link,__('View future events'));

if(!empty($upcoming_roles))
{
	printf('<h3>%s</h3>
%s',__('Upcoming Roles','rsvpmaker-for-toastmasters'),$upcoming_roles);					
}

?>
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

function toastmasters_admin_widget () {
?>
<p><strong><a class="wp-first-item" href="admin.php?page=toastmasters_screen">Toastmasters</a></strong> - Reports and Tools for Updating Speech and Role Records</p>
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
</ul>

<?php
if(current_user_can('manage_options'))
{
?>
<p><strong>Appearance</strong></p>
<ul>
 	<li id="menu-posts-rsvpmaker"><a class="hide-if-no-customize" href="customize.php">Customize</a> - tweak website design</li>
 	<li><a href="widgets.php">Widgets</a> - add/update sidebar widgets</li>
 	<li><a href="nav-menus.php">Menus</a> - update menu of pages, other links</li>
</ul>
<?php
}
if(current_user_can('add_members'))
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
	unset($normal_dashboard['toastmasters_admin_widget']);
	$wp_meta_boxes['dashboard']['side']['core'] = array_merge($sidebar_widget_backup,$side_dashboard);
	}
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
if(isset($_GET["reorder"]))
	return; // not needed in this context	
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
			$editable = '<div class="agenda_note_editable"><textarea name="agenda_note[]" rows="5" cols="80" class="mce">'.$editable.'</textarea><input type="hidden" name="agenda_note_label[]" value="agenda_note_'.$atts["editable"].'" /></div>';
			$display = 'both';
			}
		elseif(empty($editable) && is_club_member() && current_user_can('edit_signups') && !isset($_GET["print_agenda"]) && !isset($_GET["email_agenda"]))
			{
			$permalink = get_permalink($post->ID);
			$permalink .= (strpos($permalink,'?')) ? '&edit_roles=1' : '?edit_roles=1'; 
			$editable = sprintf('%s %s %s <a href="%s">%s</a>',__('To add','rsvpmaker-for-toastmasters'),$atts["editable"],__('content, switch to ','rsvpmaker-for-toastmasters'),$permalink, __('Edit Signups mode'));
			}
		elseif(empty($editable))
			$editable = __('Not set','rsvpmaker-for-toastmasters');
		$content .= '<h3>'.$atts["editable"].'</h3>'.wpautop($editable);
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

	if(isset($_GET["reorder"]))
		{
		if($count == 1)
			return;
		$output .= '<input type="hidden" id="post_id" value="'.$post->ID.'">';
		$output .= '<h3>'.$atts["role"].'</h3><ul id="'.$field_base.'" class="tmsortable sortable">';
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
			$output .= '<li class="sortableitem sortable_'.$field_base.'" id="'.$field.'" >'.$assignedto.'<input type="hidden" id="'.$field.'_assigned" value="'.$assigned.'"></li>';
			}
		$output .= '<li><div id="'.$field_base.'_sortresult" class="sortresult">'.__('Drag and drop assignments into the desired agenda order','rsvpmaker-for-toastmasters').'</div></li></ul>';
		return $output;
		}
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
		$enhanced_css = get_option('wp4toastmasters_agenda_enhanced_css');
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

			if ($enhanced_css == 1)
			    {
			        $output .= '<ul class="role-agenda-item-leader"><li><span>';
			    }
			 else
			    {
			        $output .= '<p>';
			    }

			// old style of time display
			if(isset($time) && is_array($time) && $time[$i - 1])
				$output .= '<em>'.$time[$i - 1].'</em> ';

			if(!empty($atts["time_allowed"]) && strpos($field,'Speaker'))
				{
					$speaktime += (int) get_post_meta($post->ID,'_maxtime'.$field,true);
				}
			$output .= '<strong>'.$atts["role"];
			if ($enhanced_css)
			    {
                if ( (strpos($field,'Speaker')) | (strpos($field,'Evaluator')) && $field != '_General_Evaluator_1')
                    {
                        $output .= ' '.$i;
                    }
			    }

            $output .= '</strong>';
			if ($enhanced_css == 1)
			    {
                if ( ( (strpos($field,'Evaluator')) ) && ($field != '_General_Evaluator_1'))  //add speaker after evaluator
                {
                    $speechfield = '_Speaker_'.$i;
                    $speakerID_to_be_evaluated = get_post_meta($post->ID, $speechfield, true);
                    $user_info = get_userdata($speakerID_to_be_evaluated);
                    $speaker_to_be_evaluated = $user_info -> first_name . ' ' . $user_info -> last_name;
                    $output .= '<span class = "evaluates"> evaluates '. $speaker_to_be_evaluated . '</span>';
                }
                $output .= '</span>';
                }
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
					if ($enhanced_css == 1)
					      {
					        $output .= sprintf(' <span class="member-role">%s</span></li></ul>', $name);
					      }
					 else
					      {
					        $output .= sprintf(' <span class="member-role">%s%s</span>', $name, $title);
					      }
				}
			else
				{
				if(isset($open[$atts["role"]]))
					$open[$atts["role"]]++;
				else
					$open[$atts["role"]] = 1;				
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
						$speaker_name = $member->first_name.' '.$member->last_name;
						if(!empty($member->education_awards)) $speaker_name .= ', '.$member->education_awards;
						}
					else
						$speaker_name = $speaker_id.' ('.__('guest','rsvpmaker-for-toastmasters').')';
					$note = str_replace('{Speaker}',$speaker_name,$note);
					}
				$output .=  "<br /><em>".$note."</em>";
				}
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
					$speaker_name = $member->first_name.' '.$member->last_name;
					if(!empty($member->education_awards)) $speaker_name .= ', '.$member->education_awards;
					}
				else
					$speaker_name = $speaker_id.' ('.__('guest','rsvpmaker-for-toastmasters').')';
				$note = str_replace('{Speaker}',$speaker_name,$note);
				}
			$output .=  "<div><em>".$note."</em></div>";
			}

		if(is_club_member() && !(isset($_GET["edit_roles"]) || isset($_GET["recommend_roles"]) || (isset($_GET["page"]) && ($_GET["page"] == 'toastmasters_reconcile') ) )  ) 
				$output .= '</form>';


			$output .= '</div></div><!-- end role block -->';			
			} //end for loop

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
		if(isset($_GET["end"]))
			$start_time .= '-'.strftime($rsvp_options["time_format"],$time_count);
		return $start_time;
	}

add_shortcode( 'agenda_role', 'toastmaster_short' );
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
$enhanced_css = get_option('wp4toastmasters_agenda_enhanced_css');

if ($enhanced_css == 1)
    {
        $buffer = "\n<div class=\"officers\">"; //.$label.": ";
    }
else
    {
        $buffer = "\n<div class=\"officers\"><strong>".$label."</strong>"; //.$label.": ";
    }
if(is_array($wp4toastmasters_officer_ids))
{
foreach ($wp4toastmasters_officer_ids as $index => $officer_id)
	{
		if(!$officer_id)
			continue;
		$officer = get_userdata($officer_id);
		$title = str_replace(' ','&nbsp;',$wp4toastmasters_officer_titles[$index]);
		if ($enhanced_css == 1)
		    {
		        $buffer .= sprintf('<div class="officer_entity"><p>%s<officertitle>%s</officertitle><br><officer>%s&nbsp;%s</officer>&nbsp;<educationawards>%s</educationawards></p></div>',$sep,$title,$officer->first_name,$officer->last_name, $officer->education_awards);
		    }
		else
		    {
		        $buffer .= sprintf('%s<em>%s</em>&nbsp;%s&nbsp;%s',$sep,$title,$officer->first_name,$officer->last_name);
		    }
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
			delete_post_meta($post_id,'_display_time'.$role);
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
		$edit_log = array();
		foreach($_POST["editor_assign"] as $role => $user_id)
		{
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
		
	if(!empty($edit_log))
		add_post_meta($post_id,'_activity_editor',implode('<br />',$edit_log));
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
			update_user_meta($user_id,'current_manual',$manual);
			update_post_meta($post_id,'_manual'.$basefield,$manual);
			update_post_meta($post_id,'_title'.$basefield,$title);
			update_post_meta($post_id,'_project'.$basefield,$project);
			if(isset($_POST["_display_time"][$basefield]))
				update_post_meta($post_id,'_display_time'.$basefield,$display_time);
			if(isset($_POST["_maxtime"][$basefield]))
				update_post_meta($post_id,'_maxtime'.$basefield,$time);
			if(isset($_POST["_intro"][$basefield]))
				update_post_meta($post_id,'_intro'.$basefield,$intro);
			do_action('save_speaker_extra',$post_id,$basefield);
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
	$enhanced_css = get_option('wp4toastmasters_agenda_enhanced_css');
	$manual = get_post_meta($post->ID, '_manual'.$field, true);
	$project_index = get_post_meta($post->ID, '_project'.$field, true);
	if(!empty($project_index))
		{
		$project = get_project_text($project_index);
		$dt = get_post_meta($post->ID, '_display_time'.$field, true);
		if(empty($dt))
			{
			$timing = get_projects_array('display_times');
			$dt = (isset($timing[$project_index])) ? $timing[$project_index] : '';
			}
		if(!empty($dt))
			$project .= ' ('.$dt.')';
		$manual .= ': '.$project;
		if ($enhanced_css == 1)
		    {
		        $manual = ucwords(strtolower($manual));
				$title = get_post_meta($post->ID, '_title'.$field, true);
		    }
		}
	if ($enhanced_css == 1)
		{
            $output = ($manual && !strpos($manual,'Manual /') ) ? '<div id="manual">'.$manual."</div>" : "";
            $output = '<div class="speaker-details">'.$output.'<div id="title">"'.$title.'"</div></div>'."\n";
	    }
	else
	    {
            $output = ($manual && !strpos($manual,'Manual /') ) ? '<div class="manual"><strong>'.$manual."</strong></div>" : "\n";
            $output = "\n".'<div class="speaker-details">'.$output.'</div>'."\n";
	    }
	return apply_filters('speaker_details_agenda',$output,$field);
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
		$output .= '<div id="_tmsg_'.$field.'"></div></div>';
		$display_time = get_post_meta($post->ID, '_display_time'.$field,true);
		$output .= '<div class="time_required">Timing: <input type="text"class="speaker_details" name="_display_time['.$field.']" id="_display_time_'.$field.'" size="10" value="'.$display_time.'">';
		$output .= ' Maximum Time: <input type="text"class="speaker_details '.$maxclass.'" name="_maxtime['.$field.']" id="_maxtime_'.$field.'" size="4" value="'.$time.'"></div>';

		$title = get_post_meta($post->ID, '_title'.$field, true);
		$output .= '<div class="speech_title">Title: <input type="text" class="speaker_details title_text" id="title_text'.$field.'" name="_title['.$field.']" value="'.$title.'" /></div>';
		$intro = get_post_meta($post->ID, '_intro'.$field, true);
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
		return apply_filters('speech_details_public',$output,$field);
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
$mm = get_option('wp4toastmasters_mailman');

if(!empty($_POST["guestlist"]))
	{
	foreach($_POST["guestlist"] as $email)
		{
			add_to_mailman($email,'g');
		}
	printf('<p>Attempted to add %s email addresses to guest list. Verify by visiting <a href="%s">%s</a>, password: %s</p>',sizeof($_POST["guestlist"]),$mm["gpath"],$mm["gpath"],$mm["gpass"]);
	}

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
				{
				$former_list .= $userdata["user_email"].", ";
				$f_email[] = $userdata["user_email"];
				}
			if(isset($_GET['guests_only']))
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
		add_to_mailman($user_id,'o');
	}
}

?>

<h3><?php _e("Officer Email List",'rsvpmaker-for-toastmasters');?></h3>
<p><?php _e("List email address",'rsvpmaker-for-toastmasters');?>: <input type="text" name="wp4toastmasters_mailman[officers]" value="<?php if(isset($wp4toastmasters_mailman["officers"])) echo $wp4toastmasters_mailman["officers"]; ?>" /></p>
<p><?php _e("Path",'rsvpmaker-for-toastmasters');?>: <input type="text" name="wp4toastmasters_mailman[opath]" value="<?php if(isset($wp4toastmasters_mailman["opath"])) echo $wp4toastmasters_mailman["opath"]; ?>" /> <?php _e("Password",'rsvpmaker-for-toastmasters');?>: <input type="text" name="wp4toastmasters_mailman[opass]" value="<?php if(isset($wp4toastmasters_mailman["opass"])) echo $wp4toastmasters_mailman["opass"]; ?>" />

<?php if(isset($wp4toastmasters_mailman["opass"])) {
	printf('<p><a href="%s&mailman_add_officers=1">'.__("Update officers mailing list",'rsvpmaker-for-toastmasters').'</a></p>',admin_url('options-general.php?page=wp4toastmasters_settings'));
	}
?>

<h3><?php _e("Guest Email List",'rsvpmaker-for-toastmasters');?></h3>
<p><?php _e("List email address",'rsvpmaker-for-toastmasters');?>: <input type="text" name="wp4toastmasters_mailman[guest]" value="<?php if(isset($wp4toastmasters_mailman["guest"])) echo $wp4toastmasters_mailman["guest"]; ?>" /></p>
<p><?php _e("Path",'rsvpmaker-for-toastmasters');?>: <input type="text" name="wp4toastmasters_mailman[gpath]" value="<?php if(isset($wp4toastmasters_mailman["gpath"])) echo $wp4toastmasters_mailman["gpath"]; ?>" /> <?php _e("Password",'rsvpmaker-for-toastmasters');?>: <input type="text" name="wp4toastmasters_mailman[gpass]" value="<?php if(isset($wp4toastmasters_mailman["gpass"])) echo $wp4toastmasters_mailman["gpass"]; ?>" />

<?php
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

<h3><?php _e('Render CSS Enhancements','rsvpmaker-for-toastmasters'); ?></h3>
<?php $enhanced_css = get_option('wp4toastmasters_agenda_enhanced_css'); ?>
<p><input type="radio" name="wp4toastmasters_agenda_enhanced_css" value="1" <?php if($enhanced_css == 1) echo ' checked="checked" '; ?> /> <?php _e("Yes, implement CSS Enhancements",'rsvpmaker-for-toastmasters');?></p>
<p><input type="radio" name="wp4toastmasters_agenda_enhanced_css" value="0" <?php if($enhanced_css != 1) echo ' checked="checked" '; ?> /> <?php _e("No",'rsvpmaker-for-toastmasters');?>.</p>



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
	register_setting( 'wp4toastmasters-settings-group', 'wp4toastmasters_agenda_enhanced_css' );
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

function wpt_default_agenda_css() {
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
}';

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
			add_post_meta($layout_id,'_rsvptoast_agenda_css',wpt_default_agenda_css());
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
		$url = trailingslashit($wp4toastmasters_mailman[$list."path"])."members?findmember=".$email."&setmemberopts_btn&adminpw=".$wp4toastmasters_mailman[$list."pass"];
		$result = file_get_contents($url);
		if(!strpos($result, 'CHECKBOX') )
			{
			$url = trailingslashit($wp4toastmasters_mailman[$list."path"])."add?subscribe_or_invite=0&send_welcome_msg_to_this_batch=0&notification_to_list_owner=0&subscribees_upload=".$email."&adminpw=".$wp4toastmasters_mailman[$list."pass"];;
		$result = file_get_contents($url);
		if(!strpos($result, 'Successfully') )
			echo "<div>".__('Error attempting to subscribe','rsvpmaker-for-toastmasters')." $email</div>";
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

if(isset($_GET["unsubscribe"]))
	unsubscribe_mailman_by_email($_GET["unsubscribe"],$_GET["list"]);
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
	if(isset($_GET["rsvp"]))
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
		$link .= '<li"><a href="'.$permalink.'reorder=1">'.__('Reorder','rsvpmaker-for-toastmasters').'</a></li>';
		$link .= '<li"><a href="'.$permalink.'recommend_roles=1">'.__('Recommend','rsvpmaker-for-toastmasters').'</a></li>';
		$events = get_future_events("post_content LIKE '%[toastmaster%' ", 10);
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

	$template_id = get_post_meta($post->ID,'_meet_recur',true);

	if(current_user_can($security['agenda_setup']))
		{
		$agenda_menu[__('Agenda Setup','rsvpmaker-for-toastmasters')] = admin_url('post.php?action=edit&post='.$post->ID);
		if($template_id)
			$agenda_menu[__('Agenda Setup: Template','rsvpmaker-for-toastmasters')] = admin_url('post.php?action=edit&post='.$template_id);
		}
	if(current_user_can($security['edit_signups']))
		{		
		$agenda_menu[__('Agenda Timing','rsvpmaker-for-toastmasters')] = admin_url('edit.php?post_type=rsvpmaker&page=agenda_timing&post_id='.$post->ID);
		if($template_id && current_user_can($security['agenda_setup']))
			$agenda_menu[__('Agenda Timing: Template','rsvpmaker-for-toastmasters')] = admin_url('edit.php?post_type=rsvpmaker&page=agenda_timing&post_id='.$template_id);
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

	$link .= '<li class="last"><a  target="_blank" href="'.site_url('?signup2=1').'">'.__('Signup Sheet','rsvpmaker-for-toastmasters').'</a></li>';
	$link .= '</ul></div>';

if(isset($_GET["assigned_open"]) && current_user_can($security['edit_signups']))
	{
	$link .= "\n".sprintf('<div style="margin-top: 10px; margin-bottom: 10px;"><a href="%s">%s</a></div>',$permalink.'assigned_open=1&email_me=1',__('Email to me','rspmaker-for-toastmasters'))."\n";
	
	$link .= wp4t_assigned_open();
	$link .= rsvp_report_this_post();
	return $link;
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
if(!empty($userdata->club_member_since))
	printf('<div class="club_join_date">%s: %s</div>',__('Joined Club','rsvpmaker-for-toastmasters'),$userdata->club_member_since);
if(!empty($userdata->original_join_date))
	printf('<div class="original_join_date">%s: %s</div>',__('Joined Toastmasters','rsvpmaker-for-toastmasters'),$userdata->original_join_date);
?>
</div>
<?php

}

add_shortcode('awesome_members','awesome_members');

function add_awesome_member() {

global $wpdb;
global $current_user;
$blog_id = get_current_blog_id();

if(isset($_POST["correction"]))
	{
		foreach($_POST["correction"] as $index => $type)
			{
				$user = NULL;
				if($type == 'new')
					{
					if(!empty($_POST["newuser"][$index]))
					$user = $_POST["newuser"][$index];
					}
				else
					{
					if(!empty($_POST["existing"][$index]))
						{
						$user = array('ID' => $_POST["existing"][$index]);
						if(!empty($_POST["existingtmid"][$index]))
							$user['toastmasters_id'] = $_POST["existingtmid"][$index];
						}
					}
			if(!empty($user))
				$users[] = $user;
			}
	if(!empty($users))
	{
$member_factory = new Toastmasters_Member();
foreach($users as $index => $user)
	{
		$users[$index] = $member_factory->check($user);
	}
foreach($users as $user)
	{
	if(!empty($user))
	$active_ids[] = $member_factory->add($user);
	//$active_ids[] = add_member_user($user);
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
	if(!empty($label["Edu."]) && !empty($cells[$label["Edu."]]))
		$user["education_awards"] = $cells[$label["Edu."]];		
		
	if(isset($label["E-mail"]))
		$user["user_email"] = strtolower(trim($cells[$label["E-mail"]]));
	elseif(isset($label["Email"]))
		$user["user_email"] = strtolower(trim($cells[$label["Email"]]));
	if($user["user_email"] == strtolower(trim($current_user->user_email)))
		continue;
	
	$user["user_login"] = preg_replace('/[^a-z]/','',strtolower($user["first_name"].$user["last_name"]));
	$user["nickname"] = $user["display_name"] = $user["first_name"].' '.$user["last_name"];

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
	
	if(isset($label["Member of Club Since"]))
		$user["club_member_since"] = $cells[$label["Member of Club Since"]];
	if(isset($label["Original Join Date"]))
		$user["original_join_date"] = $cells[$label["Original Join Date"]];
	
	$user["user_pass"] = password_hurdle(wp_generate_password());
	$users[] = $user;
	}
	//break;
	}

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

class Toastmasters_Member  {

public $prompts;
public $confirmations;
public $active_ids;
public 	$blog_id;
public $welcome;
public $prompt_count;

function __construct() {
$this->prompt_count = 0;
$this->blog_id = get_current_blog_id();
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
		if(!is_user_member_of_blog( $member_id, $this->blog_id ) && !user_can($member_id,'manage_options') )
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
			$mail["html"] = "<html>\n<body>\n".$message.$this->welcome."\n</body></html>";
			$mail["to"] = $user["user_email"];
			$mail["cc"] = $admin_email;			
			$mail["from"] = $admin_email;
			$mail["fromname"] = get_bloginfo('name');
			$return = awemailer($mail);
			if($return === false)
				$this->confirmations[] = "<h3>".__('Emailing notifications disabled','rsvpmaker-for-toastmasters')."</h3><pre>".$message."</pre>";			
			else	
				$this->confirmations[] = "<h3>".__('Emailing to','rsvpmaker-for-toastmasters')." ".$user["user_email"]."</h3><pre>".$message."</pre>";
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
			$user["ID"] = $member_exists->ID;
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
		$user["ID"] = $member_exists->ID;
		$this->confirmations[] = $user["first_name"].' '.$user["last_name"].' recognized by Toastmasters ID'; 
		return $user;
		}
	}
	$login_exists = get_user_by('login',$user["user_login"] );
	$email_exists = get_user_by('email',$user["user_email"] );
	if( ($login_exists && $email_exists) && ($login_exists->ID == $email_exists->ID) )
		{
		$user["ID"] = $login_exists->ID;
		$this->confirmations[] = get_member_name($login_exists->ID).' recognized by name and email';
		return $user;
		}
	elseif($email_exists)
		{
			$tmid = get_user_meta($email_exists->ID,'toastmasters_id',true);
			if(empty($tmid) && !empty($user["toastmasters_id"]))
				{
					$user["ID"] = $email_exists->ID;
					return $user; // right user, no tmid
				}
			elseif(!empty($tmid) && !empty($user["toastmasters_id"]) && ($tmid != $user["toastmasters_id"]))
				{
					//different person with same email address
					$user["user_email"] = $user["user_login"].'@example.com';
					$this->confirmations[] = '<span style="color: red;">'.$user["first_name"].' '.$user["last_name"].' appears to have the same email address as '.get_member_name($email_exists->ID). ': '.$email_exists->user_email. '(set to '.$user["user_email"].' instead to keep records distinct)</span>';
					return $user;
				}
			else
				{
				$this->prompts[] = '<span style="color: red;">'.$user["first_name"].' '.$user["last_name"].' appears to have the same email address as '.get_member_name($email_exists->ID). ': '.$email_exists->user_email.' Each user must have a distinct email address.</span><br />'.$this->prompt_fields($user,$email_exists);
				return;
				}
		}
	elseif($login_exists)
		{
		$this->prompts[] = '<span style="color: red;">'.$user["first_name"].' '.$user["last_name"].' cannot have the same username as '.get_member_name($login_exists->ID). ': '.$login_exists->user_email.' Are they the same person?</span><br />'.$this->prompt_fields($user,$login_exists);
		return;
		}
	if(!is_email($user["user_email"]) && !strpos($user["user_email"],'example.com') )
		 {
		$this->prompts[] = '<span style="color: red;">'.__('Error: invalid email address','rsvpmaker-for-toastmasters').' '.$user["user_email"].'</span><br />'.$this->prompt_fields($user);
		 return;
		 }
	return $user;
	}
}

function prompt_fields($user, $other_user = NULL) {
$visible = array('user_login','first_name','last_name','educational_awards','user_email','home_phone','work_phone','mobile_phone');
$o = sprintf('<input type="radio" name="correction[%d]" value="new" /> Correct and re-submit ',$this->prompt_count);
foreach($user as $field => $value)
	{
		if(!empty($value) && in_array($field,$visible))
			$o .= sprintf('<br />%s <input type="text" name="newuser[%d][%s]" value="%s" > ',$field,$this->prompt_count,$field,$value);
		else
			$o .= sprintf('<input type="hidden" name="newuser[%d][%s]" value="%s" > ',$this->prompt_count,$field,$value);		
	}
if(!empty($other_user) && ($user["user_login"] == $other_user->user_login))
	{
		$o .= '<br />Suggested alternate logins ';
		$short = preg_replace('/[^a-z]/','',strtolower($user["first_name"]));
		$long = $user["user_login"];
		for($i = 1; $i < 6; $i++)
			{
			$test = $short.$i;
			if(!get_user_by('login',$test))
				$o .= $test.' ';
			}
		for($i = 1; $i < 6; $i++)
			{
			$test = $long.$i;
			if(!get_user_by('login',$test))
				$o .= $test.' ';
			}
	}
if(!empty($other_user))
{
$member = (is_user_member_of_blog($other_user->ID)) ? '' : ' (user account not currently associated with this club website)';
$o .= sprintf('<br /><input type="radio" name="correction[%d]" value="existing" /> Update existing user <input type="hidden" name="existing[%s]" value="%s" /> %s',$this->prompt_count,$this->prompt_count,$other_user->ID, $member);
if(!empty($user["toastmasters_id"]))
$o .= sprintf('<input_type="hidden" name="existingtmid[%s]" value="%s" />',$this->prompt_count,$user["toastmasters_id"]);
$other_user = get_userdata($other_user->ID);
$o .= $other_user->first_name.' '.$other_user->last_name.$other_user->user_login.' '.$other_user->user_email;
if(!empty($other_user->toastmasters_id))
$o .= ' TMID:'.$other_user->toastmasters_id;
}
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
<form method="post" action="<?php echo admin_url('users.php?page=add_awesome_member'); ?>">
<?php
echo $o;
?>
<input type="submit"  class="button-primary" value="<?php _e("Submit Changes",'rsvpmaker-for-toastmasters');?>" />
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
$contactmethods['education_awards'] = "Educational Awards";
$contactmethods['club_member_since'] = "Joined Club";
$contactmethods['original_join_date'] = "Joined Toastmasters";

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
if(isset($_GET["edit_sidebar"]))
	{
	$sidebar_editor = agenda_sidebar_editor($post->ID);
return sprintf('<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script> 
<script>
        tinymce.init({selector:"textarea.mce",plugins: "code, link"});		
</script>
<form id="edit_roles_form" method="post" action="%s"">
%s<button class="save_changes">'.__("Save Changes",'rsvpmaker-for-toastmasters').'</button><input type="hidden" name="post_id" id="post_id" value="%d"><input type="hidden" id="toastcode" value="%s"></form>%s',rsvpmaker_permalink_query($post->ID),$sidebar_editor,$post->ID,wp_create_nonce( "rsvpmaker-for-toastmasters" ),$content);
	}
if(isset($_GET["reorder"]))
	return '<p><em>'.__('Drag and drop to change the order in which speakers, evaluators and other roles with multiple participants will appear on the agenda').'</em></p>'.$content;
if(!isset($_GET["edit_roles"]) || !current_user_can('edit_signups') )
	return $content;
if(current_user_can('agenda_setup'))
$content .= sprintf('<p><a href="%sedit_sidebar=1">%s</a></p>',rsvpmaker_permalink_query($post->ID),__('Edit Sidebar','rsvpmaker-for-toastmasters'));//agenda_sidebar_editor($post->ID);

return sprintf('<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script> 
<script>
        tinymce.init({selector:"textarea.mce",plugins: "code, link"});		
</script>
<form id="edit_roles_form" method="post" action="%s"">
<p><em>'.__("Edit signups and click <b>Save Changes</b> as the bottom of the form.",'rsvpmaker-for-toastmasters').' <a href="%s?edit_roles=1&rm=1">'.__('Show random assignments','rsvpmaker-for-toastmasters').'</a> / <a href="%s">'.__('Return to agenda signup','rsvpmaker-for-toastmasters').'</a></em><p>
%s<button class="save_changes">'.__("Save Changes",'rsvpmaker-for-toastmasters').'</button><input type="hidden" name="post_id" id="post_id" value="%d"><input type="hidden" id="editor_id" value="%d" /><input type="hidden" id="toastcode" value="%s"></form>',rsvpmaker_permalink_query($post->ID),rsvpmaker_permalink_query($post->ID),rsvpmaker_permalink_query($post->ID),$content,$post->ID,$current_user->ID,wp_create_nonce( "rsvpmaker-for-toastmasters" ));
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
        tinymce.init({selector:"textarea",plugins: "code, link"});	
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
if(empty($assigned))
	return array("ID" => 0, "manual" => '', "project" => '', "maxtime" => '', "title" => '', "intro" => '');
global $wpdb;
if(!$post_id)
	{
	global $post;
	$post_id = $post->ID;
	}
if($backup)
	$field = '_Backup_Speaker_1';
else
	$field = $wpdb->get_var("SELECT meta_key from $wpdb->postmeta WHERE post_id=$post_id AND meta_key LIKE '%Speaker%' AND meta_value='".$assigned."' ");
$speaker["ID"] = $assigned;
$speaker["manual"] = get_post_meta($post_id, '_manual'.$field, true);
$speaker["project"] = get_post_meta($post_id, '_project'.$field, true);
$speaker["maxtime"] = get_post_meta($post_id, '_maxtime'.$field, true);
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
	update_post_meta($post_id, '_'.$name.$field, $value);
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
		$assigned = get_post_meta($post->ID, $field, true);
		if(!empty($assigned))
			{
				$currentorder[] = $i;
				$fullorder[] = $scount;
				$speaker[$scount] = get_speaker_array($assigned,$post->ID);
				$scount++;
			}
		}

		if(sizeof($currentorder) < $count)
			{
				$assigned = (int) get_post_meta($post->ID, '_Backup_Speaker_1', true);
				if($assigned > 0)
					{
					$speaker[$scount] = get_speaker_array($assigned,$post->ID,true);
					$fullorder[] = $scount;
					delete_post_meta($post->ID,'_Backup_Speaker_1');
					delete_post_meta($post->ID,'_manual_Backup_Speaker_1');
					delete_post_meta($post->ID,'_project_Backup_Speaker_1');
					delete_post_meta($post->ID,'_maxtime_Backup_Speaker_1');
					delete_post_meta($post->ID,'_display_time_Backup_Speaker_1');
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
				if(isset($speaker[$i]["ID"]))
					{
					save_speaker_array($speaker[$i],$i,$post->ID);
					}
				else
					{
					delete_post_meta($post->ID,'_Speaker_' . $i);
					delete_post_meta($post->ID,'_manual_Speaker_' . $i);
					delete_post_meta($post->ID,'_project_Speaker_' . $i);
					delete_post_meta($post->ID,'_maxtime_Speaker_' . $i);
					delete_post_meta($post->ID,'_display_time_Speaker_' . $i);
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


add_action('init','add_awesome_roles');

function add_awesome_roles() {
$manager = get_role('manager');
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
	if( (isset($post->post_content) && (strpos($post->post_content,'role=') || strpos($post->post_content,'rsvpmaker') ) ) || (isset($_GET["page"]) && (($_GET["page"] == 'toastmasters_reconcile') || ($_GET["page"] == 'my_progress_report')  || ($_GET["page"] == 'toastmasters_reports') )  ) )
	{
	wp_enqueue_style( 'jquery' );
	wp_enqueue_style( 'jquery-ui-core' );
	wp_enqueue_style( 'jquery-ui-sortable' );
	wp_enqueue_style( 'style-toastmasters', plugins_url('rsvpmaker-for-toastmasters/toastmasters.css'), array(), '2.4.3' );
	wp_enqueue_style('jquery-ui-css', 'http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css');
	wp_register_script('script-toastmasters', plugins_url('rsvpmaker-for-toastmasters/toastmasters.js'), array('jquery','jquery-ui-core','jquery-ui-sortable'), '2.4.9');
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
$sql = "SELECT ID FROM `$wpdb->posts` WHERE `post_content` LIKE '%[toastmasters%' AND post_status='publish' ORDER BY `ID` DESC ";
if($wpdb->get_var($sql))
	return;

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
		$next_show_promo = strtotime('+ 2 month');
		update_user_meta($current_user->ID,'next_show_promo',$next_show_promo);
	}
if((time() > $next_show_promo ) || isset($_GET["show_ad"]) )
{
show_wpt_promo();
$next_show_promo = strtotime('+ 1 month');
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

printf('<div>%s: <a href="%s">%s</a> | <a href="%s" target="_blank">%s</a></div>',__('Related','rsvpmaker-for-toastmasters'),admin_url('edit.php?post_type=rsvpmaker&page=agenda_timing&post_id='.$post->ID),__('Agenda Timing','rsvpmaker-for-toastmasters'),rsvpmaker_permalink_query($post->ID,'print_agenda=1&no_print=1'),__('Show Agenda','rsvpmaker-for-toastmasters'));

?>
</div>
<?php
}

if(isset($_GET["page"]) && ($_GET["page"] == 'agenda_timing') && isset($_GET["post_id"]))
{
echo '<div class="notice notice-info"><p>'.__('Related','rsvpmaker-for-toastmasters').': ';
$template_id = get_post_meta($_GET["post_id"],'_meet_recur',true);	
if($template_id && current_user_can('agenda_setup'))
	printf('<a href="%s">%s</a> | ',admin_url('edit.php?post_type=rsvpmaker&page=agenda_timing&post_id='.$template_id),__('Agenda Timing: Template','rsvpmaker-for-toastmasters'));

if(current_user_can('agenda_setup'))
	printf('<a href="%s">%s</a> | ',admin_url('post.php?action=edit&post='.$_GET["post_id"]),__('Edit/Agenda Setup','rsvpmaker-for-toastmasters'));

printf('<a href="%s" target="_blank">%s</a> | ',rsvpmaker_permalink_query($_GET["post_id"],'print_agenda=1&no_print=1'),__('View Agenda','rsvpmaker-for-toastmasters'));
printf('<a href="%s">%s</a>',get_permalink($_GET["post_id"]),__('View Signup Form','rsvpmaker-for-toastmasters'));
echo '</div>';
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

if($sync_ok == '') // if not 1 or 0
	{
	echo '<div class="notice notice-info"><p>'.sprintf(__('You can choose to allow the member data on the Progress Reports screen to sync with other websites that use this software. See <a target="_blank" href="https://wp4toastmasters.com/2017/05/13/sync-member-progress-report-data/">blog post</a>.</p><p>Choose whether this should be on our off: <a href="%s">Toastmasters Settings.</a>','rsvpmaker-for-toastmasters'), admin_url('options-general.php?page=wp4toastmasters_settings') )."</p></div>\n";
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
if(isset($_GET["role"]))
	$impath = dirname( __FILE__ ).DIRECTORY_SEPARATOR.'mce'.DIRECTORY_SEPARATOR.'placeholder.png';
elseif(isset($_GET["agenda_note"]) && strpos($_GET["agenda_note"],'editable'))
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
imagestring($im, 5, 40, 10, $text, $textcolor);
imagestring($im, 5, 40, 25, $tip, $textcolor);

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
include 'projects_array.php';

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

	$output = sprintf('<tr class="timerow" timecount="%d"><td><input type="checkbox" name="delete[%s]" value="1" /></td><td id="time%s"></td><td class="time_allowed_cell"><select class="time_count" name="time_allowed[%d]" id="time_allowed%d">%s</select>%s</td><td class="text_cell">%s</td></tr>',$time_counter,$time_counter,$time_counter,$time_counter ,$time_counter,timeplanner_option ($atts["time_allowed"]),$padding_time_block ,$txt);

return $output;
}

function agenda_timing () {
global $wpdb;
global $time_counter;
global $timeplanner_total;
global $post;
fix_timezone();
if( !isset($_GET["post_id"]))
{
$template_options = '';
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
return;
}
else
	$post = get_post($_GET["post_id"]);

update_option('agenda_time',1);
$output = $newoutput = $template_options = '';
if(isset($_GET["post_id"]) && $_GET["post_id"])
{
$post_id = (int) $_GET["post_id"];
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

$time_counter = 1;
$lines = explode("\n",$post->post_content);
foreach($lines as $line)
	{
		if( isset($_POST["time_allowed"]))
			{
			if(!empty($_POST["delete"][$time_counter]))
				{
				$time_counter++;
				continue;
				}
			elseif ((strpos($line,'[toastmaster') === false)  && (strpos($line,'[agenda_note') === false))
				$newoutput .= "\n".$line;
			else
				{

					$time_allowed = (!empty($_POST["time_allowed"][$time_counter])) ? (int) $_POST["time_allowed"][$time_counter] : 0;
					$padding_time = (!empty($_POST["padding_time"][$time_counter])) ? (int) $_POST["padding_time"][$time_counter] : 0;
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
		$time_counter++;
	}

$output .= '<tr class="timerow" timecount="'.$time_counter.'"><td></td><td id="time'.$time_counter.'"></td><td><input type="hidden" id="time_allowed'.$time_counter.'" value="0" /><input type="hidden" id="padding_time'.$time_counter.'" value="0"></td><td class="text_cell">'.__('Projected End of Meeting','rsvpmaker-for-toastmasters').'</td></tr>';	

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
<tr><th>Delete</th><th>Elapsed Time</th><th>Time Allowed</th><th>Role/Note</th></tr>
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
	tallyadd += Number($('#time_allowed' + count).val());
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
setcookie('tm_member', $_SERVER['REMOTE_ADDR'], time() + 15552000);//180 days

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

function wpt_extract_video($content) {

$pattern = '/<a class="vm-video-title-content.+video_id=([^"]+)[^>]+([^\<]+)/';

	preg_match_all($pattern,$content, $matches);
	foreach($matches[1] as $index => $value)
		{
			$url = 'https://www.youtube.com/watch?v='.$value;
			$title = $matches[2][$index];
			$links[] = sprintf('<a href="%s"%s</a>'."\n%s\n\n",$url,$title,$url);
		}

$pattern = '/href="(https:\/\/www.youtube.com\/playlist\?list=[^"]+)[^>]+([^\<]+)/';

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
	
	$vtext = wpt_extract_video(stripslashes($_POST["video"]))."<br /><br />";

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

function tmlayout_tag_line ($atts) {
	return get_bloginfo('description');
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
add_shortcode('tmlayout_tag_line','tmlayout_tag_line');
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
$template_forms['General Evaluator'] = array('subject' => 'You are signed up as General Evaluator for [rsvpdate]','body' => "You are signed up as an evaluator for [rsvpdate].\n\n[speaker_evaluator]\n\n[evaluation_links]\n\n[wpt_speakers]\n\nEvaluation Team:\n\n[wpt_evaluators] ");
return $template_forms;
}

add_filter('rsvpmaker_notification_template_forms','wpt_notification_forms');

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

if(!function_exists('pre_print_test')) {
function pre_print_test ($var,$label,$return=false)
{
	$debug = '<pre>'.$label."\n".var_export($var,true).'</pre>';
	if($return)
		return $debug;
	echo $debug;
	
}
}
?>