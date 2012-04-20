<form id="survey" class="styled">
	<fieldset>
	    <!-- Text Field -->
		<div class="non-label-section">
			<span>Position in industry supply chain</span>
			<label><input type="checkbox" name="Position[]" class="required editable" value="Client" /> Client</label><br />
			<label><input type="checkbox" name="Position[]" class="required editable" value="Architect" /> Architect</label><br />
			<label><input type="checkbox" name="Position[]" class="required editable" value="Engineering consultancy" /> Engineering consultancy</label><br />
			<label><input type="checkbox" name="Position[]" class="required editable" value="Construction - large contractor" /> Construction – large contractor</label><br />
			<label><input type="checkbox" name="Position[]" class="required editable" value="Construction - small contractor" /> Construction – small contractor</label><br />
			<label><input type="checkbox" name="Position[]" class="required editable" value="Facilities management" /> Supplier of construction products</label><br />
			<label><input type="checkbox" name="Position[]" class="required editable" value="Client" /> Facilities management</label><br />
			<label><input type="checkbox" name="Position[]" class="required editable" value="Public Sector" /> Public Sector</label><br />
			<label><input type="checkbox" name="Position[]" class="required editable" value="Other" /> Other</label>          
		</div>
		
		<!-- Drop-down -->
		<label class="align-left m" for="Experience">
			<span>Level of experience in the sector</span>
			<select class="chosen required editable" name="Experience" id="Experience">  
			      <option value="">Select one...</option>
                  <option value="0-4" >0–4 years</option>
                  <option value="5-9" >5–9 years</option>
                  <option value="10-14" >10–14 years</option>
                  <option value="15+" >15 years +</option>
			</select>
		</label>
		
		<!-- Button do not change ID - used to save form data -->
		<div class="non-label-section">
		        <input type="button" id="send-survey" class="button medium blue" value="Start voting" />
		</div>
	</fieldset>
</form>