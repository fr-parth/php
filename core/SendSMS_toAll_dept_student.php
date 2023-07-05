<?php
// echo "hi";
// exit();
error_reporting(0);
include('conn.php');
// include("scadmin_header.php");
//include('conn.php');
require "twilio.php";
// $i=0;
// $fail = 0;
// $success= 0;
// $School_id=$_GET['school_id'];
// $dept=$_GET['t_dept'];
// $Sms_status=$_GET['status'];
// $Country=strtoupper($_GET['country']);

// $query2="select t_email,t_phone,t_password,t_current_school_name,send_unsend_status from `tbl_teacher` where t_dept = '$dept' and school_id='$School_id'";

// Added By Kunal SMC-4755
$group_member_id = $_SESSION['group_admin_id'];
if($_POST['grp_id']!=''){ $group_member_id = $_POST['grp_id']; }
else if ($group_member_id!=''){
	$sqlgp="select group_member_id from tbl_group_school where school_id = '".$_POST['school_id']."' limit 1";
	$row=mysql_query($sqlgp);
	$gp=mysql_fetch_array($row);
	$group_member_id=$gp['group_member_id'];
}
$i=1;
$success=0;
$fail =0;
$flag = "No";
$invalide_email = 0;
$check = $_POST['check'];
$Country=strtoupper($_POST['country']);
 $date=date('Y-m-d H:i:s');
if($_POST['dept_id']==""){$_POST['dept_id']="0";}
        if($_POST['school_id']==""){$_POST['school_id']="0";}
$p_lenght=strlen(trim(($phone)));
$msgid = $_POST['msgid'];
if(empty($msgid) || $msgid=='' )
{
	$msgid = 9;
}
$School_id=$_POST['school_id'];
		if($_POST['startlmt']!="" && $_POST['endlmt']!=""){
            $start=((int)$_POST['startlmt']-1);
            $end=((int)$_POST['endlmt']-((int)$start));
            $Limit= "LIMIT ".$start.",".$end;
        }
        else if($_POST['startlmt']!="" && $_POST['endlmt']==""){
        	$Limit= "LIMIT ".$_POST['startlmt'];
        }
        else{$Limit= "";}

	if($check != "No"){
		if($_POST['t_dept']!="0"){
			// echo '-*1*-';
	        $query2 = "SELECT s.id,sa.school_id, s.std_PRN, s.std_email,s.std_phone,s.std_password,s.std_complete_name,s.std_country,s.send_unsend_status, s.email_status, s.std_dept, s.std_branch, s.batch_id, s.std_class, sa.school_name,sa.scadmin_country FROM tbl_student s LEFT JOIN tbl_school_admin sa ON s.school_id=sa.school_id join tbl_group_school gs on gs.school_id=sa.school_id WHERE  gs.group_member_id='$group_member_id' AND sa.school_id='$School_id' AND  s.std_dept='$dept'  ORDER BY s.id $Limit";
	    }else if($_POST['school_id']!="0"){
	        $query2 = "SELECT s.id, sa.school_id, s.std_PRN, s.std_email,s.std_phone,s.std_password,s.std_complete_name,s.std_country,s.send_unsend_status, s.email_status, s.std_dept, s.std_branch, s.batch_id, s.std_class, sa.school_name,sa.scadmin_country FROM tbl_student s LEFT JOIN tbl_school_admin sa ON s.school_id=sa.school_id join tbl_group_school gs on gs.school_id=sa.school_id WHERE  gs.group_member_id='$group_member_id' AND sa.school_id='$School_id'  ORDER BY s.id $Limit";
	    }else{
	    	$query2 = "SELECT s.id, sa.school_id, s.std_PRN, s.std_email,s.std_phone,s.std_password,s.std_complete_name,s.std_country,s.send_unsend_status, s.email_status, s.std_dept, s.std_branch, s.batch_id, s.std_class, sa.school_name,sa.scadmin_country FROM tbl_student s LEFT JOIN tbl_school_admin sa ON s.school_id=sa.school_id join tbl_group_school gs on gs.school_id=sa.school_id WHERE  gs.group_member_id='$group_member_id'  ORDER BY s.id $Limit";
	    }
	}else{
        if($_POST['t_dept']!="0"){

            $dept = $_POST['t_dept'];
            $query2 = "SELECT s.id, sa.school_id, s.std_PRN, s.std_email,s.std_phone,s.std_password,s.std_complete_name,s.std_country,s.send_unsend_status, s.email_status, s.std_dept, s.std_branch, s.batch_id, s.std_class, sa.school_name,sa.scadmin_country FROM tbl_student s LEFT JOIN tbl_school_admin sa ON s.school_id=sa.school_id join tbl_group_school gs on gs.school_id=sa.school_id WHERE  gs.group_member_id='$group_member_id' AND sa.school_id='$School_id' AND s.std_dept='$dept' AND s.send_unsend_status = 'Unsend'  ORDER BY s.id $Limit";
        }else if($_POST['school_id']!="0"){
        	$query2 = "SELECT s.id, sa.school_id, s.std_PRN, s.std_email,s.std_phone,s.std_password,s.std_complete_name,s.std_country,s.send_unsend_status, s.email_status, s.std_dept, s.std_branch, s.batch_id, s.std_class, sa.school_name,sa.scadmin_country FROM tbl_student s LEFT JOIN tbl_school_admin sa ON s.school_id=sa.school_id join tbl_group_school gs on gs.school_id=sa.school_id WHERE  gs.group_member_id='$group_member_id' AND sa.school_id='$School_id' AND s.send_unsend_status = 'Unsend'  ORDER BY s.id $Limit";
    	}else{
    		$query2 = "SELECT s.id, sa.school_id, s.std_PRN, s.std_email,s.std_phone,s.std_password,s.std_complete_name,s.std_country,s.send_unsend_status, s.email_status, s.std_dept, s.std_branch, s.batch_id, s.std_class, sa.school_name,sa.scadmin_country FROM tbl_student s LEFT JOIN tbl_school_admin sa ON s.school_id=sa.school_id join tbl_group_school gs on gs.school_id=sa.school_id WHERE  gs.group_member_id='$group_member_id' AND s.send_unsend_status = 'Unsend'  ORDER BY s.id $Limit";
    	}
    }
	// echo $query2;
$row2=mysql_query($query2);
$res_sms = mysql_query("select type,subject,email_body,sms_body from tbl_email_sms_templates where id ='$msgid'");
$row_sms= mysql_fetch_array($res_sms);
//assign variables and send email
$sms_response = $row_sms['type'];
// echo $sms_body; exit;
				// function messageUser($cc,$site,$phone,$email,$password,$teachershortside,$School_id)
				// 			{
								
				// 		 $url2="For App Download click here: http://".$site."/Download";
				// 			 $url1=""; //"Please visit ".$teachershortside."";
									
				// 			  $Text1="CONGRATULATIONS!,You are registered as a teacher in Smart Cookie - A Student/Teacher Rewards Program. Your Username is ".$phone." and Password is ".$password." College/School_id is ".$School_id." ".$url2." ".$url1; 
							
				// 		 $Text = urlencode($Text1);
							
							
				// 			$url="http://www.smswave.in/panel/sendsms.php?user=blueplanet&password=123123&sender=PHUSER&PhoneNumber=$phone&Text=$Text";
				// 				$response = file_get_contents($url);
				// 				return $response;
				// 			}
				$s=0;

function messageUser($cc,$site,$phone,$email,$password,$teachershortside,$School_id,$sc_name,$msgid1)
{
	$url=$GLOBALS['URLNAME']."/core/api2/api2.php?x=send_message";
//echo $url;exit;
    $data=array(
      "operation"=>"send_message",
      "country_code"=>"+91",
      "phone_number"=>$phone,
      "password"=>$password,
      "email_id"=>$email,
      "school_id"=>$School_id,
      "school_name"=> $school_name,
      "entity_type"=>"student",
      "reason"=>'$sms_response',
      "delivery_method"=>"SMS",
       "msg"=>$msgid1,
      "api_key"=>"cda11aoip2Ry07CGWmjEqYvPguMZTkBel1V8c3XKIxwA6zQt5s"

      
      );

        $ch = curl_init($url);          
        $data_string = json_encode($data);    
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
        $result = json_decode(curl_exec($ch),true);
		return $result;
	}
while($value2=mysql_fetch_array($row2))
{	
	// print_r($value2); exit;
$password=$value2['std_password'];
$phone=$value2['std_phone'];
$email=$value2['std_email'];
$p_lenght=strlen(trim(($phone)));
$status=$value2['send_unsend_status'];
$school_name=$value2['school_name'];
$s_name=explode(" ",$school_name);
$sc_name=$s_name[0]."".$s_name[1]."".$s_name[2]."".$s_name[3];
$site = $_SERVER['HTTP_HOST'];
$Country=$value2['scadmin_country'];
if($Country==""){ $Country="INDIA"; }
$Country=strtoupper($Country);
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
//$androidlink="https://goo.gl/71F2hc";
//$ioslink="https://goo.gl/cdi711";
	if($Country!='')
	{
		
			if($Country=='INDIA')   // India
			{	
				
					$cc=91;
					if($p_lenght>0 && $p_lenght==10)
						{
							
							$response = messageUser($cc,$site,$phone,$email,$password,$teachershortside,$School_id,$school_name,$msgid);
                            if($response['responseStatus']==200)
							{
							$date=(new \DateTime())->format('Y-m-d H:i:s');
							//echo $site;die;
							$sql_update="UPDATE `tbl_student` SET send_unsend_status='Send_SMS',sms_time_log='$date',sms_response = '$response' WHERE std_phone='$phone' AND school_id='$School_id'";
							$retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error());
							
							$success++;
							
							///echo "<script type=text/javascript>alert('SMS has been sent Successfully on $phone')</script>";
							
							//echo "<script type=text/javascript>'window.location='Send_Msg_Teacher.php'</script>";
							}
							else
							{
								echo "Sorry,Message could not send to- ".$phone;
								$fail++;
							}	
						}
						else
						{
						echo "Sorry,Invalid Phone Number- ".$phone;
						$fail++;
						//window.location='Send_Msg_Teacher.php'</script>";
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
						//$Text="Welcome in Smartcookie as Teacher UserID: $phone and Password: $password android app $androidlink iOS app $ioslink";
						$Text="Your college is now a member of a Student-Teacher Reward platform (SMART COOKIE) that rewards you for your accomplishments as a teacher/mentor. It also enables you to reward your Students for their good deeds in Studies & Extracurricular activities.  UserID: $phone and Password: $password College/School_id is $School_id $url2 ";
						$res = $client->request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages", 
										"POST", array(
										"To" => $number,
										"From" => "732-798-7878",
										"Body" => $Text
									));
								echo "<script type=text/javascript>alert('SMS has been sent Successfully on $number'); window.location='Send_Msg_Teacher.php'</script>";
                        $date=(new \DateTime())->format('Y-m-d H:i:s');
						$sql_update="UPDATE `tbl_student` SET send_unsend_status='Send_SMS',sms_time_log='$date' WHERE std_phone='$phone' AND school_id='$School_id'";
						$retval = mysql_query($sql_update) or die('Could not update data: ' . mysql_error());
			}
			else{
				
			}
	}
		else
		{
			echo "Sorry,Unable to send message without Country name";
		}
}
echo "\n $success SMS sent successfully, $fail failed to sent SMS ";


?>