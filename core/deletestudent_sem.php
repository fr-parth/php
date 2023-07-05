<?php
include('conn.php');
$id=mysql_escape_string(trim($_GET['student_id']));
//print_r($id);exit;
$ExtSemesterId=mysql_escape_string(trim($_GET['ExtSemesterId']));
//print_r($ExtSemesterId);exit;

//$row=mysql_query("select * from  StudentSemesterRecord where  student_id='$id' AND ExtSemesterId='$ExtSemesterId'") ;
//print_r($row);exit;

//$resultsd = mysql_query($query);");

	mysql_query("delete from StudentSemesterRecord where student_id='$id' AND ExtSemesterId='$ExtSemesterId'");	
	 //o "<script>alert('Are you sure you want to delete?')</script>";
	 
		if (mysql_num_rows($row)>0)
		{
			echo "<script type='text/javascript'>alert('Are you sure you want to delete?')</script>";
		}
		else
		{
			echo "<script type='text/javascript'>alert('failed!')</script>";
		}
	 

//else
//{
  // $report="Unsuccess" report=$report;	
//}
header("location:student_semester_record.php");

?>