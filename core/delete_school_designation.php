<?php
              include('conn.php');					 
			 
			  $div_id=$_GET['id'];
		  
		//$sql=mysql_query("delete  from tbl_school_division where id='$div_id'");
		$sql=mysql_query("delete  from tbl_teacher_designation where id='$div_id'");
		//		 header("Location:list_school_division.php");
	if($sql)
	{
		echo ("<script LANGUAGE='JavaScript'>window.alert('Record deleted successfully');
                     window.location.href='list_school_designation.php';
                  </script>");
	}

?>

      <script>
          window.history.go(-1);
      </script>