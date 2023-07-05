<?php
/**
*Created by			: Shivkumar
*Created on			: 2018-03-16
*Modified by		: Shivkumar
*Modified on		: 2018-08-10
*Reason to modify	: to display/confirm the point before assign
*/
include 'conn.php';
$json = file_get_contents('php://input');
$obj = json_decode($json);
header('Content-type: application/json');

$tid = xss_clean(mysql_real_escape_string($obj->{'t_id'}));
$school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
$User_Std_id = xss_clean(mysql_real_escape_string($obj->{'User_Std_id'}));
$method_id = xss_clean(mysql_real_escape_string($obj->{'method_id'}));
$activity_id = xss_clean(mysql_real_escape_string($obj->{'activity_id'}));
$subject_id = xss_clean(mysql_real_escape_string($obj->{'subject_id'}));

// Start SMC-3451 Modify By sachin 2018-09-19 17:16:38 PM 
  //$dates=date('Y-m-d');
   $dates = CURRENT_TIMESTAMP; 
  // define in core/securityfunctions.php
  //Start SMC-3451

	if($activity_id != '')
	{
		$meth_sub_id = "activity_id='".$activity_id."'";
		$activity_type= 'activity';
	}
	else
	{
		$activity_id=$subject_id;
		$meth_sub_id = "subject_id='".$subject_id."'";
		$activity_type= 'subject';
	}
$reward_value = xss_clean(mysql_real_escape_string($obj->{'reward_value'}));
$User_date = xss_clean(mysql_real_escape_string($obj->{'User_date'}));
$point_type = xss_clean(mysql_real_escape_string($obj->{'point_type'}));
$Comment = xss_clean(mysql_real_escape_string($obj->{'Comment'}));

if($method_id!='' && $reward_value!='' && $school_id !='' && $User_Std_id == '' && $tid =='')
{
	$update_point = getPoints_from_ruleEngine($school_id,$method_id,$reward_value,$meth_sub_id);
	if($update_point < 1)
	{
		$postvalue['responseStatus']=1006;
		$postvalue['responseMessage']="Rule engine not found";
		$posts[]=array('report'=>"Sorry, rule engine is not defined for this subject or activity on selected mthod.Kindly use other method");
		$postvalue['posts']=$posts;
		echo  json_encode($postvalue);
	}
	else
	{
		$posts[]=array('points'=>$update_point);
		$postvalue['responseStatus']=200;
		$postvalue['responseMessage']="OK";
		$postvalue['posts']=$posts;
		echo  json_encode($postvalue);
	}
}

else if($User_Std_id != '' && $tid !='' && $method_id!=''&& $point_type!='' && $reward_value!='' && $school_id !='')
{
	
	$array=mysql_query("select tc_balance_point,t_name,t_middlename,t_lastname,water_point,brown_point from tbl_teacher where t_id='$tid' and school_id='$school_id'");
	$result = mysql_fetch_array($array);
	
	if($method_id == 1)
	{
		$update_point = $reward_value;
	}
	else
	{
		$update_point = getPoints_from_ruleEngine($school_id,$method_id,$reward_value,$meth_sub_id);
	}

		if($point_type == 'Greenpoint')
		{
			$update_teacher = "tc_balance_point = tc_balance_point - ".$update_point;
			$update_student = "sc_total_point = sc_total_point + ".$update_point; 
			$posts[]=array('report'=>"Green Points successfully assigned");
			$avail_points = $result['tc_balance_point'];
		}
		else if($point_type == 'Waterpoint')
		{
			$update_teacher = "water_point = water_point - ".$update_point;
			$update_student = "sc_total_point = sc_total_point + ".$update_point;
			$posts[]=array('report'=>"Water Points  successfully assigned");
			$avail_points = $result['water_point'];
		}

		if($update_point > $avail_points)
		{
			$postvalue['responseStatus']=1000;
			$postvalue['responseMessage']="You do not have sufficient $point_type";
			$postvalue['posts']=null;
			echo  json_encode($postvalue);
			exit;
		}

		$teacher_update = 	mysql_query("update tbl_teacher set $update_teacher where t_id='$tid' and school_id='$school_id'");
		/* Author VaibhavG
		*  changed reward_value as update_point for sc_point to the insert into 		tbl_student_point for the ticket number SAND-1625 as discussed with Android developer Priyanka Gole.
		*/
		$student_insert = mysql_query("INSERT INTO `tbl_student_point` (sc_stud_id, sc_entites_id, sc_teacher_id, sc_studentpointlist_id,subject_id,sc_point, point_date, sc_status,activity_type,method,school_id,comment,type_points)VALUES('$User_Std_id', '103', '$tid','$activity_id','$subject_id', '$update_point', '$dates', 'N','$activity_type','$method_id','$school_id','$Comment','$point_type');");

		$student_update = 	mysql_query("update tbl_student_reward set $update_student where sc_stud_id='$User_Std_id' and school_id='$school_id'");

		if($teacher_update==1 && $student_update ==1)
		{
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="OK";
			$postvalue['posts']=$posts;
			echo  json_encode($postvalue);
		}
		else
		{
			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="No Response";
			$postvalue['posts']=null;
			echo  json_encode($postvalue);
		}
	}
else
{
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']="Invalid Input";
		$postvalue['posts']=null;
		echo  json_encode($postvalue); 
}

function getPoints_from_ruleEngine($school_id,$method_id,$reward_value,$meth_sub_id)
{
	if($method_id !=3)
	{
		$range = "AND from_range <=$reward_value and to_range >= $reward_value";
	}
	else
	{
		$range = "AND from_range <='$reward_value' and to_range >= '$reward_value'";
	}
	
		$query_get_points = mysql_query("select points from  tbl_master where school_id = '$school_id' AND method_id = '$method_id' $range and $meth_sub_id");
		$get_points_res = mysql_fetch_array($query_get_points);
		$count	=	mysql_num_rows($query_get_points);
		$update_point = $get_points_res['points'];

		if($count < 1)
		{
			$meth_sub_id = "(subject_id='0' OR subject_id ='' OR subject_id IS NULL) AND (activity_id ='0' OR activity_id ='' OR activity_id IS NULL)";
			
			$query_get_points = mysql_query("select points from  tbl_master where school_id = '$school_id' AND method_id = '$method_id' $range and $meth_sub_id");
			$get_points_res = mysql_fetch_array($query_get_points);
			$count	=	mysql_num_rows($query_get_points);
			$update_point = $get_points_res['points'];
		}
		return $update_point;
}
