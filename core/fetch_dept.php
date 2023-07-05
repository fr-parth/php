<?php 
//Created by Rutuja Jori to make Department list dynamic on 27/01/2020
include('conn.php');
  $id_employee=$_POST['id_employee'];
$school_id= $_SESSION['school_id'];


if($id_employee=='133' || $id_employee=='134' || $id_employee=='135' || $id_employee=='137')
{
  $sqldept ="select Dept_Name,Dept_code from tbl_department_master where school_id='$school_id' and Is_Enabled='1' ORDER BY Dept_Name";
  
  
  $querydept = mysql_query($sqldept);
 
?> 
 <option value="">Select Department</option>
<?PHP 
 while( $rows = mysql_fetch_assoc($querydept))
  {  
?>
                       <option value="<?php echo $rows['Dept_Name']?>,<?php echo $rows['Dept_code']?>"><?php echo $rows['Dept_Name']."(".$rows['Dept_code'].")"; ?></option></option>
  
<?php 
  }   
} else { ?>
<option value="NULL">All</option>
<?php 

$sqldept ="select Dept_Name,Dept_code from tbl_department_master where school_id='$school_id' and Is_Enabled='1' ORDER BY Dept_Name";
  
  
  $querydept = mysql_query($sqldept);
 
 while( $rows = mysql_fetch_assoc($querydept))
  {  
?>
    <option value="<?php echo $rows['Dept_Name']?>,<?php echo $rows['Dept_code']?>"><?php echo $rows['Dept_Name']."(".$rows['Dept_code'].")"; ?></option></option>
  
<?php 
  
  }

} ?>
  
