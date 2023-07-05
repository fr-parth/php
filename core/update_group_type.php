<?php

include 'conn.php';

$id=base64_decode($_REQUEST['id']);
$group_type=base64_decode($_REQUEST['group_type']);


$sql=mysql_query("update  tbl_group_type set group_type='$group_type' where id='$id'");

if($sql=='1')
{

echo "<script>alert('Successfully Upadted')</script>";
header('Location:group_type.php');
}
else
{
echo "<script>alert('Something is problem while update group type...')</script>";
header('Location:group_type.php');
	
}




?>