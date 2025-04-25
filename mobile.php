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
function wp4t_enable_mobile() {
$current_user = wp_get_current_user();
$code = get_user_meta($current_user->ID,'wpt_mobile_code',true);
if(empty($code)) {
    $code = $current_user->ID.'-'.wp_generate_password(8,false);
    update_user_meta($current_user->ID,'wpt_mobile_code',$code);
}
if(is_admin()) {
?>
<h1><?php _e("Download and enable the Toastmost mobile app",'rsvpmaker-for_toastmasters'); ?></h2>
<?php
}
?>
<p><?php _e('Use the camera on your phone to scan the QR code shown below to authorize the app. If you have not yet installed it, the QR codes linked to the app stores are also included.','rsvpmaker-for-toastmasters'); ?></p>
<iframe style="border: none;" src="https://toastmost.org/qr/?domain=<?php echo $_SERVER['SERVER_NAME']; ?>&code=<?php echo $code; ?>&type=android" width="100%" height="1200">  </iframe>
<?php
    printf('<p>Domain/code string:</p><code>%s|%s</code>',$_SERVER['SERVER_NAME'],$code);
    if(current_user_can('manage_options')) {
        $url = rest_url('rsvptm/v1/mobile/'.$code);
        printf('<p>Test <a href="%s">%s</a></p>',$url,$url);
    }
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