<script>
function getStatusRow() {
	var y = document.getElementById("sum_box");
		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>" + "/Ccoupon/getStatusRow",
			dataType: 'text',			
			success: function(res) {
				if (res)
				{
 					obj = JSON && JSON.parse(res) || $.parseJSON(res);
					y.innerHTML = res;
				}
			}
		});
}


</script>
<div id="sum_box" class="row" style="padding-bottom:0px;">
</div>
<script>
$(document).ready(function(){ 
getStatusRow();
$('#state').prop('disabled', true);
$('#city').prop('disabled', true);
$('#curr').val('1');
getLocation();

$("#state").change(function(){
		var state=$(this).val();
		var country=$("#country").val();
		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>" + "/Ccoupon/country_state_city",
			dataType: 'text',
			data: { country: country, state: state},
			success: function(res) {
				if (res)
				{
					//alert(res);
 					obj = JSON && JSON.parse(res) || $.parseJSON(res);
					$("#city").empty();
					
	//prepend() added by Pranali for bug SMC-3369
					$("#city").prepend("<option value=''>Select City</option>").val('');
						$.each(obj, function () {
							$.each(this, function (name, value) {
								//console.log(name + '=' + value);
									$('#city')
									 .append($("<option></option>")
									 .attr("value",value)
									 .text(value));
									
							});
						});
					positionError();	
				}
			}
		});
});

$("#choose_loc").click(function(){
	$("#state").attr('disabled', !$("#state").attr('disabled'));
	$("#city").attr('disabled', !$("#city").attr('disabled'));
	
	var curr = document.getElementById("curr").value;
	if($("#city").attr('disabled')){		
		$('#curr').val('1');//user can't select location		
	}else{
		$('#curr').val('0');//user can select location
	}
	if(curr=='1'){	
		getLocation();		
	}else{
		positionError();//user can select location
	}
});

$("#city").change(function(){
	positionError();
});

$("#dist").change(function(){
	var curr = document.getElementById("curr").value;
	if(curr=='1'){	
		getLocation();		
	}else{
		positionError();//user can select location
	}
});

$("#cat").change(function(){
	var curr = document.getElementById("curr").value;
	if(curr=='1'){	
		getLocation();		
	}else{
		positionError();//user can select location
	}
});

});
</script>

<div class="row" >
<div class="col-md-12" >
	<div class="col-md-3" >
	<button type="button" class="btn btn-default btn-sm active" name="choose_loc" id="choose_loc" ><strong>Current / Other Location</strong></button>
	</div>
	<input type='hidden' name='curr' id='curr' value=''>
	<input type='hidden' name='addr' id='addr' value='<?=$userinfo[0]->address; ?>'>
	<input type='hidden' name='country' id='country' value='<?=$userinfo[0]->country; ?>'>
	<div class="col-md-2" >
	<select class="form-control" id="state" name="state" style='width:150px' >
	<!--Default option "Select" option added by Pranali for bug SMC-3369 -->
			<option value="">Select State</option>
		<?php foreach ($states as $key => $value): ?>						 	
		<option value="<?php echo $states[$key]->state; ?>" <?php if($userinfo[0]->state==$states[$key]->state){ echo 'selected';} ?> ><?php echo $states[$key]->state; ?></option>
		<?php endforeach; ?>
	</select>
	</div>
	<div class="col-md-2" >
	<select class="form-control" id="city" name="city" style='width:150px'>
	<option value="">Select City</option>
		<?php foreach ($cities as $key => $value): ?>						 	
		<option value="<?php echo $cities[$key]->sub_district; ?>" <?php if($userinfo[0]->city==$cities[$key]->sub_district){ echo 'selected';} ?> ><?php echo $cities[$key]->sub_district; ?></option>
		<?php endforeach; ?>
	</select>
	</div>
	<div class="col-md-2" >
	<select class="form-control btn-sm" style="width:150px;" name="dist" id="dist"> 
	<option value="">Select Distance</option> 
		<option value="5">Distance 5 Kms</option>
		<option value="10">Distance 10 Kms</option>
		<option value="30">Distance 30 Kms</option>
		<option value="50">Distance 50 Kms</option>
		<option value="70">Distance 70 Kms</option>
		<option value="100">Distance 100 Kms</option>
		<option value="200">Distance 200 Kms</option>  
	</select>
	</div>
	<div class="col-md-2" >
	<select class="form-control btn-sm" style="width:150px;"  name="cat" id="cat">	
	<option value="">Select Category</option> 	
	<!-- changes end -->

		<?php foreach ($categories as $key => $value): ?>	

		<!--ucwords() added by Pranali for bug SMC-3370 --> 
		
		<option value="<?php echo ucwords($categories[$key]->id); ?>"><?php echo ucwords($categories[$key]->category); ?></option>

		<?php endforeach; ?>  
	</select>		
	</div>
</div>
</div>
