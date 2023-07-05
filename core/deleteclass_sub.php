<?php
/*
Author:Priyanka Rakshe
Date :23-4-2021
this file was created for delete option in add class subject 
*/

include('conn.php');
$subject_id = $_POST['id'];

$sql = mysql_query("delete from tbl_class_subject_master where id = '$subject_id'");
if($sql)
{
echo true;
}
else {
  echo false;
}

?>