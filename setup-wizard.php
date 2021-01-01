<?php
function wp4t_setup_wizard_no_distrations() {
    if(!empty($_GET['page']) && ($_GET['page'] == 'wp4t_setup_wizard'))
    remove_all_actions('admin_notices');
}

add_action('admin_init','wp4t_setup_wizard_no_distrations');

function wp4t_setup_wizard() {
global $rsvp_options, $current_user;
?>
<style>

#wizard ul {
  list-style-position: outside;
  list-style-type: circle;
  margin-left: 20px;
  font-size: large;
  line-height: 1.5;
}
#wizard #bullets {
    padding: 10px;
    background-color: #fff;
}

#wizardmenu {
    background-color: #000;
    font-size: large;
    color: #fff;
    font-weight: bold;
    margin-top: 3px;
    padding-top: 5px;
}
#wizardmenu a {
display: inline-block;
width: 250px;
text-decoration: none;
color: #ddd;
text-align: center;
padding: 5px;
height: 2em;
}
#wizardmenu a.current {
color: #fff;
}
img {
    max-width: 60%;
}
</style>
<div id="wizard">
<h1>Toastmasters Setup Wizard</h1>
<?php
$class1 = (empty($_REQUEST['setup_wizard'])) ? ' class="current" ' : '';
$class2 = (!empty($_REQUEST['setup_wizard']) && ($_REQUEST['setup_wizard'] == 1) ) ? ' class="current" ' : '';
$class3 = (!empty($_REQUEST['setup_wizard']) && ($_REQUEST['setup_wizard'] == 2) ) ? ' class="current" ' : '';
printf('<div id="wizardmenu"><a target="_blank" href="'.admin_url('admin.php?page=wp4t_setup_wizard').'" '.$class1.'>Step 1:<br />Meetings &amp; Basics</a> &gt; 
<a target="_blank" href="'.admin_url('admin.php?page=wp4t_setup_wizard').'&setup_wizard=1"  '.$class2.'>Step 2:<br />Invite Others</a> &gt; 
<a target="_blank" href="'.admin_url('admin.php?page=wp4t_setup_wizard').'&setup_wizard=2"  '.$class3.'>Next Steps</a></div>');
if(isset($_POST['setup_wizard'])) {

if($_POST['setup_wizard'] == '1') {
$agenda_content = '';
$time_open = (int) $_POST['time_open'];
$time_ge = (int) $_POST['time_ge'];
$time_closing = (int) $_POST['time_closing'];
$time_break = (int) $_POST['time_break'];

if(!empty($_POST['opening']))
{
$opening = stripslashes($_POST['opening']);
$agenda_content .= '<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"'.$time_open.'","uid":"note1534625016726"} -->
<p class="wp-block-wp4toastmasters-agendanoterich2">'.$opening.'</p>
<!-- /wp:wp4toastmasters/agendanoterich2 -->'."\n\n";
}
$agenda_content .= '<!-- wp:wp4toastmasters/role {"role":"Toastmaster of the Day","count":"1","agenda_note":"Introduces supporting roles. Leads the meeting.","time_allowed":"0","padding_time":"0"} /-->'."\n\n";
$rarr = explode(',',stripslashes($_POST['otherroles']));
foreach($rarr as $role)
    $agenda_content .= '<!-- wp:wp4toastmasters/role {"role":"'.$role.'","count":"1","time_allowed":"0","padding_time":"0"} /-->'."\n\n";
if($_POST['tabletopics'] == 'before')
    $agenda_content .= '<!-- wp:wp4toastmasters/role {"role":"Topics Master","count":"1","time_allowed":"'.(int) $_POST['time_tt'].'","padding_time":"0"} /-->'."\n\n";

if($_POST['break'] == 'before')
    $agenda_content .= '<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"'.$time_break.'","uid":"note1534625016726"} -->
    <p class="wp-block-wp4toastmasters-agendanoterich2">'.$time_break.' minute break</p>
    <!-- /wp:wp4toastmasters/agendanoterich2 -->'."\n\n";
    
$numberspeakers = (int) $_POST['numberspeakers'];
if($numberspeakers)
    $agenda_content .= '<!-- wp:wp4toastmasters/role {"role":"Speaker","count":"'.$numberspeakers.'","time_allowed":"'.(round($numberspeakers*7.5)).'","padding_time":"0"} /-->'."\n\n";

if($_POST['break'] == 'afterspeakers')
    $agenda_content .= '<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"'.$time_break.'","uid":"note1534625016726"} -->
    <p class="wp-block-wp4toastmasters-agendanoterich2">'.$time_break.' minute break</p>
    <!-- /wp:wp4toastmasters/agendanoterich2 -->'."\n\n";

if($_POST['tabletopics'] == 'after')
    $agenda_content .= '<!-- wp:wp4toastmasters/role {"role":"Topics Master","count":"1","time_allowed":"'.(int) $_POST['time_tt'].'","padding_time":"0"} /-->'."\n\n";

$agenda_content .= '<!-- wp:wp4toastmasters/role {"role":"General Evaluator","count":"1","agenda_note":"Explains the importance of evaluations. Introduces Evaluators.","time_allowed":"1","padding_time":"0"} /-->';
if($numberspeakers)
    $agenda_content .= '<!-- wp:wp4toastmasters/role {"role":"Evaluator","count":"'.$numberspeakers.'","time_allowed":"'.($numberspeakers*3).'","padding_time":"0"} /-->'."\n\n";

if($_POST['break'] == 'afterevaluators')
    $agenda_content .= '<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"'.$time_break.'","uid":"note1534625016726"} -->
    <p class="wp-block-wp4toastmasters-agendanoterich2">'.$time_break.' minute break</p>
    <!-- /wp:wp4toastmasters/agendanoterich2 -->'."\n\n";

if(!empty($_POST['reports']))
    {
    $content = stripslashes($_POST['reports']);
    $agenda_content .= '<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"'.$time_ge.'","uid":"note1534625016726"} -->
    <p class="wp-block-wp4toastmasters-agendanoterich2">'.$content.'</p>
    <!-- /wp:wp4toastmasters/agendanoterich2 -->'."\n\n";
    }

if($_POST['tabletopics'] == 'end')
    $agenda_content .= '<!-- wp:wp4toastmasters/role {"role":"Topics Master","count":"1","time_allowed":"'.(int) $_POST['time_tt'].'","padding_time":"0"} /-->'."\n\n";

if(!empty($_POST['closing']))
    {
    $content = stripslashes($_POST['closing']);
    $agenda_content .= '<!-- wp:wp4toastmasters/agendanoterich2 {"time_allowed":"'.$time_closing.'","uid":"note1534625016726"} -->
    <p class="wp-block-wp4toastmasters-agendanoterich2">'.$content.'</p>
    <!-- /wp:wp4toastmasters/agendanoterich2 -->'."\n\n";
    }
if(!empty($_POST['theme']))
    $agenda_content .= '<!-- wp:wp4toastmasters/agendaedit {"editable":"'.stripslashes($_POST['theme_label']).'","uid":"Theme"} /-->'."\n\n";
if(!empty($_POST['absences']))
    $agenda_content .= '<!-- wp:wp4toastmasters/absences /-->'."\n\n";

$rsvp = (int) $_POST['invite'];
$sync = (int) $_POST['sync'];

$update['post_content'] = $agenda_content;
$template_id = get_option('default_toastmasters_template');
$toupdate = future_rsvpmakers_by_template($template_id);
if(empty($toupdate))
{
    $update['ID'] = $template_id;
    wp_update_post($update);
    update_post_meta($post_id,'_rsvp_on',$rsvp);
    auto_renew_project($template_id);
}
else {
    $toupdate[] = $template_id;
    foreach($toupdate as $post_id) {
        $update['ID'] = $post_id;
        wp_update_post($update);
        update_post_meta($post_id,'_rsvp_on',$rsvp);
    }    
}
$rsvp_options['rsvp_on'] = $rsvp;
$rsvp_options['convert_timezone'] = 1;
$rsvp_options['add_timezone'] = 1;
$rsvp_options['calendar_icons'] = 1;
update_option('RSVPMAKER_Options',$rsvp_options);
update_option('wp4toastmasters_enable_sync', $sync );

if($rsvp) {
    $frontpage_id = get_option( 'page_on_front' );
    if($frontpage_id)
    {
        $post = get_post($frontpage_id);
        if(!strpos($post->post_content,'wp:rsvpmaker/event'))
        {
        $update['post_content'] = '<!-- wp:heading -->
<h2 id="visit">Visit as a Guest</h2>
<!-- /wp:heading -->

<!-- wp:rsvpmaker/event {"post_id":"nextrsvp","one_format":"compact"} /-->
            
'.$post->post_content;
        $update['ID'] = $frontpage_id;
        wp_update_post($update);        
        }
    }
}

echo '<div class="notice notice-success"><p>Meeting Options Saved</p></div>';

}

if(isset($_POST['first']))
{
    $member_factory = new Toastmasters_Member();
    $wp4toastmasters_officer_titles = get_option('wp4toastmasters_officer_titles');
    if(empty($wp4toastmasters_officer_titles))
        $wp4toastmasters_officer_titles = array(__("President",'rsvpmaker-for-toastmasters'),__("VP of Education",'rsvpmaker-for-toastmasters'),__("VP of Membership",'rsvpmaker-for-toastmasters'),__("VP of Public Relations",'rsvpmaker-for-toastmasters'),__("Secretary",'rsvpmaker-for-toastmasters'),__("Treasurer",'rsvpmaker-for-toastmasters'),__("Sgt. at Arms",'rsvpmaker-for-toastmasters'),__("Webmaster",'rsvpmaker-for-toastmasters'),__("Immediate Past President",'rsvpmaker-for-toastmasters'));
    $wp4toastmasters_officer_ids = get_option('wp4toastmasters_officer_ids');
    if(empty($wp4toastmasters_officer_ids))
        $wp4toastmasters_officer_ids = array(0,0,0,0,0,0,0,0,0);
    foreach($_POST['first'] as $index => $first)
    {
        $user = array();
        $user['first_name'] = stripslashes($first);
        $user['last_name'] = stripslashes($_POST['last'][$index]);
        $user['display_name'] = $first.' '.$user['last_name'];
        $user['user_email'] = $_POST['email'][$index];
        if(empty($user['user_email']))
            continue;
        $role = $_POST['role'][$index];
        $security = $_POST['security'][$index];
        $user = wpt_wizard_check_member($user);
        if(!empty($user))
            $user_id = $member_factory->add($user);    
        if(!empty($security))
        {
            $u = new WP_User( $user_id );
            $u->set_role( $security );
        }
        if(!empty($role))
        {
            $title_index = array_search($role,$wp4toastmasters_officer_titles);
            $wp4toastmasters_officer_ids[$title_index] = $user_id;
        }
    }
    $role = $_POST['myrole'];
    $title_index = array_search($role,$wp4toastmasters_officer_titles);
    $wp4toastmasters_officer_ids[$title_index] = $current_user->ID;

    update_option('wp4toastmasters_officer_titles',$wp4toastmasters_officer_titles);
    update_option('wp4toastmasters_officer_ids',$wp4toastmasters_officer_ids);
    echo '<div class="notice notice-success"><p>User Account Options Saved</p></div>';
}

}

if(empty($_REQUEST['setup_wizard']))
    wpt_setup_wizard_1();
elseif($_REQUEST['setup_wizard'] == '1')
    wpt_setup_wizard_2();
elseif($_REQUEST['setup_wizard'] == '2')
    wpt_setup_wizard_3();

echo '<div>';
}

function wpt_setup_wizard_1 () {
    ?>
    <h2>Step 1: Meeting Defaults</h2>
    <form method="post" action="<?php echo admin_url('admin.php?page=wp4t_setup_wizard'); ?>">
    <p><label>Meeting Opening Activities</label><br /> <textarea name="opening" style="width: 80%;">Sgt. at Arms calls the meeting to order. President or Presiding officer makes opening remarks, then introduces Toastmaster of the Day. Toastmaster of the Day introduces the other role players.</textarea><br />Time Allowed<input name="time_open" value="6" /></p>
    <p><label>Number of Speakers at a Typical Meeting </label> <select name="numberspeakers">
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3" selected="selected">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="8">8</option>
    <option value="9">9</option>
    <option value="10">10</option>
    </select></p>
    <p><label>Topics Master leads Table Topics</label> <select name="tabletopics">
    <option value="before">before speakers</option>
    <option value="after">after speakers, before evaluators</option>
    <option value="end">end of the meeting</option>
    <option value="">no Table Topics</option>
    </select> Time Allowed <input name="time_tt" value="10" /></p>
    <p>Other Roles on Your Agenda (separated with commas)
    <br /><input type="text" name="otherroles" value="Ah Counter, Body Language Monitor, Grammarian, Humorist, Timer, Vote Counter" style="width: 80%;" />
    </p>
    <p><label>Reports</label><br /> <textarea name="reports" style="width: 80%;">General Evaluator calls for reports from supporting players. General Evaluator then gives an overall evaluation of the meeting.</textarea><br />Time Allowed<input name="time_ge" value="5" /></p>
    <p><label>Meeting Closing Activities</label><br /> <textarea name="closing" style="width: 80%;">Toastmaster of the Day presents the awards. President or Presiding officer closes the meeting.</textarea><br />Time Allowed <input name="time_closing" value="6" /></p>
    <p><label>Break</label> <select name="break">
    <option val="">None</option>
    <option value="before">before speakers</option>
    <option value="afterspeakers">after speakers</option>
    <option value="afterevaluators">after evaluators</option>
    <select>
    Time Allowed<input name="time_break" value="5" />
    </p>
    <p><label>Include Theme and/or Word of the Day on the Agenda</label> <input type="radio" name="theme" value="1" checked="checked" /> Yes <input type="radio" name="theme" value="0" > No
    <label>Label</label>  <input name="theme_label" value="Theme and Word of the Day" style="width: 20em;" /></p>
    <p><label>Include Member Absences Widget</label> <input type="radio" name="absences" value="1" checked="checked" /> Yes <input type="radio" name="absences" value="0" > No</p>
    
    <p><label>Invite Guests to Register Online</label> <input type="radio" name="invite" value="1" checked="checked" /> Yes <input type="radio" name="invite" value="0" > No</p>
    <p><label>Allow Member Data to Sync (see <a target="_blank" href="" target="_blank">blog post</a>)</label> <input type="radio" name="sync" value="1" checked="checked" /> Yes <input type="radio" name="sync" value="0" > No</p>
    <input type="hidden" name="setup_wizard" value="1" />
    <?php submit_button('Next'); ?>
    </form>
    <?php    
}

function wpt_setup_wizard_2 () {
    update_option('wp4t_setup_wizard_used',time());
    $wp4toastmasters_officer_titles = get_option('wp4toastmasters_officer_titles');
    if(empty($wp4toastmasters_officer_titles))
        $wp4toastmasters_officer_titles = array(__("President",'rsvpmaker-for-toastmasters'),__("VP of Education",'rsvpmaker-for-toastmasters'),__("VP of Membership",'rsvpmaker-for-toastmasters'),__("VP of Public Relations",'rsvpmaker-for-toastmasters'),__("Secretary",'rsvpmaker-for-toastmasters'),__("Treasurer",'rsvpmaker-for-toastmasters'),__("Sgt. at Arms",'rsvpmaker-for-toastmasters'),__("Webmaster",'rsvpmaker-for-toastmasters'),__("Immediate Past President",'rsvpmaker-for-toastmasters'));
    elseif(!in_array('Webmaster',$wp4toastmasters_officer_titles))
        {
            foreach($wp4toastmasters_officer_titles as $index => $title) {
                if(empty($title)) {
                    $wp4toastmasters_officer_titles[$index] = 'Webmaster';
                    break;
                }
            }
            update_option('wp4toastmasters_officer_titles',$wp4toastmasters_officer_titles);
        }
    $oopt = '';
    foreach($wp4toastmasters_officer_titles as $title) {
        if(!empty($title))
        $oopt .= sprintf('<option value="%s">%s</option>',$title,$title);
    }
    ?>
    <h2>Step 2: Invite Other Users</h2>
    <p>It's a good idea to invite a few people who can review what you are doing with the website and join you in experimenting with using the online agenda. When the website is ready, you can invite in all your members.</p>
    <form method="post" action="<?php echo admin_url('admin.php?page=wp4t_setup_wizard'); ?>">
<?php for($i = 0; $i < 10; $i++) { ?>
    <p><label>First Name</label> <input type="text" name="first[]" />
    <label>Last Name</label> <input type="text" name="last[]" />
    <label>Email</label> <input type="text" name="email[]" />
 <label>Officer Role</label> <select name="role[]" >
    <option value="">None</option>
    <?php echo $oopt;?>
   </select>
   <label>Security </label> <select name="security[]" >
    <option value="">Member</option>
    <option value="administrator">Administrator</option>
    <option value="manager">Manager</option>
    <option value="editor">Editor</option>
    <option value="author">Author</option>
   </select></p>
<?php
}
?>
    <p><label>My Role</label> <select name="myrole" >
    <option value="">None</option>
    <option value="Webmaster" selected="selected">Webmaster</option>
    <?php echo $oopt;?>
   </select></p>
    <input type="hidden" name="setup_wizard" value="2" />
    <?php submit_button('Next'); ?>
    </form>

<p>Note on security roles: You may want to assign another Administrator who will have security rights equal to your own. A Manager can do most of the same things as an administrator, including adding user accounts, but cannot change the basic settings of the website. An Editor can add and edit pages and blog posts. An author can post to the blog but cannot edit other people's content.</p>

    <?php    
}

function wpt_setup_wizard_3 () {
    update_option('wp4t_setup_wizard_used',time());
    $template_id = get_option('default_toastmasters_template');
    $upcoming = future_rsvpmakers_by_template($template_id);
    $next = $upcoming[0];
    $frontpage_id = get_option( 'page_on_front' );
    ?>
    <h2>Next Steps</h2>
<div id="bullets">
    <ul>
    <li><a target="_blank" href="<?php echo admin_url('post.php?post='.$frontpage_id.'8&action=edit'); ?>">Edit your home page</a> - tell everyone what makes your club special! See the documentation on how to use the WordPress editor below.</li>
    <li>View the <a target="_blank" href="<?php echo get_permalink($next); ?>">signup page</a> and <a target="_blank" href="<?php echo get_permalink($next); ?>?print_agenda=1&no_print=1">agenda</a> for a meeting. Try signing up for a role. Explore the different options on the agenda menu, such as how to email it to the club.</li>
    <li>Open your primary <a target="_blank" href="<?php echo admin_url('post.php?post='.$template_id.'&action=edit'); ?>">agenda template in the WordPress editor</a>. Learn how to add, edit, and rearrange the widgets representing roles on the agenda and notes. You can use the template to update all your other events to match. Documentation below.</li>
    <li>Check out the design options available in the <a target="_blank" href="<?php echo admin_url('customize.php?return=%2Fwp-admin%2F'); ?>">Customize</a> tool.</li>
    <li>Once things are starting to look good, <a target="_blank" href="<?php echo admin_url('users.php?page=add_awesome_member'); ?>">add members</a> to your club website. You can save time by importing the member roster spreadsheet you can get from Club Central on toastmasters.org.</li>
    </ul>
</div>

<h2>Documentation</h2>
<p>For more complete documentation, see <a target="_blank" href="https://wp4toastmasters.com">wp4toastmasters.com</a>, particularly the <a target="_blank" href="https://www.wp4toastmasters.com/knowledge-base/">knowledge base section</a>. Some of the essential articles you should review when getting started are excerpted below.</p>

	<h4 class="entry-title">Add WordPress Blocks (Different Types of Content)</h4>

<p>The WordPress editor organizes content into <em>blocks</em> representing different content types. The default block is the paragraph. When you create a new post, enter the title, and hit ENTER, and start typing in the main content area of the editor, you are creating paragraph blocks.</p>

<p>To add other types of blocks, click the + button (appears both at the top of the page and in the left hand margin when you add a blank line).</p>

<figure class="wp-block-image size-large"><a target="_blank" href="https://www.wp4toastmasters.com/wp-content/uploads/2021/01/block-plus.jpg"><img src="https://i0.wp.com/www.wp4toastmasters.com/wp-content/uploads/2021/01/block-plus.jpg" /></a><figcaption>Insert block buttons</figcaption></figure>

<figure class="wp-block-image size-large"><a target="_blank" href="https://www.wp4toastmasters.com/wp-content/uploads/2021/01/block-select-search.jpg"><img src="https://i1.wp.com/www.wp4toastmasters.com/wp-content/uploads/2021/01/block-select-search.jpg"  /></a><figcaption>Select and search for blocks</figcaption></figure>
<!--  width="614" height="240" width="614" height="497"  -->
<p><a target="_blank" href="https://www.wp4toastmasters.com/knowledge-base/how-to-add-wordpress-blocks-content-types/">Read More</a></p>

<h4 class="entry-title">Meeting Templates and Meeting Events</h4>
<p>The WordPress for Toastmasters agenda management system is defined around a system of event templates and individual event posts, or documents, that define the structure of your meetings. Members can then sign up for roles (or meeting organizers can assign them).</p>
<p>The event documents are organized using the RSVPMaker WordPress plugin. The WordPress for Toastmasters system uses a separate plugin (RSVPMaker for Toastmasters) to add agenda management features. Within the WordPress editor, you use <a target="_blank" href="https://www.wp4toastmasters.com/knowledge-base/add-or-edit-an-agenda-role/">Agenda Role</a> and <a target="_blank" href="https://www.wp4toastmasters.com/knowledge-base/add-an-agenda-note/">Agenda Note</a> content blocks to structure your agenda. Other available content blocks include <a target="_blank" href="https://www.wp4toastmasters.com/knowledge-base/editable-agenda-blocks/">Editable Note</a> and <a target="_blank" href="https://www.wp4toastmasters.com/2018/04/11/tracking-planned-absences-agenda/">Toastmasters Absences</a>.</p>
<figure class="wp-block-image size-large"><a target="_blank" href="https://www.wp4toastmasters.com/wp-content/uploads/2021/01/agenda-role-block-properties.jpg"><img  src="https://www.wp4toastmasters.com/wp-content/uploads/2021/01/agenda-role-block-properties-1024x499.jpg" alt="" class="wp-image-1138710"/></a><figcaption>Agenda Role block</figcaption></figure>
<figure class="wp-block-image size-large"><a target="_blank" href="https://www.wp4toastmasters.com/wp-content/uploads/2021/01/agenda-note-block-properties.jpg"><img  src="https://www.wp4toastmasters.com/wp-content/uploads/2021/01/agenda-note-block-properties-1024x517.jpg" alt="" class="wp-image-1138712"/></a><figcaption>Agenda Note block</figcaption></figure>
<p>You can plan the time associated with different events on your agenda using the <strong>Time Allowed</strong> fields that appear in the sidebar of both Agenda Role and Agenda Note blocks. Agenda Role blocks also allow you to set a <strong>Count</strong> -- which, for example, is how you you would change the number of speaker openings that appear on the agenda and the signup form.</p>
<p><a target="_blank" href="https://www.wp4toastmasters.com/knowledge-base/toastmasters-meeting-templates-and-meeting-events/">Read More</a></p>
    

<h4 class="entry-title">Batch Creation of User Accounts</h4>
<p>This wizard helps you add a few selected user accounts for members. The easiest way to add all your members is to download the member spreadsheet from Club Central on Toastmasters.org and import it into your club website.</p>
<p><a target="_blank" href="https://www.wp4toastmasters.com/2018/10/05/video-how-to-import-your-member-list-then-add-and-accounts-after-dues-renewal/">Read More</a></p>

<h4 class="entry-title">Change the Look of Your Club Website</h4>
<p>If you don't like how your website looks, you can change it. Follow the link below to learn how to change the overall design of your site and style selected elements like headlines and the background color for pages.</p>
<p><a target="_blank" href="https://www.wp4toastmasters.com/2020/11/09/video-change-the-look-of-your-club-website/">Read More</a></p>
    <?php    
}

function wpt_wizard_check_member($user) {
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
	$login_exists = get_user_by('login',$user["user_login"] );
    $email_exists = get_user_by('email',$user["user_email"] );
    if(!empty($login_exists->ID))
        $user['ID'] = $login_exists->ID;
    if(!empty($email_exists->ID))
        $user['ID'] = $email_exists->ID;
    return $user;
}

function wpt_wizard_prompt() {
    $members = get_club_members();
    $morethanone = sizeof($members) > 1;
    $wp4toastmasters_officer_titles = get_option('wp4toastmasters_officer_titles');
    if(!empty($wp4toastmasters_officer_titles) || (sizeof($members) > 1) )
        return;
    $cleared = get_user_meta($current_user->ID,'rsvpmaker_agenda_notifications');
    if(empty($cleared))
        $cleared = array();
    $used = get_option('wp4t_setup_wizard_used');
    $message ='<div style="height: 100px; padding: 20px;">';
    $message .= sprintf('<h2>Try the <a href="%s">Club Website Setup Wizard</a></h2>',admin_url('admin.php?page=wp4t_setup_wizard'));
    $message .= sprintf('<h3>Use the <a href="%s">setup wizard</a> to quickly tweak your agenda, invite others to test the site, and begin using your club website productively.</h3>',admin_url('admin.php?page=wp4t_setup_wizard'));
    $message .= '</div>';
    rsvptoast_admin_notice_format($message, 'wizard', $cleared, 'info');
}
add_action('admin_notices','wpt_wizard_prompt',-5);