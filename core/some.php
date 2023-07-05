<?php 
require "conn.php";
error_reporting(0);
// require 'sd_upload_function.php';
$batch_id=$_POST['batch_id'];
$school_id=$_POST['school_id'];
 	// $data['scan']= mysql_query("CALL ScanRecordStudent('".$batch_id."','".$school_id."')");
$sql = "CALL `UploadRecordStudent`('".$batch_id."','".$school_id."')";
// echo $sql; exit;
	$data['process']=mysql_query($sql)or die(mysql_error());
 
	if($data['process']==1){
		$sql1="select group_member_id from tbl_school_admin where school_id='".$school_id."'";
		$query1= mysql_query($sql1);
		$res1= mysql_fetch_assoc($query1);
		$sql2="UPDATE tbl_student SET group_member_id='".$res1['group_member_id']."' where school_id='".$school_id."'";
		// echo $sql2; exit;
		$query2= mysql_query($sql2);
	}
	echo $data['process'];
?> 