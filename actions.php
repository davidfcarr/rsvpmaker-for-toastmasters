<?php
add_action('init','wp4t_init_actions');
function wp4t_init_actions() {
	wp4t_role_array();
	wp4t_server_block_render();
	rsvptoast_load_plugin_textdomain();
	fix_cache_users_bug();
	create_block_toastmasters_dynamic_agenda_block_init();
	wp4toastmasters_agenda_layout_block_init();
	wpt_server_block_render();
	create_block_memberoptions_block_init();
	create_block_speaker_evaluator_block_init();
    minutes_post_type();
    if ( isset( $_GET['toast_scoring_update'] ) ) {
	    toast_scoring_update();
    }
    if(isset($_GET['toastmost_app_redirect'])) {
    	wp4t_toastmost_app_redirect();
    }
    if ( isset( $_REQUEST['signup'] ) || isset( $_REQUEST['signup2'] ) || isset( $atts['limit'] ) ) {
        signup_sheet();
    }
	//wp4t_data_model_update();
	if ( isset( $_GET['tm_reminders_preview'] ) ) {
		toastmasters_reminder_preview();
	}
	if ( isset( $_REQUEST['tm_export'] ) ) {
		tm_export();
	}
	if ( isset( $_REQUEST['show_evaluation'] ) && is_user_logged_in() ) {
		show_evaluation();
	}
}

add_action( 'widgets_init', 'wptoast_widgets' );
add_action( 'wp_enqueue_scripts', 'toastmasters_css_js' );
add_action( 'pre_get_posts', 'toast_modify_query_exclude_category' );
add_action( 'admin_menu', 'tm_security_setup', 1 );
add_action( 'admin_bar_menu', 'toolbar_add_member', 999 );
add_action( 'admin_bar_menu', 'toolbar_link_to_agenda', 999 );
add_action( 'admin_init', 'check_first_login' );
add_action( 'admin_init', 'archive_users_init' );
add_action( 'admin_menu', 'awesome_menu' );
add_action( 'admin_init', 'awesome_role_activation_wrapper' );
add_action( 'admin_init', 'register_wp4toastmasters_settings' );
add_action( 'admin_init', 'new_agenda_template' );
add_action( 'admin_notices', 'rsvptoast_admin_notice' );
add_action( 'wp_dashboard_setup', 'awesome_add_dashboard_widgets', 99 );
add_action( 'admin_init', 'awesome_roles' );
add_action( 'wp', 'accept_recommended_role' );
add_action( 'show_user_profile', 'awesome_user_profile_fields' );
add_action( 'edit_user_profile', 'awesome_user_profile_fields' );
add_action( 'personal_options_update', 'save_awesome_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_awesome_user_profile_fields' );
add_action( 'user_new_form', 'member_not_user' );
add_action( 'rsvpmaker_datebox_message', 'toastmasters_datebox_message' );
add_action( 'toastmasters_agenda_notification', 'bp_toastmasters', 10, 3 );
add_action( 'toastmasters_agenda_notification', 'wp4t_intro_notification', 10, 5 );
add_action( 'bp_profile_header_meta', 'display_toastmasters_profile' );
add_action( 'admin_head', 'profile_richtext' );
add_action( 'admin_init', 'wp4t_cron_nudge_setup' );
