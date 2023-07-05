<html>
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <style>
    .textstyle{
      color:red;
      margin-top:400px;
    }
  </style>
  <script>
  $(document).ready(function(){
    $('h1').fadeIn(2000);
    var server =window.location.hostname;
    $("#div").text('loading...').delay(10000).queue(function() {
             $(this).hide();
             //window.location.assign("http://"+server);
             $(this).dequeue();
         });
  });
  </script>
</head>
<body>	
</body>
</html>
<?php

include 'conn.php';

$sender_member_id = base64_decode($_REQUEST['id']);
$sender_entity_id = base64_decode($_REQUEST['senderentity']);
$receiver_entity_id = base64_decode($_REQUEST['receiverentity']);
$referral_id = base64_decode($_REQUEST['referral_id']);
// Start SMC-3450 Modify By Pravin 2018-09-22 04:48 PM
//$server_name = base64_decode($_SERVER['SERVER_NAME']);
//$issue_date = date("d/m/Y");

$server_name = base64_decode($GLOBALS['URLNAME']);
$issue_date = CURRENT_TIMESTAMP;
if ($sender_member_id =='' || $sender_entity_id =='' || $receiver_entity_id == '' || $referral_id == '')
{
	echo '<center><div><h1 class="textstyle" style="display:none">Invalid Inputs</h1><hr style="border : 1px solid red;width:300px"/><div id="div"></div></div></center>';
	exit;
}
else{	

	$select_new_user=mysql_query("select receiver_country_code,receiver_mobile_number,receiver_email_id,firstname,middlename,lastname,CONCAT(firstname,' ',middlename,' ' ,lastname) as completename, CONCAT(firstname,'123') as password , acceptance_flag from referral_activity_log where  referral_id='$referral_id' ");

	$result_new_user=mysql_fetch_array($select_new_user);
	
	 $count=mysql_num_rows($select_new_user); 

if($count == '0')
{
	
	echo '<center><div><h1 class="textstyle" style="display:none">Invalid Referral Id</h1><hr style="border : 1px solid red;width:300px"/><div id="div"></div></div></center>';
	exit;
}
else if($result_new_user['acceptance_flag']=='Y')
{
	echo '<center><div><h1 class="textstyle" style="display:none">Request Already Accepted</h1><hr style="border : 1px solid red;width:300px"/><div id="div"></div></div></center>';
	exit;
}
else
{ 
		
		$user_country_code=$result_new_user['receiver_country_code'];
		$user_mobile_number=$result_new_user['receiver_mobile_number'];
		$user_email_id=$result_new_user['receiver_email_id'];
		$user_name=$result_new_user['firstname'];
		$user_middle_name=$result_new_user['middlename'];
		$user_last_name=$result_new_user['lastname'];
		$user_complete_name=$result_new_user['completename'];
		$user_password=$result_new_user['password'];
		
		
		if($receiver_entity_id ==103)
		{
			$table_name = 'tbl_teacher';
			$select	= "t_complete_name,t_name,t_id,school_id";
			$insert_table='tbl_teacher_point';
			$condition = "t_phone = '$user_mobile_number' or t_email = '$user_email_id'";
			$insert_colum_name = "CountryCode, t_phone, t_email, t_complete_name, t_password,t_date, t_name, t_middlename, t_lastname, school_id, t_emp_type_pid,t_current_school_name";
			$value="'$user_name','$user_middle_name','$user_last_name','OPEN','134','Open Universe'";
			$update_column="t_id";
			$tbl_reward = "tbl_teacher";
			$tbl_point="tbl_teacher_point";
			$point_insert_column = "sc_teacher_id,sc_entities_id,assigner_id,reason,sc_point,point_date,school_id,point_type,referral_id";
			$user_id = "t_id";
			$point_type='Brown';
		

		}
		else if($receiver_entity_id ==105)
		{
			$table_name = 'tbl_student';
			$select	= "std_complete_name,std_name,std_PRN,school_id";
			$insert_table='tbl_student_point';
			$condition = "std_phone = '$user_mobile_number' or std_email = '$user_email_id'";
			$insert_colum_name ="country_code, std_phone, std_email, std_complete_name,std_password,std_date, std_name, std_Father_name, std_lastname,  school_id ,std_school_name";
			$value="'$user_name','$user_middle_name','$user_last_name','OPEN','Open Universe'";
			$update_column="std_PRN";
			$tbl_reward = "tbl_student_reward";
			$tbl_point="tbl_student_point";
			$point_insert_column = "sc_stud_id, sc_entites_id, sc_teacher_id, reason,sc_point, point_date,school_id,type_points,referral_id";
			$user_id = "sc_stud_id";
			$point_type='Brown';
		}
		else 
		{
			$table_name = 'tbl_sponsorer';
			$condition = "sp_phone = '$user_mobile_number' or sp_email = '$user_email_id'";
			$insert_colum_name="CountryCode, sp_phone,sp_email, sp_name, sp_password,sp_date,v_status,v_responce_status";
			$value="'Inactive','Suggested'";
			
			
		}
		
		
		
$request_status = 'request_accepted';

$sender = $sender_entity_id == 103 ?  'teacher' : ( $sender_entity_id == 105 ? 'student' : 'sponsor');

$receiver = $receiver_entity_id == 103 ?  'teacher' : ( $sender_entity_id == 105 ? 'student' : 'sponsor');


$points_query = mysql_query("select points from rule_engine_for_referral_activity where from_user='$sender' and to_user='$receiver' and  referal_reason='$request_status'");
$points_query_result = mysql_fetch_assoc($points_query);
$points = (integer)$points_query_result['points'];



		$userisexist = mysql_query("select id from $table_name where $condition");
		$count_of_user_exist = mysql_num_rows($userisexist);
		
		if($count_of_user_exist > 0 )
		{
			echo '<center><div><h1 class="textstyle" style="display:none">User Already Registered</h1><hr style="border : 1px solid red;width:300px"/><div id="div"></div></div></center>';
			exit;
		}
		
		
		$insert=mysql_query("INSERT INTO $table_name ($insert_colum_name) VALUES ('$user_country_code','$user_mobile_number','$user_email_id','$user_complete_name','$user_password' ,'$issue_date',$value)");
		$id=mysql_insert_id();
		
		if($insert)
		{
			
			$update_PRN_or_Teacher_Id=mysql_query("update $table_name set $update_column = $id where id =$id");
			
			$update_flag=mysql_query("update referral_activity_log set acceptance_flag = 'Y', accepted_datestamp = '$issue_date', receiver_member_id='$id' where referral_id='$referral_id'");
			
			
					$select_user_for_assign_point = mysql_query("select $select
					from $table_name where id='$id'");
		
				while($row1 = mysql_fetch_array($select_user_for_assign_point))
				{
		
					$complete_name1 = $row1[0];
					$receiver_name = explode(' ',$complete_name1);
					$receiver_name = $receiver_name[0];
					$first_name = $row1[1];
					$id_prn = $row1[2];
					$school_id = $row1[3];
		
					if($sender_name == "")
					{
						$receiver_name = $first_name;
					}
				}
			
			
			
			$point_insert_query = mysql_query("INSERT INTO $tbl_point ($point_insert_column) VALUES ('$id_prn','$receiver_entity_id','','$request_status','$points','$issue_date','$school_id','$point_type','$referral_id')");

				$update_brown_points = mysql_query("update $tbl_reward set brown_point = if(brown_point IS NULL, $points,brown_point+$points) where school_id = '$school_id' AND $user_id = '$id_prn'");
				$affected_rows = mysql_affected_rows();

				if($affected_rows == 0 && $sender_entity_id ==105)
				{
					$tbl_student_reward_update_query=mysql_query("insert into tbl_student_reward (sc_stud_id,sc_date,brown_point,school_id) values ('$id_prn','$issue_date','$points','$school_id')");
				}

				
			if($sender_entity_id == 103)
			{
		
				$sender_table = "tbl_teacher";
				$select	= "t_complete_name,t_name,t_id,school_id";
				$tbl_point = "tbl_teacher_point";
				$point_insert_column = "sc_teacher_id,sc_entities_id,assigner_id,reason,sc_point,point_date,school_id,referral_id";
				$tbl_reward = "tbl_teacher";
				$user_id = "t_id";
				$point_type='Brown';
			
			}
			else if($sender_entity_id ==105)
			{
		
				$sender_table = "tbl_student";
				$select	= "std_complete_name,std_name,std_PRN,school_id";
				$tbl_reward = "tbl_student_reward";
				$tbl_point = "tbl_student_point";
				$point_insert_column = "sc_stud_id, sc_entites_id, sc_teacher_id, reason,sc_point, point_date,school_id,referral_id";
				$user_id = "sc_stud_id";
				$point_type='Brown';
			}
			else
			{
				$sender_table = "tbl_sponsorer";
				$select	= "sp_name";
				
			}
			
			$point_insert_query = mysql_query("INSERT INTO $tbl_point ($point_insert_column) VALUES ('$id_prn','$sender_entity_id','','$request_status','$points','$issue_date','$school_id','$point_type','$referral_id')");

				$update_brown_points = mysql_query("update $tbl_reward set brown_point = if(brown_point IS NULL, $points,brown_point+$points) where school_id = '$school_id' AND $user_id = '$id_prn'");
				
				
				
				
			
				$Text1="Congratulations! You've been successfully registered with Smartcookie. Use following credentials to login. Your Username is: $user_email_id and Your School Id is: $school_id and Your Password is: $user_password";
				$Text=urlencode($Text1);
				/*Below query added by Rutuja for fetching dynamic values for user,password & sender for SMC-4989 on 02-12-2020*/
                            $sql_dynamic= mysql_query("select * from tbl_otp where id=1");
                            $dynamic_fetch= mysql_fetch_array($sql_dynamic);
                            $dynamic_user = $dynamic_fetch['mobileno'];
                            $dynamic_pass = $dynamic_fetch['email'];
                            $dynamic_sender = $dynamic_fetch['otp'];
                            
				$url="http://www.smswave.in/panel/sendsms.php?user=$dynamic_user&password=$dynamic_pass&sender=$dynamic_sender&PhoneNumber=$user_mobile_number&Text=$Text";
				file_get_contents($url);

				$msgid='smartcookie_join_request_accept';
				$res = file_get_contents("$server_name/core/clickmail/sendmail.php?email=$user_email_id&msgid=$msgid&site=$server_name&pass=$user_password&school_id=$school_id");//SMC-3450

				//End SMC-3450
				
				if(stripos($res,"Mail sent successfully"))
				{
					$result_mail = 'mail sent successfully';
				}
				if($receiver_country_code != '+91')
				{
					$ApiVersion = "20100401";
					// set our AccountSid and AuthToken
					$AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
					$AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";
					// instantiate a new Twilio Rest Client
					$client = new TwilioRestClient($AccountSid, $AuthToken);
					$number="+1".$phone;
					$message="Congratulations! You've been successfully registered with Smartcookie. Use following credentials to login. Your Username is: $user_email_id and Your School Id is: $school_id and Your Password is: $user_password";
					$response = $client>request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages",
					"POST", array(
					"To" => $number,
					"From" => "7327987878",
					"Body" => $message
					));
				}	
				
				
			
			
			
			echo '<center><div><h1 class="textstyle" style="display:none">success</h1><hr style="border : 1px solid red;width:300px"/><div id="div"></div></div></center>';
			
			
		}
		else{
			echo '<center><div><h1 class="textstyle" style="display:none">No Response </h1><hr style="border : 1px solid red;width:300px"/><div id="div"></div></div></center>';
			exit;
			
		}
		
		
		
		
		

}

}



	
	
?>
