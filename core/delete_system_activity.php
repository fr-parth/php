<?php
include("conn.php");
if(isset($_GET["id"]))
	{
		$id= $_GET["id"];
		
		 $sql="DELETE FROM  tbl_studentpointslist WHERE sc_id='$id'";
		mysql_query($sql);
		
		 echo ("<script LANGUAGE='JavaScript'>
				window.alert('Record Deleted Successfully');
				window.location.href='System_level_activity.php';
				</script>");
		
	}
?>