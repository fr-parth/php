<?php
              include('conn.php');					 
						
			 
			$cookiesAdmin_id=$_GET['id'];
			
	
	     
		  
		 $sql="DELETE FROM tbl_cookie_adminstaff  where id='$cookiesAdmin_id'";
		 
		 
		
		 $test=mysql_query($sql);
		
	
			
							
				 header("Location:CookieAdminStaff_list.php");
		

?>