  <!--Used Water Points Log view created for displaying log by Pranali for SMC-4087 on 17-10-19-->
   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="container-fluid">
		<div class="block-header" align='center'>
                <h2>Used Water Points Log</h2>
        </div>
            
            <div class="row clearfix">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<label class="col-sm-3" for="water_point">Select Type:</label>
				<div class="col-sm-9"> 
					<select name="water_points" id="water_point" class="form-control" required />
						
						<option value="1">Coupon</option>
						<option value="2">Shared Points</option>
						<option value="3">Assigned Points</option>
						
						
					</select>
				</div>
			
				<div id="log_div1" class="scroll"></div>
				<div id= "onload_div1" class="scroll" >
                    <table id="example" class="table table-striped table-invers  table-bordered table-responsive table-dark" style="border:none;" align="center" role="grid" aria-describedby="example_info">
						<thead class="thead-dark">
							<tr>
							  <th>Sr. No.</th>
							  <th>Coupon Code</th>
			                  <th>Amount</th>
			                  <th>Issue Date</th>
                 			  <th>Validity Date</th>
							</tr>
					    </thead>
					    <tbody>
						
							<?php
							  $i=1;
							 
							  foreach($used_water_log as $uwl){
								 
								  ?>
								<tr>
								  <td><?php echo $i++;?></td>
								  <td><?php echo $uwl['coupon_id']; ?></td>
								  <td><?php echo $uwl['amount']; ?></td>
								  <td><?php echo date('Y/m/d', strtotime($uwl['issue_date'])); ?></td>
								  <td><?php echo date('Y/m/d', strtotime($uwl['validity_date'])); ?></td>
								</tr>
							<?php } ?>
							
						</tbody>
					</table> 
				</div>
                <!-- #END# Browser Usage -->
				</div>
			</div>
		</div>
    </div>
	<head>
			<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/validation.js"></script>
			<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/ajax.js" /></script>
			<script>
					document.getElementById("mylogs").className += "active";
					document.getElementById("used_water").className += "active";
			</script>
	</head>