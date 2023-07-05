<?php
include("conn.php");
if(isset($_GET["id"]))
	{
		$id= $_GET["id"];
		
		 $sql="DELETE FROM tbl_student_recognition WHERE id='$id'";
		mysql_query($sql);
		header("location:student_reason.php");
	}
?>