<?php 
 
 
	if(!empty($student_info[0]->std_complete_name))
	{
		 $std_name = $student_info[0]->std_complete_name;
	}
	else
	{
		 $std_name = $student_info[0]->std_name.' '.$student_info[0]->std_Father_name.' '.$student_info[0]->std_lastname;
	}
	$filepath = $_SERVER['DOCUMENT_ROOT'].'/core/'.$student_info[0]->std_img_path;
	if(!file_exists($filepath) || empty($student_info[0]->std_img_path))
	{
		$std_img_path =DEFAULT_IMG_PATH;//DEFAULT_IMG_PATH is constant defined in config/constants.php  
	}
	else
	{
		$std_img_path = base_url().'/core/'.$student_info[0]->std_img_path;
	}
	 $avail_green_point = $teacher_info[0]->tc_balance_point;
	 $avail_water_point = $teacher_info[0]->water_point;
	 $avail_brown_point = $teacher_info[0]->brown_point;
?>

	 <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="container-fluid">
		<div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll">
                <table id="" class="table table-striped table-invers  table-bordered table-responsive table-dark" style="border:none;" align="center" role="grid" aria-describedby="example_info">
				<?php //echo form_open("","class='form-horizontal' onSubmit='window.location.reload(true)'");?>
				<form method="post" action=" " id="assign_form">
				<input type="hidden" name = "avail_green" id="avail_green" value="<?php echo $teacher_info[0]->tc_balance_point; ?>">
				<input type="hidden" name = "avail_water" id="avail_water" value="<?php echo $teacher_info[0]->water_point; ?>">
                    <thead>
						  <tr><th colspan=3>Assign Points to <?php echo $std_name; ?></th>
						  </tr>
						  <tr>
<!--Replaced condition $this->session->userdata('usertype')=='teacher' by $school_type!='organization' and UI changes done by Pranali for SMC-4210,SMC-4249 respectively on 7-1-20 -->
						  <td rowspan=2><img src="<?php echo $std_img_path; ?>" height="60" width="70"></td>
						  <td>Department : <?php echo $student_info[0]->std_dept?></td></tr>
						  <tr><td><?php echo ($school_type!='organization')?'Branch':'Section'; ?>   : <?php echo $student_info[0]->std_branch?></td>
						  </tr>
                    </thead>
                    <tbody>
						<tr><th colspan=2>Activity & <?php echo ($school_type!='organization')?'Subject':'Project'; ?> List</th>
						</tr>
						<tr>
							<td>
								Select <?php echo ($school_type!='organization')?'Subject':'Project'; ?>/Activity: 
								
							</td>
							<td>
								<select class="form-control" id="activity_or_subject" name="activity_or_subject" required/> 
									<option value=''>Select <?php echo ($school_type!='organization')?'Subject':'Project'; ?>/Activity</option>
									
									<option value='1'><?php 
									echo ($school_type=='organization')?'Project':'Subject'; ?> </option>
								
									<option value='2'>Activity</option>
								</select>
								<div id="actsub"></div>
								<?php echo form_error('activity_or_subject', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</td>
						</tr>
						  
						<tr id="select_subject">
						    <td>
								Select <?php echo ($school_type!='organization')?'Subject':'Project'; ?>:
							</td>
							<td>			  
								<select name="subject" id="subject" class="form-control" />
									<option value="">Select <?php echo ($school_type!='organization')?'Subject':'Project'; ?></option>
									<?php  
									foreach($subject_list as $t){
										if($t['subjectName']!=''){
										?>
									<option value="<?php echo $t['subjcetId'];?>"><?php echo $t['subjectName'];?></option>
									<?php }
								}?>
								</select>
								<?php echo form_error('subject', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</td>
						</tr>
						<tr id="select_activity">
							<td>
								Select Activity Type:
							</td>
							<td>			  
								<select name="activity" id="activity" class="form-control"/>
									<option value="">Select Activity Type</option>
										<?php
											foreach($activity_list as $t){?>
											<option value="<?php echo $t->id;?>"><?php echo $t->activity_type;?></option>
											<?php }
									?>
								</select>
								<?php echo form_error('activity', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</td>
						</tr> 
						<tr id="select_sub_activity">
							<td>
								Select Activity:
							</td>
							<td>
								<select name="sub_activities" id="sub_activity" class="form-control"/>
									<option value="">Select Activity</option>
									<!-- Sub Activity comes through ajax call-->
 
								</select>
								<?php echo form_error('sub_activities', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</td>
						</tr>
						<tr id="select_point_type">
							<td>
								Select Points Type:
							</td>
							<td>			  
								<select name="point_type" id="point_type" class="form-control" required/>
									<option value="">Select Points Type</option>
									<?php  
//only water point option for Manager to Manager report by Pranali for SMC-4210						
										if($school_type=='organization' && $mykey!='Employee' && $mykey!=''){ ?>
											<option value="Waterpoint">Water Points</option>
										<?php
										}
										else{
										foreach($pointsArr as $k=>$val){?>
										<option value="<?php echo $k;?>"><?php echo $val;?>
									</option>
										<?php } 
									}?>
								</select>
								<?php echo form_error('point_type', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</td>
						</tr> 
						<tr id="select_point_method">
							<td>
								Select Method:
							</td>
							<td>			 

								<select name="point_method" id="point_method" class="form-control" required/>
									<option value=""></option>

										<?php  
										//only Judgement option kept for organization by Pranali for SMC-4210			
										//method_list changed to methods by Pranali for SMC-3763 on 2-10-19

										foreach($methods as $ks)
										{
											if($school_type=='organization' && $ks['method_name']=='Judgement'){ ?>
											<option value="<?php echo $ks['id']." ".$ks['method_name'];?>"><?php echo $ks['method_name'];?></option>
										<?php break;}
										else{ ?>
										<option value="<?php echo $ks['id']." ".$ks['method_name'];?>"><?php echo $ks['method_name'];?>
									</option>
										<?php 
											}

										}
										?>
								</select>
								<?php echo form_error('point_method', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</td>
						</tr> 
						
						<tr id="select_points_value">
							<td id="type_method">
								
							</td>
							<td>			  
								<input type="text" name="points_value" id="points_value" placeholder="Enter Value" class="form-control" required/>
								<?php echo form_error('points_value', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</td>
						</tr> 
						<tr id="points_field"></tr>
						<tr id="select_point_reason">
							<td>
								Enter Comment:
							</td>
							<td>			  
								<textarea name="point_reason" id="point_reason" placeholder="Enter Comment" class="form-control"/></textarea>
								<?php echo form_error('point_reason', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</td>
						</tr> 
						<tr>
							<td align='center'><input type="button" value="Back" class="myButton" onclick="javascript:history.go(-1)";></td>
							<td align='center'>
								<?php 
									echo form_submit('assign', 'Assign Points','class="myButton btn-success" id="submit_button" onclick=" return assign_point();"');
								?>
							</td>
							
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		</div>
	</div>
 
 

 <!--uncommented below script for showing sub activities list for bug SMC-3854 by Pranali on 23-9-19-->
<script type="text/javascript">
   $(document).ready(function(){
      
      $('#activity').change(function() {
			var value = $(this).val();
         
            var base_url1 = window.location.origin;
          
			$.ajax({
					type: "POST",
					url: base_url1 + '/subactivities/sub_activity_list',
					data: { 
                              sc_type : value
                          },  
					success: function(data) {
                        //alert(data);
                        console.log(data);
                        
							$('#sub_activity').html(data);
						}		
				});
		});
       
   });


</script>
	<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH; ?>/js/validation.js"></script>
	<!-- <script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/jquery.dataTables.js"></script> -->
	<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/ajax.js"></script>