<?php //var_dump($event); ?>
<!-- BEGIN HOMEPAGE -->
<div class="container_4">
	    <div class="grid-wrap m-top" class="clearfix">
    		<div class="grid_3">
    		    <?php if (isset($event->description)&&$event->description!=''){?>
    		    <div class="pad-r">
    		       <?php echo nl2br($event->description) ?>
    		     </div>
    		    <?php } ?>
    		    
    		    
    		    <?php if(($event->allow_anon && !isset($event->end)) || ($event->allow_anon && ($event->end >= time()))){ ?>
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
            	 <?php } ?>
    		    
    		</div>
    		<div class="grid_1">
    		    <?php if(!isset($_SESSION['user']->id)){?>
    			  <h3>Sign in to vote</h3>
    		       	<div class="panel form">
               		    <span class="message"></span>
               			<div class="content no-cap">
               			    <form method="post" action="index.php?do=login&ref_query=<?php echo $ref_query; ?>" name="loginform" id="loginform" class="styled login">   
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
               						    <p class="button medium disabled" id="fakelogin">Login</p>
               						    <input type="submit" id="login" class="button medium blue" value="Login" style="display:none" />
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
<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script type="text/javascript">
/* <![CDATA[ */
var formChanged = false;
var baseurl = "<?php echo BASE_URL; ?>";
var ref = "do=vote&event=<?php echo $event->id; ?>";
var action = 'controller=user&action=get&';
$(document).ready(function() {
    var validator = $("#loginform").validate({ 
         rules: { 
            username: "required", 
            password: "required", 
    },
    errorElement: "span",
     messages: {
     	 username: "Username required", 
         password: "Password required",	
    },
    
       debug:true
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
    
   });

   function handleFormChanged() {
        $('#login').show();
        $('#fakelogin').hide();
        formChanged = true;
   }

    /* ]]> */
</script>