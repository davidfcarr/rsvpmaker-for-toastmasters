<?php

function wp4t_navigation_submenu( $attributes ) {
global $rsvp_options;

$logo = empty($attributes['hidelogo']) ? '<li class=" wp-block-navigation-item"><a href="'.site_url().'"><img src="https://toastmost.org/tmbranding/toastmasters-50.png" width="50" height="41"></a></li>' : '';

$count = (!empty($attributes['count'])) ? intval($attributes['count']) : 5;
$dashboard_label = (is_user_logged_in()) ? __('Dashboard','rsvpmaker-for-toastmasters') : __('Member Login','rsvpmaker-for-toastmasters'); 
$html = '<nav class="wp-container-620833bf95386 items-justified-right wp-block-navigation">
<ul class="wp-block-navigation__container" style="padding-top: 5px; margin-bottom: -55px;">'.$logo.'
<li class=" wp-block-navigation-item has-child open-on-hover-click wp-block-navigation-submenu">

<a class="wp-block-navigation-item__content" href="'.admin_url().'">'.$dashboard_label.'</a>

<button aria-label="Dashboard submenu" class="wp-block-navigation__submenu-icon wp-block-navigation-submenu__toggle" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none" role="img" aria-hidden="true" focusable="false"><path d="M1.50002 4L6.00002 8L10.5 4" stroke-width="1.5"></path></svg></button>

<ul class="wp-block-navigation__submenu-container">

<li class="wp-block-navigation-item wp-block-navigation-link"><a class="wp-block-navigation-item__content"  href="'.admin_url('profile.php').'"><span class="wp-block-navigation-item__label">Profile</span></a></li>
<li class="wp-block-navigation-item wp-block-navigation-link"><a class="wp-block-navigation-item__content"  href="'.admin_url('profile.php#profilephoto').'"><span class="wp-block-navigation-item__label">Profile Photo</span></a></li>
<li class="wp-block-navigation-item wp-block-navigation-link"><a class="wp-block-navigation-item__content"  href="'.admin_url('profile.php#password').'"><span class="wp-block-navigation-item__label">New Password</span></a></li>';

$label = __('Sign Up','rsvpmaker-for-toastmasters');
$meetings = future_toastmaster_meetings($count);
if($meetings)
	foreach($meetings as $meeting) {
		$permalink = (is_user_logged_in()) ? get_permalink($meeting->ID) : wp_login_url(get_permalink($meeting->ID));
		$html .= sprintf('<li class="wp-block-navigation-item wp-block-navigation-link meeting-link"><a class="wp-block-navigation-item__content"  href="%s"><span class="wp-block-navigation-item__label">%s</span></a></li>',$permalink,esc_html($label.' '.rsvpmaker_date($rsvp_options['short_date'],intval($meeting->ts_start))));
	}

$html .= "\n".'</ul></li></ul></nav>';
return $html;
}

//invoked if navigation not found in the header
function wp4t_sidebar_template_part($menu_id) {
	global $wpdb, $current_user;

	$post_type = 'wp_template_part';
	$template_part = get_block_template( get_stylesheet() . '//sidebar', $post_type );
    if ( ! $template_part || empty( $template_part->content ) ) {
		//rsvpmaker_debug_log('template part not found');
        return;
    }
	if(!empty($template_part->wp_id)) {
		return;
	}
	$content = $template_part->content;
	preg_match('/<!-- wp:navigation (\{){0,1}/',$content,$match);
	
	if(empty($match[0]))
		return;
	elseif(empty($match[1]))
		$content = str_replace('wp:navigation', 'wp:navigation {"ref":'.$menu_id.'}',$content);
	else
		$content = str_replace('wp:navigation {', 'wp:navigation {"ref":'.$menu_id.',',$content);

	$part['post_type'] = $post_type;
	$part['post_title'] = 'Sidebar';
	$part['post_content'] = $content;
	$part['post_status'] = 'publish';
	$part['post_author'] = $current_user->ID;
	$part_id = wp_insert_post($part);
	wp_add_object_terms($part_id,$template_part->theme,'wp_theme');
}

function wp4t_block_theme_menu() {
	global $wpdb, $current_user;
	$menu_id = $wpdb->get_var("SELECT ID from $wpdb->posts WHERE post_type='wp_navigation' and post_status='publish' AND post_title='Toastmasters Navigation' ORDER BY ID DESC");
	if(!$menu_id)
	{
	$link_format = '<!-- wp:navigation-link {"label":"%s","type":"page","id":%d,"url":"%s","kind":"post-type","isTopLevelLink":true} /-->'."\n\n";
	$sql = "SELECT ID FROM $wpdb->posts WHERE post_status='publish' and post_name='calendar' ";
	$calendar_id = $wpdb->get_var($sql);
	$sql = "SELECT ID FROM $wpdb->posts WHERE post_status='publish' and post_name='members' ";
	$members_id = $wpdb->get_var($sql);
	$blog_id = get_option('page_for_posts');
	$home_id = get_option('page_on_front');
	if($home_id) {
		$menu['post_content'] = sprintf($link_format,__('Home','rsvpmaker-for-toastmasters'),$home_id,site_url());
		if($blog_id)
			$menu['post_content'] .= sprintf($link_format,__('Blog','rsvpmaker-for-toastmasters'),$blog_id,get_permalink($blog_id));
	}
	else
		$menu['post_content'] = sprintf('<!-- wp:navigation-link {"label":"'.__('Home','rsvpmaker-for-toastmasters').'","type":"custom",url":"%s","kind":"post-type","isTopLevelLink":true} /-->'."\n\n",site_url());
	if($calendar_id)
		$menu['post_content'] .= sprintf($link_format,__('Calendar','rsvpmaker-for-toastmasters'),$calendar_id,get_permalink($calendar_id));
	else {
		$post = array(
			'post_content' => '<!-- wp:rsvpmaker/upcoming {"calendar":"1","hideauthor":"true"} /-->',
			'post_name'    => 'calendar',
			'post_title'   => 'Calendar',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_author'  => $current_user->ID,
			'ping_status'  => 'closed',
		);
		$calendar_id = wp_insert_post( $post );
		$menu['post_content'] .= sprintf($link_format,__('Calendar','rsvpmaker-for-toastmasters'),$calendar_id,get_permalink($calendar_id));

	}
	if($members_id)
		$menu['post_content'] .= sprintf($link_format,__('Members','rsvpmaker-for-toastmasters'),$members_id,get_permalink($members_id));
	else {
		$post = array(
			'post_content' => '<!-- wp:shortcode -->
			[awesome_members comment="This placeholder code displays the member listing"]
			<!-- /wp:shortcode -->',
			'post_name'    => 'members',
			'post_title'   => 'Members',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_author'  => $current_user->ID,
			'ping_status'  => 'closed',
		);
		$members_id = wp_insert_post( $post );
		$menu['post_content'] .= sprintf($link_format,__('Members','rsvpmaker-for-toastmasters'),$members_id,get_permalink($members_id));
	}
	$menu['post_title'] = 'Toastmasters Navigation';
	$menu['post_status'] = 'publish';
	$menu['post_type'] = 'wp_navigation';
	$menu['post_author'] = $current_user->ID;
	$menu_id = wp_insert_post($menu);
	}
return $menu_id;
}

function wpt_add_menu_to_nav($content, $menu_id) {
preg_match('/<!-- wp:navigation (\{){0,1}/',$content,$match);

if(empty($match[0]))
	;
elseif(empty($match[1]))
	$content = str_replace('wp:navigation', 'wp:navigation {"ref":'.$menu_id.'}',$content);
else
	$content = str_replace('wp:navigation {', 'wp:navigation {"ref":'.$menu_id.',',$content);
return $content;
}

function wp4t_header_template_part() {
	global $wpdb, $current_user;
	$post_type = 'wp_template_part';
	$template_part = get_block_template( get_stylesheet() . '//header', $post_type );
    if ( ! $template_part || empty( $template_part->content ) ) {
        return;
    }
	if(!empty($template_part->wp_id)) {
		return;
	}
	$menu_id = wp4t_block_theme_menu();
	$content = $template_part->content;
	if(!strpos($content,'wp:navigation'))
		return; //might be using a pattern in header.html

	$content = wpt_add_menu_to_nav($content, $menu_id);

	$header['post_type'] = $post_type;
	$header['post_title'] = 'Header';
	$header['post_content'] = $content;
	$header['post_status'] = 'publish';
	$header['post_author'] = $current_user->ID;
	$header_id = wp_insert_post($header);
	wp_add_object_terms($header_id,$template_part->theme,'wp_theme');
	return $header_id;
}

add_action('after_setup_theme','wp4t_header_template_part');