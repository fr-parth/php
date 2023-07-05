<?php
              include('conn.php');					 
			 
			 $id=$_GET['id'];
			 
			    //echo $id;die;
				$row=mysql_query("delete from tbl_student_subject_master where id='$id'");
					
		       // mysql_query($row);
	   /*Done if condition for alert message by Dhanashri_Tak on 15/6/18 */
		
			if($row)
			{
				echo ("<script LANGUAGE='JavaScript'>alert('Record Deleted Successfully');
                     window.location.href='list_student_subject.php';
                  </script>");
				// header("Location:list_student_subject.php");
			}
		/*End*/
?>
          <script> 
		        window.history.go(-1);
		   </script>