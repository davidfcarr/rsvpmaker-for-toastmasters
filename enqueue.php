<?php

function tm_welcome_screen_assets( $hook ) {
//everywhere except posts screen
$ver = '2.4';
  if(!strpos($_SERVER['REQUEST_URI'],'post.php')) //if( ( strpos($hook,'toastmasters') !== false ) || strpos($_SERVER['REQUEST_URI'],'index.php')) 
   {
    wp_enqueue_style( 'tm_welcome_screen_css', plugin_dir_url( __FILE__ ) . '/admin-style.css',array(), $ver );
    wp_enqueue_script( 'tm_welcome_screen_js', plugin_dir_url( __FILE__ ) . '/admin-script.js', array( 'jquery' ), $ver, true );
  }
}

function toastmasters_css_js() {
	global $post;
	$version = '3.36';
	if(isset($_GET['action']) || (is_admin() && !isset($_GET['page'])) )
		return; // don't load all this in editor or post listings
    if( (isset($post->post_content) && is_wp4t() ) || (isset($_REQUEST["page"]) && 
    (($_REQUEST["page"] == 'toastmasters_reconcile') || ($_REQUEST["page"] == 'my_progress_report') 
    || ($_REQUEST["page"] == 'wp4t_evaluations') || ($_REQUEST["page"] == 'toastmasters_reports') 
    || ($_REQUEST["page"] == 'toastmasters_planner') )  ) )
	{
	wp_enqueue_style( 'jquery' );
	wp_enqueue_style( 'jquery-ui-core' );
	wp_enqueue_style( 'jquery-ui-sortable' );
	wp_register_script('script-toastmasters', plugins_url('rsvpmaker-for-toastmasters/toastmasters.js'), array('jquery','jquery-ui-core','jquery-ui-sortable'), $version);
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
	wp_localize_script('script-toastmasters', 'wpt_rest', array('nonce' => wp_create_nonce( 'wp_rest' ), 'url' => get_rest_url() ) );
	wp_enqueue_style( 'style-toastmasters', plugins_url('rsvpmaker-for-toastmasters/toastmasters.css'), array(), $version );
	}
}

?>