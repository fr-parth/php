<?php  
/*
 * @file to delete subject from teacher & student 
 * created by Madhuri (SMC-5483)
 * created on 2021-08-05

 */

include '../conn.php';
$json = file_get_contents('php://input');
$obj = json_decode($json);
header('Content-type: application/json');
 
 $entity_id = xss_clean(mysql_real_escape_string($obj->{'entity_id'}));
 //$user_id	= xss_clean(mysql_real_escape_string($obj->{'user_id'}));
 $t_id		= xss_clean(mysql_real_escape_string($obj->{'teacher_id'}));
 //$teacher_member_id		= xss_clean(mysql_real_escape_string($obj->{'member_id'}));
 $std_PRN		= xss_clean(mysql_real_escape_string($obj->{'student_id'}));
 $school_id	= xss_clean(mysql_real_escape_string($obj->{'school_id'}));
 $SubjectCode	= xss_clean(mysql_real_escape_string($obj->{'subjcet_code'}));
 $mysubject 	= explode(',',$subject);
 $subjectName	= $mysubject[0];
 $subjectCode	= $mysubject[1];
 $departmentId	= xss_clean(mysql_real_escape_string($obj->{'Department_id'}));

 $semesterName	= xss_clean(addslashes($obj->{'Semester_id'}));
 $year		= xss_clean(addslashes($obj->{'year'}));
 $CourseLevel	= xss_clean(addslashes($obj->{'CourseLevel'}));
 $Branches_id	= xss_clean(mysql_real_escape_string($obj->{'Branches_id'}));
 $divisionId	= xss_clean(addslashes($obj->{'Division_id'}));
 $Year = xss_clean(addslashes($obj->{'AcademicYear'}));
 

	if(empty($entity_id) || empty($school_id) || empty($SubjectCode) || empty($departmentId) || empty($semesterName) || empty($divisionId) )
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

			
			
			
			$subject = mysql_query("SELECT student_id,school_id,subjcet_code,subjectName 
			FROM tbl_student_subject_master 
			WHERE  student_id='".$std_PRN."' and school_id='".$school_id."' and subjcet_code='".$SubjectCode."' and Division_id='".$divisionId."' and Semester_id='".$semesterName."' and Branches_id='".$Branches_id."' and Department_id='".$departmentId."' and AcademicYear='".$Year."'");
			

			$subject_count = mysql_num_rows($subject);

			if($subject_count > 0)
			{
				$query = mysql_query("DELETE  
			FROM tbl_student_subject_master 
			WHERE  student_id='".$std_PRN."' and school_id='".$school_id."' and subjcet_code='".$SubjectCode."' and Division_id='".$divisionId."' and Semester_id='".$semesterName."' and Branches_id='".$Branches_id."' and Department_id='".$departmentId."' and AcademicYear='".$Year."'");
				
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
				$postvalue['responseMessage']="Subject does not exists";
				echo json_encode($postvalue);
				exit;
			}

		

			
		}
		else
		{
			
		
			$subject = mysql_query("SELECT Teacher_Member_Id, teacher_id, school_id,subjcet_code
			FROM tbl_teacher_subject_master 
			WHERE teacher_id='".$t_id."' and school_id='".$school_id."' and subjcet_code='".$SubjectCode."' and Division_id='".$divisionId."' and Semester_id='".$semesterName."' and CourseLevel='".$CourseLevel."' and Department_id='".$departmentId."' and AcademicYear='".$Year."'");
			

			$subject_count = mysql_num_rows($subject);

			if($subject_count > 0)
			{
				$query = mysql_query("DELETE 
			FROM tbl_teacher_subject_master 
			WHERE teacher_id='".$t_id."' and school_id='".$school_id."' and subjcet_code='".$SubjectCode."' and Division_id='".$divisionId."' and Semester_id='".$semesterName."' and CourseLevel='".$CourseLevel."' and Department_id='".$departmentId."' and AcademicYear='".$Year."'");

		
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
				$postvalue['responseMessage']="Subject1 does not exists";
				echo json_encode($postvalue);
				exit;
			}
			//end code for SMC-5483
		}

	
	  
	}

			
?>



	
			
		