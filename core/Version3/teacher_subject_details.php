<?php
include '../conn.php';
header('Content-Type: application/json');
$json = file_get_contents('php://input');
$obj = json_decode($json);   
//print_r($obj);exit;
error_reporting(0);
$school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
 $entity_id = xss_clean(mysql_real_escape_string($obj->{'entity_id'}));

 $subject	= xss_clean(mysql_real_escape_string($obj->{'subjcet_code'}));
$mysubject 	= explode(',',$subject);
  $subjectName	= $mysubject[0];
  $subjectCode	= $mysubject[1];
  $department = xss_clean(mysql_real_escape_string($obj->{'Department_id'}));
 $courseLevel = xss_clean(mysql_real_escape_string($obj->{'CourseLevel'}));
 $semester = xss_clean(mysql_real_escape_string($obj->{'Semester_id'}));
 $year = xss_clean(mysql_real_escape_string($obj->{'year'}));
 $division = xss_clean(mysql_real_escape_string($obj->{'Division_id'}));
$branch = xss_clean(mysql_real_escape_string($obj->{'Branches_id'}));
$all_data = xss_clean(mysql_real_escape_string($obj->{'all_data'}));

$relevant_data = xss_clean(mysql_real_escape_string($obj->{'relevant_data'}));

//clean_string function called from securityfunctions.php file

//////////// *****Validation for Empty****** ////////
	
	if(empty($school_id))
	{
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']="Invalid Input";
		$postvalue['posts']=null;
		echo json_encode($postvalue);
	}
	else if(!empty($school_id) && !empty($subjectCode) && !empty($department) && !empty($courseLevel) && !empty($semester) && !empty($year) /*&& !empty($division)*/ && !empty($branch) && $entity_id == '105')
	{
			$teacher = mysql_query("select t.id,t.t_id,ucwords(t.t_complete_name) as t_complete_name,ucwords(t.t_name) as t_name,ucwords(t.t_middlename) as t_middlename,ucwords(t.t_lastname) as t_lastname from tbl_teacher_subject_master as ts right join tbl_teacher as t 
		on  ts.teacher_id=t.t_id where ts.school_id = '$school_id' AND ts.subjcet_code='$subjectCode' AND ts.Department_id='$department' AND ts.CourseLevel='$courseLevel' AND ts.Semester_id='$semester' AND ts.AcademicYear='$year' AND ts.Branches_id='$branch'");
		
		/*if(!empty($obj->{'all_data'}))
		{
			echo "select t.id,t.t_id,ucwords(t.t_complete_name) as t_complete_name,ucwords(t.t_name) as t_name,ucwords(t.t_middlename) as t_middlename,ucwords(t.t_lastname) as t_lastname from tbl_teacher_subject_master as ts right join tbl_teacher as t 
		on  ts.teacher_id=t.t_id where ts.school_id = '$school_id' AND ts.subjcet_code='$subjectCode' AND ts.Department_id='$department' AND ts.CourseLevel='$courseLevel' AND ts.Semester_id='$semester' AND ts.AcademicYear='$year' AND ts.Branches_id='$branch'";exit;
			$teacher = mysql_query("select t.id,t.t_id,ucwords(t.t_complete_name) as t_complete_name,ucwords(t.t_name) as t_name,ucwords(t.t_middlename) as t_middlename,ucwords(t.t_lastname) as t_lastname from tbl_teacher_subject_master as ts right join tbl_teacher as t 
		on  ts.teacher_id=t.t_id where ts.school_id = '$school_id' AND ts.subjcet_code='$subjectCode' AND ts.Department_id='$department' AND ts.CourseLevel='$courseLevel' AND ts.Semester_id='$semester' AND ts.AcademicYear='$year' AND ts.Branches_id='$branch'");
		}
		if(!empty($obj->{'relevant_data'}))
		{
			$teacher = mysql_query("select t.id,t.t_id,ucwords(t.t_complete_name) as t_complete_name,ucwords(t.t_name) as t_name,ucwords(t.t_middlename) as t_middlename,ucwords(t.t_lastname) as t_lastname from tbl_teacher_subject_master as ts right join tbl_teacher as t 
		on  ts.teacher_id=t.t_id where ts.school_id = '$school_id' AND ts.subjcet_code='$subjectCode' AND ts.Department_id='$department' AND ts.CourseLevel='$courseLevel' AND ts.Semester_id='$semester' AND ts.AcademicYear='$year' AND ts.Division_id ='$division' AND ts.Branches_id='$branch'");
		}*/
		$count = mysql_num_rows($teacher);
		if($count > 0)
		{  
			while($post = mysql_fetch_assoc($teacher))
			{
				$member_id = $post['id'];
				$t_id = $post['t_id'];
				$teacher_name = isset($post['t_complete_name']) ? $post['t_complete_name'] : $post['t_name'].' '.$post['t_middlename'].' '.$post['t_lastname'];
				$posts[] = array('member_id'=>$member_id,'t_id'=>trim($t_id),'teacher_name'=>trim($teacher_name));
			}
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="OK";
			$postvalue['posts']=$posts;
			echo json_encode($postvalue);
		}
		else
		{
			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="No Teacher Found";
			$postvalue['posts']=null;	
			echo json_encode($postvalue);
		}
	}
	else
	{
		//get school's all subject
		$sub = mysql_query("select id,subject,Subject_Code from tbl_school_subject where school_id = '$school_id' and subject!=''");
//distinct added in below queries by Pranali for SMC-3778 on 19-2-19
		while($row = mysql_fetch_assoc($sub))
		{
			$id=$row['id'];
			 $subject = $row['subject']; 
			 $Subject_Code=$row['Subject_Code'];
			 $Subject_type = $row['Subject_type'];
			$subjects[] =array('id'=>$id,'subject'=>$subject,'Subject_Code'=>$Subject_Code,'Subject_type'=>$Subject_type);
			//$subjects[] = array_map(clean_string,$row);
		}

		//get school's all departments
		$dept = mysql_query("select distinct(Dept_Name) from tbl_department_master where school_id = '$school_id'");
	
		while($row = mysql_fetch_assoc($dept))
		{
			$departments[] = array_map(clean_string,$row);
		}

		//get school's all Course Levels
		$course = mysql_query("select distinct(CourseLevel) from tbl_CourseLevel where school_id = '$school_id'");
	
		while($row = mysql_fetch_assoc($course))
		{
			$CourseLevel[] = array_map(clean_string,$row);
		}

		//get school's all Semester Name
		$sem = mysql_query("select distinct(Semester_Name),ExtSemesterId from tbl_semester_master where school_id = '$school_id'");
	
		while($row = mysql_fetch_assoc($sem))
		{
			$semesters[] = array_map(clean_string,$row);
		}

		//get school's all Year
		//Added Academic_Year,ExtYearID in below query by Prranali for SMC-5071
		$year = mysql_query("select distinct(Year),Academic_Year,ExtYearID from tbl_academic_Year where school_id = '$school_id'");
	
		while($row = mysql_fetch_assoc($year))
		{
			$years[] = array_map(clean_string,$row);
		}

		//get school's all Division
		$div = mysql_query("select distinct(DivisionName) from Division where school_id = '$school_id' ");
	
		while($row = mysql_fetch_assoc($div))
		{
			$divisions[] = array_map(clean_string,$row);
		}

		//get school's all Branches
		$branch = mysql_query("select distinct(branch_Name), ExtBranchId from tbl_branch_master where school_id = '$school_id' ");
	
		while($row = mysql_fetch_assoc($branch))
		{
			$branches[] = array_map(clean_string,$row);
		}

		$postvalue['responseStatus']=200;
		$postvalue['responseMessage']="Ok";
		$postvalue['subjects']=$subjects;
		$postvalue['departments']=$departments;
		$postvalue['courseLevel']=$CourseLevel;
		$postvalue['semesters']=$semesters;
		$postvalue['years']=$years;
		$postvalue['divisions']=$divisions;
		$postvalue['branches']=$branches;
		echo json_encode($postvalue);
	}


@mysql_close($con);