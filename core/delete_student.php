<?php
              include('conn.php');					 
			$student_id=$_GET['id'];
		$sql="DELETE FROM tbl_student where id='$student_id'";
		    $test=mysql_query($sql);
		echo ("<script LANGUAGE='JavaScript'>
				alert('Record Deleted Successfully');
				window.location.href='studentlist.php';
				</script>");
		//header("Location:teacher_setup.php");
?>
  <script> 
  //alert('record deleted successfully');
  //window.history.back(-1)
  </script>