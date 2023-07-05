<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="container-fluid">
		<div class="block-header" align='center'>
                <h2> Used ThanQ Points Log</h2>
        </div>
		<div class="row clearfix">
		
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll">
                <table id="example2" class="table table-striped table-invers  table-bordered table-responsive table-dark" style="border:none;" align="center" role="grid" aria-describedby="example_info">
				<?php
				//echo form_open("","class=form-horizontal");?>
                    <thead>
						<tr>
							<th>Sr. No.</th>
							<th>Reason</th>
							<th>Name/Code</th>
							<th>Points</th>
							<th>Date</th>
						</tr>
                    </thead>
                    <tbody>
					<?php
						$i=1;
						 foreach($shared_points_log as $shared_points){
							if(!empty($shared_points->t_complete_name)){
								$teacher_name = $shared_points->t_complete_name;
							}
							else{
								$teacher_name = $shared_points->t_name.' '.$shared_points->t_middlename.' '.$shared_points->t_lastname;
							}
					?>	
						<tr>
							<td><?php echo $i++; ?></td>
							<td><?php echo "Points shared to teacher"; ?></td>
							<td><?php echo $teacher_name; ?></td>
							<td><?php echo $shared_points->sc_point; ?></td>
							<td><?php echo date("Y/m/d", strtotime($shared_points->point_date));?></td>
						</tr>
						<?php } ?>
					<?php
						
						foreach($generated_coupon_details as $coupon_details){
						
					?>	
							<tr>
								<td><?php echo $i++; ?></td>
								<td><?php echo "Generated coupon"; ?></td>
								<td><?php echo $coupon_details->coupon_id; ?></td>
								<td><?php echo $coupon_details->amount; ?></td>
								<td><?php echo date('Y/m/d', strtotime($coupon_details->issue_date)); ?></td>
							</tr>
							<?php } ?>
							
							<?php
						
						foreach($bought_coupons as $bought_coupon){
					?>	
						<tr>
							<td><?php echo $i++; ?></td>
							<td><?php echo "Purchased coupon"; ?></td>
							<td><?php echo $bought_coupon->code; ?></td>
							<td><?php echo $bought_coupon->for_points; ?></td>
							<td><?php echo date('Y/m/d', strtotime($bought_coupon->timestamp)); ?></td>
						</tr>
							<?php } ?>
						<?php
						foreach($purchased_softreward as $softreward){	
					?>	
						<tr>
							<td><?php echo $i++; ?></td>
							<td><?php echo "Purchased soft reward"; ?></td>
							<td><?php echo $softreward->rewardType; ?></td>
							<td><?php echo $softreward->point; ?></td>
							<td><?php echo date("Y/m/d", strtotime($softreward->logDate)); ?></td>
						</tr>
							<?php } ?>
					</tbody>
				</table>
			</div>
			 
		</div>
		</div>
</div>
<head>
		<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/validation.js"></script>
		<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/ajax.js" /></script>
		<script>
			document.getElementById("mylogs").className += " active";
			document.getElementById("myblue").className += " active";
			document.getElementById("usedblue").className += " active";
		</script>
</head>
<script>
$(document).ready(function() {
    $('#example2').DataTable( {
        "aaSorting": [[ 4, "desc" ]],
		
    } );
} );
</script>
<style>div#example2_length {
   float: right;
}
div#example2_paginate {
   float: right;
}
a#example2_previous {
   margin-right: 1%;
}</style>