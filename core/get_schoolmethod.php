<?php
 include("conn.php");
$id=$_SESSION['id'];

$query = mysql_query("select * from tbl_student where id = '$id' ");
$value = mysql_fetch_array($query);

$school_id=$value['school_id'];
?>

</head>
<body>

<?php
 $value = xss_clean(mysql_real_escape_string($_GET['subject']));
 $domain = substr($value,0,8);

if($domain=="subject-")
{
 $subject_id=substr($value,8);
 $activity_id=0;
}
else
{
$activity_id=$value;
$subject_id=0;
}


  $row=mysql_query("select distinct me.id,method_name  from tbl_master m join tbl_method me on m.method_id=me.id where  (school_id='0' or school_id='$school_id') and subject_id='$subject_id' and activity_id='$activity_id'"); 
if(mysql_num_rows($row)>0)
{
  while($val=mysql_fetch_array($row))
  {
  
  echo "<option value='$val[id]'> $val[method_name]</option>";
  
  }
  }
  else
  {
   $rows=mysql_query("select id,method_name  from tbl_method ");
   while($values=mysql_fetch_array($rows))
   {
 
   echo "<option value='$values[id]'> $values[method_name]</option>";
   }
  }





?>
</body>
</html>