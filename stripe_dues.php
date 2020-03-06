<?php
function stripe_dues_report () {
	echo '<h1>Stripe Charges</h1>';
	
	if(isset($_GET['history'])) {
		stripe_balance_history();
	}

	global $wpdb;
	$sql = "SELECT * FROM $wpdb->postmeta WHERE meta_key='rsvpmaker_stripe_payment' ORDER BY meta_id DESC";
	$results = $wpdb->get_results($sql);
	if(is_array($results))
	foreach($results as $row) {
		echo '<p>';
		$payment = unserialize($row->meta_value);
		foreach($payment as $index => $value)
			printf('<div>%s: %s</div>',$index,$value);
		echo '</p>';
	}
}
