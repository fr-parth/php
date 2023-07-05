<?php
/*Create new file for delete Branch_Subject_Division_Year*/
 include('conn.php');	 
	$subject_id=$_GET['id'];
		//echo $subject_id;
	$sql=mysql_query("delete from Branch_Subject_Division_Year where id='$subject_id'");
		//$successreport="Successfully deleted";
		if($sql){
		echo ("<script  LANGUAGE='JavaScript'>window.alert('Record deleted successfully');
                     window.location.href='branch_subject_master.php';
                  </script>");
		}
?>