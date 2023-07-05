<?php
            include('conn.php');					 
			$teacher_id=$_SESSION['id'];
			
			
			$t_id = xss_clean(mysql_real_escape_string($_GET['id']));
			
			$query=mysql_query("select t_pc from tbl_teacher where t_id='$t_id'");
			$path = mysql_fetch_array($query);
			$finalpath = $path['t_pc'];
			
			unlink($finalpath);
			$sql="update tbl_teacher set t_pc ='' where t_id='$t_id'";
			$retval = mysql_query($sql);
			
				
		if($retval)
		{
			
			 echo "<script> alert('profile remove  succesfully'); </script>";
			
		}
		 else
		{
			 echo "<script> alert('profile not remove succesfully'); </script>";
		}		 
			 header('Location:teacher_profile.php');
		
?>