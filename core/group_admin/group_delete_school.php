<?php
include ("../conn.php");
$sc_id = $_GET['sc_id'];
$sql = mysql_query("DELETE FROM `tbl_school_admin` WHERE id='$sc_id'");

	if($sql)
	{

	echo "<script>alert('School Deleted Successfully');</script>";

	}
	else
	{

	echo "<script>alert('Something is problem while delete school...')</script>";

		
	}
	 echo ("<script LANGUAGE='JavaScript'>
						window.location.href='group_list_school.php';
						</script>");



?>