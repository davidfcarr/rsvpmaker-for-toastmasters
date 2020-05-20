<?php
global $post, $current_user, $wpdb;
show_admin_bar(false);
$is_timer = false;
$contest_timer = '';
function timer_display_time_stoplight ($content, $name,$speechid) {
    preg_match_all('/\d{1,3}/',$content,$matches);
        $output = '';
        if(!empty($matches))
        {
        $green = array_shift($matches[0]);
        $red = array_shift($matches[0]);
        $output .= timer_get_stoplight_options($name,$green,$red,$speechid);
        }
        return $output;
    }
    
function timer_get_stoplight_options ($name, $green,$red, $speechid='') {
        if(empty($yellow))
        {
            $diff = $red - $green;
            $plus_minutes = ($diff - $diff % 2) / 2;
            $yellow = $green + $plus_minutes;
            if($diff % 2)
            {
                if(($green > 5) && ($diff > 2)) // go to next minute 
                {
                    $yellow++;
                }
                else
                    $yellow = $yellow .= ':30';
            }
            else
                $yellow = $yellow .= ':00';
    
        }
        $red = $red .= ':00';
        $green = $green .= ':00';
        return sprintf('<option value="%s|%s|%s|%s|%s">%s (%s - %s)</option>',$name,$green,$yellow,$red,$speechid,$name,$green,$red);
    }

if(is_user_logged_in()) {
    $sql = "SELECT * FROM `$wpdb->postmeta` where post_id=".$post->ID."  AND meta_value=".$current_user->ID." AND BINARY meta_key RLIKE '^_[A-Z].+[0-9]$' ";
    $role_row = $wpdb->get_row($sql);
    if($role_row)
        {
        $role = trim(preg_replace('/[^A-Za-z]/',' ',$role_row->meta_key));
        }
    else
        $role = '';
    $name = $role.' '.$current_user->display_name;
    $email = $current_user->user_email;
    $is_timer = (($role == 'Timer') && !isset($_GET['exit_timer']) );
}
elseif(isset($_GET['email']) && is_email($_GET['email']))
    {
        $email = $_GET['email'];
        $sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix.'rsvpmaker WHERE email LIKE %s AND event=%d',$email,$post->ID);
        $row = $wpdb->get_row($sql);
        if($row)
        {
            $name = 'Guest:'.$row->first.' '.$row->last;
        }
    }
if(isset($_GET['demo'])) {
    if(current_user_can('manage_options'))
        {
            update_post_meta($post->ID,'jitsi_demo',true);
            $name = 'Testy Tester';
            $email = 'testy@example.com';
        }
    elseif(get_post_meta($post->ID,'jitsi_demo',true)){
        $name = 'Testy Tester';
        $email = 'testy@example.com';
    }
}
if($post->post_type != 'rsvpmaker')
{
    //test configuration, not associated with an event or club
    $name = 'Testy Tester';
    $email = 'testy@example.com';
    //if last used more than 2 hours ago
    $colorts = (int) get_post_meta($post->ID,'timing_timestamp',true);
    if($colorts < strtotime('-2 hours'))
        update_post_meta($post->ID,'timing_light_color','default');
    update_post_meta($post->ID,'timing_timestamp',time());
}

if(isset($_GET['claim_timer']))
    $is_timer = true;

$widthadj = ($is_timer) ? 100 : 50;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <?php global $post; ?>
  <title>Timer: Toastmasters Online Meeting</title>

  <meta name="viewport" content="width=device-width"/>

  <link href="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo plugins_url('rsvpmaker-for-toastmasters/jitsi-timer.css?v='.time()); ?>" rel="stylesheet" />
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<style>
		#voting {background-color: #fff;}
		#colorlabel {position: absolute; left: 300px; top: 300px; font-size: 80px;font-weight:bolder;}
	</style>

<script src="<?php echo plugins_url('rsvpmaker-for-toastmasters/jitsi-timer.js?v='.time());?>"></script>
<style>
<?php 
if(isset($_GET['embed']) && ($_GET['embed'] == 'zoom'))
{
?>
.zoom-window-wrap h1, .zoom-window-wrap h2, .zoom-window-wrap h3,
.zoom-window-wrap a.button, .zoom-window-wrap a.start-meeting-btn,
.zoom-app-notice, .zoom-links  {
display: none;
}
<?php    
}
?>

#viewcontrol {
    float: right;
    max-width: 250px;
}

@media only screen and (max-width: 400px) {
  #viewcontrol {
    display: none;
  }
  #jitsi {
      display: none;
      width: 5px;
  }
}

</style>
<?php 
if(isset($_GET['embed']) && ($_GET['embed'] == 'jitsi'))
{
?>
<script src='https://meet.jit.si/external_api.js'></script>
<?php
}
?>
</head>
<body>
<div id="body">
    <div>
<div id="viewcontrol">View <select id="view">
        <option value="normal">Normal</option>
        <option value="self">Self Timer</option>
        <option value="timer" <?php if($is_timer) echo ' selected="selected"' ?> >Timer</option>
</select><button id="popup">Popup Light</button> <!--button id="timerpopup">Timer</button--></div>

<p id="explanation">The background of this page (and the Popup Timer window) act as timing lights.</p>

		<div id="timelog">
        <div class="timer-controls">
<?php
$options = '';

if(isset($_GET['contest']))	{

$dt = get_post_meta($post->ID,'toast_timing',true);
if(empty($dt))
	$dt = '5 to 7';
	
$contestants = get_post_meta($post->ID,'tm_scoring_contestants',true);
if(empty($contestants))
	echo 'Contestants list not set';
else
{
$order = get_post_meta($post->ID,'tm_scoring_order',true);
if(empty($order))
	$order = $contestants;

foreach ($order as $index => $speakername)
	{
	$options .= timer_display_time_stoplight ($dt, $speakername, $index);
	}
}

}				
elseif($post->post_type == 'rsvpmaker')
{
$count = 0;
if(strpos($post->post_content,'wp:wp4toastmasters'))
{
$data = wpt_blocks_to_data($post->post_content);
$count = (isset($data['Speaker']['count'])) ? $data['Speaker']['count'] : 0;
}
else {
preg_match('/role="Speaker" count="([^"])"/',$post->post_content,$matches); //  count="([^"]+)
$count = $matches[1];
}

for($i = 1; $i <= $count; $i++) {
	//echo 'Lookup '.'_Speaker_'.$i;
	$member_id = get_post_meta($post->ID,'_Speaker_'.$i,true);
	//echo ' id '.$member_id;
	if($member_id)
	{
		if(is_numeric($member_id))
		{
		$member = get_userdata($member_id);
		$speakername = $member->first_name.' '.$member->last_name;
		}
		else $name = 'Guest'; // guest
		//print_r($member);
		$dt = get_post_meta($post->ID, '_display_time_Speaker_'.$i, true);
		if(empty($dt))
			$dt = '5 to 7';
		$options .= timer_display_time_stoplight ($dt, $speakername, $i);
	}
}

for($i = 1; $i <= $count; $i++) {
	//echo 'Lookup '.'_Speaker_'.$i;
	$member_id = get_post_meta($post->ID,'_Evaluator_'.$i,true);
	//echo ' id '.$member_id;
	if($member_id)
	{
		if(is_numeric($member_id))
		{
            $speakername = get_member_name($member_id);
		}
		else $name = 'Guest: '.$member_id;
		//print_r($member);
		$options .= timer_display_time_stoplight ('2 to 3', 'Evaluator: '.$speakername,$i);
	}
}

}
?>
    <select id="dropdowntime">
    <option value="">Speech Type</option>
    <?php echo $options; ?>
    <option value="Speech (5-7)|5:00|6:00|7:00|standard">Speech (5-7)</option>
    <option value="Table Topics|1:00|1:30|2:00|tt">Table Topics</option>
    <option value="Evaluation|2:00|2:30|3:00|eval">Evaluation</option>
    <option value="Speech (3-4)|3:00|3:30|4:00|6to8">Speech (3-4)</option>
    <option value="Speech (6-8)|6:00|7:00|8:00|6to8">Speech (6-8)</option>
    <option value="Speech (8-10)|8:00|9:00|10:00|8to10">Speech (8-10)</option>
    <option value="Speech (10-15)|10:00|12:30|15:00|10to15">Speech (10-15)</option>
    <option value="Speech (15-20)|15:00|17:30|20:00|15to20">Speech (15-20)</option>
    <option value="Speech (20-30)|20:00|22:30|30:00|20to30">Speech (20-30)</option>
    <option value="One Minute|0:30|0:45|1:00|minute">One Minute</option>
    <option value="Test|0:05|0:10|0:15|test">Test</option>
    </select>
    <input type="hidden" id="speechid" />    
    <input type="text" placeholder="Speaker Name" id="speakername" size="30"> 
    <span class="hidecount">
          <input id="green-light" type="text" class="greenyellowred">
          <input id="yellow-light" type="text" class="greenyellowred">
          <input id="red-light" type="text" class="greenyellowred">
    </span>

    <button class="btn-primary btnStart" id="btnStart" type="button" value="Start">Start</button>
    <button class=" btn-default btnReset" id="btnReset" type="button" value="Reset">Reset</button>
	<select id="correction">
	  <option value="0" selected="selected">Correction (0)</option>
	  <?php 
	for($min = 0; $min < 11; $min++)
		for($seconds = 0; $seconds < 60; $seconds += 5)
		{
			if(($min == 0) && ($seconds == 0))
			continue;
			printf('<option value="%s">+ %s:%s%s</option>',$seconds+($min*60),$min,($seconds<10)? '0':'',$seconds);
		}
	  ?>
	  </select>
      <button id="greennow" class="colorbuttons">Green</button>
      <button id="yellownow" class="colorbuttons">Yellow</button>
      <button id="rednow" class="colorbuttons">Red</button>
	</div>

			<div id="smallcounter"></div>
<?php

if(isset($_REQUEST['contest']))
{
$timer_code = get_post_meta($post->ID,'tm_timer_code',true);
if($timer_code != $_REQUEST['contest'])
	wp_die('incorrect code');
if(isset($_POST['time']))
	{
	$disqualified = (isset($_POST['disqualified'])) ? $_POST['disqualified'] : array();
	$timereport = '';
	foreach($_POST['time'] as $index => $value)
	{
		$timereport .= $order[$index] .': '.$value;
		if(in_array($index,$disqualified))
			$timereport .= ' (disqualified)';
		$timereport .= '<br />';
	}
	if(!empty($timereport))
	{
		update_post_meta($post->ID,'_time_report',$timereport);
		printf('<h2>Recorded</h2><p>%s</p>',$timereport);
	}
	if(!empty($disqualified))
	{
		update_post_meta($post->ID,'_time_disqualified',$disqualified);
	}
	
	}
$action = add_query_arg( array(
    'timer' => '1',
    'contest' => $timer_code,
), get_permalink($post->ID) );
$timer_user = (int) get_post_meta($post->ID,'contest_timer',true);
$dashboard_users = get_post_meta($post->ID,'tm_contest_dashboard_users',true);
if($timer_user && ($current_user->ID != $timer_user) && !in_array($current_user->ID,$dashboard_users))
{
	printf('<p>You must <a href="%s">login</a> use the timer\'s report form.</p>',wp_login_url($_SERVER['REQUEST_URI']));
}
else {
ob_start();
?>
<form method="post" action="<?php echo $action; ?>" id="voting">
<p><strong>Record Time</strong></p>
<?php
foreach($order as $index => $contestant) {
	printf('<p>%s <br /><input type="text" class="timefield" name="time[]" value="0:00" id="actualtime%d" ><br /><input type="checkbox" name="disqualified[]" value="%d" id="disqualified%d" /> Disqualified</p>',$contestant,$index,$index,$index);
}
		
?>
<div id="readyline"><input type="checkbox" id="readytovote" value="1" /> Check to digitally sign this as the official time record</div>
<div id="readyprompt"></div>
			<div id="timesend" ><button >Send</button></div>
		</form>			
<?php
$contest_timer = ob_get_clean();
}// end display of form

} // end contest output
echo $contest_timer;
?>
</div><!-- end timer controls -->
		</div>

    </div>
  </div>
  <input type="hidden" id="seturl" value="<?php echo site_url('/wp-json/toasttimer/v1/color/'.$post->ID); ?>" />
</div>
<?php
if(!empty($_GET['embed']) && empty($name))
    {
    printf('<h1>%s</h1><p>To join the online meeting</p><ul>',$post->post_title);
    printf('<li>Members please <a href="%s">login</a></li>',wp_login_url($_SERVER['REQUEST_URI']));
    printf('<li>Guests, please enter the email you used to RSVP</li></ul><form action="%s" method="get"><p>Email <input type="text" name="email"></p><input type="hidden" name="jitsi" value="1"><p><button>Submit</button></p></form></p>',site_url($_SERVER['REQUEST_URI']));
    }
elseif(empty($_GET['embed']))
    {
        ?>
<div id="jitsi" style="background-color: #fff;">
<div style="width: 100px; float: right;"><button id="hideit">Hide Instructions</button></div>
<h2>Normal / Speaker View of Timer Light Disabled</h2>
<p><em>A redesigned version is under development. Our original design caused problems with the hosting service that serves toastmost.org and wp4toastmasters.com.</em></p>
<hr />
<p>This screen displays in 3 views: Normal (speaker view), Self Timer, and Timer (the person showing timing lights to others). In Timer view, the green, yellow, and red colors are broadcast to everyone watching the Normal view (with a delay of about 1 second).</p>
<p>If you are listed on the agenda as Timer, the screen will open in Timer mode. Or you can use the dropdown list in the upper right hand corner to claim that role.</p>
<p>How to set this up as a speaker:</p>
<ul><li>In Normal view, click the Popup Light button in the upper right hand corner of the screen to get a small popup window that will change colors.</li><li>You can now minimize the bigger browser window and leave the timing light window parked in a corner of your screen.</li><li>In Zoom, exit full screen and size the Zoom window so you can still see the timing light.</li><li>For screen sharing, share individual applications rather than your whole desktop.</li></ul>
<figure class="wp-block-image size-large"><img src="https://i2.wp.com/wp4toastmasters.com/wp-content/uploads/2020/05/timer-zoom-screensharing.jpg?fit=614%2C345&amp;ssl=1" alt="" class="wp-image-1138251"/></figure>
<br />
<p>Below: Use Reading Mode in PowerPoint to show slides without taking up the whole screen. Size the PowerPoint window so you can still see the timing light.</p>
<figure class="wp-block-image size-large"><img src="https://wp4toastmasters.com/wp-content/uploads/2020/05/powerpoint-reading.png" alt="" class="wp-image-1138253"/></figure>
</div>
        <?php
    }
elseif(($_GET['embed'] == 'zoom') && empty($_GET['zoom_login_confirmed']))
    printf('<h1>Confirm Your Zoom Login</h1><p>To use the web-based version of Zoom, you must first <a href="https://zoom.us/signin" target="_blank">login at zoom.us</a></p><p><a href="%s">Refresh this page</a> when you have confirmed you are logged into Zoom.</p>',get_permalink().'?timer=1&embed=zoom&zoom_login_confirmed=1');
elseif($_GET['embed'] == 'zoom')
    {
        $meeting_id = get_post_meta($post->ID,'zoom_meeting_id',true);
        if(empty($meeting_id))
        {
            $online = get_option('tm_online_meeting');
            $meeting_id = (empty($online['personal_meeting_id'])) ? '' : $online['personal_meeting_id'];    
        }
        if($meeting_id) {
            $meeting_id = preg_replace('/[^0-9]/','',$meeting_id); // remove any dashes
            echo '<div id="jitsi">'.do_shortcode('[zoom_api_link meeting_id="'.$meeting_id.'" link_only="no"]').'
            <p>To start meeting as host, log in at <a href="https://zoom.us/signin" target="_blank">zoom.us/signin</a>, then refresh this page.</p></div>';    
        }
        else {
            echo '<p>Zoom meeting ID not set</p>';
        }    
    }
else 
    echo '<div id="jitsi"></div>';

$users = get_users();
foreach($users as $user)
{
	$userdata = get_userdata($user->ID);
	$u[] = $userdata->first_name.' '.$userdata->last_name;
}
if(!empty($u))
sort($u);
{
?>
<script>
  $( function() {
    var members = <?php echo json_encode($u); ?>;
    $( "#speakername" ).autocomplete({
      source: members
    });
  } );
<?php 
if(isset($_GET['embed']) && ($_GET['embed'] == 'jitsi'))
{
?>
const domain = 'meet.jit.si';
const options = {
    roomName: '<?php 
    $room_name = get_post_meta($post->ID,'jitsi_room_name',true);
    if(empty($room_name))
    {
        $room_name = $post->post_title.' '.rand();
        update_post_meta($post->ID,'jitsi_room_name',$room_name);
    }    
    echo $room_name; ?>',
    width: window.innerWidth - <?php echo $widthadj;?>,
    height: window.innerHeight - 50,
    parentNode: document.querySelector('#jitsi')
};
const api = new JitsiMeetExternalAPI(domain, options);
api.executeCommand('displayName', '<?php echo $name;?>');
api.executeCommand('email', '<?php echo $email;?>');
<?php
}//end jitsi only
?>

</script>

<?php	
}
?>
</body>
</html>