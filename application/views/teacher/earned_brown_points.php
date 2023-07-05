<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="container-fluid">
		<div class="block-header" align='center'>
                <h2>Earned Brown Points</h2>
        </div>
		<div class="row clearfix">
		
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll">
                <table id="example" class="table table-striped table-invers  table-bordered table-responsive table-dark" style="border:none;" align="center" role="grid" aria-describedby="example_info">
				<?php
				//echo form_open("","class=form-horizontal");?>
                    <thead>
						<tr>
							<th>Sr. No.</th>
							<th>Reason</th>
							<th>Points</th>
							<th>Date</th>						
						</tr>
                    </thead>
                    <tbody>
					<?php
						$i=1;
						foreach($earned_brown_points as $brown_points){	
						$reason = ($brown_points->reason == 'request_sent') ? 'Sent request to join Smartcookie' : (($brown_points->reason == 'request_accepted') ? 'Accepted request to join Smartcookie' : $brown_points->reason);
					?>	
						<tr>
							<td><?php echo $i++; ?></td>
							<td><?php echo $reason; ?></td>
							<td><?php echo $brown_points->sc_point; ?></td>
							<td><?php echo date('Y/m/d',strtotime($brown_points->point_date)); ?></td>
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
			document.getElementById("mybrown").className += " active";
			document.getElementById("allbrown").className += " active";
		</script>
</head>