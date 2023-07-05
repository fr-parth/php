<?php
include '../conn.php';
require "twilio.php";
header('Contenttype: application/json');

$json = file_get_contents('php://input');
$obj = json_decode($json);

$sender_member_id = xss_clean(mysql_real_escape_string($obj->{'sender_member_id'}));
$sender_entity_id = xss_clean(mysql_real_escape_string($obj->{'sender_entity_id'}));
$receiver_entity_id = xss_clean(mysql_real_escape_string($obj->{'receiver_entity_id'}));
$receiver_country_code = xss_clean(mysql_real_escape_string(trim($obj->{'receiver_country_code'},'+')));      
$receiver_mobile_number = xss_clean(mysql_real_escape_string($obj->{'receiver_mobile_number'}));
$receiver_email_id = xss_clean(addslashes($obj->{'receiver_email_id'}));
$firstname = xss_clean(addslashes($obj->{'firstname'}));
$middlename = xss_clean(addslashes($obj->{'middlename'}));
$lastname = xss_clean(addslashes($obj->{'lastname'}));
$platform_source = xss_clean(mysql_real_escape_string($obj->{'platform_source'}));
$request_status = xss_clean(mysql_real_escape_string($obj->{'request_status'}));
// Start SMC-3450 Modify By Pravin 2018-09-22 03:15 PM
//$issue_date = date("d/m/Y");
$email=filter_var($receiver_email_id, FILTER_VALIDATE_EMAIL);
$issue_date = CURRENT_TIMESTAMP;
$point_type='Brown';
		if($receiver_entity_id ==103)
		{
			$table_name = 'tbl_teacher';
			$condition = "(CountryCode = '$receiver_country_code' AND t_phone = '$receiver_mobile_number') or t_email = '$receiver_email_id'";

		}
		else if($receiver_entity_id ==105)
		{
			$table_name = 'tbl_student';
			$condition = "(country_code = '$receiver_country_code' AND std_phone = '$receiver_mobile_number') or std_email = '$receiver_email_id'";

		}
		else 
		{
			$table_name = 'tbl_sponsorer';
			$condition = "(CountryCode = '$receiver_country_code' AND sp_phone = '$receiver_mobile_number') or sp_email = '$receiver_email_id'";

		}
	$server_name = $GLOBALS['URLNAME'];
	//removed mandatory middle name from below if condition by Pranali for SMC-5138 
if((($receiver_country_code!='' && $receiver_mobile_number!='') || $receiver_email_id!='') && $sender_member_id!='' && $sender_entity_id !='' && $receiver_entity_id!='' && $firstname!=''  && $lastname!='' && $platform_source!='' && $request_status!='')
{
	$referral_id = rand(1, 9999999);

	$sender_type = $sender_entity_id == 103 ?  'teacher' : ( $sender_entity_id == 105 ? 'student' : 'sponsor');
	$receiver_type = $receiver_entity_id == 103 ?  'teacher' : ( $receiver_entity_id == 105 ? 'student' : 'sponsor');

	$check_request_query = mysql_query("select referral_tracking_id from referral_activity_log where ((receiver_country_code ='$receiver_country_code' AND receiver_mobile_number='$receiver_mobile_number') or receiver_email_id='$receiver_email_id') AND receiver_user_type='$receiver_type'");
	$count = mysql_num_rows($check_request_query);

	$check_request_query1 = mysql_query("select id from $table_name where $condition");
	$count1 = mysql_num_rows($check_request_query1);
	
	$acceptance_flag = 'N';
	//$invitation_sent_datestamp = date("Ymd h:i:s");//SMC-3450
	$invitation_sent_datestamp = CURRENT_TIMESTAMP;//SMC-3450
	//End SMC-3450
	$password = $firstname.'123';
	//changes done by Pranali for SMC-3477 and SAND-1661 to display full name in message
	if($sender_entity_id == 103)
	{
		$sender_table = "tbl_teacher";
		$select	= "t_complete_name,t_name,t_middlename,t_lastname,t_id,school_id";
		$tbl_point = "tbl_teacher_point";

		$point_insert_column = "sc_teacher_id,sc_entities_id,assigner_id,reason,sc_point,point_date,school_id,referral_id,point_type";

		$tbl_reward = "tbl_teacher";
		$user_id = "t_id";
	
	}
	else if($sender_entity_id == 105)
	{
		$sender_table = "tbl_student";
		$select	="std_complete_name,std_name,std_Father_name,std_lastname,std_PRN,school_id";
		$tbl_reward = "tbl_student_reward";
		$tbl_point = "tbl_student_point";

		$point_insert_column = "sc_stud_id, sc_entites_id, sc_teacher_id, reason,sc_point, point_date,school_id,referral_id,type_points";

		$user_id = "sc_stud_id";
		
	}
	else
	{
		$sender_table = "tbl_sponsorer";
		$select	= "sp_name";
		
	}
 
	$invitation_sender_name_sql = mysql_query("select $select from $sender_table where id='$sender_member_id'");
	while($row1 = mysql_fetch_array($invitation_sender_name_sql))
	{
		
		$complete_name1 = $row1[0];
		//$invitation_sender_name1 = explode(' ',$complete_name1);
		//$invitation_sender_name = $invitation_sender_name1[0];
		 $invitation_sender_name = $complete_name1; 
		 $fn = $row1[1];
		 $mn = $row1[2];
		 $ln = $row1[3];
		 
		if(empty($invitation_sender_name))
		{
			$invitation_sender_name =  $fn." ".$mn." ".$ln;
		}
	
	 $id_prn = $row1[4];
	 $school_id = $row1[5];
	}

	$points_query = mysql_query("select points from rule_engine_for_referral_activity where from_user='$sender_type' and to_user='$receiver_type' and  referal_reason='$request_status'");
	$points_query_result = mysql_fetch_assoc($points_query);
	$points = (integer)$points_query_result['points'];


	$viral_link1 = $server_name."/core/Version3/accept_request_to_join_smartcookie.php?id=".base64_encode($sender_member_id)."&senderentity=".base64_encode($sender_entity_id)."&receiverentity=".base64_encode($receiver_entity_id)."&referral_id=".base64_encode($referral_id);


	if($count == 0 && $count1 == 0)
	{
			
			$referral_activity_log_query = mysql_query("insert into referral_activity_log (sender_member_id,sender_user_type,receiver_country_code,receiver_mobile_number,receiver_email_id,invitation_sent_datestamp,acceptance_flag,method,receiver_user_type,firstname,middlename,lastname,referral_id,point) values ('$sender_member_id','$sender_type','$receiver_country_code','$receiver_mobile_number','$receiver_email_id','$invitation_sent_datestamp','$acceptance_flag','$platform_source','$receiver_type','$firstname','$middlename','$lastname','$referral_id',$points)");
	
			if($referral_activity_log_query)
			{
				/*Below query added by Sayali Balkawade for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
						$sql_dynamic= mysql_query("select * from tbl_otp where id=1");
						$dynamic_fetch= mysql_fetch_array($sql_dynamic);
						$dynamic_user = $dynamic_fetch['mobileno'];
						$dynamic_pass = $dynamic_fetch['email'];
						$dynamic_sender = $dynamic_fetch['otp']; 
						
				$Text=urlencode("You are requested by ".$invitation_sender_name." to join Smartcookie. Click on following link to join smartcookie ".$viral_link1." sent by ".$platform_source);  
				//changes end for SMC-3477 & SAND-1661
				//Added SEND_SMS_PATH and &msgType=$msgType&Pe_id=$pe_id&template_id=$template_id by Pranali for SMC-5166 
				//echo SEND_MAIL_PATH;
				
				 $url=SEND_SMS_PATH."?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$receiver_mobile_number&Text=$Text&msgType=$msgType&pe_id=$pe_id&template_id=$template_id";

				//Added SEND_SMS_PATH and &msgType=$msgType&Pe_id=$pe_id&template_id=$template_id by Pranali for SMC-5166 
				//$url=SEND_SMS_PATH."?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$receiver_mobile_number&Text=$Text&msgType=$msgType&Pe_id=$pe_id&template_id=$template_id";
				
				file_get_contents($url);
				
				$res1 = mysql_query("select id,type,email_body from tbl_email_sms_templates where id='4'");
				$e_body1=mysql_fetch_array($res1);
				$e_body=$e_body1['email_body'];
				 $msgid=$e_body1['id'];

				//$msgid='promoting_smartcookie';
				//SMC-4716 & SMC-4722 by Pranali on 3-10-21: Added urlencode for $invitation_sender_name and $viral_link1 for solving issue of accept request to join smartcookie url was breaking in email and SMS
				$invitation_sender_name = urlencode($invitation_sender_name);
				$viral_link1 = urlencode($viral_link1);
				
				//echo $res = file_get_contents($GLOBALS['URLNAME']."/core/clickmail/sendmail_new.php?&email=$receiver_email_id&msgid=$msgid&invitation_sender_name=$invitation_sender_name&viral_link=$viral_link1&platform_source=$platform_source&site=$server_name");
				//echo  $myvars = 'email='.$receiver_email_id.'&msgid='.$msgid1.'&Name='.$invitation_sender_name.'&senderid='.$email.'&pass='.$dynamic_pass.'&site='.$site.'&sender_entity_id='.$sender_entity_id.'&receiver_mobile_number='.$receiver_mobile_number;
 				   $url1 = SEND_MAIL_PATH;
						 $myvars = 'email='.$receiver_email_id.'&msgid='.$msgid.'&invitation_sender_name='.$invitation_sender_name.'&viral_link='.$viral_link1.'&platform_source='.$platform_source.'&site='.$server_name.'';
				 //function defined in securityfunctions.php

						$res = post_function($url1,$myvars);

				if(stripos($res,"Mail sent successfully"))
				{
					$result_mail = 'mail sent successfully';
				}
				if($receiver_country_code != '91' && $receiver_country_code != '+91')
				{
					$ApiVersion = "20100401";
					// set our AccountSid and AuthToken
					$AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
					$AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";
					// instantiate a new Twilio Rest Client
					$client = new TwilioRestClient($AccountSid, $AuthToken);
					$number="+1".$phone;
					$message="You are requested by ".$invitation_sender_name." to join Smartcookie,student Teacher Reward program.click following link to join ".$viral_link1."sent through ".$platform_source.".";
					$response = $client>request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages",
					"POST", array(
					"To" => $number,
					"From" => "7327987878",
					"Body" => $message
					));
				}

//$Brown added in insert query by Pranali for SMC-3713
				$Brown='Brown';
				
				$point_insert_query = mysql_query("INSERT INTO $tbl_point ($point_insert_column) VALUES ('$id_prn','$sender_entity_id','','$request_status','$points','$issue_date','$school_id','$referral_id','$Brown')");


				$update_brown_points = mysql_query("update $tbl_reward set brown_point = if(brown_point IS NULL, $points,brown_point+$points) where school_id = '$school_id' AND $user_id = '$id_prn'");
				$affected_rows = mysql_affected_rows();

				if($affected_rows == 0 && $sender_entity_id ==105)
				{
					$tbl_student_reward_update_query=mysql_query("insert into tbl_student_reward (sc_stud_id,sc_date,brown_point,school_id) values ('$id_prn','$issue_date','$points','$school_id')");
				}

				$postvalue['responseStatus']  = 200;
				$postvalue['responseMessage'] = "ok";
				$postvalue['posts'] = "Request submitted successfully";
				encode_values($postvalue);
			}
	}
	else if($count1 > 0)
	{
			$postvalue['responseStatus'] = 409;
			$postvalue['responseMessage'] = "User Already Exists";
			$postvalue['posts'] = null;
			encode_values($postvalue);
	}
	else if($count > 0)
	{
			$postvalue['responseStatus'] = 208;
			$postvalue['responseMessage'] = "User is Already Requested";
			$postvalue['posts'] = null;	
			encode_values($postvalue);
	}
	else
	{
			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="No Response";
			$postvalue['posts']=null;
			encode_values($postvalue);
	}
	
}
else
{
	$postvalue['responseStatus'] = 1000;
	$postvalue['responseMessage'] = "Invalid Input";
	$postvalue['posts'] = null;
	encode_values($postvalue);
}


function encode_values($postvalue)
{
	echo json_encode($postvalue);
}
