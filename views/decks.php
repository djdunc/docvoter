<?php
//var_dump($steep);
//var_dump($decks);
?>
<!--	Load the Tablesorter script. -->
<script src="assets/js/jquery.tablesorter.min.js" type="text/javascript"></script>
<script src="assets/js/jquery.tablesorter.pager.js" type="text/javascript"></script>
<!--	Load the "Chosen" stylesheet. -->
<link rel="stylesheet" href="assets/js/chosen/chosen.css" type="text/css" media="screen" />
<!--	Load the Chosen script.-->
<script src="assets/js/chosen/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#decks')
	.tablesorter({dateFormat: 'ddmmyyyy', widthFixed: true, widgets: ['zebra'],sortList:[[2,1]],headers: { 
          //3: { sorter: "shortDate", dateFormat: 'ddmmyyyy' }, // dateFormat will parsed as the default above 
         // 4: { sorter: "shortDate"}, // set day first format 
          3: { sorter: false}
        }})
    .tablesorterPager({container: $("#table-pager-1")});
});
</script>
<!-- BEGIN PAGE BREADCRUMBS/TITLE -->
<div class="container_4">
	<div id="page-heading" class="clearfix">
	    <div class="grid-wrap">
    		<h2 class="grid_2">Decks</h2>
    		<div class="grid_2 align_right">
    				<a href="index.php?do=deck" class="button medium">Add new deck</a>
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
			<!-- <h2 class="cap">Decks</h2> -->
			<div class="content no-cap">			
				<table id="decks" class="styled"> 
					<thead> 
						<tr> 
							<th>Deck Name</th>
							<th>Cards</th>
							<th class="{sorter: 'shortDate'}">Date created</th>
							<th class="options-row">Options</th> 
						</tr> 
					</thead> 
					<tbody> 
						<?php foreach ($decks as $deck){?>
						<tr> 
							<td><a href="index.php?do=deck&id=<?php echo $deck->id ?>"><?php echo $deck->name ?></a></td> 
							<td class="center"></td> 
							<td class="center"><?php echo(date( "d-m-Y", $deck->ctime)); ?></td>
							<td class="center options-row"><a class="icon-button edit" title="edit deck" href="index.php?do=deck&id=<?php echo $deck->id ?>">Edit</a><a class="icon-button send" title="send details" href="mailto:?subject=<?php echo $deck->name; ?> Drivers of Change&amp;body=Link: <?php echo urlencode(BASE_URL.'index.php?do=deck&id='.$deck->id); ?>">Send details</a><a class="icon-button link" title="view Deck" href="<?php echo(BASE_URL.'index.php?Deck='.$deck->id);?>">View Deck</a></td> 
						</tr>
						<?php unset($deck); } ?>
					</tbody> 
					
				</table>
				
				<div id="table-pager-1" class="pager">
					<form action="">
						<select class="pagesize">
							<option selected="selected" value="10">10</option>
							<option value="20">20</option>
							<option value="30">30</option>
							<option value="40">40</option>
							<option value="<?php echo count($decks);?>">All</option>
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