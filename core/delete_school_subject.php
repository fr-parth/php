<?php
              include('conn.php');					 
			 
			  $subject_id=$_GET['id'];
			 echo $subject_id;
		        /*  $rows=mysql_query("select * from `tbl_school_subject` where id='$subject_id'");
				 $value=mysql_fetch_array($rows);
		        $sc_id=$value['School_id']; */
			     // $subject=$value['Subject_Title'];
				 //$row=mysql_query("delete from `tbl_school_subject` where Subject_Title='$subject' and school_id='$sc_id'");
			        // mysql_query($row); 
				  $sql=mysql_query("delete from tbl_school_subject where id='$subject_id'");
		           // mysql_query($sql);
				   $successreport="Successfully deleted";
				 header("Location:list_school_subject.php");
		

?>