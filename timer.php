<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <?php global $post; ?>
  <title>Toastmaster Speech Timer <?php if($post->post_type != 'rsvpmaker') echo '- stand-alone version' ?></title>
  <meta description="Practice your speech with confidence. This timer can be used to practice any speech type. It was originally created for practicing Toastmaster speeches. Large font and big colors enable you to see it from a distance."

  <meta name="viewport" content="width=device-width"/>

  <link href="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
  <link href="timer.css" rel="stylesheet" />
  <link href="<?php echo plugins_url('rsvpmaker-for-toastmasters/timer.css'); ?>" rel="stylesheet" />
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!--script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script -->
<!--script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script-->
<script src="<?php echo plugins_url('rsvpmaker-for-toastmasters/timer.js?v=0.1'); ?>"></script>

</head>
<body>
<div id="body">
  <div class="content-wrapper">
    <h1 style="margin-bottom: 20px;">Time for <input type="text" placeholder="Speaker Name" id="speakername" size="30"></h1>
	  <div style="font-size: 12px; margin-bottom: 15px;"><input type="checkbox" id="playchime" > Play chime <input type="checkbox" id="showdigits"> Show digits <br /><a href="https://wp4toastmasters.com/2017/11/29/new-online-timing-lights-tool/" target="_blank">How-to use this</a></div>

    <div>
      <div class="row" id="buttons" style="font-size: large"></div>
      <br/>

      <div class="row" id="content" style="font-size: xx-large; height:20px; line-height:20px">
        <div class="col-sm-2 col-md-2 hidecount">
          <input class="form-control" id="green-light" type="text">
        </div>
        <div class="col-sm-2 col-md-2 hidecount">
          <input class="form-control" id="yellow-light" type="text">
        </div>

        <div class="col-sm-2 col-md-2 hidecount">
          <input class="form-control" id="red-light" type="text">
        </div>

        <div class="col-sm-2 col-md-2">
          <button class="btn btn-default btn-primary btn-lg" id="btnStart" type="button" value="Start">Start</button>
        </div>
        <div class="col-sm-2 col-md-2">
          <button class="btn btn-default btn-lg" id="btnReset" type="button" value="Reset">Reset</button>
        </div>
      </div>
      <br/>

		<div id="timelog" class="hidecount">
<?php
if($post->post_type == 'rsvpmaker')
{

preg_match('/role="Speaker" count="([^"])"/',$post->post_content,$matches); //  count="([^"]+)
$count = $matches[1];
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
?>
		</div>

            <div class="row" id="trafficlight" style="font-size: 28em;line-height:600px">
		  0:00
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
<input type="hidden" id="stopwatchurl" value="<?php echo plugins_url('rsvpmaker-for-toastmasters/stopwatch.png'); ?>"><input type="hidden" id="chimeurl" value="<?php echo plugins_url('rsvpmaker-for-toastmasters/timer-chime.mp3'); ?>"></script>
<div id="credit" class="hidecount">
		<p>Based on Toastmasters Timer &copy; 2013 - Guy Ellis <a href="https://github.com/guyellis/toastmaster-timer">github.com/guyellis/toastmaster-timer</a></p>
</div>

</body>
</html>
