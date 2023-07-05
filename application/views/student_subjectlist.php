<?php
//print_r($studentinfo);//exit;
$this->load->view('stud_header',$studentinfo);
$std_PRN = $this->session->userdata('std_PRN');
$school_id = $this->session->userdata('school_id');

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
	  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
<script>

        $(document).ready(function() {
            $('#example').dataTable( {


         });


        } );

function confirmation() {
//alert(xxx);
        var answer = confirm("Are you sure you want to delete?")
        if (answer) {
                   //alert('Record Deleted Successfully');
                   return true;//Done comment by Dhanashri_Tak on 15/6/18
            //window.location = 'student_subjectlist?SubjectCode=".$row->SubjectCode."'+ xxx;
        }
        else{
        	return false;
        }

    }
$(document).ready(function(){
     $('.SMCselect2').select2({
    
     });
    });

        </script>
        
</head>

<title>Subject List</title>


<body>

    <!--END THEME SETTING-->


        <!--END SIDEBAR MENU--><!--BEGIN CHAT FORM-->

     <div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->


<!--$school_type=='organization' condition checked by Pranali for SMC-4263 on 9-1-20 -->
             <div id="page-wrapper"><!--BEGIN TITLE & BREADCRUMB PAGE-->
            <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">My <?php echo ($school_type=='organization')?'Projects':'Subjects'; ?></div>
                </div>

                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                   <!-- <li><a href="#">Logs</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>-->
                    <li class="active">My <?php echo ($school_type=='organization')?'Projects':'Subjects'; ?></li>
                </ol>

                <div class="clearfix"></div>
            </div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
            <div class="page-content">
                <div class="row">
                	<?php $current_acadmic_year=$Academic_Year[0]->Academic_Year; ?>
                    <div class="col-lg-12">
                        <div id="generalTabContent" class="tab-content responsive" style="margin-top:4%;">
                            <div id="teacher" class="tab-pane fade in active">
                   <?php  if($school_type=='organization'){}else{   ?>
						<div class="row">
						   <?php echo form_open("main/student_subjectlist","class=form-horizontal");?>
						<div class="col-md-4">

						</div>
						
						 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scroll" align="center">
                      <div class="name">
                        <form action="<?php echo base_url().'Main/aa';?>" method="post">
                            <?php $yr=$this->session->userdata('acadmic_yr'); 
                            //echo $yr;
                           ?>
                            <label>Choose Academic Year:</label>
                        <select id="cars" name="year" style="height:25px;"> Year
                            <?php foreach($student_subjectlist1['posts'] as $student)
                        { //if($student['Academic_Year']!=''){ $enable=1; ?>
                               <option value="<?php echo $student['Academic_Year']; ?>"<?php if($student['Academic_Year']==$yr){ ?> selected="selected" <?php } ?>><?php echo $student['Academic_Year']; ?></option>
                           <?php }  ?>
                        </select>
                        <input type="submit" name="year1" value="Submit">
                       </form>
                      
                    </div> 
			</div>
                </div>
						<!--<select id="select_opt" name="select_opt" class="form-control">

							<option value="4"
								 <?php if(isset($_POST['select_opt']))
								  		{
										 if($_POST['select_opt']=="4"){  ?> selected <?php }
										} ?>><?php// echo "Current Year" ?>
							</option>

							<option value="1"
								<?php if(isset($_POST['select_opt']))
	 									{
		 								if($_POST['select_opt']=="1"){  ?> selected <?php }
		 								} ?>>
								<?php //echo "Current Semester" ?>
							</option>

	 						<option value="2"
								<?php if(isset($_POST['select_opt']))
	 									{
										if($_POST['select_opt']=="2"){ ?> selected <?php }
										} ?>>
								<?php //echo "All Semester" ?>
							</option>

	   						<option value="3"
							   	<?php if(isset($_POST['select_opt']))
	 									{
										if($_POST['select_opt']=="3"){  ?> selected <?php }
										} ?>>
								<?php //echo "All Year" ?>
							</option>

							<option value="5"
								<?php if(isset($_POST['select_opt']))
	 									{
										 if($_POST['select_opt']=="5"){  ?> selected <?php }
										} ?>><?php //echo "My all Subject List" ?>
							</option>

      					</select>
						// <?php //echo form_error('select_opt', '<div class="error">', '</div>'); ?>
					</div> -->
						<!-- <div class="col-md-4">
						  <?php

								//echo form_submit('submit', 'Submit','class="btn btn-green"');
						    // echo form_submit('submit', 'Add Subject','class="btn btn-green"');
								//echo form_submit('button', 'Add Subject','class="btn btn-green"');

				    ?>
					</div>-->
						<?php
							echo form_close();
						?>
				</div>

				<?php } ?>
				<div class="row" style="margin-top:5%;">

                                  <div id="no-more-tables">
                                    <table class="table table-bordered table-hover " id="example" style="margin-left: 0px !important;">
                                        <thead class="cf">
                                        <tr>
                                            <th>Sr.No.</th>
                                            <th><?php echo ($school_type=='organization')?'Project':'Subject'; ?> Code</th>
                                            <?php if($group_type=='sports'){ ?> <th>Image</th><?php }?>
                                            <th><?php echo ($school_type=='organization')?'Project':'Subject'; ?> Name</th>

						      <?php if($school_type=='organization')
						        {

						        }
								else
								{
							        echo "<th>Semester</th>";
						        }
						         ?>


																						<th> Department </th>

                                             <th><?php echo ($school_type=='organization')?'Section':'Branch'; ?></th>
					              <?php if($school_type=='organization')
					                {

						            }
									else
									{
							            echo " <th>Year</th>";
						            } ?>

																						<th> Division </th>


                                            <th ><?php echo ($school_type=='organization')?'Manager':'Teacher'; ?> Name</th>

                                            <th style="width:100px;">
                                    <center>Delete</center>
                                </th>


                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i=1;
											//print_r($student_subjectlist['posts'][0]); exit;
											if ($student_subjectlist['responseStatus']==204){
												echo "<script>alert('No Record Found');</script>";
											}
											else{
												//print_r($student_subjectlist);exit;
										foreach($student_subjectlist['posts'] as $t)
											{
												// print_r($student_subjectlist['posts']);
												// print_r($t['Year']);exit;

												?>
                                        	<tr>
                                            	<td data-title="Sr.No"><?php echo $i;?></td>
                                            	<td data-title="<?php echo ($school_type=='organization')?'Project':'Subject'; ?> Code"><?php if(isset($t['SubjectCode'])){ echo $t['SubjectCode']; }else {}   ?></td>


<!--SMC-4263 by Pranali on 9-1-20 : height and weight changed to display image properly -->
												 <?php if($group_type=='sports'){ ?> <td data-title="Image" style="height:25%;width:15%;"><img  src="<?php if(isset($t['subject_image'])){echo $t['subject_image']; }else {
													echo base_url()."core/Images/default_subject.jpg";
												};?>"style="height:25%;width:25%;"></td><?php }?>
	<!--End SMC-4263 -->
                                            	<td data-title="<?php echo ($school_type=='organization')?'Project':'Subject'; ?> Name" ><?php if(isset($t['subjectName'])){ echo $t['subjectName']; } else { } ?></td>

													<?php if($school_type=='organization')
															{}
															else{ ?>
																<td data-title="Semester" >
																<?php if(isset($t['semesterName'])) {
																	echo $t['semesterName']; } else { } ?></td><?php
						            							} ?>

																			<td data-title="Department"> <?php echo $t['departmentId']; ?> </td>

												<td data-title="Branch"><?php if(isset($t['Branches_id'])) { echo $t['Branches_id'];}else{} ?></td>
											 		<?php if($school_type=='organization')
						              						{}
									  						else{ ?>
																<td data-title="Year">
																<?php if(isset($t['Year'])){
																	echo $t['Year'];}else{ } ?></td><?php
						              							} ?>

																				<td data-title="Division"> <?php echo $t['divisionId']; ?> </td>

											 	<td data-title="<?php //echo ($school_type=='organization')?'Manager':'Teacher'; ?> Name"><?php  if(isset($t['teacher_name'])){ echo ucwords(strtolower( $t['teacher_name'])); } else{ } ?></td>
											 	 <td style="width:100px;">
											 	 	<?php //echo $t['SubjectCode']."/".$std_PRN."/".$t['semesterName']."/".(urldecode($t['Branches_id']))."/".$t['departmentId']."/".$t['divisionId']."/".$t['Year']."/".$school_id;exit;//base_url('Main/delete_row/'.$t['SubjectCode'])."".$t['subjectName']."".$t['Semester_id']."".$t['Branches_id'];exit;?>
                                            <center><!--<a href="delete_row?SubjectCode="<?php echo $t['SubjectCode'];?>><span class="glyphicon glyphicon-trash"></span></a>-->
                                            	<!--<a href="javascript:void(0);" ;return isconfirm('<?php //echo base_url('Main/delete_row/'.);?>');" onclick="return isconfirm('<?php //echo base_url('Main/delete_row/'.$t['SubjectCode']."/".$std_PRN."/".$t['semesterName']);?>');">Delete</a> -->
                                            	<a href="<?php echo base_url('Main/delete_row/'.$t['SubjectCode']."/".$std_PRN."/".$t['semesterName']."/".(urldecode($t['Branches_id']))."/".(urldecode($t['departmentId']))."/".$t['divisionId']."/".$t['Year']."/".$school_id);?>" onclick="return confirmation()" class="delete glyphicon glyphicon-trash"></a>
                                            </center>
                                        </td>
											</tr>
                                      		<?php $i++;} } ?>
                                        </tbody>
                                    </table>
                                </div>
			<!--End SMC-4263 -->
                                </div>
                                </div>

                                </div>
                            </div>
                                    </div>
                                </div>
                            </div>

                 </div>

            <!--END CONTENT--><!--BEGIN FOOTER-->


        <!--END PAGE WRAPPER-->
                  <?php


$this->load->view('footer');

?>
            <!--END CONTENT--><!--BEGIN FOOTER-->

            </div>

</body>
</html>
