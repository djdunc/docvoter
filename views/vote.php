<div class="container_4">
	<div id="page-heading" class="clearfix">
	    <div class="grid-wrap">
    		<div class="grid_4">
    		       <ul>
    		           <?php foreach ($data['event_cards'] as $card) { ?>
    		          <li><a href=""><?php echo($card->name);?></a></li>
    		          <?php }?>
    		       </ul>
    		</div>
	    </div>
    </div>
</div>