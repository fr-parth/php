<?php
session_start();
include("conn.php");
if($_SESSION['usertype']=='HR Admin Staff' OR $_SESSION['usertype']=='School Admin Staff')
	{
		$sc_id=$_SESSION['school_id']; 
		$query2 = mysql_query("select id from tbl_school_admin where school_id ='$sc_id'");

    $value2 = mysql_fetch_array($query2);

    $id = $value2['id'];
		
		
	}
	else
	{
		$id = $_SESSION['id'];
	}

$query = mysql_query("select school_id,school_type from tbl_school_admin where id ='$id'");
$value = mysql_fetch_array($query);
$school_id=$value['school_id'];
$scType = $value['school_type'];
if($scType=="organization"){ $dynamic_branch = "Section";}else{$dynamic_branch = "Branch";}
?>



<?php
$value=$_GET['course'];
if($value=="Dept"){
//echo "select Degee_name,Degree_code from tbl_degree_master where school_id='$sc_id' and course_level='$value'";die;

  // $row=mysql_query("SELECT DISTINCT  `std_branch`,school_id FROM `tbl_student` where `std_branch`!=' ' AND `school_id`='$school_id'"); 

 // SMC-4276 By Kunal change query for fetch department list from tbl_department_master
  $row=mysql_query("SELECT DISTINCT  `Dept_Name`,school_id FROM `tbl_department_master` where `Dept_Name`!=' ' AND `Dept_Name`!='' AND `school_id`='$school_id' order by Dept_Name"); 
  //modified width:152px by Pranali for SMC-4975 
echo " <div class='row1 form-inline'>
<div style='float:left'>Select Department</div>
             <select name='Department' id='Department' class='form-control' onChange='showbranchwise(this.value)'  style='width:152px;margin-left:14px;'>
			 <option value='select'>Select</option>";
  while($val=mysql_fetch_array($row))
  {    
   echo "<option value='".$val['Dept_Name']."'>".$val['Dept_Name']."</option>";
  }
 
 echo " </select>
      </div>";

}else{
echo '';
}


?>
