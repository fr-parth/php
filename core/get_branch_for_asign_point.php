<?php
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
$query = mysql_query("select school_id from tbl_school_admin where id ='$id'");
$value = mysql_fetch_array($query);
$school_id=$value['school_id']; ?>



<?php
$value=$_GET['course'];
if($value=="Dept")
{
//change in below query done by Pranali for bug SMC-3312
	//SMC-4974 by Pranali : modified below query to solve extra dept name getting displayed into dept name dropdown
	//SMC-4974 by Pranali : modified below query for displaying all departments of school
 $row=mysql_query("SELECT DISTINCT  `Dept_Name`,school_id FROM `tbl_department_master` where `Dept_Name`!=' ' AND `Dept_Name`!='' AND `school_id`='$school_id' order by Dept_Name"); 
  ?>
  
 
 <?php
echo "<div style='float:left; padding:10px 0 0 10px;'>
<div style='float:left; padding-right:25px'>Select Department</div>
            <select name='Department' id='Department' class='form-control' onChange='showbranchwise(this.value)' style='width:152px;margin-left: 13px;'>
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
