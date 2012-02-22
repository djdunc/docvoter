<!--	Load the Tablesorter script. -->
<script src="assets/js/jquery.tablesorter.min.js" type="text/javascript"></script>
<script src="assets/js/jquery.tablesorter.pager.js" type="text/javascript"></script>
<!--	Load the "Chosen" stylesheet. -->
<link rel="stylesheet" href="assets/js/chosen/chosen.css" type="text/css" media="screen" />
<!--	Load the Chosen script.-->
<script src="assets/js/chosen/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#events')
	.tablesorter({dateFormat: 'ddmmyyyy', widthFixed: true, widgets: ['zebra'],sortList:[[3,1]],headers: { 
          //3: { sorter: "shortDate", dateFormat: 'ddmmyyyy' }, // dateFormat will parsed as the default above 
         // 4: { sorter: "shortDate"}, // set day first format 
          5: { sorter: false}
        }})
    .tablesorterPager({container: $("#table-pager-1")});
});
</script>
<!-- BEGIN PAGE BREADCRUMBS/TITLE -->
<div class="container_4">
	<div id="page-heading" class="clearfix">
	    <div class="grid-wrap">
    		<h2 class="grid_2">
    		       Events
    		</h2>
    		<div class="grid_2 align_right">
    				<a href="index.php?do=event" class="button medium">Add new event</a>
    		</div>
	    </div>
    </div>
</div>
<!-- END PAGE BREADCRUMBS/TITLE -->
<div class="container_4">
    <div class="grid-wrap">	
    <!-- BEGIN TABLESORTER Tablesorter documentation can be found at their website: http://tablesorter.com/docs/ -->
	<div class="grid_4">
		<div class="panel">
			<!-- <h2 class="cap">Events</h2> -->
			<div class="content no-cap">			
				<table id="events" class="styled"> 
					<thead> 
						<tr> 
							<th>Event Name</th>
							<th>Event Owner</th> 
							<th>Cards</th>
							<th class="{sorter: 'shortDate'}">Start date</th>
							<th>End date</th> 
							<th class="options-row">Options</th> 
						</tr> 
					</thead> 
					<tbody> 
						<?php
						    foreach ($events as $event):
						        $owner_name = get_name($event->owner_user);
						?>
						<tr> 
							<td><a href="index.php?do=event&id=<?php echo $event->id ?>"><?php echo $event->name ?></a></td> 
							<td class="center"><?php echo $owner_name ?></td> 
							<td class="center"><?php echo $event->card_count; ?></td> 
							<td class="center"><?php echo(date( "d-m-Y", $event->start)); ?></td>
							<td class="center"><?php if($event->end!=0){echo(date( "d-m-Y", $event->end));}?></td> 
							<td class="center options-row"><a class="icon-button edit" title="edit event" href="index.php?do=event&id=<?php echo $event->id ?>">Edit</a><a class="icon-button send" title="send details" href="mailto:?subject=<?php echo $event->name; ?> Drivers of Change&amp;body=Link: <?php echo urlencode(BASE_URL.'index.php?event='.$event->id); ?> <?php if($event->password!=''){ echo("Secret Code:".$event->password);} ?>">Send details</a><a class="icon-button link" title="view event" href="<?php echo(BASE_URL.'index.php?event='.$event->id);?>">View event</a></td> 
						</tr>
						<?php
						    endforeach;
						    unset($event);
						?>
					</tbody> 
					
				</table>
				
				<div id="table-pager-1" class="pager">
					<form action="">
						<select class="pagesize">
							<option selected="selected" value="10">10</option>
							<option value="20">20</option>
							<option value="30">30</option>
							<option value="40">40</option>
							<option value="<?php echo count($events);?>">All</option>
						</select>
						<a class="button small first"><img src="assets/images/table_pager_first.png" alt="First" /></a>
						<a class="button small prev"><img src="assets/images/table_pager_previous.png" alt="Previous" /></a>
						<input type="text" class="pagedisplay" disabled="disabled" />
						<a class="button small next"><img src="assets/images/table_pager_next.png" alt="Next" /></a>
						<a class="button small last"><img src="assets/images/table_pager_last.png" alt="Last" /></a>
					</form>
				</div>	
			</div>
		</div>
	</div>
	<!-- END TABLESORTER -->
	</div>
	</div>