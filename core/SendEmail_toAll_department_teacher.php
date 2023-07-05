<?php
error_reporting(0);
include('conn.php');

$i=1;
$batch_id=$_GET['batch_id'];
//$p_lenght=strlen(trim(($phone)));
$School_id=$_GET['school_id'];
$Sms_status=$_GET['status'];
$department=$_GET['dept'];

$query2="select count(batch_id) as b_id,t_current_school_name from `tbl_teacher` where batch_id like '$batch_id' and school_id='$School_id' and t_dept='$department'";  //query for getting last batch_id what else if are inserting first time data
$row2=mysql_query($query2);
$value2=mysql_fetch_array($row2);
$count=$value2['b_id'];
$school_name=$value2['t_current_school_name'];

if($Sms_status!='Send_Email')
{

$query2=mysql_query("select t_password,t_email from `tbl_teacher` where batch_id like '$batch_id' and t_dept='$department' and school_id='$School_id' order by id"); 
$password=array();
$phone=array();
   while(($row = mysql_fetch_array($query2))) {
    $password[$i] = $row['t_password'];
	$email[$i] = $row['t_email'];
	
	 $from="smartcookiesprogramme@gmail.com";
	$to=$email[$i];
	$subject="Successful Registration";
	$message="".$school_name." is pleased to inform that you are part of SmartCookie Student/Teacher Rewards Program\r\n".
		   "your User ID is: "  .$email[$i].  "\n\n".
		  "& your password is: ".$password[$i]."\n".
		  "School ID is:".$School_id."\n\n".
		  "Please visit www.smartcookie.in for more details"."\r\n".
		  "Regards,\r\n".
   	      "Smart Cookie Admin";
		  
       mail($to, $subject, $message);
	
	
	/* $url1="+Please+visit+www.smartcookie.in";
	$Text="COEP+is+pleased+to+inform+that+you+are+part+of+smartcookie+program.+UserID+is+".$phone[$i]."+%26+Pswd+is+".$password[$i]."+".$url1."+for+more+details.";
	$url="http://www.smswave.in/panel/sendsms.php?user=blueplanet&password=123123&sender=PHUSER&PhoneNumber=$phone[$i]&Text=$Text";
	$response=file_get_contents($url); */
	$sql_update="UPDATE `tbl_teacher` SET send_unsend_status='Send_Email' WHERE batch_id like '$batch_id' and t_dept='$department' and school_id='$School_id' and t_email like '$email[$i]'";
    $retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error());
	
		} 
	
 echo "<script type=text/javascript>alert('Email has been sent Successfully to $department'); window.location='SendMSG_department_Teacher.php'</script>";
}
 

else
{
echo "<script type=text/javascript>alert('You have already sent Email to $count teachers in $batch_id !! Thank You'); window.location='Send_Msg_Teacher.php'</script>";	
} 

/* else
{
	echo "<script type=text/javascript>alert('Sorry, No Phone No.'); window.location='Send_Msg_Teacher.php'</script>";
}  */ 
 

  /* $url1="+Please+visit+www.smartcookie.in";
$Text="COEP+is+pleased+to+inform+that+you+are+part+of+smartcookie+program.+UserID+is+".$phone."+%26+Pswd+is+".$password."+".$url1."+for+more+details.";
$url="http://api.smscountry.com/SMSCwebservice_bulk.aspx?User=ashishd&passwd=Passion@2015&mobilenumber=$phone&message=$Text&sid=SMCOOKIE&mtype=N&DR=Y&SMS_Job_NO";
$response=file_get_contents($url);   */
             
?>