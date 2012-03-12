<?php
require_once ('../config.php');
require_once ('functions.php');
$options = array();

if ($_POST) {
    foreach ($_POST as $key => $value) {
        if ($key == 'controller' || $key == 'action') {
            $$key = $value;
        } else {   
            $options[$key]=$value;
        }
    }
}

$myURL = $controller.'/'.$action; 
$userobj = callAPI($myURL, $options, 'obj');

if($userobj && is_object($userobj) && $userobj->id) {
    $_SESSION['user'] = $userobj;
    
    $name = $userobj->username; 

    if($userobj->first_name!='' && !$userobj->last_name) {
    	$name = $userobj->first_name;
    } elseif($userobj->first_name!='' && $userobj->last_name!='') {
    	$name = $userobj->first_name." ".$userobj->last_name;
    } elseif($userobj->last_name!='') {
    	$name = $userobj->last_name;
    }
    $_SESSION['user_name'] = $name;
    echo(json_encode($userobj));
} else {
    echo $userobj;
    die;
}
  
?>