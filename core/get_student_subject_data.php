<?php
/*
Author : Pranali Dalvi
Date : 31/12/20
This file was created for getting data for adding student subject
*/
ob_end_clean();
include("conn.php");
//Added below ternary condition for school id by Pranali for SMC-5091
$school_id = ($_SESSION['school_id']!='') ? $_SESSION['school_id'] : $_POST['school_id'];
$course_level = $_POST['course_level'];
$Dept_Name = $_POST['Dept_Name'];
$subjectCode = $_POST['subjectCode'];
$semester = $_POST['semester'];
$year = $_POST['year'];
$division = $_POST['division'];
$branch = $_POST['branch'];
$stud_prn = $_POST['stud_prn'];
//join taken on tbl_academic_Year by Pranali for SMC-5071
//join taken on tbl_department_master by Pranali for SMC-5071 on 30-1-21

$mem_id = mysql_query("SELECT d.Dept_Name as std_dept,s.Course_level,s.std_branch,s.std_year,s.Academic_Year,s.std_semester,s.std_div,s.id ,a.Academic_Year,a.Year,a.ExtYearID, s.std_dept as ExtDeptId, s.ExtBranchId, s.ExtSemesterId,d.ExtDeptId as dept_ExtDeptId
FROM tbl_student s 
left join tbl_academic_Year a on s.school_id=a.school_id and (s.std_year=a.Year or s.Academic_Year=a.Academic_Year)
 left join tbl_department_master d on (s.std_dept = d.ExtDeptId or s.std_dept=d.Dept_Name) and s.school_id = d.School_ID
where s.std_PRN='".$stud_prn."' and s.school_id='".$school_id."' and a.Enable=1"); /*and a.Enable=1*/
$res = mysql_fetch_array($mem_id);
$stud_member_id = $res['id'];
//print_r($res);exit;
$output="";

$url = $GLOBALS['URLNAME']."/core/Version3/teacher_subject_details.php";
$url_rel = $GLOBALS['URLNAME']."/core/Version3/get_subject_relevant_details.php";
//add space
switch ($_POST['fn_name']) {
	case 'teacher_name': //echo "1";exit;	
		//$subjectCode1=explode(',',$subjectCode);

		$data = array("school_id"=>$school_id, "entity_id"=>"105", "subjcet_code"=>$subjectCode, "Department_id"=>$Dept_Name, "CourseLevel"=>$course_level, "Semester_id"=>$semester,"year"=>$year, "Division_id"=>$division, "Branches_id"=>$branch);
		//print_r($data);exit;
		$ch = curl_init($url);             
		$data_string = json_encode($data);    
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
		$teacher_det = json_decode(curl_exec($ch),true); 

		//print_r($teacher_det);exit;
		//echo "hi";exit;
		
		/*$teacher = mysql_query("select * from tbl_teacher_subject_master AS ts right join tbl_teacher as t on ts.teacher_id=t.t_id where ts.school_id = '$school_id' AND ts.subjcet_code='$subjectCode1[1]' AND ts.Department_id='$Dept_Name' AND ts.CourseLevel='$course_level' AND ts.Semester_id='$semester' AND ts.AcademicYear='$year' AND ts.Branches_id='$branch'");
		$count = mysql_num_rows($teacher);
		//print_r($count);exit;
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
			echo $postvalue;
		}
		else
		{
			$postvalue['responseStatus']=204;
			$postvalue['responseMessage']="No Teacher Found";
			$postvalue['posts']=null;	
			echo $postvalue;
		}
		$teacher_det = $postvalue; */
		//echo $teacher_det['posts'];exit;
		//print_r($teacher_det['posts']);
      $output .= '<option value=""> Select Teacher</option>';
      foreach($teacher_det['posts'] as $result_teacher)
			{
				//print_r($result_teacher);exit;			 	
				$output .=	'<option value="'.$result_teacher["t_id"].'"> '.$result_teacher["teacher_name"].'</option> ';
				
			}
		echo $output;
		break;

	case 'department':

		$data = array("school_id"=>$school_id, "type"=>"department", "stud_member_id"=>$stud_member_id);
		$ch = curl_init($url_rel);             
		$data_string = json_encode($data);    
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
		$dept_det = json_decode(curl_exec($ch),true); 
     
      
      $output .= '<option value=""> Select Department</option>';
      foreach($dept_det['posts'] as $dept)
			{
							 	
				$output .=	'<option value="'.$dept["DeptName"].'"> '.$dept["DeptName"].'</option> ';
				
			}
			echo $output;
		break;

	case 'course_level':

		$data = array("school_id"=>$school_id, "type"=>"courseLevel", "stud_member_id"=>$stud_member_id, "department"=>$Dept_Name);
		
		$ch = curl_init($url_rel);             
		$data_string = json_encode($data);    
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
		$cl_det = json_decode(curl_exec($ch),true); 
           
      	$output .= '<option value=""> Select Course Level</option>';
      	foreach($cl_det['posts'] as $cl)
			{
							 	
				$output .=	'<option value="'.$cl["CourseLevel"].'"> '.$cl["CourseLevel"].'</option> ';
				
			}
			echo $output;
		break;

	case 'branch':

		$data = array("school_id"=>$school_id, "type"=>"branch", "stud_member_id"=>$stud_member_id, "department"=>$Dept_Name, "courseLevel"=>$course_level);
		
		$ch = curl_init($url_rel);             
		$data_string = json_encode($data);    
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
		$br_det = json_decode(curl_exec($ch),true); 
           
      	$output .= '<option value=""> Select Branch</option>';
      	foreach($br_det['posts'] as $branch)
			{
							 	
				$output .=	'<option value="'.$branch["BranchName"].'"> '.$branch["BranchName"].'</option> ';
				
			}
			echo $output;
		break;	

	case 'division':

		$data = array("school_id"=>$school_id, "type"=>"division", "stud_member_id"=>$stud_member_id, "department"=>$Dept_Name, "courseLevel"=>$course_level, "branch"=>$branch);
		
		$ch = curl_init($url_rel);             
		$data_string = json_encode($data);    
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
		$div_det = json_decode(curl_exec($ch),true); 
           
      	$output .= '<option value=""> Select Division</option>';
      	foreach($div_det['posts'] as $division)
			{
				$sql_div=mysql_query("select ExtDivisionID from Division where school_id='$school_id' and DivisionName='".$division['DivisionName']."' ");

			 	$result_div1=mysql_fetch_array($sql_div);			 	
				$output .=	'<option value="'.$result_div1["ExtDivisionID"].','.$division["DivisionName"].'"> '.$division["DivisionName"].'</option> ';
				
			}
			echo $output;
		break;	

	case 'semester':

		$data = array("school_id"=>$school_id, "type"=>"semester", "stud_member_id"=>$stud_member_id, "department"=>$Dept_Name, "courseLevel"=>$course_level, "branch"=>$branch, "division"=>$division);
		
		$ch = curl_init($url_rel);             
		$data_string = json_encode($data);    
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
		$sem_det = json_decode(curl_exec($ch),true); 
           
      	$output .= '<option value=""> Select Semester</option>';
      	foreach($sem_det['posts'] as $semester)
			{
						 	
				$output .=	'<option value="'.$semester["SemesterName"].' '.,.' '.$semester['ExtSemesterId'].' "> '.$semester["SemesterName"].'</option> ';
				
			}
			echo $output;
		break;

	case 'rel_subject':
		$cl = mysql_query("SELECT * FROM tbl_CourseLevel where school_id='$school_id' and CourseLevel='".$res['Course_level']."'");
		$res_cl = mysql_fetch_array($cl);

		$div = mysql_query("SELECT * FROM Division where school_id='$school_id' and DivisionName='".$res['std_div']."'");
		$res_div = mysql_fetch_array($div);
//modified data for getting relevant subject by Pranali for SMC-5091 
		$data = array("school_id"=>$school_id, "type"=>"subject", "stud_member_id"=>$stud_member_id, "department"=>$res['dept_ExtDeptId'], "courseLevel"=>$res_cl['ExtCourseLevelID'], "branch"=>$res['ExtBranchId'], "division"=>$res_div['ExtDivisionID'], "semester"=>$res['ExtSemesterId']);
		//print_r($data);

		$ch = curl_init($url_rel);             
		$data_string = json_encode($data);    
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
		$sub_det = json_decode(curl_exec($ch),true); 
         
        //print_r($ch);
        if($sub_det['responseStatus']==200 && $sub_det['posts']!=null){
      		$output .= '<option value=""> Select Subject</option>';
      			foreach($sub_det['posts'] as $subject)
				{
						 	
					$output .=	'<option value="'.$subject["SubjectTitle"].','.$subject["SubjectCode"].'"> '.$subject["SubjectTitle"].'</option> ';
				
				}
		}
		
        
			echo $output;
		break;	

	case 'relevant_data':
		$data = array("school_id"=>$school_id,"relevant_data"=>"relevant_data");
		
		$ch = curl_init($url);             
		$data_string = json_encode($data);    
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
		$teacher_det = json_decode(curl_exec($ch),true); 
		
		echo json_encode($teacher_det);
		
		break;
	//echo json_encode($res);


			
			break;
//Added case for all_data by Pranali for SMC-5071 to display all data if All subject type is selected 
	case 'all_data':
		
		$data = array("school_id"=>$school_id,"all_data"=>"all_data");
		//print_r($data);exit;
		$ch = curl_init($url);             
		$data_string = json_encode($data);    
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
		$teacher_det = json_decode(curl_exec($ch),true); 
		
		echo json_encode($teacher_det);
		
		break;

}

?>