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
	<h2><?php echo $dynamic_student; ?></h2>
 </div>
<form method="post">
<table align="center" style="margin-top: 1cm;">
<!-- Added labels code by Chaitali for SMC-4619 -->
<tr>
<td>
<dic class='row'>
<div class=''>
<div class="form-group has-success">
<label>Enter <?php echo $dynamic_student; ?> Name</label>
<input   class="form-control"  type="text" name="name" placeholder="<?php echo $dynamic_student;?>  Name" value="<?php if(isset($_POST['name'])) { echo $_POST['name']; }?>">
</div>
</div>
</td>

<td><?php echo "&nbsp"  ?></td>

<td>
<div class=''>
<div class="form-group has-success">
<label>Enter <?php echo $dynamic_student; ?> ID</label>
<input   class="form-control"  type="text" name="std_PRN" placeholder="<?php echo $dynamic_student;?> ID" value="<?php if(isset($_POST['std_PRN'])) { echo $_POST['std_PRN']; }?>">
</div>
</div>
</td>

<td><?php echo "&nbsp"  ?></td>

<td>
<div class=''>
<div class="form-group has-success">
<label>Enter <?php echo $dynamic_student; ?> Department</label>
<input  class="form-control"  type="text" name="std_dept" placeholder="<?php echo $dynamic_student;?>   Department" value="<?php if(isset($_POST['std_dept'])) { echo $_POST['std_dept']; }?>">
</div>
</div>
</td>

<td><?php echo "&nbsp"  ?></td>

<td>
<div class=''>
<div class="form-group has-success">
<label>Enter <?php echo $dynamic_student; ?> Email ID</label>
<!-- Camel casing done for Student Email ID and Go by Pranali -->
<input  class="form-control"  type="text" name="std_email" placeholder="<?php echo $dynamic_student;?>   Email ID" value="<?php if(isset($_POST['std_email'])) { echo $_POST['std_email']; }?>">
</div>
</div>
</td>

</tr>

<tr>

<td>
<div class=''>
<div class="form-group has-success">
<label>Enter <?php echo $dynamic_student; ?> Phone No.</label>
<input  class="form-control"  type="text" name="std_phone" placeholder="<?php echo $dynamic_student;?> Phone No." value="<?php if(isset($_POST['std_phone'])) { echo $_POST['std_phone']; }?>">
</div>
</div>
</td>

<td><?php echo "&nbsp"  ?></td>

<?php $query_acadamic = mysql_query("select * from tbl_academic_Year where school_id='$sc_id'"); ?>

<td>
<div class=''>
<div class="form-group has-success">
<label>Select <?php echo $dynamic_year;?></label>
<select class="form-control" name="Academic_Year" >
<option value="<?php if(isset($_POST['Academic_Year'])) { echo $_POST['Academic_Year']; }?>"><?php if(isset($_POST['Academic_Year'])) { echo $_POST['Academic_Year']; } else {echo 'Select Academic Year';}?></option>
<?php while($row = mysql_fetch_array($query_acadamic)) { ?>
<option value="<?php echo $row['Academic_Year']; ?>"><?php echo $row['Academic_Year']; ?></option>
<?php } ?>
</select>
</div>
</div>
</td>

<td><?php echo "&nbsp"  ?></td>

<td>
<div class=''>
<div class="form-group has-success">
<label>Enter <?php echo $dynamic_level;?></label>
<input  class="form-control"  type="text" name="Course_level" placeholder="<?php echo $dynamic_level; ?>" value="<?php if(isset($_POST['Course_level'])) { echo $_POST['Course_level']; }?>">
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
$std_PRN = trim($_POST['std_PRN']);
$std_dept = trim($_POST['std_dept']);


$std_email = trim($_POST['std_email']);
$std_phone = trim($_POST['std_phone']);
$Academic_Year = trim($_POST['Academic_Year']);
$Course_level = trim($_POST['Course_level']);


$query="SELECT std_complete_name,std_PRN,std_dept,std_email,std_phone,Academic_Year,Course_level from tbl_student ";
$query1=" where ";

if($_POST['name']==''  &  $_POST['std_PRN']=='' & $_POST['std_dept']=='' & $_POST['std_email']=='' & $_POST['std_phone']==''  &  $_POST['Academic_Year']==''  &  $_POST['Course_level']=='')
	{
		echo "<script>window.alert('please enter a field')</script>";
		echo "<script>window.location.assign('student_search_engine.php')</script>";
	}
else
{
	$f = 0;
	if($name!='')
		{
			$query1.="std_complete_name like '%$name%'";
			$f = 1;
		}
	if($std_PRN!='')
		{
			if($f==1)
				{
					$query1.= ' and ';
				}
			$query1.="std_PRN like '%$std_PRN%'";
			$f = 1;
		}
	if($std_dept!='')
		{
			if($f==1)
				{
					$query1.= ' and ';
				}
			$query1.="std_dept  like '%$std_dept%'";
			$f = 1;
		}
	
	if($std_email!='')
		{
			if($f==1)
				{
					$query1.= ' and ';
				}
			$query1.="std_email like '%$std_email%'";
			$f = 1;
		}
		if($std_phone!='')
		{
			if($f==1)
				{
					$query1.= ' and ';
				}
			$query1.="std_phone like '%$std_phone%'";
			$f = 1;
		}
		if($Academic_Year!='')
		{
			if($f==1)
				{
					$query1.= ' and ';
				}
			$query1.="Academic_Year like '%$Academic_Year%'";
			$f = 1;
		}
		if($Course_level!='')
		{
			if($f==1)
				{
					$query1.= ' and ';
				}
			$query1.="Course_level like '%$Course_level%'";
			$f = 1;
		}
	
	$query_final=$query.$query1." and school_id='$sc_id'";
	
	$sql = mysql_query($query_final);
	
	
	
	if(mysql_num_rows($sql)>0)
		{
			?>
           
            
			<table id="example" class="display" cellspacing="0" width="100%" >
			
            <thead>
			<tr style="background-color:#909497;color: white;"><th align='center' >Sr.No</th>
			<th style="text-align:center"><?php echo $dynamic_student;?>   Name</th>
			<th style="text-align:center"><?php echo $dynamic_student;?> <?php echo $dynamic_student_prn;?></th>
			<th style="text-align:center"><?php echo $dynamic_student;?>   Department</th>
			
			
			<th style="text-align:center"><?php echo $dynamic_student;?>   Email</th>
			<th style="text-align:center"><?php echo $dynamic_student;?>   Phone</th>
			<th style="text-align:center">Academic Year</th>
			<th style="text-align:center">Course Level</th></tr>
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
			echo "<script>window.location.assign('student_search_engine.php')</script>";
		}
		

}
	

}


?>

</body>
</html>
<?php

?>

