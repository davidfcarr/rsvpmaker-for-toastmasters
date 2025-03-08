<?php

function wp4t_enable_mobile() {

    global $current_user;
    if(isset($_POST['status'])) {

        if(empty($_POST['status'])) {

            $enabled = false;

            delete_user_meta($current_user->ID,'wpt_mobile_code');

        } 

        else {

            $enabled = true;

            $code = sanitize_text_field($_POST['status']);

            update_user_meta($current_user->ID,'wpt_mobile_code',$code);

        }

    } else {

        $code = get_user_meta($current_user->ID,'wpt_mobile_code',true);

        if($code)

            $enabled = true;

        else

            $enabled = false; 

    }

if(!$enabled)

    $code = $current_user->ID.'-'.wp_generate_password(8,false);

$enabled_checked = ($enabled) ? ' checked="checked" ' : '';

$disabled_checked = ($enabled) ? '' : ' checked="checked" ';

if(isset($_POST['volunteer'])) {
    $volunteer = [];
    foreach($_POST['volunteer'] as $index => $value) {
        $volunteer[$index] = sanitize_text_field($value);
    }
    update_user_meta($current_user->ID,'wpt_mobile_volunteer',$volunteer);
    $mail['from'] = $current_user->user_email;
    $mail['fromname'] = $current_user->display_name;
    $mail['to'] = 'david@carrcommunications.com';
    $mail['html'] = '<p>'.implode('<br>',$volunteer).'</p>';
    $mail['subject'] = 'App testing volunteer: '.$volunteer['type'];
    rsvpmailer($mail);
    if($volunteer['type'] == 'Android' || $volunteer['type'] == 'both') {
        $mail['from'] = 'david@toastmost.org';
        $mail['fromname'] = 'David @ Toastmost';
        $mail['to'] = $current_user->user_email;
        $mail['subject'] = 'Toastmost Mobile App Android Download '.date('r');
        $app_redirect_url = site_url('?toastmost_app_redirect=Settings&domain='.$_SERVER['SERVER_NAME'].'&code='.$code);
        $rest_url = rest_url('rsvptm/v1/mobile/'.$code);
        $code_url = 'https://toastmost.org/app-setup/?domain='.$_SERVER['SERVER_NAME'].'&code='.$code.'&type=android';
        $mail['html'] = sprintf('<p>Open this email on your phone and follow this <a href="%s">magic link</a>, which should automatically open the Toastmost app and allow the app to use the website\'s agenda on your behalf. If the magic does not work for some reason, follow the link below instructions to download and configure the Android app <a href="%s">%s</a><p>',$code_url,$code_url);
        rsvpmailer($mail);
    }
}
else {
    $volunteer = get_user_meta($current_user->ID,'wpt_mobile_volunteer',true);
    if(!is_array($volunteer))
        $volunteer = [];
}

if(isset($_POST['resend']) && isset($volunteer['type']) && ($volunteer['type'] == 'Android' || $volunteer['type'] == 'both')) {
        $mail['from'] = 'david@toastmost.org';
        $mail['fromname'] = 'David @ Toastmost';
        $mail['to'] = $current_user->user_email;
        $mail['subject'] = 'Toastmost Mobile App Android Download '.date('r');
        $code_url = 'https://toastmost.org/app-setup/?domain='.$_SERVER['SERVER_NAME'].'&code='.$code.'&type=android';
        $mail['html'] = sprintf('<p>Open this email on your phone and follow the link below for instructions to download and configure the Android app <a href="%s">%s</a><p>',$code_url,$code_url);
        rsvpmailer($mail);
        echo '<p>Resending link</p>';
}
?>

<h1>Enable Mobile App (beta)</h2>

<?php

if($enabled) {
    printf('<p>Enter the domain %s and this code into the mobile app to enable role signups.</p><code>%s</code>',$_SERVER['SERVER_NAME'],$code);
    if(current_user_can('manage_options')) {
        $url = rest_url('rsvptm/v1/mobile/'.$code);
        printf('<p>Test <a href="%s">%s</a></p>',$url,$url);
    }
}
if(empty($volunteer) || isset($_GET['reset'])){ 
    ?>
    <p>The Toastmost mobile app makes it more convenient for club members to sign up for roles from their phones. It also includes a speech timer, and additional features will be added as we learn what members would value in a mobile app.</p>
    <p>Before the Toastmost app goes live on the Apple App Store and Google Play Store, we will need a few dozen people to test each version and provide feedback. The Android version is ready for testing now. The iPhone version is running in a simulator, but I need to raise sponsor funds to cover costs related to Apple's app review process.</p>
    <form method="post" action="">    
    <p>I can test the app on <input type="radio" name="volunteer[type]" value="Android" checked="checked"> Android <input type="radio" name="volunteer[type]" value="iOS" > iOS (iPhone) <input type="radio" name="volunteer[type]" value="both"> Both Android and iOS</p>
    <p>Message:<br><textarea name="volunteer[message]" placeholder="Message to the developer" rows="3" cols="100"></textarea></p> 
    <input type="hidden" name="status" value="<?php echo $code ?>" />
    <p><button>Volunteer</button></p>    
    </form>    
    <?php 
}
else {
    echo '<h2>Thank you for volunteering</h2><p>You will receive follow up details by email.</p>';
    echo '<p>Message: '.$volunteer['message'].'</p>';
    echo '<p>Device type: '.$volunteer['type'].'</p>';
    if(isset($volunteer['type']) && ($volunteer['type'] == 'Android' || $volunteer['type'] == 'both')) {
?>        
<p>If you have an Android device, you will be emailed a download link you can open on your phone or tablet. You can also use your phone to scan the QR code shown below.</p>
<form method="post" action="">
        <p><input type="hidden" name="resend" value="1"><button>Resend Android App Download Link</button></p>
        </form>
        <iframe src="https://toastmost.org/qr/?domain=<?php echo $_SERVER['SERVER_NAME']; ?>&code=<?php echo $code; ?>&type=android" width="100%" height="300">  </iframe>
<?php        
    }
}
?>

<h2>Help as a Sponsor?</h2>
<p>Your contribution of $20 or more will help cover expenses such as registration for the Apple developer program (required for testing and publishing iPhone apps). <a href="https://biz.toastmost.org/sponsor-the-app/">Learn more</a>.</p>

<h2>Enable / Disable the App for Your Account</h2>
<form method="post" action="">

<input type="radio" name="status" value="<?php echo $code ?>" <?php echo $enabled_checked ?> > Enabled <input type="radio" name="status" value="" <?php echo $disabled_checked ?> > Disabled 

<button>Update</button>

</form>

<h2>Video Demo: Android Setup</h2>
<iframe width="560" height="315" src="https://www.youtube.com/embed/4ssGi3PpqWM?si=KZSUAunGohBFSF1V" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

<?php
    
}

add_shortcode('toastmost_qr_code','toastmost_qr_code');
function toastmost_qr_code() {
 return 'https://toastmost.org/app-setup/?domain='.sanitize_text_field($_GET['domain']).'&code='.sanitize_text_field($_GET['code']).'&type='.sanitize_text_field($_GET['type']);
}

if(isset($_GET['domain']) && isset($_GET['code']) && isset($_GET['type'])) {
    add_filter( 'show_admin_bar', '__return_false' );
}

function wpt_domains_of_mobile_user($user_id) {
    $domains = [];
    if(!is_multisite())
        return $domains;
    $blogs = get_blogs_of_user($user_id);
    foreach($blogs as $blog) {
        $domains[] = $blog->domain;
    }
    return $domains;
}

function wpt_mobile_user_check() {

    global $wpdb;

    if(isset($_GET['mobilekey'])) {

        $key = sanitize_text_field($_GET['mobilekey']);

        $sql = "SELECT user_id FROM $wpdb->usermeta WHERE meta_key='wpt_mobile_code' AND meta_value='$key' ";

        $user_id = $wpdb->get_var($sql);

        if($user_id) {

            wp_set_current_user($user_id);

            return true;

        }        

    }

    return false;

}

function wp4t_toastmost_app_redirect () {
    if(isset($_GET['toastmost_app_redirect'])) {
        $url = 'toastmost:///';
        if(!empty($_GET['toastmost_app_redirect']))
            $url .= sanitize_text_field($_GET['toastmost_app_redirect']); //path
        if(isset($_GET['domain']))
            $url .= '?domain='.sanitize_text_field($_GET['domain']);
        if(isset($_GET['code']))
            $url .= '&code='.sanitize_text_field($_GET['code']);
        header('Location: '.$url);
        exit;    
    }
}