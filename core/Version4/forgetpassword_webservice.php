<?php  
/*
Author : Pranali Dalvi
Date: 19/09/2020
*/

include("../connsqli.php");
include("../securityfunctions.php");
$json = file_get_contents('php://input');
$obj = json_decode($json);
$format = 'json';
//Removed mysql real escape string by Pranali for SMC-4842 ON 17-10-20
$email_id = $obj->{'email'};
$entity_id = $obj->{'entity_id'};
$school_id = $obj->{'school_id'};
//Country code added by Rutuja for SMC-5024 on 12-12-2020
$CountryCode = $obj->{'CountryCode'};
$site = $GLOBALS['URLNAME'];
//$site = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'];
$school_reg = mysqli_query($conn,"SELECT * FROM tbl_school_admin where school_id='".$school_id."'");
$school_arr = mysqli_fetch_array($school_reg);
$school_type = isset($school_arr['school_type']) ? $school_arr['school_type'] : "school";


if($email_id=="")
{
	$postvalue['responseStatus']=1000;
	$postvalue['responseMessage']="Please enter email id";
	header('Content-type: application/json');
	echo json_encode($postvalue);
	exit;		 
}
else if($entity_id=="")
{
	$postvalue['responseStatus']=1000;
	$postvalue['responseMessage']="Please enter entity id";
	header('Content-type: application/json');
	echo json_encode($postvalue);
	exit;
}
else if($school_id=="" && ($entity_id==1 || $entity_id==2 || $entity_id==3 || $entity_id==5 || $entity_id==7))
{
	$postvalue['responseStatus']=1000;
	$postvalue['responseMessage']="Please enter valid school / organization id";
	header('Content-type: application/json');
	echo json_encode($postvalue);
	exit;		 
}
else if(mysqli_num_rows($school_reg)==0 && ($entity_id==1 || $entity_id==2 || $entity_id==3 || $entity_id==5 || $entity_id==7))
{
	$postvalue['responseStatus']=1000;
	$postvalue['responseMessage']="Please enter registered school / organization id";
	header('Content-type: application/json');
	echo json_encode($postvalue);
	exit;		 
}
else
{
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$password = substr( str_shuffle( $chars ), 0, 8 );
				
	$posts=array();
//Added below switch case by Pranali for SMC-4842
	switch ($entity_id) {
		case 1:
		//student / employee
				$arr_query = "select std_phone as phone,std_email as email,country_code as country_code, (CASE WHEN entity_type_id='105' THEN 'school' 
				WHEN entity_type_id='205' THEN 'organization' 
				ELSE '' END) as school_type
			  from tbl_student where (std_email='$email_id' OR std_phone='$email_id') and school_id='$school_id'";

				$update_query = "update tbl_student set std_password='$password' where (std_email='$email_id' OR std_phone='$email_id') and school_id='$school_id'";

				$msgid='forgotpasswordstudent';
				if($school_type == 'school')
				{
					$entity='Student';
				}
				else if($school_type == 'organization')
				{
					$entity='Employee';
				}
					break;
				
		case 2:
	//teacher / manager
				$arr_query = "select t_email as email,t_phone as phone,CountryCode as country_code,school_type as school_type from tbl_teacher where (t_email='$email_id' OR t_phone='$email_id') and school_id='$school_id'";

				$update_query = "update tbl_teacher set t_password='$password' where (t_email='$email_id' OR t_phone='$email_id') and school_id='$school_id'";

				$msgid='forgotpasswordteacher';
				$entity = 'Teacher';
				if($school_type == 'school')
				{
					$entity='Teacher';
				}
				else if($school_type == 'organization')
				{
					$entity='Manager';
				}
					break;

		case 3:
		//school / organization admin
				$arr_query = "select email as email,mobile as phone,CountryCode as country_code,school_type as school_type from tbl_school_admin where (email='$email_id' OR mobile='$email_id') and school_id='$school_id'";

				$update_query = "update tbl_school_admin set password='$password' where (email='$email_id' OR mobile='$email_id') and school_id='$school_id'";
				
				$msgid='forgotpasswordschooladmin';
				$entity_new = ucfirst($school_type).' Admin';
				$entity = preg_replace("/[\s]/", "+", $entity_new);
				break;

		case 4:
		//sponsor
				$arr_query = "select sp_email as email,sp_phone as phone,CountryCode as country_code from tbl_sponsorer where (sp_email='$email_id' OR sp_phone='$email_id')";

				$update_query = "update tbl_sponsorer set sp_password='$password' where (sp_email='$email_id' OR sp_phone='$email_id')";
				
				$msgid='forgotpasswordsponsor';
				$entity = 'Sponsor';
				break;

		case 5:
		//Parent
				$arr_query = "select email_id as email,Phone as phone,CountryCode as country_code from tbl_parent where (email_id='$email_id' OR Phone='$email_id') and school_id='$school_id'";

				$update_query = "update tbl_parent set Password='$password' where (email_id='$email_id' OR Phone='$email_id') and school_id='$school_id'";
				
				$msgid='forgotpasswordparent';
				$entity = 'Parent';
				break;

		case 6:
		//Cookie Admin
				$arr_query = "select admin_email as email,mobile_no as phone,country_code as country_code from tbl_cookieadmin where (admin_email='$email_id' OR mobile_no='$email_id') and id=1";

				$update_query = "update tbl_cookieadmin set admin_password='$password' where (admin_email='$email_id' OR mobile_no='$email_id') and id=1";
				
				$msgid='forgotpasswordcookieadmin';
				$entity = preg_replace("/[\s]/", "+", "Cookie Admin");
				
				break;

		case 7:
		//School / HR Admin Staff
				$arr_query = "select email as email,phone as phone,CountryCode as country_code from tbl_school_adminstaff where (email='$email_id' OR phone='$email_id') and school_id='$school_id'";

				$update_query = "update tbl_school_adminstaff set pass='$password' where (email='$email_id' OR phone='$email_id') and school_id='$school_id'";
				
				$msgid='forgotpasswordschooladminstaff';
				$entity_new = $school_type." Admin Staff";
				$entity = preg_replace("/[\s]/", "+", $entity_new);
				break;

		case 8:
		//Group Admin
				$arr_query = "select admin_email as email,mobile_no as phone,country_code as country_code,group_mnemonic_name as group_id from tbl_cookieadmin where (admin_email='$email_id' OR mobile_no='$email_id') and id!=1";

				$update_query = "update tbl_cookieadmin set admin_password='$password' where (admin_email='$email_id' OR mobile_no='$email_id') and id!=1";
				
				$msgid='forgotpasswordgroupadmin';
				$entity = preg_replace("/[\s]/", "+", "Group Admin");
				break;

		case 9:
		//Cookie Admin Staff
				$arr_query = "select email as email,phone as phone,CountryCode as country_code from tbl_cookie_adminstaff where (email='$email_id' OR phone='$email_id')";

				$update_query = "update tbl_cookie_adminstaff set pass='$password' where (email='$email_id' OR phone='$email_id')";
				
				$msgid='forgotpasswordcookieadminstaff';
				$entity = preg_replace("/[\s]/", "+", "Cookie Admin Staff");
				break;

		case 10:
		//Salesperson
				$arr_query = "select p_email as email,p_phone as phone,CountryCode as country_code from tbl_salesperson where (p_email='$email_id' OR p_phone='$email_id')";

				$update_query = "update tbl_salesperson set p_password='$password' where (p_email='$email_id' OR p_phone='$email_id')";
				
				$msgid='forgotpasswordsalesperson';
				$entity = 'Salesperson';
				break;

		case 11:
		//Group Admin Staff
				$arr_query = "select email as email,phone as phone,CountryCode as country_code,group_mnemonic_name as group_id from tbl_cookie_adminstaff where (email='$email_id' OR phone='$email_id') and group_member_id!=''";

				$update_query = "update tbl_cookie_adminstaff set pass='$password' where (email='$email_id' OR phone='$email_id') and group_member_id!=''";
				
				$msgid='forgotpasswordgroupadminstaff';
				$entity = preg_replace("/[\s]/", "+", "Group Admin Staff");
				break;

		default :
				$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Please enter valid entity id";
				header('Content-type: application/json');
				echo json_encode($postvalue);
				exit;
				break;
	}
	
		
			$arr=mysqli_query($conn,$arr_query);
			$count = mysqli_num_rows($arr);

			if($count==1)
			{
				$query=mysqli_query($conn,$update_query);

				while($row=mysqli_fetch_array($arr))
				{
					$std_phone=$row['phone'];
					$std_email=$row['email']; 
					$country_code = $CountryCode;
					if($country_code==""){ $country_code='91'; }
					$group_id = isset($row['group_id']) ? $row['group_id'] : '';
				}	
				

									$school_id_new = urlencode($school_id);
									$report='Your password has been sent to your registered ';
									
									$res = file_get_contents("$site/core/clickmail/sendmail.php?email=$std_email&msgid=$msgid&site=$site&pass=$password&school_type=$school_type&school_id=$school_id_new&entity=$entity&group_short_name=$group_id");

									// if($res=='<h3 style="color:#009933;">Mail sent successfully</h3>')
									// {
									// 	$report .= 'Email ID ';
									// }

									if($entity_id==1 || $entity_id==2 || $entity_id==3 || $entity_id==5 || $entity_id==7)
									{
										$Text1="You recently requested to reset your password  for Smartcookie $entity. Your Username is: $email_id. Your Password is: $password. Your $school_type ID is: $school_id. Smartcookie Admin $site";
									}
									else if($entity_id==8)
									{
										$Text1="You recently requested to reset your password  for Smartcookie $entity. Your Username is: $email_id. Your Password is: $password. Your Group ID is: $group_id. Smartcookie Admin $site";
									}
									else{
										$Text1="You recently requested to reset your password  for Smartcookie $entity. Your Username is: $email_id. Your Password is: $password. Smartcookie Admin $site";
									}

										//$Text=urlencode($Text1);
									$Text = preg_replace("/[\s]/", "+", $Text1);

									if($std_phone!='' && ($country_code=='91' || $country_code=='+91'))
							        {
							            $sms_sql = mysqli_query($conn,"SELECT * FROM tbl_otp WHERE id='1'");
							            $sms = mysqli_fetch_assoc($sms_sql);
							            $sms_user = $sms['mobileno'];
							            $sms_password = $sms['email'];
							            $sms_sender = $sms['otp'];
										//Added SEND_SMS_PATH and &msgType=$msgType&Pe_id=$pe_id&template_id=$template_id by Pranali for SMC-5166
										$url=SEND_SMS_PATH."?user=$sms_user&password=$sms_password&sender=$sms_sender&PhoneNumber=$std_phone&Text=$Text&msgType=$msgType&Pe_id=$pe_id&template_id=$template_id";
										$result= file_get_contents($url);
									}
									else if($std_phone!='' && ($country_code=='1' || $country_code=='+1'))
							        {
							                $ApiVersion = "2010-04-01";

							                // set our AccountSid and AuthToken

							                $AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
							                $AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";

							                // instantiate a new Twilio Rest Client

							                $client = new TwilioRestClient($AccountSid, $AuthToken);
							                $number = "+1" . $std_phone;
							                $result = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", "POST", 
							                    array(                                                      "To" => $number,
							                        "From" => "732-798-7878",
							                        "Body" => $Text
							                        ));
							        }
// Below code added by Pranali to check success and error messages received after sending Email / SMS for SMC-4842 on 16-0-20
							       $res = substr($res,27,-6);
							        $sms_res_arr = explode(" | ", $result);
							        $sms_res = $sms_res_arr[1];

									if($res == "Mail sent successfully" && $sms_res=="Success")	
									{
										$report .="Email ID and Mobile No";
									}
									else if($res != "Mail sent successfully" && $sms_res=="Success")
									{	
										$report .="Mobile No";
									}	
									else if($res == "Mail sent successfully" && $sms_res!="Success")
									{
										$report .="Email ID";
									}
									else{
										$report = "Email and SMS sending failed";
									}
						
			}
			else if($count==0)
			{
				if (filter_var($email_id, FILTER_VALIDATE_EMAIL)) {
					$error_msg = 'Email ID is not registered in system';
				}
				else
				{
					$error_msg = 'Mobile number is not registered in system';
				}
						$postvalue['responseStatus']=404;
						$postvalue['responseMessage']=$error_msg;
						header('Content-type: application/json');
						echo json_encode($postvalue);
						exit;
			}
			else{
						$postvalue['responseStatus']=409;
						$postvalue['responseMessage']="Multiple users exist for same Email ID or Phone number";
						header('Content-type: application/json');
						echo json_encode($postvalue);
						exit;
			}

					if($report)
					{
						$posts[]=array('report'=>$report);	  
						$postvalue['responseStatus']=200;
						$postvalue['responseMessage']=$report;
						// $postvalue['posts']=$posts;
						header('Content-type: application/json');
						echo json_encode($postvalue);
						exit;
					}
					else    
					{
						$postvalue['responseStatus']=204;
						$postvalue['responseMessage']="Email and SMS sending failed .. Please try again!!";
						// $postvalue['posts']=null;
						header('Content-type: application/json');
						echo json_encode($postvalue);
						exit;

					}	

}      

?>