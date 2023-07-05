<?php 
$gcm_id=$_GET['registrationId'];
include_once('../conn.php');
$id=$_SESSION['id'];
$row=mysql_query("select * from tbl_student where id='$id'");
$value=mysql_fetch_array($row);
 $std_PRN=$value['std_PRN'];
echo "insert into student_gcmid(student_id,std_PRN,gcm_id,type) values ('$id','$std_PRN','$gcm_id','chrome')";
mysql_query("insert into student_gcmid(student_id,std_PRN,gcm_id,type) values ('$id','$std_PRN','$gcm_id','chrome')");

?>