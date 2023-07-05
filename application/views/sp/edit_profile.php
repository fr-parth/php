<?php $this->load->view('sp/header'); ?>

<style type="text/css">
	.dark{
		color: #11151c;
	}

</style>

<script>
$(document).ready(function(){
	$("#sp_country").change(function(){
		var cntr=$(this).val();
		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>" + "/Csponsor/country_state",
			dataType: 'text',
			data: { country: cntr},
			success: function(res) {
				if (res)
				{
					//alert(res);
 					obj = JSON && JSON.parse(res) || $.parseJSON(res);
					$("#sp_state").empty();
					$("#sp_city").empty();
						$.each(obj, function () {
							$.each(this, function (name, value) {
								//console.log(name + '=' + value);
									$('#sp_state')
									 .append($("<option></option>")
									 .attr("value",value)
									 .text(value));
							});
						});				

				}
			}
		});
	});

});
</script>
<script>
$(document).ready(function(){
	$("#sp_state").change(function(){
		var sp_state=$(this).val();
		var sp_country=$("#sp_country").val();
		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>" + "/Csponsor/country_state_city",
			dataType: 'text',
			data: { country: sp_country, state: sp_state},
			success: function(res) {
				if (res)
				{
					//alert(res);
 					obj = JSON && JSON.parse(res) || $.parseJSON(res);
					$("#sp_city").empty();
						$.each(obj, function () {
							$.each(this, function (name, value) {
								//console.log(name + '=' + value);
									$('#sp_city')
									 .append($("<option></option>")
									 .attr("value",value)
									 .text(value));
							});
						});
				}
			}
		});
	});	
	$('#submit_id').click(function(){
		 if( !$('#Revenue_visit').val() ) { 
		 //if it is blank.
          alert('field is empty');		 
         return false;    
         }else if(!$('#Revenue_percent').val()){
			 return false; 
			 alert('field is empty');
		 }else{
			 return true;
		 }
	});
});
</script>

	<div class="panel panel-violet">
		<div class="panel-heading">
		<h2 class="panel-title"><strong>Edit Profile</strong></h2>
		</div>
		<div class="panel-body">
			
		 <?php $attributes1 = array('id' => 'edit_prof');
		 echo form_open_multipart('Csponsor/edit_prof', $attributes1); ?>
	
			<table class="table table-hover">
			<tr>
				<td style="font-weight:bold;"  class="dark">
					Owner Name
				</td>
				<td>
					<input type="text" name="sp_name" id="sp_name" class="form-control" 
					value="<?=$myData->sp_name; ?>" >
			<?php echo form_error('sp_name', "<span style='color:red;' id='err_sp_name' >", "</span>"); ?>
				</td>
			</tr>
			<tr>
				<td style="font-weight:bold;" class="dark">
					Company Name <sup style='color: red;'>*</sup>
				</td>
				<td>
					<input type="text" name="sp_company" id="sp_company" class="form-control" 
					value="<?=$myData->sp_company; ?>" required >
			<?php echo form_error('sp_company', "<span style='color:red;' id='err_sp_company' >", "</span>"); ?>
				</td>
			</tr>
			<tr>
				<td style="font-weight:bold;" class="dark">
					Landline Number
				</td>
				<td>
					<input type="tel" name="sp_landline" id="sp_landline" class="form-control" 
					value="<?=$myData->sp_landline; ?>" >
			<?php echo form_error('sp_landline', "<span style='color:red;' id='err_sp_landline' >", "</span>"); ?>
				</td>
			</tr>
			<tr>
				<td style="font-weight:bold;" class="dark" >
					Default Product Category <sup style='color: red;'>*</sup>
				</td>
				<td>
					<select class="form-control" id="v_category" name="v_category" required > 
					<option value=''>Select Category</option>
						 <?php foreach ($categories as $key => $value): ?>						 	
                       <option value="<?php echo $categories[$key]->id; ?>" <?php if($myData->v_category==$categories[$key]->id){ echo 'selected';} ?> ><?php echo $categories[$key]->category; ?></option>
					   <?php endforeach; ?>
					</select>
				</td>
			</tr>

			<tr>
				<td style="font-weight:bold;" class="dark">
					Website
				</td>
				<td>
					<input type="url" name="sp_website" id="sp_website" class="form-control" 
					value="<?=$myData->sp_website; ?>" placeholder="http://www.yourwebsite.com">
			
				<?php echo form_error('sp_website', "<span style='color:red;' id='sp_website' >", "</span>"); ?>	
				</td>
			</tr>

			<tr>
				<td style="font-weight:bold;" class="dark">
					Address <sup style='color: red;'>*</sup>
				</td>
				<td class="text-capitalize">
					<textarea class="form-control custom-control" rows="3" name="sp_address" id="sp_address" style="resize:none" required ><?=$myData->sp_address; ?></textarea>
					<div class="row text-danger" align="center" id='err_address' ></div>
			<?php echo form_error('sp_address', "<span style='color:red;' id='err_address' >", "</span>"); ?>
				</td>
			</tr>
			<tr>
				<td style="font-weight:bold;">
					
				</td>
				<td class="text-capitalize">
					<?php //include 'country_state_city.form.inc.php'; ?>	
						<div class="row">							
						  <div class="col-md-4">
							<select class="form-control" id="sp_country" name="sp_country" required >						
								<?php foreach ($countries as $key => $value): ?>						 	
								<option value="<?php echo $countries[$key]->country; ?>" <?php if($myData->sp_country==$countries[$key]->country){ echo 'selected';} ?> ><?php echo $countries[$key]->country; ?></option>
								<?php endforeach; ?>
							</select>	
							
						 </div> 
						 
							<div class="col-md-4">
							<select class="form-control" id="sp_state" name="sp_state" required > 							
								<?php foreach ($states as $key => $value): ?>						 	
								<option value="<?php echo $states[$key]->state; ?>" <?php if($myData->sp_state==$states[$key]->state){ echo 'selected';} ?> ><?php echo $states[$key]->state; ?></option>
								<?php endforeach; ?>
							</select>							
							</div>
						   <div class="col-md-4">
							<select class="form-control" id="sp_city" name="sp_city" required >
								<?php foreach ($cities as $key => $value): ?>						 	
								<option value="<?php echo $cities[$key]->sub_district; ?>" <?php if($myData->sp_city==$cities[$key]->sub_district){ echo 'selected';} ?> ><?php echo $cities[$key]->sub_district; ?></option>
								<?php endforeach; ?>
							</select>
							</div>
						  </div>
				<?php echo form_error('sp_country', "<span style='color:red;' id='err_sp_country' >", "</span>"); ?>
				<?php echo form_error('sp_state', "<span style='color:red;' id='err_sp_state' >", "</span>"); ?>
				<?php echo form_error('sp_city', "<span style='color:red;' id='err_sp_city' >", "</span>"); ?>
						  <div class="clearfix"></div>
				</td>
			</tr>			
			<tr>
				<td style="font-weight:bold;" class="dark">
					ZIP / PIN
				</td>
				<td class="text-capitalize">
					<input type="number" name="pin" id="pin" class="form-control" 
					value="<?=$myData->pin; ?>" onkeypress="return isNumberKey(event)"  >					
				<?php echo form_error('pin', "<span style='color:red;' id='err_pin' >", "</span>"); ?>
				</td>
			</tr>
	        <tr>
				<td style="font-weight:bold;" class="dark">
					Revenue Per Visit
				</td>
				<td class="text-capitalize">
				   <div class="row">							
						<div class="col-md-3">
						<input type="text" name="Revenue_visit"  class="form-control" id="Revenue_visit" value="<?php echo $myData->revenue_per_visit; ?>" maxlength="4" pattern="[1-9]+">
				        </div>
					</div>
				</td>
			</tr>
			<tr>
				<td style="font-weight:bold;" class="dark">
					Revenue Share Percentage
				</td>
				<td class="text-capitalize">
				     <div class="row">							
						<div class="col-md-3">
				 		<input type="text" name="Revenue_percent"  class="form-control" id="Revenue_percent" value="<?php echo $myData->revenue_percent; ?>" min="0" max="99.99"  pattern="[0-9]+(\.[0-9]{0,2})?%?" >
				        </div>
					 </div>
				</td>
			</tr>
			
			
			</table>	
<input type="submit" name="submit" class="btn btn-success btn-sm" value="Submit" /> 
<a href="<?=site_url('Csponsor/page/profile');?>" ><input type="button" value="Back" name="cancel" class="btn btn-warning btn-sm"></a>
</form>
		</div>
	</div>
