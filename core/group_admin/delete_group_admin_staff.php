<?php
//Created by Rutuja for SMC-4487 on 11/02/2020
              include('../conn.php');					 
						
			 
			$cookiesAdmin_id=$_GET['id'];
			
	
	     
		  
		 $sql="DELETE FROM tbl_cookie_adminstaff  where id='$cookiesAdmin_id'";
		 
		 
		
		 $test=mysql_query($sql);
		
	
			
							
				 header("Location:GroupAdminStaff_list.php");
		

?>