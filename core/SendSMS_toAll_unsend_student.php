<?php
error_reporting(0);
include('conn.php');
require "twilio.php";
$i=0;
$fail = 0;
$success= 0;
$alrady_sent=0;
//$phone=$_GET['phone'];
//$p_lenght=strlen(trim(($phone)));
$School_id=$_GET['school_id'];
//$Sms_status=$_GET['status'];
//$Country=strtoupper($_GET['country']);
$query2="select std_email,std_phone,std_password,std_school_name,std_country,send_unsend_status from `tbl_student` where school_id='$School_id'";  //query for getting last batch_id what else if are inserting first time data
$row2=mysql_query($query2);

function messageUser($cc,$phone,$email,$password,$teachershortside,$site,$School_id)
							{
						
							//$url2=" Android app ".$androidlink." ios app ".$ioslink."";
							$url2="For App Download click here: http://".$site."/Download";
							//$url1=" Please visit ".$teachershortside."";

				$Text1="CONGRATULATIONS!, You are registered as a student in Smart Cookie - A Student/Teacher Rewards Program. Your Username is ".$phone." and Password is ".$password." College/School_id is ".$School_id." ".$url2." ".$url1; 
							$Text = urlencode($Text1);
							
							/*Below query added by Rutuja for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
                        	$sql_dynamic= mysql_query("select * from tbl_otp where id=1");
                        	$dynamic_fetch= mysql_fetch_array($sql_dynamic);
                        	$dynamic_user = $dynamic_fetch['mobileno'];
                        	$dynamic_pass = $dynamic_fetch['email'];
                        	$dynamic_sender = $dynamic_fetch['otp'];
                        	
							$url="http://www.smswave.in/panel/sendsms.php?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$phone&Text=$Text";
								$response = file_get_contents($url);
								return $response;
							}

while($value2=mysql_fetch_array($row2))
{
$password=$value2['std_password'];
$phone=$value2['std_phone'];
$p_lenght=strlen(trim(($phone)));
$Country=$value2['std_country'];
$Country=strtoupper($Country);
$status=$value2['send_unsend_status'];
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
//$androidlink="https://goo.gl/r4YMt4";
//$ioslink="https://goo.gl/HNqrPR";

if($status=="Unsend")
{
if($Country!='')
	{
			if($Country=='INDIA')   // India
			{	
					$cc=91;
					if($p_lenght>0 && $p_lenght==10)
						{
							if(preg_match("/^[7-9][0-9]{9}$/", $phone))
							{
							$response = messageUser($cc,$phone,$email,$password,$teachershortside,$site,$School_id);
                            $date=(new \DateTime())->format('Y-m-d H:i:s');
							$sql_update="UPDATE `tbl_student` SET send_unsend_status='Send_SMS',sms_time_log='$date',sms_response = '$response' WHERE std_phone='$phone' AND school_id='$School_id'";
						    $retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error());

							$success++;
							//echo "<script type=text/javascript>alert('SMS has been sent Successfully on $phone'); window.location='Send_Msg_Student.php'</script>";
							}
							else{
								$invalid_number++;
							}
						
						}
						else
						{
						$fail++;	
						//echo "<script type=text/javascript>alert('Sorry,Invalid Phone No.'); window.location='Send_Msg_Student.php'</script>";
						}
			}
			else if($Country=='US' || $Country=='USA')                // for USA
			{		
				
						$ApiVersion = "2010-04-01";

								// set our AccountSid and AuthToken
						$AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
						$AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";
    
								// instantiate a new Twilio Rest Client
						$client = new TwilioRestClient($AccountSid, $AuthToken);
						$number="+1".$phone;
						$Text="Your college is now a member of a Student Teacher Reward platform that rewards you for  your accomplishments as a student and also enables you to thank your Teachers for all the motivation, mentoring etc. UserID: $phone and Password: $password College/School_id is $School_id $url2 "; 
								
				
						$res = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
										"POST", array(
										"To" => $number,
										"From" => "732-798-7878",
										"Body" => $Text
									));

								echo "<script type=text/javascript>alert('SMS has been sent Successfully on $number');window.location='Send_Msg_Student.php'</script>";
							
							
						$sql_update="UPDATE `tbl_student` SET send_unsend_status='Send_SMS' WHERE std_phone='$phone' AND school_id='$School_id'";
						$retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error());


			}
			else
			{
				$fail++;
				//echo "<script type=text/javascript>alert('Sorry, Something is wrong in Country Name'); window.location='Send_Msg_Student.php'</script>";
				
			}
			
		}
		else
		{
			$fail++;
			//echo "<script type=text/javascript>alert('Sorry,Unable to send message without Country name'); //window.location='Send_Msg_Student.php'</script>";
		}
}
		else
		{
			$alrady_sent++;
			//echo "<script type=text/javascript>alert('You have already sent SMS on $phone. Thank You....! '); window.location='Send_Msg_Student.php'</script>";	
		}

}
echo "<script type=text/javascript>alert('$success SMS sent successfully , $alrady_sent mail already sent, $invalid_number is invalid number,$fail SMS fails by sendmail library'); window.location='Send_Msg_Student.php'</script>";
?>