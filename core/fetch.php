<?php 
//include('scadmin_header.php');
include('conn.php');
  $deptName=$_POST['deptName'];
$sc_id= $_SESSION['school_id'];
$where="";
if($deptName=='')
{
	$where.="";
}
else
{
	$where.=" and t_dept='".$deptName."'";
}
  $sqldept = "SELECT t_id,t_complete_name FROM tbl_teacher where  school_id='".$sc_id."' $where";
  //echo $sqldept;
  
  $querydept = mysql_query($sqldept);
 // $rowcnt = mysql_num_rows($querydept);
 // echo $rowcnt;
?> 
 <option value="">All Manager</option>
<?PHP 
 while( $rows = mysql_fetch_assoc($querydept))
  {  
?>		<option value="<?php echo $rows["t_id"]; ?>"><?php echo $rows["t_complete_name"]; ?></option>  
<?php	
  // echo "<option value='".$rows[t_id]."'> ".$rows[t_complete_name]."</option>";
  }
   
?>