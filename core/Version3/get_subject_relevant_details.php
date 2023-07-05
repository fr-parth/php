<?php
/*
 *Created by Shivkumar on 2018-12-12
 *@file - webservice for student/teacher to display subject of relevant details
 *common functions are defined in /core/securityfunctions.php file
 */
 include '../conn.php';
 header('Content-type: application/json');
 $json = file_get_contents('php://input');
 $obj = json_decode($json);

 $stud_member_id = xss_clean(mysql_real_escape_string($obj->{'stud_member_id'}));
 $school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
 $std_prn = xss_clean(mysql_real_escape_string($obj->{'std_prn'}));
 $type = xss_clean(mysql_real_escape_string($obj->{'type'}));
 $department = xss_clean(mysql_real_escape_string($obj->{'department'}));
 $courseLevel = xss_clean(mysql_real_escape_string($obj->{'courseLevel'}));
 $branch = xss_clean(mysql_real_escape_string($obj->{'branch'}));
 $division = xss_clean(mysql_real_escape_string($obj->{'division'}));
 $semester = xss_clean(mysql_real_escape_string($obj->{'semester'}));
 //$year = xss_clean(mysql_real_escape_string($obj->{'year'})); //commented by Pranali as no year should be taken from Android/ IOS side

if(!empty($stud_member_id) && !empty($type) && !empty($school_id))
{
	//below query modified (join taken on tbl_academic_Year) and $year taken by Pranali for getting only current year's student data for SMC-3702 on 2-5-19
	//!=null and !='null' and !empty() added by Pranali in below if conditions for SMC-3702 on 15-5-19
	 $res = mysql_query("select s.id,s.school_id,s.std_PRN,s.std_branch,s.std_dept,s.std_year,s.std_semester,s.std_div,s.Course_level ,ay.Academic_Year,ay.Year,ay.ExtYearID
	 from tbl_student s
	 left join tbl_academic_Year ay on s.school_id=ay.school_id
	 where s.id = '$stud_member_id' and s.school_id='$school_id' and ay.Enable='1'");
	 
	 $count1 = mysql_num_rows($res);
	 $posts1 = mysql_fetch_assoc($res);
	 $year = $posts1['Year'];
	 $ExtYearID = $posts1['ExtYearID'];

	  	if($type == "department")
		{
			$res = mysql_query("select distinct DeptName from Branch_Subject_Division_Year where school_id = '$school_id'");
			$count = mysql_num_rows($res);

				if($count1>0 && !empty($posts1['std_dept']) && $posts1['std_dept']!=null && $posts1['std_dept']!='null')
				{
					
					$posts[0] = array("DeptName"=>$posts1['std_dept']);
				}
				else if($count>0){
					
					while($post = mysql_fetch_assoc($res))
					{
				
						$posts[] = array_map(clean_string,$post);
					}
				}
		}
		else if($type == "courseLevel" && !empty($department))
		{
			$res = mysql_query("select distinct CourseLevel from Branch_Subject_Division_Year where school_id = '$school_id' AND DeptName='$department'");
			$count = mysql_num_rows($res);
			
			if($count1>0 && !empty($posts1['Course_level']) && $posts1['Course_level']!=null && $posts1['Course_level']!='null')
			{
					$posts[0] = array("CourseLevel"=>$posts1['Course_level']);
			}
			else if($count>0){
				while($post = mysql_fetch_assoc($res))
				{
					
						$posts[] = array_map(clean_string,$post);
				}
			}
		}
		else if($type == "branch" && !empty($department) && !empty($courseLevel))
		{
			$res = mysql_query("select distinct BranchName from Branch_Subject_Division_Year where school_id = '$school_id' AND DeptName='$department' AND CourseLevel='$courseLevel'");
			$count = mysql_num_rows($res);

			if($count1>0 && !empty($posts1['std_branch']) && $posts1['std_branch']!=null && $posts1['std_branch']!='null') 
			{
					$posts[0] = array("BranchName"=>$posts1['std_branch']);
			}
			else if($count>0){
				while($post = mysql_fetch_assoc($res))
				{
					
						$posts[] = array_map(clean_string,$post);
				}
			}
		}
		else if($type == "division" && !empty($department) && !empty($courseLevel) && !empty($branch))
		{			
			$res = mysql_query("select distinct DivisionName from Branch_Subject_Division_Year where school_id = '$school_id' AND DeptName='$department' AND CourseLevel='$courseLevel' AND BranchName='$branch'");
			$count = mysql_num_rows($res);

			if($count1>0 && !empty($posts1['std_div']) && $posts1['std_div']!=null && $posts1['std_div']!='null')
			{
					$posts[0] = array("DivisionName"=>$posts1['std_div']);
			}
			else if($count>0){
				while($post = mysql_fetch_assoc($res))
				{
					
						$posts[] = array_map(clean_string,$post);
				}
			}
		}
		else if($type == "semester" && !empty($department) && !empty($courseLevel) && !empty($branch) && !empty($division))
		{
			$res = mysql_query("select distinct SemesterName from Branch_Subject_Division_Year where school_id = '$school_id' AND DeptName='$department' AND CourseLevel='$courseLevel' AND BranchName='$branch' AND DivisionName='$division'");
			$count = mysql_num_rows($res);

			if($count1>0 && !empty($posts1['std_semester']) && $posts1['std_semester']!=null && $posts1['std_semester']!='null')
			{
				$posts[0] = array("SemesterName"=>$posts1['std_semester']);
			}
			else if($count>0){
				while($post = mysql_fetch_assoc($res))
				{
					
						$posts[] = array_map(clean_string,$post);
				}
			}
		}
		//commented below condition for year not to be given in o/p as discussed with Priyanka by Pranali for SMC-3702 on 2-5-19
		/*else if($type == "year" && !empty($department) && !empty($courseLevel) && !empty($branch) && !empty($division) && !empty($semester))
		{
			$res = mysql_query("select distinct Year from Branch_Subject_Division_Year where school_id = '$school_id' AND DeptName='$department' AND CourseLevel='$courseLevel' AND BranchName='$branch' AND DivisionName='$division' AND SemesterName='$semester'");
			$count = mysql_num_rows($res);

			while($post = mysql_fetch_assoc($res))
			{
				$posts[0] = array("Year"=>$posts1['std_year']);
				$posts[] = array_map(clean_string,$post);
			}
		}*/

		else if($type == "subject" && !empty($department) && !empty($courseLevel) && !empty($branch) && !empty($division) && !empty($semester) && !empty($year))
		{ //added OR Year='$ExtYearID' condition by Pranali for SMC-5071
			$res = mysql_query("select SubjectCode,SubjectTitle from Branch_Subject_Division_Year where school_id = '$school_id' AND DeptName='$department' AND CourseLevel='$courseLevel' AND BranchName='$branch' AND DivisionName='$division' AND SemesterName='$semester' AND (Year='$year' OR Year='$ExtYearID')");
			$count = mysql_num_rows($res);
			//Added below if condition for matching id values by Pranali for SMC-5091
			if($count==0){
				$res = mysql_query("select SubjectCode,SubjectTitle from Branch_Subject_Division_Year where school_id = '$school_id' AND DeptID='$department' AND CourseLevelPID='$courseLevel' AND BranchID='$branch' AND DevisionId='$division' AND SemesterID='$semester' AND (Year='$year' OR Year='$ExtYearID')");
				$count = mysql_num_rows($res);
			}
	
			while($post = mysql_fetch_assoc($res))
			{
				$posts[] = array_map(clean_string,$post);
			}
		}
		
		if($count > 0 || $count1 > 0)
		{
			$postvalue['responseStatus']=200;
			$postvalue['responseMessage']="Ok";
			$postvalue['posts']=$posts;
			echo json_encode($postvalue);	
		}
		else 
		{
			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="No $type found!";
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
