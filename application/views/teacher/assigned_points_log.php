<?php $points_type = array('Greenpoint'=>'Green Points','Waterpoint'=>'Water Points'); ?>
   <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="container-fluid">
		<div class="block-header" align='center'>
                <h2>Reward Points Log</h2>
        </div>
            <!-- CPU Usage -->
            <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<label class=" col-sm-3" for="pointType">Select Points Type:</label>
				<div class="col-sm-9"> 
					<select name="points_type" id="point_types" class="form-control" required />
						<!-- <option value="">Select Point Type</option> -->
						<?php  
							foreach($points_type as $k=>$val){?>
							<option value="<?php echo $k;?>"><?php echo $val;?>	</option>
						<?php }?>
					</select>
				</div>
			
				<div id="log_div" class="scroll"></div>
				<div id= "onload_div" class="scroll" >
                    <table id="example" class="table table-striped table-invers  table-bordered table-responsive table-dark" style="border:none;" align="center" role="grid" aria-describedby="example_info">
						<thead class="thead-dark">
						  <th>Sr. No.</th>
						  <th><?php echo ($school_type=='organization')?'Employee':'Student'; ?> Name</th>
						  <th><?php echo ($school_type=='organization')?'Project':'Subject'; ?>/Activity Name</th>
						  <th>Assigned Points</th>
						  <th>Point Type</th>
						  <th>Date</th></tr>
					    </thead>
					    <tbody>
						
							<?php
							  $i=1;
							  //print_r($student_info); exit;
							  foreach($student_list as $student){
								  if(!empty($student->std_complete_name)){
									  $std_name = $student->std_complete_name;
								  }
								  else{
									  $std_name = $student->std_name.' '.$student->std_Father_name.' '.$student->std_lastname;
								  }
								  if($student->activity_type =="subject")
								  {
									  $act_sub_name = $student->act_or_sub;
								  }
								  else if($student->activity_type =="activity")
								  {
									  $act_sub_name = (!empty($student->act_or_sub)) ? $student->sc_list." ".$student->act_or_sub." " : $student->sc_list;
								  }
								  else $act_sub_name ="";
								  ?>
								<tr>
								  <td><?php echo $i++;?></td>
								  <td><?php echo $std_name ?></td>
								  <td><?php echo $act_sub_name ?></td>
								  <td><?php echo $student->sc_point ?></td>
								  <td><?php echo $student->type_points ?></td>
								  <td><?php echo date('Y/m/d', strtotime($student->point_date)); ?></td>
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
			<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/validation.js"></script>
			<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/ajax.js"></script>
			<script>
					document.getElementById("mylogs").className += " active";
					document.getElementById("stdRlog").className += " active";
			</script>