<?php
include('conn.php');
$id = $_POST['id'];
$sql = mysql_query("delete from tbl_social_points where id = '$id'");

if($sql)
{
echo true;
}
else {
  echo false;
}
?>
