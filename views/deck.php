<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.0/themes/base/jquery-ui.css" type="text/css" media="all" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
<!--	Load the "Chosen" stylesheet. -->
<link rel="stylesheet" href="assets/js/chosen/chosen.css" type="text/css" media="screen" />
<!--	Load the Chosen script.-->
<script src="assets/js/chosen/chosen.jquery.js" type="text/javascript"></script>
<!-- BEGIN PAGE BREADCRUMBS/TITLE -->
<div class="container_4">
	<div id="page-heading" class="clearfix">
	    <div class="grid-wrap">
    		<div class="grid_2 title-crumbs">
    		       <h2>Add Deck</h2>
    		</div>
    		<div class="grid_2 align_right">
    				<a href="index.php?do=decks" class="button medium">Back to deck list</a>
    		</div>
	    </div>
    </div>
</div>
<!-- END PAGE BREADCRUMBS/TITLE -->
<div class="container_4">
<div class="grid-wrap">
	<!-- BEGIN FORM STYLING -->
	<div class="grid_3">
		<div class="panel form">
		    <span class="message"></span>
			<div class="content no-cap">
				<!-- Any form you want to use this custom styling with must have the class "styled" -->
				<form id="event" class="styled">
					<fieldset>
						<!-- Text Field -->
						<label class="align-left">
							<span>Deck name<strong class="red">*</strong></span>
							<input class="textbox l required editable" name="name" id="name" type="text" value="<?php if(isset($edit_event->name)){echo($edit_event->name);}?>" />
						</label>
						<!-- Text Area -->
						<label class="align-left" for="textArea">
							<span>Deck description</span>
							<textarea class="textarea l editable" name="description" id="description" rows="2" cols="1"><?php if(isset($edit_event)){echo($edit_event->description);}?></textarea>
						</label>
						<!-- Buttons -->
						<div class="non-label-section">
						    <p class="button medium disabled" id="fakesave">Save</p>
						    <input type="button" id="save" class="button medium blue" value="Save" style="display:none" />
							<a href="index.php?do=admin" class="button medium">Cancel</a>
						</div>
					
					</fieldset>
				</form>
			</div>
		</div>
		 <h2>Cards</h2>
		 <?php //foreach ($steep as $cat){?>
		<div class="panel">
		    <h2 class="cap">Social</h2>
			<div class="content">
			</div>
		</div>
		<?php //}?>
	</div>
	
	<!-- END FORM STYLING -->
	<div class="grid_1">
		<div class="panel">
		    <h2 class="cap">Lorem Ipsum</h2>
		    	<div class="content">
		    	    <p><strong class="red">*</strong> Indicates required fields</p>
    				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    			</div>
		</div>
	</div>
	<?php if (isset($event_cards)){?>
	<div class="grid_4">
	    <div class="panel">	
	        <h2 class="cap">Event cards</h2>
			<!-- gallery -->
			<div class="content gallery">
				<div class="gallery-wrap">
					<div class="gallery-pager">
						<?php foreach (array_reverse($event_cards) as $card) { ?>
						<!-- GALLERY ITEM -->
						<div class="gallery-item">
							<a class="clue" title="<?php echo $card->name; ?>" href="index.php?do=view&card_id=<?php echo $card->id ?>"><img src="<?php if (isset($card->card_front)){ echo (UPLOADS_URL."fronts/".$card->card_front."_t.jpg");}?>" alt="" /></a>
						</div>
						<!-- END GALLERY ITEM -->
						<?php unset($card); } ?>
					</div>
				</div>
			
				<!-- The gallery pagination/options area. -->
				<div class="pager">
				
					<!-- Gallery options - these should probably become active once you've checked an image or more. -->
					<!-- <div class="gallery-options">
					                       <a class="button red small" href="#">Delete</a>
					                       <a class="button blue small" href="#">Edit</a>
					                   </div> -->
					
					<!-- Gallery pagination -->
					<form action="">
						<a class="button small first"><img src="assets/images/table_pager_first.png" alt="First" /></a>
						<a class="button small prev"><img src="assets/images/table_pager_previous.png" alt="Previous" /></a>
						<input type="text" class="pagedisplay" disabled="disabled" />
						<a class="button small next"><img src="assets/images/table_pager_next.png" alt="Next" /></a>
						<a class="button small last"><img src="assets/images/table_pager_last.png" alt="Last" /></a>
					</form>
				</div>
			
			</div>
			<!-- END CONTENT -->
			
		</div>
		<!-- END PANEL -->
	</div>
	<?php }?>
 </div>
</div>