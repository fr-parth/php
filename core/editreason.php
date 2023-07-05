<?php
include('conn.php');
$result = $_POST['reason'];
$row_id = $_POST['row_id'];
$sql = mysql_query("update tbl_student_recognition set student_recognition='$result' where id='$row_id'");
if($sql)
{
echo true;
}
else {
  echo false;
}
?>
