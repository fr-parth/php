<?php
 ob_start();
		include('conn.php');					 
			$teacher_id=$_GET['id'];
		$sql="DELETE FROM tbl_teacher where id='$teacher_id'";
		
		    $test=mysql_query($sql);
		
		header("Location:Nonteacherlist.php");
		

?>