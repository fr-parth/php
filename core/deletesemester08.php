<?php
include('conn.php');
$id=mysql_escape_string(trim($_GET['id']));
$row=mysql_query("select * from  tbl_semester_master where Semester_Id='$id'");
if(mysql_num_rows($row)>0)
{
  mysql_query("delete  from tbl_semester_master where Semester_Id='$id'");	
	 $report="Successfully deleted";	
}
else
{
   $report="Unsuccess";	
}
header("location:list_semester.php?report=$report");

?>