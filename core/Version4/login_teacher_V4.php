<?php
include '../conn.php';

$json = file_get_contents('php://input');
$obj = json_decode($json);
error_reporting(0);

//print_r($json);
$User_Name = xss_clean(mysql_real_escape_string($obj->{'User_Name'}));
$College_Code = xss_clean(mysql_real_escape_string($obj->{'College_Code'}));
$User_Pass = xss_clean(mysql_real_escape_string($obj->{'User_Pass'}));
$User_Type = xss_clean(mysql_real_escape_string($obj->{'User_Type'}));
$LatestMethod = xss_clean(mysql_real_escape_string($obj->{'method'}));
$country_code = xss_clean(mysql_real_escape_string($obj->{'country_code'}));
$LatestDevicetype = xss_clean(mysql_real_escape_string($obj->{'device_type'})); 
$LatestDeviceDetails = xss_clean(mysql_real_escape_string($obj->{'device_details'}));
$LatestPlatformOS = xss_clean(mysql_real_escape_string($obj->{'platform_OS'}));
$LatestIPAddress = xss_clean(mysql_real_escape_string($obj->{'ip_address'}));
$LatestLatitude = xss_clean(mysql_real_escape_string($obj->{'lat'}));
$LatestLongitude = xss_clean(mysql_real_escape_string($obj->{'long'}));
$LatestBrowser = xss_clean(mysql_real_escape_string($obj->{'platform_OS'}));
$entity_type_id = xss_clean(mysql_real_escape_string($obj->{'entity_type_id'}));
   //$entity_type = $obj->{'entity_sub_type'};
   // $activity = $obj->{'activity'};platform_OS

	//Start SMC-3451 Modify By sachin 2018-09-19 14:16:38 PM 
	//$date = date('Y-m-d H:i:s');
$date = CURRENT_TIMESTAMP; 
	//define in core/securityfunctions.php
	//End SMC-3451
//Validation messages modified according to error type by Pranali for SMC-4871



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
	}elseif($User_Type=='EmployeeID'){
		$member_id4 = $User_Name;
		$phone4 = "";
		$email4 = "";
	}else{
		$member_id4 = "";
		$phone4 = "";
		$email4 = "";
	}
	if($entity_type_id=='203'){
		$app_name4 = "ProtsahanBharti";
		$utype4 = $entity_type_id."(Manager)";
		$find_msg = "Manager Login Attempts";
	}else{
		$app_name4 = "Smartcookie";
		$utype4 = $entity_type_id."(Teacher)";
		$find_msg = "Teacher Login Attempts";
	}

	$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('A-log ', '$find_msg', '$json', '$datetime1234', '$utype4', '$member_id4', '', '$phone4', '$email4','$app_name4', '', '', '','Tapan Sthapak','core/Version4/login_teacher_V4','','','$College_Code','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','Android')");



$school_type = ($entity_type_id==103) ? 'School' : 'Organization';
$findSchool = mysql_query("SELECT sa.school_id,sa.school_name,sa.school_type,sa.group_member_id,ca.group_mnemonic_name FROM `tbl_school_admin` sa LEFT JOIN tbl_cookieadmin ca ON sa.group_member_id=ca.id WHERE sa.school_id='$College_Code'");

$error_report = "";

if(mysql_num_rows($findSchool)==0 && $College_Code!='')
{
	$error_report = "This ".$school_type." is not registered in the system";
	$postvalue['responseStatus']=404;
	$postvalue['responseMessage'] = $error_report;
	$postvalue['posts']=null;
    // header('Content-type: application/json');
    // echo  json_encode($postvalue);
	
	//Insert Queries are added by Sayali for SMC-4949 on 13/11/2020 
	$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log ', '$error_report', '$json', '$datetime1234', '$utype4', '$member_id4', '', '$phone4', '$email4','$app_name4', '', '', '','Sayali Balkawade','core/Version4/login_teacher_V4','','','$College_Code','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','Android')");
	
	
    
}

$schoolName=mysql_fetch_assoc($findSchool);
//$school_type = $schoolName['school_type'];

$entity = ($entity_type_id==103) ? 'Teacher' : 'Manager';

$condition = "";

if($User_Type=='MemberID' && $error_report=="")
{
	if($User_Name =="")
	{
		$error_report = "Please Enter Member ID";
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']= $error_report;

		$postvalue['posts']=null;
	    // header('Content-type: application/json');
	    // echo  json_encode($postvalue);
	    //goto end;
		$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log ', '$error_report', '$json', '$datetime1234', '$utype4', '$member_id4', '', '$phone4', '$email4','$app_name4', '', '', '','Sayali Balkawade','core/Version4/login_teacher_V4','','','$College_Code','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','Android')");
	}
	else if($User_Pass==""){

		$error_report = "Please Enter Password";
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']=$error_report;
		$postvalue['posts']=null;
	    // header('Content-type: application/json');
	    // echo  json_encode($postvalue);
	    //goto end;
		$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log ', '$error_report', '$json', '$datetime1234', '$utype4', '$member_id4', '', '$phone4', '$email4','$app_name4', '', '', '','Sayali Balkawade','core/Version4/login_teacher_V4','','','$College_Code','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','Android')");
	}
	else 
	{

	//$condition ="id ='".substr($User_Name,1)."'";
	//below $condition modified by Pranali for bug SAND-1565 as value of id is received as MemberId only 
	  $condition = "t.id='".$User_Name."'";
	  
	}
		
}
else if($error_report=="")
{
	if($College_Code =="")
	{
			$error_report = "Please Enter ".$school_type." ID";
			$postvalue['responseStatus']=1000;
			$postvalue['responseMessage']=$error_report;
			$postvalue['posts']=null;
		    // header('Content-type: application/json');
		    // echo  json_encode($postvalue);
			$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log ', '$error_report', '$json', '$datetime1234', '$utype4', '$member_id4', '', '$phone4', '$email4','$app_name4', '', '', '','Sayali Balkawade','core/Version4/login_teacher_V4','','','$College_Code','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','Android')");
	}
	if($User_Type=='Email'){

			$condition = "t.t_email='".$User_Name."' and  t.school_id='".$College_Code."'";
	}
	else if($User_Type=='Mobile-No'){
		
		if($country_code=="")
		{
				$error_report = "Please Enter Country Code";
				  	$postvalue['responseStatus']=404;
					$postvalue['responseMessage']=$error_report;
					$postvalue['posts']=null;	
					$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log ', '$error_report', '$json', '$datetime1234', '$utype4', '$member_id4', '', '$phone4', '$email4','$app_name4', '', '', '','Sayali Balkawade','core/Version4/login_teacher_V4','','','$College_Code','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','Android')");
		}
		else if($error_report==""){
			$condition = "t.CountryCode='".$country_code."' and t.t_phone='".$User_Name."' and  t.school_id='".$College_Code."'";
		}


	}
	else if($User_Type=='EmployeeID')
	{

			$condition = "t.t_id='".$User_Name."' and  t.school_id='".$College_Code."'";
	}
	else
	{
			$User_Name_id1 = str_replace("M","",$User_Name);
		    // $User_Name_id = str_replace("0","",$User_Name_id1);
			$User_Name_id = ltrim($User_Name_id1, '0');
			$condition = "id='".$User_Name_id."'";

	}
}

//Below query and if..else condition added by Pranali for SMC-4871 on 1-10-20
$sql = "SELECT t.first_login_date,t.last_login_date, t.id , t.t_id , t.t_complete_name,t.t_middlename,t.t_lastname,t.t_name, t.t_current_school_name, t.school_id, t.t_dept, t.t_subject, t.t_class, t.t_qualification, t.t_address, t.t_permanent_village, t.t_permanent_taluka, t.t_permanent_district, t.t_permanent_pincode, t.t_city, t.t_dob, t.t_gender, t.t_country,t.t_email, t.t_academic_year, t.t_password, t.t_pc, t.CountryCode, t.t_phone, t.tc_balance_point, t.tc_used_point, t.state, t.balance_blue_points, t.water_point, t.used_blue_points, t.brown_point, sa.school_type, t.group_status,sa.group_member_id,t.t_emp_type_pid,c.group_type,t.t_designation,t.t_DeptID,c.group_mnemonic_name,t.is_accept_terms,t.entity_type_id,sa.img_path FROM tbl_teacher t LEFT JOIN tbl_school_admin sa on t.school_id=sa.school_id left join tbl_cookieadmin c on c.id=sa.group_member_id where $condition ";

//$query = mysql_query($sql) or die('Errant query:  '.$sql);
 	$query = mysql_query($sql);

 	$sql_pass = $sql." and binary t.t_password = '$User_Pass'";
 	$query_pass = mysql_query($sql_pass);

	  	if($error_report=="" && mysql_num_rows($query)==0){
	  	
		  	$error_report = "This ".$User_Type." is not registered in the system";
		  	$postvalue['responseStatus']=404;
			$postvalue['responseMessage']=$error_report;
			$postvalue['posts']=null;
		    // header('Content-type: application/json');
		    // echo  json_encode($postvalue);
			$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log ', '$error_report', '$json', '$datetime1234', '$utype4', '$member_id4', '', '$phone4', '$email4','$app_name4', '', '', '','Sayali Balkawade','core/Version4/login_teacher_V4','','','$College_Code','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','Android')");
	  	}
	  	else if($error_report=="" && mysql_num_rows($query_pass)==0){
			  
			  		$error_report = "Password is invalid";
				  	$postvalue['responseStatus']=404;
					$postvalue['responseMessage']=$error_report;
					$postvalue['posts']=null;
					$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log ', '$error_report', '$json', '$datetime1234', '$utype4', '$member_id4', '', '$phone4', '$email4','$app_name4', '', '', '','Sayali Balkawade','core/Version4/login_teacher_V4','','','$College_Code','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','Android')");
		}

$email = "";

/* soak in the passed variable or set our own */
$number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
$format = 'json'; //xml is the default

 if($User_Name != "" && $User_Pass !="" && $User_Type !="" && $error_report=="")
 {


  //$query = "SELECT * FROM tbl_student where std_password = '$User_Pass' and (std_username = '$User_Name' or  std_email='$User_Name' or std_phone='$User_Name' or std_PRN='$User_Name')";

  //t_emp_type_pid and t.group_member_id selected by Pranali for SMC-3825, SMC-3763


 	//Added otp new paramaeter and called varify_otp webservice to match otp for SMC-5047 by Pranali on 17-12-20
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
	
//group_status selected from tbl_school_admin by PRanali for SMC-5063
  	$sql = "SELECT t.first_login_date,t.last_login_date, t.id , t.t_id , t.t_complete_name,t.t_middlename,t.t_lastname,t.t_name, t.t_current_school_name, t.school_id, t.t_dept, t.t_subject, t.t_class, t.t_qualification, t.t_address, t.t_permanent_village, t.t_permanent_taluka, t.t_permanent_district, t.t_permanent_pincode, t.t_city, t.t_dob, t.t_gender, t.t_country,t.t_email, t.t_academic_year, t.t_password, t.t_pc, t.CountryCode, t.t_phone, t.tc_balance_point, t.tc_used_point, t.state, t.balance_blue_points, t.water_point, t.used_blue_points, t.brown_point, sa.school_type, t.group_status,sa.group_member_id,t.t_emp_type_pid,c.group_type,t.t_designation,t.t_DeptID,c.group_mnemonic_name,t.is_accept_terms,t.entity_type_id,sa.img_path FROM tbl_teacher t LEFT JOIN tbl_school_admin sa on t.school_id=sa.school_id left join tbl_cookieadmin c on c.id=sa.group_member_id where $condition and binary t.t_password = '$User_Pass'";

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
				
				$sql = "SELECT t.first_login_date,t.last_login_date, t.id , t.t_id , t.t_complete_name,t.t_middlename,t.t_lastname,t.t_name, t.t_current_school_name, t.school_id, t.t_dept, t.t_subject, t.t_class, t.t_qualification, t.t_address, t.t_permanent_village, t.t_permanent_taluka, t.t_permanent_district, t.t_permanent_pincode, t.t_city, t.t_dob, t.t_gender, t.t_country,t.t_email, t.t_academic_year, t.t_password, t.t_pc, t.CountryCode, t.t_phone, t.tc_balance_point, t.tc_used_point, t.state, t.balance_blue_points, t.water_point, t.used_blue_points, t.brown_point, sa.school_type, t.group_status,t.group_member_id,t.t_emp_type_pid,c.group_type,t.t_designation,t.t_DeptID,t.group_member_id,t.is_accept_terms,t.entity_type_id,sa.img_path,sa.group_status FROM tbl_teacher t LEFT JOIN tbl_school_admin sa on t.school_id=sa.school_id left join tbl_cookieadmin c on c.id=t.group_member_id where $condition ";
				
			}
	}
	else{
	
	  	$sql = "SELECT t.first_login_date,t.last_login_date, t.id , t.t_id , t.t_complete_name,t.t_middlename,t.t_lastname,t.t_name, t.t_current_school_name, t.school_id, t.t_dept, t.t_subject, t.t_class, t.t_qualification, t.t_address, t.t_permanent_village, t.t_permanent_taluka, t.t_permanent_district, t.t_permanent_pincode, t.t_city, t.t_dob, t.t_gender, t.t_country,t.t_email, t.t_academic_year, t.t_password, t.t_pc, t.CountryCode, t.t_phone, t.tc_balance_point, t.tc_used_point, t.state, t.balance_blue_points, t.water_point, t.used_blue_points, t.brown_point, sa.school_type, t.group_status,sa.group_member_id,t.t_emp_type_pid,c.group_type,t.t_designation,t.t_DeptID,c.group_mnemonic_name,t.is_accept_terms,t.entity_type_id,sa.img_path,sa.group_status FROM tbl_teacher t LEFT JOIN tbl_school_admin sa on t.school_id=sa.school_id left join tbl_cookieadmin c on c.id=sa.group_member_id where $condition and binary t.t_password = '$User_Pass'";
	  }
//$query = mysql_query($sql) or die('Errant query:  '.$sql);
 	$query = mysql_query($sql);
 	if(!$query){
 		$error_report = "Login failed due to technical problem.. Please try again";
 		$postvalue['responseStatus']=1001;
 		$postvalue['responseMessage']=$error_report;
 		$postvalue['posts']=null;
		
		$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log ', '$error_report', '$json', '$datetime1234', '$utype4', '$member_id4', '', '$phone4', '$email4','$app_name4', '', '', '','Sayali Balkawade','core/Version4/login_teacher_V4','','','$College_Code','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','Android')");
 		
 	}
 	$count = mysql_num_rows($query);

 	/* create one master array of the records */
 	$posts = array();
 	if($count == 1)
 	{
 		$post = mysql_fetch_array($query);

 		$College_Code= $post["school_id"];
 		$t_row_id=$post["id"];
 		$t_complete_name=$post["t_complete_name"];
 		$tname=$post["t_name"];
 		$tmname=$post["t_middlename"];
 		$tlname=$post["t_lastname"];
 		$img=$post['t_pc'];
 		$school_id=$post['school_id'];
 		$group_type=$post['group_type'];
 		$scimg_path=$post['img_path'];

 		/*Below conditions and queries added by Rutuja Jori for Updating First Login & Last Login  for SMC-4830 on 16-09-2020*/
						 $first_login_date=$post["first_login_date"];
                          if($first_login_date=='')
                          {
                           $update_first = mysql_query("update `tbl_teacher` set first_login_date='$date' where id='$t_row_id' and school_id='$school_id'");
                          }
                          else
                          {
                           $update_last = mysql_query("update `tbl_teacher` set last_login_date='$date' where id='$t_row_id' and school_id='$school_id'");
                          }

						 //below if added by Pranali for SMC-3734 on 28-3-19
 		if($school_id=='KIMHC' || $school_id=='kimhc')
 		{
 			$group_type='Sports';
 		}

 		if($t_complete_name=="")
 		{
 			$t_complete_name=$tname." ".$tmname." ".$tlname;
 		}
 		else
 		{
 			$t_complete_name;
 		}
 		if($img=='')
 		{
 			$imagepath = $GLOBALS['URLNAME']."/Assets/images/avatar/avatar_2x.png";
 		}
 		else{
//image path changed by Pranali for SMC-3747
							// $imagepath=$GLOBALS['URLNAME']."/core/".$img;
 			$imagepath=$GLOBALS['URLNAME']."/teacher_images/".$img;
 		}
 		if($scimg_path=='')
 		{
 			$scimagepath = $GLOBALS['URLNAME']."/Assets/images/avatar/avatar_2x.png";
 		}
 		else{
//image path changed by Pranali for SMC-3747
							// $imagepath=$GLOBALS['URLNAME']."/core/".$img;
 			$scimagepath=$GLOBALS['URLNAME']."/core/".$scimg_path;
 		}
						 //group_type replaced by $group_type in $data by Pranali for SMC-3734 on 28-3-19
	//t_name,t_middlename and t_lastname given as o/p parameter by Pranali for SMC-3825 on 17-5-19
 		$data=array(
 			'id' =>$post['id'],
 			't_id' =>$post['t_id'],
 			't_complete_name'=>$t_complete_name,
 			't_current_school_name'=>$post['school_id'],
 			'school_id'=>$post['school_id'],
 			't_dept'=>$post['t_dept'],
 			't_subject'=>$post['t_subject'],
 			't_class'=>$post['t_class'],
 			't_qualification'=>$post['t_qualification'],
 			't_address'=>$post['t_address'],
 			't_permanent_village'=>$post['t_permanent_village'],
 			't_permanent_taluka'=>$post['t_permanent_taluka'], 
 			't_permanent_district'=>$post['t_permanent_district'],
 			't_permanent_pincode'=>$post['t_permanent_pincode'],
 			't_city'=>$post['t_city'], 
 			't_dob'=>$post['t_dob'],
 			't_gender'=>$post['t_gender'],
 			't_country'=>$post['t_country'],
 			't_email'=>$post['t_email'], 
 			't_academic_year'=>$post['t_academic_year'],
 			't_password'=>$post['t_password'],
 			't_pc'=>$imagepath, 
 			'CountryCode'=>$post['CountryCode'],
 			't_phone'=>$post['t_phone'],
 			'tc_balance_point'=>$post['tc_balance_point'],
 			'tc_used_point'=>$post['tc_used_point'],
 			'state'=>$post['state'],
 			'balance_blue_points'=>$post['balance_blue_points'], 
 			'water_point'=>$post['water_point'],
 			'used_blue_points'=>$post['used_blue_points'],
 			'brown_point'=>$post['brown_point'],
 			'school_type'=>$post['school_type'],
 			'group_status'=>$post['group_status'],
 			'group_type'=>$group_type,
 			't_emp_type_pid'=>$post['t_emp_type_pid'],
 			'entity_type_id'=>$post['entity_type_id'],
 			't_name'=>$tname,
 			't_middlename'=>$tmname,
 			't_lastname'=>$tlname,
 			't_designation'=>$post['t_designation'],
 			// 'group_member_id'=>$post['group_member_id'],
 			'group_member_id'=>$post['group_member_id'],
 			'group_mnemonic'=>$post['group_mnemonic_name'],
 			't_DeptID'=>isset($post['t_DeptID'])?$post['t_DeptID']:'',
 			'school_image'=>$scimagepath,
 			'is_accept_terms'=>$post['is_accept_terms'],
 			'first_login_date'=>$post['first_login_date'],
			'last_login_date'=>$post['last_login_date'],
 			'tnc_link'=>$GLOBALS['URLNAME']."/core/tnc.php"

 		);

 		if($entity_type_id =='')
 		{
 			$entity_type_id=103;
 		}
 		$entity_type_id1=$data['entity_type_id'];
 		if($entity_type_id1=='')
 		{
 			$entity_type_id1=103;
 		}
 		if($post['school_type']=="organization"){
			$entity_type_id1=203; // Checko for manager
		}
 		if($entity_type_id==$entity_type_id1)
 		{
 			$posts[] = $data;
								//$arr = mysql_query("select  EntityID from `tbl_LoginStatus` where EntityID='$t_row_id' and Entity_type='103'");

 			$arr = mysql_query("select * from `tbl_LoginStatus` where EntityID='$t_row_id' and Entity_type='$entity_type_id' and LogoutTime='0000-00-00 00:00:00' ORDER BY `RowID` DESC  limit 1");
 			$result_arr = mysql_fetch_assoc($arr);

 			if (mysql_num_rows($arr) == 0)
 			{
 				$LoginStatus=mysql_query("INSERT INTO `tbl_LoginStatus`(`EntityID`,`Entity_type`,`FirstLoginTime`,`FirstMethod`,`FirstDevicetype`, `FirstDeviceDetails`, `FirstPlatformOS`, `FirstIPAddress`, `FirstLatitude`, `FirstLongitude`, `FirstBrowser`, `LatestLoginTime`, `LatestMethod`, `LatestDevicetype`, `LatestDeviceDetails`, `LatestPlatformOS`, `LatestIPAddress`, `LatestLatitude`, `LatestLongitude`, `LatestBrowser`, `CountryCode`,`school_id`)
 					VALUES ('$t_row_id','$entity_type_id','$date ','$LatestMethod','$LatestDevicetype','$LatestDeviceDetails','$LatestBrowser','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$LatestBrowser','$date ','$LatestMethod','$LatestDevicetype','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$LatestBrowser','$country_code','$College_Code')");


 			}
 			else
 			{
 				$LoginStatus=mysql_query("INSERT INTO `tbl_LoginStatus`(`EntityID`,`Entity_type`,`FirstLoginTime`,`FirstMethod`,`FirstDevicetype`, `FirstDeviceDetails`, `FirstPlatformOS`, `FirstIPAddress`, `FirstLatitude`, `FirstLongitude`,`LatestBrowser`, `LatestLoginTime`, `LatestMethod`, `LatestDevicetype`, `LatestDeviceDetails`, `LatestPlatformOS`, `LatestIPAddress`, `LatestLatitude`, `LatestLongitude`, `CountryCode`,`school_id`)
 					VALUES ('".$result_arr['EntityID']."','".$result_arr['Entity_type']."','".$result_arr['LatestLoginTime']."','".$result_arr['LatestMethod']."','".$result_arr['LatestDevicetype']."','".$result_arr['LatestDeviceDetails']."','".$result_arr['LatestBrowser']."','".$result_arr['LatestIPAddress']."','".$result_arr['LatestLatitude']."','".$result_arr['LatestLongitude']."','".$result_arr['LatestBrowser']."',' $date','$LatestMethod','$LatestDevicetype','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$country_code','$College_Code')");

							//$LoginStatus = mysql_query("insert into `tbl_LoginStatus` (`LatestLoginTime`,LatestMethod,LatestDeviceDetails,LatestPlatformOS,LatestIPAddress,LatestLatitude,LatestLongitude,CountryCode) values ('$LatestLoginTime''$LatestMethod','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','$LatestLatitude','$LatestLongitude','$CountryCode');
 				if($result_arr['LogoutTime']=='0000-00-00 00:00:00' || $result_arr['LogoutTime']=='')
 				{
 					$LoginStatus_old = mysql_query("update `tbl_LoginStatus` set LogoutTime='$date' where EntityID='$t_row_id' and Entity_type='$entity_type_id' and RowID=".$result_arr['RowID']." ");
 				}					
 			}	
		                //$activity_log=mysql_query("INSERT INTO `tbl_ActivityLog` //(EntityID,Entity_type,EntitySubType,Timestamp,Activity,CountryCode)
		                //    values ('$t_row_id','103','$entity_type','$date','$activity','$country_code')");



 			$postvalue['responseStatus']=200;
 			$postvalue['responseMessage']="OK";
 			$postvalue['posts']=$posts;
 		}

 		else if($error_report==""){	
 		$error_report = "Please enter valid Entity Type ID";		   			
 			$postvalue['responseStatus']=202;
 			$postvalue['responseMessage']=$error_report;
 			$postvalue['posts']=null;
			$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log ', '$error_report', '$json', '$datetime1234', '$utype4', '$member_id4', '', '$phone4', '$email4','$app_name4', '', '', '','Sayali Balkawade','core/Version4/login_teacher_V4','','','$College_Code','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','Android')");
 		}


 	}
 	else if($User_Type!='' && $count > 1 && $error_report=="")
 	{
 		$error_report = "More than one ".$entity." exists for same ".$User_Type." in ".$school_type;
 		$postvalue['responseStatus']=409;
 		$postvalue['responseMessage']=$error_report;
 		$postvalue['posts']=null;
		$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log ', '$error_report', '$json', '$datetime1234', '$utype4', '$member_id4', '', '$phone4', '$email4','$app_name4', '', '', '','Sayali Balkawade','core/Version4/login_teacher_V4','','','$College_Code','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','Android')");

 	}
 	else if($User_Type!='' && $count==0 && $error_report=="")
 	{
 		$error_report = $User_Type." is not registered in ".$school_type;
 		$postvalue['responseStatus']=1002;
 		$postvalue['responseMessage']=$error_report;
 		$postvalue['posts']=null;
		$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log ', '$error_report', '$json', '$datetime1234', '$utype4', '$member_id4', '', '$phone4', '$email4','$app_name4', '', '', '','Sayali Balkawade','core/Version4/login_teacher_V4','','','$College_Code','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','Android')");

 	}


 }
 			else if($User_Name=='' && $error_report=="")
			{

			    $postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Please Enter ".$User_Type;
				$postvalue['posts']=null;

					$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log ', '$error_report', '$json', '$datetime1234', '$utype4', '$member_id4', '', '$phone4', '$email4','$app_name4', '', '', '','Sayali Balkawade','core/Version4/login_teacher_V4','','','$College_Code','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','Android')");
			    // header('Content-type: application/json');
   			 //    echo  json_encode($postvalue);


			}
			else if($User_Type=='' && $error_report=="")
			{

			    $postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Please Select Login Type";
				$postvalue['posts']=null;
	$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log ', '$error_report', '$json', '$datetime1234', '$utype4', '$member_id4', '', '$phone4', '$email4','$app_name4', '', '', '','Sayali Balkawade','core/Version4/login_teacher_V4','','','$College_Code','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','Android')");
			    // header('Content-type: application/json');
   			 //    echo  json_encode($postvalue);


			}
			else if($User_Pass=='' && $error_report=="")
			{

			    $postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Please Enter Password";
				$postvalue['posts']=null;
				$q=mysql_query("insert into tbl_error_log(`error_type`,`error_description`,`data`,`datetime`,`user_type`,`member_id`,`name`, `phone`, `email`,`app_name`,`subroutine_name`,`line`,`status`,`last_programmer_name`,`webservice_name`,`webmethod_name`,`programmer_error_message`,`school_id`,`device_name`,`device_OS_version`,`ip_address`,`source`) values('E-log ', '$error_report', '$json', '$datetime1234', '$utype4', '$member_id4', '', '$phone4', '$email4','$app_name4', '', '', '','Sayali Balkawade','core/Version4/login_teacher_V4','','','$College_Code','$LatestDeviceDetails','$LatestPlatformOS','$LatestIPAddress','Android')");

			    // header('Content-type: application/json');
   			 //    echo  json_encode($postvalue);

			}
			//comment  is added by Sayali for SMC-4949 on 13/11/2020 
//Below if condition added by Pranali for calling error log report api if login fails for SMC-4629 on 12-4-20

 // if($postvalue['responseStatus']!=200 )
 // {
 	
 	// $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/core/Version3/error_log_ws_v1.php';
 	// $webservice_name = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/core/Version4/login_teacher_V4.php';
 	// $response_msg = $postvalue['responseMessage'];

 	// $error_description = '{"Response Message":"'.$response_msg.'","Login Option":"'.$User_Type.'","Entity":"'.$entity_type_id.'","'.$User_Type.'":"'.$User_Name.'"}';
 	// $app_name = ($entity_type_id=='103')?'Teacher':'Manager';
 	// $last_programmer_name = 'Pranali Dalvi';

 	// $data = array('error_type'=>'Login Fail','error_description'=>$error_description,'datetime'=>$date,'user_type'=>$entity_type_id,'app_name'=>$app_name,'school_id'=>$College_Code,'webservice_name'=>$webservice_name,'last_programmer_name'=>$last_programmer_name);

 	// $ch = curl_init($url);
 	// $data_string = json_encode($data);      
 	// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
 	// curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
 	// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
 	// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
 	// $result = json_decode(curl_exec($ch),true);
// }

 /* output in necessary format */
 if($format == 'json') {
 	header('Content-type: application/json');
 	echo json_encode($postvalue);
 }
 else {
    //header('Content-type: text/xml');
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