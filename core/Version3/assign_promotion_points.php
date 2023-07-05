<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);
include('conn.php');

$request_status = $obj->{'request_status'};
$sender_entity_id = $obj->{'sender_entity_id'};
$receiver_entity_id = $obj->{'receiver_entity_id'};
$sender_member_id = $obj->{'sender_member_id'};
$receiver_member_id = $obj->{'receiver_member_id'};
$receiver_employee_id = $obj->{'receiver_employee_id'};
$issue_date = date("d/m/Y");


if($request_status!='' && $sender_entity_id!='' && $receiver_entity_id!='' && $sender_member_id!='' && $receiver_member_id!='')
{
	$sender = $sender_entity_id == 103 ?  'teacher' : ( $sender_entity_id == 105 ? 'student' : 'sponsor');

	$receiver = $receiver_entity_id == 103 ?  'teacher' : ( $receiver_entity_id == 105 ? 'student' : 'sponsor');
	$points_query = mysql_query("select points from rule_engine_for_referral_activity where from_user='$sender' and to_user='$receiver' and  referal_reason='$request_status'");
	$points_query_result = mysql_fetch_assoc($points_query);
	$points = (integer)$points_query_result['points'];


		if($sender_entity_id == '103')
		{
			$teacher_query = mysql_query("select t_id,t_complete_name,t_email,t_phone from tbl_teacher where id='$sender_member_id'");
			$teacher_query_result = mysql_fetch_assoc($teacher_query);
			$t_id = $teacher_query_result['t_id'];
			$sender_name = $teacher_query_result['t_complete_name'];
			$sender_phone = $teacher_query_result['t_phone'];
			$sender_email = $teacher_query_result['t_email'];


				$tbl_teacher_update_query=mysql_query("update tbl_teacher set brown_point = CASE
				WHEN brown_point is not null THEN brown_point + $points
				WHEN brown_point is null THEN $points
											END
				where id='$sender_member_id'");

				$tbl_teacher_update_query_error = mysql_error($con);

				$tbl_teacher_point_insert_query=mysql_query("insert into tbl_teacher_point (sc_teacher_id,sc_entities_id,assigner_id,reason,sc_point,point_date) values('$t_id','$receiver_entity_id','$receiver_employee_id','$request_status','$points','$issue_date')");

				$tbl_teacher_point_insert_query_error = mysql_error($con);

				if($tbl_teacher_update_query_error!='' || $tbl_teacher_point_insert_query_error!='')
				{
					$date = date("Y-m-d h:i:s");
					$query_error1 = $tbl_teacher_update_query_error.$tbl_teacher_point_insert_query_error;
					$query_error = str_replace("'","",$query_error1);
					$data = array('error_type'=>'',
							'error_description'=>$query_error,
							'data'=>'',
							'datetime'=>$date,
							'user_type'=>$sender,
							'member_id'=>$sender_member_id,
							'name'=>$sender_name,
							'phone'=>$sender_phone,
							'email'=>$sender_email,
							'line'=>'40',
							'status'=>'',
							'last_programmer_name'=>'Rutuja Jori'
							);
					// last_programmer_name added by Rutuja for SMC-4915 for  on 21-10-2020
					$ch = curl_init("http://$server_name/core/Version2/error_log_ws.php");
					$data_string = json_encode($data);
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
					$result = json_decode(curl_exec($ch),true);
					$responce = $result["responseStatus"];
					$postvalue['responseStatus']=417;
					$postvalue['responseMessage']="error in sql queries";
					$postvalue['posts']=$query_error;
					header('Content-type: application/json');
					echo json_encode($postvalue);
				}
				else
				{
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="select points from rule_engine_for_referral_activity where from_user='$sender' and to_user='$receiver' and  referal_reason='$request_status'";
				$postvalue['posts']=null;
				header('Content-type: application/json');
				echo json_encode($postvalue);
				}

		}
		elseif($sender_entity_id == '105')
		{
			$student_query = mysql_query("select std_PRN,std_complete_name,std_email,std_phone from tbl_student where id='$sender_member_id'");
			$student_query_result = mysql_fetch_assoc($student_query);
			$std_PRN = $student_query_result['std_PRN'];
			$sender_name = $student_query_result['std_complete_name'];
			$sender_phone = $student_query_result['std_email'];
			$sender_email = $student_query_result['std_phone'];

			$tbl_student_reward_check_data_query = mysql_query("select id from tbl_student_reward where sc_stud_id='$std_PRN'");

			if(mysql_num_rows($tbl_student_reward_check_data_query) >= 1)
			{
				$tbl_student_reward_update_query=mysql_query("update tbl_student_reward set brown_point = CASE
				WHEN brown_point is not null THEN brown_point + $points
				WHEN brown_point is null THEN $points
											END
				where sc_stud_id='$std_PRN'");
			}
			else
			{
				$tbl_student_reward_update_query=mysql_query("insert into tbl_student_reward (sc_stud_id,sc_date,brown_point) values ('$std_PRN','$issue_date','$points')");
			}

				$tbl_student_reward_update_query = mysql_error($con);

				$tbl_student_point_insert_query = mysql_query("INSERT INTO `tbl_student_point` (sc_stud_id, sc_entites_id, sc_teacher_id, reason,sc_point, point_date)VALUES('$std_PRN', '$receiver_entity_id', '$receiver_employee_id ','$request_status', '$points', '$issue_date')");


				$tbl_student_point_insert_query = mysql_error($con);

				if($tbl_student_reward_update_query!='' || $tbl_student_point_insert_query!='')
				{
					$date = date("Y-m-d h:i:s");
					$query_error1 = $tbl_student_reward_update_query.$tbl_student_point_insert_query;
					$query_error = str_replace("'","",$query_error1);
					$data = array('error_type'=>'',
							'error_description'=>$query_error,
							'data'=>'',
							'datetime'=>$date,
							'user_type'=>$sender,
							'member_id'=>$sender_member_id,
							'name'=>$sender_name,
							'phone'=>$sender_phone,
							'email'=>$sender_email,
							'line'=>'40',
							'status'=>''
							);
					$ch = curl_init("http://$server_name/core/Version2/error_log_ws.php");
					$data_string = json_encode($data);
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
					$result = json_decode(curl_exec($ch),true);
					$responce = $result["responseStatus"];
					$postvalue['responseStatus']=417;
					$postvalue['responseMessage']="error in sql queries";
					$postvalue['posts']=$query_error;
					header('Content-type: application/json');
					echo json_encode($postvalue);
				}
				else
				{
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="ok";
				$postvalue['posts']=null;
				header('Content-type: application/json');
				echo json_encode($postvalue);
				}
		}



}
else
{
	$postvalue['responseStatus']=1000;
	$postvalue['responseMessage']="invalid inputs";
	$postvalue['posts']=null;
	header('Content-type: application/json');
	echo json_encode($postvalue);
}

@mysql_close($con);

?>
