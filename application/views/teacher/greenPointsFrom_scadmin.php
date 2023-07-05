<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
    <div class="container-fluid">
			<div class="block-header" align='center'>
					<h2>Reward Points From <?php echo ($this->session->userdata('usertype')=='teacher')?'School':'Organization'; ?> Admin</h2>
			</div>
		<div class="row clearfix">
		
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll">
                <table id="example" class="table table-striped table-invers  table-bordered table-responsive table-dark" style="border:none;" align="center" role="grid" aria-describedby="example_info">
                    <thead>
						<tr>
							<th>Sr. No.</th>
							<th>Name</th>
							<th>Reason</th>
							<th>Points</th>
							<th>Date</th>
						</tr>
                    </thead>
                    <tbody>
					<?php
						$i=1;
						$total_points = 0;
						foreach($greenPointsFrom_scadmin as $greenPoints){
							if(!empty($greenPoints->t_complete_name))
							{
							    $teacher_name = $greenPoints->t_complete_name;
							}
							else
							{
								$teacher_name = $greenPoints->t_name.' '.$greenPoints->t_middlename.' '.$greenPoints->t_lastname;
							}
							$total_points = $total_points + $greenPoints->sc_point;
					?>	
						<tr>
							<td><?php echo $i++; ?></td>
							<td>School admin shared to <?php echo $teacher_name; ?></td>
							<td><?php echo $greenPoints->reason; ?></td>
							<td><?php echo $greenPoints->sc_point; ?></td>
							<td><?php echo date('Y/m/d',strtotime($greenPoints->point_date)); ?></td>
						</tr>
							<?php } ?>
						<?php //echo $total_points?>
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
			document.getElementById("mygreen").className += " active";
			document.getElementById("allgreen").className += " active";
		</script>
</head>