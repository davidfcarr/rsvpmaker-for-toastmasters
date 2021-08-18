<?php
/*
* Speech and role history
*/

add_action('init','wp4t_build_history_table');
function wp4t_build_history_table() {
global $wpdb;
$history_table = $wpdb->base_prefix.'tm_history';
$speech_history_table = $wpdb->base_prefix.'tm_speech_history';
$version = 11;
$ver = (int) get_option('history_table_version');
//$test = @ $wpdb->get_var("SELECT 1 FROM `$history_table` LIMIT 1");
if($ver < $version)
{
    update_option('history_table_version',$version);
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    $sql = "CREATE TABLE `$history_table` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `role` varchar(100) NOT NULL,
        `datetime` datetime NOT NULL,
        `rolecount` smallint(6) NOT NULL,
        `domain` varchar(255) NOT NULL,
        `user_id` int(11) NOT NULL,
        `post_id` int(11) NOT NULL,
        `metadata` text,
        `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        KEY `user_id` (`user_id`),
        KEY `role` (`role`),
        KEY `datetime` (`datetime`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

      dbDelta($sql);

    $sql = "CREATE TABLE `$speech_history_table` (
        `speech_id` int(11) NOT NULL AUTO_INCREMENT,
        `history_id` int(11) NOT NULL,
        `manual` varchar(255) NOT NULL,
        `project_key` varchar(255) NOT NULL,
        `project` varchar(255) NOT NULL,
        `title` varchar(255) NOT NULL,
        `intro` text NULL,
        PRIMARY KEY (`speech_id`),
        KEY `manual` (`manual`),
        KEY `history_id` (`history_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
      //CONSTRAINT `".$speech_history_table."_ibfk_1` FOREIGN KEY (`history_id`) REFERENCES `$history_table` (`id`) ON DELETE CASCADE
      dbDelta($sql);

      wp4t_history_overview();//start the process of importing legacy records
}

} // end build tables

function wp4toastmasters_history() {
	$export_link = sprintf( '<a href="%s?page=%s&tm_export=%s&%s">Export Summary</a>', admin_url( 'admin.php' ), 'import_export', $nonce,$timelord );
	$export_role = sprintf( '<a href="%s?page=%s&tm_export=%s&%s&role=1">Export Role Report</a>', admin_url( 'admin.php' ), 'import_export', $nonce,$timelord );
    $sidebar = sprintf('<div>Export Options (Spreadsheet/CSV)<br>%s<br>%s</div>',$export_link,$export_role);
    $hook = tm_admin_page_top(__('Reports','rsvpmaker-for-toastmasters'),$sidebar);
    if(empty($_GET['rsvp_print']))
        update_user_role_archive_all();
    global $wpdb, $rsvp_options, $current_user, $page;
    $history_table = $wpdb->base_prefix.'tm_history';
    $speech_history_table = $wpdb->base_prefix.'tm_speech_history';
    $startover = isset($_GET['startover']);
    wp4t_history_overview($startover);
    $output = '';
    if(isset($_GET['user_id']))
        $user_id = intval($_GET['user_id']);
    else
        $user_id = ('my_progress_report' == $_GET['page']) ? $current_user->ID : 0;
        $members = get_club_members();
        foreach($members as $member)
            $and[] = 'user_id='.$member->ID;
        $where = 'WHERE 1 AND ('.implode(' OR ',$and).')';
        $allchecked = '';
        $notallchecked = '';
        $datechecked = '';
        $nodatechecked = '';
        $speakerchecked = '';
        $pathchecked = '';
        $countbyrolechecked = '';
        $countspeecheschecked = '';
        $mostactivechecked = '';
        $latestchecked = '';

        if(isset($_GET['limit'])) {
            $limit = sanitize_text_field($_GET['limit']);
            if($limit == 'all')
                $limitsql = '';
            else
               $limitsql = ' LIMIT 0,'.$limit; 
        }
        else
            {
                $limit = 100;
                $limitsql = ' LIMIT 0,'.$limit; 
            }
        if(empty($_GET['all']))
            {
                $notallchecked = ' checked="checked" ';
                $where .= " AND domain='".$_SERVER['SERVER_NAME']."' ";
                $filters[] = 'for all member clubs on this website';
            }
        else
        {
            $allchecked = ' checked="checked" ';
            $filters[] = 'for clubs on this website';
        }
        if($user_id) {
            $where .= " AND user_id=" . $user_id. ' ';
            $filters[] = 'filtered by user';
        }
        if(!empty($_GET['datefilter']) && !empty($_GET['since']))
        {
            $datechecked = ' checked="checked" ';
            $date = sanitize_text_field($_GET['since']);
            $where .= sprintf(" AND datetime > '%s' ",$date);
            $filters[] = ' more recent than '.$date;
        }
        else {
            $nodatechecked = ' checked="checked" ';
            $filters[] = 'not filtered by date';
        }
        if(isset($_GET['type']) && ($_GET['type'] == 'speaker'))
        {
            $speakerchecked = ' checked="checked" ';
            $where .= " AND role LIKE '%Speaker%' ";
            $filters[] = 'speaker roles only';
            $sql = "SELECT * FROM $history_table LEFT JOIN $speech_history_table ON $history_table.id = $speech_history_table.history_id $where ORDER BY datetime DESC ".$limitsql;
            $results = $wpdb->get_results($sql);
            foreach($results as $row) {
                $temp = sprintf('<p><strong>%s</strong>, %s %s %s</p>',get_member_name($row->user_id),$row->role,rsvpmaker_date($rsvp_options['long_date'],rsvpmaker_strtotime($row->datetime)), $row->domain);
                $temp .= sprintf('<p class="speech_details">Title: <em>%s</em>, Path/Level: %s, Project: %s</p>',$row->title,$row->manual,$row->project);
                $output .= $temp;
                if(!empty($row->manual)) {
                    $index = (strpos($row->manual,'Level')) ? ' '.$row->manual : $row->manual;//pathways at top of list
                    $manualsort[$index] = $temp;
                }
            }
            ksort($manualsort);
            foreach($manualsort as $manual => $content)
                $output .= '<h2>'.$manual.'</h2>'.$content;
        }
        elseif(isset($_GET['type']) && ($_GET['type'] == 'path'))
        {
            $pathchecked = 'checked="checked"';
            $filters[] = 'speech by path';
            $where .= " AND role LIKE '%Speaker%' ";
            $sql = "SELECT  user_id, manual, count(manual) as tally FROM $history_table LEFT JOIN $speech_history_table ON $history_table.id = $speech_history_table.history_id $where GROUP BY user_id, manual ORDER BY user_id, manual".$limitsql;
            $results = $wpdb->get_results($sql);
            foreach($results as $row) {
                $index = wp4t_name_index($row->user_id);
                if(empty($msort[$index]))
                    $msort[$index] = '';
                $msort[$index] .= sprintf('<p><strong>%s</strong>, %s <strong>%s</strong></p>',get_member_name($row->user_id),$row->manual,$row->tally);
            }
            ksort($msort);
            $output .= implode("\n",$msort);
        }
        elseif(isset($_GET['type']) && ($_GET['type'] == 'countbyrole'))
        {
            $countbyrolechecked = ' checked="checked" ';
            $filters[] = 'count by member, by role';
            $sql = "SELECT  user_id, role, count(*) as tally FROM $history_table LEFT JOIN $speech_history_table ON $history_table.id = $speech_history_table.history_id $where GROUP BY user_id, role ORDER BY user_id, role ".$limitsql;
            $results = $wpdb->get_results($sql);
            foreach($results as $row) {
                $index = wp4t_name_index($row->user_id);
                if(empty($msort[$index]))
                    $msort[$index] = '';
                $msort[$index] .= sprintf('<p><strong>%s</strong>, %s %s</p>',get_member_name($row->user_id),$row->role,$row->tally);
            }
            ksort($msort);
            $output .= implode("\n",$msort);
        }
        elseif(isset($_GET['type']) && ($_GET['type'] == 'countspeeches'))
        {
            $countspeecheschecked = ' checked="checked" ';
            $filters[] = 'count speeches';
            $where .= " AND role = 'speaker' ";
            $sql = "SELECT  user_id, role, count(*) as tally FROM $history_table LEFT JOIN $speech_history_table ON $history_table.id = $speech_history_table.history_id $where GROUP BY user_id, role ORDER BY tally DESC ".$limitsql;
            $results = $wpdb->get_results($sql);
            foreach($results as $row) {
                $output .= sprintf('<p><strong>%s</strong>, %s %s</p>',get_member_name($row->user_id),$row->role,$row->tally);
            }
        }
        elseif(isset($_GET['type']) && ($_GET['type'] == 'mostactive'))
        {
            $mostactivechecked = ' checked="checked" ';
            $filters[] = 'count by most active';
            $sql = "SELECT  user_id, count(role) as tally FROM $history_table LEFT JOIN $speech_history_table ON $history_table.id = $speech_history_table.history_id $where GROUP BY user_id ORDER BY count(role) DESC".$limitsql;
            $results = $wpdb->get_results($sql);
            foreach($results as $row) {
                $output .= sprintf('<p><strong>%s</strong>, %s total roles</p>',get_member_name($row->user_id),$row->tally);
            }
        }
        else {
            $latestchecked = ' checked="checked" ';
            $filters[] = '100 most recent';
            $sql = "SELECT * FROM $history_table LEFT JOIN $speech_history_table ON $history_table.id = $speech_history_table.history_id $where ORDER BY datetime DESC ".$limitsql;
            $results = $wpdb->get_results($sql);
            foreach($results as $row) {
                $output .= sprintf('<p><strong>%s</strong>, %s %s %s</p>',get_member_name($row->user_id),$row->role,rsvpmaker_date($rsvp_options['long_date'],rsvpmaker_strtotime($row->datetime)), $row->domain);
                if(strpos($row->role,'peaker'))
                    $output .= sprintf('<p class="speech_details">Title: <em>%s</em>, Path/Level: %s, Project: %s</p>',$row->title,$row->manual,$row->project);
            }    
        }

    $year = (date('n') < 7) ? (date('Y') - 1) : date('Y');
    $since = (empty($_GET['since'])) ?  $year.'-07-01': sanitize_text_field($_GET['since']);
    $nonce       = wp_create_nonce( 'tm_export' );
	$timelord = rsvpmaker_nonce('query');
    if(empty($_GET['rsvp_print'])) {
        printf("<p>Active filters: %s</p>",implode(', ',$filters));
        printf('<form method="get" action="%s">
        <p>%s</p>
        <input type="hidden" name="page" value="toastmasters_reports" >
        Available filters: <br>
        <input type="radio" name="type" value="latest" %s> Latest <input type="radio" name="type" value="speaker" %s> Speeches <input type="radio" name="type" value="path" %s> Speeches by manual/path & level <input type="radio" name="type" value="mostactive" %s> Most Active <input type="radio" name="type" value="countbyrole" %s> Count by role <input type="radio" name="type" value="countspeeches" %s> Count speeches<br>
        <input type="radio" name="all" value="0" %s> Just for this club website <input type="radio" name="all" value="1" %s> Include data from other clubs (where available)<br>
        <input type="radio" name="datefilter" value="0" %s> Not filtered by date <input type="radio" name="datefilter" value="1" %s> Filtered by date > <input type="text" name="since" value="%s" > (YEAR-MONTH-DATE)<br>
        Up to <select name="limit"><option value="%s">%s</option> records
        <option value="100">100</option>
        <option value="200">200</option>
        <option value="300">300</option>
        <option value="400">400</option>
        <option value="500">500</option>
        <option value="all">%s</option>
        </select><br>
        <button>Filter</button>
        </form>',admin_url('admin.php'), awe_user_dropdown('user_id',$user_id, true, 'All Members'), $latestchecked, $speakerchecked, $pathchecked, $mostactivechecked, $countbyrolechecked, $countspeecheschecked, $notallchecked, $allchecked, $nodatechecked, $datechecked, $since, $limit, $limit, __('No limit','rsvpmaker-for-toastmasters') );    
    }
    echo $output;
    tm_admin_page_bottom($hook);
}

function wp4toastmasters_history_edit() {
    echo '<h1>Edit Records</h1>';
    global $wpdb, $rsvp_options, $current_user, $page;
    $history_table = $wpdb->base_prefix.'tm_history';
    $speech_history_table = $wpdb->base_prefix.'tm_speech_history';

    if(isset($_POST['confirmed_delete'])) {
        foreach($_POST['confirmed_delete'] as $id)
        {
            $wpdb->query("delete from $history_table WHERE id=$id");
            $wpdb->query("delete from $speech_history_table WHERE history_id=$id");
            echo "<p>Deleted: $id</p>";
        }
    }

    if(isset($_POST['editor_assign'])) {
        foreach($_POST['editor_assign'] as $key => $value)
        {
            $role = clean_role($key);
            $id = preg_replace('/[^0-9]/','',$key);
            echo "<p>Updating $role record $id</p>";
            $sql = "update $history_table SET user_id=$value WHERE id=$id";
            $wpdb->query($sql);
            if('Speaker' == $role)
            {
                $manual = sanitize_text_field($_POST['_manual'][$key]);
                $project_key = sanitize_text_field($_POST['_project'][$key]);
                $project = get_project_text($project_key);
                $title = sanitize_text_field(stripslashes($_POST['_title'][$key]));
                $intro = wp_kses_post(stripslashes($_POST['_intro'][$key]));
                $sql = $wpdb->prepare("UPDATE $speech_history_table SET manual=%s, project_key=%s, project=%s, title=%s, intro=%s WHERE history_id=%d",$manual,$project_key,$project,$title,$intro,$id);
                $wpdb->query($sql);
            }
        }
    }

    if(isset($_POST['select'])) {
        foreach($_POST['select'] as $item){
            $p = explode(':',sanitize_text_field($item));
            if($p[0] == 'edit') 
                $edit[] = intval($p[1]);
            else
                $delete[] = intval($p[1]);
        }
        if(!empty($edit) || !empty($delete))
        printf('<h3>Form Starts Here</h3><form method="post" action="%s">',admin_url('admin.php?page=wp4toastmasters_history_edit'));
        if(!empty($edit)) {
            foreach($edit as $history_id) {
                foreach($edit as $history_id) {
                    $row = $wpdb->get_row("select * from $history_table LEFT JOIN $speech_history_table ON $history_table.id = $speech_history_table.history_id WHERE id=$history_id");
                    $role = $row->role;
                    $field = '_'.str_replace(' ','_',$role).'_'.$row->id;
                    $detailsform = '';
                    if($role == 'Speaker') {
                        $detailsform = speaker_details_history($row->post_id, $field, $row, $row->id );
                    }
                    $awe_user_dropdown = awe_user_dropdown( $field, $row->user_id );
                    printf('<div><h3>%s</h3><div> %s %s </div></div>',$role,$awe_user_dropdown,$detailsform);
                }    
            }
        }
        if(!empty($delete)) {
            echo '<h3>'.__('Confirm: Delete These Records?','rsvpmaker-for-toastmasters').'</h3>';
            foreach($delete as $history_id) {
                $row = $wpdb->get_row("select * from $history_table WHERE id=$history_id");
                printf('<p><input type="checkbox" name="confirmed_delete[]" value="%s" checked="checked"> %s %s %s</p>',$row->id,get_member_name($row->user_id),$row->role,$row->datetime);
            }
        }
        printf('<p><button style="font-size: larger;">%s</button></p></form>',__('Submit Edits','rsvpmaker_for_toastmasters'));
    }

    if(!empty($_POST['select']))
       {
        printf('<p><a href="%s">%s</a></p>',admin_url('admin.php?page=wp4toastmasters_history_edit'),__('Refresh','rsvpmaker-for-toastmasters'));
        return;
       } 

    $output = '<h2>Select Records</h2>';
    if(isset($_REQUEST['user_id']))
        $user_id = intval($_REQUEST['user_id']);
    else
        $user_id = 0;

        $members = get_club_members();
        foreach($members as $member)
            $and[] = 'user_id='.$member->ID;
        $where = 'WHERE 1 AND ('.implode(' OR ',$and).')';
        $allchecked = '';
        $notallchecked = '';
        $datechecked = '';
        $nodatechecked = '';
        $speakerchecked = '';
        $latestchecked = '';

        if(isset($_GET['limit'])) {
            $limit = sanitize_text_field($_GET['limit']);
            if($limit == 'all')
                $limitsql = '';
            else
               $limitsql = ' LIMIT 0,'.$limit; 
        }
        else
            {
                $limit = 100;
                $limitsql = ' LIMIT 0,'.$limit; 
            }
        if(empty($_GET['all']))
            {
                $notallchecked = ' checked="checked" ';
                $where .= " AND domain='".$_SERVER['SERVER_NAME']."' ";
                $filters[] = 'for all member clubs on this website';
            }
        else
        {
            $allchecked = ' checked="checked" ';
            $filters[] = 'for clubs on this website';
        }
        if($user_id) {
            $where .= " AND user_id=" . $user_id. ' ';
            $filters[] = 'filtered by user';
        }
        if(!empty($_GET['datefilter']) && !empty($_GET['since']))
        {
            $datechecked = ' checked="checked" ';
            $date = sanitize_text_field($_GET['since']);
            $where .= sprintf(" AND datetime > '%s' ",$date);
            $filters[] = ' more recent than '.$date;
        }
        else {
            $nodatechecked = ' checked="checked" ';
            $filters[] = 'not filtered by date';
        }
        if(isset($_GET['type']) && ($_GET['type'] == 'speaker'))
        {
            $speakerchecked = ' checked="checked" ';
            $where .= " AND role LIKE '%Speaker%' ";
            $filters[] = 'speaker roles only';        
        }
        else 
            $latestchecked = ' checked="checked" ';
        $sql = "SELECT * FROM $history_table LEFT JOIN $speech_history_table ON $history_table.id = $speech_history_table.history_id $where ORDER BY datetime DESC ".$limitsql;
        $results = $wpdb->get_results($sql);
        foreach($results as $row) {
            $controls = sprintf('<input type="radio" name="select[%d]" value="edit:%s"> %s <input type="radio" name="select[%d]" value="delete:%s"> %s ',$row->id,$row->id,__('Edit','rsvpmaker-for-toastmasters'),$row->id,$row->id,__('Delete','rsvpmaker-for-toastmasters') );
            $output .= sprintf('<p>%s<strong>%s</strong>, %s %s %s</p>',$controls,get_member_name($row->user_id),$row->role,rsvpmaker_date($rsvp_options['long_date'],rsvpmaker_strtotime($row->datetime)), $row->domain);
            if(strpos($row->role,'peaker'))
                $output .= sprintf('<p class="speech_details">Title: <em>%s</em>, Path/Level: %s, Project: %s</p>',$row->title,$row->manual,$row->project);
        }
    
    $output = '<form style="margin-bottom: 100px;" method="post" action="'.admin_url('admin.php?page=wp4toastmasters_history_edit').'">'.$output.'
    <div style="position: fixed; top: 50%; right: 0; width: 200px; padding: 50px; background-color: #fff; border-radius: 10px; ">
    <p>Pick records to edit or delete and click Select.</p>
    <button style="font-size: larger;">'.__('Select','rsvpmaker-for-toastmasters').'</button></div></form>';

    $year = (date('n') < 7) ? (date('Y') - 1) : date('Y');
    $since = (empty($_GET['since'])) ?  $year.'-07-01': sanitize_text_field($_GET['since']);
    printf("<p>Active filters: %s</p>",implode(', ',$filters));
    printf('<form method="get" action="%s">
    <p>%s</p>
    <input type="hidden" name="page" value="wp4toastmasters_history_edit" >
    Available filters: <br>
    <input type="radio" name="type" value="latest" %s> Latest <input type="radio" name="type" value="speaker" %s> Speeches <br>
    <input type="radio" name="all" value="0" %s> Just for this club website <input type="radio" name="all" value="1" %s> Include data from other clubs (where available)<br>
    <input type="radio" name="datefilter" value="0" %s> Not filtered by date <input type="radio" name="datefilter" value="1" %s> Filtered by date > <input type="text" name="since" value="%s" > (YEAR-MONTH-DATE)<br>
    Up to <select name="limit"><option value="%s">%s</option> records
    <option value="100">100</option>
    <option value="200">200</option>
    <option value="300">300</option>
    <option value="400">400</option>
    <option value="500">500</option>
    <option value="all">%s</option>
    </select><br>
    <button>Filter</button>
    </form>',admin_url('admin.php'), awe_user_dropdown('user_id',$user_id, true, 'Overview'), $latestchecked, $speakerchecked, $notallchecked, $allchecked, $nodatechecked, $datechecked, $since, $limit, $limit, __('No limit','rsvpmaker-for-toastmasters') );
    echo $output;

$examined = array();
echo $sql = "SELECT * from $history_table order by datetime DESC LIMIT 0, 30";
$results = $wpdb->get_results($sql);
//print_r($results);
foreach($results as $row) {
    if(in_array($row->id,$examined))
        continue;
    $examined[] = $row->id;
    $sql = $wpdb->prepare("SELECT * FROM $history_table WHERE role=%s AND datetime=%s AND domain=%s AND id != %d",$row->role, $row->datetime,$row->domain,$row->ID);
    $dres = $wpdb->get_results($sql);
    if(sizeof($dres))
    {
    printf('<p>%s %s %s %s %s</p>',$row->role, $row->rolecount, $row->user_id, $row->datetime, $row->domain);
        //print_r($dres);
    foreach($dres as $drow) {
        if(in_array($drow->id,$examined))
            continue;
        $examined[] = $drow->id;
        //echo 'possible duplicate';
        printf('<p><em>Duplicate?</em> %s %s %s %s %s</p>',$drow->role, $drow->rolecount, $drow->user_id, $drow->datetime, $drow->domain);
    }
    }
}
return;
echo '<h3>Debugging</h3>';
echo $sql = "SELECT * FROM $wpdb->usermeta where meta_key LIKE 'tm|Ah%' ORDER BY umeta_id DESC LIMIT 0,100";
$results = $wpdb->get_results($sql);
foreach($results as $row) {
    printf('<p>%s</p>',$row->meta_key);
    $data = unserialize($row->meta_value);
    printf('<pre>%s</pre>',var_export($data,true));
}

}

add_action('wp4t_history_overview','wp4t_history_overview');

/* imports old usermeta records */
function wp4t_history_overview($startover = false) {
global $wpdb;
$history_table = $wpdb->base_prefix.'tm_history';
$speech_history_table = $wpdb->base_prefix.'tm_speech_history';  
$checkimported = (function_exists('get_blog_option')) ? (int) get_blog_option(1,'wp4t_imported_usermeta') : (int) get_option('wp4t_imported_usermeta');
if($startover) {
    $wpdb->query('truncate table '.$speech_history_table);
    $wpdb->query('truncate table '.$history_table);
    $startfrom = 0;
    echo "<p style=\"color:red\">Starting over to rebuild table</p>";
}
elseif($checkimported)
    return;//don't keep pulling in old records
else
    $startfrom = (int) get_option('wp4history_start');

$sql     = "SELECT * FROM `$wpdb->usermeta` WHERE meta_key LIKE 'tm|%' AND umeta_id > $startfrom ORDER BY umeta_id LIMIT 0, 500";
$results = $wpdb->get_results( $sql );
if(empty($results)) {
    wp_clear_scheduled_hook( 'wp4t_history_overview' );
    if(function_exists('update_blog_option'))
        update_blog_option(1,'wp4t_imported_usermeta',1);
    else
        update_option('wp4t_imported_usermeta',1);
    return;
}
else {
    if(!wp_next_scheduled('wp4t_history_overview'))
        wp_schedule_event(time()+60,'hourly','wp4t_history_overview');
    echo '<p style="color: red; font-weight: bold;">Data refresh scheduled. The latest data should be displayed shortly.</p>';
}
$function = 'copied from usermeta';
foreach($results as $row) {
    $startfrom = $row->umeta_id;
    $user_id = $row->user_id;
    $key_array  = explode( '|', $row->meta_key );
    $role       = $key_array[1];
    $timestamp = $key_array[2];
    $rolecount  = $key_array[3];
    $domain     = $key_array[4];
    $post_id    = $key_array[5];
    $manual = $project_key = $title = $intro = '';
    if(strpos($role,'peaker'))
    {
    $roledata = unserialize( $row->meta_value );
    $manual   = ( empty( $roledata['manual'] ) ) ? 'Other' : $roledata['manual'];
    $project_key = (empty( $roledata['project'] ) ) ? '' : $roledata['project'];
    $project = (empty( $roledata['project'] ) ) ? '' : get_project_text( $roledata['project'] );
    $title = (empty($roledata['title'])) ? '' : $roledata['title'];
    $intro = (empty($roledata['intro'])) ? '' : $roledata['intro'];
    }
    wp4t_record_history_to_table($user_id, '_'.$role.'_'.$rolecount, $timestamp, $post_id, $function, $manual,$project_key,$title,$intro, $domain);
}//foreach usermeta
update_option('wp4history_start',$startfrom);
}

function former_member_history($user_id,$old_id = 0) {
global $wpdb;
$history_table = $wpdb->base_prefix.'tm_history';
$sql     = "SELECT * FROM `$wpdb->usermeta` WHERE meta_key LIKE 'tm|%' AND user_id=$user_id";
$results = $wpdb->get_results( $sql );
$function = 'former_member_history';
foreach($results as $row) {
    $startfrom = $row->umeta_id;
    $user_id = $row->user_id;
    $key_array  = explode( '|', $row->meta_key );
    $role       = $key_array[1];
    $timestamp = $key_array[2];
    $rolecount  = $key_array[3];
    $domain     = $key_array[4];
    $post_id    = $key_array[5];
    $manual = $project_key = $title = $intro = '';
    if(strpos($role,'peaker'))
    {
    $roledata = unserialize( $row->meta_value );
    $manual   = ( empty( $roledata['manual'] ) ) ? 'Other' : $roledata['manual'];
    $project_key = (empty( $roledata['project'] ) ) ? '' : $roledata['project'];
    $project = (empty( $roledata['project'] ) ) ? '' : get_project_text( $roledata['project'] );
    $title = (empty($roledata['title'])) ? '' : $roledata['title'];
    $intro = (empty($roledata['intro'])) ? '' : $roledata['intro'];
    }
    wp4t_record_history_to_table($user_id, '_'.$role.'_'.$rolecount, $timestamp, $post_id, $function, $manual,$project_key,$title,$intro, $domain);
    if($old_id && ($old_id != $user_id))
        $wpdb->query("UPDATE $history_table SET user_id=$user_id WHERE user_id=$old_id");
}//foreach usermeta

}
/*
add_member_speech
post_user_role_archive
update_user_role_archive
archive_legacy_roles_usermeta - called on login from archive_site_user_roles
wp_ajax_editor_assign
*/

function wp4t_record_history_to_table($user_id, $role, $timestamp, $post_id, $function, $manual = '',$project_key='',$title='',$intro='', $domain='', $role_count = 0) {
	global $wpdb;
	//history table
    if(empty($rolecount))
    	$role_count = preg_replace( '/[^0-9]/', '', $role );
	$role = str_replace( 'Contest_Speaker', 'Speaker', $role );
	$role = trim( preg_replace( '/[^\sa-zA-Z]/', ' ', $role ) );
    if(empty($domain))
	    $domain = sanitize_text_field($_SERVER['SERVER_NAME']); 
	$history_table = $wpdb->base_prefix.'tm_history';
    $speech_history_table = $wpdb->base_prefix.'tm_speech_history';
	$sql = $wpdb->prepare("SELECT id FROM $history_table WHERE domain=%s AND role=%s AND (rolecount=%s OR user_id=%s) AND datetime=%s",$domain,$role,$role_count,$user_id,$timestamp);
	$id = $wpdb->get_var($sql);
	if($id) {
		$sql = $wpdb->prepare("UPDATE $history_table SET domain=%s, role=%s, rolecount=%s, datetime=%s, user_id=%d, post_id=%d, metadata=%s WHERE id=%d",$domain,$role,$role_count,$timestamp,$user_id,$post_id, serialize(make_tm_roledata_array( $function )),$id);
        $wpdb->query($sql);
    }
	else
    {
	$sql = $wpdb->prepare("INSERT INTO $history_table SET domain=%s, role=%s, rolecount=%s, datetime=%s, user_id=%d, post_id=%d, metadata=%s",$domain,$role,$role_count,$timestamp,$user_id,$post_id, serialize(make_tm_roledata_array( $function )));
	$success = $wpdb->query($sql);
    $id = ($success) ? $wpdb->insert_id : 0;
    }
	rsvpmaker_debug_log($sql,'record to history table');
    rsvpmaker_debug_log($post_id,'history post id');
    rsvpmaker_debug_log($user_id,'history user id');
	if($role == 'Speaker') {
		$speech_id = $wpdb->get_var("SELECT speech_id from $speech_history_table WHERE history_id=$id");
		if($speech_id)
			$sql = $wpdb->prepare("UPDATE $speech_history_table SET manual=%s, project_key=%s, project=%s, title=%s, intro=%s, history_id=%d WHERE speech_id=%d",$manual,$project_key,get_project_text($project_key),$title,$intro,$id,$speech_id);
		else
			$sql = $wpdb->prepare("INSERT INTO $speech_history_table SET manual=%s, project_key=%s, project=%s, title=%s, intro=%s, history_id=%d",$manual,$project_key,get_project_text($project_key),$title,$intro,$id);
		$wpdb->query($sql);
        //echo $sql.'<br />';
		//rsvpmaker_debug_log($sql,'record history speech details');
	}
}

function wp4t_delete_history($role, $timestamp, $post_id) {
	global $wpdb;
	$key      = make_tm_usermeta_key( $role, $timestamp, $post_id );
	$sql = $wpdb->prepare( "DELETE FROM $wpdb->usermeta WHERE meta_key=%s", $key );
	$wpdb->query( $sql );
}

function refresh_tm_history() {
    global $wpdb;
    $history_table = $wpdb->base_prefix.'tm_history';
    $speech_history_table = $wpdb->base_prefix.'tm_speech_history';
	$events_table = $wpdb->prefix . 'rsvpmaker_event';
    $sql = "SELECT * FROM $wpdb->posts JOIN $events_table ON $wpdb->posts.ID=$events_table.event WHERE post_content LIKE '%wp:wp4toastmasters%' AND post_status='publish' AND date < NOW() ORDER BY date DESC LIMIT 0, 5";
    $results = $wpdb->get_results($sql);
    foreach($results as $row) {
        $sql = "SELECT id FROM $history_table WHERE post_id=$row->ID";
        $found = $wpdb->get_var($sql);
        if(!$found) {
            update_user_role_archive( $row->ID, $row->date );
        }
    }
}
add_action( 'refresh_tm_history', 'refresh_tm_history' );

function wp4t_recent_history($user_id) {
    global $wpdb;
    $history_table = $wpdb->base_prefix.'tm_history';
    $sql = "SELECT * FROM $history_table WHERE user_id=$user_id ORDER BY datetime DESC LIMIT 0,3";
    $results = $wpdb->get_results($sql);
    $roles = array();
    foreach($results as $row) {
        if(!in_array($row->role,$roles))
            $roles[] = $row->role;
    }
    return $roles;
}

function wp4t_history_query($where_or_array = '') {
    global $wpdb;
    $where = $groupby = $limit = '';
    $select = '*';
    $orderby = 'ORDER BY datetime DESC';
    if(is_array($where_or_array)){
        if(isset($where_or_array['where']))
            $where = 'WHERE '.$where_or_array['where'];
        if(isset($where_or_array['orderby']))
            $orderby = 'ORDER BY '.$where_or_array['orderby'];
        if(isset($where_or_array['groupby']))
            $groupby = 'GROUP BY '.$where_or_array['groupby'];
        if(isset($where_or_array['limit']))
            $limit = 'LIMIT 0,'.$where_or_array['limit'];
        if(isset($where_or_array['select']))
            $select = $where_or_array['select'];
    }
    elseif(!empty($where_or_array))
        $where = 'WHERE '.$where_or_array;

    $history_table = $wpdb->base_prefix.'tm_history';
    $speech_history_table = $wpdb->base_prefix.'tm_speech_history';
    $sql = "SELECT $select FROM $history_table LEFT JOIN $speech_history_table ON $history_table.id = $speech_history_table.history_id $where $groupby $orderby $limit";
    return $wpdb->get_results($sql);   
} 
