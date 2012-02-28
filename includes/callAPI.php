<?php
/**
 * Used to handle AJAX calls to API from front-end
 * Expects $_POST['action'] to contain endpoint
 * Expects query parameters to be set in $_POST
 * Authorisation is handled as such:
 * - $_SESSION['user'] must be set
 * - Admin can execute all API calls
 * - User can only POST on 'card', 'cardtags' and 'tag'
 * - User can only PUT|DELETE on object of which it is the owner
 * Response from API is echoed as JSON string if possible
 * Error echoes a plain String descriptive message
 */
require_once ('../config.php');
require_once ('functions.php');
$options = array();
$action = "";
if ($_REQUEST) {
    foreach ($_REQUEST as $key => $value) {
        if ($key == 'controller' || $key == 'action') {
            $$key = $value;
        } else {   
            $options[$key]=$value;
        }
    }
}

$request_url = $action;

//if POST|PUT|DELETE, must check privileges
if(preg_match("/post|put|delete\/*/i",$action)) {
	
	if(!is('user')) {
    //must be logged in for POST|PUT|DELETE
        echo "Not logged in; can't POST|PUT|DELETE";
        die;
	}

	if(!is('super')) {

		//get method
	    $matches = array();
	    preg_match_all("/(post|put|delete)/i",$action,$matches);
	    if(isset($matches[1])) { $method = $matches[1]; }
	    
	    //get resource
	    $resource = substr($action, 0, strpos($action, "/"));
	    
	    if(is('admin')) {
	    	//restrict PUT|DELETE to own
	    	if(preg_match("/put|delete/i",$action)) {
	    	    $object = callAPI($resource,array("id"=>$options['id']),'obj');
                if(!is('owner',$object)) {
                    echo "That's not yours. Must be Super Admin to do that";
                    die;
                }
	    	}
	    } else { //user
	    	//restrict POST to card, tag, cardtag and vote
	    	if(preg_match("/post/i",$action)) {
                $allowed = array("card","tag","cardtags","vote");
		    	//get resource
	            if(!in_array($resource,$allowed)) {
	                echo "Must be Admin to do that";
	                die;
	            }
	    	}
	    	//restrict PUT to card and own
	        if(preg_match("/put/i",$action)) {
	        	$allowed = array("card","user");
                $object = callAPI($resource,array("id"=>$options['id']),'obj');
                if(!in_array($resource,$allowed) || !is('owner',$object)) {
                    echo "That's not yours. Must be Super Admin to do that";
                    die;
                }
            }
            //restrict DELETE to cardtag and own
	        if(preg_match("/delete/i",$action)) {
                $allowed = array("cardtags");
                $object = callAPI($resource,array("id"=>$options['id']),'obj');
                if(!in_array($resource,$allowed) || !is('owner',$object)) {
                    echo "That's not yours. Must be Super Admin to do that";
                    die;
                }
            }
	    }
	}
}

//get object from API
$response = callAPI($request_url, $options, 'obj');

if($response && is_object($response) || is_array($response)) {
//a JSON object, echo JSON string
	echo json_encode($response);
} else {
//probably an error string, just echo it
	echo $response;
}

?>