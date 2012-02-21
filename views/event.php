<?php //var_dump($collections);?>
<!--	Load the "Chosen" stylesheet. -->
<link rel="stylesheet" href="assets/js/chosen/chosen.css" type="text/css" media="screen" />
<!--	Load the Chosen script.-->
<script src="assets/js/chosen/chosen.jquery.js" type="text/javascript"></script>
<!-- BEGIN PAGE BREADCRUMBS/TITLE -->
<div class="container_4">
	<div id="page-heading" class="clearfix">
	    <div class="grid-wrap">
    		<div class="grid_2 title-crumbs">
    		       <h2>Add event</h2>
    		</div>
    		<div class="grid_2 align_right">
    				<a href="index.php?do=events" class="button medium">Back to events list</a>
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
							<span>Event name<strong class="red">*</strong></span>
							<input class="textbox l required editable" name="name" id="name" type="text" value="<?php if(isset($edit_event->name)){echo($edit_event->name);}?>" />
						</label>
							<!-- Text Field -->
    						<label class="align-left" for="textField">
    							<span>Event url</span>
    						    <input class="l readonly" id="url" type="text" value="<?php if(isset($edit_event->name)){echo(BASE_URL.'index.php?event='.$edit_event->id);}?>" readonly="readonly" />
    						</label>
						
						<!-- Text Area -->
						<label class="align-left" for="textArea">
							<span>Event description</span>
							<textarea class="textarea l editable" name="description" id="description" rows="2" cols="1"><?php if(isset($edit_event)){echo($edit_event->description);}?></textarea>
						</label>
						<!-- Collection -->
    					<label class="align-left" for="collection_id">
    					    
							<span>Driver categories</span>
							<select class="chosen" name="collection_id">  
							    <?php foreach ($collections as $key=>$collection){ echo('<option value='.$key.'>'.$collection['name'].'</option>');} //TODO add collections under once is selecte?>
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
                                    <input type="checkbox" name="auto_close" value="true" <?php if(isset($edit_event) && $edit_event->auto_close){echo 'checked';}?> class="editable" /> Close event automatically after end date</label></p>
							 <p class="check-pair">
							     <input type="hidden" name="auto_publish" value="false" />
 							      <label>
							    <input type="checkbox" name="auto_publish" value="true" <?php if(isset($edit_event) && $edit_event->auto_publish){echo 'checked';}?> class="editable" />
							    Auto-publish submitted drivers
							</label>
							</p>
							<p class="check-pair">  
							    <input type="hidden" name="allow_anon" value="false" />
							    <label>
							    <input type="checkbox" name="allow_anon" value="true" <?php if(isset($edit_event) && $edit_event->allow_anon){echo 'checked';}?> class="editable" />
							    Include voter survey
							    </label>
							</p>
						</div>
						<!-- Pass Field -->
						<label class="align-left" for="password">
							<span>Secret code</span>
							<input type="hidden" name="private" id="private" value="false" />
							<input class="textbox s editable" name="password" id="password" type="text" value="<?php if(isset($edit_event)){echo($edit_event->password);}?>" /> <?php if(isset($edit_event)&&$edit_event->private){echo("(private event)");}?>
						</label>
						
						<!-- Buttons -->
						<div class="non-label-section">
						    <p class="button medium disabled" id="fakesave">Save</p>
						    <input type="button" id="save" class="button medium blue" value="Save" style="display:none" />
							<a href="index.php?do=events" class="button medium">Cancel</a>
						</div>
					
					</fieldset>
				</form>
			</div>
		</div>
		<div class="panel form">
		    <h2 class="cap">Select Deck</h2>
    		<div class="content">
    		    List of decks here
    		    <!-- Buttons -->
				<div class="non-label-section">
				    <p class="button medium disabled" id="fakesave">Save</p>
				    <input type="button" id="save" class="button medium blue" value="Save" style="display:none" />
					<a href="index.php?do=admin" class="button medium">Cancel</a>
				</div>
    		</div>
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
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.0/themes/base/jquery-ui.css" type="text/css" media="all" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
<?php if(!isset($edit_event_id)){$edit_event_id=0;} ?>
<script type="text/javascript">//<![CDATA[
    $(document).ready(function() {
    var formChanged = false;
    var baseurl = "<?php echo BASE_URL; ?>";
    var edit_event = <?php echo($edit_event_id);?>;
    var owner = <?php echo $_SESSION['user']->id;?>;
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
          }
    });
    $( "#endpicker" ).datepicker({
      dateFormat: 'dd/mm/yy',
      altField: '#end',
      beforeShow: customRange,
      altFormat: '@',
      onSelect: function(dateText, inst) {
         milsToSecs($(this),$('#end'));
        }
    });
    //start second one always from first date
    function customRange(a) {  
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
        var dstart = $.datepicker.parseDate('@', '<?php if(isset($edit_event)){echo($edit_event->start);}?>000');
        var dend = $.datepicker.parseDate('@', '<?php if(isset($edit_event)){echo($edit_event->end);}?>000');
        $('#startpicker').datepicker('setDate', dstart);
        milsToSecs($('#startpicker'),$('#start'));
        $('#endpicker').datepicker('setDate', dend);
         milsToSecs($('#endpicker'),$('#end'));
    } else{
        var action = 'controller=api&action=event/post&owner='+owner;
        $('#startpicker').datepicker('setDate', new Date());
        milsToSecs($('#startpicker'),$('#start'));
    }
    
    $("#event").validate({
        rules: { name: "required", startpicker:"required"},
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
    
    //automatically apend url on name change TODO: no need for this can add on save
    $('#name').keyup(function () {
     var value = $(this).val();
     $('#url').val(baseurl + value);
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
         //alert(action+'&'+$("#event").serialize());    
          $.post('includes/callAPI.php', action+'&'+$("#event").serialize(), function(data) {
                       displayAlertMessage(data);
           }).error(function() { alert("There was an error saving your event, please try again later."); })
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