<?php //var_dump($event);?>
<div class="container_4">
	<div id="page-heading" class="clearfix">
	    <div class="grid-wrap">
    		<div class="grid_3">
    		       <ul id="category-nav">
    		           <li><a class="active" href="">top 50</a></li><li><a href="">social</a></li><li><a href="">technological</a></li>
    		       </ul>
    		</div>
    		<div class="grid_1 align_right">
    				<a href="index.php?do=driver" class="button blue medium">+ add driver</a>
    		</div>
	    </div>
    </div>
</div>
<div class="container_4">
	    <div class="grid-wrap" class="clearfix">
    		<div class="grid_4">
    		    <div class="panel">
    		       <ul id="vote-cloud">
    		           <?php foreach ($data['event_cards'] as $card) { //var_dump($card);?>
    		               <li><a href="" <?php if($card->category_id==1){echo('class="social-b"');} ?>><?php echo($card->name);?></a></li>
    		          <?php }?>
    		       </ul>
    		     </div>
    		</div>
	    </div>
</div>
<br /><br />