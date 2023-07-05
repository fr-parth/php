<?php include_once("school_staff_header.php"); ?>

<?php
$report="";

$id=$_SESSION['staff_id'];
         
$results=mysql_query("SELECT * FROM `tbl_school_adminstaff` WHERE id =".$staff_id."");
$result=mysql_fetch_array($results);
$school_id=$result['school_id'];?>
</head>
<body>

<?php
$activity_type = intval($_GET['activity_type']);

  $row=mysql_query("select * from tbl_studentpointslist where sc_type='$activity_type' and  school_id='$school_id'"); 
  echo "<option value='' selected> Select</option>";
  while($val=mysql_fetch_array($row))
  {
  
  echo "<option value='$val[sc_id]'> $val[sc_list]</option>";
  
  }





?>
</body>
</html>