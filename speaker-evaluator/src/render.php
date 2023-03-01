<?php 
global $post;
$agenda = wpt_get_agendadata($post->ID);
$backup = null;
foreach($agenda['blocksdata'] as $block) {
	if('wp4toastmasters/role' == $block['blockName'])
	{
		if('Speaker' == $block['attrs']['role']) {
			$speaker_assignments = $block['assignments'];
			if(!empty($block['attrs']['backup']))
				$backup = array_pop($speaker_assignments);	
		}
		if('Evaluator' == $block['attrs']['role'])
			$evaluator_assignments = $block['assignments'];
	}
}
if(empty($speaker_assignments) || empty($evaluator_assignments))
	return;
?>
<div <?php echo get_block_wrapper_attributes(); ?>>
<table class="speaker-evaluator-table">
<tr><td class="speakernumber" >#</td><td class="speaker-column" >Speaker</td><td class="evaluator-column" >Evaluator</td></tr>
<?php
foreach($speaker_assignments as $index => $sa) {
	$ea = $evaluator_assignments[$index];
	printf('<tr><td>%d</td><td>%s</td><td>%s</td></tr>',$index+1,$sa['name'],$ea['name']);
}
if($backup && $backup['name'])
	printf('<p>Backup Speaker: %s</p>',$backup['name']);

?>
</table>
</div>
