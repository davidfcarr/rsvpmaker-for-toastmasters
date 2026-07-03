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
<title>Agenda: <?php wp_title( '|', true, 'right' ); ?></title>
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
dialog {
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  text-align: center;
}

/* Dims the rest of the webpage while the modal is open */
dialog::backdrop {
  background-color: rgba(0, 0, 0, 0.5);
}

.dialog-actions {
  margin-top: 20px;
  display: flex;
  justify-content: center;
  gap: 15px;
}

#related-page-link {
  display: inline-block;
  background-color: #007bff;
  color: white;
  padding: 8px 16px;
  text-decoration: none;
  border-radius: 4px;
}

#close-dialog-btn {
  background-color: #f8f9fa;
  border: 1px solid #ccc;
  padding: 8px 16px;
  border-radius: 4px;
  cursor: pointer;
}
</style>
</head>
<body lang=EN-US style='tab-interval:.5in' <?php if(isset($_GET['no_print'])) echo ' id="show" '; ?> >
<?php
if(isset($_GET['show_voting_qr'])) {
	echo rsvpmaker_qr([
		'url' => get_permalink().'?meetingvote=1',
		'pixel' => 20,
	]);
}
$intros_link = get_permalink().'?intros=show';
if ( !isset($_GET['showintros']) && !isset($_GET['simple']) && !isset($_GET['word_agenda'])) {
	?>
<div class="noPrint" style="text-align:center;margin:10px;">
<fieldset>
<legend><strong><?php _e( 'Will not print', 'rsvpmaker-for-toastmasters' ); ?></strong></legend>
<p style="font-size: 15px;"><?php
 if(!get_option( 'wp4toastmasters_intros_on_agenda' ) )
	printf( '<a href="%s?print_agenda=1&no_print=1&showintros=show">%s</a> | ', get_permalink(), __( 'Show Speech Introductions on Agenda', 'rsvpmaker-for-toastmasters' ) );
?>
<a href="<?php echo $intros_link; ?>" target="_blank"><?php _e( 'Show Speech Introductions (New Tab)', 'rsvpmaker-for-toastmasters' ); ?></a><br />
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
if ( !isset($_GET['showintros']) && !isset($_GET['simple']) && !isset($_GET['word_agenda'])) {
?>
<dialog id="print-suggestion-dialog">
  <h3>Related Document Available</h3>
  <p>Would you also like to view or print the Speech Introductions?</p>
  
  <div class="dialog-actions">
    <a id="related-page-link" href="<?php echo $intros_link; ?>" rel="noopener">
      Speech Introductions
    </a>
    <button id="close-dialog-btn" type="button">No Thanks</button>
  </div>
</dialog>
<script type="text/javascript">
window.addEventListener('afterprint', (event) => {
  // This runs AFTER the print dialog closes (whether they clicked Print or Cancel)
  console.log('afterprint event detected');
  showRelatedPagePrompt();
});

function showRelatedPagePrompt() {
console.log('Showing related page prompt');
const printDialog = document.getElementById('print-suggestion-dialog');
const closeBtn = document.getElementById('close-dialog-btn');
const relatedLink = document.getElementById('related-page-link');

printDialog.showModal(); 

// 2. Close the dialog if they click "Maybe Later"
closeBtn.addEventListener('click', () => {
  printDialog.close();
});

// 3. Optional: Close the dialog if they click the link
relatedLink.addEventListener('click', () => {
  printDialog.close();
});
}
</script>
<?php
}
?>
</body>
</html>
