
<?php
 include("conn.php");
$id=$_SESSION['id'];

$query = mysql_query("select school_id from tbl_school_admin where id = '$id' ");
$value = mysql_fetch_array($query);

$school_id=$value['school_id'];

?>



<?php
$branch_id=$_GET['sem'];
$dpt=$_GET['dpt'];
$cors=$_GET['cors'];
                             $get_dpt_name=mysql_query("select Dept_Name from tbl_department_master where Dept_code='$dpt'");
							          $fetch_d_name=mysql_fetch_array($get_dpt_name);
									             $departmentName=$fetch_d_name['Dept_Name'];
												
												 $get_branch_name=mysql_query("select branch_Name from tbl_branch_master where Branch_code='$branch_id'");
							          $fetch_B_name=mysql_fetch_array($get_branch_name);
									             $BranchName=$fetch_B_name['branch_Name'];
												
//echo "SELECT `semester_name`,`Semester_Id FROM` FROM `tbl_semester_master` WHERE `Branch_name`='$BranchName' AND Department_Name='$departmentName' AND CourseLevel='$cors'";
//die;

  $row=mysql_query("SELECT `semester_name`,`Semester_Id` FROM `tbl_semester_master` WHERE `Branch_name`='$BranchName' AND Department_Name='$departmentName' AND CourseLevel='$cors'"); 
 echo "<option value='' selected> Select Semester</option>";
  while($val=mysql_fetch_array($row))
  {
    
   echo "<option value='$val[Semester_Id]'> $val[semester_name]</option>";
  
  }
 
 




?>
