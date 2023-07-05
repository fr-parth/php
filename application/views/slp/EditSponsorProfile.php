<?php
/*
Author : Pranali Dalvi
This file is created for Editing Sponsor's profile and get verified it from Sponsor
Date : 13-12-2018
*/
 $this->load->view('slp/header');
?>

<!DOCTYPE html>
<html>
<body onLoad="return modal_input_hide()">

<script>

var x = document.getElementByClass("edit");

function getLocation() {
	
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    x.innerHTML = "Latitude: " + position.coords.latitude + 
    "<br>Longitude: " + position.coords.longitude;
	
	
}
</script>

</body>
</html>

<style>
.required, .error{
	color:red;
}

label {
    
    color: black;
	font-weight:bold;
    
}
.warning {background-color: #ff9800;} /* Orange */
</style>
	<div class="panel panel-violet">
		<div class="panel-heading">
		<h2 class="panel-title"><strong>Edit Sponsor Profile</strong></h2>
		</div>
		<div class="panel-body">
	<!--span  class="label warning">Verified</span-->
	<div class='row'>	
	<div class='col-md-8'>	
			<?php $attributes = array('id' => $id);
			echo form_open('Csalesperson/EditSponsorProfile/'.$id); ?>

			<table class="table table-hover">
			<tr>
				<td>
					<label for="sponsor_name">Sponsor Name <span class="required">*</span></label>
				</td>
				<td>
				
				<!--required in input tags removed by Pranali for bug SMC-2262  -->
					<input id="sponsor_name" type="text" class='form-control' name="sponsor_name" maxlength="50" value="<?php echo $sponsor_details[0]->sp_name; ?>" />
					<?php echo form_error('sponsor_name'); ?>							
				</td>
				</tr>
				<td>
					<label for="sp_company">Company Name <span class="required">*</span></label>
				</td>
				<td>
					<input id="sp_company" type="text" class='form-control' name="sp_company" maxlength="50" value="<?php echo $sponsor_details[0]->sp_company; ?>" />
					<?php echo form_error('sp_company'); ?>							
				</td>
			</tr>
			<tr>
				<td>
					<label for="sp_phone">Mobile <span class="required">*</span></label>
				</td>
				<td>
				<input id="sp_phone" type="text" class='form-control' name="sp_phone" maxlength="10" value="<?php echo $sponsor_details[0]->sp_phone; ?>" />
			
					<?php echo form_error('sp_phone'); ?>
				</td>
			</tr>
			<tr>
				<td>
					<label for="sp_landline">Landline</label>
				</td>
				<td>				
					
					<input id="sp_landline" type="tel" class='form-control' name="sp_landline" maxlength="20" value="<?php echo $sponsor_details[0]->sp_landline; ?>"  />
					<?php echo form_error('sp_landline'); ?>
					
				</td>
			</tr>
			<tr>
				<td>
					<label for="sp_email">Email <span class="error">*</span></label>
				</td>
				<td>						
					<!--type="text" done for email by Pranali for bug SMC-2262 -->
					
					<input id="sp_email" type="text" class='form-control' name="sp_email" value="<?php echo $sponsor_details[0]->sp_email; ?>"  />
					<?php echo form_error('sp_email'); ?>
				</td>
			</tr>
		
			<tr>
				<td>
					<label for="sp_website">Website</label>
				</td>
				<td>					
					<input id="sp_website" type="url" class='form-control' name="sp_website" maxlength="60" value="<?php echo $sponsor_details[0]->sp_website; ?>"  />
					<?php echo form_error('sp_website'); ?>
				</td>
			</tr>
			<tr>
				<td>
					<label for="sp_address">Address <span class="required">*</span></label>
				</td>
				<td>					
				<?php echo form_textarea( array( 'name' => 'sp_address', 
												'rows' => '5', 
												'cols' => '80', 
												'value' => $sponsor_details[0]->sp_address,			
												'class' => 'form-control'	
				) )?>
				<?php echo form_error('sp_address'); ?>
				</td>
			</tr>
			<tr>
				<td>
					<label for="sp_pin">Pin <span  class="required">*</span></label>
				</td>
				<td>
				<input id="sp_pin" type="tel" class='form-control' name="sp_pin" maxlength="6" value="<?php echo $sponsor_details[0]->pin; ?>" />
			
					<?php echo form_error('sp_pin'); ?>
				</td>
			</tr>
			
			<tr>
				<td>
					<label for="oldsp_password">Old Password <span class="required">*</span></label>
				</td>
				<td>					
					<input id="oldsp_password" type="password" class='form-control' name="oldsp_password" maxlength="20" value="<?php echo $sponsor_details[0]->sp_password; ?>" />
					<?php echo form_error('oldsp_password'); ?>
				</td>
			</tr>
				<tr>
				<td>
					<label for="sp_password">New Password <span class="required">*</span></label>
				</td>
				<td>					
					<input id="sp_password" type="password" class='form-control' name="sp_password" maxlength="20" value="<?php echo set_value('sp_password1'); ?>" />
					<?php echo form_error('sp_password'); ?>
				</td>
			</tr>
			<tr>
				<td>
					<label for="sp_password1">Confirm Password <span class="required">*</span></label>
				</td>
				<td>					
					<input id="sp_password1" type="password" class='form-control' name="sp_password1" maxlength="20" value="<?php echo set_value('sp_password1'); ?>" />
					<?php echo form_error('sp_password1'); ?>
				</td>
			</tr>
								
			<tr>
				<td>
					<label for="image">Profile Image </label>
				</td>
				<td>					
					<input id="image" type="file" class='form-control' name="image" value="<?php echo set_value('image'); ?>"  />
					<br/><small>Max Image Size 100KB, image Width X Height should be less than 1024 X 900 pixels.</small>
					<?php echo form_error('image'); ?>
				</td>
			</tr>
			
		<!--	<tr id="discount">
				<td>
					<label for="discount">Discount</label>
				</td>
				<td>
					<div class='row'>
						<div class='col-md-6'>
						<div class="input-group">
							<input id="discount" type="number" class='form-control' name="discount"  min='0' max='100' value="?php echo $sponsor_details[0]->discount; ?>" placeholder='Discount' />
							?php echo form_error('discount'); ?>
						<span class="input-group-addon" id="basic-addon2">%</span>
						</div>
						</div>
						<div class='col-md-6'>
							<input id="points" type="number" class='form-control' name="points"  min='0' value="?php 
							echo $sponsor_details[0]->points_per_product; ?>" placeholder='Points' />
							?php echo form_error('points'); ?>
						</div>
					</div>
				</td>
			</tr>

			<tr id="revenue">
				<td>
					<label for="revenue_percent">Revenue Share<span class="required">*</span></label>
				</td>
				<td>
					<div class='row'>
						<div class='col-md-6'>
						<div class="input-group">
							<input id="revenue_percent" type="number" class='form-control' name="revenue_percent"  min='0' max='100' value="?php echo $sponsor_details[0]->revenue_percent; ?>" placeholder='Revenue' />
							?php echo form_error('revenue_percent'); ?>
						<span class="input-group-addon" id="basic-addon2">%</span>
						</div>
						</div>
						<div class='col-md-6'>
							<input id="revenue_per_visit" type="number" class='form-control' name="revenue_per_visit"  min='0' value="?php echo $sponsor_details[0]->revenue_per_visit; ?>" placeholder='Revenue Per Visit' />
							?php echo form_error('revenue_per_visit'); ?>
						</div>
					</div>
				</td>
			</tr>
		
			<!--changes end for SMC-3678 by Pranali
			
			<tr>
				<td>
					<label for="product_image">Product Image </label>
				</td>
				<td>					
					<input id="product_image" type="file" class='form-control' name="product_image" value="<?php echo set_value('product_image'); ?>"  />
					<br/><small>Max Image Size 100KB, image Width X Height should be less than 1024 X 900 pixels.</small>
					<?php echo form_error('product_image'); ?>
				</td>
			</tr>-->
			
			<tr>
				<td>
				
				</td>
				<td><span class='error'><?php  if(isset($error)){echo $error;}else{}?></span><br/>
					
					<?php echo form_submit('edit', 'Edit',"class='btn btn-success submit'"); ?> &nbsp; <input type="reset" value="Reset" class='btn btn-warning'/>
				</td>
			</tr>
			
			</table>				
	
	
		</div>
		</div>
		</div>
	</div>

<?php echo form_close(); ?>
