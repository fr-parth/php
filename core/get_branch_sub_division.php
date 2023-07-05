<?php
 include("conn.php");
$id=$_SESSION['id'];

$sql=mysql_query("select school_id from tbl_school_admin where id='$id'");
$result=mysql_fetch_array($sql);
$sc_id=$_SESSION['school_id'];

switch($_GET['fn']){
	
	
	
	case 'fun_course':
		$row=mysql_query("select DISTINCT Dept_Name,ExtDeptId from  tbl_department_master where school_id='$sc_id' and ExtDeptId !='' order by id"); 
			echo "<option>select</option>";
		  while($val=mysql_fetch_array($row))
		  {
		  	  echo "<option value='$val[ExtDeptId],$val[Dept_Name]'> $val[Dept_Name]</option>";
		   }
		  
		break;	
		
//Added or Dept_Name='".$_GET['value']."' condition by Pranali for SMC-5005
		case 'fun_dept':
		$v=$_GET['value'];
		$val1= explode(",", $v);
		$value = $val1['0'];
		$sqlquery= mysql_query("select * from  tbl_department_master where school_id='$sc_id' and (ExtDeptId='".$value."' or Dept_Name='".$_GET['value']."') order by id");
		$val1=mysql_fetch_array($sqlquery);	
		
		$row=mysql_query("select * from  tbl_branch_master where school_id='$sc_id' and DepartmentName='".$val1['Dept_Name']."'  and ExtBranchId !=''"); 
			echo "<option>select</option>";
		  while($val=mysql_fetch_array($row))
		  {
		  	  echo "<option value='$val[ExtBranchId],$val[branch_Name]'> $val[branch_Name]</option>";
		   }
		
		//$row=mysql_query("select distinct Branch_name from  tbl_semester_master where Department_Name='".$_GET['value']."' and school_id='$sc_id' and Is_enable='1' "); 
		//	echo "<option>select</option>";
		//  while($val=mysql_fetch_array($row))
		//  {
		//  	  echo "<option value='$val[Branch_name]'> $val[Branch_name]</option>";
		//   }
		  
		break;	
		
		case 'fun_branch':
		$v=$_GET['value'];
		$val1= explode(",", $v);
		$value = $val1['0'];
		$sqlquery= mysql_query("select * from  tbl_branch_master where school_id='$sc_id' and ExtBranchId='".$value."' order by id");
		$val1=mysql_fetch_array($sqlquery);
		$row=mysql_query("select DISTINCT Semester_Name ,ExtSemesterId from  tbl_semester_master where Branch_name='$val1[branch_Name]' and school_id='$sc_id' and ExtSemesterId !=''"); 
			echo "<option>select</option>";
		  while($val=mysql_fetch_array($row))
		  {
		  	  echo "<option value='$val[ExtSemesterId],$val[Semester_Name]'> $val[Semester_Name]</option>";
		   }
		  
		break;	
		
		
		case 'fun_academc':
		
		$row=mysql_query("select * from   tbl_academic_Year where Academic_Year='".$_GET['value']."' and school_id='$sc_id'"); 
		echo "<option>select</option>";
		  while($val=mysql_fetch_array($row))
		  {
		  	  echo "<option value='$val[ExtYearID],$val[Year]'> $val[Year]</option>";
		   }
		  
		break;	

case 'fun_yearid':
echo "<input type='text' value='".$_GET['value']."' />";
break;
		
}

?>