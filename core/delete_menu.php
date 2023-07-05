<?php
              include('conn.php');					 
						
			 
			$id=$_GET['id'];
			
	
	     
		  
		 $sql="DELETE FROM tbl_menu  where id='$id'";
		 
		 
		
		 $test=mysql_query($sql);
		 if($test)
		 {
		
	echo '<script type="text/javascript">'; 
	echo 'alert("Record deleted successfully...");'; 
	echo 'window.location.href = "list_menu.php";';
	echo '</script>';	
}else
{
	echo '<script type="text/javascript">'; 
	echo 'alert("Record not deleted...");'; 
	echo 'window.location.href = "list_menu.php";';
	echo '</script>';	
}
				 
?>