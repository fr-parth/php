
<?php
 include("conn.php");
$id=$_SESSION['id'];

$query = mysql_query("select school_id from tbl_school_admin where id = '$id' ");
$value = mysql_fetch_array($query);

$school_id=$value['school_id'];

?>



<?php
$department=$_GET['dept'];
$degree=$_GET['degree'];
$course=$_GET['course'];




  $row=mysql_query("SELECT branch_Name,Branch_code FROM tbl_branch_master WHERE Dept_Id=".$department." AND Course_Name='".$course."' AND degree_code=".$degree.""); 
 echo "<option value='' selected> Select</option>";
  while($val=mysql_fetch_array($row))
  {
  
  echo "<option value='$val[Branch_code]'>$val[branch_Name]</option>";
  
  }
 
 




?>
