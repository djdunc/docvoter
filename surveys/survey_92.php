<form id="survey" class="styled">
	<fieldset>
	    <!-- Text Field -->
		<label class="align-left">
			<span>Profession<strong class="red"></strong></span>
			<input class="textbox l required editable" name="profession" id="profession" type="text" value="" />
		</label>
		
		<!-- Text Field -->
		<label class="align-left m" for="Gender">
			<span>Gender<strong class="red"></strong></span>
			<select class="chosen" name="Gender" id="Gender">  
			      <option value="">Select one...</option>
                  <option value="Male" >Male</option>
                  <option value="Female" >Female</option>
			</select>
		</label>
		
		<!-- Drop-down -->
		<label class="align-left m" for="age">
			<span>Age<strong class="red"></strong></span>
			<select class="chosen" name="age" id="age">  
			      <option value="">Select one...</option>
                  <option value="0" >18-21</option>
                  <option value="1" >22-25</option>
                  <option value="2" >26-30</option>

                  <option value="3" >31-40</option>
                  <option value="4" >41-50</option>
                  <option value="5" >51-60</option>
                  <option value="6" >61 or over</option>
			</select>
		</label>
		
		<!-- Text Area -->
		<label class="align-left" for="textArea">
			<span>Comments</span>
			<textarea class="textarea l editable" name="comments" id="comments" rows="2" cols="1"></textarea>
		</label>
		
		<!-- Button do not change ID - used to save form data -->
		<div class="non-label-section">
		        <input type="button" id="send-survey" class="button medium blue" value="Start voting" />
		</div>
	</fieldset>
</form>