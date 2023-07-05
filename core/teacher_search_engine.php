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
	<h2><?php echo $dynamic_teacher; ?></h2>
 </div>
<form method="post">
<table align="center" style="margin-top: 1cm;">
<!-- Added labels code by Chaitali for SMC-4619 -->
<tr>

<td>
<dic class='row'>
<div class=''>
<div class="form-group has-success">
<label>Enter <?php echo $dynamic_teacher; ?> Name</label>
<input   class="form-control"  type="text" name="name" placeholder="<?php echo $dynamic_teacher;?> Name" value="<?php if(isset($_POST['name'])) { echo $_POST['name']; }?>">
</div>
</div>
</td>

<td><?php echo "&nbsp"  ?></td>

<td>
<div class=''>
<div class="form-group has-success">
<label>Enter <?php echo $dynamic_teacher; ?> ID</label>
<input   class="form-control"  type="text" name="t_id" placeholder="<?php echo $dynamic_teacher;?> ID" value="<?php if(isset($_POST['t_id'])) { echo $_POST['t_id']; }?>">
</div>
</div>
</td>

<td><?php echo "&nbsp"  ?></td>

<td>
<div class=''>
<div class="form-group has-success">
<label>Enter <?php echo $dynamic_teacher; ?> Department</label>
<input  class="form-control"  type="text" name="t_dept" placeholder="<?php echo $dynamic_teacher;?> Department" value="<?php if(isset($_POST['t_dept'])) { echo $_POST['t_dept']; }?>">
</div>
</div>
</td>

</tr>

<tr>

<td>
<div class=''>
<div class="form-group has-success">
<label>Enter <?php echo $dynamic_teacher; ?> Email ID</label>
<input  class="form-control"  type="text" name="t_email" placeholder="<?php echo $dynamic_teacher;?> Email ID" value="<?php if(isset($_POST['t_email'])) { echo $_POST['t_email']; }?>">
</div>
</div>
</td>

<td><?php echo "&nbsp"  ?></td>

<td>
<div class=''>
<div class="form-group has-success">
<label>Enter <?php echo $dynamic_teacher; ?> Phone No.</label>
<input  class="form-control"  type="text" name="t_phone" placeholder="<?php echo $dynamic_teacher;?> Phone No." value="<?php if(isset($_POST['t_phone'])) { echo $_POST['t_phone']; }?>">
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
$t_id = trim($_POST['t_id']);
$t_dept = trim($_POST['t_dept']);
$t_email = trim($_POST['t_email']);
$t_phone = trim($_POST['t_phone']);




$query="SELECT t_complete_name,t_id,t_dept,t_email,t_phone from tbl_teacher";
$query1=" where ";

if($_POST['name']==''  &  $_POST['t_id']=='' & $_POST['t_dept']=='' & $_POST['t_email']=='' & $_POST['t_phone']=='')
	{
		echo "<script>window.alert('please enter a field')</script>";
		echo "<script>window.location.assign('teacher_search_engine.php')</script>";
	}
else
{
	$f = 0;
	if($name!='')
		{
			$query1.="t_complete_name like '%$name%'";
			$f = 1;
		}
	if($t_id!='')
		{
			if($f==1)
				{
					$query1.= ' and ';
				}
			$query1.="t_id like '%$t_id%'";
			$f = 1;
		}
	if($t_dept!='')
		{
			if($f==1)
				{
					$query1.= ' and ';
				}
			$query1.="t_dept  like '%$t_dept%'";
			$f = 1;
		}
	
	if($t_email!='')
		{
			if($f==1)
				{
					$query1.= ' and ';
				}
			$query1.="t_email like '%$t_email%'";
			$f = 1;
		}
		if($t_phone!='')
		{
			if($f==1)
				{
					$query1.= ' and ';
				}
			$query1.="t_phone like '%$t_phone%'";
			$f = 1;
		}
		
		
	$query_final=$query.$query1." and school_id='$sc_id'";
	//echo $query_final;
	$sql = mysql_query($query_final);
	
	
	
	if(mysql_num_rows($sql)>0)
		{
			?>
           
            
			<table id="example" class="display" cellspacing="0" width="100%" >
			
            <thead>
			<tr style="background-color:#909497;color: white;"><th align='center' >Sr.No</th>
			<th style="text-align:center"><?php echo $dynamic_teacher;?> Name</th>
			<th style="text-align:center"><?php echo $dynamic_teacher;?> ID</th>
			<th style="text-align:center"><?php echo $dynamic_teacher;?></th>
			<th style="text-align:center"><?php echo $dynamic_teacher;?> Email</th>
			<th style="text-align:center"><?php echo $dynamic_teacher;?> Phone</th>
			
			
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
			echo "<script>window.location.assign('teacher_search_engine.php')</script>";
		}
		

}
	

}


?>

</body>
</html>
<?php

?>

