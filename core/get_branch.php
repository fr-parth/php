<?php include('scadmin_header.php');?>

<?php
$report="";

$id=$_SESSION['id'];
           $fields=array("id"=>$id);
		   $table="tbl_school_admin";
		   
		   $smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$school_id=$result['school_id'];?>
</head>
<body>

<?php
$activity_type = $_GET['activity_type'];
               

	
  $row=mysql_query("select * from tbl_branch_master where Dept_Id='$activity_type' and  school_id='$school_id'"); 
  echo "<option value='' selected> Select</option>";
  while($val=mysql_fetch_array($row))
  {
  
  echo "<option value='$val[Branch_code]'> $val[branch_Name]</option>";
  
  }

?>
</body>
</html>