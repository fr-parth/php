<?php
error_reporting(0);
include('conn.php');
require "twilio.php";
$i=1;
$batch_id=$_GET['batch_id'];
//$p_lenght=strlen(trim(($phone)));
$School_id=$_GET['school_id'];
$Sms_status=$_GET['status'];
$country=$_GET['country'];
$department=$_GET['dept'];
$query2="select count(batch_id) as b_id,t_current_school_name,t_country from `tbl_teacher` where batch_id like '$batch_id' and school_id='$School_id' and t_dept='$department'";  //query for getting last batch_id what else if are inserting first time data
$row2=mysql_query($query2);
$value2=mysql_fetch_array($row2);
$count=$value2['b_id'];
$school_name=$value2['t_current_school_name'];
$country=$value2['t_country'];
if($country!='')
{
if($country=='India')   // India
{	
if($Sms_status!='Send_SMS')
{

$query2=mysql_query("select t_password,t_phone from `tbl_teacher` where batch_id like '$batch_id' and school_id='$School_id' and t_dept='$department' order by id"); 
$password=array();
$phone=array();
/*Below query added by Rutuja for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
                        	$sql_dynamic= mysql_query("select * from tbl_otp where id=1");
                        	$dynamic_fetch= mysql_fetch_array($sql_dynamic);
                        	$dynamic_user = $dynamic_fetch['mobileno'];
                        	$dynamic_pass = $dynamic_fetch['email'];
                        	$dynamic_sender = $dynamic_fetch['otp'];
                        	
   while(($row = mysql_fetch_array($query2))) {
    $password[$i] = $row['t_password'];
	$phone[$i] = $row['t_phone'];
	
	$url1="+Please+visit+www.smartcookie.in";
	//$Text="".$school_name."+is+pleased+to+inform+that+you+are+part+of+smartcookie+program.+UserID+is+".$phone[$i]."+%26+Pswd+is+".$password[$i]."+".$url1."+for+more+details.";
	$Text="CONGRATULATIONS!+,+You+are+now+a+registered+User+of+Smart+Cookie+-+A+Student+/+Teacher+Rewards+Program.+Your+Username+is+".$phone[$i]."+and+Password+is+".$password[$i]."+".$url1."+for+more+details.";
	$url="http://www.smswave.in/panel/sendsms.php?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$phone[$i]&Text=$Text";
	$response=file_get_contents($url);
	$sql_update="UPDATE `tbl_teacher` SET send_unsend_status='Send_SMS' WHERE batch_id like '$batch_id' and t_dept='$department' and school_id='$School_id' and t_phone like '$phone[$i]'";
    $retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error());
	
		} 
	
 echo "<script type=text/javascript>alert('Message has been sent Successfully to $count teachers in $department'); window.location='Send_Msg_Teacher.php'</script>";
}
 

else
{
echo "<script type=text/javascript>alert('You have already sent SMS Message to $department !! Thank You'); window.location='Send_Msg_Teacher.php'</script>";	
} 

}

else      //USA
{
	
if($Sms_status!='Send_SMS')
{

$query2=mysql_query("select t_password,t_phone from `tbl_teacher` where batch_id like '$batch_id' and t_dept='$department' and school_id='$School_id' order by id"); 
$password=array();
$phone=array();
   while(($row = mysql_fetch_array($query2))) {
    $password[$i] = $row['t_password'];
	$phone[$i] = $row['t_phone'];
	
	
	$ApiVersion = "2010-04-01";

	// set our AccountSid and AuthToken
	$AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
	$AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";
    
	// instantiate a new Twilio Rest Client
	$client = new TwilioRestClient($AccountSid, $AuthToken);
	$number="+1".$phone[$i];
	
	//$url1="Please visit www.smartcookie.in";
    //$Text=" ".$sc_name." is pleased to inform that you are part of SmartCookie Rewards program. UserID is ".$phone." Pswd is ".$password." ".$url1." for more details.";
	 $Text="CONGRATULATIONS!,You are now a registered User of Smart Cookie -A Student/Teacher Rewards Program.Your UserID is ".$phone[$i]." and Pswd is ".$password[$i]." ."; 
				
				$response = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
			"POST", array(
			"To" => $number,
			"From" => "732-798-7878",
			"Body" => $Text
		));
	$sql_update="UPDATE `tbl_teacher` SET send_unsend_status='Send_SMS' WHERE batch_id like '$batch_id' and t_dept='$department' and school_id='$School_id' and t_phone like '$phone[$i]'";
    $retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error());
	
		} 
	
 echo "<script type=text/javascript>alert('Message has been sent Successfully to $count teachers in $department'); window.location='Send_Msg_Teacher.php'</script>";
}
 

else
{
echo "<script type=text/javascript>alert('You have already sent SMS Message to $department !! Thank You'); window.location='Send_Msg_Teacher.php'</script>";	
} 	
	
}
}
else
{
	echo "<script type=text/javascript>alert('Sorry,Require Country name'); window.location='Send_Msg_Teacher.php'</script>";
}	            
?>