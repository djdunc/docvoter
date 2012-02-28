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