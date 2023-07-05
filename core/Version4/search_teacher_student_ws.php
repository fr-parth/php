<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);
include "../conn.php";

$student_key = xss_clean(mysql_real_escape_string($obj->{'stud_teacher_key'}));
$user_id = xss_clean(mysql_real_escape_string($obj->{'user_id'}));
$school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
$entity_id = xss_clean(mysql_real_escape_string($obj->{'entity_id'}));
$emp_type_pid = xss_clean(mysql_real_escape_string($obj->{'emp_type_pid'}));
$authority = xss_clean(mysql_real_escape_string($obj->{'authority'}));
$offset = xss_clean(mysql_real_escape_string($obj->{'offset'}));

$format = 'json';
//Added condition for employee and manager by Pranali for SMC-4894 on 8-10-20
$site=$GLOBALS['URLNAME'];
if(!empty($student_key) and ($entity_id=='105' || $entity_id=='205')){
	if(!empty($school_id))
	{
		if(!empty($offset)){
	$query="SELECT  DISTINCT(std_PRN),school_id,id as member_id ,std_name,std_lastname,std_Father_name,std_complete_name,std_dept,std_class,std_branch,std_dob,std_age,	std_school_name,std_address,std_city,std_country,std_gender,std_div,std_hobbies,	std_img_path,std_email,std_phone,	std_state,Iscoordinator,Academic_Year FROM tbl_student 
	WHERE
	(std_PRN LIKE '%$student_key%' OR std_complete_name LIKE '%$student_key%' 
	OR std_lastname LIKE '%$student_key%' OR std_dept LIKE '$student_key%'	
	OR std_Father_name LIKE '%$student_key%' OR school_id LIKE '%$student_key%'
	OR std_name LIKE '%$student_key%' OR std_class LIKE '$student_key%' OR std_branch LIKE '%$student_key%') AND school_id = '$school_id' AND std_PRN != $user_id LIMIT 100 OFFSET $offset";
	
		}
		else{
			$query="SELECT  DISTINCT(std_PRN),school_id,id as member_id,std_name,std_lastname,std_Father_name,std_complete_name,std_dept,std_class,std_branch,std_dob,std_age,	std_school_name,std_address,std_city,std_country,std_gender,std_div,std_hobbies,	std_img_path,std_email,std_phone,	std_state,Iscoordinator,Academic_Year FROM tbl_student 
	WHERE
	(std_PRN LIKE '%$student_key%'OR std_complete_name LIKE '%$student_key%' 
	OR std_lastname LIKE '%$student_key%' OR std_dept LIKE '$student_key%'	
	OR std_Father_name LIKE '%$student_key%' OR school_id LIKE '%$student_key%'
	OR std_name LIKE '%$student_key%' OR std_class LIKE '$student_key%' OR std_branch LIKE '%$student_key%') AND school_id = '$school_id' AND std_PRN != $user_id LIMIT 100 ";
		}
	}
	else{
		if(!empty($offset)){
	$query="SELECT  DISTINCT(std_PRN),school_id,id as member_id,std_name,std_lastname,std_Father_name,std_complete_name,std_dept,std_class,std_branch,std_dob,std_age,	std_school_name,std_address,std_city,std_country,std_gender,std_div,std_hobbies,	std_img_path,std_email,std_phone,	std_state,Iscoordinator,Academic_Year FROM tbl_student 
	WHERE
	(std_PRN LIKE '%$student_key%'OR std_complete_name LIKE '%$student_key%' 
	OR std_lastname LIKE '%$student_key%' OR std_dept LIKE '$student_key%'	
	OR std_Father_name LIKE '%$student_key%' OR school_id LIKE '%$student_key%'
	OR std_name LIKE '%$student_key%' OR std_class LIKE '$student_key%' OR std_branch LIKE '%$student_key%') AND AND std_PRN != $user_id LIMIT 100 OFFSET $offset";
		}
		else{
			$query="SELECT  DISTINCT(std_PRN),school_id,id as member_id,std_name,std_lastname,std_Father_name,std_complete_name,std_dept,std_class,std_branch,std_dob,std_age,	std_school_name,std_address,std_city,std_country,std_gender,std_div,std_hobbies,	std_img_path,std_email,std_phone,	std_state,Iscoordinator,Academic_Year FROM tbl_student 
	WHERE
	(std_PRN LIKE '%$student_key%'OR std_complete_name LIKE '%$student_key%' 
	OR std_lastname LIKE '%$student_key%' OR std_dept LIKE '$student_key%'	
	OR std_Father_name LIKE '%$student_key%' OR school_id LIKE '%$student_key%'
	OR std_name LIKE '%$student_key%' OR std_class LIKE '$student_key%' OR std_branch LIKE '%$student_key%') AND std_PRN != $user_id LIMIT 100";
		}
	}
	
	$result = mysql_query($query,$con) or die('Errant query:  '.$query);
	$posts = array();
	
	if(mysql_num_rows($result) >= 1){
		while($post = mysql_fetch_assoc($result)){
			$res_school_id = htmlentities($post['school_id']);
			$res_member_id = htmlentities($post['member_id']);
			$res_std_PRN = htmlentities($post['std_PRN']);
			$std_name =htmlentities($post['std_name']);
			$std_Father_name = htmlentities($post['std_Father_name']);
			$std_lastname = htmlentities($post['std_lastname']);
			$res_std_complete_name = htmlentities($post['std_complete_name']);
			$res_std_dept = htmlentities($post['std_dept']);
			$res_std_class = htmlentities($post['std_class']);
			$res_std_branch = htmlentities($post['std_branch']);
			$std_dob = htmlentities($post['std_dob']);
			$std_age = htmlentities($post['std_age']);
			$std_school_name = htmlentities($post['std_school_name']);
			$std_address = htmlentities($post['std_address']);
			$std_city = htmlentities($post['std_city']);
			$std_country = htmlentities($post['std_country']);
			$std_gender = htmlentities($post['std_gender']);
			$std_div = htmlentities($post['std_div']);
			$std_hobbies = htmlentities($post['std_hobbies']);
			$std_img_path = htmlentities($post['std_img_path']);
			$std_email = htmlentities($post['std_email']);
			$std_phone = htmlentities($post['std_phone']);
			$std_state = htmlentities($post['std_state']);
			$Iscoordinator = htmlentities($post['Iscoordinator']);
			$Academic_Year = htmlentities($post['Academic_Year']);
			if($std_img_path != ''){
				
				$std_img_path="$site/core/".$std_img_path;
			}
			else{
				$std_img_path="$site/Assets/images/avatar/avatar_2x.png";
			}
			if($res_std_complete_name =='')
			{
				$res_std_complete_name=$std_name." ".$std_Father_name." ".$std_lastname;
			}
			else{
				$res_std_complete_name;
			}
			/** Author : Vaibhav G
			/*  Below code belongs to calculate age
			/* code start
			*/
			if(!empty($std_dob)){
				//date format changed by sachin
             //$std_dob = date("d/m/Y", strtotime( $std_dob));
			 $std_dob = date("Y/m/d", strtotime( $std_dob));
			 //end sachin
				
				$arr=explode('/',$std_dob);
				//$dateTs=date_default_timezone_set($std_dob); 
				$dateTs=strtotime($std_dob);
				 
				$now=strtotime('today');
				 
				//if(sizeof($arr)!=3) die('ERROR:please entera valid date');
				 
				//if(!checkdate($arr[0],$arr[1],$arr[2])) die('PLEASE: enter a valid dob');
				 
				//if($dateTs>=$now) die('ENTER a dob earlier than today');
				 
				$ageDays=floor(($now-$dateTs)/86400);
				 
				$ageYears=floor($ageDays/365);
				 
				$ageMonths=floor(($ageDays-($ageYears*365))/30);
				 
				$std_age= $ageYears;
			}
//first and last login time added by Pranali for SMC-4894 on 8-10-20
			$login_det = mysql_query("SELECT FirstLoginTime,LatestLoginTime FROM tbl_LoginStatus WHERE EntityID='$res_member_id' ORDER BY RowID DESC LIMIT 1");
			$res_login = mysql_fetch_array($login_det);
			$FirstLoginTime = isset($res_login['FirstLoginTime']) ? $res_login['FirstLoginTime'] : '';
			$LatestLoginTime = isset($res_login['LatestLoginTime']) ? $res_login['LatestLoginTime'] : '';
			/* code end
			*/
			
			$posts[] =array(
			"school_id"=>$res_school_id,
			"student_id"=>$res_member_id,
			"std_PRN"=>$res_std_PRN,
			"std_name"=>$std_name,
			"std_father_name"=>$std_Father_name,
			"std_complete_name"=>ucwords(strtolower(trim($res_std_complete_name))),
			"std_father_name"=>$std_Father_name,
			"std_img_path"=>$std_img_path,
			"std_dept"=>$res_std_dept,
			"std_class"=>$res_std_class,
			"std_dob"=>$std_dob,
			"std_age"=>$std_age,
			"std_school_name"=>$std_school_name,
			"std_address"=>$std_address,
			"std_city"=>$std_city,
			"std_country"=>$std_country,
			"std_gender"=>$std_gender,
			"std_div"=>$std_div,
			"std_hobbies"=>$std_hobbies,
			"std_email"=>$std_email,
			"std_phone"=>$std_phone,
			"std_state"=>$std_state,
			"is_coordinator"=>$Iscoordinator,
			"Academic_Year"=>$Academic_Year,
			"std_branch"=>$res_std_branch,
			"FirstLoginTime"=>$FirstLoginTime,
			"LastLoginTime"=>$LatestLoginTime
			
			);
		}
		$postvalue['responseStatus'] = 200;
		$postvalue['responseMessage'] = "OK";
		$postvalue['posts'] = $posts;

	}
	else{
		$postvalue['responseStatus'] = 204;
		$postvalue['responseMessage'] = 'No Response';
		$postvalue['posts'] = NULL;
	}
	
	if($format = 'json'){
		header('Content-type: application/json');
		echo json_encode($postvalue);
	}
	
}
else if(!empty($student_key) and ($entity_id=='103' || $entity_id=='203'))
{
		$where="";
			
		 if($emp_type_pid!='' and $authority == 'Higher')
		 {	
				if($emp_type_pid=='134')
				{
					$emp_type_pid='133';
				}
		 $where.=" and t_emp_type_pid >='".$emp_type_pid."'";
		 }
		 if($emp_type_pid!='' and $authority == 'Lower' )
		 {	
			if($emp_type_pid=='134')
				{
					$emp_type_pid='133';
				}
		 $where.=" and t_emp_type_pid <'".$emp_type_pid."'";
		 }	  
			  
			  
	if(!empty($school_id))
	{ 

	  $query="SELECT t.id,t.t_id, t.t_pc,t.t_complete_name, t.t_name, t.t_middlename, t.t_lastname, t.t_dept, t.school_id, t.t_class,t.t_designation,t.t_emp_type_pid,ts.subjcet_code,ts.Semester_id,ts.AcademicYear,ts.ExtBranchId,ts.subjectName,ts.subjcet_code,ts.tch_sub_id FROM tbl_teacher as t left join tbl_teacher_subject_master as ts on t.t_id=ts.teacher_id and t.school_id=ts.school_id left join tbl_academic_Year as ay on ay.Year=ts.AcademicYear and ay.Enable='1' and ay.school_id=t.school_id WHERE (t.t_complete_name LIKE '%$student_key%' OR t.t_name LIKE '%$student_key%' OR t.t_lastname LIKE '%$student_key%') AND t.school_id ='$school_id' AND t.t_id != $user_id $where  group by t.t_id";

	
	//echo $query;exit;
	}
	else
	{
		 $query="SELECT t.id,t.t_id,t.t_pc, t.t_complete_name, t.t_name, t.t_middlename, t.t_lastname, t.t_dept, t.school_id, t.t_class,t.t_designation,ts.Semester_id,ts.AcademicYear,ts.ExtBranchId,ts.tch_sub_id,ts.subjectName,ts.subjcet_code FROM tbl_teacher as t left join tbl_teacher_subject_master as ts on t.t_id=ts.teacher_id and t.school_id=ts.school_id left join tbl_academic_Year as ay on ay.Year=ts.AcademicYear and ay.Enable='1' and ay.school_id=t.school_id WHERE (t.t_complete_name LIKE '%$student_key%' OR t.t_name LIKE '%$student_key%' OR t.t_lastname LIKE '%$student_key%') AND t.t_id != $user_id AND $where group by t.t_id";
		 
	}
	$result = mysql_query($query) or die('Errant query:  '.$query);
	
	$count=mysql_num_rows($result);
	$posts = array();
	
	
		
	if( $count > 0){
		
		while($post = mysql_fetch_array($result)){
			
			$id=$post['id'];
			$t_id=$post['t_id'];
			$t_pc=$post['t_pc'];
			$t_complete_name=$post['t_complete_name'];
			$t_name=$post['t_name'];
			$t_middlename=$post['t_middlename'];
			$t_lastname=$post['t_lastname'];
			$t_dept=$post['t_dept'];
			$t_class=$post['t_class'];
			$school_id=$post['school_id'];
			$t_designation=$post['t_designation'];
			$t_emp_type_pid=$post['t_emp_type_pid'];
			$Branches_id=$post['ExtBranchId'];
			$Year=$post['AcademicYear'];
			$semesterName=$post['Semester_id'];
			$subjcetId=$post['tch_sub_id'];
			$subjectName=htmlspecialchars($post['subjectName']);
			$subjcet_code= htmlspecialchars($post['subjcet_code']);
			$subject_image='';
			if($t_complete_name!=""){
				$t_complete_name;
			}
			else{
				
				$t_complete_name=$t_name." ".$t_middlename." ".$t_lastname;
			}
			if($t_pc!=""){
				$image=$site."/teacher_images/".$t_pc;
			}
			else{
				
			$image=$site."/Assets/images/avatar/avatar_2x.png";
			}
			
		if($subjectName == NULL) 
			{
				$subjectName='';
				
			}
		if($subjcet_code == NULL)
		{
			$subjcet_code='';
		}
		if($t_class == NULL)
		{
			$t_class='';
		}
		if($t_dept == NULL)
		{
			$t_dept='';
		}

//first and last login time added by Pranali for SMC-4894 on 8-10-20
			$login_det = mysql_query("SELECT FirstLoginTime,LatestLoginTime FROM tbl_LoginStatus WHERE EntityID='$id' ORDER BY RowID DESC LIMIT 1");
			$res_login = mysql_fetch_array($login_det);
			$FirstLoginTime = isset($res_login['FirstLoginTime']) ? $res_login['FirstLoginTime'] : '';
			$LatestLoginTime = isset($res_login['LatestLoginTime']) ? $res_login['LatestLoginTime'] : '';

			$data[]=array(
			"id"=> $id,
			"teacher_image"=> $image,
            "teacher_id"=> $t_id,
            "teacher_name"=>$t_complete_name,
            "t_dept"=>$t_dept,
            "school_id"=> $school_id,
            "t_class"=>$t_class,
			"t_designation"=> $t_designation,
			"t_emp_type_pid"=> $t_emp_type_pid,
			"Branches_id"=> $Branches_id,
			"Year"=> $Year,
			"semesterName"=> $semesterName,
            "subjectName"=> $subjectName,
            "SubjectCode"=> $subjcet_code,
			"subjcetId"=> $subjcetId,
			"subject_image"=> $subject_image,
			"FirstLoginTime"=> $FirstLoginTime,
			"LastLoginTime"=> $LatestLoginTime
			
			);
			
			
			
			
		}	
		
	
		$posts = $data;
		$postvalue['responseStatus'] = 200;
		$postvalue['responseMessage'] = "OK";
		$postvalue['posts'] = $posts;

	}
	else{
		$postvalue['responseStatus'] = 204;
		$postvalue['responsMessage'] = 'No Response';
		$postvalue['posts'] = NULL;
	}
	
	if($format = 'json'){
		header('Content-type: application/json');
		echo json_encode($postvalue);
	}
	
}
else{

	$postvalue['responseStatus']=1000;
	$postvalue['responseMessage']="Invalid Input";
	$postvalue['posts']=null;
	
	header('Content-type: application/json');
   	echo  json_encode($postvalue);
}

  @mysql_close($con);

?>