<h3>Create a new Account</h3>
    <div class="panel form">
	    <span class="message"></span>
		<div class="content no-cap">
		    <form id="register" class="styled">
				<fieldset>
				    <!-- Text Field -->
					<label class="align-left" for="name">
						<span>First name</span>
						<input class="textbox m editable" name="first_name" id="first_name" type="text" value="" />
					</label>
					<!-- Text Field -->
					<label class="align-left" for="name">
						<span>Last name</span>
						<input class="textbox m editable" name="last_name" id="last_name" type="text" value="" />
					</label>
					<!-- Text Field -->
					<label class="align-left" for="username">
						<span>Email address<strong class="red">*</strong></span>
						<input class="textbox m editable" name="email" id="email" type="text" value="" />
					</label>
					<!-- Text Field -->
					<label class="align-left" for="password">
						<span>Password<strong class="red">*</strong></span>
						<input class="textbox required editable" name="password" id="password" type="password" value="" />
					</label>
					<!-- Text Field -->
					<label class="align-left" for="name">
						<span>Confirm password<strong class="red">*</strong></span>
						<input class="textbox required editable" name="password_confirm" id="password_confirm" type="password" value="" />
					</label>
					<!-- Buttons -->
					<div class="non-label-section" id="save_btns">
					    <p class="button medium disabled" id="fakesave">Register</p>
					    <input type="submit" id="save" class="button medium blue" value="Register" style="display:none" />
					    <a href="index.php" class="button medium">Cancel</a>
					</div>

				</fieldset>
			</form>
		</form>
	  </div>
</div>
<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script type="text/javascript">
/* <![CDATA[ */
var formChanged = false;
var baseurl = "<?php echo BASE_URL; ?>";
var action = 'controller=user&action=post&';
$(document).ready(function() {
    var validator = $("#register").validate({ 
         rules: { 
            firstname: "required", 
            lastname: "required", 
            username: { 
                required: true,
                email:true, 
                 remote: {
                     url:baseurl+'includes/username_unique.php',
                     type: 'post',
                 }
            },
            password: { 
                required: true, 
                minlength: 5 
            }, 
            password_confirm: { 
                required: true, 
                minlength: 5, 
                equalTo: "#password" 
            },
            email:{
                email:true
            }
    },
     messages: {
     			password_confirm: {
     				required: " ",
     				equalTo: "Please enter the same password as above"	
     			},
     			email: {
     				required: "Email is required",
     				remote: "That email is already in use."
     			}
    },
           // debug:true
     
     
    });
    
   // if something is edited, show save button, and display alert on page leave
   $('#register .editable').bind('change paste', function() {
           handleFormChanged();
      });
    
    //bind save button
    $("#save").click(function() {
      if($("#register").valid()){
          $(window).unbind("beforeunload");
          $("#fakesave").html("Sending...").show();
          $("#save").hide();
          if($("#email").val()!=''){
              var fields = $($("#register")[0].elements).not("#password_confirm").serialize();
          }else{
              var fields = $($("#register")[0].elements).not("#email").serialize();
          }  
           $.post('includes/load.php', action+fields+'username='$('#email').val(), function(data) {
               displayAlertMessage(data);
            var user = eval(jQuery.parseJSON(data));
               if(user.username){
                   window.location.href = baseurl+"index.php?do=login";
              } else{
                    displayAlertMessage(data);
            }
           }).error(function() { alert("error"); }, "json")
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
    /* ]]> */
</script>