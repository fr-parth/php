<?php
              include('conn.php');					 
			 
			  $class_id=$_GET['id'];
		          //echo "select * from tbl_school_class where id=$class_id";
				    //when delete school class then teacher respective class should delete first
				 $row=mysql_query("select * from tbl_school_class where id=$class_id");
				while( $value=mysql_fetch_array($row))
				{
				   $class=$value['class'];
				  
				   $rows=mysql_query("select * from tbl_school_class where class=$class");
				   mysql_query("delete from tbl_school_class where class='$class'");
				   
				  
				   mysql_query("delete from tbl_school_division where class_id=$class_id");
				   
				        
				 }
                 mysql_query("delete from tbl_class where class=$class_id");
				 //when  school class deleted division of that class should be deleted
				 mysql_query("delete from tbl_division where class_id=$class_id");
				
				// header("Location:list_school_class.php");
		

?>
     <script> 
	 window.history.go(-1);
	  </script>