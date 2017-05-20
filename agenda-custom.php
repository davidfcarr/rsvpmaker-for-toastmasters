<?php 
if(isset($_GET["word_agenda"]))
{
global $post;
header('Content-Type: application/msword');
header('Content-disposition: attachment; filename='.$post->post_name.'.doc');
}
$layout = get_option('rsvptoast_agenda_layout');
$layout_post = get_post($layout);
$layout_css = get_post_meta($layout,'_rsvptoast_agenda_css',true);
?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Windows-1252">
<title><?php wp_title( '|', true, 'right' ); ?></title>
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
<?php echo $layout_css ."\n". get_option('wp4toastmasters_agenda_css'); ?>
</style>
</head>

<body lang=EN-US style='tab-interval:.5in'>
<div class="Section1">
<?php
echo wpautop(convert_chars(wptexturize(do_shortcode($layout_post->post_content))));
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