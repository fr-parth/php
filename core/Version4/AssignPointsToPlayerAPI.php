<?php 
/* 
Author : Pranali Dalvi
Date : 08-01-2019
This web service is created for assigning points to Player by Spectator   
*/
$json = file_get_contents('php://input');
$obj = json_decode($json);

include '../conn.php';
$format = 'json';

	$PlayerName=xss_clean(mysql_real_escape_string(@$obj->{'PlayerName'}));
	$PlayerNo=xss_clean(mysql_real_escape_string(@$obj->{'PlayerNo'}));
	$SportsName=xss_clean(mysql_real_escape_string(@$obj->{'SportsName'}));
	$Points=xss_clean(mysql_real_escape_string(@$obj->{'Points'}));
    //$mobile=xss_clean(mysql_real_escape_string(@$obj->{'mobile'}));
	
	$MemberID=xss_clean(mysql_real_escape_string($obj->{'MemberID'}));
	//MemberID added as i/p parameter by Pranali for SMC-3734 on 24-1-19
	
	if($PlayerName!='' and $Points!='' and $SportsName!='' and $MemberID!='')
	{
		
		$sql=mysql_query("SELECT total_points,reward_points,school_id 
		FROM tbl_vol_spect_master WHERE id='$MemberID'");
		
		$points=mysql_fetch_assoc($sql);
		$total_points=$points['total_points'];
		$reward_points=$points['reward_points'];
		$school_id=$points['school_id'];
		
			$sc_date=CURRENT_TIMESTAMP; //from core/securityfunctions.php
			//$school_id='KI2019';
		
			$prn=mysql_query("SELECT std_PRN FROM tbl_student where std_complete_name='$PlayerName' and school_id='$school_id'");
			$std_PRN=mysql_fetch_assoc($prn);
			$std_PRN1=$std_PRN['std_PRN'];
			
			if($std_PRN1=='')
			{
				
				$member_id=mysql_query("SELECT id,std_school_name FROM tbl_student where school_id='$school_id' order by id desc limit 1 offset 0"); 
				$member_id1=mysql_fetch_assoc($member_id);
				$memberID=$member_id1['id'];
				$schoolName=$member_id1['std_school_name'];
				
				//$schoolName='Khelo India 2019';
				$prn=$memberID+1;
				$PlayerName1=explode(' ',$PlayerName);
				
				$pwd=$PlayerName1[0]."123";
				$insert_student=mysql_query("INSERT INTO tbl_student(std_PRN,std_complete_name,std_school_name,school_id,upload_date,Roll_no,std_password) values ('$prn','$PlayerName','$schoolName','$school_id','$sc_date','$PlayerNo','$pwd')");
				
				$year=date('Y');
				
				$insert=mysql_query("INSERT INTO tbl_student_subject_master(ExtYearID,student_id,school_id,subjectName,AcademicYear,upload_date) values ('$year','$prn','$school_id','$SportsName','$year','$sc_date')");
				$std_PRN1=$prn; 
			}
			else
			{
				$insert_student=mysql_query("UPDATE tbl_student set Roll_no='$PlayerNo' WHERE std_PRN='$std_PRN1' and school_id='$school_id'");
			}
			
			$sql=mysql_query("select sc_total_point from `tbl_student_reward` where sc_stud_id='$std_PRN1' and school_id='$school_id'");
			$result1=mysql_fetch_assoc($sql);
			$balance_greenstud_points=$result1['sc_total_point'];
		 	$final_greenstud_points=$balance_greenstud_points+$Points; 
			
			if(mysql_num_rows($sql)==0)
			{
				$reward=mysql_query("INSERT INTO tbl_student_reward(`sc_total_point`,`sc_stud_id`,`sc_date`,`school_id`) VALUES ('$Points','$std_PRN1','$sc_date','$school_id')");
			}
			else
			{
				
				$reward=mysql_query("update tbl_student_reward set sc_total_point='$final_greenstud_points', sc_date='$sc_date' where sc_stud_id='$std_PRN1' and school_id='$school_id'");
			}
			if($reward)
			{
				
				$reward_points=$reward_points + 5;
				$updatePoints=mysql_query("UPDATE tbl_vol_spect_master SET total_points='$total_points', reward_points='$reward_points' WHERE id ='$MemberID'");
				
			}
			$postvalue['responseStatus'] = 200;
			$postvalue['responseMessage'] = "OK";
		
	}
	else{
		$postvalue['responseStatus'] = 1000;
        $postvalue['responseMessage'] = "Invalid Input";
	}
	 header('Content-type: application/json');
	echo json_encode($postvalue);
	
@mysql_close($con);
?>