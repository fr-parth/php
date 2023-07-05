<?php
include("conn.php");
if(isset($_GET["id"]))
	{
		 $id= $_GET["id"];
		
		 $sql="DELETE FROM  tbl_salesperson WHERE person_id='$id'";
		mysql_query($sql);
		
		 echo ("<script LANGUAGE='JavaScript'>
				alert('Record Deleted Successfully');
				window.location.href='salesperson_list_cookie.php';
				</script>");
		
	}
?>