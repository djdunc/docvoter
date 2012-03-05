<?php //var_dump($events);?>
<div class="grey">
<div class="container_4">
	<div class="clearfix">
	    <div class="grid-wrap">
    		<div class="grid_4">
    		       <ul id="event-gallery">
    		           <?php foreach ($events as $event){?>
    		          <li><a href="<?php echo (BASE_URL.'index.php?event='.$event->id);?>"> 
    		                  <?php //if($event->end!=0 && $event->end < time()) { ?>
    		                <!-- <p class="drivers">
    		                                            <span class="social">viral/bacterial pandemic</span> <span class="technological-b">full scale nuclear war</span> <span class="environmental">rapid rise in life expentancy</span> <span class="economic">gulf stream shuts down</span> <span class="political">lifelong working</span>
    		                                            </p> -->
    		                  <?php //} else { 
    		                      $cols = array('aadae5','529ec7','124576','9fbfc3','7f96a6','55b2ca');
    		                      $rand_col = $cols[array_rand($cols)];
    		                  ?>
    		                      <p class="drivers" style="background-color:#<?php echo $rand_col;?>">
    		                      <span><img src="assets/images/your-say.png" alt="Have your say" /></span>
    		                      </p>
    		                  <?php //}?>
    		              <p class="footer"><span class="event"><?php echo($event->name);?></span>
    		              <?php if($event->org){ echo ('<span class="org">by '.$event->org.'</span>' ); }?> <?php if(isset($event->totalvotes)){ echo('<span class="votes">'.$event->totalvotes.' votes</span>'); }?></p>
    		              </a>
    		          </li>
    		          <?php }?>
    		       </ul>
    		</div>
	    </div>
    </div>
</div>
</div>