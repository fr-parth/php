<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
    <div class="container-fluid">
	<div align="center" class="block-header"><h4>Suggest New Sponsor</h4></div>
		<div class="row clearfix">
				<div id="invisible">
				<head>
					<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/validation.js"></script>
					<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/ajax.js" /></script>
					<script>
						document.getElementById("sponsors").className += " active";
						document.getElementById("suggestSpons").className += " active";
					</script>
				</head>
			</div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<form method="post" action=" " >	
				<input type="hidden" name="lat" id="lat">
				<input type="hidden" name="lon" id="lon">
				<input type="hidden" name="timezone" id="timezone">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="form1">
							<label class="control-label" for="sponsorName">Sponsor Name:</label>
							<div class="">
							  <input type="text" class="form-control" maxlength="40" name="sponsorName" id="sponsorName" placeholder="Enter Sponsor Name" required>
							  <?php echo form_error('sponsorName', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
						</div>
						<div class="form1">
							<label class="control-label " for="companyName">Shop Name:</label>
							<div class="">
							  <input type="text" class="form-control" maxlength="50" name="companyName" id="companyName" placeholder="Enter Shop Name" required>
							  <?php echo form_error('companyName', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
						</div>
						<div class="form1">
							<label class="control-label" for="category">Category:</label>
							<div class="">
							  <select class="form-control" name="category" id="categories" required>
							  <option value="">Select Category</option>
								<?php
									foreach($categories as $category){
										echo "<option value='$category->id'>$category->category</option>";
									}
								?>
							  </select>
							  <?php echo form_error('category', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
						</div>
						<div class="form1">
							<label class="control-label" for="emailId">Email Id:</label>
							<div class=""> 
							  <input type="email" class="form-control" maxlength="35" name="emailId" id="emailId" placeholder="Enter Email Id" required>
							  <?php echo form_error('emailId', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
							</div>
						<div class="form1">
							<label class="control-label " for="phoneNumber">Phone Number:</label>
							<div class=""> 
							  <input type="number" class="form-control" name="phoneNumber" id="phoneNumber" placeholder="Enter Phone Number" required>
							  <?php echo form_error('phoneNumber', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
						</div>
						<div class="form1">
							<label class="control-label" for="country">Country:</label>
							<div class="">
							  <select class="form-control" name="country_id" name="country_id" id="country_id" required>
							  <option value="">Select Country</option>
								<?php
									foreach($country as $cont){
										echo "<option value='$cont->country'>$cont->country</option>";
									}
								?>
							  </select>
							  <?php echo form_error('country_id', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
						</div>
						<div class="form1">
							<label class="control-label" for="state">State:</label>
							<div class="">
							  <select class="form-control" name="state" id="states" required>
								<option value="">Select State</option>
							  </select>
							  <?php echo form_error('state', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
						</div>
						<div class="form1">
							<label class="control-label" for="city">City:</label>
							<div class="">
							  <select class="form-control" name="city" id="cities" required>
								<option value="">Select City</option>
							  </select>
							  <?php echo form_error('city', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
						</div>
						
						<div class="form1">
							<label class="control-label" for="address">Address:</label>
							<div class="">
							  <textarea class="form-control" name="address" id="address" required>  </textarea>
							  <?php echo form_error('address', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
						</div>
							
						<div class="form1" style="margin-top: 100px;margin-left: -452px;">
							<label class="col-sm-5" for="schoolName" style="margin-top: 0px;">I am at sponsors:</label>
							<div class="col-sm-2">
								  <input type="checkbox" class="form-control" name="iscurrent" id="iscurrent" onclick="return getLocation()" style="width:20px;height: 20px;margin-left: -50px;margin-top: -2px;"></input>  
							</div>
						</div>
						
							 <div class="form1">
							<!--<button  class="myButton" onclick="javascript:history.go(-1);">Back</button>-->
							  <!-- <button type="submit" name="submit" class="myButton form2" value="Submit" onclick="return suggest_sponsor();">Submit</button> -->
							</div>
							
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form1" style="text-align: left;margin-top: 125px;margin-left: -410px;">
		<label for="sponsor_survey" style="margin-left: -40px;">Sponsor Survey</label>
				 
	<label for="current_marketing">Current Marketing</label><br/>
<table>
	<tr>
		<td>
	<label>Newspaper</label>
</td>
<td>
	<input type="radio" id='newspaper' name='newspaper' value='0' style="margin-left: 50px;" required="required"> Yes</td>
<td >
	&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='newspaper1' name='newspaper' value='1' required="required"> No
</td>
<td>
	&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='newspaper2' name='newspaper' value='2' required="required"> Skip
	</td>
	</tr>
	<tr>
	<td>	
	<label>Just Dial</label></td>
	<td>
	<input type="radio" id='justdial' name='justdial' value='0' required="required" style="margin-left: 50px;"> Yes</td>
	<td>
	&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='justdial1' name='justdial' value='1' required="required"> No
</td>
<td>
	&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='justdial2' name='justdial' value='2' required="required"> Skip
</td>
</tr>
<tr>
	<td>
		
	<label>Inserts</label></td>
	<td><input type="radio" id='inserts' name='inserts' value='0' required="required" style="margin-left: 50px;"> Yes
	</td>
	
<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='inserts1' name='inserts' value='1' required="required"> No
</td>
<td>
	&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='inserts2' name='inserts' value='2' required="required"> Skip
</td>
</tr>
<tr>
	<td>
		
	<label>Monthly Budgets</label></td>
	<td><input type="radio" id='monthly_budgets' name='monthly_budgets' value='0' required="required" style="margin-left: 50px;"> Yes</td>
	<td>
	&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='monthly_budgets1' name='monthly_budgets' value='1' required="required"> No
</td>
<td>
	&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='monthly_budgets2' name='monthly_budgets' value='2' required="required"> Skip
		</td>
	</tr>
</table>
		
		<label for="digital_marketing" style="margin-left: -40px;">Digital Marketing</label><br/>
		<table>
			<tr>
				<td><label>Website</label></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='website' name='website' value='0' required="required" style="margin-left: 70px;"> Yes</td>

	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='website1' name='website' value='1' required="required"> No</td>

	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='website2' name='website' value='2' required="required"> Skip</td>
</tr>
<tr>
	<td><label>Facebook</label></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='facebook' name='facebook' value='0' required="required" style="margin-left: 70px;"> Yes</td>
	<td>
	&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='facebook1' name='facebook' value='1' required="required"> No</td>
	<td>
	&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='facebook2' name='facebook' value='2' required="required"> Skip</td>
</tr>
	<tr>
		<td>
	<label>Twitter</label></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='twitter' name='twitter' value='0' style="margin-left: 70px;" required="required"> Yes</td>

	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='twitter1' name='twitter' value='1' required="required"> No</td>

	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='twitter2' name='twitter' value='2' required="required"> Skip</td>
		</tr>
		<tr>
	<td><label>Zomato</label></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='zomato' name='zomato' value='0' required="required" style="margin-left: 70px;"> Yes</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='zomato1' name='zomato' value='1' required="required"> No</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='zomato2' name='zomato' value='2' required="required"> Skip</td>
</tr>
	<tr>	
	<td><label>Food Panda</label></td>
	<td> &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='food_panda' name='food_panda' value='0' required="required" style="margin-left: 70px;"> Yes</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='food_panda1' name='food_panda' value='1' required="required"> No</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='food_panda2' name='food_panda' value='2' required="required"> Skip</td>
	</tr>
	<tr>
	<td>	
	<label>Swiggy</label></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='swiggy' name='swiggy' value='0' required="required" style="margin-left: 70px;"> Yes</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='swiggy1' name='swiggy' value='1' required="required"> No</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='swiggy2' name='swiggy' value='2' required="required"> Skip</td>
</tr>
	<tr>
	<td><label>Own App</label></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='own_app' name='own_app' value='0' required="required" style="margin-left: 70px;"> Yes</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='own_app1' name='own_app' value='1' required="required"> No</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='own_app2' name='own_app' value='2' required="required"> Skip</td>
	</tr>
</table>
	<label for="discount_coupons" style="margin-left: -40px;">Discount Coupons</label><br/>
	<table>
		<tr>
			<td>
	<label>Own Coupons</label></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='own_coupons' name='own_coupons' value='0' required="required" style="margin-left: 55px;"> Yes</td>

	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='own_coupons1' name='own_coupons' value='1' required="required"> No</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='own_coupons2' name='own_coupons' value='2' required="required"> Skip</td>
		</tr>
		<tr>
	<td><label>Coupon Dunia</label></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='coupon_dunia' name='coupon_dunia' value='0' required="required" style="margin-left: 55px;"> Yes</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='coupon_dunia1' name='coupon_dunia' value='1' required="required"> No</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='coupon_dunia2' name='coupon_dunia' value='2' required="required"> Skip</td>
</tr>
<tr>
	<td>
	<label>Freecharge</label></td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='freecharge' name='freecharge' value='0' required="required" style="margin-left: 55px;"> Yes</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='freecharge1' name='freecharge' value='1' required="required"> No</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='freecharge2' name='freecharge' value='2' required="required"> Skip</td>
</tr>
</table>
	<table>
		<tr>
			<td>
	<label for="bill_boards" style="margin-left: -40px;display: inline;">Bill Boards at Store?</label>
	</td>
			<td>
	&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='bill_boards' name='bill_boards' value='0' required="required" style="margin-left: 55px;"> Yes</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='bill_boards1' name='bill_boards' value='1' required="required"> No</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='bill_boards2' name='bill_boards' value='2' required="required"> Skip
	</td>
	</tr>
</table>
	<table>
		<tr>
<td>
	<label for="call" style="margin-left: -40px;display: inline;">Should we call and offer<br/> <p style="margin-left: -40px;">our marketing services?</p></label>
</td>
	<td ><input type="radio" id='call' name='call' value='0' style="margin-left: 45px;" required="required"> Yes</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id='call1' name='call' value='1' required="required"> No</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;<label ></label><input type="radio" id='call2' name='call' value='2' required="required"> Skip</td></tr>
</table>
	<span class='error'><?php  if(isset($error)){echo $error;}else{}?></span><br/>
					<!-- <input id="editID" type="hidden" name="editID" value="<?php //echo set_value('editID'); ?>"  /> -->
					<input id="submit" type="submit" name="submit" class="btn btn-success form2" value="Submit" onclick="return suggest_sponsor();">
					<?php //echo form_submit('submit', 'Submit',"class='btn btn-success submit'"); ?> &nbsp; <input type="reset" value="Cancel" class='btn btn-warning' onclick="return suggest_sponsor(); "/>
				</div>
						</div>

					</div>

				</form>
			</div>

		</div>
	</div>
</div>
		
	
			<!-- </>			 
					</div>
				  </div>
				</div>
			</form>
		</div>
	</div> -->
<!-- </div> -->

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jstimezonedetect/1.0.4/jstz.min.js">
</script>
<script type="text/javascript">
  $(document).ready(function(){
    var tz = jstz.determine(); // Determines the time zone of the browser client
    var timezone = tz.name(); //'Asia/Kolkata' for Indian Time.
	$('#timezone').val(timezone);
  });
</script>

<script>
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, positionError);
    } else {
        positionError();
    }
}

function showPosition(position){
	if(document.getElementById('iscurrent').checked == true)
	{
		document.getElementById('lat').value=position.coords.latitude;
		document.getElementById('lon').value=position.coords.longitude;	
	}
}
function positionError(position){
	document.getElementById('lat').value='';
	document.getElementById('lon').value='';	
}
</script>