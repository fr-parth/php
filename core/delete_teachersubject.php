<?php
include('conn.php');					 
$teacher_id=$_SESSION['id'];
$rowid = xss_clean(mysql_real_escape_string($_GET['id']));
$sql="delete from  tbl_teacher_subject_master where tch_sub_id='$rowid'";
$retval = mysql_query( $sql);
if($retval)
{
	echo"<script>alert('record deleted succesfully')</script>";
}
else
{
	echo"<script>alert('record not deleted succesfully')</script>";
}		 
header("Location:dashboard.php");

?>