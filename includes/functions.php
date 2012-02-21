<?php
/**
 * Used to set up variables and objects in $_SESSION along with some global
 * variabless
 * @param $data Associative array of variable name => value of variables to be
 *              generated locally
 */
function setup($data=array()) {
    //generate read-only varaibles passed via $data assoc array in local scope
	parse_str(http_build_query($data));
	//set up global variable references
	global $steep;
    global $steep_cols;
    global $event;
    global $admin_pages;
	
    //define steep category names
	$steep = array (1=>"social", 2=>"technological", 3=>"economic", 4=>"environmental", 5=>"political");
	$steep_cols = array (1=>"39B1D9", 2=>"A681B2", 3=>"F69220", 4=>"8BC53F", 5=>"EC2027");
	
	//set admin pages
	$admin_pages = array('decks','deck','events','event','issues','issue');
	
	//OAuth
    $_SESSION['oauth'] = new OAuth(PRIVATE_KEY, SECRET, OAUTH_SIG_METHOD_HMACSHA1);
}

/**
 * Checks $_SESSION to see if user is logged in. Forces login if not
 */
function login($data=null) {
    if(empty($_SESSION['user']) || !$_SESSION['user']->id) {
        view('login', $data);
        die;
    }
}


/**
 * Intended for use with is() function. Takes boolean expression, and parameters
 * for show_error() function to be displayed if boolean expression is false.
 * @param bool $allowed     Whether to allow flow to continue, or show error
 * @param array $error_params   Array containing params for show_error()
 */
function allow($allowed,$error_params=array('Sorry,','You must be an admin to do that..','403')) {
	if(!$allowed) {
		show_error($error_params[0],$error_params[1],$error_params[2]);
		require_once(VIEW_PATH.'partials/footer.php');
		die;
	}
	//if it gets here, action is allowed and program flow is continued
}

/**
 * Used to check on user role or ownership of objects. Uses $_SESSION['user_id']
 * and $_SESSION['user_role'] variables. Handy for Authorisation checks. 
 * @param string $role      [superadmin|admin|user|owner] owner requires $object
 * @param PHPFrame_Object $object   Or any object with ->owner property. Used in
 *                                  conjunction with 'owner' role to check
 *                                  ownership of an object
 */
function is($role='admin', $object=null) {
	$auth = false;
	switch($role) {
		case 'user':
		        if(isset($_SESSION['user'])
                    && $_SESSION['user']->group_id == USER_GROUP_ID
                ) {
                    $auth = true;
                }
                //NOTE: no break, falls through to admin
        case 'admin':
                if(isset($_SESSION['user'])
                    && $_SESSION['user']->group_id == ADMIN_GROUP_ID
                ) {
                    $auth = true;
                }
                //NOTE: no break, falls through to superadmin
        case 'super':
		case 'superadmin':
                if(isset($_SESSION['user'])
                    && $_SESSION['user']->group_id == SUPERADMIN_GROUP_ID
                ) {
                    $auth = true;
                }
            break;
		case 'owner':
			    if(isset($object)
			        && is_object($object)    //object passed in
			        && $object->owner        //has owner field
			        && isset($_SESSION['user'])   //session user_id is set
			        && $_SESSION['user']->id      //session user_id not false
			        && $object->owner == $_SESSION['user']->id    //matches
			    ) {
			    	$auth = true;
			    }
		    break;
	}
	return $auth;
}

/**
 * Used to include header, page (name passed as $page variable) and footer
 * @param String $page  name of php file in views to include
 * @param array $data   assoc array containing any data required by view 
 */
function view($page="home", $data=array()) {
	//generate read-only varaibles passed via $data assoc array in local scope
    foreach($data as $key=>$value) {
    	$$key = $value;
    }
    
	require_once(VIEW_PATH.'partials/header.php');
	if(file_exists(VIEW_PATH."$page.php")) {
        require_once(VIEW_PATH."$page.php");
	} else {
		//TODO: Error if view chosen doesn't exist?
	}
    require_once(VIEW_PATH.'partials/footer.php');
}

/**
 * Used to display error page
 * @param String $h1
 * @param String $body
 * @param String $type
 */
function show_error($h1, $body, $type="404"){
    $page="error";
    isset($h1) ? $message_h1 = $h1 :$message_h1 = "Sorry, the page you requested can't be found.";
    isset($body) ? $message_body = $body :$message_body = "There might be a typing error in the address, or you clicked an out-of date link. You can try: <ul><li>Retype the address</li><li>Go back to the <a href=\"".BASE_URL."\">homepage</a></li></ul><small>404 error</small>";
    switch($type){
        case '503':
        header("503 Service Unavailable");
        $title = "Private event, you must login to access contents";
        default:
        header("Status: 404 Not Found");
        $title = "Private event, you must login to access contents";
    }
    require_once(VIEW_PATH.'partials/header.php');
    require_once(VIEW_PATH.'404.php');
}

/**
 * Used to get value from key in $_GET array
 * @param unknown_type $key
 */
function get($key) {
	if(isset($_GET[$key])) {
		return $_GET[$key];
	} else {
		return NULL;
	}
}

/**
 * Used to retrive nice name from user object
 * @param PHPFrame_User $owner
 */
function get_name($owner) {
	$name = "Anon";
	
	if($owner && is_object($owner) && $owner->username) {
		$name = $owner->username; 
	
	    if($owner->first_name && !$owner->last_name) {
	    	$name = $owner->first_name;
	    } elseif($owner->first_name && $owner->last_name) {
	    	$name = $owner->first_name." ".$owner->last_name;
	    } elseif($owner->last_name) {
	    	$name = $owner->last_name;
	    }
	}
	
    return $name;
}

/**
 * Used to make secure OAuth calls to API
 * @param String $query_url     Query as URL to make to API. e.g. "card/get"
 *                              Could contain parameters e.g. ?id=1
 * @param Array $query_params   Query parameters as assoc_array
 *                              Overrides parameters passed in $query_url
 * @param String $as            Desired format of return [json|obj|assoc]
 */
function callAPI($query_url, $query_params=array(), $as='json') {
	$ret = "";
    try {
    	$request = BASE_API.$query_url;
    	//create OAuth object using private key and secret
        $oauth = new OAuth(PRIVATE_KEY, SECRET, OAUTH_SIG_METHOD_HMACSHA1);
        //parameters passed as data using array 
        $oauth->fetch($request, $query_params, OAUTH_HTTP_METHOD_GET);
        //get JSON response string
        $json_string = $oauth->getLastResponse();   
//var_dump($request);
//var_dump($json_string);
    } catch(OAuthException $E) {
//var_dump($oauth->getLastResponse());
        $json_string = $oauth->getLastResponse();
        $ret = $json_string;
//var_dump($json_string); exit;        
//    	$error = json_decode($oauth->getLastResponse());
//        if($error && is_object($error)) {
//            echo $error->error->message;
//        } else {
//            echo $error; 
//        }
//        return;
    }
    
    if($as == "json")
        $ret = $json_string;
    if($as == "obj")
        $ret = json_decode($json_string);
    if($as == "assoc")
        $ret = json_decode($json_string);
        
    return $ret;
}