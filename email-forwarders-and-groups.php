<?php

add_action('init','keep_relay_alive');
function keep_relay_alive () {
    $blog_id = get_current_blog_id();
    if($blog_id && !wp_next_scheduled('rsvpmaker_relay_init_hook'))
        wp_schedule_event( time()+120, 'doubleminute', 'rsvpmaker_relay_init_hook' );
}

add_action('rsvpmaker_autoreply','wpt_email_handler_automation',15,7);

add_action('admin_menu','wpt_email_menu');
function wpt_email_menu () {
    add_menu_page( __('TM Email', 'rsvpmaker-for-toastmasters' ), __( 'TM Email', 'rsvpmaker-for-toastmasters' ), 'read', 'wpt_email_handler_page', 'wpt_email_handler_page', 'https://toastmost.org/click16.png', '2.03' );
    add_submenu_page('wpt_email_handler_page', 'Email Lists', 'Email Lists', 'manage_options', 'toastmost_club_email_list', 'toastmost_club_email_list');  
    add_submenu_page('wpt_email_handler_page', 'Email Forwarding', 'Email Forwarding', 'manage_options', 'toastmost_forwarders', 'toastmost_forwarders');
    add_submenu_page('wpt_email_handler_page', 'Email Status', 'Email Status', 'read', 'toastmost_email_status', 'toastmost_email_status');
    add_submenu_page('wpt_email_handler_page', 'Find a Club Autoresponder / Notifications Forwarding', 'Find a Club Autoresponder / Notifications Forwarding', 'manage_options', 'findaclub', 'findaclub');    
}

function wpt_email_handler_page () {
    echo '<h1>Email Services</h1><p>Check if activated or provide instructions</p>';
}

function wpt_email_handler_automation($qpost, $to, $from, $toaddress, $fromname, $toarray, $ccarray) {
    echo '<h1>wpt_email_handler_automation triggered</h1>';

    $output = $to;

    $hosts = wpt_get_hosts();
    if(empty($ccarray))
        $addresses = $toarray;
    else
        $addresses = array_merge($toarray, $ccarray);
    $output .= var_export($addresses);
    foreach($addresses as $address) {
        $forwarder = $address->mailbox.'@'.$address->host;
        if(!in_array($address->host,$hosts))
            continue;
        //returns 0 for main host, blog_id for subdomains
        $blog_id = array_search($address->host,$hosts);
        echo 'initial blog id '.$blog_id;
        $subdomain = '';
        $parts = explode('-',$address->mailbox);
        print_r($parts);
        $members = false;
        if(sizeof($parts) > 1) {
            $subdomain = $parts[0];
            $slug = $parts[1];
            if(is_multisite())
                $blog_id = wpt_subdomain_blog_id($subdomain, $hosts[0]);
            if($slug == 'members')
                $members = true;
        }
        else {
            $slug = $address->mailbox; // example members at domain or op in op@toastmost.org
            if(is_multisite())
                $blog_id = wpt_subdomain_blog_id($slug, $hosts[0]);
            if($blog_id)
                $members = true; // example op@toastmost.org where subdomain only is member address
            elseif($slug == 'members')
                $members = true;
        }
        $output .= sprintf('<p>%s@%s blog_id %d router %s </p>',$address->mailbox, $address->host, $blog_id, $slug);
        if($members)
            $output .= '<p>is members list</p>';

        $ffemails = (is_multisite()) ? get_blog_option(1,'findclub_emails') : get_option('findclub_emails');
        if($ffemails && is_array($ffemails))
            $finda_id = array_search($forwarder,$ffemails);
        else
            $finda_id = 0;

        if($finda_id && strpos($from,'google.com') && strpos($qpost['post_title'],'Forward'))
        {
            preg_match_all('/\w+@[a-zA-Z_\-]+?\.[a-zA-Z_\-]{2,3}/',$qpost["post_content"],$matches);
            foreach($matches[0] as $email) {
                if(strpos($email,'google') || strpos($email,'findaclub'))
                    continue;
                $contact = $email;
            }
            $mail['html'] = '<p>The Toastmost Find-a-Club bot is forwarding this Google confirmation message back to you, allowing you to approve it yourself.</p>'."\n".$qpost['post_content'].'<p>forwarder:'.$forwarder.' blog id '.$blog_id.'</p>';
            $mail['to'] = $contact;
            $mail['from'] = 'noreply@toastmost.org';
            $mail['fromname'] = 'Toastmost.org';
            $mail['subject'] = 'Verify gmail forwarding for '.$to;
            rsvpmailer($mail);
        }
        if(strcasecmp($to,'findaclub@toastmost.org')) //should only be true for gmail confirmation
            continue;
    
        $qpost['post_content'] .= '<p>Forwarded from '.$forwarder.'</p>';
    
        if(!empty($finda_id) && $slug = 'info') {
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
            continue;
            }
            if(is_array($forward_by_id)) {
                $output .= sprintf('<p>forward by id %s</p>',$forwarder);
                toastmost_qemail($qpost, $forward_by_id, $from, $fromname, $blog_id);
                $sentmail = true;
            }    
        }

        if(!empty($finda_id) && ($from == 'clubleads@toastmasters.org') )
        {
            $blog_id = $finda_id;
            preg_match_all('/\w+@[a-zA-Z_\-]+?\.[a-zA-Z_\-]{2,3}/',$qpost["post_content"],$matches);
            foreach($matches[0] as $email) {
                if(strpos($email,'toastmasters.org') || strpos($email,'@toastmost.org') || (strcasecmp($email, $forwarder) == 0))
                    continue;
                $contact = $email;
            }
            $sentmail = send_wpt_autoresponder ($contact, $from, $blog_id);
        }
        if(!empty($sentmail))
            continue;

        if($members) {
            $on = (int) (is_multisite() && $blog_id) ? get_blog_option($blog_id,'member_distribution_list', true) : get_option('member_distribution_list', true);
            $output .= sprintf('<p>members %s</p>',$forwarder);
            $output .= sprintf('<p>%s</p>',$on);
            if(!$on)
                continue;
            $listvars = (is_multisite() && $blog_id) ? get_blog_option($blog_id,'member_distribution_list_vars') : get_blog_option('member_distribution_list_vars');
            $recipients = get_club_member_emails($blog_id);
            if(!empty($listvars['additional']))
            foreach($listvars['additional'] as $email) {
                if(!in_array($email,$unsubscribed))
                    $recipients[] = $email;
            }
            rsvpmaker_debug_log($recipients,'club recipients');
            if((!in_array($from,$recipients) && !in_array($from,$listvars['whitelist'])) || in_array($from,$listvars['blocked']) ) {
                toastmost_qemail_blocked($qpost, $from, $forwarder, $blog_id);
                continue;
            }
            $unsubscribed = get_option('rsvpmail_unsubscribed');
            if(empty($unsubscribed))
                $unsubscribed = array();
            if($blog_id){
                $club_unsub = get_blog_option($blog_id,'rsvpmail_unsubscribed');
                if($club_unsub && is_array($club_unsub))
                {
                    $unsubscribed = array_unique(array_merge($unsubscribed,$club_unsub));
                }
            }
            $qpost['post_title'] = '['.$slug.'] '.$qpost['post_title'];
            toastmost_bcc($qpost, $recipients, $from, $fromname,$blog_id, $forwarder.' email list');
            rsvpmaker_debug_log($forwarder,'toastmost_qemail');
            continue;
        }

        if('officers' == $slug) {
            $output .= sprintf('<p>officers %s</p>',$forwarder);
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
                toastmost_qemail_blocked($qpost, $from, $forwarder);
                continue;
            }
            $slug = str_replace('@toastmost.org','',$forwarder);
            $qpost['post_title'] = '['.$slug.'] '.$qpost['post_title'];
            toastmost_bcc($qpost, $recipients, $from, $fromname, $blog_id, $forwarder.' email list');
            }
            continue;
        }

        $officer_ids    = (is_multisite()) ? get_blog_option( $blog_id, 'wp4toastmasters_officer_ids' ) : get_option( 'wp4toastmasters_officer_ids' );
        $officer_titles = (is_multisite()) ? get_blog_option( $blog_id, 'wp4toastmasters_officer_titles' ) : get_option( 'wp4toastmasters_officer_titles' );
        if(is_array($officer_ids))
        {
            foreach($officer_ids as $index => $user_id) {
                if($user_id > 0)
                {
                    $title = $officer_titles[$index];
                    if(strpos($title,'Education'))
                        $title = 'vpe';
                    elseif(strpos($title,'Membership'))
                        $title = 'vpm';
                    elseif(strpos($title,'Public'))
                        $title = 'vppr';
                    elseif(strpos($title,'PR'))
                        $title = 'vppr';
                    elseif(strpos($title,'Arms'))
                        $title = 'saa';
                    $title = strtolower($title);
                    $title = preg_replace('/[^a-z]/','',$title);
                    if($title == $slug)
                    {
                        $officer = get_userdata($user_id);
                        $recipients[] = $officer->user_email;
                    }
                $titles[$user_id] = $title;
                }
            }
        }
        if(!empty($recipients)) {
            $recipients = array_unique($recipients);
            $qpost['post_content'] = "<p>Forwarded from $forwarder</p>\n".$qpost['post_content'];
            $output .= sprintf('<p>officer forwarders %s</p>',var_export($recipients,true));
            toastmost_qemail($qpost, $recipients, $from, $fromname, $blog_id);
            continue;
        }

        $custom_forwarders = (is_multisite()) ? get_blog_option($blog_id,'custom_forwarders') : get_option('custom_forwarders');
        if(!empty($custom_forwarders[$forwarder]))
        {
            $qpost['post_content'] = "<p>Forwarded from $forwarder</p>\n".$qpost['post_content'];
            $recipients = $custom_forwarders[$forwarder];
            $output .= sprintf('<p>custom forwarders toastmost_bcc %s</p>',$forwarder);
            toastmost_bcc($qpost, $recipients, $from, $fromname, $blog_id, $forwarder.' email forwarder');
            continue;
        }

            //$output .= $members;
    } // end loop through emails
    echo $output;
    $mail['html'] = $output;
    $mail['to'] = 'david@carrcommunications.com';
    $mail['subject'] = 'mail handler test';
    $mail['from'] = 'bot@toastmost.org';
    $mail['fromname'] = 'toastmost';
    rsvpmailer($mail);
}

function toastmost_qemail_blocked ($qpost, $from, $forwarder) {
    $rmail['subject'] = 'BLOCKED '.$qpost['post_title'];
    $rmail['to'] = $from;
    $rmail['html'] = '<p>'.$from .' is not authorized to send to the '.$forwarder." email list.</p>\n<p>Authorized senders include email addresses associated with member accounts, as well as addresses whitelisted by a club website administrator on the TM Administration -> Toastmost Club Email screen.</p>";
    $rmail['from'] = get_option('admin_email');
    $rmail['fromname'] = get_option('blogname');
    rsvpmailer($rmail);    
}

function toastmost_qemail ($qpost, $recipients, $from, $fromname = '', $blog_id = 0) {
        if(is_multisite())
            switch_to_blog(1);
        $post_id = 0;
        if(!empty($qpost['post_content']) && !empty($from))  
            $post_id = wp_insert_post($qpost);
        update_post_meta($post_id,'sending website',$blog_id);
        $html .= var_export($qpost,true);

        if($post_id) {
            //add_post_meta($post_id,'imap_message_id',$headerinfo->message_id);
            add_post_meta($post_id,'rsvprelay_from',$from);
            add_post_meta($post_id,'all_recipients',$recipients);
            //for debugging
            //add_post_meta($post_id,'imap_body',imap_body($mail,$n));
            if(empty($fromname))
                $fromname = $from;
            add_post_meta($post_id,'rsvprelay_fromname',$fromname);
    
            if(!empty($recipients))
    
            foreach($recipients as $to) {
    
                $rsvpmailer_rule = apply_filters('rsvpmailer_rule','',$to, 'email_rule_group_email');
    
                if ($rsvpmailer_rule == 'permit')
    
                    add_post_meta($post_id,'rsvprelay_to',$to);        
    
                elseif($rsvpmailer_rule=='deny') {
    
                    rsvpmaker_debug_log($to,'group email blocked');            
    
                }
                add_post_meta($post_id,'rsvprelay_to',$to);
            }
        }
        if(is_multisite())
        restore_current_blog();
}

function toastmost_bcc ($qpost, $recipients, $from, $fromname = '', $blog_id = 0, $forwarder_label = '') {
    if (($key = array_search($from, $recipients)) !== false) {
        unset($recipeients[$key]);
    }
    $mail['from'] = $from;
    $mail['fromname'] = $fromname;
    $mail['bcc'] = $recipients;
    $mail['to'] = 'noreply@toastmost.org';
    $mail['subject'] = $qpost['post_title'];
    $mail['html'] = $qpost['post_content'];
    if($forwarder_label)
        $mail['toname'] = $forwarder_label;
    rsvpmailer($mail);
    //restore_current_blog();
}

function send_wpt_autoresponder ($email, $from, $blog_id = 1) {
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
    $mail['from'] = ($blog_id == 1) ? get_option('findafriend_email') : get_blog_option($blog_id,'findafriend_email');
    if(rsvpmaker_cronmail_check_duplicate($email.$mail['from'].$mail['subject']))//added subject June 2021
        return true;//already sent
    $mail['fromname'] = ($blog_id == 1) ? get_option('blogname') : get_blog_option($blog_id,'blogname');
    if($from == 'clubleads@toastmasters.org') {
        //send for real
        $mail['to'] = $email;
        rsvpmailer($mail);
        rsvpmaker_debug_log($blog_id,'autoresponder blog id');
        rsvpmaker_debug_log($mail,'autoresponder email');
   }
    $autoreplyto[] = $email;
    //else {
    //for testing
    $mail2 = $mail;
    $mail2['to'] = (is_multisite()) ? get_blog_option($blog_id,'admin_email') : get_option('admin_email');
    $mail2['subject'] = "autoreply sent to $email: ".$mail['subject'];
    $mail2['html'] .= "<p>Email: $email</p>";
    rsvpmailer($mail2);
    //}
    //$wpdb->query("delete from $wpdb->posts WHERE post_type='rsvpemail' AND post_title LIKE '%sNew prospective member for your club' ");
    return $mail;
}

function findaclub () {
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

$o = '<option>Select a Message</option><option value="new">Create Message</option>';
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
        preg_match_all ("/\b[A-z0-9][\w.-]*@[A-z0-9][\w\-\.]+\.[A-z0-9]{2,6}\b/", strtolower($_POST['forward']), $emails);
        $forward = array_splice($emails[0],0,5);
        update_option('wpt_forward_general',$forward);
    }
    if(empty($_POST['basecamp'])) {
        delete_option('wpt_forward_basecamp');
        $basecamp = array();
    }
    else {
        preg_match_all ("/\b[A-z0-9][\w.-]*@[A-z0-9][\w\-\.]+\.[A-z0-9]{2,6}\b/", strtolower($_POST['basecamp']), $emails);
        $basecamp = array_splice($emails[0],0,5);
        update_option('wpt_forward_basecamp',$basecamp);
    }
    update_option('findafriend_email',$ffemail);
    $ffpage = $_POST['ffpage'];
    if($ffpage == 'new') {
        $content = sprintf('<!-- wp:paragraph -->
        <p>Learn more about our club at <a href="https://%s">%s</a></p>
        <!-- /wp:paragraph -->',$_SERVER['SERVER_NAME'],$_SERVER['SERVER_NAME']);
        $ffpage = wp_insert_post( array('post_author' => $current_user->ID, 'post_status' => 'publish','post_type' => 'rsvpemail','post_title' => 'Thank you for your interest in '.get_option('blogname'), 'post_content' => $content) );
    }
    if($ffpage)
        update_option('findafriend_page',$ffpage);
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
<h1>Find a Club / Notifications Setup</h1>
<form action="<?php echo admin_url('admin.php?page=findaclub'); ?>" method="post">
<p><input type="radio" name="bot" value="1" <?php if($botchecked) echo ' checked="checked" '; ?> >  I will register <?php echo $botemail.$ordomain; ?> as the club's email address in Club Central</p>
<p><input type="radio" name="bot" value="0" <?php if(!$botchecked) echo ' checked="checked" '; ?> > I have set up forwarding to findaclub@toastmost.org from this address:<br />
<input type="text" name="ffemail" value="<?php if(!$botchecked) echo $ffemail; ?>" />
<br /><em>Example: myclub@gmail.com (<a href="https://www.wp4toastmasters.com/2021/01/05/use-the-toastmost-find-a-club-email-bot-with-gmail/" target="_blank">GMail setup example</a>)</em></p>
<p>Automatic response content:<br /><select name="ffpage"><?php echo $o; ?></select>
</p>
<p>
General forwarding (limit 5 email addresses) <br />
<textarea name="forward" rows="2" cols="60">
<?php if(is_array($forward)) echo implode(', ',$forward); ?>
</textarea>
<br /><em>Intended for use with <?php echo $botemail; ?>. Separate emails with commas or line breaks.</em>
</p>
<p>
BaseCamp forwarding (limit 5 email addresses) <br />
<textarea name="basecamp" rows="2" cols="60">
<?php if(is_array($basecamp)) echo implode(', ',$basecamp); ?>
</textarea>
<br /><em>Intended for use with <?php echo $botemail; ?>. Separate emails with commas or line breaks.</em>
</p>
<?php submit_button(); 
if($ffpage) {
    printf('<p><a href="%s&post=%d">Edit Message</a></p>',admin_url('post.php?&action=edit'),$ffpage);
    $post = get_post($ffpage);
    printf('<h2>%s</h2>',$post->post_title);
    echo (empty($post->post_content)) ? '<p>(no content)</p>' : $post->post_content;
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
}

function get_club_email_lists($blog_id = 0) {
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

function set_club_email_lists($lists, $blog_id = 0) {
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

add_action('wpt_wizard_post','toastmost_mailing_lists_wizard_post');
function toastmost_mailing_lists_wizard_post() {
    if(isset($_POST['toastmost_mailing_lists'])) {
        $blog_id = get_current_blog_id();
        if(is_multisite())
            switch_to_blog(1);
        $clubemails = get_option('toastmost_club_email_list');
        $officeremails = get_option('toastmost_officer_email_list');
        if(empty($clubemails))
            $clubemails = array();
        if(empty($officeremails))
            $officeremails = array();
        $parts = explode('.',$_SERVER['SERVER_NAME']);
        $clubemails[$blog_id] = $parts[0].'@toastmost.org';
        $officeremails[$blog_id] = $parts[0].'-officers@toastmost.org';
        update_option('toastmost_club_email_list',$clubemails);
        update_option('toastmost_officer_email_list',$officeremails);
        echo '<div class="notice notice-success"><p>Added '.$clubemails[$blog_id].' and '.$officeremails[$blog_id].' email lists</p></div>';
        if(is_multisite())
            restore_current_blog();    
    }
}

add_action('wpt_wizard_screen_2','toastmost_mailing_lists_wizard');
function toastmost_mailing_lists_wizard() {
    $blog_id = get_current_blog_id();
    $parts = explode('.',$_SERVER['SERVER_NAME']);
    $clubemail = $parts[0].'@toastmost.org';
    $officeremail = $parts[0].'-officers@toastmost.org';
    printf('<p>Activate member and officer email distribution lists <input type="radio" name="toastmost_mailing_lists" value="1" checked="checked" /> Yes <input type="radio" name="toastmost_mailing_lists" value="0" /> No <br />%s to write to all members %s for officers to write to all officers.</p>',$clubemail,$officeremail);
}

add_action('wpt_wizard_screen_3','toastmost_mailing_lists_wizard_next_steps');
function toastmost_mailing_lists_wizard_next_steps() {
    $blog_id = get_current_blog_id();
    if(is_multisite())
        switch_to_blog(1);
    $clubemails = get_option('toastmost_club_email_list');
    $officeremails = get_option('toastmost_officer_email_list');
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
        $output .= sprintf('<li><a href="https://%s/wp-admin/admin.php?page=toastmost_club_email_list">Turn on</a> email discussion lists for members and/or officers.</li>',$_SERVER['SERVER_NAME']);
    if($output)
        echo '<ul>'.$output.'</ul>';
    if(is_multisite())
        restore_current_blog();
}

add_action('group_email_admin_notice','toastmost_group_email_notice');
function toastmost_group_email_notice() {
    printf('<div style="padding: 10px; border: thin solid red;"><p>Toastmost.org users use the <a href="%s">Toastmost Club Email</a> screen instead.</p></div>',admin_url('admin.php?page=toastmost_club_email_list'));
}

function get_toastmost_email_listvars($email) {
    if(is_multisite())
        switch_to_blog(1);
    $vars = get_option('listvars_'.$email);
    if(empty($vars) || !is_array($vars))
        $vars = array('whitelist' => array(),'blocked' => array(),'additional' => array());
    if(is_multisite())
        restore_current_blog();
    return $vars;
}
function set_toastmost_email_listvars($email, $vars) {
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
}

function toastmost_club_email_list() {
    global $wpdb, $current_user;
    $member_on = (int) get_option('member_distribution_list');
    $officer_on = (int) get_option('officer_distribution_list');
    if(isset($_POST['clubchecked'])) {
        $member_on = (int) $_POST['clubchecked'];
        update_option('member_distribution_list',$member_on);
        $vars = array();
        foreach($_POST['toastmost_member_list_vars'] as $index => $text) {
            $text = strtolower($text);
            preg_match_all ("/\b[A-z0-9][\w.-]*@[A-z0-9][\w\-\.]+\.[A-z0-9]{2,6}\b/", $text, $emails);
            $vars[$index] = $emails[0];
        }
        update_option('member_distribution_list_vars',$vars);

        //set_toastmost_email_listvars($clubemail,$vars);
        //    set_toastmost_email_listvars($officeremail,$vars);
    }
    if(isset($_POST['officerchecked'])) {
        $officer_on = (int) $_POST['officerchecked'];
        update_option('officer_distribution_list',$officer_on);
        $vars = array();
        foreach($_POST['toastmost_officer_list_vars'] as $index => $text) {
            $text = strtolower($text);
            preg_match_all ("/\b[A-z0-9][\w.-]*@[A-z0-9][\w\-\.]+\.[A-z0-9]{2,6}\b/", $text, $emails);
            $vars[$index] = $emails[0];
        }
        update_option('officer_distribution_list_vars',$vars);
    }

    $parts = explode('.',$_SERVER['SERVER_NAME']);
    $prefix = '';
    if(sizeof($parts) > 2) {
        $members = array_shift($parts);
        $prefix = $members.'-';
    }
    else {
        $members = 'members';
        $prefix = '';
    }
    $basedomain = implode('.',$parts);
    $clubemail = $members .'@'.$basedomain;
    $officeremail = $prefix .'officers@'.$basedomain;
    $toastmost_member_list_vars = get_option('member_distribution_list_vars');
    $toastmost_officer_list_vars = get_option('officer_distribution_list_vars');
?>
<h1>Toastmost Email List Setup</h1>
<form action="<?php echo admin_url('admin.php?page=toastmost_club_email_list'); ?>" method="post">
<p>These are private distribution lists, meaning that by default only messages from members will be accepted for distribution to the members list, and only officers may write to the officers list. You can whitelist additional senders (for example, an alternate email address for a club officer), block senders, or add additional recipients (for example, an area director who isn't a member but you want to include).</p>
<h3>List for Members</h3>
<p>Member List: <input type="hidden" name="clubemail" value="<?php echo $clubemail; ?>" /> <?php echo $clubemail; ?><br />
<input type="radio" name="clubchecked" value="1" <?php if($member_on) echo 'checked="checked"'; ?> > On
<input type="radio" name="clubchecked" value="0" <?php if(!$member_on) echo 'checked="checked"'; ?> > Off  
</p>
<p>Members whitelist (additional allowed senders)<br />
<textarea rows="2" cols="100" name="toastmost_member_list_vars[whitelist]">
<?php echo implode(', ',$toastmost_member_list_vars["whitelist"]); ?>
</textarea></p>
<p>Members emails blocked<br />
<textarea rows="2" cols="100" name="toastmost_member_list_vars[blocked]">
<?php echo implode(', ',$toastmost_member_list_vars["blocked"]); ?>
</textarea></p>
<p>Additional recipients (also allowed to send)<br />
<textarea rows="2" cols="100" name="toastmost_member_list_vars[additional]">
<?php echo implode(', ',$toastmost_member_list_vars["additional"]); ?>
</textarea></p>
<h3>List for Officers</h3>
<p>Officer List: <input type="text" name="officeremail" value="<?php echo $officeremail; ?>"> <br />
<input type="radio" name="officerchecked" value="1" <?php if($officer_on) echo 'checked="checked"'; ?> > On
<input type="radio" name="officerchecked" value="0" <?php if(!$officer_on) echo 'checked="checked"'; ?> > Off  
</p>
<p>Officer whitelist (additional allowed senders)<br />
<textarea rows="2" cols="100" name="toastmost_officer_list_vars[whitelist]">
<?php echo implode(', ',$toastmost_officer_list_vars["whitelist"]); ?>
</textarea></p>
<p>Officer emails blocked<br />
<textarea rows="2" cols="100" name="toastmost_officer_list_vars[blocked]">
<?php echo implode(', ',$toastmost_officer_list_vars["blocked"]); ?>
</textarea></p>
<p>Additional recipients (also allowed to send)<br />
<textarea rows="2" cols="100" name="toastmost_officer_list_vars[additional]">
<?php echo implode(', ',$toastmost_officer_list_vars["additional"]); ?>
</textarea></p>
<?php submit_button(); ?>
</form>

<?php    
}

function toast_email_preferences () {
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

    printf('<h1>Email Preferences</h1><form method="post" action="%s">',admin_url('edit.php?post_type=rsvpemail&page=toast_email_preferences'));
    toast_permit_deny ($current_user->ID,'email_rule_group_email','Group Email');
    toast_permit_deny ($current_user->ID,'email_rule_reminder','Scheduled Reminders');
    toast_permit_deny ($current_user->ID,'email_rule_test','Test');
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

function toast_permit_deny ($user_id,$tag,$label) {
    $value = get_user_meta($user_id,$tag,true);
    $permit = '<option value="permit">permit</option>';
    $isdeny = ($value == 'deny') ? ' selected="selected" ' : '';   
    $deny = '<option value="deny" '.$isdeny.'>deny</option>';   
    printf('<p><label>%s</label> <select name="rule[%s]">%s</select></p>',$label,$tag,$permit.$deny);
}

function toastmost_forwarders() {
    $parts = explode('.',$_SERVER['SERVER_NAME']);
    $prefix = '';
    if(sizeof($parts) > 2) {
        $prefix = array_shift($parts).'-';
        $domain = implode('.',$parts);
    }
    else {
        $prefix = '';
        $domain = $_SERVER['SERVER_NAME'];
    }

    $toastmost_custom_forwarders = get_option('toastmost_custom_forwarders');
    if(empty($toastmost_custom_forwarders))
        $toastmost_custom_forwarders = array();
    if(!empty($_POST['slug']) && !wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) )
        die('security error');
        $toastmost_custom_forwarders = get_option('custom_forwarders');
    if(empty($toastmost_custom_forwarders))
            $toastmost_custom_forwarders = array();
    if(isset($_POST['forward_update']))
    {
        foreach($_POST['forward_update'] as $forward_from => $forward_to_text) {
            $femail = sanitize_text_field($forward_from);
            if(empty($forward_to_text))
                unset($toastmost_custom_forwarders[$femail]);
            else {
                preg_match_all('/[^@\s,]+@[^@]+\.[a-z]+/',strtolower($forward_to_text),$matches);
                $toastmost_custom_forwarders[$femail] = $matches[0];
            }
        }
    }

    if(isset($_POST['slug'])) {
        foreach($_POST['slug'] as $index => $slug) {
            if(!empty($slug)){
                $slug = strtolower(preg_replace('/[^a-z0-9]/','',sanitize_text_field($slug)));
                //echo $slug;
                if(($slug == 'info') || ($slug == 'officer') || ($slug == 'officers')  || ($slug == 'member')   || ($slug == 'members'))
                {
                    printf('<p>%s not allowed</p>',$slug);
                    continue;
                }
                $forwardto = strtolower($_POST['forwardto'][$index]);
                preg_match_all('/[^@\s,]+@[^@]+\.[a-z]+/',$forwardto,$matches);
                echo $forwardto;
                print_r($matches);
                echo ' '.$femail = $prefix.$slug.'@'.$domain;
                $toastmost_custom_forwarders[$femail] = $matches[0];                
            }
        }
    }
    if(isset($_POST)) {
        printf('<p>Updating toastmost_custom_forwarders %s</p>', var_export($toastmost_custom_forwarders,true));  
        update_option('custom_forwarders',$toastmost_custom_forwarders);
    }
 

    $officer_ids    = get_option( 'wp4toastmasters_officer_ids' );
    $officer_titles = get_option( 'wp4toastmasters_officer_titles' );
    if(is_array($officer_ids))
    {
        foreach($officer_ids as $index => $user_id) {
            if($user_id > 0)
            {
                $title = $officer_titles[$index];
                if(strpos($title,'Education'))
                    $title = 'vpe';
                elseif(strpos($title,'Membership'))
                    $title = 'vpm';
                elseif(strpos($title,'Public'))
                    $title = 'vppr';
                elseif(strpos($title,'PR'))
                    $title = 'vppr';
                elseif(strpos($title,'Arms'))
                    $title = 'saa';
                $title = strtolower($title);
                $title = preg_replace('/[^a-z]/','',$title);
                $alias[] = $prefix.$title.'@toastmost.org';
            }
        }
    }
?>
<h2>Email Forwarders</h2>
<p>In addition to <?php echo $prefix; ?>info@toastmost.org, <?php echo $prefix; ?>@toastmost.org, and <?php echo $prefix; ?>officers@toastmost.org, forwarding addresses in the format <?php echo $prefix; ?>-president@toastmost.org are enabled based on the officers list from the <a href="<?php echo admin_url('options-general.php?page=wp4toastmasters_settings'); ?>">Toastmasters Settings</a> screen.</p>
<?php 
if(!empty($alias))
    printf('<p>Currently configured: %s</p>', implode(', ',$alias)); ?>
<p>The form below allows to to add custom forwarding addresses in the format <?php echo $prefix; ?><em>label</em>@toastmost.org (example: <?php echo $prefix; ?>-mentorship@toastmost.org). A list of email addresses to forward to may be entered on separate lines or separated by commas.</p>
<form action="<?php echo admin_url('admin.php?page=toastmost_forwarders'); ?>" method="post">
<?php
if(!empty($toastmost_custom_forwarders)) {
    foreach($toastmost_custom_forwarders as $forward_from => $forward_to) {
        printf('<p><strong>Forwarder</strong>: %s</p>',$forward_from);
        printf('<p><strong>Forwards to</strong>: <br /><textarea name="forward_update[%s]" cols="120">%s</textarea></p>',$forward_from, implode(', ',$forward_to));
    }
}
for($i = 0; $i < 3; $i++)
{
    printf('<p><strong>Forwarder</strong>: %s<input type="text" name="slug[%d]" />@%s</p>',$prefix,$i,$domain);
    printf('<p><strong>Forwards to</strong>: <br /><textarea name="forwardto[%d]" cols="120"></textarea></p>',$i);
}
rsvpmaker_nonce();
submit_button();
echo '</form>';

if(current_user_can('manage_network')) {
$clubemails = get_blog_option(1,'toastmost_club_email_list');
$officeremails = get_blog_option(1,'toastmost_officer_email_list');
$custom_forwarders = get_blog_option(1,'toastmost_custom_forwarders_service');
global $wpdb;
$forwarders = array_merge($clubemails,$officeremails);
$forwarders[] = 'members@digitalcommunicators.org';
$forwarders[] = 'officers@digitalcommunicators.org';
$forwarders[] = 'vpe@digitalcommunicators.org';
$forwarders[] = 'op-vpe@toastmost.org';
$forwarders[] = 'testyy-vpe@toastmost.org';
$forwarders[] = 'testyy@toastmost.org';

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
    $lsql = "SELECT blog_id FROM wpt_blogs WHERE domain='$site_lookup' ";
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

}

function wp4t_format_email_forwarder($lookup = '') {
    $root_domain = wp4t_get_site_domain(1);
    $domain = wp4t_get_site_domain();
    $username = '';
    if(strpos($domain,$root_domain))
        {
        $username = str_replace('.'.$root_domain,'',$domain);
        $domain = $root_domain;
        }
    if(!empty($username) && !empty($lookup))
        $username .= '-';
    elseif(empty($lookup) && empty($username))
        $username = 'members';
    $username .= $lookup;
    return $username .'@' .$domain;
}

function wp4t_get_site_domain($blog_id = 0) {
    if(!$blog_id)
        $blog_id = get_current_blog_id();
    $url = get_site_url($blog_id); 
    $parts = explode('/',$url);
    return str_replace('www.','',$parts[2]);
}

function wpt_get_hosts() {
    global $wpdb;
    $basedomain = parse_url( get_site_url(), PHP_URL_HOST );
    $hosts = array($basedomain);
    if(is_multisite()) {
        $sql = "SELECT * FROM $wpdb->blogs WHERE `domain` NOT LIKE '%".$basedomain."'";
        $results = $wpdb->get_results($sql);
        foreach($results as $site) {
            $hosts[$site->blog_id] = $site->domain;
        }
    }
    return $hosts;
}

function wpt_subdomain_blog_id($subdomain, $basedomain) {
    global $wpdb;
    $domain = $subdomain.'.'.$basedomain;
    $sql = "SELECT blog_id FROM $wpdb->blogs WHERE `domain` LIKE '%".$domain."'";
    return $wpdb->get_var($sql);
}
