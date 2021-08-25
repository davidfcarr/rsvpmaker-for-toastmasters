<?php
global $wpdb, $post, $rsvp_options, $current_user;
if(is_user_member_of_blog()) 
$identifier = $current_user->ID;
else {
    if(empty($_COOKIE["tm_voting_cookie"]))
    {
        $identifier = rand(1000,100000);
        setcookie("tm_voting_cookie", $identifier, time()+DAY_IN_SECONDS);
    }
    else {
        $identifier = $_COOKIE["tm_voting_cookie"];
        if(empty($identifier))
            $identifier = $_SERVER['REMOTE_ADDR'];
    }
}
?>
<html>
<head>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php wp_head(); ?>
<style>
    body {padding: 15px; background-color: #fff; background-image:none;}
    p {font-size: large;}
</style>
</style>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
<h2>Voting for <?php echo rsvpmaker_date($rsvp_options['long_date'],rsvpmaker_strtotime(get_rsvp_date($post->ID))) ?></h2>
<?php
$actionlink = add_query_arg('voting',1,get_permalink());
if(isset($_POST['claim']) && isset($current_user->ID))
{
    update_post_meta($post->ID,'_Vote_Counter_1',$current_user->ID);
    update_post_meta($post->ID,'vote_counter_claimed',$current_user->ID);
    $vote_counter = $claimed = $current_user->ID;
}
else {
    $vote_counter = (int) get_post_meta($post->ID,'_Vote_Counter_1',true);
    $claimed = (int) get_post_meta($post->ID,'vote_counter_claimed',true);
}

if(is_user_member_of_blog() && ($current_user->ID == $vote_counter)) {
    printf('<p>Logged in as vote counter <a href="%s">check for votes</a></p>',$actionlink);

    $metakey = 'myvote_'.$key.'_'.$identifier;
    $sql = "SELECT * FROM $wpdb->postmeta where post_id=$post->ID AND meta_key LIKE 'myvote%' ORDER BY meta_key, meta_value";
    $results = $wpdb->get_results($sql);
    //print_r($results);
    foreach($results as $row) {
        $p = explode('_',$row->meta_key);
        $contest = $p[1];
        if(isset($votes[$contest][$row->meta_value]))
        $votes[$contest][$row->meta_value]++;
            else
        $votes[$contest][$row->meta_value] = 1;
    }

    foreach($votes as $contest => $contestvote) {
        printf('<h3>%s</h3>',$contest);
        //print_r($contestvote);
        arsort($contestvote);
        foreach($contestvote as $name => $score)
        printf('<p>%s: %s</p>',$name,$score);
    }

    //show vote counter controls
    $claimed = $current_user->ID;

    if(isset($_POST['openvotes']))
    {
        $label = $openvotes = sanitize_text_field($_POST['openvotes']);
        $openvotes = preg_replace('/[^a-z]/','',strtolower($openvotes));
        update_post_meta($post->ID,'votelabel_'.$openvotes,$label);
        $raw = $_POST['candidates'];
        foreach($raw as $r) {
            $r = trim($r);
            if(!empty($r)) {
                $candidates[] = $r;
            }
        }
        //print_r($candidates);
        $key = 'voting_'.$openvotes;
        update_post_meta($post->ID,$key,$candidates);
        add_post_meta($post->ID,'openvotes',$openvotes);
    }

    $open = get_post_meta($post->ID,'openvotes'); // get array

    if(is_array($open)) {
        foreach($open as $v) {
            $check = 'voting_'.$v;
            $contestants = get_post_meta($post->ID,$check,true);
            if(empty($contestants))
                continue;
            $label = get_post_meta($post->ID,'votelabel_'.$v,true);
            printf('<h3>Contest set %s: %s</h3>',$label,implode(', ',$contestants));
            $voting_link = $actionlink.'&key='.$v;
            printf('<p><a href="%s">Voting link for %s %s</a></p>',$voting_link, $label, $voting_link);
        }
    }

    if(!is_array($open) || !in_array('speakers',$open)) {
        $sql = "SELECT * FROM $wpdb->postmeta where post_id=$post->ID AND meta_key LIKE '_Speaker_%' ";
        $results = $wpdb->get_results($sql);
        foreach($results as $row) {
            if(is_numeric($row->meta_value)) {
                $row->meta_value = intval($row->meta_value);
                if($row->meta_value < 1)
                    continue;
                $speakers[] = get_member_name($row->meta_value);
            }
            else
                $speakers[] = $row->meta_value;//guest
        }
        
        printf('<form method="post" adtion="%s">',add_query_arg('voting',1,get_permalink()));    
        printf('<h2>%s</h2>',__('Vote for Speaker','rsvpmaker-for-toastmasters'));
        foreach($speakers as $speaker)
            printf('<div><input type="checkbox" name="candidates[]" value="%s" checked="checked"> %s</div>',$speaker,$speaker);
        for($i=0; $i < 5; $i++)
            echo '<div><input class="candidates" type="text" name="candidates[]"></div>';
        echo '<input type="hidden" name="openvotes" value="Speakers">';
        rsvpmaker_nonce();
        echo '<button>Submit</button></form>';    
    }

    if(!is_array($open) || !in_array('evaluators',$open)) {
    $sql = "SELECT * FROM $wpdb->postmeta where post_id=$post->ID AND meta_key LIKE '_Evaluator_%' ";
    $results = $wpdb->get_results($sql);
    foreach($results as $row) {
        if(is_numeric($row->meta_value)) {
            $row->meta_value = intval($row->meta_value);
            if($row->meta_value < 1)
                continue;
            $evaluators[] = get_member_name($row->meta_value);
        }
        else
            $evaluators[] = $row->meta_value;//guest
    }

    printf('<form method="post" adtion="%s">',add_query_arg('voting',1,get_permalink()));    
    printf('<h2>%s</h2>',__('Vote for Evaluator','rsvpmaker-for-toastmasters'));
    foreach($evaluators as $evaluator)
        printf('<div><input type="checkbox" name="candidates[]" value="%s" checked="checked"> %s</div>',$evaluator,$evaluator);
    for($i=0; $i < 5; $i++)
        echo '<div><input class="candidates" type="text" name="candidates[]"></div>';
    echo '<input type="hidden" name="openvotes" value="Evaluators">';
    rsvpmaker_nonce();
    echo '<button>Submit</button></form>';
    
    printf('<form method="post" adtion="%s">',add_query_arg('voting',1,get_permalink()));    
    printf('<h2>%s</h2>',__('Vote for Table Topics Speaker','rsvpmaker-for-toastmasters'));
    for($i=0; $i < 10; $i++)
        echo '<div><input class="candidates" type="text" name="candidates[]"></div>';
    echo '<input type="hidden" name="openvotes" value="Table Topics">';
    rsvpmaker_nonce();
    echo '<button>Submit</button></form>';
    }//end show evaluators setup

    printf('<form method="post" adtion="%s">',add_query_arg('voting',1,get_permalink()));
    printf('<h2>%s</h2>',__('Other Vote for Member','rsvpmaker-for-toastmasters'));
    for($i=0; $i < 10; $i++)
        echo '<div><input class="candidates" type="text" name="candidates[]"></div>';
    echo '<p>Label: <input type="text" name="openvotes" value="Other Member Vote"></p>';
    rsvpmaker_nonce();
    echo '<button>Submit</button></form>';

    printf('<form method="post" adtion="%s">',add_query_arg('voting',1,get_permalink()));    
    printf('<h2>%s</h2>',__('Other Vote','rsvpmaker-for-toastmasters'));
    echo '<div><input class="candidates" type="text" name="candidates[]" value="Yes"></div>';
    echo '<div><input class="candidates" type="text" name="candidates[]" value="No"></div>';
    for($i=0; $i < 8; $i++)
        echo '<div><input class="candidates" type="text" name="candidates[]"></div>';
    echo '<p>Label: <input type="text" name="openvotes" value="Other Procedural Vote"></p>';
    rsvpmaker_nonce();
    echo '<button>Submit</button></form>';    
    } // end vote counter controls
else {
    printf('<p>Vote counter: %s</p>',get_member_name($vote_counter));
    if(isset($_POST['my_vote'])){
        $vote = sanitize_text_field($_POST['my_vote']);
        $key = sanitize_text_field($_POST['key']);
        $identifier = sanitize_text_field($_POST['identifier']);
        $metakey = 'myvote_'.$key.'_'.$identifier;
        update_post_meta($post->ID,$metakey,$vote);
        echo '<div style="border: thin solid red; padding: 10px; background-color:#ffe">Vote recorded: '.$key.'</div>';
    }
    elseif(isset($_GET['key'])) {
        $key = sanitize_text_field($_GET['key']);
        $label = get_post_meta($post->ID,'votelabel_'.$key,true);
        printf('<h3>Voting for %s</h3>',$label);
        $check = 'voting_'.$key;
        $contestants = get_post_meta($post->ID,$check,true);
        if(is_array($contestants)) {
            printf('<form method="post" action="%s">',$actionlink);
            $indentifier = (is_user_member_of_blog()) ? $current_user->ID : $_SERVER['REMOTE_ADDR'];
            foreach($contestants as $contestant) {
                printf('<p><input type="radio" name="my_vote" value="%s" > %s</p>',$contestant,$contestant);
            }
            rsvpmaker_nonce();
            printf('<input type="hidden" name="key" value="%s">',$key);
            printf('<input type="hidden" name="identifier" value="%s">',$identifier);
            echo '<button>Submit</button></form>';        
        }
    }

    $open = get_post_meta($post->ID,'openvotes'); // get array
    if(is_array($open)) {
        printf('<h3>%s (<a href="%s">%s</a>)</h3>',__('Active contests','rsvpmaker-for-toastmasters'),$actionlink,__('Reload to see more','rsvpmaker-for-toastmasters'));
            foreach($open as $v) {
                $check = 'voting_'.$v;
                $voting_link = $actionlink.'&key='.$v;
                $metakey = 'myvote_'.$v.'_'.$identifier;
                $label = get_post_meta($post->ID,'votelabel_'.$v,true);
                if(get_post_meta($post->ID,$metakey,true))
                    printf('<p>Vote recorded for %s</a></p>',$label);
                else
                    printf('<p><a href="%s">Vote for %s</a></p>',$voting_link,$label);
            }
        }    
}

if(!$claimed) {
    if(is_user_member_of_blog()) {
        printf('<form method="post" adtion="%s"><input type="hidden" name="claim" value="1"><button>Make Yourself Vote Counter</button></form>',add_query_arg('voting',1,get_permalink()));
    }
    else {
        printf('<p><a href="%s">Login</a> to claim the vote counter role.</p>',wp_login_url(add_query_arg('voting',1,get_permalink())));
    }
}

$users = get_club_members();
foreach ( $users as $user ) {
	$userdata = get_userdata( $user->ID );
	$u[]      = $userdata->first_name . ' ' . $userdata->last_name;
}
if ( ! empty( $u ) ) {
	sort( $u );
}
?>
<script>
jQuery( document ).ready(
	function($) {
	var members = <?php echo json_encode( $u ); ?>;
	$( ".candidates" ).autocomplete({
	  source: members
	});
} );
</script>

<p style="margin-top: 30px;"><em>This tool is intended for casual voting at weekly meetings. See the Contest Dashboard to set up digital ballots for contests.</em></p>
<?php wp_footer(); ?>
</body>
</html>
