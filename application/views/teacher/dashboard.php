    
<head>
				<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/validation.js"></script>
				<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/ajax.js" /></script>
				
				
			</head>

    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="container-fluid">
            <div class="block-header">
                <h2 style="text-align: center;">DASHBOARD</h2>
            </div>
            
        <!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<?php //echo form_open("","class=form-horizontal");

			//foreach($searchstuds as $stud)
				
			?>
			<div class="input-group">
			<input type="hidden" value="<?php print_r($stud); ?>" id="myval">
			<div class="panel-body">
				<label class="control-label col-sm-2" for="schoolName" >Search By<?php //echo ($this->session->userdata('usertype')=='teacher')?'Students':'Employee'; ?>:</label>
				<div class="col-sm-6"> 
				<input type="text" name="search_text" id="search_text" placeholder="Search by <?php //echo ($this->session->userdata('usertype')=='teacher')?'student':'employee'; ?> ID, Name or <?php //echo ($this->session->userdata('usertype')=='teacher')?'Class':'Team'; ?>" class="form-control" />
				<div class="col-sm-2" ><input type="button" value="Search" id="search" class="myButton" style="margin-left: 450px;margin-top: -50px;">
					<a  href="<?= base_url('/teachers');?>" class="myButton" style="margin-left: 550px;margin-top: -90px;">Back
        <i class="bi bi-arrow-return-left"></i>
    </a>

				</div> 
				</div> -->
			
            </div> 
            	<tbody>
					<div id="loading" align="center" style="display:none"><img src="<?php echo base_url();?>/images/ajax-loader.gif"></div>
					<div id="searched_student">
					</tbody>
				   
<!-- <label>Search:</label>
<input class="form-control" type="text" name="class" value="<?php //if(isset($_POST['class'])) { echo $_POST['class']; }?>" style="width: 200px;margin-left: 70px;margin-top: -30px;">

<div class="btn btn-group has-success" >
<input class="btn btn-group has-success form-control" type="submit" value="Submit" name="submit" style="width: 100px;margin-left: 300px;margin-top: -60px;"> -->
<!-- </div> -->

            	<!--New logic for dropdown added by Pranali for SMC-4404 on 10-1-20 -->
				 <?php $empType=$teacher_info->t_emp_type_pid; ?> 
            <div class="row clearfix">
            	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            	<?php if($school_type=='organization'){

      //       			if($empType == '133' || $empType=='134'){ //Manager

						// 	$list = array('Employee');
						// }
						// else if($empType=='135'){ //Reviewing Officer

						// 	$list = array('Employee','Manager');
						// }
						// else if($empType=='137'){ //Appointing Authority

						// 	$list = array('Employee','Manager','Reviewing Officer');
						// }
						// else if($empType=='139'){ //Member Secretary

						// 	$list = array('Employee','Manager','Reviewing Officer');
						// }
						// else if($empType=='141'){ //Vice Chairman

						// 	$list = array('Employee','Manager','Reviewing Officer','Member Secretary');
						// }
						// else if($empType=='143'){ //Chairman

							$list = array('Employee','Manager','Reviewing Officer','Member Secretary','Vice Chairman');
						// }
						// else{
						// 	$list = array('Employee');
						// }
            		?>            		             	            	
						<label class="col-sm-3" for="emp_type">Select Type:</label>
				 
						<select name="emp_types" id="emp_type" class="form-control" required />
						>
						<?php
						foreach ($list as $k=>$value) { ?>
							
								<option <?php if ($key==$value) { ?>selected="selected"<?php } ?> value="<?php echo $value; ?>">
									

									<?php echo $value; ?>					 	
							 	</option>
								<?php }
								 ?>
							</select>
					
				<?php  } //if ?>
			<div id="log_div1" class="scroll"></div>
                            	<div id="onload_div1" class="scroll">
                            		<?php if ($school_type=='organization')
                            		{ ?>
                            			<table class="table table-bordered table-hover" id="example" style="margin-left: 0px !important;">
                  <thead class='thead-dark'>
                        <th>Sr. No.</th>
                        <th>Image</th>
                        <th>ID</th>
                        <th>Name</th>                        
                        <th>Designation</th>
                        <th>Assign Points</th>
                      </thead><tbody>
                      	<?php 
                      	$i=1;

                      if(count($data)>0)
                      	{
                      		foreach($data as $uwl)
                      					            {              
                      					               if ($key=='Employee')
                      					               {
                      					                $teacher_name=$uwl['std_complete_name'];
                      					                $teacher_id=$uwl['std_PRN'];
                      					                $filepath=$uwl['std_img_path'];
                      					               
                      										if(!file_exists($filepath) || empty($filepath))
                      										{
                      											$teacher_image =DEFAULT_IMG_PATH;//DEFAULT_IMG_PATH is constant defined in config/constants.php  
                      										}
                      										else
                      										{
                      											$teacher_image = $uwl['std_img_path'];
                      										}
                      					              }
                      					            else {
                      					                $teacher_name=$uwl['teacher_name'];
                      					                $teacher_id=$uwl['teacher_id'];
                      					                $filepath=$uwl['teacher_image'];
                      					               	
                      										if(!file_exists($filepath) || empty($filepath))
                      										{
                      											$teacher_image =DEFAULT_IMG_PATH;//DEFAULT_IMG_PATH is constant defined in config/constants.php  
                      										}
                      										else
                      										{
                      											$teacher_image = $uwl['teacher_image'];
                      										}
                      					               }
                      					             
                      					             $link = base_url().'teachers/assign_points/'.$teacher_id.'/'.$key;
                      	
                      					               ?>
                      					               <tr>
                      					                          <td><?php echo $i ?></td>
                      					                          <td><img src="<?php echo $teacher_image;?>" height='50' width='50'></td>
                      					                          <td><?php echo $teacher_id?></td>
                      					                          <td><?php echo $teacher_name?></td>
                      					                          <td><?php echo $key?></td>
                      					                          <td><a href='<?php echo $link ?>'><input type='button' class='myButton' value='Assign'/></a></td>
                      					                        </tr>
                      					             <?php  $i++;
                      					            }
                      			} //if(count>0)
                       }else{ ?>
                                    <table class="table table-bordered table-hover" id="example" style="margin-left: 0px !important;">
									<thead class="thead-dark">
									  <th>Sr. No.</th>
									  <th>Student ID</th>
									  <th>Name</th>
									  <th>Image</th>
									  <th>Type</th>
						 			  <th>Class</th>
						  			  <th>Assign Points</th>
									   <?php if($this->session->userdata('usertype')=='teacher'){?>
									  <th>Student Coordinator</th> 
									   <?php } ?>
					   				 </thead>
                                        <tbody>
										<?php 
										
											
										
										?>										
                                    <?php 
                                    $i=1;
									foreach($student_info as $student){
										$filepath = $_SERVER['DOCUMENT_ROOT'].'/core/'.$student['std_img_path'];
									if(!file_exists($filepath) || empty($student['std_img_path']))
									{
										$std_img_path =DEFAULT_IMG_PATH;//DEFAULT_IMG_PATH is constant defined in config/constants.php  
									}
									else
									{
										$std_img_path = base_url().'/core/'.$student['std_img_path'];
									}

										if(!empty($student['std_complete_name'])){
											$std_name = $student['std_complete_name'];
										}
										else{
											$std_name = $student['std_name'].' '.$student['std_Father_name'].' '.$student['std_lastname'];
										} 
										
										?>
									  
								<tr>
								  <td><?php echo $i++;?></td>
								  <td><?php echo $student['std_PRN']?></td>
								  <td><?php echo $student['std_name'] ?></td>
								  <td><img src="<?php echo $std_img_path ?>" height="40" width=
								  "50"> </td>
								  <td><?php echo $key; ?></td>
								  <td><?php echo $student['std_class'] ?></td>
								  <td><a href="<?php echo base_url();?>teachers/assign_points/<?php echo $student['std_PRN'];?>"><input type="button" class="myButton" value="Assign"/></a></td>
								  
								  <?php if($this->session->userdata('usertype')=='teacher'){?>
								  <td>		  
								  	<form method="post" action="#" onchange="this.form.submit()">
								  	<input type="checkbox" name="make_coord[]" id="make_coord" onChange='submit();' value="<?php echo $student['stud_mem_id'];?>" <?php if($student['is_coordinator'] == 'Y'){?>checked <?php } //else($student->status == 'Y'){?>>
								  </form></td>
								  <?php } ?>
								</tr>
										
											 <?php } //foreach ?>
                                        </tbody>
                                    </table>
                                <?php } ?>
                                </div>
                <!-- #END# Browser Usage -->
				</div>
			</div>
		</div>
    </div>
    
		<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/validation.js"></script>
		<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/ajax.js" /></script>
			

