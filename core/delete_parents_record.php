<?php
include('conn.php');
/*Create Page for delete parent record by Dhanashri_Tak_Intern*/
$id=mysql_real_escape_string(trim($_GET['Id']));
	$row=mysql_query("delete  from tbl_parent where Id='$id'");	
	 //o "<script>alert('Are you sure you want to delete?')</script>";
		if ($row)
		{
			echo ("<script LANGUAGE='JavaScript'>window.alert('Record deleted successfully');
                     window.location.href='parents_list.php';
                  </script>");
		}
		else
		{
			
		}
	 
?>
<!-- End-->