<?php
              include('conn.php');					 
						
			 
			  $id=$_GET['id'];
			
	
		 $sql="DELETE FROM tbl_social_points  where id='$id'";
		 
		 
		
		 $test=mysql_query($sql);
		
	
			
							
				 header("Location:socialfootprint.php");
		

?>