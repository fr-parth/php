<?php

include 'conn.php';

$id=base64_decode($_REQUEST['id']);


$sql=mysql_query("delete from tbl_group_type where id='$id'");

if($sql=='1')
{

echo "<script>alert('Successfully deleted');</script>";

}
else
{
echo "<script>alert('Something is problem while delete group type...')</script>";

	
}
 echo ("<script LANGUAGE='JavaScript'>
					window.location.href='group_type.php';
					</script>");
//echo "<script>window.location('group_type.php')</script>";
//header('Location:group_type.php');


?>