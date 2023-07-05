<?php
error_reporting(0);
include('conn.php');
require "twilio.php";
$i=1;
$success = 0;
$invalide_phone = 0;
$missing_country_code = 0;
$batch_id=$_GET['batch_id'];

$School_id=$_GET['school_id'];
$Sms_status=$_GET['status'];


$msgid = $_GET['msgid'];
$pass = $_GET['pass'];
$site = $_GET['site'];
$query2="select t_email,t_country,t_phone,t_password,t_current_school_name,send_unsend_status from `tbl_teacher` where batch_id ='$batch_id' and school_id='$School_id' order by id desc";

//echo "select t_phone,t_password,t_current_school_name,send_unsend_status from `tbl_teacher` where batch_id ='$batch_id' and school_id='$School_id' order by id desc";die;
function messageUser($cc,$phone,$email,$password,$teachershortside,$site,$School_id)
							{
							 $url2="For App Download click here: http://".$site."/Download";
							 $url1=""; //"Please visit ".$teachershortside."";

			$Text1="CONGRATULATIONS!,You are registered as a teacher in Smart Cookie - A Student/Teacher Rewards Program.Your Username is ".$phone." and Password is ".$password." College/School_id is ".$School_id." ".$url2; 
							$Text = urlencode($Text1);
							/*Below query added by Rutuja for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
                        	$sql_dynamic= mysql_query("select * from tbl_otp where id=1");
                        	$dynamic_fetch= mysql_fetch_array($sql_dynamic);
                        	$dynamic_user = $dynamic_fetch['mobileno'];
                        	$dynamic_pass = $dynamic_fetch['email'];
                        	$dynamic_sender = $dynamic_fetch['otp'];

							$url="http://www.smswave.in/panel/sendsms.php?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$phone&Text=$Text";
								$response =  file_get_contents($url);
								return $response;
							//echo "<script>	alert($a)</script>";
							}
$row2=mysql_query($query2);
while($value2=mysql_fetch_array($row2))
{
//echo "hwdi";die;
	
$phone=$value2['t_phone'];
//echo $phone;die;
$p_lenght=strlen(trim(($phone)));
$Country=strtoupper($value2['t_country']);
$email = $_GET['t_email'];
//echo "<script>alert('$phone');</script>";
$password=$value2['t_password'];
$status=$value2['send_unsend_status'];
$school_name=$value2['t_current_school_name'];
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
$url2="For App Download click here: http://".$site."/Download";
	if($Country!='')
	{
		
			if($Country=='INDIA')   // India
			{	
			
					$cc=91;
					if($p_lenght>0 && $p_lenght==10)
						{
						
							//echo "<script>	alert('3')</script>";
							
							$response = messageUser($cc,$phone,$email,$password,$teachershortside,$site,$School_id);
                            $date=date('Y-m-d H:i:s');
							$sql_update="UPDATE `tbl_teacher` SET send_unsend_status='SMS sent',sms_response = '$response',sms_time_log='$date' WHERE t_phone='$phone' AND school_id='$School_id'";
						$retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error());
							//echo "hszddi";die;
							 $success++;

						}
						else
						{
							$invalide_phone++;
						}
			}
			elseif($Country=='US' || $Country=='USA')                // for USA
			{
						$ApiVersion = "2010-04-01";
								// set our AccountSid and AuthToken
						$AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
						$AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";
								// instantiate a new Twilio Rest Client
						$client = new TwilioRestClient($AccountSid, $AuthToken);
						$number="+1".$phone;
						$Text="Welcome in Smartcookie as Teacher UserID: $phone and Password: $password College/School_id is $School_id $url2";
						$res = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
										"POST", array(
										"To" => $number,
										"From" => "732-798-7878",
										"Body" => $Text
									));
								$success++;
                        $date=date('Y-m-d H:i:s');
						$sql_update="UPDATE `tbl_teacher` SET send_unsend_status='SMS sent',sms_time_log='$date' WHERE t_phone='$phone' AND school_id='$School_id'";
						$retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error());
			}
	}
	
		else
		{
				$missing_country_code++;
		}   
}		
echo "<script type=text/javascript>alert('$success massages sent successfully $missing_country_code records failed because of missing country code $invalide_phone records failed because of invalide phone number'); window.location='Send_Msg_Teacher.php'</script>";
?>