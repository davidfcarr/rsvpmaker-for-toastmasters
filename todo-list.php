<?php

add_shortcode('wp4t_todolist','wp4t_todolist_short');
function wp4t_todolist_short () {
    $blog_id = (is_multisite()) ? get_current_blog_id() : 1;
    $list = wp4t_todolist($blog_id);
    return $list;
}

function wp4t_todolist_screen() {
    $blog_id = (is_multisite()) ? get_current_blog_id() : 1;
    echo wp4t_todolist($blog_id);
}

function wp4t_todolist($blog_id, $send = false) {
    global $wpdb;
    if(!get_site($blog_id))
        return; //maybe a deleted test site

    if(is_multisite())
    switch_to_blog($blog_id);

    $wizard_timestamp = (int) get_option('wp4t_setup_wizard_used');
    if(!$wizard_timestamp)
        $todo['wizard'] = 'If you are still at the beginning of setting up your website, the setup wizard can make that easier.';

    if('page' == get_option('show_on_front')) {
        $home = get_option('page_on_front');
        $post = get_post($home);
        if(strpos($post->post_content,'Your custom welcome message here'))
            $todo['homepage'] =  'Home page still says "Your custom welcome message here"';
        else
            $done['homepage'] = 'Freshen up your home page?';        
    }

    //customize the agenda 
    $template = get_option('default_toastmasters_template');
    $revisions = wp_get_post_revisions($template);
    $agendaprompt = 'Update the agenda template to set up a standard model for the roles displayed on the agenda (and the signup form), as well as agenda notes ("stage directions" for the flow of the meeting), and timing for each activity.';
    if($revisions) {
        $done['agenda_customized'] = $agendaprompt;
    }
    else {
        $todo['agenda_customized'] = $agendaprompt;
    }
    //metric here?

    $members = get_club_members();
    $member_count = sizeof($members);
    if($member_count > 1)
        $done['members'] = "You have created $member_count member accounts. The more the merrier! You can create more member accounts one at a time, or import your whole membership list (which can be downloaded from toastmasters.org)";
    else
        $todo['members'] = 'Inviting in at least a few other members will make this website a more interesting place. You can create member accounts one at a time, or import your whole membership list (which can be downloaded from toastmasters.org).';
    //use the agenda to plan meetings
    $speaker_signups = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key LIKE '_Speaker%' ");
    $speaker_activity = sizeof($speaker_signups);
    if($speaker_activity)
        $done['agenda_use'] = $speaker_activity .' speaker signups on the agenda';
    else
        $todo['agenda_use'] = 'Get speakers to sign up on the agenda';

    $done['confirmation'] = '<strong>Meeting online?</strong> Edit your guest registration confirmation message to include online meeting details.';

    if($home)
    {
        $featured_image = get_the_post_thumbnail_url($home);
        if($featured_image) {
            /*
            $defaultimages = array('MEL_665-scaled',
            'public-speaking-3956908_1920',
            'MEL_534-scaled',
            'NBM_1721-scaled',
            '2019-LASTUDIO-5-scaled',
            '2019-LASTUDIO-6-scaled',
            '2019-LASTUDIO-7-scaled',
            '2019-LASTUDIO-8-scaled',
            '2019-LASTUDIO-9-scaled',
            '2019-LASTUDIO-16-scaled');
            $is_default = false;
            foreach($defaultimages as $img)
            {
                if(strpos($featured_image, $img))
                    $is_default = true;
            }
            if($is_default)
                $todo['change_featured_image'] = 'How to change the default image on the home page. Your current theme (WordPress design) is set up to use featured images at the top of the page, which can be different from page to page. Currently, you have one of the featured images from the initial setup on the home page.';
            else
                $done['change_featured_image'] = 'Looks like you know how to change the featured image, but here is a reminder just in case.';
            */
            $done['change_featured_image'] = 'Your current theme (WordPress design) is set up to let you set a featured images for each page. If you do not like the one currently shown on the home page, you can change it or remove it. You can have a different featured image for each page.';
        }
        //does the home page have a featured image? Is it one of the defaults? Instructions on how to change
    }
    //add_theme_support( 'custom-header' ); get_header_image() 
    if(current_theme_supports('custom-header')) {
        //how to change
        $done['change_custom_header'] = 'Your current theme (WordPress design) allows you to set a custom image that appears at the top of each page. You can change the one that is currently displayed.';
    }
    /*
    $theme = get_option('current_theme');
    $status['theme'] = $theme;
    $theme_changed = (('Lectern' != $theme) && ('Twenty Nineteen TM' != $theme));
    if($theme_changed)
        $done['change_theme'] = 'Looks like you have already changed the default theme.';
    else
    */
    $done['change_theme'] = "If you don't like the way your website looks, you have the option of changing the theme (design) and customizing from there.";
    //give advice for specific themes

    //create a page and add it to the menu

    //creeate a blog post

    //setup online payments
    $stripe = get_rsvpmaker_stripe_keys();
    $paypal = get_option('rsvpmaker_paypal_rest_keys');
    $payments = array();
    if($paypal['client_id'])
    $payments[] = 'PayPal production keys';
    if($paypal['sandbox_client_id'])
    $payments[] = 'PayPal sandbox keys';
    if($stripe['pk'])
    $payments[] = 'Stripe production keys';
    if($stripe['sandbox_pk'])
    $payments[] = 'Stripe sandbox keys';

    if(empty($payments)) {
        $todo['payments'] = 'Online payments not yet set up';
    }
    else {
        $done['payments'] = 'Online payments set up so far: '.implode(', ',$payments);
    }

    $dues = get_option( 'club_dues' );
    if(empty($dues))
        $todo['member_application'] = 'The web-based application lets you invite new members to enroll by filling out a web-based form, with an online payment option presented at the end of the process. Use it to move beyond paper-based/PDF-based processes';
    else
        $done['member_application'] = 'You have set up the online application. Revisit this settings page if you need to update the dues schedule or other settings';

    $label['wizard'] = 'Setup Wizard';
    $link['wizard'] = admin_url('admin.php?page=wp4t_setup_wizard');
    $help['wizard'] = 'https://www.wp4toastmasters.com/knowledge-base/setup-wizard/';

    $label['homepage'] = 'Edit Home Page';
    $link['homepage'] = admin_url('post.php?action=edit&post='.$home);
    $help['homepage'] = 'https://www.wp4toastmasters.com/knowledge-base/how-to-add-wordpress-blocks-content-types/';

    $label['agenda_customized'] = 'Edit Agenda';
    $link['agenda_customized'] = admin_url('post.php?action=edit&post='.$template);
    $help['agenda_customized'] = 'https://www.wp4toastmasters.com/knowledge-base/toastmasters-meeting-templates-and-meeting-events/';

    $next = next_toastmaster_meeting();
    $label['agenda_use'] = 'Sign up for roles or assign them to other members.';
    $link['agenda_use'] = get_permalink($next->ID);
    $help['agenda_use'] = 'https://www.wp4toastmasters.com/knowledge-base/sign-up-for-a-role/';

    $label['members'] = 'Create member accounts';
    $link['members'] = admin_url('users.php?page=add_awesome_member');
    $help['members'] = 'https://www.wp4toastmasters.com/knowledge-base/create-member-accounts/';

    $label['payments'] = 'Set up online payments';
    $link['payments'] = admin_url('options-general.php?page=rsvpmaker-admin.php&tab=payments');
    $help['payments'] = 'https://www.wp4toastmasters.com/knowledge-base/online-payments-for-dues-and-events/';

    $label['member_application'] = 'Set up the web-based member application and dues schedule';
    $link['member_application'] = admin_url('options-general.php?page=member_application_settings');
    $help['member_application'] = 'https://www.wp4toastmasters.com/knowledge-base/web-based-toastmasters-membership-application/';

    $label['confirmation'] = 'Edit RSVP confirmation message';
    $link['confirmation'] = admin_url( 'post.php?post=' . $rsvp_options['rsvp_confirm'] . '&action=edit' );
    $help['confirmation'] = 'https://rsvpmaker.com/knowledge-base/confirmation-and-reminder-messages/?seq_no=2';

    if(function_exists('toastmost_club_email_list')) {
        $label['lists'] = 'Member and officer email lists';
        $link['lists'] = admin_url( 'admin.php?page=toastmost_club_email_list' );
        $help['lists'] = 'https://www.wp4toastmasters.com/knowledge-base/member-and-officer-email-lists-toastmost/';
        $done['lists'] = 'Set up private email discussion lists. Members can send a message to all other members, and officers can send a message to all other officers. By default, only messages from an email associated with the member profile will be shared with the group. You can whitelist or block additional addresses.';
    
        $label['forwarding'] = 'Email forwarding addresses';
        $link['forwarding'] = admin_url( 'admin.php?page=toastmost_forwarders' );
        $help['forwarding'] = 'https://www.wp4toastmasters.com/knowledge-base/email-forwarders/';
        $done['forwarding'] = 'Configure email forwarders, in addition to those provided by default for officer roles.';
        
        $label['findaclub'] = 'Handle Find-a-Club and other notifications from toastmasters.org';
        $link['findaclub'] = admin_url( 'admin.php?page=findaclub' );
        $help['findaclub'] = 'https://www.wp4toastmasters.com/knowledge-base/notification-tools-for-find-a-club-basecamp-and-other-toastmasters-org-notifications/';
        $done['findaclub'] = 'You can choose to set up an auto-response message for prospective member inquiries relayed through the Find-a-Club search on toastmasters.org. Forward Basecamp notifications and other notifications from toastmasters.org to the appropriate officers.';
    }
    //else mailing list setup for stanalone?

    $label['change_theme'] = 'Change the WordPress theme';
    $link['change_theme'] = admin_url('themes.php');
    $help['change_theme'] = 'https://www.wp4toastmasters.com/2020/11/09/video-change-the-look-of-your-club-website/';

    $label['change_featured_image'] = 'Change the featured image on the home page';
    $link['change_featured_image'] = admin_url('post.php?action=edit&post='.$home);
    $help['change_featured_image'] = 'https://firstsiteguide.com/wordpress-featured-image/';

    $label['change_custom_header'] = 'Change the header image that appears at the top of each page.';
    $link['change_custom_header'] = admin_url('customize.php');
    $help['change_custom_header'] = 'https://wordpress.com/support/custom-header-image/';

    $output = '<h2>This Is The Website Administrator Todo List</h2>'."\n";

    if(empty($todo))
        $output .= '<p>[none]</p>';
    
    foreach($todo as $slug => $status) {
        $l = $label[$slug];
        $u = $link[$slug];
        $h = $help[$slug];
        $output .= sprintf('<h3><a href="%s">%s</a> - <a href="%s" target="_blank">Help</a></h3>'."\n".'<p>%s</p>',$u,$l,$h,$status)."\n";
    }
    if(!empty($done)) {
    $output .= '<h2>The Items Below Are Optional Or Already Started</h2>'."\n";
        foreach($done as $slug => $status) {
            $l = $label[$slug];
            $u = $link[$slug];
            $h = $help[$slug];
            $output .= sprintf('<h3><a href="%s">%s</a> - <a href="%s" target="_blank">Help</a></h3>'."\n".'<p>%s</p>',$u,$l,$h,$status)."\n";
        }    
    }
    $output .= '<h2>Need More Help?</h2><p>See the <a href="https://www.wp4toastmasters.com/knowledge-base/">WordPress for Toastmasters knowledge base</a>. 
    Or write to <a href="mailto:david@wp4toastmasters.com?subject=Todo page query">david@wp4toastmasters.com</a>.</p>
    <p>There is also a <a href="https://www.facebook.com/groups/wp4toastmasters">Facebook group</a> where users of the software and the Toastmost service can compare notes and give feedback.</p>';
    $output .= '<h2>Volunteer Help</h2><p>The WordPress for Toastmasters project is looking for volunteers to help with documentation and training materials.
    If you have web programming or design skills, this is open source software for which your contributions are welcome. 
    Write to <a href="mailto:david@wp4toastmasters.com?subject=Todo page volunteer">david@wp4toastmasters.com</a>.</p>';

    if($send) {
        $mail['html'] = "<p>This email is intended to nudge you toward fleshing out your Toastmost website and taking full advantage of it. You can find the same list on the administrative dashboard under TM Administration.</p>\n".$output;
        $mail['subject'] = 'Toastmost.org todo list for '.get_bloginfo('name');
        $mail['from'] = 'david@wp4toastmasters.com';
        $mail['fromname'] = 'Toastmost.org';
        $blogusers = get_users( array( 'role__in' => array( 'administrator', 'manager' ), 'blog_id' => $blog_id ) );
        foreach ( $blogusers as $user ) {
            $mail['to'] = $user->user_email;
            rsvpmailer($mail);
        }
        $mail['to'] = 'david@carrcommunications.com';
        rsvpmailer($mail);
    }

    if(is_multisite())
    restore_current_blog();
    return $output;
}