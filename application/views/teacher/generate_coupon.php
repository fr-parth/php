<?php 

//print_r($myvar); 
$points_type = array('Bluepoints'=>'Blue Points','Waterpoints'=>'Water Points','Brownpoints'=>'Brown Points');
 ?>
 <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="container-fluid">
		<div class="row clearfix">
		<head>
			<script>
				document.getElementById("smartCoupon").className += " active";
				document.getElementById("genCoupon").className += " active";
			</script>
		</head>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
			<div class="scroll">
               <table class="table table-striped table-invers  table-bordered table-responsive table-dark">
				<?php echo form_open("","class=form-horizontal");?>
				<input type="hidden" name = "avail_blue" id="avail_blue" value="<?php echo $teacher_info[0]->balance_blue_points; ?>">
				<input type="hidden" name = "avail_water" id="avail_water" value="<?php echo $teacher_info[0]->water_point; ?>">
				<input type="hidden" name = "avail_brown" id="avail_brown" value="<?php echo $teacher_info[0]->brown_point; ?>">
                    <thead>
						  <tr><th colspan =6 align='center'>Generate Smart Cookie Coupon</th>
						  </tr>
						  
                    </thead>
                    <tbody>
						<tr>
						    <td>
								Select Point Type:
							</td>
							<td>			  
								<select name="points_type" id="points_type" class="form-control" required/>
									<option value="">Select Point Type</option>
									<?php  
									foreach($points_type as $key=>$val){?>
									<option value="<?php echo $key;?>"><?php echo $val;?></option>
									<?php }?>
								</select>
								<?php echo form_error('points_type', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</td>
						
						    <td>
								Select Points:
							</td>
							<td>			  
								<select name="points_values" id="points_value" class="form-control" required/>
								<option>Select Points</option>
									<!-- points come through ajax call-->									
								</select>
								<?php echo form_error('points_values', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</td>
						
							<td colspan=2 align='center'>
								<?php 
									echo form_submit('generate', 'Generate Coupon','class="myButton" onclick="return generate_coupon();"');
								?>
							</td>
						</tr>
					</tbody>
				</table>
				</div>
			</div>
			 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="block-header" align='center'>
					<h2>Generated SmartCookie Coupons</h2>
				</div>
				<div class="scroll">
                <table id="example" class="table table-striped table-invers  table-bordered table-responsive table-dark">
					<thead>
						<!--<tr>
							<th colspan=6 align='center'>Smart Cookie Coupons</th>
						</tr>-->
						<tr>
							<th>Sr No</th>
							<th>Amount</th>
							<th>Coupon Code</th>
							<th>Status</th>
							<th>Point Type</th>
							<th>Issue Date</th>
							<th>Show</th>	
						</tr>
						  
                    </thead>
                    <tbody>
						<?php
							$i=1;
							foreach($generated_coupon_details as $coupon_details){
								
								$coupon_status = ($coupon_details->status == 'p') ? 'Partial Used' : $coupon_details->status;
						?>
							<tr>
								<td><?php echo $i++; ?></td>
								<td><?php echo $coupon_details->amount; ?></td>
								<td><?php echo $coupon_details->coupon_id; ?></td>
								<td><?php echo ucfirst($coupon_status); ?></td>
								<td><?php echo ucfirst($coupon_details->used_points); ?></td>
								<td><?php echo date('Y/m/d',strtotime($coupon_details->issue_date)); ?></td>
								<td><a href="<?php echo base_url(); ?>/teachers/show_coupon/<?php echo $coupon_details->id; ?>"><input type="button" value="Show" class="myButton"></a></td>
							</tr>
							<?php } ?>
					</tbody>
				</table>
				</div>
		</div>
		</div>
</div>

<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/validation.js"></script>
<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/ajax.js" /></script>