<?php 
if(isset($_GET["word_agenda"]))
{
global $post;
header('Content-Type: application/msword');
header('Content-disposition: attachment; filename='.$post->post_name.'.doc');
}
wp4toastmasters_agenda_layout_check('custom'); //add layout post if doesn't already exist
$layout = get_option('rsvptoast_agenda_layout');
$layout_post = get_post($layout);
if(!isset($_GET['reset']))
$layout_css = get_post_meta($layout,'_rsvptoast_agenda_css_2018-07',true);
if(empty ($layout_css))
{
$layout_css = wpt_default_agenda_css();
update_post_meta($layout,'_rsvptoast_agenda_css_2018-07',$layout_css);
}
if(isset($_GET['word_agenda']))
	echo '.dateblock {margin-bottom: -1em;}';

?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Windows-1252">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<!-- Custom Agenda Template -->
<!--[if gte mso 9]>
<xml>
<w:WordDocument>
<w:View>Print</w:View>
<w:Zoom>90</w:Zoom>
<w:DoNotOptimizeForBrowser/>
</w:WordDocument>
</xml>
<![endif]-->
<style>
<!-- /* Style Definitions */
<?php echo wpt_default_agenda_css(); ?>
<?php echo get_option('wp4toastmasters_agenda_css'); ?>
</style>
</head>

<body lang=EN-US style='tab-interval:.5in'>
<div class="Section1">
<?php
if(function_exists('do_blocks'))
	$layout_post->post_content = do_blocks($layout_post->post_content);
$output = wpautop(convert_chars(wptexturize(do_shortcode($layout_post->post_content))));
if(isset($_GET['word_agenda']) || isset($_GET['word_test']))
{
	$output = str_replace('</p>','</p><p>&nbsp;</p>',$output);
	$output = str_replace('</div>','</div><p>&nbsp;</p>',$output);
}

echo $output;
?>
</div>
<?php
if(!isset($_GET["word_agenda"]) && !isset($_GET["no_print"]))
{
echo '<script type="text/javascript">
<!--
window.print();
//-->
</script>
';
}
?>
</body>
</html>