<div <?php echo get_block_wrapper_attributes(); ?>>
<?php
if(is_user_logged_in())
{
global $post, $wpdb;
$results = $wpdb->get_results($wpdb->prepare("SELECT first,last FROM {$wpdb->prefix}rsvpmaker WHERE event=%d ORDER BY last,first", $post->ID));
if($results)
{
    echo '<h3>Registered Guests</h3>
    <ul class="rsvplist">';
    foreach($results as $r)
        echo '<li>'.esc_html($r->first.' '.$r->last).'</li>';
    echo '</ul>';
}
}
?>
</div>