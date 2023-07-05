<?php
include("conn.php");
$id=$_SESSION['id'];

$sql=mysql_query("select school_id from tbl_school_admin where id='$id'");
$result=mysql_fetch_array($sql);
$school_id=$result['school_id'];

switch($_GET['fn']){
	
		case 'fun_deptname':
		$a = $_GET['value'];
		$b = explode (",", $a);
		$c = $b[1];
		//$row=mysql_query("select * from  tbl_department_master where Dept_Name='$c' school_id='$school_id' ");
        $row=mysql_query("select Dept_code,ExtDeptId,trim(Dept_Name) as Dept_Name from tbl_department_master where School_ID='$school_id' and Dept_Name!='' and  Dept_Name='$c'group by Dept_Name order by trim(Dept_Name)  asc"); 
			
		  while($val=mysql_fetch_array($row))
		  {
		  	  echo "<option readonly value='$val[ExtDeptId],$val[Dept_code]'> $val[Dept_code]</option>";
              //  echo"<input type='text' value='$val[Dept_code]'/>";
		   }
		  
		break;
		
		}

        
?>