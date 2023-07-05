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

<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"></link>
<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
	 $('#example').DataTable();
	 $('#example tbody tr').click(function(){
        window.location = $(this).data('href');   
    });
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
<input class="form-control" type="text" name="name" placeholder="Employee Name" value="<?php if(isset($_POST['name'])) { echo $_POST['name']; }?>">
</div>
</div>
</td>
<td>
<div class='col-lg-12'>
<div class="form-group has-success">
<input class="form-control" type="text" name="Student_PRN" placeholder="Employee PRN" value="<?php if(isset($_POST['Roll_no'])) { echo $_POST['Roll_no']; }?>">
</div>
</div>
</td>
<td>
<div class='col-lg-12'>
<div class="form-group has-success">
<input class="form-control" type="submit" value="go" name="submit">
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


$query="SELECT a.school_id,a.std_PRN,a.id,a.std_complete_name,b.sc_reward
FROM tbl_student AS a
left JOIN tbl_student_reward AS b ON a.std_PRN = b.sc_stud_id";
$query1=" where ";

if($_POST['name']==''  &  $_POST['Roll_no']=='' )
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
			$query1.="a.std_PRN like '%$Roll_no%'";
			$f = 1;
		}

	
	$query_final=$query.$query1." and a.school_id='$sc_id'";
	$sql = mysql_query($query_final);
	
	
	
	if(mysql_num_rows($sql)>0)
		{
	
	?>
			<table id="example" class="display" cellspacing="0" width="100%">
			<thead>
			<tr style="background-color:#909497;color: white;">
			<th style="text-align:center">Sr.No</th>
			<th style="text-align:center">Employee Name</th>
			<th style="text-align:center">Employee PRN</th>
			<th style="text-align:center">Balanced Green Points</th>
			</thead>
			<tbody>
			
	<?php	
			 $c = 1;
			while($rows = mysql_fetch_array($sql))
				{?>
       
            <tr  data-href='studassigngreenpoints_search.php?std_id=<?php echo $rows["std_PRN"];?>&sc_id=<?php echo $rows["school_id"];?> '>
            <td style="padding:10px;" align="center"><?php echo $c;?></td>
            <td style="padding:10px;" align="center"><?php echo $rows['std_complete_name'];?></td>
              <td style="padding:10px;" align="center"><?php echo $rows['std_PRN'];?></td>
                <td style="padding:10px;" align="center"><?php if($ows['sc_reward']==""){ echo "0";}else { echo $rows['sc_reward'];  }?></td>

                                    
            </tr>
            
     <?php $c++; }?>
        </tbody>
    </table>
	<?php }
		
	else
		{
			echo "<script>window.alert('No records found')</script>";
			echo "<script>window.location.assign('search_student_reward_points.php')</script>";
		}
		

}
	

}

?>
</body>
</html>


<?php

?>

