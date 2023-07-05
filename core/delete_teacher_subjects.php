<?php
              include('conn.php');					 
			$tch_sub_id=$_GET['id']; 
		$sql="DELETE FROM tbl_teacher_subject_master where tch_sub_id='$tch_sub_id'";
		    $test=mysql_query($sql);
			if($test>0)
			{
			echo ("<script type='text/JavaScript'>
					alert('Record deleted successfully...');
					window.location.href='list_teacher_subject.php';
					</script>");
			}
			else
			{
				echo ("<script type='text/JavaScript'>
					alert('Record not deleted');
					window.location.href='list_teacher_subject.php';
					</script>");
			}
			
?>