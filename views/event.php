<?php //var_dump($event_votes);?>
<!-- BEGIN PAGE BREADCRUMBS/TITLE -->
<div class="container_4">
	<div id="page-heading" class="clearfix">
	    <div class="grid-wrap">
    		<div class="grid_2 title-crumbs">
    		       <h2>Event details</h2>
    		</div>
    		<div class="grid_2 align_right">
    				<?php if(isset($event->id)){?><a href="index.php?event=<?php echo($event->id)?>" class="button medium blue">View event</a><?php }?> <a href="index.php?do=events" class="button medium">Back to events list</a>
    		</div>
	    </div>
    </div>
</div>
<!-- END PAGE BREADCRUMBS/TITLE -->
<div class="container_4">
<div class="grid-wrap">
	<!-- BEGIN FORM  -->
	<div class="grid_3">
		<div class="panel form">
		    <span class="message"></span>
			<div class="content no-cap">
				<!-- Any form you want to use this custom styling with must have the class "styled" -->
				<form id="event" class="styled">
					<fieldset>
						<!-- Text Field -->
						<label class="align-left">
							<span>Event name<strong class="red">*</strong></span>
							<input class="textbox l required editable" name="name" id="name" type="text" value="<?php if(isset($event->name)){echo($event->name);}?>" />
						</label>
							<!-- Text Field -->
    						<label class="align-left" for="textField">
    							<span>Event url</span>
    						    <input class="l readonly" id="url" type="text" value="<?php if(isset($event->name)){echo(BASE_URL.'index.php?event='.$event->id);}?>" readonly="readonly" />
    						</label>
						
						<!-- Text Area -->
						<label class="align-left" for="textArea">
							<span>Event description</span>
							<textarea class="textarea l editable" name="description" id="description" rows="2" cols="1"><?php if(isset($event->description)){echo($event->description);}?></textarea>
						</label>
						<!-- Collection -->
    					<label class="align-left" for="collection_id">
    					    
							<span>Driver categories</span>
							
							<select class="chosen" name="collection_id">  
							    <?php foreach ($collections as $key=>$collection){ 
							        $sel = "";
							        if ($key == $event->collection_id){
							            $sel = " SELECTED";
							        }
							        echo('<option value='.$key.$sel.'>'.$collection['name'].'</option>');}?>
							</select>
						</label>
						<!-- date -->
						<label class="align-left" for="startpicker">
							<span>Date from<strong class="red">*</strong></span>
							<input type="text" id="startpicker" value="" class="editable" />
							<input type="hidden" id="start" name='start' value="">
						</label>
						<label class="align-left" for="endpicker">
							<span>Date to</span>
							<input type="text" id="endpicker" value="" class="editable" />
							<input type="hidden" id="end" name='end' value="">
						</label>
						<!-- Tick box -->
						<div class="non-label-section">
						    <p class="check-pair">
						         <input type="hidden" name="auto_close" value="false" />
                                <label>
                                    <input type="checkbox" name="auto_close" value="true" <?php if(isset($event) && $event->auto_close){echo 'checked';}?> class="editable" /> Close event automatically after end date</label></p>
							 <p class="check-pair">
							     <input type="hidden" name="auto_publish" value="false" />
 							      <label>
							    <input type="checkbox" name="auto_publish" value="true" <?php if(isset($event) && $event->auto_publish){echo 'checked';}?> class="editable" />
							    Auto-publish submitted drivers
							</label>
							</p>
							<p class="check-pair">  
							    <input type="hidden" name="allow_anon" value="false" />
							    <label>
							    <input type="checkbox" name="allow_anon" value="true" <?php if(isset($event) && $event->allow_anon){echo 'checked';}?> class="editable" />
							    Include voter survey
							    </label>
							</p>
						</div>
						<!-- Pass Field -->
						<label class="align-left" for="password">
							<span>Secret code</span>
							<input type="hidden" name="private" id="private" value="false" />
							<input class="textbox s editable" name="password" id="password" type="text" value="<?php if(isset($edit_event)){echo($event->password);}?>" /> <?php if(isset($edit_event)&&$event->private){echo("(private event)");}?>
						</label>
						
						<!-- Buttons -->
						<div class="non-label-section">
						    <?php if(isset($event) && (is('super') || is('owner',$event))):?>
						        <input type="button" id="save" class="button medium blue" value="Save" />
                                <a href="index.php?do=events" class="button medium">Cancel</a>
						    <?php elseif(is('admin')):?>
						        <input type="button" id="save" class="button medium blue" value="Save" />
                                <a href="index.php?do=events" class="button medium">Cancel</a>
						    <?php else:?>
						        <p class="button medium disabled" id="fakesave">Only owner can edit</p>
						    <?php endif;?>
						</div>
					
					</fieldset>
				</form>
			</div>
		</div>	
    </div>
	<!-- END FORM  -->
	<div class="grid_1">
		<div class="panel">
		    <h2 class="cap">Notes</h2>
		    	<div class="content">
		    	    <p><strong class="red">*</strong> Indicates required fields</p>
    				<p>The driver categories are used to display the different groupings of issues. The Foresight team typically use STEEP however requests can be made for other categories - but these need to be set-up manually, contact the Foresight team if you need to do this.</p>

                    <p>We recommend you select the Auto-publish submitted drivers.</p>

                    <p>If you want to include a survey to link through to voter demographics please contact the foresight team before setting up event.</p>
    			</div>
		</div>
	</div>

	<div class="grid_3" id="deck-panel" <?php if(!isset($event) || !empty($event_cards)){echo("style='display:none'");}?>>
        <div class="panel">
        	<div class="content no-cap clearfix">
    		    <form id="deck">
    		    <fieldset>
    		           <h3>Add cards from Deck</h3>
    		        <div>
    		        <?php foreach($data['decks'] as $deck){
                          echo("<span class='list-col'><label><input type='radio' name='deck_id'  value='$deck->id'> $deck->name</label></span>");
                      } ?>
    		          </div>
    		    <!-- Buttons -->
				</fieldset>
				<div class='m-top'>
				 <input type="button" id="save-deck" class="button small blue" value="Add cards" />
				 </div>
				</form>
    		</div>
        </div>
    </div>
    <?php if(isset($event) && !empty($data['event_cards'])){
    //var_dump($data['event_cards']);?>
    <div class="clearfix">
    		<div class="grid_2 title-crumbs">
    		       <h3>Event Cards</h3>
    		</div>
    		<div class="grid_2 align_right">
    				<a href="index.php?do=eventcard&event_id=<?php echo $event->id;?>" class="button medium">Add a new card</a>
    		</div>
    </div>
    <div class="grid_4">
		<div class="panel">
			<div class="content no-cap">
		    <table id="cards" class="styled"> 
				<thead> 
					<tr> 
						<th>Name</th>
						<th>Category</th>
						<th>Votes</th>
						<th>Owner</th>
						<th class="{sorter: 'shortDate'}">Created</th>
						<th class="options-row">Options</th> 
					</tr> 
				</thead> 
				<tbody> 
				    	<?php
						    foreach ($data['event_cards'] as $card):
						    $owner_name = get_name($card->owner_user);
						    $card_votes = $event_votes[$card->id];
						?>
					<tr id='<?php echo $card->id ?>'> 
						<td><a href="index.php?do=eventcard&id=<?php echo $card->id ?>&event_id=<?php echo $event->id;?>"><?php echo $card->name ?></a></td> 
						<td class="center <?php if ($event->collection_id==1){echo $data['steep'][$card->category_tag_id].'-b';} ?>"><?php if(isset($collections[$event->collection_id]['categories'][$card->category_tag_id])){ echo $collections[$event->collection_id]['categories'][$card->category_tag_id]; }  ?></td>
						<td class="center"><?php echo $card_votes ?></td> 
						<td class="center"><?php echo $owner_name ?></td> 
						<td class="center" style="white-space: nowrap;"><?php echo(date( "d-m-Y", $card->ctime)); ?></td>
						<td class="center options-row"><a class="icon-button edit" title="edit card" href="index.php?do=eventcard&id=<?php echo $card->id ?>&event_id=<?php echo $event->id;?>">Edit</a><a class="icon-button delete" title="remove card from this event" href="#">Remove</a></td> 
					</tr>
					<?php
					    endforeach;
					    unset($card);
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
						<option value="50">50</option>
						<option value="<?php echo count($data['event_cards']);?>">All</option>
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
	<?php	}?>
</div>
</div>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.0/themes/base/jquery-ui.css" type="text/css" media="all" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
<!--	Load the Tablesorter script. -->
<script src="assets/js/jquery.tablesorter.min.js" type="text/javascript"></script>
<script src="assets/js/jquery.tablesorter.pager.js" type="text/javascript"></script>
<!--	Load the "Chosen" stylesheet. -->
<link rel="stylesheet" href="assets/js/chosen/chosen.css" type="text/css" media="screen" />
<!--	Load the Chosen script.-->
<script src="assets/js/chosen/chosen.jquery.js" type="text/javascript"></script>
<?php if(isset($event)){$edit_event_id=$event->id;}else{$edit_event_id=0;} ?>
<script type="text/javascript">
    $(document).ready(function() {
    var formChanged = false;
    var baseurl = "<?php echo BASE_URL; ?>";
    var edit_event = <?php echo($edit_event_id);?>;
    var owner = <?php echo $_SESSION['user']->id;?>;
    var cards = <?php echo count($event_cards); ?>;
    //setup datepickers
    function milsToSecs(picker, altField){
        var date = picker.datepicker('getDate');
        var epoch = date.valueOf() / 1000;
        altField.val(epoch);
    }
	$( "#startpicker" ).datepicker({
	  dateFormat: 'dd/mm/yy',
      altField: '#start',
      altFormat: '@',
      onSelect: function(dateText, inst) {
          milsToSecs($(this),$('#start'));
          handleFormChanged();
          }
    });
    $( "#endpicker" ).datepicker({
      dateFormat: 'dd/mm/yy',
      altField: '#end',
      beforeShow: customRange,
      altFormat: '@',
      onSelect: function(dateText, inst) {
         milsToSecs($(this),$('#end'));
         handleFormChanged();
        }
    });
    function customRange(a) {//start second one always from first date
        var b = new Date();
        var c = new Date(b.getFullYear(), b.getMonth(), b.getDate());
        if (a.id == 'endpicker') {
            if ($('#startpicker').datepicker('getDate') != null) {
                c = $('#startpicker').datepicker('getDate');
            }
        }
        return {
            minDate: c
        }
    }
    //if adding event edit_event == 0
    if (edit_event != 0){
        var action = 'controller=api&action=event/put&id='+edit_event;
        var dstart = '<?php if(isset($event)){echo($event->start);}?>';
        var dend = '<?php if(isset($event)){echo($event->end);}?>';
        if (dstart!='0'&&dstart!=''){
            $('#startpicker').datepicker('setDate', $.datepicker.parseDate('@',dstart+'000'));
            milsToSecs($('#startpicker'),$('#start'));
        }
        if (dend!='0'&&dend!=''){
            $('#endpicker').datepicker('setDate', $.datepicker.parseDate('@',dend+'000'));
            milsToSecs($('#endpicker'),$('#end'));
        }  
        // if we have cards, sort table and add delete buttons
        if (cards!=0){
             
             $('#cards').tablesorter({
                 dateFormat: 'ddmmyyyy', 
                 widthFixed: true, 
                 widgets: ['zebra'],
                 sortList:[[3,1]],
                 headers: {4: { sorter: false}}
             })
             .tablesorterPager({container: $("#table-pager-1")});
             $("#deck-select").chosen();
             
            function confirmGetMessage(line) {
            var myId = line.attr('id');
            //display a confirmation box
            var deletecard = confirm("Are you sure you want to remove this card?"); 
            //if the user presses the "OK" button delete
                if (deletecard){
                    $.post('includes/callAPI.php', 'action=eventcards/delete&event_id='+edit_event+'&card_id='+myId, function(data) {
                        if(data==''){
                            line.remove();
                        } else{
                            alert("There was an error removing the card, please try again later.");
                        }
                    }).error(function() { alert("There was an error removing the card, please try again later."); })
                }
            }
            //delete buttons
            $(".delete").click(function() {
                var myTr = $(this).closest('tr');
                confirmGetMessage(myTr);
               return false;
            });
        }
        
    } else{ //we are adding event
        var action = 'controller=api&action=event/post&eventtype=2&owner='+owner;
        $('#startpicker').datepicker('setDate', new Date());
        milsToSecs($('#startpicker'),$('#start'));
    }
    
    $("#event").validate({
        rules: { name: "required", start:"required"},
        messages: { name: "Event name is required", startpicker: "Please enter a start date"}
    });
    
    $('#event input.editable, #event textarea.editable').each(function (i) {
         $(this).data('initial_value', $(this).val());
    });

    $('#event input.editable, #event textarea.editable').keyup(function() {
         if ($(this).val() != $(this).data('initial_value')) {
              handleFormChanged();
         }
    });
    
    //if something is edited, show save button, and display alert on page leave

    $('#event .editable').bind('change paste', function() {
         handleFormChanged();
    });
    $('#startpicker').bind('change paste', function() {
         milsToSecs($(this),$('#start'));
          handleFormChanged();
    });
    $('#endpicker').bind('change paste', function() {
         milsToSecs($(this),$('#end'));
          handleFormChanged();
    });
    
    //set value of private on password change
    $('#password').keyup(function() {
     var value = $(this).val();
     if (value){
         $('#private').val('true');
     } else{
         $('#private').val('false');
     }
    });
    //bind save button
    $("#save").click(function() {
      if($("#event").valid()){
          $(window).unbind("beforeunload");
          $.post('includes/callAPI.php', action+'&'+$("#event").serialize(), function(data) {
              var saved_event = eval(jQuery.parseJSON(data));
              if (saved_event.id){
                  edit_event = saved_event.id;
                  if (cards==0){
                      $('#deck-panel').show();
                      window.location.hash = '#deck-panel';
                  }
                  displayAlertMessage("Event saved!");
              } else{
                   displayAlertMessage(data);
              }
           }).error(function() { alert("There was an error saving your event, please try again later."); })
      }
      return false;
    });
    //bind deck button
    $("#save-deck").click(function() {
      if($("#deck").valid()){
          var d_action = 'action=eventcards/post&event_id='+edit_event;   
          $.post('includes/callAPI.php', d_action+'&'+$("#deck").serialize(), function(data) {
             if (data==''){
                 //redirect to show cards
                 window.location.href = baseurl+"index.php?do=event&id="+edit_event;
             } else{
                 displayAlertMessage(data);
             }
          }).error(function() { alert("There was an error saving your event, please try again later."); })
      }
      return false;
    });
});
   function handleFormChanged() {
        $(window).bind('beforeunload', confirmNavigation);
        formChanged = true;
   }
   function confirmNavigation() {
        if (formChanged) {
             return ('One or more forms on this page have changed. Your changes will be lost!');
        } else {
             return true;
        }
   }
</script>