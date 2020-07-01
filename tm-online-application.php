<?php

function tm_member_application ($atts) {
fix_timezone();
if(isset($_GET['rsvpstripeconfirm']))
    return; // let rsvpmaker show payment message

if(isset($_GET['paydues']))
	return paydues_later();
	
global $post;
if(empty($_POST['user_email']))
    return tm_application_form_start($atts);
    
$notifications = get_option('tm_application_notifications');
if(empty($notifications))
    $notifications = get_option('admin_email');

//add code to buffer output, write to file on post
ob_start();
    
if(!is_admin()) {
?>
<style>
label {
    display: inline-block;
    width: 150px;
}
</style>
<?php
}

include 'application-form.php';
$output = ob_get_clean();
$payprompt = '';

if(!empty($_POST['applicant_signature']))
    {
    $content = preg_replace('/(<(style)\b[^>]*>).*?(<\/\2>)/is', "$1$3", $output);
$newpost['post_type'] = 'tmapplication';
$newpost['post_status'] = 'private';
$newpost['post_content'] = $content;
$newpost['post_title'] = 'Membership Application: '.$_POST['first_name'].' '.$_POST['last_name'];
$post_id = wp_insert_post($newpost);
foreach($_POST as $slug => $value)
    update_post_meta($post_id,$slug,$value);
$public = get_option('rsvpmaker_stripe_pk');
if(!empty($public))
{
    $vars['amount'] = get_post_meta($post->ID,'tm_application_fee',true);//fetch from page for form
	update_post_meta($post_id,'tm_application_fee',$vars['amount']);//record to app document	
    $vars['description'] = 'Toastmasters Dues Payment';
    $vars['name'] = $_POST['first_name'].' '.$_POST['last_name'];
    $vars['email'] = $_POST['user_email'];
    $vars['tracking'] = 'tmapplication'.$post_id;
    $payprompt = rsvpmaker_stripe_form($vars);
}    

$mail['subject'] = 'PENDING '.$newpost['post_title'];
$mail['html'] = '<p>Verify with officer signature <a href="';
$mail['html'] .= admin_url('admin.php?page=member_application_approval&app='.$post_id);
$mail['html'] .= '">'.admin_url('admin.php?page=member_application_approval&app='.$post_id).'</a></p>'."\n\n";
$mail['html'] .= $output;
$mail['fromname'] = $vars['name'];
$mail['from'] = $vars['email'];

$n = explode(',',$notifications);
foreach($n as $to) {
    $mail['to'] = $to;
    rsvpmailer($mail);
    printf('<p>Pending application emailed to %s</p>',$to);
}

}

return $payprompt . $output;
}

function paydues_later () {
	$id = (int) $_GET['paydues'];
    $vars['amount'] = get_post_meta($id,'tm_application_fee',true);
    $vars['description'] = 'Toastmasters Dues Payment';
    $vars['name'] = get_post_meta($id,'first_name',true).' '.get_post_meta($id,'last_name',true);
    $vars['email'] = get_post_meta($id,'user_email',true);
    $vars['tracking'] = 'tmapplication'.$id;
    $payprompt = rsvpmaker_stripe_form($vars);
	return sprintf('<h2>Pay dues for %s</h2>',$vars['name']).$payprompt;
}

add_shortcode('club_fee_schedule','club_fee_schedule');

function club_fee_schedule () {
    $ti_dues = get_option('ti_dues');
    $club_dues = get_option('club_dues');
    $output = '';
    $months = array('January','February','March','April','May','June','July','August','September','October','November','December');
    if(empty($ti_dues))
        return 'not set';
    else {
        $output .= '<style>.feeschedule th {text-align: left;} .feeschedule td {text-align: center; min-width: 100px;}</style>';
        $output .= sprintf('<table class="feeschedule"><tr><th>%s</th><th>%s</th><th>%s</th><th>%s</th><th>%s</th></tr>',__('Month','rsvpmaker-for-toastmasters'),__('TI Dues','rsvpmaker-for-toastmasters'),__('Club Dues','rsvpmaker-for-toastmasters'),__('Total','rsvpmaker-for-toastmasters'),__('+ New Member Fee','rsvpmaker-for-toastmasters'));
        foreach($months as $index => $month) {
            $total = number_format($ti_dues[$index]+$club_dues[$index],2);
            $new = number_format($total + 20,2);
            $output .= sprintf('<tr><th>%s</th><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>',$month,number_format($ti_dues[$index],2),number_format($club_dues[$index],2),$total,$new);
        }
        $output .= '</table>';
    }
return $output;
}

function tm_application_fee() {
global $post;
if(isset($_POST['membership_type']))
{
    $new = ($_POST['membership_type'] == 'New') ? 20 : 0;
    $ti_dues = get_option('ti_dues');
    if(empty($ti_dues))
        $ti_dues = array(22.50,15.00,7.50,45.00,37.50,30.00,22.50,15.00,7.50,45.00,37.50,30.00);
    $club_dues = get_option('club_dues');
    if(empty($club_dues))
        $club_dues = array(0,0,0,0,0,0,0,0,0,0,0,0);
    $monthindex = date('n') - 1;
    $club_new = (int) get_option('club_new_member_fee');
    $ti_dues_calc = ($_POST['membership_type'] == 'Transfer') ? 0 : $ti_dues[$monthindex];
    $club_dues_calc = $club_dues[$monthindex];
    $fee = $ti_dues_calc + $club_dues_calc + $new + $club_new;
    $feetext = sprintf('<p>Membership Starting: %s</p>',date('F'));
    $feetext .= sprintf('<p>Toastmasters International Dues: <strong>%s</strong><br>
    <em>Paid twice a year by all members, membership dues are pro-rated from the member’s start month.</em></p>',number_format($ti_dues_calc,2));
    if($ti_dues_calc == 0)
        $feetext .= '<p>(Paid member of another club requesting transfer.)</p>';    
    $feetext .= sprintf('<p>New member fee (US$20): <strong>%s</strong><br /><em>Paid only by new members, this fee covers the cost of the first education path, online copy of The Navigator and processing</em></p>',number_format($new,2));
    $feetext .= sprintf('<p>Total Payment to Toastmasters International: %s</p>',number_format($ti_dues_calc + $new,2));

    $feetext .= sprintf('<p>Club Dues: <strong>%s</strong></p>',number_format($club_dues_calc,2));
    $feetext .= sprintf('<p>Club New Member Fee: <strong>%s</strong></p>',number_format($club_new,2));
    $feetext .= sprintf('<p>Total Payment to Club: <strong>%s</strong></p>',number_format($club_dues_calc+$club_new,2));
    $feetext .= sprintf('<p>Total: <strong>%s</strong></p>',number_format($fee,2));
    echo $feetext;
    update_post_meta($post->ID,'tm_application_fee',$fee);
    update_post_meta($post->ID,'tm_application_feetext',$feetext);
}
else {
    echo get_post_meta($post->ID,'tm_application_feetext',true);
}

}

function tm_application_form_start($atts) {
$pdf = (isset($atts['pdf'])) ? $atts['pdf'] : 'https://www.toastmasters.org/-/media/files/membership-files/membership-applications/membership-application---800.ashx';
if(isset($_POST['user_email']) && empty($_POST['user_email']))
    return 'Email address is required <a href="'.get_permalink().'">Try again</a>';
ob_start();
?>
<style>
label {
    display: inline-block;
    width: 150px;
}
</style>
<p>By submitting this online membership application, you agree to treat it as the legally binding equivalent of the standard Toastmasters International membership application, and you will be prompted to agree to all the same terms and conditions. If you prefer, you can download and sign the <a href="<?php echo $pdf; ?>" target="_blank">PDF version</a>.</p>

<form method="post" action="<?php echo get_permalink(); ?>">

<p>Step 1: We need a little data to set up the application form and calculate the pro-rated dues (based on the month that you are joining). On the next screen, you will enter your personal data and electronically sign the application.</p>

<p>Email address <?php tm_application_form_field('user_email'); ?> (required)</p>

<p>Application Type <?php tm_application_form_choice('membership_type', array('New','Dual','Transfer','Reinstated (break in membership)','Renewing (no break in membership)'));  ?></p>

<p><em>&quot;New&quot; means the member is new to Toastmasters (not just new to this club).</em></p>

<p><em>"Transfer" means you are currently enrolled as a paying member of another club, which you wish to withdraw from and apply credit for your dues to our club.</em></p>

<p id="transferprompt">If you are transferring from another club, please provide as much information as possible so we can look up your records. The <a href="https://www.toastmasters.org/Find-a-Club">Find a Club</a> feature of the toastmasters.org website can help you look up club numbers.</p>

<p id="formerclubinfo"><label>Previous club name</label> <?php tm_application_form_field('previous_club_name'); ?><br ><label>Previous club number</label><?php tm_application_form_field('previous_club_number'); ?><br /> <label>Member number</label><?php tm_application_form_field('toastmasters_id'); ?><br /><em>Appears above your name on the mailing label for Toastmaster magazine.</em></p>

<button>Next Screen</button>
</form>
<p>&nbsp;</p>

<script>
jQuery(document).ready(function($) {

$('#transferprompt').hide();
$('#formerclubinfo').hide();
var membership_type = 'New';

$('#membership_type').change(function(){
    membership_type = $( "select#membership_type option:selected" ).val();
    if(membership_type != 'New')
        $('#formerclubinfo').show();
    if(membership_type == 'Transfer')
        $('#transferprompt').show();
    else
        $('#transferprompt').hide();

}); 

});
</script>

<?php
return ob_get_clean();
}

function tm_application_form_hidden($slug) {
    echo ' <strong>'.stripslashes($_POST[$slug]).'</strong>';
    printf('<input type="hidden" name="%s" id="%s" value="%s" />',$slug,$slug,stripslashes($_POST[$slug]));
}

function tm_application_form_field($slug) {
    global $post;
    $defaults = array('club_name' => get_option('club_name'),'club_number' => get_option('club_number'), 'club_city' => get_option('club_city'), 'date' => date('F j, Y'));
    
    if(isset($_POST[$slug]))
        echo ' <strong>'.stripslashes($_POST[$slug]).'</strong>';
    else
        {
        $value = '';// get_post_meta($post->ID,'application_'.$slug,true);
        if(!empty($defaults[$slug]) )
            $value = $defaults[$slug];
        elseif(strpos($slug,'date'))
            $value = $defaults['date'];
        if(empty($value))
            printf(' <input type="text" name="%s" id="%s" value="" />',$slug,$slug);
        else
            printf(' <input type="hidden" name="%s" id="%s" value="%s" /> <strong>%s</strong>',$slug,$slug,$value,$value);        
        }
}
    
function tm_application_form_choice($slug, $choices) {
    global $post;
    if(isset($_POST['first_name']))
        echo ' <strong>'.$_POST[$slug].'</strong>';
    else
        {
        printf('<select name="%s" id="%s">',$slug,$slug);
        foreach($choices as $choice)
            printf('<option value="%s">%s</option>',$choice,$choice);
        echo '</select>';
        }
}

function member_application_settings () {
echo '<h1>Toastmasters Application Form</h1>';

global $wpdb;
$sql = "SELECT ID FROM $wpdb->posts WHERE post_content LIKE '%tm_member_application%' AND post_status='publish'";
$apppage = $wpdb->get_var($sql);

if(isset($_POST['ti_dues'])) {
    update_option('club_name',stripslashes($_POST['club_name']));
    update_option('club_number',$_POST['club_number']);
    update_option('club_city',stripslashes($_POST['club_city']));
    update_option('ti_dues',$_POST['ti_dues']);
    update_option('club_dues',$_POST['club_dues']);
    update_option('club_new_member_fee',$_POST['club_new_member_fee']);
    update_option('tm_application_notifications',$_POST['tm_application_notifications']);
if(isset($_POST['rsvpmaker_stripe_pk']))
    {
        update_option('rsvpmaker_stripe_pk',$_POST['rsvpmaker_stripe_pk']);
        update_option('rsvpmaker_stripe_sk',$_POST['rsvpmaker_stripe_sk']);
        update_option('rsvpmaker_stripe_notify',$_POST['tm_application_notifications']);
    }
if(isset($_POST['addpage']))
{
    $page['post_title'] = 'Application';
    $page['post_content'] = '<!-- wp:shortcode -->
    [tm_member_application]
    <!-- /wp:shortcode -->';
    $page['post_status'] = 'publish';
    $page['post_type'] = 'page';
    $apppage = wp_insert_post($page);
}

}

$ti_dues = get_option('ti_dues');
if(empty($ti_dues))
    $ti_dues = array('22.50','15.00','7.50','45.00','37.50','30.00','22.50','15.00','7.50','45.00','37.50','30.00');
$club_dues = get_option('club_dues');
if(empty($club_dues))
    $club_dues = array('0','0','0','0','0','0','0','0','0','0','0','0');

$notifications = get_option('tm_application_notifications');
if(empty($notifications))
    $notifications = get_option('admin_email');

$months = array('January','February','March','April','May','June','July','August','September','October','November','December');
?>
<form action="<?php echo admin_url('options-general.php?page=member_application_settings'); ?>" method="post">
<p><strong>Club Name:</strong><br /><input type="text" name="club_name" value="<?php echo get_option('club_name'); ?>" /> </p>
<p><strong>Club Number:</strong><br /><input type="text" name="club_number" value="<?php echo get_option('club_number'); ?>" /> </p>
<p><strong>Club City:</strong><br /><input type="text" name="club_city" value="<?php echo get_option('club_city'); ?>" /> </p>
<table>
<tr><th>Month</th><th>TI Dues</th><th>Club Dues</th></tr>
<?php
foreach($months as $i => $month)
{
?>
<tr><td><?php echo $month; ?></td><td><input type="text" name="ti_dues[<?php echo $i; ?>]" value="<?php echo $ti_dues[$i] ?>"  /></td><td><input type="text" name="club_dues[<?php echo $i; ?>]" value="<?php echo $club_dues[$i] ?>"  /></td></tr>
<?php    
}
?>
</table>
<p><strong>Club New Member Fee:</strong><br /><input type="text" name="club_new_member_fee" value="<?php echo get_option('club_new_member_fee'); ?>" /> </p>
<p><strong>Email Approval Notifications To:</strong><br /><input style="width: 90%" type="text" name="tm_application_notifications" value="<?php echo $notifications; ?>" /><br />
Multiple email addresses may be entered, separated by a comma.</p>
<?php
$public = get_option('rsvpmaker_stripe_pk');
$secret = get_option('rsvpmaker_stripe_sk');
if(empty($public) || empty($secret))
{
?>
<h3>Stripe Online Payment Service</h3>
<p>To enable online payments, obtain these credentials from stripe.com.</p>
<p>Publishable Key:<br />
	<input name="rsvpmaker_stripe_pk" value="<?php echo get_option('rsvpmaker_stripe_pk'); ?>"></p>
<p>Secret Key:<br />
	<input name="rsvpmaker_stripe_sk" value="<?php echo get_option('rsvpmaker_stripe_sk'); ?>"></p>
<?php
}
else
    printf('<p><strong>Stripe Online Payments: Enabled</strong> <a href="%s">RSVPMaker settings</a>.</p>',admin_url('https://toastmost.org/wp-admin/options-general.php?page=rsvpmaker-admin.php'));

if(empty($apppage))
    printf('<p><input type="checkbox" name="addpage" value="1" checked="checked"> Create a page where the application will be displayed.</p>');
else
    printf('<p>Application page: <a target="_blank" href="%s">View</a> or <a target="_blank" href="%s">Edit</a>',get_permalink($apppage),admin_url('post.php?action=edit&post='.$apppage));
submit_button(); ?>
</form>
<?php echo club_fee_schedule(); ?>
<p>To display web page, use the shortcode [club_fee_schedule]</p>
<?php
}

function verification_by_officer () {
fix_timezone();
ob_start();
?>
<p><strong>Verification of Club Officer</strong></p>

<p>I confirm that a complete membership application, including the signatures of the new member and a club officer, is on file with the club and will be retained by the club.</p>

<p>By my signature below, I certify that this individual has joined the Toastmasters club identified. As a club, we will ensure that this member receives proper orientation and mentoring.</p>

<p>I acknowledge that my electronic signature on this document is legally equivalent to my handwritten signature.</p>

<p><label>Club officer’s signature</label> <?php tm_application_form_field('officer_signature'); ?> <br >
<label>Date</label> <?php tm_application_form_field('officer_signature_date'); ?>
</p>
<!-- /wp:paragraph -->
<?php
return ob_get_clean();
}

function check_application_payment($app_id) {
    global $wpdb;
    $key = 'tmapplication'.$app_id;
    $sql = "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='$key' ";
    $paid = $wpdb->get_row($sql);
	$sql = "SELECT ID FROM $wpdb->posts WHERE post_content LIKE '%tm_member_application%' AND post_status='publish'";
	$app_page = $wpdb->get_var($sql);
	$paylink = '';
	if($app_page) {
		$paylink = add_query_arg('paydues',$app_id,get_permalink($app_page));
		$paylink = sprintf(' Payment link: <a href="%s">%s</a>',$paylink,$paylink);
	}
    if($paid)
        return sprintf('<strong>Paid online: %s</strong>',number_format($paid->meta_value,2));
    else
        {
            $email = strtolower(get_post_meta($app_id,'user_email',true));
            if(!empty($email))
            $log = stripe_log_by_email ($email);
            if(empty($log))
                return '<span style="color: red;">No online payment recorded.</span>'.$paylink;
            else
                return '<span style="color: red;">Possible payment matches:</span></p>'.$log.'<p>'.$paylink;
        }
}

function tm_note_format() {
    global $current_user;
    return '<p>Note: '.stripslashes($_POST['notes']). ' <br /><small>('.$current_user->user_email.' '.date('r').')</small></p>';
}


function member_application_approval () {
echo '<h1>Member Application Approval</h1>
<style>
label {
display: inline-block;
width: 150px;
}
</style>
';
global $wpdb, $current_user;

if(isset($_POST['officer_signature']))
{
    $app_id = (int) $_POST['app'];
    $application = get_post($app_id);
    $verification = verification_by_officer();
    $notes = (empty($_POST['notes'])) ? '' : tm_note_format();
    $update['ID'] = $app_id;
    $update['post_content'] = $application->post_content.$verification.$notes;
    $return = wp_update_post($update);
    update_post_meta($app_id,'officer_signature',$_POST['officer_signature']);
    update_post_meta($app_id,'officer_signature_date',$_POST['officer_signature_date']);
    $mail['subject'] = 'COMPLETED '.$application->post_title;
    $mail['html'] = $update['post_content'];
    $mail['fromname'] = $current_user->display_name;
    $mail['from'] = $current_user->user_email;
    $notifications = get_option('tm_application_notifications');
    $n = explode(',',$notifications);
    
    foreach($n as $to) {
        $mail['to'] = trim($to);
        rsvpmailer($mail);
        printf('<p>Completed application emailed to %s</p>',$to);
    }

    $mail['to'] = get_post_meta($app_id,'user_email',true);
    rsvpmailer($mail);
    printf('<p>Completed application emailed to %s</p>',$mail['to']);

    $member_factory = new Toastmasters_Member();
    $user["first_name"] = get_post_meta($app_id,'first_name',true);		
    $user["last_name"] = get_post_meta($app_id,'last_name',true);		
    $user["user_email"] = get_post_meta($app_id,'user_email',true);
    $user["home_phone"] = get_post_meta($app_id,'home_phone',true);
    $user["mobile_phone"] = get_post_meta($app_id,'mobile_phone',true);
    $user["toastmasters_id"] = get_post_meta($app_id,'toastmasters_id',true);
    $member_factory->check($user);
    $member_factory->show_prompts();    
}
elseif(!empty($_POST['notes']))
{
    $app_id = (int) $_POST['app'];
    $application = get_post($app_id);
    $notes = tm_note_format();
    $update['ID'] = $app_id;
    $update['post_content'] = $application->post_content.$notes;
    wp_update_post($update);
}

if(isset($_POST['add_account'])) {
    $app_id = (int) $_POST['add_account'];
    $member_factory = new Toastmasters_Member();
    $user["first_name"] = get_post_meta($app_id,'first_name',true);		
    $user["last_name"] = get_post_meta($app_id,'last_name',true);		
    $user["user_email"] = get_post_meta($app_id,'user_email',true);
    $user["home_phone"] = get_post_meta($app_id,'home_phone',true);
    $user["mobile_phone"] = get_post_meta($app_id,'mobile_phone',true);
    $user["toastmasters_id"] = get_post_meta($app_id,'toastmasters_id',true);
    $member_factory->check($user);
    $member_factory->show_prompts();    
}

if(isset($_GET['app']))
{
    echo '<div style="background-color: #fff; padding: 10px; margin: 10px; border: thin solid #000;">';
    printf('<form action="%s" method="post"><input type="hidden" name="app" value="%s" />',admin_url('admin.php?page=member_application_approval'),$_GET['app']);
    //$vars['tracking'] = 'tmapplication'.$post_id;
    $app_id = (int) $_GET['app'];
    $approval = get_post_meta($app_id,'officer_signature',true);
    if($approval)
        {
            printf('<p>Approved by %s on %s</p>',$approval,get_post_meta($app_id,'officer_signature_date',true));
            echo '<p>Notes</br><textarea style="width: 100%;" name="notes"></textarea></p>';
            echo submit_button();
        }
    else {
        printf('<p>%s</p>',check_application_payment($app_id));
    echo verification_by_officer();
    echo '<p>Notes</br><textarea style="width: 100%;" name="notes"></textarea></p>';
    echo submit_button('Approve');
        }
    echo '</form>';
    echo '</div>';

    $application = get_post($_GET['app']);
    echo '<h2>'.$application->post_title.'</h2>';
    echo $application->post_content;
}

$emailopt = '';
$emails = Array();
$results = $wpdb->get_results('SELECT ID, post_title, meta_value FROM '.$wpdb->posts.' JOIN '.$wpdb->postmeta.' on '.$wpdb->posts.'.ID = '.$wpdb->postmeta.'.post_id WHERE post_status="private" AND post_type="tmapplication" AND meta_key="user_email" ORDER BY ID DESC');
if($results) {
    foreach($results as $row) {
        $p = explode(': ',$row->post_title);
        if(empty($p[1]))
            continue;
        $name = $p[1];
        $email = $row->meta_value;
        if(in_array($email,$emails))
            continue;
        $emails[] = $email;
        $user = get_user_by('email',$email);
        if($user)
            continue;
        $emailopt .= sprintf('<option value="%d">%s %s</option>',$row->ID,$name,$email);
    }
}

$last = '';
$results = $wpdb->get_results('SELECT ID, post_title, post_modified FROM '.$wpdb->posts.' WHERE post_status="private" AND post_type="tmapplication" ORDER BY ID DESC');
if($results)
{
if(!empty($emailopt))
    printf('<form method="post" action="%s"><p>%s <select name="add_account">%s</select> <button>%s</button></p></form>',admin_url('admin.php?page=member_application_approval'),__('Create user account for','rsvpmaker-for-toastmasters'),$emailopt,__('Add','rsvpmaker-for-toastmasters'));
echo '<div style="border: thin solid #333; padding: 10px;">';
    foreach($results as $post) {
        if($post->post_title == $last)
            continue;
        $last = $post->post_title;
        $verified = '';
        $approval = get_post_meta($post->ID,'officer_signature',true);
        if($approval)
            $verified = sprintf('(Approved %s)',get_post_meta($post->ID,'officer_signature_date',true));
        else
            $verified = check_application_payment($post->ID);
        echo $log;
        printf('<p><a href="%s">%s</a> %s %s</p>',admin_url('admin.php?page=member_application_approval&app='.$post->ID),$post->post_title, $post->post_modified, $verified);
        }
echo '<div>';    
}

}

function member_application_upload () {
if(!empty($_POST)) {
    $upload_overrides = array(
        'test_form' => false
    );
    $content = '';
    //print_r($_POST);
    //print_r($_FILES);
    foreach($_FILES as $file) {
        if(!empty($file[tmp_name]))
        {
            $result = wp_handle_upload($file,$upload_overrides);
            //echo '<br />upload result';
            //print_r($result);
            if($result['url'])
            {
                if(strpos($result['type'],'png') || strpos($result['type'],'jpg') || strpos($result['type'],'gif'))
                    $content .= sprintf('<p><img src="%s" style="max-width: %s" /></p>',$result['url'],'95%');
                else
                    $content .= sprintf('<p><a target="_blank" href="%s">Application file</a></p>',$result['url']);
            }
            else
            {
                echo '<p>Upload error ';
                print_r($result);
                echo '</p>';
            }

        }
    }

    if(!empty($_POST['application3'])) {
        $content .= sprintf('<p><a target="_blank" href="%s">Application file (external link)</a></p>',$_POST['application3']);
    }

    if(!empty($content)) {
        $newpost['post_type'] = 'tmapplication';
        $newpost['post_status'] = 'private';
        $newpost['post_content'] = $content;
        $newpost['post_title'] = 'Membership Application: '.$_POST['first_name'].' '.$_POST['last_name'];
        $post_id = wp_insert_post($newpost);
        add_post_meta($post_id,'first_name',$_POST['first_name']);
        add_post_meta($post_id,'last_name',$_POST['last_name']);
        add_post_meta($post_id,'user_email',$_POST['user_email']);
        add_post_meta($post_id,'toastmasters_id',$_POST['toastmasters_id']);
        printf('<p><a href="%s">Application posted</a></p>',admin_url('admin.php?page=member_application_approval&app='.$post_id));    
        if(!empty($_POST['approved']))
            {
                echo '<p>Marking approved</p>';
                global $current_user;
                update_post_meta($post_id,'officer_signature',get_user_meta($current_user->ID,'first_name',false).' '.get_user_meta($current_user->ID,'last_name',false));
                update_post_meta($post_id,'officer_signature_date',date('F j, Y'));            
                $member_factory = new Toastmasters_Member();
                $user["first_name"] = get_post_meta($post_id,'first_name',true);		
                $user["last_name"] = get_post_meta($post_id,'last_name',true);		
                $user["user_email"] = get_post_meta($post_id,'user_email',true);
                $user["toastmasters_id"] = get_post_meta($post_id,'toastmasters_id',true);
                $member_factory->check($user);
                $member_factory->show_prompts();            
            }
    }
}

?>
<style>
label {
    display: inline-block;
    width: 125px;
}
</style>
<h1>Member Application Manual Upload</h1>
<p>When you receive an application as a PDF or image file, you can upload it to be tracked along with applications submitted as HTML. Alternatively, you can provide a link to a file sharing service like Dropbox or Google Drive.</p>
<form action="<?php echo admin_url('admin.php?page=member_application_upload');?>" method="post" enctype="multipart/form-data">
<p><label>First name:</label> <input type="text" name="first_name"></p>
<p><label>Last name:</label> <input type="text" name="last_name"></p>
<p><label>Email:</label> <input type="text" name="user_email"></p>
<p><label>Toastmasters ID:</label> <input type="text" name="toastmasters_id"> <br />(optional, if available)</p>
<p>File: <input type="file" name="application" id="application"></p>
<p>File: <input type="file" name="application2" id="application2"> <br />(2nd page, if captured separately)</p>
<p><label>Link:</label> <input type="text" name="application3" id="application3"></p>
<p><input type="checkbox" name="approved"> Mark approved (signed by current user, today's date)</p>
<p><input type="submit" value="Submit" name="submit"></p>
</form>
<?php    
}

function tm_application_menus () {
    add_options_page( 'TM Application Form', 'TM Application Form', 'manage_options', 'member_application_settings', 'member_application_settings');
    add_menu_page( 'Review/Approve Applications', 'Review/Approve Applications', 'edit_users', 'member_application_approval', 'member_application_approval');
    add_submenu_page( 'member_application_approval','Add File or Link', 'Add File or Link', 'edit_users', 'member_application_upload', 'member_application_upload');
}
add_action('admin_menu','tm_application_menus');
?>