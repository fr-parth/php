<?php
              include('conn.php');					 
			   
			  $id=$_GET['id'];	
				$sch_id=$_GET['sch_id'];			  
			echo "<script type=text/javascript>alert('$id');</script>";
                 $row=mysql_query("update `tbl_student` set `parent_id`='0' where `std_PRN`='$id' and school_id='$sch_id'");
                  //$row=mysql_query("delete from tbl_parent_student where student_id=$id");
				
				 header("Location:child.php");
				 
		

?>