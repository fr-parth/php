<?php
              include('conn.php');					 
			$teacher_id=$_SESSION['id'];
			
			
			if(isset($_POST['id']))
			{
			 
			  //$subject_id=$_GET['subid'];
			  //$sc_id=$_GET['sc_id'];
			  
			$id=$_POST['id'];
		
	
		 //$sql="DELETE FROM tbl_subject  where subject='$subject_id' and teacher_id='$teacher_id' and school_id='$sc_id'";
		
		 //$test=mysql_query($sql);
		 
		 $sql="delete from  tbl_teacher_subject_master where id='$id'";
		  $retval = mysql_query( $sql);
		 if($retval)
		 {
			 
			 echo"record deleted succesfully";
			 
		 }
		 else
		 {
			  echo"record not deleted succesfully";
			 
			 }		 
		
			}
			
							
				 header("Location:dashboard.php");
		

?>