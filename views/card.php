<?php //var_dump($user)?>
<!-- BEGIN PAGE BREADCRUMBS/TITLE -->
<div class="container_4">
	<div id="page-heading" class="clearfix">
	    <div class="grid-wrap">
    		<div class="grid_2 title-crumbs">
    		       <h3>New driver</h3>
    		</div>
    		<div class="grid_2 align_right">
    				<a href="index.php?do=vote&event=<?php echo $data['event_id']?>" class="button large">Back to voting</a>
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
							<span>Category<strong class="red">*</strong></span>
							<select class="chosen" name="category_tag_id" id="cat_id">  
							    <?php foreach ($data['event_categories']['categories'] as $key=>$cat){ 
							        $sel = "";
							        if ($key == $card->category_tag_id){
							            $sel = " SELECTED";
							        }
							        echo('<option value='.$key.$sel.'>'.$cat.'</option>');} //TODO add collections under once is selecte?>
							</select>
						</label>
						<?php if (!$user->email||$user->email==''){?>
						<label class="align-left">
							<span>Your email<strong class="red">*</strong></span>
							<input class="textbox l editable" name="email" id="email" type="text" value="" />
						</label>
						<?php } ?>
						<!-- Buttons -->
						<div class="non-label-section">
						    <?php if(isset($card->owner_user->id)&&$card->owner_user->id==1&&!is('super')) {?>
						        <p class="button medium disabled" id="fakesave">Only owner can edit this card</p>
						    <?php  }else{?>
						        <input type="button" id="save" class="button medium blue" value="Save" />
    						    <a href="index.php?do=vote&event=<?php echo($event->id);?>" class="button medium">Cancel</a>
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
		    <h2 class="cap">Notes</h2>
		    	<div class="content">
		    	    <p><strong class="red">*</strong> Indicates required fields</p>
    				<p>Try to keep the issue text as short as possible - they are being shown as a list.</p>

                    <p>The question and factoid fields allow you to capture a bit more information about the card in the same format as the original Drivers of Change cards - but these are optional.</p>
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
    var owner_email = <?php if (!$user->email||$user->email==''){echo 'false';}else{echo 'true';}?>;
    //if adding card card_id == 0
    if (card_id != 0){
        var action = 'controller=api&action=card/put&id='+card_id;
        var event_action = 'action=eventcards/put&event_id='+event_id;
    } else{
        var action = 'controller=api&action=card/post&topic_id=1&type=vote&owner='+owner+'&origin_event_id='+event_id;
        var event_action = 'action=eventcards/post&event_id='+event_id;
    }
    
    if(!owner_email){
        $("#card").validate({
            rules: { name: "required", email:{  required: true, email:true}},
            messages: { name: "Card name is required", email: "Please enter a valid email address"}
        });
    }
    
    
    $('#card input.editable, #card textarea.editable').each(function (i) {
         $(this).data('initial_value', $(this).val());
    });
    function postCard(){
        $.post('includes/callAPI.php', action+'&name='+$("#name").val(), function(data) {
                  try { saved_card = $.parseJSON(data); }
                  catch (err) { displayAlertMessage(data); return false; }
                  if (saved_card.id){
                       // alert(event_action+'&card_id='+saved_card.id+'&category_tag_id='+$('#cat_id option:selected').val());
                        $.post('includes/callAPI.php', event_action+'&card_id='+saved_card.id+'&category_tag_id='+$('#cat_id option:selected').val(), function(data) {
                             try { saved_eventcard = $.parseJSON(data); }
                             catch (err) { displayAlertMessage(data); return false; }
                               if (saved_eventcard.event_id){
                                  window.location.href = baseurl+'index.php?do=vote&event='+event_id;
                               }
                           }).error(function() { alert("There was an error adding your card to this event, please try again."); })
                  } else{
                       displayAlertMessage(data);
                  }
         }).error(function() { alert("There was an error saving your card, please try again later."); },'json')
    }
    function postOwner(){
        var update_user = 'action=user/put&id='+owner+'&email='+$("#email").val();
        $.post('includes/callAPI.php', update_user , function(data) {
             try { saved_user = $.parseJSON(data); }
             catch (err) { displayAlertMessage(data); return false; }
              if (saved_user.id){
                     postCard();
              } 
         }).error(function() { alert("There was an error saving your card, please try again later."); },'json')
    }

    //bind save button
    $("#save").click(function() {
      if($("#card").valid()){
          if (collection == 'steep'){
              action = action+'&category_id='+$('#cat_id option:selected').val();
          } else{
              action = action+'&category_id=6';
          }
          if (!owner_email){
             postOwner();
          } else{
              postCard();
          }
          
      }
      return false;
    });
    
});

//]]></script>