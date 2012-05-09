<?php //var_dump($event); ?>
<!-- BEGIN HOMEPAGE -->
<div class="container_4">
	    <div class="grid-wrap m-top" class="clearfix">
    		<?php if(!isset($_SESSION['user']->id)){ echo('<div class="grid_3b">'); } else{ echo('<div class="grid_3">');}?>
    		    <?php if (isset($event->description)&&$event->description!=''){?>
    		    <div class="pad-r">
    		       <?php echo nl2br($event->description) ?>
    		     </div>
    		    <?php } ?>
    		    
    		    
    		    <?php if (!isset($_SESSION['survey'])){
    		    if((isset($_SESSION['user']->id) && $event->allow_anon && !isset($event->end)) || (isset($_SESSION['user']->id) && $event->allow_anon && ($event->end >= time()))){ ?>
    		         <h3>Survey</h3>
            		    <div class="panel form">
            		         <span class="message"></span>
            		        <div class="content no-cap">
            		            <?php
                                $survey_path = "";
                                if(is_readable(SURVEY_PATH."/survey_$event->id.php")) {
                                  $survey_path = SURVEY_PATH."/survey_$event->id.php";
                                } else {
                                  $survey_path = SURVEY_PATH."/survey_sample.php";
                                }
                                require_once($survey_path);
                                ?>
            		       </div>
            		     </div>
            	 <?php } 
            	 } ?>
    		    
    		</div>
    		<?php if(!isset($_SESSION['user']->id)){ echo('<div class="grid_1b">'); } else{ echo('<div class="grid_1">');}?>
    		    <?php if(!isset($_SESSION['user']->id)){?>
    			  <h3>Sign in to vote</h3>
    		       	<div class="panel form">
               		    <span class="message"></span>
               			<div class="content no-cap">
               			    <form method="post" action="" name="loginform" id="loginform" class="styled login">   
               			    <fieldset>
                   			 <!-- Text Field -->
                                   <!-- Text Field -->
               					<label class="align-left" for="username">
               						<span>Username<strong class="red">*</strong></span>
               						<input class="textbox required editable" name="username" id="username" type="text" value="" />
               					</label>
               					<!-- Text Field -->
               					<label class="align-left" for="password">
               						<span>Password<strong class="red">*</strong></span>
               						<input class="textbox required editable" name="password" id="password" type="password" value="" />
               					</label>
               						<!-- Buttons -->
               						<div class="non-label-section">
               						    <div class="buttons">
               						    <input type="submit" id="login" class="button medium blue" value="Login" />
               						    </div>
               						</div>
               						 <br /><br />
            					<p id="account_set">Don't have an account yet?, <a href="index.php?do=register">click here to sign up</a>.</p>
                               </form>
                               </div>
                              </div>
                        <?php } ?>	
    		</div>
	    </div>
</div>
<!-- END CONTAINER -->
<!--	Load the "Chosen" stylesheet. -->
<link rel="stylesheet" href="assets/js/chosen/chosen.css" type="text/css" media="screen" />
<!--	Load the Chosen script.-->
<script src="assets/js/chosen/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
<script type="text/javascript">
/* <![CDATA[ */
var formChanged = false;
var baseurl = "<?php echo BASE_URL; ?>";
var ref = "<?php if ($event->allow_anon){ echo('do=about&event='.$event->id); } else { echo ('do=vote&event='.$event->id);} ?>";
var action = 'controller=user&action=get&';
var event_id = '<?php echo $event->id;?>';
$(document).ready(function() {
    $("#loginform").validate({ 
         rules: { 
            username: "required", 
            password: "required", 
    },
    errorElement: "span",
     messages: {
     	 username: "Username required", 
         password: "Password required",	
    }
    });
    
   // if something is edited, show save button, and display alert on page leave
   $('#loginform .editable').bind('change paste', function() {
           handleFormChanged();
      });
    
    //bind save button
    $("#login").click(function() {
      if($("#loginform").valid()){
          $('#login').hide();
          $(".buttons").append("<div id=\"indicator\"><img src=\"assets/images/indicator.gif\" /></div>")
          $.post('includes/load_login.php', action+$("#loginform").serialize(), function(data) {
              try {
                  var user = jQuery.parseJSON(data);
                  window.location.href = baseurl+"index.php?"+ref;
              } catch (err) {
            	  displayAlertMessage("Error:"+data);//todo display real json error
                  $('#login').show();
                  $('#indicator').remove();
              }
            }).error(function() { displayAlertMessage("Bad username/password combination"); }, "json")
      }
      return false;
    });
    
    //bind survey button if available
      $("#send-survey").click(function() {
          $.post('includes/save_survey.php?event_id='+event_id, $("#survey").serialize(), function(data) {
                if (data==''){
                   window.location.href = baseurl+'index.php?do=vote&event='+event_id;
                }
              }).error(function() { displayAlertMessage("There was an error saving your data, please try again later."); })
            return false;
      });

    
   });
   

   function handleFormChanged() {
        formChanged = true;
   }

    /* ]]> */
</script>