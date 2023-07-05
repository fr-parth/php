<?php
$json = file_get_contents('php://input');
$obj = json_decode($json);
include('conn.php');

	$t_id = xss_clean(mysql_real_escape_string($obj->{'t_id'}));
	$school_id = xss_clean(mysql_real_escape_string($obj->{'school_id'}));
	$student_id = xss_clean(mysql_real_escape_string($obj->{'student_PRN'}));
	$reason_id=xss_clean(mysql_real_escape_string($obj->{'reason_id'}));

	//// Start SMC-3450 Modify By Pravin 2018-09-21 05:02 PM 
	//$accept_date=Date('d/m/Y');
	//End SMC-3450	


	if($t_id!='' && $school_id!='' && $reason_id!='' && $student_id!='')
	{
		$sql2=mysql_query("update tbl_request set flag='P' where stud_id1='$student_id' and stud_id2='$t_id' and entitity_id='103' and flag='N' and reason like '$reason_id' and school_id='$school_id'");
		$postvalue['responseStatus']=200;
		$postvalue['responseMessage']="ok";
		$postvalue['posts']=null;
	}
	else
	{
		$postvalue['responseStatus']=1000;
		$postvalue['responseMessage']="invalid inputs";
		$postvalue['posts']=null;
	}
	
	header('content-type:application/json');
	echo  json_encode($postvalue);
	@mysql_close($conn);
?>