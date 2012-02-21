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
				<form id="deck" class="styled">
					<fieldset>
						<!-- Text Field -->
						<label class="align-left">
							<span>Deck name<strong class="red">*</strong></span>
							<input class="textbox l required editable" name="name" id="name" type="text" value="<?php if(isset($edit_deck->name)){echo($edit_deck->name);}?>" />
						</label>
						<!-- Text Area -->
						<label class="align-left" for="textArea">
							<span>Deck description</span>
							<textarea class="textarea l editable" name="description" id="description" rows="2" cols="1"><?php if(isset($edit_deck)){echo($edit_deck->description);}?></textarea>
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
	<?php if (isset($deck_cards)){?>
	<div class="grid_4">
	    <div class="panel">	
	        <h2 class="cap">Event cards</h2>
			<!-- gallery -->
			<div class="content gallery">
				<div class="gallery-wrap">
					<div class="gallery-pager">
						<?php foreach (array_reverse($deck_cards) as $card) { ?>
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
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.0/themes/base/jquery-ui.css" type="text/css" media="all" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
<?php if(!isset($edit_deck_id)){$edit_deck_id=0;} ?>
<script type="text/javascript">//<![CDATA[
    $(document).ready(function() {
    var formChanged = false;
    var baseurl = "<?php echo BASE_URL; ?>";
    var edit_deck = <?php echo($edit_deck_id);?>;
    var owner = <?php echo $_SESSION['user']->id;?>;
    //if adding deck edit_deck == 0
    if (edit_deck != 0){
        var action = 'controller=api&action=deck/put&id='+edit_deck;
    } else{
        var action = 'controller=api&action=deck/post&owner='+owner;
    }
    
    $("#deck").validate({
        rules: { name: "required"},
        messages: { name: "Deck name is required"}
    });
    
    $('#deck input.editable, #deck textarea.editable').each(function (i) {
         $(this).data('initial_value', $(this).val());
    });

    $('#deck input.editable, #deck textarea.editable').keyup(function() {
         if ($(this).val() != $(this).data('initial_value')) {
              handleFormChanged();
         }
    });
    
    //if something is edited, show save button, and display alert on page leave

    $('#deck .editable').bind('change paste', function() {
         handleFormChanged();
    });
    
    //bind save button
    $("#save").click(function() {
      if($("#deck").valid()){
          $(window).unbind("beforeunload");
         //alert(action+'&'+$("#deck").serialize());    
          $.post('includes/callAPI.php', action+'&'+$("#deck").serialize(), function(data) {
                  var saved_deck = eval(jQuery.parseJSON(data));
                  if (saved_deck.id){
                      displayAlertMessage("Deck saved!");
                  } else{
                       displayAlertMessage(data);
                  }
         }).error(function() { alert("There was an error saving your deck, please try again later."); })
      }
      return false;
    });
});

   function handleFormChanged() {
        $(window).bind('beforeunload', confirmNavigation);
        $('#save').show();
        $('#fakesave').hide();
        formChanged = true;
   }
   function confirmNavigation() {
        if (formChanged) {
             return ('One or more forms on this page have changed. Your changes will be lost!');
        } else {
             return true;
        }
   }
//]]></script>