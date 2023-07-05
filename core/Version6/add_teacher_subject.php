<?php  
/*
 * @file to add new subject from teacher 
 * created by Shivkumar (SMC-3596)
 * created on 2018-10-18
 * modified on 2019-04-23 to add validation for already added teacher and student subject
 */
include '../conn.php';
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

			$sub_code=mysql_query("SELECT Subject_Code FROM tbl_school_subject where subject='$subjectName' and school_id='$school_id'");
			$result=mysql_fetch_assoc($sub_code);
		    $subjectCode=$result['Subject_Code'];
			if($subjectCode!="")
			{
				//Academic year selected from table & inserted in tbl_student_subject_master by Pranali for SMC-3720 on 24-12-2018
			/*	$sql1 = mysql_query("SELECT std_year FROM tbl_student WHERE id='$user_id'");
				$result = mysql_fetch_assoc($sql1);
				$std_year = $result['std_year']; */

				$AcademicYear=mysql_query("SELECT Year,Academic_Year from tbl_academic_Year where school_id='$school_id' and Year='$year'");
				$AcademicYear1=mysql_fetch_assoc($AcademicYear);
				$std_year=$AcademicYear1['Academic_Year'];
			

			//below validation for add student subject added by Pranali for SMC-3833 on 23-4-19
			
			$subject = mysql_query("SELECT student_id,school_id,subjcet_code,subjectName 
			FROM tbl_student_subject_master 
			WHERE  student_id='".$student_id."' and school_id='".$school_id."' and subjcet_code='".$subjectCode."' and subjectName='".$subjectName."' and Division_id='".$Division_id."' and Semester_id='".$Semester_id."' and Branches_id='".$Branches_id."' and Department_id='".$Department_id."' and CourseLevel='".$CourseLevel."' and AcademicYear='".$std_year."'");

			$subject_count = mysql_num_rows($subject);

			if($subject_count == 0)
			{
				$query = mysql_query("INSERT INTO tbl_student_subject_master (Stud_Member_Id,Teacher_Member_Id,student_id,teacher_ID,school_id,subjcet_code,subjectName,Division_id,Semester_id,Branches_id,Department_id,CourseLevel,AcademicYear,upload_date,uploaded_by) VALUES ('$user_id','$teacher_member_id','$student_id','$t_id','$school_id','$subjectCode','$subjectName','$Division_id','$Semester_id','$Branches_id','$Department_id','$CourseLevel','$std_year',CURRENT_TIMESTAMP,'Student $user_id')");
			
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
			else{
				$postvalue['responseStatus']=409;
				$postvalue['responseMessage']="Subject already exists";
				echo json_encode($postvalue);
				exit;
			}

		}
		else
		{
			$postvalue['responseStatus']=1000;
			$postvalue['responseMessage']="Invalid Input";
			echo json_encode($postvalue);
			exit;
		}

			
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
				$AcademicYear=mysql_query("SELECT Year,Academic_Year from tbl_academic_Year where school_id='$school_id' and Year='$year'");
				$AcademicYear1=mysql_fetch_assoc($AcademicYear);
				$t_academic_year=$AcademicYear1['Academic_Year'];
			}
		//below validation for add teacher subject added by Pranali for SMC-3833 on 23-4-19
			$subject = mysql_query("SELECT Teacher_Member_Id, teacher_id, school_id,subjcet_code 
			FROM tbl_teacher_subject_master 
			WHERE  teacher_id='".$t_id."' and school_id='".$school_id."' and subjcet_code='".$subjectCode."' and subjectName='".$subjectName."' and Division_id='".$Division_id."' and Semester_id='".$Semester_id."' and Branches_id='".$Branches_id."' and Department_id='".$Department_id."' and CourseLevel='".$CourseLevel."' and AcademicYear='".$t_academic_year."'");

			$subject_count = mysql_num_rows($subject);

			if($subject_count == 0)
			{
				$query = mysql_query("INSERT INTO tbl_teacher_subject_master (Teacher_Member_Id,teacher_id,school_id,subjcet_code,subjectName,Division_id,Semester_id,Branches_id,Department_id,CourseLevel,AcademicYear,upload_date,uploaded_by) VALUES ('$user_id','$t_id','$school_id','$subjectCode','$subjectName','$Division_id','$Semester_id','$Branches_id','$Department_id','$CourseLevel','$t_academic_year',CURRENT_TIMESTAMP,'Teacher $user_id')");
			
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
			else{
				$postvalue['responseStatus']=409;
				$postvalue['responseMessage']="Subject already exists";
				echo json_encode($postvalue);
				exit;
			}
			//end code for SMC-3833
		}

	
	  
	}

			
?>