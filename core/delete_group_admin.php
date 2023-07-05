<?php
include("conn.php");
if(isset($_GET["id"]))
	{
		$id= $_GET["id"];
		
		 $sql="DELETE FROM  tbl_cookieadmin WHERE id='$id'";
		mysql_query($sql);
		
		 echo ("<script LANGUAGE='JavaScript'>
				alert('Record Deleted Successfully');
				window.location.href='group_admin_list.php';
				</script>");
		
	}
?>