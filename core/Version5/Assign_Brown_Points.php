<?php  
/*
Author: Pranali Dalvi
Date : 18-5-20
This webservice was created for assigning brown points as reward for Student / Teacher 
*/

$json = file_get_contents('php://input');
$obj = json_decode($json);
$format = 'json';

include '../conn.php';
header('Content-type: application/json');

$Member_ID = xss_clean(mysql_real_escape_string($obj->{'Member_ID'}));
$Entity_TypeID = xss_clean(mysql_real_escape_string($obj->{'Entity_TypeID'}));
$Source = xss_clean(mysql_real_escape_string($obj->{'Source'})); // Project name
$Category = xss_clean(mysql_real_escape_string($obj->{'Category'}));
$Sub_Category = xss_clean(mysql_real_escape_string($obj->{'Sub_Category'}));
$Reason = xss_clean(mysql_real_escape_string($obj->{'Reason'}));
$Referral_Reason = xss_clean(mysql_real_escape_string($obj->{'Referral_Reason'}));
$Time_Duration = xss_clean(mysql_real_escape_string($obj->{'Time_Duration'}));



if($Member_ID!='' && $Source!='' && $Category!='' && $Sub_Category!='' && $Reason!='' && $Referral_Reason!='' && $Entity_TypeID != '')
{	
	if($Entity_TypeID == '105')
	{
		$fields = 'std_PRN as id,school_id';
		$table = 'tbl_student';
		$reward_table = 'tbl_student_reward';
		$where_reward = 'sc_stud_id';
	}
	else if($Entity_TypeID == '103')
	{
		$fields = 't_id as id,school_id';
		$table = 'tbl_teacher';
		$reward_table = 'tbl_teacher';
		$where_reward = 't_id';
	}		
		$rule_engine = mysql_query("SELECT points FROM rule_engine_for_referral_activity WHERE referal_reason='".$Referral_Reason."' AND is_enable='1' AND To_entityid='".$Entity_TypeID."'");	
		 
	if(mysql_num_rows($rule_engine)!=0)
	{
		$rule_engine1 = mysql_fetch_array($rule_engine);
		$points = $rule_engine1[0];

		if($Referral_Reason=='Channel Time'){
					
			$rule_engine2 = mysql_query("SELECT points
			FROM rule_engine_for_referral_activity
			WHERE To_entityid='".$Entity_TypeID."' AND is_enable='1' AND referal_reason='Play Track'");
			$res = mysql_fetch_array($rule_engine2); 
			$points1 = $res['points'];
			if($Time_Duration!=0)
			{
				$points = $points1 + ($points * $Time_Duration);
			}
			else if($Time_Duration==0 || $Time_Duration==''){
				$points = $points1;
			}
		}
	
		$sql_record = mysql_query("SELECT $fields FROM $table WHERE id='$Member_ID'");
		if(mysql_num_rows($sql_record)==1)
		{
			$stud = mysql_fetch_assoc($sql_record);
			$id = $stud['id'];
			$school_id = $stud['school_id'];

			$record_exists = mysql_query("SELECT brown_point FROM $reward_table WHERE $where_reward = '$id' AND school_id='$school_id' order by id desc limit 1");

				if(mysql_num_rows($record_exists)==1){
					$res = mysql_fetch_assoc($record_exists);

		//reward point entry
					$datetime = date('Y-m-d H:i:s');
					$brown_point = $res['brown_point'] + $points;
					if($Entity_TypeID=='105'){
						$stud_reward = mysql_query("UPDATE tbl_student_reward SET brown_point='$brown_point',sc_date='$datetime',Stud_Member_Id='$Member_ID' WHERE sc_stud_id='$id' AND school_id='$school_id'");
					}else if($Entity_TypeID=='103'){
						$stud_reward = mysql_query("UPDATE tbl_teacher SET brown_point='$brown_point' WHERE t_id='$id' AND school_id='$school_id'");
					}
					
				}else{
					if($Entity_TypeID=='105'){
					$brown_point = $points;
					$stud_reward = mysql_query("INSERT INTO tbl_student_reward (Stud_Member_Id,sc_stud_id,sc_date,school_id,brown_point) VALUES ('$Member_ID','$id','$datetime','$school_id','$brown_point')");
					}
				}
		//point log
				if($Entity_TypeID=='105') {
					$stud_reward_log = mysql_query("INSERT INTO tbl_student_point (Stud_Member_Id,sc_stud_id,sc_entites_id,sc_point,point_date,reason,activity_type,school_id,type_points,source,category,sub_category) VALUES ('$Member_ID','$id','$Entity_TypeID','$points','$datetime','$Reason','$Referral_Reason','$school_id','BrownPoints','$Source','$Category','$Sub_Category')");
				}
				else if($Entity_TypeID=='103') {
					$stud_reward_log = mysql_query("INSERT INTO tbl_teacher_point (Teacher_Member_Id,sc_teacher_id,sc_entities_id,sc_point,point_date,reason,activity_type,school_id,point_type,source,category,sub_category) VALUES ('$Member_ID','$id','$Entity_TypeID','$points','$datetime','$Reason','$Referral_Reason','$school_id','BrownPoints','$Source','$Category','$Sub_Category')");
				} 			
			$success_msg = "$points reward brown points assigned successfully";
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="OK";
			$postvalue['success_message']=$success_msg;
		}
		else{
			$postvalue['responseStatus']=404;
			$postvalue['responseMessage']="No record found";
		}
	}
	else
	{
		$postvalue['responseStatus']=204;
		$postvalue['responseMessage']="Rule Engine doesn't exists for this referral reason";
	}

}
else{
	$postvalue['responseStatus']=1000;
	$postvalue['responseMessage']="Invalid Input";
}   
echo json_encode($postvalue);
?>