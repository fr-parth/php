<?php
/**
*Created by			: Shivkumar
*Created on			: 2018-03-16
*Modified by		: Rutuja
*Modified on		: 2019-11-23
*Reason to modify	: to update insert query for adding reason & referral_id
*/
include '../conn.php';
$json = file_get_contents('php://input');
$obj = json_decode($json);
header('Content-type: application/json');
//method_name added as i/p parameter by Pranali for SMC-4210 on 6-12-19
$tid = xss_clean(mysql_real_escape_string($obj->{'t_id'}));
$school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
$User_Std_id = xss_clean(mysql_real_escape_string($obj->{'User_Std_id'}));
$method_id = xss_clean(mysql_real_escape_string($obj->{'method_id'}));
$activity_id = xss_clean(mysql_real_escape_string($obj->{'activity_id'}));
$subject_id = xss_clean(mysql_real_escape_string($obj->{'subject_id'}));
$entity = xss_clean(mysql_real_escape_string($obj->{'entity'}));
$activity_type = xss_clean(mysql_real_escape_string($obj->{'activity_type'}));
$method_name = xss_clean(mysql_real_escape_string($obj->{'method_name'}));

   $dates = CURRENT_TIMESTAMP; // define in core/securityfunctions.php
   	  
	  $meth_sub_id = "activity_id='".$activity_id."'";
	 
	 /* if($activity_id != '')
	{
		$meth_sub_id = "activity_id='".$activity_id."'";
		$activity_type= 'activity';
	}
	else
	{
		$activity_id=$subject_id;
		$meth_sub_id = "subject_id='".$subject_id."'";
		$activity_type= 'subject';
	}*/
	if($method_name==''){
		$sql = mysql_query("SELECT method_name FROM tbl_method WHERE id='".$method_id."'");
		$res = mysql_fetch_assoc($sql);
		$method_name = $res['method_name'];
}
$reward_value = xss_clean(mysql_real_escape_string($obj->{'reward_value'}));
$User_date = xss_clean(mysql_real_escape_string($obj->{'User_date'}));
$point_type = xss_clean(mysql_real_escape_string($obj->{'point_type'}));
$Comment = xss_clean(mysql_real_escape_string($obj->{'Comment'}));
$reason = xss_clean(mysql_real_escape_string($obj->{'reason'}));


if($method_id!='' && $reward_value!='' && $school_id !='' && $User_Std_id == '' && $tid =='')
{
	$update_point = getPoints_from_ruleEngine($school_id,$method_id,$reward_value,$meth_sub_id,$method_name);
	
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
	
	
	$array=mysql_query("select balance_blue_points,t_name,t_middlename,t_lastname,water_point,brown_point from tbl_teacher where t_id='$tid' and school_id='$school_id'");
	$result = mysql_fetch_array($array);
	
	if($method_name == 'Judgement')
	{
		$update_point = $reward_value;
	}
	else
	{
		$update_point = getPoints_from_ruleEngine($school_id,$method_id,$reward_value,$meth_sub_id,$method_name);
	}

		if($point_type == 'Bluepoint')
		{
			$update_teacher = "balance_blue_points = balance_blue_points - ".$update_point;
			$update_student = "balance_blue_points = balance_blue_points + ".$update_point; 
			$posts[]=array('report'=>"Blue Points successfully assigned");
			$avail_points = $result['balance_blue_points'];
		}
		else if($point_type == 'Waterpoint')
		{
			$update_teacher = "water_point = water_point - ".$update_point;
			$update_student = "balance_blue_points = balance_blue_points + ".$update_point;
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

		$student_insert = mysql_query("INSERT INTO tbl_teacher_point (assigner_id, sc_entities_id, sc_teacher_id, sc_thanqupointlist_id,sc_point, point_date,method, activity_type,school_id,comment,point_type,reward_type,referral_id,reason)VALUES('$tid', '103', '$User_Std_id','$activity_id','$update_point', '$dates','$method_id','$activity_type','$school_id','$Comment','$point_type','reward','0','$reason');");


		$select_student =  mysql_query("select id,t_id from tbl_teacher where t_id='$User_Std_id' and school_id='$school_id'");
		$count=mysql_num_rows($select_student);
		
		if($count > 0){
		$student_update = 	mysql_query("update tbl_teacher set $update_student where t_id='$User_Std_id' and school_id='$school_id'");
		}
		/*else{
			$select_id=mysql_query("select id from tbl_teacher where t_id='$User_Std_id' and school_id='$school_id'");
			$res=mysql_fetch_array($select_id);
			$std_mem_id=$res['id'];
			$student_update = mysql_query("INSERT INTO tbl_student_reward (Stud_Member_Id, sc_total_point, sc_stud_id, sc_date,school_id) VALUES ('$std_mem_id','$reward_value', '$User_Std_id', '$dates','$school_id')");
		}*/
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

function getPoints_from_ruleEngine($school_id,$method_id,$reward_value,$meth_sub_id,$method_name)
{
	if($method_name !='Grade')
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
//below if condition added to take default rule engine by Pranali for SMC-4210 on 11-12-19
			if($count < 1)
			{
				$meth_sub_id = "(subject_id='0' OR subject_id ='' OR subject_id IS NULL) AND (activity_id ='0' OR activity_id ='' OR activity_id IS NULL)";
				
				$method_details = mysql_query("SELECT id FROM tbl_method WHERE method_name='".$method_name."' AND school_id='0' AND group_member_id='0'");
				$methodName = mysql_fetch_assoc($method_details);
				$method_id = $methodName['id'];
				
				$query_get_points = mysql_query("select points from tbl_master where school_id = '0' AND method_id = '$method_id' $range and $meth_sub_id");
				$get_points_res = mysql_fetch_array($query_get_points);
				$count	=	mysql_num_rows($query_get_points);
				$update_point = $get_points_res['points'];
			}
		}
		return $update_point;
}   