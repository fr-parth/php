<?php
              include('conn.php');					 
						
			 
			$staff_id=$_GET['id'];
				
//As per discussed with Avi Sir, update query added for updating only the delete flag in tbl_school_adminstaff and not physically delete the staff by Pranali for SMC-4591 on 26-3-20
		 $sql="UPDATE tbl_school_adminstaff SET delete_flag='1' WHERE id='$staff_id'";
		 $test=mysql_query($sql);
		
	// echo "<script> alert('Successfully Deleted!!');</script>";
			$succesreport="Successfully Deleted!!";
							
			header("Location:schoolAdminStaff_list.php?successreport=$succesreport");
		

?>