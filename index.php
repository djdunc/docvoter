<?php
//globals
require_once 'config.php';
require_once 'includes/functions.php';

//requested page
$page = get('do');
if(!$page) $page = DEFAULT_PAGE;

//setup
setup(
    array('page'=>$page)
);

//set up data assoc array to pass variables to view
$data = array(
    'admin_pages'=>$admin_pages
);
	
//set up ref page
if($page != "login")
    $_SESSION['ref_page'] = $page;

//force login and check admin for admin pages (defined in functions->setup())
if(in_array($page,$admin_pages)) {
	login($data);
	allow('admin');
}
	
//do required page
switch($page) {
    case 'logout':
	        $_SESSION['user']=NULL;
	        $_SESSION['user_name']=NULL;
	        header("Location: index.php"); 
	        exit;
	    break;
    case 'login':
            view('login', $data);
        break;
    case 'decks':
            $data['decks'] = callAPI("deck", array(), 'obj');
            $data['steep'] = $steep;
            
            view('decks', $data);
        break;
    case 'deck':
            $deck_id = get('id');
            if (isset($deck_id)) {
                $deck = callAPI("deck/get?id=$deck_id", array(), 'obj');
                if (empty($deck) || !$deck->id) {
	                //404 error
	                show_error("Sorry, the deck you have requested does not exist.", "Make sure that you have the correct URL and that the owner hasn't deleted it. You can create your own deck <a href=\"index.php?do=deck\">here</a>.");
	            }

	            $deck_cards = callAPI("card", array('deck_id'=>$deck_id), 'obj');
                
	            $data['deck'] = $deck;
                $data['deck_cards'] = $deck_cards;
            }
            
            //$cards = callAPI("card?limit=-1&tag_id=3", array(), 'obj');
            //$data['cards'] = $cards;
            $data['steep'] = $steep;
            
            view('deck', $data);
        break;
    case 'events':
    	    $data['events'] = callAPI("event", array('include_owner'=>true,'include_card_count'=>true), 'obj');
            view('events',$data);
        break;
    case 'event':
            $event_id = get('id');
            if (isset($event_id)) {
                $event = callAPI("event/get?id=$event_id", array(), 'obj');
                if (empty($event) || !$event->id) {
                    //404 error
                    show_error("Sorry, the event you have requested does not exist.", "Make sure that you have the correct URL and that the owner hasn't deleted it. You can create your own deck <a href=\"index.php?do=event\">here</a>.");
                }

                $event_cards = callAPI("card", array('event_id'=>$event_id), 'obj');
                
                $data['event'] = $event;
                $data['event_cards'] = $event_cards;
            }
    	    $collections = callAPI('collection', array(), 'obj');
    	    foreach($collections as $collection) {
    	    	$data['collections'][$collection->id] = array(
    	    	    'name'=>$collection->name,
    	    	    'categories'=>array()
    	    	);
    	    	foreach($collection->categories as $category) {
    	    	    $data['collections'][$collection->id]['categories'][$category->id] = $category->name;	
    	    	}
    	    }
    	    $data['decks'] =  callAPI('deck?include_card_count=1', array(), 'obj');
       	    view('event',$data);
        break;
    case 'issues':
            view('issues',$data);
        break;
    case 'issue':
            view('issue',$data);
        break;
    case 'issue_add':
    	    allow('user');
            view('issue_add',$data);
        break;
    case 'vote':
    	    view('vote',$data);
        break;
    case 'about':
    default:
            $_SESSION['ref_page'] = "";
            view('about', $data);
}
?>