<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script type="text/javascript">
/* <![CDATA[ */
var formChanged = false;
var baseurl = "<?php echo BASE_URL.'index.php?event='.$event->id; ?>";
$(document).ready(function() {
    var validator = $("#pass").validate({ 
         rules: { 
            password: "required", 
    },
    errorElement: "span",
     messages: {
         password: "Code required",	
    },
    
       debug:true
    });
    
    
    //bind save button
    $("#enter").click(function() {
      if($("#pass").valid()){
         window.location.href = baseurl+'&pass='+$("#password").val();
      }
     return false;
    });
    
   });

   function handleFormChanged() {
        formChanged = true;
   }

    /* ]]> */
</script>
<!-- BEGIN PAGE BREADCRUMBS/TITLE -->
<div class="container_4">
	<div id="page-heading" class="clearfix">
	        <div class="grid-wrap">
    		<div class="grid_2 title-crumbs">
    		       <h1>Private event</h1>
    		       <p>This event is by invitation only, 
    		       <?php if (get('pass')){
    		           echo('please enter correct event code below.');
    		       } else{
    		           echo('please enter the event code below.');
    		       }?>
    		       <p>
    		    </p>
    		</div>
    		<div class="grid_2 align_right">	
    		</div>
	</div>
</div>
</div>
<div class="container_4">
<div class="grid-wrap">
	<!-- BEGIN FORM STYLING -->
	<div class="grid_2">
		<div class="panel form">
		    <span class="message"></span>
			<div class="content no-cap">
			    <form method="post" action="" name="pass" id="pass" class="styled login">   
			    <fieldset>
    			 <!-- Text Field -->
                    <!-- Text Field -->
					<label class="align-left" for="username">
						<span>Event code<strong class="red">*</strong></span>
						<input class="textbox required editable" name="password" id="password" type="text" value="" />
					</label>
					<!-- Buttons -->
					<div class="non-label-section">
					    <div class="buttons">
					    <input type="submit" id="enter" class="button medium blue" value="Enter" />
					    </div>
					</div>
                    <!-- <input type="submit" name="login" id="login" value="Login" class="button blue" /> --> 
                </form>
                </div>
</div>
</div>
</div>
</div>