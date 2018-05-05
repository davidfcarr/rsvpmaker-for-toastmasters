<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<title>Scoring <?php if($_GET['scoring'] == 'dashboard') echo 'Dashboard';?> - <?php global $post; echo $post->post_title; ?></title>

<?php
	wp_head(); 
?>
<style>
input,select {max-width: 45%}
#scorebody { margin: 10px; background-color: #fff; padding: 15px;}
	input.setscore {width: 50px;}
</style>
</head>
<body>
<div id="scorebody">

<?php
if(isset($_REQUEST['scoring']))
{
	echo toast_contest($_REQUEST['scoring']);
}
?>
</div>
</body>
</html>