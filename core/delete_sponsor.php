<?php
ob_start();
              include('conn.php');					 
			$sp_id=$_GET['id'];
			
			
		$sql="DELETE FROM tbl_sponsorer where id='$sp_id'";
		
			
		$results = mysql_query($sql);
		  
		header("Location:sponsor_list.php");
		
		//echo "<script> window.location('sponsor_list.php');</script>";
	
						
?>