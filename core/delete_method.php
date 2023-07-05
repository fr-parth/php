<?php

include ("conn.php");
	$id = $_GET[actid];
    mysql_query("delete from tbl_master where id=$id");
	//echo "delete * from tbl_master where id=$id";
	
	echo "<script>alert('record deleted')</script>";
	
	echo "<script>window.location.assign('school_master_table.php')</script>";


?>