<?php
add_action('init','wp4t_init_actions');
function wp4t_init_actions() {
	wp4t_role_array();
	rsvptoast_load_plugin_textdomain();
	//wp4t_fix_cache_users_bug();
	create_block_toastmasters_dynamic_agenda_block_init();
	//wpt_server_block_render();
	if(!wpt_exclude_agenda_functions()) {
	//excluded on specified sites
	//wp4toastmasters_agenda_layout_block_init();
	//create_block_memberoptions_block_init();
	//create_block_speaker_evaluator_block_init();
	add_action( 'toastmasters_agenda_notification', 'bp_toastmasters', 10, 3 );
	add_action( 'toastmasters_agenda_notification', 'wp4t_intro_notification', 10, 5 );
	add_action('wp4toast_reminders_intros','wp4toast_reminders_intros',10,2);
	add_action('init','wp4t_reminders_test');
	add_action( 'wp_ajax_wptoast_role_planner_update', 'wp_ajax_wptoast_role_planner_update' );
	add_action( 'wp4t_reminders_nudge', 'wp4t_reminders_nudge' );
	add_action( 'wp4t_refresh_tm_history', 'wp4t_refresh_tm_history' );
	add_action('admin_init','wpt_minutes_from_history_draft');
	add_filter('default_title','wpt_minutes_from_history_title');
	add_filter('default_content','wpt_minutes_from_history');
	add_action('wp4t_add_history_to_table','wp4t_add_history_to_table_log',10, 12);
	add_action('wpt_update_speech_history_by_id','wpt_update_speech_history_by_id_log',10,6);
	add_action('wpt_remove_history_by_id','wpt_remove_history_by_id_log',10,3);
	add_action('wpt_update_history_by_id','wpt_update_history_by_id_log',10,4);

	//end excluded actions
	}
    wp4t_minutes_post_type();
	if ( isset( $_GET['toast_scoring_update'] ) ) {
		toast_scoring_update();
	}

    if(isset($_GET['toastmost_app_redirect'])) {
    	wp4t_toastmost_app_redirect();
    }
    if ( isset( $_REQUEST['signup'] ) || isset( $_REQUEST['signup2'] ) || isset( $atts['limit'] ) ) {
        wp4t_signup_sheet();
    }
	//wp4t_data_model_update();
	if ( isset( $_GET['tm_reminders_preview'] ) ) {
		toastmasters_reminder_preview();
	}
	if ( isset( $_REQUEST['wp4t_tm_export'] ) ) {
		wp4t_tm_export();
	}
	if ( isset( $_REQUEST['wp4t_show_evaluation'] ) && is_user_logged_in() ) {
		wp4t_show_evaluation();
	}
}

add_action( 'widgets_init', 'wptoast_widgets' );
add_action( 'wp_enqueue_scripts', 'toastmasters_css_js' );
add_action( 'admin_enqueue_scripts', 'toastmasters_css_js' );
add_action( 'pre_get_posts', 'toast_modify_query_exclude_category' );
add_action( 'admin_menu', 'wp4t_tm_security_setup', 1 );
add_action( 'admin_bar_menu', 'wp4t_toolbar_add_member', 999 );
add_action( 'admin_bar_menu', 'wp4t_toolbar_link_to_agenda', 999 );
add_action( 'admin_init', 'wp4t_check_first_login' );
if($_SERVER['SERVER_SOFTWARE'] != 'PHP.wasm') //disable within WordPress Playground
	add_action( 'admin_init', 'wp4t_archive_users_init' );
add_action( 'admin_menu', 'wp4t_awesome_menu' );
add_action( 'admin_init', 'wp4t_awesome_role_activation_wrapper' );
add_action( 'admin_init', 'register_wp4toastmasters_settings' );
add_action( 'admin_init', 'wp4t_new_agenda_template' );
add_action( 'admin_notices', 'rsvptoast_admin_notice' );
add_action( 'wp_dashboard_setup', 'wp4t_awesome_add_dashboard_widgets', 99 );
add_action( 'admin_init', 'wp4t_awesome_roles' );
add_action( 'wp', 'wp4t_accept_recommended_role' );
add_action( 'show_user_profile', 'wp4t_awesome_user_profile_fields' );
add_action( 'edit_user_profile', 'wp4t_awesome_user_profile_fields' );
add_action( 'personal_options_update', 'wp4t_save_awesome_user_profile_fields' );
add_action( 'edit_user_profile_update', 'wp4t_save_awesome_user_profile_fields' );
add_action( 'user_new_form', 'wp4t_member_not_user' );
add_action( 'rsvpmaker_datebox_message', 'toastmasters_datebox_message' );
add_action( 'bp_profile_header_meta', 'display_toastmasters_profile' );
//add_action( 'admin_head', 'wp4t_profile_richtext' );
add_action( 'admin_init', 'wp4t_cron_nudge_setup' );
