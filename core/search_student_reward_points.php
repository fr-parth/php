<?php


include('scadmin_header.php');?>

<?php
$report="";
session_start();
 $sc_id = $_SESSION['school_id'];
/*$id=$_SESSION['id']; */
           $fields=array("id"=>$id);
		  /* $table="tbl_school_admin";  */
		   
		   $smartcookie=new smartcookie();
/*		   
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$sc_id=$result['school_id'];
*/

?>

<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"></link>
<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
	 $('#example').DataTable();
	/* $('#example tbody tr').click(function(){
        window.location = $(this).data('href');   
    });*/
} );
</script>
<style>

#example tbody tr{
cursor : pointer;

}
<!--

#row:hover{
	color:white;
	background-color:#428BCA;
	
}
-->
</style>
</head>
<body>
<div class="container">
<form method="post">
<table align="center" style="margin-top: 1cm;">
<tr>
<td>
<dic class='row'>
<div class='col-lg-12'>
<div class="form-group has-success">
<input class="form-control" type="text" name="name" placeholder="<?php echo $dynamic_student;?> Name" value="<?php if(isset($_POST['name'])) { echo $_POST['name']; }?>">
</div>
</div>
</td>
<td>
<div class='col-lg-12'>
<div class="form-group has-success">
<input class="form-control" type="number" name="Roll_no" min="0" placeholder="<?php echo $dynamic_emp;?>" value="<?php if(isset($_POST['Roll_no'])) { echo $_POST['Roll_no']; }?>">
</div>
</div>
</td>
<td>
<div class='col-lg-12'>
<div class="form-group has-success">
<input class="form-control" type="submit" value="GO" name="submit">
</div>
</div>
</td>
</tr>
</table>
</form>
</div>


<?php

if(isset($_POST['submit']))
{
$name = trim($_POST['name']);
$Roll_no = trim($_POST['Roll_no']);


$query="SELECT distinct a.std_PRN, a.school_id,a.id,a.std_complete_name, b.sc_total_point,b.school_id
FROM tbl_student AS a
JOIN tbl_student_reward AS b ON a.std_PRN = b.sc_stud_id";
$query1=" where ";

if($_POST['name']==''  &  $_POST['Roll_no']=='')
	{
		echo "<script>window.alert('please enter a field')</script>";
		echo "<script>window.location.assign('search_student_reward_points.php')</script>";
	}
else
{
	$f = 0;
	if($name!='')
		{
			$query1.="a.std_complete_name like '%$name%'";
			$f = 1;
		}
	if($Roll_no!='')
		{
			if($f==1)
				{
					$query1.= ' and ';
				}
				//like clause removed and = added by Pranali for SMC-3374 on 21-9-19
			$query1.="a.std_PRN='$Roll_no'";
			$f = 1;
		}

	//'order by b.id desc limit 1' added in below query (to overcome issue of multiple records of same student are displayed) and below if condition added by Pranali for SMC-3374 on 21-9-19
	$query_final=$query.$query1." and a.school_id='$sc_id' and b.school_id='$sc_id' order by b.id desc limit 1";
	$sql = mysql_query($query_final);
	
	if(mysql_num_rows($sql)==0)
	{
		$sql = mysql_query("SELECT school_id,std_complete_name,std_PRN
		FROM tbl_student WHERE school_id='$sc_id' AND std_PRN='$Roll_no'");
		$cnt = mysql_num_rows($sql);
	}

	
	?>
			<table id="example" class="display" cellspacing="0" width="100%">
			<thead>
			<tr style="background-color:#909497;color: white;">
			<th style="text-align:center">Sr.No</th>
			<th style="text-align:center"><?php echo $dynamic_student;?> Name</th>
			<th style="text-align:center"><?php echo $dynamic_emp;?></th>
			<th style="text-align:center">Balanced Green Points</th>
			<th style="text-align:center">Assign</th>
			</thead>
			<tbody>
			
	<?php	
			 $c = 1;
			while($rows = mysql_fetch_array($sql))
				{?>
       
            <tr> 
            <td style="padding:10px;" align="center"><?php echo $c;?></td>
            <td style="padding:10px;" align="center"><?php echo $rows['std_complete_name'];?></td>
              <td style="padding:10px;" align="center"><?php echo $rows['std_PRN'];?></td>
                <td style="padding:10px;" align="center"><?php if($rows['sc_total_point']==""){ echo "0";}else { echo $rows['sc_total_point'];  }?></td>
				<td> <a href='studassigngreenpoints_search.php?std_id=<?php echo $rows["std_PRN"];?>&sc_id=<?php echo $rows["school_id"];?> '><input type="button" value="Assign" name="assign"/></a>
                   </td>                 
            </tr>
            
     <?php $c++; }?>
        </tbody>
    </table>
	<?php 
		
	/*else
		{
			echo "<script>window.alert('No records found')</script>";
			echo "<script>window.location.assign('search_student_reward_points.php')</script>";
		}
	*/	

}
	

}

?>
</body>
</html>