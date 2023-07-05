<?php
 include("conn.php");
$id=$_SESSION['id'];

$sql=mysql_query("select school_id from tbl_school_admin where id='$id'");
$result=mysql_fetch_array($sql);
$sc_id=$result['school_id'];

switch($_GET['fn']){
	
	
	
	case 'fun_course':
	$row=mysql_query("select * from  tbl_department_master where school_id='$sc_id' order by id"); 
			echo "<option>select</option>";
		  while($val=mysql_fetch_array($row))
		  {
		  	  echo "<option value='$val[ExtDeptId],$val[Dept_Name]'> $val[Dept_Name]</option>";
		   }
		  
		break;	
		
		
		case 'fun_dept':
		$a = $_GET['value'];
		$b = explode (",", $a);
		$c = $b[1];
		$row=mysql_query("select *from  tbl_branch_master where DepartmentName='$c' and school_id='$sc_id' "); 
			echo "<option>select</option>";
		  while($val=mysql_fetch_array($row))
		  {
		  	  echo "<option value='$val[ExtBranchId],$val[branch_Name]'> $val[branch_Name]</option>";
		   }
		 
		break;	
		


		
		
		
		
		
		

		
}


?>