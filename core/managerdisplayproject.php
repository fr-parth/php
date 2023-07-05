 <?php
 
include('hr_header.php');
?>

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
<form method="post">
<table align="center" style="margin-top: 1cm;">
<tr>
<td>
<dic class='row'>
<div class=''>
<div class="form-group has-success">
<input   class="form-control"  type="text" name="name" placeholder="Manager Name" value="<?php if(isset($_POST['name'])) { echo $_POST['name']; }?>">
</div>
</div>
</td>
<td><?php echo "&nbsp"  ?></td>
<td>
<div class=''>
<div class="form-group has-success">
<input   class="form-control"  type="text" name="tid" placeholder="Manager Id" value="<?php if(isset($_POST['tid'])) { echo $_POST['tid']; }?>">
</div>
</div>
</td>
<td><?php echo "&nbsp"  ?></td>
<td>
<div class=''>
<div class="form-group has-success">

<input  class="form-control"  type="text" name="subtitle" placeholder="Project Name" value="<?php if(isset($_POST['subtitle'])) { echo $_POST['subtitle']; }?>">
</div>
</div>
</td>
<td><?php echo "&nbsp"  ?></td>
</tr>
<tr>
<td>
<div class=''>
<div class="form-group has-success">
<input  class="form-control"  type="text" name="subcode" placeholder="Project Code" value="<?php if(isset($_POST['subcode'])) { echo $_POST['subcode']; }?>">
</div>
</div>
</td>
<td><?php echo "&nbsp"  ?></td>
<td>
<div class=''>
<div class="form-group has-success">
<input  class="form-control"  type="text" name="acadamicyear" placeholder="Acadamic Year" value="<?php if(isset($_POST['acayear'])) { echo $_POST['acayear']; }?>">
</div>
</div>
</td>
<td><?php echo "&nbsp"  ?></td>
<td>
<div class=''>
<div class="form-group has-success">
<input  class="form-control"  type="submit" value="go" name="submit">
</div>
</div>
</td>
</table>
</form>
</div>


<!--

<form method="post" >
<input type="text" name="name" placeholder="Teacher Name" value="<?php if(isset($_POST['name'])) { echo $_POST['name']; }?>">
<input type="text" name="tid" placeholder="Teacher Id" value="<?php if(isset($_POST['tid'])) { echo $_POST['tid']; }?>">
<input type="text" name="subtitle" placeholder="Subject Name" value="<?php if(isset($_POST['subtitle'])) { echo $_POST['subtitle']; }?>">
<input type="text" name="subcode" placeholder="Subject Code" value="<?php if(isset($_POST['subcode'])) { echo $_POST['subcode']; }?>">
<input type="text" name="branch" placeholder="Branch" value="<?php if(isset($_POST['branch'])) { echo $_POST['branch']; }?>">
<input type="text" name="semesterid" placeholder="Semester Id" value="<?php if(isset($_POST['semesterid'])) { echo $_POST['semesterid']; }?>">
<input type="text" name="acadamicyear" placeholder="Acadamic Year" value="<?php if(isset($_POST['acadamicyear'])) { echo $_POST['acadamicyear']; }?>">
<input type="submit" value="go" name="submit">
</form>
-->


<?php
if(isset($_POST['submit']))
{
$name = trim($_POST['name']);
$tid = trim($_POST['tid']);
$subtitle = trim($_POST['subtitle']);
$subcode = trim ($_POST['subcode']);
$branch = trim($_POST['branch']);
$semesterid = trim($_POST['semesterid']);
$acadamicyear = trim($_POST['acadamicyear']);


$conn = mysql_connect("localhost","root","");
$db = mysql_select_db("smartcookie");
$query="select a.t_complete_name,a.t_id,b.subjectname,b.`subjcet_code`,b.`Branches_id`,b.Semester_id,b.AcademicYear from tbl_teacher as a inner join tbl_teacher_subject_master as b on a.t_id = b.teacher_id ";
$query1=" where ";

if($name=='' & $tid=='' & $subtitle=='' & $subcode=='' & $branch=='' & $semesterid=='' & $acadamicyear=='' )
	{
		echo "<script>window.alert('please enter a field')</script>";
		echo "<script>window.location.assign('teacherdisplaysub.php')</script>";
	}
else
{
	$f = 0;
	if($name!='')
		{
			$query1.="a.t_complete_name like '%$name%'";
			$f = 1;
		}
	if($tid!='')
		{
			if($f==1)
				{
					$query1.= ' and ';
				}
			$query1.="a.t_id like '%$tid%'";
			$f=1;
		}
	if($subtitle!='')
		{
			if($f==1)
				{
					$query1.= ' and ';
				}
			$query1.="b.subjectname like '%$subtitle%'";
			$f=1;
		}
	if($subcode!='')
		{
			if($f==1)
				{
					$query1.= ' and ';
				}
			$query1.="b.subjcet_code like '%$subcode%'";
			$f=1;
		}
	if($branch!='')
		{
			if($f==1)
				{
					$query1.= ' and ';
				}
			$query1.="b.Branches_id like '%$branch%'";
			$f=1;
		}
	if($semesterid!='')
		{
			if($f==1)
				{
					$query1.= ' and ';
				}
			$query1.="b.Semester_id like '$semesterid'";
			$f=1;
		}
	if($acadamicyear!='')
		{
			if($f==1)
				{
					$query1.= ' and ';
				}
			$query1.="b.AcademicYear like '%$acadamicyear%'";
			$f=1;
		}
	
	$query_final=$query.$query1." and b.school_id = '$sc_id' ";
	
	$sql = mysql_query($query_final);
	


	if(mysql_num_rows($sql)>0)
		{
	
	?>
			<table id="example" class="display" cellspacing="0" width="100%" >
			<thead>
			<tr style="background-color:#909497;color: white;">
			<th style="text-align:center">Sr.No</th>
			<th style="text-align:center">Manager Name</th>
			<th style="text-align:center">Manager Id</th>
			<th style="text-align:center">Project Name</th>
			<th style="text-align:center">Project Code</th>
			<th style="text-align:center">Academic Year</th>
			</tr>
			</thead>
			<tbody>
			
	<?php
			$c = 1;
			while($rows = mysql_fetch_array($sql,MYSQLI_NUM))
				{
					echo "<tr>";
					
					echo "<td>$c</td>";
				
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
			echo "<script>window.location.assign('teacherdisplaysub.php')</script>";
		}
		
}
}


?>

</body>
</html>
<?php


?>
