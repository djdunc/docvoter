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
    		      <?php if(!isset($_SESSION['user']->id)){?>
    		    <div class="pad-r">
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
    		    </div>
    		    
    		    <?php } elseif(($event->allow_anon && !isset($event->end)) || ($event->allow_anon && ($event->end >= time()))){ ?>
    		         <h3>Survey</h3>
            		    <div class="panel form">
            		         <span class="message"></span>
            		        <div class="content no-cap">
            		            <?php require_once(SURVEY_PATH.'/survey_sample.php');?>
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
                                   <!-- <input type="submit" name="login" id="login" value="Login" class="button blue" /> --> 
                               </form>
                               </div>
                              </div>
                        <?php } ?>	
    		</div>
	    </div>
</div>
<!-- END CONTAINER -->