<?php
include("scadmin_header.php");
$id=$_SESSION['id'];
$sql=mysql_query("select school_id from tbl_school_admin where id='$id'");
$result=mysql_fetch_array($sql);
$sc_id=$result['school_id'];switch($_GET['fn'])
{	

 //Below case added by Rutuja Jori on 22/11/2019 for getting higher authorities names from Teacher/Manager name for SMC-4208
 case 'fun_emp_type':
  $a = $_GET['value'];
  $b = explode (",", $a);
   $c = $b[0];
		$row=mysql_query("select distinct(t_complete_name),t_id,t_emp_type_pid from tbl_teacher where t_emp_type_pid > '$c' and school_id='$sc_id'"); 
		echo "<option>select</option>";
		  while($val=mysql_fetch_array($row))
		  {
	
			  
   echo "<option value='$val[t_id],$val[t_emp_type_pid]'> $val[t_complete_name]</option>";  
		   }
		 echo "<option value='-1,-1' style='font-weight:bold'>NO Reporting Authority</option>";    
		
 break;

 case 'fun_emp_type_edit':
  $a = $_GET['value'];
  $b = explode (",", $a);
   $c = $b[0];
		$row=mysql_query("select distinct(t_complete_name),t_id,t_emp_type_pid from tbl_teacher where t_emp_type_pid > '$c' and school_id='$sc_id'"); 
		echo "<option>select</option>";
		  while($val=mysql_fetch_array($row))
		  {
	
			  
   echo "<option value='$val[t_id],$val[t_emp_type_pid]'> $val[t_complete_name]</option>";  
		   }
		 echo "<option value='-1,-1' style='font-weight:bold'>NO Reporting Authority</option>";    
		
 break;
 
 }

 
 ?>