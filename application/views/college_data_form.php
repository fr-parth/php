<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Add AICTE college information for 360 implementation">

    <title>College Information</title>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans">
    <link href="<?= base_url('core/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" >
    <link href="<?= base_url('Assets/css/bootstrap.css'); ?>" rel="stylesheet" type="text/css" >
    <link href="<?= base_url('css/bower_components/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
<link href="<?= base_url('core/css/bootstrap-datetimepicker.min.css');?>" rel="stylesheet" media="screen">
</head>
<body style="font-family: 'Open Sans', serif;">
<div class="container-fluid">
    <br>
	<style>
	input, select, textarea{
    color: #ff0000;
}
body{
    font-size: 16px;
    font-weight: bold;
}
</style>
    <form id="facultyDetailsForm" action="<?= base_url('AICTEcollegeinfo/InsertCollege_data');?>" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
            <div class="col-md-12 text-center" id="mainApplicationdiv" style="background-color: #FFFFFF;">
			 <div class="row">
        <div class="col-md-2">
      <!--image -->
	  <label for="name"><img src="<?php echo base_url('/core/Images/250_86.png');?>" height="100px"></label>
     </div>
	 <div class="col-md-2 col-md-offset-3">
      <!--image 
	  <label for="name"><img src="<?php //echo base_url('/images/pblogoname.jpg');?>" height="100px"></label>-->
     </div>
    <div class="col-md-2 col-md-offset-3">
      <!--image 
	  <label for="name"><img src="<?php// echo $GLOBALS['URLNAME']."/image/ProLogoOnly.png";?>" height="100px" width="200px"></label>-->
	  <label for="name"><img src="<?php echo base_url('/image/aicte_logo.webp');?>" height="100px" ></label>
     </div>
    </div>
			
			
			
                <div class="col-lg-12 col-md-12 form-group">
                    <h2>College Readiness for the Implementation of 360 Degree Feedback </h2>
                </div>
                <!-- <div class="col-lg-12 col-md-12 form-group">
                    <b>Basic Details of Institute</b><br> <a data-toggle="modal" data-target="#searchCollegesModal">Click here to Search your college</a>
                </div> -->
                <div class="form-group required">
                    <label for="state" class="col-md-3 control-label">State:</label>
                    <div class="col-lg-3 col-md-3">
                        <input class="form-control" name="state" id="state" placeholder="Enter College State" type="text" <?php if(!empty($college_detail->aicte_application_id) || !empty($college_detail->aicte_permanent_id)){ echo 'readonly';} ?> value="<?= $college_detail->scadmin_state;?>" autocomplete="off">
                    </div>
                    <label for="city" class="col-md-1 control-label">City:</label>
                    <div class="col-lg-3 col-md-3">
                        <input class="form-control" name="city" id="city" placeholder="Enter College City" type="text" <?php if(!empty($college_detail->aicte_application_id) || !empty($college_detail->aicte_permanent_id)){ echo 'readonly';} ?> value="<?= $college_detail->scadmin_city;?>" autocomplete="off">
                    </div>
                    <div class="col-md-2">
                        <?php if(empty($college_detail->aicte_application_id) && empty($college_detail->aicte_permanent_id)){?>
                        <button class="btn btn-warning btn-block" type="button" id="search">Search</button>
                        <?php } ?>
                    </div>
                </div>
                <div class="form-group required">
                    <label for="EmploymentType" class="col-md-3 control-label">College Name:<b style="color:red">*</b></label>
                    <div class="col-lg-7 col-md-7">
                        <span id="college_alert"></span>
                        <span id="college_list_div">
                        <?php if(empty($college_detail->aicte_application_id) && empty($college_detail->aicte_permanent_id)){?>
                            <select name="colleges" id="colleges" class="searchselect form-control" required="required">
                            <option value=""> - Select College - </option> 
                            </select>
                        <?php }else{ ?>
                            <input type="text" class="form-control" value="<?= $college_detail->school_name; ?>" readonly>
                            <input type="hidden" name="colleges" value="<?= $college_detail->school_id; ?>" readonly>
                        <?php } ?>
                        </span>
                        <input type="hidden" name="clg_name" id="clg_name" value="<?= $college_detail->school_name; ?>" />
                    </div>
                </div>
                <div class="form-group required">
                    <label for="apply_id" class="col-md-3 control-label">AICTE Application ID:<b style="color:red">*</b></label>
                    <div class="col-lg-7 col-md-7">
                        <input class="form-control" name="apply_id" id="apply_id" placeholder="Enter AICTE Application ID" type="text" value="<?= $college_detail->aicte_application_id;?>" <?php if(!empty($college_detail->aicte_application_id) || !empty($college_detail->aicte_permanent_id)){ echo 'readonly';} ?> required="required">
                    </div>
					<div class="col-md-2">
                        <?php if(empty($college_detail->aicte_application_id) && empty($college_detail->aicte_permanent_id)){?>
                        <button class="btn btn-warning btn-block" type="button" id="search1">Search</button>
                        <?php } ?>
                    </div>
                </div>
                <div class="form-group required">
                    <label for="Name" class="col-md-3 control-label">AICTE Permanent ID:</label>
                    <div class="col-lg-7 col-md-7">
                        <input class="form-control" name="aicte_id" id="aicte_id" placeholder="Enter AICTE Permanent ID" type="text" <?php if(!empty($college_detail->aicte_application_id) || !empty($college_detail->aicte_permanent_id)){ echo 'readonly';} ?> value="<?= $college_detail->aicte_permanent_id;?>" required="required">
                    </div>
					<div class="col-md-2">
                        <?php if(empty($college_detail->aicte_application_id) && empty($college_detail->aicte_permanent_id)){?>
                        <button class="btn btn-warning btn-block" type="button" id="search2">Search</button>
                        <?php } ?>
                    </div>
                </div>

                <!-- <div class="form-group required">
                    <label for="EmploymentType" class="col-md-3 control-label">College Name:<b style="color:red">*</b></label>
                    <div class="col-lg-7 col-md-7">
                            <select name="EmploymentType" id="EmploymentType" class="form-control" required="required">
                            <option value=""> - Select College - </option>
                            <?php foreach($college_list as $cl){ ?>
                                <option value="<?= $cl->school_id;?>"><?= $cl->school_name;?> </option>
                            <?php } ?>
                        </select>
                    </div>
                </div> -->
                <hr>
                <div class="form-group" style="background-color: #d3d3d3;
    padding: 10px 0;">
                  <!--  <div class="col-lg-12 col-md-12">
                            We would like to implement the Protsahan Bharati, 360 Degree Feedback program in our college from : <input type="text" name="implement_dt" class="datepicker" />

                    </div>-->
					 
					<label for="Name" class="col-md-10 control-label"><b style="font-size: 20px;">We would like to implement the Protsahan Bharati, 360 Degree Feedback program in our college from :</b></label>
                    <div class=" col-md-2">
                        <input class="form-control datepicker" name="implement_dt" id="implement_dt"  type="text" placeholder="YYYY-MM-DD" autocomplete="off" required>
                    </div>
                </div>
				 <hr>
                <div class="form-group">
                    <div class="col-lg-12 col-md-12 text-justify">
                        We would share the Non Confidential, Public Domain Data like the Organization Data, Master Entity Data and Mapping Data with Smart Cookie Rewards Pvt. Ltd.   Public Domain Data of the Institution like Degrees offered, Department Name, Different Branches, Subjects offered, Students List, Teachers List, Teacher Student Subject Mapping.                     

                    </div>
               <div class="row">
			   <div class="col-md-12">
			   <label><h3>Details of person entering the form</h3></label>
				</div>
			   </div>
				
				<div class="row">
  <div class="col-md-6">
   <div class="form-group required">
                    <label for="informer_name" class="col-md-3 control-label">Name:<b style="color:red">*</b></label>
                    <div class="col-lg-7 col-md-7">
                        <input class="form-control" name="informer_name" id="informer_name" placeholder="Name" type="text" autocomplete="off" required="required">
                    </div>
                </div> 
</div>				
  <div class="col-md-6">
    <div class="form-group required" >
                    <label for="designation" class="col-md-3 control-label">Designation:<b style="color:red">*</b></label>
                    <div class="col-lg-7 col-md-7">
                        <input class="form-control" name="designation" id="designation" placeholder="Enter Designation" type="text" autocomplete="off" required="required">
                    </div>
                </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
   <div class="form-group required">
                    <label for="email_id" class="col-md-3 control-label">Email ID:<b style="color:red">*</b></label>
                    <div class="col-lg-7 col-md-7">
                        <input class="form-control" name="email_id" id="email_id" placeholder="Enter Email ID" type="email" autocomplete="off" required="required">
                    </div>
                </div> 
</div>				
  <div class="col-md-6">
    <div class="form-group required" >
                    <label for="phone_no" class="col-md-3 control-label">Phone Number:<b style="color:red">*</b></label>
                    <div class="col-lg-7 col-md-7">
                        <input class="form-control" name="phone_no" id="phone_no" placeholder="Enter Phone Number" type="phone" autocomplete="off" required="required">
                    </div>
                </div>
  </div>
</div>

                <!-- <div class="form-group required" >
                    <label for="info_date" class="col-md-3 control-label">Date:<b style="color:red">*</b></label>
                    <div class="col-lg-7 col-md-7">
                        <input class="form-control" name="info_date" id="info_date" placeholder="Enter Date" type="text"  required="required">
                    </div>
                </div> -->
                
                <!-- <div class="col-lg-12 col-md-12 form-group">
                    <b>Basic Details of Institute</b><br> <a data-toggle="modal" data-target="#searchCollegesModal">Click here to Search your college</a>
                </div> -->
				<div class="row">
			   <div class="col-md-12">
			   <label><h3>Some Of The Following People Can Help In The Implementation</h3></label>
				</div>
			   </div>
				
                <div class="form-group" >
                    <div class="col-lg-12 col-md-12 table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <th style="width: 3%;">Sr.</th>
                                <th style="width: 30%;">In-charge Details</th>
                                <th style="width: 25%;">Name of In-charge</th>
                                <th style="width: 11%;">Mobile No</th>
                                <th style="width: 16%;">Email Id</th>
                                <th style="width: 15%;">Meeting Date & Time</th>
                            </thead>
                            <tbody class="text-justify">
                                <tr>
                                    <td>1</td>
                                    <td>ERP In charge or person responsible for Admission / Time Table</td>
                                    <td><input class="form-control" type="text" name="erp_incharge_nm" id="erp_incharge_nm" placeholder="Enter Name"></td>
                                    <td><input class="form-control" type="text" name="erp_incharge_mob" id="erp_incharge_mob" placeholder="Enter Mobile No."></td>
                                    <td><input class="form-control" type="text" name="erp_incharge_email" id="erp_incharge_email" placeholder="Enter Email ID"></td>
                                    <td><input class="form-control datetimepick" name="erp_meet_date" id="erp_meet_date"  type="text" placeholder="YYYY-MM-DD H:M" autocomplete="off" data-date-format="YYYY-MM-DD - HH:ii p" data-link-field="dtp_input1"></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>IT In charge who is responsible for or has knowledge of Data and how to Extract Data from Database.</td>
                                    <td><input class="form-control" type="text" name="it_incharge_nm" id="it_incharge_nm" placeholder="Enter Name"></td>
                                    <td><input class="form-control" type="text" name="it_incharge_mob" id="it_incharge_mob" placeholder="Enter Mobile No."></td>
                                    <td><input class="form-control" type="text" name="it_incharge_email" id="it_incharge_email" placeholder="Enter Email ID"></td>
                                    <td><input class="form-control datetimepick" name="it_meet_date" id="it_meet_date"  type="text" placeholder="YYYY-MM-DD H:M" autocomplete="off" data-link-field="dtp_input1"></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Details of Person who will authorize giving the data to AICTE </td>
                                    <td><input class="form-control" type="text" name="aicte_incharge_nm" id="aicte_incharge_nm" placeholder="Enter Name"></td>
                                    <td><input class="form-control" type="text" name="aicte_incharge_mob" id="aicte_incharge_mob" placeholder="Enter Mobile No."></td>
                                    <td><input class="form-control" type="text" name="aicte_incharge_email" id="aicte_incharge_email" placeholder="Enter Email ID"></td>
                                    <td><input class="form-control datetimepick" name="aicte_meet_date" id="aicte_meet_date"  type="text" placeholder="YYYY-MM-DD H:M" autocomplete="off" data-link-field="dtp_input1"></td>
                                </tr> 
                                <tr>
                                    <td>4</td>
                                    <td>TPO Details </td>
                                    <td><input class="form-control" type="text" name="tpo_incharge_nm" id="tpo_incharge_nm" placeholder="Enter Name"></td>
                                    <td><input class="form-control" type="text" name="tpo_incharge_mob" id="tpo_incharge_mob" placeholder="Enter Mobile No."></td>
                                    <td><input class="form-control" type="text" name="tpo_incharge_email" id="tpo_incharge_email" placeholder="Enter Email ID"></td>
                                    <td><input class="form-control datetimepick" name="tpo_meet_date" id="tpo_meet_date"  type="text" placeholder="YYYY-MM-DD H:M" autocomplete="off" data-link-field="dtp_input1"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="5">
                                        <label>Do You Need Help In Placement?</label>  &emsp;&emsp;
                                        <input type="radio" name="place_help" class="intern_help" id="intern_help_Y" value="Yes" checked> Yes &emsp;&emsp;
                                        <input type="radio" name="place_help" class="intern_help" id="intern_help_N" value="No"> NO
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>5</td>
                                    <td>Clubs / Art Circle In charge Details</td>
                                    <td><input class="form-control" type="text" name="art_incharge_nm" id="art_incharge_nm" placeholder="Enter Name"></td>
                                    <td><input class="form-control" type="text" name="art_incharge_mob" id="art_incharge_mob" placeholder="Enter Mobile No."></td>
                                    <td><input class="form-control" type="text" name="art_incharge_email" id="art_incharge_email" placeholder="Enter Email ID"></td>
                                    <td><input class="form-control datetimepick" name="art_meet_date" id="art_meet_date"  type="text" placeholder="YYYY-MM-DD H:M" autocomplete="off" data-link-field="dtp_input1"></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Student Affairs In charge Details </td>
                                    <td><input class="form-control" type="text" name="student_incharge_nm" id="student_incharge_nm" placeholder="Enter Name"></td>
                                    <td><input class="form-control" type="text" name="student_incharge_mob" id="student_incharge_mob" placeholder="Enter Mobile No."></td>
                                    <td><input class="form-control" type="text" name="student_incharge_email" id="student_incharge_email" placeholder="Enter Email ID"></td>
                                    <td><input class="form-control datetimepick" name="student_meet_date" id="student_meet_date"  type="text" placeholder="YYYY-MM-DD H:M" autocomplete="off" data-link-field="dtp_input1"></td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Admin In charge for Putting up posters, allotting room for campus radio </td>
                                    <td><input class="form-control" type="text" name="admin_incharge_nm" id="admin_incharge_nm" placeholder="Enter Name"></td>
                                    <td><input class="form-control" type="text" name="admin_incharge_mob" id="admin_incharge_mob" placeholder="Enter Mobile No."></td>
                                    <td><input class="form-control" type="text" name="admin_incharge_email" id="admin_incharge_email" placeholder="Enter Email ID"></td>
                                    <td><input class="form-control datetimepick" name="admin_meet_date" id="admin_meet_date"  type="text" placeholder="YYYY-MM-DD H:M" autocomplete="off" data-link-field="dtp_input1"></td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>Exam Cell In charge </td>
                                    <td><input class="form-control" type="text" name="exam_incharge_nm" id="exam_incharge_nm" placeholder="Enter Name"></td>
                                    <td><input class="form-control" type="text" name="exam_incharge_mob" id="exam_incharge_mob" placeholder="Enter Mobile No."></td>
                                    <td><input class="form-control" type="text" name="exam_incharge_email" id="exam_incharge_email" placeholder="Enter Email ID"></td>
                                    <td><input class="form-control datetimepick" name="exam_meet_date" id="exam_meet_date"  type="text" placeholder="YYYY-MM-DD H:M" autocomplete="off" data-link-field="dtp_input1"></td>
                                </tr>
                             <!--   <tr>
                                    <td>9</td>
                                    <td colspan="4">Various Clubs in the Institute</td>
                                    <!-- <td><input class="form-control" type="text" name="erp_incharge_nm"></td>
                                    <td><input class="form-control" type="text" name="erp_incharge_mob"></td>
                                    <td><input class="form-control" type="text" name="erp_incharge_email"></td> //--
                                </tr> -->
                                <tr>
                                    <td>9</td>
                                    <td>Name of Club: &emsp; NSS</td>
                                    <td><input class="form-control" type="text" name="nss_incharge_nm" id="nss_incharge_nm" placeholder="Enter Name"></td>
                                    <td><input class="form-control" type="text" name="nss_incharge_mob" id="nss_incharge_mob" placeholder="Enter Mobile No."></td>
                                    <td><input class="form-control" type="text" name="nss_incharge_email" id="nss_incharge_email" placeholder="Enter Email ID"></td>
                                    <td><input class="form-control datetimepick" name="nss_meet_date" id="nss_meet_date"  type="text" placeholder="YYYY-MM-DD H:M" autocomplete="off" data-link-field="dtp_input1"></td>
                                </tr>
                                <!-- <tr>
                                    <td></td>
                                    <td>Name of Club: &emsp; NCC</td>
                                    <td><input class="form-control" type="text" name="ncc_incharge_nm" placeholder="Enter Name"></td>
                                    <td><input class="form-control" type="text" name="ncc_incharge_mob" placeholder="Enter Mobile No."></td>
                                    <td><input class="form-control" type="text" name="ncc_incharge_email" placeholder="Enter Email ID"></td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td colspan="4">Student Unions in the Institute </td>
                                    <!-- <td><input class="form-control" type="text" name="erp_incharge_nm"></td>
                                    <td><input class="form-control" type="text" name="erp_incharge_mob"></td>
                                    <td><input class="form-control" type="text" name="erp_incharge_email"></td> //--
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Name : &emsp; ABVP</td>
                                    <td><input class="form-control" type="text" name="abvp_incharge_nm" placeholder="Enter Name"></td>
                                    <td><input class="form-control" type="text" name="abvp_incharge_mob" placeholder="Enter Mobile No."></td>
                                    <td><input class="form-control" type="text" name="abvp_incharge_email" placeholder="Enter Email ID"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Name : &emsp; NSUI</td>
                                    <td><input class="form-control" type="text" name="nsui_incharge_nm" placeholder="Enter Name"></td>
                                    <td><input class="form-control" type="text" name="nsui_incharge_mob" placeholder="Enter Mobile No."></td>
                                    <td><input class="form-control" type="text" name="nsui_incharge_email" placeholder="Enter Email ID"></td>
                                </tr> -->
                                <tr id="placement_row">
                                    <td>10</td>
                                    <td>Any Other Contact Person</td>
                                    <td><input class="form-control" type="text" name="place_incharge_nm" id="placement_incharge_nm" placeholder="Enter Name"></td>
                                    <td><input class="form-control" type="text" name="place_incharge_mob" id="placement_incharge_mob" placeholder="Enter Mobile No."></td>
                                    <td><input class="form-control" type="text" name="place_incharge_email" id="placement_incharge_email" placeholder="Enter Email ID"></td>
                                    <td><input class="form-control datetimepick" name="placement_meet_date" id="placement_meet_date"  type="text" placeholder="YYYY-MM-DD H:M" autocomplete="off" data-link-field="dtp_input1"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- <div class="col-md-12">
                        <div class="form-group col-md-8 col-md-offset-4">
                            
                        </div>
                    </div> -->
                </div>
                <br>
                <div class="col-md-offset-4 col-lg-2">
                    <button class="btn btn-success btn-block" id="facultyDetailSaveButton" type="Submit">Submit</button>
                </div>
                
                <div class="col-lg-2">
                    <a href="<?= base_url();?>" class="btn btn-danger btn-block" id="BasicDetailSaveButton">Back</a>
                </div>
                <!-- <div class="col-md-4" id="facultyDetailsMessage"></div> -->
            </div>
            <!-- <br><br><b>Note:</b> The identity of the Faculty will not be revealed to the institute and will be kept confidential in the record of AICTE only. However any falsification in the above details will be viewed seriously by AICTE<br><br> -->
            <input type="hidden" name="c_id" id="c_id">
    </form>
</div>

<!-- <div id="searchCollegesModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
        <div class="modal-body">            
               <div class="form-group required">
                    <label for="informer_name" class="col-md-1 control-label">State:</label>
                    <div class="col-lg-4 col-md-4">
                        <input class="form-control" name="state" id="state" placeholder="State" type="text">
                    </div>
                    <label for="informer_name" class="col-md-1 control-label">city:</label>
                    <div class="col-lg-4 col-md-4">
                        <input class="form-control" name="city" id="city" placeholder="Name" type="text">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-warning btn-block" type="button" id="search">Search</button>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group required">
                    <label for="EmploymentType" class="col-md-3 control-label">College Name:<b style="color:red">*</b></label>
                    <div class="col-lg-7 col-md-7">
                            <select name="colleges" id="colleges" class="form-control" required="required">
                            <option value=""> - Select College - </option>
                           
                        </select>
                    </div>
                </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> -->
</body>
    <script type="text/javascript" src="<?= base_url('Assets/js/jquery-1.10.2.min.js');?>"></script>
    <script type="text/javascript" src="<?= base_url('Assets/js/bootstrap.min.js');?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
    <script src="<?= base_url('core/js/bootstrap-datepicker.min.js');?>"></script>
    <script src="<?= base_url('core/js/moment.js');?>"></script>
    <script src="<?= base_url('core/js/locale/bootstrap-datetimepicker.js');?>"></script>
    <script type="text/javascript" src="<?= base_url('core/js/bootstrap-datetimepicker.fr.js');?>" charset="UTF-8"></script>
     <script type="text/javascript">
      $(document).ready(function() {
        $('.searchselect').select2();

        $('.datepicker').datepicker({
          format:'yyyy-mm-dd',
          autoClose:'TRUE',
          startDate: '-0d'
        }).on('changeDate', function(e){
        $(this).datepicker('hide');
        });
        //P added in below format for displaying AM / PM for SMC-4848 on 26-9-20
        $('.datetimepick').datetimepicker({
          weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        format: 'yyyy-mm-dd HH:ii P',
        showMeridian: 1,
        startDate: '+0d'
        });
        $('#colleges').change(function(){
            let clg_name = $("#colleges option:selected").html();
            $("#clg_name").val(clg_name);
			var college_val = $("#colleges").val();
		//alert(college_val);
    		 var strArray = college_val.split("|");
            var college_id=strArray['0'];
    		var apply_id=strArray['1'];
    		var aicte_id=strArray['2'];
    		document.getElementById("apply_id").value = apply_id;
    		document.getElementById("aicte_id").value = aicte_id;
    		//alert(apply_id);alert(app_id);
            $.ajax({
                url:"<?php echo base_url();?>AICTEcollegeinfo/Search_college_data",
                type:"POST",
                data:{
                    sc_id:college_id
                    // ct:city
                },
                dataType: "json",
                success:function(clg){
                    if(clg[0]!=null)
                    {
                        var dtarr=clg[0]['impliment_date'].split("-");
                        var d=dtarr[2];
                        var m=dtarr[1];
                        var y=dtarr[0];
                        $("#c_id").val(clg[0]['id']);
                        // $("#implement_dt").val(d+"-"+m+"-"+y);
                        $('#colleges').html("<option value='"+clg[0]['college_id']+"'>"+clg[0]['college_name']+"</option>");
                        $("#implement_dt").val(clg[0]['impliment_date']);
                        $("#informer_name").val(clg[0]['informer_name']);
                        $("#designation").val(clg[0]['designation']);
                        $("#email_id").val(clg[0]['email_id']);
                        $("#phone_no").val(clg[0]['phone_no']);
                        $("#erp_incharge_nm").val(clg[0]['erp_incharge_nm']);
                        $("#erp_incharge_mob").val(clg[0]['erp_incharge_mob']);
                        $("#erp_incharge_email").val(clg[0]['erp_incharge_email']);
                        $("#it_incharge_nm").val(clg[0]['it_incharge_nm']);
                        $("#it_incharge_mob").val(clg[0]['it_incharge_mob']);
                        $("#it_incharge_email").val(clg[0]['it_incharge_email']);
                        $("#aicte_incharge_nm").val(clg[0]['aicte_incharge_nm']);
                        $("#aicte_incharge_mob").val(clg[0]['aicte_incharge_mob']);
                        $("#aicte_incharge_email").val(clg[0]['aicte_incharge_email']);
                        $("#tpo_incharge_nm").val(clg[0]['tpo_incharge_nm']);
                        $("#tpo_incharge_mob").val(clg[0]['tpo_incharge_mob']);
                        $("#tpo_incharge_email").val(clg[0]['tpo_incharge_email']);
                        $("#art_incharge_nm").val(clg[0]['art_incharge_nm']);
                        $("#art_incharge_mob").val(clg[0]['art_incharge_mob']);
                        $("#art_incharge_email").val(clg[0]['art_incharge_email']);
                        $("#student_incharge_nm").val(clg[0]['student_incharge_nm']);
                        $("#student_incharge_mob").val(clg[0]['student_incharge_mob']);
                        $("#student_incharge_email").val(clg[0]['student_incharge_email']);
                        $("#student_incharge_mob").val(clg[0]['student_incharge_mob']);
                        $("#admin_incharge_nm").val(clg[0]['admin_incharge_nm']);
                        $("#admin_incharge_mob").val(clg[0]['admin_incharge_mob']);
                        $("#admin_incharge_email").val(clg[0]['admin_incharge_email']);
                        $("#exam_incharge_nm").val(clg[0]['exam_incharge_nm']);
                        $("#exam_incharge_mob").val(clg[0]['exam_incharge_mob']);
                        $("#exam_incharge_email").val(clg[0]['exam_incharge_email']);
                        if(clg[0]['placement_help']=="No"){
                            $("#intern_help_N").prop("checked",true);
                        }else{
                            $("#intern_help_Y").prop("checked",true);                            
                        }
                        $("#placement_incharge_nm").val(clg[0]['placement_incharge_nm']);
                        $("#placement_incharge_mob").val(clg[0]['placement_incharge_mob']);
                        $("#placement_incharge_email").val(clg[0]['placement_incharge_email']);
                        $("#nss_incharge_nm").val(clg[0]['nss_incharge_nm']);
                        $("#nss_incharge_mob").val(clg[0]['nss_incharge_mob']);
                        $("#nss_incharge_email").val(clg[0]['nss_incharge_email']);
                        $("#erp_meet_date").val(clg[0]['erp_meet_date']);
                        $("#it_meet_date").val(clg[0]['it_meet_date']);
                        $("#aicte_meet_date").val(clg[0]['aicte_meet_date']);
                        $("#tpo_meet_date").val(clg[0]['tpo_meet_date']);
                        $("#art_meet_date").val(clg[0]['art_meet_date']);
                        $("#student_meet_date").val(clg[0]['student_meet_date']);
                        $("#admin_meet_date").val(clg[0]['admin_meet_date']);
                        $("#exam_meet_date").val(clg[0]['exam_meet_date']);
                        $("#placement_meet_date").val(clg[0]['erp_meet_date']);
                        $("#nss_meet_date").val(clg[0]['nss_meet_date']);
                    }
                }
                // }).done(function(clg){
                //   //alert("Batch="+k);
                //         $('#colleges').html(clg);
            });
        });
		
        // $('.intern_help').change(function(){
        //     var placem=$(this).val();
        //     if(placem=="No"){
        //         $('#placement_row').css("display","none");
        //     }else{
        //         $('#placement_row').css("display","table-row");

        //     }
        // });
      });
    </script>
    <script>
        $("#search").click(function(){
            var state = $("#state").val();
            var city = $("#city").val();
            if(state=="" && city==""){
                alert("Please enter state or city");
            }else{
                $.ajax({
                    url:"<?php echo base_url();?>AICTEcollegeinfo/Search_college_Ajax",
                    type:"POST",
                    data:{
                        st:state,
                        ct:city
                    },
                    beforeSend:function(){
                        $('#college_list_div').css("display","none");
                        $('#college_alert').css("display","block");
                        $('#college_alert').html("Please Wait.....");
                    },
                    success:function(clg){
                        $('#college_alert').css("display","none");
                        $('#college_list_div').css("display","block");
                        $('#colleges').html(clg);
                    }
                // }).done(function(clg){
                //   //alert("Batch="+k);
                //         $('#colleges').html(clg);
                });
            }
        });
    </script>
	 <script>
        $("#search1").click(function(){
        	var str = $("#apply_id").val();			
            if(str==""){
                alert("Please enter AICTE application id");
            }else{
                $.ajax({
                    url:"<?php echo base_url();?>AICTEcollegeinfo/Search_college_info",
                    type:"POST",
                    data:{
                        application_id:str                       
                    },
					dataType: "json",
                    success:function(clg){
					if(clg==null)
					{
						alert("No Record Found");
					}else{
						//var strArray = clg.split(",");
                		var city=clg['0'];
                		var state=clg['1'];
                		var permanent_id=clg['2'];
                		var college_name=clg['3'];
                		//alert(college_name);
                		
                		document.getElementById("city").value = city;
                		document.getElementById("state").value = state;
                		document.getElementById("aicte_id").value = permanent_id;
                		//document.getElementById("colleges").value = college_name;
                		$('#colleges').html(clg['3']);
                        $('#clg_name').val(clg['5']);
                		if(clg[4]!=null)
                        {
                            var dtarr=clg[4]['impliment_date'].split("-");
                            var d=dtarr[2];
                            var m=dtarr[1];
                            var y=dtarr[0];
                            $("#c_id").val(clg[4]['id']);
                            $('#colleges').html("<option value='"+clg[4]['college_id']+"'>"+clg[4]['college_name']+"</option>");
                            // $("#implement_dt").val(d+"-"+m+"-"+y);
                            $("#implement_dt").val(clg[4]['impliment_date']);
                            $("#informer_name").val(clg[4]['informer_name']);
                            $("#designation").val(clg[4]['designation']);
                            $("#email_id").val(clg[4]['email_id']);
                            $("#phone_no").val(clg[4]['phone_no']);
                            $("#erp_incharge_nm").val(clg[4]['erp_incharge_nm']);
                            $("#erp_incharge_mob").val(clg[4]['erp_incharge_mob']);
                            $("#erp_incharge_email").val(clg[4]['erp_incharge_email']);
                            $("#it_incharge_nm").val(clg[4]['it_incharge_nm']);
                            $("#it_incharge_mob").val(clg[4]['it_incharge_mob']);
                            $("#it_incharge_email").val(clg[4]['it_incharge_email']);
                            $("#aicte_incharge_nm").val(clg[4]['aicte_incharge_nm']);
                            $("#aicte_incharge_mob").val(clg[4]['aicte_incharge_mob']);
                            $("#aicte_incharge_email").val(clg[4]['aicte_incharge_email']);
                            $("#tpo_incharge_nm").val(clg[4]['tpo_incharge_nm']);
                            $("#tpo_incharge_mob").val(clg[4]['tpo_incharge_mob']);
                            $("#tpo_incharge_email").val(clg[4]['tpo_incharge_email']);
                            $("#art_incharge_nm").val(clg[4]['art_incharge_nm']);
                            $("#art_incharge_mob").val(clg[4]['art_incharge_mob']);
                            $("#art_incharge_email").val(clg[4]['art_incharge_email']);
                            $("#student_incharge_nm").val(clg[4]['student_incharge_nm']);
                            $("#student_incharge_mob").val(clg[4]['student_incharge_mob']);
                            $("#student_incharge_email").val(clg[4]['student_incharge_email']);
                            $("#student_incharge_mob").val(clg[4]['student_incharge_mob']);
                            $("#admin_incharge_nm").val(clg[4]['admin_incharge_nm']);
                            $("#admin_incharge_mob").val(clg[4]['admin_incharge_mob']);
                            $("#admin_incharge_email").val(clg[4]['admin_incharge_email']);
                            $("#exam_incharge_nm").val(clg[4]['exam_incharge_nm']);
                            $("#exam_incharge_mob").val(clg[4]['exam_incharge_mob']);
                            $("#exam_incharge_email").val(clg[4]['exam_incharge_email']);
                            if(clg[4]['placement_help']=="No"){
                                $("#intern_help_N").prop("checked",true);
                            }else{
                                $("#intern_help_Y").prop("checked",true);                            
                            }
                            $("#placement_incharge_nm").val(clg[4]['placement_incharge_nm']);
                            $("#placement_incharge_mob").val(clg[4]['placement_incharge_mob']);
                            $("#placement_incharge_email").val(clg[4]['placement_incharge_email']);
                            $("#nss_incharge_nm").val(clg[4]['nss_incharge_nm']);
                            $("#nss_incharge_mob").val(clg[4]['nss_incharge_mob']);
                            $("#nss_incharge_email").val(clg[4]['nss_incharge_email']);
                            $("#erp_meet_date").val(clg[4]['erp_meet_date']);
                            $("#it_meet_date").val(clg[4]['it_meet_date']);
                            $("#aicte_meet_date").val(clg[4]['aicte_meet_date']);
                            $("#tpo_meet_date").val(clg[4]['tpo_meet_date']);
                            $("#art_meet_date").val(clg[4]['art_meet_date']);
                            $("#student_meet_date").val(clg[4]['student_meet_date']);
                            $("#admin_meet_date").val(clg[4]['admin_meet_date']);
                            $("#exam_meet_date").val(clg[4]['exam_meet_date']);
                            $("#placement_meet_date").val(clg[4]['erp_meet_date']);
                            $("#nss_meet_date").val(clg[4]['nss_meet_date']);
                        }	
                    }		
                }
                // }).done(function(clg){
                //   //alert("Batch="+k);
                //         $('#colleges').html(clg);
                });
            }
        });
    </script>
	
	 <script>
    $("#search2").click(function(){
		var p_id = $("#aicte_id").val();
		//alert(p_id);
        if(p_id==""){
            alert("Please enter AICTE permanent ID");
        }else{
			//alert(p_id);
            $.ajax({
                url:"<?php echo base_url();?>AICTEcollegeinfo/Search_permanent_id",
                type:"POST",
                data:{
                    permanent_id:p_id
                   
                },
				dataType: "json",
                success:function(clg){
    				if(clg==null)
    				{
    					alert("No Record Found");
    				}else{
    					//var strArray = clg.split(",");
                		var city=clg['0'];
                		var state=clg['1'];
                		var application_id=clg['2'];
                		var college_name=clg['3'];
                		//alert(college_name);
                		
                		document.getElementById("city").value = city;
                		document.getElementById("state").value = state;
                		document.getElementById("apply_id").value = application_id;
                		//document.getElementById("colleges").value = college_name;
                		$('#colleges').html(clg['3']);
                        $('#clg_name').val(clg['5']);
    	               
                       if(clg[4]!=null)
                        {
                            var dtarr=clg[4]['impliment_date'].split("-");
                            var d=dtarr[2];
                            var m=dtarr[1];
                            var y=dtarr[0];
                            $('#colleges').html("<option value='"+clg[4]['college_id']+"'>"+clg[4]['college_name']+"</option>");
                            $("#c_id").val(clg[4]['id']);
                            // $("#implement_dt").val(d+"-"+m+"-"+y);
                            $("#implement_dt").val(clg[4]['impliment_date']);
                            $("#informer_name").val(clg[4]['informer_name']);
                            $("#designation").val(clg[4]['designation']);
                            $("#email_id").val(clg[4]['email_id']);
                            $("#phone_no").val(clg[4]['phone_no']);
                            $("#erp_incharge_nm").val(clg[4]['erp_incharge_nm']);
                            $("#erp_incharge_mob").val(clg[4]['erp_incharge_mob']);
                            $("#erp_incharge_email").val(clg[4]['erp_incharge_email']);
                            $("#it_incharge_nm").val(clg[4]['it_incharge_nm']);
                            $("#it_incharge_mob").val(clg[4]['it_incharge_mob']);
                            $("#it_incharge_email").val(clg[4]['it_incharge_email']);
                            $("#aicte_incharge_nm").val(clg[4]['aicte_incharge_nm']);
                            $("#aicte_incharge_mob").val(clg[4]['aicte_incharge_mob']);
                            $("#aicte_incharge_email").val(clg[4]['aicte_incharge_email']);
                            $("#tpo_incharge_nm").val(clg[4]['tpo_incharge_nm']);
                            $("#tpo_incharge_mob").val(clg[4]['tpo_incharge_mob']);
                            $("#tpo_incharge_email").val(clg[4]['tpo_incharge_email']);
                            $("#art_incharge_nm").val(clg[4]['art_incharge_nm']);
                            $("#art_incharge_mob").val(clg[4]['art_incharge_mob']);
                            $("#art_incharge_email").val(clg[4]['art_incharge_email']);
                            $("#student_incharge_nm").val(clg[4]['student_incharge_nm']);
                            $("#student_incharge_mob").val(clg[4]['student_incharge_mob']);
                            $("#student_incharge_email").val(clg[4]['student_incharge_email']);
                            $("#student_incharge_mob").val(clg[4]['student_incharge_mob']);
                            $("#admin_incharge_nm").val(clg[4]['admin_incharge_nm']);
                            $("#admin_incharge_mob").val(clg[4]['admin_incharge_mob']);
                            $("#admin_incharge_email").val(clg[4]['admin_incharge_email']);
                            $("#exam_incharge_nm").val(clg[4]['exam_incharge_nm']);
                            $("#exam_incharge_mob").val(clg[4]['exam_incharge_mob']);
                            $("#exam_incharge_email").val(clg[4]['exam_incharge_email']);
                            if(clg[4]['placement_help']=="No"){
                                $("#intern_help_N").prop("checked",true);
                            }else{
                                $("#intern_help_Y").prop("checked",true);                            
                            }
                            $("#placement_incharge_nm").val(clg[4]['placement_incharge_nm']);
                            $("#placement_incharge_mob").val(clg[4]['placement_incharge_mob']);
                            $("#placement_incharge_email").val(clg[4]['placement_incharge_email']);
                            $("#nss_incharge_nm").val(clg[4]['nss_incharge_nm']);
                            $("#nss_incharge_mob").val(clg[4]['nss_incharge_mob']);
                            $("#nss_incharge_email").val(clg[4]['nss_incharge_email']);
                            $("#erp_meet_date").val(clg[4]['erp_meet_date']);
                            $("#it_meet_date").val(clg[4]['it_meet_date']);
                            $("#aicte_meet_date").val(clg[4]['aicte_meet_date']);
                            $("#tpo_meet_date").val(clg[4]['tpo_meet_date']);
                            $("#art_meet_date").val(clg[4]['art_meet_date']);
                            $("#student_meet_date").val(clg[4]['student_meet_date']);
                            $("#admin_meet_date").val(clg[4]['admin_meet_date']);
                            $("#exam_meet_date").val(clg[4]['exam_meet_date']);
                            $("#placement_meet_date").val(clg[4]['erp_meet_date']);
                            $("#nss_meet_date").val(clg[4]['nss_meet_date']);
                        }
    				}
                }
            });
        }
    });
    </script>
</html>
