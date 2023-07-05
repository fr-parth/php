<?php


include('scadmin_header.php');?>

<?php
$report="";

/*$id=$_SESSION['id']; */
           $fields=array("id"=>$id);
		  /* $table="tbl_school_admin";  */
		   
		   $smartcookie=new smartcookie();
		   
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$sc_id=$result['school_id'];


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
<title>Info Table</title>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"></link>
<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function(){
    $('#example').DataTable();
});
</script>
</head>
<body>

<div class="container">
<div  align="center"  >
	<h2><?php echo $dynamic_student; ?> <?php echo $dynamic_subject; ?></h2>
 </div>
<form method="post">
<table align="center" style="margin-top: 1cm;">
<tr>
<td>
<dic class='row'>
<div class=''>
<div class="form-group has-success">
<label>Enter <?php echo $dynamic_student; ?> Name</label>
<input   class="form-control"  type="text" name="name" placeholder="<?php echo $dynamic_student;?> Name" value="<?php if(isset($_POST['name'])) { echo $_POST['name']; }?>">
</div>
</div>
</td>
<td><?php echo "&nbsp"  ?></td>
<td>
<div class=''>

<div class="form-group has-success">
<label>Enter Class</label>
<input   class="form-control"  type="text" name="class" placeholder="Class" value="<?php if(isset($_POST['class'])) { echo $_POST['class']; }?>">
</div>
</div>
</td>
<td><?php echo "&nbsp"  ?></td>
<td>
<div class=''>
<div class="form-group has-success">
<label>Enter <?php echo $dynamic_subject; ?> Name</label>
<input  class="form-control"  type="text" name="subname" placeholder="<?php echo $dynamic_subject; ?> Name" value="<?php if(isset($_POST['subname'])) { echo $_POST['subname']; }?>">
</div>
</div>
</td>
<td><?php echo "&nbsp"  ?></td>
<td>
<div class=''>
<div class="form-group has-success">
<label>Select <?php echo $dynamic_semester;?></label>
<select class="form-control" name="semesterid" >
<option value="<?php if(isset($_POST['semesterid'])) { echo $_POST['semesterid'];} else { echo "" ;}?>"><?php if(isset($_POST['semesterid'])) { echo $_POST['semesterid'];} else { echo "Select $dynamic_semester" ;}?></option>
<option value="Semester I">Semester I</option>
<option value="Semester II">Semester II</option>
<option value="Semester III">Semester III</option>
<option value="Semester IV">Semester IV</option>
<option value="Semester V">Semester V</option>
<option value="Semester VI">Semester VI</option>
</select>
</div>
</div>
</td>
</tr>
<tr>
<td>
<div class=''>
<div class="form-group has-success">
<label>Enter <?php echo $dynamic_branches;?></label>
<input  class="form-control"  type="text" name="branchid" placeholder="<?php echo $dynamic_branches;?>" value="<?php if(isset($_POST['branchid'])) { echo $_POST['branchid']; }?>">
</div>
</div>
</td>
<td><?php echo "&nbsp"  ?></td>
<td>
<div class=''>
<div class="form-group has-success">
<label>Enter Department</label>
<input  class="form-control"  type="text" name="deptid" placeholder="Department" value="<?php if(isset($_POST['deptid'])) { echo $_POST['deptid']; }?>">
</div>
</div>
</td>
<td><?php echo "&nbsp"  ?></td>

<!-- Added Academic Year dropdown list code by Chaitali for SMC-4619 -->

<?php $query_acadamic = mysql_query("select * from tbl_academic_Year where school_id='$sc_id'"); ?>

<td>
<div class=''>
<div class="form-group has-success">
<label>Select <?php echo $dynamic_year;?></label>
<select class="form-control" name="acayear" >
<option value="<?php if(isset($_POST['acayear'])) { echo $_POST['acayear']; }?>"><?php if(isset($_POST['acayear'])) { echo $_POST['acayear']; } else {echo 'Select Academic Year';}?></option>
<?php while($row = mysql_fetch_array($query_acadamic)) { ?>
<option value="<?php echo $row['Academic_Year']; ?>"><?php echo $row['Academic_Year']; ?></option>
<?php } ?>
<!--
<input  class="form-control"  type="text" name="acayear" placeholder=" <?php echo $dynamic_year;?>" value="<?php if(isset($_POST['acayear'])) { echo $_POST['acayear']; }?>">
-->
</div>
</div>
</td>

<td><?php echo "&nbsp"  ?></td>
<td>
<div class=''>
<div class="btn btn-group has-success">
<input  class="form-control"  type="submit" value="Submit" name="submit">
</div>
</div>
</td>
</table>
</form>
</div>


<?php

if(isset($_POST['submit']))
{
$name = trim($_POST['name']);
$class = trim($_POST['class']);
$subname = trim($_POST['subname']);
$semesterid = trim($_POST['semesterid']);
$branchid = trim($_POST['branchid']);
$deptid = trim($_POST['deptid']);
$acayear = trim($_POST['acayear']);


$query="SELECT a.std_complete_name, a.std_class, b.SubjectName, b.semester_id, b.Branches_id, b.Department_id, b.academicyear
FROM tbl_student AS a
INNER JOIN tbl_student_subject_master AS b ON a.std_PRN = b.student_id";
$query1=" where ";

if($_POST['name']==''  &  $_POST['class']=='' & $_POST['subname']=='' & $_POST['semesterid']=='' & $_POST['branchid']=='' & $_POST['deptid']=='' & $_POST['acayear']=='' )
	{
		echo "<script>window.alert('please enter a field')</script>";
		echo "<script>window.location.assign('displaystudsubject.php')</script>";
	}
else
{
	$f = 0;
	if($name!='')
		{
			$query1.="a.std_complete_name like '%$name%'";
			$f = 1;
		}
	if($class!='')
		{
			if($f==1)
				{
					$query1.= ' and ';
				}
			$query1.="a.std_class like '%$class%'";
			$f = 1;
		}
	if($subname!='')
		{
			if($f==1)
				{
					$query1.= ' and ';
				}
			$query1.="b.SubjectName  like '%$subname%'";
			$f = 1;
		}
	if($semesterid!='')
		{
			if($f==1)
				{
					$query1.= ' and ';
				}
			$query1.="b.semester_id like '$semesterid'";
			$f = 1;
		}
	if($branchid!='')
		{
			if($f==1)
				{
					$query1.= ' and ';
				}
			$query1.="b.Branches_id like '%$branchid%'";
			$f = 1;
		}
	if($deptid!='')
		{
			if($f==1)
				{
					$query1.= ' and ';
				}
			$query1.="b.Department_id like '%$deptid%'";
			$f = 1;
		}
		if($acayear!='')
		{
			if($f==1)
				{
					$query1.= ' and ';
				}
			$query1.="b.academicyear like '%$acayear%'";
			$f = 1;
		}
	
	 $query_final=$query.$query1." and b.school_id='$sc_id' and a.school_id='$sc_id'";
	
	$sql = mysql_query($query_final);
	
	
	
	if(mysql_num_rows($sql)>0)
		{
			?>
            
            
			<table id="example" class="display" cellspacing="0" width="100%" >
			
            <thead>
			<tr style="background-color:#909497;color: white;"><th align='center' >Sr.No</th>
			<th style="text-align:center"><?php echo $dynamic_student; ?> Name</th>
			<th style="text-align:center">Class</th>
			<th style="text-align:center"><?php echo $dynamic_subject; ?> Name</th>
			<th style="text-align:center"><?php echo $dynamic_semester;?></th>
			<th style="text-align:center"><?php echo $dynamic_branches;?></th>
			<th style="text-align:center">Department</th>
			<th style="text-align:center"><?php echo $dynamic_year;?></th></tr>
              </thead>
            <tbody>
            
            <?php
			$c = 1;
			while($rows = mysql_fetch_array($sql,MYSQLI_NUM))
				{
					
					echo "<tr>";
					
					echo "<td >$c</td>";
				
					foreach($rows as $k=>$v)
						{
							
							
								echo "<td style='padding:10px;' align='center'>$v</td>";
							
						}
					echo "</tr>";
				$c++;
				}
			echo "</tbody></table>";
		}
		
	else
		{
			echo "<script>window.alert('No records found')</script>";
			echo "<script>window.location.assign('displaystudsubject.php')</script>";
		}
		

}
	

}


?>

</body>
</html>
<?php

?>

