<?php
include("conn.php");
if(isset($_GET["id"]))
	{
		$id= $_GET["id"];
		
		 $sql="DELETE FROM tbl_sponsored WHERE id='$id'";
		mysql_query($sql);
		header("location:product_setup.php");
	}
?>