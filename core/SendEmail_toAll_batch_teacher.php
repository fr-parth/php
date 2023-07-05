<?php
ini_set("max_execution_time", "-1");
ini_set("memory_limit", "-1");
ignore_user_abort(true);
set_time_limit(0);
error_reporting(0);
include('conn.php');

$i=1;
$success=0;
$fail =0;
$invalide_email = 0;
$batch_id=$_GET['batch_id'];
 $date=date('Y-m-d H:i:s');
//$p_lenght=strlen(trim(($phone)));
$School_id=$_GET['school_id'];
$query2="select t_email,school_id,t_country,t_phone,t_password,t_current_school_name,send_unsend_status from `tbl_teacher` where batch_id ='$batch_id' and school_id='$School_id' order by id desc";
$row2=mysql_query($query2);
$site = $_SERVER['HTTP_HOST'];
$msgid='welcometeacherfromscadmin';
while($value2=mysql_fetch_array($row2))
{
$email=$value2['t_email'];
//echo "<script>alert('$email')</script>";
//echo "<script></script>";
//echo "<script></script>";
$e_lenght=strlen(trim(($email)));
$School_id=$value2['school_id'];
$Email_status=$value2['status'];
$password=$value2['t_password'];
$status=$value2['email_status'];
$school_name=$value2['t_current_school_name'];
$s_name=explode(" ",$school_name);
		$sc_name=$s_name[0]."".$s_name[1]."".$s_name[2]."".$s_name[3];
if($e_lenght>0 && filter_var($email, FILTER_VALIDATE_EMAIL))
{
						$res = file_get_contents("http://$site/core/clickmail/sendmail.php?email=$email&msgid=$msgid&site=$site&pass=$password&school_name=".urlencode($school_name)."");
						if(stripos($res,"Mail sent successfully"))
						{
							$success++;
							$sql_update="UPDATE `tbl_teacher` SET email_status='Send_Email',email_time_log='$date' WHERE t_email='$email' AND school_id='$School_id'";
							
							$retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error());
						}
						else
						{
							$fail++;
							
						}
}
else
{
 $invalide_email++;
}
}
 echo "<script type=text/javascript>alert('$success emails sent successfully , $fail mails fails by sendmail library, $invalide_email fails because of wrong email address'); window.location='Send_Msg_Teacher.php'</script>";	
?>