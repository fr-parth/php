<?php  
/*
 * @file to add new subject from teacher 
 * created by Shivkumar (SMC-3596)
 * created on 2018-10-18
 * modified on 2018-11-13 to add student subject
 */
include('conn.php');
$json = file_get_contents('php://input');
$obj = json_decode($json);
header('Content-type: application/json');
 
 $entity_id = xss_clean(mysql_real_escape_string($obj->{'entity_id'}));
 $user_id	= xss_clean(mysql_real_escape_string($obj->{'user_id'}));
 $t_id		= xss_clean(mysql_real_escape_string($obj->{'t_id'}));
 $teacher_member_id		= xss_clean(mysql_real_escape_string($obj->{'member_id'}));
 $student_id		= xss_clean(mysql_real_escape_string($obj->{'student_id'}));
 $school_id	= xss_clean(mysql_real_escape_string($obj->{'school_id'}));
 $subject	= xss_clean(mysql_real_escape_string($obj->{'subjcet_code'}));
 $mysubject 	= explode(',',$subject);
 $subjectName	= $mysubject[0];
 $subjectCode	= $mysubject[1];
 $Department_id	= xss_clean(addslashes($obj->{'Department_id'}));
 $Semester_id	= xss_clean(addslashes($obj->{'Semester_id'}));
 $year		= xss_clean(addslashes($obj->{'year'}));
 $CourseLevel	= xss_clean(addslashes($obj->{'CourseLevel'}));
 $Branches_id	= xss_clean(addslashes($obj->{'Branches_id'}));
 $Division_id	= xss_clean(addslashes($obj->{'Division_id'}));
	 

	if(empty($user_id) || empty($school_id) || empty($subject) || empty($Department_id) || empty($Semester_id) || empty($CourseLevel) || empty($Branches_id) || empty($Division_id) )
	{
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']="Invalid Input";
		$postvalue['posts']=null;
		echo json_encode($postvalue);
	}
	else 
	{
		if($entity_id == '105')
		{
			
				//Academic year selected from table & inserted in tbl_student_subject_master by Pranali for SMC-3720 on 24-12-2018
				$sql1 = mysql_query("SELECT std_year FROM tbl_student WHERE id='$user_id'");
				$result = mysql_fetch_assoc($sql1);
				$std_year = $result['std_year'];
				if($std_year=='')
			{
				$AcademicYear=mysql_query("SELECT Year from tbl_academic_Year where school_id='$school_id' and Enable='1'");
				$AcademicYear1=mysql_fetch_assoc($AcademicYear);
				$std_year=$AcademicYear1['Year'];
			}
			$query = mysql_query("INSERT INTO tbl_student_subject_master (Stud_Member_Id,Teacher_Member_Id,student_id,teacher_ID,school_id,subjcet_code,subjectName,Division_id,Semester_id,Branches_id,Department_id,CourseLevel,AcademicYear,upload_date,uploaded_by) VALUES ('$user_id','$teacher_member_id','$student_id','$t_id','$school_id','$subjectCode','$subjectName','$Division_id','$Semester_id','$Branches_id','$Department_id','$CourseLevel','$std_year',CURRENT_TIMESTAMP,'Student $user_id')");
		}
		else
		{
			//Academic year selected from table & inserted in tbl_student_subject_master by Pranali for SMC-3720 on 24-12-2018
			
				$sql1 = mysql_query("SELECT t_academic_year FROM tbl_teacher WHERE id='$user_id'");
				$result = mysql_fetch_assoc($sql1);
				$t_academic_year = $result['t_academic_year'];
			//below if added for entry of year from academic year when it is blank from teacher table  4-3-19 
			if($t_academic_year=='')
			{
				$AcademicYear=mysql_query("SELECT Year from tbl_academic_Year where school_id='$school_id' and Enable='1'");
				$AcademicYear1=mysql_fetch_assoc($AcademicYear);
				$t_academic_year=$AcademicYear1['Year'];
			}
			$query = mysql_query("INSERT INTO tbl_teacher_subject_master (Teacher_Member_Id,teacher_id,school_id,subjcet_code,subjectName,Division_id,Semester_id,Branches_id,Department_id,CourseLevel,AcademicYear,upload_date,uploaded_by) VALUES ('$user_id','$t_id','$school_id','$subjectCode','$subjectName','$Division_id','$Semester_id','$Branches_id','$Department_id','$CourseLevel','$t_academic_year',CURRENT_TIMESTAMP,'Teacher $user_id')");
		}

	  if($query)
	  {
			 $postvalue['responseStatus']=200;
			 $postvalue['responseMessage']="OK";
			 echo json_encode($postvalue);
	  }
	  else
	  {
			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="Subject could not be added";
			echo json_encode($postvalue);
	  }
	  
	}

			
?>