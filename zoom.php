<?php
global $post, $current_user, $wpdb;
show_admin_bar(false);
$is_timer = false;
$contest_timer = '';
function timer_display_time_stoplight ($content, $name,$speechid) {
    preg_match_all('/\d{1,3}/',$content,$matches);
        //return var_export($matches[0],true);
        $output = '';
        if(!empty($matches))
        {
        $green = array_shift($matches[0]);
        $red = array_shift($matches[0]);
    /*	if(sizeof($matches[0]) > 2)
        {
            $output = $content.'<br />';
        }
    */
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
        return sprintf('<option value="%s,%s,%s,%s,%s">%s (%s - %s)</option>',$name,$green,$yellow,$red,$speechid,$name,$green,$red);
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

if(isset($_GET['claim_timer']))
    $is_timer = true;

$widthadj = ($is_timer) ? 100 : 50;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <?php global $post; ?>
  <title>Toastmasters Online Meeting</title>

  <meta name="viewport" content="width=device-width"/>

  <link href="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo plugins_url('rsvpmaker-for-toastmasters/jitsi-timer.css?v'.time()); ?>" rel="stylesheet" />
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<style>
		#voting {background-color: #fff;}
		#colorlabel {position: absolute; left: 300px; top: 300px; font-size: 80px;font-weight:bolder;}
	</style>

<script src="<?php echo plugins_url('rsvpmaker-for-toastmasters/jitsi-timer.js?v='.time());?>"></script>
<style>
.zoom-window-wrap h1, .zoom-window-wrap h2, .zoom-window-wrap h3,
.zoom-window-wrap a.button, .zoom-window-wrap a.start-meeting-btn,
.zoom-app-notice, .zoom-links  {
display: none;
}
#viewcontrol {
    position: absolute;
    top: 5px;
    right: 5px;
    width: 200px;
}
</style>
</head>
<body>
<div id="body">
    <div>
<div id="viewcontrol">View <select id="view">
        <option value="normal">Normal</option>
        <option value="self">Self Timer</option>
        <option value="timer" <?php if($is_timer) echo ' selected="selected"' ?> >Timer</option>
</select></div>

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
$count = $data['Speaker']['count'];
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
    <option value="Speech (5-7),5:00,6:00,7:00,standard">Speech (5-7)</option>
    <option value="Table Topics,1:00,1:30,2:00,tt">Table Topics</option>
    <option value="Evaluation,2:00,2:30,3:00,eval">Evaluation</option>
    <option value="Speech (6-8),6:00,7:00,8:00,6to8">Speech (6-8)</option>
    <option value="Speech (8-10),8:00,9:00,10:00,8to10">Speech (8-10)</option>
    <option value="Speech (10-15),10:00,12:30,15:00,10to15">Speech (10-15)</option>
    <option value="Speech (15-20),15:00,17:30,20:00,15to20">Speech (15-20)</option>
    <option value="Speech (20-30),20:00,22:30,30:00,20to30">Speech (20-30)</option>
    <option value="One Minute,0:30,0:45,1:00,minute">One Minute</option>
    <option value="Test,0:05,0:10,0:15,test">Test</option>
    </select>
    <input type="hidden" id="speechid" />    
    <input type="text" placeholder="Speaker Name" id="speakername" size="30"> 
    <span class="hidecount">
          <input id="green-light" type="text" class="greenyellowred">
          <input id="yellow-light" type="text" class="greenyellowred">
          <input id="red-light" type="text" class="greenyellowred">
    </span>

    <button class="btn-primary" id="btnStart" type="button" value="Start">Start</button>
    <button class=" btn-default" id="btnReset" type="button" value="Reset">Reset</button>
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
      <button id="greennow">Green</button> 
      <button id="yellownow">Yellow</button> 
      <button id="rednow">Red</button> 
	</div>

		<div id="timelog">
        <div class="row" id="buttons" ></div>
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

if(empty($name))
    {
    printf('<h1>%s</h1><p>To join the online meeting</p><ul>',$post->post_title);
    printf('<li>Members please <a href="%s">login</a></li>',wp_login_url($_SERVER['REQUEST_URI']));
    printf('<li>Guests, please enter the email you used to RSVP</li></ul><form action="%s" method="get"><p>Email <input type="text" name="email"></p><input type="hidden" name="jitsi" value="1"><p><button>Submit</button></p></form></p>',site_url($_SERVER['REQUEST_URI']));
    }
    //prompt
else {
    $meeting_id = get_post_meta($post->ID,'zoom_meeting_id',true);
    if(empty($meeting_id))
    {
        $online = get_option('tm_online_meeting');
        $meeting_id = (empty($online['personal_meeting_id'])) ? '' : $online['personal_meeting_id'];    
    }
    if($meeting_id) {
        echo '<div id="jitsi">'.do_shortcode('[zoom_api_link meeting_id="'.$meeting_id.'" link_only="no"]').'
        <p>To start meeting as host, log in at <a href="https://zoom.us/signin" target="_blank">zoom.us/signin</a>, then refresh this page.</p></div>';    
    }
    else {
        echo '<p>Zoom meeting ID not set</p>';
    }
}
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
console.log('page bottom scripts');
var color = '';

  $( function() {
    var members = <?php echo json_encode($u); ?>;
    $( "#speakername" ).autocomplete({
      source: members
    });
  } );

 function refreshView() {
     var view = $('#view').children("option:selected").val();
     console.log('view: '+view);
     if(view == 'normal')
     {
    $('iframe').css("height", window.innerHeight - 50);
    $('iframe').css("width", window.innerWidth - 50);
    $('#jitsi').css("left", '30px');
    $('.timer-controls').hide();
    var gotvotetimer = setInterval(function(){
    checkColorChange();	
    }, 200);

     }
     else {
    $('iframe').css("height", window.innerHeight - 50);
    $('iframe').css("width", window.innerWidth - 100);
    $('.timer-controls').show();
    $('#jitsi').css("left", '100px');
        if(gotvotetimer)
           stopRefreshReceived();
     }

 } 

function checkColorChange() {
$.get( "<?php echo site_url('/wp-json/toasttimer/v1/color/'.$post->ID); ?>", function( data ) {
//console.log(data);
if(data == 'green') {
    $('body').css('background-color', '#A7DA7E');
} else if (data == 'yellow') {
    $('body').css('background-color', '#FCDC3B');
} else if (data == 'red') {
    $('body').css('background-color', '#FF4040');
}
else {
    $('body').css('background-color', '#EFEEEF');
}
});
}

function stopRefreshReceived() {
  clearInterval(gotvotetimer);
}

refreshView(); // initial load
$('#view').change(refreshView);

</script>

<?php	
}
?>
</body>
</html>