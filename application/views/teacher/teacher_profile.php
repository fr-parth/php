<!--style added by Pranali for SMC-4077 (SMC-4184) on 13-11-19--->
<style type="text/css">
	.mandatory{color: red;}
	.datepicker {
z-index: 9999;
top: 70px !important;
left: 0;
padding: 4px;
margin-top: 1px;
-webkit-border-radius: 4px;
-moz-border-radius: 4px;
border-radius: 4px;
}
</style>
<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
    <div class="container-fluid">
		<div class="row clearfix">
				<head>
					<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/validation.js"></script>
					<script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/ajax.js" /></script>
					<!-- Bootstrap Date-Picker Plugin -->
					<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
					<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
				</head>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<form method="post" action=" " >	
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				  <div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingOne">
					<div><?php if($this->session->flashdata('msg')): ?>
						<p><?php //echo $this->session->flashdata('msg'); ?></p>
						<?php endif; ?>
					</div>
					  <h4 class="panel-title">
						<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="alert alert-success">
						  Basic Information
						</a>
					  </h4>
					</div>
					<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
					  <div class="panel-body">
						<div class="form1">
							<label class="control-label" for="fullName">Full Name:</label>
							<div class="">
							  <input type="text" class="form-control" maxlength="40" name="fullName" id="fullName" placeholder="Enter Full Name" value="<?php echo $teacher_info[0]->t_complete_name;?>"  >
							  <?php echo form_error('fullName', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
						</div>
						
						<!--<div class="form1">
							<label class="control-label" for="firstName">First Name:</label>
							<div class="">
							  <input type="text" class="form-control" maxlength="15" name="firstName" id="firstName" placeholder="Enter First Name" value="<?php //echo $teacher_info[0]->t_name;?>"  >
							  <?php //echo form_error('firstName', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
						</div>
						<div class="form1">
							<label class="control-label" for="midName">Middle Name:</label>
							<div class="">
							  <input type="text" class="form-control" maxlength="15" name="midName" id="midName" placeholder="Enter Middle Name" value="<?php //echo $teacher_info[0]->t_middlename;?>">
							  <?php //echo form_error('midName', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
						</div>
						<div class="form1">
							<label class="control-label " for="lastName">Last Name:</label>
							<div class="">
							  <input type="text" class="form-control" maxlength="15" name="lastName" id="lastName" placeholder="Enter Last Name" value="<?php //echo $teacher_info[0]->t_lastname;?>"  >
							  <?php //echo form_error('lastName', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
						</div>-->
						<div class="form1" id='datepicker'>
						  <label class="control-label" for="dob">Date of Birth:</label>
						  <div class="">
						  <input class="form-control" id="date" name="date" placeholder="YYYY-MM-DD" type="text" value="<?php
						  if($teacher_info[0]->t_dob == '0000-00-00'){
							 echo $date = ""; 
						  }else{
						  echo $date = date("Y-m-d", strtotime($teacher_info[0]->t_dob));
						  }
						  ?>"/>
						</div>
						</div>
						<div class="form1">
							<label class="control-label" for="qualification">Qualification:</label>
							<div class="">
							  <input type="text" class="form-control" maxlength="20" name="qualification" id="qualification" placeholder="Enter Qualification" value="<?php echo $teacher_info[0]->t_qualification;?>">
							  <?php echo form_error('qualification', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
						</div>
						<div class="form1">
							<label class="control-label" for="gender">Gender:</label>
							<div class="">
								 <input name="gender" type="radio" id="genderM" value="Male" <?php if($teacher_info[0]->t_gender =='Male') echo "checked";?>/>
								 Male
								 <input name="gender" type="radio" id="genderF" value="Female" <?php if($teacher_info[0]->t_gender =='Female') echo "checked";?>/>
								 Female
								 <?php echo form_error('gender', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
						</div>
							<div class="form_button">
							  <button type="submit" name="basic_submit" class="myButton form2" value="Submit" onclick="return teacher_basic_info();">Submit</button>
							</div>
						 
					</div>
				  </div>
				  <div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingTwo">
					  <h4 class="panel-title">
						<a class="collapsed alert alert-info" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" >
						  Contact Details
						</a>
					  </h4>
					</div>
					<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
					  <div class="panel-body">	
                      <div class="form1">					  
							<label class="control-label" for="countryCode">Country Code:</label>
							<div class="">
							  <input type="number" class="form-control" maxlength="3" name="countryCode" id="countryCode" placeholder="Enter Country Code" value="<?php echo $teacher_info[0]->CountryCode;?>"  >
							  <?php echo form_error('countryCode', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
							</div>
							<div class="form1">
							<label class="control-label" name="countryName" for="countryName">Country Name:</label>
							<div class=""> 
							  <input type="text" class="form-control" maxlength="15" name="countryName" id="countryName" placeholder="Enter Country Name" value="<?php echo $teacher_info[0]->t_country;?>"  >
							  <?php echo form_error('countryName', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
							</div>
							<div class="form1">
							<label class="control-label " for="mobileNumber">Mobile Number:</label>
							<div class=""> 
							  <input type="number" class="form-control" maxlength="10" name="mobileNumber" id="mobileNumber" placeholder="Enter Mobile Number" value="<?php echo $teacher_info[0]->t_phone;?>"  >
							  <?php echo form_error('mobileNumber', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
							</div>
							<div class="form1">
							<label class="control-label" for="landline">Landline Number:</label>

							<div class="">
							  <input type="number" class="form-control" maxlength="12" name="landLine" id="landLine" placeholder="Enter Landline Number" value="<?php echo $teacher_info[0]->t_landline;?>" >
							  <?php echo form_error('landLine', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>	
							
							</div>
							<div class="form1">
							<label class="control-label" for="emailId">Email Id:</label>
							<div class=""> 
							  <input type="email" class="form-control" maxlength="35" name="emailId" id="emailId" placeholder="Enter Email Id" value="<?php echo $teacher_info[0]->t_email;?>"  >
							  <?php echo form_error('emailId', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
							</div>
							<div class="form1">
							<label class="control-label" for="address">Address:</label>
							<div class="">
							  <input type="text" class="form-control" name="address" id="address" placeholder="Enter Address" value="<?php echo $teacher_info[0]->t_address;?>" >
							  <?php echo form_error('address', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>	
							<!-- <div class=""> 
							  <textarea class="form-control" name="address" id="address" placeholder="Enter Address"  ><?php echo $teacher_info[0]->t_address;?></textarea>
							  <?php //echo form_error('address', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div> -->
							</div>
							<div class="form1">
							<label class="control-label" for="pinCode">Pin Code:</label>
							<div class=""> 
							  <input type="number" class="form-control" maxlength="6" name="pinCode" id="pinCode" placeholder="Enter Pin Code" value="<?php echo $teacher_info[0]->t_permanent_pincode;?>"  >
							  <?php echo form_error('pinCode', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
							</div>
							<div class="form_button">
							  <button type="submit" name="contact_submit" class="myButton form2" value="Submit" onclick="return teacher_contact_info();">Submit</button>
							</div>
					  </div>
					</div>
				  </div>
				  <div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingThree">
					  <h4 class="panel-title">
						<a class="collapsed alert alert-warning" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						  Work Place
						</a>
					  </h4>
					</div>
					<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
					  <div class="panel-body">
					  <div class="form1">
							<label class="control-label" for="schoolName"><?php echo ($this->session->userdata('usertype')=='teacher')?'School':'Organization'; ?> Name:</label>
							<div class=""> 
							  <input type="text" class="form-control" id="schoolName" value="<?php echo $teacher_info[0]->t_current_school_name;?>" readonly disabled/>
							</div>
							</div>
							
							<div class="form1">
<label class="control-label" for="department">Department:</label> 
<select name="department"  id="department" class="profile_present form-control " >
<option value="">--- Choose a Department ---</option>
<?php
 
// print_r($getalldepartment);		
 foreach($getalldepartment as $dptname)
 {
?>
 <?php //echo form_error('department', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); 
  ?>
  <option value="<?php echo $dptname->Dept_Name; ?>"
  <?php 
       if($dptname->Dept_Name == $teacher_info[0]->t_dept)
	    {
		//echo ' ' .$dptname;
		echo "$dptname";} ?> ><?php echo $dptname->Dept_Name; ?></option>

     <?php } 
	 // echo "</select>";
	 ?> 
	<?php 
	   if(!in_array("{$teacher_info[0]->t_dept}",$dptother))
	   { 
		?>
    <option value="<?php echo $teacher_info[0]->t_dept; ?>" selected ><?php echo $teacher_info[0]->t_dept ; ?></option>
     <?php }
	 ?>  
</select>
	   </div>	
						
							
							</div>
							<div class="form1">
							<label class="control-label" for="teacherId"><?php echo ($this->session->userdata('usertype')=='teacher')?'Teacher':'Manager'; ?> ID:</label>
							<div class=""> 
							  <input type="text" class="form-control" id="teacherId" value="<?php echo $teacher_info[0]->t_id;?>" readonly disabled/>
							</div>
							</div>
							<div class="form1">
							<label class="control-label" for="experience">Experience Years:</label>
							<div class=""> 
							  <input type="text" class="form-control" maxlength="3" id="experience" name="experience" value="<?php echo $teacher_info[0]->t_exprience;?>" />
							  <?php echo form_error('experience', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
							</div>
							<div class="form1">
							<label class="control-label" for="internalEmail">Internal Email Id:</label>
							<div class="">
							  <input type="email" class="form-control" maxlength="35" name="internalEmail" id="internalEmail" placeholder="Enter Internal Email" value="<?php echo $teacher_info[0]->t_internal_email;?>" >
							  <?php echo form_error('internalEmail', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>	
							</div>	
<!--Designation field added by Pranali for SMC-4022 on 10-12-19 -->
							<div class="form1">
<label class='control-label '>Designation</label>
<select class='form-control' id='designation' name="designation" placeholder='Enter Designation'>
<option value=""> Select Designation</option>
<!-- <div class=''> -->
<?php
	
 foreach($getalldesignation as $des)
	  { 		
		// echo $des['designation'];exit;
	?>               
 <option value="<?php echo $des->designation; ?>"<?php
  if($des->designation == $teacher_info[0]->t_designation){
	echo $des->designation;		
		} ?> ><?php echo $des->designation; ?>
	</option>
     <?php } ?>
     <?php 
	   if(!in_array("{$teacher_info[0]->t_designation}",$dptother))
	   { 
		?>
    <option value="<?php echo $teacher_info[0]->t_designation; ?>" selected ><?php echo $teacher_info[0]->t_designation ; ?></option>
     <?php } ?>     
    </select>
	   
   </div>		
<!--Added 5 new fields for teacher id by Pranali for SMC-5134 on 2-2-21-->
<?php if ($teacher_info[0]->sctype == 'school') { ?>
							<div class="form1">
							<label class="control-label" for="group_teacher_id"> Group Teacher ID:</label>
							<div class="">
							  <input type="text" class="form-control" name="group_teacher_id" id="group_teacher_id" placeholder="Enter Group Teacher ID" value="<?php echo $teacher_info[0]->group_teacher_id;?>" autocomplete="off">
							  
							</div>	
							</div>			

							<div class="form1">
							<label class="control-label" for="state_group_teacher_id">State Group Teacher ID:</label>
							<div class="">
							  <input type="text" class="form-control" name="state_group_teacher_id" id="state_group_teacher_id" placeholder="Enter State Group Teacher ID" value="<?php echo $teacher_info[0]->state_group_teacher_id;?>" autocomplete="off">
							  
							</div>	
							</div>

							<div class="form1">
							<label class="control-label" for="edu_org_teacher_id"> Education Teacher ID:</label>
							<div class="">
							  <input type="text" class="form-control" name="edu_org_teacher_id" id="edu_org_teacher_id" placeholder="Enter Education Teacher ID" value="<?php echo $teacher_info[0]->edu_org_teacher_id;?>" autocomplete="off">
							  
							</div>	
							</div>

							<div class="form1">
							<label class="control-label" for="edu_org_id"> Education Organization ID:</label>
							<div class="">
							  <input type="text" class="form-control" name="edu_org_id" id="edu_org_id" placeholder="Enter Education Organization ID" value="<?php echo $teacher_info[0]->edu_org_id;?>" autocomplete="off">
							  
							</div>	
							</div>

							<div class="form1">
							<label class="control-label" for="state_group_id">State Group ID:</label>
							<div class="">
							  <input type="text" class="form-control" name="state_group_id" id="state_group_id" placeholder="Enter State Group ID" value="<?php echo $teacher_info[0]->state_group_id;?>" autocomplete="off">
							  
							</div>	
							</div>	
<?php } ?>
							<div class="form_button">
							  <button type="submit" name="work_submit" class="myButton form2" value="Submit" onclick="return teacher_work_info();">Submit</button>
							</div>
					  </div>
					</div>
				  </div>
				  <div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingThree">
					  <h4 class="panel-title">
						<a class="collapsed alert alert-danger" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
						  Change Password
						</a>
					  </h4>
					</div>
					<div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
					  <div class="panel-body">
					  <div class="form_new">
							<label class="control-label" for="oldPassword">Old Password:</label>
							<div class=""> 
							  <input type="password" class="form-control" id="oldPassword" name="oldPassword" autocomplete ="off"placeholder="Enter Old Password" />
							  <div id="chk_old"></div>
							  <?php echo form_error('oldPassword', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
							</div>
							<div class="form_new">
							<label class="control-label" for="newPassword">New Password:</label>
							<div class=""> 
							 <input type="password" class="form-control" id="newPassword" name="newPassword" autocomplete ="off" placeholder="Enter New Password" />
							 <?php echo form_error('newPassword', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
							</div>
							<div class="form_new">
							<label class="control-label" for="confPassword">Confirm Password:</label>
							<div class=""> 
							  <input type="password" class="form-control" id="confPassword" name="confPassword" autocomplete ="off" placeholder="Confirm New Password" />
							  <?php echo form_error('confPassword', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
							</div>
									</div>				 
							<div class="form_button">
							  <button type="submit" name="pass_submit" class="myButton form2" value="Submit" onclick="return teacher_pass_info();">Submit</button>
							</div>
					  </div>
					</div>
				  </div>
				</div>
				</div>
			</form>
		</div>
	</div>		
</div>		
<!--////*********datepicker*******////////-->
<script>
	//format changed from dd-mm-yyyy to yyyy-mm-dd & startDate, endDate, yearRange added by Pranali for SMC-4077,SMC-3995 on 13-11-19
	var options={
        format: 'yyyy-mm-dd',
		startDate: '1919-01-01',
		endDate: '2001-12-31',
        yearRange: '1919:2001',
		todayHighlight: true,
        autoclose: true
      };
	$('#date').datepicker(options);
</script>
<!--	////*********Ends datepicker*******////////-->