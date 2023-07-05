
<?php
 include("conn.php");
$id=$_SESSION['id'];

$query = mysql_query("select school_id from tbl_school_admin where id = '$id' ");
$value = mysql_fetch_array($query);

$school_id=$value['school_id'];

?>

</head>
<body>

<?php
 $value=$_GET['course'];


//echo "select Degee_name,Degree_code from tbl_degree_master where school_id='$sc_id' and course_level='$value'";die;

  $row=mysql_query("select Degee_name,Degree_code from tbl_degree_master where school_id='$school_id'"); 

  while($val=mysql_fetch_array($row))
  {
  
  echo "<option value='$val[Degree_code]'> $val[Degee_name]</option>";
  
  }
 
 




?>
