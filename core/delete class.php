
<?php 
       include('conn.php');		
 $server_name=$_SERVER['SERVER_NAME'];	   
			 
			  $class_id=$_GET['id'];
		          //echo "select * from tbl_school_class where id=$class_id";
				    //when delete school class then teacher respective class should delete first
					if(isset($_GET['id']))
					{
						 $class_id=$_GET['id'];
				 //$row=mysql_query("select * from Class  where id=$class_id");
				//echo "delete  from Class where class='$class_id'";die;
               $test = mysql_query("delete  from Class where id='$class_id'");
			   if($test)
			   {
				  // echo"<script>
				    //alert('Class  delete succesfully')
				  // </script>";
				   echo "<script>
window.location.href='http://$server_name/core/list_school_class.php';
alert('Deleted succesfully..');
</script>";
				   //	header("Location: http://$SERVER_NAME/core/list_school_class.php"); 
				   
				  // delete from Class where class='21'
			   }
			   
			   
			   else
			   {
				   echo"<script>
				   alert('Record not deleted..')
				   </script>";
				    
				   
			   }
			

				}
				 //when  school class deleted division of that class should be deleted
				// mysql_query("delete from tbl_division where class_id=$class_id");
				 ?>