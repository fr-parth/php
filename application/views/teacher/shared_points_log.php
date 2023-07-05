<?php $points_type = array('Greenpoint'=>'Green Points','Waterpoint'=>'Water Points'); ?>
 <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="container-fluid">
            <div class="row clearfix">
			<div class="block-header" align="center">
				  <h2>Shared Points Log</h2>
			</div>
               <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll">
				<div id="log_div"></div>
				<div id= "onload_div" class="scroll">
                    <table id="example" class="table table-striped table-invers  table-bordered table-responsive table-dark" style="border:none;" align="center" role="grid" aria-describedby="example_info">
						<thead class="thead-dark">
						  <th>Sr. No.</th>
						 <th><?php echo ($this->session->userdata('usertype')=='teacher')?'Teacher':'Manager'; ?> Name</th>
						  <th>Reason</th>
						  <th>Shared Points</th>
						   <th>Point Type</th>
						  <th>Date</th></tr>
					    </thead>
					    <tbody>
						
							<?php
							  $i=1;
							  //print_r($student_info); exit;
							  foreach($shared_points_log as $shared_points){
								  if(!empty($shared_points->t_complete_name)){
									  $teacher_name = $shared_points->t_complete_name;
								  }
								  else{
									  $teacher_name = $shared_points->t_name.' '.$shared_points->t_middlename.' '.$shared_points->t_lastname;
								  }
								  ?>
								<tr>
								  <td><?php echo $i++;?></td>
								  <td><?php echo $teacher_name ?></td>
								  <td><?php echo $shared_points->reason ?></td>
								  <td><?php echo $shared_points->sc_point ?></td>
								  <td><?php echo $shared_points->point_type ?></td>
								  <td><?php echo date("Y/m/j", strtotime($shared_points->point_date));?></td>
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
			document.getElementById("mylogs").className += " active";
			document.getElementById("sharedpt").className += " active";
		</script>
	</head>