<?php

add_action( 'admin_init', 'wptm_register_member_listing' );

function wptm_register_member_listing_markup() {
	return "<!-- wp:group {\"style\":{\"border\":{\"width\":\"5px\",\"color\":\"#004165\",\"radius\":{\"topLeft\":\"15px\",\"topRight\":\"15px\",\"bottomLeft\":\"15px\",\"bottomRight\":\"15px\"}},\"spacing\":{\"padding\":{\"right\":\"var:preset|spacing|10\",\"left\":\"var:preset|spacing|10\"}}},\"layout\":{\"type\":\"constrained\"}} -->

<div class=\"wp-block-group has-border-color\" style=\"border-color:#004165;border-width:5px;border-top-left-radius:15px;border-top-right-radius:15px;border-bottom-left-radius:15px;border-bottom-right-radius:15px;padding-right:var(--wp--preset--spacing--10);padding-left:var(--wp--preset--spacing--10)\"><!-- wp:heading {\"style\":{\"elements\":{\"link\":{\"color\":{\"text\":\"var:preset|color|loyalblue\"}}}},\"textColor\":\"loyalblue\"} -->

<h2 class=\"wp-block-heading has-loyalblue-color has-text-color has-link-color\">Leadership</h2>

<!-- /wp:heading -->

<!-- wp:wp4toastmasters/memberprofile {\"identifier\":\"officerslist\",\"pictureShape\":\"rounded\",\"showEdAwards\":true,\"centerHeading\":true} /-->
</div>
<!-- /wp:group -->

<!-- wp:heading {\"style\":{\"elements\":{\"link\":{\"color\":{\"text\":\"var:preset|color|loyalblue\"}}}},\"textColor\":\"loyalblue\"} -->

<h2 class=\"wp-block-heading has-loyalblue-color has-text-color has-link-color\">Members</h2>

<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Logged in members will see the full list (except for members who have opted out of the private member directory). Nonmembers will see a list of members who have chosen to make their profiles public. By default, only logged in members will see contact details like email and phone number.</p>
<!-- /wp:paragraph -->

<!-- wp:wp4toastmasters/memberprofile {\"identifier\":\"nonofficers\",\"pictureShape\":\"rounded\",\"showEdAwards\":true,\"centerHeading\":true} /-->";
}

function wptm_register_member_listing() {

register_block_pattern_category(

    'toastmasters',

    array( 'label' => __( 'Toastmasters', 'rsvpmaker-for-toastmasters' ) )

);

register_block_pattern(

		'rsvpmaker-for-toastmasters/member-profile',

		[

			'title'       => __( 'Toastmasters Officer and Member Profile Listing', 'rsvpmaker-for-toastmasters' ),

			'categories'    => ['toastmasters'],

			'description' => __( 'Displays member profile blocks for each of the standard officer roles, followed by a listing of the profiles of members who have chosen to make their profiles public.', 'rsvpmaker-for-toastmasters' ),

			'content'     => wptm_register_member_listing_markup(),
		]

	);
/*
$slug = 'toastmasters-club-boilerplate';
register_block_pattern(
		'rsvpmaker-for-toastmasters/'.$slug,

		[

			'title'       => __( 'Toastmasters Club Boilerplate', 'rsvpmaker-for-toastmasters' ),

			'categories'    => ['toastmasters'],

			'description' => __( 'Standard Toastmasters International-approved copy for explaining the purpose of a Toastmasters club', 'rsvpmaker-for-toastmasters' ),

			'content'     => '',
		]

	);
*/
}
