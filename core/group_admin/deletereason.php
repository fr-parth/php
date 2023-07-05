<?php
include('../conn.php');
$id = $_POST['id'];
$sql = mysql_query("delete from tbl_student_recognition where id = '$id'");
if($sql)
{
echo true;
}
else {
  echo false;
}
?>
