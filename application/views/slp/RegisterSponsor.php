<?php $this->load->view('slp/header'); ?>

<!DOCTYPE html>
<html>
<body onLoad="return modal_input_hide()">

<script>
//changes for SMC-2266
$(document).ready(function(){
	$('#p_mode').on('change', function() {
		if ( this.value == 'Free Register')
		{
			$("#amounttr").hide();
		}
		else if ( this.value == 'By Cheque')
		{
			$("#amounttr").show();
		}
		else if ( this.value == 'By Cash')
		{
			$("#amounttr").show();
		}
		else
		{
			$("#amounttr").show();
		}
	});
});
//changes end

function modal_input_hide()
{
	document.getElementById("sp_callback_date").style.visibility='hidden';
	document.getElementById("sp_callback_time").style.visibility='hidden';
	document.getElementById("sp_callback_date_lbl").style.visibility='hidden';
	document.getElementById("sp_callback_time_lbl").style.visibility='hidden';
	
	return false;
}
function modal_callback_date_time(e)
{
	if(document.getElementById("modal_callback_date").value=="")
	{
		document.getElementById("sp_callback_date").style.required=true;
	}
	if(document.getElementById("modal_callback_time").value=="")
	{
		document.getElementById("sp_callback_time").style.required=true;
	}
	document.getElementById("sp_callback_date").style.visibility='visible';
	document.getElementById("sp_callback_time").style.visibility='visible';
	document.getElementById("sp_callback_date_lbl").style.visibility='visible';
	document.getElementById("sp_callback_time_lbl").style.visibility='visible';
	
	var mod_date=document.getElementById("modal_callback_date").value;
	var mod_time=document.getElementById("modal_callback_time").value;
	var sp_date=document.getElementById("sp_callback_date");
	sp_date.value = mod_date;
	var sp_time=document.getElementById("sp_callback_time");
	sp_time.value = mod_time;
	
	return false;
}

var x = document.getElementByClass("submit");

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

<script>
$(document).ready(function(){
	$("#sp_country").change(function(){
		var cntr=$(this).val();
		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>" + "Csalesperson/country_state",
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
			url: "<?php echo base_url(); ?>" + "Csalesperson/country_state_city",
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
	});
</script>



<style>
.required, .error{
	color:red;
}

label {
    
    color: black;
	font-weight:bold;
    
}
</style>
	<div class="panel panel-violet">
		<div class="panel-heading">
		<h2 class="panel-title"><strong>Register Sponsor</strong></h2>
		</div>
		<div class="panel-body">
	
	<div class='row'>	
	<div class='col-md-8'>	
			<?php $attributes = array('id' => '');
			echo form_open('Csalesperson/RegisterSponsor', $attributes); ?>

			<table class="table table-hover">
			<tr>
				<td>
					<label for="sponsor_name">Sponsor Name <span class="required">*</span></label>
				</td>
				<td>
				<!--required in input tags removed by Pranali for bug SMC-2262  -->
					<input id="sponsor_name" type="text" class='form-control' name="sponsor_name" maxlength="50" value="<?php echo set_value('sponsor_name'); ?>" />
					<?php echo form_error('sponsor_name'); ?>							
				</td>
				</tr>
				<td>
					<label for="sp_company">Company Name <span class="required">*</span></label>
				</td>
				<td>
					<input id="sp_company" type="text" class='form-control' name="sp_company" maxlength="50" value="<?php echo set_value('sp_company'); ?>" />
					<?php echo form_error('sp_company'); ?>							
				</td>
			</tr>
			<tr>
				<td>
					<label for="sp_phone">Mobile <span class="required">*</span></label>
				</td>
				<td>
				<input id="sp_phone" type="text" class='form-control' name="sp_phone" maxlength="10" value="<?php echo set_value('sp_phone'); ?>">
			
					<?php echo form_error('sp_phone'); ?>
				</td>
			</tr>
			<tr>
				<td>
					<label for="sp_landline">Landline</label>
				</td>
				<td>				
					
					<input id="sp_landline" type="tel" class='form-control' name="sp_landline" maxlength="20" value="<?php echo set_value('sp_landline'); ?>"  />
					<?php echo form_error('sp_landline'); ?>
					
				</td>
			</tr>
			<tr>
				<td>
					<label for="sp_email">Email <span class="required">*</span></label>
				</td>
				<td>						
					<!--type="text" done for email by Pranali for bug SMC-2262 -->
					
					<input id="sp_email" type="text" class='form-control' name="sp_email" value="<?php echo set_value('sp_email'); ?>">
					<?php echo form_error('sp_email'); ?>
				</td>
			</tr>
			<tr>
				<td>
					<label for="v_category">Product Category <span class="required">*</span></label>
				</td>
				<td>		
									
						<?php 
						$cats=array();
						$cats['']='Please Select Category';	
						foreach ($categories as $key => $value){						 	
									$cats[$value->id]=$value->category;					
									
						} ?>				

					<?php echo form_dropdown('v_category', $cats, set_value('v_category'),'class="form-control" id="v_category" ')?>
					<?php echo form_error('v_category'); ?>	
				</td>
			</tr>
			<tr>
				<td>
					<label for="sp_website">Website</label>
				</td>
				<td>					
					<input id="sp_website" type="url" class='form-control' name="sp_website" maxlength="60" value="<?php echo set_value('sp_website'); ?>"  />
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
												'value' => set_value('sp_address'),			
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
				<input id="sp_pin" type="tel" class='form-control' name="sp_pin" maxlength="6" value="<?php echo set_value('sp_pin'); ?>" />
			
					<?php echo form_error('sp_pin'); ?>
				</td>
			</tr>
			<tr>
				<td>
					
				</td>
				<td class="text-capitalize">
						<div class="row">							
						  <div class="col-md-4">
					<label for="sp_country">Country <span class="required">*</span></label>
									
					<?php // Change the values in this array to populate your dropdown as required ?>
						<?php 
						$cntry=array();
						$cntry['']='Select';	
						foreach ($countries as $key => $value){						 	
									$cntry[$value->country]=$value->country;					
									
						} 
						?>	
					<br /><?php echo form_dropdown('sp_country', $cntry, set_value('sp_country'),'class="form-control" id="sp_country" ')?>
							<?php echo form_error('sp_country'); ?>	
						 </div> 
						 
							<div class="col-md-4">
					<label for="sp_state">State <span class="required">*</span></label>			
					
					<?php // Change the values in this array to populate your dropdown as required ?>
					<?php 
					$states=array();
					
					if(uri_string()=='Csalesperson/page/RegisterSponsor'){						
						$options=array();
						$options[]='Select';
						foreach ($states as $key => $value){
							$options[$value->state]=$value->state;	
						}
					}else{
						$options = array(
										  ''  => '',
										);
					}												
					//$state_merge = array_merge($options,$states);
					//print_r($state_merge);exit;
					?>	
																	
					<br /><?php echo form_dropdown('sp_state', $options, set_value('sp_state'),'class="form-control" id="sp_state"')?>
						<?php echo form_error('sp_state'); ?>
							</div>
						   <div class="col-md-4">
					<label for="sp_city">City <span class="required">*</span></label>
					
					
					<?php // Change the values in this array to populate your dropdown as required ?>
					<?php 	
					$cities = array();
					if(uri_string()=='Csalesperson/page/RegisterSponsor'){						
						$options1=array();
							$options1[]='Select';	
						
						foreach ($cities as $key => $value){
							$options1[$value->sub_district]=$value->sub_district;
						}
					}else{
						$options1 = array(''  => '');
					}	?>
					<br /><?php echo form_dropdown('sp_city', $options1, set_value('sp_city'),'class="form-control" id="sp_city"')?>
					<?php echo form_error('sp_city'); ?>
							</div>
						  </div>

						  <div class="clearfix"></div>
				</td>
			</tr>
			<tr>
				<td>
					<label for="sp_password">Password <span class="required">*</span></label>
				</td>
				<td>					
					<input id="sp_password" type="password" class='form-control' name="sp_password" maxlength="20" value="<?php echo set_value('sp_password'); ?>" />
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
			<tr>
				<td>
					<label for="v_status">Select Status<span class="required">*</span></label>
				</td>
				<td>


					<!-- <?php  
					// echo form_dropdown('v_status', $v_stat, set_value('v_status'),'class="form-control" id="v_status" ')
					//if($v_stat['Suggested']==Selected)
						//data-toggle="modal" data-target="#myModal"
					?> -->
					
				<select name="v_status" class="form-control" id="v_status">
				<option value="" selected="selected">Please Select Status</option>
				<option value="Active">Interested</option>
				<option value="Inactive">Not Interested</option>
				<option value="Suggested">Call Back/Come Later</option>
				</select>

					<?php echo form_error('v_status'); ?>
					<label id="sp_callback_date_lbl">You Choose Date:</label><input type="text" readonly id="sp_callback_date" name="sp_callback_date"><br>
					<label id="sp_callback_time_lbl">You Set Time:</label><input type="text" readonly id="sp_callback_time" name="sp_callback_time">
				</td>
			</tr>
			<!-- attribute "id" added for all tr by Pranali for bug SMC-2269 -->
			<tr id="pm">
				<td>
					<label for="p_mode">Payment Mode</label>
				</td>
				<td>
						<?php 
						$cost=false;
						$p_mode=array(
							''=>'Please Select Payment Mode',
							'Free Register'=>'Free Register',
							'Cheque'=>'By Cheque',
							'Cash'=>'By Cash'					
						);
						
						 ?>				

					<?php echo form_dropdown('p_mode', $p_mode, set_value('p_mode'),'class="form-control" id="p_mode" ')?>
					<?php echo form_error('p_mode'); ?>	
				</td>
			</tr>
			
			<tr id="amounttr">
				<td>
					<label for="amount">Registration Cost</label>
				</td>
				<td>					
					<input id="amount" type="number" class='form-control' name="amount"  min='0' value="<?php echo set_value('amount'); ?>"  />
					<?php echo form_error('amount'); ?>
				</td>
			</tr>
			<tr id="source">
				<td>
					<label for="source">Source</label>
				</td>
				<td>
					<input id="source" type="text" class='form-control' name="source" maxlength="60" value="<?php echo set_value('source'); ?>"/>
                   
                    <?php echo form_error('source'); ?>
                    
				</td>
			</tr>
			<tr id="comment">
				<td>
					<label for="source">Comment</label>
				</td>
				<td>
					<input id="comment" type="text" class='form-control' name="comment" maxlength="60" value="<?php echo set_value('comment'); ?>"/>
                   
                    <?php echo form_error('comment'); ?>
                    
				</td>
			</tr>
			
			
			
			
			<tr id="discount">
				<td>
					<label for="discount">Discount<span class="required">*</span></label>
				</td>
				<td>
					<div class='row'>
						<div class='col-md-6'>
						<div class="input-group">
							<input id="discount" type="number" class='form-control' name="discount"  min='0' max='100' value="<?php echo set_value('discount'); ?>" placeholder='Discount' />
							<?php echo form_error('discount'); ?>
						<span class="input-group-addon" id="basic-addon2">%</span>
						</div>
						</div>
						<div class='col-md-6'>
							<input id="points" type="number" class='form-control' name="points"  min='0' value="<?php echo set_value('points'); ?>" placeholder='Points' />
							<?php echo form_error('points'); ?>
						</div>
					</div>
				</td>
			</tr>
<!--Revenue Percent , Revenue Per Visit & Social Availability added by Pranali for SMC-3678-->
			<tr id="revenue">
				<td>
					<label for="revenue_percent">Revenue Share<span class="required">*</span></label>
				</td>
				<td>
					<div class='row'>
						<div class='col-md-6'>
						<div class="input-group">
							<input id="revenue_percent" type="number" class='form-control' name="revenue_percent"  min='0' max='100' value="<?php echo set_value('revenue_percent'); ?>" placeholder='Revenue' />
							<?php echo form_error('revenue_percent'); ?>
						<span class="input-group-addon" id="basic-addon2">%</span>
						</div>
						</div>
						<div class='col-md-6'>
							<input id="revenue_per_visit" type="number" class='form-control' name="revenue_per_visit"  min='0' value="<?php echo set_value('revenue_per_visit'); ?>" placeholder='Revenue Per Visit' />
							<?php echo form_error('revenue_per_visit'); ?>
						</div>
					</div>
				</td>
			</tr>
	<!--Sponsor Survey added by Pranali for SMC-3678 on 11-12-2018-->
			<tr><td>
					<label for="sponsor_survey">Sponsor Survey</label>
				</td> 
	<td><label for="current_marketing">Current Marketing</label><br/>

	<label>Newspaper</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='newspaper' name='newspaper' value='0'>&nbsp;<label>Yes</label>
	<input type="radio" id='newspaper1' name='newspaper' value='1'>&nbsp;<label>No</label>
	<input type="radio" id='newspaper2' name='newspaper' value='2' checked="checked">&nbsp;<label>Skip</label><br/>
		
	<label>Just Dial</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='justdial' name='justdial' value='0'>&nbsp;<label>Yes</label>
	<input type="radio" id='justdial1' name='justdial' value='1'>&nbsp;<label>No</label>
	<input type="radio" id='justdial2' name='justdial' value='2' checked="checked">&nbsp;<label>Skip</label><br/>
		
	<label>Inserts</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='inserts' name='inserts' value='0'>&nbsp;<label>Yes</label>
	<input type="radio" id='inserts1' name='inserts' value='1'>&nbsp;<label>No</label>
	<input type="radio" id='inserts2' name='inserts' value='2' checked="checked">&nbsp;<label>Skip</label><br/>
		
	<label>Monthly Budgets</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='monthly_budgets' name='monthly_budgets' value='0'>&nbsp;<label>Yes</label>
	<input type="radio" id='monthly_budgets1' name='monthly_budgets' value='1'>&nbsp;<label>No</label>
	<input type="radio" id='monthly_budgets2' name='monthly_budgets' value='2' checked="checked">&nbsp;<label>Skip</label><br/><br/>
		
		
		<label for="digital_marketing">Digital Marketing</label><br/>
		
		<label>Website</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='website' name='website' value='0'>&nbsp;<label>Yes</label>
	<input type="radio" id='website1' name='website' value='1'>&nbsp;<label>No</label>
	<input type="radio" id='website2' name='website' value='2' checked="checked">&nbsp;<label>Skip</label><br/>
		
	<label>Facebook</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='facebook' name='facebook' value='0'>&nbsp;<label>Yes</label>
	<input type="radio" id='facebook1' name='facebook' value='1'>&nbsp;<label>No</label>
	<input type="radio" id='facebook2' name='facebook' value='2' checked="checked">&nbsp;<label>Skip</label><br/>
	
	<label>Twitter</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='twitter' name='twitter' value='0'>&nbsp;<label>Yes</label>
	<input type="radio" id='twitter1' name='twitter' value='1'>&nbsp;<label>No</label>
	<input type="radio" id='twitter2' name='twitter' value='2' checked="checked">&nbsp;<label>Skip</label><br/>
		
	<label>Zomato</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='zomato' name='zomato' value='0'>&nbsp;<label>Yes</label>
	<input type="radio" id='zomato1' name='zomato' value='1'>&nbsp;<label>No</label>
	<input type="radio" id='zomato2' name='zomato' value='2' checked="checked">&nbsp;<label>Skip</label><br/>
		
	<label>Food Panda</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='food_panda' name='food_panda' value='0'>&nbsp;<label>Yes</label>
	<input type="radio" id='food_panda1' name='food_panda' value='1'>&nbsp;<label>No</label>
	<input type="radio" id='food_panda2' name='food_panda' value='2' checked="checked">&nbsp;<label>Skip</label><br/>
		
	<label>Swiggy</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='swiggy' name='swiggy' value='0'>&nbsp;<label>Yes</label>
	<input type="radio" id='swiggy1' name='swiggy' value='1'>&nbsp;<label>No</label>
	<input type="radio" id='swiggy2' name='swiggy' value='2' checked="checked">&nbsp;<label>Skip</label><br/>
	
	<label>Own App</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='own_app' name='own_app' value='0'>&nbsp;<label>Yes</label>
	<input type="radio" id='own_app1' name='own_app' value='1'>&nbsp;<label>No</label>
	<input type="radio" id='own_app2' name='own_app' value='2' checked="checked">&nbsp;<label>Skip</label><br/><br/>
	
	<label for="discount_coupons">Discount Coupons</label><br/>
	
	<label>Own Coupons</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='own_coupons' name='own_coupons' value='0'>&nbsp;<label>Yes</label>
	<input type="radio" id='own_coupons1' name='own_coupons' value='1'>&nbsp;<label>No</label>
	<input type="radio" id='own_coupons2' name='own_coupons' value='2' checked="checked">&nbsp;<label>Skip</label><br/>
		
	<label>Coupon Dunia</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='coupon_dunia' name='coupon_dunia' value='0'>&nbsp;<label>Yes</label>
	<input type="radio" id='coupon_dunia1' name='coupon_dunia' value='1'>&nbsp;<label>No</label>
	<input type="radio" id='coupon_dunia2' name='coupon_dunia' value='2' checked="checked">&nbsp;<label>Skip</label><br/>
	
	<label>Freecharge</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='freecharge' name='freecharge' value='0'>&nbsp;<label>Yes</label>
	<input type="radio" id='freecharge1' name='freecharge' value='1'>&nbsp;<label>No</label>
	<input type="radio" id='freecharge2' name='freecharge' value='2' checked="checked">&nbsp;<label>Skip</label><br/><br/>
	
	<label for="bill_boards">Bill Boards at Store?</label>
	
	<input type="radio" id='bill_boards' name='bill_boards' value='0'>&nbsp;<label>Yes</label>
	<input type="radio" id='bill_boards1' name='bill_boards' value='1'>&nbsp;<label>No</label>
	<input type="radio" id='bill_boards2' name='bill_boards' value='2' checked="checked">&nbsp;<label>Skip</label><br/><br/>
	
	<label for="call">Should we call and offer our marketing services?</label>
	
	<input type="radio" id='call' name='call' value='0'>&nbsp;<label>Yes</label>
	<input type="radio" id='call1' name='call' value='1'>&nbsp;<label>No</label>
	<input type="radio" id='call2' name='call' value='2' checked="checked">&nbsp;<label>Skip</label><br/><br/>
	
		</tr>
		
		
			<!--changes end for SMC-3678 by Pranali-->
			
			<!--<tr>
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
					<input id="editID" type="hidden" name="editID" value="<?php echo set_value('editID'); ?>"  />
					<?php echo form_submit('submit', 'Submit',"class='btn btn-success submit'"); ?> &nbsp; 
					<a href="http://localhost.smartcookie.in/Csalesperson/RegisterSponsor">
					 <input type="reset" value="Reset"  class='btn btn-warning' /> </a>
				</td>
			</tr>
			
			</table>				
	
	
		</div>
		</div>
		</div>
	</div>
	
	<!--Call back pop-up-->
	<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Set Callback Alert</h4>
      </div>
      <div class="modal-body">
		<label for="discount">Choose Callback Date:-</label>
        <input type="date" class='form-control' name="modal_callback_date" id="modal_callback_date"/>
		<label for="discount">Choose Callback Time:-</label>
        <input type="time" class='form-control' name="modal_callback_time" id="modal_callback_time"/>
      </div>
      <div class="modal-footer">
        <input type="button" class="btn btn-default" data-dismiss="modal" onClick="return modal_callback_date_time()" value="set date-time"/>
      </div>     
    </div>
	
  </div>
</div>

<?php echo form_close(); ?>
<script>
$("#v_status").on("change", function () {        
    $modal = $('#myModal');
    if($(this).val() === 'Suggested'){
        $modal.modal('show');
		//changes done by Pranali for bug SMC-2269 
		$("#pm").show();
		$("#amounttr").show();
		$("#source").show();
		$("#comment").show();
		$("#discount").show();
    }
	
	else if($(this).val() === 'Inactive'){
		$("#pm").hide();
		$("#amounttr").hide();
		$("#source").hide();
		$("#comment").hide();
		$("#discount").hide();
		
	}
	
	else {
		$("#pm").show();
		$("#amounttr").show();
		$("#source").show();
		$("#comment").show();
		$("#discount").show();
	}
	//changes end
});


</script>