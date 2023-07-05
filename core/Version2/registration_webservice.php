<?php  
//$json=$_GET ['json'];
$json = file_get_contents('php://input');
$obj = json_decode($json);
include 'conn.php';
$test='';
function email_user_password($email,$pass, $uname, $ehr){
	
$str="Hello $uname , \r\n You are successfully registered with us. <table><tr><td>Your username is:</td><td>$email</td></tr>
			<tr><td>Your password is:</td><td>$pass</td></tr> 
			</table>";
	// Always set content-type when sending HTML email
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	// More headers
	$headers .= 'From: <admin@startupworld.com>' . "\r\n";
	
	//for sending an email
	$to=$email; 
	if($ehr=='Y' or $ehr=='y'){
		$subject="StartupWorld and Ethical-HR Registration";
	}else{
		$subject="StartupWorld Registration";
	}
	
	
	mail($to,$subject,$str,$headers); 
}

function message_india($email, $mobile, $pass, $ehr){
	if($ehr=='Y' or $ehr=='y' ){
		$Text="CONGRATULATIONS%21,+You+are+now+a+registered+User+of+StartupWorld+and+Ethical-HR.+Your+Username+is+".$email."+and+Password+is+".$pass."."; 
	}else{
		$Text="CONGRATULATIONS%21,+You+are+now+a+registered+User+of+StartupWorld.+Your+Username+is+".$email."+and+Password+is+".$pass."."; 
	}
/*Below query added by Rutuja for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
$sql_dynamic= mysql_query("select * from tbl_otp where id=1");
$dynamic_fetch= mysql_fetch_array($sql_dynamic);
$dynamic_user = $dynamic_fetch['mobileno'];
$dynamic_pass = $dynamic_fetch['email'];
$dynamic_sender = $dynamic_fetch['otp'];

	$url="http://www.smswave.in/panel/sendsms.php?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$mobile&Text=$Text";
	file_get_contents($url);
}


if($obj->{'User_Name'}!= '' && $obj->{'User_email'}!= '' && $obj->{'User_collage'}!= ''){
			$name =$obj->{'User_Name'};
			
 			$email=$obj->{'User_email'};
			$pass= $obj->{'User_pass'};
			$mobile=$obj->{'User_mobile'};
			$ehr='N';
			
			$mob="/^[789][0-9]{9}$/";
			$emailval = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/';
				
			if(!preg_match($emailval, $email)){	 
			$test="Check your email";
			}			

			if(!preg_match($mob, $mobile)){ 
			$test="Check your Mobile number ";
			}	
			if($test!=""){
			email_user_password($email,$obj->{'User_pass'},$obj->{'User_Name'}, $ehr);
			}

$query = mysql_query("SELECT * FROM tbl_user WHERE email = '".$email."' ");
$count = mysql_num_rows($query);
if($count == 0 )
{
$test = mysql_query("INSERT INTO `tbl_user` (uname, dob, age, gender, add1, add2, city, state, pincode, college, mobile, email, pass, liketobe, other, is_ehr) VALUES('".$obj->{'User_Name'}."', '".$obj->{'User_Dob'}."', '".$obj->{'User_age'}."', '".$obj->{'User_gender'}."', '".$obj->{'User_add1'}."', '".$obj->{'User_add2'}."', '".$obj->{'User_city'}."', '".$obj->{'User_state'}."', '".$obj->{'User_pin'}."', '".$obj->{'User_collage'}."',  '".$obj->{'User_mobile'}."', '".$obj->{'User_email'}."', '".$obj->{'User_pass'}."', '".$obj->{'User_to_be'}."', '".$obj->{'User_HereAboutUs'}."', '".$obj->{'is_ehr'}."')");
$insertid=mysql_insert_id();
mysql_query("INSERT INTO `tbl_notes` (`callstatus`, `calltype`, `cnotes`,`userid`, `addedby`) VALUES 
										 ('No activity', '', 'No Activity', '$insertid', '')");	

		

$test="true";
 $posts = array($test);
    header('Content-type: application/json');
    echo json_encode(array('posts'=>$posts));
		}

}
elseif($count != 0)
{
	$test = "false";
	 $posts = array($test);
    header('Content-type: application/json');
    echo json_encode(array('posts'=>$posts));
}
else
{
	
	$test = "Invalid Data";
	 $posts = array($test);
    header('Content-type: application/json');
    echo json_encode(array('posts'=>$posts));
}




	
//echo $json;
/*include 'conn.php';
echo $test="";

function email_user_password($email,$pass, $uname, $ehr){
	
$str="Hello $uname , \r\n You are successfully registered with us. <table><tr><td>Your username is:</td><td>'pravinc@blueplanetsolutions.com'</td></tr>
			<tr><td>Your password is:</td><td>'123'</td></tr> 
			</table>";
	// Always set content-type when sending HTML email
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	// More headers
	$headers .= 'From: <admin@startupworld.com>' . "\r\n";
	
	//for sending an email
	$to=$email; 
	if($ehr=='Y' or $ehr=='y'){
		$subject="StartupWorld and Ethical-HR Registration";
	}else{
		$subject="StartupWorld Registration";
	}
	
	
	mail($to,$subject,$str,$headers); 
}

function message_india($email, $mobile, $pass, $ehr){
	if($ehr=='Y' or $ehr=='y' ){
		$Text="CONGRATULATIONS%21,+You+are+now+a+registered+User+of+StartupWorld+and+Ethical-HR.+Your+Username+is+".$email."+and+Password+is+".$pass."."; 
	}else{
		$Text="CONGRATULATIONS%21,+You+are+now+a+registered+User+of+StartupWorld.+Your+Username+is+".$email."+and+Password+is+".$pass."."; 
	}
	
	$url="http://www.smswave.in/panel/sendsms.php?user=blueplanet&password=123123&sender=PHUSER&PhoneNumber=$mobile&Text=$Text";
	file_get_contents($url);
}


//Save
if($obj->{'User_Name'} != '' && $obj->{'User_email'} != '' && $obj->{'User_collage'} != ''){
			$email=$obj->{'User_email'};
			$mobile=$obj->{'User_mobile'};
			$ehr=$obj->{'is_ehr'};
			
			$mob="/^[789][0-9]{9}$/";
			$emailval = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/';
				
			if(!preg_match($emailval, $email)){	 
			$test="Check your email";
			}			

			if(!preg_match($mob, $mobile)){ 
			$test="Check your Mobile number ";
			}	

$query = mysql_query("SELECT * FROM tbl_user WHERE email = '".$obj->{'User_email'}."' ");
$count = mysql_num_rows($query);
if($count == 0 )
{

		if($test!=""){
			email_user_password($email, $obj->{'User_pass'}, $obj->{'User_Name'}, $ehr);
		if($mobile!=""){
			message_india($email, $mobile, $obj->{'User_pass'}, $ehr);
		}	


$test = mysql_query("INSERT INTO `startupworld`.`tbl_user` (uname, dob, age, gender, add1, add2, city, state, pincode, college, mobile, email, pass, liketobe, other, is_ehr) VALUES('".$obj->{'User_Name'}."', '".$obj->{'User_Dob'}."', '".$obj->{'User_age'}."', '".$obj->{'User_gender'}."', '".$obj->{'User_add1'}."', '".$obj->{'User_add2'}."', '".$obj->{'User_city'}."', '".$obj->{'User_state'}."', '".$obj->{'User_pin'}."', '".$obj->{'User_collage'}."',  '".$obj->{'User_mobile'}."', '".$obj->{'User_email'}."', '".$obj->{'User_pass'}."', '".$obj->{'User_to_be'}."', '".$obj->{'User_HereAboutUs'}."', '".$obj->{'is_ehr'}."')");
$insertid=mysql_insert_id();
mysql_query("INSERT INTO `tbl_notes` (`callstatus`, `calltype`, `cnotes`,`userid`, `addedby`) VALUES 
										 ('No activity', '', 'No Activity', '$insertid', '')");




if('uname'!= '' && 'email'!= '' && 'college'!= ''){
			$email=$obj->{'User_email'};
			$mobile=$obj->{'User_mobile'};
			$ehr=$obj->{'is_ehr'};
			
			$mob="/^[789][0-9]{9}$/";
			$emailval = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/';
				
			if(!preg_match($emailval, $email)){	 
			$test="Check your email";
			}			

			if(!preg_match($mob, $mobile)){ 
			$test="Check your Mobile number ";
			}	

$query = mysql_query("SELECT * FROM tbl_user WHERE email = '$email' ");
$count = mysql_num_rows($query);

if($count == 0 )
{

		if($test!=""){
			email_user_password($email, '123', 'pravin', $ehr);
		if($mobile!=""){
			message_india($email, $mobile, '123', $ehr);
		}	


$test = mysql_query("INSERT INTO `startupworld`.`tbl_user` (uname, dob, age, gender, add1, add2, city, state, pincode, college, mobile, email, pass, liketobe, other, is_ehr) VALUES('pravin', '01-01-1990', '20', '1', 'pune', 'kothrud', 'pune', 'maharashtra', '410038', 'dkte',  '9421614354', 'pravin@blueplanetsolutions.com', '123', 'null', 'Facebook', 'null')");
$insertid=mysql_insert_id();
mysql_query("INSERT INTO `tbl_notes` (`callstatus`, `calltype`, `cnotes`,`userid`, `addedby`) VALUES 
										 ('No activity', '', 'No Activity', '$insertid', '')");
										 
										 
mysql_close($con);

$test="Registered";
 $posts = array($test);
    header('Content-type: application/json');
    echo json_encode(array('posts'=>$posts));
		}

}
else
{
	$test = "Email exists";
	 $posts = array($test);
    header('Content-type: application/json');
    echo json_encode(array('posts'=>$posts));
}

}
		}
}
}		
else
{
	$test = "Invalid Data";
	 $posts = array($test);
    header('Content-type: application/json');
    echo json_encode(array('posts'=>$posts));

}*/


		
  ?>