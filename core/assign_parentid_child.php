<?php
              include('conn.php');					 
			 
			  $id=$_GET['std_prn'];
		    $parent_id=$_GET['id'];
			$school_id=$_GET['sch_id'];
			
                 $row=mysql_query("update `tbl_student` set parent_id='$parent_id' where std_PRN='$id' and school_id='$school_id'");
				 header("Location:child.php");
		

?>
