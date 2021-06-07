<?php

add_action( 'rsvpmail_unsubscribe', 'wpt_mailster_unsubscribe', 1 );

function wpt_mailster_unsubscribe( $email ) {
	if ( ! function_exists( 'mailster_install' ) ) {
		return;
	}
	global $wpdb;
	$user = get_user_by( 'email', $email );
	if ( $user ) {
		$sql    = 'DELETE FROM ' . $wpdb->prefix . 'mailster_list_members WHERE is_core_user=1 AND user_id=' . $user->ID;
		$result = $wpdb->query( $sql );
		if ( $result ) {
			echo '<div style="text-align: center;" class="notice">Unsubscribe for ' . $email . '</div>';
		}
	}
}

add_action( 'admin_init', 'wpt_mailster_update' );
function wpt_mailster_update() {
	if ( ! function_exists( 'mailster_install' ) ) {
		return;
	}
	global $wpdb;
	$overwrite = true;
	// add your custom coding here.
	// create members list if it doesn't exist

	$unsub = get_option( 'rsvpmail_unsubscribed' );
	if ( empty( $unsub ) ) {
		$unsub = array();
	}

	$pop3 = get_option( 'wpt_mailster_pop_id' );
	$smtp = get_option( 'wpt_mailster_smtp_id' );
	if ( ! $pop3 || ! $smtp ) {
		if ( function_exists( 'wpt_mailster_popdefaults' ) ) {
			$success = $wpdb->insert( $wpdb->prefix . 'mailster_servers', wpt_mailster_popdefaults() );
			if ( $success ) {
				$pop3 = $wpdb->insert_id;
				update_option( 'wpt_mailster_pop_id', $wpdb->insert_id );
			}
		}
		if ( function_exists( 'wpt_mailster_imapdefaults' ) ) {
			$success = $wpdb->insert( $wpdb->prefix . 'mailster_servers', wpt_mailster_imapdefaults() );
			if ( $success ) {
				$smtp = $wpdb->insert_id;
				update_option( 'wpt_mailster_smtp_id', $wpdb->insert_id );
			}
		}
	}
	$whitelist = get_option( 'wpt_mailster_whitelist' );
	if ( ! $whitelist ) {
		$success = $wpdb->insert(
			$wpdb->prefix . 'mailster_groups',
			array(
				'name'          => 'whitelist',
				'is_core_group' => 0,
				'core_group_id' => 0,
			)
		);
		if ( $success ) {
			update_option( 'wpt_mailster_whitelist', $wpdb->insert_id );
		}
	}
	if ( isset( $_GET['wpt_mailster_reset'] ) ) {
		echo '<div class="notice">Resetting</div>';
		update_option( 'wpt_mailster_memberlist', 0 );
		update_option( 'wpt_mailster_officerslist', 0 );
	}
	$urlparts = preg_split( '/[\/{2}\.]/', get_site_url() );
	array_shift( $urlparts );
	array_shift( $urlparts ); // get rid of protocol
	if ( $urlparts[0] == 'www' ) {
		array_shift( $urlparts );
	}
	$emailstart         = ( sizeof( $urlparts ) > 2 ) ? array_shift( $urlparts ) : 'members';
	$list_email         = $emailstart . '@' . implode( '.', $urlparts );
	$emailstart         = ( $emailstart == 'members' ) ? 'officers' : $emailstart . '-officers';
	$officer_list_email = $emailstart . '@' . implode( '.', $urlparts );
	$list_table         = $wpdb->prefix . 'mailster_lists';
	$member_list        = get_option( 'wpt_mailster_memberlist' );
	if ( ! $member_list ) {
		echo '<div class="notice">Setting Member List Defaults</div>';
		$name            = 'Members: ' . substr( get_bloginfo( 'name' ), 0, 25 );
		$password        = wp_generate_password();
		$unsubscribe_url = site_url( '?rsvpmail_unsubscribe=' );
		$memberarray     = array(
			'asset_id'                   => '0',
			'name'                       => $name,
			'admin_mail'                 => get_bloginfo( 'admin_email' ),
			'published'                  => null,
			'active'                     => '0',
			'public_registration'        => '1',
			'sending_public'             => '0',
			'sending_recipients'         => '1',
			'sending_admin'              => '1',
			'sending_group'              => '1',
			'sending_group_id'           => $whitelist,
			'mod_mode'                   => '0',
			'mod_moderated_group'        => '0',
			'mod_approve_recipients'     => '0',
			'mod_approve_group'          => '0',
			'mod_approve_group_id'       => '0',
			'mod_info_sender_moderation' => '0',
			'mod_info_sender_approval'   => '0',
			'mod_info_sender_rejection'  => '0',
			'disable_mail_footer'        => '0',
			'allow_subscribe'            => '1',
			'allow_unsubscribe'          => '1',
			'reply_to_sender'            => '2',
			'list_mail'                  => $list_email,
			'subject_prefix'             => '',
			'use_cms_mailer'             => '0',
			'copy_to_sender'             => '1',
			'mail_in_user'               => $list_email,
			'mail_in_pw'                 => $password,
			'mail_out_user'              => $list_email,
			'mail_out_pw'                => $password,
			'server_inb_id'              => $pop3,
			'server_out_id'              => $smtp,
			'custom_header_plain'        => 'Message from {name}  {email} ({date}):',
			'custom_footer_plain'        => 'From {site} 
    Unsubscribe: ' . $unsubscribe_url . '{email}',
			'custom_header_html'         => 'Message From {name} <a href="mailto:{email}">Reply to {email}</a> ({date}):<br /><br />',
			'custom_footer_html'         => sprintf( 'From {site} <a href="%s{email}">Unsubscribe</a>', $unsubscribe_url ),
			'mail_format_conv'           => '0',
			'mail_format_altbody'        => '1',
			'alibi_to_mail'              => null,
			'addressing_mode'            => '1',
			'mail_from_mode'             => '2',
			'name_from_mode'             => '2',
			'archive_mode'               => '0',
			'archive_retention'          => '0',
			'archive2article'            => '0',
			'archive2article_author'     => '0',
			'archive2article_cat'        => '0',
			'archive2article_state'      => '1',
			'archive_offline'            => '0',
			'bounce_mode'                => '0',
			'bounce_mail'                => '',
			'bcc_count'                  => '10',
			'incl_orig_headers'          => '0',
			'max_send_attempts'          => '5',
			'filter_mails'               => '0',
			'allow_bulk_precedence'      => '0',
			'clean_up_subject'           => '1',
			'cstate'                     => '1',
			'mail_size_limit'            => '0',
			'notify_not_fwd_sender'      => '1',
			'save_send_reports'          => '7',
			'subscribe_mode'             => '0',
			'unsubscribe_mode'           => '0',
			'welcome_msg'                => '1',
			'welcome_msg_admin'          => '0',
			'goodbye_msg'                => '1',
			'goodbye_msg_admin'          => '0',
			'allow_digests'              => '0',
			'front_archive_access'       => '0',
			'mail_content'               => null,
		);
		$wpdb->insert( $wpdb->prefix . 'mailster_lists', $memberarray );
		$member_list = $wpdb->insert_id;
		if ( $member_list ) {
			update_option( 'wpt_mailster_memberlist', $member_list );
		}
		// $wpdb->query("UPDATE $list_table SET active=1 WHERE id=$member_list");
	}
	$officer_list = get_option( 'wpt_mailster_officerslist' );
	if ( ! $officer_list ) {
		$name            = 'Officers: ' . substr( get_bloginfo( 'name' ), 0, 25 );
		$password        = wp_generate_password();
		$unsubscribe_url = site_url( '?rsvpmail_unsubscribe=' );
		$memberarray     = array(
			'asset_id'                   => '0',
			'name'                       => $name,
			'admin_mail'                 => get_bloginfo( 'admin_email' ),
			'published'                  => null,
			'active'                     => '0',
			'public_registration'        => '1',
			'sending_public'             => '0',
			'sending_recipients'         => '1',
			'sending_admin'              => '1',
			'sending_group'              => '1',
			'sending_group_id'           => $whitelist,
			'mod_mode'                   => '0',
			'mod_moderated_group'        => '0',
			'mod_approve_recipients'     => '0',
			'mod_approve_group'          => '0',
			'mod_approve_group_id'       => '0',
			'mod_info_sender_moderation' => '0',
			'mod_info_sender_approval'   => '0',
			'mod_info_sender_rejection'  => '0',
			'disable_mail_footer'        => '0',
			'allow_subscribe'            => '1',
			'allow_unsubscribe'          => '1',
			'reply_to_sender'            => '2',
			'list_mail'                  => $officer_list_email,
			'subject_prefix'             => '',
			'use_cms_mailer'             => '0',
			'copy_to_sender'             => '1',
			'mail_in_user'               => $officer_list_email,
			'mail_in_pw'                 => $password,
			'mail_out_user'              => $officer_list_email,
			'mail_out_pw'                => $password,
			'server_inb_id'              => $pop3,
			'server_out_id'              => $smtp,
			'custom_header_plain'        => 'Message from {name}  {email} ({date}):',
			'custom_footer_plain'        => 'From {site} 
    Unsubscribe: ' . $unsubscribe_url . '{email}',
			'custom_header_html'         => 'Message From {name} <a href="mailto:{email}">Reply to {email}</a> ({date}):<br /><br />',
			'custom_footer_html'         => sprintf( 'From {site} <a href="%s{email}">Unsubscribe</a>', $unsubscribe_url ),
			'mail_format_conv'           => '0',
			'mail_format_altbody'        => '1',
			'alibi_to_mail'              => null,
			'addressing_mode'            => '1',
			'mail_from_mode'             => '2',
			'name_from_mode'             => '2',
			'archive_mode'               => '0',
			'archive_retention'          => '0',
			'archive2article'            => '0',
			'archive2article_author'     => '0',
			'archive2article_cat'        => '0',
			'archive2article_state'      => '1',
			'archive_offline'            => '0',
			'bounce_mode'                => '0',
			'bounce_mail'                => '',
			'bcc_count'                  => '10',
			'incl_orig_headers'          => '0',
			'max_send_attempts'          => '5',
			'filter_mails'               => '0',
			'allow_bulk_precedence'      => '0',
			'clean_up_subject'           => '1',
			'cstate'                     => '1',
			'mail_size_limit'            => '0',
			'notify_not_fwd_sender'      => '1',
			'save_send_reports'          => '7',
			'subscribe_mode'             => '0',
			'unsubscribe_mode'           => '0',
			'welcome_msg'                => '1',
			'welcome_msg_admin'          => '0',
			'goodbye_msg'                => '1',
			'goodbye_msg_admin'          => '0',
			'allow_digests'              => '0',
			'front_archive_access'       => '0',
			'mail_content'               => null,
		);
		$success         = $wpdb->insert( $wpdb->prefix . 'mailster_lists', $memberarray );
		$officer_list    = $wpdb->insert_id;
		if ( $success ) {
			update_option( 'wpt_mailster_officerslist', $officer_list );
		}
		// $wpdb->query("UPDATE $list_table SET active=1 WHERE id=$officer_list");
	}
	$users = get_users( 'blog_id=' . get_current_blog_id() );// limit by blog ID
	foreach ( $users as $user ) {
		$sql    = $wpdb->prepare( 'SELECT user_id FROM `' . $wpdb->prefix . 'mailster_list_members` WHERE user_id=%d AND list_id=%d AND is_core_user=1 ', $user->ID, $member_list );
		$onlist = $wpdb->get_var( $sql );
		// check if already on list
		// check if on unsubscribed list
		if ( ! $onlist && ! in_array( strtolower( $user->user_email ), $unsub ) ) {
			$wpdb->insert(
				$wpdb->prefix . 'mailster_list_members',
				array(
					'is_core_user' => 1,
					'user_id'      => $user->ID,
					'list_id'      => $member_list,
				)
			);
		}
	}

	$officers = get_option( 'wp4toastmasters_officer_ids' );
	if ( ! empty( $officers ) && is_array( $officers ) ) {
		foreach ( $officers as $officer ) {
			$user = get_userdata( $officer );
			if ( empty( $user ) ) {
				continue;
			}
			$sql    = $wpdb->prepare( 'SELECT user_id FROM `' . $wpdb->prefix . 'mailster_list_members` WHERE user_id=%d AND list_id=%d AND is_core_user=1 ', $user->ID, $officer_list );
			$onlist = $wpdb->get_var( $sql );
			// check if already on list
			// check if on unsubscribed list
			if ( ! $onlist && ! in_array( strtolower( $user->user_email ), $unsub ) ) {
				$wpdb->insert(
					$wpdb->prefix . 'mailster_list_members',
					array(
						'is_core_user' => 1,
						'user_id'      => $user->ID,
						'list_id'      => $officer_list,
					)
				);
			}
		}
	}

	foreach ( $unsub as $email ) {
		$user = get_user_by( 'email', $email );
		if ( $user ) {
			$sql    = 'DELETE FROM ' . $wpdb->prefix . 'mailster_list_members WHERE is_core_user=1 AND user_id=' . $user->ID;
			$result = $wpdb->query( $sql );
			if ( $result ) {
				echo '<div style="text-align: center;" class="notice">Unsubscribe for ' . $email . '</div>';
			}
		}
	}

	$add_to_whitelist = get_option( 'wpt_mailster_whitelist_pending' );// array of additional emails to add
	if ( ! empty( $add_to_whitelist ) && is_array( $add_to_whitelist ) ) {
		// require_once plugin_dir_path("wp_mailster/models/MailsterModelUser.php");
		foreach ( $add_to_whitelist as $email ) {
			$wpdb->insert(
				$wpdb->prefix . 'mailster_users',
				array(
					'name'  => $email,
					'email' => $email,
				)
			);
			$subscriber_id = $wpdb->insert_id;
			$wpdb->insert(
				$wpdb->prefix . 'mailster_group_users',
				array(
					'is_core_user' => 0,
					'user_id'      => $subscriber_id,
					'group_id'     => $whitelist,
				)
			);
			// $User = new MailsterModelUser($subscriber_id, false);
			// $User->addToGroup($whitelist);
		}
		update_option( 'wpt_mailster_whitelist_pending', null ); // once processed, clear
	}
} // end action / closure

add_action( 'admin_menu', 'toast_mailster_menu', 55 );

function toast_mailster_menu() {
	if ( ! function_exists( 'mailster_install' ) ) {
		return;
	}
	add_submenu_page( 'wpmst_mailster_intro', __( 'Toastmasters Lists', 'rsvpmaker-for-toastmasters' ), __( 'Toastmasters Lists', 'rsvpmaker-for-toastmasters' ), 'edit_posts', 'mailster_toastmasters', 'mailster_toastmasters' );
}

function mailster_toastmasters() {
	if ( ! function_exists( 'mailster_install' ) ) {
		return;
	}
	echo '<h1>Toastmasters Lists in Mailster</h1>';
	global $wpdb;
	$member_list  = get_option( 'wpt_mailster_memberlist' );
	$officer_list = get_option( 'wpt_mailster_officerslist' );
	$list_table   = $wpdb->prefix . 'mailster_lists';

	if ( isset( $_POST['email'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$emails = preg_split( '/[,\n]/', sanitize_textarea_field($_POST['email']) );
		foreach ( $emails as $email ) {
			$email = strtolower( trim( $email ) );
			if ( is_email( $email ) ) {
				$whitelist[] = $email;
			}
		}
		if ( ! empty( $whitelist ) ) {
			update_option( 'wpt_mailster_whitelist_pending', $whitelist );
			printf( '<div class="notice">Emails added to whitelist: %s</div>', var_export( $whitelist, true ) );
		}
	}
	if ( isset( $_POST['extra'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		$unsub = get_option( 'rsvpmail_unsubscribed' );
		if ( empty( $unsub ) ) {
			$unsub = array();
		}
		$emails = preg_split( '/[,\n]/', array_map('sanitize_text_field',$_POST['extra']) );
		foreach ( $emails as $email ) {
			$email = strtolower( trim( $email ) );
			if ( is_email( $email ) ) {
				$extra[] = $email;
			}
		}
		if ( ! empty( $extra ) ) {
			foreach ( $extra as $email ) {
				$user = get_user_by( 'email', $email );
				if ( ! empty( $user ) ) {
					printf( '<p>%s has an active user account</p>', $email );
				}

				if ( in_array( $email, $unsub ) ) {
					printf( '<p>%s is on the unsubscribed list</p>', $email );
					continue;
				}
				$sql           = $wpdb->prepare( 'SELECT id FROM `' . $wpdb->prefix . 'mailster_users` WHERE email=%s', $email );
				$subscriber_id = $wpdb->get_var( $sql );
				if ( ! $subscriber_id ) {
					$wpdb->insert(
						$wpdb->prefix . 'mailster_users',
						array(
							'name'  => $email,
							'email' => $email,
						)
					);
					$subscriber_id = $wpdb->insert_id;
				}
				$sql    = $wpdb->prepare( 'SELECT user_id FROM `' . $wpdb->prefix . 'mailster_list_members` WHERE user_id=%d AND list_id=%d AND is_core_user=1 ', $subscriber_id, $member_list );
				$onlist = $wpdb->get_var( $sql );
				if ( $onlist ) {
					printf( '<p>%s is already on the member list</p>', $email );
				} else {
					$wpdb->insert(
						$wpdb->prefix . 'mailster_list_members',
						array(
							'is_core_user' => 0,
							'user_id'      => $subscriber_id,
							'list_id'      => $member_list,
						)
					);
					printf( '<p>%s added to member list</p>', $email );
				}
			}
		}
	}
	?>
<h3>List Status</h3>
	<?php
	if ( isset( $_POST['activate'] ) && wp_verify_nonce(rsvpmaker_nonce_data('data'),rsvpmaker_nonce_data('key')) ) {
		foreach ( $_POST['activate'] as $list_id ) {
			$list_id = sanitize_text_field($list_id);
			$wpdb->query( "UPDATE $list_table SET active=1 WHERE id=$list_id" );
		}
		delete_option( 'wp4toastmasters_mailman' );
	}

	$sql           = $wpdb->prepare( 'SELECT `name`, list_mail, mail_in_pw, active, server_inb_id FROM ' . $list_table . ' WHERE id=%d', $member_list );
	$member_login  = $wpdb->get_row( $sql );
	$sql           = $wpdb->prepare( 'SELECT `name`, list_mail, mail_in_pw, active, server_inb_id FROM ' . $list_table . ' WHERE id=%d', $officer_list );
	$officer_login = $wpdb->get_row( $sql );
	$activate_form = '';
	if ( $member_login->active ) {
		printf( '<p><strong>%s</strong> is active. <a href="%s">Tweak and Test</a> / <a href="%s">See Members</a></p>', $member_login->name, admin_url( 'admin.php?page=mst_mailing_lists&subpage=edit&lid=' . $member_list ), admin_url( 'admin.php?page=mst_mailing_lists&subpage=edit&lid=' . $member_list ) );
	} else {
		$activate_form .= sprintf( '<p><strong>%s</strong> NOT active<br />Create email account %s pw: %s<br /><input type="checkbox" name="activate[]" value="%d" /> Mark activated</p>', $member_login->name, $member_login->list_mail, $member_login->mail_in_pw, $member_list );
	}
	if ( $officer_login->active ) {
		printf( '<p><strong>%s</strong> is active. <a href="%s">Tweak and Test</a> / <a href="%s">See Members</a></p>', $officer_login->name, admin_url( 'admin.php?page=mst_mailing_lists&subpage=edit&lid=' . $officer_list ), admin_url( 'admin.php?page=mst_mailing_lists&subpage=recipients&lid=' . $officer_list ) );
	} else {
		$activate_form .= sprintf( '<p><strong>%s</strong> NOT active<br />Create email account %s pw: %s <br /><input type="checkbox" name="activate[]" value="%d" /> Mark activated</p>', $officer_login->name, $officer_login->list_mail, $officer_login->mail_in_pw, $officer_list );
	}
	if ( ! empty( $activate_form ) ) {
		printf( '<form method="post" action="%s">%s<button>Activate Checked</button>%s</form>', admin_url( 'admin.php?page=mailster_toastmasters' ), $activate_form, rsvpmaker_nonce('return') );
	}

	if ( ! $member_login->server_inb_id ) {
		printf( '<p><strong>%s</strong> no server settings configured. <a href="%s">Edit Settings</a></p>', $member_login->name, admin_url( 'admin.php?page=mst_mailing_lists&subpage=edit&lid=' . $member_list ) );
	}

	if ( ! $officer_login->server_inb_id ) {
		printf( '<p><strong>%s</strong> no server settings configured. <a href="%s">Edit Settings</a></p>', $officer_login->name, admin_url( 'admin.php?page=mst_mailing_lists&subpage=edit&lid=' . $officer_list ) );
	}

	if ( function_exists( 'wpt_mailster_cpanel_link' ) ) {
		wpt_mailster_cpanel_link();
	}
	?>
<h3>Whitelist Emails</h3>
<p>The mailing list software will accept messages from any email address associated with a user record.</p><p>You can add additional &quot;whitelist&quot; email addresses that should be allowed to send to the list.</p><p>Enter one or more email addresses, separated by commas or line breaks.</p>
<form method="post" action="<?php echo admin_url( 'admin.php?page=mailster_toastmasters' ); ?>">
<textarea name="email" rows="5" cols="80"></textarea>
<br /><button>Add to Whitelist</button>
<?php rsvpmaker_nonce(); ?>
</form>

<h3>Additional List Members</h3>
<p>Add recipients who do not have a member/user account (such as former/honorary members).</p><p>Enter one or more email addresses, separated by commas or line breaks.</p>
<form method="post" action="<?php echo admin_url( 'admin.php?page=mailster_toastmasters' ); ?>">
<textarea name="extra" rows="5" cols="80"></textarea>
<br /><button>Add to Member List</button>
<?php rsvpmaker_nonce(); ?>
</form>

<p><a href="<?php echo admin_url( 'edit.php?post_type=rsvpemail&page=unsubscribed_list' ); ?>">Unsubscribed / blocked emails</a></p>
<h3>Members Email List</h3>
	<?php
	$sql     = 'SELECT user_email FROM `' . $wpdb->prefix . "mailster_list_members` JOIN $wpdb->users ON `" . $wpdb->prefix . "mailster_list_members`.user_id=$wpdb->users.ID WHERE  is_core_user=1 AND list_id=" . $member_list . ' ORDER BY user_email';
	$results = $wpdb->get_results( $sql );
	foreach ( $results as $row ) {
		echo esc_html($row->user_email) . '<br />';
	}

}

function wpt_mailster_get_email() {
	if ( ! function_exists( 'mailster_install' ) ) {
		return;
	}
	global $wpdb;
	$member_list = get_option( 'wpt_mailster_memberlist' );
	return $wpdb->get_var( 'SELECT list_mail FROM ' . $wpdb->prefix . 'mailster_lists WHERE id=' . $member_list );
}

?>
