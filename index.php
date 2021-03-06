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
global $data;
$data = array(
    'admin_pages'=>$admin_pages
);
	
//set up ref page
if($page != "login" && $page != "register" && $page != "registration")
//    $_SESSION['ref_page'] = $page;
    $_SESSION['ref_query'] = $_SERVER['QUERY_STRING'];

//force login and check admin for admin pages (defined in functions->setup())
if(in_array($page,$admin_pages)) {
	login($data);
	allow(is('admin'));
}
	
//do required page
switch($page) {
    case 'logout':
            $_SESSION['survey']=NULL;
	        $_SESSION['user']=NULL;
	        $_SESSION['user_name']=NULL;
	        header("Location: index.php"); 
	        exit;
	    break;
    case 'login':
            view('login', $data);
        break;
    case 'relogin':
            allow(is('user'));
            $_SESSION['user'] = callAPI('user/get&id='.$_SESSION['user']->id);
            return $_SESSION['user']->id ? "success" : "failed";
        break;
    case 'register':
    	    view('register',$data);
    	break;
    case 'registration':
    	    //callAPI with user post, set group_id = 3
    	    $params['username'] = get('username');
            $params['password'] = get('password');
    	    $params['email'] = get('email');
            $params['first_name'] = get('first_name');
    	    $params['last_name'] = get('last_name');
    	    $params['group_id'] = 3;
    	    $user_json = callAPI('user/post',$params,'obj');
    	    
    	    if($user_json && is_object($user_json) && $user_json->id) {
                $_SESSION['user'] = $user_json;
                $_SESSION['user_name'] = $user_json->first_name." ".$user_json->last_name;
                echo(json_encode($user_json));
    	    } else {
    	    	echo $user_json;
                die;
    	    }
    	    
    	break;
    case 'decks':
            $data['decks'] = callAPI("deck", array('include_card_count'=>1), 'obj');
            $data['steep'] = $steep;
            
            view('decks', $data);
        break;
    case 'deck':
    	    $deck_card_ids = array();
            $deck_id = get('id');
            $data['editable'] = false;
            if (isset($deck_id)) {
                $deck = callAPI("deck/get?id=$deck_id", array(), 'obj');
                if (empty($deck) || !$deck->id) {
	                //404 error
	                show_error("Sorry, the deck you have requested does not exist.", "Make sure that you have the correct URL and that the owner hasn't deleted it. You can create your own deck <a href=\"index.php?do=deck\">here</a>.");
	            }

	            $deck_cards = callAPI("card", array('deck_id'=>$deck_id), 'obj');
                foreach($deck_cards as $card) {
                	$deck_card_ids[] = $card->id;
                }
                $data['editable'] = is('super') || (is('admin') && is('owner',$deck));
                $data['deck_card_ids'] = implode(',',$deck_card_ids);
                $data['edit_deck_id'] = $deck_id;
	            $data['edit_deck'] = $deck;
                $data['deck_cards'] = $deck_cards;
            }
            
            //$cards = callAPI("card?limit=-1&tag_id=3", array(), 'obj');
            //$data['cards'] = $cards;
            $data['steep'] = $steep;
            
            view('deck', $data);
        break;
    case 'events':
    	    $params = array('include_owner'=>true,'include_card_count'=>true,'type'=>2);
            if(!is('super')) $params['owner'] = $_SESSION['user']->id;
    	    $data['events'] = callAPI("event", $params, 'obj');
            view('events',$data);
        break;
    case 'event':
    	    $data['event_cards'] = array();
            $event_id = get('id');
            if (isset($event_id)) {
                $event = callAPI("event/get?id=$event_id", array(), 'obj');
                if (empty($event) || !$event->id) {
                    //404 error
                    show_error("Sorry, the event you have requested does not exist.", "Make sure that you have the correct URL and that the owner hasn't deleted it. You can create your own event below:");
                }
                $event_cards = callAPI("card", array('event_id'=>$event_id,'include_owner'=>1), 'obj');
                $votes = callAPI("vote", array('event_id'=>$event_id,'include_owner'=>1), 'obj');
                $event_votes= array();
                foreach ($votes as $vote){
                    $event_votes[$vote->card_id] = $vote->total;
                }
                
                $data['event'] = $event;
                $data['edit_event_id'] = $event->id;
                $data['event_cards'] = $event_cards;
                $data['event_votes'] =  $event_votes;
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
    	    $data['steep'] = $steep;
       	    view('event',$data);
        break;
        //add card in admin mode
    case 'eventcard':
    	    allow(is('user'));
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
            $event_id = get('event_id');
            if(isset($event_id)) {
            	$event = callAPI("event/get?id=$event_id", array(), 'obj');
                if (empty($event) || !$event->id) {
                    //404 error
                    show_error("Sorry, the event you have requested does not exist.", "Make sure that you have the correct URL and that the owner hasn't deleted it. You can create your own event <a href=\"index.php?do=event\">here</a>.");
                }
                
                $data['event_categories'] = $data['collections'][$event->collection_id];
                $data['event_id'] = $event_id;
                $data['event'] = $event;
            } else {
            	show_error("Sorry, the event you have requested does not exist.", "Make sure that you have the correct URL and that the owner hasn't deleted it. You can create your own event <a href=\"index.php?do=event\">here</a>.");
            	view('404',$data);
            	exit;
            }
    	    $card_id = get('id');
            if (isset($card_id)) {
            	$params = array('include_owner'=>1);
            	if(isset($event)) {
            		$params['event_id']=$event->id;
            	}
                $card = callAPI("card/get?id=$card_id", $params, 'obj');
                if (empty($card) || !$card->id) {
                    //404 error
                    show_error("Sorry, the card you have requested does not exist.", "Make sure that you have the correct URL and that the owner hasn't deleted it. You can create your own card <a href=\"index.php?do=card\">here</a>.");
                }

                $data['card'] = $card;
            }
            $data['user'] = $_SESSION['user'];
            view('eventcard',$data);
        break;
        case 'card':
        	    allow(is('user'));
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
                $event_id = get('event');
                if(isset($event_id)) {
                	$event = callAPI("event/get?id=$event_id", array(), 'obj');
                    if (empty($event) || !$event->id) {
                        //404 error
                        show_error("Sorry, the event you have requested does not exist.", "Make sure that you have the correct URL and that the owner hasn't deleted it. You can create your own event <a href=\"index.php?do=event\">here</a>.");
                    }

                    $data['event_categories'] = $data['collections'][$event->collection_id];
                    $data['event_id'] = $event_id;
                    $data['event'] = $event;
                } else {
                	show_error("Sorry, the event you have requested does not exist.", "Make sure that you have the correct URL and that the owner hasn't deleted it. You can create your own event <a href=\"index.php?do=event\">here</a>.");
                	view('404',$data);
                	exit;
                }
        	    $card_id = get('id');
                if (isset($card_id)) {
                	$params = array('include_owner'=>1);
                	if(isset($event)) {
                		$params['event_id']=$event->id;
                	}
                    $card = callAPI("card/get?id=$card_id", $params, 'obj');
                    if (empty($card) || !$card->id) {
                        //404 error
                        show_error("Sorry, the card you have requested does not exist.", "Make sure that you have the correct URL and that the owner hasn't deleted it. You can create your own card <a href=\"index.php?do=card\">here</a>.");
                    }

                    $data['card'] = $card;
                }
                $data['user'] = $_SESSION['user'];
                view('card',$data);
            break;
    case 'vote':
    	    allow(is('user'));
    	    $event_id = get('event');
            if (isset($event_id)) {
                $event = callAPI("event/get?id=$event_id&include_owner=1", array(), 'obj');
                if (empty($event) || !$event->id) {
                    //404 error
                    show_error("Sorry, the event you have requested does not exist.", "Make sure that you have the correct URL and that the owner hasn't deleted it.");
                }
                if(isset($event->owner_user)) {
                    $event_org_id = $event->owner_user->organisation_id;
                    if(isset($event_org_id) && $event_org_id) {
                        $event_org = callAPI("organisation/get?id=$event_org_id", array(), 'obj');
                        if(isset($event_org) && $event_org->id) {
                            $data['event_org'] = $event_org;
                        }
                    }
                }
                $collection = callAPI('collection?id='.$event->collection_id, array(), 'obj');
                $data['collection'] = array('id'=>$collection->id,'name'=>$collection->name);
                foreach($collection->categories as $category) {
                    $data['collection']['categories'][$category->id] = $category->name;
                }
                $event_cards = callAPI("card", array('event_id'=>$event_id), 'obj');
                $votes = callAPI("vote", array('event_id'=>$event_id), 'obj');
                $data['event'] = $event;
                $data['event_cards'] = $event_cards;
                $data['votes'] = $votes;
                $data['top50'] = top(50, $votes);
                $data['steep'] = $steep;
            }
            if($event->end!=0 && $event->end < time() && $event->auto_close){
                $page = 'results';
            } else{
                if (!isset($event->password)){
                    view('vote',$data);
                } else{
                    if ($event->password==$_SESSION['code']){
                        view('vote',$data);
                    } else{
                        view('event_login', $data);
                    }
                }
                break;
            }   
    case 'results':
            $event_id = get('event');
            if (isset($event_id)) {
                $event = callAPI("event/get?id=$event_id&include_owner=1", array(), 'obj');
                if (empty($event) || !$event->id) {
                    //404 error
                    show_error("Sorry, the event you have requested does not exist.", "Make sure that you have the correct URL and that the owner hasn't deleted it.");
                }

                if(isset($event->owner_user)) {
                    $event_org_id = $event->owner_user->organisation_id;
                    if(isset($event_org_id) && $event_org_id) {
                        $event_org = callAPI("organisation/get?id=$event_org_id", array(), 'obj');
                        if(isset($event_org) && $event_org->id) {
                            $data['event_org'] = $event_org;
                        }
                    }
                }
                
                $collection = callAPI('collection?id='.$event->collection_id, array(), 'obj');
                $data['collection'] = array('id'=>$collection->id,'name'=>$collection->name);
                foreach($collection->categories as $category) {
                	$data['collection']['categories'][$category->id] = $category->name;
                }
                $event_cards = callAPI("card", array('event_id'=>$event_id), 'obj');
                $votes = callAPI("vote", array('event_id'=>$event_id), 'obj');
                $data['top50'] = top(50, $votes);
                $data['event'] = $event;
                $data['event_cards'] = $event_cards;
                $data['votes'] = $votes;
                $data['steep'] = $steep;
            }
            if (!isset($event->password)){
                view('results',$data);
            } else{
                if ($event->password==$_SESSION['code']){
                    view('results',$data);
                } else{
                    view('event_login', $data);
                }
            }
        break;
    case 'about':
    case 'home':
    default:
    	    $event_id = get('event');
    	    $event_pass = get('pass');
    	    if (isset($event_pass)){
    	        $_SESSION['code'] = $event_pass;
    	    }
    	    if(isset($event_id)) {
    	    	$event = callAPI("event/get?id=$event_id&include_owner=1", array(), 'obj');
    	        if (!empty($event) && $event->id) {
                    if(isset($event->owner_user)) {
                    	$event_org_id = $event->owner_user->organisation_id;
                    	if(isset($event_org_id) && $event_org_id) {
                    		$event_org = callAPI("organisation/get?id=$event_org_id", array(), 'obj');
                    		if(isset($event_org) && $event_org->id) {
                    			$data['event_org'] = $event_org;
                    		}
                    	}
                    }
                    if (isset($event->password)){
                        if ($event->password==$_SESSION['code']){
                            $data['event'] = $event;
            	        	view('about', $data);
                        } else{
                            $data['event'] = $event;
            	        	view('event_login', $data);
                        }
                    } else{
                        $data['event'] = $event;
        	        	view('about', $data);
                    }
    	        	
                }
    	    }
    	    //if no event is set, do home
    	    if(!isset($event) || !$event->id) {
    	        $events = callAPI("event", array('include_owner'=>true,'include_card_count'=>true,'type'=>2), 'obj');
    	        //filter out events starting after today
    	        $count = count($events);                
                while($count--) {
                    if($events[$count]->start > time()) {
                        unset($events[$count]);
                    }
                }  
                //from remaining
                foreach ($events as $event){
                    //get org
                    if(isset($event->owner_user)) {
                    	$event_org_id = $event->owner_user->organisation_id;
                    	if(isset($event_org_id) && $event_org_id) {
                    		$event_org = callAPI("organisation/get?id=$event_org_id", array(), 'obj');
                    		if(isset($event_org) && $event_org->id) {
                    			$event->org = $event_org->name;
                    		}
                    	}
                    }
                    //get votes
                    $allvotes = callAPI("vote", array('event_id'=>$event->id), 'obj');
                    //tally total
                    $totalvotes = 0;
                    foreach ($allvotes as $vote){
                        $totalvotes += $vote->total;
                    }
                    $event->totalvotes = $totalvotes;
                    unset($totalvotes);
                    //if event has ended get top 5
                    if($event->end!=0 && $event->end < time() && count($allvotes)>0){
                        $top5 = top(5, $allvotes);
                        $event->top5 = array();
                        foreach ($allvotes as $topcard){
                            if (in_array($topcard->card_id, $top5 )){
                                $event->top5[]=$topcard;
                            }
                        }
                    }
                }  	        	
    	        $data['events'] = $events;
                //$_SESSION['ref_page'] = "";
                view('home', $data);
    	    }
}
?>