<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <?php global $post; ?>
  <title>Toastmaster Speech Timer <?php if($post->post_type != 'rsvpmaker') echo '- stand-alone version' ?></title>
  <meta description="Practice your speech with confidence. This timer can be used to practice any speech type. It was originally created for practicing Toastmaster speeches. Large font and big colors enable you to see it from a distance."

  <meta name="viewport" content="width=device-width"/>

  <link href="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo plugins_url('rsvpmaker-for-toastmasters/timer.css?v=0.3'); ?>" rel="stylesheet" />
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<style>
		#voting {background-color: #fff;}
		#colorlabel {position: absolute; left: 300px; top: 300px; font-size: 80px;font-weight:bolder;}
	</style>

<script src="<?php echo plugins_url('rsvpmaker-for-toastmasters/timer.js?v=2.92');?>"></script>

</head>
<body>
<div id="body">
  <div class="content-wrapper">
    <h1 style="margin-bottom: 20px;">Time for <input type="text" placeholder="Speaker Name" id="speakername" size="30"></h1>
	  <div style="font-size: 12px; margin-bottom: 15px;"><a href="#" id="popup">Color popup</a> <input type="checkbox" id="playchime" > Play chime <input type="checkbox" id="showdigits"> Show digits 
	  <a href="https://wp4toastmasters.com/knowledge-base/online-timer-tool/" target="_blank">How-to use this</a> 
	  <br />Correction 	<select id="correction">
	  <option value="0" selected="selected">0</option>
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
	  </div>
    <div>
      <div class="row" id="buttons" style="font-size: large"></div>
      <br/>

      <div class="row" id="content" style="font-size: xx-large; height:20px; line-height:20px">
        <div  class="col-sm-2 col-md-2">
          <button class="btn btn-default btn-primary btn-lg" id="btnStart" type="button" value="Start">Start</button>
        </div>
        <div class="col-sm-2 col-md-2">
          <button class="btn btn-default btn-lg" id="btnReset" type="button" value="Reset">Reset</button>
        </div>
        <!--div class="col-sm-2 col-md-2 nudge">
          <button class="btn btn-default btn-lg" id="btnNudge" type="button" value="Nudge">+5 sec</button><div id="nudged"></div>
        </div -->
        <div class="col-sm-2 col-md-2 hidecount">
          <input class="form-control" id="green-light" type="text">
        </div>
        <div class="col-sm-2 col-md-2 hidecount">
          <input class="form-control" id="yellow-light" type="text">
        </div>

        <div class="col-sm-2 col-md-2 hidecount">
          <input class="form-control" id="red-light" type="text">
        </div>
      </div>
      <br/>

		<div id="timelog">
			<div id="smallcounter"></div>
<?php
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

foreach ($order as $index => $name)
	{
	echo timer_display_time_stoplight ($dt, $name);
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
		$name = $member->first_name.' '.$member->last_name;
		}
		else $name = 'Guest'; // guest
		//print_r($member);
		$dt = get_post_meta($post->ID, '_display_time_Speaker_'.$i, true);
		if(empty($dt))
			$dt = '5 to 7';
		echo timer_display_time_stoplight ($dt, $name);
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
		$name = get_member_name($member_id);
		}
		else $name = 'Guest: '.$member_id;
		//print_r($member);
		echo timer_display_time_stoplight ('2 to 3', 'Evaluator: '.$name);
	}
}

}

function timer_display_time_stoplight ($content, $name) {
preg_match_all('/\d{1,3}/',$content,$matches);
	//return var_export($matches[0],true);
	$output = '';
	if(!empty($matches))
	{
	$green = array_shift($matches[0]);
	$red = array_shift($matches[0]);
	if(sizeof($matches[0]) > 2)
	{
		$output = $content.'<br />';
	}
	$output .= timer_get_stoplight($name,$green,$red);
	}
	return $output;
}

function timer_get_stoplight ($name, $green,$red, $yellow=NULL) {
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
	return sprintf('<p class="stoplight_block">'.$name.'<br /><span style="display: inline-block; border: thin solid #000; color: green; background-color: green; ">&#9724;</span> Green: '.$green.'<br />'.'<span style="display: inline-block; border: thin solid #000; color: yellow; background-color: yellow;">&#9724;</span> Yellow: '.$yellow.'<br />'.'<span style="display: inline-block; border: thin solid #000; color: red; background-color: red;">&#9724;</span> Red: '.$red.'</span><input class="agenda_speakers" type="hidden" value="'.$name.'" green="'.$green.'" yellow="'.$yellow.'" red="'.$red.'" /></p>');
}

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
global $current_user;
$timer_user = (int) get_post_meta($post->ID,'contest_timer',true);
$dashboard_users = get_post_meta($post->ID,'tm_contest_dashboard_users',true);
if($timer_user && ($current_user->ID != $timer_user) && !in_array($current_user->ID,$dashboard_users))
{
	printf('<p>You must <a href="%s">login</a> use the timer\'s report form.</p>',wp_login_url($_SERVER['REQUEST_URI']));
}
else {
?>
<form method="post" action="<?php echo $action; ?>" id="voting">
<h3 id="record_time">Record Time</h3>
<?php
foreach($order as $index => $contestant) {
	printf('<p>%s Time: <input type="text" name="time[]" value="0:00" id="actualtime%d" ><br /><input type="checkbox" name="disqualified[]" value="%d" id="disqualified%d" /> Disqualified</p>',$contestant,$index,$index,$index);
}
			
?>
<div id="readyline"><input type="checkbox" id="readytovote" value="1" /> Check to digitally sign this as the official time record</div>
<div id="readyprompt"></div>
			<div id="timesend" ><button >Send</button></div>
		</form>			
<?php	
}// end display of form

} // end contest output
?>
		</div>

		<div id="colorlabel" ></div>			
			<div class="row" id="trafficlight" style="font-size: 28em;line-height:600px">
		  <img src="<?php echo plugins_url('rsvpmaker-for-toastmasters/stopwatch.png'); ?>" />
      </div>
    </div>
  </div>
</div>
<?php
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
  </script>	
<?php	
}
?>	
<input type="hidden" id="stopwatchurl" value="<?php echo plugins_url('rsvpmaker-for-toastmasters/stopwatch.png'); ?>"><input type="hidden" id="chimeurl" value="<?php echo plugins_url('rsvpmaker-for-toastmasters/timer-chime.mp3'); ?>">
<div id="credit" class="hidecount">
		<p>Based on Toastmasters Timer &copy; 2013 - Guy Ellis <a href="https://github.com/guyellis/toastmaster-timer">github.com/guyellis/toastmaster-timer</a></p>
</div>
	
</body>
</html>
