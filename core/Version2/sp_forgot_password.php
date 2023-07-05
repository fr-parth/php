<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);
include 'conn.php';

$sp_email = xss_clean(mysql_real_escape_string($obj->{'sp_email'}));
$sp_phone =xss_clean(mysql_real_escape_string($obj->{'sp_phone'}));


function random_password( $length = 8 ) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$password = substr( str_shuffle( $chars ), 0, $length );
	return $password;
}
$sp_password=random_password(8);

if($sp_email != "" || $sp_phone != "" )
{
	if(!empty($sp_email))
	{
		$condition="sp_email='$sp_email'";
	
	}
	elseif(!empty($sp_phone))
	{
		$condition="sp_phone='$sp_phone'";
	}
	else
	{
						$post="Email Or Phone No Do Not Empty";
						$postvalue['responseStatus']=1007;
						$postvalue['responseMessage']="No Response";
						$postvalue['posts']=$post;
	}
	$mail_check_query = mysql_query("select sp_email,sp_phone,sp_password from tbl_sponsorer where $condition");
	
	$mail_check_query_result = mysql_num_rows($mail_check_query);
	
	
	if($mail_check_query_result > 0)
	{
			$q=mysql_query("update tbl_sponsorer set `sp_password`='$sp_password' where $condition ")or die(mysql_error());
			if($q)
			{
				/* author vaibhavg
				* here we put new query for getting updated password from table & added by VaibhavG as per the discussed with Android Developer Tabassum for ticket number SAND-1152.
				*/
				$mail_checked_query = mysql_query("select sp_email,sp_phone,sp_password from tbl_sponsorer where $condition");
				$result = mysql_fetch_array($mail_checked_query);
						
				$sp_pass=$result['sp_password'];
				$registered_email=$result['sp_email'];
				$registered_phone=$result['sp_phone'];
				
						
				$site = $GLOBALS['URLNAME'];
			
			
				$Text1="Dear Sponsor, Congratulations! You've successfully changed your password. Your Username is:$registered_phone Your Password is: $sp_pass Regards,Smart Cookie Admin $site";
				/*Below query added by Sayali Balkawade for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
						$sql_dynamic= mysql_query("select * from tbl_otp where id=1");
						$dynamic_fetch= mysql_fetch_array($sql_dynamic);
						$dynamic_user = $dynamic_fetch['mobileno'];
						$dynamic_pass = $dynamic_fetch['email'];
						$dynamic_sender = $dynamic_fetch['otp'];

				$Text=urlencode($Text1);
				$url="http://www.smswave.in/panel/sendsms.php?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$registered_phone&Text=$Text";
			
				$result=file_get_contents($url);
				
				$msgid='forgotpasswordsponsor';
				$curl = curl_init();
			// Set some options - we are passing in a useragent too here
				curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => "$site/core/clickmail/sendmail.php?email=$registered_email&msgid=$msgid&site=$site&pass=$sp_pass",
				CURLOPT_USERAGENT => 'Codular Sample cURL Request'
			));
			
		// Send the request & save response to $resp
					$result_mail = curl_exec($curl);
				$myres = explode('|',$result);	
						$res=trim($myres['1']);
						if($res == "Success" || stripos($result_mail,"Mail sent successfully"))
						{	
						$post="Password sent successfully on registered phone number/Email Id";
						$postvalue['responseStatus']=200;
						$postvalue['responseMessage']="OK";
						$postvalue['posts']=$post;
							
						}
						else{
						$post="SMS not sent ";
						$postvalue['responseStatus']=1006;
						$postvalue['responseMessage']="No Response";
						$postvalue['posts']=$post;
						}
			
						
			}
			else{
						$post="Something Is Wrong...!Please Try Again";
						$postvalue['responseStatus']=201;
						$postvalue['responseMessage']="No Response";
						$postvalue['posts']=$post;
				
			}
			
	}
	
	else
	{
		$postvalue['responseStatus']=204;
		$postvalue['responseMessage']="User not exists";
		$postvalue['posts']=null;
	}
}

else{
	$postvalue['responseStatus']=1000;
	$postvalue['responseMessage']="Invalid Input";
	$postvalue['posts']=null;
}
header('Content-type: application/json');
echo  json_encode($postvalue);

?>
