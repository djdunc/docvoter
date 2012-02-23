<?php //var_dump($events);?>
<!-- BEGIN PAGE BREADCRUMBS/TITLE -->
<div id="header">
<div class="container_4">
	<div class="grid-wrap clearfix">
	        <h1 class="grid_2">
		            <span class="org">vote</span>
			        Drivers of Change Events
		    </h1>
    		<div class="grid_2 align_right">
    				
    		</div>
    </div>
</div>
</div>
<div class="container_4">
	<div id="page-heading" class="clearfix">
	    <div class="grid-wrap">
    		<div class="grid_4">
    		       <ul>
    		           <?php foreach ($data['events'] as $event) { ?>
    		          <li><a href="<?php echo (BASE_URL.'index.php?event='.$event->id);?>"><?php echo($event->name);?></a></li>
    		          <?php }?>
    		       </ul>
    		</div>
	    </div>
    </div>
</div>