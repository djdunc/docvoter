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
$user = callAPI($myURL, $options, 'obj');

if($user && is_object($user) && $user->id) {
    $_SESSION['user'] = $user;
    
    $name = $user->username; 

    if($user->first_name!='' && !$user->last_name) {
    	$name = $user->first_name;
    } elseif($user->first_name!='' && $user->last_name!='') {
    	$name = $user->first_name." ".$user->last_name;
    } elseif($user->last_name!='') {
    	$name = $user->last_name;
    }
    $_SESSION['user_name'] = $name;
    echo(json_encode($user));
} else {
    echo $user;
    die;
}
  
?>