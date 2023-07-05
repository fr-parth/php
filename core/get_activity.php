<?php include('scadmin_header.php');?>

<?php
$report="";

$id=$_SESSION['id'];
           $fields=array("id"=>$id);
		   $table="tbl_school_admin";
		   
		   $smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
//school_id taken from session & activity list ordered in ascending order by Pranali for SMC-5020 on 9-12-20
$school_id=$_SESSION['school_id'];?>
</head>
<body>

<?php
$activity_type = intval($_GET['activity_type']);

  $row=mysql_query("select * from tbl_studentpointslist where sc_type='$activity_type' and  school_id='$school_id' order by sc_list ASC"); 
  echo "<option value='' selected> Select</option>";
  while($val=mysql_fetch_array($row))
  {
  
  echo "<option value='$val[sc_id]'> $val[sc_list]</option>";
  
  }





?>
</body>
</html>