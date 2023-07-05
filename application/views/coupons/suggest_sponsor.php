<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
</head>
<style>
sup{
	color:red;
}
</style>
<div class='panel panel-default'>
	<div class='panel-heading'>
	Suggest New Sponsor
	</div>
	<div class='panel-body'>
		<?php 
			echo form_open('Ccoupon/suggest_sponsor'); 
		?>  
		<div class="col-sm-6">
			<div class="form-group">
				<label for="name">Sponsor Name : <sup>*</sup></label>
				<input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name'); ?>" placeholder='Sponsor Name'>	
				<?php echo form_error('name',  '<div class="error">', '</div>'); ?>
			</div>
			
			<div class="form-group">
				<label for="company">Company Name : <sup>*</sup></label>
				<input type="company" class="form-control" name="company" id="company" placeholder="Company Name" value="<?php echo set_value('company'); ?>">	
				<?php echo form_error('company',  '<div class="error">', '</div>'); ?>
			</div>

			<div class="form-group" >
				<label for="product_type">Sponsor Category / Type : <sup>*</sup></label>
				<select class="form-control btn-sm" name="cat" id="cat">
					<option value=''>Select</option>
					<?php foreach ($categories as $key => $value): ?>						 	
					<option value="<?php echo $categories[$key]->id; ?>" <?php if($catsel==$categories[$key]->id){ echo 'selected';} ?> <?php echo set_select('cat', $categories[$key]->id); ?>><?php echo $categories[$key]->category; ?></option>
					<?php endforeach; ?>  
				</select>
				<?php echo form_error('cat',  '<div class="error">', '</div>'); ?>
			</div>
			<!--Author VaibhavG
			here I've been added country code field for Ticket Number SMC-3262 10Sept2018 7:40PM
			-->
			<div class="form-group">
				<label>Country Code<sup>*</sup></label>
				<select class="form-control btn-sm SMCselect2" name="countryCode" id="code">
					<option value=''>Select</option>
					<?php foreach ($countrycode as $key => $value): ?>
					<option value="<?php echo $countrycode[$key]->calling_code; ?>">
						<?php echo "+".$countrycode[$key]->calling_code; ?>
					</option>
					<?php endforeach; ?>  
				</select>
				<?php echo form_error('countryCode',  '<div class="error">', '</div>'); ?>
			</div>
			<div class="form-group">
				<label for="phone_number">Phone Number : <sup>*</sup></label>
				<input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Phone Number" 
				value="<?php echo set_value('phone_number'); ?>">	
				<?php echo form_error('phone_number',  '<div class="error">', '</div>'); ?>
			</div>
			
			<div class="form-group">
				<label for="email">Email ID : </label>
				<input type="email" class="form-control" name="email" id="email"  value="<?php echo set_value('email'); ?>" placeholder="Email ID">	
				<?php echo form_error('email',  '<div class="error">', '</div>'); ?>
			</div>			  
		</div>
		<!-- right side start -->
								 
		<div class="col-sm-6">
			<div class="form-group">
				<label>Sponsor Address<sup></sup></label>
				<input type='hidden' name='country' id='country' value='<?=$userinfo[0]->country; ?>'>					
				<input type='hidden' name='lat' id='lat' value=''>					
				<input type='hidden' name='lon' id='lon' value=''>					

				<div class="row">
				<!--col-md-6 done by Pranali for bug SMC-3376 -->
					<div class="col-md-6" >
						<label>State:<sup>*</sup></label>
						<select class="form-control" id="state" name="state" >	
						<option value="" disabled selected>State</option>
						<?php foreach ($states as $key => $value): ?>						 	
						<option value="<?php echo $states[$key]->state; ?>" <?php if($statesel==$states[$key]->state){ echo 'selected';} ?> ><?php echo $states[$key]->state; ?></option>
						<?php endforeach; ?>
						</select>
						<?php echo form_error('state',  '<div class="error">', '</div>'); ?>
					</div>

					<div class="col-md-6" >
			<!-- changes end-->					
						<label>City:<sup>*</sup></label>
						<select class="form-control" id="city" name="city"> 
						<option value=""  selected>City</option>
						<?php foreach ($cities as $key => $value): ?>						 	
						<option value="<?php echo $cities[$key]->sub_district; ?>" <?php if($citysel==$cities[$key]->sub_district){ echo 'selected';} ?> ><?php echo $cities[$key]->sub_district; ?></option>
						<?php endforeach; ?>
						</select>
						<?php echo form_error('city',  '<div class="error">', '</div>'); ?>
					</div>
				</div>	
			</div>

			<div class="form-group">
				<label>Address:<sup>*</sup></label>
				<textarea class="form-control" rows="3" name="vendor_address" id="vendor_address" value='<?php echo set_value('vendor_address'); ?>' placeholder="Address goes here..." > </textarea>	
				<?php echo form_error('vendor_address',  '<div class="error">', '</div>'); ?>
			</div> 
			<div class="form-group" style="margin-top: 250px;margin-left: -510px;">
				<?php
					$js = 'onClick="getLocation()"';
					echo form_checkbox('iscurrent', 'current', FALSE, $js)."   I am at sponsors.";
				?>
			</div> 
			<div class="form-group">
				<!-- <input type="Submit" name="submit" class="btn btn-success btn-sm"  value="Suggest"/> 
				<a href="<?php echo base_url("Ccoupon/suggested_sponsors");?>"><button type="b utton" class="btn btn-danger btn-sm">Cancel</button></a> -->
			</div> 
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form1" style="text-align: left;margin-top: 0px;margin-left: -485px;">
		<label for="sponsor_survey" style="margin-left: -40px;">Sponsor Survey</label>
				 
	<label for="current_marketing">Current Marketing</label>
<table>
	<tr>
		<td>
	<label>Newspaper</label>
</td>
<td>&nbsp;
	<input type="radio" id='newspaper' name='newspaper' value='0' required="required"> Yes</td>
<td >
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='newspaper1' name='newspaper' value='1' required="required"> No
</td>
<td>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='newspaper2' name='newspaper' value='2' required="required"> Skip
	</td>
	</tr>
	<tr>
	<td>	
	<label>Just Dial</label></td>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td style="margin-left: 30px;">&nbsp;&nbsp;<input type="radio" id='justdial' name='justdial' value='0' required="required"> Yes</td>
	<td>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='justdial1' name='justdial' value='1' required="required"> No
</td>
<td>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='justdial2' name='justdial' value='2' required="required"> Skip
</td>
</tr>
<tr>
	<td>
		
	<label>Inserts</label></td>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td style="margin-left: 30px;">&nbsp;&nbsp;<input type="radio" id='inserts' name='inserts' value='0' required="required"> Yes
	</td>
	
<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='inserts1' name='inserts' value='1' required="required"> No
</td> 
<td>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='inserts2' name='inserts' value='2' required="required"> Skip
</td>
</tr>
<tr>
	<td>
		
	<label>Monthly Budgets</label></td>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<td style="margin-left: 30px;">&nbsp;&nbsp;<input type="radio" id='monthly_budgets' name='monthly_budgets' value='0' required="required"> Yes</td>
	<td>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='monthly_budgets1' name='monthly_budgets' value='1' required="required"> No
</td>
<td>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='monthly_budgets2' name='monthly_budgets' value='2' required="required"> Skip
		</td>
	</tr>
</table><br/>
		
		<label for="digital_marketing" style="margin-left: -40px;">Digital Marketing</label><br/>
		<table>
			<tr>
				<td><label>Website</label></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='website' name='website' value='0' required="required"> Yes</td>

	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='website1' name='website' value='1' required="required"> No</td>

	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='website2' name='website' value='2' required="required"> Skip</td>
</tr>
<tr>
	<td><label>Facebook</label></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='facebook' name='facebook' value='0' required="required"> Yes</td>
	<td>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='facebook1' name='facebook' value='1' required="required"> No</td>
	<td>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='facebook2' name='facebook' value='2' required="required"> Skip</td>
</tr>
	<tr>
		<td>
	<label>Twitter</label></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='twitter' name='twitter' value='0' required="required"> Yes</td>

	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='twitter1' name='twitter' value='1' required="required"> No</td>

	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='twitter2' name='twitter' value='2' required="required"> Skip</td>
		</tr>
		<tr>
	<td><label>Zomato</label></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='zomato' name='zomato' value='0' required="required" style="margin-left: 50px;"> Yes</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='zomato1' name='zomato' value='1' required="required"> No</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='zomato2' name='zomato' value='2' required="required"> Skip</td>
</tr>
	<tr>	
	<td><label>Food Panda</label></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='food_panda' name='food_panda' value='0' required="required"> Yes</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='food_panda1' name='food_panda' value='1' required="required"> No</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='food_panda2' name='food_panda' value='2' required="required"> Skip</td>
	</tr>
	<tr>
	<td>	
	<label>Swiggy</label></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='swiggy' name='swiggy' value='0' required="required"> Yes</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='swiggy1' name='swiggy' value='1' required="required"> No</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='swiggy2' name='swiggy' value='2' required="required"> Skip</td>
</tr>
	<tr>
	<td><label>Own App</label></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='own_app' name='own_app' value='0' required="required"> Yes<br/></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='own_app1' name='own_app' value='1' required="required"> No<br/></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='own_app2' name='own_app' value='2' required="required"> Skip</td>
	</tr>
</table><br/>
	<label for="discount_coupons" style="margin-left: -40px;">Discount Coupons</label><br/>
	<table>
		<tr>
			<td>
	<label>Own Coupons</label></td>
	<td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='own_coupons' name='own_coupons' value='0' required="required"> Yes</td>

	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='own_coupons1' name='own_coupons' value='1' required="required"> No</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='own_coupons2' name='own_coupons' value='2' required="required"> Skip</td>
		</tr>
		<tr>
	<td><label>Coupon Dunia</label></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='coupon_dunia' name='coupon_dunia' value='0' required="required"> Yes</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='coupon_dunia1' name='coupon_dunia' value='1' required="required"> No</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='coupon_dunia2' name='coupon_dunia' value='2' required="required"> Skip</td>
</tr>
<tr>
	<td>
	<label>Freecharge</label></td>
	<td style="margin-left: 38px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='freecharge' name='freecharge' value='0' required="required"> Yes</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='freecharge1' name='freecharge' value='1' required="required"> No</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='freecharge2' name='freecharge' value='2' required="required"> Skip</td>
</tr>
</table>
	<table>
		<tr>
			<td>
	<label for="bill_boards" style="margin-left: -40px;display: inline;">Bill Boards at Store?</label>
	</td>
			<td>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='bill_boards' name='bill_boards' value='0' required="required"> Yes</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='bill_boards1' name='bill_boards' value='1' required="required"> No</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='bill_boards2' name='bill_boards' value='2' required="required"> Skip
	</td><br/>
	</tr>
</table>
	<table>
		<tr>
<td><br/>
	<label for="call" style="margin-left: -40px;">Should we call and offer<br/> our marketing services?</label>
</td>

			<td>
	&nbsp;<input type="radio" id='call' name='call' value='0' required="required"> Yes</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='call1' name='call' value='1' required="required"> No</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='call2' name='call' value='2' required="required"> Skip</td></tr>
</table>
	<span class='error'><?php  if(isset($error)){echo $error;}else{}?></span><br/>
					<input type="Submit" name="submit" class="btn btn-success btn-sm" value="Suggest"/> 
					<input type="reset" value="Cancel" class='btn btn-danger btn-sm' onclick="return Ccoupon/suggested_sponsors(); "/>
				<!-- <a href="<?php //echo base_url("Ccoupon/suggested_sponsors");?>"><button type="button" class="btn btn-danger btn-sm">Cancel</button></a> -->
					
				</div>
						 
					</div>
				  </div>

		</div>  						   
	<!--</form>  -->
	<?php echo form_close(); ?>
	</div>	
</div>
<script>
$(document).ready(function(){ 

//getLocation();

$("#state").change(function(){
		var state=$(this).val();
		var country=$("#country").val();
		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>" + "Ccoupon/country_state_city",
			dataType: 'text',
			data: { country: country, state: state},
			success: function(res) {
				if (res)
				{
					//alert(res);
 					obj = JSON && JSON.parse(res) || $.parseJSON(res);
					$("#city").empty();
						$.each(obj, function () {
							$.each(this, function (name, value) {
								//console.log(name + '=' + value);
									$('#city')
									 .append($("<option></option>")
									 .attr("value",value)
									 .text(value));
									
							});
						});
					//positionError();					}
				}
			}
});

});
	
});
</script>
<script>
	   function valid()  
       {
			var regx1=/^[A-z ]+$/;
			var regx2=/^[0-9]+$/;
			//var regx3=;

			var vendor_name=document.getElementById("name").value; 
			if(vendor_name==null||vendor_name==""){
				document.getElementById('errorname').innerHTML='Enter sponsor name.';
				return false;
			}else{
				document.getElementById('errorname').innerHTML='';
			}
			
			
			var vendor_address=document.getElementById("vendor_address").value;
			if (vendor_address== null || vendor_address == ""){
				document.getElementById('errorvendor_address').innerHTML='Please enter sponsor address.';
				return false;
			}else{
				document.getElementById('errorvendor_address').innerHTML='';
			}
			
			var product_type=document.getElementById("cat").value;
			if (product_type== null || product_type == ""){
				document.getElementById('errorproduct_type').innerHTML='Please select category.';
				return false;
			}else{
				document.getElementById('errorproduct_type').innerHTML='';
			}
			
			var phone_number=document.getElementById("phone_number").value;
			
			if (phone_number== null || phone_number == ""){
				document.getElementById('errorphone_number').innerHTML='Please enter phone number.';
				return false;
			}else{
				document.getElementById('errorphone_number').innerHTML='';
			}
			
			if(!regx2.test(phone_number)){
				document.getElementById('errorphone_number').innerHTML='Please enter valid phone number.';
				return false;
			}else{
				document.getElementById('errorphone_number').innerHTML="";
			}

 }
</script>
<script>
$(document).ready(function(){ 
	getLocation();
});

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, positionError);
    } else {
        positionError();
    }
}

function showPosition(position){
	document.getElementById('lat').value=position.coords.latitude;
	document.getElementById('lon').value=position.coords.longitude;	
}
function positionError(position){
	document.getElementById('lat').value='';
	document.getElementById('lon').value='';	
}
$(document).ready(function(){
     $('.SMCselect2').select2({
    
     });
    });

</script>