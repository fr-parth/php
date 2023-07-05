<?php 
/* 
Author : Pranali Dalvi
Date : 22-01-2020
This web service is created for assigning reward points for Student / Teacher for giving 360 feedback for first time.
*/
$json = file_get_contents('php://input');
$obj = json_decode($json);
include '../conn.php';

$format = 'json';

$PRN_EmpID = xss_clean(mysql_real_escape_string($obj->{'PRN_EmpID'}));
$SchoolID = xss_clean(mysql_real_escape_string($obj->{'SchoolID'}));
$Entity_TypeID = xss_clean(mysql_real_escape_string($obj->{'Entity_TypeID'}));
$Key = xss_clean(mysql_real_escape_string($obj->{'Key'}));
			// start SMC-4456 added by Kunal
$Key_id = xss_clean(mysql_real_escape_string($obj->{'Key_id'}));
$reason_id = "1005";
// End SMC-4456

if($PRN_EmpID!='' && $SchoolID!='' && $Entity_TypeID!='' && ($Key!='' || $Key_id!=''))
{
    // start SMC-4456 added by Kunal

	if($Key_id!=''){
		$rewards = mysql_query("SELECT total_points,reward_points FROM tbl_360activity_level WHERE actL360_ID='$Key_id'");
		$result = mysql_fetch_assoc($rewards);
		$points = $result['reward_points']; //reward points to be inserted for 360 activity
	}else{
		$rewards = mysql_query("SELECT total_points,reward_points FROM tbl_360activity_level WHERE actL360_activity_level='$Key'");
		$result = mysql_fetch_assoc($rewards);
		$points = $result['reward_points']; //reward points to be inserted for 360 activity
	}
	// $feedback = mysql_query("SELECT reason_id FROM referral_activity_reasons WHERE reason='360 Feedback'");
	// $result1 = mysql_fetch_assoc($feedback);
	// $reason_id = $result1['reason_id']; //reason id for 360 feedback

	// End SMC-4456

	$reward = mysql_query("SELECT referal_reason_id,school_id FROM rule_engine_for_referral_activity WHERE From_entityid='$Entity_TypeID' AND referal_reason_id='$reason_id' AND is_enable='1'");
			
			if(mysql_num_rows($reward)>0){

				$reward1 = mysql_fetch_assoc($reward);
				$referal_reason_id = $reward1['referal_reason_id'];
				$date = CURRENT_TIMESTAMP;
				$type_points='BrownPoints';
			}
			else{
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;
				header('Content-type: application/json');
	    		echo json_encode($postvalue);
	    		exit;
			}

	if($Entity_TypeID=='105') //Student
	{		
			$record_exists = mysql_query("SELECT id,brown_point FROM tbl_student_reward WHERE sc_stud_id='$PRN_EmpID' AND school_id='$SchoolID'");
			
				if(mysql_num_rows($record_exists)>0)
				{
					$record = mysql_fetch_assoc($record_exists);
					$brown_point = $record['brown_point'];
					$update_points = $brown_point+$points;

					$reward_update = mysql_query("UPDATE tbl_student_reward SET sc_date='$date' , brown_point='$update_points' WHERE sc_stud_id='$PRN_EmpID' AND school_id='$SchoolID'");
				}
				else
				{
					$reward_insert = mysql_query("INSERT INTO tbl_student_reward(sc_stud_id,sc_date,school_id,brown_point) VALUES ('$PRN_EmpID','$date','$SchoolID','$points')");
				}
				//log entry					 	
				$reward_log_insert = mysql_query("INSERT INTO tbl_student_point(sc_stud_id,sc_entites_id,sc_point,point_date,reason,type_points,school_id,referral_id) VALUES ('$PRN_EmpID','105','$points','$date','Rewards for 360 feedback','$type_points','$SchoolID','$referal_reason_id')");

				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['message']='Reward points assigned successfully';		

	}
	else if($Entity_TypeID=='103') // Teacher
	{
		$record_exists = mysql_query("SELECT id,brown_point FROM tbl_teacher WHERE t_id='$PRN_EmpID' AND school_id='$SchoolID'");
				
				$record = mysql_fetch_assoc($record_exists);
				$brown_point = $record['brown_point'];
				$points1 = $brown_point+$points;

				$reward_update = mysql_query("UPDATE tbl_teacher SET brown_point='$points1' WHERE t_id='$PRN_EmpID' AND school_id='$SchoolID'");
				
				//log entry					 	
				$reward_log_insert = mysql_query("INSERT INTO tbl_teacher_point(sc_teacher_id,sc_entities_id,sc_point,point_date,reason,point_type,school_id,referral_id) VALUES ('$PRN_EmpID','103','$points','$date','Rewards for 360 feedback','$type_points','$SchoolID','$referal_reason_id')");

				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				$postvalue['message']='Reward points assigned successfully';	

	}
	else{
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']="Invalid Input";
		$postvalue['posts']=null;
	}
}
else
{
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']="Invalid Input";
		$postvalue['posts']=null;
   			 
}
		header('Content-type: application/json');
	    echo json_encode($postvalue);
							
?>