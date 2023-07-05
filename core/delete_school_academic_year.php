<?php
include('conn.php');
$id=mysql_escape_string(trim($_GET['id']));
$row=mysql_query("select * from  tbl_academic_Year where id='$id'");
$res=mysql_fetch_array($row);
if ($res['Enable']=='1')
{
	echo "<script type='text/javascript'>alert('Please enable other academic year to delete this..!!')</script>";
}
else{
	mysql_query("delete  from tbl_academic_Year where id='$id'");	
	 //o "<script>alert('Are you sure you want to delete?')</script>";
 
	if (mysql_num_rows($row)>0)
	{
		echo "<script type='text/javascript'>alert('Record Deleted Successfully')</script>";
	}
	else
	{
		echo "<script type='text/javascript'>alert('failed!')</script>";
	}
}
echo ("<script LANGUAGE='JavaScript'>
			window.location.href='list_school_academic_year.php';
			</script>"); 


?>