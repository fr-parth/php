<?php

	include_once("hr_header.php");
    error_reporting(0);
	      /* $id=$_SESSION['id'];
           $fields=array("id"=>$id);
		   $table="tbl_school_admin";
           $smartcookie=new smartcookie();*/

$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$school_id=$result['school_id'];
    	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta charset="utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Smart Cookie Program</title>
</head>

<body>

<div class="container" style="padding-top:30px;">

<div class="row" style="padding-top:20px;">

<div class="col-md-3"><a href="managerlist.php?entity=11" style="text-decoration:none;">
<div class="panel panel-info ">
  <div class="panel-heading">
    <h3 class="panel-title" align="center"><b>No. of Managers</b> </h3>
  </div>
  <div class="panel-body" style="font-size:x-large" align="center">
	<?php 		
				$sql_t1="select count(t_id) as count from tbl_teacher where (`t_emp_type_pid`=133 or `t_emp_type_pid`=134 )and school_id='$school_id'";
				$row_t1=mysql_query($sql_t1);
				$count1=mysql_fetch_array($row_t1);
				echo $count1['count'];
	?>
  </div>
</div></a>
</div>

<div class="col-md-3"><a href="techanical_staflist.php?entity=11" style="text-decoration:none;">
<div class="panel panel-info ">
  <div class="panel-heading">
    <h3 class="panel-title" align="center"><b>No.of Techanical Staff</b> </h3>
  </div>
  <div class="panel-body" style="font-size:x-large" align="center">
  <?php 		
	$sql_t1="select count(t_id) as count from tbl_teacher where `t_emp_type_pid`!=133 and `t_emp_type_pid`!=134 and school_id='$school_id'";
				 $row_t1=mysql_query($sql_t1);
				 $count1=mysql_fetch_array($row_t1);
				            echo $count1['count'];
							
				?>
  </div>
</div></a>
</div>

<div class="col-md-3">
	<a href="Nontechanicallist.php?entity=11" style="text-decoration:none;">
<div class="panel panel-info ">
	<div class="panel-heading">
		<h3 class="panel-title" align="center"><b>No.of Non Techanical Staff</b> </h3>
	</div>
	<div class="panel-body" style="font-size:x-large" align="center">
	<?php 		
		$sql_t1="select count(t_id) as count from tbl_teacher where `t_emp_type_pid`!=133 and `t_emp_type_pid`!=134 and school_id='$school_id'";
		$row_t1=mysql_query($sql_t1);
		$count1=mysql_fetch_array($row_t1);
		echo $count1['count'];
							
	?>
	</div>
</div>
	</a>
</div>


<div class="col-md-3"><a href="employeelist.php?entity=11" style="text-decoration:none;">
<div class="panel panel-info ">
		<div class="panel-heading">
			<h3 class="panel-title" align="center"><b>No. of Employee</b> </h3>
		</div>
  
	<div class="panel-body" style="font-size:x-large" align="center">
		
		<?php 
						
					$sql_t="select count(id) from tbl_student where school_id='$school_id'";
					$row_t=mysql_query($sql_t);
					$r=mysql_fetch_array($row_t); 
					echo $c_parent=$r['0'];
				    
		?>
	</div>
	
</div></a>
</div>


</div>


<div class="row" style="padding-top:20px;">
<div class="col-md-3"><a href="list_manager_Project.php?entity=11" style="text-decoration:none;">
<div class="panel panel-info ">
  <div class="panel-heading">
    <h3 class="panel-title" align="center"><b>No. of Project Head</b> </h3>
  </div>
<div class="panel-body" style="font-size:x-large" align="center">

                 <?php							
				 $sql_sp="select count(tch_sub_id) as count from  tbl_teacher_subject_master where school_id='$school_id' ";
				 $row_sp=mysql_query($sql_sp);
				 $count_sp=mysql_fetch_array($row_sp);
				  echo $count_sp['count'];?>
  </div>
</div></a>
</div>
<div class="col-md-3"><a href="Sponsorlist1.php?entity=11" style="text-decoration:none;">
<div class="panel panel-info ">
  <div class="panel-heading">
    <h3 class="panel-title" align="center"><b>No. of Sponsors</b> </h3>
  </div>
  <div class="panel-body" style="font-size:x-large" align="center">
 <?php	
					$sql_sp="select count(id) as count from tbl_sponsorer ";
					$row_sp=mysql_query($sql_sp);
					$count_sp=mysql_fetch_array($row_sp);
				   echo $count_sp['count'];?>
  </div>
</div></a>
</div>


<div class="col-md-3"><a href="list_company_projects.php?entity=11" style="text-decoration:none;">
<div class="panel panel-info ">
		<div class="panel-heading">
			<h3 class="panel-title" align="center"><b>No. of Projects</b> </h3>
		</div>
		<div class="panel-body" style="font-size:x-large" align="center">
				
				<?php
						
							
					$sql_sp="select count(id) as count from tbl_school_subject where school_id='$school_id'";
					$row_sp=mysql_query($sql_sp);
					$count_sp=mysql_fetch_array($row_sp);
					echo $count_sp['count'];
				?>
		</div>
</div></a>
</div>


<div class="col-md-3"><a href="list_Employee_Project.php" style="text-decoration:none;">
<div class="panel panel-info ">
  <div class="panel-heading">
    <h3 class="panel-title" align="center"><b>No. of employee per project</b> </h3>
  </div>
  <div class="panel-body" style="font-size:x-large" align="center">

				<?php


					$sql_sp="select count(id) as count from  tbl_student_subject_master where school_id='$school_id'";
					$row_sp=mysql_query($sql_sp);
					$count_sp=mysql_fetch_array($row_sp);
					echo $count_sp['count'];
				?>
  </div>
</div></a>
</div>
</div>


<div class="row" style="padding-top:20px;">

	<div class="col-md-3"><a href="list_company_department.php?entity=11" style="text-decoration:none;">
		<div class="panel panel-info ">
		<div class="panel-heading">
			<h3 class="panel-title" align="center"><b>No. of Departments</b> </h3>
		</div>
		<div class="panel-body" style="font-size:x-large" align="center">

                 <?php							
				 $sql_sp="select count(id) as count from  tbl_department_master where school_id='$school_id' ";
				 $row_sp=mysql_query($sql_sp);
				 $count_sp=mysql_fetch_array($row_sp);
				  echo $count_sp['count'];?>
		</div>
		</div></a>
	</div>

	<div class="col-md-3"><a href="list_company_academic_year.php" style="text-decoration:none;">
	<div class="panel panel-info ">
		<div class="panel-heading">
			<h3 class="panel-title" align="center"><b>No. of Academic Years</b> </h3>
		</div>
	<div class="panel-body" style="font-size:x-large" align="center">

            <?php


					$sql_sp="SELECT count(id) as count FROM `tbl_academic_Year` WHERE `school_id` ='$school_id'";
					$row_sp=mysql_query($sql_sp);
					$count_sp=mysql_fetch_array($row_sp);
					echo $count_sp['count'];
			?>
	</div>
	</div></a>
	</div>

	<div class="col-md-3"><a href="Clientlist.php?entity=11" style="text-decoration:none;">
		<div class="panel panel-info ">
		<div class="panel-heading">
			<h3 class="panel-title" align="center"><b>No. of Clients</b> </h3>
		</div>
		<div class="panel-body" style="font-size:x-large" align="center">

               <?php


				 $sql_sp="SELECT count(id) as count FROM `tbl_academic_Year` WHERE `school_id` ='$school_id'";
				 $row_sp=mysql_query($sql_sp);
				 $count_sp=mysql_fetch_array($row_sp);
				 echo $count_sp['count'];?>
		</div>
		</div></a>
	</div>

</div>

</div>


</body>
</html>
