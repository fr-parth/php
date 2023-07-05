<?php
error_reporting(0);
include ('conn.php');


if(isset($_POST['sub']))
{
$i=1;
	$success = 0;
	$invalide_phone = 0;
	$missing_country_code = 0;

	$School_id=$_SESSION['school_id'];

	$start = $_POST['start'];
	$end = $_POST['end'];
$query2 = "select std_country,std_phone,std_password,std_email,std_school_name from `tbl_student` where school_id='$School_id' limit $start,$end";
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
echo "$success massages sent successfully $missing_country_code records failed because of missing country code $invalide_phone records failed because of invalide phone number";
//echo "<script type=text/javascript>alert(' $success mails sent successfully $fail mails failed'); window.location='Send_Msg_Student.php'</script>";

}
?>


<html>
<body>
<form method='POST'>
	Start <input type='number' name='start' required>
	End <input type='number' name='end' required>
	<input type='submit' name='sub'>
	
</form>
</body>
</html>