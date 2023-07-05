<?php 
/*Author:Sayali Balkawade 
  Date:24/10/2020
  This file is created for academic year
*/
  include_once('../conn.php');
if($_POST['a_id'] !='')
{
$a_id=$_POST['a_id'];
$sql= "select  Academic_Year from tbl_student where Academic_Year!='' and school_id='$a_id' group by Academic_Year";
$query =mysql_query($sql);

$output = "<option value=''>Select Academic Year</option>";
if(mysql_num_rows($query)>0){
	//echo "in if";
	while($row= mysql_fetch_array($query)){
		$output .="<option value='".$row['Academic_Year']."'>".$row['Academic_Year']."</option>";
	}
}
echo $output;
}

if($_POST['t_id'] !='')
{
$t_id=$_POST['t_id'];
$sql= "select  t_academic_year from tbl_teacher where t_academic_year !='' and school_id='$t_id' group by t_academic_year";
$query =mysql_query($sql);

$output = "<option value=''>Select Academic Year</option>";
if(mysql_num_rows($query)>0){
	//echo "in if";
	while($row= mysql_fetch_array($query)){
		$output .="<option value='".$row['t_academic_year']."'>".$row['t_academic_year']."</option>";
	}
}
echo $output;
}
if($_POST['d_id'] !='')
{
$d_id=$_POST['d_id'];
$sql= "select  Establiment_Year from tbl_department_master where Establiment_Year !='' and School_ID='$d_id' group by Establiment_Year";
$query =mysql_query($sql);

$output = "<option value=''>Select Academic Year</option>";
if(mysql_num_rows($query)>0){
	//echo "in if";
	while($row= mysql_fetch_array($query)){
		$output .="<option value='".$row['Establiment_Year']."'>".$row['Establiment_Year']."</option>";
	}
}
echo $output;
}

if($_POST['s_id'] !='')
{
$d_id=$_POST['s_id'];
$sql= "select  Year_ID from tbl_school_subject where Year_ID!='' and school_id='$s_id' group by Year_ID";
$query =mysql_query($sql);

$output = "<option value=''>Select Academic Year</option>";
if(mysql_num_rows($query)>0){
	//echo "in if";
	while($row= mysql_fetch_array($query)){
		$output .="<option value='".$row['Year_ID']."'>".$row['Year_ID']."</option>";
	}
}
echo $output;
}
if($_POST['nt_id'] !='')
{
$nt_id=$_POST['nt_id'];
$sql= "select  t_academic_year from tbl_teacher where t_academic_year!='' and  school_id='$nt_id' AND t_emp_type_pid NOT IN (133,134) group by t_academic_year";
$query =mysql_query($sql);

$output = "<option value=''>Select Academic Year</option>";
if(mysql_num_rows($query)>0){
	//echo "in if";
	while($row= mysql_fetch_array($query)){
		$output .="<option value='".$row['t_academic_year']."'>".$row['t_academic_year']."</option>";
	}
}
echo $output;
}

//Added below condition by Pranali for SMC-4972 on 27-11-20
if($_POST['c_id'] !='')
{
$c_id=$_POST['c_id'];
$sql= "SELECT Academic_Year,Year FROM tbl_academic_Year where school_id='".$c_id."' and Academic_Year!='' and Year!='' group by Academic_Year";
$query =mysql_query($sql);

$output = "<option value=''>Select Academic Year</option>";
if(mysql_num_rows($query)>0){
	//echo "in if";
	while($row= mysql_fetch_array($query)){
		$output .="<option value='".$row['Year']."'>".$row['Academic_Year']."</option>";
	}
}
echo $output;
}

?>