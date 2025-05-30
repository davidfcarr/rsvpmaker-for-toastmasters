<?php
add_action('rsvpmaker_autoreply','wpt_email_handler_automation',15,7);
add_action('admin_menu','wpt_email_menu');
function wpt_email_menu () {
    add_menu_page( __('Toastmasters Email Tools', 'rsvpmaker-for-toastmasters' ), __( 'TM Email', 'rsvpmaker-for-toastmasters' ), 'read', 'wpt_email_handler_page', 'wpt_email_handler_page', 'https://toastmost.org/click16.png', '2.03' );
    //submenus were edit_users
    add_submenu_page('wpt_email_handler_page', 'Email Lists', 'Email Lists', 'manage_options', 'wpt_email_handler_club_email_list', 'wpt_email_handler_club_email_list');  
    add_submenu_page('wpt_email_handler_page', 'Email Forwarding', 'Email Forwarding', 'manage_options', 'wpt_email_handler_forwarders', 'wpt_email_handler_forwarders');
    add_submenu_page('wpt_email_handler_page', 'Find a Club Autoresponder / Notifications Forwarding', 'Find a Club Autoresponder / Notifications Forwarding', 'manage_options', 'wpt_findaclub', 'wpt_findaclub');    
    add_submenu_page('wpt_email_handler_page', 'Member Email Check', 'Member Email Check', 'manage_options', 'wpt_member_email_check', 'wpt_member_email_check');
}
function wpt_email_handler_page () {
    echo '<h1>Toastmasters Email Forwarders, Groups &amp; Tools</h1>';
    $status = rsvpmaker_relay_bot_check();
    printf('<div style="float: right; width: 250px; margin-left: 25px; margin-right: 25px; padding: 5px; border: thin solid gray"><h3>Service Status</h3>%s</div>',$status);
    $slug_ids = get_officer_slug_ids();
    if(!empty($slug_ids)) {
        $forwarder_info = '<p>Configured officer forwarding addresses include:';
        foreach($slug_ids as $slug => $id) {
            $f = wpt_format_email_forwarder($slug);
            $forwarder_info .= sprintf('<br /><a href="mailto:%s" target="_blank">%s</a>',$f,$f);
        }
        $forwarder_info .= '</p>';
    }
    if(current_user_can('manage_options')) {
        printf('<p>You can configure a variety of forwarding addresses such as <strong>%s</strong> to foward to the club president and mailing lists such as <strong>%s</strong> for discussion between club members and <strong>%s</strong> for discussions between officers.</p>',wpt_format_email_forwarder('president'),wpt_format_email_forwarder(''),wpt_format_email_forwarder('officers'));
        printf('<p>Use <strong>%s</strong> as a general address that forwards to one or more officers, with specific forwarding rules for Base Camp notifications. Optionally, you can also set up an auto-reply that will go to prospective members who have filled out the contact form on the toastmasters.org Find a Club page. (<a href="%s">configure</a>)</p>',wpt_format_email_forwarder('info'),admin_url('admin.php?page=wpt_findaclub'));
        echo '<h2>Forwarding Addresses</h2>';
        if(empty($slug_ids)) {
            printf('<p>Set your officers list on the <a href="%s">Toastmasters settings page</a> to enable forwarding by officer title/abbreviation.</p>',admin_url('options-general.php?page=wp4toastmasters_settings'));
        }
        else {
            echo $forwarder_info;
            printf('<p>See the <a href="%s">Toastmasters settings page</a> to edit this list.</p>',admin_url('options-general.php?page=wp4toastmasters_settings'));
        }
        printf('<p>You can configure <a href="%s">custom forwarding addresses</a> for other club purposes.</p>',admin_url('admin.php?page=wpt_email_handler_forwarders'));
        echo '<h2>Mailing Lists</h2>';
        printf('<p>Member and officer email lists can be set to distribute messages from any member of the list to every other member of the list (<a href="%s">configure</a>).</p>',admin_url('wpt_email_handler_club_email_list'));
        $member_status = empty(get_option('member_distribution_list')) ? 'OFF' : 'ON';
        $officer_status = empty(get_option('officer_distribution_list')) ? 'OFF' : 'ON';
        printf('<p>Status: member list %s officer list %s</p>',$member_status,$officer_status);
        echo '<h2>Using your own domain</h2>';
        if(wpt_is_own_domain()) {
            echo '<p>If this site is <strong>not</strong> hosted as part of the Toastmost service, the site administrator must configure a default email forwarder to send messages not associated with any other mailbox to an account the server is configured to check. Contact david@wp4toastmasters.com for assistance as this feature is not completely documented yet.</p>';
        }
        else {
            printf('<p>If you register your own domain to use with this website, you can use email addresses such as members@clubawesome.org (without the prefix).</p>');
        }
    
        if(!is_multisite() || 1 == get_current_blog_id())
        {
            printf('<h2>Configuration</h2><p>To make this work, you must create an email account on the web server that will act as the "bot" for these automated functions. Record the username, password, and other parameters in the bot section of the <a href="%s">Group Email tab of RSVPMaker Settings</a>.</p>',admin_url('options-general.php?page=rsvpmaker-admin.php'));
            echo "<p>Configure the default email forwarder on the server to send all messages that don't match another account or alias on the server to the bot email account. By default, many web hosts have the default set to discard any message that does not match a hard-coded email address or alias.</p>";
        }    
    }
    else { // viewable by all members
        $active = get_option( 'rsvpmaker_discussion_active' );
        if($active) {
            $m = wpt_format_email_forwarder('members');
            printf('<p>You can send a message for distribution to all other members by writing to <a href="mailto:%s">%s</a>.</p>',$m,$m);
            echo '<p>Please limit use of this list to club business.</p>';    
        }
        else {
            echo '<p><strong>Member email list currently not active on this site.</strong></p>';
        }
        echo $forwarder_info;
    }
}
function wpt_email_handler_automation($qpost, $to, $from, $toaddress, $fromname, $toarray, $ccarray) {
    update_blog_option(1,'wpt_email_handler', $to);
    echo '<h1>wpt_email_handler_automation triggered</h1>';
    $toline = 'Forwarded message, originally <strong>To:</strong> ';
    foreach($toarray as $address)
        $toline .= $address->mailbox.'@'.$address->host.' ';
    if(!empty($ccarray))
        {
            $toline .= '<strong>CC:</strong> ';
            foreach($ccarray as $address)
                $toline .= $address->mailbox.'@'.$address->host.' ';    
        }
    preg_match_all('/[a-zA-Z_\-\.]+@[a-zA-Z_\-]+?\.[a-zA-Z_\-]{2,3}/',$qpost["post_content"],$fcmatches);
    $qpost['post_content'] .= "\n<p>$toline</p>";
    $output = "<p>$to $from $fromname ".$qpost['post_title'].'</p>';
    $hosts = wpt_get_hosts();
    $subdomains = wpt_get_subdomains();
    if(empty($ccarray))
        $addresses = $toarray;
    else
        $addresses = array_merge($toarray, $ccarray);
    $noreply = (is_multisite()) ? 'noreply@'.$hosts[0] : 'noreply@'.$hosts[1];
    $mail['from'] = $noreply;
    $output .= "<p>addresses: ".var_export($addresses, true)."</p>";
    $ffemails = (is_multisite()) ? get_blog_option(1,'findclub_emails') : get_option('findclub_emails');
    foreach($addresses as $address) {
        if($address->mailbox == 'noreply')
            continue;
        $forwarder = strtolower($address->mailbox.'@'.$address->host);
        //$mail['toname'] = 'forwarded from '.$forwarder;
        $qpost['forwarded_from'] = $forwarder;
        $subdomain = '';
        if(!in_array($address->host,$hosts)) {
            $output .= sprintf('<p>%s not in hosts list</p>',$forwarder);
            continue;
        }
        if(is_multisite()) {
            //returns 0 for main host, blog_id for subdomains
            $blog_id = array_search($address->host,$hosts);
            //$output .= sprintf('<p>blog id based on host %s</p>',$blog_id);
            if($blog_id) {//has own domain
                $slug = $address->mailbox;
            } else {
                $parts = explode('-',$address->mailbox);
                $subdomain = $parts[0];
                if(sizeof($parts) > 1)
                    $slug = $parts[1]; //op-officers
                elseif(in_array($subdomain,$subdomains))
                    $slug = 'members';
                else
                    $slug = $address->mailbox;
                $blog_id = array_search($subdomain,$subdomains); // wpt_subdomain_blog_id($subdomain, $hosts[0]);
                if(!$blog_id && $address->host == $hosts[0])
                    $blog_id = 1;//root domain, no subdomain
                //$output .= sprintf('<p>multisite blog id %s</p>',$blog_id);
            }
        }
        else {
            $blog_id = 1;
            $slug = $address->mailbox;
        }
        if(!$blog_id)
            continue;
        $sent = false;
        $output .= sprintf('<p>%s@%s blog_id %d router %s </p>',$address->mailbox, $address->host, $blog_id, $slug);
        if($ffemails && is_array($ffemails))
            $finda_id = array_search($forwarder,$ffemails);
        else
            $finda_id = 0;
        if(!empty($finda_id)) {
            //$output .= sprintf('<p>Checking finda_id %s / %s</p>',$finda_id,$forwarder);
            if($finda_id && strpos($from,'google.com') && strpos($qpost['post_title'],'Forward'))
            {
                foreach($fcmatches[0] as $email) {
                    if(strpos($email,'google') || strpos($email,'findaclub'))
                        continue;
                    $contact = $email;
                }
                $hosts = wpt_get_hosts();
                $mail['fromname'] = (is_multisite()) ? get_option('blogname',true) : get_blog_option($blog_id,'blogname',true);
                $mail['html'] = '<p>Your website\'s Find-a-Club bot is forwarding this Google confirmation message back to you, allowing you to approve it yourself.</p>'."\n".$qpost['post_content'].'<p>forwarder:'.$forwarder.' blog id '.$blog_id.'</p>';
                $mail['to'] = $contact;
                //$mail['toname'] = 'forwarded from '.$forwarder;
                $mail['subject'] = 'Verify gmail forwarding for '.$to;
                rsvpmailer($mail);
                $output .= "<p>Forward $forwarder gmail forwarding confirmation</p>";
                continue;
            }
            if(strpos($qpost['post_title'],'prospective member'))
            {
                $blog_id = $finda_id;
                foreach($fcmatches[0] as $email) {
                    if(strpos($email,'toastmasters.org') || strpos($email,'@toastmost.org') || (strcasecmp($email, $forwarder) == 0))
                        continue;
                    $contact = $email;
                }
                wpt_email_handler_autoresponder ($contact, $from, $blog_id,'line 616');
                $output .= sprintf('<p>autoresponder %s for %s, contact %s</p>',$finda_id,$forwarder, $contact);
                $sent = true;
            }
    
            //$output .= sprintf('<p>check Basecamp/misc forwarding for finda_id %s / %s</p>',$finda_id,$forwarder);
            $blog_id = $finda_id;
            $forward_by_id = ($blog_id == 1)  ? get_option('wpt_forward_general') : get_blog_option($blog_id,'wpt_forward_general');
            $basecamp = ($blog_id == 1) ? get_option('wpt_forward_basecamp') : get_blog_option($blog_id,'wpt_forward_basecamp');
           
            if(is_array($basecamp) && (strcasecmp($from,'BaseCamp@toastmasters.org') == 0) ) {
                $mail['html'] = $qpost['post_content']; //$parts[0];
                $mail['subject'] = $qpost['post_title'];
                $mail['from'] = $from;
                $mail['fromname'] = (empty($fromname)) ? $from : $fromname;
                foreach($basecamp as $fto) {
                    $mail['to'] = $fto;
                    rsvpmailer($mail);
                }
            $output .= sprintf('<p>forarded %s basecamp message to %s</p>',$forwarder, var_export($fto,true));
            continue;
            }
            if(is_array($forward_by_id)) {
                $output .= sprintf('<p><strong>forward by id %s %s</strong></p>',$forwarder, var_export($forward_by_id,true));
                wpt_email_handler_qemail($qpost, $forward_by_id, $from, $fromname, $blog_id);
                $sent = true;
            }
            continue;
        }
        $unsubscribed = get_option('rsvpmail_unsubscribed');
        if(empty($unsubscribed))
            $unsubscribed = array();
        if($blog_id && is_multisite()){
            $club_unsub = get_blog_option($blog_id,'rsvpmail_unsubscribed');
            if($club_unsub && is_array($club_unsub))
            {
                $unsubscribed = array_unique(array_merge($unsubscribed,$club_unsub));
            }
        }
        if($slug == 'members') {
            $on = (int) (is_multisite() && $blog_id) ? get_blog_option($blog_id,'member_distribution_list', true) : get_option('member_distribution_list', true);
            if(!$on)
                continue;
            $listvars = (is_multisite() && $blog_id) ? get_blog_option($blog_id,'member_distribution_list_vars') : get_option('member_distribution_list_vars');
            $recipients = get_club_member_emails($blog_id);
            $recipients = wpt_remove_unsubscribed($recipients, $unsubscribed);
            if(!empty($listvars['additional']))
            foreach($listvars['additional'] as $email) {
                if(!in_array($email,$unsubscribed))
                    $recipients[] = $email;
            }
            if((!in_array($from,$recipients) && !in_array($from,$listvars['whitelist'])) || in_array($from,$listvars['blocked']) ) {
                $output .= '<p>Blocked: '.$from.'</p>';
                wpt_email_handler_qemail_blocked($qpost, $from, $forwarder, $blog_id);
                continue;
            }
            $qpost['post_title'] = '['.$slug.'] '.$qpost['post_title'];
            $output .= sprintf('<p><strong>members list %s</strong> to %s</p>',$forwarder, var_export($recipients,true));
            wpt_email_handler_qemail($qpost, $recipients, $from, $fromname, $blog_id);
            $recipients = array();
            $sent = true;
        }
        if('officers' == $slug) {
            //$output .= sprintf('<p>officers %s</p>',$forwarder);
            $on = (int) (is_multisite()) ? get_blog_option($blog_id,'officer_distribution_list') : get_option('officer_distribution_list');
            if(!$on)
                continue;
            $listvars = (is_multisite() && $blog_id) ? get_blog_option($blog_id,'officer_distribution_list_vars') : get_option('officer_distribution_list_vars');
            $officers = (is_multisite() && $blog_id) ? get_blog_option($blog_id,'wp4toastmasters_officer_ids') : get_option('wp4toastmasters_officer_ids');
            if($officers && is_array($officers)) {
                foreach($officers as $id) {
                    $member = get_userdata($id);
                    if($member) {
                        $email = strtolower($member->user_email);
                        if(!in_array($email,$unsubscribed))
                            $recipients[] = $email;
                    }
                }
            if(!empty($listvars['additional']))
            foreach($listvars['additional'] as $email) {
                if(!in_array($email,$unsubscribed))
                    $recipients[] = $email;
            }
            if((!in_array($from,$recipients) && !in_array($from,$listvars['whitelist'])) || in_array($from,$listvars['blocked']) ) {
                wpt_email_handler_qemail_blocked($qpost, $from, $forwarder);
                $output .= '<p>Blocked: '.$from.'</p>';
                continue;
            }
            $slug = str_replace('@toastmost.org','',$forwarder);
            $qpost['post_title'] = '['.$slug.'] '.$qpost['post_title'];
            $recipients = wpt_remove_unsubscribed($recipients, $unsubscribed);
            $output .= sprintf('<p><strong>officers list %s</strong> to %s</p>',$forwarder, var_export($recipients,true));
            //faster where there is less need for queuing
            $output .= wpt_email_handler_bcc($qpost, $recipients, $from, $fromname, $blog_id, $forwarder.' email list', $noreply);
            $recipients = array();
            $sent = true;
            }
            continue;
        }
        $slug_ids = get_officer_slug_ids($blog_id);
        //$output .= sprintf("<p>Officer slug ids %s</p>",var_export($slug_ids, true));
        if(!empty(	$slug_ids [$slug]))
        {
            foreach($slug_ids[$slug] as $user_id) {
                if($user_id) {
                    $officer = get_userdata($user_id);
                    $recipients[] = $officer->user_email;
                }
            }
            $output .= sprintf("<p>Officer recipients for %s %s</p>",$forwarder, var_export($recipients,true));
        }
        if(!empty($recipients)) {
            $recipients = array_unique($recipients);
            $output .= sprintf('<p><strong>forward by title %s %s</strong></p>',$forwarder, var_export($recipients,true));
            $recipients = wpt_remove_unsubscribed($recipients, $unsubscribed);
            wpt_email_handler_qemail($qpost, $recipients, $from, $fromname, $blog_id);
            $recipients = array();
            $sent = true;
        }
        $custom_forwarders = (is_multisite()) ? get_blog_option($blog_id,'custom_forwarders') : get_option('custom_forwarders');
        if(!empty($custom_forwarders[$forwarder]))
        {
            $qpost['post_content'] = "<p>Forwarded from $forwarder</p>\n".$qpost['post_content'];
            $recipients = $custom_forwarders[$forwarder];
            $output .= sprintf('<p><strong>custom forwarder for %s</strong> %s</p>',$forwarder,var_export($recipients,true));
            wpt_email_handler_qemail($qpost, $recipients, $from, $fromname, $blog_id);
            $recipients = array();
            $sent = true;
        }
        if(!$sent) {
            $output .= 'do action hook';
            ob_start();
            do_action('wpt_email_handler_automation_default',$qpost, $forwarder, $from, $fromname, $slug); //wpt_email_handler_automation($qpost, $to, $from, $toaddress, $fromname    
            $output .= ob_get_clean();
            $forwarder = wpt_format_email_forwarder('default',$blog_id);
            $output .= "<p>Check for default mailbox</p>";
            if(!empty($custom_forwarders[$forwarder]))
            {
                $qpost['post_content'] = "<p>Forwarded from $forwarder</p>\n".$qpost['post_content'];
                $recipients = $custom_forwarders[$forwarder];
                $output .= sprintf('<p><strong>default forwarder for %s</strong> %s</p>',$forwarder,var_export($recipients,true));
                wpt_email_handler_qemail($qpost, $recipients, $from, $fromname, $blog_id);
                $recipients = array();
                $sent = true;
            }
        }
    } // end loop through emails
    echo $output;
    do_action('wpt_email_handler_automation_debug',$output);
}
function wpt_email_handler_qemail_blocked ($qpost, $from, $forwarder) {
    $rmail['subject'] = 'BLOCKED '.$qpost['post_title'];
    $rmail['to'] = $from;
    $rmail['html'] = '<p>'.$from .' is not authorized to send to the '.$forwarder." email list.</p>\n<p>Authorized senders include email addresses associated with member accounts, as well as addresses whitelisted by a club website administrator on the TM Administration -> wpt_email_handler Club Email screen.</p>";
    $rmail['from'] = get_option('admin_email');
    $rmail['fromname'] = get_option('blogname');
    rsvpmailer($rmail);    
}
function wpt_email_handler_qemail ($qpost, $recipients, $from, $fromname = '', $blog_id = 0) {
$mail['from'] = $from;
$mail['fromname'] = $fromname;
$mail['subject'] = $qpost['post_title'];
$mail['html'] = $qpost['post_content'];
//if(isset($qpost['forwarded_from']))
    //$mail['toname'] = 'forwarded from '. $qpost['forwarded_from'];
return rsvpmaker_qemail ($mail, $recipients);
}
function wpt_email_handler_bcc ($qpost, $recipients, $from, $fromname = '', $blog_id = 0, $forwarder_label = '', $noreply = '') {
    if (($key = array_search($from, $recipients)) !== false) {
        unset($recipients[$key]);
    }
    if(!empty($qpost['forwarded_from']))
        $qpost['post_content'] .= sprintf("\n<p>Forwarded from %s <a href=\"mailto:%s?subject=Re: %s\">reply to list</a></p>",$qpost['forwarded_from'],$qpost['forwarded_from'],$qpost['post_title']);
    $mail['from'] = $from;
    $mail['fromname'] = $fromname;
    $mail['bcc'] = $recipients;
    $mail['to'] = $noreply;
    $mail['subject'] = $qpost['post_title'];
    $mail['html'] = $qpost['post_content'];
    //if($forwarder_label)
        //$mail['toname'] = $forwarder_label;
    $mail['result'] = rsvpmailer($mail);
    return var_export($mail, true);
}
function wpt_email_handler_autoresponder ($email, $from, $blog_id = 1,$function = '') {
    global $wpdb, $autoreplyto;
    if(empty($email))
        return;
    if(!empty($autoreplyto) && is_array($autoreplyto) && in_array($email,$autoreplyto))
        return; // don't do twice
    $ffpage = ($blog_id == 1) ? get_option('findafriend_page') : get_blog_option($blog_id,'findafriend_page');
    if($ffpage)
        $messagepost = ($blog_id == 1) ? get_post($ffpage) : get_blog_post($blog_id, $ffpage);
    if(empty($messagepost))
        return;
    $mail['subject'] = $messagepost->post_title;
    $mail['html'] = $messagepost->post_content;
    if($function)
        $mail['html'] .= '<p>Function '.$function.'</p>';
    $mail['from'] = ($blog_id == 1) ? get_option('findafriend_email') : get_blog_option($blog_id,'findafriend_email');
    if(strpos($from,'toastmasters.org') || strpos($from,'carrcommunications.com')) {
        //send for real
        $mail['to'] = $email;
        rsvpmailer($mail);
   }
    $autoreplyto[] = $email;
    $mail2 = $mail;
    $mail2['to'] = (is_multisite()) ? get_blog_option($blog_id,'admin_email') : get_option('admin_email');
    $mail2['subject'] = "autoreply sent to $email: ".$mail['subject'];
    $mail2['html'] .= "<p>Email: $email</p>";
    rsvpmailer($mail2);
    add_post_meta($messagepost->ID,'club_leads',$email.' '.date('r'));
    return $mail;
}
function wpt_findaclub () {
rsvpmaker_admin_heading(__('Find a Club / General Notifications Setup','rsvpmaker-for-toastmasters'),__FUNCTION__);
global $wpdb, $current_user;
$blog_id = get_current_blog_id();
$parts = explode('.',$_SERVER['SERVER_NAME']);
$botemail = $parts[0].'-info@toastmost.org';
$ordomain = (strpos($_SERVER['SERVER_NAME'],'toastmost.org')) ? '' : ' or info@'.$_SERVER['SERVER_NAME'];
$ffemails = ($blog_id == 1) ? get_option('findclub_emails') : get_blog_option(1,'findclub_emails');
if(!is_array($ffemails))
    $ffemails = array();
$forward = get_option('wpt_forward_general');
$basecamp = get_option('wpt_forward_basecamp');
$o = '<option value="0">Not Set</option><option value="new">Create Message</option>';
if(isset($_POST['ffemail'])) {
    $ffemail = $_POST['ffemail'];
    if($_POST['bot'])
        $ffemail = $botemail;
    if(empty($ffemail))
        unset($ffemails[$blog_id]);
    else{
        echo '<div class="notice notice-success"><p>Added '.$ffemail.'</p></div>';
        $ffemails[$blog_id] = $ffemail;
    }
    if(is_multisite())
        update_blog_option(1,'findclub_emails',$ffemails);
    else
        update_option('findclub_emails',$ffemails);
    if(empty($_POST['forward'])) {
        delete_option('wpt_forward_general');
        $forward = array();
    } 
    else {
        $emails = wpt_email_list_to_array($_POST['forward']);
        $forward = array_splice($emails,0,5);
        update_option('wpt_forward_general',$forward);
    }
    if(empty($_POST['basecamp'])) {
        delete_option('wpt_forward_basecamp');
        $basecamp = array();
    }
    else {
        $emails = wpt_email_list_to_array($_POST['basecamp']);
        $basecamp = array_splice($emails,0,5);
        update_option('wpt_forward_basecamp',$basecamp);
    }
    update_option('findafriend_email',$ffemail);
    $ffpage = $_POST['ffpage'];
    if(!is_numeric($ffpage))
        $ffpage = 0;
    if($ffpage == 'new') {
        $ffpage = 0;
        $content = sprintf('<!-- wp:paragraph -->
        <p>Learn more about our club at <a href="https://%s">%s</a></p>
        <!-- /wp:paragraph -->',$_SERVER['SERVER_NAME'],$_SERVER['SERVER_NAME']);
        $content = rsvpmailer_default_block_template_wrapper($content);
        $ffpage = wp_insert_post( array('post_author' => $current_user->ID, 'post_status' => 'publish','post_type' => 'rsvpemail','post_title' => 'Thank you for your interest in '.get_option('blogname'), 'post_content' => $content) );
    }
    if($ffpage)
        update_option('findafriend_page',$ffpage);
    else
        delete_option('findafriend_page');
    echo 'forwarding page '.$ffpage;
}
else {
    $ffemail = get_option('findafriend_email');
    $ffpage = get_option('findafriend_page');
}
$results = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type='rsvpemail' AND post_status='publish' ORDER BY post_title");
foreach($results as $row)
    {
        $s = ($row->ID == $ffpage) ? ' selected="selected" ' : '';
        $o .= sprintf('<option value="%d" %s>%s</option>',$row->ID,$s,$row->post_title);
    }
$botchecked = ($ffemail == $botemail); 
?>
<form action="<?php echo admin_url('admin.php?page=wpt_findaclub'); ?>" method="post">
<p><input type="radio" name="bot" value="1" <?php if($botchecked) echo ' checked="checked" '; ?> >  I will register <?php echo $botemail.$ordomain; ?> as the club's email address in Club Central</p>
<p><input type="radio" name="bot" value="0" <?php if(!$botchecked) echo ' checked="checked" '; ?> > I have set up forwarding to findaclub@toastmost.org from this address:<br />
<input type="text" name="ffemail" value="<?php if(!$botchecked) echo $ffemail; ?>" />
<br /><em>Example: myclub@gmail.com (<a href="https://www.wp4toastmasters.com/2021/01/05/use-the-toastmost-find-a-club-email-bot-with-gmail/" target="_blank">GMail setup example</a>)</em></p>
<p>Automatic response content:<br /><select name="ffpage"><?php echo $o; ?></select>
<?php
if($ffpage) {
    $post = get_post($ffpage);
    if(isset($post->post_title))
        printf('<p>Edit Message: <a href="%s&post=%d">%s</a></p>',admin_url('post.php?&action=edit'),$ffpage,$post->post_title);
}
?>
</p>
<p>
General forwarding (limit 5 email addresses) <br />
<textarea name="forward" rows="2" cols="60"><?php if(is_array($forward)) echo implode(', ',$forward); ?></textarea>
<br /><em>Intended for use with <?php echo $botemail; ?>. Separate emails with commas or line breaks.</em>
</p>
<p>
BaseCamp forwarding (limit 5 email addresses) <br />
<textarea name="basecamp" rows="2" cols="60"><?php if(is_array($basecamp)) echo implode(', ',$basecamp); ?></textarea>
<br /><em>Intended for use with <?php echo $botemail; ?>. Separate emails with commas or line breaks.</em>
</p>
<?php submit_button();
if(isset($post->post_title)) {
    printf('<p><a href="%s&post=%d">Edit Message</a></p>',admin_url('post.php?&action=edit'),$ffpage);
    $post = get_post($ffpage);
    if(empty($post->post_title))
        echo '<p>Error with welcome message setup</p>';
    else {
        echo '<div style="background-color:#fff; padding: 10px;">';
        printf('<h2>%s</h2>',$post->post_title);
        echo (empty($post->post_content)) ? '<p>(no content)</p>' : $post->post_content;    
        echo '</div>';
        $leads = get_post_meta($post->ID,'club_leads');
        if($leads) {
          echo '<h3>Leads processed</h3>';
        foreach($leads as $lead)
            printf('<div>%s</div>',$lead);
        }
    }
}
?>
</form>
<h2>How This Works</h2>
<p>Toastmasters International sends a variety of different notifications, including "Contact Club" emails from the "Find a Club" page, all to the same email address that you've registered in Club Central.</p>
<p>Sending an automated response is one way of responding faster and more consistently &mdash; which is not to say you shouldn't also follow up personally. The automated response is only sent to messages from clubleads@toastmasters.org.</p>
<p>To use <?php echo $botemail ?>, you must register <?php echo $botemail ?> as the club's official email address in Club Central. In that case, you should specify one or more forwarding email addresses for club officers who should also get those messages.</p>
<h2>Handle Messages Forwarded from Another Email Address</h2>
<p>To use this feature with your own club email account, you need to have those contact email messages from clubleads@toastmasters.org forwarded to findaclub@toastmost.org.</p>
<p>One relatively easy way is to create a GMail account specifically for purposes of club correspondence and have it forward selected emails to findaclub@toastmost.org. See this <a target="_blank" href="https://www.wp4toastmasters.com/2021/01/05/use-the-toastmost-find-a-club-email-bot-with-gmail/#stepbystep">step-by-step illustrated tutorial</a>.</p>
<p>The process is:</p>
<ol>
<li>Record your club's main email address here on the Find-a-Club Autoresponder screen under Toastmasters Administration.</li>
<li>Edit the message that will be sent in response to prospective member inquiries. For example, if you answer most of the questions people typically have on your website, you can send them a link to your website, along with contact information for your officers. The title of the document you create in WordPress will become the subject line of the automated emails, and the body of the document will become the body of the autoreply messages.</li>
<li>Set up forwarding from your club's email account to findaclub@toastmost.org</li>
<li>Before establishing a forwarding address, GMail sends a nofification to the target address asking for confirmation. Our findaclub email bot sends you a copy, allowing you to approve the forwarding yourself by clicking a link in the notification.</li>
<li>Create a forwarding rule in GMail to forward any message from clubleads@toastmasters.org to findaclub@toastmost.org</li>
</ol>
<p>When findaclub@toastmost.org receives a notification from clubleads@toastmasters.org, it parses that message, finds the address of the person requesting information, and sends them the autoresponder message you have defined.</p>
<?php
wpt_delete_forwarding_transient();
}
function wpt_get_club_email_lists($blog_id = 0) {
if(empty($blog_id))
    $blog_id = get_current_blog_id();
if(is_multisite())
    switch_to_blog(1);
$clubemails = get_option('toastmost_club_email_list');
$officeremails = get_option('toastmost_officer_email_list');
if(is_multisite())
    restore_current_blog();
$member = (empty($clubemails[$blog_id])) ? '' : $clubemails[$blog_id];
$officer = (empty($officeremails[$blog_id])) ? '' : $officeremails[$blog_id];
return array('member' => $member, 'officer' => $officer);
}
function wpt_set_club_email_lists($lists, $blog_id = 0) {
    if(empty($blog_id))
        $blog_id = get_current_blog_id();
    if(is_multisite())
        switch_to_blog(1);
    $clubemails = get_option('toastmost_club_email_list');
    $officeremails = get_option('toastmost_officer_email_list');
    if(empty($lists['member']))
        unset($clubemails[$blog_id]);
    else
        $clubemails[$blog_id] = $lists['member'];
    if(empty($lists['officer']))
        unset($officeremails[$blog_id]);
    else
        $officeremails[$blog_id] = $lists['officer'];
    update_option('toastmost_club_email_list',$clubemail);
    update_option('toastmost_officer_email_list',$officeremails);
    if(is_multisite())
        restore_current_blog();
    $member = (empty($clubemails[$blog_id])) ? '' : $clubemails[$blog_id];
    $officer = (empty($officermails[$blog_id])) ? '' : $officeremails[$blog_id];
    return array('member' => $member, 'officer' => $officer);
}
add_action('wpt_wizard_post','wpt_email_handler_mailing_lists_wizard_post');
function wpt_email_handler_mailing_lists_wizard_post() {
    if(isset($_POST['wpt_email_handler_mailing_lists'])) {
        $blog_id = get_current_blog_id();
        if(is_multisite())
            switch_to_blog(1);
        $clubemails = get_option('wpt_email_handler_club_email_list');
        $officeremails = get_option('wpt_email_handler_officer_email_list');
        if(empty($clubemails))
            $clubemails = array();
        if(empty($officeremails))
            $officeremails = array();
        $parts = explode('.',$_SERVER['SERVER_NAME']);
        $clubemails[$blog_id] = $parts[0].'@toastmost.org';
        $officeremails[$blog_id] = $parts[0].'-officers@toastmost.org';
        update_option('wpt_email_handler_club_email_list',$clubemails);
        update_option('wpt_email_handler_officer_email_list',$officeremails);
        echo '<div class="notice notice-success"><p>Added '.$clubemails[$blog_id].' and '.$officeremails[$blog_id].' email lists</p></div>';
        if(is_multisite())
            restore_current_blog();    
    }
}
add_action('wpt_wizard_screen_2','wpt_email_handler_mailing_lists_wizard');
function wpt_email_handler_mailing_lists_wizard() {
    $blog_id = get_current_blog_id();
    $parts = explode('.',$_SERVER['SERVER_NAME']);
    $clubemail = $parts[0].'@toastmost.org';
    $officeremail = $parts[0].'-officers@toastmost.org';
    printf('<p>Activate member and officer email distribution lists <input type="radio" name="toastmost_mailing_lists" value="1" checked="checked" /> Yes <input type="radio" name="wpt_email_handler_mailing_lists" value="0" /> No <br />%s to write to all members %s for officers to write to all officers.</p>',$clubemail,$officeremail);
}
add_action('wpt_wizard_screen_3','wpt_email_handler_mailing_lists_wizard_next_steps');
function wpt_email_handler_mailing_lists_wizard_next_steps() {
    $blog_id = get_current_blog_id();
    if(is_multisite())
        switch_to_blog(1);
    $clubemails = get_option('wpt_email_handler_club_email_list');
    $officeremails = get_option('wpt_email_handler_officer_email_list');
    if(!is_array($clubemails))
        $clubemails = array();
    if(!is_array($officeremails))
        $officeremails = array();
    $output = sprintf('<li><a href="https://%s/wp-admin/admin.php?page=findaclub">Configure</a> Find a Club Autoresponder / Administrative Message Forwarding. Handle routine notifications from toastmasters.org.</li>',$_SERVER['SERVER_NAME']);
    if(!empty($clubemails[$blog_id]))
        $output .= sprintf('<li>Test member email list <a target="_blank" href="mailto:%s">%s</a></li>',$clubemails[$blog_id],$clubemails[$blog_id]);
    if(!empty($officeremails[$blog_id]))
        $output .= sprintf('<li>Test officer email list <a target="_blank" href="mailto:%s">%s</a></li>',$officeremails[$blog_id],$officeremails[$blog_id]);
    if(empty($clubemails[$blog_id]))
        $output .= sprintf('<li><a href="https://%s/wp-admin/admin.php?page=wpt_email_handler_club_email_list">Turn on</a> email discussion lists for members and/or officers.</li>',$_SERVER['SERVER_NAME']);
    if($output)
        echo '<ul>'.$output.'</ul>';
    if(is_multisite())
        restore_current_blog();
}
add_action('group_email_admin_notice','wpt_email_handler_group_email_notice');
function wpt_email_handler_group_email_notice() {
    printf('<div style="padding: 10px; border: thin solid red;"><p>Toastmasters use the <a href="%s">Club Email</a> screen instead.</p></div>',admin_url('admin.php?page=wpt_email_handler_club_email_list'));
}
function get_wpt_email_handler_email_listvars($email) {
    if(is_multisite())
        switch_to_blog(1);
    $vars = get_option('listvars_'.$email);
    if(empty($vars) || !is_array($vars))
        $vars = array('whitelist' => array(),'blocked' => array(),'additional' => array());
    if(is_multisite())
        restore_current_blog();
    return $vars;
}
function set_wpt_email_handler_email_listvars($email, $vars) {
    if(is_multisite())
        switch_to_blog(1);
    foreach($vars as $index => $var)
    {
        preg_match_all ("/\b[A-z0-9][\w.-]*@[A-z0-9][\w\-\.]+\.[A-z0-9]{2,6}\b/", $var, $emails);
        $vars[$index] = $emails[0];
    }
    update_option('listvars_'.$email,$vars);
    if(is_multisite())
        restore_current_blog();
    return $vars;
    wpt_delete_forwarding_transient();
}
function wpt_email_handler_club_email_list() {
    global $wpdb, $current_user;
    $member_on = (int) get_option('member_distribution_list');
    $officer_on = (int) get_option('officer_distribution_list');
    if(isset($_POST['clubchecked'])) {
        $member_on = (int) $_POST['clubchecked'];
        update_option('member_distribution_list',$member_on);
        $vars = array();
        foreach($_POST['wpt_email_handler_member_list_vars'] as $index => $text) {
            $vars[$index] = wpt_email_list_to_array($text);
        }
        update_option('member_distribution_list_vars',$vars);
    }
    if(isset($_POST['officerchecked'])) {
        $officer_on = (int) $_POST['officerchecked'];
        update_option('officer_distribution_list',$officer_on);
        $vars = array();
        foreach($_POST['wpt_email_handler_officer_list_vars'] as $index => $text) {
            $vars[$index] = wpt_email_list_to_array($text);
        }
        update_option('officer_distribution_list_vars',$vars);
    }
    $clubemail = wpt_format_email_forwarder('members');
    $officeremail = wpt_format_email_forwarder('officers');
    $wpt_email_handler_member_list_vars = get_option('member_distribution_list_vars');
    $wpt_email_handler_officer_list_vars = get_option('officer_distribution_list_vars');
    if(empty($wpt_email_handler_member_list_vars))
        $wpt_email_handler_member_list_vars = array('whitelist' => [], 'blocked' =>  [], 'additional' =>  []);
    if(empty($wpt_email_handler_officer_list_vars))
        $wpt_email_handler_officer_list_vars = array('whitelist' =>  [], 'blocked' =>  [], 'additional' =>  []);
wpt_rsvpmaker_admin_heading(__('Email List Setup','rsvpmaker-for-toastmasters'),__FUNCTION__);
?>
<form action="<?php echo admin_url('admin.php?page=wpt_email_handler_club_email_list'); ?>" method="post">
<p>These are private distribution lists, meaning that by default only messages from members will be accepted for distribution to the members list, and only officers may write to the officers list. You can whitelist additional senders (for example, an alternate email address for a club officer), block senders, or add additional recipients (for example, an area director who isn't a member but you want to include).</p>
<h3>List for Members</h3>
<p>Member List: <input type="hidden" name="clubemail" value="<?php echo $clubemail; ?>" /> <?php echo $clubemail; ?><br />
<input type="radio" name="clubchecked" value="1" <?php if($member_on) echo 'checked="checked"'; ?> > On
<input type="radio" name="clubchecked" value="0" <?php if(!$member_on) echo 'checked="checked"'; ?> > Off  
</p>
<p>Members whitelist (additional allowed senders)<br />
<textarea rows="2" cols="100" name="wpt_email_handler_member_list_vars[whitelist]"><?php echo implode(', ',$wpt_email_handler_member_list_vars["whitelist"]); ?></textarea></p>
<p>Members emails blocked<br />
<textarea rows="2" cols="100" name="wpt_email_handler_member_list_vars[blocked]"><?php echo implode(', ',$wpt_email_handler_member_list_vars["blocked"]); ?></textarea></p>
<p>Additional recipients (also allowed to send)<br />
<textarea rows="2" cols="100" name="wpt_email_handler_member_list_vars[additional]"><?php echo implode(', ',$wpt_email_handler_member_list_vars["additional"]); ?></textarea></p>
<h3>List for Officers</h3>
<p>Officer List: <input type="hidden" name="officeremail" value="<?php echo $officeremail; ?>"> <?php echo $officeremail; ?><br />
<input type="radio" name="officerchecked" value="1" <?php if($officer_on) echo 'checked="checked"'; ?> > On
<input type="radio" name="officerchecked" value="0" <?php if(!$officer_on) echo 'checked="checked"'; ?> > Off  
</p>
<p>Officer whitelist (additional allowed senders)<br />
<textarea rows="2" cols="100" name="wpt_email_handler_officer_list_vars[whitelist]"><?php echo implode(', ',$wpt_email_handler_officer_list_vars["whitelist"]); ?></textarea></p>
<p>Officer emails blocked<br />
<textarea rows="2" cols="100" name="wpt_email_handler_officer_list_vars[blocked]"><?php echo implode(', ',$wpt_email_handler_officer_list_vars["blocked"]); ?></textarea></p>
<p>Additional recipients (also allowed to send)<br />
<textarea rows="2" cols="100" name="wpt_email_handler_officer_list_vars[additional]"><?php echo implode(', ',$wpt_email_handler_officer_list_vars["additional"]); ?></textarea></p>
<?php submit_button(); ?>
</form>
<?php    
wpt_delete_forwarding_transient();
}
function wpt_email_preferences () {
?>
<style>
label {display: inline-block; width: 175px;}
</style>
<?php
    global $current_user;
    //print_r($_REQUEST);
    if(isset($_POST['rule'])) {
        foreach($_POST['rule'] as $index => $rule)
        {
            update_user_meta($current_user->ID,$index,$rule);
        }
        printf('<div class="notice updated"><p>Preferences Updated</p></div>');
    }
    $isset = get_user_meta($current_user->ID,'email_rule_group_email',true);
    if($isset == '')
        printf('<div class="notice"><p>No Preferences Set (defaults shown below)</p></div>');
    if(isset($_GET['test'])) {
        echo rsvpmailer(array('to' => 'david@carrcommunications.com','from' => 'test@toastmost.org', 'fromname' => 'Test', 'subject' => 'Test', 'message_type' => 'test', 'html' => '<p>Test</p>' ));
    }
    printf('<h1>Email Preferences</h1><form method="post" action="%s">',admin_url('edit.php?post_type=rsvpemail&page=wpt_email_preferences'));
    wpt_toast_permit_deny ($current_user->ID,'email_rule_group_email','Group Email');
    wpt_toast_permit_deny ($current_user->ID,'email_rule_reminder','Scheduled Reminders');
    wpt_toast_permit_deny ($current_user->ID,'email_rule_test','Test');
    submit_button();
    echo '</form>';
    $unsubscribed = get_option('rsvpmail_unsubscribed');
    if(empty($unsubscribed))
        $unsubscribed = array();
    $email = strtolower($current_user->user_email);
    $status = (in_array($email,$unsubscribed)) ? 'YES' : 'NO';
    printf('<p>%s on unsubscribed list? %s</p>',$email, $status);
    echo '<p>Setting "permit" for one of the message categories shown above will override a broader "unsubscribe."</p>';
}
function wpt_toast_permit_deny ($user_id,$tag,$label) {
    $value = get_user_meta($user_id,$tag,true);
    $permit = '<option value="permit">permit</option>';
    $isdeny = ($value == 'deny') ? ' selected="selected" ' : '';   
    $deny = '<option value="deny" '.$isdeny.'>deny</option>';   
    printf('<p><label>%s</label> <select name="rule[%s]">%s</select></p>',$label,$tag,$permit.$deny);
}
function wpt_email_list_to_array($text) {
    $emails = [];
    $mess = preg_split('/[,\n\s]/',strtolower($text));
    foreach($mess as $item) {
        $item = trim($item);
        if(rsvpmail_contains_email($item) && !in_array($item,$emails))
            $emails[] = $item;
    }
return $emails;
}
function wpt_consolidated_forwarders($recipients, $blog_id) {
    $root_domain = wpt_get_site_domain(1);
    foreach($recipients as $forwarder => $target) {
        if(empty($forwarder))
            {
                unset($recipients[$forwarder]);
                continue;
            }
        if(!strpos($forwarder,$root_domain)) {
            $parts = explode('@',$forwarder);
            $root_forwarder = wpt_format_email_forwarder($parts[0],$blog_id,'root');
            $recipients['problem'] = $forwarder;
            $recipients['root_forwarder'] = $root_forwarder;
            if(strpos($forwarder,'_whitelist'))
                $recipients[$root_forwarder.'_whitelist'] = $target;
            elseif(strpos($forwarder,'_blacklist'))
                $recipients[$root_forwarder.'_blacklist'] = $target;
            else
                $recipients[$root_forwarder] = $target;
        }
    }
    $recipients['root_domain'] = $root_domain;
    return $recipients;
}
add_filter('rsvpmaker_consolidated_forwarders','wpt_consolidated_forwarders',10,2);
function wpt_email_handler_forwarders() {
    rsvpmaker_admin_heading('Email Forwarders',__FUNCTION__,'','<img style="max-width: 300px;" src="https://www.wp4toastmasters.com/wp-content/uploads/2022/05/forwarders.jpg" /><br><em>Example</em>');
    $blog_id = get_current_blog_id();
    rsvpmail_clear_allforwarders($blog_id);
    $parts = explode('.',$_SERVER['SERVER_NAME']);
    $prefix = '';
    if(sizeof($parts) > 2) {
        $prefix = array_shift($parts).'-';
        $domain = implode('.',$parts);
        if('www-' == $prefix)
            $prefix = '';
    }
    else {
        $prefix = '';
        $domain = $_SERVER['SERVER_NAME'];
    }
    $base_domain = wpt_get_site_domain(1);
    $site_domain = wpt_get_site_domain($blog_id);
    if(!empty($_POST['slug']) && !wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) )
        die('security error');
    $wpt_email_handler_custom_forwarders = get_option('custom_forwarders');
    $fix = false;
    if(empty($wpt_email_handler_custom_forwarders))
        $wpt_email_handler_custom_forwarders = array();
    else {
        foreach($wpt_email_handler_custom_forwarders as $forwarder => $target) {
            if(strpos($forwarder,'@toastmost.org@')) {
                unset($wpt_email_handler_custom_forwarders[$forwarder]);                
                $forwarder = str_replace('@toastmost.org@','@',$forwarder);
                $fix = true;
                $wpt_email_handler_custom_forwarders[$forwarder] = $target;                
            }            
        }
    }
    if($fix)
        update_option('custom_forwarders',$wpt_email_handler_custom_forwarders);
    if(isset($_POST['forward_update']))
    {
        foreach($_POST['forward_update'] as $forward_from => $forward_to_text) {
            $femail = strtolower(sanitize_text_field($forward_from));
            if(empty($femail))
                continue;
            if(!strpos($femail,$domain)) {
                unset($wpt_email_handler_custom_forwarders[$femail]);
                $femail = $prefix.$femail.'@'.$domain;
                $wpt_email_handler_custom_forwarders[$femail] = wpt_email_list_to_array($forward_to_text);
            }
            if(empty($forward_to_text))
                unset($wpt_email_handler_custom_forwarders[$femail]);
            else {
                $wpt_email_handler_custom_forwarders[$femail] = wpt_email_list_to_array($forward_to_text);
            }
        }
    }
    if(isset($_POST['slug'])) {
        foreach($_POST['slug'] as $index => $slug) {
            if(!empty($slug)){
                $slug = strtolower(preg_replace('/[^a-z0-9]/','',sanitize_text_field($slug)));
                if(($slug == 'info') || ($slug == 'officer') || ($slug == 'officers')  || ($slug == 'member')   || ($slug == 'members'))
                {
                    printf('<p>%s not allowed</p>',$slug);
                    continue;
                }
                $ffemail = $prefix.$slug.'@'.$domain;
                $wpt_email_handler_custom_forwarders[$ffemail] = wpt_email_list_to_array($_POST['forwardto'][$index]);                
            }
        }
    }
    if(!empty($wpt_email_handler_custom_forwarders)) {
        $clean = [];
        $delete = (empty($_POST['delete_forwarder'])) ? [] : $_POST['delete_forwarder'];
        foreach($wpt_email_handler_custom_forwarders as $ffemail => $targets) {
            $ffemail = strtolower($ffemail);
            if(!in_array($ffemail,$delete))
                $clean[$ffemail] = $targets;
        }
        $wpt_email_handler_custom_forwarders = $clean;
    }
    if(!empty($_POST)) {
        echo '<div class="notice notice-success"><p>Updating wpt_email_handler_custom_forwarders</p></div>';  
        update_option('custom_forwarders',$wpt_email_handler_custom_forwarders);
    }
    if(isset($_POST['rsvpmail_blacklist'])) {
        if(empty($_POST['rsvpmail_blacklist']))
            delete_option('rsvpmail_blacklist');
        else {
            $blacklist = wpt_email_list_to_array($_POST['rsvpmail_blacklist']);
            update_option('rsvpmail_blacklist',$blacklist);
        }
    }
    else
        $blacklist = get_option('rsvpmail_blacklist');
    
    $info_address = wpt_format_email_forwarder('info');
    $prefix = (strpos($info_address,'-')) ? preg_replace('/-.+/','-',$info_address) : '';
    if(isset($_GET['test'])) {
        $testrecipients = ['testy@gmail.com'];
        foreach($wpt_email_handler_custom_forwarders as $femail => $earray) {
            $testrecipients[] = $femail;
        }
        $slug_ids = get_officer_slug_ids();
        if(is_array($slug_ids)) {
            foreach($slug_ids as $slug => $ids) {
                if(!empty($ids)) {
                    $officers_fwd = wpt_format_email_forwarder($slug);
                    if(!empty($officers_fwd)) {
                        $testrecipients[] = $officers_fwd;
                    }
                }
        }
        }
        $message = sprintf('<p>Test %s</p>',var_export($testrecipients,true));
        echo $message;
        error_log($message);
        $filtered = rsvpmaker_recipients_no_problems($testrecipients);
        printf('<p>Filtered %s</p>',var_export($filtered,true));
    }
?>
<p>Use the form below to specify custom email forwarding addresses, or aliases.</p>
<p>By default, <strong><?php echo wpt_format_email_forwarder('members'); ?></strong> is used for a members email list and <strong><?php echo wpt_format_email_forwarder('officers'); ?></strong> is for an officers email lists. Forwarding addresses in the format <?php echo wpt_format_email_forwarder('vpe'); ?> are enabled based on the officers list from the <a href="<?php echo admin_url('options-general.php?page=wp4toastmasters_settings'); ?>">Toastmasters Settings</a> screen.</p>
<?php 
    if($site_domain != $base_domain) {
        printf('<div style="margin: 20px;background-color:#000;color:#fff; padding: 10px;"><p>For a site with a custom domain (other than %s), email addresses in the format %s / %s or %s / %s will work the same.</p><p>However, the @%s version requires proper email formatting setup for the domain.</p></div>',$base_domain,wpt_format_email_forwarder('members'),wpt_format_email_forwarder('members',0,'root'),wpt_format_email_forwarder('mentors'),wpt_format_email_forwarder('mentors',0,'root'),$site_domain);
    }
    $slug_ids = get_officer_slug_ids();
    if(isset($_GET['debug']))
        print_r($slug_ids);
    if(is_array($slug_ids)) {
        foreach($slug_ids as $slug => $ids) {
            if(!empty($ids))
            $alias[] = '<strong>'.wpt_format_email_forwarder($slug).'</strong>';
        }
    }
if(!empty($alias))
    printf('<p>Currently configured: %s</p>', implode(', ',$alias));
printf('<p><strong>%s</strong> forwards to the current website administrator email registered in WordPress.<p>',wpt_format_email_forwarder('admin'));
if(function_exists('toastmost_billing_email')) {
    $billing = toastmost_billing_email();
    printf('<p><strong>%s</strong> is used for Toastmost subscription status emails.</p>',$billing);
}
?>
<p>Custom forwarding addresses can be added in the format <?php echo wpt_format_email_forwarder('mycustomlabel'); ?> (example: <?php echo wpt_format_email_forwarder('mentors'); ?>).</p><p>For a default address that should be used if no other is a match, use <strong><?php echo wpt_format_email_forwarder('default'); ?></strong>.</p> <p>Recipient email addresses may be entered on separate lines or separated by commas.</p>
<form action="<?php echo admin_url('admin.php?page=wpt_email_handler_forwarders'); ?>" method="post">
<?php
if(!empty($wpt_email_handler_custom_forwarders)) {
    $index = 0;
    foreach($wpt_email_handler_custom_forwarders as $forward_from => $forward_to) {
        $forward_from = trim($forward_from);
        if(empty($forward_from))
            continue;
        printf('<p><strong>Forwarder</strong>: %s <input type="checkbox" name="delete_forwarder[]" value="%s" /> Delete</p>',$forward_from,$forward_from);
        printf('<p><strong>Forwards to</strong>: <br /><textarea name="forward_update[%s]" cols="120">%s</textarea></p>',$forward_from, implode(', ',$forward_to));
    }
}
for($i = 0; $i < 3; $i++)
{
    printf('<p><strong>Forwarder</strong>: %s<input type="text" name="slug[%d]" />@%s</p>',$prefix,$i,$domain);
    printf('<p><strong>Forwards to</strong>: <br /><textarea name="forwardto[%d]" cols="120"></textarea></p>',$i);
}
if(rsvpmaker_postmark_is_active()) {
$blacklist_text = (is_array($blacklist)) ? implode(',',$blacklist) : '';
printf('<h3>Blacklist (blocked senders)</h3><p>You can prevent messages from being delivered from spammers or other unwanted senders by adding them to this list.<br><textarea name="rsvpmail_blacklist" cols="120">%s</textarea></p>',$blacklist_text);
}
rsvpmaker_nonce();
submit_button();
echo '</form>';
if(current_user_can('manage_network')) {
$clubemails = get_blog_option(1,'toastmost_club_email_list');
if(!$clubemails)
    $clubemails = array();
$officeremails = get_blog_option(1,'toastmost_officer_email_list');
if(!$officeremails)
    $officeremails = array();
$custom_forwarders = get_blog_option(1,'toastmost_custom_forwarders_service');
global $wpdb;
$forwarders = array_merge($clubemails,$officeremails);
foreach($forwarders as $forwarder) {
    $fparts = preg_split('/[@-]/',$forwarder);
    $domain = array_pop($fparts);
    if($domain == 'toastmost.org')
    {
        $site_lookup = $fparts[0].'.toastmost.org';
        if('digitalcommunicators' == $parts[0])
            $site_lookup = 'digitalcommunicators.org';
        $list_lookup = (isset($fparts[1])) ? $fparts[1] : 'members'; //example: op@toastmost.org
    }
    else {
        $site_lookup = $domain;
        $list_lookup = $fparts[0];
    }
    $lsql = "SELECT blog_id FROM wpt_blogs WHERE domain='$site_lookup' "; error_log('email-forwarders-and-groups.php line 3282 '.$lsql);
    $list_blog_id = $wpdb->get_var($lsql);
    echo '<p>forwarder to blog id',"$forwarder lookup: $site_lookup list: $list_lookup id: $list_blog_id </p>\n";
    if($list_blog_id) {
        if('members' == $list_lookup) {
            echo '<p>Members list</p>';
            if(get_blog_option($list_blog_id,'member_distribution_list'))
                echo '<p>list active</p>';
        } 
        elseif('officers' == $list_lookup) {
            echo '<p>Officers list</p>';
            if(get_blog_option($list_blog_id,'officer_distribution_list'))
                echo '<p>list active</p>';
        }
        else 
            printf('<p>Check for forwarder %s</p>',$list_lookup); 
    }
}
}
//refresh list
wpt_flattened_forwarders();
wpt_all_flattened_forwarders();
}
function wpt_format_email_forwarder($lookup = '', $blog_id = 0, $format = '') {
    if(!$blog_id)
        $blog_id = get_current_blog_id();
    $lookup = strtolower($lookup);
    $root_domain = wpt_get_site_domain(1);
    $domain = wpt_get_site_domain($blog_id);
    $username = '';
    if(strpos($domain,$root_domain) || ('root' == $format))
        {
        $username = str_replace('.'.$root_domain,'',$domain);
        if(strpos($username,'.'))
            $username = preg_replace('/\..+/','',$username);
        $domain = $root_domain;
        }
    if(($lookup == 'members') && !empty($username))
        $lookup = '';//username@ is members list
    elseif(!empty($username)  && !empty($lookup))
        $username .= '-';
    elseif((empty($lookup)) && empty($username))
        $username = 'members';
    $username .= $lookup;
    return $username .'@' .$domain;
}
function wpt_get_site_domain($blog_id = 0) {
    if(is_multisite()) {
    if(!$blog_id)
        $blog_id = get_current_blog_id();
    $url = get_site_url($blog_id); 
    $url = str_replace('www.','',$url);
    $parts = explode('/',$url);
    return $parts[2];
    }
    else {
        $basedomain = parse_url( get_site_url(), PHP_URL_HOST );
        return str_replace('www.','',$basedomain);
    }
}
function wpt_get_hosts() {
    global $wpdb;
    if(is_multisite())
        switch_to_blog(1);
    $basedomain = parse_url( get_site_url(), PHP_URL_HOST );
    $basedomain = str_replace('www.','',$basedomain);
    if(!is_multisite())
        return array(1 => $basedomain);
    $hosts = array($basedomain);
    if(is_multisite()) {
        $sql = "SELECT * FROM $wpdb->blogs WHERE `domain` NOT LIKE '%".$basedomain."'";
        $results = $wpdb->get_results($sql);
        foreach($results as $site) {
            $hosts[$site->blog_id] = $site->domain;
        }
    }
    if(is_multisite())
        restore_current_blog();
    return $hosts;
}
function wpt_get_subdomains() {
    global $wpdb;
    if(is_multisite())
        switch_to_blog(1);
    else
        return array();
    $basedomain = parse_url( get_site_url(), PHP_URL_HOST );
    $subdomains = array();
    if(is_multisite()) {
        $sql = "SELECT * FROM $wpdb->blogs WHERE `domain` LIKE '%".$basedomain."'";
        $results = $wpdb->get_results($sql);
        foreach($results as $site) {
            $subdomains[$site->blog_id] = str_replace('.'.$basedomain,'',$site->domain);
        }
    }
    if(is_multisite())
        restore_current_blog();
    return $subdomains;
}
/* only works interactively where $_SERVER variable is set */
function wpt_is_own_domain() {
    $hosts = wpt_get_hosts();
    if(!is_multisite() || $hosts[0] == $_SERVER['SERVER_NAME'])
        return true;
    //return ID for multisite with own domain or false for none
    return array_search($_SERVER['SERVER_NAME'],$hosts);
}
function wpt_subdomain_blog_id($subdomain, $basedomain) {
    global $wpdb;
    $domain = $subdomain.'.'.$basedomain;
    $sql = "SELECT blog_id FROM $wpdb->blogs WHERE `domain` LIKE '%".$domain."'";  error_log('email-forwarders-and-groups.php line 3608 '.$sql);
    return $wpdb->get_var($sql);
}
function wpt_officer_title_to_slug ($title) {
    if(empty($title))
        return 'empty';
    $title = strtolower($title);
    if(strpos($title,'education'))
        $title = 'vpe';
    elseif(strpos($title,'membership'))
        $title = 'vpm';
    elseif(strpos($title,'public'))
        $title = 'vppr';
    elseif(strpos($title,'of pr'))
        $title = 'vppr';
    elseif(strpos($title,'arms'))
        $title = 'saa';
    elseif($title == 'district director')
        $title = 'dd';
    elseif($title == 'program quality director')
        $title = 'pqd';
    elseif($title == 'club growth director')
        $title = 'cgd';
    elseif($title == 'public relations manager')
        $title = 'prm';
    elseif($title == 'immediate past president')
        $title = 'ipp';
    elseif($title == 'logistics manager')
        $title = 'logistics';
    elseif(strpos($title,'ivision'))
        $title = str_replace('director','',str_replace('division','div',$title));
    elseif(strpos($title,'rea'))
        $title = str_replace('director','',str_replace('area','area',$title));
    $title = preg_replace('/[^a-z0-9]/','',$title);
    return $title;
}
function get_officer_slug_ids($blog_id = 0) {
    if($blog_id && is_multisite())
        switch_to_blog($blog_id);
    $wp4toastmasters_officer_ids    = get_option( 'wp4toastmasters_officer_ids' );
	$wp4toastmasters_officer_titles = get_option( 'wp4toastmasters_officer_titles' );
	$wp4toastmasters_officer_slugs = get_option( 'wp4toastmasters_officer_slugs' );
    if(isset($_GET['debug']))
        printf("<pre>ids %s \ntitles %s \nslugs %s</pre>",var_export($wp4toastmasters_officer_ids,true),var_export($wp4toastmasters_officer_titles,true),var_export($wp4toastmasters_officer_slugs,true));
    if(empty($wp4toastmasters_officer_ids))
        return array();
    if(empty($wp4toastmasters_officer_slugs)) {
        $wp4toastmasters_officer_slugs = array();
        foreach($wp4toastmasters_officer_titles as $index => $title)
            if(!empty($title))
                $wp4toastmasters_officer_slugs[$index] = wpt_officer_title_to_slug($title);
        update_option('wp4toastmasters_officer_slugs',$wp4toastmasters_officer_slugs);
    }
    foreach($wp4toastmasters_officer_ids as $index => $id) {
        if(!isset($wp4toastmasters_officer_slugs[$index])) {
            if(!empty($wp4toastmasters_officer_titles[$index]))
            {
                $slug = wpt_officer_title_to_slug($wp4toastmasters_officer_titles[$index]);
                $wp4toastmasters_officer_slugs[$index] = $slug;
                update_option('wp4toastmasters_officer_slugs',$wp4toastmasters_officer_slugs);
            }
            else
                continue;
        }
        else
            $slug = $wp4toastmasters_officer_slugs[$index];
        $slug_ids[$slug][] = $id;
    }
    if($blog_id && is_multisite())
        restore_current_blog();
    return $slug_ids;
}
function unempty ($slug) { return ($slug != 'empty'); }
add_shortcode('title_abbrev_tester','title_abbrev_tester');
function title_abbrev_tester() {
$output = '';
$titles = array('President','VP of Education','VPE','VP of Public Relations','Vice President of Public Relations','VP of PR','Division B Director','Area 21 Director','Director Area 21','Logistics Manager','Chief Cook & Bottle Washer','District Director','Program Quality Director');
foreach($titles as $title) {
    $output .= sprintf('<p>%s demo-%s@toastmost.org</p>',$title,officer_title_to_slug($title));
}
return $output;
}
function rsvpmaker_relay_bot_check( ) {
    global $wpdb;
    if(is_multisite())
        switch_to_blog(1);
    ob_start();
	$active = get_option( 'rsvpmaker_discussion_active' );
    $output = '';
    if($active)
        $output .= '<p>Email processing bot is active</p>';
	rsvpmaker_relay_queue();
    $output .= $qresult;
    if(rsvpmaker_postmark_is_live()) {
        $output .= 'Postmark email delivery is active';
    }
    elseif($active) {
        $output .= '<p>'.rsvpmaker_relay_get_pop( 'bot', true ).'</p>';
        $sql = "SELECT count(*) FROM $wpdb->postmeta WHERE meta_key='rsvprelay_to' ";
        $in_q = $wpdb->get_var($sql);
        if($in_q)   
            $output .= "<p>$in_q messages queued for delivery</p>";    
    }
    if(is_multisite())
        restore_current_blog();
    return $output;
}
function wpt_get_officer_emails() {
    $recipients = array();
    $blog_id = get_current_blog_id();
    $listvars = (is_multisite() && $blog_id) ? get_blog_option($blog_id,'officer_distribution_list_vars') : get_option('officer_distribution_list_vars');
    $officers = (is_multisite() && $blog_id) ? get_blog_option($blog_id,'wp4toastmasters_officer_ids') : get_option('wp4toastmasters_officer_ids');
    if($officers && is_array($officers)) {
        foreach($officers as $id) {
            $member = get_userdata($id);
            if($member) {
                $email = strtolower($member->user_email);
                if(!in_array($email,$unsubscribed))
                    $recipients[] = $email;
            }
        }
    if(!empty($listvars['additional']))
    foreach($listvars['additional'] as $email) {
        if(!in_array($email,$unsubscribed))
            $recipients[] = $email;
    }
    }
    return $recipients;
}
function wpt_member_email_check() {
    rsvpmaker_admin_heading('Member Email Check',__FUNCTION__);
    echo '<p>This screen allows you to see whether any members have unsubscribed from email notifications, indicated a preference against receiving group email messages and event notifications, or have bad email addresses associated with their member profiles.</p>';
    
    $members = get_club_members();
    $output = '';
    foreach($members as $member) {
        $problem = rsvpmail_is_problem($member->user_email);
        if(strpos($problem,'ManualSuppression')) {
            $suppressions[] = strtolower($member->user_email);
        }
        $rsvpmailer_rule = apply_filters('rsvpmailer_rule','permit',$member->user_email, 'group_email');
        if($rsvpmailer_rule == 'deny') {
            $problem .= ' blocks group email and forwarding';
        }
        $status = (empty($problem)) ? '<span style="color:green; font-weight: bold;">OK</span>' : '<span style="color:red; font-weight: bold;">'.$problem.'</span>';
        $output .= '<p>'.$member->display_name.' '.$member->user_email.' '.$status.'</p>';
    }
    if(!empty($suppressions))
        do_action('rsvpmaker_postmark_suppressions',$suppressions);
    if(empty($_POST))
    echo $output;
}
function wpt_email_forwarder_recipients($forwarder) {
    $address = explode('@',$forwarder);
    $recipients = array();
    $hosts_and_subdomains = rsvpmaker_get_hosts_and_subdomains();
    if(!in_array($address[1],$hosts_and_subdomains) && ($address[1]!=$hosts_and_subdomains['basedomain']))
        return;
    $hosts = wpt_get_hosts();
    $subdomains = wpt_get_subdomains();
    $ffemails = (is_multisite()) ? get_blog_option(1,'findclub_emails') : get_option('findclub_emails');
    if(is_multisite()) {
        //returns 0 for main host, blog_id for subdomains
        $blog_id = array_search($address[0],$hosts);
        if($blog_id) {//has own domain
            $slug = $address->mailbox;
        } else {
            $parts = explode('-',$address[0]);
            $subdomain = $parts[0];
            if(sizeof($parts) > 1)
                $slug = $parts[1]; //op-officers
            elseif(in_array($subdomain,$subdomains))
                $slug = 'members';
            else
                $slug = $address[0];
            $blog_id = array_search($subdomain,$subdomains); // wpt_subdomain_blog_id($subdomain, $hosts[0]);
            if(!$blog_id && $address[0] == $hosts[0])
                $blog_id = 1;//root domain, no subdomain
        }
    }
    else {
        $blog_id = 1;
        $slug = $address->mailbox;
    }
    if($ffemails && is_array($ffemails))
    $finda_id = array_search($forwarder,$ffemails);
else
    $finda_id = 0;
if(!empty($finda_id)) {
    $blog_id = $finda_id;
    $forward_by_id = ($blog_id == 1)  ? get_option('wpt_forward_general') : get_blog_option($blog_id,'wpt_forward_general');
    if(is_array($forward_by_id)) {
        $recipients = $forward_by_id;
    }
}
if($slug == 'members') {
    $on = is_multisite() ? get_blog_option($blog_id,'member_distribution_list') : get_option('member_distribution_list');
    if($on) {
        $recipients = array_merge($recipients,get_club_member_emails($blog_id));
        $listvars = (is_multisite() && $blog_id) ? get_blog_option($blog_id,'member_distribution_list_vars') : get_option('member_distribution_list_vars');
        if(!empty($listvars['additional']))
        foreach($listvars['additional'] as $email) {
            if(!in_array($email,$unsubscribed))
                $recipients[] = $email;
        }    
    }
}
if('officers' == $slug) {
    $listvars = (is_multisite() && $blog_id) ? get_blog_option($blog_id,'officer_distribution_list_vars') : get_option('officer_distribution_list_vars');
    $officers = (is_multisite() && $blog_id) ? get_blog_option($blog_id,'wp4toastmasters_officer_ids') : get_option('wp4toastmasters_officer_ids');
    $on = is_multisite() ? get_blog_option($blog_id,'officer_distribution_list') : get_option('officer_distribution_list');
    if($on && $officers && is_array($officers)) {
        foreach($officers as $id) {
            $member = get_userdata($id);
            if($member && !empty($member->user_email)) {
                $email = strtolower($member->user_email);
                if(!in_array($email,$unsubscribed))
                    $recipients[] = $email;
            }
        }
    if(!empty($listvars['additional']))
    foreach($listvars['additional'] as $email) {
        if(!in_array($email,$unsubscribed))
            $recipients[] = $email;
    }
    }
}
$slug_ids = get_officer_slug_ids($blog_id);
if(!empty(	$slug_ids [$slug]))
{
    foreach($slug_ids[$slug] as $user_id) {
        if($user_id) {
            $officer = get_userdata($user_id);
            $recipients[] = $officer->user_email;
        }
    }
}
$custom_forwarders = (is_multisite()) ? get_blog_option($blog_id,'custom_forwarders') : get_option('custom_forwarders');
if(!empty($custom_forwarders[$forwarder]))
{
    $recipients = array_merge($custom_forwarders[$forwarder],$recipients);
}
return $recipients;
}
//	$mail = apply_filters('rsvpmailer_mail',$mail);
add_filter('rsvpmailer_mail','wpt_mail_forwarders');
function wpt_mail_forwarders($mail) {
    $recipients = wpt_email_forwarder_recipients($mail['to']);
    if(empty($recipients))
        return $mail;
    else {
        $returnto = array_pop($recipients);
        foreach($recipients as $to) {
            $mail['to'] = $to;
            rsvpmailer($mail);
        }
        $mail['to'] = $returnto;
        return $mail;
    }
}
add_filter('rsvpmail_recipients_from_forwarders','wpt_slugs_to_recipients',10,4);
function wpt_slugs_to_recipients($recipients,$slug_and_id,$from,$addresses) {
    $slug = $slug_and_id['slug'];
    $blog_id = $slug_and_id['blog_id'];
    $eparts = rsvpmail_email_to_parts($slug_and_id['forwarder']);
    $custom_forwarders = (is_multisite()) ? get_blog_option($blog_id,'custom_forwarders') : get_option('custom_forwarders');
    foreach($addresses as $forwarder) {
        if(!empty($from) && ('members' == $slug)) {
            $on = (int) (is_multisite() && $blog_id) ? get_blog_option($blog_id,'member_distribution_list', true) : get_option('member_distribution_list', true);
            if(!$on)
                return;
            $listvars = (is_multisite() && $blog_id) ? get_blog_option($blog_id,'member_distribution_list_vars') : get_option('member_distribution_list_vars');
            $mrecipients = get_club_member_emails($blog_id);
            $recipients = array_merge($mrecipients,$recipients);
            if(!empty($listvars['additional']))
            foreach($listvars['additional'] as $email) {
                $recipients[] = $email;
            }
            if((!in_array($from,$recipients) && !in_array($from,$listvars['whitelist'])) || in_array($from,$listvars['blocked']) ) {
                return 'BLOCKED'; //NOT FROM A RECOGNIZED MEMBER ADDRESS
            }
        }
        if(!empty($from) && ('officers' == $slug)) {
            //$output .= sprintf('<p>officers %s</p>',$forwarder);
            $on = (int) (is_multisite()) ? get_blog_option($blog_id,'officer_distribution_list') : get_option('officer_distribution_list');
            if(!$on)
                return;
            $listvars = (is_multisite() && $blog_id) ? get_blog_option($blog_id,'officer_distribution_list_vars') : get_option('officer_distribution_list_vars');
            $officers = (is_multisite() && $blog_id) ? get_blog_option($blog_id,'wp4toastmasters_officer_ids') : get_option('wp4toastmasters_officer_ids');
            if($officers && is_array($officers)) {
                foreach($officers as $id) {
                    $member = get_userdata($id);
                    if($member) {
                        $email = strtolower($member->user_email);
                        $off[] = $email;
                    }
                }
                if(!empty($off))
                    $recipients = array_merge($off,$recipients);
            if(!empty($listvars['additional']))
            foreach($listvars['additional'] as $email) {
                $recipients[] = $email;
            }
    
            if((!in_array($from,$recipients) && !in_array($from,$listvars['whitelist'])) || in_array($from,$listvars['blocked']) ) {
                return 'BLOCKED'; //NOT FROM A RECOGNIZED MEMBER ADDRESS
            }
            }
        }
        if(('info' == $slug)) {
            if((strcasecmp($from,'BaseCamp@toastmasters.org') == 0) ) {
                $basecamp = ($blog_id == 1) ? get_option('wpt_forward_basecamp') : get_blog_option($blog_id,'wpt_forward_basecamp');    
            }
            if(is_array($basecamp))
                return $basecamp;//send just to basecamp managers 
            $forward_by_id = ($blog_id == 1)  ? get_option('wpt_forward_general') : get_blog_option($blog_id,'wpt_forward_general');
        
            if(is_array($forward_by_id))
                $recipients = array_merge($forward_by_id,$recipients);
        }
        $slug_ids = get_officer_slug_ids($blog_id);
        if(!empty(	$slug_ids [$slug]))
        {
            foreach($slug_ids[$slug] as $user_id) {
                if($user_id) {
                    $officer = get_userdata($user_id);
                    $orecipients[] = $officer->user_email;
                }
            }
            if(!empty($orecipients))
            $recipients = array_merge($orecipients,$recipients);
        }
        if(!empty($forwarder) && !empty($custom_forwarders[$forwarder]))
        {
            //hack
            if('admins@toastmost.org'==$forwarder && 'david@carrcommunications.com' != $emailobj->From)
                return array();
            $recipients = array_merge($recipients,$custom_forwarders[$forwarder]);
        }
    }
    $unsubscribed = get_option('rsvpmail_unsubscribed');
    if(!empty($recipients)) {
        if(is_array($unsubscribed))
        $recipients = wpt_remove_unsubscribed($recipients, $unsubscribed);
        $recipients = array_unique($recipients);
    }
    return $recipients;
}
//apply_filters('rsvpmail_slug_and_id',array('slug' => '','blog_id'=>0),$email);
add_filter('rsvpmail_slug_and_id','wpt_find_club_emails',10,2);
function wpt_find_club_emails($slug_and_id, $forwarder) {
    global $ffemails, $message_blog_id;
    $blog_id = 0;
    if(empty($ffemails))
    $ffemails = (is_multisite()) ? get_blog_option(1,'findclub_emails') : get_option('findclub_emails');
    if($ffemails && is_array($ffemails))
        $blog_id = array_search(trim($forwarder),$ffemails);
    if($blog_id) {
        $message_blog_id = $blog_id; // used for logging
        $slug_and_id = array('slug' => 'info','blog_id' => $blog_id);
    }
    return $slug_and_id;
}
add_action('rsvpmail_relay_slug_and_id','wpt_handle_autoresponder',10,3);
function wpt_handle_autoresponder($slug_and_id,$forwarder,$emailobj) {
    global $ffemails;
    $slug = is_array($slug_and_id) ? $slug_and_id['slug'] : '';
    $finda_id = $blog_id = is_array($slug_and_id) ? $slug_and_id['blog_id'] : 0;
    $output = '';
    if($slug != 'info') {
        //check for a different registered address
        if(empty($ffemails))
            $ffemails = (is_multisite()) ? get_blog_option(1,'findclub_emails') : get_option('findclub_emails');
        if($ffemails && is_array($ffemails))
            $finda_id = array_search($forwarder,$ffemails);
        else
            $finda_id = 0;
        if($finda_id)
            $blog_id = $finda_id;
        if(!is_array($ffemails) || !in_array(strtolower($forwarder),$ffemails))
            return;
    }
    $from = $emailobj->From;
    $to = $emailobj->ToFull[0]->Email;
    preg_match_all('/[a-zA-Z_\-\.]+@[a-zA-Z_\-]+?\.[a-zA-Z_\-]{2,3}/',$emailobj->HtmlBody,$fcmatches);
    preg_match('/Email address:\s*([a-zA-Z_\-\.]+@[a-zA-Z_\-]+?\.[a-zA-Z_\-]{2,3})/',$emailobj->TextBody,$email_match);
    $findacontact = (empty($email_match[1])) ? '' : $email_match[1];
    if(strpos($from,'google.com') && strpos($emailobj->Subject,'Forward'))
    {
        foreach($fcmatches[0] as $email) {
            if(strpos($email,'google') || strpos($email,'findaclub'))
                continue;
            $contact = $email;
        }
        $hosts = wpt_get_hosts();
        $mail['fromname'] = (is_multisite()) ? get_option('blogname',true) : get_blog_option($blog_id,'blogname',true);
        $mail['html'] = '<p>Your website\'s Find-a-Club bot is forwarding this Google confirmation message back to you, allowing you to approve it yourself.</p>'."\n".$emailobj->HtmlBody.'<p>forwarder:'.$forwarder.' blog id '.$blog_id.'</p>';
        $mail['to'] = $contact;
        $mail['subject'] = 'Verify gmail forwarding for '.$to;
        rsvpmailer($mail);
        $output .= "<p>Forward $forwarder gmail forwarding confirmation</p>";
        return $output;
    }
    if($findacontact)// && ($from == 'clubleads@toastmasters.org'))
    {
        $blog_id = $finda_id;
        wpt_email_handler_autoresponder ($findacontact, $from, $blog_id);
        $output .= sprintf('<p>autoresponder %s for %s, contact %s</p>',$finda_id,$forwarder, $contact,'line 5373');
    }
    
    $forward_by_id = ($blog_id == 1)  ? get_option('wpt_forward_general') : get_blog_option($blog_id,'wpt_forward_general');
    $basecamp = ($blog_id == 1) ? get_option('wpt_forward_basecamp') : get_blog_option($blog_id,'wpt_forward_basecamp');
    if(empty($basecamp))
        $basecamp = $forward_by_id;
    if(is_array($basecamp) && (strcasecmp($from,'BaseCamp@toastmasters.org') == 0) ) {
        $mail['html'] = $emailobj->HtmlBody; //$parts[0];
        $mail['subject'] = $emailobj->Subject;
        $mail['from'] = $emailobj->From;
        $mail['fromname'] = (empty($emailobj->FromName)) ? $emailobj->From : $emailobj->FromName;
        foreach($basecamp as $fto) {
            $mail['to'] = $fto;
            rsvpmailer($mail);
        }
    $output .= sprintf('<p>forarded %s basecamp message to %s</p>',$forwarder, var_export($fto,true));
    }
    
    if(is_array($forward_by_id)) {
        $output .= sprintf('<p><strong>forward by id %s %s</strong></p>',$forwarder, var_export($forward_by_id,true));
        wpt_email_handler_qemail($qpost, $forward_by_id, $from, $fromname, $blog_id);
    }
    return $output;   
}
function wpt_get_consolidated_forwarders($blog_id, $subdomain, $domain) {
    $join = ($subdomain) ? '-' : '';
    $slug_ids = get_officer_slug_ids($blog_id);
    if($slug_ids) {
        foreach($slug_ids as $slug => $slug_id) {
        foreach($slug_id as $user_id) {
                if($user_id) {
                    $officer = get_userdata($user_id);
                    $recipients[$subdomain.$join.$slug.'@'.$domain][] = $officer->user_email;
                }
            }
        }
    }
    $forward_by_id = (is_multisite()) ? get_blog_option($blog_id,'wpt_forward_general') : get_option('wpt_forward_general');
    $basecamp = (is_multisite()) ? get_blog_option($blog_id,'wpt_forward_basecamp') : get_option('wpt_forward_basecamp');
    if($forward_by_id) {
        $ffemail = (is_multisite()) ? get_blog_option($blog_id,'findafriend_email') : get_option('findafriend_email');
        mail('david@carrcommunications.com','fwd options',"forward by id\n".var_export($forward_by_id,true),"\nbasecamp\n".var_export($basecamp,true)."\n\n".$ffemail);
        $recipients[$ffemail] = [];
        foreach($forward_by_id as $forwarder => $email) {
            if(empty($recipients[$email]))
                $recipients[$ffemail][] = $email;
            else
                foreach($recipients[$email] as $f)
                    $recipients[$ffemail][] = $f;
            }
    }
    if($basecamp) {
        $recipients[$subdomain.$join.'basecamp@'.$domain] = [];
        foreach($basecamp as $forwarder => $email) {
            if(empty($recipients[$email]))
                $recipients[$subdomain.$join.'basecamp@'.$domain][] = $email;
            else
                foreach($recipients[$email] as $f)
                    $recipients[$subdomain.$join.'basecamp@'.$domain][] = $f;
        }
    }
    $custom_forwarders = (is_multisite()) ? get_blog_option($blog_id,'custom_forwarders') : get_option('custom_forwarders');
    if(!empty($custom_forwarders))
    {
        $recipients[$forwarder] = [];
        foreach($custom_forwarders as $forwarder => $emails) {
            foreach($emails as $email) {
                if(!empty($recipients[$email])) {
                    $recipients[$forwarder] = array_merge($recipients[$forwarder], $recipients[$email]);
                }
                else {
                    $recipients[$forwarder][] = $email;
                }
            }
        }
    }
    $members_on = (is_multisite() && $blog_id) ? get_blog_option($blog_id,'member_distribution_list', true) : get_option('member_distribution_list', true);
    $officers_on = (is_multisite()) ? get_blog_option($blog_id,'officer_distribution_list') : get_option('officer_distribution_list');
    if($members_on) {
        $listvars = (is_multisite() && $blog_id) ? get_blog_option($blog_id,'member_distribution_list_vars') : get_option('member_distribution_list_vars');
        $list_email = ($subdomain) ? $subdomain.'@'.$domain : "members@".$domain;
        $recipients[$list_email] = get_club_member_emails($blog_id);
        if(!empty($listvars['additional']))
        foreach($listvars['additional'] as $email) {
            $recipients[$list_email][] = $email;
        }
        $listvars[$list_email.'_whitelist'] = $listvars['whitelist'];
    }
    if($officers_on) {
        $listvars = (is_multisite() && $blog_id) ? get_blog_option($blog_id,'officer_distribution_list_vars') : get_option('officer_distribution_list_vars');
        $list_email = ($subdomain) ? $subdomain.'-officers@'.$domain : "officers@".$domain;
        $officers = (is_multisite() && $blog_id) ? get_blog_option($blog_id,'wp4toastmasters_officer_ids') : get_option('wp4toastmasters_officer_ids');
        if($officers && is_array($officers)) {
            foreach($officers as $id) {
                $member = get_userdata($id);
                if($member) {
                    $email = strtolower($member->user_email);
                    $recipients[$list_email][] = $email;
                }
            }
            if(!empty($listvars['additional']))
            foreach($listvars['additional'] as $email) {
                $recipients[$list_email][] = $email;
            }
            $recipients[$list_email.'_whitelist'] = $listvars['whitelist'];
    }
    }
    return $recipients;
}
add_shortcode('consolidated_forwarders_test','consolidated_forwarders_test');
function consolidated_forwarders_test() {
$forwarders = wpt_get_consolidated_forwarders(109,'op','toastmost.org');
return '<pre>'.var_export($forwarders,true).'</pre>';   
}
add_filter('rsvpmail_email_match','rsvpemail_match_findaclub',10,4);
function rsvpemail_match_findaclub($to,$from,$breakdown,$emailobj) {
    rsvpmaker_testlog('findaclub_to',$to);
    rsvpmaker_testlog('findaclub_breakdown',$breakdown);
    //preg_match('/[a-zA-Z0-9_\-\.]+@[a-zA-Z0-9_\-]+?\.[a-zA-Z_\-]{2,20}/',$emailobj->HtmlBody,$fcmatch);
    //match non-traditional email, patterns like .co.uk
    preg_match('/[a-zA-Z0-9_\-\.]+@[a-zA-Z0-9_\-\.]+/',$emailobj->HtmlBody,$fcmatch);
    rsvpmaker_testlog('findaclub_matches',$fcmatch);
    rsvpmaker_testlog('findaclub_contact',$fcmatch[0]); 
    rsvpmaker_testlog('findaclub_email',$emailobj); 
    rsvpmaker_testlog('findaclub_subject',$emailobj->Subject); 
    rsvpmaker_testlog('findaclub_from',$from); 
    $ffemail = (is_multisite()) ? get_blog_option($breakdown['blog_id'],'findafriend_email') : get_option('findafriend_email');
    if($to == $ffemail) {
        $prefix = $breakdown['subdomain'] ? $breakdown['subdomain'].'-' : '';
        if(strpos($from,'asecamp@toastmasters.org'))
            $to = $prefix.'basecamp@'.$breakdown['domain'];
    }
    //if(strpos($from,'toastmasters.org') && strpos($emailobj->Subject,'prospective')) {
    if(strpos($emailobj->Subject,'prospective member')) {
        rsvpmaker_testlog('clubleads-message-to',$fcmatch[0]);
        if(!empty($fcmatch[0])) {
            rsvpmaker_testlog('clubleads-message-triggered',$fcmatch[0]);
            //active version as of June 2024
            wpt_email_handler_autoresponder ($fcmatch[0], $from, $breakdown['blog_id']);
        }
    }
    return $to;
}
add_action('profile_update','wpt_delete_forwarding_transient');
add_action('add_user_to_blog','wpt_delete_forwarding_transient');
function wpt_delete_forwarding_transient() {
    if(is_multisite())
        switch_to_blog(1);
    delete_transient('allforwarders_'.get_current_blog_id());
    if(is_multisite())
        restore_current_blog();
}
add_filter('rsvpmail_post_for_email','wpt_post_for_email');
function wpt_post_for_email($epost) {
    global $email_context,$post;
    $backup = $post;
    $email_context = true;
    if(strpos($epost->post_content,'wp:wp4toastmasters/role'))
    {
        $post = $epost;
        $epost->post_content = "\n\n".do_blocks($epost->post_content)."\n\n";
        $epost->post_content = preg_replace('/ - <a href="[^"]+">One-Click Signup<\/a>/','',$epost->post_content);
        $epost->post_content = str_replace('<div','<p',str_replace('</div>','</p>',$epost->post_content));
        $epost->post_content = preg_replace('/<p[^>]*>/',"<!-- wp:paragraph -->\n<p>",str_replace('</p>',"</p>\n<!-- /wp:paragraph -->\n\n",$epost->post_content));
        $epost->post_content = preg_replace('/<h3[^>]*>/',"<!-- wp:heading {\"level\":3} -->\n<h3>",str_replace('</h3>',"</h3>\n<!-- /wp:heading -->\n\n",$epost->post_content));
        $epost->post_content = preg_replace('/<span[^>]*>/','',str_replace('</span>','',$epost->post_content));
        $epost->post_content = preg_replace('/\n{3,}>/',"\n\n",$epost->post_content);
    }
    $post = $backup;
    return $epost;
}
function toastmasters_officer_single( $atts ) {
	$title                          = ( isset( $atts['title'] ) ) ? $atts['title'] : 'VP of Education';
	$wp4toastmasters_officer_ids    = get_option( 'wp4toastmasters_officer_ids' );
	$wp4toastmasters_officer_titles = get_option( 'wp4toastmasters_officer_titles' );
	$index                          = array_search( $title, $wp4toastmasters_officer_titles );
	if ( $index === false ) {
		return;
	}
	$officer_id = $wp4toastmasters_officer_ids[ $index ];
	$contact = '';
	if ( $officer_id ) {
		$userdata                       = get_userdata( $officer_id );
		$contactmethods['home_phone']   = __( 'Home Phone', 'rsvpmaker-for-toastmasters' );
		$contactmethods['work_phone']   = __( 'Work Phone', 'rsvpmaker-for-toastmasters' );
		$contactmethods['mobile_phone'] = __( 'Mobile Phone', 'rsvpmaker-for-toastmasters' );
		$contactmethods['user_email']   = __( 'Email', 'rsvpmaker-for-toastmasters' );
		$contact                        = '<div><strong>' . $title . ': ' . $userdata->first_name . ' ' . $userdata->last_name . '</strong></div>';
		foreach ( $contactmethods as $name => $value ) {
			if ( strpos( $name, 'phone' ) && ! empty( $userdata->$name ) ) {
				$contact .= sprintf( "<div>%s: %s</div>\n", $value, $userdata->$name );
			}
		}
		$contact .= sprintf( '<div>' . __( 'Email', 'rsvpmaker-for-toastmasters' ) . ': <a href="mailto:%s">%s</a></div>' . "\n", $userdata->user_email, $userdata->user_email );
	}
	return $contact;
}
function toastmasters_officer_email_by_title( $title, $site_id = 0 ) {
	$wp4toastmasters_officer_ids    = ($site_id) ? get_blog_option( $site_id, 'wp4toastmasters_officer_ids' ) : get_option( 'wp4toastmasters_officer_ids' );
	$wp4toastmasters_officer_titles = ($site_id) ? get_blog_option( $site_id,'wp4toastmasters_officer_titles' ) : get_option( 'wp4toastmasters_officer_titles' );
	$wp4toastmasters_officer_slugs = ($site_id) ? get_blog_option( $site_id,'wp4toastmasters_officer_titles' ) : get_option( 'wp4toastmasters_officer_slugs' );
	$index                          = array_search( $title, $wp4toastmasters_officer_titles );
	$slug_index                    = array_search( $title, $wp4toastmasters_officer_slugs );
	if ( $slug_index !== false ) {
		$officer_id = $wp4toastmasters_officer_ids[ $slug_index ];
	}
	elseif ( $index !== false ) {
		$officer_id = $wp4toastmasters_officer_ids[ $index ];
	}
	if(empty($officer_id))
		return;
	$userdata                       = get_userdata( $officer_id );
	if ( !empty($userdata->user_email) ) {
		return $userdata->user_email;
	}
}
function toastmasters_officer_email_array( $site_id = 0 ) {
	$wp4toastmasters_officer_ids    = ($site_id) ? get_blog_option( $site_id, 'wp4toastmasters_officer_ids' ) : get_option( 'wp4toastmasters_officer_ids' );
	$wp4toastmasters_officer_titles = ($site_id) ? get_blog_option( $site_id,'wp4toastmasters_officer_titles' ) : get_option( 'wp4toastmasters_officer_titles' );
	$wp4toastmasters_officer_slugs = ($site_id) ? get_blog_option( $site_id,'wp4toastmasters_officer_slugs' ) : get_option( 'wp4toastmasters_officer_slugs' );
	$dp = wpt_domain_prefix($site_id);
	foreach($wp4toastmasters_officer_ids as $index => $id) {
		if(!$id)
			continue;
		$userdata = get_userdata( $id );
		if ( !empty($userdata->user_email) && !strpos($userdata->user_email,'example.com') ) {
			$slug = strtolower($wp4toastmasters_officer_slugs[$index]);
			$officer_emails[$dp['prefix'].$slug.'@'.$dp['domain']] = $userdata->user_email;
		}
	}
	$officer_emails[$dp['prefix'].'admin@'.$dp['domain']] = ($site_id) ? get_blog_option( $site_id,'admin_email' ) : get_option( 'admin_email' );
	return $officer_emails;
}

//$mail = apply_filters('rsvpmailer_mail',$mail);

add_filter('rsvpmailer_mail','wpt_check_local_forwarders',10,1);
function wpt_check_local_forwarders($mail) {
    $mail['to'] = strtolower($mail['to']);
    $forwarders = wpt_flattened_forwarders($mail['blog_id']);
    if(!empty($forwarders[$mail['to']]))
        $mail['to'] = (sizeof($forwarders[$mail['to']]) > 1) ? $forwarders[$mail['to']] : $forwarders[$mail['to']][0];
    return $mail;
}

function wpt_flattened_forwarders($site_id = 0) {
	$forwarders = array();
	$officer_emails = toastmasters_officer_email_array($site_id);
	foreach($officer_emails as $key => $value) {
		$forwarders[$key] = array($value);
	}
    $wpt_email_handler_custom_forwarders = ($site_id) ? get_blog_option($site_id,'custom_forwarders') : get_option('custom_forwarders');
    if(empty($wpt_email_handler_custom_forwarders))
        $wpt_email_handler_custom_forwarders = array();
    else {
        foreach($wpt_email_handler_custom_forwarders as $forwarder => $targets) 
		{
			foreach($targets as $target) {
				$target = trim($target);
                if(empty($target))
                    continue;
                $target = strtolower($target);
				if(isset($officer_emails[$target])) {
					$target = $officer_emails[$target];
				}
				$forwarders[$forwarder][] = $target;
			}
		}
	}
	update_option('flattened_forwarders',$forwarders);
	if(!$site_id && is_multisite()) {
		if(get_current_blog_id() != 1) {
            delete_blog_option(1,'all_flattened_forwarders'); //reset so it will be rebuilt
		}
	}
	return $forwarders;
}
function wpt_all_flattened_forwarders() {
    if(is_multisite()) {
        if(get_current_blog_id() != 1) {
            if(isset($_GET['page']))
            echo '<p>wpt_all_flattened_forwarders must be run from main site</p>';
            return;
        }
        $forwarders = isset($_GET['reset']) ? null : get_option('all_flattened_forwarders');
        if(empty($forwarders)) {
            $forwarders = array();
            $sites = get_sites(array('public' => 1, 'limit' => 1000, 'number' => 1000));
            foreach($sites as $site) {
                $local_forwarders = wpt_flattened_forwarders($site->blog_id);
                $forwarders = array_merge($forwarders,$local_forwarders);
                if(isset($_GET['page']))
                printf('<p><strong>added %s forwarders from %s</strong></p><pre>%s</pre>',sizeof($local_forwarders),$site->domain,var_export($local_forwarders,true));
            }
            update_option('all_flattened_forwarders',$forwarders);
        }
    }
    else 
        $forwarders = wpt_flattened_forwarders();
    if(isset($_GET['page']))
        printf('<p>Total flattened forwarders %s</p><pre>%s</pre>',sizeof($forwarders),var_export($forwarders,true));
    return $forwarders;
}
function wpt_domain_prefix( $site_id = 0 ) {
	$url = ($site_id) ? get_blog_option( $site_id,'siteurl' ) : get_option( 'siteurl' );
	$domain = parse_url(strtolower($url), PHP_URL_HOST);
	$dp = explode('.',$domain);
	$prefix = '';
	if(sizeof($dp) > 2)
		$prefix = array_shift($dp).'-';
    if('www-' == $prefix)
        $prefix = '';
	$base_domain = implode('.',$dp);
	return array('prefix' => $prefix, 'domain' => $base_domain);
}
