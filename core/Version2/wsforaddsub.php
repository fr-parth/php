<?php
include 'conn.php';
$json = file_get_contents('php://input');
$obj = json_decode($json);
    error_reporting(0);
    $SubjectCode = xss_clean(mysql_real_escape_string($obj->{'Subject_Code'}));
	$school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
	$SubjectTitle = xss_clean(mysql_real_escape_string($obj->{'SubjectTitle'}));
	$DivisionName = xss_clean(mysql_real_escape_string($obj->{'DivisionName'}));
	$SemesterName = xss_clean(mysql_real_escape_string($obj->{'Semester_id'}));
	$t_id= xss_clean(mysql_real_escape_string($obj->{'t_id'}));
	$BranchName = xss_clean(mysql_real_escape_string($obj->{'BranchName'}));
	$DeptName = xss_clean(mysql_real_escape_string($obj->{'DeptName'}));
	$CourseLevel = xss_clean(mysql_real_escape_string($obj->{'Course_Level_PID'}));
	$Year = xss_clean(mysql_real_escape_string($obj->{'year'}));	


  $number_of_posts = xss_clean(mysql_real_escape_string(isset($_GET['num']))) ? xss_clean(mysql_real_escape_string(intval($_GET['num']))) : 10; //10 is the default
  $format = 'json';

 if($SubjectCode!=='' && $school_id!==''&& $SubjectTitle!==''&& $DivisionName !==''&& $SemesterName!==''&&$t_id!==''&& $BranchName!==''&& $DeptName!==''&& $CourseLevel!==''&& $Year!=='')
	{
             $insertsoftreward=mysql_query("insert into tbl_teacher_subject_master (school_id,teacher_id,subjcet_code,subjectName,Division_id,Semester_id,Branches_id,Department_id,CourseLevel,AcademicYear)
			values('$school_id','$t_id','$SubjectCode','$SubjectTitle','$DivisionName','$SemesterName','$BranchName','$DeptName','$CourseLevel','$Year')");
			                
       		  if(mysql_affected_rows()>0)
			 {
						
				$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="subject added successfully.";
				$postvalue['posts']=null;
				 header('Content-type: application/json');
				 echo json_encode($postvalue);
			 
			 }

			else
			{
				$postvalue['responseStatus']=204;
				$postvalue['responseMessage']="No Response";
				$postvalue['posts']=null;
				 header('Content-type: application/json');
				 echo json_encode($postvalue);

			}         
	}
	else
	{

		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']="Invalid Input";
		$postvalue['posts']=null;

		 header('Content-type: application/json');
		echo  json_encode($postvalue);


	}


  @mysql_close($con);

?>