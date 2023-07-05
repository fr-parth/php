<?php 
/*Author : Pranali Dalvi
Date : 7-2-20
This file was created to add Teacher as School Admin Staff or to add Manager as HR Admin Staff
*/
include_once("scadmin_header.php");
$school_id = $_SESSION['school_id'];
$group_member_id = $_SESSION['group_member_id'];
$date = CURRENT_TIMESTAMP;

if(isset($_POST['submit'])){
	$staff_id = $_POST['staff'];

	$sql = mysql_query("SELECT id,t_id,school_id,t_exprience,t_designation,t_address,t_country,t_city,state,t_dob,t_age,t_gender,t_email,t_phone,t_qualification,t_password,t_current_school_name,CountryCode,group_member_id,(CASE WHEN t_complete_name='' THEN CONCAT_WS(' ', t_name, t_middlename,t_lastname) ELSE t_complete_name END) as teacher_name 
		FROM tbl_teacher WHERE school_id='$school_id' AND id='$staff_id'");

	$t = mysql_fetch_assoc($sql);

	$teacher_name = $t['teacher_name'];
	$school_id = $t['school_id'];
	$t_current_school_name = $t['t_current_school_name'];
	$t_exprience = $t['t_exprience'];
	$t_designation = $t['t_designation'];
	$t_address = $t['t_address'];
	$t_country = $t['t_country'];
	$t_city = $t['t_city'];
	$state = $t['state'];
	$t_dob = $t['t_dob'];
	$t_age = $t['t_age'];
	$t_gender = $t['t_gender'];
	$t_email = $t['t_email'];
	$CountryCode = $t['CountryCode'];
	$t_phone = $t['t_phone'];
	$t_password = $t['t_password'];
	$t_qualification = $t['t_qualification'];
	$group_member_id = $t['group_member_id'];

	$user = mysql_query("SELECT id from tbl_school_adminstaff where school_id='$school_id' and (email='$t_email' or phone='$t_phone') AND delete_flag='0'");
	$cnt = mysql_num_rows($user);

	if($cnt==0){
		//insert teacher details in tbl_school_adminstaff table
		$add_staff = mysql_query("INSERT INTO tbl_school_adminstaff(stf_name,school_id,school_name,exprience,designation,addd,country,city,statue,dob,age,gender,email,CountryCode,phone,pass,qualification,currentDate,group_member_id,delete_flag) 
			VALUES 
			('$teacher_name','$school_id','$t_current_school_name','$t_exprience','$t_designation','$t_address','$t_country','$t_city','$state','$t_dob','$t_age','$t_gender','$t_email','$CountryCode','$t_phone','$t_password','$t_qualification','$date','$group_member_id','0')");
	
//Added redirection to staff member list page after successfully adding staff by Pranali for SMC-5008
        echo "<script>alert('Staff added successfully..'); 
        window.location.href='schoolAdminStaff_list.php';</script>";
	}
	else{
		echo "<script>alert('Staff already exists!!');</script>";
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/select2.min.js"></script>
<style>
	
	 .selectPicker{ 
            
           margin-left: 12px;
           padding: 30px 0px 30px 0px; 
       }

       .bootstrap-select>.dropdown-toggle {
            position: relative;
            width: 100%;
            text-align: right;
            white-space: nowrap;
            display: -webkit-inline-box;
            display: -webkit-inline-flex;
            display: -ms-inline-flexbox;
            display: inline-flex;
            -webkit-box-align: center;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: justify;
            -webkit-justify-content: space-between;
            -ms-flex-pack: justify;
            justify-content: space-between;
            background-color: #2a77df57;
            color: black !important;
        }
       
       .searchAreaALLsearch{
            position: relative;
            right: 15px;
       }

       .submitBtn{
           
               position: relative;
               float: right;
       }
       
</style>
</head>
<body bgcolor="#CCCCCC"> 
<div class="container" style="padding:25px;">
<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8;">
		<form id="submitData" method="POST">
			<div style="background-color:#F8F8F8 ;">
            <div class="row">
				<div class="col-md-6" align="center">
		                          
		            <h2>Add Staff Member</h2>
		        </div>
	
							<div class="col-md-4" style="padding-top:55px;margin-left: -450px;"> 
                       
                                 <div class="selectPicker"> 
                                    <label for="staff">Select Staff</label>
                                    <select name="staff" id="staff"  class="form-control searchselect">
                                         <!-- <option value="all">All</option> -->                                       
                                        <?php 
                                        
                                         $sq = mysql_query("SELECT id,t_id,school_id,t_exprience,t_designation,t_address,t_country,t_city,state,t_dob,t_age,t_gender,t_email,t_phone,t_qualification,t_password,(CASE WHEN t_complete_name='' THEN CONCAT_WS(' ', t_name, t_middlename,t_lastname) ELSE t_complete_name END) as teacher_name FROM tbl_teacher WHERE school_id='$school_id'"); 

                                           while($row = mysql_fetch_assoc($sq))
                                            {   ?>                       
                                            <option value="<?php echo $row['id']?>"><?php echo $row['teacher_name'];?></option>'; 
                                            
                                        <?php }

                                        ?>

                                    </select> 
                                </div>
                               
                            </div>
                            <div class="submitBtn" style="padding-top:105px;margin-right: 350px;">
                        		<input type="submit" name="submit" id="submit" value="Submit" class="btn btn-primary" />

                        		<a href='schoolAdminStaff_list.php'><input type="button" name="back" id="back" value="Back" class="btn btn-danger" style="margin-left:15px;"/></a> 
                    		</div>
                        </form></div></div>
</div>
</div>
</body>
</html>
<script type="text/javascript"> 
	$(document).ready(function() {
    $('.searchselect').select2();

});</script>