<?php
add_shortcode('toastmost_mobile_qr_shortcode','toastmost_mobile_qr_shortcode');
function toastmost_mobile_qr_shortcode($atts) {
    global $current_user;
    if(!is_user_logged_in()) {
        return '<p>'.__('You must be logged in to view the QR code.','rsvpmaker-for-toastmasters').'</p>';
    }
    if(!is_user_member_of_blog($current_user->ID)) {
        return '<p>'.__('You do not have permission to view this page.','rsvpmaker-for-toastmasters').'</p>';
    }
    ob_start();
    echo '<div>';
    wp4t_enable_mobile();
    echo '</div>';
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
function wpt_get_mobile_code($user_id) {
    $code = get_user_meta($user_id,'wpt_mobile_code',true);
    if(empty($code)) {
        $code = $user_id.'-'.wp_generate_password(8,false);
        update_user_meta($user_id,'wpt_mobile_code',$code);
    }
    return $code;
}
function wp4t_enable_mobile() {
$user = (isset($_GET['user_id']) && current_user_can('manage_options')) ? get_userdata(intval($_GET['user_id'])) : wp_get_current_user();
$code = wpt_get_mobile_code($user->ID);
if(is_admin()) {
?>
<h1><?php _e("Download and enable the Toastmost mobile app",'rsvpmaker-for_toastmasters'); ?></h1>
<?php
}
?>
<p><?php _e('If you have not yet installed the app, click to display the QR codes to download it from the <a href="#iosdownload">iOS App Store</a> or <a href="#androiddownload">Android Play Store</a>.','rsvpmaker-for-toastmasters'); ?></p>
<p><?php _e('Once you have installed the app, use the camera on your iOS or Android device to scan the QR code shown below. This will authorize the app to access this website.','rsvpmaker-for-toastmasters'); ?></p>
<!--iframe style="border: none;" src="https://toastmost.org/qr/?domain=<?php echo $_SERVER['SERVER_NAME']; ?>&code=<?php echo $code; ?>&type=android" width="100%" height="600">  </iframe -->
<?php
$deeplink = 'toastmost:///Settings/?domain='.sanitize_text_field($_SERVER['SERVER_NAME']).'&code='.$code;
echo '<h3>Authorize the app for '.esc_html($user->display_name).'</h3>'.rsvpmaker_qr(['url' => $deeplink]);
printf('<p><a href="%s">%s</a></p>',$deeplink,$deeplink);
    printf('<p>Domain/code string:</p><code>%s|%s</code>',$_SERVER['SERVER_NAME'],$code);
    if(current_user_can('manage_options')) {
        $url = rest_url('rsvptm/v1/mobile/'.$code);
        printf('<p>Test <a href="%s">%s</a></p>',$url,$url);
        $members = get_users( 'blog_id=' . get_current_blog_id() );
        foreach($members as $member) {
            printf('<p><a href="%s">Show code for %s</a></p>',admin_url('admin.php?page=wp4t_enable_mobile&user_id='.$member->ID),$member->display_name);
        }
    }
$store = 'https://apps.apple.com/us/app/toastmost/id6741133200';
echo '<h3 id="iosdownload" style="margin-top: 500px;">iOS App Store</h3>'.rsvpmaker_qr(['url' => $store]);
printf('<p><a href="%s">%s</a></p>',$store,$store);
$store = 'https://play.google.com/store/apps/details?id=com.toastmost.mobileagenda';
echo '<h3 id="androiddownload" style="margin-top: 500px;">Android Play Store</h3>'.rsvpmaker_qr(['url' => $store]);
printf('<p><a href="%s">%s</a></p>',$store,$store);

}
add_shortcode('toastmost_qr_deeplink','toastmost_qr_deeplink');
function toastmost_qr_deeplink() {
 return 'toastmost:///Settings/?domain='.sanitize_text_field($_GET['domain']).'&code='.sanitize_text_field($_GET['code']);
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