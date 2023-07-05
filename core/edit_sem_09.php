<?php
include('conn.php');
include('scadmin_header.php');

$sql=mysql_query("select school_id from tbl_school_admin where id='$id'");
$result=mysql_fetch_array($sql);
 
 if(mysql_affected_rows()>0)
{
	echo "<script type=text/javascript>alert('Record successfully edited');location:editsemester.php </script>";
}
else
{
		//$msg="you didn't change anything...";
		echo "<script type=text/javascript>alert('you didn't change anything...')</script>";
}
?>