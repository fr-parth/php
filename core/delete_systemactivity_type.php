<?php
include("conn.php");
if(isset($_GET["id"]))
	{
		$id= $_GET["id"];
		
		 $sql="DELETE FROM  tbl_activity_type WHERE id='$id'";
		mysql_query($sql);
		header("location:System_level_activity_type.php");
	}
?>