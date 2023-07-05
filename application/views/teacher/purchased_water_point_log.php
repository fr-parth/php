<!--purchase_water_point_log created for displaying purchased water point log by Pranali for SMC-4088 on 25-10-19 -->
<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="container-fluid">
			<div class="block-header" align='center'>
				<h2>Assigned/Purchased Water Point Log</h2>
			</div>
		<div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll">
                <table id="example" class="table table-striped table-inverse  table-bordered table-responsive table-dark" style="border:none;" align="center" role="grid" aria-describedby="example_info">
				<?php
				echo form_open("","class=form-horizontal");?>
                    <thead>
						<tr>
							<th>Sr. No.</th>
							<th>Points</th>
							<th>Purchased Date</th>						
							<th>Description</th>
						</tr>
                    </thead>
                    <tbody>
                    	
					<?php
						$i=1;
						if($_SESSION['school_type']=='organization'){$sc_type="HR Admin";}else{$sc_type="School Admin";}
						foreach($purchase_water_log as $pwl){?>
							<tr>
								
							<td><?php echo $i++; ?></td>
							<td><?php echo $pwl['points']; ?></td>
							<td><?php echo $pwl['issue_date']; ?></td>
							<td><?php if($pwl['coupon_id']==0){ echo "Assigned point by ".$sc_type; }else{echo "Purchased by ".$pwl['coupon_id']." coupon.";} ?></td>
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
<script>
		document.getElementById("mylogs").className += " active";
        document.getElementById("mywater").className += " active";
		document.getElementById("allwater").className += " active";
 
</script>