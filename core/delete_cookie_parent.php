<?php
include('conn.php');	
/*Created page for delete Parent record By Dhanashri_Tak*/
	$parent_id=$_POST['id']; 
	$sql="DELETE FROM tbl_parent  where Id='$parent_id'";
	$test=mysql_query($sql);	
	if($test)
	{
		echo true;		 
	}
	else 
	{
	   echo false;
	}	
?>