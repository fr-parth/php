<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);
include('../conn.php');
	$t_id = xss_clean(mysql_real_escape_string($obj->{'t_id'}));
	$school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
	$points = xss_clean(mysql_real_escape_string($obj->{'points'}));
	$reason = xss_clean(mysql_real_escape_string($obj->{'reason'}));
	$student_id = xss_clean(mysql_real_escape_string($obj->{'student_PRN'}));
	$activity_type1=xss_clean(mysql_real_escape_string($obj->{'activity_type'}));
	$reason_id=xss_clean(mysql_real_escape_string($obj->{'reason_id'}));

	//request_id added as new parameter by Pranali for SMC-3483
	$request_id=xss_clean(mysql_real_escape_string($obj->{'request_id'}));
	

		$accept_date= CURRENT_TIMESTAMP; 
	//define in core/securityfunctions.php
		
	$query = mysql_query("select tc_balance_point from tbl_teacher where t_id ='$t_id' and school_id = '$school_id'");
	 
	 $value = mysql_fetch_assoc($query);
	 $reward_points=$value['tc_balance_point'];

	if($t_id!='' && $school_id!='' && $points!='' && $reason!='' && $student_id!='' && $activity_type1!='' && $reason_id!='')
	{
			if($reward_points >= $points)
			{
					$final_points=$reward_points-$points;
					$test=mysql_query("update tbl_teacher set tc_balance_point='$final_points' where t_id='$t_id' and school_id='$school_id'");
				 
					$arr=mysql_query("select * from tbl_student_reward where sc_stud_id='$student_id' and school_id='$school_id'");
					$arr1=mysql_fetch_array($arr);
				 
				  
					$sc_final_point=$arr1['sc_total_point']+$points;
					$sql1=mysql_query("update tbl_student_reward set sc_total_point='$sc_final_point' where sc_stud_id='$student_id' and school_id='$school_id'");

				//and id='$request_id' added in where by Pranali for SMC-3483
					$sql2=mysql_query("update tbl_request set flag='Y' where stud_id1='$student_id' and stud_id2='$t_id' and entitity_id='103' and flag='N' and reason like '$reason_id' and school_id='$school_id' and id='$request_id'");
					/* Author VaibhavG
					*	added activity_type condition of subject & activity to getting subject id with respect to subject code for the ticket number SMC-3248 24Aug18 06:37PM
					*/
					if($activity_type1=='activity')
					{		
						$sql3=mysql_query("insert into tbl_student_point(sc_stud_id,sc_entites_id,sc_teacher_id,sc_studentpointlist_id,sc_point,point_date,method,activity_type,school_id) values('$student_id','103','$t_id','$reason_id','$points','$accept_date','1','$activity_type1','$school_id')");
					}
					elseif($activity_type1=='subject')	
					{
						$sql3=mysql_query("insert into tbl_student_point(sc_stud_id,sc_entites_id,sc_teacher_id,subject_id,sc_point,point_date,method,activity_type,school_id) values('$student_id','103','$t_id','$reason_id','$points','$accept_date','1','$activity_type1','$school_id')");
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
	
	header('content-type:application/json');
	echo  json_encode($postvalue);
	@mysql_close($conn);
?>