<?php  
$json = file_get_contents('php://input');
$obj = json_decode($json);
header('Content-type: application/json');

 $format = 'json'; //xml is the default
 
include 'conn.php';
	
	 $server_name=$GLOBALS['URLNAME'];
	 $key = xss_clean(mysql_real_escape_string($obj->{'key'}));
	 $t_id = xss_clean(mysql_real_escape_string($obj->{'t_id'}));
	 $User_Meid = xss_clean(mysql_real_escape_string($obj->{'User_Meid'}));
	 $fname = xss_clean(addslashes($obj->{'User_FName'}));
	 $mname = xss_clean(addslashes($obj->{'User_MName'}));
	 $lname = xss_clean(addslashes($obj->{'User_LName'}));
	 $school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
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


 if($imageDataEncoded=$obj->{'User_imagebase64'} != '')
		{
			 $data=$obj->{'User_imagebase64'};
			 $img = $obj->{'User_Image'};

			 $ex_img = explode(".",$img);
			 //date format changed by sachin
             //$img_name = "mid_".$member_id."_".date('mdYHi').".jpg";
			 
			 $img_name = "mid_".$member_id."_".date('YmdHi').".jpg";
			 
			 //end sachin
			 $entity="Teacher";
			 $start_dir="Images";
			 $path='../'.$start_dir.'/'.$school_id.'/'.$entity.'/';
			 if(!file_exists($path)){
				mkdir($path, 0705, true);
		 	 }
					
				$filenm=$path."/".$img_name;
				$filenm1 = $start_dir.'/'.$school_id.'/'.$entity."/".$img_name;

			$data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
			file_put_contents($filenm, $data);

			$test = mysql_query("update tbl_teacher set t_pc = '$filenm1' where id = '$User_Meid' and school_id = '$school_id'");
		}

	if($t_complete_name != '' && $gender != '')
	{
		
	  $test = mysql_query("update `tbl_teacher` set t_complete_name = '$t_complete_name', t_name ='$fname' , t_middlename='$mname' ,t_lastname ='$lname',t_email='$email', t_dob = '$dob', t_address = '$address', t_city = '$city', t_country = '$country',state = '$state', t_gender = '$gender',t_phone = '$phone',  CountryCode = '$country_code' where id = '$User_Meid' and school_id = '$school_id'");
	  
	}

	if($password != '')
	{
		$test = mysql_query("update `tbl_teacher` set t_password = '$password' where id = '$User_Meid' and school_id = '$school_id'");
	}
			if($test)
			{
					 $postvalue['responseStatus']=200;
					 $postvalue['responseMessage']="OK";
					 echo json_encode($postvalue);
			}
			else
			{
					$postvalue['responseStatus']=204;
					$postvalue['responseMessage']="No Response";
					echo json_encode($postvalue);
			}
?>