<?php
              include('conn.php');					 
			$student_id=$_GET['id'];
		$sql="DELETE FROM tbl_branch_master where id='$student_id'";
		    $test=mysql_query($sql);
		echo ("<script LANGUAGE='JavaScript'>
					alert('Deleted successfully ');
					window.location.href='list_school_branch.php';
					</script>");
		
?>
  