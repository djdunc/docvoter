<?php //var_dump($events);?>
<div class="grey">
<div class="container_4">
	<div class="clearfix">
	    <div class="grid-wrap">
	        <div class="grid_3 push-top">
	            <p>Much about the course of our future is unknown, but there are actions taking place today that will determine tomorrow's way of life. <span class="break-l"></span>The <strong><em>Vote</em></strong> app allows us to get feedback from people around the world on what is driving change in their world. A Flickr pool of previous <strong><em>Vote</em></strong> events is available at <a href="http://bit.ly/docvote" target="_blank">http://bit.ly/docvote</a></p>

                <p>To create a <strong><em>Vote</em></strong> event contact vote[at]driversofchange.com</p>
	        </div>
	        <div class="grid_1">
	        </div>
    		<div class="grid_4">
    		       <ul id="event-gallery">
    		           <?php foreach ($events as $event){ 
    		               if (!$event->password){?>
    		          <li><a href="<?php echo (BASE_URL.'index.php?event='.$event->id);?>"> 
    		                  <?php if($event->end!=0 && $event->end < time() && $event->auto_close) {  ?>
    		                        <div class="drivers">
    		                            
    		                            <?php if (isset($event->top5)){
    		                                
                                             foreach($event->top5 as $card){
                                                    $sorted[$card->category_tag_id] = $card;
                                                }
                                                ksort($sorted);
                                            unset($card);
    		                                foreach ($sorted as $card){
    		                                    if (strlen($card->card_title) > 40){
    		                                        $trimmed_title = preg_replace('/\s+?(\S+)?$/', '', substr($card->card_title, 0, 40)).'...';
    		                                    }else{
    		                                        $trimmed_title = $card->card_title;
    		                                    }
    		                                    echo('<p class="card cat-'.$card->category_tag_id.'"><span>'.$trimmed_title.'</span></p> ');
    		                                }
    		                            }?>
    		                            
    		                        </div>
    		                  <?php } else { 
    		                      $cols = array('aadae5','529ec7','124576','9fbfc3','7f96a6','55b2ca');
    		                      $rand_col = $cols[array_rand($cols)];
    		                  ?>
    		                      <p class="drivers" style="background-color:#<?php echo $rand_col;?>">
    		                      <span><img src="assets/images/your-say.png" alt="Have your say" /></span>
    		                      </p>
    		                  <?php }?>
    		              <p class="footer"><span class="event"><?php echo($event->name);?></span>
    		              <?php if($event->org){ echo ('<span class="org">by '.$event->org.'</span>' ); }?>&nbsp;&nbsp;<?php if(isset($event->totalvotes)&&$event->totalvotes>1){ echo('<span class="votes">'.$event->totalvotes.' votes</span>'); }elseif($event->totalvotes==1){echo('<span class="votes">1 vote</span>');}else{echo('<span class="votes">no votes</span>'); }?></p>
    		              </a>
    		          </li>
    		          <?php }}?>
    		       </ul>
    		</div>
	    </div>
    </div>
</div>
</div>