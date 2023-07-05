
<?php 
//print_r($schoolinfo);

$this->load->view('stud_header',$studentinfo);

?>

<!DOCTYPE html>
<html lang="en">
<head><title>User Profile</title>
    
  
</head>
<body>

    <!--END THEME SETTING-->
    
     
 
 <div id="page-wrapper"><!--BEGIN TITLE & BREADCRUMB PAGE-->
            <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">User Profile</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="index.html">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li><a href="#">Extra</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active">User Profile</li>
                </ol>
                <div class="clearfix"></div>
            </div>  
            <div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
            <div class="page-content">
                <div class="row">
                    <div class="col-md-12"><h2>Profile: <?php 
                                            if($studentinfo[0]->std_complete_name!="")
											{
												
												echo ucwords(strtolower($studentinfo[0]->std_complete_name));
											}
											else
											{
											echo ucwords(strtolower( $studentinfo[0]->std_name." ".$studentinfo[0]->std_Father_name." ".$studentinfo[0]->std_lastname	));	
											}
											
											?></h2>

                        <div class="row mtl">
                            <div class="col-md-3">
                                <div class="form-group">
                                                        <div class="thumb" align="center" style="width:28%;margin-left:28%;">

<?php if($studentinfo[0]->std_img_path==""){?>
                                                    <img src="<?php echo base_url()?>images/avtar.png"  alt="" class="img-circle" style="width:135%;"/>
                                                    
<?php }
else
{?>
	<img src="<?php echo base_url()?><?php $studentinfo[0]->std_img_path?>"  alt="" class="img-circle"/>
<?php }?>

                    </div>

                                    <div class="text-center mbl"> <input type="file" a href="#" class="btn btn-green"><i class="fa fa-upload"></i>&nbsp;
                                        Upload</a></div>
                                </div>
                                <table class="table table-striped table-hover">
                                    <tbody>
                                    <tr>
                                        <td> Name</td>
                                        <td><?php 
                                             if($studentinfo[0]->std_complete_name!="")
											{
												
												echo ucwords(strtolower($studentinfo[0]->std_complete_name));
											}
											else
											{
											echo ucwords(strtolower( $studentinfo[0]->std_name." ".$studentinfo[0]->std_Father_name." ".$studentinfo[0]->std_lastname	));	
											}?></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td><?php echo  $studentinfo[0]->std_email;?></td>
                                    </tr>
                                   
                              
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-9">
                                <?php 
echo form_open("main/update_profile","class=form-horizontal");?>
                                                               <div id="generalTabContent" class="tab-content">
                                    <div id="tab-edit" class="tab-pane fade in active">
                                        <form action="#" class="form-horizontal"><h3>Education Details</h3>
                                         <div class="form-group"><label class="col-sm-3 control-label">Student PRN</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-9"><input type="email" value="<?php 
                                            echo $studentinfo[0]->std_PRN;?>" class="form-control" readonly/></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group"><label class="col-sm-3 control-label">College Name</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-9"><input type="email" value="<?php 
                                            echo $studentinfo[0]->std_school_name;?>" class="form-control" readonly/></div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                               <div class="form-group"><label class="col-sm-3 control-label">Department</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-9"><input type="email" value="<?php 
                                            echo $studentinfo[0]->std_dept;?>" class="form-control" readonly/></div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                               <div class="form-group"><label class="col-sm-3 control-label">Branch</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-9"><input type="email" value="<?php 
                                            echo $studentinfo[0]->std_branch;?>" class="form-control" readonly/></div>
                                                    </div>
                                                </div>
                                            </div>
                                           
										    <div class="form-group"><label class="col-sm-3 control-label">Semester</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-9"><input type="email" value="<?php 
														
														if(isset($stud_sem_record[0]->SemesterName))
														{
															 echo $stud_sem_record[0]->SemesterName;
															
														}
														else
															
															{
                                           echo "";
															}?>" class="form-control" readonly/></div>
                                                    </div>
                                                </div>
                                            </div>
                                      
									    <div class="form-group"><label class="col-sm-3 control-label">Academic Year</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-9"><input type="email" value="<?php 
if(isset($stud_sem_record[0]->AcdemicYear))
														{
															echo $stud_sem_record[0]->AcdemicYear;
															
														}
														else
															
															{                                           
echo "";
															 }?>" class="form-control" readonly/></div>
                                                    </div>
                                                </div>
                                            </div>
											
											<div class="form-group"><label class="col-sm-3 control-label">Division</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-9"><input type="email" value="<?php 
														if(isset($stud_sem_record[0]->DivisionName))
														{
															 echo $stud_sem_record[0]->DivisionName;
															
														}
														else
															
															{
                                           echo "";
															}?>" class="form-control" readonly/></div>
                                                    </div>
                                                </div>
                                            </div>
											
											<div class="form-group"><label class="col-sm-3 control-label">Class</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-9"><input type="email" value="<?php 
if(isset($stud_sem_record[0]->std_class))
														{
															echo $studentinfo[0]->std_class;
															
														}
														else
															
															{  
echo "";															
															 }?>" class="form-control" readonly/></div>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                            <hr/>
                                            <h3>Pro Setting</h3>

                                            <div class="form-group"><label class="col-sm-3 control-label">First Name</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-9"><input type="text" placeholder="first name" class="form-control"  name="fname" id="fname" value="<?php if(isset($_POST['fname'])){echo $_POST['fname'];}  else {echo $studentinfo[0]->std_name;}?>"/><?php echo form_error('fname', '<div class="error">', '</div>'); ?></div>
                                                    </div>
                                                </div>
                                            </div>
											<div class="form-group"><label class="col-sm-3 control-label">Middle Name</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-9"><input type="text" placeholder="middle name" class="form-control"  name="mname" id="mname" value="<?php if(isset($_POST['mname'])){echo $_POST['mname'];}  else {echo $studentinfo[0]->std_Father_name;}?>"/><?php echo form_error('mname', '<div class="error">', '</div>'); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label class="col-sm-3 control-label">Last Name</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-9"><input type="text" placeholder="last name" class="form-control" name="lname" id="lname" value="<?php if(isset($_POST['lname'])){echo $_POST['lname'];} else{  echo $studentinfo[0]->std_lastname;}?>"/><?php echo form_error('lname', '<div class="error">', '</div>'); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                           <?php /*?> <div class="form-group"><label class="col-sm-3 control-label">Gender</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-9">
                                                        <?php if($studentinfo[0]->std_gender=="")
														{?>
                                                            <label class="radio-inline"><input type="radio" value="Male" name="gender" checked="checked"/>&nbsp;
                                                                Male</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="radio-inline"><input type="radio" value="Female" name="gender"/>&nbsp;
                                                                Female</label>
                                                               <?php }if($studentinfo[0]->std_gender=="Male"){?> 
                                                               <label class="radio-inline"><input type="radio" value="Male" name="gender" checked="checked"/>&nbsp;
                                                                Male</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="radio-inline"><input type="radio" value="Female" name="gender"/>&nbsp;
                                                                Female</label>
                                                                <?php }if($studentinfo[0]->std_gender=="Female"){?> 
                                                               <label class="radio-inline"><input type="radio" value="Male" name="gender"/>&nbsp;
                                                                Male</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="radio-inline"><input type="radio" value="Female" name="gender"  checked="checked"/>&nbsp;
                                                                Female</label>
                                                                <?php }?><?php echo form_error('gender', '<div class="error">', '</div>'); ?>
                                                                
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          <?php */?>
                                            
                                           
                                            <hr/>
                                            <h3>Contact Details</h3>
                                             <div class="form-group"><label class="col-sm-3 control-label">External Email</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-9">
													<input type="text" placeholder="External email" class="form-control" name="ext_email" id="ext_email" value="<?php if(isset($_POST['ext_email'])){echo $_POST['ext_email'];} else{  echo $studentinfo[0]->std_email;}?>"/><?php echo form_error('ext_email', '<div class="error">', '</div>'); ?>
															
														
													</div>
                                                    </div>
                                                </div>
                                            </div>

											<div class="form-group"><label class="col-sm-3 control-label">Internal Email</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-9">
														
														<input type="text" placeholder="Internal email" class="form-control" name="int_email" id="int_email" value="<?php if(isset($_POST['int_email'])){echo $_POST['int_email'];} else{  echo $studentinfo[0]->Email_Internal;}?>"/><?php echo form_error('int_email', '<div class="error">', '</div>'); ?>
														
														</div>
                                                    </div>
                                                </div>
                                            </div>
											
											
											
                                            <div class="form-group"><label class="col-sm-3 control-label">Mobile Phone</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-9"><input type="text" placeholder="mobile phone" class="form-control" name="phone" id="phone" value="<?php if(isset($_POST['phone'])){echo $_POST['phone'];} else{  echo $studentinfo[0]->std_phone;}?>"/><?php echo form_error('phone', '<div class="error">', '</div>'); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group"><label class="col-sm-3 control-label">Address</label>

                                                <div class="col-sm-9 controls">
                                                    <div class="row">
                                                        <div class="col-xs-9"><input type="text" placeholder="Address" class="form-control" name="address" id="address" value="<?php if(isset($_POST['address'])){echo $_POST['address'];} else{  echo $studentinfo[0]->std_address;}?>"/><?php echo form_error('address', '<div class="error">', '</div>'); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                          
                                            <hr/>
                                            <div class="row" align="center">
                                            <div class="error" align="center">
                                                    <?php if(isset($report))
													{
														
													echo $report;	
													}?></div>
                                              <?php 
													echo form_submit('update', 'Update','class="btn btn-green"');
													?>
                                                    </div>
                                         <?php

echo form_close();
	?>
                                    </div>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--END CONTENT--><!--BEGIN FOOTER-->
            <?php 


$this->load->view('footer');

?>
            <!--END FOOTER--></div>
        <!--END PAGE WRAPPER--></div>
</div>
   
         
</body>
</html> 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
