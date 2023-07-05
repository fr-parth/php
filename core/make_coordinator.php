<?php

 include('conn.php');					 

     			$id=xss_clean(mysql_real_escape_string($_GET['id']));

			  $teacher_id=$_SESSION['id'];

			  $query = mysql_query("select school_id from tbl_teacher where id = ".$_SESSION['id']);

$value = mysql_fetch_array($query);

$sc_id=$value['school_id'];

			  

$point_date = date('d/m/Y');

			

	
			 $query = mysql_query("select * from tbl_coordinator where stud_id='$id' and school_id='$sc_id' and teacher_id='$teacher_id' ");
			 
			if( mysql_num_rows($query)>=1){
			$query=mysql_query("UPDATE tbl_coordinator SET status = case when status = 'Y' then 'N' else 'Y' end where teacher_id='$teacher_id' and stud_id='$id' and school_id='$sc_id'");	
			}
			else
			{
				$query=mysql_query("insert into tbl_coordinator(teacher_id,stud_id,status,pointdate,school_id) values('$teacher_id','$id','Y','$point_date','$sc_id')");
			}
			 

				 header("Location:dashboard.php");


?>

