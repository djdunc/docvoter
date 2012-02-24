<?php //var_dump($card)?>
<!-- BEGIN PAGE BREADCRUMBS/TITLE -->
<div class="container_4">
	<div id="page-heading" class="clearfix">
	    <div class="grid-wrap">
    		<div class="grid_2 title-crumbs">
    		       <h2>Event: <em><?php echo $event->name;?></em></h2>
    		       <h3>Card details</h3>
    		</div>
    		<div class="grid_2 align_right">
    				<a href="index.php?do=event&id=<?php echo $data['event_id']?>" class="button medium">Back to event</a>
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
				<form id="card" class="styled">
					<fieldset>
						<!-- Text Field -->
						<label class="align-left">
							<span>Issue<strong class="red">*</strong></span>
							<input class="textbox l required editable" name="name" id="name" type="text" value="<?php if(isset($card->name)){echo($card->name);}?>" />
						</label>
						<!-- Collection -->
    					<label class="align-left" for="category_tag_id">
							<span>Category (<?php echo $data['event_categories']['name'];?>)</span>
							<select class="chosen" name="category_tag_id" id="cat_id">  
							    <?php foreach ($data['event_categories']['categories'] as $key=>$cat){ 
							        $sel = "";
							        if ($key == $card->category_tag_id){
							            $sel = " SELECTED";
							        }
							        echo('<option value='.$key.$sel.'>'.$cat.'</option>');} //TODO add collections under once is selecte?>
							</select>
						</label>
						<label class="align-left">
							<span>Question<strong class="red"></strong></span>
							<input class="textbox l editable" name="question" id="quiestion" type="text" value="<?php if(isset($card->question)){echo($card->question);}?>" />
						</label>
						<!-- Text Area -->
						<label class="align-left" for="textArea">
							<span>Factoid</span>
							<textarea class="textarea l editable" name="description" id="description" rows="2" cols="1"><?php if(isset($card)){echo($card->description);}?></textarea>
						</label>
						<!-- Buttons -->
						<div class="non-label-section">
						    <?php if(isset($card->owner_user->id)&&$card->owner_user->id==1&&!is('super')) {?>
						        <p class="button medium disabled" id="fakesave">Only superadmins can edit this</p>
						    <?php  }else{?>
						        <input type="button" id="save" class="button medium blue" value="Save" />
    						    <a href="index.php?do=event&id=<?php echo($event->id);?>" class="button medium">Cancel</a>
						    <?php }?>
						</div>
					
					</fieldset>
				</form>
			</div>
		</div>
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
 </div>
</div>
<!--	Load the "Chosen" stylesheet. -->
<link rel="stylesheet" href="assets/js/chosen/chosen.css" type="text/css" media="screen" />
<!--	Load the Chosen script.-->
<script src="assets/js/chosen/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
<?php if(!isset($card_id)){$card_id=0;} ?>
<script type="text/javascript">//<![CDATA[
    $(document).ready(function() {
    var formChanged = false;
    var baseurl = "<?php echo BASE_URL; ?>";
    var event_id = <?php echo($event->id);?>;
    var owner = <?php echo $_SESSION['user']->id;?>;
    var card_id = <?php if(isset($card)){ echo($card->id);} else{echo('0');}?>;
    var collection = "<?php echo $data['event_categories']['name'];?>";
    //if adding card card_id == 0
    if (card_id != 0){
        var action = 'controller=api&action=card/put&id='+card_id;
        var event_action = 'action=eventcards/put&event_id='+event_id;
    } else{
        var action = 'controller=api&action=card/post&topic_id=1&type=vote&owner='+owner+'&origin_event_id='+event_id;
        var event_action = 'action=eventcards/post&event_id='+event_id;
    }
    
    $("#card").validate({
        rules: { name: "required"},
        messages: { name: "Card name is required"}
    });
    
    $('#card input.editable, #card textarea.editable').each(function (i) {
         $(this).data('initial_value', $(this).val());
    });

    $('#card input.editable, #card textarea.editable').keyup(function() {
         if ($(this).val() != $(this).data('initial_value')) {
              handleFormChanged();
         }
    });

    //bind save button
    $("#save").click(function() {
      if($("#card").valid()){
          $(window).unbind("beforeunload");  
          if (collection == 'steep'){
              action = action+'&category_id='+$('#cat_id option:selected').val();
          }
          $.post('includes/callAPI.php', action+'&'+$("#card").find('input[name!=category_tag_id]').serialize(), function(data) {
                  var saved_card = eval(jQuery.parseJSON(data));
                  if (saved_card.id){
                         //alert(event_action+'&card_id='+saved_card.id+'&category_tag_id='+$('#cat_id option:selected').val());
                        $.post('includes/callAPI.php', event_action+'&card_id='+saved_card.id+'&category_tag_id='+$('#cat_id option:selected').val(), function(data) {
                               var saved_eventcards = eval(jQuery.parseJSON(data));
                               if (saved_eventcards.event_id){
                                  displayAlertMessage("Card saved!");
                               } else{
                                   displayAlertMessage(data);
                               }
                           }).error(function() { alert("There was an error adding your card to this event, please try again."); })
                  } else{
                       displayAlertMessage(data);
                  }
         }).error(function() { alert("There was an error saving your card, please try again later."); })
      }
      return false;
    });
    
});

//]]></script>