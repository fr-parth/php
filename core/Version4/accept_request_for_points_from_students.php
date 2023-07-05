<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);
include('../conn.php');

	$t_id = xss_clean(mysql_real_escape_string($obj->{'t_id'}));
	$school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
	$points = xss_clean(mysql_real_escape_string($obj->{'points'}));
	$reason = xss_clean(mysql_real_escape_string($obj->{'reason'}));
	$student_id = xss_clean(mysql_real_escape_string($obj->{'student_PRN'}));
	$activity_type1 = xss_clean(mysql_real_escape_string($obj->{'activity_type'}));
	$reason_id = xss_clean(mysql_real_escape_string($obj->{'reason_id'}));
	$entity = xss_clean(mysql_real_escape_string($obj->{'entity'}));
	$accept_date = CURRENT_TIMESTAMP; 
	//define in core/securityfunctions.php

	//Below parameters added by Rutuja Jori on 06/12/2019 for adding teacher comment & point_type for deducting points from water_points if green points are insufficient.

	$point_type = xss_clean(mysql_real_escape_string($obj->{'point_type'}));
	$teacher_comment = xss_clean(mysql_real_escape_string($obj->{'teacher_comment'}));

	
	

if($entity=='103')
{
	 $query = mysql_query("select water_point from tbl_teacher where t_id ='$t_id' and school_id = '$school_id'");
	 
	 $value = mysql_fetch_assoc($query);
	 $reward_points=$value['water_point'];

	if($t_id!='' && $school_id!='' && $points!='' && $reason!='' && $student_id!='' && $activity_type1!='' && $reason_id!='')
	{
			if($reward_points >= $points)
			{
					$final_points=$reward_points-$points;
					$test=mysql_query("update tbl_teacher set water_point='$final_points' where t_id='$t_id' and school_id='$school_id'");
				 
					$arr=mysql_query("select * from tbl_teacher where t_id='$student_id' and school_id='$school_id'");
					$arr1=mysql_fetch_array($arr);
				 
				  
					$sc_final_point=$arr1['balance_blue_points']+$points;
					$sql1=mysql_query("update tbl_teacher set balance_blue_points='$sc_final_point' where t_id='$student_id' and school_id='$school_id'");
			//For update query, teacher_comment added by Rutuja Jori on 05/12/2019
					$sql2=mysql_query("update tbl_request set teacher_comment='$teacher_comment',flag='Y' where stud_id1='$student_id' and stud_id2='$t_id' and entitity_id='103' and entitity_id1='$entity' and flag='N' and reason like '$reason_id' and school_id='$school_id'");
					/* Author VaibhavG
					*	added activity_type condition of subject & activity to getting subject id with respect to subject code for the ticket number SMC-3248 24Aug18 06:37PM
					*/
					
					
					//reason and comment inserted into tbl_student_point by Pranali for SMC-3810 on 26-3-19

					//point_type changed by Rutuja Jori on 05/12/2019 from 'Bluepoint' to 'Waterpoint' as water point log was not getting displayed after accepting the request from manager.

					$sql3=mysql_query("insert into tbl_teacher_point(sc_teacher_id,sc_entities_id,assigner_id,sc_thanqupointlist_id,sc_point,point_date,activity_type,school_id,reason,comment,point_type, reward_type) values('$student_id','103','$t_id','$reason_id','$points','$accept_date','$activity_type1','$school_id','$reason','$teacher_comment','Waterpoint','reward')");
					
					//code end for SMC-3248 24Aug18 06:37PM	
					$postvalue['responseStatus']=200;
					$postvalue['responseMessage']="OK";
					$postvalue['posts']=null;
				
			}
			else
			{
					$postvalue['responseStatus']=204;
					$postvalue['responseMessage']="insufficient points";
					$postvalue['posts']=null;
			}
	}
	else
	{
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']="invalid inputs";
		$postvalue['posts']=null;
	}
	
	
}
else
{
//Below code updated by Rutuja Jori on 06/12/2019 for adding point_type for deducting points from water_points if there are insufficient green points for specific $t_id.  

if($point_type=='Waterpoint')
{
 $point .= " water_point ";
}	
else
{
$point .= " tc_balance_point ";
}
	 $query = mysql_query("select $point as point from tbl_teacher where t_id ='$t_id' and school_id = '$school_id'");
	 
	 $value = mysql_fetch_assoc($query);
	 $reward_points=$value['point'];

	if($t_id!='' && $school_id!='' && $points!='' && $reason!='' && $student_id!='' && $activity_type1!='' && $reason_id!='')
	{
			if($reward_points >= $points)
			{
					$final_points=$reward_points-$points;
					$test=mysql_query("update tbl_teacher set $point='$final_points' where t_id='$t_id' and school_id='$school_id'");
				 
					$arr=mysql_query("select * from tbl_student_reward where sc_stud_id='$student_id' and school_id='$school_id'");
					$arr1=mysql_fetch_array($arr);
				 
				  
					$sc_final_point=$arr1['sc_total_point']+$points;
					$sql1=mysql_query("update tbl_student_reward set sc_total_point='$sc_final_point' where sc_stud_id='$student_id' and school_id='$school_id'");
				
					$sql2=mysql_query("update tbl_request set flag='Y' where stud_id1='$student_id' and stud_id2='$t_id' and entitity_id='103' and flag='N' and reason like '$reason_id' and school_id='$school_id'");
					/* Author VaibhavG
					*	added activity_type condition of subject & activity to getting subject id with respect to subject code for the ticket number SMC-3248 24Aug18 06:37PM
					*/
					
					
					//reason and comment inserted into tbl_student_point by Pranali for SMC-3810 on 26-3-19
					if($activity_type1=='activity')
					{		
						$sql3=mysql_query("insert into tbl_student_point(sc_stud_id,sc_entites_id,sc_teacher_id,sc_studentpointlist_id,sc_point,point_date,method,activity_type,school_id,reason,comment) values('$student_id','103','$t_id','$reason_id','$points','$accept_date','1','$activity_type1','$school_id','$reason','$teacher_comment')");
					}
					elseif($activity_type1=='subject')	
					{
						$sql3=mysql_query("insert into tbl_student_point(sc_stud_id,sc_entites_id,sc_teacher_id,subject_id,sc_point,point_date,method,activity_type,school_id,reason,comment) values('$student_id','103','$t_id','$reason_id','$points','$accept_date','1','$activity_type1','$school_id','$reason','$teacher_comment')");
					}	
					//code end for SMC-3248 24Aug18 06:37PM	
					$postvalue['responseStatus']=200;
					$postvalue['responseMessage']="OK";
					$postvalue['posts']=null;
				
			}
			else
			{
					$postvalue['responseStatus']=204;
					$postvalue['responseMessage']="insufficient points";
					$postvalue['posts']=null;
			}
	}
	else
	{
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']="invalid inputs";
		$postvalue['posts']=null;
	}

}	
	header('content-type:application/json');
	echo  json_encode($postvalue);
	@mysql_close($con);
?>