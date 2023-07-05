<?php
include("scadmin_header.php");
$id=$_SESSION['id'];
$sql=mysql_query("select school_id from tbl_school_admin where id='$id'");
$result=mysql_fetch_array($sql);
$sc_id=$_SESSION['school_id'];

//Below conditions added by Rutuja for SMC-5049 on 18-12-2020
if (($_POST['course']!='') && ($_POST['department']!=''))
{ 
 $department = $_POST['department'];
 $course = $_POST['course'];

$row=mysql_query("select branch_Name,ExtBranchId from tbl_branch_master where school_id='$sc_id' and DepartmentName='$department' and Course_Name='$course' order by id "); ?>
			<option>Select Branch</option>
		 <?php while($val=mysql_fetch_array($row))
		  {?>
		  	  <option value="<?php echo $val['ExtBranchId']?>,<?php echo $val['branch_Name']?>"><?php echo  $val['branch_Name']?></option>";
		  <?php }


}
if($_GET['fn']!=''){
switch($_GET['fn'])
{	
case 'fun_course':
		
$row=mysql_query("select Dept_Name,ExtDeptId from tbl_department_master where school_id='$sc_id' order by id ");   
   
  echo "<option value=''>Select</option>";	
  
  while($val=mysql_fetch_array($row))		 
	  {		  	  
  //echo "<option value='$val[Dept_Id]'> $val[Department_Name]</option>";	



echo "<option value='$val[ExtDeptId],$val[Dept_Name]'> $val[Dept_Name]</option>";  
  }		break;	
  

case 'fun_dept':
		$a = $_GET['value'];
		$b = explode (",", $a);
		$c = $b[1];
		$row=mysql_query("select branch_Name,ExtBranchId from tbl_branch_master where school_id='$sc_id' and DepartmentName='$c' order by id "); 
			echo "<option>select</option>";
		  while($val=mysql_fetch_array($row))
		  {
		  	  echo "<option value='$val[ExtBranchId],$val[branch_Name]'> $val[branch_Name]</option>";
		   }
		 
		break;	

  case 'fun_branch':
  
  $a = $_GET['value'];
  $b = explode (",", $a);
  $c = $b[1];
  
  $row=mysql_query("select DISTINCT Semester_Name,ExtSemesterId from tbl_semester_master where school_id='$sc_id' and branch_Name='$c' order by Semester_Id ");     
  echo "<option value=''>Select</option>";
  
  while($val=mysql_fetch_array($row))		
	  {		 
  
  echo "<option value='$val[ExtSemesterId],$val[Semester_Name]'> $val[Semester_Name]</option>";  
  }
  break;


case 'fun_semester':

  $a = $_GET['value'];
  $b = explode (",", $a);
  $c = $b[1];
  
  $row=mysql_query("select distinct subject,ExtSchoolSubjectId  from   tbl_school_subject where school_id='$sc_id' ");     
  echo "<option value=''>Select</option>";
  
  while($val=mysql_fetch_array($row))		
	  {		 
  
  echo "<option value='$val[ExtSchoolSubjectId],$val[subject]'> $val[subject]</option>";    
  }
  break;
  
  //changes done by Sayali Balkawade to resolve issue in SMC-4188 on 14/11/2019
  		case 'fun_subject':
		
  $a = $_GET['value'];
  $b = explode (",", $a);
  $c = $b[0];
  
  

		$row=mysql_query("select distinct Subject_Code from  tbl_school_subject where Subject_Code='$c' and school_id='$sc_id'"); 
		  $val=mysql_fetch_array($row);
		   
  echo "<option value='$val[Subject_Code]'> $val[Subject_Code]</option>"; 
		  
		
 break;
 //Below case added by Rutuja Jori on 22/11/2019 for getting higher authorities names from Teacher/Manager name for SMC-4208
 case 'fun_teacher':
  $a = $_GET['value'];
  $b = explode (",", $a);
   $c = $b[0];
		$row=mysql_query("select distinct(t_complete_name),t_id,t_emp_type_pid from tbl_teacher where t_emp_type_pid > '$c' and school_id='$sc_id'"); 
		echo "<option>select</option>";
		  while($val=mysql_fetch_array($row))
		  {
	
			  
   echo "<option value='$val[t_emp_type_pid],$val[t_id]'> $val[t_complete_name]</option>";  
		   }
		 echo "<option value='-1,-1' style='font-weight:bold'>NO Reporting Authority</option>";    
		
 break;
 
 }
}
 ?>