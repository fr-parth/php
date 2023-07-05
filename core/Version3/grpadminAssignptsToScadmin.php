<?php 
/*
 *Created by Shivkumar on 2018-11-09
 *@file - webservice for group admin to assign green/blue point to school admin
 */
include 'conn.php';
header('Content-type: application/json');
 $json = file_get_contents('php://input');
 $obj = json_decode($json);

 $group_id = xss_clean(mysql_real_escape_string($obj->{'group_id'}));
 $entity_id = xss_clean(mysql_real_escape_string($obj->{'entity_id'}));
 $teacher_id = xss_clean(mysql_real_escape_string($obj->{'teacher_id'}));
 $student_id = xss_clean(mysql_real_escape_string($obj->{'student_id'}));
 $school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
 $points = xss_clean(mysql_real_escape_string($obj->{'points'}));
 $point_type = xss_clean(mysql_real_escape_string($obj->{'point_type'}));
 $date = CURRENT_TIMESTAMP;
//offset function call from core/securityfunctions.php
//$offset=offset($offset);//default offset = "0"

if(!empty($group_id) && !empty($points) && !empty($point_type) && !empty($entity_id))
{

	if(empty($school_id) && $entity_id==102)
	{
		$sql=mysql_query("select count(*) as count from tbl_school_admin where group_member_id = '$group_id'");
		$result=mysql_fetch_array($sql);
		$grp_points = ($result['count']) * $points;
	}
	else if(!empty($school_id) && $entity_id==102)
	{
		$sql=mysql_query("select school_name,id from tbl_school_admin where school_id='$school_id' AND group_member_id = '$group_id'");
		$result=mysql_fetch_array($sql);
		$school_name=$result['school_name'];
		$grp_points = $points;
	}
	/*else if(empty($teacher_id) && $entity_id==103)
	{
		$sql=mysql_query("select count(*) as count from tbl_teacher where group_member_id = '$group_id'");
		$result=mysql_fetch_array($sql);
		$grp_points = ($result['count']) * $points;
	}
	else if(empty($student_id) && $entity_id==105)
	{
		$sql=mysql_query("select count(*) as count from tbl_student where group_member_id = '$group_id'");
		$result=mysql_fetch_array($sql);
		$grp_points = ($result['count']) * $points;
	}*/
	else if($entity_id==103)
	{
		$sql=mysql_query("select count(*) as count from tbl_teacher where group_member_id = '$group_id'");
		$result=mysql_fetch_array($sql);
		$grp_points = ($result['count']) * $points;
	}
	else if($entity_id==105)
	{
		$sql=mysql_query("select count(*) as count from tbl_student where group_member_id = '$group_id'");
		$result=mysql_fetch_array($sql);
		$grp_points = ($result['count']) * $points;
	}
	else
	{
		$grp_points = $points;
	}

	if($point_type == 'Green')
	{
		$grp_point_col = "balance_green_point";
		$groupset = "balance_green_point = balance_green_point - ".$grp_points;
		$schoolset = "school_balance_point = IF(school_balance_point IS NULL,'".$points."',school_balance_point + '".$points."')"; 
		$teacherset = "tc_balance_point = IF(tc_balance_point IS NULL,'".$points."',tc_balance_point + '".$points."')";
		$studentset = "sc_total_point = IF(sc_total_point IS NULL,'".$points."',sc_total_point + '".$points."')";
		$stud_update_tbl = "tbl_student_reward";
		$stud_where = "(sc_stud_id='".$prn."' AND school_id='".$school_id."' AND group_member_id = '".$group_id."') OR id='".$student_id."'"; 
	}
	else if($point_type == 'Blue')
	{
		$grp_point_col = "balance_blue_point";
		$groupset = "balance_blue_point = balance_blue_point - ".$grp_points;
		$schoolset = "balance_blue_points = IF(balance_blue_points IS NULL,'".$points."',balance_blue_points + '".$points."')";
		$teacherset = "balance_blue_points = IF(balance_blue_points IS NULL,'".$points."',balance_blue_points + '".$points."')";
		$studentset = "balance_bluestud_points = IF(balance_bluestud_points IS NULL,'".$points."',balance_bluestud_points + '".$points."')";
		$stud_update_tbl = "tbl_student";
		$stud_where = "id=".$student_id;
	}

	$mysql=mysql_query("select $grp_point_col from tbl_cookieadmin where id = '$group_id'");
	$myresult=mysql_fetch_array($mysql);
	$avail_pts=$myresult[0];

	if($avail_pts >= $grp_points)
	{
		
		$query=mysql_query("update tbl_cookieadmin set $groupset where id = '$group_id'");
		
		if(empty($school_id) && $entity_id==102)
		{
			$query=mysql_query("update tbl_school_admin set $schoolset where group_member_id = '$group_id'");

			$log_details=mysql_query("INSERT INTO tbl_distribute_points_by_cookieadmin (assigned_by,points,point_color,entity_name,entity_id,date) select '$group_id' as grpid,'$points' as pts,'$point_type' as ptype,school_name,school_id,'$date' as date from tbl_school_admin where group_member_id = '$group_id')");
		}
		else if(!empty($school_id) && $entity_id==102)
		{
			$query=mysql_query("update tbl_school_admin set $schoolset where school_id='$school_id' AND group_member_id = '$group_id'");

			$log_details=mysql_query("INSERT INTO tbl_distribute_points_by_cookieadmin (assigned_by,points,point_color,entity_name,entity_id,date)values ('$group_id','$points','$point_type','$school_name','$school_id','$date')");
		}
		else if($entity_id==103 && $point_type == 'Green')
		{
			
			$query=mysql_query("update tbl_school_admin sc set school_balance_point = IF(school_balance_point IS NULL,(select count(*) as c from tbl_teacher where school_id=sc.school_id AND group_member_id = '$group_id')*'$points',school_balance_point + ((select count(*) as c from tbl_teacher where school_id=sc.school_id AND group_member_id = '$group_id')*'$points')) where group_member_id = '$group_id'");

			$log_details=mysql_query("INSERT INTO tbl_distribute_points_by_cookieadmin (assigned_by,points,point_color,entity_name,entity_id,date) select '$group_id' as grpid,(select count(*) as c from tbl_teacher where school_id=sc.school_id AND group_member_id = '$group_id')*'$points' as pts, '$point_type' as ptype,school_name,school_id,'$date' as date from tbl_school_admin sc where group_member_id = '$group_id' having (select count(*) as c from tbl_teacher where school_id=sc.school_id AND group_member_id = '$group_id' ) > 0");
		}
		else if($entity_id==103 && $point_type == 'Blue')
		{
			
			$query=mysql_query("update tbl_school_admin sc set balance_blue_points = IF(balance_blue_points IS NULL,(select count(*) as c from tbl_teacher where school_id=sc.school_id AND group_member_id = '$group_id')*'$points',balance_blue_points + ((select count(*) as c from tbl_teacher where school_id=sc.school_id AND group_member_id = '$group_id')*'$points')) where group_member_id = '$group_id'");

			$log_details=mysql_query("INSERT INTO tbl_distribute_points_by_cookieadmin (assigned_by,points,point_color,entity_name,entity_id,date) select '$group_id' as grpid,(select count(*) as c from tbl_teacher where school_id=sc.school_id AND group_member_id = '$group_id')*'$points' as pts, '$point_type' as ptype,school_name,school_id,'$date' as date from tbl_school_admin sc where group_member_id = '$group_id' having (select count(*) as c from tbl_teacher where school_id=sc.school_id AND group_member_id = '$group_id' ) > 0");
		}
		else if($entity_id==105 && $point_type == 'Green')
		{
			
			$query=mysql_query("update tbl_school_admin sc set school_balance_point = IF(school_balance_point IS NULL,(select count(*) as c from tbl_student where school_id=sc.school_id AND group_member_id = '$group_id')*'$points',school_balance_point + ((select count(*) as c from tbl_student where school_id=sc.school_id AND group_member_id = '$group_id')*'$points')) where group_member_id = '$group_id'");

			$log_details=mysql_query("INSERT INTO tbl_distribute_points_by_cookieadmin (assigned_by,points,point_color,entity_name,entity_id,date) select '$group_id' as grpid,(select count(*) as c from tbl_student where school_id=sc.school_id AND group_member_id = '$group_id')*'$points' as pts, '$point_type' as ptype,school_name,school_id,'$date' as date from tbl_school_admin sc where group_member_id = '$group_id' having (select count(*) as c from tbl_student where school_id=sc.school_id AND group_member_id = '$group_id' ) > 0");
		}
		else if($entity_id==105 && $point_type == 'Blue')
		{
			
			$query=mysql_query("update tbl_school_admin sc set balance_blue_points = IF(balance_blue_points IS NULL,(select count(*) as c from tbl_student where school_id=sc.school_id AND group_member_id = '$group_id')*'$points',balance_blue_points + ((select count(*) as c from tbl_student where school_id=sc.school_id AND group_member_id = '$group_id')*'$points')) where group_member_id = '$group_id'");

			$log_details=mysql_query("INSERT INTO tbl_distribute_points_by_cookieadmin (assigned_by,points,point_color,entity_name,entity_id,date) select '$group_id' as grpid,(select count(*) as c from tbl_student where school_id=sc.school_id AND group_member_id = '$group_id')*'$points' as pts, '$point_type' as ptype,school_name,school_id,'$date' as date from tbl_school_admin sc where group_member_id = '$group_id' having (select count(*) as c from tbl_student where school_id=sc.school_id AND group_member_id = '$group_id' ) > 0");
		}
		/*else if(empty($teacher_id) && $entity_id==103)
		{
			$query=mysql_query("update tbl_teacher set $teacherset where group_member_id = '$group_id'");

			$log_details=mysql_query("INSERT INTO tbl_teacher_point (sc_teacher_id,sc_entities_id,assigner_id,sc_point,sc_thanqupointlist_id,point_type,point_date,school_id) select id,'131' as entity, '$group_id' as grpid,'$points' as pts,'' as thnq,'$point_type' as ptype,'$date' as date,school_id from tbl_teacher where group_member_id = '$group_id'");
		}
		else if(!empty($teacher_id) && $entity_id==103)
		{
			$query=mysql_query("update tbl_teacher set $teacherset where id='$teacher_id' AND group_member_id = '$group_id'");

			$log_details=mysql_query("INSERT INTO tbl_teacher_point (sc_teacher_id,sc_entities_id,assigner_id,sc_point,sc_thanqupointlist_id,point_type,point_date,school_id)values ('$teacher_id','131','$group_id','$points','','$point_type','$date','$school_id')");
		}
		else if(empty($student_id) && $entity_id==105)
		{
			$insert = mysql_query("INSERT INTO tbl_student_reward (Stud_Member_Id,sc_stud_id,school_id,group_member_id) select id,std_PRN,school_id,group_member_id from tbl_student s where group_member_id='$group_id' AND std_PRN NOT IN (select sc_stud_id from tbl_student_reward where school_id=s.school_id AND group_member_id='$group_id')");

			$query=mysql_query("update $stud_update_tbl set $studentset where group_member_id = '$group_id'");

			$log_details=mysql_query("INSERT INTO tbl_student_point (sc_stud_id,sc_entites_id,sc_point,point_date,reason,school_id,type_points,Stud_Member_Id,sc_teacher_id) select '$prn' as prn,'131' as entity,'$points' as pts,'$date' as date,'' as reason,,school_id,'$point_type' as ptype,'$student_id' as stud_mem,'$group_id' as grpid from tbl_school_admin where group_member_id = '$group_id')");
		}
		else if(!empty($student_id) && $entity_id==105)
		{
			$query=mysql_query("update $stud_update_tbl set $schoolset where $stud_where");
			$affected_rows = mysql_affected_rows();

			if($affected_rows == 0 && $point_type == 'Green')
			{
				$query=mysql_query("insert into tbl_student_reward (Stud_Member_Id,sc_stud_id,sc_total_point,sc_date,school_id) values ('$student_id','$prn','$points','$date','$school_id')");
			}

			$log_details=mysql_query("INSERT into tbl_student_point(sc_stud_id,sc_entites_id,sc_point,point_date,reason,school_id,type_points,Stud_Member_Id,sc_teacher_id)
							   VALUES('$prn','131','$points','$date','assigned by Group Admin','$school_id','$point_type','$student_id','$group_id')");
		}*/
		

		if($query)
		{
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="OK";
			//$postvalue['posts']=$posts;
			echo json_encode($postvalue);
		}
		else
		{
			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="Points could not assigned";
			echo json_encode($postvalue);
		}
	}
	else
	{
		$postvalue['responseStatus']=204;
		$postvalue['responseMessage']="Insufficient $point_type Points";
		echo json_encode($postvalue);
	}
}
else
{
	$postvalue['responseStatus']=1000;
	$postvalue['responseMessage']="Invalid Input";
	$postvalue['posts']=null;
	echo json_encode($postvalue); 
}