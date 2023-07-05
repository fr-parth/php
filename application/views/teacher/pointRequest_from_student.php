<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="container-fluid">
		<div class="block-header" align='center'>
        <h2><?php
//$school_type=='organization' condition added for naming convention by Pranali for SMC-4269 on 3-1-20
         echo ($school_type=='organization')?'Employee/Manager':'Student';
         $teacher_id = $teacher_info[0]->t_id;

         ?> Request for Points</h2>
        </div>
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll">
			<form method="post" action=" " >
			<input type="hidden" name="avail_green" id="avail_green" value="<?php echo $teacher_info[0]->tc_balance_point; ?>">
                <table id="example" class="table table-striped table-invers  table-bordered table-responsive table-dark" style="border:none;" align="center" role="grid" aria-describedby="example_info">
                    <thead>
						<tr>
	<!--Entity Type added by Pranali for SMC-4269 on 19-12-19-->
							<th>Sr. No.</th>
							<th><?php echo ($school_type=='organization')?'Employee/Manager':'Student'; ?> Image</th>
							<th><?php echo ($school_type=='organization')?'Employee/Manager':'Student'; ?> Name</th>
							<th>Points</th>
							<th>Point Reason</th>
							<th>Entity Type</th>
							<th>Request Date</th>
							<th>Edit Points</th>
							<th>Accept</th>
							<th>Decline</th>							
						</tr>
                    </thead>
                    <tbody>
					<?php
						$i=1;
						foreach($pointRequest as $pointRequests){
							
						$filepath = $_SERVER['DOCUMENT_ROOT'].'/core/'.$pointRequests['std_img_path'];
						if(!file_exists($filepath) || empty($pointRequests['std_img_path']))
						{
							$std_img_path =DEFAULT_IMG_PATH;//DEFAULT_IMG_PATH is constant defined in config/constants.php  
						}
						else
						{
							$std_img_path = base_url().'/core/'.$pointRequests['std_img_path'];
						}
					?>	
						<tr>
<!--Modal functionality and ajax call done for Edit points from Student / Employee request by Pranali for SMC-4269 on 26-12-19-->
							<td><?php echo $i; ?></td>
							<td><img src="<?php echo $std_img_path; ?>" height="50" width="50"></td>
							<td><?php echo $pointRequests['std_complete_name']; ?></td>
							<td id='point<?php echo $i;?>'><?php echo $pointRequests['points']; ?></td>
							<td><?php echo $pointRequests['reason']; ?></td>
							<td><?php

							if($school_type=='organization'){
								echo $pointRequests['entity']; 
							}
							else{
								echo 'Student';
							}

							?></td>
							<td><?php echo date("Y/m/j", strtotime($pointRequests['requestdate'])); ?></td>
							<td><input type="button" id="edit<?php echo $i;?>" value="Edit" data-toggle="modal" data-target="#myModal<?php echo $i;?>"></td>

							<!-- Modal -->
							  <div class="modal fade" id="myModal<?php echo $i;?>" role="dialog">
							    <div class="modal-dialog">
							    
							      <!-- Modal content-->
							      <div class="modal-content">
							        <div class="modal-header">
							          <button type="button" class="close" data-dismiss="modal">&times;</button>
							          <h4 class="modal-title">Edit Points</h4>
							        </div>

							        <div class="modal-body">
							         <label>Points :</label>&nbsp;&nbsp;
							         <input type="number" id="edit_point<?php echo $i; ?>" name="edit_points<?php echo $i; ?>" value="<?php echo $pointRequests['points']; ?>" min='1' style="margin-left:20px;"/>
							         <br/><br/>
							         <label>Comment :</label>&nbsp;&nbsp;
							         <input type="text" id="comment<?php echo $i; ?>" name="comments<?php echo $i; ?>"/>
							        </div>

							        <div class="modal-footer">
							        	<button type="button" class="btn btn-primary" name='submit' onclick="point_validate('<?php echo $i;?>','<?php echo $pointRequests['id'];?>');">Submit</button>
							          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							        </div>
							      </div>
							      
							    </div>
							  </div>
							  
<!--$pointRequests['entity'] added as new parameter by Pranali for SMC-4419 on 11-1-20 -->
							<td><input type="button" value="Accept" id="accept<?php echo $i;?>" onclick="return adrequest('<?php echo $pointRequests['student_PRN']; ?>','<?php echo $pointRequests['reason_id']; ?>','<?php echo $pointRequests['activity_type'];?>','<?php echo $pointRequests['points']; ?>','<?php echo $pointRequests['id'];?>','<?php echo $i;?>','<?php echo $school_type;?>','<?php echo $pointRequests['reason']; ?>','<?php echo $pointRequests['entity']; ?>')"></td>
							<td><input type="button" value="Decline" id="decline<?php echo $i;?>" class="myButton" onclick="return decrequest('<?php echo $pointRequests['id'];?>','<?php echo $i;?>','<?php echo $pointRequests['student_PRN']; ?>','<?php echo $teacher_id;?>','<?php echo $pointRequests['entity']; ?>','<?php echo $pointRequests['reason_id']; ?>')"></td>
						</tr>
							<?php $i++;} ?>
						
					</tbody>
				</table>
				</form>
			</div>
			 
		</div>
		</div>
</div>
<!-- <script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/validation.js"></script>
<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/ajax.js"></script>
 --><script type="text/javascript">
	function point_validate(i,id)
{
	var point = $('#edit_point'+i).val();
	var comment = $('#comment'+i).val();
	var num = new RegExp("^[1-9][0-9]*$");
	var base_url = location.origin;
	
	if(point=='' || point=='null' || point=='0')
	{
		alert('Please enter number greater than zero!!');
		$('#edit_point'+i).focus();
		$('#edit_point'+i).val("");
		return false;
	}
	else if(!num.test(point))
	{
		alert('Please enter positive number!!');
		$('#edit_point'+i).focus();
		$('#edit_point'+i).val("");
		return false;
	}	
	else{

		$.ajax({
				type    : "POST",
				url     : base_url + '/Teachers/update_points',
				data    : { points : point, id : id, comment : comment },
				cache   : false,
				success : function(data) {
							if(data == "0")	//failure
							{
								alert('Points not edited.. Please try again!!');
									
							}
							else //success
							{
								alert('Points edited successfully');
								window.location.href=base_url +'/Teachers/pointRequest_from_student'; 
								$('#myModal'+i).modal('hide');
								$('#point'+i).html(data);
								
							}
							 	
						},
				error   : function(){
                			alert('Error');
        			}	
				});
			
	}
	
}
</script>
<script>
	document.getElementById("otheract").className += " active";
	document.getElementById("pointRequest").className += " active";
</script>