<?php 
include("scadmin_header.php");
	$id=$_SESSION['id'];
	$school_id=$_SESSION['school_id'];
	$sql = mysql_query("SELECT school_id, school_name, scadmin_city, scadmin_state, aicte_permanent_id, aicte_application_id FROM tbl_school_admin WHERE id='$id' ");
        $row = mysql_fetch_assoc($sql);
		
			$sql1 = mysql_query("SELECT * FROM aicte_college_info WHERE college_id='$school_id' ");
        $rows = mysql_fetch_assoc($sql1);
		//print_r($rows);exit;
		//echo $row['scadmin_state'];exit;
	//echo $GLOBALS['URLNAME'];exit;
	 if (isset($_POST['submit'])) {
		 
		$clg_id = $school_id;
		//$exp=explode(',',$clg_id1);
		//$clg_id=$exp['0'];
		$clg_name = $_POST['colleges'];
		$apply_id = $_POST['apply_id'];
		$aicte_id = $_POST['aicte_id'];
		$impliment_date = date("Y-m-d",strtotime($_POST['implement_dt']));
		$informer_name = $_POST['informer_name'];
		$designation = $_POST['designation'];
		$email_id = $_POST['email_id'];
		$phone_no = $_POST['phone_no'];
		$erp_incharge_nm = $_POST['erp_incharge_nm'];
		$erp_incharge_mob = $_POST['erp_incharge_mob'];
		$erp_incharge_email = $_POST['erp_incharge_email'];
		$it_incharge_nm = $_POST['it_incharge_nm'];
		$it_incharge_mob = $_POST['it_incharge_mob'];
		$it_incharge_email = $_POST['it_incharge_email'];
		$aicte_incharge_nm = $_POST['aicte_incharge_nm'];
		$aicte_incharge_mob = $_POST['aicte_incharge_mob'];
		$aicte_incharge_email = $_POST['aicte_incharge_email'];
		$tpo_incharge_nm = $_POST['tpo_incharge_nm'];
		$tpo_incharge_mob = $_POST['tpo_incharge_mob'];
		$tpo_incharge_email = $_POST['tpo_incharge_email'];
		$art_incharge_nm = $_POST['art_incharge_nm'];
		$art_incharge_mob = $_POST['art_incharge_mob'];
		$art_incharge_email = $_POST['art_incharge_email'];
		$student_incharge_nm = $_POST['student_incharge_nm'];
		$student_incharge_mob = $_POST['student_incharge_mob'];
		$student_incharge_email = $_POST['student_incharge_email'];
		$admin_incharge_nm = $_POST['admin_incharge_nm'];
		$admin_incharge_mob = $_POST['admin_incharge_mob'];
		$admin_incharge_email = $_POST['admin_incharge_email'];
		$exam_incharge_nm = $_POST['exam_incharge_nm'];
		$exam_incharge_mob = $_POST['exam_incharge_mob'];
		$exam_incharge_email = $_POST['exam_incharge_email'];
	
		if($rows)
		{
			$results=mysql_query("update aicte_college_info set college_name='$clg_name', apply_id='$apply_id', aicte_id='$aicte_id', impliment_date='$impliment_date', informer_name='$informer_name', designation='$designation', email_id='$email_id', phone_no='$phone_no', erp_incharge_nm='$erp_incharge_nm', erp_incharge_mob='$erp_incharge_mob', erp_incharge_email='$erp_incharge_email', it_incharge_nm='$it_incharge_nm', it_incharge_mob='$it_incharge_mob', it_incharge_email='$it_incharge_email', aicte_incharge_nm='$aicte_incharge_nm', aicte_incharge_mob='$aicte_incharge_mob', aicte_incharge_email='$aicte_incharge_email', tpo_incharge_nm='$tpo_incharge_nm', tpo_incharge_mob='$tpo_incharge_mob', tpo_incharge_email='$tpo_incharge_email', art_incharge_nm='$art_incharge_nm', art_incharge_mob='$art_incharge_mob', art_incharge_email='$art_incharge_email', student_incharge_nm='$student_incharge_nm', student_incharge_mob='$student_incharge_mob', student_incharge_email='$student_incharge_email', admin_incharge_nm='$admin_incharge_nm', admin_incharge_mob='$admin_incharge_mob', admin_incharge_email='$admin_incharge_email', exam_incharge_nm='$exam_incharge_nm', exam_incharge_mob='$exam_incharge_mob', exam_incharge_email='$exam_incharge_email' where id='$rows[id]' ");
			if($results)
			{
				echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Record updated Successfully');
					window.location.href='college_data_form.php';
                    
                    </script>");
				
			}
			else
			{
				echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Record Not updated Please try again');
                 
                    </script>");
				
			}
		}
		else
		{
		$query =mysql_query("insert into aicte_college_info (college_id, college_name, apply_id, aicte_id, informer_name, impliment_date, designation, email_id, phone_no, erp_incharge_nm, erp_incharge_mob, erp_incharge_email, it_incharge_nm, it_incharge_mob, it_incharge_email, aicte_incharge_nm, aicte_incharge_mob, aicte_incharge_email, tpo_incharge_nm, tpo_incharge_mob, tpo_incharge_email, art_incharge_nm, art_incharge_mob, art_incharge_email, student_incharge_nm, student_incharge_mob, student_incharge_email, admin_incharge_nm, admin_incharge_mob, admin_incharge_email, exam_incharge_nm, exam_incharge_mob, exam_incharge_email) values('$clg_id','$clg_name','$apply_id', '$aicte_id', '$informer_name' ,'$impliment_date','$designation' ,'$email_id' ,'$phone_no' ,'$erp_incharge_nm' ,'$erp_incharge_mob' ,'$erp_incharge_email' ,'$it_incharge_nm' ,'$it_incharge_mob' ,'$it_incharge_email' ,'$aicte_incharge_nm' ,'$aicte_incharge_mob' ,'$aicte_incharge_email' ,'$tpo_incharge_nm' ,'$tpo_incharge_mob' ,'$tpo_incharge_email' ,'$art_incharge_nm' ,'$art_incharge_mob' ,'$art_incharge_email' ,'$student_incharge_nm' ,'$student_incharge_mob' ,'$student_incharge_email', '$admin_incharge_nm' ,'$admin_incharge_mob' ,'$admin_incharge_email' ,'$exam_incharge_nm' ,'$exam_incharge_mob' ,'$exam_incharge_email')");
		
		if($query)
		{
			echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Thanks for updating your college information. We will contact you soon for further process.');
                    window.location.href='college_data_form.php';
                    </script>");
		}
		else
		{
			echo ("<script LANGUAGE='JavaScript'>
                    window.alert('Record Not Inserted Please try again');
                    </script>");
		}
		}
	 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="KANCHAN PANDHARE">

    <title>College Information</title>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans">
    <link href="<?php echo $GLOBALS['URLNAME']."/Assets/css/bootstrap.css"; ?>" rel="stylesheet" type="text/css" >
    <link href="<?php echo $GLOBALS['URLNAME']."/css/bower_components/font-awesome/css/font-awesome.min.css"; ?>" rel="stylesheet" type="text/css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
</head>
<body style="font-family: 'Open Sans', serif;">
<div class="container-fluid">
    <br>
    <form id="facultyDetailsForm"  class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
            <div class="col-md-12  text-center" id="mainApplicationdiv" style="background-color: #FFFFFF;">
			 <div class="row">
        <div class="col-md-2">
      <!--image -->
	  <label for="name"><img src="<?php echo $GLOBALS['URLNAME']."/core/Images/250_86.png"; ?>" height="100px"></label>
     </div>
	 <div class="col-md-2 col-md-offset-3">
      <!--image 
	  <label for="name"><img src="<?php //echo base_url('/images/pblogoname.jpg');?>" height="100px"></label>-->
     </div>
    <div class="col-md-2 col-md-offset-3">
      <!--image 
	  <label for="name"><img src="<?php// echo $GLOBALS['URLNAME']."/image/ProLogoOnly.png";?>" height="100px" width="200px"></label>-->
	  <label for="name"><img src="<?php echo $GLOBALS['URLNAME']."/image/aicte_logo.webp";?>" height="100px" ></label>
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
                       <input class="form-control" name="state" id="state" value="<?php echo $row['scadmin_state']; ?>"  type="text" autocomplete="off" readonly>
                    </div>
                    <label for="city" class="col-md-1 control-label">City:</label>
                    <div class="col-lg-3 col-md-3">
                        <input class="form-control" name="city" id="city"  value="<?php echo $row['scadmin_city']; ?>" type="text" autocomplete="off" readonly>
                    </div>
                    
                </div>
                <div class="form-group required">
                    <label for="EmploymentType" class="col-md-3 control-label">College Name:</label>
                    <div class="col-lg-7 col-md-7">
                       <!-- <span id="college_alert"></span>
                        <span id="college_list_div">
						name="colleges" id="colleges" 
                            
                        </span>
                        <input type="hidden" name="clg_name" id="clg_name" />-->
						<input class="form-control" name="colleges" id="colleges" placeholder="Enter College Name" type="text"  value="<?php echo $row['school_name']; ?>" readonly>
                    </div>
                </div>
                <div class="form-group required">
                    <label for="apply_id" class="col-md-3 control-label">AICTE Application ID:</label>
                    <div class="col-lg-7 col-md-7">
                        <input class="form-control" name="apply_id" id="apply_id" placeholder="Enter AICTE Application ID" type="text"   value="<?php echo $row['aicte_application_id']; ?>" readonly>
                    </div>
					
                </div>
                <div class="form-group required">
                    <label for="Name" class="col-md-3 control-label">AICTE Permanent ID:</label>
                    <div class="col-lg-7 col-md-7">
                        <input class="form-control" name="aicte_id" id="aicte_id" placeholder="Enter AICTE Permanant ID" type="text"  value="<?php echo $row['aicte_permanent_id']; ?>" readonly>
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
					 
					<label for="Name" class="col-md-9 control-label"><b style="font-size: 19px;">We would like to implement the Protsahan Bharati, 360 Degree Feedback program in our college from :</b></label>
                    <div class=" col-md-2">
                        <input class="form-control datepicker" name="implement_dt" value="<?php echo $rows['impliment_date']; ?>"  type="text" placeholder="DD-MM-YYYY">
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
                        <input class="form-control" name="informer_name" id="informer_name" placeholder="Name" type="text" value="<?php echo $rows['informer_name']; ?>" autocomplete="off" required="required">
                    </div>
                </div> 
</div>				
  <div class="col-md-6">
    <div class="form-group required" >
                    <label for="designation" class="col-md-3 control-label">Designation:<b style="color:red">*</b></label>
                    <div class="col-lg-7 col-md-7">
                        <input class="form-control" name="designation" id="designation" placeholder="Enter Designation" type="text" value="<?php echo $rows['designation']; ?>" autocomplete="off" required="required">
                    </div>
                </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
   <div class="form-group required">
                    <label for="email_id" class="col-md-3 control-label">Email ID:<b style="color:red">*</b></label>
                    <div class="col-lg-7 col-md-7">
                        <input class="form-control" name="email_id" id="email_id" value="<?php echo $rows['email_id']; ?>" placeholder="Enter Email ID" type="email" autocomplete="off" required="required">
                    </div>
                </div> 
</div>				
  <div class="col-md-6">
    <div class="form-group required" >
                    <label for="phone_no" class="col-md-3 control-label">Phone Number:<b style="color:red">*</b></label>
                    <div class="col-lg-7 col-md-7">
                        <input class="form-control" name="phone_no" id="phone_no" value="<?php echo $rows['phone_no']; ?>" placeholder="Enter Phone Number" type="phone" autocomplete="off" required="required">
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
                                <th style="width: 5%;">Sr.</th>
                                <th style="width: 42%;">In-charge Details</th>
                                <th style="width: 24%;">Name of In-charge</th>
                                <th style="width: 12%;">Mobile No</th>
                                <th style="width: 17%;">Email Id</th>
                            </thead>
                            <tbody class="text-justify">
                                <tr>
                                    <td>1</td>
                                    <td>ERP In charge or person responsible for Admission / Time Table</td>
                                    <td><input class="form-control" type="text" name="erp_incharge_nm" value="<?php echo $rows['erp_incharge_nm']; ?>" placeholder="Enter Name"></td>
                                    <td><input class="form-control" type="text" name="erp_incharge_mob" value="<?php echo $rows['erp_incharge_mob']; ?>" placeholder="Enter Mobile No."></td>
                                    <td><input class="form-control" type="text" name="erp_incharge_email" value="<?php echo $rows['erp_incharge_email']; ?>" placeholder="Enter Email ID"></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>IT In charge who is responsible for or has knowledge of Data and how to Extract Data from Database.</td>
                                    <td><input class="form-control" type="text" name="it_incharge_nm" value="<?php echo $rows['it_incharge_nm']; ?>" placeholder="Enter Name"></td>
                                    <td><input class="form-control" type="text" name="it_incharge_mob" value="<?php echo $rows['it_incharge_mob']; ?>" placeholder="Enter Mobile No."></td>
                                    <td><input class="form-control" type="text" name="it_incharge_email" value="<?php echo $rows['it_incharge_email']; ?>" placeholder="Enter Email ID"></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Details of Person who will authorize giving the data to AICTE </td>
                                    <td><input class="form-control" type="text" name="aicte_incharge_nm" value="<?php echo $rows['aicte_incharge_nm']; ?>" placeholder="Enter Name"></td>
                                    <td><input class="form-control" type="text" name="aicte_incharge_mob" value="<?php echo $rows['aicte_incharge_mob']; ?>" placeholder="Enter Mobile No."></td>
                                    <td><input class="form-control" type="text" name="aicte_incharge_email" value="<?php echo $rows['aicte_incharge_email']; ?>" placeholder="Enter Email ID"></td>
                                </tr> 
                                <tr>
                                    <td>4</td>
                                    <td>TPO Details </td>
                                    <td><input class="form-control" type="text" name="tpo_incharge_nm" value="<?php echo $rows['tpo_incharge_nm']; ?>" placeholder="Enter Name"></td>
                                    <td><input class="form-control" type="text" name="tpo_incharge_mob" value="<?php echo $rows['tpo_incharge_mob']; ?>" placeholder="Enter Mobile No."></td>
                                    <td><input class="form-control" type="text" name="tpo_incharge_email" value="<?php echo $rows['tpo_incharge_email']; ?>" placeholder="Enter Email ID"></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Art Circle In charge Details</td>
                                    <td><input class="form-control" type="text" name="art_incharge_nm" value="<?php echo $rows['art_incharge_nm']; ?>" placeholder="Enter Name"></td>
                                    <td><input class="form-control" type="text" name="art_incharge_mob" value="<?php echo $rows['art_incharge_mob']; ?>" placeholder="Enter Mobile No."></td>
                                    <td><input class="form-control" type="text" name="art_incharge_email" value="<?php echo $rows['art_incharge_email']; ?>" placeholder="Enter Email ID"></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Student Affairs In charge Details </td>
                                    <td><input class="form-control" type="text" name="student_incharge_nm" value="<?php echo $rows['student_incharge_nm']; ?>" placeholder="Enter Name"></td>
                                    <td><input class="form-control" type="text" name="student_incharge_mob" value="<?php echo $rows['student_incharge_mob']; ?>" placeholder="Enter Mobile No."></td>
                                    <td><input class="form-control" type="text" name="student_incharge_email"value="<?php echo $rows['student_incharge_email']; ?>" placeholder="Enter Email ID"></td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Admin In charge for Putting up posters, allotting room for campus radio </td>
                                    <td><input class="form-control" type="text" name="admin_incharge_nm" value="<?php echo $rows['admin_incharge_nm']; ?>" placeholder="Enter Name"></td>
                                    <td><input class="form-control" type="text" name="admin_incharge_mob" value="<?php echo $rows['admin_incharge_mob']; ?>" placeholder="Enter Mobile No."></td>
                                    <td><input class="form-control" type="text" name="admin_incharge_email"value="<?php echo $rows['admin_incharge_email']; ?>" placeholder="Enter Email ID"></td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>Exam Cell In charge </td>
                                    <td><input class="form-control" type="text" name="exam_incharge_nm" value="<?php echo $rows['exam_incharge_nm']; ?>" placeholder="Enter Name"></td>
                                    <td><input class="form-control" type="text" name="exam_incharge_mob" value="<?php echo $rows['exam_incharge_mob']; ?>" placeholder="Enter Mobile No."></td>
                                    <td><input class="form-control" type="text" name="exam_incharge_email" value="<?php echo $rows['exam_incharge_email']; ?>" placeholder="Enter Email ID"></td>
                                </tr>
                             <!--   <tr>
                                    <td>9</td>
                                    <td colspan="4">Various Clubs in the Institute</td>
                                    <!-- <td><input class="form-control" type="text" name="erp_incharge_nm"></td>
                                    <td><input class="form-control" type="text" name="erp_incharge_mob"></td>
                                    <td><input class="form-control" type="text" name="erp_incharge_email"></td> //--
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Name of Club: &emsp; NSS</td>
                                    <td><input class="form-control" type="text" name="nss_incharge_nm" placeholder="Enter Name"></td>
                                    <td><input class="form-control" type="text" name="nss_incharge_mob" placeholder="Enter Mobile No."></td>
                                    <td><input class="form-control" type="text" name="nss_incharge_email" placeholder="Enter Email ID"></td>
                                </tr>
                                <tr>
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
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-offset-4 col-lg-2">
                    <button class="btn btn-success btn-block" id="facultyDetailSaveButton" name="submit" type="submit">Update</button>
                </div>
                
                
                <!-- <div class="col-md-4" id="facultyDetailsMessage"></div> -->
            </div>
            <!-- <br><br><b>Note:</b> The identity of the Faculty will not be revealed to the institute and will be kept confidential in the record of AICTE only. However any falsification in the above details will be viewed seriously by AICTE<br><br> -->
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
    <script type="text/javascript" src="<?php echo $GLOBALS['URLNAME']."/Assets/js/jquery-1.10.2.min.js"; ?>"></script>
    <script type="text/javascript" src="<?php echo $GLOBALS['URLNAME']."/Assets/js/bootstrap.min.js";?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
    <script src="<?php echo $GLOBALS['URLNAME']."/core/js/bootstrap-datepicker.min.js"; ?>"></script>
     <script type="text/javascript">
      $(document).ready(function() {
        $('.searchselect').select2();
        $('.datepicker').datepicker({
          format:'dd-mm-yyyy',
          autoClose:'TRUE',
          maxDate:0
        }).on('changeDate', function(e){
        $(this).datepicker('hide');
        });
      });
    </script>
    
</html>
