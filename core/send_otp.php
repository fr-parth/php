<?php
include "conn.php";
require "twilio.php";
$report=false;
$err=false;
$errflag=false;
$msg=0;
$sp=$_POST['sp'];
$mob="/^[789][0-9]{9}$/";
$emailval = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/';
$otp=rand(1000,9999);

	if(!empty($_POST['ph']) && !empty($_POST['cc']) && !empty($_POST['sp']) ){		
	$stdmob=$_POST['ph'];		
	$cc=$_POST['cc'];
	$sp=$_POST['sp'];
		if(!preg_match($mob, $stdmob)){ 
		echo $msg="Check your Mobile number ";
		}
		mysql_query("update tbl_sponsorer set `temp_phone`='$stdmob', `otp_phone`='$otp' where `id`='$sp'");	
		if($cc=='91'){

			/*Below query added by Rutuja for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
                        $sql_dynamic= mysql_query("select * from tbl_otp where id=1");
                        $dynamic_fetch= mysql_fetch_array($sql_dynamic);
                        $dynamic_user = $dynamic_fetch['mobileno'];
                        $dynamic_pass = $dynamic_fetch['email'];
                        $dynamic_sender = $dynamic_fetch['otp'];

			$Text="OTP+is+".$otp."+Thank+You"; 
			$url="http://www.smswave.in/panel/sendsms.php?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$stdmob&Text=$Text";
			file_get_contents($url);
			echo $report="OTP Sent";
		}
		if($cc=='1'){
			$ApiVersion = "2010-04-01";

			// set our AccountSid and AuthToken
			$AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
			$AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";
			
			// instantiate a new Twilio Rest Client
			$client = new TwilioRestClient($AccountSid, $AuthToken);
			$number="+1".$stdmob;
			$message="OTP is ".$otp." Thank You. "; 
				
				$response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
					"POST", array(
					"To" => $number,
					"From" => "732-798-7878",
					"Body" => $message
				));
			echo $report="OTP Sent";	
		} 		
			
	}
	
	
	if(!empty($_POST['eml']) && !empty($_POST['sp']) ){
		$stdemail=$_POST['eml'];
		$sp=$_POST['sp'];
		if(!preg_match($emailval, $stdemail)){	 
				echo $msg="Check your email";
		}
		mysql_query("update tbl_sponsorer set `temp_email`='$stdemail', `otp_email`='$otp' where `id`='$sp'");
		$to=$stdemail;
		$from="smartcookiesprogramme@gmail.com";
		$subject="Email Verification";
		$message="Dear Sponsorer,\r\n\r\n".			 
			  "Your OTP is: ".$otp."\n\n".
			  "\n\n".
			  "Regards,\r\n".
			  "Smart Cookie Admin \n"."www.smartcookie.in";
			  
		mail($to, $subject, $message);
		
		echo "Email Sent";
	}	
	

if(!empty($_POST['emailotp']) && !empty($_POST['sp']) ){
	$temp_email1=mysql_query("select temp_email,otp_email from tbl_sponsorer where `id`='$sp'");
	$temp_email=mysql_fetch_array($temp_email1);
	$te=$temp_email['temp_email'];
	$oe=$temp_email['otp_email'];
	if($_POST['emailotp']==$oe){
	
	mysql_query("update tbl_sponsorer set `sp_email`='$te',`temp_email`='', `otp_email`='1' where `id`='$sp'")or die("Error Occured");
	echo "Email Updated";
	}else{
		echo "OTP Does Not Match";
	}
}

if(!empty($_POST['phoneotp']) && !empty($_POST['sp']) ){
	$temp_email1=mysql_query("select temp_phone,otp_phone from tbl_sponsorer where `id`='$sp'");
	$temp_email=mysql_fetch_array($temp_email1);	
	$te=$temp_email['temp_phone'];
	$op=$temp_email['otp_phone'];
	
	if($_POST['phoneotp']==$op){
	mysql_query("update tbl_sponsorer set `sp_phone`='$te',`temp_phone`='', `otp_phone`='1' where `id`='$sp'")or die("Error Occured");
	echo "Phone Number Updated";
	}else{
		echo "OTP Does Not Match";
	}
}
