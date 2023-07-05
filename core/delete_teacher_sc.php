<?php
              include('conn.php');					 
			
			 $teacher_id=$_GET['id'];
             $sql="DELETE FROM tbl_teacher where id='$teacher_id'";
		     $test=mysql_query($sql);
			 ?>
             <script language="javascript" type="text/javascript">
                history.back(-1)
				
             </script>
           