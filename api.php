<?php

class Toast_Norole_Controller extends WP_REST_Controller {
  public function register_routes() {
    $namespace = 'rsvptm/v1';
    $path = 'norole/(?P<post_id>[0-9]+)';

    register_rest_route( $namespace, '/' . $path, [
      array(
        'methods'             => 'GET',
        'callback'            => array( $this, 'get_items' ),
        'permission_callback' => array( $this, 'get_items_permissions_check' )
            ),
        ]);     
    }

  public function get_items_permissions_check($request) {
    return true;
  }

public function get_items($request) {
    global $wpdb;
    $hasrole = array();
    $norole = array();
    $post_id = $request['post_id'];
    $date = get_rsvp_date($post_id);
    $absences = get_absences_array($post_id);
    $sql = "SELECT * FROM `$wpdb->postmeta` where post_id=".$post_id." AND meta_value REGEXP '^[0-9]+$' AND BINARY meta_key RLIKE '^_[A-Z].+[0-9]$' ";
    $results = $wpdb->get_results($sql);
    foreach ($results as $row)
        $hasrole[] = $row->meta_value;
    $users = get_users('blog_id='.get_current_blog_id());
    foreach($users as $user)
        {
            if(!in_array($user->ID,$hasrole) && !in_array($user->ID,$absences))
                {
                $userdata = get_userdata($user->ID);
                $norole[] = $userdata->first_name .' '. $userdata->last_name;
                }
        }
    sort($norole);
    return new WP_REST_Response($norole, 200);
  }
}

class WPTContest_Order_Controller extends WP_REST_Controller {
	public function register_routes() {
	  $namespace = 'wptcontest/v1';
	  $path = 'order/(?P<post_id>[0-9]+)';///(?P<nonce>.+)
  
	  register_rest_route( $namespace, '/' . $path, [
		array(
		  'methods'             => 'GET',
		  'callback'            => array( $this, 'get_items' ),
		  'permission_callback' => array( $this, 'get_items_permissions_check' )
			  ),
		  ]);     
	  }
  
	public function get_items_permissions_check($request) {
	  return true;
	}
  
  public function get_items($request) {
	  global $wpdb;
	  $order = get_post_meta($request['post_id'],'tm_scoring_order',true);
	  return new WP_REST_Response($order, 200);
	}
}

class WPTContest_VoteCheck extends WP_REST_Controller {
	public function register_routes() {
	  $namespace = 'wptcontest/v1';
	  $path = 'votecheck/(?P<post_id>[0-9]+)';///(?P<nonce>.+)
  
	  register_rest_route( $namespace, '/' . $path, [
		array(
		  'methods'             => 'GET',
		  'callback'            => array( $this, 'get_items' ),
		  'permission_callback' => array( $this, 'get_items_permissions_check' )
			  ),
		  ]);     
	  }
  
	public function get_items_permissions_check($request) {
	  return true;
	}
  
  public function get_items($request) {
	  global $wpdb;
	  $votes = toast_scores_check($request['post_id']);
	  return new WP_REST_Response($votes, 200);
	}
}

add_action('rest_api_init', function () {
     $toastnorole = new Toast_Norole_Controller();
     $toastnorole->register_routes();
     $order_controller = new WPTContest_Order_Controller();
     $order_controller->register_routes();
     $votecheck_controller = new WPTContest_VoteCheck();
     $votecheck_controller->register_routes();
   } );
?>