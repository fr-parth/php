<?php
/**
Code Updated by Rutuja Jori on 14/08/2019 for adding getPoints_from_ruleEngine() function on Dev, Test environment
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
$a_id = xss_clean(mysql_real_escape_string($obj->{'a_id'}));
$method_name = xss_clean(mysql_real_escape_string($obj->{'method_name'}));

   $dates = CURRENT_TIMESTAMP; 

  	/*if($activity_id != '')
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

//Below if/else conditions added by Rutuja Jori on 30/07/2019 for Innovation Cell
if($activity_type=='1')
{
	$activity_type= 'Subject';
}

else if($activity_type=='2')
{
	$activity_type= 'Activity';
}

else if($activity_type=='3')
{
	$activity_type= 'Innovation Cell';
}


	if($activity_id != '')
	{
		$meth_sub_id = "activity_id='".$activity_id."'";
		$activity_type= 'activity';
	}
	else
	{
		//below line commented by Pranali as activity id was inserted in subject_id column when activity_id was blank  FOR SMC-3809 on 2-4-19
		//$activity_id=$subject_id;
		$meth_sub_id = "subject_id='".$subject_id."'";
		$activity_type= 'subject';
	}
$reward_value = xss_clean(mysql_real_escape_string($obj->{'reward_value'}));
$User_date = xss_clean(mysql_real_escape_string($obj->{'User_date'}));
$point_type = xss_clean(mysql_real_escape_string($obj->{'point_type'}));
$Comment = xss_clean(mysql_real_escape_string($obj->{'Comment'}));


	
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
	
	$array=mysql_query("select tc_balance_point,t_name,t_middlename,t_lastname,water_point,brown_point from tbl_teacher where t_id='$tid' and school_id='$school_id'");
	$result = mysql_fetch_array($array);
	
	if($method_name == 'Judgement')
	{
		$update_point = $reward_value;
	}
	else
	{
		$update_point = getPoints_from_ruleEngine($school_id,$method_id,$reward_value,$meth_sub_id,$method_name);
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

		
		$activity=mysql_query("select sc_id,sc_list from tbl_studentpointslist where sc_id='$activity_id'");
		$r=mysql_fetch_array($activity);
			$sc_id=$r['sc_id'];
		$sc_list=$r['sc_list'];
		
		$achieve=mysql_query("select a_alloc_points,a_desc from tbl_onlinesubject_activity_achivement where a_id='$a_id'");
		
		
		
		$ach=mysql_fetch_array($achieve);
		 	$a_alloc_points=$ach['a_alloc_points'];
		$a_desc=$ach['a_desc'];
		
		
		//Below insert query updated by Rutuja Jori on 30/07/2019 for Innovation Cell
		
		$student_insert = mysql_query("INSERT INTO tbl_student_point (sc_id,sc_list,a_desc,a_alloc_points,reason,sc_stud_id, sc_entites_id, sc_teacher_id, sc_studentpointlist_id,subject_id,sc_point, point_date, sc_status,activity_type,method,school_id,comment,type_points)VALUES('$activity_id','$sc_list','$a_desc','$a_alloc_points','$sc_list','$User_Std_id', '103', '$tid','$activity_id','$subject_id', '$update_point', '$dates', 'N','$activity_type','$method_id','$school_id','$Comment','$point_type');");
		

		
		$select_student =  mysql_query("select id from tbl_student_reward where sc_stud_id='$User_Std_id' and school_id='$school_id'");
		$count=mysql_num_rows($select_student);
		
		if($count > 0){
		$student_update = 	mysql_query("update tbl_student_reward set $update_student where sc_stud_id='$User_Std_id' and school_id='$school_id'");
		}
		else{
			$select_id=mysql_query("select id from tbl_student where std_PRN='$User_Std_id' and school_id='$school_id'");
			$res=mysql_fetch_array($select_id);
			$std_mem_id=$res['id'];
			$student_update = mysql_query("INSERT INTO tbl_student_reward (Stud_Member_Id, sc_total_point, sc_stud_id, sc_date,school_id) VALUES ('$std_mem_id','$reward_value', '$User_Std_id', '$dates','$school_id')");
		}
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
			if($count < 1){
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