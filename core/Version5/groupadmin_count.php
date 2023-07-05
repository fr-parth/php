<?php

include '../connsqli.php';
//$conn=mysqli_connect("50.63.166.149", "techindi_Develop", "A*-fcV6gaFW0","techindi_Dev");
error_reporting(0);
$json = file_get_contents('php://input');
header('Content-type: application/json');
$obj = json_decode($json);

$operation = $obj->operation;

if($operation == "check_count"){
$group_member_id = $obj->group_member_id;
$entity_type = $obj->entity_type;
$status = $obj->status;

if($group_member_id == ""){
	$postvalue['responseStatus']=204;
		$postvalue['responseMessage']="Please Enter GroupID";
		echo  json_encode($postvalue);
}
if($entity_type == ""){
	$postvalue['responseStatus']=206;
	$postvalue['responseMessage']="Please Enter Entity Type";
	echo  json_encode($postvalue);
}
if($status == ""){
	$postvalue['responseStatus']=208;
	$postvalue['responseMessage']="Please Enter Status Login Or NotLogin";
	echo  json_encode($postvalue);
}
if($entity_type == "student"){
	$a = "tbl_student";
	$c = "student";
	$e = "";
}elseif($entity_type == "teacher"){
	$a = "tbl_teacher";
	$e = "AND (tbl_teacher.t_emp_type_pid='133' or tbl_teacher.t_emp_type_pid='134')";
	$c = "teacher";
}

if($status == "Login"){
	$b = "first_login_date IS NOT NULL";
	$d = "Login";
}elseif($status == "NotLogin"){
	$b = "first_login_date IS NULL";
	$d = "NotLogin";
}


	$sql  = mysqli_query($conn,"select count($a.id) as counts from $a JOIN  tbl_school_admin on 
tbl_school_admin.school_id = $a.school_id where $a.group_member_id = '$group_member_id' AND $a.$b AND (tbl_school_admin.school_type ='school' or tbl_school_admin.school_type ='') $e");

	$rowcount = mysqli_fetch_array($sql);
	$count = $rowcount['counts'];
	if($count > 0){
		$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				if($c == "student" && $d == "Login"){
				$postvalue['Student_Login_Count']=$count;
				}
				if($c == "student" && $d == "NotLogin"){
				$postvalue['Student_NotLogin_Count']=$count;
				}
				if($c == "teacher" && $d == "Login"){
				$postvalue['Teacher_Login_Count']=$count;
				}
				if($c == "teacher" && $d == "NotLogin"){
				$postvalue['Teacher_NotLogin_Count']=$count;
				}
   				echo  json_encode($postvalue);
	}else{
		$postvalue['responseStatus']=210;
				$postvalue['responseMessage']="Recode Not Found";
			
   				echo  json_encode($postvalue);
	}
	
}elseif($operation == "check_school_count"){
	$group_member_id = $obj->group_member_id;
$entity_type = $obj->entity_type;
$status = $obj->status;

if($group_member_id == ""){
	$postvalue['responseStatus']=204;
		$postvalue['responseMessage']="Please Enter GroupID";
		echo  json_encode($postvalue);
}
if($entity_type == ""){
	$postvalue['responseStatus']=206;
	$postvalue['responseMessage']="Please Enter Entity Type";
	echo  json_encode($postvalue);
}
if($status == ""){
	$postvalue['responseStatus']=208;
	$postvalue['responseMessage']="Please Enter Status Login Or NotLogin";
	echo  json_encode($postvalue);
}

if($entity_type == "student"){
	$a = "tbl_student";
	$c = "student";
	$e = "";
}elseif($entity_type == "teacher"){
	$a = "tbl_teacher";
	$c = "teacher";
	$e = "AND (tbl_teacher.t_emp_type_pid='133' or tbl_teacher.t_emp_type_pid='134')";
}

if($status == "Login"){
	$b = "first_login_date IS NOT NULL";
	$d = "Login";
}elseif($status == "NotLogin"){
	$b = "first_login_date IS NULL";
	$d = "NotLogin";
}


	
	
	$sql  = mysqli_query($conn,"select distinct($a.school_id) as school_ids from $a JOIN  tbl_school_admin on 
tbl_school_admin.school_id = $a.school_id where $a.group_member_id = '$group_member_id' AND $a.$b AND (tbl_school_admin.school_type ='school' or tbl_school_admin.school_type ='') $e");

	
	$count = mysqli_num_rows($sql);
	if($count > 0){
	while($row = mysqli_fetch_array($sql)){
		$school_ids = $row['school_ids'];
		$query = mysqli_query($conn,"select * from $a where group_member_id = '$group_member_id' AND school_id ='$school_ids' AND $b");
		$count_school = mysqli_num_rows($query);
		
		$query2 = mysqli_query($conn,"select * from tbl_school_admin where school_id='$school_ids'");
		$rows = mysqli_fetch_array($query2);
		$school_name = $rows['school_name'];
		if($school_name == ""){
			$school_name = "";
		}
		$info[] = array('school_name'=>$school_name,'school_id'=>$school_ids,'count'=>$count_school);
	}
	
	$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
			
				$postvalue['data']=$info;
				
   				echo  json_encode($postvalue);
	
	}else{
			$postvalue['responseStatus']=210;
				$postvalue['responseMessage']="Recode Not Found";
			
   				echo  json_encode($postvalue);
	}

}elseif($operation == "school_count_details"){
	$group_member_id = $obj->group_member_id;
$entity_type = $obj->entity_type;
$status = $obj->status;
$school_id = $obj->school_id;

if($group_member_id == ""){
	$postvalue['responseStatus']=204;
		$postvalue['responseMessage']="Please Enter GroupID";
		echo  json_encode($postvalue);
}
if($entity_type == ""){
	$postvalue['responseStatus']=206;
	$postvalue['responseMessage']="Please Enter Entity Type";
	echo  json_encode($postvalue);
}
if($status == ""){
	$postvalue['responseStatus']=208;
	$postvalue['responseMessage']="Please Enter Status Login Or NotLogin";
	echo  json_encode($postvalue);
}
if($school_id == ""){
	$postvalue['responseStatus']=210;
	$postvalue['responseMessage']="Please Enter SchoolID";
	echo  json_encode($postvalue);
}

if($entity_type == "student"){
	$a = "tbl_student";
	$c = "student";
	$e = "";
}elseif($entity_type == "teacher"){
	$a = "tbl_teacher";
	$c = "teacher";
	$e = "AND (tbl_teacher.t_emp_type_pid='133' or tbl_teacher.t_emp_type_pid='134')";
}

if($status == "Login"){
	$b = "first_login_date IS NOT NULL";
	$d = "Login";
}elseif($status == "NotLogin"){
	$b = "first_login_date IS NULL";
	$d = "NotLogin";
}


$sql  = mysqli_query($conn,"select * from $a JOIN  tbl_school_admin on 
tbl_school_admin.school_id = $a.school_id where $a.group_member_id = '$group_member_id' AND $a.$b AND (tbl_school_admin.school_type ='school' or tbl_school_admin.school_type ='') AND $a.school_id='$school_id' $e");

$count = mysqli_num_rows($sql);
if($count > 0){
	$info = array();
	while($row = mysqli_fetch_assoc($sql)){
		$info[] = $row;
	}
	$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
			
				$postvalue['data']=$info;
				
   				echo  json_encode($postvalue);
}else{
	$postvalue['responseStatus']=212;
				$postvalue['responseMessage']="Recode Not Found";
			
   				echo  json_encode($postvalue);
}

}elseif($operation == "upload_data_count"){
	
$entity_type = $obj->entity_type;
$start_date = $obj->start_date;
$end_date = $obj->end_date;

if($entity_type == ""){
	$postvalue['responseStatus']=206;
	$postvalue['responseMessage']="Please Enter Entity Type";
	echo  json_encode($postvalue);
}

if($entity_type == "student"){
	$a = "tbl_student";
	$b = "DATE(upload_date)";
	$c = "student";
}elseif($entity_type == "teacher"){
	$a = "tbl_teacher";
	$b = "DATE(created_on)";
	$c = "teacher";
}

// $week=29;
// $year=2019;

  // $dateTime = new DateTime();
  // $dateTime->setISODate($year, $week);
 // echo $week_start_date = $dateTime->format('Y-m-d');
  // $dateTime->modify('+6 days');
  // echo $week_end_date = $dateTime->format('Y-m-d');


if($start_date == "" && $end_date == ""){
	$end_date = date("Y-m-d");
	$start_date = date("Y-m-d");
}

$sql = mysqli_query($conn,"SELECT * FROM $a where $b BETWEEN '$start_date' AND '$end_date'");
$count = mysqli_num_rows($sql);
if($count > 0){
	$info = array();
	while($row = mysqli_fetch_assoc($sql)){
		$info[] = $row;
	}
	$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
			if($c == "student"){
				$postvalue['upload_student_count']=$count;
				$postvalue['upload_student_list']=$info;
			}
			if($c == "teacher"){
				$postvalue['upload_teacher_count']=$count;
				$postvalue['upload_teacher_list']=$info;
			}
   				echo  json_encode($postvalue);
}else{
	$postvalue['responseStatus']=212;
				$postvalue['responseMessage']="Recode Not Found";
			
   				echo  json_encode($postvalue);
}

}elseif($operation == "check_schoolwise_count"){
$group_member_id = $obj->school_id;
$entity_type = $obj->entity_type;
$status = $obj->status;

if($group_member_id == ""){
	$postvalue['responseStatus']=204;
		$postvalue['responseMessage']="Please Enter SchoolID";
		echo  json_encode($postvalue);
}
if($entity_type == ""){
	$postvalue['responseStatus']=206;
	$postvalue['responseMessage']="Please Enter Entity Type";
	echo  json_encode($postvalue);
}
if($status == ""){
	$postvalue['responseStatus']=208;
	$postvalue['responseMessage']="Please Enter Status Login Or NotLogin";
	echo  json_encode($postvalue);
}
if($entity_type == "student"){
	$a = "tbl_student";
	$c = "student";
	$e = "";
}elseif($entity_type == "teacher"){
	$a = "tbl_teacher";
	$e = "AND (tbl_teacher.t_emp_type_pid='133' or tbl_teacher.t_emp_type_pid='134')";
	$c = "teacher";
}

if($status == "Login"){
	$b = "first_login_date IS NOT NULL";
	$d = "Login";
}elseif($status == "NotLogin"){
	$b = "first_login_date IS NULL";
	$d = "NotLogin";
}


	
	
	$sql  = mysqli_query($conn,"select count($a.id) as counts from $a JOIN  tbl_school_admin on 
tbl_school_admin.school_id = $a.school_id where $a.school_id = '$group_member_id' AND $a.$b AND (tbl_school_admin.school_type ='school' or tbl_school_admin.school_type ='') $e");
	
	
	$rowcount = mysqli_fetch_array($sql);
	$count = $rowcount['counts'];
	if($count > 0){
		$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
				if($c == "student" && $d == "Login"){
				$postvalue['Student_Login_Count']=$count;
				}
				if($c == "student" && $d == "NotLogin"){
				$postvalue['Student_NotLogin_Count']=$count;
				}
				if($c == "teacher" && $d == "Login"){
				$postvalue['Teacher_Login_Count']=$count;
				}
				if($c == "teacher" && $d == "NotLogin"){
				$postvalue['Teacher_NotLogin_Count']=$count;
				}
   				echo  json_encode($postvalue);
	}else{
		$postvalue['responseStatus']=210;
				$postvalue['responseMessage']="Recode Not Found";
			
   				echo  json_encode($postvalue);
	}
	
}elseif($operation == "schoolwise_count_details"){
	
$entity_type = $obj->entity_type;
$status = $obj->status;
$school_id = $obj->school_id;


if($entity_type == ""){
	$postvalue['responseStatus']=206;
	$postvalue['responseMessage']="Please Enter Entity Type";
	echo  json_encode($postvalue);
}
if($status == ""){
	$postvalue['responseStatus']=208;
	$postvalue['responseMessage']="Please Enter Status Login Or NotLogin";
	echo  json_encode($postvalue);
}
if($school_id == ""){
	$postvalue['responseStatus']=210;
	$postvalue['responseMessage']="Please Enter SchoolID";
	echo  json_encode($postvalue);
}

if($entity_type == "student"){
	$a = "tbl_student";
	$c = "student";
	$e = "";
}elseif($entity_type == "teacher"){
	$a = "tbl_teacher";
	$c = "teacher";
	$e = "AND (tbl_teacher.t_emp_type_pid='133' or tbl_teacher.t_emp_type_pid='134')";
}

if($status == "Login"){
	$b = "first_login_date IS NOT NULL";
	$d = "Login";
}elseif($status == "NotLogin"){
	$b = "first_login_date IS NULL";
	$d = "NotLogin";
}



$sql  = mysqli_query($conn,"select * from $a JOIN  tbl_school_admin on 
tbl_school_admin.school_id = $a.school_id where $a.school_id = '$school_id' AND $a.$b AND (tbl_school_admin.school_type ='school' or tbl_school_admin.school_type ='') $e");


$count = mysqli_num_rows($sql);
if($count > 0){
	$info = array();
	while($row = mysqli_fetch_assoc($sql)){
		$info[] = $row;
	}
	$postvalue['responseStatus']=200;
				$postvalue['responseMessage']="OK";
			
				$postvalue['data']=$info;
				
   				echo  json_encode($postvalue);
}else{
	$postvalue['responseStatus']=212;
				$postvalue['responseMessage']="Recode Not Found";
			
   				echo  json_encode($postvalue);
}

}else{
	$postvalue['responseStatus']=1000;
				$postvalue['responseMessage']="Operation Not Found";
			
   				echo  json_encode($postvalue);
}
?>