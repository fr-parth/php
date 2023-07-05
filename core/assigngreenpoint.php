<?php
       if(isset($_GET['name']))
	   {
		include_once("school_staff_header.php");

	if(!isset($_SESSION['staff_id']))
	{
		header('location:index.php');
	}

	      
$results=mysql_query("select * from tbl_school_adminstaff where id=".$staff_id."");
$scadmin=mysql_fetch_array($results);
	$school_id = $scadmin['school_id'];

             
	$sql="SELECT * FROM tbl_teacher where school_id='$school_id' order by id";
	$row=mysql_query($sql);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title>School Teachers</title>


<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>

  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <style>
  /* Body cells */
  table {
	border-collapse:collapse;
	margin-bottom:15px;
	width:90%;
	}
tabletbody th {
    text-align: left;
    background: #99CC66;
}
 

  </style>
  
 
  <script>
      $(document).ready(function(){
     $('#example').dataTable()
		  ({ 	
    		});
		});
	
   </script>
 </head>

<body bgcolor="#CCCCCC">

</body>
</html>
<?php   
		}
		else
		{
	include("scadmin_header.php");

$smartcookie=new smartcookie();
	if(!isset($_SESSION['id']))
	{
		header('location:index.php');
	}

	$id=$_SESSION['id'];
           $fields=array("id"=>$id);
		   $table="tbl_school_admin";
		   
		   $smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$scadmin=mysql_fetch_array($results);
	$school_id = $scadmin['school_id'];


	$sql="SELECT * FROM tbl_teacher where school_id='$school_id' and (t_emp_type_pid=133 or `t_emp_type_pid`=132) order by t_complete_name ASC";
	$row=mysql_query($sql);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title>School Teachers</title>


<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
 <link rel="stylesheet" href="css/bootstrap.min.css">
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>

  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <body bgcolor="#CCCCCC">
  <h1>Work in progress</h1>
  
</body>
</html>
<?php
	}
	?>

