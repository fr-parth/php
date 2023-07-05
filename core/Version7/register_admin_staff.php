<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);
 include '../conn.php';

$format = 'json'; //xml is the default
$staff_name = xss_clean(mysql_real_escape_string($obj->{'stf_name'}));
$school_id= xss_clean(mysql_real_escape_string($obj->{'school_id'})); 
$desg = xss_clean(mysql_real_escape_string($obj->{'designation'})); 
$address = xss_clean(mysql_real_escape_string($obj->{'addd'})); 
$country = xss_clean(mysql_real_escape_string($obj->{'country'})); 
$city = xss_clean(mysql_real_escape_string($obj->{'city'})); 
$state = xss_clean(mysql_real_escape_string($obj->{'statue'}));
$email = xss_clean(mysql_real_escape_string($obj->{'email'}));
$cc = xss_clean(mysql_real_escape_string($obj->{'CountryCode'}));
$mobile = xss_clean(mysql_real_escape_string($obj->{'phone'}));
//$date = xss_clean(mysql_real_escape_string($obj->{'currentDate'}));

if($staff_name!='' && $country!='' && $desg!='' && $mobile!='')
{
	$sql_exist = mysql_query("SELECT * from tbl_school_adminstaff where school_id='$school_id' and email='$email'");
	if(mysql_num_rows($sql_exist) > 0){
		$postvalue['responseStatus']=206;
		$postvalue['responseMessage']="Staff already exists for entered email and school id.. Please try another one";
			
	}
	else {
			$sql1=mysql_query("SELECT * from tbl_school_admin where school_id='$school_id'");
		
	 	if(mysql_num_rows($sql1) > 0)
		{
			$ins=mysql_query("update tbl_school_admin SET email='$email',mobile='$mobile' where school_id='$school_id'");
			$date=date('y-d-m');
			$query = mysql_query("insert into tbl_school_adminstaff (stf_name, school_id,  designation, addd, country, city, statue, email, CountryCode, phone, currentDate, delete_flag) VALUES ('$staff_name','$school_id','$desg','$address','$country','$city','$state','$email','$cc','$mobile','$date','0')");
			
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="OK";
		}
		else
		{
			$postvalue['responseStatus']=1000;
			$postvalue['responseMessage']="wrong school_id";
			
		}

  	}
}
else
{
	
	$postvalue['responseStatus']=204;
	$postvalue['responseMessage']="Insufficient Data";
	
	 
}

header('Content-type: application/json');
echo json_encode($postvalue); 
@mysql_close($con);		


?>