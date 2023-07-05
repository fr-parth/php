<?php  
$json = file_get_contents('php://input');
$obj = json_decode($json);
header('Content-type: application/json');

 $format = 'json'; //xml is the default
 
include 'conn.php';
	
	 $server_name=$GLOBALS['URLNAME'];
	 $key = xss_clean(mysql_real_escape_string($obj->{'key'}));
	 $t_id = xss_clean(mysql_real_escape_string($obj->{'t_id'}));
	 
//new parameter new_t_id added by Pranali for SMC-3762 on 1-2-19
	 $new_t_id = xss_clean(mysql_real_escape_string($obj->{'new_t_id'}));
	 $User_Meid = xss_clean(mysql_real_escape_string($obj->{'User_Meid'}));
	 $fname = xss_clean(addslashes($obj->{'User_FName'}));
	 $mname = xss_clean(addslashes($obj->{'User_MName'}));
	 $lname = xss_clean(addslashes($obj->{'User_LName'}));
	 $school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
//new school id parameter added by Pranali on 29-1-19 for SMC-3762
	 $new_sc_id= xss_clean(mysql_real_escape_string($obj->{'new_school_id'}));
	 $t_complete_name=$fname." ".$mname." ".$lname; 
	 $email = xss_clean(addslashes($obj->{'User_email'}));
	 $dob = xss_clean(mysql_real_escape_string($obj->{'User_dob'}));
	 $gender = xss_clean(mysql_real_escape_string($obj->{'User_gender'}));
	 $member_id = xss_clean(mysql_real_escape_string($obj->{'User_Meid'}));
	 $phone = xss_clean(addslashes($obj->{'User_Phone'}));
	 $country_code = xss_clean(mysql_real_escape_string($obj->{'CountryCode'}));
	 $address = xss_clean(addslashes($obj->{'User_address'}));
	 $city = xss_clean(addslashes($obj->{'User_city'}));
	 $country = xss_clean(mysql_real_escape_string($obj->{'User_country'}));
	 $state = xss_clean(addslashes($obj->{'state'}));
	 $password = xss_clean(addslashes(trim($obj->{'User_password'})));
	 $emp_id = xss_clean(mysql_real_escape_string($obj->{'employee_id'}));

//Author: Pranali 
//If teacher has school id as open, then provision given for him to update school id and teacher id  (SMC-3762)
	if($school_id == 'OPEN' || $school_id == 'open')
	{
		$validateSchool=mysql_query("SELECT school_id FROM tbl_school_admin where school_id='$new_sc_id'");
		$validateSchool1=mysql_fetch_assoc($validateSchool);
		$SchoolID=$validateSchool1['school_id'];
		
		if($new_sc_id==$SchoolID)
		{
			$test=mysql_query("UPDATE tbl_teacher SET school_id='$new_sc_id'  where id='$User_Meid'");
		}
		
		else{
		
			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="Please enter valid School ID";
			echo json_encode($postvalue);
			exit;
		}
	
	}
//teacher id updation provision given to all school teachers by Pranali for SMC-3762
//below if condition added by Pranali for SMC-3762
	if($new_t_id!='' && $t_id!='')
	{
		
		$tID=mysql_query("select t_id from tbl_teacher where t_id='$new_t_id' and (school_id = '$school_id' or school_id ='$new_sc_id')");
		$teacherID=mysql_fetch_assoc($tID);
		$teacherID1=$teacherID['t_id'];
		
		//if new and old tid are same then don't update tid
		if($new_t_id==$t_id)
		{
			$test='';
		}
		
		// if teacher id in same school doesn't exists then update tid 
		else if($teacherID1=='') 
		{
			$test=mysql_query("UPDATE tbl_teacher SET t_id='$new_t_id' where id='$User_Meid'");
		}
		else{
			
			$postvalue['responseStatus']=409;
			$postvalue['responseMessage']="Teacher ID already exists";
			echo json_encode($postvalue);
			exit;
			}
	
	}
 if($imageDataEncoded=$obj->{'User_imagebase64'} != '')
		{
			 $data=$obj->{'User_imagebase64'};
			 $img = $obj->{'User_Image'};
			 $ex_img = explode(".",$img);
			 $img_name = "mid_".$member_id."_".date('mdYHi').".jpg";
			 $filenm=$_SERVER['DOCUMENT_ROOT'].'/teacher_images/'.$img_name;

			 $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
			 file_put_contents($filenm, $data);

			 $test = mysql_query("update tbl_teacher set t_pc = '$img_name' where id = '$User_Meid' and (school_id = '$school_id' or school_id ='$new_sc_id')");
		}

	if($t_complete_name != '' && $gender != '')
	{
		
	  $test = mysql_query("update `tbl_teacher` set t_complete_name = '$t_complete_name', t_name ='$fname' , t_middlename='$mname' ,t_lastname ='$lname',t_email='$email', t_dob = '$dob', t_address = '$address', t_city = '$city', t_country = '$country',state = '$state', t_gender = '$gender',t_phone = '$phone',  CountryCode = '$country_code' where id = '$User_Meid' and (school_id = '$school_id' or school_id ='$new_sc_id')");
	  
	}

	if($password != '')
	{
		$test = mysql_query("update `tbl_teacher` set t_password = '$password' where id = '$User_Meid' and (school_id = '$school_id' or school_id ='$new_sc_id')");
	}
			if($test)
			{
					 $postvalue['responseStatus']=200;
					 $postvalue['responseMessage']="OK";
					 echo json_encode($postvalue);
			}
			else
			{
					$postvalue['responseStatus']=1000;
					$postvalue['responseMessage']="Profile could not be updated";
					echo json_encode($postvalue);
			}
?>