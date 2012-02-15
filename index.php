<?php
//globals
require_once 'config.php';
require_once 'includes/functions.php';

//requested page
$page = get('do');
if(!$page) $page = 'dash';

//setup
setup(array('page'=>$page));

//set up data assoc array to pass variables to view
$data = array(
);
	
//set up ref page
if($page != "login")
    $_SESSION['ref_page'] = $page;
	
//do required page
switch($page) {
    case 'logout':
	        $_SESSION['user']=NULL;
	        $_SESSION['user_name']=NULL;
	        header("Location: index.php"); 
	        exit;
	    break;
    case 'login':
            view('login');
        break;
    case 'decks':
            login();
            allow(is('admin'));

            $data['decks'] = callAPI("deck", array(), 'obj');
            $data['steep'] = $steep;
            
            view('decks', $data);
        break;
    case 'deck':
            login();
            allow(is('admin'));
            
            $deck_id = get('deck');
            if (isset($deck_id)) {
                $deck = callAPI("deck/get?id=$deck_id", array(), 'obj');
                if (empty($deck) || !$deck->id) {
	                //404 error
	                show_error("Sorry, the deck you have requested does not exist.", "Make sure that you have the correct URL and that the owner hasn't deleted it. You can create your own deck <a href=\"index.php?do=deck_new\">here</a>.");
	            }

	            $deck_cards = callAPI("card", array('deck_id'=>$deck_id), 'obj');
                
	            $data['deck'] = $deck;
                $data['deck_cards'] = $deck_cards;
            }
            
            view('deck', $data);
        break;
    case 'events':
    	    login();
            allow(is('admin'));
            view('events',$data);
        break;
    case 'event':
    	    login();
            allow(is('admin'));
       	    view('event',$data);
        break;
    case 'issues':
    	    login();
            allow(is('admin'));
            view('issues',$data);
        break;
    case 'issue':
    	    login();
            allow(is('admin'));
            view('issue',$data);
        break;
    case 'issue_add':
            view('issue_add',$data);
        break;
    case 'vote':
    	    view('vote',$data);
        break;
    case 'dash':
    default:
            $_SESSION['ref_page'] = "";
            view('dash', $data);
}
?>