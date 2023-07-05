<?php 
/*
 *Created by Shivkumar on 2018-11-06
 *@file - webservice for group admin to display school list with informations
 */
include 'conn.php';
header('Content-type: application/json');
 $json = file_get_contents('php://input');
 $obj = json_decode($json);

 $group_id = xss_clean(mysql_real_escape_string($obj->{'group_id'}));
 $keyword = xss_clean(mysql_real_escape_string($obj->{'keyword'}));

 $offset = xss_clean(mysql_real_escape_string($obj->{'offset'}));
//offset function call from core/securityfunctions.php
$offset=offset($offset);//default offset = "0"


	if(!empty($group_id))
	{
		$count_query = mysql_query("SELECT count(id) as schoolCount FROM tbl_school_admin where group_member_id = '$group_id'");
		$res = mysql_fetch_array($count_query);
		$total_count = $res['schoolCount'];
		if(!empty($keyword))
		{
			$sql=mysql_query("SELECT id as member_id,school_id,school_name,reg_date,name as admin_name,address,scadmin_city,scadmin_country,scadmin_state,balance_blue_points,school_balance_point,school_assigned_point,(SELECT COUNT('id') as no_teacher  FROM tbl_teacher where school_id=sa.school_id and group_member_id='$group_id') as teacher_count,(SELECT COUNT(id) as no_students FROM tbl_student  where school_id=sa.school_id and group_member_id='$group_id') as student_count FROM tbl_school_admin sa where group_member_id = '$group_id' AND (school_id LIKE '%$keyword%' OR school_name LIKE '%$keyword%') order by student_count desc LIMIT $limit OFFSET $offset");
		}
		else
		{
			$sql=mysql_query("SELECT id as member_id,school_id,school_name,reg_date,name as admin_name,address,scadmin_city,scadmin_country,scadmin_state,balance_blue_points,school_balance_point,school_assigned_point,(SELECT COUNT('id') as no_teacher  FROM tbl_teacher where school_id=sa.school_id and group_member_id='$group_id') as teacher_count,(SELECT COUNT(id) as no_students FROM tbl_student  where school_id=sa.school_id and group_member_id='$group_id') as student_count FROM tbl_school_admin sa where group_member_id = '$group_id' order by student_count desc LIMIT $limit OFFSET $offset");
		}
		
		
		$count=mysql_num_rows($sql);
		if($count==0 && $sql) 
		{
			if($offset==0)
			{
				
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Record found";
				$postvalue['posts']=null;
			}
			else
			{
				$postvalue['responseStatus']=224;
				$postvalue['responseMessage']="End of Records";
				$postvalue['posts']=null;
			}
			
		}
		else if($count > 0) 
		{
			while($post = mysql_fetch_assoc($sql))
			{
				$posts[] = array_map(clean_string,$post); 
			}
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="OK";
			$postvalue['schoolCount']=$total_count;
			$postvalue['posts']=$posts;
			echo json_encode($postvalue); 
		}
		else
		{
			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="No Response";
			$postvalue['posts']=null;	
		}
	}
	else
	{
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']="Invalid Input";
		$postvalue['posts']=null;
		echo json_encode($postvalue); 
	}