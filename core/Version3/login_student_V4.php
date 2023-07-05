<?php
include '../conn.php';
error_reporting(0);
$json = file_get_contents('php://input');
$obj = json_decode($json);

$User_Name = $obj->{'User_Name'};
$College_Code=$obj->{'College_Code'};
$User_Pass = $obj->{'User_Pass'};
$User_Type =$obj->{'User_Type'};
  $method =$obj->{'method'};         // Android or iOS or Web
  $device_type =$obj->{'device_type'};    // phone or Tab
  $device_details =$obj->{'device_details'};    // version or entire device details
  $platform_OS =$obj->{'platform_OS'};    // OS name
  $ip_add =$obj->{'ip_address'};
  $lat = $obj->{'lat'};
  $long = $obj->{'long'};
  $entity_type_id = $obj->{'entity_type_id'};
  $otp = $obj->{'otp'};
  // Start SMC-3450 Modify By Pravin 2018-09-18 07:04 PM 
  //$date = date('Y-m-d H:i:s');
  $date = CURRENT_TIMESTAMP; // define in core/securityfunctions.php
  //End SMC-3450
//Modified api for adding validation messages according to error type by Pranali for SMC-4867
/* Author VaibhavG 
			*  I've fire queries for getting school name from table school admin If any  *  student has empty school name in student table. 
			*  As per the discussed with Android Developer Pooja Paramshetti for the ticket Number SAND-1602. 




			
			*/ 
			
				$datetime1234 = date('Y-m-d H:i:s');
if($User_Type=='MemberID'){
		$member_id4 = $User_Name;
		$phone4 = "";
		$email4 = "";
	}elseif($User_Type=='Email'){
		$email4 = $User_Name;
		$member_id4 = "";
		$phone4 = "";
	}elseif($User_Type=='Mobile-No'){
		$phone4 = $User_Name;
		$member_id4 = "";
		$email4 = "";
	}elseif($User_Type=='PRN'){
		$member_id4 = $User_Name;
		$phone4 = "";
		$email4 = "";
	}else{
		$member_id4 = "";
		$phone4 = "";
		$email4 = "";
	}
	if($entity_type_id=='205'){
		$app_name4 = "ProtsahanBharti";
		$utype4 = $entity_type_id."(Employee)";
		$find_msg = "Employee Login Attempts";
	}else{
		$app_name4 = "Smartcookie";
		$utype4 = $entity_type_id."(Student)";
		$find_msg = "Student Login Attempts";
	}
	
	
	$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('A-log', '$find_msg', '$json', '$datetime1234', '$utype4', '$member_id4', '', '$phone4', '$email4','$app_name4', '', '', '','Tapan Sthapak','core/Version3/login_student_V4.php','','','$College_Code','$device_details','$platform_OS','$ip_add','Android')");
			
	 			
			
$school_type = ($entity_type_id==205) ? 'Organization' : 'School';
$findSchool = mysql_query("SELECT sa.school_id,sa.school_name,sa.school_type,sa.group_member_id,ca.group_mnemonic_name FROM `tbl_school_admin` sa LEFT JOIN tbl_cookieadmin ca ON sa.group_member_id=ca.id WHERE sa.school_id='$College_Code'");
//Added errors in $error_report by Pranali for SMC-4867
$error_report = "";

if(mysql_num_rows($findSchool)==0 && $College_Code!='')
{
	$error_report = "This ".$school_type." is not registered in the system";
	$postvalue['responseStatus']=404;
	$postvalue['responseMessage'] = $error_report;
	$postvalue['posts']=null;
    // header('Content-type: application/json');
    // echo  json_encode($postvalue);exit;z
	
	$datetime123 = date('Y-m-d H:i:s');
		
		if($User_Type=='MemberID'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}elseif($User_Type=='Email'){
		$email = $User_Name;
		$member_id = "";
		$phone = "";
	}elseif($User_Type=='Mobile-No'){
		$phone = $User_Name;
		$member_id = "";
		$email = "";
	}elseif($User_Type=='PRN'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}else{
		$member_id = "";
		$phone = "";
		$email = "";
	}
	
	
	if($entity_type_id=='205'){
		$app_name = "ProtsahanBharti";
		$utype = $entity_type_id."(Employee)";
	}else{
		$app_name = "Smartcookie";
		$utype = $entity_type_id."(Student)";
	}
	
	
	$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log', '$error_report', '$json', '$datetime123', '$utype', '$member_id', '', '$phone', '$email','$app_name', '', '', '','Tapan Sthapak','core/Version3/login_student_V4.php','','','$College_Code','$device_details','$platform_OS','$ip_add','Android')");
	
}

$schoolName=mysql_fetch_assoc($findSchool);

//$school_type = $schoolName['school_type'];
//End for the ticket Number SAND-1602.
$entity = ($school_type=='Organization') ? 'Employee' : 'Student';
//$condition = "";
if($User_Type=='MemberID' && $error_report=="")
{
	if($User_Name =="")
	{
		$error_report = "Please Enter Member ID";
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']=$error_report;
		$postvalue['posts']=null;
	    // header('Content-type: application/json');
	    // echo  json_encode($postvalue);exit;
		
		$datetime123 = date('Y-m-d H:i:s');
		
		if($User_Type=='MemberID'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}elseif($User_Type=='Email'){
		$email = $User_Name;
		$member_id = "";
		$phone = "";
	}elseif($User_Type=='Mobile-No'){
		$phone = $User_Name;
		$member_id = "";
		$email = "";
	}elseif($User_Type=='PRN'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}else{
		$member_id = "";
		$phone = "";
		$email = "";
	}
	
	
	if($entity_type_id=='205'){
		$app_name = "ProtsahanBharti";
		$utype = $entity_type_id."(Employee)";
	}else{
		$app_name = "Smartcookie";
		
		$utype = $entity_type_id."(Student)";
	}
	
	
	$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log', '$error_report', '$json', '$datetime123', '$utype', '$member_id', '', '$phone', '$email','$app_name', '', '', '','Tapan Sthapak','core/Version3/login_student_V4.php','','','$College_Code','$device_details','$platform_OS','$ip_add','Android')");
		
		
	}
	else if($User_Pass=="" && $otp==""){
		$error_report = "Please Enter Password";
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']=$error_report;
		$postvalue['posts']=null;
	    // header('Content-type: application/json');
	    // echo  json_encode($postvalue);exit;
		
		
		$datetime123 = date('Y-m-d H:i:s');
		if($User_Type=='MemberID'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}elseif($User_Type=='Email'){
		$email = $User_Name;
		$member_id = "";
		$phone = "";
	}elseif($User_Type=='Mobile-No'){
		$phone = $User_Name;
		$member_id = "";
		$email = "";
	}elseif($User_Type=='PRN'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}else{
		$member_id = "";
		$phone = "";
		$email = "";
	}
	
	
	if($entity_type_id=='205'){
		$app_name = "ProtsahanBharti";
		$utype = $entity_type_id."(Employee)";
	}else{
		$app_name = "Smartcookie";
		$utype = $entity_type_id."(Student)";
	}
	
	
	$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log', '$error_report', '$json', '$datetime123', '$utype', '$member_id', '', '$phone', '$email','$app_name', '', '', '','Tapan Sthapak','core/Version3/login_student_V4.php','','','$College_Code','$device_details','$platform_OS','$ip_add','Android')");
		
	}
	else
	{

	//$condition ="id ='".substr($User_Name,1)."'";
	//below $condition modified by Pranali for bug SAND-1565 as value of id is received as MemberID only 
	  $condition ="s.id ='$User_Name'";
	  
	  $query_id = mysql_query("SELECT * FROM `tbl_student` s WHERE $condition ");
	  $query = mysql_query("SELECT s.*,sa.group_member_id,ca.group_mnemonic_name FROM  `tbl_student` s LEFT JOIN `tbl_school_admin` sa ON s.school_id=sa.school_id LEFT JOIN tbl_cookieadmin ca ON sa.group_member_id=ca.id WHERE $condition and binary s.std_password = '$User_Pass'");

	  if(mysql_num_rows($query_id)==0){
	  	
		  	$error_report = "This Member ID is not registered in the system";
		  	$postvalue['responseStatus']=404;
			$postvalue['responseMessage']=$error_report;
			$postvalue['posts']=null;
		    // header('Content-type: application/json');
		    // echo  json_encode($postvalue);exit;
			$datetime123 = date('Y-m-d H:i:s');
		if($User_Type=='MemberID'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}elseif($User_Type=='Email'){
		$email = $User_Name;
		$member_id = "";
		$phone = "";
	}elseif($User_Type=='Mobile-No'){
		$phone = $User_Name;
		$member_id = "";
		$email = "";
	}elseif($User_Type=='PRN'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}else{
		$member_id = "";
		$phone = "";
		$email = "";
	}
	if($entity_type_id=='205'){
		$app_name = "ProtsahanBharti";
		$utype = $entity_type_id."(Employee)";
	}else{
		$app_name = "Smartcookie";
		$utype = $entity_type_id."(Student)";
	}
	
	
	$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log', '$error_report', '$json', '$datetime123', '$utype', '$member_id', '', '$phone', '$email','$app_name', '', '', '','Tapan Sthapak','core/Version3/login_student_V4.php','','','$College_Code','$device_details','$platform_OS','$ip_add','Android')");
			
			
			
	  }
	  else if($error_report=="" && mysql_num_rows($query)==0 && $otp=="")
	  {
	  		$error_report = "Password is invalid";
		  	$postvalue['responseStatus']=404;
			$postvalue['responseMessage']=$error_report;
			$postvalue['posts']=null;
			
			
			$datetime123 = date('Y-m-d H:i:s');
if($User_Type=='MemberID'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}elseif($User_Type=='Email'){
		$email = $User_Name;
		$member_id = "";
		$phone = "";
	}elseif($User_Type=='Mobile-No'){
		$phone = $User_Name;
		$member_id = "";
		$email = "";
	}elseif($User_Type=='PRN'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}else{
		$member_id = "";
		$phone = "";
		$email = "";
	}
	if($entity_type_id=='205'){
		$app_name = "ProtsahanBharti";
		$utype = $entity_type_id."(Employee)";
	}else{
		$app_name = "Smartcookie";
		$utype = $entity_type_id."(Student)";
	}
	
	
	$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log', '$error_report', '$json', '$datetime123', '$utype', '$member_id', '', '$phone', '$email','$app_name', '', '', '','Tapan Sthapak','core/Version3/login_student_V4.php','','','$College_Code','$device_details','$platform_OS','$ip_add','Android')");
			
	  }
	}
		
}
else if($error_report=="")
{
	if($College_Code =="")
	{
		$error_report="Please Enter ".$school_type." ID";
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']=$error_report;
		$postvalue['posts']=null;
	    // header('Content-type: application/json');
	    // echo  json_encode($postvalue);exit;
		
		$datetime123 = date('Y-m-d H:i:s');
	if($User_Type=='MemberID'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}elseif($User_Type=='Email'){
		$email = $User_Name;
		$member_id = "";
		$phone = "";
	}elseif($User_Type=='Mobile-No'){
		$phone = $User_Name;
		$member_id = "";
		$email = "";
	}elseif($User_Type=='PRN'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}else{
		$member_id = "";
		$phone = "";
		$email = "";
	}
	if($entity_type_id=='205'){
		$app_name = "ProtsahanBharti";
		$utype = $entity_type_id."(Employee)";
	}else{
		$app_name = "Smartcookie";
		$utype = $entity_type_id."(Student)";
	}
	
	
	$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log', '$error_report', '$json', '$datetime123', '$utype', '$member_id', '', '$phone', '$email','$app_name', '', '', '','Tapan Sthapak','core/Version3/login_student_V4.php','','','$College_Code','$device_details','$platform_OS','$ip_add','Android')");
		
	}

	if($User_Type=='Email' && $User_Name !="" && $College_Code != "" && $error_report=="")
	{
			$condition = "s.std_email ='$User_Name' and s.school_id='$College_Code'";
			$query_id = mysql_query("SELECT * FROM  `tbl_student` s WHERE $condition ");
			$query = mysql_query("SELECT s.*,sa.group_member_id,ca.group_mnemonic_name FROM  `tbl_student` s LEFT JOIN `tbl_school_admin` sa ON s.school_id=sa.school_id LEFT JOIN tbl_cookieadmin ca ON sa.group_member_id=ca.id WHERE $condition and binary s.std_password = '$User_Pass'");
			if(mysql_num_rows($query_id)==0){
	  	
		  	$error_report = "This Email is not registered in the ".$school_type;
		  	$postvalue['responseStatus']=404;
			$postvalue['responseMessage']=$error_report;
			$postvalue['posts']=null;
		    // header('Content-type: application/json');
		    // echo  json_encode($postvalue);exit;
			
			$datetime123 = date('Y-m-d H:i:s');
	if($User_Type=='MemberID'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}elseif($User_Type=='Email'){
		$email = $User_Name;
		$member_id = "";
		$phone = "";
	}elseif($User_Type=='Mobile-No'){
		$phone = $User_Name;
		$member_id = "";
		$email = "";
	}elseif($User_Type=='PRN'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}else{
		$member_id = "";
		$phone = "";
		$email = "";
	}
	if($entity_type_id=='205'){
		$app_name = "ProtsahanBharti";
		$utype = $entity_type_id."(Employee)";
	}else{
		$app_name = "Smartcookie";
		$utype = $entity_type_id."(Student)";
	}
	
	
	$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log', '$error_report', '$json', '$datetime123', '$utype', '$member_id', '', '$phone', '$email','$app_name', '', '', '','Tapan Sthapak','core/Version3/login_student_V4.php','','','$College_Code','$device_details','$platform_OS','$ip_add','Android')");
			
			
			  }
			  else if($error_report=="" && mysql_num_rows($query)==0 && $otp=="")
			  {
			  		$error_report = "Password is invalid";
				  	$postvalue['responseStatus']=404;
					$postvalue['responseMessage']=$error_report;
					$postvalue['posts']=null;
					
					
					$datetime123 = date('Y-m-d H:i:s');
if($User_Type=='MemberID'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}elseif($User_Type=='Email'){
		$email = $User_Name;
		$member_id = "";
		$phone = "";
	}elseif($User_Type=='Mobile-No'){
		$phone = $User_Name;
		$member_id = "";
		$email = "";
	}elseif($User_Type=='PRN'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}else{
		$member_id = "";
		$phone = "";
		$email = "";
	}
	if($entity_type_id=='205'){
		$app_name = "ProtsahanBharti";
		$utype = $entity_type_id."(Employee)";
	}else{
		$app_name = "Smartcookie";
		$utype = $entity_type_id."(Student)";
	}
	
	
	$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log', '$error_report', '$json', '$datetime123', '$utype', '$member_id', '', '$phone', '$email','$app_name', '', '', '','Tapan Sthapak','core/Version3/login_student_V4.php','','','$College_Code','$device_details','$platform_OS','$ip_add','Android')");
					
			  }
	}
	else if($User_Type=='Mobile-No' && $User_Name != "" && $College_Code != "" && $error_report=="")
	{
		
		$country_code1=$obj->{'country_code'};
		if($country_code1=="")
		{
				$error_report = "Please Enter Country Code";
				  	$postvalue['responseStatus']=404;
					$postvalue['responseMessage']=$error_report;
					$postvalue['posts']=null;	
					
					$datetime123 = date('Y-m-d H:i:s');
	if($User_Type=='MemberID'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}elseif($User_Type=='Email'){
		$email = $User_Name;
		$member_id = "";
		$phone = "";
	}elseif($User_Type=='Mobile-No'){
		$phone = $User_Name;
		$member_id = "";
		$email = "";
	}elseif($User_Type=='PRN'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}else{
		$member_id = "";
		$phone = "";
		$email = "";
	}
	if($entity_type_id=='205'){
		$app_name = "ProtsahanBharti";
		$utype = $entity_type_id."(Employee)";
	}else{
		$app_name = "Smartcookie";
		$utype = $entity_type_id."(Student)";
	}
	
	
	$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log', '$error_report', '$json', '$datetime123', '$utype', '$member_id', '', '$phone', '$email','$app_name', '', '', '','Tapan Sthapak','core/Version3/login_student_V4.php','','','$College_Code','$device_details','$platform_OS','$ip_add','Android')");
					
					
		}
		
		$country_code = ltrim($country_code1, '+');
		//$condition = "country_code='$country_code1' AND std_phone='$User_Name' and  school_id='$College_Code'";

		//$country_code variable passed to country_code by Pranali for bug SAND-1565
		$condition = "s.country_code='$country_code' AND s.std_phone='$User_Name' and  s.school_id='$College_Code'";
		$query_id = mysql_query("SELECT * FROM  `tbl_student` s WHERE $condition ");
		$query = mysql_query("SELECT s.*,sa.group_member_id,ca.group_mnemonic_name FROM  `tbl_student` s LEFT JOIN `tbl_school_admin` sa ON s.school_id=sa.school_id LEFT JOIN tbl_cookieadmin ca ON sa.group_member_id=ca.id WHERE $condition AND s.std_password='$User_Pass'");
			if(mysql_num_rows($query_id)==0 && $error_report==''){
	  	
		  	$error_report = "This Mobile-No is not registered in the ".$school_type;
		  	$postvalue['responseStatus']=404;
			$postvalue['responseMessage']=$error_report;
			$postvalue['posts']=null;
		    // header('Content-type: application/json');
		    // echo  json_encode($postvalue);exit;
			
			$datetime123 = date('Y-m-d H:i:s');
if($User_Type=='MemberID'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}elseif($User_Type=='Email'){
		$email = $User_Name;
		$member_id = "";
		$phone = "";
	}elseif($User_Type=='Mobile-No'){
		$phone = $User_Name;
		$member_id = "";
		$email = "";
	}elseif($User_Type=='PRN'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}else{
		$member_id = "";
		$phone = "";
		$email = "";
	}
	if($entity_type_id=='205'){
		$app_name = "ProtsahanBharti";
		$utype = $entity_type_id."(Employee)";
	}else{
		$app_name = "Smartcookie";
		$utype = $entity_type_id."(Student)";
	}
	
	$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log', '$error_report', '$json', '$datetime123', '$utype', '$member_id', '', '$phone', '$email','$app_name', '', '', '','Tapan Sthapak','core/Version3/login_student_V4.php','','','$College_Code','$device_details','$platform_OS','$ip_add','Android')");
			
			
			
			  }
			  else if($error_report=='' && mysql_num_rows($query)==0 && $otp=="")
			  {
			  		$error_report = "Password is invalid";
				  	$postvalue['responseStatus']=404;
					$postvalue['responseMessage']=$error_report;
					$postvalue['posts']=null;
					
					
					$datetime123 = date('Y-m-d H:i:s');
	if($User_Type=='MemberID'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}elseif($User_Type=='Email'){
		$email = $User_Name;
		$member_id = "";
		$phone = "";
	}elseif($User_Type=='Mobile-No'){
		$phone = $User_Name;
		$member_id = "";
		$email = "";
	}elseif($User_Type=='PRN'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}else{
		$member_id = "";
		$phone = "";
		$email = "";
	}
	if($entity_type_id=='205'){
		$app_name = "ProtsahanBharti";
		$utype = $entity_type_id."(Employee)";
	}else{
		$app_name = "Smartcookie";
		$utype = $entity_type_id."(Student)";
	}
	
	
	$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log', '$error_report', '$json', '$datetime123', '$utype', '$member_id', '', '$phone', '$email','$app_name', '', '', '','Tapan Sthapak','core/Version3/login_student_V4.php','','','$College_Code','$device_details','$platform_OS','$ip_add','Android')");
					
					
					
			  }
			
	}
	else if($User_Type=='PRN' && $User_Name != ""  && $College_Code !='' && $error_report=="")
	{
		 $condition = "s.std_PRN='$User_Name' and  s.school_id='$College_Code'";
		 $query_id = mysql_query("SELECT * FROM  `tbl_student` s WHERE $condition ");
		 $query = mysql_query("SELECT s.*,sa.group_member_id,ca.group_mnemonic_name FROM  `tbl_student` s LEFT JOIN `tbl_school_admin` sa ON s.school_id=sa.school_id LEFT JOIN tbl_cookieadmin ca ON sa.group_member_id=ca.id WHERE $condition AND s.std_password='$User_Pass'");
			if(mysql_num_rows($query_id)==0){
	  	
		  	$error_report = "This PRN is not registered in the ".$school_type;
		  	$postvalue['responseStatus']=404;
			$postvalue['responseMessage']=$error_report;
			$postvalue['posts']=null;
		    // header('Content-type: application/json');
		    // echo  json_encode($postvalue);exit;
			
			
			$datetime123 = date('Y-m-d H:i:s');
		if($User_Type=='MemberID'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}elseif($User_Type=='Email'){
		$email = $User_Name;
		$member_id = "";
		$phone = "";
	}elseif($User_Type=='Mobile-No'){
		$phone = $User_Name;
		$member_id = "";
		$email = "";
	}elseif($User_Type=='PRN'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}else{
		$member_id = "";
		$phone = "";
		$email = "";
	}
	if($entity_type_id=='205'){
		$app_name = "ProtsahanBharti";
		$utype = $entity_type_id."(Employee)";
	}else{
		$app_name = "Smartcookie";
		$utype = $entity_type_id."(Student)";
	}
	
	
	$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log', '$error_report', '$json', '$datetime123', '$utype', '$member_id', '', '$phone', '$email','$app_name', '', '', '','Tapan Sthapak','core/Version3/login_student_V4.php','','','$College_Code','$device_details','$platform_OS','$ip_add','Android')");
			
			
			  }
			  else if($error_report=="" && mysql_num_rows($query)==0 && $otp=="")
			  {
			  		$error_report = "Password is invalid";
				  	$postvalue['responseStatus']=404;
					$postvalue['responseMessage']=$error_report;
					$postvalue['posts']=null;
					
					
					$datetime123 = date('Y-m-d H:i:s');
		if($User_Type=='MemberID'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}elseif($User_Type=='Email'){
		$email = $User_Name;
		$member_id = "";
		$phone = "";
	}elseif($User_Type=='Mobile-No'){
		$phone = $User_Name;
		$member_id = "";
		$email = "";
	}elseif($User_Type=='PRN'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}else{
		$member_id = "";
		$phone = "";
		$email = "";
	}
	if($entity_type_id=='205'){
		$app_name = "ProtsahanBharti";
		$utype = $entity_type_id."(Employee)";
	}else{
		$app_name = "Smartcookie";
		$utype = $entity_type_id."(Student)";
	}
	
	
	$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log', '$error_report', '$json', '$datetime123', '$utype', '$member_id', '', '$phone', '$email','$app_name', '', '', '','Tapan Sthapak','core/Version3/login_student_V4.php','','','$College_Code','$device_details','$platform_OS','$ip_add','Android')");
					
					
			  }
		 
	}
	else if($error_report=="")
	{
	    $User_Name_id1 = str_replace("M","",$User_Name);
	    $User_Name_id = ltrim($User_Name_id1, '0');		
	     $condition = "s.id='$User_Name_id'";

	     $query_id = mysql_query("SELECT * FROM  `tbl_student` s WHERE $condition ");
		$query = mysql_query("SELECT s.*,sa.group_member_id,ca.group_mnemonic_name FROM  `tbl_student` s LEFT JOIN `tbl_school_admin` sa ON s.school_id=sa.school_id LEFT JOIN tbl_cookieadmin ca ON sa.group_member_id=ca.id WHERE $condition AND s.std_password='$User_Pass'");

			if(mysql_num_rows($query_id)==0){
	  		
			  	$error_report = "This ID is not registered in the ".$school_type;
			  	$postvalue['responseStatus']=404;
				$postvalue['responseMessage']=$error_report;
				$postvalue['posts']=null;
		    // header('Content-type: application/json');
		    // echo  json_encode($postvalue);exit;
			
			
			$datetime123 = date('Y-m-d H:i:s');
		if($User_Type=='MemberID'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}elseif($User_Type=='Email'){
		$email = $User_Name;
		$member_id = "";
		$phone = "";
	}elseif($User_Type=='Mobile-No'){
		$phone = $User_Name;
		$member_id = "";
		$email = "";
	}elseif($User_Type=='PRN'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}else{
		$member_id = "";
		$phone = "";
		$email = "";
	}
	if($entity_type_id=='205'){
		$app_name = "ProtsahanBharti";
		$utype = $entity_type_id."(Employee)";
	}else{
		$app_name = "Smartcookie";
		$utype = $entity_type_id."(Student)";
	}
	
	
	$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log', '$error_report', '$json', '$datetime123', '$utype', '$member_id', '', '$phone', '$email','$app_name', '', '', '','Tapan Sthapak','core/Version3/login_student_V4.php','','','$College_Code','$device_details','$platform_OS','$ip_add','Android')");
			
			
			  }
			  else if($error_report=="" && mysql_num_rows($query)==0 && $otp==""){
			  
			  		$error_report = "Password is invalid";
				  	$postvalue['responseStatus']=404;
					$postvalue['responseMessage']=$error_report;
					$postvalue['posts']=null;
					
					
					$datetime123 = date('Y-m-d H:i:s');
			if($User_Type=='MemberID'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}elseif($User_Type=='Email'){
		$email = $User_Name;
		$member_id = "";
		$phone = "";
	}elseif($User_Type=='Mobile-No'){
		$phone = $User_Name;
		$member_id = "";
		$email = "";
	}elseif($User_Type=='PRN'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}else{
		$member_id = "";
		$phone = "";
		$email = "";
	}
	if($entity_type_id=='205'){
		$app_name = "ProtsahanBharti";
		$utype = $entity_type_id."(Employee)";
	}else{
		$app_name = "Smartcookie";
		$utype = $entity_type_id."(Student)";
	}
	
	
	$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log', '$error_report', '$json', '$datetime123', '$utype', '$member_id', '', '$phone', '$email','$app_name', '', '', '','Tapan Sthapak','core/Version3/login_student_V4.php','','','$College_Code','$device_details','$platform_OS','$ip_add','Android')");
					
					
			  }
			
	}
}
$format = 'json'; //xml is the default

if($User_Name != "" and ($User_Pass !="" || $otp!="") and $User_Type !="" && $error_report=="")
{
	//Added otp new paramaeter and called varify_otp webservice to match otp for SMC-4962 by Pranali on 25/11/20
	if($otp != "" && ($User_Type=='Email' || $User_Type=='Mobile-No'))
	{
		$url=$GLOBALS['URLNAME']."/core/api2/api2.php?x=varify_otp"; 
		if($User_Type=='Email')
		{
			$myvars_cat=array(
			'operation'=>"varify_otp",
			'email_id'=>$User_Name,
			'otp'=>$otp,			
			'api_key'=>'cda11aoip2Ry07CGWmjEqYvPguMZTkBel1V8c3XKIxwA6zQt5s'
			
			);
		}
		else
		{
			$myvars_cat=array(
			'operation'=>"varify_otp",
			'phone_number'=>$User_Name,
			'otp'=>$otp,			
			'api_key'=>'cda11aoip2Ry07CGWmjEqYvPguMZTkBel1V8c3XKIxwA6zQt5s'
			
			);
		}
		// print_r($myvars_cat);
		$ch = curl_init($url); 			
		$data_string = json_encode($myvars_cat);    
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
		


			$res_otp = json_decode(curl_exec($ch),true);
			$responcemsg = $res_otp["responseStatus"];
			if($responcemsg!=200)
			{
				$error_report = "OTP is invalid";
        		$postvalue['responseStatus']=$responcemsg;
        		$postvalue['responseMessage']=$res_otp["responseMessage"];
        		header('Content-type: application/json');
				echo json_encode($postvalue);exit;
        		
        
			}else{
				

				$query = mysql_query("SELECT * FROM  `tbl_student` WHERE $condition ");

			}
	}
	else{
	$query = mysql_query("SELECT s.*,sa.group_member_id,ca.group_mnemonic_name FROM  `tbl_student` s LEFT JOIN `tbl_school_admin` sa ON s.school_id=sa.school_id LEFT JOIN tbl_cookieadmin ca ON sa.group_member_id=ca.id WHERE $condition and binary s.std_password = '$User_Pass'");

}		   

    $posts = array();
			
	$a = mysql_num_rows($query);
            if(mysql_num_rows($query)==1)
             {


                                        while($post = mysql_fetch_assoc($query))
                                       {
												$post["std_img_path"]=$GLOBALS['URLNAME']."/core/".$post["std_img_path"];
												//Start for the ticket Number SAND-1602.
					if(empty($post["std_school_name"]))
						$post["std_school_name"]=$schoolName['school_name'];
												//End for the ticket Number SAND-1602.
					$post['school_image']=$GLOBALS['URLNAME']."/core/".$post['school_image'];
					$post['tnc_link'] = $GLOBALS['URLNAME']."/core/tnc.php";
			//Retrieved group status from tbl_school_admin by Pranali for SMC-5063
					$group_status = mysql_query("select group_status from tbl_school_admin where school_id = '$College_Code'");
					$group_status1 = mysql_fetch_array($group_status);
					$post['group_status'] = $group_status1['group_status'];
					$post['group_member_id'] = $post['group_member_id'];
					$post['group_mnemonic'] = $post['group_mnemonic_name'];

					$posts[] = $post;
					$sch_id= $post["school_id"];
					$std_row_id=$post["id"];
					$entity_id=$post["entity_type_id"]; 

					/*Below conditions and queries added by Rutuja Jori for Updating First Login & Last Login  for SMC-4830 on 16-09-2020*/
                                                $first_login_date=$post["first_login_date"];
                                                if($first_login_date=='')
                                                {
                                                	$update_first = mysql_query("update `tbl_student` set first_login_date='$date' where id='$std_row_id' and school_id='$sch_id'");
                                                }
                                                else
                                                {
                                                	$update_last = mysql_query("update `tbl_student` set last_login_date='$date' where id='$std_row_id' and school_id='$sch_id'");
                                                }

				}
				$query1 = "SELECT school_address,school_latitude,school_longitude FROM tbl_school where school_mnemonic='$sch_id'";
				$result1 = mysql_query($query1);
				$posts1 = array();
				if(mysql_num_rows($result1)==1)
				{

					while($post1 = mysql_fetch_assoc($result1))
					{
						$posts1[] = $post1;
					}
				}



				if($entity_type_id=='')
				{
					$entity_type_id=105;
				}
				if($entity_id=='')
				{
					//$entity_id=105;
					$check_entity_query = mysql_query("select school_type from tbl_school_admin where school_id = '$College_Code'");
					$check_row_entity = mysql_fetch_array($check_entity_query);
					$entity_name_check = $check_row_entity['school_type'];
					if($entity_name_check == "organization"){
						$entity_id=205;
					}elseif($entity_name_check == "school"){
						$entity_id=105;
					}else{
						$entity_id=105;
					}
				}

				if($entity_type_id==$entity_id)
				{
					$arr = mysql_query("select  * from `tbl_LoginStatus` where EntityID='$std_row_id' and Entity_type='$entity_type_id' and LogoutTime='0000-00-00 00:00:00' ORDER BY `RowID` DESC  limit 1");
					$result_arr = mysql_fetch_assoc($arr);

					if (mysql_num_rows($arr) == 0)
					{									
						$login_details=mysql_query("INSERT INTO `tbl_LoginStatus` (EntityID,Entity_type,FirstLoginTime,FirstMethod,FirstDeviceDetails, FirstPlatformOS,FirstIPAddress,FirstLatitude,FirstLongitude,LatestLoginTime,LatestMethod,LatestDeviceDetails,LatestPlatformOS,LatestIPAddress,LatestLatitude,LatestLongitude,CountryCode,school_id)
							values ('$std_row_id','$entity_type_id',NOW(),'$method','$device_details','$platform_OS','$ip_add','$lat','$long','$date','$method','$device_details','$platform_OS','$ip_add','$lat','$long','$country_code','$sch_id')");

						if($login_details)
						{
							$a= "yes";
						}
						else
						{
							$a = "no";
						}													

					}
					else
					{
						$LoginStatus=mysql_query("INSERT INTO `tbl_LoginStatus`(`EntityID`,`Entity_type`,`FirstLoginTime`,`FirstMethod`,`FirstDevicetype`, `FirstDeviceDetails`, `FirstPlatformOS`, `FirstIPAddress`, `FirstLatitude`, `FirstLongitude`,`LatestBrowser`, `LatestLoginTime`, `LatestMethod`, `LatestDevicetype`, `LatestDeviceDetails`, `LatestPlatformOS`, `LatestIPAddress`, `LatestLatitude`, `LatestLongitude`, `CountryCode`,`school_id`)
 							VALUES ('".$result_arr['EntityID']."','".$result_arr['Entity_type']."','".$result_arr['LatestLoginTime']."','".$result_arr['LatestMethod']."','".$result_arr['LatestDevicetype']."','".$result_arr['LatestDeviceDetails']."','".$result_arr['LatestBrowser']."','".$result_arr['LatestIPAddress']."','".$result_arr['LatestLatitude']."','".$result_arr['LatestLongitude']."','".$result_arr['LatestBrowser']."',' $date','$method','$device_type','$device_details','$platform_OS','$ip_add','$lat','$long','$country_code1','$College_Code')");

								if($result_arr['LogoutTime']=='0000-00-00 00:00:00' || $result_arr['LogoutTime']=='')
		 						{
									$LoginStatus_old = mysql_query("update `tbl_LoginStatus` set LogoutTime='$date' where EntityID='$std_row_id' and Entity_type='$entity_type_id' and RowID=".$result_arr['RowID']." ");
								}
							
					if($LoginStatus_old)
											{
												$c= "updated again";
											}
											else
											{
												$c = "not updated";
											}
					}					
								
							
							    $postvalue['responseStatus']=200;
                				$postvalue['responseMessage']="OK";
                				$postvalue['posts']=$posts;
                                $postvalue['posts1']=$posts1;
				}
				else if($error_report==""){	
		 			$error_report = "You Are Not Registered as a Employee,Please Check Your Entity";	   			
		 			$postvalue['responseStatus']=202;
		 			$postvalue['responseMessage']=$error_report;
		 			$postvalue['posts']=null;
					
					
					
					$datetime123 = date('Y-m-d H:i:s');
			if($User_Type=='MemberID'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}elseif($User_Type=='Email'){
		$email = $User_Name;
		$member_id = "";
		$phone = "";
	}elseif($User_Type=='Mobile-No'){
		$phone = $User_Name;
		$member_id = "";
		$email = "";
	}elseif($User_Type=='PRN'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}else{
		$member_id = "";
		$phone = "";
		$email = "";
	}
	if($entity_type_id=='205'){
		$app_name = "ProtsahanBharti";
		$utype = $entity_type_id."(Employee)";
	}else{
		$app_name = "Smartcookie";
		$utype = $entity_type_id."(Student)";
	}
	
	
	$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log', '$error_report', '$json', '$datetime123', '$utype', '$member_id', '', '$phone', '$email','$app_name', '', '', '','Tapan Sthapak','core/Version3/login_student_V4.php','','','$College_Code','$device_details','$platform_OS','$ip_add','Android')");
					
		 		}				
            }
            else if($User_Type!='' && mysql_num_rows($query)==0 && $error_report=="")
            {
            			$error_report = "This ".$User_Type." is not registered in ".$school_type;
                        $postvalue['responseStatus']=409;
          				$postvalue['responseMessage']=$error_report;
          				$postvalue['posts']=null;
						
						
						$datetime123 = date('Y-m-d H:i:s');
		if($User_Type=='MemberID'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}elseif($User_Type=='Email'){
		$email = $User_Name;
		$member_id = "";
		$phone = "";
	}elseif($User_Type=='Mobile-No'){
		$phone = $User_Name;
		$member_id = "";
		$email = "";
	}elseif($User_Type=='PRN'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}else{
		$member_id = "";
		$phone = "";
		$email = "";
	}
	if($entity_type_id=='205'){
		$app_name = "ProtsahanBharti";
		$utype = $entity_type_id."(Employee)";
	}else{
		$app_name = "Smartcookie";
		$utype = $entity_type_id."(Student)";
	}
	
	
	
	$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log', '$error_report', '$json', '$datetime123', '$utype', '$member_id', '', '$phone', '$email','$app_name', '', '', '','Tapan Sthapak','core/Version3/login_student_V4.php','','','$College_Code','$device_details','$platform_OS','$ip_add','Android')");
						
						
						

            }
			else if($User_Type!='' && mysql_num_rows($query)>1 && $error_report =="")
            {
            			$error_report = "More than one ".$entity." exists for same ".$User_Type." in ".$school_type;
                        $postvalue['responseStatus']=409;
          				$postvalue['responseMessage']=$error_report;
          				$postvalue['posts']=null;
						
						
						
						
						$datetime123 = date('Y-m-d H:i:s');
		if($User_Type=='MemberID'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}elseif($User_Type=='Email'){
		$email = $User_Name;
		$member_id = "";
		$phone = "";
	}elseif($User_Type=='Mobile-No'){
		$phone = $User_Name;
		$member_id = "";
		$email = "";
	}elseif($User_Type=='PRN'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}else{
		$member_id = "";
		$phone = "";
		$email = "";
	}
	if($entity_type_id=='205'){
		$app_name = "ProtsahanBharti";
		$utype = $entity_type_id."(Employee)";
	}else{
		$app_name = "Smartcookie";
		$utype = $entity_type_id."(Student)";
	}
	
	
	$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log', '$error_report', '$json', '$datetime123', '$utype', '$member_id', '', '$phone', '$email','$app_name', '', '', '','Tapan Sthapak','core/Version3/login_student_V4.php','','','$College_Code','$device_details','$platform_OS','$ip_add','Android')");

            }
                                


	
}

else if($User_Name=='' && $error_report =="")
{
	$error_report = "Please Enter ".$User_Type;
    $postvalue['responseStatus']=1000;
	$postvalue['responseMessage']= $error_report;
	$postvalue['posts']=null;
	
	
	$datetime123 = date('Y-m-d H:i:s');
		if($User_Type=='MemberID'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}elseif($User_Type=='Email'){
		$email = $User_Name;
		$member_id = "";
		$phone = "";
	}elseif($User_Type=='Mobile-No'){
		$phone = $User_Name;
		$member_id = "";
		$email = "";
	}elseif($User_Type=='PRN'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}else{
		$member_id = "";
		$phone = "";
		$email = "";
	}
	if($entity_type_id=='205'){
		$app_name = "ProtsahanBharti";
		$utype = $entity_type_id."(Employee)";
	}else{
		$app_name = "Smartcookie";
		$utype = $entity_type_id."(Student)";
	}
	
	
	$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log', '$error_report', '$json', '$datetime123', '$utype', '$member_id', '', '$phone', '$email','$app_name', '', '', '','Tapan Sthapak','core/Version3/login_student_V4.php','','','$College_Code','$device_details','$platform_OS','$ip_add','Android')");
    
}
else if($User_Type=='' && $error_report =="")
{
	$error_report = "Please Select Login Type";
    $postvalue['responseStatus']=1000;
	$postvalue['responseMessage']=$error_report;
	$postvalue['posts']=null;
	
	
	
	$datetime123 = date('Y-m-d H:i:s');
	if($User_Type=='MemberID'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}elseif($User_Type=='Email'){
		$email = $User_Name;
		$member_id = "";
		$phone = "";
	}elseif($User_Type=='Mobile-No'){
		$phone = $User_Name;
		$member_id = "";
		$email = "";
	}elseif($User_Type=='PRN'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}else{
		$member_id = "";
		$phone = "";
		$email = "";
	}
	if($entity_type_id=='205'){
		$app_name = "ProtsahanBharti";
		$utype = $entity_type_id."(Employee)";
	}else{
		$app_name = "Smartcookie";
		$utype = $entity_type_id."(Student)";
	}
	$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log', '$error_report', '$json', '$datetime123', '$utype', '$member_id', '', '$phone', '$email','$app_name', '', '', '','Tapan Sthapak','core/Version3/login_student_V4.php','','','$College_Code','$device_details','$platform_OS','$ip_add','Android')");

}
else if($User_Pass=='' && $error_report =="" && $otp=="")
{
	$error_report = "Please Enter Password";
	$postvalue['responseStatus']=1000;
	$postvalue['responseMessage']= $error_report;
	$postvalue['posts']=null;
	
	
	$datetime123 = date('Y-m-d H:i:s');
	if($User_Type=='MemberID'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}elseif($User_Type=='Email'){
		$email = $User_Name;
		$member_id = "";
		$phone = "";
	}elseif($User_Type=='Mobile-No'){
		$phone = $User_Name;
		$member_id = "";
		$email = "";
	}elseif($User_Type=='PRN'){
		$member_id = $User_Name;
		$phone = "";
		$email = "";
	}else{
		$member_id = "";
		$phone = "";
		$email = "";
	}
	
	
	if($entity_type_id=='205'){
		$app_name = "ProtsahanBharti";
		$utype = $entity_type_id."(Employee)";
	}else{
		$app_name = "Smartcookie";
		$utype = $entity_type_id."(Student)";
	}
	
	
	$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log', '$error_report', '$json', '$datetime123', '$utype', '$member_id', '', '$phone', '$email','$app_name', '', '', '','Tapan Sthapak','core/Version3/login_student_V4.php','','','$College_Code','$device_details','$platform_OS','$ip_add','Android')");

}
	
		/*else
		{

			//$postvalue['responseStatus']=1000;
			$postvalue['responseMessage']="Invalid Input";
			$postvalue['posts']=null;



		}*/
//Below if condition added by Pranali for calling error log report api if login fails for SMC-4629 on 11-4-20
/*
		if($postvalue['responseStatus']!=200) 
		{
			$url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/core/Version3/error_log_ws_v1.php';
			$webservice_name = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/core/Version3/login_student_V4.php';
			$response_msg = $postvalue['responseMessage'];

			$error_description = '{"Response Message":"'.$response_msg.'","Login Option":"'.$User_Type.'","Entity":"'.$entity_type_id.'","'.$User_Type.'":"'.$User_Name.'"}';
			$app_name = ($entity_type_id=='105')?'Student':'Employee';
			$last_programmer_name = 'Pranali Dalvi';

			$data = array('error_type'=>'Login Fails','error_description'=>$error_description,'datetime'=>$date,'user_type'=>$entity_type_id,'app_name'=>$app_name,'school_id'=>$College_Code,'webservice_name'=>$webservice_name,'last_programmer_name'=>$last_programmer_name);

			$ch = curl_init($url);
			$data_string = json_encode($data);      
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
			$result = json_decode(curl_exec($ch),true);
		}
		*/
		/* output in necessary format */
		if($format == 'json') {
			header('Content-type: application/json');
			echo json_encode($postvalue);
		}
		else {
			header('Content-type: text/xml');
			echo '';
			foreach($posts as $index => $post) {
				if(is_array($post)) {
					foreach($post as $key => $value) {
						echo '<',$key,'>';
						if(is_array($value)) {
							foreach($value as $tag => $val) {
								echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
							}
						}
						echo '</',$key,'>';
					}
				}
			}
			echo '';
		}
		/* disconnect from the db */
		@mysql_close($con);

?>