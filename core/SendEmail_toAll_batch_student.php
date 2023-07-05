<?php
error_reporting(0);
include ('conn.php');

$i = 0;
$success = 0;
$fail = 0;
$batch_id = $_GET['batch_id'];

// $p_lenght=strlen(trim(($phone)));

$School_id = $_GET['school_id'];
$School_id = $_GET['school_id'];
$query2 = "select std_PRN,std_name,std_email,std_phone,std_password,std_school_name,email_status from `tbl_student` where batch_id='$batch_id' and school_id='$School_id'"; //query for getting last batch_id what else if are inserting first time data
$row2 = mysql_query($query2);

while ($value2 = mysql_fetch_array($row2))
	{
	$email = $value2['std_email'];
	$password = $value2['std_password'];
	$school_name = $value2['std_school_name'];
	$s_name = explode(" ", $school_name);
	$sc_name = $s_name[0] . "" . $s_name[1] . "" . $s_name[2] . "" . $s_name[3];
	$site = $_SERVER['HTTP_HOST'];
	$msgid = 'welcomestudentfromscadmin';
	$res = file_get_contents("http://$site/core/clickmail/sendmail.php?email=$email&msgid=$msgid&site=$site&pass=$password&school_name=" . urlencode($school_name) . "");
	if (stripos($res, "Mail sent successfully"))
		{
		$success++;
		$date = (new DateTime())->format('Y-m-d H:i:s');
		$sql_update = "UPDATE `tbl_student` SET email_status='Send_Email',email_time_log='$date' WHERE std_email='$email' AND school_id='$School_id'";
		$retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error());
		}
	  else
		{
		$fail++;
		}
	}

echo "<script type=text/javascript>alert(' $success mails sent successfully $fail mails failed'); window.location='Send_Msg_Student.php'</script>";
?>