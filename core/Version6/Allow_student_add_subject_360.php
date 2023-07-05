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
 
$school_id	= xss_clean(mysql_real_escape_string($obj->{'school_id'}));

if($school_id == "")
{
	$postvalue['responseStatus']=206;
	$postvalue['responseMessage']="Please Find School ID";
	echo json_encode($postvalue);
	die;
}

 
 $sql = mysql_query("select * from school_rule_engine where school_id='$school_id'");
 $row = mysql_fetch_array($sql);
 $Allow_student_add_subject_360 = $row['Allow_student_add_subject_360'];
 $count = mysql_num_rows($sql);
 if($count > 0)
 {
	 $postvalue['responseStatus']=200;
	 $postvalue['responseMessage']="OK";
	 $postvalue['Allow_student_add_subject_360_status']=$Allow_student_add_subject_360;
	 echo json_encode($postvalue);
 }
 else
 {
	 
		$postvalue['responseStatus']=204;
		$postvalue['responseMessage']="School ID not found";
		echo json_encode($postvalue);
			  	
 }
 ?>