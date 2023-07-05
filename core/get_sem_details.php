<?php 
//include('scadmin_header.php');
include('conn.php');
  
$sc_id= $_SESSION['school_id'];
  if (($_POST['course']!='') && ($_POST['department']!=''))
{ 
 $department = $_POST['department'];
 $course = $_POST['course'];

$row=mysql_query("select DISTINCT branch_Name from tbl_branch_master where school_id='$sc_id' and DepartmentName='$department' and Course_Name='$course' order by id "); ?>
			<option>Select Branch</option>
		 <?php while($val=mysql_fetch_array($row))
		  {?>
		  	  <option value="<?php echo $val['branch_Name']?>"><?php echo  $val['branch_Name']?></option>";
		  <?php }

}
if($_POST['branch']!=''){
$branch = $_POST['branch'];
$row=mysql_query("select DISTINCT Semester_Name from tbl_semester_master where school_id='$sc_id' and branch_Name='$branch' order by Semester_Id ");     
  echo "<option value=''>Select</option>";
  
  while($val=mysql_fetch_array($row))		
	  {		 
  
  echo "<option value='$val[Semester_Name]'> $val[Semester_Name]</option>";  
  }
 }
?>