<?php if(is('admin') || is('owner', $edit_deck )) {
    $editable = true;
}else{
    $editable = false;
}?>

<!-- BEGIN PAGE BREADCRUMBS/TITLE -->
<div class="container_4">
	<div id="page-heading" class="clearfix">
	    <div class="grid-wrap">
    		<div class="grid_2 title-crumbs">
    		       <h2>Deck details</h2>
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
						    <?php if($editable) {?>
						     <p class="button medium disabled" id="fakesave">Save</p>
						    <input type="button" id="save" class="button medium blue" value="Save" style="display:none" />
							<a href="index.php?do=admin" class="button medium">Cancel</a>
							<?php  }else{?>
						    <p class="button medium disabled">Only owner can edit</p>
						    <?php }?>
						</div>
					
					</fieldset>
				</form>
			</div>
		</div>
		 <div class="accordion">
		<h3>Deck cards</h3>
		<?php foreach($steep as $cat_id=>$cat_name): ?>
		<div class="accordion-block">
		    <h3 class="category <?php echo $cat_name?>-b"><?php echo $cat_name?></h3>
		    <div class="lod" style="display:none">includes/callAPI.php?action=card/get&category_id=<?php echo $cat_id?>&owner=1</div>
		</div>        
		<?php endforeach; ?>
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
<!--	Load the "Chosen" stylesheet. -->
<link rel="stylesheet" href="assets/js/chosen/chosen.css" type="text/css" media="screen" />
<!--	Load the Chosen script.-->
<script src="assets/js/chosen/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
<?php if(!isset($edit_deck_id)){$edit_deck_id=0;} ?>
<script type="text/javascript">//<![CDATA[                                     
    $(document).ready(function() {
    var formChanged = false;
    var baseurl = "<?php echo BASE_URL; ?>";
    var edit_deck = <?php echo($edit_deck_id);?>;
    var owner = <?php echo $_SESSION['user']->id;?>;
    var deck_card_ids = "<?php echo $deck_card_ids;?>";
    var editable = "<?php echo $editable; ?>";
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

    $('.accordion-block .category').click(function(){
        var $placeholder = $(this).next();
        if($placeholder.hasClass('lod')) {
            $.ajax({
                url: $placeholder.html().replace(/&amp;/g,'&'),
                success: function(data){
                    var data; try { data = $.parseJSON(data); } catch (err) { data = data; }
                    //build markup
                    var cards = "";
                    for(var index in data) {
                    	var id = data[index].id;
                    	if (editable){
                    	    var checked = deck_card_ids.match(new RegExp("^"+id+",|,"+id+",|,"+id+"$")) ? "checked='checked'" : "";
                            cards += "<span class='list-col'><label><input type='checkbox' id='"+id+"' value='"+data[index].name+"' "+checked+" /> "+data[index].name+"</label></span>";
                    	} else{
                    	    if (deck_card_ids.match(new RegExp("^"+id+",|,"+id+",|,"+id+"$")) ){
                    	        cards += "<span class='list-col'>"+data[index].name+"</span>";
                    	    }
                    	}
                    }
                    //replace lod placeholder with markup 
                    $placeholder.replaceWith("<div class='cards'>"+cards+"</div>");
                },
                error: function(data){ /*alert(data);*/ }
            });
            $placeholder.html("<div class='content'><img src='assets/images/indicator.gif' /> loading cards...</div>");
        }
        $(this).toggleClass('open');
        $(this).next().toggle();
    });

    $('.accordion-block :checkbox').live('click',function(){
        addremove(this);
    });
    
});

    function addremove(card) {
        var query_url;
        if($(card).is(':checked')) {
            //add deckcard entry
        	query_url = "includes/callAPI.php?action=deckcard/post&deck_id=<?php echo $edit_deck_id;?>&card_id="+$(card).attr('id');
        } else {
            //delete deckcard entry
        	query_url = "includes/callAPI.php?action=deckcard/delete&deck_id=<?php echo $edit_deck_id;?>&card_id="+$(card).attr('id');
        }
        $.ajax({
            url: query_url,
            success: function(data){/*uhm ... it worked*/},
            error: function(data){/*... it didn't*/}
        });
    }

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