<?php
//Below code added by Rutuja Jori on 21/12/2019 for SMC-4278

include("scadmin_header.php");
$id=$_SESSION['id'];
$sql=mysql_query("select school_id from tbl_school_admin where id='$id'");
$result=mysql_fetch_array($sql);
$sc_id=$_SESSION['school_id'];switch($_GET['fn'])
{	
case 'fun_emp_type_edit':
	 $a = $_GET['value'];	
    $b = explode (",", $a);
  $c = $b[0];
   
  echo "<option value='-1'>Select</option>";	
  $row=mysql_query("select * from tbl_teacher where t_dept='$c' and school_id='$sc_id' and t_emp_type_pid<=135");
  while($val=mysql_fetch_array($row))		 
	  {		  	  
  
echo "<option value='$val[t_id],$val[t_complete_name]'> $val[t_complete_name]</option>";  
  }		break;	
  
 
 }
 ?>