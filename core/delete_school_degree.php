<?php

include('conn.php');
$id=mysql_escape_string(trim($_GET['id']));
$row=mysql_query("select * from  tbl_degree_master where id='$id'");

	mysql_query("delete  from tbl_degree_master where id='$id'");	
	 //o "<script>alert('Are you sure you want to delete?')</script>";
	 
		if (mysql_num_rows($row)>0)
		{
			echo "<script type='text/javascript'>alert('Are you sure you want to delete?')</script>";
		}
		else
		{
			echo "<script type='text/javascript'>alert('failed!')</script>";
		}
	 

//else
//{
  // $report="Unsuccess" report=$report;	
//}
header("location:list_school_degree.php");
?>
