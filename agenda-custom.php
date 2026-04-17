<?php
if ( isset( $_GET['word_agenda'] ) ) {
	global $post;
	header( 'Content-Type: application/msword' );
	header( 'Content-disposition: attachment; filename=' . $post->post_name . '.doc' );
}
global $post;
$layout = wp4toastmasters_agenda_layout_check( true );//gets default or custom layout.
$layout_post = get_post( $layout );
if ( ! isset( $_GET['reset'] ) ) {
	$layout_css = get_post_meta( $layout, '_rsvptoast_agenda_css_2018-07', true );
}
if ( empty( $layout_css ) ) {
	$layout_css = wpt_default_agenda_css();
	update_post_meta( $layout, '_rsvptoast_agenda_css_2018-07', $layout_css );
}
if ( isset( $_GET['word_agenda'] ) ) {
	$layout_css .= '.dateblock {margin-bottom: -1em;}';
}
?>
<html <?php language_attributes(); ?> >
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<style>
<?php 
	echo wpt_default_agenda_css();
	$main = get_option( 'wp4toastmasters_agenda_font_main' );
	if($main) {
		printf('#agenda, #agenda p, #agenda div, #agenda li {font-size: %dpx;} ',$main);
		printf('#agenda h3 {font-size: %dpx;} #agenda h2 {font-size: %dpx;} #agenda h1 {font-size: %dpx;} ',$main+2,$main+4,$main+6 );
	}
	$side = get_option( 'wp4toastmasters_agenda_font_sidebar' );
	if($side)
		printf('#agenda-sidebar, #agenda-sidebar p, #agenda-sidebar div, #agenda-sidebar li {font-size: %dpx;} ',$side);
	echo get_option( 'wp4toastmasters_agenda_css' );
?>
@media print {
   .noPrint {display:none;}
}
fieldset {
  background-color: #eeeeee;
}

legend {
  background-color: black;
  color: white;
  padding: 5px 10px;
}
.wp-block-wp4toastmasters-rsvplist, .eachrole {
	page-break-inside: avoid;
}
</style>
</head>
<body lang=EN-US style='tab-interval:.5in' <?php if(isset($_GET['no_print'])) echo ' id="show" '; ?> >
<?php
if ( !isset($_GET['showintros']) && !isset($_GET['simple']) && !isset($_GET['word_agenda'])) {
	?>
<div class="noPrint" style="text-align:center;margin:10px;">
<fieldset>
<legend><strong><?php _e( 'Will not print', 'rsvpmaker-for-toastmasters' ); ?></strong></legend>
<p style="font-size: 15px;"><?php
 if(!get_option( 'wp4toastmasters_intros_on_agenda' ) )
	printf( '<a href="%s?showintros=show" target="_blank">%s</a> | ', get_permalink(), __( 'Show Speech Introductions on Agenda', 'rsvpmaker-for-toastmasters' ) );
?>
<a href="<?php echo get_permalink(); ?>?intros=show" target="_blank"><?php _e( 'Show Speech Introductions (New Tab)', 'rsvpmaker-for-toastmasters' ); ?></a><br />
<em><?php _e( 'Note: content shown above will not be included on the printed agenda.', 'rsvpmaker-for-toastmasters' ); ?></em></p>
</fieldset>
</div>
<?php
}
?>
<div class="Section1">
<?php
if(isset($_GET['simple'])) {
	$output = '<h2>'.wp4t_tmlayout_meeting_date()."</h2>\n".wp4t_tm_agenda_content();
}
else {
	if ( function_exists( 'do_blocks' ) ) {
		$layout_post->post_content = do_blocks( $layout_post->post_content );
	}
	$output = wpautop( convert_chars( wptexturize( do_shortcode( $layout_post->post_content ) ) ) );	
}
if ( isset( $_GET['word_agenda'] ) || isset( $_GET['word_test'] ) ) {
	$output = str_replace( '</p>', '</p><p>&nbsp;</p>', $output );
	$output = str_replace( '</div>', '</div><p>&nbsp;</p>', $output );
}
echo $output;
?>
</div>
<?php
if ( ! isset( $_GET['word_agenda'] ) && ! isset( $_GET['no_print'] ) ) {
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
