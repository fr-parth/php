<?php
include("conn.php");
if(isset($_GET["id"]))
	{
		$id= $_GET["id"];
		
		 $sql="DELETE FROM  tbl_onlinesubject_activity_achivement WHERE a_id='$id'";
		mysql_query($sql);
		
		 echo ("<script LANGUAGE='JavaScript'>
				window.alert('Record Deleted Successfully');
				window.location.href='subactivity_list.php';
				</script>");
		
	}
?>