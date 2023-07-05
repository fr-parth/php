
<?php
error_reporting(0);
include('conn.php');
require "twilio.php";

if(isset($_POST['sub']))
{
	
	
	$i=1;
	$success = 0;
	$invalide_phone = 0;
	$missing_country_code = 0;

	$School_id=$_SESSION['school_id'];

	$start = $_POST['start'];
	$end = $_POST['end'];

	$query2 = "select std_country,std_phone,std_password,std_email,std_school_name from `tbl_student` where school_id='SVCP' limit $start,$end";
	//die;
	//echo "select t_phone,t_password,t_current_school_name,send_unsend_status from `tbl_teacher` where batch_id ='$batch_id' and school_id='$School_id' order by id desc";die;

function messageUser($cc,$phone,$email,$password,$teachershortside,$site)
								{
									 $url2="For App Download click here: http://".$site."/Download";
									 $url1=""; //"Please visit ".$teachershortside."";

									$Text1="CONGRATULATIONS!,You are registered as a Student in Smart Cookie - A Student/Teacher Rewards Program.Your Username is ".$phone." and Password is ".$password.". ".$url2;
									$Text = urlencode($Text1);
									//$url="http://www.smswave.in/panel/sendsms.php?user=blueplanet&password=123123&sender=PHUSER&PhoneNumber=$phone&Text=$Text";
										$a = file_get_contents($url);
									//echo "<script>	alert($a)</script>";
									//echo "<script>	alert('3')</script>";
								}

	$row2=mysql_query($query2);
	while($value2=mysql_fetch_array($row2))
	{
		
	$phone=$value2['std_phone'];
	$p_lenght=strlen(trim(($phone)));
	$Country=$value2['std_country'];
	$password=$value2['std_password'];
	$school_name=$value2['std_school_name'];
	$s_name=explode(" ",$school_name);
	$sc_name=$s_name[0]."".$s_name[1]."".$s_name[2]."".$s_name[3];
	$site = $_SERVER['HTTP_HOST'];
	if ($site=='dev.smartcookie.in')
						{
							$teachershortside="https://goo.gl/MWbV2E";
						}
				else if($site=='test.smartcookie.in')
						{
							$teachershortside="https://goo.gl/CaEhf8";
						}
				else 
						{
							$teachershortside="https://goo.gl/HdVtLL";
						}

		if($Country!='')
		{
			//echo "<script>	alert('1')</script>";
			
			
				if($Country=='India' || $Country=='india' || $Country=='IN' || $Country=='INDIA')   // India
				{	
				//echo "<script>	alert('2')</script>";
						$cc=91;
						if($p_lenght>0 && $p_lenght==10)
							{
								

									//messageUser($cc,$phone,$email,$password,$teachershortside,$site);
									 $date=(new \DateTime())->format('Y-m-d H:i:s');
									
									$sql_update="UPDATE `tbl_student` SET send_unsend_status='Send_SMS',sms_time_log='$date' WHERE std_phone='$phone' AND school_id='$School_id'";
									$retval = mysql_query($sql_update);
								
									$success++;

								//echo "<script>	alert($success)</script>";

							}
							else
							{
								$invalide_phone++;
								//echo "<script>	alert($invalide_phone)</script>";

							}
				}
				
		}
			else
			{
					$missing_country_code++;
					//echo "<script>	alert($missing_country_code)</script>";
			}   
	}
	echo "$success massages sent successfully. $missing_country_code records failed because of missing country code. $invalide_phone records failed because of invalide phone number on the date of $date";
	//echo "<script type=text/javascript>alert('$success massages sent successfully $missing_country_code records failed because of missing country code $invalide_phone records failed because of invalide phone number');</script>";
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

